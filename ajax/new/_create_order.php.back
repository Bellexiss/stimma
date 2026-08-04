<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if($_SERVER['REMOTE_ADDR'] == '109.95.48.150')
{
    //require_once 'create_order_new.php';
    //die();
}


if($_POST['email'] == 'tyhtuh@gmail.com')die();

use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Sale\Order;
use Bitrix\Sale\Basket;
use Bitrix\Main\Loader;
use Bitrix\Sale;

CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");
Loader::includeModule("catalog");

global $USER, $DB;

if(isset($_POST['sqls']))
    foreach($_POST['sqls'] as $index => $sql)
        $DB->Query($sql);


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

function getBasketItems($site_id, $ajax = false)
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


/*
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
*/


$bItems = getBasketItems($site_id);
/*
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
*/
if(!$bItems['BASKET_COUNT'])
{
    echo json_encode(['status' => 0, 'msg' => 'Ваша корзина пуста']);
    die();

}

$uid = $USER -> GetID();
$userCode = false;
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
        $userCode = rand(100000,999999);
        $uid = $uadd->Add(['NAME'=>$_POST['name'],'LAST_NAME'=>$_POST['fio'],'SECOND_NAME'=>$_POST['second_name'],'LOGIN' => $_POST['email'], 'EMAIL' => $_POST['email'], 'PASSWORD' => $pass, 'CONFIRM_PASSWORD' => $pass, 'PERSONAL_PHONE' => $phone, 'UF_PHONE_CODE'=>$userCode]);
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
        $userCode = rand(100000,999999);
        $uid = $uadd->Add(['NAME'=>$_POST['name'],'LAST_NAME'=>$_POST['fio'],'SECOND_NAME'=>$_POST['second_name'],'LOGIN' => $phone, 'EMAIL' => $phone.'@i.ua', 'PASSWORD' => $pass, 'CONFIRM_PASSWORD' => $pass, 'PERSONAL_PHONE' => $phone, 'UF_PHONE_CODE'=>$userCode]);
    }
}

if($userCode && $phone && $uid)
{
    $phone = preg_replace('/[^0-9+]/', '', $phone);

    sendSmsTelikom($phone, "Код підтвердження: " . $userCode);

    /*$phoneValue = str_replace([' ',')','(','-'],['','','',''],$phone);
    $apiKey = 'CCECFE951999D570AEC5638B3DC9CF45';
    $senderName = 'STIMMA';
    $phoneNumber = $phone;
    $data = [
        'phoneNumbers' => [$phoneNumber],
        "from" => "STIMMA",
        "text" => "Код підтвердження: " . $userCode
    ];

    $headers = [
        'Authorization: Basic ' . base64_encode("STIMMA:".$apiKey),
        'Content-Type: application/json',
    ];

    $options = [
        CURLOPT_URL => 'https://esputnik.com/api/v1/message/sms',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers,
    ];
    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    curl_close($curl);*/
}


//DiscountCouponsManager::init(DiscountCouponsManager::MODE_CLIENT, ['userId' => $uid]);

$allSum = $totalBonus = 0;
$idsbasket = [];//error_reporting(E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);
foreach ($bItems['ITEMS'] as $index => $bItem) {
    $dpuprop = \CIBlockElement::GetList([], ['ID' => $bItem['PRODUCT_ID']], false, false, ['ID', 'NAME', 'PROPERTY_PROP_BONUS', 'PROPERTY_PROP_BONUS_PRICE'])->Fetch();
    if (isset($dpuprop['PROPERTY_PROP_BONUS_PRICE_VALUE'])) {
        $totalBonus += $dpuprop['PROPERTY_PROP_BONUS_PRICE_VALUE'] * $bItem['QUANTITY'];
    }
    $idsbasket[] = $bItem['ID'];
    $allSum += $bItem['PRICE'] * $bItem['QUANTITY'];        //echo "<pre>";print_r($dpuprop['PROPERTY_PROP_BONUS_PRICE_VALUE']);print_R($bItem);echo"</pre>";	//echo "<pre>";print_R($bItem);echo"</pre>";
}
$_POST['USER_DESCRIPTION'] = 0;
$_POST['SV_BONUS'] = 0;
if (isset($_POST['payment_method_part']) && $_POST['payment_method_part'] == 1 && $_POST['payment_method_part']) {
    $_POST['USER_DESCRIPTION'] = $totalBonus;
    $_POST['SV_BONUS'] = $totalBonus;
}


