$(document).on('submit','#userLogin',function () {
    let formData = $(this).serializeArray();
    let notify = $(this).find('.notify');
    notify.html('');
    BX.ajax.runComponentAction('2quick:authorize',
        'Auth', { // Вызывается без постфикса Action
            mode: 'class',
            data: {form:formData}, // ключи объекта data соответствуют параметрам метода
        })
        .then(function(response) {
            location.reload();
        }, function (response) {
            notify.addClass('red');
            $.each(response.errors,function (index, value) {
                notify.html(value.message);
            })
        });
    return false
})
$(document).on('submit','#userRegister',function () {
    let formData = $(this).serializeArray();
    let notify = $(this).find('.notify');
    BX.ajax.runComponentAction('2quick:authorize',
        'Register', { // Вызывается без постфикса Action
            mode: 'class',
            data: {form:formData}, // ключи объекта data соответствуют параметрам метода
        })
        .then(function(response) {
            location.href='/auth/?reg=success';
        },function (response) {
            notify.addClass('red');
            $.each(response.errors,function (index, value) {
                notify.html(value.message);
            })
        });
    return false
})