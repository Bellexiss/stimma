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
        //echo "<pre>";print_R($prod["PROPERTIES"]['MINIMUM_PRICE']);echo "</pre>";//exit();
    }
    //echo "<pre>";print_R($sv_prices);echo "</pre>";
    //exit();
}

?>
<?$gGroups = explode(',',$USER -> GetGroups());?>
<?if($arResult["ITEMS"] || $for):?>
    <?
    $selected = 0;
    $available = true; //$arItem['PRODUCT']['AVAILABLE']; //todo змінити
    //$availableTextIn = GetMessage('EX_IN_STORE ');
    //$availableTextOut = GetMessage('NO_EX_IN_STORE ');
    $tree = $arResult['TREE_PROPS'];
    ?>
    <div class="insertpag loadmore_container <?=$isNew ? 'catalog-items-block-center' : ''?> <?=$arParams['WRAP_CLASS'] ? $arParams['WRAP_CLASS'] : 'catalog-items-block'?>">
        <?
        if(isset($_REQUEST['get_catalog_ajax_filter']) && $_REQUEST['get_catalog_ajax_filter'] == 'y')
        {
            global $jsonFilter;
            ob_start();
        }
        $myIndex = 0;
        $myIndexes = [];



        foreach ($for as $index => $arItem)
        {
            if($index == 8 && $bIndex) break;

            $skip = false;
            $myIndexes[] = $myIndex . ' => ' . $arItem['UF_SIZE'];
            if(LANGUAGE_ID == 'ru' && strpos($arItem['DETAIL_PAGE_URL'], '/ru/') === false)
                $arItem['DETAIL_PAGE_URL'] = '/ru'.$arItem['DETAIL_PAGE_URL'];

            $dopClass = $isNew ? 'w-33' : 'w-25';
            $img = false;

            if($isNew && $myIndex%2==0){?><div class="catalog-items-block-center"><?}

            if($isNew)
            {
                $img = $arItem['UF_FILE'];

                if($arItem['UF_SIZE'] == 100)
                {
                    $size = getimagesize($_SERVER['DOCUMENT_ROOT'].$img);
                    if($size[0] < $size[1]) // 0 - Ширина
                        $dopClass = 'w-33 wm-100';
                    else
                        $dopClass = 'w-66';
                }
                elseif($arItem['UF_SIZE'] == 200)
                {
                    $dopClass = 'w-66';
                }
                if($arItem['UF_PRODUCT_ID'] > 0)
                {
                    $ufSize = $arItem['UF_SIZE'];
                    $arItem = $arResult['ITEMS'][$arResult['RELATION'][$arItem['UF_PRODUCT_ID']]];
                    $arItem['UF_SIZE'] = $ufSize;

                }
                else
                {

                    //$dopClass = 'w-'.$arItem['UF_SIZE'];
                    /*if($myIndex%2==0){?><div class="catalog-items-block-center"><?}*/
                    ?>

                    <div my_index="<?=$myIndex?>-<?=$arItem['UF_SIZE']?>" class="catalog-item-cont <?=$dopClass?>" style="min-height: 100%;">
                        <div class="catalog-item-block">
                            <div class="catalog-item-img">
                                <?
                                if(isset($_GET['p']) || true)
                                {
                                    ?><img  src="<?=convertToWebP($arItem['UF_FILE'])?>" class="img1"><?
                                }
                                else
                                {
                                    ?><img src="/upload/new_files/<?=$arItem['UF_FILE']?>" class="img2"><?
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                    <?
                    /*if($arItem['UF_SIZE'] == 100) $myIndex += 2; else $myIndex++;*/
                    /*if($myIndex%2==0){?></div><?}*/

                    //continue;
                    $skip = true;
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
                    $res = $DB->Query('select * from b_iblock_element_property where IBLOCK_PROPERTY_ID = 239 and IBLOCK_ELEMENT_ID = ' . $item['PROPERTIES']['CML2_LINK']['VALUE']);
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

                    }
                }
                else
                    $slider = [$img];


                $minPrice = $item['MIN_PRICE'];

                ?>
                <div number_index="<?=$index?>" my_index="<?=$myIndex?>-<?=$arItem['UF_SIZE']?>" data-entity="scu" class="<?=$arParams['BLOCK_CLASS'] ? $arParams['BLOCK_CLASS'] : 'catalog-item-cont'?> <?=$dopClass?>" data-item="<?=$arItem['ID']?>" offer-item="<?=$arItem['OFFERS'][0]['ID']?>" style="min-height: 100%;">
                    <div class="catalog-item-block <?=($item['PRICES']['BASE']['DISCOUNT_VALUE'] > $minPrice['DISCOUNT_VALUE']) ? 'catalog-item-block-discount' : ''?>"  data-entity="scu-values">
                        <div <?/*onclick="addViewItem(<?=$arItem['ID']?>, '<?=addslashes($arItem['NAME'])?>', <?=$minPrice['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', <?=($index+1)?>, 'select_item',true)"*/?> class="catalog-item-img">
                            <?
                            if($novinki)
                            {
                                ?>
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>">
                                    <img  src="<?=convertToWebP($img)?>" class="img3">
                                </a>
                                <?
                            }
                            else
                            {
                                ?>
                                <div class="catalog-item-img-slider <?=$arParams['ONLY_SECOND'] ? 'no-slick' : ''?>">
                                    <?

                                    if(isset($slider[1]) && ($arParams['ONLY_SECOND'] || strpos($APPLICATION->GetCurPage(), '/catalog/love_sale/') !== false || strpos($APPLICATION->GetCurPage(), '/catalog/rasprodazha/') !== false || strpos($APPLICATION->GetCurPage(), '/catalog/khity_prodazh/') !== false))
                                    {
                                        if($arParams['ONLY_SECOND'])
                                            $slider = [$slider[1]];
                                        else
                                        {
                                            $firstEl = $slider[0];
                                            unset($slider[0]);
                                            $slider[] = $firstEl;
                                        }


                                    }
                                    $indexSlider = 1;
                                    foreach($slider as $indexPhoto => $src)
                                    {
                                        ?>
                                        <div class="catalog-item-img-slider-el">
                                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>">
                                                <img  <?/*src="<?=getLazySrc()?>" data-lazzysrc="<?=$src?>"*/?> src="<?=convertToWebP($src)?>" alt="<?=$arItem['NAME']?>, фото <?=($indexSlider)?>" title="<?=$arItem['NAME']?>, фото <?=($indexSlider)?>" class="img4">
                                            </a>
                                        </div>
                                        <?
                                        $indexSlider++;
                                        if($bIndex) break;
                                    }
                                    ?>
                                </div>
                                <?
                            }
                            ?>


                            <div class="catalog-item-size-list cisl1" data-code="RAZMER">
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
                                    ?>
                                    <?/*<div class="catalog-item-size " data-entity="scu-value" data-id="<?=$indexProp?>"><?=mb_strtoupper($prop)?></div>*/?>
                                    <div class="catalog-item-size <?=!$indexOFfer ? 'active' : ''?> <?/*no-size*/?>" data-entity="scu-value" data-id="<?=$offer['ID']?>">
                                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>">
                                            <?=mb_strtoupper($offer)?>
                                        </a>
                                    </div>
                                    <?
                                }

                                ?>
                            </div>

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
                                if(empty($arItem['OFFERS']) && !$novinki && !$isOutdoor && !$isEvents && !$isCruise&& !$isSmartOffice && !$isComfort && !$isCasual)
                                {
                                    ?>
                                    <div class="card-badge-item no-available">
                                        <?=LANGUAGE_ID=='ua'?'Немає в наявності':'Нет в наличии'?>
                                    </div>
                                    <?
                                }
                                if($minPrice['DISCOUNT_DIFF'] && (in_array('rasprodazha', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID']) || in_array('khit_prodazh', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID'])))
                                {
                                    ?><div class="card-badge-item action cbia2">-<?=$minPrice['DISCOUNT_DIFF_PERCENT']?>%</div><?
                                }
                                if($arItem['PROPERTIES']['SOON']['VALUE'])
                                {
                                    ?><div class="card-badge-item soon cbia2" style="background-color: #c1a68b; font-size:14px;"><?=LANGUAGE_ID == 'ua' ? 'Передзамовлення' : 'Предзаказ'?></div><?
                                }
                                if(!$isOutdoor && !$isEvents && !$isCruise&& !$isSmartOffice && !$isComfort && !$isCasual)
                                {
                                    $isLimited = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $arItem['ID'] . ' and IBLOCK_SECTION_ID = 1250');
                                    if($isLimited -> Fetch() && strpos($APPLICATION->GetCurPage(),'/limited/') === false)
                                    {
                                        ?><div class="card-badge-item limited cbia2" style="background-color: gray; font-size:14px;">LIMITED</div><?
                                    }
                                }

                                ?>
                            </div>
                        </div>
                        <div <?/*onclick="addViewItem(<?=$arItem['ID']?>, '<?=addslashes($arItem['NAME'])?>', <?=$minPrice['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', <?=($index+1)?>, 'select_item',true)"*/?> class="catalog-item-name-block">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" aria-label="<?=$arItem['NAME']?>" class="catalog-item-name" data-entity="name"><?/*Жіноча сукня*/?><?=$arItem['NAME']?></a>
                            <div class="catalog-item-favorite">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" data-id="<?=$arItem['ID']?>" aria-label="<?=LANGUAGE_ID == 'ua' ? 'Додати в обране' : 'Добавить в избранное'?>">
                                    <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#000" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <?

                        ?>
                        <div class="catalog-item-info">
                            <div class="catalog-item-price">

                                <?
                                global $USER;
                                //PR($arItem['PROPERTIES']['PROP_BONUS']['VALUE']);
                                //PR($item['PRICES']);
                                //if ($USER->IsAdmin()):
                                ?>
                                <? if ($arItem['PROPERTIES']['PROP_BONUS']['VALUE'] &&$item['PRICES']['BASE']['VALUE']){ ?>
                                    <? //$bonusPrice = $arItem['PROPERTIES']['PROP_BONUS_PRICE']['VALUE'];?>
                                    <? $bonusPrice = $item['PRICES']['BASE']['VALUE'];?>
                                    <div class="catalog-item-price-currency">
                                        <?= UA ? "$bonusPrice стімзів" : "$bonusPrice стимзов" ?>
                                    </div>
                                <? }else{ ?>
                                    <div class="catalog-item-price-currency" data-entity="price"><?=$minPrice['PRINT_DISCOUNT_VALUE']?></div>
                                <?}?>
                                <?
                                //if($item['PRICES']['BASE']['DISCOUNT_DIFF'])
                                if($minPrice['DISCOUNT_DIFF'])
                                {
                                    ?><div class="catalog-item-price-old cip3"><?=$item['PRICES']['BASE']['PRINT_VALUE']?></div><?
                                }
                                ?>
                            </div>
                            <div class="catalog-item-colors cic4" data-code="COLOR_REF">
                                <?
                                $noImg = '/bitrix/templates/aspro_max/images/colorimg.png'; // todo Не должно быть пустого
                                //foreach ($tree[$arItem['ID']]['props']['COLOR_REF']['values'] as $indexProp => $prop)

                                foreach ($arResult['COLOR_VARIANTS'][$arResult['COLOR_IDS'][$arItem['ID']]] as $indexProp => $prop)
                                {
                                    $variants[$prop['code']] = $prop;
                                    ?>
                                    <a onclick="changeData('<?=$prop['code']?>', this);return false;" style="background-color: <?=$arResult['ALL_MAIN_COLORS'][$prop['color']]?>;" aria-label="<?=$arResult['COLOR_LIST'][$prop['color']]?> <?=LANGUAGE_ID == 'ua' ? 'колір' : 'цвет'?>" href="#" class="catalog-item-color <?=strtoupper($arResult['ALL_COLORS'][$prop['color']]) == '#FFFFFF' ? 'white' : ''?> <?=$indexProp == $arItem['PROPERTIES']['COLOR']['VALUE'] ? 'active' : ''?>" data-entity="scu-value" data-id="<?=$indexProp?>">
                                    </a>
                                    <?
                                }
                                ?>
                            </div>
                        </div>


                    </div>
                </div>
                <?
            }


            if($isNew && ($arItem['UF_SIZE'] == 100 || $arItem['UF_SIZE'] == 200)) $myIndex += 2; else $myIndex++;
            if($isNew && $myIndex%2==0){?></div><?}


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

