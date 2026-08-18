<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $arCurSection
 */

if(LANGUAGE_ID == 'ua')
{
    $section = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['VARIABLES']['SECTION_ID']], false,
     ['ID','IBLOCK_ID', 'NAME' ,'UF_*']) -> Fetch();
    if($section['UF_NAME_UA'])
        $section = $section['UF_NAME_UA'];
    else
        $section = $section['NAME'];
}
else
    $section = CIBlockSection::GetByID($arResult['VARIABLES']['SECTION_ID'])->Fetch()['NAME'];

/*global $seo,$selectedFilter;

if(!empty($selectedFilter))
{
    // COLOR RAZMER VID SOSTAV SELECTION STYLES PRINT
    $arFilters = ['COLOR', 'RAZMER', 'VID', 'SOSTAV', 'SELECTION', 'STYLES', 'PRINT'];
    foreach($selectedFilter as $index => $item)
    {
        foreach($seo as $index2 => $item2)
            $seo[$index2] = str_replace('{'.$item['code'].'}', $item['value'], $seo[$index2]);
    }
    foreach($arFilters as $index => $item)
    {
        foreach($seo as $index2 => $item2)
            $seo[$index2] = str_replace('{'.$item.'}', $item, $seo[$index2]);
    }
}
if(isset($_GET['p']))
{
    ?><pre><?=print_r($selectedFilter, 1)?></pre><?
    ?><pre><?=print_r($seo, 1)?></pre><?
}
*/

//if(!$seo['ELEMENT_PAGE_TITLE'] && $section)
//    $seo['ELEMENT_PAGE_TITLE'] = $section;

?>
<div class="page-title">
    <h1 class="page-title-text" style="<?=strpos($APPLICATION -> GetCurPage(), '/rasprodazha/') !== false ? 'color:#8B0000;' : ''?>">
        <?$APPLICATION->ShowViewContent('mdf_title');?>
        <?//=$seo['ELEMENT_PAGE_TITLE'] ? $seo['ELEMENT_PAGE_TITLE'] : $section?>
        <?=$seo['ELEMENT_PAGE_TITLE'] ? '' : $section?>
        <?//=$APPLICATION->ShowTitle()?>
        <?
        //$APPLICATION->SetTitle($seo['ELEMENT_PAGE_TITLE'] ? $seo['ELEMENT_PAGE_TITLE'] : $section);
        //$APPLICATION->SetTitle('Бомбери');
        ?>
    </h1>
</div>
<?
if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
	$basketAction = isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '';
else
	$basketAction = isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '';


$sectionListParams = array(
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
    "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
    "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
    "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
    "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
    "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
);
if ($sectionListParams["COUNT_ELEMENTS"] === "Y")
{
    $sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_ACTIVE";
    if ($arParams["HIDE_NOT_AVAILABLE"] == "Y")
    {
        $sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_AVAILABLE";
    }
}
$APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list",
    "",
    $sectionListParams,
    $component,
    array("HIDE_ICONS" => "Y")
);
unset($sectionListParams);


if(!$arParams["IS_NEW"])
$APPLICATION->IncludeComponent(
    "bitrix:catalog.smart.filter",
    "",
    array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "SECTION_ID" => $arCurSection['ID'],
        "FILTER_NAME" => $arParams["FILTER_NAME"],
        "PRICE_CODE" => $arParams["~PRICE_CODE"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "SAVE_IN_SESSION" => "N",
        "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
        "XML_EXPORT" => "N",
        "SECTION_TITLE" => "NAME",
        "SECTION_DESCRIPTION" => "DESCRIPTION",
        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
        "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
        "SEF_MODE" => $arParams["SEF_MODE"],
        "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
        "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
        "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
    ),
    $component,
    array('HIDE_ICONS' => 'Y')
);
?>



<?
global $MAX_SMART_FILTER;
if(isset($MAX_SMART_FILTER['>=CATALOG_PRICE_1']))
    $MAX_SMART_FILTER['>=PROPERTY_MINIMUM_PRICE'] = $MAX_SMART_FILTER['>=CATALOG_PRICE_1'];
if(isset($MAX_SMART_FILTER['<=CATALOG_PRICE_1']))
    $MAX_SMART_FILTER['<=PROPERTY_MINIMUM_PRICE'] = $MAX_SMART_FILTER['<=CATALOG_PRICE_1'];
if(isset($MAX_SMART_FILTER['><CATALOG_PRICE_1']))
{
    $MAX_SMART_FILTER['>=PROPERTY_MINIMUM_PRICE'] = $MAX_SMART_FILTER['><CATALOG_PRICE_1'][0];
    $MAX_SMART_FILTER['<=PROPERTY_MINIMUM_PRICE'] = $MAX_SMART_FILTER['><CATALOG_PRICE_1'][1];
}

