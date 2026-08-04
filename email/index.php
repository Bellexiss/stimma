<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stimma_mail/header.php';

global $DB;


die();
$id = 2860;

sendNewEmailToClient(2860);
die();

$orderRecord = $DB -> Query('select * from b_sale_order where ID = ' . $id)->Fetch();
global $DB;

$res = $DB -> Query('select * from b_sale_basket where ORDER_ID = '.$id);
while ($record = $res -> Fetch())
{
    $record['PRODUCT'] = \CIBlockElement::GetByID($record['PRODUCT_ID']) -> GetNext();
    //            /if ($arItem['PROPERTIES']['NAME_'.UPPER_LANGUAGE_ID]['VALUE']) $arItem['NAME'] = $arItem['PROPERTIES']['NAME_'.UPPER_LANGUAGE_ID]['VALUE'];

    $record['PRODUCT']['NAME'] = CIBlockElement::GetProperty(35, $record['PRODUCT_ID'], '','', ['CODE' => 'NAME_UA']) -> Fetch()["VALUE"];
    $record['NAME'] = $record['PRODUCT']['NAME'];
    $arBasket[] = $record;
}

$email = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and ORDER_PROPS_ID = 2') -> Fetch()['VALUE'];
$name = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and (ORDER_PROPS_ID = 1 or ORDER_PROPS_ID = 22)');
while ($names = $name -> Fetch())
{
    if($names['VALUE'])
    {
        $name = $names['VALUE'];
        break;
    }
}

if(!$email)
{
    $orderRecord = $DB -> Query('select * from b_sale_order where ID = '.$id) -> Fetch();
    $user = \CUser::GetByID($orderRecord['USER_ID']) -> Fetch();
    $email = $user['EMAIL'];
}

ob_start();
?>
    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
        <td style="box-sizing: border-box; padding: 0; margin: 0;">
            <table class="table-body" style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding: 20px 10px;" width="100%">
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <?/*<h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Доброго дня<?=$name ? ', '.$name : '!'?></h2>*/?>
                        <h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Дякуємо за замовлення !</h2>
                    </td>
                </tr>
                <?/*<tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <p class="table-body-text" style="box-sizing: border-box; padding: 0; margin: 0;  padding-bottom: 10px;font-style: italic;">
                            Привіт, подружко!
                        </p>
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <p class="table-body-text" style="box-sizing: border-box; padding: 0; margin: 0;  padding-bottom: 10px;">
                            Ми вже працюємо над твоїм замовленням. Зовсім скоро ми зателефонуємо для уточнення деталей.
                        </p>
                    </td>
                </tr>*/?>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;">
                            Зовсім скоро ми зателефонуємо для уточнення деталей.
                        </h3>
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <?
                        $amount = 0;
                        foreach ($arBasket as $index => $item)
                        {
                            $idimg = $item['PRODUCT']['PREVIEW_PICTURE'] ? $item['PRODUCT']['PREVIEW_PICTURE'] : $item['PRODUCT']['DETAIL_PICTURE'];
                            $file = \CFile::GetFileArray($idimg)['SRC'];
                            $amount += $item['PRICE']*$item['QUANTITY'];
                            $titleUA = CIBlockElement::GetProperty(25, $item['PRODUCT']['ID'], array("sort" => "asc"), Array("CODE"=>"NAME_UA"))->Fetch()['VALUE'];
                            ?>
                            <table class="table-list-item" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-bottom: 10px; padding-top: 10px; border-bottom: 1px solid #333333;" width="100%">
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td class="table-list-item-img" style="box-sizing: border-box; padding: 0; margin: 0; padding-right: 15px;">
                                        <a href="https://www.stimma.com.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0;">
                                            <img src="https://www.stimma.com.ua/upload/resize_cache/iblock/87b/118_181_1/a54ibj6w24t2etn3e5rgnlyuhph1t0wl.jpg<?/*https://www.stimma.com.ua<?=$file?>*/?>" style="box-sizing: border-box; padding: 0; margin: 0; max-width: 100px;">
                                        </a>
                                    </td>
                                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                        <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000;" width="100%">
                                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <td class="table-list-item-name" colspan="2" style="box-sizing: border-box; padding: 0; margin: 0; padding-bottom: 30px;">
                                                    <a href="https://www.stimma.com.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0; color: #000000; font-size: 16px; text-decoration: none; font-weight: bold;"><?=$titleUA?></a>
                                                </td>
                                            </tr>
                                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <td class="table-list-item-number" style="box-sizing: border-box; padding: 0; margin: 0; text-align: right; font-size: 16px;" align="right">
                                                    <?=FormatCurrency($item['PRICE'], 'UAH')?> x <?=intval($item['QUANTITY'])?> шт
                                                </td>
                                                <td class="table-list-item-price" style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold; text-align: right;" align="right">
                                                    <?=FormatCurrency($item['PRICE']*$item['QUANTITY'], 'UAH')?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <?
                        }
                        ?>
                        <table class="table-list-total" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-top: 30px; text-align: right; font-size: 16px;" width="100%" align="right">
                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                    Сума: <span style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold;"><?=FormatCurrency($amount,'UAH')?></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?
$html = ob_get_clean();

echo $html;

$email = 'company703@gmail.com';
//$email = 'linkevych.o.v@gmail.com';
if($email && isset($_GET['send']))
{
    $arFieldsSend = [
        'TEXT' => $html,
        'NUMBER' => $id,
        'EMAIL' => $email
    ];
    CEvent::SendImmediate("BS_SALE_NEW_ORDER", "s1", $arFieldsSend, 'Y', 102);
}

unset($_SESSION['CATALOG_USER_COUPONS']);

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stimma_mail/footer.php';