<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О нас пишут");
?>

<?
if($APPLICATION->GetCurPage() == '/ru/news/')
{
    $APPLICATION->IncludeComponent(
        "bitrix:news",
        "blog_new",
        array(
            "IBLOCK_TYPE" => "aspro_max_content",
            "IBLOCK_ID" => "23",
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
            "SEF_FOLDER" => "/news/",
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
                0 => "",
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
            "ADD_ELEMENT_CHAIN" => "Y",
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
                "detail" => "/news/#ELEMENT_CODE#/",
                "rss" => "rss/",
                "rss_section" => "#SECTION_ID#/rss/",
            )
        ),
        false
    );

    $APPLICATION->SetPageProperty('title','О нас пишут');
}
else
{
    preg_match('/\/news\/(.*)\//', $APPLICATION->GetCurPage(), $matches);

    if($matches[1])
    {
        $news = CIBlockElement::GetList([],['CODE'=>$matches[1],'IBLOCK_ID'=>23,'ACTIVE'=>'Y']);
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

            $APPLICATION->SetPageProperty('title',$fields['NAME'].' - Новости Stimma');
            //$APPLICATION->SetPageProperty('description',strip_tags($fields['PREVIEW_TEXT']));
            $APPLICATION->SetPageProperty('description',$fields['NAME'].' - Новости Интернет магазина одежды от производителя Stimma');

            if(empty(trim($fields['DETAIL_TEXT'])))
            {
                $APPLICATION->AddHeadString('<meta name="robots" content="noindex,nofollow" />');
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