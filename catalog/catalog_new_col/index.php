<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Придбати Розпродаж. ⭐ Ціна від 199 грн. ⚡ Швидка доставка по Україні ⭐ ТМ «Стимма» – модний жіночий одяг.");
$APPLICATION->SetPageProperty("title", "Розпродаж від 199 грн. Купити Розпродаж від ТМ «Стимма» | Харків, Київ, Дніпро, Одеса, Львів");
	
	if(isset($_GET['newstimma']) )
    {?>


        <!-- // Каталог -->

    	<div class="offcanvas offcanvas-end filter-canvas" tabindex="-1" id="filter-canvas">
            <div class="offcanvas-header">
                <div class="filter-title-block">
                    <div class="filter-title">
                        Фільтр та сортування
                    </div>
                    <div class="filter-count">
                        12 товарів
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.4365 12.0225L25.4561 0.00292969L26.8701 1.41699L14.8506 13.4365L26.8701 25.4561L25.4561 26.8701L13.4365 14.8506L1.41406 26.873L0 25.459L12.0225 13.4365L0 1.41406L1.41406 0L13.4365 12.0225Z" fill="currentcolor"/>
                    </svg>
                </button>
            </div>
            <div class="offcanvas-body">
                <div class="accordion" id="filter-list">
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block1" aria-expanded="true" >
                                Колір
                            </button>
                        </div>
                        <div id="filter-block1" class="accordion-collapse collapse show" >
                            <div class="accordion-body">
                                <div class="filter-element-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            Червоний
                                        </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            Червоний
                                        </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            Червоний
                                        </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            Червоний
                                        </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            Червоний
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block2" aria-expanded="false" >
                                Розмір
                            </button>
                        </div>
                        <div id="filter-block2" class="accordion-collapse collapse" >
                            <div class="accordion-body">
                                <div class="filter-element-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            XS
                                        </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            S
                                        </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            M
                                        </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            L
                                        </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            XL
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block3" aria-expanded="false" >
                                Ціна
                            </button>
                        </div>
                        <div id="filter-block3" class="accordion-collapse collapse" >
                            <div class="accordion-body">
                                
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block4" aria-expanded="false" >
                                Вид виробу
                            </button>
                        </div>
                        <div id="filter-block4" class="accordion-collapse collapse" >
                            <div class="accordion-body">
                                <div class="filter-element-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            Шкіра
                                        </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            Бавовна
                                        </span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="">
                                        <span class="checkbox">
                                            
                                        </span>
                                        <span class="text">
                                            Трикотаж
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-block5" aria-expanded="false" >
                                Сортувати за
                            </button>
                        </div>
                        <div id="filter-block5" class="accordion-collapse collapse" >
                            <div class="accordion-body">
                                <div class="filter-element-group">
                                    <label class="radiobox-label">
                                        <input type="radio" name="radio-filter">
                                        <span class="radiobox">
                                            
                                        </span>
                                        <span class="text">
                                            Рекомендовані
                                        </span>
                                    </label>
                                    <label class="radiobox-label">
                                        <input type="radio" name="radio-filter">
                                        <span class="radiobox">
                                            
                                        </span>
                                        <span class="text">
                                            З меншої до більшої ціни
                                        </span>
                                    </label>
                                    <label class="radiobox-label">
                                        <input type="radio" name="radio-filter">
                                        <span class="radiobox">
                                            
                                        </span>
                                        <span class="text">
                                            З більшої до меншої ціни
                                        </span>
                                    </label>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-footer">
                <a href="#" class="info-btn info-btn-black">
                    Показати товари
                </a>
                <a href="#" class="info-btn ">
                    видалити фільтри
                </a>
            </div>
        </div>

    	<div class="catalog-menu-cont">
    		<div class="wrapper">
                <div class="catalog-menu-block">
        			<div class="catalog-menu">
        				<a href="#" class="catalog-menu-item">
        					Всі товари
        				</a>
        				<a href="#" class="catalog-menu-item active">
        					NEW
        				</a>
        				<a href="#" class="catalog-menu-item ">
        					SMART CASUAL
        				</a>
        				<a href="#" class="catalog-menu-item">
        					CASUAL
        				</a>
        				<a href="#" class="catalog-menu-item">
        					MATCH
        				</a>
        				<a href="#" class="catalog-menu-item">
        					LIMITED
        				</a>
        				<a href="#" class="catalog-menu-item">
        					BESTSELLERS
        				</a>
        				<a href="#" class="catalog-menu-item">
        					SALE
        				</a>
                        <a href="#" class="catalog-menu-item">
                            Товари за стімзи
                        </a>
        			</div>
                </div>
    		</div>
    	</div>

        <div class="wrapper">
        	<div class="catalog-page">
        		<div class="catalog-control-block">
        			<div class="catalog-filter-info">
        				<button class="catalog-filter" type="button" data-bs-toggle="offcanvas" data-bs-target="#filter-canvas">
        					<span class="icon">
        						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    								<path fill-rule="evenodd" clip-rule="evenodd" d="M13.125 3.75781C11.6205 3.75781 10.3553 4.83619 10.0635 6.25781H1.875C1.52983 6.25781 1.25 6.53764 1.25 6.88281C1.25 7.22799 1.52983 7.50781 1.875 7.50781H10.0635C10.3553 8.92943 11.6205 10.0078 13.125 10.0078C14.6295 10.0078 15.8947 8.92943 16.1865 7.50781H18.125C18.4702 7.50781 18.75 7.22799 18.75 6.88281C18.75 6.53764 18.4702 6.25781 18.125 6.25781H16.1865C15.8947 4.83619 14.6295 3.75781 13.125 3.75781ZM13.125 5.00781C14.1679 5.00781 15 5.83989 15 6.88281C15 7.92573 14.1679 8.75781 13.125 8.75781C12.0821 8.75781 11.25 7.92573 11.25 6.88281C11.25 5.83989 12.0821 5.00781 13.125 5.00781Z" fill="currentcolor"/>
    								<path fill-rule="evenodd" clip-rule="evenodd" d="M6.875 10.0078C5.37051 10.0078 4.10528 11.0862 3.81348 12.5078H1.875C1.52983 12.5078 1.25 12.7876 1.25 13.1328C1.25 13.478 1.52983 13.7578 1.875 13.7578H3.81348C4.10528 15.1794 5.37051 16.2578 6.875 16.2578C8.37949 16.2578 9.64472 15.1794 9.93652 13.7578H18.125C18.4702 13.7578 18.75 13.478 18.75 13.1328C18.75 12.7876 18.4702 12.5078 18.125 12.5078H9.93652C9.64472 11.0862 8.37949 10.0078 6.875 10.0078ZM6.875 11.2578C7.91792 11.2578 8.75 12.0899 8.75 13.1328C8.75 14.1757 7.91792 15.0078 6.875 15.0078C5.83208 15.0078 5 14.1757 5 13.1328C5 12.0899 5.83208 11.2578 6.875 11.2578Z" fill="currentcolor"/>
    							</svg>
        					</span>
        					Фільтр (2)
        				</button>
        				<div class="catalog-filter-viewed">
        					30 товарів
        				</div>
        			</div>
        		</div>
        		<div class="catalog-grid catalog-grid-new">
                    <div class="catalog-grid-item">
                        <div class="catalog-item">
                            <div class="catalog-item-top">
                                <div class="catalog-item-img">
                                    <a href="#">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/catimg2.png">
                                    </a>
                                </div>
                                <div class="catalog-item-favorite">
                                    <a href="#">
                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="catalog-item-more-info">
                                    <div class="catalog-item-btn-buy">
                                        <a href="#">
                                            Додати до кошика
                                        </a>
                                    </div>
                                    <div class="catalog-item-size-list">
                                        <label>
                                            <input type="radio" name="radio2">
                                            <span class="catalog-item-size">
                                                XS
                                            </span>
                                        </label>
                                        <label>
                                            <input type="radio" name="radio2">
                                            <span class="catalog-item-size">
                                                S
                                            </span>
                                        </label>
                                        <label>
                                            <input type="radio" name="radio2">
                                            <span class="catalog-item-size">
                                                M
                                            </span>
                                        </label>
                                        <label>
                                            <input type="radio" name="radio2">
                                            <span class="catalog-item-size">
                                                XS
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-item-info">
                                <a href="#" class="catalog-item-name">
                                    Жіноча куртка Stimma Анір
                                </a>
                                <div class="catalog-item-details">
                                    <div class="catalog-item-price-block">
                                        <div class="catalog-item-price">
                                            3 699 ₴
                                        </div>
                                    </div>
                                    <div class="catalog-item-color-block">
                                        <a href="#" style="background:#CB594F ;">
                                        </a>
                                        <a href="#" style="background:#8B5231 ;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-grid-item">
                        <div class="catalog-item">
                            <div class="catalog-item-top">
                                <div class="catalog-item-img">
                                    <a href="#">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/catimg3.png">
                                    </a>
                                </div>
                                <div class="catalog-item-favorite">
                                    <a href="#">
                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="catalog-item-more-info">
                                    <div class="catalog-item-btn-buy">
                                        <a href="#">
                                            Додати до кошика
                                        </a>
                                    </div>
                                    <div class="catalog-item-size-list">
                                        <label>
                                            <input type="radio" name="radio3">
                                            <span class="catalog-item-size">
                                                XS
                                            </span>
                                        </label>
                                        <label>
                                            <input type="radio" name="radio3">
                                            <span class="catalog-item-size">
                                                S
                                            </span>
                                        </label>
                                        <label>
                                            <input type="radio" name="radio3">
                                            <span class="catalog-item-size">
                                                M
                                            </span>
                                        </label>
                                        <label>
                                            <input type="radio" name="radio3">
                                            <span class="catalog-item-size">
                                                XS
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-item-info">
                                <a href="#" class="catalog-item-name">
                                    Жіноча сукня Stimma Памо коричневий
                                </a>
                                <div class="catalog-item-details">
                                    <div class="catalog-item-price-block">
                                        <div class="catalog-item-price">
                                            1 999 ₴
                                        </div>
                                    </div>
                                    <div class="catalog-item-color-block">
                                        <a href="#" style="background:#CB594F ;">
                                        </a>
                                        <a href="#" style="background:#8B5231 ;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-new-banner">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/new-colection1.png">
                    </div>
                    <div class="catalog-grid-item">
                        <div class="catalog-item">
                            <div class="catalog-item-top">
                                <div class="catalog-item-img">
                                    <a href="#">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/catimg4.png">
                                    </a>
                                </div>
                                <div class="catalog-item-favorite">
                                    <a href="#">
                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="catalog-item-more-info">
                                    <div class="catalog-item-btn-buy">
                                        <a href="#">
                                            Додати до кошика
                                        </a>
                                    </div>
                                    <div class="catalog-item-size-list">
                                        <label>
                                            <input type="radio" name="radio4">
                                            <span class="catalog-item-size">
                                                XS
                                            </span>
                                        </label>
                                        <label>
                                            <input type="radio" name="radio4">
                                            <span class="catalog-item-size">
                                                S
                                            </span>
                                        </label>
                                        <label>
                                            <input type="radio" name="radio4">
                                            <span class="catalog-item-size">
                                                M
                                            </span>
                                        </label>
                                        <label>
                                            <input type="radio" name="radio4">
                                            <span class="catalog-item-size">
                                                XS
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-item-info">
                                <a href="#" class="catalog-item-name">
                                    Жіночий блейзер Stimma Альріл коричневий
                                </a>
                                <div class="catalog-item-details">
                                    <div class="catalog-item-price-block">
                                        <div class="catalog-item-price">
                                            2 999 ₴
                                        </div>
                                    </div>
                                    <div class="catalog-item-color-block">
                                        <a href="#" style="background:#CB594F ;">
                                        </a>
                                        <a href="#" style="background:#8B5231 ;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-grid-item">
    	                <div class="catalog-item">
    	                    <div class="catalog-item-top">
    	                        <div class="catalog-item-img">
    	                            <a href="#">
    	                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg1.png">
    	                            </a>
    	                        </div>
    	                        <div class="catalog-item-favorite">
    	                            <a href="#">
    	                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
    	                                    <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
    	                                </svg>
    	                            </a>
    	                        </div>
    	                        <div class="catalog-item-more-info">
    	                            <div class="catalog-item-btn-buy">
    	                                <a href="#">
    	                                    Додати до кошика
    	                                </a>
    	                            </div>
    	                            <div class="catalog-item-size-list">
    	                                <label>
    	                                    <input type="radio" name="radio5">
    	                                    <span class="catalog-item-size">
    	                                        XS
    	                                    </span>
    	                                </label>
    	                                <label>
    	                                    <input type="radio" name="radio5">
    	                                    <span class="catalog-item-size">
    	                                        S
    	                                    </span>
    	                                </label>
    	                                <label>
    	                                    <input type="radio" name="radio5">
    	                                    <span class="catalog-item-size">
    	                                        M
    	                                    </span>
    	                                </label>
    	                                <label>
    	                                    <input type="radio" name="radio5">
    	                                    <span class="catalog-item-size">
    	                                        XS
    	                                    </span>
    	                                </label>
    	                            </div>
    	                        </div>
    	                    </div>
    	                    <div class="catalog-item-info">
    	                        <a href="#" class="catalog-item-name">
    	                            Жіночий лонгслів Stimma Саймін Теракотовий
    	                        </a>
    	                        <div class="catalog-item-details">
    	                            <div class="catalog-item-price-block">
    	                                <div class="catalog-item-price">
    	                                    799 ₴
    	                                </div>
    	                            </div>
    	                            <div class="catalog-item-color-block">
    	                                <a href="#" style="background:#CB594F ;">
    	                                </a>
    	                                <a href="#" style="background:#8B5231 ;">
    	                                </a>
    	                            </div>
    	                        </div>
    	                    </div>
    	                </div>
    	            </div>
                    <div class="catalog-new-banner">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/new-colection2.png">
                    </div>
        		</div>
        	</div>
        </div>

        


        

      
        

    <?}else{


		?>
			<link rel="stylesheet" href="/bitrix/templates/aspro_max/components/bitrix/breadcrumb/main/style.css" />
		<?
		$files = [];
		$perPage = 21;
		$isNew = $isSale = false;
		if($APPLICATION -> GetCurPage() == '/catalog/rasprodazha/' || $APPLICATION -> GetCurPage() == '/ru/catalog/rasprodazha/')
			$isSale = true;
		if($APPLICATION -> GetCurPage() == '/catalog/novinki/' || $APPLICATION -> GetCurPage() == '/ru/catalog/novinki/')
		{
		    $isNew = true;
		    $perPage = 100;

		    $res = CIBlockElement::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 39, 'ACTIVE' => 'Y','ACTIVE_DATE' => 'Y']);
		    while ($record = $res -> GetNextElement())
		    {
		        $fields = $record -> GetFields();
		        $props = $record -> GetProperties();

		        if($props['UF_PRODUCT_ID']['VALUE'])
		            $ids[$props['UF_PRODUCT_ID']['VALUE']] = $props['UF_PRODUCT_ID']['VALUE'];

		        $files[] = [
		            'UF_FILE' => $userPhoto = CFile::ResizeImageGet($props['UF_FILE']['VALUE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
		            'UF_SIZE' => $props['UF_SIZE']['VALUE_XML_ID'],
		            'UF_PRODUCT_ID' => $props['UF_PRODUCT_ID']['VALUE']
		        ];
		    }



		    if(!empty($ids))
		        $MAX_SMART_FILTER = ['ID' => $ids];

		    global $MAX_SMART_FILTER;
		}
		$isOutdoor=false;
		if($APPLICATION -> GetCurPage() == '/catalog/outdoor/' || $APPLICATION -> GetCurPage() == '/ru/catalog/outdoor/')
		{
		    $isOutdoor=true;

		    $res = CIBlockElement::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 46, 'ACTIVE' => 'Y','ACTIVE_DATE' => 'Y']);
		    while ($record = $res -> GetNextElement())
		    {
		        $fields = $record -> GetFields();
		        $props = $record -> GetProperties();

		        if($props['UF_PRODUCT_ID']['VALUE'])
		            $ids[$props['UF_PRODUCT_ID']['VALUE']] = $props['UF_PRODUCT_ID']['VALUE'];

		        $files[] = [
		            'UF_FILE' => $userPhoto = CFile::ResizeImageGet($props['UF_FILE']['VALUE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
		            'UF_SIZE' => $props['UF_SIZE']['VALUE_XML_ID'],
		            'UF_PRODUCT_ID' => $props['UF_PRODUCT_ID']['VALUE']
		        ];
		    }

		    if(!empty($ids))
		        $MAX_SMART_FILTER = ['ID' => $ids];

		    global $MAX_SMART_FILTER;
		}
		$isSmartOffice=false;
		if($APPLICATION -> GetCurPage() == '/catalog/smart_office/' || $APPLICATION -> GetCurPage() == '/ru/catalog/smart_office/')
		{
		    $isSmartOffice=true;

		    $res = CIBlockElement::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 50, 'ACTIVE' => 'Y','ACTIVE_DATE' => 'Y']);
		    while ($record = $res -> GetNextElement())
		    {
		        $fields = $record -> GetFields();
		        $props = $record -> GetProperties();

		        if($props['UF_PRODUCT_ID']['VALUE'])
		            $ids[$props['UF_PRODUCT_ID']['VALUE']] = $props['UF_PRODUCT_ID']['VALUE'];

		        $files[] = [
		            'UF_FILE' => $userPhoto = CFile::ResizeImageGet($props['UF_FILE']['VALUE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
		            'UF_SIZE' => $props['UF_SIZE']['VALUE_XML_ID'],
		            'UF_PRODUCT_ID' => $props['UF_PRODUCT_ID']['VALUE']
		        ];
		    }

		    if(!empty($ids))
		        $MAX_SMART_FILTER = ['ID' => $ids];

		    global $MAX_SMART_FILTER;
		}
		$isComfort=false;
		if($APPLICATION -> GetCurPage() == '/catalog/comfort/' || $APPLICATION -> GetCurPage() == '/ru/catalog/comfort/')
		{
		    $isComfort=true;

		    $res = CIBlockElement::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 51, 'ACTIVE' => 'Y','ACTIVE_DATE' => 'Y']);
		    while ($record = $res -> GetNextElement())
		    {
		        $fields = $record -> GetFields();
		        $props = $record -> GetProperties();

		        if($props['UF_PRODUCT_ID']['VALUE'])
		            $ids[$props['UF_PRODUCT_ID']['VALUE']] = $props['UF_PRODUCT_ID']['VALUE'];

		        $files[] = [
		            'UF_FILE' => $userPhoto = CFile::ResizeImageGet($props['UF_FILE']['VALUE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
		            'UF_SIZE' => $props['UF_SIZE']['VALUE_XML_ID'],
		            'UF_PRODUCT_ID' => $props['UF_PRODUCT_ID']['VALUE']
		        ];
		    }

		    if(!empty($ids))
		        $MAX_SMART_FILTER = ['ID' => $ids];

		    global $MAX_SMART_FILTER;
		}

		$isCruise=false;
		if($APPLICATION -> GetCurPage() == '/catalog/cruise/' || $APPLICATION -> GetCurPage() == '/ru/catalog/cruise/')
		{
		    $isCruise=true;

		    $res = CIBlockElement::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 49, 'ACTIVE' => 'Y','ACTIVE_DATE' => 'Y']);
		    while ($record = $res -> GetNextElement())
		    {
		        $fields = $record -> GetFields();
		        $props = $record -> GetProperties();

		        if($props['UF_PRODUCT_ID']['VALUE'])
		            $ids[$props['UF_PRODUCT_ID']['VALUE']] = $props['UF_PRODUCT_ID']['VALUE'];

		        $files[] = [
		            'UF_FILE' => $userPhoto = CFile::ResizeImageGet($props['UF_FILE']['VALUE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
		            'UF_SIZE' => $props['UF_SIZE']['VALUE_XML_ID'],
		            'UF_PRODUCT_ID' => $props['UF_PRODUCT_ID']['VALUE']
		        ];
		    }

		    if(!empty($ids))
		        $MAX_SMART_FILTER = ['ID' => $ids];

		    global $MAX_SMART_FILTER;
		}
		$isLimited=false;
		if($APPLICATION -> GetCurPage() == '/catalog/limited/' || $APPLICATION -> GetCurPage() == '/ru/catalog/limited/')
		{
		    $isLimited=true;

		    $res = CIBlockElement::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 48, 'ACTIVE' => 'Y','ACTIVE_DATE' => 'Y']);
		    while ($record = $res -> GetNextElement())
		    {
		        $fields = $record -> GetFields();
		        $props = $record -> GetProperties();

		        if($props['UF_PRODUCT_ID']['VALUE'])
		            $ids[$props['UF_PRODUCT_ID']['VALUE']] = $props['UF_PRODUCT_ID']['VALUE'];

		        $files[] = [
		            'UF_FILE' => $userPhoto = CFile::ResizeImageGet($props['UF_FILE']['VALUE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
		            'UF_SIZE' => $props['UF_SIZE']['VALUE_XML_ID'],
		            'UF_PRODUCT_ID' => $props['UF_PRODUCT_ID']['VALUE']
		        ];
		    }

		    if(!empty($ids))
		        $MAX_SMART_FILTER = ['ID' => $ids];

		    global $MAX_SMART_FILTER;
		}
		$isEvents=false;
		if($APPLICATION -> GetCurPage() == '/catalog/events/' || $APPLICATION -> GetCurPage() == '/ru/catalog/events/')
		{
		    $isEvents=true;

		    $res = CIBlockElement::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 47, 'ACTIVE' => 'Y','ACTIVE_DATE' => 'Y']);
		    while ($record = $res -> GetNextElement())
		    {
		        $fields = $record -> GetFields();
		        $props = $record -> GetProperties();

		        if($props['UF_PRODUCT_ID']['VALUE'])
		            $ids[$props['UF_PRODUCT_ID']['VALUE']] = $props['UF_PRODUCT_ID']['VALUE'];

		        $files[] = [
		            'UF_FILE' => $userPhoto = CFile::ResizeImageGet($props['UF_FILE']['VALUE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
		            'UF_SIZE' => $props['UF_SIZE']['VALUE_XML_ID'],
		            'UF_PRODUCT_ID' => $props['UF_PRODUCT_ID']['VALUE']
		        ];
		    }

		    if(!empty($ids))
		        $MAX_SMART_FILTER = ['ID' => $ids];

		    global $MAX_SMART_FILTER;
		}
		$isCasual=false;
		if($APPLICATION -> GetCurPage() == '/catalog/casual/' || $APPLICATION -> GetCurPage() == '/ru/catalog/casual/')
		{
		    $isCasual=true;

		    $res = CIBlockElement::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 52, 'ACTIVE' => 'Y','ACTIVE_DATE' => 'Y']);
		    while ($record = $res -> GetNextElement())
		    {
		        $fields = $record -> GetFields();
		        $props = $record -> GetProperties();

		        if($props['UF_PRODUCT_ID']['VALUE'])
		            $ids[$props['UF_PRODUCT_ID']['VALUE']] = $props['UF_PRODUCT_ID']['VALUE'];

		        $files[] = [
		            'UF_FILE' => $userPhoto = CFile::ResizeImageGet($props['UF_FILE']['VALUE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'],
		            'UF_SIZE' => $props['UF_SIZE']['VALUE_XML_ID'],
		            'UF_PRODUCT_ID' => $props['UF_PRODUCT_ID']['VALUE']
		        ];
		    }

		    if(!empty($ids))
		        $MAX_SMART_FILTER = ['ID' => $ids];

		    global $MAX_SMART_FILTER;
		}

		$bIndex = (strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false) || isset($_GET['google']);
		global $MAX_SMART_FILTER;

		//else
		{
			$APPLICATION->SetTitle("Каталог");
			$APPLICATION->IncludeComponent(
			"bitrix:catalog",
			".default",
			array(
				"GOOGLE" => $bIndex,
				"FILES" => $files,
				"IS_NEW" => $isNew,
				"IS_OUTDOOR" => $isOutdoor,
				"IS_LIMITED" => $isLimited,
				"IS_CRUISE" => $isCruise,
				"IS_SALE" => $isSale,
				"IS_EVENTS" => $isEvents,
				"IS_SMART_OFFICE" => $isSmartOffice,
				"IS_COMFORT" => $isComfort,
				"IS_CASUAL" => $isCasual,
				"IBLOCK_TYPE" => "aspro_max_catalog",
				"IBLOCK_ID" => "21",
				"HIDE_NOT_AVAILABLE" => "L",
				"BASKET_URL" => "/basket/",
				"ACTION_VARIABLE" => "action",
				"PRODUCT_ID_VARIABLE" => "id",
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"PRODUCT_QUANTITY_VARIABLE" => "quantity",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/catalog/",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "Y",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600000",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"SET_TITLE" => "Y",
				"SET_STATUS_404" => "N",
				"USE_ELEMENT_COUNTER" => "Y",
				"USE_FILTER" => "Y",
				"FILTER_NAME" => "MAX_SMART_FILTER",
				"FILTER_FIELD_CODE" => array(
					0 => "",
					1 => "",
				),
				"FILTER_PROPERTY_CODE" => array(
					0 => "",
					1 => "HIT",
					2 => "RAZMER",
					3 => "",
				),
				"FILTER_PRICE_CODE" => array(
					0 => "BASE",
				),
				"FILTER_OFFERS_FIELD_CODE" => array(
					0 => "NAME",
					1 => "",
				),
				"FILTER_OFFERS_PROPERTY_CODE" => array(
					0 => "",
					1 => "AGE",
					2 => "SELECTION",
					3 => "PRINT",
					4 => "RAZMER",
					5 => "ROST",
					6 => "SOSTAV",
					7 => "STYLES",
					8 => "COLOR_REF",
					9 => "",
				),
				"USE_REVIEW" => "Y",
				"MESSAGES_PER_PAGE" => "5",
				"USE_CAPTCHA" => "Y",
				"REVIEW_AJAX_POST" => "Y",
				"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
				"FORUM_ID" => "1",
				"URL_TEMPLATES_READ" => "",
				"SHOW_LINK_TO_FORUM" => "Y",
				"POST_FIRST_MESSAGE" => "N",
				"USE_COMPARE" => "Y",
				"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
				"COMPARE_FIELD_CODE" => array(
					0 => "NAME",
					1 => "TAGS",
					2 => "SORT",
					3 => "PREVIEW_PICTURE",
					4 => "",
				),
				"COMPARE_PROPERTY_CODE" => array(
					0 => "BRAND",
					1 => "CML2_ARTICLE",
					2 => "CML2_BASE_UNIT",
					3 => "PROP_2033",
					4 => "COLOR_REF2",
					5 => "PROP_159",
					6 => "PROP_2052",
					7 => "PROP_2053",
					8 => "PROP_2083",
					9 => "PROP_2065",
					10 => "PROP_2054",
					11 => "PROP_2017",
					12 => "PROP_2026",
					13 => "PROP_2027",
					14 => "PROP_2049",
					15 => "PROP_2044",
					16 => "PROP_162",
					17 => "CML2_MANUFACTURER",
					18 => "PROP_2055",
					19 => "PROP_2069",
					20 => "PROP_2062",
					21 => "PROP_2061",
					22 => "",
				),
				"COMPARE_OFFERS_FIELD_CODE" => array(
					0 => "NAME",
					1 => "PREVIEW_PICTURE",
					2 => "",
				),
				"COMPARE_OFFERS_PROPERTY_CODE" => array(
					0 => "ARTICLE",
					1 => "VOLUME",
					2 => "SIZES",
					3 => "COLOR_REF",
					4 => "",
				),
				"COMPARE_ELEMENT_SORT_FIELD" => "shows",
				"COMPARE_ELEMENT_SORT_ORDER" => "asc",
				"DISPLAY_ELEMENT_SELECT_BOX" => "N",
				"PRICE_CODE" => array(
					0 => "BASE",
					1 => "DISCOUNT",
					2 => "OPT",
					3 => "OPT_DISCOUNT",
				),
				"USE_PRICE_COUNT" => "N",
				"SHOW_PRICE_COUNT" => "1",
				"PRICE_VAT_INCLUDE" => "Y",
				"PRICE_VAT_SHOW_VALUE" => "N",
				"PRODUCT_PROPERTIES" => "",
				"USE_PRODUCT_QUANTITY" => "Y",
				"CONVERT_CURRENCY" => "Y",
				"CURRENCY_ID" => "UAH",
				"OFFERS_CART_PROPERTIES" => "",
				"SHOW_TOP_ELEMENTS" => "Y",
				"SECTION_COUNT_ELEMENTS" => "Y",
				"SECTION_TOP_DEPTH" => "2",
				"SECTIONS_LIST_PREVIEW_PROPERTY" => "UF_SECTION_DESCR",
				"SHOW_SECTION_LIST_PICTURES" => "Y",
				"PAGE_ELEMENT_COUNT" => $isNew || $isOutdoor || $isEvents || $isLimited || $isCruise || $isSmartOffice || $isComfort || $isCasual ? 150 : 20,
				"LINE_ELEMENT_COUNT" => "4",
				"ELEMENT_SORT_FIELD" => isset($_GET["by"])?$_GET["by"]:"PROPERTY_CATALOG_SORT",
				"ELEMENT_SORT_ORDER" => isset($_GET["sort"])?$_GET["sort"]:"ASC",
				"ELEMENT_SORT_FIELD2" => "ID",
				"ELEMENT_SORT_ORDER2" => "desc",
				"LIST_PROPERTY_CODE" => array(
					0 => "HIT",
					1 => "BRAND",
					2 => "CML2_ARTICLE",
					3 => "PROP_2104",
					4 => "PODBORKI",
					5 => "PROP_2033",
					6 => "COLOR_REF2",
					7 => "PROP_305",
					8 => "PROP_352",
					9 => "PROP_317",
					10 => "PROP_357",
					11 => "PROP_2102",
					12 => "PROP_318",
					13 => "PROP_159",
					14 => "PROP_349",
					15 => "PROP_327",
					16 => "PROP_2052",
					17 => "PROP_370",
					18 => "PROP_336",
					19 => "PROP_2115",
					20 => "PROP_346",
					21 => "PROP_2120",
					22 => "PROP_2053",
					23 => "PROP_363",
					24 => "PROP_320",
					25 => "PROP_2089",
					26 => "PROP_325",
					27 => "PROP_2103",
					28 => "PROP_2085",
					29 => "PROP_300",
					30 => "PROP_322",
					31 => "PROP_362",
					32 => "PROP_365",
					33 => "PROP_359",
					34 => "PROP_284",
					35 => "PROP_364",
					36 => "PROP_356",
					37 => "PROP_343",
					38 => "PROP_2083",
					39 => "PROP_314",
					40 => "PROP_348",
					41 => "PROP_316",
					42 => "PROP_350",
					43 => "PROP_333",
					44 => "PROP_332",
					45 => "PROP_360",
					46 => "PROP_353",
					47 => "PROP_347",
					48 => "PROP_25",
					49 => "PROP_2114",
					50 => "PROP_301",
					51 => "PROP_2101",
					52 => "PROP_2067",
					53 => "PROP_323",
					54 => "PROP_324",
					55 => "PROP_355",
					56 => "PROP_304",
					57 => "PROP_358",
					58 => "PROP_319",
					59 => "PROP_344",
					60 => "PROP_328",
					61 => "PROP_338",
					62 => "PROP_2065",
					63 => "PROP_366",
					64 => "PROP_302",
					65 => "PROP_303",
					66 => "PROP_2054",
					67 => "PROP_341",
					68 => "PROP_223",
					69 => "PROP_283",
					70 => "PROP_354",
					71 => "PROP_313",
					72 => "PROP_2066",
					73 => "PROP_329",
					74 => "PROP_342",
					75 => "PROP_367",
					76 => "PROP_2084",
					77 => "PROP_340",
					78 => "PROP_351",
					79 => "PROP_368",
					80 => "PROP_369",
					81 => "PROP_331",
					82 => "PROP_337",
					83 => "PROP_345",
					84 => "PROP_339",
					85 => "PROP_310",
					86 => "PROP_309",
					87 => "PROP_330",
					88 => "PROP_2017",
					89 => "PROP_335",
					90 => "PROP_321",
					91 => "PROP_308",
					92 => "PROP_206",
					93 => "PROP_334",
					94 => "PROP_2100",
					95 => "PROP_311",
					96 => "PROP_2132",
					97 => "SHUM",
					98 => "PROP_361",
					99 => "PROP_326",
					100 => "PROP_315",
					101 => "PROP_2091",
					102 => "PROP_2026",
					103 => "PROP_307",
					104 => "PROP_2027",
					105 => "PROP_2098",
					106 => "PROP_2122",
					107 => "PROP_24",
					108 => "PROP_2049",
					109 => "PROP_22",
					110 => "PROP_2095",
					111 => "PROP_2044",
					112 => "PROP_162",
					113 => "PROP_2055",
					114 => "PROP_2069",
					115 => "PROP_2062",
					116 => "PROP_2061",
					117 => "CML2_LINK",
					118 => "RZMER",
				),
				"INCLUDE_SUBSECTIONS" => "Y",
				"LIST_META_KEYWORDS" => "-",
				"LIST_META_DESCRIPTION" => "-",
				"LIST_BROWSER_TITLE" => "-",
				"LIST_OFFERS_FIELD_CODE" => array(
					0 => "NAME",
					1 => "CML2_LINK",
					2 => "DETAIL_PAGE_URL",
					3 => "",
				),
				"LIST_OFFERS_PROPERTY_CODE" => array(
					0 => "ARTICLE",
					1 => "SPORT",
					2 => "SIZES2",
					3 => "MORE_PHOTO",
					4 => "VOLUME",
					5 => "SIZES",
					6 => "SIZES5",
					7 => "SIZES4",
					8 => "SIZES3",
					9 => "COLOR_REF",
					10 => "RAZMER",
				),
				"LIST_OFFERS_LIMIT" => "10",
				"SORT_BUTTONS" => array(
					0 => "POPULARITY",
					1 => "NAME",
					2 => "PRICE",
				),
				"SORT_PRICES" => "REGION_PRICE",
				"DEFAULT_LIST_TEMPLATE" => "block",
				"SECTION_DISPLAY_PROPERTY" => "UF_SECTION_TEMPLATE",
				"LIST_DISPLAY_POPUP_IMAGE" => "Y",
				"SECTION_PREVIEW_PROPERTY" => "DESCRIPTION",
				"SHOW_SECTION_PICTURES" => "Y",
				"SHOW_SECTION_SIBLINGS" => "Y",
				"DETAIL_PROPERTY_CODE" => array(
					0 => "BRAND",
					1 => "LINK_SALE",
					2 => "EXPANDABLES",
					3 => "CML2_ARTICLE",
					4 => "LINK_VACANCY",
					5 => "VIDEO_YOUTUBE",
					6 => "POPUP_VIDEO",
					7 => "PROP_2104",
					8 => "LINK_NEWS",
					9 => "ASSOCIATED",
					10 => "HELP_TEXT",
					11 => "LINK_STAFF",
					12 => "LINK_BLOG",
					13 => "PROP_2033",
					14 => "SERVICES",
					15 => "CML2_ATTRIBUTES",
					16 => "COLOR_REF2",
					17 => "PROP_305",
					18 => "PROP_352",
					19 => "PROP_317",
					20 => "PROP_357",
					21 => "PROP_2102",
					22 => "PROP_318",
					23 => "PROP_159",
					24 => "PROP_349",
					25 => "PROP_327",
					26 => "PROP_2052",
					27 => "PROP_370",
					28 => "PROP_336",
					29 => "PROP_2115",
					30 => "PROP_346",
					31 => "PROP_2120",
					32 => "PROP_2053",
					33 => "PROP_363",
					34 => "PROP_320",
					35 => "PROP_2089",
					36 => "PROP_325",
					37 => "PROP_2103",
					38 => "PROP_2085",
					39 => "PROP_300",
					40 => "PROP_322",
					41 => "PROP_362",
					42 => "PROP_365",
					43 => "PROP_359",
					44 => "PROP_284",
					45 => "PROP_364",
					46 => "PROP_356",
					47 => "PROP_343",
					48 => "PROP_2083",
					49 => "PROP_314",
					50 => "PROP_348",
					51 => "PROP_316",
					52 => "PROP_350",
					53 => "PROP_333",
					54 => "PROP_332",
					55 => "PROP_360",
					56 => "PROP_353",
					57 => "PROP_347",
					58 => "PROP_25",
					59 => "PROP_2114",
					60 => "PROP_301",
					61 => "PROP_2101",
					62 => "PROP_2067",
					63 => "PROP_323",
					64 => "PROP_324",
					65 => "PROP_355",
					66 => "PROP_304",
					67 => "PROP_358",
					68 => "PROP_319",
					69 => "PROP_344",
					70 => "PROP_328",
					71 => "PROP_338",
					72 => "PROP_2113",
					73 => "PROP_2065",
					74 => "PROP_366",
					75 => "PROP_302",
					76 => "PROP_303",
					77 => "PROP_2054",
					78 => "PROP_341",
					79 => "PROP_223",
					80 => "PROP_283",
					81 => "PROP_354",
					82 => "PROP_313",
					83 => "PROP_2066",
					84 => "PROP_329",
					85 => "PROP_342",
					86 => "PROP_367",
					87 => "PROP_2084",
					88 => "PROP_340",
					89 => "PROP_351",
					90 => "PROP_368",
					91 => "PROP_369",
					92 => "PROP_331",
					93 => "PROP_337",
					94 => "PROP_345",
					95 => "PROP_339",
					96 => "PROP_310",
					97 => "PROP_309",
					98 => "PROP_330",
					99 => "PROP_2017",
					100 => "PROP_335",
					101 => "PROP_321",
					102 => "PROP_308",
					103 => "PROP_206",
					104 => "PROP_334",
					105 => "PROP_2100",
					106 => "PROP_311",
					107 => "PROP_2132",
					108 => "SHUM",
					109 => "PROP_361",
					110 => "PROP_326",
					111 => "PROP_315",
					112 => "PROP_2091",
					113 => "PROP_2026",
					114 => "PROP_307",
					115 => "PROP_2090",
					116 => "PROP_2027",
					117 => "PROP_2098",
					118 => "PROP_2112",
					119 => "PROP_2122",
					120 => "PROP_221",
					121 => "PROP_24",
					122 => "PROP_2134",
					123 => "PROP_23",
					124 => "PROP_2049",
					125 => "PROP_22",
					126 => "PROP_2095",
					127 => "PROP_2044",
					128 => "PROP_162",
					129 => "PROP_207",
					130 => "PROP_220",
					131 => "PROP_2094",
					132 => "PROP_2092",
					133 => "PROP_2111",
					134 => "PROP_2133",
					135 => "PROP_2096",
					136 => "PROP_2086",
					137 => "PROP_285",
					138 => "PROP_2130",
					139 => "PROP_286",
					140 => "PROP_222",
					141 => "PROP_2121",
					142 => "PROP_2123",
					143 => "PROP_2124",
					144 => "PROP_2093",
					145 => "LINK_REVIEWS",
					146 => "PROP_312",
					147 => "PROP_3083",
					148 => "PROP_2055",
					149 => "PROP_2069",
					150 => "PROP_2062",
					151 => "PROP_2061",
					152 => "RECOMMEND",
					153 => "NEW",
					154 => "STOCK",
					155 => "VIDEO",
					156 => "MATERIAL",
					157 => "SOSTAV_SITE_RU",
					158 => "SOSTAV_SITE_UA",
				),
				"DETAIL_META_KEYWORDS" => "-",
				"DETAIL_META_DESCRIPTION" => "-",
				"DETAIL_BROWSER_TITLE" => "-",
				"DETAIL_OFFERS_FIELD_CODE" => array(
					0 => "NAME",
					1 => "PREVIEW_PICTURE",
					2 => "DETAIL_TEXT",
					3 => "DETAIL_PICTURE",
					4 => "DETAIL_PAGE_URL",
					5 => "",
				),
				"DETAIL_OFFERS_PROPERTY_CODE" => array(
					0 => "SELECTION",
					1 => "RAZMER",
					2 => "STYLES",
					3 => "PRINT",
					4 => "AGE",
					5 => "MATERIAL",
					6 => "COLOR_REF",
					7 => "VID",
				),
				"PROPERTIES_DISPLAY_LOCATION" => "TAB",
				"SHOW_BRAND_PICTURE" => "Y",
				"SHOW_ASK_BLOCK" => "Y",
				"ASK_FORM_ID" => "2",
				"SHOW_ADDITIONAL_TAB" => "Y",
				"PROPERTIES_DISPLAY_TYPE" => "TABLE",
				"SHOW_KIT_PARTS" => "Y",
				"SHOW_KIT_PARTS_PRICES" => "Y",
				"LINK_IBLOCK_TYPE" => "",
				"LINK_IBLOCK_ID" => "",
				"LINK_PROPERTY_SID" => "",
				"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
				"USE_ALSO_BUY" => "Y",
				"ALSO_BUY_ELEMENT_COUNT" => "5",
				"ALSO_BUY_MIN_BUYES" => "2",
				"USE_STORE" => "Y",
				"USE_STORE_PHONE" => "Y",
				"USE_STORE_SCHEDULE" => "Y",
				"USE_MIN_AMOUNT" => "N",
				"MIN_AMOUNT" => "10",
				"STORE_PATH" => "/contacts/stores/#store_id#/",
				"MAIN_TITLE" => "Наличие на складах",
				"MAX_AMOUNT" => "20",
				"USE_ONLY_MAX_AMOUNT" => "Y",
				"OFFERS_SORT_FIELD" => "sort",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_FIELD2" => "sort",
				"OFFERS_SORT_ORDER2" => "asc",
				"PAGER_TEMPLATE" => "main",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"IBLOCK_STOCK_ID" => "18",
				"IBLOCK_LINK_NEWS_ID" => "23",
				"IBLOCK_SERVICES_ID" => "24",
				"IBLOCK_TIZERS_ID" => "11",
				"IBLOCK_LINK_REVIEWS_ID" => "10",
				"STAFF_IBLOCK_ID" => "30",
				"VACANCY_IBLOCK_ID" => "2",
				"SHOW_QUANTITY" => "Y",
				"SHOW_MEASURE" => "Y",
				"SHOW_QUANTITY_COUNT" => "Y",
				"USE_RATING" => "Y",
				"DISPLAY_WISH_BUTTONS" => "Y",
				"DEFAULT_COUNT" => "1",
				"SHOW_HINTS" => "Y",
				"AJAX_OPTION_ADDITIONAL" => "",
				"ADD_SECTIONS_CHAIN" => "N",
				"ADD_ELEMENT_CHAIN" => "N",
				"ADD_PROPERTIES_TO_BASKET" => "N",
				"PARTIAL_PRODUCT_PROPERTIES" => "Y",
				"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
				"STORES" => array(
					0 => "",
					1 => "",
				),
				"USER_FIELDS" => array(
					0 => "",
					1 => "UF_NAME_UA",
					2 => "UF_CATALOG_ICON",
					3 => "UF_DETAIL_TEXT_UA",
					4 => "",
				),
				"FIELDS" => array(
					0 => "",
					1 => "",
				),
				"SHOW_EMPTY_STORE" => "Y",
				"SHOW_GENERAL_STORE_INFORMATION" => "N",
				"TOP_ELEMENT_COUNT" => "8",
				"TOP_LINE_ELEMENT_COUNT" => "4",
				"TOP_ELEMENT_SORT_FIELD" => "sort",
				"TOP_ELEMENT_SORT_ORDER" => "asc",
				"TOP_ELEMENT_SORT_FIELD2" => "sort",
				"TOP_ELEMENT_SORT_ORDER2" => "asc",
				"TOP_PROPERTY_CODE" => array(
					0 => "",
					1 => "",
				),
				"COMPONENT_TEMPLATE" => ".default",
				"DETAIL_SET_CANONICAL_URL" => "Y",
				"SHOW_DEACTIVATED" => "N",
				"TOP_OFFERS_FIELD_CODE" => array(
					0 => "ID",
					1 => "",
				),
				"TOP_OFFERS_PROPERTY_CODE" => array(
					0 => "",
					1 => "",
				),
				"TOP_OFFERS_LIMIT" => "10",
				"SECTION_TOP_BLOCK_TITLE" => "Лучшие предложения",
				"OFFER_TREE_PROPS" => array(
					0 => "COLOR_REF",
					1 => "RAZMER",
				),
				"USE_BIG_DATA" => "Y",
				"BIG_DATA_RCM_TYPE" => "bestsell",
				"SHOW_DISCOUNT_PERCENT" => "Y",
				"SHOW_OLD_PRICE" => "Y",
				"VIEWED_ELEMENT_COUNT" => "20",
				"VIEWED_BLOCK_TITLE" => "Раніше ви переглядали",
				"ELEMENT_SORT_FIELD_BOX" => "name",
				"ELEMENT_SORT_ORDER_BOX" => "asc",
				"ELEMENT_SORT_FIELD_BOX2" => "id",
				"ELEMENT_SORT_ORDER_BOX2" => "desc",
				"ADD_PICT_PROP" => "-",
				"OFFER_ADD_PICT_PROP" => "-",
				"MAX_GALLERY_ITEMS" => "5",
				"SHOW_GALLERY" => "Y",
				"SHOW_PROPS" => "Y",
				"DETAIL_ADD_DETAIL_TO_SLIDER" => "Y",
				"SKU_DETAIL_ID" => "oid",
				"USE_MAIN_ELEMENT_SECTION" => "Y",
				"SET_LAST_MODIFIED" => "Y",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"AJAX_FILTER_CATALOG" => "Y",
				"AJAX_CONTROLS" => "Y",
				"SECTION_BACKGROUND_IMAGE" => "-",
				"DETAIL_BACKGROUND_IMAGE" => "-",
				"DISPLAY_ELEMENT_SLIDER" => "10",
				"SHOW_ONE_CLICK_BUY" => "Y",
				"USE_GIFTS_DETAIL" => "Y",
				"USE_GIFTS_SECTION" => "Y",
				"USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
				"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "8",
				"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
				"GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
				"GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
				"GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "3",
				"GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
				"GIFTS_SECTION_LIST_BLOCK_TITLE" => "Подарки к товарам этого раздела",
				"GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "Подарок",
				"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
				"GIFTS_SHOW_OLD_PRICE" => "Y",
				"GIFTS_SHOW_NAME" => "Y",
				"GIFTS_SHOW_IMAGE" => "Y",
				"GIFTS_MESS_BTN_BUY" => "Выбрать",
				"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",
				"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
				"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
				"OFFER_HIDE_NAME_PROPS" => "N",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
				"SECTION_PREVIEW_DESCRIPTION" => "Y",
				"SECTIONS_LIST_PREVIEW_DESCRIPTION" => "Y",
				"SALE_STIKER" => "SALE_TEXT",
				"SHOW_DISCOUNT_TIME" => "Y",
				"SHOW_RATING" => "Y",
				"COMPOSITE_FRAME_MODE" => "A",
				"COMPOSITE_FRAME_TYPE" => "AUTO",
				"DETAIL_OFFERS_LIMIT" => "0",
				"DETAIL_EXPANDABLES_TITLE" => "С этим товаром покупают",
				"DETAIL_ASSOCIATED_TITLE" => "Вам также может понравиться",
				"DETAIL_LINKED_GOODS_SLIDER" => "Y",
				"DETAIL_LINKED_GOODS_TABS" => "Y",
				"DETAIL_PICTURE_MODE" => "MAGNIFIER",
				"SHOW_UNABLE_SKU_PROPS" => "Y",
				"HIDE_NOT_AVAILABLE_OFFERS" => "L",
				"DETAIL_STRICT_SECTION_CHECK" => "N",
				"COMPATIBLE_MODE" => "Y",
				"TEMPLATE_THEME" => "blue",
				"LABEL_PROP" => array(
				),
				"PRODUCT_DISPLAY_MODE" => "Y",
				"COMMON_SHOW_CLOSE_POPUP" => "N",
				"PRODUCT_SUBSCRIPTION" => "Y",
				"SHOW_MAX_QUANTITY" => "N",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_COMPARE" => "Сравнение",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"MESS_BTN_SUBSCRIBE" => "Подписаться",
				"SIDEBAR_SECTION_SHOW" => "Y",
				"SIDEBAR_DETAIL_SHOW" => "N",
				"SIDEBAR_PATH" => "",
				"USE_SALE_BESTSELLERS" => "Y",
				"FILTER_VIEW_MODE" => "VERTICAL",
				"FILTER_HIDE_ON_MOBILE" => "N",
				"INSTANT_RELOAD" => "N",
				"COMPARE_POSITION_FIXED" => "Y",
				"COMPARE_POSITION" => "top left",
				"USE_RATIO_IN_RANGES" => "Y",
				"USE_COMMON_SETTINGS_BASKET_POPUP" => "N",
				"COMMON_ADD_TO_BASKET_ACTION" => "ADD",
				"TOP_ADD_TO_BASKET_ACTION" => "ADD",
				"SECTION_ADD_TO_BASKET_ACTION" => "ADD",
				"DETAIL_ADD_TO_BASKET_ACTION" => array(
					0 => "BUY",
				),
				"DETAIL_ADD_TO_BASKET_ACTION_PRIMARY" => array(
					0 => "BUY",
				),
				"TOP_PROPERTY_CODE_MOBILE" => array(
				),
				"TOP_VIEW_MODE" => "SECTION",
				"TOP_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
				"TOP_PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
				"TOP_ENLARGE_PRODUCT" => "STRICT",
				"TOP_SHOW_SLIDER" => "Y",
				"TOP_SLIDER_INTERVAL" => "3000",
				"TOP_SLIDER_PROGRESS" => "N",
				"SECTIONS_VIEW_MODE" => "LIST",
				"SECTIONS_SHOW_PARENT_NAME" => "Y",
				"LIST_PROPERTY_CODE_MOBILE" => array(
				),
				"LIST_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
				"LIST_PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
				"LIST_ENLARGE_PRODUCT" => "STRICT",
				"LIST_SHOW_SLIDER" => "Y",
				"LIST_SLIDER_INTERVAL" => "3000",
				"LIST_SLIDER_PROGRESS" => "N",
				"DETAIL_MAIN_BLOCK_PROPERTY_CODE" => array(
				),
				"DETAIL_MAIN_BLOCK_OFFERS_PROPERTY_CODE" => array(
				),
				"DETAIL_USE_VOTE_RATING" => "N",
				"DETAIL_USE_COMMENTS" => "N",
				"DETAIL_BRAND_USE" => "N",
				"DETAIL_DISPLAY_NAME" => "Y",
				"DETAIL_IMAGE_RESOLUTION" => "16by9",
				"DETAIL_PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
				"DETAIL_PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
				"DETAIL_BLOCKS_ORDER" => "complect,nabor,offers,tabs,services,news,blog,staff,vacancy,gifts,goods",
				"DETAIL_SHOW_SLIDER" => "N",
				"DETAIL_DETAIL_PICTURE_MODE" => array(
					0 => "POPUP",
					1 => "MAGNIFIER",
				),
				"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
				"MESS_PRICE_RANGES_TITLE" => "Ціни",
				"MESS_DESCRIPTION_TAB" => "Опис",
				"MESS_PROPERTIES_TAB" => "Характеристики",
				"MESS_COMMENTS_TAB" => "Коментарі",
				"LAZY_LOAD" => "N",
				"LOAD_ON_SCROLL" => "N",
				"USE_ENHANCED_ECOMMERCE" => "N",
				"DETAIL_DOCS_PROP" => "-",
				"STIKERS_PROP" => "HIT",
				"USE_SHARE" => "Y",
				"TAB_OFFERS_NAME" => "",
				"TAB_DESCR_NAME" => "",
				"TAB_KOMPLECT_NAME" => "",
				"TAB_NABOR_NAME" => "",
				"TAB_CHAR_NAME" => "",
				"TAB_VIDEO_NAME" => "",
				"TAB_REVIEW_NAME" => "",
				"TAB_FAQ_NAME" => "",
				"TAB_STOCK_NAME" => "",
				"TAB_DOPS_NAME" => "",
				"BLOCK_SERVICES_NAME" => "",
				"BLOCK_DOCS_NAME" => "",
				"DIR_PARAMS" => CMax::GetDirMenuParametrs(__DIR__),
				"ELEMENT_DETAIL_TYPE_VIEW" => "FROM_MODULE",
				"SHOW_CHEAPER_FORM" => "Y",
				"LANDING_TITLE" => "Популярные категории",
				"LANDING_SECTION_COUNT" => "10",
				"LANDING_SEARCH_TITLE" => "Похожие запросы",
				"LANDING_SEARCH_COUNT" => "7",
				"LIST_SECTIONS_TYPE_VIEW" => "sections_1",
				"LIST_ELEMENTS_TYPE_VIEW" => "list_elements_1",
				"CHEAPER_FORM_NAME" => "",
				"SECTIONS_TYPE_VIEW" => "FROM_MODULE",
				"SECTION_ELEMENTS_TYPE_VIEW" => "list_elements_1",
				"ELEMENT_TYPE_VIEW" => "FROM_MODULE",
				"LANDING_TYPE_VIEW" => "FROM_MODULE",
				"FILE_404" => "",
				"SHOW_MEASURE_WITH_RATIO" => "N",
				"SHOW_COUNTER_LIST" => "Y",
				"SHOW_DISCOUNT_TIME_EACH_SKU" => "N",
				"USER_CONSENT" => "N",
				"USER_CONSENT_ID" => "0",
				"USER_CONSENT_IS_CHECKED" => "Y",
				"USER_CONSENT_IS_LOADED" => "N",
				"SHOW_ARTICLE_SKU" => "Y",
				"USE_FILTER_PRICE" => "Y",
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"RESTART" => "N",
				"USE_LANGUAGE_GUESS" => "Y",
				"NO_WORD_LOGIC" => "Y",
				"SORT_REGION_PRICE" => "BASE",
				"SHOW_SECTION_DESC" => "Y",
				"USE_ADDITIONAL_GALLERY" => "Y",
				"ADDITIONAL_GALLERY_TYPE" => "BIG",
				"ADDITIONAL_GALLERY_PROPERTY_CODE" => "PHOTO_GALLERY",
				"ADDITIONAL_GALLERY_OFFERS_PROPERTY_CODE" => "-",
				"BLOCK_ADDITIONAL_GALLERY_NAME" => "",
				"STORES_FILTER" => "TITLE",
				"STORES_FILTER_ORDER" => "SORT_ASC",
				"VIEW_BLOCK_TYPE" => "N",
				"SHOW_HOW_BUY" => "Y",
				"TITLE_HOW_BUY" => "Як купити",
				"SHOW_DELIVERY" => "Y",
				"TITLE_DELIVERY" => "Доставка",
				"SHOW_PAYMENT" => "Y",
				"TITLE_PAYMENT" => "Оплата",
				"SHOW_GARANTY" => "Y",
				"TITLE_GARANTY" => "Умови гарантії",
				"TITLE_SLIDER" => "Рекомендуємо",
				"SHOW_SEND_GIFT" => "Y",
				"SEND_GIFT_FORM_NAME" => "",
				"BLOCK_LANDINGS_NAME" => "",
				"BLOG_IBLOCK_ID" => "28",
				"BLOCK_BLOG_NAME" => "",
				"RECOMEND_COUNT" => "5",
				"VISIBLE_PROP_COUNT" => "6",
				"BIGDATA_EXT" => "bigdata_1",
				"SHOW_DISCOUNT_PERCENT_NUMBER" => "Y",
				"ALT_TITLE_GET" => "NORMAL",
				"BUNDLE_ITEMS_COUNT" => "3",
				"SHOW_LANDINGS_SEARCH" => "Y",
				"SHOW_LANDINGS" => "Y",
				"LANDING_POSITION" => "BEFORE_PRODUCTS",
				"USE_DETAIL_PREDICTION" => "Y",
				"SECTION_BG" => "UF_SECTION_BG_IMG",
				"OFFER_SHOW_PREVIEW_PICTURE_PROPS" => array(
					0 => "COLOR_REF",
				),
				"LANDING_IBLOCK_ID" => "27",
				"DETAIL_BLOCKS_TAB_ORDER" => "desc,char,stores,video,reviews,buy,payment,delivery,custom_tab",
				"DETAIL_BLOCKS_ALL_ORDER" => "complect,goods,nabor,offers,desc,char,buy,payment,delivery,video,stores,custom_tab,services,news,blog,reviews,staff,vacancy,gifts",
				"DELIVERY_CALC" => "Y",
				"DELIVERY_CALC_NAME" => "",
				"ASK_TAB" => "",
				"TAB_NEWS_NAME" => "",
				"TAB_STAFF_NAME" => "",
				"TAB_VACANCY_NAME" => "",
				"STAFF_VIEW_TYPE" => "staff_block",
				"SECTION_TYPE_VIEW" => "FROM_MODULE",
				"SHOW_BUY_DELIVERY" => "Y",
				"TITLE_BUY_DELIVERY" => "Оплата и доставка",
				"BLOG_URL" => "catalog_comments",
				"LANDING_SEARCH_COUNT_MOBILE" => "3",
				"USE_BIG_DATA_IN_SEARCH" => "N",
				"SHOW_MORE_SUBSECTIONS" => "Y",
				"SHOW_SIDE_BLOCK_LAST_LEVEL" => "N",
				"SHOW_SORT_IN_FILTER" => "Y",
				"SUBSECTION_PREVIEW_PROPERTY" => "DESCRIPTION",
				"SHOW_SUBSECTION_DESC" => "Y",
				"LANDING_SECTION_COUNT_MOBILE" => "3",
				"SHOW_SMARTSEO_TAGS" => "Y",
				"SHOW_SKU_DESCRIPTION" => "Y",
				"MODULES_ELEMENT_COUNT" => "10",
				"USE_CUSTOM_RESIZE" => "N",
				"DETAIL_SET_PRODUCT_TITLE" => "Собрать комплект",
				"DISPLAY_LINKED_PAGER" => "Y",
				"LINKED_ELEMENT_TAB_SORT_FIELD" => "sort",
				"LINKED_ELEMENT_TAB_SORT_ORDER" => "asc",
				"LINKED_ELEMENT_TAB_SORT_FIELD2" => "id",
				"LINKED_ELEMENT_TAB_SORT_ORDER2" => "desc",
				"DETAIL_BLOG_EMAIL_NOTIFY" => "Y",
				"MAX_IMAGE_SIZE" => "0.5",
				"TAB_BUY_SERVICES_NAME" => "",
				"COUNT_SERVICES_IN_ANNOUNCE" => "2",
				"SHOW_ALL_SERVICES_IN_SLIDE" => "N",
				"BIGDATA_SHOW_FROM_SECTION" => "N",
				"SMARTSEO_TAGS_COUNT" => "10",
				"SMARTSEO_TAGS_COUNT_MOBILE" => "3",
				"DISCOUNT_PERCENT_POSITION" => "bottom-right",
				"SEARCH_PAGE_RESULT_COUNT" => "50",
				"SEARCH_RESTART" => "N",
				"SEARCH_NO_WORD_LOGIC" => "Y",
				"SEARCH_USE_LANGUAGE_GUESS" => "Y",
				"SEARCH_CHECK_DATES" => "Y",
				"SEARCH_USE_SEARCH_RESULT_ORDER" => "N",
				"DETAIL_SHOW_POPULAR" => "Y",
				"DETAIL_SHOW_VIEWED" => "Y",
				"MESS_BTN_LAZY_LOAD" => "Показать ещё",
				"SEF_URL_TEMPLATES" => array(
					"sections" => "",
					"section" => "#SECTION_CODE_PATH#/",
					"element" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
					"compare" => "compare.php?action=#ACTION_CODE#",
					"smart_filter" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
				),
				"VARIABLE_ALIASES" => array(
					"compare" => array(
						"ACTION_CODE" => "action",
					),
				)
			),
			false
		);
		}


		?>

		<?/*
		<div class="page-title">
			<h1 class="page-title-text">
				Жіночий одяг
			</h1>
		</div>

		<div class="catalog-category-cont">
			<div class="catalog-category-item-cont">
				<div class="catalog-category-item">
					<div class="catalog-category-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/categ-img.png">
						</a>
						<div class="catalog-category-item-name">
							<a href="#">нова колекція</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-category-item-cont">
				<div class="catalog-category-item">
					<div class="catalog-category-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/categ-img.png">
						</a>
						<div class="catalog-category-item-name">
							<a href="#">Сукні</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-category-item-cont">
				<div class="catalog-category-item">
					<div class="catalog-category-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/categ-img.png">
						</a>
						<div class="catalog-category-item-name">
							<a href="#">Костюми</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-category-item-cont">
				<div class="catalog-category-item">
					<div class="catalog-category-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/categ-img.png">
						</a>
						<div class="catalog-category-item-name">
							<a href="#">ДЖИНСИ</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-category-item-cont">
				<div class="catalog-category-item">
					<div class="catalog-category-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/categ-img.png">
						</a>
						<div class="catalog-category-item-name">
							<a href="#">Брюки</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-category-item-cont">
				<div class="catalog-category-item">
					<div class="catalog-category-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/categ-img.png">
						</a>
						<div class="catalog-category-item-name">
							<a href="#">Блузи і Сорочки</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-category-item-cont">
				<div class="catalog-category-item">
					<div class="catalog-category-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/categ-img.png">
						</a>
						<div class="catalog-category-item-name">
							<a href="#">нова колекція</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="catalog-filters">
			<div class="catalog-filters-top">
				<div class="catalog-filter-cont catalog-filter-cont-opener">
					<div class="catalog-filter-block">
						<div class="catalog-filter-name">
							<span>фільтр</span>
							<span class="icon">
								<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
			 				</span>
						</div>
					</div>
				</div>
				<div class="catalog-filters-type">
					<div class="catalog-filter-cont">
						<div class="catalog-filter-block">
							<div class="catalog-filter-name">
								<span>Тип</span>
								<span class="icon">
									<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
				 				</span>
							</div>
							<div class="catalog-filter-dropdown">
								<ul class="catalog-filter-type">
									<li>
										<a href="#">
											<span class="icon"></span>легінси
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>джинси
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>джогери
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>бріджі
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>шорти
										</a>
									</li>
									<li>
										<a href="#" class="active">
											<span class="icon"></span>брюки
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>легінси
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>джинси
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>джогери
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>бріджі
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>шорти
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>легінси
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>джинси
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="catalog-filter-cont">
						<div class="catalog-filter-block">
							<div class="catalog-filter-name">
								<span>Розмір</span>
								<span class="icon"></span>
									<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
				 				</span>
							</div>
							<div class="catalog-filter-dropdown">
								<ul class="catalog-filter-type">
									<li>
										<a href="#">
											<span class="icon"></span>xs
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>s
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>m
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>l
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>xl
										</a>
									</li>
									<li>
										<a href="#" class="active">
											<span class="icon"></span>xxl
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>xxxl
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="catalog-filter-cont">
						<div class="catalog-filter-block">
							<div class="catalog-filter-name">
								<span>Колір</span>
								<span class="icon"></span>
									<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
				 				</span>
							</div>
							<div class="catalog-filter-dropdown">
								<ul class="catalog-filter-type filter-color">
									<li>
										<a href="#">
											<span class="icon" style="box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.35); background:#ffffff"></span>білий
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#000000"></span>чорний
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#FFE974"></span>жовтий
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#1F4CED"></span>синій
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#39A430;"></span>зелений
										</a>
									</li>
									<li>
										<a href="#" class="active">
											<span class="icon" style="background:#E31111"></span>червоний
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#915D40"></span>коричневий
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#E8D4AD"></span>беж
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#AAAAAA"></span>сірий
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#5F6940"></span>хакі
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#63B4FF"></span>блакитний
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#E31111"></span>червоний
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" style="background:#915D40"></span>коричневий
										</a>
									</li>
								</ul>
								<ul class="catalog-filter-type filter-color" style="display:none;">
									<li>
										<a href="#">
											<span class="icon">
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>білий
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" >
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>чорний
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon">
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>жовтий
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon">
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>синій
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"">
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>зелений
										</a>
									</li>
									<li>
										<a href="#" class="active">
											<span class="icon">
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>червоний
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon">
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>коричневий
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon">
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>беж
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon">
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>сірий
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon">
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>хакі
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" >
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>блакитний
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon" >
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>червоний
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon">
												<img src="/bitrix/templates/aspro_max/images/colorimg.png">
											</span>коричневий
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="catalog-filter-cont">
						<div class="catalog-filter-block">
							<div class="catalog-filter-name">
								<span>Матеріал</span>
								<span class="icon"></span>
									<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
				 				</span>
							</div>
							<div class="catalog-filter-dropdown">
								<ul class="catalog-filter-type">
									<li>
										<a href="#">
											<span class="icon"></span>шовк
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>льон
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>шкіра
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>еко-шкіра
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>трикотаж
										</a>
									</li>
									<li>
										<a href="#" class="active">
											<span class="icon"></span>мереживо
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>жатка
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>шерсть
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>вельвет
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>джинс
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>сатин
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>жатка
										</a>
									</li>
									<li>
										<a href="#">
											<span class="icon"></span>трикотаж
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="catalog-filter-cont">
						<div class="catalog-filter-block">
							<div class="catalog-filter-name">
								<span>Ціна</span>
								<span class="icon"></span>
									<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
				 				</span>
							</div>
							<div class="catalog-filter-dropdown">
								
							</div>
						</div>
					</div>
				</div>
				<div class="catalog-filter-cont">
					<div class="catalog-filter-block">
						<div class="catalog-filter-name">
							<span>сортувати</span>
							<span class="icon">
								<svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L9 9L17 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
			 				</span>
						</div>
						<div class="catalog-filter-dropdown">
							<a href="#">За новизною</a>
							<a href="#">За популярністю</a>
							<a href="#">Максимальна знижка</a>
							<a href="#">Від дешевих до дорогих</a>
							<a href="#">Від дорогих до дешевих</a>
						</div>
					</div>
				</div>
			</div>
			<div class="filter-selected-list">
				<div class="filter-selected-item">
					<div class="filter-selected-item-name">спортивний костюм</div>
					<a href="#" class="filter-selected-item-delete">
						<svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
						</svg>
					</a>
				</div>
				<div class="filter-selected-item">
					<div class="filter-selected-item-name">світшот</div>
					<a href="#" class="filter-selected-item-delete">
						<svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
						</svg>
					</a>
				</div>
				<div class="filter-selected-item">
					<div class="filter-selected-item-name">чорний</div>
					<a href="#" class="filter-selected-item-delete">
						<svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
						</svg>
					</a>
				</div>
				<div class="filter-selected-item">
					<div class="filter-selected-item-name">котон</div>
					<a href="#" class="filter-selected-item-delete">
						<svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
						</svg>
					</a>
				</div>
				<div class="filter-selected-item">
					<div class="filter-selected-item-name">очистити фільтри</div>
					<a href="#" class="filter-selected-item-delete">
						<svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M0.146447 6.1464C-0.0488155 6.34166 -0.0488155 6.65824 0.146447 6.8535C0.341709 7.04877 0.658291 7.04877 0.853553 6.8535L3.48759 4.21946L6.12174 6.8536C6.317 7.04887 6.63358 7.04887 6.82884 6.8536C7.02411 6.65834 7.02411 6.34176 6.82884 6.1465L4.1947 3.51235L6.82884 0.878212C7.02411 0.682949 7.02411 0.366367 6.82884 0.171105C6.63358 -0.0241572 6.317 -0.0241576 6.12174 0.171105L3.48759 2.80525L0.853553 0.171206C0.658291 -0.0240561 0.341709 -0.0240561 0.146447 0.171206C-0.0488155 0.366468 -0.0488155 0.683051 0.146447 0.878313L2.78049 3.51235L0.146447 6.1464Z" fill="#3D441D"></path>
						</svg>
					</a>
				</div>
			</div>
		</div>

		<div class="catalog-items-block">
			<div class="catalog-item-cont">
				<div class="catalog-item-block">
					<div class="catalog-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/mgimg.png">
						</a>
						<div class="catalog-item-size-list">
							<div class="catalog-item-size no-size">
								XS
							</div>
							<div class="catalog-item-size ">
								S
							</div>
							<div class="catalog-item-size no-size">
								M
							</div>
							<div class="catalog-item-size ">
								L
							</div>
							<div class="catalog-item-size ">
								XL
							</div>
							<div class="catalog-item-size no-size">
								XXL
							</div>
						</div>
						<div class="catalog-item-favorite">
							<a href="#">
								<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
					<div class="catalog-item-name-block">
						<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
						<div class="catalog-item-sale">SALE</div>
					</div>
					<div class="catalog-item-info">
						<div class="catalog-item-price">
							<div class="catalog-item-price-currency">990 грн</div>
							<div class="catalog-item-price-old">1300  грн</div>
						</div>
						<div class="catalog-item-colors">
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color active">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-item-cont">
				<div class="catalog-item-block">
					<div class="catalog-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/mgimg.png">
						</a>
						<div class="catalog-item-size-list">
							<div class="catalog-item-size no-size">
								XS
							</div>
							<div class="catalog-item-size ">
								S
							</div>
							<div class="catalog-item-size no-size">
								M
							</div>
							<div class="catalog-item-size ">
								L
							</div>
							<div class="catalog-item-size ">
								XL
							</div>
							<div class="catalog-item-size no-size">
								XXL
							</div>
						</div>
						<div class="catalog-item-favorite">
							<a href="#">
								<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
					<div class="catalog-item-name-block">
						<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
						<div class="catalog-item-sale">SALE</div>
					</div>
					<div class="catalog-item-info">
						<div class="catalog-item-price">
							<div class="catalog-item-price-currency">990 грн</div>
							<div class="catalog-item-price-old">1300  грн</div>
						</div>
						<div class="catalog-item-colors">
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color active">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-item-cont">
				<div class="catalog-item-block">
					<div class="catalog-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/mgimg.png">
						</a>
						<div class="catalog-item-size-list">
							<div class="catalog-item-size no-size">
								XS
							</div>
							<div class="catalog-item-size ">
								S
							</div>
							<div class="catalog-item-size no-size">
								M
							</div>
							<div class="catalog-item-size ">
								L
							</div>
							<div class="catalog-item-size ">
								XL
							</div>
							<div class="catalog-item-size no-size">
								XXL
							</div>
						</div>
						<div class="catalog-item-favorite">
							<a href="#">
								<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
					<div class="catalog-item-name-block">
						<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
						<div class="catalog-item-sale">SALE</div>
					</div>
					<div class="catalog-item-info">
						<div class="catalog-item-price">
							<div class="catalog-item-price-currency">990 грн</div>
							<div class="catalog-item-price-old">1300  грн</div>
						</div>
						<div class="catalog-item-colors">
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color active">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-item-cont">
				<div class="catalog-item-block">
					<div class="catalog-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/mgimg.png">
						</a>
						<div class="catalog-item-size-list">
							<div class="catalog-item-size no-size">
								XS
							</div>
							<div class="catalog-item-size ">
								S
							</div>
							<div class="catalog-item-size no-size">
								M
							</div>
							<div class="catalog-item-size ">
								L
							</div>
							<div class="catalog-item-size ">
								XL
							</div>
							<div class="catalog-item-size no-size">
								XXL
							</div>
						</div>
						<div class="catalog-item-favorite">
							<a href="#">
								<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
					<div class="catalog-item-name-block">
						<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
						<div class="catalog-item-sale">SALE</div>
					</div>
					<div class="catalog-item-info">
						<div class="catalog-item-price">
							<div class="catalog-item-price-currency">990 грн</div>
							<div class="catalog-item-price-old">1300  грн</div>
						</div>
						<div class="catalog-item-colors">
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color active">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-item-cont">
				<div class="catalog-item-block">
					<div class="catalog-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/mgimg.png">
						</a>
						<div class="catalog-item-size-list">
							<div class="catalog-item-size no-size">
								XS
							</div>
							<div class="catalog-item-size ">
								S
							</div>
							<div class="catalog-item-size no-size">
								M
							</div>
							<div class="catalog-item-size ">
								L
							</div>
							<div class="catalog-item-size ">
								XL
							</div>
							<div class="catalog-item-size no-size">
								XXL
							</div>
						</div>
						<div class="catalog-item-favorite">
							<a href="#">
								<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
					<div class="catalog-item-name-block">
						<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
						<div class="catalog-item-sale">SALE</div>
					</div>
					<div class="catalog-item-info">
						<div class="catalog-item-price">
							<div class="catalog-item-price-currency">990 грн</div>
							<div class="catalog-item-price-old">1300  грн</div>
						</div>
						<div class="catalog-item-colors">
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color active">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-item-cont">
				<div class="catalog-item-block">
					<div class="catalog-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/mgimg.png">
						</a>
						<div class="catalog-item-size-list">
							<div class="catalog-item-size no-size">
								XS
							</div>
							<div class="catalog-item-size ">
								S
							</div>
							<div class="catalog-item-size no-size">
								M
							</div>
							<div class="catalog-item-size ">
								L
							</div>
							<div class="catalog-item-size ">
								XL
							</div>
							<div class="catalog-item-size no-size">
								XXL
							</div>
						</div>
						<div class="catalog-item-favorite">
							<a href="#">
								<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
					<div class="catalog-item-name-block">
						<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
						<div class="catalog-item-sale">SALE</div>
					</div>
					<div class="catalog-item-info">
						<div class="catalog-item-price">
							<div class="catalog-item-price-currency">990 грн</div>
							<div class="catalog-item-price-old">1300  грн</div>
						</div>
						<div class="catalog-item-colors">
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color active">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-item-cont">
				<div class="catalog-item-block">
					<div class="catalog-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/mgimg.png">
						</a>
						<div class="catalog-item-size-list">
							<div class="catalog-item-size no-size">
								XS
							</div>
							<div class="catalog-item-size ">
								S
							</div>
							<div class="catalog-item-size no-size">
								M
							</div>
							<div class="catalog-item-size ">
								L
							</div>
							<div class="catalog-item-size ">
								XL
							</div>
							<div class="catalog-item-size no-size">
								XXL
							</div>
						</div>
						<div class="catalog-item-favorite">
							<a href="#">
								<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
					<div class="catalog-item-name-block">
						<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
						<div class="catalog-item-sale">SALE</div>
					</div>
					<div class="catalog-item-info">
						<div class="catalog-item-price">
							<div class="catalog-item-price-currency">990 грн</div>
							<div class="catalog-item-price-old">1300  грн</div>
						</div>
						<div class="catalog-item-colors">
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color active">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="catalog-item-cont">
				<div class="catalog-item-block">
					<div class="catalog-item-img">
						<a href="#">
							<img src="/bitrix/templates/aspro_max/images/mgimg.png">
						</a>
						<div class="catalog-item-size-list">
							<div class="catalog-item-size no-size">
								XS
							</div>
							<div class="catalog-item-size ">
								S
							</div>
							<div class="catalog-item-size no-size">
								M
							</div>
							<div class="catalog-item-size ">
								L
							</div>
							<div class="catalog-item-size ">
								XL
							</div>
							<div class="catalog-item-size no-size">
								XXL
							</div>
						</div>
						<div class="catalog-item-favorite">
							<a href="#">
								<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.5059 18L19.7299 10.6017C21.0134 9.4487 21.881 7.86335 21.9879 6.13388C22.083 4.65662 21.6433 2.98719 19.7418 1.8222C15.5347 -0.747996 11.6723 3.38353 11.4941 4.9929C11.3158 3.38353 7.4534 -0.747996 3.24635 1.8222C1.35674 2.98719 0.917023 4.65662 1.0121 6.13388C1.11906 7.86335 1.98661 9.4487 3.27012 10.6017L11.5059 18Z" stroke="#3D441D" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
					<div class="catalog-item-name-block">
						<a href="#" class="catalog-item-name">Жіноча сукня Stimma Коріс</a>
						<div class="catalog-item-sale">SALE</div>
					</div>
					<div class="catalog-item-info">
						<div class="catalog-item-price">
							<div class="catalog-item-price-currency">990 грн</div>
							<div class="catalog-item-price-old">1300  грн</div>
						</div>
						<div class="catalog-item-colors">
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color active">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
							<a href="#" class="catalog-item-color">
								<img src="/bitrix/templates/aspro_max/images/colorimg.png">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="show-more-block">
			<a href="#" class="show-more-btn">
				показати більше
			</a>
			<a href="#" class="up-page-btn">
				<svg width="32" height="17" viewBox="0 0 32 17" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M30.1421 15.1421L16 1L1.85787 15.1421" stroke="#3D441D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</a>
		</div>

		<div class="pagination-cont">
			<div class="pagination-block">
				<a href="#" class="pagination-item pagination-arrow pagination-arrow-prev">
					<svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11 21L1 11L11 1" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>
				<a href="#" class="pagination-item">
					1
				</a>
				<span class="pagination-item active">
					2
				</span>
				<a href="#" class="pagination-item">
					3
				</a>
				<span class="pagination-sep">
					....
				</span>
				<a href="#" class="pagination-item">
					304
				</a>
				<a href="#" class="pagination-item pagination-arrow pagination-arrow-next">
					<svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1 1L11 11L1 21" stroke="#3D441D" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>
			</div>
		</div>

		*/?>

<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>