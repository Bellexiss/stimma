<?php
// scripts/bitrix_export_products.php
// Разместите этот файл в /local/api/export_products.php

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);
define('BX_WITH_ON_AFTER_EPILOG', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// PHP script executes ~35s due to N+1 queries (CPrice::GetList, CCatalogProduct::GetByID per offer).
// Default max_execution_time=30 causes random truncation (3-15% product loss).
set_time_limit(300);
ini_set('memory_limit', '512M');

// 2. Конфигурация
$API_KEY = "781a1629e59a0ceecdbcfd602a5af92fe2938a4ae2328bbe1109b8bc1e392ca4"; 
$IBLOCK_ID = 21; // ЗАМЕНИТЕ НА ID ВАШЕГО ИНФОБЛОКА ТОВАРОВ
$PRICE_TYPE_ID = 1; // ID типа базовой цены
$DISCOUNT_PRICE_TYPE_ID = 2; // ID типа цены со скидкой (DISCOUNT)

// 3. Проверка доступа
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$key = $request->getQuery("key");
$type = $request->getQuery("type"); // type=raw для отримання всіх полів

if ($key !== $API_KEY) {
    header('HTTP/1.0 403 Forbidden');
    echo json_encode(['error' => 'Access denied']);
    die();
}

header('Content-Type: application/json');

// COUNT MODE: Fast count without heavy queries (for pre-flight validation)
if ($type === 'count') {
    if (!\Bitrix\Main\Loader::includeModule('iblock')) {
        echo json_encode(['error' => 'iblock module not loaded']);
        die();
    }
    $arFilter = Array(
        "IBLOCK_ID" => $IBLOCK_ID,
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y"
    );
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array("ID"));
    $count = 0;
    while ($res->GetNextElement()) { $count++; }
    echo json_encode(['count' => $count, 'type' => 'count']);
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
    die();
}

// RAW MODE: Повертає всі поля без обробки (для дебагу)
$RAW_MODE = ($type === 'raw');

if (!\Bitrix\Main\Loader::includeModule('iblock') || !\Bitrix\Main\Loader::includeModule('catalog') || !\Bitrix\Main\Loader::includeModule('highloadblock')) {
    echo json_encode(['error' => 'Modules not loaded']);
    die();
}

