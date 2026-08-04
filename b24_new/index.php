<?//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER['DOCUMENT_ROOT']."/b24_new/include/config.php");

$props = $basket = [];

$order = $DB -> Query('select * from b_sale_order where ID = ' . $orderID) -> Fetch();
$user = CUser::GetByID($order['USER_ID']) -> Fetch();
$userGroups = CUser::GetUserGroup($order['USER_ID']);

$isOptUser = in_array(9, $userGroups);
$isDropShip = in_array(11, $userGroups);
$isRozdrib = !$isOptUser && !$isDropShip;

global $DB;

$colorRef = [];
$res = $DB -> Query('select * from max_color_reference');
while ($record = $res -> Fetch())
    $colorRef[$record['UF_XML_ID']] = $record;

$res = $DB -> Query('select * from b_sale_basket where ORDER_ID = ' . $orderID);
$relationIDsB24 = [];
while ($record = $res -> Fetch())
{
    $basket[] = $record;

    $Product = CIBlockElement::GetByID($record['PRODUCT_ID'])->GetNextElement();
    $ProductProps = $Product->GetProperties();
    $ProductFields = $Product->GetFields();
    $price = CCatalogProduct::GetOptimalPrice($ProductFields['ID'])['RESULT_PRICE']['DISCOUNT_PRICE'];
    $productIDB24 = $ProductProps['BX_ID']['VALUE'];

    # Добавляем товар если нет кода
    if (!$productIDB24)
    {
        // добавление нового товара start
        $arFieldsProductAdd = array(
            "fields" => array(
                "NAME" => $ProductFields['NAME'],
                "CURRENCY_ID" => "UAH",
                "PRICE" => $price,
                "PROPERTY_100" => (string)$colorRef[$ProductProps['COLOR_REF']['VALUE_XML_ID'][0]]['UF_NAME'], // цвет
                "PROPERTY_102" => (string)$ProductProps['RAZMER']['VALUE'], // размер
                "PROPERTY_104" => $ProductFields['ID'], // id на сайте
                "PROPERTY_106" => (string)$ProductProps['MATERIAL']['VALUE'][0], // материал
                "MEASURE" => 9
            )
        );
        while (1) {
            $arProductAddResult = call("crm.product.add", $arFieldsProductAdd, true);
            if ($arProductAddResult['STATUS'] == 200) break;
        }
        CIBlockElement::SetPropertyValuesEx($ProductFields['ID'], false, array('BX_ID' => $arProductAddResult['result']));
        echo "Добавлен товар с ID: ".$arProductAddResult['result'];
        // добавление нового товара end
    }
    else
        $relationIDsB24[$record['PRODUCT_ID']] = [
                'BX_ID' => $productIDB24
        ];
    # /Добавляем товар если нет кода
}

$res = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = ' . $orderID);
while ($record = $res -> Fetch())
    $props[$record['CODE']] = $record;

# Начало передачи в Битрикс24
$arProducts              = [];
$arOrderProductsAll      = [];
$arProductsListResultAll = [];
foreach ($basket as $item)
    $arOrderProductsAll[] = (string)$item['PRODUCT_ID'];
//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductListResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductListResult.txt', print_r($arOrderProductsAll, true), FILE_APPEND);
$steps = ceil(count($arOrderProductsAll) / 50);
for ($i = 0; $i < $steps; $i++)
{
    $arOrderProductsStep = array_slice($arOrderProductsAll, $i, 50);
    array_splice($arOrderProductsAll, $i, 49);
    $arFieldsProductList = ["order" => ["NAME" => "ASC"], "filter" => ["PROPERTY_104" => $arOrderProductsStep], "select" => ["ID", "NAME", "CURRENCY_ID", "PRICE", "PROPERTY_*"]];
    while (1)
    {
        $arProductListResult = call("crm.product.list", $arFieldsProductList, true);
        if ($arProductListResult['STATUS'] != 503)
            break;
    }

    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductListResult.txt', print_r($arOrderProductsStep, true), FILE_APPEND);
    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductListResult.txt', print_r($arProductListResult, true), FILE_APPEND);
    foreach ($arProductListResult['result'] as $key => $arProductB24)
    {
        foreach ($basket as $obProduct)
        {
            $id = (string)$obProduct['PRODUCT_ID'];
            if ($arProductB24['PROPERTY_104']['value'] == $id)
            {
                $arProductListResult['result'][$key]['QUANTITY'] = (string)$obProduct['QUANTITY'];
                $arProductListResult['result'][$key]['NAME']     = (string)$obProduct['NAME'];
                if ($arProductB24['PRICE'] != (string)$obProduct['PRICE'])
                {
                    $arProductListResult['result'][$key]['PRICE'] = (string)$obProduct['PRICE'];
                }
            }
        }
    }
    $arProductsListResultAll = array_merge($arProductsListResultAll, $arProductListResult['result']);
}
$new = [];
foreach ($arProductsListResultAll as $index => $item)
    $new[$item['PROPERTY_104']['value']] = $item;

