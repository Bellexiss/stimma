<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $DB;
$order_id = 47375;

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