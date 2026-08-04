<?
$bIndex = (strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false) || isset($_GET['google']);

global $DB;
$mainColors = [];
$res = $DB -> Query('select * from main_colors');
while($record = $res -> Fetch())
    $mainColors[$record['UF_NAME']] = $record['UF_NAME_UA'];
?>
						<?CMax::checkRestartBuffer();?>
						<?IncludeTemplateLangFile(__FILE__);?>
                        <?//$isIndex == ($APPLICATION -> GetCurPage() == '/' || $APPLICATION -> GetCurPage() == '/ru/')?>
							<?if(!$isIndex):?>
								<?if($isHideLeftBlock && !$isWidePage):?>
									</div> <?// .maxwidth-theme?>
								<?endif;?>
								</div> <?// .container?>
							<?else:?>
								<?CMax::ShowPageType('indexblocks');?>
							<?endif;?>
							<?CMax::get_banners_position('CONTENT_BOTTOM');?>
						</div> <?// .middle?>
					<?//if(($isIndex && $isShowIndexLeftBlock) || (!$isIndex && !$isHideLeftBlock) && !$isBlog):?>
					<?if(($isIndex && ($isShowIndexLeftBlock || $bActiveTheme)) || (!$isIndex && !$isHideLeftBlock)):?>
						</div> <?// .right_block?>
						<?if($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") != "Y" && !defined("ERROR_404")):?>
							<?CMax::ShowPageType('left_block');?>
						<?endif;?>
					<?endif;?>
					</div> <?// .container_inner?>
				<?if($isIndex):?>
					</div>
				<?elseif(!$isWidePage):?>
					</div> <?// .wrapper_inner?>
				<?endif;?>
			</div> <?// #content?>
			<?CMax::get_banners_position('FOOTER');?>
		</div><?// .wrapper?>

<?


global $APPLICATION;
$curPage = $APPLICATION->GetCurPage(false);
if ($curPage == '/') {
	?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "STIMMA",
  "url": "https://www.stimma.com.ua/",
  "logo": "https://www.stimma.com.ua/upload/CMax/95f/ewzwz7j9wwwn3jf0i974xt1thzfog3p6.svg",
  "sameAs": [
    "https://www.facebook.com/stimma2016/",
    "https://www.instagram.com/stimma_official/",
    "https://www.youtube.com/channel/UCYbanVf9TfoB3sZ3FZDkGng"
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+380800300068",
    "contactType": "Customer Service",
    "areaServed": "UA",
    "availableLanguage": ["uk", "ru"]
  }
}
</script>
	
	<?php
}

global $USER;
    /*echo '<pre>';
    print_r($USER);
    echo '</pre>';*/
    ?>
<div class="action-form-cont">
        <form class="action-form-block">
            <div class="action-form-title">
                <?=LANGUAGE_ID=='ua'?'-10% знижки на першу купівлю** за підписку на розсилку':'-10% скидки на первую покупку** за подписку на рассылку'?>
            </div>
            <div class="action-form-text">
                <p>
                    <?=LANGUAGE_ID=='ua'?'Долучайся, щоб якнайшвидше дізнаватися про нові колекції та акції':'Присоединяйся, что бы как можно быстрее узнавать о новых коллекциях и акциях'?>
                </p>
                <p class="light">
                    <?=LANGUAGE_ID=='ua'?
                            '** Знижка є одноразовою та діє лише на новинки (товари з чорними цінниками). Промокод не поєднується з іншими акціями та може не розповсюджуватися на деякі товари. Деталі за посиланням:':
                            '** Скидка единоразовая и действует лишь на новинки (товары с черными ценниками). Промокод не обьединяется с другими акциями и может не распространяться на некоторые товары. Детали по ссылке:'?>
                </p>
            </div>
            <div class="d-flex flex-column">
	            <div class="action-form-email">
	                <input type="text" name="subscribe_email" placeholder="Ваш E-mail">
	                <button class="subscribe_me">
	                    <?=LANGUAGE_ID=='ua'?'Я з вами':'Я с вами'?>
	                </button>
	                
	            </div>
	            <div class="subscribe_result"></div>
            </div>
        </form>
    <div class="action-form-block">
        <div class="action-form-title">
            <?=LANGUAGE_ID=='ua'?'САМА СОБІ STIMMA':'САМА СЕБЕ STIMMA'?>
        </div>
        <div class="action-form-text">
            <p>
                <?=LANGUAGE_ID=='ua'?'Реєструйся, щоб заощаджувати й отримувати усі плюси':'Регистрируйся, что бы сэкономить и получить все плюсы'?>
            </p>
        </div>
        <div class="action-form-btn">
            <a href="/sama_sobi/" rel="noopener noreferrer">
                <?=LANGUAGE_ID=='ua'?'Хочу дізнатися':'Хочу узнать'?>
            </a>
        </div>
    </div>
</div>



		<footer id="footer">
			<?/*include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/under_footer.php'));*/?>
			<?/*include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/top_footer.php'));*/?>
			<div class="footer-cont">
				<div class="footer-block">
					<?/*<div class="footer-logo">
						<a href="#">
							<!-- <img src="/bitrix/templates/aspro_max/images/stimma.png"> -->
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1164.53 223" style="enable-background:new 0 0 1164.53 223;" xml:space="preserve">
								<g>
									<g>
										<path d="M167.24,133.23c0,5.86-1.09,11.03-3.23,15.38c-2.12,4.29-4.98,7.96-8.53,10.93c-3.43,2.87-7.43,5.2-11.9,6.91
											c-4.21,1.61-8.69,2.87-13.3,3.75c-4.54,0.86-9.19,1.43-13.81,1.69c-4.51,0.27-8.86,0.4-12.94,0.4c-10.72,0-20.81-0.9-29.98-2.67
											c-9.13-1.77-17.34-4-24.39-6.65l-3.42-1.29v-37.79l7.83,4.35c6.58,3.64,14.21,6.55,22.69,8.62c8.54,2.09,17.82,3.15,27.58,3.15
											c5.73,0,10.41-0.3,13.91-0.88c4.14-0.7,6.42-1.5,7.6-2.05c1.75-0.81,2.18-1.37,2.19-1.37c0.16-0.25,0.24-0.42,0.27-0.51
											c-0.04-0.02-0.15-0.14-0.35-0.3c-0.73-0.6-2.14-1.5-4.73-2.42c-2.43-0.87-5.36-1.69-8.68-2.44c-3.49-0.78-7.21-1.57-11.13-2.35
											c-4-0.8-8.11-1.67-12.34-2.59c-4.35-0.96-8.62-2.1-12.71-3.39c-4.16-1.31-8.17-2.87-11.9-4.63c-3.94-1.86-7.47-4.11-10.48-6.68
											c-3.17-2.72-5.71-5.92-7.56-9.51c-1.91-3.73-2.88-8.04-2.88-12.81c0-5.44,1.01-10.27,2.99-14.35c1.95-4.03,4.63-7.51,7.96-10.35
											c3.21-2.74,6.95-4.98,11.12-6.67c3.93-1.6,8.13-2.86,12.48-3.74c4.25-0.86,8.61-1.46,12.95-1.78c4.27-0.32,8.38-0.48,12.21-0.48
											c4.23,0,8.65,0.22,13.13,0.64c4.43,0.42,8.88,1.02,13.2,1.79c4.27,0.75,8.48,1.64,12.53,2.64c4,1,7.77,2.06,11.21,3.17l3.65,1.18
											v36.69l-7.58-3.69c-1.82-0.89-4.33-1.94-7.45-3.11c-3.09-1.16-6.67-2.28-10.63-3.33c-3.95-1.05-8.31-1.94-12.96-2.65
											c-4.59-0.7-9.36-1.05-14.18-1.05c-3.91,0-7.28,0.12-10.01,0.36c-2.68,0.24-4.93,0.55-6.69,0.91c-1.95,0.4-2.99,0.79-3.52,1.03
											c-0.17,0.08-0.31,0.15-0.44,0.22c0.82,0.54,2.19,1.25,4.38,1.99c2.48,0.83,5.42,1.64,8.76,2.39c3.52,0.79,7.25,1.6,11.19,2.44
											c4.01,0.85,8.14,1.78,12.4,2.79c4.37,1.03,8.66,2.25,12.75,3.63c4.19,1.4,8.21,3.06,11.93,4.92c3.92,1.96,7.43,4.3,10.43,6.95
											c3.16,2.8,5.69,6.07,7.52,9.73C166.28,124.15,167.24,128.48,167.24,133.23z"></path>
									</g>
									<g>
										<polygon points="341.18,53.4 341.18,86.9 296.34,86.9 296.34,169.45 257.3,169.45 257.3,86.9 212.54,86.9 212.54,53.4 		"></polygon>
									</g>
									<g>
										<rect x="394.04" y="53.4" width="39.03" height="116.05"></rect>
									</g>
									<g>
										<polygon points="672.09,53.4 672.09,169.45 633.21,169.45 633.21,111.34 602.5,169.45 568.81,169.45 538.1,111.34 538.1,169.45 
											499.07,169.45 499.07,53.4 546.21,53.4 585.66,127.33 625.11,53.4 		"></polygon>
									</g>
									<g>
										<polygon points="911.15,53.4 911.15,169.45 872.28,169.45 872.28,111.34 841.57,169.45 807.88,169.45 777.17,111.34 
											777.17,169.45 738.14,169.45 738.14,53.4 785.27,53.4 824.72,127.33 864.17,53.4 		"></polygon>
									</g>
									<g>
										<path d="M1058.76,53.4h-38.17l-60.73,116.05h43.77l9.9-19.97h52.28l9.91,19.97h43.76L1058.76,53.4z M1050.54,118.36h-21.55
											l10.82-21.72L1050.54,118.36z"></path>
									</g>
								</g>
							</svg>
						</a>
					</div>*/?>
				</div>



				<div class="footer-block">
					<div class="footer-block-menu">
						<!-- <div class="footer-block-title">
							<span><?=LANGUAGE_ID == 'ua' ? 'Інформація' : 'Информация'?></span>
                            <a href="<?=LANGUAGE_ID == 'ru' ? '/ru':''?>/pro-nas/yak-zrobiti-zamovlennya/"><?=LANGUAGE_ID == 'ua' ? 'Інформація' : 'Информация'?></a>
						</div> -->
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "footer_info_menu",
                            array(
                                "COMPONENT_TEMPLATE" => "footer_info_menu",
                                "ROOT_MENU_TYPE" => "info_menu5",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "",
                                "USE_EXT" => "N",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                            ),
                            false
                        );?>
                        <br>
                        <div  class="footer-phone-block">
                        	<a href="tel:0800300068" style="color:#000">0800300068</a>
                        </div>
					</div>
				</div>
				<div class="footer-block">
					<div class="footer-block-menu">
						<!-- <div class="footer-block-title">
                            <span><?=LANGUAGE_ID == 'ua' ? 'Співпраця' : 'Сотрудничество'?></span>
                            <a href="<?=LANGUAGE_ID == 'ru' ? '/ru':''?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/"><?=LANGUAGE_ID == 'ua' ? 'Співпраця' : 'Сотрудничество'?></a>
						</div> -->
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "footer_info_menu",
                            array(
                                "COMPONENT_TEMPLATE" => "footer_info_menu",
                                "ROOT_MENU_TYPE" => "info_menu4",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "",
                                "USE_EXT" => "N",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                            ),
                            false
                        );?>
                        <?/*
						<ul class="footer-block-list">
							<li>
								<a href="#">Переваги співпраці з компанією STIMMA</a>
							</li>
							<li>
								<a href="#">Для оптових клієнтів</a>
							</li>
							<li>
								<a href="#">Для дропшиперів</a>
							</li>
							<li>
								<a href="#">Роздрібним клієнтам</a>
							</li>
						</ul>
                        */?>
					</div>
				</div>
				<div class="footer-block">
					<div class="footer-block-menu">
						<!-- <div class="footer-block-title">
                            <a href="<?=LANGUAGE_ID == 'ru' ? '/ru':''?>/contacts/"><?=LANGUAGE_ID == 'ua' ? 'Наші магазини' : 'Наши магазины'?></a>
						</div> -->
						<div class="footer-block-title">
                            <span><?=LANGUAGE_ID == 'ua' ? 'Соціальні мережі' : 'Социальные сети'?></span>
                            <a href="<?=LANGUAGE_ID == 'ru' ? '/ru':''?>/contacts/"><?=LANGUAGE_ID == 'ua' ? 'Соціальні мережі' : 'Социальные сети'?></a>
						</div>
						<!-- <ul class="footer-block-list">
							<li>
								<span class="icon">
									<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M4.33973 9.65997L6.39895 11.7192C8.1063 13.4265 10.8693 13.4265 12.5766 11.7192L12.6006 11.6952C12.9445 11.3513 12.9445 10.7995 12.6006 10.4557L9.9616 7.81667C9.61773 7.4728 9.06594 7.4728 8.72207 7.81667L8.35821 8.18053C8.01434 8.5244 7.46255 8.5244 7.11868 8.18053L5.81517 6.87703C5.4713 6.53316 5.4713 5.98137 5.81517 5.6375L6.17903 5.27364C6.5229 4.92977 6.5229 4.37798 6.17903 4.03411L3.54004 1.39511C3.19617 1.05124 2.64438 1.05124 2.30051 1.39511L2.28051 1.4231C0.573162 3.13045 0.573162 5.8934 2.28051 7.60075L4.33973 9.65997Z" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M12.9766 5.94168C13.0965 4.65017 12.6607 3.31468 11.6731 2.32305C10.6854 1.33143 9.34595 0.899593 8.05444 1.01955" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M10.2695 5.74194C10.3335 5.20614 10.1696 4.65035 9.75773 4.2425C9.34589 3.83066 8.7901 3.66672 8.2583 3.7307" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</span>
								<a href="#">0 800 3000 68</a>
							</li>
							<li>
								<span class="icon">
									<svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M13 1.27197H1V9.7881H13V1.27197Z" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M1 1.27197L7 6.52875L13 1.27197" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M1 9.78787L5.31226 5.0498" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M13 9.78787L8.68384 5.0498" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</span>
								<a href="#">stimmacomua@gmail.com</a>

							</li>
							<li>
								<span class="icon">
									<svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M13 1.27197H1V9.7881H13V1.27197Z" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M1 1.27197L7 6.52875L13 1.27197" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M1 9.78787L5.31226 5.0498" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M13 9.78787L8.68384 5.0498" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</span>
                                <a href="#">marketingstimma@gmail.com</a>

							</li>
							<li>
								<span class="icon">
									<svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M6.1929 8.60758C7.51875 8.60758 8.59356 7.51766 8.59356 6.17317C8.59356 4.82869 7.51875 3.73877 6.1929 3.73877C4.86705 3.73877 3.79224 4.82869 3.79224 6.17317C3.79224 7.51766 4.86705 8.60758 6.1929 8.60758Z" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M6.19777 15C6.24115 14.9422 6.27007 14.9084 6.299 14.8698C7.04137 13.8961 7.79339 12.9223 8.53094 11.9389C9.16726 11.0905 9.81804 10.2517 10.4013 9.36953C11.1967 8.16438 11.5438 6.83389 11.3269 5.37325C10.8834 2.47125 7.94765 0.465876 5.08421 1.1263C1.99902 1.84457 0.25878 5.00206 1.30485 7.99566C1.61337 8.88265 2.11953 9.65877 2.68354 10.3963C3.54161 11.5292 4.42378 12.6475 5.28667 13.7804C5.59519 14.1757 5.88443 14.5806 6.19777 15Z" stroke="#3D441D" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</span>
								<span><?=LANGUAGE_ID == 'ua' ? 'Україна, м. Хмельницький, вул. Святослава Хороброго, 5' : 'Украина, г. Хмельницкий, ул. Святослава Храброго, 5'?></span>
							</li>
							
						</ul -->
						<!-- footer-block-list-line -->
						<ul class="footer-block-list ">
							<li>
								<a target="_blank" href="https://www.instagram.com/stimma_official/" rel="noopener noreferrer">
									<?/*<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>*/?>
									Instagram
								</a>
							</li>
							<li>
								<a target="_blank" href="https://www.facebook.com/stimma2016/" rel="noopener noreferrer">
									<?/*<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>*/?>
									Facebook
								</a>
							</li>
							<li>
								<a target="_blank" href="https://www.youtube.com/channel/UCYbanVf9TfoB3sZ3FZDkGng" rel="noopener noreferrer">
									<?/*<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>*/?>
									Youtube
								</a>
							</li>
							<li>
								<a href="<?=LANGUAGE_ID=='ru'?'/ru':''?>/blog/">
									<?/*<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>*/?>
									<?=LANGUAGE_ID=='ua' ?'Проєкти' :'Проекты'?>
								</a>
							</li>
						</ul>
					</div>
				</div>
                <?/*<div class="footer-block">
					<div class="footer-block-menu">

						<form>
                            <div class="write-us-form-block">
                                <input type="text" placeholder="Ваш E-mail" name="subscribe_email">
                                <button type="submit" class="subscribe_me"><?=LANGUAGE_ID=='ua'?'Підписатися':'Подписаться'?></button>
                            </div>
                            <div class="subscribe_result"></div>
                        </form>
					</div>
				</div>*/?>
			</div>
			<div class="footer-copyright">
				© 2021 STIMMA - <?=LANGUAGE_ID == 'ua' ? 'Інтернет магазин жіночого одягу від виробника' : 'Интернет магазин женской одежды от производителя'?>
			</div>
		</footer>



