<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Data\Cache;
use \Bitrix\Main\Config\Option;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

class TqModuleData extends \CBitrixComponent
{
    /**
     * @override
     */
    public function onIncludeComponentLang()
    {
        parent::onIncludeComponentLang();
        $this->includeComponentLang(basename(__FILE__));
    }
    /**
     * @param $params
     * @override
     * @return array
     */
    public function onPrepareComponentParams($params)
    {
        $params = parent::onPrepareComponentParams($params);

        if (!isset($params["CACHE_TIME"])) {
            $params["CACHE_TIME"] = 86400;
        }
        $params['CACHE_GROUPS'] = ($params['CACHE_GROUPS'] == 'Y');
        $data = Option::get("tq.tools", "tq_default_settings");
        $params['MODULE_SETTINGS'] = unserialize($data);
        return $params;
    }


    /**
     * @return mixed|void
     */
    public function executeComponent()
    {
        if ($this->StartResultCache($this->arParams['CACHE_TIME'])) {
            $this->initResult();
            $this->includeComponentTemplate();
        }
    }


    /**
     * @throws Exception
     */
    protected function initResult()
    {
          $result = [];
          $tabs = $this->arParams['TABS'];
          $fields = $this->arParams['FIELDS'];
          $moduleSettings = $this->arParams['MODULE_SETTINGS'];
          if(count($tabs)>0 || count($fields)>0) {//Кейс когда не выбрано вообще ничего

              if(count($tabs) == 1 && $tabs[0] =='all') {// выбран таб все
                foreach ($moduleSettings['TABS'] as $tabKey=> $arTab) {
                  if(count($fields)>0) {
                    foreach ($fields as $fieldCode) {
                        if($moduleSettings['TABS'][$tabKey]['OPTIONS'][$fieldCode]['CODE']){
                          $result['TABS'][$tabKey]['NAME'] = $arTab['TAB'];
                          $result['TABS'][$tabKey]['OPTIONS'][$fieldCode]['NAME'] = $moduleSettings['TABS'][$tabKey]['OPTIONS'][$fieldCode]['NAME'];
                          $result['TABS'][$tabKey]['OPTIONS'][$fieldCode]['CODE'] = $moduleSettings['TABS'][$tabKey]['OPTIONS'][$fieldCode]['CODE'];
                          $result['TABS'][$tabKey]['OPTIONS'][$fieldCode]['VALUE'] = Option::get("tq.tools", sprintf('tq_module_param_%s_%s',$tabKey,$fieldCode));
                        }
                    }
                  } else {
                    foreach ($arTab['OPTIONS'] as $key => $OPTION) {
                      $result['TABS'][$tabKey]['NAME'] = $arTab['TAB'];
                      $result['TABS'][$tabKey]['OPTIONS'][$key]['NAME'] = $OPTION['NAME'];
                      $result['TABS'][$tabKey]['OPTIONS'][$key]['CODE'] = $OPTION['CODE'];
                      $result['TABS'][$tabKey]['OPTIONS'][$key]['VALUE'] = Option::get("tq.tools", sprintf('tq_module_param_%s_%s',$tabKey,$key));
                    }
                  }
                }
              } else {
                foreach ($tabs as $tabCode) {
                  $result['TABS'][$tabCode]['NAME'] = $moduleSettings['TABS'][$tabCode]['TAB'];
                  if(count($fields)>0) {
                    foreach ($fields as $fieldCode) {
                      if($moduleSettings['TABS'][$tabCode]['OPTIONS'][$fieldCode]['CODE']){
                        $result['TABS'][$tabCode]['OPTIONS'][$fieldCode]['NAME'] = $moduleSettings['TABS'][$tabCode]['OPTIONS'][$fieldCode]['NAME'];
                        $result['TABS'][$tabCode]['OPTIONS'][$fieldCode]['CODE'] = $moduleSettings['TABS'][$tabCode]['OPTIONS'][$fieldCode]['CODE'];
                        $result['TABS'][$tabCode]['OPTIONS'][$fieldCode]['VALUE'] = Option::get("tq.tools", sprintf('tq_module_param_%s_%s',$tabCode,$fieldCode));
                      }
                    }
                  } else {
                    foreach ($moduleSettings['TABS'][$tabCode]['OPTIONS'] as $key => $OPTION) {
                      $result['TABS'][$tabCode]['OPTIONS'][$key]['NAME'] = $OPTION['NAME'];
                      $result['TABS'][$tabCode]['OPTIONS'][$key]['CODE'] = $OPTION['CODE'];
                      $result['TABS'][$tabCode]['OPTIONS'][$key]['VALUE'] = Option::get("tq.tools", sprintf('tq_module_param_%s_%s',$tabCode,$key));
                    }
                  }
                }
              }
          }
          $this->arResult = $result;
    }
}
