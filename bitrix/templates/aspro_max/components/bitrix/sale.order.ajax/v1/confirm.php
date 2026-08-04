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
padding-bottom: 40px;
max-width: 800px !important;
margin: 0 auto !important;
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
    <script>
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
    </script>
    <?
?>
    <div class="row nasa-order-received">
        <div class="large-12 columns nasa-order-received-left" style="width: 100%;">
            <div class="nasa-warper-order margin-bottom-20">
                <p class="woocommerce-thankyou-order-received"><?=LANGUAGE_ID == 'ua' ?
                '<span style="font-size: 19px;color:black;">Поки ми опрацьовуємо замовлення, у нас для вас є</span>  <a href="/pro-nas/doglyad/" style="color:#3D441D;font-size:19px;text-decoration: underline;">дещо цікавеньке</a>'
                :
                '<span style="font-size: 19px;color:black;">Пока мы обрабатываем Ваш заказ, у нас для Вас есть</span> <a href="/pro-nas/doglyad/" style="color:#3D441D;font-size:19px;text-decoration: underline;">кое-что интересное.</a>'?></p>
                <ul class="woocommerce-thankyou-order-details order_details">
                    <li class="order">
                        <?=LANGUAGE_ID == 'ua' ? 'Номер замовлення' : 'Номер заказа'?>: <strong><?=$arResult["ORDER"]['ID']?></strong>
                    </li>
                    <li class="date">
                        <?=LANGUAGE_ID == 'ua' ? 'Дата' : 'Дата'?>: <strong><?=date('d.m.Y', $arResult['ORDER']['DATE_INSERT']->getTimestamp())?></strong>
                    </li>
                    <li class="total">
                        <?=LANGUAGE_ID == 'ua' ? 'Сума' : 'Сумма'?>: <strong><span class="woocommerce-Price-amount amount"><bdi><?=FormatCurrency($arResult['ORDER']['PRICE'], 'UAH')?></bdi></span></strong>
                    </li>
                    <li class="method">
                        <?=LANGUAGE_ID == 'ua' ? 'Платіж' : 'Платеж'?>: <strong><?=$payment['NAME']?></strong>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <div class="large-12 columns nasa-order-received-right" style="width: 100%;">
            <div class="nasa-warper-order">
                <?/*<script>(window.b24order=window.b24order||[]).push({id: "188993", sum: "<span class="woocommerce-Price-amount amount"><bdi>1199&nbsp;<span class="woocommerce-Price-currencySymbol">&#x433;&#x440;&#x43D;.</span></bdi></span>"});</script>*/?>
                <p style="color: #3D441D">
                <?=LANGUAGE_ID == 'ua' ?
                'Пам’ятайте! Посмішка додасть +100 балів до вашого луку😉'
                :
                'Помните! Улыбка всегда добавит +100 баллов твоему луку😉'?>
                </p>

                <section class="woocommerce-order-details">

                    <h2 class="woocommerce-order-details__title"><?=LANGUAGE_ID == 'ua' ? 'Інформація про замовлення' : 'Информация о заказе'?></h2>
                    <div style="text-align: center;"><?=LANGUAGE_ID == 'ua' ? 'Очікуйте на дзвінок менеджера протягом дня (до 18:00)' : 'Ожидайте на звонок менеджера на протяжении дня (до 18:00)'?></div>

                    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details" style="width: 100%">

                        <thead>
                        <tr>
                            <th class="woocommerce-table__product-name product-name"><?=LANGUAGE_ID == 'ua' ? 'Товар' : 'Товар'?></th>
                            <th class="woocommerce-table__product-table product-total"><?=LANGUAGE_ID == 'ua' ? 'Всього' : 'Итого'?></th>
                        </tr>
                        </thead>

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
                        <tr>
                            <th scope="row"><?=LANGUAGE_ID == 'ua' ? 'Спосіб оплати' : 'Способ оплаты:'?></th>
                            <td style="text-align: right"><?=$payment['NAME']?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?=LANGUAGE_ID == 'ua' ? 'Всього:' : 'Всего:'?></th>
                            <td style="text-align: right"><span class="woocommerce-Price-amount amount" style="color:#8B0000;"><?=FormatCurrency($arResult['ORDER']['PRICE'], 'UAH')?></span></td>
                        </tr>
                        </tfoot>
                    </table>

                </section>
        </div>
    </div>


<?/*
	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ORDER_SUC", array(
					"#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
					"#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
				))?>
				<? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
					<?=Loc::getMessage("SOA_PAYMENT_SUC", array(
						"#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
					))?>
				<? endif ?>
				<? if ($arParams['NO_PERSONAL'] !== 'Y'): ?>
					<br /><br />
					<?=Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']])?>
				<? endif; ?>
			</td>
		</tr>
	</table>
	*/?>

	<?
	/*
	if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
	{
		if (!empty($arResult["PAYMENT"]))
		{
			foreach ($arResult["PAYMENT"] as $payment)
			{
				if ($payment["PAID"] != 'Y')
				{
					if (!empty($arResult['PAY_SYSTEM_LIST'])
						&& array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
					)
					{
						$arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

						if (empty($arPaySystem["ERROR"]))
						{
							?>
							<br /><br />

							<table class="sale_order_full_table">
								<tr>
									<td class="ps_logo">
										<div class="pay_name"><?=Loc::getMessage("SOA_PAY") ?></div>
										<?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?>
										<div class="paysystem_name"><?=$arPaySystem["NAME"] ?></div>
										<br/>
									</td>
								</tr>
								<tr>
									<td>
										<? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
											<?
											$orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
											$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
											?>
											<script>
												window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
											</script>
										<?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?>
										<? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
										<br/>
											<?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?>
										<? endif ?>
										<? else: ?>
											<?=$arPaySystem["BUFFERED_OUTPUT"]?>
										<? endif ?>
									</td>
								</tr>
							</table>

							<?
						}
						else
						{
							?>
							<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
							<?
						}
					}
					else
					{
						?>
						<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
						<?
					}
				}
			}
		}
	}
	else
	{
		?>
		<br /><strong><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></strong>
		<?
	}
    */
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