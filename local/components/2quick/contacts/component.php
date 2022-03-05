<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

if (!empty($arParams['ADDRESS'])) {
    $arResult['ADDRESS'] = $arParams['ADDRESS'];
}
if (!empty($arParams['PHONES'])) {
    foreach ($arParams['PHONES'] as $phone) {
        $arResult['PHONES'][] = array(
            'FORMATED' => $phone,
            'PHONE' => preg_replace('~\D+~', '', $phone)
        );
    }
};
if (!empty($arParams['EMAILS'])) {
    $arResult['EMAILS'] = $arParams['EMAILS'];
}
if (!empty($arParams['WORK_TIMES'])) {
    $arResult['WORK_TIMES'] = $arParams['WORK_TIMES'];
}
if (!empty($arParams['DESCRIPTION'])) {
    $arResult['DESCRIPTION'] = $arParams['DESCRIPTION'];
}

$this->IncludeComponentTemplate();
?>
