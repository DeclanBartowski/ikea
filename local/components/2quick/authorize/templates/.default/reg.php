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
<div class="successful-registration_content">
    <span class="successful-registration_icon"><img data-src="<?=SITE_TEMPLATE_PATH?>/img/icons/ico-check.svg" alt=""></span>
    <p class="section-title">Вы успешно зарегистрировались!</p>
    <a href="/personal/" class="main-btn main-btn_mod">Перейти в личный кабинет</a>
</div>