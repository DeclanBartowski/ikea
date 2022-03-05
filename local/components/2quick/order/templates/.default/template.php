<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

/** @var array $arParams */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var array $arResult */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->SetViewTarget('main-class'); ?> cart<? $this->EndViewTarget(); ?>
<noscript>
	<div style="color:red"><?= GetMessage('SOA_NO_JS'); ?></a>.</div>
</noscript>

<div class="ordering-section">
	<div class="cart-section_content">
		<div class="row cart-row">
			<div class="cart_left-column">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "favorites",
                    Array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(0 => "",),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "left",
                        "USE_EXT" => "N"
                    )
                ); ?>
			</div>
			<div class="cart_center-column">
				<form method="POST" id="ORDER" class="checkout-form">
					<div class="subtitle">Личные данные</div>

                    <? foreach ($arResult['MAIN_PROPS'] as $prop) {
                        $required = '';
                        if ($prop['REQUIRED'] == 'Y') {
                            $required = ' requiredField ';
                            if ($prop['IS_PROFILE_NAME'] == 'Y') {
                                $required .= 'callback-name';
                            } elseif ($prop['IS_PHONE'] == 'Y') {
                                $required .= 'callback-phone';
                            } elseif ($prop['IS_EMAIL'] == 'Y') {
                                $required .= 'callback-email';
                            } else {
                                $required .= 'callback-text';
                            }
                        }
                        ?>
                        <? if ($prop['IS_LOCATION'] == 'Y') { ?>
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:sale.location.selector.search",
                                "",
                                Array(
                                    "CACHE_TIME" => "36000000",
                                    "CACHE_TYPE" => "A",
                                    "CODE" => "",
                                    "FILTER_BY_SITE" => "N",
                                    "ID" => "",
                                    "INITIALIZE_BY_GLOBAL_EVENT" => "",
                                    "INPUT_NAME" => "LOCATION",
                                    "JS_CALLBACK" => "",
                                    "JS_CONTROL_GLOBAL_ID" => "",
                                    "PROVIDE_LINK_BY" => "id",
                                    "SHOW_DEFAULT_LOCATIONS" => "N",
                                    "SUPPRESS_ERRORS" => "N"
                                )
                            ); ?>
                        <? } else { ?>
							<div class="form-group">
								<input type="text"
								       name="<?= $prop['CODE']; ?>"
								       value="<?= (is_array($prop['VALUE'])) ? $prop['VALUE'][0] : $prop['VALUE']; ?>"
								       class="form-control<?= $required; ?>">
								<label class="form-label"><?= $prop['NAME']; ?></label>
								<span class="input_delete-text ico-close"></span>
							</div>
                        <? } ?>
                    <? } ?>
                    <? foreach ($arResult['CHUNKED_PROPS'] as $chunk) { ?>
						<div class="row">
                            <? foreach ($chunk as $prop) {
                                $required = '';
                                if ($prop['REQUIRED'] == 'Y') {
                                    $required = ' requiredField ';
                                    if ($prop['IS_PROFILE_NAME'] == 'Y') {
                                        $required .= 'callback-name';
                                    } elseif ($prop['IS_PHONE'] == 'Y') {
                                        $required .= 'callback-phone';
                                    } elseif ($prop['IS_EMAIL'] == 'Y') {
                                        $required .= 'callback-email';
                                    } else {
                                        $required .= 'callback-text';
                                    }
                                } ?>
								<div class="col-md-4">
									<div class="form-group">
										<input type="text"
										       name="<?= $prop['CODE']; ?>"
										       value="<?= (is_array($prop['VALUE'])) ? $prop['VALUE'][0] : $prop['VALUE']; ?>"
										       class="form-control<?= $required; ?>">
										<label class="form-label"> <?= $prop['NAME']; ?></label>
										<span class="input_delete-text ico-close"></span>
									</div>
								</div>
                            <? } ?>
						</div>
                    <? } ?>

					<div class="form-group form-group_mod">
						<textarea name="comment" class="form-control"></textarea>
						<label class="form-label">Комментарий к заказу</label>
					</div>
					<div class="checkout-form_footer">
						<div class="checkout-form_policy">
							Нажимая на кнопку "Оформить заказ", вы соглашаетесь на <a href="">Обработку своих
								персональных
								данных</a> и соглашаетесь с <a href="">Условиями конфиденциальности</a>
						</div>
						<input type="submit" class="main-btn checkout-form_submit-btn js_form-submit"
						       value="Оформить заказ">
					</div>
				</form>
			</div>
			<div class="cart_right-column">
				<div class="cart-total_box">
					<div class="h4">Сумма заказа</div>
					<table class="cart-total_table">


						<tr class="delivery-data">
							<td><?= $arResult['DELIVERIES'][$arResult['INFO_ORDER']['DELIVERY_ID']]['NAME']; ?></td>
							<td><?= $arResult['INFO_ORDER']['FORMATED_DELIVERY_PRICE']; ?></td>
						</tr>

						<tr>
							<td>Сумма заказа</td>
							<td><span class="cart-total-sum"><?= $arResult['INFO_ORDER']['PRICE_FORMATED']; ?></span>
							</td>
						</tr>
						<tr>
							<td>Скидка</td>
							<td class="discount_sum">- <?= $arResult['INFO_ORDER']['FORMATED_DISCOUNT_PRICE']; ?></td>
						</tr>
						<tr>
							<td><strong>Общая сумма</strong></td>
							<td><span class="cart-total_sum"><?= $arResult['INFO_ORDER']['FORMATED_SUM']; ?></span></td>
						</tr>
					</table>
				</div>

				<div class="checkout-sidebar_box delivery_description"<? if (empty($arResult['DELIVERIES'][$arResult['INFO_ORDER']['DELIVERY_ID']]['DESCRIPTION'])) {
                    echo ' style="display: none"';
                } ?>>
                    <?= $arResult['DELIVERIES'][$arResult['INFO_ORDER']['DELIVERY_ID']]['DESCRIPTION'] ?>
				</div>

				<div class="checkout-sidebar_box tq_error_order">
					<span class="subtitle">Ошибка!</span>
					<p class="error-text"></p>
				</div>
				<div class="checkout-sidebar_box">
					<span class="subtitle">Наличие товара</span>
					<p>
						Если товара нет в наличии, то вы всё равно можете оформить заказ. В этом случае уточнить сроки
						доставки вы можете у менеджера по телефону или в мессенджере
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
