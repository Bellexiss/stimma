/*
You can use this file with your scripts.
It will not be overwritten when you upgrade solution.
*/

var hover = 0;

function loadMore(href,replace = false, triggerClick = false, callBack = false){
    console.log('startloadMore');
    console.log(href);
    let fData = new FormData();
    fData.append(`get_catalog_ajax_filter`, 'y');

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
                if($('.insertpag').closest('.row').find('.section_review').length)
                {
                    $('.insertpag').closest('.row').find('.section_review').before(data[2]);
                }
                else
                    $('.insertpag').closest('.row').append(data[2]);
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

$(document).ready(function()
{
    getDataForChange();

                /*if ($(window).width() >= '767'){
           
                    var zzz = $(".easyzoom").easyZoom();
                    var easyzoomAPI = zzz.data('easyZoom');
                    console.log(easyzoomAPI);
                }*/

    $(document).on('click', '.card-info-size-item', function()
    {
        $(this).closest('.card-info-size').find('.card-info-size-item').removeClass('active');
        $(this).addClass('active');
    })

    $(document).on('click', '.catalog-item-size', function()
    {
        $(this).closest('.catalog-item-size-list').find('.catalog-item-size').removeClass('active');
        $(this).addClass('active');
    })
    function sayHi(phrase, who) {
        //$('.card-basket-add').removeClass('added')
    }

    $(document).on('click', '.buy_product', function()
    {
        //id = $(this).attr('data-id');
        id = $('.card-main-info [data-code="RAZMER"] .card-info-size-item.active').attr('data-id');
        cnt = parseInt($('.card-counter').find('input').val());
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

    $(document).on('click', '.subscribe_me', function()
    {
        email = $('[name=subscribe_email]').val();

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

