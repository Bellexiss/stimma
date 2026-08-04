
function setActiveItem()
{
	$('[data-entity="scu-value"]').removeClass('active');
	offerItem = treeOffersIds[selectedOfferID];
	blockScu = $('[data-entity="scu"]');
	for (i in offerItem)
	{
		codeBlock = $(blockScu).find('[data-code="'+i+'"]');
		valueItem = $(codeBlock).find('[data-entity="scu-value"][data-id="' + offerItem[i] + '"]');
		$(valueItem).addClass('active');
	}
}

function disabledValues()
{
	offerItem = treeOffersIds[selectedOfferID];
	//$('[data-entity="scu-value"]').css('color','red');
	$('[data-entity="scu-value"]').removeClass('no-size');
	check = [];
	for (index in scuProps)
	{
		if(index == 0)
		{
			codeBlock = $(blockScu).find('[data-code="'+scuProps[index]+'"]');
			//valueItem = $(codeBlock).find('[data-entity="scu-value"]').css('color','inherit');
			valueItem = $(codeBlock).find('[data-entity="scu-value"]').removeClass('no-size');
			check[index] = offerItem[scuProps[index]];

		}
		else
		{
			codeBlock = $(blockScu).find('[data-code="'+scuProps[index]+'"]');
			$(codeBlock).find('[data-entity="scu-value"]').each(function(i, elem)
			{
				value = $(elem).attr('data-id');
				check[index] = value;
				findStr = check.join('-');
				for (j in variants)
				{
					if(variants[j].indexOf(findStr) > -1)
					{
						//$(elem).css('color','inherit');
						console.log('no-size');
						$(elem).removeClass('no-size');
					}
				}
			});
		}
	}
}

function initScu()
{
	setActiveItem();
	disabledValues();
}

function findOfferID()
{
	ar = [];
	for (index in scuProps)
	{
		codeBlock = $(blockScu).find('[data-code="'+scuProps[index]+'"]');
		valueItem = $(codeBlock).find('.active[data-entity="scu-value"]').attr('data-id');
		ar[index] = valueItem;
	}
	findStr = ar.join('-');
	console.log(findStr);
	finded = false;
	for (i in variants)
	{
		if(variants[i] == findStr)
		{
			console.log('finded');
			selectedOfferID = i;
			console.log(selectedOfferID);
			finded = true;
			break;
		}
	}

	if(!finded)
	{
		console.log('not finded');
		findStr = ar[0]+'-';
		for (i in variants)
		{
			if(variants[i].indexOf(findStr) > -1)
			{
				selectedOfferID = i;
				finded = true;
				break;
			}
		}
		setActiveItem();
	}
	console.log('->');
	console.log(selectedOfferID);
	$('.buy_product').attr('data-id', selectedOfferID);
	$('.fast_buy_product').attr('data-id', selectedOfferID);
}

function updateSelectOffer()
{
	console.log(jsData[selectedOfferID]);
	//$('[data-entity="name_card"]').html(jsData[selectedOfferID].name);
	$('[data-entity="price_card"]').html(jsData[selectedOfferID].price);
	if(jsData[selectedOfferID].price_base_num > jsData[selectedOfferID].price_num)
	{
		$('[data-entity="price_card"]').closest('.card-info-price').find('[data-entity="price-old"]').html(jsData[selectedOfferID].price_base);
		$('[data-entity="price_card"]').closest('.card-info-price').find('[data-entity="price-old"]').show();
	}
	else
		$('[data-entity="price_card"]').closest('.card-info-price').find('[data-entity="price-old"]').hide();


	//$('[data-entity="price_old"]').html(jsData[selectedOfferID].price_old);

	//if(jsData[selectedOfferID].available)
		//$('[data-entity="available"]').html($availableTextIn);
	//else
		//$('[data-entity="available"]').html($availableTextOut);
}

