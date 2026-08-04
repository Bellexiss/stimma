<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Проєкти");
?>
    <style>
        .rss{display:none !important;}
    </style>
<?
if($APPLICATION->GetCurPage() == '/blog/')
{
    if(isset($_GET['newstimma'])  || NEW_STIMMA)
    {?>
            <?/*
        <div class="breadcrumbs-cont">
            <div class="wrapper">
                <div class="breadcrumbs-block">
                    <a href="#" class="breadcrumb-item">
                        STIMMA
                    </a>
                    <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
                        </svg>
                    </span>
                    <a href="#" class="breadcrumb-item">
                        Угода користувача
                    </a>
                    <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
                        </svg>
                    </span>
                    <span class="breadcrumb-item">
                        Статті
                    </span>
                </div>
            </div>
        </div>
        <div class="info-pages-list-cont">
            <div class="wrapper">
                <div class="info-pages-list">
                    <a href="#" class="info-page-link active">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/infopimg1.png">
                        <div class="info-page-link-title">
                            Статті
                        </div>
                    </a>
                    <a href="#" class="info-page-link">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/infopimg2.png">
                        <div class="info-page-link-title">
                            Угода користувача
                        </div>
                    </a>
                    <a href="#" class="info-page-link">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/infopimg3.png">
                        <div class="info-page-link-title">
                            Співпраця
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="info-page-content news-page">
            <h2 class="info-page-title">
                Статті
            </h2>
            <div class="info-page-menu">
                <a href="#" class="info-page-menu-item active">
                    Всі статті
                </a>
                <a href="#" class="info-page-menu-item">
                    Загальні поради
                </a>
                <a href="#" class="info-page-menu-item">
                    Акції та знижки
                </a>
                <a href="#" class="info-page-menu-item">
                    Ідеї для образів
                </a>
            </div>
            <div class="news-grid">
                <div class="news-item-cont">
                    <div class="news-item">
                        <a href="#" class="news-item-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/newsim1.png">
                        </a>
                        <div class="news-item-types">
                            <a href="#" class="news-item-type">
                                Загальні поради
                            </a>
                        </div>
                        <a href="#" class="news-item-name">
                            Відкриття магазину STIMMA у ТРЦ "SKYMALL"
                        </a>
                        <div class="news-item-date">
                            30.08.2023
                        </div>
                    </div>
                </div>
                <div class="news-item-cont">
                    <div class="news-item">
                        <a href="#" class="news-item-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/newsim2.png">
                        </a>
                        <div class="news-item-types">
                            <a href="#" class="news-item-type">
                                Акції та знижки
                            </a>
                        </div>
                        <a href="#" class="news-item-name">
                            Зустрінемось на Galychyna Fashion Expo 2023
                        </a>
                        <div class="news-item-date">
                            01.08.2023
                        </div>
                    </div>
                </div>
                <div class="news-item-cont">
                    <div class="news-item">
                        <a href="#" class="news-item-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/newsim3.png">
                        </a>
                        <div class="news-item-types">
                            <a href="#" class="news-item-type">
                                Акції та знижки
                            </a>
                        </div>
                        <a href="#" class="news-item-name">
                            Твоя знижка -30% для прохолодних вечорів!
                        </a>
                        <div class="news-item-date">
                            29.04.2023
                        </div>
                    </div>
                </div>
                <div class="news-item-cont">
                    <div class="news-item">
                        <a href="#" class="news-item-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/newsim4.png">
                        </a>
                        <div class="news-item-types">
                            <a href="#" class="news-item-type">
                                Ідеї для образів
                            </a>
                        </div>
                        <a href="#" class="news-item-name">
                            Джемпер – базова річ у жіночому гардеробі.
                        </a>
                        <div class="news-item-date">
                            30.11.2021
                        </div>
                    </div>
                </div>
                <div class="news-item-cont">
                    <div class="news-item">
                        <a href="#" class="news-item-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/newsim5.png">
                        </a>
                        <div class="news-item-types">
                            <a href="#" class="news-item-type">
                                Ідеї для образів
                            </a>
                        </div>
                        <a href="#" class="news-item-name">
                            У чому різниця між джемпером та светром?
                        </a>
                        <div class="news-item-date">
                            30.11.2021
                        </div>
                    </div>
                </div>
                <div class="news-item-cont">
                    <div class="news-item">
                        <a href="#" class="news-item-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/newsim6.png">
                        </a>
                        <div class="news-item-types">
                            <a href="#" class="news-item-type">
                                Ідеї для образів
                            </a>
                        </div>
                        <a href="#" class="news-item-name">
                            Сукня-сорочка: зручність та функціональність
                        </a>
                        <div class="news-item-date">
                            30.11.2021
                        </div>
                    </div>
                </div>
                <div class="news-item-cont">
                    <div class="news-item">
                        <a href="#" class="news-item-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/newsim7.png">
                        </a>
                        <div class="news-item-types">
                            <a href="#" class="news-item-type">
                                Ідеї для образів
                            </a>
                        </div>
                        <a href="#" class="news-item-name">
                           В’язана сукня: модні кольори 2022
                        </a>
                        <div class="news-item-date">
                            30.11.2021
                        </div>
                    </div>
                </div>
                <div class="news-item-cont">
                    <div class="news-item">
                        <a href="#" class="news-item-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/newsim8.png">
                        </a>
                        <div class="news-item-types">
                            <a href="#" class="news-item-type">
                                Ідеї для образів
                            </a>
                        </div>
                        <a href="#" class="news-item-name">
                            Об’ємний светр – тренд сезону
                        </a>
                        <div class="news-item-date">
                            30.11.2021
                        </div>
                    </div>
                </div>
                <div class="news-item-cont">
                    <div class="news-item">
                        <a href="#" class="news-item-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/newsim9.png">
                        </a>
                        <div class="news-item-types">
                            <a href="#" class="news-item-type">
                                Ідеї для образів
                            </a>
                        </div>
                        <a href="#" class="news-item-name">
                            Сарафан із класичним кроєм – тренд весни.
                        </a>
                        <div class="news-item-date">
                            30.11.2021
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagination-cont">
                <div class="pagination-block">
                    <a href="#" class="pagination-arrow pagination-item disabled">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M-3.76701e-05 6.53121C-3.76701e-05 6.68306 0.058001 6.83506 0.173931 6.95099L6.11143 12.8885C6.34344 13.1205 6.71913 13.1205 6.95099 12.8885C7.18285 12.6565 7.183 12.2808 6.95099 12.0489L1.43327 6.53121L6.95099 1.01349C7.183 0.781487 7.183 0.40579 6.95099 0.173931C6.71899 -0.0579281 6.34329 -0.0580769 6.11143 0.173931L0.173931 6.11143C0.058001 6.22736 -3.76701e-05 6.37936 -3.76701e-05 6.53121Z" fill="currentcolor"/>
                        </svg>
                    </a>
                    <div class="padination-pages">
                        <a href="#" class="pagination-item active">
                            1
                        </a>
                        <a href="#" class="pagination-item">
                            2
                        </a>
                        <a href="#" class="pagination-item">
                            3
                        </a>
                        <span class="pagination-item pagination-sep">...</span>
                        <a href="#" class="pagination-item">
                            15
                        </a>
                    </div>
                    <a href="#" class="pagination-arrow pagination-item">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.12504 6.53121C7.12504 6.68306 7.067 6.83506 6.95107 6.95099L1.01357 12.8885C0.78156 13.1205 0.405865 13.1205 0.174006 12.8885C-0.0578535 12.6565 -0.058002 12.2808 0.174006 12.0489L5.69173 6.53121L0.174006 1.01349C-0.058002 0.781487 -0.058002 0.40579 0.174006 0.173931C0.406014 -0.0579281 0.781709 -0.0580769 1.01357 0.173931L6.95107 6.11143C7.067 6.22736 7.12504 6.37936 7.12504 6.53121Z" fill="currentcolor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        */?>

    <?
    //} else{


        $APPLICATION->IncludeComponent(
            "bitrix:news",
            "blog_new",
            array(
                "IBLOCK_TYPE" => "aspro_max_content",
                "IBLOCK_ID" => "44",
                "NEWS_COUNT" => "6",
                "USE_SEARCH" => "N",
                "USE_RSS" => "Y",
                "USE_RATING" => "N",
                "USE_CATEGORIES" => "N",
                "USE_FILTER" => "Y",
                "FILTER_NAME" => "arRegionLink",
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_ORDER1" => "DESC",
                "SORT_BY2" => "ID",
                "SORT_ORDER2" => "DESC",
                "CHECK_DATES" => "Y",
                "SEF_MODE" => "Y",
                "SEF_FOLDER" => "/blog/",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "100000",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "N",
                "SET_TITLE" => "Y",
                "SET_STATUS_404" => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "ADD_SECTIONS_CHAIN" => "N",
                "USE_PERMISSIONS" => "N",
                "PREVIEW_TRUNCATE_LEN" => "250",
                "LIST_ACTIVE_DATE_FORMAT" => "j F Y",
                "LIST_FIELD_CODE" => array(
                    0 => "NAME",
                    1 => "PREVIEW_TEXT",
                    2 => "PREVIEW_PICTURE",
                    3 => "DATE_ACTIVE_FROM",
                    4 => "",
                ),
                "LIST_PROPERTY_CODE" => array(
                    0 => "BNR_DOP_TEXT_UA",
                    1 => "",
                ),
                "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                "DISPLAY_NAME" => "N",
                "META_KEYWORDS" => "-",
                "META_DESCRIPTION" => "-",
                "BROWSER_TITLE" => "-",
                "DETAIL_ACTIVE_DATE_FORMAT" => "j F Y G:i",
                "DETAIL_FIELD_CODE" => array(
                    0 => "TAGS",
                    1 => "PREVIEW_TEXT",
                    2 => "DETAIL_TEXT",
                    3 => "DETAIL_PICTURE",
                    4 => "DATE_ACTIVE_FROM",
                    5 => "",
                ),
                "DETAIL_PROPERTY_CODE" => array(
                    0 => "LINK_GOODS",
                    1 => "FORM_QUESTION",
                    2 => "FORM_ORDER",
                    3 => "LINK_SERVICES",
                    4 => "PHOTOS",
                    5 => "DOCUMENTS",
                    6 => "",
                ),
                "DETAIL_DISPLAY_TOP_PAGER" => "N",
                "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
                "DETAIL_PAGER_TITLE" => "Страница",
                "DETAIL_PAGER_TEMPLATE" => "",
                "DETAIL_PAGER_SHOW_ALL" => "Y",
                "PAGER_TEMPLATE" => "main",
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "PAGER_TITLE" => "Новости",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "IMAGE_POSITION" => "left",
                "USE_SHARE" => "Y",
                "AJAX_OPTION_ADDITIONAL" => "",
                "USE_REVIEW" => "N",
                "ADD_ELEMENT_CHAIN" => "N",
                "SHOW_DETAIL_LINK" => "Y",
                "S_ASK_QUESTION" => "",
                "S_ORDER_SERVISE" => "",
                "T_GALLERY" => "",
                "T_DOCS" => "",
                "T_GOODS" => "Товары",
                "T_SERVICES" => "",
                "T_STUDY" => "",
                "COMPONENT_TEMPLATE" => "blog",
                "SECTION_ELEMENTS_TYPE_VIEW" => "FROM_MODULE",
                "ELEMENT_TYPE_VIEW" => "element_1",
                "SET_LAST_MODIFIED" => "N",
                "T_VIDEO" => "",
                "T_NEXT_LINK" => "",
                "T_PREV_LINK" => "",
                "SHOW_SECTION_PREVIEW_DESCRIPTION" => "Y",
                "SHOW_SECTION_DESCRIPTION" => "Y",
                "LINE_ELEMENT_COUNT" => "2",
                "LINE_ELEMENT_COUNT_LIST" => "4",
                "DETAIL_SET_CANONICAL_URL" => "N",
                "SHOW_NEXT_ELEMENT" => "N",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "SHOW_404" => "N",
                "MESSAGE_404" => "",
                "FORM_ID_ORDER_SERVISE" => "",
                "IMAGE_WIDE" => "Y",
                "NUM_NEWS" => "20",
                "NUM_DAYS" => "30",
                "YANDEX" => "N",
                "T_ALSO_ITEMS" => "",
                "ALSO_ITEMS_POSITION" => "side",
                "DETAIL_USE_COMMENTS" => "N",
                "DETAIL_BLOG_USE" => "N",
                "DETAIL_BLOG_URL" => "catalog_comments",
                "DETAIL_BLOG_EMAIL_NOTIFY" => "Y",
                "DETAIL_VK_USE" => "N",
                "DETAIL_VK_API_ID" => "6284571",
                "DETAIL_FB_USE" => "N",
                "DETAIL_FB_APP_ID" => "",
                "COMMENTS_COUNT" => "10",
                "BLOG_TITLE" => "Комментарии",
                "VK_TITLE" => "Вконтакте",
                "FB_TITLE" => "Facebook",
                "DETAIL_STRICT_SECTION_CHECK" => "N",
                "STRICT_SECTION_CHECK" => "N",
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "FILE_404" => "",
                "FILTER_FIELD_CODE" => array(
                    0 => "NAME",
                    1 => "PREVIEW_PICTURE",
                    2 => "DATE_ACTIVE_FROM",
                    3 => "ACTIVE_FROM",
                    4 => "",
                ),
                "FILTER_PROPERTY_CODE" => array(
                    0 => "TYPE_BLOCK",
                    1 => "",
                ),
                "ALSO_ITEMS_COUNT" => "5",
                "GALLERY_TYPE" => "small",
                "LIST_VIEW" => "slider",
                "LINKED_ELEMENST_PAGE_COUNT" => "20",
                "SHOW_DISCOUNT_PERCENT_NUMBER" => "N",
                "PRICE_CODE" => array(
                    0 => "BASE",
                ),
                "STORES" => array(
                    0 => "",
                    1 => "",
                ),
                "HIDE_NOT_AVAILABLE" => "N",
                "SHOW_FILTER_DATE" => "Y",
                "SHOW_ASK_BLOCK" => "N",
                "HIDE_BORDER_ELEMENT" => "Y",
                "SHOW_BORDER_ELEMENT" => "Y",
                "USE_BG_IMAGE_ALTERNATE" => "Y",
                "BG_POSITION" => "center",
                "TYPE_IMG" => "lg",
                "SIZE_IN_ROW" => "3",
                "TITLE_SHOW_FON" => "Y",
                "SIDE_LEFT_BLOCK" => "RIGHT",
                "TYPE_LEFT_BLOCK" => "4",
                "SIDE_LEFT_BLOCK_DETAIL" => "FROM_MODULE",
                "TYPE_LEFT_BLOCK_DETAIL" => "FROM_MODULE",
                "IBLOCK_LINK_NEWS_ID" => "23",
                "IBLOCK_LINK_SERVICES_ID" => "24",
                "IBLOCK_LINK_TIZERS_ID" => "11",
                "IBLOCK_LINK_REVIEWS_ID" => "10",
                "IBLOCK_LINK_STAFF_ID" => "30",
                "IBLOCK_LINK_VACANCY_ID" => "2",
                "IBLOCK_LINK_BLOG_ID" => "28",
                "IBLOCK_LINK_PROJECTS_ID" => "26",
                "IBLOCK_LINK_BRANDS_ID" => "29",
                "IBLOCK_LINK_LANDINGS_ID" => "28",
                "BLOCK_SERVICES_NAME" => "Услуги",
                "BLOCK_NEWS_NAME" => "Новости",
                "BLOCK_TIZERS_NAME" => "",
                "BLOCK_REVIEWS_NAME" => "Отзывы",
                "BLOCK_STAFF_NAME" => "Сотрудники",
                "BLOCK_VACANCY_NAME" => "Вакансии",
                "BLOCK_PROJECTS_NAME" => "Проекты",
                "BLOCK_BRANDS_NAME" => "Бренды",
                "BLOCK_BLOG_NAME" => "Статьи",
                "BLOCK_LANDINGS_NAME" => "Коллекции",
                "STAFF_TYPE_DETAIL" => "list",
                "DETAIL_BLOCKS_ALL_ORDER" => "tizers,desc,char,docs,services,news,vacancy,blog,reviews,projects,staff,goods,brands,gallery,landings,form_order,comments",
                "IBLOCK_LINK_PARTNERS_ID" => "19",
                "BLOCK_PARTNERS_NAME" => "Партнеры",
                "DETAIL_LINKED_GOODS_SLIDER" => "Y",
                "SEF_URL_TEMPLATES" => array(
                    "news" => "",
                    "section" => "",
                    "detail" => "/blog/#ELEMENT_CODE#/",
                    "rss" => "rss/",
                    "rss_section" => "#SECTION_ID#/rss/",
                )
            ),
            false
        );

        $APPLICATION->SetPageProperty('title','Про нас пишуть');

    }
}
else
{
    if(isset($_GET['newstimma']) || NEW_STIMMA )
    {?>

        <div class="breadcrumbs-cont">
            <div class="wrapper">
                <div class="breadcrumbs-block">
                    <a href="#" class="breadcrumb-item">
                        STIMMA
                    </a>
                    <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
                        </svg>
                    </span>
                    <a href="#" class="breadcrumb-item">
                        Угода користувача
                    </a>
                    <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
                        </svg>
                    </span>
                    <a href="#" class="breadcrumb-item">
                        Статті
                    </a>
                    <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
                        </svg>
                    </span>
                    <span class="breadcrumb-item">
                        Джемпер – базова річ у жіночому гардеробі.
                    </span>
                </div>
            </div>
        </div>
        <div class="info-page-content">
            <h2 class="info-page-title">
                Джемпер – базова річ у жіночому гардеробі.
            </h2>
            <div class="news-detail-page">
                <div class="news-detail-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsd2.png">
                </div>
                <div class="news-detail-text-block">
                    <div class="news-detail-date">
                        Опубліковано: 30.11.2021
                    </div>
                    <div class="news-detail-text">
                        <div class="news-detail-text-group">
                            <p><b>
                                Холодна пора року – ідеальний час для модних експериментів, стильних багатошарових образів, нетривіальних рішень. Сучасним дизайнерам вдається бездоганно поєднувати у теплих трикотажних речах красу та комфорт. Щоб зробити гардероб більш різноманітним, варто придбати кілька модних джемперів у 2022 році фасонів, кольорів. Джемпер – універсальна, базова річ, яка чудово поєднується як зі спідницями, брюками, джинсами, так і з сукнями. За допомогою цієї нехитрої речі можна створити унікальний багатошаровий образ у діловому, повсякденному, романтичному стилі.
                            </b></p>
                        </div>
                        <div class="news-detail-text-group">
                            <h4>
                                <b>Які кольори у тренді у 2022 році?</b>
                            </h4>
                            <p>
                                Вибираючи джемпер, варто звернути особливу увагу на колір. Напевно, ви знаєте, які відтінки в найбільш вигідному світлі підкреслюють ваш відтінок шкіри, але не бійтеся експериментувати. Якщо ви оберете модель з V-подібним вирізом, то навіть найнебезпечніший колір буде досить далеко від обличчя і не зробить відтінок шкіри блідим, сіруватим. Крім того, можна скористатися іншим модним прийомом і використовувати шийну хустку або комірець. Так, у 2022 році актуальними кольорами визнано:
                            </p>
                            <ul>
                                <li>
                                   фісташковий;
                                </li>
                                <li>
                                   пляшка (глибокий зелений);
                                </li>
                                <li>
                                    хакі;
                                </li>
                                <li>
                                    коричневий з усіма його відтінками.
                                </li>
                            </ul>
                        </div>
                        <div class="news-detail-text-group">
                            <p>
                                Ці відтінки виглядають стильно та благородно, особливо на в’язаній фактурі джемпера. Також ви можете поекспериментувати, вибравши яскравіші, але не менш модні, кольори – жовтий, помаранчевий, синій. Яскравий джемпер підніме настрій навіть у похмуру погоду і виглядатиме дуже ефектно. Якщо ви шукаєте модель для базового гардеробу, яка відмінно поєднуватиметься з більшістю інших відтінків, то можете зупинити вибір на спокійних тонах – бежевий, слонова кістка, білий, чорний і т.д. Джемпери подібних кольорів виглядають стримано, але при цьому елегантно – вони добре вписуються у повсякденне життя та офісний дрес-код.
                            </p>
                        </div>
                        <div class="news-detail-text-group">
                            <h4>
                                <b>Які фасони актуальні у 2022 році?</b>
                            </h4>
                            <p>
                              У 2022 році актуальні джемпери:
                            </p>
                            <ul>
                                <li>
                                   з розрізами – асиметричні та симетричні, знизу та зверху – чим несподіваніше, тим стильніше;
                                </li>
                                <li>
                                    оверсайз – вільний крій, широкі рукави дозволяють створювати затишні, повітряні образи, що відповідають холодному сезону;
                                </li>
                                <li>
                                    з широкими поясами – масивний пояс контрастного кольору допоможе підкреслити талію та зробити образ більш жіночним, але водночас зухвалим.
                                </li>
                            </ul>
                        </div>
                        <div class="news-detail-text-group">
                            <p>
                                У 2022 році, як і раніше, актуальні моделі з відкритими плечима – подібні джемпери виглядають жіночно, витончено і навіть ошатно. Купити стильний джемпер можна через інтернет магазин Stimma. У каталозі представлені трендові та базові моделі різних кольорів та фасонів. Ви можете носити джемпер як самостійний «верх» або надіти під них водолазку кроп-топ із високою горловиною, отримавши трендовий аутфіт, або доповнити кофту сорочкою.
                            </p>
                        </div>
                        <div class="news-detail-text-group">
                            <p>
                                Не бійтеся експериментувати з кольорами та фактурами – у 2022 році, як і раніше, актуальні нетривіальні стилістичні рішення, що підкреслюють індивідуальність. Всі речі з колекції Stimma гармонійно поєднуються між собою, тому вам не важко зібрати модний аутфіт для будь-якого випадку життя. Речі виготовляються з міцних, довговічних матеріалів, а значить – при дотриманні правил догляду джемпер не деформується і не вицвітає, радуватиме вас первозданним виглядом жоден сезон.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="info-page-content news-detail-action" style="display:none;">
            <h2 class="info-page-title">
                Відкриття магазину STIMMA у ТРЦ "SKYMALL"
            </h2>
            <div class="news-detail-page">
                <div class="news-detail-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsd1.png">
                </div>
                <div class="news-detail-text-block">
                    <div class="news-detail-date">
                        Опубліковано: 30.11.2021
                    </div>
                    <div class="news-detail-text">
                        <div class="news-detail-title-block">
                            <div class="news-detail-title">
                                НЕ ПРОПУСТИ!
                            </div>
                            <div class="news-detail-title-desc">
                                <div class="news-detail-semititle">Відкриття магазину STIMMA у ТРЦ "SKYMALL"</div>
                                З нагоди відкриття знижки до -60%*
                            </div>
                        </div>
                        <div class="news-detail-action-detail">
                            Зустрічаємося 9 <b>вересня</b><br> 
                            ТРЦ “SKY MALL” <br>
                            проспект Романа Шухевича, 2т
                        </div>
                        <div class="news-detail-ps">
                            *Знижка діє з 09.09.2023 по 10.10.2023 у магазині STIMMA за адресою м. Київ, просп. Романа Шухевича, 2т за умови наявності акційного товару. Під акційним товаром розуміється товар із червоним цінником.
                        </div>
                        <div class="news-detail-btn">
                            <a href="#" class="info-btn info-btn-black">
                                Також, знайти нас можна тут
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?} else{

    preg_match('/\/blog\/(.*)\//', $APPLICATION->GetCurPage(), $matches);

    if($matches[1])
    {
        $news = CIBlockElement::GetList([],['CODE'=>$matches[1],'IBLOCK_ID'=>44,'ACTIVE'=>'Y']);
        if($news = $news->GetNextElement())
        {
            $fields = $news->GetFields();
            $props = $news->GetProperties();

            $img = CFile::GetPath($fields['DETAIL_PICTURE']);

            ?>
            <div class="blod-details-page">
                <div class="blod-details-img-title">
                    <img src="<?=$img?>">
                </div>
                <h1><?=LANGUAGE_ID == 'ua' ? $props['NAME_UA']['VALUE'] : $fields['NAME']?></h1>
                <?/*
                <div class="blod-details-img">
                    <img src="<?=$img?>">
                </div>
                */?>
                <p><?=LANGUAGE_ID=='ua' ? $props['WIDE_TEXT_UA']['~VALUE']['TEXT'] : $fields['DETAIL_TEXT']?></p>
                <?/*
                <div class="blod-details-img">
                    <img src="<?=$img?>">
                </div>
                */?>
            </div>
            <?

            $APPLICATION->SetPageProperty('title',$props['NAME_UA']['VALUE']);
            $APPLICATION->SetPageProperty('description',strip_tags($props['BNR_DOP_TEXT_UA']['~VALUE']['TEXT']));
        }
    }

    }
}

