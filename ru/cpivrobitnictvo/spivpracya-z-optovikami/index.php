<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Модная женская одежда от украинского производителя TM STIMMA. Для оптовых клиентов");
$APPLICATION->SetPageProperty("title", "Для оптовых клиентов | Интернет-магазин STIMMA");
$APPLICATION->SetTitle("ДЛЯ ОПТОВЫХ КЛИЕНТОВ");

$uGroups = $USER->GetUserGroupArray();
$ru=LANGUAGE_ID=='ru'?'/ru':'';
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
                        Для оптовых клиентов
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
                        Сотрудничество с оптовыми покупателями
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="info-page-content cooperation-page">
        <h1 class="info-page-title">
            Сотрудничество с оптовыми покупателями
        </h1>
        <div class="info-page-menu">
            <a href="<?=$ru?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/" class="info-page-menu-item">
                Преимущества сотрудничества
            </a>
            <a href="<?=$ru?>/cpivrobitnictvo/spivpracya-z-optovikami/" class="info-page-menu-item active">
                Для оптовых клиентов
            </a>
            <a href="<?=$ru?>/cpivrobitnictvo/rozdribnim-kliyentam/" class="info-page-menu-item">
                Для розничных клиентов
            </a>
        </div>
        <div class="cooperation-content">
            <div class="cooperation-title">
                <b>Мы сотрудничаем с оптовыми клиентами, которые уже ведут действующий бизнес.</b>
            </div>
            <div class="cooperation-text-block">
                <div class="cooperation-text-group">
                    <p>
                        <b>
                            Мы предлагаем:
                        </b>
                    </p>
                    <ul>
                        <li>
                            широкий ассортимент женской одежды;
                        </li>
                        <li>
                            коллекции, представленные капсулами, изделия из которых гармонично сочетаются между собой;
                        </li>
                        <li>
                            различные стилистические направления: от спортивного до casual, от делового до более женственного и романтичного;
                        </li>
                        <li>
                            еженедельное обновление ассортимента;
                        </li>
                        <li>
                            высокую скорость производства одежды без ущерба для качества и дизайна изделий. Наш бренд выпускает около 1000 новых моделей одежды в год, каждая из которых представлена в нескольких цветах.
                        </li>
                    </ul>
                    <b>Минимальная сумма оптового заказа — 15 000 грн.</b>
                </div>
                <div class="cooperation-text-group">
                    <p>
                        <b>
                            Мы гарантируем:
                        </b>
                    </p>
                    <ul>
                        <li>
                            предоставление официальных документов (при необходимости);
                        </li>
                        <li>
                            обмен или возврат товара при обнаружении производственного брака в течение 14 дней (при условии сохранения фирменной бирки).
                        </li>
                    </ul>
                </div>
                <div class="cooperation-text-group">
                    <p>
                        <b>
                            Важно:
                        </b>

                    </p>
                    <ul>
                        <li>
                            обязательное соблюдение рекомендованной розничной цены — цена продажи не должна быть ниже розничной стоимости, указанной на нашем сайте;
                        </li>
                        <li>
                            запрещено использовать фотографии с официального сайта или Instagram для собственного интернет-контента.
                        </li>
                    </ul>
                </div>
                <div class="cooperation-text-group">
                    <b>*На сайте указаны розничные цены.</b> Зарегистрируйтесь и выберите статус «Оптовый клиент». После подтверждения статуса нашим менеджером вам станут доступны оптовые цены.
                </div>
                <div class="cooperation-text-group">
                    Зарегистрируйтесь и получите коммерческое предложение о сотрудничестве с украинским производителем одежды Stimma. После регистрации и подтверждения статуса нашим менеджером вы получите доступ к оптовым ценам в нашем каталоге, а также сможете получать специальные предложения для оптовых партнёров.
                </div>
                <div class="cooperation-form">
                    <form id="registraion-page-form2" method="post" action="/auth/registration/?register=yes&amp;backurl=%2F" name="regform" enctype="multipart/form-data" novalidate="novalidate">
                        <input type="hidden" name="url" value="<?=$APPLICATION->GetCurPage()?>">
                        <input type="hidden" name="backurl" value="/"> <input type="hidden" name="register_submit_button" value="reg">
                        <div class="form_body">
                            <input size="30" id="input_LOGIN" type="hidden" value="1" name="REGISTER[LOGIN]" aria-required="true">
                            <div class="form-block">
                                <label for="input_NAME"><span>Фамилия Имя Отчество<span class="star">*</span></span></label>
                                <input size="30" type="text" id="input_NAME" name="REGISTER[NAME]" required="" value="" aria-required="true" class="form-control">
                            </div>
                            <div class="form-block">
                                <label for="input_EMAIL"><span>Логин / E-mail&nbsp;<span class="star">*</span></span></label>
                                <input size="30" type="email" id="input_EMAIL" name="REGISTER[EMAIL]" required="" value="" aria-required="true" class="form-control">
                            </div>
                            <div class="form-block">
                                <label for="input_PERSONAL_PHONE"><span>Телефон&nbsp;<span class="star">*</span></span></label>
                                <input size="30" type="tel" id="input_PERSONAL_PHONE" name="REGISTER[PERSONAL_PHONE]" class="phone_input form-control" required="" value="" aria-required="true">
                            </div>
                            <div class="form-block" style="display:none;">
                                <label for="input_UF_UGROUP">Способ сотрудничества&nbsp;</label>
                                <div class="ik_select common_select" style="position: relative; display: inline-block; width: auto; vertical-align: top;">
                                    <div class="ik_select_link common_select-link">
                                        <span class="ik_select_link_text">Розничный клиент</span>
                                        <div class="trigger">
                                        </div>
                                    </div>
                                    <div class="ik_select_dropdown common_select-dd" style="position: absolute; z-index: 9998; width: 18px; display: none;">
                                        <div class="ik_select_list" style="position: relative;">
                                            <div class="ik_select_list_inner" style="height: auto;">
                                                <ul>
                                                    <li class="ik_select_option" title="undefined" data-value="25"><span class="ik_select_option_label" title="undefined">Роздрібний клієнт</span></li>
                                                    <li class="ik_select_option" title="undefined" data-value="26"><span class="ik_select_option_label" title="undefined">Оптовий клієнт</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <select id="input_UF_UGROUP" name="REGISTER[UF_UGROUP]" style="position: absolute; margin: 0px; padding: 0px; top: 0px; left: -9999px;">
                                        <option value="25">Розничный клиент</option>
                                        <option value="26" selected="">Оптовый клиент</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-block">
                                <label for="input_PASSWORD"><span>Пароль&nbsp;<span class="star">*</span></span></label>
                                <input size="30" type="password" id="input_PASSWORD" name="REGISTER[PASSWORD]" required="" value="" autocomplete="off" class="password form-control" aria-required="true">
                                <div class="text-block">
                                    Длина пароля не менее 6 символов
                                </div>
                            </div>
                            <div class="form-block">
                                <label for="input_CONFIRM_PASSWORD"><span>Подтверждение пароля&nbsp;<span class="star">*</span></span></label>
                                <input size="30" type="password" id="input_CONFIRM_PASSWORD" name="REGISTER[CONFIRM_PASSWORD]" required="" value="" autocomplete="off" class="confirm_password form-control" aria-required="true" >
                            </div>

                        </div>
                        <div class="form_footer">
                            <div class="licence_block filter label_block">
                                <input type="checkbox" id="licenses_register" name="licenses_register" checked="" required="" value="Y" aria-required="true">
                                <label for="licenses_register">
                                    Я соглашаюсь на <a href="/ru/pravova-informatsiya/" target="_blank">обработку персональных данных</a>
                                </label>
                            </div>
                            <button class="info-btn info-btn-black" type="submit" name="register_submit_button1" value="Y">Зарегистрироваться</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>