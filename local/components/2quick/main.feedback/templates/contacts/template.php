<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>

<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	?>
    <script>
        $.fancybox.close();
        $.fancybox.open('<div id="thank-modal"><div class="thank"><div class="form-bg"><div class="h2"><?=GetMessage('SUBMITED')?></div><div class="thank-text"><?=$arResult['OK_MESSAGE']?></div></div></div></div>');
    </script>
    <?
}
?>

<form action="<?=POST_FORM_ACTION_URI?>" method="POST" class="contact-form">
    <?=bitrix_sessid_post()?>
	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
	<input type="hidden" name="submit" value="<?=GetMessage("SUBMIT")?>">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<input type="text" name="NAME" class="form-control requiredField callback-name">
				<label class="form-label">Фамилия, Имя, Отчество*</label>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label">Телефон*</label>
				<input type="tel" name="PHONE" class="form-control requiredField callback-phone">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label">Почта</label>
				<input type="email" name="EMAIL" class="form-control">
			</div>
		</div>
	</div>
	<div class="form-group form-group_mod">
		<textarea name="PREVIEW_TEXT" class="form-control requiredField callback-text"></textarea>
		<label class="form-label">Ваш вопрос*</label>
	</div>
	<div class="contact-form_footer">
		<div class="form-policy">
			Нажимая на кнопку “Отправить” вы даете согласие на обработку персональных данных.
		</div>
		<input type="submit" class="contact-form_submit-btn main-btn js_form-submit" value="Отправить">
	</div>
</form>
