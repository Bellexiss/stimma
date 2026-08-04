$(document).ready(function()
{
    $(document).on('change', '[name="dost[14][city]"],[name="dost[17][city]"]', function()
    {
        var cityID = $(this).val();
        console.log('change choose_city_np');
        console.log(cityID);
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

        if($(this).attr('name') == 'dost[14][city]') whereUrl += '?type=viddilennya';
        if($(this).attr('name') == 'dost[17][city]') whereUrl += '?type=pochtomat';

        $.ajax({
            url: '/ajax/'+whereUrl,
            data: {cityID: cityID, url:location.href},
            type: 'POST',
            dataType:'json'
        }).done(function(html)
        {
            $(block).find('.choose_city').find('span.select2').remove();
            $(block).find('.choose_city select').html(html.html_vid);
            //$('[name="choose_city_np_vid"]').closest('.form-block').show();
            $(block).find('.choose_city select').select2();
        });

        console.log($(block).find('[name=choose_city_np]').find('option:selected').text());
    });

    $(document).on('change', '[name="dost[15][city]"]', function()
    {
        var cityID = $(this).val();
        console.log('change choose_city_np');
        console.log(cityID);
        var block=$(this).closest('.order-detail-element');
        value = $(block).find('[name=choose_city_np]').find('option:selected').text();
        $('input#soa-property-5').val(value);
        $('input#soa-property-4').val(value);
        val = $(block).find('[name=choose_city_np]').val();

        whereUrl = 'get_city_posts_ukr.php';

        if($(this).attr('name') == 'dost[14][city]') whereUrl += '?type=viddilennya';
        if($(this).attr('name') == 'dost[17][city]') whereUrl += '?type=pochtomat';

        $.ajax({
            url: '/ajax/'+whereUrl,
            data: {cityID: cityID, url:location.href},
            type: 'POST',
            dataType:'json'
        }).done(function(html)
        {
            $(block).find('.choose_city').find('span.select2').remove();
            $(block).find('.choose_city select').html(html.html_vid);
            //$('[name="choose_city_np_vid"]').closest('.form-block').show();
            $(block).find('.choose_city select').select2();
        });

        console.log($(block).find('[name=choose_city_np]').find('option:selected').text());
    });

    $('[name="dost[14][city]"], [name="dost[17][city]"]').select2({
        width: '100%',
        ajax: {
            url: "/ajax/get_city_np.php",
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

    $('[name="dost[15][city]"]').select2({
        width: '100%',
        ajax: {
            url: "/ajax/get_city_ukr.php",
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


});