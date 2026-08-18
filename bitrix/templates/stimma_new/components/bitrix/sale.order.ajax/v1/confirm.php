<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Sale;
use Bitrix\Sale\Order;
use Bitrix\Sale\Basket;
/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
$ru=LANGUAGE_ID=='ru'?'/ru':'';
CModule::IncludeModule('iblock');
?>

<? if (!empty($arResult["ORDER"])): ?>
<?
/* todo: Костыль для акции сумма > 6000 - 1000 на товар */
    global $USER;
    $isYour30 = true;
    $uGroups = $USER->GetUserGroupArray();
    if (in_array(9, $uGroups)) {
        $isYour30 = false;
    }

	$isYour30 = false;
    Loader::includeModule("sale");
    Loader::includeModule("catalog");
    Loader::includeModule("iblock");



    // Далі створення бонусного заказу (Валера)
    /*
    $orderId = (int)$arResult["ORDER"]["ID"];
    $order = Order::load($orderId);
    if ($order) {
        $siteId = $order->getSiteId();
        $userId = $order->getUserId();
        $currency = $order->getCurrency();
        $personTypeId = $order->getPersonTypeId();

        $basket = $order->getBasket();

        $bonusItems = [];
        $regularItems = [];

        // --- Разделяем товары по PROP_BONUS ---
        foreach ($basket as $basketItem) {
            $productId = $basketItem->getProductId();

            // Проверяем, не SKU ли это
            $productInfo = \CCatalogSku::GetProductInfo($productId);
            if ($productInfo && $productInfo['ID']) {
                $realProductId = $productInfo['ID'];
            } else {
                $realProductId = $productId;
            }

            $prop = CIBlockElement::GetProperty(21, $realProductId, [], ['CODE' => 'PROP_BONUS'])->Fetch();
            $value = trim((string)$prop['VALUE_ENUM'] ?: (string)$prop['VALUE']);

            $isBonus = in_array(mb_strtoupper($value), ['Y', 'ДА', 'YES', '1'], true);

            if ($isBonus) {
                $bonusItems[] = $basketItem;
            } else {
                $regularItems[] = $basketItem;
            }
        }

        if (!empty($bonusItems)) {

            // --- Создаем бонусный заказ ---
            $bonusOrder = Sale\Order::create($siteId, $userId);
            $bonusOrder->setPersonTypeId($personTypeId);

            // Создаём корзину для бонусных товаров
            $bonusBasket = Sale\Basket::create($siteId);
            foreach ($bonusItems as $item) {
                $newItem = $bonusBasket->createItem('catalog', $item->getProductId());
                $newItem->setFields([
                    'QUANTITY' => $item->getQuantity(),
                    'PRICE' => $item->getPrice(),            // сохраняем цену
                    'BASE_PRICE' => $item->getBasePrice(),   // сохраняем базовую цену
                    'DISCOUNT_PRICE' => $item->getDiscountPrice(),
                    'CURRENCY' => $currency,
                    'LID' => $siteId,
                    'NAME' => $item->getField('NAME'),
                    'PRODUCT_PROVIDER_CLASS' => $item->getField('PRODUCT_PROVIDER_CLASS'),
                ]);
            }

            $bonusOrder->setBasket($bonusBasket);

            // Копируем свойства
            $props = $order->getPropertyCollection();
            $bonusProps = $bonusOrder->getPropertyCollection();
            foreach ($props as $propItem) {
                $propId = $propItem->getField('ORDER_PROPS_ID');
                $value = $propItem->getValue();
                $targetProp = $bonusProps->getItemByOrderPropertyId($propId);
                if ($targetProp) {
                    $targetProp->setValue($value);
                }
            }

            // Доставка и оплата
            $shipmentCollection = $bonusOrder->getShipmentCollection();
            $shipment = $shipmentCollection->createItem();
            $shipment->setField('DELIVERY_NAME', 'Бонусная доставка');
            $shipmentItemCollection = $shipment->getShipmentItemCollection();
            foreach ($bonusBasket as $basketItem) {
                $shipmentItem = $shipmentItemCollection->createItem($basketItem);
                $shipmentItem->setQuantity($basketItem->getQuantity());
            }

            $paymentCollection = $bonusOrder->getPaymentCollection();
            $payment = $paymentCollection->createItem();
            $payment->setField('SUM', 0);
            $payment->setField('PAY_SYSTEM_NAME', 'Оплата стимзы');

            $bonusOrder->setField('CURRENCY', $currency);
            $bonusOrder->doFinalAction(true);

            // теперь ставим комментарий и сохраняем
            $bonusOrder->setField('COMMENTS', 'Бонусный заказ, создан из #' . $orderId);
            $bonusOrder->save();

            $bonusOrderId = $bonusOrder->getId();

            // --- Удаляем бонусные товары из основного заказа ---
            foreach ($bonusItems as $basketItem) {
                $basket->getItemById($basketItem->getId())->delete();
            }

            $order->doFinalAction(true);
            $order->save();

            // Лог для проверки
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/local/log_bonus_orders.txt',
                date('Y-m-d H:i:s') . " Основной заказ: {$orderId}, бонусный: {$bonusOrderId}\n", FILE_APPEND);

            // Обновляем arResult, чтобы в оплату пошёл только основной заказ
            $arResult['ORDER']['ID'] = $orderId;
            $arResult['ORDER']['PRICE'] = $order->getPrice();
        }
    }
    */

    if (/*$USER->IsAdmin() &&*/ $isYour30) {


        if ($order) {
            $basket = $order->getBasket();

            $maxDiscountAmount = 1000;
            $cumulativeSum = 0;

            $discountCandidateItem = null;
            $discountCandidatePrice = PHP_FLOAT_MAX;

            foreach ($basket as $item) {
                $basePrice = $item->getBasePrice();
                $price = $item->getPrice();
                $quantity = $item->getQuantity();

                $hasDiscount = $price < $basePrice;

                if ($hasDiscount) {
                    // Пропускаем товар со скидкой
                    continue;
                }

                $positionTotal = $price * $quantity;
                $cumulativeSum += $positionTotal;

                // Ищем самую дешёвую позицию (по цене за 1 шт)
                if ($price < $discountCandidatePrice) {
                    $discountCandidatePrice = $price;
                    $discountCandidateItem = $item;
                }
            }

            // Применяем скидку, только если сумма больше 6000
            if ($cumulativeSum > 6000 && $discountCandidateItem) {
                $originalPrice = $discountCandidateItem->getPrice();
                $quantity = $discountCandidateItem->getQuantity();

                if ($quantity > 0) {
                    $neededDiscount = $cumulativeSum - 6000;
                    $maxPossibleDiscount = $originalPrice * $quantity;
                    $discountToApply = min($neededDiscount, $maxDiscountAmount, $maxPossibleDiscount);
                    $discountPerUnit = $discountToApply / $quantity;
                    $newUnitPrice = max($originalPrice - $discountPerUnit, 0);

                    // Лог для отладки (можно убрать)
                    PR([
                        'cumulativeSum' => $cumulativeSum,
                        'neededDiscount' => $neededDiscount,
                        'maxPossibleDiscount' => $maxPossibleDiscount,
                        'discountToApply' => $discountToApply,
                        'quantity' => $quantity,
                        'originalPrice' => $originalPrice,
                        'discountPerUnit' => $discountPerUnit,
                        'newUnitPrice' => $newUnitPrice,
                    ], 'discount_debug');

                    $discountCandidateItem->setFields([
                        'PRICE' => $newUnitPrice,
                        'DISCOUNT_PRICE' => $discountPerUnit,
                    ]);

                    $order->doFinalAction(true); // перерасчёт
                    $order->save();

                    $arResult["ORDER"]["PRICE"] = $order->getPrice();
                }
            }
        }
    }

    global $DB;

    $orderData = $DB -> Query('select * from b_sale_order where ID = ' . $arResult['ORDER']['ID']) -> Fetch();