$(document).ready(function()
{
	$('.new-card-size-list[data-code=RAZMER]').find('[data-entity="scu-value"]').eq(0).trigger('click');

	var blockScu = $('[data-entity="scu"]');

	//initScu();

	/*$(document).on('click', '[data-entity="scu-value"]', function()
	{
		return false;
		$(this).closest('[data-entity="scu-values"]').find('[data-entity="scu-value"]').removeClass('active');
		$(this).addClass('active');
		findOfferID();
		disabledValues();
		updateSelectOffer();

		return false;
	});*/

	var pid = $('.new-card-size-item.active').attr('data-id');

	$.ajax({
		url: '/ajax/new/get_basket_item.php',
		data: {pid:pid},
		type: 'POST',
		dataType:'json'
	}).done(function(response)
	{
		var text = location.href.indexOf('/ru/') == -1 ? 'Перейти до кошику' : 'Перейти к корзине';
		if(response.status == 1)
			$('.triggeropenbasket').show();
			//$('.new-card-btn').html('<a class="new-card-btn-buy triggeropenbasket">'+text+'</a>');
		else
			$('.triggeropenbasket').hide();
			//$('.buy_product').show();
	});

	$(document).on('click','.triggeropenbasket', function()
	{
		$('.get_popup_basket').trigger('click');
	});

	$(document).on('click', '.minuscounter, .pluscounter', function()
	{
		count = parseInt($(this).closest('.card-counter').find('input').val());
		if($(this).hasClass('minuscounter'))
			count--;
		else
			count++;

		if(count < 1) count = 1;
		$(this).closest('.card-counter').find('input').val(count);
		return  false;
	});

	$(document).on('click', '[name=send_review]', function()
	{
		obj = $(this);
		form = $(this).closest('form').serialize();
		$.ajax({
			url: '/ajax/new/reviews.php',
			data: form,
			type: 'POST',
			dataType:'json'
		}).done(function(html)
		{
			if(location.href.indexOf('/ru/') != -1)
				$(obj).closest('.reviews-form').html('<div style="color:#3D441D">Ваш отзыв добавлен. После модерации он появится на сайте.</div>')
			else
				$(obj).closest('.reviews-form').html('<div style="color:#3D441D">Ваш відгук додано. Після модерації він з’явиться на сайті.</div>')
		});

		return false;
	});

	$(document).on('click', '.get_my_size', function()
	{
		$('#modal-size').find('.set_image').attr('src',$('.card-big-slider').find('.first_img').attr('src'));
	});

	$(document).on('click','.find_my_size', function()
	{
		talia = $('#modal-size').find('input[name=talia]').val();
		grud = $('#modal-size').find('input[name=grud]').val();
		bedra = $('#modal-size').find('input[name=bedra]').val();
		id = $('.buy_product').attr('data-id');
		url = location.pathname;
		section = $('.get_my_size').attr('section');

		$.ajax({
			url: '/ajax/new/get_my_size.php',
			data: {talia:talia,grud:grud,bedra:bedra,id:id,url:url,section:section},
			type: 'POST',
			dataType:'json'
		}).done(function(html)
		{
			console.log(html);
			$('#modal-size .modal-size-info').hide();
			$('#modal-size .modal-size-info-2').html(html.html).show();

			$('#modal-size .modal-footer').hide();
			$('#modal-size .modal-footer.justify-content-space').show();

			if(html.button_add_basket == true || html.button_add_basket == 'true')
				$('#modal-size .button_add_to_basket').attr('add-id',html.add_to_basket).show();

		});

		return false;
	});

	$(document).on('click', '#modal-size .btn-modal-back', function()
	{
		$('#modal-size .modal-size-info').hide();
		$('#modal-size .modal-footer').hide();

		$('#modal-size .mf-1').show();
		$('#modal-size .modal-size-info-1').show();

		$('#model-size.button_add_to_basket').hide();
		return false;
	});

	$(document).on('click', '.button_add_to_basket', function()
	{
		//id = $(this).attr('data-id');
		id = $(this).attr('add-id');
		cnt = 1;
		$.ajax({
			url: '/ajax/basket.php',
			data: {'pprocess':'add','id':id, 'url':location.pathname, cnt:cnt},
			type: 'POST',
			dataType:'json'
		}).done(function(html)
		{
			link = location.href.indexOf('/ru/') != -1 ? '/ru/basket/' : '/basket/';
			ua = location.href.indexOf('/ru/') == -1;
			textDop = ua ? 'до кошика' : 'в корзину';
			$('.card-basket-add').html('<a href="'+link+'">Перейти '+textDop+' </a>'+$('.card-info-name').text() + ' ' + $('.card-main-info [data-code="RAZMER"] .card-info-size-item.active').text());
			$('.card-basket-add').addClass('added');
			$('#modal-size button.close').trigger('click');
			setTimeout(sayHi, 3000);
			if(window.innerWidth <= 672)
				$('html').animate({
						scrollTop: $('.card-basket-add').offset().top // прокручиваем страницу к требуемому элементу
					}, 500 // скорость прокрутки
				);
			$('.headerbasket .counter').html(html.basket.TOTAL_KOM);
		});

		return false;
	});
	if ($(window).width() >= '767'){

		//var zzz = $(".easyzoom").easyZoom();
		//var easyzoomAPI = zzz.data('easyZoom');
		//console.log(easyzoomAPI);
	}
	$(document).on('click', '.is_sert', function()
	{
		var $img = $(this).attr('data-img');
		var $img2 = $(this).attr('data-img2');
		var $original = $(this).attr('data-original');
		console.log('$original');
		console.log($original);
		$('.big_img_sert').attr('src', $img);
		$('.small_img_sert').attr('src', $img2);
		$('.big_img_sert').closest('a').attr('href', $original);
		//easyzoomAPI.swap($original, $img);
	})
});