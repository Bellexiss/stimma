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




$currtime = strtotime(date('d.m.Y H:i:s'));
$startAction = strtotime('21.08.2026 00:00:01');
$endAction = strtotime('23.08.2026 23:59:59');

$rizn = isset($_SESSION['DATE_CLAUDE']) ? $currtime-$_SESSION['DATE_CLAUDE'] : 3000;

global $isJulyAction;
$isJulyAction = $currtime >= $startAction && $currtime <= $endAction && $rizn > 1800 ? 1 : 0;
$fuserID = Bitrix\Sale\Fuser::getId();
$isBanka = $DB->Query('select * from b_sale_basket where PRODUCT_ID = 47170 and FUSER_ID = ' . $fuserID . ' limit 1')->Fetch();

//if ($isJulyAction) $_SESSION['DATE_CLAUDE'] = $currtime;
//$isJulyAction=false;
IncludeTemplateLangFile(__FILE__);
global $APPLICATION, $arRegion, $arSite, $arTheme, $bIndexBot, $bIframeMode;
$arSite = CSite::GetByID(SITE_ID)->Fetch();
$htmlClass = ($_REQUEST && isset($_REQUEST['print']) ? 'print' : false);
//$bIncludedModule = (\Bitrix\Main\Loader::includeModule("aspro.max"));
$bIncludedModule = true;

$basketCount = getBasketCount();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID == 'ua' ? 'uk' : 'ru'?>" lang="<?=LANGUAGE_ID == 'ua' ? 'uk' : 'ru'?>" <?=($htmlClass ? 'class="'.$htmlClass.'"' : '')?> >
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
    <link rel="alternate" hreflang="x-default" href="<?='https://stimma.ua'.$page?>" />
    <link rel="alternate" hreflang="uk" href="<?='https://stimma.ua'.$page?>" />
    <link rel="alternate" hreflang="ru" href="<?='https://stimma.ua/ru'.$page?>" />
    <link rel="shortcut icon" href="/upload/CMax/95f/ewzwz7j9wwwn3jf0i974xt1thzfog3p6.svg" />

    <!-- <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/styles.css"> -->

    <meta name="google-site-verification" content="T5kBM8Wp5zJaMgfHMsKRgpfb_TUXeiqDMxdwIh5uYsU" />

    <?//$APPLICATION->ShowMeta("viewport");?>
	<?$APPLICATION->ShowMeta("HandheldFriendly");?>
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-capable", "yes");?>
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-status-bar-style");?>
	<?$APPLICATION->ShowMeta("SKYPE_TOOLBAR");?>
	<?$APPLICATION->ShowHead();?>
	<?//$APPLICATION->AddHeadString('<script>BX.message('.CUtil::PhpToJSObject( $MESS, false ).')</script>', true);?>
	<?if($bIncludedModule)
		//CMax::Start(SITE_ID);?>
	<?//include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/head.php'));?>

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

    <!-- New Styles #1 -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/bootstrap.min.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/slick.css">
    <?
    if(strpos($APPLICATION->GetCurPage(), '/order/') === false)
    {
        ?> <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/select2.min.css"><?
    }
    ?>

    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/global.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/header.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/footer.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">

    <!-- Політика, Угода , Гарантія та повернення, Доставка, Про Нас, Статі , Статі детально, Співпраця(переваги), Співпраця ( Опт), Співпраця (роздріб), догляд  -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/text-page.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">
    
    <!-- Хлібні крихти  -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/breadcrambs.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">
    
    <!-- Пагінація  -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/pagination.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">
    
    <!-- Авторизація і Регістрація -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/auth.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">

    <!-- Головна  -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/main.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">
    
    <!-- Елемент каталогу  -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/catalog-element.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">
    
    <!-- Карточка товару, сертифікат -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/card.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">

    <!-- Сама собі стіма -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/sama-sobi.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">

    <!-- Каталог -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/catalog.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">

    <!-- Кошик -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/order.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">

    <!-- Пошук  -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/search.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">

    <!-- Особистий кабінет -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/stylesnew/personal.css?v=<?=strtotime(date('d.m.Y H:i:s'));?>">

    <?use Bitrix\Main\Page\Asset;?>

    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jquery.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jsnew/bootstrap.min.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jsnew/slick.min.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jsnew/swiper.js');?>
    <?if(strpos($APPLICATION->GetCurPage(), '/order/') === false)Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jsnew/select2.min.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jsnew/jquery.zoom.min.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jsnew/hover-pinch-zoom.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jsnew/easyzoom.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jsnew/script.js?v='.strtotime(date('d.m.Y H:i:s')));?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/custom.js?v='.strtotime(date('d.m.Y H:i:s')));?>

    <?
    if($isJulyAction)
    {
        $randPhoto = rand(1,20);
        ?>
        <script>window.july_action = <?=$isJulyAction?>;</script>
        <script>window.numberClaude = <?=$randPhoto?>;</script>
        <script>window.isBanka = <?=isset($isBanka['ID']) ? 1 : 0?>;</script>
        <script>window.user_id = <?=$USER->GetID()?>;</script>
        <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jsnew/july_action.js?v='.strtotime(date('d.m.Y H:i:s')));?>
        <?
    }
    ?>

    <!-- New Js #1 -->
    <?/*<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.js"></script>*/?>
    <!-- <script src="<?=SITE_TEMPLATE_PATH?>/js/jsnew/bootstrap.bundle.min.js" ></script> -->
    <?/*
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jsnew/bootstrap.min.js" ></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jsnew/slick.min.js" ></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jsnew/swiper.js" ></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jsnew/select2.min.js" ></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jsnew/script.js?v=<?=strtotime(date('d.m.Y H:i:s'));?>" ></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/custom.js?v=<?=strtotime(date('d.m.Y H:i:s'));?>" ></script> <?// todo перебрати скрипти?>
    */?>
    <?//$APPLICATION->ShowHead();?>

    <meta name="google-site-verification" content="5n-Mf7YlvjDD3byGM9nB5ho7p0Bss2eIFic5ljdLnmk" />

    <?


    if($APPLICATION->GetCurPage() == '/' || $APPLICATION->GetCurPage() == '/ru/')
    {
        ?>
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="STIMMA">
        <meta property="og:title" content="<?=$APPLICATION->GetTitle()?>">
        <meta property="og:description" content="<?=$APPLICATION->GetProperty('description')?>">
        <meta property="og:image" content="https://stimma.ua/logo.png">
        <meta property="og:image:alt" content="STIMMA">
        <meta property="og:url" content="<?=$APPLICATION->GetCurPage()?>">
        <meta property="og:locale" content="<?=LANGUAGE_ID == 'ua' ? 'uk-UA' : 'ru-RU'?>">
        <?
    }


    if(!$bIndex)
    /*{
        ?>
        <script>
            (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q || []).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", "vym1p7d6mx");
        </script>
        <?
    }*/
    ?>

</head>
<?
$textRunning = \Bitrix\Main\Config\Option::get('main', "running_line_text", "");
$textRunning=trim($textRunning);
$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$textRunning=str_replace('<>',$space,$textRunning);

?>
<?//$bIndexBot = CMax::checkIndexBot();?>

