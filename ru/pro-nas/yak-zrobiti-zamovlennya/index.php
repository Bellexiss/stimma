<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Как оформить заказ в интернет магазине модной одежды STIMMA.COM.UA? Заказы в нашем интернет-магазине можно оформить: &#8212; заказы принимаются онлайн, через корзину сайта. Для этого Вам нужно добавить в корзину понравившийся товар, просмотрев корзину перейти к оплате, где вы сможете заполнить форму с реквизитами о покупателе, выбрать способ оплаты и доставки. Если вы не знаете как [&hellip;]");
$APPLICATION->SetPageProperty("title", "Купить оптом одежду, интернет магазин Украина, Хмельницкий.");
$APPLICATION->SetTitle("КАК ОФОРМИТЬ ЗАКАЗ?");
?><div class="info-page">
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
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>