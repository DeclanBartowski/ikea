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
	<div class="portfolio-section">
		<div class="section-title">Больше идей и вдохновения</div>
		<div class="tab-container">
			<ul class="porfolio-section_tab-names">
                <?
                $cnt = 0;
                foreach ($arResult['MAIN_SECTIONS'] as $key => $section) {
                    if ($arResult['SUB_SECTIONS'][$section['ID']]) { ?>
						<li class="tab <? if ($cnt == 0) { ?>active<? } ?>"><?= $section['NAME']; ?></li>
                        <?
                        $cnt++;
                    }
                } ?>
			</ul>
            <?
            $cnt = 0;
            foreach ($arResult['MAIN_SECTIONS'] as $key => $mainSection) {
                if ($arResult['SUB_SECTIONS'][$mainSection['ID']]) {
                    ?>
					<div class="tab-item <? if ($cnt == 0) { ?>is-visible<? } ?>">
						<div class="portfolio-content">
                            <?
                            $subCnt = 0;
                            foreach ($arResult['SUB_SECTIONS'][$mainSection['ID']] as $subSection) { ?>
								<div class="portfolio-item <? if ($subCnt >= 9) { ?>item-hidden<? } ?>">
									<a href="<?= $subSection['SECTION_PAGE_URL'] ?>">
										<img data-src="<?= $subSection['PICTURE']['SRC']; ?>" alt="alt">
									</a>
								</div>
                                <?
                                $subCnt++;
                            } ?>
						</div>
                        <?
                        $elementsCount = count($arResult['SUB_SECTIONS'][$mainSection['ID']]);
                        if ($elementsCount > 9) {
                            ?>
							<div class="text-center">
								<a href="javascript:void(0)" class="main-btn show-all_portfolio-btn">
									<span class="text">Смотреть еще</span>
									<span class="number"> +<?= $elementsCount - 9; ?></span>
								</a>
							</div>
                        <? } ?>
					</div>
                    <?
                    $cnt++;
                }
            } ?>
		</div>
	</div>
<? } ?>