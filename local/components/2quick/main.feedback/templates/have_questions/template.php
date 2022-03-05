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
<div class="form-section">
	<div class="row no-gutters">
		<div class="col-md-7 order-md-2">
			<div class="static-form_bg" style="background-image: url(<?= SITE_TEMPLATE_PATH;?>/img/bg/form/01.jpg)"></div>
		</div>
		<div class="col-md-5 left-column">
			<div class="section-title">
				У вас появились вопросы?
			</div>
			<span class="top-text">Оставьте нам свою заявку и мы с вами свяжемся в ближайшее время</span>
			<form action="<?=POST_FORM_ACTION_URI?>" method="POST"  class="static-form">
                <?=bitrix_sessid_post()?>
				<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
				<input type="hidden" name="submit" value="<?=GetMessage("SUBMIT")?>">
				<div class="form-group">
					<input type="text" class="form-control" name="NAME">
					<label class="form-label">Ф.И.О.</label>
				</div>
				<div class="form-group">
					<label class="form-label">Телефон*</label>
					<input type="tel" class="form-control requiredField callback-phone" name="PHONE" required>
				</div>
				<div class="form-group form-group_mod">
					<textarea class="form-control requiredField callback-text" name="PREVIEW_TEXT" required></textarea>
					<label class="form-label">Ваш вопрос*</label>
				</div>
				<input type="submit" class="main-btn form-static_submit js_form-submit" value="Отправить">
			</form>
		</div>
	</div>
</div>