<?
if(!$bIndex)
{
    ?>
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "p8o2g9ywf0");
    </script>

    <div class="modal fade" id="basket-popup"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog basket-popup" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-btn-cont">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-header-cont">
                        <div class="modal-header-text" style="display:none">
                            <?=UA ? 'Кошик' : 'Корзина'?>
                            <span class="popup_basket_total_kom">()</span>
                        </div>
                        <div class="modal-header-block">
                            <a href="#">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1164.53 223" style="enable-background:new 0 0 1164.53 223;" xml:space="preserve">
										<g>
                                            <g>
                                                <path d="M167.24,133.23c0,5.86-1.09,11.03-3.23,15.38c-2.12,4.29-4.98,7.96-8.53,10.93c-3.43,2.87-7.43,5.2-11.9,6.91
													c-4.21,1.61-8.69,2.87-13.3,3.75c-4.54,0.86-9.19,1.43-13.81,1.69c-4.51,0.27-8.86,0.4-12.94,0.4c-10.72,0-20.81-0.9-29.98-2.67
													c-9.13-1.77-17.34-4-24.39-6.65l-3.42-1.29v-37.79l7.83,4.35c6.58,3.64,14.21,6.55,22.69,8.62c8.54,2.09,17.82,3.15,27.58,3.15
													c5.73,0,10.41-0.3,13.91-0.88c4.14-0.7,6.42-1.5,7.6-2.05c1.75-0.81,2.18-1.37,2.19-1.37c0.16-0.25,0.24-0.42,0.27-0.51
													c-0.04-0.02-0.15-0.14-0.35-0.3c-0.73-0.6-2.14-1.5-4.73-2.42c-2.43-0.87-5.36-1.69-8.68-2.44c-3.49-0.78-7.21-1.57-11.13-2.35
													c-4-0.8-8.11-1.67-12.34-2.59c-4.35-0.96-8.62-2.1-12.71-3.39c-4.16-1.31-8.17-2.87-11.9-4.63c-3.94-1.86-7.47-4.11-10.48-6.68
													c-3.17-2.72-5.71-5.92-7.56-9.51c-1.91-3.73-2.88-8.04-2.88-12.81c0-5.44,1.01-10.27,2.99-14.35c1.95-4.03,4.63-7.51,7.96-10.35
													c3.21-2.74,6.95-4.98,11.12-6.67c3.93-1.6,8.13-2.86,12.48-3.74c4.25-0.86,8.61-1.46,12.95-1.78c4.27-0.32,8.38-0.48,12.21-0.48
													c4.23,0,8.65,0.22,13.13,0.64c4.43,0.42,8.88,1.02,13.2,1.79c4.27,0.75,8.48,1.64,12.53,2.64c4,1,7.77,2.06,11.21,3.17l3.65,1.18
													v36.69l-7.58-3.69c-1.82-0.89-4.33-1.94-7.45-3.11c-3.09-1.16-6.67-2.28-10.63-3.33c-3.95-1.05-8.31-1.94-12.96-2.65
													c-4.59-0.7-9.36-1.05-14.18-1.05c-3.91,0-7.28,0.12-10.01,0.36c-2.68,0.24-4.93,0.55-6.69,0.91c-1.95,0.4-2.99,0.79-3.52,1.03
													c-0.17,0.08-0.31,0.15-0.44,0.22c0.82,0.54,2.19,1.25,4.38,1.99c2.48,0.83,5.42,1.64,8.76,2.39c3.52,0.79,7.25,1.6,11.19,2.44
													c4.01,0.85,8.14,1.78,12.4,2.79c4.37,1.03,8.66,2.25,12.75,3.63c4.19,1.4,8.21,3.06,11.93,4.92c3.92,1.96,7.43,4.3,10.43,6.95
													c3.16,2.8,5.69,6.07,7.52,9.73C166.28,124.15,167.24,128.48,167.24,133.23z"></path>
                                            </g>
                                            <g>
                                                <polygon points="341.18,53.4 341.18,86.9 296.34,86.9 296.34,169.45 257.3,169.45 257.3,86.9 212.54,86.9 212.54,53.4 		"></polygon>
                                            </g>
                                            <g>
                                                <rect x="394.04" y="53.4" width="39.03" height="116.05"></rect>
                                            </g>
                                            <g>
                                                <polygon points="672.09,53.4 672.09,169.45 633.21,169.45 633.21,111.34 602.5,169.45 568.81,169.45 538.1,111.34 538.1,169.45
													499.07,169.45 499.07,53.4 546.21,53.4 585.66,127.33 625.11,53.4 		"></polygon>
                                            </g>
                                            <g>
                                                <polygon points="911.15,53.4 911.15,169.45 872.28,169.45 872.28,111.34 841.57,169.45 807.88,169.45 777.17,111.34
													777.17,169.45 738.14,169.45 738.14,53.4 785.27,53.4 824.72,127.33 864.17,53.4 		"></polygon>
                                            </g>
                                            <g>
                                                <path d="M1058.76,53.4h-38.17l-60.73,116.05h43.77l9.9-19.97h52.28l9.91,19.97h43.76L1058.76,53.4z M1050.54,118.36h-21.55
													l10.82-21.72L1050.54,118.36z"></path>
                                            </g>
                                        </g>
									</svg>
                            </a>
                        </div>
                    </div>
                    <div class="modal-basket-cont popup_basket_content">
                        <?//getBasketHtml()?>
                        <?/*
                            <div class="modal-basket-block">
                                <div class="modal-basket-content">
                                    <div class="modal-basket-list">
                                        <div class="modal-basket-item">
                                            <div class="modal-basket-item-img">
                                                <a href="#">
                                                    <img src="/bitrix/templates/stimma/images/bigimg.avif">
                                                </a>
                                            </div>
                                            <div class="modal-basket-item-info">
                                                <div class="modal-basket-item-top">
                                                    <div class="modal-basket-item-name">
                                                        <a href="#">Cable knit corset in cream cream</a>
                                                    </div>
                                                    <div class="modal-basket-item-price-block">
                                                        <div class="modal-basket-item-price-old">
                                                            2000 грн
                                                        </div>
                                                        <div class="modal-basket-item-price">
                                                            1500 грн
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-basket-item-size-block">
                                                    <div class="modal-basket-item-size">
                                                        40
                                                    </div>
                                                    <div class="modal-basket-item-count">
                                                        <input type="text" name="" value="2">
                                                    </div>
                                                </div>
                                                <div class="modal-basket-item-btn">
                                                    <a href="#" class="modal-basket-item-delete">
                                                        Видалити
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-basket-item">
                                            <div class="modal-basket-item-img">
                                                <a href="#">
                                                    <img src="/bitrix/templates/stimma/images/bigimg.avif">
                                                </a>
                                            </div>
                                            <div class="modal-basket-item-info">
                                                <div class="modal-basket-item-top">
                                                    <div class="modal-basket-item-name">
                                                        <a href="#">Cable knit corset in cream cream</a>
                                                    </div>
                                                    <div class="modal-basket-item-price-block">
                                                        <div class="modal-basket-item-price-old">
                                                            2000 грн
                                                        </div>
                                                        <div class="modal-basket-item-price">
                                                            1500 грн
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-basket-item-size-block">
                                                    <div class="modal-basket-item-size">
                                                        40
                                                    </div>
                                                    <div class="modal-basket-item-count">
                                                        <input type="text" name="" value="2">
                                                    </div>
                                                </div>
                                                <div class="modal-basket-item-btn">
                                                    <a href="#" class="modal-basket-item-delete">
                                                        Видалити
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-basket-item">
                                            <div class="modal-basket-item-img">
                                                <a href="#">
                                                    <img src="/bitrix/templates/stimma/images/bigimg.avif">
                                                </a>
                                            </div>
                                            <div class="modal-basket-item-info">
                                                <div class="modal-basket-item-top">
                                                    <div class="modal-basket-item-name">
                                                        <a href="#">Cable knit corset in cream cream</a>
                                                    </div>
                                                    <div class="modal-basket-item-price-block">
                                                        <div class="modal-basket-item-price-old">
                                                            2000 грн
                                                        </div>
                                                        <div class="modal-basket-item-price">
                                                            1500 грн
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-basket-item-size-block">
                                                    <div class="modal-basket-item-size">
                                                        40
                                                    </div>
                                                    <div class="modal-basket-item-count">
                                                        <input type="text" name="" value="2">
                                                    </div>
                                                </div>
                                                <div class="modal-basket-item-btn">
                                                    <a href="#" class="modal-basket-item-delete">
                                                        Видалити
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-basket-item">
                                            <div class="modal-basket-item-img">
                                                <a href="#">
                                                    <img src="/bitrix/templates/stimma/images/bigimg.avif">
                                                </a>
                                            </div>
                                            <div class="modal-basket-item-info">
                                                <div class="modal-basket-item-top">
                                                    <div class="modal-basket-item-name">
                                                        <a href="#">Cable knit corset in cream cream</a>
                                                    </div>
                                                    <div class="modal-basket-item-price-block">
                                                        <div class="modal-basket-item-price-old">
                                                            2000 грн
                                                        </div>
                                                        <div class="modal-basket-item-price">
                                                            1500 грн
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-basket-item-size-block">
                                                    <div class="modal-basket-item-size">
                                                        40
                                                    </div>
                                                    <div class="modal-basket-item-count">
                                                        <input type="text" name="" value="2">
                                                    </div>
                                                </div>
                                                <div class="modal-basket-item-btn">
                                                    <a href="#" class="modal-basket-item-delete">
                                                        Видалити
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-basket-info">
                                        <div class="modal-basket-info-title">
                                            Підсумок Замовлення
                                        </div>
                                        <div class="modal-basket-info-list">
                                            <div class="modal-basket-info-key">Оплата <span>(10)</span> </div>
                                            <div class="modal-basket-info-value">20000 грн</div>
                                        </div>
                                        <div class="modal-basket-info-list">
                                            <div class="modal-basket-info-key">Доставка</div>
                                            <div class="modal-basket-info-value">За тарифом</div>
                                        </div>
                                        <div class="modal-basket-info-list basket-info-list-total">
                                            <div class="modal-basket-info-key">Загальна</div>
                                            <div class="modal-basket-info-value">20000 грн</div>
                                        </div>
                                        <div class="modal-basket-info-check">
                                            <label class="new-checkbox">
                                                <input type="checkbox" name="">
                                                <span class="new-checkbox-text">
													Я підтверджую, що я прочитав і зрозумів <a href="#">положення та умови</a> .
												</span>
                                            </label>
                                        </div>
                                        <div class="modal-basket-btn-block">
                                            <a href="#" class="modal-basket-btn">
                                                Оформити замовлення
                                            </a>
                                        </div>
                                        <div class="modal-basket-text-bottom">
                                            <p>Безкоштовна доставка при замовленні на суму від 2000 грн</p>
                                            <p><span>Дізнайтеся більше про нашу повну <a href="#">політику повернення та відшкодування</a> .</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            */?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="menu-mob-popup"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog menu-mob-popup" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="mob-menu-top">
                        <div class="mob-menu-bg">
                            <div class="mob-menu-bg-img">
                                <?/*<img src="/bitrix/templates/stimma/images/mob-menu-bg.avif">*/?>
                                <img src="/bitrix/templates/stimma/images/3428_2.jpg?v=12">
                            </div>
                        </div>
                        <div class="mob-menu-gradient"></div>
                        <div class="menu-mob-header">
                            <div class="menu-mob-close">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="c-biXJmc c-biXJmc-ulsnn-size-medium"><g><rect width="24" height="24" fill="none"></rect><polygon points="20.8 3.9 20.1 3.2 12 11.3 3.9 3.2 3.2 3.9 11.3 12 3.2 20.1 3.9 20.8 12 12.7 20.1 20.8 20.8 20.1 12.7 12 20.8 3.9"></polygon></g></svg>
                                </button>
                            </div>
                            <div class="menu-mob-header-right">
                            	<?/*
                                <div class="menu-mob-search header-search-icon" >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="c-cTrMKP c-cTrMKP-lcsxpA-size-default"><g><path d="M18.22,17.52l-3.35-3.36a5.12,5.12,0,1,0-4,1.89h0a5.11,5.11,0,0,0,3.25-1.18l3.36,3.35Zm-7.31-2.47a4.13,4.13,0,1,1,2.93-1.21,4.11,4.11,0,0,1-2.93,1.21Z"></path><rect width="24" height="24" fill="none"></rect></g></svg>
                                </div>
                                <div class="header-new-elem favorite">
                                    <a href="<?=UA?'':'/ru'?>/favorite/" class="header-favorite-link favcounter">
											<span class="counter">
												0
											</span>
                                        <span class="icon">
												<svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M16.761 1.01109C13.871 1.14109 11.641 3.78109 11.501 4.99109C11.321 3.39109 7.46095 -0.748911 3.25095 1.82109C1.36095 2.98109 0.920954 4.65109 1.01095 6.13109C1.12095 7.86109 1.99095 9.45109 3.27095 10.6011L11.501 18.0011L19.451 10.8511" stroke="#fff" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"></path>
												</svg>
											</span>
                                    </a>
                                </div>*/?>
                                <div class="header-new-elem personal">
	                            	<a rel="nofollow" title="Мій кабінет" class="header-favorite-link" data-event="jqm" data-param-type="auth" data-name="auth" href="/personal/" data-param-backurl="/">
	                        			<svg class="" width="19" height="19" viewBox="0 0 19 19"><path data-name="Ellipse 206 copy 4" class="cls-1" d="M909,961a9,9,0,1,1,9-9A9,9,0,0,1,909,961Zm2.571-2.5a6.825,6.825,0,0,0-5.126,0A6.825,6.825,0,0,0,911.571,958.5ZM909,945a6.973,6.973,0,0,0-4.556,12.275,8.787,8.787,0,0,1,9.114,0A6.973,6.973,0,0,0,909,945Zm0,10a4,4,0,1,1,4-4A4,4,0,0,1,909,955Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,909,949Z" transform="translate(-900 -943)"></path>
	                        			</svg>
	                            	</a>
	                            </div>
                            </div>
                        </div>
                        <div class="menu-mob-lists">
                            <div class="menu-mob-list">
                                <div class="menu-mob-list-element">

                                    <div class="menu-mob-list-title-block">

                                        <?/*<div class="menu-mob-list-title"><?=UA?'Категорії':'Категории'?></div>*/?>
                                        <a href="<?=UA ? '' : '/ru'?>/contacts/" class="menu-mob-list-titl-link"><?=UA?'Наші Магазини':'Наши магазины'?></a>
                                        <a title="<?=LANGUAGE_ID == 'ua' ? 'САМА СОБІ STIMMA' : 'САМА СЕБЕ STIMMA'?>" class="mob-menu-languege-elem" href="<?=UA?'':'/ru'?>/sama_sobi/" >
                                            <?=UA?'САМА СОБІ STIMMA':'САМА СЕБЕ STIMMA'?>
                                        </a>
                                        <?/*<a href="<?=UA ? '' : '/ru'?>/catalog/zhenskaya_odezhda/" class="menu-mob-list-titl-link"><?=UA?'Дивитися всі':'Смотреть все'?></a>*/?>
                                    </div>
                                    <?$res = CIBlockSection::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 21,'ACTIVE'=>'Y','DEPTH_LEVEL'=>1,"!ID"=>347],false,['UF_*']);?>
                                    <?$res2 = CIBlockSection::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 21,'ACTIVE'=>'Y','DEPTH_LEVEL'=>2,'SECTION_ID' => 347],false,['UF_*']);?>
                                    <?
                                    //$menu = [];
                                    /*while ($item = $res -> Fetch())
                                        $menu['/catalog/'.$item['CODE'].'/'] = UA ? $item['UF_NAME_UA'] : $item['NAME'];
                                    while ($item = $res2 -> Fetch())
                                        $menu['/catalog/zhenskaya_odezhda/'.$item['CODE'].'/'] = UA ? $item['UF_NAME_UA'] : $item['NAME'];
                                    $count = round(count($menu)/2);
                                    */

                                    /*$res = CIBlockElement::GetList(['SORT'=>'asc'],['IBLOCK_ID' => 43,'ACTIVE'=>'Y'],false,false,['ID','IBLOCK_ID','PROPERTY_NAME_RU','PROPERTY_NAME_UA','PROPERTY_LINK']);
                                    while ($record = $res->Fetch())
                                        $menu[$record['PROPERTY_LINK_VALUE']] = UA ? $record['PROPERTY_NAME_UA_VALUE'] : $record['PROPERTY_NAME_RU_VALUE'];

                                    $count = round(count($menu)/2);*/
                                    ?>
                                    <?/*<ul class="menu-mob-list-block">
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/novinki/">NEW</a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/khity_prodazh/">BESTSELLERS</a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/rasprodazha/">SALE</a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/"><?=UA ? 'Верхній одяг' : 'Верхняя одежда'?></a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/zhenskaya_odezhda/kostyumy_i_zhakety/"><?=UA ? 'Костюми та жакети' : 'Костюмы и жакеты'?></a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/zhenskaya_odezhda/trikotazh/"><?=UA ? 'Трикотаж' : 'Трикотаж'?></a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/zhenskaya_odezhda/platya_sarafany_i_yubki/"><?=UA ? 'Сукні, сарафани та спідниці' : 'Платья, сарафаны и юбки'?></a></li>

                                        </ul>
                                        <ul class="menu-mob-list-block">
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/zhenskaya_odezhda/bluzy_i_rubashki/"><?=UA ? 'Блузи та сорочки' : 'Блузы и рубашки'?></a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/zhenskaya_odezhda/dzhinsy_bryuki_shorty/"><?=UA ? 'Джинси, штани, шорти' : 'Джинсы, брюки, шорты'?></a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/zhenskaya_odezhda/topy1/"><?=UA ? 'Футболки, Топи, Лонгсліви' : 'Футболки, Топы, Лонгсливы'?></a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/zhenskaya_odezhda/sportivnaya_odezhda/"><?=UA ? 'Спортивний одяг' : 'Спортивная одежда'?></a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/aksessuary/"><?=UA ? 'Аксесуари' : 'Аксессуары'?></a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/termoodezhda/"><?=UA ? 'Термоодяг' : 'Термоодежда'?></a></li>
                                            <li class="h-menu-list-item"><a href="<?=!UA ? '/ru' : ''?>/catalog/podarochnyy_sertifikat/"><?=UA ? 'Подарунковий сертифікат' : 'Подарочный сертификат'?></a></li>

                                            <li class="h-menu-list-item">&nbsp;</li>
                                            <li class="h-menu-list-item"><a href="<?=UA ? '' : '/ru'?>/catalog/zhenskaya_odezhda/"><?=UA?'Дивитися всі':'Смотреть все'?></a></li>
                                        </ul>
                                        */?>

                                    <?
                                    $res = CIBlockSection::GetList(['DEPTH_LEVEL' => 'asc','sort'=>'asc'], ['IBLOCK_ID' => 43,'ACTIVE'=>'Y'],false,['UF_*']);
                                    $sections = [];
                                    while ($section = $res->Fetch())
                                    {
                                        if(!$section['IBLOCK_SECTION_ID'])
                                            $sections[$section['ID']] = $section;
                                        else
                                            $sections[$section['IBLOCK_SECTION_ID']]['child'][] = $section;
                                    }
                                    ?>

                                    <ul class="menu-mob-list-block">
                                        <?
                                        global $USER;
                                        $n=0;
                                        foreach($sections as $link => $name)
                                        {
											
											if ( trim($name['UF_NAME_UA']) == '' ) continue;	

											if($name['UF_LINK'] == '/catalog/bonusna_shafa' && !$USER->IsAdmin()){
												//continue;
											}
                                        ?>
                                        <li class="h-menu-list-item">
                                            <div class="h-menu-list-item-dropdown">
                                                <a href="<?=UA ? '' : '/ru'?><?=$name['UF_LINK']?>" style="<?=$name['UF_LINK'] == '/catalog/rasprodazha/' ? 'color:#ec5353;font-weight:700;' : ''?>"><?=LANGUAGE_ID == 'ua' ? $name['UF_NAME_UA'] : $name['NAME']?></a>

                                                <?
                                                if(isset($name['child']))
                                                {
                                                    ?>
                                                    <span class="icon">
		                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"></path></svg>
		                                                    </span>
                                                    <ul class="h-menu-list-semi" style="">
                                                    <?
                                                    foreach($name['child'] as $index => $item)
                                                    {
														
														//if($item['UF_NAME_UA'] == 'Жилет') continue;
                                                        ?>
                                                        <li class="h-menu-list-item">
                                                            <a href="<?=UA ? '' : '/ru'?><?=$item['UF_LINK']?>"><?=LANGUAGE_ID == 'ua' ? $item['UF_NAME_UA'] : $item['NAME']?></a>
                                                        </li>
                                                        <?
                                                    }
                                                    ?></ul><?
                                                }
                                                ?>



                                            </div>
                                        </li>
                                        <?
                                        if($name['UF_LINK'] == '/catalog/rasprodazha/')
                                        {
                                            /*?>
                                            <li class="h-menu-list-item">
                                                <div class="h-menu-list-item-dropdown">
                                                <a href="<?=UA ? '' : '/ru'?>/look20/"><?=LANGUAGE_ID == 'ua' ? 'Акції' : 'Акции'?></a>
                                                </div>
                                            </li>
                                            <?*/
                                        }
                                        ?>
                                        <?
                                        $n++;
                                        if($count == $n)
                                        {
                                        ?></ul><ul class="menu-mob-list-block"><?
                                        }
                                        }
                                        ?>
                                        <li class="h-menu-list-item">&nbsp;</li>
                                        <li class="h-menu-list-item"><a href="<?=UA ? '' : '/ru'?>/catalog/zhenskaya_odezhda/"><?=UA?'Дивитися всі':'Смотреть все'?></a></li>
                                        <li class="h-menu-list-item">&nbsp;</li>
                                        <li class="h-menu-list-item">
                                            <a href="tel:0800300068">0800300068</a>
                                        </li>
                                    </ul>
                                </div>
                                <?/*
									<div class="menu-mob-list-element">
										<div class="menu-mob-list-title-block">
											<div class="menu-mob-list-title">Категорії</div>
											<a href="#" class="menu-mob-list-titl-link">Дивитися всі</a>
										</div>
										<ul class="menu-mob-list-block">
											<li class="menu-mob-list-item">
												<a href="#">Плаття</a>
											</li>
											<li class="menu-mob-list-item">
												<a href="#">Светри</a>
											</li>
											<li class="menu-mob-list-item">
												<a href="#">Штани</a>
											</li>
											<li class="menu-mob-list-item">
												<a href="#">Юбки</a>
											</li>
											<li class="menu-mob-list-item">
												<a href="#">Аксесуари</a>
											</li>
										</ul>
									</div>
                                    */?>
                            </div>
                            <div class="menu-mob-list customer">
                                <div class="menu-mob-list-customer">
                                    <div class="menu-mob-back-cont">
                                        <div class="menu-mob-back-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="transition: fill 300ms ease 0s; fill: currentcolor; width: 24px;"><g><polygon points="18.83 11.5 7.13 11.5 10.83 7.91 10.13 7.19 5.17 12 10.13 16.81 10.83 16.09 7.13 12.5 18.83 12.5 18.83 11.5"></polygon><rect width="24" height="24" fill="none"></rect></g></svg>
                                        </div>
                                    </div>
                                    <div class="menu-mob-customer-cont">
                                        <div class="menu-mob-customer-item">
                                            <div class="menu-mob-customer-title">
                                                <?=UA?'Сервіс':'Сервис'?>
                                            </div>
                                            <p>Email
                                                <br>
                                                <a href="mailto:stimmacomua@gmail.com">stimmacomua@gmail.com</a>
                                            </p>
                                            <p><?=UA ? 'Гаряча лінія' : 'Горячая линия'?>
                                                <br>
                                                <a href="tel:0800300068">0800300068</a>
                                            </p>
                                            <p>
                                                <?=UA?'Графік роботи інтернет-магазину:':'График работы интернет-магазина:'?>
                                                <br>
                                                <?=UA ? 'понеділок - п\'ятниця' : 'понедельник-пятница'?> - 9.00 - 18.00
                                                <br>
                                                <?=UA ? 'Субота-Неділя' : 'Суббота-Воскресенье'?> - 10.00 - 18.00
                                                <br>

                                            </p>
                                        </div>
                                        <div class="menu-mob-customer-item">
                                            <div class="menu-mob-customer-title">
                                                Інформація
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="<?=UA?'':'/ru'?>/pro-nas/dostavka-ta-oplata/">Доставка</a>
                                                </li>
                                                <li>
                                                    <a href="<?=UA?'':'/ru'?>/pro-nas/garantiya-ta-povernennya/"><?=UA?'Повернення та обмін':'Возврат и обмен'?></a>
                                                </li>
                                                <li>
                                                    <a href="<?=UA?'':'/ru'?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/"><?=UA?'Співпраця':'Сотрудничество'?></a>
                                                </li>
                                                <li style="margin-top: 20px;">
                                                    <a style="font-size: 18px;" href="<?=UA ? '' : '/ru'?>/vacancies/"><?=UA?'Вакансії':'Вакансии'?></a>
                                                </li>
                                                <?/*<li>
														<a href="<?=UA?'':'/ru'?>">Сервіс</a>
													</li>*/?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?

                    $pageUrl = isset($_SERVER['NEW_URL']) ? $_SERVER['NEW_URL'][3] : $APPLICATION->GetCurPage();
                    $page = str_replace('/ru/','/',$pageUrl);
                    ?>
                    <div class="mob-menu-bottom">

                        <div class="mob-menu-languege-switch">
                            <?
                            if(LANGUAGE_ID == 'ua')
                            {
                                ?>
                                <span class="mob-menu-languege-elem active">
							    	UA
							    </span>
                                <span class="language-switch-sep">/</span>
                                <a href="/ru<?=$page?>" class="mob-menu-languege-elem">RU</a>
                                <?
                            }
                            else
                            {
                                ?>
                                <a href="<?=$page?>" class="mob-menu-languege-elem">UA</a>
                                <span class="mob-menu-languege-sep">/</span>
                                <span class="mob-menu-languege-elem active">
								    RU
							    </span>
                                <?
                            }
                            ?>

                        </div>
                        <div class="mob-menu-toogler toogler-customer">
                            <?=UA?'Користувачам':'Пользователям'?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="search-popup"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog search-popup" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-btn-cont">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-header-cont">
                        <div class="modal-header-block">
                            <a href="#">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1164.53 223" style="enable-background:new 0 0 1164.53 223;" xml:space="preserve">
										<g>
                                            <g>
                                                <path d="M167.24,133.23c0,5.86-1.09,11.03-3.23,15.38c-2.12,4.29-4.98,7.96-8.53,10.93c-3.43,2.87-7.43,5.2-11.9,6.91
													c-4.21,1.61-8.69,2.87-13.3,3.75c-4.54,0.86-9.19,1.43-13.81,1.69c-4.51,0.27-8.86,0.4-12.94,0.4c-10.72,0-20.81-0.9-29.98-2.67
													c-9.13-1.77-17.34-4-24.39-6.65l-3.42-1.29v-37.79l7.83,4.35c6.58,3.64,14.21,6.55,22.69,8.62c8.54,2.09,17.82,3.15,27.58,3.15
													c5.73,0,10.41-0.3,13.91-0.88c4.14-0.7,6.42-1.5,7.6-2.05c1.75-0.81,2.18-1.37,2.19-1.37c0.16-0.25,0.24-0.42,0.27-0.51
													c-0.04-0.02-0.15-0.14-0.35-0.3c-0.73-0.6-2.14-1.5-4.73-2.42c-2.43-0.87-5.36-1.69-8.68-2.44c-3.49-0.78-7.21-1.57-11.13-2.35
													c-4-0.8-8.11-1.67-12.34-2.59c-4.35-0.96-8.62-2.1-12.71-3.39c-4.16-1.31-8.17-2.87-11.9-4.63c-3.94-1.86-7.47-4.11-10.48-6.68
													c-3.17-2.72-5.71-5.92-7.56-9.51c-1.91-3.73-2.88-8.04-2.88-12.81c0-5.44,1.01-10.27,2.99-14.35c1.95-4.03,4.63-7.51,7.96-10.35
													c3.21-2.74,6.95-4.98,11.12-6.67c3.93-1.6,8.13-2.86,12.48-3.74c4.25-0.86,8.61-1.46,12.95-1.78c4.27-0.32,8.38-0.48,12.21-0.48
													c4.23,0,8.65,0.22,13.13,0.64c4.43,0.42,8.88,1.02,13.2,1.79c4.27,0.75,8.48,1.64,12.53,2.64c4,1,7.77,2.06,11.21,3.17l3.65,1.18
													v36.69l-7.58-3.69c-1.82-0.89-4.33-1.94-7.45-3.11c-3.09-1.16-6.67-2.28-10.63-3.33c-3.95-1.05-8.31-1.94-12.96-2.65
													c-4.59-0.7-9.36-1.05-14.18-1.05c-3.91,0-7.28,0.12-10.01,0.36c-2.68,0.24-4.93,0.55-6.69,0.91c-1.95,0.4-2.99,0.79-3.52,1.03
													c-0.17,0.08-0.31,0.15-0.44,0.22c0.82,0.54,2.19,1.25,4.38,1.99c2.48,0.83,5.42,1.64,8.76,2.39c3.52,0.79,7.25,1.6,11.19,2.44
													c4.01,0.85,8.14,1.78,12.4,2.79c4.37,1.03,8.66,2.25,12.75,3.63c4.19,1.4,8.21,3.06,11.93,4.92c3.92,1.96,7.43,4.3,10.43,6.95
													c3.16,2.8,5.69,6.07,7.52,9.73C166.28,124.15,167.24,128.48,167.24,133.23z"></path>
                                            </g>
                                            <g>
                                                <polygon points="341.18,53.4 341.18,86.9 296.34,86.9 296.34,169.45 257.3,169.45 257.3,86.9 212.54,86.9 212.54,53.4 		"></polygon>
                                            </g>
                                            <g>
                                                <rect x="394.04" y="53.4" width="39.03" height="116.05"></rect>
                                            </g>
                                            <g>
                                                <polygon points="672.09,53.4 672.09,169.45 633.21,169.45 633.21,111.34 602.5,169.45 568.81,169.45 538.1,111.34 538.1,169.45
													499.07,169.45 499.07,53.4 546.21,53.4 585.66,127.33 625.11,53.4 		"></polygon>
                                            </g>
                                            <g>
                                                <polygon points="911.15,53.4 911.15,169.45 872.28,169.45 872.28,111.34 841.57,169.45 807.88,169.45 777.17,111.34
													777.17,169.45 738.14,169.45 738.14,53.4 785.27,53.4 824.72,127.33 864.17,53.4 		"></polygon>
                                            </g>
                                            <g>
                                                <path d="M1058.76,53.4h-38.17l-60.73,116.05h43.77l9.9-19.97h52.28l9.91,19.97h43.76L1058.76,53.4z M1050.54,118.36h-21.55
													l10.82-21.72L1050.54,118.36z"></path>
                                            </g>
                                        </g>
									</svg>
                            </a>
                        </div>
                    </div>
                    <div class="modal-search-cont">
                        <div class="modal-search-overlay"></div>
                        <div class="modal-search-block">
                            <form>
                                <div class="modal-search">
                                    <input type="text" name="fast_search_new" placeholder="Колекція, товар тощо...">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-search-bottom">
                        <div class="modal-search-example">
                            <span class="modal-search-text">Спробуйте пошукати:</span>
                            <a href="#" class="modal-search-link">
                                Плаття
                            </a>
                            <a href="#" class="modal-search-link">
                                Аксесуари
                            </a>
                            <a href="#" class="modal-search-link">
                                Костюм
                            </a>
                            <a href="#" class="modal-search-link">
                                Сорочка
                            </a>
                        </div>
                        <div class="modal-search-help">
                            Потрібна допомога у пошуку твору? <br> Щоб отримати додаткову інформацію, зверніться до нашої <a href="#"> служби підтримки </a> клієнтів.
                        </div>
                    </div>

                    <!-- opened  -->
                    <div class="modal-search-result-cont" >
                        <div class="modal-search-result-counter">
                            Результати пошуку <?/*(96)*/?>
                        </div>
                        <div class="modal-search-result-list">
                            <?/*
								<div class="search-result-item">
									<div class="catalog-item-block" data-entity="scu-values">
			                            <div class="catalog-item-img">
			                                <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                    <img src="/upload/resize_cache/iblock/74d/530_780_1/2wnke8y1fa8su5ehjfk5mnsd4y2zvb4f.jpg">
			                                </a>
			                                <div class="catalog-item-size-list" data-code="RAZMER">
			                                                                                                                    <div class="catalog-item-size  " data-entity="scu-value" data-id="X">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                XS                                            </a>
			                                        </div>
			                                                                                                                        <div class="catalog-item-size  " data-entity="scu-value" data-id="S">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                S                                            </a>
			                                        </div>
			                                                                                                                        <div class="catalog-item-size  " data-entity="scu-value" data-id="M">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                M                                            </a>
			                                        </div>
			                                                                        </div>
			                                <div class="catalog-item-favorite">
			                                    <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/" data-id="26013">
			                                        <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
			                                            <path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"></path>
			                                        </svg>
			                                    </a>
			                                </div>
			                                <div class="card-stars-block">
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                                                        </div>
			                                <div class="card-badge-block">
			                                    <div class="card-badge-item hit">Хіт продажу</div>                                </div>
			                            </div>
			                            <div class="catalog-item-name-block">
			                                <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/" class="catalog-item-name" data-entity="name">Жіноча сорочка Stimma Дорена</a>
			                                                            </div>
			                                                        <div class="catalog-item-info">
			                                <div class="catalog-item-price">
			                                    <div class="catalog-item-price-currency" data-entity="price">1 199 грн</div>
			                                                                    </div>
			                                <div class="catalog-item-colors" data-code="COLOR_REF">
			                                                                                <a onclick="changeData('zhenskaya-rubashka-stimma-dorena-1081', this);return false;" style="background-color: #145574;" href="#" class="catalog-item-color  active" data-entity="scu-value" data-id="siniy">
			                                                                                            </a>
			                                                                                        <a onclick="changeData('zhenskaya-rubashka-stimma-dorena-1082', this);return false;" style="background-color: #d1c3ab;" href="#" class="catalog-item-color  " data-entity="scu-value" data-id="bezhevyy">
			                                                                                            </a>
			                                                                            </div>
			                            </div>
			                        </div>
								</div>
								<div class="search-result-item">
									<div class="catalog-item-block" data-entity="scu-values">
			                            <div class="catalog-item-img">
			                                <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                    <img src="/upload/resize_cache/iblock/74d/530_780_1/2wnke8y1fa8su5ehjfk5mnsd4y2zvb4f.jpg">
			                                </a>
			                                <div class="catalog-item-size-list" data-code="RAZMER">
			                                                                                                                    <div class="catalog-item-size  " data-entity="scu-value" data-id="X">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                XS                                            </a>
			                                        </div>
			                                                                                                                        <div class="catalog-item-size  " data-entity="scu-value" data-id="S">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                S                                            </a>
			                                        </div>
			                                                                                                                        <div class="catalog-item-size  " data-entity="scu-value" data-id="M">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                M                                            </a>
			                                        </div>
			                                                                        </div>
			                                <div class="catalog-item-favorite">
			                                    <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/" data-id="26013">
			                                        <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
			                                            <path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"></path>
			                                        </svg>
			                                    </a>
			                                </div>
			                                <div class="card-stars-block">
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                                                        </div>
			                                <div class="card-badge-block">
			                                    <div class="card-badge-item hit">Хіт продажу</div>                                </div>
			                            </div>
			                            <div class="catalog-item-name-block">
			                                <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/" class="catalog-item-name" data-entity="name">Жіноча сорочка Stimma Дорена</a>
			                                                            </div>
			                                                        <div class="catalog-item-info">
			                                <div class="catalog-item-price">
			                                    <div class="catalog-item-price-currency" data-entity="price">1 199 грн</div>
			                                                                    </div>
			                                <div class="catalog-item-colors" data-code="COLOR_REF">
			                                                                                <a onclick="changeData('zhenskaya-rubashka-stimma-dorena-1081', this);return false;" style="background-color: #145574;" href="#" class="catalog-item-color  active" data-entity="scu-value" data-id="siniy">
			                                                                                            </a>
			                                                                                        <a onclick="changeData('zhenskaya-rubashka-stimma-dorena-1082', this);return false;" style="background-color: #d1c3ab;" href="#" class="catalog-item-color  " data-entity="scu-value" data-id="bezhevyy">
			                                                                                            </a>
			                                                                            </div>
			                            </div>
			                        </div>
								</div>
								<div class="search-result-item">
									<div class="catalog-item-block" data-entity="scu-values">
			                            <div class="catalog-item-img">
			                                <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                    <img src="/upload/resize_cache/iblock/74d/530_780_1/2wnke8y1fa8su5ehjfk5mnsd4y2zvb4f.jpg">
			                                </a>
			                                <div class="catalog-item-size-list" data-code="RAZMER">
			                                                                                                                    <div class="catalog-item-size  " data-entity="scu-value" data-id="X">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                XS                                            </a>
			                                        </div>
			                                                                                                                        <div class="catalog-item-size  " data-entity="scu-value" data-id="S">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                S                                            </a>
			                                        </div>
			                                                                                                                        <div class="catalog-item-size  " data-entity="scu-value" data-id="M">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                M                                            </a>
			                                        </div>
			                                                                        </div>
			                                <div class="catalog-item-favorite">
			                                    <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/" data-id="26013">
			                                        <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
			                                            <path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"></path>
			                                        </svg>
			                                    </a>
			                                </div>
			                                <div class="card-stars-block">
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                                                        </div>
			                                <div class="card-badge-block">
			                                    <div class="card-badge-item hit">Хіт продажу</div>                                </div>
			                            </div>
			                            <div class="catalog-item-name-block">
			                                <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/" class="catalog-item-name" data-entity="name">Жіноча сорочка Stimma Дорена</a>
			                                                            </div>
			                                                        <div class="catalog-item-info">
			                                <div class="catalog-item-price">
			                                    <div class="catalog-item-price-currency" data-entity="price">1 199 грн</div>
			                                                                    </div>
			                                <div class="catalog-item-colors" data-code="COLOR_REF">
			                                                                                <a onclick="changeData('zhenskaya-rubashka-stimma-dorena-1081', this);return false;" style="background-color: #145574;" href="#" class="catalog-item-color  active" data-entity="scu-value" data-id="siniy">
			                                                                                            </a>
			                                                                                        <a onclick="changeData('zhenskaya-rubashka-stimma-dorena-1082', this);return false;" style="background-color: #d1c3ab;" href="#" class="catalog-item-color  " data-entity="scu-value" data-id="bezhevyy">
			                                                                                            </a>
			                                                                            </div>
			                            </div>
			                        </div>
								</div>
								<div class="search-result-item">
									<div class="catalog-item-block" data-entity="scu-values">
			                            <div class="catalog-item-img">
			                                <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                    <img src="/upload/resize_cache/iblock/74d/530_780_1/2wnke8y1fa8su5ehjfk5mnsd4y2zvb4f.jpg">
			                                </a>
			                                <div class="catalog-item-size-list" data-code="RAZMER">
			                                                                                                                    <div class="catalog-item-size  " data-entity="scu-value" data-id="X">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                XS                                            </a>
			                                        </div>
			                                                                                                                        <div class="catalog-item-size  " data-entity="scu-value" data-id="S">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                S                                            </a>
			                                        </div>
			                                                                                                                        <div class="catalog-item-size  " data-entity="scu-value" data-id="M">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                M                                            </a>
			                                        </div>
			                                                                        </div>
			                                <div class="catalog-item-favorite">
			                                    <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/" data-id="26013">
			                                        <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
			                                            <path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"></path>
			                                        </svg>
			                                    </a>
			                                </div>
			                                <div class="card-stars-block">
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                                                        </div>
			                                <div class="card-badge-block">
			                                    <div class="card-badge-item hit">Хіт продажу</div>                                </div>
			                            </div>
			                            <div class="catalog-item-name-block">
			                                <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/" class="catalog-item-name" data-entity="name">Жіноча сорочка Stimma Дорена</a>
			                                                            </div>
			                                                        <div class="catalog-item-info">
			                                <div class="catalog-item-price">
			                                    <div class="catalog-item-price-currency" data-entity="price">1 199 грн</div>
			                                                                    </div>
			                                <div class="catalog-item-colors" data-code="COLOR_REF">
			                                                                                <a onclick="changeData('zhenskaya-rubashka-stimma-dorena-1081', this);return false;" style="background-color: #145574;" href="#" class="catalog-item-color  active" data-entity="scu-value" data-id="siniy">
			                                                                                            </a>
			                                                                                        <a onclick="changeData('zhenskaya-rubashka-stimma-dorena-1082', this);return false;" style="background-color: #d1c3ab;" href="#" class="catalog-item-color  " data-entity="scu-value" data-id="bezhevyy">
			                                                                                            </a>
			                                                                            </div>
			                            </div>
			                        </div>
								</div>
								<div class="search-result-item">
									<div class="catalog-item-block" data-entity="scu-values">
			                            <div class="catalog-item-img">
			                                <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                    <img src="/upload/resize_cache/iblock/74d/530_780_1/2wnke8y1fa8su5ehjfk5mnsd4y2zvb4f.jpg">
			                                </a>
			                                <div class="catalog-item-size-list" data-code="RAZMER">
			                                                                                                                    <div class="catalog-item-size  " data-entity="scu-value" data-id="X">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                XS                                            </a>
			                                        </div>
			                                                                                                                        <div class="catalog-item-size  " data-entity="scu-value" data-id="S">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                S                                            </a>
			                                        </div>
			                                                                                                                        <div class="catalog-item-size  " data-entity="scu-value" data-id="M">
			                                            <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/">
			                                                M                                            </a>
			                                        </div>
			                                                                        </div>
			                                <div class="catalog-item-favorite">
			                                    <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/" data-id="26013">
			                                        <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
			                                            <path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"></path>
			                                        </svg>
			                                    </a>
			                                </div>
			                                <div class="card-stars-block">
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                        <span class="">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
			                                                <defs></defs>
			                                                <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
			                                            </svg>
			                                        </span>
			                                                                        </div>
			                                <div class="card-badge-block">
			                                    <div class="card-badge-item hit">Хіт продажу</div>                                </div>
			                            </div>
			                            <div class="catalog-item-name-block">
			                                <a href="/catalog/zhenskaya_odezhda/bluzy_i_rubashki/rubashki/zhenskaya-rubashka-stimma-dorena-1081/" class="catalog-item-name" data-entity="name">Жіноча сорочка Stimma Дорена</a>
			                                                            </div>
			                                                        <div class="catalog-item-info">
			                                <div class="catalog-item-price">
			                                    <div class="catalog-item-price-currency" data-entity="price">1 199 грн</div>
			                                                                    </div>
			                                <div class="catalog-item-colors" data-code="COLOR_REF">
			                                                                                <a onclick="changeData('zhenskaya-rubashka-stimma-dorena-1081', this);return false;" style="background-color: #145574;" href="#" class="catalog-item-color  active" data-entity="scu-value" data-id="siniy">
			                                                                                            </a>
			                                                                                        <a onclick="changeData('zhenskaya-rubashka-stimma-dorena-1082', this);return false;" style="background-color: #d1c3ab;" href="#" class="catalog-item-color  " data-entity="scu-value" data-id="bezhevyy">
			                                                                                            </a>
			                                                                            </div>
			                            </div>
			                        </div>
								</div>
                                */?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="size-popup"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog size-popup" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-btn-cont">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="c-biXJmc c-biXJmc-dRToyv-size-small"><g><rect width="24" height="24" fill="none"></rect><polygon points="20.8 3.9 20.1 3.2 12 11.3 3.9 3.2 3.2 3.9 11.3 12 3.2 20.1 3.9 20.8 12 12.7 20.1 20.8 20.8 20.1 12.7 12 20.8 3.9"></polygon></g></svg>
								</span>
                        </button>
                    </div>
                    <div class="popup-size-cont">
                        <?/*<ul class="nav nav-tabs" id="myTab" role="tablist">
							  <li class="nav-item active">
							    <a class="nav-link"  data-toggle="tab" href="#sizet1" role="tab"  aria-selected="true">Перетворення розміру</a>
							  </li>
							  <li class="nav-item">
							    <a class="nav-link"  data-toggle="tab" href="#sizet2" role="tab"  aria-selected="false">Вимірювання</a>
							  </li>
							</ul>*/?>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active in" id="sizet1" role="tabpanel" >
                                <?/*<div class="popup-size-text">
							  		<p>Ця річь відповідає розміру. Ми рекомендуємо вам замовляти звичайний розмір.</p>
							  		<p>Зріст моделі 180 см, на ній 34 розмір.</p>
							  	</div>*/?>
                                <div class="popup-size-table-cont pst1">
                                    <table class="table-border">
                                        <tr>
                                            <td colspan="2" style="text-align: center;">Розмір</td>
                                            <td>Обхват грудей</td>
                                            <td>Обхват талії</td>
                                            <td>Обхват стегон</td>
                                        </tr>
                                        <tr>
                                            <td>40</td>
                                            <td>XS</td>
                                            <td>80-84</td>
                                            <td>62-66</td>
                                            <td>90-94</td>
                                        </tr>
                                        <tr>
                                            <td>42</td>
                                            <td>S</td>
                                            <td>84-88</td>
                                            <td>66-70</td>
                                            <td>94-98</td>
                                        </tr>
                                        <tr>
                                            <td>44</td>
                                            <td>M</td>
                                            <td>88-92</td>
                                            <td>70-74</td>
                                            <td>98-102</td>
                                        </tr>
                                        <tr>
                                            <td>46</td>
                                            <td>L</td>
                                            <td>92-96</td>
                                            <td>74-78</td>
                                            <td>102-106</td>
                                        </tr>
                                        <tr>
                                            <td>48</td>
                                            <td>XL</td>
                                            <td>96-100</td>
                                            <td>78-82</td>
                                            <td>106-110</td>
                                        </tr>
                                        <tr>
                                            <td>50</td>
                                            <td>XXL</td>
                                            <td>100-104</td>
                                            <td>82-86</td>
                                            <td>110-114</td>
                                        </tr>
                                        <?/*<tr>
                                            <td>52</td>
                                            <td>XXXL</td>
                                            <td>104-108</td>
                                            <td>86-90</td>
                                            <td>114-118</td>
                                        </tr>
                                        <tr>
                                            <td>54</td>
                                            <td>XXXXL</td>
                                            <td>112-116</td>
                                            <td>90-94</td>
                                            <td>118-122</td>
                                        </tr>*/?>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sizet2" role="tabpanel" >
                                <div class="popup-size-switch-cont">
                                    <label class="popup-size-sw-block">
                                        <input type="checkbox" name="">
                                        <div class="popup-size-sw-text">CM</div>
                                        <div class="popup-size-sw">
                                            <span class="popup-size-sw-sl"></span>
                                        </div>
                                        <div class="popup-size-sw-text">IN</div>
                                    </label>
                                </div>
                                <div class="popup-size-table-cont pst2">
                                    <table>
                                        <tr>
                                            <td>
                                                Розмір
                                            </td>
                                            <td>
                                                34
                                            </td>
                                            <td>
                                                36
                                            </td>
                                            <td>
                                                38
                                            </td>
                                            <td>
                                                40
                                            </td>
                                            <td>
                                                42
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Бюст (CM)
                                            </td>
                                            <td>
                                                38
                                            </td>
                                            <td>
                                                40
                                            </td>
                                            <td>
                                                42
                                            </td>
                                            <td>
                                                44
                                            </td>
                                            <td>
                                                46
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Талія (см)
                                            </td>
                                            <td>
                                                6
                                            </td>
                                            <td>
                                                8
                                            </td>
                                            <td>
                                                10
                                            </td>
                                            <td>
                                                12
                                            </td>
                                            <td>
                                                14
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Стегна (CM)
                                            </td>
                                            <td>
                                                2
                                            </td>
                                            <td>
                                                4
                                            </td>
                                            <td>
                                                6
                                            </td>
                                            <td>
                                                8
                                            </td>
                                            <td>
                                                10
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="size-item"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog size-popup" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-btn-cont">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="c-biXJmc c-biXJmc-dRToyv-size-small"><g><rect width="24" height="24" fill="none"></rect><polygon points="20.8 3.9 20.1 3.2 12 11.3 3.9 3.2 3.2 3.9 11.3 12 3.2 20.1 3.9 20.8 12 12.7 20.1 20.8 20.8 20.1 12.7 12 20.8 3.9"></polygon></g></svg>
								</span>
                        </button>
                    </div>
                    <div class="popup-size-cont">
                        <div class="popup-size-table-cont">
                            <?/*<table class="">
                                                                                    <tbody><tr>
                                        <td></td><td>S</td><td>M</td><td>L</td><td>XL</td>                                                    </tr>
                                                                                        <tr>
                                        <td>Обхват грудей</td><td>82</td><td>86</td><td>90</td><td>94</td>                                                    </tr>
                                                                                        <tr>
                                        <td>Обхват талії </td><td>68</td><td>72</td><td>76</td><td>80</td>                                                    </tr>
                                                                                        <tr>
                                        <td>Обхват стегон</td><td>94</td><td>98</td><td>102</td><td>106</td>                                                    </tr>
                                                                                        <tr>
                                        <td>Довжина виробу по спинці</td><td>127</td><td>127</td><td>127</td><td>127</td>                                                    </tr>
                                                                                        <tr>
                                        <td>Довжина рукава від шиї</td><td>71</td><td>71</td><td>71</td><td>71</td>                                                    </tr>
                                                                                </tbody></table>*/?>

                            <?
                            global $cardTable,$nameForTable;

                            ?>
                        <table class="table-border">
                            <?
                            foreach ($cardTable as $index => $items)
                            {
                                ?>
                                <tr>
                                    <?
                                    foreach ($items as $index2 => $item)
                                    {
                                        ?><td colspan="<?//=!$index && !$index2 ? '2' : '1'?>" style="<?//=!$index && !$index2 ? 'text-align:center;' : ''?>"><?=!$index && !$index2 ?  $nameForTable : $item?></td><?
                                        //if($index || $index2)
                                        {
                                            /*?><td><?=!$index && !$index2 ? '' : $item?></td><?*/
                                        }
                                    }
                                    ?>
                                </tr>
                                <?
                            }
                            ?>
                        </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?
}
?>




