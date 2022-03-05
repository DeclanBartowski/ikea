<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>

<div class="tab-container login_tab-container">
    <div class="row">
        <div class="col-md-3">
            <ul class="log-register_tab-names">
            </ul>
        </div>
        <div class="col-md-9">
            <div class="tab-item is-visible">
                <form class="log-register_form" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
                    <?
                    if ($arResult["BACKURL"] <> '')
                    {
                        ?>
                        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                        <?
                    }
                    ?>
                    <input type="hidden" name="AUTH_FORM" value="Y">
                    <input type="hidden" name="TYPE" value="SEND_PWD">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" name="USER_LOGIN" required>
                                <input type="hidden" name="USER_EMAIL" />
                            </div>
                        </div>
                    </div>
                    <div class="footer-panel">
                        <a href="/auth/" class="forgot-password_btn">Авторизоваться</a>
                    </div>
                    <div class="notify"><?ShowMessage($arParams["~AUTH_RESULT"]);?></div>
                    <div class="text-center">
                        <div class="wrapper-submit main-btn">
                            <input type="submit" class="log-register_form-submit" value="<?=GetMessage("AUTH_SEND")?>" name="send_account_info">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
document.bform.USER_LOGIN.focus();
</script>
