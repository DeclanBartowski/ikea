function initPage() {
    $('input[type="tel"]').inputmask("+7 (999) 999 99 99", {
        "clearIncomplete": true,
        showMaskOnHover: false,
    });
    $('.form-control').focus(function () {
        $(this).closest('.form-group').addClass('focus');
        $(this).closest('.form-group').find('.input_delete-text').addClass('is-visible');
    });
    $('.form-control').blur(function () {
        if ($(this).val().length == 0) {
            $(this).closest('.form-group').removeClass('focus');
            $(this).closest('.form-group').find('.input_delete-text').removeClass('is-visible');
        }
    });
    $('.input_delete-text').on("click", function () {
        $(this).closest('.form-group').find('.form-control').val(' ');
        $(this).closest('.form-group').removeClass('focus');
        $(this).removeClass('is-visible');
    });
    $('form').find('.form-control').each(function () {
        if ($(this).val().length > 1) {
            $(this).closest('.form-group').addClass('focus');
            $(this).closest('.form-group').find('.input_delete-text').addClass('is-visible');
        }
    });
    lazyLoad($('body'));
    $('.js-select').selectric({
        maxHeight: 300,
        disableOnMobile: false,
        nativeOnMobile: false,
    });
}

BX.addCustomEvent('onAjaxSuccess', function () {
    initPage();
});

function ajaxUpdate() {
    $.get(location.pathname, function (data) {
        //$('.cart-section').html($(data,'.cart-section').html());
        $('.cart-section').html(data);
        lazyLoad($('body'));
        $('.js-select').selectric({
            maxHeight: 300,
            disableOnMobile: false,
            nativeOnMobile: false,
        });
    });
    BX.onCustomEvent('OnBasketChange');
}

$(document).on('click', '[data-show-more]', function () {
    var btn = $(this);
    var page = btn.attr('data-next-page');
    var id = btn.attr('data-show-more');
    //var bx_ajax_id = btn.attr('data-ajax-id');
    //var block_id = "#comp_"+bx_ajax_id;
    //var addClear = btn.attr('data-add-clear');
    var data = {};
    data['PAGEN_' + id] = page;

    $.ajax({
        type: "GET",
        url: window.location.href,
        data: data,
        success: function (data) {
            var list = $(data).find('.dds-list-items').html();
            $('.dds-list-pag').remove();
            $('.dds-list-items').append(list);
            $('.dds-list-items').after($(data).find('.dds-list-pag'));
            initPage();
        }
    });
});

$(document).on('click change submit', '[data-class]', function (e) {
    let mClass = $(this).data('class');
    let method = $(this).attr('data-method');
    let $this = $(this);
    let data = {};
    let items = [];
    data['method'] = method;

    switch (e.type) {
        case 'click':
            switch (method) {
                case 'delete_custom':
                    $('.products-list').find('[name="product-delete"]').each(function () {
                        if ($(this).prop('checked')) items.push($(this).val());
                    });
                    data['items'] = items;
                    break;
                case 'add2basket':
                    let id = $this.data('id');
                    data['id'] = id;
                    data['quantity'] = $this.parents('.dds-parent-basket').find('[name="dds-quantity"]').val();
                    break;
                case 'delete':
                    data['id'] = $this.attr('data-id');
                    break;
                case 'compfav':
                    data['id'] = $this.attr('data-id');
                    data['add'] = $this.attr('data-add');
                    break;
                case 'compfavdelete':
                    data['id'] = $this.attr('data-id');
                    data['add'] = $this.attr('data-add');
                    break;
                case 'clear_favorites':
                    break;
                case 'clear':
                    break;
                default:
                    return false;
            }
            break;
        case 'change':
            switch (method) {
                case 'update':
                    data['id'] = $this.attr('data-id');
                    data['quantity'] = $this.val();
                    break;
                default:
                    return false;
            }
            break;
        case 'submit':
        default:
            return false;
    }

    $.ajax({
        url: "/api/2quick/ajax/index.php",
        type: "POST",
        dataType: 'json',
        data: {action: mClass, data: data},
        success: function (result) {
            switch (method) {
                case 'clear':
                case 'update':
                case 'delete_custom':
                case 'delete':
                    if ($this.closest('.bx-soa-coupon-item')) {
                        $this.closest('.bx-soa-coupon-item').remove();
                    }
                    ajaxUpdate();
                    break;
                case 'add2basket':
                    ajaxUpdate();
                    $this.removeClass('ico-cart');
                    $this.addClass('is-active');
                    $this.removeAttr('data-class').removeAttr('data-method').removeAttr('data-id').attr('href', '/basket/');
                    break;
                case 'compfav':
                    $this.addClass('is-active');
                    $this.attr('data-method', 'compfavdelete');
                    if ($this.attr('data-page-refresh') === 'Y') {
                        location.reload();
                    }
                    BX.onCustomEvent('OnBasketChange');
                    break;
                case 'compfavdelete':
                    $this.removeClass('is-active');
                    $this.attr('data-method', 'compfav');
                    if ($this.attr('data-page-refresh') === 'Y') {
                        location.reload();
                    }
                    BX.onCustomEvent('OnBasketChange');
                    break;
                case 'clear_favorites':
                    location.reload();
                    BX.onCustomEvent('OnBasketChange');
                    break;
            }

        }
    });
    return false;
});