$arParams["ELEMENT_SORT_FIELD"] = isset($_GET['by']) ? $_GET['by'] : "SORT";
$arParams["ELEMENT_SORT_ORDER"] = isset($_GET['sort']) ? $_GET['sort'] : "DESC";

$arParams["ELEMENT_SORT_FIELD2"] = "ID";
$arParams["ELEMENT_SORT_ORDER2"] = "DESC";

$optIDs = [
    25595, 25599,24889, 24893,8457, 8461,9129, 9133, 9137,4912, 5799, 5803,5815, 5818, 5821, 5824,5807, 5811,24818, 24822,5574, 5578, 7515, 7518,8054, 8058, 8062,25151, 25154,25497, 25501,25147,4966,24920, 25625,5835,25205, 25209,25213, 25216,25229, 25232, 25235,5065, 5067, 5069,5490, 5494, 5498, 7404,24948, 24951, 24954, 24957,5768, 5772,25165, 25169,25063, 25067,25393, 25401, 25397,25127, 25131, 25135,7999, 8003,25405, 25413, 25409,8204, 8208,24877, 24881,5071, 5074, 5077,25139, 25143,5179, 5182,5128, 5131,25949, 25953, 25957,24936, 24940, 24944,24924, 24928, 24932,25661, 25666, 25671,26460, 26465,5567, 5571,5459, 5462, 5465,4916, 4919,5541, 5545,26104, 26109,26094, 26099,25694, 25698,25819, 25815,25219, 25222, 25262, 25266, 25270, 25274,5791, 5795,5590, 5839,5480, 8626, 8630,24969, 24974, 24979,5038,25981, 25985,5288, 5291, 5294,5143, 5146, 5149,25091, 25095,25099, 25104, 25109,5055, 5058,25859, 25870,5135, 5138, 5140,24907, 24910, 24913, 25824,25193, 25201,25433, 25438, 25443,5827, 5831,25157, 25161,25553, 25456,25644, 25640,25649,4990, 25834, 25839,5362, 5365,26137, 26142, 26147,26393, 26398, 26402,25676, 25679,26370, 26375,26380,26470, 26474, 26478,26707, 26712, 26717,25603, 25608,25629,26813,25829
];
$uGrops = $USER -> GetUserGroupArray();
if(($APPLICATION -> GetCurPage() == '/catalog/rasprodazha/'||$APPLICATION -> GetCurPage() == '/ru/catalog/rasprodazha/') && in_array(9, $uGrops))
    //$MAX_SMART_FILTER['ID'] = $optIDs;
//else
    $MAX_SMART_FILTER['!ID'] = $optIDs;

if(($APPLICATION -> GetCurPage() == '/catalog/rasprodazha/'||$APPLICATION -> GetCurPage() == '/ru/catalog/rasprodazha/'||$APPLICATION -> GetCurPage() == '/catalog/khity_prodazh/'||$APPLICATION -> GetCurPage() == '/ru/catalog/khity_prodazh/'))
{
    $MAX_SMART_FILTER['>SORT'] = 0;
}

$intSectionID = $APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "main",
    array(
        "SEND_STATISTIC" => 'Y',
        "FILES" => $arParams["FILES"],
        "IS_NEW" => $arParams["IS_NEW"],
        "IS_SALE" => $arParams["IS_SALE"],
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
        "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
        "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
        "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
        "PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
        "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
        "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
        "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
        "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
        "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
        "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
        "BASKET_URL" => $arParams["BASKET_URL"],
        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
        "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
        "FILTER_NAME" => $arParams["FILTER_NAME"],
        "CACHE_TYPE" => isset($_POST['get_catalog_ajax_filter']) && $_POST['get_catalog_ajax_filter'] == 'y' ? 'N' : $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "SET_TITLE" => $arParams["SET_TITLE"],
        "MESSAGE_404" => $arParams["~MESSAGE_404"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "SHOW_404" => $arParams["SHOW_404"],
        "FILE_404" => $arParams["FILE_404"],
        "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
        "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
        "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
        "PRICE_CODE" => $arParams["~PRICE_CODE"],
        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
        "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
        "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
        "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
        "PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
        "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
        "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
        "LAZY_LOAD" => $arParams["LAZY_LOAD"],
        "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
        "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

        "OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
        "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
        "OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
        "OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
        "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
        'HIDE_NOT_AVAILABLE' => 'N',//$arParams["HIDE_NOT_AVAILABLE"],
        'HIDE_NOT_AVAILABLE_OFFERS' => 'N',//$arParams["HIDE_NOT_AVAILABLE_OFFERS"],

        'LABEL_PROP' => $arParams['LABEL_PROP'],
        'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
        'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
        'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
        'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
        'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
        'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
        'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
        'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
        'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
        'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
        'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

        'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
        'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
        'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
        'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
        'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
        'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
        'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
        'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
        'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
        'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
        'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
        'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
        'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
        'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
        'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

        'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
        'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
        'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

        'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
        "ADD_SECTIONS_CHAIN" => "N",
        'ADD_TO_BASKET_ACTION' => $basketAction,
        'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
        'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
        'COMPARE_NAME' => $arParams['COMPARE_NAME'],
        'USE_COMPARE_LIST' => 'Y',
        'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
        'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
        'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
    ),
    false
);


