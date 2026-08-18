<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc,
	  \Bitrix\Main\Web\Json;?>
<?
$bIndex = (strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false) || isset($_GET['google']);
$type = getTypeDevice();

$res = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $arParams['SECTION_ID']], false, ['ID','IBLOCK_ID','NAME','UF_*']) -> Fetch();
$sectionName = LANGUAGE_ID == 'ua' ? $res['UF_NAME_UA'] : $res['NAME'];

$novinki = strpos($APPLICATION->GetCurPage(), '/catalog/novinki/') !== false;

$arJsonProducts = $facebookIds = [];
?>
<?$universalID = 'id_'.uniqid()?>
<?$variants = []?>
<?$isNew = $arParams['IS_NEW'];?>
<?$isOutdoor = $arParams['IS_OUTDOOR'];?>
<?$isLimited = $arParams['IS_LIMITED'];?>
<?$isCruise = $arParams['IS_CRUISE'];?>
<?$isEvents = $arParams['IS_EVENTS'];?>
<?$isSmartOffice = $arParams['IS_SMART_OFFICE'];?>
<?$isComfort = $arParams['IS_COMFORT'];?>
<?$isCasual = $arParams['IS_CASUAL'];?>
<?if($isOutdoor || $isEvents || $isLimited || $isCruise || $isSmartOffice || $isComfort|| $isCasual)$isNew=true;?>
<?$for = $isNew ? $arParams['FILES'] : $arResult['ITEMS']?>
<?
if ( 1 || isset($_GET['svtmp_descr']) ) {
	global $sv_prices;
	$sv_prices = ['min' => 99999, 'max' => 0];
	foreach($arResult["ITEMS"] as $prod) {
		if ( $prod["PROPERTIES"]['MINIMUM_PRICE']['VALUE'] < $sv_prices['min'] ) $sv_prices['min'] = (int)$prod["PROPERTIES"]['MINIMUM_PRICE']['VALUE'];
		if ( $prod["PROPERTIES"]['MINIMUM_PRICE']['VALUE'] > $sv_prices['max'] ) $sv_prices['max'] = (int)$prod["PROPERTIES"]['MINIMUM_PRICE']['VALUE'];
	}
}
$chast = true;
$uGroups = $USER->GetUserGroupArray();
if(in_array(9,$uGroups)) $chast = false;

if($arParams['FAVORITE'] == 'Y' && empty($arResult['ITEMS']))
{
    ?>
    <div class="personal-wish-list-empty">
        <div class="personal-wish-list-empty-text">
            <p><?=LANGUAGE_ID == 'ua' ? 'Список бажань порожній' : 'Список желаний пуст'?></p>
            <p class="uppercase">
                <?=LANGUAGE_ID == 'ua' ? 'ДOДABAЙ HEOБMEЖEHУ KІЛЬKІCTЬ CBOЇX БAЖAHOK, ПЛAHУЙ OБPAЗИ І OБИPAЙ CEPЦEM!' : 'ДОБАВЛЯЙ НЕОГРАНИЧЕННОЕ КОЛИЧЕСТВО СВОИХ ХОТЕЛОВ, ПЛАНИРУЙ ОБРАЗЫ И ВЫБИРАЙ СЕРДЦЕМ!'?>
            </p>
        </div>
        <div class="personal-wish-list-empty-btn">
            <a href="/catalog/zhenskaya_odezhda/" class="info-btn info-btn-black">
                <?=LANGUAGE_ID == 'ua' ? 'До каталогу' : 'До каталога'?>
            </a>
        </div>
    </div>
    <?
}

