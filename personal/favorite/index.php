<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Особистий кабінет");

if(!$USER->IsAuthorized())
{
    $ru=LANGUAGE_ID=='ru'?'/ru':'';
    include $_SERVER['DOCUMENT_ROOT'].$ru.'/auth/auth.php';
}
else
{
    ?>
    <div class="breadcrumbs-cont">
        <div class="wrapper">
            <div class="breadcrumbs-block">
                <a href="/" class="breadcrumb-item">
                    STIMMA
                </a>
                <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"></path>
                        </svg>
                    </span>
                <span class="breadcrumb-item">
                        Особистий кабінет
                    </span>
            </div>
        </div>
    </div>

    <div class="personal-page">
        <div class="wrapper">
            <div class="personal-cont">
                <?include '../left_menu.php'?>


                <div class="personal-content">


                    <div class="personal-content-block">
                        <div class="personal-content-title-block">
                            <div class="personal-content-title">
                                <?=LANGUAGE_ID=='ua'?'Твій вішліст':'Твой вишлист'?>
                            </div>
                        </div>
                        <?
                        global $favorite;
                        $favorite = ['ID' => $_SESSION['FAVORITE']];

                        if(empty($favorite['ID']))
                        {
                            ?>
                            <div class="personal-wish-list-empty">
                                <div class="personal-wish-list-empty-text">
                                    <p>Список бажань порожній</p>
                                    <p class="uppercase">ДOДABAЙ HEOБMEЖEHУ KІЛЬKІCTЬ CBOЇX БAЖAHOK, ПЛAHУЙ OБPAЗИ І OБИPAЙ CEPЦEM!</p>
                                </div>
                                <div class="personal-wish-list-empty-btn">
                                    <a href="/catalog/zhenskaya_odezhda/" class="info-btn info-btn-black">
                                        До каталогу
                                    </a>
                                </div>
                            </div>
                            <?
                        }
                        else
                        {
                            $params = [
                                    'IBLOCK_TYPE' => 'aspro_max_catalog',
                                    'IBLOCK_ID' => '21',
                                    'ELEMENT_SORT_FIELD' => 'ID',
                                    'ELEMENT_SORT_ORDER' => 'desc',
                                    'ELEMENT_SORT_FIELD2' => 'sort',
                                    'ELEMENT_SORT_ORDER2' => 'asc',
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
                                            119 => 'SOSTAV_SITE_RU',
                                            120 => 'SOSTAV_SITE_UA',
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
                                    'CACHE_TYPE' => 'A',
                                    'CACHE_TIME' => '3600000',
                                    'CACHE_FILTER' => 'Y',
                                    'CACHE_GROUPS' => 'Y',
                                    'SET_TITLE' => 'N',
                                    'MESSAGE_404' => '',
                                    'SET_STATUS_404' => 'Y',
                                    'SHOW_404' => 'Y',
                                    'FILE_404' => '',
                                    'DISPLAY_COMPARE' => 'Y',
                                    'PAGE_ELEMENT_COUNT' => '10',
                                    'LINE_ELEMENT_COUNT' => '4',
                                    'PRICE_CODE' => [0 => 'BASE',],
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
                                    'SECTION_ID' => '347',
                                    'SECTION_CODE' => 'zhenskaya_odezhda',
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
                                    'WRAP_CLASS' => 'main-googs-list',
                                    'BLOCK_CLASS' => 'main-googs-item-cont',
                            ];

                            //global $arViewed;
                            //$arViewed = ['ID' => $ids];
                            //$params['FILTER_NAME'] = 'arViewed';
                            //$params['SECTION_ID'] = '350';
                            //$params['ONLY_SECOND'] = true;
                            $params['PAGE_ELEMENT_COUNT'] = 800;
                            $params['BLOCK_CLASS']= 'personal-wish-list-item';
                            $params['WRAP_CLASS']= 'personal-wish-list';

                            $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.section",
                                    "main",
                                    $params,
                                    false
                            );
                        }

                        ?>
                        <?/*
                        <div class="personal-wish-list">
                            <div class="personal-wish-list-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg1.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#" class="active">
                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="catalog-item-badges">
                                            <div class="catalog-item-badge discount">
                                                -50%
                                            </div>
                                        </div>
                                        <div class="catalog-item-more-info">
                                            <div class="catalog-item-btn-buy">
                                                <a href="#">
                                                    Додати до кошика
                                                </a>
                                            </div>
                                            <div class="catalog-item-size-list">
                                                <label>
                                                    <input type="radio" name="radio1">
                                                    <span class="catalog-item-size">
                                                            XS
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio1">
                                                    <span class="catalog-item-size">
                                                            S
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio1">
                                                    <span class="catalog-item-size">
                                                            M
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio1">
                                                    <span class="catalog-item-size">
                                                            XS
                                                        </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="catalog-item-info">
                                        <a href="#" class="catalog-item-name">
                                            Жіночий лонгслів Stimma Саймін Теракотовий
                                        </a>
                                        <div class="catalog-item-details">
                                            <div class="catalog-item-price-block">
                                                <div class="catalog-item-price-new">
                                                    1 499 ₴
                                                </div>
                                                <div class="catalog-item-price-old">
                                                    2 999 ₴
                                                </div>
                                            </div>
                                            <div class="catalog-item-color-block">
                                                <a href="#" style="background:#CB594F ;">
                                                </a>
                                                <a href="#" style="background:#8B5231 ;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="personal-wish-list-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg2.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#" class="active">
                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="catalog-item-more-info">
                                            <div class="catalog-item-btn-buy">
                                                <a href="#">
                                                    Додати до кошика
                                                </a>
                                            </div>
                                            <div class="catalog-item-size-list">
                                                <label>
                                                    <input type="radio" name="radio2">
                                                    <span class="catalog-item-size">
                                                            XS
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio2">
                                                    <span class="catalog-item-size">
                                                            S
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio2">
                                                    <span class="catalog-item-size">
                                                            M
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio2">
                                                    <span class="catalog-item-size">
                                                            XS
                                                        </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="catalog-item-info">
                                        <a href="#" class="catalog-item-name">
                                            Жіноча куртка Stimma Анір
                                        </a>
                                        <div class="catalog-item-details">
                                            <div class="catalog-item-price-block">
                                                <div class="catalog-item-price">
                                                    3 699 ₴
                                                </div>
                                            </div>
                                            <div class="catalog-item-color-block">
                                                <a href="#" style="background:#CB594F ;">
                                                </a>
                                                <a href="#" style="background:#8B5231 ;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="personal-wish-list-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg3.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#" class="active">
                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="catalog-item-more-info">
                                            <div class="catalog-item-btn-buy">
                                                <a href="#">
                                                    Додати до кошика
                                                </a>
                                            </div>
                                            <div class="catalog-item-size-list">
                                                <label>
                                                    <input type="radio" name="radio3">
                                                    <span class="catalog-item-size">
                                                            XS
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio3">
                                                    <span class="catalog-item-size">
                                                            S
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio3">
                                                    <span class="catalog-item-size">
                                                            M
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio3">
                                                    <span class="catalog-item-size">
                                                            XS
                                                        </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="catalog-item-info">
                                        <a href="#" class="catalog-item-name">
                                            Жіноча сукня Stimma Памо коричневий
                                        </a>
                                        <div class="catalog-item-details">
                                            <div class="catalog-item-price-block">
                                                <div class="catalog-item-price">
                                                    1 999 ₴
                                                </div>
                                            </div>
                                            <div class="catalog-item-color-block">
                                                <a href="#" style="background:#CB594F ;">
                                                </a>
                                                <a href="#" style="background:#8B5231 ;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="personal-wish-list-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg4.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#" class="active">
                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="catalog-item-more-info">
                                            <div class="catalog-item-btn-buy">
                                                <a href="#">
                                                    Додати до кошика
                                                </a>
                                            </div>
                                            <div class="catalog-item-size-list">
                                                <label>
                                                    <input type="radio" name="radio4">
                                                    <span class="catalog-item-size">
                                                            XS
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio4">
                                                    <span class="catalog-item-size">
                                                            S
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio4">
                                                    <span class="catalog-item-size">
                                                            M
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio4">
                                                    <span class="catalog-item-size">
                                                            XS
                                                        </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="catalog-item-info">
                                        <a href="#" class="catalog-item-name">
                                            Жіночий блейзер Stimma Альріл коричневий
                                        </a>
                                        <div class="catalog-item-details">
                                            <div class="catalog-item-price-block">
                                                <div class="catalog-item-price">
                                                    2 999 ₴
                                                </div>
                                            </div>
                                            <div class="catalog-item-color-block">
                                                <a href="#" style="background:#CB594F ;">
                                                </a>
                                                <a href="#" style="background:#8B5231 ;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="personal-wish-list-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg1.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#" class="active">
                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="catalog-item-more-info">
                                            <div class="catalog-item-btn-buy">
                                                <a href="#">
                                                    Додати до кошика
                                                </a>
                                            </div>
                                            <div class="catalog-item-size-list">
                                                <label>
                                                    <input type="radio" name="radio5">
                                                    <span class="catalog-item-size">
                                                            XS
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio5">
                                                    <span class="catalog-item-size">
                                                            S
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio5">
                                                    <span class="catalog-item-size">
                                                            M
                                                        </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio5">
                                                    <span class="catalog-item-size">
                                                            XS
                                                        </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="catalog-item-info">
                                        <a href="#" class="catalog-item-name">
                                            Жіночий лонгслів Stimma Саймін Теракотовий
                                        </a>
                                        <div class="catalog-item-details">
                                            <div class="catalog-item-price-block">
                                                <div class="catalog-item-price">
                                                    799 ₴
                                                </div>
                                            </div>
                                            <div class="catalog-item-color-block">
                                                <a href="#" style="background:#CB594F ;">
                                                </a>
                                                <a href="#" style="background:#8B5231 ;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        */?>
                    </div>



                </div>
            </div>
        </div>
    </div>
    <?
}
?>

<?


