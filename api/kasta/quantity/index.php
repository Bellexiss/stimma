<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

// обнулить кількість перед початком



$products = file_get_contents('php://input');
$products = json_decode($products);
Bitrix\Main\Diag\Debug::writeToFile((array)$products, "start get order " , '/log_1c/___kasta_quantity.txt');

/*$iblockId = 25;
$strSql = "SELECT ID FROM b_iblock_element WHERE IBLOCK_ID = $iblockId AND ACTIVE = 'Y'";
$res = $DB->Query($strSql);
while ($arItem = $res->Fetch()) {
    CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, [
        "KASTA_QUNATITY" => 0
    ]);
}*/
$arFilter = [
    "IBLOCK_ID" => 25,
    "ACTIVE" => "Y"
];
$arSelect = ["ID"];

$res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
while ($arItem = $res->Fetch()) {
    CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, [
        "KASTA_QUNATITY" => 0
    ]);
}

foreach ($products as $productObj) {
    $productCode = trim($productObj->product);
    $quantity = intval($productObj->quantity);

    // Ищем торговое предложение по части названия
    $arFilter = [
        "IBLOCK_ID" => 25,
        "ACTIVE" => "Y",
        "%NAME" => $productCode
    ];

    $arSelect = ["ID", "NAME"];
    $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);

    while ($arItem = $res->Fetch()) {
        // Обновляем свойство
        CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, [
            "KASTA_QUNATITY" => $quantity
        ]);

        // Логируем успех
        Bitrix\Main\Diag\Debug::writeToFile([
            'ID' => $arItem['ID'],
            'SEARCH_PRODUCT' => $productCode,
            'NAME' => $arItem['NAME'],
            'NEW_QUANTITY' => $quantity
        ], "Updated item", '/log_1c/__update_kasta_quantity.txt');
    }
}

die('2');
if(!empty($products))
{
    $DB->Query('update b_catalog_product set QUANTITY = 0');

    $articles = $updated = [];
    foreach($products as $index => $product)
    {
        $article = $product->product;
        $quantity = $product->quantity;

        $articles[$article] = $article;
        $updated[$article] = $quantity;
    }

    if(!empty($updated))
    {
        $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_ARTICLE' => $articles],false,false,['ID','IBLOCK_ID','PROPERTY_ARTICLE']);
        while ($record = $res->Fetch())
        {
            if(isset($updated[$record['PROPERTY_ARTICLE_VALUE']]))
            {
                $DB->Query('update b_catalog_product set QUANTITY = ' . intval($updated[$record['PROPERTY_ARTICLE_VALUE']]) . ' where ID = ' . $record['ID']);
                unset($updated[$record['PROPERTY_ARTICLE_VALUE']]);
            }
        }

        if(!empty($updated))
        {
            foreach($updated as $article => $quantity)
            {
                $find = $DB->Query('select * from b_iblock_element where IBLOCK_ID = 25 and NAME like \'%'.$article.'%\'');
                if($find = $find->Fetch())
                    $DB->Query('update b_catalog_product set QUANTITY = ' . intval($quantity) . ' where ID = ' . $find['ID']);
            }
        }
    }

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

    /*// Bestsellers
    $newRes = CIBlockElement::GetList([],['IBLOCK_ID'=>21,'ACTIVE'=>'Y','SECTION_ID'=>351]);
    $new = [];
    while ($record = $newRes->Fetch())
    {
        $new[$record['ID']] = $record['ID'];
        $newTpRes = CIBlockElement::GetList([],['IBLOCK_ID'=>25,'ACTIVE'=>'Y','PROPERTY_CML2_LINK'=>$record['ID']]);
        while ($tp = $newTpRes->Fetch())
        {
            $DB->Query('update b_catalog_product set QUANTITY = 1000 where ID = ' . $tp['ID']);
        }
    }*/

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

