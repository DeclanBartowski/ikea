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
	<div class="head-nav">
		<div class="back-list js_back-list">Назад</div>
		<ul class="head-menu">
            <? foreach ($arResult['MAIN_SECTIONS'] as $section) { ?>
				<li>
					<a href="<?= $section['SECTION_PAGE_URL']; ?>"><?= $section['NAME']; ?></a>
                    <? if ($arResult['SUB_SECTIONS'][$section['ID']]) { ?>
						<span class="mobile-menu_arrow-icon js_arrow-icon"></span>
						<ul class="head-submenu">
							<li class="back-list js_back-list_2">Назад</li>
							<li class="title">Каталог</li>
							<li>
								<a href="<?= $section['SECTION_PAGE_URL']; ?>">Все товары</a>
							</li>
                            <? foreach ($arResult['SUB_SECTIONS'][$section['ID']] as $subSection) { ?>
								<li>
									<a href="<?= $subSection['SECTION_PAGE_URL']; ?>"><?= $subSection['NAME']; ?></a>
								</li>
                            <? } ?>
						</ul>
                    <? } ?>
				</li>
            <? } ?>
		</ul>
	</div>
<? } ?>