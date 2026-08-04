<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Page\Frame;
/**
 * @global CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $arCurSection
 */
$bIndex = (strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false) || isset($_GET['google']);
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
global $seo,$selectedFilter;

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


if(LANGUAGE_ID == 'ru')
{
    if(!$seo['ELEMENT_PAGE_TITLE'] && $section)
        $sectionTitle = $section;
    else $sectionTitle = $seo['ELEMENT_PAGE_TITLE'];
}



/*?>
<div class="page-title">
    <h1 class="page-title-text" style="<?=strpos($APPLICATION -> GetCurPage(), '/rasprodazha/') !== false ? 'color:#8B0000;' : ''?>">
        <?$APPLICATION->ShowViewContent('mdf_title');?>
        <?//=$seo['ELEMENT_PAGE_TITLE'] ? $seo['ELEMENT_PAGE_TITLE'] : $section?>
        <?=$seo['ELEMENT_PAGE_TITLE'] ? '' : $sectionTitle?>
        <?//=$APPLICATION->ShowTitle()?>
        <?
        //$APPLICATION->SetTitle($seo['ELEMENT_PAGE_TITLE'] ? $seo['ELEMENT_PAGE_TITLE'] : $section);
        //$APPLICATION->SetTitle('Бомбери');
        ?>
    </h1>
</div>
<?*/
if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
	$basketAction = isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '';
else
	$basketAction = isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '';

$ru=LANGUAGE_ID=='ru'?'/ru':'';
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
/*$APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list",
    "",
    $sectionListParams,
    $component,
    array("HIDE_ICONS" => "Y")
);*/
unset($sectionListParams);

$res = CIBlockSection::GetList(['DEPTH_LEVEL' => 'asc','sort'=>'asc'], ['IBLOCK_ID' => 43,'ACTIVE'=>'Y'],false,['UF_*']);
$sections = [];
while ($sectionFetch = $res->Fetch())
{
    if(!$sectionFetch['IBLOCK_SECTION_ID'])
        $sections[$sectionFetch['ID']] = $sectionFetch;
    else
        $sections[$sectionFetch['IBLOCK_SECTION_ID']]['child'][] = $sectionFetch;
}
?>
<div class="catalog-menu-cont">
    <div class="wrapper">
        <div class="catalog-menu-block">
            <div class="catalog-menu">
                <a href="<?=$ru?>/catalog/zhenskaya_odezhda/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/zhenskaya_odezhda/') !== false ? 'active' : ''?>">
                    <?=LANGUAGE_ID=='ua'?'Всі товари':'Все товары'?>
                </a>
                <?
                foreach ($sections as $index => $itemSection)
                {
                    if(!$itemSection['UF_SHOW_CATALOG_MENU']) continue;
                    ?>
                    <a href="<?=$ru.$itemSection['UF_LINK']?>" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),$itemSection['UF_LINK']) !== false ? 'active' : ''?>">
                        <?=LANGUAGE_ID=='ua'?$itemSection['UF_NAME_UA']:$itemSection['NAME']?>
                    </a>
                    <?
                }
                ?>

                <?/*<a href="<?=$ru?>/catalog/novinki/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/novinki/') !== false ? 'active' : ''?>">
                    NEW
                </a>
                <a href="<?=$ru?>/catalog/street_casual/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/street_casual/') !== false ? 'active' : ''?>">
                    STREET CASUAL
                </a>
                <a href="<?=$ru?>/catalog/smart_casual/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/smart_casual/') !== false ? 'active' : ''?>">
                    SMART CASUAL
                </a>
                <a href="<?=$ru?>/catalog/winter_drop/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/winter_drop/') !== false ? 'active' : ''?>">
                    WINTER DROP
                </a>
                <a href="<?=$ru?>/catalog/events/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/events/') !== false ? 'active' : ''?>">
                    EVENTS
                </a>
                <a href="<?=$ru?>/catalog/limited/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/limited/') !== false ? 'active' : ''?>">
                    LIMITED
                </a>
                <a href="<?=$ru?>/catalog/khity_prodazh/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/khity_prodazh/') !== false ? 'active' : ''?>">
                    BESTSELLERS
                </a>
                <a href="<?=$ru?>/catalog/rasprodazha/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/rasprodazha/') !== false ? 'active' : ''?>">
                    SALE
                </a>
                <a href="<?=$ru?>/catalog/aksessuary/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/aksessuary/') !== false ? 'active' : ''?>">
                    <?=LANGUAGE_ID=='ua'?'Аксесуари':'Аксесуары'?>
                </a>
                <a href="<?=$ru?>/catalog/bonusna_shafa/" class="catalog-menu-item <?=strpos($APPLICATION->GetCurPage(),'/catalog/bonusna_shafa/') !== false ? 'active' : ''?>">
                    Товари за стімзи
                </a>*/?>

            </div>
        </div>
    </div>
