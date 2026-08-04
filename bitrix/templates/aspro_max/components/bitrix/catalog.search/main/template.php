<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
        <!---sSearch-->
<?
global $favorite;

$q = $_GET['q'];
$items = [];
$res = $DB -> Query('select * from b_iblock_element where ACTIVE = \'Y\' and IBLOCK_ID = 21 and LOWER(NAME) like \'%'.mb_strtolower($q).'%\'');
while ($record = $res -> Fetch())
    $items[$record['ID']] = $record['ID'];

$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'ACTIVE' => 'Y', '%PROPERTY_NAME_UA'=>$q]);
while ($record = $res -> Fetch())
    $items[$record['ID']] = $record['ID'];

$favorite = ['ID' => $items];
$params = [
    'IBLOCK_TYPE' => 'aspro_max_catalog',
    'IBLOCK_ID' => '21',
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
    'FILTER_NAME' => 'favorite',
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
    'PAGE_ELEMENT_COUNT' => '30',
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
    'SECTION_URL' => LANGUAGE_ID == 'ua' ? '/catalog/#SECTION_CODE_PATH#/' : '/ru/catalog/#SECTION_CODE_PATH#/',
    'DETAIL_URL' => LANGUAGE_ID == 'ua' ? '/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/' : '/ru/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
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
    'WRAP_CLASS' => '',
    'BLOCK_CLASS' => '',
];
?>
<div class="search-page sp2">
    <form action="" method="get" style="width: 100%;">
        <input type="text" name="q" value="<?=$_GET['q']?>" size="40">
        &nbsp;<input class="btn btn-search btn-default btn-lg  has-ripple" type="submit" value="<?=LANGUAGE_ID == 'ua' ? 'Пошук' : 'Искать'?>">
        <input type="hidden" name="how" value="r">
    </form><br>
