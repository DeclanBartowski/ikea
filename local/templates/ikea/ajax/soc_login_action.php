<?
	    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	    
		/**
		*	Для работы модуля:
		*	Вставьте содержимое файла soc_login.php в место где должны появиться соц сети
		* 	Создайте свойство UF_ULOGIN у пользователей		
		**/		
		
		$s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
		
		$user = json_decode($s, true);
		
		

		//$user['network'] - соц. сеть, через которую авторизовался пользователь
		//$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
		//$user['first_name'] - имя пользователя
		//$user['last_name'] - фамилия пользователя
		
		// получаем данные о пользователе с сервера uLogin
		if (!isset($user['identity'])) {
			die('Ошибка: ' . $uloginUserInfo->error_message);
		}
		
		if (isset($user['first_name']) && $user['first_name']) {
			$firstname = $user['first_name'];
		} else {
			$firstname = '';
		}
		
		if (isset($user['last_name']) && $user['last_name']) {			
			$lastname = $user['last_name'];
		} else {
			$lastname = '';
		}
		
		if (isset($user['email']) && $user['email']) {
			$email = $user['email'];
		} else {
			$email = '';
		}
		
		if (isset($user['photo_big']) && $user['photo_big']) {
			$img = file_get_contents($user['photo_big']);
			$tmp_name = $_SERVER['DOCUMENT_ROOT'].'/cache/'.date('dmyhis').'.jpg';
			$f = fopen($tmp_name,'w+');
			fwrite($f, $img);
			fclose($f);
			$avatar = CFile::MakeFileArray($tmp_name);
		} else {
			$avatar = '';
		}
		/*echo '<pre>'.print_r($avatar,1).'</pre>';
		echo '<pre>'.print_r($user,1).'</pre>';die;	*/
	//	$rsUser = CUser::GetList(($by="ID"), ($order="desc"), array("UF_ULOGIN"=>'aaa'));
	//	$resUser = $rsUser->Fetch();
	//	print_r($resUser);

		
		
         //       echo $user['last_name'];
		$check_id = check_identity($user['identity'],$user['email']);
		
		if (!$check_id) {
			// регистрируем	
			$pass = generate_password(10);
			global $USER;
			if(!is_object($USER))
  				$USER = new CUser;
			//Если используется CAPTCHA при регистрации
			$use_capthca = false;
			if (COption::GetOptionString("main","captcha_registration") == 'Y'){
				COption::SetOptionString("main","captcha_registration","N");	
				$use_capthca = true;
			}
			//Если используется подтверждение E-mail при регистрации
			$use_confirm = false;
			if (COption::GetOptionString("main","new_user_registration_email_confirmation") == 'Y'){
				COption::SetOptionString("main","new_user_registration_email_confirmation","N");	
				$use_confirm = true;
			}			
			$res = $USER->Register(htmlspecialcharsbx($email), htmlspecialcharsbx($firstname), htmlspecialcharsbx($lastname), $pass, $pass, htmlspecialcharsbx($email));
	 		$ID = $USER->GetID();				
			
			//Возращаем обратно использование CAPTCHA если она использовалась
			if ($use_capthca)
				COption::SetOptionString("main","captcha_registration","Y");
			//Возращаем обратно использование подтверждение E-mail если она использовалась
			if ($use_confirm)
				COption::SetOptionString("main","new_user_registration_email_confirmation","Y");

			if ($ID){
				//Записываем Identify для нового пользователя
				$fields = array(
				  "UF_ULOGIN" => htmlspecialcharsbx($user['identity'])
				);
				if (is_array($avatar))
					$fields['PERSONAL_PHOTO'] = $avatar;
				
				$USER->Update($ID, $fields);			
					
				$USER->Authorize($ID,true);
			}			
		} else {
			// авторизация
			
			$USER->Authorize($check_id,true);
		}
		
		//Редиректим на ту страницу где был вызван модуль
		 
		if (isset($_SESSION['ulogin_redirect'])) {
			header('Location: '.$_SESSION['ulogin_redirect']);
		} else {
			header('Location: '.'http://'.$_SERVER['SERVER_NAME']);
		}
	
	//Поиск пользователя в базе
	function check_identity($identity,$email) {
		//В стандартном модуле авторизации uLogin проверяется идентификация по параметру $identify
		//но возможна ситуация, что пользователь уже зареган, тогда пытаемся найти его по e-mail и 
		//присваиваем ему $identify
		global $USER;
		if(!is_object($USER))
		  $USER = new CUser;
		  
		$rsUser  = CUser::GetList(($by="ID"), ($order="desc"), array("UF_ULOGIN"=>$identity));
		$resUser = $rsUser->Fetch();
		
		if ($resUser['ID']) {
			return $resUser['ID'];
		} elseif(isset($email) && $email) {
			$rsUser2  = CUser::GetList(($by="ID"), ($order="desc"), array("EMAIL"=>$email));
			$resUser2 = $rsUser2->Fetch();
			if ($resUser2['EMAIL']) {
				//Обновляем Edentify
				$user = new CUser;
				$user->Update($resUser2['ID'], array('UF_ULOGIN'=>$identity));				
				return $resUser2['ID'];
			}
			else
				return false;
		}
		else
		 return false;
	}
			
	function generate_password($number) {
		$arr = array('a','b','c','d','e','f',
						'g','h','i','j','k','l',
						'm','n','o','p','r','s',
						't','u','v','x','y','z',
						'A','B','C','D','E','F',
						'G','H','I','J','K','L',
						'M','N','O','P','R','S',
						'T','U','V','X','Y','Z',
						'1','2','3','4','5','6',
						'7','8','9','0');
		// Генерируем пароль
		$pass = "";
		for($i = 0; $i < $number; $i++) {
			// Вычисляем случайный индекс массива
			$index = rand(0, count($arr) - 1);
			$pass .= $arr[$index];
		}

		return $pass;
	}		
?>