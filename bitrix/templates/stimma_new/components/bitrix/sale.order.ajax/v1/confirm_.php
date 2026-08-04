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

    /*global $USER;
    if($USER->IsAdmin()){*/
        //$merchant_id = '15740';
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

                            preg_match('/<url>(.*)<\/url>/',$response,$matches);

                            if($matches[1])
                            {
                                header('Location: ' . strip_tags($matches[1]));
                                exit();
                            }

                        }
                    }

                }

                //if($USER->IsAdmin()){

                    if($order['PAY_SYSTEM_ID'] == 9 && $order['DELIVERY_ID'] == 14) {
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

                                if($matches[1]) {
                                    header('Location: ' . strip_tags($matches[1]));
                                    exit();
                                }
                            }
                        }
                    }
                //}
                ?>


            </div>
        </div>
    </div>

        <?
        //if(isset($_GET['add']))
        {
            $params = [
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

