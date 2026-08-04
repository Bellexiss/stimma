<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<?global $isHideLeftBlock, $arTheme;?>
<?
if(isset($arParams["TYPE_LEFT_BLOCK"]) && $arParams["TYPE_LEFT_BLOCK"]!='FROM_MODULE'){
	$arTheme['LEFT_BLOCK']['VALUE'] = $arParams["TYPE_LEFT_BLOCK"];
}

if(isset($arParams["SIDE_LEFT_BLOCK"]) && $arParams["SIDE_LEFT_BLOCK"]!='FROM_MODULE'){
	$arTheme['SIDE_MENU']['VALUE'] = $arParams["SIDE_LEFT_BLOCK"];
}
?>
<?
if(!$isHideLeftBlock && $APPLICATION->GetProperty("HIDE_LEFT_BLOCK_LIST") == "Y"){
	$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "Y");
}
?>
<?

if(isset($arParams["TYPE_HEAD_BLOCK"]) && $arParams["TYPE_HEAD_BLOCK"]=='FROM_MODULE'){
	if($arTheme["PROJECTS_SHOW_HEAD_BLOCK"]['VALUE'] == 'N'){
		$arParams['TYPE_HEAD_BLOCK'] = 'none';
	}else{
		$arParams['TYPE_HEAD_BLOCK'] = $arTheme["PROJECTS_SHOW_HEAD_BLOCK"]["DEPENDENT_PARAMS"]["SHOW_HEAD_BLOCK_TYPE"]['VALUE'];
	}
}
?>

