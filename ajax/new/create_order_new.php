<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if($_POST['email'] == 'tyhtuh@gmail.com')die();

use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Sale\Order;
use Bitrix\Sale\Basket;
use Bitrix\Main\Loader;
use Bitrix\Sale;

CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");

global $USER, $DB;

$ru = isset($_POST['url']) && strpos($_POST['url'], '/ru/') !== false;

if($ru)
    $site_id = 's1';
else
    $site_id = 's2';
$DB -> Query('update b_sale_discount set LID = \''.$site_id.'\'');
$fuserID = CSaleBasket::GetBasketUserID();
$res = $DB -> Query('select * from b_sale_basket where FUSER_ID = '.$fuserID.' and ORDER_ID is null and (LID = \'s1\' or LID = \'s2\')');
while ($record = $res -> Fetch())
    $DB -> Query('update b_sale_basket set LID = \''.$site_id.'\' where ID = '.$record['ID']);

$uid = $USER -> GetID();

if (!$uid)
{
    $phone = $_POST['phone'];

    if (!$_POST['email'])
        $_POST['email'] = 'noemail_'.uniqid().'@gmail.com';

    $user = CUser::GetList($by = 'ID', $order = 'DESC', ['EMAIL' => $_POST['email']]);
    $uadd = new CUser;

    if ($buyer = $user -> Fetch())
        $uid = $buyer['ID'];
    else
    {
        $pass = uniqid();
        $uid = $uadd->Add(['LOGIN' => $_POST['email'], 'EMAIL' => $_POST['email'], 'PASSWORD' => $pass, 'CONFIRM_PASSWORD' => $pass, 'PERSONAL_PHONE' => $phone]);
    }
}

if (!$uid)
{
    $phone = $_POST['phone'];

    $user = CUser::GetList($by = 'ID', $order = 'DESC', ['PERSONAL_PHONE' => $phone]);
    $uadd = new CUser;

    if ($buyer = $user -> Fetch())
        $uid = $buyer['ID'];
    else
    {
        $pass = uniqid();
        $uid = $uadd->Add(['LOGIN' => $phone, 'EMAIL' => $phone.'@i.ua', 'PASSWORD' => $pass, 'CONFIRM_PASSWORD' => $pass, 'PERSONAL_PHONE' => $phone]);
    }
}


function getBasketItems2($site_id, $ajax = false)
{
    CModule::IncludeModule('sale');
    CModule::IncludeModule('iblock');
    global $DB;

    $arBasketItems = array();

    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => $site_id,
            "ORDER_ID" => "NULL"
        ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE",
              "PRODUCT_ID", "QUANTITY", "DELAY",
              "CAN_BUY", "PRICE", "WEIGHT")
    );
    while ($arItems = $dbBasketItems->Fetch())
    {
        $db = CIBlockElement::GetByID($arItems['PRODUCT_ID']) -> Fetch();
        $arItems['NAME'] = $db['NAME'];
        $arItems['CODE'] = $db['CODE'];
        $arItems['PICTURE'] = $db['PREVIEW_PICTURE'] ? $db['PREVIEW_PICTURE'] : $db['DETAIL_PICTURE'];
        $arBasketItems['ITEMS'][] = $arItems;
    }
    $arBasketItems['BASKET_COUNT'] = count($arBasketItems['ITEMS']);

    return $arBasketItems;
}

$basket = getBasketItems2($site_id);
$products = [];

foreach($basket['ITEMS'] as $index => $item)
{
    if(!$item) continue;

    $products[$index] = [
        'PRODUCT_ID' => $item['PRODUCT_ID'],
        'QUANTITY' => $item['QUANTITY'],
        'PRICE' => $item['PRICE'],
        //'BASE_PRICE' => $basePrice['PRICE'],
        'NAME' => $item['NAME'],
    ];
}

