<?
    //require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Loader;
use Bitrix\Sale;
use Bitrix\Sale\Order;
use Bitrix\Sale\Basket;

$users = CUser::GetList($by='ID',$order='DESC', ['ACTIVE'=>'Y','GROUPS_ID'=>[9]]);
?>
<table>
<?
$n=1;
$need = strtotime('16.07.2026 00:00:00');
while ($user = $users->Fetch())
{
    if(!$user['EMAIL'] || strpos($user['EMAIL'],'.ru') !== false) continue;
    if(!$user['EMAIL'] || strpos($user['EMAIL'],'stimma.com.ua') !== false) continue;

    $time = strtotime($user['DATE_REGISTER']);

    //if($time < $need) continue;
        ?>
    <tr>
        <td><?=$n?></td>
        <td><?=$user['DATE_REGISTER']?></td>
        <td><?=$user['EMAIL']?></td>
    </tr>
    <?
    $n++;
}
?>
</table>
<?
die();
/*$response=addUserTo1C('380969762816', '', '', '');
?><pre>$response last <?=print_r($response,1)?></pre><?
die();*/

$user=$DB->Query('select * from b_user where PERSONAL_PHONE like \'%0638931893%\'')->Fetch();
?><pre><?=print_r($user, 1)?></pre><?
die();

generateFeedGoogleNew();
die();
$DB->Query('update b_user set XML_ID = \'1a204600-3a58-11f1-b17b-ac6e7568e201\' where ID = 85012');

$user=$DB->Query('select * from b_user where EMAIL like \'yaremenkoov1992@gmail.com\'')->Fetch();

//$user=$DB->Query('select * from b_user where ID = 86314')->Fetch();
?><pre>$user -> <?=print_r($user,1)?></pre><?

$balance=GetBalance('1a204600-3a58-11f1-b17b-ac6e7568e201');
?><pre><?=print_r($balance,1)?></pre><?
die();

$user=$DB->Query('select * from b_user where PERSONAL_PHONE like \'0509161441\'')->Fetch();
//$user=$DB->Query('select * from b_user where ID = 86314')->Fetch();
?><pre>$user -> <?=print_r($user,1)?></pre><?

die();

generateYMLCatalog();
die();

$dateFrom = new DateTime();
$dateFrom->modify('-200 days');
//$dateFrom->add('-200 days');
global $DB;

$users = $DB->Query('select * from b_user where ACTIVE = \'Y\' order by ID desc');
$need = strtotime('2025-12-28 00:00:00');

echo '<table border="1">';
echo '<tr><th>#</th><th>Email</th><th>Дата регистрации</th></tr>';
$index=1;
while ($user = $users->fetch())
{
    if(strpos($user['EMAIL'],'noemail_') !== false) continue;

    $register = strtotime($user['DATE_REGISTER']);
    if($register < $need)die();

    //$order = $DB->Query('select * from b_sale_order where USER_ID = ' . $user['ID'].' limit 1')->Fetch();
    //if(!isset($order['ID'])) continue;
    echo '<tr>';
    echo '<td>'.$index.'</td>';
    echo '<td>'.htmlspecialcharsbx($user['EMAIL']).'</td>';
    echo '<td>'.$user['DATE_REGISTER']  .'</td>';
    echo '</tr>';
    $index++;
}

echo '</table>';
die();

die();
$users = [];
$res = $DB->Query('select * from b_user where ACTIVE = \'Y\'');
while ($user = $res->Fetch())
    $users[$user['PERSONAL_PHONE']] = $user['EMAIL'];

$numbers = file($_SERVER['DOCUMENT_ROOT'].'/test/numbers.txt');
$result = [];
?><table><?
foreach($numbers as $index => $number)
{
    $number = trim($number);
    foreach($users as $phone => $email)
    {
        if(strpos($phone, $number) !== false)
        {
            $result[$number] = $email;
            ?>
            <tr>
                <td><?=$number?></td>
                <td><?=$email?></td>
            </tr>
            <?
        }
    }
}
?></table><?

die();

die();
// Production: https://u2-ext.mono.st4g3.com
// Sandbox:    https://u2-demo-ext.mono.st4g3.com
$baseUrl   = 'https://u2.monobank.com.ua';
$storeId   = '3763309543_031';
$storeSec  = '8807dfd0-be80-43fb-b3ed-20749244b96b';

$orderId = 'c3f9ddc9-2564-43fe-8824-84a4341c2778';

// 1) Формуємо тіло запиту БЕЗ зайвих пробілів/escape
$body = json_encode(['order_id' => $orderId], JSON_UNESCAPED_UNICODE);

// 2) Рахуємо підпис: Base64(HMAC-SHA256)
$signature = base64_encode(hash_hmac('sha256', $body, $storeSec, true));

// 3) Викликаємо /api/order/confirm
$ch = curl_init($baseUrl . '/api/order/confirm');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $body,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'store-id: ' . $storeId,
        'signature: ' . $signature,
    ],
]);

$response = curl_exec($ch);
?><pre>$response <?=print_r($response, 1)?></pre><?
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error    = curl_error($ch);
curl_close($ch);

if ($error) {
    // cURL помилка (мережа, DNS, TLS тощо)
    error_log("Monobank confirm cURL error: {$error}");
} else {
    $result = json_decode($response, true);
    ?><pre>$result <?=print_r($result, 1)?></pre><?
    // 200 OK — підтверджено; 401 — невалідний підпис; 404 — заявку не знайдено
    // ...
}
/**
 * $response {"order_id":"c3f9ddc9-2564-43fe-8824-84a4341c2778","state":"SUCCESS","order_sub_state":"ACTIVE"}

$result Array
(
[order_id] => c3f9ddc9-2564-43fe-8824-84a4341c2778
[state] => SUCCESS
[order_sub_state] => ACTIVE
)

 */

die();



//CSaleOrder::Update(47464, array("PAYED" => "Y"));
CSaleOrder::PayOrder(47464, "Y");

die();
generateSitemap();
die();
use Bitrix\Main\UserTable;
use Bitrix\Main\Type\DateTime;

$file = file($_SERVER['DOCUMENT_ROOT'].'/output4.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach($file as $index => $item)
{
    ?><pre><?=print_r($item, 1)?></pre><?
    $text = file_get_contents($item);
    ?><xmp><?=print_r($text, 1)?></xmp><?
    ?><pre><?=print_r('--------------------------------------------------', 1)?></pre><?
    if($index == 19)
        die();
}

?><pre><?=print_r($file, 1)?></pre><?
die();


//generateYMLCatalog();
generateFeedGoogleNew();
die();

//generateSitemap();
//die('end sitemap');

/*
$res=$DB->Query('select * from b_user where (XML_ID is null or XML_ID = \'\') and PERSONAL_PHONE is not null and PERSONAL_PHONE != \'\'');

$cnt = 0;
$updUser=new CUser;
while ($user = $res->Fetch())
{
    //$updUser->Update($user["ID"], ['UF_ONE_C'=>'']);
    $cnt++;
}
?><pre><?=print_r($cnt, 1)?></pre><?
die();
*/

/*
$user=$DB->Query('select * from b_user where EMAIL like \'Oksanamurin24031988@gmail.com\'')->Fetch();
//$user=$DB->Query('select * from b_user where ID = 86314')->Fetch();
?><pre>$user -> <?=print_r($user,1)?></pre><?

$balance=GetBalance('1b3dbcfe-8d44-11f0-9ae7-50ebf69facce');
?><pre><?=print_r($balance,1)?></pre><?
die();
*/


$order_id = 46991 ;
$order_id = 47026 ;

/*
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
die();
*/

//for($order_id = 43955; $order_id<=44066; $order_id++ )
//if($order_id > 0)
{
    echo '1<Br>';
    $data = getOrderFor1C($order_id,'N',false);


    $stimsItems = [];
    foreach ($data['items'] as $index => $bItem)
    {
        if($bItem['stims'])
        {
            $stimsItems[] = $bItem;
            unset($data['items'][$index]);
        }
    }


    //$url = 'http://195.201.245.102:22022/MobClient/CreateOrder/';
    $url = 'http://195.201.245.102:22022/sklad/hs/list/CreateOrder';

    $headers = [
        'Content-Type: application/json'
    ];

    if(!empty($data['items']))
    {
        ?><pre>$data 1<?=print_r($data,1)?></pre><?

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

        $response = curl_exec($curl);

        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Удаляем BOM перед json_decode
        $cleaned_response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
        $decoded = json_decode($cleaned_response, true);

        $result1C = [
            'error' => false,
            'http_code' => $http_code,
            'response_raw' => $response,
            'response' => $decoded
        ];
        ?><pre>$result1C - order <?=print_r($result1C,1)?></pre><?
    }

    if(!empty($stimsItems))
    {
        $data['order_id'].='-1';
        $data['items']=$stimsItems;

        ?><pre>$data stims<?=print_r($data,1)?></pre><?

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

        $response = curl_exec($curl);

        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Удаляем BOM перед json_decode
        $cleaned_response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
        $decoded = json_decode($cleaned_response, true);

        $result1C = [
            'error' => false,
            'http_code' => $http_code,
            'response_raw' => $response,
            'response' => $decoded
        ];
        ?><pre>$result1C - stims <?=print_r($result1C,1)?></pre><?
    }

    /*if (curl_errno($curl)) {
        $error = curl_error($curl);
        curl_close($curl);
        return [
                'error' => true,
                'message' => $error
        ];
    }*/


}


die();

//generateFeedGoogleNew();
//die();
$updUser=new CUser;

//$users = CUser::GetList($by='ID', $order='ASC'/*, ['UF_ONE_C'=>false]*/);
/*$users = CUser::GetList($by='ID', $order='ASC',['UF_ONE_C'=>0]);
$count=0;
while ($user = $users->Fetch())
{
    //if(empty($user['XML_ID']))
    //{
    //    $count++;
    //    $updUser->Update($user["ID"], ['UF_ONE_C'=>0]);
    //}
    $count++;
}*/
/*?><pre><?=print_r($count, 1)?></pre><?
checkUserWith1C();
?>
    <script>
        setTimeout(function(){
        }, 100);
    </script>
<?
die();*/



//$DB->Query('update b_user set XML_ID = \'621f7095-4125-11f0-96c6-f02f74213ec8\' where ID = 71470');
//$DB->Query('update b_user set XML_ID = \'d813f02c-7ff6-11f0-b16c-e1db060b0202\' where ID = 17969');
checkUserWith1C();
//$response=addUserTo1C('380957126358', 'Віта', 'Федюк', '');
?><pre>$response last <?=print_r($response,1)?></pre><?
die();
$balance=GetBalance('621f7095-4125-11f0-96c6-f02f74213ec8');
?><pre><?=print_r($balance,1)?></pre><?
die();

$users = CUser::GetList($by='ID', $order='ASC', ['UF_ONE_C'=>false]);
$count=0;
while ($user = $users->Fetch())
{
    $count++;
}
?><pre><?=print_r($count, 1)?></pre><?
//checkUserWith1C();
die();


if(CEvent::Send('FORGET_BASKET', 's1', ['TEXT'=>'test ' . date('d.m.Y H:i:s'),'EMAIL'=>'company703@gmail.com'], "Y",132)) echo '+++'; else echo '---';
if(CEvent::Send('FORGET_BASKET', 's1', ['TEXT'=>'test ' . date('d.m.Y H:i:s'),'EMAIL'=>'marushevskiy.petr@gmail.com'], "Y",132)) echo '+++'; else echo '---'; die();
die();
Loader::includeModule("sale");
Loader::includeModule("catalog");
Loader::includeModule("iblock");

global $DB;

$orderId = 44267;
$data = getOrderFor1C($orderId,'N',false);
?><pre><?=print_r($data, 1)?></pre><?
$orderId = 44268;
$data = getOrderFor1C($orderId,'N',false);
?><pre><?=print_r($data, 1)?></pre><?
die();

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
            $newId = $newItem->setFields([
                                    'QUANTITY' => $item->getQuantity(),
                                    'PRICE' => $item->getPrice(),            // сохраняем цену
                                    'BASE_PRICE' => $item->getBasePrice(),   // сохраняем базовую цену
                                    'DISCOUNT_PRICE' => $item->getDiscountPrice(),
                                    'CURRENCY' => 'STI',
                                    'LID' => $siteId,
                                    'NAME' => $item->getField('NAME'),
                                    'PRODUCT_PROVIDER_CLASS' => $item->getField('PRODUCT_PROVIDER_CLASS'),
                                ]);

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

        // Обновляем arResult, чтобы в оплату пошёл только основной заказ
        //$arResult['ORDER']['ID'] = $orderId;
        //$arResult['ORDER']['PRICE'] = $order->getPrice();
    }
}

die('success');

/*$find = $DB->Query('select * from b_user where EMAIL like \'%vita.fedyk2016@gmail.com%\'')->Fetch();
?><pre><?=print_r($find, 1)?></pre><?
die();*/
/*
$res=$DB->Query('select * from b_sale_order where COMMENTS is not null');
while ($order = $res->Fetch())
{
    echo $order['ID'].' - '.$order['COMMENTS'].'<br>';
}

die();
$result = sendSms('0984639566', 'Ваш код: 1234');
?><pre><?=print_r($result, 1)?></pre><?
if ($result['response']['reply'][0]['status'] === 'OK') {
    echo 'SMS отправлено';
} else {
    echo 'Ошибка: ' . $result['response']['reply'][0]['status'];
}

die();*/
/*$user=CUser::GetByID(3643)->Fetch();
?><pre>$user -> <?=print_r($user,1)?></pre><?
die();

checkUserWith1C();
die();*/
/*$DB->Query('update b_user set XML_ID = \'621f7095-4125-11f0-96c6-f02f74213ec8\' where ID = 71470');
//$DB->Query('update b_user set XML_ID = \'d813f02c-7ff6-11f0-b16c-e1db060b0202\' where ID = 17969');
$response=addUserTo1C('380686973320', 'Катерина', 'Солоха', '');
?><pre><?=print_r($response,1)?></pre><?
die();*/
/*$DB->Query('update b_user set XML_ID = \'621f7095-4125-11f0-96c6-f02f74213ec8\' where ID = 71470');
$user=$DB->Query('select * from b_user where EMAIL = \'katerinkasoloha@gmail.com\'')->Fetch();
$user=CUser::GetByID(71470)->Fetch();
?><pre>$user -> <?=print_r($user,1)?></pre><?

$balance=GetBalance('621f7095-4125-11f0-96c6-f02f74213ec8');
?><pre><?=print_r($balance,1)?></pre><?
die();

global $DB;
generateFeedGoogleNew();
die();*/
//sendForgetBasket();
//die('--');
/*$DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) values
                                                        (40983,7,\'Місто\',\'Зміїв\',\'CITY\',40983,\'ORDER\')');*/

//$DB->Query('update b_sale_order_props_value set CODE = \'ADDRESS\' where ID = 385274');
//$DB->Query('update b_sale_order set DELIVERY_ID = 14, PAY_SYSTEM_ID=3 where ID = 40983');
/*$DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) values
                                                        (40983,5,\'Відділення\',\'11\',\'ADDRESS\',40983,\'ORDER\')');*/
//die('^)');
// №1 Зміїв, Піщана, 2А
//$DB->Query('update b_sale_basket set NOTES = \'\' where NOTES = \'S\'');
//generateSitemap();
//die();



//$DB->Query('update b_sale_basket set NOTES = \'\' where NOTES = \'S\'');

//generateFeedGoogleNew();
//checkUserWith1C();
/*
$users = CUser::GetList($by='ID', $order='ASC', ['UF_ONE_C'=>false]);
$count=1;
while ($user = $users->Fetch()) {
    $count++;
}
?><pre><?=print_r($count,1)?></pre><?
*/

$DB->Query('update b_user set XML_ID = \'513f78b8-2029-11ed-b7c1-2cf05dad434d\' where ID = 85326');
$user=$DB->Query('select * from b_user where ID = 85326')->Fetch();
/*$response=addUserTo1C('380936115273', 'Ірина', 'Комишан', '');
?><pre><?=print_r($response,1)?></pre><?
die();*/
//$user=$DB->Query('select * from b_user where PERSONAL_PHONE like \'%93711913680%\'')->Fetch();
//$user=$DB->Query('select * from b_user where EMAIL = \'katerinkasoloha@gmail.com\'')->Fetch();
?><pre><?=print_r($user,1)?></pre><?

//$balance=GetBalance('b79de768-738c-11f0-b16c-e1db060b0202'); // та клієнтка шо під 30 тисяч було
$balance=GetBalance('513f78b8-2029-11ed-b7c1-2cf05dad434d');
?><pre><?=print_r($balance,1)?></pre><?
die();

/*sendForgetBasketEmailToClient();
die();*/
/*sendForgetBasketEmailToClient();
die();*/

//$DB->Query('update b_iblock_section_property set SMART_FILTER = \'N\' where IBLOCK_ID = 21 and PROPERTY_ID = 621');
//setMinimumPrice();
die();


$item = $DB->Query('select * from b_iblock_element where ID = 48493')->Fetch();



$me=$DB->Query("select * from b_user where ID= 1")->Fetch();
?><pre><?=print_r($me,1)?></pre><?
die();

$users = CUser::GetList($by='ID', $order='ASC', ['UF_ONE_C'=>false]);
$count=1;
while ($user = $users->Fetch()) {
    $count++;
}
?><pre><?=print_r($count,1)?></pre><?
//checkUserWith1C();

die();
GetDiscount1C('123456');
die();




//$url = 'http://195.201.245.102:22022/MobClient/CreateOrder/';
$url = 'http://195.201.245.102:22022/sklad/hs/list/GetDiscount';

$data=[
        'UidCard'=>'03d03252-6100-11ee-96d4-f02f742215f1',
        'warehouse'=>'87523e5c-af43-11eb-8fbc-305a3a45331a',
        'opt'=>false,
        'UidPromo'=>'111',
        'Goods' => [
                [
                        'SKU'=>'932ef6f5-b879-11eb-90fc-305a3a45331a',
                        'Key'=>'1',
                        'Sum'=>2999,
                ]
        ]
];

$headers = [
        'Content-Type: application/json'
];

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

$response = curl_exec($curl);
?><pre><?=print_r($response,1)?></pre><?
if (curl_errno($curl)) {
    $error = curl_error($curl);
    curl_close($curl);
    return [
            'error' => true,
            'message' => $error
    ];
}

$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

// Удаляем BOM перед json_decode
$cleaned_response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
$decoded = json_decode($cleaned_response, true);

$result1C = [
        'error' => false,
        'http_code' => $http_code,
        'response_raw' => $response,
        'response' => $decoded
];
?><pre><?=print_r($result1C,1)?></pre><?
die();

$orderId=37427;
$data = getOrderFor1C($orderId,'N',false);
?><pre><?=print_r($data,1)?></pre><?
//$url = 'http://195.201.245.102:22022/MobClient/CreateOrder/';
$url = 'http://195.201.245.102:22022/sklad/hs/list/CreateOrder';

$headers = [
        'Content-Type: application/json'
];

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

$response = curl_exec($curl);

if (curl_errno($curl)) {
    $error = curl_error($curl);
    curl_close($curl);
    return [
            'error' => true,
            'message' => $error
    ];
}

$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

// Удаляем BOM перед json_decode
$cleaned_response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
$decoded = json_decode($cleaned_response, true);

$result1C = [
        'error' => false,
        'http_code' => $http_code,
        'response_raw' => $response,
        'response' => $decoded
];
?><pre><?=print_r($result1C,1)?></pre><?
die();
$str = '+380 (98) 004-93-79';
$str=preg_replace('/[^0-9+]/', '', $str);
?><pre><?=print_r($str,1)?></pre><?
//generateXMLs();

//setMinimumPrice();
die();

$order = $DB->Query('select * from b_sale_order where ID = 157')->Fetch();

$amount = $order['PRICE'];
$amount = 1;

$orderID = $order['ID'];
$publicKey = 'sandbox_i88184991194';
$secretKey = 'sandbox_ic4MjMgrzzlx3LnZPBnew4xt84535XpLyCy0QNwo';

//$publicKey = 'sandbox_i17414932573';
//$secretKey = 'sandbox_oweIuhUVMTP9FdZAqsaRlSACn6KButT2ms8TsEse';

$json_string = '{"result_url":"https://www.stimma.com.ua/order/?ORDER_ID='.$order['ID'].'","server_url":"https://www.stimma.com.ua/pay_result/","public_key":"'.$publicKey.'","version":"3","action":"pay","amount":"'.intval($amount).'","currency":"UAH","description":"Заказ #'.$orderID.'","order_id":"'.$orderID.'"}';
$data = base64_encode($json_string);
$sign_string = $secretKey.$data.$secretKey;
$signature = base64_encode( sha1( $sign_string, 1) );

$form = '';
$form .= '<form class="paythispayment order-complete-btns" method="POST" action="https://www.liqpay.ua/api/3/checkout" accept-charset="utf-8">';
$form .= '<input type="hidden" name="data" value="'.$data.'"/>';
$form .= '<input type="hidden" name="signature" value="'.$signature.'"/>';
$form .= '<input class="btn btn-large payme" type="submit" value="Оплатить"/>';
$form .= '</form>';

echo $form;


die();


require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stimma_mail_new/header.php');

