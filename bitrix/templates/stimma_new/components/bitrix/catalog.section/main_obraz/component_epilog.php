<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
?>


<?
//global $maxNUmbers;
//$maxNUmbers = $arResult['NAV_RESULT'] -> NavPageCount;

/*global $dataSeo;
if(LANGUAGE_ID == 'ru')
    {
        $dataSeo = $APPLICATION->IncludeComponent(
            "dwstroy:dwstroy.seo.section",
            "",
            Array(
                "SECTION_ID" => $arParams['SECTION_ID'], //Ид раздела
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


    }
else
{
    $dataSeo = $ipropSectionValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams['IBLOCK_ID'], $arParams['SECTION_ID']);
    $dataSeo = $dataSeo->getValues();
}*/
?>
