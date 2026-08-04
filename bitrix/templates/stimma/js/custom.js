/*
You can use this file with your scripts.
It will not be overwritten when you upgrade solution.
*/

var hover = 0;

function initDopSlick()
{
    $('.modal-basket-more-list .main-googs-list').slick({
        dots: false,
        arrows:true,
        infinite: true,
        appendArrows:".modal-basket-more-controls",
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1680,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false
                }
            },
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1100,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }

        ]
    })
}

function StartLazyLoad()
{
    if (!('IntersectionObserver' in window))
    {
        console.log('lazzyLoaded 1 version');
        var lazy = [];
        var lazyb = [];
        registerListener('load', setLazy); registerListener('load', lazyLoad); registerListener('scroll', lazyLoad); registerListener('resize', lazyLoad);
        registerListener('load', setLazyB); registerListener('load', lazyLoadB); registerListener('scroll', lazyLoadB); registerListener('resize', lazyLoadB);
        function setLazyB(){
            lazyb = document.querySelectorAll('[data-lazzybsrc]');
            console.log('Found ' + lazyb.length + ' lazy images');
        }
        function lazyLoadB(){
            for(var i=0; i<lazyb.length; i++){
                if(isInViewport(lazyb[i])){
                    if (lazyb[i].getAttribute('data-lazzybsrc')){
                        lazyb[i].style.backgroundImage = "url('"+lazyb[i].getAttribute('data-lazzybsrc')+"')";
                        lazyb[i].removeAttribute('data-lazzybsrc');
                    }
                }
            }
            cleanLazyB();
        }
        function cleanLazyB(){
            lazyb = Array.prototype.filter.call(lazyb, function(l){ return l.getAttribute('data-lazzybsrc');});
        }
        function setLazy(){
            lazy = document.querySelectorAll('[data-lazzysrc]');
            console.log('Found ' + lazy.length + ' lazy images');
        }
        function lazyLoad(){
            for(var i=0; i<lazy.length; i++){
                if(isInViewport(lazy[i])){
                    if (lazy[i].getAttribute('data-lazzysrc')){
                        lazy[i].src = lazy[i].getAttribute('data-lazzysrc');
                        lazy[i].onload = function () {
                            this.classList.add("lazyloaded")
                        };
                        lazy[i].removeAttribute('data-lazzysrc');
                    }
                }
            }

            cleanLazy();
        }
        function cleanLazy(){
            lazy = Array.prototype.filter.call(lazy, function(l){ return l.getAttribute('data-lazzysrc');});
        }
        function isInViewport(el){
            var rect = el.getBoundingClientRect();

            return (
                rect.bottom >= 0 &&
                rect.right >= 0 &&
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.left <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }
        function registerListener(event, func) {
            if (window.addEventListener) {
                window.addEventListener(event, func)
            } else {
                window.attachEvent('on' + event, func)
            }
        }
    }
    else
    {
        console.log('lazzyLoaded 2 version');
        document.addEventListener("DOMContentLoaded", function() {
            const imageObserver = new IntersectionObserver((entries, imgObserver) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const lazyImage = entry.target;

                        $(lazyImage).hide();

                        lazyImage.src = lazyImage.dataset.lazzysrc;

                        imageObserver.unobserve(lazyImage);

                        lazyImage.onload = function () {
                            $(lazyImage).show();
                            this.classList.add("lazyloaded")
                        };
                    }
                })
            });
            const arr = document.querySelectorAll('[data-lazzysrc]');
            arr.forEach((v) => {
                imageObserver.observe(v);
            });
            const imageObserver2 = new IntersectionObserver((entries, imgObserver) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const lazyImage = entry.target;
                        //console.log(lazyImage);
                        //$(lazyImage).hide();
                        lazyImage.style.backgroundImage = "url('"+lazyImage.dataset.lazzybsrc+"')";

                        //imageObserver.unobserve(lazyImage);

                        //lazyImage.onload = function () {
                        //    $(lazyImage).show('slow');
                        //    this.classList.add("lazyloaded")
                        //};
                    }
                })
            });
            const arr2 = document.querySelectorAll('[data-lazzybsrc]');
            arr2.forEach((v) => {
                imageObserver2.observe(v);
            })
        })
    }
}
StartLazyLoad();
function loadMore(href,replace = false, triggerClick = false, callBack = false){
    console.log('startloadMore');
    console.log(href);
    let fData = new FormData();
    fData.append(`get_catalog_ajax_filter`, 'y');
    $('#ajax_load_btn').remove();

    $('.insertpag').append('<div class="loadmore_gif" style="text-align: center;width: 100%;display:block;"><img style="width: 60px;" src="/loading.gif?v=2"></div>');
    
    const requestOptions = {
        method: 'POST',
        body: fData
    };
    return fetch(href, requestOptions)
        .then(function (response) {
            return response.text().then(text => {
                return text
            });
        })
        .then(data => {
            var loadmore_wrapper = document.querySelector(".insertpag");


            if( loadmore_wrapper ){
                var loadmore_container = loadmore_wrapper.querySelector(".loadmore_container");
                data = data.split('<!--filter-->');
                console.log('------------data----------------');
                console.log(data);
                $('.loadmore_gif').remove();
                if(!replace)
                {
                    console.log('inside NOT REPLACE');
                    $(loadmore_wrapper).append(data[1]);
                }
                else
                {
                    loadmore_wrapper.innerHTML = '';
                    console.log('inside REPLACE');
                    $(loadmore_wrapper).html(data[1]);
                }
                console.log('inside AFTER NOT REPLACE 1');
                $('.filter-selected-list').html(data[0]);
                console.log('inside AFTER NOT REPLACE 2');
                $('.ajax_load_btn').remove();
                $('.module-pagination').remove();
                //section_review
                //if($('.insertpag').closest('.row').find('.section_review').length)
                //{
                //    $('.insertpag').closest('.row').find('.section_review').before(data[2]);
                //} 
                //else
                    //$('.insertpag').closest('.row').append(data[2]);
                    $('.insertpag').after(data[2]);

                    $('#insert_ajax_load_btn').after(data[2]).remove();
                console.log('inside AFTER NOT REPLACE 3');
                //setActiveItem();
                console.log('inside AFTER NOT REPLACE 4');
                //disabledValues();
                console.log('inside AFTER NOT REPLACE 5');
                console.log('before getDataForChange');
                getDataForChange();
                console.log('inside AFTER NOT REPLACE 6');



                /*if( !replace ){
                    var loadmore_items = loadmore_container.innerHTML;
                    loadmore_container = loadmore_wrapper.querySelector(".loadmore_container");
                    if( loadmore_container && loadmore_items.length ){
                        var firstItem = loadmore_container.querySelector(".loadmore_item");

                        if( firstItem ){
                            firstItem.insertAdjacentHTML('beforebegin', loadmore_items);
                        }
                    }
                }*/
                $(loadmore_wrapper).find(".fancybox").fancybox();
            }
            //initLoadMore(triggerClick);
            //makeOffersMap();
            //fillInBasket();
            //fillInCompare();
            //fillInFavorites();
            //initLazzyload();
            //initCnt();
            if( callBack !== false ){
                callBack();
            }
        }).catch(errors => {
        });
}
var offersObject = {};
function getDataForChange()
{
    console.log('getDataForChange');
    arr2 = [];
    $('[data-entity=scu]').each(function(i,elem)
    {
        arr2.push($(elem).attr('data-item'));
    });

    $.ajax({
        url: '/ajax/new/get_offers.php',
        data: {id:arr2,url:location.href},
        type: 'POST',
        dataType:'json'
    }).done(function(json)
    {
        offersObject = json;
    });
    console.log(arr2);
}

