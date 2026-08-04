<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;



CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

$users = file_get_contents('php://input');
$users = json_decode($users);

$users = (array)$users;

Bitrix\Main\Diag\Debug::writeToFile($users, "start get order " , '/___1c_user_history.txt');



