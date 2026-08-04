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
<?$for = $isNew ? $arParams['FILES'] : $arResult['ITEMS']?>
<?

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

            if(!$isNew)
            {
                /*if(in_array(9,$gGroups) && $arItem['OFFERS'][$arItem['SELECTED_OFFER']]['PRICES']['OPT']['DISCOUNT_VALUE'] > $arItem['OFFERS'][$arItem['SELECTED_OFFER']]['PRICES']['OPT_DISCOUNT']['DISCOUNT_VALUE'])
                {
                    $arItem['OFFERS'][$arItem['SELECTED_OFFER']]['PRICES']['BASE'] =  $arItem['OFFERS'][$arItem['SELECTED_OFFER']]['PRICES']['OPT'];
                    $arItem['OFFERS'][$arItem['SELECTED_OFFER']]['MIN_PRICE'] = $arItem['OFFERS'][$arItem['SELECTED_OFFER']]['PRICES']['OPT_DISCOUNT'];
                }*/
            }


            $skip = false;
            $myIndexes[] = $myIndex . ' => ' . $arItem['UF_SIZE'];
            if(LANGUAGE_ID == 'ru' && strpos($arItem['DETAIL_PAGE_URL'], '/ru/') === false)
                $arItem['DETAIL_PAGE_URL'] = '/ru'.$arItem['DETAIL_PAGE_URL'];

            $dopClass = 'w-33';
            $img = false;

            if($isNew && $myIndex%2==0){?><div class="catalog-items-block-center"><?}

            if($isNew)
            {
                /*if($myIndex%2==0){?><div class="catalog-items-block-center"><?}*/
                //$img = isset($_GET['p']) ? $arItem['UF_FILE'] : '/upload/new_files/'.$arItem['UF_FILE'];
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

                        <div my_index="<?=$myIndex?>-<?=$arItem['UF_SIZE']?>" class="catalog-item-cont <?=$dopClass?>">
                            <div class="catalog-item-block">
                                <div class="catalog-item-img">
                                    <?
                                    if(isset($_GET['p']) || true)
                                        {
                                            ?><img src="<?=$arItem['UF_FILE']?>"><?
                                        }
                                    else
                                        {
                                            ?><img src="/upload/new_files/<?=$arItem['UF_FILE']?>"><?
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
                    /*if($arItem['PROPERTIES']["ACTION"]["VALUE"] && isset($arParams['ACTION']))
                    {
                        if($arItem['PROPERTIES']["ACTION_R"]["VALUE_XML_ID"] == 'photo4')
                            $dopClass = 'w-50 offset-3';
                        elseif($arItem['PROPERTIES']["ACTION_R"]["VALUE_XML_ID"] == 'photo2')
                            $dopClass = 'w-50';
                    }*/
                    if(1)
                    {
                        $item = $arItem['OFFERS'][0];

                        if(!$img)
                            $img = $item['DETAIL_PICTURE']['ID'];

                        if(!$img)
                            $img = $item['PREVIEW_PICTURE'];

                        if(!$img)
                            $img = $arItem['DETAIL_PICTURE'];
                        if(!$img)
                            $img = $arItem['PREVIEW_PICTURE'];
                    }

                    if(isset($img['ID'])) $img = $img['ID'];

                    if(!$isNew)
                    {
                        //if($dopClass)
                        //    $img = CFile::GetFileArray($img)['SRC'];
                        //else
                        $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                    }



                    $minPrice = $item['MIN_PRICE'];
                    /*if($isNew && $myIndex%2==0){?><div class="catalog-items-block-center"><?}*/
                    ?>
                    <div my_index="<?=$myIndex?>-<?=$arItem['UF_SIZE']?>" data-entity="scu" class="<?=$arParams['BLOCK_CLASS'] ? $arParams['BLOCK_CLASS'] : 'catalog-item-cont'?> <?=$dopClass?>" data-item="<?=$arItem['ID']?>" offer-item="<?=$arItem['OFFERS'][0]['ID']?>">
                        <div class="catalog-item-block <?=($item['PRICES']['BASE']['DISCOUNT_VALUE'] > $minPrice['DISCOUNT_VALUE']) ? 'catalog-item-block-discount' : ''?>"  data-entity="scu-values">
                            <div <?/*onclick="addViewItem(<?=$arItem['ID']?>, '<?=addslashes($arItem['NAME'])?>', <?=$minPrice['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', <?=($index+1)?>, 'select_item',true)"*/?> class="catalog-item-img">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                    <img src="<?=$img?>">
                                </a>
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
                                        <?/*<div class="catalog-item-size " data-entity="scu-value" data-id="<?=$indexProp?>"><?=mb_strtoupper($prop)?></div>*/?>
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
                                <div class="card-stars-block">
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
                                    //if(empty($arItem['OFFERS']) && strpos($APPLICATION->GetCurPage(), '/catalog/novinki/') === false)
                                    if(empty($arItem['OFFERS'])/*$arResult['SKIP_OFFERS']*/)
                                    {
                                        ?>
                                        <div class="card-badge-item no-available">
                                            <?=LANGUAGE_ID=='ua'?'Немає в наявності':'Нет в наличии'?>
                                        </div>
                                        <?
                                    }

                                    if(in_array('novaya_kollektsiya', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID']))
                                    {
                                        ?><div class="card-badge-item new">NEW</div><?
                                    }
                                    if(in_array('khit_prodazh', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID']))
                                    {
                                        ?><div class="card-badge-item hit">Хіт продажу</div><?
                                    }
                                    if(in_array('rasprodazha', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID']))
                                    {
                                        ?><div class="card-badge-item action cbia1">SALE</div><?
                                    }
                                    //if($minPrice['DISCOUNT_DIFF'] && !$arParams['IS_NEW'] && !$arParams['IS_SALE'])
                                    if($minPrice['DISCOUNT_DIFF'] && (in_array('rasprodazha', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID']) || in_array('khit_prodazh', $item['PROPERTIES']['SELECTION']['VALUE_XML_ID'])))
                                        {
                                            ?><div class="card-badge-item action cbia2">-<?=$minPrice['DISCOUNT_DIFF_PERCENT']?>%</div><?
                                        }
                                    ?>
                                </div>
                            </div>
                            <div <?/*onclick="addViewItem(<?=$arItem['ID']?>, '<?=addslashes($arItem['NAME'])?>', <?=$minPrice['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', <?=($index+1)?>, 'select_item',true)"*/?> class="catalog-item-name-block">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="catalog-item-name" data-entity="name"><?/*Жіноча сукня*/?><?=$arItem['NAME']?></a>
                                <?
                                if(in_array('STOCK', $arItem['PROPERTIES']['HIT']['VALUE_XML_ID']) )
                                {
                                    ?><div class="catalog-item-sale">SALE</div><?
                                }
                                ?>
                            </div>
                            <?

                            ?>
                            <div class="catalog-item-info">
                                <div class="catalog-item-price">
                                    <div class="catalog-item-price-currency" data-entity="price"><?=$minPrice['PRINT_DISCOUNT_VALUE']?></div>
                                    <?
                                    //if($item['PRICES']['BASE']['DISCOUNT_DIFF'])
                                    if($minPrice['DISCOUNT_DIFF'])
                                    {
                                        ?><div class="catalog-item-price-old cip1"><?=$item['PRICES']['BASE']['PRINT_VALUE']?></div><?
                                    }
                                    ?>
                                </div>
                                <div class="catalog-item-colors" data-code="COLOR_REF">
                                    <?
                                    $noImg = '/bitrix/templates/aspro_max/images/colorimg.png'; // todo Не должно быть пустого
                                    //foreach ($tree[$arItem['ID']]['props']['COLOR_REF']['values'] as $indexProp => $prop)

                                    foreach ($arResult['COLOR_VARIANTS'][$arResult['COLOR_IDS'][$arItem['ID']]] as $indexProp => $prop)
                                    {
                                        //foreach ($props as $index => $prop)
                                        {
                                            /*if($arResult['FILE_COLORS'][$prop])
                                             $file = CFile::ResizeImageGet($arResult['FILE_COLORS'][$prop], array('width'=>10, 'height'=>10), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                                         else
                                             $file = $noImg;*/
                                            $variants[$prop['code']] = $prop;
                                            ?>
                                            <a onclick="changeData('<?=$prop['code']?>', this);return false;" style="background-color: <?=$arResult['ALL_MAIN_COLORS'][$prop['color']]?>;" href="#" class="catalog-item-color <?=strtoupper($arResult['ALL_COLORS'][$prop['color']]) == '#FFFFFF' ? 'white' : ''?> <?=$indexProp == $arItem['PROPERTIES']['COLOR']['VALUE'] ? 'active' : ''?>" data-entity="scu-value" data-id="<?=$indexProp?>">
                                                <?/*<img src="<?=$file?>">*/?>
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
                    if($arParams['SEND_STATISTIC'] == 'Y')
                        {
                            /*?>
                            <script>
                                addViewItem(<?=$arItem['ID']?>, '<?=addslashes($arItem['NAME'])?>', <?=$minPrice['DISCOUNT_VALUE']?>, '<?=addslashes($sectionName)?>', <?=($index+1)?>,'');
                            </script>
                            <?*/
                        }

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
    <?
}
?>

