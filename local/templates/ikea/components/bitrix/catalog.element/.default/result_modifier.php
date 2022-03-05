<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
$cp = $this->__component;

foreach ($arResult['PROPERTIES']['GALLERY']['VALUE'] as $arPhotoID) {
    $arResult['GALLERY'][$arPhotoID] = CFile::GetPath($arPhotoID);
}
if($arResult['IBLOCK_SECTION_ID']){
    $arResult['SECTION'] = CIBlockSection::GetByID($arResult['IBLOCK_SECTION_ID'])->fetch();
}
if($arResult['PROPERTIES']['PRODUCTS']['VALUE'] || $arResult['ID']){
    $arResult['PROPERTIES']['PRODUCTS']['VALUE'][] = $arResult['ID'];
    $arSelect = ["ID", "NAME",'PREVIEW_PICTURE','PROPERTY_SELECTION_PROPERTY','DETAIL_PAGE_URL'];
    $arFilter = ["IBLOCK_ID"=>$arParams["IBLOCK_ID"],"ACTIVE"=>"Y",'=ID'=>$arResult['PROPERTIES']['PRODUCTS']['VALUE']];
    $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
    while($ob = $res->GetNext())
    {
        $ob['PIC'] = CFile::GetPath($ob['PREVIEW_PICTURE']);
        $arResult['PRODUCTS'][$ob['ID']] = $ob;
    }
}

if($arResult['PROPERTIES']['RELATED']['VALUE']){

    if (is_object($cp))
    {
        $cp->arResult['RELATED'] = $arResult['PROPERTIES']['RELATED']['VALUE'];
        $cp->SetResultCacheKeys(array('RELATED'));
    }
}
