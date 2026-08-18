<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?

global $DB;
$fuserID = CSaleBasket::GetBasketUserID();
$res = $DB -> Query('select * from b_sale_basket where FUSER_ID = '.$fuserID.' and ORDER_ID is null and (LID = \'s1\' or LID = \'s2\')');
while ($record = $res -> Fetch())
    $DB -> Query('update b_sale_basket set LID = \''.SITE_ID.'\' where ID = '.$record['ID']);


checkGlobalRedirect();

//if(isset($_GET['p']))
{
    CModule::IncludeModule('sale');
    if(!$USER -> IsAuthorized())
        $fuserID = Bitrix\Sale\Fuser::getId();
    else
        $fuserID = 'u-'.$USER -> GetID();
    $res = $DB -> Query('select * from favorite where UF_FUSER_ID = \'' . $fuserID.'\'');
    while ($record = $res -> Fetch())
        $_SESSION['FAVORITE'][$record['UF_PRODUCT_ID']] = $record['UF_PRODUCT_ID'];
}

?>
<?if($_GET["debug"] == "y")
	error_reporting(E_ERROR | E_PARSE);
IncludeTemplateLangFile(__FILE__);
global $APPLICATION, $arRegion, $arSite, $arTheme, $bIndexBot, $bIframeMode;
$arSite = CSite::GetByID(SITE_ID)->Fetch();
$htmlClass = ($_REQUEST && isset($_REQUEST['print']) ? 'print' : false);
$bIncludedModule = (\Bitrix\Main\Loader::includeModule("aspro.max"));?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID == 'ua' ? 'uk' : 'ru'?>" lang="<?=LANGUAGE_ID == 'ua' ? 'uk' : 'ru'?>" <?=($htmlClass ? 'class="'.$htmlClass.'"' : '')?> <?=($bIncludedModule ? CMax::getCurrentHtmlClass() : '')?>>
<head>
    <!-- Google tag (gtag.js) -->
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-T9VMJJK');</script>
    <!-- End Google Tag Manager -->




	<title><?$APPLICATION->ShowTitle()?></title>

    <?$page = str_replace('/ru/', '/', $APPLICATION -> GetCurPage())?>
    <link rel="alternate" hreflang="x-default" href="<?='https://www.stimma.com.ua'.$page?>" />
    <link rel="alternate" hreflang="uk" href="<?='https://www.stimma.com.ua'.$page?>" />
    <link rel="alternate" hreflang="ru" href="<?='https://www.stimma.com.ua/ru'.$page?>" />
    <link rel="shortcut icon" href="/favicon.jpg" />

    <?$APPLICATION->ShowMeta("viewport");?>
	<?$APPLICATION->ShowMeta("HandheldFriendly");?>
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-capable", "yes");?>
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-status-bar-style");?>
	<?$APPLICATION->ShowMeta("SKYPE_TOOLBAR");?>
	<?$APPLICATION->ShowHead();?>
	<?$APPLICATION->AddHeadString('<script>BX.message('.CUtil::PhpToJSObject( $MESS, false ).')</script>', true);?>
	<?if($bIncludedModule)
		CMax::Start(SITE_ID);?>
	<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/head.php'));?>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/ecommerce.js?v=<?=strtotime(date('d.m.Y H:i:s'))?>"></script>

    <script charset="UTF-8" src="//web.webpushs.com/js/push/3ddbed13c815db1605dc55c5c502b332_1.js" async></script>

    <meta name="google-site-verification" content="5n-Mf7YlvjDD3byGM9nB5ho7p0Bss2eIFic5ljdLnmk" />