<body class="<?=($bIndexBot || $bIndex ? "wbot" : "");?> <?=!empty($textRunning) ? 'run-line-body' : ''?>" id="main" data-site="<?=SITE_DIR?>">
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
    <?


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
$ru=LANGUAGE_ID=='ru'?'/ru':'';
?>
<?
//$textRunning = \Bitrix\Main\Config\Option::get('main', "running_line_text", "");
//$textRunning=trim($textRunning);
//$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
//$textRunning=str_replace('<>',$space,$textRunning);
if(!empty($textRunning))
{
    ?>
    <style>
        .running-line-cont{
            height: 24px;
        }
        .running-line
        {
            width: 100%;
            overflow: hidden;
            background: var(--peach);
            height: 24px;
            display: flex;
            align-items: center;
            position: fixed;
            left: 0;
            right: 0;
            z-index: 4;

        }

        .running-line-track
        {
            display: flex;
            width: max-content;
            animation: runningLine 120s linear infinite;
        }
        @media (max-width: 768px)
        {
            .running-line-track
            {
                animation-duration: 120s;
            }
        }
        .running-line-track span
        {
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            margin-right: 120px;
            line-height: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media(min-width: 1000px){
            .running-line{
                height: 42px;
            }

            .running-line-cont{
                height: 42px;
            }

            .running-line-track span{
                font-size: 14px;
                line-height: 42px;
            }
        }

        @keyframes runningLine
        {
            from
            {
                transform: translateX(0);
            }

            to
            {
                transform: translateX(-50%);
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function ()
        {
            const track = document.getElementById('runningLine');

            let position = 0;
            let speed = 1;

            function animate()
            {
                position -= speed;

                const firstBlock = track.children[0];

                if(Math.abs(position) >= firstBlock.offsetWidth + 120)
                {
                    position += firstBlock.offsetWidth + 120;

                    track.appendChild(firstBlock);
                }

                track.style.transform = 'translateX(' + position + 'px)';

                requestAnimationFrame(animate);
            }

            animate();
        });
    </script>
    <div class="running-line-cont">
        <div class="running-line">
            <div class="running-line-track" id="runningLine">
                <?
                for($i = 0; $i < 16; $i++)
                {
                    ?><span><?=$textRunning?></span><?
                }
                ?>
            </div>
        </div>
    </div>
    <?
}
?>
<header class="<?=$USER->IsAuthorized() ? 'header-cont-authorized': ''?> <?=($APPLICATION->GetCurPage()!='/' && $APPLICATION->GetCurPage()!='/ru') ? 'white-header' :' main-header-pos'?>">
    <div class="header-cont ">
        <div class="wrapper">
            <div class="header-block">
                <div class="header-group-block">
                    <div class="header-menu" data-bs-toggle="offcanvas" data-bs-target="#header-menu">
                        <span class="icon">
                            <svg width="29" height="23" viewBox="0 0 29 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="29" height="3" fill="currentcolor"/>
                                <rect y="10" width="23" height="3" fill="currentcolor"/>
                                <rect y="20" width="27" height="3" fill="currentcolor"/>
                            </svg>
                        </span>
                        Menu
                    </div>
                    <?/*<a href="<?=$ru?>/contacts/" class="header-link">
                        <?=LANGUAGE_ID=='ua' ? 'Магазини' : 'Магазины'?>
                    </a>*/?>
                    <a href="<?=$ru?>/search/" class="header-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M23.6665 22.0497L17.6943 16.0775C17.4947 15.8804 17.4695 15.5697 17.6312 15.3423C18.763 13.7533 19.4299 11.8105 19.4299 9.71368C19.4299 4.35284 15.077 0 9.71368 0C4.35284 0 0 4.35284 0 9.71368C0 15.077 4.35284 19.4299 9.71368 19.4299C11.8105 19.4299 13.7533 18.763 15.3423 17.6312C15.5697 17.4695 15.8804 17.4947 16.0775 17.6943L22.0497 23.6665C22.4943 24.1112 23.2194 24.1112 23.6665 23.6665C24.1112 23.2194 24.1112 22.4943 23.6665 22.0497ZM9.71368 17.4114C5.46698 17.4114 2.016 13.963 2.016 9.71368C2.016 5.46695 5.46698 2.016 9.71368 2.016C13.963 2.016 17.4114 5.46695 17.4114 9.71368C17.4114 13.963 13.963 17.4114 9.71368 17.4114Z" fill="currentcolor"/>
                        </svg>
                    </a>
                    <a href="<?=$ru?>/catalog/zhenskaya_odezhda/" class="header-link">
                        <?=LANGUAGE_ID=='ua' ? 'Каталог' : 'Каталог'?>
                    </a>
                    <a href="<?=$ru?>/catalog/rasprodazha/" class="header-link">
                        <?=LANGUAGE_ID=='ua' ? 'Sale' : 'Sale'?>
                    </a>
                    <a href="<?=$ru?>/catalog/khity_prodazh/" class="header-link">
                        <?=LANGUAGE_ID=='ua' ? 'Bestsellers' : 'Bestsellers'?>
                    </a>
                </div>
                <div class="header-logo-block">
                    <a href="<?=$ru?>/" class="logo-link">
                        <svg width="263" height="50" viewBox="0 0 263 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M37.6301 29.8733C37.6301 31.1872 37.3848 32.3464 36.9033 33.3218C36.4263 34.2836 35.7828 35.1065 34.984 35.7724C34.2123 36.4159 33.3123 36.9384 32.3065 37.3218C31.3592 37.6828 30.3512 37.9653 29.3139 38.1626C28.2924 38.3554 27.2461 38.4832 26.2066 38.5415C25.1918 38.602 24.213 38.6312 23.295 38.6312C20.883 38.6312 18.6127 38.4294 16.5494 38.0325C14.4951 37.6357 12.6478 37.1357 11.0615 36.5415L10.292 36.2523V27.7792L12.0538 28.7545C13.5343 29.5706 15.2511 30.2231 17.1591 30.6872C19.0807 31.1558 21.1687 31.3935 23.3648 31.3935C24.6541 31.3935 25.7071 31.3263 26.4946 31.1962C27.4261 31.0393 27.9391 30.8599 28.2046 30.7366C28.5984 30.555 28.6952 30.4294 28.6974 30.4294C28.7334 30.3733 28.7514 30.3352 28.7582 30.315C28.7491 30.3106 28.7244 30.2836 28.6794 30.2478C28.5151 30.1132 28.1979 29.9115 27.6151 29.7052C27.0684 29.5101 26.4091 29.3262 25.6621 29.1581C24.8768 28.9832 24.0398 28.8061 23.1578 28.6312C22.2577 28.4518 21.333 28.2567 20.3812 28.0505C19.4024 27.8352 18.4417 27.5796 17.5214 27.2904C16.5854 26.9967 15.6831 26.6469 14.8438 26.2523C13.9573 25.8352 13.163 25.3307 12.4858 24.7545C11.7725 24.1446 11.201 23.4271 10.7847 22.6222C10.355 21.7859 10.1367 20.8195 10.1367 19.75C10.1367 18.5303 10.364 17.4473 10.8095 16.5325C11.2482 15.6289 11.8513 14.8487 12.6005 14.2119C13.3228 13.5976 14.1643 13.0953 15.1026 12.7164C15.9869 12.3576 16.9319 12.0751 17.9106 11.8778C18.8669 11.685 19.8479 11.5505 20.8245 11.4787C21.7852 11.407 22.71 11.3711 23.5718 11.3711C24.5236 11.3711 25.5181 11.4204 26.5261 11.5146C27.5229 11.6088 28.5241 11.7433 29.4962 11.9159C30.4569 12.0841 31.4042 12.2836 32.3155 12.5079C33.2155 12.7321 34.0638 12.9697 34.8378 13.2186L35.6591 13.4832V21.7097L33.9535 20.8823C33.544 20.6828 32.9792 20.4473 32.2772 20.185C31.582 19.9249 30.7764 19.6738 29.8854 19.4384C28.9967 19.2029 28.0156 19.0034 26.9694 18.8442C25.9366 18.6872 24.8633 18.6088 23.7788 18.6088C22.899 18.6088 22.1407 18.6357 21.5265 18.6895C20.9235 18.7433 20.4172 18.8128 20.0212 18.8935C19.5824 18.9832 19.3484 19.0706 19.2292 19.1245C19.1909 19.1424 19.1594 19.1581 19.1302 19.1738C19.3147 19.2949 19.6229 19.4541 20.1157 19.62C20.6737 19.8061 21.3352 19.9877 22.0867 20.1558C22.8788 20.333 23.718 20.5146 24.6046 20.7029C25.5068 20.8935 26.4361 21.102 27.3946 21.3285C28.3779 21.5594 29.3432 21.833 30.2634 22.1424C31.2062 22.4563 32.1107 22.8285 32.9477 23.2455C33.8298 23.685 34.6195 24.2097 35.2946 24.8038C36.0056 25.4316 36.5748 26.1648 36.9866 26.9854C37.4141 27.8375 37.6301 28.8083 37.6301 29.8733Z" fill="currentcolor"/>
                            <path d="M76.7689 11.9727V19.4839H66.6797V37.9928H57.8955V19.4839H47.8242V11.9727H76.7689Z" fill="currentcolor"/>
                            <path d="M97.4421 11.9727H88.6602V37.9928H97.4421V11.9727Z" fill="currentcolor"/>
                            <path d="M151.223 11.9727V37.9928H142.475V24.9637L135.565 37.9928H127.985L121.075 24.9637V37.9928H112.293V11.9727H122.9L131.776 28.5489L140.653 11.9727H151.223Z" fill="currentcolor"/>
                            <path d="M205.014 11.9727V37.9928H196.268V24.9637L189.358 37.9928H181.778L174.868 24.9637V37.9928H166.086V11.9727H176.69L185.567 28.5489L194.443 11.9727H205.014Z" fill="currentcolor"/>
                            <path d="M238.226 11.9727H229.637L215.973 37.9928H225.821L228.049 33.5153H239.812L242.042 37.9928H251.888L238.226 11.9727ZM236.376 26.5377H231.527L233.962 21.6677L236.376 26.5377Z" fill="currentcolor"/>
                        </svg>
                    </a>
                </div>
                <div class="header-group-block">
                    <?
                    if($USER->IsAuthorized())
                    {
                        $xml_id=$DB->Query('select * from b_user where ID='.$USER->GetID())->Fetch()['XML_ID'];
                        $balance=GetBalance($xml_id);
                        /*if($USER->IsAdmin())
                        {
                            $APPLICATION->RestartBuffer();
                            ?><pre><?=print_r($balance, 1)?></pre><?
                            die();
                        }*/
                        //$balance=[];
                        ?>
                        <div class="header-bonus-block">
                            <a href="<?=$ru?>/personal/bonus/" class="header-bonus-link">
                                <?=$balance['response']['Balance']?>
                                <span class="icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="12" fill="#FE9D56"/>
                                    <path d="M18.4182 13.6833C18.4182 14.2617 18.3115 14.772 18.1021 15.2013C17.8947 15.6248 17.6148 15.987 17.2674 16.2801C16.9317 16.5634 16.5403 16.7934 16.1029 16.9622C15.6909 17.1211 15.2525 17.2454 14.8014 17.3323C14.3571 17.4172 13.9021 17.4734 13.45 17.4991C13.0086 17.5257 12.5829 17.5386 12.1837 17.5386C11.1346 17.5386 10.1472 17.4497 9.24989 17.275C8.35645 17.1003 7.55303 16.8802 6.86313 16.6187L6.52846 16.4914V12.7615L7.29469 13.1908C7.93859 13.5501 8.68525 13.8373 9.51508 14.0416C10.3508 14.2479 11.2589 14.3525 12.214 14.3525C12.7747 14.3525 13.2327 14.3229 13.5752 14.2657C13.9803 14.1966 14.2035 14.1176 14.3189 14.0633C14.4902 13.9834 14.5323 13.9281 14.5332 13.9281C14.5489 13.9034 14.5567 13.8867 14.5597 13.8778C14.5557 13.8758 14.545 13.864 14.5254 13.8482C14.454 13.7889 14.316 13.7001 14.0625 13.6093C13.8247 13.5234 13.538 13.4425 13.2131 13.3685C12.8716 13.2915 12.5076 13.2135 12.124 13.1365C11.7325 13.0576 11.3303 12.9717 10.9164 12.8809C10.4907 12.7861 10.0729 12.6736 9.67264 12.5463C9.26555 12.417 8.87314 12.263 8.50813 12.0893C8.12257 11.9057 7.77713 11.6837 7.48257 11.43C7.17236 11.1615 6.92381 10.8457 6.74277 10.4914C6.55586 10.1232 6.46094 9.69781 6.46094 9.22701C6.46094 8.69008 6.55977 8.21336 6.75353 7.81066C6.94436 7.4129 7.20662 7.06942 7.53248 6.78911C7.84661 6.51867 8.21259 6.29758 8.62066 6.13078C9.00524 5.97286 9.41625 5.84849 9.84193 5.76164C10.2578 5.67676 10.6845 5.61753 11.1092 5.58595C11.527 5.55437 11.9292 5.53857 12.304 5.53857C12.718 5.53857 13.1505 5.56029 13.5889 5.60174C14.0224 5.6432 14.4579 5.70242 14.8806 5.77842C15.2985 5.85244 15.7105 5.94029 16.1068 6.03899C16.4982 6.13769 16.8672 6.24231 17.2038 6.35187L17.561 6.46833V10.0897L16.8192 9.72545C16.6411 9.6376 16.3955 9.53397 16.0902 9.41849C15.7878 9.304 15.4374 9.19345 15.0499 9.08982C14.6634 8.98618 14.2367 8.89834 13.7817 8.82826C13.3325 8.75917 12.8657 8.72462 12.3941 8.72462C12.0114 8.72462 11.6817 8.73647 11.4145 8.76016C11.1522 8.78384 10.9321 8.81444 10.7598 8.84997C10.569 8.88945 10.4672 8.92795 10.4154 8.95164C10.3987 8.95953 10.385 8.96644 10.3723 8.97335C10.4526 9.02665 10.5866 9.09673 10.8009 9.16976C11.0436 9.25169 11.3313 9.33163 11.6582 9.40566C12.0026 9.48363 12.3676 9.56358 12.7532 9.64649C13.1456 9.73038 13.5498 9.82217 13.9666 9.92186C14.3943 10.0235 14.8141 10.1439 15.2143 10.2801C15.6244 10.4183 16.0177 10.5822 16.3818 10.7657C16.7654 10.9592 17.1089 11.1902 17.4024 11.4517C17.7117 11.7281 17.9592 12.0508 18.1383 12.4121C18.3243 12.7871 18.4182 13.2145 18.4182 13.6833Z" fill="white"/>
                                </svg>
                            </span>
                            </a>
                            <div class="header-bonus-dropdown-cont">
                                <div class="header-bonus-dropdown">
                                    Кількість накопичених стмімзів
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    ?>

                    <div class="language-block">
                        <?
                        $pageUrl = isset($_SERVER['NEW_URL']) ? $_SERVER['NEW_URL'][3] : $APPLICATION->GetCurPage();
                        $page = str_replace('/ru/','/',$pageUrl);

                        if(LANGUAGE_ID == 'ua')
                        {
                            ?>
                            <div class="language-current">
                                UA
                                <span class="icon">
                                <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.00002 7C5.86053 7 5.72089 6.94298 5.61439 6.82908L0.159852 0.995781C-0.053284 0.767845 -0.053284 0.398743 0.159852 0.170952C0.372988 -0.0568383 0.718124 -0.0569841 0.931123 0.170952L6.00002 5.59184L11.0689 0.170952C11.2821 -0.0569841 11.6272 -0.0569841 11.8402 0.170952C12.0532 0.398889 12.0533 0.767991 11.8402 0.995781L6.38566 6.82908C6.27916 6.94298 6.13952 7 6.00002 7Z" fill="currentcolor"/>
                                </svg>
                            </span>
                            </div>
                            <div class="language-dropdown">
                                <a href="/ru<?=$page?>">
                                    RU
                                </a>
                            </div>
                            <?
                        }
                        else
                        {
                            ?>

                            <div class="language-current">
                                RU
                                <span class="icon">
                                <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.00002 7C5.86053 7 5.72089 6.94298 5.61439 6.82908L0.159852 0.995781C-0.053284 0.767845 -0.053284 0.398743 0.159852 0.170952C0.372988 -0.0568383 0.718124 -0.0569841 0.931123 0.170952L6.00002 5.59184L11.0689 0.170952C11.2821 -0.0569841 11.6272 -0.0569841 11.8402 0.170952C12.0532 0.398889 12.0533 0.767991 11.8402 0.995781L6.38566 6.82908C6.27916 6.94298 6.13952 7 6.00002 7Z" fill="currentcolor"/>
                                </svg>
                            </span>
                            </div>
                            <div class="language-dropdown">
                                <a href="<?=$page?>">
                                    UA
                                </a>
                            </div>

                            <?
                        }
                        ?>

                    </div>
                    <div class="header-icons-group">
                        <a href="<?=$ru?>/favorite/" class="header-icon-link">
                            <svg width="29" height="24" viewBox="0 0 29 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.1211 1C22.8573 1.00008 24.5177 1.67362 25.7998 2.9082C27.2066 4.26283 28.013 6.18547 28 8.18164C27.9901 9.6702 27.4064 11.3444 26.1465 13.1729L25.8857 13.541C24.7731 15.0644 23.2108 16.6732 21.2246 18.3184C18.0759 20.9262 14.9727 22.7134 14.499 22.9814C14.0197 22.7121 10.8967 20.9249 7.73828 18.3184C5.74455 16.673 4.18144 15.0637 3.07324 13.541C1.63737 11.5682 0.98956 9.7706 1 8.18457C1.01286 6.2594 1.73204 4.46171 3.01465 3.11328C4.31718 1.744 6.04209 1.0001 7.87891 1C10.2274 1 12.3954 2.25905 13.6504 4.28418C13.8327 4.5784 14.1539 4.7578 14.5 4.75781C14.8461 4.75781 15.1673 4.57841 15.3496 4.28418C16.6046 2.25908 18.7726 1 21.1211 1Z" stroke="currentcolor" stroke-width="2" stroke-linejoin="round"/>
                            </svg>
                        </a>
                        <a href="/search/" class="header-link header-link-mob">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M23.6665 22.0497L17.6943 16.0775C17.4947 15.8804 17.4695 15.5697 17.6312 15.3423C18.763 13.7533 19.4299 11.8105 19.4299 9.71368C19.4299 4.35284 15.077 0 9.71368 0C4.35284 0 0 4.35284 0 9.71368C0 15.077 4.35284 19.4299 9.71368 19.4299C11.8105 19.4299 13.7533 18.763 15.3423 17.6312C15.5697 17.4695 15.8804 17.4947 16.0775 17.6943L22.0497 23.6665C22.4943 24.1112 23.2194 24.1112 23.6665 23.6665C24.1112 23.2194 24.1112 22.4943 23.6665 22.0497ZM9.71368 17.4114C5.46698 17.4114 2.016 13.963 2.016 9.71368C2.016 5.46695 5.46698 2.016 9.71368 2.016C13.963 2.016 17.4114 5.46695 17.4114 9.71368C17.4114 13.963 13.963 17.4114 9.71368 17.4114Z" fill="currentcolor"></path>
                            </svg>
                        </a>
                        <?
                        $lAuthPage=$USER->IsAuthorized() ? '/personal/' : '/auth/';
                        ?>
                        <a href="<?=$lAuthPage?>" class="header-icon-link personal-menu-trigger">
                            <svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.0764 13.5156C3.9337 13.5156 0 16.9271 0 23.1217C0 23.6055 0.388388 23.9976 0.867593 23.9976H21.2851C21.7643 23.9976 22.1527 23.6055 22.1527 23.1217C22.1527 16.9274 18.219 13.5156 11.0764 13.5156ZM1.76676 22.2458C2.10802 17.6141 5.23569 15.2675 11.0764 15.2675C16.917 15.2675 20.0448 17.6141 20.3863 22.2458H1.76676Z" fill="currentcolor"/>
                                <path d="M11.0707 0C7.78975 0 5.31567 2.54809 5.31567 5.92688C5.31567 9.40461 7.89737 12.2336 11.0707 12.2336C14.2441 12.2336 16.8258 9.40461 16.8258 5.92716C16.8258 2.54809 14.3517 0 11.0707 0ZM11.0707 10.482C8.85402 10.482 7.05086 8.43873 7.05086 5.92716C7.05086 3.50783 8.74152 1.75185 11.0707 1.75185C13.3627 1.75185 15.0906 3.54665 15.0906 5.92716C15.0906 8.43873 13.2874 10.482 11.0707 10.482Z" fill="currentcolor"/>
                            </svg>
                        </a>
                        <a data-bs-toggle="offcanvas" href="#basket-header" role="button" class="header-icon-link get_popup_basket">
                            <svg width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.495666 7.49794C0.813037 7.17908 1.24348 7 1.69231 7H20.3077C20.7565 7 21.187 7.17908 21.5043 7.49794C21.8217 7.81674 22 8.24913 22 8.7V20.2414C22 22.342 20.2339 24 18.1923 24H3.8077C1.74115 24 0 22.251 0 20.175V8.7C0 8.24913 0.1783 7.81674 0.495666 7.49794ZM20.3077 8.7H1.69231V20.175C1.69231 21.312 2.67578 22.3 3.8077 22.3H18.1923C19.3492 22.3 20.3077 21.3538 20.3077 20.2414V8.7Z" fill="currentcolor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11 1.8C9.86338 1.8 8.77325 2.27411 7.96952 3.11802C7.16579 3.96191 6.71429 5.10654 6.71429 6.3V8.1C6.71429 8.59708 6.3305 9 5.85714 9C5.38373 9 5 8.59708 5 8.1V6.3C5 4.62915 5.63214 3.02671 6.75736 1.84523C7.88257 0.66375 9.40871 0 11 0C12.5913 0 14.1174 0.66375 15.2426 1.84523C16.3679 3.02671 17 4.62915 17 6.3V8.1C17 8.59708 16.6162 9 16.1429 9C15.6694 9 15.2857 8.59708 15.2857 8.1V6.3C15.2857 5.10654 14.8342 3.96191 14.0304 3.11802C13.2267 2.27411 12.1366 1.8 11 1.8Z" fill="currentcolor"/>
                            </svg>
                            <div class="header-icon-counter">
                                <?=$basketCount?>
                            </div>
                        </a>

                        <div class="header-basket-add-block">
                            <div class="header-basket-add-text">
                                <?=LANGUAGE_ID=='ua'?'Товар додано у кошик':'Товар добавлен в корзину'?>
                            </div>
                            <div class="header-basket-add-remove">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="c-biXJmc c-biXJmc-ulsnn-size-medium"><g><rect width="24" height="24" fill="none" ></rect><polygon fill="currentcolor" stroke="currentcolor" points="20.8 3.9 20.1 3.2 12 11.3 3.9 3.2 3.2 3.9 11.3 12 3.2 20.1 3.9 20.8 12 12.7 20.1 20.8 20.8 20.1 12.7 12 20.8 3.9"></polygon></g></svg>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>

            <?/*<div class="search-mob-cont">
                <input type="text" name="q" placeholder="<?=LANGUAGE_ID=='ua'?'Шукати спідницю':'Искать юбку'?>">
            </div>*/?>
        </div>
    </div>
</header>

<div class="personal-menu-cont">
    <div class="wrapper">
        <div class="personal-menu-block">
            <div class="personal-menu-bonus-block">
                <div class="personal-menu-bonus-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/ssshead.png">
                </div>
                <div class="personal-menu-bonus-info">
                    <div class="personal-menu-bonus-text">
                        <?=LANGUAGE_ID=='ua' ? 'Сама собі STIMMA - вигідно бути собою' : 'Сама себя STIMMA — выгодно быть собой'?>
                    </div>
                    <div class="personal-menu-bonus-btn">
                        <a href="<?=$ru?>/personal/" class="info-btn info-btn-black">
                            <?=LANGUAGE_ID=='ua' ? 'Круто, я з вами' : 'Круто, я с вами'?>
                        </a>
                    </div>
                </div>
            </div>
            <?
            if($USER->IsAuthorized())
            {
                ?>
                <div class="personal-menu-list">
                    <a href="<?=$ru?>/personal/" class="personal-menu-item">
                        <?=LANGUAGE_ID=='ua' ? 'Персональні дані' : 'Персональные данные'?>
                    </a>
                    <a href="<?=$ru?>/personal/orders/" class="personal-menu-item">
                        <?=LANGUAGE_ID=='ua' ? 'Мої замовлення' : 'Мои заказы'?>
                    </a>
                    <a href="<?=$ru?>/personal/bonus/" class="personal-menu-item">
                        <?=LANGUAGE_ID=='ua' ? 'Програма лояльності' : 'Программа лояльности'?>
                    </a>
                    <a href="<?=$ru?>/favorite/" class="personal-menu-item">
                        <?=LANGUAGE_ID=='ua' ? 'Вішліст' : 'Список желаний'?>
                    </a>
                    <a href="<?=$ru?>/?logout=yes&sessid=<?=$_SERVER['SESS_ID']?>" class="personal-menu-item">
                        <?=LANGUAGE_ID=='ua' ? 'Вийти з акаунту' : 'Выйти из аккаунта'?>
                    </a>
                </div>
                <?
            }
            else
            {
                ?>
                <div class="personal-menu-list">
                    <a href="<?=$ru?>/personal/" class="personal-menu-item">
                        <?=LANGUAGE_ID=='ua' ? 'Персональні дані' : 'Персональные данные'?>
                    </a>
                    <a href="<?=$ru?>/personal/orders/" class="personal-menu-item">
                        <?=LANGUAGE_ID=='ua' ? 'Мої замовлення' : 'Мои заказы'?>
                    </a>
                    <a href="<?=$ru?>/personal/bonus/" class="personal-menu-item">
                        <?=LANGUAGE_ID=='ua' ? 'Програма лояльності' : 'Программа лояльности'?>
                    </a>
                    <a href="<?=$ru?>/favorite/" class="personal-menu-item">
                        <?=LANGUAGE_ID=='ua' ? 'Вішліст' : 'Список желаний'?>
                    </a>
                </div>
                <?
            }
            ?>

        </div>
    </div>
</div>


<div class="offcanvas offcanvas-end basket-header-canvas" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="basket-header">
    <?//=getBasketNewHtml()?>
    <?/*
  <div class="offcanvas-header">
    <div class="basker-header-title">
        Кошик
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        <span class="icon">
            <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.4365 12.0225L25.4561 0.00292969L26.8701 1.41699L14.8506 13.4365L26.8701 25.4561L25.4561 26.8701L13.4365 14.8506L1.41406 26.873L0 25.459L12.0225 13.4365L0 1.41406L1.41406 0L13.4365 12.0225Z" fill="currentcolor"/>
            </svg>
        </span>
    </button>
  </div>
  <div class="offcanvas-body">
    <div class="basket-header-list-cont">
        <div class="basket-header-list">
            <div class="basket-header-item">
                <div class="basket-header-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/headbask1.png">
                </div>
                <div class="basket-header-info-block">
                    <div class="basket-header-info">
                        <div class="basket-header-prop">
                            <a href="#" class="basket-header-item-name">
                                Жіночий бомбер Stimma Ешалін хакі
                            </a>
                            <div class="basket-header-item-size">
                                Розмір: <span>S</span>
                            </div>
                            <div class="basket-header-item-color">
                                Колір: <span style="background: #635240;"></span>
                            </div>
                        </div>
                        <div class="basket-header-price-block">
                            <div class="basket-header-item-price">
                                7 198 ₴ 
                            </div>
                        </div>
                    </div>
                    <div class="basket-header-control">
                        <div class="basket-header-counter">
                            <button class="basket-header-counter-btn">
                                <svg width="13" height="1" viewBox="0 0 13 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="13" width="1" height="13" transform="rotate(90 13 0)" fill="currentcolor"/>
                                </svg>
                            </button>
                            <input type="text" name="" value="1">
                            <button class="basket-header-counter-btn">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="6" width="1" height="13" fill="white"/>
                                    <rect x="13" y="6" width="1" height="13" transform="rotate(90 13 6)" fill="white"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="basket-header-item-delete">
                            видалити
                        </a>
                    </div>
                </div>
            </div>
            <div class="basket-header-item basket-header-item-bonus">
                <div class="basket-header-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/headbask2.png">
                </div>
                <div class="basket-header-info-block">
                    <div class="basket-header-info">
                        <div class="basket-header-prop">
                            <a href="#" class="basket-header-item-name">
                                Жіноча сумка Stimma Глорія шоколадний
                            </a>
                            <div class="basket-header-item-color">
                                Колір: <span style="background: #635240;"></span>
                            </div>
                        </div>
                        <div class="basket-header-price-block">
                            <div class="basket-header-item-price-bonus">
                                500
                                <span class="icon">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="11" cy="11" r="11" fill="#FE9D56"/>
                                        <path d="M16.8827 12.5402C16.8827 13.0704 16.7849 13.5382 16.593 13.9318C16.4028 14.3199 16.1462 14.6519 15.8278 14.9207C15.5201 15.1803 15.1613 15.3911 14.7603 15.5458C14.3827 15.6915 13.9808 15.8055 13.5673 15.8851C13.16 15.9629 12.7429 16.0145 12.3285 16.038C11.9239 16.0625 11.5337 16.0742 11.1677 16.0742C10.2061 16.0742 9.30099 15.9928 8.47841 15.8326C7.65942 15.6725 6.92296 15.4707 6.29055 15.231L5.98377 15.1143V11.6952L6.68615 12.0888C7.27639 12.4181 7.96083 12.6814 8.72151 12.8687C9.48757 13.0578 10.32 13.1537 11.1955 13.1537C11.7095 13.1537 12.1293 13.1265 12.4433 13.0741C12.8147 13.0107 13.0192 12.9383 13.125 12.8886C13.282 12.8153 13.3206 12.7646 13.3215 12.7646C13.3358 12.742 13.343 12.7266 13.3457 12.7185C13.3421 12.7167 13.3322 12.7058 13.3143 12.6913C13.2488 12.6371 13.1223 12.5556 12.89 12.4724C12.672 12.3937 12.4092 12.3195 12.1114 12.2516C11.7983 12.1811 11.4646 12.1096 11.113 12.039C10.7542 11.9666 10.3855 11.8879 10.0061 11.8047C9.61585 11.7178 9.23282 11.6147 8.86593 11.498C8.49277 11.3795 8.13306 11.2383 7.79846 11.0791C7.44503 10.9108 7.12838 10.7072 6.85838 10.4747C6.57402 10.2286 6.34617 9.93908 6.18022 9.61427C6.00889 9.2768 5.92188 8.88685 5.92188 8.45529C5.92188 7.9631 6.01248 7.5261 6.19009 7.15696C6.36501 6.79235 6.60541 6.47749 6.90412 6.22054C7.19207 5.97264 7.52756 5.76997 7.90162 5.61707C8.25416 5.47231 8.63091 5.35831 9.02112 5.27869C9.40236 5.20088 9.79346 5.1466 10.1828 5.11765C10.5658 5.08869 10.9345 5.07422 11.278 5.07422C11.6575 5.07422 12.054 5.09412 12.4558 5.13212C12.8532 5.17012 13.2524 5.22441 13.6399 5.29407C14.023 5.36193 14.4006 5.44245 14.7639 5.53293C15.1227 5.6234 15.4609 5.71931 15.7695 5.81974L16.0969 5.9265V9.24604L15.4169 8.91219C15.2537 8.83166 15.0285 8.73666 14.7487 8.63081C14.4715 8.52586 14.1503 8.42452 13.7951 8.32952C13.4408 8.23453 13.0497 8.154 12.6326 8.08976C12.2208 8.02643 11.7929 7.99476 11.3606 7.99476C11.0098 7.99476 10.7075 8.00562 10.4626 8.02734C10.2222 8.04905 10.0204 8.0771 9.86253 8.10967C9.68761 8.14586 9.59432 8.18114 9.54678 8.20286C9.53153 8.2101 9.51897 8.21643 9.50731 8.22276C9.58086 8.27162 9.70376 8.33586 9.90021 8.40281C10.1227 8.4779 10.3864 8.55119 10.686 8.61905C11.0018 8.69052 11.3364 8.76381 11.6898 8.83981C12.0495 8.91671 12.42 9.00085 12.8021 9.09223C13.1941 9.18542 13.5789 9.2958 13.9458 9.42066C14.3217 9.54732 14.6823 9.69751 15.016 9.8658C15.3676 10.0431 15.6825 10.2548 15.9516 10.4946C16.235 10.7479 16.462 11.0438 16.6261 11.3749C16.7966 11.7187 16.8827 12.1105 16.8827 12.5402Z" fill="white"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="basket-header-control">
                        <div class="basket-header-counter">
                            <button class="basket-header-counter-btn">
                                <svg width="13" height="1" viewBox="0 0 13 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="13" width="1" height="13" transform="rotate(90 13 0)" fill="currentcolor"/>
                                </svg>
                            </button>
                            <input type="text" name="" value="1">
                            <button class="basket-header-counter-btn">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="6" width="1" height="13" fill="white"/>
                                    <rect x="13" y="6" width="1" height="13" transform="rotate(90 13 6)" fill="white"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="basket-header-item-delete">
                            видалити
                        </a>
                    </div>
                </div>
            </div>
            <div class="basket-header-item">
                <div class="basket-header-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/headbask1.png">
                </div>
                <div class="basket-header-info-block">
                    <div class="basket-header-info">
                        <div class="basket-header-prop">
                            <a href="#" class="basket-header-item-name">
                                Жіночий бомбер Stimma Ешалін хакі
                            </a>
                            <div class="basket-header-item-size">
                                Розмір: <span>S</span>
                            </div>
                            <div class="basket-header-item-color">
                                Колір: <span style="background: #635240;"></span>
                            </div>
                        </div>
                        <div class="basket-header-price-block">
                            <div class="basket-header-item-price">
                                7 198 ₴ 
                            </div>
                        </div>
                    </div>
                    <div class="basket-header-control">
                        <div class="basket-header-counter">
                            <button class="basket-header-counter-btn">
                                <svg width="13" height="1" viewBox="0 0 13 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="13" width="1" height="13" transform="rotate(90 13 0)" fill="currentcolor"/>
                                </svg>
                            </button>
                            <input type="text" name="" value="1">
                            <button class="basket-header-counter-btn">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="6" width="1" height="13" fill="white"/>
                                    <rect x="13" y="6" width="1" height="13" transform="rotate(90 13 6)" fill="white"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="basket-header-item-delete">
                            видалити
                        </a>
                    </div>
                </div>
            </div>
            <div class="basket-header-item basket-header-item-bonus">
                <div class="basket-header-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/headbask2.png">
                </div>
                <div class="basket-header-info-block">
                    <div class="basket-header-info">
                        <div class="basket-header-prop">
                            <a href="#" class="basket-header-item-name">
                                Жіноча сумка Stimma Глорія шоколадний
                            </a>
                            <div class="basket-header-item-color">
                                Колір: <span style="background: #635240;"></span>
                            </div>
                        </div>
                        <div class="basket-header-price-block">
                            <div class="basket-header-item-price-bonus">
                                500
                                <span class="icon">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="11" cy="11" r="11" fill="#FE9D56"/>
                                        <path d="M16.8827 12.5402C16.8827 13.0704 16.7849 13.5382 16.593 13.9318C16.4028 14.3199 16.1462 14.6519 15.8278 14.9207C15.5201 15.1803 15.1613 15.3911 14.7603 15.5458C14.3827 15.6915 13.9808 15.8055 13.5673 15.8851C13.16 15.9629 12.7429 16.0145 12.3285 16.038C11.9239 16.0625 11.5337 16.0742 11.1677 16.0742C10.2061 16.0742 9.30099 15.9928 8.47841 15.8326C7.65942 15.6725 6.92296 15.4707 6.29055 15.231L5.98377 15.1143V11.6952L6.68615 12.0888C7.27639 12.4181 7.96083 12.6814 8.72151 12.8687C9.48757 13.0578 10.32 13.1537 11.1955 13.1537C11.7095 13.1537 12.1293 13.1265 12.4433 13.0741C12.8147 13.0107 13.0192 12.9383 13.125 12.8886C13.282 12.8153 13.3206 12.7646 13.3215 12.7646C13.3358 12.742 13.343 12.7266 13.3457 12.7185C13.3421 12.7167 13.3322 12.7058 13.3143 12.6913C13.2488 12.6371 13.1223 12.5556 12.89 12.4724C12.672 12.3937 12.4092 12.3195 12.1114 12.2516C11.7983 12.1811 11.4646 12.1096 11.113 12.039C10.7542 11.9666 10.3855 11.8879 10.0061 11.8047C9.61585 11.7178 9.23282 11.6147 8.86593 11.498C8.49277 11.3795 8.13306 11.2383 7.79846 11.0791C7.44503 10.9108 7.12838 10.7072 6.85838 10.4747C6.57402 10.2286 6.34617 9.93908 6.18022 9.61427C6.00889 9.2768 5.92188 8.88685 5.92188 8.45529C5.92188 7.9631 6.01248 7.5261 6.19009 7.15696C6.36501 6.79235 6.60541 6.47749 6.90412 6.22054C7.19207 5.97264 7.52756 5.76997 7.90162 5.61707C8.25416 5.47231 8.63091 5.35831 9.02112 5.27869C9.40236 5.20088 9.79346 5.1466 10.1828 5.11765C10.5658 5.08869 10.9345 5.07422 11.278 5.07422C11.6575 5.07422 12.054 5.09412 12.4558 5.13212C12.8532 5.17012 13.2524 5.22441 13.6399 5.29407C14.023 5.36193 14.4006 5.44245 14.7639 5.53293C15.1227 5.6234 15.4609 5.71931 15.7695 5.81974L16.0969 5.9265V9.24604L15.4169 8.91219C15.2537 8.83166 15.0285 8.73666 14.7487 8.63081C14.4715 8.52586 14.1503 8.42452 13.7951 8.32952C13.4408 8.23453 13.0497 8.154 12.6326 8.08976C12.2208 8.02643 11.7929 7.99476 11.3606 7.99476C11.0098 7.99476 10.7075 8.00562 10.4626 8.02734C10.2222 8.04905 10.0204 8.0771 9.86253 8.10967C9.68761 8.14586 9.59432 8.18114 9.54678 8.20286C9.53153 8.2101 9.51897 8.21643 9.50731 8.22276C9.58086 8.27162 9.70376 8.33586 9.90021 8.40281C10.1227 8.4779 10.3864 8.55119 10.686 8.61905C11.0018 8.69052 11.3364 8.76381 11.6898 8.83981C12.0495 8.91671 12.42 9.00085 12.8021 9.09223C13.1941 9.18542 13.5789 9.2958 13.9458 9.42066C14.3217 9.54732 14.6823 9.69751 15.016 9.8658C15.3676 10.0431 15.6825 10.2548 15.9516 10.4946C16.235 10.7479 16.462 11.0438 16.6261 11.3749C16.7966 11.7187 16.8827 12.1105 16.8827 12.5402Z" fill="white"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="basket-header-control">
                        <div class="basket-header-counter">
                            <button class="basket-header-counter-btn">
                                <svg width="13" height="1" viewBox="0 0 13 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="13" width="1" height="13" transform="rotate(90 13 0)" fill="currentcolor"/>
                                </svg>
                            </button>
                            <input type="text" name="" value="1">
                            <button class="basket-header-counter-btn">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="6" width="1" height="13" fill="white"/>
                                    <rect x="13" y="6" width="1" height="13" transform="rotate(90 13 6)" fill="white"/>
                                </svg>
                            </button>
                        </div>
                        <a href="#" class="basket-header-item-delete">
                            видалити
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="offcanvas-footer">
        <div class="basket-header-total">
            <div class="basket-header-total-key">
                Разом 2 од.
            </div>
            <div class="basket-header-total-value">
                7 198 ₴ 
            </div>
        </div>
        <div class="basket-header-btn">
            <a href="#" class="info-btn info-btn-black">
                Оформити замовлення
            </a>
            <a href="#" class="info-btn ">
                Купити в 1 клік
            </a>
        </div>
  </div>
    */?>
</div>

<div class="offcanvas offcanvas-start header-menu-canvas" tabindex="-1" id="header-menu" >
  <div class="offcanvas-header-cont">
    <div class="wrapper">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <span class="icon">
                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.4365 12.0225L25.4561 0.00292969L26.8701 1.41699L14.8506 13.4365L26.8701 25.4561L25.4561 26.8701L13.4365 14.8506L1.41406 26.873L0 25.459L12.0225 13.4365L0 1.41406L1.41406 0L13.4365 12.0225Z" fill="currentcolor"/>
                    </svg>
                </span>
                Закрити
            </button>
            <div class="language-block">
                <?
                if(LANGUAGE_ID=='ua')
                {
                    ?>
                    <div class="language-current">
                        UA
                        <span class="icon">
                        <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.00002 7C5.86053 7 5.72089 6.94298 5.61439 6.82908L0.159852 0.995781C-0.053284 0.767845 -0.053284 0.398743 0.159852 0.170952C0.372988 -0.0568383 0.718124 -0.0569841 0.931123 0.170952L6.00002 5.59184L11.0689 0.170952C11.2821 -0.0569841 11.6272 -0.0569841 11.8402 0.170952C12.0532 0.398889 12.0533 0.767991 11.8402 0.995781L6.38566 6.82908C6.27916 6.94298 6.13952 7 6.00002 7Z" fill="currentcolor"></path>
                        </svg>
                    </span>
                    </div>
                    <div class="language-dropdown">
                        <a href="/ru<?=$page?>">
                            RU
                        </a>
                    </div>
                    <?
                }
                else
                {
                    ?>
                    <div class="language-current">
                        RU
                        <span class="icon">
                    <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.00002 7C5.86053 7 5.72089 6.94298 5.61439 6.82908L0.159852 0.995781C-0.053284 0.767845 -0.053284 0.398743 0.159852 0.170952C0.372988 -0.0568383 0.718124 -0.0569841 0.931123 0.170952L6.00002 5.59184L11.0689 0.170952C11.2821 -0.0569841 11.6272 -0.0569841 11.8402 0.170952C12.0532 0.398889 12.0533 0.767991 11.8402 0.995781L6.38566 6.82908C6.27916 6.94298 6.13952 7 6.00002 7Z" fill="currentcolor"></path>
                    </svg>
                </span>
                    </div>
                    <div class="language-dropdown">
                        <a href="<?=$page?>">
                            UA
                        </a>
                    </div>
                    <?
                }
                ?>

            </div>
        </div>
    </div>
  </div>
    <?
    $res = CIBlockSection::GetList(['DEPTH_LEVEL' => 'asc','sort'=>'asc'], ['IBLOCK_ID' => 43,'ACTIVE'=>'Y'],false,['UF_*']);
    $sections = [];
    while ($section = $res->Fetch())
    {
        if(!$section['IBLOCK_SECTION_ID'])
            $sections[$section['ID']] = $section;
        else
            $sections[$section['IBLOCK_SECTION_ID']]['child'][] = $section;
    }
    $res = CIBlockSection::GetList(['DEPTH_LEVEL' => 'asc','sort'=>'asc'], ['IBLOCK_ID' => 21,'ACTIVE'=>'Y','SECTION_ID'=>361],false,['UF_*']);
    $accsesouries = [];
    while ($section = $res->Fetch())
    {
        $accsesouries[$section['ID']] = $section;
    }
    ?>
  <div class="offcanvas-body">
    <div class="header-menu-body">
        <div class="header-menu-list">
            <div class="header-menu-group">
                <div class="header-menu-item">
                    <a href="<?=$ru?>/catalog/novinki/" class="header-menu-link">
                        <span>
                            NEW
                        </span>
                    </a>
                </div>
                <div class="header-menu-item">

                    <a href="#" class="header-menu-link dropdown click_show_click_catalog">
                        <span>
                          КАТАЛОГ
                        </span>
                        <span class="icon">
                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.12045 8.00004C9.12045 8.2868 9.01096 8.57351 8.79245 8.79214L1.91274 15.6718C1.4751 16.1094 0.765551 16.1094 0.328093 15.6718C-0.109364 15.2343 -0.109364 14.5249 0.328093 14.0872L6.41564 8.00004L0.328306 1.91282C-0.109152 1.47518 -0.109152 0.765844 0.328306 0.328423C0.765764 -0.109425 1.47531 -0.109425 1.91295 0.328423L8.79266 7.20795C9.01121 7.42668 9.12045 7.7134 9.12045 8.00004Z" fill="currentcolor"/>
                            </svg>
                        </span>
                    </a>
                    <div class="header-menu-dropdown show_click_catalog" style="display:none;">
                        <div class="header-menu-semi-block">
                            <div class="header-menu-semi-control">
                                <div class="header-menu-semi-back">
                                    <span class="icon">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_168_12307)">
                                            <path d="M3.44205 7.99996C3.44205 7.7132 3.55154 7.42649 3.77005 7.20786L10.6498 0.328226C11.0874 -0.109409 11.7969 -0.109409 12.2344 0.328226C12.6719 0.765684 12.6719 1.47509 12.2344 1.91276L6.14686 7.99996L12.2342 14.0872C12.6717 14.5248 12.6717 15.2342 12.2342 15.6716C11.7967 16.1094 11.0872 16.1094 10.6496 15.6716L3.76984 8.79205C3.55129 8.57332 3.44205 8.2866 3.44205 7.99996Z" fill="currentcolor" fill-opacity="0.8"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_168_12307">
                                            <rect width="16" height="16" fill="currentcolor" transform="matrix(0 1 -1 0 16 0)"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                    Назад
                                </div>
                            </div>
                            <div class="header-menu-semi-list " >
                                <?
                                foreach ($sections as $index => $section)
                                {
                                    if(
                                        $section['UF_COLLECTION']
                                        || !$section['ID']
                                        || strpos($section['UF_LINK'],'/catalog/podarochnyy_sertifikat/') !== false
                                        || strpos($section['UF_LINK'],'/catalog/bonusna_shafa/') !== false
                                        || strpos($section['UF_LINK'],'/catalog/aksessuary/') !== false
                                    ) continue;
                                    ?>
                                    <div class="header-accordion-block id<?=$section['ID']?>">
                                        <div class="header-accordion-title">
                                            <a href="<?=$ru?><?=$section['UF_LINK']?>" class="header-menu-semi-link">
                                                <?=LANGUAGE_ID=='ua'?$section['UF_NAME_UA']:$section['NAME']?>
                                            </a>
                                            <?
                                            if($section['child'])
                                            {
                                                ?>
                                                <div class="header-accordion-toogler">
                                                    <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.00004 10C8.79079 10 8.58133 9.91854 8.42158 9.75584L0.239778 1.42254C-0.0799262 1.09692 -0.0799261 0.569632 0.239778 0.244218C0.559482 -0.0811974 1.07719 -0.0814056 1.39669 0.244218L9.00004 7.98835L16.6034 0.24422C16.9231 -0.0814029 17.4408 -0.0814028 17.7603 0.244221C18.0798 0.569844 18.08 1.09713 17.7603 1.42255L9.57849 9.75584C9.41874 9.91854 9.20929 10 9.00004 10Z" fill="#999999"/>
                                                    </svg>
                                                </div>
                                                <?
                                            }
                                            ?>
                                        </div>
                                        <?
                                        if($section['child'])
                                        {
                                            ?>
                                            <div class="header-accordion-dropdown">
                                                <div class="header-accordion-dropdown-list">
                                                    <?
                                                    foreach ($section['child'] as $index => $item)
                                                    {
                                                        ?><a href="<?=$ru?><?=$item['UF_LINK']?>"> <?=LANGUAGE_ID=='ua'?$item['UF_NAME_UA']:$item['NAME']?></a><?
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?
                                        }
                                        ?>

                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                        <div class="header-menu-img">
                            <img src="/bitrix/templates/stimma_new/images/delitakate_1279.jpg">
                        </div>
                    </div>

                    <?/*
                    <a href="#" class="header-menu-link dropdown click_show_click_catalog">
                        <span>
                          Всі товари
                        </span>
                        <span class="icon">
                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.12045 8.00004C9.12045 8.2868 9.01096 8.57351 8.79245 8.79214L1.91274 15.6718C1.4751 16.1094 0.765551 16.1094 0.328093 15.6718C-0.109364 15.2343 -0.109364 14.5249 0.328093 14.0872L6.41564 8.00004L0.328306 1.91282C-0.109152 1.47518 -0.109152 0.765844 0.328306 0.328423C0.765764 -0.109425 1.47531 -0.109425 1.91295 0.328423L8.79266 7.20795C9.01121 7.42668 9.12045 7.7134 9.12045 8.00004Z" fill="currentcolor"/>
                            </svg>
                        </span>
                    </a>
                    <div class="header-menu-dropdown">
                        <div class="header-menu-semi-block">
                            <div class="header-menu-semi-control">
                                <div class="header-menu-semi-back">
                                    <span class="icon">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_168_12307)">
                                            <path d="M3.44205 7.99996C3.44205 7.7132 3.55154 7.42649 3.77005 7.20786L10.6498 0.328226C11.0874 -0.109409 11.7969 -0.109409 12.2344 0.328226C12.6719 0.765684 12.6719 1.47509 12.2344 1.91276L6.14686 7.99996L12.2342 14.0872C12.6717 14.5248 12.6717 15.2342 12.2342 15.6716C11.7967 16.1094 11.0872 16.1094 10.6496 15.6716L3.76984 8.79205C3.55129 8.57332 3.44205 8.2866 3.44205 7.99996Z" fill="currentcolor" fill-opacity="0.8"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_168_12307">
                                            <rect width="16" height="16" fill="currentcolor" transform="matrix(0 1 -1 0 16 0)"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                    Назад
                                </div>
                            </div>

                            <div class="header-menu-semi-list show_click_catalog" style="display:none;">
                                <div class="header-accordion-block">
                                    <div class="header-accordion-title">
                                        <a href="<?=$ru?>/catalog/street_casual/" class="header-menu-semi-link">
                                            Street Casual
                                        </a>
                                        <div class="header-accordion-toogler">
                                            <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.00004 10C8.79079 10 8.58133 9.91854 8.42158 9.75584L0.239778 1.42254C-0.0799262 1.09692 -0.0799261 0.569632 0.239778 0.244218C0.559482 -0.0811974 1.07719 -0.0814056 1.39669 0.244218L9.00004 7.98835L16.6034 0.24422C16.9231 -0.0814029 17.4408 -0.0814028 17.7603 0.244221C18.0798 0.569844 18.08 1.09713 17.7603 1.42255L9.57849 9.75584C9.41874 9.91854 9.20929 10 9.00004 10Z" fill="#999999"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="header-accordion-dropdown">
                                        <div class="header-accordion-dropdown-list">
                                            <a href="#"> лінк1</a>
                                            <a href="#"> лінк2</a>
                                            <a href="#"> лінк3</a>
                                            <a href="#"> лінк4</a>
                                            <a href="#"> лінк5</a>
                                            <a href="#"> лінк6</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-accordion-block">
                                    <div class="header-accordion-title">
                                        <a href="<?=$ru?>/catalog/smart_casual/" class="header-menu-semi-link">
                                            Smart Casual
                                        </a>
                                        <div class="header-accordion-toogler">
                                            <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.00004 10C8.79079 10 8.58133 9.91854 8.42158 9.75584L0.239778 1.42254C-0.0799262 1.09692 -0.0799261 0.569632 0.239778 0.244218C0.559482 -0.0811974 1.07719 -0.0814056 1.39669 0.244218L9.00004 7.98835L16.6034 0.24422C16.9231 -0.0814029 17.4408 -0.0814028 17.7603 0.244221C18.0798 0.569844 18.08 1.09713 17.7603 1.42255L9.57849 9.75584C9.41874 9.91854 9.20929 10 9.00004 10Z" fill="#999999"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="header-accordion-dropdown">
                                        <div class="header-accordion-dropdown-list">
                                            <a href="#"> лінк1</a>
                                            <a href="#"> лінк2</a>
                                            <a href="#"> лінк3</a>
                                            <a href="#"> лінк4</a>
                                            <a href="#"> лінк5</a>
                                            <a href="#"> лінк6</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-accordion-block">
                                    <div class="header-accordion-title">
                                         <a href="<?=$ru?>/catalog/winter_drop/" class="header-menu-semi-link">
                                            Winter Drop
                                        </a>
                                        <div class="header-accordion-toogler">
                                            <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.00004 10C8.79079 10 8.58133 9.91854 8.42158 9.75584L0.239778 1.42254C-0.0799262 1.09692 -0.0799261 0.569632 0.239778 0.244218C0.559482 -0.0811974 1.07719 -0.0814056 1.39669 0.244218L9.00004 7.98835L16.6034 0.24422C16.9231 -0.0814029 17.4408 -0.0814028 17.7603 0.244221C18.0798 0.569844 18.08 1.09713 17.7603 1.42255L9.57849 9.75584C9.41874 9.91854 9.20929 10 9.00004 10Z" fill="#999999"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="header-accordion-dropdown">
                                        <div class="header-accordion-dropdown-list">
                                            <a href="#"> лінк1</a>
                                            <a href="#"> лінк2</a>
                                            <a href="#"> лінк3</a>
                                            <a href="#"> лінк4</a>
                                            <a href="#"> лінк5</a>
                                            <a href="#"> лінк6</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-accordion-block">
                                    <div class="header-accordion-title">
                                        <a href="<?=$ru?>/catalog/events/" class="header-menu-semi-link">
                                            Events
                                        </a>
                                        <div class="header-accordion-toogler">
                                            <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.00004 10C8.79079 10 8.58133 9.91854 8.42158 9.75584L0.239778 1.42254C-0.0799262 1.09692 -0.0799261 0.569632 0.239778 0.244218C0.559482 -0.0811974 1.07719 -0.0814056 1.39669 0.244218L9.00004 7.98835L16.6034 0.24422C16.9231 -0.0814029 17.4408 -0.0814028 17.7603 0.244221C18.0798 0.569844 18.08 1.09713 17.7603 1.42255L9.57849 9.75584C9.41874 9.91854 9.20929 10 9.00004 10Z" fill="#999999"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="header-accordion-dropdown">
                                        <div class="header-accordion-dropdown-list">
                                            <a href="#"> лінк1</a>
                                            <a href="#"> лінк2</a>
                                            <a href="#"> лінк3</a>
                                            <a href="#"> лінк4</a>
                                            <a href="#"> лінк5</a>
                                            <a href="#"> лінк6</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-accordion-block">
                                    <div class="header-accordion-title">
                                        <a href="<?=$ru?>/catalog/limited/" class="header-menu-semi-link">
                                            Limited
                                        </a>
                                        <div class="header-accordion-toogler">
                                            <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.00004 10C8.79079 10 8.58133 9.91854 8.42158 9.75584L0.239778 1.42254C-0.0799262 1.09692 -0.0799261 0.569632 0.239778 0.244218C0.559482 -0.0811974 1.07719 -0.0814056 1.39669 0.244218L9.00004 7.98835L16.6034 0.24422C16.9231 -0.0814029 17.4408 -0.0814028 17.7603 0.244221C18.0798 0.569844 18.08 1.09713 17.7603 1.42255L9.57849 9.75584C9.41874 9.91854 9.20929 10 9.00004 10Z" fill="#999999"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="header-accordion-dropdown">
                                        <div class="header-accordion-dropdown-list">
                                            <a href="#"> лінк1</a>
                                            <a href="#"> лінк2</a>
                                            <a href="#"> лінк3</a>
                                            <a href="#"> лінк4</a>
                                            <a href="#"> лінк5</a>
                                            <a href="#"> лінк6</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header-menu-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/header-m-img.png">
                        </div>
                    </div>
                    */?>
                </div>

                <div class="header-menu-item">
                    <a href="#" class="header-menu-link dropdown click_show_click_collection">
                        <span>
                          КОЛЕКЦІЇ
                        </span>
                        <span class="icon">
                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.12045 8.00004C9.12045 8.2868 9.01096 8.57351 8.79245 8.79214L1.91274 15.6718C1.4751 16.1094 0.765551 16.1094 0.328093 15.6718C-0.109364 15.2343 -0.109364 14.5249 0.328093 14.0872L6.41564 8.00004L0.328306 1.91282C-0.109152 1.47518 -0.109152 0.765844 0.328306 0.328423C0.765764 -0.109425 1.47531 -0.109425 1.91295 0.328423L8.79266 7.20795C9.01121 7.42668 9.12045 7.7134 9.12045 8.00004Z" fill="currentcolor"/>
                            </svg>
                        </span>
                    </a>
                    <div class="header-menu-dropdown show_click_collection" style="display:none;">
                        <div class="header-menu-semi-block">
                            <div class="header-menu-semi-control">
                                <div class="header-menu-semi-back">
                                    <span class="icon">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_168_12307)">
                                            <path d="M3.44205 7.99996C3.44205 7.7132 3.55154 7.42649 3.77005 7.20786L10.6498 0.328226C11.0874 -0.109409 11.7969 -0.109409 12.2344 0.328226C12.6719 0.765684 12.6719 1.47509 12.2344 1.91276L6.14686 7.99996L12.2342 14.0872C12.6717 14.5248 12.6717 15.2342 12.2342 15.6716C11.7967 16.1094 11.0872 16.1094 10.6496 15.6716L3.76984 8.79205C3.55129 8.57332 3.44205 8.2866 3.44205 7.99996Z" fill="currentcolor" fill-opacity="0.8"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_168_12307">
                                            <rect width="16" height="16" fill="currentcolor" transform="matrix(0 1 -1 0 16 0)"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                    Назад
                                </div>
                            </div>
                            <div class="header-menu-text " >
                                <?=LANGUAGE_ID=='ua'?
                                'Виберіть свій унікальний стиль — чи то єдиний шедевр, чи еклектичне поєднання з різних колекцій. Втілюйте своє бачення, поєднуючи'
                                :
                                'Выберите свой уникальный стиль — будь то единичный шедевр или эклектичное сочетание из разных коллекций. Воплощайте своё видение, сочетая'?>
                                 
                            </div>
                            <div class="header-menu-semi-list show_click_collection" style="display:none;">
                                <?
                                foreach ($sections as $index => $section)
                                {
                                    if(
                                            !$section['UF_COLLECTION']
                                            || strpos($section['UF_LINK'],'/catalog/novinki/') !== false
                                            || strpos($section['UF_LINK'],'/catalog/rasprodazha/') !== false
                                            || strpos($section['UF_LINK'],'/catalog/khity_prodazh/') !== false

                                    ) continue;
                                    ?>
                                    <a href="<?=$ru?><?=$section['UF_LINK']?>" class="header-menu-semi-link">
                                        <?=LANGUAGE_ID=='ua'?$section['UF_NAME_UA']:$section['NAME']?>
                                    </a>
                                    <?
                                }
                                ?>
                                <?/*
                                <a href="<?=$ru?>/catalog/street_casual/" class="header-menu-semi-link">
                                    Street Casual
                                </a>
                                <a href="<?=$ru?>/catalog/smart_casual/" class="header-menu-semi-link">
                                    Smart Casual
                                </a>
                                <a href="<?=$ru?>/catalog/winter_drop/" class="header-menu-semi-link">
                                    Winter Drop
                                </a>
                                <a href="<?=$ru?>/catalog/events/" class="header-menu-semi-link">
                                    Events
                                </a>
                                <a href="<?=$ru?>/catalog/limited/" class="header-menu-semi-link">
                                    Limited
                                </a>
                                */?>
                            </div>
                        </div>
                        <div class="header-menu-img">
                            <img src="/bitrix/templates/stimma_new/images/delitakate_1279.jpg">
                        </div>
                    </div>
                </div>
                <div class="header-menu-item">
                    <a href="<?=$ru?>/catalog/khity_prodazh/" class="header-menu-link">
                        <span>
                            BESTSELLERS
                        </span>
                    </a>
                </div>
                <div class="header-menu-item">
                    <a href="<?=$ru?>/catalog/rasprodazha/" class="header-menu-link">
                        <span>
                            ЗНИЖКИ
                        </span>
                        <span class="header-menu-badge">
                            SALE
                        </span>
                    </a>
                </div>
                <div class="header-menu-item">
                    <a href="<?=$ru?>/catalog/zhenskaya_odezhda/" class="header-menu-link">
                        <span>
                            <?=LANGUAGE_ID=='ua'?'ВСІ ТОВАРИ':'ВСЕ ТОВАРЫ'?>
                        </span>
                    </a>
                </div>
                <?/*<div class="header-menu-item">
                    <a href="<?=$ru?>/catalog/zhenskaya_odezhda/" class="header-menu-link">
                        <span>
                            <?=LANGUAGE_ID=='ua' ? 'ВСІ ТОВАРИ' : 'ВСЕ ТОВАРЫ'?>
                        </span>
                    </a>
                </div>*/?>
                <div class="header-menu-item">
                    <div class="header-menu-item-dropdown-title">
                        <a href="<?=$ru?>/catalog/aksessuary/" class="header-menu-link">
                            <span>
                                <?=LANGUAGE_ID=='ua' ? 'АКСЕСУАРИ' : 'АКСЕССУАРЫ'?>
                            </span>
                        </a>
                        <span class="header-menu-item-icon-dropdown">
                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.12045 8.00004C9.12045 8.2868 9.01096 8.57351 8.79245 8.79214L1.91274 15.6718C1.4751 16.1094 0.765551 16.1094 0.328093 15.6718C-0.109364 15.2343 -0.109364 14.5249 0.328093 14.0872L6.41564 8.00004L0.328306 1.91282C-0.109152 1.47518 -0.109152 0.765844 0.328306 0.328423C0.765764 -0.109425 1.47531 -0.109425 1.91295 0.328423L8.79266 7.20795C9.01121 7.42668 9.12045 7.7134 9.12045 8.00004Z" fill="currentcolor"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="header-menu-item-dropdown-cont">
                        <div class="header-menu-item-dropdown-block">
                            <?
                            foreach ($accsesouries as $index => $accsesoury)
                            {
                                ?>
                                <a href="<?=$ru?>/catalog/aksessuary/<?=$accsesoury['CODE']?>/">
                                    <?=LANGUAGE_ID=='ua' ? $accsesoury['UF_NAME_UA'] : $accsesoury['NAME']?>
                                </a>
                                <?
                            }
                            ?>
                        </div>
                    </div>


                    <?/*
                    <div class="header-menu-item-dropdown-cont">
                        <div class="header-menu-item-dropdown-block">
                            <a href="#">
                                Аксесуар 1
                            </a>
                            <a href="#">
                                Аксесуар 2
                            </a>
                            <a href="#">
                                Аксесуар 3
                            </a>
                            <a href="#">
                                Аксесуар 4
                            </a>
                            <a href="#">
                                Аксесуар 5
                            </a>
                            <a href="#">
                                Аксесуар 6
                            </a>
                        </div>
                    </div>
                    */?>
                </div>
                <div class="header-menu-item">
                    <div class="header-menu-item-dropdown-title">
                        <a href="<?=$ru?>/catalog/bonusna_shafa/" class="header-menu-link">
                            <span>
                                <?=LANGUAGE_ID=='ua' ? 'БОНУСНА ШАФА' : 'БОНУСНАЯ ШАФА'?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="header-menu-group bordered">
                <div class="header-menu-item little">
                    <a href="<?=$ru?>/catalog/podarochnyy_sertifikat/" class="header-menu-link">
                        <span>
                            <?=LANGUAGE_ID=='ua' ? 'Подарунковий сертифікат' : 'Подарочный сертификат'?>
                        </span>
                    </a>
                </div>
                <div class="header-menu-item little">
                    <a href="<?=$ru?>/pro-nas/razmirna-sitka/" class="header-menu-link">
                        <span>
                            <?=LANGUAGE_ID=='ua' ? 'Розмірна сітка' : 'Размерная сетка'?>
                        </span>
                    </a>
                </div>
                <div class="header-menu-item little">
                    <a href="<?=$ru?>/pro-nas/dostavka-ta-oplata/" class="header-menu-link">
                        <span>
                            <?=LANGUAGE_ID=='ua' ? 'Оплата та доставка' : 'Оплата и доставка'?>
                        </span>
                    </a>
                </div>
                <div class="header-menu-item little">
                    <a href="<?=$ru?>/pro-nas/garantiya-ta-povernennya/" class="header-menu-link">
                        <span>
                            <?=LANGUAGE_ID=='ua' ? ' Гарантія та повернення' : 'Гарантия и возврат'?>
                        </span>
                    </a>
                </div>

                <?/*<div class="header-menu-item little">
                    <a href="<?=$ru?>/contacts/" class="header-menu-link">
                        <span>
                            <?=LANGUAGE_ID=='ua' ? 'Магазини' : 'Магазины'?>
                        </span>
                    </a>
                </div>*/?>
                <div class="header-menu-item little">
                    <a href="<?=$ru?>/sama_sobi/" class="header-menu-link">
                        <span>
                            <?=LANGUAGE_ID=='ua' ? 'Програма лояльності' : 'Программа лояльности'?>
                        </span>
                    </a>
                </div>
                <div class="header-menu-item little">
                    <a href="<?=$ru?>/pro-nas/" class="header-menu-link">
                        <span>
                            <?=LANGUAGE_ID=='ua' ? 'Про нас' : 'О нас'?>
                        </span>
                    </a>
                </div>

            </div>
            <div class="header-menu-group bordered social">
               <a href="#">
                   <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.9438 0C8.49824 0 0 8.49824 0 18.9438C0 29.3886 8.49824 37.8876 18.9438 37.8876C29.3886 37.8876 37.8876 29.3886 37.8876 18.9438C37.8876 8.49824 29.3902 0 18.9438 0ZM23.655 19.6107H20.573V30.5958H16.006C16.006 30.5958 16.006 24.5935 16.006 19.6107H13.8351V15.7283H16.006V13.217C16.006 11.4185 16.8607 8.60812 20.6149 8.60812L23.9991 8.6211V12.3899C23.9991 12.3899 21.9427 12.3899 21.5428 12.3899C21.143 12.3899 20.5745 12.5898 20.5745 13.4475V15.729H24.0541L23.655 19.6107Z" fill="currentcolor"/>
                    </svg>
               </a>
               <a href="#">
                   <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="19" cy="19" r="19" fill="currentcolor"/>
                        <path d="M19.2086 22.4719C21.0108 22.4719 22.4719 21.0108 22.4719 19.2086C22.4719 17.4063 21.0108 15.9453 19.2086 15.9453C17.4063 15.9453 15.9453 17.4063 15.9453 19.2086C15.9453 21.0108 17.4063 22.4719 19.2086 22.4719Z" fill="#1E1E1E"/>
                        <path d="M24.8532 13.4375C24.7829 13.4375 24.7227 13.4977 24.7227 13.568C24.7227 13.7186 24.9938 13.7186 24.9938 13.568C24.9938 13.4977 24.9335 13.4375 24.8632 13.4375H24.8532Z" fill="#1E1E1E"/>
                        <path d="M23.2241 9.41797H15.1915C12.0085 9.41797 9.41797 12.0085 9.41797 15.1915V23.2241C9.41797 26.4071 12.0085 28.9976 15.1915 28.9976H23.2241C26.4071 28.9976 28.9976 26.4071 28.9976 23.2241V15.1915C28.9976 12.0085 26.4071 9.41797 23.2241 9.41797ZM19.2078 23.9772C16.5771 23.9772 14.4384 21.8385 14.4384 19.2078C14.4384 16.5771 16.5771 14.4384 19.2078 14.4384C21.8385 14.4384 23.9772 16.5771 23.9772 19.2078C23.9772 21.8385 21.8385 23.9772 19.2078 23.9772ZM24.8508 14.9404C24.0977 14.9404 23.4752 14.3279 23.4752 13.5648C23.4752 12.8017 24.0877 12.1892 24.8508 12.1892C25.6139 12.1892 26.2264 12.8017 26.2264 13.5648C26.2264 14.3279 25.6139 14.9404 24.8508 14.9404Z" fill="#1E1E1E"/>
                    </svg>
               </a>
               <a href="#">
                   <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="19" cy="19" r="19" fill="currentcolor"/>
                        <path d="M29.5467 13.5036C29.2932 12.5246 28.5501 11.7529 27.6078 11.4893C25.8862 11 18.9998 11 18.9998 11C18.9998 11 12.1136 11 10.392 11.4707C9.46779 11.7341 8.70657 12.5248 8.45305 13.5036C8 15.2917 8 19 8 19C8 19 8 22.727 8.45305 24.4964C8.70684 25.4752 9.44966 26.247 10.3922 26.5106C12.1317 27 19 27 19 27C19 27 25.8862 27 27.6078 26.5293C28.5502 26.2658 29.2932 25.4941 29.547 24.5152C29.9999 22.727 29.9999 19.0188 29.9999 19.0188C29.9999 19.0188 30.018 15.2917 29.5467 13.5036ZM16.8073 22.4258V15.5742L22.5337 19L16.8073 22.4258Z" fill="#1E1E1E"/>
                    </svg>
               </a>
               <a href="#">
                   <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="19" cy="19" r="19" fill="currentcolor"/>
                    <path d="M28.2514 13.5166C26.9959 13.5166 25.8375 13.1007 24.9072 12.399C23.8403 11.5946 23.0737 10.4147 22.803 9.05473C22.736 8.71871 22.6999 8.37195 22.6964 8.0166H19.1098V17.8169L19.1055 23.185C19.1055 24.6202 18.171 25.837 16.8755 26.265C16.4995 26.3892 16.0934 26.448 15.6706 26.4248C15.1309 26.3952 14.6252 26.2323 14.1856 25.9694C13.2502 25.4099 12.616 24.395 12.5988 23.234C12.5717 21.4194 14.0387 19.94 15.852 19.94C16.2099 19.94 16.5536 19.9984 16.8755 20.1046V17.4259V16.463C16.536 16.4127 16.1905 16.3865 15.8412 16.3865C13.8565 16.3865 12.0002 17.2115 10.6734 18.6978C9.67047 19.821 9.06891 21.254 8.97609 22.7566C8.85449 24.7306 9.5768 26.607 10.9776 27.9915C11.1834 28.1947 11.3995 28.3834 11.6255 28.5574C12.8265 29.4816 14.2948 29.9827 15.8412 29.9827C16.1905 29.9827 16.536 29.9569 16.8755 29.9066C18.3201 29.6926 19.653 29.0313 20.7048 27.9915C21.9973 26.714 22.7115 25.018 22.7192 23.2129L22.7007 15.1967C23.3173 15.6723 23.9915 16.0659 24.7151 16.3714C25.8405 16.8463 27.0337 17.0869 28.2618 17.0864V14.4821V13.5157C28.2626 13.5166 28.2523 13.5166 28.2514 13.5166Z" fill="#1E1E1E"/>
                </svg>
               </a>
               <a href="#">
                   <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="19" cy="19" r="19" fill="currentcolor"/>
                    <g clip-path="url(#clip0_2124_874)">
                    <path d="M18.7998 31H18.7929C15.2121 30.9757 12.4593 29.7952 10.6097 27.49C8.9632 25.439 8.11444 22.5851 8.08594 19.0087V18.9913C8.11448 15.414 8.9632 12.5609 10.6097 10.51C12.4584 8.20483 15.2121 7.02419 18.792 7H18.8058C21.5508 7.01814 23.8473 7.72427 25.632 9.09681C27.3097 10.3872 28.4903 12.2265 29.142 14.5644L27.1023 15.1331C25.9986 11.1737 23.2052 9.14955 18.7989 9.11758C15.8897 9.1383 13.69 10.0527 12.2596 11.835C10.92 13.504 10.2277 15.9145 10.2026 18.9992C10.2285 22.0847 10.9208 24.4953 12.2596 26.1634C13.6901 27.9455 15.8897 28.8599 18.7989 28.8807C21.4212 28.8617 23.1568 28.2507 24.6002 26.8367C26.2475 25.2229 26.2173 23.2437 25.69 22.0398C25.3798 21.3302 24.8161 20.739 24.0564 20.2913C23.8655 21.6414 23.4359 22.7373 22.7721 23.5627C21.887 24.6647 20.6321 25.2671 19.0435 25.3526C17.8412 25.4174 16.6831 25.1332 15.7842 24.5515C14.7211 23.8635 14.0988 22.8107 14.0323 21.5869C13.9674 20.3968 14.4394 19.3025 15.3607 18.5056C16.2414 17.7442 17.48 17.2974 18.9432 17.2152C20.0219 17.1547 21.0305 17.2023 21.9631 17.3578C21.8395 16.6154 21.5889 16.0268 21.2155 15.6016C20.7021 15.0164 19.9078 14.7174 18.8559 14.7105H18.8265C17.9821 14.7105 16.8352 14.9421 16.104 16.0294L14.3469 14.8479C15.3253 13.3933 16.9148 12.5929 18.8257 12.5929H18.8689C22.0643 12.6128 23.9666 14.567 24.1559 17.9801C24.2647 18.026 24.3711 18.0734 24.4765 18.1227C25.9675 18.8237 27.0573 19.8851 27.6295 21.1919C28.4264 23.0138 28.4999 25.9828 26.0807 28.3509C24.2328 30.1607 21.989 30.9775 18.8058 30.9992H18.7989L18.7998 31ZM19.8024 19.3085C19.5604 19.3085 19.3149 19.3154 19.0642 19.3301C17.2276 19.4339 16.0832 20.2749 16.1481 21.4728C16.2164 22.7277 17.601 23.3111 18.9311 23.2394C20.1558 23.1737 21.7497 22.6975 22.0167 19.5289C21.3407 19.3846 20.5975 19.3085 19.8023 19.3085H19.8024Z" fill="#1E1E1E"/>
                    </g>
                </svg>
               </a>
            </div>
        </div>
        <div class="header-menu-value">
            
        </div>
    </div>
  </div>
</div>


<main>