function changeData(code, object)
{

    console.log(offersObject[code]);
    block = $(object).closest('.catalog-item-block');

    if(offersObject[code].img != '')
        $(block).find('.catalog-item-img a img').attr('src', offersObject[code].img);

    if(offersObject[code].price)
        $(block).find('.catalog-item-price').html(offersObject[code].price);

    if(offersObject[code].price)
        $(block).find('.catalog-item-size-list[data-code="RAZMER"]').html(offersObject[code].sizes);
}

function onScroll() {
    /*var targetElement = $("#ajax_load_btn");

    if (isElementInViewport(targetElement)) {
        // Ваш код, который будет выполнен
        load_mode_scroll($("#ajax_load_btn"));
        console.log("Элемент достигнут!");

        // Отписываемся от события после выполнения кода, если нужно
        //$(window).off("scroll", onScroll);
    }*/
}

// Функция для проверки, дойден ли элемент
function isElementInViewport(el) {
    if (el.length <= 0) return false;
    var rect = el[0].getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}


$(document).ready(function()
{

    $(window).on("scroll", onScroll);
    onScroll();

    $(".main-big-banner-slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        dots: false,
        arrows: false

    });

    $('.sss-bonus-buy-slider').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: true,
      infinite: false,
      responsive: [
        {
          breakpoint: 1440,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: false
          }
        }
    ]
    });

    $('.sss-rangs-slider').slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      arrows: true,
      infinite: false,
      adaptiveHeight: true,
      responsive: [
        
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: false,
            dots: false
          }
        }
    ]
    });


    getDataForChange();

                /*if ($(window).width() >= '767'){
           
                    var zzz = $(".easyzoom").easyZoom();
                    var easyzoomAPI = zzz.data('easyZoom');
                    console.log(easyzoomAPI);
                }*/

    $(document).on('click','.register_action', function()
    {
        var email = $('[name=register_email]').val();
        $('.show_action_error').hide();
        $('.show_action_success').hide();

        $.ajax({
            url: '/ajax/new/register_action.php',
            data: {EMAIL:email,url:location.href},
            type: 'POST',
            dataType:'json'
        }).done(function(response)
        {
            if(response.result == 'error')
            {
                $('.show_action_error').text(response.message).show();
            }
            else
            {
                $('.show_action_success').text(response.message).show();
                //$('.coupon_code_show').text('Ваш промокод: ' + response.coupon);
            }
        });

        return false;
    })

    $(document).on('click','.new-card-size-guide-delivery', function()
    {
        $(".new-card-tabs-delivery").slideToggle();

        return false;
    })

    $(document).on('keyup','[name=fast_search_new]',function()
    {
        val = $(this).val();
        if(val.length < 2) return false;

        $.ajax({
            url: '/ajax/search.php',
            data: {q:val},
            type: 'POST',
            dataType:'html'
        }).done(function(response)
        {
            $('.modal-search-result-list').html(response);
            if(!$('.modal-search-result-cont').hasClass('opened'))
                $('.modal-search-result-cont').addClass('opened');
        });
    })

    $(document).on('change','.modal-basket-item-count input',function()
    {
        $(this).closest('.modal-basket-item-count').addClass('loader');
        var val = $(this).val();
        var id = $(this).attr('data-id');

        $.ajax({
            url: '/ajax/basket.php',
            data: {id:id,val:val,pprocess:'change', 'url':location.pathname},
            type: 'POST',
            dataType:'json'
        }).done(function(response)
        {
            $('.popup_basket_content').html(response.html_basket);
            $('.popup_basket_total_kom').text('('+response.basket.TOTAL_KOM+')');
            $('.header-basket-counter').html(response.basket.TOTAL_KOM);
            if(!parseInt(response.basket.TOTAL_KOM))
            {
                $('.header-basket-counter').hide();
                $('.header-new-elem-basket').removeClass('green-basket');
            }
            else
            {
                $('.header-basket-counter').show();
                $('.header-new-elem-basket').addClass('green-basket');
            }

            $('.modal-basket-item-count').removeClass('loader');

            initDopSlick();
        });
    });
    $(document).on('click','.modal-basket-item-count .minus_count', function()
    {
        $(this).closest('.modal-basket-item-count').addClass('loader');
        var val = parseInt($(this).closest('.modal-basket-item-count').find('input').val());
        val--;
        if(val <= 0) val = 1;
        var id = $(this).attr('data-id');

        $.ajax({
            url: '/ajax/basket.php',
            data: {id:id,val:val,pprocess:'change', 'url':location.pathname},
            type: 'POST',
            dataType:'json'
        }).done(function(response)
        {
            $('.popup_basket_content').html(response.html_basket);
            $('.popup_basket_total_kom').text('('+response.basket.TOTAL_KOM+')');
            $('.header-basket-counter').html(response.basket.TOTAL_KOM);
            if(!parseInt(response.basket.TOTAL_KOM))
            {
                $('.header-basket-counter').hide();
                $('.header-new-elem-basket').removeClass('green-basket');
            }
            else
            {
                $('.header-basket-counter').show();
                $('.header-new-elem-basket').addClass('green-basket');
            }

            $('.modal-basket-item-count').removeClass('loader');

            initDopSlick();
        });
    });
    $(document).on('click','.modal-basket-item-count .plus_count', function()
    {
        $(this).closest('.modal-basket-item-count').addClass('loader');
        var val = parseInt($(this).closest('.modal-basket-item-count').find('input').val());
        val++;
        var id = $(this).attr('data-id');

        $.ajax({
            url: '/ajax/basket.php',
            data: {id:id,val:val,pprocess:'change', 'url':location.pathname},
            type: 'POST',
            dataType:'json'
        }).done(function(response)
        {
            $('.popup_basket_content').html(response.html_basket);
            $('.popup_basket_total_kom').text('('+response.basket.TOTAL_KOM+')');
            $('.header-basket-counter').html(response.basket.TOTAL_KOM);
            if(!parseInt(response.basket.TOTAL_KOM))
            {
                $('.header-basket-counter').hide();
                $('.header-new-elem-basket').removeClass('green-basket');
            }
            else
            {
                $('.header-basket-counter').show();
                $('.header-new-elem-basket').addClass('green-basket');
            }

            $('.modal-basket-item-count').removeClass('loader');

            initDopSlick();
        });
    });


    $(document).on('click','.modal-basket-item-delete',function()
    {
        $(this).closest('.modal-basket-item').addClass('loader');
        id = $(this).attr('data-id');
        $.ajax({
            url: '/ajax/basket.php',
            data: {id:id,pprocess:'delete', 'url':location.pathname},
            type: 'POST',
            dataType:'json'
        }).done(function(response)
        {
            $('.popup_basket_content').html(response.html_basket);
            $('.popup_basket_total_kom').text('('+response.basket.TOTAL_KOM+')');
            $('.header-basket-counter').html(response.basket.TOTAL_KOM);
            if(!parseInt(response.basket.TOTAL_KOM))
            {
                $('.header-basket-counter').hide();
                $('.header-new-elem-basket').removeClass('green-basket');
            }
            else
            {
                $('.header-basket-counter').show();
                $('.header-new-elem-basket').addClass('green-basket');
            }

            $('.modal-basket-item').removeClass('loader');

            initDopSlick();
        });
    });

    $(document).on('click','.get_popup_basket',function()
    {
        url = location.href.indexOf('/ru/') != -1 ? '/ru/ajax/basket.php' : '/ajax/basket.php';

        $.ajax({
            url: url,
            data: {'url':location.pathname},
            type: 'POST',
            dataType:'json'
        }).done(function(response)
        {
            $('.popup_basket_content').html(response.html_basket);
            $('.popup_basket_total_kom').text('('+response.basket.TOTAL_KOM+')');

            initDopSlick();
        });
    })

    $(document).on('click','.basket-alert-btn, .basket-alert-btn-mob', function()
    {
        $('.get_popup_basket').trigger('click');
        return false;
    });

    $(document).on('click', '.new-card-size-item', function()
    {
        $(this).closest('.new-card-size-list').find('.new-card-size-item').removeClass('active');
        $(this).addClass('active');
    })

    $(document).on('click', '.header-basket-add-remove', function()
    {
        $(".header-basket-add-block").removeClass("opened");
    })

   /* $(document).on('click', '.catalog-item-size', function()
    {
        $(this).closest('.catalog-item-size-list').find('.catalog-item-size').removeClass('active');
        $(this).addClass('active');
    })*/
    function sayHi(phrase, who) {
        //$('.card-basket-add').removeClass('added')
    }

    $(document).on('click', '.buy_product', function()
    {
        blockClosest = $(this).closest('.new-card-btn');
        $(blockClosest).addClass('loader');
        //id = $(this).attr('data-id');
        id = $('.new-card-size-list[data-code="RAZMER"] .new-card-size-item.active').attr('data-id');
        var bys = $(this).hasClass('in_s') ? 1 : 0;
        //cnt = parseInt($('.card-counter').find('input').val());
        cnt = 1;
        $.ajax({
            url: '/ajax/basket.php',
            data: {'pprocess':'add','id':id, 'url':location.pathname, cnt:cnt,bys:bys},
            type: 'POST',
            dataType:'json'
        }).done(function(html)
        {
            $img = $('.first_image').eq(0).attr('src');
            $name = $('[data-entity=name_card]').eq(0).text();
            $('.popup_basket_image').attr('src',$img);
            $('.popup_basket_name').text($name);

            /*link = location.href.indexOf('/ru/') != -1 ? '/ru/basket/' : '/basket/';
            ua = location.href.indexOf('/ru/') == -1;
            textDop = ua ? 'до кошика' : 'в корзину';
            $('.card-basket-add').html('<a href="'+link+'">Перейти '+textDop+' </a>'+$('.card-info-name').text() + ' ' + $('.card-main-info [data-code="RAZMER"] .card-info-size-item.active').text());
            $('.card-basket-add').addClass('added');
            setTimeout(sayHi, 3000);
            if(window.innerWidth <= 672)
            $('html').animate({
                    scrollTop: $('.card-basket-add').offset().top // прокручиваем страницу к требуемому элементу
                }, 500 // скорость прокрутки
            );*/
            $('.header-basket-counter').html(html.basket.TOTAL_KOM);
            if(!parseInt(html.basket.TOTAL_KOM))
            {
                $('.header-basket-counter').hide();
                $('.header-new-elem-basket').removeClass('green-basket');
            }
            else
            {
                $('.header-basket-counter').show();
                $('.header-new-elem-basket').addClass('green-basket');
            }

            $('.basket-items-alert').addClass('opened');

            $(blockClosest).removeClass('loader');

            $('.header-basket-add-block').addClass('opened');

            var text = location.href.indexOf('/ru/') == -1 ? 'Перейти до кошику' : 'Перейти к корзине';
            //$('.new-card-btn').html('<a class="new-card-btn-buy triggeropenbasket">'+text+'</a>');
            $('.triggeropenbasket').show();
        });

        return false;
    });

    $(document).on('click','.new_register_in_popup', function()
    {
        //$('#action-modal').find('button.close').trigger('click');
        //$('[data-param-type="auth"]').trigger('click');
        var UserVariant = $('[name=type_user_register]').val();
        location.href='/auth/registration/?register=yes&choose='+UserVariant;

        /*setTimeout(function()
        {
            $('#auth-page-form').append('<input type="hidden" name="UF_REG_POPUP" value="Так">');
            console.log(UserVariant);
        }, 1000);*/
    });

    $(document).on('click', '.subscribe_me', function()
    {
        email = $(this).closest('form').find('[name=subscribe_email]').val();

        var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;

        if(email != '' && re.test(String(email).toLowerCase()))
        $.ajax({
            url: '/ajax/new/subscribe.php',
            data: {'email':email,'url':location.pathname},
            type: 'POST',
            dataType:'json'
        }).done(function(html)
        {
            $('.subscribe_result').text(html.msg);
        });
        else
        {
            $('.subscribe_result').text('Введіть коректний email');
        }

        return false;
    });



    $(".size-calc-item.item1 .size-calc-slider").slider({
        range: "min",
        value: 1,
        step: 1,
        min: 58,
        max: 102,
        slide: function( event, ui ) {
            $( ".size-calc-item.item1 .size-calc-value input" ).val(ui.value );
        }
    });


    $(".size-calc-item.item1 .size-calc-value input").change(function () {
        var value = this.value.substring(1);
        $(".size-calc-item.item1 .size-calc-slider").slider("value", parseInt(value));
    });

    $(".size-calc-item.item2 .size-calc-slider").slider({
        range: "min",
        value: 1,
        step: 1,
        min: 76,
        max: 116,
        slide: function( event, ui ) {
            $( ".size-calc-item.item2 .size-calc-value input" ).val(ui.value );
        }
    });


    $(".size-calc-item.item2 .size-calc-value input").change(function () {
        var value = this.value.substring(1);
        $(".size-calc-item.item2 .size-calc-slider").slider("value", parseInt(value));
    });

    $(".size-calc-item.item3 .size-calc-slider").slider({
        range: "min",
        value: 1,
        step: 1,
        min: 82,
        max: 118,
        slide: function( event, ui ) {
            $( ".size-calc-item.item3 .size-calc-value input" ).val(ui.value );
        }
    });


    $(".size-calc-item.item3 .size-calc-value input").change(function () {
        var value = this.value.substring(1);
        $(".size-calc-item.item3 .size-calc-slider").slider("value", parseInt(value));
    });



    $(document).on('click', 'iframe', function ()
    {
        console.log('im a click');
    });

    $(document).on('mouseover','.hoverme_1',function()
    {
        $('[data-for="hoverme_1"]').addClass('opened');
    })

    $(document).on('mouseover','.hoverme_2',function()
    {
        $('[data-for="hoverme_2"]').addClass('opened');
    })
    $(document).on('mouseleave','.h-menu-item',function()
    {
        $(this).removeClass('opened')
    });

    $(window).scroll(function(){
            if ( $(".new-card-big-img").scrollTop() == 0){
                var ident = $(this).attr("id");
                console.log(ident);
            }
        });

    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
        var windowTop = $(window).height();

        
        $('.new-card-big-img').each(function() {
            var offset = $(this).offset().top;

            if (offset >= scrollTop && offset < scrollTop + windowTop) {
                var blockId = $(this).attr('id');
                console.log('Верхня границя блоку, що знаходиться у верхній частині сторінки:', blockId);
                
                var targetLink = $('.new-card-small-img[href="#' + blockId + '"]');

                if (targetLink.length) {
                    $(".new-card-small-img").removeClass("active");
                    targetLink.addClass('active');
                }

                return false;
            }
        });
    });

    $( ".basket-alert-close" ).on( "click", function() {
      $(this).parents(".basket-item-alert").removeClass("active");
        $('.basket-items-alert').removeClass('opened');
    });

    $( ".toogler-customer" ).on( "click", function() {
      $('.menu-mob-lists').addClass("cst");
    });

    $( ".menu-mob-back-btn" ).on( "click", function() {
      $('.menu-mob-lists').removeClass("cst");
    });

    $( ".h-menu-list-item-dropdown .icon" ).on( "click", function() {
        if ($(this).parent().hasClass("opened")) {
            $(".h-menu-list-semi").slideUp();  
            $(this).parent().removeClass("opened");
        }else{
            $(".h-menu-list-item-dropdown").removeClass("opened");
            $(".h-menu-list-semi").slideUp();
            $(this).parent().children(".h-menu-list-semi").slideToggle("opened");
            $(this).parent().addClass("opened");
        }
        
    });




    /*function showSubMenu(obj)
    {
        $url = $(obj).find('a').attr('href');
        $id = $(obj).find('a').attr('tohref');

        $('.header-menu-catalog-lists .tab-content .tab-pane').removeClass('active in').hide();
        $($id).addClass('active in').show();

        console.log($url);

        hover = 1;
    }

    $(document).on('mouseover', '.header-menu-catalog-lists .nav.nav-tabs li', function()
    {
        //if(hover) return;
        //hover = 1;
        $url = $(this).find('a').attr('href');
        $id = $(this).find('a').attr('tohref');

        setTimeout(showSubMenu, 300, this);
    })*/

});

