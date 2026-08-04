<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");?>
    <style>.right_block.wide_, .right_block.wide_N{float:none !important;width:100% !important;}.top-block-wrapper{display: none;}#content{padding-top: 0!important;}</style>
<?if(isset($_GET['newstimma'])  || NEW_STIMMA)
    {
        $ru=LANGUAGE_ID=='ru'?'/ru':'';
        ?>

        <div class="info-page-banner sama-sobi-banner">
            <div class="breadcrumbs-cont">
                <div class="wrapper">
                    <div class="breadcrumbs-block">
                        <a href="#" class="breadcrumb-item">
                            STIMMA
                        </a>
                        <span class="breadcrumb-sep">
                            <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"></path>
                            </svg>
                        </span>
                        <span class="breadcrumb-item">
                            Сама собі STIMMA
                        </span>
                    </div>
                </div>
            </div>
            <div class="info-page-banner-content">
                <div class="info-page-banner-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/sss-main-img3.webp">
                    <img class="sama-sobi-img-mob" src="/bitrix/templates/stimma_new/images/imgnew/sss-main-img-mob1.jpg">
                </div>
                <div class="info-page-banner-title-block">
                    <h1 class="info-page-banner-title">
                        Сама собі STIMMA
                    </h1>
                    <div class="info-page-banner-semititle">
                        Персональні знижки, унікальний доступ до ексклюзивних акцій, колекцій і «Шафи для своїх» — відкривай усі бенефіти!
                    </div>
                    <div class="sama-sobi-banner-btn">
                        <a href="<?=$ru?>/catalog/bonusna_shafa/" class="info-btn info-btn-black">
                            Перейти
                            <span class="icon">
                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g >
                                    <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
                                    </g>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="sama-sobi-tutorial-cont sama-sobi-section">
            <div class="wrapper">
                <div class="sama-sobi-block">
                    <div class="sama-sobi-title-block">
                        <div class="sama-sobi-title">
                            Чим більше витрачаєш на шопінг зі STIMMA, тим більше подарунків отримуєш
                        </div>
                    </div>
                    <div class="sama-sobi-tutorial-list">
                        <div class="sama-sobi-tutorial-item">
                            <div class="sama-sobi-tutorial-item-icon">
                                <span class="icon">
                                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="25" cy="25.2227" r="23.75" fill="white"/>
                                        <path d="M8.1235 8.27373C-1.09097 17.5884 -1.04089 32.662 8.27373 41.8765C17.5884 51.091 32.662 51.0409 41.8765 41.7263C51.091 32.4116 51.0409 17.338 41.7263 8.1235C32.4116 -1.09097 17.338 -1.0409 8.1235 8.27373ZM36.5682 20.4428L23.6479 33.5134C22.5461 34.6151 20.7433 34.6151 19.6416 33.5134L19.1408 33.0126L17.6384 31.5102L13.4318 27.3537C12.3301 26.252 12.3301 24.4491 13.4318 23.3474C14.5336 22.2457 16.3364 22.2457 17.4381 23.3474L21.6447 27.5039L32.5619 16.4866C33.6636 15.3849 35.4664 15.3849 36.5682 16.4866C37.6699 17.5383 37.6699 19.3411 36.5682 20.4428Z" fill="#1E1E1E"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="sama-sobi-tutorial-text-block">
                                <div class="sama-sobi-tutorial-item-title">
                                    САМА СОБІ STIMMA має 4 рівні: <br> Зірка, Діва, Ікона Стилю та Богиня
                                </div>
                                <div class="sama-sobi-tutorial-text">
                                    Кожен із них відкриває особливі привілеї та пропозиції. <br>
                                    Для участі достатньо придбати хоча б одну річ і зареєструватися 
                                </div>
                            </div>
                        </div>
                        <div class="sama-sobi-tutorial-item">
                            <div class="sama-sobi-tutorial-item-icon">
                                <span class="icon">
                                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="25" cy="25.2227" r="23.75" fill="white"/>
                                        <path d="M8.1235 8.27373C-1.09097 17.5884 -1.04089 32.662 8.27373 41.8765C17.5884 51.091 32.662 51.0409 41.8765 41.7263C51.091 32.4116 51.0409 17.338 41.7263 8.1235C32.4116 -1.09097 17.338 -1.0409 8.1235 8.27373ZM36.5682 20.4428L23.6479 33.5134C22.5461 34.6151 20.7433 34.6151 19.6416 33.5134L19.1408 33.0126L17.6384 31.5102L13.4318 27.3537C12.3301 26.252 12.3301 24.4491 13.4318 23.3474C14.5336 22.2457 16.3364 22.2457 17.4381 23.3474L21.6447 27.5039L32.5619 16.4866C33.6636 15.3849 35.4664 15.3849 36.5682 16.4866C37.6699 17.5383 37.6699 19.3411 36.5682 20.4428Z" fill="#1E1E1E"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="sama-sobi-tutorial-text-block">
                                <div class="sama-sobi-tutorial-item-title">
                                    Накопичуй стімзи легко, витрачай приємно:<br>
                                    1 витрачена гривня = 1 нарахований стімз
                                </div>
                                <div class="sama-sobi-tutorial-text">
                                    За кожну придбану річ ти будеш отримувати стімзи
                                </div>
                            </div>
                        </div>
                        <div class="sama-sobi-tutorial-item">
                            <div class="sama-sobi-tutorial-item-icon">
                                <span class="icon">
                                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="25" cy="25.2227" r="23.75" fill="white"/>
                                        <path d="M8.1235 8.27373C-1.09097 17.5884 -1.04089 32.662 8.27373 41.8765C17.5884 51.091 32.662 51.0409 41.8765 41.7263C51.091 32.4116 51.0409 17.338 41.7263 8.1235C32.4116 -1.09097 17.338 -1.0409 8.1235 8.27373ZM36.5682 20.4428L23.6479 33.5134C22.5461 34.6151 20.7433 34.6151 19.6416 33.5134L19.1408 33.0126L17.6384 31.5102L13.4318 27.3537C12.3301 26.252 12.3301 24.4491 13.4318 23.3474C14.5336 22.2457 16.3364 22.2457 17.4381 23.3474L21.6447 27.5039L32.5619 16.4866C33.6636 15.3849 35.4664 15.3849 36.5682 16.4866C37.6699 17.5383 37.6699 19.3411 36.5682 20.4428Z" fill="#1E1E1E"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="sama-sobi-tutorial-text-block">
                                <div class="sama-sobi-tutorial-item-title">
                                    Отримуй стімзи за різноманітні активності: <br> Відгуки, підписки, публікації тощо
                                </div>
                                <div class="sama-sobi-tutorial-text">
                                    За стімзи ти можеш отримувати речі із «Шафи для своїх»: <br>
                                    одяг, аксесуари й товари для дому від STIMMA та брендів-партнерів
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sama-sobi-section">
            <div class="wrapper">
                <div class="sama-sobi-block">
                    <div class="sama-sobi-title-block">
                        <div class="sama-sobi-title">
                            Рівні лояльності
                        </div>
                    </div>
                    <div class="sama-sobi-loyalty-cont">
                        <div class="sama-sobi-loyalty-block">
                            <div class="sama-sobi-loyalty-item-block">
                                <div class="sama-sobi-loyalty-item">
                                    <div class="sama-sobi-loyalty-bg">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/loalimg1.jpg">
                                    </div>
                                    <div class="sama-sobi-loyalty-info">
                                        <div class="sama-sobi-loyalty-rang">
                                            <div class="sama-sobi-loyalty-rang-key">
                                                Зірка
                                            </div>
                                            <div class="sama-sobi-loyalty-rang-value">
                                                0 - 4999 ₴*
                                            </div>
                                        </div>
                                        <div class="sama-sobi-loyalty-list">
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Можливість накопичувати та витрачати стімзи
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Участь у челенджах
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Вітальна знижка
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    10%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Знижка до дня народження
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    10%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до обмежених у часі акцій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Безоплатна доставка замовлення від 1500 грн
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до ексклюзивних колаборацій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до лімітованих колекцій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Знижки чи сертифікати на послуги стиліста
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Запрошення на закриті фешн-івенти
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sama-sobi-loyalty-item-block">
                                <div class="sama-sobi-loyalty-item">
                                    <div class="sama-sobi-loyalty-bg">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/loalimg2.jpg">
                                    </div>
                                    <div class="sama-sobi-loyalty-info">
                                        <div class="sama-sobi-loyalty-rang">
                                            <div class="sama-sobi-loyalty-rang-key">
                                                Діва
                                            </div>
                                            <div class="sama-sobi-loyalty-rang-value">
                                                5000 - 9999 ₴*
                                            </div>
                                        </div>
                                        <div class="sama-sobi-loyalty-list">
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Можливість накопичувати та витрачати стімзи
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Участь у челенджах
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Вітальна знижка
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    10%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Знижка до дня народження
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    15%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до обмежених у часі акцій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    речі зі <br> знижкою 10%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Безоплатна доставка замовлення від 1500 грн
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до ексклюзивних колаборацій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до лімітованих колекцій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Знижки чи сертифікати на послуги стиліста
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Запрошення на закриті фешн-івенти
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sama-sobi-loyalty-item-block">
                                <div class="sama-sobi-loyalty-item">
                                    <div class="sama-sobi-loyalty-bg">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/loalimg3.png">
                                    </div>
                                    <div class="sama-sobi-loyalty-info">
                                        <div class="sama-sobi-loyalty-rang">
                                            <div class="sama-sobi-loyalty-rang-key">
                                                Ікона стилю
                                            </div>
                                            <div class="sama-sobi-loyalty-rang-value">
                                                10000–19999 ₴*
                                            </div>
                                        </div>
                                        <div class="sama-sobi-loyalty-list">
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Можливість накопичувати та витрачати стімзи
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Участь у челенджах
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Вітальна знижка
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    10%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Знижка до дня народження
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    18%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до обмежених у часі акцій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    речі зі <br> знижкою 15%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Безоплатна доставка замовлення від 1500 грн
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до ексклюзивних колаборацій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до лімітованих колекцій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Знижки чи сертифікати на послуги стиліста
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Запрошення на закриті фешн-івенти
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sama-sobi-loyalty-item-block">
                                <div class="sama-sobi-loyalty-item">
                                    <div class="sama-sobi-loyalty-bg">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/loalimg4.png">
                                    </div>
                                    <div class="sama-sobi-loyalty-info">
                                        <div class="sama-sobi-loyalty-rang">
                                            <div class="sama-sobi-loyalty-rang-key">
                                                Богиня
                                            </div>
                                            <div class="sama-sobi-loyalty-rang-value">
                                                20000+ ₴*
                                            </div>
                                        </div>
                                        <div class="sama-sobi-loyalty-list">
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Можливість накопичувати та витрачати стімзи
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Участь у челенджах
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Вітальна знижка
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    10%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Знижка до дня народження
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    20%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до обмежених у часі акцій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    речі зі <br> знижкою 20%
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Безоплатна доставка замовлення від 1500 грн
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до ексклюзивних колаборацій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Унікальний доступ до лімітованих колекцій
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Знижки чи сертифікати на послуги стиліста
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="sama-sobi-loyalty-list-item">
                                                <div class="sama-sobi-loyalty-key">
                                                    Запрошення на закриті фешн-івенти
                                                </div>
                                                <div class="sama-sobi-loyalty-value">
                                                    <span class="icon">
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.72012 16C7.33813 16 6.98012 15.8709 6.71748 15.6341L0.462928 9.82163C-0.133881 9.32653 -0.157711 8.48696 0.415136 7.94877C0.964157 7.41059 1.89518 7.3891 2.49199 7.90568L7.07548 10.8549C7.33808 11.0702 7.7439 11.0271 7.95871 10.7689L12.6589 5.64952L17.359 0.53018C17.8365 -0.0511009 18.7675 -0.180228 19.4121 0.271896C20.0567 0.702408 20.1999 1.54198 19.6985 2.12326L14.2941 8.79258L8.88968 15.4619C8.62708 15.7633 8.24509 15.957 7.83926 15.9786C7.79163 16.0001 7.76775 16 7.72012 16Z" fill="currentcolor"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sama-sobi-loyalty-nav">
                            <button class="slider-arrow slider-prev" type="button">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.889 4.14083C13.0622 4.13702 13.2322 4.18722 13.3755 4.28452C13.5188 4.38183 13.6282 4.52143 13.6886 4.6838C13.7489 4.84617 13.7571 5.02327 13.7121 5.19054C13.6671 5.3578 13.5711 5.50682 13.4375 5.61701L8.33821 9.9855L13.4375 14.3524C13.5299 14.4204 13.6074 14.5066 13.6649 14.6059C13.7225 14.7052 13.7589 14.8153 13.7719 14.9292C13.785 15.0432 13.7743 15.1587 13.7407 15.2684C13.7071 15.378 13.6511 15.4796 13.5764 15.5667C13.5017 15.6538 13.4098 15.7244 13.3065 15.7743C13.2032 15.8242 13.0907 15.8523 12.9761 15.8567C12.8614 15.8611 12.7471 15.8419 12.6402 15.8001C12.5334 15.7583 12.4363 15.6949 12.3551 15.6138L6.51692 10.6186C6.42524 10.5404 6.35162 10.4433 6.30114 10.3338C6.25065 10.2244 6.22451 10.1053 6.22451 9.98473C6.22451 9.8642 6.25065 9.74507 6.30114 9.63562C6.35162 9.52618 6.42524 9.42897 6.51692 9.35073L12.3551 4.35075C12.5026 4.21975 12.6918 4.14547 12.889 4.14083Z" fill="currentcolor"/>
                                </svg>
                            </button>
                            <ul class="slider-dots"></ul>
                            <button class="slider-arrow slider-next" type="button">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.11101 4.14083C6.93784 4.13702 6.76779 4.18722 6.62449 4.28452C6.48119 4.38183 6.37177 4.52143 6.31145 4.6838C6.25112 4.84617 6.24288 5.02327 6.28788 5.19054C6.33287 5.3578 6.42886 5.50682 6.56251 5.61701L11.6618 9.9855L6.56251 14.3524C6.47006 14.4204 6.39263 14.5066 6.33508 14.6059C6.27753 14.7052 6.2411 14.8153 6.22806 14.9292C6.21502 15.0432 6.22565 15.1587 6.2593 15.2684C6.29294 15.378 6.34887 15.4796 6.42359 15.5667C6.4983 15.6538 6.59018 15.7244 6.69349 15.7743C6.7968 15.8242 6.90929 15.8523 7.02394 15.8567C7.13859 15.8611 7.25291 15.8419 7.35976 15.8001C7.4666 15.7583 7.56366 15.6949 7.64486 15.6138L13.4831 10.6186C13.5748 10.5404 13.6484 10.4433 13.6989 10.3338C13.7493 10.2244 13.7755 10.1053 13.7755 9.98473C13.7755 9.8642 13.7493 9.74507 13.6989 9.63562C13.6484 9.52618 13.5748 9.42897 13.4831 9.35073L7.64486 4.35075C7.49738 4.21975 7.30821 4.14547 7.11101 4.14083Z" fill="currentcolor"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="sama-sobi-loyalty-ps">
                        *Накопичення дійсне протягом року з моменту першої покупки<br>
                        **Знижка до дня народження діє за 5 днів до та 5 днів після твого свята
                    </div>
                </div>
            </div>
        </div>

        <div class="sama-sobi-section">
            <div class="wrapper">
                <div class="sama-sobi-block">
                    <div class="sama-sobi-title-block">
                        <div class="sama-sobi-title">
                            За що накопичуєте стімзи та на що їх витрачати
                        </div>
                    </div>
                    <div class="sama-sobi-accum-cont">
                        <div class="sama-sobi-accum-item">
                            <div class="sama-sobi-accum-tooltip">
                                <?/*<div class="sama-sobi-accum-tooltip-icon">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12.5" cy="12.5" r="11.75" fill="#FE9D56" stroke="#FE9D56" stroke-width="1.5"/>
                                        <path d="M11.4654 18.9652V10.5342H13.6206V18.9652H11.4654ZM11.3447 6.62036H13.724V8.74105H11.3447V6.62036Z" fill="white"/>
                                    </svg>
                                </div>*/?>
                                <div class="sama-sobi-accum-tooltip-dropdown-cont">
                                    <div class="sama-sobi-accum-tooltip-dropdown">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna 
                                    </div>
                                </div>
                            </div>
                            <div class="sama-sobi-accum-item-img">
                                <img src="/bitrix/templates/stimma_new/images/imgnew/accum1.png">
                            </div>
                            <div class="sama-sobi-accum-text">
                                Купуй товари <br> в магазині
                            </div>
                        </div>
                        <div class="sama-sobi-accum-item">
                            <div class="sama-sobi-accum-tooltip">
                                <?/*<div class="sama-sobi-accum-tooltip-icon">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12.5" cy="12.5" r="11.75" fill="#FE9D56" stroke="#FE9D56" stroke-width="1.5"/>
                                        <path d="M11.4654 18.9652V10.5342H13.6206V18.9652H11.4654ZM11.3447 6.62036H13.724V8.74105H11.3447V6.62036Z" fill="white"/>
                                    </svg>
                                </div>*/?>
                                <div class="sama-sobi-accum-tooltip-dropdown-cont">
                                    <div class="sama-sobi-accum-tooltip-dropdown">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna 
                                    </div>
                                </div>
                            </div>
                            <div class="sama-sobi-accum-item-img">
                                <img src="/bitrix/templates/stimma_new/images/imgnew/accum2.png">
                            </div>
                            <div class="sama-sobi-accum-text">
                                Публікуй луки у своїх <br> соц мережах
                            </div>
                        </div>
                        <div class="sama-sobi-accum-item">
                            <div class="sama-sobi-accum-tooltip">
                                <?/*<div class="sama-sobi-accum-tooltip-icon">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12.5" cy="12.5" r="11.75" fill="#FE9D56" stroke="#FE9D56" stroke-width="1.5"/>
                                        <path d="M11.4654 18.9652V10.5342H13.6206V18.9652H11.4654ZM11.3447 6.62036H13.724V8.74105H11.3447V6.62036Z" fill="white"/>
                                    </svg>
                                </div>*/?>
                                <div class="sama-sobi-accum-tooltip-dropdown-cont">
                                    <div class="sama-sobi-accum-tooltip-dropdown">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna 
                                    </div>
                                </div>
                            </div>
                            <div class="sama-sobi-accum-item-img">
                                <img src="/bitrix/templates/stimma_new/images/imgnew/accum3.png">
                            </div>
                            <div class="sama-sobi-accum-text">
                                Пиши відгуки з фото та хештегом
                                <span class="logo">
                                    <svg width="285" height="50" viewBox="0 0 285 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.916 37L4.14 30.808H1.584V27.928H4.68L6.156 20.404H2.34V17.524H6.66L7.848 11.62H10.98L9.792 17.524H14.328L15.516 11.62H18.648L17.46 17.524H20.016V20.404H16.92L15.444 27.928H19.26V30.808H14.94L13.716 37H10.584L11.808 30.808H7.272L6.048 37H2.916ZM7.812 27.928H12.312L13.788 20.404H9.288L7.812 27.928Z" fill="white"/>
                                        <path d="M59.6301 29.8733C59.6301 31.1872 59.3848 32.3464 58.9033 33.3218C58.4263 34.2836 57.7828 35.1065 56.984 35.7724C56.2123 36.4159 55.3123 36.9384 54.3065 37.3218C53.3592 37.6828 52.3512 37.9653 51.3139 38.1626C50.2924 38.3554 49.2461 38.4832 48.2066 38.5415C47.1918 38.602 46.213 38.6312 45.295 38.6312C42.883 38.6312 40.6127 38.4294 38.5494 38.0325C36.4951 37.6357 34.6478 37.1357 33.0615 36.5415L32.292 36.2523V27.7792L34.0538 28.7545C35.5343 29.5706 37.2511 30.2231 39.1591 30.6872C41.0807 31.1558 43.1687 31.3935 45.3648 31.3935C46.6541 31.3935 47.7071 31.3263 48.4946 31.1962C49.4261 31.0393 49.9391 30.8599 50.2046 30.7366C50.5984 30.555 50.6952 30.4294 50.6974 30.4294C50.7334 30.3733 50.7514 30.3352 50.7582 30.315C50.7491 30.3106 50.7244 30.2836 50.6794 30.2478C50.5151 30.1132 50.1979 29.9115 49.6151 29.7052C49.0684 29.5101 48.4091 29.3262 47.6621 29.1581C46.8768 28.9832 46.0398 28.8061 45.1578 28.6312C44.2577 28.4518 43.333 28.2567 42.3812 28.0505C41.4024 27.8352 40.4417 27.5796 39.5214 27.2904C38.5854 26.9967 37.6831 26.6469 36.8438 26.2523C35.9573 25.8352 35.163 25.3307 34.4858 24.7545C33.7725 24.1446 33.201 23.4271 32.7847 22.6222C32.355 21.7859 32.1367 20.8195 32.1367 19.75C32.1367 18.5303 32.364 17.4473 32.8095 16.5325C33.2482 15.6289 33.8513 14.8487 34.6005 14.2119C35.3228 13.5976 36.1643 13.0953 37.1026 12.7164C37.9869 12.3576 38.9319 12.0751 39.9106 11.8778C40.8669 11.685 41.8479 11.5505 42.8245 11.4787C43.7852 11.407 44.71 11.3711 45.5718 11.3711C46.5236 11.3711 47.5181 11.4204 48.5261 11.5146C49.5229 11.6088 50.5241 11.7433 51.4962 11.9159C52.4569 12.0841 53.4042 12.2836 54.3155 12.5079C55.2155 12.7321 56.0638 12.9697 56.8378 13.2186L57.6591 13.4832V21.7097L55.9535 20.8823C55.544 20.6828 54.9792 20.4473 54.2772 20.185C53.582 19.9249 52.7764 19.6738 51.8854 19.4384C50.9967 19.2029 50.0156 19.0034 48.9694 18.8442C47.9366 18.6872 46.8633 18.6088 45.7788 18.6088C44.899 18.6088 44.1407 18.6357 43.5265 18.6895C42.9235 18.7433 42.4172 18.8128 42.0212 18.8935C41.5824 18.9832 41.3484 19.0706 41.2292 19.1245C41.1909 19.1424 41.1594 19.1581 41.1302 19.1738C41.3147 19.2949 41.6229 19.4541 42.1157 19.62C42.6737 19.8061 43.3352 19.9877 44.0867 20.1558C44.8788 20.333 45.718 20.5146 46.6046 20.7029C47.5068 20.8935 48.4361 21.102 49.3946 21.3285C50.3779 21.5594 51.3432 21.833 52.2634 22.1424C53.2062 22.4563 54.1107 22.8285 54.9477 23.2455C55.8298 23.685 56.6195 24.2097 57.2946 24.8038C58.0056 25.4316 58.5748 26.1648 58.9866 26.9854C59.4141 27.8375 59.6301 28.8083 59.6301 29.8733Z" fill="white"/>
                                        <path d="M98.7689 11.9727V19.4839H88.6797V37.9928H79.8955V19.4839H69.8242V11.9727H98.7689Z" fill="white"/>
                                        <path d="M119.442 11.9727H110.66V37.9928H119.442V11.9727Z" fill="white"/>
                                        <path d="M173.223 11.9727V37.9928H164.475V24.9637L157.565 37.9928H149.985L143.075 24.9637V37.9928H134.293V11.9727H144.9L153.776 28.5489L162.653 11.9727H173.223Z" fill="white"/>
                                        <path d="M227.014 11.9727V37.9928H218.268V24.9637L211.358 37.9928H203.778L196.868 24.9637V37.9928H188.086V11.9727H198.69L207.567 28.5489L216.443 11.9727H227.014Z" fill="white"/>
                                        <path d="M260.226 11.9727H251.637L237.973 37.9928H247.821L250.049 33.5153H261.812L264.042 37.9928H273.888L260.226 11.9727ZM258.376 26.5377H253.527L255.962 21.6677L258.376 26.5377Z" fill="white"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="sama-sobi-accum-item">
                            <div class="sama-sobi-accum-tooltip">
                                <?/*<div class="sama-sobi-accum-tooltip-icon">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12.5" cy="12.5" r="11.75" fill="#FE9D56" stroke="#FE9D56" stroke-width="1.5"/>
                                        <path d="M11.4654 18.9652V10.5342H13.6206V18.9652H11.4654ZM11.3447 6.62036H13.724V8.74105H11.3447V6.62036Z" fill="white"/>
                                    </svg>
                                </div>*/?>
                                <div class="sama-sobi-accum-tooltip-dropdown-cont">
                                    <div class="sama-sobi-accum-tooltip-dropdown">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna 
                                    </div>
                                </div>
                            </div>
                            <div class="sama-sobi-accum-item-img">
                                <img src="/bitrix/templates/stimma_new/images/imgnew/accum4.png">
                            </div>
                            <div class="sama-sobi-accum-text">
                                Приводь подруг у Сама <br> Собі STIMMA
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sama-sobi-section">
            <div class="wrapper">
                <div class="sama-sobi-block">
                    <div class="sama-sobi-title-block">
                        <div class="sama-sobi-title">
                            Витрачаємо на товари за стімзи
                        </div>
                        <div class="sama-sobi-title-btn-block">
                            <a href="<?=$ru?>/catalog/bonusna_shafa/" class="sama-sobi-title-btn">
                                Дивитись все
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
                    <?
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
                            'SECTION_ID' => '1311',
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
                    $params['BLOCK_CLASS']= 'goods-slider-item';
                    $params['WRAP_CLASS']= 'goods-slider goods-slider-sama-sobi';

                    $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section",
                            "main",
                            $params,
                            false
                    );
                    ?>
                    <?/*
                    <div class="goods-slider goods-slider-sama-sobi">
                        <div class="goods-slider-item">
                            <div class="catalog-item catalog-item-stimz">
                                <div class="catalog-item-top">
                                    <div class="catalog-item-img">
                                        <a href="#">
                                            <img src="/bitrix/templates/stimma_new/images/imgnew/scatimg1.jpg">
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
                                                799 <span class="bonus">стімзів</span>
                                                <span class="catalog-item-price-sep">
                                                    |
                                                </span>
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
                            <div class="catalog-item catalog-item-stimz">
                                <div class="catalog-item-top">
                                    <div class="catalog-item-img">
                                        <a href="#">
                                            <img src="/bitrix/templates/stimma_new/images/imgnew/scatimg2.jpg">
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
                                                3 699 <span class="bonus">стімзів</span>
                                                <span class="catalog-item-price-sep">
                                                    |
                                                </span>
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
                            <div class="catalog-item catalog-item-stimz">
                                <div class="catalog-item-top">
                                    <div class="catalog-item-img">
                                        <a href="#">
                                            <img src="/bitrix/templates/stimma_new/images/imgnew/scatimg3.jpg">
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
                                                1 999 <span class="bonus">стімзів</span>
                                                <span class="catalog-item-price-sep">
                                                    |
                                                </span>
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
                            <div class="catalog-item catalog-item-stimz">
                                <div class="catalog-item-top">
                                    <div class="catalog-item-img">
                                        <a href="#">
                                            <img src="/bitrix/templates/stimma_new/images/imgnew/scatimg4.jpg">
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
                                                2 999 <span class="bonus">стімзів</span>
                                                <span class="catalog-item-price-sep">
                                                    |
                                                </span>
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
                        <div class="goods-slider-item">
                            <div class="catalog-item catalog-item-stimz">
                                <div class="catalog-item-top">
                                    <div class="catalog-item-img">
                                        <a href="#">
                                            <img src="/bitrix/templates/stimma_new/images/imgnew/scatimg1.jpg">
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
                                                799 <span class="bonus">стімзів</span>
                                                <span class="catalog-item-price-sep">
                                                    |
                                                </span>
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
                            <div class="catalog-item catalog-item-stimz">
                                <div class="catalog-item-top">
                                    <div class="catalog-item-img">
                                        <a href="#">
                                            <img src="/bitrix/templates/stimma_new/images/imgnew/scatimg2.jpg">
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
                                                3 699 <span class="bonus">стімзів</span>
                                                <span class="catalog-item-price-sep">
                                                    |
                                                </span>
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
                            <div class="catalog-item catalog-item-stimz">
                                <div class="catalog-item-top">
                                    <div class="catalog-item-img">
                                        <a href="#">
                                            <img src="/bitrix/templates/stimma_new/images/imgnew/scatimg3.jpg">
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
                                                1 999 <span class="bonus">стімзів</span>
                                                <span class="catalog-item-price-sep">
                                                    |
                                                </span>
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
                            <div class="catalog-item catalog-item-stimz">
                                <div class="catalog-item-top">
                                    <div class="catalog-item-img">
                                        <a href="#">
                                            <img src="/bitrix/templates/stimma_new/images/imgnew/scatimg4.jpg">
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
                                                2 999 <span class="bonus">стімзів</span>
                                                <span class="catalog-item-price-sep">
                                                    |
                                                </span>
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
                    <div class="sama-sobi-btn-block">
                        <a href="<?=$ru?>/catalog/bonusna_shafa/" class="info-btn">
                            Дивитись все
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

        <div class="sama-sobi-section">
            <div class="wrapper">
                <div class="sama-sobi-block">
                    <div class="sama-sobi-title-block">
                        <div class="sama-sobi-title">
                            Для всіх, хто сама собі STIMMA
                        </div>
                    </div>
                    <div class="sama-sobi-icon-block">
                        <div class="sama-sobi-icon-item">
                            <div class="sama-sobi-icon-img">
                                <svg width="127" height="127" viewBox="0 0 127 127" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="63.5" cy="63.5" r="63.5" fill="#FE9D56"/>
                                    <path d="M87.7564 99.3834H35.2404C34.9239 99.3834 34.6203 99.2576 34.3965 99.0338C34.1726 98.81 34.0469 98.5064 34.0469 98.1898V71.9318C34.0469 71.6153 34.1726 71.3117 34.3965 71.0879C34.6203 70.864 34.9239 70.7383 35.2404 70.7383C35.557 70.7383 35.8606 70.864 36.0844 71.0879C36.3082 71.3117 36.434 71.6153 36.434 71.9318V96.9963H86.5629V71.9318C86.5629 71.6153 86.6886 71.3117 86.9125 71.0879C87.1363 70.864 87.4399 70.7383 87.7564 70.7383C88.073 70.7383 88.3766 70.864 88.6004 71.0879C88.8242 71.3117 88.95 71.6153 88.95 71.9318V98.1898C88.95 98.5064 88.8242 98.81 88.6004 99.0338C88.3766 99.2576 88.073 99.3834 87.7564 99.3834Z" fill="white"/>
                                    <path d="M87.7564 63.5746H35.2404C34.9239 63.5746 34.6203 63.4488 34.3965 63.225C34.1726 63.0012 34.0469 62.6976 34.0469 62.381C34.0469 62.0645 34.1726 61.7609 34.3965 61.5371C34.6203 61.3132 34.9239 61.1875 35.2404 61.1875H87.7564C88.073 61.1875 88.3766 61.3132 88.6004 61.5371C88.8242 61.7609 88.95 62.0645 88.95 62.381C88.95 62.6976 88.8242 63.0012 88.6004 63.225C88.3766 63.4488 88.073 63.5746 87.7564 63.5746Z" fill="white"/>
                                    <path d="M61.4982 99.381C61.1817 99.381 60.8781 99.2552 60.6543 99.0314C60.4304 98.8075 60.3047 98.504 60.3047 98.1874V62.381C60.3047 62.0645 60.4304 61.7609 60.6543 61.5371C60.8781 61.3132 61.1817 61.1875 61.4982 61.1875C61.8148 61.1875 62.1184 61.3132 62.3422 61.5371C62.566 61.7609 62.6918 62.0645 62.6918 62.381V98.1874C62.6918 98.504 62.566 98.8075 62.3422 99.0314C62.1184 99.2552 61.8148 99.381 61.4982 99.381Z" fill="white"/>
                                    <path d="M50.7586 73.123H26.8876C26.6585 73.1227 26.4343 73.0565 26.2418 72.9323C26.0492 72.8081 25.8965 72.6311 25.8019 72.4224C25.7072 72.2137 25.6747 71.9822 25.708 71.7556C25.7414 71.5289 25.8393 71.3166 25.9901 71.1441L34.3449 61.5957C34.4568 61.4676 34.5948 61.365 34.7496 61.2946C34.9044 61.2242 35.0724 61.1877 35.2425 61.1875H61.5005C61.7425 61.1875 61.9788 61.261 62.178 61.3983C62.3773 61.5356 62.5301 61.7303 62.6161 61.9564C62.7022 62.1826 62.7175 62.4296 62.66 62.6647C62.6025 62.8997 62.4749 63.1117 62.2942 63.2726L51.5523 72.821C51.3337 73.0155 51.0512 73.123 50.7586 73.123ZM29.5134 70.7359H50.305L58.3614 63.5746H35.7843L29.5134 70.7359Z" fill="white"/>
                                    <path d="M96.1113 73.123H72.2404C71.9477 73.123 71.6652 73.0155 71.4466 72.821L60.7047 63.2726C60.524 63.1117 60.3964 62.8997 60.3389 62.6647C60.2814 62.4296 60.2967 62.1826 60.3828 61.9564C60.4689 61.7303 60.6217 61.5356 60.8209 61.3983C61.0202 61.261 61.2565 61.1875 61.4984 61.1875H87.7564C87.9266 61.1871 88.0948 61.2234 88.2497 61.2938C88.4046 61.3643 88.5424 61.4672 88.654 61.5957L97.0088 71.1441C97.1596 71.3166 97.2575 71.5289 97.2909 71.7556C97.3242 71.9822 97.2917 72.2138 97.197 72.4224C97.1024 72.6311 96.9497 72.8081 96.7571 72.9323C96.5646 73.0565 96.3404 73.1227 96.1113 73.123ZM72.6939 70.7359H93.4855L87.2193 63.5746H64.6375L72.6939 70.7359Z" fill="white"/>
                                    <path d="M45.9838 59.9987C45.761 59.9999 45.5423 59.9387 45.3525 59.8221C45.1626 59.7054 45.0092 59.538 44.9096 59.3387C38.1625 45.8325 25.8129 45.6762 25.6935 45.6762C25.377 45.6762 25.0734 45.5504 24.8496 45.3266C24.6257 45.1027 24.5 44.7992 24.5 44.4826C24.5 44.1661 24.6257 43.8625 24.8496 43.6386C25.0734 43.4148 25.377 43.2891 25.6935 43.2891C26.2605 43.2891 39.6449 43.4597 47.058 58.2716C47.1492 58.4541 47.1921 58.6569 47.1826 58.8607C47.1731 59.0644 47.1116 59.2623 47.0039 59.4355C46.8961 59.6088 46.7458 59.7515 46.5672 59.8501C46.3887 59.9486 46.1878 59.9998 45.9838 59.9987Z" fill="white"/>
                                    <path d="M77.0171 59.9987C76.8138 59.9986 76.6138 59.9465 76.4362 59.8474C76.2586 59.7483 76.1093 59.6055 76.0024 59.4325C75.8955 59.2595 75.8346 59.062 75.8254 58.8589C75.8163 58.6557 75.8592 58.4536 75.9501 58.2716C83.356 43.4597 96.7405 43.2891 97.3074 43.2891C97.624 43.2891 97.9275 43.4148 98.1514 43.6386C98.3752 43.8625 98.501 44.1661 98.501 44.4826C98.501 44.7992 98.3752 45.1027 98.1514 45.3266C97.9275 45.5504 97.624 45.6762 97.3074 45.6762C96.8001 45.6762 84.8074 45.8886 78.083 59.3387C77.984 59.5367 77.8319 59.7033 77.6437 59.8199C77.4555 59.9365 77.2385 59.9984 77.0171 59.9987Z" fill="white"/>
                                    <path d="M50.7564 52.8326C50.4815 52.8324 50.215 52.7373 50.0021 52.5633C49.7892 52.3893 49.6429 52.1472 49.5879 51.8778C47.3632 40.7552 39.8605 37.3619 39.5418 37.2234C39.3979 37.1615 39.2675 37.0717 39.1583 36.9594C39.049 36.847 38.9629 36.7142 38.9049 36.5686C38.7879 36.2745 38.7924 35.9459 38.9176 35.6551C39.0428 35.3644 39.2784 35.1353 39.5725 35.0182C39.8666 34.9011 40.1952 34.9057 40.4859 35.0309C40.8512 35.1873 49.4459 39.0006 51.9273 51.4099C51.9878 51.7189 51.9238 52.0393 51.7492 52.3013C51.5746 52.5633 51.3036 52.7457 50.9951 52.8088C50.9166 52.8252 50.8366 52.8332 50.7564 52.8326Z" fill="white"/>
                                    <path d="M71.0493 52.8335C70.9691 52.8341 70.8891 52.8261 70.8106 52.8097C70.657 52.7784 70.511 52.7171 70.3811 52.6293C70.2512 52.5416 70.1398 52.4291 70.0533 52.2983C69.9669 52.1676 69.907 52.021 69.8772 51.8671C69.8474 51.7132 69.8482 51.5549 69.8796 51.4013C72.361 38.9884 80.9557 35.1786 81.3209 35.0223C81.6105 34.904 81.9349 34.904 82.2244 35.0225C82.5139 35.1409 82.7453 35.3683 82.8689 35.6556C82.9924 35.9429 82.9983 36.2673 82.8851 36.5589C82.772 36.8505 82.5489 37.086 82.2639 37.2148C81.9261 37.3628 74.4414 40.7632 72.219 51.8692C72.1659 52.1405 72.0202 52.385 71.8069 52.5609C71.5936 52.7368 71.3258 52.8332 71.0493 52.8335Z" fill="white"/>
                                    <path d="M55.4953 44.4784C54.9992 44.4785 54.5169 44.3154 54.1227 44.0141C53.8066 43.779 53.5625 43.4601 53.418 43.0936C53.2735 42.727 53.2344 42.3273 53.3051 41.9397L54.2385 36.8815L50.2676 33.2829C49.9656 33.0148 49.7474 32.6651 49.6392 32.276C49.531 31.8869 49.5374 31.4748 49.6577 31.0892C49.7835 30.6878 50.0226 30.3313 50.3461 30.0624C50.6696 29.7935 51.0638 29.6237 51.4814 29.5734L57.0445 28.8215L59.5152 24.1666C59.7115 23.8131 59.9989 23.5184 60.3475 23.3133C60.6961 23.1082 61.0932 23 61.4976 23C61.9021 23 62.2992 23.1082 62.6478 23.3133C62.9964 23.5184 63.2837 23.8131 63.4801 24.1666L65.9508 28.8215L71.5127 29.5734C71.9305 29.6237 72.3249 29.7934 72.6486 30.0623C72.9723 30.3312 73.2115 30.6877 73.3376 31.0892C73.4579 31.4746 73.4644 31.8865 73.3562 32.2755C73.248 32.6644 73.0297 33.0139 72.7277 33.2818L68.7568 36.8827L69.6901 41.9409C69.7609 42.3285 69.7218 42.7282 69.5773 43.0948C69.4328 43.4613 69.1887 43.7802 68.8726 44.0153C68.5359 44.2728 68.1337 44.4307 67.7118 44.4712C67.2899 44.5117 66.865 44.4332 66.4855 44.2445L61.4499 41.7822L56.5038 44.2397C56.1903 44.3954 55.8453 44.477 55.4953 44.4784ZM52.2727 31.8746L55.9465 35.2046C56.2166 35.4452 56.4203 35.7514 56.5378 36.0936C56.6553 36.4358 56.6826 36.8025 56.6172 37.1584L55.7173 42.0376L60.4915 39.6362C60.8046 39.4848 61.148 39.4061 61.4959 39.4061C61.8437 39.4061 62.1871 39.4848 62.5002 39.6362L67.2672 41.972L66.3804 37.1644C66.3151 36.8086 66.3424 36.442 66.4597 36.0999C66.5769 35.7577 66.7802 35.4514 67.05 35.2105L70.7249 31.8805L65.5629 31.1823C65.2117 31.1373 64.8763 31.0092 64.5844 30.8087C64.2926 30.6082 64.0527 30.341 63.8847 30.0293L61.4976 25.5225L59.1106 30.0293C58.9427 30.3392 58.7037 30.6049 58.4132 30.8045C58.1227 31.0041 57.7891 31.1319 57.4396 31.1775L52.2727 31.8746Z" fill="white"/>
                                    <path d="M37.6271 43.2855C38.2863 43.2855 38.8207 42.7512 38.8207 42.092C38.8207 41.4328 38.2863 40.8984 37.6271 40.8984C36.968 40.8984 36.4336 41.4328 36.4336 42.092C36.4336 42.7512 36.968 43.2855 37.6271 43.2855Z" fill="white"/>
                                    <path d="M91.3381 39.7035C91.9973 39.7035 92.5316 39.1691 92.5316 38.51C92.5316 37.8508 91.9973 37.3164 91.3381 37.3164C90.6789 37.3164 90.1445 37.8508 90.1445 38.51C90.1445 39.1691 90.6789 39.7035 91.3381 39.7035Z" fill="white"/>
                                    <path d="M65.0803 55.223C65.7394 55.223 66.2738 54.6887 66.2738 54.0295C66.2738 53.3703 65.7394 52.8359 65.0803 52.8359C64.4211 52.8359 63.8867 53.3703 63.8867 54.0295C63.8867 54.6887 64.4211 55.223 65.0803 55.223Z" fill="white"/>
                                    <path d="M84.1779 57.6097C84.8371 57.6097 85.3715 57.0754 85.3715 56.4162C85.3715 55.757 84.8371 55.2227 84.1779 55.2227C83.5187 55.2227 82.9844 55.757 82.9844 56.4162C82.9844 57.0754 83.5187 57.6097 84.1779 57.6097Z" fill="white"/>
                                    <path d="M56.7248 49.2543C57.384 49.2543 57.9183 48.7199 57.9183 48.0607C57.9183 47.4016 57.384 46.8672 56.7248 46.8672C56.0656 46.8672 55.5312 47.4016 55.5312 48.0607C55.5312 48.7199 56.0656 49.2543 56.7248 49.2543Z" fill="white"/>
                                    <path d="M40.0139 58.8012C40.673 58.8012 41.2074 58.2668 41.2074 57.6076C41.2074 56.9484 40.673 56.4141 40.0139 56.4141C39.3547 56.4141 38.8203 56.9484 38.8203 57.6076C38.8203 58.2668 39.3547 58.8012 40.0139 58.8012Z" fill="white"/>
                                    <path d="M44.7912 31.348C45.4504 31.348 45.9847 30.8137 45.9847 30.1545C45.9847 29.4953 45.4504 28.9609 44.7912 28.9609C44.132 28.9609 43.5977 29.4953 43.5977 30.1545C43.5977 30.8137 44.132 31.348 44.7912 31.348Z" fill="white"/>
                                    <path d="M77.0139 28.9613C77.673 28.9613 78.2074 28.4269 78.2074 27.7678C78.2074 27.1086 77.673 26.5742 77.0139 26.5742C76.3547 26.5742 75.8203 27.1086 75.8203 27.7678C75.8203 28.4269 76.3547 28.9613 77.0139 28.9613Z" fill="white"/>
                                </svg>
                            </div>
                            <div class="sama-sobi-icon-text-block">
                                <div class="sama-sobi-icon-title">
                                    Ексклюзивна знижка
                                </div>
                                <div class="sama-sobi-icon-text">
                                    10%, 15% або 20% до Дня Народження
                                </div>
                            </div>
                        </div>
                        <div class="sama-sobi-icon-item">
                            <div class="sama-sobi-icon-img">
                                <svg width="127" height="127" viewBox="0 0 127 127" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="63.5" cy="63.5" r="63.5" fill="#FE9D56"/>
                                    <path d="M102.209 55.11C103.424 52.9331 103.776 50.8474 103.254 48.9004C102.566 46.3323 100.024 42.98 91.8359 41.551C85.0427 33.0142 71.7066 31.8087 63.5254 39.2889C57.8796 34.3651 50.4076 32.9691 43.5346 35.5895C42.7765 34.7493 42.2116 33.7314 41.9101 32.6059C41.4919 31.0737 39.3128 31.0745 38.8947 32.6057C38.2247 35.1063 36.2551 37.0758 33.7546 37.7459C32.2226 38.1645 32.2234 40.3435 33.7548 40.7612C34.3186 40.9123 34.8552 41.1294 35.3561 41.4036C32.7478 44.5198 31.1902 48.3441 30.828 52.5599C30.6919 54.1428 30.7232 55.7508 30.921 57.3794C16.3249 69.1455 25.0516 77.8266 41.5909 78.1625C43.8026 80.6829 46.2863 83.1363 48.9517 85.4178C54.1586 89.8749 59.4558 93.1222 63.1213 94.1043C63.3859 94.1753 63.6647 94.1753 63.9292 94.1043C67.5948 93.1222 72.892 89.8747 78.0989 85.4178C83.6155 80.6958 88.3536 75.2371 91.5141 69.9735C92.1319 70.3239 92.7078 70.577 93.204 70.7099C93.4686 70.781 93.7472 70.781 94.0119 70.7099C96.2649 70.1065 100.164 67.0277 102.158 63.575C104.227 59.9914 103.631 57.0162 102.209 55.11ZM100.239 49.7084C100.508 50.7144 100.338 51.8539 99.7343 53.1066C98.6197 52.5945 97.4047 52.4258 96.2248 52.5908C96.003 49.986 95.3201 47.5274 94.235 45.3054C97.6038 46.3076 99.741 47.8518 100.239 49.7084ZM40.4024 36.654C41.1081 37.6666 41.9895 38.5482 43.0022 39.2538C41.9895 39.9595 41.1081 40.8409 40.4024 41.8536C39.6967 40.8409 38.8151 39.9593 37.8026 39.2538C38.8151 38.548 39.6966 37.6666 40.4024 36.654ZM26.812 69.383C26.1989 67.0948 27.9278 64.0479 31.5912 60.8711C32.8359 65.7295 35.6289 70.6463 38.8776 74.8592C32.1277 74.2474 27.5913 72.2919 26.812 69.383ZM76.069 83.0464C71.4695 86.9832 66.7196 89.9782 63.5253 90.9719C58.8386 89.6526 50.2655 83.0089 45.8123 78.1533C46.7886 78.1205 47.7911 78.0673 48.819 77.993C49.6789 77.931 50.3254 77.1835 50.2633 76.3238C50.2013 75.4639 49.4541 74.8135 48.5941 74.8795C46.6522 75.0198 44.7943 75.0787 43.0398 75.0609C34.8093 65.7231 30.117 52.3591 37.7094 43.4534C38.2479 44.1776 38.6548 45.0055 38.8949 45.9016C39.3135 47.4336 41.4925 47.4328 41.9102 45.9015C42.5801 43.4009 44.5497 41.4314 47.0502 40.7615C48.5385 40.3585 48.5953 38.2597 47.1384 37.7726C52.5784 36.6219 58.2106 38.3164 62.4216 42.5276C63.003 43.1321 64.0477 43.1321 64.6291 42.5276C74.8428 32.0543 92.4047 38.8299 93.1463 53.2985C90.9646 52.1239 88.2901 52.2836 86.2389 53.8576C84.0679 55.5234 82.4561 59.068 85.0584 63.5752C85.2534 63.9128 85.4666 64.2468 85.6946 64.5754C80.1899 67.4056 73.6901 69.8604 66.7852 71.7105C65.2939 72.1101 63.7682 72.484 62.2501 72.8223C61.4086 73.0097 60.8785 73.8439 61.066 74.6853C61.2498 75.5327 62.1093 76.0588 62.929 75.8694C71.5182 73.9817 80.7416 70.7444 87.7509 67.0247C88.1468 67.4234 88.5546 67.8012 88.9655 68.1528C85.9773 73.1986 81.4134 78.4719 76.069 83.0464ZM99.4539 62.0143C97.9171 64.6762 95.0549 66.9025 93.6078 67.546C90.7942 66.3708 84.0031 59.7349 88.1391 56.3342C89.4297 55.3638 91.2319 55.3824 92.5041 56.6742C93.1137 57.2839 94.1017 57.2837 94.7117 56.6742C96.1455 55.2401 97.9795 55.4923 99.0767 56.3342C100.302 57.2743 101.044 59.2601 99.4539 62.0143Z" fill="white"/>
                                    <path d="M97.624 87.6951C95.1234 87.0251 93.1539 85.0556 92.4838 82.5549C92.0652 81.0229 89.8862 81.0237 89.4685 82.5551C88.7986 85.0556 86.8291 87.0251 84.3285 87.6951C82.7964 88.1134 82.7972 90.2924 84.3284 90.7104C86.8291 91.3805 88.7986 93.35 89.4685 95.8505C89.8867 97.3827 92.066 97.3819 92.4838 95.8507C93.1539 93.35 95.1234 91.3805 97.6241 90.7104C99.1561 90.2918 99.1553 88.1128 97.624 87.6951ZM90.9762 91.8027C90.2705 90.79 89.3891 89.9084 88.3764 89.2027C89.3891 88.4971 90.2707 87.6156 90.9762 86.6029C91.6818 87.6156 92.5634 88.4972 93.5761 89.2027C92.5634 89.9084 91.6818 90.79 90.9762 91.8027Z" fill="white"/>
                                    <path d="M55.6863 74.0859H55.6853C54.8233 74.0859 54.125 74.7849 54.125 75.6468C54.2074 77.717 57.1653 77.7169 57.2472 75.6468C57.2472 74.7849 56.5483 74.0859 55.6863 74.0859Z" fill="white"/>
                                </svg>
                            </div>
                            <div class="sama-sobi-icon-text-block">
                                <div class="sama-sobi-icon-title">
                                    Безумовна любов  і бездоганний стиль
                                </div>
                                <div class="sama-sobi-icon-text">
                                    бо ти варта усього «най-най»
                                </div>
                            </div>
                        </div>
                        <div class="sama-sobi-icon-item">
                            <div class="sama-sobi-icon-img">
                                <svg width="127" height="127" viewBox="0 0 127 127" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="63.5" cy="63.5" r="63.5" fill="#FE9D56"/>
                                    <g clip-path="url(#clip0_50_849)">
                                    <path d="M101.443 42.2239C101.271 40.295 99.6814 38.8404 97.7448 38.8404H88.1377V37.4246H88.3247C89.6966 37.4246 90.8126 36.3086 90.8126 34.9369V31.4878C90.8126 30.1161 89.6966 29 88.3247 29H60.0486C59.4333 29 58.9346 29.4986 58.9346 30.114C58.9346 30.7294 59.4333 31.228 60.0486 31.228H88.3247C88.4681 31.228 88.5847 31.3444 88.5847 31.4878V34.9369C88.5847 35.0802 88.4681 35.1966 88.3247 35.1966H46.6753C46.5319 35.1966 46.4153 35.0802 46.4153 34.9369V31.4878C46.4153 31.3444 46.5319 31.228 46.6753 31.228H54.8254C55.4406 31.228 55.9394 30.7294 55.9394 30.114C55.9394 29.4986 55.4406 29 54.8254 29H46.6753C45.3034 29 44.1873 30.1161 44.1873 31.4878V34.9369C44.1873 36.3086 45.3034 37.4246 46.6753 37.4246H46.8623V38.8404H37.2552C35.3186 38.8404 33.7286 40.295 33.5566 42.2239C33.534 42.4761 33.0334 48.4802 35.4921 55.13C37.7416 61.2142 42.9025 68.9828 54.7272 72.0315C56.6308 73.5356 58.8045 74.7126 61.1627 75.4753L61.7234 76.4008C62.7832 78.1504 63.3433 80.2187 63.3433 82.382C63.3433 83.7035 63.1327 84.9946 62.7174 86.2189L61.9388 88.5135H59.3482C56.6898 88.5135 54.5269 90.6764 54.5269 93.335V95.6686H50.4725C49.3284 95.6686 48.3975 96.5996 48.3975 97.7437V102.977C48.3975 104.121 49.3284 105.052 50.4725 105.052H84.5276C85.6718 105.052 86.6026 104.121 86.6026 102.977V97.7437C86.6026 96.5996 85.6718 95.6686 84.5276 95.6686H80.4733V93.335C80.4733 90.6764 78.3104 88.5135 75.6519 88.5135H73.0614L72.2828 86.2189C71.8673 84.9947 71.6567 83.7037 71.6567 82.382C71.6567 80.2188 72.2168 78.1505 73.2766 76.4008L73.8373 75.4753C76.1955 74.7126 78.369 73.5357 80.2728 72.0315C92.0975 68.9828 97.2584 61.2142 99.5079 55.13C101.967 48.4802 101.466 42.4762 101.443 42.2239ZM47.2747 59.9474C45.1977 58.0028 43.6064 55.5905 42.5181 52.7153C41.762 50.7176 41.267 48.5485 41.0468 46.2671H46.8623V55.8344C46.8623 57.2424 47.0047 58.6179 47.2747 59.9474ZM37.582 54.3575C35.2953 48.1729 35.7551 42.6537 35.7758 42.4219C35.8446 41.6504 36.4806 41.0686 37.2552 41.0686H46.8623V44.0392H40.9545C40.3527 44.0392 39.7752 44.2943 39.37 44.739C38.9643 45.1843 38.7638 45.7837 38.8198 46.3838C39.0544 48.8974 39.5975 51.2931 40.4344 53.5042C42.0871 57.8707 44.7623 61.2803 48.4242 63.7076C49.1448 65.4467 50.0964 67.0665 51.241 68.5289C43.17 65.1834 39.3689 59.1905 37.582 54.3575ZM84.3746 97.8966V102.824H50.6253V97.8966H84.3746ZM75.6519 90.7415C77.0818 90.7415 78.2453 91.9049 78.2453 93.335V95.6686H56.7548V93.335C56.7548 91.9049 57.9183 90.7415 59.3482 90.7415H75.6519ZM70.173 86.9349L70.7086 88.5135H64.2912L64.827 86.9347C65.3207 85.4793 65.5712 83.9476 65.5712 82.382C65.5712 80.1907 65.0814 78.0752 64.1501 76.1988C65.2408 76.3776 66.3594 76.4721 67.5 76.4721C68.6404 76.4721 69.7592 76.3776 70.8497 76.1988C69.9184 78.0752 69.4287 80.1907 69.4287 82.382C69.4288 83.9477 69.6791 85.4794 70.173 86.9349ZM67.5 74.2439C57.3488 74.2439 49.0903 65.9854 49.0903 55.8344V37.4246H85.9097V55.8344C85.9097 65.9855 77.6512 74.2439 67.5 74.2439ZM97.4182 54.3575C95.6312 59.1906 91.8299 65.1842 83.7585 68.5296C84.9052 67.0646 85.8583 65.4416 86.5795 63.699C89.7238 61.6111 92.1453 58.7991 93.8127 55.278C94.0761 54.722 93.8387 54.0576 93.2827 53.7944C92.7269 53.5312 92.0627 53.7683 91.7992 54.3244C90.7669 56.5044 89.4054 58.3826 87.7244 59.9542C87.9953 58.6226 88.138 57.245 88.138 55.8345V46.2672H93.9535C93.8427 47.4134 93.6585 48.5502 93.4059 49.6475C93.2679 50.2472 93.642 50.8451 94.2417 50.983C94.8407 51.1217 95.4391 50.747 95.5771 50.1473C95.8585 48.9251 96.0613 47.6588 96.1805 46.3838C96.2365 45.7837 96.0359 45.1843 95.6303 44.739C95.2251 44.2943 94.6476 44.0392 94.0458 44.0392H88.138V41.0686H97.7451C98.5197 41.0686 99.1557 41.6504 99.2245 42.422C99.2449 42.6537 99.7047 48.1729 97.4182 54.3575Z" fill="white"/>
                                    <path d="M74.8244 50.6349L71.63 50.1707C71.4908 50.1504 71.3707 50.063 71.3085 49.9371L69.8799 47.0425C69.4294 46.1296 68.5171 45.5625 67.499 45.5625C66.481 45.5625 65.5687 46.1296 65.1182 47.0425L63.6896 49.9371C63.6274 50.0632 63.5072 50.1505 63.368 50.1707L60.1737 50.6349C59.1662 50.7812 58.345 51.4735 58.0304 52.4418C57.7158 53.4101 57.9732 54.4529 58.7022 55.1637L61.0137 57.4166C61.1144 57.5148 61.1603 57.656 61.1365 57.7948L60.5908 60.9763C60.4186 61.9797 60.8234 62.9745 61.647 63.573C62.4705 64.1711 63.542 64.2488 64.4433 63.7751L67.3003 62.273C67.4248 62.2075 67.5733 62.2075 67.6978 62.273L70.5549 63.7751C70.9469 63.9811 71.371 64.0829 71.7928 64.0829C72.3411 64.0829 72.8857 63.911 73.3511 63.5728C74.1747 62.9744 74.5794 61.9794 74.4073 60.9762L73.8616 57.7946C73.8378 57.6559 73.8837 57.5146 73.9844 57.4166L76.296 55.1634C77.025 54.4528 77.2824 53.4098 76.9678 52.4416C76.6533 51.4735 75.8317 50.7812 74.8244 50.6349ZM74.7407 53.5681L72.4291 55.8214C71.8034 56.4314 71.5179 57.3098 71.6655 58.1713L72.2112 61.3529C72.2503 61.5806 72.1215 61.7123 72.0413 61.7707C71.9613 61.8291 71.7961 61.911 71.5916 61.8032L68.7344 60.3011C68.3476 60.0978 67.9232 59.996 67.4989 59.996C67.0745 59.996 66.6502 60.0978 66.2634 60.3011L63.4064 61.8032C63.202 61.9109 63.0368 61.8289 62.9565 61.7707C62.8763 61.7123 62.7476 61.5807 62.7865 61.3529L63.3322 58.1713C63.48 57.3098 63.1946 56.4314 62.5686 55.8212L60.2572 53.5683C60.0917 53.407 60.1183 53.2247 60.149 53.1304C60.1796 53.0361 60.2652 52.873 60.4938 52.8397L63.6881 52.3755C64.5532 52.2497 65.3005 51.7069 65.6872 50.9232L67.1158 48.0286C67.218 47.8214 67.3997 47.7905 67.4987 47.7905C67.5978 47.7905 67.7795 47.8214 67.8817 48.0286L69.3102 50.9232C69.697 51.7069 70.4443 52.2499 71.3093 52.3755L74.5038 52.8397C74.7324 52.873 74.818 53.0361 74.8486 53.1304C74.8795 53.2247 74.9061 53.407 74.7407 53.5681Z" fill="white"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_50_849">
                                    <rect width="86" height="88" fill="white" transform="translate(20.5 14)"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <div class="sama-sobi-icon-text-block">
                                <div class="sama-sobi-icon-title">
                                    Участь у челенджах
                                </div>
                                <div class="sama-sobi-icon-text">
                                    щоб зібрати ще більше стімзів
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="discount-container discount-container-sama-sobi">
            <div class="discount-bg">
                <div class="wrapper">
                    <div class="discount-block">
                        <div class="discount-title">
                            -10% на першу купівлю
                        </div>
                        <div class="discount-text-block">
                            <div class="discount-text-title">
                                Долучайся, щоб якнайшвидше дізнатися про нові речі та акції
                            </div>
                            <div class="discount-text">
                                *Знижка діє один раз та не поширюється на товари з розділу SALE.<br class="br-1000">  Промокод не сумується з іншими акціями.
                            </div>
                        </div>
                        <form>
                            <div class="discount-input-block">
                                <input type="text" name="" placeholder="Ваш E-mail">
                                <button class="discount-input-btn info-btn info-btn-black">
                                    Я з вами
                                    <span class="icon">
                                        <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                            <path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="#FFF7E7"/>
                                            </g>
                                        </svg>
                                    </span>
                                </button>                            
                            </div>               
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?/*
        <div class="instagram-cont">
            <div class="wrapper">
                <div class="instagram-title-block">
                    <div class="instagram-title">
                        Приєднуйтесь до нас у Instagram
                    </div>
                    <div class="instagram-btn-block">
                        <a href="#" class="info-btn">
                            @stimma_official
                        </a>
                    </div>
                </div>
            </div>
            <div class="swiper instagram-foto-slider">
                <div class="swiper-wrapper">
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
                </div>
            </div>
        </div>
        */?>
        <div class="instagram-cont">
            <div class="wrapper">
                <div class="instagram-title-block">
                    <div class="instagram-title">
                        Приєднуйтесь до нас у Instagram
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
                    */?></div>
            </div>
        </div>



