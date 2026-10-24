<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$ua = strpos($_REQUEST['url'], '/ru/') === false;

$msg = "";

$email = trim($_GET['email']);
$code = trim($_GET['code']);

global $DB;
$res = $DB->Query('select * from subscribers where UF_EMAIL = \''.$email.'\' AND UF_COUPON='.'\''.$code.'\'');
// $res = $DB->Query('ALTER TABLE subscribers ADD COLUMN CODE TEXT');
// $res = $DB->Query('ALTER TABLE subscribers ADD COLUMN VERIFIED TEXT NULL');
if($res=$res->Fetch())
{
    $msg = $ua ? 'Ви підтвердили підписку' : 'Вы подтвердили подписку';
	$msg = 'Дякуємо, що підтвердила e-mail 🤗
Знижка 10% уже твоя! Обовʼязково скористайся нею під час наступного замовлення.';
		$DB->Query('update subscribers set UF_VERIFIED=1 where UF_EMAIL = \''.$email.'\' AND UF_COUPON='.'\''.$code.'\'');
        $findCoupon = $DB->Query('select * from b_sale_discount_coupon where COUPON = \''.$code.'\'');

        if($findCoupon = $findCoupon->Fetch())
        {
            $DB->Query('update b_sale_discount_coupon set ACTIVE = \'Y\' where ID = ' . $findCoupon['ID']);
        }
}
else
{
	$msg = $ua ? 'Помилка підтвердження підписки' : 'Ошибка подтверждения подписки';
}

?>
<div class="page_not_found">
    <div class="description">
        <div class="subtitle404">
            <?=$msg?>
        </div>
        <div class="">
            <a href="/" class="info-btn info-btn-black">
                На головну
            </a>
        </div>
    </div>
</div>


<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>