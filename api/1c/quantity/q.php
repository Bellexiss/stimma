<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;
//api/1c/quantity/q.php
// обнулить кількість перед початком

// Путь к JSON-файлу
$products = $_SERVER["DOCUMENT_ROOT"] . "/api/1c/quantity/q.json";

// Проверка файла
if (!file_exists($products)) {

    Debug::writeToFile("File not found: $products", "file_error", '/log_1c/error_user_cards.txt');
    exit("JSON file not found");
}

$products = file_get_contents($products);
//$products = file_get_contents('php://input');
$products = json_decode($products);
//PR($products);
if(!empty($products))
{
    $DB->Query('update b_catalog_product set QUANTITY = 0');

    $articles = $updated = $updatedXmlId = [];
    foreach($products as $index => $product)
    {
        $article = $product->product;
        $quantity = $product->quantity;
        $xml_id = $product->xml_id;

        $articles[$article] = $article;
        $updated[$article] = $quantity;
        $updatedXmlId[$article] = $xml_id;
    }

    if(!empty($updated))
    {
        $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_ARTICLE' => $articles],false,false,['ID','IBLOCK_ID','PROPERTY_ARTICLE']);
        while ($record = $res->Fetch())
        {
            $articleValue = $record['PROPERTY_ARTICLE_VALUE'];
            if(isset($updated[$articleValue]))
            {
                if($updated[$articleValue] < 0) $updated[$articleValue] = 0;
                $quantityInt = intval($updated[$articleValue]);
                $xmlIdVal = $updatedXmlId[$articleValue];

                // Обновляем количество в b_catalog_product
                $DB->Query('update b_catalog_product set QUANTITY = ' . $quantityInt . ' where ID = ' . $record['ID']);

                // Обновляем XML_ID в b_iblock_element
                $DB->Query('update b_iblock_element set XML_ID = \'' . $DB->ForSql($xmlIdVal) . '\' where ID = ' . $record['ID']);

                unset($updated[$articleValue]);
                unset($updatedXmlId[$articleValue]);
            }
        }

        if(!empty($updated))
        {
            foreach($updated as $article => $quantity)
            {
                if($quantity < 0) $quantity = 0;
                $find = $DB->Query('select * from b_iblock_element where IBLOCK_ID = 25 and NAME like \'%'.$article.'%\'');
                if($find = $find->Fetch())
                {
                    $quantityInt = intval($quantity);
                    $xmlIdVal = isset($updatedXmlId[$article]) ? $updatedXmlId[$article] : '';

                    $DB->Query('update b_catalog_product set QUANTITY = ' . $quantityInt . ' where ID = ' . $find['ID']);
                    if($xmlIdVal !== '') {
                        $DB->Query('update b_iblock_element set XML_ID = \'' . $DB->ForSql($xmlIdVal) . '\' where ID = ' . $find['ID']);
                    }
                }
            }
        }
    }

    // дальше по твоему коду без изменений ...
    // Новинки
    $newRes = CIBlockElement::GetList([],['IBLOCK_ID'=>21,'ACTIVE'=>'Y','SECTION_ID'=>350]);
    $new = [];
    while ($record = $newRes->Fetch())
    {
        $new[$record['ID']] = $record['ID'];
        $newTpRes = CIBlockElement::GetList([],['IBLOCK_ID'=>25,'ACTIVE'=>'Y','PROPERTY_CML2_LINK'=>$record['ID']]);
        while ($tp = $newTpRes->Fetch())
        {
            $DB->Query('update b_catalog_product set QUANTITY = 1000 where ID = ' . $tp['ID']);
        }
    }

    // Сертифікати
    $newRes = CIBlockElement::GetList([],['IBLOCK_ID'=>21,'ACTIVE'=>'Y','SECTION_ID'=>510]);
    $new = [];
    while ($record = $newRes->Fetch())
    {
        $new[$record['ID']] = $record['ID'];
        $newTpRes = CIBlockElement::GetList([],['IBLOCK_ID'=>25,'ACTIVE'=>'Y','PROPERTY_CML2_LINK'=>$record['ID']]);
        while ($tp = $newTpRes->Fetch())
        {
            $DB->Query('update b_catalog_product set QUANTITY = 1000 where ID = ' . $tp['ID']);
        }
    }
}
