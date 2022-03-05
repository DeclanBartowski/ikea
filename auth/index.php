<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вход и регистрация");
?>
    <? $APPLICATION->IncludeComponent(
        "2quick:authorize",
        "",
        [],
        false
    ); ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>