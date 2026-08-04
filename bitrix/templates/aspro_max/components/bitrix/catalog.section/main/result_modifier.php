<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arDefaultParams = array(
	'TYPE_SKU' => 'N',
	'FILTER_HIT_PROP' => 'block',
	'OFFER_TREE_PROPS' => array('-'),
);

$skipOffer = true;
foreach($arResult['ITEMS'] as $index => $arItem)
{
    foreach($arItem['OFFERS'] as $indexs => $arOffer)
    {
        if(!$arOffer['CATALOG_QUANTITY'])
        {
            unset($arResult['ITEMS'][$index]['OFFERS'][$indexs]);
        }
    }
    $arResult['ITEMS'][$index]['OFFERS'] = array_values($arResult['ITEMS'][$index]['OFFERS']);


    if(!$arOffer['CATALOG_QUANTITY'])
        $arResult['OFFERS'][$index]['skip'] = 1;
    else
    {
        if($selOffer === false) $selOffer = $index;
        $skipOffer = false;
    }
}

$arResult['SKIP_OFFERS'] = $skipOffer;
$arParams = array_merge($arDefaultParams, $arParams);

$isNew = $arParams['IS_NEW'];

$alLColors = $alLColorsIDs = $alLMainColors = [];
$res = $DB -> Query('select * from max_color_reference');
while ($record = $res -> Fetch())
{
    $alLColors[$record['UF_XML_ID']] = $record['UF_COLOR_CODE'];
    $alLColorsIDs[$record['ID']] = $record['UF_COLOR_CODE'];
}
$arResult['ALL_COLORS'] = $alLColors;

$res = $DB -> Query('select * from main_colors');
while ($record = $res -> Fetch())
{
    $record['UF_COLORS'] = unserialize($record['UF_COLORS'], ['allowed_classes' => false]);
    $alLMainColors[$record['UF_XML_ID']] = $record['UF_CODE_COLOR'];
}
$arResult['ALL_MAIN_COLORS'] = $alLMainColors;

$colorVariants = $noId = $Ids = $json = [];

if(LANGUAGE_ID == 'ua')
{
    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/uf_values.php'))
        require $_SERVER['DOCUMENT_ROOT'].'/upload/uf_values.php';
    foreach ($arResult['ITEMS'] as $index => $arItem)
    {
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['color'] = $arItem['PROPERTIES']['COLOR']['VALUE'];
        $noId[$arItem['ID']] = $arItem['ID'];
        $Ids[$arItem['ID']] = $arItem['NAME'];

        if($arItem['PROPERTIES']['NAME_UA']['VALUE']) $arResult['ITEMS'][$index]['NAME'] = $arItem['PROPERTIES']['NAME_UA']['VALUE'];
        if($arItem['PROPERTIES']['NAME_UA']['VALUE']) $arResult['ITEMS'][$index]['~NAME'] = $arItem['PROPERTIES']['NAME_UA']['VALUE'];
        if($arItem['PROPERTIES']['DETAIL_TEXT_UA']['VALUE']['TEXT']) $arResult['ITEMS'][$index]['DETAIL_TEXT'] = $arItem['PROPERTIES']['DETAIL_TEXT_UA']['VALUE']['TEXT'];
        foreach ($arItem['PROPERTIES'] as $indexProp => $arItemProp)
        {
            if(isset($arItemProp['VALUE_XML_ID'])|| $arItemProp['CODE'] == 'COLOR_REF')
            {
                $result = changeValue($arItemProp['IBLOCK_ID'], $arItemProp["CODE"], $arItemProp['VALUE_XML_ID'], $values_ua);
                if($result['values'] && $result['name'])
                {
                    $arResult['ITEMS'][$index]['PROPERTIES'][$indexProp]['VALUE'] = $result['values'];
                    $arResult['ITEMS'][$index]['PROPERTIES'][$indexProp]['NAME'] = $result['name'];
                }

            }
        }
        foreach ($arItem['OFFERS'] as $indexOffer => $offer)
        {
            foreach ($offer['PROPERTIES'] as $indexProp => $arItemProp)
            {
                if(isset($arItemProp['VALUE_XML_ID']) || $arItemProp['CODE'] == 'COLOR_REF')
                {
                    $result = changeValue($arItemProp['IBLOCK_ID'], $arItemProp["CODE"], $arItemProp['VALUE_XML_ID'], $values_ua);
                    if($result['values'] && $result['name'])
                    {
                        $arResult['ITEMS'][$index]['OFFERS'][$indexOffer]['PROPERTIES'][$indexProp]['VALUE'] = $result['values'];
                        $arResult['ITEMS'][$index]['OFFERS'][$indexOffer]['PROPERTIES'][$indexProp]['NAME'] = $result['name'];
                    }

                }
            }
        }

        $item = $arItem['OFFERS'][0];
        $img = $item['DETAIL_PICTURE']['ID'];

        if(!$img)
            $img = $item['PREVIEW_PICTURE'];

        if(!$img)
            $img = $arItem['DETAIL_PICTURE'];
        if(!$img)
            $img = $arItem['PREVIEW_PICTURE'];

        $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $minPrice = $item['MIN_PRICE'];

        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['img'] = $img;
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['price'] = $minPrice;
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['code'] = $arItem['CODE'];
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['name'] = $arItem['NAME'];
    }
}
else
{
    foreach ($arResult['ITEMS'] as $index => $arItem)
    {
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['color'] = $arItem['PROPERTIES']['COLOR']['VALUE'];
        $noId[$arItem['ID']] = $arItem['ID'];
        $Ids[$arItem['ID']] = $arItem['NAME'];

        $item = $arItem['OFFERS'][0];
        $img = $item['DETAIL_PICTURE']['ID'];

        if(!$img)
            $img = $item['PREVIEW_PICTURE'];

        if(!$img)
            $img = $arItem['DETAIL_PICTURE'];
        if(!$img)
            $img = $arItem['PREVIEW_PICTURE'];

        $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $minPrice = $item['MIN_PRICE'];

        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['img'] = $img;
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['price'] = $minPrice;
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['code'] = $arItem['CODE'];
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['name'] = $arItem['NAME'];
    }
}

