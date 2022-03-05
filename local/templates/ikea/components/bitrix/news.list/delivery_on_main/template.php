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
	<div class="delivery-section">
		<div class="row">
            <? foreach ($arResult["ITEMS"] as $key => $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                    array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                switch ($key) {
                    case '0':
                        $class = 'col-md-4 delivery-item';
                        break;
                    case '1':
                        $class = 'col-md-5 delivery-item delivery-item_center';
                        break;
                    case '2':
                        $class = 'col-md-3 delivery-item';
                        break;
                }
                ?>
				<div class="<?= $class;?>" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
					<span class="delivery-item_title"><?= $arItem['NAME']; ?></span>
					<p><?= $arItem['PREVIEW_TEXT']; ?></p>
				</div>
            <? } ?>
		</div>
	</div>
<? } ?>
