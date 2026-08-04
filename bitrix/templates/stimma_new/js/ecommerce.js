var viewItems = '';

function addViewItem(id, name, price,category,index,event,send=false,list_name='Items Category List',quantity=1)
{
    console.log('addViewItem');
    if(viewItems != '') viewItems += ',';
    viewItems += '{\n' +
        'item_name: "'+name+'",\n' +
        'item_id: "'+id+'",\n' +
        'price: '+price+',\n' +
        'item_brand: "STIMMA",\n' +
        'item_category: "'+category+'",\n' +
        'item_list_name: "'+list_name+'",\n' +
        'index: '+index+',\n' +
        'quantity: '+quantity+'\n' +
        '}';

    if(send)
        sendViewItems(event);
}

function sendViewItems(event)
{
    console.log('sendViewItems');
    console.log('viewItems');
    console.log(viewItems);
    if(viewItems == '') return;
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
        event: "'"+event+"'",
        ecommerce: {
            items: [viewItems]
        }
    });

    viewItems = '';
}

function sendOrder(id, price)
{
    if(viewItems == '') return;
    console.log('sendOrder');
    console.log('viewItems');
    console.log(viewItems);
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
        event: "purchase",
        ecommerce: {
            transaction_id: "'"+id+"'",
            affiliation: "Online Store",
            value: price,
            //tax: "4.90",
            //shipping: "5.99",
            currency: "UAH",
            //coupon: "SUMMER_SALE",
            items: [viewItems]
        }
    });
    viewItems = '';
}

/*
function addToCartEK(id, name, price,category,index,event,send=false,list_name='Items Category List',quantity=1, basePrice = 0)
{
    cnt = $('.card-counter').find('input').val();
    cnt = parseInt(cnt);
    if(!cnt || cnt < 1) cnt = 1;
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
        'ecommerce': {
            'currencyCode': 'UAH',
            'add': {
                'products': [{
                    'name': `${name}`,
                    'id': id,
                    'baseId': id,
                    'price': price*cnt,
                    'brand': 'STIMMA',
                    'category': `${category}`,
                    //'variant': 'Variant 1',
                    'quantity': cnt
                }]
            }
        },
        'event': 'gtm-ee-event',
        'gtm-ee-event-category': 'Enhanced Ecommerce',
        'gtm-ee-event-action': 'Adding a Product to a Shopping Cart',
        'gtm-ee-event-non-interaction': 'False',
        'dyn-rem-ids': id,
        'dyn-rem-pagetype': 'cart',
        'dyn-rem-value': price*cnt,
    });

    discountValue = basePrice-price;
    if(discountValue < 0)
        discountValue = 0;

    dataLayer.push({ ecommerce: null });
    dataLayer.push({
        event: "add_to_cart",
        ecommerce: {
            currency: "UAH",
            value: price*cnt,
            items: [
                {
                    item_id: ""+id+"",
                    item_name: `${name}`,
                    affiliation: "STIMMA",
                    discount: discountValue,
                    index: cnt,
                    item_brand: "STIMMA",
                    item_category: `${category}`,
                    item_list_id: id,
                    item_list_name: `${name}`,
                    price: basePrice,
                    quantity: cnt
                }
            ]
        }
    });

    fbq ( 'track', 'AddToCart',
        {
            Currency: 'USD',
            Content_ids: ""+id+"",
            Content_type: 'AddToCart',
            Content_category: `${category}`,
        });

    console.log('AddToCart facebook pixel');
    console.log({
        Currency: 'UAH',
        Content_ids: ""+id+"",
        Content_type: 'AddToCart',
        Content_category: `${category}`,
    });


    console.log('add_to_cart 1');

    console.log({
        item_id: ""+id+"",
        item_name: `${name}`,
        affiliation: "STIMMA",
        discount: discountValue,
        index: cnt,
        item_brand: "STIMMA",
        item_category: `${category}`,
        item_list_id: id,
        item_list_name: `${name}`,
        price: basePrice,
        quantity: cnt
    })
}*/

function addToCartEK(id, name, price, category, index, event, send = false, list_name = 'Items Category List', quantity = 1, basePrice = 0) {
    let cnt = $('.card-counter').find('input').val();
    cnt = parseInt(cnt);
    if (!cnt || cnt < 1) cnt = 1;

    // Расчёт скидки
    let discountValue = basePrice - price;
    if (discountValue < 0) discountValue = 0;

    // Facebook Pixel only
    fbq('track', 'AddToCart', {
        currency: 'UAH',
        content_ids: [id],
        content_type: 'product',
        content_category: `${category}`,
        value: price * cnt
    });

    dataLayer.push({ ecommerce: null });
    dataLayer.push({
        event: "add_to_cart",
        ecommerce: {
            currency: "UAH",
            value: price*cnt,
            items: [
                { 
                    item_id: ""+id+"",
                    item_name: `${name}`,
                    affiliation: "STIMMA",
                    discount: discountValue,
                    index: cnt,
                    item_brand: "STIMMA",
                    item_category: `${category}`,
                    item_list_id: id,
                    item_list_name: `${name}`,
                    price: basePrice,
                    quantity: cnt
                }
            ]
        }
    });

    // Отладка
    console.log('add_to_cart FB only');

    console.log({
        item_id: id,
        item_name: name,
        price: basePrice,
        discount: discountValue,
        quantity: cnt
    });
}