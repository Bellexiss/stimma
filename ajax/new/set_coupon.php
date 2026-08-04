<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use Bitrix\Sale\Discount;
use Bitrix\Sale\Discount\Context\Fuser as FuserContext;
use Bitrix\Sale\DiscountCouponsManager;

if (!Loader::includeModule('sale')) {
echo json_encode(['status' => 0, 'msg' => 'Sale module error']);
die();
}

global $USER, $DB;

$request = Context::getCurrent()->getRequest();

// --- 1. Входные данные --------------------------------------------------------
$coupon     = trim((string)$request->getPost('coupon'));
$url        = (string)$request->getPost('url');
$isOrder    = ((string)$request->getPost('is_order')) === '1' || ((string)$request->getPost('is_order')) === 'true';
$isAction08 = ((string)$request->getPost('isAction08')) === '1' || ((string)$request->getPost('isAction08')) === 'true';

// --- 2. Сайт и язык -----------------------------------------------------------
$siteId = (strpos($url, '/ru/') !== false) ? 's1' : 's2';
$isUa   = (strpos($url, '/ru/') === false);

if ($coupon === '') {
echo json_encode(['status' => 0, 'msg' => $isUa ? 'Введіть промокод' : 'Введите промокод']);
die();
}

$msgCouponActionNotApply  = $isUa ? 'Промокод не може бути застосований' : 'Промокод не может быть применен';
$msgCouponOnActionItem    = $isUa ? 'Промокод не діє на акційний товар'    : 'Промокод не действует на акционный товар';
$msgNeedAuth              = $isUa ? 'Для активації промокоду авторизуйтесь': 'Для активации промокода авторизуйтесь';
$msgCouponUsed            = $isUa ? 'Промокод використано раніше'         : 'Промокод использован ранее';
$msgCouponOk              = $isUa ? 'Промокод успішно застосований'        : 'Промокод успешно применен';
$msgCouponNotFound        = $isUa ? 'Промокод не знайдений'               : 'Промокод не найден';

$res = $DB -> Query('select * from b_sale_discount_coupon where COUPON = \''.$coupon.'\' and ACTIVE = \'Y\'');
if($res=$res->Fetch())
{
    if($res['COUPON'])
        $coupon = $res['COUPON'];
    else
    {
        echo json_encode(['status' => 0, 'msg' => $msgCouponNotFound]);
        die();
    }
}
else
{
    echo json_encode(['status' => 0, 'msg' => $msgCouponNotFound]);
    die();
}



// --- 3. Нормализация купона ---------------------------------------------------
//$coupon = mb_strtolower($coupon);

// Купоны, которые разрешено применять без авторизации
$publicCoupons = ['yana10', 'look25'];

// --- 4. Проверка акции 08 -----------------------------------------------------
if ($isAction08 && $coupon !== 'look25') {
echo json_encode(['status' => 0, 'msg' => $msgCouponActionNotApply]);
die();
}

// --- 5. Проверка авторизации и истории использования --------------------------
$isAuthorized = $USER->IsAuthorized();
$userId       = $isAuthorized ? (int)$USER->GetID() : 0;

if (!$isAuthorized && !in_array($coupon, $publicCoupons, true)) {
echo json_encode(['status' => 0, 'msg' => $msgNeedAuth, 'needAuth' => true]);
die();
}

// Проверка повторного использования (для авторизованных, кроме служебных)
if ($isAuthorized && $coupon !== 'look25') {
$res = $DB->Query(
"SELECT ID FROM raz_zam WHERE UF_COUPON = '".$DB->ForSql($coupon)."' AND UF_USER_ID = ".(int)$userId
);
if ($res && $res->Fetch()) {
echo json_encode(['status' => 0, 'msg' => $msgCouponUsed]);
die();
}
}

// --- 6. Инициализация менеджера купонов --------------------------------------
DiscountCouponsManager::init(DiscountCouponsManager::MODE_CLIENT, [
'userId' => $userId,
'siteId' => $siteId,
]);

// --- 7. Проверка «акционный ли товар» через цену базы ------------------------
$basketList = Basket::loadItemsForFUser(Fuser::getId(), $siteId);

$hasActionItem = false;
foreach ($basketList as $basketItem) {
$productId = (int)$basketItem->getProductId();
if ($productId <= 0) {
continue;
}

$res = $DB->Query(
'SELECT CATALOG_GROUP_ID, PRICE '
.'FROM b_catalog_price '
.'WHERE PRODUCT_ID = '.$productId.' AND CATALOG_GROUP_ID IN (1, 2)'
);

$prices = [];
while ($row = $res->Fetch()) {
$prices[(int)$row['CATALOG_GROUP_ID']] = (float)$row['PRICE'];
}

if (
isset($prices[1], $prices[2])
&& $prices[1] > 0
&& $prices[2] > 0
&& $prices[1] > $prices[2]
) {
$hasActionItem = true;
break;
}
}

if ($hasActionItem) {
echo json_encode(['status' => 0, 'msg' => $msgCouponOnActionItem]);
die();
}

// --- 8. Применение купона ----------------------------------------------------
DiscountCouponsManager::add($coupon);

// --- 9. Проверка статуса купона ----------------------------------------------
$arCoupons = DiscountCouponsManager::get(true, ['COUPON' => $coupon], true);
$arCoupon  = is_array($arCoupons) ? reset($arCoupons) : false;

if (!$arCoupon) {
echo json_encode(['status' => 0, 'msg' => $msgCouponNotFound. ' 1','coupons'=>$arCoupons,'coupon'=>$coupon]);
die();
}

/*if ($arCoupon['STATUS'] !== DiscountCouponsManager::STATUS_NOT_APPLYED) {
echo json_encode(['status' => 0, 'msg' => $msgCouponNotFound. ' 2']);
die();
}*/

// --- 10. Пересчёт корзины ----------------------------------------------------
$basket = Basket::loadItemsForFUser(Fuser::getId(), $siteId);
$ctx    = new FuserContext($basket->getFUserId(true));

$discounts = Discount::buildFromBasket($basket, $ctx);
$discounts->calculate();

if (!$basket->save()) {
echo json_encode(['status' => 0, 'msg' => 'Basket save error']);
die();
}


/*$total    = $basket->getPrice();
$baseTotal = $basket->getBasePrice();
$hasDiscount = ($baseTotal > $total);

if (!$hasDiscount) {
    echo json_encode(['status' => 0, 'msg' => $msgCouponNotFound. ' 3']);
    die();
}*/

// --- 11. Ответ с пересчитанной корзиной --------------------------------------
$itemsOut = [];
$total    = 0.0;

foreach ($basket as $basketItem) {
$price    = (float)$basketItem->getPrice();
$basePrice = (float)$basketItem->getBasePrice();
$qty      = (float)$basketItem->getQuantity();
$sum      = $price * $qty;
$total   += $sum;

$itemsOut[] = [
'ID'           => $basketItem->getId(),
'PRODUCT_ID'   => $basketItem->getProductId(),
'NAME'         => $basketItem->getField('NAME'),
'QUANTITY'     => $qty,
'PRICE'        => $price,
'BASE_PRICE'   => $basePrice,
'DISCOUNT'     => max(0, $basePrice - $price),
'SUM'          => $sum,
];
}

$_SESSION['COUPON'] = $coupon;

echo json_encode([
'status' => 1,
'msg'    => $msgCouponOk,
'basket' => $itemsOut,
'amount' => $total,
]);
die();