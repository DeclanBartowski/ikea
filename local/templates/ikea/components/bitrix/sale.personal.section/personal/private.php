<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

if ($arParams['SHOW_PRIVATE_PAGE'] !== 'Y') {
    LocalRedirect($arParams['SEF_FOLDER']);
}

if ($arParams["MAIN_CHAIN_NAME"] <> '') {
    $APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}
$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_PRIVATE"));
if ($arParams['SET_TITLE'] == 'Y') {
    $APPLICATION->SetTitle(Loc::getMessage("SPS_TITLE_PRIVATE"));
}

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_PRIVATE'],
        "name" => 'Личные данные',
        "icon" => SITE_TEMPLATE_PATH . '/img/icons/pa/01.svg',
        "active" => true
    );
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_ORDERS'],
        "name" => 'Текущие заказы',
        "icon" => SITE_TEMPLATE_PATH . '/img/icons/pa/02.svg'
    );
    $availablePages[] = array(
        "path" => sprintf('%s?filter_history=Y', $arResult['PATH_TO_ORDERS']),
        "name" => 'История заказов',
        "icon" => SITE_TEMPLATE_PATH . '/img/icons/pa/03.svg'
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
                    "bitrix:main.profile",
                    "",
                    Array(
                        "SET_TITLE" => $arParams["SET_TITLE"],
                        "AJAX_MODE" => $arParams['AJAX_MODE_PRIVATE'],
                        "SEND_INFO" => $arParams["SEND_INFO_PRIVATE"],
                        "CHECK_RIGHTS" => $arParams['CHECK_RIGHTS_PRIVATE'],
                        "EDITABLE_EXTERNAL_AUTH_ID" => $arParams['EDITABLE_EXTERNAL_AUTH_ID'],
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
