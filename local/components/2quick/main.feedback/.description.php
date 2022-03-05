<?php
if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$arComponentDescription = [
    'NAME' => 'Форма обратной связи',
    'DESCRIPTION' => 'Компонент формы обратной связи',
    'SORT' => 10,
    "COMPLEX" => "N",
    'PATH' => [
        'ID' => '2quick',
        'NAME' => 'Компоненты 2Quick',
        'SORT' => 10,
        'CHILD' => [
            'ID' => 'Формы',
            'NAME' => Loc::getMessage('PROJECT_COMP'),
            'SORT' => 10
        ]
    ]
];