<?}else{?>

<?$APPLICATION->IncludeComponent(
	"mycompany:test_element",
	".default",
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"ELEMENT_ID" => "46172",
		"IBLOCK_ID" => "54",
		"IBLOCK_TYPE" => "aspro_max_content",
		"PROPERTY_CODES" => array(
		)
	),
	false
);?>
<div class="sss-info-cont">
	<div class="sss-info-title action-title">
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "page",
                "AREA_FILE_SUFFIX" => "inc_title",
                "EDIT_TEMPLATE" => ""
            )
        );?>
	</div>
	<div class="sss-info-list">
        <?$APPLICATION->IncludeComponent(
	"mycompany:test_element", 
	"info_item", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "info_item",
		"ELEMENT_ID" => "46173",
		"IBLOCK_ID" => "54",
		"IBLOCK_TYPE" => "aspro_max_content",
		"PROPERTY_CODES" => array(
			0 => "ICON_CSV",
		)
	),
	false
);?>

        <?$APPLICATION->IncludeComponent(
            "mycompany:test_element",
            "info_item",
            array(
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "COMPONENT_TEMPLATE" => "info_item",
                "ELEMENT_ID" => "46174",
                "IBLOCK_ID" => "54",
                "IBLOCK_TYPE" => "aspro_max_content",
                "PROPERTY_CODES" => array(
                    0 => "ICON_CSV",
                )
            ),
            false
        );?>
        <?$APPLICATION->IncludeComponent(
            "mycompany:test_element",
            "info_item",
            array(
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "COMPONENT_TEMPLATE" => "info_item",
                "ELEMENT_ID" => "46175",
                "IBLOCK_ID" => "54",
                "IBLOCK_TYPE" => "aspro_max_content",
                "PROPERTY_CODES" => array(
                    0 => "ICON_CSV",
                )
            ),
            false
        );?>
	</div>
