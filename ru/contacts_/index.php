<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "1. Винница, ТЦ «Sky Park», ул. Николая Оводова 51. (2-й этаж). 2. Львов, ТРЦ «Victoria Gardens», ул. Кульпарковская, 226а (1 этаж). 3. Житомир, ТЦ «Глобал», ул. Киевская 77. 4. Луцк, ТРЦ «ПортCity», ул. Сухомлинского, 1 (1-й этаж). 5. Тернополь, ТРЦ «Подоляны», ул. Текстильная 28. (1-й этаж). 6. Кривой Рог, ТЦ «Солнечная Галерея», Площадь 30-летия Победы, […]");
$APPLICATION->SetPageProperty("title", "Наши магазины &ndash; STIMMA");
$APPLICATION->SetTitle("Наши магазины");?>
<?use Bitrix\Main\Page\Asset;?>
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/leaflet.css" />
    <link rel="stylesheet" href="/bitrix/templates/aspro_max/components/bitrix/breadcrumb/main/style.css" />

<?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/leaflet.js');?>


<?//CMax::ShowPageType('page_contacts');?>
    <div class="top-block-wrapper">
        <section class="intoppage page-top maxwidth-theme ">
            <div class="topic">
                <div class="topic__inner">
                    <div class="topic__heading">
                        <h1 id="pagetitle th4">Наши магазины</h1>                    </div>
                </div>
            </div>
            <div id="navigation">
                <div class="breadcrumbs swipeignore" itemscope="" itemtype="http://schema.org/BreadcrumbList"><div class="breadcrumbs__item" id="bx_breadcrumb_0" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a class="breadcrumbs__link" href="/" title="Главная" itemprop="item"><span itemprop="name" class="breadcrumbs__item-name ">Главная</span><meta itemprop="position" content="1"></a></div><span class="breadcrumbs__separator">/</span><span class="breadcrumbs__item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><link href="/contacts/" itemprop="item"><span><span itemprop="name" class="breadcrumbs__item-name ">Наши магазины</span><meta itemprop="position" content="2"></span></span></div>            </div>
        </section>
    </div>

