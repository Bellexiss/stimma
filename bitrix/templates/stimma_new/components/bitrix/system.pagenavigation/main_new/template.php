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

    <div class="pagination-cont">
        <div class="pagination-block">
            <?if(!$bPrevDisabled):?>
                <?$page = ( $bHasPage ? ($arResult["NavPageNomer"]-1 == 1 ? '' : $arResult["NavPageNomer"]-1) : '' );
                $url = ($page ? '?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.$page : $strNavQueryStringFull);?>
                    <a href="<?=$arResult["sUrlPath"]?><?=$url?>" class="pagination-arrow pagination-item <?/*disabled*/?>">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M-3.76701e-05 6.53121C-3.76701e-05 6.68306 0.058001 6.83506 0.173931 6.95099L6.11143 12.8885C6.34344 13.1205 6.71913 13.1205 6.95099 12.8885C7.18285 12.6565 7.183 12.2808 6.95099 12.0489L1.43327 6.53121L6.95099 1.01349C7.183 0.781487 7.183 0.40579 6.95099 0.173931C6.71899 -0.0579281 6.34329 -0.0580769 6.11143 0.173931L0.173931 6.11143C0.058001 6.22736 -3.76701e-05 6.37936 -3.76701e-05 6.53121Z" fill="currentcolor"/>
                        </svg>
                    </a>
                <link rel="prev" href="<?=$arResult["sUrlPath"].$url?>" />
                <link rel="canonical" href="<?=$arResult["sUrlPath"]?>" />
            <?endif;?>
            <div class="padination-pages">

                <?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>
                    <?if($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                        <a href="#" onclick="return false;" class="pagination-item active">
                            <?=$arResult["nStartPage"]?>
                        </a>
                    <?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
                        <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="pagination-item dl5"><?=$arResult["nStartPage"]?></a>
                    <?else:?>
                        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" class="pagination-item dl6"><?=$arResult["nStartPage"]?></a>
                    <?endif;?>
                    <?$arResult["nStartPage"]++;?>
                <?endwhile;?>

                <?if ($arResult["nEndPage"]>3):?>
                    <span class="pagination-item pagination-sep">...</span>
                    <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nEndPage"]?>" class="pagination-item">
                        <?=$arResult["nEndPage"]?>
                    </a>
                <?endif?>
            </div>
            <?if(!$bNextDisabled):?>
                <?$APPLICATION->AddHeadString('<link rel="next" href="'.$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1).'"  />', true);?>
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" class="pagination-arrow pagination-item">
                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.12504 6.53121C7.12504 6.68306 7.067 6.83506 6.95107 6.95099L1.01357 12.8885C0.78156 13.1205 0.405865 13.1205 0.174006 12.8885C-0.0578535 12.6565 -0.058002 12.2808 0.174006 12.0489L5.69173 6.53121L0.174006 1.01349C-0.058002 0.781487 -0.058002 0.40579 0.174006 0.173931C0.406014 -0.0579281 0.781709 -0.0580769 1.01357 0.173931L6.95107 6.11143C7.067 6.22736 7.12504 6.37936 7.12504 6.53121Z" fill="currentcolor"/>
                    </svg>
                </a>
            <?endif;?>
        </div>
    </div>
<?endif;?>

