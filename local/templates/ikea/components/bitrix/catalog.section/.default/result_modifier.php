<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

foreach ($arResult['ITEMS'] as &$arItem) {
    if (!empty($arItem['PREVIEW_PICTURE']['ID'])) {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem['PREVIEW_PICTURE']['ID'],
            ['width' => 320, 'height' => 320],
            BX_RESIZE_IMAGE_PROPORTIONAL
        );
        $arFileTmpSmall = CFile::ResizeImageGet(
            $arItem['PREVIEW_PICTURE']['ID'],
            ['width' => 48, 'height' => 36],
            BX_RESIZE_IMAGE_PROPORTIONAL
        );
        $arItem['GALLERY'][] = [
            'BIG' => $arFileTmp['src'],
            'SMALL' => $arFileTmpSmall['src']
        ];
    }
    if (!empty($arItem['PROPERTIES']['GALLERY']['VALUE'])) {
        foreach ($arItem['PROPERTIES']['GALLERY']['VALUE'] as $picID) {
            $arFileTmp = CFile::ResizeImageGet(
                $picID,
                ['width' => 320, 'height' => 320],
                BX_RESIZE_IMAGE_PROPORTIONAL
            );
            $arFileTmpSmall = CFile::ResizeImageGet(
                $picID,
                ['width' => 48, 'height' => 36],
                BX_RESIZE_IMAGE_PROPORTIONAL
            );
            $arItem['GALLERY'][] = [
                'BIG' => $arFileTmp['src'],
                'SMALL' => $arFileTmpSmall['src']
            ];
        }
    }
    $arItem['IMAGE_COUNT'] = count($arItem['GALLERY']) - 4;
    $arItem['GALLERY'] = array_slice($arItem['GALLERY'], 0, 4);
}
unset($arItem);