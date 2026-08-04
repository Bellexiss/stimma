<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
$bIndex = (strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false) || isset($_GET['me']);

//$basket = getBasket();
$basketCount = getBasketCount();
global $arTheme, $arRegion, $bLongHeader, $bColoredHeader,$USER;
$arRegions = CMaxRegionality::getRegions();
if($arRegion)
	$bPhone = ($arRegion['PHONES'] ? true : false);
else
	$bPhone = ((int)$arTheme['HEADER_PHONES'] ? true : false);
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
$bLongHeader = true;
$bColoredHeader = true;
$type = getTypeDevice();

							/*if ( isset($_GET['svtmp2255']) ) {
								echo "type___=$type<==";exit();
							}*/

?>

<?
if(!$bIndex)
{
    ?>


    <link rel="stylesheet" href="/bitrix/templates/aspro_max/css/slick.css">
    <script src="/bitrix/templates/aspro_max/js/slick.min.js" ></script>

    <?/*<link rel="preload" as="style"  href="/bitrix/templates/aspro_max/css/select2.min.css">*/?>
    <?/*<script src="/bitrix/templates/aspro_max/js/select2.min.js?v=<?=strtotime(date('d.m.Y H:i:s'))?>"></script>*/?>

    <link rel="stylesheet" href="/bitrix/templates/aspro_max/fbox/source/jquery.fancybox.css">
    <link rel="stylesheet" href="/bitrix/templates/aspro_max/fbox/source/helpers/jquery.fancybox-buttons.css">
    <link rel="stylesheet" href="/bitrix/templates/aspro_max/fbox/source/helpers/jquery.fancybox-thumbs.css">

    <script src="/bitrix/templates/aspro_max/fbox/lib/jquery.mousewheel.pack.js" ></script>
    <script src="/bitrix/templates/aspro_max/fbox/source/jquery.fancybox.js" ></script>
    <script src="/bitrix/templates/aspro_max/fbox/source/helpers/jquery.fancybox-buttons.js" ></script>
    <script src="/bitrix/templates/aspro_max/fbox/source/helpers/jquery.fancybox-media.js" ></script>
    <script src="/bitrix/templates/aspro_max/fbox/source/helpers/jquery.fancybox-thumbs.js" ></script>
    <?
}


$res = CIBlockSection::GetList(['LEFT_MARGIN' => 'ASC','sort' => 'asc'], ['IBLOCK_ID' => 21, 'ACTIVE' => 'Y', '<DEPTH_LEVEL' => 3], false, ['IBLOCK_SECTION_ID','ID', 'NAME', 'SECTION_PAGE_URL', 'UF_*', 'DEPTH_LEVEL']);
$items = [];
while ($record = $res -> GetNext())
{
    if(LANGUAGE_ID == 'ua' && $record['UF_NAME_UA'])
        $record['NAME'] = $record['UF_NAME_UA'];

    if($record['DEPTH_LEVEL'] == 1)
        $items[$record['ID']] = $record;
    else
        $items[$record['IBLOCK_SECTION_ID']]['items'][$record['ID']] = $record;
}
?>
<!-- black -->

