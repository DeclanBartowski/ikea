<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление пароля");
global $USER;
if($USER->IsAuthorized()){
    localRedirect('/auth/');
}
?>
    <? $APPLICATION->IncludeComponent(
        "bitrix:system.auth.forgotpasswd",
        "custom",
        ['AUTH_RESULT'=>$APPLICATION->arAuthResult],
        false
    ); ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>