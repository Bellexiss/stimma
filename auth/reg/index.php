<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");



if(isset($_GET['newstimma']) || NEW_STIMMA )
    {?>

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
                        Вхід та Реєстрація
                    </span>
                </div>
            </div>
        </div>

        <div class="wrapper">

	        <div class="auth-page">
	        	<div class="auth-tabs-cont">
	        		<a href="#" class="auth-link">
	        			BXІД
	        		</a>
	        		<a href="#" class="auth-link active">
	        			PEЄCTPAЦІЯ
	        		</a>
	        	</div>
	        	<div class="auth-reg-text">
	        		Зареєструйтесь, щоб використовувати всі можливості особистого кабінету: відслідковування замовлення, налаштування підписки, зв’язки з соціальними мережами та інше. Ми ніколи і ні при яких умовах не розголошуємо особисті дані клієнтів. Контактна інформація буде використана тільки для оформлення замовлень та більш зручної роботи з сайтом.
	        	</div>
	        	<div class="auth-form-cont">
	        		<form>
	        			<div class="auth-form">
	        				<div class="auth-inputs">
	        					<div class="auth-inputs-group">
	        						<div class="form-block">
	                                    <input size="30" type="text" name="" value="" class="form-control" placeholder="Ваше Ім’я">
	                                </div>
	                                <div class="form-block">
	                                	<input size="30" type="text" name="" value="" class="form-control" placeholder="Прізвище">
	                                </div>
	        					</div>
	        					<div class="auth-inputs-group">
	        						<div class="form-block">
	                                    <input size="30" type="text" name="" value="" class="form-control" placeholder="Телефон">
	                                </div>
	                                <div class="form-block">
	                                	<input size="30" type="text" name="" value="" class="form-control" placeholder="Ваш E-mail">
	                                </div>
	        					</div>
	        					<div class="auth-inputs-group">
	                                <div class="form-block">
	                                	<div class="password-input">
	                                    	<input size="30" type="text" name="" value="" class="form-control" placeholder="Пароль">
	                                		<div class="password-swap">
	                                			<svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="#999999"/>
													<path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="#999999"/>
												</svg>
	                                		</div>
	                                	</div>
	                                </div>
	        						<div class="form-block">
	                                    <select class="form-select">
	                                    	<option>
	                                    		Спосіб співпраці
	                                    	</option>
	                                    	<option>
	                                    		Спосіб 1
	                                    	</option>
	                                    	<option>
	                                    		Спосіб 1
	                                    	</option>
	                                    	<option>
	                                    		Спосіб 1
	                                    	</option>
	                                    	<option>
	                                    		Спосіб 1
	                                    	</option>
	                                    	<option>
	                                    		Спосіб 1
	                                    	</option>
	                                    	<option>
	                                    		Спосіб 1
	                                    	</option>
	                                    </select>
	                                </div>
	        					</div>
	        					<div class="licence_block filter label_block">
	                                <input type="checkbox" id="oferta_agree" name="oferta_agree" > 
	                                <label for="oferta_agree">
	                                    Я погоджуюсь з договором оферти і політикую конфіденційності
	                                </label>
	                            </div>
		        				<div class="auth-btn-block">
		        					<button class="info-btn info-btn-black">
		        						Зареєструватись
		        					</button>
		        				</div>
	        				</div>
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
	        			</div>
	        		</form>
	        	</div>
	        </div>
        	
        </div>


<?}else{





if(isset($_POST['USER_LOGIN']) || isset($_REQUEST['USER_LOGIN']))
{
    ?><pre><?=print_r($_POST, 1)?></pre><?
    die();
    $phoneNumber = \Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($_POST['USER_LOGIN']);
    $user = CUser::GetList($by = 'ID', $order = 'DESC', ['PERSONAL_PHONE' => $phoneNumber],['SELECT'=>['UF_PHONE_CODE']]);

    if ($buyer = $user -> Fetch())
    {
        if($_POST['USER_PASSWORD'] == $buyer['UF_PHONE_CODE'])
        {
            die('yes');
        }
    }
}

?>
	<style>
		.form-control > [name=UF_REG_POPUP]{
			display: none;
		}
	</style>
<?$APPLICATION->IncludeComponent("aspro:auth.max", "main", array(
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "/auth/",
	"SEF_URL_TEMPLATES" => array(
		"auth" => "N",
		"registration" => "registration/",
		"forgot" => "forgot-password/",
		"change" => "change-password/",
		"confirm" => "confirm-password/",
		"confirm_registration" => "confirm-registration/",
	),
	"PERSONAL" => "/personal/"
	),
	false
);?>

<?}?>
	
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>