</div>
<?
if(!empty($items))
{
    //$params['ID'] = $_SESSION['FAVORITE'];
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "main",
        $params,
        false
    );

}
else
{
    ?><div class="empty-favorite">
    <?=LANGUAGE_ID == 'ua' ? 'На жаль, нічого не знайдено' : 'К сожалению, ничего не найдено'?>
</div><?
}
?>
<?/*
<?$isAjax="N";?>
<?if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest"  && isset($_GET["ajax_get"]) && $_GET["ajax_get"] == "Y" || (isset($_GET["ajax_basket"]) && $_GET["ajax_basket"]=="Y") || isset($_GET["control_ajax"])){
	$isAjax="Y";
}?>
<?if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && isset($_GET["ajax_get_filter"]) && $_GET["ajax_get_filter"] == "Y"  && !isset($_GET["control_ajax"])){
	$isAjaxFilter="Y";
}?>
<?
global $arTheme, $arRegion, $searchQuery;
$catalogIBlockID = $arParams["IBLOCK_ID"];
$arParams["AJAX_FILTER_CATALOG"] = "N";
?>

<?$APPLICATION->AddViewContent('right_block_class', 'catalog_page search_page');
$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "Y");?>

<?if($arParams["FILTER_NAME"] == '' || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"])){
	$arParams["FILTER_NAME"] = "searchFilter";
}


$bShowFilter = ($arTheme["SEARCH_VIEW_TYPE"]["VALUE"] == "with_filter");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.history.js');

// bitrix:search.page arrFILTER
$arSearchPageFilter = array(
	'arrFILTER' => array('iblock_'.$arParams['IBLOCK_TYPE']),
	'arrFILTER_iblock_'.$arParams['IBLOCK_TYPE'] => array($arParams['IBLOCK_ID']),
);

$arSKU = array();
if($arParams['IBLOCK_ID']){
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
	if($arSKU['IBLOCK_ID']){
		$dbRes = CIBlock::GetByID($arSKU['IBLOCK_ID']);
		if($arSkuIblock = $dbRes ->Fetch()){
			$arSearchPageFilter['arrFILTER'][] = 'iblock_'.$arSkuIblock['IBLOCK_TYPE_ID'];
			$arSearchPageFilter['arrFILTER'] = array_unique($arSearchPageFilter['arrFILTER']);
			if(!$arSearchPageFilter['arrFILTER_iblock_'.$arSkuIblock['IBLOCK_TYPE_ID']]){
				$arSearchPageFilter['arrFILTER_iblock_'.$arSkuIblock['IBLOCK_TYPE_ID']] = array();
			}
			$arSearchPageFilter['arrFILTER_iblock_'.$arSkuIblock['IBLOCK_TYPE_ID']][] = $arSKU['IBLOCK_ID'];
		}
	}
}

// show bitrix.search_page content
$APPLICATION->ShowViewContent('comp_search_page');

?>

<?
// include bitrix.search_page
ob_start();
include 'include_search_page.php';
$searchPageContent = ob_get_clean();

if(!strlen($searchQuery)){
	$searchQuery = $_GET['q'];
}

// find landings in search
$oSearchQuery = new \Aspro\Max\SearchQuery($searchQuery);
$arLandingsFilter = array('ACTIVE' => 'Y');
if($arRegion){
	// filter landings by property LINK_REGION (empty or ID of current region)
	$arLandingsFilter[] = array(
		'LOGIC' => 'OR',
		array('PROPERTY_LINK_REGION' => false),
		array('PROPERTY_LINK_REGION' => $arRegion['ID']),
	);
}

if(isset($_REQUEST['ls'])){
	if(($landingID = intval($_REQUEST['ls'])) > 0){
		$arLandingsFilter['ID'] = $landingID;
		if(!strlen($searchQuery)){
			// query is empty
			$dbRes = \CIBlockElement::GetByID($landingID);
			if($arElement = $dbRes->Fetch()){
				$arElement = \CMaxCache::CIBlockElement_GetList(
					array(
						'CACHE' => array(
							'TAG' => \CMaxCache::GetIBlockCacheTag($arElement['IBLOCK_ID']),
							'MULTI' => 'N'
						)
					),
					array('ID' => $landingID),
					false,
					false,
					array(
						'ID',
						'IBLOCK_ID',
						'PROPERTY_QUERY',
					)
				);

				$arQuery = (array)$arElement['PROPERTY_QUERY_VALUE'];
				if(strlen($query = $arQuery ? trim(htmlspecialchars_decode($arQuery[0])) : '')){
					if(strlen($query = \Aspro\Max\SearchQuery::getSentenceExampleQuery($query))){
						$searchQuery = $_GET['q'] = $_POST['q'] = $_REQUEST['q'] = $query;
						$_GET['spell'] = $_POST['spell'] = $_REQUEST['spell'] = 1;
						$oSearchQuery->setQuery($searchQuery);

						// include bitrix.search_page and replace $arElements by default query example
						ob_start();
						include 'include_search_page.php';
						$searchPageContent = ob_get_clean();
					}
				}
			}
		}
		else{
			$_SESSION['q_'.$landingID] = $searchQuery;
		}
	}
}

// get one landing
$arLanding = $oSearchQuery->getLandings(
	array(),
	$arLandingsFilter,
	false,
	false,
	array(
		'ID',
		'IBLOCK_ID',
		'NAME',
		'PREVIEW_TEXT',
		'DETAIL_TEXT',
		'DETAIL_PICTURE',
		'PROPERTY_IS_INDEX',
		'PROPERTY_FORM_QUESTION',
		'PROPERTY_HIDE_QUERY_INPUT',
		'PROPERTY_TIZERS',
		'PROPERTY_H3_GOODS',
		'PROPERTY_SIMILAR',
		'PROPERTY_REDIRECT_URL',
		'PROPERTY_URL_CONDITION',
		'PROPERTY_QUERY_REPLACEMENT',
		'PROPERTY_CUSTOM_FILTER',
		'PROPERTY_CUSTOM_FILTER_TYPE',
		'PROPERTY_I_ELEMENT_PAGE_TITLE',
		'PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_ALT',
		'PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_TITLE',
		'PROPERTY_I_SKU_PAGE_TITLE',
		'PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_ALT',
		'PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_TITLE',
	),
	true
);
if($arLanding){
	if(!$arLanding['PROPERTY_IS_INDEX_VALUE']){
		$APPLICATION->AddHeadString('<meta name="robots" content="noindex,nofollow" />');
	}

	if(strlen($arLanding['PROPERTY_URL_CONDITION_VALUE'])){
		$urlCondition = ltrim(trim($arLanding['PROPERTY_URL_CONDITION_VALUE']), '/');
		$canonicalUrl = '/'.$urlCondition;

		if(!isset($_REQUEST['ls'])){
			$_SESSION['q_'.$arLanding['ID']] = $searchQuery;
			LocalRedirect($canonicalUrl, true, '301 Moved permanently');
			die();

			// not use APPLICATION->AddHeadString because it`s cached template
			?><link rel="canonical" href="<?=$canonicalUrl?>" /><?
		}
	}

	if(strlen($arLanding['PROPERTY_REDIRECT_URL_VALUE']) && !strlen($urlCondition)){
		if(!isset($_REQUEST['ls'])){
			LocalRedirect($arLanding['PROPERTY_REDIRECT_URL_VALUE'], false, '301 Moved Permanently');
			die();
		}
	}

	if($arLanding['PROPERTY_HIDE_QUERY_INPUT_VALUE']){
		$searchPageContent = '';
	}

	if($arLanding['PROPERTY_CUSTOM_FILTER_VALUE'] && $arLanding['PROPERTY_CUSTOM_FILTER_TYPE_VALUE']){
		// decode CUSTOM_FILTER
		if(\Bitrix\Main\Loader::includeModule('catalog') && class_exists('CMaxCondition')){
			$arCustomFilter = array();
			$cond = new CMaxCondition();
			$arLanding['PROPERTY_CUSTOM_FILTER_VALUE'] = (array)$arLanding['PROPERTY_CUSTOM_FILTER_VALUE'];

			foreach($arLanding['PROPERTY_CUSTOM_FILTER_VALUE'] as $customFilter){
				if(isset($customFilter) && is_string($customFilter)){
					try{
						$customFilter = $cond->parseCondition(\Bitrix\Main\Web\Json::decode($customFilter), $arParams);
					}
					catch(\Exception $e){
						$customFilter = array();
					}
				}

				if($customFilter){
					$arCustomFilter = array_merge($arCustomFilter, $customFilter);
				}
			}
		}

		// get CUSTOM_FILTER_TYPE enums
		$arCustomFilterTypeEnums = CMaxCache::CIBlockPropertyEnum_GetList(
			array('CACHE' => array()),
			array(
				'IBLOCK_ID' => $arLanding['IBLOCK_ID'],
				'CODE' => 'CUSTOM_FILTER_TYPE',
			)
		);
	}

	if(
		$bReplaceElementsByCustomFilter = $arCustomFilter &&
			$arLanding['PROPERTY_CUSTOM_FILTER_TYPE_VALUE'] &&
			$arCustomFilterTypeEnums &&
			$arLanding['PROPERTY_CUSTOM_FILTER_TYPE_VALUE'] === $arCustomFilterTypeEnums[\Aspro\Max\SearchQuery::CUSTOM_FILTER_TYPE_SET_XML_ID]
	){
		// replace $arElements by CUSTOM_FILTER
		$arItemsFilter = array_merge(
			array(
				"IBLOCK_ID" => $catalogIBlockID,
				"ACTIVE" => "Y",
			),
			array($arCustomFilter)
		);

		$arElements = CMaxCache::CIBLockElement_GetList(
			array(
				'CACHE' => array(
					'MULTI' => 'Y',
					'TAG' => CMaxCache::GetIBlockCacheTag($catalogIBlockID),
					'RESULT' => array('ID'),
				)
			),
			$arItemsFilter,
			false,
			false,
			array(
				'ID',
			)
		);
	}

	if(!$bReplaceElementsByCustomFilter && $arLanding['PROPERTY_QUERY_REPLACEMENT_VALUE'] && $arLanding['PROPERTY_QUERY_REPLACEMENT_VALUE'] !== $searchQuery){
		// save oroginal query
		$originalSearchQuery = $searchQuery;

		// replace query
		$searchQuery = $_GET['q'] = $_POST['q'] = $_REQUEST['q'] = $arLanding['PROPERTY_QUERY_REPLACEMENT_VALUE'];
		$_GET['spell'] = $_POST['spell'] = $_REQUEST['spell'] = 1;

		// include bitrix.search_page and replace $arElements by other search results
		ob_start();
		include 'include_search_page.php';
		ob_end_clean();

		// restore original query
		$searchQuery = $_GET['q'] = $_POST['q'] = $_REQUEST['q'] = $originalSearchQuery;
	}

	$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($arLanding['IBLOCK_ID'], $arLanding['ID']);
	$arLanding['IPROPERTY_VALUES'] = $ipropValues->getValues();

	if($arLanding['PROPERTY_SIMILAR_VALUE']){
		$arLanding['PROPERTY_SIMILAR_VALUE'] = (array)$arLanding['PROPERTY_SIMILAR_VALUE'];
		if(in_array($arLanding['ID'], $arLanding['PROPERTY_SIMILAR_VALUE'])){
			unset($arLanding['PROPERTY_SIMILAR_VALUE'][array_search($arLanding['ID'], $arLanding['PROPERTY_SIMILAR_VALUE'])]);
		}
	}

	$arIBInheritTemplates = array(
		"ELEMENT_PAGE_TITLE" => $arLanding["PROPERTY_I_ELEMENT_PAGE_TITLE_VALUE"],
		"ELEMENT_PREVIEW_PICTURE_FILE_ALT" => $arLanding["PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_ALT_VALUE"],
		"ELEMENT_PREVIEW_PICTURE_FILE_TITLE" => $arLanding["PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_TITLE_VALUE"],
		"SKU_PAGE_TITLE" => $arLanding["PROPERTY_I_SKU_PAGE_TITLE_VALUE"],
		"SKU_PREVIEW_PICTURE_FILE_ALT" => $arLanding["PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_ALT_VALUE"],
		"SKU_PREVIEW_PICTURE_FILE_TITLE" => $arLanding["PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_TITLE_VALUE"],
	);
}
?>
<div class="top-content-block <?=$APPLICATION->ShowViewContent('top_class');?>">
	<?=$searchPageContent;?>

	<?if($arLanding && ($arLanding["DETAIL_PICTURE"] || strlen($arLanding["PREVIEW_TEXT"]) || $arLanding["PROPERTY_FORM_QUESTION_VALUE"]) || $arLanding["PROPERTY_TIZERS_VALUE"]):?>
		<?if($arLanding["DETAIL_PICTURE"]):?>
			<div class="seo_block">
				<img data-src="<?=CFile::GetPath($arLanding["DETAIL_PICTURE"]);?>" src="<?=\Aspro\Functions\CAsproMax::showBlankImg(CFile::GetPath($arLanding["DETAIL_PICTURE"]));?>" alt="" title="" class="img-responsive lazy top-big-img"/>
			</div>
		<?endif;?>

		<?if(strlen($arLanding["PREVIEW_TEXT"])):?>
			<div class="seo_block">
				<?=$arLanding["PREVIEW_TEXT"]?>
			</div>
		<?endif;?>

		<div class="seo_block">
			<?$APPLICATION->ShowViewContent('sotbit_seometa_top_desc');?>

			<?if($arLanding["PROPERTY_FORM_QUESTION_VALUE"]):?>
				<table class="order-block bordered">
					<tbody>
						<tr>
							<td class="col-md-9 col-sm-8 col-xs-7 valign">
								<div class="block-item">
									<div class="flexbox flexbox--row">
										<div class="block-item__image icon_sendmessage"><?=CMax::showIconSvg("sendmessage", SITE_TEMPLATE_PATH."/images/svg/sendmessage.svg", "", "colored_theme_svg", true, false);?></div>
										<div class="text darken">
											<?$APPLICATION->IncludeComponent(
												 'bitrix:main.include',
												 '',
												 Array(
													  'AREA_FILE_SHOW' => 'page',
													  'AREA_FILE_SUFFIX' => 'ask',
													  'EDIT_TEMPLATE' => ''
												 )
											);?>
										</div>
									</div>
								</div>
							</td>
							<td class="col-md-3 col-sm-4 col-xs-5 valign btns-col">
								<div class="btns">
									<span><span class="btn btn-default btn-sm animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question"><span><?=(strlen($arParams['S_ASK_QUESTION']) ? $arParams['S_ASK_QUESTION'] : GetMessage('S_ASK_QUESTION'))?></span></span></span>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			<?endif;?>

			<?if($arLanding["PROPERTY_TIZERS_VALUE"]):?>
				<?$GLOBALS["arLandingTizers"] = array("ID" => $arLanding["PROPERTY_TIZERS_VALUE"]);?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"front_tizers",
					array(
						"IBLOCK_TYPE" => "aspro_max_content",
						"IBLOCK_ID" => $arParams['IBLOCK_TIZERS_ID'],
						"NEWS_COUNT" => "4",
						"SORT_BY1" => "SORT",
						"SORT_ORDER1" => "ASC",
						"SORT_BY2" => "ID",
						"SORT_ORDER2" => "DESC",
						// "SMALL_BLOCK" => "Y",
						"FILTER_NAME" => "arLandingTizers",
						"FIELD_CODE" => array(
							0 => "PREVIEW_PICTURE",
							1 => "PREVIEW_TEXT",
							2 => "DETAIL_PICTURE",
							3 => "",
						),
						"PROPERTY_CODE" => array(
							0 => "ICON",
							1 => "URL",
						),
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "N",
						"CACHE_TYPE" => $arParams['CACHE_TYPE'],
						"CACHE_TIME" => "36000000",
						"CACHE_FILTER" => "Y",
						"CACHE_GROUPS" => "N",
						"PREVIEW_TRUNCATE_LEN" => "250",
						"ACTIVE_DATE_FORMAT" => "d F Y",
						"SET_TITLE" => "N",
						"SHOW_DETAIL_LINK" => "N",
						"SET_STATUS_404" => "N",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"ADD_SECTIONS_CHAIN" => "N",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"PAGER_TITLE" => "",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_TEMPLATE" => "ajax",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600",
						"PAGER_SHOW_ALL" => "N",
						"DISPLAY_DATE" => "Y",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "N",
						"DISPLAY_PREVIEW_TEXT" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"COMPONENT_TEMPLATE" => "front_tizers",
						"SET_BROWSER_TITLE" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_LAST_MODIFIED" => "N",
						"INCLUDE_SUBSECTIONS" => "Y",
						"STRICT_SECTION_CHECK" => "N",
						"TYPE_IMG" => "left",
						"CENTERED" => "Y",
						"SIZE_IN_ROW" => "4",
						"PAGER_BASE_LINK_ENABLE" => "N",
						"SHOW_404" => "N",
						"MESSAGE_404" => ""
					),
					false, array("HIDE_ICONS" => "Y")
				);?>
			<?endif;?>
			<?$APPLICATION->ShowViewContent('sotbit_seometa_add_desc');?>
		</div>
	<?endif;?>

	<?if($arLanding &&strlen($arLanding['PROPERTY_H3_GOODS_VALUE'])):?>
		<h4 class="search-title"><?=$arLanding['PROPERTY_H3_GOODS_VALUE']?></h4>
	<?endif;?>

	<?$APPLICATION->ShowViewContent('top_content');?><?$APPLICATION->ShowViewContent('top_content2');?>
	<hr>
</div>
<?
// reinit in sort.php
$bHideLeftBlock = $APPLICATION->GetDirProperty('HIDE_LEFT_BLOCK') == 'Y' || ($arTheme['HEADER_TYPE']['VALUE'] == 28 || $arTheme['HEADER_TYPE']['VALUE'] == 29);?>

<div class="main-catalog-wrapper">
	<div class="section-content-wrapper <?=($arElements && !$bHideLeftBlock ? 'with-leftblock' : '');?> <?=($bShowFilter ? 'with-filter' : '');?> js-load-wrapper">
		<?
		if($arRegion)
		{
			if($arRegion['LIST_PRICES'])
			{
				if(reset($arRegion['LIST_PRICES']) != 'component')
					$arParams['PRICE_CODE'] = array_keys($arRegion['LIST_PRICES']);
			}
			if($arRegion['LIST_STORES'])
			{
				if(reset($arRegion['LIST_STORES']) != 'component')
					$arParams['STORES'] = $arRegion['LIST_STORES'];
			}
		}

		if($arParams['LIST_PRICES'])
		{
			foreach($arParams['LIST_PRICES'] as $key => $price)
			{
				if(!$price)
					unset($arParams['LIST_PRICES'][$key]);
			}
		}

		if($arParams['STORES'])
		{
			foreach($arParams['STORES'] as $key => $store)
			{
				if(!$store)
					unset($arParams['STORES'][$key]);
			}
		}
		if (is_array($arElements) && !empty($arElements))
		{
			if($arSKU)
			{
				foreach($arElements as $key => $value)
				{
					$arTmp = CIBlockElement::GetProperty($arSKU['IBLOCK_ID'], $value, array("sort" => "asc"), Array("ID"=>$arSKU['SKU_PROPERTY_ID']))->Fetch();
					if($arTmp['VALUE'])
						$arElements[$arTmp['VALUE']] = $arTmp['VALUE'];
				}
			}
			$arrFilter = ($GLOBALS[$arParams["FILTER_NAME"]] ? $GLOBALS[$arParams["FILTER_NAME"]] : []);

			$GLOBALS[$arParams["FILTER_NAME"]] = array(
				"=ID" => $arElements,
				'SECTION_GLOBAL_ACTIVE' => 'Y',
			) + $arrFilter;

			if($arLanding && $arCustomFilter){
				if($bReplaceElementsByCustomFilter){
					$GLOBALS[$arParams["FILTER_NAME"]] = array($arCustomFilter) + $arrFilter;
				}
				else{
					$GLOBALS[$arParams["FILTER_NAME"]] = array_merge($GLOBALS[$arParams["FILTER_NAME"]], array($arCustomFilter));
				}
			}

			if($arParams['HIDE_NOT_AVAILABLE'] === 'Y'){
				$GLOBALS[$arParams["FILTER_NAME"]]['CATALOG_AVAILABLE'] = 'Y';
			}

			if($arRegion)
			{
				if($arRegion['LIST_STORES'] && $arParams["HIDE_NOT_AVAILABLE"] == "Y")
				{
					if($arParams['STORES']){
						if(CMax::checkVersionModule('18.6.200', 'iblock')){
							$arStoresFilter = array(
								'STORE_NUMBER' => $arParams['STORES'],
								'>STORE_AMOUNT' => 0,
							);
						}
						else{
							if(count($arParams['STORES']) > 1){
								$arStoresFilter = array('LOGIC' => 'OR');
								foreach($arParams['STORES'] as $storeID)
								{
									$arStoresFilter[] = array(">CATALOG_STORE_AMOUNT_".$storeID => 0);
								}
							}
							else{
								foreach($arParams['STORES'] as $storeID)
								{
									$arStoresFilter = array(">CATALOG_STORE_AMOUNT_".$storeID => 0);
								}
							}
						}

						$arTmpFilter = array('!TYPE' => array('2', '3'));
						if($arStoresFilter){
							if(!CMax::checkVersionModule('18.6.200', 'iblock') && count($arStoresFilter) > 1){
								$arTmpFilter[] = $arStoresFilter;
							}
							else{
								$arTmpFilter = array_merge($arTmpFilter, $arStoresFilter);
							}

							$GLOBALS[$arParams["FILTER_NAME"]][] = array(
								'LOGIC' => 'OR',
								array('TYPE' => array('2', '3')),
								$arTmpFilter,
							);
						}
					}
				}
			}

			$arItems = CMaxCache::CIBLockElement_GetList(
				array(
					'CACHE' => array(
						'MULTI' => 'Y',
						'TAG' => CMaxCache::GetIBlockCacheTag($catalogIBlockID),
					)
				),
				CMax::makeElementFilterInRegion($GLOBALS[$arParams["FILTER_NAME"]]),
				false,
				false,
				array(
					'ID',
					'IBLOCK_ID',
					'IBLOCK_SECTION_ID',
				)
			);

			$arAllSections = $arSectionsID = $arItemsID = array();

			if($arItems){

				// sections
				ob_start();
				include_once 'sections.php';
				$htmlSections = ob_get_clean();

				if (!$bHideLeftBlock) {
					$APPLICATION->AddViewContent('filter_section', $htmlSections);
					$htmlSections2 = $htmlSections;
					$htmlSections = '';
				} else {
					$APPLICATION->AddViewContent('filter_content', $htmlSections);
				}

				// sort
				ob_start();
				include_once 'sort.php';
				$htmlSort = ob_get_clean();
				$listElementsTemplate = $template;

				// filter
				ob_start();
				include_once 'filter.php';
				$htmlFilter = ob_get_clean();
				if ($arTheme["FILTER_VIEW"]["VALUE"] == 'VERTICAL') {
					$APPLICATION->AddViewContent('filter_content', $htmlFilter);
				}
			}
			?>
			<?if($isAjax === "Y"):?>
				<?$APPLICATION->RestartBuffer();?>
			<?endif;?>

			<?$APPLICATION->ShowViewContent('search_content');?>
			<div class="catalog vertical filter_exists">


				<?=$htmlSections2;?>

				<?// sort?>
				<?=$htmlSort?>

				<?unset($_GET['q']);?>

				<?if($arTheme["FILTER_VIEW"]["VALUE"] == 'VERTICAL'):?>
					<div id="filter-helper-wrapper">
						<div id="filter-helper" class="top"></div>
					</div>
				<?else:?>
					<div class="filter-compact-block swipeignore">
						<?=$htmlFilter?>
					</div>
				<?endif;?>
				<div class="inner_wrapper">
					<div class="ajax_load cur <?=$display?>" data-code="<?=$display?>">
						<?$arTransferParams = array(
							"SHOW_ABSENT" => $arParams["SHOW_ABSENT"],
							"HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
							"PRICE_CODE" => $arParams["PRICE_CODE"],
							"OFFER_TREE_PROPS" => $arParams["OFFER_TREE_PROPS"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
							"CURRENCY_ID" => $arParams["CURRENCY_ID"],
							"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
							"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
							"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
							"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
							"LIST_OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
							"LIST_OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
							"SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
							"SHOW_COUNTER_LIST" => $arParams["SHOW_COUNTER_LIST"],
							"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
							"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
							"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
							"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
							"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
							"USE_REGION" => ($arRegion ? "Y" : "N"),
							"STORES" => $arParams["STORES"],
							"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
							"BASKET_URL" => $arParams["BASKET_URL"],
							"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
							"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
							"PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
							"ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
							"SHOW_DISCOUNT_TIME_EACH_SKU" => $arParams["SHOW_DISCOUNT_TIME_EACH_SKU"],
							"SHOW_ARTICLE_SKU" => $arParams["SHOW_ARTICLE_SKU"],
							"OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
							"SHOW_GALLERY" => $arParams["SHOW_GALLERY"],
							"MAX_GALLERY_ITEMS" => $arParams["MAX_GALLERY_ITEMS"],
							"DISPLAY_COMPARE" => CMax::GetFrontParametrValue('CATALOG_COMPARE'),
							"SHOW_POPUP_PRICE" => CMax::GetFrontParametrValue('SHOW_POPUP_PRICE'),
							"ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
							"ADD_DETAIL_TO_SLIDER" => $arParams["DETAIL_ADD_DETAIL_TO_SLIDER"],
							"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
							"SHOW_ONE_CLICK_BUY" => $arParams["SHOW_ONE_CLICK_BUY"],
							"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
							'CURRENT_BASE_PAGE' => $arLanding && strlen($arLanding['PROPERTY_URL_CONDITION_VALUE']) ? $canonicalUrl : null,
							"IBINHERIT_TEMPLATES" => $arLanding ? $arIBInheritTemplates : array(),
						);?>
						<?$show = $arParams["PAGE_ELEMENT_COUNT"];?>
						<div class="catalog <?=$display;?> search js_wrapper_items" data-params='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arTransferParams, false))?>'>

							<?$APPLICATION->IncludeComponent(
								"bitrix:catalog.section",
								$listElementsTemplate,
								array(
									"USE_REGION" => ($arRegion ? "Y" : "N"),
									"STORES" => $arParams['STORES'],
									"TYPE_SKU" => $arTheme["TYPE_SKU"]["VALUE"],
									"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
									"IBLOCK_ID" => $arParams["IBLOCK_ID"],
									"SHOW_BIG_BLOCK" => 'N',
									"IS_CATALOG_PAGE" => 'Y',
									"ELEMENT_SORT_FIELD" => $sort,
									"ELEMENT_SORT_ORDER" => $sort_order,
									"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
									"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
									"PAGE_ELEMENT_COUNT" => $show,
									"LINE_ELEMENT_COUNT" => $linerow,
									"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
									"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
									"SHOW_ARTICLE_SKU" => $arParams["SHOW_ARTICLE_SKU"],
									"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],
									"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
									"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
									"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
									"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
									"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
									"OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
									"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
									"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
									'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
									"SHOW_COUNTER_LIST" => $arParams["SHOW_COUNTER_LIST"],
									"MAX_GALLERY_ITEMS" => $arParams["MAX_GALLERY_ITEMS"],
									"SHOW_GALLERY" => $arParams["SHOW_GALLERY"],
									"SHOW_PROPS" => (CMax::GetFrontParametrValue("SHOW_PROPS_BLOCK") == "Y" ? "Y" : "N"),
									'SHOW_POPUP_PRICE' => (CMax::GetFrontParametrValue('SHOW_POPUP_PRICE') == 'Y' ? "Y" : "N"),
									'TYPE_VIEW_BASKET_BTN' => CMax::GetFrontParametrValue('TYPE_VIEW_BASKET_BTN'),
									'TYPE_VIEW_CATALOG_LIST' => CMax::GetFrontParametrValue('TYPE_VIEW_CATALOG_LIST'),
									"MANY_BUY_CATALOG_SECTIONS" => CMax::GetFrontParametrValue('MANY_BUY_CATALOG_SECTIONS'),
									"DISPLAY_TYPE" => $display,
									"SECTION_URL" => $arParams["SECTION_URL"],
									"DETAIL_URL" => $arParams["DETAIL_URL"],
									"BASKET_URL" => $arParams["BASKET_URL"],
									"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
									"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
									"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
									"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
									"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
									"CACHE_TYPE" => $arParams["CACHE_TYPE"],
									"CACHE_TIME" => $arParams["CACHE_TIME"],
									"PRICE_CODE" => $arParams["PRICE_CODE"],
									"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
									"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
									"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
									"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
									"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
									"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
									"CURRENCY_ID" => $arParams["CURRENCY_ID"],
									"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
									"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
									"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
									"PAGER_TITLE" => $arParams["PAGER_TITLE"],
									"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
									"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
									"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
									"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
									"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
									"FILTER_NAME" => $arParams["FILTER_NAME"],
									"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
									"SECTION_ID" => ($setionIDRequest ? $setionIDRequest : ""),
									"SECTION_CODE" => "",
									"SECTION_USER_FIELDS" => array(),
									"INCLUDE_SUBSECTIONS" => "Y",
									"SHOW_ALL_WO_SECTION" => "Y",
									"META_KEYWORDS" => "",
									"META_DESCRIPTION" => "",
									"BROWSER_TITLE" => "",
									"ADD_SECTIONS_CHAIN" => "N",
									"SET_TITLE" => "N",
									"SET_STATUS_404" => "N",
									"CACHE_FILTER" => "Y",
									"AJAX_REQUEST" => (($isAjax == "Y" && $isAjaxFilter != "Y") ? "Y" : "N"),
									"AJAX_REQUEST" => "N",
									"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
									"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
									"CURRENCY_ID" => $arParams["CURRENCY_ID"],
									"DISPLAY_SHOW_NUMBER" => "N",
									"DISPLAY_COMPARE" => CMax::GetFrontParametrValue('CATALOG_COMPARE'),
									"SHOW_ONE_CLICK_BUY" => $arParams["SHOW_ONE_CLICK_BUY"],
									"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
									"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
									"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
									"SALE_STIKER" => $arParams["SALE_STIKER"],
									"STIKERS_PROP" => $arParams["STIKERS_PROP"],
									"SHOW_RATING" => $arParams["SHOW_RATING"],
									"SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
									"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
									"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
									"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
									"OFFER_HIDE_NAME_PROPS" => $arParams["OFFER_HIDE_NAME_PROPS"],
									"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
									"ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
									"OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
									"HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
									"ADD_DETAIL_TO_SLIDER" => $arParams["DETAIL_ADD_DETAIL_TO_SLIDER"],
									"MAX_SCU_COUNT_VIEW" => $arParams['MAX_SCU_COUNT_VIEW'],
									'CURRENT_BASE_PAGE' => $arLanding && strlen($arLanding['PROPERTY_URL_CONDITION_VALUE']) ? $canonicalUrl : null,
									"SET_SKU_TITLE" => (($arTheme["TYPE_SKU"]["VALUE"] == "TYPE_1" && $arTheme["CHANGE_TITLE_ITEM"]["VALUE"] == "Y") ? "Y" : ""),
									"IBINHERIT_TEMPLATES" => $arLanding ? $arIBInheritTemplates : array(),
									'OFFER_SHOW_PREVIEW_PICTURE_PROPS' => $arParams['OFFER_SHOW_PREVIEW_PICTURE_PROPS'],
									"REVIEWS_VIEW" => $arTheme["REVIEWS_VIEW"]["VALUE"] == "EXTENDED",
								),
								$arResult["THEME_COMPONENT"]
							);?>

						</div>
					</div>
				</div>
			</div>
			<?if($isAjax === "Y"):?>
				<?die();?>
			<?endif;?>
		<?}else{
			if(!strlen($searchQuery))
				echo '<div class="alert alert-info">'.GetMessage("CT_BCSE_EMPTY_QUERY")."</div>";
			else
				echo '<div class="alert alert-danger">'.GetMessage("CT_BCSE_NOT_FOUND")."</div>";

			if($arParams["USE_BIG_DATA_IN_SEARCH"] == "Y"){
				$APPLICATION->IncludeComponent("bitrix:catalog.bigdata.products", "main", array(
					"USE_REGION" => $arParams["USE_REGION"],
					"STORES" => $arParams['STORES'],
					"LINE_ELEMENT_COUNT" => 5,
					"TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
					"DETAIL_URL" => (array_key_exists('FOLDER', $arResult)  ? $arResult['FOLDER'] : '').(array_key_exists('URL_TEMPLATES', $arResult) && array_key_exists('element', $arResult['URL_TEMPLATES'])  ? $arResult['URL_TEMPLATES']['element'] : ''),
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action")."_cbdp",
					"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],
					"ADD_PROPERTIES_TO_BASKET" => "N",
					"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
					"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
					"SLIDER" => "Y",
					"ROW" => "Y",
					"PRICE_CODE" => $arParams['PRICE_CODE'],
					"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
					"PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
					"TITLE_SLIDER" => $arParams['TITLE_SLIDER_IN_SEARCH'],
					"FILTER_NAME" => "arrFilterBigDataSearch",
					"SHOW_NAME" => "Y",
					"SHOW_IMAGE" => "Y",
					"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
					"SHOW_RATING" => $arParams["SHOW_RATING"],
					"MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
					"MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
					"MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
					"MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
					"PAGE_ELEMENT_COUNT" => ($arParams['RECOMEND_IN_SEARCH_COUNT'] ? $arParams['RECOMEND_IN_SEARCH_COUNT'] : 10),
					"SHOW_FROM_SECTION" => $arBigData['BIGDATA_SHOW_FROM_SECTION'],
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SALE_STIKER" => $arParams["SALE_STIKER"],
					"STIKERS_PROP" => $arParams["STIKERS_PROP"],
					"DEPTH" => "2",
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
					"ADDITIONAL_PICT_PROP_".$arParams["IBLOCK_ID"] => $arParams['ADD_PICT_PROP'],
					"LABEL_PROP_".$arParams["IBLOCK_ID"] => "-",
					"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
					'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
					"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
					"CURRENCY_ID" => $arParams["CURRENCY_ID"],
					"SECTION_ID" => $arBigData["SECTION_ID"],
					"SECTION_ELEMENT_ID" => $arBigData["SECTION_ID"],
					"ID" => '',
					"PROPERTY_CODE_".$arParams["IBLOCK_ID"] => $arParams["LIST_PROPERTY_CODE"],
					"CART_PROPERTIES_".$arParams["IBLOCK_ID"] => $arParams["PRODUCT_PROPERTIES"],
					"RCM_TYPE" => (isset($arParams['BIG_DATA_IN_SEARCH_RCM_TYPE']) ? $arParams['BIG_DATA_IN_SEARCH_RCM_TYPE'] : ''),
					"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
					"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
					"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
					"ONLY_POPUP_PRICE" => "Y",
					),
					false,
					array("HIDE_ICONS" => "Y", "ACTIVE_COMPONENT" => "Y")
				);
			}

			$APPLICATION->AddViewContent('top_class', 'emptys');?>
			
			<script src="<?=SITE_TEMPLATE_PATH;?>/vendor/js/carousel/owl/owl.carousel.js" data-skip-moving="true" async=""></script>
			<?
			$APPLICATION->AddHeadString('<link href="'.$APPLICATION->oAsset->getFullAssetPath(SITE_TEMPLATE_PATH.'/vendor/css/carousel/owl/owl.carousel.css').'" data-template-style="true" rel="stylesheet">');
		}
		?>
		<?if($arLanding):?>
			<div class="group_description_block bottom muted777">
				<?if(strlen($arLanding["DETAIL_TEXT"])):?>
					<?=$arLanding["DETAIL_TEXT"];?>
				<?endif;?>

				<?$APPLICATION->ShowViewContent('sotbit_seometa_bottom_desc');?>

				<?if($arParams['SHOW_LANDINGS'] !== 'N' && $arLanding['PROPERTY_SIMILAR_VALUE']):?>
					<?$arLandingsFilter['ID'] = $arLanding['PROPERTY_SIMILAR_VALUE'];?>
					<?$GLOBALS["arLandingsFilter"] = $arLandingsFilter;?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:news.list",
						"landings_search_list",
						array(
							"IBLOCK_TYPE" => "aspro_max_catalog",
							"IBLOCK_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_catalog"]["aspro_max_search"][0],
							"NEWS_COUNT" => "999",
							"SHOW_COUNT" => 1,
							"SHOW_COUNT_MOBILE" => 1,
							"VIEW_TYPE" => $arTheme['CATALOG_PAGE_LANDINGS_VIEW']['VALUE'],
							"SORT_BY1" => "SORT",
							"SORT_ORDER1" => "ASC",
							"SORT_BY2" => "ID",
							"SORT_ORDER2" => "DESC",
							"BG_FILLED" => ($arParams["LANDING_TYPE"] == "landing_2" ? "Y" : "N"),
							"FILTER_NAME" => "arLandingsFilter",
							"FIELD_CODE" => array(
								0 => "",
								1 => "",
							),
							"PROPERTY_CODE" => array(
								0 => "URL_CONDITION",
								1 => "REDIRECT_URL",
								2 => "QUERY",
								3 => "",
							),
							"CHECK_DATES" => "Y",
							"DETAIL_URL" => "",
							"AJAX_MODE" => "N",
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "Y",
							"AJAX_OPTION_HISTORY" => "N",
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_FILTER" => "Y",
							"CACHE_GROUPS" => "N",
							"PREVIEW_TRUNCATE_LEN" => "",
							"ACTIVE_DATE_FORMAT" => "j F Y",
							"SET_TITLE" => "N",
							"SET_STATUS_404" => "N",
							"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
							"ADD_SECTIONS_CHAIN" => "N",
							"HIDE_LINK_WHEN_NO_DETAIL" => "N",
							"PARENT_SECTION" => "",
							"PARENT_SECTION_CODE" => "",
							"INCLUDE_SUBSECTIONS" => "Y",
							"PAGER_TEMPLATE" => "",
							"DISPLAY_TOP_PAGER" => "N",
							"DISPLAY_BOTTOM_PAGER" => "N",
							"PAGER_TITLE" => "",
							"PAGER_SHOW_ALWAYS" => "N",
							"PAGER_DESC_NUMBERING" => "N",
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
							"PAGER_SHOW_ALL" => "N",
							"AJAX_OPTION_ADDITIONAL" => "",
							"COMPONENT_TEMPLATE" => "next",
							"SET_BROWSER_TITLE" => "N",
							"SET_META_KEYWORDS" => "N",
							"SET_META_DESCRIPTION" => "N",
							"SET_LAST_MODIFIED" => "N",
							"PAGER_BASE_LINK_ENABLE" => "N",
							"TITLE_BLOCK" => $arParams["LANDING_TITLE"],
							"SHOW_404" => "N",
							"MESSAGE_404" => ""
						),
						false, array("HIDE_ICONS" => "Y")
					);?>
				<?endif;?>
				<?
				$langing_seo_h1 = strip_tags(htmlspecialchars_decode($arLanding["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != "" ? $arLanding["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arLanding["NAME"]));

				$APPLICATION->SetTitle($langing_seo_h1);

				if($arLanding["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"])
					$APPLICATION->SetPageProperty("title", strip_tags(htmlspecialchars_decode($arLanding["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"])));
				else
					$APPLICATION->SetPageProperty("title", strip_tags(htmlspecialchars_decode($arLanding["NAME"].$postfix)));

				if($arLanding["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"])
					$APPLICATION->SetPageProperty("description", strip_tags(htmlspecialchars_decode($arLanding["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"])));

				if($arLanding["IPROPERTY_VALUES"]['ELEMENT_META_KEYWORDS'])
					$APPLICATION->SetPageProperty("keywords", $arLanding["IPROPERTY_VALUES"]['ELEMENT_META_KEYWORDS']);
				?>
			</div>
		<?endif;?>

	</div>
	<?if($arElements && !$bHideLeftBlock):?>
		<?if($bShowFilter):?>
			<div class="left_block filter_visible">
				<div class="sticky-sidebar__inner">
					<?$APPLICATION->ShowViewContent('filter_section');?>

					<?$APPLICATION->ShowViewContent('filter_content');?>

					<?$APPLICATION->ShowViewContent('under_sidebar_content');?>

					<?CMax::get_banners_position('SIDE', 'Y');?>

					<?if(\Bitrix\Main\ModuleManager::isModuleInstalled("subscribe") && $arTheme['HIDE_SUBSCRIBE']['VALUE'] != 'Y'):?>
						<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
							array(
								"COMPONENT_TEMPLATE" => ".default",
								"PATH" => SITE_DIR."include/left_block/comp_subscribe.php",
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "",
								"AREA_FILE_RECURSIVE" => "Y",
								"EDIT_TEMPLATE" => "include_area.php"
							),
							false
						);?>
					<?endif;?>
				</div>
			</div>
		<?else:?>
			<?CMax::ShowPageType('left_block');?>
		<?endif;?>
	<?elseif($bShowFilter && $bHideLeftBlock && $arElements):?>
		<div class="hidden"><?$APPLICATION->ShowViewContent('filter_content');?></div>
	<?endif;?>
</div>