function reInitFilter(){
    var sliders = $(".slider-range");
    sliders.each(function() {
        var number = parseInt($(this).closest('.filter-number').find('.price-min').data('number'));
        var number2 = parseInt($(this).closest('.filter-number').find('.price-max').data('number'));

        var valMin = parseInt($(this).closest('.filter-number').find(".price-min").val());
        var valMax = parseInt($(this).closest('.filter-number').find(".price-max").val());

        if($(this).closest('.filter-number').find(".price-min").val() == '') valMin = number;
        if($(this).closest('.filter-number').find(".price-max").val() == '') valMax = number2;
        console.log(valMin,valMax,number,number2);

        $(this).closest('.filter-number').find(".price-min").on('input', function() {
            var value1 = $(this).val();
            var rep = /[a-zA-Zа-яА-Я]/;
            if (rep.test(value1)) {
                value1 = value1.replace(rep, '');
                $(this).val(value1);
            }
        });
        $(this).closest('.filter-number').find(".price-max").on('input', function() {
            var value2 = $(this).val();
            var rep = /[a-zA-Zа-яА-Я]/;
            if (rep.test(value2)) {
                value2 = value2.replace(rep, '');
                $(this).val(value2);
            }
        });
        $(this).closest('.filter-number').find(".price-min").on('change', function() {
            var value1 = parseInt($(this).val());
            var value2 = parseInt($(this).closest('.filter-number').find('.price-max').val());
            if ($(this).val() == '') value1 = 1
            if (value1 > number2) {
                $(this).val(number2);
                value1 = number2;
            }
            if (value1 < number) {
                $(this).val(number);
                value1 = number;
            }
            if (value1 > value2) {
                $(this).val(value2);
                value1 = value2;
            }
            $(this).closest('.filter-number').find('.slider-range').slider("values", 0, value1);
            $(this).closest('.filter-number').find(".first-price").text(value1);
        });
        $(this).closest('.filter-number').find(".price-max").on('change', function() {
            var value1 = parseInt($(this).closest('.filter-number').find(".price-min").val());
            var value2 = parseInt($(this).val());
            if ($(this).val() == '') value2 = 2000
            if (value2 > number2) {
                $(this).val(number2);
                value2 = number2;
            }
            if (value2 < number) {
                $(this).val(number);
                value2 = number;
            }
            if (value1 > value2) {
                $(this).val(value1);
                value2 = value1;
            }
            $(this).closest('.filter-number').find('.slider-range').slider("values", 1, value2);
            $(this).closest('.filter-number').find(".second-price").text(value2);
        });
        if($(this).hasClass('slider-range_vertical')){
            $(this).slider({
                animate: true,
                range: true,
                orientation: "vertical",
                min: number,
                max: number2,
                values: [valMin, valMax],
                slide: function(event, ui) {
                    $(this).closest('.filter-number').find(".price-min").val(ui.values[0] + " " + "руб.");
                    $(this).closest('.filter-number').find(".price-max").val(ui.values[1] + " " + "руб.");
                },
                change: function () {
                    $(this).parents('.smartfilter').submit();
                }
            });
        } else{
            $(this).slider({
                animate: true,
                range: true,
                min: number,
                max: number2,
                values: [valMin, valMax],
                slide: function(event, ui) {
                    $(this).closest('.filter-number').find(".price-min").val(ui.values[0]);
                    $(this).closest('.filter-number').find(".price-max").val(ui.values[1]);
                    $(this).closest('.filter-number').find(".first-price").text(ui.values[0]);
                    $(this).closest('.filter-number').find(".second-price").text(ui.values[1]);
                },
                change: function () {
                    $(this).parents('.smartfilter').submit();
                }
            });
        }
    });
}

$(document).on('submit change', '.smartfilter', function () {
    var filterFixed = $('.filter-fixed').hasClass('is-open');
    $.ajax({
        url: location.pathname,
        type: "GET",
        data: $(this).serialize(),
        success: function (result) {

            $('.catalog-section').html($('.catalog-section',result).html());
            if(filterFixed){
                $('.filter-fixed').addClass('is-open');
            }
            reInitFilter();
            initPage();
        },
    });
    return false;
});