</div>
<?
if(!$arParams["IS_NEW"] && !$arParams["IS_OUTDOOR"] && !$arParams["IS_EVENTS"] && !$arParams["IS_LIMITED"] && !$arParams["IS_CRUISE"] && !$arParams["IS_SMART_OFFICE"] && !$arParams["IS_COMFORT"] && !$arParams["IS_CASUAL"])
    $APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            "",
            array(
                    'SEO' => $seo,
                    'SECTION' => $section,
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

<div class="wrapper">
    <div class="catalog-page">
        <div class="catalog-control-block">
            <div class="catalog-filter-info">
                <button class="catalog-filter" type="button" data-bs-toggle="offcanvas" data-bs-target="#filter-canvas">
        					<span class="icon">
        						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    								<path fill-rule="evenodd" clip-rule="evenodd" d="M13.125 3.75781C11.6205 3.75781 10.3553 4.83619 10.0635 6.25781H1.875C1.52983 6.25781 1.25 6.53764 1.25 6.88281C1.25 7.22799 1.52983 7.50781 1.875 7.50781H10.0635C10.3553 8.92943 11.6205 10.0078 13.125 10.0078C14.6295 10.0078 15.8947 8.92943 16.1865 7.50781H18.125C18.4702 7.50781 18.75 7.22799 18.75 6.88281C18.75 6.53764 18.4702 6.25781 18.125 6.25781H16.1865C15.8947 4.83619 14.6295 3.75781 13.125 3.75781ZM13.125 5.00781C14.1679 5.00781 15 5.83989 15 6.88281C15 7.92573 14.1679 8.75781 13.125 8.75781C12.0821 8.75781 11.25 7.92573 11.25 6.88281C11.25 5.83989 12.0821 5.00781 13.125 5.00781Z" fill="currentcolor"/>
    								<path fill-rule="evenodd" clip-rule="evenodd" d="M6.875 10.0078C5.37051 10.0078 4.10528 11.0862 3.81348 12.5078H1.875C1.52983 12.5078 1.25 12.7876 1.25 13.1328C1.25 13.478 1.52983 13.7578 1.875 13.7578H3.81348C4.10528 15.1794 5.37051 16.2578 6.875 16.2578C8.37949 16.2578 9.64472 15.1794 9.93652 13.7578H18.125C18.4702 13.7578 18.75 13.478 18.75 13.1328C18.75 12.7876 18.4702 12.5078 18.125 12.5078H9.93652C9.64472 11.0862 8.37949 10.0078 6.875 10.0078ZM6.875 11.2578C7.91792 11.2578 8.75 12.0899 8.75 13.1328C8.75 14.1757 7.91792 15.0078 6.875 15.0078C5.83208 15.0078 5 14.1757 5 13.1328C5 12.0899 5.83208 11.2578 6.875 11.2578Z" fill="currentcolor"/>
    							</svg>
        					</span>
                    <?
                    $APPLICATION->ShowViewContent('filter_counter');
                    ?>
                    <?/*<span class="count_products">Фільтр (2)</span>*/?>
                </button>
                <?
                $APPLICATION->ShowViewContent('filter_counter_products');
                ?>
                <?/*
                <div class="catalog-filter-viewed">
                    30 товарів
                </div>
                */?>
            </div>
            <h1 class="catalog-page-title">
                <?$APPLICATION->ShowViewContent('mdf_title');?>
                <?=$sectionTitle?>
            </h1>
            <?
            if(!$arParams["IS_NEW"])
            {
                ?>
                <div class="catalog-grid-btn-block">
                    <div class="catalog-grid-btn active ">
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 0.5V20.5M0.5 0.5H20.5V20.5H0.5V0.5Z" stroke="currentcolor"/>
                        </svg>
                    </div>
                    <div class="catalog-grid-btn rectangle">
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 0.5V20.5M0.634399 10H20.4996M0.5 0.5H20.5V20.5H0.5V0.5Z" stroke="currentcolor"/>
                        </svg>
                    </div>
                </div>
                <?
            }
            ?>

        </div>

<?
/*
if(isset($_GET['google']) && !$arParams["IS_NEW"] && !$arParams["IS_OUTDOOR"] && !$arParams["IS_EVENTS"] && !$arParams["IS_LIMITED"] && !$arParams["IS_CRUISE"] && !$arParams["IS_SMART_OFFICE"] && !$arParams["IS_COMFORT"] && !$arParams["IS_CASUAL"])
{
    ?>
    <div class="catalog-filters-mobile">
        <div class="h1 page-title-text" style=""> Верхній одяг </div>
        <div class="catalog-filters-mobile-opener">
            <svg width="30" height="29" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg"> <line y1="4.5" x2="30" y2="4.5" stroke="#3D441D"></line> <line y1="24.5" x2="30" y2="24.5" stroke="#3D441D"></line> <circle cx="22" cy="4" r="3.5" fill="white" stroke="#3D441D"></circle> <line y1="14.5" x2="30" y2="14.5" stroke="#3D441D"></line> <circle cx="22" cy="24.6678" r="3.5" fill="white" stroke="#3D441D"></circle> <circle cx="8" cy="14.2273" r="3.5" fill="white" stroke="#3D441D"></circle> </svg>
        </div>
    </div>
    <div class="catalog-filters">
        <div class="catalog-filters-top">
            <h1 class="page-title-text" style=""> Верхній одяг </h1>
            <div class="catalog-filter-cont catalog-filter-cont-opener"> <div class="catalog-filter-block"> <div class="catalog-filter-name"> <span>фільтр</span> <span class="icon"> <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"></path> </svg> </span> </div> </div> </div>
            <div class="catalog-filter-cont">
                <div class="catalog-filter-block">
                    <div class="catalog-filter-name"> <span>сортувати</span> <span class="icon"> <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"></path> </svg> </span> </div>
                </div>
            </div>
        </div>
    </div>

    <?
}
elseif(!$arParams["IS_NEW"] && !$arParams["IS_OUTDOOR"] && !$arParams["IS_EVENTS"] && !$arParams["IS_LIMITED"] && !$arParams["IS_CRUISE"] && !$arParams["IS_SMART_OFFICE"] && !$arParams["IS_COMFORT"] && !$arParams["IS_CASUAL"])
$APPLICATION->IncludeComponent(
    "bitrix:catalog.smart.filter",
    "",
    array(
        'SEO' => $seo,
        'SECTION' => $section,
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
*/
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

$arParams["ELEMENT_SORT_FIELD"] = isset($_GET['by']) ? $_GET['by'] : "sort";
$arParams["ELEMENT_SORT_ORDER"] = isset($_GET['sort']) ? $_GET['sort'] : "desc";

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

if(($APPLICATION -> GetCurPage() == '/catalog/rasprodazha/'
    ||$APPLICATION -> GetCurPage() == '/ru/catalog/rasprodazha/'
    ||$APPLICATION -> GetCurPage() == '/catalog/khity_prodazh/'
    ||$APPLICATION -> GetCurPage() == '/ru/catalog/khity_prodazh/'
    ||(isset($_GET['by']) && $_GET['by'] == 'PROPERTY_MINIMUM_PRICE')
))
{
    $MAX_SMART_FILTER['>SORT'] = 0;
}
/*
if($bIndex)
{
    global $DB;
    $subsections = [];

    $sectionId = $arResult['VARIABLES']['SECTION_ID']; // Ваш ID раздела

    function getSubsections($parentId) {
        global $DB;
        $subsections = [];

        $sql = "SELECT ID, NAME, IBLOCK_ID, IBLOCK_SECTION_ID 
            FROM b_iblock_section 
            WHERE IBLOCK_SECTION_ID = " . intval($parentId);

        $res = $DB->Query($sql);

        while ($row = $res->Fetch()) {
            $subsections[] = $row['ID'];
            $subsections = array_merge($subsections, getSubsections($row['ID']));
        }

        return $subsections;
    }

    $allSubsections = getSubsections($sectionId);
    $allSubsections[] = $sectionId;
    $allSubsections = array_unique($allSubsections);


    $res = $DB->Query('select * from b_iblock_element where IBLOCK_ID = 21 and ACTIVE = \'Y\' and IBLOCK_SECTION_ID in ('.implode(',',$allSubsections) . ') limit 8');

    ?>
    <div class="insertpag loadmore_container catalog-items-block">
        <?
        while ($record = $res ->Fetch())
        {
            $price = $DB->Query('select * from b_catalog_price  where PRODUCT_ID = ' . $record['ID'])->Fetch()['PRICE'];
            $fileId = $record['PREVIEW_PICTURE'] ? $record['PREVIEW_PICTURE'] : $record['DETAIL_PICTURE'];
            $img = CFile::ResizeImageGet($fileId, array( "width" => 250, "height" => 375 ), BX_RESIZE_IMAGE_EXACT, true )['src'];
            ?>
            <div class="catalog-item-cont w-25" style="min-height: 100%">
                <div class="catalog-item-block">
                    <div class="catalog-item-img">
                        <div class="catalog-item-img-slider ">
                            <div class="catalog-item-img-slider-el">
                                <a href="" aria-label="">
                                    <img src="<?=convertToWebP($img)?>" class="img4" width="250">
                                </a>
                            </div>
                        </div>
                        <div class="catalog-item-size-list cisl1">
                            <div class="catalog-item-size " data-entity="scu-value" data-id="S"><a href="" aria-label="Жіночий тренч Stimma Дейвер"> S </a></div>
                            <div class="catalog-item-size " data-entity="scu-value" data-id="M"><a href="" aria-label="Жіночий тренч Stimma Дейвер"> M </a></div>
                        </div>
                        <div class="card-badge-block"></div>
                    </div>
                    <div class="catalog-item-name-block">
                        <a href="" aria-label="Жіночий тренч Stimma Дейвер" class="catalog-item-name" data-entity="name">
                            <?=$record['NAME']?>
                        </a>
                        <div class="catalog-item-favorite">
                            <a href="" data-id="28814" aria-label="Додати в обране">
                                <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#000" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="catalog-item-info">
                        <div class="catalog-item-price">
                            <div class="catalog-item-price-currency" data-entity="price"><?=FormatCurrency($price,'UAH')?> грн</div>
                        </div>
                        <div class="catalog-item-colors" data-code="COLOR_REF">
                            <a onclick="" style="background-color: #FFFFFF;" aria-label="Білий колір" href="#" class="catalog-item-color white active" data-entity="scu-value" data-id="belyy"></a>
                            <a onclick="changeData('zhenskiy-trench-stimma-deyver-1710', this);return false;" style="background-color: #a3a9ab;" aria-label="сірий колір" href="#" class="catalog-item-color " data-entity="scu-value" data-id="seryy"> </a>
                            <a onclick="changeData('zhenskiy-trench-stimma-deyver-1709', this);return false;" style="background-color: #d1c3ab;" aria-label="бежевий колір" href="#"></a>
                        </div>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
    </div>
    <?
}
else
    */
$intSectionID = $APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "main",
    array(
        "GOOGLE" => $bIndex,
        "SEND_STATISTIC" => 'Y',
        "FILES" => $arParams["FILES"],
        "IS_NEW" => $arParams["IS_NEW"],
        "IS_OUTDOOR" => $arParams["IS_OUTDOOR"],
        "IS_CRUISE" => $arParams["IS_CRUISE"],
        "IS_LIMITED" => $arParams["IS_LIMITED"],
        "IS_SALE" => $arParams["IS_SALE"],
        "IS_EVENTS" => $arParams["IS_EVENTS"],
        "IS_SMART_OFFICE" => $arParams["IS_SMART_OFFICE"],
        "IS_COMFORT" => $arParams["IS_COMFORT"],
        "IS_CASUAL" => $arParams["IS_CASUAL"],
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

?>




        <?

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/cache.php';
$cache = cache::getInstance();
global $reviewS;
$apppage = isset($_SERVER['REQUEST_URI_OLD']) ? $_SERVER['REQUEST_URI_OLD'] : $APPLICATION -> GetCurPage();
$apppageCode = CUtil::translit($apppage, 'ru');

global $MAX_SMART_FILTER;

if(!empty($MAX_SMART_FILTER))
    $filter = $MAX_SMART_FILTER;
else
    $filter = [];

if(!$bIndex)
{
    global $minGlobalPrice,$maxGlobalPrice;
    $res = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['VARIABLES']['SECTION_ID']], false, ['ID','IBLOCK_ID','UF_*'])->Fetch();
    $minGlobalPrice = $res['UF_MIN_PRICE'];
    $maxGlobalPrice = $res['UF_MAX_PRICE'];
    if($cache -> isStartCache($apppageCode, 86400*5))
    {



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
        $image = 'https://stimma.com.ua'.CFile::GetFileArray($min['PREVIEW_PICTURE'])['SRC'];

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

}
/*
 *
 * <script type="text/JavaScript">
        document.getElementById('to').innerHTML = document.getElementById('from').innerHTML;
    </script>*/


$APPLICATION->AddViewContent('filter_counter_products','<div class="catalog-filter-viewed fff_countr">
            '.$cnt. (LANGUAGE_ID=='ua'?' товарів':' товаров') .'
        </div>');
?>

        <?
//if(isset($_GET['faq']))
if($thisSection['UF_IN_CHAP'])
{
    global $DB;

    # FAQ
    $questions=[];
    $res=$DB->Query('select * from faq_sections where UF_ID = ' . $thisSection['ID'] . ' and UF_LANG = \''.LANGUAGE_ID.'\' order by ID asc');
    while ($record =$res->Fetch())
        $questions[] = $record;

    if(!empty($questions))
    {
        ?>
        <div class="catalog-faq-cont">
            <div class="catalog-faq-title">
                <?=LANGUAGE_ID=='ua'?'Найпоширеніші запитання':'Самые популярные вопросы'?>
            </div>
            <div class="catalog-faq-list">
                <div class="accordion">
                    <?
                    $json=[];
                    foreach ($questions as $index => $question)
                    {
                        ?>
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panels<?=($index+1)?>" aria-expanded="false" >
                                    <?=$question['UF_QUESTION']?>
                                </button>
                            </div>
                            <div id="panels<?=($index+1)?>" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <?=$question['UF_ANSWER']?>
                                </div>
                            </div>
                        </div>
                        <?
                        $json[]='{
                    "@type": "Question",
                    "name": "'.addslashes($question['UF_QUESTION']).'",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "'.addslashes($question['UF_ANSWER']).'"
                    }
                }';
                    }
                    ?>
                </div>
            </div>
        </div>


        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "FAQPage",
                "mainEntity": [<?=implode(',',$json)?>]
            }
        </script>

        <?
    }
    else
    {
        $block3 = [];
        $res = CIBlockElement::GetList(array('PROPERTY_MINIMUM_PRICE' => 'asc'), $filter+['>PROPERTY_MINIMUM_PRICE' => 0], ['NAME','PROPERTY_NAME_UA'],['nTopCount' => 5]);
        while ($record = $res->GetNext())
            $block3[] = $record;

        $block2 = [];
        $res = CIBlockElement::GetList(array('PROPERTY_COUNTER' => 'desc','SHOW_COUNTER'=>'desc'), $filter+['>PROPERTY_MINIMUM_PRICE' => 0], ['NAME','PROPERTY_NAME_UA'],['nTopCount' => 5]);
        while ($record = $res->GetNext())
            $block2[] = $record;
        ?>
        <div class="catalog-faq-cont">
            <div class="catalog-faq-title">
                <?=LANGUAGE_ID=='ua'?'Найпоширеніші запитання':'Самые популярные вопросы'?>
            </div>
            <div class="catalog-faq-list">
                <div class="accordion">

                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panels1" aria-expanded="false" >
                                <?=LANGUAGE_ID=='ua'?'Які товари є в наявності?':'Какие товары есть в наличии?'?>
                            </button>
                        </div>
                        <div id="panels1" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <?=LANGUAGE_ID=='ua'?'В наявності '.$cnt.' товарних пропозицій за ціною від '.intval($min).' грн до '.intval($max).' грн':'В наличии '.$cnt.' товарных предложений за ценами от '.intval($min).' грн до '.intval($max).' грн'?>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panels2" aria-expanded="false" >
                                <?=LANGUAGE_ID=='ua'?'Які товари найпопулярніші?':'Какие товары самые популярные?'?>
                            </button>
                        </div>
                        <div id="panels2" class="accordion-collapse collapse">
                            <?
                            $jPart1='';
                            foreach ($block2 as $index => $item)
                            {
                                ?><div class="accordion-body"><a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?=(LANGUAGE_ID=='ua'?$item['PROPERTY_NAME_UA_VALUE']:$item['NAME'])?></a></div><?
                                $jPart1.='<a href="'.$item['DETAIL_PAGE_URL'].'">'.(LANGUAGE_ID=='ua'?$item['PROPERTY_NAME_UA_VALUE']:$item['NAME']).'</a>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panels3" aria-expanded="false" >
                                <?=LANGUAGE_ID=='ua'?'Які товари найдешевші?':'Какие товары самые дешевые?'?>
                            </button>
                        </div>
                        <div id="panels3" class="accordion-collapse collapse">
                            <?
                            $jPart2='';
                            foreach ($block3 as $index => $item)
                            {
                                ?><div class="accordion-body"><a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?=(LANGUAGE_ID=='ua'?$item['PROPERTY_NAME_UA_VALUE']:$item['NAME'])?></a></div><?
                                $jPart2.='<a href="'.$item['DETAIL_PAGE_URL'].'">'.(LANGUAGE_ID=='ua'?$item['PROPERTY_NAME_UA_VALUE']:$item['NAME']).'</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?
        $json[]='{
                    "@type": "Question",
                    "name": "Які товари є в наявності?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "В наявності '.$cnt.' товарних пропозицій за ціною від '.intval($min).' грн до '.intval($max).' грн"
                    }
                }';
        $json[]='{
                    "@type": "Question",
                    "name": "Які товари найпопулярніші?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "'.$jPart1.'"
                    }
                }';
        $json[]='{
                    "@type": "Question",
                    "name": "Які товари найдешевші?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "'.$jPart2.'"
                    }
                }';
    }

    // Які товари є в наявності?
    // Які товари найпопулярніші?
    // Які товари найдешевші?
    // Який асортимент?
