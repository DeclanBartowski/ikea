$(document).on('submit','#change-password',function () {
    let formData = $(this).serializeArray();
    let notify = $(this).find('.notify');
    BX.ajax.runComponentAction('2quick:password.change',
        'Change', { // Вызывается без постфикса Action
            mode: 'class',
            data: {form:formData}, // ключи объекта data соответствуют параметрам метода
        })
        .then(function(response) {
            location.href='/personal/change-password/?change=success';
        },function (response) {
            notify.addClass('red');
            $.each(response.errors,function (index, value) {
                notify.html(value.message);
            })
        });
    return false
});
