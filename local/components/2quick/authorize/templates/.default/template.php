<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
use Bitrix\Main\Page\Asset;
/** @var array $arParams */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var array $arResult */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="tab-container login_tab-container">
    <div class="row">
        <div class="col-md-3">
            <ul class="log-register_tab-names">
                <li class="tab active">Вход</li>
                <li class="tab">Регистрация</li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="tab-item is-visible">
                <form action="#" class="log-register_form" id="userLogin">
                    <div class="form-group">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Пароль</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="footer-panel">
                        <label class="unified-checkbox">
                            <input value="Y" type="checkbox" name="save">
                            <span class="checkbox-text">Запомнить меня</span>
                        </label>
                        <a href="/auth/forgot/" class="forgot-password_btn">Забыли пароль?</a>
                    </div>
                    <div class="notify"></div>
                    <div class="text-center">
                        <input type="submit" class="login_form-submit main-btn" value="Войти">
                    </div>
                </form>
            </div>
            <div class="tab-item">
                <div class="register-content">
                    <form action="#" class="log-register_form register-form" id="userRegister">
                        <div class="row">
                            <div class="col-lg-8 col-md-7">
                                <div class="form-group">
                                    <label class="form-label">Фамилия, имя, отчество*</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5">
                                <span class="register-prompt">Заполните, чтобы мы знали, как к вам обращаться.</span>
                            </div>
                            <div class="col-lg-8 col-md-7">
                                <div class="form-group">
                                    <label class="form-label">E-mail*</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5">
                                <span class="register-prompt">Для отправки уведомлений о статусе заказа.Используйте как логин для входа в личный кабинет.</span>
                            </div>
                            <div class="col-lg-8 col-md-7">
                                <div class="form-group">
                                    <label class="form-label">Tелефон*</label>
                                    <input type="tel" class="form-control" name="phone" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5">
                                <span class="register-prompt">Необходим для уточнения деталей заказа.</span>
                            </div>
                            <div class="col-lg-8 col-md-7">
                                <div class="form-group">
                                    <label class="form-label">Пароль*</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5">
                                <span class="register-prompt">Пароль должен состоять минимум из 6 знаков.</span>
                            </div>
                            <div class="col-lg-8 col-md-7">
                                <div class="form-group">
                                    <label class="form-label">Подтверждение пароля*</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-7">
                                <div class="form_agree_text">
                                    <label class="unified-checkbox">
                                        <input value="Y" type="checkbox" name="privacy" required>
                                        <span class="checkbox-text">Я согласен на обработку персональных данных</span>
                                    </label>
                                </div>
                                <div class="notify"></div>
                                <input type="submit" class="register_form-submit main-btn" value="Зарегистрироваться">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>