<?
if(!isset($_COOKIE['show_subs_form']) && !$bIndex && false)
{
    ?>
    <button type="button" class="btn btn-primary show popupsubs" data-toggle="modal" data-target="#action-modal" style="display: none;">
    </button>

    <div class="modal fade" id="action-modal"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered action-modal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="action-modal-cont">
                        <div class="action-modal-img">
                            <img src="/bitrix/templates/stimma/images/300450.jpg">
                        </div>
                        <div class="action-modal-block">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="c-biXJmc c-biXJmc-ulsnn-size-medium"><g><rect width="24" height="24" fill="none"></rect><polygon points="20.8 3.9 20.1 3.2 12 11.3 3.9 3.2 3.2 3.9 11.3 12 3.2 20.1 3.9 20.8 12 12.7 20.1 20.8 20.8 20.1 12.7 12 20.8 3.9"></polygon></g></svg>
                            </button>
                            <div class="action-modal-title"><?=LANGUAGE_ID == 'ua' ? 'НЕЗАЛЕЖНІ 33' : 'НЕЗАВИСИМЫЕ 33'?></div>
                            <div class="action-modal-form">
                                <div style="color: red;display:none;" class="show_action_error"><?=LANGUAGE_ID == 'ua' ? 'Такий користувач вже існує' : 'Такой пользователь уже существует'?></div>
                                <div style="display:none;" class="show_action_success"><?=LANGUAGE_ID == 'ua' ? 'Промокод надіслано на ваш email' : 'Промокод выслан вам на Email'?></div>
                                <form>
                                    <?/*<div class="action-modal-inp">
                                        <input type="text" placeholder="Ваш E-mail" name="register_email">
                                    </div>
                                    <div class="action-modal-inp">
                                        <input type="text" placeholder="<?=LANGUAGE_ID=='ua' ? 'Ваш пароль для входу в аккаунт' :'Ваш пароль для входа в аккаунт'?>" name="register_pass">
                                    </div>*/?>
                                    <div class="action-modal-btn">
                                        <a href="<?=LANGUAGE_ID=='ru'?'/ru':''?>/blog/" style="font-weight: 500;
  font-size: 11px;
  line-height: 13px;
  text-align: center;
  text-transform: uppercase;
  color: #3d441d;
  border: 1px solid #3d441d;
  border-radius: 3px;
  padding: 13px 21px;
  background: #fff;
  width: 100%; display:block;">
                                            <?=LANGUAGE_ID=='ua'?'Детальніше про проєкт':'Детальнее о проекте'?>
                                        </a>
                                    </div>
                                    <div class="coupon_code_show"></div>
                                </form>
                            </div>
                            <div class="action-modal-text">
                                <?=LANGUAGE_ID == 'ua' ?
                                    'Цей проєкт є нашим маніфестом, яким прагнемо донести ідею, що для жінки незалежність так само важлива, як і для держави. 
 <br>
У рамках проєкту створені інтерв’ю з 33 українками, кожна з яких поділилася своїм визначенням особистої незалежності.'
                                    :
                                    'Этот проект является нашим манифестом, которым хотим донести идею, что для женщины независимость так же важна, как и для государства.<br>
                                    В рамках проекта сделаны интервью с 33 украинками, каждая из которых поделилась своим видением личной независимости.'?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?/*
    <div class="modal fade" id="action-modal"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered action-modal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="action-modal-cont">
                        <div class="action-modal-img">
                            <img src="/bitrix/templates/stimma/images/popup_subs.jpg?v=1">
                        </div>
                        <div class="action-modal-block">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="c-biXJmc c-biXJmc-ulsnn-size-medium"><g><rect width="24" height="24" fill="none"></rect><polygon points="20.8 3.9 20.1 3.2 12 11.3 3.9 3.2 3.2 3.9 11.3 12 3.2 20.1 3.9 20.8 12 12.7 20.1 20.8 20.8 20.1 12.7 12 20.8 3.9"></polygon></g></svg>
                            </button>
                            <div class="action-modal-title"><?=LANGUAGE_ID == 'ua' ? 'ЗАРЕЄСТРУЙТЕСЯ ТА ОТРИМАЙТЕ ЗНИЖКУ 10%' : 'ЗАРЕГИСТРИРУЙТЕСЬ И ПОЛУЧИТЕ СКИДКУ 10%'?></div>
                            <div class="action-modal-form">
                                <div style="color: red;display:none;" class="show_action_error"><?=LANGUAGE_ID == 'ua' ? 'Такий користувач вже існує' : 'Такой пользователь уже существует'?></div>
                                <div style="display:none;" class="show_action_success"><?=LANGUAGE_ID == 'ua' ? 'Промокод надіслано на ваш email' : 'Промокод выслан вам на Email'?></div>
                                <form>
                                    <div class="action-modal-inp">
                                        <input type="text" placeholder="Ваш E-mail" name="register_email">
                                    </div>
                                    <div class="action-modal-inp">
                                        <input type="text" placeholder="<?=LANGUAGE_ID=='ua' ? 'Ваш пароль для входу в аккаунт' :'Ваш пароль для входа в аккаунт'?>" name="register_pass">
                                    </div>
                                    <div class="action-modal-btn register_action">
                                        <button><?=LANGUAGE_ID=='ua'?'Зареєструватися':'Зарегистрироваться'?></button>
                                    </div>
                                    <div class="coupon_code_show"></div>
                                </form>
                            </div>
                            <div class="action-modal-text">
                                <?=LANGUAGE_ID == 'ua' ?
                                    '* знижка доступна клієнтам, які вперше зареєструвались на сайті. (через вікно поп-апу)<br>Для використання введіть код у полі "промокод" (знижка не діє на товар з розділу SALE)'
                                    :
                                    '* скидка доступна клиентам, которые сначала зарегистрировались на сайте. (через окно поп-апа)<br>Для использования введите код в поле "промокод (скидка не действует на товар из раздела SALE)'?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    */?>

    <script>
        setTimeout(function() {
            $('.popupsubs').trigger('click');
        }, 10000);
    </script>
    <?
    setcookie("show_subs_form", 'y', time()+86400, "/");
}


