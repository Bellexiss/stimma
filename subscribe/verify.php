<?
use Bitrix\Sale\Internals\DiscountCouponTable;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ua = strpos($_REQUEST['url'], '/ru/') === false;

$msg = "";

$email = trim($_GET['email']);
$code = trim($_GET['code']);

global $DB;
$res = $DB->Query('select * from subscribers where UF_EMAIL = \''.$email.'\' AND CODE='.'\''.$code.'\'');
// $res = $DB->Query('ALTER TABLE subscribers ADD COLUMN CODE TEXT');
// $res = $DB->Query('ALTER TABLE subscribers ADD COLUMN VERIFIED TEXT NULL');
if($res=$res->Fetch())
{
    $msg = $ua ? 'Ви підтвердили підписку' : 'Вы подтвердили подписку';
	$msg = 'Дякуємо, що підтвердила e-mail 🤗
Знижка 10% уже твоя! Обовʼязково скористайся нею під час наступного замовлення.';
		$DB->Query('update subscribers set VERIFIED=\'Y\' where UF_EMAIL = \''.$email.'\' AND CODE='.'\''.$code.'\'');
}else{
	$msg = $ua ? 'Помилка підтвердження підписки' : 'Ошибка подтверждения подписки';
}
echo $msg;
?>