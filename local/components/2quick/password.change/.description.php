<?php
if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$arComponentDescription = [
    'NAME' => 'Смена пароля',
    'DESCRIPTION' => "Компонент для смены пароля",
    'SORT' => 10,
    "COMPLEX" => "N",
    'PATH' => [
        'ID' => '2quick',
        'NAME' => 'Компоненты 2Quick',
        'SORT' => 10,
    ]
];