$text = '<tr><td>
<div style="text-align: center;">Ваша знижка - 10% на перше замовлення. <br>Персональний промокод '.$coupon.'</div>';
$text .= '<div style="text-align: center;"><br>*знижка/безкоштовна доставка доступна протягом 7 днів з моменту реєстрації на сайті та отримання промокоду
                                <br>Для використання введіть промокод у полі "промокод" (знижка/безкоштовна доставка не діє на товар з розділу SALE)
                                </div></td></tr>';
echo$text;
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stimma_mail_new/footer.php');
die();

global $DB;
if(isset($_GET['show']))
{
    # Порівнюємо зараз з збереженим
    require $_SERVER['DOCUMENT_ROOT'].'/upload/fix2.php';
    $res = $DB->Query('select * from b_catalog_product');
    ?><table><?
    ?>
    <tr>
        <td>Артикул</td>
        <td>Назва</td>
        <td>Внутрішній ID</td>
        <td>Було</td>
        <td>Стало</td>
        <td>Артикул</td>
    </tr>
    <?
    while ($record = $res->Fetch())
    {
        if(!$record['QUANTITY'] && $quantities[$record['ID']] > 0)
        {
            $props = CIBlockElement::GetByID($record['ID'])->GetNextElement();
            $fields = $props->GetFields();
            $props = $props->GetProperties();
            ?>
            <tr>
                <td><?=$props['ARTICLE']['VALUE']?></td>
                <td><?=$fields['NAME']?></td>
                <td><?=$fields['ID']?></td>
                <td><?=$quantities[$record['ID']]?></td>
                <td><?=$record['QUANTITY']?></td>
                <td><?=$props['ARTICLE']['VALUE']?></td>
            </tr>
            <?
        }
    }
    ?></table><?
    # /Порівнюємо зараз з збереженим
    die();
}

# Зберігаємо залишки
global $DB;
$res = $DB->Query('select * from b_catalog_product');
$result = [];
$alLCount = 0; $products = 0;
while ($record = $res->Fetch())
{
    $result[$record['ID']] = $record['QUANTITY'];
    $alLCount += $record['QUANTITY'];
    if($record['QUANTITY'])$products++;
}
?><pre><?=print_r($alLCount, 1)?></pre><?
?><pre><?=print_r($products, 1)?></pre><?
/*file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/fix4.php', '<?$quantities='.var_export($result, 1).'?>');*/

die();

# Повертаємо залишки
require $_SERVER['DOCUMENT_ROOT'].'/upload/fix3.php';
foreach($quantities as $id => $quantity)
{
    $DB->Query('update b_catalog_product set QUANTITY = '.$quantity.' where ID = '.$id);
}
# /Повертаємо залишки
die();

$codes = [];
$res = $DB->Query('select * from b_iblock_element where IBLOCK_ID = 25');
while ($record = $res->Fetch())
    if(!isset($codes[$record['CODE']])) $codes[$record['CODE']] = 1;
    else $codes[$record['CODE']]++;
foreach($codes as $index => $code)
{
    if($code == 1)
        unset($codes[$index]);
}
    ?><pre><?=print_r($codes, 1)?></pre><?
die();
$relation = [
    '95_poliester_5_elastan'                             => '661',
    '35_khlopok_60_poliester_5_elastan'                  => '661',
    '95_khlopok_5_spandeks'                              => '664',
    '100_khlopok'                                        => '418',
    '62_khlopok_38_poliester'                            => '664',
    '30_poliester_67_khlopok_3_laykra'                   => '664',
    '55_khlopok_45_poliester'                            => '664',
    '85_kotton_15_poliester'                             => '664',
    '10_sherst_45_akril_45_poliester'                    => '661',
    '65_viskoza_35_poliester'                            => '664',
    '55_viskoza_40_poliester_5_elastan'                  => '664',
    '16_viskoza_77_poliester_7_elastan'                  => '661',
    '25_shersti_50_viskoza_25_poliester'                 => '664',
    '75_khlopok_21_poliester_4_spandeks'                 => '664',
    '80_khlopok_20_poliester'                            => '664',
    '100_kozha'                                          => '418',
    '60_viskoza_33_poliester_7_elastan'                  => '664',
    '95_khlopok_5_elastan'                               => '664',
    '75_kotton_21_poliester_4_spandeks'                  => '664',
    '100_poliester'                                      => '661',
    '50_khlopok_50_akril'                                => '664',
    '45_viskoza_53_poliamid_2_metallizirovannoe_volokno' => '664',
    '50_viskoza_50_poliester'                            => '664',
    '38_sherst_35_viskoza_27_akril'                      => '664',
    '45_sherst_20_viskoza_35_poliester'                  => '664',
    '65_sherst_35_viskoza'                               => '664',
    '80_poliester_20_elastan'                            => '661',
    '100_viskoza'                                        => '418',
    '95_viskoza_5_elastan'                               => '664',
    '50_viskoza_35_poliester_15_sherst'                  => '664',
    '76_atsetat_24_viskoza'                              => '664',
    '30_len_70_viskoza'                                  => '418',
];

$unique = [];
$res = CIBlockElement::GetList([],['IBLOCK_ID' => 25, 'ACTIVE' => 'Y','!PROPERTY_SOSTAV'=>[418,661,664]]);
?><table><?
while ($record = $res->GetNextElement())
{
    $fields = $record->GetFields();
    $props = $record->GetProperties();

    if(!$props['SOSTAV']['VALUE']) continue;
    ?>
    <tr>
        <td style="border:1px solid black;"><?=$fields['NAME']?></td>
        <td style="border:1px solid black;"><?=$props['SOSTAV']['VALUE']?></td>
        <td style="border:1px solid black;"><?=$relation[trim($props['SOSTAV']['VALUE_XML_ID'])]?></td>
    </tr>
    <?
    $props['SOSTAV']['VALUE'] = str_replace(PHP_EOF,'',$props['SOSTAV']['VALUE']);
    $unique[$props['SOSTAV']['VALUE']] = $props['SOSTAV']['VALUE'];

    //CIBlockElement::SetPropertyValuesEx($fields['ID'], false, array("SOSTAV" => $relation[trim($props['SOSTAV']['VALUE_XML_ID'])]));
}
?></table><?

?><table><?
    foreach($unique as $index => $item)
    {
        ?>
        <tr>
            <td><?=$item?></td>
        </tr>
        <?
    }
?></table><?

die();

$res = CIBlockElement::GetList([],['IBLOCK_ID' => 25, 'ACTIVE' => 'Y','>catalog_QUANTITY'=>0]);
$articles = [];

while ($record = $res->GetNextElement())
{
    $props = $record->GetProperties();
    $fields = $record->GetFields();
    //$res2 = $DB->Query('select * from b_catalog_product where ID = '.$fields['ID'])->Fetch();
    if(strlen($props['ARTICLE']['VALUE']) < 6)
    {
        $articles[$fields['ID']] = [
                'id'=>$fields['ID'],
                'name'=>$fields['NAME'],
                'article'=>$props['ARTICLE']['VALUE'],
        ];

        //if(!empty($props['ARTICLE']['VALUE']))
            //$articles[$fields['ID']] = $props['ARTICLE']['VALUE'];
        //else
            //$articles[$fields['ID']] = $fields['NAME'];
    }
}
//$articles = array_unique($articles);

?>
    <table>
        <tr>
            <td>ID</td>
            <td>Имя</td>
            <td>Артикул</td>
        </tr>
<?
foreach($articles as $index => $article)
{
    ?>
        <tr>
            <td><?=$article['id']?></td>
            <td><?=$article['name']?></td>
            <td><?=$article['article']?></td>
        </tr>
    <?
}

?></table><?
die();








/*global $DB;
if(!empty($_POST))
{
    echo CUtil::translit($_POST['name'], 'ru', ['replace_space' => '-', 'replace_other' => '-']);
}
?>
    <form action="/test/" method="post">
        <input type="text" name="name" id="">
        <input type="submit" value="Отримати код">
    </form>
<?

die();*/


die();
global $DB;
$cnt = $DB->Query('select count(ID) as cnt from b_catalog_product  where QUANTITY > 0')->Fetch();
?><pre><?=print_r($cnt, 1)?></pre><?
die();
$DB->Query('update b_catalog_product set QUANTITY = 0');
die();

$res = $DB->Query('select * from b_iblock_element where IBLOCK_ID = 25');
while ($record = $res->Fetch())
{
    preg_match('/(\d+)/',$record['NAME'], $matches);
    if($matches[1])
    {
        CIBlockElement::SetPropertyValuesEx($record['ID'], false, array('ARTICLE' => $matches[1]));
    }
}

die();

$query = "update np_posts_new set 
                        UF_SHORT_ADRESS_UA='Миньківці, Квітнева, 15А',
                        UF_SHORT_ADRESS_RU='',
                        UF_PHONE='380800500609',
                        UF_TYPE='841339c7-591a-42e2-8233-7a0a00f0ed6f',
                        UF_REF_ID='f220c0ef-fd3c-11ed-9eb1-d4f5ef0df2b8',
                        UF_NUMBER='1',
                        UF_CITY_REF_ID='a8a20d8b-fba0-11ed-a361-48df37b92096',
                        UF_LON='29.479210000000000',
                        UF_LAT='49.796065000000000',
                        UF_SCHEULDE='',
                        UF_STATUS='Working',
                        UF_ACTIVE='1',
                        UD_DATE_UPD='22.04.2024 17:04:09' where ID = 28513";

$DB->Query($query);

die();

$items[] = [
    'number'=>1,
    'name'=>'товар',
    'quantity'=>12,
    'link'=>'https://www.stimma.com.ua',
];

$send = [
    'number'=>12,
    'amount'=>str_replace('&nbsp;',' ', FormatCurrency(12,'UAH')),
    'uname'=>'X',
    'sname'=>'Я',
    'phone'=>'asdasd',
    'delivery'=>'asdasd',
    'pay'=>'asdasd',
    'user_id'=>160831010,
    'items'=>$items
];
?><pre><?=print_r($send, 1)?></pre><?
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
$response = json_decode( $response );
?><pre><?=print_r($response, 1)?></pre><?
die();
$res = $DB->Query('select * from np_cities_new');
while ($record = $res->Fetch())
{
    $valueUA = $record['UF_NAME_UA'];
    $valueRU = $record['UF_NAME_RU'];

    $valueUA = str_replace(['’',"'"],['',''],$valueUA);
    $valueRU = str_replace(['’',"'"],['',''],$valueRU);
    $DB->Query('update np_cities_new set UF_SEARCH_UA = \''.$valueUA.'\',UF_SEARCH_RU = \''.$valueRU.'\' where ID = '.$record['ID']);
}

die();


$DB->Query("insert into np_posts_new (UF_SHORT_ADRESS_UA,UF_SHORT_ADRESS_RU,UF_PHONE,UF_TYPE,UF_REF_ID,UF_NUMBER,UF_CITY_REF_ID,UF_LON,UF_LAT,UF_SCHEULDE,UF_STATUS,UF_ACTIVE) values ('Миньківці, Квітнева, 15А','','380800500609','841339c7-591a-42e2-8233-7a0a00f0ed6f','f220c0ef-fd3c-11ed-9eb1-d4f5ef0df2b8','1','a8a20d8b-fba0-11ed-a361-48df37b92096','29.479210000000000','49.796065000000000','','Working','1')");

echo $_SERVER['DOCUMENT_ROOT'];


die();

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/classes/NP.php';

$np = NP::getInstance();
$np -> updatePostList();
//$np -> updateCities();
die();

saveQuantity();
die();

use Bitrix\Sale\DiscountCouponsManager;
//$_SESSION['JIPO'] = 1;
$orderId = 4519; // Замените на реальный ID заказа
$coupon = "Your30";	//код купона, который нужно учесть в заказе
DiscountCouponsManager::delete('Your30');die();
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
die();

// ID вашего заказа

// Проверяем, что заказ успешно загружен
    // Код купона
    $couponCode = 'Your30';

$order = Order::load($orderId);


//DiscountCouponsManager::init();
//\Bitrix\Sale\DiscountCouponsManager::add($couponCode);

$oBasket = \Bitrix\Sale\Basket::loadItemsForOrder($order);
$oDiscounts = \Bitrix\Sale\Discount::loadByBasket($oBasket);
\Bitrix\Sale\DiscountCouponsManager::add($couponCode);
$oBasket->refreshData([ 'PRICE' ,  'COUPONS']);
$oDiscounts->calculate();
$result = $oDiscounts->getApplyResult();
$oBasket->save();

?><pre>$result 1<?=print_r($result, 1)?></pre><?

DiscountCouponsManager::init(
        DiscountCouponsManager::MODE_ORDER,
        [
            "userId" => $order->getUserId(),
            "orderId" => $orderId
        ]
    );
//$orderDisc = DiscountCouponsManager::load();
    ?><pre><?=print_r([
                          "userId" => $order->getUserId(),
                          "orderId" => $order->getId()
                      ], 1)?></pre><?
    $result = DiscountCouponsManager::add($couponCode);
    var_dump($result);
    $discounts = $order->getDiscount();
    ?><pre><?=print_r($discounts, 1)?></pre><?
    $discounts->calculate();
    $order->doFinalAction(true);
    $order->save();

//unset($_SESSION['COUPON']);

//sendNewEmailToClient(2891);
die();

global $DB;
$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'SECTION_ID' => 350]);
$cnt = 0;
while ($record = $res->Fetch())
{
    $cnt++;
    $DB->Query('update b_iblock_element set SORT = 1000 where ID = ' . $record['ID']);
    ?><pre><?=print_r($record['ID'], 1)?></pre><?
}
?><pre><?=print_r($cnt, 1)?></pre><?
//getInstagramPhotos();
//sendSertCoupon();
die('2');
$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 25]);
$variants = [];
?>
<table>
<?
while ($record = $res->GetNextElement())
{
    $props = $record->GetProperties();


    $variants[$props['VID']['VALUE_ENUM_ID']] = $props['VID']['VALUE_ENUM'];
}
foreach($variants as $index => $variant)
{
    ?>
    <tr>
        <td><?=$index?></td>
        <td><?=$variant?></td>
    </tr>
    <?
}
?>
</table>
    <?
//generateFeedGoogle();
//updateSortingProduct();
die();
/**
 * вид
 *  вязана сукня
 */
$ar = [
    '110698',
'110691',
'110692',
'110378',
'110371',
'110372',
'110341',
'110342',
'110368',
'110361',
'110362',
'110298',
'110291',
'110292',
'110158',
'110151',
'110152',
'110328',
'110321',
'110322',
'110148',
'110141',
'110142',
'110143',
'110471',
'110472',
'110473',
'108658',
'108651',
'108652',
'110528',
'110521',
'110558',
'110551',
'110552',
'110553',
'110518',
'110511',
'110512',
'110358',
'110351',
'110352',
'110338',
'110331',
'110332',
'110308',
'110301',
'110302',
'110388',
'110381',
'110382',
'110383',
'110398',
'110391',
'110392',
'110393',
'110481',
'110482',
'110483',
'110318',
'110311',
'110312',
'110548',
'110541',
'110542',
'110543',
'110278',
'110271',
'110272',
'110568',
'110561',
'110562',
'110563',
'110538',
'110531',
'110508',
'110501',
'110502',
'110638',
'110631',
'110632',
'110628',
'110621',
'110622',
];
foreach($ar as $index => $item)
{
    $res = $DB -> Query('select * from b_iblock_element where IBLOCK_ID = 25 and NAME like \'% '.$item.' %\'');
    if($record = $res->Fetch())
    {
        $DB->Query('update b_catalog_product set QUANTITY = 10, AVAILABLE = \'Y\' where ID = ' . $record['ID']);
        $DB->Query('update b_iblock_element set ACTIVE = \'Y\' where ID = ' . $record['ID']);
    }

}


//sendOrderToB24();
die();


$res = CIBlockElement::GetList([], ['IBLOCK_ID'=>40],false,false,['ID','IBLOCK_ID','PROPERTY_OLD_LINK','PROPERTY_NEW_LINK']);
$items = $delete = [];
while ($record = $res->Fetch())
    $items[$record['PROPERTY_NEW_LINK_VALUE']][] = $record['ID'];
foreach ($items as $index => $item)
{
    if(count($item) == 1)
        unset($items[$index]);
    else
    {
        foreach ($item as $index2 => $item2)
        {
            if(isset($item[$index2+1]))
            {
                //CIBlockElement::Delete($item2);
                $delete[] = $item2;
            }
        }
    }
}
?><pre><?=print_r($items, 1)?></pre><?
//generateFeedGoogle();
die();

/*
$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21,'SECTION_ID' =>352,'ACTIVE'=>'Y']);
$int=0;
$NotIs = [];
while ($record = $res->Fetch())
{
    $NotIs[] = $record['ID'];
    $int++;

}
$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21,'ACTIVE'=>'Y']);
$int=0;
$NotIs = [];
while ($record = $res->Fetch())
{
    if(in_array($record['ID'], $NotIs)) continue;

    CIBlockElement::SetPropertyValuesEx($record['ID'], false, ['USE_ACTION' => 1310]);
    $res2 = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_CML2_LINK' => $record['ID']]);
    while ($record2 = $res2 -> Fetch())
        CIBlockElement::SetPropertyValuesEx($record2['ID'], false, ['USE_ACTION' => 1311]);
}

?><pre><?=print_r(count($NotIs), 1)?></pre><?
die();

$res = CIBlockElement::GetList(['IBLOCK_ID' => 21]);
while ($record = $res->Fetch())
{
    CIBlockElement::SetPropertyValuesEx($record['ID'], false, ['USE_ACTION' => false]);
    $res2 = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_CML2_LINK' => $record['ID']]);
    while ($record2 = $res2 -> Fetch())
        CIBlockElement::SetPropertyValuesEx($record2['ID'], false, ['USE_ACTION' => false]);
}
die();


$res = $DB -> Query('select * from b_iblock_section_element where IBLOCK_SECTION_ID in (389,383,378)');
$els = [];
while ($record = $res -> Fetch())
    $els[$record['IBLOCK_ELEMENT_ID']] = $record['IBLOCK_ELEMENT_ID'];
foreach ($els as $index => $item)
{
    CIBlockElement::SetPropertyValuesEx($item, false, ['USE_ACTION' => 1310]);
    $res2 = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_CML2_LINK' => $item]);
    while ($record2 = $res2 -> Fetch())
        CIBlockElement::SetPropertyValuesEx($record2['ID'], false, ['USE_ACTION' => 1311]);
}

die();
*/

CModule::IncludeModule('iblock');

$mainProps = ['COLOR'];
$offerProps = ['RAZMER', 'VID','SOSTAV','SELECTION','STYLES','PRINT'];

$props = [];
foreach ($mainProps as $index => $mainProp)
{
    $res = CIBlockProperty::GetList([], ['IBLOCK_ID' => 21, 'CODE'=>$mainProp]);
    while ($record = $res -> Fetch())
        $props[$mainProp] = $record;

    $res = $DB->Query('select * from main_colors');
    while ($record = $res->Fetch())
        $props[$mainProp]['values'][$record['UF_XML_ID']] = $record['UF_NAME'];
}

foreach ($offerProps as $index => $offerProp)
{
    $res = CIBlockProperty::GetList([], ['IBLOCK_ID' => 25,'CODE'=>$offerProp]);
    while ($record = $res -> Fetch())
    {
        $props[$offerProp] = $record;

        $res2 = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID'=>25, 'CODE' => $offerProp]);
        while ($record2 = $res2 -> Fetch())
            $props[$offerProp]['values'][$record2['ID']] = $record2['XML_ID'];
    }
}

