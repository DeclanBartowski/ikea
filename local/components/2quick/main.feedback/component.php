<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == '')
    $arParams["EVENT_NAME"] = "FEEDBACK_FORM";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == '')
    $arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if($arParams["OK_TEXT"] == '')
    $arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"]))
{
    $arResult["ERROR_MESSAGE"] = array();
    if(check_bitrix_sessid())
    {
        /*if(empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"]))
        {
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_name"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_NAME");
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_email"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_EMAIL");
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["MESSAGE"]) <= 3)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_MESSAGE");
        }
        if(strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"]))
            $arResult["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");*/
        if($arParams["USE_CAPTCHA"] == "Y")
        {
            include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
            $captcha_code = $_POST["captcha_sid"];
            $captcha_word = $_POST["captcha_word"];
            $cpt = new CCaptcha();
            $captchaPass = COption::GetOptionString("main", "captcha_password", "");
            if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0)
            {
                if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
                    $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
            }
            else
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");

        }
        if(empty($arResult["ERROR_MESSAGE"]))
        {
            $arFields = Array(
                "EMAIL_TO" => $arParams["EMAIL_TO"],
            );
            foreach($_POST as $keyPOST => $valuePOST){
                $arFields[$keyPOST] = $valuePOST;
            }
            if(!empty($_FILES["file"])){
                if($arParams["MULTI_FILES"]=='Y'){
                    $files = array();
                    foreach ($_FILES['file']["name"] as $key=> $arItem){
                        $files[$key]["name"] = $_FILES['file']["name"][$key];
                        $files[$key]["type"] =  $_FILES['file']["type"][$key];
                        $files[$key]["tmp_name"] =  $_FILES['file']["tmp_name"][$key];
                        $files[$key]["error"] =  $_FILES['file']["error"][$key];
                        $files[$key]["size"] =  $_FILES['file']["size"][$key];
                    }
                    $arFields["file"] = $files;
                }
                else{
                    $arFields["file"] = $_FILES["file"];
                }
            }
            if($arParams['INFOBLOCKADD'] == "Y" && !empty($arParams['INFOBLOCKID'])){
                CModule::IncludeModule("iblock");
                $el = new CIBlockElement;
                $arLoadProductArray = Array(
                    "IBLOCK_ID"      => intval($arParams['INFOBLOCKID']),
                    "PROPERTY_VALUES"=> $arFields,
                    "PREVIEW_TEXT"=> $_POST["PREVIEW_TEXT"],
                    "NAME"           => "Элемент",
                    "ACTIVE"           => "N",
                );
                $PRODUCT_ID = $el->Add($arLoadProductArray);
                if($PRODUCT_ID>0) {
                  switch ($_POST['formType']) {
                    case 'contacts':
                      $name = sprintf('Заявка № %s, %s',$PRODUCT_ID,$_POST['tabName']);
                      break;
                    default:
                  }
                  $updateFields =[
                    'NAME'=>$name
                  ];
                  $arFields['TITLE'] = $updateFields['NAME'];
                  $el->Update($PRODUCT_ID,$updateFields);
                }
            }

            if(!empty($arParams["EVENT_MESSAGE_ID"]))
            {
                foreach($arParams["EVENT_MESSAGE_ID"] as $v){
                    if(IntVal($v) > 0){
                        if($arParams["FILE_SEND"]=='Y'){
                            if(!empty($_FILES['file'])){
                                $files=array();
                                foreach ($_FILES['file'] as $propName => $arr){
                                    foreach ($arr as $key => $item){
                                        $filesProm[$key][$propName] = $item;
                                    }
                                }
                                foreach ($filesProm as $file){

                                    if (!empty($file['tmp_name'])){
                                        $files[]=CFile::SaveFile($file,'/feedback');
                                    }
                                }
                            }
                            if(!empty($files)){
                                CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v),$files);
                            }
                            else{
                                CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v));
                            }
                        }
                        else{
                            CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v));
                        }
                    }
                }
            }
            else
                CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields);
            $_SESSION["MF_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
            $_SESSION["MF_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
            LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"], Array("success")));
        }

        $arResult["MESSAGE"] = htmlspecialcharsbx($_POST["MESSAGE"]);
        $arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
        $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
    }
    else
        $arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
}
elseif($_REQUEST["success"] == $arResult["PARAMS_HASH"])
{
    $arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}

if(empty($arResult["ERROR_MESSAGE"]))
{
    if($USER->IsAuthorized())
    {
        $arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
        $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
    }
    else
    {
        if(strlen($_SESSION["MF_NAME"]) > 0)
            $arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
        if(strlen($_SESSION["MF_EMAIL"]) > 0)
            $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
    }
}

if($arParams["USE_CAPTCHA"] == "Y")
    $arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

CModule::IncludeModule("iblock");
$res = CIBlock::GetByID($arParams["INFOBLOCKID"]);
$ar_res = $res->GetNext();
$arResult["NAME"] = $ar_res['NAME'];

$this->IncludeComponentTemplate();