# /FAQ
}
?>

        <?
$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
$section = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $intSectionID], false, ['ID','DESCRIPTION','NAME','UF_*']) -> Fetch();
if($section['UF_NAME_UA'] && LANGUAGE_ID == 'ua')
    $section['NAME'] = $section['UF_NAME_UA'];
if(!isset($_GET['PAGEN_1']) && !$bIndex)
{
    if(isset($_SERVER['ELEMENT_ID']) && $_SERVER['ELEMENT_ID'] > 0)
    {
        $seOELement = CIBlockElement::GetByID($_SERVER['ELEMENT_ID'])->GetNextElement();

        $seoFields = $seOELement->GetFields();
        $seoProps = $seOELement->GetProperties();

        if($seoProps['SEO_RU_TEXT']['~VALUE']['TEXT'] && LANGUAGE_ID=='ru')
        {
            ?>
            <div class="col-md-12">
            <div class="seo_text col-md-12" style="padding-top: 55px;">
                <?=$seoProps['SEO_RU_TEXT']['~VALUE']['TEXT']?>
            </div>
                </div>
            <?
        }
        elseif($seoProps['SEO_UA_TEXT']['~VALUE']['TEXT'] && LANGUAGE_ID=='ua')
        {
            ?>
            <div class="col-md-12">
            <div class="seo_text col-md-12" style="padding-top: 55px;">
                <?=$seoProps['SEO_UA_TEXT']['~VALUE']['TEXT']?>
            </div>
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
                    <div class="col-md-12">
                            <div class="seo_text col-md-12" style="padding-top: 55px;">
                                <?=$text?>
                            </div>
                    </div>
                    <?
                }
            }
        }
    }
    else
    {
        ?>
        <div class="col-md-12">
                <div class="seo_text col-md-12" style="padding-top: 55px;">
                    <?=LANGUAGE_ID=='ua' ? $section['UF_DETAIL_TEXT_UA'] : $section['DESCRIPTION']?>
                </div>
        </div>
        <?
    }
}
?>