$variants = [
    'COLOR'=>[],
    'RAZMER'=>[],
    'VID'=>[],
    'SOSTAV'=>[],
    'SELECTION'=>[],
    'STYLES'=>[],
    'PRINT'=>[],

    /*'COLOR-RAZMER'=>[],
        'COLOR-VID'=>[],
        'COLOR-SOSTAV'=>[],
        'COLOR-SELECTION'=>[],
        'COLOR-STYLES'=>[],
        'COLOR-PRINT'=>[],

        'RAZMER-VID'=>[],
        'RAZMER-SOSTAV'=>[],
        'RAZMER-SELECTION'=>[],
        'RAZMER-STYLES'=>[],
        'RAZMER-PRINT'=>[],

        'VID-SOSTAV'=>[],
        'VID-SELECTION'=>[],
        'VID-STYLES'=>[],
        'VID-PRINT'=>[],

        'SOSTAV-SELECTION'=>[],
        'SOSTAV-STYLES'=>[],
        'SOSTAV-PRINT'=>[],

        'SELECTION-STYLES'=>[],
        'SELECTION-PRINT'=>[],

        'STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID'=>[],
        'COLOR-RAZMER-SOSTAV'=>[],
        'COLOR-RAZMER-SELECTION'=>[],
        'COLOR-RAZMER-STYLES'=>[],
        'COLOR-RAZMER-PRINT'=>[],

        'COLOR-VID-SOSTAV'=>[],
        'COLOR-VID-SELECTION'=>[],
        'COLOR-VID-STYLES'=>[],
        'COLOR-VID-PRINT'=>[],

        'COLOR-SOSTAV-SELECTION'=>[],
        'COLOR-SOSTAV-STYLES'=>[],
        'COLOR-SOSTAV-PRINT'=>[],

        'COLOR-SELECTION-STYLES'=>[],
        'COLOR-SELECTION-PRINT'=>[],

        'COLOR-STYLES-PRINT'=>[],

        'RAZMER-VID-SOSTAV'=>[],
        'RAZMER-VID-SELECTION'=>[],
        'RAZMER-VID-STYLES'=>[],
        'RAZMER-VID-PRINT'=>[],

        'RAZMER-SOSTAV-SELECTION'=>[],
        'RAZMER-SOSTAV-STYLES'=>[],
        'RAZMER-SOSTAV-PRINT'=>[],

        'RAZMER-SELECTION-STYLES'=>[],
        'RAZMER-SELECTION-PRINT'=>[],

        'RAZMER-STYLES-PRINT'=>[],

        'VID-SOSTAV-SELECTION'=>[],
        'VID-SOSTAV-STYLES'=>[],
        'VID-SOSTAV-PRINT'=>[],

        'VID-SELECTION-STYLES'=>[],
        'VID-SELECTION-PRINT'=>[],

        'VID-STYLES-PRINT'=>[],

        'SOSTAV-SELECTION-STYLES'=>[],
        'SOSTAV-SELECTION-PRINT'=>[],

        'SOSTAV-STYLES-PRINT'=>[],

        'SELECTION-STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID-SOSTAV'=>[],
        'COLOR-RAZMER-VID-SELECTION'=>[],
        'COLOR-RAZMER-VID-STYLES'=>[],
        'COLOR-RAZMER-VID-PRINT'=>[],

        'COLOR-RAZMER-SOSTAV-SELECTION'=>[],
        'COLOR-RAZMER-SOSTAV-STYLES'=>[],
        'COLOR-RAZMER-SOSTAV-PRINT'=>[],

        'COLOR-RAZMER-SELECTION-STYLES'=>[],
        'COLOR-RAZMER-SELECTION-PRINT'=>[],

        'COLOR-RAZMER-STYLES-PRINT'=>[],

        'COLOR-VID-SOSTAV-SELECTION'=>[],
        'COLOR-VID-SOSTAV-STYLES'=>[],
        'COLOR-VID-SOSTAV-PRINT'=>[],

        'COLOR-VID-SELECTION-STYLES'=>[],
        'COLOR-VID-SELECTION-PRINT'=>[],

        'COLOR-VID-STYLES-PRINT'=>[],

        'COLOR-SOSTAV-SELECTION-STYLES'=>[],
        'COLOR-SOSTAV-SELECTION-PRINT'=>[],

        'COLOR-SOSTAV-STYLES-PRINT'=>[],

        'COLOR-SELECTION-STYLES-PRINT'=>[],

        'RAZMER-VID-SOSTAV-SELECTION'=>[],
        'RAZMER-VID-SOSTAV-STYLES'=>[],
        'RAZMER-VID-SOSTAV-PRINT'=>[],

        'RAZMER-VID-SELECTION-STYLES'=>[],
        'RAZMER-VID-SELECTION-PRINT'=>[],

        'RAZMER-VID-STYLES-PRINT'=>[],

        'RAZMER-SOSTAV-SELECTION-STYLES'=>[],
        'RAZMER-SOSTAV-SELECTION-PRINT'=>[],

        'RAZMER-SOSTAV-STYLES-PRINT'=>[],

        'RAZMER-SELECTION-STYLES-PRINT'=>[],

        'VID-SOSTAV-SELECTION-STYLES'=>[],
        'VID-SOSTAV-SELECTION-PRINT'=>[],

        'VID-SOSTAV-STYLES-PRINT'=>[],

        'SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID-SOSTAV-SELECTION'=>[],
        'COLOR-RAZMER-VID-SOSTAV-STYLES'=>[],
        'COLOR-RAZMER-VID-SOSTAV-PRINT'=>[],

        'COLOR-RAZMER-VID-SELECTION-STYLES'=>[],
        'COLOR-RAZMER-VID-SELECTION-PRINT'=>[],

        'COLOR-RAZMER-VID-STYLES-PRINT'=>[],

        'COLOR-RAZMER-SOSTAV-SELECTION-STYLES'=>[],
        'COLOR-RAZMER-SOSTAV-SELECTION-PRINT'=>[],

        'COLOR-RAZMER-SOSTAV-STYLES-PRINT'=>[],

        'COLOR-RAZMER-SELECTION-STYLES-PRINT'=>[],

        'COLOR-VID-SOSTAV-SELECTION-STYLES'=>[],
        'COLOR-VID-SOSTAV-SELECTION-PRINT'=>[],

        'COLOR-VID-SOSTAV-STYLES-PRINT'=>[],

        'COLOR-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'RAZMER-VID-SOSTAV-SELECTION-STYLES'=>[],
        'RAZMER-VID-SOSTAV-SELECTION-PRINT'=>[],

        'RAZMER-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'VID-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID-SOSTAV-SELECTION-STYLES'=>[],
        'COLOR-RAZMER-VID-SOSTAV-SELECTION-PRINT'=>[],

        'COLOR-RAZMER-VID-SOSTAV-STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID-SELECTION-STYLES-PRINT'=>[],

        'COLOR-RAZMER-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'COLOR-VID-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'RAZMER-VID-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID-SOSTAV-SELECTION-STYLES-PRINT'=>[],*/
];
$links=[];
$int = 0;
$res = CIBlockSection::GetList(['DEPTH_LEVEL'=>'asc'], ['IBLOCK_ID' => 21, 'ACTIVE'=>'Y','!ID' => [350,351,352,510]]);
while ($record = $res->GetNext())
{
    $res2 = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'ACTIVE' => 'Y','SECTION_ID'=>$record['ID'],'INCLUDE_SUBSECTIONS'=>'Y'], false,false,['ID','IBLOCK_ID','PROPERTY_COLOR']);
    while ($recordProduct = $res2->Fetch())
    {
        //$links[$record['ID']][] = '/filter/color-is-'.$recordProduct['PROPERTY_COLOR_VALUE'].'/apply/';

        $tpDb = CIBlockElement::GetList([],
                                        ['IBLOCK_ID' => 25, 'ACTIVE' => 'Y','PROPERTY_CML2_LINK'=>$recordProduct['ID'],'INCLUDE_SUBSECTIONS'=>'Y'], false,false,
                                        ['ID','IBLOCK_ID','PROPERTY_RAZMER','PROPERTY_VID','PROPERTY_SOSTAV','PROPERTY_SELECTION','PROPERTY_STYLES','PROPERTY_PRINT']);

        while ($tp = $tpDb->Fetch())
        {
            foreach ($variants as $codes => $variant)
            {
                $cache = explode('-', $codes);

                $link = $name = $linkNew = $ids = [];
                foreach ($cache as $index => $code)
                {
                    //if($code != 'RAZMER') continue;

                    $name[] = $props[$code]['NAME'];
                    $ids[] = $props[$code]['ID'];
                    $value = $code == 'COLOR' ? $recordProduct['PROPERTY_'.$code.'_VALUE'] : $props[$code]['values'][$tp['PROPERTY_'.$code.'_ENUM_ID']];
                    if(empty(strtolower($value))) continue;
                    $link[] = strtolower($code).'-is-'.strtolower($value);
                    $linkNew[] = strtolower($value);
                }

                if(empty($link) || empty($linkNew)) continue;

                $name = implode('+', $name);
                $ids = implode('+', $ids);

                //$links[$record['ID']]['section_name'] = $record['NAME'];
                $links[$record['ID']][$codes]['name'] = $name;
                $links[$record['ID']][$codes]['ids'] = $ids;
                $links[$record['ID']][$codes]['code'] = CUtil::translit($name, 'ru');

                $old = $record['SECTION_PAGE_URL'].'filter/'.implode('/',$link).'/apply/';
                $new = $record['SECTION_PAGE_URL'].implode('/',$linkNew).'/';
                $links[$record['ID']][$codes]['links'][$old] = $new;
                /*$links[$record['ID']]['links'][] =
                [
                        'old'=>$record['SECTION_PAGE_URL'].'filter/'.implode('/',$link).'/apply/',
                        'new'=>$record['SECTION_PAGE_URL'].implode('/',$linkNew).'/',
                ];*/
            }
        }
    }

}
$int = 0;
foreach ($links as $index => $link)
{
    //$links[$index]['links'] = array_unique($links[$index]['links']);
    $int += count($links[$index]['links']);
}

$el = new CIBlockElement;
$bs  = new CIBlockSection;
foreach ($links as $sid => $linkItemsList)
{
    $res = CIBlockSection::GetList([], ['IBLOCK_ID' => 40, 'UF_CATALOG_SECTION_ID'=>$sid])->Fetch();

    if($res['ID'])
    {
        foreach ($linkItemsList as $propCode => $linkItems)
        {
            $res2 = CIBlockSection::GetList([],['IBLOCK_ID'=>40,'SECTION_ID'=>$res['ID'],'UF_IDS'=>$linkItems['ids']]);
            if(!$res2 = $res2->Fetch())
            {
                $addID = $bs ->Add([
                                       "ACTIVE" => 'Y',
                                       "IBLOCK_SECTION_ID" => $res['ID'],
                                       "IBLOCK_ID" => 40,
                                       "NAME" => "Свойство: " . $linkItems['name'],
                                       "UF_IDS" => $linkItems['ids'],
                                   ]);
            }
            else
            {
                $addID = $res2['ID'];
            }

            if($addID>0)
            {
                foreach ($linkItems['links'] as $old => $new)
                {
                    $exist = CIBlockElement::GetList([], ['IBLOCK_ID'=>40, 'PROPERTY_OLD_LINK' => $old, 'PROPERTY_NEW_LINK'=>$linkNew]);
                    if(!$exist = $exist->Fetch())
                    {
                        $propsList = [
                            'OLD_LINK'=>$old,
                            'NEW_LINK'=>$new,
                        ];
                        $arAdd = [
                            "IBLOCK_SECTION_ID" => $addID,
                            "IBLOCK_ID"      => 40,
                            "PROPERTY_VALUES"=> $propsList,
                            "NAME"           => $linkItems['name'],
                            "ACTIVE"         => "Y",
                        ];
                        $ID = $el->Add($arAdd);

                        if(!$ID)
                        {
                            ?><pre><?=print_r($arAdd, 1)?></pre><?
                            ?><pre><?=print_r($el->LAST_ERROR, 1)?></pre><?
                        }
                    }
                }
            }
            else
            {
                ?><pre><?=print_r($linkItems['name'], 1)?></pre><?
                ?><pre><?=print_r($linkItems['ids'], 1)?></pre><?
                ?><pre><?=print_r($linkItems['code'], 1)?></pre><?
                echo $bs->LAST_ERROR;
            }
        }


    }
}


//$links = array_unique($links);
?><pre><?=print_r($int, 1)?></pre><?
?><pre><?=print_r($links, 1)?></pre><?

die();

function getCombinations($arrays, $current = array()) {
    if (empty($arrays)) {
        return array($current);
    }

    $result = array();
    $firstArray = array_shift($arrays);
    foreach ($firstArray as $key=>$element)
    {
        $newCurrent = array_merge($current, array($key));
        $result = array_merge($result, getCombinations($arrays, $newCurrent));
    }

    return $result;
}

/*// Пример использования:
$arr1 = array(1, 2);
$arr2 = array('a', 'b', 'c');
$arr3 = array('X', 'Y');

$arrays = array($arr1, $arr2, $arr3);
$result = getCombinations($arrays);

// Выводим все комбинации
foreach ($result as $combination) {
    echo implode(', ', $combination) . "<br>";
}

die();*/

function getLinks($props,$codes,&$links,$link='')
{
    $startLink = '/filter';
    $endLink = 'apply/';
    $link = '';
    foreach ($codes as $index => $code)
    {

    }
}

$mainProps = ['COLOR'];
$offerProps = ['RAZMER', 'VID','SOSTAV','SELECTION','STYLES','PRINT'];

$props = [];
foreach ($mainProps as $index => $mainProp)
{
    $res = CIBlockProperty::GetList([], ['IBLOCK_ID' => 21, 'CODE'=>$mainProp]);
    while ($record = $res -> Fetch())
        $props[$mainProp] = $record;

    $res = $DB->Query('select * from main_colors');
    while ($record = $res->Fetch())
        $props[$mainProp]['values'][$record['UF_XML_ID']] = $record['UF_NAME'];
}

foreach ($offerProps as $index => $offerProp)
{
    $res = CIBlockProperty::GetList([], ['IBLOCK_ID' => 25,'CODE'=>$offerProp]);
    while ($record = $res -> Fetch())
    {
        $props[$offerProp] = $record;

        $res2 = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID'=>25, 'CODE' => $offerProp]);
        while ($record2 = $res2 -> Fetch())
            $props[$offerProp]['values'][$record2['XML_ID']] = $record2['VALUE'];
    }
}

$variants = [
        'COLOR'=>[],
        'RAZMER'=>[],
        'VID'=>[],
        'SOSTAV'=>[],
        'SELECTION'=>[],
        'STYLES'=>[],
        'PRINT'=>[],

        'COLOR-RAZMER'=>[],
        'COLOR-VID'=>[],
        'COLOR-SOSTAV'=>[],
        'COLOR-SELECTION'=>[],
        'COLOR-STYLES'=>[],
        'COLOR-PRINT'=>[],

        'RAZMER-VID'=>[],
        'RAZMER-SOSTAV'=>[],
        'RAZMER-SELECTION'=>[],
        'RAZMER-STYLES'=>[],
        'RAZMER-PRINT'=>[],

        'VID-SOSTAV'=>[],
        'VID-SELECTION'=>[],
        'VID-STYLES'=>[],
        'VID-PRINT'=>[],

        'SOSTAV-SELECTION'=>[],
        'SOSTAV-STYLES'=>[],
        'SOSTAV-PRINT'=>[],

        'SELECTION-STYLES'=>[],
        'SELECTION-PRINT'=>[],

        'STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID'=>[],
        'COLOR-RAZMER-SOSTAV'=>[],
        'COLOR-RAZMER-SELECTION'=>[],
        'COLOR-RAZMER-STYLES'=>[],
        'COLOR-RAZMER-PRINT'=>[],

        'COLOR-VID-SOSTAV'=>[],
        'COLOR-VID-SELECTION'=>[],
        'COLOR-VID-STYLES'=>[],
        'COLOR-VID-PRINT'=>[],

        'COLOR-SOSTAV-SELECTION'=>[],
        'COLOR-SOSTAV-STYLES'=>[],
        'COLOR-SOSTAV-PRINT'=>[],

        'COLOR-SELECTION-STYLES'=>[],
        'COLOR-SELECTION-PRINT'=>[],

        'COLOR-STYLES-PRINT'=>[],

        'RAZMER-VID-SOSTAV'=>[],
        'RAZMER-VID-SELECTION'=>[],
        'RAZMER-VID-STYLES'=>[],
        'RAZMER-VID-PRINT'=>[],

        'RAZMER-SOSTAV-SELECTION'=>[],
        'RAZMER-SOSTAV-STYLES'=>[],
        'RAZMER-SOSTAV-PRINT'=>[],

        'RAZMER-SELECTION-STYLES'=>[],
        'RAZMER-SELECTION-PRINT'=>[],

        'RAZMER-STYLES-PRINT'=>[],

        'VID-SOSTAV-SELECTION'=>[],
        'VID-SOSTAV-STYLES'=>[],
        'VID-SOSTAV-PRINT'=>[],

        'VID-SELECTION-STYLES'=>[],
        'VID-SELECTION-PRINT'=>[],

        'VID-STYLES-PRINT'=>[],

        'SOSTAV-SELECTION-STYLES'=>[],
        'SOSTAV-SELECTION-PRINT'=>[],

        'SOSTAV-STYLES-PRINT'=>[],

        'SELECTION-STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID-SOSTAV'=>[],
        'COLOR-RAZMER-VID-SELECTION'=>[],
        'COLOR-RAZMER-VID-STYLES'=>[],
        'COLOR-RAZMER-VID-PRINT'=>[],

        'COLOR-RAZMER-SOSTAV-SELECTION'=>[],
        'COLOR-RAZMER-SOSTAV-STYLES'=>[],
        'COLOR-RAZMER-SOSTAV-PRINT'=>[],

        'COLOR-RAZMER-SELECTION-STYLES'=>[],
        'COLOR-RAZMER-SELECTION-PRINT'=>[],

        'COLOR-RAZMER-STYLES-PRINT'=>[],

        'COLOR-VID-SOSTAV-SELECTION'=>[],
        'COLOR-VID-SOSTAV-STYLES'=>[],
        'COLOR-VID-SOSTAV-PRINT'=>[],

        'COLOR-VID-SELECTION-STYLES'=>[],
        'COLOR-VID-SELECTION-PRINT'=>[],

        'COLOR-VID-STYLES-PRINT'=>[],

        'COLOR-SOSTAV-SELECTION-STYLES'=>[],
        'COLOR-SOSTAV-SELECTION-PRINT'=>[],

        'COLOR-SOSTAV-STYLES-PRINT'=>[],

        'COLOR-SELECTION-STYLES-PRINT'=>[],

        'RAZMER-VID-SOSTAV-SELECTION'=>[],
        'RAZMER-VID-SOSTAV-STYLES'=>[],
        'RAZMER-VID-SOSTAV-PRINT'=>[],

        'RAZMER-VID-SELECTION-STYLES'=>[],
        'RAZMER-VID-SELECTION-PRINT'=>[],

        'RAZMER-VID-STYLES-PRINT'=>[],

        'RAZMER-SOSTAV-SELECTION-STYLES'=>[],
        'RAZMER-SOSTAV-SELECTION-PRINT'=>[],

        'RAZMER-SOSTAV-STYLES-PRINT'=>[],

        'RAZMER-SELECTION-STYLES-PRINT'=>[],

        'VID-SOSTAV-SELECTION-STYLES'=>[],
        'VID-SOSTAV-SELECTION-PRINT'=>[],

        'VID-SOSTAV-STYLES-PRINT'=>[],

        'SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID-SOSTAV-SELECTION'=>[],
        'COLOR-RAZMER-VID-SOSTAV-STYLES'=>[],
        'COLOR-RAZMER-VID-SOSTAV-PRINT'=>[],

        'COLOR-RAZMER-VID-SELECTION-STYLES'=>[],
        'COLOR-RAZMER-VID-SELECTION-PRINT'=>[],

        'COLOR-RAZMER-VID-STYLES-PRINT'=>[],

        'COLOR-RAZMER-SOSTAV-SELECTION-STYLES'=>[],
        'COLOR-RAZMER-SOSTAV-SELECTION-PRINT'=>[],

        'COLOR-RAZMER-SOSTAV-STYLES-PRINT'=>[],

        'COLOR-RAZMER-SELECTION-STYLES-PRINT'=>[],

        'COLOR-VID-SOSTAV-SELECTION-STYLES'=>[],
        'COLOR-VID-SOSTAV-SELECTION-PRINT'=>[],

        'COLOR-VID-SOSTAV-STYLES-PRINT'=>[],

        'COLOR-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'RAZMER-VID-SOSTAV-SELECTION-STYLES'=>[],
        'RAZMER-VID-SOSTAV-SELECTION-PRINT'=>[],

        'RAZMER-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'VID-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID-SOSTAV-SELECTION-STYLES'=>[],
        'COLOR-RAZMER-VID-SOSTAV-SELECTION-PRINT'=>[],

        'COLOR-RAZMER-VID-SOSTAV-STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID-SELECTION-STYLES-PRINT'=>[],

        'COLOR-RAZMER-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'COLOR-VID-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'RAZMER-VID-SOSTAV-SELECTION-STYLES-PRINT'=>[],

        'COLOR-RAZMER-VID-SOSTAV-SELECTION-STYLES-PRINT'=>[],
];
foreach ($variants as $index => $variant)
{
    $cache = explode('-', $index);
    $name=$links=[];
    //getLinks($props, $cache, $links);

    $arrays = [];
    foreach ($cache as $codeProp)
    {
        $name[] = $props[$codeProp]['NAME'];
        $arrays[] = $props[$codeProp]['values'];
    }
    if(count($arrays) == 3)
    $result = getCombinations($arrays);

    foreach ($result as $combination) {
        $links[] = implode('/', $combination);
    }

    $name = implode('+', $name);

    $variants[$index]['name'] = $name;
    $variants[$index]['code'] = CUtil::translit($name, 'ru');
    $variants[$index]['links'] = $links;
}

?><pre><?=print_r($variants, 1)?></pre><?

$mainProps = ['COLOR'];
$offerProps = ['RAZMER', 'VID','SOSTAV','SELECTION','STYLES','PRINT'];

?><pre><?=print_r($props, 1)?></pre><?
die();
$optIDs = [
    8548,8557,8540,8514,4469,4477,4253,4365,4458,4571,4372,4376,4380,4561,4558,4519,4523,4527,4384,4462,4538,4543,4266,4263,4260,4575,4534,4531,4548,4551,4386,4332
];
foreach ($optIDs as $index => $optID)
{
    $res2 = CIBlockElement::GetList([],['IBLOCK_ID' => 25, 'PROPERTY_CML2_LINK' => $optID]);
    while ($rec = $res2->Fetch())
        CIBlockElement::SetPropertyValuesEx($rec['ID'], false, array('SELECTION' => [668]));

    $DB -> Query('insert into b_iblock_section_element (IBLOCK_ELEMENT_ID, IBLOCK_SECTION_ID) values ('.$optID.', 352)');
}
$res = $DB -> Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID in ('.implode(',',$optIDs).') and IBLOCK_SECTION_ID = 352');
while ($record = $res->Fetch())
{
    echo $record['ID'].'<br>';
}
echo 'end';
//generateSitemap();
//generateFeedGoogle();
die();

