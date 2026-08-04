<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вакансії");
$APPLICATION->SetPageProperty("description", "Модний жіночий одяг від українського виробника ТМ STIMMA. Вакансії");
$APPLICATION->SetPageProperty("title", "Вакансії | Інтернет-магазин STIMMA");


if(isset($_GET['newstimma'])  || NEW_STIMMA)
{

    if($_REQUEST['NAME'] == 'FsbNhnVz') die();

    Bitrix\Main\Diag\Debug::writeToFile($_REQUEST, "spam" , '/___spam_vacancy.txt');


    $cities=[
            1=>'Хмельницький',
            2=>'Київ',
            3=>'Одеса',
            4=>'Львів',
            5=>'Івано-Франківськ',
            6=>'Вінниця',
            7=>'Житомир',
            8=>'Кривий ріг',
            9=>'Дрогобич',
            10=>'Вишневе',
            11=>'Луцьк',
            12=>'Рівне',
            13=>'Чернігів',
            14=>'Кам’янець-Подільський',
            15=>'Стрий',
            16=>'Полтава',
            17=>'Ужгород',
    ];


    if(!empty($_POST))
    {

        if (!check_bitrix_sessid())
        {
            die('Помилка сесії');
        }
        $el=new CIBlockElement;

        if($_POST['WORK_NOT_FORKHM'])
        {
            switch($_POST['WORK_NOT_FORKHM'])
            {
                case 1: $vacancy = 'Продажі'; break;
                case 2: $vacancy = 'Управління магазином'; break;
                case 3: $vacancy = 'Управління регіоном (декілька магазинів)'; break;
                case 4: $vacancy = 'Інше'; break;
            }
        }
        elseif($_POST['WORK_FORKHM'])
        {
            switch($_POST['WORK_FORKHM'])
            {
                case 1: $vacancy = 'Оберіть'; break;
                case 2: $vacancy = 'Продажі в магазині'; break;
                case 3: $vacancy = 'Онлайн продажі'; break;
                case 4: $vacancy = 'Керівництво середньої ланки'; break;
                case 5: $vacancy = 'ТОП-керівництво'; break;
                case 6: $vacancy = 'Маркетинг'; break;
                case 7: $vacancy = 'HR'; break;
                case 8: $vacancy = 'Рекрутинг'; break;
                case 9: $vacancy = 'Виробництво'; break;
                case 10: $vacancy = 'Склад-логістика'; break;
                case 11: $vacancy = 'Пошиття одягу'; break;
                case 12: $vacancy = 'Конструювання одягу'; break;
            }
        }

        $PROPNew1 = [
                'EMAIL'=>$_POST['EMAIL'],
                'PHONE'=>$_POST['PHONE'],
                'CITY'=>$cities[$_POST['CITY']],
                'VACANCY'=>$vacancy,
        ];

        if($_FILES['RESUME'])
            $PROPNew1['FILE'] = $_FILES['RESUME'];

        // додаємо в новинки
        $arLoadProductArrayNew1 = Array(
                "IBLOCK_ID"      => 45,
                "PROPERTY_VALUES"=> $PROPNew1,
                "DETIAL_TEXT"=> $_POST['COMMENT'],
                "NAME"           => $_POST['NAME'],
        );

        $ID = $el->Add($arLoadProductArrayNew1);


        $text = 'Заповнена форма на вакансію<br>';
        $text .= 'Телефон: '.$_POST['PHONE'].'<br>';
        $text .= 'Email: '.$_POST['EMAIL'].'<br>';
        $text .= 'Місто: '.$cities[$_POST['CITY']].'<br>';
        $text .= 'Вакансія: '.$vacancy.'<br>';

        if($_POST['COMMENT'])
            $text .= 'Коментар: '.$_POST['COMMENT'].'<br>';

        $res = CIBlockElement::GetByID($ID)->GetNextElement();
        $fields = $res->GetFields();
        $props = $res->GetProperties();

        $fields = [
                'MY_EMAIL' => 'volodarchukliubov@gmail.com',
            //'MY_EMAIL' => 'company703@gmail.com',
                'TEXT' => $text,
        ];

        if(!$props['FILE']['VALUE'])
            CEvent::SendImmediate('BS_VACANCY_MAIL', 's1', $fields, "Y",105);
        else
            CEvent::SendImmediate('BS_VACANCY_MAIL', 's1', $fields, "Y",105,[$props['FILE']['VALUE']]);

        $send = [
                'pib'=>$_POST['NAME'],
                'email'=>$_POST['EMAIL'],
                'phone'=>$_POST['PHONE'],
                'city'=>$cities[$_POST['CITY']],//$user['LAST_NAME'],
                'line'=>$vacancy . ($_POST['COMMENT'] ? '('.$_POST['COMMENT'].')' : ''),
            //'user_id'=>160831010,
            //'file'=>$phoneValue,
        ];

        if($props['FILE']['VALUE'])
        {
            $send['file_url'] = 'https://www.stimma.com.ua'.CFile::GetPath($props['FILE']['VALUE']);
            $send['file_name'] = 'Завантажити резюме';
        }
        else
        {
            $send['file_url'] = '';
            $send['file_name'] = 'Без файлу';
        }

        $url = 'https://notify.shop/api/v1/tg/ZgmVEdjmwolBk9rpLiNKzHftpN3zeXTIH1pj3Cgo/hook/llhDNFICmKXvk45NTpgqYqKPKMS3Wh0wsIesWUI5';
//\Bitrix\Main\Diag\Debug::writeToFile($send, '_data', 'notify_test.txt');

        $sendData = json_encode( $send );

        $header = [
                'Content-Type: application/json',
            //'Content-Length: 0'
        ];

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $sendData );
        $response = curl_exec( $ch );

        curl_close($ch);

        LocalRedirect('/vacancies/?success=Y');

        die();
    }
    ?>
    <div class="info-page-banner info-page-banner-vacancies">
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
                        Вакансії
                    </span>
                </div>
            </div>
        </div>
        <div class="info-page-banner-content">
            <div class="info-page-banner-img">
                <img src="/bitrix/templates/stimma_new/images/imgnew/vacbanner.png">
            </div>
            <div class="info-page-banner-title-block">
                <h1 class="info-page-banner-title">
                    Вакансії
                </h1>
                <div class="info-page-banner-semititle">
                    Шукаєте місце, де ваші ідеї втілюються в життя, а кар'єрний ріст — це не порожні слова? Приєднуйтесь до команди STIMMA!
                </div>
            </div>
        </div>
    </div>

    <div class="info-page-content cooperation-page">
        <div class="cooperation-content">
            <div class="vacancies-title">
                <b>STIMMA</b> — це більше, ніж бренд одягу, це місце, де мода зустрічається з повсякденністю.
            </div>
            <div class="vacancies-text">
                Наша команда налічує понад 350 професіоналів, що працюють від дизайну до продажу, а наші магазини відкриті у 28 містах і онлайн.<br>
                Ми не просто слідуємо модним тенденціям, ми адаптуємо їх до реального життя, щоб кожна жінка могла відчути себе особливою.
            </div>
            <div class="vacancies-text">
                <p>
                    <b>Бренд заснований у 2010 році.</b> Ми впевнено крокуємо вперед та розширюємо наші горизонти, відкриваючи нові магазини та беручи участь у Kyiv Fashion Week. 
                </p>
                <p>
                    <b>Наша ціль</b> — надихати та підкреслювати унікальність кожної жінки через кожен елемент одягу. Якщо ти хочеш бути частиною чогось 
                </p>
                <p>
                    більшого і впливати на світ моди, долучайся до нас і допоможи нам створювати одяг, що робить жінок по всьому світу впевненими у своїй унікальності та силі. 
                </p>
            </div>
            <div class="vacancies-form-block">
                <div class="vacancies-form">
                    <?
                    if(isset($_GET['success']) && $_GET['success']=='Y')
                        echo '<div style="color:green;font-weight: bold;">Ваша заявка успішно відправлена</div>';
                    ?>
                    <form class="custom-form" id="registraion-page-form2" method="post" action="/vacancies/" name="regform" enctype="multipart/form-data" novalidate="novalidate">
                        <?= bitrix_sessid_post() ?>
                        <div class="form_body">
                            <div class="form-block">
                                <label for="input_NAME"><span>Прізвище, Ім’я, По батькові&nbsp;<span class="star">*</span></span></label> 
                                <input size="30" type="text" id="input_NAME" name="NAME" required="" value="" aria-required="true" class="form-control">
                                <div class="text-block name_text" style="color:red;display:none;">
                                    Це поле обов’язкове для заповнення
                                </div>
                            </div>
                            <div class="form-block">
                                <label for="input_EMAIL"><span>E-mail&nbsp;<span class="star">*</span></span></label> 
                                <input size="30" type="email" id="input_EMAIL" name="EMAIL" required="" value="" aria-required="true" class="form-control">
                                <div class="text-block email_text" style="color:red;display:none;">
                                    Це поле обов’язкове для заповнення
                                </div>
                            </div>
                            <div class="form-block">
                                <label for="input_PERSONAL_PHONE"><span>Телефон&nbsp;<span class="star">*</span></span></label> 
                                <input size="30" type="tel" id="input_PERSONAL_PHONE" name="PHONE" class="phone_input form-control" required="" value="" aria-required="true">
                                <div class="text-block phone_text" style="color:red;display:none;">
                                    Це поле обов’язкове для заповнення
                                </div>
                            </div>
                            <div class="form-block">
                                <label for="input_UF_CITY">Місто, в якому шукаєте роботу<span class="star">*</span></label>
                                <select id="input_UF_CITY" name="CITY" class="form-select">
                                    <?
                                    foreach($cities as $index => $city)
                                    {
                                        ?><option value="<?=$index?>" <?=$index==1?'selected':''?>><?=$city?></option><?
                                    }
                                    ?>
                                </select>
                                <div class="text-block city_text" style="color:red;display:none;">
                                    Це поле обов’язкове для заповнення
                                </div>
                            </div>
                            <div class="form-block" data-for="not_khm" style="display:none;">
                                <label for="input_UF_UGROUP2">Напрямок, в якому цікаво працювати</label>
                                <select id="input_UF_UGROUP2" name="WORK_NOT_FORKHM" class="form-select">
                                    <option value="0">Оберіть</option>
                                    <option value="1">Продажі</option>
                                    <option value="2">Управління магазином</option>
                                    <option value="3">Управління регіоном</option>
                                    <option value="4">Інше</option>
                                </select>
                                <div class="text-block napryam_text" style="color:red;display:none;">
                                    Це поле обов’язкове для заповнення
                                </div>
                            </div>
                            <div class="form-block" data-for="khm">
                                <label for="input_UF_UGROUP3">Напрямок, в якому цікаво працювати</label>
                                <select id="input_UF_UGROUP3" name="WORK_FORKHM" class="form-select">
                                    <option value="0">Оберіть</option>
                                    <option value="1">Продажі в магазині</option>
                                    <option value="2">Онлайн продажі</option>
                                    <option value="3">Керівництво середньої ланки</option>
                                    <option value="4">ТОП-керівництво</option>
                                    <option value="5">Маркетинг</option>
                                    <option value="6">HR</option>
                                    <option value="7">Рекрутинг</option>
                                    <option value="8">Виробництво</option>
                                    <option value="9">Склад-логістика</option>
                                    <option value="10">Пошиття одягу</option>
                                    <option value="11">Конструювання одягу</option>
                                    <option value="12">Інше</option>
                                </select>
                                <div class="text-block napryam_text" style="color:red;display:none;">
                                    Це поле обов’язкове для заповнення
                                </div>
                            </div>
                            <div class="form-block comment" style="display: none;">
                                <label for="input_PASSWORD">Коментар</label>
                                <textarea size="30" name="COMMENT" class="form-control"></textarea>
                            </div>
                            <div class="form-block">
                                <label for="input_PASSWORD">Завантажити резюме</label>
                                <label class="form-file form-control">
                                    <span class="form-file-text">Вибрати файл</span>
                                    <input size="30" type="file" id="input_PASSWORD" name="RESUME" required="" value="" autocomplete="off" class="password" aria-required="true">
                                </label>
                            </div>
                        </div>
                        <div class="form_footer text-center">
                            <button class="info-btn info-btn-black " type="submit" name="register_submit_button1" value="Y">Надіслати</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?}else{

//if(!isset($_SERVER['HTTP_USER_AGENT']))
if($_REQUEST['NAME'] == 'FsbNhnVz') die();

Bitrix\Main\Diag\Debug::writeToFile($_REQUEST, "spam" , '/___spam_vacancy.txt');


$cities=[
    1=>'Хмельницький',
    2=>'Київ',
    3=>'Одеса',
    4=>'Львів',
    5=>'Івано-Франківськ',
    6=>'Вінниця',
    7=>'Житомир',
    8=>'Кривий ріг',
    9=>'Дрогобич',
    10=>'Вишневе',
    11=>'Луцьк',
    12=>'Рівне',
    13=>'Чернігів',
    14=>'Кам’янець-Подільський',
    15=>'Стрий',
    16=>'Полтава',
    17=>'Ужгород',
];


if(!empty($_POST))
{


    $el=new CIBlockElement;

    if($_POST['WORK_NOT_FORKHM'])
    {
        switch($_POST['WORK_NOT_FORKHM'])
        {
            case 1: $vacancy = 'Продажі'; break;
            case 2: $vacancy = 'Управління магазином'; break;
            case 3: $vacancy = 'Управління регіоном (декілька магазинів)'; break;
            case 4: $vacancy = 'Інше'; break;
        }
    }
    elseif($_POST['WORK_FORKHM'])
    {
        switch($_POST['WORK_FORKHM'])
        {
            case 1: $vacancy = 'Оберіть'; break;
            case 2: $vacancy = 'Продажі в магазині'; break;
            case 3: $vacancy = 'Онлайн продажі'; break;
            case 4: $vacancy = 'Керівництво середньої ланки'; break;
            case 5: $vacancy = 'ТОП-керівництво'; break;
            case 6: $vacancy = 'Маркетинг'; break;
            case 7: $vacancy = 'HR'; break;
            case 8: $vacancy = 'Рекрутинг'; break;
            case 9: $vacancy = 'Виробництво'; break;
            case 10: $vacancy = 'Склад-логістика'; break;
            case 11: $vacancy = 'Пошиття одягу'; break;
            case 12: $vacancy = 'Конструювання одягу'; break;
        }
    }

    $PROPNew1 = [
        'EMAIL'=>$_POST['EMAIL'],
        'PHONE'=>$_POST['PHONE'],
        'CITY'=>$cities[$_POST['CITY']],
        'VACANCY'=>$vacancy,
    ];

    if($_FILES['RESUME'])
        $PROPNew1['FILE'] = $_FILES['RESUME'];

    // додаємо в новинки
    $arLoadProductArrayNew1 = Array(
        "IBLOCK_ID"      => 45,
        "PROPERTY_VALUES"=> $PROPNew1,
        "DETIAL_TEXT"=> $_POST['COMMENT'],
        "NAME"           => $_POST['NAME'],
    );

    $ID = $el->Add($arLoadProductArrayNew1);


    $text = 'Заповнена форма на вакансію<br>';
    $text .= 'Телефон: '.$_POST['PHONE'].'<br>';
    $text .= 'Email: '.$_POST['EMAIL'].'<br>';
    $text .= 'Місто: '.$cities[$_POST['CITY']].'<br>';
    $text .= 'Вакансія: '.$vacancy.'<br>';

    if($_POST['COMMENT'])
        $text .= 'Коментар: '.$_POST['COMMENT'].'<br>';

    $res = CIBlockElement::GetByID($ID)->GetNextElement();
    $fields = $res->GetFields();
    $props = $res->GetProperties();

    $fields = [
        'MY_EMAIL' => 'volodarchukliubov@gmail.com',
        //'MY_EMAIL' => 'company703@gmail.com',
        'TEXT' => $text,
    ];

    if(!$props['FILE']['VALUE'])
        CEvent::SendImmediate('BS_VACANCY_MAIL', 's1', $fields, "Y",105);
    else
        CEvent::SendImmediate('BS_VACANCY_MAIL', 's1', $fields, "Y",105,[$props['FILE']['VALUE']]);

    $send = [
        'pib'=>$_POST['NAME'],
        'email'=>$_POST['EMAIL'],
        'phone'=>$_POST['PHONE'],
        'city'=>$cities[$_POST['CITY']],//$user['LAST_NAME'],
        'line'=>$vacancy . ($_POST['COMMENT'] ? '('.$_POST['COMMENT'].')' : ''),
        //'user_id'=>160831010,
        //'file'=>$phoneValue,
    ];

    if($props['FILE']['VALUE'])
    {
        $send['file_url'] = 'https://www.stimma.com.ua'.CFile::GetPath($props['FILE']['VALUE']);
        $send['file_name'] = 'Завантажити резюме';
    }
    else
    {
        $send['file_url'] = '';
        $send['file_name'] = 'Без файлу';
    }

$url = 'https://notify.shop/api/v1/tg/ZgmVEdjmwolBk9rpLiNKzHftpN3zeXTIH1pj3Cgo/hook/llhDNFICmKXvk45NTpgqYqKPKMS3Wh0wsIesWUI5';
//\Bitrix\Main\Diag\Debug::writeToFile($send, '_data', 'notify_test.txt');

$sendData = json_encode( $send );

$header = [
    'Content-Type: application/json',
    //'Content-Length: 0'
];

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );
curl_setopt( $ch, CURLOPT_HEADER, false );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $sendData );
$response = curl_exec( $ch );

