<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arDefaultParams = array(
	'TYPE_SKU' => 'N',
	'FILTER_HIT_PROP' => 'block',
	'OFFER_TREE_PROPS' => array('-'),
);
foreach($arResult['ITEMS'] as $index => $arItem)
{
    foreach($arItem['OFFERS'] as $indexs => $arOffer)
    {
        if(!$arOffer['CATALOG_QUANTITY'])
        {
            unset($arResult['ITEMS'][$index]['OFFERS'][$indexs]);
        }
    }
    $arResult['ITEMS'][$index]['OFFERS'] = array_values($arResult['ITEMS'][$index]['OFFERS']);
}

$arParams = array_merge($arDefaultParams, $arParams);

$isNew = $arParams['IS_NEW'];

$alLColors = $alLColorsIDs = $alLMainColors = [];
$res = $DB -> Query('select * from max_color_reference');
while ($record = $res -> Fetch())
{
    $alLColors[$record['UF_XML_ID']] = $record['UF_COLOR_CODE'];
    $alLColorsIDs[$record['ID']] = $record['UF_COLOR_CODE'];
}
$arResult['ALL_COLORS'] = $alLColors;

$res = $DB -> Query('select * from main_colors');
while ($record = $res -> Fetch())
{
    $record['UF_COLORS'] = unserialize($record['UF_COLORS'], ['allowed_classes' => false]);
    $alLMainColors[$record['UF_XML_ID']] = $record['UF_CODE_COLOR'];
}
$arResult['ALL_MAIN_COLORS'] = $alLMainColors;

$colorVariants = $noId = $Ids = $json = [];

if(LANGUAGE_ID == 'ua')
{
    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/uf_values.php'))
        require $_SERVER['DOCUMENT_ROOT'].'/upload/uf_values.php';
    foreach ($arResult['ITEMS'] as $index => $arItem)
    {
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['color'] = $arItem['PROPERTIES']['COLOR']['VALUE'];
        $noId[$arItem['ID']] = $arItem['ID'];
        $Ids[$arItem['ID']] = $arItem['NAME'];

        if($arItem['PROPERTIES']['NAME_UA']['VALUE']) $arResult['ITEMS'][$index]['NAME'] = $arItem['PROPERTIES']['NAME_UA']['VALUE'];
        if($arItem['PROPERTIES']['NAME_UA']['VALUE']) $arResult['ITEMS'][$index]['~NAME'] = $arItem['PROPERTIES']['NAME_UA']['VALUE'];
        if($arItem['PROPERTIES']['DETAIL_TEXT_UA']['VALUE']['TEXT']) $arResult['ITEMS'][$index]['DETAIL_TEXT'] = $arItem['PROPERTIES']['DETAIL_TEXT_UA']['VALUE']['TEXT'];
        foreach ($arItem['PROPERTIES'] as $indexProp => $arItemProp)
        {
            if(isset($arItemProp['VALUE_XML_ID'])|| $arItemProp['CODE'] == 'COLOR_REF')
            {
                $result = changeValue($arItemProp['IBLOCK_ID'], $arItemProp["CODE"], $arItemProp['VALUE_XML_ID'], $values_ua);
                if($result['values'] && $result['name'])
                {
                    $arResult['ITEMS'][$index]['PROPERTIES'][$indexProp]['VALUE'] = $result['values'];
                    $arResult['ITEMS'][$index]['PROPERTIES'][$indexProp]['NAME'] = $result['name'];
                }

            }
        }
        foreach ($arItem['OFFERS'] as $indexOffer => $offer)
        {
            foreach ($offer['PROPERTIES'] as $indexProp => $arItemProp)
            {
                if(isset($arItemProp['VALUE_XML_ID']) || $arItemProp['CODE'] == 'COLOR_REF')
                {
                    $result = changeValue($arItemProp['IBLOCK_ID'], $arItemProp["CODE"], $arItemProp['VALUE_XML_ID'], $values_ua);
                    if($result['values'] && $result['name'])
                    {
                        $arResult['ITEMS'][$index]['OFFERS'][$indexOffer]['PROPERTIES'][$indexProp]['VALUE'] = $result['values'];
                        $arResult['ITEMS'][$index]['OFFERS'][$indexOffer]['PROPERTIES'][$indexProp]['NAME'] = $result['name'];
                    }

                }
            }
        }

        $item = $arItem['OFFERS'][0];
        $img = $item['DETAIL_PICTURE']['ID'];

        if(!$img)
            $img = $item['PREVIEW_PICTURE'];

        if(!$img)
            $img = $arItem['DETAIL_PICTURE'];
        if(!$img)
            $img = $arItem['PREVIEW_PICTURE'];

        $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $minPrice = $item['MIN_PRICE'];

        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['img'] = $img;
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['price'] = $minPrice;
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['code'] = $arItem['CODE'];
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['name'] = $arItem['NAME'];
    }
}
else
{
    foreach ($arResult['ITEMS'] as $index => $arItem)
    {
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['color'] = $arItem['PROPERTIES']['COLOR']['VALUE'];
        $noId[$arItem['ID']] = $arItem['ID'];
        $Ids[$arItem['ID']] = $arItem['NAME'];

        $item = $arItem['OFFERS'][0];
        $img = $item['DETAIL_PICTURE']['ID'];

        if(!$img)
            $img = $item['PREVIEW_PICTURE'];

        if(!$img)
            $img = $arItem['DETAIL_PICTURE'];
        if(!$img)
            $img = $arItem['PREVIEW_PICTURE'];

        $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $minPrice = $item['MIN_PRICE'];

        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['img'] = $img;
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['price'] = $minPrice;
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['code'] = $arItem['CODE'];
        $colorVariants[$arItem['NAME']][$arItem['PROPERTIES']['COLOR']['VALUE']]['name'] = $arItem['NAME'];
    }
}