<?/*$this->SetViewTarget("more_text_title");?>
<span class="element-count-wrapper"><span class="element-count muted font_xs rounded3">asdasd<?=$arResult['SECTION']['ELEMENT_CNT'];?></span></span>
<?$this->EndViewTarget();*/?>
<?
if($cntReview)
{
    ?>
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

    <?
}
//$APPLICATION->AddChainItem($section['NAME'], '');
?>
    </div>
</div>
<?
if($thisSection['ID'])
{
    $nav = \CIBlockSection::GetNavChain(false, $thisSection['ID']);

    $path = [];
    $code=$ru.'/catalog/';

    while ($item = $nav->GetNext())
    {
        if(LANGUAGE_ID=='ua')
        {
            $sectionF = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $item['ID']], false,
                    ['ID','IBLOCK_ID', 'NAME' ,'UF_*']) -> Fetch();
            if($sectionF['UF_NAME_UA'])
                $item['NAME'] = $section['UF_NAME_UA'];
        }
        $code.=$item['CODE'].'/';
        $path[] = ['name'=>$item['NAME'],'code'=>$code];

    }

    $number=2;
    foreach ($path as $index => $item)
    {
        $path[$index] = '{
            "@type": "ListItem",
            "position": '.$number.',
            "name": "'.str_replace('"','',$item['name']).'",
            "item": "htps://www.stimma.com.ua'.$item['code'].'"
        }';
        $number++;
    }
}
?>
<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "BreadcrumbList",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "<?=LANGUAGE_ID=='ua'?'Головна':'Главная'?>",
            "item": "https://www.stimma.com.ua"
        },<?=implode(',',$path)?>]
    }
</script>



