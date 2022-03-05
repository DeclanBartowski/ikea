<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if (method_exists($this, 'setFrameMode')) {
	$this->setFrameMode(true);
}

if ($arResult['ACTION']['status']=='error') {
	ShowError($arResult['ACTION']['message']);
} elseif ($arResult['ACTION']['status']=='ok') {
	ShowNote($arResult['ACTION']['message']);
}
?>
<div class="footer_form-box">
	<div class="title">Подписывайтесь <span class="min">на наши новости</span></div>
	<form action="<?= POST_FORM_ACTION_URI?>" method="post" class="footer-form asd_subscribe_form">
        <?= bitrix_sessid_post()?>
		<input type="hidden" name="asd_subscribe" value="Y" />
		<input type="hidden" name="charset" value="<?= SITE_CHARSET?>" />
		<input type="hidden" name="site_id" value="<?= SITE_ID?>" />
		<input type="hidden" name="asd_rubrics" value="<?= $arParams['RUBRICS_STR']?>" />
		<input type="hidden" name="asd_format" value="<?= $arParams['FORMAT']?>" />
		<input type="hidden" name="asd_show_rubrics" value="<?= $arParams['SHOW_RUBRICS']?>" />
		<input type="hidden" name="asd_not_confirm" value="<?= $arParams['NOT_CONFIRM']?>" />
		<input type="hidden" name="asd_key" value="<?= md5($arParams['JS_KEY'].$arParams['RUBRICS_STR'].$arParams['SHOW_RUBRICS'].$arParams['NOT_CONFIRM'])?>" />
		<input type="text" class="form-footer_input requiredField callback-email" name="asd_email" placeholder="Ваш mail">
		<input type="submit" class="form-footer_submit-btn main-btn js_form-submit asd_subscribe_submit" name="asd_submit" value="<?=GetMessage("ASD_SUBSCRIBEQUICK_PODPISATQSA")?>">
		<div class="asd_subscribe_res"></div>
	</form>
</div>