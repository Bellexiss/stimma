<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("viewed_show", "Y");
$APPLICATION->SetTitle("Стимма");?>


<div class="info-page">
	<div class="info-page-tabs">
        <?$APPLICATION->IncludeComponent(
            "bitrix:menu",
            "page_info_menu",
            array(
                "COMPONENT_TEMPLATE" => "page_info_menu",
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
        <?/*
		<ul class="nav nav-tabs" role="tablist">
		  <li class="nav-item active">
		    <a class="nav-link" id="stab1" data-toggle="tab" href="#stab1-b" role="tab" aria-selected="true">Як зробити замовлення</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="stab2" data-toggle="tab" href="#stab2-b" role="tab" aria-selected="false">Гарантія та повернення</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="stab3" data-toggle="tab" href="#stab3-b" role="tab" aria-selected="false">Доставка та оплата</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="stab4" data-toggle="tab" href="#stab4-b" role="tab" aria-selected="false">Розмірна сітка</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="stab5" data-toggle="tab" href="#stab5-b" role="tab" aria-selected="false">Сертифікати</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="stab6" data-toggle="tab" href="#stab6-b" role="tab" aria-selected="false">Відгуки</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="stab7" data-toggle="tab" href="#stab7-b" role="tab" aria-selected="false">Про нас</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="stab8" data-toggle="tab" href="#stab8-b" role="tab" aria-selected="false">Статті</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="stab9" data-toggle="tab" href="#stab9-b" role="tab" aria-selected="false">Архів колекцій</a>
		  </li>
		</ul>
        */?>
		<div class="tab-content">
		  <div class="tab-pane fade active in" id="stab1-b" role="tabpanel">...</div>
		  <div class="tab-pane fade" id="stab2-b" role="tabpanel">...</div>
		  <div class="tab-pane fade" id="stab3-b" role="tabpanel">...</div>
		  <div class="tab-pane fade" id="stab4-b" role="tabpanel">
		  	<div class="dimensional-info">
		  		<div class="dimensional-info-cont">
		  			<div class="dimensional-info-left">
		  				<div class="dimensional-info-h1">
		  					ЯК ПРАВИЛЬНО ВИМІРЯТИ?
		  				</div>
		  				<div class="dimensional-info-semi-t">Щоб вибрати правильний розмір, необхідно зняти такі мірки:</div>
		  				<div class="dimensional-info-text">
		  					<div class="dimensional-info-text-title">
		  						1. ОБХВАТ ГРУДЕЙ
		  					</div>
		  					<div class="dimensional-info-text-cont">
		  						Виміряйте свій обхват грудей за допомогою сантиметрової стрічки, провівши її під пахвами і по самій виступаючій частині Необхідно, щоб мірна стрічка прилягала до тіла і була паралельна до землі.
		  					</div>
		  				</div>
		  				<div class="dimensional-info-text">
		  					<div class="dimensional-info-text-title">
		  						2. ОБХВАТ ТАЛІЇ
		  					</div>
		  					<div class="dimensional-info-text-cont">
		  						Щоб виміряти обхват талії, спочатку підніміть або зніміть сорочку, потім встаньте прямо і видихніть. У цьому положенні тримайте край мірної стрічки на пупці і оберніть її навколо найвужчої частини талії. Переконайтеся, що мірна стрічка щільно прилягала до тіла і паралельна до землі.
		  					</div>
		  				</div>
		  				<div class="dimensional-info-text">
		  					<div class="dimensional-info-text-title">
		  						3. ОБХВАТ СТЕГОН
		  					</div>
		  					<div class="dimensional-info-text-cont">
		  						Поставте ноги разом і оберніть навколо своїх стегон сантиметрову стрічку, провівши її по точках сідниць, що найбільш виступають. Мірна стрічка повинна бути паралельною до землі та щільно прилягати до тіла.
		  					</div>
		  				</div>
		  			</div>
		  			<div class="dimensional-info-right">
		  				<img src="/bitrix/templates/aspro_max/images/size1.png">
		  				<div class="dimensional-info-right-img">
		  					<img src="/bitrix/templates/aspro_max/images/Leaf1.png">
		  				</div>
		  			</div>
		  		</div>
		  		<div class="dimensional-info-gen">
		  			<div class="dimensional-info-gen-title">
		  				ЖІНОЧИЙ ОДЯГ
		  			</div>
		  			<div class="dimensional-info-gen-table-cont">
		  				<div class="dimensional-info-gen-table-title">
		  					Кофти, топи, блузи, верхній одяг
		  				</div>
		  				<div class="dimensional-info-gen-table">
		  					<table>
		  						<tr>
		  							<th>Україна</th>
		  							<th>Міжнародний</th>
		  							<th>Обхват грудей</th>
		  							<th>Обхват талії</th>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  					</table>
		  				</div>
		  			</div>
		  			<div class="dimensional-info-gen-table-cont">
		  				<div class="dimensional-info-gen-table-title">
		  					Штани, шорти, спідниці
		  				</div>
		  				<div class="dimensional-info-gen-table">
		  					<table>
		  						<tr>
		  							<th>Україна</th>
		  							<th>Міжнародний</th>
		  							<th>Обхват грудей</th>
		  							<th>Обхват талії</th>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  						</tr>
		  					</table>
		  				</div>
		  			</div>
		  			<div class="dimensional-info-gen-table-cont">
		  				<div class="dimensional-info-gen-table-title">
		  					СУКНІ
		  				</div>
		  				<div class="dimensional-info-gen-table">
		  					<table>
		  						<tr>
		  							<th>Україна</th>
		  							<th>Міжнародний</th>
		  							<th>Обхват грудей</th>
		  							<th>Обхват талії</th>
		  							<th>Обхват СТЕГОН </th>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  							<td>
		  								86 - 90
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  							<td>
		  								86 - 90
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  							<td>
		  								86 - 90
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  							<td>
		  								86 - 90
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  							<td>
		  								86 - 90
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  							<td>
		  								86 - 90
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  							<td>
		  								86 - 90
		  							</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>40</b>
		  							</td>
		  							<td>
		  								<b>XS</b>
		  							</td>
		  							<td>
		  								80 - 84
		  							</td>
		  							<td>
		  								62 - 66
		  							</td>
		  							<td>
		  								86 - 90
		  							</td>
		  						</tr>
		  					</table>
		  				</div>
		  			</div>
		  		</div>
		  		<div class="dimensional-info-gen">
		  			<div class="dimensional-info-gen-title">
		  				ДИТЯЧИЙ ОДЯГ
		  			</div>
		  			<div class="dimensional-info-gen-table-cont">
		  				<div class="dimensional-info-gen-table-title">
		  					ДЛЯ ДІВЧАТОК
		  				</div>
		  				<div class="dimensional-info-gen-table">
		  					<table>
		  						<tr>
		  							<th>РОЗМІР (РІСТ)</th>
		  							<th>110</th>
		  							<th>116</th>
		  							<th>122</th>
		  							<th>128</th>
		  							<th>134</th>
		  							<th>140</th>
		  							<th>146</th>
		  							<th>152</th>
		  							<th>158</th>
		  							<th>164</th>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>ОБХВАТ ГРУДЕЙ</b>
		  							</td>
		  							<td>58</td>
		  							<td>60</td>
		  							<td>62</td>
		  							<td>64</td>
		  							<td>66</td>
		  							<td>68</td>
		  							<td>72</td>
		  							<td>76</td>
		  							<td>80</td>
		  							<td>84</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>ОБХВАТ ГРУДЕЙ</b>
		  							</td>
		  							<td>58</td>
		  							<td>60</td>
		  							<td>62</td>
		  							<td>64</td>
		  							<td>66</td>
		  							<td>68</td>
		  							<td>72</td>
		  							<td>76</td>
		  							<td>80</td>
		  							<td>84</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>ОБХВАТ ГРУДЕЙ</b>
		  							</td>
		  							<td>58</td>
		  							<td>60</td>
		  							<td>62</td>
		  							<td>64</td>
		  							<td>66</td>
		  							<td>68</td>
		  							<td>72</td>
		  							<td>76</td>
		  							<td>80</td>
		  							<td>84</td>
		  						</tr>
		  					</table>
		  				</div>
		  			</div>
		  			<div class="dimensional-info-gen-table-cont">
		  				<div class="dimensional-info-gen-table-title">
		  					ДЛЯ ХЛОПЧИКІВ
		  				</div>
		  				<div class="dimensional-info-gen-table">
		  					<table>
		  						<tr>
		  							<th>РОЗМІР (РІСТ)</th>
		  							<th>110</th>
		  							<th>116</th>
		  							<th>122</th>
		  							<th>128</th>
		  							<th>134</th>
		  							<th>140</th>
		  							<th>146</th>
		  							<th>152</th>
		  							<th>158</th>
		  							<th>164</th>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>ОБХВАТ ГРУДЕЙ</b>
		  							</td>
		  							<td>58</td>
		  							<td>60</td>
		  							<td>62</td>
		  							<td>64</td>
		  							<td>66</td>
		  							<td>68</td>
		  							<td>72</td>
		  							<td>76</td>
		  							<td>80</td>
		  							<td>84</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>ОБХВАТ ГРУДЕЙ</b>
		  							</td>
		  							<td>58</td>
		  							<td>60</td>
		  							<td>62</td>
		  							<td>64</td>
		  							<td>66</td>
		  							<td>68</td>
		  							<td>72</td>
		  							<td>76</td>
		  							<td>80</td>
		  							<td>84</td>
		  						</tr>
		  						<tr>
		  							<td>
		  								<b>ОБХВАТ ГРУДЕЙ</b>
		  							</td>
		  							<td>58</td>
		  							<td>60</td>
		  							<td>62</td>
		  							<td>64</td>
		  							<td>66</td>
		  							<td>68</td>
		  							<td>72</td>
		  							<td>76</td>
		  							<td>80</td>
		  							<td>84</td>
		  						</tr>
		  					</table>
		  				</div>
		  			</div>
		  			
		  		</div>
		  	</div>
		  </div>
		  <div class="tab-pane fade" id="stab5-b" role="tabpanel">
		  	<div class="sertificate-cont">
            	<div class="sertificate-item">
            		<div class="sertificate-item-img">
            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
            			</a>
            		</div>
            		<div class="sertificate-item-name">
            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
            		</div>
            	</div>
            	<div class="sertificate-item">
            		<div class="sertificate-item-img">
            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
            			</a>
            		</div>
            		<div class="sertificate-item-name">
            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
            		</div>
            	</div>
            	<div class="sertificate-item">
            		<div class="sertificate-item-img">
            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
            			</a>
            		</div>
            		<div class="sertificate-item-name">
            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
            		</div>
            	</div>
            	<div class="sertificate-item">
            		<div class="sertificate-item-img">
            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
            			</a>
            		</div>
            		<div class="sertificate-item-name">
            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
            		</div>
            	</div>
            	<div class="sertificate-item">
            		<div class="sertificate-item-img">
            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
            			</a>
            		</div>
            		<div class="sertificate-item-name">
            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
            		</div>
            	</div>
            	<div class="sertificate-item">
            		<div class="sertificate-item-img">
            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
            			</a>
            		</div>
            		<div class="sertificate-item-name">
            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
            		</div>
            	</div>
            	<div class="sertificate-item">
            		<div class="sertificate-item-img">
            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
            			</a>
            		</div>
            		<div class="sertificate-item-name">
            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
            		</div>
            	</div>
            </div>
		  </div>
		  <div class="tab-pane fade" id="stab6-b" role="tabpanel">...</div>
		  <div class="tab-pane fade" id="stab7-b" role="tabpanel">...</div>
		  <div class="tab-pane fade" id="stab8-b" role="tabpanel">...</div>
		  <div class="tab-pane fade" id="stab9-b" role="tabpanel">...</div>
		</div>
	</div>
	<div class="card-main-tabs-mobile">
            <div class="card-tabs-mobile-item">
                <div class="card-tabs-mobile-item-title">
                    ХАРАКТЕРИСТИКИ
                </div>
                <div class="card-tabs-mobile-item-cont">
                    <ul class="card-info-list">
                        <?
                        foreach ($arResult['PROPERTIES'] as $index => $arProp)
                        {
                            if(!$arProp['VALUE']) continue;
                            ?>
                            <li>
                                <span><?=$arProp['NAME']?>:</span>
                                <?=is_array($arProp['VALUE']) ? implode(', ',$arProp['VALUE']) : $arProp['VALUE']?>
                            </li>
                            <?
                        }
                        ?>
                        <?/*
                        <li>
                            <span>Розміри:</span>
                            S, M
                        </li>
                        <li>
                            <span>Колір:</span>
                            Капучіно
                        </li>
                        <li>
                            <span>Бренд:</span>
                            STIMMA
                        </li>
                        <li>
                            <span>Вид:</span>
                            Сукня
                        </li>
                        <li>
                            <span>Країна:</span>
                            Україна
                        </li>
                        <li>
                            <span>Матеріал:</span>
                            Сатин
                        </li>
                        <li>
                            <span>Склад:</span>
                            70% - поліестр,  30% - віскоза
                        </li>
                        <li>
                            <span>Виробник:</span>
                            STIMMA
                        </li>
                        */?>
                    </ul>
                </div>
            </div>
            <div class="card-tabs-mobile-item">
                <div class="card-tabs-mobile-item-title">
                    РОЗМІРИ ГОТОВОГО ВИРОБУ
                </div>
                <div class="card-tabs-mobile-item-cont">
                    <table class="card-table-size">
                        <tr>
                            <td>Аліма(сукня)</td>
                            <td>S</td>
                            <td>M</td>
                            <td>L</td>
                        </tr>
                        <tr>
                            <td>Пог</td>
                            <td>46</td>
                            <td>48</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>ПоТ</td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                        </tr>
                        <tr>
                            <td>ПОБ</td>
                            <td>47</td>
                            <td>49</td>
                            <td>51</td>
                        </tr>
                        <tr>
                            <td>Ширина плеч по спинке</td>
                            <td>32</td>
                            <td>33</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>Длина рукава</td>
                            <td>51</td>
                            <td>51</td>
                            <td>51</td>
                        </tr>
                        <tr>
                            <td>Длина изделия по спинке</td>
                            <td>111</td>
                            <td>111</td>
                            <td>111</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-tabs-mobile-item">
                <div class="card-tabs-mobile-item-title">
                    ОПЛАТА ТА ДОСТАВКА
                </div>
                <div class="card-tabs-mobile-item-cont">
                    <div class="card-info-text-block">
                        <div class="card-info-text-title">
                            ДОСТАВКА
                        </div>
                        <div class="card-info-text-content">
                            <p>Для нових оптових покупців, перша доставка на склад компанії перевізника БЕЗКОШТОВНО, якщо сума замовлення більше 5000 грн. за оптовими цінами.</p>
                            <ul>
                                <li>Вартість доставки оплачується покупцем при отриманні товару згідно з тарифами служби доставки. Ваші замовлення доставляються компаніями експрес-доставки на вибір: Нова пошта, Укрпошта. Також є можливість доставки замовлень і іншими зручними для Вас способами. Можлива доставка кур’єром до дверей.</li>
                                <li>Доставка по м. Хмельницький:  на склад Нової пошти 1 кг від 50 грн. Можливий самовивіз з точок продажу. </li>
                                <li>Доставка здійснюється на протязі 1-3 днів, в залежності від обраного перевізника.</li>
                                <li>У зв’язку з війною доставка здійснюється у регіони України, де працюють логістичні компанії.</li>
                            </ul>
                            <p><b>Важливо!</b> Після того, як Ваше замовлення доставлять на відділення служби доставки у Вашому місті, Вам потрібно буде забрати його не більше ніж через 5 днів, інакше замовлення відправляється назад на склад магазин.</p>
                            <p>Ми гарантуємо, що ваша посилка буде відправлена ​​після підтвердження замовлення менеджером (менеджер вам передзвонить, щоб уточнити деталі замовлення) протягом 2 робочих днів з дня замовлення. Коли Ваше замовлення буде відправлено, Вам буде надіслано SMS повідомлення з номером декларації, по якому Ви зможете отримати свою посилку. </p>
                            <p>Якщо у Вас виникли питання по доставці замовлень з нашого інтернет магазину одягу, ми завжди готові на них відповісти.</p>
                        </div>
                    </div>
                    <div class="card-info-text-block">
                        <div class="card-info-text-title">
                            Оплата
                        </div>
                        <div class="card-info-text-content">
                            <ul>
                                <li>100% передоплата на платіжну карту Приват Банку. Оплату можна робити через термінали ПриватБанку, каси банку або систему Приват 24. Реквізити платіжної картки ми відсилаємо на Ваш E-MAIL або на телефон SMS повідомленням.</li>
                                <li>Накладений платіж можливий, якщо доставка здійснюється Новою поштою. Вартість доставки (повернення) коштів оплачується покупцем, відповідно до тарифів перевізника.</li>
                            </ul>
                            <p>Право вибору способу оплати замовлень залишається за покупцем інтернет магазину STIMMA.COM.UA</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-tabs-mobile-item">
                <div class="card-tabs-mobile-item-title">
                    ВІДГУКИ
                </div>
                <div class="card-tabs-mobile-item-cont">
                    <div class="reviews-empty">
                        Відгуків немає, поки що.
                    </div>
                    <div class="reviews-cont">
                        <div class="reviews-add-comment">
                            <a href="#" class="reviews-add-comment-btn">
                                Додати коментар
                            </a>
                        </div>
                        <div class="reviews-form">
                            <form>
                                <input type="hidden" name="reviews-id-product" value="<?=$arResult['ID']?>">
                                <div class="form-group group2">
                                    <div class="form-wrap">
                                        <div class="form-wrap-title">
                                            Ваше ім'я
                                            <span class="required">*</span>
                                        </div>
                                        <input type="text" name="name">
                                    </div>
                                    <div class="form-wrap">
                                        <div class="form-wrap-title">
                                            E-mail
                                        </div>
                                        <input type="text" name="email">
                                    </div>
                                </div>
                                <div class="form-wrap">
                                    <div class="form-wrap-title">
                                        Ваша оцінка
                                    </div>
                                    <div class="wrap-stars-cont">
                                        <div class="star-block">
                                            <input id="star5" name="star" type="radio" value="5">
                                            <label for="star5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star4" name="star" type="radio" value="4">
                                            <label for="star4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star3" name="star" type="radio" value="3">
                                            <label for="star3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star2" name="star" type="radio" value="2">
                                            <label for="star2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                            <input id="star1" name="star" type="radio" value="1">
                                            <label for="star1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                    <defs></defs>
                                                    <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="star-rating">
                                            Без оцінки
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrap">
                                    <div class="form-wrap-title">
                                        Коментар
                                    </div>
                                    <textarea name="comment"></textarea>
                                </div>
                                <div class="fort-wrap-btn-block">
                                    <button type="submit" name="send_review" class="fort-wrap-btn">ОПУБЛІКУВАТИ ВІДГУК</button>
                                </div>
                            </form>
                        </div>
                        <div class="reviews-list">

                                <?
                                foreach ($arResult['REVIEW'] as $index => $review)
                                {
                                    ?>
                                    <div class="reviews-item">
                                        <div class="reviews-item-head">
                                        <div class="reviews-item-name">
                                            <?=$review['NAME']?>
                                        </div>
                                        <div class="reviews-item-star">
                                            <?
                                            for ($i = 1; $i <= 5; $i++)
                                            {
                                                ?>
                                                <span class="<?=$i <= $review['PROPERTY_RATING_VALUE'] ? 'active' : ''?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                        <defs></defs>
                                                        <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                    </svg>
                                                </span>
                                                <?
                                            }
                                            ?>
                                        </div>
                                    </div>
                                        <div class="reviews-item-body">
                                        <?/*<div class="reviews-item-body-title">
                                            Комментарій
                                        </div>*/?>
                                        <div class="reviews-item-body-text">
                                            <?=$review['PREVIEW_TEXT']?>
                                        </div>
                                    </div>
                                    </div>
                                    <?
                                }
                                ?>


                        </div>
                    </div>
                </div>
            </div>
            <div class="card-tabs-mobile-item">
                <div class="card-tabs-mobile-item-title">
                    сертифікати
                </div>
                <div class="card-tabs-mobile-item-cont">
                    <div class="sertificate-cont">
		            	<div class="sertificate-item">
		            		<div class="sertificate-item-img">
		            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
		            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
		            			</a>
		            		</div>
		            		<div class="sertificate-item-name">
		            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
		            		</div>
		            	</div>
		            	<div class="sertificate-item">
		            		<div class="sertificate-item-img">
		            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
		            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
		            			</a>
		            		</div>
		            		<div class="sertificate-item-name">
		            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
		            		</div>
		            	</div>
		            	<div class="sertificate-item">
		            		<div class="sertificate-item-img">
		            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
		            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
		            			</a>
		            		</div>
		            		<div class="sertificate-item-name">
		            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
		            		</div>
		            	</div>
		            	<div class="sertificate-item">
		            		<div class="sertificate-item-img">
		            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
		            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
		            			</a>
		            		</div>
		            		<div class="sertificate-item-name">
		            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
		            		</div>
		            	</div>
		            	<div class="sertificate-item">
		            		<div class="sertificate-item-img">
		            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
		            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
		            			</a>
		            		</div>
		            		<div class="sertificate-item-name">
		            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
		            		</div>
		            	</div>
		            	<div class="sertificate-item">
		            		<div class="sertificate-item-img">
		            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
		            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
		            			</a>
		            		</div>
		            		<div class="sertificate-item-name">
		            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
		            		</div>
		            	</div>
		            	<div class="sertificate-item">
		            		<div class="sertificate-item-img">
		            			<a href="/bitrix/templates/aspro_max/images/sert1.png" class="fancybox">
		            				<img src="/bitrix/templates/aspro_max/images/sert1.png">
		            			</a>
		            		</div>
		            		<div class="sertificate-item-name">
		            			Сертифікат учасника 25 Міжнародного форуму товарів для дітей
		            		</div>
		            	</div>
		            </div>
                </div>
            </div>
            <div class="card-tabs-mobile-item">
                <div class="card-tabs-mobile-item-title">
                    <?=LANGUAGE_ID == 'ua' ? 'Розмірна сітка' : 'Разметрная сетка'?>
                </div>
                <div class="card-tabs-mobile-item-cont">
                    <div class="dimensional-info">
				  		<div class="dimensional-info-cont">
			  				<div class="dimensional-info-h1">
			  					ЯК ПРАВИЛЬНО ВИМІРЯТИ?
			  				</div>
			  				<div class="dimensional-info-semi-t">Щоб вибрати правильний розмір, необхідно зняти такі мірки:</div>
			  				<div class="dimensional-info-img-cont">
				  				<img src="/bitrix/templates/aspro_max/images/size1.png">
				  				<div class="dimensional-info-right-img">
				  					<img src="/bitrix/templates/aspro_max/images/Leaf1.png">
				  				</div>
			  				</div>
			  				<div class="dimensional-info-text">
			  					<div class="dimensional-info-text-title">
			  						1. ОБХВАТ ГРУДЕЙ
			  					</div>
			  					<div class="dimensional-info-text-cont">
			  						Виміряйте свій обхват грудей за допомогою сантиметрової стрічки, провівши її під пахвами і по самій виступаючій частині Необхідно, щоб мірна стрічка прилягала до тіла і була паралельна до землі.
			  					</div>
			  				</div>
			  				<div class="dimensional-info-text">
			  					<div class="dimensional-info-text-title">
			  						2. ОБХВАТ ТАЛІЇ
			  					</div>
			  					<div class="dimensional-info-text-cont">
			  						Щоб виміряти обхват талії, спочатку підніміть або зніміть сорочку, потім встаньте прямо і видихніть. У цьому положенні тримайте край мірної стрічки на пупці і оберніть її навколо найвужчої частини талії. Переконайтеся, що мірна стрічка щільно прилягала до тіла і паралельна до землі.
			  					</div>
			  				</div>
			  				<div class="dimensional-info-text">
			  					<div class="dimensional-info-text-title">
			  						3. ОБХВАТ СТЕГОН
			  					</div>
			  					<div class="dimensional-info-text-cont">
			  						Поставте ноги разом і оберніть навколо своїх стегон сантиметрову стрічку, провівши її по точках сідниць, що найбільш виступають. Мірна стрічка повинна бути паралельною до землі та щільно прилягати до тіла.
			  					</div>
			  				</div>
				  		</div>
				  		<div class="dimensional-info-gen">
				  			<div class="dimensional-info-gen-title">
				  				ЖІНОЧИЙ ОДЯГ
				  			</div>
				  			<div class="dimensional-info-gen-table-cont">
				  				<div class="dimensional-info-gen-table-title">
				  					Кофти, топи, блузи, верхній одяг
				  				</div>
				  				<div class="dimensional-info-gen-table">
				  					<table>
				  						<tr>
				  							<th colspan="2">розмір</th>
				  							<th>Обхват грудей</th>
				  							<th>Обхват талії</th>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  					</table>
				  				</div>
				  			</div>
				  			<div class="dimensional-info-gen-table-cont">
				  				<div class="dimensional-info-gen-table-title">
				  					Штани, шорти, спідниці
				  				</div>
				  				<div class="dimensional-info-gen-table">
				  					<table>
				  						<tr>
				  							<th colspan="2">розмір</th>
				  							<th>Обхват грудей</th>
				  							<th>Обхват талії</th>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  					</table>
				  				</div>
				  			</div>
				  			<div class="dimensional-info-gen-table-cont">
				  				<div class="dimensional-info-gen-table-title">
				  					СУКНІ
				  				</div>
				  				<div class="dimensional-info-gen-table">
				  					<table>
				  						<tr>
				  							<th colspan="2">розмір</th>
				  							<th>Обхват грудей</th>
				  							<th>Обхват талії</th>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>40</b>
				  							</td>
				  							<td>
				  								<b>XS</b>
				  							</td>
				  							<td>
				  								80 - 84
				  							</td>
				  							<td>
				  								62 - 66
				  							</td>
				  						</tr>
				  					</table>
				  				</div>
				  			</div>
				  		</div>
				  		<div class="dimensional-info-gen">
				  			<div class="dimensional-info-gen-title">
				  				ДИТЯЧИЙ ОДЯГ
				  			</div>
				  			<div class="dimensional-info-gen-table-cont">
				  				<div class="dimensional-info-gen-table-title">
				  					ДЛЯ ДІВЧАТОК
				  				</div>
				  				<div class="dimensional-info-gen-table">
				  					<table>
				  						<tr>
				  							<th>РОЗМІР (РІСТ)</th>
				  							<th>110</th>
				  							<th>116</th>
				  							<th>122</th>
				  							<th>128</th>
				  							<th>134</th>
				  							<th>140</th>
				  							<th>146</th>
				  							<th>152</th>
				  							<th>158</th>
				  							<th>164</th>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>ОБХВАТ ГРУДЕЙ</b>
				  							</td>
				  							<td>58</td>
				  							<td>60</td>
				  							<td>62</td>
				  							<td>64</td>
				  							<td>66</td>
				  							<td>68</td>
				  							<td>72</td>
				  							<td>76</td>
				  							<td>80</td>
				  							<td>84</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>ОБХВАТ ГРУДЕЙ</b>
				  							</td>
				  							<td>58</td>
				  							<td>60</td>
				  							<td>62</td>
				  							<td>64</td>
				  							<td>66</td>
				  							<td>68</td>
				  							<td>72</td>
				  							<td>76</td>
				  							<td>80</td>
				  							<td>84</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>ОБХВАТ ГРУДЕЙ</b>
				  							</td>
				  							<td>58</td>
				  							<td>60</td>
				  							<td>62</td>
				  							<td>64</td>
				  							<td>66</td>
				  							<td>68</td>
				  							<td>72</td>
				  							<td>76</td>
				  							<td>80</td>
				  							<td>84</td>
				  						</tr>
				  					</table>
				  				</div>
				  			</div>
				  			<div class="dimensional-info-gen-table-cont">
				  				<div class="dimensional-info-gen-table-title">
				  					ДЛЯ ХЛОПЧИКІВ
				  				</div>
				  				<div class="dimensional-info-gen-table">
				  					<table>
				  						<tr>
				  							<th>РОЗМІР (РІСТ)</th>
				  							<th>110</th>
				  							<th>116</th>
				  							<th>122</th>
				  							<th>128</th>
				  							<th>134</th>
				  							<th>140</th>
				  							<th>146</th>
				  							<th>152</th>
				  							<th>158</th>
				  							<th>164</th>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>ОБХВАТ ГРУДЕЙ</b>
				  							</td>
				  							<td>58</td>
				  							<td>60</td>
				  							<td>62</td>
				  							<td>64</td>
				  							<td>66</td>
				  							<td>68</td>
				  							<td>72</td>
				  							<td>76</td>
				  							<td>80</td>
				  							<td>84</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>ОБХВАТ ГРУДЕЙ</b>
				  							</td>
				  							<td>58</td>
				  							<td>60</td>
				  							<td>62</td>
				  							<td>64</td>
				  							<td>66</td>
				  							<td>68</td>
				  							<td>72</td>
				  							<td>76</td>
				  							<td>80</td>
				  							<td>84</td>
				  						</tr>
				  						<tr>
				  							<td>
				  								<b>ОБХВАТ ГРУДЕЙ</b>
				  							</td>
				  							<td>58</td>
				  							<td>60</td>
				  							<td>62</td>
				  							<td>64</td>
				  							<td>66</td>
				  							<td>68</td>
				  							<td>72</td>
				  							<td>76</td>
				  							<td>80</td>
				  							<td>84</td>
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

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>