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
                                <?
                                if(in_array($item['ID'],[50987,62220,62221,62222]))
                                    echo LANGUAGE_ID == 'ua' ? 'Образ від Тетяни - FREE DELIVERY' : 'Образ от Татьяны - FREE DELIVERY';
                                else
                                    echo LANGUAGE_ID == 'ua' ? 'Готовий образ' : 'Готовый образ';
                                ?>
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
                            <div class="look-modal-item-list-cont">
                                <div class="look-modal-item-list">
                                    <?
                                    $cntItems = $cntAmount = 0;
                                    foreach($item['PROPERTIES']['PRODUCTS']['VALUE'] as $index => $product)
                                    {
                                        if(!isset($arResult['ITEMS'][$product]))
                                            continue;
                                        $arItem = $arResult['ITEMS'][$product];


                                        $cntItems++;

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

                                        $minPrice = $arItem['OFFERS'][$arItem['OFFER_ID_SELECTED']]['MIN_PRICE'];

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
                                                                <?$cntAmount += $minPrice['DISCOUNT_VALUE']?>
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
                                <div class="look-modal-footer">
                                    <div class="look-modal-total-block">
                                        <div class="look-modal-total-key">
                                            Разом <?=$cntItems?> од.
                                        </div>
                                        <div class="look-modal-total-value">
                                            <?=FormatCurrency($cntAmount, 'UAH')?>
                                        </div>
                                    </div>
                                    <div class="look-modal-total-btns">
                                        <a href="#" class="info-btn info-btn-black obraz_add_basket" data-lookid="<?=$item['ID']?>">
                                            Додати образ
                                        </a>
                                        <a href="#" class="look-modal-total-parts">
                                            <span class="icon">
                                                <svg width="25" height="25" viewBox="0 0 16 16" fill="currentcolor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.92004 11.1955C1.06831 9.81362 0.794053 8.15752 1.15549 6.57872C1.51693 4.99993 2.48561 3.62276 3.85589 2.73957L7.28454 7.95419L1.92004 11.1955Z"></path>
                                                    <path d="M5.31799 2.98764C6.3714 2.31742 7.60302 1.97403 8.85488 2.00153C10.1067 2.02903 11.3218 2.42616 12.3441 3.14198C13.3665 3.8578 14.1495 4.85968 14.5929 6.01912C15.0362 7.17856 15.1197 8.4427 14.8325 9.6494C14.5452 10.8561 13.9005 11.9503 12.9809 12.7918C12.0613 13.6332 10.9088 14.1835 9.67124 14.3721C8.43363 14.5606 7.16736 14.3788 6.03482 13.85C4.90228 13.3212 3.95512 12.4695 3.3148 11.4041L8.71548 8.22222L5.31799 2.98764Z"></path>
                                                </svg>
                                            </span>
                                            <span class="icon">
                                                <svg width="25" height="25" viewBox="0 0 16 16" fill="currentcolor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.75377 13.8172C9.36677 13.7211 8.97029 13.633 8.59271 13.5208C8.33315 13.4448 8.08769 13.3366 7.84229 13.2285C6.88889 12.804 5.88829 12.6879 4.82634 12.8C4.30717 12.8561 3.76439 12.8801 3.25466 12.804C2.0228 12.6238 1.29123 11.5986 1.57442 10.5414C1.79625 9.72843 2.37678 9.12776 3.18386 8.69122C3.84935 8.32683 4.43932 7.89029 5.00097 7.42577C5.34079 7.14143 5.69478 6.86513 6.06764 6.60883C7.29005 5.75183 8.87591 6.30848 9.42341 7.09739C9.71603 7.52188 9.94259 7.97844 10.1786 8.42696C10.4335 8.91953 10.7355 9.38003 11.1272 9.80453C11.6133 10.3292 11.9296 10.9138 12.0192 11.5826C12.175 12.76 11.132 13.7852 9.77735 13.7732C9.76793 13.7811 9.76319 13.7972 9.75377 13.8172Z"></path>
                                                    <path d="M12.5295 3.94437C12.4729 4.81338 12.0764 5.57026 11.2033 6.10688C10.0894 6.79167 8.85754 6.37519 8.59798 5.23387C8.37142 4.25273 9.01804 3.03932 10.0375 2.53073C11.1844 1.95807 12.3549 2.47066 12.5059 3.61198C12.5154 3.7121 12.5201 3.81222 12.5295 3.94437Z"></path>
                                                    <path d="M7.89298 3.69445C7.88824 4.21105 7.75137 4.69962 7.39737 5.12812C6.69413 5.9771 5.52362 5.98912 4.8015 5.15615C4.09353 4.3392 4.10297 2.99764 4.82037 2.1887C5.50946 1.4118 6.63276 1.4078 7.33132 2.1807C7.69474 2.57715 7.89298 3.11378 7.89298 3.69445Z"></path>
                                                    <path d="M11.084 8.04012C11.0887 7.10705 11.9713 6.14994 13.0285 5.93369C14.0433 5.72544 14.8409 6.22602 14.9023 7.11105C14.9683 8.08818 14.0008 9.14941 12.868 9.33763C11.8533 9.50182 11.0793 8.94118 11.084 8.04012Z"></path>
                                                    <path d="M4.21015 6.15683C4.20071 6.68144 4.08271 7.09392 3.74761 7.44631C3.29452 7.91887 2.59599 8.02703 1.97298 7.72663C0.826079 7.17001 0.42962 5.62422 1.19894 4.71916C1.65204 4.18254 2.41192 4.03837 3.07269 4.38678C3.87505 4.80726 4.15823 5.47204 4.21015 6.15683Z"></path>
                                                </svg>
                                            </span>
                                            <div class="text">
                                                <span>Оплата частинами -</span> від <?=round($cntAmount/3)?> грн/міс
                                            </div>
                                        </a>
                                    </div>
                                </div>
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


