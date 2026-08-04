<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Проекты");
?>
<?

if(isset($_GET['newstimma'])  || NEW_STIMMA)
{
    ?>
    <?$APPLICATION->IncludeComponent(
    "bitrix:news",
    "projects",
    array(
        "IBLOCK_TYPE" => "aspro_max_content",
        "IBLOCK_ID" => "44",
        "NEWS_COUNT" => "200",
        "USE_SEARCH" => "N",
        "USE_RSS" => "N",
        "USE_RATING" => "N",
        "USE_CATEGORIES" => "N",
        "USE_FILTER" => "Y",
        "FILTER_NAME" => "arProjectFilter",
        "SORT_BY1" => "SORT",
        "SORT_ORDER1" => "ASC",
        "SORT_BY2" => "ID",
        "SORT_ORDER2" => "DESC",
        "CHECK_DATES" => "Y",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/ru/projects/",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "100000",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "N",
        "SET_TITLE" => "Y",
        "SET_STATUS_404" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "Y",
        "USE_PERMISSIONS" => "N",
        "PREVIEW_TRUNCATE_LEN" => "",
        "LIST_ACTIVE_DATE_FORMAT" => "j F Y",
        "LIST_FIELD_CODE" => array(
            0 => "NAME",
            1 => "PREVIEW_TEXT",
            2 => "PREVIEW_PICTURE",
            3 => "",
        ),
        "LIST_PROPERTY_CODE" => array(
            0 => "NAME_UA",
            1 => "",
        ),
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "DISPLAY_NAME" => "N",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "DETAIL_ACTIVE_DATE_FORMAT" => "j F Y",
        "DETAIL_FIELD_CODE" => array(
            0 => "NAME",
            1 => "PREVIEW_TEXT",
            2 => "DETAIL_TEXT",
            3 => "DETAIL_PICTURE",
            4 => "",
        ),
        "DETAIL_PROPERTY_CODE" => array(
            0 => "FORM_ORDER",
            1 => "FORM_QUESTION",
            2 => "ORDERER",
            3 => "SITE",
            4 => "DATA",
            5 => "AUTHOR",
            6 => "LINK_BRANDS",
            7 => "LINK_VACANCY",
            8 => "TASK_PROJECT",
            9 => "LINK_LANDINGS",
            10 => "LINK_NEWS",
            11 => "LINK_REVIEWS",
            12 => "LINK_PARTNERS",
            13 => "LINK_PROJECTS",
            14 => "LINK_STAFF",
            15 => "LINK_BLOG",
            16 => "LINK_TIZERS",
            17 => "LINK_GOODS",
            18 => "LINK_SERVICES",
            19 => "LINK_TEAM",
            20 => "LINK_COMPANY",
            21 => "FORM_PROJECT",
            22 => "DOCUMENTS",
            23 => "PHOTOS",
            24 => "GALLEY_BIG",
            25 => "",
        ),
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
        "DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PAGER_TEMPLATE" => "",
        "DETAIL_PAGER_SHOW_ALL" => "Y",
        "PAGER_TEMPLATE" => ".default",
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
        "ADD_ELEMENT_CHAIN" => "Y",
        "SHOW_DETAIL_LINK" => "Y",
        "S_ASK_QUESTION" => "",
        "S_ORDER_PROJECT" => "Заказать проект",
        "T_GALLERY" => "",
        "T_DOCS" => "",
        "T_PROJECTS" => "Похожие проекты",
        "T_CHARACTERISTICS" => "",
        "COMPONENT_TEMPLATE" => "projects",
        "SET_LAST_MODIFIED" => "N",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "DETAIL_SET_CANONICAL_URL" => "N",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "SHOW_404" => "Y",
        "MESSAGE_404" => "",
        "FORM_ID" => "",
        "GALLERY_TYPE" => "big",
        "T_GOODS" => "Товары",
        "T_SERVICES" => "",
        "T_REVIEWS" => "Отзыв клиента",
        "SECTION_ELEMENTS_TYPE_VIEW" => "FROM_MODULE",
        "ELEMENT_TYPE_VIEW" => "element_1",
        "LINE_ELEMENT_COUNT" => "3",
        "LINE_ELEMENT_COUNT_LIST" => "3",
        "SHOW_SECTION_PREVIEW_DESCRIPTION" => "Y",
        "SHOW_SECTION_DESCRIPTION" => "Y",
        "S_ORDER_SERVISE" => "Заказать проект",
        "SHOW_MAX_ELEMENT" => "N",
        "T_MAX_LINK" => "",
        "T_PREV_LINK" => "",
        "FORM_ID_ORDER_SERVISE" => "6",
        "IMAGE_WIDE" => "Y",
        "DETAIL_STRICT_SECTION_CHECK" => "N",
        "FILTER_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "FILTER_PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "DETAIL_BRAND_USE" => "Y",
        "DETAIL_BRAND_PROP_CODE" => array(
            0 => "TIZERS",
            1 => "",
        ),
        "T_CLIENTS" => "",
        "STRICT_SECTION_CHECK" => "N",
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
        "FILE_404" => "",
        "SHOW_FILTER_DATE" => "Y",
        "SHOW_ASK_BLOCK" => "N",
        "SHOW_BORDER_ELEMENT" => "Y",
        "USE_BG_IMAGE_ALTERNATE" => "Y",
        "BG_POSITION" => "center",
        "TYPE_IMG" => "lg",
        "SIZE_IN_ROW" => "4",
        "TITLE_SHOW_FON" => "N",
        "SIDE_LEFT_BLOCK" => "FROM_MODULE",
        "TYPE_LEFT_BLOCK" => "FROM_MODULE",
        "ALL_BLOCK_BG" => "Y",
        "TYPE_HEAD_BLOCK" => "FROM_MODULE",
        "SIDE_LEFT_BLOCK_DETAIL" => "RIGHT",
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
        "IBLOCK_LINK_LANDINGS_ID" => "",
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
        "DETAIL_BLOCKS_ALL_ORDER" => "tizers,desc,char,docs,services,goods,reviews,news,vacancy,blog,form_order,projects,staff,brands,gallery,landings,partners,comments",
        "DETAIL_USE_COMMENTS" => "N",
        "DETAIL_BLOG_USE" => "N",
        "DETAIL_VK_USE" => "N",
        "DETAIL_FB_USE" => "N",
        "IBLOCK_LINK_PARTNERS_ID" => "",
        "BLOCK_PARTNERS_NAME" => "Партнеры",
        "DETAIL_LINKED_GOODS_SLIDER" => "Y",
        "SHOW_TOP_PROJECT_BLOCK" => "Y",
        "TOP_GALLERY_PROPERTY_CODE" => "PHOTOS",
        "ADDITIONAL_GALLERY_PROPERTY_CODE" => "GALLEY_BIG",
        "MAIN_GALLERY_PROPERTY_CODE" => "GALLEY_BIG",
        "DETAIL_BLOG_URL" => "catalog_comments",
        "COMMENTS_COUNT" => "5",
        "BLOG_TITLE" => "Комментарии",
        "DETAIL_BLOG_EMAIL_NOTIFY" => "N",
        "SEF_URL_TEMPLATES" => array(
            "news" => "",
            "section" => "#SECTION_CODE_PATH#/",
            "detail" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
        )
    ),
    false
);?>
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
                    <span class="breadcrumb-item">
                        Проекти
                    </span>
                </div>
            </div>
        </div>

        <div class="project-cont">
        	<div class="project-block">
        		<div class="project-wrapper">
	        		<div class="project-info">
	        			<a href="#" class="project-name">
	        				Розіграш до колекції VOLIA
        				</a>
	        			<div class="project-text">
	        				У межах виходу колекції VOLIA ми провели особливий розіграш, який поєднав мистецтво, моду та доброту. Розігрувалась унікальна картина художника Михайла Коробкова, створена спеціально для цієї колекції.
	        			</div>
	        			<div class="project-btn">
	        				<a href="#" class="info-btn">
	        					Детальніше
	        					<span class="icon">
	        						<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g >
										<path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
										</g>
									</svg>
	        					</span>
	        				</a>
	        			</div>
	        		</div>
	        		<div class="project-img">
	        			<a href="#">
	        				<img src="/bitrix/templates/stimma_new/images/imgnew/progectimg1.png">
	        			</a>
	        		</div>
        		</div>
        	</div>
        	<div class="project-block">
        		<div class="project-wrapper">
	        		<div class="project-info">
	        			<a href="#" class="project-name">
	        				Благодійна ініціатива від Tabletochki та Stimma
	        			</a>
	        			<div class="project-text">
	        				Ми створили унікальні шпарпетки, щоб нагадати про можливість підтримки. Кожна пара шкарпеток- допомога найменшим.
	        			</div>
	        			<div class="project-btn">
	        				<a href="#" class="info-btn">
	        					Детальніше
	        					<span class="icon">
	        						<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g >
										<path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
										</g>
									</svg>
	        					</span>
	        				</a>
	        			</div>
	        		</div>
	        		<div class="project-img">
	        			<a href="#">
	        				<img src="/bitrix/templates/stimma_new/images/imgnew/progectimg2.png">
	        			</a>
	        		</div>
        		</div>
        	</div>
        	<div class="project-block">
        		<div class="project-wrapper">
	        		<div class="project-info">
	        			<a href="#" class="project-name">
	        				Незалежні 33: Маніфест STIMMA
	        			</a>
	        			<div class="project-text">
	        				З нагоди 33-ї річниці Незалежності України бренд одягу STIMMA презентує проєкт “Незалежні 33”, присвячений силі та впевненості українських жінок.
	        			</div>
	        			<div class="project-btn">
	        				<a href="#" class="info-btn">
	        					Детальніше
	        					<span class="icon">
	        						<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g >
										<path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
										</g>
									</svg>
	        					</span>
	        				</a>
	        			</div>
	        		</div>
	        		<div class="project-img">
	        			<a href="#">
	        				<img src="/bitrix/templates/stimma_new/images/imgnew/progectimg3.png">
	        			</a>
	        		</div>
        		</div>
        	</div>
        </div>
        */?>

    <?
}
else
{
    $APPLICATION->IncludeComponent(
        "bitrix:news",
        "projects",
        array(
            "IBLOCK_TYPE" => "aspro_max_content",
            "IBLOCK_ID" => "26",
            "NEWS_COUNT" => "20",
            "USE_SEARCH" => "N",
            "USE_RSS" => "N",
            "USE_RATING" => "N",
            "USE_CATEGORIES" => "N",
            "USE_FILTER" => "Y",
            "FILTER_NAME" => "arProjectFilter",
            "SORT_BY1" => "SORT",
            "SORT_ORDER1" => "ASC",
            "SORT_BY2" => "ID",
            "SORT_ORDER2" => "DESC",
            "CHECK_DATES" => "Y",
            "SEF_MODE" => "Y",
            "SEF_FOLDER" => "/projects/",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "100000",
            "CACHE_FILTER" => "Y",
            "CACHE_GROUPS" => "N",
            "SET_TITLE" => "Y",
            "SET_STATUS_404" => "Y",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "Y",
            "USE_PERMISSIONS" => "N",
            "PREVIEW_TRUNCATE_LEN" => "",
            "LIST_ACTIVE_DATE_FORMAT" => "j F Y",
            "LIST_FIELD_CODE" => array(
                0 => "NAME",
                1 => "PREVIEW_TEXT",
                2 => "PREVIEW_PICTURE",
                3 => "",
            ),
            "LIST_PROPERTY_CODE" => array(
                0 => "",
                1 => "",
            ),
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "DISPLAY_NAME" => "N",
            "META_KEYWORDS" => "-",
            "META_DESCRIPTION" => "-",
            "BROWSER_TITLE" => "-",
            "DETAIL_ACTIVE_DATE_FORMAT" => "j F Y",
            "DETAIL_FIELD_CODE" => array(
                0 => "NAME",
                1 => "PREVIEW_TEXT",
                2 => "DETAIL_TEXT",
                3 => "DETAIL_PICTURE",
                4 => "",
            ),
            "DETAIL_PROPERTY_CODE" => array(
                0 => "FORM_ORDER",
                1 => "FORM_QUESTION",
                2 => "ORDERER",
                3 => "SITE",
                4 => "DATA",
                5 => "AUTHOR",
                6 => "LINK_BRANDS",
                7 => "LINK_VACANCY",
                8 => "TASK_PROJECT",
                9 => "LINK_LANDINGS",
                10 => "LINK_NEWS",
                11 => "LINK_REVIEWS",
                12 => "LINK_PARTNERS",
                13 => "LINK_PROJECTS",
                14 => "LINK_STAFF",
                15 => "LINK_BLOG",
                16 => "LINK_TIZERS",
                17 => "LINK_GOODS",
                18 => "LINK_SERVICES",
                19 => "LINK_TEAM",
                20 => "LINK_COMPANY",
                21 => "FORM_PROJECT",
                22 => "DOCUMENTS",
                23 => "PHOTOS",
                24 => "GALLEY_BIG",
                25 => "",
            ),
            "DETAIL_DISPLAY_TOP_PAGER" => "N",
            "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
            "DETAIL_PAGER_TITLE" => "Страница",
            "DETAIL_PAGER_TEMPLATE" => "",
            "DETAIL_PAGER_SHOW_ALL" => "Y",
            "PAGER_TEMPLATE" => ".default",
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
            "ADD_ELEMENT_CHAIN" => "Y",
            "SHOW_DETAIL_LINK" => "Y",
            "S_ASK_QUESTION" => "",
            "S_ORDER_PROJECT" => "Заказать проект",
            "T_GALLERY" => "",
            "T_DOCS" => "",
            "T_PROJECTS" => "Похожие проекты",
            "T_CHARACTERISTICS" => "",
            "COMPONENT_TEMPLATE" => "projects",
            "SET_LAST_MODIFIED" => "N",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "DETAIL_SET_CANONICAL_URL" => "N",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "SHOW_404" => "Y",
            "MESSAGE_404" => "",
            "FORM_ID" => "",
            "GALLERY_TYPE" => "big",
            "T_GOODS" => "Товары",
            "T_SERVICES" => "",
            "T_REVIEWS" => "Отзыв клиента",
            "SECTION_ELEMENTS_TYPE_VIEW" => "FROM_MODULE",
            "ELEMENT_TYPE_VIEW" => "element_1",
            "LINE_ELEMENT_COUNT" => "3",
            "LINE_ELEMENT_COUNT_LIST" => "3",
            "SHOW_SECTION_PREVIEW_DESCRIPTION" => "Y",
            "SHOW_SECTION_DESCRIPTION" => "Y",
            "S_ORDER_SERVISE" => "Заказать проект",
            "SHOW_MAX_ELEMENT" => "N",
            "T_MAX_LINK" => "",
            "T_PREV_LINK" => "",
            "FORM_ID_ORDER_SERVISE" => "6",
            "IMAGE_WIDE" => "Y",
            "DETAIL_STRICT_SECTION_CHECK" => "N",
            "FILTER_FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "FILTER_PROPERTY_CODE" => array(
                0 => "",
                1 => "",
            ),
            "DETAIL_BRAND_USE" => "Y",
            "DETAIL_BRAND_PROP_CODE" => array(
                0 => "TIZERS",
                1 => "",
            ),
            "T_CLIENTS" => "",
            "STRICT_SECTION_CHECK" => "N",
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
            "FILE_404" => "",
            "SHOW_FILTER_DATE" => "Y",
            "SHOW_ASK_BLOCK" => "N",
            "SHOW_BORDER_ELEMENT" => "Y",
            "USE_BG_IMAGE_ALTERNATE" => "Y",
            "BG_POSITION" => "center",
            "TYPE_IMG" => "lg",
            "SIZE_IN_ROW" => "4",
            "TITLE_SHOW_FON" => "N",
            "SIDE_LEFT_BLOCK" => "FROM_MODULE",
            "TYPE_LEFT_BLOCK" => "FROM_MODULE",
            "ALL_BLOCK_BG" => "Y",
            "TYPE_HEAD_BLOCK" => "FROM_MODULE",
            "SIDE_LEFT_BLOCK_DETAIL" => "RIGHT",
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
            "IBLOCK_LINK_LANDINGS_ID" => "",
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
            "DETAIL_BLOCKS_ALL_ORDER" => "tizers,desc,char,docs,services,goods,reviews,news,vacancy,blog,form_order,projects,staff,brands,gallery,landings,partners,comments",
            "DETAIL_USE_COMMENTS" => "N",
            "DETAIL_BLOG_USE" => "N",
            "DETAIL_VK_USE" => "N",
            "DETAIL_FB_USE" => "N",
            "IBLOCK_LINK_PARTNERS_ID" => "",
            "BLOCK_PARTNERS_NAME" => "Партнеры",
            "DETAIL_LINKED_GOODS_SLIDER" => "Y",
            "SHOW_TOP_PROJECT_BLOCK" => "Y",
            "TOP_GALLERY_PROPERTY_CODE" => "PHOTOS",
            "ADDITIONAL_GALLERY_PROPERTY_CODE" => "GALLEY_BIG",
            "MAIN_GALLERY_PROPERTY_CODE" => "GALLEY_BIG",
            "DETAIL_BLOG_URL" => "catalog_comments",
            "COMMENTS_COUNT" => "5",
            "BLOG_TITLE" => "Комментарии",
            "DETAIL_BLOG_EMAIL_NOTIFY" => "N",
            "SEF_URL_TEMPLATES" => array(
                "news" => "",
                "section" => "#SECTION_CODE_PATH#/",
                "detail" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
            )
        ),
        false
    );
}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>