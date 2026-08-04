<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Модний жіночий одяг від українського виробника ТМ STIMMA. Для оптових клієнтів");
$APPLICATION->SetPageProperty("title", "Для оптових клієнтів | Інтернет-магазин STIMMA");
$APPLICATION->SetTitle("ДЛЯ ОПТОВИХ КЛІЄНТІВ");
$uGroups = $USER->GetUserGroupArray();

?>

<?if(isset($_GET['newstimma'])  || NEW_STIMMA)
    {
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
                        Для оптових клієнтів
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
                Співпраця з оптовиками
            </h1>
            <div class="info-page-menu">
                <a href="<?=$ru?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/" class="info-page-menu-item">
                    Переваги співпраці
                </a>
                <a href="<?=$ru?>/cpivrobitnictvo/spivpracya-z-optovikami/" class="info-page-menu-item active">
                    Для оптових клієнтів
                </a>
                <a href="<?=$ru?>/cpivrobitnictvo/rozdribnim-kliyentam/" class="info-page-menu-item">
                    Для роздрібних клієнтів
                </a>
            </div>
            <div class="cooperation-content">
            	<div class="cooperation-title">
            		<b>!Ми співпрацюємо з оптовими клієнтами, які вже мають діючий бізнес.</b>
            	</div>
            	<div class="cooperation-text-block">
            		<div class="cooperation-text-group">
                        <p>
                			<b>
                				Ми пропонуємо:
                			</b>
                        </p>
            			<ul>
            				<li>
            					широкий асортимент жіночого одягу;
            				</li>
            				<li>
            					колекції, які представлені капсулами, одяг з яких завжди гармонійно поєднується між собою;
            				</li>
            				<li>
            					різні стилістичні напрямки: від спортивного до стилю кежуал, від ділового до більш жіночного та романтичного;
            				</li>
            				<li>
            					щотижневе оновлення асортименту;
            				</li>
            				<li>
            					високу швидкість виготовлення одягу, що не впливає на якість та дизайн виробу. Наш бренд виготовляє близько 1000 нових моделей одягу в рік, кожна з яких представлена в декількох кольорах.
            				</li>
            			</ul>
            			<b>Мінімальна сума оптового замовлення 15 000 грн.</b>
            		</div>
            		<div class="cooperation-text-group">
                        <p>
                			<b>
                				Ми гарантуємо:
                			</b>
                        </p>
            			<ul>
            				<li>
            					надання офіційних документів (при необхідності);
            				</li>
            				<li>
            					обмін/повернення при виявленні виробничого дефекту протягом 14 днів (за умови наявності бірки).
            				</li>
            			</ul>
            		</div>
            		<div class="cooperation-text-group">
                        <p>
                			<b>
                				! Важливо:
                			</b>
                            
                        </p>
            			<ul>
            				<li>
            					обов’язкова націнка, не нижче роздрібної вартості на нашому сайті;
            				</li>
            				<li>
								заборонено використання фото з офіційного сайту/instagram для власного інтернет-контенту.
            				</li>
            			</ul>
            		</div>
            		<div class="cooperation-text-group">
            			<b>*На сайті вказані роздрібні ціни.</b>Зареєструйтесь та оберіть статус “оптовий клієнт”. Оптові ціни відображаються після підтвердження менеджером статусу “оптовий клієнт”.
            		</div>
            		<div class="cooperation-text-group">
            			Зареєструйтесь та отримайте комерційну пропозицію співпраці з українським виробником одягу Stimma. Після реєстрації та підтвердження нашого менеджера, вам будуть доступні оптові ціни в нашому каталозі. Також отримуйте спеціальні пропозиції оптової співпраці.
            		</div>
            		<div class="cooperation-form">
	            		<form id="registraion-page-form2" method="post" action="/auth/registration/?register=yes&amp;backurl=%2F" name="regform" enctype="multipart/form-data" novalidate="novalidate">
                            <input type="hidden" name="url" value="<?=$APPLICATION->GetCurPage()?>">
                            <input type="hidden" name="backurl" value="/"> <input type="hidden" name="register_submit_button" value="reg">
                            <div class="form_body">
                                <input size="30" id="input_LOGIN" type="hidden" value="1" name="REGISTER[LOGIN]" aria-required="true">
                                <div class="form-block">
                                    <label for="input_NAME"><span>Прізвище Ім’я По батькові&nbsp;<span class="star">*</span></span></label> 
                                    <input size="30" type="text" id="input_NAME" name="REGISTER[NAME]" required="" value="" aria-required="true" class="form-control">
                                </div>
                                <div class="form-block">
                                    <label for="input_EMAIL"><span>Логін / E-mail&nbsp;<span class="star">*</span></span></label> 
                                    <input size="30" type="email" id="input_EMAIL" name="REGISTER[EMAIL]" required="" value="" aria-required="true" class="form-control">
                                </div>
                                <div class="form-block">
                                    <label for="input_PERSONAL_PHONE"><span>Телефон&nbsp;<span class="star">*</span></span></label> 
                                    <input size="30" type="tel" id="input_PERSONAL_PHONE" name="REGISTER[PERSONAL_PHONE]" class="phone_input form-control" required="" value="" aria-required="true">
                                </div>
                                <div class="form-block" style="display:none;">
                                    <label for="input_UF_UGROUP">Спосіб співпраці&nbsp;</label>
                                        <div class="ik_select common_select" style="position: relative; display: inline-block; width: auto; vertical-align: top;">
                                            <div class="ik_select_link common_select-link">
                                                <span class="ik_select_link_text">Роздрібний клієнт</span>
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
                                                <option value="25">Роздрібний клієнт</option>
                                                <option value="26" selected="">Оптовий клієнт</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="form-block">
                                    <label for="input_PASSWORD"><span>Пароль&nbsp;<span class="star">*</span></span></label> 
                                    <input size="30" type="password" id="input_PASSWORD" name="REGISTER[PASSWORD]" required="" value="" autocomplete="off" class="password form-control" aria-required="true">
                                    <div class="text-block">
                                         Довжина паролю не менше 6 символів.
                                    </div>
                                </div>
                                <div class="form-block">
                                    <label for="input_CONFIRM_PASSWORD"><span>Підтвердження паролю&nbsp;<span class="star">*</span></span></label> 
                                    <input size="30" type="password" id="input_CONFIRM_PASSWORD" name="REGISTER[CONFIRM_PASSWORD]" required="" value="" autocomplete="off" class="confirm_password form-control" aria-required="true" >
                                    </div>
                                    
                                </div>
                                <div class="form_footer">
                                    <div class="licence_block filter label_block">
                                        <input type="checkbox" id="licenses_register" name="licenses_register" checked="" required="" value="Y" aria-required="true"> 
                                        <label for="licenses_register">
                                            Я погоджуюсь на <a href="/pravova-informatsiya/" target="_blank">обробку персональних даних</a> 
                                        </label>
                                    </div>
                                    <button class="info-btn info-btn-black" type="submit" name="register_submit_button1" value="Y">Зареєструватися</button>
                                </div>
                        </form>
            			
            		</div>
            	</div>
            </div>
        </div>

<?}else{

 if(isset($_GET['new']))
    {
        ?>
			<div class="large-9 desktop-padding-left-30 right columns">
				<div class="page-inner">
					 <?
				        if(!in_array(9,$uGroups))
				        {
				            ?>
					<div class="page-banner-mob">
			 <a href="#registraion-page-form2"> <img src="/cpivrobitnictvo/spivpracya-z-optovikami/mob.jpg"> </a>
					</div>
					<div class="page-banner-desc">
						 <?/*<a href="https://www.stimma.com.ua/<?=LANGUAGE_ID=='ru' ? 'ru/' : ''?>auth/registration/?register=yes&backurl=/">*/?> <a href="#registraion-page-form2"> <img src="/cpivrobitnictvo/spivpracya-z-optovikami/desktop.jpg"> </a>
					</div>
					 <?
					        }
					        ?> <article id="post-110634" class="post-110634 page type-page status-publish hentry del-and-pay">
					<div class="entry-header">
					</div>
					<p>
			 <b><span style="color: #000000;">! Ми співпрацюємо з оптовими клієнтами, які вже мають діючий бізнес.</span></b><span style="color: #000000;"> </span>
					</p>
					<p style="text-align: left;">
			 <span style="color: #000000;"> </span><b><span style="color: #000000;"> Ми пропонуємо:</span></b><span style="color: #000000;"> </span>
					</p>
			 <span style="color: #000000;"> </span>
					<div>
			 <span style="color: #000000;"> </span>
						<ul>
							<li style="color: #000000;">знижку на асортимент до - 60% від роздрібної вартості;</li>
							<li style="color: #000000;">можливість замовити як повний розмірний ряд, так і окремі розміри;</li>
							<li style="color: #000000;">щотижневе оновлення асортименту;</li>
							<li style="color: #000000;">лімітовані колекції, що забезпечать унікальність товару;</li>
							<li style="color: #000000;">доступ до оптової спільноти. Можливість замовити колекції до появи на сайті.</li>
						</ul>
						<p>
			 <b>Мінімальна сума оптового замовлення 15 000 грн.</b>
						</p>
			 <span style="color: #000000;"> </span>
					</div>
			 <span style="color: #000000;"> </span>
					<p>
			 <span style="color: #000000;"> </span> <b><span style="color: #000000;">Ми гарантуємо:</span></b>
					</p>
					<div>
						<ul>
							<li>надання офіційних документів (при необхідності) ;</li>
							<li>
							обмін/повернення при виявленні виробничого дефекту протягом 14 днів (за умови наявності бірки). </li>
						</ul>
					</div>
					<p>
			 <span style="color: #000000;"> </span> <b><span style="color: #000000;">! Важливо:</span></b>
					</p>
					<div>
						<ul>
							<li>обов’язкова націнка, не нижче роздрібної вартості на нашому сайті; </li>
							<li>
							заборонено використання фото з офіційного сайту/instagram для власного інтернет-контенту. </li>
						</ul>
					</div>
					<p>
			 <b>*На сайті вказані роздрібні ціни</b>. Зареєструйтесь та оберіть статус “оптовий клієнт”. Оптові ціни відображаються після підтвердження менеджером статусу “оптовий клієнт”.
					</p>
			 </article>
				</div>
			</div>
			 <br>
			 <?
							if(!in_array(9,$uGroups))
							{
							    ?> <style>
							        input.has-error{border-color:#fe5252}
							    </style>
			<div class="success-register" style="text-align: center; color:#414c00;display:none;">
				 Ви успішно зареєструвалися.
			</div>
			<div class="error-register" style="text-align: center; color:#7a0026;display:none;">
				 Ви успішно зареєструвалися.
			</div>
			<form id="registraion-page-form2" method="post" action="/auth/registration/?register=yes&amp;backurl=%2F" name="regform" enctype="multipart/form-data" novalidate="novalidate">
			 <input type="hidden" name="url" value="<?=$APPLICATION->GetCurPage()?>">
				<div class="top-text">
					<p>
						 Зареєструйтесь та отримайте комерційну пропозицію співпраці з українським виробником одягу Stimma. Після реєстрації та підтвердження нашого менеджера, вам будуть доступні оптові ціни в нашому каталозі. Також отримуйте спеціальні пропозиції оптової співпраці.
					</p>
				</div>
			 <input type="hidden" name="backurl" value="/"> <input type="hidden" name="register_submit_button" value="reg">
				<div class="form_body">
			 <input size="30" id="input_LOGIN" type="hidden" value="1" name="REGISTER[LOGIN]" aria-required="true">
					<div class="form-control">
			 <label for="input_NAME"><span>Прізвище Ім’я По батькові&nbsp;<span class="star">*</span></span></label> <input size="30" type="text" id="input_NAME" name="REGISTER[NAME]" required="" value="" aria-required="true">
					</div>
					<div class="form-control">
			 <label for="input_EMAIL"><span>Логін / E-mail&nbsp;<span class="star">*</span></span></label> <input size="30" type="email" id="input_EMAIL" name="REGISTER[EMAIL]" required="" value="" aria-required="true">
					</div>
					<div class="form-control">
			 <label for="input_PERSONAL_PHONE"><span>Телефон&nbsp;<span class="star">*</span></span></label> <input size="30" type="tel" id="input_PERSONAL_PHONE" name="REGISTER[PERSONAL_PHONE]" class="phone_input " required="" value="" aria-required="true">
					</div>
					<div class="form-control" style="display:none;">
			 <label for="input_UF_UGROUP">Спосіб співпраці&nbsp;</label>
						<div class="ik_select common_select" style="position: relative; display: inline-block; width: auto; vertical-align: top;">
							<div class="ik_select_link common_select-link">
			 <span class="ik_select_link_text">Роздрібний клієнт</span>
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
								<option value="25">Роздрібний клієнт</option>
								<option value="26" selected="">Оптовий клієнт</option>
							</select>
						</div>
					</div>
					<div class="form-control">
			 <label for="input_PASSWORD"><span>Пароль&nbsp;<span class="star">*</span></span></label> <input size="30" type="password" id="input_PASSWORD" name="REGISTER[PASSWORD]" required="" value="" autocomplete="off" class="password " aria-required="true">
						<div class="text-block">
							 Довжина паролю не менше 6 символів.
						</div>
					</div>
					<div class="form-control">
			 <label for="input_CONFIRM_PASSWORD"><span>Підтвердження паролю&nbsp;<span class="star">*</span></span></label> <input size="30" type="password" id="input_CONFIRM_PASSWORD" name="REGISTER[CONFIRM_PASSWORD]" required="" value="" autocomplete="off" class="confirm_password " aria-required="true">
					</div>
					<div class="clearboth">
					</div>
				</div>
				<div class="form_footer">
					<div class="licence_block filter label_block onoff">
			 <input type="checkbox" id="licenses_register" name="licenses_register" checked="" required="" value="Y" aria-required="true"> <label for="licenses_register">
						Я погоджуюсь на <a href="/pravova-informatsiya/" target="_blank">обробку персональних даних</a> </label>
					</div>
			 <button class="btn btn-default btn-lg" type="submit" name="register_submit_button1" value="Y">Зареєструватися</button>
					<div class="clearboth">
					</div>
				</div>
			</form>
			 <script>
					        $(document).ready(function()
					        {
					            $(document).on('click', '[name=register_submit_button1]', function()
					            {
					                error = false;
					                $('.has-error').removeClass('has-error');
					                $('.error-register').hide();

					                obj = $(this);

					                form=$(this).closest('form');
					                if($(form).find('[name="REGISTER[EMAIL]"]').val() == '') {error = true;$(form).find('[name="REGISTER[EMAIL]"]').addClass('has-error')}
					                if($(form).find('[name="REGISTER[PERSONAL_PHONE]"]').val() == '') {error = true;$(form).find('[name="REGISTER[PERSONAL_PHONE]"]').addClass('has-error')}
					                if($(form).find('[name="REGISTER[PASSWORD]"]').val() == '') {error = true;$(form).find('[name="REGISTER[PASSWORD]"]').addClass('has-error')}
					                if($(form).find('[name="REGISTER[CONFIRM_PASSWORD]"]').val() == '') {error = true;$(form).find('[name="REGISTER[CONFIRM_PASSWORD]"]').addClass('has-error')}
					                if($(form).find('[name="REGISTER[PASSWORD]"]').val() != $(form).find('[name="REGISTER[CONFIRM_PASSWORD]"]').val()) {error = true;$(form).find('[name="REGISTER[PASSWORD]"]').addClass('has-error');$(form).find('[name="REGISTER[CONFIRM_PASSWORD]"]').addClass('has-error')}
					                if(!$('#licenses_register').prop('checked')) {error = true;}

					                form = $(this).closest('form').serialize();

					                if(!error)
					                    $.ajax({
					                        url: '/ajax/new/register.php',
					                        data: form,
					                        type: 'POST',
					                        dataType:'json'
					                    }).done(function(html)
					                    {
					                        if(html.result == 'error')
					                        {
					                            $('.error-register').html(html.message);
					                            $('.error-register').show();
					                        }
					                        else
					                        {
					                            dataLayer.push({'event': 'form_submit_opt'})
					                            $('#registraion-page-form2').hide();
					                            $('.success-register').show();
					                        }
					                        /*if(location.href.indexOf('/ru/') != -1)
					                            $(obj).closest('.reviews-form').html('<div style="color:#3D441D">Ваш отзыв добавлен. После модерации он появится на сайте.</div>')
					                        else
					                            $(obj).closest('.reviews-form').html('<div style="color:#3D441D">Ваш відгук додано. Після модерації він з’явиться на сайті.</div>')*/
					                    });

					                return false;
					            })
					        })
					    </script> <?
							}
						?> <?
						    }
						    else
						    {?>
						<div id="content" class="large-9 desktop-padding-left-30 right columns">
							<div class="page-inner">
								 <?
							        if(!in_array(9,$uGroups))
							        {
							            ?>
								<div class="page-banner-mob">
						 <a href="#registraion-page-form2"> <img src="/cpivrobitnictvo/spivpracya-z-optovikami/mob.jpg"> </a>
								</div>
								<div class="page-banner-desc">
									 <?/*<a href="https://www.stimma.com.ua/<?=LANGUAGE_ID=='ru' ? 'ru/' : ''?>auth/registration/?register=yes&backurl=/">*/?> <a href="#registraion-page-form2"> <img src="/cpivrobitnictvo/spivpracya-z-optovikami/desktop.jpg"> </a>
								</div>
								 <?
								        }
								        ?> <article id="post-110634" class="post-110634 page type-page status-publish hentry">
								<div class="entry-header">
								</div>
								<p>
						 <b><span style="color: #000000;">! Ми співпрацюємо з оптовими клієнтами, які вже мають діючий бізнес.</span></b><span style="color: #000000;"> </span>
								</p>
								<p style="text-align: left;">
						 <span style="color: #000000;"> </span><b><span style="color: #000000;"> Ми пропонуємо:</span></b><span style="color: #000000;"> </span>
								</p>
						 <span style="color: #000000;"> </span>
								<div>
						 <span style="color: #000000;"> </span>
									<ul>
										<li style="color: #000000;">знижку на асортимент до - 60% від роздрібної вартості;</li>
										<li style="color: #000000;">можливість замовити як повний розмірний ряд, так і окремі розміри;</li>
										<li style="color: #000000;">щотижневе оновлення асортименту;</li>
										<li style="color: #000000;">лімітовані колекції, що забезпечать унікальність товару;</li>
										<li style="color: #000000;">доступ до оптової спільноти. Можливість замовити колекції до появи на сайті.</li>
									</ul>
						 <span style="color: #000000;"> </span>
								</div>
						 <span style="color: #000000;"> </span>
								<p>
						 <b>Мінімальна сума оптового замовлення 15 000 грн.</b>
								</p>
								<p>
						 <span style="color: #000000;"> </span><b><span style="color: #000000;">Ми гарантуємо:</span></b>
								</p>
								<div>
									<ul>
										<li>надання офіційних документів (при необхідності) ;</li>
										<li>обмін/повернення при виявленні виробничого дефекту протягом 14 днів (за умови наявності бірки).</li>
									</ul>
								</div>
								<p>
						 <span style="color: #000000;"> </span><b><span style="color: #000000;">! Важливо:</span></b>
								</p>
								<div>
									<ul>
										<li>обов’язкова націнка, не нижче роздрібної вартості на нашому сайті;</li>
										<li>заборонено використання фото з офіційного сайту/instagram для власного інтернет-контенту.</li>
									</ul>
								</div>
								<p>
						 <b>*На сайті вказані роздрібні ціни.</b> Зареєструйтесь та оберіть статус “оптовий клієнт”. Оптові ціни відображаються після підтвердження менеджером статусу “оптовий клієнт”.
								</p>
						 </article>
							</div>
						</div>
						 <br>
						 <?
										if(!in_array(9,$uGroups))
										{
										    ?> <style>
										        input.has-error{border-color:#fe5252}
										    </style>
						<div class="success-register" style="text-align: center; color:#414c00;display:none;">
							 Ви успішно зареєструвалися.
						</div>
						<div class="error-register" style="text-align: center; color:#7a0026;display:none;">
							 Ви успішно зареєструвалися.
						</div>
						<form id="registraion-page-form2" method="post" action="/auth/registration/?register=yes&amp;backurl=%2F" name="regform" enctype="multipart/form-data" novalidate="novalidate">
						 <input type="hidden" name="url" value="<?=$APPLICATION->GetCurPage()?>">
							<div class="top-text">
								 Зареєструйтесь та отримайте комерційну пропозицію співпраці з українським виробником одягу Stimma. Після реєстрації та підтвердження нашого менеджера, вам будуть доступні оптові ціни в нашому каталозі. Також отримуйте спеціальні пропозиції оптової співпраці.
							</div>
						 <input type="hidden" name="backurl" value="/"> <input type="hidden" name="register_submit_button" value="reg">
							<div class="form_body">
						 <input size="30" id="input_LOGIN" type="hidden" value="1" name="REGISTER[LOGIN]" aria-required="true">
								<div class="form-control">
						 <label for="input_NAME"><span>Прізвище Ім’я По батькові&nbsp;<span class="star">*</span></span></label> <input size="30" type="text" id="input_NAME" name="REGISTER[NAME]" required="" value="" aria-required="true">
								</div>
								<div class="form-control">
						 <label for="input_EMAIL"><span>Логін / E-mail&nbsp;<span class="star">*</span></span></label> <input size="30" type="email" id="input_EMAIL" name="REGISTER[EMAIL]" required="" value="" aria-required="true">
								</div>
								<div class="form-control">
						 <label for="input_PERSONAL_PHONE"><span>Телефон&nbsp;<span class="star">*</span></span></label> <input size="30" type="tel" id="input_PERSONAL_PHONE" name="REGISTER[PERSONAL_PHONE]" class="phone_input " required="" value="" aria-required="true">
								</div>
								<div class="form-control" style="display:none;">
						 <label for="input_UF_UGROUP">Спосіб співпраці&nbsp;</label>
									<div class="ik_select common_select" style="position: relative; display: inline-block; width: auto; vertical-align: top;">
										<div class="ik_select_link common_select-link">
						 <span class="ik_select_link_text">Роздрібний клієнт</span>
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
											<option value="25">Роздрібний клієнт</option>
											<option value="26" selected="">Оптовий клієнт</option>
										</select>
									</div>
								</div>
								<div class="form-control">
						 <label for="input_PASSWORD"><span>Пароль&nbsp;<span class="star">*</span></span></label> <input size="30" type="password" id="input_PASSWORD" name="REGISTER[PASSWORD]" required="" value="" autocomplete="off" class="password " aria-required="true">
									<div class="text-block">
										 Довжина паролю не менше 6 символів.
									</div>
								</div>
								<div class="form-control">
						 <label for="input_CONFIRM_PASSWORD"><span>Підтвердження паролю&nbsp;<span class="star">*</span></span></label> <input size="30" type="password" id="input_CONFIRM_PASSWORD" name="REGISTER[CONFIRM_PASSWORD]" required="" value="" autocomplete="off" class="confirm_password " aria-required="true">
								</div>
								<div class="clearboth">
								</div>
							</div>
							<div class="form_footer">
								<div class="licence_block filter label_block onoff">
						 <input type="checkbox" id="licenses_register" name="licenses_register" checked="" required="" value="Y" aria-required="true"> <label for="licenses_register">
									Я погоджуюсь на <a href="/pravova-informatsiya/" target="_blank">обробку персональних даних</a> </label>
								</div>
						 <button class="btn btn-default btn-lg" type="submit" name="register_submit_button1" value="Y">Зареєструватися</button>
								<div class="clearboth">
								</div>
							</div>
						</form>
											    <script>
											        $(document).ready(function()
											        {
											            $(document).on('click', '[name=register_submit_button1]', function()
											            {
											                error = false;
											                $('.has-error').removeClass('has-error');
											                $('.error-register').hide();

											                obj = $(this);

											                form=$(this).closest('form');
											                if($(form).find('[name="REGISTER[EMAIL]"]').val() == '') {error = true;$(form).find('[name="REGISTER[EMAIL]"]').addClass('has-error')}
											                if($(form).find('[name="REGISTER[PERSONAL_PHONE]"]').val() == '') {error = true;$(form).find('[name="REGISTER[PERSONAL_PHONE]"]').addClass('has-error')}
											                if($(form).find('[name="REGISTER[PASSWORD]"]').val() == '') {error = true;$(form).find('[name="REGISTER[PASSWORD]"]').addClass('has-error')}
											                if($(form).find('[name="REGISTER[CONFIRM_PASSWORD]"]').val() == '') {error = true;$(form).find('[name="REGISTER[CONFIRM_PASSWORD]"]').addClass('has-error')}
											                if($(form).find('[name="REGISTER[PASSWORD]"]').val() != $(form).find('[name="REGISTER[CONFIRM_PASSWORD]"]').val()) {error = true;$(form).find('[name="REGISTER[PASSWORD]"]').addClass('has-error');$(form).find('[name="REGISTER[CONFIRM_PASSWORD]"]').addClass('has-error')}
											                if(!$('#licenses_register').prop('checked')) {error = true;}

											                form = $(this).closest('form').serialize();

											                if(!error)
											                    $.ajax({
											                        url: '/ajax/new/register.php',
											                        data: form,
											                        type: 'POST',
											                        dataType:'json'
											                    }).done(function(html)
											                    {
											                        if(html.result == 'error')
											                        {
											                            $('.error-register').html(html.message);
											                            $('.error-register').show();
											                        }
											                        else
											                        {
											                            dataLayer.push({'event': 'form_submit_opt'})
											                            $('#registraion-page-form2').hide();
											                            $('.success-register').show();
											                        }
											                        /*if(location.href.indexOf('/ru/') != -1)
											                            $(obj).closest('.reviews-form').html('<div style="color:#3D441D">Ваш отзыв добавлен. После модерации он появится на сайте.</div>')
											                        else
											                            $(obj).closest('.reviews-form').html('<div style="color:#3D441D">Ваш відгук додано. Після модерації він з’явиться на сайті.</div>')*/
											                    });

											                return false;
											            })
											        })
											    </script>
										    <?
							}
						?>
    <?}

}
    
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>