require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/cache.php';
$cache = cache::getInstance();
global $reviewS;
$apppage = isset($_SERVER['REQUEST_URI_OLD']) ? $_SERVER['REQUEST_URI_OLD'] : $APPLICATION -> GetCurPage();
$apppageCode = CUtil::translit($apppage, 'ru');

global $minGlobalPrice,$maxGlobalPrice;
$res = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['VARIABLES']['SECTION_ID']], false, ['ID','IBLOCK_ID','UF_*'])->Fetch();
$minGlobalPrice = $res['UF_MIN_PRICE'];
$maxGlobalPrice = $res['UF_MAX_PRICE'];
if($cache -> isStartCache($apppageCode, 86400*5))
{

    global $MAX_SMART_FILTER;

    if(!empty($MAX_SMART_FILTER))
        $filter = $MAX_SMART_FILTER;
    else
        $filter = [];

    $filter['IBLOCK_ID'] = 21;
    $filter['SECTION_ID'] = $arResult['VARIABLES']['SECTION_ID'];
    $filter['INCLUDE_SUBSECTIONS'] = 'Y';
    $filter['ACTIVE'] = 'Y';
    $filter['>CATALOG_QUNATITY'] = 0;

    $thisSection = CIBlockSection::GetList(array(), ['IBLOCK_ID' => 21, 'ID' => $arResult['VARIABLES']['SECTION_ID']], false, ['ID', 'NAME', 'UF_*']) -> Fetch();
    $reviewS = array();
    $cnt = CIBlockElement::GetList(array(), $filter, array());
    $min = CIBlockElement::GetList(array('PROPERTY_MINIMUM_PRICE' => 'asc'), $filter+['>PROPERTY_MINIMUM_PRICE' => 0], false,['nTopCount' => 1], ['ID','IBLOCK_ID', 'CODE','PROPERTY_MINIMUM_PRICE','PREVIEW_PICTURE']) -> Fetch();
    $max = CIBlockElement::GetList(array('PROPERTY_MINIMUM_PRICE' => 'desc'), $filter+['>PROPERTY_MINIMUM_PRICE' => 0], false,['nTopCount' => 1], ['ID','IBLOCK_ID', 'PROPERTY_MINIMUM_PRICE']) -> Fetch()['PROPERTY_MINIMUM_PRICE_VALUE'];
    $image = 'https://dev.stimma.ua'.CFile::GetFileArray($min['PREVIEW_PICTURE'])['SRC'];

    $idsRes = CIBlockElement::GetList(array(), $filter);
    $ids = [];
    while ($rec = $idsRes->Fetch())
        $ids[] = $rec['ID'];

    $cntReview = 0;
    $cntReviewRes = CIBlockElement::GetList(array(), ['IBLOCK_ID' => 35, 'ACTIVE' => 'Y', 'PROPERTY_SECTIONS' => $thisSection['ID']]);
    while ($res = $cntReviewRes -> Fetch())
        $reviewS['ID'][$res['ID']] = $res['ID'];
    $cntReview = count($reviewS['ID']);

    $result = [
        'thisSection' => $thisSection,
        'reviewS' => $reviewS,
        'cnt' => $cnt,
        'min' => $min,
        'max' => $max,
        'image' => $image,
        'cntReview' => $cntReview,
    ];

    $cache->endCache($result);
}
else
{
    $result = $cache -> getCacheVars();
    $thisSection = $result['thisSection'];
    $reviewS = $result['reviewS'];
    $cnt = $result['cnt'];
    $min = $result['min'];
    $max = $result['max'];
    $image = $result['image'];
    $cntReview = $result['cntReview'];
}
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"section_review",
	array(
		"IBLOCK_TYPE" => "-",
		"IBLOCK_ID" => "35",
		"NEWS_COUNT" => "9",
		"SORT_BY1" => "ID",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "ID",
		"SORT_ORDER2" => "ASC",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_PICTURE",
			2 => "CREATED_DATE",
			3 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "RATING",
			1 => "",
			2 => "",
			3 => "",
		),
		"CHECK_DATES" => "N",
		"FILTER_NAME" => "reviewS",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "150",
		"ACTIVE_DATE_FORMAT" => "Y-m-d",
		"CREATED_DATE_FORMAT" => "Y-m-d",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SHOW_DETAIL_LINK" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"COMPONENT_TEMPLATE" => "list_review_section",
		"SET_LAST_MODIFIED" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"STRICT_SECTION_CHECK" => "N"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y",
		"HIDE_ICONS" => "N"
	)
);
$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
$section = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $intSectionID], false, ['ID','DESCRIPTION','UF_*']) -> Fetch();

