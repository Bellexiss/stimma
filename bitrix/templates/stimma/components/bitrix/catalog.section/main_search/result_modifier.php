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
        <div data-entity="scu" class="search-result-item" data-item="<?=$arItem['ID']?>" offer-item="<?=$arItem['OFFERS'][0]['ID']?>">
            <div class="catalog-item-block <?=($item['PRICES']['BASE']['DISCOUNT_VALUE'] > $minPrice['DISCOUNT_VALUE']) ? 'catalog-item-block-discount' : ''?>"  data-entity="scu-values">
                <div  class="catalog-item-img">
                    <div class="catalog-item-img-slider">
                        <div class="catalog-item-img-slider-el">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                <img src="<?=$img?>">
                            </a>
                        </div>
                        <div class="catalog-item-img-slider-el">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                <img src="<?=$img?>">
                            </a>
                        </div>
                        <div class="catalog-item-img-slider-el">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                <img src="<?=$img?>">
                            </a>
                        </div>
                        <div class="catalog-item-img-slider-el">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                <img src="<?=$img?>">
                            </a>
                        </div>
                    </div>
                    <div class="catalog-item-size-list" data-code="RAZMER">
                        <?

                        //foreach ($tree[$arItem['ID']]['props']['RAZMER']['values'] as $indexProp => $prop)
                        $sizes = [];
                        foreach ($arItem['OFFERS'] as $indexOFfer => $offer)
                            $sizes[$arResult['SORTING_SIZES'][mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE'])]] = mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE']);
                        ksort($sizes);
                        foreach ($sizes as $indexOFfer => $offer)
                        {
                            // todo if not available then add class no-size
                            ?>
                            <div class="catalog-item-size <?=!$indexOFfer ? 'active' : ''?> <?/*no-size*/?>" data-entity="scu-value" data-id="<?=$offer['ID']?>">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                    <?=mb_strtoupper($offer)?>
                                </a>
                            </div>
                            <?
                        }

                        ?>
                    </div>
                    <div class="catalog-item-favorite">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" data-id="<?=$arItem['ID']?>">
                            <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    <?/*<div class="card-stars-block">
                        <?
                        for ($i = 1; $i <= 5; $i++)
                        {
                            ?>

                            <span class="<?=$i <= $arResult['AVERAGE'][$arItem['ID']] ? 'active' : ''?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                            <defs></defs>
                                            <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                        </svg>
                                    </span>
                            <?
                        }
                        ?>
                    </div>*/?>
                    <div class="card-badge-block">
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

                        /*if(in_array('novaya_kollektsiya', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID']))
                        {
                            ?><div class="card-badge-item new">NEW</div><?
                        }*/
                        /*if(in_array('khit_prodazh', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID']))
                        {
                            ?><div class="card-badge-item hit">Хіт продажу</div><?
                        }*/
                        /*if(in_array('rasprodazha', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID']))
                        {
                            ?><div class="card-badge-item action cbia1">SALE</div><?
                        }*/
                        if($minPrice['DISCOUNT_DIFF'] && (in_array('rasprodazha', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID']) || in_array('khit_prodazh', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID'])))
                        {
                            ?><div class="card-badge-item action cbia2">-<?=$minPrice['DISCOUNT_DIFF_PERCENT']?>%</div><?
                        }
                        if($arItem['PROPERTIES']['SOON']['VALUE'])
                        {
                            ?><div class="card-badge-item soon cbia2" style="background-color: #c1a68b; font-size:14px;"><?=LANGUAGE_ID == 'ua' ? 'Передзамовлення' : 'Предзаказ'?></div><?
                        }
                        $isLimited = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $arItem['ID'] . ' and IBLOCK_SECTION_ID = 1250');
                        if($isLimited -> Fetch() && strpos($APPLICATION->GetCurPage(),'/limited/') === false)
                        //if($arItem['IBLOCK_SECTION_ID'] == 1250)
                        {
                            ?><div class="card-badge-item limited cbia2" style="background-color: gray; font-size:14px;">LIMITED</div><?
                        }
                        ?>
                    </div>
                </div>
                <div  class="catalog-item-name-block">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="catalog-item-name" data-entity="name"><?/*Жіноча сукня*/?><?=$arItem['NAME']?></a>
                    <?
                    /*if(in_array('STOCK', $arItem['PROPERTIES']['HIT']['VALUE_XML_ID']) )
                    {
                        ?><div class="catalog-item-sale">SALE</div><?
                    }*/
                    ?>
                </div>
                <?

                ?>
                <div class="catalog-item-info">
                    <div class="catalog-item-price">
                        <div class="catalog-item-price-currency" data-entity="price"><?=$minPrice['PRINT_DISCOUNT_VALUE']?></div>
                        <?
                        if($minPrice['DISCOUNT_DIFF'])
                        {
                            ?><div class="catalog-item-price-old cip6"><?=$item['PRICES']['BASE']['PRINT_VALUE']?></div><?
                        }
                        ?>
                    </div>
                    <div class="catalog-item-colors cic6" data-code="COLOR_REF">
                        <?
                        $noImg = '/bitrix/templates/aspro_max/images/colorimg.png'; // todo Не должно быть пустого

                        foreach ($arResult['COLOR_VARIANTS'][$arResult['COLOR_IDS'][$arItem['ID']]] as $indexProp => $prop)
                        {
                            {
                                $variants[$prop['code']] = $prop;
                                ?>
                                <a onclick="changeData('<?=$prop['code']?>', this);return false;" style="background-color: <?=$arResult['ALL_MAIN_COLORS'][$prop['color']]?>;" href="#" class="catalog-item-color <?=strtoupper($arResult['ALL_COLORS'][$prop['color']]) == '#FFFFFF' ? 'white' : ''?> <?=$indexProp == $arItem['PROPERTIES']['COLOR']['VALUE'] ? 'active' : ''?>" data-entity="scu-value" data-id="<?=$indexProp?>">
                                </a>
                                <?
                            }


                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?
    }
}
?>