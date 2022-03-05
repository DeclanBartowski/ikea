<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.section", 
	"personal", 
	array(
		"ACCOUNT_PAYMENT_SELL_USER_INPUT" => "N",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_RIGHTS_PRIVATE" => "N",
		"COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
		"CUSTOM_PAGES" => "[[\"/personal/change-password/\",\"Смена пароля\",\"/local/templates/ikea/img/icons/pa/04.svg\"]]",
		"CUSTOM_SELECT_PROPS" => array(
			0 => "ART_NUMBER",
			1 => "PREVIEW_PICTURE",
			2 => "",
		),
		"MAIN_CHAIN_NAME" => "Личный кабинет",
		"NAV_TEMPLATE" => "",
		"ORDERS_PER_PAGE" => "20",
		"ORDER_DEFAULT_SORT" => "STATUS",
		"ORDER_DISALLOW_CANCEL" => "N",
		"ORDER_HIDE_USER_INFO" => array(
			0 => "0",
		),
		"ORDER_HISTORIC_STATUSES" => array(
			0 => "F",
		),
		"ORDER_REFRESH_PRICES" => "N",
		"ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array(
			0 => "N",
			1 => "F",
		),
		"PATH_TO_BASKET" => "/basket/",
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_CONTACT" => "/contacts/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PROFILES_PER_PAGE" => "20",
		"SAVE_IN_SESSION" => "Y",
		"SEF_FOLDER" => "/personal/",
		"SEF_MODE" => "Y",
		"SEND_INFO_PRIVATE" => "N",
		"SET_TITLE" => "Y",
		"SHOW_ACCOUNT_PAGE" => "N",
		"SHOW_BASKET_PAGE" => "Y",
		"SHOW_CONTACT_PAGE" => "N",
		"SHOW_ORDER_PAGE" => "Y",
		"SHOW_PRIVATE_PAGE" => "Y",
		"SHOW_PROFILE_PAGE" => "N",
		"SHOW_SUBSCRIBE_PAGE" => "N",
		"USE_AJAX_LOCATIONS_PROFILE" => "N",
		"COMPONENT_TEMPLATE" => "personal",
		"PROP_1" => array(
		),
		"SEF_URL_TEMPLATES" => array(
			"index" => "index.php",
			"orders" => "orders/",
			"account" => "account/",
			"subscribe" => "subscribe/",
			"profile" => "profiles/",
			"profile_detail" => "profiles/#ID#",
			"private" => "private/",
			"order_detail" => "orders/#ID#",
			"order_cancel" => "cancel/#ID#",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>