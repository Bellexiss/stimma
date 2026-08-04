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

preg_match('/\/([a-z0-9-_]+)\/([a-z0-9-_]+-[0-9]+)\/$/',$APPLICATION->GetCurPage(),$matches);
//if(isset($_GET['clear_cache']))
{
    if($matches[1] && $matches[2])
    {

        $find = $DB->Query('select * from b_iblock_element where CODE = \''.$matches[2].'\'');
        if($find = $find->Fetch())
        {
            $section = $DB->Query('select * from b_iblock_section where ID = \''.$find['IBLOCK_SECTION_ID'].'\'');
            if($section = $section->Fetch())
            {
                if($matches[1] != $section['CODE'])
                {
                    Bitrix\Iblock\Component\Tools::process404(
                        'Не найден', //Сообщение
                        true, // Нужно ли определять 404-ю константу
                        true, // Устанавливать ли статус
                        true, // Показывать ли 404-ю страницу
                        false // Ссылка на отличную от стандартной 404-ю
                    );
                }
            }
        }
        else
        {
            Bitrix\Iblock\Component\Tools::process404(
                'Не найден', //Сообщение
                true, // Нужно ли определять 404-ю константу
                true, // Устанавливать ли статус
                true, // Показывать ли 404-ю страницу
                false // Ссылка на отличную от стандартной 404-ю
            );
        }
    }
}
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
else
{
    if(LANGUAGE_ID == 'ru')
    {
        $dataSeo = $APPLICATION->IncludeComponent(
            "dwstroy:dwstroy.seo.section",
            "",
            Array(
                "SECTION_ID" => $arResult['VARIABLES']['SECTION_ID'], //Ид раздела
                "IBLOCK_ID" => $arParams['IBLOCK_ID'], //Ид инфоблока
                "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'], //Код типа инфоблока
                "LANG_ID" => 'ru', //Код вкладки
                "SET_BROWSER_TITLE" => "Y",//Установить title
                "SET_META_DESCRIPTION" => "Y",//Установить description
                "SET_META_KEYWORDS" => "Y",//Установить keywords
                "SET_TITLE" => "Y", //Установить h1
                "TYPE" => "1" // ID вкладка ровна домену сайта
            )
        );

        //$dataSeo['ELEMENT_PAGE_TITLE'] = $dataSeo['SECTION_PAGE_TITLE'];
        //$dataSeo['ELEMENT_META_TITLE'] = $dataSeo['SECTION_META_TITLE'];
        //$dataSeo['ELEMENT_META_DESCRIPTION'] = $dataSeo['SECTION_META_DESCRIPTION'];
    }
    else
    {
        $dataSeo = $ipropSectionValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams['IBLOCK_ID'], $arResult['VARIABLES']['SECTION_ID']);
        $dataSeo = $dataSeo->getValues();

        //$dataSeo['ELEMENT_PAGE_TITLE'] = $dataSeo['SECTION_PAGE_TITLE'];
        //$dataSeo['ELEMENT_META_TITLE'] = $dataSeo['SECTION_META_TITLE'];
        //$dataSeo['ELEMENT_META_DESCRIPTION'] = $dataSeo['SECTION_META_DESCRIPTION'];
    }
}

$this->setFrameMode(true);
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");
if(isset($_GET['pp']))
{
    ?><pre><?=print_r($dataSeo, 1)?></pre><?
}
if(!isset($_GET['ll']))
{
    ?>
    <style>
        .intoppage{display:none !important;}
    </style>
    <?
}
if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
{
    $ua = LANGUAGE_ID == 'ua';
    $url = (!$ua ? '/ru' : '').'/catalog/';
    $nav = CIBlockSection::GetNavChain(false, $arResult["VARIABLES"]["SECTION_ID"]);
    while($record = $nav->Fetch())
    {
        $sectionFind = CIBlockSection::GetList([], ['ID' => $record['ID'], 'IBLOCK_ID' => 21],false, ['ID','IBLOCK_ID','CODE', 'UF_*', 'NAME']) -> Fetch();
        $name = $ua ? $sectionFind['UF_NAME_UA'] : $sectionFind['NAME'];
        $url .= $sectionFind['CODE'].'/';
    }
    $APPLICATION->AddChainItem($name, $url);
}


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
<?
if ($isVerticalFilter)
	include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_vertical.php");
else
	include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_horizontal.php");

global $canonical;
if(isset($_SERVER['REAL_URL']))
    $canonical='https://www.stimma.com.ua'.str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REAL_URL']);
else
    $canonical='https://www.stimma.com.ua'.$APPLICATION->GetCurPage();

?>
