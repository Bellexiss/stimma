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

global $selectedFilter;





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

<?

?>

    <div class="catalog-page">
        <div class="catalog-control-block catalog-controlnew-block">
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

            <?
            if(!$arParams["IS_NEW"])
            {
                ?>
                <div class="catalog-grid-btn-block">
                    <div class="catalog-grid-btn  ">
                        <svg class="catalog-grid-btn-mob" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 0.5H20.5V20.5H0.5V0.5Z" stroke="currentColor"></path>
                        </svg>
                        <svg class="catalog-grid-btn-table" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 0.5V20.5M0.5 0.5H20.5V20.5H0.5V0.5Z" stroke="currentcolor"/>
                        </svg>
                        <svg class="catalog-grid-btn-desc" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 0.5H20.5V20.5H0.5V0.5Z" stroke="currentColor"></path>
                            <path d="M7.17 0.5V20.5" stroke="currentColor"></path>
                            <path d="M13.83 0.5V20.5" stroke="currentColor"></path>
                        </svg>

                    </div>
                    <div class="catalog-grid-btn rectangle active">
                        <!-- <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 0.5V20.5M0.634399 10H20.4996M0.5 0.5H20.5V20.5H0.5V0.5Z" stroke="currentcolor"/>
                        </svg> -->
                        <svg class="catalog-grid-btn-mob" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 0.5V20.5M0.5 0.5H20.5V20.5H0.5V0.5Z" stroke="currentcolor"/>
                        </svg>
                        <svg class="catalog-grid-btn-table" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 0.5H20.5V20.5H0.5V0.5Z" stroke="currentColor"></path>
                            <path d="M7.17 0.5V20.5" stroke="currentColor"></path>
                            <path d="M13.83 0.5V20.5" stroke="currentColor"></path>
                        </svg>
                        <svg class="catalog-grid-btn-desc" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 0.5H20.5V20.5H0.5V0.5Z" stroke="currentColor"></path>
                            <path d="M5.5 0.5V20.5" stroke="currentColor"></path>
                            <path d="M10.5 0.5V20.5" stroke="currentColor"></path>
                            <path d="M15.5 0.5V20.5" stroke="currentColor"></path>
                        </svg>
                    </div>
                </div>
                <?
            }
            ?>

        </div>


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

        $isNewPage = $arParams["IS_NEW"] || $arParams["IS_OUTDOOR"] || $arParams["IS_EVENTS"] || $arParams["IS_LIMITED"] || $arParams["IS_CRUISE"] || $arParams["IS_SMART_OFFICE"] || $arParams["IS_COMFORT"] || $arParams["IS_CASUAL"];

        ?>
        <div class="catalog-gridnew-cont">
                        <?
                    if(!$arParams["IS_NEW"] && !$arParams["IS_OUTDOOR"] && !$arParams["IS_EVENTS"] && !$arParams["IS_LIMITED"] && !$arParams["IS_CRUISE"] && !$arParams["IS_SMART_OFFICE"] && !$arParams["IS_COMFORT"] && !$arParams["IS_CASUAL"])
                        $APPLICATION->IncludeComponent(
                            "bitrix:catalog.smart.filter",
                            "new",
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
                        );?>

                <div class="catalog-gridnew-items <?=$isNewPage ? 'catalog-gridnew-nofilter' : ''?>">
                            
                        
                    <?$intSectionID = $APPLICATION->IncludeComponent(
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

                </div>
        </div>



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


                $viewed = $_SESSION['VIEWED_PRODUCTS'];
                if(!empty($viewed))
                {
                    $viewed = array_reverse($viewed);
                    $viewed = array_slice($viewed, 0, 20);
                    global $MAX_SMART_FILTER;
                    $MAX_SMART_FILTER['ID'] = $viewed;
                    ?>
                    <div class="search-goods-ex-cont catalog-goods-views-cont" style="margin-top:35px;">
                        <div class="catalog-faq-title">
                            <?=LANGUAGE_ID=='ua'?'Ви нещодавно переглядали:':'Вы недавно просматривали:'?>
                        </div>
                        <div class="search-goods-ex-slider-cont">
                            <?
                            $params = [
                                'IBLOCK_TYPE' => 'aspro_max_catalog',
                                'IBLOCK_ID' => '21',
                                'NO_SLIDER' => 'Y',
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
                                "SHOW_ALL_WO_SECTION" => "Y",
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
                    <?
                }
        ?>
    </div>
<?
?>




