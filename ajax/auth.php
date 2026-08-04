<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
global $USER;

if($_GET['auth_service_error']){
	LocalRedirect(SITE_DIR.'personal/');
}
?>
<?if(!$USER->IsAuthorized()):?>

	<script src="<?=SITE_TEMPLATE_PATH.'/js/phoneorlogin.min.js'?>"></script>
	<?if(isset($_REQUEST['backurl']) && $_REQUEST['backurl']){
		// fix ajax url
		if($_REQUEST['backurl'] != $_SERVER['REQUEST_URI']){
			$_SERVER['QUERY_STRING'] = '';
			$_SERVER['REQUEST_URI'] = $_REQUEST['backurl'];
			$APPLICATION->reinitPath();
		}
	}?>
    <style>
        .change_type_auth.active{text-decoration: underline;}
    </style>
    <script>
        $(document).on('click','.change_type_auth',function()
        {
            $('.change_type_auth').removeClass('active');
            $(this).addClass('active');
        });
        $(document).on('click','.va1',function()
        {
            console.log('adasdasdasd-1');
            $('#ajax_auth').hide();
            $('#ajax_auth2').show();
        });
        $(document).on('click','.va2',function()
        {
            console.log('adasdasdasd-2');
            $('#ajax_auth').show();
            $('#ajax_auth2').hide();
        });
    </script>
	<a href="#" class="close jqmClose"><?=CMax::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg')?></a>
	<div id="wrap_ajax_auth" class="form">
		<div class="form_head fh1" ">
            <h2 class="change_type_auth va1" style="display:inline;margin-right:36px;font-size:22px;"><?=strpos($_GET['backurl'], '/ru/') !== false ? 'По телефону' : 'Вхід по телефону'//=\Bitrix\Main\Localization\Loc::getMessage('AUTHORIZE_TITLE');?></h2>

			<h2 class="change_type_auth va2 active" style="font-size:22px;display:inline;"><?=strpos($_GET['backurl'], '/ru/') !== false ? 'Личный кабинет' : 'Особистий кабінет'//=\Bitrix\Main\Localization\Loc::getMessage('AUTHORIZE_TITLE');?></h2>
		</div>

    <div id="ajax_auth2" class="pk-page pp1-1" style="display:none;">
        <div class="auth_wrapp">
            <div class="wrap_md1">
                <div class="form">
                    <div class="error auth_global_error"  style="text-align: center;color: #ff0000;display:none;">Телефон або пароль не правильні</div>
                    <form id="auth-page-form2" name="system_auth_phone" method="post" target="_top" action="/auth/?login=yes" novalidate="novalidate">
                        <div class="form_body">
                            <div class="form-control">
                                <label for="USER_LOGIN_POPUP" ><span>Телефон&nbsp;<span class="required-star">*</span></span></label>
                                <label id="USER_LOGIN_PHONE-error" style="display:none;" class="error" alt="Заповніть це поле" title="Заповніть це поле" for="USER_LOGIN_PHONE">Заповніть це поле</label>
                                <input type="text" name="USER_LOGIN_PHONE" class="required valid" maxlength="50" value="" tabindex="1" aria-required="true" aria-invalid="false">
                            </div>
                            <div class="form-control">
                                <label for="USER_PASSWORD_POPUP" ><span>Пароль&nbsp;<span class="required-star">*</span></span></label>
                                <label id="USER_PASSWORD_PHONE-error" style="display:none;" class="error" alt="Заповніть це поле" title="Заповніть це поле" for="USER_LOGIN_POPUP">Заповніть це поле</label>
                                <input type="password" name="USER_PASSWORD_PHONE" class="required password" maxlength="50" value="" autocomplete="off" tabindex="2" aria-required="true">
                            </div>

                        </div>
                        <div class="form_footer">
                            <div class="filter block">
                                <div class="prompt remember pull-left onoff">
                                    <input type="checkbox" name="USER_REMEMBER2" value="Y" tabindex="5">
                                    <label for="USER_REMEMBER_frm" title="Запам’ятати мене" tabindex="5">Запам’ятати мене</label>
                                </div>
                                <a class="forgot pull-right" href="/auth/forgot-password/?forgot-password=yes&amp;backurl=/" tabindex="4">Забули пароль?</a>
                                <div class="clearfix"></div>
                            </div>
                            <div class="buttons clearfix" style="margin-top:33px;">
                                <button class="btn btn-default btn-lg" type="submit" name="Login11" value="Y" tabindex="3"><span>Увійти</span></button>
                                <!--noindex--><a href="/auth/registration/?register=yes&amp;backurl=/" rel="nofollow" class="btn btn-transparent-border-color btn-lg pull-right register" tabindex="6">Реєстрація</a><!--/noindex-->
                                <div class="clearboth"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function()
            {
                $('[name=USER_LOGIN_PHONE]').inputmask("mask", { mask: '+389 (99) 999-99-99' });

                $(document).on('click','[name=Login11]',function()
                {
                    var error= false;

                    $('#USER_LOGIN_PHONE-error').hide();
                    $('#USER_PASSWORD_PHONE').hide();
                    $('.auth_global_error').hide();
                    $('[name=USER_LOGIN_PHONE]').removeClass('error');
                    $('[name=USER_PASSWORD_PHONE]').removeClass('error');

                    if($('[name=USER_LOGIN_PHONE]').val() == '')
                    {
                        $('#USER_LOGIN_PHONE-error').show();
                        error= true;
                        $('[name=USER_LOGIN_PHONE]').addClass('error');
                    }
                    if($('[name=USER_PASSWORD_PHONE]').val() == '')
                    {
                        $('#USER_PASSWORD_PHONE').show();
                        error= true;
                        $('[name=USER_PASSWORD_PHONE]').addClass('error');
                    }

                    if(!error)
                    $.ajax({
                        url: '/ajax/new/auth.php',
                        dataType: "json",
                        type: "POST",
                        data: {USER_LOGIN_PHONE:$('[name=USER_LOGIN_PHONE]').val(),USER_PASSWORD_PHONE:$('[name=USER_PASSWORD_PHONE]').val()},
                        success: function(response)
                        {
                            if(response.status == 0)
                                $('.auth_global_error').show();
                            else location.reload();
                        },
                    })

                    return false;
                });
            });
        </script>
    </div>


		<?
		$APPLICATION->IncludeComponent(
			"bitrix:system.auth.form",
			"main",
			Array(
				"REGISTER_URL" => SITE_DIR."auth/registration/?register=yes",
				"PROFILE_URL" => SITE_DIR."auth/",
				"FORGOT_PASSWORD_URL" => SITE_DIR."auth/forgot-password/?forgot-password=yes",
				"AUTH_URL" => SITE_DIR."auth/",
				"SHOW_ERRORS" => "Y",
				"POPUP_AUTH" => "Y",
				"AJAX_MODE" => "Y",
				"BACKURL" => ((isset($_REQUEST['backurl']) && $_REQUEST['backurl']) ? $_REQUEST['backurl'] : "")
			)
		);?>
	</div>
<?elseif(strlen($_REQUEST['backurl'])):?>
	<?LocalRedirect($_REQUEST['backurl']);?>
<?else:?>
	<?if(strpos($_SERVER['HTTP_REFERER'], SITE_DIR.'personal/') === false && strpos($_SERVER['HTTP_REFERER'], SITE_DIR.'ajax/form.php') === false):?>
		<?
        $APPLICATION->ShowHead();
		?>
		<script>
		jsAjaxUtil.ShowLocalWaitWindow('id', 'wrap_ajax_auth', true);
		BX.reload(false)
		</script>
	<?else:?>
		<?LocalRedirect(SITE_DIR.'personal/');?>
	<?endif;?>
<?endif;?>