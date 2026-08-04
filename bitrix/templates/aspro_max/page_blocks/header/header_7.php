<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
global $arTheme, $arRegion, $bLongHeader, $bColoredHeader;
$arRegions = CMaxRegionality::getRegions();
if($arRegion)
	$bPhone = ($arRegion['PHONES'] ? true : false);
else
	$bPhone = ((int)$arTheme['HEADER_PHONES'] ? true : false);
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
$bLongHeader = true;
$bColoredHeader = true;
?>

<link rel="stylesheet" href="/bitrix/templates/aspro_max/css/slick.css">
<script src="/bitrix/templates/aspro_max/js/slick.min.js"></script>

<link rel="stylesheet" href="/bitrix/templates/aspro_max/fbox/source/jquery.fancybox.css">
<link rel="stylesheet" href="/bitrix/templates/aspro_max/fbox/source/helpers/jquery.fancybox-buttons.css">
<link rel="stylesheet" href="/bitrix/templates/aspro_max/fbox/source/helpers/jquery.fancybox-thumbs.css">

<script src="/bitrix/templates/aspro_max/fbox/lib/jquery.mousewheel.pack.js"></script>
<script src="/bitrix/templates/aspro_max/fbox/source/jquery.fancybox.js"></script>
<script src="/bitrix/templates/aspro_max/fbox/source/helpers/jquery.fancybox-buttons.js"></script>
<script src="/bitrix/templates/aspro_max/fbox/source/helpers/jquery.fancybox-media.js"></script>
<script src="/bitrix/templates/aspro_max/fbox/source/helpers/jquery.fancybox-thumbs.js"></script>

<div class="top-block top-block-v1" style="display:none;">
	<div class="maxwidth-theme">		
		<div class="wrapp_block">
			<div class="row">
				<div class="items-wrapper flexbox flexbox--row justify-content-between">
					<?if($arRegions):?>
						<div class="top-block-item">
							<div class="top-description no-title wicons">
								<?\Aspro\Functions\CAsproMax::showRegionList();?>
							</div>
						</div>
					<?endif;?>
					<div class="top-block-item">
						<div class="phone-block icons">
							<?if($bPhone):?>
								<div class="inline-block">
									<?CMax::ShowHeaderPhones();?>
								</div>
							<?endif?>
							<?$callbackExploded = explode(',', $arTheme['SHOW_CALLBACK']['VALUE']);
							if( in_array('HEADER', $callbackExploded) ):?>
								<div class="inline-block">
									<span class="callback-block animate-load font_upper_xs colored" data-event="jqm" data-param-form_id="CALLBACK" data-name="callback"><?=GetMessage("CALLBACK")?></span>
								</div>
							<?endif;?>
						</div>
					</div>
					
					<div class="top-block-item addr-block">
						<div><?CMax::showAddress('address tables inline-block');?></div>
					</div>
                    <?
                    $pageUrl = isset($_SERVER['NEW_URL']) ? $_SERVER['NEW_URL'][3] : $APPLICATION->GetCurPage();
                    $page = str_replace('/ru/','/',$pageUrl);
                    ?>
					<div class="top-block-item">
						<div class="language-switch">
                            <?
                            if(LANGUAGE_ID == 'ua')
                            {
                                ?>
                                <span class="active">Укр</span>
                                <a href="/ru<?=$page?>">Рус</a>
                                <?
                            }
                            else
                            {
                                ?>
                                <a href="<?=$page?>">Укр</a>
                                <span class="active">Рус</span>
                                <?
                            }
                            ?>
						</div>
					</div>
					<div class="top-block-item show-fixed top-ctrl">
						<div class="personal_wrap">
							<div class="personal top login font_upper">
								<?=CMax::ShowCabinetLink(true, true);?>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="header-wrapper header-v7" style="display:none;">
	<div class="logo_and_menu-row">
		<div class="logo-row paddings">
			<div class="maxwidth-theme">
				<div class="row">
					<div class="col-md-12">
						<div class="logo-block pull-left floated">
							<div class="logo<?=$logoClass?>">
								<?=CMax::ShowLogo();?>
							</div>
						</div>

						<div class="float_wrapper fix-block pull-left">
							<div class="hidden-sm hidden-xs pull-left">
								<div class="top-description addr tda8">
									<?$APPLICATION->IncludeFile(SITE_DIR."include/top_page/slogan.php", array(), array(
											"MODE" => "html",
											"NAME" => "Text in title",
											"TEMPLATE" => "include_area.php",
										)
									);?>
								</div>
							</div>
						</div>

						<div class="search_wrap pull-left">
							<div class="search-block inner-table-block">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include/top_page/search.title.catalog.php",
										"EDIT_TEMPLATE" => "include_area.php",
										'SEARCH_ICON' => 'Y',
									)
								);?>
							</div>
						</div>

						<div class="right-icons pull-right wb">
							<div class="pull-right">
								<?=CMax::ShowBasketWithCompareLink('', 'big', '', 'wrap_icon wrap_basket baskets');?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><?// class=logo-row?>
	</div>

	<div class="menu-row middle-block bg<?=strtolower($arTheme["MENU_COLOR"]["VALUE"]);?>">
		<div class="maxwidth-theme">
			<div class="row">
				<div class="col-md-12">
					<div class="menu-only">
						<nav class="mega-menu sliced">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/menu/menu.".($arTheme["HEADER_TYPE"]["LIST"][$arTheme["HEADER_TYPE"]["VALUE"]]["ADDITIONAL_OPTIONS"]["MENU_HEADER_TYPE"]["VALUE"] == "Y" ? "top_catalog_wide" : "top").".php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false, array("HIDE_ICONS" => "Y")
							);?>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="line-row visible-xs"></div>
