<?$this->setFrameMode(true);?>
<?if($arResult["NavPageCount"] > 1):?>
	<?
	if($arResult["NavQueryString"])
	{
		$arUrl = explode('&amp;', $arResult["NavQueryString"]);
		if($arUrl)
		{
			foreach($arUrl as $key => $url)
			{
				if(strpos($url, 'ajax_get') !== false || strpos($url, 'AJAX_REQUEST') !== false)
					unset($arUrl[$key]);
			}
		}
		$arResult["NavQueryString"] = implode('&amp;', $arUrl);
	}
	$count_item_between_cur_page = 2; // count numbers left and right from cur page
	$count_item_dotted = 2; // count numbers to end or start pages
	
	$arResult["nStartPage"] = $arResult["NavPageNomer"] - $count_item_between_cur_page;
	$arResult["nStartPage"] = $arResult["nStartPage"] <= 0 ? 1 : $arResult["nStartPage"];
	$arResult["nEndPage"] = $arResult["NavPageNomer"] + $count_item_between_cur_page;
	$arResult["nEndPage"] = $arResult["nEndPage"] > $arResult["NavPageCount"] ? $arResult["NavPageCount"] : $arResult["nEndPage"];
	$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
	$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
	if($arResult["NavPageNomer"] == 1){
		$bPrevDisabled = true;
	}
	elseif($arResult["NavPageNomer"] < $arResult["NavPageCount"]){
		$bPrevDisabled = false;
	}
	if($arResult["NavPageNomer"] == $arResult["NavPageCount"]){
		$bNextDisabled = true;
	}
	else{
		$bNextDisabled = false;
	}
	?>
	<?if(!$bNextDisabled && false){?>
            <div id="ajax_load_btn"></div>
            <div id="insert_ajax_load_btn"></div>
		<div class="ajax_load_btn rounded3 colored_theme_hover_bg main" <?/*style="display:none;"*/?>>
			<span class="more_text_ajax font_upper_md"><?=GetMessage('PAGER_SHOW_MORE')?></span>
		</div>
	<?}?>
	<?global $APPLICATION;?>
	<?
	$bHasPage = (isset($_GET['PAGEN_'.$arResult["NavNum"]]) && $_GET['PAGEN_'.$arResult["NavNum"]]);
	if($bHasPage)
	{
		if($_GET['PAGEN_'.$arResult["NavNum"]] == 1 && !isset($_GET['q']))
		{
			LocalRedirect($arResult["sUrlPath"], false, "301 Moved permanently");
		}
		elseif($_GET['PAGEN_'.$arResult["NavNum"]] > $arResult["nEndPage"])
		{
			if (!defined("ERROR_404"))
			{
				define("ERROR_404", "Y");
				\CHTTP::setStatus("404 Not Found");
			}
		}

	}?>
	<div class="module-pagination" style="margin:30px 30px;<?/*=strpos($APPLICATION->GetCurPage(),'/news/') === false ? 'display:none;' : ''*/?>">
		<div class="nums" style="<?=strpos($APPLICATION->GetCurPage(),'/news/') === false ? '' : 'margin-bottom:10px;'?>">
			<ul class="flex-direction-nav fdn6">
				<?if(!$bPrevDisabled):?>
					<?$page = ( $bHasPage ? ($arResult["NavPageNomer"]-1 == 1 ? '' : $arResult["NavPageNomer"]-1) : '' );
					$url = ($page ? '?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.$page : $strNavQueryStringFull);?>
					<li class="flex-nav-prev colored_theme_hover_text">
						<a href="<?=$arResult["sUrlPath"]?><?=$url?>" class="flex-prev" style="margin-top: 7px;">
							<?=CMax::showIconSvg("down", SITE_TEMPLATE_PATH.'/images/svg/catalog/arrow_pagination.svg', '', '', true, false);?>
						</a>
					</li>
					<link rel="prev" href="<?=$arResult["sUrlPath"].$url?>" />
					<link rel="canonical" href="<?=$arResult["sUrlPath"]?>" />
				<?endif;?>
				<?if(!$bNextDisabled):?>
					<?$APPLICATION->AddHeadString('<link rel="next" href="'.$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1).'"  />', true);?>
					<li class="flex-nav-next colored_theme_hover_text">
						<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" class="flex-next" style="<?=strpos($APPLICATION->GetCurPage(),'/news/') === false ? 'margin-top:7px;' : 'margin-top:7px;'?>">
							<?=CMax::showIconSvg("down", SITE_TEMPLATE_PATH.'/images/svg/catalog/arrow_pagination.svg', '', '', true, false);?>
						</a>
					</li>
				<?endif;?>
			</ul>
			<?if($arResult["nStartPage"] > 1):?>
				<?/*<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1" class="dark_link dl55">1</a>*/?>
            <?$pre = empty($strNavQueryString) ? '' : "?"?>
				<a href="<?=$arResult["sUrlPath"]?><?=$pre.$strNavQueryString?>" class="dark_link dl55">1</a>
				<?if(($arResult["nStartPage"] - $count_item_dotted) > 1):?>
					<span class='point_sep'>...</span>
				<?elseif(($firstPage = $arResult["nStartPage"]-1) > 1 && $arResult["nStartPage"] !=2):?>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$firstPage?>"><?=$firstPage?></a>
				<?endif;?>
			<?endif;?>
			<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>
				<?if($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
					<span class="cur"><?=$arResult["nStartPage"]?></span>
				<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="dark_link dl5"><?=$arResult["nStartPage"]?></a>
				<?else:?>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" class="dark_link dl6"><?=$arResult["nStartPage"]?></a>
				<?endif;?>
				<?$arResult["nStartPage"]++;?>
			<?endwhile;?>
			<?if($arResult["nEndPage"] < $arResult["NavPageCount"]):?>
				<?if(($arResult["nEndPage"] + $count_item_dotted) < $arResult["NavPageCount"]):?>
					<span class='point_sep'>...</span>
				<?elseif(($lastPage = $arResult["nEndPage"]+1) < $arResult["NavPageCount"]):?>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$lastPage?>"><?=$lastPage?></a>
				<?endif;?>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>" class="dark_link dl66"><?=$arResult["NavPageCount"]?></a>
			<?endif;?>
			<?if ($arResult["bShowAll"]):?>			
				<div class="all_block_nav">
					<!--noindex-->
						<?if ($arResult["NavShowAll"]):?>
							<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0" class="link" rel="nofollow"><?=GetMessage("nav_paged")?></a>
						<?else:?>
							<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1" class="link" rel="nofollow"><?=GetMessage("nav_all")?></a>
						<?endif?>
					<!--/noindex-->
				</div>			
			<?endif?>
		</div>
	</div>
<?endif;?>