?>
<?$gGroups = explode(',',$USER -> GetGroups());?>
<?if($arResult["ITEMS"] || $for):?>
<?
    $selected = 0;
    $available = true; //$arItem['PRODUCT']['AVAILABLE']; //todo змінити
    $tree = $arResult['TREE_PROPS'];
    ?>
    
    <div class=" insertpag loadmore_container <?=$isNew ? 'catalog-grid-new' : ''?> <?=$arParams['WRAP_CLASS'] ? $arParams['WRAP_CLASS'] : 'catalog-grid '. (!$isNew ? 'rectangle' : '')?>">
        <?
        if(isset($_REQUEST['get_catalog_ajax_filter']) && $_REQUEST['get_catalog_ajax_filter'] == 'y')
        {
            global $jsonFilter;
            ob_start();
        }
        $myIndex = 0;
        $myIndexes = $newArr=[];
        $myNumber=false;
        $curIndex=$prevIndex=$prevIndex2=0;
        $endTag=1;

        foreach ($for as $index => $arItem)
        {
            if($index == 8 && $bIndex) break;

            $skip = false;
            $myIndexes[] = $myIndex . ' => ' . $arItem['UF_SIZE'];
            if(LANGUAGE_ID == 'ru' && strpos($arItem['DETAIL_PAGE_URL'], '/ru/') === false)
                $arItem['DETAIL_PAGE_URL'] = '/ru'.$arItem['DETAIL_PAGE_URL'];

            $arItem['DETAIL_PAGE_URL'] = str_replace('/search/','/catalog/', $arItem['DETAIL_PAGE_URL']);

            $dopClass = $isNew ? 'w-33' : 'w-25';
            $dopClass='';
            $img = false;

            if($arItem['UF_PRODUCT_ID'] > 0)
            {
                $ufSize = $arItem['UF_SIZE'];
                $fileCache=$arItem['UF_FILE'];
                $arItem = $arResult['ITEMS'][$arResult['RELATION'][$arItem['UF_PRODUCT_ID']]];
                if($fileCache) $arItem['UF_FILE'] = $fileCache;
                $arItem['UF_SIZE'] = $ufSize;
            }

            if($isNew && $arItem['UF_SIZE']==300 && $prevIndex!= 300){?><div class="catalog-grid catalog-grid-new-incide"><?}
            if($isNew && $arItem['UF_SIZE']!=300 && $prevIndex== 300){?></div><?}

            $prevIndex=$arItem['UF_SIZE'];

            if($isNew)
            {
                $img = $arItem['UF_FILE'];

                if($arItem['UF_PRODUCT_ID'] > 0)
                {
                    $ufSize = $arItem['UF_SIZE'];
                    $arItem = $arResult['ITEMS'][$arResult['RELATION'][$arItem['UF_PRODUCT_ID']]];
                    $arItem['UF_SIZE'] = $ufSize;
                }

                if($arItem['UF_SIZE']==200)
                {
                    ?>
                    </div>
                        <div class="catalog-new-banner claude_photo">
                            <?
                            if(isset($_GET['p']) && false)
                            {
                                ?><img  src="<?=convertToWebP($arItem['UF_FILE'])?>" class="img1"><?
                            }
                            else
                            {
                                ?><img src="<?=$arItem['UF_FILE']?>" class="img2"><?
                            }
                            ?>
                        </div>
                    <div class=" insertpag loadmore_container <?=$isNew ? 'catalog-grid-new' : ''?> <?=$arParams['WRAP_CLASS'] ? $arParams['WRAP_CLASS'] : 'catalog-grid'?>">
                    <?
                    $skip=true;
                }
            }
            if(!$skip)
            {
                $item = $arItem['OFFERS'][0];

                if($arParams['CONFIRM_ORDER'])
                {
                    $img = $arItem['PROPERTIES']['PHOTO_GALLERY']["VALUE"][0];
                }
                else
                {
                    if(!$img)
                        $img = $item['DETAIL_PICTURE']['ID'];

                    if(!$img)
                        $img = $item['PREVIEW_PICTURE'];

                    if(!$img)
                        $img = $arItem['DETAIL_PICTURE'];
                    if(!$img)
                        $img = $arItem['PREVIEW_PICTURE'];

                    if(isset($img['ID'])) $img = $img['ID'];
                }

                if(!$isNew)
                {
                    if($bIndex)
                    {
                        if($type == 'Desktop')
                            $img = CFile::ResizeImageGet($img, array('width'=>250, 'height'=>375), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                        else
                            $img = CFile::ResizeImageGet($img, array('width'=>250, 'height'=>375), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                    }
                    else
                        $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];

                }

                if(!$novinki && $item['PROPERTIES']['CML2_LINK']['VALUE'])
                {
                    $slider = [$img];
                    //$res = $DB->Query('select * from b_iblock_element_property where IBLOCK_PROPERTY_ID = 239 and IBLOCK_ELEMENT_ID = ' . $item['PROPERTIES']['CML2_LINK']['VALUE']);
                    $res = $DB->Query('select * from b_iblock_element_property where IBLOCK_PROPERTY_ID = 239 and IBLOCK_ELEMENT_ID = ' . $arItem['ID']);
                    while ($file = $res -> Fetch())
                    {
                        $file = $file['VALUE'];
                        if($bIndex)
                        {
                            if($type == 'Desktop')
                                $slider[] = CFile::ResizeImageGet($file, array('width'=>250, 'height'=>375), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                            else
                                $slider[] = CFile::ResizeImageGet($file, array('width'=>250, 'height'=>375), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                        }
                        else
                            $slider[] = CFile::ResizeImageGet($file, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];

                        if($arParams['NO_SLIDER'] == 'Y')
                            break;

                    }
                }
                else
                    $slider = [$img];
                $minPrice = $item['MIN_PRICE'];

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
                $stims = $arItem['IBLOCK_SECTION_ID'] ==1311;
                $dopClass = $arItem['UF_SIZE']==100?' ':'';

                if($isNew && $arItem['UF_SIZE']==400 && $prevIndex2!= 400){?><div class=" catalog-grid-three"><?}
                if($isNew && $arItem['UF_SIZE']!=400 && $prevIndex2== 400){?></div><?}

                $prevIndex2=$arItem['UF_SIZE'];

                if($arItem['UF_SIZE']==100){?><div class="catalog-grid-solo"><?}



                $isVideo = $videoItem = false;
                foreach ($slider as $indexSlider => $itemSlider)
                {
                    if(strpos($itemSlider,'.m4v') !== false || strpos($itemSlider,'.mp4') !== false || strpos($itemSlider,'.MP4') !== false)
                    {
                        $videoItem = $itemSlider;
                        $isVideo = true;
                        break;
                    }
                }
                ?>
                <div number_index="<?=$index?>" my_index="<?=$myIndex?>-<?=$arItem['UF_SIZE']?>-<?=$arItem['ID']?>" data-entity="scu" class="<?=$arParams['BLOCK_CLASS'] ? $arParams['BLOCK_CLASS'] : 'catalog-grid-item'?> <?//=$dopClass?>" data-item="<?=$arItem['ID']?>" offer-item="<?=$arItem['OFFERS'][0]['ID']?>" style="">
                    <div class="catalog-item claude_photo <?=$stims ? 'catalog-item-stimz' : ''?>" data-entity="scu-values">

                        <div class="catalog-item-top">

                            <div count="<?=count($slider)?>" class="catalog-item-img-slider <?=count($slider) == 1 || $arParams['MAIN_PAGE']=='Y' || $arParams['NO_SLIDER'] == 'Y' ? 'slider-off' : ''?>">

                                        <?
                                        if($novinki)
                                        {
                                            if($img>0)$img=CFile::GetFileArray($img)['SRC'];
                                            ?>
                                            <div class="catalog-item-img <?=$arParams['MAIN_PAGE']=='Y' && $isVideo ?'video':''?>"> <?// клас video потрібен тільки якщо в елементі є відео?>
                                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>">
                                                    <?
                                                    if($isVideo)
                                                    {
                                                        ?>
                                                        <video
                                                                autoplay
                                                                muted
                                                                loop
                                                                playsinline
                                                                preload="auto"
                                                                <?/*controls */?>
                                                                <?/*poster="<?=$slider[0]?>"*/?>
                                                        >
                                                            <source src="<?=$img?>" type="video/mp4">
                                                            <?=LANGUAGE_ID=='ua'?'Ваш браузер не підтримує відео':'Ваш браузер не поддерживает видео'?>
                                                        </video>
                                                        <?
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <img class="simg1" src="<?=convertToWebP($img)?>">
                                                        <?
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                            <?
                                        }
                                        else
                                        {
                                            $firstEl=false;
                                            if($arParams['MAIN_PAGE'] == 'Y')
                                            {
                                                if($isVideo)
                                                    $firstEl = $videoItem;
                                                if($firstEl)
                                                {
                                                    ?>
                                                    <div class="catalog-item-img <?=$arParams['MAIN_PAGE']=='Y' && $isVideo ?'':''?>"> <?// клас video потрібен тільки якщо в елементі є відео?>
                                                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>">
                                                            <video
                                                                    autoplay
                                                                    muted
                                                                    loop
                                                                    playsinline
                                                                    preload="auto"
                                                                    <?/*controls */?>
                                                                    <?/*poster="<?=$slider[0]?>"*/?>
                                                            >
                                                                <source src="<?=$firstEl?>" type="video/mp4">
                                                                <?=LANGUAGE_ID=='ua'?'Ваш браузер не підтримує відео':'Ваш браузер не поддерживает видео'?>
                                                            </video>
                                                        </a>
                                                    </div>
                                                    <?
                                                }
                                                else
                                                {
                                                    $firstEl = $slider[0];
                                                    $secondEl = $slider[1];
                                                    if(intval($firstEl)>0)$firstEl=CFile::GetFileArray($firstEl)['SRC'];
                                                    if(intval($secondEl)>0)$secondEl=CFile::GetFileArray($secondEl)['SRC'];

                                                    ?>
                                                    <div class="catalog-item-img hover-change <?=$arParams['MAIN_PAGE']=='Y' && $isVideo ?'video':''?>"> <?// клас video потрібен тільки якщо в елементі є відео?>
                                                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>">
                                                            <img class="simg2223" src="<?=convertToWebP($firstEl)?>">
                                                            <img class="simg2223-2 catalog-item-img-change" src="<?=convertToWebP($secondEl)?>">
                                                        </a>
                                                    </div>
                                                    <?

                                                    /*foreach($slider as $indexSlider => $itemSlider)
                                                    {
                                                        ?>
                                                        <div class="catalog-item-img <?=$arParams['MAIN_PAGE']=='Y' && $isVideo ?'video':''?>"> <?// клас video потрібен тільки якщо в елементі є відео?>
                                                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>">
                                                                <img class="simg2223" src="<?=convertToWebP($itemSlider)?>">
                                                            </a>
                                                        </div>
                                                        <?
                                                    }*/


                                                }
                                            }
                                            else
                                            {
                                                //$firstEl = $slider[0];
                                                foreach ($slider as $indexSlider => $itemSlider)
                                                {

                                                    if(strpos($itemSlider,'.m4v') !== false || strpos($itemSlider,'.mp4') !== false || strpos($itemSlider,'.MP4') !== false)
                                                        continue;

                                                    if(intval($itemSlider)>0)$itemSlider=CFile::GetFileArray($itemSlider)['SRC'];
                                                    ?>
                                                    <div class="catalog-item-img <?=$arParams['MAIN_PAGE']=='Y' && $isVideo ?'video':''?>"> <?// клас video потрібен тільки якщо в елементі є відео?>
                                                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>">
                                                            <img class="simg2" src="<?=!$novinki ? $itemSlider : convertToWebP($itemSlider)?>">
                                                        </a>
                                                    </div>
                                                    <?

                                                    if($arParams['NO_SLIDER'] == 'Y') break;
                                                }

                                            }
                                        }
                                        ?>


                            </div>
                            <div class="catalog-item-favorite">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" data-id="<?=$arItem['ID']?>" aria-label="<?=LANGUAGE_ID == 'ua' ? 'Додати в обране' : 'Добавить в избранное'?>">
                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="catalog-item-badges">
                                <?
                                if($minPrice['DISCOUNT_DIFF'] && (in_array('rasprodazha', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID']) || in_array('khit_prodazh', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID'])))
                                {
                                    ?><div class="catalog-item-badge discount cbia2">-<?=$minPrice['DISCOUNT_DIFF_PERCENT']?>%</div><?
                                }
                                if($arItem['PROPERTIES']['SOON']['VALUE'])
                                {
                                    ?><div class="catalog-item-badge top-price cbia2" style="background-color: #c1a68b;"><?=LANGUAGE_ID == 'ua' ? 'Передзамовлення' : 'Предзаказ'?></div><?
                                }
                                if(!$isOutdoor && !$isEvents && !$isCruise&& !$isSmartOffice && !$isComfort && !$isCasual && !$isNew)
                                {
                                    $isLimited = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $arItem['ID'] . ' and IBLOCK_SECTION_ID = 1250');
                                    if($isLimited -> Fetch() && strpos($APPLICATION->GetCurPage(),'/limited/') === false)
                                    {
                                        ?><div class="catalog-item-badge limited cbia2" style="background-color: gray;">LIMITED</div><?
                                    }
                                }
                                if($arItem['PROPERTIES']['BEST_PRICE']['VALUE'])
                                {
                                    ?>
                                    <div class="catalog-item-badge top-price">
                                        <?=LANGUAGE_ID=='ua'?'найкраща ціна':'лучшая цена'?>
                                    </div>
                                    <?
                                }
                                if($arItem['PROPERTIES']['SPORT']['VALUE'])
                                {
                                    ?>
                                    <div class="catalog-item-badge sport">
                                        sport
                                    </div>
                                    <?
                                }
                                if($arItem['PROPERTIES']['BASIC']['VALUE'])
                                {
                                    ?>
                                    <div class="catalog-item-badge basic">
                                        basic
                                    </div>
                                    <?
                                }
                                if(!$item['PRODUCT']['QUANTITY'])
                                {
                                    ?>
                                    <div class="catalog-item-badge no-available">
                                        <?=LANGUAGE_ID=='ua'?'Немає в наявності':'Нет в наличии'?>
                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                            <?
                            if($arItem['ID'])
                            {
                                ?>
                                <div class="catalog-item-more-info">

                                    <div class="catalog-item-size-list" data-code="RAZMER">
                                        <?
                                        $sizes = [];
                                        foreach ($arItem['OFFERS'] as $indexOFfer => $offer)
                                        {
                                            $offer['PROPERTIES']['RAZMER']['VALUE'] = str_replace('_','-',$offer['PROPERTIES']['RAZMER']['VALUE']);
                                            $sizes[$arResult['SORTING_SIZES'][mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE'])]] = mb_strtoupper($offer['PROPERTIES']['RAZMER']['VALUE']);
                                        }
                                        ksort($sizes);

                                        foreach ($sizes as $indexOFfer => $offer)
                                        {
                                            // todo if not available then add class no-size
                                            $cSize=str_replace('_','-',mb_strtoupper($arItem['OFFERS'][$arItem['OFFER_ID_SELECTED']]['PROPERTIES']['RAZMER']['VALUE']));
                                            ?>
                                            <label data-entity="scu-value" data-csize="<?=$cSize?>" data-id="<?=$offer?>" class="<?=$offer==$cSize? 'active':''?>">
                                                <input type="radio" name="radio<?=$arItem['ID']?>" <?//=$offer==$cSize? 'checked="checked"':''?>>
                                                <span aria-label="<?=$arItem['NAME']?>" class="catalog-item-size">
                                                <?=mb_strtoupper($offer)?>
                                            </span>
                                            </label>
                                            <?
                                        }

                                        ?>

                                    </div>

                                    <?
                                    if(!$item['PRODUCT']['QUANTITY'])
                                    {
                                            ?>
                                        <div class="catalog-item-btn-buy nobuy">
                                            <a href="#" class="info-btn" onclick="return false;">
                                                <?=LANGUAGE_ID=='ua'?'Немає в наявності':'Нет в наличии'?>
                                            </a>
                                        </div>
                                        <?
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="catalog-item-btn-buy">
                                            <a href="#" data-id="<?=$arItem['OFFERS'][$arItem['OFFER_ID_SELECTED']]['ID']?>" class="info-btn">
                                                Додати до кошика
                                            </a>
                                        </div>
                                        <?
                                    }
                                    ?>


                                </div>
                                <?
                            }
                            ?>

                        </div>
                        <div class="catalog-item-info">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>" class="catalog-item-name" data-entity="name" data-nameurl="<?=CUtil::translit($arItem['NAME'],'ru');?>">
                                <?=$arItem['NAME']?>
                            </a>
                            <div class="catalog-item-details">
                                <div class="catalog-item-price-block">

                                    <div class="catalog-item-price" data-entity="price">
                                        <?
                                        if($arItem['PROPERTIES']['PROP_BONUS_PRICE']['VALUE'])
                                        {
                                            ?>
                                            <?=number_format($arItem['PROPERTIES']['PROP_BONUS_PRICE']['VALUE'],0,'', ' ')?> <span class="bonus">стімзів</span>
                                            <span class="catalog-item-price-sep">
                                                |
                                            </span>
                                            <?
                                        }
                                        ?>
                                        <?=$minPrice['PRINT_DISCOUNT_VALUE']?>
                                    </div>
                                    <?
                                    if($minPrice['DISCOUNT_DIFF'])
                                    {
                                        ?><div class="catalog-item-price-old cip3"><?=$item['PRICES']['BASE']['PRINT_VALUE']?></div><?
                                    }
                                    ?>
                                </div>
                                <div class="catalog-item-color-block" data-code="COLOR_REF">
                                    <?
                                    $noImg = '/bitrix/templates/aspro_max/images/colorimg.png'; // todo Не должно быть пустого
                                    foreach ($arResult['COLOR_VARIANTS'][$arResult['COLOR_IDS'][$arItem['ID']]] as $indexProp => $prop)
                                    {
                                        $jsonVariants[$arResult['ID']];
                                        $variants[$prop['code']] = $prop;
                                        ?>
                                        <a onclick="changeData('<?=$prop['code']?>', this);return false;" style="background: <?=$arResult['ALL_MAIN_COLORS'][$prop['color']]?>;" aria-label="<?=$arResult['COLOR_LIST'][$prop['color']]?> <?=LANGUAGE_ID == 'ua' ? 'колір' : 'цвет'?>" href="#" class="<?=strtoupper($arResult['ALL_COLORS'][$prop['color']]) == '#FFFFFF' ? 'white' : ''?> <?=$indexProp == $arItem['PROPERTIES']['COLOR']['VALUE'] ? 'active' : ''?>" data-entity="scu-value" data-id="<?=$indexProp?>">
                                        </a>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>
                            <?
                            if($minPrice['DISCOUNT_VALUE'] >= 3000 && $chast)
                            {?>
                                <div class="catalog-item-buy-parts">
                                    <div class="catalog-item-buy-parts-icons">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentcolor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.92004 11.1955C1.06831 9.81362 0.794053 8.15752 1.15549 6.57872C1.51693 4.99993 2.48561 3.62276 3.85589 2.73957L7.28454 7.95419L1.92004 11.1955Z"/>
                                            <path d="M5.31799 2.98764C6.3714 2.31742 7.60302 1.97403 8.85488 2.00153C10.1067 2.02903 11.3218 2.42616 12.3441 3.14198C13.3665 3.8578 14.1495 4.85968 14.5929 6.01912C15.0362 7.17856 15.1197 8.4427 14.8325 9.6494C14.5452 10.8561 13.9005 11.9503 12.9809 12.7918C12.0613 13.6332 10.9088 14.1835 9.67124 14.3721C8.43363 14.5606 7.16736 14.3788 6.03482 13.85C4.90228 13.3212 3.95512 12.4695 3.3148 11.4041L8.71548 8.22222L5.31799 2.98764Z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentcolor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.75377 13.8172C9.36677 13.7211 8.97029 13.633 8.59271 13.5208C8.33315 13.4448 8.08769 13.3366 7.84229 13.2285C6.88889 12.804 5.88829 12.6879 4.82634 12.8C4.30717 12.8561 3.76439 12.8801 3.25466 12.804C2.0228 12.6238 1.29123 11.5986 1.57442 10.5414C1.79625 9.72843 2.37678 9.12776 3.18386 8.69122C3.84935 8.32683 4.43932 7.89029 5.00097 7.42577C5.34079 7.14143 5.69478 6.86513 6.06764 6.60883C7.29005 5.75183 8.87591 6.30848 9.42341 7.09739C9.71603 7.52188 9.94259 7.97844 10.1786 8.42696C10.4335 8.91953 10.7355 9.38003 11.1272 9.80453C11.6133 10.3292 11.9296 10.9138 12.0192 11.5826C12.175 12.76 11.132 13.7852 9.77735 13.7732C9.76793 13.7811 9.76319 13.7972 9.75377 13.8172Z"/>
                                            <path d="M12.5295 3.94437C12.4729 4.81338 12.0764 5.57026 11.2033 6.10688C10.0894 6.79167 8.85754 6.37519 8.59798 5.23387C8.37142 4.25273 9.01804 3.03932 10.0375 2.53073C11.1844 1.95807 12.3549 2.47066 12.5059 3.61198C12.5154 3.7121 12.5201 3.81222 12.5295 3.94437Z"/>
                                            <path d="M7.89298 3.69445C7.88824 4.21105 7.75137 4.69962 7.39737 5.12812C6.69413 5.9771 5.52362 5.98912 4.8015 5.15615C4.09353 4.3392 4.10297 2.99764 4.82037 2.1887C5.50946 1.4118 6.63276 1.4078 7.33132 2.1807C7.69474 2.57715 7.89298 3.11378 7.89298 3.69445Z"/>
                                            <path d="M11.084 8.04012C11.0887 7.10705 11.9713 6.14994 13.0285 5.93369C14.0433 5.72544 14.8409 6.22602 14.9023 7.11105C14.9683 8.08818 14.0008 9.14941 12.868 9.33763C11.8533 9.50182 11.0793 8.94118 11.084 8.04012Z"/>
                                            <path d="M4.21015 6.15683C4.20071 6.68144 4.08271 7.09392 3.74761 7.44631C3.29452 7.91887 2.59599 8.02703 1.97298 7.72663C0.826079 7.17001 0.42962 5.62422 1.19894 4.71916C1.65204 4.18254 2.41192 4.03837 3.07269 4.38678C3.87505 4.80726 4.15823 5.47204 4.21015 6.15683Z"/>
                                        </svg>
                                    </div>
                                    <span>від <?=round($minPrice['DISCOUNT_VALUE']/3)?> грн/міс</span>
                                </div>
                            <?}
                            ?>
                        </div>
                    </div>
                </div>

                <?
                if($arItem['UF_SIZE']==100){?></div><?}
            }



            $arJsonProducts[] = '{
                    item_id: "'.$arItem['ID'].'", 
                    item_name: "'.addslashes($arItem['NAME']).'",
                    affiliation: "STIMMA", 
                    discount: '.$minPrice['DISCOUNT_DIFF'].', 
                    index: '.$index.',  
                    item_brand: "STIMMA", // якщо є бренд , то вставляємо його. Якщо ні - назву магазину який продає 
                    item_category: "'.addslashes($sectionName).'", 
                    item_list_id: "'.$arItem['ID'].'", 
                    item_list_name: "'.addslashes($arItem['NAME']).'",
                    price: '.$minPrice['VALUE'].', 
                    quantity: 1  
            }';
            $facebookIds[] = $arItem['ID'];

        }
        ?>
        <?
        if(isset($_REQUEST['get_catalog_ajax_filter']) && $_REQUEST['get_catalog_ajax_filter'] == 'y')
        {
            $jsonFilter['elements'] = ob_get_clean();
            $APPLICATION -> RestartBuffer();
            echo $jsonFilter['filter'].'<!--filter-->'.$jsonFilter['elements'].'<!--filter-->'.$arResult['NAV_STRING'];
            die();
        }
        ?>
    </div>

<?=$arResult['NAV_STRING']?>

<?elseif($arParams['IS_CATALOG_PAGE'] == 'Y'):?>
	<div class="no_goods catalog_block_view">
		<div class="no_products">
			<div class="wrap_text_empty">
				<?if($_REQUEST["set_filter"]){?>
					<?$APPLICATION->IncludeFile(SITE_DIR."include/section_no_products_filter.php", Array(), Array("MODE" => "html",  "NAME" => GetMessage('EMPTY_CATALOG_DESCR')));?>
				<?}else{?>
					<?$APPLICATION->IncludeFile(SITE_DIR."include/section_no_products.php", Array(), Array("MODE" => "html",  "NAME" => GetMessage('EMPTY_CATALOG_DESCR')));?>
				<?}?>
			</div>
		</div>
	</div>
<?endif;?>

<?
if($arParams['SEND_STATISTIC'] == 'Y')
{
    ?>
    <script>
        //sendViewItems('view_item_list');
    </script>
    <script>
        dataLayer.push({ ecommerce: null });
        dataLayer.push({
            event: "view_item_list",
            ecommerce: {
                item_list_id: "catalog",
                item_list_name: "<?=addslashes($sectionName)?>",
                items: [
                    <?=implode(',',$arJsonProducts)?>
                ]
            }
        });
    </script>

    <script>
        fbq ( 'track', 'ViewCategory', {content_ids: [<?=implode(',',$facebookIds)?>],
            Content_type: 'view_category',
        });


    </script>
    <?
}
?>

<script>
    var jsonOffers = <?=CUtil::PhpToJSObject($arResult['JSON_VARIANTS'])?>;
</script>