$res = $DB -> Query('select * from b_iblock_section_element where IBLOCK_SECTION_ID in (389,383,378)');
$els = [];
while ($record = $res -> Fetch())
    $els[$record['IBLOCK_ELEMENT_ID']] = $record['IBLOCK_ELEMENT_ID'];
foreach ($els as $index => $item)
{
    CIBlockElement::SetPropertyValuesEx($item, false, ['USE_ACTION' => 1310]);
    $res2 = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_CML2_LINK' => $item]);
    while ($record2 = $res2 -> Fetch())
        CIBlockElement::SetPropertyValuesEx($record2['ID'], false, ['USE_ACTION' => 1311]);
}

?><pre><?=print_r($els, 1)?></pre><?
//generateFeedGoogle();
die();

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stimma_mail/header.php';

$id = 157;
global $DB;
$orderRecord = $DB -> Query('select * from b_sale_order where ID = ' . $id)->Fetch();
    global $DB;

    $res = $DB -> Query('select * from b_sale_basket where ORDER_ID = '.$id);
    while ($record = $res -> Fetch())
    {
        $record['PRODUCT'] = \CIBlockElement::GetByID($record['PRODUCT_ID']) -> GetNext();
        //            /if ($arItem['PROPERTIES']['NAME_'.UPPER_LANGUAGE_ID]['VALUE']) $arItem['NAME'] = $arItem['PROPERTIES']['NAME_'.UPPER_LANGUAGE_ID]['VALUE'];

        $record['PRODUCT']['NAME'] = CIBlockElement::GetProperty(35, $record['PRODUCT_ID'], '','', ['CODE' => 'NAME_UA']) -> Fetch()["VALUE"];
        $record['NAME'] = $record['PRODUCT']['NAME'];
        $arBasket[] = $record;
    }

    $email = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and ORDER_PROPS_ID = 2') -> Fetch()['VALUE'];
    $name = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and (ORDER_PROPS_ID = 1 or ORDER_PROPS_ID = 22)');
    while ($names = $name -> Fetch())
    {
        if($names['VALUE'])
        {
            $name = $names['VALUE'];
            break;
        }
    }

    if(!$email)
    {
        $orderRecord = $DB -> Query('select * from b_sale_order where ID = '.$id) -> Fetch();
        $user = \CUser::GetByID($orderRecord['USER_ID']) -> Fetch();
        $email = $user['EMAIL'];
    }

    ob_start();
    ?>
    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
        <td style="box-sizing: border-box; padding: 0; margin: 0;">
            <table class="table-body" style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #3d441d; padding: 20px 10px;" width="100%">
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <?/*<h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Доброго дня<?=$name ? ', '.$name : '!'?></h2>*/?>
                        <h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Дякуємо за замовлення</h2>
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <p class="table-body-text" style="box-sizing: border-box; padding: 0; margin: 0;  padding-bottom: 10px;font-style: italic;">
                            Привіт, подружко!
                        </p>
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <p class="table-body-text" style="box-sizing: border-box; padding: 0; margin: 0;  padding-bottom: 10px;">
                            Ми вже працюємо над твоїм замовленням. Зовсім скоро ми зателефонуємо для уточнення деталей.
                        </p>
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;">Проглянь ще раз своє замовлення. Ти точно нічого не забула?:</h3>
                    </td>
                </tr>
                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                        <?
                        $amount = 0;
                        foreach ($arBasket as $index => $item)
                        {
                            $file = \CFile::GetFileArray($item['PRODUCT']['PREVIEW_PICTURE'])['SRC'];
                            $amount += $item['PRICE']*$item['QUANTITY'];
                            $titleUA = CIBlockElement::GetProperty(25, $item['PRODUCT']['ID'], array("sort" => "asc"), Array("CODE"=>"NAME_UA"))->Fetch()['VALUE'];
                            ?>
                            <table class="table-list-item" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #3d441d; padding-bottom: 10px; padding-top: 10px; border-bottom: 1px solid #333333;" width="100%">
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td class="table-list-item-img" style="box-sizing: border-box; padding: 0; margin: 0; padding-right: 15px;">
                                        <a href="https://www.stimma.com.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0;">
                                            <img src="https://www.stimma.com.ua<?=$file?>" style="box-sizing: border-box; padding: 0; margin: 0; max-width: 100px;">
                                        </a>
                                    </td>
                                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                        <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #3d441d;" width="100%">
                                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <td class="table-list-item-name" colspan="2" style="box-sizing: border-box; padding: 0; margin: 0; padding-bottom: 30px;">
                                                    <a href="https://www.stimma.com.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0; color: #3d441d; font-size: 16px; text-decoration: none; font-weight: bold;"><?=$titleUA?></a>
                                                </td>
                                            </tr>
                                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <td class="table-list-item-number" style="box-sizing: border-box; padding: 0; margin: 0; text-align: right; font-size: 16px;" align="right">
                                                    <?=FormatCurrency($item['PRICE'], 'UAH')?> x <?=intval($item['QUANTITY'])?> шт
                                                </td>
                                                <td class="table-list-item-price" style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold; text-align: right;" align="right">
                                                    <?=FormatCurrency($item['PRICE']*$item['QUANTITY'], 'UAH')?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <?
                        }
                        ?>
                        <table class="table-list-total" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #3d441d; padding-top: 30px; text-align: right; font-size: 16px;" width="100%" align="right">
                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                    Сума: <span style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold;"><?=FormatCurrency($amount,'UAH')?></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?
    $html = ob_get_clean();

if($email)
{
    $arFieldsSend = [
        'TEXT' => $html,
        'NUMBER' => $id,
        'EMAIL' => $email
    ];
    if(CEvent::SendImmediate("BS_SALE_NEW_ORDER", "s1", $arFieldsSend, 'Y', 102))echo '+++';
    else echo '----';
}


require $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stimma_mail/footer.php';

die();



if(mail('company703@gmail.com','test','test')) echo '+++';
else echo '---';

$arFieldsSend = [
    'TEXT' => 'its my text',
    'NUMBER' => 125,
    'EMAIL' => 'company703@gmail.com'
];
CEvent::Send("BS_SALE_NEW_ORDER", "s1", $arFieldsSend, 'Y', 102);

die();
Bitrix\Main\Diag\Debug::writeToFile('start sendOrderToB24', "debug_b24 " , '/debug_b24.txt');
$idsToB24 = COption::GetOptionString('main', 'order_ro_b24', '');
$idsToB24 = explode(',',$idsToB24);
?><pre><?=print_r($idsToB24, 1)?></pre><?
die();

echo date('d.m.Y H:i:s');
die();
global $DB;
$sql ='select * from b_sale_order_props_value where ORDER_ID = 84 and ORDER_PROPS_ID = 3';
$res = $DB -> Query($sql)->Fetch();
?><pre><?=print_r($res, 1)?></pre><?

die('2');


die();
require_once 'vendor/autoload.php';

// Замените YOUR_API_KEY на свой API ключ
$apiKey = 'YOUR_API_KEY';

// Замените YOUR_SENDER_NAME на имя отправителя (без пробелов)
$senderName = 'YOUR_SENDER_NAME';

// Замените YOUR_PHONE_NUMBER на номер телефона получателя в формате +79111234567
$phoneNumber = 'YOUR_PHONE_NUMBER';

// Замените YOUR_TEMPLATE_ID на ID шаблона SMS, который вы создали в личном кабинете Esputnik
$templateId = 'YOUR_TEMPLATE_ID';

// Создаем клиент Guzzle и передаем ему API ключ
$client = new GuzzleHttp\Client([
                                    'base_uri' => 'https://api.esputnik.com',
                                    'headers' => [
                                        'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
                                    ],
                                ]);

// Формируем данные для отправки SMS
$data = [
    'messages' => [
        [
            'from' => $senderName,
            'to' => $phoneNumber,
            'templateId' => $templateId,
        ],
    ],
];

// Отправляем запрос на сервер API Esputnik и получаем ответ
$response = $client->post('/v1/message/sms/send', [
    'json' => $data,
]);

// Выводим статус ответа и тело ответа
echo $response->getStatusCode() . ' ' . $response->getReasonPhrase() . PHP_EOL;
echo $response->getBody() . PHP_EOL;


die();

if(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/services/main/ajax.php'))
    echo '++';
else
    echo '--';

$accessToken = 'IGQVJWVDVqd0dUdnYteFNvTWJmbDJ3NGo1TTJkVGcwWnZASc212bDVnMW9FdVNkTlZAMVDdNUnlpMlRFZA3RuSnFWbS1QLXdvd2VLSlE4ZAzhJek9TaVV3UlRvbUFvWUFBYUxDOGZAJVHE4UnV0OEw5RXk3MwZDZD';


// todo якшо токен созданий менше як 60 днів.. то не получиться обновить
/*$url = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=" . $accessToken;

$instagramCnct = curl_init(); // инициализация cURL подключения
curl_setopt($instagramCnct, CURLOPT_URL, $url); // адрес запроса
curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
$response = json_decode(curl_exec($instagramCnct)); // получаем и декодируем данные из JSON
curl_close($instagramCnct); // закрываем соединение

// обновляем токен и дату его создания в базе

$accessToken = $response->access_token; // обновленный токен*/


$url = "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink&access_token=" . $accessToken;
$instagramCnct = curl_init(); // инициализация cURL подключения
curl_setopt($instagramCnct, CURLOPT_URL, $url); // адрес запроса
curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
$media = json_decode(curl_exec($instagramCnct)); // получаем и декодируем данные из JSON
curl_close($instagramCnct); // закрываем соединение
$ar = [];
foreach ($media -> data as $index => $datum)
{
    $ar[$datum -> id] = [
            'photo' => $datum -> media_url,
            'link' => $datum->permalink
    ];
}

$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 36, 'NAME' => array_keys($ar)]);
while ($record = $res -> Fetch())
    unset($ar[$record['NAME']]);

ksort($ar);
$el = new CIBlockElement();
foreach ($ar as $id => $item)
{
    $el -> Add(
        [
            "IBLOCK_ID" => 36,
            "NAME"           => $id,
            "ACTIVE"         => "Y",
            "PREVIEW_TEXT"   => $item['link'],
            "PREVIEW_PICTURE" => CFile::MakeFileArray($item['photo'])
        ]
    );
}

?><pre><?=print_r($media, 1)?></pre><?
die();


$link = 'https://www.stimma.com.ua/bitrix/services/main/ajax.php?analyticsLabel[FILTER_ID]=tbl_user&analyticsLabel[GRID_ID]=tbl_user&analyticsLabel[PRESET_ID]=default_filter&analyticsLabel[FIND]=N&analyticsLabel[ROWS]=Y&mode=ajax&c=bitrix:main.ui.filter&action=setFilter';
$get = array(
    'name'  => 'Alex',
    'email' => 'mail@example.com'
);

$ch = curl_init($link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);

echo $html;
die();
setMinimumPrice();
die();
$colorRef = $color = [];
$res = $DB -> Query('select * from max_color_reference');
while ($record = $res -> Fetch())
    $colorRef[$record['UF_XML_ID']] = $record;
$res = $DB -> Query('select * from main_colors');
while ($record = $res -> Fetch())
{
    $record['UF_COLORS'] = unserialize($record['UF_COLORS'], ['allowed_classes' => false]);
    $color[$record['ID']] = $record;
}

$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'PROPERTY_COLOR' => false],false,false,['ID','NAME','PROPERTY_COLOR_REF']);
while ($record = $res -> Fetch())
{
    $valueXmlID = false;
    $xmlIdColorRef = $record['PROPERTY_COLOR_REF_VALUE'];
    $colorRefID = $colorRef[$xmlIdColorRef]['ID'];
    foreach ($color as $index => $item)
    {
        if(in_array($colorRefID, $item['UF_COLORS']))
        {
            $valueXmlID = $item['UF_XML_ID'];
            break;
        }
    }
    CIBlockElement::SetPropertyValuesEX(
        $record['ID'],
        21,
        ['COLOR' => $valueXmlID]
    );
}
?><pre><?=print_r($color, 1)?></pre><?

//generateFeedGoogle();
die();
$ar = [
    '1' => 	'Бежевый',
'2' => 	'Белый',
'3' => 	'Бордовый',
'4' => 	'Голубой',
'5' => 	'Желтый',
'6' => 	'Зеленый',
'7' => 	'Коричневый',
'8' => 	'Красный',
'9' => 	'Оранжевый',
'10' => 	'Розовый',
 	'11' => 	'Серый',
'12' => 	'Синий',
'13' => 	'Фиолетовый',
'14' => 	'Черный',
];
foreach ($ar as $index => $item)
{
    $ar[$index] = CUtil::translit($item, 'ru', ['replace_space' => '_', 'replace_other' => '_']);
}
?><pre><?=print_r($ar, 1)?></pre><?
die();


?>
    <div class="easyzoom easyzoom--overlay">
    <a href="/upload/iblock/b5c/ixmo6k6183xicr8urxf2pyi2oua9zk9k.jpg" tabindex="0">
        <img src="/upload/resize_cache/iblock/b5c/545_800_1/ixmo6k6183xicr8urxf2pyi2oua9zk9k.jpg" alt="Женская юбка Stimma Эрис, колір - оливка">
    </a>
    </div>
    <script>
        $(document).ready(function()
        {
            $('.easyzoom').easyzoom();
        })
    </script>
<?
die();
generateXMLs();
die();
require_once $_SERVER['DOCUMENT_ROOT'] . '/get_auto_list/phpQuery.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/get_auto_list/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'].'/test/items_photos.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/test/list_photos.php';
//$photosLink
foreach ($items as $index => $item)
{
    $link = $item['url'];
    $id = $item['id'];

    $html = getContent($link);
    $doc = phpQuery::newDocument($html);

    $hrefs = [];
    foreach ($doc -> find('.images .product-image') as $index2 => $item2)
    {
        $hrefs[] = pq($item2) -> attr('href');
    }

    if(!empty($hrefs) && count($hrefs) > 1)
        $photosLink[$id] = $hrefs;

    unset($items[$index]);

    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/list_photos.php', '<?$photosLink='.var_export($photosLink, 1).';?>');
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/items_photos.php', '<?$items='.var_export($items, 1).';?>');

    ?><pre><?=print_r($id, 1)?></pre><?
    ?><pre><?=print_r($hrefs, 1)?></pre><?

    ?>
    <script>
        function sayHi() {
            location.reload();
        }
        setTimeout(sayHi, 100);
    </script>
    <?
    echo 'left:'.count($items).'<br>';
    die('process');
}


die('end');


require_once $_SERVER['DOCUMENT_ROOT'].'/test/list_photos.php';
foreach ($photosLink as $id => $items)
{
    if(intval($id) <= 0 || empty($items)) continue;
    $item = CIBlockElement::GetByID($id) -> GetNextElement() -> GetProperties();
    $photos = $item['PHOTO_GALLERY']['VALUE'];

    if(!$photos || count($photos) == 1)
    {
        $files = [];
        foreach ($items as $index => $item)
        {
            $img = explode('/',$item);
            $path = $_SERVER['DOCUMENT_ROOT'].'/test/imgs/'.end($img);
            $files[] = '/test/imgs/'.end($img);
            $fileCOntent = file_get_contents($item);
            file_put_contents($path, $fileCOntent);
        }

        if(!empty($files))
        {
            $values = [];
            foreach ($files as $index => $file)
            {
                $values[] = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].$file);
            }
            CIBlockElement::SetPropertyValuesEx($id, 21, array('PHOTO_GALLERY' => $values) );
        }
        ?><pre><?=print_r($files, 1)?></pre><?
        ?><pre><?=print_r($id, 1)?></pre><?
    }

    unset($photosLink[$id]);

    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/list_photos.php', '<?$photosLink='.var_export($photosLink, 1).';?>');
    ?>
    <script>
        function sayHi() {
            location.reload();
        }
        setTimeout(sayHi, 100);
    </script>
    <?
    echo 'left:'.count($photosLink).'<br>';
    die('process');
    }

    die('end');


$index = isset($_GET['index']) ? $_GET['index'] : 0;

$res = $DB -> Query('select * from b_file');

$links = [];
$start  = strtotime(date('d.m.Y H:i:s'));
while ($record = $res -> Fetch())
{
    if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/'.$record['SUBDIR'].'/'.$record['FILE_NAME']))
    {
        $path = 'https://stimma.bservice.club/upload/'.$record['SUBDIR'].'/'.$record['FILE_NAME'];
        $links[] = $path;

      /*  $fileCOntent = file_get_contents($path);

        if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/upload/'.$record['SUBDIR']))
            mkdir($_SERVER['DOCUMENT_ROOT'].'/upload/'.$record['SUBDIR']);

        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/'.$record['SUBDIR'].'/'.$record['FILE_NAME'], $fileCOntent);
*/?><!--<pre><?/*=print_r($_SERVER['DOCUMENT_ROOT'].'/upload/'.$record['SUBDIR'].'/'.$record['FILE_NAME'], 1)*/?></pre><?/*
        $index++;
        $end  = strtotime(date('d.m.Y H:i:s'));

        if($end - $start >= 3)
        {
            */?>
            <script>
                function sayHi() {
                    location.href = '/test/?index=<?/*=$index*/?>';
                }

                setTimeout(sayHi, 100);
            </script>
            --><?/*
            die('process ...  ');

        }*/

    }
}
?><pre><?=print_r($links, 1)?></pre><?
die();

$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'PREVIEW_PICTURE' => false, 'DETAIL_PICTURE' => false]);
$ids = [];
$el = new CIBlockElement;
while ($record = $res -> Fetch())
{
    $ids[$record['ID']] = false;

    $res2 = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'ACTIVE' => 'Y','PROPERTY_CML2_LINK' => $record['ID']]);
    while ($record2 = $res2 -> Fetch())
    {
        if($record2['PREVIEW_PICTURE'] && !$ids[$record['ID']])
            $ids[$record['ID']] = $record2['PREVIEW_PICTURE'];
        if($record2['DETAIL_PICTURE'] && !$ids[$record['ID']])
            $ids[$record['ID']] = $record2['DETAIL_PICTURE'];
    }

    if(!$ids[$record['ID']])
        unset($ids[$record['ID']]);
    else
    {
        $el->Update($record['ID'],
        [
            "DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].CFile::GetFileArray($ids[$record['ID']])['SRC']),
            "PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].CFile::GetFileArray($ids[$record['ID']])['SRC']),
        ]);
    }
}

?><pre><?=print_r(count($ids), 1)?></pre><?
die('2');