?>

<?/*
<div class="blog-grid-block">
	<div class="blog-item-cont">
		<div class="blog-item">
			<div class="blog-item-title">
				<a href="#">
					Відкриття флагманського магазину PAPAYA в Києві
				</a>
			</div>
			<div class="blog-item-img">
				<a href="#">
					<img src="/bitrix/templates/stimma/images/blgimg.webp">
				</a>
			</div>
			<div class="blog-item-desc">
				Денім давно вийшов за межі casual стилю, та перетворився в самостійни стиль. Джинс кожного року на піку популярності і 2023 не став винятком. У статті розглянемо основні тенденції деніму, та як його стлізувати цієї весни, щоб виглядати модно.
			</div>
			<div class="blog-item-link">
				<a href="#">
					Детальніше
					<span class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>
					</span>
				</a>
			</div>
		</div>
	</div>
	<div class="blog-item-cont">
		<div class="blog-item">
			<div class="blog-item-title">
				<a href="#">
					Відкриття флагманського магазину PAPAYA в Києві
				</a>
			</div>
			<div class="blog-item-img">
				<a href="#">
					<img src="/bitrix/templates/stimma/images/blgimg.webp">
				</a>
			</div>
			<div class="blog-item-desc">
				Денім давно вийшов за межі casual стилю, та перетворився в самостійни стиль. Джинс кожного року на піку популярності і 2023 не став винятком. У статті розглянемо основні тенденції деніму, та як його стлізувати цієї весни, щоб виглядати модно.
			</div>
			<div class="blog-item-link">
				<a href="#">
					Детальніше
					<span class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>
					</span>
				</a>
			</div>
		</div>
	</div>
	<div class="blog-item-cont">
		<div class="blog-item">
			<div class="blog-item-title">
				<a href="#">
					Відкриття флагманського магазину PAPAYA в Києві
				</a>
			</div>
			<div class="blog-item-img">
				<a href="#">
					<img src="/bitrix/templates/stimma/images/blgimg.webp">
				</a>
			</div>
			<div class="blog-item-desc">
				Денім давно вийшов за межі casual стилю, та перетворився в самостійни стиль. Джинс кожного року на піку популярності і 2023 не став винятком. У статті розглянемо основні тенденції деніму, та як його стлізувати цієї весни, щоб виглядати модно.
			</div>
			<div class="blog-item-link">
				<a href="#">
					Детальніше
					<span class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>
					</span>
				</a>
			</div>
		</div>
	</div>
	<div class="blog-item-cont">
		<div class="blog-item">
			<div class="blog-item-title">
				<a href="#">
					Відкриття флагманського магазину PAPAYA в Києві
				</a>
			</div>
			<div class="blog-item-img">
				<a href="#">
					<img src="/bitrix/templates/stimma/images/blgimg.webp">
				</a>
			</div>
			<div class="blog-item-desc">
				Денім давно вийшов за межі casual стилю, та перетворився в самостійни стиль. Джинс кожного року на піку популярності і 2023 не став винятком. У статті розглянемо основні тенденції деніму, та як його стлізувати цієї весни, щоб виглядати модно.
			</div>
			<div class="blog-item-link">
				<a href="#">
					Детальніше
					<span class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>
					</span>
				</a>
			</div>
		</div>
	</div>
	<div class="blog-item-cont">
		<div class="blog-item">
			<div class="blog-item-title">
				<a href="#">
					Відкриття флагманського магазину PAPAYA в Києві
				</a>
			</div>
			<div class="blog-item-img">
				<a href="#">
					<img src="/bitrix/templates/stimma/images/blgimg.webp">
				</a>
			</div>
			<div class="blog-item-desc">
				Денім давно вийшов за межі casual стилю, та перетворився в самостійни стиль. Джинс кожного року на піку популярності і 2023 не став винятком. У статті розглянемо основні тенденції деніму, та як його стлізувати цієї весни, щоб виглядати модно.
			</div>
			<div class="blog-item-link">
				<a href="#">
					Детальніше
					<span class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>
					</span>
				</a>
			</div>
		</div>
	</div>
	<div class="blog-item-cont">
		<div class="blog-item">
			<div class="blog-item-title">
				<a href="#">
					Відкриття флагманського магазину PAPAYA в Києві
				</a>
			</div>
			<div class="blog-item-img">
				<a href="#">
					<img src="/bitrix/templates/stimma/images/blgimg.webp">
				</a>
			</div>
			<div class="blog-item-desc">
				Денім давно вийшов за межі casual стилю, та перетворився в самостійни стиль. Джинс кожного року на піку популярності і 2023 не став винятком. У статті розглянемо основні тенденції деніму, та як його стлізувати цієї весни, щоб виглядати модно.
			</div>
			<div class="blog-item-link">
				<a href="#">
					Детальніше
					<span class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>
					</span>
				</a>
			</div>
		</div>
	</div>
	<div class="blog-item-cont">
		<div class="blog-item">
			<div class="blog-item-title">
				<a href="#">
					Відкриття флагманського магазину PAPAYA в Києві
				</a>
			</div>
			<div class="blog-item-img">
				<a href="#">
					<img src="/bitrix/templates/stimma/images/blgimg.webp">
				</a>
			</div>
			<div class="blog-item-desc">
				Денім давно вийшов за межі casual стилю, та перетворився в самостійни стиль. Джинс кожного року на піку популярності і 2023 не став винятком. У статті розглянемо основні тенденції деніму, та як його стлізувати цієї весни, щоб виглядати модно.
			</div>
			<div class="blog-item-link">
				<a href="#">
					Детальніше
					<span class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>
					</span>
				</a>
			</div>
		</div>
	</div>
	<div class="blog-item-cont">
		<div class="blog-item">
			<div class="blog-item-title">
				<a href="#">
					Відкриття флагманського магазину PAPAYA в Києві
				</a>
			</div>
			<div class="blog-item-img">
				<a href="#">
					<img src="/bitrix/templates/stimma/images/blgimg.webp">
				</a>
			</div>
			<div class="blog-item-desc">
				Денім давно вийшов за межі casual стилю, та перетворився в самостійни стиль. Джинс кожного року на піку популярності і 2023 не став винятком. У статті розглянемо основні тенденції деніму, та як його стлізувати цієї весни, щоб виглядати модно.
			</div>
			<div class="blog-item-link">
				<a href="#">
					Детальніше
					<span class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>
					</span>
				</a>
			</div>
		</div>
	</div>
</div>
*/?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>