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
<? if (!empty($arResult["ITEMS"])) { ?>
	<div class="section-title text-center">Способ доставки</div>
	<div class="row delivery-method_row">
        <? foreach ($arResult["ITEMS"] as $arItem) {
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
                CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
                CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
			<div class="col-md-4" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
				<div class="delivery-method_item">
					<span class="item-icon"><img src="<?= $arItem['ICON']; ?>" alt="alt"></span>
					<div class="item-desc">
						<div class="h4"><?= $arItem['NAME']; ?></div>
						<p><?= $arItem['PREVIEW_TEXT']; ?></p>
					</div>
				</div>
			</div>
        <? } ?>
	</div>
<? } ?>
