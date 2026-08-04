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
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
global $seo;
$seo = false;

if(isset($_SERVER['ELEMENT_ID']) && $_SERVER['ELEMENT_ID'] > 0)
{
    //$seo = CIBlockElement::GetByID($_SERVER['ELEMENT_ID'])->Fetch();
    //$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(40,$_SERVER['ELEMENT_ID']);
    if(LANGUAGE_ID == 'ua')
    {
        $ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues(40,$_SERVER['ELEMENT_ID']);
        $seo  = $ipropValues->getValues();
    }
    else
    {
        $seo = $APPLICATION->IncludeComponent(
            "dwstroy:dwstroy.seo.element",
            "",
            Array(
                "ELEMENT_ID" => $_SERVER['ELEMENT_ID'], //Ид товара(элемента) инфоблока
                "IBLOCK_ID" => 40, //Ид инфоблока
                "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'], //Код типа инфоблока
                "LANG_ID" => LANGUAGE_ID, //Код вкладки
                "SET_BROWSER_TITLE" => "N", //Установить title
                "SET_META_DESCRIPTION" => "N", //Установить description
                "SET_META_KEYWORDS" => "N", //Установить keywords
                "SET_TITLE" => "N", //Установить h1
                "TYPE" => "1" // Если домен равен ID вкладки
            )
        );
    }
}

$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");
?>
<style>
    .intoppage{display:none !important;}
</style>
<?
if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');

if ($isFilter)
{
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);
	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
	{
		$arCurSection = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		$arCurSection = array();
		if (Loader::includeModule("iblock"))
		{
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurSection = $dbRes->Fetch())
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurSection = $dbRes->Fetch())
					$arCurSection = array();
			}
		}
		$obCache->EndDataCache($arCurSection);
	}
	if (!isset($arCurSection))
		$arCurSection = array();
}
?>
<div class="row">
<?

if ($isVerticalFilter)
	include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_vertical.php");
else
	include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_horizontal.php");
?>
</div>