<?
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
									<?if(!isset($_GET['me'])) echo '</div>'?> <?// .maxwidth-theme?>
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
<?if(strpos($APPLICATION->GetCurPage(). '/catalog/novinki/') !== false) echo '</div>'?>

		<footer id="footer">
			<?/*include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/under_footer.php'));*/?>
			<?/*include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/top_footer.php'));*/?>
			<div class="footer-cont">
				<div class="footer-block">
					<div class="footer-logo">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/stimma.png">
						</a>
					</div>
					<div class="footer-text">
                        <?//=LANGUAGE_ID == 'ua' ? ' STIMMA - це моє!' : 'STIMMA - это мое!'?>

                        <?=LANGUAGE_ID == 'ua' ?
                            //'Найбільше ми цінуємо в одязі комфорт і легкість. Адже кожна наша річ відповідає сучасним трендам і перетворить Вас у модницю, будь-то сукня чи маленький аксесуар.'
                            '<ul>
							<li>Stimma - це український бренд жіночого одягу, який має власне швейне виробництво та мережу фірмових магазинів по всій Україні.</li>
							<li>Усі колекції в магазині представлені капсулами, одяг з яких завжди гармонійно поєднується між собою. </li>
							<li>Щотижня у нас відбувається оновлення.</li>
						</ul>
'
                            :
//                            'Больше всего мы ценим в одежде комфорт и легкость. Ведь каждая вещь соответствует современным трендам и преврати Вас у иодницу, будь то платье или маленький акссесуар.'
                            '
                            <ul>
							<li>Stimma - это украинский бренд женской одежды, который имеет собственное швейное производство и сеть фирменных магазинов по всей Украине.</li>
							<li>Все коллекции в магазине представлены капсулами, одежда с которых всегда гармонично сочетается между собой.</li>
							<li>Каждую неделю у нас происходит обновление.</li>
						</ul>