$payment = CSalePaySystem::GetByID($arResult['ORDER']['PAY_SYSTEM_ID']);
$delivery = CSaleDelivery::GetByID($arResult['ORDER']['DELIVERY_ID']);
$basket = [];
$res = $DB -> Query('select * from b_sale_basket where ORDER_ID = ' . $arResult['ORDER']['ID']);
$productJson = [];
$minus_price=$bonus=0;
while ($record = $res -> Fetch())
{
        {
           $product = $record['PRODUCT_ID'];
            $withStims =$DB->Query('select * from basket_stims where UF_ID = '.$record['ID']);
            if($withStims=$withStims->Fetch())
            {
                $bonus += ($withStims['UF_STIMS']*$record['QUANTITY']);
                $minus_price += ($record['PRICE']*$record['QUANTITY']);
                $record['STIMS'] = $withStims['UF_STIMS']*$record['QUANTITY'];
            }

            $basket[] = $record;

            $product = CIBlockElement::GetByID($product)->Fetch();
            $res2 = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $product['IBLOCK_SECTION_ID']], false, ['ID','IBLOCK_ID','NAME','UF_*']) -> Fetch();
            $sectionName = LANGUAGE_ID == 'ua' ? $res2['UF_NAME_UA'] : $res2['NAME'];

            if(LANGUAGE_ID == 'ua')
                $itemName = CIBlockElement::GetProperty(25, $record['PRODUCT_ID'],'sort', 'asc', array('CODE' => 'NAME_UA')) -> Fetch()['VALUE'];
            else
                $itemName = $record['NAME'];

            $mainPID = CIBlockElement::GetProperty(25, $record['PRODUCT_ID'],'sort', 'asc', array('CODE' => 'CML2_LINK')) -> Fetch()['VALUE'];
            $mainFields = CIBlockElement::GetByID($mainPID)->Fetch();

            if(LANGUAGE_ID == 'ua')
            {
                $mainFields['NAME'] = CIBlockElement::GetProperty(21, $mainPID,'sort', 'asc', array('CODE' => 'NAME_UA')) -> Fetch()['VALUE'];
            }

             $productJson[] = "
                {
                    'name': '".addslashes($mainFields['NAME'])."',
                    'id': '".$mainPID."',
                    'baseId': '".$mainPID."',
                    'price': '".$record['PRICE']."',
                    'brand': 'STIMMA',
                    'category': '".addslashes($sectionName)."',
                    'quantity': ".$record['QUANTITY']."
                }
                ";
             $productJson2[] = "
                {
                    item_id: '".$mainPID."',
                    item_name: '".addslashes($mainFields['NAME'])."',
                    affiliation: 'STIMMA',
                    discount: ".($record['BASE_PRICE']-$record['PRICE']).", 
                    index: 1, 
                    item_brand: 'STIMMA', 
                    item_category: '".addslashes($sectionName)."',
                    item_list_id:'".$mainPID."',
                    item_list_name: '".addslashes($itemName)."',
                    price: ".$record['BASE_PRICE'].", // Ціна товару без знижки.
                    quantity: ".$record['QUANTITY']." 
                }
                ";
             $facebookIds[] = $mainPID;
            ?>
            <script>
                //addViewItem(<?=$record['PRODUCT_ID']?>, '<?=addslashes($itemName)?>', <?=$record['PRICE']?>, '<?=addslashes($sectionName)?>', 1,'', false,'Checkout', <?=$record['QUANTITY']?>);
            </script>
            <?
        }
}
?>
<?// ЗАКОМЕНТИВ 05,03?>
<script>
dataLayer.push({ ecommerce: null });
dataLayer.push({
  event: "purchase",
  ecommerce: {
      transaction_id: "<?=$orderData['ID']?>", // id замовлення. Унікальне для кожного замовлення
      value: <?=$orderData['PRICE']?>,
      currency: "UAH",
      items: [
          <?=implode(',',$productJson2)?>
    ]
  }
});
</script>
<?
if($orderData['PAY_SYSTEM_ID'] != 3)
{
    $usdRate = COption::GetOptionString("my_module", "usd_rate",'41.7');
    ?>
    <script>
        fbq ( 'track', 'Purchase',
            {value:<?=round($orderData['PRICE']/$usdRate,2)?>,
                Currency: 'USD',
                Content_ids: [<?=implode(',',$facebookIds)?>],
                Content_type: 'Purchase',
                Content_category: 'Purchase' ,
            });
    </script>
    <?
}
?>
    <?/*<script>
window.dataLayer = window.dataLayer || [];
dataLayer.push({
 'ecommerce': {
   'currencyCode': 'UAH',
   'purchase': {
     'actionField': {
       'id': '<?=$orderData['ID']?>',
       'affiliation': 'Online Store',
       'type': 'Покупка через корзину',
       'revenue': '<?=$orderData['PRICE']?>',
       'tax': '0',
       'shipping': '0'
     },
     'products': [<?=implode(',',$productJson)?>]
   }
 },
 'event': 'gtm-ee-event',
 'gtm-ee-event-category': 'Enhanced Ecommerce',
 'gtm-ee-event-action': 'Purchase',
 'gtm-ee-event-non-interaction': 'False',
 'dyn-rem-ids': '<?=$orderData['ID']?>',
 'dyn-rem-pagetype': 'purchase',
 'dyn-rem-value': '<?=$orderData['PRICE']?>',
});
        //sendOrder();
    </script>*/?>
    <?

    $order = $DB->Query('select * from b_sale_order where ID = '.$arResult['ORDER']['ID'])->Fetch();

$amount = $order['PRICE'];

$orderID = $order['ID'];