$APPLICATION->SetTitle("Блог");
/*setMinimumPrice();
die();*/
/*$res = $DB -> Query('select * from size_table');
$Products = $variants = [];
while ($record = $res -> Fetch())
{
    //$Products[$record['UF_PRODUCT']] = $record['UF_PRODUCT'];
    $table = unserialize($record['UF_TABLE'], ['allowed_classes' => false]);
    foreach ($table as $index => $items)
    {
        foreach ($items as $index2 => $item)
        {
            $table[$index][$index2] = str_replace(
                ['ПОГ', 'ПОТ', 'ПОБ'],
                ['Обхват грудей','Обхват талії','Обхват бедер'],
                $item
            );
        }

        if(!$index) continue;
        $variants[$items[0]] = $items[0];
    }

    $record['UF_TABLE'] = serialize($table);
    //$DB -> Query('update size_table set UF_TABLE = \''.$record['UF_TABLE'].'\' where ID = ' . $record['ID']);
}
?><pre><?=print_r($variants, 1)?></pre><?
die();*/
/*$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21], false, false, ['ID','IBLOCK_ID', 'NAME', 'PROPERTY_MODEL']);
?>
<table>
    <tr>ID</tr>
    <tr>Назва</tr>
<?
while ($record = $res -> Fetch())
{
    if(!isset($Products[$record['ID']]))
    {
        ?>
        <tr>
            <td><?=$record['ID']?></td>
            <td><?=$record['NAME']?> <?=$record['PROPERTY_MODEL_VALUE']?></td>
        </tr>
        <?
        $exists[] = [$record['ID'],$record['NAME']];
    }
}
?></table><?
die();*/
/*
$urls=array ( 5335 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-avelin20228698?attribute_pa_razmer=m&attribute_pa_cvet=nyudovij', 4077 => 'https://www.stimma.com.ua/shop/zhenskij-krop-top-stimma-alejna-8699?attribute_pa_razmer=xs&attribute_pa_cvet=nyudovyj', 4083 => 'https://www.stimma.com.ua/shop/zhenskij-krop-top-stimma-alejna-8691?attribute_pa_razmer=m&attribute_pa_cvet=serebryano-chyornyj', 5214 => 'https://www.stimma.com.ua/shop/zhinochi-bryuki-stimma-allisum-8646-2?attribute_pa_razmer=m&attribute_pa_cvet=chernij', 4080 => 'https://www.stimma.com.ua/shop/zhenskij-krop-top-stimma-alejna-8692?attribute_pa_razmer=m&attribute_pa_cvet=chernyj', 5338 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-avelin-8697?attribute_pa_razmer=m&attribute_pa_cvet=chernij', 5356 => 'https://www.stimma.com.ua/shop/zhinocha-shuba-stimma-kalateya-9997?attribute_pa_razmer=s&attribute_pa_cvet=shokolad', 5265 => 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-chirsti-9959?attribute_pa_razmer=m&attribute_pa_cvet=kremovo-bezhevij', 5359 => 'https://www.stimma.com.ua/shop/zhinocha-shuba-stimma-kalateya-9998?attribute_pa_razmer=s&attribute_pa_cvet=bezhevo-kremovyj', 5227 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-feodora-9978?attribute_pa_razmer=m&attribute_pa_cvet=gorixova-poloska', 5241 => 'https://www.stimma.com.ua/shop/zhinochij-golf-stimma-riniya-9986?attribute_pa_razmer=l&attribute_pa_cvet=molochnyj', 5365 => 'https://www.stimma.com.ua/shop/zhinocha-shuba-stimma-oriyeta-9993?attribute_pa_razmer=s&attribute_pa_cvet=bezhevo-krem', 5332 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-eshlin-9988?attribute_pa_razmer=s&attribute_pa_cvet=bezhevaya', 5321 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-ejfa-9994?attribute_pa_razmer=m&attribute_pa_cvet=bezhevaya', 5313 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-sajvi-9963?attribute_pa_razmer=l&attribute_pa_cvet=bezhevaya', 5329 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-eshlin-9987?attribute_pa_razmer=s&attribute_pa_cvet=pudra', 5223 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-feodora-9979?attribute_pa_razmer=m&attribute_pa_cvet=kremova-klitinka', 5318 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-sajvi-9964?attribute_pa_razmer=m&attribute_pa_cvet=molochnyj', 5325 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-ejfa-9995?attribute_pa_razmer=m&attribute_pa_cvet=melanzh', 5309 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-sajvi-9962?attribute_pa_razmer=l&attribute_pa_cvet=melanzh', 5273 => 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-chirsti-9961?attribute_pa_razmer=m&attribute_pa_cvet=sv-blakitnij', 5204 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-rudes-9943?attribute_pa_razmer=m&attribute_pa_cvet=t-korichnevij-nyud', 5170 => 'https://www.stimma.com.ua/shop/zhinochij-svitshot-stimma-barsenij-9992?attribute_pa_razmer=m&attribute_pa_cvet=sv-sirij', 5152 => 'https://www.stimma.com.ua/shop/zhinochij-golf-stimma-tigrana-9934?attribute_pa_razmer=l&attribute_pa_cvet=kapuchino', 5160 => 'https://www.stimma.com.ua/shop/zhinochij-golf-stimma-tigrana-9935?attribute_pa_razmer=l&attribute_pa_cvet=bezhevo-olivkovyj', 5128 => 'https://www.stimma.com.ua/shop/zhinocha-kurtka-stimma-rozaliya-9938?attribute_pa_razmer=m&attribute_pa_cvet=glyase-2', 5187 => 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-sivel-9749?attribute_pa_razmer=m&attribute_pa_cvet=lilovyj', 5167 => 'https://www.stimma.com.ua/shop/zhinochij-svitshot-stimma-barsenij-9989?attribute_pa_razmer=m&attribute_pa_cvet=siro-bilij', 5164 => 'https://www.stimma.com.ua/shop/zhinochij-svitshot-stimma-barsenij-9991?attribute_pa_razmer=m&attribute_pa_cvet=melanzh', 5138 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-xroder-9973?attribute_pa_razmer=m&attribute_pa_cvet=olivka', 5143 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-eniya-9957?attribute_pa_razmer=m&attribute_pa_cvet=glyase-2', 5173 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-brium-9975?attribute_pa_razmer=s&attribute_pa_cvet=siro-korichnevij', 5146 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-eniya-9958?attribute_pa_razmer=m&attribute_pa_cvet=latte', 5176 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-brium-9974?attribute_pa_razmer=xxs&attribute_pa_cvet=xolodnij-lid', 5149 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-eniya-9999?attribute_pa_razmer=m&attribute_pa_cvet=mentol', 5135 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-xroder-9972?attribute_pa_razmer=m&attribute_pa_cvet=melanzh', 5185 => 'https://www.stimma.com.ua/shop/zhinochij-svitshot-stimma-beteliya-9981?attribute_pa_razmer=m&attribute_pa_cvet=melanzh', 5156 => 'https://www.stimma.com.ua/shop/zhinochij-golf-stimma-tigrana-9936?attribute_pa_razmer=l&attribute_pa_cvet=seraya', 5140 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-xroder-9971?attribute_pa_razmer=m&attribute_pa_cvet=siro-bilij', 5179 => 'https://www.stimma.com.ua/shop/zhinocha-kurtka-stimma-vejsi-9983?attribute_pa_razmer=m&attribute_pa_cvet=glyase-2', 5182 => 'https://www.stimma.com.ua/shop/zhinocha-kurtka-stimma-vejsi-9984?attribute_pa_razmer=m&attribute_pa_cvet=chernij', 5125 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-nadijdiya-9950?attribute_pa_razmer=s&attribute_pa_cvet=blakitnij', 5120 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-nadijdiya-9949?attribute_pa_razmer=m&attribute_pa_cvet=svitlo-gorixovij', 5110 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-farzana-9946?attribute_pa_razmer=m&attribute_pa_cvet=bezhevaya', 5101 => 'https://www.stimma.com.ua/shop/zhinochij-svitshot-stimma-bagnij-9948?attribute_pa_razmer=m&attribute_pa_cvet=fistashka', 5116 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-glafira-9921?attribute_pa_razmer=l&attribute_pa_cvet=vanil', 5093 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-bornij-9929?attribute_pa_razmer=xxs&attribute_pa_cvet=glyase-2', 5095 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-bornij-9928?attribute_pa_razmer=xxs&attribute_pa_cvet=pudra', 5112 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-amiriya-9941?attribute_pa_razmer=l&attribute_pa_cvet=siro-bilij', 5098 => 'https://www.stimma.com.ua/shop/zhinochij-svitshot-stimma-bagnij-9947?attribute_pa_razmer=m&attribute_pa_cvet=nizhno-rozhevij', 5122 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-nadijdiya-9951?attribute_pa_razmer=s&attribute_pa_cvet=blakitnij', 5049 => 'https://www.stimma.com.ua/shop/zhinoche-xudi-podovzhene-gayane-9905?attribute_pa_razmer=xxs&attribute_pa_cvet=lajm', 5067 => 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-gress-9838?attribute_pa_razmer=s&attribute_pa_cvet=zelenij', 5058 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-pelageya-9910?attribute_pa_razmer=m&attribute_pa_cvet=siro-bilij', 5069 => 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-gress-9839?attribute_pa_razmer=s&attribute_pa_cvet=lajm', 5029 => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-rufina-9912?attribute_pa_razmer=xxs&attribute_pa_cvet=xolodnij-lid', 5065 => 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-gress-9837?attribute_pa_razmer=s&attribute_pa_cvet=gorchica', 5038 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-andreniya-9898?attribute_pa_razmer=m&attribute_pa_cvet=latte', 5046 => 'https://www.stimma.com.ua/shop/zhinoche-xudi-podovzhene-gayane-9904?attribute_pa_razmer=xxs&attribute_pa_cvet=zheltyj', 5063 => 'https://www.stimma.com.ua/shop/zhinochij-kardigan-stimma-musfira-9793?attribute_pa_razmer=s&attribute_pa_cvet=bezhevo-pomaranchevij', 5017 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-anisiya-9880?attribute_pa_razmer=m&attribute_pa_cvet=lajm', 5023 => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-rufina-9913?attribute_pa_razmer=xxs&attribute_pa_cvet=zheltyj', 5052 => 'https://www.stimma.com.ua/shop/zhinoche-xudi-podovzhene-gayane-9906?attribute_pa_razmer=xxs&attribute_pa_cvet=chernij', 5077 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-sava-9876?attribute_pa_razmer=xl&attribute_pa_cvet=chernij', 5074 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-sava-9874?attribute_pa_razmer=xl&attribute_pa_cvet=orexovyj', 5020 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-anisiya-9878?attribute_pa_razmer=m&attribute_pa_cvet=siro-bilij', 5032 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-sevastiya-9903?attribute_pa_razmer=m&attribute_pa_cvet=bezhevaya-pudra', 5055 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-pelageya-9909?attribute_pa_razmer=m&attribute_pa_cvet=bezhevaya-pudra', 5061 => 'https://www.stimma.com.ua/shop/zhinochij-kardigan-stimma-musfira-9792?attribute_pa_razmer=s&attribute_pa_cvet=bezhevo-kremovyj', 5071 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-sava-9875?attribute_pa_razmer=xl&attribute_pa_cvet=glyase-2', 5026 => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-rufina-9911?attribute_pa_razmer=xxs&attribute_pa_cvet=molochnyj', 5035 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-sevastiya-9902?attribute_pa_razmer=s&attribute_pa_cvet=siro-bilij', 4990 => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-avgusta-9810?attribute_pa_razmer=xs&attribute_pa_cvet=molochnyj', 4997 => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-ildara-9850?attribute_pa_razmer=xs&attribute_pa_cvet=molochnyj', 4982 => 'https://www.stimma.com.ua/shop/zhinochij-komplekt-stimma-akiya-9827?attribute_pa_razmer=xs&attribute_pa_cvet=belaya', 4993 => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-avgusta-9811?attribute_pa_razmer=xs&attribute_pa_cvet=svitlo-zelenij', 5006 => 'https://www.stimma.com.ua/shop/zhinochi-sportivni-shtani-stimma-melaniya-9820?attribute_pa_razmer=xl&attribute_pa_cvet=melanzh', 5000 => 'https://www.stimma.com.ua/shop/zhinochi-dzhogeri-stimma-monika-9832?attribute_pa_razmer=xs&attribute_pa_cvet=chernij', 4986 => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-avgusta-9809?attribute_pa_razmer=xs&attribute_pa_cvet=voloshkovij', 4935 => 'https://www.stimma.com.ua/shop/zhinochij-golf-stimma-aliana-9861?attribute_pa_razmer=xs&attribute_pa_cvet=llyanij', 4948 => 'https://www.stimma.com.ua/shop/zhinochij-dzhemper-stimma-tunis-9568?attribute_pa_razmer=m&attribute_pa_cvet=myata', 4940 => 'https://www.stimma.com.ua/shop/zhinochij-golf-stimma-aliana-9863?attribute_pa_razmer=xs&attribute_pa_cvet=seraya', 4938 => 'https://www.stimma.com.ua/shop/zhinochij-golf-stimma-aliana-9862?attribute_pa_razmer=xs&attribute_pa_cvet=kapuchino', 4956 => 'https://www.stimma.com.ua/shop/zhinocha-spidnicya-stimma-safana-9710?attribute_pa_razmer=xs&attribute_pa_cvet=kapuchino', 4966 => 'https://www.stimma.com.ua/shop/zhinochi-bryuki-stimma-arika-9804?attribute_pa_razmer=l&attribute_pa_cvet=sero-bezhevyj', 4962 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-arseniya-9823?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevaya', 4944 => 'https://www.stimma.com.ua/shop/zhinochij-dzhemper-stimma-tunis-9567?attribute_pa_razmer=m&attribute_pa_cvet=ceglyanij', 4907 => 'https://www.stimma.com.ua/shop/zhinochi-dzhogeri-stimma-matias-9794?attribute_pa_razmer=xs&attribute_pa_cvet=glyase-2', 4885 => 'https://www.stimma.com.ua/shop/zhinochij-dzhemper-stimma-apfis-9615?attribute_pa_razmer=m&attribute_pa_cvet=myata', 4902 => 'https://www.stimma.com.ua/shop/zhinochi-dzhogeri-stimma-adzuki-9757?attribute_pa_razmer=xs&attribute_pa_cvet=chernij', 4895 => 'https://www.stimma.com.ua/shop/zhinochi-bryuki-stimma-estel-8733?attribute_pa_razmer=m&attribute_pa_cvet=chernij', 4889 => 'https://www.stimma.com.ua/shop/zhinocha-spidnicya-stimma-safana-9708?attribute_pa_razmer=xs&attribute_pa_cvet=shokolad', 4873 => 'https://www.stimma.com.ua/shop/zhinoche-bodi-stimma-damiana-9775?attribute_pa_razmer=xs&attribute_pa_cvet=svetlo-seryj', 4897 => 'https://www.stimma.com.ua/shop/zhinochi-bryuki-stimma-estel-9743?attribute_pa_razmer=m&attribute_pa_cvet=orexovyj', 4881 => 'https://www.stimma.com.ua/shop/zhinoche-bodi-stimma-damiana-9777?attribute_pa_razmer=xs&attribute_pa_cvet=svetlo-bezhevaya', 4877 => 'https://www.stimma.com.ua/shop/zhinoche-bodi-stimma-damiana-9776?attribute_pa_razmer=xs&attribute_pa_cvet=belaya', 4925 => 'https://www.stimma.com.ua/shop/zhinochi-dzhinsi-stimma-skajni-9763?attribute_pa_razmer=34&attribute_pa_cvet=blakitnij', 4930 => 'https://www.stimma.com.ua/shop/zhinochi-dzhinsi-stimma-skajni-9764?attribute_pa_razmer=36&attribute_pa_cvet=sinij', 4923 => 'https://www.stimma.com.ua/shop/zhinochi-dzhinsi-stimma-yuma-9761?attribute_pa_razmer=38', 4916 => 'https://www.stimma.com.ua/shop/zhinoche-palto-uteplene-stimma-sanir-9736?attribute_pa_razmer=l&attribute_pa_cvet=chorna-klitinka', 4912 => 'https://www.stimma.com.ua/shop/zhinochij-blejzer-stimma-lesmar-9724?attribute_pa_razmer=xs&attribute_pa_cvet=temno-sira-lapka', 4919 => 'https://www.stimma.com.ua/shop/zhinoche-palto-uteplene-stimma-sanir-9737?attribute_pa_razmer=l&attribute_pa_cvet=sira-klitinka', 4899 => 'https://www.stimma.com.ua/shop/zhinochi-bryuki-stimma-fadeya-9753?attribute_pa_razmer=s&attribute_pa_cvet=chernij', 4838 => 'https://www.stimma.com.ua/shop/zhinocha-futbolka-stimma-dzhadiniya-9730?attribute_pa_razmer=xs&attribute_pa_cvet=belaya', 4864 => 'https://www.stimma.com.ua/shop/zhinochij-blejzer-palto-stimma-ostiniya-9711?attribute_pa_razmer=m&attribute_pa_cvet=bezhevo-olivkovaya-lapka', 4866 => 'https://www.stimma.com.ua/shop/zhinochij-blejzer-palto-stimma-ostiniya-9712?attribute_pa_razmer=m&attribute_pa_cvet=shokoladna-lapka', 4858 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-yanina-9631?attribute_pa_razmer=l&attribute_pa_cvet=chernij', 4862 => 'https://www.stimma.com.ua/shop/zhinochij-blejzer-stimma-samiriya-9656?attribute_pa_razmer=m&attribute_pa_cvet=seraya', 4850 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-valyana-9673?attribute_pa_razmer=xl&attribute_pa_cvet=chornij-vishneva-kvitka', 4854 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-valyana-9674?attribute_pa_razmer=xl&attribute_pa_cvet=chornij-vishnevij-uzor', 4846 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-dilvi-8318?attribute_pa_razmer=2xl&attribute_pa_cvet=olivka', 4842 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-dilvi-8317?attribute_pa_razmer=2xl&attribute_pa_cvet=bordo', 4802 => 'https://www.stimma.com.ua/shop/zhinochij-xudi-stimma-mashal-9655?attribute_pa_razmer=xs&attribute_pa_cvet=belaya', 4806 => 'https://www.stimma.com.ua/shop/zhinochij-xudi-stimma-mashal-9654?attribute_pa_razmer=xs&attribute_pa_cvet=bezheviij', 4175 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-latifa-9650?attribute_pa_razmer=xl&attribute_pa_cvet=bezheviij', 4368 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-latifa-9648?attribute_pa_razmer=xl&attribute_pa_cvet=mentol', 4515 => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-kamar-9598?attribute_pa_razmer=l&attribute_pa_cvet=bezheviij', 4829 => 'https://www.stimma.com.ua/shop/dityache-xudi-stimma-aliman-9670?attribute_pa_razmer=134&attribute_pa_cvet=olivka', 4721 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-alima-9536?attribute_pa_razmer=l&attribute_pa_cvet=chornij-kremova-kvitka', 4729 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-nazifa-9583?attribute_pa_razmer=l&attribute_pa_cvet=chornij-pomarancheva-kvitka', 4756 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-raviya-9542?attribute_pa_razmer=xl&attribute_pa_cvet=chornij-pudra-kvitka', 4713 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-alima-9538?attribute_pa_razmer=l&attribute_pa_cvet=chornij-limonna-kvitka', 4824 => 'https://www.stimma.com.ua/shop/dityache-xudi-stimma-aliman-9669?attribute_pa_razmer=134&attribute_pa_cvet=molochnyj', 4815 => 'https://www.stimma.com.ua/shop/dityache-xudi-stimma-kamal-9619?attribute_pa_razmer=122&attribute_pa_cvet=molochnyj', 4817 => 'https://www.stimma.com.ua/shop/dityache-xudi-stimma-kamal-9620?attribute_pa_razmer=128&attribute_pa_cvet=grafit', 4263 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-borneo-8985?attribute_pa_razmer=m&attribute_pa_cvet=pudra', 4266 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-borneo-8986?attribute_pa_razmer=m&attribute_pa_cvet=kapuchino', 4260 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-borneo-8984?attribute_pa_razmer=m&attribute_pa_cvet=kremovyj', 4680 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-rovena-8280?attribute_pa_razmer=xs&attribute_pa_cvet=grafit', 5245 => 'https://www.stimma.com.ua/shop/zhenskoe-palto-stimma-yunona-2-8834?attribute_pa_razmer=xs&attribute_pa_cvet=seraya-kletka', 4792 => 'https://www.stimma.com.ua/shop/zhinochij-top-stimma-gazal-9556?attribute_pa_razmer=xs&attribute_pa_cvet=belaya', 4777 => 'https://www.stimma.com.ua/shop/zhinocha-sorochka-stimma-bertina-9499?attribute_pa_razmer=xs&attribute_pa_cvet=blakitnij', 4783 => 'https://www.stimma.com.ua/shop/zhinocha-sorochka-stimma-artisha-9558?attribute_pa_razmer=xs', 4704 => 'https://www.stimma.com.ua/shop/zhinochi-bryuki-stimma-kargan-8873?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevaya', 4773 => 'https://www.stimma.com.ua/shop/zhinocha-sorochka-stimma-kivano-9473?attribute_pa_razmer=xs&attribute_pa_cvet=blakitnij', 4780 => 'https://www.stimma.com.ua/shop/zhinocha-sorochka-stimma-bertina-9498?attribute_pa_razmer=xs&attribute_pa_cvet=belaya', 4697 => 'https://www.stimma.com.ua/shop/zhinochij-blejzer-stimma-xadir-9562?attribute_pa_razmer=xs&attribute_pa_cvet=chernij', 4797 => 'https://www.stimma.com.ua/shop/zhinochij-top-stimma-gazal-9555?attribute_pa_razmer=xs&attribute_pa_cvet=chernij', 4695 => 'https://www.stimma.com.ua/shop/zhinochij-blejzer-stimma-xadir-9563?attribute_pa_razmer=xs&attribute_pa_cvet=grafit', 4787 => 'https://www.stimma.com.ua/shop/zhinocha-futbolka-stimma-dzhana-9551?attribute_pa_razmer=xs&attribute_pa_cvet=belaya', 4684 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-rovena-8278?attribute_pa_razmer=m&attribute_pa_cvet=chernij', 4764 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-raviya-9540?attribute_pa_razmer=xl&attribute_pa_cvet=chornij-bezheva-kvitka', 4760 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-raviya-9541?attribute_pa_razmer=xl&attribute_pa_cvet=chornij-gilka', 4748 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-raviya-9605?attribute_pa_razmer=xl&attribute_pa_cvet=chornij-zelena-kvitka', 4710 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-alima-9539?attribute_pa_razmer=l&attribute_pa_cvet=temno-sinij-kvitka', 4733 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-nazifa-9508?attribute_pa_razmer=l&attribute_pa_cvet=chornij-koral-kvitka', 4752 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-raviya-9604?attribute_pa_razmer=xl&attribute_pa_cvet=chornij-molochna-kvitka', 4737 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-nazifa-9507?attribute_pa_razmer=l&attribute_pa_cvet=chornij-limonnij-uzor', 4717 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-alima-9537?attribute_pa_razmer=l&attribute_pa_cvet=chornij-tyulpan', 4743 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-taira-9504?attribute_pa_razmer=m&attribute_pa_cvet=chornij-zelenij-uzor', 4725 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-nazifa-9584?attribute_pa_razmer=l&attribute_pa_cvet=chornij-pudrova-kvitka', 4691 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-flajza-9439?attribute_pa_razmer=xs&attribute_pa_cvet=rozovyj', 4688 => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-xilda-9487?attribute_pa_razmer=xs&attribute_pa_cvet=molochnyj', 4745 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-zaxira-9592?attribute_pa_razmer=xs&attribute_pa_cvet=sero-bezhevyj', 4741 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-taira-9506?attribute_pa_razmer=m&attribute_pa_cvet=krem-shokoladna-kvitka', 4770 => 'https://www.stimma.com.ua/shop/zhinocha-spidnicya-stimma-shadiya-9607?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevij-gorox', 4768 => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-aida-9531?attribute_pa_razmer=m&attribute_pa_cvet=mokko-koralova-kvitka', 4701 => 'https://www.stimma.com.ua/shop/zhinochij-zhaket-stimma-roberta-9510?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevaya', 4582 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-bamiya-9486?attribute_pa_razmer=xs&attribute_pa_cvet=fistashka-uzor', 4578 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-bamiya-9485?attribute_pa_razmer=xs&attribute_pa_cvet=vanilnyj-uzor', 4637 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-taryam-9480?attribute_pa_razmer=l&attribute_pa_cvet=molochnyj', 4633 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-taryam-9479?attribute_pa_razmer=l&attribute_pa_cvet=sero-bezhevyj', 4413 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-ketnis-9223?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevyj', 4575 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-godzhiya-9484?attribute_pa_razmer=xs&attribute_pa_cvet=fuksiya', 4645 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-moreneya-9456?attribute_pa_razmer=l&attribute_pa_cvet=kapuchino', 4641 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-taryam-9482?attribute_pa_razmer=l&attribute_pa_cvet=svetlo-orexovyj', 4653 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-moreneya-9458?attribute_pa_razmer=l&attribute_pa_cvet=zheltyj', 4649 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-moreneya-9457?attribute_pa_razmer=l&attribute_pa_cvet=olivka', 4613 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-merion-9441?attribute_pa_razmer=xxs&attribute_pa_cvet=golubaya-biryuza', 4610 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-larri-9404?attribute_pa_razmer=xs&attribute_pa_cvet=lajm', 4571 => 'https://www.stimma.com.ua/shop/zhenskaya-rubashka-stimma-adel-9430?attribute_pa_razmer=xs&attribute_pa_cvet=salatovyj', 4607 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-larri-9403?attribute_pa_razmer=xs&attribute_pa_cvet=oranzhevyj', 4617 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-merion-9442?attribute_pa_razmer=xxs&attribute_pa_cvet=zelenyj', 4621 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-merion-9443?attribute_pa_razmer=xxs&attribute_pa_cvet=fuksiya', 4657 => 'https://www.stimma.com.ua/shop/zhenskie-dzhinsovye-shorty-stimma-petsi-9454?attribute_pa_razmer=34&attribute_pa_cvet=goluboj', 4660 => 'https://www.stimma.com.ua/shop/zhenskie-dzhinsovye-shorty-stimma-petsi-9455?attribute_pa_razmer=34&attribute_pa_cvet=sinij', 4625 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-pachuliya-9417?attribute_pa_razmer=xs&attribute_pa_cvet=zelenyj', 4593 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-artediya-9459?attribute_pa_razmer=l&attribute_pa_cvet=svetlo-seryj', 4603 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-ketnis-9449?attribute_pa_razmer=xs&attribute_pa_cvet=temnaya-myata', 4675 => 'https://www.stimma.com.ua/shop/zhenskie-dzhinsovye-shorty-stimma-rebbi-9451?attribute_pa_razmer=38&attribute_pa_cvet=temno-sinij', 4589 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-konstans-9470?attribute_pa_razmer=xs&attribute_pa_cvet=nezhno-rozovyj-cvetok', 4599 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-adalin-9468?attribute_pa_razmer=xs&attribute_pa_cvet=persik-lilovyj-cvetok', 4586 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-konstans-9469?attribute_pa_razmer=m&attribute_pa_cvet=myatnyj-cvetok', 4671 => 'https://www.stimma.com.ua/shop/zhenskie-dzhinsovye-shorty-stimma-rebbi-9450?attribute_pa_razmer=34&attribute_pa_cvet=goluboj', 4595 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-naliya-9431?attribute_pa_razmer=l&attribute_pa_cvet=svetlo-rozovyj', 4663 => 'https://www.stimma.com.ua/shop/zhenskie-dzhinsovye-shorty-stimma-xanter-9452?attribute_pa_razmer=34&attribute_pa_cvet=goluboj', 4667 => 'https://www.stimma.com.ua/shop/zhenskie-dzhinsovye-shorty-stimma-xanter-9453?attribute_pa_razmer=34&attribute_pa_cvet=sinij', 4629 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-pachuliya-9418?attribute_pa_razmer=xs&attribute_pa_cvet=chernyj', 4523 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-preriya-9420?attribute_pa_razmer=l&attribute_pa_cvet=molochnyj', 4564 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-gazaniya-9392?attribute_pa_razmer=l&attribute_pa_cvet=orexovyj', 4561 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-greviniya-9412?attribute_pa_razmer=xs&attribute_pa_cvet=myatnyj-gorox', 4534 => 'https://www.stimma.com.ua/shop/zhenskij-sarafan-stimma-moliniya-9423?attribute_pa_razmer=xs&attribute_pa_cvet=belyj', 4551 => 'https://www.stimma.com.ua/shop/zhenskij-sarafan-stimma-nefira-9294?attribute_pa_razmer=m&attribute_pa_cvet=molochnyj', 4548 => 'https://www.stimma.com.ua/shop/zhenskij-sarafan-stimma-nefira-9293?attribute_pa_razmer=xs&attribute_pa_cvet=kapuchino', 4558 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-greviniya-9411?attribute_pa_razmer=xs&attribute_pa_cvet=pudra-gorox', 4554 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-artediya-9379?attribute_pa_razmer=l&attribute_pa_cvet=svetlo-olivkovyj-2', 4531 => 'https://www.stimma.com.ua/shop/zhenskij-sarafan-stimma-moliniya-9422?attribute_pa_razmer=m&attribute_pa_cvet=vasilkovyj', 4567 => 'https://www.stimma.com.ua/shop/zhenskie-dzhinsy-stimma-nomi-9409?attribute_pa_razmer=34&attribute_pa_cvet=goluboj', 4543 => 'https://www.stimma.com.ua/shop/zhenskij-sarafan-stimma-libeya-9279?attribute_pa_razmer=xs&attribute_pa_cvet=fuksiya', 4527 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-preriya-9421?attribute_pa_razmer=l&attribute_pa_cvet=fuksiya', 4538 => 'https://www.stimma.com.ua/shop/zhenskij-sarafan-stimma-libeya-9278?attribute_pa_razmer=xs&attribute_pa_cvet=chernyj', 4519 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-preriya-9419?attribute_pa_razmer=l&attribute_pa_cvet=chernyj', 4499 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-idani-7348?attribute_pa_razmer=xs&attribute_pa_cvet=molochnyj', 4503 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-retida-9362?attribute_pa_razmer=xs&attribute_pa_cvet=pudra', 4025 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-darina-7909?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevyj', 4022 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-darina-7908?attribute_pa_razmer=xs&attribute_pa_cvet=svetlo-olivkovyj-2', 4063 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-daniya-7952?attribute_pa_razmer=xs&attribute_pa_cvet=goluboj', 4495 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-idani-7347?attribute_pa_razmer=xs&attribute_pa_cvet=salatovyj', 4511 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-retida-9364?attribute_pa_razmer=xs&attribute_pa_cvet=goluboj', 4507 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-retida-9363?attribute_pa_razmer=xs&attribute_pa_cvet=myata', 4492 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-daniya-7953?attribute_pa_razmer=xs&attribute_pa_cvet=akvamarin', 4462 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-baksiniya-9359?attribute_pa_razmer=xs&attribute_pa_cvet=rozovyj', 4069 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-daniya-7954?attribute_pa_razmer=xs&attribute_pa_cvet=fioletovyj', 4445 => 'https://www.stimma.com.ua/shop/zhenskaya-bluza-stimma-nansi-9373?attribute_pa_razmer=xxs&attribute_pa_cvet=rozovyj', 4427 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-kopirena-9370?attribute_pa_razmer=xxs&attribute_pa_cvet=sirenevyj', 4423 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-rafael-9324?attribute_pa_razmer=xs&attribute_pa_cvet=nezhno-rozovyj', 4477 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-shamal-9350?attribute_pa_razmer=xxs&attribute_pa_cvet=nezhno-rozovyj', 4443 => 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-avraniya-9398?attribute_pa_razmer=l&attribute_pa_cvet=nezhno-rozovyj', 4460 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-maliviya-9377?attribute_pa_razmer=xxs&attribute_pa_cvet=nezhno-rozovyj', 4417 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-zeraya-9316?attribute_pa_razmer=xs&attribute_pa_cvet=goluboj', 4458 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-maliviya-9375?attribute_pa_razmer=xs&attribute_pa_cvet=goluboj', 4419 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-rafael-9323?attribute_pa_razmer=xs&attribute_pa_cvet=goluboj', 4452 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-brera-9319?attribute_pa_razmer=xxs&attribute_pa_cvet=svetlo-seryj', 4449 => 'https://www.stimma.com.ua/shop/zhenskaya-bluza-stimma-zemiya-9331?attribute_pa_razmer=xs&attribute_pa_cvet=goluboj-cvetok', 4433 => 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-alteliya-9393?attribute_pa_razmer=m&attribute_pa_cvet=belyj', 4440 => 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-avraniya-9397?attribute_pa_razmer=l&attribute_pa_cvet=molochnyj', 4429 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-kopirena-9371?attribute_pa_razmer=xxs&attribute_pa_cvet=myata', 4488 => 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-aminta-9384?attribute_pa_razmer=xs&attribute_pa_cvet=svetlo-rozovyj', 4455 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-brera-9321?attribute_pa_razmer=xxs&attribute_pa_cvet=rozovyj', 4473 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-makan-9355?attribute_pa_razmer=xxs&attribute_pa_cvet=belyj-rozovyj', 4436 => 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-alteliya-9394?attribute_pa_razmer=xs&attribute_pa_cvet=rozovyj', 4469 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-makan-9354?attribute_pa_razmer=xxs&attribute_pa_cvet=belyj-travyanoj', 4481 => 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-aminta-9381?attribute_pa_razmer=xs&attribute_pa_cvet=sine-goluboj', 4485 => 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-aminta-9382?attribute_pa_razmer=xs&attribute_pa_cvet=travyanoj', 4465 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-makan-9353?attribute_pa_razmer=xxs&attribute_pa_cvet=belyj-chyornyj', 4390 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-ostin-9273?attribute_pa_razmer=l&attribute_pa_cvet=kirpichnyj', 4393 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-ostin-9275?attribute_pa_razmer=xl&attribute_pa_cvet=tyomnaya-gorchica', 4406 => 'https://www.stimma.com.ua/shop/zhenskie-letnie-shtany-stimma-lichi-9333?attribute_pa_razmer=xl&attribute_pa_cvet=kapuchino', 4404 => 'https://www.stimma.com.ua/shop/zhenskie-letnie-shtany-stimma-lichi-9334?attribute_pa_razmer=xl&attribute_pa_cvet=mokko', 4409 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-ketnis-9222?attribute_pa_razmer=xs&attribute_pa_cvet=belyj', 4397 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-goriya-9308?attribute_pa_razmer=xl&attribute_pa_cvet=belyj', 4400 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-goriya-9310?attribute_pa_razmer=xl&attribute_pa_cvet=bezhevaya-pudra', 4094 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-koris-8035?attribute_pa_razmer=l&attribute_pa_cvet=bezhevyj', 4386 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-verenaya-9271?attribute_pa_razmer=xs&attribute_pa_cvet=rozovyj-cvetok', 4388 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-verenaya-9272?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevyj-cvetok', 4376 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-nolan-9219?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevaya-pudra', 4384 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-nazira-9239?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevaya-pudra', 4380 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-nolan-9220?attribute_pa_razmer=xs&attribute_pa_cvet=molochnyj', 4372 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-nolan-9218?attribute_pa_razmer=xs&attribute_pa_cvet=belyj', 4096 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-koris-8036?attribute_pa_razmer=l&attribute_pa_cvet=chernyj', 4342 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-fluter-9228?attribute_pa_razmer=xs&attribute_pa_cvet=pudra', 4344 => 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-feris-5036?attribute_pa_razmer=xl&attribute_pa_cvet=belyj', 4355 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-naliya-9212?attribute_pa_razmer=l&attribute_pa_cvet=molochnyj', 4352 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-naliya-9211?attribute_pa_razmer=m&attribute_pa_cvet=chernyj', 4348 => 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-feris-4822?attribute_pa_razmer=xl&attribute_pa_cvet=chernyj', 4358 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-naliya-9214?attribute_pa_razmer=l&attribute_pa_cvet=yarko-myatnyj', 4363 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-zalaya-9190?attribute_pa_razmer=xs&attribute_pa_cvet=rozovyj', 4365 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-zalaya-9191?attribute_pa_razmer=m&attribute_pa_cvet=molochnyj', 4332 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-bora-9183?attribute_pa_razmer=s&attribute_pa_cvet=nezhnaya-myata', 4334 => 'https://www.stimma.com.ua/shop/zhenskij-sarafan-stimma-bali-9184?attribute_pa_razmer=m&attribute_pa_cvet=goluboj-cvetok', 4336 => 'https://www.stimma.com.ua/shop/zhenskij-sarafan-stimma-bali-9185?attribute_pa_razmer=m&attribute_pa_cvet=lavanda-cvetok', 4339 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-siven-9136?attribute_pa_razmer=l&attribute_pa_cvet=bezhevyj', 4314 => 'https://www.stimma.com.ua/shop/zhenskij-kardigan-stimma-kvatro-9031?attribute_pa_razmer=m&attribute_pa_cvet=molochnyj-pudra', 4326 => 'https://www.stimma.com.ua/shop/zhenskie-dzhinsy-stimma-oriana-9149?attribute_pa_razmer=34&attribute_pa_cvet=seryj', 4317 => 'https://www.stimma.com.ua/shop/zhenskij-sviter-stimma-alara-7218?attribute_pa_razmer=m&attribute_pa_cvet=sirenevyj', 4323 => 'https://www.stimma.com.ua/shop/zhenskij-sviter-stimma-alara-7220?attribute_pa_razmer=m&attribute_pa_cvet=perlamutr', 4330 => 'https://www.stimma.com.ua/shop/zhenskie-dzhinsy-stimma-yuta-9153?attribute_pa_razmer=40&attribute_pa_cvet=goluboj', 4320 => 'https://www.stimma.com.ua/shop/zhenskij-sviter-stimma-alara-7219?attribute_pa_razmer=m&attribute_pa_cvet=nebesnyj', 4302 => 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-sanrado-9154?attribute_pa_razmer=l&attribute_pa_cvet=svetlo-fistashkovyj', 4300 => 'https://www.stimma.com.ua/shop/zhenskij-xudi-stimma-lorin-9098?attribute_pa_razmer=xs&attribute_pa_cvet=nezhno-rozovyj', 4293 => 'https://www.stimma.com.ua/shop/zhenskij-svitshot-stimma-zevksinij-9165?attribute_pa_razmer=xl&attribute_pa_cvet=bezhevyj', 4306 => 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-sanrado-9155?attribute_pa_razmer=l&attribute_pa_cvet=molochnyj', 4298 => 'https://www.stimma.com.ua/shop/zhenskij-svitshot-stimma-zevksinij-9166?attribute_pa_razmer=xl&attribute_pa_cvet=molochnyj', 4291 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-rolan-8944?attribute_pa_razmer=m&attribute_pa_cvet=molochnyj', 4310 => 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-sanrado-9156?attribute_pa_razmer=l&attribute_pa_cvet=bezhevyj', 4289 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-rolan-8943?attribute_pa_razmer=m&attribute_pa_cvet=chernyj', 4258 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-agona-8907-kopirovat?attribute_pa_razmer=xl&attribute_pa_cvet=vanilno-travyanoj-cvetok', 4269 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-sumatra-8987?attribute_pa_razmer=xs&attribute_pa_cvet=pudra', 4271 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-tilda-8824-2?attribute_pa_razmer=l&attribute_pa_cvet=chernyj', 4275 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-tilda-8825-2?attribute_pa_razmer=l&attribute_pa_cvet=temno-sinij', 3873 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-dakota-5095?attribute_pa_razmer=s&attribute_pa_cvet=belyj', 4250 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-dreda-8960?attribute_pa_razmer=l&attribute_pa_cvet=bezhevyj', 4256 => 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-zhardin-8916?attribute_pa_razmer=xs&attribute_pa_cvet=pudro-bezhevyj', 4253 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-asaliya-8999?attribute_pa_razmer=xs&attribute_pa_cvet=chernyj', 3877 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-dakota-5096?attribute_pa_razmer=s&attribute_pa_cvet=chernyj', 4246 => 'https://www.stimma.com.ua/shop/zhenskoe-palto-stimma-tanzanit-8857?attribute_pa_razmer=xs&attribute_pa_cvet=seryj', 4234 => 'https://www.stimma.com.ua/shop/zhenskaya-bluza-stimma-karpi-8787?attribute_pa_razmer=xs&attribute_pa_cvet=chernyj', 4236 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-bergiya-8867?attribute_pa_razmer=xl&attribute_pa_cvet=mokko', 4240 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-charli-8854?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevyj', 4222 => 'https://www.stimma.com.ua/shop/zhenskaya-kurtka-stimma-sesil-8727?attribute_pa_razmer=xxs&attribute_pa_cvet=yarko-zelenyj', 4218 => 'https://www.stimma.com.ua/shop/zhenskij-zhilet-stimma-fernanda-8741?attribute_pa_razmer=xxs&attribute_pa_cvet=zheltyj', 4230 => 'https://www.stimma.com.ua/shop/zhenskaya-kurtka-stimma-sesil-8729?attribute_pa_razmer=xxs&attribute_pa_cvet=zheltyj', 4226 => 'https://www.stimma.com.ua/shop/zhenskaya-kurtka-stimma-sesil-8728?attribute_pa_razmer=xxs&attribute_pa_cvet=elektrik', 4212 => 'https://www.stimma.com.ua/shop/zhenskij-trench-stimma-reton-8785?attribute_pa_razmer=s&attribute_pa_cvet=svetlo-karamelnyj', 4214 => 'https://www.stimma.com.ua/shop/zhenskaya-kurtka-stimma-brameya-8773?attribute_pa_razmer=m&attribute_pa_cvet=xolodnyj-lyod', 4216 => 'https://www.stimma.com.ua/shop/zhenskaya-kurtka-stimma-brameya-8774?attribute_pa_razmer=m&attribute_pa_cvet=seraya-olivka', 3818 => 'https://www.stimma.com.ua/shop/zhenskaya-yubka-stimma-armina-8759?attribute_pa_razmer=xs&attribute_pa_cvet=chyornaya-lapka-2', 4168 => 'https://www.stimma.com.ua/shop/zhenskij-golf-stimma-terna-8720?attribute_pa_razmer=l&attribute_pa_cvet=svetlo-bezhevyj', 4072 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-federika-8667?attribute_pa_razmer=xs&attribute_pa_cvet=temno-sinij', 4189 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-nayada-8690?attribute_pa_razmer=m&attribute_pa_cvet=chernyj', 4195 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-fren-8678?attribute_pa_razmer=xs&attribute_pa_cvet=serebryanyj-krug', 4204 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-fren-8681?attribute_pa_razmer=xs&attribute_pa_cvet=serebryanyj-kvadrat', 4186 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-nayada-8689?attribute_pa_razmer=m&attribute_pa_cvet=serebryano-chyornyj', 4201 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-fren-8680?attribute_pa_razmer=xs&attribute_pa_cvet=chernyj-kvadrat', 4198 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-fren-8679?attribute_pa_razmer=xs&attribute_pa_cvet=serebryanaya-chertochka', 4192 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-fren-8677?attribute_pa_razmer=xs&attribute_pa_cvet=chyornyj-krug', 4182 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-valero-8615?attribute_pa_razmer=s&attribute_pa_cvet=mokko', 3761 => 'https://www.stimma.com.ua/shop/zhenskoe-palto-stimma-triera-8548?attribute_pa_razmer=xs&attribute_pa_cvet=orexovyj', 3764 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-lazanna-8611?attribute_pa_razmer=xs&attribute_pa_cvet=orexovyj', 3758 => 'https://www.stimma.com.ua/shop/zhenskoe-palto-stimma-triera-8549?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevyj', 3774 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-benna-8526?attribute_pa_razmer=xs&attribute_pa_cvet=tyomno-seraya', 3768 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-salli-8544?attribute_pa_razmer=xxs&attribute_pa_cvet=bledno-golubaya', 3869 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-mirena-8474?attribute_pa_razmer=xl&attribute_pa_cvet=chernyj', 4002 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-mirena-8473?attribute_pa_razmer=xl&attribute_pa_cvet=olivka', 3867 => 'https://www.stimma.com.ua/shop/zhenskoe-palto-stimma-loren-8426?attribute_pa_razmer=m&attribute_pa_cvet=mokko', 3938 => 'https://www.stimma.com.ua/shop/zhenskij-longsliv-stimma-alkena-8452?attribute_pa_razmer=xs&attribute_pa_cvet=svetlo-molochnyj-2', 3890 => 'https://www.stimma.com.ua/shop/zhenskij-longsliv-stimma-alkena-8454?attribute_pa_razmer=xs&attribute_pa_cvet=orexovyj', 4166 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-norika-8367?attribute_pa_razmer=2xl&attribute_pa_cvet=chernyj', 4163 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-derbi-8205?attribute_pa_razmer=l&attribute_pa_cvet=grafit', 4161 => 'https://www.stimma.com.ua/shop/zhenskaya-yubka-stimma-dzhun-8342?attribute_pa_razmer=xs&attribute_pa_cvet=chernyj', 4136 => 'https://www.stimma.com.ua/shop/zhenskoe-xudi-stimma-adiant-8229?attribute_pa_razmer=xs&attribute_pa_cvet=krasnyj', 4144 => 'https://www.stimma.com.ua/shop/zhenskij-zhaket-stimma-ligeya-8183?attribute_pa_razmer=l&attribute_pa_cvet=grafit', 4140 => 'https://www.stimma.com.ua/shop/zhenskij-zhaket-stimma-ligeya-8040?attribute_pa_razmer=l&attribute_pa_cvet=mokryj-asfalt', 4138 => 'https://www.stimma.com.ua/shop/zhenskij-krop-top-stimma-loris-7919?attribute_pa_razmer=m&attribute_pa_cvet=chernyj', 4148 => 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-monra-8217?attribute_pa_razmer=xxs&attribute_pa_cvet=tyomno-sizij', 4133 => 'https://www.stimma.com.ua/shop/zhenskij-longsliv-stimma-tafeit-8180?attribute_pa_razmer=m&attribute_pa_cvet=belyj', 4127 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-nensi-8157?attribute_pa_razmer=xs&attribute_pa_cvet=sirenevo-bezhevyj', 4121 => 'https://www.stimma.com.ua/shop/zhenskie-dzhinsy-stimma-foreks-8133?attribute_pa_razmer=34&attribute_pa_cvet=seryj', 4100 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-xanna-8104?attribute_pa_razmer=2xl&attribute_pa_cvet=chernyj', 4116 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-paulina-8121?attribute_pa_razmer=2xl&attribute_pa_cvet=chernyj', 4108 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-xanna-8106?attribute_pa_razmer=2xl&attribute_pa_cvet=dzhinsovyj', 4104 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-xanna-8105?attribute_pa_razmer=2xl&attribute_pa_cvet=kapuchino', 4112 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-vildi-8100?attribute_pa_razmer=2xl&attribute_pa_cvet=zheltyj', 4087 => 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-xarlina-7974?attribute_pa_razmer=xs&attribute_pa_cvet=sero-goluboj-2', 4085 => 'https://www.stimma.com.ua/shop/zhenskoe-xudi-stimma-tajman-8096?attribute_pa_razmer=xs&attribute_pa_cvet=rozovyj', 4091 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-bibl-8088?attribute_pa_razmer=m&attribute_pa_cvet=latte', 4056 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-zabrus-7948?attribute_pa_razmer=m&attribute_pa_cvet=korallovyj', 4060 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-zabrus-7950?attribute_pa_razmer=m&attribute_pa_cvet=temno-sinij', 4052 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-kariya-7946?attribute_pa_razmer=l&attribute_pa_cvet=krasnyj', 4054 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-kariya-7947?attribute_pa_razmer=l&attribute_pa_cvet=sero-olivkovyj', 4050 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-kariya-7945?attribute_pa_razmer=l&attribute_pa_cvet=fuksiya', 4058 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-zabrus-7949?attribute_pa_razmer=m&attribute_pa_cvet=sinij', 3960 => 'https://www.stimma.com.ua/shop/zhenskaya-rubashka-stimma-mejkol-7790?attribute_pa_razmer=l&attribute_pa_cvet=molochnyj', 3949 => 'https://www.stimma.com.ua/shop/zhenskaya-rubashka-stimma-mejkol-7789?attribute_pa_razmer=l&attribute_pa_cvet=chernyj', 3956 => 'https://www.stimma.com.ua/shop/zhenskaya-yubka-stimma-lunair-7896?attribute_pa_razmer=s&attribute_pa_cvet=olivkovo-sirenevyj', 4036 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-itali-7863?attribute_pa_razmer=xs&attribute_pa_cvet=belyj', 3953 => 'https://www.stimma.com.ua/shop/zhenskaya-yubka-stimma-lunair-7895?attribute_pa_razmer=m&attribute_pa_cvet=sine-sirenevyj', 4032 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-aromediya-7861?attribute_pa_razmer=xs&attribute_pa_cvet=molochnyj', 4034 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-aromediya-7862?attribute_pa_razmer=xs&attribute_pa_cvet=tyomno-bezhevyj', 4008 => 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-gejbliya-7786?attribute_pa_razmer=xs&attribute_pa_cvet=fistashkovyj', 4019 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-aleksiya-7888?attribute_pa_razmer=xl&attribute_pa_cvet=molochnyj', 4030 => 'https://www.stimma.com.ua/shop/zhenskij-komplekt-stimma-arneir-7926?attribute_pa_razmer=m&attribute_pa_cvet=bezhevyj', 4014 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-aleksiya-7887?attribute_pa_razmer=xl&attribute_pa_cvet=temno-sinij', 4006 => 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-gejbliya-7784?attribute_pa_razmer=xs&attribute_pa_cvet=svetlo-goluboj', 3992 => 'https://www.stimma.com.ua/shop/detskie-shorty-stimma-korgo-7797?attribute_pa_razmer=122&attribute_pa_cvet=dzhinsovyj', 3982 => 'https://www.stimma.com.ua/shop/detskie-shorty-stimma-anoplij-7768?attribute_pa_razmer=116&attribute_pa_cvet=fistashkovyj', 3997 => 'https://www.stimma.com.ua/shop/detskie-shorty-stimma-korgo-7798?attribute_pa_razmer=116&attribute_pa_cvet=mokko', 3936 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-karamella-7606?attribute_pa_razmer=l&attribute_pa_cvet=persikovyj', 3925 => 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-alsobiya-7604?attribute_pa_razmer=l&attribute_pa_cvet=molochnyj', 3922 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-shajna-7581?attribute_pa_razmer=xs&attribute_pa_cvet=belyj', 3894 => 'https://www.stimma.com.ua/shop/zhenskij-top-xolis-7647?attribute_pa_razmer=xs&attribute_pa_cvet=molochnyj', 3927 => 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-bessariya-7528?attribute_pa_razmer=s&attribute_pa_cvet=rozovyj', 3930 => 'https://www.stimma.com.ua/shop/zhenskie-dzhogery-stimma-yavita-7621?attribute_pa_razmer=l&attribute_pa_cvet=molochnyj', 3932 => 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-braun-7616?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevyj', 3892 => 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-mareneya-7506?attribute_pa_razmer=xs&attribute_pa_cvet=sirenevyj', 3858 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-nirutti-7093?attribute_pa_razmer=xs&attribute_pa_cvet=pudra', 3854 => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-nirutti-7092?attribute_pa_razmer=xs&attribute_pa_cvet=olivka', 3847 => 'https://www.stimma.com.ua/shop/detskaya-futbolka-stimma-arita-6857?attribute_pa_razmer=110&attribute_pa_cvet=mentolovyj', 3840 => 'https://www.stimma.com.ua/shop/detskie-bryuki-stimma-vildan-6837?attribute_pa_razmer=152&attribute_pa_cvet=bezhevyj', 3671 => 'https://www.stimma.com.ua/shop/zhenskie-bryuki-stimma-erden-6554?attribute_pa_razmer=xs&attribute_pa_cvet=kapuchino', 3669 => 'https://www.stimma.com.ua/shop/zhenskie-bryuki-stimma-erden-6552?attribute_pa_razmer=xs&attribute_pa_cvet=grafitovyj', 3665 => 'https://www.stimma.com.ua/shop/zhenskaya-kurtka-stimma-misso-6755?attribute_pa_razmer=l&attribute_pa_cvet=biryuzovyj', 3676 => 'https://www.stimma.com.ua/shop/zhenskaya-bluza-stimma-eliana-6579?attribute_pa_razmer=l&attribute_pa_cvet=chernyj', 3742 => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-besli-6614?attribute_pa_razmer=xs&attribute_pa_cvet=shokoladnyj', 3667 => 'https://www.stimma.com.ua/shop/zhenskie-dzhogery-stimma-tajmas-6556?attribute_pa_razmer=xs&attribute_pa_cvet=chernyj');
$url = $urls=array (
        '0032' => 'https://www.stimma.com.ua/shop/zhinocha-spidnicya-stimma-rona-0032?attribute_pa_razmer=m&attribute_pa_cvet=perlamutr',
        '0005' => 'https://www.stimma.com.ua/shop/zhinochij-zhaket-stimma-ligeya-0005?attribute_pa_razmer=m&attribute_pa_cvet=molochnyj',
        '0031' => 'https://www.stimma.com.ua/shop/zhinocha-spidnicya-stimma-rona-0031?attribute_pa_razmer=m&attribute_pa_cvet=chernij',
        '3000' => 'https://www.stimma.com.ua/shop/186583?attribute_pa_razmer=3000',
        '0028' => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-blounid-0028?attribute_pa_razmer=m&attribute_pa_cvet=xolodnij-lid',
        '0043' => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-neilina-0043?attribute_pa_razmer=m&attribute_pa_cvet=xolodnij-lid',
        '0026' => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-blounid-0026?attribute_pa_razmer=m&attribute_pa_cvet=siro-korichnevij',
        '0035' => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-antoniya-0035?attribute_pa_razmer=l&attribute_pa_cvet=chernij',
        '0044' => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-neilina-0044?attribute_pa_razmer=m&attribute_pa_cvet=glyasya',
        '0027' => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-blounid-0027?attribute_pa_razmer=m&attribute_pa_cvet=chernij',
        '0045' => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-neilina-0045?attribute_pa_razmer=m&attribute_pa_cvet=voloshkovij',
        '0036' => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-antoniya-0036?attribute_pa_razmer=l&attribute_pa_cvet=ultramarin',
        '0042' => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-antoniya-0042?attribute_pa_razmer=l&attribute_pa_cvet=pomaranchevij',
        '0029' => 'https://www.stimma.com.ua/shop/zhinocha-termobilizna-stimma-ol-c-0029?attribute_pa_razmer=xxxl&attribute_pa_cvet=olivka',
        '0072' => 'https://www.stimma.com.ua/shop/zhinocha-termobilizna-stimma-c-0072?attribute_pa_razmer=xxxl&attribute_pa_cvet=chernij',
        '0014' => 'https://www.stimma.com.ua/shop/zhinocha-kurtka-stimma-ojsin-0014?attribute_pa_razmer=m&attribute_pa_cvet=chernij',
        '0038' => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-mixaela-0038?attribute_pa_razmer=l&attribute_pa_cvet=bezheva-lapka',
        '0030' => 'https://www.stimma.com.ua/shop/zhinocha-shuba-stimma-oriyeta-0030?attribute_pa_razmer=xs&attribute_pa_cvet=molochnyj',
        '0037' => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-mixaela-0037?attribute_pa_razmer=l&attribute_pa_cvet=chorna-yalinka',
        '0007' => 'https://www.stimma.com.ua/shop/zhinochi-leginsi-stimma-mejdi-0007?attribute_pa_razmer=l&attribute_pa_cvet=bezhevaya',
        '0008' => 'https://www.stimma.com.ua/shop/zhinochi-leginsi-stimma-mejdi-0008?attribute_pa_razmer=l&attribute_pa_cvet=chernij',
        '9944' => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-farzana-9944?attribute_pa_razmer=m&attribute_pa_cvet=nizhno-rozhevij',
        '9915' => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-rufina-9915?attribute_pa_razmer=xxs&attribute_pa_cvet=pomaranchevij',
        '9831' => 'https://www.stimma.com.ua/shop/zhinochi-dzhogeri-stimma-monika-9831?attribute_pa_razmer=m&attribute_pa_cvet=molochnyj',
        '9849' => 'https://www.stimma.com.ua/shop/zhinoche-xudi-stimma-ildara-9849?attribute_pa_razmer=xs&attribute_pa_cvet=chernij',
        '9769' => 'https://www.stimma.com.ua/shop/zhinoche-palto-uteplene-stimma-odis-9770?attribute_pa_razmer=m&attribute_pa_cvet=mokko',
        '8316' => 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-dilvi-8316?attribute_pa_razmer=2xl&attribute_pa_cvet=chernij',
        '9649' => 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-latifa-9649?attribute_pa_razmer=xl&attribute_pa_cvet=temna-pudra',
        '9621' => 'https://www.stimma.com.ua/shop/dityache-xudi-stimma-kamal-9621?attribute_pa_razmer=116&attribute_pa_cvet=chernij',
        '9488' => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-xilda-9488?attribute_pa_razmer=xs&attribute_pa_cvet=bezhevaya',
        '9440' => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-flajza-9440?attribute_pa_razmer=m&attribute_pa_cvet=myata',
        '9511' => 'https://www.stimma.com.ua/shop/zhinochij-zhaket-stimma-roberta-9511?attribute_pa_razmer=s&attribute_pa_cvet=belaya',
        '9489' => 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-xilda-9489?attribute_pa_razmer=xs&attribute_pa_cvet=kremovyj',
        '9358' => 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-baksiniya-9358?attribute_pa_razmer=s&attribute_pa_cvet=goluboj',
        '8945' => 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-rolan-8945?attribute_pa_razmer=m&attribute_pa_cvet=mokko',
        '8835' => 'https://www.stimma.com.ua/shop/zhenskij-trench-stimma-reton-8835?attribute_pa_razmer=xs&attribute_pa_cvet=xolodnyj-lyod',
        '1627' => 'https://www.stimma.com.ua/shop/termobele-stimma-zhenskoe-ripstop-1627?attribute_pa_razmer=xl&attribute_pa_cvet=seryj',
        '0024' => 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0024?attribute_pa_razmer=s&attribute_pa_cvet=chernyj',
        '0641' => 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0641?attribute_pa_razmer=xl&attribute_pa_cvet=chernyj',
        '0025' => 'https://www.stimma.com.ua/shop/termobele-zhenskoe-stimma-00025?attribute_pa_razmer=xxl&attribute_pa_cvet=chernij',
        '0067' => 'https://www.stimma.com.ua/shop/balaklava-muzhskaya-0067?attribute_cvet=%D0%A7%D1%91%D1%80%D0%BD%D1%8B%D0%B9' );
$urls = [
    3696=> 'не знайшла',
3708=> 'не знайшла',
4119=> 'https://www.stimma.com.ua/magazin/zhinochij-komplekt-stimma-dominika-8107?lang=uk',
3729=> 'https://www.stimma.com.ua/shop/detskaya-futbolka-stimma-xarli-4926?lang=uk',
3744=> 'https://www.stimma.com.ua/magazin/detskij-sportivnyj-kostyum-stimma-kajzer-5755?lang=uk',
3746=> 'https://www.stimma.com.ua/magazin/detskij-sportivnyj-kostyum-stimma-kajzer-5756?lang=uk',
3795=> 'https://www.stimma.com.ua/magazin/detskie-sportivnye-shtany-stimma-aristol-6059?lang=uk',
3832=> 'https://www.stimma.com.ua/shop/detskie-bryuki-stimma-vildan-6835?lang=uk',
3835=> 'https://www.stimma.com.ua/shop/detskie-bryuki-stimma-vildan-6836?lang=uk',
3980=> 'https://www.stimma.com.ua/shop/detskie-shorty-stimma-anoplij-7766?lang=uk',
3985=> 'https://www.stimma.com.ua/shop/detskie-shorty-stimma-anoplij-7769?lang=uk',
3987=> 'https://www.stimma.com.ua/shop/detskie-shorty-stimma-korgo-7796?lang=uk',
4822=> 'https://www.stimma.com.ua/shop/dityache-xudi-stimma-aliman-9668?lang=uk',
4834=> 'https://www.stimma.com.ua/shop/dityachij-sportivnij-kostyum-stimma-shejn-9646?lang=uk',
4836=> 'https://www.stimma.com.ua/shop/dityachij-sportivnij-kostyum-stimma-shejn-9647?lang=uk',
3710=> 'https://www.stimma.com.ua/magazin/detskaya-bluza-stimma-belona-4871?lang=uk',
3712=> 'https://www.stimma.com.ua/shop/detskoe-plate-stimma-lamma-4841',
3716=> 'https://www.stimma.com.ua/shop/detskoe-plate-stimma-lamma-4842',
3721=> 'https://www.stimma.com.ua/shop/detskoe-plate-stimma-pring-4889',
3725=> 'https://www.stimma.com.ua/shop/detskoe-plate-stimma-pring-4890',
3750=> 'https://www.stimma.com.ua/shop/detskie-sportivnye-shtany-stimma-nikola-5693',
3797=> 'https://www.stimma.com.ua/shop/detskij-svitshot-stimma-taneriya-6281',
3801=> 'https://www.stimma.com.ua/shop/detskij-svitshot-stimma-amanet-6287',
3804=> 'https://www.stimma.com.ua/shop/detskij-svitshot-stimma-amanet-6289',
3828=> 'https://www.stimma.com.ua/shop/detskie-bryuki-stimma-asep-6785',
3845=> 'https://www.stimma.com.ua/shop/detskaya-futbolka-stimma-dajcyya-6777',
3887=> 'https://www.stimma.com.ua/shop/detskoe-plate-stimma-mariza-6971',
3945=> 'https://www.stimma.com.ua/shop/detskaya-futbolka-stimma-albiciya-7658',
3962=> 'https://www.stimma.com.ua/shop/detskaya-futbolka-stimma-akorniya-7666',
3964=> 'https://www.stimma.com.ua/shop/detskoe-plate-stimma-rubina-7727',
3966=> 'https://www.stimma.com.ua/shop/detskoe-plate-stimma-rubina-7728',
3969=> 'https://www.stimma.com.ua/shop/detskoe-plate-stimma-kolin-7741',
3974=> 'https://www.stimma.com.ua/shop/detskoe-plate-stimma-fani-7791',
3976=> 'https://www.stimma.com.ua/shop/detskoe-plate-stimma-fani-7792',
3978=> 'https://www.stimma.com.ua/shop/detskie-shorty-stimma-dzhener-7730',
4244=> 'https://www.stimma.com.ua/shop/dityachij-longsliv-stimma-raziya-9588',
4812=> 'https://www.stimma.com.ua/shop/dityachij-longsliv-stimma-inaya-9572',
5382=> 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0641',
5384=> 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0641',
5386=> 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0641',
5390=> 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0641',
5392=> 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0641',
5396=> 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0024',
5398=> 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0024',
5400=> 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0024',
5402=> 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0024',
5404=> 'https://www.stimma.com.ua/shop/termobele-stimma-muzhskoe-0024',
5009=> 'https://www.stimma.com.ua/shop/zhinocha-kurtka-stimma-melisa-9873',
5012=> 'https://www.stimma.com.ua/shop/zhinocha-kurtka-stimma-teodora-2-9923',
5015=> 'https://www.stimma.com.ua/shop/zhinocha-kurtka-stimma-teodora-9919',
5131=> 'https://www.stimma.com.ua/shop/zhinocha-kurtka-stimma-rozaliya-9939',
4210=> 'https://www.stimma.com.ua/shop/zhinocha-kurtka-stimma-aglaya-9846',
3686=> 'https://www.stimma.com.ua/shop/zhenskij-blejzer-stimma-balayazh-2461',
3865=> 'https://www.stimma.com.ua/shop/zhenskoe-palto-stimma-polin-8492',
4043=> 'https://www.stimma.com.ua/shop/zhenskoe-palto-stimma-polin-8491',
5353=> 'https://www.stimma.com.ua/shop/zhinocha-shuba-stimma-kalateya-0025',
3678=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-tardiniya-8538',
3688=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-otiliya-4530',
3692=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-byuti-4587',
3694=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-rajs-4618',
3752=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-talita-5775',
3766=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-salli-8543',
3772=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-salli-8545',
3777=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-zhanariya-6180',
3780=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-zhanariya-6181',
3816=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-fatua-6374',
3850=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-barisan-6926',
3852=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-barisan-6927',
3862=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-foliya-7213',
4028=> 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-basan-8429',
4045=> 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-livera-8636',
4075=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-federika-8666',
4098=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-ruan-8076',
4180=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-kamiliya-8714',
4184=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-valero-8616',
4279=> 'https://www.stimma.com.ua/shop/zhenskoe-plate-stimma-agona-8907',
4893=> 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-livera-8637',
4958=> 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-dress-9751',
4960=> 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-anel-9808',
5202=> 'https://www.stimma.com.ua/shop/zhinocha-suknya-stimma-rudes-9942',
4171=> 'https://www.stimma.com.ua/shop/zhenskaya-yubka-stimma-armina-8760',
4207=> 'https://www.stimma.com.ua/shop/zhenskaya-yubka-stimma-delajla-8706',
5080=> 'https://www.stimma.com.ua/shop/zhinocha-spidnicya-stimma-gabriel-9924',
4039=> 'https://www.stimma.com.ua/shop/zhenskie-dzhinsy-stimma-mavi-8117',
4041=> 'https://www.stimma.com.ua/shop/zhenskie-dzhinsy-stimma-reks-8013',
4155=> 'https://www.stimma.com.ua/shop/zhenskie-dzhinsy-stimma-subira-7062',
4157=> 'https://www.stimma.com.ua/shop/zhenskie-dzhinsy-stimma-subira-7063',
3706=> 'https://www.stimma.com.ua/shop/zhenskie-bryuki-stimma-banni-4698',
3734=> 'https://www.stimma.com.ua/shop/zhenskie-bryuki-stimma-loran-5008',
3737=> 'https://www.stimma.com.ua/shop/zhenskie-bryuki-stimma-loran-5009',
3739=> 'https://www.stimma.com.ua/shop/zhenskie-bryuki-stimma-loran-5010',
3756=> 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-kyumel-5856',
3783=> 'https://www.stimma.com.ua/shop/zhenskie-dzhogery-stimma-bilal-6118',
4125=> 'https://www.stimma.com.ua/shop/zhenskie-dzhinsy-stimma-repiti-8115',
4159=> 'https://www.stimma.com.ua/shop/zhenskie-bryuki-stimma-dzholin-8231',
5133=> 'https://www.stimma.com.ua/shop/zhinochi-bryuki-stimma-artemiya-9916',
5217=> 'https://www.stimma.com.ua/shop/zhinochi-bryuki-stimma-allisum-0006',
3881=> 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-maffi-7064',
3885=> 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-maffi-7065',
4361=> 'https://www.stimma.com.ua/shop/zhenskie-shorty-stimma-zalaya-9189',
4066=> 'https://www.stimma.com.ua/shop/zhenskie-leginsy-stimma-tajla',
4952=> 'https://www.stimma.com.ua/shop/zhinochij-dzhemper-stimma-sitra-9573',
4954=> 'https://www.stimma.com.ua/shop/zhinochij-dzhemper-stimma-sitra-9574',
5190=> 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-sivel-9748',
5249=> 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-darra-0003',
5253=> 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-darra-0004',
5257=> 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-singel-0009',
5261=> 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-singel-0010',
5269=> 'https://www.stimma.com.ua/shop/zhinochij-svetr-stimma-chirsti-9960',
4151=> 'https://www.stimma.com.ua/shop/zhenskij-sportivnyj-kostyum-stimma-monra-8219',
5041=> 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-leona-9885',
5043=> 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-leona-9908',
5104=> 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-evangiya-9932',
5107=> 'https://www.stimma.com.ua/shop/zhinochij-sportivnij-kostyum-stimma-evangiya-9931',
5004=> 'https://www.stimma.com.ua/shop/zhinochi-sportivni-shtani-stimma-melaniya-9808',
5414=> 'https://www.stimma.com.ua/shop/zhenskij-sportivnye-shtany-stimma-korneli-3548',
4011=> 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-sicidiya-7723',
4431=> 'https://www.stimma.com.ua/shop/zhenskaya-futbolka-stimma-saner-9292',
3958=> 'https://www.stimma.com.ua/shop/zhenskij-top-stimma-asai-7756',
5341=> 'https://www.stimma.com.ua/shop/zhinochij-top-stimma-morion-8684',
3934=> 'https://www.stimma.com.ua/shop/zhenskij-longsliv-stimma-alkena-8453',
4131=> 'https://www.stimma.com.ua/shop/zhenskij-longsliv-stimma-tafeit-8179',
4810=> 'https://www.stimma.com.ua/shop/zhinochij-longsliv-stimma-nadzha-9600',
4868=> 'https://www.stimma.com.ua/shop/zhinochij-longsliv-stimma-nadiris-9759',
4871=> 'https://www.stimma.com.ua/shop/zhinochij-longsliv-stimma-nadiris-9760',
5416=> 'https://www.stimma.com.ua/shop/zhenskij-longsliv-stimma-inzhu-3911',
3897=> 'https://www.stimma.com.ua/shop/zhenskaya-rubashka-stimma-cabesti-7637',
3901=> 'https://www.stimma.com.ua/shop/zhenskaya-rubashka-stimma-cabesti-7638',
3905=> 'https://www.stimma.com.ua/shop/zhenskaya-rubashka-stimma-cabesti-7639',
3908=> 'https://www.stimma.com.ua/shop/zhenskaya-rubashka-stimma-cabesti-7640',
3912=> 'https://www.stimma.com.ua/shop/zhenskaya-rubashka-stimma-cabesti-7641',
3916=> 'https://www.stimma.com.ua/shop/zhenskaya-rubashka-stimma-cabesti-7642',
3920=> 'https://www.stimma.com.ua/shop/zhenskaya-rubashka-stimma-cabesti-7643',
3674=> 'https://www.stimma.com.ua/shop/zhenskaya-bluza-stimma-sejfolla-6566',
3682=> 'https://www.stimma.com.ua/shop/zhenskaya-bluza-stimma-solada-4803',
3698=> 'https://www.stimma.com.ua/shop/zhenskaya-bluza-stimma-solada-4805',
3700=> 'https://www.stimma.com.ua/shop/zhenskaya-bluza-stimma-solada-4806',
3704=> 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-valensiya-4770',
3787=> 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-tamira-6182',
3791=> 'https://www.stimma.com.ua/magazin/zhenskij-kostyum-stimma-tamira-6183?lang=uk',
3825=> 'https://www.stimma.com.ua/magazin/zhenskij-kostyum-stimma-botejn-6476?lang=uk',
3940=> 'https://www.stimma.com.ua/magazin/zhinochij-kostyum-stimma-ivet-8702?lang=uk',
3943=> 'https://www.stimma.com.ua/magazin/zhinochij-kostyum-stimma-ivet-8700?lang=uk',
4048=> 'https://www.stimma.com.ua/magazin/zhinochij-kostyum-stimma-ivet-8701?lang=uk',
4281=> 'https://www.stimma.com.ua/shop/zhenskij-kostyum-stimma-tilda-8824?lang=uk',
4285=> 'https://www.stimma.com.ua/?s=8825&post_type=product&lang=uk',
4677=> 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-asiya-9617?lang=uk',
5082=> 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-mironiya-9892?lang=uk',
5085=> 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-mironiya-9890?lang=uk',
5087=> 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-mironiya-9891?lang=uk',
5090=> 'https://www.stimma.com.ua/shop/zhinochij-kostyum-stimma-mironiya-9893?lang=uk',
4979=> 'https://www.stimma.com.ua/shop/zhinochij-komplekt-stimma-akiya-9826?lang=uk',
4708=> 'https://www.stimma.com.ua/shop/zhinochi-bryuki-stimma-allisum-2-9569?lang=uk',
3811=> 'https://www.stimma.com.ua/magazin/zhenskij-svitshot-stimma-tirena-6365?lang=uk',
3814=> 'https://www.stimma.com.ua/magazin/zhenskoe-xudi-stimma-romaks-6332?lang=uk',
3822=> 'https://www.stimma.com.ua/magazin/zhenskoe-xudi-stimma-romaks-6331?lang=uk',
5276=> 'https://www.stimma.com.ua/shop/zhinochij-svitshot-stimma-miorel-0023?lang=uk',
5279=> 'https://www.stimma.com.ua/shop/zhinochij-svitshot-stimma-miorel-0024?lang=uk',
3806=> 'https://www.stimma.com.ua/magazin/zhenskij-golf-stimma-niolla-6320?lang=uk',
3808=> 'https://www.stimma.com.ua/magazin/zhenskij-golf-stimma-midona-6314?lang=uk',
4972=> 'https://www.stimma.com.ua/shop/zhinochij-golf-stimma-ilariona-9882?lang=uk',
4974=> 'https://www.stimma.com.ua/shop/zhinochij-golf-stimma-ilariona-9883?lang=uk',
5412=> 'https://www.stimma.com.ua/shop/zhenskij-golf-stimma-olifiya-4165?lang=uk',
];


$relation = [
    '0032'=>5285,
'0005'=>5220,
'0031'=>5282,
'3000'=>5375,
'0028'=>5291,
'0043'=>5350,
'0026'=>5288,
'0035'=>5297,
'0044'=>5347,
'0027'=>5294,
'0045'=>5344,
'0036'=>5301,
'0042'=>5305,
'0029'=>5207,
'0072'=>5368,
'0014'=>5239,
'0038'=>5235,
'0030'=>5362,
'0037'=>5231,
'0007'=>5197,
'0008'=>5192,
'9944'=>5110,
'9915'=>5029,
'9831'=>5000,
'9849'=>4997,
'9769'=>4970,
'8316'=>4846,
'9649'=>4368,
'9621'=>4817,
'9488'=>4688,
'9440'=>4691,
'9511'=>4701,
'9489'=>4688,
'9358'=>4462,
'8945'=>4291,
'8835'=>4212,
'1627'=>5419,
'0024'=>5394,
'0641'=>5388,
'0025'=>5406,
'0067'=>5380,
];

if(!isset($_SESSION['URLS']))
    $_SESSION['URLS'] = $urls;

require_once $_SERVER['DOCUMENT_ROOT'] . '/get_auto_list/phpQuery.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/get_auto_list/functions.php';

$variants = [

];
global $DB;
foreach ($_SESSION['URLS'] as $id => $link)
{
    //$id = $relation[$modelID];
    if(intval($id)<=0 || isset($Products[$id])) continue;
    $html = getContent($link);
    $doc = phpQuery::newDocument($html);

    $table = [];

    $block = $doc -> find('#nasa-tab-description');
    $tableHtml = pq($block) -> find('table');
    $indexTr = 0;
    foreach (pq($tableHtml) -> find('tr') as $tr)
    {
        $table[$indexTr] = [];
        foreach (pq($tr) -> find('td') as $td)
        {
            $table[$indexTr][] = pq($td) -> text();
        }
        $indexTr++;
    }
    $DB -> Query('insert into size_table (UF_PRODUCT, UF_TABLE) values (\''.$id.'\',\''.serialize($table).'\')');
    unset($_SESSION['URLS'][$id]);

    ?>
    <script>
        function sayHi() {
            location.reload();
        }

        setTimeout(sayHi, 100);
    </script>
    <?
    die('process ...  left: ' . count($_SESSION['URLS']));

}

die('end');*.


/*$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 25]);
$exists = $colors = $materials = $items = $vids = [];
while ($record = $res -> GetNextElement())
{
    $fields = $record->GetFields();
    $props = $record->GetProperties();

    if(!$props['VID']['VALUE']) continue;

    $items[$fields['ID']] = $fields;
    $items[$fields['ID']]['PROPERTIES'] = $props;

    $vids[] = $props['VID']['VALUE'];
}
$vids = array_unique($vids);
?><pre><?=print_r($vids, 1)?></pre><?
die();*/
/*
$not = [];
$resTP = CIBlockElement::GetList([], ['IBLOCK_ID' => 25]);
while ($tp = $resTP -> GetNextElement())
{
    $props = $tp -> GetProperties();
    $fields = $tp -> GetFields();

    if(!$props['MATERIAL']['VALUE'])
    {
        $not[$props['CML2_LINK']['VALUE']][$fields['ID']] = $fields['NAME'];
    }
}
?><pre><?=print_r(count($not), 1)?></pre><?
?><pre><?=print_r($not, 1)?></pre><?
die();*/