<?$bIsHideLeftBlock = ($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") == "Y");?>

<?
// geting section items count and section [ID, NAME]
$arItemFilter = CMax::GetCurrentSectionElementFilter($arResult["VARIABLES"], $arParams);//$arResult["VARIABLES"]);
$arSectionFilter = CMax::GetCurrentSectionFilter($arResult["VARIABLES"], $arParams);

if($arParams['CACHE_GROUPS'] == 'Y')
{
	$arSectionFilter['CHECK_PERMISSIONS'] = 'Y';
	$arSectionFilter['GROUPS'] = $GLOBALS["USER"]->GetGroups();
}

$arSection = CMaxCache::CIblockSection_GetList(array("CACHE" => array("TAG" => CMaxCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "MULTI" => "N")), $arSectionFilter, false, array('ID', 'DESCRIPTION', 'PICTURE', 'DETAIL_PICTURE'), true);
/*CMax::AddMeta(
	array(
		'og:description' => $arSection['DESCRIPTION'],
		'og:image' => (($arSection['PICTURE'] || $arSection['DETAIL_PICTURE']) ? CFile::GetPath(($arSection['PICTURE'] ? $arSection['PICTURE'] : $arSection['DETAIL_PICTURE'])) : false),
	)
);*/

$bFoundSection = false;
$arYears = array();

if($arSection)
{
	$bFoundSection = true;
	$itemsCnt = CMaxCache::CIblockElement_GetList(array("CACHE" => array("TAG" => CMaxCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arItemFilter, array());
}


if($arParams['TYPE_HEAD_BLOCK']=='years')
{
	$arYears = CMax::GetItemsYear($arParams);
	if($arYears)
	{
		$current_year = current($arResult['VARIABLES']);
		if($current_year && $arYears[$current_year])
		{
			$bFoundSection = true;
			$GLOBALS[$arParams["FILTER_NAME"]] = array(
				">DATE_ACTIVE_FROM" => ConvertDateTime("01.01.".$current_year, "DD.MM.YYYY"),
				"<=DATE_ACTIVE_FROM" => ConvertDateTime("01.01.".(intval($current_year)+1), "DD.MM.YYYY"),
			);
			//$title_news = GetMessage('CURRENT_PROJECTS', array('#YEAR#' => $current_year));
		}
		$itemsCnt = 1;
	}
}?>

<?if(!$bFoundSection && $arParams['SET_STATUS_404'] !== 'Y'):?>
	<div class="alert alert-warning"><?=GetMessage("SECTION_NOTFOUND")?></div>
<?elseif(!$bFoundSection && $arParams['SET_STATUS_404'] === 'Y'):?>
	<?CMax::goto404Page();?>
<?else:?>

	<?$this->SetViewTarget('product_share');?>
		<?if($arParams['USE_RSS'] !== 'N'):?>
			<div class="colored_theme_hover_bg-block">
				<?=CMax::ShowRSSIcon(CComponentEngine::makePathFromTemplate($arResult['FOLDER'].$arResult['URL_TEMPLATES']['rss_section'], array_map('urlencode', $arResult['VARIABLES'])));?>
			</div>
		<?endif;?>
	<?$this->EndViewTarget();?>
	
	<?/* start tags */?>
	<?
	if(isset($arItemFilter['CODE']))
	{
		unset($arItemFilter['CODE']);
		unset($arItemFilter['SECTION_CODE']);
	}
	if(isset($arItemFilter['ID']))
	{
		unset($arItemFilter['ID']);
		unset($arItemFilter['SECTION_ID']);
	}
	?>
	<?
	$arTags = array();
	
	$arElements = CMaxCache::CIblockElement_GetList(array('CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'Y')), $arItemFilter, false, false, array('ID', 'TAGS'));

	foreach($arElements as $arElement)
	{
		if($arElement['TAGS'])
		{
			$arTags[] = explode(',', $arElement['TAGS']);
		}
	}
	?>
	<?$this->__component->__template->SetViewTarget('under_sidebar_content');?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:search.tags.cloud",
			"main",
			Array(
				"CACHE_TIME" => "86400",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "Y",
				"COLOR_NEW" => "3E74E6",
				"COLOR_OLD" => "C0C0C0",
				"COLOR_TYPE" => "N",
				"TAGS_ELEMENT" => $arTags,
				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"FONT_MAX" => "50",
				"FONT_MIN" => "10",
				"PAGE_ELEMENTS" => "150",
				"PERIOD" => "",
				"PERIOD_NEW_TAGS" => "",
				"SHOW_CHAIN" => "N",
				"SORT" => "NAME",
				"TAGS_INHERIT" => "Y",
				"URL_SEARCH" => SITE_DIR."search/index.php",
				"WIDTH" => "100%",
				"arrFILTER" => array("iblock_aspro_max_content"),
				"arrFILTER_iblock_aspro_max_content" => array($arParams["IBLOCK_ID"])
			), $component, array('HIDE_ICONS' => 'Y')
		);?>
	<?$this->__component->__template->EndViewTarget();?>
	<?/* end tags */?>
	
	<?if(!$itemsCnt):?>
		<div class="alert alert-warning"><?=GetMessage("SECTION_EMPTY")?></div>
	<?endif;?>
	<?if($arParams['TYPE_HEAD_BLOCK']=='sections_mix' || $arParams['TYPE_HEAD_BLOCK']=='years_mix'):?>
		<div class="mixitup-container">
	<?endif;?>
	<?if($arParams['TYPE_HEAD_BLOCK']=='years_links'){
		$useDateLink = true;
	}?>
	<?@include_once('include/head_block.php');?>
	<?$sViewElementsTemplate = ($arParams["SECTION_ELEMENTS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["PROJECTS_PAGE"]["VALUE"] : $arParams["SECTION_ELEMENTS_TYPE_VIEW"]);?>

<?
    $ru=LANGUAGE_ID=='ru'?'/ru':'';
    ?>
    <div class="breadcrumbs-cont">
        <div class="wrapper">
            <div class="breadcrumbs-block">
                <a href="<?=$ru?>/" class="breadcrumb-item">
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

<?
$sections=[];
    $res = CIBlockSection::GetList(['SORT'=>'asc'],['IBLOCK_ID'=>$arParams['IBLOCK_ID'],'ACTIVE'=>'Y','GLOBAL_ACTIVE'=>'Y'],false,['ID','NAME','CODE','SECTION_PAGE_URL','UF_*']);;
    ?>

    <div class="info-page-content media-prog-page">
        <div class="info-page-menu info-page-menu-around">
            <?
            while ($section = $res->GetNext())
            {
                $active =strpos($APPLICATION->GetCurPage(),'/projects/'.$section['CODE'].'/')!==false?'active':'';
                ?>
                <a href="<?=LANGUAGE_ID == 'ru' ? '/ru' : ''?><?='/projects/'.$section['CODE'].'/'?>" class="info-page-menu-item <?=$active?>">
                    <?=LANGUAGE_ID=='ua'?$section['NAME']:$section['UF_NAME_RU']?>
                </a>
                <?
            }
            ?>

        </div>
    </div>

    <?$sViewElementsTemplate='list_elements_1';?>
	<?@include_once('page_blocks/'.$sViewElementsTemplate.'.php');?>
	<?if($arParams['TYPE_HEAD_BLOCK']=='sections_mix' || $arParams['TYPE_HEAD_BLOCK']=='years_mix'):?>
		</div>
	<?endif;?>
<?endif;?>
		    
<?if($arYears && $bFoundSection)
{			
	//$APPLICATION->SetTitle($title_news);
	//$APPLICATION->AddChainItem($title_news);
}?>