'?>

					</div>
				</div>



				<div class="footer-block">
					<div class="footer-block-menu">
						<div class="footer-block-title">
							<span><?=LANGUAGE_ID == 'ua' ? 'Інформація' : 'Информация'?></span>
                            <a href="<?=LANGUAGE_ID == 'ru' ? '/ru':''?>/pro-nas/yak-zrobiti-zamovlennya/"><?=LANGUAGE_ID == 'ua' ? 'Інформація' : 'Информация'?></a>
						</div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "footer_info_menu",
                            array(
                                "COMPONENT_TEMPLATE" => "footer_info_menu",
                                "ROOT_MENU_TYPE" => "info_menu",
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
					</div>
				</div>
				<div class="footer-block">
					<div class="footer-block-menu">
						<div class="footer-block-title">
                            <span><?=LANGUAGE_ID == 'ua' ? 'Співпраця' : 'Сотрудничество'?></span>
                            <a href="<?=LANGUAGE_ID == 'ru' ? '/ru':''?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/"><?=LANGUAGE_ID == 'ua' ? 'Співпраця' : 'Сотрудничество'?></a>
						</div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "footer_info_menu",
                            array(
                                "COMPONENT_TEMPLATE" => "footer_info_menu",
                                "ROOT_MENU_TYPE" => "info_menu2",
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
					<div class="footer-block-menu">
						<div class="footer-block-title">
                            <a href="<?=LANGUAGE_ID == 'ru' ? '/ru':''?>/contacts/"><?=LANGUAGE_ID == 'ua' ? 'Наші магазини' : 'Наши магазины'?></a>
						</div>
						<div class="footer-block-title">
                            <span><?=LANGUAGE_ID == 'ua' ? 'Контактна інформація' : 'Контактная информация'?></span>
                            <a href="<?=LANGUAGE_ID == 'ru' ? '/ru':''?>/contacts/"><?=LANGUAGE_ID == 'ua' ? 'Контактна інформація' : 'Контактная информация'?></a>
						</div>
						<ul class="footer-block-list">
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
							
						</ul>
					</div>
				</div>
				<div class="footer-block">
					<div class="footer-block-menu">
						<div class="footer-block-title">
                            <span><?=LANGUAGE_ID == 'ua' ? 'Слідкуйте за нами' : 'Следите за нами'?></span>
						</div>
						<ul class="footer-block-list footer-block-list-line">
							<li>
								<a target="_blank" href="https://www.instagram.com/stimma_official/">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
								</a>
							</li>
							<li>
								<a target="_blank" href="https://www.facebook.com/stimma2016/">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
								</a>
							</li>
							<li>
								<a target="_blank" href="https://www.youtube.com/channel/UCYbanVf9TfoB3sZ3FZDkGng">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="footer-copyright">
				© 2021 STIMMA - <?=LANGUAGE_ID == 'ua' ? 'Інтернет магазин жіночого одягу від виробника' : 'Интернет магазин женской одежды от производителя'?>
			</div>
		</footer>
		<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/bottom_footer.php'));?>


                        <?
                        if($USER->IsAdmin())
                        {
                            ?>
                            <!-- Тут твій попап -->

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-size" style="display: none;">
							  Launch demo modal
							</button>

							<div class="modal fade" id="modal-size" tabindex="-1" role="dialog" aria-hidden="true">
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


                        <script async rel="preconnect" href="https://cdn.bitrix24.eu">
                            (function(w,d,u){
                                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
                                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
                            })(window,document,'https://cdn.bitrix24.eu/b25596107/crm/site_button/loader_1_fd8pjn.js');
                        </script>
	</body>
</html>
                        <?

                        global $dataSeo, $dataSeoElement, $seo, $selectedFilter;

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
                                $APPLICATION -> SetPageProperty('description', $seo['ELEMENT_META_DESCRIPTION']);
                            if($seo['ELEMENT_PAGE_TITLE'])
                            {
                                $APPLICATION -> SetTitle($seo['ELEMENT_PAGE_TITLE']);
                                $APPLICATION->AddViewContent('mdf_title',$seo['ELEMENT_PAGE_TITLE']);
                            }

                            if(isset($_GET['p']))
                            {
                                ?><pre><?=print_r($seo, 1)?></pre><?
                                ?><pre>gettitle <?=print_r($APPLICATION->GetTitle(), 1)?></pre><?
                                die();
                            }

                        }
                        elseif($dataSeoElement)
                        {
                            if($dataSeoElement['ELEMENT_META_TITLE'])
                                $APPLICATION -> SetPageProperty('title', changeColorToUa($dataSeoElement['ELEMENT_META_TITLE'], $mainColors));
                            if($dataSeoElement['ELEMENT_META_DESCRIPTION'])
                                $APPLICATION -> SetPageProperty('description', $dataSeoElement['ELEMENT_META_DESCRIPTION']);
                            if($dataSeoElement['ELEMENT_PAGE_TITLE'])
                                $APPLICATION -> SetTitle($dataSeoElement['ELEMENT_PAGE_TITLE']);
                        }
                        elseif ($dataSeo)
                        {
                            if($dataSeo['SECTION_META_TITLE'])
                                $APPLICATION -> SetPageProperty('title', changeColorToUa($dataSeo['SECTION_META_TITLE'], $mainColors));
                            if($dataSeo['SECTION_META_DESCRIPTION'])
                                $APPLICATION -> SetPageProperty('description', $dataSeo['SECTION_META_DESCRIPTION']);
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
                                || strpos($filterPage, '/filter/') !== false
                                || strpos($APPLICATION -> GetCurPage(), '/author/') !== false
                        )
                            $APPLICATION -> SetPageProperty('robots', 'noindex');
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
                            $APPLICATION -> SetPageProperty('title', 'Інтернет магазин одягу від виробника Стімма. &ndash; STIMMA');
                            $APPLICATION -> SetPageProperty('description', 'Інтернет магазин одягу від виробника Стімма. &ndash; STIMMA');
                        }
                        elseif($APPLICATION -> GetCurPage() == '/ru/')
                        {
                            $APPLICATION -> SetPageProperty('title', 'Интернет магазин одежды от производителя Стимма. &ndash; STIMMA');
                            $APPLICATION -> SetPageProperty('description', 'Интернет магазин одежды от производителя Стимма. &ndash; STIMMA');
                        }
                        ?>