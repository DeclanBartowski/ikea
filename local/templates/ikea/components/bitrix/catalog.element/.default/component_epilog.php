<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Catalog\CatalogViewedProductTable as CatalogViewedProductTable;
CatalogViewedProductTable::refresh($arResult['ID'], CSaleBasket::GetBasketUserID());

$GLOBALS['relatedFilter']['=ID'] = ($arResult['RELATED'])?$arResult['RELATED']:false;