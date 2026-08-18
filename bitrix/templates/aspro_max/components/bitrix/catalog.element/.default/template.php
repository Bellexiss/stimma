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
$this->addExternalCss('/bitrix/css/main/bootstrap.css');

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
if(strpos($APPLICATION->GetCurPage(), '/podarochnyy_sertifikat/') !== false)
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
?>
    <?/*<script src="<?=SITE_TEMPLATE_PATH?>/slick/slick.js"></script>
    <link href="<?=SITE_TEMPLATE_PATH?>/slick/slick-theme.css" type="text/css" rel="stylesheet">*/?>

    <div class="card-page-cont">
        <div class="card-basket-add">
            <a href="#">Перейти в корзину </a>
             Ви отложили “Жіночий кроп-топ Stimma Брауні 0114” в свою корзину.  
        </div>
        <a href="<?=str_replace('/'.$arResult['CODE'].'/', '/', $APPLICATION -> GetCurPage())?>" class="card-page-back">
            <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.80804 6.46875L13.9955 6.46875" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6.49548 0.843751C4.29878 3.04045 3.06718 4.27205 0.870485 6.46875L6.49548 12.0938" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <div class="card-main-info">
            <div class="card-main-sliders">
                <div class="card-big-slider-cont">
                    <div class="card-badge-block">
                        <?

                        if($arResult['SKIP_OFFERS'])
                        {
                            ?>
                            <div class="card-badge-item no-available">
                                <?=LANGUAGE_ID == 'ua' ? 'Немає в наявності' : 'Нет в наличии'?>
                            </div>
                            <?
                        }
                        if(in_array('novaya_kollektsiya', $arResult['OFFERS'][$selected]['PROPERTIES']['SELECTION']['VALUE_XML_ID']))
                        {
                            ?><div class="card-badge-item new">NEW</div><?
                        }
                        if(in_array('khit_prodazh', $arResult['OFFERS'][$selected]['PROPERTIES']['SELECTION']['VALUE_XML_ID']))
                        {
                            ?><div class="card-badge-item hit">Хіт продажу</div><?
                        }
                        if(in_array('rasprodazha', $arResult['OFFERS'][$selected]['PROPERTIES']['SELECTION']['VALUE_XML_ID'])  )
                        {
                            ?><div class="card-badge-item action cbia3">SALE</div><?
                        }
                        if($arParams['IS_NEW'])
                        {
                            $gGroups = explode(',',$USER -> GetGroups());
                            if(in_array(9,$gGroups) && $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['OPT']) $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['BASE'] = $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['OPT'];
                        }

                        $showPercent = in_array('rasprodazha', $arResult['OFFERS'][$selected]['PROPERTIES']['SELECTION']['VALUE_XML_ID']) || in_array('khit_prodazh', $arResult['OFFERS'][$selected]['PROPERTIES']['SELECTION']['VALUE_XML_ID']);
                        if($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['BASE']['DISCOUNT_VALUE'] > $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE'] && $showPercent)
                        {
                            $percent = $minPrice['DISCOUNT_DIFF_PERCENT'] = round(100-($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']/$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['BASE']['DISCOUNT_VALUE'])*100);
                            ?><div class="card-badge-item action cbia3">-<?=$percent?>%</div><?
                        }
                        //$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['PRINT_DISCOUNT_VALUE']
                        //$minPrice['DISCOUNT_DIFF_PERCENT'] = round(100-($minPrice['DISCOUNT_VALUE']/$item['PRICES']['BASE']['DISCOUNT_VALUE'])*100);
                        ?>

                    </div>
                    <div class="card-stars-block">
                        <?
                        for ($i = 1; $i <= 5; $i++)
                        {
                            ?>
                            <span class="<?=$i <= $arResult['AVERAGE'] ? 'active' : ''?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                    <defs></defs>
                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                </svg>
                            </span>
                            <?
                        }
                        ?>
                    </div>
                    <div class="catalog-item-favorite">
                        <a href="#" data-id="<?=$arResult['ID']?>">
                            <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="card-big-slider">
                        <?

                        foreach ($arResult['SLIDER'] as $index => $item)
                        {
                            $colorName = LANGUAGE_ID == 'ua' ? 'колір' : 'цвет';
                            ?><div class="card-big-slider-item">
                                <div class="easyzoom easyzoom--overlay">
                                    <a href="<?=$item['ORIGINAL']?>">
                                        <img class="big_img_sert <?=$isSert ? 'is_sert' : ''?>" <?=!$index ? 'class="first_img"' : ''?> src="<?=$item['BIG']?>" alt="<?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']?>, <?=$colorName?> - <?=$arResult['OFFERS'][0]['DISPLAY_PROPERTIES']['COLOR_REF']['DISPLAY_VALUE']?>">
                                    </a>
                                </div>
                            </div><?
                        }
                        ?>
                    </div>
                </div>
                <div class="card-small-slider-cont" style="min-height: 100%;">
                    <div class="card-small-slider">
                        <?
                        foreach ($arResult['SLIDER'] as $index => $item)
                        {
                            $colorName = LANGUAGE_ID == 'ua' ? 'колір' : 'цвет';
                            ?><div class="card-small-slider-item">
                                <img class="small_img_sert <?=$isSert ? 'is_sert' : ''?>" src="<?=$item['SMALL']?>" alt="<?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']?>, <?=$colorName?> - <?=$arResult['OFFERS'][0]['DISPLAY_PROPERTIES']['COLOR_REF']['DISPLAY_VALUE']?>">
                            </div><?
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="card-info">
                <div class="card-info-top">
                    <div class="card-info-name-cont">
                        <?/*<div class="card-info-name" data-entity="name_card"><?=LANGUAGE_ID == 'ua' && $arResult['PROPERTIES']['NAME_UA']['VALUE'] ? $arResult['NAME'] : $arResult['PROPERTIES']['NAME_UA']['VALUE']?></div>*/?>
                        <?/*<div class="card-info-name" data-entity="name_card"><?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']?><?//=LANGUAGE_ID == 'ua' && $arResult['OFFERS'][$selected]['PROPERTIES']['NAME_UA']['VALUE'] ? $arResult['OFFERS'][$selected]['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['OFFERS'][$selected]['NAME'] ?></div>*/?>
                        <?
                        //if(isset($_GET['me']))
                        {
                            if(strpos($APPLICATION->GetCurPage(), '/podarochnyy_sertifikat/') === false)
                                $ccName = LANGUAGE_ID == 'ua' ? ' колір' : ' цвет';
                            else
                                $ccName = '';
                            ?><div class="card-info-name" data-entity="name_card"><?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] . ' ' . $arResult['COLORS_FOR_CHANGE'][$arResult['PROPERTIES']['COLOR']['VALUE']] . $ccName : $arResult['NAME'] . ' ' . $arResult['COLORS_FOR_CHANGE'][$arResult['PROPERTIES']['COLOR']['VALUE']] .$ccName?><?//=LANGUAGE_ID == 'ua' && $arResult['OFFERS'][$selected]['PROPERTIES']['NAME_UA']['VALUE'] ? $arResult['OFFERS'][$selected]['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['OFFERS'][$selected]['NAME'] ?></div><?
                        }
                        ?>


                        <?
                        if(in_array('STOCK', $arResult['PROPERTIES']['HIT']['VALUE_XML_ID']) )
                        {
                            ?><div class="card-sale">SALE</div><?
                        }

                        ?>
                    </div>
                    <?/*<div class="card-info-name"><?=$arResult['NAME']?></div>*/?>
                    <div class="card-info-article" style="font-weight: bold;"><?=$arResult['PROPERTIES']['MODEL']['VALUE']?></div>
                    <div class="card-info-text">
                        <?=LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['DETAIL_TEXT_UA']['~VALUE']['TEXT'] : $arResult['DETAIL_TEXT']?>
                    </div>
                </div>
                <?

                $selOffer = $arResult['OFFERS'][$arResult['SELECTED_OFFER']];


                if($selOffer['PRICES']['BASE']['DISCOUNT_VALUE'] > $selOffer['MIN_PRICE']['DISCOUNT_VALUE'])
                {
                    //if(in_array(9,$gGroups) && $selOffer['PRICES']['BASE']['DISCOUNT_VALUE'])
                    //    $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['PRINT_VALUE'] = FormatCurrency($selOffer['PRICES']['BASE']['DISCOUNT_VALUE'], 'UAH');
                    //else
                        $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['PRINT_VALUE'] = FormatCurrency($selOffer['PRICES']['BASE']['DISCOUNT_VALUE'], 'UAH');
                }
                ?>
                <div class="card-info-bottom" data-entity="scu">
                    <div class="card-info-price">
                        <div class="card-info-price-currency" data-entity="price_card">
                            <?
                            if(strpos($APPLICATION->GetCurPage(), '/podarochnyy_sertifikat/') === false)
                            {
                                ?>
                                <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?>
                                <?
                            }
                            else
                            {
                                echo LANGUAGE_ID=='ua'?'Виберіть номінал':'Выберите номинал';
                            }
                            ?>

                            <?
                            if(in_array(9, explode(',',$USER ->GetGroups())) && $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['BASE']['DISCOUNT_VALUE'] > $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE'])
                            {
                                if($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['OPT_DISCOUNT']['DISCOUNT_VALUE'])
                                {
                                    ?>
                                    <span class="text"><?=LANGUAGE_ID=='ua' ? 'Ціна зі знижкою' : 'Цена со скидкой'?></span>
                                    <?
                                }
                                else
                                {
                                    ?>
                                    <span class="text"><?=LANGUAGE_ID=='ua' ? 'Оптова ціна' : 'Оптовая цена'?></span>
                                    <?
                                }
                            }
                            ?>
                        </div>
                        <?
                        //if($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['VALUE'] > $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE'])
                        if($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['BASE']['DISCOUNT_VALUE'] > $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE'])
                        {
                            ?>
                            <div class="card-info-price-old" data-entity="price-old">
                                <span class="price"><?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['PRINT_VALUE']?></span>
                                <?
                                if(in_array(9, explode(',',$USER ->GetGroups())))
                                {
                                    if($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['OPT_DISCOUNT']['DISCOUNT_VALUE'])
                                    {
                                        ?>
                                        <span class="text"><?=LANGUAGE_ID=='ua' ? 'Оптова ціна' : 'Оптовая цена'?></span>
                                        <?
                                    }
                                    else
                                    {
                                        ?>
                                        <span class="text"><?=LANGUAGE_ID=='ua' ? 'Роздрібна ціна' : 'Розничная цена'?></span>
                                        <?
                                    }

                                }
                                ?>
                            </div>
                            <?/*<div class="my-ekonom"><?=LANGUAGE_ID=='ua' ? 'Економія' : 'Экономия'?>: <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['PRICES']['BASE']['DISCOUNT_VALUE'] - $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?> грн</div>*/?>


                            <?
                            /*if(in_array(9, explode(',',$USER ->GetGroups())))
                            {
                                ?>
                                <div class="my-ekonom"><?=LANGUAGE_ID=='ua' ? 'Оптова ціна' : 'Оптовая цена'?></div>
                                <?
                            }
                            else
                            {
                                ?>
                                <div class="my-ekonom"><?=LANGUAGE_ID=='ua' ? 'Ціна зі знижкою' : 'Цена со скидкой'?></div>
                                <?
                            }*/
                        }
                        if($USER -> IsAdmin())
                        {
                            /*?>
                            <div class="my-ekonom"><?=LANGUAGE_ID=='ua' ? 'Роздрібна ціна' : 'Розничная цена'?></div>
                            <?*/
                        }
                        ?>


                    </div>
                    <div class="card-info-size" data-entity="scu-values" data-code="RAZMER">
                        <?
                        //foreach ($tree['props']['RAZMER']['values'] as $index => $value)
                        $sizes = [];
                        foreach ($arResult['OFFERS'] as $indexOFfer => $offer)
                        {
                            if($offer['skip']) continue;
                            $sizes[$arResult['SORTING_SIZES'][mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE'])]] = ['offer_id' => $offer['ID'], 'value' => mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE'])];
                            $sizes[$arResult['SORTING_SIZES'][mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE'])]]['active'] = $arResult['SELECTED_OFFER'] == $indexOFfer ? true : false;
                        }

                        ksort($sizes);
                        if($isSert)
                            $sizes = $sizesSert;
                        //if(ME || isset($_GET['me']))
                        {

                        }

                        foreach ($sizes as $indexOFfer => $value)
                        {
                            /*?><div class="card-info-size-item" data-entity="scu-value" data-id="<?=mb_strtolower($index)?>"><?=$value?></div><?*/
                            ?><div class="card-info-size-item <?=$isSert ? 'is_sert' : ''?> <?=$value['active'] ? 'active' : ''?>" data-entity="scu-value" data-id="<?=mb_strtolower($value['offer_id'])?>" data-img="<?=$value['imag']?>" data-img2="<?=$value['imag_2']?>" data-original="<?=$value['original']?>"><?=$value['value']?></div><?
                        }
                        ?>
                        <?/*
                        <div class="card-info-size-item no-size" data-entity="scu-value" data-id="<?=$index?>">XS</div>
                        <div class="card-info-size-item" data-entity="scu-value" data-id="<?=$index?>">S</div>
                        <div class="card-info-size-item no-size" data-entity="scu-value" data-id="<?=$index?>">M</div>
                        <div class="card-info-size-item" data-entity="scu-value" data-id="<?=$index?>">L</div>
                        */?>
                    </div>

                    <?
                    if($arResult['OFFERS'][$arResult['SELECTED_OFFER']]['CATALOG_QUANTITY'] > 0 && $arResult['OFFERS'][$arResult['SELECTED_OFFER']]['CATALOG_QUANTITY'] < 7)
                    {
                        echo LANGUAGE_ID == 'ua' ?
                            'Залишилось лише <span style="font-weight:bold;">'.$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['CATALOG_QUANTITY'].'</span> в наявності'
                            :
                            'Осталось только <span style="font-weight:bold;">'.$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['CATALOG_QUANTITY'].'</span> в наличии';
                    }
                    ?>

                    <?
                    if(strpos($APPLICATION->GetCurPage(), '/podarochnyy_sertifikat/') === false)
                    {
                        ?>
                        <div class="card-info-color-cont" data-code="COLOR_REF">
                            <div class="card-info-color" data-entity="scu-values">
                                <?
                                //foreach ($tree['props']['COLOR_REF']['values'] as $index => $colorXmlid)
                                foreach ($arResult['COLOR_VARIANTS'] as $colorXmlid => $colorLink)
                                {
                                    //   foreach ($value as $index2 => $colorXmlid)
                                    {
                                        /*?><a style="background-color: <?=$arResult['ALL_COLORS'][$colorXmlid]?>;" href="#" class="card-info-color-item" data-entity="scu-value" data-id="<?=$colorXmlid?>">
                                        </a><?*/
                                        ?><a style="background-color: <?=$arResult['ALL_COLORS'][$colorXmlid]?>;" href="<?=$colorLink?>" class="card-info-color-item <?=strtoupper($arResult['ALL_MAIN_COLORS'][$colorXmlid]) == '#FFFFFF' ? 'white' : ''?> <?=$colorXmlid == $arResult['PROPERTIES']['COLOR']['VALUE'] ? 'active' : ''?>" >
                                        <?/*<img src="/bitrix/templates/aspro_max/images/card-color.png">*/?>
                                        </a><?
                                    }

                                }
                                ?>
                                <?/*
                            <a href="#" class="card-info-color-item" data-entity="scu-value" data-id="<?=$index?>">
                                <img src="/bitrix/templates/aspro_max/images/card-color.png">
                            </a>
                            <a href="#" class="card-info-color-item" data-entity="scu-value" data-id="<?=$index?>">
                                <img src="/bitrix/templates/aspro_max/images/card-color.png">
                            </a>
                            <a href="#" class="card-info-color-item" data-entity="scu-value" data-id="<?=$index?>">
                                <img src="/bitrix/templates/aspro_max/images/card-color.png">
                            </a>
                            <a href="#" class="card-info-color-item active" data-entity="scu-value" data-id="<?=$index?>">
                                <img src="/bitrix/templates/aspro_max/images/card-color.png">
                            </a>
                            */?>
                            </div>



                            <a href="#" class="card-info-size-btn">
						<span class="icon">
							<svg width="72" height="27" viewBox="0 0 72 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M57.7844 11.6536V25.5005" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
								<path d="M64.4279 20.9381C65.7344 20.9381 66.7935 19.8789 66.7935 18.5724C66.7935 17.2659 65.7344 16.2068 64.4279 16.2068C63.1214 16.2068 62.0623 17.2659 62.0623 18.5724C62.0623 19.8789 63.1214 20.9381 64.4279 20.9381Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
								<path d="M44.7556 25.5005V16.2158" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M51.5591 25.5006V20.3247" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M38.2725 25.5006V20.3247" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M24.9856 25.0292V19.8533" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M11.6902 23.5528V18.3857" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M31.7981 25.0291V15.7444" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M18.8315 24.2555V14.9797" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M5.87378 22.0852V12.8005" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M1.00026 5.85502V19.2751C0.929114 22.7435 15.4075 25.3048 35.9334 25.5005H71V11.6535H35.9334H36.0046C15.4876 11.4578 -0.155877 8.67422 1.07141 5.42814C2.04968 2.83128 16.1546 0.856947 32.5717 1.00813C45.7073 1.13264 55.7123 2.92021 54.9297 4.99237C54.2982 6.65543 45.2715 7.91828 34.7684 7.82046C26.3642 7.74042 19.9609 6.60207 20.459 5.26806C20.8592 4.20086 26.6399 3.39156 33.3632 3.46271C38.7437 3.51607 42.8436 4.24532 42.5234 5.09019C42.2655 5.76609 38.5659 6.2908 34.2704 6.24633C30.8286 6.21076 28.2051 5.7483 28.4096 5.20581V7.54476" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M54.9207 4.99243V11.6536" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
								<path d="M20.459 5.26807V10.8798" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M42.5146 5.09009V7.64249" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</span>
                                <?=LANGUAGE_ID == 'ua' ? 'РОЗМІРНА СІТКА' : 'РАЗМЕРНАЯ СЕТКА'?>
                            </a>
                        </div>
                        <?
                    }
                    ?>



                    <?
                    if($USER->IsAdmin() && $arResult['PROPERTIES']['SILUET']['VALUE'])
                    {
                        ?>
                        <button style="border-radius:0 !important;width: 100%;" type="button" class="btn btn-primary get_my_size" section="<?=$arResult['IBLOCK_SECTION_ID']?>" data-toggle="modal" data-target="#modal-size">
                            <?=LANGUAGE_ID=='ua'?'Підібрати розмір':'Подорбать размер'?>
                        </button>
                        <?
                    }
                    ?>
                    <?
                    if(!$arResult['SKIP_OFFERS'])
                    {
                        ?>
                        <a href="#" style="margin-top: 15px;<?//=!$arResult['OFFERS'][$selected]['PRODUCT']['QUANTITY'] ? 'display:none;' : ''?>"
                            <?/*onclick="addViewItem(<?=$arResult['ID']?>, '<?=addslashes($itemName)?>', <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', 1,'add_to_cart', true, 'Item View');"*/?>
                           onclick="addToCartEK(<?=$arResult['ID']?>, '<?=addslashes($itemName)?>', <?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', 1,'add_to_cart', true, 'Item View', 1,<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>);"
                           class="card-info-buy-btn buy_product" data-id="<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['ID']?>"><?=LANGUAGE_ID == 'ua' ? 'У КОШИК' : 'В КОРЗИНУ'?>
                        </a>
                        <div class="card-info-counter" style="<?//=!$arResult['OFFERS'][$selected]['PRODUCT']['QUANTITY'] ? 'display:none;' : ''?>">
                            <form>
                                <div class="card-counter">
                                    <button class="card-counter-btn minuscounter" >
                                        <svg width="20" height="1" viewBox="0 0 20 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <line y1="0.5" x2="20" y2="0.5" stroke="#3D441D"/>
                                        </svg>
                                    </button>
                                    <input type="text" name="" value="1" disabled>
                                    <button class="card-counter-btn pluscounter" >
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <line x1="9.83325" y1="2.18557e-08" x2="9.83325" y2="20" stroke="#3D441D"/>
                                            <line y1="10.1667" x2="20" y2="10.1667" stroke="#3D441D"/>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <?
                    }
                    ?>


                    <div class="card-info-dop-text">

                        <?
                        if(LANGUAGE_ID == 'ua')
                            $fromTo2 = [
                                'Параметри моделі' => 'Параметри моделі',
                                'Зріст' => 'Зріст',
                                'На моделі розмір' => 'На моделі розмір',
                                ' - ' => ' - '.PHP_EOL,
                                ';' => ';'.PHP_EOL,
                                '.' => '.'.PHP_EOL,
                            ];
                        else
                            $fromTo2 = [
                                'Параметри моделі' => 'Параметры модели',
                                'Зріст' => 'Рост',
                                'На моделі розмір' => 'На модели размер',
                                ' - ' => ' - '.PHP_EOL,
                                ';' => ';'.PHP_EOL,
                                '.' => '.'.PHP_EOL,
                            ];
                        ?>
                        <?=str_replace(array_keys($fromTo2), $fromTo2, $arResult['OFFERS'][0]['PROPERTIES']['PARAM_MODEL']['VALUE']);?>
                    </div>
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
        ?>
        <div class="card-main-tabs-mobile">
            <div class="card-tabs-mobile-item">
                <div class="card-tabs-mobile-item-title">
                    ХАРАКТЕРИСТИКИ
                </div>
                <div class="card-tabs-mobile-item-cont">
                    <ul class="card-info-list">
                        <?
                        foreach ($arResult['OFFERS'][0]['DISPLAY_PROPERTIES'] as $index => $arProp)
                        {
                            if(!$arProp['VALUE']/* || $arProp['CODE'] == 'SOSTAV'*/) continue;
                            if($arProp['CODE'] == 'COLOR_REF' && LANGUAGE_ID == 'ru') $arProp['VALUE'] = $arProp['DISPLAY_VALUE'];
                            ?>
                            <li  code="<?=$arProp['CODE']?>">
                                <span><?=$arProp['NAME']?>:</span>
                                <?=is_array($arProp['VALUE']) ? implode(', ',$arProp['VALUE']) : $arProp['VALUE']?>
                            </li>
                            <?
                        }
                        ?>
                        <?
                        if($arResult['PROPERTIES']['TEMP_REJIM']['VALUE'])
                        {
                            ?>
                            <li  code="TEMP_REJIM">
                                <span><?=LANGUAGE_ID=='ua' ? 'Температурний режим' : 'Температурный режим'?>:</span>
                                <?=is_array($arResult['PROPERTIES']['TEMP_REJIM']['VALUE']) ? implode(', ',$arResult['PROPERTIES']['TEMP_REJIM']['VALUE']) : $arResult['PROPERTIES']['TEMP_REJIM']['VALUE']?>
                            </li>
                            <?
                        }
                        ?>
                        <?/*
                        <li>
                            <span>Розміри:</span>
                            S, M
                        </li>
                        <li>
                            <span>Колір:</span>
                            Капучіно
                        </li>
                        <li>
                            <span>Бренд:</span>
                            STIMMA
                        </li>
                        <li>
                            <span>Вид:</span>
                            Сукня
                        </li>
                        <li>
                            <span>Країна:</span>
                            Україна
                        </li>
                        <li>
                            <span>Матеріал:</span>
                            Сатин
                        </li>
                        <li>
                            <span>Склад:</span>
                            70% - поліестр,  30% - віскоза
                        </li>
                        <li>
                            <span>Виробник:</span>
                            STIMMA
                        </li>
                        */?>
                    </ul>
                </div>
            </div>
            <div class="card-tabs-mobile-item">
                <div class="card-tabs-mobile-item-title">
                    <?=LANGUAGE_ID=='ua'?'РОЗМІРИ ГОТОВОГО ВИРОБУ':'РАЗМЕРЫ ГОТОВОГО ИЗДЕЛИЯ'?>
                </div>

                <div class="card-tabs-mobile-item-cont">
                    <table class="card-table-size">
                        <?
                        foreach ($table as $index => $items)
                        {
                            ?>
                            <tr>
                                <?
                                foreach ($items as $index2 => $item)
                                {
                                    /*?><td><?=!$index && !$index2 ? (LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']) : $item?></td><?*/
                                    ?><td><?=!$index && !$index2 ? '' : $item?></td><?
                                }
                                ?>
                            </tr>
                            <?
                        }
                        ?>

                    </table>
                </div>
            </div>
            <div class="card-tabs-mobile-item">
                <div class="card-tabs-mobile-item-title">
                    <?=LANGUAGE_ID=='ua'?'ОПЛАТА ТА ДОСТАВКА':'ОПЛАТА И ДОСТАВКА'?>
                </div>
                <div class="card-tabs-mobile-item-cont">
                    <div class="card-info-text-block">
                        <?/*
                        <div class="card-info-text-title">
                            ДОСТАВКА
                        </div>
                        <div class="card-info-text-content">
                            <p>Відправка здійснюється після підтвердження менеджером вашого замовлення.</p>
                            <p><strong>Спосіб оплати:</strong></p>
                            <ul>
                                <li>100% оплата на реквізити ФОП (реквізити надішле менеджер, при виставленні рахунку).</li>
                                <li>грошовий переказ (лише перевізником НОВА ПОШТА)</li>
                                <li>готівка  (при самовивозі, з м. Хмельницький. вул. Святослава Хороброго 5)</li>
                            </ul>
                            <p><b>Важливо!</b> Після того, як Ваше замовлення доставлять на відділення служби доставки у Вашому місті, Вам потрібно буде забрати його не більше ніж через 5 днів, інакше замовлення відправляється назад на склад магазин.</p>
                            <p>Ми гарантуємо, що ваша посилка буде відправлена ​​після підтвердження замовлення менеджером (менеджер вам передзвонить, щоб уточнити деталі замовлення) протягом 2 робочих днів з дня замовлення. Коли Ваше замовлення буде відправлено, Вам буде надіслано SMS повідомлення з номером декларації, по якому Ви зможете отримати свою посилку. </p>
                            <p>Якщо у Вас виникли питання по доставці замовлень з нашого інтернет магазину одягу, ми завжди готові на них відповісти.</p>
                        </div>
                        */?>
                        <?
                        if(LANGUAGE_ID == 'ua')
                        {
                            ?>
                            <p>
                                Відправка здійснюється після підтвердження менеджером вашого замовлення.<br>
                            </p>
                            <p>
                                <b>Спосіб оплати:</b>
                            </p>
                            <p>
                            </p>
                            <div>
                                <ul>
                                    <li>100% оплата на реквізити ФОП (реквізити надішле менеджер, при виставленні рахунку). </li>
                                    <li>
                                        грошовий переказ (лише перевізником НОВА ПОШТА) </li>
                                </ul>
                                <span style="color: var(--basic_text_black);"><i>*Право вибору способу доставки та оплати замовлень залишається за покупцем.&nbsp;</i></span><br>
                            </div>
                            <p>
                                <b>Спосіб доставки:</b>
                            </p>
                            <div>
                                <ul>
                                    <li>
                                        НОВА ПОШТА (відправки замовлень щодня) </li>
                                    <li>
                                        УКРПОШТА (відправка замовлень щосереди) </li>
                                    <li>
                                        самовивіз (м. Хмельницький. вул. Святослава Хороброго 5)</li>
                                </ul>
                                <span style="color: var(--basic_text_black);">Після оформлення замовлення на обрану службу доставки, менеджер надішле вам повідомлення з номером декларації, за яким ви зможете відстежити та отримати поштове відправлення.</span><br>
                            </div>
                            <p>
                                <b>Зверніть увагу</b>, після того, як замовлення буде отримано перевізником на відділенні, вам необхідно отримати його <b>протягом 5 днів</b>. В іншому випадку буде здійснене автоповернення в інтернет-магазин.
                            </p>

                            <p><strong>ПОВЕРНЕННЯ</strong></p>

                            <p>“ЛЕГКЕ ПОВЕРНЕННЯ”</p>
                            <p>ПРИ ДОСТАВЦІ НОВОЮ ПОШТОЮ</p>

                            <p>Якщо товар не підійшов, можна легко оформити заявку повернення в застосунку Нової Пошти. Послуга безкоштовна</p>

                            <p><a style="text-decoration: underline;" href="https://dev.stimma.ua/pro-nas/garantiya-ta-povernennya/">Як це працює?</a> </p>

                            <p>Термін повернення та обміну товару здійснюється протягом 14 календарних днів з моменту продажу, відповідно до законодавства України, за умови збереження цілісності упаковки та оригінальності товару. Вживаний товар обміну та поверненню не підлягає.</p>
                            <?
                        }
                        else
                        {
                            ?>
                            <p>
                                Отправка осуществляется после подтверждения менеджером вашего заказа.
                            </p>
                            <p>
                                <b>Способ оплаты:</b>
                            </p>
                            <div>
                                <ul>
                                    <li>
                                        100% оплата на реквизиты ФОП (реквизиты вышлет менеджер при выставлении счета). </li>
                                    <li>
                                        денежный перевод (только перевозчиком НОВА ПОШТА) </li>
                                </ul>
                                <span style="color: var(--basic_text_black);"><i>*Право выбора способа доставки и оплаты заказов остается за покупателем.</i></span><br>
                            </div>
                            <p>
                                <b>Способ доставки:</b>
                            </p>
                            <div>
                                <ul>
                                    <li>
                                        НОВА ПОШТА (отправки заказов каждый день) </li>
                                    <li>
                                        УКРПОШТА (отправка заказов каждую среду) </li>
                                    <li>
                                        самовывоз (г. Хмельницкий, ул. Святослава Хороброго 5)</li>
                                </ul>
                                <span style="color: var(--basic_text_black);">После оформления заказа на выбранную службу доставки, менеджер отправит вам уведомление с номером декларации, по которому вы сможете отследить и получить почтовое отправление.</span><br>
                            </div>
                            <p>
                            </p>
                            <p>
                                <b>Обратите внимание</b>, что после того, как заказ будет получен перевозчиком на отделении, вам необходимо получить его <b>в течение 5 дней</b>. В противном случае будет осуществлено автовозврат в интернет-магазин.
                            </p>
                            <p><strong>ВОЗВРАТ</strong></p>

                            <p>“ЛЕГКИЙ ВОЗВРАТ”</p>
                            <p>ПРИ ДОСТАВКЕ НОВОЙ ПОЧТОЙ</p>

                            <p>Если товар не подошел, можна легко оформить заявку на возврат в приложении Новой Почты. Услуга бесплатная.</p>

                            <p><a style="text-decoration: underline;" href="https://dev.stimma.ua/ru/pro-nas/garantiya-ta-povernennya/">Как это работает?</a></p>

                            <p>Срок возврата и обмена товара осуществляется на протяжении 14 дней с момента продажи, согласно к законодательству Украины, за условия сохранения целостности упаковки. Подержанный товар не подлежит обмену и возврату.</p>
                            <?
                        }
                        ?>
                    </div>
                    <?/*
                    <div class="card-info-text-block">
                        <div class="card-info-text-title">
                            Оплата
                        </div>
                        <div class="card-info-text-content">
                            <ul>
                                <li>100% передоплата на платіжну карту Приват Банку. Оплату можна робити через термінали ПриватБанку, каси банку або систему Приват 24. Реквізити платіжної картки ми відсилаємо на Ваш E-MAIL або на телефон SMS повідомленням.</li>
                                <li>Накладений платіж можливий, якщо доставка здійснюється Новою поштою. Вартість доставки (повернення) коштів оплачується покупцем, відповідно до тарифів перевізника.</li>
                            </ul>
                            <p>Право вибору способу оплати замовлень залишається за покупцем інтернет магазину STIMMA.COM.UA</p>
                        </div>
                    </div>
                    */?>
                </div>
            </div>
            <div class="card-tabs-mobile-item">
                <div class="card-tabs-mobile-item-title">
                    <?=LANGUAGE_ID == 'ua' ? 'ВІДГУКИ' : 'ОТЗЫВЫ'?>

                </div>
                <div class="card-tabs-mobile-item-cont">
                    <div class="reviews-empty">
                        <?=LANGUAGE_ID == 'ua' ? 'Відгуків немає, поки що.' : 'Отзывов нет, пока что'?>
                    </div>
                    <div class="reviews-cont">
                        <div class="reviews-add-comment">
                            <a href="#" class="reviews-add-comment-btn">
                                <?=LANGUAGE_ID == 'ua' ? 'Додати коментар' : 'Добавить комментарий'?>
                            </a>
                        </div>
                        <div class="reviews-form">
                            <form>
                                <input type="hidden" name="reviews-id-product" value="<?=$arResult['ID']?>">
                                <div class="form-group group2">
                                    <div class="form-wrap">
                                        <div class="form-wrap-title">
                                            <?=LANGUAGE_ID == 'ua' ? 'Ваше ім\'я' : 'Ваше имя'?>

                                            <span class="required">*</span>
                                        </div>
                                        <input type="text" name="name">
                                    </div>
                                    <div class="form-wrap">
                                        <div class="form-wrap-title">
                                            E-mail
                                        </div>
                                        <input type="text" name="email">
                                    </div>
                                </div>
                                <div class="form-wrap">
                                    <div class="form-wrap-title">
                                        <?=LANGUAGE_ID == 'ua' ? 'Ваша оцінка' : 'Ваша оценка'?>
                                    </div>
                                    <div class="wrap-stars-cont">
                                        <div class="star-block">
                                            <input id="star51" name="star" type="radio" value="5">

                                            <label for="star51">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star41" name="star" type="radio" value="4">

                                            <label for="star41">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <label for="star31">
                                            <label for="star21">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star21" name="star" type="radio" value="2">

                                            <input id="star31" name="star" type="radio" value="3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star11" name="star" type="radio" value="1">

                                            <label for="star11">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="star-rating">
                                            <?=LANGUAGE_ID == 'ua' ? 'Без оцінки' : 'Без оценки'?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrap">
                                    <div class="form-wrap-title">
                                        <?=LANGUAGE_ID == 'ua' ? 'Коментар' : 'Комментарий'?>
                                    </div>
                                    <textarea name="comment"></textarea>
                                </div>
                                <div class="fort-wrap-btn-block">
                                    <button type="submit" name="send_review" class="fort-wrap-btn"><?=LANGUAGE_ID == 'ua' ? 'ОПУБЛІКУВАТИ ВІДГУК' : 'ОПУБЛИКОВАТЬ ОТЗЫВ'?></button>
                                </div>
                            </form>
                        </div>
                        <div class="reviews-list">

                                <?
                                foreach ($arResult['REVIEW'] as $index => $review)
                                {
                                    ?>
                                    <div class="reviews-item">
                                        <div class="reviews-item-head">
                                        <div class="reviews-item-name">
                                            <?=$review['NAME']?>
                                        </div>
                                        <div class="reviews-item-star">
                                            <?
                                            for ($i = 1; $i <= 5; $i++)
                                            {
                                                ?>
                                                <span class="<?=$i <= $review['PROPERTY_RATING_VALUE'] ? 'active' : ''?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                        <defs></defs>
                                                        <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                    </svg>
                                                </span>
                                                <?
                                            }
                                            ?>
                                        </div>
                                    </div>
                                        <div class="reviews-item-body">
                                        <?/*<div class="reviews-item-body-title">
                                            Комментарій
                                        </div>*/?>
                                        <div class="reviews-item-body-text">
                                            <?=$review['PREVIEW_TEXT']?>
                                        </div>
                                    </div>
                                    </div>
                                    <?
                                }
                                ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-main-tabs">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab21" data-toggle="tab">ХАРАКТЕРИСТИКИ</a></li>
                <?
                if($table)
                {
                    ?><li><a href="#tab24" data-toggle="tab"><?=LANGUAGE_ID == 'ua' ? 'РОЗМІРИ ГОТОВОГО ВИРОБУ' :'РАЗМЕРЫ ГОТОВОГО ИЗДЕЛИЯ'?></a></li><?
                }
                ?>
                <li class=""><a href="#tab22" data-toggle="tab"><?=LANGUAGE_ID == 'ua' ? 'ОПЛАТА ТА ДОСТАВКА' :'ОПЛАТА И ДОСТАВКА'?></a></li>
                <li><a href="#tab23" data-toggle="tab"><?=LANGUAGE_ID == 'ua' ? 'ВІДГУКИ' :'ОТЗЫВЫ'?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab21">
                    <ul class="card-info-list">
                        <?
                        foreach ($arResult['OFFERS'][0]['DISPLAY_PROPERTIES'] as $index => $arProp)
                        {
                            if(!$arProp['VALUE']) continue;
                            if($arProp['CODE'] == 'COLOR_REF' && LANGUAGE_ID == 'ru') $arProp['VALUE'] = $arProp['DISPLAY_VALUE'];
                            ?>
                            <li code="<?=$arProp['CODE']?>">
                                <span><?=$arProp['NAME']?>:</span>
                                <?=is_array($arProp['VALUE']) ? implode(', ',$arProp['VALUE']) : $arProp['VALUE']?>
                            </li>
                            <?
                        }
                        ?>
                        <?
                        if($arResult['PROPERTIES']['TEMP_REJIM']['VALUE'])
                        {
                            ?>
                            <li  code="TEMP_REJIM">
                                <span><?=LANGUAGE_ID=='ua' ? 'Температурний режим' : 'Температурный режим'?>:</span>
                                <?=is_array($arResult['PROPERTIES']['TEMP_REJIM']['VALUE']) ? implode(', ',$arResult['PROPERTIES']['TEMP_REJIM']['VALUE']) : $arResult['PROPERTIES']['TEMP_REJIM']['VALUE']?>
                            </li>
                            <?
                        }
                        ?>
                        <?/*
                        <li>
                            <span>Розміри:</span>
                            S, M
                        </li>
                        <li>
                            <span>Колір:</span>
                            Капучіно
                        </li>
                        <li>
                            <span>Бренд:</span>
                            STIMMA
                        </li>
                        <li>
                            <span>Вид:</span>
                            Сукня
                        </li>
                        <li>
                            <span>Країна:</span>
                            Україна
                        </li>
                        <li>
                            <span>Матеріал:</span>
                            Сатин
                        </li>
                        <li>
                            <span>Склад:</span>
                            70% - поліестр,  30% - віскоза
                        </li>
                        <li>
                            <span>Виробник:</span>
                            STIMMA
                        </li>
                        */?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="tab24">
                    <table class="card-table-size">
                        <?
                        foreach ($table as $index => $items)
                        {
                            ?>
                            <tr>
                                <?
                                foreach ($items as $index2 => $item)
                                {
                                    /*?><td><?=!$index && !$index2 ? (LANGUAGE_ID == 'ua' ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME']) : $item?></td><?*/
                                    ?><td><?=!$index && !$index2 ? '' : $item?></td><?
                                }
                                ?>
                            </tr>
                            <?
                        }
                        ?>
                        <?/*
                        <tr>
                            <td>Аліма(сукня)</td>
                            <td>S</td>
                            <td>M</td>
                            <td>L</td>
                        </tr>
                        <tr>
                            <td>Пог</td>
                            <td>46</td>
                            <td>48</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>ПоТ</td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                        </tr>
                        <tr>
                            <td>ПОБ</td>
                            <td>47</td>
                            <td>49</td>
                            <td>51</td>
                        </tr>
                        <tr>
                            <td>Ширина плеч по спині</td>
                            <td>32</td>
                            <td>33</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>Довжина рукава</td>
                            <td>51</td>
                            <td>51</td>
                            <td>51</td>
                        </tr>
                        <tr>
                            <td>Довжина виробу по спині</td>
                            <td>111</td>
                            <td>111</td>
                            <td>111</td>
                        </tr>
                        */?>
                    </table>


                </div>
                <div class="tab-pane fade" id="tab22">
                    <div class="card-info-text-block">
                        <div class="card-info-text-title">
                            ДОСТАВКА
                        </div>
                        <div class="card-info-text-content">
                            <?
                            if(LANGUAGE_ID == 'ua')
                            {
                                ?>
                                <p>
                                Відправка здійснюється після підтвердження менеджером вашого замовлення.<br>
                                </p>
                                <p>
                                    <b>Спосіб оплати:</b>
                                </p>
                                <p>
                                </p>
                                <div>
                                    <ul>
                                        <li>100% оплата на реквізити ФОП (реквізити надішле менеджер, при виставленні рахунку). </li>
                                        <li>
                                            грошовий переказ (лише перевізником НОВА ПОШТА) </li>
                                    </ul>
                                    <span style="color: var(--basic_text_black);"><i>*Право вибору способу доставки та оплати замовлень залишається за покупцем.&nbsp;</i></span><br>
                                </div>
                                <p>
                                    <b>Спосіб доставки:</b>
                                </p>
                                <div>
                                    <ul>
                                        <li>
                                            НОВА ПОШТА (відправки замовлень щодня) </li>
                                        <li>
                                            УКРПОШТА (відправка замовлень щосереди) </li>
                                        <li>
                                            самовивіз (м. Хмельницький. вул. Святослава Хороброго 5)</li>
                                    </ul>
                                    <span style="color: var(--basic_text_black);">Після оформлення замовлення на обрану службу доставки, менеджер надішле вам повідомлення з номером декларації, за яким ви зможете відстежити та отримати поштове відправлення.</span><br>
                                </div>
                                <p>
                                    <b>Зверніть увагу</b>, після того, як замовлення буде отримано перевізником на відділенні, вам необхідно отримати його <b>протягом 5 днів</b>. В іншому випадку буде здійснене автоповернення в інтернет-магазин.
                                </p>
                                <p><strong>ПОВЕРНЕННЯ</strong></p>

                                <p>“ЛЕГКЕ ПОВЕРНЕННЯ”</p>
                                <p>ПРИ ДОСТАВЦІ НОВОЮ ПОШТОЮ</p>

                                <p>Якщо товар не підійшов, можна легко оформити заявку повернення в застосунку Нової Пошти. Послуга безкоштовна</p>

                                <p><a style="text-decoration: underline;" href="https://dev.stimma.ua/pro-nas/garantiya-ta-povernennya/">Як це працює? </a> </p>

                                <p>Термін повернення та обміну товару здійснюється протягом 14 календарних днів з моменту продажу, відповідно до законодавства України, за умови збереження цілісності упаковки та оригінальності товару. Вживаний товар обміну та поверненню не підлягає.</p>
                                <?
                            }
                            else
                            {
                                ?>
                                <p>
                                    Отправка осуществляется после подтверждения менеджером вашего заказа.
                                </p>
                                <p>
                                    <b>Способ оплаты:</b>
                                </p>
                                <div>
                                    <ul>
                                        <li>
                                            100% оплата на реквизиты ФОП (реквизиты вышлет менеджер при выставлении счета). </li>
                                        <li>
                                            денежный перевод (только перевозчиком НОВА ПОШТА) </li>
                                    </ul>
                                    <span style="color: var(--basic_text_black);"><i>*Право выбора способа доставки и оплаты заказов остается за покупателем.</i></span><br>
                                </div>
                                <p>
                                    <b>Способ доставки:</b>
                                </p>
                                <div>
                                    <ul>
                                        <li>
                                            НОВА ПОШТА (отправки заказов каждый день) </li>
                                        <li>
                                            УКРПОШТА (отправка заказов каждую среду) </li>
                                        <li>
                                            самовывоз (г. Хмельницкий, ул. Святослава Хороброго 5)</li>
                                    </ul>
                                    <span style="color: var(--basic_text_black);">После оформления заказа на выбранную службу доставки, менеджер отправит вам уведомление с номером декларации, по которому вы сможете отследить и получить почтовое отправление.</span><br>
                                </div>
                                <p>
                                </p>
                                <p>
                                    <b>Обратите внимание</b>, что после того, как заказ будет получен перевозчиком на отделении, вам необходимо получить его <b>в течение 5 дней</b>. В противном случае будет осуществлено автовозврат в интернет-магазин.
                                </p>
                                <p><strong>ВОЗВРАТ</strong></p>

                                <p>“ЛЕГКИЙ ВОЗВРАТ”</p>
                                <p>ПРИ ДОСТАВКЕ НОВОЙ ПОЧТОЙ</p>

                                <p>Если товар не подошел, можна легко оформить заявку на возврат в приложении Новой Почты. Услуга бесплатная.</p>

                                <p><a style="text-decoration: underline;" href="https://dev.stimma.ua/ru/pro-nas/garantiya-ta-povernennya/">Как это работает? </a> </p>

                                <p>Срок возврата и обмена товара осуществляется на протяжении 14 дней с момента продажи, согласно к законодательству Украины, за условия сохранения целостности упаковки. Подержанный товар не подлежит обмену и возврату.</p>
                                <?
                            }
                            ?>
                        </div>
                    </div>
                    <?/*
                    <div class="card-info-text-block">
                        <div class="card-info-text-title">
                            Оплата
                        </div>
                        <div class="card-info-text-content">
                            <ul>
                                <li>100% передоплата на платіжну карту Приват Банку. Оплату можна робити через термінали ПриватБанку, каси банку або систему Приват 24. Реквізити платіжної картки ми відсилаємо на Ваш E-MAIL або на телефон SMS повідомленням.</li>
                                <li>Накладений платіж можливий, якщо доставка здійснюється Новою поштою. Вартість доставки (повернення) коштів оплачується покупцем, відповідно до тарифів перевізника.</li>
                            </ul>
                            <p>Право вибору способу оплати замовлень залишається за покупцем інтернет магазину STIMMA.COM.UA</p>
                        </div>
                    </div>
                    */?>
                </div>
                <div class="tab-pane fade" id="tab23">
                    <div class="reviews-empty">
                        <?=LANGUAGE_ID == 'ua' ? 'Відгуків немає, поки що.' : 'Отзывов нет, пока что'?>
                    </div>
                    <div class="reviews-cont">
                        <div class="reviews-add-comment">
                            <a href="#" class="reviews-add-comment-btn">
                                <?=LANGUAGE_ID == 'ua' ? 'Додати коментар' : 'Добавить комментарий'?>
                            </a>
                        </div>
                        <div class="reviews-form">
                            <form>
                                <input type="hidden" name="reviews-id-product" value="<?=$arResult['ID']?>">
                                <div class="form-group group2">
                                    <div class="form-wrap">
                                        <div class="form-wrap-title">
                                            <?=LANGUAGE_ID == 'ua' ? 'Ваше ім\'я' : 'Ваше имя'?>
                                            <span class="required">*</span>
                                        </div>
                                        <input type="text" name="name">
                                    </div>
                                    <div class="form-wrap">
                                        <div class="form-wrap-title">
                                            E-mail
                                        </div>
                                        <input type="text" name="email">
                                    </div>
                                </div>
                                <div class="form-wrap">
                                    <div class="form-wrap-title">
                                        <?=LANGUAGE_ID == 'ua' ? 'Ваша оцінка' : 'Ваша оценка'?>
                                    </div>
                                    <div class="wrap-stars-cont">
                                        <div class="star-block">
                                            <input id="star5" name="star" type="radio" value="5">

                                            <label for="star5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star4" name="star" type="radio" value="4">

                                            <label for="star4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star3" name="star" type="radio" value="3">

                                            <label for="star3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star2" name="star" type="radio" value="2">

                                            <label for="star2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star1" name="star" type="radio" value="1">

                                            <label for="star1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="star-rating">
                                            <?=LANGUAGE_ID == 'ua' ? 'Без оцінки' : 'Без оценки'?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrap">
                                    <div class="form-wrap-title">
                                        <?=LANGUAGE_ID == 'ua' ? 'Коментар' : 'Комментарий'?>
                                    </div>
                                    <textarea name="comment"></textarea>
                                </div>
                                <div class="fort-wrap-btn-block">
                                    <button type="submit" name="send_review" class="fort-wrap-btn"><?=LANGUAGE_ID == 'ua' ? 'ОПУБЛІКУВАТИ ВІДГУК' : 'ОПУБЛИКОВАТЬ ОТЗЫВ'?></button>
                                </div>
                            </form>
                        </div>
                        <div class="reviews-list">

                                <?
                                foreach ($arResult['REVIEW'] as $index => $review)
                                {
                                    ?>
                                    <div class="reviews-item">
                                        <div class="reviews-item-head">
                                        <div class="reviews-item-name">
                                            <?=$review['NAME']?>
                                        </div>
                                        <div class="reviews-item-star">
                                            <?
                                            for ($i = 1; $i <= 5; $i++)
                                            {
                                                ?>
                                                <span class="<?=$i <= $review['PROPERTY_RATING_VALUE'] ? 'active' : ''?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                        <defs></defs>
                                                        <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                    </svg>
                                                </span>
                                                <?
                                            }
                                            ?>
                                        </div>
                                    </div>
                                        <div class="reviews-item-body">
                                        <?/*<div class="reviews-item-body-title">
                                            Комментарій
                                        </div>*/?>
                                        <div class="reviews-item-body-text">
                                            <?=$review['PREVIEW_TEXT']?>
                                        </div>
                                    </div>
                                    </div>
                                    <?
                                }
                                ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?
$typeFile = 'female.php';
$res = CIBlockSection::GetNavChain($arParams['IBLOCK_ID'], $arResult['IBLOCK_SECTION_ID'], array('ID', 'NAME'));
while($section = $res->Fetch())
{
    if($section['ID'] == 347)
    {
        $typeFile = 'female.php';
        break;
    }
    if($section['ID'] == 362)
    {
        $typeFile = 'kids_male.php';
        break;
    }
    if($section['ID'] == 363)
    {
        $typeFile = 'kids_female.php';
        break;
    }
}
?>
    <div class="card-info-size-cont">
        <div class="card-info-size-close">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.62012 4.37985L13.6201 13.3799" stroke="#3D441D" stroke-linecap="round"></path>
                <path d="M13.5 4.50006L4.5 13.5001" stroke="#3D441D" stroke-linecap="round"></path>
            </svg>
        </div>
        <div class="card-info-size-table-cont">
            <?include $typeFile;?>

        </div>
    </div>

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
    $slider[] = '"https://dev.stimma.ua'.$item['ORIGINAL'].'"';

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
    </script>
    <script type="application/ld+json">
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
                "availability": "https://schema.org/InStock",
                "price": "<?=$arResult['OFFERS'][$arResult['SELECTED_OFFER']]['MIN_PRICE']['DISCOUNT_VALUE']?>",
                "priceCurrency": "UAH",
                "priceValidUntil": "<?=date('Y')?>-12-31",
                "review": <?=implode(',',$jsonReview)?>,
                "aggregateRating": {
                    "@type": "AggregateRating",
                    "ratingValue": "<?=!$rating ? 0 : round($count/$rating)?>",
                    "reviewCount": "<?=$count?>"
                }
            }
        }
    </script>

<?php
unset($actualItem, $itemIds, $jsParams);