if (!empty($colorVariants))
{
    $filter = ['IBLOCK_ID' => 21, 'NAME' => array_keys($colorVariants), "!ID" => $noId,'ACTIVE' => 'Y'];
    $res = CIBlockElement::GetList([], $filter, false, false, ['ID','IBLOCK_ID','PROPERTY_COLOR','NAME','PREVIEW_PICTURE','DETAIL_PICTURE','CODE']);
    while ($record = $res -> Fetch())
    {
        $colorVariants[$record['NAME']][$record['PROPERTY_COLOR_VALUE']]['color'] = $record['PROPERTY_COLOR_VALUE'];

        $img = $record['PREVIEW_PICTURE'];
        if(!$img)
            $img = $record['DETAIL_PICTURE'];

        $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $minPrice = CCatalogProduct::GetOptimalPrice($record['ID']);

        $colorVariants[$record['NAME']][$record['PROPERTY_COLOR_VALUE']]['img'] = $img;
        $colorVariants[$record['NAME']][$record['PROPERTY_COLOR_VALUE']]['price'] = $minPrice;
        $colorVariants[$record['NAME']][$record['PROPERTY_COLOR_VALUE']]['code'] = $record['CODE'];
        $colorVariants[$record['NAME']][$record['PROPERTY_COLOR_VALUE']]['name'] = $record['NAME'];
    }
}

$arResult['COLOR_VARIANTS'] = $colorVariants;

$arResult['COLOR_IDS'] = $Ids;

$offerTreeProps = $arParams['OFFER_TREE_PROPS'];
foreach ($offerTreeProps as $index => $offerTreeProp)
    if(!$offerTreeProp) unset($offerTreeProps[$index]);
$items = $arResult['ITEMS'];
$tree = $colors = $fileColors = $ids = $jsData = [];

$res = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => 25, 'CODE' => 'RAZMER']);
$sortingSizes = [];
while ($record = $res -> Fetch())
{
    $sortingSizes[mb_strtoupper($record['VALUE'])] = $record['SORT'];
}
$arResult['SORTING_SIZES'] = $sortingSizes;

if(!empty($colors))
{
    $res = $DB -> Query('select * from max_color_reference where UF_XML_ID in ("'.implode('","', $colors).'")');
    while ($record = $res -> Fetch())
    {
        $colors[$record['UF_XML_ID']] =
            LANGUAGE_ID == 'ua' && $record['UF_NAME_UA'] ?
                $record['UF_NAME_UA'] :
                $record['UF_NAME'];
        $fileColors[$record['UF_XML_ID']] = $record['UF_FILE'] ? $record['UF_FILE'] : '';
    }
}
$arResult['TREE_PROPS'] = $tree;
$arResult['FILE_COLORS'] = $fileColors;

$cp = $this->__component;
$cp->SetResultCacheKeys( array('NAV_RESULT') );

$res = CIBlockSection::GetList(
    array(),
    array(
        'IBLOCK_ID' => 35,
        'UF_PRODUCT' => $ids,
    ),
    false,
    array('ID','IBLOCK_ID','UF_*')
);
while ($record = $res -> Fetch())
{
    $r1 = intval($record['UF_RATING_1'])*1;
    $r2 = intval($record['UF_RATING_2'])*2;
    $r3 = intval($record['UF_RATING_3'])*3;
    $r4 = intval($record['UF_RATING_4'])*4;
    $r5 = intval($record['UF_RATING_5'])*5;

    $sumRatings = intval($record['UF_RATING_1'])+intval($record['UF_RATING_2'])+intval($record['UF_RATING_3'])+intval($record['UF_RATING_4'])+intval($record['UF_RATING_5']);
    if(!$sumRatings)
        $arResult['AVERAGE'][$record['UF_PRODUCT']] = 0;
    else
        $arResult['AVERAGE'][$record['UF_PRODUCT']] = round(($r1+$r2+$r3+$r4+$r5)/$sumRatings,1);
}
$relation = [];
foreach ($arResult['ITEMS'] as $index => $arItem)
{
    $relation[$arItem['ID']] = $arItem;
}

