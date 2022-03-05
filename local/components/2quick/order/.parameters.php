<?php
if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        "AJAX_MODE" => [],
        "CACHE_TIME"  =>  ["DEFAULT"=>86400],
        "PATH_TO_PAYMENT"  =>  [
            'NAME'=>'Путь для оплаты заказа',
            'DEFAULT'=>'payment.php',
            "TYPE"=>"STRING",
            "PARENT" => "BASE",
        ],
    ],
];