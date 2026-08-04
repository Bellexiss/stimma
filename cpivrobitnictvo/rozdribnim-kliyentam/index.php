<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Умови для роздрібного покупця: Зв&#8217;язатися можна з нашим менеджером в робочий час за телефоном:  0 800 3000 68 (Дзвінки зі всіх операторів України безкоштовно). Ціни на сайті інтернет магазину жіночого одягу СТІММА вказані роздрібні. Замовлення приймаються як від зареєстрованих клієнтів так і гостьові (реєстрація не обов&#8217;язково). Надаються гарантійні умови для покупців згідно законодавства України, про [&hellip;]");
$APPLICATION->SetPageProperty("title", "Роздрібним клієнтам &ndash; STIMM");
$APPLICATION->SetTitle("ДЛЯ РОЗДРІБНИХ КЛІЄНТІВ");

if(isset($_GET['newstimma'])  || NEW_STIMMA)
{
    $ru = LANGUAGE_ID == 'ru' ? '/ru' : '';

    ?>
    <div class="breadcrumbs-cont">
        <div class="wrapper">
            <div class="breadcrumbs-block">
                <a href="<?=$ru?>/" class="breadcrumb-item">
                    STIMMA
                </a>
                <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
                        </svg>
                    </span>
                <span class="breadcrumb-item">
                        Роздрібним клієнтам
                    </span>
            </div>
        </div>
    </div>
    <div class="info-pages-list-cont">
        <div class="wrapper">
            <div class="info-pages-list">
                <a href="<?=$ru?>/pravova-informatsiya/" class="info-page-link">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/infopimg2.png">
                    <div class="info-page-link-title">
                        Угода користувача
                    </div>
                </a>
                <a href="<?=$ru?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/" class="info-page-link">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/infopimg3.png">
                    <div class="info-page-link-title">
                        Співпраця
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="info-page-content cooperation-page">
        <h1 class="info-page-title">
            Роздрібним клієнтам
        </h1>
        <div class="info-page-menu">
            <a href="<?=$ru?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/" class="info-page-menu-item">
                Переваги співпраці
            </a>
            <a href="<?=$ru?>/cpivrobitnictvo/spivpracya-z-optovikami/" class="info-page-menu-item">
                Для оптових клієнтів
            </a>
            <a href="<?=$ru?>/cpivrobitnictvo/rozdribnim-kliyentam/" class="info-page-menu-item active">
                Для роздрібних клієнтів
            </a>
        </div>

            <div class="cooperation-content">
                <div class="cooperation-title">
                    <b>STIMMA - український бренд одягу для жінок та про жінок.</b>
                </div>
                <div class="cooperation-text-block">
                    <div class="cooperation-text-group">
                        Адаптуючи модні тренди до реального життя, наша команда створює сучасний міський гардероб, доступний жінкам з усіх міст України, незалежно від рівня доходів, типу фігури та поглядів на життя.
                    </div>
                    <div class="cooperation-text-group">
                        Колекції STIMMA завжди присвячені жіночій силі, характеру та винахідливості. Створюючи для українських жінок простір для експериментів, для нас залишається важливим аби усі речі поєднувалися між собою та формувалися у капсули для різних випадків життя, а кожен новий дроп був логічним продовженням попереднього. Маючи мережу магазинів по Україні та регулярно оновлюючи колекції, ми робимо ставку на позачасові силуети, невимушену кольорову гаму та любов до деталей.
                    </div>
                    <div class="cooperation-text-group">
                        Бренд був заснований у 2010 році.
                    </div>
                    <div class="cooperation-text-group">
                        <b>
                            Ми гарантуємо: </b>
                        <ul>
                            <li>
                                відправку замовлення протягом 2-5 робочих днів. <a href="#">Детальніше</a> </li>
                            <li>
                                зручний спосіб оплати. <a href="#">Детальніше</a> </li>
                            <li>
                                допомогу персонального менеджера щодо підбору вашого ідеального образу, розміру та фасону </li>
                            <li>
                                стилістичну консультацію </li>
                            <li>
                                обмін та повернення товару у разі виробничого браку (впродовж 14 днів з моменту отримання). <a href="#">Детальніше</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
    </div>
    <?
}
else
{
    ?>
    <style>
        div.container a{color:#8B0000;}
    </style>
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => "clientam.php",
                "AREA_FILE_RECURSIVE" => "N",
                "EDIT_MODE" => "html",
        ),
        false,
        Array('HIDE_ICONS' => 'N')
);?>
    <?
}

?>

    <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>