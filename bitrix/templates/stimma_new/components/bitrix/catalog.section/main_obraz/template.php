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
$tree = $arResult['TREE_PROPS'];

foreach ($arParams['LOOKS_IDS'] as $key => $item)
{
    ?>
    <div class="modal fade look-modal" id="look-modal_<?=$item['ID']?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="look-modal-cont">
                        <div class="look-modal-title-block">
                            <div class="look-modal-title">
                                Готовий образ
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4365 12.0225L25.4561 0.00292969L26.8701 1.41699L14.8506 13.4365L26.8701 25.4561L25.4561 26.8701L13.4365 14.8506L1.41406 26.873L0 25.459L12.0225 13.4365L0 1.41406L1.41406 0L13.4365 12.0225Z" fill="currentcolor"/>
                                </svg>
                            </button>
                        </div>
                        <div class="look-modal-content">
                            <div class="look-modal-slider-cont">
                                <div class="look-modal-slider">
                                    <?
                                    foreach($item['PROPERTIES']['PRODUCTS']['VALUE'] as $index => $product)
                                    {
                                        $lookFile = $img = CFile::ResizeImageGet($arResult['ITEMS'][$product]['PREVIEW_PICTURE'], array('width'=>470, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                                        ?>
                                        <div class="look-modal-slider-item">
                                            <img src="<?=$lookFile?>">
                                        </div>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="look-modal-item-list">
                                <?
                                foreach($item['PROPERTIES']['PRODUCTS']['VALUE'] as $index => $product)
                                {
                                    if(!isset($arResult['ITEMS'][$product]))
                                        continue;
                                    $arItem = $arResult['ITEMS'][$product];

                                    if(LANGUAGE_ID == 'ru' && strpos($arItem['DETAIL_PAGE_URL'], '/ru/') === false)
                                        $arItem['DETAIL_PAGE_URL'] = '/ru'.$arItem['DETAIL_PAGE_URL'];

                                    $img = false;
                                    if(!$img) $img = $arItem['DETAIL_PICTURE'];
                                    if(!$img) $img = $arItem['PREVIEW_PICTURE'];

                                    if(!$img)
                                    {
                                        $res = $DB->Query('select * from b_iblock_element_property where IBLOCK_PROPERTY_ID = 239 and IBLOCK_ELEMENT_ID = ' . $arItem['ID']);
                                        if($res=$res->Fetch())$img = $res['VALUE'];
                                    }
                                    if(isset($img['ID'])) $img = $img['ID'];

                                    $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];

                                    $minPrice = $item['MIN_PRICE'];
                                    ?>
                                    <div class="look-modal-item">
                                        <div class="catalog-item ">
                                            <div class="catalog-item-top">
                                                <div class="catalog-item-img " >
                                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>" tabindex="-1">
                                                        <img class="simg2" src="<?=$img?>">
                                                    </a>
                                                </div>
                                                <div class="catalog-item-favorite">
                                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" data-id="<?=$arItem['ID']?>" aria-label="Додати в обране">
                                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div class="catalog-item-more-info">
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
                                                    <div class="catalog-item-btn-buy">
                                                        <a href="#" data-id="<?=$arItem['OFFERS'][$arItem['OFFER_ID_SELECTED']]['ID']?>" class="info-btn">
                                                            Додати до кошика
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="catalog-item-info">
                                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>" class="catalog-item-name" data-entity="name" data-nameurl="<?=$arItem['CODE']?>">
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
                                                                if(in_array(9,$gGroups) && $arItem['PRICES']['DISCOUNT']) $arItem['PRICES']['BASE'] = $arItem['PRICES']['DISCOUNT'];
                                                                elseif(in_array(9,$gGroups) && $arItem['PRICES']['OPT']) $arItem['PRICES']['BASE'] = $arItem['PRICES']['OPT'];
                                                            }

                                                            if($arItem['PRICES']['BASE']['DISCOUNT_VALUE'] > $minPrice['DISCOUNT_VALUE'])
                                                            {
                                                                $minPrice['DISCOUNT_DIFF'] = $arItem['PRICES']['BASE']['DISCOUNT_VALUE'] - $minPrice['DISCOUNT_VALUE'];
                                                                $minPrice['DISCOUNT_DIFF_PERCENT'] = round(100-($minPrice['DISCOUNT_VALUE']/$arItem['PRICES']['BASE']['DISCOUNT_VALUE'])*100);
                                                            }
                                                            ?>
                                                            <?=$minPrice['PRINT_DISCOUNT_VALUE'];?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?

    /*if(LANGUAGE_ID == 'ru' && strpos($arItem['DETAIL_PAGE_URL'], '/ru/') === false)
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
    */
}
?>


