<?php
/**
 * Catalog export for Visual Product Recognition Service.
 *
 * GET ?key=API_KEY              → serves pre-generated catalog.json
 * GET ?key=API_KEY&generate=1   → regenerates catalog.json and serves it
 *
 * Flow: Bitrix "Произвольный PHP-скрипт" calls ?generate=1 nightly.
 *       Sync Worker calls without &generate to get instant static response.
 */

define('API_KEY', '781a1629e59a0ceecdbcfd602a5af92fe2938a4ae2328bbe1109b8bc1e392ca4');
define('SITE_DOMAIN', 'https://stimma.ua');
define('IBLOCK_ID', 21);
define('MAX_IMAGES_PER_PRODUCT', 10);
define('OUTPUT_FILE', dirname(__FILE__) . '/catalog.json');

if (empty($_GET['key']) || $_GET['key'] !== API_KEY) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid API key']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

// --- Serve mode: return pre-generated file ---
if (empty($_GET['generate'])) {
    if (file_exists(OUTPUT_FILE)) {
        readfile(OUTPUT_FILE);
    } else {
        http_response_code(503);
        echo json_encode(['error' => 'Catalog not generated yet. Call with &generate=1 first.']);
    }
    exit;
}

// --- Generate mode: build catalog.json ---
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
Loader::includeModule('iblock');
Loader::includeModule('catalog');
Loader::includeModule('sale');

set_time_limit(600);
ini_set('memory_limit', '512M');

function isSizeProp($code) {
    return in_array(strtoupper($code), ['RAZMER', 'SIZE', 'SIZES']);
}

function isColorProp($code) {
    return in_array(strtoupper($code), ['TSVET', 'COLOR', 'CVET']);
}

function isImageFile($path) {
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
}

