<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');
\Bitrix\Main\Loader::includeModule('sale');

global $DB;

Bitrix\Main\Diag\Debug::writeToFile(1, "START", '/_debug_pay_PRIVAT.txt');

$password = 'a6fdc3b0e8bc4da48ec7a0b1d887f908';
$body = file_get_contents('php://input');
$data = json_decode($body, true);


if($data['paymentState'] == 'SUCCESS')
{
    Bitrix\Main\Diag\Debug::writeToFile(1, "IM IN SUCESS", '/_debug_pay_PRIVAT.txt');
    $orderId = str_replace('ORDER-','',$data['orderId']);
    Bitrix\Main\Diag\Debug::writeToFile($orderId, "ORDER_ID", '/_debug_pay_PRIVAT.txt');
    if($orderId>0)
    {
        Bitrix\Main\Diag\Debug::writeToFile($orderId, "UPDATE STATUS :)", '/_debug_pay_PRIVAT.txt');
        //CSaleOrder::Update($orderId, array("PAYED" => "Y"/*, 'STATUS_ID'=>'P'*/));
        CSaleOrder::PayOrder($orderId, "Y");
    }
}

Bitrix\Main\Diag\Debug::writeToFile($data, "BODY", '/_debug_pay_PRIVAT.txt');

// Проверка сигнатуры ответа с ошибкой
/*$expectedSignature = base64_encode(sha1($password . ($data['state'] ?? '') . ($data['storeId'] ?? '') . ($data['orderId'] ?? '') . ($data['message'] ?? '') . $password, true));
// Или для успешного ответа (если есть token)
if(isset($data['token']))
{
    $expectedSignature = base64_encode(sha1($password . ($data['state'] ?? '') . ($data['storeId'] ?? '') . ($data['orderId'] ?? '') . ($data['token'] ?? '') . $password, true));
}
if(!hash_equals($expectedSignature, $data['signature'] ?? ''))
{
    http_response_code(401);
    exit('Invalid signature');
}*/
// Логируем

// Обрабатываем статус
if($data['state'] === 'SUCCESS')
{
    // Платёж прошёл — можно отмечать заказ оплаченным
}
elseif($data['state'] === 'FAIL')
{
    // Ошибка: $data['message']
}



http_response_code(200);
die('OK');
