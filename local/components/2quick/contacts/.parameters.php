<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"ADDRESS" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => 'Адресс',
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),
        "PHONES" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => 'Телефоны',
            "TYPE" => "STRING",
            "DEFAULT" => "",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
        ),
        "EMAILS" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => 'E-Mail',
            "TYPE" => "STRING",
            "DEFAULT" => "",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
        ),
		"WORK_TIMES" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => 'Время работы',
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),
		"DESCRIPTION" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => 'Описание',
			"TYPE" => "TEXT",
			"DEFAULT" => "",
		)
	),
);

?>
