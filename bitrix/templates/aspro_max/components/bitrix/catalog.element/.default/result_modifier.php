<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$slider = $colorVariants = [];

$skipOffer = true;
$selOffer = false;
foreach($arResult['OFFERS'] as $index => $arOffer)
{
    if(!$arOffer['CATALOG_QUANTITY'])
        $arResult['OFFERS'][$index]['skip'] = 1;
    else
    {
        if($selOffer === false) $selOffer = $index;
        $skipOffer = false;
    }
}
if($selOffer === false) $selOffer = 0;

$arResult['SELECTED_OFFER'] = $selOffer;

$arResult['SKIP_OFFERS'] = $skipOffer;

//$arResult['OFFERS'] = array_values($arResult['OFFERS']);

$item = $arResult['OFFERS'][$arResult['SELECTED_OFFER']];
$item = $arResult;

$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'ACTIVE' => 'Y', 'NAME' => $arResult['NAME']],false,false,['ID','IBLOCK_ID','NAME','PROPERTY_COLOR','DETAIL_PAGE_URL']);
while ($record = $res -> GetNext())
    $colorVariants[$record['PROPERTY_COLOR_VALUE']] = $record['DETAIL_PAGE_URL'];

$arResult['COLOR_VARIANTS'] = $colorVariants;
if(!$item['DETAIL_PICTURE']['ID'] && $arResult['DETAIL_PICTURE'])
    $item['DETAIL_PICTURE']['ID'] = $arResult['DETAIL_PICTURE'];
if(!$item['PREVIEW_PICTURE'] && $arResult['PREVIEW_PICTURE'])
    $item['PREVIEW_PICTURE'] = $arResult['PREVIEW_PICTURE'];
if((!$item['PROPERTIES']['MORE_PHOTO']['VALUE'] || empty($item['PROPERTIES']['MORE_PHOTO']['VALUE'])) && !empty($arResult['PROPERTIES']['PHOTO_GALLERY']['VALUE']))
    $item['PROPERTIES']['MORE_PHOTO']['VALUE'] = $arResult['PROPERTIES']['PHOTO_GALLERY']['VALUE'];