// COLORS DIAGNOSTIC: ?type=colors — дамп довідника кольорів (HL-блок 5) як є.
// Тимчасовий режим для перевірки структури/полів (UF_NAME_UA + коди RU-назви
// та XML_ID/коду). Прибрати після налаштування резолву color_ua.
if ($type === 'colors') {
    $hlbColorId = (int)($request->getQuery("hlb") ?: 5);
    $hlbColor = \Bitrix\Highloadblock\HighloadBlockTable::getById($hlbColorId)->fetch();
    if (!$hlbColor) {
        echo json_encode(['error' => "HL block $hlbColorId not found"]);
        die();
    }
    $colorEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlbColor);
    $colorDataClass = $colorEntity->getDataClass();
    $rsColors = $colorDataClass::getList(array("select" => array("*")));
    $rows = [];
    while ($arColor = $rsColors->fetch()) {
        $rows[] = $arColor;
    }
    echo json_encode([
        '_hlb_id' => $hlbColorId,
        '_table'  => $hlbColor['TABLE_NAME'],
        '_count'  => count($rows),
        '_fields' => !empty($rows) ? array_keys($rows[0]) : [],
        'rows'    => $rows,
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
    die();
}

// Helper function to process property values
function formatPropValue($value) {
    if (is_array($value)) {
        return implode(', ', array_filter($value));
    }
    return (string)$value;
}

// Helper to check if property is likely size or color
function isSizeProp($code) {
    // Исключаем RAZMERNOST (Размерность)
    return preg_match('/(SIZE|RAZMER|OFFER_SIZE)/i', $code) && !preg_match('/RAZMERNOST/i', $code);
}
function isColorProp($code) {
    // Исключаем COLOR_REF (справочник цветов)
    return preg_match('/(COLOR|CVET|COLOUR)/i', $code) && !preg_match('/COLOR_REF/i', $code);
}

/**
 * Extract Ukrainian value from "RU*UA" format
 * Falls back to original if no separator found
 */
function extractUkrainian($value) {
    if (empty($value)) return '';
    if (strpos($value, '*') !== false) {
        $parts = explode('*', $value);
        // Take the last non-empty part (Ukrainian)
        for ($i = count($parts) - 1; $i >= 0; $i--) {
            $part = trim($parts[$i]);
            if (!empty($part)) return $part;
        }
    }
    return $value;
}

/**
 * Get Ukrainian field with fallback
 * Tries UA field first, then RU field, then default
 */
function getUaWithFallback($uaValue, $ruValue, $default = '') {
    if (!empty($uaValue)) return $uaValue;
    if (!empty($ruValue)) return $ruValue;
    return $default;
}

/**
 * VID (тип товару) Russian to Ukrainian mapping
 */
function getVidUa($vid) {
    if (empty($vid)) return '';

    $map = [
        // Основні типи
        'Термобелье' => 'Термобілизна',
        'Платье' => 'Сукня',
        'Блуза' => 'Блуза',
        'Юбка' => 'Спідниця',
        'Брюки' => 'Штани',
        'Джинсы' => 'Джинси',
        'Футболка' => 'Футболка',
        'Куртка' => 'Куртка',
        'Пальто' => 'Пальто',
        'Кардиган' => 'Кардиган',
        'Свитер' => 'Светр',
        'Жилет' => 'Жилет',
        'Комбинезон' => 'Комбінезон',
        'Костюм' => 'Костюм',
        'Шорты' => 'Шорти',
        'Топ' => 'Топ',
        'Боди' => 'Боді',
        'Сарафан' => 'Сарафан',
        'Туника' => 'Туніка',
        'Рубашка' => 'Сорочка',
        'Плащ' => 'Плащ',
        'Свитшот' => 'Світшот',
        'Худи' => 'Худі',
        'Лонгслив' => 'Лонгслів',
        'Жакет' => 'Жакет',
        'Пиджак' => 'Піджак',
        'Леггинсы' => 'Легінси',
        'Тренч' => 'Тренч',
        // Додаткові типи
        'Джинсовые бермуды' => 'Джинсові бермуди',
        'Джинсовые шорты' => 'Джинсові шорти',
        'Спортивные штаны' => 'Спортивні штани',
        'Спортивный костюм' => 'Спортивний костюм',
        'Юбка-шорты' => 'Спідниця-шорти',
        'Ветровка' => 'Вітровка',
        'Бермуды' => 'Бермуди',
        'Кроссовки' => 'Кросівки',
        'Босоножки' => 'Босоніжки',
        'Сандалии' => 'Сандалі',
        'Сапоги' => 'Чоботи',
        'Лоферы' => 'Лофери',
        'Мюли' => 'Мюлі',
        'Угги' => 'Уги',
        'Серьги' => 'Сережки',
        'Подвеска' => 'Підвіска',
        'Браслет' => 'Браслет',
        'Ремень' => 'Ремінь',
        'Сумка' => 'Сумка',
        'Косметичка' => 'Косметичка',
        'Носки' => 'Шкарпетки',
        'Следы' => 'Сліди',
        'Майка' => 'Майка',
        'Манишка' => 'Манішка',
        'Купальник' => 'Купальник',
        'Кимоно' => 'Кімоно',
        'Кейп' => 'Кейп',
        'Бомбер' => 'Бомбер',
        'Полупальто' => 'Напівпальто',
        'Джемпер' => 'Джемпер',
        'Джемпер-поло' => 'Джемпер-поло',
        'Джогеры' => 'Джогери',
        'Пижамные брюки' => 'Піжамні штани',
        'Комплект пижамный' => 'Комплект піжамний',
        'Комплект' => 'Комплект',
        'Блейзер' => 'Блейзер',
        'Блейзер-Пальто' => 'Блейзер-Пальто',
        'Кроп-жакет' => 'Кроп-жакет',
        'Кроп-топ' => 'Кроп-топ',
        'Топ-корсет' => 'Топ-корсет',
        'Жилет-корсет' => 'Жилет-корсет',
        'Худи-зип' => 'Худі-зіп',
        'Хустка' => 'Хустка',
        // Аксесуари та декор
        'Ваза' => 'Ваза',
        'Свеча' => 'Свічка',
        'Подставка' => 'Підставка',
        'Эко-бутылка' => 'Еко-пляшка',
        'Арома-набор' => 'Арома-набір',
        'Набор украшений' => 'Набір прикрас',
        'Набор аксессуаров для причесок' => 'Набір аксесуарів для зачісок',
        'Набор бальзамов для губ' => 'Набір бальзамів для губ',
        'Набор кремов для рук' => 'Набір кремів для рук',
    ];

    if (isset($map[$vid])) {
        return $map[$vid];
    }

    // Fallback: return original
    return $vid;
}

/**
 * PRINT (принт) Russian to Ukrainian mapping
 */
function getPrintUa($print) {
    if (empty($print)) return '';

    $map = [
        'Без принта (однотонный)' => 'Без принту (однотонний)',
        'Без принта' => 'Без принту',
        'Однотонный' => 'Однотонний',
        'Надписи' => 'Написи',
        'Абстракция' => 'Абстракція',
        'Геометрия' => 'Геометрія',
        'Полоска' => 'Смужка',
        'Клетка' => 'Клітинка',
        'Горох' => 'Горох',
        'Цветы' => 'Квіти',
        'Цветочный' => 'Квітковий',
        'Животные' => 'Тварини',
        'Анималистичный' => 'Анімалістичний',
        'Леопард' => 'Леопард',
        'Зебра' => 'Зебра',
        'Камуфляж' => 'Камуфляж',
        'Орнамент' => 'Орнамент',
        'Узор' => 'Візерунок',
        'Логотип' => 'Логотип',
        'Рисунок' => 'Малюнок',
        'Вышивка' => 'Вишивка',
        'Аппликация' => 'Аплікація',
        'Пайетки' => 'Паєтки',
        'Стразы' => 'Стрази',
        'Принт' => 'Принт',
    ];

    // Try direct match
    if (isset($map[$print])) {
        return $map[$print];
    }

    // Handle comma-separated values
    if (strpos($print, ',') !== false) {
        $parts = explode(',', $print);
        $translated = [];
        foreach ($parts as $part) {
            $trimmed = trim($part);
            $translated[] = isset($map[$trimmed]) ? $map[$trimmed] : $trimmed;
        }
        return implode(', ', $translated);
    }

    return $print;
}

function translitToCyrillic($string) {
    $table = array(
        'shch' => 'щ', 'sch' => 'щ', 'yo' => 'ё', 'zh' => 'ж', 'ch' => 'ч', 'sh' => 'ш', 
        'yu' => 'ю', 'ya' => 'я', 'kh' => 'х', 'ts' => 'ц',
        'a' => 'а', 'b' => 'б', 'v' => 'в', 'g' => 'г', 'd' => 'д', 'e' => 'е', 'z' => 'з', 
        'i' => 'и', 'j' => 'й', 'k' => 'к', 'l' => 'л', 'm' => 'м', 'n' => 'н', 'o' => 'о', 
        'p' => 'п', 'r' => 'р', 's' => 'с', 't' => 'т', 'u' => 'у', 'f' => 'ф', 'y' => 'ы', 
        "'" => 'ь', '_' => ' ', '-' => '-'
    );
    // Handle specific endings first
    $string = str_replace(['yy', 'iy'], ['ый', 'ий'], $string);
    return strtr($string, $table);
}

function getColorUa($code) {
    $code = strtolower($code);
    $map = [
        'chernyy' => 'Чорний',
        'belyy' => 'Білий',
        'krasnyy' => 'Червоний',
        'siniy' => 'Синій',
        'zelenyy' => 'Зелений',
        'zheltyy' => 'Жовтий',
        'oranzhevyy' => 'Помаранчевий',
        'fioletovyy' => 'Фіолетовий',
        'rozovyy' => 'Рожевий',
        'goluboy' => 'Блакитний',
        'bezhevyy' => 'Бежевий',
        'korichnevyy' => 'Коричневий',
        'seryy' => 'Сірий',
        'molochniy' => 'Молочний',
        'molochnyy' => 'Молочний',
        'haki' => 'Хакі',
        'temno-siniy' => 'Темно-синій',
        'svetlo-seryy' => 'Світло-сірий',
        'temno-seryy' => 'Темно-сірий',
        'bordovyy' => 'Бордовий',
        'biryuzovyy' => 'Бірюзовий',
        'myatnyy' => 'М\'ятний',
        'persikovyy' => 'Персиковий',
        'sirenevyy' => 'Бузковий',
        'pesochnyy' => 'Пісочний',
        'gorchichnyy' => 'Гірчичний',
        'olivkovyy' => 'Оливковий',
        'koral' => 'Кораловий',
        'kremovyy' => 'Кремовий',
        'pudrovyy' => 'Пудровий',
        'elektrik' => 'Електрик',
        'kapuchino' => 'Капучино',
        'kakao' => 'Какао',
        'terrakotovyy' => 'Теракотовий',
        'vishnevyy' => 'Вишневий',
        'izumrudnyy' => 'Смарагдовий',
        'tsvetochnyy' => 'Квітковий',
        'geometriya' => 'Геометрія',
        'poloska' => 'Смужка',
        'kletka' => 'Клітинка',
        'gorokh' => 'Горох',
        'abstraktsiya' => 'Абстракція',
        'animalisticheskiy' => 'Анімалістичний',
        'kamuflyazh' => 'Камуфляж',
        'ornament' => 'Орнамент',
        'uzor' => 'Візерунок',
        'nadpis' => 'Напис',
        'logotip' => 'Логотип',
        'risunok' => 'Малюнок',
        'vyshivka' => 'Вишивка',
        'applikatsiya' => 'Аплікація',
        'payetki' => 'Паєтки',
        'strazy' => 'Стрази',
        'biser' => 'Бісер',
        'zhemchug' => 'Перли',
        'kruzhevo' => 'Мереживо',
        'setka' => 'Сітка',
        'prozrachnyy' => 'Прозорий',
        'multikolor' => 'Мультиколор',
        'raznotsvetnyy' => 'Різнокольоровий',
        'serebristyy' => 'Сріблястий',
        'zolotistyy' => 'Золотистий',
        'bronzovyy' => 'Бронзовий',
        'metallik' => 'Металік',
        'neon' => 'Неон',
        'pastel' => 'Пастель',
        'yarkiy' => 'Яскравий',
        'temnyy' => 'Темний',
        'svetlyy' => 'Світлий',
        'matovyy' => 'Матовий',
        'glyantsevyy' => 'Глянцевий',
        'perlamutrovyy' => 'Перламутровий',
        'ekryu' => 'Екрю',
        'taup' => 'Тауп',
    ];
    
    if (isset($map[$code])) {
        return $map[$code];
    }
    
    // Fallback: reverse translit
    return ucfirst(translitToCyrillic($code));
}

function formatMeasurements($serializedData) {
    if (empty($serializedData)) return "";
    
    // Data comes as serialized string
    $data = @unserialize($serializedData, ['allowed_classes' => false]);
    if (!$data || !is_array($data)) return "";

    // Row 0 contains sizes (headers)
    if (!isset($data[0]) || !is_array($data[0])) return "";
    
    $sizes = [];
    foreach ($data[0] as $idx => $val) {
        if (!empty($val)) {
            $sizes[$idx] = $val;
        }
    }
    
    if (empty($sizes)) return "";

    $result = [];
    
    // Iterate over sizes to group by size
    foreach ($sizes as $idx => $sizeName) {
        $sizeParams = [];
        // Iterate over rows (parameters) starting from 1
        for ($i = 1; $i < count($data); $i++) {
            if (isset($data[$i][0]) && !empty($data[$i][0]) && isset($data[$i][$idx]) && !empty($data[$i][$idx])) {
                $paramName = trim($data[$i][0]);
                $paramValue = trim($data[$i][$idx]);
                $sizeParams[] = "$paramName: $paramValue";
            }
        }
        
        if (!empty($sizeParams)) {
            $result[] = "Розмір $sizeName (" . implode(', ', $sizeParams) . ")";
        }
    }
    
    return implode('; ', $result);
}

$products = [];
$productIds = [];

// 4. Получение товаров
$arSelect = Array(
    "ID", 
    "NAME", 
    "IBLOCK_ID", 
    "IBLOCK_SECTION_ID",
    "PREVIEW_TEXT", 
    "DETAIL_TEXT", 
    "DETAIL_PAGE_URL",
    "DETAIL_PICTURE"
);

$arFilter = Array(
    "IBLOCK_ID" => $IBLOCK_ID, 
    "ACTIVE_DATE" => "Y", 
    "ACTIVE" => "Y"
);

$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

while($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $productId = $arFields['ID'];
    $productIds[] = $productId;

    // Получаем ВСЕ свойства товара
    $arProps = $ob->GetProperties();

    // Сбор картинок
    $images = [];
    $domain = 'https://stimma.com.ua'; // Замените на ваш домен если нужно

    if ($arFields['DETAIL_PICTURE']) {
        $path = CFile::GetPath($arFields['DETAIL_PICTURE']);
        if ($path) $images[] = $domain . $path;
    }

    // Дополнительные фото (PHOTO_GALLERY)
    // Используем GetProperty для надежного получения множественного свойства
    $dbMorePhoto = CIBlockElement::GetProperty($IBLOCK_ID, $productId, array("sort" => "asc"), Array("CODE"=>"PHOTO_GALLERY"));
    while ($arMorePhoto = $dbMorePhoto->Fetch()) {
        if (count($images) >= 4) break;
        $val = $arMorePhoto['VALUE'];
        if ($val) {
             $path = CFile::GetPath($val);
             if ($path) $images[] = $domain . $path;
        }
    }
    
    // Ограничиваем до 4х
    $images = array_slice(array_unique($images), 0, 4);

    $attributes = [];
    foreach ($arProps as $code => $prop) {
        // Списочные свойства с XML_ID (напр. SOON: "y" = "Скоро в наявності", передзамовлення)
        // VALUE содержит ID элемента enum, нам нужен VALUE_XML_ID
        if ($code === 'SOON') {
            $xmlId = isset($prop['VALUE_XML_ID']) ? trim((string)$prop['VALUE_XML_ID']) : '';
            if ($xmlId !== '') {
                $attributes['soon'] = $xmlId;
            }
            continue;
        }

        $val = formatPropValue($prop['VALUE']);
        if ($val !== '' && $prop['CODE'] !== 'MINIMUM_PRICE' && $prop['CODE'] !== 'MAXIMUM_PRICE' && $prop['CODE'] !== 'PHOTO_GALLERY') {
             // Используем название свойства как часть ключа или просто код в нижнем регистре
             // Для читаемости JSON используем код в нижнем регистре
             $key = strtolower($code);
             $attributes[$key] = $val;
        }
    }

    $products[$productId] = [
        'product_id' => md5($productId),
        'bitrix_id' => $productId,
        'base_name_ua' => $arFields['NAME'],
        'model' => $arFields['NAME'],
        'category_id' => $arFields['IBLOCK_SECTION_ID'],
        'url' => $domain . $arFields['DETAIL_PAGE_URL'],
        'images' => $images,
        'attributes' => $attributes,
        // 'variants' => [], // Убрали массив вариантов
        'available_sizes' => [],
        'available_colors' => [],
        'description_ua' => $arFields['DETAIL_TEXT'] ?: $arFields['PREVIEW_TEXT'],
        'text_content' => ''
    ];
}

// 4.5. Получение всех разделов товаров (для флагов is_new, is_sale, is_bestseller)
$productSections = [];
$specialSectionFlags = [
    350 => 'is_new',           // NEW
    352 => 'is_sale',          // SALE
    1288 => 'is_sale',         // LOVE SALE (объединяем с SALE)
    351 => 'is_bestseller',    // BESTSELLERS
];

if (!empty($productIds)) {
    // Получаем все разделы для всех товаров одним запросом
    $db_groups = CIBlockElement::GetElementGroups($productIds, true, ["ID", "IBLOCK_ELEMENT_ID"]);
    while ($group = $db_groups->Fetch()) {
        $elementId = $group["IBLOCK_ELEMENT_ID"];
        $sectionId = (int)$group["ID"];

        if (!isset($productSections[$elementId])) {
            $productSections[$elementId] = [
                'sections' => [],
                'is_new' => false,
                'is_sale' => false,
                'is_bestseller' => false,
            ];
        }

        $productSections[$elementId]['sections'][] = $sectionId;

        // Проверяем специальные категории
        if (isset($specialSectionFlags[$sectionId])) {
            $flag = $specialSectionFlags[$sectionId];
            $productSections[$elementId][$flag] = true;
        }
    }
}

// 5. Получение торговых предложений (SKU)
if (!empty($productIds)) {
    // Находим ID инфоблока предложений
    $arCatalog = CCatalog::GetByID($IBLOCK_ID);
    $offersIBlockID = $arCatalog['OFFERS_IBLOCK_ID'];

    if ($offersIBlockID) {
        $arOfferSelect = Array(
            "ID", "NAME", "IBLOCK_ID", "PROPERTY_CML2_LINK", "DETAIL_PICTURE"
        );
        // Мы не можем просто выбрать PROPERTY_*, поэтому будем использовать GetProperties внутри цикла или GetList с IBLOCK_ID
        // Для оптимизации выберем основные поля, а свойства получим через GetNextElement->GetProperties()
        
        $arOfferFilter = Array(
            "IBLOCK_ID" => $offersIBlockID,
            "PROPERTY_CML2_LINK" => $productIds,
            "ACTIVE" => "Y"
        );

        $rsOffers = CIBlockElement::GetList(
            Array("SORT"=>"ASC"), 
            $arOfferFilter, 
            false, 
            false, 
            $arOfferSelect
        );

        while($obOffer = $rsOffers->GetNextElement()) {
            $arOfferFields = $obOffer->GetFields();
            $offerId = $arOfferFields['ID'];
            
            // CML2_LINK - это ID родительского товара
            // Но в $arOfferFields он может быть не прямым значением, если мы не выбрали его явно в Select как свойство
            // GetProperties вернет его точно
            $arOfferProps = $obOffer->GetProperties();
            
            $parentId = $arOfferProps['CML2_LINK']['VALUE'];
            if (!$parentId || !isset($products[$parentId])) continue;

            // Получаем цену
            $dbPrice = CPrice::GetList(
                array(),
                array("PRODUCT_ID" => $offerId, "CATALOG_GROUP_ID" => $PRICE_TYPE_ID)
            );
            $price = 0;
            if ($arPrice = $dbPrice->Fetch()) {
                $price = $arPrice["PRICE"];
            }
            
            // Fallback: если цена не найдена по типу, пробуем найти любую цену
            if ($price <= 0) {
                 $dbPrice = CPrice::GetList(
                    array(),
                    array("PRODUCT_ID" => $offerId)
                );
                if ($arPrice = $dbPrice->Fetch()) {
                    $price = $arPrice["PRICE"];
                }
            }

            // Get sale price from DISCOUNT price type (ID=2)
            $salePrice = null;
            if ($DISCOUNT_PRICE_TYPE_ID) {
                $dbSalePrice = CPrice::GetList(
                    array(),
                    array("PRODUCT_ID" => $offerId, "CATALOG_GROUP_ID" => $DISCOUNT_PRICE_TYPE_ID)
                );
                if ($arSalePrice = $dbSalePrice->Fetch()) {
                    $discountedPrice = (float)$arSalePrice["PRICE"];
                    if ($discountedPrice > 0 && $discountedPrice < $price) {
                        $salePrice = $discountedPrice;
                    }
                }
            }

            // Доступность
            $productInfo = CCatalogProduct::GetByID($offerId);
            // Товар доступен, если есть остаток И цена > 0
            $available = ($productInfo['QUANTITY'] > 0 && $price > 0);

            // Картинка предложения
            $offerImages = [];
            $domain = 'https://stimma.com.ua';

            if ($arOfferFields['DETAIL_PICTURE']) {
                $path = CFile::GetPath($arOfferFields['DETAIL_PICTURE']);
                if ($path) $offerImages[] = $domain . $path;
            }
            
            // Дополнительные фото предложения (PHOTO_GALLERY)
            if (!empty($arOfferProps['PHOTO_GALLERY']['VALUE'])) {
                $morePhotos = $arOfferProps['PHOTO_GALLERY']['VALUE'];
                if (!is_array($morePhotos)) $morePhotos = [$morePhotos];
                
                foreach ($morePhotos as $photoId) {
                    $path = CFile::GetPath($photoId);
                    if ($path) $offerImages[] = $domain . $path;
                }
            }
            
            // Добавляем картинки предложения в общий список картинок товара
            if (!empty($offerImages)) {
                foreach ($offerImages as $img) {
                    $products[$parentId]['images'][] = $img;
                }
            }

            $pictureUrl = !empty($offerImages) ? $offerImages[0] : "";

            // Собираем динамические атрибуты оффера
            $offerAttributes = [];
            $sizeVal = "";
            $colorVal = "";
            $articleVal = "";

            foreach ($arOfferProps as $code => $prop) {
                $val = formatPropValue($prop['VALUE']);
                if ($val !== '' && $code !== 'CML2_LINK' && $code !== 'PHOTO_GALLERY') {
                    $lowerCode = strtolower($code);
                    $offerAttributes[$lowerCode] = $val;

                    // Пытаемся определить размер и цвет
                    if (isSizeProp($code)) $sizeVal = $val;
                    if (isColorProp($code)) $colorVal = $val;
                    if ($code == 'ARTICLE' || $code == 'ARTNUMBER') $articleVal = $val;
                }
            }

            // ВАЛИДАЦИЯ РАЗМЕРА: Размер не может быть длинным текстом
            if (mb_strlen($sizeVal) > 15) {
                $sizeVal = "";
            }

            // УЛУЧШЕНИЕ: Если цвет не найден или он на латинице/коде, пробуем достать из названия
            // Формат: Название Артикул Размер Цвет
            if ($sizeVal && $arOfferFields['NAME']) {
                // Ищем позицию размера в названии
                // Добавляем пробелы для точности, чтобы не найти часть слова
                $name = $arOfferFields['NAME'];
                $pos = mb_strrpos($name, $sizeVal);
                
                if ($pos !== false) {
                    // Берем все что после размера
                    $potentialColor = trim(mb_substr($name, $pos + mb_strlen($sizeVal)));
                    // Очищаем от лишних символов если нужно
                    if ($potentialColor && mb_strlen($potentialColor) < 30) {
                         // Если цвет был пустой или похож на код (латиница), заменяем
                         if (!$colorVal || preg_match('/^[a-zA-Z0-9_]+$/', $colorVal)) {
                             $colorVal = $potentialColor;
                         }
                    }
                }
            }

            // ВАЛИДАЦИЯ ЦВЕТА: Если цвет все еще на латинице (код), пробуем транслитерацию/перевод
            if ($colorVal && preg_match('/^[a-zA-Z0-9_]+$/', $colorVal)) {
                $colorVal = getColorUa($colorVal);
            }

            // ФИЛЬТР: Пропускаем недоступные предложения — КРОМЕ передзамовлення.
            // Товари «Скоро в наявності» (SOON=y) мають QUANTITY=0, тож без цього
            // винятку ВСІ їх оффери відсіювались тут → продукт лишався без
            // variants → і повністю випадав з вигрузки (його не було ні в
            // текстовому пошуку, ні як передзамовлення). Експортуємо їх з
            // розмірами та ціною; downstream transformer за attributes.soon==="y"
            // ставить coming_soon=true і примусово in_stock=false, тож додані
            // розміри не вводять клієнта в оману (це майбутні розміри).
            $parentIsSoon = isset($products[$parentId]['attributes']['soon'])
                && $products[$parentId]['attributes']['soon'] === 'y';
            if (!$available && !$parentIsSoon) {
                continue;
            }

            $variant = [
                "offer_id" => $offerId,
                "article" => $articleVal,
                "size" => $sizeVal,
                "color" => $colorVal,
                "price" => (float)$price,
                "sale_price" => $salePrice,
                "available" => $available,
                "url" => $products[$parentId]['detail_page_url'] ?? '',
                "picture" => $pictureUrl,
                "attributes" => $offerAttributes
            ];

            if ($sizeVal) {
                $products[$parentId]['available_sizes'][] = $sizeVal;
            }
            if ($colorVal) {
                $products[$parentId]['available_colors'][] = $colorVal;
            }
            
            // Сохраняем минимальную цену товара
            if (!isset($products[$parentId]['price']) || ($price > 0 && $price < $products[$parentId]['price'])) {
                $products[$parentId]['price'] = $price;
            }

            // Сохраняем минимальную акционную цену товара
            if ($salePrice !== null) {
                if (!isset($products[$parentId]['sale_price']) || $salePrice < $products[$parentId]['sale_price']) {
                    $products[$parentId]['sale_price'] = $salePrice;
                }
            }

            $products[$parentId]['variants'][] = $variant;
        }
    }
}

// 5.5. Получение замеров из HighloadBlock (ID=4)
$productMeasurements = [];
if (!empty($productIds)) {
    $hlblockId = 4;
    $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($hlblockId)->fetch();
    if ($hlblock) {
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $entityDataClass = $entity->getDataClass();
        
        $rsData = $entityDataClass::getList(array(
            "select" => array("UF_PRODUCT", "UF_TABLE"),
            "filter" => array("UF_PRODUCT" => $productIds)
        ));
        
        while ($arData = $rsData->fetch()) {
            $pid = $arData['UF_PRODUCT'];
            $table = $arData['UF_TABLE'];
            if ($pid && $table) {
                $productMeasurements[$pid] = $table;
            }
        }
    }
}

// 5.6. Українські назви кольорів з Highload-блоків.
//   HL-блок 3 (max_color_reference) — повна палітра ~791 точних назв з
//   українським UF_NAME_UA (точний відтінок: "серо-голубой" → "сіро-блакитний").
//   HL-блок 5 (main_colors) — 23 базові кольори (fallback за базовим slug).
// Нормалізуємо ключі (регістр, ё→е, дефіс/пробіл, артикул-префікс), щоб
// вільний текст кольору з назви оффера матчився з довідником (~96% товарів).
function normColorKey($s) {
    if ($s === null) return '';
    $s = trim((string)$s);
    if ($s === '') return '';
    $s = preg_replace('/^\s*\d+\s+/u', '', $s);   // зрізати артикул/ID-префікс
    $s = mb_strtolower($s, 'UTF-8');
    $s = str_replace('ё', 'е', $s);               // ё→е (назва оффера vs довідник)
    $s = preg_replace('/[\s\-\/]+/u', ' ', $s);   // дефіс/слеш/пробіл → пробіл
    return trim($s);
}
function ucfirstUa($s) {
    if ($s === '') return $s;
    return mb_strtoupper(mb_substr($s, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($s, 1, null, 'UTF-8');
}
function loadColorUaMap($hlbId) {
    $map = [];
    $hlb = \Bitrix\Highloadblock\HighloadBlockTable::getById($hlbId)->fetch();
    if (!$hlb) return $map;
    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlb);
    $dc = $entity->getDataClass();
    $rs = $dc::getList(array("select" => array("UF_NAME", "UF_NAME_UA", "UF_XML_ID")));
    while ($r = $rs->fetch()) {
        $ua = isset($r['UF_NAME_UA']) ? trim((string)$r['UF_NAME_UA']) : '';
        if ($ua === '') continue;
        foreach (array('UF_NAME', 'UF_XML_ID') as $f) {
            $k = normColorKey(isset($r[$f]) ? $r[$f] : '');
            if ($k !== '' && !isset($map[$k])) $map[$k] = $ua;
        }
    }
    return $map;
}
$colorUaHl3 = loadColorUaMap(3); // точна палітра (primary)
$colorUaHl5 = loadColorUaMap(5); // базові кольори (fallback)

// 6. Формирование финального JSON (Color-Centric: Один товар Bitrix = Один цвет)
$finalOutput = [];

// RAW MODE: Повертаємо дані без фільтрації
if ($RAW_MODE) {
    $rawOutput = [];
    $limit = (int)$request->getQuery("limit") ?: 0; // ?limit=5 для обмеження
    $count = 0;

    foreach ($products as $pid => $p) {
        // Додаємо всі поля без очистки
        $rawProduct = $p;
        $rawProduct['_raw_bitrix_id'] = $pid;
        $rawProduct['_raw_measurements'] = isset($productMeasurements[$pid]) ? $productMeasurements[$pid] : null;

        $rawOutput[] = $rawProduct;
        $count++;

        if ($limit > 0 && $count >= $limit) break;
    }

    echo json_encode([
        '_mode' => 'raw',
        '_total_products' => count($products),
        '_returned' => count($rawOutput),
        'products' => $rawOutput
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
    die();
}

foreach ($products as $pid => $p) {
    // ФИЛЬТР: Если у товара нет доступных предложений, пропускаем его
    if (empty($p['variants'])) {
        continue;
    }

    // 1. ID и Group ID
    // ID - реальный ID товара из Битрикс
    $p['id'] = (string)$p['bitrix_id'];
    // Group ID - хэш от названия модели (чтобы связать разные цвета одной модели)
    $p['group_id'] = md5($p['base_name_ua']);

    // 1.2. Флаги специальных категорий (NEW, SALE, BESTSELLERS)
    $bitrixId = $p['bitrix_id'];
    if (isset($productSections[$bitrixId])) {
        $p['sections'] = $productSections[$bitrixId]['sections'];
        $p['is_new'] = $productSections[$bitrixId]['is_new'];
        $p['is_sale'] = $productSections[$bitrixId]['is_sale'];
        $p['is_bestseller'] = $productSections[$bitrixId]['is_bestseller'];
    } else {
        $p['sections'] = [];
        $p['is_new'] = false;
        $p['is_sale'] = false;
        $p['is_bestseller'] = false;
    }

    // 1.5. УКРАЇНІЗАЦІЯ: Використовуємо українські поля з fallback
    // Назва товару: attributes.name_ua → base_name_ua (fallback)
    $nameUa = isset($p['attributes']['name_ua']) ? $p['attributes']['name_ua'] : '';
    $p['base_name_ua'] = getUaWithFallback($nameUa, $p['base_name_ua']);

    // Стилі: витягуємо українську частину з "RU*UA" формату
    if (isset($p['attributes']['styles'])) {
        $p['attributes']['styles'] = extractUkrainian($p['attributes']['styles']);
    }

    // Склад (composition): витягуємо українську частину
    if (isset($p['attributes']['composition'])) {
        $p['attributes']['composition'] = extractUkrainian($p['attributes']['composition']);
    }

    // Принт: спочатку витягуємо українську частину з "RU*UA", потім перекладаємо
    if (isset($p['attributes']['print'])) {
        $print = extractUkrainian($p['attributes']['print']);
        $p['attributes']['print'] = getPrintUa($print);
    }

    // VID з variants (тип товару) - перекладаємо на українську
    $firstVariant = !empty($p['variants']) ? reset($p['variants']) : null;
    if ($firstVariant && isset($firstVariant['attributes']['vid'])) {
        $vidRu = $firstVariant['attributes']['vid'];
        $p['attributes']['vid'] = getVidUa($vidRu);
    }

    // Склад з variants (sostav_site_ua) - українська версія
    if ($firstVariant && isset($firstVariant['attributes']['sostav_site_ua'])) {
        $p['attributes']['sostav_full'] = $firstVariant['attributes']['sostav_site_ua'];
    }

    // 2. Определение цвета
    // Так как "один товар = один цвет", берем цвет из первого варианта
    $color = "";
    if (!empty($p['available_colors'])) {
        $color = reset($p['available_colors']);
    }
    // Если цвета нет в available_colors, ищем в атрибутах
    if (!$color && isset($p['attributes']['color'])) {
        $color = $p['attributes']['color'];
    }
    $p['color'] = $color;

    // 2.1. Українська назва кольору. Пріоритет:
    //   1) точна назва кольору з HL-3 (за нормалізованою РОС-назвою),
    //   2) базовий slug (attributes.color) у HL-3, потім у HL-5,
    //   3) точна назва у HL-5 (базовий).
    // Якщо ніде немає — поле не додаємо, споживач (transformer) лишає
    // російську назву як fallback.
    $colorUa = '';
    $ck = normColorKey($color);
    if ($ck !== '' && isset($colorUaHl3[$ck])) {
        $colorUa = $colorUaHl3[$ck];
    }
    if ($colorUa === '' && isset($p['attributes']['color'])) {
        $sk = normColorKey($p['attributes']['color']);
        if ($sk !== '' && isset($colorUaHl3[$sk])) {
            $colorUa = $colorUaHl3[$sk];
        } elseif ($sk !== '' && isset($colorUaHl5[$sk])) {
            $colorUa = $colorUaHl5[$sk];
        }
    }
    if ($colorUa === '' && $ck !== '' && isset($colorUaHl5[$ck])) {
        $colorUa = $colorUaHl5[$ck];
    }
    if ($colorUa !== '') {
        $p['color_ua'] = ucfirstUa($colorUa);
    }

    // Удаляем старые поля цветов, они больше не нужны в массиве
    unset($p['available_colors']);
    unset($p['_color_sizes']); // Если было

    // 3. Размеры и артикулы (SKU)
    // Собираем размеры и артикулы из всех вариантов этого товара
    $sizes = [];
    $articles = [];
    foreach ($p['variants'] as $v) {
        if (!empty($v['size'])) {
            $sizes[] = $v['size'];
            // Маппинг размер -> артикул для проверки остатков в магазинах
            if (!empty($v['article'])) {
                $articles[$v['size']] = $v['article'];
            }
        }
    }
    $p['available_sizes'] = array_values(array_unique($sizes));
    $p['articles'] = $articles; // { "XS": "141803", "S": "141804", ... }

    // 4. Цена
    // Берем минимальную цену среди вариантов, если она еще не установлена
    if (!isset($p['price']) || $p['price'] <= 0) {
        $minPrice = 0;
        foreach ($p['variants'] as $v) {
            if ($v['price'] > 0) {
                if ($minPrice === 0 || $v['price'] < $minPrice) {
                    $minPrice = $v['price'];
                }
            }
        }
        $p['price'] = $minPrice;
    }

    // 4.1. Акционная цена (sale_price от GetOptimalPrice)
    if (!isset($p['sale_price'])) {
        $minSalePrice = null;
        foreach ($p['variants'] as $v) {
            if (isset($v['sale_price']) && $v['sale_price'] !== null) {
                if ($minSalePrice === null || $v['sale_price'] < $minSalePrice) {
                    $minSalePrice = $v['sale_price'];
                }
            }
        }
        $p['sale_price'] = $minSalePrice;
    }

    // 5. Атрибуты
    // Переносим атрибуты из первого варианта в товар (общие для всех размеров этого цвета)
    if (!empty($p['variants'])) {
        $firstVariant = reset($p['variants']);
        $variantSpecificKeys = ['article', 'razmer', 'color_ref', 'size', 'color', 'offer_size', 'artnumber', 'cml2_link', 'price', 'available'];
        
        foreach ($firstVariant['attributes'] as $k => $v) {
            $lowerK = strtolower($k);
            if (!in_array($lowerK, $variantSpecificKeys)) {
                if (!isset($p['attributes'][$lowerK])) {
                    $p['attributes'][$lowerK] = $v;
                }
            }
        }
    }

    // 6. Описание
    // Если описание пустое, ищем в вариантах
    if (empty($p['description_ua']) && !empty($p['variants'])) {
        foreach ($p['variants'] as $v) {
            foreach ($v['attributes'] as $code => $val) {
                if (stripos($code, 'detail_text') !== false || stripos($code, 'description') !== false) {
                    $p['description_ua'] = $val;
                    break 2;
                }
            }
        }
    }

    // 7. Замеры
    $measurementsText = "";
    if (isset($productMeasurements[$p['bitrix_id']])) {
        $measurementsText = formatMeasurements($productMeasurements[$p['bitrix_id']]);
    }
    $p['measurements'] = $measurementsText;

    // 8. Text Content
    // Получаем название категории
    $categoryName = '';
    if ($p['category_id']) {
        $rsSection = CIBlockSection::GetList([], ['ID' => $p['category_id']], false, ['NAME']);
        if ($arSection = $rsSection->GetNext()) {
            $categoryName = $arSection['NAME'];
        }
    }

    $textContentParts = [
        $p['base_name_ua'],
        "Категорія: " . ($categoryName ?: $p['category_id']),
        "Колір: " . $color,
        "Опис: " . trim(strip_tags($p['description_ua'])),
    ];
    
    $excludeAttrsFromText = [
        'photo_gallery', 'dopol', 'in_block', 'model', 'kasta_qunatity', 'url', 'picture', 'color_ref', 'article',
        'sostav_site_ru', 'razmernost_ru', 'name_ua', 'detail_text', 'color', 'price'
    ];

    $uaNames = [
        'material' => 'Матеріал',
        'sostav' => 'Склад',
        'composition' => 'Склад',
        'style' => 'Стиль',
        'styles' => 'Стиль',
        'print' => 'Принт',
        'siluet' => 'Силует',
        'param_model' => 'Параметри моделі',
        'vid' => 'Вид',
        'sostav_site_ua' => 'Склад (сайт)',
        'razmernost_ua' => 'Розмірність',
        'detail_text_ua' => 'Опис'
    ];

    foreach ($p['attributes'] as $k => $v) {
        $lowerK = strtolower($k);
        
        if ($lowerK === 'detail_text_ua') {
            $desc = trim(strip_tags($p['description_ua']));
            if (mb_strpos($desc, trim(strip_tags($v))) !== false) {
                continue;
            }
        }

        if (!in_array($lowerK, $excludeAttrsFromText) && !is_numeric($v) && strlen($v) > 1) {
             $label = $uaNames[$lowerK] ?? $k;
             $textContentParts[] = "$label: $v";
        }
    }
    
    if (!empty($p['available_sizes'])) {
        $textContentParts[] = "Розміри: " . implode(', ', $p['available_sizes']);
    }
    
    $p['text_content'] = implode(". ", array_filter($textContentParts));

    // 8.5 Cross-sell (DOPOL)
    $crossSell = [];
    if (isset($p['attributes']['dopol'])) {
        $dopolVal = $p['attributes']['dopol'];
        // Если это строка с запятыми
        if (is_string($dopolVal)) {
            $parts = explode(',', $dopolVal);
            foreach ($parts as $part) {
                $id = trim($part);
                if ($id) $crossSell[] = $id;
            }
        } elseif (is_array($dopolVal)) {
             foreach ($dopolVal as $part) {
                $id = trim((string)$part);
                if ($id) $crossSell[] = $id;
            }
        }
    }
    $p['cross_sell'] = $crossSell;

    // 9. Чистка JSON
    $fieldsToRemove = [
        'detail_text_ua', 'detail_text', 'name_ua', 'photo_gallery', 'dopol', 'in_block', 
        'model', 'kasta_qunatity', 'sostav_site_ru', 'razmernost_ru', 'picture', 
        'variants', 'bitrix_id', 'product_id', '_category_name', 'color_to_id'
    ];

    foreach ($fieldsToRemove as $field) {
        if (isset($p['attributes'][$field])) unset($p['attributes'][$field]);
        if (isset($p[$field])) unset($p[$field]);
    }

    $finalOutput[] = $p;
}

echo json_encode($finalOutput, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
