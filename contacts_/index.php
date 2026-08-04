<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetPageProperty("description", "1. Вінниця, ТЦ “Sky Park”, вул. Миколи Оводова 51. (2-й поверх). 2. Львів, ТРЦ “Victoria Gardens”, вул. Кульпарківська, 226а (1-й поверх). 3. Житомир, ТЦ “Глобал”, вул. Київська 77. 4. Луцьк, ТРЦ “ПортCity”, вул. Сухомлинського, 1 (1-й поверх). 5. Тернопіль, ТРЦ “Подоляни”, вул. Текстильна 28. (1-й поверх). 6. Кривий Ріг, ТЦ “Сонячна Галерея”, Площа 30 річчя […]");
$APPLICATION->SetPageProperty("title", "Наші магазини &ndash; STIMMA");
$APPLICATION->SetTitle("Наші магазини");?>
<?
setcookie('new_stimma', '1', -1,'/');
?>
<?if(isset($_GET['newstimma']) || NEW_STIMMA)
    {
        $points=$sections=[];
        $resPoints=CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => 12,'ACTIVE'=>'Y','!ID'=>5428));
        $resSections=CIBlockSection::GetList(Array(), Array("IBLOCK_ID" => 12,'ACTIVE'=>'Y','!ID'=>1248),false,['UF_*']);

        while ($record = $resPoints->GetNextElement())
        {
            $fields=$record->GetFields();
            $properties=$record->GetProperties();
            $points[$fields['ID']]=$fields;
            $points[$fields['ID']]['PROPERTIES']=$properties;
        }

        while ($record = $resSections->Fetch())
        {
            if($record['DEPTH_LEVEL']== 1) continue;
            $sections[$record['ID']]=$record;
        }

        \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/css/leaflet.css');
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/leaflet.js');

        ?>

        <div class="breadcrumbs-cont">
            <div class="wrapper">
                <div class="breadcrumbs-block">
                    <a href="#" class="breadcrumb-item">
                        STIMMA
                    </a>
                    <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
                        </svg>
                    </span>
                    <span class="breadcrumb-item">
                        Магазини
                    </span>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <h2 class="info-page-title margin-top-0">
                <?=LANGUAGE_ID == 'ru' ? 'Магазины' : 'Магазини'?>
            </h2>
            <div class="city-list-block">
                <?
                foreach ($sections as $index => $section)
                {
                    ?>
                    <a href="#" class="city-list-item move_map s_section" move-to="<?=$section['UF_COORDS']?>" data-section-id="<?=$section['ID']?>">
                        <?=LANGUAGE_ID == 'ru' ? $section['NAME'] : $section['UF_NAME_UA']?>
                    </a>
                    <?
                }
                ?>
            </div>
            <div class="city-list-tabs" role="tablist">
                <button class="city-list-tab" data-bs-toggle="tab" data-bs-target="#city-map-list" type="button" role="tab" aria-selected="true">
                    Списком
                </button>
                <button class="city-list-tab" data-bs-toggle="tab" data-bs-target="#contacts_map" type="button" role="tab" aria-selected="false">
                    <?=LANGUAGE_ID == 'ru' ? 'На карте' : 'На мапі'?>
                </button>
            </div>
            <div class="city-map-cont tab-content ">
                <div class="city-map-list tab-pane fade show active" id="city-map-list" role="tabpanel"  tabindex="0">

                        <?
                        $maps=[];
                        $number=0;
                        foreach ($points as $index => $point)
                        {
                            if($point['PROPERTIES']['MAP']['VALUE'])
                                $maps[] = explode(',',$point['PROPERTIES']['MAP']['VALUE']);
                            ?>
                            <div class="city-map-item show_city" for-section="<?=$point['IBLOCK_SECTION_ID']?>" id="city_<?=$sections[$point['IBLOCK_SECTION_ID']]['ID']?>" data-city-id="<?=$sections[$point['IBLOCK_SECTION_ID']]['ID']?>">
                                <div class="city-map-item-title move_map for_city_<?=$sections[$point['IBLOCK_SECTION_ID']]['ID']?>" data-marker="<?=$number?>"  id="shop_<?=$point['ID']?>" move-to="<?=$point['PROPERTIES']['MAP']['VALUE'] ? $point['PROPERTIES']['MAP']['VALUE'] : '-1'?>">
                                    <div class="city-map-info">
                                        <div class="city-map-name">
                                            <?=LANGUAGE_ID == 'ru' ? $sections[$point['IBLOCK_SECTION_ID']]['NAME'] : $sections[$point['IBLOCK_SECTION_ID']]['UF_NAME_UA']?>
                                        </div>
                                        <div class="city-map-address">
                                            <?=LANGUAGE_ID=='ru' ? $point['PROPERTIES']['ADDRESS']['VALUE'] : $point['PROPERTIES']['ADDRESS_UA']['VALUE']?>
                                        </div>
                                        <div class="city-map-work">
                                            <?=LANGUAGE_ID=='ru' ? $point['PROPERTIES']['SCHEDULE']['VALUE'] : $point['PROPERTIES']['SCHEDULE_UA']['VALUE']?>
                                        </div>
                                    </div>
                                    <div class="city-map-icon">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M25 12.5C25 5.60728 19.3927 0 12.5 0C5.60728 0 0 5.60728 0 12.5C0 19.3927 5.60728 25 12.5 25C19.3927 25 25 19.3927 25 12.5ZM11.7635 16.3615L6.55523 11.1531C6.3521 10.95 6.25 10.6833 6.25 10.4166C6.25 10.15 6.3521 9.8833 6.55523 9.68018C6.9625 9.2729 7.62085 9.2729 8.02812 9.68018L12.5 14.1521L16.9719 9.68023C17.3792 9.27295 18.0375 9.27295 18.4448 9.68023C18.8521 10.0875 18.8521 10.7458 18.4448 11.1531L13.2364 16.3615C12.8292 16.7688 12.1708 16.7688 11.7635 16.3615Z" fill="black"/>
                                        </svg>
                                    </div>
                                </div>
                                <?
                                if(!empty($point['PROPERTIES']['MORE_PHOTOS']['VALUE']))
                                {
                                    ?>
                                    <div class="city-map-item-dropdown">
                                        <div class="city-map-item-img-list">
                                            <?
                                            foreach ($point['PROPERTIES']['MORE_PHOTOS']['VALUE'] as $photo)
                                            {
                                                $img=CFile::GetFileArray($photo)['SRC'];
                                                ?>
                                                <div class="city-map-item-img">
                                                    <img src="<?=$img?>">
                                                </div>
                                                <?
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?
                                }
                                ?>

                            </div>
                            <?
                            $number++;
                        }
                        ?>
                </div>
                <div class="city-map tab-pane fade" id="contacts_map" id="nav-profile" role="tabpanel" tabindex="0">
                    
                </div>
            </div>
            <div class="work-time-cont">
                <div class="work-time-block">
                    <div class="work-time-title">
                        Інтернет -магазин
                    </div>
                    <div class="work-time-list">
                        <div class="work-time-group">
                            <a href="tel:0800300068" class="work-time-elem">
                                <span class="icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_418_625)">
                                        <path d="M15.5653 11.7424L13.3325 9.50954C12.535 8.71209 11.1794 9.0311 10.8604 10.0678C10.6211 10.7855 9.82369 11.1842 9.10599 11.0247C7.5111 10.626 5.358 8.5526 4.95927 6.87797C4.72004 6.16024 5.19851 5.36279 5.91621 5.12359C6.95289 4.80461 7.27187 3.44895 6.47442 2.65151L4.24157 0.418659C3.60362 -0.139553 2.64668 -0.139553 2.08847 0.418659L0.573324 1.93381C-0.941823 3.5287 0.732813 7.75516 4.48081 11.5032C8.2288 15.2511 12.4553 17.0056 14.0502 15.4106L15.5653 13.8955C16.1235 13.2575 16.1235 12.3006 15.5653 11.7424Z" fill="#1E1E1E"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_418_625">
                                        <rect width="16" height="16" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                0 800 300 068
                            </a>       
                            <a href="mailto:stimmacomua@gmail.com" class="work-time-elem">
                                <span class="icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.8583 3.17969L11.0059 8.00091L15.8583 12.8221C15.946 12.6388 15.9993 12.4361 15.9993 12.2197V3.78216C15.9993 3.56569 15.946 3.36303 15.8583 3.17969Z" fill="#1E1E1E"/>
                                        <path d="M14.5947 2.375H1.40716C1.19069 2.375 0.988031 2.42822 0.804688 2.51594L7.00666 8.68666C7.55503 9.23503 8.44678 9.23503 8.99516 8.68666L15.1971 2.51594C15.0138 2.42822 14.8111 2.375 14.5947 2.375Z" fill="#1E1E1E"/>
                                        <path d="M0.140938 3.17969C0.0532188 3.36303 0 3.56569 0 3.78216V12.2197C0 12.4361 0.0532188 12.6388 0.140938 12.8221L4.99341 8.00091L0.140938 3.17969Z" fill="#1E1E1E"/>
                                        <path d="M10.3447 8.66406L9.658 9.35072C8.74428 10.2644 7.2575 10.2644 6.34378 9.35072L5.65716 8.66406L0.804688 13.4853C0.988031 13.573 1.19069 13.6262 1.40716 13.6262H14.5947C14.8111 13.6262 15.0138 13.573 15.1971 13.4853L10.3447 8.66406Z" fill="#1E1E1E"/>
                                    </svg>
                                </span>
                                Stimmacomua@gmail.com
                            </a>                            
                        </div>
                        <div class="work-time-group">
                            <div class="work-time-elem">
                                пн-пт  09:00 - 18:00
                            </div>
                            <div class="work-time-elem">
                                сб-нд  10:00 - 18:00
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var arr = <?=CUtil::PhpToJSObject($maps)?>;
            $(document).ready(function()
            {
                /*$(document).on('click','.show_city',function()
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
                });*/

                $(document).on('click', '.move_map', function()
                {
                    var markerIndex = $(this).attr('data-marker');

                    markers.forEach(function(marker){
                        marker.setIcon(myIcon);
                    });

                    console.log('mindex');
                    console.log(markerIndex);
                    console.log(markers[markerIndex]);
                    if(markers[markerIndex])
                    {
                        markers[markerIndex].setIcon(activeIcon);
                    }

                    if($(this).hasClass('s_section'))
                    {
                        if($(this).hasClass('active'))
                        {
                            $('.s_section').removeClass('active');
                            $('[for-section]').show();
                        }
                        else
                        {
                            $('.s_section').removeClass('active');
                            $(this).addClass('active');
                            $('[for-section]').hide();
                            $('[for-section='+$(this).attr('data-section-id')+']').show();
                        }

                    }

                    var coords = $(this).attr('move-to');
                    if(coords != -1 && coords != '-1')
                    {
                        coords = coords.split(',');
                        moveToLocation(coords[0], coords[1]);
                    }

                    return false;
                });

                console.log(arr);
                var grayscale = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
                //var grayscale = L.tileLayer('https://tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png');

                var myIcon = L.icon({
                    //iconUrl: '/bitrix/templates/aspro_max/images/marker.png',
                    iconUrl: '/contacts/pin.png',
                    iconSize: [50, 70],
                });
                var activeIcon = L.icon({
                    iconUrl: '/contacts/pin_active.png',
                    iconSize: [70, 70],
                });
                //if(arr[0][0] != '' && arr[0][1] != '')
                {
                    var map = L.map('contacts_map', {center: [arr[0][0], arr[0][1]],zoom: 15,layers: [grayscale]});
                    var markers = [];

                    for (i in arr)
                    {
                        var point = L.marker([arr[i][0], arr[i][1]], {icon:myIcon});
                        point.addTo(map);
                        markers.push(point);
                    }

                    /* map.fitBounds([
                         [arr[0][0], arr[0][1]],
                         arr
                     ]);*/
                }
                console.log('markers');
                console.log(markers);


                function moveToLocation(latitude, longitude) {
                    map.setView([latitude, longitude], 12);
                }

                /*moveButton.addEventListener('click', function () {
                    moveToLocation(40.7128, -74.0060); // Приклад координат Нью-Йорка
                });*/

            })
        </script>

        <?
        /*<div class="wrapper">
            <h2 class="info-page-title margin-top-0">
                Магазини
            </h2>
            <div class="city-list-block">
                <a href="#" class="city-list-item">
                    Вінниця
                </a>
                <a href="#" class="city-list-item">
                    Вишневе
                </a>
                <a href="#" class="city-list-item">
                    Дніпро
                </a>
                <a href="#" class="city-list-item">
                    Дрогобич
                </a>
                <a href="#" class="city-list-item">
                    Житомир
                </a>
                <a href="#" class="city-list-item">
                    Івано-Франківськ
                </a>
                <a href="#" class="city-list-item">
                    Івано-Франківськ
                </a>
                <a href="#" class="city-list-item">
                    Кам’янець-Подільський
                </a>
                <a href="#" class="city-list-item active">
                    Київ
                </a>
                <a href="#" class="city-list-item">
                    Кривий ріг
                </a>
                <a href="#" class="city-list-item">
                    Луцьк
                </a>
                <a href="#" class="city-list-item">
                    Львів
                </a>
                <a href="#" class="city-list-item">
                    Одеса
                </a>
                <a href="#" class="city-list-item">
                    Полтава
                </a>
                <a href="#" class="city-list-item">
                    Рівне
                </a>
                <a href="#" class="city-list-item">
                    Ужгород
                </a>
                <a href="#" class="city-list-item">
                    Хмельницький
                </a>
                <a href="#" class="city-list-item">
                    Черкаси
                </a>
                <a href="#" class="city-list-item">
                    Чернігів
                </a>
            </div>
            <div class="city-list-tabs" role="tablist">
                <button class="city-list-tab" data-bs-toggle="tab" data-bs-target="#city-map-list" type="button" role="tab" aria-selected="true">
                    Списком
                </button>
                <button class="city-list-tab" data-bs-toggle="tab" data-bs-target="#contacts_map" type="button" role="tab" aria-selected="false">
                    На мапі
                </button>
            </div>
            <div class="city-map-cont tab-content ">
                <div class="city-map-list tab-pane fade show active" id="city-map-list" role="tabpanel"  tabindex="0">
                    <div class="city-map-item">
                        <div class="city-map-item-title">
                            <div class="city-map-info">
                                <div class="city-map-name">
                                    м. Київ
                                </div>
                                <div class="city-map-address">
                                    ТЦ New Way, вул. Архітектора Вербицького, 1 (1й поверх)
                                </div>
                                <div class="city-map-work">
                                    Пн.- Нд.: 10:00 - 21:00
                                </div>
                            </div>
                            <div class="city-map-icon">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25 12.5C25 5.60728 19.3927 0 12.5 0C5.60728 0 0 5.60728 0 12.5C0 19.3927 5.60728 25 12.5 25C19.3927 25 25 19.3927 25 12.5ZM11.7635 16.3615L6.55523 11.1531C6.3521 10.95 6.25 10.6833 6.25 10.4166C6.25 10.15 6.3521 9.8833 6.55523 9.68018C6.9625 9.2729 7.62085 9.2729 8.02812 9.68018L12.5 14.1521L16.9719 9.68023C17.3792 9.27295 18.0375 9.27295 18.4448 9.68023C18.8521 10.0875 18.8521 10.7458 18.4448 11.1531L13.2364 16.3615C12.8292 16.7688 12.1708 16.7688 11.7635 16.3615Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="city-map-item-dropdown">
                            <div class="city-map-item-img-list">
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg1.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg2.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg3.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg4.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="city-map-item">
                        <div class="city-map-item-title">
                            <div class="city-map-info">
                                <div class="city-map-name">
                                    м. Київ
                                </div>
                                <div class="city-map-address">
                                    ТЦ New Way, вул. Архітектора Вербицького, 1 (1й поверх)
                                </div>
                                <div class="city-map-work">
                                    Пн.- Нд.: 10:00 - 21:00
                                </div>
                            </div>
                            <div class="city-map-icon">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25 12.5C25 5.60728 19.3927 0 12.5 0C5.60728 0 0 5.60728 0 12.5C0 19.3927 5.60728 25 12.5 25C19.3927 25 25 19.3927 25 12.5ZM11.7635 16.3615L6.55523 11.1531C6.3521 10.95 6.25 10.6833 6.25 10.4166C6.25 10.15 6.3521 9.8833 6.55523 9.68018C6.9625 9.2729 7.62085 9.2729 8.02812 9.68018L12.5 14.1521L16.9719 9.68023C17.3792 9.27295 18.0375 9.27295 18.4448 9.68023C18.8521 10.0875 18.8521 10.7458 18.4448 11.1531L13.2364 16.3615C12.8292 16.7688 12.1708 16.7688 11.7635 16.3615Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="city-map-item-dropdown">
                            <div class="city-map-item-img-list">
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg1.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg2.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg3.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg4.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="city-map-item">
                        <div class="city-map-item-title">
                            <div class="city-map-info">
                                <div class="city-map-name">
                                    м. Київ
                                </div>
                                <div class="city-map-address">
                                    ТЦ New Way, вул. Архітектора Вербицького, 1 (1й поверх)
                                </div>
                                <div class="city-map-work">
                                    Пн.- Нд.: 10:00 - 21:00
                                </div>
                            </div>
                            <div class="city-map-icon">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25 12.5C25 5.60728 19.3927 0 12.5 0C5.60728 0 0 5.60728 0 12.5C0 19.3927 5.60728 25 12.5 25C19.3927 25 25 19.3927 25 12.5ZM11.7635 16.3615L6.55523 11.1531C6.3521 10.95 6.25 10.6833 6.25 10.4166C6.25 10.15 6.3521 9.8833 6.55523 9.68018C6.9625 9.2729 7.62085 9.2729 8.02812 9.68018L12.5 14.1521L16.9719 9.68023C17.3792 9.27295 18.0375 9.27295 18.4448 9.68023C18.8521 10.0875 18.8521 10.7458 18.4448 11.1531L13.2364 16.3615C12.8292 16.7688 12.1708 16.7688 11.7635 16.3615Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="city-map-item-dropdown">
                            <div class="city-map-item-img-list">
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg1.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg2.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg3.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg4.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="city-map-item">
                        <div class="city-map-item-title">
                            <div class="city-map-info">
                                <div class="city-map-name">
                                    м. Київ
                                </div>
                                <div class="city-map-address">
                                    ТЦ New Way, вул. Архітектора Вербицького, 1 (1й поверх)
                                </div>
                                <div class="city-map-work">
                                    Пн.- Нд.: 10:00 - 21:00
                                </div>
                            </div>
                            <div class="city-map-icon">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25 12.5C25 5.60728 19.3927 0 12.5 0C5.60728 0 0 5.60728 0 12.5C0 19.3927 5.60728 25 12.5 25C19.3927 25 25 19.3927 25 12.5ZM11.7635 16.3615L6.55523 11.1531C6.3521 10.95 6.25 10.6833 6.25 10.4166C6.25 10.15 6.3521 9.8833 6.55523 9.68018C6.9625 9.2729 7.62085 9.2729 8.02812 9.68018L12.5 14.1521L16.9719 9.68023C17.3792 9.27295 18.0375 9.27295 18.4448 9.68023C18.8521 10.0875 18.8521 10.7458 18.4448 11.1531L13.2364 16.3615C12.8292 16.7688 12.1708 16.7688 11.7635 16.3615Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="city-map-item-dropdown">
                            <div class="city-map-item-img-list">
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg1.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg2.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg3.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg4.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="city-map-item">
                        <div class="city-map-item-title">
                            <div class="city-map-info">
                                <div class="city-map-name">
                                    м. Київ
                                </div>
                                <div class="city-map-address">
                                    ТЦ New Way, вул. Архітектора Вербицького, 1 (1й поверх)
                                </div>
                                <div class="city-map-work">
                                    Пн.- Нд.: 10:00 - 21:00
                                </div>
                            </div>
                            <div class="city-map-icon">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25 12.5C25 5.60728 19.3927 0 12.5 0C5.60728 0 0 5.60728 0 12.5C0 19.3927 5.60728 25 12.5 25C19.3927 25 25 19.3927 25 12.5ZM11.7635 16.3615L6.55523 11.1531C6.3521 10.95 6.25 10.6833 6.25 10.4166C6.25 10.15 6.3521 9.8833 6.55523 9.68018C6.9625 9.2729 7.62085 9.2729 8.02812 9.68018L12.5 14.1521L16.9719 9.68023C17.3792 9.27295 18.0375 9.27295 18.4448 9.68023C18.8521 10.0875 18.8521 10.7458 18.4448 11.1531L13.2364 16.3615C12.8292 16.7688 12.1708 16.7688 11.7635 16.3615Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="city-map-item-dropdown">
                            <div class="city-map-item-img-list">
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg1.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg2.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg3.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg4.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="city-map-item">
                        <div class="city-map-item-title">
                            <div class="city-map-info">
                                <div class="city-map-name">
                                    м. Київ
                                </div>
                                <div class="city-map-address">
                                    ТЦ New Way, вул. Архітектора Вербицького, 1 (1й поверх)
                                </div>
                                <div class="city-map-work">
                                    Пн.- Нд.: 10:00 - 21:00
                                </div>
                            </div>
                            <div class="city-map-icon">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25 12.5C25 5.60728 19.3927 0 12.5 0C5.60728 0 0 5.60728 0 12.5C0 19.3927 5.60728 25 12.5 25C19.3927 25 25 19.3927 25 12.5ZM11.7635 16.3615L6.55523 11.1531C6.3521 10.95 6.25 10.6833 6.25 10.4166C6.25 10.15 6.3521 9.8833 6.55523 9.68018C6.9625 9.2729 7.62085 9.2729 8.02812 9.68018L12.5 14.1521L16.9719 9.68023C17.3792 9.27295 18.0375 9.27295 18.4448 9.68023C18.8521 10.0875 18.8521 10.7458 18.4448 11.1531L13.2364 16.3615C12.8292 16.7688 12.1708 16.7688 11.7635 16.3615Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="city-map-item-dropdown">
                            <div class="city-map-item-img-list">
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg1.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg2.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg3.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg4.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="city-map-item">
                        <div class="city-map-item-title">
                            <div class="city-map-info">
                                <div class="city-map-name">
                                    м. Київ
                                </div>
                                <div class="city-map-address">
                                    ТЦ New Way, вул. Архітектора Вербицького, 1 (1й поверх)
                                </div>
                                <div class="city-map-work">
                                    Пн.- Нд.: 10:00 - 21:00
                                </div>
                            </div>
                            <div class="city-map-icon">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25 12.5C25 5.60728 19.3927 0 12.5 0C5.60728 0 0 5.60728 0 12.5C0 19.3927 5.60728 25 12.5 25C19.3927 25 25 19.3927 25 12.5ZM11.7635 16.3615L6.55523 11.1531C6.3521 10.95 6.25 10.6833 6.25 10.4166C6.25 10.15 6.3521 9.8833 6.55523 9.68018C6.9625 9.2729 7.62085 9.2729 8.02812 9.68018L12.5 14.1521L16.9719 9.68023C17.3792 9.27295 18.0375 9.27295 18.4448 9.68023C18.8521 10.0875 18.8521 10.7458 18.4448 11.1531L13.2364 16.3615C12.8292 16.7688 12.1708 16.7688 11.7635 16.3615Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="city-map-item-dropdown">
                            <div class="city-map-item-img-list">
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg1.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg2.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg3.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg4.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="city-map-item">
                        <div class="city-map-item-title">
                            <div class="city-map-info">
                                <div class="city-map-name">
                                    м. Київ
                                </div>
                                <div class="city-map-address">
                                    ТЦ New Way, вул. Архітектора Вербицького, 1 (1й поверх)
                                </div>
                                <div class="city-map-work">
                                    Пн.- Нд.: 10:00 - 21:00
                                </div>
                            </div>
                            <div class="city-map-icon">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25 12.5C25 5.60728 19.3927 0 12.5 0C5.60728 0 0 5.60728 0 12.5C0 19.3927 5.60728 25 12.5 25C19.3927 25 25 19.3927 25 12.5ZM11.7635 16.3615L6.55523 11.1531C6.3521 10.95 6.25 10.6833 6.25 10.4166C6.25 10.15 6.3521 9.8833 6.55523 9.68018C6.9625 9.2729 7.62085 9.2729 8.02812 9.68018L12.5 14.1521L16.9719 9.68023C17.3792 9.27295 18.0375 9.27295 18.4448 9.68023C18.8521 10.0875 18.8521 10.7458 18.4448 11.1531L13.2364 16.3615C12.8292 16.7688 12.1708 16.7688 11.7635 16.3615Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="city-map-item-dropdown">
                            <div class="city-map-item-img-list">
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg1.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg2.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg3.png">
                                </div>
                                <div class="city-map-item-img">
                                    <img src="/bitrix/templates/stimma_new/images/imgnew/citymimg4.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="city-map tab-pane fade" id="contacts_map" id="nav-profile" role="tabpanel" tabindex="0">

                </div>
            </div>
            <div class="work-time-cont">
                <div class="work-time-block">
                    <div class="work-time-title">
                        Інтернет -магазин
                    </div>
                    <div class="work-time-list">
                        <div class="work-time-group">
                            <a href="#" class="work-time-elem">
                                <span class="icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_418_625)">
                                        <path d="M15.5653 11.7424L13.3325 9.50954C12.535 8.71209 11.1794 9.0311 10.8604 10.0678C10.6211 10.7855 9.82369 11.1842 9.10599 11.0247C7.5111 10.626 5.358 8.5526 4.95927 6.87797C4.72004 6.16024 5.19851 5.36279 5.91621 5.12359C6.95289 4.80461 7.27187 3.44895 6.47442 2.65151L4.24157 0.418659C3.60362 -0.139553 2.64668 -0.139553 2.08847 0.418659L0.573324 1.93381C-0.941823 3.5287 0.732813 7.75516 4.48081 11.5032C8.2288 15.2511 12.4553 17.0056 14.0502 15.4106L15.5653 13.8955C16.1235 13.2575 16.1235 12.3006 15.5653 11.7424Z" fill="#1E1E1E"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_418_625">
                                        <rect width="16" height="16" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                0 800 300 068
                            </a>
                            <a href="#" class="work-time-elem">
                                <span class="icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.8583 3.17969L11.0059 8.00091L15.8583 12.8221C15.946 12.6388 15.9993 12.4361 15.9993 12.2197V3.78216C15.9993 3.56569 15.946 3.36303 15.8583 3.17969Z" fill="#1E1E1E"/>
                                        <path d="M14.5947 2.375H1.40716C1.19069 2.375 0.988031 2.42822 0.804688 2.51594L7.00666 8.68666C7.55503 9.23503 8.44678 9.23503 8.99516 8.68666L15.1971 2.51594C15.0138 2.42822 14.8111 2.375 14.5947 2.375Z" fill="#1E1E1E"/>
                                        <path d="M0.140938 3.17969C0.0532188 3.36303 0 3.56569 0 3.78216V12.2197C0 12.4361 0.0532188 12.6388 0.140938 12.8221L4.99341 8.00091L0.140938 3.17969Z" fill="#1E1E1E"/>
                                        <path d="M10.3447 8.66406L9.658 9.35072C8.74428 10.2644 7.2575 10.2644 6.34378 9.35072L5.65716 8.66406L0.804688 13.4853C0.988031 13.573 1.19069 13.6262 1.40716 13.6262H14.5947C14.8111 13.6262 15.0138 13.573 15.1971 13.4853L10.3447 8.66406Z" fill="#1E1E1E"/>
                                    </svg>
                                </span>
                                Stimmacomua@gmail.com
                            </a>
                        </div>
                        <div class="work-time-group">
                            <div class="work-time-elem">
                                пн-пт  09:00 - 18:00
                            </div>
                            <div class="work-time-elem">
                                сб-нд  10:00 - 18:00
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>*/
        ?>


<?}
else
{?>

        <?//use Bitrix\Main\Page\Asset;?>
            <!-- <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/leaflet.css" /> -->
            <link rel="stylesheet" href="/bitrix/templates/aspro_max/components/bitrix/breadcrumb/main/style.css" /> 

            <?php
            \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/css/leaflet.css');
            \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/leaflet.js');

            //Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/leaflet.js');?>


        <?//CMax::ShowPageType('page_contacts');?>
            <div class="top-block-wrapper">
                <section class="intoppage page-top maxwidth-theme ">
                    <div class="topic">
                        <div class="topic__inner">
                            <div class="topic__heading">
                                <h1 id="pagetitle th4">Наші магазини</h1>                    </div>
                        </div>
                    </div>
                    <div id="navigation">
                        <div class="breadcrumbs swipeignore" itemscope="" itemtype="http://schema.org/BreadcrumbList"><div class="breadcrumbs__item" id="bx_breadcrumb_0" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a class="breadcrumbs__link" href="/" title="Головна" itemprop="item"><span itemprop="name" class="breadcrumbs__item-name ">Головна</span><meta itemprop="position" content="1"></a></div><span class="breadcrumbs__separator">/</span><span class="breadcrumbs__item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><link href="/contacts/" itemprop="item"><span><span itemprop="name" class="breadcrumbs__item-name ">Наші магазини</span><meta itemprop="position" content="2"></span></span></div>            </div>
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
                                    <h2 >Інтернет-магазин</h2>
                                    <h2 >Графік роботи</h2>
                                    <p>Понеділок - П'ятниця: 9.00 - 18.00</p>
                                    <p>Субота - Неділя: 10:00 - 18:00</p>
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

                                    if($(this).hasClass('s_section'))
                                    {
                                        $('s_section').removeClass('active');
                                        $(this).addClass('active');
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
                                <div class=" item-shop-detail1  col-md-3 col-sm-6 col-xs-12">
                                    <div class="left_block_store ">
                                        <div class="top_block tb23">
                                            <div class="contacts_img ">
                                                <img data-lazyload="" class=" ls-is-cached lazyloaded" src="<?=$img?>" data-src="/images/contacts_image.jpg">											</div>

                                        </div>
                                        <div class="bottom_block">
                                            <div class="properties clearfix">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="property address">
                                                        <div class="title font_upper muted">Адреса</div>
                                                        <div itemprop="address" class="value darken"><?=$item['PROPERTIES']['NAME_UA']['VALUE']?> <?=$item['PROPERTIES']['ADDRESS_UA']['VALUE']?></div>
                                                    </div>
                                                    <div class="property schedule">
                                                        <div class="title font_upper muted">Графік</div>
                                                        <div class="value darken"><?=$item['PROPERTIES']['SCHEDULE_UA']['~VALUE']?></div>
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

<?
}
?>




<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>