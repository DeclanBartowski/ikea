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
if ($arResult['SECTIONS']) {
    $strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
    $strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
    $arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

    $this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete,
        $arSectionDeleteParams);
    ?>
	<div class="category-section gray-section">
		<div class="container">
			<div class="category-section_header">
				<div class="section-title">Популярные категории</div>
				<div class="category-counter">
					<span class="pagination-number"></span>
					<span class="unified-divider">из</span>
					<span class="pagination-digit"></span>
				</div>
			</div>
			<div class="category-slider"><?
                $sectionsCount = floor(count($arResult['SECTIONS']) / 2);
                foreach ($arResult['SECTIONS'] as $key => $arSection) {
                    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete,
                        $arSectionDeleteParams);

                    ?>
					<div class="category-item" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
						<a href="<?= $arSection['SECTION_PAGE_URL']; ?>">
                            <? if ($arSection['PICTURE']['ID']) {
                                $picture = CFile::ResizeImageGet($arSection['PICTURE']['ID'],
                                    ['width' => 207, 'height' => 285],
                                    BX_RESIZE_IMAGE_PROPORTIONAL
                                )['src'];
                                ?>
								<img src="<?= $picture; ?>" alt="alt">
                            <? } ?>
							<span class="category-item_title"><?= $arSection['NAME']; ?></span>
						</a>
					</div>
                    <? if (/*$sectionsCount == $key + 1*/$key == 4) { ?>
						<div class="category-item">
							<a href="/catalog/" class="swow-all_category-btn">
								<span class="item-text">Смотреть все товары</span>
								<span class="item-arrow ico-arrow"></span>
							</a>
						</div>
                    <? } ?>
                <? } ?>
			</div>
		</div>
	</div>
<? } ?>