curl_close($ch);

LocalRedirect('/vacancies/?success=Y');

die();
}

?>



<?
    ?>
    <div class="info-page">

        <div class="info-page-tabs visible-mob">
             <?/*$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "page_info_menu",
                    array(
                        "COMPONENT_TEMPLATE" => "page_info_menu",
                        "ROOT_MENU_TYPE" => "info_menu",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "",
                        "USE_EXT" => "N",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                    ),
                    false
                );*/?>
            <div class="tab-content" style="max-width: inherit">

                <div class="tab-pane fade active in" id="stab1-b">

                    <article id="post-110700" class="post-110700 page type-page status-publish hentry del-and-pay info-page-small-cont">
                        <?
                        if(isset($_GET['success']) && $_GET['success']=='Y')
                            echo '<div style="color:green;font-weight: bold;">Ваша заявка успішно відправлена</div>';
                        ?>
                        <div class="page-banner-mob">
                            <a href="#">
                                <img src="/bitrix/templates/stimma/images/vacancy-banner-mob.jpg?v=1">
                            </a>
                        </div>
                        <div class="page-banner-desc">
                            <a href="#">
                                <img src="/bitrix/templates/stimma/images/vacancy-banner.jpg?v=1">
                            </a>
                        </div>

                    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_RECURSIVE" => "N",
            "AREA_FILE_SHOW" => "file",
            "EDIT_MODE" => "html",
            "PATH" => "oplata.php"
        ),
    false,
    Array(
        'HIDE_ICONS' => 'N'
    )
    );?>
                        <form class="custom-form" id="registraion-page-form2" method="post" action="/vacancies/" name="regform" enctype="multipart/form-data" novalidate="novalidate" style="margin-top: 20px;">
                            <?= bitrix_sessid_post() ?>
                            <div class="form_body">
                                <div class="form-control">
                                    <label for="input_NAME"><span>Прізвище, Ім’я, По батькові&nbsp;<span class="star">*</span></span></label> <input size="30" type="text" id="input_NAME" name="NAME" required="" value="" aria-required="true">
                                    <div class="text-block name_text" style="color:red;display:none;">
                                        Це поле обов’язкове для заповнення
                                    </div>
                                </div>
                                <div class="form-control">
                                    <label for="input_EMAIL"><span>E-mail&nbsp;<span class="star">*</span></span></label> <input size="30" type="email" id="input_EMAIL" name="EMAIL" required="" value="" aria-required="true">
                                    <div class="text-block email_text" style="color:red;display:none;">
                                        Це поле обов’язкове для заповнення
                                    </div>
                                </div>
                                <div class="form-control">
                                    <label for="input_PERSONAL_PHONE"><span>Телефон&nbsp;<span class="star">*</span></span></label> <input size="30" type="tel" id="input_PERSONAL_PHONE" name="PHONE" class="phone_input " required="" value="" aria-required="true">
                                    <div class="text-block phone_text" style="color:red;display:none;">
                                        Це поле обов’язкове для заповнення
                                    </div>
                                </div>
                                <div class="form-control">
                                    <label for="input_UF_CITY">Місто, в якому шукаєте роботу<span class="star">*</span></label>
                                    <select id="input_UF_CITY" name="CITY" class="form-control">
                                        <?
                                        foreach($cities as $index => $city)
                                        {
                                            ?><option value="<?=$index?>" <?=$index==1?'selected':''?>><?=$city?></option><?
                                        }
                                        ?>
                                    </select>
                                    <div class="text-block city_text" style="color:red;display:none;">
                                        Це поле обов’язкове для заповнення
                                    </div>
                                </div>
                                <div class="form-control" data-for="not_khm" style="display:none;">
                                    <label for="input_UF_UGROUP2">Напрямок, в якому цікаво працювати</label>
                                    <select id="input_UF_UGROUP2" name="WORK_NOT_FORKHM" class="form-control">
                                        <option value="0">Оберіть</option>
                                        <option value="1">Продажі</option>
                                        <option value="2">Управління магазином</option>
                                        <option value="3">Управління регіоном</option>
                                        <option value="4">Інше</option>
                                    </select>
                                    <div class="text-block napryam_text" style="color:red;display:none;">
                                        Це поле обов’язкове для заповнення
                                    </div>
                                </div>
                                <div class="form-control" data-for="khm">
                                    <label for="input_UF_UGROUP3">Напрямок, в якому цікаво працювати</label>
                                    <select id="input_UF_UGROUP3" name="WORK_FORKHM" class="form-control">
                                        <option value="0">Оберіть</option>
                                        <option value="1">Продажі в магазині</option>
                                        <option value="2">Онлайн продажі</option>
                                        <option value="3">Керівництво середньої ланки</option>
                                        <option value="4">ТОП-керівництво</option>
                                        <option value="5">Маркетинг</option>
                                        <option value="6">HR</option>
                                        <option value="7">Рекрутинг</option>
                                        <option value="8">Виробництво</option>
                                        <option value="9">Склад-логістика</option>
                                        <option value="10">Пошиття одягу</option>
                                        <option value="11">Конструювання одягу</option>
                                        <option value="12">Інше</option>
                                    </select>
                                    <div class="text-block napryam_text" style="color:red;display:none;">
                                        Це поле обов’язкове для заповнення
                                    </div>
                                </div>
                                <div class="form-control comment" style="display: none;">
                                    <label for="input_PASSWORD">Коментар</label>
                                    <textarea size="30" name="COMMENT"></textarea>
                                </div>
                                <div class="form-control">
                                    <label for="input_PASSWORD">Завантажити резюме</label>
                                    <input size="30" type="file" id="input_PASSWORD" name="RESUME" required="" value="" autocomplete="off" class="password " aria-required="true">
                                </div>
                            </div>
                            <div class="form_footer text-center">
                                <button class="btn btn-default " type="submit" name="register_submit_button1" value="Y" style="margin-bottom:20px">Надіслати</button>
                            </div>
                        </form>
                    </article>



                </div>
            </div>
        </div>