//if(isset($_GET['form']))
if(!isset($_COOKIE['show_subs_form']) && !$bIndex && false)
{
    ?>
    <button type="button" class="btn btn-primary show popupsubs" data-toggle="modal" data-target="#action-modal" style="display: none;"></button>

    <div class="modal fade" id="action-modal"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered bonus-modal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="c-biXJmc c-biXJmc-ulsnn-size-medium"><g><rect width="24" height="24" fill="none"></rect><polygon points="20.8 3.9 20.1 3.2 12 11.3 3.9 3.2 3.2 3.9 11.3 12 3.2 20.1 3.9 20.8 12 12.7 20.1 20.8 20.8 20.1 12.7 12 20.8 3.9"></polygon></g></svg>
                    </button>
                    <div class="bonus-modal-cont">
                    	<h3 class="bonus-modal-title text-center">
                    		Зареєструйтеся <br>
                    		та обирайте свій бонус
                    	</h3>
                    	<div class="bonus-modal-info">
                    		<div class="bonus-modal-item">
                    			<span>-100 ₴</span> <span class="bonus-modal-item-text">Знижка</span>
                    		</div>
                    		<div class="bonus-modal-sep">
                    			Або
                    		</div>
                    		<div class="bonus-modal-item">
                    			<span>Безкоштовна</span> <span class="bonus-modal-item-text">Доставка</span>
                    		</div>
                    	</div>
                    	<div class="bonus-modal-select">
                    		<select class="custom-select" name="type_user_register">
                    			<option value="discount">Знижка</option>
                    			<option value="delivery">Доставка</option>
                    		</select>
                    	</div>
                    	<div class="bonus-modal-btn-block">
                    		<a href="#" class="bonus-modal-btn new_register_in_popup">Зареєструватися</a>
                    	</div>
                    	<div class="bonus-modal-bottom-text">
                            *знижка/безкоштовна доставка доступна клієнтам, які вперше зареєструвались на сайті (при реєстрації через вікно поп-апу)<br>
                            *знижка/безкоштовна доставка доступна протягом 7 днів з моменту реєстрації на сайті та отримання промокоду<br>
                            <br>
                            Для використання введіть промокод у полі "промокод" (знижка/безкоштовна доставка не діє на товар з розділу SALE)<br>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            $('.popupsubs').trigger('click');
        }, 1);
    </script>
    <?
    setcookie("show_subs_form", 'y', time()+86400, "/");
}

