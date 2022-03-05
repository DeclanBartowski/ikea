$(document).on('submit', '#ORDER', function (e) {
    e.preventDefault();
    var errorBlock = $('.tq_error_order');
    errorBlock.hide();
    BX.ajax.runComponentAction('2quick:order',
        'createOrder', { // Вызывается без постфикса Action
            mode: 'class',
            data: {data: $('#ORDER').serializeArray()}, // ключи объекта data соответствуют параметрам метода
        })
        .then(function (response) {
            if (response.data.STATUS == 'ERROR') {
                errorBlock.find('.error-text').html(response.data.HTML);
                errorBlock.show();
                $('html, body').animate({
                    scrollTop: $('#ORDER').offset().top - 200
                }, {
                    duration: 370,   // по умолчанию «400»
                    easing: "linear" // по умолчанию «swing»
                });
            } else {
                errorBlock.find('.error-text').html('');
                errorBlock.hide();
                location.href = '?ORDER_ID=' + response.data
            }
        });
    return false;
});

$(document).on('change', '[name=LOCATION]', function (e) {
    if ($(this).val().length > 0) {
        $('.delivery_description').hide();
        $('.delivery_description').html('');
        BX.ajax.runComponentAction('2quick:order',
            'getupdateDeliveries', { // Вызывается без постфикса Action
                mode: 'class',
                data: {
                    userCityId: $(this).val(),
                }, // ключи объекта data соответствуют параметрам метода
            })
            .then(function (response) {
                if(response.data.show_delivery_description){
                    $('.delivery_description').html(response.data.delivery_description);
                    $('.delivery_description').show();
                }
                $('.delivery-data').html(response.data.delivery_info);
                $('.cart-total-sum').html(response.data.basket_sum);
                $('.discount_sum').html(response.data.discount_price);
                $('.cart-total_sum').html(response.data.total);

                console.log(response);
            });
    }
});