<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

$xml = $_POST['xml'];

Bitrix\Main\Diag\Debug::writeToFile(var_export($xml, true), 'RESPONSE XML', '/_debug_pay.txt');

preg_match('/{"dogovor":([0-9]+)}/',$xml,$matches);
preg_match('/<bnk_error>(.*)<\/bnk_error>/',$xml,$matches2);

if(empty(trim($matches2[1])) && $matches[1] > 0)
{
    global $DB;
    Bitrix\Main\Diag\Debug::writeToFile(var_export($matches, 1), "NOT ERROR FOR " . $matches[1] , '/debug_pay.txt');
    CSaleOrder ::PayOrder($matches[1], 'Y');
    $DB->Query('update b_sale_order set PAYED = \'Y\' where ID = ' . $matches[1]);
    $DB -> Query('insert into payments (UF_ORDER_ID,UF_DATA,UF_TO_1C) values('.$matches[1].', \''.$xml.'\',0)');
}
else
    Bitrix\Main\Diag\Debug::writeToFile(var_export($matches, 1), "ERROR FOR " . $matches[1] , '/debug_pay.txt');

die();


//\Bitrix\Main\Diag\Debug::writeToFile($_REQUEST, '_data', 'try_pay.txt');
$data = $_REQUEST['data'];
//\Bitrix\Main\Diag\Debug::writeToFile($data, '_data', 'try_pay.txt');
$data = json_decode(base64_decode($data));
//\Bitrix\Main\Diag\Debug::writeToFile($data, '_data', 'try_pay.txt');

$orderID = $data -> order_id;
global $DB;

if ($data -> status == 'wait_accept' || $data -> status == 'success')
{
    CSaleOrder::Update($orderID, array("PAYED" => "Y"/*, 'STATUS_ID'=>'P'*/));
    $DB->Query('update b_sale_order set PAYED = \'Y\' where ID = ' . $orderID);
    $DB -> Query('insert into payments (UF_ORDER_ID,UF_DATA,UF_TO_1C) values('.$orderID.', \''.$_REQUEST['data'].'\',0)');
}
else
    $DB -> Query('insert into payments (UF_ORDER_ID,UF_TO_1C) values('.$orderID.',0)');
