var blockScu = '';

/*function changeData(id, code, object)
{
    console.log(id[code]);
    block = $(object).closest('.catalog-item-block');

    if(id[code].img != '')
        $(block).find('.catalog-item-img a img').attr('src', id[code].img);

    if(id[code].price)
        $(block).find('.catalog-item-price-currency').attr('src', id[code].price.PRINT_DISCOUNT_VALUE);
}*/

/*
function setActiveItem()
{
    $('.catalog-items-block .catalog-item-cont').each(function(i,elem)
    {
        $(elem).find('[data-entity="scu-value"]').removeClass('active');

        mainID = $(elem).attr('data-item');
        offerID = $(elem).attr('offer-item');
        offerItem = offers[mainID]['offers_ids'][offerID];

        for (i in offerItem)
        {
            codeBlock = $(elem).find('[data-code="'+i+'"]');
            valueItem = $(codeBlock).find('[data-entity="scu-value"][data-id="' + offerItem[i] + '"]');
            $(valueItem).addClass('active');
        }
    });
}

function disabledValues()
{
    $('.catalog-items-block .catalog-item-cont').each(function(i,elem)
    {
        $(elem).find('[data-entity="scu-value"]').addClass('no-size');

        mainID = $(elem).attr('data-item');
        console.log('start check main id ' + mainID);
        offerID = $(elem).attr('offer-item');
        offerItem = offers[mainID]['offers_ids'][offerID];
        variants = offers[mainID]['variants'];

        console.log('mainID: '+mainID);
        console.log('offerID: '+offerID);
        console.log('offerItem: '+offerItem);
        console.log('variants: ');
        console.log(variants);
        console.log('scuProps: '+scuProps);
        console.log('elem: '+$(elem));

        check = [];
        for (index in scuProps)
        {
            if(index == 0)
            {
                codeBlock = $(elem).find('[data-code="'+scuProps[index]+'"]');
                //valueItem = $(codeBlock).find('[data-entity="scu-value"]').css('color','inherit');
                valueItem = $(codeBlock).find('[data-entity="scu-value"]').removeClass('no-size');
                check[index] = offerItem[scuProps[index]];

            }
            else
            {
                codeBlock = $(elem).find('[data-code="'+scuProps[index]+'"]');
                console.log('codeBlock');
                console.log(codeBlock);
                console.log('[data - code = "'+scuProps[index]+'"]');
                $(codeBlock).find('[data-entity="scu-value"]').each(function(i2, elem2)
                {
                    value = $(elem2).attr('data-id');
                    console.log('value');
                    console.log(value);
                    check[index] = value;
                    findStr = check.join('-');
                    for (j in variants)
                    {
                        if(variants[j].indexOf(findStr) > -1)
                        {
                            //$(elem).css('color','inherit');
                            $(elem2).removeClass('no-size');
                        }
                    }
                });
            }
        }
    });
}

function initScu()
{
    setActiveItem();
    disabledValues();
}

function findOfferID()
{
    mainID = $(blockScu).attr('data-item');
    variants = offers[mainID]['variants'];
    console.log('start find offer');
    console.log(mainID);
    console.log(blockScu);
    console.log(variants);
    ar = [];
    for (index in scuProps)
    {
        codeBlock = $(blockScu).find('[data-code="'+scuProps[index]+'"]');
        console.log(codeBlock);
        console.log($(codeBlock).find('.active[data-entity="scu-value"]'));
        valueItem = $(codeBlock).find('.active[data-entity="scu-value"]').attr('data-id');
        console.log(valueItem);
        ar[index] = valueItem;
    }
    findStr = ar.join('-');
    console.log(findStr);
    finded = false;
    for (i in variants)
    {
        if(variants[i] == findStr)
        {
            selectedOfferID = i;
            console.log('finded');
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

    console.log('new item');
    console.log(selectedOfferID);
    $(blockScu).attr('offer-item', selectedOfferID);

    $('.buy_product').attr('data-id', selectedOfferID);
    $('.fast_buy_product').attr('data-id', selectedOfferID);
}

function updateSelectOffer()
{
    console.log(jsData);

    mainID = $(blockScu).attr('data-item');
    console.log(mainID);
    console.log(selectedOfferID);
    console.log(jsData[mainID][selectedOfferID].name);
    console.log(jsData[mainID][selectedOfferID].price);
    $(blockScu).find('[data-entity="name"]').html(jsData[mainID][selectedOfferID].name);
    $(blockScu).find('[data-entity="price"]').html(jsData[mainID][selectedOfferID].price);
    //$('[data-entity="price_old"]').html(jsData[selectedOfferID].price_old);

    //if(jsData[selectedOfferID].available)
    //    $('[data-entity="available"]').html($availableTextIn);
    //else
    //    $('[data-entity="available"]').html($availableTextOut);
}

$(document).ready(function()
{
    //blockScu = $('[data-entity="scu"]');

    initScu();

    $(document).on('click', '[data-entity="scu-value"]', function()
    {
        blockScu = $(this).closest('[data-entity="scu"]');
        $(this).closest('[data-entity="scu-values"]').find('[data-entity="scu-value"]').removeClass('active');
        $(this).addClass('active');
        findOfferID();
        disabledValues();
        updateSelectOffer();

        return false;
    });
});
*/