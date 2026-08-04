<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

// обнулить кількість перед початком

$products = file_get_contents('php://input');
$products = json_decode($products);


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
                if($updated[$record['PROPERTY_ARTICLE_VALUE']] < 0) $updated[$record['PROPERTY_ARTICLE_VALUE']] = 0;
                $DB->Query('update b_catalog_product set QUANTITY = ' . intval($updated[$record['PROPERTY_ARTICLE_VALUE']]) . ' where ID = ' . $record['ID']);
                unset($updated[$record['PROPERTY_ARTICLE_VALUE']]);
            }
        }

        if(!empty($updated))
        {
            foreach($updated as $article => $quantity)
            {
                if($quantity < 0) $quantity = 0;
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

