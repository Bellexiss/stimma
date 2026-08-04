<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$search = $_REQUEST['q'];
$ids = [];
$res = $DB -> Query('select * from b_iblock_element where LOWER(NAME) like \'%'.strtolower($search).'%\' and IBLOCK_ID = 21 and ACTIVE = \'Y\'
    and ID in (select ID from b_catalog_product  where QUANTITY > 0) 
 order by SORT desc, ID desc limit 10');
while ($record = $res -> Fetch())
{
    $ids[$record['ID']] = $record['ID'];
}

if (count($ids) < 10)
{
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, '%PROPERTY_NAME_UA' => $search,'ACTIVE' => 'Y'], false, ['nTopCount' => (10-count($ids))]);
    while ($record = $res -> Fetch())
        $ids[$record['ID']] = $record['ID'];
}

//$arResult =[];
$items = $elements = [];
if(!empty($ids))
{
    $res = CIBlockElement::GetList(['SORT' => 'desc', 'ID'=>'desc'], ['IBLOCK_ID' => 21, 'ID' => $ids]);
    while ($record = $res -> GetNext())
    {

        $name = LANGUAGE_ID == 'ua' ? CIBlockElement::GetProperty(21, $record['ID'], array("sort" => "asc"), Array("CODE"=>"NAME_UA")) -> Fetch()['VALUE'] : $record['NAME'];
        $items[] = [
                'NAME' => $name,
                'URL' => $record['DETAIL_PAGE_URL'],
                'MODULE_ID' => 'iblock',
                'PARAM1' => 'aspro_max_catalog',
                'PARAM2' => '21',
                'ITEM_ID' => $record['ID'],
                'ICON' => 1
        ];

        $img = $record['PREVIEW_PICTURE'];
        if(!$img)
            $img = $record['DETAIL_PICTURE'];

        $img = CFile::ResizeImageGet($img, array('width'=>38, 'height'=>38), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $price = CCatalogProduct::GetOptimalPrice($record['ID'], 1, explode(',',$USER->GetGroups()))['RESULT_PRICE'];
        $basePrice = $DB->Query('select * from b_catalog_price where CATALOG_GROUP_ID = 1 and PRODUCT_ID = ' . $record['ID'])->Fetch()['PRICE'];

        $elements[$record['ID']] = [
                'PICTURE' => $img,
                'MIN_PRICE' => [
                        'DISCOUNT_VALUE' => $price['DISCOUNT_PRICE'],
                        'VALUE' => $basePrice, //$price['BASE_PRICE'],
                        'PRINT_DISCOUNT_VALUE' => FormatCurrency($price['DISCOUNT_PRICE'], 'UAH'),
                        'PRINT_VALUE' =>FormatCurrency($basePrice, 'UAH')
                ]
        ];
    }
}
$arResult = [];
$arResult['CATEGORIES'][0]['ITEMS'] = $items;
$arResult['CATEGORIES']['all']['ITEMS'] = [0 => [
        'NAME' => LANGUAGE_ID == 'ua' ? 'Всі результати' : 'Все результаты',
        'URL' => LANGUAGE_ID == 'ua' ? '/search/?q='.$_REQUEST['q'] : '/ru/search/?q='.$_REQUEST['q']]];
$arResult['ELEMENTS'] = $elements;
?>
<?if (empty($arResult["CATEGORIES"])) return;?>
<div class="bx_searche scrollblock bss1">

	<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
		<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
        <?
            if($arItem['PARAM2'] == 21 && LANGUAGE_ID == 'ua')
            {
                $item = CIBlockElement::GetByID($arItem['ITEM_ID']) -> GetNextElement() -> GetProperties();
                $arItem['NAME'] = $item['NAME_UA']['VALUE'];
            }
            else
                $arItem['NAME'] = strip_tags($arItem['NAME']);
            ?>
			<?//=$arCategory["TITLE"]?>
			<?if(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]]) && $category_id !== "all"):
				$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];?>
				<a class="bx_item_block" href="<?=$arItem["URL"]?>">
					<div class="maxwidth-theme">
						<div class="bx_img_element">
							<?if(is_array($arElement["PICTURE"])):?>
								<img src="<?=$arElement["PICTURE"]["src"]?>">
							<?else:?>
								<img src="<?=SITE_TEMPLATE_PATH?>/images/svg/noimage_product.svg" width="38" height="38">
							<?endif;?>
						</div>
						<div class="bx_item_element">
							<span><?=$arItem["NAME"]?></span>
							<div class="price cost prices">
								<div class="title-search-price">
									<?if(isset($arElement["MIN_PRICE"]) && $arElement["MIN_PRICE"])
                                    {?>
										<?if($arElement["MIN_PRICE"]["DISCOUNT_VALUE"] < $arElement["MIN_PRICE"]["VALUE"]):?>
											<div class="price"><?=$arElement["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"]?></div>
											<div class="price discount">
												<strike><?=$arElement["MIN_PRICE"]["PRINT_VALUE"]?></strike>
											</div>
										<?else:?>
											<div class="price"><?=$arElement["MIN_PRICE"]["PRINT_VALUE"]?></div>
										<?endif;?>
									<?}else{?>
										<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
											<?if($arPrice["CAN_ACCESS"]):?>
												<?if (count($arElement["PRICES"])>1):?>
													<div class="search_price_wrap">
													<div class="price_name"><?=$arResult["PRICES"][$code]["TITLE"];?></div>
												<?endif;?>
												<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
													<div class="price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></div>
													<div class="price discount">
														<strike><?=$arPrice["PRINT_VALUE"]?></strike>
													</div>
												<?else:?>
													<div class="price"><?=$arPrice["PRINT_VALUE"]?></div>
												<?endif;?>
												<?if (count($arElement["PRICES"])>1):?>
													</div>
												<?endif;?>
											<?endif;?>
										<?endforeach;?>
									<?}?>
								</div>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
				</a>
			<?elseif($category_id !== "all"):?>
				<?if($arItem["MODULE_ID"]):?>
					<a class="bx_item_block others_result" href="<?=$arItem["URL"]?>">
						<div class="maxwidth-theme">
							<div class="bx_item_element">
								<span><?=$arItem["NAME"]?></span>
							</div>
							<div style="clear:both;"></div>
						</div>
					</a>
				<?endif;?>
			<?endif;?>
		<?endforeach;?>
	<?endforeach;?>
</div>

<?if(isset($arResult["CATEGORIES"]['all']) ):?>
	<?foreach($arResult["CATEGORIES"]['all']["ITEMS"] as $i => $arItem):?>
		<div class="bx_item_block all_result">
			<div class="bx_item_element">
				<a class="all_result_title btn btn-transparent btn-wide round-ignore" href="<?=$arItem["URL"]?>"><?=$arItem["NAME"]?></a>
			</div>
			<div style="clear:both;"></div>
		</div>
	<?endforeach;?>
<?endif;?>