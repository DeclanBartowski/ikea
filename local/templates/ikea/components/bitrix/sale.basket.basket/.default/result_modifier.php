<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;


$buyPrice = 0;
$buyDiscountPrice = 0;
$buyDiscount = 0;

$orderedPrice = 0;
$orderedDiscountPrice = 0;
$orderedDiscount = 0;

$vatPrice = 0;

$arResult['HAS_OUT_OF_STOCKS_PRODUCTS'] = false;
foreach ($arResult['ITEMS']['AnDelCanBuy'] as &$arItem) {
    $vatPrice += $arItem['PRICE_VAT_VALUE'];
    foreach ($arItem['PROPS'] as $PROP) {
        $arItem['TQ_PROPERTIES'][$PROP['CODE']] = $PROP;
        if ($PROP['CODE'] == 'IS_OUT_OF_STOCKS' && $PROP['VALUE'] == 'Y') {
            $arResult['HAS_OUT_OF_STOCKS_PRODUCTS'] = true;
        }
    }
    if ($arItem['TQ_PROPERTIES']['IS_OUT_OF_STOCKS']['VALUE'] == 'Y') {
        $orderedPrice += $arItem['SUM_FULL_PRICE'];
        $orderedDiscountPrice += $arItem['SUM_VALUE'];
        $orderedDiscount += $arItem['SUM_DISCOUNT_PRICE'];
    } else {
        $buyPrice += $arItem['SUM_FULL_PRICE'];
        $buyDiscountPrice += $arItem['SUM_VALUE'];
        $buyDiscount += $arItem['SUM_DISCOUNT_PRICE'];
    }
}
unset($arItem);
$arResult['VAT_PRICE'] = $vatPrice;
/*$arResult['PRICE_WITHOUT_DISCOUNT'] = CurrencyFormat($buyPrice, $arResult['CURRENCY']);
$arResult['ORDER_PRICE_FORMATED'] = CurrencyFormat($buyDiscountPrice, $arResult['CURRENCY']);
$arResult['DISCOUNT_PRICE_FORMATED'] = CurrencyFormat($buyDiscount, $arResult['CURRENCY']);

$arResult['ORDERED_PRICE_WITHOUT_DISCOUNT'] = CurrencyFormat($orderedPrice, $arResult['CURRENCY']);
$arResult['ORDER_ORDERED_PRICE_FORMATED'] = CurrencyFormat($orderedDiscountPrice, $arResult['CURRENCY']);
$arResult['ORDERED_DISCOUNT_PRICE_FORMATED'] = CurrencyFormat($orderedDiscount, $arResult['CURRENCY']);

*/