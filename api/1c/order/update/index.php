<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

$order = file_get_contents('php://input');
$order = json_decode($order);
Bitrix\Main\Diag\Debug::writeToFile((array)$order, "start get order " , '/log_1c/___order_update_status.txt');