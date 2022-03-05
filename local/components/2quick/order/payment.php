<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/basket.css", true);

?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment",
	"",
Array()
);?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>