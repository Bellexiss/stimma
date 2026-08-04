<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');
\Bitrix\Main\Loader::includeModule('sale');

global $DB;

$xml = $_POST['xml'];

Bitrix\Main\Diag\Debug::writeToFile(var_export($xml, true), 'RESPONSE XML', '/_debug_pay.txt');

// Извлекаем номер заказа из info: {"dogovor":33275}
preg_match('/{"dogovor":([0-9]+),/', $xml, $matches);
$orderID = (int)($matches[1] ?? 0);
$loadOrderData = $DB->Query('select * from b_sale_order where ID = ' . $orderID)->Fetch();

// Проверка на ошибки банка
preg_match('/<bnk_error>(.*?)<\/bnk_error>/', $xml, $errorMatch);
$hasError = !empty(trim($errorMatch[1]));

// smch_id — определяет тип платежа (предоплата или полная оплата)
preg_match('/<smch_id>([0-9]+)<\/smch_id>/', $xml, $smchMatch);
$smchID = (int)($smchMatch[1] ?? 0);

preg_match('/{"pay_system_id":([0-9]+)}/', $xml, $pay_system_id);
$PaySystemId = (int)($pay_system_id[1] ?? 0);

// Сумма предоплаты (можно вытащить из XML при необходимости)
$prepayAmount = 200;

$hasErrorText = $hasError ? ' IS ERROR ' : 'NOT ERROR';
Bitrix\Main\Diag\Debug::writeToFile($orderID, 'orderID', '/_debug_pay.txt');
Bitrix\Main\Diag\Debug::writeToFile($hasErrorText, 'hasError', '/_debug_pay.txt');

if ($orderID > 0 && !$hasError)
{
    Bitrix\Main\Diag\Debug::writeToFile(1, 'var 1', '/_debug_pay.txt');
    // 🔍 Определяем тип платежа
    if (($smchID === 15740 || $smchID == 16932 || $smchID == 18597) && $loadOrderData['PAY_SYSTEM_ID'] == 9)
    {
        // 🟡 Это предоплата — записываем в свойство заказа
        $propertyCode = "PREDOPLATA"; // Замените на ваш код свойства

        $res = CSaleOrderPropsValue::GetList([], [
            "ORDER_ID" => $orderID,
            "CODE" => $propertyCode
        ]);
        if ($prop = $res->Fetch()) {
            CSaleOrderPropsValue::Update($prop['ID'], ["VALUE" => "{$prepayAmount} грн."]);
        } else {
            Bitrix\Main\Diag\Debug::writeToFile("Свойство предоплаты не найдено", "ORDER {$orderID}", '/_debug_pay.txt');
        }

        // ✅ Создаём частичный платёж через D7 API
        $order = \Bitrix\Sale\Order::load($orderID);
        if ($order) {
            $paymentCollection = $order->getPaymentCollection();

            //\Bitrix\Sale\PaySystem\Manager::getObjectById($loadOrderData['PAY_SYSTEM_ID']) // Укажите ID вашей платёжной системы
            $payment = $paymentCollection->createItem(
                \Bitrix\Sale\PaySystem\Manager::getObjectById(9) // Укажите ID вашей платёжной системы
            );

            $payment->setFields([
                'SUM' => $prepayAmount,
                'CURRENCY' => $order->getCurrency(),
                'PAID' => 'Y', // Отмечаем как оплаченный
                'PS_STATUS' => 'Y',
                'PS_STATUS_DESCRIPTION' => 'Предоплата',
            ]);

            $order->save();

            Bitrix\Main\Diag\Debug::writeToFile("Предоплата добавлена через D7", "PREPAY FOR ORDER {$orderID}", '/_debug_pay.txt');
        } else {
            Bitrix\Main\Diag\Debug::writeToFile("Ошибка загрузки заказа", "ORDER {$orderID}", '/_debug_pay.txt');
        }

        // Запись в таблицу payments
        global $DB;
        $DB -> Query('insert into payments (UF_ORDER_ID,UF_DATA,UF_TO_1C) values('.$orderID.', \''.$xml.'\',0)');

    }
    else
    {
        preg_match('/{"dogovor":([0-9]+),/',$xml,$matches);
        preg_match('/<bnk_error>(.*)<\/bnk_error>/',$xml,$matches2);

        if(empty(trim($matches2[1])) && $matches[1] > 0)
        {
            global $DB;
            Bitrix\Main\Diag\Debug::writeToFile(var_export($matches, 1), "NOT ERROR FOR " . $matches[1] , '/_debug_pay.txt');
            CSaleOrder ::PayOrder($matches[1], 'Y');
            $DB->Query('update b_sale_order set PAYED = \'Y\' where ID = ' . $matches[1]);
            $DB -> Query('insert into payments (UF_ORDER_ID,UF_DATA,UF_TO_1C) values('.$matches[1].', \''.$xml.'\',0)');
        }
        else
            Bitrix\Main\Diag\Debug::writeToFile(var_export($matches, 1), "ERROR FOR " . $matches[1] , '/_debug_pay.txt');

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
    }

}
elseif($hasError)
{
    Bitrix\Main\Diag\Debug::writeToFile(1, 'var 2', '/_debug_pay.txt');
    // Ошибка в данных или банке
    Bitrix\Main\Diag\Debug::writeToFile(var_export($matches, 1), "ERROR FOR ORDER {$orderID}", '/_debug_pay.txt');
}
else
{
    Bitrix\Main\Diag\Debug::writeToFile(1, 'var 3', '/_debug_pay.txt');
    Bitrix\Main\Diag\Debug::writeToFile($xml, 'var 4 xml 2', '/_debug_pay.txt');
    $oid = rand(100000, 999999)*-1;
    Bitrix\Main\Diag\Debug::writeToFile($oid, 'var 5 oid', '/_debug_pay.txt');
    preg_match('/<desc>(.*)<\/desc>/',$xml,$matches2);
    Bitrix\Main\Diag\Debug::writeToFile(1, 'var 6 preg desc', '/_debug_pay.txt');
    $desc = ($matches2[1] ?? 0);
    Bitrix\Main\Diag\Debug::writeToFile($desc, 'var 7 desc value', '/_debug_pay.txt');
    preg_match('/<amount>(.*)<\/amount>/',$xml,$matches2);
    Bitrix\Main\Diag\Debug::writeToFile(1, 'var 8 preg desc 2', '/_debug_pay.txt');
    $amount = (int)($matches2[1] ?? 0);
    Bitrix\Main\Diag\Debug::writeToFile($amount, 'var 5 amount value', '/_debug_pay.txt');
    Bitrix\Main\Diag\Debug::writeToFile('insert into payments (UF_ORDER_ID,UF_DATA,UF_TO_1C,UF_DESC,UF_AMOUNT) values('.$oid.', \''.$_REQUEST['data'].'\',0,\''.$desc.'\','.$amount.')', "SQL query", '/_debug_pay.txt');
    $DB -> Query('insert into payments (UF_ORDER_ID,UF_DATA,UF_TO_1C,UF_DESC,UF_AMOUNT) values('.$oid.', \''.$xml.'\',0,\''.$desc.'\','.$amount.')');
    Bitrix\Main\Diag\Debug::writeToFile(1, "After SQL query", '/_debug_pay.txt');

}

http_response_code(200);
die('OK');
