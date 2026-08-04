<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>

<?global $arTheme, $isHideLeftBlock, $isWidePage;?>
<?
if(isset($arParams["TYPE_LEFT_BLOCK_DETAIL"]) && $arParams["TYPE_LEFT_BLOCK_DETAIL"]!='FROM_MODULE'){
	$arTheme['LEFT_BLOCK']['VALUE'] = $arParams["TYPE_LEFT_BLOCK_DETAIL"];
}

if(isset($arParams["SIDE_LEFT_BLOCK_DETAIL"]) && $arParams["SIDE_LEFT_BLOCK_DETAIL"]!='FROM_MODULE'){
	$arTheme['SIDE_MENU']['VALUE'] = $arParams["SIDE_LEFT_BLOCK_DETAIL"];
}

if($arTheme['HIDE_SUBSCRIBE']['VALUE'] == 'Y'){
	$arParams["USE_SUBSCRIBE_IN_TOP"] = "N";
}
?>

<?

if(!$isHideLeftBlock && $APPLICATION->GetProperty("HIDE_LEFT_BLOCK_DETAIL") == "Y"){
	$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "Y");
	$APPLICATION->AddViewContent('container_inner_class', ' contents_page ');
	$APPLICATION->AddViewContent('wrapper_inner_class', ' wide_page ');
	if(!$isWidePage){
		$APPLICATION->AddViewContent('right_block_class', ' maxwidth-theme ');		
	}
}

?>

<?
// get element
$arItemFilter = CMax::GetCurrentElementFilter($arResult['VARIABLES'], $arParams);

global $APPLICATION, $arRegion, $bLongBanner;
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/animation/animate.min.css');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/animation/animation_ext.css');
//$bLongBanner = true;

//var_dump($bLongBanner);

if($arParams['CACHE_GROUPS'] == 'Y')
{
	$arItemFilter['CHECK_PERMISSIONS'] = 'Y';
	$arItemFilter['GROUPS'] = $GLOBALS["USER"]->GetGroups();
}

$arElement = CMaxCache::CIblockElement_GetList(array('CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'N')), $arItemFilter, false, false, array('ID', 'PREVIEW_TEXT', 'IBLOCK_SECTION_ID', 'PREVIEW_PICTURE', 'ACTIVE_FROM', 'ACTIVE_TO', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL', 'LIST_PAGE_URL', 'PROPERTY_LINK_PROJECTS', 'PROPERTY_LINK_GOODS', 'PROPERTY_LINK_REVIEWS', 'PROPERTY_LINK_STAFF', 'PROPERTY_LINK_SERVICES', 'PROPERTY_FORM_QUESTION', 'PROPERTY_LINK_REGION', 'PROPERTY_LINK_GOODS_FILTER', 'PERIOD', 'SALE_NUMBER'));


