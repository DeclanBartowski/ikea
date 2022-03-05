if (typeof($) !== 'undefined') {
	$(document).ready(function() {
		$('.asd_subscribe_submit').click(function(){
			let $this = $(this);
			if (!$.trim($(this).parents('.asd_subscribe_form').find('input[name$="asd_email"]').val()).length) {
				return false;
			}
			var arPost = {};
			arPost.asd_rub = [];
			$.each($(this).parents('.asd_subscribe_form').find('input'), function() {
				if ($(this).attr('type')!='checkbox') {
					arPost[$(this).attr('name')] = $(this).val();
				}
				else if ($(this).attr('type')=='checkbox' && $(this).is(':checked')) {
					arPost.asd_rub.push($(this).val());
				}
			});
            $(this).parents('.asd_subscribe_form').find('.asd_subscribe_res').hide();
            $(this).parents('.asd_subscribe_form').find('.asd_subscribe_submit').attr('disabled', 'disabled');
			$.post('/bitrix/components/asd/subscribe.quick.form/action.php', arPost,
					function(data) {
                        $this.parents('.asd_subscribe_form').find('.asd_subscribe_submit').removeAttr('disabled');
                        $this.parents('.asd_subscribe_form').find('.asd_subscribe_res').html(data.message);
                        $this.parents('.asd_subscribe_form').find('.asd_subscribe_res').show();
					}, 'json');
			return false;
		});
	});
}