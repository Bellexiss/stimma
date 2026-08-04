<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

// обнулить кількість перед початком



$products = file_get_contents('php://input');
$products = json_decode($products);
Bitrix\Main\Diag\Debug::writeToFile((array)$products, "start get order " , '/log_1c/___old_kasta_quantity'.uniqid().'.txt');