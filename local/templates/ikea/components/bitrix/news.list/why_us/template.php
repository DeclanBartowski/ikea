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
	<div class="advantages-section">
		<div class="container">
			<div class="section-title text-center">
                <?= $arResult['NAME']; ?>
				<small><?= $arResult['DESCRIPTION']; ?></small>
			</div>
			<ul class="advantages-list">
                <? foreach ($arResult["ITEMS"] as $arItem): ?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
                        CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
                        CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                        array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
					<li id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
						<div class="advantage-item">
							<div class="advantage-item_title">
                                <? if ($arItem['PROPERTIES']['ICON']['VALUE']) { ?>
									<span class="advantage-item_icon">
									<img data-src="<?= CFile::GetPath($arItem['PROPERTIES']['ICON']['VALUE']); ?>"
									     alt="alt">
								</span>
                                <? } ?>
                                <?= $arItem['NAME']; ?>
							</div>
							<p><?= $arItem['PREVIEW_TEXT']; ?></p>
						</div>
					</li>
                <? endforeach; ?>
			</ul>
		</div>
	</div>
<? } ?>