</div>

<?$APPLICATION->IncludeComponent(
	"mycompany:section_with_items", 
	".default", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"SECTION_ID" => "1308",
		"IBLOCK_ID" => "54",
		"IBLOCK_TYPE" => "aspro_max_content",
		"PROPERTY_CODES" => array(
			0 => "",
			1 => "DIAPAZON_PRICE",
			2 => "BONUS_POINTS",
			3 => "CHALLENGES_PARTICIPATION",
			4 => "WELCOME_DISCOUNT",
			5 => "BIRTHDAY_DISCOUNT",
			6 => "LIMITED_TIME_PROMOS",
			7 => "FREE_DELIVERY_FROM_1500",
			8 => "EXCLUSIVE_COLLAB_ACCESS",
			9 => "LIMITED_COLLECTION_ACCESS",
			10 => "STYLIST_DISCOUNTS_OR_CERTS",
			11 => "FASHION_EVENT_INVITES",
		)
	),
	false
);?>

<?$APPLICATION->IncludeComponent(
    "mycompany:section_with_items",
    "action_bonus",
    array(
        "SECTION_NAME" => "За що накопичуєте бонуси та на що їх витрачати",
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => ".default",
        "SECTION_ID" => "1309",
        "IBLOCK_ID" => "54",
        "IBLOCK_TYPE" => "aspro_max_content",
        "PROPERTY_CODES" => array(
            0 => "",
        )
    ),
    false
);?>
<?
$res = CIBlockElement::GetList(['SORT'=>'asc'],['IBLOCK_ID' => 41,'ACTIVE' => 'Y','ACTIVE_DATE'=>'Y']);
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
//NEW_IN_BLOCK
$newDB = CIBlockElement::GetList([],['IBLOCK_ID'=>21,/*'SECTION_ID'=>350,*/'>SORT' => 0,'!PREVIEW_PICTURE' => false,'INCLUDE_SUBSECTIONS'=>'Y','ACTIVE'=>'Y','!PROPERTY_NEW_IN_BLOCK'=>false],false,['nTopCount'=>4]);
while ($record = $newDB->Fetch())
{
    $new[$record['ID']] = $record['ID'];
    //$products[$record['ID']] = $record['ID'];
}


