<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
$bIndex = (strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false) || isset($_GET['google']);

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
//$bIncludedModule = (\Bitrix\Main\Loader::includeModule("aspro.max"));
$bIncludedModule = true;
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID == 'ua' ? 'uk' : 'ru'?>" lang="<?=LANGUAGE_ID == 'ua' ? 'uk' : 'ru'?>" <?=($htmlClass ? 'class="'.$htmlClass.'"' : '')?> <?=($bIncludedModule ? CMax::getCurrentHtmlClass() : '')?>>
<head>
    <?
    if(!$bIndex)
    {
        ?>
        <!-- Google tag (gtag.js) -->
        <!-- Google Tag Manager -->
        <script async rel="preconnect" href="https://www.googletagmanager.com">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-T9VMJJK');</script>
        <!-- End Google Tag Manager -->
        <?
    }
    ?>

    <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">

    <meta name="it-rating" content="it-rat-b31c927f11de7015e699d2428dbfcee5" />

	<title><?$APPLICATION->ShowTitle()?></title>
<?global $arTheme?>
    <?$page = str_replace('/ru/', '/', $APPLICATION -> GetCurPage())?>
    <link rel="alternate" hreflang="x-default" href="<?='https://www.stimma.com.ua'.$page?>" />
    <link rel="alternate" hreflang="uk" href="<?='https://www.stimma.com.ua'.$page?>" />
    <link rel="alternate" hreflang="ru" href="<?='https://www.stimma.com.ua/ru'.$page?>" />
    <link rel="shortcut icon" href="/upload/CMax/95f/ewzwz7j9wwwn3jf0i974xt1thzfog3p6.svg" />
    <?
    if($bIndex)
    {
        ?>
        <?/*<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/vendor/css/bootstrap.css">*/?>
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/styles.css">
        <?
        /*if(!isset($_GET['google2']))
        {
            ?><link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/styles.css"><?
        }
        elseif(isset($_GET['google2']))
        {
            ?><link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/styles_g.css?v=<?=strtotime(date('d.m.Y H:i:s'))?>"><?
        }*/
        ?>

        <?
    }
    else
    {
        ?>
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/vendor/css/bootstrap.css">
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/styles.css">
        <?
    }
    ?>

    <?//$APPLICATION->ShowMeta("viewport");?>
<!--1111-->
	<?$APPLICATION->ShowMeta("HandheldFriendly");?>
<!--1112-->
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-capable", "yes");?>
<!--1113-->
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-status-bar-style");?>
<!--1114-->
	<?$APPLICATION->ShowMeta("SKYPE_TOOLBAR");?>
<!--1115-->
	<?$APPLICATION->ShowHead();?>
<!--1116-->
	<?$APPLICATION->AddHeadString('<script>BX.message('.CUtil::PhpToJSObject( $MESS, false ).')</script>', true);?>
<!--1117-->
	<?if($bIncludedModule)
		CMax::Start(SITE_ID);?>
	<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/head.php'));?>
<!--118-->

    <?
    if(!$bIndex)
    {
        ?>
        <script src="<?=SITE_TEMPLATE_PATH?>/js/ecommerce.js?v=<?=strtotime(date('d.m.Y H:i:s'))?>" ></script>
        <script charset="UTF-8" src="//web.webpushs.com/js/push/3ddbed13c815db1605dc55c5c502b332_1.js"></script>

        <!-- Facebook Pixel Code -->
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '727255070184437');
            fbq('track', 'PageView');
        </script>

        <?
    }
    ?>


    <meta name="google-site-verification" content="5n-Mf7YlvjDD3byGM9nB5ho7p0Bss2eIFic5ljdLnmk" />
</head>
<?$bIndexBot = CMax::checkIndexBot();?>

<body class="<?=($bIndexBot || $bIndex ? "wbot" : "");?> site_<?=SITE_ID?> <?=($bIncludedModule ? CMax::getCurrentBodyClass() : '')?>" id="main" data-site="<?=SITE_DIR?>">
    <?

