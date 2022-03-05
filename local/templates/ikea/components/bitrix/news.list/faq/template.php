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
	<div class="qustions-section">
		<div class="qustions-content">
            <? foreach ($arResult["ITEMS"] as $arItem) { ?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                    array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
				<div class="qustion-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
					<div class="qustion-item_title">
                        <?= $arItem['NAME']; ?> <span class="ico-plus"></span>
					</div>
					<div class="qustion-item_body">
						<p><?= $arItem['PREVIEW_TEXT']; ?></p>
					</div>
				</div>
            <? } ?>
		</div>
	</div>
<? } ?>
