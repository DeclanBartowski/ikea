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
	<div class="service-section">
		<h2>Сегодня в ИКЕА</h2>
		<div class="row service-row">
            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                    array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
				<div class="col-md-4" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
					<div class="service-item">
                        <? if ($arItem['PREVIEW_PICTURE']['ID']) {
                            $picture = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'],
                                ['width' => 433, 'height' => 393],
                                BX_RESIZE_IMAGE_PROPORTIONAL
                            )['src'];
                            ?>
							<div class="service-item_img">
								<a <? if ($arItem['PROPERTIES']['URL']['VALUE']) { ?>href="<?= $arItem['PROPERTIES']['URL']['VALUE'] ?>"<? } ?>>
									<img data-src="<?= $picture; ?>" alt="alt">
								</a>
							</div>
                        <? } ?>
						<div class="service-item_desc desc-red" <?if ($arItem['PROPERTIES']['BACKGROUND_COLOR']['VALUE']) {?>style="background: <?= $arItem['PROPERTIES']['BACKGROUND_COLOR']['VALUE'];?>;" <?}?>>
							<span class="service-item_title"><?= $arItem['NAME']; ?></span>
                            <? if ($arItem['PREVIEW_TEXT']) { ?>
								<p><?= $arItem['PREVIEW_TEXT']; ?></p>
                            <? } ?>
                            <? if ($arItem['PROPERTIES']['URL']['VALUE']) { ?>
								<a href="<?= $arItem['PROPERTIES']['URL']['VALUE']; ?>"
								   class="service-item_btn main-btn">
                                    <?= $arItem['PROPERTIES']['URL_TEXT']['VALUE'] ?: 'Смотреть'; ?> <span
											class="ico-arrow"></span>
								</a>
                            <? } ?>
						</div>
					</div>
				</div>
            <? endforeach; ?>
		</div>
	</div>
<? } ?>