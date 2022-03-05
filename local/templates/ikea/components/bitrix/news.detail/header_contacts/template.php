<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="footer-contact">
    <? if ($arResult['PROPERTIES']['PHONE']['VALUE']) { ?>
		<a href="tel:+<?= preg_replace('~\D~', '', $arResult['PROPERTIES']['PHONE']['VALUE']) ?>"
		   class="footer_phone-number">
			<span class="ico-phone"></span>
            <?= $arResult['PROPERTIES']['PHONE']['VALUE']; ?>
		</a>
    <? } ?>
    <? if ($arResult['PROPERTIES']['EMAIL']['VALUE']) { ?>
		<a href="mailto:<?= $arResult['PROPERTIES']['EMAIL']['VALUE']; ?>" class="footer-email">
			<span class="ico-email"></span>
            <?= $arResult['PROPERTIES']['EMAIL']['VALUE']; ?>
		</a>
    <? } ?>
</div>