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
$this->setFrameMode(true);

$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if (0 < $arResult["SECTIONS_COUNT"])
{
?>
<div class="catalog-category-cont">

<?
foreach ($arResult['SECTIONS'] as &$arSection)
{
    if($arSection['IBLOCK_SECTION_ID'] != $arParams['SECTION_ID']) continue;

    if(LANGUAGE_ID == 'ua')
    {
        $section = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arSection['ID']], false,
                                            ['ID','IBLOCK_ID', 'NAME' ,'UF_*']) -> Fetch();
        if($section['UF_NAME_UA'])
            $section = $section['UF_NAME_UA'];
        else
            $section = $section['NAME'];

        $arSection['NAME'] = $section;
    }

    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
    if (false === $arSection['PICTURE'])
        $arSection['PICTURE'] = array(
            'SRC' => $arCurView['EMPTY_IMG'],
            'ALT' => (
            '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                : $arSection["NAME"]
            ),
            'TITLE' => (
            '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                : $arSection["NAME"]
            )
        );

    ?>
    <div class="catalog-category-item-cont" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
        <div class="catalog-category-item">
            <div class="catalog-category-item-img">
                <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
                    <img src="<? echo $arSection['PICTURE']['SRC']; ?>" title="<? echo $arSection['PICTURE']['TITLE']; ?>" alt="<? echo $arSection['PICTURE']['ALT']; ?>">
                </a>
                <div class="catalog-category-item-name">
                    <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>"><?=$arSection['NAME']?></a>
                </div>
            </div>
        </div>
    </div>
    <?
}

?>
</div>
<?
}
