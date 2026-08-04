function initChooseCity()
{
	$('input#soa-property-2, input#soa-property-5, input#soa-property-7, input#soa-property-4, input#soa-property-25').hide();
	console.log('initChooseCity');

	$('.choose_city').find('span.select2').remove();
	if($('[name="choose_city_np_vid"]').length)$('[name="choose_city_np_vid"]').select2();

	whereUrl = 'get_city_np.php';
	if($('#delivery_method').prop('checked'))
		whereUrl = 'get_city_np.php';
	else if($('#delivery_method1').prop('checked'))
		whereUrl = 'get_city_ukr.php';
	console.log('whereUrl');
	console.log(whereUrl);
	$('[name=choose_city_np]').next('span.select2').remove();

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
		//if (BX.Sale.OrderAjaxComponent)
//			BX.Sale.OrderAjaxComponent.locationsCompletion();
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

function checkOrderForm(typeClick)
{
	$npDelivery = $('#delivery_method').prop('checked');
	$ukrDelivery = $('#delivery_method1').prop('checked');
	$pickupDelivery = $('#delivery_method2').prop('checked');

	$pbPayment = $('#payment_method').prop('checked');
	$naklPayment = $('#payment_method2').prop('checked');
	$cashPayment = $('#payment_method1').prop('checked');

	if($npDelivery)
	{
		$('#payment_method1').closest('.form-checkbox').hide();
		$('#payment_method').closest('.form-checkbox').show();
		$('#payment_method2').closest('.form-checkbox').show();
		if(typeClick == 'delivery')$('#payment_method').prop('checked',true);
		$('[name=choose_city_np]').closest('.form-control').show();
		$('[name=choose_city_np_vid]').closest('.form-control').show();
	}
	else if ($ukrDelivery)
	{
		$('#payment_method1').closest('.form-checkbox').hide();
		$('#payment_method').closest('.form-checkbox').show();
		//$('#payment_method2').closest('.form-checkbox').hide();
		$('#payment_method2').closest('.form-checkbox').show();
		if(typeClick == 'delivery')$('#payment_method').prop('checked',true);
		$('[name=choose_city_np]').closest('.form-control').show();
		$('[name=choose_city_np_vid]').closest('.form-control').show();
	}
	else if ($pickupDelivery)
	{
		$('#payment_method1').closest('.form-checkbox').show();
		$('#payment_method').closest('.form-checkbox').show();
		$('#payment_method2').closest('.form-checkbox').hide();
		if(typeClick == 'delivery')$('#payment_method').prop('checked',true);
		$('[name=choose_city_np]').closest('.form-control').hide();
		$('[name=choose_city_np_vid]').closest('.form-control').hide();
	}

}

$(document).ready(function()
{
	initChooseCity();
	//$('[type=tel]').inputmask("mask", { mask: '+389 (99) 999-99-99' });

	$(document).on('click','.set_coupon',function()
	{

		//var coupon = $(this).closest('.order-list-discount-block').find('[name=coupon]').val();
		var coupon = $(this).prev('input').val();
		console.log(coupon);

        $('.promocode').remove();
        $('[name*=sql_order]').remove();

		var blockClosest = $(this).closest('div');
		$(blockClosest).addClass('loader');
		$('.error_coupon').remove();

        if(window.isAction08 && coupon == 'Look25')
        {
			console.log('isAction08',window.isAction08)
            var fullValue = $('.order-list-total-value').eq(0).attr('data-price');
            fullValue = fullValue.replace(/\D/g, '');
            fullValue = TotalValue = parseInt(fullValue);
            //fullValue -= fullValue*0.1;
            fullValue -= fullValue*0.05;
            console.log('TotalValue');
            console.log(TotalValue);
            console.log('fullValue');
            console.log(fullValue);
            raznica = TotalValue-fullValue;
            raznica = Math.round(raznica);
            raznica = raznica.toLocaleString('ru-RU');
            console.log('raznica');
            console.log(raznica);
            fullValue = NumberValue = Math.round(fullValue);
            fullValue = fullValue.toLocaleString('ru-RU');
            $(blockClosest).removeClass('loader');

            $('.order-list-total').prepend('<div class="order-list-total-item promocode">\n' +
                '                        <div class="order-list-total-key">Промокод</div>\n' +
                '                        <div class="order-list-total-value">-'+raznica+' грн</div>\n' +
                '                    </div>');
            $('.order-list-total-item.total-end .order-list-total-value').text(fullValue + ' грн');
            $('#create_order_form').prepend('<input type="hidden" name="sql_order[]" value="update b_sale_order set PRICE = '+NumberValue+' where ID = #ORDER_ID#">');

            console.log(fullValue);
        }

        if(window.isActionSelfDate && coupon == 'selfdate')
        {
            console.log('isActionSelfDate',window.isActionSelfDate)
            var fullValue = $('.order-total-price-value').eq(0).attr('data-price');
            fullValue = fullValue.replace(/\D/g, '');
            fullValue = TotalValue = parseInt(fullValue);
            //fullValue -= fullValue*0.1;
            fullValue -= fullValue*0.2;
            console.log('TotalValue');
            console.log(TotalValue);
            console.log('fullValue');
            console.log(fullValue);
            raznica = TotalValue-fullValue;
            raznica = Math.round(raznica);
            raznica = raznica.toLocaleString('ru-RU');
            console.log('raznica');
            console.log(raznica);
            fullValue = NumberValue = Math.round(fullValue);
            fullValue = fullValue.toLocaleString('ru-RU');
            $(blockClosest).removeClass('loader');

            /*$('.order-total-price').prepend('<div class="order-list-total-item promocode">\n' +
                '                        <div class="order-list-total-key">Промокод</div>\n' +
                '                        <div class="order-list-total-value">-'+raznica+' грн</div>\n' +
                '                    </div>');*/
            $('.order-total-price').prepend('<div class="order-total-price-item"><div class="order-total-price-key">Знижка за промокодом: selfdate</div><div class="order-total-price-value">-'+raznica+' ₴</div></div>');
            $('.order-total-price-value').text(fullValue + ' грн');
            $('#create_order_form').prepend('<input type="hidden" name="sql_order[]" value="update b_sale_order set PRICE = '+NumberValue+' where ID = #ORDER_ID#">');

            console.log(fullValue);
        }

        if(!window.isAction08 && !window.isActionSelfDate)
        {
            $.ajax({
                url: '/ajax/new/set_coupon.php',
                data: {'action':'set_coupon','coupon':coupon,url:location.href,is_order:window.is_order,isAction08:window.isAction08,phone:$('[name=phone]').val()},
                type: 'POST',
                dataType:'json'
            }).done(function(json)
            {
                if(json.status == 0)
                {
                    $('[name=coupon]').before('<span class="error_coupon">'+json.msg+'</span>');
                }
                //else
                    //location.reload();
                console.log('location.href',location.href)
                $.ajax({
                    url: location.href,
                    data: {'action':'get_basket'},
                    type: 'POST',
                    dataType:'json'
                }).done(function(json)
                {
                    console.log('json', json)
                    $('.order-list-cont.mobile').html(json.mobile);
                    $('.order-list-cont.desctop').html(json.desctop);
                    $('.order-list-total-value').html(json.amount);

					//var fullValue = $('.order-total-price-value[data-entity="full_value"]').attr('data-price');
					//console.log('fullValue');
					//console.log(fullValue);
					//TotalValue = parseInt(fullValue);
					//raznica = TotalValue-json.all_summ;
					//raznica = Math.round(raznica);
					//raznica = raznica.toLocaleString('ru-RU');
					//$('.order-total-price').prepend('<div class="order-total-price-item"><div class="order-total-price-key">Знижка за промокодом: '+coupon+'</div><div class="order-total-price-value">-'+raznica+' ₴</div></div>');
					//$('.order-total-count-value').text(fullValue + ' грн');
                    $('.order-total-price-value[data-entity="full_value"]').html(json.amount);

                    $(blockClosest).removeClass('loader');
                });
            });
        }
        else $(blockClosest).removeClass('loader');

		return false;
	});

	$(document).on('change','[name=delivery_method]',function()
	{
		var id_shipping = $(this).val();

		text1 = location.href.indexOf('/ru/') == -1 ? 'Оберіть спочатку місто' : 'Выберите сначала город';
		text2 = location.href.indexOf('/ru/') == -1 ? 'Оберіть місто' : 'Выберите город';

		console.log(dost);

		$('.choose_city').find('span.select2').remove();
		if (typeof dost[id_shipping] !== 'undefined')
			$('[name="choose_city_np_vid"]').html('<option value="'+dost[id_shipping].UF_VIDD_ID+'">'+dost[id_shipping].VIDD+'</option>');
		else
			$('[name="choose_city_np_vid"]').html('<option value="">'+text1+'</option>');
		if($('[name="choose_city_np_vid"]').length)$('[name="choose_city_np_vid"]').select2();

		$('.choose_city_np').closest('.form-control').find('span.select2').remove();
		if (typeof dost[id_shipping] !== 'undefined')
			$('[name="choose_city_np"]').html('<option value="'+dost[id_shipping].UF_CITY_ID+'">'+dost[id_shipping].CITY+'</option>');
		else
			$('[name="choose_city_np"]').html('<option value="">'+text2+'</option>');

		if($('[name="choose_city_np"]').length)$('[name="choose_city_np"]').select2();



		checkOrderForm('delivery');
		initChooseCity();
		
		

		if ( id_shipping != 14 ) {
			$('.svNovaPoshta').hide();
			console.log('hide');
		} else {
			$('.svNovaPoshta').show();
			console.log('show');
		}
		console.log('id_shipping='+id_shipping);		
		

	})

	$(document).on('change','[name=payment_method]',function()
	{
		checkOrderForm('payment');
	})


    $('select[name="choose_city_np"]').on('change', function() {
        if ($(this).closest('.form-block').hasClass('error-select') && $(this).val() !== '') {
            $(this).closest('.form-block').removeClass('error-select');
        }
    });


    $('select[name="choose_city_np_vid"]').on('change', function() {
        if ($(this).closest('.form-block.choose_city').hasClass('error-select') && $(this).val() !== '-1') {
            $(this).closest('.form-block.choose_city').removeClass('error-select');
        }
    });



document.querySelectorAll('.form-block input').forEach(function(input) {
    input.addEventListener('input', function() {
        if (this.classList.contains('error') && this.value.trim() !== '') {
            this.classList.remove('error');
        }
    });
});


	$(document).on('click','.create_order',function()
	{
		if(window.is_order == 0)
			return false;
		$('.create_error').hide();
		var blockClosest = $(this).closest('div');
		$(blockClosest).addClass('loader');
		$('.error').removeClass('error');
		$('.error-select').removeClass('error-select');
		form = $('#create_order_form');
		email = $(form).find('[name=email]').val();

		$npDelivery = $(form).find('#delivery_method').prop('checked') || $(form).find('#delivery_method3').prop('checked') || $(form).find('#delivery_method4').prop('checked');
		$ukrDelivery = $(form).find('#delivery_method1').prop('checked');
		$pickupDelivery = $(form).find('#delivery_method2').prop('checked');

		city = $(form).find('[name=choose_city_np]:visible').val();
		vidd = $(form).find('[name=choose_city_np_vid]:visible').val();
		name = $(form).find('[name=name]').val();
		fio = $(form).find('[name=fio]').val();
		second_name = $(form).find('[name=second_name]').val();
		name = name.trim();
		fio = fio.trim();
        email = email.trim();
		second_name = second_name.trim();
		phone = $(form).find('[name=phone]').val();
		phone=phone.replace(/\D/g, '');

		//var phoneRegex = /^380\d{9}$/;
        var phoneRegex = /^(?:0|380|\+380)(39|50|63|66|67|68|73|91|92|93|94|95|96|97|98|99)\d{7}$/;
		isPhone = phoneRegex.test(phone);

		console.log(phone);
		console.log(isPhone);
		error =false;
        console.log('error 1');
        console.log(error);
        if(name == '')
		{
			$(form).find('[name=name]').closest('.form-block').addClass('error');
			error = true;
		}
        console.log('error 2');
        console.log(error);
        if(email == '')
        {
            $(form).find('[name=email]').closest('.form-block').addClass('error');
            error = true;
        }
        console.log('error 3');
        console.log(error);
		if(second_name == '')
		{
			$(form).find('[name=second_name]').closest('.form-block').addClass('error');
			error = true;
		}
        console.log('error 4');
        console.log(error);
		if(fio == '')
		{
			$(form).find('[name=fio]').closest('.form-block').addClass('error');
			error = true;
		}
        console.log('error 5');
        console.log(error);
		if(phone == '' || !isPhone)
		{
			$(form).find('[name=phone]').closest('.form-block').addClass('error');
			error = true;
		}
        console.log('error 6');
        console.log(error);
		console.log('$npDelivery');
		console.log($npDelivery);
		console.log($ukrDelivery);
		console.log(city);
		console.log(vidd);
		if(($npDelivery || $ukrDelivery) && (!city || !vidd || city == -1 || vidd == -1 || city == '0' || vidd == '0'))
		{
			if(!city || city == -1 || city == '0')$(form).find('[name=choose_city_np]').closest('.form-block').addClass('error');
			if(!vidd || vidd == -1 || vidd == '0')$(form).find('[name=choose_city_np_vid]').closest('.form-block').addClass('error');
			error = true;
		}
        console.log('error 7');
        console.log(error);
		/*if(location.href.indexOf('cancel_create') != -1)
		{
			$(blockClosest).removeClass('loader');

			console.log('$npDelivery');
			console.log($npDelivery);
			console.log(city);
			console.log(vidd);
			console.log('$ukrDelivery');
			console.log($ukrDelivery);

			console.log('return false;');
			return false;
		}*/
		if(!error)
		{
            $('#create_order_form').find('select[name=choose_city_np]:hidden').remove();
            $('#create_order_form').find('select[name=choose_city_np_vid]:hidden').remove();


			data = $('#create_order_form').serialize();
			$.ajax({
				url: '/ajax/new/create_order.php',
				data: data,
				type: 'POST',
				dataType:'json'
			}).done(function(json)
			{
				$(blockClosest).removeClass('loader');
				if(location.href.indexOf('/ru/') == -1)
					var link = '/order/?ORDER_ID='+json.order_id;
				else
					var link = '/ru/order/?ORDER_ID='+json.order_id;
				if(json.status == 1)
					location.href = link
				else
					$('.create_error').show();

			});
		}
		else
			$(blockClosest).removeClass('loader');

		if ((error) && ($(window).width() <= 1000)) {
			let firstError = $(".error, .error-select").first();

		    if (firstError.length) {
		        $("html, body").animate(
		            { scrollTop: firstError.offset().top - 50 }, // -50px щоб не впирався у верх
		            500
		        );
		    }
		}

		return false;
	})


	$(document).on('change', '[name=choose_city_np]', function()
	{
        console.log('change choose_city_np');
        var block=$(this).closest('.order-detail-element');
        value = $(block).find('[name=choose_city_np]').find('option:selected').text();
		$('input#soa-property-5').val(value);
		$('input#soa-property-4').val(value);
		val = $(block).find('[name=choose_city_np]').val();

		whereUrl = 'get_city_posts_np.php';
		if($('#delivery_method').prop('checked'))
			whereUrl = 'get_city_posts_np.php';
		else if($('#delivery_method1').prop('checked'))
			whereUrl = 'get_city_posts_ukr.php';

        if($('#delivery_method').prop('checked')) whereUrl += '?type=viddilennya';
        if($('#delivery_method3').prop('checked')) whereUrl += '?type=pochtomat';

		$.ajax({
			url: '/ajax/'+whereUrl,
			data: {cityID: val, url:location.href},
			type: 'POST',
			dataType:'json'
		}).done(function(html)
		{
			$('.choose_city').find('span.select2').remove();
			$('[name="choose_city_np_vid"]').html(html.html_vid);
			$('[name="choose_city_np_vid"]').closest('.form-block').show();
			if($('[name="choose_city_np_vid"]').length)$('[name="choose_city_np_vid"]').select2();
		});

		console.log($(block).find('[name=choose_city_np]').find('option:selected').text());
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