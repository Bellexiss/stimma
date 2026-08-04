<?
global $arTheme, $arRegion;
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
?>
<div class="maxwidth-theme">
	<div class="logo-row v2 row margin0 menu-row">

		<?/*if($arTheme['HEADER_TYPE']['VALUE'] != 29):?>
			<div class="burger inner-table-block"><?=CMax::showIconSvg("burger dark", SITE_TEMPLATE_PATH."/images/svg/burger.svg");?></div>
		<?endif;*/?>

		<?/*if($arTheme['HEADER_TYPE']['VALUE'] != 28 && $arTheme['HEADER_TYPE']['VALUE'] != 29):?>
			<div class="inner-table-block nopadding logo-block">
				<div class="logo<?=$logoClass?>">
					<?=CMax::ShowLogoFixed();?>
				</div>
			</div>
		<?endif;*/?>
		<div class="inner-table-block menu-block">
			<div class="navs table-menu js-nav">
				<?if(CMax::nlo('menu-fixed')):?>
				<!-- noindex -->
				<nav class="mega-menu sliced">
					<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
						array(
							"COMPONENT_TEMPLATE" => ".default",
							"PATH" => SITE_DIR."include/menu/menu.top.php",
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "",
							"AREA_FILE_RECURSIVE" => "Y",
							"EDIT_TEMPLATE" => "include_area.php"
						),
						false, array("HIDE_ICONS" => "Y")
					);?>
				</nav>
				<!-- /noindex -->
				<?endif;?>
				<?CMax::nlo('menu-fixed');?>
			</div>
		</div>
		<div class=" inner-table-block">
			<div class="header-menu-language-switch">
                <?
                $pageUrl = isset($_SERVER['NEW_URL']) ? $_SERVER['NEW_URL'][3] : $APPLICATION->GetCurPage();
                $page = str_replace('/ru/','/',$pageUrl);
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
		<div class=" inner-table-block">
			<div class="wrap_icon">
				<button class="top-btn inline-search-show ">
					<?=CMax::showIconSvg("search", SITE_TEMPLATE_PATH."/images/svg/Search.svg");?>
				</button>
			</div>
		</div>
		<div class="inner-table-block nopadding small-block">
			<div class="wrap_icon wrap_cabinet">
				<?=CMax::ShowCabinetLink(true, false, 'big');?>
			</div>
		</div>


        <?
        $basket = getBasket();
        ?>
        <div class="inner-table-block">
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
	        </div>
        </div>
		<?//=CMax::ShowBasketWithCompareLink('inner-table-block', 'big');?>
	</div>
</div>