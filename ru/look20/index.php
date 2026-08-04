<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Look25");
$APPLICATION->SetPageProperty("title", "Look25 | Харьков, Киев, Днепр, Одесса, Львов");

?>

<div class="action-main-banner">
	<div class="action-main-img">
		<img src="/bitrix/templates/stimma/images/action-main-banner.png">
	</div>
	<div class="action-main-text-img">
		<img src="/bitrix/templates/stimma/images/action-main-text-ru.png">
	</div>
</div>

<div class="action-work-cont">
	<div class="action-work-title action-title">
		Как это работает
	</div>
	<div class="action-work-group">
		<div class="action-work-item action-work-item1">
			<div class="action-work-text-block">
				<div class="action-work-item-title-block">
					<span class="action-work-item-counter">
						1
					</span>
					Выбери три вещи или больше
				</div>
				<div class="action-work-item-text">
                    Это должны быть самые разные предметы одежды с разных категорий
				</div>
			</div>
			<div class="action-work-img-cont">
				<div class="action-work-img-block">
					<div class="action-work-img">
						<img src="/bitrix/templates/stimma/images/action-top.png">
					</div>
					<div class="action-work-img-text">
						Верх
					</div>
				</div>
				<div class="action-work-img-plus">
					<svg width="108" height="108" viewBox="0 0 108 108" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M54.1729 3.8374V104.574M104.541 54.2056L3.80469 54.2056" stroke="#FF9A02" stroke-width="6" stroke-linecap="round"/>
					</svg>
				</div>
				<div class="action-work-img-block">
					<div class="action-work-img">
						<img src="/bitrix/templates/stimma/images/action-bottom.png">
					</div>
					<div class="action-work-img-text">
						низ
					</div>
				</div>
			</div>
		</div>
		<div class="action-work-item action-work-item2">
			<div class="action-work-text-block">
				<div class="action-work-item-title-block">
					<span class="action-work-item-counter">
						2
					</span>
					Получи скидку на весь лук
				</div>
				<div class="action-work-item-text">
                    Скидка распространяется на все товары в корзине кроме аксессуаров и акционных позиций
				</div>
			</div>
			<div class="action-work-img-cont">
				<div class="action-work-img-block">
					<div class="action-work-img">
						<img src="/bitrix/templates/stimma/images/action-disc.png">
					</div>
				</div>
			</div>
		</div>
		<div class="action-work-item action-work-item3">
			<div class="action-work-text-block">
				<div class="action-work-item-title-block">
					<span class="action-work-item-counter">
						3
					</span>
					Получи еще большую скидку, -25%, если имеешь специальный промокод!				
				</div>
				<div class="action-work-item-text">
					Воспользуйся промокодом в корзине. Отслеживай промокод в соцсетях!
				</div>
			</div>
			<div class="action-work-img-cont">
				<div class="action-work-img-plus">
					<svg width="90" height="90" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M44.6035 3.58325V86.72M86.1719 45.1516L3.03516 45.1516" stroke="#FF9A02" stroke-width="6" stroke-linecap="round"/>
					</svg>
				</div>
				<div class="action-work-img-block">
					<div class="action-work-img">
						<img src="/bitrix/templates/stimma/images/action-disc1.png">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="action-items-cont">
	<div class="action-items-title action-title">
        Выбери свой лук с новых коллекций!
	</div>
	<div class="action-items-list">
		<div class="action-item-block action-item-block-full">
			<a href="/catalog/novinki/">
				<img src="/bitrix/templates/stimma/images/action-itm1.png">
			</a>
			<div class="action-item-btn">
				<a href="/catalog/novinki/" class="action-btn">
					посмотреть
				</a>
			</div>
		</div>
		<div class="action-item-block">
			<a href="/catalog/zhenskaya_odezhda/platya_sarafany_i_yubki/">
				<img src="/bitrix/templates/stimma/images/action-itm2-ru.png">
			</a>
		</div>
		<div class="action-item-block">
			<a href="/catalog/zhenskaya_odezhda/kostyumy_i_zhakety/">
				<img src="/bitrix/templates/stimma/images/action-itm3-ru.png">
			</a>
		</div>
		<div class="action-item-block">
			<a href="/catalog/novinki/">
				<img src="/bitrix/templates/stimma/images/action-itm4.png">
			</a>
		</div>
		<div class="action-item-block">
			<a href="/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/">
				<img src="/bitrix/templates/stimma/images/action-itm5-ru.png">
			</a>
		</div>
	</div>
</div>

<?/*<div class="action-form-cont">
    <form>
        <div class="action-form-block">
            <div class="action-form-title">
                -10% скидки на первую покупку** за подписку на рассылку
            </div>
            <div class="action-form-text">
                <p>
                    Присоединяйся, что бы как можно быстрее узнавать о новых вещах и акциях
                </p>
                <p class="light">
                    ** Скидка единоразовая и действует лишь на новинки (товары с черными ценниками). Промокод не обьединяется с другими акциями и может не распространяться на некоторые товары. Детали по ссылке:
                </p>
            </div>
            <div class="action-form-email">
                <input type="text" name="subscribe_email" placeholder="Ваш E-mail">
                <button class="subscribe_me">Я с вами</button>
            </div>
        </div>
    </form>
	<div class="action-form-block">
		<div class="action-form-title">
			САМА СЕБЕ STIMMA
		</div>
		<div class="action-form-text">
			<p>
                Регистрируйся, что бы сэкономить и получить все плюсы
			</p>
		</div>
		<div class="action-form-btn">
			<a href="https://www.stimma.com.ua/auth/registration/?register=yes&backurl=/">
				Хочу узнать
			</a>
		</div>
	</div>
</div>*/?>

<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");