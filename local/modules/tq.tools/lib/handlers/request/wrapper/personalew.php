<?php
	/**
	 * Created by PhpStorm.
	 * User: 2qucick
	 * Date: 04.01.2018
	 * Time: 10:05
	 */

	namespace TQ\Tools\Handlers\Request\Wrapper;

	use TQ\Tools\Handlers\Request\EntityWrapper, \Bitrix\Main\Loader, \Bitrix\Main\Mail\Event, \Bitrix\Main\Security\Password;

	/**
	 * Class PersonalEW
	 * @package TQ\Tools\Handlers\Request\Wrapper
	 */
	class PersonalEW extends EntityWrapper
	{
		/**
		 * @var
		 */
		private $data;

		/**
		 * PersonalEW constructor.
		 *
		 * @param $data
		 *
		 * @throws \Exception
		 */
		public function __construct($data)
		{
			$this->data = $data;

			parent::__construct($this->data);
			parent::checkAuthorization();
			parent::checkRequestMethod('post');

		}

		/**
		 * @param $old_password
		 *
		 * @return bool
		 */
		private function isUserPassword($old_password)
		{
			$userData = $this->getUserData();
			$result = Password::equals($userData['PASSWORD'], $old_password);
			return ($result);
		}

		/**
		 * @return array
		 */
		private function getUserData()
		{
			global $USER;
			$rsUser = $USER->GetByID($USER->GetID());
			$userData = $rsUser->Fetch();
			return $userData;
		}

		/**
		 * @param $data
		 *
		 * @return array
		 */
		private function userInfoChange($data)
		{
			foreach ($data as $item) {
				$arPass[$item['name']] = htmlentities($item['value']);
			}
			$userData = $this->getUserData();
			$isUserPassword = $this->isUserPassword($arPass['OLD_PASSWORD']);
			if ($isUserPassword) {
				$user = new \CUser;
				$arFields = ["PASSWORD" => $arPass['NEW_PASSWORD'], "CONFIRM_PASSWORD" => $arPass['NEW_PASSWORD'],'NAME'=>$arPass['NAME'],'EMAIL'=>$arPass['EMAIL'],'LOGIN'=>$arPass['EMAIL'],'PERSONAL_PHONE'=>$arPass['PERSONAL_PHONE']];
				$ID = $user->Update($userData['ID'], $arFields);
				if (intval($ID) > 0) {
					$result = ['status' => 'success', 'msg' => 'Информация обновлена'];
				} else {
					$result = ['status' => 'error', 'msg' => $user->LAST_ERROR];
				}
			} else {
				$result = ['status' => 'error', 'msg' => 'Старный пароль введен неверно!'];
			}
			return $result;
		}

		/**
		 * @param $data
		 *
		 * @return array|int|mixed
		 * @throws \Bitrix\Main\LoaderException
		 */
		private function togleSubscribe($data)
		{
			$userData = $this->getUserData();
			Loader::includeModule('subscribe');
			$subscr = new \CSubscription;
			$subscription = $subscr->GetList([], ['USER_ID' => $userData['ID']], ['nPageSize' => 1])->fetch();

			if ($data == 'sub') {
				if (!$subscription) {
					$result = $subscr->Add(['SEND_CONFIRM' => 'N', 'CONFIRMED' => 'Y', 'EMAIL' => $userData['EMAIL'], 'ACTIVE' => 'Y', 'USER_ID' => $userData['ID']]);
				} else {
					$result = $subscr->Update($subscription['ID'], ['ACTIVE' => 'Y']);
				}
				$msg = 'Вы успешно подписались на рассылку!';
			} else {
				$result = $subscr->Update($subscription['ID'], ['ACTIVE' => 'N']);
				$msg = 'Вы успешно отписались от рассылки!';
			}
			if (!$result) {
				$result = ['status' => 'error', 'msg' => 'В процессе оформления подписки, возникла техначеская ошибка<br>Попробуйте подписаться позже или обратитесь к администрации сайта!'];
			} else {
				$result = ['status' => 'success', 'msg' => $msg];
			}
			return $result;
		}

		/**
		 * @return array
		 */
		public function get()
		{

			switch ($this->data['action']) {
				case 'userInfoChange':
					$result = $this->userInfoChange($this->data['params']);
					break;
				case 'togleSubscribe':
					$result = $this->togleSubscribe($this->data['params']);
					break;
			}
			return $result;
		}
	}