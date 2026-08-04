<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;



CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

$user_history = file_get_contents('php://input');
$user_history = json_decode($user_history);

$users = (array)$users;

Bitrix\Main\Diag\Debug::writeToFile($users, "start get order " , '/___1c_user_history.txt');



