<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/uf_values.php'))
    require $_SERVER['DOCUMENT_ROOT'].'/upload/uf_values.php';
// $values_ua
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";
foreach($arResult["ITEMS"] as $key => $arItem)
{
    if(isset($values_ua['names'][$arItem['IBLOCK_ID']][$arItem['CODE']]))
        $arResult["ITEMS"][$key]['NAME'] = $values_ua['names'][$arItem['IBLOCK_ID']][$arItem['CODE']];
	/*unset empty values*/
	if (
		(
		 ($arItem["DISPLAY_TYPE"] == "A" || isset($arItem["PRICE"]))
		 && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
		)
		|| !$arItem["VALUES"]
	)
		unset($arResult["ITEMS"][$key]);
	/**/
	
	if($arItem["CODE"]=="IN_STOCK"){
		if(is_array($arResult["ITEMS"][$key]["VALUES"]))
			sort($arResult["ITEMS"][$key]["VALUES"]);
		
		if($arResult["ITEMS"][$key]["VALUES"])
			$arResult["ITEMS"][$key]["VALUES"][0]["VALUE"]=$arItem["NAME"];
	}

    if($arItem['PROPERTY_TYPE'] == 'S' || $arItem['PROPERTY_TYPE'] == 'L' || $arItem['PROPERTY_TYPE'] == 'E'){
        foreach($arItem['VALUES'] as $key2 => $arValue){
            if(isset($values_ua[$arItem['IBLOCK_ID']][$arItem['CODE']][mb_strtolower($arValue['URL_ID'])]))
                $arResult["ITEMS"][$key]['VALUES'][$key2]['VALUE'] = $values_ua[$arItem['IBLOCK_ID']][$arItem['CODE']][mb_strtolower($arValue['URL_ID'])];
        }
    }
}

\Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);

if (!$arResult['ITEMS']) {
	$arResult['EMPTY_ITEMS'] = true;
}

// sort
if ($arParams['SHOW_SORT']) {
	include 'sort.php';
}

global $sotbitFilterResult;
$sotbitFilterResult = $arResult;