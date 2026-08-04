<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вакансии");
$APPLICATION->SetPageProperty("description", "Модная женская одежда от украинского производителя ТМ STIMMA. Вакансии");
$APPLICATION->SetPageProperty("title", "Вакансии | Интернет-магазин STIMMA");
if($_REQUEST['NAME'] == 'FsbNhnVz') die();

$cities=[
    1=>'Хмельницк',
    2=>'Киев',
    3=>'Одесса',
    4=>'Львов',
    5=>'Ивано-Франковск',
    6=>'Винница',
    7=>'Житомир',
    8=>'Кривой рог',
    9=>'Дрогобыч',
    10=>'Вишневое',
    11=>'Луцк',
    12=>'Ровно',
    13=>'Чернигов',
    14=>'Камянец-Подольский',
    15=>'Стрый',
    16=>'Полтава',
    17=>'Ужгород',
];


if(!empty($_POST))
{
    if (!check_bitrix_sessid())
    {
        die('Ошибка сессии');
    }
    $el=new CIBlockElement;

    if($_POST['WORK_NOT_FORKHM'])
    {
        switch($_POST['WORK_NOT_FORKHM'])
        {
            case 1: $vacancy = 'Продажи'; break;
            case 2: $vacancy = 'Управление магазином'; break;
            case 3: $vacancy = 'Управление регионом (несколько магазинов)'; break;
            case 4: $vacancy = 'Другое'; break;
        }
    }
    elseif($_POST['WORK_FORKHM'])
    {
        switch($_POST['WORK_FORKHM'])
        {
            case 1: $vacancy = 'Выберите'; break;
            case 2: $vacancy = 'Продажи в магазине'; break;
            case 3: $vacancy = 'Онлайн продажи'; break;
            case 4: $vacancy = 'Управление средней ланкой'; break;
            case 5: $vacancy = 'ТОП-управленец'; break;
            case 6: $vacancy = 'Маркетинг'; break;
            case 7: $vacancy = 'HR'; break;
            case 8: $vacancy = 'Рекрутинг'; break;
            case 9: $vacancy = 'Производство'; break;
            case 10: $vacancy = 'Склад-логистика'; break;
            case 11: $vacancy = 'Шитье одежды'; break;
            case 12: $vacancy = 'Конструрирование одежды'; break;
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
                        Вакансии
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
                    Вакансии
                </h1>
                <div class="info-page-banner-semititle">
                    Ищете место, где ваши идеи воплощаются в жизнь, а карьерный рост — это не пустые слова? Присоединяйтесь к команде STIMMA!
                </div>
            </div>
        </div>
    </div>

    <div class="info-page-content cooperation-page">
        <div class="cooperation-content">
            <div class="vacancies-title">
                <b>STIMMA</b> — это больше, чем бренд одежды, это место, где мода встречается с повседневностью.
            </div>
            <div class="vacancies-text">
                Наша команда насчитывает более 350 профессионалов, работающих от дизайна до продаж, а наши магазины открыты в 28 городах и онлайн.<br>
                Мы не просто следуем модным тенденциям, мы адаптируем их к реальной жизни, чтобы каждая женщина могла почувствовать себя особенной.
            </div>
            <div class="vacancies-text">
                <p>
                    <b>Бренд основан в 2010 году.</b> Мы уверенно движемся вперед и расширяем наши горизонты, открывая новые магазины и принимая участие в Kyiv Fashion Week.
                </p>
                <p>
                    <b>Наша цель</b> — вдохновлять и подчеркивать уникальность каждой женщины через каждый элемент одежды. Если ты хочешь быть частью чего
                </p>
                <p>
                    большего и влиять на мир моды, присоединяйся к нам и помоги нам создавать одежду, которая делает женщин по всему миру уверенными в своей уникальности и силе.
                </p>
            </div>
            <div class="vacancies-form-block">
                <div class="vacancies-form">
                    <?
                    if(isset($_GET['success']) && $_GET['success']=='Y')
                        echo '<div style="color:green;font-weight: bold;">Ваша заявка успешно отправлена</div>';
                    ?>
                    <form class="custom-form" id="registraion-page-form2" method="post" action="/vacancies/" name="regform" enctype="multipart/form-data" novalidate="novalidate">
                        <?= bitrix_sessid_post() ?>
                        <div class="form_body">
                            <div class="form-block">
                                <label for="input_NAME"><span>Фамилия, Имя, Отчество&nbsp;<span class="star">*</span></span></label>
                                <input size="30" type="text" id="input_NAME" name="NAME" required="" value="" aria-required="true" class="form-control">
                                <div class="text-block name_text" style="color:red;display:none;">
                                    Это поле обязательно для заполнения
                                </div>
                            </div>
                            <div class="form-block">
                                <label for="input_EMAIL"><span>E-mail&nbsp;<span class="star">*</span></span></label>
                                <input size="30" type="email" id="input_EMAIL" name="EMAIL" required="" value="" aria-required="true" class="form-control">
                                <div class="text-block email_text" style="color:red;display:none;">
                                    Это поле обязательно для заполнения
                                </div>
                            </div>
                            <div class="form-block">
                                <label for="input_PERSONAL_PHONE"><span>Телефон&nbsp;<span class="star">*</span></span></label>
                                <input size="30" type="tel" id="input_PERSONAL_PHONE" name="PHONE" class="phone_input form-control" required="" value="" aria-required="true">
                                <div class="text-block phone_text" style="color:red;display:none;">
                                    Это поле обязательно для заполнения
                                </div>
                            </div>
                            <div class="form-block">
                                <label for="input_UF_CITY">Город, в котором ищете работу<span class="star">*</span></label>
                                <select id="input_UF_CITY" name="CITY" class="form-select">
                                    <?
                                    foreach($cities as $index => $city)
                                    {
                                        ?><option value="<?=$index?>" <?=$index==1?'selected':''?>><?=$city?></option><?
                                    }
                                    ?>
                                </select>
                                <div class="text-block city_text" style="color:red;display:none;">
                                    Это поле обязательно для заполнения
                                </div>
                            </div>
                            <div class="form-block" data-for="not_khm" style="display:none;">
                                <label for="input_UF_UGROUP2">Направление, в котором интересно работать</label>
                                <select id="input_UF_UGROUP2" name="WORK_NOT_FORKHM" class="form-select">
                                    <option value="0">Выберите</option>
                                    <option value="1">Продажи</option>
                                    <option value="2">Управление магазином</option>
                                    <option value="3">Управление регионом</option>
                                    <option value="4">Другое</option>
                                </select>
                                <div class="text-block napryam_text" style="color:red;display:none;">
                                    Это поле обязательно для заполнения
                                </div>
                            </div>
                            <div class="form-block" data-for="khm">
                                <label for="input_UF_UGROUP3">Направление, в котором интересно работать</label>
                                <select id="input_UF_UGROUP3" name="WORK_FORKHM" class="form-select">
                                    <option value="0">Выберите</option>
                                    <option value="1">Продажи в магазине</option>
                                    <option value="2">Онлайн продажи</option>
                                    <option value="3">Руководство среднего звена</option>
                                    <option value="4">ТОП-руководство</option>
                                    <option value="5">Маркетинг</option>
                                    <option value="6">HR</option>
                                    <option value="7">Рекрутинг</option>
                                    <option value="8">Производство</option>
                                    <option value="9">Склад-логистика</option>
                                    <option value="10">Пошив одежды</option>
                                    <option value="11">Конструирование одежды</option>
                                    <option value="12">Другое</option>
                                </select>
                                <div class="text-block napryam_text" style="color:red;display:none;">
                                    Это поле обязательно для заполнения
                                </div>
                            </div>
                            <div class="form-block comment" style="display: none;">
                                <label for="input_PASSWORD">Комментарий</label>
                                <textarea size="30" name="COMMENT" class="form-control"></textarea>
                            </div>
                            <div class="form-block">
                                <label for="input_PASSWORD">Загрузить резюме</label>
                                <label class="form-file form-control">
                                    <span class="form-file-text">Выбрать файл</span>
                                    <input size="30" type="file" id="input_PASSWORD" name="RESUME" required="" value="" autocomplete="off" class="password" aria-required="true">
                                </label>
                            </div>
                        </div>
                        <div class="form_footer text-center">
                            <button class="info-btn info-btn-black " type="submit" name="register_submit_button1" value="Y">Отправить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>