<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$page = $APPLICATION -> GetCurPage();
$selected = [];

if(isset($_GET['die']))
{
    $APPLICATION->RestartBuffer();
    ?><pre><?=print_r($arResult,1)?></pre><?
    die();
}

$templateData = array(
	//'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME']))
{
	$this->addExternalCss($templateData['TEMPLATE_THEME']);
}
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");
//$this->addExternalCss("/bitrix/css/main/font-awesome.css");

?>
<?/*
<div class="catalog-filters">
    <div class="catalog-filters-top">
        <div class="catalog-filter-cont catalog-filter-cont-opener">
            <div class="catalog-filter-block">
                <div class="catalog-filter-name">
                    <span>фільтр</span>
                    <span class="icon">
						<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
	 				</span>
                </div>
            </div>
        </div>
        <div class="catalog-filters-type">
            <div class="catalog-filter-cont">
                <div class="catalog-filter-block">
                    <div class="catalog-filter-name">
                        <span>Тип</span>
                        <span class="icon">
							<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
		 				</span>
                    </div>
                    <div class="catalog-filter-dropdown">
                        <ul class="catalog-filter-type">
                            <li>
                                <label>
                                    <input type="checkbox" name="">
                                    <span class="icon"></span>легінси
                                </label>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>джинси
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>джогери
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>бріджі
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>шорти
                                </a>
                            </li>
                            <li>
                                <a href="#" class="active">
                                    <span class="icon"></span>брюки
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>легінси
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>джинси
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>джогери
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>бріджі
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>шорти
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>легінси
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>джинси
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="catalog-filter-cont">
                <div class="catalog-filter-block">
                    <div class="catalog-filter-name">
                        <span>Розмір</span>
                        <span class="icon"></span>
                        <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </span>
                    </div>
                    <div class="catalog-filter-dropdown">
                        <ul class="catalog-filter-type">
                            <li>
                                <a href="#">
                                    <span class="icon"></span>xs
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>s
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>m
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>l
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>xl
                                </a>
                            </li>
                            <li>
                                <a href="#" class="active">
                                    <span class="icon"></span>xxl
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>xxxl
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="catalog-filter-cont">
                <div class="catalog-filter-block">
                    <div class="catalog-filter-name">
                        <span>Колір</span>
                        <span class="icon"></span>
                        <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </span>
                    </div>
                    <div class="catalog-filter-dropdown">
                        <ul class="catalog-filter-type filter-color">
                            <li>
                                <a href="#">
                                    <span class="icon" style="box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.35); background:#ffffff"></span>білий
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#000000"></span>чорний
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#FFE974"></span>жовтий
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#1F4CED"></span>синій
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#39A430;"></span>зелений
                                </a>
                            </li>
                            <li>
                                <a href="#" class="active">
                                    <span class="icon" style="background:#E31111"></span>червоний
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#915D40"></span>коричневий
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#E8D4AD"></span>беж
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#AAAAAA"></span>сірий
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#5F6940"></span>хакі
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#63B4FF"></span>блакитний
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#E31111"></span>червоний
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon" style="background:#915D40"></span>коричневий
                                </a>
                            </li>
                        </ul>
                        <ul class="catalog-filter-type filter-color" style="display:none;">
                            <li>
                                <a href="#">
									<span class="icon">
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>білий
                                </a>
                            </li>
                            <li>
                                <a href="#">
									<span class="icon" >
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>чорний
                                </a>
                            </li>
                            <li>
                                <a href="#">
									<span class="icon">
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>жовтий
                                </a>
                            </li>
                            <li>
                                <a href="#">
									<span class="icon">
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>синій
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"">
                                    <img src="/bitrix/templates/aspro_max/images/colorimg.png">
                                    </span>зелений
                                </a>
                            </li>
                            <li>
                                <a href="#" class="active">
									<span class="icon">
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>червоний
                                </a>
                            </li>
                            <li>
                                <a href="#">
									<span class="icon">
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>коричневий
                                </a>
                            </li>
                            <li>
                                <a href="#">
									<span class="icon">
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>беж
                                </a>
                            </li>
                            <li>
                                <a href="#">
									<span class="icon">
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>сірий
                                </a>
                            </li>
                            <li>
                                <a href="#">
									<span class="icon">
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>хакі
                                </a>
                            </li>
                            <li>
                                <a href="#">
									<span class="icon" >
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>блакитний
                                </a>
                            </li>
                            <li>
                                <a href="#">
									<span class="icon" >
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>червоний
                                </a>
                            </li>
                            <li>
                                <a href="#">
									<span class="icon">
										<img src="/bitrix/templates/aspro_max/images/colorimg.png">
									</span>коричневий
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="catalog-filter-cont">
                <div class="catalog-filter-block">
                    <div class="catalog-filter-name">
                        <span>Матеріал</span>
                        <span class="icon"></span>
                        <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </span>
                    </div>
                    <div class="catalog-filter-dropdown">
                        <ul class="catalog-filter-type">
                            <li>
                                <a href="#">
                                    <span class="icon"></span>шовк
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>льон
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>шкіра
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>еко-шкіра
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>трикотаж
                                </a>
                            </li>
                            <li>
                                <a href="#" class="active">
                                    <span class="icon"></span>мереживо
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>жатка
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>шерсть
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>вельвет
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>джинс
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>сатин
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>жатка
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon"></span>трикотаж
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="catalog-filter-cont">
                <div class="catalog-filter-block">
                    <div class="catalog-filter-name">
                        <span>Ціна</span>
                        <span class="icon"></span>
                        <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </span>
                    </div>
                    <div class="catalog-filter-dropdown">

                    </div>
                </div>
            </div>
        </div>
        <div class="catalog-filter-cont">
            <div class="catalog-filter-block">
                <div class="catalog-filter-name">
                    <span>сортувати</span>
                    <span class="icon">
						<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
	 				</span>
                </div>
                <div class="catalog-filter-dropdown">
                    <a href="#">За новизною</a>
                    <a href="#">За популярністю</a>
                    <a href="#">Максимальна знижка</a>
                    <a href="#">Від дешевих до дорогих</a>
                    <a href="#">Від дорогих до дешевих</a>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-selected-list">
        <div class="filter-selected-item">
            <div class="filter-selected-item-name">спортивний костюм</div>
            <a href="#" class="filter-selected-item-delete">
                <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                </svg>
            </a>
        </div>
        <div class="filter-selected-item">
            <div class="filter-selected-item-name">світшот</div>
            <a href="#" class="filter-selected-item-delete">
                <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                </svg>
            </a>
        </div>
        <div class="filter-selected-item">
            <div class="filter-selected-item-name">чорний</div>
            <a href="#" class="filter-selected-item-delete">
                <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                </svg>
            </a>
        </div>
        <div class="filter-selected-item">
            <div class="filter-selected-item-name">котон</div>
            <a href="#" class="filter-selected-item-delete">
                <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                </svg>
            </a>
        </div>
        <div class="filter-selected-item">
            <div class="filter-selected-item-name">очистити фільтри</div>
            <a href="#" class="filter-selected-item-delete">
                <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
*/?>
<div class="catalog-filter-new-cont">
    <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="offcanvas offcanvas-end filter-canvas" tabindex="-1" id="filter-canvas">
        <div class="offcanvas-header">
            <div class="filter-title-cont">
                <div class="filter-title-block">
                    <div class="filter-title">
                        <?=LANGUAGE_ID == 'ua' ? 'Фільтр та сортування' : 'Фильтр и сортировка'?>
                    </div>
                    <div class="filter-count fff_countr">
                        0 <?=LANGUAGE_ID == 'ua' ? 'товарів' : 'товаров'?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.4365 12.0225L25.4561 0.00292969L26.8701 1.41699L14.8506 13.4365L26.8701 25.4561L25.4561 26.8701L13.4365 14.8506L1.41406 26.873L0 25.459L12.0225 13.4365L0 1.41406L1.41406 0L13.4365 12.0225Z" fill="currentcolor"/>
                    </svg>
                </button>
            </div>
            <?//if(isset($_GET['activefilter']))
            {?>
            <div class="filter-active-cont">

                <?$APPLICATION->ShowViewContent('selected_filter');?>
                <?/*
                <?
                $APPLICATION->AddViewContent(
                    'selected_filter',
                    '<div>Контент снизу</div>'
                );
                ?>
                <div class="filter-active-list">
                    <div class="filter-active-elem">
                        <button class="filter-active-remove">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.5022 8.79148C2.30695 8.98678 2.30698 9.30333 2.50226 9.49858C2.69754 9.69383 3.01412 9.69383 3.20936 9.49853L6.00198 6.70543L8.79483 9.49828C8.99008 9.69353 9.30668 9.69353 9.50193 9.49828C9.69718 9.30303 9.69718 8.98643 9.50193 8.79118L6.70903 5.99828L9.50173 3.20509C9.69693 3.00981 9.69693 2.69323 9.50163 2.49798C9.30638 2.30273 8.98978 2.30276 8.79453 2.49804L6.00188 5.29118L3.20902 2.49828C3.01376 2.30302 2.69718 2.30302 2.50192 2.49828C2.30665 2.69355 2.30665 3.01013 2.50192 3.20539L5.29488 5.99833L2.5022 8.79148Z" fill="currentcolor"/>
                            </svg>
                        </button>
                        <span class="text">
                            Блакитний
                        </span>
                    </div>
                    <div class="filter-active-elem">
                        <button class="filter-active-remove">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.5022 8.79148C2.30695 8.98678 2.30698 9.30333 2.50226 9.49858C2.69754 9.69383 3.01412 9.69383 3.20936 9.49853L6.00198 6.70543L8.79483 9.49828C8.99008 9.69353 9.30668 9.69353 9.50193 9.49828C9.69718 9.30303 9.69718 8.98643 9.50193 8.79118L6.70903 5.99828L9.50173 3.20509C9.69693 3.00981 9.69693 2.69323 9.50163 2.49798C9.30638 2.30273 8.98978 2.30276 8.79453 2.49804L6.00188 5.29118L3.20902 2.49828C3.01376 2.30302 2.69718 2.30302 2.50192 2.49828C2.30665 2.69355 2.30665 3.01013 2.50192 3.20539L5.29488 5.99833L2.5022 8.79148Z" fill="currentcolor"/>
                            </svg>
                        </button>
                        <span class="text">
                            Взуття
                        </span>
                    </div>
                </div>
                */?>
            </div>
            <?}?>
        </div>
        <div class="offcanvas-body">
            <div class="accordion" id="filter-list">
                <?foreach($arResult["HIDDEN"] as $arItem):?>
                    <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
                <?endforeach;?>
                <?$kNumber=1;?>


                <?
                //if(isset($_GET['showme']))
                {
                    ?>
                    <div class="accordion-item" data-code="SOZRTING" data-role="bx_filter_block">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block0" aria-expanded="true">Сортування</button>
                        </div>
                        <div id="filter-block0" class="accordion-collapse collapse ">
                            <div class="accordion-body">
                                <div class="filter-element-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" value="" name="" id="" <?=!isset($_GET['by']) &&!isset($_GET['sort']) ? 'checked' : ''?> onclick="setSort('<?=$APPLICATION->GetCurPageParam('', ['by','sort'])?>')">
                                        <span class="checkbox"></span>
                                        <span class="text">Новинки</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" value="" name="" id="" <?=$_GET['by']=='PROPERTY_MINIMUM_PRICE' && $_GET['sort']=='asc' ? 'checked' : ''?> onclick="setSort('<?=$APPLICATION->GetCurPageParam('by=PROPERTY_MINIMUM_PRICE&sort=asc', ['by','sort'])?>')">
                                        <span class="checkbox"></span>
                                        <span class="text">Від найнижчої ціни</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" value="" name="" id="" <?=$_GET['by']=='PROPERTY_MINIMUM_PRICE' && $_GET['sort']=='desc' ? 'checked' : ''?> onclick="setSort('<?=$APPLICATION->GetCurPageParam('by=PROPERTY_MINIMUM_PRICE&sort=desc', ['by','sort'])?>')">
                                        <span class="checkbox"></span>
                                        <span class="text">Від найвищої ціни</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>
                <?
                /*
                foreach($arResult["ITEMS"] as $key=>$arItem)//prices
                {
                    if($arItem['CODE'] == 'MATERIAL') continue;

                    if(isset($arItem["PRICE"]) && ($key == 'DISCOUNT' || $key == 'OPT' || $key == 'OPT_DISCOUNT')) continue;

                    $key = $arItem["ENCODED_ID"];
                    if(isset($arItem["PRICE"]) || $key == 'MINIMUM_PRICE'):
                        if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                            continue;



                        $step_num = 4;
                        $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                        $prices = array();
                        if (Bitrix\Main\Loader::includeModule("currency"))
                        {
                            for ($i = 0; $i < $step_num; $i++)
                            {
                                $prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                            }
                            $prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                        }
                        else
                        {
                            $precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
                            for ($i = 0; $i < $step_num; $i++)
                            {
                                $prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
                            }
                            $prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                        }
                        ?>
                        <div class="catalog-filter-cont">
                            <div class="catalog-filter-block" data-role="bx_filter_block">
                                <div class="catalog-filter-name">
                                    <span><?=LANGUAGE_ID == 'ua' ? 'Ціна' : 'Цена'?></span>
                                    <span class="icon">
                                            <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                </div>

                                <div class="catalog-filter-dropdown">
                                    <div class="row bx-filter-parameters-box-container">


                                        <div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
                                            <div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
                                                <?for($i = 0; $i <= $step_num; $i++):?>
                                                    <div class="bx-ui-slider-part p<?=$i+1?>"><span><?=$prices[$i]?></span></div>
                                                <?endfor;?>

                                                <div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
                                                <div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
                                                <div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
                                                <div class="bx-ui-slider-range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
                                                    <a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
                                                    <a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
                                            <i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></i>
                                            <div class="bx-filter-input-container">


                                                <input
                                                        class="min-price"
                                                        type="text"
                                                        name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                        id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                                        value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]// ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"]?>"
                                                        size="5"
                                                        onkeyup="smartFilter.keyup(this)"
                                                />
                                                <?
                                                if(!$arItem["VALUES"]["MIN"]["HTML_VALUE"])
                                                {
                                                    ?><span class="fake-value min"><?=$arItem["VALUES"]["MIN"]["VALUE"]?></span><?
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
                                            <i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></i>
                                            <div class="bx-filter-input-container">
                                                <input
                                                        class="max-price"
                                                        type="text"
                                                        name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                        id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                                        value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]// ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"]?>"
                                                        size="5"
                                                        onkeyup="smartFilter.keyup(this)"
                                                />
                                                <?
                                                if(!$arItem["VALUES"]["MAX"]["HTML_VALUE"])
                                                {
                                                    ?><span class="fake-value max"><?=$arItem["VALUES"]["MAX"]["VALUE"]?></span><?
                                                }
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?
                    $arJsParams = array(
                            "leftSlider" => 'left_slider_'.$key,
                            "rightSlider" => 'right_slider_'.$key,
                            "tracker" => "drag_tracker_".$key,
                            "trackerWrap" => "drag_track_".$key,
                            "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                            "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                            "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                            "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                            "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                            "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                            "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
                            "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                            "precision" => $precision,
                            "colorUnavailableActive" => 'colorUnavailableActive_'.$key,
                            "colorAvailableActive" => 'colorAvailableActive_'.$key,
                            "colorAvailableInactive" => 'colorAvailableInactive_'.$key,
                    );
                    ?>
                        <script type="text/javascript">
                            BX.ready(function(){
                                window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                            });
                        </script>
                    <?endif;
                }
                */

                //if(isset($_GET['price']))
                {
                    foreach($arResult["ITEMS"] as $key=>$arItem)//prices
                    {
                        if($arItem['CODE'] == 'MATERIAL') continue;
                        if(isset($arItem["PRICE"]) && ($key == 'DISCOUNT' || $key == 'OPT' || $key == 'OPT_DISCOUNT')) continue;

                        $key = $arItem["ENCODED_ID"];
                        if(isset($arItem["PRICE"]) || $key == 'MINIMUM_PRICE'):
                            if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                                continue;

                            /*if(!$arItem["VALUES"]["MIN"]["HTML_VALUE"])
                                $arItem["VALUES"]["MIN"]["HTML_VALUE"] = $arItem["VALUES"]["MIN"]["VALUE"];
                            if(!$arItem["VALUES"]["MAX"]["HTML_VALUE"])
                                $arItem["VALUES"]["MAX"]["HTML_VALUE"] = $arItem["VALUES"]["MAX"]["VALUE"];*/

                            $step_num = 4;
                            $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                            $prices = array();
                            if (Bitrix\Main\Loader::includeModule("currency"))
                            {
                                for ($i = 0; $i < $step_num; $i++)
                                {
                                    $prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                                }
                                $prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                            }
                            else
                            {
                                $precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
                                for ($i = 0; $i < $step_num; $i++)
                                {
                                    $prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
                                }
                                $prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                            }
                            ?>
                            <div class="accordion-item" data-role="bx_filter_block">
                                    <div class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block-price" aria-expanded="false"> 
                                            <span><?=LANGUAGE_ID == 'ua' ? 'Ціна' : 'Цена'?></span>
                                            
                                        </button>
                                    </div>

                                    <div class="accordion-collapse collapse " id="filter-block-price">
                                        <div class="accordion-body">
                                            <div class="bx-filter-parameters-box-container">
                                                <div class="bx-ui-slider-track-container">
                                                    <div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
                                                        <?for($i = 0; $i <= $step_num; $i++):?>
                                                            <div class="bx-ui-slider-part p<?=$i+1?>"><span><?=$prices[$i]?></span></div>
                                                        <?endfor;?>

                                                        <div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
                                                        <div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
                                                        <div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
                                                        <div class="bx-ui-slider-range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
                                                            <a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
                                                            <a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="filter-price-inputs-block">
                                                    <div class="bx-filter-parameters-box-container-block bx-left">
                                                        <?/*<span class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></span>*/?>
                                                        <div class="bx-filter-input-container">
                                                            <input
                                                                    class="min-price"
                                                                    type="text"
                                                                    name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                                    id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                                                    value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]// ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"]?>"
                                                                    size="5"
                                                                    onkeyup="smartFilter.keyup(this)"
                                                                    style="display:none;"
                                                            />
                                                            <?
                                                            //if(!$arItem["VALUES"]["MIN"]["HTML_VALUE"])
                                                            {
                                                                /*?><span class="fake-value min"><?=$arItem["VALUES"]["MIN"]["VALUE"]?></span><?*/
                                                                ?><span class="fake-value min"><?=$arItem["VALUES"]["MIN"]["HTML_VALUE"] ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"]?></span><?
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="bx-filter-parameters-box-container-block bx-right">
                                                        <?/*<span class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></span>*/?>
                                                        <div class="bx-filter-input-container">
                                                            <input
                                                                    class="max-price"
                                                                    type="text"
                                                                    name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                                    id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                                                    value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]// ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"]?>"
                                                                    size="5"
                                                                    onkeyup="smartFilter.keyup(this)"
                                                                    style="display:none;"
                                                            />
                                                            <?
                                                            //if(!$arItem["VALUES"]["MAX"]["HTML_VALUE"])
                                                            {
                                                                /*?><span class="fake-value max"><?=$arItem["VALUES"]["MAX"]["VALUE"]?></span><?*/
                                                                ?><span class="fake-value max"><?=$arItem["VALUES"]["MAX"]["HTML_VALUE"] ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"]?></span><?
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <?/*<div class="buttonsm">
                                                    <a class="gozast set_prices" href="">Застосувати</a>
                                                    <a class="govidm" href="">Відмінити</a>
                                                </div>*/?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                        <?
                        $arJsParams = array(
                            "leftSlider" => 'left_slider_'.$key,
                            "rightSlider" => 'right_slider_'.$key,
                            "tracker" => "drag_tracker_".$key,
                            "trackerWrap" => "drag_track_".$key,
                            "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                            "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                            "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                            "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                            "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                            "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                            "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
                            "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                            "precision" => $precision,
                            "colorUnavailableActive" => 'colorUnavailableActive_'.$key,
                            "colorAvailableActive" => 'colorAvailableActive_'.$key,
                            "colorAvailableInactive" => 'colorAvailableInactive_'.$key,
                        );
                        ?>
                            <script type="text/javascript">
                                BX.ready(function(){
                                    window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                                });
                            </script>
                        <?endif;
                    }
                }

                //not prices
                foreach($arResult["ITEMS"] as $key=>$arItem)
                {
                    if(/*$arItem['CODE'] == 'MATERIAL' || */$arItem['CODE'] == 'AGE') continue;
                    $arItem["DISPLAY_TYPE"] = 'K';

                    if(empty($arItem["VALUES"])|| isset($arItem["PRICE"]))continue;
                    if ($arItem["DISPLAY_TYPE"] == "A"&& ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))continue;
                    ?>

                    <?/*<div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block1" aria-expanded="true" >
                                Колір
                            </button>
                        </div>
                        <div id="filter-block1" class="accordion-collapse collapse show" >
                            <div class="accordion-body">
                                <div class="filter-element-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">

                                            </span>
                                        <span class="text">
                                                Червоний
                                            </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">

                                            </span>
                                        <span class="text">
                                                Червоний
                                            </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">

                                            </span>
                                        <span class="text">
                                                Червоний
                                            </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">

                                            </span>
                                        <span class="text">
                                                Червоний
                                            </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">

                                            </span>
                                        <span class="text">
                                                Червоний
                                            </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>*/?>

                    <div class="accordion-item" data-code="<?=$arItem['CODE']?>" data-role="bx_filter_block">
                            <div class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block<?=$kNumber?>" aria-expanded="false" ><?=LANGUAGE_ID == 'ua' && $arItem['FILTER_HINT'] ? $arItem['FILTER_HINT'] :$arItem['NAME']?></button>
                            </div>
                            <div id="filter-block<?=$kNumber?>" class="accordion-collapse collapse <?//=!$kNumber?'show':''?>" data-typess="<?=$arItem["DISPLAY_TYPE"]?>">
                                <div class="accordion-body">
                                    <div class="filter-element-group">
                                        <?
                                        $arCur = current($arItem["VALUES"]);

                                        switch ($arItem["DISPLAY_TYPE"])
                                        {
                                            case "K"://RADIO_BUTTONS
                                        ?>
                                        <?foreach($arItem["VALUES"] as $val => $ar):?>
                                        <?
                                        if($ar['CHECKED'])
                                        {
                                            $selected[] = [
                                                    'name' => $arItem['NAME'],
                                                    'code' => $arItem['CODE'],
                                                    'value' => $ar['VALUE'],
                                                    'url' => str_replace('/'.mb_strtolower($arItem['CODE'].'-is-'.$ar['URL_ID']).'/', '/', $APPLICATION -> GetCurPage()),
                                            ];
                                        }
                                        ?>
                                                <label class="checkbox-label">
                                                    <input
                                                            type="checkbox"
                                                            value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                            name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
                                                            id="<? echo $ar["CONTROL_ID"] ?>"
                                                            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                            onclick="smartFilter.click(this)"
                                                    >
                                                    <span class="checkbox"></span>
                                                    <span class="text"><?=trim($ar["VALUE"]);?></span>
                                                </label>
                                        <?endforeach;?>
                                        <?
                                        break;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <?
                    $kNumber++;
                }
                ?>
                <?/*
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block1" aria-expanded="true" >
                            Колір
                        </button>
                    </div>
                    <div id="filter-block1" class="accordion-collapse collapse show" >
                        <div class="accordion-body">
                            <div class="filter-element-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                Червоний
                                            </span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                Червоний
                                            </span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                Червоний
                                            </span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                Червоний
                                            </span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                Червоний
                                            </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block2" aria-expanded="false" >
                            Розмір
                        </button>
                    </div>
                    <div id="filter-block2" class="accordion-collapse collapse" >
                        <div class="accordion-body">
                            <div class="filter-element-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                XS
                                            </span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                S
                                            </span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                M
                                            </span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                L
                                            </span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                XL
                                            </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block3" aria-expanded="false" >
                            Ціна
                        </button>
                    </div>
                    <div id="filter-block3" class="accordion-collapse collapse" >
                        <div class="accordion-body">

                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block4" aria-expanded="false" >
                            Вид виробу
                        </button>
                    </div>
                    <div id="filter-block4" class="accordion-collapse collapse" >
                        <div class="accordion-body">
                            <div class="filter-element-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                Шкіра
                                            </span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                Бавовна
                                            </span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="">
                                    <span class="checkbox">

                                            </span>
                                    <span class="text">
                                                Трикотаж
                                            </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block5" aria-expanded="false" >
                            Сортувати за
                        </button>
                    </div>
                    <div id="filter-block5" class="accordion-collapse collapse" >
                        <div class="accordion-body">
                            <div class="filter-element-group">
                                <label class="radiobox-label">
                                    <input type="radio" name="radio-filter">
                                    <span class="radiobox">

                                            </span>
                                    <span class="text">
                                                Рекомендовані
                                            </span>
                                </label>
                                <label class="radiobox-label">
                                    <input type="radio" name="radio-filter">
                                    <span class="radiobox">

                                            </span>
                                    <span class="text">
                                                З меншої до більшої ціни
                                            </span>
                                </label>
                                <label class="radiobox-label">
                                    <input type="radio" name="radio-filter">
                                    <span class="radiobox">

                                            </span>
                                    <span class="text">
                                                З більшої до меншої ціни
                                            </span>
                                </label>

                            </div>
                        </div>
                    </div>
                </div>
                */?>
            </div>
        </div>
        <div class="offcanvas-footer">
            <a href="#" class="info-btn info-btn-black show_filter_button">
                Показати товари
            </a>
            <a href="#" class="info-btn ">
                видалити фільтри
            </a>
        </div>
    </form>


    <div style="display:none;" class="catalog-filters-mobile">
        <div class="h1 page-title-text" style="<?=strpos($APPLICATION -> GetCurPage(), '/rasprodazha/') !== false ? 'color:#8B0000;' : ''?>font-size:14px;">
            <?$APPLICATION->ShowViewContent('mdf_title');?>
            <?//=$seo['ELEMENT_PAGE_TITLE'] ? $seo['ELEMENT_PAGE_TITLE'] : $section?>
            <?=$arParams['SEO']['ELEMENT_PAGE_TITLE'] ? '' : $arParams['SECTION']?>
            <?//=$APPLICATION->ShowTitle()?>
            <?
            //$APPLICATION->SetTitle($seo['ELEMENT_PAGE_TITLE'] ? $seo['ELEMENT_PAGE_TITLE'] : $section);
            //$APPLICATION->SetTitle('Бомбери');
            ?>
        </div>
        <div class="catalog-filters-mobile-opener">
            <svg width="30" height="29" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line y1="4.5" x2="30" y2="4.5" stroke="#3D441D"/>
                <line y1="24.5" x2="30" y2="24.5" stroke="#3D441D"/>
                <circle cx="22" cy="4" r="3.5" fill="white" stroke="#3D441D"/>
                <line y1="14.5" x2="30" y2="14.5" stroke="#3D441D"/>
                <circle cx="22" cy="24.6678" r="3.5" fill="white" stroke="#3D441D"/>
                <circle cx="8" cy="14.2273" r="3.5" fill="white" stroke="#3D441D"/>
            </svg>
        </div>
    </div>

    <div style="display:none;" class="catalog-filters">
    	<div class="catalog-filters-top">
            <div class="catalog-filters-top-mobile">
                <div class="catalog-filters-top-mobile-title">
                    <?=LANGUAGE_ID == 'ua' ? 'Фільтр' : 'Фильтр'?>
                </div>
                <div class="catalog-filters-close">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.7002 7.2998L22.7002 22.2998" stroke="#3D441D" stroke-linecap="round"/>
                        <path d="M22.5 7.50012L7.5 22.5001" stroke="#3D441D" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <?/*<h1 class="page-title-text in_tpl_filter" style="<?=strpos($APPLICATION -> GetCurPage(), '/rasprodazha/') !== false ? 'color:#8B0000;' : ''?>">
                <?$APPLICATION->ShowViewContent('mdf_title');?>
                <?//=$seo['ELEMENT_PAGE_TITLE'] ? $seo['ELEMENT_PAGE_TITLE'] : $section?>
                <?=$arParams['SEO']['ELEMENT_PAGE_TITLE'] ? '' : $arParams['SECTION']?>
                <?//=$APPLICATION->ShowTitle()?>
                <?
                //$APPLICATION->SetTitle($seo['ELEMENT_PAGE_TITLE'] ? $seo['ELEMENT_PAGE_TITLE'] : $section);
                //$APPLICATION->SetTitle('Бомбери');
                ?>
            </h1>*/?>
            <div class="catalog-filter-cont catalog-filter-cont-opener">
                <div class="catalog-filter-block">
                    <div class="catalog-filter-name">
                        <span><?=LANGUAGE_ID == 'ua' ? 'фільтр' : 'фильтр'?></span>
                        <span class="icon">
    						<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
    							<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
    						</svg>
    	 				</span>
                    </div>
                </div>
            </div>
            <form class="catalog-filters-type" name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
                <?foreach($arResult["HIDDEN"] as $arItem):?>
                    <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
                <?endforeach;?>



                    <?foreach($arResult["ITEMS"] as $key=>$arItem)//prices
                    {
                        if($arItem['CODE'] == 'MATERIAL') continue;

                        if(isset($arItem["PRICE"]) && ($key == 'DISCOUNT' || $key == 'OPT' || $key == 'OPT_DISCOUNT')) continue;

                        $key = $arItem["ENCODED_ID"];
                        if(isset($arItem["PRICE"]) || $key == 'MINIMUM_PRICE'):
                            if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                                continue;

                            /*if(!$arItem["VALUES"]["MIN"]["HTML_VALUE"])
                                $arItem["VALUES"]["MIN"]["HTML_VALUE"] = $arItem["VALUES"]["MIN"]["VALUE"];
                            if(!$arItem["VALUES"]["MAX"]["HTML_VALUE"])
                                $arItem["VALUES"]["MAX"]["HTML_VALUE"] = $arItem["VALUES"]["MAX"]["VALUE"];*/

                            $step_num = 4;
                            $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                            $prices = array();
                            if (Bitrix\Main\Loader::includeModule("currency"))
                            {
                                for ($i = 0; $i < $step_num; $i++)
                                {
                                    $prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                                }
                                $prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                            }
                            else
                            {
                                $precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
                                for ($i = 0; $i < $step_num; $i++)
                                {
                                    $prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
                                }
                                $prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                            }
                            ?>
                            <div class="catalog-filter-cont">
                                <div class="catalog-filter-block" data-role="bx_filter_block">
                                    <div class="catalog-filter-name">
                                        <span><?=LANGUAGE_ID == 'ua' ? 'Ціна' : 'Цена'?></span>
                                        <span class="icon">
                                            <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </div>

                                    <div class="catalog-filter-dropdown">
                                    <div class="row bx-filter-parameters-box-container">


                                        <div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
                                            <div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
                                                <?for($i = 0; $i <= $step_num; $i++):?>
                                                    <div class="bx-ui-slider-part p<?=$i+1?>"><span><?=$prices[$i]?></span></div>
                                                <?endfor;?>

                                                <div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
                                                <div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
                                                <div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
                                                <div class="bx-ui-slider-range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
                                                    <a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
                                                    <a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
                                            <i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></i>
                                            <div class="bx-filter-input-container">


                                                <input
                                                        class="min-price"
                                                        type="text"
                                                        name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                        id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                                        value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]// ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"]?>"
                                                        size="5"
                                                        onkeyup="smartFilter.keyup(this)"
                                                />
                                                <?
                                                if(!$arItem["VALUES"]["MIN"]["HTML_VALUE"])
                                                {
                                                    ?><span class="fake-value min"><?=$arItem["VALUES"]["MIN"]["VALUE"]?></span><?
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
                                            <i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></i>
                                            <div class="bx-filter-input-container">
                                                <input
                                                        class="max-price"
                                                        type="text"
                                                        name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                        id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                                        value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]// ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"]?>"
                                                        size="5"
                                                        onkeyup="smartFilter.keyup(this)"
                                                />
                                                <?
                                                if(!$arItem["VALUES"]["MAX"]["HTML_VALUE"])
                                                {
                                                    ?><span class="fake-value max"><?=$arItem["VALUES"]["MAX"]["VALUE"]?></span><?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?/*<div class="buttonsm">
                                            <a class="gozast set_prices" href="">Застосувати</a>
                                            <a class="govidm" href="">Відмінити</a>
                                        </div>*/?>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        <?
                        $arJsParams = array(
                            "leftSlider" => 'left_slider_'.$key,
                            "rightSlider" => 'right_slider_'.$key,
                            "tracker" => "drag_tracker_".$key,
                            "trackerWrap" => "drag_track_".$key,
                            "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                            "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                            "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                            "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                            "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                            "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                            "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
                            "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                            "precision" => $precision,
                            "colorUnavailableActive" => 'colorUnavailableActive_'.$key,
                            "colorAvailableActive" => 'colorAvailableActive_'.$key,
                            "colorAvailableInactive" => 'colorAvailableInactive_'.$key,
                        );
                        ?>
                            <script type="text/javascript">
                                BX.ready(function(){
                                    window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                                });
                            </script>
                        <?endif;
                    }

                    //not prices
                    foreach($arResult["ITEMS"] as $key=>$arItem)
                    {
                        if(/*$arItem['CODE'] == 'MATERIAL' || */$arItem['CODE'] == 'AGE') continue;
                        $arItem["DISPLAY_TYPE"] = 'K';

                        if(empty($arItem["VALUES"])|| isset($arItem["PRICE"]))continue;
                        if ($arItem["DISPLAY_TYPE"] == "A"&& ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))continue;
                        ?>

                        <div class="catalog-filter-cont" data-code="<?=$arItem['CODE']?>">
                            <div class="catalog-filter-block" data-role="bx_filter_block">
                                <div class="catalog-filter-name">
                                    <span><?=LANGUAGE_ID == 'ua' && $arItem['FILTER_HINT'] ? $arItem['FILTER_HINT'] :$arItem['NAME']?></span>
                                    <span class="icon">
                                        <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="catalog-filter-dropdown" data-typess="<?=$arItem["DISPLAY_TYPE"]?>">
                                    <ul class="catalog-filter-type">
                                        <?
                                        $arCur = current($arItem["VALUES"]);

                                        switch ($arItem["DISPLAY_TYPE"])
                                        {
                                        case "A"://NUMBERS_WITH_SLIDER
                                            ?>
                                            <div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
                                                <i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></i>
                                                <div class="bx-filter-input-container">
                                                    <input
                                                            class="min-price"
                                                            type="text"
                                                            name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                            id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                                            value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                                            size="5"
                                                            onkeyup="smartFilter.keyup(this)"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
                                                <i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></i>
                                                <div class="bx-filter-input-container">
                                                    <input
                                                            class="max-price"
                                                            type="text"
                                                            name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                            id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                                            value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                                            size="5"
                                                            onkeyup="smartFilter.keyup(this)"
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-xs-12 bx-ui-slider-track-container">
                                                <div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
                                                    <?
                                                    $precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
                                                    $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
                                                    $value1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
                                                    $value2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
                                                    $value3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
                                                    $value4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
                                                    $value5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                                                    ?>
                                                    <div class="bx-ui-slider-part p1"><span><?=$value1?></span></div>
                                                    <div class="bx-ui-slider-part p2"><span><?=$value2?></span></div>
                                                    <div class="bx-ui-slider-part p3"><span><?=$value3?></span></div>
                                                    <div class="bx-ui-slider-part p4"><span><?=$value4?></span></div>
                                                    <div class="bx-ui-slider-part p5"><span><?=$value5?></span></div>

                                                    <div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
                                                    <div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
                                                    <div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
                                                    <div class="bx-ui-slider-range" 	id="drag_tracker_<?=$key?>"  style="left: 0;right: 0;">
                                                        <a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
                                                        <a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?
                                        $arJsParams = array(
                                            "leftSlider" => 'left_slider_'.$key,
                                            "rightSlider" => 'right_slider_'.$key,
                                            "tracker" => "drag_tracker_".$key,
                                            "trackerWrap" => "drag_track_".$key,
                                            "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                                            "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                                            "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                                            "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                                            "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                                            "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                                            "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
                                            "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                                            "precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
                                            "colorUnavailableActive" => 'colorUnavailableActive_'.$key,
                                            "colorAvailableActive" => 'colorAvailableActive_'.$key,
                                            "colorAvailableInactive" => 'colorAvailableInactive_'.$key,
                                        );
                                        ?>
                                            <script type="text/javascript">
                                                BX.ready(function(){
                                                    window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                                                });
                                            </script>
                                        <?
                                        break;
                                        case "B"://NUMBERS
                                        ?>
                                            <div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
                                                <div class="bx-filter-input-container">
                                                    <input
                                                            class="min-price"
                                                            type="text"
                                                            name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                            id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                                            value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                                            size="5"
                                                            onkeyup="smartFilter.keyup(this)"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
                                                <div class="bx-filter-input-container">
                                                    <input
                                                            class="max-price"
                                                            type="text"
                                                            name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                            id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                                            value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                                            size="5"
                                                            onkeyup="smartFilter.keyup(this)"
                                                    />
                                                </div>
                                            </div>
                                        <?
                                        break;
                                        case "G"://CHECKBOXES_WITH_PICTURES
                                        ?>
                                            <div class="col-xs-12">
                                                <div class="bx-filter-param-btn-inline">
                                                    <?foreach ($arItem["VALUES"] as $val => $ar):?>
                                                        <input
                                                                style="display: none"
                                                                type="checkbox"
                                                                name="<?=$ar["CONTROL_NAME"]?>"
                                                                id="<?=$ar["CONTROL_ID"]?>"
                                                                value="<?=$ar["HTML_VALUE"]?>"
                                                            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                        />
                                                        <?
                                                        $class = "";
                                                        if ($ar["CHECKED"])
                                                            $class.= " bx-active";
                                                        if ($ar["DISABLED"])
                                                            $class.= " disabled";
                                                        ?>
                                                        <label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label <?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'bx-active');">
                                                    <span class="bx-filter-param-btn bx-color-sl">
                                                        <?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                            <span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                                        <?endif?>
                                                    </span>
                                                        </label>
                                                    <?endforeach?>
                                                </div>
                                            </div>
                                        <?
                                        break;
                                        case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
                                        ?>
                                            <div class="col-xs-12">
                                                <div class="bx-filter-param-btn-block">
                                                    <?foreach ($arItem["VALUES"] as $val => $ar):?>
                                                        <input
                                                                style="display: none"
                                                                type="checkbox"
                                                                name="<?=$ar["CONTROL_NAME"]?>"
                                                                id="<?=$ar["CONTROL_ID"]?>"
                                                                value="<?=$ar["HTML_VALUE"]?>"
                                                            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                        />
                                                        <?
                                                        $class = "";
                                                        if ($ar["CHECKED"])
                                                            $class.= " bx-active";
                                                        if ($ar["DISABLED"])
                                                            $class.= " disabled";
                                                        ?>
                                                        <label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'bx-active');">
                                                    <span class="bx-filter-param-btn bx-color-sl">
                                                        <?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                            <span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                                        <?endif?>
                                                    </span>
                                                            <span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
                                                                if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                                    ?> <span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span><?
                                                                endif;?></span>
                                                        </label>
                                                    <?endforeach?>
                                                </div>
                                            </div>
                                        <?
                                        break;
                                        case "P"://DROPDOWN
                                        $checkedItemExist = false;
                                        ?>
                                            <input
                                                    style="display: none"
                                                    type="radio"
                                                    name="<?=$arCur["CONTROL_NAME_ALT"]?>"
                                                    id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
                                                    value=""
                                            />
                                            <?foreach ($arItem["VALUES"] as $val => $ar):?>
                                                <li>
                                                    <label>
                                                        <input type="checkbox" name="">
                                                        <span class="icon"></span><?=$ar['VALUE']?>
                                                    </label>
                                                </li>
                                                <input
                                                        style="display: none"
                                                        type="radio"
                                                        name="<?=$ar["CONTROL_NAME_ALT"]?>"
                                                        id="<?=$ar["CONTROL_ID"]?>"
                                                        value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                    <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                />
                                            <?endforeach?>
                                        <?
                                        break;
                                        case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
                                        ?>
                                            <div class="col-xs-12">
                                                <div class="bx-filter-select-container">
                                                    <div class="bx-filter-select-block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
                                                        <div class="bx-filter-select-text fix" data-role="currentOption">
                                                            <?
                                                            $checkedItemExist = false;
                                                            foreach ($arItem["VALUES"] as $val => $ar):
                                                                if ($ar["CHECKED"])
                                                                {
                                                                    ?>
                                                                    <?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                                    <span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                                                <?endif?>
                                                                    <span class="bx-filter-param-text">
                                                                    <?=$ar["VALUE"]?>
                                                                </span>
                                                                    <?
                                                                    $checkedItemExist = true;
                                                                }
                                                            endforeach;
                                                            if (!$checkedItemExist)
                                                            {
                                                                ?><span class="bx-filter-btn-color-icon all"></span> <?
                                                                echo GetMessage("CT_BCSF_FILTER_ALL");
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="bx-filter-select-arrow"></div>
                                                        <input
                                                                style="display: none"
                                                                type="radio"
                                                                name="<?=$arCur["CONTROL_NAME_ALT"]?>"
                                                                id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
                                                                value=""
                                                        />
                                                        <?foreach ($arItem["VALUES"] as $val => $ar):?>
                                                            <input
                                                                    style="display: none"
                                                                    type="radio"
                                                                    name="<?=$ar["CONTROL_NAME_ALT"]?>"
                                                                    id="<?=$ar["CONTROL_ID"]?>"
                                                                    value="<?=$ar["HTML_VALUE_ALT"]?>"
                                                                <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                            />
                                                        <?endforeach?>
                                                        <div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none">
                                                            <ul>
                                                                <li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
                                                                    <label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx-filter-param-label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
                                                                        <span class="bx-filter-btn-color-icon all"></span>
                                                                        <? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
                                                                    </label>
                                                                </li>
                                                                <?
                                                                foreach ($arItem["VALUES"] as $val => $ar):
                                                                    $class = "";
                                                                    if ($ar["CHECKED"])
                                                                        $class.= " selected";
                                                                    if ($ar["DISABLED"])
                                                                        $class.= " disabled";
                                                                    ?>
                                                                    <li>
                                                                        <label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
                                                                            <?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                                                <span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                                                            <?endif?>
                                                                            <span class="bx-filter-param-text">
                                                                        <?=$ar["VALUE"]?>
                                                                    </span>
                                                                        </label>
                                                                    </li>
                                                                <?endforeach?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?
                                        break;
                                        case "K"://RADIO_BUTTONS
                                        ?>
                                                <?foreach($arItem["VALUES"] as $val => $ar):?>
                                                    <?
                                                    /*if($ar['CHECKED'])
                                                    {
                                                        $selected[] = [
                                                            'code' => $arItem['CODE'],
                                                            'value' => $ar['VALUE'],
                                                            'url' => str_replace('/'.mb_strtolower($arItem['CODE'].'-is-'.$ar['URL_ID']).'/', '/', $APPLICATION -> GetCurPage()),
                                                        ];
                                                    }*/
                                                    ?>
                                                    <li>
                                                        <label data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>">
                                                            <input
                                                                    type="radio"
                                                                    value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            />
                                                            <span  class="icon" title="<?=$ar["VALUE"];?>"></span><span val="<?=trim($ar["VALUE"]);?>"><?=trim($ar["VALUE"]);?><?
                                                                if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                                    ?>&nbsp;<span data-role="count_<?=$ar["CONTROL_ID"]?>">(<? echo $ar["ELEMENT_COUNT"]; ?>)</span><?
                                                                endif;?>
                                                                </span>
                                                        </label>
                                                    </li>

                                                <?endforeach;?>
                                        <?
                                        break;
                                        case "U"://CALENDAR
                                        ?>
                                            <div class="col-xs-12">
                                                <div class="bx-filter-parameters-box-container-block"><div class="bx-filter-input-container bx-filter-calendar-container">
                                                        <?$APPLICATION->IncludeComponent(
                                                            'bitrix:main.calendar',
                                                            '',
                                                            array(
                                                                'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
                                                                'SHOW_INPUT' => 'Y',
                                                                'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
                                                                'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
                                                                'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                                                                'SHOW_TIME' => 'N',
                                                                'HIDE_TIMEBAR' => 'Y',
                                                            ),
                                                            null,
                                                            array('HIDE_ICONS' => 'Y')
                                                        );?>
                                                    </div></div>
                                                <div class="bx-filter-parameters-box-container-block"><div class="bx-filter-input-container bx-filter-calendar-container">
                                                        <?$APPLICATION->IncludeComponent(
                                                            'bitrix:main.calendar',
                                                            '',
                                                            array(
                                                                'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
                                                                'SHOW_INPUT' => 'Y',
                                                                'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
                                                                'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
                                                                'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                                                                'SHOW_TIME' => 'N',
                                                                'HIDE_TIMEBAR' => 'Y',
                                                            ),
                                                            null,
                                                            array('HIDE_ICONS' => 'Y')
                                                        );?>
                                                    </div></div>
                                            </div>
                                        <?
                                        break;
                                        default://CHECKBOXES

                                        ?>
                                            <div class="col-xs-12">
                                                <?foreach($arItem["VALUES"] as $val => $ar):?>
                                                    <div class="checkbox">
                                                        <label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
                                                        <span class="bx-filter-input-checkbox">
                                                            <input
                                                                    type="checkbox"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                                onclick="smartFilter.click(this)"
                                                            />
                                                            <span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
                                                                if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                                    ?>&nbsp;<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span><?
                                                                endif;?></span>
                                                        </span>
                                                        </label>
                                                    </div>
                                                <?endforeach;?>
                                            </div>
                                        <?
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    ?>
                <div class="bx-filter-parameters-box-container" style="display: none;">
                                <input
                                        class="btn btn-themes"
                                        type="submit"
                                        id="set_filter"
                                        name="set_filter"
                                        value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
                                />
                                <input
                                        class="btn btn-link"
                                        type="submit"
                                        id="del_filter"
                                        name="del_filter"
                                        value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
                                />
                                <div class="bx-filter-popup-result <?if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL") echo $arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
                                    <?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
                                    <span class="arrow"></span>
                                    <br/>
                                    <a href="<?echo $arResult["FILTER_URL"]?>" target=""><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
                                </div>
                            </div>
            </form>
            <div class="catalog-filter-cont">
                <div class="catalog-filter-block">
                    <div class="catalog-filter-name">
                        <span><?=LANGUAGE_ID == 'ua' ? 'сортувати' : 'сортировать по'?></span>
                        <span class="icon">
    						<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
    							<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
    						</svg>
    	 				</span>
                    </div>
                    <div class="catalog-filter-dropdown">
                        <?/*<a href="<?=$page?>?by=PROPERTY_POPULAR&sort=desc"><?=LANGUAGE_ID == 'ua' ? 'За популярністю' : 'Популярности'?></a>*/?>
                        <?/*<a href="<?=$page?>?by=PROPERTY_POPULAR&sort=desc"><?=LANGUAGE_ID == 'ua' ? 'Сортувати за оцінкою' : 'Сортировать за оценкой'?></a> <?// todo не працює це?>*/?>
                        <a href="<?=$page?>?by=sort&sort=desc"><?=LANGUAGE_ID == 'ua' ? 'За останніми надходженнями' : 'Последних поступлениях'?></a>
                        <?/*<a href="<?=$page?>?by=PROPERTY_DISCOUNT&sort=desc">Максимальна знижка</a>*/?>
                        <a href="<?=$page?>?by=PROPERTY_MINIMUM_PRICE&sort=asc"><?=LANGUAGE_ID == 'ua' ? 'За ціною: від нижчої до вищої' : 'Возрастанию цены'?></a>
                        <a href="<?=$page?>?by=PROPERTY_MINIMUM_PRICE&sort=desc"><?=LANGUAGE_ID == 'ua' ? 'За ціною: від вищої до нижчої' : 'Убыванию цены'?></a>
                    </div>
                </div>
            </div>
            <div class="catalog-filter-mobile-btns">
                <a href="#" class="btn round-ignore realignore"><?=LANGUAGE_ID == 'ua' ? 'Застосувати' : 'Применить'?></a>
                <a href="<?=preg_replace('/\/filter\/.*$/', '/', $APPLICATION -> GetCurPage());?>" class="btn round-ignore"><?=LANGUAGE_ID == 'ua' ? 'Відмінити' : 'Отменить'?></a>
            </div>
    	</div>
    </div>
    <div style="display:none;" class="filter-selected-list">
        <?
        if(isset($_REQUEST['get_catalog_ajax_filter']) && $_REQUEST['get_catalog_ajax_filter'] == 'y')
        {
            global $jsonFilter;
            ob_start();
        }

        $from = LANGUAGE_ID == 'ua' ? 'від' : 'от';

        $page = $APPLICATION -> GetCurPage();
        preg_match('/\/price-base-from-([0-9]+)-to-([0-9]+)\//',$page,$matches);
        if(!empty($matches) && $matches[1] && $matches[2])
            $selected[] = ['url' => str_replace('/price-base-from-'.$matches[1].'-to-'.$matches[2].'/', '/', $page), 'value' => $from.' '.$matches[1].' до '.$matches[2]];
        else
        {
            preg_match('/\/price-base-from-([0-9]+)\//',$page,$matches);
            if(!empty($matches) && $matches[1])
                $selected[] = ['url' => str_replace('/price-base-from-'.$matches[1].'/', '/', $page), 'value' => $from.' '.$matches[1]];
            else
            {
                preg_match('/\/price-base-to-([0-9]+)\//',$page,$matches);
                if(!empty($matches) && $matches[1])
                    $selected[] = ['url' => str_replace('/price-base-to-'.$matches[1].'/', '/', $page), 'value' => 'до '.$matches[1]];
            }
        }

        foreach ($selected as $index => $item)
        {
            $item['url'] = str_replace(['/filter/apply/', '/filter/clear/apply/'],['/','/'],$item['url'])
            ?>
            <div class="filter-selected-item">
                <div class="filter-selected-item-name"><?=$item['value']?></div>
                <a href="<?=$item['url']?>" class="filter-selected-item-delete">
                    <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                    </svg>
                </a>
            </div><?
        }


        if(isset($_REQUEST['get_catalog_ajax_filter']) && $_REQUEST['get_catalog_ajax_filter'] == 'y')
        {
            $page = $APPLICATION -> GetCurPage();
            preg_match('/\/price-base-from-([0-9]+)-to-([0-9]+)\//',$page,$matches);

            $jsonFilter['filter'] = ob_get_clean();
            $APPLICATION -> RestartBuffer();
        }
        global $selectedFilter;
        $selectedFilter=$selected;
        $text=LANGUAGE_ID=='ua'?'Фільтр':'Фильтр';
        $APPLICATION->AddViewContent('filter_counter','<span class="count_products">'.$text.' ('.count($selectedFilter).')</span>');

        ?>
        <?/*
        <div class="filter-selected-item">
            <div class="filter-selected-item-name">спортивний костюм</div>
            <a href="#" class="filter-selected-item-delete">
                <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                </svg>
            </a>
        </div>
        <div class="filter-selected-item">
            <div class="filter-selected-item-name">світшот</div>
            <a href="#" class="filter-selected-item-delete">
                <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                </svg>
            </a>
        </div>
        <div class="filter-selected-item">
            <div class="filter-selected-item-name">чорний</div>
            <a href="#" class="filter-selected-item-delete">
                <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                </svg>
            </a>
        </div>
        <div class="filter-selected-item">
            <div class="filter-selected-item-name">котон</div>
            <a href="#" class="filter-selected-item-delete">
                <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                </svg>
            </a>
        </div>
        <div class="filter-selected-item">
            <div class="filter-selected-item-name">очистити фільтри</div>
            <a href="#" class="filter-selected-item-delete">
                <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
                </svg>
            </a>
        </div>
        */?>
    </div>

    <script type="text/javascript">
    	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
    //    var urlWithoutPrice = '<?=$withoutprice?>';
    </script>
</div>


<?
$contentSelected ='';

if(!empty($selectedFilter))
    $contentSelected .= '<div class="filter-active-title">
                    '.(LANGUAGE_ID == 'ua' ? 'Застосовані фільтра' : 'Выбранные фильтра').'
                </div>';

$contentSelected .= '

<div class="filter-active-list">
';
foreach($selectedFilter as $index => $item)
{
    $item['url'] = str_replace(['/filter/apply/', '/filter/clear/apply/'],['/','/'],$item['url']);
    $contentSelected .= '<div class="filter-active-elem">
        <a class="filter-active-remove" href="'.$item['url'].'">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.5022 8.79148C2.30695 8.98678 2.30698 9.30333 2.50226 9.49858C2.69754 9.69383 3.01412 9.69383 3.20936 9.49853L6.00198 6.70543L8.79483 9.49828C8.99008 9.69353 9.30668 9.69353 9.50193 9.49828C9.69718 9.30303 9.69718 8.98643 9.50193 8.79118L6.70903 5.99828L9.50173 3.20509C9.69693 3.00981 9.69693 2.69323 9.50163 2.49798C9.30638 2.30273 8.98978 2.30276 8.79453 2.49804L6.00188 5.29118L3.20902 2.49828C3.01376 2.30302 2.69718 2.30302 2.50192 2.49828C2.30665 2.69355 2.30665 3.01013 2.50192 3.20539L5.29488 5.99833L2.5022 8.79148Z" fill="currentcolor"/>
            </svg>
        </a>
        <span class="text">'.$item['value'].'</span>
    </div>';
}
$contentSelected .= '</div>';
$APPLICATION->AddViewContent('selected_filter',$contentSelected);
?>
