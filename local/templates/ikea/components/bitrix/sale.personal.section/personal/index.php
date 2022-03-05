<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;


if ($arParams["MAIN_CHAIN_NAME"] <> '')
{
    $APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}

$availablePages = array();

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y')
{
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_PRIVATE'],
        "name" => Loc::getMessage("SPS_PERSONAL_PAGE_NAME"),
        "icon" => SITE_TEMPLATE_PATH.'/img/icons/pa/01.svg'
    );
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_ORDERS'],
        "name" => 'Текущие заказы',
        "icon" => SITE_TEMPLATE_PATH.'/img/icons/pa/02.svg'
    );
    $availablePages[] = array(
        "path" => sprintf('%s?filter_history=Y',$arResult['PATH_TO_ORDERS']),
        "name" => 'История заказов',
        "icon" => SITE_TEMPLATE_PATH.'/img/icons/pa/03.svg'
    );
}

$customPagesList = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($customPagesList)
{
    foreach ($customPagesList as $page)
    {
        $availablePages[] = array(
            "path" => $page[0],
            "name" => $page[1],
            "icon" => (mb_strlen($page[2])) ? htmlspecialcharsbx($page[2]) : ""
        );
    }
}

if ($arParams['SHOW_BASKET_PAGE'] === 'Y')
{
    $availablePages[] = array(
        "path" => $arParams['PATH_TO_BASKET'],
        "name" => Loc::getMessage("SPS_BASKET_PAGE_NAME"),
        "icon" => SITE_TEMPLATE_PATH.'/img/icons/pa/05.svg'
    );
}

if (empty($availablePages))
{
    ShowError(Loc::getMessage("SPS_ERROR_NOT_CHOSEN_ELEMENT"));
}
else
{
    ?>
	<div class="personal-area_section">
		<div class="container">
            <?include_once ($_SERVER['DOCUMENT_ROOT'].'/include/header.php')?>
			<ul class="personal-area_menu">
                <?
                foreach ($availablePages as $blockElement)
                {
                    ?>
					<li>
						<div class="personal-area_item">
							<a href="<?=htmlspecialcharsbx($blockElement['path'])?>">
								<span class="item-icon"><img data-src="<?=$blockElement['icon']?>" alt="alt"></span><?=htmlspecialcharsbx($blockElement['name'])?>
							</a>
						</div>
					</li>
                    <?
                }
                ?>
			</ul>
			<div class="wrapper_back-page_btn">
				<a href="<?=$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), array(
                    "login",
                    "logout",
                    "register",
                    "forgot_password",
                    "change_password"));?>" class="main-btn back-page_btn"><span class="ico-arrow-3"></span>Выйти из кабинета</a>
			</div>
		</div>
	</div>
    <?
}
?>
