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

$availablePages[] = array(
    "path" => SITE_DIR . 'personal/private/',
    "name" => 'Личные данные',
    "icon" => SITE_TEMPLATE_PATH . '/img/icons/pa/01.svg',
);
$availablePages[] = array(
    "path" => SITE_DIR . 'personal/orders/',
    "name" => 'Текущие заказы',
    "icon" => SITE_TEMPLATE_PATH . '/img/icons/pa/02.svg'
);
$availablePages[] = array(
    "path" => sprintf('%s%s?filter_history=Y', SITE_DIR, 'personal/orders/'),
    "name" => 'История заказов',
    "icon" => SITE_TEMPLATE_PATH . '/img/icons/pa/03.svg'
);

$availablePages[] = array(
    "path" => '/personal/change-password/',
    "name" => 'Смена пароля',
    "icon" => SITE_TEMPLATE_PATH . '/img/icons/pa/04.svg',
    "active" => true
);

?>
<div class="personal-area_section">
	<div class="personal-area_content">
		<div class="row">
			<div class="col-lg-3">
				<ul class="personal-area_menu">
                    <?
                    foreach ($availablePages as $blockElement) {
                        ?>
						<li<?
                        if ($blockElement['active']) {
                            ?> class="tablet-hidden"<?
                        } ?>>
							<div class="personal-area_item<?
                            if ($blockElement['active']) {
                                ?> active<?
                            } ?>">
								<a href="<?= htmlspecialcharsbx($blockElement['path']) ?>">
									<span class="item-icon"><img data-src="<?= $blockElement['icon'] ?>"
									                             alt="alt"></span><?= htmlspecialcharsbx($blockElement['name']) ?>
								</a>
							</div>
						</li>
                        <?
                    }
                    ?>
				</ul>
			</div>
			<div class="col-lg-6">
				<div class="tablet-visible">
					<ul class="personal-area_menu">
                        <?
                        foreach ($availablePages as $blockElement) {
                            ?>
							<li>
								<div class="personal-area_item<?
                                if ($blockElement['active']) {
                                    ?> active<?
                                } ?>">
									<a href="<?= htmlspecialcharsbx($blockElement['path']) ?>">
											<span class="item-icon"><img data-src="<?= $blockElement['icon'] ?>"
											                             alt="alt"></span><?= htmlspecialcharsbx($blockElement['name']) ?>
									</a>
								</div>
							</li>
                            <?
                        }
                        ?>
					</ul>
				</div>
				<span class="personal-area_subtitle">Смена пароля</span>
				<form class="password-form" id="change-password">
					<div class="notify"></div>
					<div class="form-group">
						<input type="password" name="PASSWORD" class="form-control" value="">
						<label class="form-label">Введите новый пароль</label>
						<span class="input_delete-text ico-close"></span>
					</div>
					<div class="form-group">
						<input type="password" name="CONFIRM_PASSWORD" class="form-control" value="">
						<label class="form-label">Подтвердите пароль</label>
						<span class="input_delete-text ico-close"></span>
					</div>
					<div class="text-right">
						<input type="submit" class="password-form_submit-btn main-btn main-btn_mod"
						       value="Сохранить">
					</div>
				</form>
			</div>
			<div class="col-lg-3 right-column">
				<a href="<?=$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), array(
                    "login",
                    "logout",
                    "register",
                    "forgot_password",
                    "change_password"));?>" class="main-btn main-btn_mod back-page_btn">Выйти из кабинета</a>
			</div>
		</div>
	</div>
</div>


