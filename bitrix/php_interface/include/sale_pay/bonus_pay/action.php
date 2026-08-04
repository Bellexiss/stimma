<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Sale\Order;

Loader::includeModule('sale');

global $USER;

$orderId = (int)($_REQUEST["ORDER_ID"] ?? 0);
$order = Order::load($orderId);

if (!$order) {
    LocalRedirect("/cart/?error=order_not_found");
    die();
}

if (!$USER->IsAuthorized()) {
    LocalRedirect("/auth/?backurl=/cart/");
    die();
}

$userId = $USER->GetID();

/*
$orderSum = (float)$order->getPrice();

$userData = CUser::GetByID($userId)->Fetch();
$bonus = (float)($userData["UF_BONUS"] ?? 0);

if ($bonus < $orderSum) {
    LocalRedirect("/cart/?error=not_enough_bonus");
    die();
}/

/*
$newBonus = $bonus - $orderSum;
$user = new CUser;
$user->Update($userId, ["UF_BONUS" => $newBonus]);
*/

$paymentCollection = $order->getPaymentCollection();
foreach ($paymentCollection as $payment) {
    if ($payment->getPaymentSystemId() == $order->getPaymentSystemId()) {
        $payment->setPaid("Y");
    }
}


$order->save();


//LocalRedirect("/cart/order-success/?ORDER_ID=" . $orderId);