if(!isset($_COOKIE['show_marketing_img']) && !$bIndex)
{
    ?>
    <button type="button" class="btn btn-primary show popupsubs" data-toggle="modal" data-target="#action-modal_marketing_img" style="display: none;"></button>

    <div class="modal fade" id="action-modal_marketing_img"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered bonus-modal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="c-biXJmc c-biXJmc-ulsnn-size-medium"><g><rect width="24" height="24" fill="none"></rect><polygon points="20.8 3.9 20.1 3.2 12 11.3 3.9 3.2 3.2 3.9 11.3 12 3.2 20.1 3.9 20.8 12 12.7 20.1 20.8 20.8 20.1 12.7 12 20.8 3.9"></polygon></g></svg>
                    </button>
                    <img class="bonus-modal-desc" src="<?=SITE_TEMPLATE_PATH?>/images/PC_1900x1069.jpg?v=2" alt="">
                    <img class="bonus-modal-mob" src="<?=SITE_TEMPLATE_PATH?>/images/mob_vert_470x600.jpg?v=2" alt="">
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            $('.popupsubs').trigger('click');
        }, 1);
    </script>
    <?
    setcookie("show_marketing_img", 'y', time()+(86400*7), "/");
}

?>




		<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/bottom_footer.php'));?>


                        <?
                        if($USER->IsAdmin() && !$bIndex)
                        {
                            ?>
                            <!-- Тут твій попап -->

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-size" style="display:none;">
							  Launch demo modal
							</button>

							<div class="modal fade" id="modal-size"  role="dialog" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered modal-size-slider" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							        <h4 class="modal-title"><?=LANGUAGE_ID=='ua' ? 'Засіб підбору розмірів' : 'Инструмент подбора размера'?></h4>
							      </div>
							      <div class="modal-body">
							        <div class="modal-size-cont">
							        	<div class="modal-size-img">
							        		<img class="set_image" src="">
							        	</div>
							        	<div class="modal-size-info modal-size-info-1">
							        		<div class="size-info-text">
							        			<?=LANGUAGE_ID == 'ua' ?
                                                'Ми визначимо ваш ідеальний розмір на основі вимірів вашого тіла'
                                                :
                                                'Мы определим ваш идеальный размер на основе измерений вашего тела'?>
							        		</div>
							        		<div class="size-calc-cont">
							        			<div class="size-calc-title">
                                                    <?=LANGUAGE_ID=='ua' ? 'Опишіть себе' : 'Опишите себя'?>
                                                </div>
                                                <div class="size-calc-item item2">
                                                    <div class="size-calc-key">
                                                        <?=LANGUAGE_ID=='ua' ? 'ОБХВАТ ГРУДЕЙ' : 'ОБХВАТ ГРУДЕЙ'?>
                                                    </div>
                                                    <div class="size-calc-slider-cont">
                                                        <div class="size-calc-slider"></div>
                                                    </div>
                                                    <div class="size-calc-value">
                                                        <input type="text" name="grud" value="80">
                                                        <span class="size-calc-value-text">См</span>
                                                    </div>
                                                </div>
							        			<div class="size-calc-item item1">
							        				<div class="size-calc-key">
                                                        <?=LANGUAGE_ID=='ua' ? 'ОБХВАТ ТАЛІЇ' : 'ОБХВАТ ТАЛИИ'?>
							        				</div>
							        				<div class="size-calc-slider-cont">
							        					<div class="size-calc-slider"></div>
							        				</div>
							        				<div class="size-calc-value">
							        					<input type="text" name="talia" value="62">
							        					<span class="size-calc-value-text">См</span>
							        				</div>
							        			</div>
							        			<div class="size-calc-item item3">
							        				<div class="size-calc-key">
                                                        <?=LANGUAGE_ID=='ua' ? 'ОБХВАТ СТЕГОН' : 'ОБХВАТ БЕДЕР'?>
							        				</div>
							        				<div class="size-calc-slider-cont">
							        					<div class="size-calc-slider"></div>
							        				</div>
							        				<div class="size-calc-value">
							        					<input type="text" name="bedra" value="86">
							        					<span class="size-calc-value-text">См</span>
							        				</div>
							        			</div>
							        		</div>
							        	</div>
							        	<div class="modal-size-info modal-size-info-2" style="display:none;">
							        		<div class="size-info-text">
							        			<span> 97%</span>  покупців з такими же параметрами тіла придбали розмір
							        		</div>
							        		<div class="size-info-main">
							        			44
							        		</div>
							        		<div class="size-calc-cont">
							        			<div class="size-calc-item item1">
							        				<div class="size-calc-key">
							        					44
							        				</div>
							        				<div class="size-calc-slider-cont">
							        					<div class="size-calc-bar" style="width:97%"></div>
							        				</div>
							        				<div class="size-calc-value">
							        					97%
							        				</div>
							        			</div>
							        			<div class="size-calc-item item1">
							        				<div class="size-calc-key">
							        					42
							        				</div>
							        				<div class="size-calc-slider-cont">
							        					<div class="size-calc-bar" style="width:3%"></div>
							        				</div>
							        				<div class="size-calc-value">
							        					3%
							        				</div>
							        			</div>
							        		</div>
							        		<div class="size-info-dop-text">
							        			 Розмір 44 придбали та <i>не</i> повернули через невід&shy;повідний розмір <span>97%</span> із покупців, що мають такі ж <b>Обхват талії</b>, <b>Обхват грудей</b> й <b>Обхвата стегон</b>.
							        		</div>
							        	</div>
							        </div>
							      </div>
							      <div class="modal-footer mf-1">
							        <button type="button" class="btn btn-modal find_my_size"><?=LANGUAGE_ID=='ua'?'Знайти свій розмір':'Найти мой размер'?></button>
							      </div>
							      <div class="modal-footer justify-content-space" style="display:none;">
							      	<button type="button" class="btn btn-modal btn-modal-back"><?=LANGUAGE_ID=='ua'?'Почати знову':'Начать снова'?></button>
							        <button style="display:none" type="button" class="btn btn-modal button_add_to_basket"><?=LANGUAGE_ID=='ua'?'Добавити розмір(-и) у корзину':'Добавить размер(-ы) в корзину'?></button>
							      </div>
							    </div>
							  </div>
							</div>

                            <?
                        }
                        ?>