<div class="header-new-cont">
	<div class="header-new">
		<div class="header-new-block">
			<div class="header-new-gradient"></div>
			<div class="header-new-bar">
				<div class="header-new-burger" data-toggle="modal" data-target="#menu-mob-popup">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" fill="currentcolor"><g><g><rect width="24" height="24" fill="none"></rect><rect y="7.5" width="24" height="1"></rect><rect y="15.5" width="24" height="1"></rect></g></g></svg>
				</div>
				<div class="header-new-list">
					<div class="header-new-elem hoverme_1">
						Каталог 
					</div>
					<a href="<?=LANGUAGE_ID == 'ua' ? '' : '/ru'?>/contacts/" class="header-new-elem">
						 <?=UA?'Магазини':'Магазины'?>
					</a>
					<div class="header-new-elem header-search-icon" data-toggle="modal" data-target="#search-fixed-modal-cont">
						<svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M9.14459 17.2892C13.6427 17.2892 17.2892 13.6427 17.2892 9.14459C17.2892 4.64646 13.6427 1 9.14459 1C4.64646 1 1 4.64646 1 9.14459C1 13.6427 4.64646 17.2892 9.14459 17.2892Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10"></path>
							<path d="M14.4937 15.2681L19.2376 20" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10"></path>
						</svg>
					</div>
                    <a href="<?=LANGUAGE_ID == 'ua' ? '' : '/ru'?>/catalog/novinki/" class="header-new-elem">
                        <?=UA?'NEW':'NEW'?>
                    </a>
                    <a href="<?=LANGUAGE_ID == 'ua' ? '' : '/ru'?>/catalog/rasprodazha/" class="header-new-elem" style="color: #ec5353">
                        <?=UA?'SALE':'SALE'?>
                    </a>
                    <?php /*<a href="<?=LANGUAGE_ID == 'ua' ? '' : '/ru'?>/look20/" class="header-new-elem">
                        <?=UA?'Акція на Look':'Акция на Look'?>
                    </a>*/ ?>
                    <a href="<?=LANGUAGE_ID=='ru'?'/ru':''?>/blog/" class="header-new-elem">
                        <?=LANGUAGE_ID=='ua' ?'Проєкти' :'Проекты'?>
                    </a>
				</div>
				<div class="header-new-logo">
					<a href="<?=UA ? '/' : '/ru/'?>" aria-label="<?=LANGUAGE_ID == 'ua' ? 'Інтернет-магазин STIMMA' : 'Интернет-магазин STIMMA'?>">
						<svg version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1164.53 223" style="enable-background:new 0 0 1164.53 223;" xml:space="preserve">
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
										c3.16,2.8,5.69,6.07,7.52,9.73C166.28,124.15,167.24,128.48,167.24,133.23z"/>
								</g>
								<g>
									<polygon points="341.18,53.4 341.18,86.9 296.34,86.9 296.34,169.45 257.3,169.45 257.3,86.9 212.54,86.9 212.54,53.4 		"/>
								</g>
								<g>
									<rect x="394.04" y="53.4" width="39.03" height="116.05"/>
								</g>
								<g>
									<polygon points="672.09,53.4 672.09,169.45 633.21,169.45 633.21,111.34 602.5,169.45 568.81,169.45 538.1,111.34 538.1,169.45 
										499.07,169.45 499.07,53.4 546.21,53.4 585.66,127.33 625.11,53.4 		"/>
								</g>
								<g>
									<polygon points="911.15,53.4 911.15,169.45 872.28,169.45 872.28,111.34 841.57,169.45 807.88,169.45 777.17,111.34 
										777.17,169.45 738.14,169.45 738.14,53.4 785.27,53.4 824.72,127.33 864.17,53.4 		"/>
								</g>
								<g>
									<path d="M1058.76,53.4h-38.17l-60.73,116.05h43.77l9.9-19.97h52.28l9.91,19.97h43.76L1058.76,53.4z M1050.54,118.36h-21.55
										l10.82-21.72L1050.54,118.36z"/>
								</g>
							</g>
						</svg>
					</a>
				</div>

				<div class="header-new-list">
                    <?
                    //if($USER->IsAdmin())
                    {
                        ?>
                        <div class="header-new-elem">
                            <a title="<?=LANGUAGE_ID == 'ua' ? 'САМА СОБІ STIMMA' : 'САМА СЕБЕ STIMMA'?>" class="header-new-elem" href="<?=UA?'':'/ru'?>/sama_sobi/" >
                                <?=UA?'САМА СОБІ STIMMA':'САМА СЕБЕ STIMMA'?>
                            </a>
                        </div>
                        <?
                    }
                    ?>

					<div class="header-new-elem">
						<div class="language-switch">
                            <?
                            $pageUrl = isset($_SERVER['NEW_URL']) ? $_SERVER['NEW_URL'][3] : $APPLICATION->GetCurPage();
                            $page = str_replace('/ru/','/',$pageUrl);
                            if(LANGUAGE_ID == 'ua')
                            {
                                ?>
                                <span class="language-switch-item active">
								UA
							</span>
                                <span class="language-switch-sep">/</span>
                                <a href="/ru<?=$page?>" class="language-switch-item">RU</a>
                                <?
                            }
                            else
                            {
                                ?> 

                                <a href="<?=$page?>" class="language-switch-item">UA</a>
                                <span class="language-switch-sep">/</span>
                                <span class="language-switch-item active">
								RU
							</span>

                                <?
                            }
                            ?>
						</div>
					</div>
					<div class="header-new-elem hoverme_2">
						<?=UA?'Користувачам':'Пользователям'?>
					</div>
                    <?
                    if(isset($_GET['new']) || true)
                    {
                        if(!$USER->IsAuthorized())
                        {
                            ?>
                            <div class="header-new-elem personal">
                            	<a rel="nofollow" title="<?=LANGUAGE_ID == 'ua' ? 'Мій кабінет' : 'Мой кабинет'?>" class="header-favorite-link" data-event="jqm" data-param-type="auth" data-name="auth" href="/personal/" data-param-backurl="/">
                        			<svg class="" width="19" height="19" viewBox="0 0 19 19"><path data-name="Ellipse 206 copy 4" class="cls-1" d="M909,961a9,9,0,1,1,9-9A9,9,0,0,1,909,961Zm2.571-2.5a6.825,6.825,0,0,0-5.126,0A6.825,6.825,0,0,0,911.571,958.5ZM909,945a6.973,6.973,0,0,0-4.556,12.275,8.787,8.787,0,0,1,9.114,0A6.973,6.973,0,0,0,909,945Zm0,10a4,4,0,1,1,4-4A4,4,0,0,1,909,955Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,909,949Z" transform="translate(-900 -943)"></path>
                        			</svg>
                            	</a>
                            </div>
                            <?
                        }
                        else
                        {
                            ?>
                            <div class="header-new-elem personal">
                            	<a rel="nofollow" title="<?=LANGUAGE_ID == 'ua' ? 'Мій кабінет' : 'Мой кабинет'?>" class="header-favorite-link"  href="/personal/" >
                            			<svg class="" width="19" height="19" viewBox="0 0 19 19"><path data-name="Ellipse 206 copy 4" class="cls-1" d="M909,961a9,9,0,1,1,9-9A9,9,0,0,1,909,961Zm2.571-2.5a6.825,6.825,0,0,0-5.126,0A6.825,6.825,0,0,0,911.571,958.5ZM909,945a6.973,6.973,0,0,0-4.556,12.275,8.787,8.787,0,0,1,9.114,0A6.973,6.973,0,0,0,909,945Zm0,10a4,4,0,1,1,4-4A4,4,0,0,1,909,955Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,909,949Z" transform="translate(-900 -943)"></path>
                            			</svg>
                            	</a>
                            </div>
                            <?
                        }

                    }
                    ?>
					<div class="header-new-elem favorite">
						<a href="<?=UA?'':'/ru'?>/favorite/" class="header-favorite-link favcounter">
							<span class="counter">
								0
							</span>
							<span class="icon">
								<!-- <svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M16.761 1.01109C13.871 1.14109 11.641 3.78109 11.501 4.99109C11.321 3.39109 7.46095 -0.748911 3.25095 1.82109C1.36095 2.98109 0.920954 4.65109 1.01095 6.13109C1.12095 7.86109 1.99095 9.45109 3.27095 10.6011L11.501 18.0011L19.451 10.8511" stroke="#fff" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"></path>
								</svg> -->
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path d="M4.3314 12.0474L12 20L19.6686 12.0474C20.5211 11.1633 21 9.96429 21 8.71405C21 6.11055 18.9648 4 16.4543 4C15.2487 4 14.0925 4.49666 13.24 5.38071L12 6.66667L10.76 5.38071C9.90749 4.49666 8.75128 4 7.54569 4C5.03517 4 3 6.11055 3 8.71405C3 9.96429 3.47892 11.1633 4.3314 12.0474Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
							</span>
						</a>
					</div>
					<div class="header-new-elem header-new-elem-basket <?=$basketCount ? 'green-basket' : ''?>">
						<div class="header-basket-block get_popup_basket" data-toggle="modal" data-target="#basket-popup">
							<div class="header-basket-text">
								<?=LANGUAGE_ID == 'ua' ? 'Кошик' : 'Корзина'?>
							</div>
							<div class="header-basket-icon">
								<!-- <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M20.5148 16.03L20.9849 19.62C21.085 20.35 20.5148 21 19.7646 21H3.23012C2.48991 21 1.90976 20.35 2.00978 19.62L3.59021 7.76001H14.4832" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10"/>
									<path d="M14.8632 3.38C14.3431 2.06 13.3628 1 11.5023 1C7.53125 1 7.53125 5.83 7.53125 7.76" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
								</svg> -->
								<img src="/bitrix/templates/stimma/images/shopping-bag-extra-thick-white.png">
							</div>
							<div class="header-basket-counter" style="<?=$basketCount ? '' : 'display:none;'?>"><?=$basketCount?></div>
						</div>
					</div>
					<!-- opened -->
					<div class="header-basket-add-block ">
						<div class="header-basket-add-text">
                            <?=LANGUAGE_ID == 'ua' ? 'Товар додано у кошик' : 'Товар добавлен в корзину'?>
						</div>
						<div class="header-basket-add-remove">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="c-biXJmc c-biXJmc-ulsnn-size-medium"><g><rect width="24" height="24" fill="none"></rect><polygon points="20.8 3.9 20.1 3.2 12 11.3 3.9 3.2 3.2 3.9 11.3 12 3.2 20.1 3.9 20.8 12 12.7 20.1 20.8 20.8 20.1 12.7 12 20.8 3.9"></polygon></g></svg>
						</div>
					</div>
				</div>
			</div>
		</div>
        <?
        if(!$bIndex)
        {
            ?>
            <div class="h-menu-cont">
                <div data-for="hoverme_1" class="h-menu-item">
                    <div class="h-menu-item-cont">
                        <div class="h-menu-logo-block">
                            <div class="h-menu-logo">
                                <a href="<?=UA ? '/' : '/ru/'?>">
                                    <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1164.53 223" style="enable-background:new 0 0 1164.53 223;" xml:space="preserve">
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
												c3.16,2.8,5.69,6.07,7.52,9.73C166.28,124.15,167.24,128.48,167.24,133.23z"/>
                                        </g>
                                        <g>
                                            <polygon points="341.18,53.4 341.18,86.9 296.34,86.9 296.34,169.45 257.3,169.45 257.3,86.9 212.54,86.9 212.54,53.4 		"/>
                                        </g>
                                        <g>
                                            <rect x="394.04" y="53.4" width="39.03" height="116.05"/>
                                        </g>
                                        <g>
                                            <polygon points="672.09,53.4 672.09,169.45 633.21,169.45 633.21,111.34 602.5,169.45 568.81,169.45 538.1,111.34 538.1,169.45
												499.07,169.45 499.07,53.4 546.21,53.4 585.66,127.33 625.11,53.4 		"/>
                                        </g>
                                        <g>
                                            <polygon points="911.15,53.4 911.15,169.45 872.28,169.45 872.28,111.34 841.57,169.45 807.88,169.45 777.17,111.34
												777.17,169.45 738.14,169.45 738.14,53.4 785.27,53.4 824.72,127.33 864.17,53.4 		"/>
                                        </g>
                                        <g>
                                            <path d="M1058.76,53.4h-38.17l-60.73,116.05h43.77l9.9-19.97h52.28l9.91,19.97h43.76L1058.76,53.4z M1050.54,118.36h-21.55
												l10.82-21.72L1050.54,118.36z"/>
                                        </g>
                                    </g>
								</svg>
                                </a>
                            </div>
                        </div>
                        <div class="h-menu-bg">
						<span class="h-menu-bg-block">
                            <?
                            if($type == 'Desktop')
                            {
                                ?><img src="/bitrix/templates/stimma/images/3414_2.jpg?v=11"><?
                            } else {
								?><img src="/bitrix/templates/stimma/images/3414_2_mob.jpg?v=11"><?
								
							}
                            ?>
						</span>
                        </div>
                        <?
                        global $USER;

                        //if($USER -> IsAdmin() || true)
                        {
                            $res = CIBlockSection::GetList(['DEPTH_LEVEL' => 'asc','sort'=>'asc'], ['IBLOCK_ID' => 43,'ACTIVE'=>'Y'],false,['UF_*']);
                            $sections = [];
                            $int = 0;
                            while ($section = $res->Fetch())
                            {
                                //if ($section['ID'] == 1311) continue;
                                if(!$section['IBLOCK_SECTION_ID'])
                                    $sections[$section['ID']] = $section;
                                else
                                    $sections[$section['IBLOCK_SECTION_ID']]['child'][] = $section;
                                $int++;
                            }
                            $count = round(count($sections)/2);
                            ?>
                            <div class="h-menu-list-cont">
                                <div class="h-menu-list-block double">
                                    <ul class="h-menu-list">
                                        <?
										
										//unset($sections[se]);
										
										if ( isset($_GET['svtmp2']) ) {
											echo "<pre>";print_R($sections);echo"</pre>";exit();
										}										
										
                                        $n=0;
                                        foreach($sections as $link => $name)
                                        {
											
											if ( trim($name['UF_NAME_UA']) == '' ) continue;	
											
											if( (!$USER -> IsAdmin() && $name['UF_LINK'] == '/catalog/bonusna_shafa')){
												//continue;
											}
                                            // $name['UF_LINK'] /catalog/tovary_za_bonusy
                                        ?>
                                        <li class="h-menu-list-item">
                                            <div class="h-menu-list-item-dropdown">
                                                <a href="<?=UA ? '' : '/ru'?><?=$name['UF_LINK']?>" style="<?=$name['UF_LINK'] == '/catalog/rasprodazha/' ? 'color:#ec5353;font-weight:700;' : ''?>">
                                                    <?=LANGUAGE_ID == 'ua' ? $name['UF_NAME_UA'] : $name['NAME']?>
                                                </a>

                                                <?
                                                if(isset($name['child']) && !empty($name['ID']))
                                                {
                                                    ?>
                                                    <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                                                </span>
                                                    <ul class="h-menu-list-semi svtmpchild123">
                                                    <?
                                                    foreach($name['child'] as $index => $item)
                                                    {
                                                        if($item['UF_NAME_UA'] == 'Жилет') continue;
                                                        ?>
                                                        <li class="h-menu-list-item svchild111">
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
                                        $n++;
                                        if($count == $n)
                                        {
                                        ?></ul><ul class="h-menu-list"><?
                                        }
                                        }
                                        ?>
<? 
global $USER;
/*
?>
<a href="/catalog/bonus/" class="h-menu-list-link">Бонусна шафа</a>
                                        */?>

                                    </ul>
                                    <a href="<?=UA ? '' : '/ru'?>/catalog/zhenskaya_odezhda/" class="h-menu-list-link">
                                        <?=UA ? 'Всі товари' : "Вся одежда"?>
                                    </a>
                                </div>
                            </div>
                            <?
                        }
                        ?>

                    </div>
                </div>
                <div data-for="hoverme_2" class="h-menu-item">
                    <div class="h-menu-item-cont">
                        <div class="h-menu-logo-block">
                            <div class="h-menu-logo">
                                <a href="<?=UA ? '/' : '/ru/'?>">
                                    <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1164.53 223" style="enable-background:new 0 0 1164.53 223;" xml:space="preserve">
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
												c3.16,2.8,5.69,6.07,7.52,9.73C166.28,124.15,167.24,128.48,167.24,133.23z"/>
                                        </g>
                                        <g>
                                            <polygon points="341.18,53.4 341.18,86.9 296.34,86.9 296.34,169.45 257.3,169.45 257.3,86.9 212.54,86.9 212.54,53.4 		"/>
                                        </g>
                                        <g>
                                            <rect x="394.04" y="53.4" width="39.03" height="116.05"/>
                                        </g>
                                        <g>
                                            <polygon points="672.09,53.4 672.09,169.45 633.21,169.45 633.21,111.34 602.5,169.45 568.81,169.45 538.1,111.34 538.1,169.45
												499.07,169.45 499.07,53.4 546.21,53.4 585.66,127.33 625.11,53.4 		"/>
                                        </g>
                                        <g>
                                            <polygon points="911.15,53.4 911.15,169.45 872.28,169.45 872.28,111.34 841.57,169.45 807.88,169.45 777.17,111.34
												777.17,169.45 738.14,169.45 738.14,53.4 785.27,53.4 824.72,127.33 864.17,53.4 		"/>
                                        </g>
                                        <g>
                                            <path d="M1058.76,53.4h-38.17l-60.73,116.05h43.77l9.9-19.97h52.28l9.91,19.97h43.76L1058.76,53.4z M1050.54,118.36h-21.55
												l10.82-21.72L1050.54,118.36z"/>
                                        </g>
                                    </g>
								</svg>
                                </a>
                            </div>
                        </div>
                        <div class="h-menu-bg">
						<span class="h-menu-bg-block">
							<?/*<img src="https://magda-butrym.imgix.net/https%3A%2F%2Fimages.prismic.io%2Fmagdabutrym%2F9ee41511-6af6-437e-b975-d06d20a54d11_Nav%2Bbg%2B3.jpg%3Fauto%3Dcompress%2Cformat?ixlib=js-2.3.2&amp;w=2560&amp;h=undefined&amp;fit=crop&amp;auto=format&amp;q=75&amp;s=cf78c9a6cba7a73de72e999dd89e6470">*/?>
                            <?
                            if($type == 'Desktop')
                            {
                                ?><img src="/bitrix/templates/stimma/images/3414_2.jpg?v=11"><?
                            } else {
								?><img src="/bitrix/templates/stimma/images/3414_2_mob.jpg?v=11"><?
								
							}
                            ?>

						</span>
                        </div>
                        <div class="h-menu-list-cont">
                            <div class="h-menu-list-block">
                                <div class="h-menu-list-title"><?=UA?'Користувачам':'Пользователям'?></div>
                                <ul class="h-menu-list">
                                    <li class="h-menu-list-item">
                                        Email
                                        <br>
                                        <a href="mailto:stimmacomua@gmail.com">stimmacomua@gmail.com</a>
                                        <br>
                                        <?=UA ? 'Гаряча лінія' : 'Горячая линия'?>
                                        <br>
                                        <a href="tel:0800300068">0800300068</a>
                                    </li>
                                    <li class="h-menu-list-item">
                                        <p>

                                            <?=UA?'Графік роботи інтернет-магазину:':'График работы интернет-магазина:'?>
                                            <br>
                                            <?=UA ? 'Понеділок - П\'ятниця: 9.00 - 18.00' : 'Понедельник-Пятница: 9.00 - 18.00'?>
                                            <br>
                                            <?=UA ? 'субота - Неділя: 10:00 - 18:00' : 'Суббота - Воскресенье: 10:00 - 18:00'?>
                                            <br>

                                        </p>
                                    </li>
                                    <li class="h-menu-list-item">
                                        <a href="<?=UA ? '' : '/ru'?>/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/"><?=UA?'Співпраця':'Сотрудничество'?></a>
                                    </li>
                                    <li class="h-menu-list-item">
                                        <a href="<?=UA ? '' : '/ru'?>/vacancies/"><?=UA?'Вакансії':'Вакансии'?></a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?
        }
        ?>

	</div>
</div>


<?
if(!$bIndex)
{
    ?>
    <div class="basket-items-alert" style="display:none;">
        <!-- active -->
        <div class="basket-item-alert active">
            <div class="basket-alert-block">
                <div class="basket-alert-img">
                    <img class="popup_basket_image" src="/bitrix/templates/stimma/images/balert-img.avif">
                </div>
                <div class="basket-alert-info-block">
                    <div class="basket-alert-info">
                        <div class="basket-alert-text">
                            <div class="basket-alert-text-top">
                                <?=UA ? 'Додано в кошик' : 'Добавлено в корзину'?>
                            </div>
                            <div class="basket-alert-name popup_basket_name">
                                Cable knit corset in cream
                            </div>
                        </div>
                        <div class="basket-alert-btn-block">
                            <a href="" class="basket-alert-btn">
                                <?=UA?'Переглянути кошик':'Показать корзину'?>
                            </a>
                        </div>
                    </div>
                    <div class="basket-alert-close-block">
                        <div class="basket-alert-close">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="c-biXJmc c-biXJmc-dRToyv-size-small"><g><rect width="24" height="24" fill="none"></rect><polygon points="20.8 3.9 20.1 3.2 12 11.3 3.9 3.2 3.2 3.9 11.3 12 3.2 20.1 3.9 20.8 12 12.7 20.1 20.8 20.8 20.1 12.7 12 20.8 3.9"></polygon></g></svg>
                        </div>
                    </div>
                </div>
                <div class="basket-alert-btn-mob-block">
                    <a href="" class="basket-alert-btn-mob">
                        <?=UA?'Переглянути кошик':'Показать корзину'?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?
}
?>
<!-- opened -->