require_once $_SERVER['DOCUMENT_ROOT'].'/test/stimma_com_ua.php';
$existsColors = [];
/*$res = $DB -> Query('select * from max_color_reference');
while ($record = $res -> Fetch())
    $existsColors[$record['UF_XML_ID']] = $record;
*/
$res = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => 25, 'CODE' => 'SOSTAV']);
$existsMaterials = [];
while ($record = $res -> Fetch())
{
    $existsMaterials[$record['XML_ID']] = $record['ID'];
}

$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21], false, false, ['ID','IBLOCK_ID', 'NAME', 'PROPERTY_MODEL']);
while ($record = $res -> Fetch())
{
    $exists[$record['ID']] = (string)$record['PROPERTY_MODEL_VALUE'];
}
$cnt = 0;
$materials = $sizes = $colors = $byModel = [];
$nf = $notModel = 0;
$names = [];
$urls = [];
$need = ['0032',
         '0005',
         '0031',
         '3000',
         '0028',
         '0043',
         '0026',
         '0035',
         '0044',
         '0027',
         '0045',
         '0036',
         '0042',
         '0029',
         '0072',
         '0014',
         '0038',
         '0030',
         '0037',
         '0007',
         '0008',
         '9944',
         '9915',
         '9831',
         '9849',
         '9769',
         '8316',
         '9649',
         '9621',
         '9488',
         '9440',
         '9511',
         '9489',
         '9358',
         '8945',
         '8835',
         '1627',
         '0024',
         '0641',
         '0025',
         '0067'];
