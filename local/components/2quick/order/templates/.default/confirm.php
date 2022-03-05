<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */

/** @var CBitrixComponent $component */

use Bitrix\Sale;
use Bitrix\Sale\PaySystem;

?>
	<div class="ordering-section">
		<div class="cart-section_content">
            <? if ($arResult['ORDER']['ORDER_ID']) { ?>
				<div class="order-placed_box">
					<div class="order-placed_icon"><img alt="alt"
					                                    src="<?= SITE_TEMPLATE_PATH ?>/img/icons/checkout-icon.svg">
					</div>
					<div class="section-title">Ваш заказ принят!</div>
					<p>В ближайшее время с вами свяжутся наши специалисты <br> для уточнения деталей заказа</p>
					<a href="<?= $arParams['EMPTY_BASKET_HINT_PATH']; ?>" class="main-btn main-btn_mod">Перейти в
						каталог</a>
				</div>
            <? } else { ?>
				<div class="cart-empty_box">
				<span class="cart-empty_box-icon">
					<img alt="alt" src="<?= SITE_TEMPLATE_PATH ?>/img/icons/cart-icon.svg">
				</span>
					<div class="section-title"> <?= $arResult['ORDER']['MESSAGE']; ?></div>
					<p>Перейдите в каталог, у нас много интересного </p>
					<a href="<?= $arParams['EMPTY_BASKET_HINT_PATH']; ?>" class="main-btn main-btn_mod">
						Перейти в каталог
					</a>
				</div>
            <? } ?>
		</div>
	</div>
	<!-- end ordering-section -->
<?
/*

<div class="container">
	<a href="<?= SITE_DIR ?>personal/" class="link-arrow user__back">
		<svg width="11" height="8" viewBox="0 0 11 8" class="link-arrow__icon">
			<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/sprite.svg#arrow-double"></use>
		</svg>
		<span><?= GetMessage('TQ_ORDER_BACK_TO_PERSONAL'); ?></span>
	</a>
	<div class="user__content">
        <? $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "left",
            Array(
                'ADITIONAL_CLASS' => 'user__sidebar_wide',
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "personal",
                "DELAY" => "N",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_GET_VARS" => array(""),
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "ROOT_MENU_TYPE" => "personal",
                "TITLE" => GetMessage('TQ_ORDER_MENU_TITLE'),
                "USE_EXT" => "N"
            )
        ); ?>
		<div class="user__box">
            <?
            if ($arResult['ORDER']['ORDER_ID']) {
                $order = Sale\Order::load($arResult['ORDER']['ORDER_ID']);
                $propertyCollection = $order->getPropertyCollection();
                $paymentCollection = $order->getPaymentCollection();
                $arResult["ORDER"]["IS_ALLOW_PAY"] = $order->isAllowPay() ? 'Y' : 'N';
                $arResult["PAYMENT"] = array();
                if ($order->isAllowPay()) {
                    $paymentCollection = $order->getPaymentCollection();
                    /** @var Payment $payment */
/*
                    foreach ($paymentCollection as $payment) {
                        $arResult["PAYMENT"][$payment->getId()] = $payment->getFieldValues();

                        if (intval($payment->getPaymentSystemId()) > 0 && !$payment->isPaid()) {
                            $paySystemService = PaySystem\Manager::getObjectById($payment->getPaymentSystemId());
                            if (!empty($paySystemService)) {
                                $arPaySysAction = $paySystemService->getFieldsValues();

                                if ($paySystemService->getField('NEW_WINDOW') === 'N' || $paySystemService->getField('ID') == PaySystem\Manager::getInnerPaySystemId()) {
                                    /** @var PaySystem\ServiceResult $initResult */
