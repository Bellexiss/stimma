$(document).ready(function()
{
	if(location.href.indexOf('/ru/') == -1)
	{
		$.datepicker.regional['ua'] = {
			closeText: 'Закрити',
			prevText: 'Попередній',
			nextText: 'Наступний',
			currentText: 'Сьогодні',
			monthNames: ['Січень','Лютий','Березень','Квітень','Травень','Червень','Липень','Серпень','Вересень','Жовтень','Листопад','Грудень'],
			monthNamesShort: ['Січ','Лют','Бер','Кві','Тра','Чер','Лип','Сер','Вер','Жов','Лис','Гру'],
			dayNames: ['неділя','понеділок','вівторок','середа','четвер','пятниця','субота'],
			dayNamesShort: ['нед','пнд','втр','срд','чтв','птн','сбт'],
			dayNamesMin: ['Нд','Пн','Вт','Ср','Чт','Пт','Сб'],
			weekHeader: 'Не',
			dateFormat: 'dd.mm.yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
		$.datepicker.setDefaults($.datepicker.regional['ua']);
	}
	else
	{
		$.datepicker.regional['ru'] = {
			closeText: 'Закрыть',
			prevText: 'Предыдущий',
			nextText: 'Следующий',
			currentText: 'Сегодня',
			monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
			monthNamesShort: ['Янв','Фев','Март','Апр','Май','Июнь','Июль','Авг','Сен','Окт','Ноя','Дек'],
			dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
			dayNamesShort: ['вс','пн','вт','ср','чт','пт','сб'],
			dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
			weekHeader: 'Не',
			dateFormat: 'dd.mm.yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
		$.datepicker.setDefaults($.datepicker.regional['ru']);
	}



	$('#sertnphone').inputmask('mask', {'mask': '+380 (99) 999-99-99'});
	$('#sertdate').datepicker(
		{
			weekstart:0,
			dateFormat: 'dd.mm.yy',
			minDate:'today'
		}
	);

	$(document).on('change','[name=sertificate_phone_fake]',function()
	{
		$('[name=sertificate_phone]').val($(this).val());
		console.log($(this).val());
		console.log($('[name=sertificate_phone]').val());
	})
})

function initChooseCity()
{

	$('input#soa-property-2, input#soa-property-5, input#soa-property-7, input#soa-property-4, input#soa-property-25').hide();
	console.log('initChooseCity');
	valueEmail = $('input#soa-property-2').val();
	if(valueEmail != '')
		$('input#soa-property-2').val(valueEmail);
	else
		$('input#soa-property-2').val('test@email.ua');

	console.log('valueEmail');
	console.log(valueEmail);

	$('[name=ORDER_PROP_5]').val('');
	$('[name=ORDER_PROP_4]').val('');
	$('[name=ORDER_PROP_7]').val('');
	$('[name=ORDER_PROP_25]').val('');

	if(!$('[name=fake_email]').length )$('input#soa-property-2').closest('div').append('<input type="text" name="fake_email" autocomplete="email" placeholder="Email" class="form-control bx-soa-customer-input bx-ios-fix">');

	if(!$('[name=choose_city_np]').length) $('input#soa-property-5').closest('div').append('<select name="choose_city_np"></select>');
	if(!$('[name=choose_city_np_vid]').length) $('input#soa-property-7').closest('div').append('<select name="choose_city_np_vid"></select>');

	if(!$('[name=choose_city_np]').length) $('input#soa-property-4').closest('div').append('<select name="choose_city_np"></select>');
	if(!$('[name=choose_city_np_vid]').length) $('input#soa-property-25').closest('div').append('<select name="choose_city_np_vid"></select>');

	if($('[name="choose_city_np_vid"]').length)$('[name="choose_city_np_vid"]').select2();

	whereUrl = 'get_city_np.php';
	if($('#ID_DELIVERY_ID_5').prop('checked') || $('#ID_DELIVERY_ID_14').prop('checked'))
		whereUrl = 'get_city_np.php';
	else if($('#ID_DELIVERY_ID_6').prop('checked') || $('#ID_DELIVERY_ID_15').prop('checked'))
		whereUrl = 'get_city_ukr.php';

	if($('[name="choose_city_np"]').length)
	$('[name="choose_city_np"]').select2({
		width: '100%',
		ajax: {
			url: "/ajax/" + whereUrl,
			dataType: 'json',
			delay: 500,
			data: function(params)
			{
				return {
					name: params.term, // search term
					page: params.page,
					action: 'searchAddress',
					url:location.href
				};
			},

			cache: true
		},
		minimumInputLength: 2,
	});
}

BX.saleOrderAjax = { // bad solution, actually, a singleton at the page

	BXCallAllowed: false,

	options: {},
	indexCache: {},
	controls: {},

	modes: {},
	properties: {},

	// called once, on component load
	init: function(options)
	{
		var ctx = this;
		this.options = options;

		window.submitFormProxy = BX.proxy(function(){
			ctx.submitFormProxy.apply(ctx, arguments);
		}, this);

		BX(function(){
			ctx.initDeferredControl();
		});
		BX(function(){
			ctx.BXCallAllowed = true; // unlock form refresher
		});

		this.controls.scope = BX('bx-soa-order');

		// user presses "add location" when he cannot find location in popup mode
		BX.bindDelegate(this.controls.scope, 'click', {className: '-bx-popup-set-mode-add-loc'}, function(){

			var input = BX.create('input', {
				attrs: {
					type: 'hidden',
					name: 'PERMANENT_MODE_STEPS',
					value: '1'
				}
			});

			BX.prepend(input, BX('bx-soa-order'));

			ctx.BXCallAllowed = false;
			BX.Sale.OrderAjaxComponent.sendRequest();
		});
	},

	cleanUp: function(){

		for(var k in this.properties)
		{
			if (this.properties.hasOwnProperty(k))
			{
				if(typeof this.properties[k].input != 'undefined')
				{
					BX.unbindAll(this.properties[k].input);
					this.properties[k].input = null;
				}

				if(typeof this.properties[k].control != 'undefined')
					BX.unbindAll(this.properties[k].control);
			}
		}

		this.properties = {};
	},

	addPropertyDesc: function(desc){
		this.properties[desc.id] = desc.attributes;
		this.properties[desc.id].id = desc.id;
	},

	// called each time form refreshes
	initDeferredControl: function()
	{
		var ctx = this,
			k,
			row,
			input,
			locPropId,
			m,
			control,
			code,
			townInputFlag,
			adapter;

		// first, init all controls
		if(typeof window.BX.locationsDeferred != 'undefined'){

			this.BXCallAllowed = false;

			for(k in window.BX.locationsDeferred){

				window.BX.locationsDeferred[k].call(this);
				window.BX.locationsDeferred[k] = null;
				delete(window.BX.locationsDeferred[k]);

				this.properties[k].control = window.BX.locationSelectors[k];
				delete(window.BX.locationSelectors[k]);
			}
		}

		for(k in this.properties){

			// zip input handling
			if(this.properties[k].isZip){
				row = this.controls.scope.querySelector('[data-property-id-row="'+k+'"]');
				if(BX.type.isElementNode(row)){

					input = row.querySelector('input[type="text"]');
					if(BX.type.isElementNode(input)){
						this.properties[k].input = input;

						// set value for the first "location" property met
						locPropId = false;
						for(m in this.properties){
							if(this.properties[m].type == 'LOCATION'){
								locPropId = m;
								break;
							}
						}

						if(locPropId !== false){
							BX.bindDebouncedChange(input, function(value){

								var zipChangedNode = BX('ZIP_PROPERTY_CHANGED');
								zipChangedNode && (zipChangedNode.value = 'Y');

								input = null;
								row = null;

								if(BX.type.isNotEmptyString(value) && /^\s*\d+\s*$/.test(value) && value.length > 3){

									ctx.getLocationsByZip(value, function(locationsData){
										ctx.properties[locPropId].control.setValueByLocationIds(locationsData);
									}, function(){
										try{
											// ctx.properties[locPropId].control.clearSelected();
										}catch(e){}
									});
								}
							});
						}
					}
				}
			}

			// location handling, town property, etc...
			if(this.properties[k].type == 'LOCATION')
			{

				if(typeof this.properties[k].control != 'undefined'){

					control = this.properties[k].control; // reference to sale.location.selector.*
					code = control.getSysCode();

					// we have town property (alternative location)
					if(typeof this.properties[k].altLocationPropId != 'undefined')
					{
						if(code == 'sls') // for sale.location.selector.search
						{
							// replace default boring "nothing found" label for popup with "-bx-popup-set-mode-add-loc" inside
							control.replaceTemplate('nothing-found', this.options.messages.notFoundPrompt);
						}

						if(code == 'slst')  // for sale.location.selector.steps
						{
							(function(k, control){

								// control can have "select other location" option
								control.setOption('pseudoValues', ['other']);

								// insert "other location" option to popup
								control.bindEvent('control-before-display-page', function(adapter){

									control = null;

									var parentValue = adapter.getParentValue();

									// you can choose "other" location only if parentNode is not root and is selectable
									if(parentValue == this.getOption('rootNodeValue') || !this.checkCanSelectItem(parentValue))
										return;

									var controlInApater = adapter.getControl();

									if(typeof controlInApater.vars.cache.nodes['other'] == 'undefined')
									{
										controlInApater.fillCache([{
											CODE:		'other', 
											DISPLAY:	ctx.options.messages.otherLocation, 
											IS_PARENT:	false,
											VALUE:		'other'
										}], {
											modifyOrigin:			true,
											modifyOriginPosition:	'prepend'
										});
									}
								});

								townInputFlag = BX('LOCATION_ALT_PROP_DISPLAY_MANUAL['+parseInt(k)+']');

								control.bindEvent('after-select-real-value', function(){

									// some location chosen
									if(BX.type.isDomNode(townInputFlag))
										townInputFlag.value = '0';
								});
								control.bindEvent('after-select-pseudo-value', function(){

									// option "other location" chosen
									if(BX.type.isDomNode(townInputFlag))
										townInputFlag.value = '1';
								});

								// when user click at default location or call .setValueByLocation*()
								control.bindEvent('before-set-value', function(){
									if(BX.type.isDomNode(townInputFlag))
										townInputFlag.value = '0';
								});

								// restore "other location" label on the last control
								if(BX.type.isDomNode(townInputFlag) && townInputFlag.value == '1'){

									// a little hack: set "other location" text display
									adapter = control.getAdapterAtPosition(control.getStackSize() - 1);

									if(typeof adapter != 'undefined' && adapter !== null)
										adapter.setValuePair('other', ctx.options.messages.otherLocation);
								}

							})(k, control);
						}
					}
				}
			}
		}

		this.BXCallAllowed = true;

		//set location initialized flag and refresh region & property actual content
		if (BX.Sale.OrderAjaxComponent)
			BX.Sale.OrderAjaxComponent.locationsCompletion();
	},

	checkMode: function(propId, mode){

		//if(typeof this.modes[propId] == 'undefined')
		//	this.modes[propId] = {};

		//if(typeof this.modes[propId] != 'undefined' && this.modes[propId][mode])
		//	return true;

		if(mode == 'altLocationChoosen'){

			if(this.checkAbility(propId, 'canHaveAltLocation')){

				var input = this.getInputByPropId(this.properties[propId].altLocationPropId);
				var altPropId = this.properties[propId].altLocationPropId;

				if(input !== false && input.value.length > 0 && !input.disabled && this.properties[altPropId].valueSource != 'default'){

					//this.modes[propId][mode] = true;
					return true;
				}
			}
		}

		return false;
	},

	checkAbility: function(propId, ability){

		if(typeof this.properties[propId] == 'undefined')
			this.properties[propId] = {};

		if(typeof this.properties[propId].abilities == 'undefined')
			this.properties[propId].abilities = {};

		if(typeof this.properties[propId].abilities != 'undefined' && this.properties[propId].abilities[ability])
			return true;

		if(ability == 'canHaveAltLocation'){

			if(this.properties[propId].type == 'LOCATION'){

				// try to find corresponding alternate location prop
				if(typeof this.properties[propId].altLocationPropId != 'undefined' && typeof this.properties[this.properties[propId].altLocationPropId]){

					var altLocPropId = this.properties[propId].altLocationPropId;

					if(typeof this.properties[propId].control != 'undefined' && this.properties[propId].control.getSysCode() == 'slst'){

						if(this.getInputByPropId(altLocPropId) !== false){
							this.properties[propId].abilities[ability] = true;
							return true;
						}
					}
				}
			}

		}

		return false;
	},

	getInputByPropId: function(propId){
		if(typeof this.properties[propId].input != 'undefined')
			return this.properties[propId].input;

		var row = this.getRowByPropId(propId);
		if(BX.type.isElementNode(row)){
			var input = row.querySelector('input[type="text"]');
			if(BX.type.isElementNode(input)){
				this.properties[propId].input = input;
				return input;
			}
		}

		return false;
	},

	getRowByPropId: function(propId){

		if(typeof this.properties[propId].row != 'undefined')
			return this.properties[propId].row;

		var row = this.controls.scope.querySelector('[data-property-id-row="'+propId+'"]');
		if(BX.type.isElementNode(row)){
			this.properties[propId].row = row;
			return row;
		}

		return false;
	},

	getAltLocPropByRealLocProp: function(propId){
		if(typeof this.properties[propId].altLocationPropId != 'undefined')
			return this.properties[this.properties[propId].altLocationPropId];

		return false;
	},

	toggleProperty: function(propId, way, dontModifyRow){

		var prop = this.properties[propId];

		if(typeof prop.row == 'undefined')
			prop.row = this.getRowByPropId(propId);

		if(typeof prop.input == 'undefined')
			prop.input = this.getInputByPropId(propId);

		if(!way){
			if(!dontModifyRow)
				BX.hide(prop.row);
			prop.input.disabled = true;
		}else{
			if(!dontModifyRow)
				BX.show(prop.row);
			prop.input.disabled = false;
		}
	},

	submitFormProxy: function(item, control)
	{
		var propId = false;
		for(var k in this.properties){
			if(typeof this.properties[k].control != 'undefined' && this.properties[k].control == control){
				propId = k;
				break;
			}
		}

		// turning LOCATION_ALT_PROP_DISPLAY_MANUAL on\off

		if(item != 'other'){

			if(this.BXCallAllowed){

				this.BXCallAllowed = false;
				setTimeout(function(){BX.Sale.OrderAjaxComponent.sendRequest()}, 20);
			}

		}
	},

	getPreviousAdapterSelectedNode: function(control, adapter){

		var index = adapter.getIndex();
		var prevAdapter = control.getAdapterAtPosition(index - 1);

		if(typeof prevAdapter !== 'undefined' && prevAdapter != null){
			var prevValue = prevAdapter.getControl().getValue();

			if(typeof prevValue != 'undefined'){
				var node = control.getNodeByValue(prevValue);

				if(typeof node != 'undefined')
					return node;

				return false;
			}
		}

		return false;
	},
	getLocationsByZip: function(value, successCallback, notFoundCallback)
	{
		if(typeof this.indexCache[value] != 'undefined')
		{
			successCallback.apply(this, [this.indexCache[value]]);
			return;
		}

		var ctx = this;

		BX.ajax({
			url: this.options.source,
			method: 'post',
			dataType: 'json',
			async: true,
			processData: true,
			emulateOnload: true,
			start: true,
			data: {'ACT': 'GET_LOCS_BY_ZIP', 'ZIP': value},
			//cache: true,
			onsuccess: function(result){
				if(result.result)
				{
					ctx.indexCache[value] = result.data;
					successCallback.apply(ctx, [result.data]);
				}
				else
				{
					notFoundCallback.call(ctx);
				}
			},
			onfailure: function(type, e){
				// on error do nothing
			}
		});
	}
};



$(document).ready(function()
{
	initChooseCity();

	$(document).on('change', '[name=choose_city_np]', function()
	{
		value = $(this).find('option:selected').text();
		$('input#soa-property-5').val(value);
		$('input#soa-property-4').val(value);
		val = $(this).val();

		whereUrl = 'get_city_posts_np.php';
		if($('#ID_DELIVERY_ID_5').prop('checked') || $('#ID_DELIVERY_ID_14').prop('checked'))
			whereUrl = 'get_city_posts_np.php';
		else if($('#ID_DELIVERY_ID_6').prop('checked') || $('#ID_DELIVERY_ID_15').prop('checked'))
			whereUrl = 'get_city_posts_ukr.php';


		$.ajax({
			url: '/ajax/'+whereUrl,
			data: {cityID: val, url:location.href},
			type: 'POST',
			dataType:'json'
		}).done(function(html)
		{
			$('[name="choose_city_np_vid"]').html(html.html_vid).select2();
		});

		console.log($(this).find('option:selected').text());
	});

	$(document).on('change', '[name=choose_city_np_vid]', function()
	{
		value = $(this).find('option:selected').text();
		$('input#soa-property-7').val(value);
		$('input#soa-property-25').val(value);
	});

	$(document).on('change', '[name=fake_email]', function()
	{
		newValue = $(this).val();
		if(newValue != '')
			$('input#soa-property-2').val(newValue);
		else
			$('input#soa-property-2').val('test@email.ua');
	})
});