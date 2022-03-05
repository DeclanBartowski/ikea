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
	<div class="instagram-section">
		<div class="section-title text-center">
            <?= $arResult['NAME']; ?>
            <?= $arResult['~DESCRIPTION'] ?>
		</div>
		<div class="row instagram-row">
            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <?
                if (!$arItem['PREVIEW_PICTURE']['ID']) {
                    continue;
                }
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                    array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                $picture = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'],
                    ['width' => 320, 'height' => 323],
                    BX_RESIZE_IMAGE_PROPORTIONAL
                )['src'];
                ?>
				<div class="col-md-3 col-6" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
					<div class="instagram-item">
						<a <? if ($arItem['PROPERTIES']['URL']['VALUE']) { ?>href="<?= $arItem['PROPERTIES']['URL']['VALUE']; ?>"<? } ?>>
							<img src="<?= $picture; ?>" alt="alt">
						</a>
					</div>
				</div>
            <? endforeach; ?>
		</div>
	</div>
<? } ?>