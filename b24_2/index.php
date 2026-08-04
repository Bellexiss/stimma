<?php
mail('company703@gmail.com', 'stimma from b24_2 index.php', 'stimma from b24_2 index.php');
require("include/config.php");
$json = file_get_contents('php://input');
if (isset($json))
{
    $arJSON        = (array)json_decode($json);
    $arLog         = [];
    $arLog['json'] = $arJSON;
    if ($arJSON['type'] != 'update_products')
    {
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/arJSON.txt', print_r($arJSON, true), FILE_APPEND);
    }
    if ($arJSON['type'] == 'order')
    {
        if (!empty($arJSON['line_items']))
        {
            // массив товаров start
            $arProducts              = [];
            $arOrderProductsAll      = [];
            $arProductsListResultAll = [];
            foreach ($arJSON['line_items'] as $obProduct)
            {
                if ((string)$obProduct -> variation_id > 0)
                {
                    $arOrderProductsAll[] = (string)$obProduct -> variation_id;
                }
                else
                {
                    $arOrderProductsAll[] = (string)$obProduct -> product_id;
                }
            }
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
                    foreach ($arJSON['line_items'] as $obProduct)
                    {
                        $id = ((string)$obProduct -> variation_id > 0) ? (string)$obProduct -> variation_id : (string)$obProduct -> product_id;
                        if ($arProductB24['PROPERTY_104']['value'] == $id)
                        {
                            $arProductListResult['result'][$key]['QUANTITY'] = (string)$obProduct -> quantity;
                            $arProductListResult['result'][$key]['NAME']     = (string)$obProduct -> name;
                            if ($arProductB24['PRICE'] != (string)$obProduct -> total)
                            {
                                $arProductListResult['result'][$key]['PRICE'] = (string)$obProduct -> total / (string)$obProduct -> quantity;
                            }
                        }
                    }
                }
                $arProductsListResultAll = array_merge($arProductsListResultAll, $arProductListResult['result']);
            }
            // массив товаров end
            // поиск контакта start
            if ($arJSON['customer_id'] > 0)
            {
                $arFilter = ["UF_CRM_1521453922" => $arJSON['customer_id']];
            }
            else
            {
                $arFilter = (string)$arJSON['billing'] -> email ? ["EMAIL" => (string)$arJSON['billing'] -> email] : ["PHONE" => (string)$arJSON['billing'] -> phone];
            }
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
            if (count($arContactsResult['result']) > 0)
            {
                // поиск сделки start
                $arFieldsDealsList = ["order" => ["ID" => "ASC"], "filter" => ["UF_CRM_1523544904" => $arJSON['id']], "select" => ["ID", "NAME", "UF_CRM_1523544904"]];
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
                    $arDealParams = ["fields" => ["CATEGORY_ID" => $arContactsResult['result'][0]["TYPE_ID"] ? $arClientDealCategory[$arContactsResult['result'][0]["TYPE_ID"]] : 0, "TITLE" => "Замовлення № " . $arJSON['id'], "TYPE_ID" => "SALE", // "STAGE_ID" => "NEW",
                                                  "STAGE_ID"    => $arContactsResult['result'][0]["TYPE_ID"] ? $arClientDealSatus[$arContactsResult['result'][0]["TYPE_ID"]] : "NEW", "CONTACT_ID" => $arContactsResult['result'][0]['ID'], "OPENED" => "Y", "ASSIGNED_BY_ID" => $arContactsResult['result'][0]['ASSIGNED_BY_ID'], "CURRENCY_ID" => $arJSON['currency'], "OPPORTUNITY" => $arJSON['total'], "BEGINDATE" => date_format(date_create($arJSON['date_created']), 'd.m.Y'), "UF_CRM_1523544904" => $arJSON['id'], // ID замовлення на сайтi
                                                  "COMMENTS"    => $arJSON['order_comments'] // комментарий
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
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arProducts, true), FILE_APPEND);
                        $arDealRowsAddParams = ["id" => $arDealResult['result'], "rows" => $arProducts,];
                        while (1)
                        {
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
                // Создание контакта и сделки start
                $newManagerID   = 114; // ответственный  менеджер Настя Морозецька - роздріб - ID 114
                $contact_result = ['result' => false];
                //Создание контакта start
                $phone_tmp          = preg_replace('~[^0-9]+~', '', $arJSON['billing'] -> phone);
                $phone              = [["VALUE" => $phone_tmp, "VALUE_TYPE" => "WORK"]];
                $arFieldsContactAdd = ["fields" => ["OPENED"            => 'Y', "EXPORT" => 'Y', "TYPE_ID" => 'CLIENT', // категория клиента (оптовик, розничный покупатель)
                                                    "SOURCE_ID"         => "WEB", "NAME" => $arJSON['billing'] -> first_name, // Имя
                                                    "LAST_NAME"         => $arJSON['billing'] -> last_name, // Фамилия
                                                    "PHONE"             => $phone, // Телефон
                                                    "EMAIL"             => [["VALUE" => $arJSON['billing'] -> email, "VALUE_TYPE" => "WORK"]], // Email
                                                    "UF_CRM_1521453922" => 0, //$arJSON['user_id'], // ID на сайте
                                                    "ASSIGNED_BY_ID"    => $newManagerID, // ответственный
                ]];
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
                    $arFieldsDealsList = ["order" => ["ID" => "ASC"], "filter" => ["UF_CRM_1523544904" => $arJSON['id']], "select" => ["ID", "NAME", "UF_CRM_1523544904"]];
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
                        $arDealParams = ["fields" => ["CATEGORY_ID" => $arClientDealCategory["CLIENT"], "TITLE" => "Замовлення № " . $arJSON['id'], "TYPE_ID" => "SALE", "STAGE_ID" => "NEW", "CONTACT_ID" => $contact_result['result'], "OPENED" => "Y", "ASSIGNED_BY_ID" => $newManagerID, "CURRENCY_ID" => $arJSON['currency'], "OPPORTUNITY" => $arJSON['total'], "BEGINDATE" => date_format(date_create($arJSON['date_created']), 'd.m.Y'), "UF_CRM_1523544904" => $arJSON['id'], // ID замовлення на сайтi
                                                      "COMMENTS"    => $arJSON['order_comments'] // комментарий
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
                            // file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arProducts, true), FILE_APPEND);
                            $arDealRowsAddParams = ["id" => $arDealResult['result'], "rows" => $arProducts,];
                            while (1)
                            {
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
                /*
                    $arFieldsLeadsList = array(
                        "order" => array("ID" => "ASC"),
                        "filter" => array("UF_CRM_1523563473" => $arJSON['id']),
                        "select" => array("ID", "TITLE", "UF_CRM_1523563473")
                    );
                    while (1) {
                        $arLeadListResult = call("crm.lead.list", $arFieldsLeadsList, true);
                        if ($arLeadListResult['STATUS'] == 200) break; 
                    }
                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arLeadListResult.txt', print_r($arLeadListResult, true), FILE_APPEND);
                    // поиск лида end

                    if(empty($arLeadListResult['result'])) {
                        // создание нового лида start
                        $title = (string)$arJSON['billing']->first_name ? (string)$arJSON['billing']->first_name.' '.(string)$arJSON['billing']->last_name : (string)$arJSON['billing']->email;
                        $phones = preg_replace('~[^0-9,]+~','',(string)$arJSON['billing']->phone);
                        $arPhones = explode(',',$phones);
                        if(count($arPhones) == 1){
                            $phone = array(array("VALUE" => $arPhones[0], "VALUE_TYPE" => "WORK"));
                        }elseif(count($arPhones) == 2){
                            $phone = array(array("VALUE" => $arPhones[0], "VALUE_TYPE" => "WORK"), array("VALUE" => $arPhones[1], "VALUE_TYPE" => "MOBILE"));
                        }
                        $arLeadParams = array(
                            "fields" => array(
                                "TITLE" => $title, 
                                "NAME" => (string)$arJSON['billing']->first_name, 
                                "LAST_NAME" => (string)$arJSON['billing']->last_name, 
                                "STATUS_ID" => "NEW",
                                "SOURCE_ID" => "WEB",
                                "OPENED" => "Y", 
                                "ASSIGNED_BY_ID" => 114, // менеджер Аліна Кондратюк - роздріб - ID 114
                                // "ASSIGNED_BY_ID" => $new_id, 
                                "CURRENCY_ID" => $arJSON['currency'], 
                                "OPPORTUNITY" => $arJSON['total'],
                                "PHONE" => $phone,
                                "EMAIL" => array(array("VALUE" => (string)$arJSON['billing']->email, "VALUE_TYPE" => "WORK")),
                                "UF_CRM_1523003556" => $arJSON['customer_id'], // ID
                                "UF_CRM_1523003410" => (string)$arJSON['billing']->address_2, // Адреса доставки
                                "UF_CRM_1523003447" => (string)$arJSON['billing']->address_1, // Компанія перевізник
                                "UF_CRM_1523003466" => (string)$arJSON['billing']->city, // місто
                                "UF_CRM_1523003480" => (string)$arJSON['billing']->state, // область
                                "UF_CRM_1523003488" => (string)$arJSON['billing']->postcode, // поштовий індекс
                                "UF_CRM_1523563473" => $arJSON['id'], // ID замовлення на сайті
                                "COMMENTS" => $arJSON['order_comments'] // комментарий
                            ),
                            "params" => array("REGISTER_SONET_EVENT" => "Y")
                        );
                        while (1) {
                            $arLeadResult = call("crm.lead.add", $arLeadParams, true);
                            if ($arLeadResult['STATUS'] == 200) break; 
                        }
                        // создание нового лида end
                        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arLeadResult.txt', print_r($arJSON['id']." - ".$arLeadResult['STATUS']."\n", true), FILE_APPEND);
                        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arLeadResult.txt', print_r($arLeadResult['result']."\n", true), FILE_APPEND);

                        if ($arLeadResult['result'] > 0) {
                            // добавление товаров к лиду start 
                            foreach ($arProductsListResultAll as $key => $arProduct) {
                                $arProducts[] = array("PRODUCT_ID" => $arProduct['ID'], "PRICE" => $arProduct['PRICE'], "QUANTITY" => $arProduct['QUANTITY'], "PRODUCT_NAME" => $arProduct['NAME']);
                            }        
                            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arProducts, true), FILE_APPEND);
                            $arLeadRowsAddParams = array(
                                "id" => $arLeadResult['result'], 
                                "rows" => $arProducts,
                            );
                            while (1) {
                                $arLeadRowsAddResult = call("crm.lead.productrows.set", $arLeadRowsAddParams, true);
                                if ($arLeadRowsAddResult['STATUS'] == 200) break; 
                            }
                            // добавление товаров к лиду end
                            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arLeadRowsAddResult.txt', print_r($arJSON['id'], true), FILE_APPEND);
                            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arLeadRowsAddResult.txt', print_r($arLeadRowsAddResult, true), FILE_APPEND);

                            // ---
                                // Массив соответствия тип клиента/направление сделки
                                $arClientDealCategory = [
                                    "CLIENT" => 0,      // Розничный покупатель
                                    "SUPPLIER" => 2,    // Дропшипер
                                    1 => 4,             // Оптовый покупатель
                                ];

                                // Массив соответствия тип клиента/статус сделки
                                $arClientDealSatus = [
                                    "CLIENT" => "NEW",      // Розничный покупатель
                                    "SUPPLIER" => "C2:NEW",    // Дропшипер
                                    1 => "C4:NEW",             // Оптовый покупатель
                                ];

                                $newManagerID = 114;// ответственный  менеджер Настя Морозецька - роздріб - ID 114
                                // создание сделки существующего контакта start
                                $arDealParams = array(
                                    "fields" => array(
                                        "CATEGORY_ID" =>  0, 
                                        "TITLE" => "Замовлення № ".$arJSON['id'], 
                                        "TYPE_ID" => "SALE", 
                                        "STAGE_ID" => "NEW",
                                        "LEAD_ID" => $arLeadResult['result'],
                                        "OPENED" => "Y", 
                                        "ASSIGNED_BY_ID" => $newManagerID, 
                                        "CURRENCY_ID" => $arJSON['currency'], 
                                        "OPPORTUNITY" => $arJSON['total'],
                                        "BEGINDATE" => date_format(date_create($arJSON['date_created']), 'd.m.Y'),
                                        "UF_CRM_1523544904" => $arJSON['id'], // ID замовлення на сайтi 
                                        "COMMENTS" => $arJSON['order_comments'] // комментарий
                                    )
                                );
                                while(1){
                                    $arDealResult = call("crm.deal.add", $arDealParams, true);
                                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/dealsAddLog.txt', print_r($arDealResult, true).PHP_EOL, FILE_APPEND);
                                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/dealsAddLog.txt', print_r($arDealParams, true).PHP_EOL, FILE_APPEND);
                                    if ($arDealResult['STATUS'] == 200) break;
                                }

                                if ($arDealResult['result'] > 0) {
                                    // добавление товаров в созданную сделку start 
                                    $arDealRowsAddParams = array(
                                        "id" => $arDealResult['result'], 
                                        "rows" => $arProducts,
                                    );
                                    while (1) {
                                        $arDealRowsAddResult = call("crm.deal.productrows.set", $arDealRowsAddParams, true);
                                        if ($arDealRowsAddResult['STATUS'] == 200) break;
                                    }
                                    // добавление товаров в созданную сделку end
                                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealRowsAddResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealRowsAddResult.txt', print_r($arDealRowsAddResult, true), FILE_APPEND);
                                }

                            //---

                        }
                    } */
            }
        }
    }
    elseif ($arJSON['type'] == 'update_products')
    {
        // поиск товара в Б24 start
        $arFieldsProductList = ["order" => ['ID' => 'ASC'], "filter" => ['PROPERTY_104' => $arJSON['id']], "select" => ['ID', 'NAME', 'PRICE', 'PROPERTY_*']];
        while (1)
        {
            $arProductListResult = call("crm.product.list", $arFieldsProductList, true);
            if ($arProductListResult['STATUS'] == 200)
                break;
        }
        // поиск товара в Б24 end
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/update_products/arProductListResult.txt', print_r($arJSON['id'], true), FILE_APPEND);
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/update_products/arProductListResult.txt', print_r($arProductListResult, true), FILE_APPEND);
        if (empty($arProductListResult['result']))
        {
            // добавление нового товара start
            $arFieldsProductAdd = ["fields" => ["NAME"         => $arJSON['name'], "CURRENCY_ID" => "UAH", "PRICE" => $arJSON['price'], "PROPERTY_100" => (string)$arJSON['attributes'] -> pa_cvet, // цвет
                                                "PROPERTY_102" => (string)$arJSON['attributes'] -> pa_razmer, // размер
                                                "PROPERTY_104" => $arJSON['id'], // id на сайте
                                                "PROPERTY_106" => (string)$arJSON['attributes'] -> pa_material, // материал
                                                "MEASURE"      => 9]];
            while (1)
            {
                $arProductAddResult = call("crm.product.add", $arFieldsProductAdd, true);
                if ($arProductAddResult['STATUS'] == 200)
                    break;
            }
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/update_products/arProductAddResult.txt', print_r($arJSON['id']." - ".$arProductAddResult['STATUS']."\n", true), FILE_APPEND);
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/update_products/arProductAddResult.txt', print_r($arProductAddResult, true), FILE_APPEND);
            echo "Добавлен товар с ID: " . $arProductAddResult['result'];
            // добавление нового товара end
        }
        else
        {
            // обновление существующего товара start
            $arFieldsProductUpdate = ["id" => $arProductListResult['result'][0]['ID'], "fields" => ["NAME"         => (string)$arJSON['name'], "CURRENCY_ID" => "UAH", "PRICE" => (string)$arJSON['price'], "PROPERTY_100" => (string)$arJSON['attributes'] -> pa_cvet, // цвет
                                                                                                    "PROPERTY_102" => (string)$arJSON['attributes'] -> pa_razmer, // размер
                                                                                                    "PROPERTY_104" => $arJSON['id'], // id на сайте
                                                                                                    "PROPERTY_106" => (string)$arJSON['attributes'] -> pa_material, // материал
                                                                                                    "MEASURE"      => 9]];
            while (1)
            {
                $arProductUpdateResult = call("crm.product.update", $arFieldsProductUpdate, true);
                if ($arProductUpdateResult['STATUS'] == 200)
                    break;
            }
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/update_products/arProductUpdateResult.txt', print_r($arJSON['id']." - ".$arProductUpdateResult['STATUS']."\n", true), FILE_APPEND);
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/update_products/arProductUpdateResult.txt', print_r($arProductUpdateResult, true), FILE_APPEND);
            echo "Товар обновлен";
            // обновление существующего товара end
        }
    }
    elseif ($arJSON['type'] == 'user_register')
    {
        if ($arJSON['user_type'] == 'opt')
        {
            //$arOptManagers = array(112, 12, 110, 122); // Віка Байда - 112, Крістіна Бексяк - 12, Анастейша Овсянюк - 110, Вікторія Байда - 122
            //обновил список менеджеров 
            //            $arOptManagers = array(112, 12, 130, 122, 678);// 112 Лєна Корнійчук, 130 Валентина Меланіч,  12 Крістіна Бексяк,  122 Вікторія Байда, 678 Вікторія Осмолян
            $arOptManagers           = [112, // Лена Корнійчук
                                        //12, // Крістіна Бексяк
                                        800, // Мирослава Величко
                                        928, // Елена Овчарук
                                        1974, //Владислава
                                        114, //НАСТЯ МОРОЗЕЦЬКА
            ]; // Новая очередь менеджеров
            $new_id                  = $arOptManagers[0];
            $role                    = '1';
            $name_role               = "Опт";
            $arFieldsContactsListNew = ["order" => ["DATE_CREATE" => "DESC"], "filter" => ["ASSIGNED_BY_ID" => $arOptManagers], "select" => ["ID", "ASSIGNED_BY_ID", "DATE_CREATE"]];
            while (1)
            {
                $arContactListResultNew = call("crm.contact.list", $arFieldsContactsListNew, true);
                if ($arContactListResultNew['STATUS'] == 200)
                    break;
            }
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/arContactListResultNew.txt', print_r($arContactListResultNew, true), FILE_APPEND);
            if (!empty($arContactListResultNew['result']))
            {
                foreach ($arOptManagers as $key => $id)
                {
                    if ($id == $arContactListResultNew['result'][0]['ASSIGNED_BY_ID'])
                    {
                        $new_id = (count($arOptManagers) - 1 != $key) ? $arOptManagers[$key + 1] : $arOptManagers[0];
                    }
                }
            }
        }
        elseif ($arJSON['user_type'] == 'supplier')
        {
            $new_id    = 116; // менеджер ОЛЕНА МОЛІНЧУК
            $role      = 'SUPPLIER';
            $name_role = "Дроп";
        }
        else
        {
            $new_id    = 724; // менеджер Аліна Кондратюк - роздріб - ID 114
            $role      = 'CLIENT';
            $name_role = "Роздріб";
        }
        $phone_tmp          = preg_replace('~[^0-9]+~', '', $arJSON['user_phone']);
        $phone              = [["VALUE" => $phone_tmp, "VALUE_TYPE" => "WORK"]];
        $arFieldsContactAdd = ["fields" => ["OPENED"            => 'Y', "EXPORT" => 'Y', "TYPE_ID" => $role, // категория клиента (оптовик, розничный покупатель)
                                            "SOURCE_ID"         => "WEB", "NAME" => $arJSON['user_firstname'], // Имя
                                            "LAST_NAME"         => $arJSON['user_lastname'], // Фамилия
                                            "PHONE"             => $phone, // Телефон
                                            "EMAIL"             => [["VALUE" => $arJSON['user_email'], "VALUE_TYPE" => "WORK"]], // Email
                                            "UF_CRM_1521453922" => $arJSON['user_id'], // ID на сайте
                                            "ASSIGNED_BY_ID"    => $new_id, // ответственный
        ]];
        /* Параметри Ліда при реєстрації */
        $title_lid    = "Реєстрація на сайті " . (string)$arJSON['user_firstname'] . " - " . $name_role;
        $arLeadParams = ["fields" => ["TITLE"          => $title_lid, "NAME" => $arJSON['user_firstname'], "LAST_NAME" => $arJSON['user_lastname'], "STATUS_ID" => "NEW", "SOURCE_ID" => "WEB", "OPENED" => "Y", // "ASSIGNED_BY_ID" =>  $role,
                                      "ASSIGNED_BY_ID" => $new_id, // "CURRENCY_ID" => $arJSON['currency'],
                                      // "OPPORTUNITY" => $arJSON['total'],
                                      "PHONE"          => $phone, "EMAIL" => [["VALUE" => $arJSON['user_email'], "VALUE_TYPE" => "WORK"]] // Email
        ], "params"               => ["REGISTER_SONET_EVENT" => "Y"]];
        /* -------- */
        while (1)
        {
            /* $contact_result = call("crm.contact.add", $arFieldsContactAdd, true);
            if ($contact_result['STATUS'] == 200) break; */
            /* Контакт при реєстрації не створюємо а створюємо Лід  */
            $arLeadResult = call("crm.lead.add", $arLeadParams, true);
            if ($arLeadResult['STATUS'] == 200)
                break;
        }
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/b24_2/mylog_' . strtotime(date('d.m.Y H:i:s')) . '.php', date('d.m.Y H:i:s') . '$log=' . var_export($arLog, 1) . '');
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/b24_2/server_' . strtotime(date('d.m.Y H:i:s')) . '.php', date('d.m.Y H:i:s') . '$server=' . var_export($_SERVER, 1) . '');
}

/* TEST */
/* $arFieldsContactAdd_test = array(
   "fields" => array(
       "OPENED" => 'Y',
       "EXPORT" => 'Y',
       "TYPE_ID" => 'CLIENT', // категория клиента (оптовик, розничный покупатель)
       "SOURCE_ID" => "WEB",
       "NAME" => "NAME_AVIVI2", // Имя
       "LAST_NAME" => "LAST_AVIVI", // Фамилия
       "PHONE" => "+3801111111111", // Телефон
       "EMAIL" => array(array("VALUE" => "test@test.ua", "VALUE_TYPE" => "WORK")), // Email
       "UF_CRM_1521453922" => 0,//$arJSON['user_id'], // ID на сайте
       "ASSIGNED_BY_ID" => 1 // ответственный
   )
);

$contact_result_demo = call("crm.contact.add", $arFieldsContactAdd_test, true);
                       if ($contact_result_demo) {
                           print_r($contact_result_demo);
                       };
*/
