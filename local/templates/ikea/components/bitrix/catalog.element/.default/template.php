<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DESCRIPTION_ID' => $mainId.'_description',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
	$actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['MORE_PHOTO_COUNT'] > 1)
		{
			$showSliderControls = true;
			break;
		}
	}
}
else
{
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y')
{
	$skuDescription = false;
	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '')
		{
			$skuDescription = true;
			break;
		}
	}
	$showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}
else
{
	$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
if(in_array($arResult['ID'],$arParams['FAVORITES'])){
    $class = 'is-active';
    $method ='compfavdelete';
} else {
    $class = '';
    $method ='compfav';
}
?>
<div class="product-card_content">
	<div class="row">
        <?if($arResult['GALLERY']){?>
            <div class="col-xl-7 col-lg-6">
                <ul class="product-card_img">
                    <?foreach ($arResult["GALLERY"] as $key => $arPhoto){?>
                        <li>
                            <a href="<?=$arPhoto?>" class="fancybox" data-fancybox="image"><img data-src="<?=$arPhoto?>" alt="alt"></a>
                        </li>
                    <?}?>
                </ul>
                <div class="progress-line"><div class="progress-bar"></div></div>
            </div>
        <?}?>
		<div class="col-xl-5 col-lg-6">
			<div class="product-card_desc-header">
				<span class="product-card_code">Артикул: <?=$arResult['PROPERTIES']['ART_NUMBER']['VALUE']?></span>
                <?if($arResult["CATALOG_QUANTITY"]<1){?>
                    <span class="product-item_stock ended">Товар закончился</span>
                <?} elseif ($arResult["CATALOG_QUANTITY"]>10){?>
                    <span class="product-item_stock">В наличии</span>
                <?} else {?>
                    <span class="product-card_stock few">Осталось мало товара</span>
                <?}?>
			</div>
			<div class="product-card_title-price">
				<div class="left-column">
					<h1 class="product-card_title"><?=$arResult['NAME']?></h1>
                    <?if($arResult['SECTION']['NAME']){?>
					    <span class="product-card_subtitle"><?=$arResult['SECTION']['NAME']?></span>
                    <?}?>
				</div>
				<span class="product-card_price"><?=$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span>
			</div>
            <?if($arResult['DISPLAY_PROPERTIES']){?>
                <div class="product-card_feature-box">
                    <?foreach (array_chunk($arResult['DISPLAY_PROPERTIES'],count($arResult['DISPLAY_PROPERTIES'])/2) as $arBlock){?>
                        <div class="column">
                            <table class="product-card_feature-table">
                                <?foreach ($arBlock as $key => $arProperty){?>
                                    <tr>
                                        <td><?=$arProperty['NAME']?>:</td>
                                        <td><?=$arProperty['VALUE']?></td>
                                    </tr>
                                <?}?>
                            </table>
                        </div>
                    <?}?>
                </div>
            <?}?>
            <?if($arResult['PROPERTIES']['SELECTION_PROPERTY']['VALUE']){?>
                <div class="select-cover_panel">
                    <?if($arResult['PROPERTIES']['SELECTION_PROPERTY']['DESCRIPTION']){?>
                        <span class="text"><?=$arResult['PROPERTIES']['SELECTION_PROPERTY']['DESCRIPTION']?>:</span>
                    <?}?>
                    <span class="select-cover_title"><?=$arResult['PROPERTIES']['SELECTION_PROPERTY']['VALUE']?></span>
                </div>
            <?}?>
            <?if($arResult['PRODUCTS']){?>
                <ul class="case-list">
                    <?foreach ($arResult['PRODUCTS'] as $key => $arProduct){?>
                        <li>
                            <a href="<?=$arProduct['DETAIL_PAGE_URL'];?>"
                               class="case-item <?if($arProduct['ID']==$arResult['ID']){?>is-active<?}?>"
                               data-text="<?=$arProduct['PROPERTY_SELECTION_PROPERTY_VALUE']?>">
                                <?if($arProduct['PIC']){?>
                                    <img src="<?=$arProduct['PIC']?>" alt="<?=$arProduct['NAME']?>">
                                <?}?>
                            </a>
                        </li>
                    <?}?>
                </ul>
            <?}?>
			<div class="product-card_desc-btns">
                <?if($arResult['CATALOG_QUANTITY']>0){?>
                    <a href="#" class="product-card_order-btn" data-class="basket" data-method="add2basket" data-id="<?=$arResult['ID']?>">
                        <span class="ico-check"></span>
                        <span class="text">Добавить в корзину</span>
                    </a>
                <?}?>
				<span class="product-card_fav <?=$class?>" data-class="tools" data-method="<?=$method?>" data-id="<?=$arResult['ID']?>">
                    <span class="ico-fav"></span>
                    <span class="ico-fav-2"></span>
                </span>
			</div>
            <?if(file_exists($_SERVER['DOCUMENT_ROOT'].'/include/card/price.php')){?>
                <div class="product-card_attention-text">
                    <span class="attention-icon">i</span>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" =>"/include/card/price.php"
                        )
                    );?>
                </div>
            <?}?>
            <?if($arResult['DETAIL_TEXT']){?>
                <div class="product-card_desc-text">
                    <span class="subtitle">Описание</span>
                    <?=$arResult['~DETAIL_TEXT']?>
                </div>
            <?}?>
		</div>
	</div>
</div>
<div class="product-card_fixed-btns">
    <?if($arResult['CATALOG_QUANTITY']>0){?>
        <a href="" class="product-card_order-btn" data-class="basket" data-method="add2basket" data-id="<?=$arResult['ID']?>">
            <span class="ico-check"></span><span class="text">Добавить в корзину</span>
        </a>
    <?}?>
	<span class="product-card_fav <?=$class?>" data-class="tools" data-method="<?=$method?>" data-id="<?=$arResult['ID']?>">
        <span class="ico-fav"></span>
        <span class="ico-fav-2"></span>
    </span>
</div>
