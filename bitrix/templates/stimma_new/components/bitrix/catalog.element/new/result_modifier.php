<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$slider = $colorVariants = [];
$bIndex = (strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false) || isset($_GET['google']);
$bIndex = $arParams['B_INDEX'];
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
$pictureVariants=[];
$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'ACTIVE' => 'Y', 'NAME' => $arResult['NAME']],false,false,['ID','IBLOCK_ID','NAME','PROPERTY_COLOR','DETAIL_PAGE_URL','PREVIEW_PICTURE']);
while ($record = $res -> GetNext())
{
    $resFile = $DB->Query('select * from b_iblock_element_property where IBLOCK_PROPERTY_ID = 239 and IBLOCK_ELEMENT_ID = ' . $record['ID'])->Fetch()["VALUE"];

    $colorVariants[$record['PROPERTY_COLOR_VALUE']] = $record['DETAIL_PAGE_URL'];
    //$pictureVariants[$record['PROPERTY_COLOR_VALUE']]['img'] = CFile::ResizeImageGet($record['PREVIEW_PICTURE'], array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
    $pictureVariants[$record['PROPERTY_COLOR_VALUE']]['img'] = CFile::ResizeImageGet($resFile, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
    $pictureVariants[$record['PROPERTY_COLOR_VALUE']]['url'] = $record['DETAIL_PAGE_URL'];
}

$arResult['PICTURE_VARIANTS'] = $pictureVariants;
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
    if($bIndex)
    {
        $big = CFile::ResizeImageGet($item['DETAIL_PICTURE']['ID'], array('width'=>412, 'height'=>618), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $small = CFile::ResizeImageGet($item['DETAIL_PICTURE']['ID'], array('width'=>118, 'height'=>181), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
    }
    else
    {
        $big = CFile::ResizeImageGet($item['DETAIL_PICTURE']['ID'], array('width'=>960, 'height'=>1344), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $small = CFile::ResizeImageGet($item['DETAIL_PICTURE']['ID'], array('width'=>118, 'height'=>181), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
    }

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
        if($bIndex)
        {
            $big = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], array('width'=>412, 'height'=>618), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
            $small = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], array('width'=>118, 'height'=>181), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        }
        else
        {
            $big = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], array('width'=>960, 'height'=>1344), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
            $small = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], array('width'=>118, 'height'=>181), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        }

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
        $big = CFile::ResizeImageGet($photo, array('width'=>960, 'height'=>1344), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
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
$colorsList = [];
while ($record = $res -> Fetch())
{
    $forChange[$record['UF_XML_ID']] = LANGUAGE_ID=='ua' ? $record['UF_NAME_UA'] : $record['UF_NAME'];
    $alLColors[$record['UF_XML_ID']] = $record['UF_COLOR_CODE'];
    $colorsList[$record['UF_XML_ID']] = LANGUAGE_ID == 'ua' ? $record['UF_NAME_UA'] : $record['UF_NAME'];
}
$arResult['ALL_COLORS'] = $alLColors;
$arResult['COLOR_LIST'] = $colorsList;
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

if(LANGUAGE_ID == 'ua')
    $fromTo = [
        'Обхват грудей' => 'Обхват грудей',
        'Обхват талії' => 'Обхват талії',
        'Обхват стегон' => 'Обхват стегон',
        'Ширина плечей по спинці' => 'Ширина плечей по спинці',
        'Довжина рукава' => 'Довжина рукава',
        'Довжина виробу по спинці' => 'Довжина виробу по спинці',
        'ширина по низу' => 'ширина по низу',
        'ширина плеч по спинке' => 'Ширина плеч по спинці',
        'длина рукава' => 'Довжина рукава',
        'Длина изделия по спинке' => 'Довжина виробу по спинці',
        'Посадка' => 'Посадка',
        'Длина по боку' => 'Довжина по боку',
        'Длина по внутреннему шву' => 'Довжина по внутрішньому шву',
        'Ширина по низу' => 'Ширина по низу',
        'Довжина по боку' => 'Довжина по боку',
        'Ширина плелей по спинці' => 'Ширина плелей по спинці',
        'Довжина по бічному шву' => 'Довжина по бічному шву',
        'Довжина по внутрішньому шву' => 'Довжина по внутрішньому шву',
        'Ширина плеч по спинке' => 'Ширина плеч по спинці',
        'Длина рукава' => 'Довжина рукава',
        'ширина плечей по спинці' => 'ширина плечей по спинці',
        'ширина плеч по спинкн' => 'Ширина плечей по спинці',
        'ОРИ' => 'ОРИ',
        'Ширина плеч по спині' => 'Ширина плечей по спині',
        'Довжина виробу по спині' => 'Довжина виробу по спині',
        'довжина рукава' => 'довжина рукава',
        'Ширина плеч по спинці' => 'Ширина плечей по спинці',
    ];
else
    $fromTo = [
        'Обхват грудей' => 'Обхват груди',
        'Обхват талії' => 'Обхват талии',
        'Обхват стегон' => 'Обхват стегон',
        'Ширина плечей по спинці' => 'ширина плеч по спинке',
        'Довжина рукава' => 'длина рукава',
        'Довжина виробу по спинці' => 'Длина изделия по спинке',
        'ширина по низу' => 'ширина по низу',
        'ширина плеч по спинке' => 'ширина плеч по спинке',
        'длина рукава' => 'длина рукава',
        'Длина изделия по спинке' => 'Длина изделия по спинке',
        'Посадка' => 'Посадка',
        'Длина по боку' => 'Длина по боку',
        'Длина по внутреннему шву' => 'Длина по внутреннему шву',
        'Ширина по низу' => 'Ширина по низу',
        'Довжина по боку' => 'Длина по боку',
        'Ширина плелей по спинці' => 'Ширина плелей по спинке',
        'Довжина по бічному шву' => 'Длина по боковому шву',
        'Довжина по внутрішньому шву' => 'Длина по внутреннему шву',
        'Ширина плеч по спинке' => 'Ширина плеч по спинке',
        'Длина рукава' => 'Длина рукава',
        'ширина плечей по спинці' => 'ширина плеч по спинке',
        'ширина плеч по спинкн' => 'ширина плеч по спинке',
        'ОРИ' => 'ОРИ',
        'Ширина плеч по спині' => 'Ширина плеч по спині',
        'Довжина виробу по спині' => 'Длина изделия по спинке',
        'довжина рукава' => 'длина рукава',
        'Ширина плеч по спинці' => 'Ширина плеч по спинке',
    ];

$table = $DB -> Query('select * from size_table where UF_PRODUCT = ' . $arResult['ID']);
$tds = [];
if ($table = $table -> Fetch())
{
    $table = unserialize($table['UF_TABLE'], ['allowed_classes' => false]);
    foreach ($table as $index => $items)
    {
        foreach ($items as $index2 => $item)
        {
            $tds[$index2][] = $item;
            $table[$index][$index2] = str_replace(array_keys($fromTo), $fromTo, $item);
        }
        if(count(array_unique($table[$index])) == 1) unset($table[$index]);
    }
    $noIds = [];
    foreach ($tds as $index => $td)
        if(count(array_unique($td)) == 1) $noIds[] = $index;

    if(!empty($noIds))
        foreach ($table as $index => $items)
        {
            foreach ($items as $index2 => $item)
            {
                if(in_array($index2, $noIds)) unset($table[$index][$index2]);
            }
        }
}
else
    $table = false;

$arResult['TABLE'] = $table;
$arResult['NAME_TABLE'] = LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME'];

