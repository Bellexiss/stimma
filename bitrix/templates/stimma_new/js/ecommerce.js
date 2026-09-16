var viewItems = '';

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