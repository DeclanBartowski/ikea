<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}


$productIDs = [];
foreach ($arResult["SEARCH"] as $arItem) {
    $productIDs[] = $arItem['ITEM_ID'];
}
if (!empty($productIDs)) {
    $select = Array('ID', 'PREVIEW_PICTURE');
    $filter = Array('ID' => $productIDs, 'ACTIVE_DATE' => 'Y', 'ACTIVE' => 'Y');
    $res = CIBlockElement::GetList(Array(), $filter, false, false, $select);
    while ($ob = $res->Fetch()) {
        $arFileTmp = CFile::ResizeImageGet(
            $ob['PREVIEW_PICTURE'],
            ['width' => 435, 'height' => 320],
            BX_RESIZE_IMAGE_PROPORTIONAL
        );
        $ob['PREVIEW_PICTURE_SRC'] = $arFileTmp['src'];
        $arResult['PRODUCTS'][$ob['ID']] = $ob;
    }
}

foreach ($arResult["SEARCH"] as &$arItem) {
    if (!empty($arResult['PRODUCTS'][$arItem['ITEM_ID']])) {
        $arItem['PRODUCT_INFO'] = $arResult['PRODUCTS'][$arItem['ITEM_ID']];
    }
}
unset($arItem);