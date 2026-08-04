<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Условия для Розничного покупателя: Связаться можно с нашим менеджером в рабочее время по телефону: 0 800 3000 68 (Звонки со всех операторов Украины бесплатно). Цены на сайте интернет магазина женской одежды СТИММА указаны розничные. Заказы принимаются как от зарегистрированных клиентов так и гостевые (регистрация не обязательно). Предоставляются гарантийные условия для покупателей согласно законодательства Украины, о [&hellip;]");
$APPLICATION->SetPageProperty("title", "Розничным покупателям &ndash; STIMMA");
$APPLICATION->SetTitle("ДЛЯ РОЗНИЧНЫХ ПОКУПАТЕЛЕЙ");

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
                        Розничным клиентам
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
                        Пользовательское соглашение
                    </div>
                </a>
                <a href="<?=$ru?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/" class="info-page-link">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/infopimg3.png">
                    <div class="info-page-link-title">
                        Розничным клиентам
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="info-page-content cooperation-page">
        <h1 class="info-page-title">
            Розничным клиентам
        </h1>
        <div class="info-page-menu">
            <a href="<?=$ru?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/" class="info-page-menu-item">
                 Преимущества сотрудничества
            </a>
            <a href="<?=$ru?>/cpivrobitnictvo/spivpracya-z-optovikami/" class="info-page-menu-item">
                 Для оптовых клиентов
            </a>
            <a href="<?=$ru?>/cpivrobitnictvo/rozdribnim-kliyentam/" class="info-page-menu-item active">
                 Для розничных клиентов
            </a>
        </div>

        <div class="cooperation-content">
            <div class="cooperation-title">
                STIMMA — украинский бренд одежды для женщин и о женщинах.**
            </div>
            <div class="cooperation-text-block">
                <div class="cooperation-text-group">
                    Адаптируя модные тренды к реальной жизни, наша команда создает современный городской гардероб, доступный женщинам из всех городов Украины независимо от уровня дохода, типа фигуры и взглядов на жизнь.
                </div>
                <div class="cooperation-text-group">
                    Коллекции STIMMA всегда посвящены женской силе, характеру и находчивости. Создавая для украинских женщин пространство для экспериментов, мы считаем важным, чтобы все изделия гармонично сочетались между собой и формировали капсульный гардероб для разных жизненных ситуаций, а каждый новый дроп становился логичным продолжением предыдущего. Имея сеть магазинов по всей Украине и регулярно обновляя коллекции, мы делаем ставку на актуальные вне времени силуэты, естественную цветовую палитру и внимание к деталям.
                </div>
                <div class="cooperation-text-group">
                    Бренд был основан в 2010 году.
                </div>
                <div class="cooperation-text-group">
                    <b>
                        Мы гарантируем:
                    </b>
                    <ul>
                        <li>
                            отправку заказа в течение 2–5 рабочих дней. <a href="#">Подробнее</a>;
                        </li>
                        <li>
                            удобные способы оплаты. <a href="#">Подробнее</a>;
                        </li>
                        <li>
                            помощь персонального менеджера в подборе вашего идеального образа, размера и фасона;
                        </li>
                        <li>
                            консультацию стилиста;
                        </li>
                        <li>
                            обмен и возврат товара в случае обнаружения производственного брака (в течение 14 дней с момента получения). <a href="#">Подробнее</a>.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>