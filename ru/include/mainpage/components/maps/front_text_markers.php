<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
}?>
<?
{
	$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 12, 'ACTIVE' => "Y"]);
	$arMaps = $sections = $corrds = [];
	$center = false;
	while ($record = $res -> GetNextElement())
	{
		$fields = $record -> GetFields();
		$props = $record -> GetProperties();
		$arMaps[$fields['ID']] = $fields;
		$arMaps[$fields['ID']]['PROPERTIES'] = $props;

		$sections[$fields['IBLOCK_SECTION_ID']] = $fields['IBLOCK_SECTION_ID'];

		if(!$center) $center = $props['MAP']['VALUE'];
		$corrds[$fields['ID']] = ['coords' => $props['MAP']['VALUE'], 'html' => ''];
	}

	if(!empty($sections))
	{
		$res = CIBlockSection::GetList([], ['ID' => $sections]);
		while ($record = $res -> Fetch())
			$sections[$record['ID']] = $record;
	}
	?>
	<link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
	<script src = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>

	<div class="content_wrapper_block map_type_2 front_map2">
		<div class="maxwidth-theme">
			<div class="wrapper_block with_title title_left">
				<div class="top_block tb15">
					<h3><?=LANGUAGE_ID == 'ua' ? 'Адреси магазинів' : 'Адреса магазинов'?></h3>
					<a href="<?=LANGUAGE_ID == 'ru' ? '/ru' : ''?>/contacts/stores/" class="pull-right font_upper muted"><?=LANGUAGE_ID == 'ua' ? 'Перейти в розділ' : 'Перейти в раздел'?></a>
				</div>
				<div class="block_container bordered ">
					<div class="items scrollblock">
						<div class="items-inner">
							<?
							foreach ($arMaps as $index => $arItem)
							{
								if(!$arItem['PROPERTIES']['MAP']['VALUE']) continue;
								$lotlan = explode(',',$arItem['PROPERTIES']['MAP']['VALUE']);
								?>
								<div class="item corrds" data-coord1="<?=trim($lotlan[0])?>" data-coord2="<?=trim($lotlan[1])?>" data-id="<?=$arItem['ID']?>">
									<div class="title option-font-bold font_sm"><?=$sections[$arItem['IBLOCK_SECTION_ID']]['NAME']?>, <?=$arItem['NAME']?>, <?=$arItem['PROPERTIES']['ADDRESS']['VALUE']?></div>
									<div class="phones">
										<?
										foreach ($arItem['PROPERTIES']['PHONE']["VALUE"] as $indexPhone => $valuePhone)
										{
											?>
											<div class="value">
												<a class="muted font_xs" rel="nofollow" href="tel:<?=str_replace(['+','-',' '], ['','',''],$valuePhone)?>"><?=$valuePhone?></a>
											</div>
											<?
										}
										?>

									</div>
								</div>
								<?
							}
							?>
						</div>
					</div>
					<?/*
                    <div class="detail_items scrollblock">
                        <div class="item" data-coordinates="55.7556721,37.6076172" data-id="74">
                            <div class="map_info_store"><div class="title option-font-bold font_mlg"><a class="dark_link" href="/ru/contacts/stores/74/">г. Москва, ул. Большая, 7/10</a></div><div class="properties"><div class="property schedule"><div class="title-prop font_upper muted">Метро</div><div class="value"><div class="metro"><i></i>Охотный ряд</div></div></div><div class="property schedule"><div class="title-prop font_upper muted">Режим работы</div><div class="value">Пн - Пт: 9.00 - 18.00<br>Сб - Вс: выходные</div></div><div class="property phone"><div class="title-prop font_upper muted">Телефон</div><div class="value"><a class="dark_link" rel="nofollow" href="tel:+70000000000">+7 000 000-00-00</a></div></div><div class="property email"><div class="title-prop font_upper muted">E-mail</div><div class="value"><a class="dark_link" href="mailto:info@site.ru">info@site.ru</a></div></div></div></div>						<div class="top-close muted svg">
                                <svg class="svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" class="cls-1" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"></path></svg>
                            </div>
                            <div class="buttons_block">
                                <span class="btn btn-transparent-border-color btn-xs animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question">Написать сообщение							</span>
                            </div>
                        </div>
                        <div class="item" data-coordinates="55.753283896217,37.649945238342" data-id="75">
                            <div class="map_info_store"><div class="title option-font-bold font_mlg"><a class="dark_link" href="/ru/contacts/stores/75/">г. Москва, ул. Охотный Ряд, 2</a></div><div class="properties"><div class="property schedule"><div class="title-prop font_upper muted">Метро</div><div class="value"><div class="metro"><i></i>Театральная</div></div></div><div class="property schedule"><div class="title-prop font_upper muted">Режим работы</div><div class="value">Пн - Пт: 9.00 - 18.00<br>Сб - Вс: выходные</div></div><div class="property phone"><div class="title-prop font_upper muted">Телефон</div><div class="value"><a class="dark_link" rel="nofollow" href="tel:+70000000000">+7 000 000-00-00</a></div></div><div class="property email"><div class="title-prop font_upper muted">E-mail</div><div class="value"><a class="dark_link" href="mailto:info@site.ru">info@site.ru</a></div></div></div></div>						<div class="top-close muted svg">
                                <svg class="svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" class="cls-1" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"></path></svg>
                            </div>
                            <div class="buttons_block">
                                <span class="btn btn-transparent-border-color btn-xs animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question">Написать сообщение							</span>
                            </div>
                        </div>
                        <div class="item" data-coordinates="59.9341886,30.3322913" data-id="76">
                            <div class="map_info_store"><div class="title option-font-bold font_mlg"><a class="dark_link" href="/ru/contacts/stores/76/">г. Санкт-Петербург, Невский проспект, 35</a></div><div class="properties"><div class="property schedule"><div class="title-prop font_upper muted">Метро</div><div class="value"><div class="metro"><i></i>Алексеевская</div></div></div><div class="property schedule"><div class="title-prop font_upper muted">Режим работы</div><div class="value">Пн - Пт: 9.00 - 18.00<br>Сб - Вс: выходные</div></div><div class="property phone"><div class="title-prop font_upper muted">Телефон</div><div class="value"><a class="dark_link" rel="nofollow" href="tel:+70000000000">+7 000 000-00-00</a></div></div><div class="property email"><div class="title-prop font_upper muted">E-mail</div><div class="value"><a class="dark_link" href="mailto:info@site.ru">info@site.ru</a></div></div></div></div>						<div class="top-close muted svg">
                                <svg class="svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" class="cls-1" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"></path></svg>
                            </div>
                            <div class="buttons_block">
                                <span class="btn btn-transparent-border-color btn-xs animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question">Написать сообщение							</span>
                            </div>
                        </div>
                        <div class="item" data-coordinates="56.809912905019,60.586228362305" data-id="77">
                            <div class="map_info_store"><div class="title option-font-bold font_mlg"><a class="dark_link" href="/ru/contacts/stores/77/">г. Екатеринбург, пр. Ленина, 12</a></div><div class="properties"><div class="property schedule"><div class="title-prop font_upper muted">Режим работы</div><div class="value">Пн - Пт: 9.00 - 18.00<br>Сб - Вс: выходные</div></div><div class="property phone"><div class="title-prop font_upper muted">Телефон</div><div class="value"><a class="dark_link" rel="nofollow" href="tel:+70000000000">+7 000 000-00-00</a></div></div><div class="property email"><div class="title-prop font_upper muted">E-mail</div><div class="value"><a class="dark_link" href="mailto:info@site.ru	">info@site.ru	</a></div></div></div></div>						<div class="top-close muted svg">
                                <svg class="svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" class="cls-1" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"></path></svg>
                            </div>
                            <div class="buttons_block">
                                <span class="btn btn-transparent-border-color btn-xs animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question">Написать сообщение							</span>
                            </div>
                        </div>
                        <div class="item" data-coordinates="55.1658934,61.4363811" data-id="78">
                            <div class="map_info_store"><div class="title option-font-bold font_mlg"><a class="dark_link" href="/ru/contacts/stores/78/">г. Челябинск, ул. Артиллерийская, 11</a></div><div class="properties"><div class="property schedule"><div class="title-prop font_upper muted">Режим работы</div><div class="value">Пн - Пт: 9.00 - 18.00<br>Сб - Вс: выходные</div></div><div class="property phone"><div class="title-prop font_upper muted">Телефон</div><div class="value"><a class="dark_link" rel="nofollow" href="tel:+70000000000">+7 000 000-00-00</a></div></div><div class="property email"><div class="title-prop font_upper muted">E-mail</div><div class="value"><a class="dark_link" href="mailto:info@site.ru">info@site.ru</a></div></div></div></div>						<div class="top-close muted svg">
                                <svg class="svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" class="cls-1" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"></path></svg>
                            </div>
                            <div class="buttons_block">
                                <span class="btn btn-transparent-border-color btn-xs animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question">Написать сообщение							</span>
                            </div>
                        </div>
                        <div class="item" data-coordinates="55.1658934,61.4363812" data-id="79">
                            <div class="map_info_store"><div class="title option-font-bold font_mlg"><a class="dark_link" href="/ru/contacts/stores/78/">г. Челябинск, ул. Артиллерийская, 11</a></div><div class="properties"><div class="property schedule"><div class="title-prop font_upper muted">Режим работы</div><div class="value">Пн - Пт: 9.00 - 18.00<br>Сб - Вс: выходные</div></div><div class="property phone"><div class="title-prop font_upper muted">Телефон</div><div class="value"><a class="dark_link" rel="nofollow" href="tel:+70000000000">+7 000 000-00-00</a></div></div><div class="property email"><div class="title-prop font_upper muted">E-mail</div><div class="value"><a class="dark_link" href="mailto:info@site.ru">info@site.ru</a></div></div></div></div>						<div class="top-close muted svg">
                                <svg class="svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" class="cls-1" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"></path></svg>
                            </div>
                            <div class="buttons_block">
                                <span class="btn btn-transparent-border-color btn-xs animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question">Написать сообщение							</span>
                            </div>
                        </div>
                        <div class="item" data-coordinates="55.1658934,61.4363813" data-id="80">
                            <div class="map_info_store"><div class="title option-font-bold font_mlg"><a class="dark_link" href="/ru/contacts/stores/78/">г. Челябинск, ул. Артиллерийская, 11</a></div><div class="properties"><div class="property schedule"><div class="title-prop font_upper muted">Режим работы</div><div class="value">Пн - Пт: 9.00 - 18.00<br>Сб - Вс: выходные</div></div><div class="property phone"><div class="title-prop font_upper muted">Телефон</div><div class="value"><a class="dark_link" rel="nofollow" href="tel:+70000000000">+7 000 000-00-00</a></div></div><div class="property email"><div class="title-prop font_upper muted">E-mail</div><div class="value"><a class="dark_link" href="mailto:info@site.ru">info@site.ru</a></div></div></div></div>						<div class="top-close muted svg">
                                <svg class="svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" class="cls-1" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"></path></svg>
                            </div>
                            <div class="buttons_block">
                                <span class="btn btn-transparent-border-color btn-xs animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question">Написать сообщение							</span>
                            </div>
                        </div>
                        <div class="item" data-coordinates="55.1658934,61.4363814" data-id="81">
                            <div class="map_info_store"><div class="title option-font-bold font_mlg"><a class="dark_link" href="/ru/contacts/stores/78/">г. Челябинск, ул. Артиллерийская, 11</a></div><div class="properties"><div class="property schedule"><div class="title-prop font_upper muted">Режим работы</div><div class="value">Пн - Пт: 9.00 - 18.00<br>Сб - Вс: выходные</div></div><div class="property phone"><div class="title-prop font_upper muted">Телефон</div><div class="value"><a class="dark_link" rel="nofollow" href="tel:+70000000000">+7 000 000-00-00</a></div></div><div class="property email"><div class="title-prop font_upper muted">E-mail</div><div class="value"><a class="dark_link" href="mailto:info@site.ru">info@site.ru</a></div></div></div></div>						<div class="top-close muted svg">
                                <svg class="svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" class="cls-1" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"></path></svg>
                            </div>
                            <div class="buttons_block">
                                <span class="btn btn-transparent-border-color btn-xs animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question">Написать сообщение							</span>
                            </div>
                        </div>
                    </div>
                    */?>
				</div>
			</div>

			<div class="contacts_map_list">
				<div class="contacts_map bordered">
					<!--'start_frame_cache_shops-map-block'-->
					<div class="bx-yandex-view-layout swipeignore">
						<div class="bx-yandex-view-map">


							<div id="sample" class="bx-yandex-map" style="height: 498px; width: 100%;">загрузка карты...</div>	</div>
						<div class="yandex-map__mobile-opener"></div>
					</div>
					<!--'end_frame_cache_shops-map-block'-->		</div>
			</div>
		</div>
	</div>


	<script>
		$(document).ready(function()
		{
			var mapOptions = {
				center: [<?=$center?>],
				zoom: 15
			}
			var map = new L.map('sample', mapOptions);

			var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
			map.addLayer(layer);

			<?
			foreach ($corrds as $index => $corrd)
			{
			?>
			var marker<?=$index?> = new L.Marker([<?=$corrd['coords']?>]);
			marker<?=$index?>.addTo(map);
			//marker<?=$index?>.bindPopup(<?=$corrd['html']?>);
			<?
			}
			?>


			$(document).on('click', '.corrds.item', function()
			{
				coord1 = parseFloat($(this).attr('data-coord1'));
				coord2 = parseFloat($(this).attr('data-coord2'));
				var latLon = L.latLng(coord1,coord2);
				console.log(coord1);
				console.log(coord2);
				map.panTo(latLon);
				map.setZoom(15);
			})

			/*map.on("click", function(e){
                new L.Marker([e.latlng.lat, e.latlng.lng]).addTo(map);
            })*/
		})

	</script>
	<?
}
?>



<?/*$APPLICATION->IncludeComponent(
	"aspro:wrapper.block.max",
	"front_map",
	Array(
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CONVERT_CURRENCY" => "N",
		"DISPLAY_COMPARE" => "Y",
		"DISPLAY_WISH_BUTTONS" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"ELEMENT_COUNT" => "30",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arRegionality",
		"FILTER_PROP_CODE" => "",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_TYPE" => "aspro_max_content",
		"IBLOCK_ID" => "12",
		"INCLUDE_SUBSECTIONS" => "Y",
		"TITLE_BLOCK" => "Адреса магазинов",
		"TITLE_BLOCK_DETAIL_NAME" => "Наши магазины",
		"TITLE_BLOCK_ALL" => "Перейти в раздел",
		"ALL_URL" => "contacts/stores/",
	)
);*/?>