foreach ($products as $index => $product)
{
    /*if(isset($exists[mb_strtolower($product['material'])]))
    {
        $materials[] = $product['name'];
        $products[$index]['id'] = $exists[mb_strtolower($product['material'])];
        $cnt++;
    }
    else*/
    {
        preg_match('/([0-9]+)/', $product['name'], $matches);
        if($matches[1])
        {
            $key = array_search($matches[1], $exists);
            if($key && $product['sostav'])
            $urls[$matches[1]] = [
                    'material' => $product['sostav'],
                    'id' => $key
            ];

            /*if($key && $product['name'])
            {
                $cache = explode(',',$product['name']);
                foreach ($cache as $index2 => $item)
                {
                    $item = trim($item);
                    $xml = CUtil::translit($item, 'ru', ['replace_space' => '_', 'replace_other' => '_']);
                    if(isset($existsMaterials[$xml]))
                        $urls[$matches[1]]['value'][] = $existsMaterials[$xml];
                    else
                    {
                        ?><pre><?=print_r($xml, 1)?></pre><?
                        ?><pre><?=print_r($item, 1)?></pre><?
                        echo 'NEED CREATE<br>';
                    }
                }
            }
            */

            continue;

            $products[$index]['find_model'] = $matches[1];
            $byModel[$matches[1]] = $product['url'];
            $products[$index]['id'] = $exists[$matches[1]];

            if(!isset($exists[$matches[1]]))
            {
                $nf++;
                $names[$matches[1]] = $product['material'];
            }
            else
            {
                //
                    $urls[$exists[$matches[1]]] = $product['url'];
            }
        }
        else
            $notModel++;

        /*preg_match('/attribute_pa_razmer=([a-z0-9-_]+)/', $product['url'], $matches);
        if($matches[1])
        {
            $products[$index]['razmer'] = $matches[1];
            $sizes[$matches[1]] = $matches[1];
        }

        preg_match('/attribute_pa_cvet=([a-z0-9-_]+)/', $product['url'], $matches);
        if($matches[1])
        {
            $products[$index]['cvet'] = $matches[1];
            $colors[$matches[1]] = $matches[1];
        }*/

    }
}