$comment = $_POST['comment'];
if(!empty($_POST['adress_comment']))
    $comment .= '. Коментар до адреси: '.$_POST['adress_comment'];

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
    "COMMENTS" => $comment,
    'BASKET_ITEMS' => $bItems['ITEMS'],
    //"DISCOUNT_VALUE" => 1.5,
    //"TAX_VALUE" => 0.0,
    "USER_DESCRIPTION" => $_POST['USER_DESCRIPTION']
);


unset($arFields['BASKET_ITEMS']);

$ORDER_ID = CSaleOrder::Add($arFields);
$ORDER_ID = IntVal($ORDER_ID);

$result['msg2'] = 'Ошибка создания заказа';
$result['msg'] = 'Ошибка создания заказа';
$result['status'] = 0;
if ($ORDER_ID > 0)
{
    $_SESSION['SALE_ORDER_ID'][] = $ORDER_ID;

    $findSertData=false;
    foreach ($idsbasket as $index => $item)
    {
        $DB -> Query('update b_sale_basket set ORDER_ID = ' . $ORDER_ID . ' where ID = ' . $item);
        if(!$findSertData)
            $findSertData = $DB->Query('select * from basket_stims where UF_ID = '.$item)->Fetch();
    }

    $propsDB = $DB->Query('select * from b_sale_order_props_value where ORDER_ID = ' . $ORDER_ID);
    $props = [];
    while ($record = $propsDB->Fetch())
        $props[$record['CODE']] = $record['ID'];

    if($props['SECOND_NAME'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($_POST['second_name']).'\' where ID = ' . $props['SECOND_NAME']);
    else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$ORDER_ID.',23, \'По батькові\', \''.addslashes($_POST['second_name']).'\', \'SECOND_NAME\', \''.$ORDER_ID.'\', \'ORDER\')');
    if($props['LASTNAME'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($_POST['fio']).'\' where ID = ' . $props['LASTNAME']);
    else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$ORDER_ID.',23, \'Прізвище\', \''.addslashes($_POST['fio']).'\', \'LASTNAME\', \''.$ORDER_ID.'\', \'ORDER\')');
    if($props['PHONE'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($_POST['phone']).'\' where ID = ' . $props['PHONE']);
    else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$ORDER_ID.',3, \'Телефон\', \''.addslashes($_POST['phone']).'\', \'PHONE\', \''.$ORDER_ID.'\', \'ORDER\')');
    if($props['EMAIL'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($_POST['email']).'\' where ID = ' . $props['EMAIL']);
    else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$ORDER_ID.',2, \'Email\', \''.addslashes($_POST['email']).'\', \'EMAIL\', \''.$ORDER_ID.'\', \'ORDER\')');
    if($props['NAME'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($_POST['name']).'\' where ID = ' . $props['NAME']);
    else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$ORDER_ID.',22, \'Імя\', \''.addslashes($_POST['name']).'\', \'NAME\', \''.$ORDER_ID.'\', \'ORDER\')');

    if($findSertData && !empty($findSertData['UF_SERT_DATA']))
    {
        $findSertData=unserialize($findSertData['UF_SERT_DATA']);
        $textSertData = '
Ім’я та прізвище відправника: '.$findSertData['sert_name_sender'].' 
Телефон відправника: '.$findSertData['sert_tel_sender'].' 
Ім’я та прізвище отримувача: '.$findSertData['send_name_receiver'].' 
Пошта отримувача: '.$findSertData['send_email_receiver'].' 
Дата відправлення сертифікату: '.$findSertData['send_date_receiver'].' 
Ваші побажання: '.$findSertData['send_desire'].' 
        ';

        if($props['SERT_DATA'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($textSertData).'\' where ID = ' . $props['SERT_DATA']);
        else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$ORDER_ID.',33, \'Дані сертифіката\', \''.addslashes($textSertData).'\', \'SERT_DATA\', \''.$ORDER_ID.'\', \'ORDER\')');
    }


    if($_POST['delivery_method'] == 14 || $_POST['delivery_method'] == 15|| $_POST['delivery_method'] == 17|| $_POST['delivery_method'] == 18)
    {
        if($_POST['delivery_method'] == 14 || $_POST['delivery_method'] == 17)
        {
            $cityName = $vid = '';
            if($_POST['choose_city_np'])
            {
                $cityName = $DB->Query('select * from np_cities_new where ID = ' . $_POST['choose_city_np']);
                if($cityName = $cityName->Fetch())
                    $cityName = $cityName['UF_NAME_UA'];
            }
            if($_POST['choose_city_np_vid'])
            {
                $vid = $DB->Query('select * from np_posts_new where ID = ' . $_POST['choose_city_np_vid']);
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
                    $vid = 'Укрпошта. '.$vid['UF_POSTINDEX'] . ', ' . $vid['UF_ADDRESS'];
            }
        }
        if($_POST['delivery_method'] == 18)
        {
            $cityName = $vid = '';

            $cityName=$_POST['np_k_city'];
            $vid = 'Нова Пошта. Кур’єр. '.$cityName.' '.$_POST['np_k_street'].' '.$_POST['np_k_kv'].' '.$_POST['np_k_dom'];
        }

        if($props['MISTO_ID'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($_POST['choose_city_np']).'\' where ID = ' . $props['MISTO_ID']);
        else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$ORDER_ID.',27, \'Місто ID\', \''.addslashes($_POST['choose_city_np']).'\', \'MISTO_ID\', \''.$ORDER_ID.'\', \'ORDER\')');
        if($props['POST_ID'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($_POST['choose_city_np_vid']).'\' where ID = ' . $props['POST_ID']);
        else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$ORDER_ID.',28, \'POST_ID\', \''.addslashes($_POST['choose_city_np_vid']).'\', \'POST_ID\', \''.$ORDER_ID.'\', \'ORDER\')');
        if($props['ADDRESS'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($vid).'\' where ID = ' . $props['ADDRESS']);
        else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$ORDER_ID.',7, \'Відділення\', \''.addslashes($vid).'\', \'ADDRESS\', \''.$ORDER_ID.'\', \'ORDER\')');
        if($props['CITY'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($cityName).'\' where ID = ' . $props['CITY']);
        else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$ORDER_ID.',5, \'Місто\', \''.addslashes($cityName).'\', \'CITY\', \''.$ORDER_ID.'\', \'ORDER\')');
    }

    # Чисто для лога
    $resOrder = $DB->Query('select * from b_sale_order_props_value where ORDER_ID = ' . $ORDER_ID);
    $findProps = [];
    while ($recordProp = $resOrder->Fetch())
        $findProps[] = $recordProp;

    # /Чисто для лога

    $result['status'] = 1;
    $result['order_id'] = $ORDER_ID;
    $result['msg'] = 'Заказ номер ' . $ORDER_ID . ' успешно создан.';

    if(isset($_SESSION['COUPON']))
    {
        $orderId = $ORDER_ID; // Замените на реальный ID заказа
        $coupon = $_SESSION['COUPON'];	//код купона, который нужно учесть в заказе
        //if($coupon == 'DASHATM_15')
        {
            $DB->Query('insert into raz_zam (UF_ORDER_ID,UF_USER_ID,UF_COUPON) values ('.$orderId.','.$uid.',\''.$coupon.'\')');
        }
        //DiscountCouponsManager::delete('Your30');
        $order = Order::load($orderId);
        $DB -> Query('update b_sale_discount set LID = \''.$order->getSiteId().'\' ');
        DiscountCouponsManager::add($coupon);
        DiscountCouponsManager::init(
            DiscountCouponsManager::MODE_ORDER,
            [
                "userId" => $order->getUserId(),
                "orderId" => $orderId
            ]
        );

        //DiscountCouponsManager::add($coupon);
        $discounts = $order->getDiscount();
        $discounts->setOrderRefresh(true);
        $r = $discounts->calculate();
        $discountData = $r->getData();

        if ($r->isSuccess() && ($discountData = $r->getData()) && !empty($discountData) && is_array($discountData))
        {
            $r = $order->applyDiscount($discountData);
        }

        $order->doFinalAction(true);
        $order->save();
        DiscountCouponsManager::delete($coupon);
    }


    sendNewEmailToClient($ORDER_ID);
    sendNewSmsToClient($ORDER_ID);


    $order_id = $ORDER_ID;

    $DB->Query('insert into facebook_purchase (UF_ORDER_ID,UF_STATUS) values ('.$order_id.',0)');

    $orderDB = $DB->Query('select * from b_sale_order where ID = ' . $order_id);
    if($order = $orderDB -> Fetch())
    {
        $uid = $order['USER_ID'];
        $user = CUser::GetByID($uid)->Fetch();
        $delivery = $DB->Query('select * from b_sale_delivery_srv where ID = ' . $order['DELIVERY_ID'])->Fetch();
        $pay = CSalePaySystem::GetByID($order['PAY_SYSTEM_ID']);

        if(CModule::IncludeModule('imaginweb.sms'))
            $phoneValue = CIWebSMS::MakePhoneNumber($user['PERSONAL_PHONE']);

        if(!$phoneValue || empty($phoneValue))
            $phoneValue = $user['PERSONAL_PHONE'];
        else
            $phoneValue = '+'.$phoneValue;

        if(!$phoneValue || empty($phoneValue))
        {
            $resPhone = $DB->Query('select * from b_sale_order_props_value where ORDER_ID = ' . $order_id . ' and ORDER_PROPS_ID = 3');
            if($resPhone = $resPhone->Fetch())
            {
                if(CModule::IncludeModule('imaginweb.sms'))
                    $phoneValue = CIWebSMS::MakePhoneNumber($resPhone['VALUE']);

                if(!$phoneValue)
                    $phoneValue = $resPhone['VALUE'];
                else
                    $phoneValue = '+'.$phoneValue;
            }

        }

        $items = [];
        $resBasket = $DB->Query('select * from b_sale_basket where ORDER_ID = ' . $order_id);
        $number = 1;
        while ($recordBasket = $resBasket->Fetch())
        {
            $link = CIBlockElement::GetByID($recordBasket['PRODUCT_ID'])->GetNext();
            $product = $DB->Query('select * from b_iblock_element where ID = ' . $recordBasket['PRODUCT_ID'])->Fetch();
            $items[] = [
                'number'=>$number,
                'name'=>$product['NAME'],
                'quantity'=>intval($recordBasket['QUANTITY']),
                'link'=>'https://www.stimma.com.ua'.$link['DETAIL_PAGE_URL'],
            ];
            $number++;
        }

        $bonuses = $order['PAYED'] == 'N' ? $order['SUM_PAID'] : 0;

        $chatIds = [];
        $find = CUser::GetList($by='ID', $or='ASC', ['!UF_CHAT_ID'=>false], ['SELECT'=>['UF_CHAT_ID']]);
        while ($record = $find->Fetch())
        {
            $chatIds[] = $record['UF_CHAT_ID'];
        }
        //if(!empty($chatIds))
        {
            //foreach($chatIds as $index => $chatId)
            {
                $send = [
                    'number'=>$order_id,
                    'amount'=>str_replace('&nbsp;',' ', FormatCurrency($order['PRICE'],'UAH')),
                    'uname'=>$_POST['fio'], //$user['NAME'],
                    'sname'=>$_POST['last_name'],//$user['LAST_NAME'],
                    'bonuses'=>$bonuses,
                    'phone'=>$phoneValue,
                    'delivery'=>str_replace(['Самовывоз','Новая почта'],['Самовивіз','Нова пошта'],$delivery['NAME']),
                    'pay'=>str_replace(['Наличными в магазине','Наложенный платеж'],['Готівкою в магазині','Накладений платіж'],$pay['NAME']),
                    //'user_id'=>$chatId,
                    'items'=>$items
                ];

                $url = 'https://notify.shop/api/v1/tg/ZgmVEdjmwolBk9rpLiNKzHftpN3zeXTIH1pj3Cgo/hook/Ao7e0ECESB28HSV8QnBcpzImi7G45E3QD2Cqt8f1';

                $sendData = json_encode( $send );

                $header = [
                    'Content-Type: application/json',
                    //'Content-Length: 0'
                ];

                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );
                curl_setopt( $ch, CURLOPT_HEADER, false );
                curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
                curl_setopt( $ch, CURLOPT_POST, 1 );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $sendData );
                $response = curl_exec( $ch );

                curl_close($ch);
                $response = json_decode( $response );
            }
        }

        $DB->Query('insert into orders_1c (UF_ORDER_ID,UF_STATUS) values ('.$order_id.',\'N\')');

    }

}
else
    Bitrix\Main\Diag\Debug::writeToFile(-1, " cant create order " , '/debug_create_order.txt');

