<?require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;

CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

$token = '26qu4soa5ttj5bidn8e500kzxeugtcp7kgle8yoi';


function getKastaProducts($token, $page = 1, $limit = 5000)
{
    $url = "https://api.kasta.ua/api/v2/products/?page={$page}&limit={$limit}";

    $headers = [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        return $data;
    } else {
        throw new Exception("Ошибка при получении товаров: " . $response);
    }
}

function updateKastaProduct($token, $productId, $data)
{
    $url = "https://api.kasta.ua/api/v2/products/{$productId}/";
    $headers = [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ];
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => "PUT",
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_POSTFIELDS     => json_encode($data),
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($httpCode === 200)
    {
        return json_decode($response, true);
    }
    else
    {
        throw new Exception("Ошибка при обновлении товара #$productId: " . $response);
    }
}

function addKastaProduct($token, $productData)
{
    $url = "https://api.kasta.ua/api/v2/products/";
    $headers = [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ];
    $payload = json_encode($productData);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if(in_array($httpCode, [
        200,
        201
    ]))
    {
        return json_decode($response, true);
    }
    else
    {
        throw new Exception("Ошибка при добавлении товара: " . $response);
    }
}

function getKastaOrders($token, $updatedFrom = null, $limit = 20) {
    $url = 'https://hub.kasta.ua/api/orders/list'; // Актуальный URL для seller API Kasta

    // Время последнего обновления (ISO 8601 формат)
    if (!$updatedFrom) {
        $updatedFrom = date('c', strtotime('-1 hour')); // по умолчанию — за последний час
    }

    // Подготавливаем POST-данные
    $postData = [
        "filters" => [
            "updated_from" => $updatedFrom
        ],
        "limit" => $limit
    ];

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => false,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: ' . $token
        ],
        //CURLOPT_POSTFIELDS => json_encode($postData),
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }

    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception("Kasta API error: HTTP $httpCode. Response: $response");
    }

    return json_decode($response, true);
}




/*// Пример товара
$product = [
    "sku"            => "SKU123456",
    // Ваш внутренний код товара
    "title"          => "Мужская футболка черная",
    "description"    => "100% хлопок, производство Украина. Размеры M–XXL.",
    "brand"          => "MyBrand",
    "category"       => "t-shirts",
    // категория по справочнику Kasta
    "price"          => 49900,
    // цена в копейках (499.00 грн)
    "discount_price" => 39900,
    // цена по акции
    "quantity"       => 20,
    "images"         => [
        "https://example.com/images/futbolka-1.jpg",
        "https://example.com/images/futbolka-2.jpg"
    ],
    "attributes"     => [
        "color" => "black",
        "size"  => [
            "M",
            "L",
            "XL"
        ]
    ]
];
// Тест
try
{
    $token = "ВАШ_API_ТОКЕН";
    $result = addKastaProduct($token, $product);
    echo "Товар добавлен: ";
    print_r($result);
} catch(Exception $e)
{
    echo $e->getMessage();
}
// Пример использования
try {
    $token = "ВАШ_API_ТОКЕН";
    $products = getKastaProducts($token);
    echo "<pre>";
    print_r($products);
    echo "</pre>";
} catch (Exception $e) {
    echo $e->getMessage();
}

// Пример использования
try
{
    $token = "ВАШ_API_ТОКЕН";
    $productId = 123456; // замените на реальный ID товара
    $updateData = [
        "name"      => "Новое название товара",
        "price"     => 599.99,
        "available" => true,
        // другие поля по API-документации
    ];
    $result = updateKastaProduct($token, $productId, $updateData);
    echo "<pre>";
    print_r($result);
    echo "</pre>";
} catch(Exception $e)
{
    echo $e->getMessage();
}*/

