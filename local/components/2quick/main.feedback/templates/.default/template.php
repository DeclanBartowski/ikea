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
<div class="form-bg">
    <form action="<?=POST_FORM_ACTION_URI?>" method="POST">
        <?=bitrix_sessid_post()?>
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="hidden" name="submit" value="<?=GetMessage("SUBMIT")?>">
        <input type="hidden" name="tabName" value="">
        <input type="hidden" name="SHOP" value="">
        <input type="hidden" name="formType" value="contacts">
        <div class="h2"><?=GetMessage('TITLE')?></div>
        <div class="form-fix">
            <div class="row">
                <div class="col-6">
                    <label for="">
                        <span><?=GetMessage('NAME')?> *</span>
                        <input type="text" name="NAME" value="<?=$arResult['AUTHOR_NAME']?>" class="form-control" required>
                    </label>
                </div>
                <div class="col-6">
                    <label for="">
                        <span><?=GetMessage('EMAIL')?> *</span>
                        <input type="email" name="EMAIL" value="<?=$arResult['AUTHOR_EMAIL']?>" class="form-control" required>
                    </label>
                </div>
                <div class="col-12">
                    <label for="">
                        <span><?=GetMessage('MESSAGE')?> *</span>
                        <textarea required class="form-control" name="PREVIEW_TEXT"></textarea>
                    </label>
                </div>
                  <?if($arParams["USE_CAPTCHA"] == "Y"):?>
                      <div class="mf-captcha">
                          <div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
                          <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
                          <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
                          <div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
                          <input type="text" name="captcha_word" size="30" maxlength="50" value="">
                      </div>
                  <?endif;?>
                <div class="col-12">
                    <div class="flex v-center agree">
                        <button class="btn btn-primary btn-lg"><?=GetMessage("SUBMIT")?></button>
                        <div class="agreement"><?=GetMessage('PRIVACY',['URL'=>'/privacy-policy/'])?></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(function() {
        $('input[name=tabName]').val($('.tab_type_1').find('li.active a').text());
        $('input[name=SHOP]').val($('.tab_type_1').find('li.active a').data('id'));
    });
</script>