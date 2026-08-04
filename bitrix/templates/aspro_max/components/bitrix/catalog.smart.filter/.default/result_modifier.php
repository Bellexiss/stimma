<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult['ITEMS'] as $index => $ITEM)
{
    if($ITEM['CODE'] == 'COLOR_REF' || $ITEM['CODE'] == 'MATERIAL' || $ITEM['CODE'] == 'DISCOUNT')
    {
        unset($arResult['ITEMS'][$index]);
    }
}
if(LANGUAGE_ID == 'ua')
{
    //if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/uf_values.php'))
    //    require $_SERVER['DOCUMENT_ROOT'].'/upload/uf_values.php';

    //$res = $DB -> Query('select * from max_color_reference');
    $res = $DB -> Query('select * from main_colors');
    while ($record = $res -> Fetch())
        $colors[$record['UF_XML_ID']] = $record;

    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php'))
        require $_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php';

    // $values_ua
    foreach($arResult["ITEMS"] as $key => $arItem)
    {

        if($arItem['CODE'] == 'COLOR')
            $arResult["ITEMS"][$key]['NAME'] = 'Колір';

        if(isset($name_ua[$arItem['CODE']]['name_ua']))
            $arResult["ITEMS"][$key]['NAME'] = $name_ua[$arItem['CODE']]['name_ua'];
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

        if($arItem['PROPERTY_TYPE'] == 'S' || $arItem['PROPERTY_TYPE'] == 'L' || $arItem['PROPERTY_TYPE'] == 'E')
        {

            foreach($arItem['VALUES'] as $key2 => $arValue)
            {
                if($arItem['CODE'] == 'COLOR')
                {
                    $arResult["ITEMS"][$key]['VALUES'][$key2]['VALUE'] = $colors[mb_strtolower($arValue['URL_ID'])]['UF_NAME_UA'];
                }
                elseif(isset($name_ua[$arItem['CODE']]['values'][mb_strtolower($arValue['URL_ID'])]))
                    $arResult["ITEMS"][$key]['VALUES'][$key2]['VALUE'] = $name_ua[$arItem['CODE']]['values'][mb_strtolower($arValue['URL_ID'])];
            }

        }
    }

}


if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
	$arAvailableThemes = array();
	$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
	if (is_dir($dir) && $directory = opendir($dir))
	{
		while (($file = readdir($directory)) !== false)
		{
			if ($file != "." && $file != ".." && is_dir($dir.$file))
				$arAvailableThemes[] = $file;
		}
		closedir($directory);
	}

	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
		if ($solution == "eshop")
		{
			$templateId = COption::GetOptionString("main", "wizard_template_id", "eshop_bootstrap", SITE_ID);
			$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? "eshop_adapt" : $templateId;
			$theme = COption::GetOptionString("main", "wizard_".$templateId."_theme_id", "blue", SITE_ID);
			$arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
		}
	}
	else
	{
		$arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
	}
}
else
{
	$arParams["TEMPLATE_THEME"] = "blue";
}

$arParams["FILTER_VIEW_MODE"] = (isset($arParams["FILTER_VIEW_MODE"]) && toUpper($arParams["FILTER_VIEW_MODE"]) == "HORIZONTAL") ? "HORIZONTAL" : "VERTICAL";
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";
