<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*if($arResult['ITEMS'])
{
    $sections = [];
	foreach($arResult['ITEMS'] as $key => $arItem)
        if($arItem['IBLOCK_SECTION_ID'])$sections[$arItem['IBLOCK_SECTION_ID']] = $arItem['IBLOCK_SECTION_ID'];

    if(!empty($sections))
    {
        $res = CIBlockSection::GetList([], ['IBLOCK_ID' => 35, 'ID' => $sections], false, ['ID','IBLOCK_ID', 'UF_*']);
        while ($record = $res -> Fetch())
            $sections[$record['ID']] = $record['UF_PRODUCT'];
    }
    */?><!--<pre><?/*=print_r($sections, 1)*/?></pre>--><?/*

	foreach($arResult['ITEMS'] as $key => $arItem)
    {
        $product = $arItem['PROPERTIES']['PRODUCT']['VALUE'];

        if(!$product) {unset($arResult['ITEMS'][$key]);continue;}
        $product = CCatalogProduct::GetByID($product);
        $element = CIBlockElement::GetList([], ['IBLOCK_ID' => 35, 'ID' => $product, 'ACTIVE' => 'Y'])->GetNextElement();

        if(!$element) {unset($arResult['ITEMS'][$key]);continue;}

        $fields = $element->GetFields();
        $props = $element->GetProperties();

        $discountPrice = CPrice::GetList([], ['PRODUCT_ID' => $product, 'CATALOG_GROUP_ID' => 3]) -> Fetch();
        $basePrice = CPrice::GetList([], ['PRODUCT_ID' => $product, 'CATALOG_GROUP_ID' => 2]) -> Fetch();
        if (!$basePrice && $discountPrice) $basePrice = $discountPrice;
        if (!$basePrice)
            $basePrice=$price=$discountPrice = CCatalogProduct::GetOptimalPrice($product)['RESULT_PRICE'];

        $product['DISCOUNT_PRICE'] = $discountPrice;
        $product['BASE_PRICE'] = $basePrice;

        $arResult['ITEMS'][$key]['PRODUCT'] = $product;
        $arResult['ITEMS'][$key]['ELEMENT'] = $fields;
        $arResult['ITEMS'][$key]['ELEMENT']['PROPERTIES'] = $props;
	}
}*/

?>