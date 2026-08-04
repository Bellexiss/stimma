<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $DB;
// ЗАКОМЕНТИВ
$usdRate = COption::GetOptionString("my_module", "usd_rate",'41.7');
//$res = $DB->Query('select * from payments where UF_FACEBOOK != 1 limit 1');
//while ($record = $res->Fetch())
{
    // 44686
    $startOrder = 44770;
    $endOrder = 44780;

    global $APPLICATION;
    //$orderId = $record['UF_ORDER_ID'];
    //for ($i=44159; $i<=44203; $i++)
    {
        $orderId = isset($_GET['order']) ? $_GET['order'] : $startOrder;
        $Order = $DB->Query('select * from b_sale_order where ID = ' . $orderId)->Fetch();

        $res = $DB -> Query('select * from b_sale_basket where ORDER_ID = ' . $orderId);
        $productJson = [];
        $minus_price=$bonus=0;
        while ($record2 = $res -> Fetch())
        {


            {
                $product = $record2['PRODUCT_ID'];
                $withStims =$DB->Query('select * from basket_stims where UF_ID = '.$product);
                if($withStims=$withStims->Fetch())
                {
                    $bonus += ($withStims['UF_STIMS']*$record2['QUANTITY']);
                    $minus_price += ($record2['PRICE']*$record2['QUANTITY']);
                    $record2['STIMS'] = $withStims['UF_STIMS']*$record2['QUANTITY'];
                }

                $basket[] = $record2;

                $product = CIBlockElement::GetByID($product)->Fetch();
                $res2 = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $product['IBLOCK_SECTION_ID']], false, ['ID','IBLOCK_ID','NAME','UF_*']) -> Fetch();
                $sectionName = LANGUAGE_ID == 'ua' ? $res2['UF_NAME_UA'] : $res2['NAME'];

                if(LANGUAGE_ID == 'ua')
                    $itemName = CIBlockElement::GetProperty(25, $record2['PRODUCT_ID'],'sort', 'asc', array('CODE' => 'NAME_UA')) -> Fetch()['VALUE'];
                else
                    $itemName = $record2['NAME'];

                $mainPID = CIBlockElement::GetProperty(25, $record2['PRODUCT_ID'],'sort', 'asc', array('CODE' => 'CML2_LINK')) -> Fetch()['VALUE'];
                $mainFields = CIBlockElement::GetByID($mainPID)->Fetch();

                if(LANGUAGE_ID == 'ua')
                {
                    $mainFields['NAME'] = CIBlockElement::GetProperty(21, $mainPID,'sort', 'asc', array('CODE' => 'NAME_UA')) -> Fetch()['VALUE'];
                }

                $productJson[] = "
                {
                    'name': '".addslashes($mainFields['NAME'])."',
                    'id': '".$mainPID."',
                    'baseId': '".$mainPID."',
                    'price': '".$record2['PRICE']."',
                    'brand': 'STIMMA',
                    'category': '".addslashes($sectionName)."',
                    'quantity': ".$record2['QUANTITY']."
                }
                ";
                $productJson2[] = "
                {
                    item_id: '".$mainPID."',
                    item_name: '".addslashes($mainFields['NAME'])."',
                    affiliation: 'STIMMA',
                    discount: ".($record2['BASE_PRICE']-$record2['PRICE']).", 
                    index: 1, 
                    item_brand: 'STIMMA', 
                    item_category: '".addslashes($sectionName)."',
                    item_list_id:'".$mainPID."',
                    item_list_name: '".addslashes($itemName)."',
                    price: ".$record2['BASE_PRICE'].", // Ціна товару без знижки.
                    quantity: ".$record2['QUANTITY']." 
                }
                ";
            }
        }
        ?>

        <script>
            dataLayer.push({ ecommerce: null });
            dataLayer.push({
                event: "purchase",
                ecommerce: {
                    transaction_id: "<?=$orderId?>", // id замовлення. Унікальне для кожного замовлення
                    value: <?=$Order['PRICE']?>,
                    currency: "UAH",
                    items: [
                        <?=implode(',',$productJson2)?>
                    ]
                }
            });

            console.log({
                event: "purchase",
                ecommerce: {
                    transaction_id: "<?=$orderId?>", // id замовлення. Унікальне для кожного замовлення
                    value: <?=$Order['PRICE']?>,
                    currency: "UAH",
                    items: [
                        <?=implode(',',$productJson2)?>
                    ]
                }
            });

        </script>
        <?
        sleep(1);

        if($orderId == $endOrder)
            die('end');
        $orderId++;

        ?>
        <script>
            setTimeout(function(){
                location.href='/test/ga4.php?order='+<?=$orderId?>;
            }, 100);
        </script>
        <?
    }

}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>