if($bIndex)
{
    ?>
    <style>
        #footer{
            display: none;
        }
        .main-big-banner img {
            width: 100%;
        }
        .middle>.container {
            width: 100% !important;
            padding: 0 !important;
            position: relative;
        }
        /* Оба попапа всегда загружаются, но скрываются с помощью JS и CSS */
        /* Скрыть десктопный попап на мобилках */
        @media (max-width: 767px) {
            .popup-outfit-modal-desktop {
                display: none !important;
            }
        }
        /* Скрыть мобильный попап на десктопе */
        @media (min-width: 768px) {
            .popup-outfit-modal-mobile {
                display: none !important;
            }
        }
    </style>
    <?
}

$type = getTypeDevice();
if($type == 'Desktop')
{
    $width = 475;
    $height = 480;
}
else
{
    $width = 200;
    $height = 200;
}
if(!$bIndex)
{
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T9VMJJK"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <script async type="text/javascript"  rel="preconnect" href="https://script.ringostat.com">
        (function (d,s,u,e,p) {
            p=d.getElementsByTagName(s)[0],e=d.createElement(s),e.async=1,e.src=u,p.parentNode.insertBefore(e, p);
        })(document, 'script', 'https://script.ringostat.com/v4/8e/8ee52d09ea737262f15f0b2e5c785256d2d6f0c4.js');
        var pw = function() {if (typeof(ringostatAnalytics) === "undefined") {setTimeout(pw,100);} else {ringostatAnalytics.sendHit('pageview');}};
        pw();
    </script>

    <?
}

$isCard = preg_match('/.*-[0-9]+\/$/', $APPLICATION->GetCurPage());
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
	<div class="wrapper1 <?=$APPLICATION->GetCurPage() == '/' || $APPLICATION->GetCurPage() == '/ru/' ? 'main-page' : ''?> <?=($APPLICATION->GetCurPage() != '/' && $APPLICATION->GetCurPage() != '/ru/' && $APPLICATION->GetCurPage() != '/ru/order/'&& $APPLICATION->GetCurPage() != '/order/' && !$isCard) || isset($_GET['ORDER_ID']) ? 'header-margin' : ''?> <?=($isIndex && $isShowIndexLeftBlock ? "with_left_block" : "");?> <?=CMax::getCurrentPageClass();?> <?$APPLICATION->AddBufferContent(array('CMax', 'getCurrentThemeClasses'))?>  ">

        <?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/top_wrapper1.php'));?>


		<div class="wraps hover_<?=$arTheme["HOVER_TYPE_IMG"]["VALUE"];?> <?=strpos($APPLICATION->GetCurPage(),'/look20/') !== false ? 'bonus-page' : ''?>" id="content">
			<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/top_wraps.php'));?>

			<?if($isIndex):?>
				<?$APPLICATION->ShowViewContent('front_top_big_banner');?>
				<div class="wrapper_inner p-0 front <?=($isShowIndexLeftBlock ? "" : "wide_page");?> <?=$APPLICATION->ShowViewContent('wrapper_inner_class')?>">
			<?elseif(!$isWidePage):?>
				<div class="wrapper_inner p-0 <?=($isHideLeftBlock ? "wide_page" : "");?> <?=$APPLICATION->ShowViewContent('wrapper_inner_class')?>">
			<?endif;?>
				<div class="container_inner clearfix <?=$APPLICATION->ShowViewContent('container_inner_class')?>">

				<?if(($isIndex && ($isShowIndexLeftBlock || $bActiveTheme)) || (!$isIndex && !$isHideLeftBlock)):?>
					<div class="right_block <?=(defined("ERROR_404") ? "error_page" : "");?> wide_<?=CMax::ShowPageProps("HIDE_LEFT_BLOCK");?> <?=$APPLICATION->ShowViewContent('right_block_class')?>">
				<?endif;?>
					<div class="<?=!$isCard?'middle':''?> <?=($is404 ? 'error-page' : '');?> <?=$APPLICATION->ShowViewContent('middle_class')?>">
						<?CMax::get_banners_position('CONTENT_TOP');?>
						<?if(!$isIndex):?>
							<div class="<?=!$isCard?'container':''?>">
								<?//h1?>
								<?if($isHideLeftBlock && !$isWidePage):?>
									<div class="<?=$APPLICATION -> GetCurPage() == '/sertificate/' || $APPLICATION -> GetCurPage() == '/ru/sertificate/' ? 'maxwidth-theme-custom' : (!$isCard ? ''/*'maxwidth-theme'*/ : '')?> mt13">
								<?endif;?>
						<?endif;?>
						<?CMax::checkRestartBuffer();?>