<!-- Попап для десктопа -->
<?/*<div class="modal fade popup-outfit-modal-desktop" id="popup-outfit-modal-desktop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="position: relative;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 10px; right: 15px; font-size: 28px;">
                <span aria-hidden="true">&times;</span>
            </button>
            <img src="/upload/pc_popup.jpg?v=<?= time() ?>" alt="Outfit Desktop Popup" style="width: 100%; display: block;" />
        </div>
    </div>
</div>

<!-- Попап для мобильных -->
<div class="modal fade popup-outfit-modal-mobile" id="popup-outfit-modal-mobile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="position: relative;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 10px; right: 15px; font-size: 28px;">
                <span aria-hidden="true">&times;</span>
            </button>
            <img src="/upload/mob_popup.jpg?v=<?= time() ?>" alt="Outfit Mobile Popup" style="width: 100%; display: block;" />
        </div>
    </div>
</div>*/?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (!localStorage.getItem("popupOutfitShown_sv_01_10_25")) {
            setTimeout(function () {
                const isMobile = window.innerWidth < 768;

                if (isMobile) {
                    $('#popup-outfit-modal-mobile').modal('show');
                } else {
                    $('#popup-outfit-modal-desktop').modal('show');
                }

                localStorage.setItem("popupOutfitShown_sv_01_10_25", "true");
            }, 1000); // Показывать через 1 секунду
        }
    });
