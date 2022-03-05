<?php

if (! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    Bitrix\Main\Engine\ActionFilter\Authentication,
    Bitrix\Main\Engine\ActionFilter,
    Bitrix\Main\Engine\Contract\Controllerable;

CJSCore::Init(["fx", "ajax"]);

class TqAuthorize extends \CBitrixComponent implements Controllerable
{
    private $componentPage = '';

    public function configureActions()
    {
        return [
            'Auth' => [ // Ajax-метод
                'prefilters' => [],
            ],
            'Register' => [ // Ajax-метод
                'prefilters' => [],
            ],
        ];
    }

    public function AuthAction($form)
    {
        $data = $this->getFormatedData($form);

        global $USER;
        if (! is_object($USER)) {
            $USER = new CUser;
        }
        $remember = 'Y';
        if (! $data['save']) {
            $remember = 'N';
        }
        $arAuthResult = $USER->Login($data['email'], $data['password'], $remember);
        if ($arAuthResult === true) {
            return true;
        } else {
            throw new Exception($arAuthResult['MESSAGE']);
        }
    }

    public function RegisterAction($form)
    {
        $data = $this->getFormatedData($form);

        if ($data['privacy'] == 'Y') {
            global $USER;
            if (! is_object($USER)) {
                $USER = new CUser;
            }
            $arRegisterResult = $USER->Register($data['email'], $data['name'], "", $data['password'],
                $data['confirm_password'], $data['email']);
            if ($arRegisterResult['TYPE'] == 'OK') {
                $arUserUpdate = $USER->Update($arRegisterResult['ID'], ['PERSONAL_PHONE' => $data['phone']]);
                return true;
            } else {
                throw new Exception($arRegisterResult['MESSAGE']);
            }
        } else {
            throw new Exception('Согласитесь с условиями обработки персональных данных');
        }
    }

    private function getFormatedData($data)
    {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$value['name']] = $value['value'];
        }
        return $result;
    }

    private function getPage()
    {
        global $USER;
        $request = \Bitrix\Main\Context::getCurrent()->getRequest();
        if ($USER->IsAuthorized()) {
            if ($request->get('reg') == 'success') {
                $page = 'reg';
            } else {
                $page = 'auth';
            }
            $this->componentPage = $page;
        }
    }

    public function executeComponent()
    {
        $this->getPage();
        $this->includeComponentTemplate($this->componentPage);
    }

}
