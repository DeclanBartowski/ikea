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
<div class="main-section">
	<div class="row no-gutters">
        <? if ($arResult['PREVIEW_PICTURE']['SRC']) { ?>
			<div class="col-md-7 order-md-2">
				<div class="main-banner"
				     style="background-image: url(<?= $arResult['PREVIEW_PICTURE']['SRC']; ?>)"></div>
			</div>
        <? } ?>
		<div class="<? if ($arResult['PREVIEW_PICTURE']['SRC']) { ?>col-md-5<? } else { ?>col-md-12<? } ?> left-column">
			<h1><?= $arResult['NAME']; ?></h1>
            <?= $arResult['~PREVIEW_TEXT']; ?>
            <? if ($arResult['PROPERTIES']['URL']['VALUE']) { ?>
				<a href="<?= $arResult['PROPERTIES']['URL']['VALUE']; ?>"
				   class="main-btn"><?= $arResult['PROPERTIES']['URL_TEXT']['VALUE'] ?: 'Смотреть все товары' ?></a>
            <? } ?>
		</div>
	</div>
</div>