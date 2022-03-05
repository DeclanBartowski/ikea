<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Config\Option;

$mid = 'tq.tools';//TODO можно ли вытянуть id модуля  как нибудь иначе?;

$data = Option::get("tq.tools", "tq_default_settings");
$defSettings = unserialize($data);

$tabs =['all'=>'Все'];

if($defSettings['TABS']) {
  foreach ($defSettings['TABS'] as $tabCode => $tab) {
    $tabs[$tabCode] = $tab['TAB'];
    if($tab['OPTIONS']) {
      foreach ($tab['OPTIONS'] as $optCode => $option) {
        if($arCurrentValues['TABS'][0] !='all') {
          foreach ($arCurrentValues['TABS'] as $currentTab) {
            if($tabCode ==$currentTab) {
              $fields[$optCode] = $option['NAME'];
            }
          }
        } else {
          $fields[$optCode] = $option['NAME'];
        }

      }
    }
  }
  $arComponentParameters = array(
    "PARAMETERS" => array(
      "TABS" => Array(
        "NAME" => 'Табы',
        "TYPE"=>"LIST",
        "VALUES" => $tabs,
        'DEFAULT'=>'all',
        "MULTIPLE"=>"Y",
        "COLS"=>25,
        "PARENT" => "BASE",
        "REFRESH" => "Y",
      ),
      "FIELDS" => Array(
        "NAME" => 'Поля',
        "TYPE"=>"LIST",
        "VALUES" => $fields,
        "MULTIPLE"=>"Y",
        "COLS"=>25,
        "PARENT" => "BASE",
      ),
     "AJAX_MODE" => array(),
    )
  );
}
?>