if(isset($_POST['sql_order']) && $order_id > 0)
    foreach($_POST['sql_order'] as $index => $sql)
        $DB->Query(str_replace('#ORDER_ID#',$order_id,$sql));



// Отправка в 1с
if($order_id > 0)
{
    Bitrix\Main\Diag\Debug::writeToFile(date('d.m.Y H:i:s'), "--------------------------- "  , '/debug_create_order_stims_1c.txt');
    Bitrix\Main\Diag\Debug::writeToFile(date('d.m.Y H:i:s'), "start send to 1C order " . $order_id , '/debug_create_order_stims_1c.txt');

    $data = getOrderFor1C($order_id,'N',false);

    Bitrix\Main\Diag\Debug::writeToFile($data, "data for 1c ", '/debug_create_order_stims_1c.txt');

    $stimsItems = [];
    foreach ($data['items'] as $index => $bItem)
    {
        if($bItem['stims'])
        {
            $stimsItems[] = $bItem;
            unset($data['items'][$index]);
        }
    }

    Bitrix\Main\Diag\Debug::writeToFile($stimsItems, "Stims items" , '/debug_create_order_stims_1c.txt');

    //$url = 'http://195.201.245.102:22022/MobClient/CreateOrder/';
    $url = 'http://195.201.245.102:22022/sklad/hs/list/CreateOrder';

    $headers = [
        'Content-Type: application/json'
    ];
    $data['items']=array_values($data['items']);
    Bitrix\Main\Diag\Debug::writeToFile($data, "data for just order" , '/debug_create_order_stims_1c.txt');
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CONNECTTIMEOUT => 5,  // таймаут соединения
        CURLOPT_TIMEOUT => 10         // таймаут выполнения
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $options);

    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


    if(!empty($data['items']))
    {
        $response = curl_exec($curl);
        Bitrix\Main\Diag\Debug::writeToFile($response, "response for send 1c just order" , '/debug_create_order_stims_1c.txt');
    }
    else
        Bitrix\Main\Diag\Debug::writeToFile(date('d.m.Y H:i:s'), "dont send to 1c just order" , '/debug_create_order_stims_1c.txt');

    curl_close($curl);

    if(!empty($stimsItems)) // Створення замовлення за стімзи)
    {
        $orderId = $data['order_id'];
        $order = Order::load($orderId);
        if ($order)
        {
            $siteId = $order->getSiteId();
            $userId = $order->getUserId();
            $currency = 'STI';
            $personTypeId = $order->getPersonTypeId();

            $basket = $order->getBasket();

            $bonusItems = [];

            // --- Разделяем товары по PROP_BONUS ---
            foreach ($basket as $basketItem)
            {
                $curr = $basketItem->getCurrency();
                if($curr != 'STI') continue;
                $productId = $basketItem->getProductId();
                $bonusItems[] = $basketItem;
            }

            if (!empty($bonusItems))
            {
                // --- Создаем бонусный заказ ---
                $bonusOrder = Sale\Order::create($siteId, $userId);
                $bonusOrder->setPersonTypeId($personTypeId);

                // Создаём корзину для бонусных товаров
                $bonusBasket = Sale\Basket::create($siteId);
                foreach ($bonusItems as $item)
                {
                    $newItem = $bonusBasket->createItem('catalog', $item->getProductId());

                    $findMain = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $item->getProductId() . ' and IBLOCK_PROPERTY_ID = 390');
                    if($findMain = $findMain->Fetch())
                        $stimsProductId = $findMain['VALUE'];
                    else $stimsProductId = $item->getProductId();

                    $element = CIBlockElement::GetByID( $stimsProductId)->GetNextElement()->GetProperties();

                    Bitrix\Main\Diag\Debug::writeToFile($item->getProductId(), "Find PRODUCT_ID " .$item->getProductId()  , '/debug_create_order_stims_1c.txt');
                    Bitrix\Main\Diag\Debug::writeToFile($element, "Array PRODUCT_ID [Element] "  , '/debug_create_order_stims_1c.txt');

                    $newId = $newItem->setFields([
                                                     'QUANTITY' => $item->getQuantity(),
                                                     'PRICE' => intval($element['PROP_BONUS_PRICE']['VALUE']),            // сохраняем цену
                                                     'BASE_PRICE' => intval($element['PROP_BONUS_PRICE']['VALUE']),   // сохраняем базовую цену
                                                     'DISCOUNT_PRICE' => $item->getDiscountPrice(),
                                                     'CURRENCY' => 'STI',
                                                     'LID' => $siteId,
                                                     'NAME' => $item->getField('NAME'),
                                                     'PRODUCT_PROVIDER_CLASS' => $item->getField('PRODUCT_PROVIDER_CLASS'),
                                                 ]);
                    Bitrix\Main\Diag\Debug::writeToFile([
                                                            'QUANTITY' => $item->getQuantity(),
                                                            'PRICE' => intval($element['PROP_BONUS_PRICE']['VALUE']),            // сохраняем цену
                                                            'BASE_PRICE' => intval($element['PROP_BONUS_PRICE']['VALUE']),   // сохраняем базовую цену
                                                            'DISCOUNT_PRICE' => $item->getDiscountPrice(),
                                                            'CURRENCY' => 'STI',
                                                            'LID' => $siteId,
                                                            'NAME' => $item->getField('NAME'),
                                                            'PRODUCT_PROVIDER_CLASS' => $item->getField('PRODUCT_PROVIDER_CLASS'),
                                                        ], "added ti basket item STIMS" , '/debug_create_order_stims_1c.txt');


                    //$id = $newItem->getId();
                    //$DB->Query('insert into basket_stims (UF_ID,UF_STIMS) values ('.$id.', '.intval($item->getPrice()).')');
                }

                $bonusOrder->setBasket($bonusBasket);

                // Копируем свойства
                $props = $order->getPropertyCollection();
                $bonusProps = $bonusOrder->getPropertyCollection();
                foreach ($props as $propItem) {
                    $propId = $propItem->getField('ORDER_PROPS_ID');
                    $value = $propItem->getValue();
                    $targetProp = $bonusProps->getItemByOrderPropertyId($propId);
                    if ($targetProp) {
                        $targetProp->setValue($value);
                    }
                }

                // Доставка и оплата
                $shipmentCollection = $bonusOrder->getShipmentCollection();
                $shipment = $shipmentCollection->createItem();
                $shipment->setField('DELIVERY_NAME', 'Бонусная доставка');
                $shipmentItemCollection = $shipment->getShipmentItemCollection();
                foreach ($bonusBasket as $basketItem) {
                    $shipmentItem = $shipmentItemCollection->createItem($basketItem);
                    $shipmentItem->setQuantity($basketItem->getQuantity());
                }

                $paymentCollection = $bonusOrder->getPaymentCollection();
                $payment = $paymentCollection->createItem();
                $payment->setField('SUM', 0);
                $payment->setField('PAY_SYSTEM_NAME', 'Оплата стимзы');

                //$bonusOrder->setField('CURRENCY', 'STI');
                $bonusOrder->doFinalAction(true);

                // теперь ставим комментарий и сохраняем
                $bonusOrder->setField('COMMENTS', 'Бонусный заказ, создан из #' . $orderId);
                $bonusOrder->save();

                $bonusOrderId = $bonusOrder->getId();

                // --- Удаляем бонусные товары из основного заказа ---
                foreach ($bonusItems as $basketItem) {
                    $basket->getItemById($basketItem->getId())->delete();
                }

                $order->doFinalAction(true);
                $order->save();

                // Лог для проверки
                file_put_contents($_SERVER['DOCUMENT_ROOT'].'/local/log_bonus_orders.txt',
                                  date('Y-m-d H:i:s') . " Основной заказ: {$orderId}, бонусный: {$bonusOrderId}\n", FILE_APPEND);

                $res = $DB->Query('select * from b_sale_basket where ORDER_ID = ' . $bonusOrderId);
                while ($record = $res->Fetch())
                {
                    $DB->Query('insert into basket_stims (UF_ID,UF_STIMS) values ('.$record['ID'].', '.intval($record['PRICE']).')');
                }

                $DB->Query('update b_sale_order set CURRENCY = \'STI\' where ID = '.$bonusOrderId);

                $dataJustOrder = getOrderFor1C($orderId,'N',false);
                $dataBonusOrder = getOrderFor1C($bonusOrderId,'N',false);
                $dataJustOrder['items'] = array_values($dataBonusOrder['items']);
                $data = $dataJustOrder;

                $url = 'http://195.201.245.102:22022/sklad/hs/list/CreateOrder';

                $headers = [
                    'Content-Type: application/json'
                ];
                $data['items']=array_values($data['items']);
                Bitrix\Main\Diag\Debug::writeToFile($data, "data for STIMS order" , '/debug_create_order_stims_1c.txt');
                $options = [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_CONNECTTIMEOUT => 5,  // таймаут соединения
                    CURLOPT_TIMEOUT => 10         // таймаут выполнения
                ];

                $curl = curl_init();
                curl_setopt_array($curl, $options);

                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if(!empty($data['items']))
                {
                    $response = curl_exec($curl);
                    Bitrix\Main\Diag\Debug::writeToFile($response, "response for send 1c STIMS order" , '/debug_create_order_stims_1c.txt');
                }
                curl_close($curl);
            }
        }


    }
    else
        Bitrix\Main\Diag\Debug::writeToFile(date('d.m.Y H:i:s'), "dont send to 1c stims order" , '/debug_create_order_stims_1c.txt');

}


global $APPLICATION;
$APPLICATION->RestartBuffer();
echo json_encode($result);
//echo json_encode($result1C);