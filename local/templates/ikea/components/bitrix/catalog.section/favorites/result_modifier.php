<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

foreach ($arResult['ITEMS'] as &$arItem){
    $arFileTmp = CFile::ResizeImageGet(
        $arItem['PREVIEW_PICTURE']['ID'],
        ['width' => 93, 'height' => 93],
        BX_RESIZE_IMAGE_PROPORTIONAL
    );
    $arItem['PREVIEW_PICTURE_RESIZED'] = $arFileTmp['src'];
}
unset($arItem);