?><pre><?=print_r($basket, 1)?></pre><?
?><pre><?=print_r($products, 1)?></pre><?
die();
if(!empty($products) && $uid)
{
    global $APPLICATION;
    global $USER;

    Bitrix\Main\Loader::includeModule("sale");
    Bitrix\Main\Loader::includeModule("catalog");
    // Проверка загрузки модуля "sale"
    if(!Loader::includeModule('sale'))
    {
        die('Виникла помилка. Зверніться до адміністратора.');
    }

    $basket = Sale\Basket::create('s1');
    foreach($products as $index => $product)
    {
        $productId = $product["PRODUCT_ID"];
        $quantity = intval($product['QUANTITY']);
        if(!$quantity) $quantity = 1;

        // Добавление товара в корзину

        $item = $basket->createItem('catalog', $productId);
        $item->setFields([
                             'QUANTITY' => $quantity,
                             'CURRENCY' => 'UAH',
                             'LID'      => $site_id,
                             //'CUSTOM_PRICE'      => "Y",
                             'NAME'      => $product['NAME'],
                             'PRICE'      => $product['PRICE'],
                             //'BASE_PRICE'      => $product['BASE_PRICE'],
                         ]);
    }


    // Сохранение корзины
    $basket->save();
    // Создание заказа
    $order = Sale\Order::create($site_id, $uid);
    $order->setBasket($basket);
    // Установка свойств заказа

    if($props['LASTNAME'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.$_POST['fio'].'\' where ID = ' . $props['LASTNAME']);
    if($props['PHONE'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.$_POST['phone'].'\' where ID = ' . $props['PHONE']);
    if($props['EMAIL'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.$_POST['email'].'\' where ID = ' . $props['EMAIL']);
    if($props['NAME'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.$_POST['name'].'\' where ID = ' . $props['NAME']);

    if($_POST['delivery_method'] == 14 || $_POST['delivery_method'] == 15)
    {
        if($_POST['delivery_method'] == 14)
        {
            $cityName = $vid = '';
            if($_POST['choose_city_np'])
            {
                $cityName = $DB->Query('select * from np_cities where ID = ' . $_POST['choose_city_np']);
                if($cityName = $cityName->Fetch())
                    $cityName = $cityName['UF_NAME_UA'];
            }
            if($_POST['choose_city_np_vid'])
            {
                $vid = $DB->Query('select * from np_posts where ID = ' . $_POST['choose_city_np_vid']);
                if($vid = $vid->Fetch())
                    $vid = '№'.$vid['UF_NUMBER'].' ' .$vid['UF_SHORT_ADRESS_UA'];
            }
        }
        if($_POST['delivery_method'] == 15)
        {
            $cityName = $vid = '';
            if($_POST['choose_city_np'])
            {
                $cityName = $DB->Query('select * from ukrposhta_cities where ID = ' . $_POST['choose_city_np']);
                if($cityName = $cityName->Fetch())
                    $cityName = $cityName['UF_CITY_UA'];
            }
            if($_POST['choose_city_np_vid'])
            {
                $vid = $DB->Query('select * from ukrposhta_posts where ID = ' . $_POST['choose_city_np_vid']);
                if($vid = $vid->Fetch())
                    $vid = $vid['UF_POSTINDEX'] . ', ' . $vid['UF_ADDRESS'];
            }
        }

        //if($props['ADDRESS'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($vid).'\' where ID = ' . $props['ADDRESS']);
        //if($props['CITY'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($cityName).'\' where ID = ' . $props['CITY']);

        //$DB -> Query('INSERT INTO b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE) VALUES('.$ORDER_ID.',25, \'Отделение\', \''.$vid.'\', \'ADDRESS\')');
        //$DB -> Query('INSERT INTO b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE) VALUES('.$ORDER_ID.',4, \'Город\', \''.$cityName.'\', \'CITY\')');
    }


    $propertyCollection = $order->getPropertyCollection();
    foreach ($propertyCollection->getGroups() as $group) {
        foreach ($propertyCollection->getGroupProperties($group['ID']) as $property) {
            $p = $property->getProperty();

            if($p['CODE'] == 'ADDRESS')
                $property->setValue($vid);
            if($p['CODE'] == 'CITY')
                $property->setValue($cityName);

            if($p['CODE'] == 'LASTNAME')
                $property->setValue($_POST['fio']);
            if($p['CODE'] == 'NAME')
                $property->setValue($_POST['name']);
            if($p['CODE'] == 'EMAIL')
                $property->setValue($_POST['email']);
            if($p['CODE'] == 'PHONE')
            {
                $nameValue = $_POST['phone'];
                $phoneNumber = \Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($nameValue);
                $property->setValue($phoneNumber);
            }

        }
    }
    // Установите нужные свойства заказа, если их больше

    // Выбор системы оплаты
    $paymentCollection = $order->getPaymentCollection();
    $payment = $paymentCollection->createItem();
    $payment->setField('PAY_SYSTEM_ID', $_POST['payment_method']); // Замените на реальный ID системы оплаты
    //$payment->setPaid('Y');
    // Выбор системы доставки
    $shipmentCollection = $order->getShipmentCollection();
    $shipment = $shipmentCollection->createItem();
    $shipment->setField('DELIVERY_ID', $_POST['delivery_method']); // Замените на реальный ID системы доставки

    $order->setPersonTypeId(1);
    $order->setField('CURRENCY', 'UAH');
    if($_POST['comment'] > 0)
    {
        //$order->setField('SUM_PAID', $_POST['user_bonus']);
        $order->setField('COMMENTS', $_POST['comment']);
    }

    // Сохранение заказа
    $result = $order->save();
    // Проверка результата
    if($result->isSuccess())
    {
        $orderId = $order->getId();

        $_SESSION['SALE_ORDER_ID'][] = $orderId;
        $json['status'] = 1;
        $json['order_id'] = $orderId;
        $json['msg'] = 'Заказ номер ' . $orderId . ' успешно создан.';

        sendNewEmailToClient($orderId);
        sendNewSmsToClient($orderId);
    }
    else
    {
        $json['msg2'] = 'Помилка створення замовлення';
        $json['msg'] = 'Помилка створення замовлення';
        $json['status'] = 0;
        $errors = $result->getErrorMessages();
        //echo 'Ошибка создания заказа: ' . implode(', ', $errors);
    }
    // todo #V1

}
$APPLICATION->RestartBuffer();
echo json_encode($json);
die();






die();



Bitrix\Main\Diag\Debug::writeToFile('start create_order', " " , '/debug_create_order.txt');


if(ME && $_SESSION['COUPON'])
{
    $arOptions = array(
        'COUNT_DISCOUNT_4_ALL_QUANTITY' => "Y",
    );

    $arErrors = array();

    DiscountCouponsManager::add($_SESSION['COUPON']);

    $arCoupons = DiscountCouponsManager::get(true, ['COUPON' => $_SESSION['COUPON']], true, true);

    $activeCoupon = 0;
    if (!empty($arCoupons))
    {
        $arCoupon = array_shift($arCoupons);
        if ($arCoupon['STATUS'] == DiscountCouponsManager::STATUS_NOT_APPLYED)
            $activeCoupon = 1;
        else $activeCoupon = 0;
    }

    $basket = Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), $site_id);

    $discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
    $discounts->calculate();
    $arBasketDiscounts = $discounts->getApplyResult(true);

    $basket->save();
    CSaleDiscount::DoProcessOrder($arFields, $arOptions, $arErrors);
    ?><pre><?=print_r($arBasketDiscounts['PRICES']['BASKET'], 1)?></pre><?
    ?><pre><?=print_r($_SESSION['COUPON'], 1)?></pre><?
    ?><pre><?=print_r($arErrors, 1)?></pre><?
    ?><pre><?=print_r($arFields, 1)?></pre><?
}


$bItems = getBasketItems2($site_id);
if(ME && $_SESSION['COUPON'])
{
    foreach($bItems['ITEMS'] as $index => $ITEM)
    {
        if(intval($arBasketDiscounts['PRICES']['BASKET'][$ITEM['ID']]['PRICE']) != intval($ITEM['PRICE']))
        {
            $bItems['ITEMS'][$index]['PRICE'] = round($arBasketDiscounts['PRICES']['BASKET'][$ITEM['ID']]['PRICE']);
            $bItems['ITEMS'][$index]['BASE_PRICE'] = round($arBasketDiscounts['PRICES']['BASKET'][$ITEM['ID']]['BASE_PRICE']);
            $bItems['ITEMS'][$index]['DISCOUNT'] = round($arBasketDiscounts['PRICES']['BASKET'][$ITEM['ID']]['DISCOUNT']);
        }
    }
    ?><pre><?=print_r($bItems, 1)?></pre><?
}
if(!$bItems['BASKET_COUNT'])
{
    echo json_encode(['status' => 0, 'msg' => 'Ваша корзина пуста']);
    die();

}

Bitrix\Main\Diag\Debug::writeToFile($bItems, " basket items " , '/debug_create_order.txt');
$uid = $USER -> GetID();

if (!$uid)
{
    $phone = $_POST['phone'];

    if (!$_POST['email'])
        $_POST['email'] = 'noemail_'.uniqid().'@gmail.com';

    $user = CUser::GetList($by = 'ID', $order = 'DESC', ['EMAIL' => $_POST['email']]);
    $uadd = new CUser;

    if ($buyer = $user -> Fetch())
        $uid = $buyer['ID'];
    else
    {
        $pass = uniqid();
        $uid = $uadd->Add(['LOGIN' => $_POST['email'], 'EMAIL' => $_POST['email'], 'PASSWORD' => $pass, 'CONFIRM_PASSWORD' => $pass, 'PERSONAL_PHONE' => $phone]);
    }
}

if (!$uid)
{
    $phone = $_POST['phone'];

    $user = CUser::GetList($by = 'ID', $order = 'DESC', ['PERSONAL_PHONE' => $phone]);
    $uadd = new CUser;

    if ($buyer = $user -> Fetch())
        $uid = $buyer['ID'];
    else
    {
        $pass = uniqid();
        $uid = $uadd->Add(['LOGIN' => $phone, 'EMAIL' => $phone.'@i.ua', 'PASSWORD' => $pass, 'CONFIRM_PASSWORD' => $pass, 'PERSONAL_PHONE' => $phone]);
    }
}

//DiscountCouponsManager::init(DiscountCouponsManager::MODE_CLIENT, ['userId' => $uid]);

$allSum = 0;
$idsbasket = [];

foreach ($bItems['ITEMS'] as $index => $bItem)
{
    $idsbasket[] = $bItem['ID'];
    $allSum += ($bItem['PRICE']*$bItem['QUANTITY']);
}

$arFields = array(
    "LID" => $site_id,
    "PERSON_TYPE_ID" => 1,
    "PAYED" => "N",
    "CANCELED" => "N",
    //'DETAIL_PAGE_URL' => '/'.$arItem['UF_CODE'],
    //"STATUS_ID" => "N",
    "PRICE" => $allSum,
    "CURRENCY" => "UAH",
    "USER_ID" => $uid, //IntVal($USER->GetID()),
    "PAY_SYSTEM_ID" => $_POST['payment_method'],
    "PRICE_DELIVERY" => 0,
    "DELIVERY_ID" => $_POST['delivery_method'],
    "COMMENTS" => $_POST['comment'],
    'BASKET_ITEMS' => $bItems['ITEMS']
    //"DISCOUNT_VALUE" => 1.5,
    //"TAX_VALUE" => 0.0,
    //"USER_DESCRIPTION" => $_POST['USER_DESCRIPTION']
);




unset($arFields['BASKET_ITEMS']);

Bitrix\Main\Diag\Debug::writeToFile($arFields, " arFields " , '/debug_create_order.txt');


$ORDER_ID = CSaleOrder::Add($arFields);
$ORDER_ID = IntVal($ORDER_ID);
Bitrix\Main\Diag\Debug::writeToFile($ORDER_ID, " ORDER_ID " , '/debug_create_order.txt');
$result['msg2'] = 'Ошибка создания заказа';
$result['msg'] = 'Ошибка создания заказа';
$result['status'] = 0;
if ($ORDER_ID > 0)
{
    $_SESSION['SALE_ORDER_ID'][] = $ORDER_ID;

    //$idBasket = CSaleBasket::Add(['CURRENCY' => 'UAH','LID' => 's1', 'PRODUCT_ID' => $arItem['UF_ELEMENT_ID'], 'QUANTITY' => 1, 'NAME' => $arItem['UF_NAME'], 'PRICE' => $arItem['UF_PRICE'], 'ORDER_ID' => $ORDER_ID]);
    Bitrix\Main\Diag\Debug::writeToFile($idsbasket, " idsbasket " , '/debug_create_order.txt');

    foreach ($idsbasket as $index => $item)
    {
        $DB -> Query('update b_sale_basket set ORDER_ID = ' . $ORDER_ID . ' where ID = ' . $item);
    }

    $propsDB = $DB->Query('select * from b_sale_order_props_value where ORDER_ID = ' . $ORDER_ID);
    $props = [];
    while ($record = $propsDB->Fetch())
        $props[$record['CODE']] = $record['ID'];

    if($props['LASTNAME'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.$_POST['fio'].'\' where ID = ' . $props['LASTNAME']);
    if($props['PHONE'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.$_POST['phone'].'\' where ID = ' . $props['PHONE']);
    if($props['EMAIL'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.$_POST['email'].'\' where ID = ' . $props['EMAIL']);
    if($props['NAME'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.$_POST['name'].'\' where ID = ' . $props['NAME']);

    //$DB -> Query('INSERT INTO b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE) VALUES('.$ORDER_ID.',20, \'Фамилия\', \''.$_POST['fio'].'\', \'LASTNAME\')');
    //$DB -> Query('INSERT INTO b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE) VALUES('.$ORDER_ID.',3, \'Телефон\', \''.$_POST['phone'].'\', \'PHONE\')');
    //$DB -> Query('INSERT INTO b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE) VALUES('.$ORDER_ID.',2, \'Email\', \''.$_POST['email'].'\', \'EMAIL\')');
    //$DB -> Query('INSERT INTO b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE) VALUES('.$ORDER_ID.',1, \'Имя\', \''.$_POST['name'].'\', \'NAME\')');

    if($_POST['delivery_method'] == 14 || $_POST['delivery_method'] == 15)
    {
        if($_POST['delivery_method'] == 14)
        {
            $cityName = $vid = '';
            if($_POST['choose_city_np'])
            {
                $cityName = $DB->Query('select * from np_cities where ID = ' . $_POST['choose_city_np']);
                if($cityName = $cityName->Fetch())
                    $cityName = $cityName['UF_NAME_UA'];
            }
            if($_POST['choose_city_np_vid'])
            {
                $vid = $DB->Query('select * from np_posts where ID = ' . $_POST['choose_city_np_vid']);
                if($vid = $vid->Fetch())
                    $vid = '№'.$vid['UF_NUMBER'].' ' .$vid['UF_SHORT_ADRESS_UA'];
            }
        }
        if($_POST['delivery_method'] == 15)
        {
            $cityName = $vid = '';
            if($_POST['choose_city_np'])
            {
                $cityName = $DB->Query('select * from ukrposhta_cities where ID = ' . $_POST['choose_city_np']);
                if($cityName = $cityName->Fetch())
                    $cityName = $cityName['UF_CITY_UA'];
            }
            if($_POST['choose_city_np_vid'])
            {
                $vid = $DB->Query('select * from ukrposhta_posts where ID = ' . $_POST['choose_city_np_vid']);
                if($vid = $vid->Fetch())
                    $vid = $vid['UF_POSTINDEX'] . ', ' . $vid['UF_ADDRESS'];
            }
        }

        if($props['ADDRESS'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($vid).'\' where ID = ' . $props['ADDRESS']);
        if($props['CITY'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($cityName).'\' where ID = ' . $props['CITY']);

        //$DB -> Query('INSERT INTO b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE) VALUES('.$ORDER_ID.',25, \'Отделение\', \''.$vid.'\', \'ADDRESS\')');
        //$DB -> Query('INSERT INTO b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE) VALUES('.$ORDER_ID.',4, \'Город\', \''.$cityName.'\', \'CITY\')');
    }



    $result['status'] = 1;
    $result['order_id'] = $ORDER_ID;
    $result['msg'] = 'Заказ номер ' . $ORDER_ID . ' успешно создан.';

    if(ME && isset($_SESSION['COUPON']))
    {
        /*$order = Order::load($ORDER_ID);
        \Bitrix\Sale\DiscountCouponsManager::add($_SESSION['COUPON']);

        $discounts = $order->getDiscount();
        $discounts->setOrderRefresh(true);
        $discounts->calculate();

        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
            \CSaleBasket::GetBasketUserID(), $site_id)->getOrderableItems();
        $basket->refreshData(["PRICE", "COUPONS"]);

        $order->doFinalAction(true);
        $order->save();

        \Bitrix\Sale\DiscountCouponsManager::delete($_SESSION['COUPON']);
        unset($_SESSION['COUPON']);*/


        $coupon = $_SESSION['COUPON'];	//код купона, который нужно учесть в заказе
        $order = Order::load($ORDER_ID);
        DiscountCouponsManager::init(
            DiscountCouponsManager::MODE_ORDER,
            [
                "userId" => $order->getUserId(),
                "orderId" => $order->getId()
            ]
        );
        DiscountCouponsManager::add($coupon);
        $discounts = $order->getDiscount();
        $discounts->calculate();
        $order->doFinalAction(true);
        $order->save();

        \Bitrix\Sale\DiscountCouponsManager::delete($_SESSION['COUPON']);
        unset($_SESSION['COUPON']);
    }




    sendNewEmailToClient($ORDER_ID);
    sendNewSmsToClient($ORDER_ID);

}
Bitrix\Main\Diag\Debug::writeToFile('end create_order', " " , '/debug_create_order.txt');




echo json_encode($result);