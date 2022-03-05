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

<form action="<?=POST_FORM_ACTION_URI?>" method="POST" class="callback-form">
    <?=bitrix_sessid_post()?>
	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
	<input type="hidden" name="submit" value="<?=GetMessage("SUBMIT")?>">
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
	<div class="form-group">
		<input name="NAME" type="text" class="form-control requiredField callback-name">
		<label class="form-label">Ваше имя*</label>
	</div>
	<div class="form-group">
		<label class="form-label">Телефон*</label>
		<input name="PHONE" type="tel" class="form-control requiredField callback-phone">
	</div>
	<input type="submit" class="popup-form_submit main-btn js_form-submit" value="Заказать звонок">
	<div class="form-policy">
		Нажимая на кнопку “Заказать звонок” вы даете согласие на <a href="">обработку персональных данных</a>.
	</div>
</form>
