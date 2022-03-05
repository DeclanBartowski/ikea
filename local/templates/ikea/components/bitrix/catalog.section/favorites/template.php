<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |    Attention!
 * |    The following comments are for system use
 * |    and are required for the component to work correctly in ajax mode:
 * |    <!-- items-container -->
 * |    <!-- pagination-container -->
 * |    <!-- component-end -->
 */

$this->setFrameMode(true);

$generalParams = array(
    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
    'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
    'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
    'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
    'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
    'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
    'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
    'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
    'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
    'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
    'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'],
    'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
    'COMPARE_PATH' => $arParams['COMPARE_PATH'],
    'COMPARE_NAME' => $arParams['COMPARE_NAME'],
    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
    'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
    'LABEL_POSITION_CLASS' => $labelPositionClass,
    'DISCOUNT_POSITION_CLASS' => $discountPositionClass,
    'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
    'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],
    '~BASKET_URL' => $arParams['~BASKET_URL'],
    '~ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
    '~BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
    '~COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
    '~COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
    'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
    'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],
    'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
    'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
    'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
    'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
    'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
    'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE']
);

$obName = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-' . $navParams['NavNum']; ?>

<? if (!empty($arResult['ITEMS'])) { ?>
	<div class="col-xl-6">
		<div class="cart-fav_header">
			<span class="cart-fav_subtitle">Избранное</span>
		</div>
		<div class="cart-content">
            <? foreach ($arResult['ITEMS'] as $item) {
                $uniqueId = $item['ID'] . '_' . md5($this->randString() . $component->getAction());
                $areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
                $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
                $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete,
                    $elementDeleteParams);
                ?>
				<div class="cart-item">
					<div class="cart-item_img">
						<a href="<?= $item['DETAIL_PAGE_URL']; ?>">
							<img data-src="<?= $item['PREVIEW_PICTURE_RESIZED'] ?>"
							     alt="<?= $item['NAME']; ?>">
						</a>
					</div>
					<div class="cart-item_desc">
			                            <span class="cart-item_title">
				                            <a href="<?= $item['DETAIL_PAGE_URL']; ?>">
					                            <?= $item['NAME']; ?>
				                            </a>
			                            </span>
                        <? if (!empty($item['PROPERTIES']['BED_FRAME']['VALUE'])) { ?>
							<p>Каркас кровати
								<span class="item-size">
					                            <?= $item['PROPERTIES']['BED_FRAME']['VALUE']; ?>
				                            </span>
							</p>
                        <? } ?>
					</div>
					<div class="cart-item_body">
						<div class="cart-item_top-row">
                            <? if ($item['CATALOG_QUANTITY'] > 0) { ?>
                                <? if ($item['CATALOG_QUANTITY'] < 10) { ?>
									<span class="cart-item_stock few">Осталось мало товара</span>
                                <? } else { ?>
									<span class="cart-item_stock">
														<span class="ico-check"></span>В наличии
													</span>
                                <? } ?>
                            <? } else { ?>
								<span class="cart-item_stock ended">Товар закончился</span>
                            <? } ?>
							<span class="cart-item_price">
					                            <?= $item['MIN_PRICE']['PRINT_DISCOUNT_VALUE_VAT']; ?>
				                            </span>
							<span data-class="tools"
							      data-method="compfavdelete"
							      data-page-refresh="Y"
							      data-add="FAVORITES"
							      data-id="<?= $item['ID']; ?>"
							      class="fav-item_delete ico-close">
				                            </span>
						</div>
						<div class="cart-item_bottom-row">
							<div class="cell">
                                <? if (!empty($item['PROPERTIES']['WEIGHT']['VALUE'])) { ?>
									<span class="subtitle">Вес</span><?= $item['PROPERTIES']['WEIGHT']['VALUE']; ?>
                                <? } ?>
							</div>
							<div class="cell">
                                <? if (!empty($item['PROPERTIES']['PACKAGE_QUANTITY']['VALUE'])) { ?>
									<span class="subtitle">Кол-во пачек</span>
                                    <?= $item['PROPERTIES']['PACKAGE_QUANTITY']['VALUE']; ?>
                                <? } ?>
							</div>
							<div class="cell">
                                <? if (!empty($item['PROPERTIES']['ART_NUMBER']['VALUE'])) { ?>
									<span class="subtitle">Артикул</span>
                                    <?= $item['PROPERTIES']['ART_NUMBER']['VALUE']; ?>
                                <? } ?>
							</div>
							<div class="cell">
								<a href="javascript:void(0)"
								   data-class="basket"
								   data-method="add2basket"
								   data-id="<?= $item['ID']; ?>"
								   class="fav_add-cart_btn">
									Добавить в корзину
								</a>
							</div>
						</div>
					</div>
				</div>
            <? } ?>
		</div>
	</div>
	<div class="col-xl-3 right-column">
		<a href="javascript:void(0)"
		   data-class="tools"
		   data-method="clear_favorites"
		   class="fav_clear-list">
			<span class="ico-close"></span>Очистить список
		</a>
	</div>
<? } ?>