<?
$shop = $sSections = [];
$res = CIBlockElement::GetList(['SORT' => 'asc'],['IBLOCK_ID' => 12, 'ACTIVE' => 'Y']);
while ($record = $res -> GetNextElement())
{
    $fields = $record -> GetFields();
    $props = $record -> GetProperties();

    $shop[$fields['IBLOCK_SECTION_ID']][$fields['ID']] = $fields;
    $shop[$fields['IBLOCK_SECTION_ID']][$fields['ID']]['PROPERTIES'] = $props;
}
$res = CIBlockSection::GetList(['SORT' => 'asc'],['IBLOCK_ID' => 12, 'ACTIVE' => 'Y'],false,['ID','NAME','IBLOCK_ID','UF_*','PICTURE']);
while ($record = $res -> Fetch())
{
    $sSections[$record['ID']] = $record;
}
?>

    <div class="wrapper_inner_half row flexbox shop-detail1 clearfix contacts-page" itemscope="" itemtype="http://schema.org/Organization">
        <div class="maxwidth-theme">
            <?
            if(isset($_GET['new_map']) ||  true)
            {
                ?>

                <div class="contacts-text">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-3">
                            <h2 >Интернет-магазин</h2>
                            <h2 >График работы</h2>
                            <p>Понедельник - Пятница: 9.00 - 18.00</p>
                            <p>Суббота - Воскресенье: 10.00 - 18.00</p>
                        </div>
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-3">
                            <h2 >ТЕЛЕФОН</h2>
                            <p ><a href="tel:0800300068">0800300068</a><?/* | <a href="tel:+380502525203">+38 050 252 52 03</a> | <a href="tel:+380632525203">+38 063 252 52 03</a>*/?></p>
                            <h2 >EMAIL</h2>
                            <p ><a href="mailto:stimmacomua@gmail.com">stimmacomua@gmail.com</a></p>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="item col-md-12 map-full padding0 map-list-cont">
                        <div class="map-list-shop">
                            <?
                            $maps = [];
                            foreach($shop as $ibs => $items)
                            {
                                $section = $sSections[$ibs];
                                $img = $section['PICTURE'];
                                $img = CFile::ResizeImageGet($img, array('width'=>315, 'height'=>210), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                                ?>
                                <div class="list-shop-item active show_city" id="city_<?=$section['ID']?>" data-city-id="<?=$section['ID']?>">
                                    <div class="list-shop-img">
                                        <img src="<?=$img?>" alt="<?=LANGUAGE_ID == 'ua' ? $section['UF_NAME_UA'] : $section['NAME']?>" width="62">
                                    </div>
                                    <div class="list-shop-item-info">
                                        <div class="list-shop-item-city"><?=LANGUAGE_ID == 'ua' ? $section['UF_NAME_UA'] : $section['NAME']?></div>
                                        <div class="list-shop-item-address"> </div>
                                    </div>
                                </div>
                                <?
                                foreach($items as $index => $item)
                                {
                                    if($item['PROPERTIES']['MAP']['VALUE'])
                                        $maps[] = explode(',',$item['PROPERTIES']['MAP']['VALUE']);

                                    $img = $item['PREVIEW_PICTURE'] ? $item['PREVIEW_PICTURE'] : $item['DETAIL_PICTURE'];
                                    $img = CFile::ResizeImageGet($img, array('width'=>315, 'height'=>210), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                                    ?>
                                    <div style="display:none;padding-left: 55px;" class="list-shop-item active move_map for_city_<?=$section['ID']?>" id="shop_<?=$item['ID']?>" move-to="<?=$item['PROPERTIES']['MAP']['VALUE'] ? $item['PROPERTIES']['MAP']['VALUE'] : '-1'?>">
                                        <div class="list-shop-img">
                                            <img src="<?=$img?>" alt="<?=LANGUAGE_ID == 'ua' ? $item['PROPERTIES']['NAME_UA']['VALUE'] : $item['NAME']?>" width="62">
                                        </div>
                                        <div class="list-shop-item-info">
                                            <div class="list-shop-item-city"><?=LANGUAGE_ID == 'ua' ? $item['PROPERTIES']['NAME_UA']['VALUE'] : $item['NAME']?></div>
                                            <div class="list-shop-item-address"> <?=LANGUAGE_ID == 'ua' ? $item['PROPERTIES']['ADDRESS_UA']['VALUE'] : $item['PROPERTIES']['ADDRESS']['VALUE']?></div>
                                            <a href="#" class="list-shop-item-phone" onclick="return false;"><?=$item['PROPERTIES']['SCHEDULE_UA']['~VALUE']?></a>
                                        </div>
                                    </div>
                                    <?
                                }
                            }
                            ?>



                        </div>
                        <div class="right_block_store contacts_map" id="contacts_map" style="width: 100%">
                        </div>
                    </div>
                </div>

                <style>
                    #contacts_map {
                        filter: grayscale(100%);
                        -webkit-filter: grayscale(100%);
                        -moz-filter: grayscale(100%);
                        -ms-filter: grayscale(100%);
                        -o-filter: grayscale(100%);
                    }
                </style>
                <script>
                    var arr = <?=CUtil::PhpToJSObject($maps)?>;
                    $(document).ready(function()
                    {
                        $(document).on('click','.show_city',function()
                        {
                            var city = $(this).attr('data-city-id');
                            $('.move_map').hide();
                            if($('.for_city_'+city).hasClass('opened'))
                            {
                                $('.for_city_'+city).hide();
                                $('.for_city_'+city).removeClass('opened');
                            }
                            else
                            {
                                $('.opened').removeClass('opened');
                                $('.for_city_'+city).show();
                                $('.for_city_'+city).addClass('opened');
                            }

                        });

                        $(document).on('click', '.move_map', function()
                        {
                            var coords = $(this).attr('move-to');
                            if(coords != -1 && coords != '-1')
                            {
                                coords = coords.split(',');
                                moveToLocation(coords[0], coords[1]);
                            }
                        });

                        console.log(arr);
                        var grayscale = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

                        var myIcon = L.icon({
                            //iconUrl: '/bitrix/templates/aspro_max/images/marker.png',
                            iconUrl: '/contacts/pin.png',
                            iconSize: [50, 70],
                        });
                        //if(arr[0][0] != '' && arr[0][1] != '')
                        {
                            var map = L.map('contacts_map', {center: [arr[0][0], arr[0][1]],zoom: 15,layers: [grayscale]});

                            for (i in arr)
                            {
                                var point = L.marker([arr[i][0], arr[i][1]], {icon:myIcon});
                                point.addTo(map);
                            }

                            /* map.fitBounds([
                                 [arr[0][0], arr[0][1]],
                                 arr
                             ]);*/
                        }


                        function moveToLocation(latitude, longitude) {
                            map.setView([latitude, longitude], 13);
                        }

                        /*moveButton.addEventListener('click', function () {
                            moveToLocation(40.7128, -74.0060); // Приклад координат Нью-Йорка
                        });*/

                    })
                </script>
                <?
            }
            else
            {
                ?>
                <div class="row">
                    <?
                    $maps = [];
                    foreach ($shop as $index => $item)
                    {
                        $img = $item['PREVIEW_PICTURE'] ? $item['PREVIEW_PICTURE'] : $item['DETAIL_PICTURE'];
                        //$img = CFile::GetFileArray($img);
                        $img = CFile::ResizeImageGet($img, array('width'=>315, 'height'=>210), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];

                        if($item['PROPERTIES']['MAP']['VALUE'])
                            $maps[] = explode(',',$item['PROPERTIES']['MAP']['VALUE']);
                        ?>
                        <div class=" item-shop-detail1  col-md-3">
                            <div class="left_block_store ">
                                <div class="top_block tb23">
                                    <div class="contacts_img ">
                                        <img data-lazyload="" class=" ls-is-cached lazyloaded" src="<?=$img?>" data-src="/images/contacts_image.jpg">											</div>

                                </div>
                                <div class="bottom_block">
                                    <div class="properties clearfix">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="property address">
                                                <div class="title font_upper muted">Адрес</div>
                                                <div itemprop="address" class="value darken"><?=$item['NAME']?> <?=$item['PROPERTIES']['ADDRESS']['VALUE']?></div>
                                            </div>
                                            <div class="property schedule">
                                                <div class="title font_upper muted">График</div>
                                                <div class="value darken"><?=$item['PROPERTIES']['SCHEDULE']['~VALUE']['TEXT']?></div>
                                            </div>
                                        </div>
                                        <?/*
                                    <div class="col-md-12 col-sm-12">
                                        <div class="property phone">
                                            <div class="title font_upper muted">Телефон</div>
                                            <div class="value darken" itemprop="telephone"><a href="http://stimma.bservice.club/contacts/?bitrix_include_areas=Y&amp;clear_cache=Y#"><?=implode(', ', $item['PROPERTIES']['PHONE']['VALUE'])?></a></div>
                                        </div>
                                        <div class="property email">
                                            <div class="title font_upper muted">E-mail</div>
                                            <div class="value darken" itemprop="email"><a href="http://stimma.bservice.club/contacts/?bitrix_include_areas=Y&amp;clear_cache=Y#"><?=$item['PROPERTIES']['EMAIL']['VALUE']?></a></div>
                                        </div>
                                    </div>
                                    */?>
                                    </div>
                                </div>
                                <div class="clearboth"></div>
                            </div>
                        </div>
                        <?
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="item col-md-12 map-full padding0">
                        <div class="right_block_store contacts_map" id="contacts_map">

                        </div>
                    </div>
                </div>
                <div class="hidden">
                    <span itemprop="name">Укр</span>
                </div>
                <script>
                    var arr = <?=CUtil::PhpToJSObject($maps)?>;
                    console.log(arr);
                    $(document).ready(function()
                    {
                        var grayscale = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

                        var myIcon = L.icon({
                            iconUrl: '/bitrix/templates/aspro_max/images/marker.png',
                            iconSize: [50, 50],
                        });

                        //if(arr[0][0] != '' && arr[0][1] != '')
                        {
                            var map = L.map('contacts_map', {center: [arr[0][0], arr[0][1]],zoom: 15,layers: [grayscale]});

                            for (i in arr)
                            {
                                console.log(arr[i][0]);
                                console.log(arr[i][1]);
                                var point = L.marker([arr[i][0], arr[i][1]], {icon:myIcon});
                                point.addTo(map);
                            }

                            map.fitBounds([
                                [arr[0][0], arr[0][1]],
                                arr
                            ]);
                        }
                    })
                </script>
                <?
            }
            ?>

        </div>
    </div>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "STIMMA",
  "url": "https://www.stimma.com.ua/",
  "logo": "https://www.stimma.com.ua/upload/CMax/95f/ewzwz7j9wwwn3jf0i974xt1thzfog3p6.svg",
  "sameAs": [
    "https://www.facebook.com/stimma2016/",
    "https://www.instagram.com/stimma_official/",
    "https://www.youtube.com/channel/UCYbanVf9TfoB3sZ3FZDkGng"
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+380800300068",
    "contactType": "Customer Service",
    "areaServed": "UA",
    "availableLanguage": ["uk", "ru"]
  }
}
</script>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>