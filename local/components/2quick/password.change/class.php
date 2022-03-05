<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    Bitrix\Main\Engine\ActionFilter\Authentication,
    Bitrix\Main\Engine\ActionFilter,
    Bitrix\Main\Engine\Contract\Controllerable;

CJSCore::Init(["fx", "ajax"]);

class TqChangePassword extends \CBitrixComponent implements Controllerable
{
    private $componentPage = '';

    public function configureActions()
    {
        return [
            'Change' => [ // Ajax-метод
                'prefilters' => [],
            ],
        ];
    }

    public function ChangeAction($form)
    {
        $data = $this->getFormatedData($form);
        if (empty($data['PASSWORD']) || empty($data['CONFIRM_PASSWORD']) || $data['PASSWORD'] == ' ' || $data['CONFIRM_PASSWORD'] == ' ') {
            throw new Exception('Введите пароль и его подтверждение');
        }
        if ($data['PASSWORD'] == $data['CONFIRM_PASSWORD'] && !empty($data['PASSWORD']) && !empty($data['CONFIRM_PASSWORD'])) {
            global $USER;
            $UserId = $USER->GetID();
            $user = new \CUser;
            $arFields = Array(
                "PASSWORD" => $data['PASSWORD'],
                "CONFIRM_PASSWORD" => $data['CONFIRM_PASSWORD'],
            );
            $ID = $user->Update($UserId, $arFields);
            if (intval($ID) > 0) {
                return ['MESSAGE' => 'Пароль успешно обнавлен', 'STATUS' => 'SUCCSESS'];
            } else {
                throw new Exception($user->LAST_ERROR);
            }
        } else {
            throw new Exception('Пароли не совпадают');
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
            if ($request->get('change') == 'success') {
                $this->componentPage = 'change';
            }
        }
    }

    public function executeComponent()
    {
        $this->getPage();
        $this->includeComponentTemplate($this->componentPage);
    }

}
