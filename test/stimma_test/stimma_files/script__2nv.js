var blockScu = '';


$(document).ready(function()
{
    console.log('asdasdasds obraz_add_basket');

    $(document).on('click','.obraz_add_basket',function()
    {
        $(this).closest('.look-modal-total-btns').addClass('loader');
        var val = $(this).val();
        var id = $(this).attr('data-lookid');

        $.ajax({
            url: '/ajax/basket.php',
            data: {id:id,val:val,pprocess:'get_the_look', 'url':location.pathname},
            type: 'POST',
            dataType:'json'
        }).done(function(response)
        {
            $('.popup_basket_content').html(response.html_basket);
            $('.popup_basket_total_kom').text('('+response.basket.TOTAL_KOM+')');
            $('.mobile-control-basket-count').text(response.basket.TOTAL_KOM);
            $('.header-icon-counter').html(response.basket.TOTAL_KOM);
            if(!parseInt(response.basket.TOTAL_KOM))
            {
                $('.header-icon-counter').hide();
                //$('.header-new-elem-basket').removeClass('green-basket');
            }
            else
            {
                $('.header-icon-counter').show();
                //$('.header-new-elem-basket').addClass('green-basket');
            }

            $('.look-modal-total-btns').removeClass('loader');

            $('.look-modal .btn-close').trigger('click');
            //$('.get_popup_basket').trigger('click');
            $('.header-icon-counter').trigger('click');

            //initDopSlick();
        });

        return false;
    });
})