<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc,
	  \Bitrix\Main\Web\Json;?>
<?
$res = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $arParams['SECTION_ID']], false, ['ID','IBLOCK_ID','NAME','UF_*']) -> Fetch();
$sectionName = LANGUAGE_ID == 'ua' ? $res['UF_NAME_UA'] : $res['NAME'];


$arJsonProducts = [];
?>
<?$universalID = 'id_'.uniqid()?>
<?$variants = []?>
<?$isNew = $arParams['IS_NEW'];?>
<?$data = $arParams['DATA']?>
<?

?>
<?$gGroups = explode(',',$USER -> GetGroups());?>
<?

$selected = 0;
$available = true; //$arItem['PRODUCT']['AVAILABLE']; //todo змінити
//$availableTextIn = GetMessage('EX_IN_STORE ');
//$availableTextOut = GetMessage('NO_EX_IN_STORE ');
$tree = $arResult['TREE_PROPS'];


foreach ($arResult['ITEMS'] as $key => $arItem)
{
    showItem($arItem, $arParams);
}

?>
<?/*<div class="<?=$arParams['WRAP_CLASS'] ? $arParams['WRAP_CLASS'] : 'catalog-items-block'?>">
    <?
    foreach ($arResult['ITEMS'] as $index => $arItem)
    {
        showItem($arItem, $arParams);
    }
    ?>
</div>*/?>