</head>
<?$bIndexBot = CMax::checkIndexBot();?>
<body class="<?=($bIndexBot ? "wbot" : "");?> site_<?=SITE_ID?> <?=($bIncludedModule ? CMax::getCurrentBodyClass() : '')?>" id="main" data-site="<?=SITE_DIR?>">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T9VMJJK"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<?
{
    ?>
    <?/*<div class="b-marquee b-marquee--rtl" style="background-color: black;">
        <div class="b-marquee__text" style="font-weight: 400;color:white;background-color: black;">ГРАФІК РОБОТИ ІНТЕРНЕТ-МАГАЗИНУ: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; понеділок - п'ятниця: 9:00 - 18:00, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; субота: 10:00 - 18:00, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; неділя:  вихідний &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| відправка протягом 1 - 3 робочих днів |</div>
    </div>*/?>
    <div class="marquee">
	    <div class="marquee-text-wrap" style="background-color: black;">
	    	<div class="marquee-text-content" style="font-weight: 400;color:white;background-color: black;">
	    		<div class="marquee-text-text" style="font-weight: 400;color:white;background-color: black;animation-duration: 15s;">
		    		<span>ГРАФІК РОБОТИ ІНТЕРНЕТ-МАГАЗИНУ:</span> 
		    		<span> понеділок - п'ятниця: 9:00 - 18:00,</span> 
		    		<span> субота-неділя: 10:00 - 18:00,</span>
		    		<span>| відправка протягом 1 - 3 робочих днів |</span>
		    	</div>
		    	<div class="marquee-text-text" style="font-weight: 400;color:white;background-color: black;animation-duration: 15s;">
		    		<span>ГРАФІК РОБОТИ ІНТЕРНЕТ-МАГАЗИНУ:</span> 
		    		<span> понеділок - п'ятниця: 9:00 - 18:00,</span> 
		    		<span> субота-неділя: 10:00 - 18:00,</span>
		    		<span>| відправка протягом 1 - 3 робочих днів |</span>
		    	</div>
		    	<div class="marquee-text-text" style="font-weight: 400;color:white;background-color: black;animation-duration: 15s;">
		    		<span>ГРАФІК РОБОТИ ІНТЕРНЕТ-МАГАЗИНУ:</span> 
		    		<span> понеділок - п'ятниця: 9:00 - 18:00,</span> 
		    		<span> субота-неділя: 10:00 - 18:00,</span>
		    		<span>| відправка протягом 1 - 3 робочих днів |</span>
		    	</div>
		    	<div class="marquee-text-text" style="font-weight: 400;color:white;background-color: black;animation-duration: 15s;">
		    		<span>ГРАФІК РОБОТИ ІНТЕРНЕТ-МАГАЗИНУ:</span> 
		    		<span> понеділок - п'ятниця: 9:00 - 18:00,</span> 
		    		<span> субота-неділя: 10:00 - 18:00,</span>
		    		<span>| відправка протягом 1 - 3 робочих днів |</span>
		    	</div>
		    	<div class="marquee-text-text" style="font-weight: 400;color:white;background-color: black;animation-duration: 15s;">
		    		<span>ГРАФІК РОБОТИ ІНТЕРНЕТ-МАГАЗИНУ:</span> 
		    		<span> понеділок - п'ятниця: 9:00 - 18:00,</span> 
		    		<span> субота-неділя: 10:00 - 18:00,</span>
		    		<span>| відправка протягом 1 - 3 робочих днів |</span>
		    	</div>
		    	<div class="marquee-text-text" style="font-weight: 400;color:white;background-color: black;animation-duration: 15s;">
		    		<span>ГРАФІК РОБОТИ ІНТЕРНЕТ-МАГАЗИНУ:</span> 
		    		<span> понеділок - п'ятниця: 9:00 - 18:00,</span> 
		    		<span> субота-неділя: 10:00 - 18:00,</span>
		    		<span>| відправка протягом 1 - 3 робочих днів |</span>
		    	</div>
	    	</div>
	    </div>
    </div>
    <?
}
?>


	<?if(!$bIncludedModule):?>
		<?$APPLICATION->SetTitle(GetMessage("ERROR_INCLUDE_MODULE_ASPRO_MAX_TITLE"));?>
		<center><?$APPLICATION->IncludeFile(SITE_DIR."include/error_include_module.php");?></center></body></html><?die();?>
	<?endif;?>
	
	<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/body_top.php'));?>

	<?$arTheme = $APPLICATION->IncludeComponent("aspro:theme.max", ".default", array("COMPONENT_TEMPLATE" => ".default"), false, array("HIDE_ICONS" => "Y"));?>
	<?include_once('defines.php');?>
	<?CMax::SetJSOptions();?>

	<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/under_wrapper1.php'));?>
	<div class="wrapper1 <?=($isIndex && $isShowIndexLeftBlock ? "with_left_block" : "");?> <?=CMax::getCurrentPageClass();?> <?$APPLICATION->AddBufferContent(array('CMax', 'getCurrentThemeClasses'))?>  ">

        <?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/top_wrapper1.php'));?>


		<div class="wraps hover_<?=$arTheme["HOVER_TYPE_IMG"]["VALUE"];?>" id="content">
			<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/top_wraps.php'));?>

			<?if($isIndex):?>
				<?$APPLICATION->ShowViewContent('front_top_big_banner');?>
				<div class="wrapper_inner front <?=($isShowIndexLeftBlock ? "" : "wide_page");?> <?=$APPLICATION->ShowViewContent('wrapper_inner_class')?>">
			<?elseif(!$isWidePage):?>
				<div class="wrapper_inner <?=($isHideLeftBlock ? "wide_page" : "");?> <?=$APPLICATION->ShowViewContent('wrapper_inner_class')?>">
			<?endif;?>
				<div class="container_inner clearfix <?=$APPLICATION->ShowViewContent('container_inner_class')?>">

				<?if(($isIndex && ($isShowIndexLeftBlock || $bActiveTheme)) || (!$isIndex && !$isHideLeftBlock)):?>
					<div class="right_block <?=(defined("ERROR_404") ? "error_page" : "");?> wide_<?=CMax::ShowPageProps("HIDE_LEFT_BLOCK");?> <?=$APPLICATION->ShowViewContent('right_block_class')?>">
				<?endif;?>
					<div class="middle <?=($is404 ? 'error-page' : '');?> <?=$APPLICATION->ShowViewContent('middle_class')?>">
						<?CMax::get_banners_position('CONTENT_TOP');?>
						<?if(!$isIndex):?>
							<div class="container">
								<?//h1?>
								<?if($isHideLeftBlock && !$isWidePage):?>
									<div class="<?=$APPLICATION -> GetCurPage() == '/sertificate/' || $APPLICATION -> GetCurPage() == '/ru/sertificate/' ? 'maxwidth-theme-custom' : (!isset($_GET['me']) ? 'maxwidth-theme' : '')?> mt13">
								<?endif;?>
						<?endif;?>
						<?CMax::checkRestartBuffer();?>