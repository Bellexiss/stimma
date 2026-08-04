<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");

$ru=LANGUAGE_ID=='ru'?'/ru':'';

if(isset($_POST['reset_password']))
{
    $email=$_POST['email'];
    $find = CUser::GetList($by = "ID", $order = "ASC", array("EMAIL" => $email), array("SELECT" => ['UF_*']));
    if($find = $find->Fetch())
    {
        $checkWord = uniqid();

        $fields = [
                'SITE_NAME' => 'Stimma',
                'EMAIL' => $email,
                'MESSAGE' => 'Ви зробили запит на відновлення паролю. Якщо це були не ви, проігноруйте це повідомлення.',
                'NAME' => $find['NAME'],
                'LAST_NAME' => $find['LAST_NAME'],
                'CHECKWORD' => $checkWord,
                'USER_EMAIL' => $email,
        ];

        $user = new CUser;
        $user->Update($find['ID'], ['UF_CHECKWORD' => $checkWord]);

        if(CEvent::SendImmediate('USER_PASS_REQUEST', 's1', $fields, "Y",3))
            LocalRedirect($APPLICATION->GetCurPageParam('send=Y', array('send')));
        else
            LocalRedirect($APPLICATION->GetCurPageParam('send=N', array('send')));
    }
    else
    {
        LocalRedirect($APPLICATION->GetCurPageParam('error=Користувач з таким email не знайдений', array('send')));
    }
}

if(isset($_POST['change_pass']))
{
    $email=$_POST['email'];
    $find = CUser::GetList($by = "ID", $order = "ASC", array("EMAIL" => $email), array("SELECT" => ['UF_*']));
    if($find = $find->Fetch())
    {
        if(empty($_POST['pass']) || empty($_POST['repeat_pass']))
        {
            $json = ['status' => 0];
            $json['msg'] = 'Введіть будь ласка пароль';
        }
        elseif($_POST['pass'] != $_POST['repeat_pass'])
        {
            $json = ['status' => 0];
            $json['msg'] = 'Паролі не співпадають';
        }
        elseif(strlen($_POST['pass']) < 6)
        {
            $json = ['status' => 0];
            $json['msg'] = 'Пароль повинен бути не менше 6 символів';
        }
        elseif($_POST['code'] != $find['UF_CHECKWORD'] || $find['EMAIL'] != $email)
        {
            $json = ['status' => 0];
            $json['msg'] = 'схоже, код введено невірно.<br>спробуйте ще раз або надішліть новий';
        }
        else
        {
            global $USER;
            $user = new CUser;
            $user->Update($find['ID'], ['PASSWORD' => $_POST['pass'],'CONFIRM_PASSWORD' => $_POST['pass'],'UF_CHECKWORD' => '']);
            $json['msg'] = 'Пароль оновлено. Тепер ви можете увійти в акаунт';
            $json['status'] = 1;
            //$USER->Authorize($find['ID']);
        }

        if($json['status'] == 0)
            LocalRedirect($APPLICATION->GetCurPageParam('error='.urlencode($json['msg']), array('error')));
        else
            LocalRedirect($APPLICATION->GetCurPageParam('success='.urlencode($json['msg']), array('error')));

        exit();
    }
}