$arProductsListResultAll = array_values($new);

$phone_tmp          = str_replace([' ',')','(','-'],['','','',''],$props['PHONE']['VALUE']);
$phone              = [["VALUE" => $phone_tmp, "VALUE_TYPE" => "WORK"]];
$arFilter = (string)$props['PHONE']['VALUE'] ? ["PHONE" => $phone_tmp] : ["EMAIL" => (string)$props['EMAIL']['VALUE']];

$arContactsParams = ["order" => ["ID" => "ASC"], "filter" => $arFilter, "select" => ["ID", "EMAIL", "UF_CRM_1521453922", "ASSIGNED_BY_ID", "PHONE", "TYPE_ID"]];
while (1)
{
    $arContactsResult = call("crm.contact.list", $arContactsParams, true);
    if ($arContactsResult['STATUS'] == 200)
        break;
}
// поиск контакта end
//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arContactsResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arContactsResult.txt', print_r($arContactsResult, true), FILE_APPEND);
?><pre>$arContactsResult<?=print_r($arContactsResult, 1)?></pre><?
// якшо знайшло користувача
if (count($arContactsResult['result']) > 0)
{
    // поиск сделки start
    $arFieldsDealsList = ["order" => ["ID" => "ASC"], "filter" => ["UF_CRM_1523544904" =>$orderID], "select" => ["ID", "NAME", "UF_CRM_1523544904"]];
    while (1)
    {
        $arDealListResult = call("crm.deal.list", $arFieldsDealsList, true);
        if ($arDealListResult['STATUS'] == 200)
            break;
    }
    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealListResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealListResult.txt', print_r($arDealListResult, true), FILE_APPEND);
    // поиск сделки end
    if (empty($arDealListResult['result']))
    {
        // Массив соответствия тип клиента/направление сделки
        $arClientDealCategory = ["CLIENT"   => 0,      // Розничный покупатель
                                 "SUPPLIER" => 2,    // Дропшипер
                                 1          => 4,             // Оптовый покупатель
        ];
        // Массив соответствия тип клиента/статус сделки
        $arClientDealSatus = ["CLIENT"   => "NEW",      // Розничный покупатель
                              "SUPPLIER" => "C2:NEW",    // Дропшипер
                              1          => "C4:NEW",             // Оптовый покупатель
        ];
        // создание сделки существующего контакта start
        $arDealParams = ["fields" => ["CATEGORY_ID" => $arContactsResult['result'][0]["TYPE_ID"] ? $arClientDealCategory[$arContactsResult['result'][0]["TYPE_ID"]] : 0, "TITLE" => "Замовлення № " . $orderID, "TYPE_ID" => "SALE", // "STAGE_ID" => "NEW",
                                      "STAGE_ID"    => $arContactsResult['result'][0]["TYPE_ID"] ? $arClientDealSatus[$arContactsResult['result'][0]["TYPE_ID"]] : "NEW", "CONTACT_ID" => $arContactsResult['result'][0]['ID'], "OPENED" => "Y", "ASSIGNED_BY_ID" => $arContactsResult['result'][0]['ASSIGNED_BY_ID'], "CURRENCY_ID" => 'UAH', "OPPORTUNITY" => $order['PRICE'], "BEGINDATE" => date_format(date_create($order['DATE_INSERT']), 'd.m.Y'), "UF_CRM_1523544904" => $orderID, // ID замовлення на сайтi
                                      "COMMENTS"    => $order['USER_DESCRIPTION'] // комментарий
        ]];
        while (1)
        {
            $arDealResult = call("crm.deal.add", $arDealParams, true);
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/dealsAddLog.txt', print_r($arDealResult, true).PHP_EOL, FILE_APPEND);
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/dealsAddLog.txt', print_r($arDealParams, true).PHP_EOL, FILE_APPEND);
            if ($arDealResult['STATUS'] == 200)
                break;
        }
        // создание сделки существующего контакта end
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealResult.txt', print_r($arJSON['id']." - ".$arDealResult['STATUS']."\n", true), FILE_APPEND);
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealResult.txt', print_r($arDealResult['result']."\n", true), FILE_APPEND);
        if ($arDealResult['result'] > 0)
        {
            // добавление товаров в созданную сделку start
            foreach ($arProductsListResultAll as $key => $arProduct)
            {
                $arProducts[] = ["PRODUCT_ID" => $arProduct['ID'], "PRICE" => $arProduct['PRICE'], "QUANTITY" => $arProduct['QUANTITY'], "PRODUCT_NAME" => $arProduct['NAME']];
            }
            ?><pre>add products -1 ? $arProducts<?=print_r($arProducts, 1)?></pre><?
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arProducts, true), FILE_APPEND);
            Bitrix\Main\Diag\Debug::writeToFile($arDealResult['result'] , "order (1) " , '/debug_b24.txt');
            Bitrix\Main\Diag\Debug::writeToFile($arProducts, "order (1) " , '/debug_b24.txt');
            $arDealRowsAddParams = ["id" => $arDealResult['result'], "rows" => $arProducts,];
            while (1)
            {
                // Додаємо товари в замовлення
                $arDealRowsAddResult = call("crm.deal.productrows.set", $arDealRowsAddParams, true);
                if ($arDealRowsAddResult['STATUS'] == 200)
                    break;
            }
            // добавление товаров в созданную сделку end
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealRowsAddResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealRowsAddResult.txt', print_r($arDealRowsAddResult, true), FILE_APPEND);
        }
    }
}
else
{
    // якшо НЕ знайшло користувача
    // Создание контакта и сделки start
    $newManagerID   = 114; // ответственный  менеджер Настя Морозецька - роздріб - ID 114
    $contact_result = ['result' => false];
    //Создание контакта start
    //$phone_tmp          = preg_replace('~[^0-9]+~', '', $props['PHONE']['VALUE']);
    $phone_tmp          = str_replace([' ',')','(','-'],['','','',''],$props['PHONE']['VALUE']);
    $phone              = [["VALUE" => $phone_tmp, "VALUE_TYPE" => "WORK"]];
    $arFieldsContactAdd = ["fields" => ["OPENED"            => 'Y', "EXPORT" => 'Y', "TYPE_ID" => 'CLIENT', // категория клиента (оптовик, розничный покупатель)
                                        "SOURCE_ID"         => "WEB", "NAME" => $props['NAME']['VALUE'], // Имя
                                        "LAST_NAME"         => $props['NAME']['LASTNAME'], // Фамилия
                                        "PHONE"             => $phone, // Телефон
                                        "EMAIL"             => [["VALUE" => $props['EMAIL']['VALUE'], "VALUE_TYPE" => "WORK"]], // Email
                                        "UF_CRM_1521453922" => 0, //$arJSON['user_id'], // ID на сайте
                                        "ASSIGNED_BY_ID"    => $newManagerID, // ответственный
    ]];
    echo 'try to add contact';
    ?><pre>$arFieldsContactAdd<?=print_r($arFieldsContactAdd, 1)?></pre><?
    while (1)
    {
        $contact_result = call("crm.contact.add", $arFieldsContactAdd, true);
        if ($contact_result['STATUS'] == 200)
            break;
    }
    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arNewContactReult.txt', print_r($contact_result, true), FILE_APPEND);
    //Создание контакта end
    // Созданиесделки start
    if ($contact_result['result'] && $contact_result['result'] > 0)
    {
        // поиск сделки start
        $arFieldsDealsList = ["order" => ["ID" => "ASC"], "filter" => ["UF_CRM_1523544904" => $orderID], "select" => ["ID", "NAME", "UF_CRM_1523544904"]];
        while (1)
        {
            $arDealListResult = call("crm.deal.list", $arFieldsDealsList, true);
            if ($arDealListResult['STATUS'] == 200)
                break;
        }
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealListResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealListResult.txt', print_r($arDealListResult, true), FILE_APPEND);
        // поиск сделки end
        if (empty($arDealListResult['result']))
        {
            // Массив соответствия тип клиента/направление сделки
            $arClientDealCategory = ["CLIENT"   => 0,      // Розничный покупатель
                                     "SUPPLIER" => 2,    // Дропшипер
                                     1          => 4,             // Оптовый покупатель
            ];
            // создание сделки существующего контакта start
            $arDealParams = ["fields" => ["CATEGORY_ID" => $arClientDealCategory["CLIENT"],
                                          "TITLE" => "Замовлення № " . $orderID,
                                          "TYPE_ID" => "SALE",
                                          "STAGE_ID" => "NEW",
                                          "CONTACT_ID" => $contact_result['result'],
                                          "OPENED" => "Y",
                                          "ASSIGNED_BY_ID" => $newManagerID,
                                          "CURRENCY_ID" => 'UAH',
                                          "OPPORTUNITY" => $order['PRICE'],
                                          "BEGINDATE" => date_format(date_create($order['DATE_INSERT']), 'd.m.Y'),
                                          "UF_CRM_1523544904" => $orderID, // ID замовлення на сайтi
                                          "COMMENTS"    => $order['USER_DESCRIPTION'] // комментарий
            ]];
            while (1)
            {
                $arDealResult = call("crm.deal.add", $arDealParams, true);
                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/dealsAddLog.txt', print_r($arDealResult, true).PHP_EOL, FILE_APPEND);
                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/dealsAddLog.txt', print_r($arDealParams, true).PHP_EOL, FILE_APPEND);
                if ($arDealResult['STATUS'] == 200)
                    break;
            }
            // создание сделки существующего контакта end
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealResult.txt', print_r($arJSON['id']." - ".$arDealResult['STATUS']."\n", true), FILE_APPEND);
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealResult.txt', print_r($arDealResult['result']."\n", true), FILE_APPEND);
            if ($arDealResult['result'] > 0)
            {
                // добавление товаров в созданную сделку start
                foreach ($arProductsListResultAll as $key => $arProduct)
                {
                    $arProducts[] = ["PRODUCT_ID" => $arProduct['ID'], "PRICE" => $arProduct['PRICE'], "QUANTITY" => $arProduct['QUANTITY'], "PRODUCT_NAME" => $arProduct['NAME']];
                }
                ?><pre>add products ? $arProducts<?=print_r($arProducts, 1)?></pre><?
                // file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arProducts, true), FILE_APPEND);
                $arDealRowsAddParams = ["id" => $arDealResult['result'], "rows" => $arProducts];
                while (1)
                {
                    Bitrix\Main\Diag\Debug::writeToFile($arDealRowsAddParams , "order (2) " , '/debug_b24.txt');
                    // Додаємо товари в замовлення
                    $arDealRowsAddResult = call("crm.deal.productrows.set", $arDealRowsAddParams, true);
                    if ($arDealRowsAddResult['STATUS'] == 200)
                        break;
                }
                // добавление товаров в созданную сделку end
                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealRowsAddResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealRowsAddResult.txt', print_r($arDealRowsAddResult, true), FILE_APPEND);
            }
        }
    }
    // Создание сделки end
    // Создание контакта и сделки end
    // Создание лида за коментировал потому что по оновой схеме для всех новых клиентов(которые не зарегестнрировались на сайте) при оформлении заказа в Б24 создается контакт и сделка
    // поиск лида start
}

$DB -> Query('INSERT INTO b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) values 
                                                                                                         (
                                                                                                          \''.$orderID.'\',
                                                                                                          \'0\',
                                                                                                          \'Вигрузка в Б24\',
                                                                                                          \'1\',
                                                                                                          \'UPLOAD_B24\',
                                                                                                          \''.$orderID.'\',
                                                                                                          \'ORDER\'
                                                                                                         )');