</div>

<?

$res = CIBlockSection::GetList(['LEFT_MARGIN' => 'ASC','sort' => 'asc'], ['IBLOCK_ID' => 21, 'ACTIVE' => 'Y', '<DEPTH_LEVEL' => 3], false, ['IBLOCK_SECTION_ID','ID', 'NAME', 'SECTION_PAGE_URL', 'UF_*', 'DEPTH_LEVEL']);
$items = [];
while ($record = $res -> GetNext())
{
    if(LANGUAGE_ID == 'ua' && $record['UF_NAME_UA'])
        $record['NAME'] = $record['UF_NAME_UA'];

    if($record['DEPTH_LEVEL'] == 1)
        $items[$record['ID']] = $record;
    else
        $items[$record['IBLOCK_SECTION_ID']]['items'][$record['ID']] = $record;
}
?>

<div class="header-cont">
	<div class="header-left-block">
		<div class="header-menu-block">
			<div class="header-menu-burger">
				<svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect width="16" height="2" fill="#3D441D"/>
					<rect y="6" width="16" height="2" fill="#3D441D"/>
					<rect y="12" width="16" height="2" fill="#3D441D"/>
				</svg>
			</div>
			<div class="header-menu-cont <?=$APPLICATION -> GetCurPage() == '/' || $APPLICATION -> GetCurPage() == '/ru/' ? 'header-menu-cont-main' : ''?>">
				<div class="header-menu-close">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M4.62012 4.37985L13.6201 13.3799" stroke="#3D441D" stroke-linecap="round"/>
						<path d="M13.5 4.50006L4.5 13.5001" stroke="#3D441D" stroke-linecap="round"/>
					</svg>
				</div>
                <?
                if(isset($_GET['me']))
                {
                }
                ?>
				<div class="header-menu-catalog-lists">
                    <ul class="nav nav-tabs">
                        <?
                        $in = 0;
                        foreach ($items as $id => $item)
                        {
                            if(!$item['NAME']) continue;
                            if($item['items'])
                            {
                                ?><li role="presentation" class="<?=!$in ? 'active' : ''?>"><a data-toggle="tab" role="tab" href="#tab<?=$id?><?//=$item['SECTION_PAGE_URL']?>" tohref="#tab<?=$id?>" style="<?=strtolower($item['NAME']) == 'sale' ? 'color:#8B0000;font-weight:bold;' : ''?>" <?/*data-toggle="tab"*/?>>
                                    <?=$item['NAME']?><?//=LANGUAGE_ID=='ua' ? 'ВЕСЬ' : 'ВСЯ'?> <?//=mb_strtoupper($item['NAME'])?>
                                </a></li><?
                            }
                            else
                            {
                                ?><li class="<?=!$in ? 'active' : ''?>"><a href="<?=$item['SECTION_PAGE_URL']?>"  style="<?=strtolower($item['NAME']) == 'sale' ? 'color:#8B0000;font-weight:bold;' : ''?>" <?/*data-toggle="tab"*/?>>
                                    <?=$item['NAME']?>
                                </a></li><?
                            }

                            $in++;
                        }
                        ?>
                        <?/*
                        <li class="active"><a href="#tab1" data-toggle="tab">жіночий одяг</a></li>
                        <li class=""><a href="#tab2" data-toggle="tab">дитячий одяг</a></li>
                        <li><a href="#tab3" data-toggle="tab">термобілизна</a></li>
                        <li><a href="#tab4" data-toggle="tab">sale</a></li>
                        */?>
                    </ul>
                    <div class="tab-content">
                        <?
                        $in1 = 0;
                        foreach ($items as $id => $item)
                        {
                            ?>
                            <div role="tabpanel" class="tab-pane fade <?=!$in1 ? 'active in' : ''?>" id="tab<?=$id?>">
                                <?
                                if($item['items'])
                                {
                                    ?>
                                    <ul class="header-menu-catalog-list">
                                        <li class="header-menu-catalog-list-item">
                                            <a href="<?=$item['SECTION_PAGE_URL']?>">
                                                <?$accss = strpos($item['SECTION_PAGE_URL'], '/aksessuary/') !== false?>
                                                <?
                                                if($accss)
                                                {
                                                    echo LANGUAGE_ID=='ua' ? 'ВСІ' : 'ВСЕ'?> <?=mb_strtoupper($item['NAME']);
                                                }
                                                else
                                                {
                                                   echo LANGUAGE_ID=='ua' ? 'ВЕСЬ ОДЯГ' : 'ВСЯ ОДЕЖДА'?> <?
                                                }
                                                ?>
                                            </a>
                                        </li>
                                        <?
                                        foreach ($item['items'] as $idL2 => $itemL2)
                                        {
                                            ?>
                                            <li class="header-menu-catalog-list-item">
                                                <a href="<?=$itemL2['SECTION_PAGE_URL']?>"><?=$itemL2['NAME']?></a>
                                            </li>
                                            <?
                                        }
                                        ?>
                                        <?/*
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Нова колекція</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Сукні та сарафани</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Спортивні костюми</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Блузи і сорочки</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Пальто</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Куртки</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Светри і джемпери</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Світшоти та худі</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Спортивні штани</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Костюми та жакети</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Джинси</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Брюки</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Спідниці</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Шорти</a>
                                        </li>
                                        <li class="header-menu-catalog-list-item">
                                            <a href="#">Футболки, лонгсліви, топи, майки</a>
                                        </li>
                                        */?>
                                    </ul>
                                    <?
                                }
                                ?>
                            </div>
                            <?
                            $in1++;
                        }
                        ?>
                        <?/*
                        <div class="tab-pane fade active in" id="tab1">
                        	<ul class="header-menu-catalog-list">
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Нова колекція</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Сукні та сарафани</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спортивні костюми</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Блузи і сорочки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Пальто</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Куртки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Светри і джемпери</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Світшоти та худі</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спортивні штани</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Костюми та жакети</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Джинси</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Брюки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спідниці</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Шорти</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Футболки, лонгсліви, топи, майки</a>
                        		</li>
                        	</ul>
                        </div>
                        <div class="tab-pane fade" id="tab2">
                        	<ul class="header-menu-catalog-list">
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Нова колекція</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Сукні та сарафани</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спортивні костюми</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Блузи і сорочки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Пальто</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Куртки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Светри і джемпери</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Світшоти та худі</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спортивні штани</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Костюми та жакети</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Джинси</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Брюки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спідниці</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Шорти</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Футболки, лонгсліви, топи, майки</a>
                        		</li>
                        	</ul>
                        </div>
                        <div class="tab-pane fade" id="tab3">
                        	<ul class="header-menu-catalog-list">
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Нова колекція</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Сукні та сарафани</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спортивні костюми</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Блузи і сорочки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Пальто</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Куртки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Светри і джемпери</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Світшоти та худі</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спортивні штани</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Костюми та жакети</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Джинси</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Брюки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спідниці</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Шорти</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Футболки, лонгсліви, топи, майки</a>
                        		</li>
                        	</ul>
                        </div>
                        <div class="tab-pane fade" id="tab4">
                        	<ul class="header-menu-catalog-list">
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Нова колекція</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Сукні та сарафани</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спортивні костюми</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Блузи і сорочки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Пальто</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Куртки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Светри і джемпери</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Світшоти та худі</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спортивні штани</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Костюми та жакети</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Джинси</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Брюки</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Спідниці</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Шорти</a>
                        		</li>
                        		<li class="header-menu-catalog-list-item">
                        			<a href="#">Футболки, лонгсліви, топи, майки</a>
                        		</li>
                        	</ul>
                        </div>
                        */?>
                    </div>
	            </div>
	            <div class="header-menu-catalog-lists-mobile">
                    <?
                    foreach ($items as $id => $item)
                    {
                        ?>
                        <div class="header-menu-mobile-item">
                            <div class="header-menu-mobile-item-title">
                                <?if(!$item['items']){?><a style="<?=strtolower($item['NAME']) == 'sale' ? 'color:#8B0000;font-weight:bold;' : 'color:inherit'?>" href="<?=$item['SECTION_PAGE_URL']?>"><?}?>
                                    <?=$item['NAME']?>
                                <?if(!$item['items']){?></a><?}?>
                            </div>
                            <?
                            if($item['items'])
                            {
                                ?>
                                <div class="header-menu-mobile-item-dropdown">
                                    <?$accss = strpos($item['SECTION_PAGE_URL'], '/aksessuary/') !== false?>
                                    <a href="<?=$item['SECTION_PAGE_URL']?>" class="header-menu-mobile-item-link">
                                        <?
                                        if($accss)
                                        {
                                            echo LANGUAGE_ID=='ua' ? 'ВСІ' : 'ВСЕ'?> <?=mb_strtoupper($item['NAME']);
                                        }
                                        else
                                        {
                                            echo LANGUAGE_ID=='ua' ? 'ВЕСЬ ОДЯГ' : 'ВСЯ ОДЕЖДА'?> <?
                                        }
                                        ?>
                                    </a>
                                    <?
                                    foreach ($item['items'] as $index => $litem)
                                    {
                                        ?>
                                        <a href="<?=$litem['SECTION_PAGE_URL']?>" class="header-menu-mobile-item-link">
                                            <?=$litem['NAME']?>
                                        </a>
                                        <?
                                    }
                                    ?>
                                </div>
                                <?
                            }
                            ?>

                        </div>
                        <?
                    }
                    ?>
                    <?/*
	            	<div class="header-menu-mobile-item">
	            		<div class="header-menu-mobile-item-title">жіночий одяг</div>
	            		<div class="header-menu-mobile-item-dropdown">
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            		</div>
	            	</div>
	            	<div class="header-menu-mobile-item">
	            		<div class="header-menu-mobile-item-title">жіночий одяг</div>
	            		<div class="header-menu-mobile-item-dropdown">
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            		</div>
	            	</div>
	            	<div class="header-menu-mobile-item">
	            		<div class="header-menu-mobile-item-title">жіночий одяг</div>
	            		<div class="header-menu-mobile-item-dropdown">
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            		</div>
	            	</div>
	            	<div class="header-menu-mobile-item">
	            		<div class="header-menu-mobile-item-title">жіночий одяг</div>
	            		<div class="header-menu-mobile-item-dropdown">
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            		</div>
	            	</div>
	            	<div class="header-menu-mobile-item">
	            		<div class="header-menu-mobile-item-title">жіночий одяг</div>
	            		<div class="header-menu-mobile-item-dropdown">
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            		</div>
	            	</div>
	            	<div class="header-menu-mobile-item">
	            		<div class="header-menu-mobile-item-title">жіночий одяг</div>
	            		<div class="header-menu-mobile-item-dropdown">
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            		</div>
	            	</div>
	            	<div class="header-menu-mobile-item">
	            		<div class="header-menu-mobile-item-title">жіночий одяг</div>
	            		<div class="header-menu-mobile-item-dropdown">
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            		</div>
	            	</div>
	            	<div class="header-menu-mobile-item">
	            		<div class="header-menu-mobile-item-title">жіночий одяг</div>
	            		<div class="header-menu-mobile-item-dropdown">
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            			<a href="#" class="header-menu-mobile-item-link">
	            				Сукні та сарафани
	            			</a>
	            		</div>
	            	</div>
                    */?>
	            </div>
				<div class="header-menu-bottom">
					<div class="header-menu-auxiliary-links">
						<a href="<?=LANGUAGE_ID == 'ru' ? '/ru' : ''?>/pro-nas/"><?=LANGUAGE_ID == 'ua' ? 'ІНФОРМАЦІЯ' : 'ИНФОРМАЦИЯ'?></a>
						<a href="<?=LANGUAGE_ID == 'ru' ? '/ru' : ''?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/"><?=LANGUAGE_ID == 'ua' ? 'СПІВПРАЦЯ' : 'СОТРУДНИЧЕСТВО'?></a>
						<a href="<?=LANGUAGE_ID == 'ru' ? '/ru' : ''?>/contacts/"><?=LANGUAGE_ID == 'ua' ? 'НАШІ МАГАЗИНИ' : 'НАШИ МАГАЗИНЫ'?></a>
					</div>
                    <?
                    $pageUrl = isset($_SERVER['NEW_URL']) ? $_SERVER['NEW_URL'][3] : $APPLICATION->GetCurPage();
                    $page = str_replace('/ru/','/',$pageUrl);
                    ?>

					<div class="header-menu-language-switch hml1">
                        <?
                        if(LANGUAGE_ID == 'ua')
                        {
                            ?>
                            <span class="active">UA</span>
                            <a href="/ru<?=$page?>">RU</a>
                            <?
                        }
                        else
                        {
                            ?>
                            <a href="<?=$page?>">UA</a>
                            <span class="active">RU</span>
                            <?
                        }
                        ?>
					</div>
				</div>
			</div>
		</div>
        <?/*
		<div class="header-city-select">
			<div class="header-city-select-icon">
				<svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M8.04759 11.3249C9.84696 11.3249 11.3056 9.84569 11.3056 8.02103C11.3056 6.19637 9.84696 4.71719 8.04759 4.71719C6.24823 4.71719 4.78955 6.19637 4.78955 8.02103C4.78955 9.84569 6.24823 11.3249 8.04759 11.3249Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M8.05411 20C8.11299 19.9215 8.15224 19.8757 8.1915 19.8234C9.199 18.5018 10.2196 17.1803 11.2206 15.8457C12.0841 14.6942 12.9673 13.5559 13.759 12.3587C14.8384 10.7231 15.3095 8.91743 15.0151 6.93513C14.4132 2.99669 10.4289 0.275117 6.54285 1.1714C2.35581 2.1462 -0.00594116 6.43137 1.41373 10.4941C1.83243 11.6979 2.51937 12.7512 3.28481 13.7522C4.44933 15.2896 5.64656 16.8074 6.81763 18.3448C7.23633 18.8813 7.62886 19.4308 8.05411 20Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="header-city-select-form">
				<div class="header-city-select-active">
					<span>Ваше місто</span>
					<span class="icon">
						<svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M15.1421 0.995667L8.07102 8.06673L0.999954 0.995665" stroke="#3D441D"/>
						</svg>
					</span>
				</div>
				<div class="header-city-select-dropdown">
					<a href="#">
						Київ
					</a>
					<a href="#">
						Рівне
					</a>
					<a href="#">
						Львів
					</a>
					<a href="#">
						Житомир
					</a>
				</div>
			</div>
		</div>
        */?>
    </div>
	<div class="header-logo-block">
		<a href="<?=SITE_DIR?>">
			<img src="/bitrix/templates/aspro_max/images/logost.png">
		</a>
	</div>
	<div class="header-right-block">
		<div class="header-menu-language-switch hml2">
            <?
            $pageUrl = isset($_SERVER['NEW_URL']) ? $_SERVER['NEW_URL'][3] : $APPLICATION->GetCurPage();
            $page = str_replace('/ru/','/',$pageUrl);
            ?>
            <?
            if(LANGUAGE_ID == 'ua')
            {
                ?>
                <span class="active">UA</span>
                <a href="/ru<?=$page?>">RU</a>
                <?
            }
            else
            {
                ?>
                <a href="<?=$page?>">UA</a>
                <span class="active">RU</span>
                <?
            }
            ?>
		</div>
		<div class="header-search-block">
			<div class="header-search-icon">
				<svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M9.14459 17.2892C13.6427 17.2892 17.2892 13.6427 17.2892 9.14459C17.2892 4.64646 13.6427 1 9.14459 1C4.64646 1 1 4.64646 1 9.14459C1 13.6427 4.64646 17.2892 9.14459 17.2892Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10"/>
					<path d="M14.4937 15.2681L19.2376 20" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10"/>
				</svg>
			</div>
			<div class="header-search-form" style="<?=strpos($APPLICATION -> GetCurPage(), '/auth/') !== false || strpos($APPLICATION -> GetCurPage(), '/form/') !== false ? 'display:none;' : ''?>">
				<form action="<?=LANGUAGE_ID=='ru' ? '/ru' :''?>/search/" method="get">
					<?/*<input type="text" placeholder="| Введіть текст" name="q">*/?>
					<input type="text" placeholder="|" name="q">
					<button class="header-search-form-btn">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M8.83194 1.93162C5.021 1.93162 1.93162 5.021 1.93162 8.83194C1.93162 12.6429 5.021 15.7323 8.83194 15.7323C12.6429 15.7323 15.7323 12.6429 15.7323 8.83194C15.7323 5.021 12.6429 1.93162 8.83194 1.93162ZM0 8.83194C0 3.95419 3.95419 0 8.83194 0C13.7097 0 17.6639 3.95419 17.6639 8.83194C17.6639 11.1132 16.799 13.1924 15.3792 14.7596L19.2619 18.6324L17.8978 20L13.9314 16.0438C12.491 17.0642 10.7315 17.6639 8.83194 17.6639C3.95419 17.6639 0 13.7097 0 8.83194Z" fill="#3D441D"/>
						</svg>
					</button>
				</form>
			</div>
		</div>
        <div class="inner-table-block nopadding small-block main_header_lk">
            <div class="wrap_icon wrap_cabinet">
                <?=CMax::ShowCabinetLink(true, false, 'big');?>
            </div>
        </div>
        <?
        $basket = getBasket();
        ?>
		<div class="header-right-icons">
			<a href="<?=LANGUAGE_ID == 'ru' ? '/ru' : ''?>/favorite/" class="header-icons-item empty favcounter">
				<span class="icon">
					<svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M16.761 1.01109C13.871 1.14109 11.641 3.78109 11.501 4.99109C11.321 3.39109 7.46095 -0.748911 3.25095 1.82109C1.36095 2.98109 0.920954 4.65109 1.01095 6.13109C1.12095 7.86109 1.99095 9.45109 3.27095 10.6011L11.501 18.0011L19.451 10.8511" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
					</svg>
				</span>
				<span class="counter">
					0
				</span>
			</a>
			<a href="<?=LANGUAGE_ID == 'ru' ? '/ru' : ''?>/basket/" class="header-icons-item headerbasket">
				<span class="icon">
					<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M20.5148 16.03L20.9849 19.62C21.085 20.35 20.5148 21 19.7646 21H3.23012C2.48991 21 1.90976 20.35 2.00978 19.62L3.59021 7.76001H14.4832" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10"/>
						<path d="M14.8632 3.38C14.3431 2.06 13.3628 1 11.5023 1C7.53125 1 7.53125 5.83 7.53125 7.76" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
					</svg>
				</span>
				<span class="counter">
					<?=$basket['TOTAL_KOM']?>
				</span>
			</a>
                <?/*<div class="wrap_icon wrap_cabinet main_header_lk_mobile">
                    <?=CMax::ShowCabinetLink(true, false, 'big');?>
                </div>*/?>
		</div>
	</div>
</div>
