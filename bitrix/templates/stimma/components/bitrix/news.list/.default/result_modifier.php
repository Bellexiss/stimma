<?
$banenrs = [];
//$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y']);
//while ($record = $res -> Fetch())

foreach ($arResult['ITEMS'] as $index => $arItem)
{
    $banenrs[$arItem['IBLOCK_SECTION_ID']][$arItem['ID']] = $arItem;

}

$desctop = 0;
$mobile = $desctop ? 0 : 1;

$arResult['BANNERS'] = $banenrs;