/*
                                    $initResult = $paySystemService->initiatePay($payment, null,
                                        PaySystem\BaseServiceHandler::STRING);

                                    if ($initResult->isSuccess()) {
                                        $arPaySysAction['BUFFERED_OUTPUT'] = $initResult->getTemplate();
                                    } else {
                                        $arPaySysAction["ERROR"] = $initResult->getErrorMessages();
                                    }


                                }

                                $arResult["PAYMENT"][$payment->getId()]['PAID'] = $payment->getField('PAID');

                                $arOrder['PAYMENT_ID'] = $payment->getId();
                                $arOrder['PAY_SYSTEM_ID'] = $payment->getPaymentSystemId();
                                $arPaySysAction["NAME"] = htmlspecialcharsEx($arPaySysAction["NAME"]);
                                $arPaySysAction["IS_AFFORD_PDF"] = $paySystemService->isAffordPdf();

                                if ($arPaySysAction > 0) {
                                    $arPaySysAction["LOGOTIP"] = CFile::GetFileArray($arPaySysAction["LOGOTIP"]);
                                }


                                if ($this->arParams['COMPATIBLE_MODE'] == 'Y' && !$payment->isInner()) {
                                    // compatibility
                                    \CSalePaySystemAction::InitParamArrays($order->getFieldValues(), $order->getId(),
                                        '',
                                        array(), $payment->getFieldValues());
                                    $map = CSalePaySystemAction::getOldToNewHandlersMap();
                                    $oldHandler = array_search($arPaySysAction["ACTION_FILE"], $map);
                                    if ($oldHandler !== false && !$paySystemService->isCustom()) {
                                        $arPaySysAction["ACTION_FILE"] = $oldHandler;
                                    }

                                    if (strlen($arPaySysAction["ACTION_FILE"]) > 0 && $arPaySysAction["NEW_WINDOW"] != "Y") {
                                        $pathToAction = Main\Application::getDocumentRoot() . $arPaySysAction["ACTION_FILE"];

                                        $pathToAction = str_replace("\\", "/", $pathToAction);
                                        while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/") {
                                            $pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);
                                        }

                                        if (file_exists($pathToAction)) {
                                            if (is_dir($pathToAction) && file_exists($pathToAction . "/payment.php")) {
                                                $pathToAction .= "/payment.php";
                                            }

                                            $arPaySysAction["PATH_TO_ACTION"] = $pathToAction;
                                        }
                                    }

                                    $arResult["PAY_SYSTEM"] = $arPaySysAction;
                                }

                                $arResult["PAY_SYSTEM_LIST"][$payment->getPaymentSystemId()] = $arPaySysAction;
                                $arResult["PAY_SYSTEM_LIST_BY_PAYMENT_ID"][$payment->getId()] = $arPaySysAction;
                            } else {
                                $arResult["PAY_SYSTEM_LIST"][$payment->getPaymentSystemId()] = array('ERROR' => true);
                            }
                        }
                    }
                }
                $emailPropValue = $propertyCollection->getUserEmail()->getValue();
                ?>
                <? if (!empty($arResult["ORDER"])): ?>
					<h2 class="main__title"><?= GetMessage('TQ_ORDER_TITLE'); ?></h2>
					<div>
                        <?= GetMessage('TQ_ORDER_NUMBER',
                            ['#ORDER_NUMBER#' => $arResult['ORDER']['ORDER_ID']]); ?>
						<br><?= GetMessage('TQ_ORDER_SEND_TO_EMAIL', ['#EMAIL#' => $emailPropValue]); ?>
						<br><?= GetMessage('TQ_ORDER_DESCRIPTION'); ?>
						<br><?= GetMessage('TQ_ORDER_RETURN_RULES', ['#DAYS#' => 14]); ?>
						<br><?= GetMessage('TQ_ORDER_THANKS'); ?>
					</div>
                    <?= GetMessage('TQ_ORDER_LINK',
                        [
                            '#URL#' => SITE_DIR . 'personal/orders/',
                            '#PAGE#' => 'Заказы',
                            '#SITE_TEMPLATE_PATH#' => SITE_TEMPLATE_PATH,
                            '#TITLE#' => ''
                        ]
                    ); ?>


                    <? if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y') {
                        if (!empty($arResult["PAYMENT"])) {
                            foreach ($arResult["PAYMENT"] as $payment) {
                                if ($payment["PAID"] != 'Y') {
                                    if (!empty($arResult['PAY_SYSTEM_LIST'])
                                        && array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
                                    ) {
                                        $arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

                                        if (empty($arPaySystem["ERROR"])) {
                                            ?>
											<div class="user__pay">
												<h2><?= GetMessage('SOA_PAY'); ?></h2>
												<p><?= $arPaySystem["NAME"] ?>,</p>
                                                <? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
                                                    <?
                                                    $orderAccountNumber = $arResult['ORDER']['ORDER_ID'];
                                                    $paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
                                                    ?>
													<script>
                                                        window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
													</script>
                                                <?= GetMessage("SOA_PAY_LINK",
                                                    array("#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&PAYMENT_ID=" . $paymentAccountNumber)) ?>
                                                <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
												<br/>
                                                    <?= GetMessage("SOA_PAY_PDF",
                                                        array("#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&pdf=1&DOWNLOAD=Y")) ?>
                                                <? endif ?>
                                                <? else: ?>
                                                    <?= $arPaySystem["BUFFERED_OUTPUT"] ?>
                                                <? endif ?>
											</div>
                                            <?
                                        } else {
                                            ?>
											<span style="color:red;"><?= GetMessage("SOA_ORDER_PS_ERROR") ?></span>
                                            <?
                                        }
                                    } else {
                                        ?>
										<span style="color:red;"><?= GetMessage("SOA_ORDER_PS_ERROR") ?></span>
                                        <?
                                    }
                                }
                            }
                        }
                    } else {
                        ?>
						<br/><strong><?= $arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] ?></strong>
                        <?
                    }
                    ?>
                <? else: ?>
					<b><?= GetMessage("SOA_ERROR_ORDER") ?></b>
					<br/><br/>
					<table class="sale_order_full_table">
						<tr>
							<td>
                                <?= GetMessage("SOA_ERROR_ORDER_LOST",
                                    ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])]) ?>
                                <?= GetMessage("SOA_ERROR_ORDER_LOST1") ?>
							</td>
						</tr>
					</table>
                <? endif ?>
            <? } else {
                ?>
                <?= GetMessage('TQ_ORDER_LINK',
                    [
                        '#URL#' => SITE_DIR . 'catalog/',
                        '#PAGE#' => 'Каталога',
                        '#SITE_TEMPLATE_PATH#' => SITE_TEMPLATE_PATH,
                        '#TITLE#' => sprintf('<div class="cart-empty-msg"><strong>%s</strong></div>',
                            GetMessage('TQ_ORDER_NOT_FOUND'))
                    ]
                ); ?>
            <? } ?>
		</div>
	</div>
</div>
*/
?>