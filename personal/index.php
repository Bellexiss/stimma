<?
define('NNED_AUTH',true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Особистий кабінет");
?>
	<?if(isset($_GET['newstimma']) || true || NEW_STIMMA )
    {
        global $USER,$DB;


        $ru=LANGUAGE_ID=='ru'?'/ru':'';

        if(!$USER->IsAuthorized())
        {
            include $_SERVER['DOCUMENT_ROOT'].$ru.'/auth/auth.php';
        }
        else
        {
            if(!empty($_POST))
            {
                foreach($_POST['dost'] as $dId => $item)
                {
                    $find = $DB->Query('select * from user_adresses where UF_UID='.$USER->GetID() . ' and UF_DELIVERY_ID = ' . $dId);
                    if($find = $find->Fetch())
                    {
                        if($dId == 18)
                            $DB->Query('update user_adresses set UF_CITY="'.$item['city'].'", UF_STREET='.$item['street'] . ', UF_DOM='.$item['dom'] . ', UF_KV='.$item['kv'] . ' where ID = ' . $find['ID']);
                        else
                            $DB->Query('update user_adresses set UF_CITY_ID="'.$item['city'].'", UF_VIDD_ID='.$item['vidd'] . ' where ID = ' . $find['ID']);
                    }
                    else
                    {
                        if($dId == 18)
                            $DB->Query('insert into user_adresses (UF_UID,UF_DELIVERY_ID,UF_CITY,UF_STREET,UF_DOM,UF_KV) values ('.$USER->GetID() . ',' . $dId . ',"' . $item['city'] . '","' . $item['street'] . '","' . $item ['dom']. '","' . $item ['kv']. '")');
                        else
                            $DB->Query('insert into user_adresses (UF_UID,UF_DELIVERY_ID,UF_CITY_ID,UF_VIDD_ID) values ('.$USER->GetID() . ',' . $dId . ',"' . $item['city'] . '","' . $item['vidd'] . '")');
                    }
                }
                
                $dost=[];

                $savePassword = false;
                $update=[];
                if(!empty($_POST['PASSWORD']) && strlen($_POST['PASSWORD']>5) && $_POST['PASSWORD'] == $_POST['CONFIRM_PASSWORD'])
                {
                    $savePassword = true;
                }
                else
                {
                    unset($_POST['PASSWORD']);
                    unset($_POST['CONFIRM_PASSWORD']);
                    $USER->Update($USER->GetID(),$_POST);
                }

                if($savePassword)
                {
                    $USER->Update($USER->GetID(),['PASSWORD'=>$_POST['PASSWORD']]);
                }
                LocalRedirect("/personal/");
                die();
            }

            $user=$USER->GetByID($USER->GetID())->Fetch();
            $dost=[];

            $res = $DB->Query('select * from user_adresses where UF_UID='.$USER->GetID());
            while ($record = $res->Fetch())
            {
                if($record['UF_DELIVERY_ID'] != 18)
                {
                    if($record['UF_DELIVERY_ID'] == 14 || $record['UF_DELIVERY_ID'] == 17)
                    {
                        if($record['UF_CITY_ID'])
                            $record['CITY'] = $DB->Query('select * from np_cities_new where ID = ' . $record['UF_CITY_ID'])->Fetch()['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                        if($record['UF_VIDD_ID'])
                        {
                            $record['VIDD'] = $DB->Query('select * from np_posts_new where ID = ' . $record['UF_VIDD_ID'])->Fetch();
                            $record['VIDD'] = '№'.$record['VIDD']['UF_NUMBER'].' ' .$record['VIDD']['UF_SHORT_ADRESS_UA'];
                        }
                    }

                    if($record['UF_DELIVERY_ID'] == 15)
                    {
                        if($record['UF_CITY_ID'])
                        {
                            $record['CITY'] = $DB->Query('select * from ukrposhta_cities where ID = ' . $record['UF_CITY_ID'])->Fetch();
                            $record['CITY'] = $record['CITY']['UF_CITYTYPE_UA'].', ' . $record['CITY']['UF_CITY_UA'] .', ' . $record['CITY']['UF_DISTRICT_UA'] . ' р-н.'.', ' . $record['CITY']['UF_REGION_UA'] . ' обл.';
                        }
                        if($record['UF_VIDD_ID'])
                        {
                            $record['VIDD'] = $DB->Query('select * from ukrposhta_posts where ID = ' . $record['UF_VIDD_ID'])->Fetch();
                            $record['VIDD'] = $record['VIDD']['UF_POSTINDEX'] . ', ' . $record['VIDD']['UF_ADDRESS'];
                        }
                    }
                }

                $dost[$record['UF_DELIVERY_ID']] = $record;
            }

            ?>

            <div class="breadcrumbs-cont">
                <div class="wrapper">
                    <div class="breadcrumbs-block">
                        <a href="<?=$ru?>/" class="breadcrumb-item">
                            STIMMA
                        </a>
                        <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"></path>
                        </svg>
                    </span>
                        <span class="breadcrumb-item">
                        <?=LANGUAGE_ID=='ua'?'Особистий кабінет':'Личный кабинет'?>
                    </span>
                    </div>
                </div>
            </div>
            <div class="personal-page">
                <div class="wrapper">
                    <div class="personal-cont">
                        <?include 'left_menu.php'?>


                        <div class="personal-content">
                            <div class="personal-content-block">
                                <div class="personal-content-title-block">
                                    <div class="personal-content-title">
                                        <?=LANGUAGE_ID=='ua'?'Контактні дані':'Контактные данные'?>
                                    </div>
                                </div>
                                <div class="personal-form-cont">
                                    <form method="post" action="/personal/">
                                        <div class="personal-form-block">
                                            <div class="personal-form-groups">
                                                <div class="personal-form-group">
                                                    <div class="form-block">
                                                        <input type="text" name="NAME" value="<?=$user['NAME']?>" class="form-control" placeholder="Ім'я">
                                                    </div>
                                                    <div class="form-block">
                                                        <input type="text" name="LAST_NAME" value="<?=$user['LAST_NAME']?>" class="form-control" placeholder="Прізвище">
                                                    </div>
                                                    <div class="form-block">
                                                        <input type="text" name="EMAIL" value="<?=$user['EMAIL']?>" class="form-control" placeholder="Email">
                                                    </div>
                                                    <div class="form-block">
                                                        <input type="text" name="PERSONAL_BIRTHDATE" value="<?=$user['PERSONAL_BIRTHDATE']?>" class="form-control" placeholder="Дата народження">
                                                    </div>
                                                </div>
                                                <div class="personal-form-group">
                                                    <div class="form-block">
                                                        <input type="tel" name="PERSONAL_PHONE" value="<?=$user['PERSONAL_PHONE']?>" class="form-control" placeholder="Телефон">
                                                    </div>
                                                    <?/*
							                    <div class="form-block">
						                        	<div class="password-input">
				                                    	<input size="30" type="password" name="" value="" class="form-control" placeholder="Пароль">
				                                		<div class="password-swap">
				                                			<svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="currentcolor"></path>
																<path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="currentcolor"></path>
															</svg>
															<svg class="password-swap-visible" width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M17.4762 11.2471L19.0665 9.58103C19.1822 10.0346 19.25 10.5087 19.25 11C19.25 14.0328 16.8949 16.5 14 16.5C13.531 16.5 13.0784 16.429 12.6455 16.3077L14.2358 14.6417C15.9747 14.5175 17.3576 13.0687 17.4762 11.2471ZM27.8898 10.5548C27.7821 10.3519 26.2557 7.54993 23.2719 5.17531L21.9986 6.50929C24.1743 8.18518 25.5528 10.1397 26.0956 11.0014C25.0585 12.6558 20.9902 18.3333 14 18.3333C12.9517 18.3333 11.977 18.1929 11.0598 17.9687L9.62194 19.475C10.9438 19.8997 12.3968 20.1667 14 20.1667C23.1597 20.1667 27.701 11.8012 27.8898 11.4453C28.0368 11.1682 28.0368 10.8318 27.8898 10.5548ZM24.2436 1.5648L4.99362 21.7314C4.82278 21.9104 4.59878 22 4.375 22C4.15122 22 3.92722 21.9104 3.75638 21.7314C3.41447 21.3732 3.41447 20.7932 3.75638 20.4353L6.2055 17.8695C2.24612 15.3654 0.234281 11.6793 0.11025 11.4453C-0.03675 11.1682 -0.03675 10.8316 0.11025 10.5545C0.299031 10.1989 4.84028 1.83339 14 1.83339C16.3684 1.83339 18.4198 2.39943 20.1736 3.23634L23.0064 0.26864C23.3483 -0.0895466 23.9019 -0.0895466 24.2436 0.26864C24.5853 0.626826 24.5855 1.20685 24.2436 1.5648ZM7.51034 16.5025L9.72563 14.1818C9.11378 13.2825 8.75 12.186 8.75 11C8.75 7.96724 11.1051 5.50004 14 5.50004C15.132 5.50004 16.1788 5.88115 17.0371 6.52189L18.8285 4.64525C17.4132 4.05148 15.8049 3.66671 14 3.66671C7.00984 3.66671 2.94153 9.3443 1.90466 10.9987C2.56309 12.0441 4.45572 14.6905 7.51034 16.5025ZM10.9959 12.8508L15.7666 7.85289C15.2462 7.53091 14.6471 7.33337 14 7.33337C12.0702 7.33337 10.5 8.97832 10.5 11C10.5 11.6779 10.6886 12.3056 10.9959 12.8508Z" fill="currentcolor"/>
															</svg>
				                                		</div>
				                                	</div>
							                    </div>
                                                */?>
                                                    <div class="form-block">
                                                        <div class="password-input">
                                                            <input size="30" type="password" name="PASSWORD" value="" class="form-control" placeholder="Новий пароль">
                                                            <div class="password-swap">
                                                                <svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="currentcolor"></path>
                                                                    <path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="currentcolor"></path>
                                                                </svg>
                                                                <svg class="password-swap-visible" width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M17.4762 11.2471L19.0665 9.58103C19.1822 10.0346 19.25 10.5087 19.25 11C19.25 14.0328 16.8949 16.5 14 16.5C13.531 16.5 13.0784 16.429 12.6455 16.3077L14.2358 14.6417C15.9747 14.5175 17.3576 13.0687 17.4762 11.2471ZM27.8898 10.5548C27.7821 10.3519 26.2557 7.54993 23.2719 5.17531L21.9986 6.50929C24.1743 8.18518 25.5528 10.1397 26.0956 11.0014C25.0585 12.6558 20.9902 18.3333 14 18.3333C12.9517 18.3333 11.977 18.1929 11.0598 17.9687L9.62194 19.475C10.9438 19.8997 12.3968 20.1667 14 20.1667C23.1597 20.1667 27.701 11.8012 27.8898 11.4453C28.0368 11.1682 28.0368 10.8318 27.8898 10.5548ZM24.2436 1.5648L4.99362 21.7314C4.82278 21.9104 4.59878 22 4.375 22C4.15122 22 3.92722 21.9104 3.75638 21.7314C3.41447 21.3732 3.41447 20.7932 3.75638 20.4353L6.2055 17.8695C2.24612 15.3654 0.234281 11.6793 0.11025 11.4453C-0.03675 11.1682 -0.03675 10.8316 0.11025 10.5545C0.299031 10.1989 4.84028 1.83339 14 1.83339C16.3684 1.83339 18.4198 2.39943 20.1736 3.23634L23.0064 0.26864C23.3483 -0.0895466 23.9019 -0.0895466 24.2436 0.26864C24.5853 0.626826 24.5855 1.20685 24.2436 1.5648ZM7.51034 16.5025L9.72563 14.1818C9.11378 13.2825 8.75 12.186 8.75 11C8.75 7.96724 11.1051 5.50004 14 5.50004C15.132 5.50004 16.1788 5.88115 17.0371 6.52189L18.8285 4.64525C17.4132 4.05148 15.8049 3.66671 14 3.66671C7.00984 3.66671 2.94153 9.3443 1.90466 10.9987C2.56309 12.0441 4.45572 14.6905 7.51034 16.5025ZM10.9959 12.8508L15.7666 7.85289C15.2462 7.53091 14.6471 7.33337 14 7.33337C12.0702 7.33337 10.5 8.97832 10.5 11C10.5 11.6779 10.6886 12.3056 10.9959 12.8508Z" fill="currentcolor"/>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-block">
                                                        <div class="password-input">
                                                            <input size="30" type="password" name="CONFIRM_PASSWORD" value="" class="form-control" placeholder="Підтвердження пароля">
                                                            <div class="password-swap">
                                                                <svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="currentcolor"></path>
                                                                    <path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="currentcolor"></path>
                                                                </svg>
                                                                <svg class="password-swap-visible" width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M17.4762 11.2471L19.0665 9.58103C19.1822 10.0346 19.25 10.5087 19.25 11C19.25 14.0328 16.8949 16.5 14 16.5C13.531 16.5 13.0784 16.429 12.6455 16.3077L14.2358 14.6417C15.9747 14.5175 17.3576 13.0687 17.4762 11.2471ZM27.8898 10.5548C27.7821 10.3519 26.2557 7.54993 23.2719 5.17531L21.9986 6.50929C24.1743 8.18518 25.5528 10.1397 26.0956 11.0014C25.0585 12.6558 20.9902 18.3333 14 18.3333C12.9517 18.3333 11.977 18.1929 11.0598 17.9687L9.62194 19.475C10.9438 19.8997 12.3968 20.1667 14 20.1667C23.1597 20.1667 27.701 11.8012 27.8898 11.4453C28.0368 11.1682 28.0368 10.8318 27.8898 10.5548ZM24.2436 1.5648L4.99362 21.7314C4.82278 21.9104 4.59878 22 4.375 22C4.15122 22 3.92722 21.9104 3.75638 21.7314C3.41447 21.3732 3.41447 20.7932 3.75638 20.4353L6.2055 17.8695C2.24612 15.3654 0.234281 11.6793 0.11025 11.4453C-0.03675 11.1682 -0.03675 10.8316 0.11025 10.5545C0.299031 10.1989 4.84028 1.83339 14 1.83339C16.3684 1.83339 18.4198 2.39943 20.1736 3.23634L23.0064 0.26864C23.3483 -0.0895466 23.9019 -0.0895466 24.2436 0.26864C24.5853 0.626826 24.5855 1.20685 24.2436 1.5648ZM7.51034 16.5025L9.72563 14.1818C9.11378 13.2825 8.75 12.186 8.75 11C8.75 7.96724 11.1051 5.50004 14 5.50004C15.132 5.50004 16.1788 5.88115 17.0371 6.52189L18.8285 4.64525C17.4132 4.05148 15.8049 3.66671 14 3.66671C7.00984 3.66671 2.94153 9.3443 1.90466 10.9987C2.56309 12.0441 4.45572 14.6905 7.51034 16.5025ZM10.9959 12.8508L15.7666 7.85289C15.2462 7.53091 14.6471 7.33337 14 7.33337C12.0702 7.33337 10.5 8.97832 10.5 11C10.5 11.6779 10.6886 12.3056 10.9959 12.8508Z" fill="currentcolor"/>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <hr>
                                                <div class="personal-form-group" style="">
                                                    <div class="order-detail-item">
                                                    <div class="order-detail-title">
                                                        <span class="icon">
                                                            <svg width="30" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M29.5312 5.91223L19.3465 0.123668C19.204 0.0426434 19.0423 -9.15536e-06 18.8777 1.47406e-09H13.1099C12.8612 1.47406e-09 12.6228 0.0972331 12.447 0.270309C12.2712 0.443385 12.1724 0.678127 12.1724 0.922893C12.1724 1.16766 12.2712 1.4024 12.447 1.57548C12.6228 1.74855 12.8612 1.84579 13.1099 1.84579H15.3789L8.44172 5.78856H0.9375C0.68886 5.78856 0.450403 5.88579 0.274587 6.05887C0.0987721 6.23195 0 6.46669 0 6.71145C0 6.95622 0.0987721 7.19096 0.274587 7.36404C0.450403 7.53711 0.68886 7.63435 0.9375 7.63435H8.44172L17.9402 13.0329V22.4788L9.16166 17.4894C9.01914 17.4084 8.85748 17.3658 8.69291 17.3657H0.9375C0.68886 17.3657 0.450403 17.463 0.274587 17.636C0.0987721 17.8091 0 18.0439 0 18.2886C0 18.5334 0.0987721 18.7681 0.274587 18.9412C0.450403 19.1143 0.68886 19.2115 0.9375 19.2115H8.44172L18.409 24.8764C18.5515 24.9574 18.7132 25 18.8777 25C19.0423 25 19.204 24.9574 19.3465 24.8764L29.5312 19.0879C29.6738 19.0069 29.7921 18.8903 29.8744 18.75C29.9567 18.6097 30 18.4506 30 18.2886V6.71145C30 6.54946 29.9567 6.39031 29.8744 6.25002C29.7921 6.10973 29.6738 5.99323 29.5312 5.91223ZM27.1875 6.71145L18.8777 11.4344L10.568 6.71145L18.8777 1.98855L27.1875 6.71145ZM19.8152 22.4788V13.0329L28.125 8.3099V17.7558L19.8152 22.4788ZM2.70023 0.922893C2.70023 0.678127 2.79901 0.443385 2.97482 0.270309C3.15064 0.0972331 3.38909 1.47406e-09 3.63773 1.47406e-09H9.70172C9.95036 1.47406e-09 10.1888 0.0972331 10.3646 0.270309C10.5404 0.443385 10.6392 0.678127 10.6392 0.922893C10.6392 1.16766 10.5404 1.4024 10.3646 1.57548C10.1888 1.74855 9.95036 1.84579 9.70172 1.84579H3.63773C3.38909 1.84579 3.15064 1.74855 2.97482 1.57548C2.79901 1.4024 2.70023 1.16766 2.70023 0.922893ZM3.63773 13.4229C3.38909 13.4229 3.15064 13.3257 2.97482 13.1526C2.79901 12.9795 2.70023 12.7448 2.70023 12.5C2.70023 12.2552 2.79901 12.0205 2.97482 11.8474C3.15064 11.6744 3.38909 11.5771 3.63773 11.5771H8.51309C8.76173 11.5771 9.00018 11.6744 9.176 11.8474C9.35181 12.0205 9.45059 12.2552 9.45059 12.5C9.45059 12.7448 9.35181 12.9795 9.176 13.1526C9.00018 13.3257 8.76173 13.4229 8.51309 13.4229H3.63773Z" fill="currentcolor"/>
                                                            </svg>
                                                        </span>
                                                        <?=UA?'Спосіб доставки':'Способ доставки'?>
                                                    </div>
                                                    <div class="order-detail-elements">
                                                        <label class="order-detail-element">
                                                            <input type="radio" checked id="delivery_method" name="delivery_method" value="14">
                                                            <div class="order-detail-block">
                                                                <div class="order-detail-radio">

                                                                </div>
                                                                <div class="order-detail-text-cont">
                                                                    <div class="order-detail-text-title">
                                                                        <?=UA?'Нова Пошта (відділення). Від 80 грн.':'Нова Почта (отделение). От 80 грн.'?>
                                                                    </div>
                                                                    <div class="order-detail-text-dropdown">
                                                                        <div class="order-detail-text">
                                                                            <p class="order-detail-text-del">
                                                                                терміни відправки до 5-ти днів.
                                                                                Номер ТТН буде надіслано у SMS-повідомленні.
                                                                                При відправленні вказуємо повну оголошену вартість товару.
                                                                                Оплата за доставку здійснюється при отриманні замовлення.
                                                                            </p>
                                                                        </div>
                                                                        <div>
                                                                            <div class="form-block ">
                                                                                <select class="custom-select dost14" name="dost[14][city]">
                                                                                    <?
                                                                                    if(isset($dost[14]['UF_CITY_ID']) && $dost[14]['UF_CITY_ID'])
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?=$dost[14]['UF_CITY_ID']?>">
                                                                                            <?=$dost[14]['CITY']?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <option value="0">
                                                                                            <?=LANGUAGE_ID=='ua'?'Оберіть місто':'Выберите город'?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-block choose_city">
                                                                                <select class="custom-select" name="dost[14][vidd]">
                                                                                    <?
                                                                                    if(isset($dost[14]['UF_VIDD_ID']) && $dost[14]['UF_VIDD_ID'])
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?=$dost[14]['UF_VIDD_ID']?>">
                                                                                            <?=$dost[14]['VIDD']?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <option value="0">
                                                                                            <?=LANGUAGE_ID=='ua'?'Виберіть відділення':'Выберите отделение'?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <label class="order-detail-element">
                                                            <input type="radio" id="delivery_method3" name="delivery_method" value="17">
                                                            <div class="order-detail-block">
                                                                <div class="order-detail-radio">

                                                                </div>
                                                                <div class="order-detail-text-cont">
                                                                    <div class="order-detail-text-title">
                                                                        <?=UA?'Нова Пошта (поштомат). Від 90 грн.':'Нова Почта (почтомат). От 90 грн.'?>
                                                                    </div>
                                                                    <div class="order-detail-text-dropdown">
                                                                        <div class="order-detail-text">
                                                                            <p class="order-detail-text-del">
                                                                                терміни відправки до 5-ти днів.
                                                                                Номер ТТН буде надіслано у SMS-повідомленні.
                                                                                При відправленні вказуємо повну оголошену вартість товару.
                                                                                Оплата за доставку здійснюється при отриманні замовлення.
                                                                            </p>
                                                                        </div>
                                                                        <div>
                                                                            <div class="form-block ">
                                                                                <select class="custom-select" name="dost[17][city]">
                                                                                    <?
                                                                                    if(isset($dost[17]['UF_CITY_ID']) && $dost[17]['UF_CITY_ID'])
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?=$dost[17]['UF_CITY_ID']?>">
                                                                                            <?=$dost[17]['CITY']?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <option value="0">
                                                                                            <?=LANGUAGE_ID=='ua'?'Оберіть місто':'Выберите город'?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-block choose_city">
                                                                                <select class="custom-select" name="dost[17][vidd]">
                                                                                    <?
                                                                                    if(isset($dost[17]['UF_VIDD_ID']) && $dost[17]['UF_VIDD_ID'])
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?=$dost[17]['UF_VIDD_ID']?>">
                                                                                            <?=$dost[17]['VIDD']?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <option value="0">
                                                                                            <?=LANGUAGE_ID=='ua'?'Виберіть відділення':'Выберите отделение'?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <label class="order-detail-element">
                                                            <input type="radio" id="delivery_method4" name="delivery_method" value="18">
                                                            <div class="order-detail-block">
                                                                <div class="order-detail-radio">

                                                                </div>
                                                                <div class="order-detail-text-cont">
                                                                    <div class="order-detail-text-title">
                                                                        <?=UA?'Нова Пошта (кур’єр). Від 130 грн.':'Нова Почта (курьер). От 130 грн.'?>
                                                                    </div>
                                                                    <div class="order-detail-text-dropdown">
                                                                        <div class="order-detail-text">
                                                                            <p class="order-detail-text-del">
                                                                                терміни відправки до 5-ти днів.
                                                                                Номер ТТН буде надіслано у SMS-повідомленні.
                                                                                При відправленні вказуємо повну оголошену вартість товару.
                                                                                Оплата за доставку здійснюється при отриманні замовлення.
                                                                            </p>

                                                                        </div>
                                                                        <div>
                                                                            <div class="form-block ">
                                                                                <input class="form-control" name="dost[18][city]" value="<?=$dost[18]['UF_CITY']?>" id="np_k_city" type="text" placeholder="<?=UA?'Місто':'Город'?>">
                                                                            </div>
                                                                            <div class="form-block">
                                                                                <input class="form-control" name="dost[18][street]" value="<?=$dost[18]['UF_STREET']?>" id="np_k_street" type="text" placeholder="<?=UA?'Вулиця':'Улица'?>">
                                                                            </div>

                                                                            <div class="form-block">
                                                                                <input class="form-control" name="dost[18][dom]" value="<?=$dost[18]['UF_DOM']?>" id="np_k_dom" type="text" placeholder="<?=UA?'Буд.':'Дом'?>">
                                                                            </div>
                                                                            <div class="form-block">
                                                                                <input class="form-control" name="dost[18][kv]" value="<?=$dost[18]['UF_KV']?>" id="np_k_kv" type="text" placeholder="<?=UA?'Квартира':'Квартира'?>">
                                                                            </div>
                                                                            <div class="form-block">
                                                                                <textarea name="adress_comment" id="adress_comment" class="form-control" placeholder="<?=UA?'Коментар':'Комментарий'?>"></textarea>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <label class="order-detail-element">
                                                            <input type="radio" id="delivery_method1" name="delivery_method" value="15">
                                                            <div class="order-detail-block">
                                                                <div class="order-detail-radio">

                                                                </div>
                                                                <div class="order-detail-text-cont">
                                                                    <div class="order-detail-text-title">
                                                                        <?=UA?'УкрПошта Експрес':'УкрПочта Экспресс'?>
                                                                    </div>
                                                                    <div class="order-detail-text-dropdown">
                                                                        <div class="order-detail-text">
                                                                            <p class="order-detail-text-del">
                                                                                терміни відправки до 5-ти днів.
                                                                                Номер ТТН буде надіслано у SMS-повідомленні.
                                                                                При відправленні вказуємо повну оголошену вартість товару.
                                                                                Оплата за доставку здійснюється при отриманні замовлення.
                                                                            </p>

                                                                        </div>
                                                                        <div>
                                                                            <div class="form-block ">
                                                                                <select class="custom-select" name="dost[15][city]">
                                                                                    <?
                                                                                    if(isset($dost[15]['UF_CITY_ID']) && $dost[15]['UF_CITY_ID'])
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?=$dost[15]['UF_CITY_ID']?>">
                                                                                            <?=$dost[15]['CITY']?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <option value="0">
                                                                                            <?=LANGUAGE_ID=='ua'?'Оберіть місто':'Выберите город'?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-block choose_city">
                                                                                <select class="custom-select" name="dost[15][vidd]">
                                                                                    <?
                                                                                    if(isset($dost[15]['UF_VIDD_ID']) && $dost[15]['UF_VIDD_ID'])
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?=$dost[15]['UF_VIDD_ID']?>">
                                                                                            <?=$dost[15]['VIDD']?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <option value="0">
                                                                                            <?=LANGUAGE_ID=='ua'?'Виберіть відділення':'Выберите отделение'?>
                                                                                        </option>
                                                                                        <?
                                                                                    }
                                                                                    ?>

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                                </div>

                                            </div>
                                            <div class="btn-block d-flex align-items-center justify-content-center">
                                                <button class="info-btn" type="submit">Зберегти</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
        <script src="/personal/js.js?v=<?=strtotime(date('d.m.Y H:i:s'))?>"></script>




        <?/*
    <div class="breadcrumbs-cont">
            <div class="wrapper">
                <div class="breadcrumbs-block">
                    <a href="<?=$ru?>/" class="breadcrumb-item">
                        STIMMA
                    </a>
                    <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"></path>
                        </svg>
                    </span>
                    <span class="breadcrumb-item">
                        Особистий кабінет
                    </span>
                </div>
            </div>
        </div>

    	<div class="personal-page">
    		<div class="wrapper">
    			<div class="personal-cont">
                    <?include 'left_menu.php'?>
    				<div class="personal-aside-cont">
    					<div class="personal-aside-block">
    						<a href="#" class="personal-aside-item active">
    							<span class="icon">
    								<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M19.5344 17.6385L18.4287 18.7686L18.1802 18.5078C18.0188 18.3441 17.7998 18.2521 17.5716 18.2521C17.3433 18.2521 17.1244 18.3441 16.963 18.5078C16.8016 18.6715 16.7109 18.8935 16.7109 19.125C16.7109 19.3565 16.8016 19.5785 16.963 19.7422L17.8202 20.6115C17.8998 20.6929 17.9946 20.7576 18.0991 20.8017C18.2035 20.8459 18.3156 20.8686 18.4287 20.8686C18.5419 20.8686 18.6539 20.8459 18.7584 20.8017C18.8628 20.7576 18.9576 20.6929 19.0373 20.6115L20.7516 18.8729C20.913 18.7092 21.0037 18.4872 21.0037 18.2557C21.0037 18.0242 20.913 17.8022 20.7516 17.6385C20.5902 17.4748 20.3713 17.3828 20.143 17.3828C19.9148 17.3828 19.6958 17.4748 19.5344 17.6385Z" fill="currentcolor"/>
										<path d="M18.8577 13.9102C17.8405 13.9102 16.8462 14.2161 16.0005 14.7892C15.1547 15.3623 14.4956 16.1769 14.1063 17.1299C13.7171 18.083 13.6152 19.1317 13.8137 20.1435C14.0121 21.1553 14.5019 22.0846 15.2212 22.8141C15.9404 23.5435 16.8568 24.0403 17.8544 24.2415C18.852 24.4428 19.8861 24.3395 20.8258 23.9447C21.7655 23.5499 22.5687 22.8814 23.1338 22.0237C23.6989 21.1659 24.0006 20.1575 24.0006 19.1259C24.0006 17.7426 23.4587 16.416 22.4943 15.4378C21.5298 14.4597 20.2217 13.9102 18.8577 13.9102ZM18.8577 22.6031C18.1796 22.6031 17.5167 22.3992 16.9529 22.0171C16.3891 21.635 15.9496 21.092 15.6901 20.4566C15.4306 19.8212 15.3627 19.1221 15.495 18.4476C15.6273 17.7731 15.9538 17.1535 16.4333 16.6672C16.9128 16.1809 17.5237 15.8497 18.1888 15.7156C18.8539 15.5814 19.5433 15.6503 20.1698 15.9134C20.7963 16.1766 21.3317 16.6223 21.7085 17.1941C22.0852 17.7659 22.2863 18.4382 22.2863 19.1259C22.2863 20.0482 21.9251 20.9326 21.2821 21.5847C20.6391 22.2368 19.767 22.6031 18.8577 22.6031Z" fill="currentcolor"/>
										<path d="M14.5026 13.7651C14.5894 13.6922 14.6611 13.6025 14.7137 13.5014C14.7663 13.4002 14.7987 13.2896 14.809 13.1757C14.8194 13.0619 14.8075 12.9471 14.774 12.8379C14.7406 12.7287 14.6862 12.6273 14.614 12.5394C14.2529 12.1096 13.7939 11.7754 13.2769 11.5658C13.8299 10.8785 14.1326 10.0189 14.134 9.13177C14.1379 8.50493 13.9932 7.88632 13.7121 7.32805C13.431 6.76977 13.0217 6.28819 12.5187 5.92386C12.0158 5.55953 11.4338 5.32313 10.8219 5.23456C10.21 5.14599 9.58612 5.20785 9.00273 5.41493C8.41934 5.62201 7.89357 5.96825 7.46969 6.42448C7.04582 6.8807 6.73626 7.43356 6.56708 8.03648C6.39791 8.63939 6.37408 9.27471 6.49761 9.88892C6.62113 10.5031 6.88839 11.0782 7.27686 11.5658C6.64644 11.8264 6.10681 12.2715 5.72671 12.8443C5.34661 13.4172 5.14327 14.0918 5.14258 14.7822V15.6515C5.14258 15.8821 5.23288 16.1032 5.39363 16.2662C5.55438 16.4292 5.77239 16.5208 5.99972 16.5208C6.22705 16.5208 6.44507 16.4292 6.60581 16.2662C6.76656 16.1032 6.85686 15.8821 6.85686 15.6515V14.7822C6.85686 14.3211 7.03748 13.8789 7.35897 13.5528C7.68046 13.2268 8.11649 13.0436 8.57115 13.0436H11.9997C12.2465 13.0413 12.4906 13.0947 12.7145 13.1999C12.9383 13.3052 13.1363 13.4597 13.294 13.6521C13.366 13.7401 13.4543 13.8129 13.5541 13.8662C13.6538 13.9196 13.7629 13.9524 13.8752 13.9629C13.9874 13.9734 14.1006 13.9614 14.2083 13.9274C14.316 13.8935 14.416 13.8383 14.5026 13.7651ZM10.2854 6.95852C10.7093 6.95852 11.1236 7.08598 11.4759 7.32478C11.8283 7.56358 12.103 7.903 12.2652 8.3001C12.4274 8.69721 12.4698 9.13418 12.3871 9.55575C12.3044 9.97732 12.1003 10.3646 11.8007 10.6685C11.501 10.9724 11.1192 11.1794 10.7035 11.2633C10.2878 11.3471 9.85696 11.3041 9.4654 11.1396C9.07384 10.9751 8.73917 10.6965 8.50371 10.3392C8.26825 9.98177 8.14258 9.5616 8.14258 9.13177C8.14258 8.55539 8.36834 8.00262 8.77021 7.59505C9.17207 7.18749 9.71711 6.95852 10.2854 6.95852Z" fill="currentcolor"/>
										<path d="M11.7171 22.0276C11.2533 22.2515 10.7751 22.4432 10.2857 22.6014C7.81153 21.8533 5.64122 20.3158 4.09708 18.2173C2.55294 16.1188 1.71731 13.5712 1.71429 10.9528V4.95463L10.2857 1.79038L18.8571 4.95463V10.9528C18.8614 11.0136 18.8614 11.0746 18.8571 11.1353V11.3005C18.8571 11.5311 18.9474 11.7522 19.1082 11.9152C19.2689 12.0782 19.487 12.1698 19.7143 12.1698C19.9416 12.1698 20.1596 12.0782 20.3204 11.9152C20.4811 11.7522 20.5714 11.5311 20.5714 11.3005V11.1614C20.5714 11.0658 20.5714 10.9702 20.5714 10.8745V4.34612C20.5714 4.16747 20.517 3.99318 20.4158 3.84696C20.3146 3.70075 20.1714 3.58972 20.0057 3.52898L10.5771 0.051788C10.3888 -0.0172627 10.1826 -0.0172627 9.99429 0.051788L0.565714 3.52898C0.400054 3.58972 0.25687 3.70075 0.155646 3.84696C0.0544222 3.99318 7.49482e-05 4.16747 0 4.34612V10.9528C0.00420949 13.9929 0.990436 16.9479 2.80777 19.3656C4.6251 21.7833 7.17345 23.5305 10.0629 24.34C10.2079 24.3866 10.3636 24.3866 10.5086 24.34C11.1578 24.1652 11.7915 23.9355 12.4029 23.6532C12.5118 23.6117 12.6112 23.5481 12.6952 23.4664C12.7791 23.3846 12.8457 23.2864 12.891 23.1777C12.9363 23.069 12.9592 22.9521 12.9585 22.834C12.9578 22.716 12.9334 22.5994 12.8867 22.4913C12.8401 22.3831 12.7723 22.2858 12.6874 22.2051C12.6025 22.1244 12.5022 22.0621 12.3928 22.022C12.2834 21.9818 12.167 21.9647 12.0509 21.9717C11.9347 21.9786 11.8212 22.0095 11.7171 22.0624V22.0276Z" fill="currentcolor"/>
									</svg>
    							</span>
    							Особисті дані
    						</a>
    						<a href="#" class="personal-aside-item">
    							<span class="icon">
    								<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M23.3482 9.58539C23.1066 9.19672 22.8783 8.82959 22.7693 8.48938C22.6524 8.12393 22.6212 7.675 22.5881 7.19974C22.5333 6.41031 22.4711 5.51551 21.9584 4.80114C21.4411 4.08018 20.6175 3.74393 19.891 3.44724C19.4586 3.27068 19.0502 3.10391 18.7501 2.88239C18.4563 2.66559 18.1779 2.32662 17.8831 1.96776C17.3786 1.35355 16.8067 0.657437 15.959 0.378285C15.1444 0.110075 14.3303 0.315306 13.5431 0.513847C13.0795 0.630726 12.6415 0.741202 12.2501 0.741202C11.8587 0.741202 11.4207 0.630726 10.9571 0.513847C10.1698 0.315306 9.35574 0.110027 8.54121 0.378285C7.69336 0.657437 7.12152 1.35355 6.61701 1.96776C6.32225 2.32662 6.0438 2.66559 5.75008 2.88239C5.44991 3.10396 5.04151 3.27068 4.60918 3.44724C3.88261 3.74393 3.05908 4.08018 2.5417 4.80119C2.02913 5.51551 1.96694 6.41031 1.91205 7.19974C1.87902 7.675 1.84778 8.12397 1.73084 8.48933C1.62191 8.82955 1.39364 9.19672 1.15198 9.58539C0.729118 10.2654 0.25 11.0361 0.25 11.9557C0.25 12.8754 0.729165 13.6461 1.15193 14.3261C1.39359 14.7148 1.62182 15.0819 1.73075 15.4221C1.84769 15.7875 1.87893 16.2364 1.91195 16.7117C1.96684 17.5011 2.02904 18.3959 2.54165 19.1103C3.05903 19.8313 3.88256 20.1675 4.60913 20.4642C5.04151 20.6408 5.44986 20.8075 5.75003 21.0291C6.04375 21.2459 6.3222 21.5848 6.61696 21.9437C7.12147 22.5578 7.69336 23.254 8.54111 23.5332C9.35569 23.8014 10.1698 23.5961 10.957 23.3976C11.4206 23.2807 11.8586 23.1702 12.25 23.1702C12.6414 23.1702 13.0794 23.2807 13.543 23.3976C14.0604 23.528 14.5893 23.6615 15.1224 23.6615C15.4004 23.6615 15.6797 23.6251 15.9589 23.5332C16.8067 23.254 17.3786 22.5579 17.8831 21.9437C18.1778 21.5848 18.4563 21.2459 18.75 21.0291C19.0502 20.8075 19.4586 20.6408 19.8909 20.4642C20.6175 20.1675 21.441 19.8313 21.9584 19.1103C22.471 18.3959 22.5332 17.5011 22.588 16.7117C22.6211 16.2364 22.6523 15.7875 22.7693 15.4221C22.8782 15.0819 23.1065 14.7147 23.3481 14.3261C23.7709 13.6461 24.25 12.8754 24.25 11.9557C24.25 11.0361 23.7709 10.2654 23.3482 9.58539ZM22.1526 13.5615C21.8752 14.0075 21.5884 14.4688 21.425 14.9794C21.2546 15.5117 21.2158 16.0704 21.1782 16.6109C21.1326 17.2661 21.0896 17.8849 20.8156 18.2667C20.5369 18.6551 19.9667 18.888 19.363 19.1344C18.8699 19.3358 18.3599 19.544 17.9183 19.8701C17.4827 20.1916 17.1341 20.6159 16.7971 21.0261C16.3779 21.5364 15.982 22.0184 15.5224 22.1698C15.0928 22.3113 14.5057 22.1632 13.8841 22.0065C13.3583 21.8739 12.8146 21.7367 12.25 21.7367C11.6855 21.7367 11.1418 21.8738 10.616 22.0065C9.99448 22.1632 9.40738 22.3113 8.97764 22.1698C8.51807 22.0184 8.12211 21.5364 7.70293 21.0261C7.36591 20.6158 7.0174 20.1916 6.58176 19.8701C6.1401 19.5441 5.63017 19.3358 5.13701 19.1344C4.53337 18.888 3.96318 18.6551 3.68449 18.2668C3.41051 17.8849 3.36745 17.2661 3.32193 16.6109C3.28438 16.0704 3.24551 15.5117 3.0751 14.9794C2.91165 14.4688 2.62486 14.0076 2.34754 13.5615C1.99573 12.9957 1.66347 12.4613 1.66347 11.9557C1.66347 11.4503 1.99573 10.9158 2.34754 10.35C2.62486 9.90392 2.91165 9.44266 3.0751 8.93204C3.24551 8.39978 3.28434 7.841 3.32193 7.30052C3.36749 6.64535 3.41051 6.02651 3.68449 5.64472C3.96322 5.25633 4.53342 5.02348 5.13706 4.77701C5.63022 4.5756 6.14015 4.36741 6.58181 4.04138C7.01744 3.71985 7.36596 3.29562 7.70297 2.88535C8.12216 2.37502 8.51807 1.89303 8.97768 1.7417C9.40743 1.60026 9.99444 1.74829 10.616 1.90497C11.1418 2.03757 11.6856 2.17471 12.2501 2.17471C12.8146 2.17471 13.3583 2.03762 13.8842 1.90497C14.5057 1.74834 15.0928 1.60026 15.5225 1.7417C15.982 1.89303 16.378 2.37502 16.7972 2.88535C17.1342 3.29562 17.4827 3.71989 17.9183 4.04138C18.36 4.36736 18.8699 4.5756 19.3631 4.77701C19.9667 5.02348 20.5369 5.25633 20.8156 5.64467C21.0896 6.02651 21.1326 6.64535 21.1782 7.30052C21.2157 7.841 21.2546 8.39978 21.425 8.93209C21.5884 9.44266 21.8752 9.90392 22.1526 10.35C22.5043 10.9158 22.8366 11.4502 22.8366 11.9557C22.8366 12.4612 22.5043 12.9957 22.1526 13.5615Z" fill="currentcolor" stroke="currentcolor" stroke-width="0.5"/>
										<path d="M16.6166 13.759C16.6166 14.2121 16.5331 14.6118 16.369 14.9482C16.2065 15.2798 15.9873 15.5636 15.7151 15.7932C15.4522 16.0151 15.1456 16.1953 14.8029 16.3275C14.4802 16.4519 14.1368 16.5494 13.7834 16.6174C13.4354 16.6839 13.0789 16.728 12.7248 16.7481C12.3791 16.7689 12.0456 16.779 11.7328 16.779C10.9111 16.779 10.1376 16.7094 9.4347 16.5726C8.73483 16.4357 8.10548 16.2633 7.56506 16.0584L7.30289 15.9587V13.0369L7.90311 13.3732C8.40751 13.6547 8.99239 13.8796 9.64244 14.0397C10.2971 14.2013 11.0084 14.2832 11.7566 14.2832C12.1959 14.2832 12.5546 14.26 12.8229 14.2152C13.1403 14.1611 13.315 14.0992 13.4055 14.0567C13.5396 13.9941 13.5726 13.9508 13.5734 13.9508C13.5856 13.9314 13.5918 13.9183 13.5941 13.9113C13.591 13.9098 13.5826 13.9005 13.5672 13.8881C13.5113 13.8418 13.4032 13.7722 13.2046 13.701C13.0184 13.6338 12.7938 13.5704 12.5393 13.5124C12.2717 13.4521 11.9866 13.391 11.6861 13.3307C11.3795 13.2688 11.0644 13.2016 10.7402 13.1304C10.4067 13.0562 10.0794 12.9681 9.76585 12.8683C9.44696 12.7671 9.13957 12.6465 8.85365 12.5104C8.55162 12.3666 8.28102 12.1926 8.05029 11.9939C7.80729 11.7836 7.61258 11.5362 7.47077 11.2586C7.32436 10.9702 7.25 10.637 7.25 10.2682C7.25 9.84761 7.32742 9.47417 7.4792 9.15872C7.62868 8.84714 7.83412 8.57808 8.08938 8.3585C8.33545 8.14666 8.62214 7.97347 8.9418 7.8428C9.24306 7.7191 9.56501 7.62168 9.89847 7.55364C10.2243 7.48715 10.5585 7.44076 10.8912 7.41602C11.2185 7.39128 11.5335 7.37891 11.8271 7.37891C12.1514 7.37891 12.4902 7.39592 12.8336 7.42839C13.1732 7.46086 13.5143 7.50725 13.8455 7.56678C14.1728 7.62477 14.4955 7.69358 14.806 7.7709C15.1126 7.84821 15.4016 7.93017 15.6653 8.01599L15.9451 8.10722V10.944L15.364 10.6587C15.2245 10.5898 15.0321 10.5087 14.793 10.4182C14.5561 10.3285 14.2817 10.2419 13.9781 10.1607C13.6753 10.0796 13.3411 10.0107 12.9846 9.95585C12.6328 9.90173 12.2671 9.87467 11.8977 9.87467C11.5979 9.87467 11.3396 9.88395 11.1303 9.9025C10.9249 9.92106 10.7524 9.94503 10.6175 9.97286C10.468 10.0038 10.3883 10.0339 10.3477 10.0525C10.3346 10.0587 10.3239 10.0641 10.3139 10.0695C10.3768 10.1113 10.4818 10.1662 10.6497 10.2234C10.8398 10.2875 11.0652 10.3502 11.3212 10.4082C11.591 10.4692 11.877 10.5319 12.179 10.5968C12.4864 10.6625 12.803 10.7344 13.1295 10.8125C13.4645 10.8921 13.7934 10.9865 14.1069 11.0932C14.4281 11.2014 14.7362 11.3298 15.0214 11.4736C15.3219 11.6251 15.591 11.806 15.8209 12.0109C16.0632 12.2274 16.2571 12.4802 16.3974 12.7632C16.543 13.057 16.6166 13.3918 16.6166 13.759Z" fill="currentcolor"/>
									</svg>
    							</span>
    							Бонусний рахунок
    						</a>
    						<a href="#" class="personal-aside-item">
    							<span class="icon">
    								<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M23.3482 9.58539C23.1066 9.19672 22.8783 8.82959 22.7693 8.48938C22.6524 8.12393 22.6212 7.675 22.5881 7.19974C22.5333 6.41031 22.4711 5.51551 21.9584 4.80114C21.4411 4.08018 20.6175 3.74393 19.891 3.44724C19.4586 3.27068 19.0502 3.10391 18.7501 2.88239C18.4563 2.66559 18.1779 2.32662 17.8831 1.96776C17.3786 1.35355 16.8067 0.657437 15.959 0.378285C15.1444 0.110075 14.3303 0.315306 13.5431 0.513847C13.0795 0.630726 12.6415 0.741202 12.2501 0.741202C11.8587 0.741202 11.4207 0.630726 10.9571 0.513847C10.1698 0.315306 9.35574 0.110027 8.54121 0.378285C7.69336 0.657437 7.12152 1.35355 6.61701 1.96776C6.32225 2.32662 6.0438 2.66559 5.75008 2.88239C5.44991 3.10396 5.04151 3.27068 4.60918 3.44724C3.88261 3.74393 3.05908 4.08018 2.5417 4.80119C2.02913 5.51551 1.96694 6.41031 1.91205 7.19974C1.87902 7.675 1.84778 8.12397 1.73084 8.48933C1.62191 8.82955 1.39364 9.19672 1.15198 9.58539C0.729118 10.2654 0.25 11.0361 0.25 11.9557C0.25 12.8754 0.729165 13.6461 1.15193 14.3261C1.39359 14.7148 1.62182 15.0819 1.73075 15.4221C1.84769 15.7875 1.87893 16.2364 1.91195 16.7117C1.96684 17.5011 2.02904 18.3959 2.54165 19.1103C3.05903 19.8313 3.88256 20.1675 4.60913 20.4642C5.04151 20.6408 5.44986 20.8075 5.75003 21.0291C6.04375 21.2459 6.3222 21.5848 6.61696 21.9437C7.12147 22.5578 7.69336 23.254 8.54111 23.5332C9.35569 23.8014 10.1698 23.5961 10.957 23.3976C11.4206 23.2807 11.8586 23.1702 12.25 23.1702C12.6414 23.1702 13.0794 23.2807 13.543 23.3976C14.0604 23.528 14.5893 23.6615 15.1224 23.6615C15.4004 23.6615 15.6797 23.6251 15.9589 23.5332C16.8067 23.254 17.3786 22.5579 17.8831 21.9437C18.1778 21.5848 18.4563 21.2459 18.75 21.0291C19.0502 20.8075 19.4586 20.6408 19.8909 20.4642C20.6175 20.1675 21.441 19.8313 21.9584 19.1103C22.471 18.3959 22.5332 17.5011 22.588 16.7117C22.6211 16.2364 22.6523 15.7875 22.7693 15.4221C22.8782 15.0819 23.1065 14.7147 23.3481 14.3261C23.7709 13.6461 24.25 12.8754 24.25 11.9557C24.25 11.0361 23.7709 10.2654 23.3482 9.58539ZM22.1526 13.5615C21.8752 14.0075 21.5884 14.4688 21.425 14.9794C21.2546 15.5117 21.2158 16.0704 21.1782 16.6109C21.1326 17.2661 21.0896 17.8849 20.8156 18.2667C20.5369 18.6551 19.9667 18.888 19.363 19.1344C18.8699 19.3358 18.3599 19.544 17.9183 19.8701C17.4827 20.1916 17.1341 20.6159 16.7971 21.0261C16.3779 21.5364 15.982 22.0184 15.5224 22.1698C15.0928 22.3113 14.5057 22.1632 13.8841 22.0065C13.3583 21.8739 12.8146 21.7367 12.25 21.7367C11.6855 21.7367 11.1418 21.8738 10.616 22.0065C9.99448 22.1632 9.40738 22.3113 8.97764 22.1698C8.51807 22.0184 8.12211 21.5364 7.70293 21.0261C7.36591 20.6158 7.0174 20.1916 6.58176 19.8701C6.1401 19.5441 5.63017 19.3358 5.13701 19.1344C4.53337 18.888 3.96318 18.6551 3.68449 18.2668C3.41051 17.8849 3.36745 17.2661 3.32193 16.6109C3.28438 16.0704 3.24551 15.5117 3.0751 14.9794C2.91165 14.4688 2.62486 14.0076 2.34754 13.5615C1.99573 12.9957 1.66347 12.4613 1.66347 11.9557C1.66347 11.4503 1.99573 10.9158 2.34754 10.35C2.62486 9.90392 2.91165 9.44266 3.0751 8.93204C3.24551 8.39978 3.28434 7.841 3.32193 7.30052C3.36749 6.64535 3.41051 6.02651 3.68449 5.64472C3.96322 5.25633 4.53342 5.02348 5.13706 4.77701C5.63022 4.5756 6.14015 4.36741 6.58181 4.04138C7.01744 3.71985 7.36596 3.29562 7.70297 2.88535C8.12216 2.37502 8.51807 1.89303 8.97768 1.7417C9.40743 1.60026 9.99444 1.74829 10.616 1.90497C11.1418 2.03757 11.6856 2.17471 12.2501 2.17471C12.8146 2.17471 13.3583 2.03762 13.8842 1.90497C14.5057 1.74834 15.0928 1.60026 15.5225 1.7417C15.982 1.89303 16.378 2.37502 16.7972 2.88535C17.1342 3.29562 17.4827 3.71989 17.9183 4.04138C18.36 4.36736 18.8699 4.5756 19.3631 4.77701C19.9667 5.02348 20.5369 5.25633 20.8156 5.64467C21.0896 6.02651 21.1326 6.64535 21.1782 7.30052C21.2157 7.841 21.2546 8.39978 21.425 8.93209C21.5884 9.44266 21.8752 9.90392 22.1526 10.35C22.5043 10.9158 22.8366 11.4502 22.8366 11.9557C22.8366 12.4612 22.5043 12.9957 22.1526 13.5615Z" fill="currentcolor" stroke="currentcolor" stroke-width="0.5"/>
										<path d="M17.0679 7.4889C16.8119 7.23287 16.3968 7.23287 16.1407 7.4889L7.48695 16.1427C7.23091 16.3988 7.23091 16.8139 7.48695 17.0699C7.61496 17.1979 7.78276 17.262 7.95052 17.262C8.11828 17.262 8.28612 17.198 8.4141 17.0699L17.0679 8.41614C17.324 8.16006 17.324 7.74498 17.0679 7.4889Z" fill="currentcolor"/>
										<path d="M9.65397 6.37891C8.32843 6.37891 7.25 7.45734 7.25 8.78288C7.25 10.1084 8.32843 11.1869 9.65397 11.1869C10.9795 11.1869 12.0579 10.1084 12.0579 8.78288C12.0579 7.45734 10.9795 6.37891 9.65397 6.37891ZM9.65397 9.87557C9.05146 9.87557 8.56129 9.38539 8.56129 8.78283C8.56129 8.18032 9.05146 7.69015 9.65397 7.69015C10.2565 7.69015 10.7467 8.18032 10.7467 8.78283C10.7467 9.38539 10.2565 9.87557 9.65397 9.87557Z" fill="currentcolor"/>
										<path d="M14.9001 13.3711C13.5745 13.3711 12.4961 14.4495 12.4961 15.7751C12.4961 17.1006 13.5745 18.179 14.9001 18.179C16.2256 18.179 17.304 17.1006 17.304 15.7751C17.304 14.4495 16.2256 13.3711 14.9001 13.3711ZM14.9001 16.8678C14.2976 16.8678 13.8073 16.3776 13.8073 15.7751C13.8073 15.1726 14.2975 14.6824 14.9001 14.6824C15.5026 14.6824 15.9928 15.1726 15.9928 15.7751C15.9928 16.3776 15.5026 16.8678 14.9001 16.8678Z" fill="currentcolor"/>
									</svg>
    							</span>
    							Мої промокоди та знижки
    						</a>
    						<a href="#" class="personal-aside-item">
    							<span class="icon">
    								<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M17.1948 22.7002C17.5531 22.7002 17.8436 22.4056 17.8436 22.0422C17.8436 21.6787 17.5531 21.3842 17.1948 21.3842C16.8365 21.3842 16.546 21.6787 16.546 22.0422C16.546 22.4056 16.8365 22.7002 17.1948 22.7002ZM17.1948 24.6742C18.6281 24.6742 19.79 23.4957 19.79 22.0422C19.79 20.5886 18.6281 19.4102 17.1948 19.4102C15.7615 19.4102 14.5996 20.5886 14.5996 22.0422C14.5996 23.4957 15.7615 24.6742 17.1948 24.6742Z" fill="currentcolor"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M9.4077 22.7002C9.76603 22.7002 10.0565 22.4056 10.0565 22.0422C10.0565 21.6787 9.76603 21.3842 9.4077 21.3842C9.04937 21.3842 8.7589 21.6787 8.7589 22.0422C8.7589 22.4056 9.04937 22.7002 9.4077 22.7002ZM9.4077 24.6742C10.841 24.6742 12.0029 23.4957 12.0029 22.0422C12.0029 20.5886 10.841 19.4102 9.4077 19.4102C7.97443 19.4102 6.8125 20.5886 6.8125 22.0422C6.8125 23.4957 7.97443 24.6742 9.4077 24.6742Z" fill="currentcolor"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M0.163552 0.439613C0.461695 -0.0139395 1.06592 -0.136499 1.51314 0.165872L3.02874 1.19059C3.51281 1.51787 3.85453 2.02108 3.98345 2.59641L6.65358 14.5117C6.82143 15.2606 7.47795 15.7921 8.23529 15.7921H18.3657C19.123 15.7921 19.7796 15.2606 19.9474 14.5117L22.0118 5.29969C22.2424 4.27032 21.4709 3.29009 20.4301 3.29009H10.3809C9.8434 3.29009 9.40767 2.84821 9.40767 2.30311C9.40767 1.758 9.8434 1.31611 10.3809 1.31611H20.4301C22.72 1.31611 24.4173 3.47249 23.9098 5.73713L21.8454 14.9491C21.4761 16.5968 20.0318 17.7661 18.3657 17.7661H8.23529C6.56917 17.7661 5.12482 16.5968 4.75559 14.9491L2.08545 3.03387C2.06703 2.95171 2.01821 2.87982 1.94906 2.83306L0.433473 1.80834C-0.0137447 1.50597 -0.13459 0.893172 0.163552 0.439613Z" fill="currentcolor"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M9.39994 9.58112C9.77981 9.19546 10.396 9.19514 10.7762 9.58039L11.9241 10.7433L15.823 6.78909C16.2031 6.40364 16.8193 6.40364 17.1993 6.78909C17.5794 7.17455 17.5794 7.79945 17.1993 8.18491L12.6126 12.8368C12.2327 13.222 11.6168 13.2222 11.2366 12.8371L9.40058 10.9769C9.02039 10.5917 9.02006 9.96671 9.39994 9.58112Z" fill="currentcolor"/>
									</svg>
    							</span>
    							Мої замовлення
    						</a>
    						<a href="#" class="personal-aside-item">
    							<span class="icon">
    								<svg width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M23.2124 3.13679C22.54 2.07134 21.5552 1.23897 20.3922 0.753104C19.0744 0.200393 17.5944 0.100905 16.1121 0.466116C14.7537 0.800834 13.4306 1.52681 12.25 2.57995C11.0693 1.52671 9.74602 0.800693 8.38748 0.466022C6.90515 0.100671 5.42497 0.200253 4.10722 0.753338C2.9442 1.23935 1.95945 2.07189 1.28716 3.13749C0.5831 4.24966 0.224927 5.60216 0.251365 7.04862C0.36874 13.479 9.9548 19.3264 11.8753 20.4334C11.9892 20.499 12.1185 20.5336 12.25 20.5336C12.3816 20.5336 12.5108 20.499 12.6248 20.4334C14.5454 19.3263 24.1323 13.4779 24.2487 7.0475C24.2748 5.60113 23.9165 4.24877 23.2124 3.13679ZM22.7489 7.02057C22.7114 9.0997 21.3244 11.5237 18.7382 14.0304C16.3431 16.3517 13.6187 18.1013 12.25 18.9155C10.8812 18.1015 8.15732 16.3521 5.76247 14.0307C3.17609 11.5242 1.78906 9.10035 1.75109 7.02127C1.70965 4.75108 2.80761 2.92456 4.6881 2.13526C5.3044 1.87803 5.96603 1.74683 6.63393 1.74939C8.3587 1.74939 10.1832 2.5837 11.7152 4.14038C11.785 4.2113 11.8682 4.26762 11.96 4.30607C12.0518 4.34451 12.1504 4.36431 12.2499 4.36431C12.3495 4.36431 12.448 4.34451 12.5398 4.30607C12.6316 4.26762 12.7149 4.2113 12.7846 4.14038C14.9131 1.97778 17.6058 1.20947 19.8112 2.13512C21.6919 2.92413 22.79 4.75038 22.7489 7.02043V7.02057Z" fill="currentcolor" stroke="currentcolor" stroke-width="0.5"/>
									</svg>
    							</span>
    							Вішліст
    						</a>
    						<a href="#" class="personal-aside-item">
    							<span class="icon">
									<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M16.9226 18.6356V20.5372C16.9226 22.6343 15.2404 24.3403 13.1725 24.3403H3.75016C1.68226 24.3403 0 22.6343 0 20.5372V3.80318C0 1.70604 1.68226 0 3.75016 0H13.1725C15.2404 0 16.9226 1.70604 16.9226 3.80318V5.70477C16.9226 6.22993 16.5029 6.65556 15.9851 6.65556C15.4672 6.65556 15.0475 6.22993 15.0475 5.70477V3.80318C15.0475 2.7547 14.2063 1.90159 13.1725 1.90159H3.75016C2.71631 1.90159 1.87508 2.7547 1.87508 3.80318V20.5372C1.87508 21.5856 2.71631 22.4388 3.75016 22.4388H13.1725C14.2063 22.4388 15.0475 21.5856 15.0475 20.5372V18.6356C15.0475 18.1104 15.4672 17.6848 15.9851 17.6848C16.5029 17.6848 16.9226 18.1104 16.9226 18.6356ZM23.3146 10.5369L21.2152 8.40785C20.8489 8.03644 20.2553 8.03644 19.8892 8.40785C19.523 8.77907 19.523 9.38111 19.8892 9.75233L21.3825 11.2669H10.1254C9.6076 11.2669 9.1879 11.6925 9.1879 12.2177C9.1879 12.7429 9.6076 13.1685 10.1254 13.1685H21.3825L19.8892 14.6831C19.523 15.0543 19.523 15.6564 19.8892 16.0276C20.0724 16.2133 20.3122 16.3061 20.5521 16.3061C20.7922 16.3061 21.0321 16.2133 21.2152 16.0276L23.3146 13.8985C24.2285 12.9717 24.2285 11.4638 23.3146 10.5369Z" fill="currentcolor"/>
									</svg>
    							</span>
    							Вийти з аккаунту
    						</a>
    					</div>
    				</div>

    				<div class="personal-content">
	    				<div class="personal-content-block">
	    					<div class="personal-content-title-block">
	    						<div class="personal-content-title">
	    							Контактні дані
	    						</div>
	    					</div>
	    					<div class="personal-form-cont">
	    						<form>
	    							<div class="personal-form-block">
	    								<div class="personal-form-groups">
	    									<div class="personal-form-group">
	    										<div class="form-block">
						                        	<input type="text" name="" value="" class="form-control" placeholder="Ім'я">
							                    </div>
							                    <div class="form-block">
						                        	<input type="text" name="" value="" class="form-control" placeholder="Прізвище">
							                    </div>
							                    <div class="form-block">
						                        	<input type="text" name="" value="" class="form-control" placeholder="Email">
							                    </div>
							                    <div class="form-block">
						                        	<input type="text" name="" value="" class="form-control" placeholder="Дата народження">
							                    </div>
	    									</div>
	    									<div class="personal-form-group">
	    										<div class="form-block">
						                        	<input type="tel" name="" value="" class="form-control" placeholder="Телефон">
							                    </div>
							                    <div class="form-block">
						                        	<div class="password-input">
				                                    	<input size="30" type="password" name="" value="" class="form-control" placeholder="Пароль">
				                                		<div class="password-swap">
				                                			<svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="currentcolor"></path>
																<path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="currentcolor"></path>
															</svg>
															<svg class="password-swap-visible" width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M17.4762 11.2471L19.0665 9.58103C19.1822 10.0346 19.25 10.5087 19.25 11C19.25 14.0328 16.8949 16.5 14 16.5C13.531 16.5 13.0784 16.429 12.6455 16.3077L14.2358 14.6417C15.9747 14.5175 17.3576 13.0687 17.4762 11.2471ZM27.8898 10.5548C27.7821 10.3519 26.2557 7.54993 23.2719 5.17531L21.9986 6.50929C24.1743 8.18518 25.5528 10.1397 26.0956 11.0014C25.0585 12.6558 20.9902 18.3333 14 18.3333C12.9517 18.3333 11.977 18.1929 11.0598 17.9687L9.62194 19.475C10.9438 19.8997 12.3968 20.1667 14 20.1667C23.1597 20.1667 27.701 11.8012 27.8898 11.4453C28.0368 11.1682 28.0368 10.8318 27.8898 10.5548ZM24.2436 1.5648L4.99362 21.7314C4.82278 21.9104 4.59878 22 4.375 22C4.15122 22 3.92722 21.9104 3.75638 21.7314C3.41447 21.3732 3.41447 20.7932 3.75638 20.4353L6.2055 17.8695C2.24612 15.3654 0.234281 11.6793 0.11025 11.4453C-0.03675 11.1682 -0.03675 10.8316 0.11025 10.5545C0.299031 10.1989 4.84028 1.83339 14 1.83339C16.3684 1.83339 18.4198 2.39943 20.1736 3.23634L23.0064 0.26864C23.3483 -0.0895466 23.9019 -0.0895466 24.2436 0.26864C24.5853 0.626826 24.5855 1.20685 24.2436 1.5648ZM7.51034 16.5025L9.72563 14.1818C9.11378 13.2825 8.75 12.186 8.75 11C8.75 7.96724 11.1051 5.50004 14 5.50004C15.132 5.50004 16.1788 5.88115 17.0371 6.52189L18.8285 4.64525C17.4132 4.05148 15.8049 3.66671 14 3.66671C7.00984 3.66671 2.94153 9.3443 1.90466 10.9987C2.56309 12.0441 4.45572 14.6905 7.51034 16.5025ZM10.9959 12.8508L15.7666 7.85289C15.2462 7.53091 14.6471 7.33337 14 7.33337C12.0702 7.33337 10.5 8.97832 10.5 11C10.5 11.6779 10.6886 12.3056 10.9959 12.8508Z" fill="currentcolor"/>
															</svg>
				                                		</div>
				                                	</div>
							                    </div>
							                    <div class="form-block">
							                    	<div class="password-input">
				                                    	<input size="30" type="password" name="" value="" class="form-control" placeholder="Новий пароль">
				                                		<div class="password-swap">
				                                			<svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="currentcolor"></path>
																<path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="currentcolor"></path>
															</svg>
															<svg class="password-swap-visible" width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M17.4762 11.2471L19.0665 9.58103C19.1822 10.0346 19.25 10.5087 19.25 11C19.25 14.0328 16.8949 16.5 14 16.5C13.531 16.5 13.0784 16.429 12.6455 16.3077L14.2358 14.6417C15.9747 14.5175 17.3576 13.0687 17.4762 11.2471ZM27.8898 10.5548C27.7821 10.3519 26.2557 7.54993 23.2719 5.17531L21.9986 6.50929C24.1743 8.18518 25.5528 10.1397 26.0956 11.0014C25.0585 12.6558 20.9902 18.3333 14 18.3333C12.9517 18.3333 11.977 18.1929 11.0598 17.9687L9.62194 19.475C10.9438 19.8997 12.3968 20.1667 14 20.1667C23.1597 20.1667 27.701 11.8012 27.8898 11.4453C28.0368 11.1682 28.0368 10.8318 27.8898 10.5548ZM24.2436 1.5648L4.99362 21.7314C4.82278 21.9104 4.59878 22 4.375 22C4.15122 22 3.92722 21.9104 3.75638 21.7314C3.41447 21.3732 3.41447 20.7932 3.75638 20.4353L6.2055 17.8695C2.24612 15.3654 0.234281 11.6793 0.11025 11.4453C-0.03675 11.1682 -0.03675 10.8316 0.11025 10.5545C0.299031 10.1989 4.84028 1.83339 14 1.83339C16.3684 1.83339 18.4198 2.39943 20.1736 3.23634L23.0064 0.26864C23.3483 -0.0895466 23.9019 -0.0895466 24.2436 0.26864C24.5853 0.626826 24.5855 1.20685 24.2436 1.5648ZM7.51034 16.5025L9.72563 14.1818C9.11378 13.2825 8.75 12.186 8.75 11C8.75 7.96724 11.1051 5.50004 14 5.50004C15.132 5.50004 16.1788 5.88115 17.0371 6.52189L18.8285 4.64525C17.4132 4.05148 15.8049 3.66671 14 3.66671C7.00984 3.66671 2.94153 9.3443 1.90466 10.9987C2.56309 12.0441 4.45572 14.6905 7.51034 16.5025ZM10.9959 12.8508L15.7666 7.85289C15.2462 7.53091 14.6471 7.33337 14 7.33337C12.0702 7.33337 10.5 8.97832 10.5 11C10.5 11.6779 10.6886 12.3056 10.9959 12.8508Z" fill="currentcolor"/>
															</svg>
				                                		</div>
				                                	</div>
							                    </div>
							                    <div class="form-block">
							                    	<div class="password-input">
				                                    	<input size="30" type="password" name="" value="" class="form-control" placeholder="Підтвердження пароля">
				                                		<div class="password-swap">
				                                			<svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="currentcolor"></path>
																<path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="currentcolor"></path>
															</svg>
															<svg class="password-swap-visible" width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M17.4762 11.2471L19.0665 9.58103C19.1822 10.0346 19.25 10.5087 19.25 11C19.25 14.0328 16.8949 16.5 14 16.5C13.531 16.5 13.0784 16.429 12.6455 16.3077L14.2358 14.6417C15.9747 14.5175 17.3576 13.0687 17.4762 11.2471ZM27.8898 10.5548C27.7821 10.3519 26.2557 7.54993 23.2719 5.17531L21.9986 6.50929C24.1743 8.18518 25.5528 10.1397 26.0956 11.0014C25.0585 12.6558 20.9902 18.3333 14 18.3333C12.9517 18.3333 11.977 18.1929 11.0598 17.9687L9.62194 19.475C10.9438 19.8997 12.3968 20.1667 14 20.1667C23.1597 20.1667 27.701 11.8012 27.8898 11.4453C28.0368 11.1682 28.0368 10.8318 27.8898 10.5548ZM24.2436 1.5648L4.99362 21.7314C4.82278 21.9104 4.59878 22 4.375 22C4.15122 22 3.92722 21.9104 3.75638 21.7314C3.41447 21.3732 3.41447 20.7932 3.75638 20.4353L6.2055 17.8695C2.24612 15.3654 0.234281 11.6793 0.11025 11.4453C-0.03675 11.1682 -0.03675 10.8316 0.11025 10.5545C0.299031 10.1989 4.84028 1.83339 14 1.83339C16.3684 1.83339 18.4198 2.39943 20.1736 3.23634L23.0064 0.26864C23.3483 -0.0895466 23.9019 -0.0895466 24.2436 0.26864C24.5853 0.626826 24.5855 1.20685 24.2436 1.5648ZM7.51034 16.5025L9.72563 14.1818C9.11378 13.2825 8.75 12.186 8.75 11C8.75 7.96724 11.1051 5.50004 14 5.50004C15.132 5.50004 16.1788 5.88115 17.0371 6.52189L18.8285 4.64525C17.4132 4.05148 15.8049 3.66671 14 3.66671C7.00984 3.66671 2.94153 9.3443 1.90466 10.9987C2.56309 12.0441 4.45572 14.6905 7.51034 16.5025ZM10.9959 12.8508L15.7666 7.85289C15.2462 7.53091 14.6471 7.33337 14 7.33337C12.0702 7.33337 10.5 8.97832 10.5 11C10.5 11.6779 10.6886 12.3056 10.9959 12.8508Z" fill="currentcolor"/>
															</svg>
				                                		</div>
				                                	</div>
							                    </div>
	    									</div>
	    								</div>
	    							</div>
	    						</form>
	    					</div>
	    				</div>


                    </div>
    			</div>
    		</div>
    	</div>
        */?>

    <?}else{?>

		<?
		global $USER;

		if(!$USER->isAuthorized()){
			LocalRedirect(SITE_DIR.'auth/');
		}
		else{

			if($APPLICATION->GetCurPage() == '/personal/orders/')
			{
				global $DB;
				$DB->Query('update b_sale_order set LID = \''.SITE_ID.'\' where USER_ID = '.$USER->GetID());
			}

			//LocalRedirect(SITE_DIR.'personal/personal-data');?>
			<?
			if(strpos($APPLICATION->GetCurPage(),'/personal/loyalty/') === false)
			{
				?>
				<?$APPLICATION->IncludeComponent(
				"bitrix:sale.personal.section",
				"main",
				array(
					"ACCOUNT_PAYMENT_ELIMINATED_PAY_SYSTEMS" => array(
						0 => "0",
					),
					"ACCOUNT_PAYMENT_PERSON_TYPE" => "1",
					"ACCOUNT_PAYMENT_SELL_SHOW_FIXED_VALUES" => "Y",
					"ACCOUNT_PAYMENT_SELL_TOTAL" => array(
						0 => "100",
						1 => "200",
						2 => "500",
						3 => "1000",
						4 => "5000",
						5 => "",
					),
					"ACCOUNT_PAYMENT_SELL_USER_INPUT" => "Y",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "3600",
					"CACHE_TYPE" => "A",
					"CHECK_RIGHTS_PRIVATE" => "N",
					"COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
					"CUSTOM_PAGES" => "",
					"CUSTOM_SELECT_PROPS" => array(
					),
					"NAV_TEMPLATE" => "",
					"ORDER_HISTORIC_STATUSES" => array(
						0 => "P",
						1 => "F",
					),
					"PATH_TO_BASKET" => "/basket/",
					"PATH_TO_CATALOG" => "/catalog/",
					"PATH_TO_CONTACT" => "/contacts",
					"PATH_TO_PAYMENT" => "/order/payment/",
					//"PATH_TO_LOYALTY" => "/personal/loyalty/",
					"PER_PAGE" => "20",
					"PROP_1" => array(
					),
					"PROP_2" => array(
					),
					"SAVE_IN_SESSION" => "Y",
					"SEF_FOLDER" => "/personal/",
					"SEF_MODE" => "Y",
					"SEND_INFO_PRIVATE" => "N",
					"SET_TITLE" => "Y",
					"SHOW_ACCOUNT_COMPONENT" => "Y",
					"SHOW_ACCOUNT_PAGE" => "N",
					"SHOW_ACCOUNT_PAY_COMPONENT" => "N",
					"SHOW_BASKET_PAGE" => "N",
					"SHOW_CONTACT_PAGE" => "N",
					"SHOW_ORDER_PAGE" => "Y",
					"SHOW_PRIVATE_PAGE" => "Y",
					"SHOW_PROFILE_PAGE" => "N",
					"SHOW_SUBSCRIBE_PAGE" => "N",
					"USER_PROPERTY_PRIVATE" => "",
					"USE_AJAX_LOCATIONS_PROFILE" => "N",
					"COMPONENT_TEMPLATE" => "main",
					"ACCOUNT_PAYMENT_SELL_CURRENCY" => "RUB",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
					"ORDER_HIDE_USER_INFO" => array(
						0 => "0",
					),
					"ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array(
						0 => "0",
					),
					"ORDER_DEFAULT_SORT" => "STATUS",
					"ALLOW_INNER" => "N",
					"ONLY_INNER_FULL" => "N",
					"ORDERS_PER_PAGE" => "20",
					"PROFILES_PER_PAGE" => "20",
					"MAIN_CHAIN_NAME" => "Мой кабинет",
					"SEF_URL_TEMPLATES" => array(
						"index" => "index.php",
						"orders" => "orders/",
						"account" => "account/",
						//"loyalty" => "loyalty/",
						"subscribe" => "subscribe/",
						"profile" => "profiles/",
						"profile_detail" => "profiles/#ID#",
						"private" => "private/",
						"order_detail" => "order/#ID#/",
						"order_cancel" => "cancel/#ID#",
					)
				),
				false
			);?>
				<?
			}

			?>

		<?}?>

<?}?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>