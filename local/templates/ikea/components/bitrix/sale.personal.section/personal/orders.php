<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

if ($arParams['SHOW_ORDER_PAGE'] !== 'Y') {
    LocalRedirect($arParams['SEF_FOLDER']);
}

if ($arParams["MAIN_CHAIN_NAME"] <> '') {
    $APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}

$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_ORDERS"), $arResult['PATH_TO_ORDERS']);

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_PRIVATE'],
        "name" => 'Личные данные',
        "icon" => SITE_TEMPLATE_PATH . '/img/icons/pa/01.svg',
    );
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_ORDERS'],
        "name" => 'Текущие заказы',
        "icon" => SITE_TEMPLATE_PATH . '/img/icons/pa/02.svg',
        "active" => ($_REQUEST['filter_history'] != 'Y')
    );
    $availablePages[] = array(
        "path" => sprintf('%s?filter_history=Y', $arResult['PATH_TO_ORDERS']),
        "name" => 'История заказов',
        "icon" => SITE_TEMPLATE_PATH . '/img/icons/pa/03.svg',
        "active" => ($_REQUEST['filter_history'] == 'Y')
    );
}

$customPagesList = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($customPagesList) {
    foreach ($customPagesList as $page) {
        $availablePages[] = array(
            "path" => $page[0],
            "name" => $page[1],
            "icon" => (mb_strlen($page[2])) ? htmlspecialcharsbx($page[2]) : ""
        );
    }
}

?>
<div class="personal-area_section">
	<div class="personal-area_content">
		<div class="row">
			<div class="col-lg-6 order-lg-2">
                <? if ($_REQUEST['filter_history'] == 'Y') { ?>
					<ul class="personal-area_order-list">
						<li<? if ($_REQUEST['show_canceled'] != 'Y') { ?> class="active"<? } ?>>
							<a href="<?= sprintf('%s?filter_history=Y', $arResult['PATH_TO_ORDERS']); ?>">История
								заказов</a>
						</li>
						<li<? if ($_REQUEST['show_canceled'] == 'Y') { ?> class="active"<? } ?>>
							<a href="<?= sprintf('%s?filter_history=Y&show_canceled=Y',
                                $arResult['PATH_TO_ORDERS']); ?>">Отмененные заказы</a>
						</li>
					</ul>
                <? } else { ?>
					<span class="personal-area_subtitle">Текущие заказы</span>
                <? } ?>
				<div class="tablet-visible">
					<ul class="personal-area_menu">
                        <?
                        foreach ($availablePages as $blockElement) {
                            ?>
							<li>
								<div class="personal-area_item<?
                                if ($blockElement['active']) {
                                    ?> active<?
                                } ?>">
									<a href="<?= htmlspecialcharsbx($blockElement['path']) ?>">
										<span class="item-icon"><img data-src="<?= $blockElement['icon'] ?>" alt="alt"></span><?= htmlspecialcharsbx($blockElement['name']) ?>
									</a>
								</div>
							</li>
                            <?
                        }
                        ?>
					</ul>
				</div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:sale.personal.order.list",
                    "",
                    array(
                        "PATH_TO_DETAIL" => $arResult["PATH_TO_ORDER_DETAIL"],
                        "PATH_TO_CANCEL" => $arResult["PATH_TO_ORDER_CANCEL"],
                        "PATH_TO_CATALOG" => $arParams["PATH_TO_CATALOG"],
                        "PATH_TO_COPY" => $arResult["PATH_TO_ORDER_COPY"],
                        "PATH_TO_BASKET" => $arParams["PATH_TO_BASKET"],
                        "PATH_TO_PAYMENT" => $arParams["PATH_TO_PAYMENT"],
                        "SAVE_IN_SESSION" => $arParams["SAVE_IN_SESSION"],
                        "ORDERS_PER_PAGE" => $arParams["ORDERS_PER_PAGE"],
                        "SET_TITLE" => $arParams["SET_TITLE"],
                        "ID" => $arResult["VARIABLES"]["ID"],
                        "NAV_TEMPLATE" => $arParams["NAV_TEMPLATE"],
                        "ACTIVE_DATE_FORMAT" => $arParams["ACTIVE_DATE_FORMAT"],
                        "HISTORIC_STATUSES" => $arParams["ORDER_HISTORIC_STATUSES"],
                        "ALLOW_INNER" => $arParams["ALLOW_INNER"],
                        "ONLY_INNER_FULL" => $arParams["ONLY_INNER_FULL"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "DISALLOW_CANCEL" => $arParams["ORDER_DISALLOW_CANCEL"],
                        "DEFAULT_SORT" => $arParams["ORDER_DEFAULT_SORT"],
                        "RESTRICT_CHANGE_PAYSYSTEM" => $arParams["ORDER_RESTRICT_CHANGE_PAYSYSTEM"],
                        "REFRESH_PRICES" => $arParams["ORDER_REFRESH_PRICES"],
                    ),
                    $component
                ); ?>
			</div>
			<div class="col-lg-3 orer-lg-1">
				<ul class="personal-area_menu">
                    <?
                    foreach ($availablePages as $blockElement) {
                        ?>
						<li<?
                        if ($blockElement['active']) {
                            ?> class="tablet-hidden"<?
                        } ?>>
							<div class="personal-area_item<?
                            if ($blockElement['active']) {
                                ?> active<?
                            } ?>">
								<a href="<?= htmlspecialcharsbx($blockElement['path']) ?>">
									<span class="item-icon"><img data-src="<?= $blockElement['icon'] ?>"
									                             alt="alt"></span><?= htmlspecialcharsbx($blockElement['name']) ?>
								</a>
							</div>
						</li>
                        <?
                    }
                    ?>
				</ul>
			</div>
			<div class="col-lg-3 order-lg-3 right-column">
				<a href="<?=$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), array(
                    "login",
                    "logout",
                    "register",
                    "forgot_password",
                    "change_password"));?>" class="main-btn main-btn_mod back-page_btn"><span class="ico-arrow-3"></span>Выйти
					из кабинета</a>
			</div>
		</div>
	</div>
</div>
