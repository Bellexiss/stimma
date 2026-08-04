<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');
global $DB;

$res = $DB->Query("select * from payments where UF_ORDER_ID='33304'");
while ($record = $res->Fetch())
    PR($record);