<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Модний жіночий одяг від українського виробника ТМ STIMMA. Гарантія та повернення");
$APPLICATION->SetPageProperty("title", "Гарантія та повернення | Інтернет-магазин STIMMA");
$APPLICATION->SetTitle("Гарантія та повернення");
?><?if(isset($_GET['newstimma']) || NEW_STIMMA)
{?>
<div class="breadcrumbs-cont">
	<div class="wrapper">
		<div class="breadcrumbs-block">
 <a href="#" class="breadcrumb-item">
			STIMMA </a> <span class="breadcrumb-sep"> </span> <span class="breadcrumb-item">
			Гарантія та повернення </span>
		</div>
	</div>
</div>
<div class="info-page-content">
	<h1 class="info-page-title">Обмін та повернення</h1>
	<div class="info-page-group">
		<div>
			<p>
				 Якщо річ вам не підійшла, її можна обміняти або повернути <b>протягом 14 календарних днів</b> з моменту отримання замовлення відповідно до чинного законодавства України.
			</p>
		</div>
	</div>
	<hr>
	<div class="info-page-group">
		<h5>Важливо знати!</h5>
		<div>
			<ul>
				<li>Oбмін тa пoвepнeння тoвapу здійcнюютьcя виключнo в тoму міcці (інтepнeт-мaгaзині aбo тopгoвій тoчці), дe булo здійcнeнo пoкупку.</li>
				<li>У разі невідповідності умовам повернення (відсутні бірки, є сліди носіння, минув термін 14 днів) ми залишаємо за собою право відмовити у поверненні. У такому випадку товар буде відправлений назад покупцю.</li>
				<li>Не підлягають обміну та поверненню: спідня білизна, купальники, боді, шкарпетки (відповідно до законодавства України).</li>
			</ul>
		</div>
	</div>
	<hr>
	<div class="info-page-group">
		<div>
			<h5><b>Для роздрібних покупців</b></h5>
 <b><br>
 </b> <b>Умови обміну та повернення</b><br>
 <b><br>
 </b> <b>Ми приймаємо товар за таких умов:<br>
 </b>
			<ul>
				<li>з моменту покупки минуло не більше 14 днів;</li>
				<li>заповнено бланк обміну/повернення;</li>
				<li>збережені бірки та оригінальне пакування;&nbsp;</li>
				<li>відсутні сліди використання (прання, запах парфумів, косметики тощо);</li>
				<li>збережений товарний вигляд виробу.</li>
			</ul>
			<p>
 <b>Повернення коштів</b>
			</p>
			<p>
				 Після отримання та перевірки товару кошти повертаються:
			</p>
			<ul>
				<li>на рахунок, зазначений у бланку, або</li>
				<li>на карту, з якої була здійснена оплата;</li>
				<li>залишаються на балансі покупця для оплати наступного замовлення.</li>
			</ul>
			<p>
				 &nbsp;Термін повернення коштів - протягом 3 робочих днів.
			</p>
		</div>
	</div>
	<hr>
	<div class="info-page-group">
		<div>
			<p>
 <b>Доставка при поверненні/обміну</b>
			</p>
			<ul>
				<li>У разі виробничого дефекту витрати на доставку покриває компанія.</li>
				<li>Якщо обмін або повернення відбувається з особистих причин (не підійшов: розмір, колір, модель) - витрати на доставку сплачує покупець.</li>
			</ul>
			<p>
 <b><i>Повернення здійснюється перевізником «Нова Пошта». Деталі оформлення повідомляє менеджер.</i></b>
			</p>
		</div>
	</div>
	<hr>
	<div class="info-page-group">
		<h5>Для оптових покупців</h5>
		<div>
			<p>
				 Обмін або повернення можливі лише у випадку виявлення виробничого дефекту.
			</p>
			<p>
 <b>Умови:</b>
			</p>
			<ul>
				<li>звернення протягом 14 днів з моменту отримання товару;</li>
				<li>збережене оригінальне пакування та бірки;</li>
				<li>відсутність слідів використання;</li>
				<li>збережений товарний вигляд.</li>
			</ul>
 <b>Повернення коштів<br>
 </b><br>
			 Після отримання та перевірки товару кошти:<br>
			<ul>
				<li>повертаються протягом 3 робочих днів, або</li>
				<li>залишаються на балансі покупця для оплати наступного замовлення.</li>
			</ul>
		</div>
	</div>
</div>
 <?}else{?> <? if(isset($_GET['new']) || true)
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
				<div class="large-9 desktop-padding-left-30 right columns">
					<div class="page-inner">
 <article id="post-110697" class="post-110697 page type-page status-publish hentry del-and-pay">
						<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_RECURSIVE" => "N",
		"AREA_FILE_SHOW" => "file",
		"EDIT_MODE" => "html",
		"PATH" => "garanti_new.php"
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
	</div>
	<div class="card-main-tabs-mobile">
		<div class="card-tabs-mobile-item del-and-pay">
			 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_RECURSIVE" => "N",
		"AREA_FILE_SHOW" => "file",
		"EDIT_MODE" => "html",
		"PATH" => "garanti_new.php"
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
				<div id="content" class="large-9 desktop-padding-left-30 right columns">
					<div class="page-inner">
 <article id="post-110697" class="post-110697 page type-page status-publish hentry">
						<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_RECURSIVE" => "N",
		"AREA_FILE_SHOW" => "file",
		"EDIT_MODE" => "html",
		"PATH" => "garanti.php"
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
		"PATH" => "garanti_new.php"
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
<?}?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>