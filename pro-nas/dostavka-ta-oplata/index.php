<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle(LANGUAGE_ID == 'ua' ? "ОПЛАТА ТА ДОСТАВКА" : "ОПЛАТА И ДОСТАВКА");
$APPLICATION->SetPageProperty("description", LANGUAGE_ID == 'ua' ? "Модний жіночий одяг від українського виробника ТМ STIMMA. ОПЛАТА ТА ДОСТАВКА" : "Модная женская одежда от украинского производителя ТМ STIMMA. ОПЛАТА И ДОСТАВКА");
$APPLICATION->SetPageProperty("title", LANGUAGE_ID == 'ua' ? "ОПЛАТА ТА ДОСТАВКА | Інтернет-магазин STIMMA" : "ОПЛАТА И ДОСТАВКА | Интернет-магазин STIMMA");

?>

<?if(isset($_GET['newstimma']) || NEW_STIMMA)
{
    $ru=LANGUAGE_ID=='ru'?'/ru':'';
    ?>


	<div class="breadcrumbs-cont">
    	<div class="wrapper">
    		<div class="breadcrumbs-block">
    			<a href="<?=$ru?>" class="breadcrumb-item">
    				STIMMA
    			</a>
    			<span class="breadcrumb-sep">
    				<svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
					</svg>
    			</span>
    			<span class="breadcrumb-item">
    				<? if (LANGUAGE_ID == 'ua'): ?>
    					Доставка та оплата
    				<? else: ?>
    					Доставка и оплата
    				<? endif; ?>
    			</span>
    		</div>
    	</div>
    </div>

    <div class="info-page-content">
    	<h1 class="info-page-title">
    		<? if (LANGUAGE_ID == 'ua'): ?>
    			Доставка та оплата
    		<? else: ?>
    			Доставка и оплата
    		<? endif; ?>
    	</h1>
    	<div class="delivery-info-cont">
            <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                            "AREA_FILE_RECURSIVE" => "N",
                            "AREA_FILE_SHOW" => "file",
                            "EDIT_MODE" => "html",
                            "PATH" => "oplata.php"
                    ),
                    false,
                    Array(
                            'HIDE_ICONS' => 'N'
                    )
            );?>

    	</div>
    </div>

<?} else {?>

	<? if(isset($_GET['new']) || true)
	    {
	        ?>
	        <div class="info-page info-page-little">
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
							<article id="post-110700" class="post-110700 page type-page status-publish hentry del-and-pay">
							<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				Array(
					"AREA_FILE_RECURSIVE" => "N",
					"AREA_FILE_SHOW" => "file",
					"EDIT_MODE" => "html",
					"PATH" => "oplata.php"
				),
			false,
			Array(
				'HIDE_ICONS' => 'N'
			)
			);?> </article>
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
					"PATH" => "oplata.php"
				),
			false,
			Array(
				'HIDE_ICONS' => 'N'
			)
			);?>
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
					<article id="post-110700" class="post-110700 page type-page status-publish hentry">
					<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_RECURSIVE" => "N",
			"AREA_FILE_SHOW" => "file",
			"EDIT_MODE" => "html",
			"PATH" => "oplata.php"
		),
	false,
	Array(
		'HIDE_ICONS' => 'N'
	)
	);?> </article>
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
			"PATH" => "oplata.php"
		),
	false,
	Array(
		'HIDE_ICONS' => 'N'
	)
	);?>
			</div>
		</div>
	    <?}
	?>

<?	
}?>






</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>