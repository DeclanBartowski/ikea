<?php
if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$arComponentDescription = [
    'NAME' => 'Контакты',
    'DESCRIPTION' => 'Компонент для вывода контактов',
    'SORT' => 10,
    "COMPLEX" => "N",
    'PATH' => [
        'ID' => '2quick',
        'NAME' => 'Компоненты 2Quick',
        'SORT' => 10,
        'CHILD' => [
            'ID' => 'Вывод информации',
            'NAME' => Loc::getMessage('PROJECT_COMP'),
            'SORT' => 10
        ]
    ]
];