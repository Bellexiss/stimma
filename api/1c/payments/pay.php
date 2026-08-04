<?php
use Bitrix\Main\Loader;
use Bitrix\Sale;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

Loader::includeModule('sale');

$orderID = 33323;
$prepayAmount = 200;

$order = Sale\Order::load($orderID);
if ($order) {
    $paymentCollection = $order->getPaymentCollection();

    $payment = $paymentCollection->createItem(
        Bitrix\Sale\PaySystem\Manager::getObjectById(9) // замените на ваш ID платежной системы
    );

    $payment->setFields([
        'SUM' => $prepayAmount,
        'CURRENCY' => $order->getCurrency(),
        'PAID' => 'Y', // это важно, чтобы сумма появилась в "Оплачено"
        'PS_STATUS' => 'Y',
        'PS_STATUS_DESCRIPTION' => 'Предоплата',
    ]);

    $order->save();
}