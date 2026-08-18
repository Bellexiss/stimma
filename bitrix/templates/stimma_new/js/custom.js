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
                console.log('BEFORE START SLICK INIT');

                $('.catalog-item-img-slider:not(.slider-off)').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    infinite: false,
                    prevArrow: `
                          <button class=" prev">
                            <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
                            </svg>
                          </button>`,
                    nextArrow: `
                          <button class=" next">
                            <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
                            </svg>
                          </button>`,
                    responsive: [
                        {
                            breakpoint: 600,
                            settings: {
                                arrows: false
                            }
                        }
                    ]
                });

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


                /*setTimeout(function(){
                    console.log('START SLICK INIT');

                }, 2500);*/


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
    console.log('changeData');
    console.log(offersObject[code]);
    block = $(object).closest('.catalog-item');

    if(offersObject[code].img != '')
    {
        $(block).find('.catalog-item-img').remove();
        $(block).find('.catalog-item-img-slider').html(offersObject[code].img);

        console.log('find slider');
        console.log($(block).find('.catalog-item-img-slider:not(.slider-off)'));

        $(block).find('.slick-initialized').slick('unslick');
        $(block).find('.slider-off').removeClass('slider-off');
        $(block).find('.slick-initialized').removeClass('slick-slider slick-initialized');

        $(block).find('.catalog-item-img-slider:not(.slider-off)').slick({
        //$(block).find('.catalog-item-img-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            infinite: false,
            prevArrow: `
                          <button class=" prev">
                            <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
                            </svg>
                          </button>`,
            nextArrow: `
                          <button class=" next">
                            <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
                            </svg>
                          </button>`,
            responsive: [
                {
                    breakpoint: 600,
                    settings: {
                        arrows: false
                    }
                }
            ]
        });

    }

    if(offersObject[code].price)
    {
        $(block).find('.catalog-item-price-block').html('');
        $(block).find('.catalog-item-price-block').html(offersObject[code].price);
    }

    if(offersObject[code].sizes)
    {
        $(block).find('.catalog-item-size-list').html('');
        $(block).find('.catalog-item-size-list[data-code="RAZMER"]').html(offersObject[code].sizes);
    }

    /*
    block = $(object).closest('.catalog-item-block');

    if(offersObject[code].img != '')
        $(block).find('.catalog-item-img a img').attr('src', offersObject[code].img);

    if(offersObject[code].price)
        $(block).find('.catalog-item-price').html(offersObject[code].price);

    if(offersObject[code].price)
        $(block).find('.catalog-item-size-list[data-code="RAZMER"]').html(offersObject[code].sizes);
    */
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