$ibpenum = new CIBlockPropertyEnum;
foreach ($urls as $index => $url)
{
    if(!$url['id']) continue;
    $value = false;

    $item = trim($url['material']);
    if(empty($item)) continue;

    $xml = CUtil::translit($item, 'ru', ['replace_space' => '_', 'replace_other' => '_']);
    if(!isset($existsMaterials[$xml]))
    {
        $PropID = $ibpenum->Add(Array('PROPERTY_ID'=>622, 'XML_ID' => $xml, 'VALUE' => $item));
        $existsMaterials[$xml] = $PropID;
        $value = $PropID;
    }
    else
        $value = $existsMaterials[$xml];


    $resTP = CIBlockElement::GetList([], ['IBLOCK_ID' => 25,'PROPERTY_CML2_LINK' => $url['id']], false, false, ['ID','IBLOCK_ID','PROPERTY_SOSTAV']);
    while ($tp = $resTP -> Fetch())
    {
        if(!$tp['PROPERTY_SOSTAV_VALUE'])
            CIBlockElement::SetPropertyValuesEx($tp['ID'], false, array('SOSTAV' => $value));
    }
}

?><pre><?=print_r($urls, 1)?></pre><?
die();

$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 25]);
$tp = [];
while ($record = $res -> GetNextElement())
{
    $f = $record->GetFields();
    $p = $record -> GetProperties();

    if($p['MATERIAL']['VALUE'])
    {
        $mainID = $p['CML2_LINK']['VALUE'];

        $model = $exists[$mainID];
        unset($urls[$model]);
    }

}




$update = [];
foreach ($urls as $index => $product)
{
    if(!isset($product['id']) || !$product['id'] || !$product['material']) continue;
    $cache = explode(',',$product['material']);
    foreach ($cache as $index2 => $item)
    {
        $item = trim($item);
        $xml = CUtil::translit($item, 'ru', ['replace_space' => '_', 'replace_other' => '_']);
        if(isset($existsMaterials[$xml]))
            $update[$product['id']][] = $existsMaterials[$xml];
        else
        {
            ?><pre><?=print_r($xml, 1)?></pre><?
            ?><pre><?=print_r($item, 1)?></pre><?
            echo 'NEED CREATE<br>';
        }
    }

}
?><pre><?=print_r($update, 1)?></pre><?
foreach ($update as $index => $item)
{
    $resTP = CIBlockElement::GetList([], ['IBLOCK_ID' => 25,'PROPERTY_CML2_LINK' => $index]);
    while ($tp = $resTP -> Fetch())
    {
        //CIBlockElement::SetPropertyValuesEx($tp['ID'], false, array('MATERIAL' => $item));
    }
    //CIBlockElement::SetPropertyValuesEx($index, false, array('MATERIAL' => $item));
}

?><pre><?=print_r(count($urls), 1)?></pre><?
?><pre><?=print_r($urls, 1)?></pre><?
//echo '$urls='.var_export($urls, 1).';';
die();

$materials = array_unique($materials);

$sizes['xs'] = 170;
$sizes['s'] = 171;
$sizes['m'] = 172;
$sizes['l'] = 173;
$sizes['xl'] = 174;
$sizes['xxl'] = 175;
$sizes['xxxl'] = 176;
$sizes['40'] = 179;
$sizes['2xl'] = 175;
$sizes['3xl'] = 176;

$res = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => 25, 'CODE' => 'MATERIAL']);
$existsMaterials = [];
while ($record = $res -> Fetch())
{
    $existsMaterials[$record['XML_ID']] = $record['ID'];
}

$ibpenum = new CIBlockPropertyEnum;
$byModelIds = $byModelIdsLinks = [];
/*foreach ($byModel as $index => $material)
{
    $cache = explode(',',$material);
    $value = [];
    foreach ($cache as $index2 => $item)
    {
        $item = trim($item);
        $xml = CUtil::translit($item, 'ru', ['replace_space' => '_', 'replace_other' => '_']);
        if(!isset($existsMaterials[$xml]))
        {
            $PropID = $ibpenum->Add(Array('PROPERTY_ID'=>621, 'XML_ID' => $xml, 'VALUE' => $item));
            $existsMaterials[$xml] = $PropID;
            $value[] = $PropID;
        }
        else
            $value[] = $existsMaterials[$xml];
    }

    if(!empty($value))
        $byModelIds[$index] = $value;
}*/

/*$update = [];
foreach ($products as $index => $product)
{
    if(!isset($product['id']) || !$product['id']) continue;
    $cache = explode(',',$product['name']);
    foreach ($cache as $index2 => $item)
    {
        $item = trim($item);
        $xml = CUtil::translit($item, 'ru', ['replace_space' => '_', 'replace_other' => '_']);
        $update[$product['id']][] = $existsMaterials[$xml];
    }

}
foreach ($update as $index => $item)
{
    //CIBlockElement::SetPropertyValuesEx($index, false, array('MATERIAL' => $item));
}*/
foreach ($byModelIds as $model => $material)
{
    $model = trim($model);
    if(!$model) continue;
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21,'PROPERTY_MODEL' => $model]);
    if($res = $res -> Fetch())
    {
        $resTP = CIBlockElement::GetList([], ['IBLOCK_ID' => 25,'PROPERTY_CML2_LINK' => $res['ID']]);
        while ($tp = $resTP -> Fetch())
        {
            //CIBlockElement::SetPropertyValuesEx($tp['ID'], false, array('MATERIAL' => $material));
        }
    }
}

?><pre><?=print_r($byModelIds, 1)?></pre><?
/*file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/stimma_com_ua.php', '<?$products='.var_export($products, 1).';?>');*/


die();
$xml = simplexml_load_file('https://www.stimma.com.ua/wp-content/plugins/saphali-export-yml/export.yml');
$shop = $xml -> shop;
$items = [];
foreach ($shop -> offers -> offer as $index => $offer)
{
    $url = $offer -> url;
    $name = $offer -> name;

    $params = $offer -> param;
    $material = false;

    foreach ($params as $param)
    foreach ($param -> attributes() as $indexAttr => $attribute)
        if((string)$attribute == 'sostav')
            $material = (string)$param;

    $items[] = [
            'name' => (string)$name,
            'url' => (string)$url,
            //'material' => (string)$material,
            'sostav' => (string)$material,
    ];
}
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/stimma_com_ua.php', '<?$products='.var_export($items, 1).';?>')

?><pre><?=print_r($items, 1)?></pre><?
die('end');

$res = $DB -> Query('select * from max_color_reference');
$list = [];
while ($record = $res -> Fetch())
{
    $cnt = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_COLOR_REF' => $record['UF_XML_ID']], []);
    $list[$record['UF_XML_ID']] = $cnt;
}
?><pre><?=print_r($list, 1)?></pre><?
die();
$props = [
    0 => "AGE",
    1 => "MATERIAL",
    2 => "SELECTION",
    3 => "PRINT",
    4 => "RAZMER",
    5 => "ROST",
    6 => "SOSTAV",
    7 => "STYLES",
];

$list = [];
$res = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => 25, 'CODE' => $props]);
while ($record = $res -> Fetch())
{
    $cnt = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_'. $record['PROPERTY_CODE'] => $record['ID']], []);

    $list[$record['PROPERTY_CODE']][$record['XML_ID']] = $cnt;
}
?><pre><?=print_r($list, 1)?></pre><?
die();

die();
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/classes/update_products.php';
$prods = prods::getInstance();
$prods -> setStep(4);
$prods -> run();
die();

global $DB;



require_once $_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/offers.php';

$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/test/list.csv', 'w');

$arItems = [
    'ID','Модель','Название','Фото','Цена со скидкой','Цена','Описание'
];
fputcsv($fp, $arItems);
foreach ($offers as $model => $items)
{
    foreach ($items['offers'] as $id => $item)
    {
        $toadd = [
            $item['id'],$model,$item['name'],$item['picture'],$item['price'],$item['old_price'],$item['description']
        ];
        fputcsv($fp, $toadd);
    }
}
fclose($fp);
?><pre><?=print_r($offers, 1)?></pre><?

die();

?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>