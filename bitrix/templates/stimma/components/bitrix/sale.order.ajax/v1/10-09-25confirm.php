<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>

<? if (!empty($arResult["ORDER"])): ?>
<style>
.nasa-order-received
{
max-width: 1240px !important;
margin: 0 auto !important;
padding: 0 20px 40px;
}
.column, .columns
{
padding-left: .68966em;
padding-right: .68966em;
float: left;
}
.nasa-order-received .nasa-order-received-left .nasa-warper-order
{
border: 2px dashed #3D441D;
padding: 20px;
}
.nasa-order-received .nasa-order-received-left .nasa-warper-order .woocommerce-thankyou-order-received
{
color: #7db62e;
font-size: 140%;
padding: 0 20px;
margin-bottom: 10px;
}
.nasa-order-received .nasa-order-received-left .nasa-warper-order ul.woocommerce-thankyou-order-details
{
padding-left: 20px;
margin-bottom: 10px;
}
.clear, .nasa-clear-both{clear:both}
div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, p, blockquote, th, td
{
margin: 0;
padding: 0;
direction: ltr;
}
body [class*="column"] + [class*="column"]:last-child
{
float: left ;
}
p{
font-weight: 400;
font-size: 100%;
line-height: 1.6;
margin-bottom: 1.37931em;
text-rendering: optimizeLegibility;
}
article, aside, details, figcaption, figure, footer, header, hgroup, main, nav, section, summary
{
display:block;
}
.nasa-order-received .woocommerce-order-details__title
{
text-align: center;
}
.shop_table
{
margin-top: 10px;
}
.shop_table.order_details thead
{
border-bottom: 3px solid #eee;
}
.shop_table thead tr:last-child
{
border-bottom: 2px solid #ececec;
}
.shop_table .product-name
{
padding: 0;
width: auto;
}
.shop_table.order_details .product-total
{
text-align: right;
}
table tr:last-child
{
border-bottom: 0;
}
.woocommerce-table--order-details .order_item td
{
padding-top: 10px;
padding-bottom: 10px;
}
table tr:last-child
{
border-bottom: 0;
}
.woocommerce-table--order-details tfoot tr:last-child th
{
text-transform: uppercase;
font-size: 130%;
color: #000;
}
.woocommerce-table--order-details tfoot tr:last-child td > .amount
{
font-size: 130%;
color: #f76b6a;
}
</style>
<?

$orderData = $DB -> Query('select * from b_sale_order where ID = ' . $arResult['ORDER']['ID']) -> Fetch();