// Готово
function initFavorite()
{
    $.ajax({
        url: '/ajax/favorite.php',
        type: 'post',
        dataType: 'json',
        data: {},
        success: function(data)
        {
            console.log(data);
            $cnt = 0;
            for(i in data.list)
            {
                console.log(data.list[i]);
                $('.catalog-item-favorite a[data-id='+data.list[i]+']').addClass('active');
                $('.card-favorite-block a[data-id='+data.list[i]+']').addClass('active');

                //$('.basket-header-item-favorite[data-id='+data.list[i]+']').find('span.text').text('В обраному');

                $cnt++;

            }

            /*$('.favcounter .counter').text($cnt);
            $cnt = parseInt($cnt);
            if(!$cnt)
                $('.favcounter').addClass('empty');
            else
                $('.favcounter').removeClass('empty');*/
        }
    });
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

function changeSKU(object)
{
    var block = $(object).closest('.catalog-item');
    var color = $(block).find('.catalog-item-color-block[data-code="COLOR_REF"] a.active').attr('data-id');
    var size = $(block).find('.catalog-item-size-list[data-code="RAZMER"] label.active').attr('data-id');
    var name = $(block).find('.catalog-item-name').attr('data-nameurl');

    console.log(color);
    console.log(size);
    console.log(name);

    if (!jsonOffers[name]) return null;

    const product = jsonOffers[name];

    if (!product.COLORS[color]) return null;

    const colorObj = product.COLORS[color];

    if (!colorObj.SIZES[size]) return null;

    var id = colorObj.SIZES[size];

    $(block).find('.catalog-item-btn-buy a').attr('data-id', id);
    console.log(id);
}

$(document).ready(function()
{
    $(window).on("scroll", onScroll);
    onScroll();

    $(document).on('click', '.catalog-item-size-list[data-code="RAZMER"] label', function()
    {
        $(this).closest('.catalog-item-size-list').find('label').removeClass('active');
        //$(this).closest('.catalog-item-size-list').find('input').attr('checked', false);
        //$(this).closest('.catalog-item-size-list').find('input').removeAttr('checked');
        //$(this).closest('.catalog-item-size-list').find('label').find('input').attr('checked', true);
        $(this).addClass('active');

        changeSKU(this);

        return false;
    });
    $(document).on('click', '.catalog-item-color-block[data-code="COLOR_REF"] a', function()
    {
        $(this).closest('.catalog-item-color-block').find('a').removeClass('active');
        $(this).addClass('active');

        changeSKU(this);

        return false;
    });
    $(document).on('click', '.catalog-item-btn-buy', function()
    {
        if($(this).hasClass('nobuy')) return false;
        var obj=this;
        $(this).addClass('loader');
        //id = $(this).attr('data-id');
        var id = $(this).find('a').attr('data-id');
        var bys = 0;
        var bysert = $(this).hasClass('in_sert') ? 1 : 0;

        var sert_name_sender = $('[name=sert_name_sender]').val();
        var sert_tel_sender = $('[name=sert_tel_sender]').val();
        var send_name_receiver = $('[name=send_name_receiver]').val();
        var send_email_receiver = $('[name=send_email_receiver]').val();
        var send_date_receiver = $('[name=send_date_receiver]').val();
        var send_desire = $('[name=send_desire]').val();

        //if(bysert) id = $(this).attr('data-id');

        //cnt = parseInt($('.card-counter').find('input').val());
        cnt = 1;
        $.ajax({
            url: '/ajax/basket.php',
            data: {'pprocess':'add','id':id, 'url':location.pathname, cnt:cnt, bys:bys,bysert:bysert,
                sert_name_sender:sert_name_sender,
                sert_tel_sender:sert_tel_sender,
                send_name_receiver:send_name_receiver,
                send_email_receiver:send_email_receiver,
                send_date_receiver:send_date_receiver,
                send_desire:send_desire
            },
            type: 'POST',
            dataType:'json'
        }).done(function(html)
        {
            /*$img = $('.first_image').eq(0).attr('src');
            $name = $('[data-entity=name_card]').eq(0).text();
            $('.popup_basket_image').attr('src',$img);
            $('.popup_basket_name').text($name);*/


            $('.header-icon-counter').html(html.basket.TOTAL_KOM);
            $('#basket-header').html(html.html_basket);
            if(!parseInt(html.basket.TOTAL_KOM))
            {
                $('.header-icon-counter').hide();
                //$('.header-new-elem-basket').removeClass('green-basket');
            }
            else
            {
                $('.header-icon-counter').show();
                //$('.header-new-elem-basket').addClass('green-basket');
            }

            $('.header-basket-add-block').addClass('opened');

            $('.mobile-control-basket-count').text(html.basket.TOTAL_KOM);
            $('.header-icon-counter').trigger('click');

            $(obj).removeClass('loader');

            //$('.header-basket-add-block').addClass('opened');

            //var text = location.href.indexOf('/ru/') == -1 ? 'Перейти до кошику' : 'Перейти к корзине';
            //$('.triggeropenbasket').show();
        });

        return false;
    });

    // Готово
    initFavorite();
    // Готово
    $(document).on('click', '.catalog-item-favorite a, .card-favorite-block a, .basket_favorite .basket-header-item-favorite, .card-mob-favorite-btn a', function()
    {
        $id = $(this).attr('data-id');
        $obj = $(this);

        $.ajax({
            url: '/ajax/favorite.php?t='+ new Date().getTime(),
            type: 'post',
            dataType: 'json',
            data: {'id': $id},
            xhrFields: {
                withCredentials: true
            },
            success: function(data)
            {
                console.log(data);

                if(data.result == 'removed')
                {
                    $($obj).removeClass('active');
                    if($($obj).hasClass('basket-header-item-favorite'))
                        $($obj).find('span.text').text('В обране');
                }
                else
                {
                    $($obj).addClass('active');
                    if($($obj).hasClass('basket-header-item-favorite'))
                        $($obj).find('span.text').text('В обраному');
                }

                /*$('.favcounter .counter').text(data.cnt);
                data.cnt = parseInt(data.cnt);
                if(!data.cnt || data.cnt == '0' || data.cnt == 0)
                    $('.favcounter').addClass('empty');
                else
                    $('.favcounter').removeClass('empty');*/
            }
        });

        return false;
    })

    /*
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
    */


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
        $(this).closest('.basket-header-item').addClass('loader');
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
            $('.mobile-control-basket-count').text(response.basket.TOTAL_KOM);
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

            $('.basket-header-item').removeClass('loader');

            //initDopSlick();
        });
    });
    // готово
    $(document).on('click','.basket-header-counter-btn.minus_count, .order-item-counter .minus_count', function()
    {
        $(this).closest('.basket-header-item').addClass('loader');
        $(this).closest('.order-item-counter').addClass('loader');
        if(location.href.indexOf('/order/') !== -1)
            var val = parseInt($(this).closest('.order-item-counter').find('input').val())
        else
            var val = parseInt($(this).closest('.basket-header-counter').find('input').val());
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
            $('#basket-header').html(response.html_basket);
            $('.header-icon-counter').text(response.basket.TOTAL_KOM);
            $('.mobile-control-basket-count').text(response.basket.TOTAL_KOM);

            $('.basket-header-item').removeClass('loader');
            $('.order-item-counter').removeClass('loader');

            if(location.href.indexOf('/order/') !== -1) location.reload();

            //initDopSlick();
        });

        return false;
    });
    // Готово
    $(document).on('click','.basket-header-counter-btn.plus_count, .order-item-counter .plus_count', function()
    {
        $(this).closest('.basket-header-item').addClass('loader');
        $(this).closest('.order-item-counter').addClass('loader');
        if(location.href.indexOf('/order/') !== -1)
            var val = parseInt($(this).closest('.order-item-counter').find('input').val());
        else
            var val = parseInt($(this).closest('.basket-header-counter').find('input').val());
        val++;
        var id = $(this).attr('data-id');

        $.ajax({
            url: '/ajax/basket.php',
            data: {id:id,val:val,pprocess:'change', 'url':location.pathname},
            type: 'POST',
            dataType:'json'
        }).done(function(response)
        {
            $('#basket-header').html(response.html_basket);
            $('.header-icon-counter').html(response.basket.TOTAL_KOM);
            $('.mobile-control-basket-count').text(response.basket.TOTAL_KOM);

            $('.basket-header-item').removeClass('loader');
            $('.order-item-counter').removeClass('loader');

            if(location.href.indexOf('/order/') !== -1) location.reload();

            //initDopSlick();
        });

        return false;
    });


    // Готово
    $(document).on('click','.basket-header-item-delete',function()
    {
        $(this).closest('.basket-header-item').addClass('loader');
        id = $(this).attr('data-id');
        $.ajax({
            url: '/ajax/basket.php',
            data: {id:id,pprocess:'delete', 'url':location.pathname},
            type: 'POST',
            dataType:'json'
        }).done(function(response)
        {
            $('#basket-header').html(response.html_basket);
            $('.header-icon-counter').html(response.basket.TOTAL_KOM);
            $('.mobile-control-basket-count').text(response.basket.TOTAL_KOM);

            $('.basket-header-item').removeClass('loader');

            $('.header-goods-views-slider').slick({
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: true,
                infinite: false,
                prevArrow: `
                    <button class=" prev">
                      <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
                      </svg>
                    </button>`,
                nextArrow: `
                    <button class=" next">
                      <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
                      </svg>
                    </button>`

            });

            //initDopSlick();
        });
    });

    $(document).on('click','.get_popup_basket',function()
    {
        url = location.href.indexOf('/ru/') != -1 ? '/ru/ajax/basket.php' : '/ajax/basket.php';
        $('#basket-header').addClass('loader');

        $.ajax({
            url: url,
            data: {'url':location.pathname},
            type: 'POST',
            dataType:'json'
        }).done(function(response)
        {
            $('#basket-header').removeClass('loader');
            $('#basket-header').html(response.html_basket);
            $('.header-icon-counter').html(response.basket.TOTAL_KOM);
            $('.mobile-control-basket-count').text(response.basket.TOTAL_KOM);

            //initDopSlick();
            
              $('.header-goods-views-slider').slick({
                  slidesToShow: 2,
                  slidesToScroll: 1,
                  arrows: true,
                  infinite: false,
                  prevArrow: `
                    <button class=" prev">
                      <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
                      </svg>
                    </button>`,
                          nextArrow: `
                    <button class=" next">
                      <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
                      </svg>
                    </button>`

              });
                        

        });
    })

    $(document).on('click','.basket-alert-btn, .basket-alert-btn-mob', function()
    {
        $('.get_popup_basket').trigger('click');
        return false;
    });

    //готово
    $(document).on('click', '.card-size-item', function()
    {
        $(this).closest('.card-size-block').find('input').prop('checked',false);
        $(this).closest('label').find('input').prop('checked',true);
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

    // Готово
    $(document).on('click', '.buy_product', function()
    {
        var obj=this;
        $(this).addClass('loader');
        //id = $(this).attr('data-id');
        id = $('.card-size-block[data-code="RAZMER"] input:checked').closest('label').find('.card-size-item').attr('data-id');
        var bys = $(this).hasClass('in_s') ? 1 : 0;
        var bysert = $(this).hasClass('in_sert') ? 1 : 0;

        var sert_name_sender = $('[name=sert_name_sender]').val();
        var sert_tel_sender = $('[name=sert_tel_sender]').val();
        var send_name_receiver = $('[name=send_name_receiver]').val();
        var send_email_receiver = $('[name=send_email_receiver]').val();
        var send_date_receiver = $('[name=send_date_receiver]').val();
        var send_desire = $('[name=send_desire]').val();

        if(bysert || $(this).hasClass('current_claude_photo')) id = $(this).attr('data-id');

        //cnt = parseInt($('.card-counter').find('input').val());
        cnt = 1;
        $.ajax({
            url: '/ajax/basket.php',
            data: {'pprocess':'add','id':id, 'url':location.pathname, cnt:cnt, bys:bys,bysert:bysert,
                sert_name_sender:sert_name_sender,
                sert_tel_sender:sert_tel_sender,
                send_name_receiver:send_name_receiver,
                send_email_receiver:send_email_receiver,
                send_date_receiver:send_date_receiver,
                send_desire:send_desire
            },
            type: 'POST',
            dataType:'json'
        }).done(function(html)
        {
            /*$img = $('.first_image').eq(0).attr('src');
            $name = $('[data-entity=name_card]').eq(0).text();
            $('.popup_basket_image').attr('src',$img);
            $('.popup_basket_name').text($name);*/


            $('.header-icon-counter').html(html.basket.TOTAL_KOM);
            $('.mobile-control-basket-count').text(html.basket.TOTAL_KOM);

            $('#basket-header').html(html.html_basket);
            if(!parseInt(html.basket.TOTAL_KOM))
            {
                $('.header-icon-counter').hide();
                //$('.header-new-elem-basket').removeClass('green-basket');
            }
            else
            {
                $('.header-icon-counter').show();
                //$('.header-new-elem-basket').addClass('green-basket');
            }

            $('.header-basket-add-block').addClass('opened');

            $(obj).removeClass('loader');

            if($(obj).hasClass('cardpopup'))
                $('#buy_za_stimz').find('.btn-close').trigger('click');
            $('.header-icon-counter').trigger('click');

            //$('.header-basket-add-block').addClass('opened');

            //var text = location.href.indexOf('/ru/') == -1 ? 'Перейти до кошику' : 'Перейти к корзине';
            //$('.triggeropenbasket').show();
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

    $(document).on('click','.click_show_click_collection',function()
    {
        $('.show_click_catalog').hide();
        $('.show_click_collection').toggle();
        return false;
    });

    $(document).on('click','.click_show_click_catalog',function()
    {
        $('.show_click_catalog').toggle();
        $('.show_click_collection').hide();
        return false;
    });

    $(document).on('click', '.subscribe_me', function()
    {
        console.log('clicked subscribe_me');
        email = $(this).closest('form').find('[name=subscribe_email]').val();

        var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
        console.log(email != '' && re.test(String(email).toLowerCase()));
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


/*
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
    */



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
});