$arResult['RELATION'] = $relation;


function showItem($arItem, $arParams)
{
    if(empty($arItem['OFFERS'])) return '';
    global $USER, $APPLICATION;
    if(LANGUAGE_ID == 'ru' && strpos($arItem['DETAIL_PAGE_URL'], '/ru/') === false)
        $arItem['DETAIL_PAGE_URL'] = '/ru'.$arItem['DETAIL_PAGE_URL'];

    $dopClass = 'w-25';
    $img = false;

    {
        if(1)
        {
            $item = $arItem['OFFERS'][0];
            if(!$img) $img = $item['DETAIL_PICTURE']['ID'];
            if(!$img) $img = $item['PREVIEW_PICTURE'];
            if(!$img) $img = $arItem['DETAIL_PICTURE'];
            if(!$img) $img = $arItem['PREVIEW_PICTURE'];
        }

        if(isset($img['ID'])) $img = $img['ID'];

        $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];

        $minPrice = $item['MIN_PRICE'];
        ?>


        <div class="<?=$arParams['DOP_CLASS'] ? $arParams['DOP_CLASS'] : 'look-dop-item'?>" data-entity="scu" data-item="<?=$arItem['ID']?>" offer-item="<?=$arItem['OFFERS'][0]['ID']?>">
            <div class="catalog-item">
                <div class="catalog-item-top">
                    <div class="catalog-item-img">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" tabindex="0">
                            <img src="<?=$img?>">
                        </a>
                    </div>
                    <div class="catalog-item-favorite">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" tabindex="0" data-id="<?=$arItem['ID']?>">
                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="catalog-item-more-info">
                        <div class="catalog-item-btn-buy">
                            <a href="#" tabindex="0" data-id="<?=$arItem['OFFERS'][$arItem['OFFER_ID_SELECTED']]['ID']?>">
                                Додати до кошика
                            </a>
                        </div>
                        <div class="catalog-item-size-list" data-code="RAZMER">
                            <?
                            $sizes = [];
                            foreach ($arItem['OFFERS'] as $indexOFfer => $offer)
                                $sizes[$arItem['SORTING_SIZES'][mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE'])]] = mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE']);
                            ksort($sizes);
                            foreach ($sizes as $indexOFfer => $offer)
                            {
                                // todo if not available then add class no-size
                                $cSize=str_replace('_','-',mb_strtoupper($arItem['OFFERS'][$arItem['OFFER_ID_SELECTED']]['PROPERTIES']['RAZMER']['VALUE']));
                                ?>
                                <label data-entity="scu-value" data-csize="<?=$cSize?>" data-id="<?=$offer?>" class="<?=$offer==$cSize? 'active':''?>">
                                    <input type="radio" name="radio2" tabindex="0" <?=!$indexOFfer ? 'checked' : ''?> data-entity="scu-value" data-id="<?=$offer['ID']?>">
                                    <span class="catalog-item-size"><?=mb_strtoupper($offer)?></span>
                                </label>
                                <?
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="catalog-item-info">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="catalog-item-name" tabindex="0">
                        <?=$arItem['NAME']?>
                    </a>
                    <div class="catalog-item-details">
                        <div class="catalog-item-price-block">
                            <div class="catalog-item-price" data-entity="price">
                                <?
                                $minPrice['DISCOUNT_DIFF_PERCENT'] = $minPrice['DISCOUNT_DIFF'] = 0;
                                if(!$arParams['IS_NEW'] && !$arParams['IS_SALE'])
                                {
                                    $gGroups = explode(',',$USER -> GetGroups());
                                    if(in_array(9,$gGroups) && $item['PRICES']['DISCOUNT']) $item['PRICES']['BASE'] = $item['PRICES']['DISCOUNT'];
                                    elseif(in_array(9,$gGroups) && $item['PRICES']['OPT']) $item['PRICES']['BASE'] = $item['PRICES']['OPT'];
                                }

                                if($item['PRICES']['BASE']['DISCOUNT_VALUE'] > $minPrice['DISCOUNT_VALUE'])
                                {
                                    $minPrice['DISCOUNT_DIFF'] = $item['PRICES']['BASE']['DISCOUNT_VALUE'] - $minPrice['DISCOUNT_VALUE'];
                                    $minPrice['DISCOUNT_DIFF_PERCENT'] = round(100-($minPrice['DISCOUNT_VALUE']/$item['PRICES']['BASE']['DISCOUNT_VALUE'])*100);
                                }
                                if(empty($arItem['OFFERS']) && strpos($APPLICATION->GetCurPage(), '/catalog/novinki/') === false)
                                {
                                    ?>
                                    <div class="card-badge-item no-available">
                                        <?=LANGUAGE_ID=='ua'?'Немає в наявності':'Нет в наличии'?>
                                    </div>
                                    <?
                                }
                                else
                                {
                                    echo $minPrice['PRINT_DISCOUNT_VALUE'];
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?
    }
}
?>