$payment = CSalePaySystem::GetByID($arResult['ORDER']['PAY_SYSTEM_ID']);
$delivery = CSaleDelivery::GetByID($arResult['ORDER']['DELIVERY_ID']);
$basket = [];
$res = $DB -> Query('select * from b_sale_basket where ORDER_ID = ' . $arResult['ORDER']['ID']);
$productJson = [];
while ($record = $res -> Fetch())
{
    $basket[] = $record;

        {
           $product = $record['PRODUCT_ID'];
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
    <!--<script>
window.dataLayer = window.dataLayer || [];
dataLayer.push({
 'ecommerce': {
   'currencyCode': 'UAH',
   'purchase': {
     'actionField': {
       'id': '<?/*=$orderData['ID']*/?>',
       'affiliation': 'Online Store',
       'type': 'Покупка через корзину',
       'revenue': '<?/*=$orderData['PRICE']*/?>',
       'tax': '0',
       'shipping': '0'
     },
     'products': [<?/*=implode(',',$productJson)*/?>]
   }
 },
 'event': 'gtm-ee-event',
 'gtm-ee-event-category': 'Enhanced Ecommerce',
 'gtm-ee-event-action': 'Purchase',
 'gtm-ee-event-non-interaction': 'False',
 'dyn-rem-ids': '<?/*=$orderData['ID']*/?>',
 'dyn-rem-pagetype': 'purchase',
 'dyn-rem-value': '<?/*=$orderData['PRICE']*/?>',
});
        //sendOrder();
    </script>-->
    <?

    $order = $DB->Query('select * from b_sale_order where ID = '.$arResult['ORDER']['ID'])->Fetch();

$amount = $order['PRICE'];

$orderID = $order['ID'];
$merchant_id = '5334';
$merchant_secret = '158884b6494b43b860abd0982eedd743e964251d';

$salt = sha1(microtime(true));
$sign = hash_hmac('sha512', $salt, $merchant_secret);
$urlBack = 'https://www.stimma.com.ua/order/?ORDER_ID=';

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
                    <auto_redirect_bad>1</auto_redirect_bad>
                </urls>
                <transactions>
                    <transaction>
                        <amount>'.($amount*100).'</amount>
                        <currency>UAH</currency>
                        <desc>Оплата замовлення #'.$orderID.'</desc>
                        <info>{"dogovor":'.$orderID.'}</info>
                    </transaction>
                </transactions>
                <trademark>{"ru":"Stimma","ua":"Stimma","en":"Stimma"}</trademark>
                <lifetime>24</lifetime>
                <lang>ua</lang>
            </payment>';
    global $USER;
    if($USER->IsAdmin()){
        $merchant_id = '15740';
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
                    <auto_redirect_bad>1</auto_redirect_bad>
                </urls>
                <transactions>
                    <transaction>
                        <amount>'.(200*100).'</amount>
                        <currency>UAH</currency>
                        <desc>Оплата замовлення #'.$orderID.'</desc>
                        <info>{"dogovor":'.$orderID.'}</info>
                        <smch_id>15740</smch_id>
                    </transaction>
                </transactions>
                <trademark>{"ru":"Stimma","ua":"Stimma","en":"Stimma"}</trademark>
                <lifetime>24</lifetime>
                <lang>ua</lang>
            </payment>';
    }else{
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
                    <auto_redirect_bad>1</auto_redirect_bad>
                </urls>
                <transactions>
                    <transaction>
                        <amount>'.(200*100).'</amount>
                        <currency>UAH</currency>
                        <desc>Оплата замовлення #'.$orderID.'</desc>
                        <info>{"dogovor":'.$orderID.'}</info>
                    </transaction>
                </transactions>
                <trademark>{"ru":"Stimma","ua":"Stimma","en":"Stimma"}</trademark>
                <lifetime>24</lifetime>
                <lang>ua</lang>
            </payment>';
    }




?>
    <div class="row nasa-order-received">
        <div class="large-12  nasa-order-received-right" style="width: 100%;">
            <div class="nasa-warper-order">
                <p style="color: #3D441D">

                </p>

                <section class="woocommerce-order-details">


                    <h2 class="woocommerce-order-details__title"><?=LANGUAGE_ID == 'ua' ? 'Замовлення №'.$arResult['ORDER']['ID'] : 'Заказе №'.$arResult['ORDER']['ID']?></h2>
                    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details" style="width: 100%">

                        <tbody>
                        <?
                        foreach ($basket as $index => $item)
                        {
                            if(LANGUAGE_ID == 'ua')
                            {
                                $p = CIBlockElement::GetByID($item['PRODUCT_ID']) -> GetNextElement();
                                $props = $p -> GetProperties();
                                $item['NAME'] = $props['NAME_UA']['VALUE'];
                            }
                            ?>
                            <tr class="woocommerce-table__line-item order_item">

                            <td class="woocommerce-table__product-name product-name">
                                <?=$item['NAME']?> <strong class="product-quantity">×&nbsp;<?=intval($item['QUANTITY'])?></strong>	</td>

                            <td class="woocommerce-table__product-total product-total">
                                <span class="woocommerce-Price-amount amount"><bdi><?=FormatCurrency($item['PRICE'], 'UAH')?></bdi></span>	</td>

                            </tr>
                            <?
                        }
                        ?>

                        </tbody>

                        <tfoot>
                        <tr style="border-top:2px solid #ececec;">
                            <th scope="row"><?=LANGUAGE_ID == 'ua' ? 'Перевізник' : 'Перевозчик:'?></th>
                            <td style="text-align: right"><?=$delivery['NAME']?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?=LANGUAGE_ID == 'ua' ? 'Спосіб оплати' : 'Способ оплаты:'?></th>
                            <td style="text-align: right"><?=$payment['NAME']?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?=LANGUAGE_ID == 'ua' ? 'Всього:' : 'Всего:'?></th>
                            <td style="text-align: right"><span class="woocommerce-Price-amount amount" style="color:#333333;"><?=FormatCurrency($arResult['ORDER']['PRICE'], 'UAH')?></span></td>
                        </tr>
                        </tfoot>
                    </table>
                <div style="text-align: center;padding-top:20px;"><?=LANGUAGE_ID == 'ua' ?
                        'Дякуємо за замовлення<br> 
                        та нагадуємо про графік роботи інтернет-магазину: <br>
                        понеділок - п’ятниця: 9:00-18:00, 
                        субота: 9:00 - 15:00,
                        неділя: вихідний.
<br><br> Для зв’язку: <a href="tel:0800300068" style="color:#333333;">0800300068</a><br><br>' :
                'Благодарим за заказ<br> и напоминаем о графике работы инетрнет-магазина:<br> понедельник - пятница: 9:00-18:00, суббота: 9:00 - 15:00, воскресенье: выходной
<br><br>Для связи: <a href="tel:0800300068" style="color:#333333;">0800300068</a><br><br>'?></div>
                                </section>

                <?
                $show = 0;
                $paySystemID = (int)$order['PAY_SYSTEM_ID'];     // ID оплаты
                $deliveryID = (int)$order['DELIVERY_ID'];        // ID доставки



                if($order['PAY_SYSTEM_ID'] == 3)
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


                            $testUrl = 'https://sandbox-checkout.ipay.ua/api302';
                            $realUrl = 'https://checkout.ipay.ua/api302';

                            $ch = curl_init($realUrl);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            //curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
                            $response = curl_exec($ch);
                            $error = curl_error($ch);
                            curl_close($ch);

                            preg_match('/<url>(.*)<\/url>/',$response,$matches);

                            if($matches[1])
                            {
                                header('Location: ' . strip_tags($matches[1]));
                                exit();
                            }

                        }
                    }

                }
                // Новая логика для післяплати 200 грн (PAY_SYSTEM_ID == 9 и DELIVERY_ID == 14)

                if($order['PAY_SYSTEM_ID'] == 9 && $order['DELIVERY_ID'] == 14 && $USER->IsAdmin()) {

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
                            $realUrl = 'https://checkout.ipay.ua/api302';

                            $ch = curl_init($realUrl);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            $response = curl_exec($ch);
                            curl_close($ch);

                            preg_match('/<url>(.*)<\/url>/', $response, $matches);

                            if($matches[1]) {
                                header('Location: ' . strip_tags($matches[1]));
                                exit();
                            }
                        }
                    }
                }
                ?>


        </div>
        </div>
        <div class="slider-controls-block">
            <div class="slider-controls">
                
            </div>
        </div>
        <?
        //if(isset($_GET['add']))
        {
            $params = [
                'IBLOCK_TYPE' => 'aspro_max_catalog',
                'IBLOCK_ID' => '21',
                'ELEMENT_SORT_FIELD' => 'RAND',
                'ELEMENT_SORT_ORDER' => 'desc',
                'ELEMENT_SORT_FIELD2' => 'RAND',
                'ELEMENT_SORT_ORDER2' => 'asc',
                'PROPERTY_CODE' => [
                    0 => 'HIT',
                    1 => 'BRAND',
                    2 => 'CML2_ARTICLE',
                    3 => 'PROP_2104',
                    4 => 'PODBORKI',
                    5 => 'PROP_2033',
                    6 => 'COLOR_REF2',
                    7 => 'PROP_305',
                    8 => 'PROP_352',
                    9 => 'PROP_317',
                    10 => 'PROP_357',
                    11 => 'PROP_2102',
                    12 => 'PROP_318',
                    13 => 'PROP_159',
                    14 => 'PROP_349',
                    15 => 'PROP_327',
                    16 => 'PROP_2052',
                    17 => 'PROP_370',
                    18 => 'PROP_336',
                    19 => 'PROP_2115',
                    20 => 'PROP_346',
                    21 => 'PROP_2120',
                    22 => 'PROP_2053',
                    23 => 'PROP_363',
                    24 => 'PROP_320',
                    25 => 'PROP_2089',
                    26 => 'PROP_325',
                    27 => 'PROP_2103',
                    28 => 'PROP_2085',
                    29 => 'PROP_300',
                    30 => 'PROP_322',
                    31 => 'PROP_362',
                    32 => 'PROP_365',
                    33 => 'PROP_359',
                    34 => 'PROP_284',
                    35 => 'PROP_364',
                    36 => 'PROP_356',
                    37 => 'PROP_343',
                    38 => 'PROP_2083',
                    39 => 'PROP_314',
                    40 => 'PROP_348',
                    41 => 'PROP_316',
                    42 => 'PROP_350',
                    43 => 'PROP_333',
                    44 => 'PROP_332',
                    45 => 'PROP_360',
                    46 => 'PROP_353',
                    47 => 'PROP_347',
                    48 => 'PROP_25',
                    49 => 'PROP_2114',
                    50 => 'PROP_301',
                    51 => 'PROP_2101',
                    52 => 'PROP_2067',
                    53 => 'PROP_323',
                    54 => 'PROP_324',
                    55 => 'PROP_355',
                    56 => 'PROP_304',
                    57 => 'PROP_358',
                    58 => 'PROP_319',
                    59 => 'PROP_344',
                    60 => 'PROP_328',
                    61 => 'PROP_338',
                    62 => 'PROP_2065',
                    63 => 'PROP_366',
                    64 => 'PROP_302',
                    65 => 'PROP_303',
                    66 => 'PROP_2054',
                    67 => 'PROP_341',
                    68 => 'PROP_223',
                    69 => 'PROP_283',
                    70 => 'PROP_354',
                    71 => 'PROP_313',
                    72 => 'PROP_2066',
                    73 => 'PROP_329',
                    74 => 'PROP_342',
                    75 => 'PROP_367',
                    76 => 'PROP_2084',
                    77 => 'PROP_340',
                    78 => 'PROP_351',
                    79 => 'PROP_368',
                    80 => 'PROP_369',
                    81 => 'PROP_331',
                    82 => 'PROP_337',
                    83 => 'PROP_345',
                    84 => 'PROP_339',
                    85 => 'PROP_310',
                    86 => 'PROP_309',
                    87 => 'PROP_330',
                    88 => 'PROP_2017',
                    89 => 'PROP_335',
                    90 => 'PROP_321',
                    91 => 'PROP_308',
                    92 => 'PROP_206',
                    93 => 'PROP_334',
                    94 => 'PROP_2100',
                    95 => 'PROP_311',
                    96 => 'PROP_2132',
                    97 => 'SHUM',
                    98 => 'PROP_361',
                    99 => 'PROP_326',
                    100 => 'PROP_315',
                    101 => 'PROP_2091',
                    102 => 'PROP_2026',
                    103 => 'PROP_307',
                    104 => 'PROP_2027',
                    105 => 'PROP_2098',
                    106 => 'PROP_2122',
                    107 => 'PROP_24',
                    108 => 'PROP_2049',
                    109 => 'PROP_22',
                    110 => 'PROP_2095',
                    111 => 'PROP_2044',
                    112 => 'PROP_162',
                    113 => 'PROP_2055',
                    114 => 'PROP_2069',
                    115 => 'PROP_2062',
                    116 => 'PROP_2061',
                    117 => 'CML2_LINK',
                    118 => 'RZMER',
                ],
                'PROPERTY_CODE_MOBILE' => '',
                'META_KEYWORDS' => '',
                'META_DESCRIPTION' => '',
                'BROWSER_TITLE' => '',
                'SET_LAST_MODIFIED' => 'Y',
                'INCLUDE_SUBSECTIONS' => 'Y',
                'BASKET_URL' => '/basket/',
                'ACTION_VARIABLE' => 'action',
                'PRODUCT_ID_VARIABLE' => 'id',
                'SECTION_ID_VARIABLE' => 'SECTION_ID',
                'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
                'PRODUCT_PROPS_VARIABLE' => 'prop',
                'FILTER_NAME' => 'MAX_SMART_FILTER',
                'CACHE_TYPE' => 'N',
                'CACHE_TIME' => '3600000',
                'CACHE_FILTER' => 'Y',
                'CACHE_GROUPS' => 'Y',
                'SET_TITLE' => 'N',
                'MESSAGE_404' => '',
                'SET_STATUS_404' => 'Y',
                'SHOW_404' => 'Y',
                'FILE_404' => '',
                'DISPLAY_COMPARE' => 'Y',
                'PAGE_ELEMENT_COUNT' => '4',
                'LINE_ELEMENT_COUNT' => '4',
                'PRICE_CODE' => [0 => 'BASE',1=>'DISCOUNT',2=>'OPT'],
                'USE_PRICE_COUNT' => 'N',
                'SHOW_PRICE_COUNT' => '1',
                'PRICE_VAT_INCLUDE' => 'Y',
                'USE_PRODUCT_QUANTITY' => 'Y',
                'ADD_PROPERTIES_TO_BASKET' => 'N',
                'PARTIAL_PRODUCT_PROPERTIES' => 'Y',
                'PRODUCT_PROPERTIES' => '',
                'DISPLAY_TOP_PAGER' => 'N',
                'DISPLAY_BOTTOM_PAGER' => 'N',
                'PAGER_TITLE' => 'Товары',
                'PAGER_SHOW_ALWAYS' => 'N',
                'PAGER_TEMPLATE' => 'main',
                'PAGER_DESC_NUMBERING' => 'N',
                'PAGER_DESC_NUMBERING_CACHE_TIME' => '36000',
                'PAGER_SHOW_ALL' => 'N',
                'PAGER_BASE_LINK_ENABLE' => 'N',
                'PAGER_BASE_LINK' => null,
                'PAGER_PARAMS_NAME' => null,
                'LAZY_LOAD' => 'N',
                'MESS_BTN_LAZY_LOAD' => null,
                'LOAD_ON_SCROLL' => 'N',
                'OFFERS_CART_PROPERTIES' => '',
                'OFFERS_FIELD_CODE' => [0 => 'NAME',
                                        1 => 'CML2_LINK',
                                        2 => 'DETAIL_PAGE_URL',
                                        3 => '',],
                'OFFERS_PROPERTY_CODE' => [0 => 'ARTICLE',
                                           1 => 'SPORT',
                                           2 => 'SIZES2',
                                           3 => 'MORE_PHOTO',
                                           4 => 'VOLUME',
                                           5 => 'SIZES',
                                           6 => 'SIZES5',
                                           7 => 'SIZES4',
                                           8 => 'SIZES3',
                                           9 => 'COLOR_REF',
                                           10 => 'RAZMER',],
                'OFFERS_SORT_FIELD' => 'ID',
                'OFFERS_SORT_ORDER' => 'desc',
                'OFFERS_SORT_FIELD2' => 'sort',
                'OFFERS_SORT_ORDER2' => 'asc',
                'OFFERS_LIMIT' => '10',
                'SECTION_ID' => '352',
                'SECTION_CODE' => '',
                'SECTION_URL' => '/catalog/#SECTION_CODE_PATH#/',
                'DETAIL_URL' => '/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
                'USE_MAIN_ELEMENT_SECTION' => 'Y',
                'CONVERT_CURRENCY' => 'Y',
                'CURRENCY_ID' => 'UAH',
                'HIDE_NOT_AVAILABLE' => 'N',
                'HIDE_NOT_AVAILABLE_OFFERS' => 'N',
                'LABEL_PROP' => '',
                'LABEL_PROP_MOBILE' => null,
                'LABEL_PROP_POSITION' => null,
                'ADD_PICT_PROP' => 'MORE_PHOTO',
                'PRODUCT_DISPLAY_MODE' => 'Y',
                'PRODUCT_BLOCKS_ORDER' => 'price,props,sku,quantityLimit,quantity,buttons,compare',
                'PRODUCT_ROW_VARIANTS' => '[{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false}]',
                'ENLARGE_PRODUCT' => 'STRICT',
                'ENLARGE_PROP' => '',
                'SHOW_SLIDER' => 'Y',
                'SLIDER_INTERVAL' => '3000',
                'SLIDER_PROGRESS' => 'N',
                'OFFER_ADD_PICT_PROP' => 'MORE_PHOTO',
                'OFFER_TREE_PROPS' => [0 => 'COLOR_REF',
                                       1 => 'RAZMER',],
                'PRODUCT_SUBSCRIPTION' => 'Y',
                'SHOW_DISCOUNT_PERCENT' => 'Y',
                'DISCOUNT_PERCENT_POSITION' => null,
                'SHOW_OLD_PRICE' => 'Y',
                'SHOW_MAX_QUANTITY' => 'N',
                'MESS_SHOW_MAX_QUANTITY' => '',
                'RELATIVE_QUANTITY_FACTOR' => '',
                'MESS_RELATIVE_QUANTITY_MANY' => '',
                'MESS_RELATIVE_QUANTITY_FEW' => '',
                'MESS_BTN_BUY' => 'Купить',
                'MESS_BTN_ADD_TO_BASKET' => 'В корзину',
                'MESS_BTN_SUBSCRIBE' => 'Подписаться',
                'MESS_BTN_DETAIL' => 'Подробнее',
                'MESS_NOT_AVAILABLE' => 'Нет в наличии',
                'MESS_BTN_COMPARE' => 'Сравнение',
                'USE_ENHANCED_ECOMMERCE' => 'N',
                'DATA_LAYER_NAME' => '',
                'BRAND_PROPERTY' => '',
                'TEMPLATE_THEME' => 'blue',
                'ADD_SECTIONS_CHAIN' => 'N',
                'ADD_TO_BASKET_ACTION' => 'ADD',
                'SHOW_CLOSE_POPUP' => 'N',
                'COMPARE_PATH' => '',
                'COMPARE_NAME' => 'CATALOG_COMPARE_LIST',
                'USE_COMPARE_LIST' => 'Y',
                'BACKGROUND_IMAGE' => '-',
                'COMPATIBLE_MODE' => 'Y',
                'DISABLE_INIT_JS_IN_COMPONENT' => 'N',
                'WRAP_CLASS' => 'main-googs-list main-googs-list-order',
                'BLOCK_CLASS' => 'main-googs-item-cont',
                'CONFIRM_ORDER' => '1',
            ];
            global $MAX_SMART_FILTER;
            $MAX_SMART_FILTER = ['>CATALOG_QUANTITY' => 0];
            //$MAX_SMART_FILTER = ['ID' => ['26737']];

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                'main',
                $params,
                false
            );
        }

        ?>

        <? else: ?>

    	<b><?=Loc::getMessage("SOA_ERROR_ORDER")?></b>
    	<br /><br />

    	<table class="sale_order_full_table">
    		<tr>
    			<td>
    				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?>
    				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?>
    			</td>
    		</tr>
    	</table>

<? endif ?>

        <?
        $APPLICATION->AddChainItem('Каталог', '/catalog/zhenskaya_odezhda/');
        if(LANGUAGE_ID == 'ua')
            $APPLICATION->AddChainItem('Оформлення замовлення', '');
        else
            $APPLICATION->AddChainItem('Оформление заказа', '');
        ?>