</script>

<script async rel="preconnect" href="https://cdn.bitrix24.eu">
    (function(w,d,u){
        var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
        var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
    })(window,document,'https://cdn.bitrix24.eu/b25596107/crm/site_button/loader_1_fd8pjn.js');
</script>


<?
global $USER;
//if(!$USER->IsAdmin() && strpos($APPLICATION->GetCurPage(),'/order/') !== false)
if(!$USER->IsAdmin() && strpos($APPLICATION->GetCurPage(),'/order/') !== false)
{
    ?>
    <!-- Hotjar Tracking Code for https://stimma.com.ua -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:3802825,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
    <?
}
?>



<script>
    // JavaScript для управления загрузочным экраном
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                loadingScreen.style.display = 'none';
            }
        }, 500); // Задержка в 500 мс
    });
</script>

<?
$usdRate = COption::GetOptionString("my_module", "usd_rate",'41.7');
//$res = $DB->Query('select * from payments where UF_FACEBOOK != 1 limit 1');
$res = $DB->Query('select * from facebook_purchase where UF_STATUS = 0 limit 1');
$facebookIds=[];
while ($record = $res->Fetch())
{
    $orderId = $record['UF_ORDER_ID'];
    $Order = $DB->Query('select * from b_sale_order where ID = ' . $orderId)->Fetch();

    $res2 = $DB -> Query('select * from b_sale_basket where ORDER_ID = ' . $orderId);
    while ($itemBasket = $res2->Fetch())
    {
        $mainPID = CIBlockElement::GetProperty(25, $itemBasket['PRODUCT_ID'],'sort', 'asc', array('CODE' => 'CML2_LINK')) -> Fetch()['VALUE'];
        $facebookIds[] = $mainPID;
    }
    ?>
    <script>
        fbq ( 'track', 'Purchase',
            {value:<?=round($Order['PRICE']/$usdRate,2)?>,
                Currency: 'USD',
                Content_ids: [<?=implode(',',$facebookIds)?>],
                Content_type: 'Purchase',
                Content_category: 'Purchase' ,
            });
    </script>
    <?
    $DB->Query('update facebook_purchase set UF_STATUS = 1 where ID = ' . $record['ID']);
}
?>

	</body>
