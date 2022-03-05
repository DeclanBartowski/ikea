<?

foreach ($arResult['ORDERS'] as $order) {
    foreach ($order['BASKET_ITEMS'] as $arItem) {
        $productsIDs[] = $arItem['PRODUCT_ID'];
    }
}

if (!empty($productsIDs)) {

    $select = Array(
        'ID',
        'IBLOCK_ID',
        'NAME',
        'DATE_ACTIVE_FROM',
        'PROPERTY_*',
        'DETAIL_PAGE_URL',
        'PREVIEW_TEXT',
        'DETAIL_TEXT',
        'PREVIEW_PICTURE',
        'DETAIL_PICTURE',
        'CATALOG_PRICE_1'
    );
    $filter = Array('ID' => $productsIDs);
    $res = CIBlockElement::GetList(Array(), $filter, false, false, $select);
    while ($ob = $res->GetNextElement()) {
        $fields = $ob->GetFields();
        $fields ['PROPERTIES'] = $ob->GetProperties();
        $arFileTmp = CFile::ResizeImageGet(
            $fields['PREVIEW_PICTURE'],
            ['width' => 100, 'height' => 100],
            BX_RESIZE_IMAGE_PROPORTIONAL
        );
        $fields['PREVIEW_PICTURE'] = $arFileTmp['src'];
        $productInfo[$fields['ID']] = $fields;
    }
}

foreach ($arResult['ORDERS'] as &$order) {
    foreach ($order['BASKET_ITEMS'] as &$arItem) {
        if (!empty($productInfo[$arItem['PRODUCT_ID']])) {
            $arItem['PRODUCT_IBLOCK_INFO'] = $productInfo[$arItem['PRODUCT_ID']];
        }
    }
}
unset($order, $arItem)
?>