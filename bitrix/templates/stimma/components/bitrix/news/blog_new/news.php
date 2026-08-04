<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?// intro text?>
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
<?$bIsHideLeftBlock = ($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") == "Y");?>

<div class="text_before_items"><?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "inc",
			"EDIT_TEMPLATE" => ""
		)
	);?></div>
<?
$arItemFilter = CMax::GetIBlockAllElementsFilter($arParams);

if($arParams['CACHE_GROUPS'] == 'Y')
{
	$arItemFilter['CHECK_PERMISSIONS'] = 'Y';
	$arItemFilter['GROUPS'] = $GLOBALS["USER"]->GetGroups();
}

$itemsCnt = CMaxCache::CIblockElement_GetList(array("CACHE" => array("TAG" => CMaxCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arItemFilter, array());?>

<?if(!$itemsCnt):?>
	<div class="alert alert-warning"><?=GetMessage("SECTION_EMPTY")?></div>
<?else:?>

	<?$this->SetViewTarget('product_share');?>
		<?if($arParams['USE_RSS'] !== 'N'):?>
			<div class="colored_theme_hover_bg-block">
				<?=CMax::ShowRSSIcon($arResult['FOLDER'].$arResult['URL_TEMPLATES']['rss']);?>
			</div>
		<?endif;?>
	<?$this->EndViewTarget();?>

	<?
	$arAllSections = $aMenuLinksExt = [];
	$arSections = CMaxCache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N', 'URL_TEMPLATE' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'])), array_merge($arItemFilter, array(/*'<=DEPTH_LEVEL' => 2,*/ 'CNT_ACTIVE' => "Y")), false, array('ID', 'SECTION_PAGE_URL', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID'));
	$arSectionsByParentSectionID = CMaxCache::GroupArrayBy($arSections, array('MULTI' => 'Y', 'GROUP' => array('IBLOCK_SECTION_ID')));
	if ($arSections) {
		CMax::getSectionChilds(false, $arSections, $arSectionsByParentSectionID, $arItemsBySectionID, $aMenuLinksExt, true);
	}
	
	$arAllSections = CMax::getChilds2($aMenuLinksExt);
	
	if (isset($arItemFilter['CODE'])) {
		unset($arItemFilter['CODE']);
		unset($arItemFilter['SECTION_CODE']);
	}
	if (isset($arItemFilter['ID'])) {
		unset($arItemFilter['ID']);
		unset($arItemFilter['SECTION_ID']);
	}
	?>
	<?
	$arTags = array();
	if ($arAllSections) {
		foreach ($arAllSections as $key => $arSection) {
			$arElements = CMaxCache::CIblockElement_GetList(array('CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'Y')), array_merge($arItemFilter, array("SECTION_ID" => $arSection["PARAMS"]["ID"], "INCLUDE_SUBSECTIONS" => "Y")), false, false, array('ID', 'TAGS'));
			if (!$arElements) {
				unset($arAllSections[$key]);
			} else {
				foreach ($arElements as $arElement) {
					if ($arElement['TAGS']) {
						$arTags[] = explode(',', $arElement['TAGS']);
					}
				}
				$arAllSections[$key]['ELEMENT_COUNT'] = count($arElements);
			}
		}
	} else {
		$arElements = CMaxCache::CIblockElement_GetList(array('CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'Y')), $arItemFilter, false, false, array('ID', 'TAGS'));

		foreach ($arElements as $arElement) {
			if ($arElement['TAGS']) {
				$arTags[] = explode(',', $arElement['TAGS']);
			}
		}
	}
	?>



	<?// section elements?>
	<?if((isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") || (strtolower($_REQUEST['ajax']) == 'y'))
	{
		$APPLICATION->RestartBuffer();
	}?>
	<?$sViewElementsTemplate = ($arParams["SECTION_ELEMENTS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["BLOG_PAGE"]["VALUE"] : $arParams["SECTION_ELEMENTS_TYPE_VIEW"]);?>
	<?@include_once('page_blocks/'.$sViewElementsTemplate.'.php');?>

	<?if((isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") || (strtolower($_REQUEST['ajax']) == 'y'))
	{
		die();
	}?>
<?endif;?>
