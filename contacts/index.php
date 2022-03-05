<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?><?$APPLICATION->IncludeComponent(
	"2quick:contacts", 
	".default", 
	array(
		"ADDRESS" => array(
			0 => "Калининград, ул. Ленина 55, оф. 5",
			1 => "",
		),
		"DESCRIPTION" => "Мы всегда рады ответить на все ваши вопросы об условиях работы, сроках и стомости доставки товаров.",
		"EMAIL" => array(
			0 => "mail@mail.ru",
		),
		"EMAILS" => array(
			0 => "mail@mail.ru",
		),
		"PHONES" => array(
			0 => "+ 7 000-000-00-00",
			1 => "",
		),
		"WORK_TIMES" => array(
			0 => "ПН - ПТ с 11:00 до 20:00",
			1 => "СБ с 11:00 до 19:00",
			2 => "Воскресенье - Выходной",
			3 => "",
		),
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>