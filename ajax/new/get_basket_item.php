<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');


global $DB;
$fuserID = CSaleBasket::GetBasketUserID();
//$record = $DB->Query('select * from b_sale_basket where FUSER_ID = \''.$fuserID.'\' and ORDER_ID is NULL and PRODUCT_ID = ' . $_REQUEST['pid']);
$record = $DB->Query('select * from b_sale_basket where FUSER_ID = \''.$fuserID.'\' and ORDER_ID is NULL limit 1');

if($record = $record->Fetch())
    $json['status'] = 1;
else
    $json['status'] = 0;

echo json_encode($json);
?>