$rsProducts = CIBlockElement::GetList(
    ['ID' => 'ASC'],
    ['IBLOCK_ID' => IBLOCK_ID, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'],
    false,
    false,
    ['ID', 'NAME', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID', 'ACTIVE']
);

$rawProducts = [];

while ($item = $rsProducts->GetNextElement()) {
    $fields = $item->GetFields();
    $props = $item->GetProperties();

    $productId = 'prd_' . $fields['ID'];

    // Images
    $images = [];
    if (!empty($fields['DETAIL_PICTURE'])) {
        $file = CFile::GetFileArray($fields['DETAIL_PICTURE']);
        if ($file && isImageFile($file['SRC'])) $images[] = ['url' => SITE_DOMAIN . $file['SRC'], 'is_primary' => true];
    }

    if (!empty($props['PHOTO_GALLERY']['VALUE'])) {
        foreach ((array)$props['PHOTO_GALLERY']['VALUE'] as $fileId) {
            if (count($images) >= MAX_IMAGES_PER_PRODUCT) break;
            $file = CFile::GetFileArray($fileId);
            if ($file && isImageFile($file['SRC'])) {
                $url = SITE_DOMAIN . $file['SRC'];
                $exists = false;
                foreach ($images as $img) { if ($img['url'] === $url) { $exists = true; break; } }
                if (!$exists) $images[] = ['url' => $url, 'is_primary' => false];
            }
        }
    }

    // Brand, SKU
    $brand = '';
    if (!empty($props['BRAND']['VALUE'])) {
        $brand = is_array($props['BRAND']['VALUE']) ? $props['BRAND']['VALUE'][0] : $props['BRAND']['VALUE'];
    }

    // SKU: use "Model" property (product-level, same across all sizes)
    $sku = '';
    if (!empty($props['MODEL']['VALUE'])) $sku = $props['MODEL']['VALUE'];

    // Offers: availability, price, sizes, colors, images
    $hasAvailableOffer = false;
    $minPrice = null;
    $salePrice = null;
    $sizes = [];
    $colors = [];

    $rsOffers = CCatalogSKU::getOffersList($fields['ID'], IBLOCK_ID, [], ['ID'], ['ACTIVE' => 'Y']);

    if (!empty($rsOffers[$fields['ID']])) {
        foreach ($rsOffers[$fields['ID']] as $offer) {
            $offerId = $offer['ID'];

            // Check availability: QUANTITY > 0 AND price > 0 (same logic as stimma_ai_agent)
            $productInfo = CCatalogProduct::GetByID($offerId);
            $optimalPrice = CCatalogProduct::GetOptimalPrice($offerId, 1, [], 'N');
            $price = $optimalPrice ? $optimalPrice['RESULT_PRICE']['BASE_PRICE'] : 0;
            $available = ($productInfo && $productInfo['QUANTITY'] > 0 && $price > 0);

            if (!$available) continue; // Skip unavailable offers

            $hasAvailableOffer = true;

            if ($optimalPrice) {
                $discount = $optimalPrice['RESULT_PRICE']['DISCOUNT_PRICE'];
                if ($minPrice === null || $price < $minPrice) $minPrice = $price;
                if ($discount < $price && ($salePrice === null || $discount < $salePrice)) $salePrice = $discount;
            }

            $offerElement = CIBlockElement::GetByID($offerId)->GetNextElement();
            if ($offerElement) {
                $offerFields = $offerElement->GetFields();
                $offerProps = $offerElement->GetProperties();

                foreach ($offerProps as $code => $prop) {
                    $val = is_array($prop['VALUE']) ? implode(', ', $prop['VALUE']) : $prop['VALUE'];
                    if (empty($val)) continue;
                    if (isSizeProp($code)) $sizes[] = $val;
                    if (isColorProp($code)) $colors[] = $val;
                }

                if (count($images) < MAX_IMAGES_PER_PRODUCT && !empty($offerFields['DETAIL_PICTURE'])) {
                    $file = CFile::GetFileArray($offerFields['DETAIL_PICTURE']);
                    if ($file && isImageFile($file['SRC'])) {
                        $url = SITE_DOMAIN . $file['SRC'];
                        $exists = false;
                        foreach ($images as $img) { if ($img['url'] === $url) { $exists = true; break; } }
                        if (!$exists) $images[] = ['url' => $url, 'is_primary' => false];
                    }
                }
            }
        }
    }

    if (!empty($images) && !$images[0]['is_primary']) $images[0]['is_primary'] = true;

    $rawProducts[] = [
        'product_id' => $productId,
        'external_id' => $fields['ID'],
        'sku' => $sku ?: ('SKU-' . $fields['ID']),
        'title' => !empty($props['NAME_UA']['VALUE']) ? $props['NAME_UA']['VALUE'] : $fields['NAME'],
        'brand' => $brand ?: 'Stimma',
        'category_id' => 'cat_' . ($fields['IBLOCK_SECTION_ID'] ?: '0'),
        'url' => !empty($fields['DETAIL_PAGE_URL']) ? SITE_DOMAIN . $fields['DETAIL_PAGE_URL'] : '',
        'price' => $minPrice,
        'sale_price' => ($salePrice && $salePrice < $minPrice) ? $salePrice : null,
        'sizes' => array_values(array_unique($sizes)),
        'colors' => array_values(array_unique($colors)),
        'active' => true,
        'in_stock' => $hasAvailableOffer,
        'images' => $images,
    ];
}

// Filter: include all active products that have at least one image, regardless
// of stock. Out-of-stock items keep their visual identity in the catalog so
// search can answer "this exists but is currently unavailable, here are
// alternatives" instead of "not found". in_stock stays as computed above and
// is exposed to the bot for the customer-facing message.
$result = array_values(array_filter($rawProducts, function($p) {
    return !empty($p['images']);
}));

$json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents(OUTPUT_FILE, $json);

// Upload to R2 via sync-worker endpoint
$r2Url = 'https://stimma-sync.grow2ai.workers.dev/catalog';
$r2Key = 'sk_4bbf2ab293534b70f88261296cc8267cffff53c564cfa552';

$ch = curl_init($r2Url);
curl_setopt_array($ch, [
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => $json,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'api-key: ' . $r2Key,
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
]);
$r2Response = curl_exec($ch);
$r2Status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo json_encode([
    'status' => 'generated',
    'products' => count($result),
    'images' => array_sum(array_map(function($p) { return count($p['images']); }, $result)),
    'file_size' => strlen($json),
    'r2_upload' => $r2Status == 200 ? 'ok' : 'failed (' . $r2Status . ')',
    'generated_at' => date('c'),
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