if (!empty($colorVariants))
{
    $filter = ['IBLOCK_ID' => 21, 'NAME' => array_keys($colorVariants), "!ID" => $noId,'ACTIVE' => 'Y'];
    $res = CIBlockElement::GetList([], $filter, false, false, ['ID','IBLOCK_ID','PROPERTY_COLOR','NAME','PREVIEW_PICTURE','DETAIL_PICTURE','CODE']);
    while ($record = $res -> Fetch())
    {
        $colorVariants[$record['NAME']][$record['PROPERTY_COLOR_VALUE']]['color'] = $record['PROPERTY_COLOR_VALUE'];

        $img = $record['PREVIEW_PICTURE'];
        if(!$img)
            $img = $record['DETAIL_PICTURE'];

        $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $minPrice = CCatalogProduct::GetOptimalPrice($record['ID']);

        $colorVariants[$record['NAME']][$record['PROPERTY_COLOR_VALUE']]['img'] = $img;
        $colorVariants[$record['NAME']][$record['PROPERTY_COLOR_VALUE']]['price'] = $minPrice;
        $colorVariants[$record['NAME']][$record['PROPERTY_COLOR_VALUE']]['code'] = $record['CODE'];
        $colorVariants[$record['NAME']][$record['PROPERTY_COLOR_VALUE']]['name'] = $record['NAME'];
    }
}

$arResult['COLOR_VARIANTS'] = $colorVariants;

$arResult['COLOR_IDS'] = $Ids;

$offerTreeProps = $arParams['OFFER_TREE_PROPS'];
foreach ($offerTreeProps as $index => $offerTreeProp)
    if(!$offerTreeProp) unset($offerTreeProps[$index]);
$items = $arResult['ITEMS'];
$tree = $colors = $fileColors = $ids = $jsData = [];

$res = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => 25, 'CODE' => 'RAZMER']);
$sortingSizes = [];
while ($record = $res -> Fetch())
{
    $sortingSizes[mb_strtoupper($record['VALUE'])] = $record['SORT'];
}
$arResult['SORTING_SIZES'] = $sortingSizes;

if(!empty($colors))
{
    $res = $DB -> Query('select * from max_color_reference where UF_XML_ID in ("'.implode('","', $colors).'")');
    while ($record = $res -> Fetch())
    {
        $colors[$record['UF_XML_ID']] =
            LANGUAGE_ID == 'ua' && $record['UF_NAME_UA'] ?
                $record['UF_NAME_UA'] :
                $record['UF_NAME'];
        $fileColors[$record['UF_XML_ID']] = $record['UF_FILE'] ? $record['UF_FILE'] : '';
    }
}
$arResult['TREE_PROPS'] = $tree;
$arResult['FILE_COLORS'] = $fileColors;

$cp = $this->__component;
$cp->SetResultCacheKeys( array('NAV_RESULT') );

$res = CIBlockSection::GetList(
    array(),
    array(
        'IBLOCK_ID' => 35,
        'UF_PRODUCT' => $ids,
    ),
    false,
    array('ID','IBLOCK_ID','UF_*')
);
while ($record = $res -> Fetch())
{
    $r1 = intval($record['UF_RATING_1'])*1;
    $r2 = intval($record['UF_RATING_2'])*2;
    $r3 = intval($record['UF_RATING_3'])*3;
    $r4 = intval($record['UF_RATING_4'])*4;
    $r5 = intval($record['UF_RATING_5'])*5;

    $sumRatings = intval($record['UF_RATING_1'])+intval($record['UF_RATING_2'])+intval($record['UF_RATING_3'])+intval($record['UF_RATING_4'])+intval($record['UF_RATING_5']);
    if(!$sumRatings)
        $arResult['AVERAGE'][$record['UF_PRODUCT']] = 0;
    else
        $arResult['AVERAGE'][$record['UF_PRODUCT']] = round(($r1+$r2+$r3+$r4+$r5)/$sumRatings,1);
}
$relation = [];
foreach ($arResult['ITEMS'] as $index => $arItem)
{
    $relation[$arItem['ID']] = $index;
}

$arResult['RELATION'] = $relation;
?>