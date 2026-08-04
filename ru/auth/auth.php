<?
if(!empty($_POST))
{
    global $DB,$USER;
    if(isset($_POST['ENTER']))
    {
        $phoneNumber = \Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($_POST['CLIENT']['LOGIN']);
        $user=$DB->Query('select * from b_user where LOGIN = \''.$_POST['CLIENT']['LOGIN'].'\' or EMAIL = \''.$_POST['CLIENT']['LOGIN'].'\' or PERSONAL_PHONE = \''.$phoneNumber.'\'')->Fetch();

        if(isset($user['ID']))
        {
            $_POST['CLIENT']['PASSWORD'] = trim($_POST['CLIENT']['PASSWORD']);

            $remember = isset($_POST['remember_me']) ? 'Y' : 'N';
            $arAuthResult = $USER->Login($user['LOGIN'], $_POST['CLIENT']['PASSWORD'], $remember);
            if($arAuthResult['TYPE'] != 'ERROR')
                LocalRedirect($APPLICATION->GetCurPageParam());
            else
            {
                $user=CUser::GetByID($user['ID'])->Fetch();

                if($user['UF_PHONE_CODE'] == $_POST['CLIENT']['PASSWORD'])
                {
                    $USER->Authorize($user['ID']);
                    LocalRedirect($APPLICATION->GetCurPageParam());
                    exit();
                }
            }
        }
    }

    if(isset($_POST['REGISTER_ME']))
    {
        $_POST['CLIENT_NEW']['PASSWORD']=trim($_POST['CLIENT_NEW']['PASSWORD']);
        $_POST['CLIENT_NEW']['REPEAT_PASSWORD']=trim($_POST['CLIENT_NEW']['REPEAT_PASSWORD']);

        $login = $_POST['CLIENT_NEW']['PERSONAL_PHONE'];
        $name = $_POST['CLIENT_NEW']['NAME'];
        $last_name = $_POST['CLIENT_NEW']['LAST_NAME'];
        $password = $_POST['CLIENT_NEW']['PASSWORD'];
        $confirmPassword = $_POST['CLIENT_NEW']['REPEAT_PASSWORD'];
        $email = $_POST['CLIENT_NEW']['EMAIL'];

        $arResult = $USER->Register($login, $name, $last_name, $password, $confirmPassword, $email);

        $uadd = new CUser;
        if($arResult>0)
        {
            if($_POST['CLIENT_NEW']['UF_UGROUP'] == 26)
                $uadd->Update($arResult, ['UF_UGROUP' => 26]);

            LocalRedirect($APPLICATION->GetCurPageParam('status=ok',['status']));
            exit();
        }
    }
}
?>

