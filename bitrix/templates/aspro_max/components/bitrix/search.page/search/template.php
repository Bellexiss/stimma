<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<div class="search-page-wrap">
	<div class="searchinput">
		<form action="" method="get">
			<div class="form-control">
			<?if( $arParams["USE_SUGGEST"] === "Y" )
            {
				if(strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"]))
				{
					$arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
					$obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
					$obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
				}
				?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:search.suggest.input",
					"",
					array(
						"NAME" => "q",
						"VALUE" => $arResult["REQUEST"]["~QUERY"],
						"INPUT_SIZE" => 40,
						"DROPDOWN_SIZE" => 10,
						"FILTER_MD5" => $arResult["FILTER_MD5"],
					),
					$component, array("HIDE_ICONS" => "Y")
				);?>
			<?}
            else
            {?>
				<input class="q" type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
			<?}?>
		<?if( $arParams["SHOW_WHERE"] ){?>
			&nbsp;<select class="where" name="where">
				<option value=""><?=GetMessage("SEARCH_ALL")?></option>
				<?foreach($arResult["DROPDOWN"] as $key=>$value):?>
					<option value="<?=$key?>"<?if($arResult["REQUEST"]["WHERE"]==$key) echo " selected"?>><?=$value?></option>
				<?endforeach?>
			</select>
		<?}?>
			</div>
			<?/*<button class="btn btn-search" type="submit" name="s" value="<?=GetMessage("SEARCH_GO")?>"><i class="svg svg-search svg-black"></i></button>*/?>
			<button type="submit" class="btn btn-default btn-lg"><?=GetMessage("SEARCH_GO")?></button>
			<input type="hidden" name="how" value="<?=$arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
		<?if( $arParams["SHOW_WHEN"] ){?>
			<div style="clear: both;"></div>
			<div id="search_params" class="search-page-params">
				<?$APPLICATION->IncludeComponent(
					'bitrix:main.calendar',
					'',
					array(
						'SHOW_INPUT' => 'Y',
						'INPUT_NAME' => 'from',
						'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
						'INPUT_NAME_FINISH' => 'to',
						'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
						'INPUT_ADDITIONAL_ATTR' => 'size="10"',
					),
					null,
					array('HIDE_ICONS' => 'Y')
				);?>
			</div>
		<?}?>
		</form>
	</div>
	<?if( isset( $arResult["REQUEST"]["ORIGINAL_QUERY"] ) ){?>
		<div class="search-language-guess">
			<?=GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
		</div><br /><?
	}
    ?>
	<?/*if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>
	<?elseif($arResult["ERROR_CODE"]!=0 && false):?>
		<p><?=GetMessage("SEARCH_ERROR")?></p>
		<?ShowError($arResult["ERROR_TEXT"]);?>
		<p><?=GetMessage("SEARCH_CORRECT_AND_CONTINUE")?></p>
		
		<p><?=GetMessage("SEARCH_SINTAX")?><br /><b><?=GetMessage("SEARCH_LOGIC")?></b></p>
		<table border="0" cellpadding="5">
			<tr>
				<td align="center" valign="top"><?=GetMessage("SEARCH_OPERATOR")?></td><td valign="top"><?=GetMessage("SEARCH_SYNONIM")?></td>
				<td><?=GetMessage("SEARCH_DESCRIPTION")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("SEARCH_AND")?></td><td valign="top">and, &amp;, +</td>
				<td><?=GetMessage("SEARCH_AND_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("SEARCH_OR")?></td><td valign="top">or, |</td>
				<td><?=GetMessage("SEARCH_OR_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("SEARCH_NOT")?></td><td valign="top">not, ~</td>
				<td><?=GetMessage("SEARCH_NOT_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top">( )</td>
				<td valign="top">&nbsp;</td>
				<td><?=GetMessage("SEARCH_BRACKETS_ALT")?></td>
			</tr>
		</table>
	<?elseif(count($arResult["SEARCH"])>0):*/?>
    <!---sPage-->
    <?
        $search = addslashes($_GET['q']);
        $ids = [];

        $res = $DB -> Query('select ID from b_iblock_element where ACTIVE = \'Y\' and LOWER(NAME) like \'%'.strtolower($search).'%\'');
        while ($record = $res -> Fetch())
            $ids[$record['ID']] = $record['ID'];

        $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, '%PROPERTY_NAME_UA' => trim($search),'ACTIVE' => 'Y']);
        while ($record = $res -> Fetch())
            $ids[$record['ID']] = $record['ID'];


        if(!empty($ids))
        {
            global $favorite;
            $favorite = ['ID' => $ids];

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "main",
                [
                    'IBLOCK_TYPE' => 'aspro_max_catalog',
                    'IBLOCK_ID' => '21',
                    'ELEMENT_SORT_FIELD' => 'SORT',
                    'ELEMENT_SORT_ORDER' => 'DESC',
                    'ELEMENT_SORT_FIELD2' => 'ID',
                    'ELEMENT_SORT_ORDER2' => 'DESC',
                    'PROPERTY_CODE' => [
                        0 => 'HIT',
                        1 => 'BRAND',
                        2 => 'CML2_ARTICLE',
                        3 => 'PROP_2104',
                        4 => 'PODBORKI',
                        5 => 'PROP_2033',
                        6 => 'COLOR_REF2',
                        7 => 'PROP_305',
                        8 => 'PROP_352',
                        9 => 'PROP_317',
                        10 => 'PROP_357',
                        11 => 'PROP_2102',
                        12 => 'PROP_318',
                        13 => 'PROP_159',
                        14 => 'PROP_349',
                        15 => 'PROP_327',
                        16 => 'PROP_2052',
                        17 => 'PROP_370',
                        18 => 'PROP_336',
                        19 => 'PROP_2115',
                        20 => 'PROP_346',
                        21 => 'PROP_2120',
                        22 => 'PROP_2053',
                        23 => 'PROP_363',
                        24 => 'PROP_320',
                        25 => 'PROP_2089',
                        26 => 'PROP_325',
                        27 => 'PROP_2103',
                        28 => 'PROP_2085',
                        29 => 'PROP_300',
                        30 => 'PROP_322',
                        31 => 'PROP_362',
                        32 => 'PROP_365',
                        33 => 'PROP_359',
                        34 => 'PROP_284',
                        35 => 'PROP_364',
                        36 => 'PROP_356',
                        37 => 'PROP_343',
                        38 => 'PROP_2083',
                        39 => 'PROP_314',
                        40 => 'PROP_348',
                        41 => 'PROP_316',
                        42 => 'PROP_350',
                        43 => 'PROP_333',
                        44 => 'PROP_332',
                        45 => 'PROP_360',
                        46 => 'PROP_353',
                        47 => 'PROP_347',
                        48 => 'PROP_25',
                        49 => 'PROP_2114',
                        50 => 'PROP_301',
                        51 => 'PROP_2101',
                        52 => 'PROP_2067',
                        53 => 'PROP_323',
                        54 => 'PROP_324',
                        55 => 'PROP_355',
                        56 => 'PROP_304',
                        57 => 'PROP_358',
                        58 => 'PROP_319',
                        59 => 'PROP_344',
                        60 => 'PROP_328',
                        61 => 'PROP_338',
                        62 => 'PROP_2065',
                        63 => 'PROP_366',
                        64 => 'PROP_302',
                        65 => 'PROP_303',
                        66 => 'PROP_2054',
                        67 => 'PROP_341',
                        68 => 'PROP_223',
                        69 => 'PROP_283',
                        70 => 'PROP_354',
                        71 => 'PROP_313',
                        72 => 'PROP_2066',
                        73 => 'PROP_329',
                        74 => 'PROP_342',
                        75 => 'PROP_367',
                        76 => 'PROP_2084',
                        77 => 'PROP_340',
                        78 => 'PROP_351',
                        79 => 'PROP_368',
                        80 => 'PROP_369',
                        81 => 'PROP_331',
                        82 => 'PROP_337',
                        83 => 'PROP_345',
                        84 => 'PROP_339',
                        85 => 'PROP_310',
                        86 => 'PROP_309',
                        87 => 'PROP_330',
                        88 => 'PROP_2017',
                        89 => 'PROP_335',
                        90 => 'PROP_321',
                        91 => 'PROP_308',
                        92 => 'PROP_206',
                        93 => 'PROP_334',
                        94 => 'PROP_2100',
                        95 => 'PROP_311',
                        96 => 'PROP_2132',
                        97 => 'SHUM',
                        98 => 'PROP_361',
                        99 => 'PROP_326',
                        100 => 'PROP_315',
                        101 => 'PROP_2091',
                        102 => 'PROP_2026',
                        103 => 'PROP_307',
                        104 => 'PROP_2027',
                        105 => 'PROP_2098',
                        106 => 'PROP_2122',
                        107 => 'PROP_24',
                        108 => 'PROP_2049',
                        109 => 'PROP_22',
                        110 => 'PROP_2095',
                        111 => 'PROP_2044',
                        112 => 'PROP_162',
                        113 => 'PROP_2055',
                        114 => 'PROP_2069',
                        115 => 'PROP_2062',
                        116 => 'PROP_2061',
                        117 => 'CML2_LINK',
                        118 => 'RZMER',
                    ],
                    'PROPERTY_CODE_MOBILE' => '',
                    'META_KEYWORDS' => '-',
                    'META_DESCRIPTION' => '-',
                    'BROWSER_TITLE' => '-',
                    'SET_LAST_MODIFIED' => 'Y',
                    'INCLUDE_SUBSECTIONS' => 'Y',
                    'BASKET_URL' => '/basket/',
                    'ACTION_VARIABLE' => 'action',
                    'PRODUCT_ID_VARIABLE' => 'id',
                    'SECTION_ID_VARIABLE' => 'SECTION_ID',
                    'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
                    'PRODUCT_PROPS_VARIABLE' => 'prop',
                    'FILTER_NAME' => 'favorite',
                    'CACHE_TYPE' => 'N',
                    'CACHE_TIME' => '3600000',
                    'CACHE_FILTER' => 'Y',
                    'CACHE_GROUPS' => 'Y',
                    'SET_TITLE' => 'N',
                    'MESSAGE_404' => '',
                    'SET_STATUS_404' => 'Y',
                    'SHOW_404' => 'Y',
                    'FILE_404' => '',
                    'DISPLAY_COMPARE' => 'Y',
                    'PAGE_ELEMENT_COUNT' => '30',
                    'LINE_ELEMENT_COUNT' => '4',
                    'PRICE_CODE' => [0 => 'BASE','DISCOUNT','OPT','OPT_DISCOUNT'],
                    'USE_PRICE_COUNT' => 'N',
                    'SHOW_PRICE_COUNT' => '1',
                    'PRICE_VAT_INCLUDE' => 'Y',
                    'USE_PRODUCT_QUANTITY' => 'Y',
                    'ADD_PROPERTIES_TO_BASKET' => 'N',
                    'PARTIAL_PRODUCT_PROPERTIES' => 'Y',
                    'PRODUCT_PROPERTIES' => '',
                    'DISPLAY_TOP_PAGER' => 'N',
                    'DISPLAY_BOTTOM_PAGER' => 'N',
                    'PAGER_TITLE' => 'Товары',
                    'PAGER_SHOW_ALWAYS' => 'N',
                    'PAGER_TEMPLATE' => 'main',
                    'PAGER_DESC_NUMBERING' => 'N',
                    'PAGER_DESC_NUMBERING_CACHE_TIME' => '36000',
                    'PAGER_SHOW_ALL' => 'N',
                    'PAGER_BASE_LINK_ENABLE' => 'N',
                    'PAGER_BASE_LINK' => null,
                    'PAGER_PARAMS_NAME' => null,
                    'LAZY_LOAD' => 'N',
                    'MESS_BTN_LAZY_LOAD' => null,
                    'LOAD_ON_SCROLL' => 'N',
                    'OFFERS_CART_PROPERTIES' => '',
                    'OFFERS_FIELD_CODE' => [0 => 'NAME',
                                            1 => 'CML2_LINK',
                                            2 => 'DETAIL_PAGE_URL',
                                            3 => '',],
                    'OFFERS_PROPERTY_CODE' => [0 => 'ARTICLE',
                                               1 => 'SPORT',
                                               2 => 'SIZES2',
                                               3 => 'MORE_PHOTO',
                                               4 => 'VOLUME',
                                               5 => 'SIZES',
                                               6 => 'SIZES5',
                                               7 => 'SIZES4',
                                               8 => 'SIZES3',
                                               9 => 'COLOR_REF',
                                               10 => 'RAZMER',],
                    'OFFERS_SORT_FIELD' => 'ID',
                    'OFFERS_SORT_ORDER' => 'desc',
                    'OFFERS_SORT_FIELD2' => 'sort',
                    'OFFERS_SORT_ORDER2' => 'asc',
                    'OFFERS_LIMIT' => '10',
                    'SECTION_ID' => '',
                    'SECTION_CODE' => '',
                    'SECTION_URL' => '/catalog/#SECTION_CODE_PATH#/',
                    'DETAIL_URL' => '/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
                    'USE_MAIN_ELEMENT_SECTION' => 'Y',
                    'CONVERT_CURRENCY' => 'Y',
                    'CURRENCY_ID' => 'UAH',
                    'HIDE_NOT_AVAILABLE' => 'N',
                    'HIDE_NOT_AVAILABLE_OFFERS' => 'N',
                    'LABEL_PROP' => '',
                    'LABEL_PROP_MOBILE' => null,
                    'LABEL_PROP_POSITION' => null,
                    'ADD_PICT_PROP' => 'MORE_PHOTO',
                    'PRODUCT_DISPLAY_MODE' => 'Y',
                    'PRODUCT_BLOCKS_ORDER' => 'price,props,sku,quantityLimit,quantity,buttons,compare',
                    'PRODUCT_ROW_VARIANTS' => '[{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false}]',
                    'ENLARGE_PRODUCT' => 'STRICT',
                    'ENLARGE_PROP' => '',
                    'SHOW_SLIDER' => 'Y',
                    'SLIDER_INTERVAL' => '3000',
                    'SLIDER_PROGRESS' => 'N',
                    'OFFER_ADD_PICT_PROP' => 'MORE_PHOTO',
                    'OFFER_TREE_PROPS' => [0 => 'COLOR_REF',
                                           1 => 'RAZMER',],
                    'PRODUCT_SUBSCRIPTION' => 'Y',
                    'SHOW_DISCOUNT_PERCENT' => 'Y',
                    'DISCOUNT_PERCENT_POSITION' => null,
                    'SHOW_OLD_PRICE' => 'Y',
                    'SHOW_MAX_QUANTITY' => 'N',
                    'MESS_SHOW_MAX_QUANTITY' => '',
                    'RELATIVE_QUANTITY_FACTOR' => '',
                    'MESS_RELATIVE_QUANTITY_MANY' => '',
                    'MESS_RELATIVE_QUANTITY_FEW' => '',
                    'MESS_BTN_BUY' => 'Купить',
                    'MESS_BTN_ADD_TO_BASKET' => 'В корзину',
                    'MESS_BTN_SUBSCRIBE' => 'Подписаться',
                    'MESS_BTN_DETAIL' => 'Подробнее',
                    'MESS_NOT_AVAILABLE' => 'Нет в наличии',
                    'MESS_BTN_COMPARE' => 'Сравнение',
                    'USE_ENHANCED_ECOMMERCE' => 'N',
                    'DATA_LAYER_NAME' => '',
                    'BRAND_PROPERTY' => '',
                    'TEMPLATE_THEME' => 'blue',
                    'ADD_SECTIONS_CHAIN' => 'N',
                    'ADD_TO_BASKET_ACTION' => 'ADD',
                    'SHOW_CLOSE_POPUP' => 'N',
                    'COMPARE_PATH' => '',
                    'COMPARE_NAME' => 'CATALOG_COMPARE_LIST',
                    'USE_COMPARE_LIST' => 'Y',
                    'BACKGROUND_IMAGE' => '-',
                    'COMPATIBLE_MODE' => 'Y',
                    'DISABLE_INIT_JS_IN_COMPONENT' => 'N',
                    'WRAP_CLASS' => '',
                    'BLOCK_CLASS' => '',
                ],
                false
            );

        }
        else
        {
            ?>
            <div class="alert alert-danger"><?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?></div>
            <?
        }


        ?>
    <?/*
		<?//sort?>
		<div class="dropdown-select">
			<div class="dropdown-select__title font_xs darken">
				<span>
					<?if($arResult["REQUEST"]["HOW"]=="d"):?>
						<?=GetMessage("SEARCH_BY_DATE")?>
					<?else:?>
						<?=GetMessage("SEARCH_BY_RANK")?>
					<?endif;?>
				</span>
				<?=CMax::showIconSvg("down", SITE_TEMPLATE_PATH.'/images/svg/trianglearrow_down.svg', '', '', true, false);?>
			</div>
			<div class="dropdown-select__list dropdown-menu-wrapper" role="menu">
				<div class="dropdown-menu-inner rounded3">
					<div class="dropdown-select__list-item font_xs">
						<?if($arResult["REQUEST"]["HOW"]!="d"):?>
							<span class="dropdown-select__list-link dropdown-select__list-link--current">
						<?else:?>
							<a href="<?=$arResult["URL"]?>&amp;how=r<?=$arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?=$arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>" class="dropdown-select__list-link <?=$sort_order?> <?=$key?> darken" rel="nofollow">
						<?endif;?>
							<span><?=GetMessage("SEARCH_BY_RANK")?></span>
						<?if($arResult["REQUEST"]["HOW"]!="d"):?>
							</span>
						<?else:?>
							</a>
						<?endif;?>
					</div>
					<div class="dropdown-select__list-item font_xs">
						<?if($arResult["REQUEST"]["HOW"]=="d"):?>
							<span class="dropdown-select__list-link dropdown-select__list-link--current">
						<?else:?>
							<a href="<?=$arResult["URL"]?>&amp;how=d<?=$arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?=$arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>" class="dropdown-select__list-link <?=$sort_order?> <?=$key?> darken" rel="nofollow">
						<?endif;?>
							<span><?=GetMessage("SEARCH_BY_DATE")?></span>
						<?if($arResult["REQUEST"]["HOW"]=="d"):?>
							</span>
						<?else:?>
							</a>
						<?endif;?>
					</div>
				</div>
			</div>
		</div>

		<?if($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
		<div class="items">
			<?foreach($arResult["SEARCH"] as $arItem):?>
				<div class="bordered rounded3 item colored_theme_hover_bg-block">
					<?if($arItem["CHAIN_PATH"]):?>
						<ul class="path"><?=$arItem["CHAIN_PATH"]?></ul>
					<?endif;?>
					<a href="<?=$arItem["URL"]?>" class="dark_link font_mlg title"><?=$arItem["TITLE_FORMATED"]?></a>
					<div class="text"><?=$arItem["BODY_FORMATED"]?></div>
					<a href="<?=$arItem['URL']?>" class="arrow_link colored_theme_hover_bg-el bordered-block rounded3 muted" title="<?=GetMessage('TO_ALL')?>"><?=CMax::showIconSvg("right-arrow", SITE_TEMPLATE_PATH.'/images/svg/arrow_right_list.svg', '', '');?></a>
					<?if (
						$arParams["SHOW_RATING"] == "Y"
						&& strlen($arItem["RATING_TYPE_ID"]) > 0
						&& $arItem["RATING_ENTITY_ID"] > 0
					):?>
						<div class="search-item-rate"><?
							$APPLICATION->IncludeComponent(
								"bitrix:rating.vote", $arParams["RATING_TYPE"],
								Array(
									"ENTITY_TYPE_ID" => $arItem["RATING_TYPE_ID"],
									"ENTITY_ID" => $arItem["RATING_ENTITY_ID"],
									"OWNER_ID" => $arItem["USER_ID"],
									"USER_VOTE" => $arItem["RATING_USER_VOTE_VALUE"],
									"USER_HAS_VOTED" => $arItem["RATING_USER_VOTE_VALUE"] == 0? 'N': 'Y',
									"TOTAL_VOTES" => $arItem["RATING_TOTAL_VOTES"],
									"TOTAL_POSITIVE_VOTES" => $arItem["RATING_TOTAL_POSITIVE_VOTES"],
									"TOTAL_NEGATIVE_VOTES" => $arItem["RATING_TOTAL_NEGATIVE_VOTES"],
									"TOTAL_VALUE" => $arItem["RATING_TOTAL_VALUE"],
									"PATH_TO_USER_PROFILE" => $arParams["~PATH_TO_USER_PROFILE"],
								),
								$component,
								array("HIDE_ICONS" => "Y")
							);?>
						</div>
					<?endif;?>
				</div>
			<?endforeach;?>
		</div>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
		<br />
    */?>
		
	<?/*else:?>
		<div class="alert alert-danger"><?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?></div>
	<?endif;*/?>
</div>