// Пример использования
try
{
    global $DB;
    $uadd = new CUser;

    $params = [
        "status"    => "new",
        "limit"     => 50,
        "offset"    => 0
    ];
    $orders = getKastaOrders($token, $params);
    foreach($orders['items'] as $index => $orderKasta)
    {
        $kastaId = $orderKasta['id'];
        $findOrder = $DB->Query('select * from b_sale_order_props_value where CODE = \'KASTA_ID\' and VALUE = \'' . $kastaId.'\'');

        if($findOrder = $findOrder->Fetch()) continue;

        $client = $orderKasta['client'];
        $client['phone'] = '+'.$client['phone'];

        $uid = 1; // todo узнать

        $user = $DB->Query('select * from b_user where PERSONAL_PHONE = \''.$client['phone'].'\'');
        if($user = $user->Fetch())
            $uid = $user['ID'];
        else
        {
            $pass = uniqid();
            $uid = $uadd->Add(['LOGIN' => $client['phone'], 'PASSWORD' => $pass, 'CONFIRM_PASSWORD' => $pass, 'PERSONAL_PHONE' => $client['phone'],'NAME'=>$client['first_name'],'SECOND_NAME'=>$client['last_name'],'LAST_NAME'=>$client['middle_name']]);

            if(!$uid)
            {
                // todo лог еррор
            }
        }



        $siteId = 's2';
        $currencyCode = 'UAH';
        //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 2 " , '/___change_rozetka_status.txt');
        // Создаёт новый заказ
        $order = Order::create($siteId, $uid);
        $order->setPersonTypeId(1);
        $order->setField('CURRENCY', $currencyCode);
        $order->setField('USER_DESCRIPTION', implode(' / ',  $orderKasta['comments']));
        //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 3 " , '/___change_rozetka_status.txt');
        // Создаём корзину с одним товаром
        $basket = Basket::create($siteId);


        //$basket = [];
        foreach($orderKasta['ordered_items'] as $ordered_item)
        {
            $id = str_replace('rzid_','',$ordered_item['unique_sku_id']);
            $db = CIBlockElement::GetByID($id) -> Fetch();
            $arItem=[];

            $arItem = $db;
            $arItem['PICTURE'] = $db['PREVIEW_PICTURE'] ? $db['PREVIEW_PICTURE'] : $db['DETAIL_PICTURE'];
            $arItem['PRICE'] = $ordered_item['supplier_price'];
            $arItem['QUANTITY'] = $ordered_item['quantity'];

            //$basket['ITEMS'][] = $arItem;

            $item = $basket->createItem('catalog', $id);
            $item->setFields(array(
                                 'QUANTITY' => $ordered_item['quantity'],
                                 'CURRENCY' => $currencyCode,
                                 'LID' => $siteId,
                                 'PRODUCT_ID' => $id,
                                 'NAME' => $db['NAME'],
                                 'PRICE' => intval($ordered_item['supplier_price']),
                                 'CUSTOM_PRICE' => 'Y',
                                 //'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider'
                             ));
        }
        //$basket['BASKET_COUNT'] = count($basket['ITEMS']);



        //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 4 " , '/___change_rozetka_status.txt');
        //$basket->save();
        //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 4.5 " , '/___change_rozetka_status.txt');
        $order->setBasket($basket);
        //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 5 " , '/___change_rozetka_status.txt');


        // Создаём одну отгрузку и устанавливаем способ доставки - "Без доставки" (он служебный)
        $shipmentCollection = $order->getShipmentCollection();
        $idShipment = 14;
        $orderProps = [];
        if($orderKasta['delivery_properties']['type'] == 'novaposhta')
        {
            $orderProps = [
                27 => $orderKasta['shipping_address']['warehouse']['delivery_service_info']['city_ref_id'], // Місто ID
                28 => $orderKasta['shipping_address']['warehouse']['ref_id'], // post id
                7 => $orderKasta['shipping_address']['warehouse']['name'], // відділення назва
                5 => $orderKasta['shipping_address']['city']['name'], // Місто назва
                23 => $client['last_name'], // Прізвище
                22 => $client['first_name'], // Імя
                29 => $client['middle_name'], // По батькові
                3 => $client['phone'], // Телефон
                30 => $orderKasta['id'], // id kasta order
            ];
            $idShipment = 14;
        }

        //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 6 " , '/___change_rozetka_status.txt');
        $shipment = $shipmentCollection->createItem(Bitrix\Sale\Delivery\Services\Manager::getObjectById($idShipment));

        //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 7 " , '/___change_rozetka_status.txt');
        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        foreach ($basket as $basketItem)
        {
            $item = $shipmentItemCollection->createItem($basketItem);
            $item->setQuantity($basketItem->getQuantity());
        }
        //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 8 " , '/___change_rozetka_status.txt');
        // Создаём оплату со способом #1
        $payment = 3;
        if($orderKasta['requested_payment_method'] == 'cod')
            $payment = 9;

        //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 9 " , '/___change_rozetka_status.txt');
        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem(Bitrix\Sale\PaySystem\Manager::getObjectById($payment));
        $payment->setField("SUM", $order -> getPrice());
        $payment->setField("CURRENCY", 'UAH');





        $order->doFinalAction(true);
        $result = $order->save();
        //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 12 " , '/___change_rozetka_status.txt');
        if (!$result->isSuccess())
        {
            //$result->getErrors();
            ?><pre> error create order <?=print_r($result->getErrors(), 1)?></pre><?
            //Bitrix\Main\Diag\Debug::writeToFile( $result->getErrors(), "error create order " , '/___change_rozetka_status.txt');
        }
        else
        {
            $orderId = $order->getId();
            ?><pre> order id <?=print_r($orderId, 1)?></pre><?

            $propsDB = $DB->Query('select * from b_sale_order_props_value where ORDER_ID = ' . $orderId);
            $props = [];
            while ($record = $propsDB->Fetch())
                $props[$record['ORDER_PROPS_ID']] = $record['ID'];
            //Bitrix\Main\Diag\Debug::writeToFile($props, " props before " , '/debug_create_order.txt');
            if($props['30'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['30']).'\' where ID = ' . $props['30']);
            else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',30, \'Kasta ID\', \''.addslashes($orderProps['30']).'\', \'SECOND_NAME\', \''.$orderId.'\', \'ORDER\')');
            if($props['29'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['29']).'\' where ID = ' . $props['29']);
            else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',29, \'По батькові\', \''.addslashes($orderProps['29']).'\', \'SECOND_NAME\', \''.$orderId.'\', \'ORDER\')');
            if($props['27'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['27']).'\' where ID = ' . $props['27']);
            else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',27, \'Місто ID\', \''.addslashes($orderProps['27']).'\', \'MISTO_ID\', \''.$orderId.'\', \'ORDER\')');
            if($props['28'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['28']).'\' where ID = ' . $props['28']);
            else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',28, \'POST_ID\', \''.addslashes($orderProps['28']).'\', \'POST_ID\', \''.$orderId.'\', \'ORDER\')');
            if($props['23'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['23']).'\' where ID = ' . $props['23']);
            else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',23, \'Прізвище\', \''.addslashes($orderProps['23']).'\', \'LASTNAME\', \''.$orderId.'\', \'ORDER\')');
            if($props['22'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['22']).'\' where ID = ' . $props['22']);
            else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',22, \'Імя\', \''.addslashes($orderProps['22']).'\', \'NAME\', \''.$orderId.'\', \'ORDER\')');
            if($props['3'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['3']).'\' where ID = ' . $props['3']);
            else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',3, \'Телефон\', \''.addslashes($orderProps['3']).'\', \'PHONE\', \''.$orderId.'\', \'ORDER\')');
            if($props['5'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['5']).'\' where ID = ' . $props['5']);
            else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',5, \'Місто\', \''.addslashes($orderProps['5']).'\', \'CITY\', \''.$orderId.'\', \'ORDER\')');
            if($props['7'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['7']).'\' where ID = ' . $props['7']);
            else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',7, \'Відділення\', \''.addslashes($orderProps['7']).'\', \'ADDRESS\', \''.$orderId.'\', \'ORDER\')');

            $DB->Query('insert into orders_1c (UF_ORDER_ID,UF_STATUS) values ('.$orderId.',\'N\')');

            //Bitrix\Main\Diag\Debug::writeToFile( $orderId, "orderId " , '/___change_rozetka_status.txt');
        }


        ?><pre>$client <?=print_r($client, 1)?></pre><?
        ?><pre>$uid <?=print_r($uid, 1)?></pre><?
        ?><pre>$basket <?=print_r($basket, 1)?></pre><?
    }

    ?><pre><?=print_r($orders, 1)?></pre><?
} catch(Exception $e)
{
    echo $e->getMessage();
}