<div class="wrapper">
    <div class="auth-page">
        <div class="auth-tabs-cont">
            <a href="#" class="auth-link auth <?=isset($_POST['REGISTER_ME']) ? '' : 'active'?>">
                ВХОД
            </a>
            <a href="#" class="auth-link register <?=isset($_POST['REGISTER_ME']) ? 'active' : ''?>">
                РЕГИСТРАЦИЯ
            </a>
        </div>
        <div class="auth-form-cont">
            <?
            if($arAuthResult['TYPE'] == 'ERROR')
            {
                ?><div style="color: red; text-align: center; margin-bottom: 15px;" class="error_message"><?=$arAuthResult['MESSAGE']?></div><?
            }
            if($arResult['TYPE'] == 'ERROR')
            {
                ?><div style="color: red; text-align: center; margin-bottom: 15px;" class="error_message"><?=$arResult['MESSAGE']?></div><?
            }
            if(isset($_GET['status']) && $_GET['status']== 'ok')
            {
                ?><div style="color: green; text-align: center; margin-bottom: 15px;" class="error_message">
                    <?=LANGUAGE_ID=='ua'?'Ви успішно зареєструвалися':'Вы успешно зарегистрировались'?>
                </div><?
            }
            ?>
            <form action="<?=$APPLICATION->GetCurPageParam()?>" method="post">
                <div class="auth-form auth_form" style="<?=isset($_POST['REGISTER_ME']) ? 'display: none;' : ''?>">
                    <div class="auth-inputs">
                        <div class="auth-inputs-group">
                            <div class="form-block">
                                <input size="30" type="text" name="CLIENT[LOGIN]" value="" class="form-control" placeholder="Ваш E-mail / Телефон">
                            </div>
                            <div class="form-block">
                                <div class="password-input">
                                    <input size="30" type="text" name="CLIENT[PASSWORD]" value="" class="form-control" placeholder="Пароль">
                                    <div class="password-swap">
                                        <svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="#999999"/>
                                            <path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="#999999"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="licence_block filter label_block">
                            <input type="checkbox" id="remember_me" name="remember_me" >
                            <label for="remember_me">
                                Запомнить меня
                            </label>
                        </div>
                    </div>
                    <div class="auth-btn-block">
                        <button class="info-btn info-btn-black" name="ENTER">
                            Войти
                        </button>
                    </div>
                    <div class="auth-forgot-pass">
                        <a href="/auth/forgot/">
                            Забыли пароль?
                        </a>
                    </div>
                    <?/*
                    <div class="auth-alternative">
                        <div class="auth-alternative-sep">
                            Або
                        </div>
                        <div class="auth-alternative-list">
                            <a href="#" class="auth-alternative-item">
	        							<span class="icon">
	        								<svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M5.98371 16.3178L5.04389 19.8263L1.60886 19.899C0.582287 17.9949 0 15.8164 0 13.5014C0 11.2628 0.544424 9.15178 1.50945 7.29297H1.51019L4.56833 7.85363L5.90798 10.8934C5.6276 11.7109 5.47478 12.5883 5.47478 13.5014C5.47488 14.4924 5.65439 15.4419 5.98371 16.3178Z" fill="#FBBB00"/>
												<path d="M26.7641 10.9766C26.9191 11.7932 27 12.6366 27 13.4985C27 14.465 26.8983 15.4078 26.7048 16.3172C26.0476 19.4118 24.3304 22.114 21.9516 24.0262L21.9509 24.0254L18.099 23.8289L17.5538 20.4257C19.1323 19.5 20.3658 18.0514 21.0156 16.3172H13.7969V10.9766H21.1209H26.7641Z" fill="#518EF8"/>
												<path d="M21.9495 24.0302L21.9503 24.0309C19.637 25.8903 16.6983 27.0029 13.4994 27.0029C8.35878 27.0029 3.88935 24.1296 1.60938 19.9012L5.98388 16.3203C7.12385 19.3627 10.0587 21.5285 13.4994 21.5285C14.9784 21.5285 16.3639 21.1287 17.5528 20.4308L21.9495 24.0302Z" fill="#28B446"/>
												<path d="M22.1174 3.10768L17.7444 6.68781C16.514 5.9187 15.0595 5.4744 13.5012 5.4744C9.98259 5.4744 6.99281 7.73951 5.90996 10.891L1.51246 7.29083H1.51172C3.75832 2.95935 8.28411 0 13.5012 0C16.7765 0 19.7796 1.1667 22.1174 3.10768Z" fill="#F14336"/>
											</svg>
	        							</span>
                                Google
                            </a>
                            <a href="#" class="auth-alternative-item">
	        							<span class="icon">
	        								<svg width="14" height="25" viewBox="0 0 14 25" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M3.64599 13.7028C3.55484 13.7028 1.54954 13.7028 0.638048 13.7028C0.151916 13.7028 0 13.5205 0 13.0648C0 11.8495 0 10.6037 0 9.38841C0 8.90228 0.182299 8.75037 0.638048 8.75037H3.64599C3.64599 8.65922 3.64599 6.89699 3.64599 6.07664C3.64599 4.86131 3.85867 3.70675 4.46633 2.64334C5.10438 1.54954 6.01588 0.820346 7.17044 0.394982C7.93002 0.121533 8.6896 0 9.50995 0H12.4875C12.9129 0 13.0952 0.182299 13.0952 0.607664V4.07135C13.0952 4.49672 12.9129 4.67901 12.4875 4.67901C11.6672 4.67901 10.8468 4.67901 10.0265 4.7094C9.20611 4.7094 8.78075 5.10438 8.78075 5.95511C8.75037 6.86661 8.78075 7.74772 8.78075 8.6896H12.3052C12.7913 8.6896 12.9736 8.8719 12.9736 9.35803V13.0344C12.9736 13.5205 12.8217 13.6724 12.3052 13.6724C11.2114 13.6724 8.8719 13.6724 8.78075 13.6724V23.5774C8.78075 24.0939 8.62883 24.2762 8.08193 24.2762C6.80584 24.2762 5.56013 24.2762 4.28403 24.2762C3.82829 24.2762 3.64599 24.0939 3.64599 23.6381C3.64599 20.4479 3.64599 13.794 3.64599 13.7028Z" fill="#0866FF"/>
											</svg>
	        							</span>
                                Facebook
                            </a>
                        </div>
                    </div>
                    */?>
                </div>
                <div class="auth-form-cont register_form" style="<?=isset($_POST['REGISTER_ME']) ? '' : 'display: none;'?>">
                    <div class="auth-form">
                            <div class="auth-inputs">
                                <div class="auth-inputs-group">
                                    <div class="form-block">
                                        <input size="30" type="text" name="CLIENT_NEW[NAME]" value="<?=$_POST['CLIENT_NEW']['NAME']?>" class="form-control" placeholder="Ваше Имя">
                                    </div>
                                    <div class="form-block">
                                        <input size="30" type="text" name="CLIENT_NEW[LAST_NAME]" value="<?=$_POST['CLIENT_NEW']['LAST_NAME']?>" class="form-control" placeholder="Фамилия">
                                    </div>
                                </div>
                                <div class="auth-inputs-group">
                                    <div class="form-block">
                                        <input size="30" type="text" name="CLIENT_NEW[PERSONAL_PHONE]" value="<?=$_POST['CLIENT_NEW']['PERSONAL_PHONE']?>" class="form-control" placeholder="Телефон">
                                    </div>
                                    <div class="form-block">
                                        <input size="30" type="text" name="CLIENT_NEW[EMAIL]" value="<?=$_POST['CLIENT_NEW']['EMAIL']?>" class="form-control" placeholder="Ваш E-mail">
                                    </div>
                                </div>
                                <div class="auth-inputs-group">
                                    <div class="form-block">
                                        <div class="password-input">
                                            <input size="30" type="text" name="CLIENT_NEW[PASSWORD]" value="" class="form-control" placeholder="Пароль">
                                            <div class="password-swap">
                                                <svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="#999999"/>
                                                    <path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="#999999"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-block">
                                        <div class="password-input">
                                            <input size="30" type="text" name="CLIENT_NEW[REPEAT_PASSWORD]" value="" class="form-control" placeholder="Повторите пароль">
                                            <div class="password-swap">
                                                <svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="#999999"/>
                                                    <path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="#999999"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="auth-inputs-group">
                                    <div class="form-block">
                                        <select class="form-select" name="CLIENT_NEW[UF_UGROUP]">
                                            <option value="">
                                                Способ сотрудничества
                                            </option>
                                            <option value="25">
                                                Розничный клиент
                                            </option>
                                            <option value="26">
                                                Оптовый клиент
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="licence_block filter label_block"></div>
                                <div class="licence_block filter label_block">
                                    <input type="checkbox" id="oferta_agree" name="oferta_agree" >
                                    <label for="oferta_agree">
                                        Я согласен с договором оферты и политикой конфиденциальности
                                    </label>
                                </div>
                                <div class="auth-btn-block">
                                    <button class="info-btn info-btn-black" name="REGISTER_ME">
                                        Зарегистрироваться
                                    </button>
                                </div>
                            </div>
                            <?/*
                            <div class="auth-alternative">
                                <div class="auth-alternative-sep">
                                    Або
                                </div>
                                <div class="auth-alternative-list">
                                    <a href="#" class="auth-alternative-item">
	        							<span class="icon">
	        								<svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M5.98371 16.3178L5.04389 19.8263L1.60886 19.899C0.582287 17.9949 0 15.8164 0 13.5014C0 11.2628 0.544424 9.15178 1.50945 7.29297H1.51019L4.56833 7.85363L5.90798 10.8934C5.6276 11.7109 5.47478 12.5883 5.47478 13.5014C5.47488 14.4924 5.65439 15.4419 5.98371 16.3178Z" fill="#FBBB00"/>
												<path d="M26.7641 10.9766C26.9191 11.7932 27 12.6366 27 13.4985C27 14.465 26.8983 15.4078 26.7048 16.3172C26.0476 19.4118 24.3304 22.114 21.9516 24.0262L21.9509 24.0254L18.099 23.8289L17.5538 20.4257C19.1323 19.5 20.3658 18.0514 21.0156 16.3172H13.7969V10.9766H21.1209H26.7641Z" fill="#518EF8"/>
												<path d="M21.9495 24.0302L21.9503 24.0309C19.637 25.8903 16.6983 27.0029 13.4994 27.0029C8.35878 27.0029 3.88935 24.1296 1.60938 19.9012L5.98388 16.3203C7.12385 19.3627 10.0587 21.5285 13.4994 21.5285C14.9784 21.5285 16.3639 21.1287 17.5528 20.4308L21.9495 24.0302Z" fill="#28B446"/>
												<path d="M22.1174 3.10768L17.7444 6.68781C16.514 5.9187 15.0595 5.4744 13.5012 5.4744C9.98259 5.4744 6.99281 7.73951 5.90996 10.891L1.51246 7.29083H1.51172C3.75832 2.95935 8.28411 0 13.5012 0C16.7765 0 19.7796 1.1667 22.1174 3.10768Z" fill="#F14336"/>
											</svg>
	        							</span>
                                        Google
                                    </a>
                                    <a href="#" class="auth-alternative-item">
	        							<span class="icon">
	        								<svg width="14" height="25" viewBox="0 0 14 25" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M3.64599 13.7028C3.55484 13.7028 1.54954 13.7028 0.638048 13.7028C0.151916 13.7028 0 13.5205 0 13.0648C0 11.8495 0 10.6037 0 9.38841C0 8.90228 0.182299 8.75037 0.638048 8.75037H3.64599C3.64599 8.65922 3.64599 6.89699 3.64599 6.07664C3.64599 4.86131 3.85867 3.70675 4.46633 2.64334C5.10438 1.54954 6.01588 0.820346 7.17044 0.394982C7.93002 0.121533 8.6896 0 9.50995 0H12.4875C12.9129 0 13.0952 0.182299 13.0952 0.607664V4.07135C13.0952 4.49672 12.9129 4.67901 12.4875 4.67901C11.6672 4.67901 10.8468 4.67901 10.0265 4.7094C9.20611 4.7094 8.78075 5.10438 8.78075 5.95511C8.75037 6.86661 8.78075 7.74772 8.78075 8.6896H12.3052C12.7913 8.6896 12.9736 8.8719 12.9736 9.35803V13.0344C12.9736 13.5205 12.8217 13.6724 12.3052 13.6724C11.2114 13.6724 8.8719 13.6724 8.78075 13.6724V23.5774C8.78075 24.0939 8.62883 24.2762 8.08193 24.2762C6.80584 24.2762 5.56013 24.2762 4.28403 24.2762C3.82829 24.2762 3.64599 24.0939 3.64599 23.6381C3.64599 20.4479 3.64599 13.794 3.64599 13.7028Z" fill="#0866FF"/>
											</svg>
	        							</span>
                                        Facebook
                                    </a>
                                </div>
                            </div>
                            */?>
                        </div>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $(document).on('click','.auth-link.auth',function()
        {
            $('.register_form').hide();
            $('.auth_form').show();
            $('.auth-link').removeClass('active');
            $(this).addClass('active');

            return false;
        });

        $(document).on('click','.auth-link.register',function()
        {
            $('.register_form').show();
            $('.auth_form').hide();
            $('.auth-link').removeClass('active');
            $(this).addClass('active');

            return false;
        });
    });
</script>