{
    $jinDB = CIBlockElement::GetList(['rand'=>'asc'],['IBLOCK_ID'=>21,'SECTION_ID'=>1311,'>SORT' => 0,'!PREVIEW_PICTURE' => false,'ACTIVE'=>'Y'],false,['nTopCount'=>8]);
    while ($record = $jinDB->Fetch())
    {
        $jin[$record['ID']] = $record['ID'];
        $products[$record['ID']] = $record['ID'];
    }
}

$params = [
    /*'NEW' => $new,*/
    'SECTION_NAME' => 'Витрачай накопичені бонуси на товари',
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

<?
$bIndex = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false) || isset($_GET['me']);
$MAX_SMART_FILTER = ['ID' => $products];

$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    'sama_sobi',
    $params,
    false
);
unset($MAX_SMART_FILTER['!ID']);
?>
<?$APPLICATION->IncludeComponent(
    "mycompany:section_with_items",
    "sama_sobi_stimma",
    array(
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => ".default",
        "SECTION_ID" => "1310",
        "IBLOCK_ID" => "54",
        "IBLOCK_TYPE" => "aspro_max_content",
        "PROPERTY_CODES" => array(
            0 => "ICON_CSV",
        )
    ),
    false
);?>
    <?/* <div class="action-form-cont" >
        <form class="action-form-block">
            <div class="action-form-title">
                -10% знижки на першу купівлю** за підписку на розсилку
            </div>
            <div class="action-form-text">
                <p>
                    Долучайся, щоб якнайшвидше дізнаватися про нові речі та акції
                </p>
                <p class="light">
                    ** Знижка є одноразовою та діє лише на новинки (товари з чорними цінниками). Промокод не поєднується з іншими акціями та може не розповсюджуватися на деякі товари. Деталі за посиланням:
                </p>
            </div>
            <div class="action-form-email">
                <input type="text" name="" placeholder="Ваш E-mail">
                <button>Я з вами</button>
            </div>
        </form>
        <div class="action-form-block">
            <div class="action-form-title">
                САМА СОБІ STIMMA
            </div>
            <div class="action-form-text">
                <p>
                    Реєструйся, щоб заощаджувати й отримувати усі плюси
                </p>
            </div>
            <div class="action-form-btn">
                <a href="#">
                    Хочу дізнатися
                </a>
            </div>
        </div>
    </div>*/?>

<?}?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");