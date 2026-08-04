<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Интернет магазин одежды от производителя Стимма. &ndash; STIMMA");
$APPLICATION->SetPageProperty("title", "Интернет магазин одежды от производителя Стимма. &ndash; STIMMA");
$APPLICATION->SetPageProperty("viewed_show", "Y");
$APPLICATION->SetTitle("Стимма");

if(isset($_GET['newstimma']) || NEW_STIMMA )
{
    $Looks = [];
    $res = CIBlockElement::GetList(['SORT'=>'asc'],['IBLOCK_ID' => 55,'ACTIVE' => 'Y']);
    while ($record = $res->GetNextElement())
    {
        $fields = $record->GetFields();
        $props = $record->GetProperties();

        $Looks[$fields['ID']] = $fields;
        $Looks[$fields['ID']]['PROPERTIES'] = $props;
    }

    $res = CIBlockElement::GetList(['SORT'=>'asc'],['IBLOCK_ID' => 41,'ACTIVE' => 'Y','ACTIVE_DATE'=>'Y','SECTION_ID'=>1336]);
    $data = [];
    $products = [];
    while ($record = $res->GetNextElement())
    {
        $fields = $record->GetFields();
        $props = $record->GetProperties();

        /*if($props['PRODUCTS']['VALUE'])
            foreach($props['PRODUCTS']['VALUE'] as $index => $product)
                $products[$product] = $product;*/

        $data[$fields['ID']] = $fields;
        $data[$fields['ID']]['PROPERTIES'] = $props;
    }
    $dataMainSlider=$data;
    $ru=LANGUAGE_ID=='ru'?'/ru':'';
    ?>
    <div class="main-banner">
        <div class="main-banner-slider">
            <?
            foreach ($dataMainSlider as $index => $item)
            {
                $file = CFile::GetFileArray($item['PROPERTIES']['FILE']['VALUE'][0])['SRC'];
                $fileMob = CFile::GetFileArray($item['PROPERTIES']['FIRST_BANNER_MOB']['VALUE'])['SRC'];
                ?>
                <div class="main-banner-slider-item">
                    <div class="main-banner-img">
                        <?if($item['PROPERTIES']['LINK']['VALUE']){?><a href="<?=$item['PROPERTIES']['LINK']['VALUE']?>" class="main-banner-link"><?}?>
                            <?
                            if((strpos($file, '.m4v')!==false || strpos($file, '.mp4')!==false || strpos($file, '.MP4')!==false))
                            {
                                ?>
                                <video class="img-desc"
                                       autoplay
                                       muted
                                       loop
                                       playsinline
                                       preload="auto"
                                    <?/*controls */?>
                                    <?/*poster="<?=$slider[0]?>"*/?>
                                >
                                    <source src="<?=$file?>" type="video/mp4">
                                    Ваш браузер не поддерживает видео
                                </video>
                                <video class="img-mob"
                                       autoplay
                                       muted
                                       loop
                                       playsinline
                                       preload="auto"
                                    <?/*controls */?>
                                    <?/*poster="<?=$slider[0]?>"*/?>
                                >
                                    <source src="<?=$fileMob?>" type="video/mp4">
                                    Ваш браузер не поддерживает видео
                                </video>
                                <?
                            }
                            else
                            {
                                ?>
                                <img class="img-desc" src="<?=$file?>">
                                <img class="img-mob" src="<?=$fileMob?>">
                                <?
                            }
                            ?>

                            <?if($item['PROPERTIES']['LINK']['VALUE']){?></a><?}?>
                    </div>
                    <div class="main-banner-text">
                        <?
                        if($item['PROPERTIES']['SEMI_TITLE_'.strtoupper(LANGUAGE_ID)]['VALUE'])
                        {
                            ?>
                            <div class="main-banner-semi-title">
                                <?=$item['PROPERTIES']['SEMI_TITLE_'.strtoupper(LANGUAGE_ID)]['VALUE']?>
                            </div>
                            <?
                        }
                        ?>
                        <?
                        if($item['PROPERTIES']['TITLE_'.strtoupper(LANGUAGE_ID)]['VALUE'])
                        {
                            ?>
                            <div class="main-banner-title">
                                <?=$item['PROPERTIES']['TITLE_'.strtoupper(LANGUAGE_ID)]['VALUE']?>
                            </div>
                            <?
                        }
                        ?>

                        <?if($item['PROPERTIES']['LINK']['VALUE']){?><a href="<?=$item['PROPERTIES']['LINK']['VALUE']?>" class="main-banner-link"><?}?>
                            Перейти
                            <span class="icon">
                                    <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                    </svg>
                                </span>
                            <?if($item['PROPERTIES']['LINK']['VALUE']){?></a><?}?>
                    </div>
                </div>
                <?
            }
            ?>
            <?/*
                <div class="main-banner-slider-item">
                    <div class="main-banner-img">
                        <div class="main-banner-video-control">
                            <a href="#" class="main-banner-video-btn">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.78651 2.125H4.8677C4.62674 2.12469 4.38809 2.17186 4.16537 2.26382C3.94265 2.35578 3.74024 2.49072 3.56969 2.66094C3.39915 2.83116 3.26381 3.03331 3.17143 3.25585C3.07904 3.47839 3.0314 3.71695 3.03125 3.95791V14.0412C3.03141 14.2823 3.07903 14.5209 3.1714 14.7435C3.26378 14.9661 3.39909 15.1683 3.56962 15.3386C3.74015 15.5089 3.94256 15.644 4.16528 15.7361C4.38801 15.8282 4.62669 15.8755 4.8677 15.8753H5.78651C6.02752 15.8755 6.2662 15.8282 6.48893 15.7361C6.71165 15.644 6.91406 15.5089 7.08459 15.3386C7.25512 15.1683 7.39043 14.9661 7.48281 14.7435C7.57518 14.5209 7.6228 14.2823 7.62296 14.0412V3.95791C7.62233 3.47137 7.42854 3.00499 7.08417 2.66129C6.7398 2.31758 6.27305 2.12469 5.78651 2.125ZM13.1323 2.125H12.2135C11.7269 2.12469 11.2602 2.31758 10.9158 2.66129C10.5715 3.00499 10.3777 3.47137 10.377 3.95791V14.0412C10.3772 14.2823 10.4248 14.5209 10.5172 14.7435C10.6096 14.9661 10.7449 15.1683 10.9154 15.3386C11.0859 15.5089 11.2883 15.644 11.5111 15.7361C11.7338 15.8282 11.9725 15.8755 12.2135 15.8753H13.1323C13.3733 15.8755 13.612 15.8282 13.8347 15.7361C14.0574 15.644 14.2598 15.5089 14.4304 15.3386C14.6009 15.1683 14.7362 14.9661 14.8286 14.7435C14.921 14.5209 14.9686 14.2823 14.9687 14.0412V3.95791C14.9686 3.71695 14.921 3.47839 14.8286 3.25585C14.7362 3.03331 14.6009 2.83116 14.4303 2.66094C14.2598 2.49072 14.0573 2.35578 13.8346 2.26382C13.6119 2.17186 13.3733 2.12469 13.1323 2.125Z" fill="white"/>
                                </svg>
                            </a>
                            <a href="#" class="main-banner-video-btn">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                    <path d="M10.074 17.8329C10.2192 17.9463 10.3992 18 10.5792 18C10.7127 18 10.8521 17.9702 10.974 17.9045C11.2643 17.7494 11.4501 17.4391 11.4501 17.1048V0.896162C11.4501 0.561963 11.2643 0.251623 10.974 0.0964526C10.6895 -0.0527436 10.3353 -0.0288483 10.074 0.168103L3.9425 4.66187H0.870953C0.389014 4.66187 0 5.06768 0 5.55705V12.4439C0 12.9333 0.389014 13.3391 0.870953 13.3391H3.9425L10.074 17.8329Z" fill="white"/>
                                    <path d="M17.7441 6.64898C17.4038 6.2993 16.8527 6.2993 16.5125 6.64898L15.4547 7.73608L14.3969 6.64898C14.0567 6.2993 13.5055 6.2993 13.1653 6.64898C12.8251 6.99866 12.8251 7.56543 13.1653 7.91481L14.2231 9.00187L13.1653 10.0889C12.8251 10.4386 12.8251 11.0051 13.1653 11.3548C13.3354 11.5296 13.5583 11.617 13.7811 11.617C14.004 11.617 14.2268 11.5296 14.3969 11.3548L15.4547 10.2677L16.5125 11.3548C16.6826 11.5296 16.9054 11.617 17.1283 11.617C17.3511 11.617 17.574 11.5296 17.7441 11.3548C18.0843 11.0051 18.0843 10.4386 17.7441 10.0889L16.6863 9.00187L17.7441 7.91481C18.0843 7.56543 18.0843 6.99866 17.7441 6.64898Z" fill="white"/>
                                    </g>
                                </svg>
                            </a>
                        </div>
                        <img src="/upload/iblock/b73/9m72dt0xt6yamtpqdkb110ib6r8ygaza.png">
                    </div>
                    <div class="main-banner-text">
                        <div class="main-banner-semi-title">
                            NEW
                        </div>
                        <div class="main-banner-title">
                            Horizon Collection
                        </div>
                        <a href="#" class="main-banner-link">
                            Перейти
                            <span class="icon">
                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                */?>
            <?/*
                <div class="main-banner-slider-item">
                    <div class="main-banner-img">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/mainbanner.png">
                    </div>
                    <div class="main-banner-text">
                        <div class="main-banner-semi-title">
                            NEW
                        </div>
                        <div class="main-banner-title">
                            Horizon Collection
                        </div>
                        <a href="#" class="main-banner-link">
                            Перейти
                            <span class="icon">
                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="main-banner-slider-item">
                    <div class="main-banner-img">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/mainbanner.png">
                    </div>
                    <div class="main-banner-text">
                        <div class="main-banner-semi-title">
                            NEW
                        </div>
                        <div class="main-banner-title">
                            Horizon Collection
                        </div>
                        <a href="#" class="main-banner-link">
                            Перейти
                            <span class="icon">
                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                */?>
        </div>
    </div>

    <div class="list-section">
        <div class="wrapper">
            <div class="list-section-block">
                <div class="list-section-title-block">
                    <div class="list-section-title">
                        Новинки
                    </div>
                    <div class="list-section-title-btn">
                        <a href="<?=$ru?>/catalog/novinki/" class="list-section-btn">
                            Перейти
                            <span class="icon">
                                    <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                        </g>
                                    </svg>
                                </span>
                        </a>
                    </div>
                </div>
                <div class="list-section-elements">
                    <?
                    global $MAX_SMART_FILTER;
                    $MAX_SMART_FILTER['!PROPERTY_IN_BLOCK']=false;
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
                                    48 => 'PROP_25',49 => 'PROP_2114',
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
                            'FILTER_NAME' => 'MAX_SMART_FILTER',
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
                            'DETAIL_URL' => '/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/','USE_MAIN_ELEMENT_SECTION' => 'Y',
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
                    $params['SECTION_ID'] = '350';
                    $params['ONLY_SECOND'] = true;
                    $params['PAGE_ELEMENT_COUNT'] = 8;
                    $params['BLOCK_CLASS']= 'goods-slider-item';
                    $params['WRAP_CLASS']= 'goods-slider';

                    $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section",
                            "main",
                            $params,
                            false
                    );

                    ?>
                    <?/*
                        <div class="goods-slider">
                            <div class="goods-slider-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg1.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#">
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
                            <div class="goods-slider-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg2.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#">
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
                            <div class="goods-slider-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg3.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#">
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
                            <div class="goods-slider-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg4.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#">
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
                                                </div></div>
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
                            <div class="goods-slider-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg1.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#">
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
                            <div class="goods-slider-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg2.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#">
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
                                                    <input type="radio" name="radio6">
                                                    <span class="catalog-item-size">
                                                        XS
                                                    </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio6">
                                                    <span class="catalog-item-size">
                                                        S
                                                    </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio6">
                                                    <span class="catalog-item-size">
                                                        M
                                                    </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio6">
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
                            <div class="goods-slider-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg3.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#">
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
                                                    <input type="radio" name="radio7">
                                                    <span class="catalog-item-size">
                                                        XS
                                                    </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio7">
                                                    <span class="catalog-item-size">
                                                        S
                                                    </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio7">
                                                    <span class="catalog-item-size">
                                                        M
                                                    </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio7">
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
                            </div><div class="goods-slider-item">
                                <div class="catalog-item">
                                    <div class="catalog-item-top">
                                        <div class="catalog-item-img">
                                            <a href="#">
                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg4.png">
                                            </a>
                                        </div>
                                        <div class="catalog-item-favorite">
                                            <a href="#">
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
                                                    <input type="radio" name="radio8">
                                                    <span class="catalog-item-size">
                                                        XS
                                                    </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio8">
                                                    <span class="catalog-item-size">
                                                        S
                                                    </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio8">
                                                    <span class="catalog-item-size">
                                                        M
                                                    </span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio8">
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
                        </div>
                        */?>
                </div>

            </div>
        </div>
    </div>
    <?
    $res=CIBlockSection::GetList(array("sort"=>"asc"),array("IBLOCK_ID"=>21,"ACTIVE"=>"Y",'!UF_POPULAR'=>false),false,array("ID","NAME",'IBLOCK_ID','UF_*','SECTION_PAGE_URL','PICTURE'));

    ?>
    <div class="list-section">
        <div class="wrapper">
            <div class="list-section-block">
                <div class="list-section-title-block">
                    <div class="list-section-title">
                        Каталог
                    </div>
                    <div class="list-section-title-btn">
                        <a href="<?=$ru?>/catalog/zhenskaya_odezhda/" class="list-section-btn">
                            Перейти
                            <span class="icon">
                                    <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                        </g>
                                    </svg>
                                </span>
                        </a>
                    </div>
                </div>
                <div class="list-section-elements">
                    <div class="category-list-cont">
                        <?
                        while ($record = $res->GetNext())
                        {
                            $img=CFile::GetFileArray($record["PICTURE"])['SRC'];
                            ?>
                            <div class="category-list-block">
                                <a href="<?=$ru?><?=$record['SECTION_PAGE_URL']?>" class="category-list-item">
                                    <div class="category-list-img">
                                        <img src="<?=$img?>?v=1">
                                    </div>
                                    <div class="category-list-name">
                                        <?=LANGUAGE_ID=='ua'?$record['UF_NAME_UA']:$record['NAME']?>
                                    </div>
                                </a>
                            </div>
                            <?
                        }
                        ?>
                        <?/*
                        <div class="category-list-block">
                            <a href="<?=$ru?>/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/" class="category-list-item">
                                <div class="category-list-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/categimg1.png?v=1">
                                </div>
                                <div class="category-list-name">
                                    Верхній одяг
                                </div>
                            </a>
                        </div>
                        <div class="category-list-block">
                            <a href="<?=$ru?>/catalog/zhenskaya_odezhda/trikotazh/dzhempery/" class="category-list-item">
                                <div class="category-list-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/categimg2.png?v=1">
                                </div>
                                <div class="category-list-name">
                                    <?=LANGUAGE_ID=='ua'?'Светри':'Кофты'?>
                                </div>
                            </a>
                        </div>
                        <div class="category-list-block">
                            <a href="<?=$ru?>/catalog/zhenskaya_odezhda/bluzy_i_rubashki/" class="category-list-item">
                                <div class="category-list-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/categimg3.png?v=1">
                                </div>
                                <div class="category-list-name">
                                    Блузи та сорочки
                                </div>
                            </a>
                        </div>
                        <div class="category-list-block">
                            <a href="<?=$ru?>/catalog/zhenskaya_odezhda/topy1/topy/" class="category-list-item">
                                <div class="category-list-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/categimg4.png?v=1">
                                </div>
                                <div class="category-list-name">
                                    <?=LANGUAGE_ID=='ua'?'Топи':'Топы'?>
                                </div>
                            </a>
                        </div>
                        */?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="sss-info-sec">
        <div class="sss-info-block">
            <div class="sss-info-top">
                <div class="sss-info-img">
                    <img src="/bitrix/templates/stimma/images/sss-info-img1.png">
                </div>
                <div class="sss-info-text-block">
                    <div class="sss-info-title">
                        <?//=$item['NAME']?>
                        Сама себе STIMMA - выгодно быть собой
                    </div>
                    <div class="sss-info-text">
                        <?//=$item['PREVIEW_TEXT']?>
                        Накапливай стимзы и обменивай их на эксклюзивные подарки.
                        <br> Также получай скидки, доступ к эксклюзивным акциям, коллекциям, коллаборациям и приглашениям на закрытые фэшн-ивенты.
                    </div>
                    <div class="sss-info-text-btn">
                        <?
                        $link = "/auth/registration/?register=yes&backurl=/";
                        if ($USER->IsAuthorized())
                            $link = "/personal/loyalty/";
                        ?>
                        <a href="<?=$link?>" class="info-btn info-btn-black">
                            <?=LANGUAGE_ID=='ua'?'Круто,  я з вами!':'Круто, я с вами!'?>
                        </a>
                        <a href="<?=$ru?>/sama_sobi/" class="info-btn">
                            <?=LANGUAGE_ID=='ua'?'Хочу  дізнатися':'Хочу  узнать'?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="sss-info-bottom">
                <div class="sss-info-badge">
                    <div class="sss-info-icon">
                        <svg width="62" height="63" viewBox="0 0 62 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_168_12493)">
                                <path d="M61.4648 35.5399L49.8398 29.6337C49.7049 29.5672 49.5567 29.5335 49.4068 29.5352H31.9693C31.819 29.5351 31.6708 29.5705 31.5363 29.6386L19.9113 35.5448C19.7974 35.6026 19.6958 35.6826 19.6123 35.7802C19.5289 35.8779 19.4652 35.9913 19.4249 36.114C19.3845 36.2366 19.3684 36.3662 19.3774 36.4952C19.3864 36.6242 19.4203 36.7502 19.4773 36.8659L23.3523 44.7409C23.4608 44.9619 23.6472 45.1334 23.8744 45.2213C24.1016 45.3091 24.353 45.307 24.5787 45.2153L28.0943 43.786V62.0196C28.0943 62.2807 28.1964 62.531 28.378 62.7156C28.5597 62.9003 28.8061 63.004 29.063 63.004H46.5005C46.7575 63.004 47.0039 62.9003 47.1856 62.7156C47.3672 62.531 47.4693 62.2807 47.4693 62.0196C47.4693 61.7585 47.3672 61.5081 47.1856 61.3235C47.0039 61.1389 46.7575 61.0352 46.5005 61.0352H30.0318V42.3321C30.0318 42.1712 29.9931 42.0128 29.919 41.8707C29.8448 41.7285 29.7375 41.6071 29.6065 41.5168C29.4754 41.4266 29.3246 41.3704 29.1672 41.3531C29.0098 41.3358 28.8506 41.3579 28.7036 41.4176L24.6872 43.0507L21.6444 36.8659L32.1979 31.504H35.8443V33.4727C35.8443 34.7781 36.3546 36.03 37.263 36.953C38.1714 37.876 39.4034 38.3946 40.688 38.3946C41.9727 38.3946 43.2047 37.876 44.1131 36.953C45.0215 36.03 45.5318 34.7781 45.5318 33.4727C45.5318 33.2116 45.4297 32.9613 45.2481 32.7767C45.0664 32.5921 44.82 32.4883 44.563 32.4883C44.3061 32.4883 44.0597 32.5921 43.878 32.7767C43.6964 32.9613 43.5943 33.2116 43.5943 33.4727C43.5943 34.2559 43.2881 35.0071 42.7431 35.5609C42.198 36.1147 41.4588 36.4258 40.688 36.4258C39.9173 36.4258 39.178 36.1147 38.633 35.5609C38.088 35.0071 37.7818 34.2559 37.7818 33.4727V31.504H49.1782L59.7317 36.8659L56.6889 43.0507L52.6724 41.4176C52.5254 41.3579 52.3663 41.3358 52.2089 41.3531C52.0515 41.3704 51.9007 41.4266 51.7696 41.5168C51.6386 41.6071 51.5313 41.7285 51.4571 41.8707C51.383 42.0128 51.3442 42.1712 51.3443 42.3321V61.0352H49.4068C49.1499 61.0352 48.9035 61.1389 48.7218 61.3235C48.5401 61.5081 48.438 61.7585 48.438 62.0196C48.438 62.2807 48.5401 62.531 48.7218 62.7156C48.9035 62.9003 49.1499 63.004 49.4068 63.004H52.313C52.57 63.004 52.8164 62.9003 52.9981 62.7156C53.1797 62.531 53.2818 62.2807 53.2818 62.0196V43.786L56.7974 45.2153C57.023 45.3067 57.2742 45.3087 57.5011 45.2208C57.7281 45.133 57.9143 44.9616 58.0229 44.7409L61.8979 36.8659C61.9556 36.75 61.9901 36.6237 61.9996 36.4942C62.0091 36.3647 61.9932 36.2345 61.953 36.1113C61.9127 35.988 61.8489 35.8741 61.7651 35.776C61.6813 35.678 61.5793 35.5977 61.4648 35.5399Z" fill="#FFF7E7"/>
                                <path d="M45.5313 47.2539C44.9564 47.2539 44.3946 47.0807 43.9166 46.7562C43.4387 46.4317 43.0662 45.9705 42.8462 45.4309C42.6263 44.8913 42.5687 44.2975 42.6808 43.7247C42.793 43.1518 43.0698 42.6256 43.4762 42.2126C43.8827 41.7996 44.4005 41.5183 44.9643 41.4044C45.528 41.2905 46.1124 41.3489 46.6434 41.5725C47.1745 41.796 47.6284 42.1745 47.9477 42.6601C48.2671 43.1458 48.4375 43.7167 48.4375 44.3008C48.4375 45.084 48.1313 45.8351 47.5863 46.389C47.0413 46.9428 46.302 47.2539 45.5313 47.2539ZM45.5313 43.3164C45.3397 43.3164 45.1524 43.3741 44.993 43.4823C44.8337 43.5905 44.7096 43.7442 44.6362 43.9241C44.5629 44.104 44.5437 44.3019 44.5811 44.4928C44.6185 44.6838 44.7108 44.8592 44.8462 44.9968C44.9817 45.1345 45.1543 45.2283 45.3423 45.2662C45.5302 45.3042 45.725 45.2847 45.902 45.2102C46.079 45.1357 46.2303 45.0096 46.3367 44.8477C46.4432 44.6858 46.5 44.4955 46.5 44.3008C46.5 44.0397 46.3979 43.7893 46.2163 43.6047C46.0346 43.4201 45.7882 43.3164 45.5313 43.3164Z" fill="#FFF7E7"/>
                                <path d="M12.529 45.4705C12.2895 45.3759 12.0968 45.1886 11.9932 44.9497C11.8897 44.7108 11.8838 44.4398 11.9768 44.1965L12.3276 43.2789L11.4246 42.9224C9.27081 42.0695 7.53798 40.3832 6.60625 38.2336C5.67453 36.084 5.62001 33.6466 6.45466 31.4562L6.80546 30.5387C6.89849 30.2953 7.08286 30.0995 7.31799 29.9942C7.55312 29.889 7.81976 29.883 8.05926 29.9775C8.29875 30.0721 8.49147 30.2594 8.59503 30.4983C8.69859 30.7373 8.70451 31.0082 8.61147 31.2516L8.26068 32.1691C7.61156 33.8728 7.65399 35.7685 8.37866 37.4404C9.10333 39.1123 10.4511 40.4238 12.1262 41.0873L13.9322 41.8002C14.1159 41.8728 14.2735 42.0007 14.3839 42.1667C14.4942 42.3327 14.5521 42.529 14.5497 42.7293L16.6181 41.8044L15.7066 39.7032C15.5753 39.8526 15.4022 39.9577 15.2105 40.0045C15.0188 40.0513 14.8176 40.0375 14.6338 39.9651L12.8278 39.2522C11.6313 38.7782 10.6687 37.8414 10.1511 36.6472C9.63346 35.453 9.60311 34.0989 10.0667 32.882C10.1597 32.6387 10.3441 32.4429 10.5792 32.3376C10.8144 32.2324 11.081 32.2264 11.3205 32.3209C11.56 32.4155 11.7527 32.6028 11.8563 32.8417C11.9598 33.0806 11.9657 33.3516 11.8727 33.5949C11.5936 34.325 11.6113 35.1378 11.922 35.8546C12.2327 36.5714 12.8109 37.1334 13.5293 37.417L14.4323 37.7735L14.7831 36.8559C14.8525 36.6745 14.9733 36.518 15.1302 36.4063C15.2871 36.2946 15.4731 36.2327 15.6646 36.2284C15.8562 36.2241 16.0446 36.2776 16.2062 36.3821C16.3679 36.4866 16.4953 36.6375 16.5726 36.8156L18.7814 41.9117C18.8849 42.1506 18.8908 42.4215 18.7978 42.6648C18.7048 42.9081 18.5205 43.1039 18.2854 43.2092L13.2702 45.4536C13.0351 45.5589 12.7685 45.565 12.529 45.4705Z" fill="#FFF7E7"/>
                                <path d="M44.0784 26.2227C43.8215 26.2226 43.5751 26.1189 43.3935 25.9342L39.5185 21.9967C39.383 21.8591 39.2908 21.6837 39.2534 21.4928C39.2161 21.3018 39.2352 21.104 39.3086 20.9241C39.3819 20.7443 39.506 20.5905 39.6653 20.4824C39.8245 20.3742 40.0118 20.3164 40.2034 20.3164H41.1721V19.332C41.1721 18.5488 40.8659 17.7977 40.3209 17.2439C39.7759 16.69 39.0367 16.3789 38.2659 16.3789C38.0089 16.3789 37.7625 16.2752 37.5809 16.0906C37.3992 15.906 37.2971 15.6556 37.2971 15.3945C37.2971 15.1335 37.3992 14.8831 37.5809 14.6985C37.7625 14.5139 38.0089 14.4102 38.2659 14.4102C39.55 14.4117 40.7812 14.9308 41.6892 15.8535C42.5973 16.7762 43.1081 18.0271 43.1096 19.332V21.3008C43.1095 21.5011 43.0493 21.6967 42.937 21.8613C42.8246 22.0259 42.6655 22.1518 42.4809 22.2222L44.0784 23.8464L45.6758 22.2222C45.4912 22.1518 45.3321 22.0259 45.2198 21.8613C45.1074 21.6967 45.0472 21.5011 45.0471 21.3008V19.332C45.0451 17.5052 44.33 15.7537 43.0587 14.4619C41.7874 13.1701 40.0637 12.4435 38.2659 12.4414H37.2971C37.0402 12.4414 36.7938 12.3377 36.6121 12.1531C36.4304 11.9685 36.3284 11.7181 36.3284 11.457C36.3284 11.196 36.4304 10.9456 36.6121 10.761C36.7938 10.5764 37.0402 10.4727 37.2971 10.4727H38.2659C40.5774 10.4753 42.7936 11.4095 44.4281 13.0704C46.0627 14.7313 46.9821 16.9832 46.9846 19.332V20.3164H47.9534C48.1449 20.3164 48.3322 20.3742 48.4915 20.4824C48.6507 20.5905 48.7749 20.7443 48.8482 20.9241C48.9215 21.104 48.9407 21.3018 48.9033 21.4928C48.8659 21.6837 48.7737 21.8591 48.6383 21.9967L44.7633 25.9342C44.5816 26.1189 44.3353 26.2226 44.0784 26.2227Z" fill="#FFF7E7"/>
                                <path d="M21.6025 4.38281C27.606 4.38281 32.5 9.33303 32.5 15.4727C32.4997 21.6121 27.6059 26.5615 21.6025 26.5615C15.5992 26.5615 10.7053 21.6121 10.7051 15.4727C10.7051 9.33303 15.5991 4.38281 21.6025 4.38281Z" stroke="#FFF7E7" stroke-width="2"/>
                                <path d="M26.3835 17.197C26.3835 17.6612 26.2982 18.0708 26.1308 18.4153C25.9649 18.7552 25.7412 19.0459 25.4635 19.2812C25.1951 19.5085 24.8822 19.6931 24.5325 19.8285C24.2031 19.9561 23.8526 20.0559 23.492 20.1256C23.1368 20.1937 22.773 20.2389 22.4116 20.2595C22.0588 20.2809 21.7185 20.2912 21.3993 20.2912C20.5606 20.2912 19.7712 20.2199 19.0539 20.0797C18.3396 19.9394 17.6973 19.7628 17.1458 19.5529L16.8782 19.4507V16.4571L17.4908 16.8017C18.0055 17.0901 18.6024 17.3206 19.2659 17.4846C19.934 17.6501 20.66 17.7341 21.4235 17.7341C21.8718 17.7341 22.2379 17.7103 22.5117 17.6644C22.8356 17.6089 23.014 17.5456 23.1063 17.502C23.2432 17.4378 23.2769 17.3935 23.2776 17.3935C23.2902 17.3737 23.2964 17.3602 23.2988 17.3531C23.2956 17.3515 23.287 17.342 23.2714 17.3293C23.2143 17.2818 23.104 17.2105 22.9013 17.1376C22.7112 17.0687 22.482 17.0037 22.2223 16.9443C21.9492 16.8825 21.6582 16.8199 21.3515 16.7582C21.0386 16.6948 20.7171 16.6259 20.3862 16.553C20.0458 16.4769 19.7118 16.3866 19.3918 16.2845C19.0664 16.1807 18.7527 16.0571 18.4608 15.9177C18.1526 15.7703 17.8764 15.5921 17.641 15.3885C17.393 15.1731 17.1943 14.9196 17.0495 14.6352C16.9001 14.3397 16.8242 13.9983 16.8242 13.6204C16.8242 13.1895 16.9032 12.8069 17.0581 12.4837C17.2107 12.1645 17.4204 11.8888 17.6809 11.6638C17.932 11.4468 18.2246 11.2693 18.5508 11.1354C18.8583 11.0087 19.1868 10.9089 19.5272 10.8392C19.8596 10.7711 20.2007 10.7235 20.5403 10.6982C20.8743 10.6728 21.1959 10.6602 21.4955 10.6602C21.8264 10.6602 22.1722 10.6776 22.5227 10.7109C22.8693 10.7441 23.2174 10.7917 23.5554 10.8526C23.8894 10.9121 24.2188 10.9826 24.5356 11.0618C24.8485 11.141 25.1435 11.225 25.4126 11.3129L25.6982 11.4064V14.3128L25.1051 14.0205C24.9628 13.95 24.7664 13.8668 24.5223 13.7741C24.2806 13.6822 24.0005 13.5935 23.6907 13.5103C23.3817 13.4272 23.0406 13.3566 22.6768 13.3004C22.3177 13.245 21.9445 13.2172 21.5675 13.2172C21.2616 13.2172 20.9979 13.2267 20.7844 13.2457C20.5747 13.2648 20.3987 13.2893 20.261 13.3178C20.1084 13.3495 20.0271 13.3804 19.9856 13.3994C19.9723 13.4058 19.9613 13.4113 19.9512 13.4169C20.0153 13.4596 20.1225 13.5159 20.2938 13.5745C20.4879 13.6402 20.7179 13.7044 20.9792 13.7638C21.2545 13.8264 21.5463 13.8906 21.8546 13.9571C22.1683 14.0244 22.4914 14.0981 22.8247 14.1781C23.1665 14.2597 23.5022 14.3563 23.8221 14.4657C24.1499 14.5766 24.4644 14.7081 24.7554 14.8554C25.0621 15.0107 25.3367 15.196 25.5714 15.406C25.8186 15.6278 26.0166 15.8868 26.1597 16.1767C26.3084 16.4777 26.3835 16.8207 26.3835 17.197Z" fill="#FFF7E7"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_168_12493">
                                    <rect width="62" height="63" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <div class="sss-info-badge-block">
                        <div class="sss-info-badge-title">
                            Шкаф для своих
                        </div>
                        <div class="sss-info-badge-text">
                            где можно обменять накопленные стимзы
                        </div>
                    </div>
                </div>
                <div class="sss-info-badge">
                    <div class="sss-info-icon">
                        <svg width="55" height="56" viewBox="0 0 55 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M52.4219 23.5398C52.9375 23.5398 53.2812 23.1898 53.2812 22.6648V13.4773C53.2812 11.9023 51.9922 10.5898 50.5312 10.5898H4.46875C2.92187 10.5898 1.71875 11.9023 1.71875 13.4773V22.6648C1.71875 23.1898 2.0625 23.5398 2.57812 23.5398C4.98438 23.5398 6.875 25.5523 6.875 28.0023C6.875 30.4523 4.89844 32.4648 2.57812 32.4648C2.0625 32.4648 1.71875 32.8148 1.71875 33.3398V42.5273C1.71875 44.1023 3.00781 45.4148 4.46875 45.4148H50.4453C51.9922 45.4148 53.1953 44.1023 53.1953 42.5273V33.3398C53.1953 32.8148 52.8516 32.4648 52.3359 32.4648C49.9297 32.4648 48.0391 30.4523 48.0391 28.0023C48.125 25.5523 50.0156 23.5398 52.4219 23.5398ZM46.4062 28.0023C46.4062 31.1523 48.6406 33.6898 51.5625 34.1273V42.5273C51.5625 43.1398 51.0469 43.6648 50.5312 43.6648H42.7969V42.3523C42.7969 41.8273 42.4531 41.4773 41.9375 41.4773C41.4219 41.4773 41.0781 41.8273 41.0781 42.3523V43.6648H4.46875C3.86719 43.6648 3.4375 43.1398 3.4375 42.5273V34.1273C6.35938 33.6898 8.59375 31.0648 8.59375 28.0023C8.59375 24.8523 6.35938 22.3148 3.4375 21.8773V13.4773C3.4375 12.8648 3.95312 12.3398 4.46875 12.3398H40.9922V13.6523C40.9922 14.1773 41.3359 14.5273 41.8516 14.5273C42.3672 14.5273 42.7109 14.1773 42.7109 13.6523V12.3398H50.4453C51.0469 12.3398 51.4766 12.8648 51.4766 13.4773V21.8773C48.6406 22.3148 46.4062 24.8523 46.4062 28.0023Z" fill="#FFF7E7" stroke="#FFF7E7"/>
                            <path d="M41.9375 33.2539C41.4219 33.2539 41.0781 33.6039 41.0781 34.1289V38.2414C41.0781 38.7664 41.4219 39.1164 41.9375 39.1164C42.4531 39.1164 42.7969 38.7664 42.7969 38.2414V34.1289C42.7969 33.6914 42.3672 33.2539 41.9375 33.2539Z" fill="#FFF7E7" stroke="#FFF7E7"/>
                            <path d="M41.9375 16.8906C41.4219 16.8906 41.0781 17.2406 41.0781 17.7656V21.8781C41.0781 22.4031 41.4219 22.7531 41.9375 22.7531C42.4531 22.7531 42.7969 22.4031 42.7969 21.8781V17.7656C42.7969 17.2406 42.3672 16.8906 41.9375 16.8906Z" fill="#FFF7E7" stroke="#FFF7E7"/>
                            <path d="M41.9375 25.1133C41.4219 25.1133 41.0781 25.4633 41.0781 25.9883V30.1008C41.0781 30.6258 41.4219 30.9758 41.9375 30.9758C42.4531 30.9758 42.7969 30.6258 42.7969 30.1008V25.9883C42.7969 25.4633 42.3672 25.1133 41.9375 25.1133Z" fill="#FFF7E7" stroke="#FFF7E7"/>
                            <path d="M32.9995 24.5891L28.4448 23.8891L26.3823 19.6891C26.1245 19.0766 25.5229 18.7266 24.8354 18.7266C24.1479 18.7266 23.5463 19.0766 23.2885 19.6891L21.226 23.8891L16.6713 24.5891C15.9838 24.6766 15.4682 25.1141 15.2963 25.8141C15.1245 26.4266 15.2963 27.1266 15.726 27.6516L18.9916 30.8891L18.2182 35.5266C18.1323 36.2266 18.3901 36.8391 18.9057 37.2766C19.2495 37.5391 19.5932 37.6266 19.937 37.6266C20.1948 37.6266 20.4526 37.5391 20.7104 37.4516L24.7495 35.2641L28.7885 37.4516C29.3901 37.8016 30.0776 37.7141 30.5932 37.2766C31.1088 36.8391 31.3666 36.2266 31.2807 35.5266L30.5073 30.8891L33.7729 27.6516C34.2885 27.2141 34.4604 26.5141 34.2026 25.8141C34.2026 25.2016 33.601 24.6766 32.9995 24.5891ZM29.1323 29.9266C28.9604 30.1016 28.8745 30.4516 28.8745 30.7141L29.6479 35.7891L25.1791 33.4266C25.0932 33.3391 24.9213 33.3391 24.7495 33.3391C24.5776 33.3391 24.4916 33.3391 24.3198 33.4266L19.851 35.7891L20.7104 30.7141C20.7963 30.4516 20.6245 30.1016 20.4526 29.9266L16.8432 26.3391L21.8276 25.6391C22.0854 25.6391 22.3432 25.3766 22.5151 25.2016L24.7495 20.5641L26.9838 25.1141C27.0698 25.3766 27.3276 25.5516 27.6713 25.5516L32.6557 26.3391L29.1323 29.9266Z" fill="#FFF7E7" stroke="#FFF7E7"/>
                        </svg>
                    </div>
                    <div class="sss-info-badge-block">
                        <div class="sss-info-badge-title">
                            Уникальный доступ
                        </div>
                        <div class="sss-info-badge-text">
                            к эксклюзивным акциям <br> и коллекциям
                        </div>
                    </div>
                </div>
                <div class="sss-info-badge">
                    <div class="sss-info-icon">
                        <svg width="53" height="53" viewBox="0 0 53 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_168_12503)">
                                <path d="M25.5391 12.8047C25.7928 12.0436 26.616 11.6322 27.377 11.8857C28.1381 12.1395 28.5495 12.9625 28.2959 13.7236L20.9766 35.6826C20.7737 36.2911 20.2068 36.6757 19.5986 36.6758C19.4465 36.6758 19.2911 36.6523 19.1387 36.6016C18.3775 36.3478 17.9661 35.5248 18.2197 34.7637L25.5391 12.8047Z" fill="#FFF7E7" stroke="#FE9D56" stroke-width="0.2"/>
                                <path d="M32.041 19.6855C34.5543 19.6855 36.5996 21.7308 36.5996 24.2441C36.5996 26.7574 34.5543 28.8027 32.041 28.8027C29.5277 28.8027 27.4824 26.7574 27.4824 24.2441C27.4824 21.7308 29.5277 19.6855 32.041 19.6855ZM32.041 22.5918C31.1296 22.5918 30.3887 23.3327 30.3887 24.2441C30.3887 25.1555 31.1296 25.8965 32.041 25.8965C32.9524 25.8965 33.6934 25.1555 33.6934 24.2441C33.6934 23.3327 32.9524 22.5918 32.041 22.5918Z" fill="#FFF7E7" stroke="#FE9D56" stroke-width="0.2"/>
                                <path d="M14.4746 19.6855C16.988 19.6855 19.0332 21.7308 19.0332 24.2441C19.0332 26.7574 16.9879 28.8027 14.4746 28.8027C11.9613 28.8027 9.91602 26.7574 9.91602 24.2441C9.91602 21.7308 11.9613 19.6855 14.4746 19.6855ZM14.4746 22.5918C13.5632 22.5918 12.8223 23.3327 12.8223 24.2441C12.8223 25.1555 13.5632 25.8965 14.4746 25.8965C15.3861 25.8965 16.127 25.1555 16.127 24.2441C16.127 23.3327 15.386 22.5918 14.4746 22.5918Z" fill="#FFF7E7" stroke="#FE9D56" stroke-width="0.2"/>
                                <path d="M36.6025 3.10059L22.5117 5.11328L22.4785 5.11816L3.79004 23.8066C2.74192 24.8548 2.74192 26.5603 3.79004 27.6084L19.8936 43.7119C20.4011 44.2192 21.0763 44.499 21.7939 44.499C22.5116 44.499 23.1868 44.2193 23.6943 43.7119L42.3594 25.0469L42.3828 25.0225L42.3877 24.9902L44.4004 10.8994L44.4082 10.8496L41.6279 8.06934L41.5566 7.99902L39.2197 10.3359L39.29 10.4072L40.3887 11.5049C40.9559 12.0722 40.9559 12.9924 40.3887 13.5596C40.1051 13.8432 39.7331 13.9853 39.3613 13.9854C38.9895 13.9854 38.6177 13.8432 38.334 13.5596L33.9424 9.16797C33.375 8.60062 33.3751 7.68051 33.9424 7.11328C34.5097 6.5461 35.4299 6.54607 35.9971 7.11328L37.0947 8.21094L37.165 8.28223L39.5029 5.94434L39.4316 5.87402L36.6514 3.09375L36.6025 3.10059ZM18.9395 46.6211L18.8916 46.5918C18.5166 46.3643 18.1624 46.0892 17.8389 45.7656L1.73535 29.6631C-0.44536 27.4825 -0.445108 23.9337 1.73535 21.7529L20.7666 2.72168C20.9889 2.4994 21.2777 2.355 21.5889 2.31055L36.96 0.114258C37.4127 0.0502097 37.8692 0.202214 38.1924 0.525391L41.4863 3.81934L41.5576 3.88965L44.9219 0.525391C45.4892 -0.0417109 46.4094 -0.0417953 46.9766 0.525391C47.5436 1.09271 47.5437 2.01291 46.9766 2.58008L43.6826 5.87402L43.6113 5.94434L43.6826 6.01562L46.9766 9.30859C47.2999 9.63186 47.4513 10.0893 47.3867 10.542L47.1758 12.0205L47.1699 12.0615L47.1953 12.0947L52.6094 19.3135C52.7979 19.5649 52.9004 19.8713 52.9004 20.1855V47.3066C52.9004 50.3907 50.3907 52.9004 47.3066 52.9004H24.5332C21.4491 52.9004 18.9395 50.3907 18.9395 47.3066V46.6211ZM49.9941 20.6699L49.9746 20.6436L46.7334 16.3223L46.5889 16.1289L46.5547 16.3682L45.1914 25.9131C45.147 26.2241 45.0024 26.5121 44.7803 26.7344L25.749 45.7656C24.6985 46.8162 23.3302 47.3592 21.9502 47.3975L21.8457 47.4004L21.8535 47.5049C21.9556 48.8947 23.1177 49.9941 24.5332 49.9941H47.3066C48.7888 49.9941 49.9941 48.7888 49.9941 47.3066V20.6699Z" fill="#FFF7E7" stroke="#FE9D56" stroke-width="0.2"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_168_12503">
                                    <rect width="53" height="53" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <div class="sss-info-badge-block">
                        <div class="sss-info-badge-title">
                            Персональные скидки
                        </div>
                        <div class="sss-info-badge-text">
                            на вещи и услуги стилиста
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <div class="base-container">
            <div class="base-content-block">
                <div class="base-bg-img">
                    <svg width="1773" height="924" viewBox="0 0 1773 924" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1688.07 891.979C1634.88 912.288 1565.25 922.314 1483.98 922.031C1321.45 921.463 1112.54 879.658 895.813 796.72C765.108 746.706 646.539 687.438 546.351 624.551L543.417 622.71L544.917 625.831C557.21 651.409 560.123 676.1 551.799 697.837L551.798 697.837C537.883 734.192 494.95 755.793 436.218 760.989C377.56 766.18 303.494 754.956 227.954 726.044C152.415 697.132 89.7868 656.032 49.5889 613.001C9.3402 569.915 -8.19536 525.166 5.71966 488.81C19.6348 452.455 62.5687 430.854 121.301 425.657C179.958 420.467254.022 431.691 329.56 460.602L329.559 460.602C331.384 461.311 332.934 461.908 334.756 462.615L335.827 460.978C288.292 413.167 253.658 366.013 234.386 321.762C215.417 278.207 211.357 237.535 224.427 201.799L225.062 200.101C240.643 159.405 277.304 128.86 330.5 108.551C383.696 88.2418 453.319 78.2149 534.591 78.4987C697.126 79.0663 906.033 120.871 1122.76 203.809C1159.79 217.975 1195.8 232.872 1230.73 248.396L1231.85 246.775C1175.75 190.565 1150.07 131.127 1167.73 83.0133L1168.15 81.8784C1185.59 36.311 1239.2 9.2191 1312.33 2.59666C1385.39 -4.0191 1477.59 9.84676 1571.59 45.8189C1665.6 81.791 1743.5 133.017 1793.48 186.717C1843.5 240.471 1865.33 296.433 1847.89 342.021C1832.62 381.911 1789.67 407.642 1730.12 417.88C1670.6 428.112 1594.76 422.816 1514.19 400.89L1513.37 402.685C1616.6 472.082 1696.95 544.786 1746.32 613.547C1795.71 682.326 1813.97 746.948 1793.55 800.345L1793.54 800.362L1793.52 800.395L1793.51 800.429C1777.93 841.125 1741.27 871.67 1688.07 891.979Z" stroke="#FE9D56" stroke-width="2"/>
                    </svg>
                    <svg class="svg-tables" width="768" height="826" viewBox="0 0 768 826" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M693.979 797.192C646.447 815.338 584.229 824.3 511.592 824.046C366.326 823.539 179.609 786.176 -14.1028 712.046L-14.1031 712.045C-130.928 667.342 -236.904 614.368 -326.45 558.161L-329.383 556.32L-327.883 559.441C-316.903 582.286 -314.309 604.325 -321.736 623.719C-334.151 656.157 -372.471 675.457 -424.957 680.101C-477.369 684.738 -543.557 674.709 -611.066 648.871C-678.575 623.033 -734.54 586.304 -770.457 547.854C-806.426 509.351 -822.064 469.395 -809.648 436.957C-797.233 404.52 -758.913 385.221 -706.427 380.577C-654.016 375.939 -587.829 385.967 -520.322 411.804L-520.323 411.805C-518.805 412.394 -517.193 413.017 -515.678 413.605L-514.606 411.967C-557.09 369.237 -588.039 327.1 -605.258 287.563C-622.206 248.648 -625.828 212.322 -614.158 180.413L-613.59 178.896C-599.677 142.558 -566.939 115.273 -519.406 97.1257C-471.874 78.9789 -409.655 70.017 -337.018 70.2707C-191.752 70.778 -5.03521 108.141 188.676 182.272L188.677 182.271C221.77 194.932 253.964 208.248 285.182 222.123L286.296 220.503C235.765 169.871 212.886 116.345 229.387 73.2238C244.956 32.5523 292.814 8.34358 358.17 2.42519C423.454 -3.48655 505.851 8.90341 589.865 41.0524C673.879 73.2015 743.499 118.982 788.156 166.967C832.864 215.006 852.334 264.986 836.771 305.675L836.77 305.674C823.142 341.279 784.797 364.265 731.581 373.415C678.405 382.558 610.627 377.826 538.624 358.231L537.802 360.025C630.07 422.052 701.873 487.03 745.997 548.478C790.134 609.945 806.435 667.667 788.196 715.347L788.192 715.354L788.177 715.387L788.163 715.421C774.25 751.759 741.512 779.045 693.979 797.192Z" stroke="#FE9D56" stroke-width="2"/>
                    </svg>
                </div>
                <div class="base-img-block">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/basebimg1.png">
                </div>
                <div class="base-info-cont">
                    <div class="base-info-img-block">
                        <div class="base-info-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/baseimg1.png">
                        </div>
                        <div class="base-info-img">
                            <img src="/bitrix/templates/stimma_new/images/imgnew/baseimg2.png">
                        </div>
                    </div>
                    <div class="base-info-text-block">
                        <div class="base-info-title">
                            STIMMA База
                        </div>
                        <div class="base-info-text">
                            Виберіть свій унікальний стиль — чи то єдиний шедевр, чи еклектичне поєднання з різних колекцій. Втілюйте своє бачення, поєднуючи ці скарби з нашого ретельно відібраного каталогу, де зручність поєднується з креативністю.
                        </div>
                    </div>
                    <div class="base-info-btn">
                        <a href="<?=$ru?>/catalog/zhenskaya_odezhda/filter/selection-is-basic/apply/" class="info-btn">
                            Перейти
                            <span class="icon">
                                <svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.84034 5.50003C6.84034 5.69717 6.75822 5.89429 6.59433 6.04459L1.43455 10.7743C1.10633 11.0752 0.574163 11.0752 0.24607 10.7743C-0.0820233 10.4736 -0.0820233 9.98587 0.24607 9.68498L4.81173 5.50003L0.246229 1.31506C-0.0818639 1.01419 -0.0818639 0.526517 0.246229 0.225789C0.574323 -0.0752306 1.10649 -0.0752306 1.43471 0.225789L6.59449 4.95547C6.75841 5.10584 6.84034 5.30296 6.84034 5.50003Z" fill="#1E1E1E"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    <?/*
        <div class="collection-cont">
            <div class="collection-wrapper">
                <div class="collection-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/collectionimg.png">
                </div>
                <div class="collection-text-block">
                    <div class="collection-title">
                        Sport Collection
                    </div>
                    <a href="#" class="collection-link">
                        Перейти
                        <span class="icon">
                            <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                </g>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        */?>

    <?/*
        <div class="look-container">
            <div class="look-content">
                <div class="look-bg-img">
                    <svg width="639" height="578" viewBox="0 0 639 578" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M563.96 232.822C600.932 206.336 627.136 174.054 636.228 134.909C642.196 109.206 636.136 87.6686 620.695 69.8758C605.232 52.0583 580.337 37.9703 548.602 27.2763C485.137 5.88961 394.523 -1.85585 298.018 1.10706C201.522 4.06966 99.1824 17.7367 12.2874 39.1426C-31.1598 49.8455 -70.7377 62.4811 -103.789 76.6763C-136.847 90.8745 -163.345 106.62 -180.66 123.528C-210.72 152.874 -222.019 188.215 -210.402 223.061C-198.774 257.941 -164.144 292.463 -102.029 320.02L-101.388 320.304L-101.981 320.94L-102.12 320.978C-176.456 340.612 -222.71 366.089 -251.394 393.832C-280.066 421.565 -291.214 451.594 -295.278 480.414C-297.28 494.609 -288.758 509.921 -271.457 524.142C-254.174 538.349 -228.225 551.38 -195.649 561C-130.504 580.238 -38.9481 585.807 62.5429 559.95C166.164 533.548 219.417 504.595 246.157 478.748C259.52 465.831 266.256 453.694 269.358 443.041C272.266 433.053 271.989 424.338 270.949 417.461L270.731 416.11C268.548 403.362 256.215 385.747 231.076 371.085C205.958 356.435 168.103 344.768 115.011 343.896L115.005 342.896C201.93 340.504 323.178 327.715 427.242 295.888C479.275 279.974 526.986 259.308 563.96 232.822Z" stroke="#FE9D56"/>
                    </svg>
                    <svg class="svg-tables" width="461"height="571" viewBox="0 0 461 571" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M714.591 5.46068C755.182 -2.75955 792.886 -0.190915 824.536 17.978C845.263 29.8792 855.785 47.159 858.056 68.3607C860.333 89.6271 854.312 114.91 841.75 142.715C816.631 198.316 765.539 263.607 703.596 326.215C641.668 388.809 568.962 448.654 500.69 493.375C466.554 515.735 433.541 534.304 403.551 547.545C373.547 560.792 346.63 568.678 324.67 569.731C286.54 571.565 256.133 557.213 240.197 528.02C224.228 498.764 222.648 454.351 242.821 395.801L243.279 394.473L241.565 394.476L241.321 394.629C182.05 432.055 136.372 447.071 100.137 448.982C63.9342 450.892 37.0619 439.725 15.3638 424.583C4.87097 417.26 -0.0584166 402.298 1.19027 381.971C2.43612 361.69 9.82898 336.329 23.6278 308.632C51.2199 253.248 104.336 188.698 184.609 137.022C266.622 84.2277 318.964 66.7103 352.709 64.9198C369.561 64.0256 381.759 67.0549 390.708 71.5562C399.659 76.0583 405.423 82.0645 409.364 87.2216L409.364 87.2206C416.387 96.4245 420.509 115.423 414.697 141.246C408.896 167.022 393.214 199.479 360.848 235.433L362.305 236.804C417.908 180.244 501.771 107.233 587.653 57.5308C630.595 32.6792 673.997 13.6818 714.591 5.46068Z" stroke="#FE9D56" stroke-width="2"/>
                    </svg>
                </div>
                <div class="look-info">
                    <div class="look-info-text-block">
                        <div class="look-info-title">
                            Get the Look
                        </div>
                        <div class="look-info-text">
                            Обирай не просто речі — створюй вайб. Чистий монохром чи сміливий мікс фактур — твій стиль диктує правила. У нашій підбірці трендовість зустрічається з характером.
                        </div>
                    </div>
                    <div class="look-info-btn-block">
                        <a href="#" class="look-info-btn">
                            готові образи
                            <span class="icon">
                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                    <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                    </g>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="look-list-cont swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide look-list-item-cont">
                            <a href="#" class="look-list-item">
                                <div class="look-list-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg1.jpg">
                                </div>

                            </a>
                        </div>
                        <div class="swiper-slide look-list-item-cont">
                            <a href="#" class="look-list-item">
                                <div class="look-list-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg2.jpg">
                                </div>

                            </a>
                        </div>
                        <div class="swiper-slide look-list-item-cont">
                            <a href="#" class="look-list-item">
                                <div class="look-list-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg3.jpg">
                                </div>

                            </a>
                        </div>
                        <div class="swiper-slide look-list-item-cont">
                            <a href="#" class="look-list-item">
                                <div class="look-list-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg1.jpg">
                                </div>

                            </a>
                        </div>
                        <div class="swiper-slide look-list-item-cont">
                            <a href="#" class="look-list-item">
                                <div class="look-list-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg2.jpg">
                                </div>

                            </a>
                        </div>
                        <div class="swiper-slide look-list-item-cont">
                            <a href="#" class="look-list-item">
                                <div class="look-list-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg3.jpg">
                                </div>

                            </a>
                        </div>
                    </div>
                    <div class="swiper-scrollbar look-list-scroll">

                    </div>
                </div>
            </div>
        </div>
        */?>
    <?if(isset($_GET['look']) || true)
{
    ?>
    <div class="look-container">
        <div class="look-content">
            <div class="look-bg-img">
                <svg width="639" height="578" viewBox="0 0 639 578" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M563.96 232.822C600.932 206.336 627.136 174.054 636.228 134.909C642.196 109.206 636.136 87.6686 620.695 69.8758C605.232 52.0583 580.337 37.9703 548.602 27.2763C485.137 5.88961 394.523 -1.85585 298.018 1.10706C201.522 4.06966 99.1824 17.7367 12.2874 39.1426C-31.1598 49.8455 -70.7377 62.4811 -103.789 76.6763C-136.847 90.8745 -163.345 106.62 -180.66 123.528C-210.72 152.874 -222.019 188.215 -210.402 223.061C-198.774 257.941 -164.144 292.463 -102.029 320.02L-101.388 320.304L-101.981 320.94L-102.12 320.978C-176.456 340.612 -222.71 366.089 -251.394 393.832C-280.066 421.565 -291.214 451.594 -295.278 480.414C-297.28 494.609 -288.758 509.921 -271.457 524.142C-254.174 538.349 -228.225 551.38 -195.649 561C-130.504 580.238 -38.9481 585.807 62.5429 559.95C166.164 533.548 219.417 504.595 246.157 478.748C259.52 465.831 266.256 453.694 269.358 443.041C272.266 433.053 271.989 424.338 270.949 417.461L270.731 416.11C268.548 403.362 256.215 385.747 231.076 371.085C205.958 356.435 168.103 344.768 115.011 343.896L115.005 342.896C201.93 340.504 323.178 327.715 427.242 295.888C479.275 279.974 526.986 259.308 563.96 232.822Z" stroke="#FE9D56"/>
                </svg>
                <svg class="svg-tables" width="461" height="571" viewBox="0 0 461 571" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M714.591 5.46068C755.182 -2.75955 792.886 -0.190915 824.536 17.978C845.263 29.8792 855.785 47.159 858.056 68.3607C860.333 89.6271 854.312 114.91 841.75 142.715C816.631 198.316 765.539 263.607 703.596 326.215C641.668 388.809 568.962 448.654 500.69 493.375C466.554 515.735 433.541 534.304 403.551 547.545C373.547 560.792 346.63 568.678 324.67 569.731C286.54 571.565 256.133 557.213 240.197 528.02C224.228 498.764 222.648 454.351 242.821 395.801L243.279 394.473L241.565 394.476L241.321 394.629C182.05 432.055 136.372 447.071 100.137 448.982C63.9342 450.892 37.0619 439.725 15.3638 424.583C4.87097 417.26 -0.0584166 402.298 1.19027 381.971C2.43612 361.69 9.82898 336.329 23.6278 308.632C51.2199 253.248 104.336 188.698 184.609 137.022C266.622 84.2277 318.964 66.7103 352.709 64.9198C369.561 64.0256 381.759 67.0549 390.708 71.5562C399.659 76.0583 405.423 82.0645 409.364 87.2216L409.364 87.2206C416.387 96.4245 420.509 115.423 414.697 141.246C408.896 167.022 393.214 199.479 360.848 235.433L362.305 236.804C417.908 180.244 501.771 107.233 587.653 57.5308C630.595 32.6792 673.997 13.6818 714.591 5.46068Z" stroke="#FE9D56" stroke-width="2"/>
                </svg>
            </div>
            <div class="look-info">
                <div class="look-info-text-block">
                    <div class="look-info-title">
                        Get the Look
                    </div>
                    <div class="look-info-text">
                        Обирай не просто речі — створюй вайб. Чистий монохром чи сміливий мікс фактур — твій стиль диктує правила. У нашій підбірці трендовість зустрічається з характером.
                    </div>
                </div>
                <!-- <div class="look-info-btn-block">
                    <a href="#" class="look-info-btn">
                        готові образи
                        <span class="icon">
                            <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                </g>
                            </svg>
                        </span>
                    </a>
                </div -->
            </div>
            <?
            $looks = $looksIds = [];
            $res = CIBlockElement::GetList(['SORT'=>'ASC'],['IBLOCK_ID'=>55,'ACTIVE'=>'Y']);
            while ($record = $res->GetNextElement())
            {
                $fields = $record->GetFields();
                $props = $record->GetProperties();
                $looks[$fields['ID']] = $fields;
                $looks[$fields['ID']]['PROPERTIES'] = $props;
                $looksIds = array_merge($looksIds, $props['PRODUCTS']['VALUE']);
            }
            $params = [
                'LOOKS_IDS' => $looks,
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
                'FILTER_NAME' => 'MAX_SMART_FILTER',
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
                'WRAP_CLASS' => 'main-googs-list',
                'BLOCK_CLASS' => 'main-googs-item-cont',
            ];
            global $arLooksIds, $looksProducts;
            $arLooksIds=$looksIds;
            $looksProducts=$looks;

            ?>

            <div class="look-list-cont swiper">
                <div class="swiper-wrapper">
                    <?
                    foreach($looks as $index => $look)
                    {
                        //$lookFile = CFile::GetFileArray($look['PREVIEW_PICTURE'])['SRC'];
                        $lookFile = $img = CFile::ResizeImageGet($look['PREVIEW_PICTURE'], array('width'=>470, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                        ?>
                        <div class="swiper-slide look-list-item-cont">
                            <a href="javascript:void(0)" class="look-list-item" data-bs-toggle="modal" data-bs-target="#look-modal_<?=$look['ID']?>">
                                <div class="look-list-item-img">
                                    <img src="<?=$lookFile?>">
                                </div>
                            </a>
                        </div>
                        <?
                    }
                    ?>
                    <?/*
                            <div class="swiper-slide look-list-item-cont">
                                <a href="javascript:void(0)" class="look-list-item" data-bs-toggle="modal" data-bs-target="#look-modal">
                                    <div class="look-list-item-img">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg1.jpg"></div>

                                </a>
                            </div>
                            <div class="swiper-slide look-list-item-cont">
                                <a href="javascript:void(0)" class="look-list-item" data-bs-toggle="modal" data-bs-target="#look-modal">
                                    <div class="look-list-item-img">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg2.jpg">
                                    </div>

                                </a>
                            </div>
                            <div class="swiper-slide look-list-item-cont">
                                <a href="javascript:void(0)" class="look-list-item" data-bs-toggle="modal" data-bs-target="#look-modal">
                                    <div class="look-list-item-img">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg3.jpg">
                                    </div>

                                </a>
                            </div>
                            <div class="swiper-slide look-list-item-cont">
                                <a href="javascript:void(0)" class="look-list-item" data-bs-toggle="modal" data-bs-target="#look-modal">
                                    <div class="look-list-item-img">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg1.jpg">
                                    </div>

                                </a>
                            </div>
                            <div class="swiper-slide look-list-item-cont">
                                <a href="javascript:void(0)" class="look-list-item" data-bs-toggle="modal" data-bs-target="#look-modal">
                                    <div class="look-list-item-img"><img src="/bitrix/templates/stimma_new/images/imgnew/lookimg2.jpg">
                                    </div>

                                </a>
                            </div>
                            <div class="swiper-slide look-list-item-cont">
                                <a href="javascript:void(0)" class="look-list-item" data-bs-toggle="modal" data-bs-target="#look-modal">
                                    <div class="look-list-item-img">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/lookimg3.jpg">
                                    </div>

                                </a>
                            </div>
                            */?>
                </div>
                <div class="swiper-scrollbar look-list-scroll">

                </div>
            </div>

        </div>
    </div>

<?}?>
    <div class="marquee-cont">
        <div class="marquee-block">
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
            <div class="marquee-item">
                Final Sale до -60%
            </div>
        </div>
    </div>

    <div class="discount-container">
        <div class="discount-bg">
            <div class="wrapper">
                <div class="discount-block">
                    <div class="discount-title">
                        10% скидки на первую покупку**
                    </div>
                    <div class="discount-text-block">
                        <div class="discount-text-title">
                            Присоединяйся, чтобы как можно быстрее узнавать о новых вещах и акциях
                        </div>
                        <div class="discount-text">
                            ** Скидкаявляется одноразовой и действует только на новинки (товары с черными ценниками).<br class="br-1000"> Промокод не сочетается с другими акциями <br> и может не распространяться на некоторые товары. Детали по ссылке
                        </div>
                    </div>
                    <form>
                        <div class="discount-input-block">
                            <input type="text" name="subscribe_email" placeholder="Ваш E-mail">
                            <button class="discount-input-btn info-btn info-btn-black subscribe_me">
                                Я с вами
                                <span class="icon">
                                        <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                            <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="#FFF7E7"/>
                                            </g>
                                        </svg>
                                    </span>
                            </button>
                        </div>
                        <div class="subscribe_result"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="about-us-main-cont">
        <div class="wrapper">
            <div class="about-us-main-block">
                <div class="about-us-main-text">
                        <span class="logo">
                            <svg width="439" height="84" viewBox="0 0 439 84" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M63.0451 50.1892C63.0451 52.3966 62.6342 54.344 61.8275 55.9826C61.0283 57.5986 59.9502 58.981 58.6119 60.0997C57.3189 61.1808 55.811 62.0585 54.1259 62.7026C52.5388 63.3091 50.85 63.7837 49.1121 64.1152C47.4006 64.4391 45.6477 64.6538 43.9061 64.7517C42.2059 64.8534 40.566 64.9024 39.028 64.9024C34.9868 64.9024 31.1831 64.5634 27.7262 63.8967C24.2845 63.2299 21.1895 62.39 18.5318 61.3917L17.2425 60.9058V46.671L20.1943 48.3096C22.6748 49.6807 25.5511 50.7769 28.7478 51.5566C31.9672 52.3439 35.4656 52.7431 39.1448 52.7431C41.3049 52.7431 43.0692 52.6301 44.3886 52.4117C45.9493 52.148 46.8088 51.8466 47.2536 51.6395C47.9133 51.3343 48.0754 51.1234 48.0792 51.1234C48.1395 51.0292 48.1697 50.9652 48.181 50.9313C48.1659 50.9238 48.1244 50.8786 48.049 50.8183C47.7738 50.5923 47.2423 50.2533 46.2659 49.9067C45.3499 49.579 44.2453 49.2701 42.9938 48.9876C41.6781 48.6938 40.2758 48.3962 38.798 48.1024C37.2901 47.8011 35.7408 47.4734 34.1461 47.1268C32.5063 46.7652 30.8966 46.3358 29.3548 45.8499C27.7866 45.3564 26.2749 44.7688 24.8688 44.1058C23.3835 43.4052 22.0528 42.5577 20.9181 41.5896C19.723 40.565 18.7655 39.3596 18.0681 38.0074C17.3481 36.6023 16.9824 34.9788 16.9824 33.1821C16.9824 31.1329 17.3632 29.3135 18.1096 27.7767C18.8447 26.2587 19.855 24.9478 21.1103 23.878C22.3204 22.8459 23.7303 22.0022 25.3023 21.3656C26.7838 20.7629 28.3671 20.2882 30.0069 19.9568C31.6091 19.6328 33.2527 19.4068 34.8888 19.2863C36.4985 19.1657 38.0478 19.1055 39.4917 19.1055C41.0863 19.1055 42.7525 19.1883 44.4414 19.3465C46.1114 19.5048 47.7889 19.7308 49.4174 20.0208C51.0271 20.3033 52.6142 20.6386 54.141 21.0152C55.6489 21.3919 57.0701 21.7912 58.3669 22.2093L59.7428 22.6538V36.4743L56.8853 35.0843C56.1992 34.7491 55.253 34.3535 54.0769 33.9128C52.912 33.4759 51.5624 33.054 50.0696 32.6585C48.5806 32.263 46.9369 31.9277 45.184 31.6603C43.4537 31.3966 41.6555 31.2648 39.8385 31.2648C38.3645 31.2648 37.0941 31.31 36.065 31.4004C35.0547 31.4908 34.2065 31.6075 33.543 31.7431C32.8079 31.8938 32.4158 32.0407 32.216 32.1311C32.1519 32.1613 32.0992 32.1876 32.0502 32.214C32.3593 32.4174 32.8757 32.6848 33.7013 32.9636C34.6362 33.2762 35.7445 33.5813 37.0036 33.8639C38.3306 34.1614 39.7367 34.4665 41.222 34.783C42.7337 35.1031 44.2906 35.4535 45.8965 35.8339C47.5439 36.2219 49.1611 36.6814 50.7029 37.2013C52.2825 37.7286 53.7979 38.3539 55.2003 39.0545C56.678 39.7928 58.0012 40.6743 59.1321 41.6725C60.3234 42.7272 61.2771 43.9589 61.967 45.3376C62.6832 46.769 63.0451 48.4 63.0451 50.1892Z" fill="#1E1E1E"/>
                                <path d="M128.619 20.1172V32.736H111.716V63.8311H96.9985V32.736H80.125V20.1172H128.619Z" fill="#1E1E1E"/>
                                <path d="M163.255 20.1172H148.542V63.8311H163.255V20.1172Z" fill="#1E1E1E"/>
                                <path d="M253.36 20.1172V63.8311H238.703V41.9421L227.126 63.8311H214.426L202.849 41.9421V63.8311H188.136V20.1172H205.906L220.778 47.9653L235.65 20.1172H253.36Z" fill="#1E1E1E"/>
                                <path d="M343.482 20.1172V63.8311H328.829V41.9421L317.252 63.8311H304.552L292.975 41.9421V63.8311H278.262V20.1172H296.029L310.9 47.9653L325.772 20.1172H343.482Z" fill="#1E1E1E"/>
                                <path d="M399.126 20.1172H384.737L361.843 63.8311H378.343L382.075 56.3088H401.783L405.519 63.8311H422.016L399.126 20.1172ZM396.027 44.5864H387.903L391.982 36.4049L396.027 44.5864Z" fill="#1E1E1E"/>
                            </svg>
                        </span>
                    – это не просто одежда, <br> а отображение твоего способа жизни –
                    <span class="orange">свободного, стильного и сегодняшнего!</span>
                </div>
                <div class="about-us-main-btn">
                    <a href="<?=$ru?>/pro-nas/" class="info-btn">
                        О нас
                        <span class="icon">
                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                    <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                    </g>
                                </svg>
                            </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="instagram-cont">
        <div class="wrapper">
            <div class="instagram-title-block">
                <div class="instagram-title">
                    Присоединяйся к нам в Инстаграм
                </div>
                <div class="instagram-btn-block">
                    <a href="https://www.instagram.com/stimma_official/" class="info-btn" target="_blank">
                        @stimma_official
                    </a>
                </div>
            </div>
        </div>
        <?
        $res=$DB->Query('select * from b_iblock_element where IBLOCK_ID = 36 and ACTIVE = \'Y\' order by ID desc limit 25');
        ?>
        <div class="swiper instagram-foto-slider">
            <div class="swiper-wrapper">
                <?
                while ($insta=$res->Fetch())
                {
                    $file=CFile::GetFileArray($insta['PREVIEW_PICTURE'])['SRC'];
                    ?>
                    <div class="swiper-slide">
                        <a href="<?=trim($insta['PREVIEW_TEXT'])?>" class="instagram-foto-item">
                            <img src="<?=$file?>">
                        </a>
                    </div>
                    <?
                }
                ?>
                <?/*
                <div class="swiper-slide">
                    <a href="#" class="instagram-foto-item">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/insta1.png">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="instagram-foto-item">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/insta2.png">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="instagram-foto-item">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/insta3.png">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="instagram-foto-item">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/insta4.png">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="instagram-foto-item">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/insta5.png">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="instagram-foto-item">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/insta6.png">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="instagram-foto-item">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/insta7.png">
                    </a>
                </div>
                */?>
            </div>
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
            ],
            'PROPERTY_CODE_MOBILE' => '',
            'META_KEYWORDS' => '-',
            'META_DESCRIPTION' => '-',
            'BROWSER_TITLE' => '-',
            'SET_LAST_MODIFIED' => 'Y',
            'INCLUDE_SUBSECTIONS' => 'Y',
            'BASKET_URL' => '/ru/basket/',
            'ACTION_VARIABLE' => 'action',
            'PRODUCT_ID_VARIABLE' => 'id',
            'SECTION_ID_VARIABLE' => 'SECTION_ID',
            'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
            'PRODUCT_PROPS_VARIABLE' => 'prop',
            'FILTER_NAME' => 'MAX_SMART_FILTER',
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
            'PAGE_ELEMENT_COUNT' => '3',
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
            'SECTION_URL' => '/ru/catalog/#SECTION_CODE_PATH#/',
            'DETAIL_URL' => '/ru/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
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
            'COMPARE_PATH' => '/ru/catalog/compare.php?action=#ACTION_CODE#',
            'COMPARE_NAME' => 'CATALOG_COMPARE_LIST',
            'USE_COMPARE_LIST' => 'Y',
            'BACKGROUND_IMAGE' => '-',
            'COMPATIBLE_MODE' => 'Y',
            'DISABLE_INIT_JS_IN_COMPONENT' => 'N',
            'WRAP_CLASS' => 'main-googs-list',
            'BLOCK_CLASS' => 'main-googs-item-cont',
    ];

    if(isset($_GET['new']) || true)
    {

        $res = CIBlockElement::GetList(['SORT'=>'asc'],['IBLOCK_ID' => 41,'ACTIVE' => 'Y']);
        $data = [];
        $products = [];
        while ($record = $res->GetNextElement())
        {
            $fields = $record->GetFields();
            $props = $record->GetProperties();

            /*if($props['PRODUCTS']['VALUE'])
                foreach($props['PRODUCTS']['VALUE'] as $index => $product)
                    $products[$product] = $product;*/

            $data[$fields['SORT']][$fields['ID']] = $fields;
            $data[$fields['SORT']][$fields['ID']]['PROPERTIES'] = $props;
        }

        $new = $jin = [];
        $newDB = CIBlockElement::GetList([],['IBLOCK_ID'=>21,'SECTION_ID'=>350,'>SORT' => 0,'!PREVIEW_PICTURE' => false,'INCLUDE_SUBSECTIONS'=>'Y','ACTIVE'=>'Y'],false,['nTopCount'=>4]);
        while ($record = $newDB->Fetch())
        {
            $new[$record['ID']] = $record['ID'];
            $products[$record['ID']] = $record['ID'];
        }
        $jinDB = CIBlockElement::GetList([],['IBLOCK_ID'=>21,'SECTION_ID'=>347,'>SORT' => 0,'!PREVIEW_PICTURE' => false,'ACTIVE'=>'Y','INCLUDE_SUBSECTIONS'=>'Y','!PROPERTY_IN_BLOCK' => false],false,['nTopCount'=>4]);
        while ($record = $jinDB->Fetch())
        {
            $jin[$record['ID']] = $record['ID'];
            $products[$record['ID']] = $record['ID'];
        }

        $params = [
                'NEW' => $new,
                'JIN' => $jin,
                'DATA' => $data,
                'IBLOCK_TYPE' => 'aspro_max_catalog',
                'IBLOCK_ID' => '21',
                'ELEMENT_SORT_FIELD' => 'RAND',
                'ELEMENT_SORT_ORDER' => 'desc',
                'ELEMENT_SORT_FIELD2' => 'RAND',
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
                        43 => 'PROP_333',44 => 'PROP_332',
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
                'META_KEYWORDS' => '',
                'META_DESCRIPTION' => '',
                'BROWSER_TITLE' => '',
                'SET_LAST_MODIFIED' => 'Y',
                'INCLUDE_SUBSECTIONS' => 'Y',
                'BASKET_URL' => '/basket/',
                'ACTION_VARIABLE' => 'action',
                'PRODUCT_ID_VARIABLE' => 'id',
                'SECTION_ID_VARIABLE' => 'SECTION_ID',
                'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
                'PRODUCT_PROPS_VARIABLE' => 'prop',
                'FILTER_NAME' => 'MAX_SMART_FILTER',
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
                'PAGE_ELEMENT_COUNT' => '3000',
                'LINE_ELEMENT_COUNT' => '4',
                'PRICE_CODE' => [0 => 'BASE',1=>'DISCOUNT',2=>'OPT'],
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
                'WRAP_CLASS' => 'main-googs-list',
                'BLOCK_CLASS' => 'main-googs-item-cont',
        ];
        global $MAX_SMART_FILTER;

        ?>
        <?/*<div class="main-big-banner main">
        <a href="#">
            <img src="/upload/iblock/754/qwz3lsi2lcsch21fg2lsy2mqard0bj1n.jpg" alt="">
        </a>
    </div>*/?>

        <?
        $old = false;

        if($old)
        {
            ?>
            <div class="main-googs-wraper mgw12">
            <div class="tab-content">
            <div class="tab-pane fade active in" id="tab111">
            <?
        }
        ?>

        <?//$params['SECTION_ID'] = 347; $params['INCLUDE_SUBSECTIONS'] = 'Y'?>
        <?
        $MAX_SMART_FILTER = ['ID' => $products];
        $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                $old ? "main" : 'main_page',
                $params,
                false
        );
        unset($MAX_SMART_FILTER['!ID']);
        ?>
        <?/*
        	<div class="main-googs-list ">
        		<div class="main-googs-item-cont">
	    			<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="main-googs-item-cont">
					<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="main-googs-item-cont">
					<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.2701210.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="main-googs-item-cont">
					<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
        	</div>
            */?>
        <?
        if($old)
        {
            ?></div>
            </div>
            </div><?
        }
        ?>

        <?/*<div class="main-big-banner main">
        <a href="#">
            <img src="/upload/iblock/754/qwz3lsi2lcsch21fg2lsy2mqard0bj1n.jpg" alt="">
        </a>
    </div>
    <div class="main-big-banner main double">
        <a href="#">
            <img src="/upload/iblock/754/qwz3lsi2lcsch21fg2lsy2mqard0bj1n.jpg" alt="">
        </a>
        <a href="#">
            <img src="/upload/iblock/754/qwz3lsi2lcsch21fg2lsy2mqard0bj1n.jpg" alt="">
        </a>
    </div>*/?>
        <?
    }
    else
    {
        ?>
        <div class="main-googs-wraper mgw13">
            <ul class="nav nav-tabs">
                <li class="active"><a href="/ru/catalog/novinki/">NEW</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab11">
                    <?
                    /*$res = CIBlockElement::GetList(['ID' => 'desc'], ['IBLOCK_ID' => 25, 'PROPERTY_SELECTION' => 1175], false, false, ['ID','IBLOCK_ID','PROPERTY_CML2_LINK']);
                    $ids = [];
                    while ($record = $res -> Fetch())
                    {
                        $ids[$record['PROPERTY_CML2_LINK_VALUE']] = $record['PROPERTY_CML2_LINK_VALUE'];
                        if(count($ids) == 3)
                            break;
                    }
                    $MAX_SMART_FILTER = ['=ID' => $ids];*/
                    $MAX_SMART_FILTER = ['SECTION_ID' => 350];
                    $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section",
                            "main",
                            $params,
                            false
                    );
                    //$MAX_SMART_FILTER['!ID'] = $MAX_SMART_FILTER['=ID'];
                    //unset($MAX_SMART_FILTER['=ID']);
                    ?>
                </div>
            </div>
        </div>
        <div class="main-googs-wraper mgw14">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab111" data-toggle="tab">женская одежда</a></li>
                <?/*<li ><a href="#tab112" data-toggle="tab">детская одежда</a></li>*/?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab111">
                    <?$params['SECTION_ID'] = 347; $params['INCLUDE_SUBSECTIONS'] = 'Y'?>
                    <?
                    $MAX_SMART_FILTER = ['!PROPERTY_IN_BLOCK' => false];
                    $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section",
                            "main",
                            $params,
                            false
                    );
                    unset($MAX_SMART_FILTER['!ID']);
                    ?>
                    <?/*
        	<div class="main-googs-list ">
        		<div class="main-googs-item-cont">
	    			<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="main-googs-item-cont">
					<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="main-googs-item-cont">
					<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="main-googs-item-cont">
					<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
        	</div>
            */?>
                </div>
                <div class="tab-pane fade" id="tab112">
                    <?$params['SECTION_ID'] = 348; $params['INCLUDE_SUBSECTIONS'] = 'Y'?>
                    <?
                    $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section",
                            "main",
                            $params,
                            false
                    );
                    ?>
                    <?/*
        	<div class="main-googs-list ">
        		<div class="main-googs-item-cont">
	    			<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="main-googs-item-cont">
					<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="main-googs-item-cont">
					<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="main-googs-item-cont">
					<div class="catalog-item-block">
						<div class="catalog-item-img">
							<a href="#">
								<img src="/bitrix/templates/aspro_max/images/mgimg.png">
							</a>
							<div class="catalog-item-size-list">
								<div class="catalog-item-size no-size">
									XS
								</div>
								<div class="catalog-item-size ">
									S
								</div>
								<div class="catalog-item-size no-size">
									M
								</div>
								<div class="catalog-item-size ">
									L
								</div>
								<div class="catalog-item-size ">
									XL
								</div>
								<div class="catalog-item-size no-size">
									XXL
								</div>
							</div>
							<div class="catalog-item-favorite">
								<a href="#">
									<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="catalog-item-name-block">
							<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
							<div class="catalog-item-sale">SALE</div>
						</div>
						<div class="catalog-item-info">
							<div class="catalog-item-price">
								<div class="catalog-item-price-currency">990 грн</div>
								<div class="catalog-item-price-old">1300  грн</div>
							</div>
							<div class="catalog-item-colors">
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color active">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
								<a href="#" class="catalog-item-color">
									<img src="/bitrix/templates/aspro_max/images/colorimg.png">
								</a>
							</div>
						</div>
					</div>
				</div>
        	</div>
            */?>
                </div>
            </div>
        </div>
        <?
    }
}



?>




<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>