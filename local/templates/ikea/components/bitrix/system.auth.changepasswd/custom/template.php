<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?if($arParams["~AUTH_RESULT"]['TYPE']=='OK'){?>
    <div class="unified-inner_content">
        <div class="password-changed_box">
            <div class="password-changed_icon"><img data-src="<?=SITE_TEMPLATE_PATH?>/img/icons/ico-check.svg" alt="alt"></div>
            <p class="section-title">Вы успешно сменили пароль</p>
            <a href="/auth/" class="main-btn main-btn_mod">Перейти к авторизации</a>
        </div>
    </div>
<?} else {?>
    <div class="tab-container">
        <div class="row">
            <div class="col-md-3">
                <ul class="log-register_tab-names">
                </ul>
            </div>
            <div class="col-md-9">
                <div class="tab-item is-visible">
                    <form class="log-register_form" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
                        <?if ($arResult["BACKURL"] <> ''): ?>
                            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                        <? endif ?>
                        <input type="hidden" name="AUTH_FORM" value="Y">
                        <input type="hidden" name="TYPE" value="CHANGE_PWD">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><?=GetMessage("AUTH_LOGIN")?></label>
                                    <input type="email" class="form-control" name="USER_LOGIN" required value="<?=$arResult["LAST_LOGIN"]?>" maxlength="50">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><?=GetMessage("AUTH_CHECKWORD")?></label>
                                    <input type="text" class="form-control" name="USER_CHECKWORD" required value="<?=$arResult["USER_CHECKWORD"]?>" maxlength="50" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?></label>
                                    <input type="password" class="form-control" name="USER_PASSWORD" required value="<?=$arResult["USER_PASSWORD"]?>" maxlength="255" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?></label>
                                    <input type="password" class="form-control" name="USER_CONFIRM_PASSWORD" required value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" maxlength="255" autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <div class="footer-panel">
                            <a href="/auth/" class="forgot-password_btn">Авторизоваться</a>
                        </div>
                        <div class="notify"><?ShowMessage($arParams["~AUTH_RESULT"]);?></div>
                        <div class="text-center">
                            <div class="wrapper-submit main-btn">
                                <input type="submit" class="log-register_form-submit" value="<?=GetMessage("AUTH_CHANGE")?>" name="change_pwd">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
<?}?>