// todo: Костыль для Включения / Выключения ФОП
$setting_fop = COption::GetOptionString("my_module", "setting_fop", "Y");
if($setting_fop == 'Y'){
    $FOP = '';
}else{
    $FOP = '<smch_id>15740</smch_id>';
}


$merchant_id = '5334';
$merchant_secret = '158884b6494b43b860abd0982eedd743e964251d';
$salt = sha1(microtime(true));
$sign = hash_hmac('sha512', $salt, $merchant_secret);
$urlBack = 'https://stimma.ua/order/?ORDER_ID=';


if ( isset($order['USER_DESCRIPTION']) && (int)$order['USER_DESCRIPTION'] > 0) {
	$amount -= $order['USER_DESCRIPTION'];
}

//unset($order['USER_DESCRIPTION']);
/*
echo "orderID=$orderID<==<br>";
echo "amount=$amount<==<br>";
echo "orderID=$orderID<==<br>";
echo "<pre>";print_R($order);print_R($_POST);print_R($_GET);print_R($_SERVER);echo "</pre>";
exit();*/

    $xml=$prepayedXml=false;
if($amount-$minus_price > 0)
{
    $xml = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>
            <payment>
                <auth>
                    <mch_id>'.$merchant_id.'</mch_id>
                    <salt>'.$salt.'</salt>
                    <sign>'.$sign.'</sign>
                </auth>
                <urls>
                    <good>'.$urlBack.$orderID.'&SUCCESS=Y</good>
                    <bad>'.$urlBack.$orderID.'&SUCCESS=N</bad>
                    <auto_redirect_good>1</auto_redirect_good>
                    <auto_redirect_bad>0</auto_redirect_bad>
                </urls>
                <transactions>
                    <transaction>
                        <amount>'.(($amount-$minus_price)*100).'</amount>
                        <currency>UAH</currency>
                        <desc>Оплата замовлення #'.$orderID.'</desc>
                        <info>{"dogovor":'.$orderID.',"view_params": {
        "retry_button": true
    }}</info>
                        <smch_id>18729</smch_id>
                    </transaction>
                </transactions>
                <trademark>{"ru":"Stimma","ua":"Stimma","en":"Stimma"}</trademark>
                <lifetime>24</lifetime>
                <lang>ua</lang>
            </payment>';


    $prepayedXml = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>
    <payment>
        <auth>
            <mch_id>'.$merchant_id.'</mch_id>
            <salt>'.$salt.'</salt>
            <sign>'.$sign.'</sign>
        </auth>
        <urls>
            <good>'.$urlBack.$orderID.'&SUCCESS=Y</good>
            <bad>'.$urlBack.$orderID.'&SUCCESS=N</bad>
            <auto_redirect_good>1</auto_redirect_good>
            <auto_redirect_bad>0</auto_redirect_bad>
        </urls>
        <transactions>
            <transaction>
                <amount>'.(200*100).'</amount>
                <currency>UAH</currency>
                <desc>Оплата замовлення #'.$orderID.'</desc>
                <info>{"dogovor":'.$orderID.',"view_params": {
"retry_button": true
}}</info>
                <smch_id>18597</smch_id>
            </transaction>
        </transactions>
        <trademark>{"ru":"Stimma","ua":"Stimma","en":"Stimma"}</trademark>
        <lifetime>24</lifetime>
        <lang>ua</lang>
    </payment>';
}
// замість 16932 став 18597

$skipOrderId = 44779;

?>
<?



