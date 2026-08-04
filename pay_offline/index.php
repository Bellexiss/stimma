<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
echo'1';
CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');
\Bitrix\Main\Loader::includeModule('sale');
echo '2';
global $DB;
//$sql = 'insert into payments (UF_ORDER_ID,UF_DATA,UF_TO_1C,UF_DESC,UF_AMOUNT) values(2, \''.$_REQUEST['data'].'\',0,\'ST000045678\',20000)';
echo '3';
\Bitrix\Main\Diag\Debug::writeToFile('111', "SQL query", '/debug_pay.txt');
echo '4';
die();
$xml = $_POST['xml'];

Bitrix\Main\Diag\Debug::writeToFile(var_export($_POST, true), 'RESPONSE POST', '/_debug_pay_offline.txt');
Bitrix\Main\Diag\Debug::writeToFile(var_export($xml, true), 'RESPONSE XML', '/_debug_pay_offline.txt');
die();
// Извлекаем номер заказа из info: {"dogovor":33275}
preg_match('/{"dogovor":([0-9]+)}/', $xml, $matches);
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

if ($orderID > 0 && !$hasError)
{
    // 🔍 Определяем тип платежа
    if ($smchID === 15740 && $loadOrderData['PAY_SYSTEM_ID'] == 9)
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
            Bitrix\Main\Diag\Debug::writeToFile("Свойство предоплаты не найдено", "ORDER {$orderID}", '/debug_pay.txt');
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

            Bitrix\Main\Diag\Debug::writeToFile("Предоплата добавлена через D7", "PREPAY FOR ORDER {$orderID}", '/debug_pay.txt');
        } else {
            Bitrix\Main\Diag\Debug::writeToFile("Ошибка загрузки заказа", "ORDER {$orderID}", '/debug_pay.txt');
        }

        // Запись в таблицу payments
        global $DB;
        $DB -> Query('insert into payments (UF_ORDER_ID,UF_DATA,UF_TO_1C) values('.$orderID.', \''.$xml.'\',0)');

    } else {
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
    }

} else {
    // Ошибка в данных или банке
    Bitrix\Main\Diag\Debug::writeToFile(var_export($matches, 1), "ERROR FOR ORDER {$orderID}", '/debug_pay.txt');
}

http_response_code(200);
die('OK');
