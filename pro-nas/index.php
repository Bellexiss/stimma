<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Може здатися, що ти зовсім нічого не знаєш про те, хто така Stimma. Але насправді її багато що поєднує із тобою. Вона, як і ти, любить бути стильною та особливою. Бути тією, яка розповідає про себе мовою одягу. Вже понад 10 років, Stimma вивчає світові тренди та адаптує їх під твій смак. Вона та, хто [&hellip;]");
$APPLICATION->SetPageProperty("title", "Про нас &ndash; STIMMA");
$APPLICATION->SetTitle("ПРО НАС");


if(isset($_GET['newstimma']) || NEW_STIMMA)
{?>
    <div class="info-page-banner pro-nas">
	<div class="breadcrumbs-cont">
		<div class="wrapper">
			<div class="breadcrumbs-block">
 <a href="#" class="breadcrumb-item">
				STIMMA </a> <span class="breadcrumb-sep"> </span> <span class="breadcrumb-item">
				Про нас </span>
			</div>
		</div>
	</div>
	<div class="info-page-banner-content">
		<div class="info-page-banner-img">
 <img src="/bitrix/templates/stimma_new/images/imgnew/infopbanner.jpg">
		</div>
		<div class="info-page-banner-title-block">
			<div class="info-page-banner-title">
				 STIMMA
			</div>
			<h1 class="info-page-banner-semititle">
				 український бренд одягу для жінок та про жінок
			</h1>
		</div>
	</div>
</div>
<div class="info-page-content">
	<div class="img-group-block">
		<div class="img-group-img">
 <img src="/bitrix/templates/stimma_new/images/imgnew/aboutus-img.png">
		</div>
		<div class="img-group-text">
			<p>
				 Про любов багато говорять. Ми в Stimma прагнемо, щоб її можна було вдягнути. Щоб жінки відчували до себе небайдужість. Йшли впевненою ходою — не важливо, яка погода і який настрій.
			</p>
			<p>
 <b> З 2010 року</b> ми розвиваємо бренд: спочатку сімейною парою, а далі — великою сім’єю Stimma.
			</p>
			<p>
				 Нам цікаві жінки: про що вони мріють, про що мріяти бояться. Хто надихає на щоденні образи, про кого пліткують. Ми любимо, коли вони наряджаються, особливо, щоб вийти за смаколиками біля дому. Любимо, коли шукають привід, щоб вигуляти свою обновку. Та любимо, як вони виражають себе через одяг, з кожним разом — все впевненіше.
			</p>
			<p>
				 Знаємо, як це — стояти перед шафою, коли все не те. Мати 20 хвилин на збори і 30 питань на місяць “що ж вдягнути сьогодні?”.
			</p>
			<p>
				 Дбаємо, щоб наші речі уживалися в гардеробі без зайвих питань. Щоб не виходили з моди і в них можна було вийти в люди і через рік.
			</p>
			<p>
				 Мріємо влучати у бажання наших дівчат якомога частіше.
			</p>
			<p>
				 Думаємо, що їм носити у відпустці, до подруги на весілля чи на зустріч з подругами.
			</p>
			<p>
 <b>Нам не потрібно займати зайве місце у шафах, але дуже хочемо мати місце у ваших серцях.</b>
			</p>
		</div>
	</div>
	<div class="about-us-text">
		<p>
			 Адаптуючи модні тренди до реального життя, наша команда створює сучасний міський гардероб, доступний жінкам з усіх міст України, незалежно від рівня доходів, типу фігури та поглядів на життя.
		</p>
		<p>
			 Колекції STIMMA завжди присвячені жіночій силі, характеру та винахідливості. Створюючи для українських жінок простір для експериментів, для нас залишається важливим, аби усі речі поєднувалися між собою та формувалися у капсули для різних випадків життя, а кожен новий дроп був логічним продовженням попереднього.
		</p>
		<p>
			 Маючи мережу магазинів по Україні та регулярно оновлюючи колекції, ми робимо ставку на позачасові силуети, невимушену кольорову гаму та любов до деталей.
		</p>
	</div>
</div>
 <?}else{

    if(isset($_GET['new']) || true)
    {
        ?> <style type="text/css">

            .info-page-small-cont{
                max-width: 600px;
                margin: 0 auto;
                padding: 0 10px;
            }
        </style>
<div class="info-page">
	<div class="info-page-big-img">
 <img src="/upload/iblock/754/qwz3lsi2lcsch21fg2lsy2mqard0bj1n.jpg">
	</div>
	<div class="info-page-small-cont">
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
					 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_RECURSIVE" => "N",
		"AREA_FILE_SHOW" => "file",
		"EDIT_MODE" => "html",
		"PATH" => "pro-nas.php"
	),
false,
Array(
	'HIDE_ICONS' => 'N'
)
);?>
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
		"PATH" => "pro-nas.php"
	),
false,
Array(
	'HIDE_ICONS' => 'N'
)
);?>
			</div>
		</div>
	</div>
</div>
 <?
    }
    else
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
				 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_RECURSIVE" => "N",
		"AREA_FILE_SHOW" => "file",
		"EDIT_MODE" => "html",
		"PATH" => "pro-nas.php"
	),
false,
Array(
	'HIDE_ICONS' => 'N'
)
);?>
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
		"PATH" => "pro-nas.php"
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
    

}?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>