<?}?>

<script>
    $(document).ready(function()
    {
        $("input[type='tel']").mask("+38(999) 999-9999");
        $(document).on('click','[name=register_submit_button1]',function()
        {
            var NAME = $('#input_NAME').val();
            var EMAIL = $('#input_EMAIL').val();
            var PHONE = $('#input_PERSONAL_PHONE').val();
            var CITY = $('#input_UF_CITY').val();

            error=false;
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            $('.name_text').hide();
            $('.email_text').hide();
            $('.phone_text').hide();
            $('.city_text').hide();
            $('.napryam_text').hide();

            if(NAME=='') {$('.name_text').show();error=true;}
            if(EMAIL=='' || !re.test(String(EMAIL).toLowerCase())) {$('.email_text').show();error=true;}
            if(PHONE=='') {$('.phone_text').show();error=true;}
            if(CITY=='') {$('.city_text').show();error=true;}

            $('.comment').hide();


            if($('#input_UF_UGROUP2').is(':visible') && ($('#input_UF_UGROUP2').val() == '0' || $('#input_UF_UGROUP2').val() == 0))
            {
                error=true;
                $('.napryam_text').show();
            }
            if($('#input_UF_UGROUP3').is(':visible') && ($('#input_UF_UGROUP3').val() == '0' || $('#input_UF_UGROUP3').val() == 0))
            {
                error=true;
                $('.napryam_text').show();
            }

            if(error) return false;
        });

        $(document).on('change','[name=CITY]',function()
        {
            $('[name=WORK_NOT_FORKHM]').val(0);
            $('[name=WORK_FORKHM]').val(0);

            var val = $(this).val();
            console.log(val);
            if(val==1 || val=='1')
            {
                $('[data-for="not_khm"]').hide();
                $('[data-for="khm"]').show();
            }
            else
            {
                $('[data-for="not_khm"]').show();
                $('[data-for="khm"]').hide();
            }
        });

        $(document).on('change','[name=WORK_NOT_FORKHM]',function()
        {
            var val = $(this).val();
            if(val==4||val=='4')
                $('.comment').show();
            else
                $('.comment').hide();
            //$('[name=WORK_FORKHM]').val(0).change();
        });
        $(document).on('change','[name=WORK_FORKHM]',function()
        {
            var val = $(this).val();
            if(val==12||val=='12')
                $('.comment').show();
            else
                $('.comment').hide();
            //$('[name=WORK_NOT_FORKHM]').val(0).change();
        });
    });
</script>


        <?/*<div class="card-main-tabs-mobile">
            <div class="card-tabs-mobile-item info-page-small-cont">
                 <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_RECURSIVE" => "N",
            "AREA_FILE_SHOW" => "file",
            "EDIT_MODE" => "html",
            "PATH" => "oplata.php"
        ),
    false,
    Array(
        'HIDE_ICONS' => 'N'
    )
    );?>



            </div>
        </div>*/?>
<?

?>



</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>