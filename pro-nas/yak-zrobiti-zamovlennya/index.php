<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Як зробити замовлення в інтернет магазині модного одягу STIMMA.COM.UA? Замовлення в нашому інтернет-магазині можна оформити: &#8211; замовлення приймаються в онлайні, через корзину сайту. Для цього Вам потрібно додати в кошик товар, який сподобався, переглянувши кошик перейти до оплати, де ви зможете заповнити форму з реквізитами про покупця, вибрати спосіб оплати і доставки. Якщо ви не [&hellip;]");
$APPLICATION->SetPageProperty("title", "Як зробити замовлення? &ndash; STIMMA");
$APPLICATION->SetTitle("ЯК ЗРОБИТИ ЗАМОВЛЕННЯ?");
?>

<? if(isset($_GET['new']))
    {
        ?>
        <div class="info-page">
	<div class="info-page-tabs">
		 <?/*$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "page_info_menu",
                array(
                    "COMPONENT_TEMPLATE" => "page_info_menu",
                    "ROOT_MENU_TYPE" => "info_menu",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "",
                    "USE_EXT" => "N",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                ),
                false
            );*/?>
		<div class="tab-content" style="max-width: inherit">
			<div class="tab-pane fade active in" id="stab1-b">
				<div class="page-inner">
 <article id="post-110698" class="post-110698 page type-page status-publish hentry info-page-small-cont del-and-pay">
					<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_RECURSIVE" => "N",
		"AREA_FILE_SHOW" => "file",
		"EDIT_MODE" => "html",
		"PATH" => "zam.php"
	),
false,
Array(
	'HIDE_ICONS' => 'N'
)
);?> </article>
				</div>
			</div>
		</div>
	</div>
	<div class="card-main-tabs-mobile">
		<div class="card-tabs-mobile-item info-page-small-cont del-and-pay">
			 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_RECURSIVE" => "N",
		"AREA_FILE_SHOW" => "file",
		"EDIT_MODE" => "html",
		"PATH" => "zam.php"
	),
false,
Array(
	'HIDE_ICONS' => 'N'
)
);?>
		</div>
	</div>
</div>
    <?
    }
    else{?>
        <div class="info-page">
	<div class="info-page-tabs">
		 <?/*$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "page_info_menu",
                array(
                    "COMPONENT_TEMPLATE" => "page_info_menu",
                    "ROOT_MENU_TYPE" => "info_menu",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "",
                    "USE_EXT" => "N",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                ),
                false
            );*/?>
		<div class="tab-content" style="max-width: inherit">
			<div class="tab-pane fade active in" id="stab1-b">
				<div class="page-inner">
 <article id="post-110698" class="post-110698 page type-page status-publish hentry">
					<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_RECURSIVE" => "N",
		"AREA_FILE_SHOW" => "file",
		"EDIT_MODE" => "html",
		"PATH" => "zam.php"
	),
false,
Array(
	'HIDE_ICONS' => 'N'
)
);?> </article>
				</div>
			</div>
		</div>
	</div>
	<div class="card-main-tabs-mobile">
		<div class="card-tabs-mobile-item">
			 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_RECURSIVE" => "N",
		"AREA_FILE_SHOW" => "file",
		"EDIT_MODE" => "html",
		"PATH" => "zam.php"
	),
false,
Array(
	'HIDE_ICONS' => 'N'
)
);?>
		</div>
	</div>
</div>
    <?}
?>




<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>