if(isset($_GET['newstimma']) || NEW_STIMMA)
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
                        Відновлення паролю
                    </span>
                </div>
            </div>
        </div>

        <div class="wrapper">
	        <div class="auth-page">
	        	
	        	<div class="auth-form-cont" style="<?=isset($_GET['forgot-password']) && !isset($_GET['send']) ? 'display:none;' : ''?>">
	        		<form action="<?=$ru?>/auth/forgot/" method="post">
	        			<div class="auth-form">
	        				<div class="auth-inputs">
	        					<div class="auth-inputs-group justify-content-center">
	        						<div class="form-block">
	                                    <input size="30" type="text" name="email" value="" class="form-control" placeholder="Ваш E-mail">
	                                    <div class="input-text">
                                            <?
                                            if(isset($_GET['send']) && $_GET['send'] == 'Y')
                                            {
                                                ?><span style="color:green;">Ми вже надіслали лист, щоб ви відновили пароль.</span><br><?
                                                ?><span style="color:green;font-size:12px;">Не отримали ? Перевірте «Спам» або спробуйте ще раз</span><?
                                            }
                                            elseif(isset($_GET['send']) && $_GET['send'] == 'N')
                                            {
                                                ?>Відбулася системна помилка при віправці листа. Спробуйте ще раз.<?
                                            }
                                            elseif(isset($_GET['error']))
                                            {
                                                ?><span style="color:red;"><?echo $_GET['error'];?></span><?
                                            }
                                            else
                                            {
                                                ?>Контрольний рядок для зміни паролю, а також ваші реєстраційні дані будуть вислані вам по E-Mail.<?
                                            }
                                            ?>
	                                    </div>
	                                </div>
	        					</div>
	        					
	        				</div>
	        				<div class="auth-btn-block">
	        					<button class="info-btn info-btn-black" name="reset_password">
	        						Відновити 
	        					</button>
	        				</div>
	        			</div>
	        		</form>
	        	</div>


	        	<div class="auth-form-cont" style="<?=isset($_GET['forgot-password'])  && !isset($_GET['send']) ? '' : 'display:none;'?>">
	        		<form action="<?=$ru?>/auth/forgot/?forgot-password=yes&USER_CHECKWORD=<?=$_GET['USER_CHECKWORD']?>&USER_EMAIL=<?=$_GET['USER_EMAIL']?>" method="post">
	        			<div class="auth-form">
	        				<div class="auth-inputs">
                                <div class="form-block">
                                    <div class="password-input">
                                        <input size="30" type="text" name="email" value="<?=$_GET['USER_EMAIL']?>" class="form-control" placeholder="Email">
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
                                        <input size="30" type="text" name="code" value="<?=$_GET['USER_CHECKWORD']?>" class="form-control" placeholder="Контрольний рядок">
                                        <div class="password-swap">
                                            <svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="#999999"/>
                                                <path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="#999999"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
	        					<div class="auth-inputs-group">
	        						
	                                <div class="form-block">
	                                	<div class="password-input">
	                                    	<input size="30" type="text" name="pass" value="" class="form-control" placeholder="Новий пароль">
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
	                                    	<input size="30" type="text" name="repeat_pass" value="" class="form-control" placeholder="Повторіть новий пароль">
	                                		<div class="password-swap">
	                                			<svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M27.8206 9.46719C27.5705 9.80935 21.6108 17.8452 13.9991 17.8452C6.38751 17.8452 0.427525 9.80935 0.177671 9.46751C-0.0592236 9.14291 -0.0592236 8.70264 0.177671 8.37803C0.427525 8.03587 6.38751 0 13.9991 0C21.6108 0 27.5705 8.03592 27.8206 8.37776C28.0578 8.70231 28.0578 9.14291 27.8206 9.46719ZM13.9991 1.84605C8.39236 1.84605 3.5363 7.17961 2.0988 8.92324C3.53444 10.6684 8.38033 15.9992 13.9991 15.9992C19.6056 15.9992 24.4614 10.6665 25.8995 8.92198C24.4638 7.17688 19.6179 1.84605 13.9991 1.84605Z" fill="#999999"/>
													<path d="M13.9913 14.4624C10.9376 14.4624 8.45312 11.9779 8.45312 8.92421C8.45312 5.8705 10.9376 3.38601 13.9913 3.38601C17.045 3.38601 19.5295 5.8705 19.5295 8.92421C19.5295 11.9779 17.045 14.4624 13.9913 14.4624ZM13.9913 5.23211C11.9554 5.23211 10.2992 6.88835 10.2992 8.92421C10.2992 10.9601 11.9555 12.6163 13.9913 12.6163C16.0272 12.6163 17.6834 10.9601 17.6834 8.92421C17.6834 6.88835 16.0272 5.23211 13.9913 5.23211Z" fill="#999999"/>
												</svg>
	                                		</div>
	                                	</div>
	                                </div>
	        					</div>
	        				</div>
                            <?
                            if(isset($_GET['error']))
                            {
                                ?><span style="color:red"><?=$_GET['error']?></span><?
                            }
                            if(isset($_GET['success']))
                            {
                                ?><span style="color:green"><?=$_GET['success']?></span><?
                            }
                            ?>
	        				<div class="auth-btn-block">
                                <?
                                if(isset($_GET['success']))
                                {
                                    ?><a href="/personal/" class="info-btn info-btn-black" name="change_pass">
                                        Увійти
                                    </a><?
                                }
                                else
                                {
                                    ?>
                                    <button class="info-btn info-btn-black" name="change_pass">
                                        Оновити пароль
                                    </button>
                                    <?
                                }
                                if(isset($_GET['error']))
                                {
                                    ?>
                                    <button class="info-btn info-btn-black" name="reset_password" style="margin-top: 15px;">
                                        Надіслати код ще раз
                                    </button>
                                    <?
                                }
                                ?>

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