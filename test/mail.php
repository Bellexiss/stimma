<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stimma_mail/header.php';

/*
?>
    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
        <td style="box-sizing: border-box; padding:0px 0; margin: 0; ">
            <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; " width="100%">
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; margin: 0; padding:20px 0; font-size: 22px; font-weight: 700; text-align: center;">
                        Дякуємо, що приєдналася до STIMMA 💛
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box;  margin: 0; padding:20px 0; font-size: 16px; font-weight: 700; text-align: center;">
                        Для першого замовлення ми підготували промокод:
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding:30px 0; margin: 0; font-size: 22px; font-weight: 700; color: #9ca848; text-transform: uppercase; text-align: center;">
                        #COUPON#
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style=" box-sizing: border-box; padding:20px 0; margin: 0; font-size: 18px; font-weight: 700; text-align: center;">
                        Щоб активувати його, підтвердь email за посиланням нижче
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding:20px 0; margin: 0; text-align: center;">
                        <a href="#VERIFICATION_LINK#" style="box-sizing: border-box; margin: 0; padding: 7px 10px; font-size: 20px; text-decoration: none; text-transform: uppercase; border-radius: 50px; color: #ffffff; background: #9ca848;">
                            ПІДТВЕРДИТИ EMAIL
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
        <td style="box-sizing: border-box; padding:30px 0; margin: 0; text-align: center; font-size: 20px; font-weight: 700; border-top: 1px solid #000000;">
           Після підтвердження можеш використати промокод під час оформлення замовлення
        </td>
    </tr>
<?
*/
/*
?>
    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
            <td style="box-sizing: border-box; padding:30px 0; margin: 0; font-size: 22px; font-weight: 700; text-align: center; border-bottom: 1px solid #000000;">
                Ми отримали запит на відновлення пароля до твого акаунту STIMMA
            </td>
        </tr>
        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
            <td style="box-sizing: border-box; padding:30px 0; margin: 0; text-align: center; font-size: 20px; font-weight: 700; border-bottom: 1px solid #000000;">
                Щоб створити новий пароль, перейди за посиланням нижче
            </td>
        </tr>
        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
            <td style="box-sizing: border-box; padding:30px 0; margin: 0; text-align: center; border-bottom: 1px solid #000000;">
                <a href="#" style="box-sizing: border-box; margin: 0; padding: 7px 10px; font-size: 20px; text-decoration: none; text-transform: uppercase; border-radius: 50px; color: #ffffff; background: #9ca848;">
                    ЗМІНИТИ ПАРОЛЬ
                </a>
            </td>
        </tr>
        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
            <td style="box-sizing: border-box; padding:30px 0; margin: 0; text-align: center; font-size: 20px; font-weight: 700;">
                Якщо це була не ти, просто проігноруй цей лист. Пароль залишиться без змін.
            </td>
        </tr>
<?
*/
sendNewEmailToClient(47699);
/*?>
    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
        <td style="box-sizing: border-box; padding: 0; margin: 0;">
            <table class="table-body" style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding: 20px 10px;" width="100%">
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Привіт ✨</h2>
                    </td>
                </tr>

                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;font-weight: normal;">
                            Ти додала речі до корзини в STIMMA, але не встигла оформити замовлення.
                            Ми зберегли їх для тебе — вони все ще чекають 💛
                        </h3>
                        <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;font-weight: normal;">
                            Можливо, ти просто відволіклась.
                            А можливо — це саме той знак повернутися й завершити покупку.
                        </h3>
                        <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;font-weight: normal;">
                            Якщо маєш запитання — ми завжди поруч.
                        </h3>
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <?
                        $amount = 0;
                        foreach ($items as $index => $item)
                        {
                            $idimg=false;
                            if($item['PRODUCT']['IBLOCK_ID'] == 25)
                            {
                                $product = CIBlockElement::GetList([], ['IBLOCK_ID'=>25,'ID'=>$item['UF_PRODUCT_ID']],false,false,['ID','IBLOCK_ID','PROPERTY_CML2_LINK'])->Fetch();
                                $mainPRoduct = CIBlockElement::GetByID($product['PROPERTY_CML2_LINK_VALUE'])->Fetch();
                                $idimg = $mainPRoduct['PREVIEW_PICTURE'] ? $mainPRoduct['PREVIEW_PICTURE'] : $mainPRoduct['DETAIL_PICTURE'];
                            }
                            else
                                $idimg = $item['PRODUCT']['PREVIEW_PICTURE'] ? $item['PRODUCT']['PREVIEW_PICTURE'] : $item['PRODUCT']['DETAIL_PICTURE'];

                            $file = \CFile::GetFileArray($idimg)['SRC'];
                            $amount += $item['BASKET']['PRICE']*$item['BASKET']['QUANTITY'];
                            $titleUA = CIBlockElement::GetProperty(25, $item['PRODUCT']['ID'], array("sort" => "asc"), Array("CODE"=>"NAME_UA"))->Fetch()['VALUE'];
                            ?>
                            <table class="table-list-item" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-bottom: 10px; padding-top: 10px; border-bottom: 1px solid #333333;" width="100%">
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td class="table-list-item-img" style="box-sizing: border-box; padding: 0; margin: 0; padding-right: 15px;">
                                        <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0;">
                                            <img src="https://stimma.ua<?=$file?>" style="box-sizing: border-box; padding: 0; margin: 0; max-width: 100px;">
                                        </a>
                                    </td>
                                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                        <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000;" width="100%">
                                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <td class="table-list-item-name" colspan="2" style="box-sizing: border-box; padding: 0; margin: 0; padding-bottom: 30px;">
                                                    <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0; color: #000000; font-size: 16px; text-decoration: none; font-weight: bold;"><?=$titleUA?></a>
                                                </td>
                                            </tr>
                                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <td class="table-list-item-number" style="box-sizing: border-box; padding: 0; margin: 0; text-align: right; font-size: 16px;" align="right">
                                                    <?=FormatCurrency($item['BASKET']['PRICE'], 'UAH')?> x <?=intval($item['BASKET']['QUANTITY'])?> шт
                                                </td>
                                                <td class="table-list-item-price" style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold; text-align: right;" align="right">
                                                    <?=FormatCurrency($item['BASKET']['PRICE']*$item['BASKET']['QUANTITY'], 'UAH')?>
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
*/
?>

   <?/* <tr style="box-sizing: border-box; padding: 0; margin: 0;">
        <td style="box-sizing: border-box; padding:0px 0; margin: 0; ">
            <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; " width="100%">
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; margin: 0; padding:20px 0; font-size: 22px; font-weight: 700; text-align: center;">
                        Ви оплатили замовлення на сайті STIMMA
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box;  margin: 0; padding:20px 0; font-size: 16px; font-weight: 700; text-align: center;">
                        Замовлення #ORDER_ID# від #ORDER_DATE# оплачено.
                    </td>
                </tr>

            </table>
        </td>
    </tr>*/?>

<?/*
    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
        <td style="box-sizing: border-box; padding:0px 0; margin: 0; ">
            <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; " width="100%">
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; margin: 0; padding:20px 0; font-size: 22px; font-weight: 700; text-align: center;">
                        #NAME# #LAST_NAME#,
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; margin: 0; padding:20px 0; font-size: 22px; font-weight: 700; text-align: center;">
                        #MESSAGE#
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box;  margin: 0; padding:20px 0; font-size: 16px; font-weight: 700; text-align: center;">
                        Для зміни паролю перейдіть за посиланням:<br>
                        http://#SERVER_NAME#/auth/forgot/?forgot-password=yes&USER_CHECKWORD=#CHECKWORD#&USER_EMAIL=#USER_EMAIL#
                    </td>
                </tr>

            </table>
        </td>
    </tr>
*/?>

<?
require $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stimma_mail/footer.php';
