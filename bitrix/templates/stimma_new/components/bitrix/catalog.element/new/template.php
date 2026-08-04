<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
   
use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$selected = $arResult['SELECTED_OFFER'];
$tree = $arResult['TREE_PROPS'];
$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');
$bIndex = (strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false) || isset($_GET['google']);
$bIndex = $arParams['B_INDEX'];

global $DB;

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DESCRIPTION_ID' => $mainId.'_description',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
	$actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['MORE_PHOTO_COUNT'] > 1)
		{
			$showSliderControls = true;
			break;
		}
	}
}
else
{
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y')
{
	$skuDescription = false;
	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '')
		{
			$skuDescription = true;
			break;
		}
	}
	$showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}
else
{
	$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$res = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $arResult['IBLOCK_SECTION_ID']], false, ['ID','IBLOCK_ID','NAME','UF_*']) -> Fetch();
$sectionName = LANGUAGE_ID == 'ua' ? $res['UF_NAME_UA'] : $res['NAME'];
$itemName = LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME'];


$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
$gGroups = explode(',',$USER -> GetGroups());
if(in_array(9,$gGroups) && $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['OPT']['DISCOUNT_VALUE'] > $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['OPT_DISCOUNT']['DISCOUNT_VALUE'] && $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['OPT_DISCOUNT']['DISCOUNT_VALUE'])
{
    $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['BASE'] =  $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['OPT'];
    $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE'] = $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['OPT_DISCOUNT'];
}
$isSert = false;
if(strpos($APPLICATION->GetCurPage(), '/podarochnyy_sertifikat') !== false)
{
    $isSert = true;
    $sizesSert = [
        '100'=>[
            'offer_id' => 25934,
            'value' => 1000,
            'active' => 1,
            'imag' => $arResult['OFFERS'][0]['PREVIEW_PICTURE']['SRC'],
            'original' => CFile::GetFileArray($arResult['OFFERS'][0]['PREVIEW_PICTURE']['ID'])['SRC'],
            'imag_2' => CFile::ResizeImageGet($arResult['OFFERS'][0]['PREVIEW_PICTURE']['ID'], array('width'=>118, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
        ],
        '200'=>[
            'offer_id' => 25935,
            'value' => 1500,
            'active' => false,
            'imag' => $arResult['OFFERS'][1]['PREVIEW_PICTURE']['SRC'],
            'original' => CFile::GetFileArray($arResult['OFFERS'][1]['PREVIEW_PICTURE']['ID'])['SRC'],
            'imag_2' => CFile::ResizeImageGet($arResult['OFFERS'][1]['PREVIEW_PICTURE']['ID'], array('width'=>118, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
        ],
        '300'=>[
            'offer_id' => 25936,
            'value' => 2000,
            'active' => false,
            'imag' => $arResult['OFFERS'][2]['PREVIEW_PICTURE']['SRC'],
            'original' => CFile::GetFileArray($arResult['OFFERS'][2]['PREVIEW_PICTURE']['ID'])['SRC'],
            'imag_2' => CFile::ResizeImageGet($arResult['OFFERS'][2]['PREVIEW_PICTURE']['ID'], array('width'=>118, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
        ],
        '400'=>[
            'offer_id' => 25937,
            'value' => 3000,
            'active' => false,
            'imag' => $arResult['OFFERS'][3]['PREVIEW_PICTURE']['SRC'],
            'original' => CFile::GetFileArray($arResult['OFFERS'][3]['PREVIEW_PICTURE']['ID'])['SRC'],
            'imag_2' => CFile::ResizeImageGet($arResult['OFFERS'][3]['PREVIEW_PICTURE']['ID'], array('width'=>118, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
        ],
        '500'=>[
            'offer_id' => 25939,
            'value' => 4000,
            'active' => false,
            'imag' => $arResult['OFFERS'][4]['PREVIEW_PICTURE']['SRC'],
            'original' => CFile::GetFileArray($arResult['OFFERS'][4]['PREVIEW_PICTURE']['ID'])['SRC'],
            'imag_2' => CFile::ResizeImageGet($arResult['OFFERS'][4]['PREVIEW_PICTURE']['ID'], array('width'=>118, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
        ],
    ];
}
$isAcsesuaries = (strpos($APPLICATION->GetCurPage(), '/aksessuary/') !== false || strpos($APPLICATION->GetCurPage(), '/bonusna_shafa/') !== false) && $arResult['IBLOCK_SECTION_ID'] != 1170 && $arResult['IBLOCK_SECTION_ID'] != 411 && $arResult['IBLOCK_SECTION_ID'] != 1262;

if(in_array($arResult['ID'], [47178,47183,47188,47191,47194,47198]))
    $isAcsesuaries=false;
$bonusProduct = $arResult['PROPERTIES']['PROP_BONUS_PRICE']['VALUE'] > 0;
if(in_array($arResult['ID'], [47178,47183,47191,47188,47194,47198]))
    $bonusProduct=false;

$shoes = $arResult['IBLOCK_SECTION_ID']==1170;

$dopObrazElement=[];

{
    $res = $DB->Query('select * from b_iblock_element_property where IBLOCK_PROPERTY_ID = 868 and IBLOCK_ELEMENT_ID in ('.$arResult['ID'].') ');
    $ids = [];
    while ($record = $res->Fetch())
        $ids[$record['VALUE']] = $record['VALUE'];

    if(!empty($ids))
        $dopObrazElement=$ids;
}


$nav = CIBlockSection::GetNavChain(
        21,
        $arResult['IBLOCK_SECTION_ID'],
        ['ID', 'IBLOCK_ID','NAME', 'SECTION_PAGE_URL']
);

$chast = true;
$uGroups = $USER->GetUserGroupArray();
if(in_array(9,$uGroups)) $chast = false;

$ru=LANGUAGE_ID=='ru'?'/ru':'';
?>

    <div class="breadcrumbs-cont">
        <div class="wrapper">
            <div class="breadcrumbs-block">
                <a href="<?=$ru?>/" class="breadcrumb-item">
                    STIMMA
                </a>
                <?
                while ($item = $nav->GetNext())
                {
                    if(LANGUAGE_ID=='ua')
                    {
                        $sss=CIBlockSection::GetList([],['ID'=>$item['ID'],'IBLOCK_ID'=>21],false,['ID','IBLOCK_ID','UF_*'])->Fetch();
                        $item['NAME']=$sss['UF_NAME_UA'];
                    }
                    ?>
                        <span class="breadcrumb-sep">
                            <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"></path>
                            </svg>
                        </span>
                        <a href="<?=$item['SECTION_PAGE_URL']?>" class="breadcrumb-item">
                            <?=$item['NAME']?>
                        </a>
                    <?
                }
                ?>

                <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"></path>
                        </svg>
                    </span>
                <span class="breadcrumb-item">
                        <?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']?>
                    </span>
            </div>
        </div>
    </div>


<?

if(LANGUAGE_ID == 'ua')
    $fromTo = [
        'Обхват грудей' => 'Обхват грудей',
        'Обхват талії' => 'Обхват талії',
        'Обхват бедер' => 'Обхват бедер',
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
        'Обхват бедер' => 'Обхват бедер',
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


$selOffer = $arResult['OFFERS'][$arResult['SELECTED_OFFER']];


if ($selOffer['PRICES']['BASE']['DISCOUNT_VALUE'] > $selOffer['MIN_PRICE']['DISCOUNT_VALUE']) {
    //if(in_array(9,$gGroups) && $selOffer['PRICES']['BASE']['DISCOUNT_VALUE'])
    //    $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['PRINT_VALUE'] = FormatCurrency($selOffer['PRICES']['BASE']['DISCOUNT_VALUE'], 'UAH');
    //else
    $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['PRINT_VALUE'] = FormatCurrency($selOffer['PRICES']['BASE']['DISCOUNT_VALUE'], 'UAH');
}

?>


        <div class="card-cont">
            <div class="wrapper">
                <div class="card-content">
                    <div class="card-img-cont">
                        <div class="card-favorite-block">
                            <a href="#" data-id="<?=$arResult['ID']?>">
                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.3926 0.5C22.1928 0.500022 23.9116 1.19375 25.2344 2.45801C26.6857 3.84515 27.5134 5.80855 27.5 7.84375C27.489 9.49086 26.7969 11.3063 25.3701 13.2451C24.2673 14.7437 22.7294 16.3136 20.791 17.9072C17.5169 20.5987 14.2974 22.3872 14.1709 22.457C14.1196 22.4853 14.0604 22.5 14 22.5C13.9397 22.5 13.8809 22.4849 13.8301 22.457C13.7011 22.3863 10.459 20.5983 7.17383 17.9072C5.22791 16.3133 3.68875 14.7438 2.58984 13.2451C1.16683 11.3045 0.489073 9.4886 0.5 7.84082C0.513093 5.8836 1.25074 4.04909 2.57227 2.66992C3.91554 1.26827 5.7023 0.500044 7.60742 0.5C10.0464 0.5 12.2849 1.79806 13.5762 3.86621C13.6675 4.01232 13.8277 4.10155 14 4.10156C14.1723 4.10156 14.3324 4.01232 14.4238 3.86621C15.7151 1.79811 17.9537 0.5 20.3926 0.5Z" stroke="currentcolor" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                        <div class="card-sliders-cont">
                            <div class="card-little-slider-cont">
                                <?

                                if(!$bIndex)
                                {
                                    ?>
                                    <div class="card-little-slider">
                                        <?
                                        $indexSlider = 1;
                                        foreach ($arResult['SLIDER'] as $index => $item)
                                        {
                                            $colorName = LANGUAGE_ID == 'ua' ? 'колір' : 'цвет';
                                            if(strpos(strtolower($item['SMALL']),'.m4v')!==false || strpos(strtolower($item['SMALL']),'.mp4')!==false || strpos(strtolower($item['SMALL']),'.MP4')!==false)
                                            {
                                                ?>
                                                <a href="#imgn<?=$index?>" class="card-little-slider-item" aria-label="<?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']?>">
                                                    <div class="card-little-slider-img">
                                                        <img src="<?=SITE_TEMPLATE_PATH?>/images/frame_video.png" alt="<?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']?>, фото <?=$indexSlider?><?/*=$colorName?> - <?=$arResult['OFFERS'][0]['DISPLAY_PROPERTIES']['COLOR_REF']['DISPLAY_VALUE']*/?>">
                                                    </div>
                                                </a>
                                                <?
                                            }
                                            else
                                                {
                                                    ?>
                                                    <a href="#imgn<?=$index?>" class="card-little-slider-item" aria-label="<?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']?>">
                                                        <div class="card-little-slider-img">
                                                            <img src="<?=convertToWebP($item['SMALL'])?>" alt="<?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']?>, фото <?=$indexSlider?><?/*=$colorName?> - <?=$arResult['OFFERS'][0]['DISPLAY_PROPERTIES']['COLOR_REF']['DISPLAY_VALUE']*/?>">
                                                        </div>
                                                    </a>
                                                    <?
                                                }

                                            $indexSlider++;
                                            if($bIndex) break;
                                        }
                                        ?>
                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                            <div class="card-big-slider-cont">
                                <div class="card-big-slider">
                                    <?
                                    $indexSlider = 1;
                                    foreach ($arResult['SLIDER'] as $index => $item)
                                    {
                                        $colorName = LANGUAGE_ID == 'ua' ? 'колір' : 'цвет';
                                        if(strpos(strtolower($item['BIG']),'.m4v')!==false || strpos(strtolower($item['BIG']),'.mp4')!==false || strpos(strtolower($item['BIG']),'.MP4')!==false)
                                         {
                                            ?>
                                            <div class="card-big-slider-item" id="imgn<?=$index?>">
                                                <div class="card-big-slider-img">
                                                    <video
                                                            autoplay
                                                            muted
                                                            loop
                                                            playsinline
                                                            preload="auto"
                                                            <?/*controls */?>
                                                            <?/*poster="<?=$slider[0]?>"*/?>
                                                    >
                                                        <source src="<?=$item['ORIGINAL']?>" type="video/mp4">
                                                        Ваш браузер не поддерживает видео
                                                    </video>
                                                </div>
                                            </div>
                                            <?
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="card-big-slider-item" id="imgn<?=$index?>">
                                                <div class="card-big-slider-img">
                                                    <span class="card-big-slider-img-zoom">
                                                        <img  src="<?=convertToWebP($item['BIG'])?>" alt="<?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']?>, фото <?=$indexSlider?> <?/*=$colorName?> - <?=$arResult['OFFERS'][0]['DISPLAY_PROPERTIES']['COLOR_REF']['DISPLAY_VALUE']*/?>">
                                                    </span>
                                                </div>
                                            </div>
                                            <?
                                        }
                                        if($bIndex) break;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?
                        if(!empty($dopObrazElement))
                        {
                            ?>
                            <div class="card-img-btn">
                                <div class="info-btn" data-bs-toggle="modal" data-bs-target="#look-dop-modal">
                                    <?=LANGUAGE_ID=='ua'?'доповни свій образ':'дополни свой образ'?>
                                </div>
                            </div>
                            <?
                        }
                        ?>

                    </div>
                    <div class="card-info-block">
                        <div class="card-name-block">

                            <h1 class="card-name" data-entity="name_card">
                                <?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] . ' ' . $arResult['COLORS_FOR_CHANGE'][$arResult['PROPERTIES']['COLOR']['VALUE']] . $ccName : $arResult['NAME'] . ' ' . $arResult['COLORS_FOR_CHANGE'][$arResult['PROPERTIES']['COLOR']['VALUE']] .$ccName?>
                            </h1>
                            <?
                            if($arResult['IBLOCK_SECTION_ID'] == 1311)
                            {
                                ?>
                                <div class="card-available">
                                    <?=LANGUAGE_ID=='ua'?'Товар за стімзи':'Товар за стимзы'?>
                                </div>
                                <?
                            }
                            ?>

                        </div>
                        <div class="card-price-block" data-entity="price_card">
                            <?
                            if($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['BASE']['DISCOUNT_VALUE'] > $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE'])
                            {
                                ?>
                                <div class="new-card-info-price-old" data-entity="price-old">
                                    <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['PRINT_VALUE']?>
                                </div>
                                <?
                            }
                            ?>
                                <?
                                if(strpos($APPLICATION->GetCurPage(), '/podarochnyy_sertifikat/') === false)
                                {
                                    ?>
                                    <div class="card-price">
                                        <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?>
                                    </div>
                                    <?
                                }
                                else
                                {
                                    //echo LANGUAGE_ID=='ua'?'Виберіть номінал':'Выберите номинал';
                                }
                                ?>
                                <?
                                if($arResult['PROPERTIES']['PROP_BONUS_PRICE']['VALUE'])
                                {
                                    ?>
                                    <div class="card-price-bonus">
                                        <?=$arResult['PROPERTIES']['PROP_BONUS_PRICE']['VALUE']?>
                                        <span class="icon">
                                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="13" cy="13" r="13" fill="#FE9D56"></circle>
                                            <path d="M19.9537 14.8235C19.9537 15.4501 19.8381 16.0029 19.6113 16.468C19.3865 16.9267 19.0833 17.3191 18.707 17.6367C18.3434 17.9436 17.9193 18.1927 17.4454 18.3756C16.9991 18.5477 16.5242 18.6824 16.0355 18.7765C15.5542 18.8685 15.0612 18.9294 14.5714 18.9572C14.0933 18.9861 13.6322 19 13.1996 19C12.0632 19 10.9935 18.9038 10.0214 18.7145C9.05347 18.5253 8.1831 18.2868 7.43571 18.0035L7.07315 17.8655V13.8248L7.90323 14.2899C8.60079 14.6791 9.40967 14.9903 10.3087 15.2116C11.214 15.4351 12.1978 15.5484 13.2325 15.5484C13.8399 15.5484 14.3361 15.5164 14.7071 15.4544C15.146 15.3795 15.3877 15.294 15.5128 15.2352C15.6983 15.1485 15.7439 15.0887 15.745 15.0887C15.762 15.0619 15.7704 15.0438 15.7736 15.0341C15.7694 15.032 15.7577 15.0192 15.7365 15.0021C15.6591 14.9379 15.5096 14.8417 15.2351 14.7433C14.9775 14.6503 14.6668 14.5626 14.3149 14.4824C13.9449 14.399 13.5505 14.3145 13.135 14.2311C12.7109 14.1456 12.2752 14.0526 11.8268 13.9542C11.3656 13.8515 10.9129 13.7296 10.4793 13.5917C10.0383 13.4516 9.61322 13.2848 9.21779 13.0966C8.8001 12.8978 8.42587 12.6572 8.10677 12.3824C7.77071 12.0915 7.50144 11.7494 7.30532 11.3655C7.10283 10.9667 7 10.5058 7 9.99581C7 9.41413 7.10707 8.89768 7.31698 8.46143C7.5237 8.03052 7.80782 7.65841 8.16084 7.35475C8.50114 7.06177 8.89763 6.82226 9.3397 6.64155C9.75633 6.47047 10.2016 6.33575 10.6627 6.24165C11.1133 6.1497 11.5755 6.08554 12.0356 6.05132C12.4883 6.01711 12.924 6 13.33 6C13.7785 6 14.247 6.02352 14.722 6.06843C15.1916 6.11334 15.6634 6.1775 16.1213 6.25983C16.574 6.34002 17.0203 6.43519 17.4497 6.54211C17.8737 6.64904 18.2734 6.76238 18.6381 6.88107L19.025 7.00724V10.9303L18.2215 10.5358C18.0285 10.4406 17.7624 10.3283 17.4317 10.2032C17.1041 10.0792 16.7246 9.95945 16.3047 9.84718C15.886 9.73491 15.4238 9.63974 14.9308 9.56383C14.4442 9.48898 13.9385 9.45155 13.4276 9.45155C13.013 9.45155 12.6558 9.46439 12.3664 9.49005C12.0823 9.51571 11.8437 9.54886 11.6571 9.58735C11.4504 9.63012 11.3402 9.67182 11.284 9.69748C11.266 9.70604 11.2511 9.71352 11.2373 9.72101C11.3243 9.77875 11.4695 9.85466 11.7017 9.93379C11.9646 10.0225 12.2763 10.1091 12.6303 10.1893C13.0035 10.2738 13.3989 10.3604 13.8166 10.4502C14.2417 10.5411 14.6796 10.6406 15.1312 10.7486C15.5945 10.8587 16.0493 10.9891 16.4828 11.1367C16.927 11.2864 17.3532 11.4639 17.7476 11.6628C18.1631 11.8723 18.5352 12.1226 18.8533 12.4059C19.1883 12.7053 19.4565 13.0549 19.6505 13.4463C19.8519 13.8526 19.9537 14.3156 19.9537 14.8235Z" fill="white"></path>
                                        </svg>
                                    </span>
                                    </div>
                                    <?
                                }
                                ?>


                            <?/*
                            <div class="card-bonus-block">
                                345 балів
                            </div>
                            */?>
                        </div>
                        <?if($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE'] >= 3000 && $chast)
                            {?>
                                <div class="card-buy-parts">
                                    <div class="card-buy-parts-icons">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentcolor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.92004 11.1955C1.06831 9.81362 0.794053 8.15752 1.15549 6.57872C1.51693 4.99993 2.48561 3.62276 3.85589 2.73957L7.28454 7.95419L1.92004 11.1955Z"/>
                                            <path d="M5.31799 2.98764C6.3714 2.31742 7.60302 1.97403 8.85488 2.00153C10.1067 2.02903 11.3218 2.42616 12.3441 3.14198C13.3665 3.8578 14.1495 4.85968 14.5929 6.01912C15.0362 7.17856 15.1197 8.4427 14.8325 9.6494C14.5452 10.8561 13.9005 11.9503 12.9809 12.7918C12.0613 13.6332 10.9088 14.1835 9.67124 14.3721C8.43363 14.5606 7.16736 14.3788 6.03482 13.85C4.90228 13.3212 3.95512 12.4695 3.3148 11.4041L8.71548 8.22222L5.31799 2.98764Z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentcolor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.75377 13.8172C9.36677 13.7211 8.97029 13.633 8.59271 13.5208C8.33315 13.4448 8.08769 13.3366 7.84229 13.2285C6.88889 12.804 5.88829 12.6879 4.82634 12.8C4.30717 12.8561 3.76439 12.8801 3.25466 12.804C2.0228 12.6238 1.29123 11.5986 1.57442 10.5414C1.79625 9.72843 2.37678 9.12776 3.18386 8.69122C3.84935 8.32683 4.43932 7.89029 5.00097 7.42577C5.34079 7.14143 5.69478 6.86513 6.06764 6.60883C7.29005 5.75183 8.87591 6.30848 9.42341 7.09739C9.71603 7.52188 9.94259 7.97844 10.1786 8.42696C10.4335 8.91953 10.7355 9.38003 11.1272 9.80453C11.6133 10.3292 11.9296 10.9138 12.0192 11.5826C12.175 12.76 11.132 13.7852 9.77735 13.7732C9.76793 13.7811 9.76319 13.7972 9.75377 13.8172Z"/>
                                            <path d="M12.5295 3.94437C12.4729 4.81338 12.0764 5.57026 11.2033 6.10688C10.0894 6.79167 8.85754 6.37519 8.59798 5.23387C8.37142 4.25273 9.01804 3.03932 10.0375 2.53073C11.1844 1.95807 12.3549 2.47066 12.5059 3.61198C12.5154 3.7121 12.5201 3.81222 12.5295 3.94437Z"/>
                                            <path d="M7.89298 3.69445C7.88824 4.21105 7.75137 4.69962 7.39737 5.12812C6.69413 5.9771 5.52362 5.98912 4.8015 5.15615C4.09353 4.3392 4.10297 2.99764 4.82037 2.1887C5.50946 1.4118 6.63276 1.4078 7.33132 2.1807C7.69474 2.57715 7.89298 3.11378 7.89298 3.69445Z"/>
                                            <path d="M11.084 8.04012C11.0887 7.10705 11.9713 6.14994 13.0285 5.93369C14.0433 5.72544 14.8409 6.22602 14.9023 7.11105C14.9683 8.08818 14.0008 9.14941 12.868 9.33763C11.8533 9.50182 11.0793 8.94118 11.084 8.04012Z"/>
                                            <path d="M4.21015 6.15683C4.20071 6.68144 4.08271 7.09392 3.74761 7.44631C3.29452 7.91887 2.59599 8.02703 1.97298 7.72663C0.826079 7.17001 0.42962 5.62422 1.19894 4.71916C1.65204 4.18254 2.41192 4.03837 3.07269 4.38678C3.87505 4.80726 4.15823 5.47204 4.21015 6.15683Z"/>
                                        </svg>
                                    </div>
                                    <span>від <?=round($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']/3)?> грн/міс</span>
                                </div>
                            <?}
                            ?>
                        <?//if(isset($_GET['infom']))
                        {?>
                            <div class="card-infom-cont">
                                <div class="card-infom-block">
                                    <span class="bonus">+<?=number_format($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE'], 0,'.',' ')?> стімзів</span> для учасників програми лояльності <a href="<?=$ru?>/sama_sobi/">Сама собі STIMMA</a>
                                </div>
                            </div>
                        <?}?>

                        <?
                        if($isSert)
                        {
                            ?>
                            <div class="card-sert-types">
                                <label>
                                    <input type="radio" name="sert-price">
                                    <span class="card-sert-price">
                                        1000₴
                                    </span>
                                </label>
                                <label>
                                    <input type="radio" name="sert-price">
                                    <span class="card-sert-price">
                                        1500₴
                                    </span>
                                </label>
                                <label>
                                    <input type="radio" name="sert-price">
                                    <span class="card-sert-price">
                                        2000₴
                                    </span>
                                </label>
                                <label>
                                    <input type="radio" name="sert-price">
                                    <span class="card-sert-price">
                                        3000₴
                                    </span>
                                </label>
                                <label>
                                    <input type="radio" name="sert-price" checked>
                                    <span class="card-sert-price">
                                        4000₴
                                    </span>
                                </label>
                            </div>
                            <div class="card-form-cont">
                                <form>
                                    <div class="card-form">
                                        <div class="form-block">
                                            <input type="text" name="sert_name_sender" value="" class="form-control" placeholder="Ім’я та прізвище відправника*">
                                        </div>
                                        <div class="form-block">
                                            <input type="text" name="sert_tel_sender" value="" class="form-control" placeholder="Телефон відправника*">
                                        </div>
                                        <div class="form-block">
                                            <input type="text" name="send_name_receiver" value="" class="form-control" placeholder="Ім’я та прізвище отримувача*">
                                        </div>
                                        <div class="form-block">
                                            <input type="text" name="send_email_receiver" value="" class="form-control" placeholder="Пошта отримувача*">
                                        </div>
                                        <div class="form-block">
                                            <input type="text" name="send_date_receiver" value="" class="form-control" placeholder="Дата відправлення сертифікату*">
                                        </div>
                                        <div class="form-block">
                                            <input type="text" name="send_desire" value="" class="form-control" placeholder="Ваші побажання">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-buy-btn-block">
                                <a href="#" class="info-btn info-btn-black buy_product in_sert" data-id="<?=$arResult['ID']?>">
                                    <?=LANGUAGE_ID=='ua'?'Додати до кошика':'Добавить в корзину'?>
                                </a>
                            </div>
                            <div class="card-accordion-block" id="card-accordion-block_id">
                                <div class="accordion accordion-flush" id="card-accord">
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card-accord11" aria-expanded="false" aria-controls="card-accord11">
                                                <?=LANGUAGE_ID=='ua'?'Умови використання онлайн-сертифікату:':'Условия использования онлайн-сертификата:'?>
                                            </button>
                                        </div>
                                        <div id="card-accord11" class="accordion-collapse collapse" data-bs-parent="#card-accord">
                                            <div class="accordion-body">
                                                <p>
                                                    <?=LANGUAGE_ID=='ua'?'Термін дії сертифіката 3 місяці з дати отримання листа.<br> Якщо сума чека перевищує номінал сертифіката — необхідно доплатити різницю. Доплату можна здійснити на сайті або накладеним платежем при отриманні замовлення. Якщо сума чека менше номіналу — залишок зберігається на балансі.':'Срок действия сертификата 3 месяца с даты получения письма.<br> Если сумма чека превышает номинал сертификата — необходимо доплатить разницу. Доплату можно осуществить на сайте или наложенным платежом при получении заказа. Если сумма чека меньше номинала — остаток сохраняется на балансе.'?>
                                                </p>
                                                <p>
                                                    <?=LANGUAGE_ID=='ua'?'Сертифікат не підлягає поверненню та обміну на грошові кошти.<br> Сертифікатом можна скористатися лише на сайті stimma.com.ua та в <a href="#">офіційному інстаграмі</a>.':'Сертификат не подлежит возврату и обмену на денежные средства.<br> Сертификатом можно воспользоваться только на сайте stimma.com.ua и в <a href="#">официальном инстаграме</a>.'?>
                                                </p>
                                                <p>
                                                    <?=LANGUAGE_ID=='ua'?'Сертифікат діє на всі позиції представлені на сайті за умови наявності товару.':'Сертификат действует на все позиции представленные на сайте при условии наличия товара.'?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card-accord12" aria-expanded="false" aria-controls="card-accord12">
                                                <?=LANGUAGE_ID=='ua'?'Як замовити?':'Как заказать?'?>
                                            </button>
                                        </div>
                                        <div id="card-accord12" class="accordion-collapse collapse" data-bs-parent="#card-accord">
                                            <div class="accordion-body">
                                                <p>
                                                    <?=LANGUAGE_ID=='ua'?'Термін дії сертифіката 3 місяці з дати отримання листа.<br> Якщо сума чека перевищує номінал сертифіката — необхідно доплатити різницю. Доплату можна здійснити на сайті або накладеним платежем при отриманні замовлення. Якщо сума чека менше номіналу — залишок зберігається на балансі.':'Срок действия сертификата 3 месяца с даты получения письма.<br> Если сумма чека превышает номинал сертификата — необходимо доплатить разницу. Доплату можно осуществить на сайте или наложенным платежом при получении заказа. Если сумма чека меньше номинала — остаток сохраняется на балансе.'?>
                                                </p>
                                                <p>
                                                    <?=LANGUAGE_ID=='ua'?'Сертифікат не підлягає поверненню та обміну на грошові кошти.<br> Сертифікатом можна скористатися лише на сайті stimma.com.ua та в <a href="#">офіційному інстаграмі</a>.':'Сертификат не подлежит возврату и обмену на денежные средства.<br> Сертификатом можно воспользоваться только на сайте stimma.com.ua и в <a href="#">официальном инстаграме</a>.'?>
                                                </p>
                                                <p>
                                                    <?=LANGUAGE_ID=='ua'?'Сертифікат діє на всі позиції представлені на сайті за умови наявності товару.':'Сертификат действует на все позиции представленные на сайте при условии наличия товара.'?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card-accord13" aria-expanded="false" aria-controls="card-accord13">
                                                <?=LANGUAGE_ID=='ua'?'Доставка':'Доставка'?>
                                            </button>
                                        </div>
                                        <div id="card-accord13" class="accordion-collapse collapse" data-bs-parent="#card-accord">
                                            <div class="accordion-body">
                                                <p>
                                                    <?=LANGUAGE_ID=='ua'?'Термін дії сертифіката 3 місяці з дати отримання листа.<br> Якщо сума чека перевищує номінал сертифіката — необхідно доплатити різницю. Доплату можна здійснити на сайті або накладеним платежем при отриманні замовлення. Якщо сума чека менше номіналу — залишок зберігається на балансі.':'Срок действия сертификата 3 месяца с даты получения письма.<br> Если сумма чека превышает номинал сертификата — необходимо доплатить разницу. Доплату можно осуществить на сайте или наложенным платежом при получении заказа. Если сумма чека меньше номинала — остаток сохраняется на балансе.'?>
                                                </p>
                                                <p>
                                                    <?=LANGUAGE_ID=='ua'?'Сертифікат не підлягає поверненню та обміну на грошові кошти.<br> Сертифікатом можна скористатися лише на сайті stimma.com.ua та в <a href="#">офіційному інстаграмі</a>.':'Сертификат не подлежит возврату и обмену на денежные средства.<br> Сертификатом можно воспользоваться только на сайте stimma.com.ua и в <a href="#">официальном инстаграме</a>.'?>
                                                </p>
                                                <p>
                                                    <?=LANGUAGE_ID=='ua'?'Сертифікат діє на всі позиції представлені на сайті за умови наявності товару.':'Сертификат действует на все позиции представленные на сайте при условии наличия товара.'?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                        }
                        else
                        {
                            ?>
                            <div class="card-prop-block">
                                <div class="card-size-block" data-entity="scu-values" data-code="RAZMER" style="<?=$isAcsesuaries || $bonusProduct ? 'display:none;' : ''?>">
                                    <?

                                    $sizes = $sizesSetka = [];
                                    foreach ($arResult['OFFERS'] as $indexOFfer => $offer)
                                    {
                                        if($offer['skip']) continue;
                                        $sizes[$arResult['SORTING_SIZES'][mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE'])]] = ['offer_id' => $offer['ID'], 'value' => mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE'])];
                                        $sizes[$arResult['SORTING_SIZES'][mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE'])]]['active'] = $arResult['SELECTED_OFFER'] == $indexOFfer ? true : false;
                                        $sizesSetka[mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE'])] = mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE']);
                                    }

                                    ksort($sizes);
                                    if($isSert)
                                        $sizes = $sizesSert;

                                    $isActive = false;
                                    foreach ($sizes as $indexOFfer => $value)
                                    {
                                        if($value['active']) $isActive=true;
                                    }

                                    $sizes = array_values($sizes);
                                    if(!$isActive) $sizes[0]['active'] = true;

                                    foreach ($sizes as $indexOFfer => $value)
                                    {
                                        ?>
                                        <label>
                                            <input type="radio" name="card-radio" <?=$value['active'] ? 'checked' : ''?>>
                                            <span class="card-size-item" data-entity="scu-value" data-id="<?=mb_strtolower($value['offer_id'])?>" data-img="<?=$value['imag']?>" data-img2="<?=$value['imag_2']?>" data-original="<?=$value['original']?>">
                                            <?=$value['value']?>
                                        </span>
                                        </label>
                                        <?
                                    }
                                    ?>
                                </div>
                                <?if(isset($_GET['new_color']) || true)
                                {?>
                                    <div class="card-color-type-block">
                                        <div class="card-color-type-title">
                                            Колір: <span><?=$arResult['COLOR_LIST'][$arResult['PROPERTIES']['COLOR']['VALUE']]?></span>
                                        </div>
                                        <div class="card-color-type-list">
                                            <?
                                            foreach($arResult['PICTURE_VARIANTS'] as $colorXmlid => $pVariant)
                                            {
                                                ?>
                                                <a href="<?=$pVariant['url']?>" class="<?=$colorXmlid == $arResult['PROPERTIES']['COLOR']['VALUE'] ? 'active' : ''?>">
                                                    <img src="<?=$pVariant['img']?>">
                                                </a>
                                                <?
                                            }
                                            ?>
                                            <?/*
                                            <a href="#" class="active">
                                                <img src="/upload/resize_cache/iblock/cfa/960_1344_1/hdmrlv2e3ka9o3ohkah1cgp0bztnjiiv.png">
                                            </a>
                                            <a href="#">
                                                <img src="/upload/resize_cache/iblock/cfa/960_1344_1/hdmrlv2e3ka9o3ohkah1cgp0bztnjiiv.png">
                                            </a>
                                            */?>
                                        </div>
                                    </div>
                                <?}else{?>
                                    <div class="card-color-block">
                                        <?
                                        $nameColor = LANGUAGE_ID == 'ua' ? 'Колір' : 'Цвет';
                                        foreach ($arResult['COLOR_VARIANTS'] as $colorXmlid => $colorLink)
                                        {
                                            ?>
                                            <label>
                                                <input type="radio" name="color-radio" <?=$colorXmlid == $arResult['PROPERTIES']['COLOR']['VALUE'] ? 'checked' : ''?>>
                                                <a class="card-color-item <?=strtoupper($arResult['ALL_MAIN_COLORS'][$colorXmlid]) == '#FFFFFF' ? 'white' : ''?>"
                                                   style="background: <?=$arResult['ALL_COLORS'][$colorXmlid]?>;"
                                                   aria-label="<?=$arResult['COLOR_LIST'][$colorXmlid]?> <?=$nameColor?>"
                                                   href="<?=$colorLink?>">

                                                </a>
                                            </label>
                                            <?
                                        }
                                        ?>
                                    </div>

                                <?}?>
                            </div>
                            <?

                            if(UA && isset($arResult['OFFERS'][0]['PROPERTIES']['WAITTIME_'.strtoupper(LANGUAGE_ID)]) && trim($arResult['OFFERS'][0]['PROPERTIES']['WAITTIME_'.strtoupper(LANGUAGE_ID)]['VALUE']) != '')
                            {
                                ?>
                                <div class="card-delivery-info">
                                    <?= $arResult['OFFERS'][0]['PROPERTIES']['WAITTIME_'.strtoupper(LANGUAGE_ID)]['VALUE'] ?>
                                    <?/*Збільшений термін очікування — <span>14-21 робочих днів</span>*/?>
                                </div>
                                <?
                            }
                            ?>
                            <div class="card-buy-btn-block">
                                <?
                                if($arResult['SKIP_OFFERS'])
                                {
                                    ?>
                                    <a href="#" class="info-btn info-btn-black"
                                       onclick="return false;"
                                    >
                                        <?=UA ? 'Немає в наявності' : 'Нет в наличии'?>
                                    </a>
                                    <?
                                }
                                elseif($arResult['IBLOCK_SECTION_ID'] == 1311)
                                {
                                    ?>
                                    <a href="#" class="info-btn info-btn-black buy_product"
                                       onclick="addToCartEK(<?=$arResult['ID']?>, '<?=addslashes($itemName)?>', <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', 1,'add_to_cart', true, 'Item View', 1,<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>);"
                                       data-id="<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['ID']?>"
                                    >
                                        Додати до кошика у
                                        <span class="icon">
                                        <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <ellipse cx="13" cy="13.0586" rx="13" ry="13.0586" fill="currentcolor"/>
                                            <path class="white-color" d="M12.6593 20.0081C11.6873 20.0081 10.8773 19.8579 10.2293 19.5574C9.5813 19.2445 9.0953 18.8064 8.7713 18.2431C8.4473 17.6673 8.2853 16.985 8.2853 16.1964C8.2853 16.0212 8.2913 15.8522 8.3033 15.6895C8.3273 15.5142 8.3633 15.3452 8.4113 15.1825H7.5293V13.793H9.0953C9.2033 13.6553 9.3233 13.5302 9.4553 13.4175C9.5873 13.2923 9.7253 13.1734 9.8693 13.0607C10.0253 12.9481 10.1873 12.8417 10.3553 12.7415C10.5233 12.6289 10.6973 12.5287 10.8773 12.4411H7.5293V11.0517H13.5413C13.6973 10.9014 13.8113 10.7324 13.8833 10.5447C13.9673 10.3444 14.0093 10.1191 14.0093 9.86873C14.0093 9.59334 13.9433 9.36176 13.8113 9.17399C13.6913 8.98623 13.5113 8.84227 13.2713 8.74213C13.0313 8.64199 12.7313 8.59192 12.3713 8.59192C12.0473 8.59192 11.7233 8.62321 11.3993 8.6858C11.0873 8.74839 10.7573 8.83602 10.4093 8.94867C10.0613 9.06133 9.6893 9.20529 9.2933 9.38054L8.4833 7.1649C9.1073 6.87699 9.7553 6.65168 10.4273 6.48895C11.1113 6.3137 11.8313 6.22607 12.5873 6.22607C13.4273 6.22607 14.1473 6.37003 14.7473 6.65794C15.3593 6.93332 15.8333 7.34641 16.1693 7.89719C16.5053 8.44797 16.6733 9.12392 16.6733 9.92506C16.6733 10.1253 16.6613 10.3194 16.6373 10.5071C16.6133 10.6949 16.5773 10.8764 16.5293 11.0517H17.4473V12.4411H15.7733C15.6413 12.5913 15.4913 12.7353 15.3233 12.873C15.1673 12.9982 14.9993 13.1171 14.8193 13.2297C14.6513 13.3299 14.4713 13.43 14.2793 13.5302C14.0993 13.6178 13.9133 13.7054 13.7213 13.793H17.4473V15.1825H11.2913C11.1713 15.3202 11.0813 15.4767 11.0213 15.6519C10.9733 15.8146 10.9493 15.9961 10.9493 16.1964C10.9493 16.4969 11.0153 16.7597 11.1473 16.985C11.2913 17.1978 11.5013 17.3668 11.7773 17.492C12.0653 17.6047 12.4133 17.661 12.8213 17.661C13.4693 17.661 14.1053 17.5859 14.7293 17.4357C15.3533 17.2729 15.9773 17.0601 16.6013 16.7973V19.1631C16.0853 19.426 15.4913 19.6325 14.8193 19.7828C14.1473 19.933 13.4273 20.0081 12.6593 20.0081Z" fill="#1E1E1E"/>
                                        </svg>
                                    </span>
                                    </a>
                                    <?
                                    if($arResult['IBLOCK_SECTION_ID'] == 1311)
                                    {
                                        ?>
                                        <a href="#" class="info-btn buy_product in_s"
                                           onclick="addToCartEK(<?=$arResult['ID']?>, '<?=addslashes($itemName)?>', <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', 1,'add_to_cart', true, 'Item View', 1,<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>);"
                                           data-id="<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['ID']?>"
                                        >
                                            Додати до кошика у
                                            <span class="icon">
                                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="13" cy="13" r="13" fill="currentcolor"/>
                                            <path class="black-color" d="M19.4537 15.2175C19.4537 15.8365 19.3381 16.3827 19.1113 16.8422C18.8865 17.2954 18.5833 17.6831 18.207 17.9969C17.8434 18.3001 17.4193 18.5462 16.9454 18.7268C16.4991 18.8969 16.0242 19.03 15.5355 19.123C15.0542 19.2138 14.5612 19.2741 14.0714 19.3015C13.5933 19.33 13.1322 19.3438 12.6996 19.3438C11.5632 19.3438 10.4935 19.2487 9.52136 19.0617C8.55347 18.8747 7.6831 18.6392 6.93571 18.3592L6.57315 18.2229V14.2308L7.40323 14.6903C8.10079 15.0748 8.90967 15.3823 9.80866 15.6009C10.714 15.8217 11.6978 15.9337 12.7325 15.9337C13.3399 15.9337 13.8361 15.902 14.2071 15.8407C14.646 15.7668 14.8877 15.6823 15.0128 15.6242C15.1983 15.5386 15.2439 15.4794 15.245 15.4794C15.262 15.453 15.2704 15.4351 15.2736 15.4256C15.2694 15.4235 15.2577 15.4108 15.2365 15.3939C15.1591 15.3305 15.0096 15.2354 14.7351 15.1382C14.4775 15.0463 14.1668 14.9597 13.8149 14.8805C13.4449 14.7981 13.0505 14.7146 12.635 14.6322C12.2109 14.5477 11.7752 14.4558 11.3268 14.3586C10.8656 14.2572 10.4129 14.1368 9.97934 14.0005C9.53833 13.8621 9.11322 13.6973 8.71779 13.5114C8.3001 13.3149 7.92587 13.0772 7.60677 12.8057C7.27071 12.5183 7.00144 12.1803 6.80532 11.801C6.60283 11.407 6.5 10.9517 6.5 10.4478C6.5 9.8731 6.60707 9.36286 6.81698 8.93185C7.0237 8.50611 7.30782 8.13849 7.66084 7.83847C8.00114 7.54901 8.39763 7.31238 8.8397 7.13384C9.25633 6.96482 9.70159 6.83171 10.1627 6.73875C10.6133 6.6479 11.0755 6.58451 11.5356 6.55071C11.9883 6.5169 12.424 6.5 12.83 6.5C13.2785 6.5 13.747 6.52324 14.222 6.56761C14.6916 6.61198 15.1634 6.67536 15.6213 6.75671C16.074 6.83594 16.5203 6.92996 16.9497 7.0356C17.3737 7.14124 17.7734 7.25322 18.1381 7.37048L18.525 7.49513V11.3711L17.7215 10.9813C17.5285 10.8873 17.2624 10.7763 16.9317 10.6527C16.6041 10.5302 16.2246 10.4119 15.8047 10.3009C15.386 10.19 14.9238 10.096 14.4308 10.021C13.9442 9.94705 13.4385 9.91008 12.9276 9.91008C12.513 9.91008 12.1558 9.92275 11.8664 9.94811C11.5823 9.97346 11.3437 10.0062 11.1571 10.0442C10.9504 10.0865 10.8402 10.1277 10.784 10.1531C10.766 10.1615 10.7511 10.1689 10.7373 10.1763C10.8243 10.2333 10.9695 10.3083 11.2017 10.3865C11.4646 10.4742 11.7763 10.5598 12.1303 10.639C12.5035 10.7225 12.8989 10.808 13.3166 10.8968C13.7417 10.9866 14.1796 11.0848 14.6312 11.1915C15.0945 11.3003 15.5493 11.4292 15.9828 11.575C16.427 11.7229 16.8532 11.8982 17.2476 12.0947C17.6631 12.3018 18.0352 12.549 18.3533 12.8289C18.6883 13.1247 18.9565 13.4702 19.1505 13.8568C19.3519 14.2582 19.4537 14.7157 19.4537 15.2175Z" fill="white"/>
                                        </svg>
                                    </span>
                                        </a>
                                        <?
                                    }
                                    ?>

                                    <?
                                }
                                else
                                {
                                    ?>
                                    <a href="#" class="info-btn info-btn-black buy_product"
                                       onclick="addToCartEK(<?=$arResult['ID']?>, '<?=addslashes($itemName)?>', <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', 1,'add_to_cart', true, 'Item View', 1,<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>);"
                                       data-id="<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['ID']?>"
                                    >
                                        <?=UA ? 'Додати до кошика' : 'Добавить у корзину'?>
                                    </a>
                                    <?
                                }
                                ?>
                            </div>
                            <?
                            if(LANGUAGE_ID == 'ua')
                                $fromTo2 = [
                                    '. '.PHP_EOL.'Параметри' => '.<br><br> Параметри',
                                    '.'.PHP_EOL.'Параметри' => '.<br><br> Параметри',
                                    '. Параметри' => '.<br><br> Параметри',
                                    'Параметри моделі' => 'Параметри моделі:<br>',
                                    'Зріст' => 'Зріст',
                                    'На моделі розмір' => '<br>На моделі розмір',
                                    ' - ' => ' - '.PHP_EOL,
                                    ';' => ';'.PHP_EOL,
                                    '.' => '.'.PHP_EOL,
                            ];
                            else
                                $fromTo2 = [
                                    '. '.PHP_EOL.'Параметри' => '.<br><br> Параметры',
                                    '.'.PHP_EOL.'Параметри' => '.<br><br> Параметры',
                                    '. Параметри' => '.<br><br> Параметры',
                                    'Параметри моделі' => 'Параметры модели:<br>',
                                    'Зріст' => 'Рост',
                                    'На моделі розмір' => '<br>На модели размер',
                                    ' - ' => ' - '.PHP_EOL,
                                    ';' => ';'.PHP_EOL,
                                    '.' => '.'.PHP_EOL,
                            ];
                            ?>
                            <div class="card-accordion-block">
                            <div class="accordion accordion-flush" id="card-accord">
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card-accord1" aria-expanded="false" aria-controls="card-accord1">
                                            Опис товару
                                        </button>
                                    </div>
                                    <div id="card-accord1" class="accordion-collapse collapse" data-bs-parent="#card-accord">
                                        <div class="accordion-body">
                                            <?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['DETAIL_TEXT_UA']['~VALUE']['TEXT'] : $arResult['DETAIL_TEXT']?>
                                        </div>
                                    </div>
                                </div>
                                <?
                                //if($arResult['OFFERS'][0]['PROPERTIES']['SOSTAV_SITE_'.strtoupper(LANGUAGE_ID)]['VALUE'])
                                {
                                    ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card-accord2" aria-expanded="false" aria-controls="card-accord2">
                                                <?=LANGUAGE_ID=='ua'?'Характеристики товару':'Характеристики товара'?>
                                            </button>
                                        </div>
                                        <div id="card-accord2" class="accordion-collapse collapse" data-bs-parent="#card-accord">
                                            <div class="accordion-body">
                                                <p>
                                                    <?
                                                    if($arResult['OFFERS'][0]['PROPERTIES']['SOSTAV_SITE_'.strtoupper(LANGUAGE_ID)]['VALUE'])
                                                    {
                                                        $arResult['OFFERS'][0]['DISPLAY_PROPERTIES']['SOSTAV']['VALUE'] = $arResult['OFFERS'][0]['PROPERTIES']['SOSTAV_SITE_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                                                    }
                                                    foreach ($arResult['OFFERS'][0]['DISPLAY_PROPERTIES'] as $index => $arProp)
                                                    {
                                                        if(!$arProp['VALUE']) continue;
                                                        if($arProp['CODE'] != 'MATERIAL' && $arProp['CODE'] != 'SOSTAV' && $arProp['CODE'] != 'COLOR_REF') continue;
                                                        if($arProp['CODE'] == 'COLOR_REF' && LANGUAGE_ID == 'ru') $arProp['VALUE'] = $arProp['DISPLAY_VALUE'];
                                                        ?>
                                                        <p style="margin: 1px 0;color:black;" code="<?=$arProp['CODE']?>"><?=$arProp['NAME']?>: <span style="color:#333333;"><?=is_array($arProp['VALUE']) ? implode(', ',$arProp['VALUE']) : $arProp['VALUE']?></span></p>
                                                        <?
                                                    }
                                                    ?>
                                                </p>
                                                <?
                                                if($arResult['OFFERS'][0]['PROPERTIES']['TEXT_MATERIAL_'.strtoupper(LANGUAGE_ID)]['VALUE'])
                                                {
                                                    ?><p><i><?=$arResult['OFFERS'][0]['PROPERTIES']['TEXT_MATERIAL_'.strtoupper(LANGUAGE_ID)]['VALUE']?></i></p><?
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }
                                ?>

                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card-accord3" aria-expanded="false" aria-controls="card-accord3">
                                            <?=LANGUAGE_ID=='ua'?'Доставка та оплата':'Доставка и оплата'?>
                                        </button>
                                    </div>
                                    <div id="card-accord3" class="accordion-collapse collapse" data-bs-parent="#card-accord">
                                        <div class="accordion-body">
                                            <?
                                            if(LANGUAGE_ID == 'ua')
                                            {
                                                ?>

                                                <p>Здійснюємо доставку по всій території України, за винятком тимчасово окупованих територій.</p>
                                                <p><b>Замовлення відправляються службами:</b></p>
                                                <ul>
                                                    <li>Нова Пошта (відділення/поштомат/адресна доставка кур’єром)</li>
                                                    <li>Укрпошта</li>
                                                </ul>
                                                <p>Відправлення замовлень здійснюється до <b>5 робочих днів</b> після підтвердження оплати. Якщо замовлення потрібне до певної дати, вкажіть це при оформленні.</p>
                                                <p>Вартість доставки визначається відповідно до тарифів обраного перевізника тa oплaчуєтьcя пpи oтpимaнні. Після прибуття посилки до відділення перевізника <b>просимо отримати її протягом 5 днів</b>. Якщо замовлення не буде забране у встановлений термін, воно автоматично повертається до інтернет-магазину.</p>
                                                <p><b>ОПЛАТА:</b></p>
                                                <p>Оплатити замовлення можна онлайн банківською карткою <b>Visa</b> або <b>Mastercard</b> під час оформлення покупки на сайті.</p>
                                                <p>Платежі здійснюються через захищений сервіс <b>iPay.ua</b>, що гарантує безпеку та конфіденційність фінансових операцій.</p>
                                                <p><b>Доступні варіанти оплати:</b></p>
                                                <ul>
                                                    <li>— повна онлайн-оплата замовлення банківською карткою;</li>
                                                    <li>—післяплата (оплата при отриманні). Лише при передоплаті 200 грн через iPay з подальшою доплатою.</li>
                                                    <li>—  покупка частинами monobank | Universal Bank та Приват Банк</li>
                                                </ul>
                                                <p><b>Зверніть увагу:</b> служба доставки може стягувати додаткову комісію за післяплату.</p>

                                                <?
                                            }
                                            else
                                            {
                                                ?>
                                                <p>Осуществляем доставку по всей территории Украины, за исключением временно оккупированных территорий.</p>
                                                <p><b>Заказы отправляются службами:</b></p>
                                                <ul>
                                                <li>Новая Почта (отделение/почтомат/адресная доставка курьером)</li>
                                                <li>Укрпочта</li>
                                                </ul>
                                                <p>Отправка заказов осуществляется до <b>5 рабочих дней</b> после подтверждения оплаты. Если заказ нужен к определенной дате, укажите это при оформлении.</p>
                                                <p>Стоимость доставки определяется в соответствии с тарифами выбранного перевозчика и оплачивается при получении. После прибытия посылки в отделение перевозчика <b>просим получить ее в течение 5 дней</b>. Если заказ не будет забрать в установленный срок, он автоматически возвращается в интернет-магазин.</p>
                                                <p><b>ОПЛАТА:</b></p>
                                                <p>Оплатить заказ можно онлайн банковской картой <b>Visa</b> или <b>Mastercard</b> при оформлении покупки на сайте.</p>
                                                <p>Платежи осуществляются через защищенный сервис <b>iPay.ua</b>, что гарантирует безопасность и конфиденциальность финансовых операций.</p>
                                                <p><b>Доступные варианты оплаты:</b></p>
                                                <ul>
                                                    <li>полная онлайн-оплата заказа банковской картой;</li>
                                                    <li>послеплата (оплата при получении). Только при предоплате 200 грн через iPay с последующей доплатой.</li>
                                                    <li>покупка в рассрочку в monobank | Universal Bank и ПриватБанк.</li>
                                                </ul>
                                                <p><b>Обратите внимание:</b> служба доставки может взимать дополнительную комиссию за послеплату.</p>

                                                <?
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?
                                if(!$isAcsesuaries && !$shoes)
                                {
                                    if(isset($_GET['sitka']))
                                    {
                                        ?><pre><?=print_r($sizesSetka, 1)?></pre><?
                                    }
                                    ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card-accord4" aria-expanded="false" aria-controls="card-accord4">
                                                <?=LANGUAGE_ID=='ua' ? 'Розмірна сітка' : 'Размерная сетка'?>
                                            </button>
                                        </div>
                                        <div id="card-accord4" class="accordion-collapse collapse" data-bs-parent="#card-accord">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <?
                                                    if(
                                                            isset($sizesSetka['XXS']) ||
                                                            isset($sizesSetka['XS']) ||
                                                            isset($sizesSetka['S']) ||
                                                            isset($sizesSetka['M']) ||
                                                            isset($sizesSetka['L']) ||
                                                            isset($sizesSetka['XL']) ||
                                                            isset($sizesSetka['XXL']) ||
                                                            isset($sizesSetka['ONE SIZE']) ||
                                                            isset($sizesSetka['32']) ||
                                                            isset($sizesSetka['34']) ||
                                                            isset($sizesSetka['36']) ||
                                                            isset($sizesSetka['38']) ||
                                                            isset($sizesSetka['40']) ||
                                                            isset($sizesSetka['42']) ||
                                                            isset($sizesSetka['44'])
                                                    )
                                                        {
                                                            ?>
                                                            <table class="table-border">
                                                                <tbody>
                                                                <tr>
                                                                    <th colspan="2" style="text-align: center;"><?=LANGUAGE_ID=='ua' ? 'Розмір' : 'Размер'?></th>
                                                                    <th><?=LANGUAGE_ID=='ua' ? 'Обхват грудей' : 'Обхват груди'?></th>
                                                                    <th><?=LANGUAGE_ID=='ua' ? 'Обхват талії' : 'Обхват талии'?></th>
                                                                    <th><?=LANGUAGE_ID=='ua' ? 'Обхват стегон' : 'Обхват бедер'?></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>32</td>
                                                                    <td>XXS</td>
                                                                    <td>76-80</td>
                                                                    <td>58-62</td>
                                                                    <td>86-90</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>34</td>
                                                                    <td>XS</td>
                                                                    <td>80-84</td>
                                                                    <td>62-66</td>
                                                                    <td>90-94</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>36</td>
                                                                    <td>S</td>
                                                                    <td>84-88</td>
                                                                    <td>66-70</td>
                                                                    <td>94-98</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>38</td>
                                                                    <td>M</td>
                                                                    <td>88-92</td>
                                                                    <td>70-74</td>
                                                                    <td>98-102</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>40</td>
                                                                    <td>L</td>
                                                                    <td>92-96</td>
                                                                    <td>74-78</td>
                                                                    <td>102-106</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>42</td>
                                                                    <td>XL</td>
                                                                    <td>96-100</td>
                                                                    <td>78-82</td>
                                                                    <td>106-110</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>44</td>
                                                                    <td>XXL</td>
                                                                    <td>100-104</td>
                                                                    <td>82-86</td>
                                                                    <td>110-114</td>
                                                                </tr>

                                                                </tbody>
                                                            </table>
                                                            <?
                                                        }
                                                    elseif (
                                                        isset($sizesSetka['XXS-XS']) ||
                                                        isset($sizesSetka['S-M']) ||
                                                        isset($sizesSetka['L-XL']) ||
                                                        isset($sizesSetka['32-34']) ||
                                                        isset($sizesSetka['36-38']) ||
                                                        isset($sizesSetka['40-42'])
                                                    )
                                                         {
                                                             ?>
                                                             <table class="table-border">
                                                                 <tbody>
                                                                 <tr>
                                                                     <th colspan="2" style="text-align: center;"><?=LANGUAGE_ID=='ua' ? 'Розмір' : 'Размер'?></th>
                                                                     <th><?=LANGUAGE_ID=='ua' ? 'Обхват грудей' : 'Обхват груди'?></th>
                                                                     <th><?=LANGUAGE_ID=='ua' ? 'Обхват талії' : 'Обхват талии'?></th>
                                                                     <th><?=LANGUAGE_ID=='ua' ? 'Обхват стегон' : 'Обхват бедер'?></th>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>32-34</td>
                                                                     <td>XXS-XS</td>
                                                                     <td>76-84</td>
                                                                     <td>58-66</td>
                                                                     <td>86-94</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>36-38</td>
                                                                     <td>S-М</td>
                                                                     <td>84-92</td>
                                                                     <td>66-74</td>
                                                                     <td>94-102</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>40-42</td>
                                                                     <td>L- XL</td>
                                                                     <td>92-100</td>
                                                                     <td>74-82</td>
                                                                     <td>102-110</td>
                                                                 </tr>
                                                                 </tbody>
                                                             </table>
                                                             <?
                                                         }
                                                    elseif (
                                                        isset($sizesSetka['XS-S']) ||
                                                        isset($sizesSetka['M-L']) ||
                                                        isset($sizesSetka['XL- XXL']) ||
                                                        isset($sizesSetka['34-36']) ||
                                                        isset($sizesSetka['38-40']) ||
                                                        isset($sizesSetka['42-44'])
                                                    )
                                                        {
                                                            ?>
                                                            <table class="table-border">
                                                                <tbody>
                                                                <tr>
                                                                    <th colspan="2" style="text-align: center;"><?=LANGUAGE_ID=='ua' ? 'Розмір' : 'Размер'?></th>
                                                                    <th><?=LANGUAGE_ID=='ua' ? 'Обхват грудей' : 'Обхват груди'?></th>
                                                                    <th><?=LANGUAGE_ID=='ua' ? 'Обхват талії' : 'Обхват талии'?></th>
                                                                    <th><?=LANGUAGE_ID=='ua' ? 'Обхват стегон' : 'Обхват бедер'?></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>34-36</td>
                                                                    <td>XS- S</td>
                                                                    <td>80-88</td>
                                                                    <td>62-70</td>
                                                                    <td>90-98</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>38-40</td>
                                                                    <td>M- L</td>
                                                                    <td>88-96</td>
                                                                    <td>70-78</td>
                                                                    <td>98-106</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>42-44</td>
                                                                    <td>XL- XXL</td>
                                                                    <td>96-104</td>
                                                                    <td>78-86</td>
                                                                    <td>106-114</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <?
                                                        }
                                                    else
                                                        {
                                                            ?>
                                                            <table class="table-border">
                                                                <tbody><tr>
                                                                    <th colspan="2" style="text-align: center;"><?=LANGUAGE_ID=='ua' ? 'Розмір' : 'Размер'?></th>
                                                                    <th><?=LANGUAGE_ID=='ua' ? 'Обхват грудей' : 'Обхват груди'?></th>
                                                                    <th><?=LANGUAGE_ID=='ua' ? 'Обхват талії' : 'Обхват талии'?></th>
                                                                    <th><?=LANGUAGE_ID=='ua' ? 'Обхват стегон' : 'Обхват бедер'?></th>
                                                                <tr>
                                                                    <td>32</td>
                                                                    <td>XXS</td>
                                                                    <td>76-80</td>
                                                                    <td>58-62</td>
                                                                    <td>86-90</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>34</td>
                                                                    <td>XS</td>
                                                                    <td>80-84</td>
                                                                    <td>62-66</td>
                                                                    <td>90-94</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>36</td>
                                                                    <td>S</td>
                                                                    <td>84-88</td>
                                                                    <td>66-70</td>
                                                                    <td>94-98</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>38</td>
                                                                    <td>M</td>
                                                                    <td>88-92</td>
                                                                    <td>70-74</td>
                                                                    <td>98-102</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>40</td>
                                                                    <td>L</td>
                                                                    <td>92-96</td>
                                                                    <td>74-78</td>
                                                                    <td>102-106</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>42</td>
                                                                    <td>XL</td>
                                                                    <td>96-100</td>
                                                                    <td>78-82</td>
                                                                    <td>106-110</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>44</td>
                                                                    <td>XXL</td>
                                                                    <td>100-104</td>
                                                                    <td>82-86</td>
                                                                    <td>110-114</td>
                                                                </tr>
                                                                </tr>
                                                                <?/*
                                                        <tr>
                                                            <td>40</td>
                                                            <td>XS</td>
                                                            <td>80-84</td>
                                                            <td>62-66</td>
                                                            <td>90-94</td>
                                                        </tr>
                                                        <tr>
                                                            <td>42</td>
                                                            <td>S</td>
                                                            <td>84-88</td>
                                                            <td>66-70</td>
                                                            <td>94-98</td>
                                                        </tr>
                                                        <tr>
                                                            <td>44</td>
                                                            <td>M</td>
                                                            <td>88-92</td>
                                                            <td>70-74</td>
                                                            <td>98-102</td>
                                                        </tr>
                                                        <tr>
                                                            <td>46</td>
                                                            <td>L</td>
                                                            <td>92-96</td>
                                                            <td>74-78</td>
                                                            <td>102-106</td>
                                                        </tr>
                                                        <tr>
                                                            <td>48</td>
                                                            <td>XL</td>
                                                            <td>96-100</td>
                                                            <td>78-82</td>
                                                            <td>106-110</td>
                                                        </tr>
                                                        <tr>
                                                            <td>50</td>
                                                            <td>XXL</td>
                                                            <td>100-104</td>
                                                            <td>82-86</td>
                                                            <td>110-114</td>
                                                        </tr>
                                                        */?>
                                                                </tbody>
                                                            </table>
                                                            <?
                                                        }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }
                                ?>

                                <?
                                if($arResult['TABLE'])
                                {
                                    ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card-accord5" aria-expanded="false" aria-controls="card-accord5">
                                                <?=LANGUAGE_ID=='ua' ? 'Заміри виробу' : 'Замеры изделия'?>
                                            </button>
                                        </div>
                                        <div id="card-accord5" class="accordion-collapse collapse" data-bs-parent="#card-accord">
                                            <div class="accordion-body table-responsive">
                                                <table>
                                                    <?
                                                    foreach ($arResult['TABLE'] as $index => $items)
                                                    {
                                                        ?>
                                                        <tr>
                                                            <?
                                                            foreach ($items as $index2 => $item)
                                                            {
                                                                ?><td><?=!$index && !$index2 ?  ''  : $item?></td><?
                                                            }
                                                            ?>
                                                        </tr>
                                                        <?
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }

                                if($arResult['OFFERS'][0]['PROPERTIES']['RAZMERNOST_'.strtoupper(LANGUAGE_ID)]['VALUE'] || $arResult['OFFERS'][0]['PROPERTIES']['PARAM_MODEL']['VALUE'])
                                {
                                    ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card-accord6" aria-expanded="false" aria-controls="card-accord6">
                                                Параметри моделі
                                            </button>
                                        </div>
                                        <div id="card-accord6" class="accordion-collapse collapse" data-bs-parent="#card-accord">
                                            <div class="accordion-body">
                                                <p style="margin-top: 15px;color: black;"><?=str_replace(array_keys($fromTo2), $fromTo2, $arResult['OFFERS'][0]['PROPERTIES']['PARAM_MODEL']['VALUE']);?></p>
                                                <p><?=$arResult['OFFERS'][0]['PROPERTIES']['RAZMERNOST_'.strtoupper(LANGUAGE_ID)]['VALUE']?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }
                                ?>

                            </div>
                        </div>
                            <?
                        }
                        ?>
                    </div>
                </div>
                <div class="card-mob-controls-cont">
                    <div class="card-mob-controls-block">
                        
                        <div class="card-mob-btn-buy">
                            <?
                            if($arResult['SKIP_OFFERS'])
                            {
                                ?>
                                <a href="#" class="info-btn info-btn-black"
                                   onclick="return false;"
                                >
                                    <?=UA ? 'Немає в наявності' : 'Нет в наличии'?>
                                </a>
                                <?
                            }
                            else
                            {
                                if($arResult['IBLOCK_SECTION_ID'] == 1311)
                                {
                                    ?>
                                    <button type="button" class="info-btn info-btn-black buy_mobile_button" data-bs-toggle="modal" data-bs-target="#buy_za_stimz" data-id="<?=$arResult['ID']?>">
                                        <?=LANGUAGE_ID=='ua'?'Додати до кошика':'Добавить в корзину'?>
                                    </button>
                                    <?
                                }
                                else
                                {
                                    ?>
                                    <a href="#" class="info-btn info-btn-black buy_product"
                                       onclick="addToCartEK(<?=$arResult['ID']?>, '<?=addslashes($itemName)?>', <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', 1,'add_to_cart', true, 'Item View', 1,<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>);"
                                       data-id="<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['ID']?>"
                                    >
                                        <?=LANGUAGE_ID=='ua'?'Додати до кошика':'Добавить в корзину'?>
                                    </a>
                                    <?
                                }
                                ?>

                                <?
                            }
                            ?>

                        </div>
                    </div>
                </div>

            </div>

        </div>

<?
if(!empty($dopObrazElement))
{
    global $MAX_SMART_FILTER;
    $MAX_SMART_FILTER['ID'] = $dopObrazElement;
    //$MAX_SMART_FILTER['>catalog_QUANTITY'] = 0;
    ?>
        <div class="wrapper">
    <div class="search-goods-ex-cont catalog-goods-views-cont">
        <div class="catalog-faq-title">
            <?=LANGUAGE_ID=='ua'?'Доповни свій образ:':'Дополни свой образ:'?>
        </div>
        <div class="search-goods-ex-slider-cont">
            <?
            $params = [
                'IBLOCK_TYPE' => 'aspro_max_catalog',
                'IBLOCK_ID' => '21',
                'NO_SLIDER'=>'Y',
                'ELEMENT_SORT_FIELD' => 'ID',
                'ELEMENT_SORT_ORDER' => 'desc',
                'ELEMENT_SORT_FIELD2' => 'sort',
                'ELEMENT_SORT_ORDER2' => 'asc',
                'PROPERTY_CODE' => [
                    0 => 'HIT',
                    1 => 'BRAND',
                    2 => 'CML2_ARTICLE',
                    3 => 'PROP_2104',
                    4 => 'PODBORKI',
                    5 => 'PROP_2033',
                    6 => 'COLOR_REF2',
                    7 => 'PROP_305',
                    8 => 'PROP_352',
                    9 => 'PROP_317',
                    10 => 'PROP_357',
                    11 => 'PROP_2102',
                    12 => 'PROP_318',
                    13 => 'PROP_159',
                    14 => 'PROP_349',
                    15 => 'PROP_327',
                    16 => 'PROP_2052',
                    17 => 'PROP_370',
                    18 => 'PROP_336',
                    19 => 'PROP_2115',
                    20 => 'PROP_346',
                    21 => 'PROP_2120',
                    22 => 'PROP_2053',
                    23 => 'PROP_363',
                    24 => 'PROP_320',
                    25 => 'PROP_2089',
                    26 => 'PROP_325',
                    27 => 'PROP_2103',
                    28 => 'PROP_2085',
                    29 => 'PROP_300',
                    30 => 'PROP_322',
                    31 => 'PROP_362',
                    32 => 'PROP_365',
                    33 => 'PROP_359',
                    34 => 'PROP_284',
                    35 => 'PROP_364',
                    36 => 'PROP_356',
                    37 => 'PROP_343',
                    38 => 'PROP_2083',
                    39 => 'PROP_314',
                    40 => 'PROP_348',
                    41 => 'PROP_316',
                    42 => 'PROP_350',
                    43 => 'PROP_333',
                    44 => 'PROP_332',
                    45 => 'PROP_360',
                    46 => 'PROP_353',
                    47 => 'PROP_347',
                    48 => 'PROP_25',
                    49 => 'PROP_2114',
                    50 => 'PROP_301',
                    51 => 'PROP_2101',
                    52 => 'PROP_2067',
                    53 => 'PROP_323',
                    54 => 'PROP_324',
                    55 => 'PROP_355',
                    56 => 'PROP_304',
                    57 => 'PROP_358',
                    58 => 'PROP_319',
                    59 => 'PROP_344',
                    60 => 'PROP_328',
                    61 => 'PROP_338',
                    62 => 'PROP_2065',
                    63 => 'PROP_366',
                    64 => 'PROP_302',
                    65 => 'PROP_303',
                    66 => 'PROP_2054',
                    67 => 'PROP_341',
                    68 => 'PROP_223',
                    69 => 'PROP_283',
                    70 => 'PROP_354',
                    71 => 'PROP_313',
                    72 => 'PROP_2066',
                    73 => 'PROP_329',
                    74 => 'PROP_342',
                    75 => 'PROP_367',
                    76 => 'PROP_2084',
                    77 => 'PROP_340',
                    78 => 'PROP_351',
                    79 => 'PROP_368',
                    80 => 'PROP_369',
                    81 => 'PROP_331',
                    82 => 'PROP_337',
                    83 => 'PROP_345',
                    84 => 'PROP_339',
                    85 => 'PROP_310',
                    86 => 'PROP_309',
                    87 => 'PROP_330',
                    88 => 'PROP_2017',
                    89 => 'PROP_335',
                    90 => 'PROP_321',
                    91 => 'PROP_308',
                    92 => 'PROP_206',
                    93 => 'PROP_334',
                    94 => 'PROP_2100',
                    95 => 'PROP_311',
                    96 => 'PROP_2132',
                    97 => 'SHUM',
                    98 => 'PROP_361',
                    99 => 'PROP_326',
                    100 => 'PROP_315',
                    101 => 'PROP_2091',
                    102 => 'PROP_2026',
                    103 => 'PROP_307',
                    104 => 'PROP_2027',
                    105 => 'PROP_2098',
                    106 => 'PROP_2122',
                    107 => 'PROP_24',
                    108 => 'PROP_2049',
                    109 => 'PROP_22',
                    110 => 'PROP_2095',
                    111 => 'PROP_2044',
                    112 => 'PROP_162',
                    113 => 'PROP_2055',
                    114 => 'PROP_2069',
                    115 => 'PROP_2062',
                    116 => 'PROP_2061',
                    117 => 'CML2_LINK',
                    118 => 'RZMER',
                    119 => 'SOSTAV_SITE_RU',
                    120 => 'SOSTAV_SITE_UA',
                ],
                'PROPERTY_CODE_MOBILE' => '',
                'META_KEYWORDS' => '-',
                'META_DESCRIPTION' => '-',
                'BROWSER_TITLE' => '-',
                'SET_LAST_MODIFIED' => 'Y',
                'INCLUDE_SUBSECTIONS' => 'Y',
                'BASKET_URL' => '/basket/',
                'ACTION_VARIABLE' => 'action',
                'PRODUCT_ID_VARIABLE' => 'id',
                'SECTION_ID_VARIABLE' => 'SECTION_ID',
                'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
                'PRODUCT_PROPS_VARIABLE' => 'prop',
                'FILTER_NAME' => 'MAX_SMART_FILTER',
                'CACHE_TYPE' => 'A',
                'CACHE_TIME' => '3600000',
                'CACHE_FILTER' => 'Y',
                'CACHE_GROUPS' => 'Y',
                'SET_TITLE' => 'N',
                'MESSAGE_404' => '',
                'SET_STATUS_404' => 'Y',
                'SHOW_404' => 'Y',
                'FILE_404' => '',
                'DISPLAY_COMPARE' => 'Y',
                'PAGE_ELEMENT_COUNT' => '10',
                'LINE_ELEMENT_COUNT' => '4',
                'PRICE_CODE' => [0 => 'BASE',],
                'USE_PRICE_COUNT' => 'N',
                'SHOW_PRICE_COUNT' => '1',
                'PRICE_VAT_INCLUDE' => 'Y',
                'USE_PRODUCT_QUANTITY' => 'Y',
                'ADD_PROPERTIES_TO_BASKET' => 'N',
                'PARTIAL_PRODUCT_PROPERTIES' => 'Y',
                'PRODUCT_PROPERTIES' => '',
                'DISPLAY_TOP_PAGER' => 'N',
                'DISPLAY_BOTTOM_PAGER' => 'N',
                'PAGER_TITLE' => 'Товары',
                'PAGER_SHOW_ALWAYS' => 'N',
                'PAGER_TEMPLATE' => 'main',
                'PAGER_DESC_NUMBERING' => 'N',
                'PAGER_DESC_NUMBERING_CACHE_TIME' => '36000',
                'PAGER_SHOW_ALL' => 'N',
                'PAGER_BASE_LINK_ENABLE' => 'N',
                'PAGER_BASE_LINK' => null,
                'PAGER_PARAMS_NAME' => null,
                'LAZY_LOAD' => 'N',
                'MESS_BTN_LAZY_LOAD' => null,
                'LOAD_ON_SCROLL' => 'N',
                'OFFERS_CART_PROPERTIES' => '',
                'OFFERS_FIELD_CODE' => [0 => 'NAME',
                                        1 => 'CML2_LINK',
                                        2 => 'DETAIL_PAGE_URL',
                                        3 => '',],
                'OFFERS_PROPERTY_CODE' => [0 => 'ARTICLE',
                                           1 => 'SPORT',
                                           2 => 'SIZES2',
                                           3 => 'MORE_PHOTO',
                                           4 => 'VOLUME',
                                           5 => 'SIZES',
                                           6 => 'SIZES5',
                                           7 => 'SIZES4',
                                           8 => 'SIZES3',
                                           9 => 'COLOR_REF',
                                           10 => 'RAZMER',],
                'OFFERS_SORT_FIELD' => 'ID',
                'OFFERS_SORT_ORDER' => 'desc',
                'OFFERS_SORT_FIELD2' => 'sort',
                'OFFERS_SORT_ORDER2' => 'asc',
                'OFFERS_LIMIT' => '10',
                'SECTION_ID' => '',
                'SECTION_CODE' => '',
                'SECTION_URL' => '/catalog/#SECTION_CODE_PATH#/',
                'DETAIL_URL' => '/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
                'USE_MAIN_ELEMENT_SECTION' => 'Y',
                'CONVERT_CURRENCY' => 'Y',
                'CURRENCY_ID' => 'UAH',
                'HIDE_NOT_AVAILABLE' => 'N',
                'HIDE_NOT_AVAILABLE_OFFERS' => 'N',
                'LABEL_PROP' => '',
                'LABEL_PROP_MOBILE' => null,
                'LABEL_PROP_POSITION' => null,
                'ADD_PICT_PROP' => 'MORE_PHOTO',
                'PRODUCT_DISPLAY_MODE' => 'Y',
                'PRODUCT_BLOCKS_ORDER' => 'price,props,sku,quantityLimit,quantity,buttons,compare',
                'PRODUCT_ROW_VARIANTS' => '[{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false}]',
                'ENLARGE_PRODUCT' => 'STRICT',
                'ENLARGE_PROP' => '',
                'SHOW_SLIDER' => 'Y',
                'SLIDER_INTERVAL' => '3000',
                'SLIDER_PROGRESS' => 'N',
                'OFFER_ADD_PICT_PROP' => 'MORE_PHOTO',
                'OFFER_TREE_PROPS' => [0 => 'COLOR_REF',
                                       1 => 'RAZMER',],
                'PRODUCT_SUBSCRIPTION' => 'Y',
                'SHOW_DISCOUNT_PERCENT' => 'Y',
                'DISCOUNT_PERCENT_POSITION' => null,
                'SHOW_OLD_PRICE' => 'Y',
                'SHOW_MAX_QUANTITY' => 'N',
                'MESS_SHOW_MAX_QUANTITY' => '',
                'RELATIVE_QUANTITY_FACTOR' => '',
                'MESS_RELATIVE_QUANTITY_MANY' => '',
                'MESS_RELATIVE_QUANTITY_FEW' => '',
                'MESS_BTN_BUY' => 'Купить',
                'MESS_BTN_ADD_TO_BASKET' => 'В корзину',
                'MESS_BTN_SUBSCRIBE' => 'Подписаться',
                'MESS_BTN_DETAIL' => 'Подробнее',
                'MESS_NOT_AVAILABLE' => 'Нет в наличии',
                'MESS_BTN_COMPARE' => 'Сравнение',
                'USE_ENHANCED_ECOMMERCE' => 'N',
                'DATA_LAYER_NAME' => '',
                'BRAND_PROPERTY' => '',
                'TEMPLATE_THEME' => 'blue',
                'ADD_SECTIONS_CHAIN' => 'N',
                'ADD_TO_BASKET_ACTION' => 'ADD',
                'SHOW_CLOSE_POPUP' => 'N',
                'COMPARE_PATH' => '',
                'COMPARE_NAME' => 'CATALOG_COMPARE_LIST',
                'USE_COMPARE_LIST' => 'Y',
                'BACKGROUND_IMAGE' => '-',
                'COMPATIBLE_MODE' => 'Y',
                'DISABLE_INIT_JS_IN_COMPONENT' => 'N',
                'WRAP_CLASS' => 'main-googs-list',
                'BLOCK_CLASS' => 'main-googs-item-cont',
            ];
            $params['BLOCK_CLASS']= 'search-goods-ex-slider-item';
            $params['WRAP_CLASS']= 'catalog-goods-views-slider';

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "main",
                $params,
                false
            );
            ?>
        </div>
    </div>
        </div>
    <?
}
?>


    <script>
        var treeProps = <?=CUtil::PhpToJSObject($tree['props'])?>;
        var treeOffers = <?=CUtil::PhpToJSObject($tree['offers'])?>;
        var treeOffersIds = <?=CUtil::PhpToJSObject($tree['offers_ids'])?>;
        var selectedOfferID = <?=$arResult['OFFERS'][$selected]['ID']?>;
        var scuProps = <?=CUtil::PhpToJSObject($arParams['OFFER_TREE_PROPS'])?>;
        var variants = <?=CUtil::PhpToJSObject($tree['variants'])?>;
        var offers = <?=CUtil::PhpToJSObject($tree['variants'])?>;
        var jsData = <?=CUtil::PhpToJSObject($arResult['JS_DATA'])?>;
        var $availableTextIn = '<?=$availableTextIn?>';
        var $availableTextOut = '<?=$availableTextOut?>';
    </script>

<?
$slider = [];
foreach ($arResult['SLIDER'] as $index => $item)
    $slider[] = '"https://stimma.com.ua'.$item['ORIGINAL'].'"';

$review = $jsonReview = [];
$res = CIBlockSection::GetList([], ['IBLOCK_ID' => 35, 'ACTIVE' => 'Y', 'UF_PRODUCT' => $arResult['ID']]);
$rating = $count = 0;
if($record = $res -> Fetch())
{
    $res2 = CIBlockElement::GetList([], ['IBLOCK_ID' => 35, 'SECTION_ID' => $record['ID'], 'ACTIVE' => "Y"]);
    while ($record2 = $res2 -> GetNextElement())
    {
        $fields = $record2 -> GetFields();
        $props = $record2 -> GetProperties();
        $review[$fields['ID']] = $fields;
        $review[$fields['ID']]['PROPERTIES'] = $props;

        $rating += intval($props['RATING']["VALUE"]);
        $count++;

        $jsonReview[] = '{
                    "@type": "Review",
                    "reviewRating": {
                        "@type": "Rating",
                        "ratingValue": "'.intval($props['RATING']["VALUE"]).'",
                        "bestRating": "5"
                    },
                    "author": {
                        "@type": "Person",
                        "name": "'.addslashes($fields['NAME']).'"
                    }
                }';
    }
}
else
{
    $review = false;
    $jsonReview[] = '{}';
}
if(empty($jsonReview))
    $jsonReview[] = '{}';
?>

    <script>
        <?/*addViewItem(<?=$arResult['ID']?>, '<?=addslashes($itemName)?>', <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', 1,'view_item', true, 'Item View');*/?>
    </script>
    <script>
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
        'ecommerce': {
            'currencyCode': 'UAH',
            'detail': {
                'actionField': {'list': 'List 1'},
                'products': [{
                    'name': '<?=addslashes($itemName)?>',
                    'id': '<?=$arResult['ID']?>',
                    'baseId': '<?=$arResult['ID']?>',
                    'price': '<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>',
                    'brand': 'STIMMA',
                    'category': '<?=addslashes($sectionName)?>',
                    //'variant': 'Variant 1'
                }]
            }
        },
        'event': 'gtm-ee-event',
        'gtm-ee-event-category': 'Enhanced Ecommerce',
        'gtm-ee-event-action': 'Product Details',
        'gtm-ee-event-non-interaction': 'True',
        'dyn-rem-ids': '<?=$arResult['ID']?>',
        'dyn-rem-pagetype': 'product',
        'dyn-rem-value': '<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>',
    });
</script>
    <script>
        dataLayer.push({ ecommerce: null });
dataLayer.push({
  event: "select_item",
  ecommerce: {
    item_list_id: "<?=$arResult['ID']?>",
    item_list_name: "<?=addslashes($itemName)?>",
    items: [
     {
      item_id: "<?=$arResult['ID']?>",
      item_name: "<?=addslashes($itemName)?>",
      affiliation: "STIMMA",
      discount: <?=$selOffer['PRICES']['BASE']['DISCOUNT_VALUE'] - $selOffer['MIN_PRICE']['DISCOUNT_VALUE']?>,
      index: 1,
      item_brand: "STIMMA",
      item_category: "<?=addslashes($sectionName)?>",
      item_list_id: "<?=$arResult['ID']?>",
      item_list_name: "<?=addslashes($itemName)?>",
      price: <?=$selOffer['PRICES']['BASE']['DISCOUNT_VALUE']?>,
      quantity: 1 // по дефолту залишаєм 1.
    }
    ]
  }
});
    </script>
    <script>
        dataLayer.push({ ecommerce: null });
        dataLayer.push({
            event: "view_item",
            ecommerce: {
                currency: "UAH",
                value: <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>,
                items: [
                    {
                        item_id: "<?=$arResult['ID']?>",
                        item_name: "<?=addslashes($itemName)?>",
                        affiliation: "STIMMA",
                        discount: <?=$selOffer['PRICES']['BASE']['DISCOUNT_VALUE'] - $selOffer['MIN_PRICE']['DISCOUNT_VALUE']?>,
                        index: 1,
                        item_brand: "STIMMA",
                        item_category: "<?=addslashes($sectionName)?>",
                        item_list_id: "<?=$arResult['ID']?>",
                        item_list_name: "<?=addslashes($itemName)?>",
                        price: <?=$selOffer['PRICES']['BASE']['DISCOUNT_VALUE']?>,
                        quantity: 1
                    }
                ]
            }
        });

        fbq ( 'track', 'ViewContent',
            {
                currency: 'USD',
                content_ids: '<?=$arResult['ID']?>',
                content_name: '<?=addslashes($itemName)?>',
                content_category: '<?=addslashes($sectionName)?>',
                content_type: 'card_page',
            });
    </script>


<?
if($rating)
{
    $rating = ',
                "aggregateRating": {
                    "@type": "AggregateRating",
                    "ratingValue": "'.round($count/$rating).'",
                    "reviewCount": "'.$count.'"
                }';
}
else
    $rating='';


//echo "<pre>";print_R($arResult);exit();
$availability = 'https://schema.org/InStock';
if ( $arResult['SKIP_OFFERS'] ) {
	$availability = 'https://schema.org/OutOfStock';
}

?>
    <script class="svtmp34343" type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Product",
            "sku": "<?=$arResult['ID']?>",
            "image": [
                <?=implode(',',$slider)?>
            ],
            "name": "<?=$arResult['NAME']?>",
            "description": "<?=addslashes($arResult['DETAIL_TEXT'])?>",
            "brand": {
                "@type": "Brand",
                "name": "STIMMA"
            },
            "offers": {
                "@type": "Offer",
                "url": "<?=$APPLICATION -> GetCurPage()?>",
                "itemCondition": "https://schema.org/NewCondition",
                "availability": "<?= $availability ?>",
				<?php 
				if ( 1 || !$arResult['SKIP_OFFERS'] ) {	?>
                "price": "<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE'] ?? 0?>",
                "priceCurrency": "UAH",
                "priceValidUntil": "<?=date('Y')?>-12-31",
				<?php } ?>
                "review": <?=implode(',',$jsonReview)?>
                <?=$rating?>
            }
        }
    </script>

<?php
unset($actualItem, $itemIds, $jsParams);
