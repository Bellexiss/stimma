<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;


CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

$user = file_get_contents('php://input');
$user = json_decode($user);

$user = (array)$user; 

Bitrix\Main\Diag\Debug::writeToFile($user, "start get order " , '/log_1c/___user_status.txt');



