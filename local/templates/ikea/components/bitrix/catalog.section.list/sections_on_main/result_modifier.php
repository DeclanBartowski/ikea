<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult['SECTIONS'] as $section) {
    if ($section['IBLOCK_SECTION_ID']) {
        $arResult['SUB_SECTIONS'][$section['IBLOCK_SECTION_ID']][] = $section;
    } else {
        $arResult['MAIN_SECTIONS'][] = $section;
    }
}