if($item['DETAIL_PICTURE']['ID'])
{
    $original = CFile::GetFileArray($item['DETAIL_PICTURE']['ID'])['SRC'];
    $big = CFile::ResizeImageGet($item['DETAIL_PICTURE']['ID'], array('width'=>545, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
    $small = CFile::ResizeImageGet($item['DETAIL_PICTURE']['ID'], array('width'=>118, 'height'=>181), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
    $slider[] = [
        'ORIGINAL' => $original,
        'BIG' => $big,
        'SMALL' => $small,
    ];
}
else
    if($item['PREVIEW_PICTURE'])
    {
        $original = CFile::GetFileArray($item['PREVIEW_PICTURE'])['SRC'];
        $big = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], array('width'=>545, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $small = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], array('width'=>118, 'height'=>181), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $slider[] = [
            'ORIGINAL' => $original,
            'BIG' => $big,
            'SMALL' => $small,
        ];
    }

if($item['PROPERTIES']['MORE_PHOTO']['VALUE'])
{
    foreach($item['PROPERTIES']['MORE_PHOTO']['VALUE'] as $key => $photo)
    {
        $original = CFile::GetFileArray($photo)['SRC'];
        $big = CFile::ResizeImageGet($photo, array('width'=>545, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $small = CFile::ResizeImageGet($photo, array('width'=>118, 'height'=>181), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $slider[] = [
            'ORIGINAL' => $original,
            'BIG' => $big,
            'SMALL' => $small,
        ];
    }
}


$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$arResult['SLIDER'] = $slider;

$razmers = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID"=>25, "CODE"=>"RAZMER"));
$sizes = [];
while ($razmer = $razmers -> Fetch())
{
    $sizes[$razmer['XML_ID']] = $razmer['SORT'];
}

$offerTreeProps = $arParams['OFFER_TREE_PROPS'];
$tree = [];
$tree['props']['RAZMER']['values'] = $nVals;

//$arResult['SELECTED_OFFER'] = 0;

$arResult['TREE_PROPS'] = $tree;

$res = CIBlockSection::GetList([], ['IBLOCK_ID' => 35,'UF_PRODUCT' => $arResult['ID']], false, ['ID','IBLOCK_ID','UF_*']);
$cnt=0;
if($res = $res -> Fetch())
{
    $cnt++;
    $r1 = intval($res['UF_RATING_1'])*1;
    $r2 = intval($res['UF_RATING_2'])*2;
    $r3 = intval($res['UF_RATING_3'])*3;
    $r4 = intval($res['UF_RATING_4'])*4;
    $r5 = intval($res['UF_RATING_5'])*5;
    $sumRatings = intval($res['UF_RATING_1'])+intval($res['UF_RATING_2'])+intval($res['UF_RATING_3'])+intval($res['UF_RATING_4'])+intval($res['UF_RATING_5']);
    if(!$sumRatings)
        $arResult['AVERAGE'] = 0;
    else
        $arResult['AVERAGE'] = round(($r1+$r2+$r3+$r4+$r5)/$sumRatings,1);
    $arResult['ALL_SUM'] = $sumRatings;

    $res['PERCENT_1'] = (intval($res['UF_RATING_1'])/$sumRatings)*100;
    $res['PERCENT_2'] = (intval($res['UF_RATING_2'])/$sumRatings)*100;
    $res['PERCENT_3'] = (intval($res['UF_RATING_3'])/$sumRatings)*100;
    $res['PERCENT_4'] = (intval($res['UF_RATING_4'])/$sumRatings)*100;
    $res['PERCENT_5'] = (intval($res['UF_RATING_5'])/$sumRatings)*100;

    $arResult['REVIEW_SECTION'] = $res;

    $res2 = CIBlockElement::GetList([], ['IBLOCK_ID' => 35,'SECTION_ID' => $res['ID'],'ACTIVE' => 'Y'], false, false, ['ID','IBLOCK_ID','NAME','PREVIEW_TEXT','PROPERTY_RATING']);
    while ($rewiew = $res2 -> Fetch())
    {
        $arResult['REVIEW'][] = $rewiew;
    }
}
else
{
    $arResult['REVIEW_SECTION'] = false;
    $arResult['AVERAGE'] = 0;
    $arResult['ALL_SUM'] = 0;
}
$arResult['ALL_COUNT'] = $cnt;

$arResult['JS_DATA'] = $jsData;


$alLColors = $alLColorsIDs = $alLMainColors = $forChange = [];
$res = $DB -> Query('select * from max_color_reference');
while ($record = $res -> Fetch())
{
    $forChange[$record['UF_XML_ID']] = LANGUAGE_ID=='ua' ? $record['UF_NAME_UA'] : $record['UF_NAME'];
    $alLColors[$record['UF_XML_ID']] = $record['UF_COLOR_CODE'];
}
$arResult['ALL_COLORS'] = $alLColors;
$arResult['COLORS_FOR_CHANGE'] = $forChange;

$res = $DB -> Query('select * from main_colors');
while ($record = $res -> Fetch())
{
    $record['UF_COLORS'] = unserialize($record['UF_COLORS'], ['allowed_classes' => false]);
    $alLMainColors[$record['UF_XML_ID']] = $record['UF_CODE_COLOR'];
}
$arResult['ALL_MAIN_COLORS'] = $alLMainColors;

if (LANGUAGE_ID == 'ua')
{
    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php'))
        require $_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php';
    // $name_ua
    foreach($arResult['OFFERS'][0]['DISPLAY_PROPERTIES'] as $key => $arItem)
    {
        if($arItem['CODE'] == 'COLOR_REF')
        {
            if(is_array($arItem['VALUE']))
                foreach ($arItem['VALUE'] as $index => $item)
                    $arItem['VALUE'][$index] = '\''.$item.'\'';
            else
                $arItem['VALUE'] = '\''.$arItem['VALUE'].'\'';

            $val = is_array($arItem['VALUE']) ? implode(',',$arItem['VALUE']) : $arItem['VALUE'];
            $res = $DB -> Query('select * from max_color_reference where UF_XML_ID in ('.$val.')');

            $vals = [];
            while ($record = $res -> Fetch())
            {
                $vals[] = $record['UF_NAME_UA'];
            }

            $arResult['OFFERS'][0]['DISPLAY_PROPERTIES'][$key]['DISPLAY_VALUE'] = implode(', ', $vals);
            $arResult['OFFERS'][0]['DISPLAY_PROPERTIES'][$key]['VALUE'] = implode(', ', $vals);
        }

        if(!$arItem['DISPLAY_VALUE']) continue;
        if(isset($name_ua[$arItem['CODE']]['name_ua']))
            $arResult['OFFERS'][0]['DISPLAY_PROPERTIES'][$key]['NAME'] = $name_ua[$arItem['CODE']]['name_ua'];

        if(is_array($arItem['VALUE_XML_ID']))
        {
            $vals = [];
            foreach ($arItem['VALUE_XML_ID'] as $index => $item)
            {
                if(isset($name_ua[$arItem['CODE']]['values'][$item]))
                    $vals[] = $name_ua[$arItem['CODE']]['values'][$item];
                else
                    $vals[] = $item;
            }
            $arResult['OFFERS'][0]['DISPLAY_PROPERTIES'][$key]['DISPLAY_VALUE'] = implode(', ', $vals);
            $arResult['OFFERS'][0]['DISPLAY_PROPERTIES'][$key]['VALUE'] = implode(', ', $vals);

        }
        else
        {
            if(isset($name_ua[$arItem['CODE']]['values'][$arItem['VALUE_XML_ID']]))
            {
                $arResult['OFFERS'][0]['DISPLAY_PROPERTIES'][$key]['DISPLAY_VALUE'] = $name_ua[$arItem['CODE']]['values'][$arItem['VALUE_XML_ID']];
                $arResult['OFFERS'][0]['DISPLAY_PROPERTIES'][$key]['VALUE'] = $name_ua[$arItem['CODE']]['values'][$arItem['VALUE_XML_ID']];
            }
        }
    }
}
$res = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => 25, 'CODE' => 'RAZMER']);
$sortingSizes = [];
while ($record = $res -> Fetch())
{
    $sortingSizes[mb_strtoupper($record['VALUE'])] = $record['SORT'];
}
$arResult['SORTING_SIZES'] = $sortingSizes;

if(LANGUAGE_ID == 'ua' && !$arResult['PROPERTIES']['DETAIL_TEXT_UA']['VALUE'])
{

    if(!is_array($arResult['PROPERTIES']['DETAIL_TEXT_UA']['~VALUE']))
        $arResult['PROPERTIES']['DETAIL_TEXT_UA']['~VALUE'] = ['TEXT'=>'','VALUE'=>''];
    $arResult['PROPERTIES']['DETAIL_TEXT_UA']['VALUE'] = [];
    //$arResult['PROPERTIES']['DETAIL_TEXT_UA']['VALUE']['TEXT'] =
        $arResult['PROPERTIES']['DETAIL_TEXT_UA']['~VALUE']['TEXT']  =
            $arResult['OFFERS'][0]['PROPERTIES']['DETAIL_TEXT_UA']['~VALUE'];
}
elseif(LANGUAGE_ID != 'ua' && ! $arResult['DETAIL_TEXT'])
{
  $arResult['DETAIL_TEXT'] = $arResult['OFFERS'][0]['DETAIL_TEXT'];
}


$cp = $this->__component;
$cp->SetResultCacheKeys(array('PROPERTIES'));