if($arParams["SHOW_MAX_ELEMENT"] == "Y")
{
	$arSort=array($arParams["SORT_BY1"] => $arParams["SORT_ORDER1"], $arParams["SORT_BY2"] => $arParams["SORT_ORDER2"]);
	$arElementNext = array();

	$arAllElements = CMaxCache::CIblockElement_GetList(array($arParams["SORT_BY1"] => $arParams["SORT_ORDER1"], $arParams["SORT_BY2"] => $arParams["SORT_ORDER2"], 'CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'Y')), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y", "SECTION_ID" => $arElement["IBLOCK_SECTION_ID"]/*, ">ID" => $arElement["ID"]*/ ), false, false, array('ID', 'DETAIL_PAGE_URL', 'IBLOCK_ID', 'SORT'));
	if($arAllElements)
	{
		$url_page = $APPLICATION->GetCurPage();
		$key_item = 0;
		foreach($arAllElements as $key => $arItemElement)
		{
			if($arItemElement["DETAIL_PAGE_URL"] == $url_page)
			{
				$key_item = $key;
				break;
			}
		}
		if(strlen($key_item))
		{
			$arElementNext = $arAllElements[$key_item+1];
		}
		if($arElementNext)
		{
			if($arElementNext["DETAIL_PAGE_URL"] && is_array($arElementNext["DETAIL_PAGE_URL"])){
				$arElementNext["DETAIL_PAGE_URL"]=current($arElementNext["DETAIL_PAGE_URL"]);
			}
		}
	}
}
?>

<?if(!$arElement && $arParams['SET_STATUS_404'] !== 'Y'):?>
	<div class="alert alert-warning"><?=GetMessage("ELEMENT_NOTFOUND")?></div>
<?elseif(!$arElement && $arParams['SET_STATUS_404'] === 'Y'):?>
	<?CMax::goto404Page();?>
<?else:?>
    <?$APPLICATION->IncludeComponent(
            "bitrix:news.detail",
            "news",
            Array(
                    "S_ASK_QUESTION" => $arParams["S_ASK_QUESTION"],
                    "S_ORDER_SERVISE" => $arParams["S_ORDER_SERVISE"],
                    "T_GALLERY" => $arParams["T_GALLERY"],
                    "T_DOCS" => $arParams["T_DOCS"],
                    "T_GOODS" => $arParams["T_GOODS"],
                    "T_SERVICES" => $arParams["T_SERVICES"],
                    "T_PROJECTS" => $arParams["T_PROJECTS"],
                    "T_REVIEWS" => $arParams["T_REVIEWS"],
                    "T_STAFF" => $arParams["T_STAFF"],
                    "T_VIDEO" => $arParams["T_VIDEO"],
                    "FORM_ID_ORDER_SERVISE" => ($arParams["FORM_ID_ORDER_SERVISE"] ? $arParams["FORM_ID_ORDER_SERVISE"] : 'SERVICES'),
                    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                    "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
                    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
                    "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
                    "DETAIL_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                    "SECTION_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "META_KEYWORDS" => $arParams["META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
                    "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                    "SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                    "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
                    "ADD_ELEMENT_CHAIN" => $arParams["ADD_ELEMENT_CHAIN"],
                    "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                    "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
                    "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                    "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
                    "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
                    "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                    "USE_SHARE" 			=> $arParams["USE_SHARE"],
                    "SHARE_HIDE" 			=> $arParams["SHARE_HIDE"],
                    "SHARE_TEMPLATE" 		=> $arParams["SHARE_TEMPLATE"],
                    "SHARE_HANDLERS" 		=> $arParams["SHARE_HANDLERS"],
                    "SHARE_SHORTEN_URL_LOGIN"	=> $arParams["SHARE_SHORTEN_URL_LOGIN"],
                    "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                    "GALLERY_TYPE" => $arParams["GALLERY_TYPE"],
                    "DETAIL_USE_COMMENTS" => $arParams["DETAIL_USE_COMMENTS"],
                    "DETAIL_BLOG_USE" => $arParams["DETAIL_BLOG_USE"],
                    "DETAIL_BLOG_URL" => $arParams["DETAIL_BLOG_URL"],
                    "DETAIL_BLOG_EMAIL_NOTIFY" => $arParams["DETAIL_BLOG_EMAIL_NOTIFY"],
                    "DETAIL_VK_USE" => $arParams["DETAIL_VK_USE"],
                    "DETAIL_VK_API_ID" => $arParams["DETAIL_VK_API_ID"],
                    "DETAIL_FB_USE" => $arParams["DETAIL_FB_USE"],
                    "DETAIL_FB_APP_ID" => $arParams["DETAIL_FB_APP_ID"],
                    "COMMENTS_COUNT" => $arParams["COMMENTS_COUNT"],
                    "BLOG_TITLE" => $arParams["BLOG_TITLE"],
                    "VK_TITLE" => $arParams["VK_TITLE"],
                    "FB_TITLE" => $arParams["FB_TITLE"],
                    "STAFF_TYPE" => $arParams["STAFF_TYPE_DETAIL"],
                    "IBLOCK_LINK_NEWS_ID" => $arParams["IBLOCK_LINK_NEWS_ID"],
                    "IBLOCK_LINK_BLOG_ID" => $arParams["IBLOCK_LINK_BLOG_ID"],
                    "IBLOCK_LINK_SERVICES_ID" => $arParams["IBLOCK_LINK_SERVICES_ID"],
                    "IBLOCK_LINK_TIZERS_ID" => $arParams["IBLOCK_LINK_TIZERS_ID"],
                    "IBLOCK_LINK_REVIEWS_ID" => $arParams["IBLOCK_LINK_REVIEWS_ID"],
                    "IBLOCK_LINK_STAFF_ID" => $arParams["IBLOCK_LINK_STAFF_ID"],
                    "IBLOCK_LINK_VACANCY_ID" => $arParams["IBLOCK_LINK_VACANCY_ID"],
                    "IBLOCK_LINK_PROJECTS_ID" => $arParams["IBLOCK_LINK_PROJECTS_ID"],
                    "IBLOCK_LINK_BRANDS_ID" => $arParams["IBLOCK_LINK_BRANDS_ID"],
                    "IBLOCK_LINK_LANDINGS_ID" => $arParams["IBLOCK_LINK_LANDINGS_ID"],
                    "IBLOCK_LINK_PARTNERS_ID" => $arParams["IBLOCK_LINK_PARTNERS_ID"],
                    "BLOCK_SERVICES_NAME" => $arParams["BLOCK_SERVICES_NAME"],
                    "BLOCK_NEWS_NAME" => $arParams["BLOCK_NEWS_NAME"],
                    "BLOCK_BLOG_NAME" => $arParams["BLOCK_BLOG_NAME"],
                    "BLOCK_TIZERS_NAME" => $arParams["BLOCK_TIZERS_NAME"],
                    "BLOCK_REVIEWS_NAME" => $arParams["BLOCK_REVIEWS_NAME"],
                    "BLOCK_STAFF_NAME" => $arParams["BLOCK_STAFF_NAME"],
                    "BLOCK_VACANCY_NAME" => $arParams["BLOCK_VACANCY_NAME"],
                    "BLOCK_PROJECTS_NAME" => $arParams["BLOCK_PROJECTS_NAME"],
                    "BLOCK_BRANDS_NAME" => $arParams["BLOCK_BRANDS_NAME"],
                    "BLOCK_LANDINGS_NAME" => $arParams["BLOCK_LANDINGS_NAME"],
                    "BLOCK_PARTNERS_NAME" => $arParams["BLOCK_PARTNERS_NAME"],
                    "DETAIL_BLOCKS_ALL_ORDER" => ($arParams["DETAIL_BLOCKS_ALL_ORDER"] ? $arParams["DETAIL_BLOCKS_ALL_ORDER"] : 'tizers,desc,char,docs,services,news,blog,vacancy,reviews,projects,staff,landings,comments'),
                    "CONTENT_LINKED_FILTER_BY_FILTER" => ($arTmpGoods['CHILDREN'] ? $arElement['~PROPERTY_LINK_GOODS_FILTER_VALUE']:''),
                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                    "STORES" => $arParams["STORES"],
                    "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                    "DISPLAY_ELEMENT_SLIDER" => $arParams["LINKED_ELEMENST_PAGE_COUNT"],
                    "LINKED_ELEMENST_PAGINATION" => $arParams["LINKED_ELEMENST_PAGINATION"],
                    "SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
                    "DETAIL_LINKED_GOODS_SLIDER" => $arParams["DETAIL_LINKED_GOODS_SLIDER"],
                    "SHOW_TOP_PROJECT_BLOCK" => $arParams["SHOW_TOP_PROJECT_BLOCK"],
                    "MAIN_GALLERY_PROPERTY_CODE" => $arParams["MAIN_GALLERY_PROPERTY_CODE"],
                    "TOP_GALLERY_PROPERTY_CODE" => $arParams["TOP_GALLERY_PROPERTY_CODE"],

                    "LINKED_ELEMENT_TAB_SORT_FIELD" => $arParams["LINKED_ELEMENT_TAB_SORT_FIELD"],
                    "LINKED_ELEMENT_TAB_SORT_ORDER" => $arParams["LINKED_ELEMENT_TAB_SORT_ORDER"],
                    "LINKED_ELEMENT_TAB_SORT_FIELD2" => $arParams["LINKED_ELEMENT_TAB_SORT_FIELD2"],
                    "LINKED_ELEMENT_TAB_SORT_ORDER2" => $arParams["LINKED_ELEMENT_TAB_SORT_ORDER2"],

                    "SHOW_SECTIONS_FILTER" => $arParams["SHOW_SECTIONS_FILTER"],
                    "IS_AJAX_SECTIONS" => (strtolower($_REQUEST['ajax_get_sections']) == 'y'),
                    "FROM_AJAX" => (CMax::checkAjaxRequest() && strtolower($_REQUEST['ajax']) == 'y'),
                    "TAGS_SECTION_COUNT" => $arParams["TAGS_SECTION_COUNT"],
                    "DISPLAY_LINKED_PAGER" => ($arParams["DETAIL_LINKED_GOODS_SLIDER"] == "Y") ? "N" : $arParams["DISPLAY_LINKED_PAGER"],
                    "MAX_GALLERY_ITEMS" => $arParams["MAX_GALLERY_ITEMS"],
                    "SHOW_GALLERY" => isset($arParams["SHOW_GALLERY_GOODS"]) ? $arParams["SHOW_GALLERY_GOODS"] : "N",
                    "SHOW_PROPS" => (CMax::GetFrontParametrValue("SHOW_PROPS_BLOCK") == "Y" ? "Y" : "N"),
                    'SHOW_POPUP_PRICE' => (CMax::GetFrontParametrValue('SHOW_POPUP_PRICE') == 'Y'),
                    "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                    "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                    "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                    'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
                    "ADD_DETAIL_TO_SLIDER" => $arParams["ADD_DETAIL_TO_SLIDER"],
                    "SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
                    "SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
                    "SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
                    "SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
                    "SHOW_ONE_CLICK_BUY" => $arParams["SHOW_ONE_CLICK_BUY"],
                    "SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
                //"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                    "SALE_STIKER" => $arParams["SALE_STIKER"],
                    "STIKERS_PROP" => $arParams["STIKERS_PROP"],
                    "SHOW_RATING" => $arParams["SHOW_RATING"],
                    "ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
                    "DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
                    "LINKED_PROPERTY_CODE" => $arParams["LINKED_PROPERTY_CODE"],
                    "SHOW_COUNT_ELEMENTS" => $arParams["SHOW_COUNT_ELEMENTS"],
                    "SECTIONS_TAGS_DEPTH_LEVEL" => $arParams["SECTIONS_TAGS_DEPTH_LEVEL"],
            ),
            $component
    );?>


	<?if(($arParams["LINKED_ELEMENT_TAB_SORT_FIELD"] == "REGION_PRICE" || $arParams["LINKED_ELEMENT_TAB_SORT_FIELD2"] == "REGION_PRICE")
		&& $arParams["SORT_REGION_PRICE"]) {
		$arPriceSort = [];
		global $arRegion;
		if ($arRegion) {
			if (!$arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"] || $arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"] == "component") {
				$price = CCatalogGroup::GetList(array(), array("NAME" => $arParams["SORT_REGION_PRICE"]), false, false, array("ID", "NAME"))->GetNext();
				$arPriceSort = array("CATALOG_PRICE_".$price["ID"]);
			} else {
				$arPriceSort = array("CATALOG_PRICE_".$arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"]);
			}
		}
		if ($arPriceSort) {
			if ($arParams["LINKED_ELEMENT_TAB_SORT_FIELD"] == "REGION_PRICE") {
				$arParams["LINKED_ELEMENT_TAB_SORT_FIELD"] = $arPriceSort[0];
			}
			if ($arParams["LINKED_ELEMENT_TAB_SORT_FIELD2"] == "REGION_PRICE") {
				$arParams["LINKED_ELEMENT_TAB_SORT_FIELD2"] = $arPriceSort[0];
			}
		}
	}?>
	<?/*CMax::AddMeta(
		array(
			'og:description' => $arElement['PREVIEW_TEXT'],
			'og:image' => (($arElement['PREVIEW_PICTURE'] || $arElement['DETAIL_PICTURE']) ? CFile::GetPath(($arElement['PREVIEW_PICTURE'] ? $arElement['PREVIEW_PICTURE'] : $arElement['DETAIL_PICTURE'])) : false),
		)
	);*/?>
	<?
	/* hide compare link from module options */
	if(CMax::GetFrontParametrValue('CATALOG_COMPARE') == 'N')
		$arParams["DISPLAY_COMPARE"] = 'N';
	/**/
	?>
	<?
	$bActiveDate = (strlen($arElement['PERIOD']['VALUE'] )&& in_array('PERIOD', $arParams['DETAIL_PROPERTY_CODE'])) || ($arElement['ACTIVE_FROM'] && in_array('DATE_ACTIVE_FROM', $arParams['DETAIL_FIELD_CODE']));
	$bDiscountCounter = ($arElement['ACTIVE_TO'] && in_array('ACTIVE_TO', $arParams['DETAIL_FIELD_CODE']));
	$bShowDopBlock = (($arElement['SALE_NUMBER']['VALUE'] && in_array('SALE_NUMBER', $arParams['DETAIL_PROPERTY_CODE'])) || $bDiscountCounter);
	$bShowPeriodLine = $bActiveDate || $bShowDopBlock;
	//var_dump($bShowPeriodLine);
	?>


<?endif;?>