</html>
                        <?

                        global $dataSeo, $dataSeoElement, $seo, $selectedFilter;
                        ?><pre>1 <?=print_r($dataSeo,1)?></pre><?
                        ?><pre>2 <?=print_r($dataSeoElement,1)?></pre><?
                        ?><pre>3 <?=print_r($seo,1)?></pre><?
                        ?><pre>4 <?=print_r($selectedFilter,1)?></pre><?
                        if($seo)
                        {

                            if(!empty($selectedFilter))
                            {
                                // COLOR RAZMER VID SOSTAV SELECTION STYLES PRINT
                                $arFilters = ['COLOR', 'RAZMER', 'VID', 'SOSTAV', 'SELECTION', 'STYLES', 'PRINT'];
                                foreach($selectedFilter as $index => $item)
                                {
                                    foreach($seo as $index2 => $item2)
                                        $seo[$index2] = str_replace('{'.$item['code'].'}', $item['value'], $seo[$index2]);
                                }
                                foreach($arFilters as $index => $item)
                                {
                                    foreach($seo as $index2 => $item2)
                                        $seo[$index2] = str_replace('{'.$item.'}', $item, $seo[$index2]);
                                }
                            }

                            if($seo['ELEMENT_META_TITLE'])
                                $APPLICATION -> SetPageProperty('title', changeColorToUa($seo['ELEMENT_META_TITLE'], $mainColors));
                            if($seo['ELEMENT_META_DESCRIPTION'])
                                $APPLICATION -> SetPageProperty('description', changeColorToUa($seo['ELEMENT_META_DESCRIPTION'], $mainColors));
                            if($seo['ELEMENT_PAGE_TITLE'])
                            {
                                $APPLICATION -> SetTitle($seo['ELEMENT_PAGE_TITLE']);
                                $APPLICATION->AddViewContent('mdf_title',$seo['ELEMENT_PAGE_TITLE']);
                            }

                        }
                        elseif($dataSeoElement)
                        {
                            if($dataSeoElement['ELEMENT_META_TITLE'])
                                $APPLICATION -> SetPageProperty('title', changeColorToUa($dataSeoElement['ELEMENT_META_TITLE'], $mainColors));
                            if($dataSeoElement['ELEMENT_META_DESCRIPTION'])
                                $APPLICATION -> SetPageProperty('description', changeColorToUa($dataSeoElement['ELEMENT_META_DESCRIPTION'], $mainColors));
                            if($dataSeoElement['ELEMENT_PAGE_TITLE'])
                                $APPLICATION -> SetTitle($dataSeoElement['ELEMENT_PAGE_TITLE']);
                        }
                        elseif ($dataSeo)
                        {
                            if($dataSeo['SECTION_META_TITLE'])
                                $APPLICATION -> SetPageProperty('title', changeColorToUa($dataSeo['SECTION_META_TITLE'], $mainColors));
                            if($dataSeo['SECTION_META_DESCRIPTION'])
                                $APPLICATION -> SetPageProperty('description', changeColorToUa($dataSeo['SECTION_META_DESCRIPTION'],$mainColors));
                            if($dataSeo['SECTION_PAGE_TITLE'])
                                $APPLICATION -> SetTitle($dataSeo['SECTION_PAGE_TITLE']);
                        }



                        $filterPage = $APPLICATION -> GetCurPage();
                        if(isset($_SERVER['NEW_URL']))
                            $filterPage = $_SERVER['NEW_URL'][3];

                        if(
                                isset($_GET['q'])
                                || isset($_GET['sort'])
                                || isset($_GET['utm_source'])
                                || isset($_GET['by'])
                                || isset($_GET['post_type'])
                                || isset($_GET['redirect_to'])
                                || isset($_GET['year'])
                                || isset($_GET['lang'])
                                || isset($_GET['product_cat'])
                                || strpos($filterPage, '/filter/') !== false
                                || strpos($filterPage, '/vidguki/') !== false
                                || strpos($filterPage, '/basket/') !== false
                                || strpos($filterPage, '/order/') !== false
                                || strpos($APPLICATION -> GetCurPage(), '/author/') !== false
                                || $APPLICATION -> GetCurPage() == '/ru/cpivrobitnictvo/dlya-dropshipperiv-organizatoriv-sp-i-torgovix-storinok/'
                                || $APPLICATION -> GetCurPage() == '/cpivrobitnictvo/dlya-dropshipperiv-organizatoriv-sp-i-torgovix-storinok/'
                                || $APPLICATION -> GetCurPage() == '/ru/perevagi-spivpraci-z-kompaniyeyu-stimma/'
                                || $APPLICATION -> GetCurPage() == '/perevagi-spivpraci-z-kompaniyeyu-stimma/'
                                || $APPLICATION -> GetCurPage() == '/ru/perevagi-spivpraci-z-kompaniyeyu-stimma/'
                                || $APPLICATION -> GetCurPage() == '/perevagi-spivpraci-z-kompaniyeyu-stimma/'
                                || $APPLICATION -> GetCurPage() == '/catalog/maska-aksessuar-4680-1/'
                                || $APPLICATION -> GetCurPage() == '/ru/catalog/maska-aksessuar-4680-1/'
                                || $APPLICATION -> GetCurPage() == '/catalog/maska-aksessuar-4680-1-2-1/'
                                || $APPLICATION -> GetCurPage() == '/ru/catalog/maska-aksessuar-4680-1-2-1/'
                                || strpos($APPLICATION -> GetCurPage(),'/detskaya_odezhda/')!==false
                        )
                            $APPLICATION -> SetPageProperty('robots', 'noindex, nofollow');
                        else
                            $APPLICATION -> SetPageProperty('robots', 'index, follow');

                        if(!empty($_GET))
                            foreach ($_GET as $param => $value)
                            {
                                if(strpos($param, 'PAGEN_') !== false)
                                {
                                    global $maxNUmbers;
                                    // todo тут домен треба змінити
                                    //$APPLICATION -> SetPageProperty('canonical', 'https://www.stimma.com.ua'.$APPLICATION -> GetCurPage().'?'.$param.'='.$value);

                                    $h1 = $APPLICATION -> GetTitle();

                                    $title = $APPLICATION -> GetPageProperty('title');
                                    $desc = $APPLICATION -> GetPageProperty('description');

                                    $title = 'Страница '.$value.' из '.$maxNUmbers.': ' . $title;
                                    $desc = 'Страница '.$value.' из '.$maxNUmbers.': ' . $desc;
                                    $h1 .= ' - страница '.$value;

                                    $APPLICATION -> SetTitle($h1);
                                    $APPLICATION -> SetPageProperty('title', changeColorToUa($title, $mainColors));
                                    $APPLICATION -> SetPageProperty('description', $desc);
                                }
                            }

                        if($APPLICATION -> GetCurPage() == '/')
                        {
                            $APPLICATION -> SetPageProperty('title', 'Інтернет-магазин жіночого одягу від виробника STIMMA');
                            $APPLICATION -> SetPageProperty('description', 'Жіночий одяг та аксесуари від українського виробника STIMMA ⭐ Нові колекції ✔️ Висока якість одягу та аксесуарів ⚡ Швидка доставка по Україні');
                        }
                        elseif($APPLICATION -> GetCurPage() == '/ru/')
                        {
                            $APPLICATION -> SetPageProperty('title', 'Интернет-магазин женской одежды от производителя STIMMA');
                            $APPLICATION -> SetPageProperty('description', 'Женская одежда и аксессуары от украинского производителя STIMMA ⭐ Новые коллекции ✔️ Высокое качество одежды и аксессуаров ⚡ Быстрая доставка по Украине');
                        }
						
						$ppage = $APPLICATION -> GetCurPage();
						//echo "page==$page<===";
						
						$opt_pages = ['/spivpracya-z-optovikami/', '/auth/', '/garantiya-ta-povernennya/'];
                        if( in_array($page, $opt_pages))
                        {
                            $APPLICATION -> SetPageProperty('title', 'Для оптових клієнтів | Інтернет магазин одягу від виробника STIMMA');
                            $APPLICATION -> SetPageProperty('description', 'Для оптових клієнтів - Модний жіночий одяг від українського виробника ТМ STIMMA');
                        }
						
						$opt_pages = ['/ru/spivpracya-z-optovikami/', '/ru/auth/', '/ru/garantiya-ta-povernennya/'];
                        if( in_array($page, $opt_pages))
                        {
                            $APPLICATION -> SetPageProperty('title', 'Для оптовых клиентов | Интернет-магазин одежды от производителя STIMMA');
                            $APPLICATION -> SetPageProperty('description', 'Для оптовых клиентов — Модная женская одежда от украинского производителя ТМ STIMMA');
                        }
						


                        if($APPLICATION -> GetCurPage() == '/catalog/detskaya_odezhda/odezhda_dlya_devochek/detskaya-futbolka-stimma-daytsyya-6777/' ||
                        $APPLICATION -> GetCurPage() == '/catalog/detskaya_odezhda/odezhda_dlya_malchikov/detskie-bryuki-stimma-vildan-6837/' ||
                        $APPLICATION -> GetCurPage() == '/catalog/detskaya_odezhda/odezhda_dlya_malchikov/detskiy-sportivnyy-kostyum-stimma-sheyn-9646/' ||
                        $APPLICATION -> GetCurPage() == '/catalog/detskaya_odezhda/odezhda_dlya_devochek/detskoe-plate-stimma-pring-4890/' ||
                        $APPLICATION -> GetCurPage() == '/catalog/detskaya_odezhda/odezhda_dlya_malchikov/detskie-sportivnye-shtany-stimma-aristol-6059/' ||
                        $APPLICATION -> GetCurPage() == '/catalog/detskaya_odezhda/odezhda_dlya_devochek/detskaya-futbolka-stimma-akorniya-7666/' ||
                        $APPLICATION -> GetCurPage() == '/catalog/detskaya_odezhda/odezhda_dlya_malchikov/detskie-shorty-stimma-korgo-7796/' ||
                        $APPLICATION -> GetCurPage() == '/catalog/detskaya_odezhda/odezhda_dlya_devochek/detskoe-plate-stimma-kolin-7741/' ||
                        $APPLICATION -> GetCurPage() == '/catalog/detskaya_odezhda/odezhda_dlya_devochek/platya_sarafany_i_yubki_g/platya_g/zhenskoe-plate-stimma-shayna-7581/')
                        {
                            $APPLICATION->SetPageProperty('robots','noindex, nofollow');
                        }

                        global $canonical;
                        if(isset($_GET['PAGEN_1']))
                            $APPLICATION -> SetPageProperty('canonical', 'https://www.stimma.com.ua'.$APPLICATION -> GetCurPage().'?PAGEN_1='.$_GET['PAGEN_1']);
                        elseif($APPLICATION->GetCurPage() == '/ru/catalog/zhenskaya_odezhda/dzhinsy_bryuki_shorty/legginsy/zhenskie-legginsy-stimma-meydi-7/')
                            $APPLICATION -> SetPageProperty('canonical', 'https://www.stimma.com.ua/ru/catalog/zhenskaya_odezhda/dzhinsy_bryuki_shorty/legginsy/zhenskie-legginsy-stimma-meydi-7/');
                        elseif($APPLICATION->GetCurPage() == '/catalog/zhenskaya_odezhda/sportivnaya_odezhda/sportivnye_losiny/zhenskie-legginsy-stimma-meydi-7/')
                            $APPLICATION -> SetPageProperty('canonical', 'https://www.stimma.com.ua/catalog/zhenskaya_odezhda/sportivnaya_odezhda/sportivnye_losiny/zhenskie-legginsy-stimma-meydi-7/');
                        elseif($canonical)
                            $APPLICATION -> SetPageProperty('canonical', $canonical);

							

						
						$opt_pages = [						
						'/catalog/novinki/',
						'/catalog/events/',
						'/catalog/limited/',
						'/catalog/outdoor/',
						'/catalog/khity_prodazh/',
						'/catalog/rasprodazha/'];
						$descr = $APPLICATION -> GetPageProperty('description');
						//echo "page==$page<===<br>\r\n";
						//echo "descr==$descr<===<br>\r\n";
						global $sv_prices;
                        if( in_array($page, $opt_pages) && isset($sv_prices['min']) )
							
							$descr = str_replace('{year}', date('Y'), $descr);
						
							$tmp = explode('Ціни від  до  грн', $descr);
							if ( isset($tmp[1]) ) {
								$descr = $tmp[0]."Ціни від {$sv_prices['min']} до {$sv_prices['max']} грн".$tmp[1];
								$APPLICATION -> SetPageProperty('description', $descr);
							}
							$tmp = explode('Цены от  до  грн', $descr);
							if ( isset($tmp[1]) ) {
								$descr = $tmp[0]."Цены от {$sv_prices['min']} до {$sv_prices['max']} грн".$tmp[1];
								$APPLICATION -> SetPageProperty('description', $descr);
							}
							/*echo "descr==$descr<===<br>\r\n";
							echo "footer_<pre>";print_R($tmp);echo "</pre><br>";
							echo "<pre>";print_R($sv_prices);echo "</pre>";*/


                        if(isset($_GET['mdrv']))
                        {
                            $newPage = $APPLICATION->GetCurPageParam('',['mdrv']);
                            LocalRedirect($newPage);
                            exit();
                        }

                        ?>



