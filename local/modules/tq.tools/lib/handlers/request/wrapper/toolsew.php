<?php
/**
 * Created by PhpStorm.
 * User: 2qucick
 * Date: 04.01.2018
 * Time: 10:05
 */

namespace TQ\Tools\Handlers\Request\Wrapper;

use TQ\Tools\Handlers\Request\EntityWrapper, \Bitrix\Main\Loader, \Bitrix\Main\Mail\Event;

class ToolsEW extends EntityWrapper
{
    private $datas;

    public function __construct($datas)
    {
        $this->datas = $datas;

        parent::__construct($this->datas);
        parent::checkRequestMethod('post');

    }

    private function clearFavorites()
    {
        unset($_SESSION['FAVORITES']);
        return 'Избранное было очищено';
    }

    private function createRequest($params = [])
    {

        foreach ($params as $param) {
            $validparams[$param['name']] = $param['value'];
        }

        if ($validparams['iblockID']) {
            Loader::includeModule('iblock');

            $el = new \CIBlockElement;

            foreach ($validparams as $fieldKey => $item) {
                $arFields[$fieldKey] = $item;
            }
            $arLoadProductArray = [
                "NAME" => sprintf('Заявка от %s', ConvertTimeStamp()),
                "IBLOCK_ID" => $validparams['iblockID'],
                "PROPERTY_VALUES" => $arFields,
                "PREVIEW_TEXT" => $arFields['PREVIEW_TEXT'],
            ];
            if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
                if ($validparams['messageID']) {
                    Event::send([
                        "EVENT_NAME" => "FEEDBACK_FORM",
                        "LID" => SITE_ID,
                        'MESSAGE_ID' => $validparams['messageID'],
                        "C_FIELDS" => $arFields
                    ]);
                }
                $result = ['status' => 'sucsess', 'msg' => 'Спасибо , ваше сообщение отправлено!'];
            } else {
                $result = ['status' => 'error', 'msg' => $el->LAST_ERROR];
            }
        } else {
            throw new \Exception("Не введен ID инфоблока в настройках компонента");
        }
        return $result;
    }

    public function get()
    {

        switch ($this->datas['method']) {
            case 'compfav':
                $_SESSION[$this->datas['add']][$this->datas['id']] = $this->datas['id'];
                $result = 'success';
                break;
            case 'compfavdelete':
                unset ($_SESSION[$this->datas['add']][$this->datas['id']]);
                $result = 'success';
                break;
            case 'formsubmit':
                $result = $this->createRequest($this->datas['params']);;
                break;
            case 'clear_favorites':
                $result = $this->clearFavorites();;
                break;
        }
        return $result;
    }
}