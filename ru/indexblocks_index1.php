<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
if(isset($_GET['new']) || true)
{

}
else
{
    ?>
    <?global $arMainPageOrder; //global array for order blocks?>
    <?global $arTheme, $dopBodyClass;?>
    <?$lookBooks = false;?>
    <?if($arMainPageOrder && is_array($arMainPageOrder)):?>
    <?foreach($arMainPageOrder as $key => $optionCode):?>
        <?$strTemplateName = $arTheme['TEMPLATE_PARAMS'][$arTheme['INDEX_TYPE']['VALUE']][$arTheme['INDEX_TYPE']['VALUE'].'_'.$optionCode.'_TEMPLATE']['VALUE'];?>
        <?$subtype = strtolower($optionCode);?>

        <?$dopBodyClass .= ' '.$optionCode.'_'.$strTemplateName;?>

        <?//BIG_BANNER_INDEX?>
        <?if($optionCode == "BIG_BANNER_INDEX"):?>
            <?global $bShowBigBanners, $bBigBannersIndexClass;?>
            <?if($bShowBigBanners):?>
                <?$bIndexLongBigBanner = ($strTemplateName != "type_1" && $strTemplateName != "type_4")?>
                <?if(!$bIndexLongBigBanner):?>
                    <?$dopBodyClass .= ' right_mainpage_banner';?>
                <?endif;?>

                <?if($bIndexLongBigBanner):?>
                    <?ob_start();?>
                    <div class="middle">
                <?endif;?>

                <div class="drag-block grey container <?=$optionCode?> <?=$bBigBannersIndexClass?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
                </div>

                <?if($bIndexLongBigBanner):?>
                    </div>
                    <?$html = ob_get_contents();
                    ob_end_clean();?>
                    <?$APPLICATION->AddViewContent('front_top_big_banner',$html);?>
                <?endif;?>
            <?endif;?>
        <?endif;?>
        <style>
            .items.normal.c_3{display: none !important;}
        </style>
        <?//STORIES?>
        <?if($optionCode == "STORIES"):?>
            <?global $bShowStories, $bStoriesIndexClass;?>
            <?if($bShowStories):?>
                <div class="drag-block db1 container <?=$optionCode?> <?=$bStoriesIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
                </div>
            <?endif;?>
        <?endif;?>

        <?//TIZERS_INDEX?>
        <?/*if($optionCode == "TIZERS"):?>
			<?global $bShowTizers, $bTizersIndexClass;?>
			<?if($bShowTizers):?>
				<div class="drag-block db2 container <?=$optionCode?> <?=$bTizersIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;*/?>

        <?//CATALOG_SECTIONS?>
        <?/*if($optionCode == "CATALOG_SECTIONS"):?>
			<?global $bShowCatalogSections, $bCatalogSectionsIndexClass;?>
			<?if($bShowCatalogSections):?>
				<div class="drag-block db3 container <?=$optionCode?> <?=$bCatalogSectionsIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;*/?>

        <?//CATALOG_TAB?>
        <?/*if($optionCode == "CATALOG_TAB"):?>
			<?global $bShowCatalogTab, $bCatalogTabIndexClass;?>
			<?if($bShowCatalogTab):?>
				<div class="drag-block db4 container grey <?=$optionCode?> <?=$bCatalogTabIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;*/?>

        <?//MIDDLE_ADV?>
        <?/*if($optionCode == "MIDDLE_ADV"):?>
			<?global $bShowMiddleAdvBottomBanner, $bMiddleAdvIndexClass;?>
			<?if($bShowMiddleAdvBottomBanner):?>
				<div class="drag-block db5 container <?=$optionCode?> <?=$bMiddleAdvIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;*/?>

        <?//FLOAT_BANNERS?>
        <?if($optionCode == "FLOAT_BANNERS"):?>
            <?global $bShowFloatBanners, $bFloatBannersIndexClass;?>
            <?if($bShowFloatBanners):?>
                <div class="drag-block db6 container <?=$optionCode?> <?=$bFloatBannersIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
                </div>
            <?endif;?>
        <?endif;?>

        <?//SALE?>
        <?if($optionCode == "SALE"):?>
            <?global $bShowSale, $bSaleIndexClass;?>
            <?if($bShowSale):?>
                <div class="drag-block db7 container grey <?=$optionCode?> <?=$bSaleIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
                </div>
            <?endif;?>
        <?endif;?>

        <?//COLLECTIONS?>
        <?/*if($optionCode == "COLLECTIONS"):?>
			<?global $bShowCollection, $bCollectionIndexClass;?>
			<?if($bShowCollection):?>
				<div class="drag-block db8 container grey <?=$optionCode?> <?=$bCollectionIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;*/?>

        <?
        if($lookBooks)
        {
            ?>

            <?
            $lookBooks = false;
        }
        ?>

        <?//LOOKBOOKS?>
        <?if($optionCode == "LOOKBOOKS"):?>
            <?$lookBooks = true;?>
            <?global $bShowLookbook, $bLookbookIndexClass;?>
            <?if($bShowLookbook):?>
                <div class="drag-block db9 container grey <?=$optionCode?> <?=$bLookbookIndexClass;?>" data-class="<?=$subtype?>_drag" <?/*data-order="<?=++$key;?>*/?>">
                <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
                </div>
                <!-- -> -->
                <?
                $res = CIBlockElement::GetByID(7958) -> GetNextElement();
                $fields = $res -> GetFields();
                $props = $res -> GetProperties();
                $img = CFile::ResizeImageGet($props['FILE_RU']['VALUE'], array('width'=>1903, 'height'=>375), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                ?>
                <div class="main-big-banner">
                    <?=$props['LINK_RU']['VALUE'] ? '<a href="'.$props['LINK_RU']['VALUE'].'">' : ''?>
                    <img src="<?=$img?>">
                    <?=$props['LINK_RU']['VALUE'] ? '</a>' : ''?>
                </div>
                <?$img = CFile::ResizeImageGet($props['FILE_RU_MOB']['VALUE'], array('width'=>576, 'height'=>375), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];?>
                <div class="main-big-banner mobile">
                    <?=$props['LINK_RU']['VALUE'] ? '<a href="'.$props['LINK_RU']['VALUE'].'">' : ''?>
                    <img src="<?=$img?>">
                    <?=$props['LINK_RU']['VALUE'] ? '</a>' : ''?>
                </div>

                <div class="main-inst-block">
                    <div class="main-inst-block-title">
                        <span>instagram</span>
                        <a href="https://www.instagram.com/stimma_official/" target="_blank">@stimma_official</a>
                    </div>
                    <div class="main-inst-list">

                        <?
                        $res = CIBlockElement::GetList(['ID' => 'desc'], ['IBLOCK_ID' => 36, 'ACTIVE' => 'Y'],false,['nTopCount' => 4]);
                        while ($record = $res -> Fetch())
                        {
                            $userPhoto = CFile::ResizeImageGet($record['PREVIEW_PICTURE'], array('width'=>400, 'height'=>400), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                            ?>
                            <div class="main-inst-list-item">
                                <a href="<?=$record['PREVIEW_TEXT']?>" target="_blank"><img src="<?=$userPhoto?>"></a>
                            </div>
                            <?
                        }
                        ?>
                    </div>
                    <div class="write-us-cont">
                        <div class="write-us-block">
                            <div class="write-us-title">Узнавайте первой про все новинки и акции</div>
                        </div>
                        <div class="write-us-form">
                            <form>
                                <div class="write-us-form-block">
                                    <input type="text" placeholder="Ваш E-mail" name="subscribe_email">
                                    <button type="submit">Подписаться</button>
                                </div>
                                <div class="subscribe_result"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- -> -->
            <?endif;?>
        <?endif;?>

        <?//NEWS?>
        <?if($optionCode == "NEWS"):?>
            <?global $bShowNews, $bNewsIndexClass;?>
            <?if($bShowNews):?>
                <div class="drag-block db11 container grey <?=$optionCode?> <?=$bNewsIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
                </div>
            <?endif;?>
        <?endif;?>

        <?//BLOG?>
        <?if($optionCode == "BLOG"):?>
            <?global $bShowBlog, $bBlogIndexClass;?>
            <?if($bShowBlog):?>
                <div class="drag-block db12 container <?=$optionCode?> <?=$bBlogIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
                </div>
            <?endif;?>
        <?endif;?>

        <?//BOTTOM_BANNERS?>
        <?/*if($optionCode == "BOTTOM_BANNERS"):?>
			<?global $bShowBottomBanner, $bBottomBannersIndexClass;?>
			<?if($bShowBottomBanner):?>
				<div class="drag-block db13 container <?=$optionCode?> <?=$bBottomBannersIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;*/?>

        <?//COMPANY_TEXT?>
        <?/*if($optionCode == "COMPANY_TEXT"):?>
			<?global $bShowCompany, $bCompanyTextIndexClass;?>
			<?if($bShowCompany):?>
				<div class="drag-block db14 container <?=$optionCode?> <?=$bCompanyTextIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;*/?>

        <?//MAPS?>
        <?/*if($optionCode == "MAPS"):?>
            <?global $bShowMaps, $bMapsIndexClass;?>
			<?if($bShowMaps):?>
				<div class="drag-block db15 container <?=$optionCode?> <?=$bMapsIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;*/?>

        <?//FAVORIT_ITEM?>
        <?if($optionCode == "FAVORIT_ITEM"):?>
            <?global $bShowFavoritItem, $bFavoritItemIndexClass;?>
            <?if($bShowFavoritItem):?>
                <div class="drag-block db16 container <?=$optionCode?> <?=$bFavoritItemIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
                </div>
            <?endif;?>
        <?endif;?>

        <?//BRANDS?>
        <?if($optionCode == "BRANDS"):?>
            <?global $bShowBrands, $bBrandsIndexClass;?>
            <?if($bShowBrands):?>
                <div class="drag-block db17 container <?=$optionCode?> <?=$bBrandsIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
                </div>
            <?endif;?>
        <?endif;?>

        <?//INSTAGRAMM?>
        <?if($optionCode == "INSTAGRAMM"):?>
            <?global $bShowInstagramm, $bInstagrammIndexClass;?>
            <?if($bShowInstagramm):?>
                <div class="drag-block db18 container <?=$optionCode?> <?=$bInstagrammIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
                </div>
            <?endif;?>
        <?endif;?>

        <?//REVIEWS?>
        <?if($optionCode == "REVIEWS"):?>
            <?global $bShowReview, $bReviewIndexClass;?>
            <?if($bShowReview):?>
                <div class="drag-block db10 container grey <?=$optionCode?> <?=$bReviewIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
                </div>
            <?endif;?>
        <?endif;?>

    <?endforeach;?>
<?endif;?>
    <script>
        $(document).ready(function()
        {

            function sayHi() {
                if($('.top_slider_wrapp').length)
                {
                    var eventdata = { slider: $('.top_slider_wrapp') };
                    BX.onCustomEvent("onSlide", [eventdata]);
                }
                else
                    setTimeout(sayHi, 100);
            }
            setTimeout(sayHi, 100);
            //startMainBannerSlideVideo($('.btn.btn-default.btn-video.has-ripple')).closest(".box")


        })
    </script>
    <?
}
?>
<?
CMax::AddMeta(
    array(
        'og:description' => 'Интернет магазин одежды от производителя Стимма. &ndash; STIMMA',
        'og:title' => 'Интернет магазин одежды от производителя Стимма. &ndash; STIMMA',
        'og:image' => '/bitrix/templates/aspro_max/images/logost.png',
    )
);
?>