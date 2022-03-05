<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);

if (!empty($arResult['ERRORS']['FATAL'])) {
    foreach ($arResult['ERRORS']['FATAL'] as $error) {
        ShowError($error);
    }
    $component = $this->__component;
    if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
        $APPLICATION->AuthForm('', false, false, 'N', false);
    }

} else {
    if (!empty($arResult['ERRORS']['NONFATAL'])) {
        foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
            ShowError($error);
        }
    }
    if (!count($arResult['ORDERS'])) {
        if ($_REQUEST["filter_history"] == 'Y') {
            if ($_REQUEST["show_canceled"] == 'Y') {
                ?>
				<div class="cart-empty_box">
		            <span class="cart-empty_box-icon">
			            <img alt="alt" src="<?= SITE_TEMPLATE_PATH ?>/img/icons/cart-icon.svg"></span>
					<div class="section-title"><?= Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER') ?>!</div>
					<p>Перейдите в каталог, у нас много интересного </p>
					<a href="<?= SITE_DIR ?>catalog/" class="main-btn main-btn_mod">Перейти в каталог</a>
				</div>
                <?
            } else {
                ?>
				<div class="cart-empty_box">
		            <span class="cart-empty_box-icon">
			            <img alt="alt" src="<?= SITE_TEMPLATE_PATH ?>/img/icons/cart-icon.svg"></span>
					<div class="section-title"><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST') ?>!</div>
					<p>Перейдите в каталог, у нас много интересного </p>
					<a href="<?= SITE_DIR ?>catalog/" class="main-btn main-btn_mod">Перейти в каталог</a>
				</div>
                <?
            }
        } else {
            ?>
			<div class="cart-empty_box">
		            <span class="cart-empty_box-icon">
			            <img alt="alt" src="<?= SITE_TEMPLATE_PATH ?>/img/icons/cart-icon.svg"></span>
				<div class="section-title"><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST') ?>!</div>
				<p>Перейдите в каталог, у нас много интересного </p>
				<a href="<?= SITE_DIR ?>catalog/" class="main-btn main-btn_mod">Перейти в каталог</a>
			</div>
            <?
        }
    }
    ?>
    <?
    $nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
    $clearFromLink = array("filter_history", "filter_status", "show_all", "show_canceled");
    ?>
    <?

    if ($_REQUEST["filter_history"] !== 'Y') {
        $paymentChangeData = array();
        $orderHeaderStatus = null;
        foreach ($arResult['ORDERS'] as $key => $order) {
            $orderHeaderStatus = $order['ORDER']['STATUS_ID'];
            ?>
			<div class="order-good">
				<table class="order-good_table">
					<thead>
					<tr>
						<th>
							<span class="order-good_th-subtitle">Название заказа</span>№<?= $order['ORDER']['ACCOUNT_NUMBER']; ?>
						</th>
						<th>
							<span class="order-good_th-subtitle">Дата</span><?= $order['ORDER']['DATE_INSERT_FORMATED']; ?>
						</th>
						<th><span class="order-good_th-subtitle">Статус</span>
							<span class="order-good_status<?= ($order['ORDER']['CANCELED'] == 'Y') ? ' canceled' : ' submitted' ?>">
								<?= ($order['ORDER']['CANCELED'] == 'Y') ? 'Отменен' : htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']) ?>
							</span>
						</th>
						<th><span class="order-good_th-subtitle">Сумма</span><?= $order['ORDER']['FORMATED_PRICE']; ?>
						</th>
						<th>
							<div class="order-good_th-flex">
								<span class="order-good_th-collapse-btn"></span>
								<span class="order-good_mobile-btn"></span>
							</div>
						</th>
					</tr>
					</thead>
					<tbody class="order-good_content">
					<tr class="order-good_title-row">
						<td colspan="2">Товар</td>
						<td>Артикул</td>
						<td>Количество</td>
						<td colspan="2">Цена</td>
					</tr>
                    <?
                    foreach ($order['BASKET_ITEMS'] as $arItem) {
                        ?>
						<tr>
							<td colspan="2">
								<div class="order-good_product">
									<a href="<?= $arItem['DETAIL_PAGE_URL']; ?>">
										<div class="order-good_product-img">
											<img src="<?= $arItem['PRODUCT_IBLOCK_INFO']['PREVIEW_PICTURE']; ?>"
											     alt="<?= $arItem['NAME']; ?>">
										</div>
										<div class="order-good_product-desc">
											<span class="mobile-title">Товар</span>
                                            <? if ($arItem['PRODUCT_IBLOCK_INFO']['CATALOG_QUANTITY'] > 0) { ?>
                                                <? if ($arItem['PRODUCT_IBLOCK_INFO']['CATALOG_QUANTITY'] < 10) { ?>
													<span class="order-good_product-stock few">Осталось мало товара</span>
                                                <? } else { ?>
													<span class="order-good_product-stock">
														<span class="ico-check"></span>В наличии
													</span>
                                                <? } ?>
                                            <? } else { ?>
												<span class="order-good_product-stock ended">Товар закончился</span>
                                            <? } ?>
											<span class="order-good_product-title"><?= $arItem['NAME']; ?></span>
										</div>
									</a>
								</div>
							</td>
							<td>
								<span class="mobile-title">Артикул</span>
                                <?
                                if (!empty($arItem['PRODUCT_IBLOCK_INFO']['PROPERTIES']['ART_NUMBER']['VALUE'])) {
                                    ?>
                                    <?= $arItem['PRODUCT_IBLOCK_INFO']['PROPERTIES']['ART_NUMBER']['VALUE']; ?>
                                    <?
                                } else { ?>
									Отсутствует
                                <? } ?>
							</td>
							<td>
								<span class="mobile-title">Количество</span><?= $arItem['QUANTITY']; ?> <?= $arItem['MEASURE_NAME']; ?>
							</td>
							<td colspan="2"><span class="mobile-title">Цена</span>
                                <?= sprintf('%s / %s', CurrencyFormat($arItem['PRICE'], $arItem['CURRENCY']),
                                    $arItem['MEASURE_NAME']) ?>
							</td>
						</tr>
                        <?
                    } ?>
					</tbody>
				</table>
			</div>
            <?
        }
    } else {
        $orderHeaderStatus = null;


        foreach ($arResult['ORDERS'] as $key => $order) {
            $orderHeaderStatus = $order['ORDER']['STATUS_ID'];
            ?>
			<div class="order-good">
				<table class="order-good_table">
					<thead>
					<tr>
						<th>
							<span class="order-good_th-subtitle">Название заказа</span>№<?= $order['ORDER']['ACCOUNT_NUMBER']; ?>
						</th>
						<th>
							<span class="order-good_th-subtitle">Дата</span><?= $order['ORDER']['DATE_INSERT_FORMATED']; ?>
						</th>
						<th><span class="order-good_th-subtitle">Статус</span>
							<span class="order-good_status<?= ($order['ORDER']['CANCELED'] == 'Y') ? ' canceled' : ' submitted' ?>">
								<?= ($order['ORDER']['CANCELED'] == 'Y') ? 'Отменен' : htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']) ?>
							</span>
						</th>
						<th><span class="order-good_th-subtitle">Сумма</span><?= $order['ORDER']['FORMATED_PRICE']; ?>
						</th>
						<th>
							<div class="order-good_th-flex">
								<a href="<?= $order['ORDER']['URL_TO_COPY']; ?>" class="repeat-order_btn"><span
											class="ico-load"></span>Повторить заказ</a>
								<span class="order-good_th-collapse-btn"></span>
								<span class="order-good_mobile-btn"></span>
							</div>
						</th>
					</tr>
					</thead>
					<tbody class="order-good_content">
					<tr class="order-good_title-row">
						<td colspan="2">Товар</td>
						<td>Артикул</td>
						<td>Количество</td>
						<td colspan="2">Цена</td>
					</tr>
                    <?
                    foreach ($order['BASKET_ITEMS'] as $arItem) {
                        ?>
						<tr>
							<td colspan="2">
								<div class="order-good_product">
									<a href="<?= $arItem['DETAIL_PAGE_URL']; ?>">
										<div class="order-good_product-img">
											<img src="<?= $arItem['PRODUCT_IBLOCK_INFO']['PREVIEW_PICTURE']; ?>"
											     alt="<?= $arItem['NAME']; ?>">
										</div>
										<div class="order-good_product-desc">
											<span class="mobile-title">Товар</span>
                                            <? if ($arItem['PRODUCT_IBLOCK_INFO']['CATALOG_QUANTITY'] > 0) { ?>
                                                <? if ($arItem['PRODUCT_IBLOCK_INFO']['CATALOG_QUANTITY'] < 10) { ?>
													<span class="order-good_product-stock few">Осталось мало товара</span>
                                                <? } else { ?>
													<span class="order-good_product-stock">
														<span class="ico-check"></span>В наличии
													</span>
                                                <? } ?>
                                            <? } else { ?>
												<span class="order-good_product-stock ended">Товар закончился</span>
                                            <? } ?>
											<span class="order-good_product-title"><?= $arItem['NAME']; ?></span>
										</div>
									</a>
								</div>
							</td>
							<td>
								<span class="mobile-title">Артикул</span>
                                <?
                                if (!empty($arItem['PRODUCT_IBLOCK_INFO']['PROPERTIES']['ART_NUMBER']['VALUE'])) {
                                    ?>
                                    <?= $arItem['PRODUCT_IBLOCK_INFO']['PROPERTIES']['ART_NUMBER']['VALUE']; ?>
                                    <?
                                } else { ?>
									Отсутствует
                                <? } ?>
							</td>
							<td>
								<span class="mobile-title">Количество</span><?= $arItem['QUANTITY']; ?> <?= $arItem['MEASURE_NAME']; ?>
							</td>
							<td colspan="2"><span class="mobile-title">Цена</span>
                                <?= sprintf('%s / %s', CurrencyFormat($arItem['PRICE'], $arItem['CURRENCY']),
                                    $arItem['MEASURE_NAME']) ?>
							</td>
						</tr>
                        <?
                    } ?>
					</tbody>
				</table>
			</div>
            <?
        }
    }
    ?>
    <?
    echo $arResult["NAV_STRING"];

    if ($_REQUEST["filter_history"] !== 'Y') {
        $javascriptParams = array(
            "url" => CUtil::JSEscape($this->__component->GetPath() . '/ajax.php'),
            "templateFolder" => CUtil::JSEscape($templateFolder),
            "templateName" => $this->__component->GetTemplateName(),
            "paymentList" => $paymentChangeData,
            "returnUrl" => CUtil::JSEscape($arResult["RETURN_URL"]),
        );
        $javascriptParams = CUtil::PhpToJSObject($javascriptParams);
        ?>
		<script>
            BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
		</script>
        <?
    }
}
?>
