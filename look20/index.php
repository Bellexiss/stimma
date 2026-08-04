<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

	
LocalRedirect("/catalog/rasprodazha/", true, "301 Moved Permanently");

$APPLICATION->SetPageProperty("description", "Look25");

if ( LANGUAGE_ID == 'ua' ) {
	$APPLICATION->SetPageProperty("title", "Look25 | Харків, Київ, Дніпро, Одеса, Львів");
} else {
	$APPLICATION->SetPageProperty("title", "Look25 | Харьков, Киев, Днепр, Одесса, Львов");
}
										
?>

<div class="action-main-banner">
	<div class="action-main-img">
		<img src="/bitrix/templates/stimma/images/action-main-banner.png">
	</div>
	<div class="action-main-text-img">
		<img src="/bitrix/templates/stimma/images/action-main-text.png">
	</div>
</div>

<div class="action-work-cont">
	<div class="action-work-title action-title">
		Як це працює
	</div>
	<div class="action-work-group">
		<div class="action-work-item action-work-item1">
			<div class="action-work-text-block">
				<div class="action-work-item-title-block">
					<span class="action-work-item-counter">
						1
					</span>
					Обери три речі або більше
				</div>
				<div class="action-work-item-text">
					Це мають бути саме різні предмети одягу з різних категорій
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
					Отримай знижку на весь лук
				</div>
				<div class="action-work-item-text">
					Знижка розповсюджується на всі товари в кошику окрім аксесуарів, та акційних позицій 
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
					Отримай ще більшу знижку, аж -25%, якщо маєш спеціальний промокод!
				</div>
				<div class="action-work-item-text">
					Скристайся промокодом "Look25" в кошику
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
		Обери свій лук з наших нових колекцій!
	</div>
	<div class="action-items-list">
		<div class="action-item-block action-item-block-full">
			<a href="/catalog/novinki/">
				<img src="/bitrix/templates/stimma/images/action-itm1.png">
			</a>
			<div class="action-item-btn">
				<a href="/catalog/novinki/" class="action-btn">
					переглянути
				</a>
			</div>
		</div>
		<div class="action-item-block">
			<a href="/catalog/zhenskaya_odezhda/platya_sarafany_i_yubki/">
				<img src="/bitrix/templates/stimma/images/action-itm2.png">
			</a>
		</div>
		<div class="action-item-block">
			<a href="/catalog/zhenskaya_odezhda/kostyumy_i_zhakety/">
				<img src="/bitrix/templates/stimma/images/action-itm3.png">
			</a>
		</div>
		<div class="action-item-block">
			<a href="/catalog/novinki/">
				<img src="/bitrix/templates/stimma/images/action-itm4.png">
			</a>
		</div>
		<div class="action-item-block">
			<a href="/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/">
				<img src="/bitrix/templates/stimma/images/action-itm5.png">
			</a>
		</div>
	</div>
</div>

<?/*<div class="action-form-cont">
    <form>
        <div class="action-form-block">
            <div class="action-form-title">
                -10% знижки на першу купівлю** за підписку на розсилку
            </div>
            <div class="action-form-text">
                <p>
                    Долучайся, щоб якнайшвидше дізнаватися про нові речі та акції
                </p>
                <p class="light">
                    ** Знижка є одноразовою та діє лише на новинки (товари з чорними цінниками). Промокод не поєднується з іншими акціями та може не розповсюджуватися на деякі товари. Деталі за посиланням:
                </p>
            </div>
            <div class="action-form-email">
                <input type="text" name="subscribe_email" placeholder="Ваш E-mail">
                <button class="subscribe_me">Я з вами</button>
            </div>
        </div>
    </form>
	<div class="action-form-block">
		<div class="action-form-title">
			САМА СОБІ STIMMA
		</div>
		<div class="action-form-text">
			<p>
				Реєструйся, щоб заощаджувати й отримувати усі плюси
			</p>
		</div>
		<div class="action-form-btn">
			<a href="https://www.stimma.com.ua/auth/registration/?register=yes&backurl=/">
				Хочу дізнатися
			</a>
		</div>
	</div>
</div>*/?>

<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");