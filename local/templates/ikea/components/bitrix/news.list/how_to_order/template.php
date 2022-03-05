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
if (!empty($arResult['ITEMS'])) { ?>
	<div class="make-order_section">
		<div class="section-title text-center">
            <?= $arResult['NAME']; ?>
			<small><?= $arResult['DESCRIPTION']; ?></small>
		</div>
		<div class="row make-order_row">
            <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                    array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
				<div class="col-md-4 make-order_item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
					<span class="item-number"><?= $key < 9 ? '0' . ($key+1) : $key+1; ?></span>
					<span class="item-title"><?= $arItem['NAME']; ?></span>
                    <? if ($arItem['PREVIEW_TEXT']) { ?>
						<p><?= $arItem['PREVIEW_TEXT']; ?></p>
                    <? } ?>
                    <? if ($arItem['PROPERTIES']['URL']['VALUE']) { ?>
						<a href="<?= $arItem['PROPERTIES']['URL']['VALUE']; ?>"
						   class="make-order_item-btn"> <?= $arItem['PROPERTIES']['URL_TEXT']['VALUE'] ?: 'Перейти в каталог'; ?></a>
                    <? } ?>
				</div>
            <? endforeach; ?>
		</div>
	</div>
<? } ?>