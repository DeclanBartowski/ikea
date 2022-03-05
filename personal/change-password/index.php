<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Смена пароля");
?>

<? $APPLICATION->IncludeComponent(
    "2quick:password.change",
    "",
    Array()
); ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>