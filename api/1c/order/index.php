<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// якшо нема заказів - віддавати пустий маисв в json
global $DB;
$order_id = 8824;
$order_id = 8772;

$json = $orders = [];
$limit = 10;
Bitrix\Main\Diag\Debug::writeToFile(1, "start get order " , '/test_get_order.txt');


$res = $DB->Query('select * from orders_1c order by id asc limit '.$limit);

$debug = isset($_GET['debug']);

while ($rec = $res->Fetch())
    $orders[$rec['UF_ORDER_ID']] = $rec;
Bitrix\Main\Diag\Debug::writeToFile($orders, "start get order " , '/test_get_order.txt');
//$orders = [10586,10587,10588];

if(isset($_GET['order_id']))
    $orders[] = ['UF_ORDER_ID'=>$_GET['order_id'],'UF_STATUS'=>'N'];

foreach($orders as $index => $order_item)
{
    $order_id = $order_item['UF_ORDER_ID'];

    /*if($debug)
    {
        ?><pre><?=print_r($order_id, 1)?></pre><?
    }

    $status = $order_item['UF_STATUS'];

    $order = $DB->Query('select * from b_sale_order where ID = '.$order_id)->Fetch();

    $orderProps = [];
    $orderPropsDB = $DB->Query('select * from b_sale_order_props_value where ORDER_ID = '.$order_id);
    while ($record = $orderPropsDB->Fetch())
        $orderProps[$record['ORDER_PROPS_ID']] = $record;

    $basketDB = $DB->Query('select * from b_sale_basket where ORDER_ID = '.$order_id);

    $basket = $jsonBasket = $delivery = [];
    while ($record = $basketDB->Fetch())
    {
        if($debug)
        {
            ?><pre><?=print_r($record, 1)?></pre><?
        }

        $props = CIBlockElement::GetByID($record['PRODUCT_ID'])->GetNextElement()->GetProperties();
        $item = $DB->Query('select * from b_iblock_element where ID = '.$record['PRODUCT_ID'])->Fetch();

        preg_match('/(\d+)/', $item['NAME'], $matches);
        $basket[] = $record;
        $jsonBasket[] = [
            //'product_uid' => $matches[1],
            'product_uid' => $props['ARTICLE']['VALUE'],
            'name' => $record['NAME'],
            'price' => $record['PRICE'],
            'quantity' => $record['QUANTITY'],
            'amount' => $record['PRICE'] * $record['QUANTITY'],
            'stims' => 0,
        ];
    }
    if($order['DELIVERY_ID'] == 14) // Нова пошта
    {
        $city = $post = [];
        if($orderProps[27]['VALUE'])
            $city = $DB->Query('select * from np_cities_new where ID = ' . $orderProps[27]['VALUE'])->Fetch();
        if($orderProps[28]['VALUE'])
            $post = $DB->Query('select * from np_posts_new where ID = ' . $orderProps[28]['VALUE'])->Fetch();
        $delivery['type'] = 'np';
        $delivery['name'] = 'Нова пошта';
        $delivery['city'] = $city['UF_REF_ID'];
        $delivery['city_name'] = $city['UF_NAME_UA'];
        $delivery['post'] = $post['UF_REF_ID'];
        $delivery['adress'] = '№'.$post['UF_NUMBER'].' ' .$post['UF_SHORT_ADRESS_UA'];
    }
    elseif($order['DELIVERY_ID'] == 15) // Укрпошта
    {
        $city = $post = [];
        if($orderProps[27]['VALUE'])
            $city = $DB->Query('select * from ukrposhta_cities where ID = ' . $orderProps[27]['VALUE'])->Fetch();
        if($orderProps[28]['VALUE'])
            $post = $DB->Query('select * from ukrposhta_posts where ID = ' . $orderProps[28]['VALUE'])->Fetch();

        $delivery['type'] = 'ukr';
        $delivery['name'] = 'УкрПошта';
        $delivery['city'] = $city['UF_CITY_ID'];
        $delivery['city_name'] = $city['UF_CITY_UA'] . ' ' . $city['UF_CITYTYPE_UA']. ' ' . $city['UF_REGION_UA'] . ' обл, ' . $city['UF_DISTRICT_UA'] . ' р-н';
        $delivery['post'] = $post['UF_ID'];
        $delivery['adress'] = $post['UF_POSTINDEX'] . ', ' . $post['UF_ADDRESS'];
        $delivery['index'] = $post['UF_POSTINDEX'];
    }
    elseif($order['DELIVERY_ID'] == 13) // Самовивіз
    {
        $delivery['type'] = 'pickup';
        $delivery['name'] = 'Самовивіз';
        $delivery['city'] = $order['DELIVERY_ID'];
    }

    $pay = CSalePaySystem::GetByID($order['PAY_SYSTEM_ID']);
    $pay = [
        'name' => $pay['NAME'],   
        'id' => $pay['PAY_SYSTEM_ID'],
    ];

    if($status == 'CK')
        $jsonBasket = [];

    $kastaId = '';
    $findOrder = $DB->Query('select * from b_sale_order_props_value where CODE = \'KASTA_ID\' and ORDER_ID = ' . $order_id);
    if($findOrder = $findOrder->Fetch()) $kastaId = $findOrder['VALUE'];

    $json[] = [
        'order_id' => $order_id,
        'create_at' => strtotime($order['DATE_INSERT']),
        'comment' => $order['COMMENTS'] . ' ' . $delivery['name'],
        'currency' => 'UAH',
        'amount' => $status == 'CK' ? 0 : $order['PRICE'],
        'contragent' => [
            'name' => $orderProps[22]['VALUE'],
            'last_name' => $orderProps[23]['VALUE'],
            'second_name' => $orderProps[29]['VALUE'],
            'phone' => $orderProps[3]['VALUE'],
            'email' => $orderProps[2]['VALUE'],
        ],
        'delivery' => $delivery,
        'pay' => $pay,
        'items'=>$jsonBasket,
        'adress'=>$delivery['adress'],
        'kasta_id'=>$kastaId,
    ];*/

    $json[] = getOrderFor1C($order_id,$order_item['UF_STATUS'],$debug);
}
if(isset($_GET['order_id']))
{
    ?><pre><?=print_r($json, 1)?></pre><?
}
echo json_encode($json);