if(!isset($_GET['PAGEN_1']))
{
    if(isset($_SERVER['ELEMENT_ID']) && $_SERVER['ELEMENT_ID'] > 0)
    {
        $seOELement = CIBlockElement::GetByID($_SERVER['ELEMENT_ID'])->GetNextElement();

        $seoFields = $seOELement->GetFields();
        $seoProps = $seOELement->GetProperties();

        if($seoProps['SEO_RU_TEXT']['~VALUE']['TEXT'] && LANGUAGE_ID=='ru')
        {
            ?>
            <div class="seo_text">
                <?=$seoProps['SEO_RU_TEXT']['~VALUE']['TEXT']?>
            </div>
            <?
        }
        elseif($seoProps['SEO_UA_TEXT']['~VALUE']['TEXT'] && LANGUAGE_ID=='ua')
        {
            ?>
            <div class="seo_text">
                <?=$seoProps['SEO_UA_TEXT']['~VALUE']['TEXT']?>
            </div>
            <?
        }
        else
        {
            if($seoFields['IBLOCK_SECTION_ID'])
            {
                $getSection = CIBlockSection::GetList([],['IBLOCK_ID'=>40, 'ID'=>$seoFields['IBLOCK_SECTION_ID']],false,['ID','IBLOCK_ID','DESCRIPTION','UF_*'])->Fetch();
                $text = LANGUAGE_ID=='ua'?$getSection['DESCRIPTION']:$getSection['UF_SEO_RU_TEXT'];

                if(!$text && $getSection['IBLOCK_SECTION_ID'])
                {
                    $getSection = CIBlockSection::GetList([],['IBLOCK_ID'=>40, 'ID'=>$seoFields['IBLOCK_SECTION_ID']],false,['ID','IBLOCK_ID','DESCRIPTION','UF_*'])->Fetch();
                    $text = LANGUAGE_ID=='ua'?$getSection['DESCRIPTION']:$getSection['UF_SEO_RU_TEXT'];

                    if(!$text && $getSection['IBLOCK_SECTION_ID'])
                    {
                        $getSection = CIBlockSection::GetList([],['IBLOCK_ID'=>40, 'ID'=>$seoFields['IBLOCK_SECTION_ID']],false,['ID','IBLOCK_ID','DESCRIPTION','UF_*'])->Fetch();
                        $text = LANGUAGE_ID=='ua'?$getSection['DESCRIPTION']:$getSection['UF_SEO_RU_TEXT'];
                    }
                }

                if(!empty($text))
                {
                    ?>
                    <div class="seo_text">
                        <?=$text?>
                    </div>
                    <?
                }
            }
        }
    }
    else
    {
        ?>
        <div class="seo_text">
            <?=LANGUAGE_ID=='ua' ? $section['UF_DETAIL_TEXT_UA'] : $section['DESCRIPTION']?>
        </div>
        <?
    }
}
?>

<?/*$this->SetViewTarget("more_text_title");?>
<span class="element-count-wrapper"><span class="element-count muted font_xs rounded3">asdasd<?=$arResult['SECTION']['ELEMENT_CNT'];?></span></span>
<?$this->EndViewTarget();*/?>
<script type="application/ld+json">
                        {
                            "@context": "http://schema.org/",
                            "@type": "Product",
                            "name": "<?=$APPLICATION->GetPageProperty('title');?>",
                            "image": "<?=$image?>",
                            <?/*"brand": "Apple",*/?>
                            "description": "<?=$APPLICATION->GetPageProperty('description');?>",
                        "aggregateRating": {
                            "@type": "AggregateRating",
                            "bestRating": "5",
                            "ratingValue": "<?=$cntReview > 0 ? 4 : 5//=$thisSection['UF_AVG_REVIEW'] ? intval($thisSection['UF_AVG_REVIEW']) : 5?>",
                            "ratingCount": "<?=$cntReview//=$thisSection['UF_CNT_REVIEW'] ? intval($thisSection['UF_CNT_REVIEW']) : 1?>"
                        },"offers": {
                            "@type": "AggregateOffer",
                            "lowPrice": "<?=intval($min['PROPERTY_MINIMUM_PRICE_VALUE'])?>",
                            "highPrice": "<?=intval($max)?>",
                            "offerCount": "<?=intval($cnt)?>",
                            "priceCurrency": "UAH"
                        }}
                    </script>


