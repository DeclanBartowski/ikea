<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Grid\Declension;

\Bitrix\Main\UI\Extension::load("ui.fonts.ruble");

$productDeclension = new Declension('товар', 'товара', 'товаров');;
/**
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var string $templateName
 * @var CMain $APPLICATION
 * @var CBitrixBasketComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $giftParameters
 */

$documentRoot = Main\Application::getDocumentRoot();
?>

<div class="cart-section">
    <?
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $GLOBALS['APPLICATION']->RestartBuffer();
    }
    ?>
    <? if (empty($arResult['ERROR_MESSAGE'])) { ?>
		<div class="cart-section_content">
			<div class="row cart-row">
				<div class="cart_left-column">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "favorites",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(0=>"",),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "left",
                            "USE_EXT" => "N"
                        )
                    );?>
				</div>

				<div class="cart_center-column">
					<div class="cart-fav_header">
						<span class="cart-fav_subtitle">товары в корзине <span
									class="number">(<?= count($arResult['ITEMS']['AnDelCanBuy']); ?>)</span></span>
						<a href="javascript:void(0)" data-class="basket" data-method="clear"
						   class="cart_clear-btn mobile-hidden"><span class="ico-close"></span>Очистить корзину</a>
					</div>
					<div class="cart-content">
                        <? foreach ($arResult['ITEMS']['AnDelCanBuy'] as $arItem) {
                            $mxQuantity = ($arItem['AVAILABLE_QUANTITY'] > 0) ? $arItem['AVAILABLE_QUANTITY'] : 1;
                            ?>
							<div class="cart-item">
								<div class="cart-item_img">
									<a href="<?= $arItem['DETAIL_PAGE_URL']; ?>"><img
												data-src="<?= $arItem['PREVIEW_PICTURE_SRC']; ?>"
												alt="<?= $arItem['NAME']; ?>"></a>
								</div>
								<div class="cart-item_desc">
									<span class="cart-item_title"><a
												href="<?= $arItem['DETAIL_PAGE_URL']; ?>"><?= $arItem['NAME']; ?></a></span>
                                    <? if (!empty($arItem['PROPERTY_BED_FRAME_VALUE'])) { ?>
										<p>Каркас кровати <span
													class="item-size"><?= $arItem['PROPERTY_BED_FRAME_VALUE']; ?></span>
										</p>
                                    <? } ?>
									<div class="mobile-visible">
										<select data-class="basket" data-method="update" data-id="<?= $arItem['ID']; ?>"
										        class="js-select">
                                            <? for ($i = 1; $i <= $mxQuantity; $i++) { ?>
												<option <? if ($i == $arItem['QUANTITY']){ ?>selected<? } ?>
												        value="<?= $i; ?>"><?= $i; ?> <?= $arItem['MEASURE_NAME']; ?>.
												</option>
                                            <? } ?>
										</select>
									</div>
								</div>
								<div class="cart-item_body">
									<div class="cart-item_top-row">
                                        <? if ($arItem['AVAILABLE_QUANTITY'] > 0) { ?>
                                            <? if ($arItem['AVAILABLE_QUANTITY'] < 10) { ?>
												<span class="cart-item_stock few">Осталось мало товара</span>
                                            <? } else { ?>
												<span class="cart-item_stock">
														<span class="ico-check"></span>В наличии
													</span>
                                            <? } ?>
                                        <? } else { ?>
											<span class="cart-item_stock ended">Товар закончился</span>
                                        <? } ?>
										<span class="cart-item_price"><?= $arItem['SUM']; ?></span>
										<span data-class="basket" data-method="delete" data-id="<?= $arItem['ID']; ?>"
										      class="cart-item_delete"><span
													class="ico-close"></span>Удалить товар</span>
									</div>
									<div class="cart-item_bottom-row">
										<?if($arItem['PROPERTY_WEIGHT_VALUE']){?>
										<div class="cell">
											<span class="subtitle">Вес</span><?= $arItem['PROPERTY_WEIGHT_VALUE']; ?>
										</div>
										<?}?>
										<?if(!empty($arItem['PROPERTY_PACKAGE_QUANTITY_VALUE'])){?>
										<div class="cell">
											<span class="subtitle">Кол-во пачек</span><?= $arItem['PROPERTY_PACKAGE_QUANTITY_VALUE']; ?>
										</div>
										<?}?>
										<?if(!empty($arItem['PROPERTY_ART_NUMBER_VALUE'])){?>
										<div class="cell">
											<span class="subtitle">Артикул</span><?= $arItem['PROPERTY_ART_NUMBER_VALUE']; ?>
										</div>
										<?}?>
										<div class="cell mobile-hidden">
											<select data-class="basket" data-method="update"
											        data-id="<?= $arItem['ID']; ?>" class="js-select">
                                                <? for ($i = 1; $i <= $mxQuantity; $i++) { ?>
													<option <? if ($i == $arItem['QUANTITY']){ ?>selected<? } ?>
													        value="<?= $i; ?>"><?= $i; ?> <?= $arItem['MEASURE_NAME']; ?>
														.
													</option>
                                                <? } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
                        <? } ?>
					</div>
					<div class="text-center mobile-visible">
						<a href="javascript:void(0)" data-class="basket" data-method="clear"
						   class="cart_clear-btn"><span class="ico-close"></span>Очистить корзину</a>
					</div>
				</div>
				<div class="cart_right-column">
					<div class="cart-total_box">
						<div class="h4">Сумма заказа</div>
						<table class="cart-total_table">
                            <? /*<tr>
								<td>Доставка до Калининграда</td>
								<td>500 <span class="rouble">i</span><span class="cart-total_weight">(1234 кг)</span>
								</td>
							</tr>*/ ?>
							<tr>
								<td>Сумма заказа</td>
								<td>
									<span class="cart-total-sum"><?= $arResult['TOTAL_RENDER_DATA']['PRICE_WITHOUT_DISCOUNT_FORMATED']; ?>
								</td>
							</tr>
							<tr>
								<td>Скидка</td>
								<td>- <?= $arResult['DISCOUNT_PRICE_ALL_FORMATED']; ?></td>
							</tr>
							<tr>
								<td><strong>Общая сумма</strong></td>
								<td><span class="cart-total_sum"><?= $arResult['allSum_FORMATED']; ?></td>
							</tr>
						</table>
					</div>
					<a href="<?= $arParams['PATH_TO_ORDER']; ?>" class="checkout-btn main-btn">Оформить заказ</a>
					<div class="checkout-form_policy">
						Нажимая на кнопку "Оформить заказ", вы соглашаетесь на <a href="/privacy-policy/">Обработку
							своих персональных
							данных</a> и соглашаетесь с <a href="/terms-of-use/">Условиями конфиденциальности</a>
					</div>

                    <? /*<div class="checkout-sidebar_box">
						<span class="subtitle">Стоимость доставки по области</span>
						<p>Пожалуйста, обратите внимание, что за доставку по области, взымается дополнительная плата.
							Расценки указаны до ближайшего населённого пункта.</p>
						<table class="delivery-table">
							<tr>
								<td>Гурьевск</td>
								<td>500 <span class="rouble">i</span></td>
							</tr>
							<tr>
								<td>Зеленоградск</td>
								<td>1000 <span class="rouble">i</span></td>
							</tr>
							<tr>
								<td>Светлогорск / Янтарный</td>
								<td>1 500 <span class="rouble">i</span></td>
							</tr>
							<tr>
								<td>Черняховск</td>
								<td>2 500 <span class="rouble">i</span></td>
							</tr>
						</table>
					</div>*/ ?>

					<div class="checkout-sidebar_box">
						<span class="subtitle">Наличие товара</span>
						<p>
							Если товара нет в наличии, то вы всё равно можете оформить заказ. В этом случае уточнить
							сроки доставки вы можете у менеджера по телефону или в мессенджере
						</p>
					</div>
				</div>
			</div>
		</div>
    <? } elseif ($arResult['EMPTY_BASKET']) {
        include(Main\Application::getDocumentRoot() . $templateFolder . '/empty.php');
    } else { ?>
		<div class="cart-section_content">
			<div class="row">
				<div class="col-xl-3">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "favorites",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(0=>"",),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "left",
                            "USE_EXT" => "N"
                        )
                    );?>
				</div>
				<div class="col-lg-6">
					<div class="cart-empty_box">
						<span class="cart-empty_box-icon"><img alt="alt"
						                                       src="<?= SITE_TEMPLATE_PATH ?>/img/icons/cart-icon.svg"></span>
						<div class="section-title">Ошибка!</div>
						<p><?= ShowError($arResult['ERROR_MESSAGE']); ?></p>
						<a href="<?= $arParams['EMPTY_BASKET_HINT_PATH']; ?>" class="main-btn main-btn_mod">Перейти в
							каталог</a>
					</div>
				</div>
			</div>
		</div>
        <?
    } ?>
    <?
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        die();
    }
    ?>
</div>