if($order['PAYED'] == 'Y' || isset($_GET['SUCCESS']))
{
    ?>
    <div class="order-end-page">
        <div class="wrapper">
            <div class="order-end-block">
                <div class="order-end-details">
                    <div class="order-end-icon">
                        <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="22.5" cy="22.5" r="22.5" fill="#FE9D56"/>
                            <path d="M22.2525 33.8875C22.1755 33.8875 22.0993 33.8715 22.0287 33.8407C21.9581 33.8098 21.8947 33.7646 21.8424 33.7081L10.7851 21.7472C10.7114 21.6675 10.6625 21.568 10.6445 21.4609C10.6264 21.3538 10.64 21.2438 10.6835 21.1443C10.727 21.0448 10.7986 20.9602 10.8895 20.9007C10.9804 20.8413 11.0866 20.8096 11.1952 20.8096H16.5176C16.5975 20.8096 16.6765 20.8268 16.7492 20.8599C16.8219 20.8931 16.8867 20.9414 16.9391 21.0017L20.6345 25.2531C21.0339 24.3994 21.807 22.978 23.1637 21.2459C25.1693 18.6852 28.8999 14.9193 35.2825 11.5196C35.4059 11.4539 35.5494 11.4369 35.6847 11.4719C35.82 11.5068 35.9373 11.5912 36.0134 11.7085C36.0896 11.8257 36.1189 11.9672 36.0958 12.105C36.0727 12.2429 35.9987 12.367 35.8885 12.453C35.8641 12.472 33.4032 14.41 30.571 17.9597C27.9644 21.2263 24.4995 26.5676 22.7945 33.4633C22.7645 33.5844 22.6949 33.692 22.5966 33.769C22.4983 33.8459 22.3771 33.8877 22.2523 33.8877L22.2525 33.8875Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="order-end-title-block">
                        <div class="order-end-thx">
                            Ти щойно зробила класний вибір.
                        </div>
                        <?/*<div class="order-end-date">
                            <?=date('d.m.Y H:i', strtotime($orderData['DATE_INSERT']))?>
                        </div>*/?>
                        <div class="order-end-number">
                            Замовлення вже у нас - скоро зв'яжемось для підтвердження.
                            <?=date('d.m.Y H:i', strtotime($orderData['DATE_INSERT']))?>, твоє замовлення № <?=$arResult['ORDER']['ID']?>
                            <a href="#" onclick="return false;">#<?=$arResult['ORDER']['ID']?></a>
                        </div>
                    </div>
                    <div class="order-end-total-block">
                        <?
                        foreach ($basket as $index => $item)
                        {
                            if(LANGUAGE_ID == 'ua')
                            {
                                $url = CIBlockElement::GetByID($item['PRODUCT_ID']) -> GetNext();
                                $p = CIBlockElement::GetByID($item['PRODUCT_ID']) -> GetNextElement();
                                $props = $p -> GetProperties();
                                $item['NAME'] = $props['NAME_UA']['VALUE'];
                            }
                            ?>
                            <div class="order-end-total-line goods">
                                <div class="order-end-total-key">
                                    <a href="<?=$url['DETAIL_PAGE_URL']?>">
                                        <?=$item['NAME']?>
                                    </a>
                                </div>
                                <div class="order-end-total-value">

                                    <?
                                    if($item['STIMS'])
                                    {
                                        ?>
                                        <div class="order-end-price-bonus">
                                            <?=$item['STIMS']?>
                                            <span class="icon">
                                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="13" cy="13" r="13" fill="#FE9D56"/>
                                                    <path d="M19.9537 14.8235C19.9537 15.4501 19.8381 16.0029 19.6113 16.468C19.3865 16.9267 19.0833 17.3191 18.707 17.6367C18.3434 17.9436 17.9193 18.1927 17.4454 18.3756C16.9991 18.5477 16.5242 18.6824 16.0355 18.7765C15.5542 18.8685 15.0612 18.9294 14.5714 18.9572C14.0933 18.9861 13.6322 19 13.1996 19C12.0632 19 10.9935 18.9038 10.0214 18.7145C9.05347 18.5253 8.1831 18.2868 7.43571 18.0035L7.07315 17.8655V13.8248L7.90323 14.2899C8.60079 14.6791 9.40967 14.9903 10.3087 15.2116C11.214 15.4351 12.1978 15.5484 13.2325 15.5484C13.8399 15.5484 14.3361 15.5164 14.7071 15.4544C15.146 15.3795 15.3877 15.294 15.5128 15.2352C15.6983 15.1485 15.7439 15.0887 15.745 15.0887C15.762 15.0619 15.7704 15.0438 15.7736 15.0341C15.7694 15.032 15.7577 15.0192 15.7365 15.0021C15.6591 14.9379 15.5096 14.8417 15.2351 14.7433C14.9775 14.6503 14.6668 14.5626 14.3149 14.4824C13.9449 14.399 13.5505 14.3145 13.135 14.2311C12.7109 14.1456 12.2752 14.0526 11.8268 13.9542C11.3656 13.8515 10.9129 13.7296 10.4793 13.5917C10.0383 13.4516 9.61322 13.2848 9.21779 13.0966C8.8001 12.8978 8.42587 12.6572 8.10677 12.3824C7.77071 12.0915 7.50144 11.7494 7.30532 11.3655C7.10283 10.9667 7 10.5058 7 9.99581C7 9.41413 7.10707 8.89768 7.31698 8.46143C7.5237 8.03052 7.80782 7.65841 8.16084 7.35475C8.50114 7.06177 8.89763 6.82226 9.3397 6.64155C9.75633 6.47047 10.2016 6.33575 10.6627 6.24165C11.1133 6.1497 11.5755 6.08554 12.0356 6.05132C12.4883 6.01711 12.924 6 13.33 6C13.7785 6 14.247 6.02352 14.722 6.06843C15.1916 6.11334 15.6634 6.1775 16.1213 6.25983C16.574 6.34002 17.0203 6.43519 17.4497 6.54211C17.8737 6.64904 18.2734 6.76238 18.6381 6.88107L19.025 7.00724V10.9303L18.2215 10.5358C18.0285 10.4406 17.7624 10.3283 17.4317 10.2032C17.1041 10.0792 16.7246 9.95945 16.3047 9.84718C15.886 9.73491 15.4238 9.63974 14.9308 9.56383C14.4442 9.48898 13.9385 9.45155 13.4276 9.45155C13.013 9.45155 12.6558 9.46439 12.3664 9.49005C12.0823 9.51571 11.8437 9.54886 11.6571 9.58735C11.4504 9.63012 11.3402 9.67182 11.284 9.69748C11.266 9.70604 11.2511 9.71352 11.2373 9.72101C11.3243 9.77875 11.4695 9.85466 11.7017 9.93379C11.9646 10.0225 12.2763 10.1091 12.6303 10.1893C13.0035 10.2738 13.3989 10.3604 13.8166 10.4502C14.2417 10.5411 14.6796 10.6406 15.1312 10.7486C15.5945 10.8587 16.0493 10.9891 16.4828 11.1367C16.927 11.2864 17.3532 11.4639 17.7476 11.6628C18.1631 11.8723 18.5352 12.1226 18.8533 12.4059C19.1883 12.7053 19.4565 13.0549 19.6505 	13.4463C19.8519 13.8526 19.9537 14.3156 19.9537 14.8235Z" fill="white"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <?
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="order-end-price">
                                            <?=FormatCurrency($item['PRICE'], 'UAH')?> ₴
                                        </div>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>
                            <?
                        }
                        ?>
                        <?/*
                        <div class="order-end-total-line goods">
                            <div class="order-end-total-key">
                                <a href="#">
                                    Жіночий бомбер Stimma Ешалін хакі
                                </a>
                            </div>
                            <div class="order-end-total-value">
                                <div class="order-end-price">
                                    3 999 ₴
                                </div>
                            </div>
                        </div>
                        <div class="order-end-total-line goods">
                            <div class="order-end-total-key">
                                <a href="#">
                                    Жіноча сумка Stimma Глорія шоколадний
                                </a>
                            </div>
                            <div class="order-end-total-value">
                                <div class="order-end-price-bonus">
                                    500
                                    <span class="icon">
        									<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
												<circle cx="13" cy="13" r="13" fill="#FE9D56"/>
												<path d="M19.9537 14.8235C19.9537 15.4501 19.8381 16.0029 19.6113 16.468C19.3865 16.9267 19.0833 17.3191 18.707 17.6367C18.3434 17.9436 17.9193 18.1927 17.4454 18.3756C16.9991 18.5477 16.5242 18.6824 16.0355 18.7765C15.5542 18.8685 15.0612 18.9294 14.5714 18.9572C14.0933 18.9861 13.6322 19 13.1996 19C12.0632 19 10.9935 18.9038 10.0214 18.7145C9.05347 18.5253 8.1831 18.2868 7.43571 18.0035L7.07315 17.8655V13.8248L7.90323 14.2899C8.60079 14.6791 9.40967 14.9903 10.3087 15.2116C11.214 15.4351 12.1978 15.5484 13.2325 15.5484C13.8399 15.5484 14.3361 15.5164 14.7071 15.4544C15.146 15.3795 15.3877 15.294 15.5128 15.2352C15.6983 15.1485 15.7439 15.0887 15.745 15.0887C15.762 15.0619 15.7704 15.0438 15.7736 15.0341C15.7694 15.032 15.7577 15.0192 15.7365 15.0021C15.6591 14.9379 15.5096 14.8417 15.2351 14.7433C14.9775 14.6503 14.6668 14.5626 14.3149 14.4824C13.9449 14.399 13.5505 14.3145 13.135 14.2311C12.7109 14.1456 12.2752 14.0526 11.8268 13.9542C11.3656 13.8515 10.9129 13.7296 10.4793 13.5917C10.0383 13.4516 9.61322 13.2848 9.21779 13.0966C8.8001 12.8978 8.42587 12.6572 8.10677 12.3824C7.77071 12.0915 7.50144 11.7494 7.30532 11.3655C7.10283 10.9667 7 10.5058 7 9.99581C7 9.41413 7.10707 8.89768 7.31698 8.46143C7.5237 8.03052 7.80782 7.65841 8.16084 7.35475C8.50114 7.06177 8.89763 6.82226 9.3397 6.64155C9.75633 6.47047 10.2016 6.33575 10.6627 6.24165C11.1133 6.1497 11.5755 6.08554 12.0356 6.05132C12.4883 6.01711 12.924 6 13.33 6C13.7785 6 14.247 6.02352 14.722 6.06843C15.1916 6.11334 15.6634 6.1775 16.1213 6.25983C16.574 6.34002 17.0203 6.43519 17.4497 6.54211C17.8737 6.64904 18.2734 6.76238 18.6381 6.88107L19.025 7.00724V10.9303L18.2215 10.5358C18.0285 10.4406 17.7624 10.3283 17.4317 10.2032C17.1041 10.0792 16.7246 9.95945 16.3047 9.84718C15.886 9.73491 15.4238 9.63974 14.9308 9.56383C14.4442 9.48898 13.9385 9.45155 13.4276 9.45155C13.013 9.45155 12.6558 9.46439 12.3664 9.49005C12.0823 9.51571 11.8437 9.54886 11.6571 9.58735C11.4504 9.63012 11.3402 9.67182 11.284 9.69748C11.266 9.70604 11.2511 9.71352 11.2373 9.72101C11.3243 9.77875 11.4695 9.85466 11.7017 9.93379C11.9646 10.0225 12.2763 10.1091 12.6303 10.1893C13.0035 10.2738 13.3989 10.3604 13.8166 10.4502C14.2417 10.5411 14.6796 10.6406 15.1312 10.7486C15.5945 10.8587 16.0493 10.9891 16.4828 11.1367C16.927 11.2864 17.3532 11.4639 17.7476 11.6628C18.1631 11.8723 18.5352 12.1226 18.8533 12.4059C19.1883 12.7053 19.4565 13.0549 19.6505 	13.4463C19.8519 13.8526 19.9537 14.3156 19.9537 14.8235Z" fill="white"/>
											</svg>
        								</span>
                                </div>
                            </div>
                        </div>
                        */?>
                        <?/*
                        <div class="order-end-total-line">
                            <div class="order-end-total-key">
                                Знижка статусу <a href="#">“Діва”</a>
                            </div>
                            <div class="order-end-total-value">
                                -10%
                            </div>
                        </div>
                        <div class="order-end-total-line">
                            <div class="order-end-total-key">
                                Нараховано стімзів
                            </div>
                            <div class="order-end-total-value">
                                150
                            </div>
                        </div>
                        <div class="order-end-total-line">
                            <div class="order-end-total-key">
                                Загальна кількість стімзів після покупки
                            </div>
                            <div class="order-end-total-value">
                                1650
                            </div>
                        </div>
                        <div class="order-end-total-line total">
                            <div class="order-end-total-key">
                                Оплачено:
                            </div>
                            <div class="order-end-total-value">
                                3 999 ₴
                            </div>
                        </div>
                        */?>
                    </div>
                    <div class="order-end-text">
                        <?=LANGUAGE_ID == 'ua' ?
                            'нагадуємо про графік роботи інтернет-магазину:<br>
                                    понеділок-п\'ятниця: 9:00 - 18:00<br>
                                    субота-неділя: 10:00 - 18:00

                        <br><br> 
                        Маєш питання - пиши або зателефонуй <br>
                        <div class="order-end-text-links">
                            <a target="_blank" href="https://www.instagram.com/stimma_official/" rel="noopener noreferrer">
    								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    									<g clip-path="url(#clip0_168_11728)">
    									<path d="M14.9996 0H4.99988C2.25019 0 0 2.25019 0 4.99988V15.0001C0 17.7491 2.25019 20 4.99988 20H14.9996C17.7493 20 19.9995 17.7491 19.9995 15.0001V4.99988C19.9995 2.25019 17.7493 0 14.9996 0ZM18.3328 15.0001C18.3328 16.8376 16.8381 18.3333 14.9996 18.3333H4.99988C3.16218 18.3333 1.66671 16.8376 1.66671 15.0001V4.99988C1.66671 3.16193 3.16218 1.66671 4.99988 1.66671H14.9996C16.8381 1.66671 18.3328 3.16193 18.3328 4.99988V15.0001Z" fill="currentcolor"></path>
    									<path d="M15.4179 5.83197C16.1083 5.83197 16.6679 5.27234 16.6679 4.582C16.6679 3.89166 16.1083 3.33203 15.4179 3.33203C14.7276 3.33203 14.168 3.89166 14.168 4.582C14.168 5.27234 14.7276 5.83197 15.4179 5.83197Z" fill="currentcolor"></path>
    									<path d="M9.99988 5C7.23793 5 5 7.23818 5 9.99988C5 12.7606 7.23793 15.0002 9.99988 15.0002C12.761 15.0002 14.9998 12.7606 14.9998 9.99988C14.9998 7.23818 12.761 5 9.99988 5ZM9.99988 13.3335C8.15915 13.3335 6.66671 11.8411 6.66671 9.99988C6.66671 8.15866 8.15915 6.66671 9.99988 6.66671C11.8406 6.66671 13.333 8.15866 13.333 9.99988C13.333 11.8411 11.8406 13.3335 9.99988 13.3335Z" fill="currentcolor"></path>
    									</g>
    									<defs>
    									<clipPath id="clip0_168_11728">
    									<rect width="20" height="20" fill="currentcolor"></rect>
    									</clipPath>
    									</defs>
    								</svg>
    						</a>
                            <a href="tel:0800300068" >
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                    <path d="M15.5653 11.7424L13.3325 9.50954C12.535 8.71209 11.1794 9.0311 10.8604 10.0678C10.6211 10.7855 9.82369 11.1842 9.10599 11.0247C7.5111 10.626 5.358 8.5526 4.95927 6.87797C4.72004 6.16024 5.19851 5.36279 5.91621 5.12359C6.95289 4.80461 7.27187 3.44895 6.47442 2.65151L4.24157 0.418659C3.60362 -0.139553 2.64668 -0.139553 2.08847 0.418659L0.573324 1.93381C-0.941823 3.5287 0.732813 7.75516 4.48081 11.5032C8.2288 15.2511 12.4553 17.0056 14.0502 15.4106L15.5653 13.8955C16.1235 13.2575 16.1235 12.3006 15.5653 11.7424Z" fill="currentcolor"></path>
                                    </g>
                                    
                                </svg>
                            </a>
                        </div>
                        <br><br>' :
                            'Благодарим за заказ<br> и напоминаем о графике работы инетрнет-магазина:<br> Понедельник - Пятница: 9:00-18:00, Суббота - Воскресенье: 10:00 - 18:00
                        <br><br>Для связи: <a href="tel:0800300068" style="color:#333333;">0800300068</a><br><br>'?>
                        <!-- <a href="#" id="trigger-link-order">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35" fill="none">
                                <path d="M17.4426 32.4174C14.8225 32.4343 12.2412 31.7839 9.94178 30.5277C9.89572 30.5085 9.84631 30.4986 9.79641 30.4986C9.74652 30.4986 9.69711 30.5085 9.65105 30.5277L4.51966 31.9813C4.2056 32.0813 3.87015 32.0932 3.54979 32.0158C3.22944 31.9384 2.93643 31.7746 2.70264 31.5423C2.46885 31.3101 2.30321 31.0181 2.22376 30.6983C2.1443 30.3784 2.15405 30.0429 2.25196 29.7282L3.79283 24.5677C3.8263 24.4787 3.8263 24.3806 3.79283 24.2915C2.21693 21.4113 1.58825 18.1078 1.996 14.8501C2.40376 11.5923 3.82724 8.54571 6.06441 6.14272C8.30159 3.73972 11.2388 2.1024 14.4591 1.46315C17.6795 0.823888 21.0194 1.21517 24.0048 2.58145C26.9902 3.94774 29.4694 6.21961 31.0906 9.07463C32.7118 11.9296 33.3925 15.2227 33.0363 18.4865C32.68 21.7503 31.3048 24.819 29.1058 27.257C26.9069 29.6951 23.9959 31.3785 20.786 32.0686C19.6862 32.2972 18.566 32.4141 17.4426 32.4174ZM9.75281 28.2455C10.1844 28.2514 10.6082 28.3611 10.9884 28.5653C12.8696 29.5969 14.9703 30.1635 17.1152 30.2175C19.26 30.2716 21.3866 29.8117 23.3174 28.8761C25.2482 27.9405 26.9271 26.5565 28.2138 24.8397C29.5005 23.1229 30.3577 21.123 30.7138 19.0073C31.0699 16.8916 30.9146 14.7213 30.2607 12.6779C29.6069 10.6344 28.4736 8.77708 26.9555 7.26102C25.4373 5.74497 23.5784 4.61421 21.5341 3.96319C19.4897 3.31218 17.3193 3.15983 15.204 3.51885C13.0847 3.87095 11.0809 4.72684 9.36113 6.01452C7.6414 7.3022 6.25603 8.98402 5.32154 10.9185C4.38705 12.853 3.93077 14.9837 3.99107 17.1312C4.05136 19.2787 4.62648 21.3804 5.66804 23.2594C5.83182 23.5561 5.93539 23.8821 5.97281 24.2189C6.01023 24.5557 5.98076 24.8965 5.88609 25.2219L4.5342 29.7137L9.02598 28.3618C9.26124 28.2876 9.50614 28.2484 9.75281 28.2455Z" fill="currentcolor"/>
                                <path d="M11.6296 19.263C12.6331 19.263 13.4466 18.4495 13.4466 17.446C13.4466 16.4424 12.6331 15.6289 11.6296 15.6289C10.626 15.6289 9.8125 16.4424 9.8125 17.446C9.8125 18.4495 10.626 19.263 11.6296 19.263Z" fill="currentcolor"/>
                                <path d="M17.4421 19.263C18.4456 19.263 19.2591 18.4495 19.2591 17.446C19.2591 16.4424 18.4456 15.6289 17.4421 15.6289C16.4385 15.6289 15.625 16.4424 15.625 17.446C15.625 18.4495 16.4385 19.263 17.4421 19.263Z" fill="currentcolor"/>
                                <path d="M23.2585 19.263C24.262 19.263 25.0755 18.4495 25.0755 17.446C25.0755 16.4424 24.262 15.6289 23.2585 15.6289C22.2549 15.6289 21.4414 16.4424 21.4414 17.446C21.4414 18.4495 22.2549 19.263 23.2585 19.263Z" fill="currentcolor"/>
                                </svg>
                            </svg>
                        </a> -->
                    </div>
                </div>
                <div class="order-page-links">
                    <a href="<?=$ru?>/catalog/bonusna_shafa/" class="info-btn info-btn-black">
                        <?=LANGUAGE_ID=='ua'?'Витратити стімзи':'Потратить стимзы'?>
                    </a>
                    <a href="<?=$ru?>/" class="order-link-main">
                        <?=LANGUAGE_ID=='ua'?'На головну':'На главную'?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?
}

if($order['PAYED'] != 'Y' && !isset($_GET['SUCCESS']))
{
    if($order['PAY_SYSTEM_ID'] == 14)
    {
        ?>
        <div class="ln-base" style="text-align: center;
  font-size: 26px;
  padding: 25px 0;">Завершіть оформлення в додатку Monobank</div>
        <script>
            setInterval(function () {
                $.ajax({
                    url: '/ajax/new/get_order_status.php',
                    dataType: "json",
                    type: "POST",
                    data: {
                        order_id: <?= (int)$_GET['ORDER_ID'] ?>
                    },
                    success: function(response) {
                        if (response.status === 'Y') {
                            location.reload();
                        }
                    }
                });
            }, 2000);
        </script>
        <?
    }
    else
    {
        ?>
        <div style="text-align: center;
  font-size: 26px;
  padding: 25px 0;">Зачекайте секунду... Готуємо безпечне з’єднання для оплати.</div>
        <?
    }

}

    $show = 0;
    if($order['PAY_SYSTEM_ID'] == 3 && $xml && $_GET['ORDER_ID'] != 43900)
    {
        if(isset($_GET['SUCCESS']) && $_GET['SUCCESS'] == 'Y')
        {
            ?><div style="color:green;">Дякуємо! Ми отримали вашу оплату. Найближчим часом з вами зв'яжеться менеджер для уточнення замовлення</div><?
        }
        elseif(isset($_GET['SUCCESS']) && $_GET['SUCCESS'] == 'N')
        {
            ?><div style="color:red;">Вибачте! Ми не отримали вашу оплату. Можливо у вас недостатньо коштів на рахунку або ліміт по картці. Зверніться до вашого банку для уточнення причин.</div><?
        }
        if($order['PAYED'] != 'Y')
        {
            if(!isset($_GET['SUCCESS']))
            {
                $xml = str_replace([PHP_EOL],[''], $xml);
                $xml = preg_replace('/>\s+</', '><', $xml);
                $xml = ltrim($xml, "\r\n");

                $data = ['data' => $xml, 'sign'=>$sign];

                if($USER->IsAdmin()) {
                    $realUrl = 'https://sandbox-checkout.ipay.ua/api302';
                }else{
                    $realUrl = 'https://checkout.ipay.ua/api302';
                }

                $ch = curl_init($realUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                //curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);
//PR($response);
//PR($error);
                preg_match('/<url>(.*)<\/url>/',$response,$matches);

                if($matches[1])
                {
                    $ret = '
									<meta name="robots" content="noindex, nofollow">
									<script>
									$(document).ready(function()
									{
                                        setTimeout(function(){
                                            window.open("'.strip_tags($matches[1]).'", "_self", "noopener,noreferrer");    
                                        }, 3000);    
									})
									
									
									</script>';
                    echo $ret;exit();
                    //header('Location: ' . strip_tags($matches[1]));
                    //exit();
                }

            }
        }

    }

    //if($USER->IsAdmin()){

    if($order['PAY_SYSTEM_ID'] == 9 && $order['DELIVERY_ID'] == 14 && $prepayedXml && $_GET['ORDER_ID'] != 43900)
    {
        if(isset($_GET['SUCCESS']) && $_GET['SUCCESS'] == 'Y') {
            ?><div style="color:green;">Дякуємо! Ми отримали вашу оплату передоплати 200 грн. Менеджер зв'яжеться з вами найближчим часом.</div><?
        } elseif(isset($_GET['SUCCESS']) && $_GET['SUCCESS'] == 'N') {
            ?><div style="color:red;">Оплата передоплати 200 грн не пройшла. Будь ласка, спробуйте ще раз або зв'яжіться з нами.</div><?
        }

        if($order['PAYED'] != 'Y') {
            if(!isset($_GET['SUCCESS'])) {
                $xmlToSend = $prepayedXml;  // используем xml с предоплатой 200 грн

                $xmlToSend = str_replace([PHP_EOL], [''], $xmlToSend);
                $xmlToSend = preg_replace('/>\s+</', '><', $xmlToSend);
                $xmlToSend = ltrim($xmlToSend, "\r\n");

                $data = ['data' => $xmlToSend, 'sign' => $sign];
                //$realUrl = 'https://sandbox-checkout.ipay.ua/api302';
                if($USER->IsAdmin()){
                    $realUrl = 'https://sandbox-checkout.ipay.ua/api302';
                }else{
                    $realUrl = 'https://checkout.ipay.ua/api302';
                }
                $ch = curl_init($realUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $response = curl_exec($ch);
                curl_close($ch);

                preg_match('/<url>(.*)<\/url>/', $response, $matches);

                if($matches[1])
                {
                    $ret = '
										<meta name="robots" content="noindex, nofollow">
										<script>
										$(document).ready(function()
										{
                                            setTimeout(function(){
                                                window.open("'.strip_tags($matches[1]).'", "_self", "noopener,noreferrer");    
                                            }, 3000);    
										})
										
										
										</script>';
                    echo $ret;exit();
                    //header('Location: ' . strip_tags($matches[1]));
                    //exit();
                }
            }
        }
    }
    //}

    if($order['PAY_SYSTEM_ID'] == 14) // Частями моно
    {
        $findMonoId = $DB->Query('select * from mono where UF_ORDER_ID = ' . $orderID)->Fetch();

        function calculateSignature($storeSecret, $requestBody)
        {
            return base64_encode(hash_hmac('sha256', $requestBody, $storeSecret, true));
        }

        $products=[];

        foreach($basket as $index => $bitem)
        {
            $bItemDB = CIBlockElement::GetByID($bitem['PRODUCT_ID'])->GetNextElement()->GetProperties();
            $products[] = [
                'name'  => $bItemDB['NAME_UA']['VALUE'],
                'count' => intval($bitem['QUANTITY']),
                'sum' => intval($bitem['PRICE'])
            ];
        }

        $phone = $DB->Query('select * from b_sale_order_props_value where ORDER_ID = ' . $_GET['ORDER_ID'] . ' and ORDER_PROPS_ID = 3')->Fetch()['VALUE'];
        $phone = preg_replace('/\D/', '', $phone);
        if (preg_match('/^0\d{9}$/', $phone)) {
            $phone = '38' . $phone;
        }
        elseif (preg_match('/^\d{9}$/', $phone)) {
            $phone = '380' . $phone;
        }
        if(strpos($phone, '+') === false)
            $phone = '+'.$phone;

        $requestBody = [
            'store_order_id' => 'ORDER-'.$_GET['ORDER_ID'],
            //'client_phone'   => '+380984639566',
            //'client_phone'   => '+380961126156',
            'client_phone'   => $phone,
            'total_sum'      => intval($order['PRICE']),
            'invoice' => [
                'date'   => date('Y-m-d'),
                'number' => 'SITE-INVOICE-'.$_GET['ORDER_ID'],
                'source' => 'INTERNET',
            ],
            'available_programs' => [
                [
                    'type' => 'payment_installments',
                    'available_parts_count' => [3],
                ],
            ],
            'products' => $products,
            'result_callback' => 'https://stimma.ua/pay_result_mono/',
        ];
        $requestBody = json_encode($requestBody, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $signature = calculateSignature('8807dfd0-be80-43fb-b3ed-20749244b96b', $requestBody);

        $headers = [
            'Content-Type: application/json',
            'store-id: 3763309543_031',
            'signature: ' . $signature
        ];


        //  Нет обязательных полей
        //Для /api/order/create обычно требуются:
        //
        //invoice
        //products
        //available_programs
        //У вас в $requestBody только store_order_id, client_phone, total_sum, result_callback. Из-за этого API вернёт 400 Bad Request.

        /**  $requestBody = json_encode([
        'store_order_id' => 'MY-TEXT-01',
        'client_phone'   => '+380984639566',
        'total_sum'      => 1500.00,
        'invoice' => [
        'date'   => date('Y-m-d'),
        'number' => 'INV-001',
        'source' => 'INTERNET',
        ],
        'available_programs' => [
        [
        'type' => 'payment_installments',
        'available_parts_count' => [3, 6, 10],
        ],
        ],
        'products' => [
        [
        'name'  => 'Товар',
        'count' => 1,
        'sum'   => 1500.00,
        ],
        ],
        'result_callback' => 'https://stimma.ua/pay_result_mono/',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $signature = calculateSignature('8807dfd0-be80-43fb-b3ed-20749244b96b', $requestBody);

        $headers = [
        'Content-Type: application/json',
        'store-id: 3763309543_031',
        'signature: ' . $signature,
        ];

        $ch = curl_init('https://u2.monobank.com.ua/api/order/create');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
        echo 'cURL error: ' . curl_error($ch);
        } else {
        echo 'HTTP: ' . $httpCode . "\n";
        echo '<pre>' . print_r($response, true) . '</pre>';
        }

        curl_close($ch); $ch */



        //$ch = curl_init('https://api.monobank.ua/api/merchant/order/create');
        //$ch = curl_init('https://api.monobank.ua/api/order/create');
        //$ch = curl_init('https://u2-demo-ext.mono.st4g3.com'); // - тестовий
        $ch = curl_init('https://u2.monobank.com.ua/api/order/create'); // - бойовий
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
        $response = curl_exec($ch);
        $response = json_decode($response);

        if(!isset($findMonoId['ID']))
        {
            $monoId = $response->order_id;
            $DB->Query('insert into mono (UF_ORDER_ID,UF_MONO_ID,UF_PHONE) values ('.$orderID.', \''.$monoId.'\', \''.$phone.'\')');
        }

        Bitrix\Main\Diag\Debug::writeToFile(var_export($response, 1), 'RESPONSE MONOBANK CONFIRM', '/_debug_pay_monobank.txt');

        //echo curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        // {"errCode":"BAD_REQUEST","errText":"Missing required header 'X-Token'","errorDescription":"Missing required header 'X-Token'"}
    }

    if($order['PAY_SYSTEM_ID'] == 15) // Частями приват
    {
        $storeId = 'CAD9933E2C5D4A54BCF4';
        $password = 'a6fdc3b0e8bc4da48ec7a0b1d887f908';
        //$storeId = '4AAD1369CF734B64B70F'; // - Тестові
        //$password = '75bef16bfdce4d0e9c0ad5a19b9940df'; // - Тестові
        $baseUrl = 'https://payparts2.privatbank.ua/ipp/v2';
        $responseUrl = 'https://stimma.ua/pay_result_pb/';
        $redirectUrl = 'https://stimma.ua/order/?ORDER_ID=' . $order['ID'] . '&SUCCESS=Y';

        // Преобразует 1500.00 → 150000 (убирает плавающую точку)
        function withoutFloatingPoint($amount) {
            return (string) round($amount * 100);
        }

        // Собирает строку товаров для сигнатуры: name + count + priceWithoutFloatingPoint
        function buildProductsString($products) {
            $string = '';
            foreach ($products as $product) {
                $string .= $product['name'];
                $string .= (string) $product['count'];
                $string .= withoutFloatingPoint($product['price']);
            }
            return $string;
        }

        // Сигнатура запроса на создание платежа
        function calculateSignature(
            $password,
            $storeId,
            $orderId,
            $amount,
            $partsCount,
            $merchantType,
            $responseUrl,
            $redirectUrl,
            $products
        ) {
            $string = $password
                      . $storeId
                      . $orderId
                      . withoutFloatingPoint($amount)
                      . $partsCount
                      . $merchantType
                      . $responseUrl
                      . $redirectUrl
                      . buildProductsString($products)
                      . $password;

            return base64_encode(sha1($string, true));
        }

        // Универсальная проверка сигнатуры ответа/колбэка
        function verifySignature($expected, $actual) {
            return hash_equals($expected, $actual);
        }

        // Универсальный POST-запрос
        function sendPost($url, $payload) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_UNICODE));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Accept-Encoding: UTF-8',
                'Content-Type: application/json; charset=UTF-8',
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                throw new Exception('cURL error: ' . $error);
            }

            $decoded = json_decode($response, true);

            if ($httpCode >= 400 || ($decoded['state'] ?? '') === 'FAIL') {
                throw new Exception(
                    'PrivatBank error. HTTP ' . $httpCode . ': ' . $response
                );
            }

            return $decoded;
        }
        $orderId = 'ORDER-' . $orderID;
        $amount  = $order['PRICE'];
        $partsCount = 3; // от 2 до 25
        $merchantType = 'PP'; // PP — Оплата частями
        $products=[];

        foreach($basket as $index => $bitem)
        {
            $bItemDB = CIBlockElement::GetByID($bitem['PRODUCT_ID'])->GetNextElement()->GetProperties();
            $products[] = [
                'name'  => $bItemDB['NAME_UA']['VALUE'],
                'count' => round($bitem['QUANTITY']),
                'price' => round($bitem['PRICE'])
            ];
        }


        $signature = calculateSignature(
            $password,
            $storeId,
            $orderId,
            $amount,
            $partsCount,
            $merchantType,
            $responseUrl,
            $redirectUrl,
            $products
        );

        $payload = [
            'storeId'     => $storeId,
            'orderId'     => $orderId,
            'amount'      => $amount,
            'partsCount'  => $partsCount,
            'merchantType'=> $merchantType,
            //'scheme'      => 1111,
            'products'    => $products,
            'responseUrl' => $responseUrl,
            'redirectUrl' => $redirectUrl,
            'signature'   => $signature,
        ];

        try {
            $result = sendPost($baseUrl . '/payment/create', $payload);
            Bitrix\Main\Diag\Debug::writeToFile('start', '------------------', '/_debug_pay_PRIVAT.txt');
            Bitrix\Main\Diag\Debug::writeToFile(var_export($products, 1), 'PRODUCTS', '/_debug_pay_PRIVAT.txt');
            Bitrix\Main\Diag\Debug::writeToFile($signature, 'SIGNATURE', '/_debug_pay_PRIVAT.txt');
            Bitrix\Main\Diag\Debug::writeToFile(var_export($payload, 1), 'PAYLOAD', '/_debug_pay_PRIVAT.txt');
            Bitrix\Main\Diag\Debug::writeToFile(var_export($result, 1), 'RESPONSE PRIVAT CONFIRM.PHP', '/_debug_pay_PRIVAT.txt');
            Bitrix\Main\Diag\Debug::writeToFile('end', '------------------', '/_debug_pay_PRIVAT.txt');

            // Проверяем сигнатуру ответа


            $expectedResponseSignature = base64_encode(sha1(
                                                           $password
                                                           . $result['state']
                                                           . $result['storeId']
                                                           . $result['orderId']
                                                           . $result['token']
                                                           . $password,
                                                           true
                                                       ));


            if (!verifySignature($expectedResponseSignature, $result['signature'])) {
                throw new Exception('Невірний підпис відповіді');
            }

            $token = $result['token'];

            $paymentUrl = $baseUrl . '/payment?token=' . urlencode($token);
            // Редирект клиента на страницу оплаты
            //header('Location: ' . $paymentUrl);

            $ret = '
									<meta name="robots" content="noindex, nofollow">
									<script>
									$(document).ready(function()
									{
                                        setTimeout(function(){
                                            window.open("'.strip_tags($paymentUrl).'", "_self", "noopener,noreferrer");    
                                        }, 3000);    
									})
									
									
									</script>';
            echo $ret;exit();

        }
        catch (Exception $e)
        {
            /*?><pre>$result 2 <?=print_r($result, 1)?></pre><?
            die('Помилка: ' . $e->getMessage());*/
        }
    }
    ?>


<? endif ?>

        <?
        $APPLICATION->AddChainItem('Каталог', '/catalog/zhenskaya_odezhda/');
        if(LANGUAGE_ID == 'ua')
            $APPLICATION->AddChainItem('Оформлення замовлення', '');
        else
            $APPLICATION->AddChainItem('Оформление заказа', '');
        ?>

