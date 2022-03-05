<?
mb_internal_encoding('utf-8');
use Bitrix\Sale;

include_once __DIR__.'/include/functions.php';

include_once __DIR__.'/include/classes/CustomAgentClass.php';
include_once __DIR__.'/include/classes/MultiPriceSiteClass.php';
include_once __DIR__.'/include/classes/CustomEventHandlersClass.php';
MultiPriceSiteClass::onInit();

/* Добавляем новое кастомное свойство начало */
include_once __DIR__.'/include/custom_properties/CIBlockPropertyContentBlock.php';
AddEventHandler("iblock", "OnIBlockPropertyBuildList", array("CIBlockPropertyContentBlock", "GetUserTypeDescription"));
/* Добавляем новое кастомное свойство конец */

$GLOBALS["site_phone"] = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/include/info/'.SITE_ID.'/header_phone.php');

//тип свойства "Таблицы" для инфоблока
AddEventHandler('iblock', 'OnIBlockPropertyBuildList', array('IdListDoc', 'GetUserTypeDescription')); //построение списка свойств инфоблока
AddEventHandler('main', 'OnBeforeUserRegister', "OnBeforeUserRegisterHandler");

AddEventHandler('sale', 'OnBeforeOrderUpdate', array("CustomEventHandlersClass", "OnBeforeOrderUpdate"));
AddEventHandler('sale', 'OnSaleCalculateOrder', array("CustomEventHandlersClass", "OnSaleCalculateOrder"));

AddEventHandler("main", "OnBeforeUserAdd", Array("CustomEventHandlersClass", "OnBeforeUserAddHandler"));

AddEventHandler("main", "OnBeforeUserUpdate", array("CustomEventHandlersClass", "OnBeforeUserChangePassword"));
AddEventHandler("main", "OnBeforeUserUpdate", array("CustomEventHandlersClass", "OnBeforeUserGroupsUpdate"));
AddEventHandler("main", "OnBeforeUserChangePassword", array("CustomEventHandlersClass", "OnBeforeUserChangePassword"));

AddEventHandler("main", "OnBeforeUserSendPassword", array("CustomEventHandlersClass", "OnBeforeUserSendPassword"));

///rover.amocrm
///
AddEventHandler('rover.amocrm', 'beforeUnsortedAdd', array('\CustomEventHandlersClass', 'roverOnBeforeUnsortedAdd'));




/** При сохранении торгового предложения - парсим его объем и в случае если он есть - записываем его объем в товар,
 * для того чтобы в каталоге можно было фильтровать товары по объему
 * */
//AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("CustomEventHandlersClass", "ShareVolumeWithGoods") );
//AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("CustomEventHandlersClass", "ShareVolumeWithGoods") );

/** При сохранении товара - проверяем его свойство "Объемы предложений" и удаляем строки которые пренадлежат несуществующим предложениям,
 * */
//AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("CustomEventHandlersClass", "LookUpTovarVolumes") );
//AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("CustomEventHandlersClass", "LookUpTovarVolumes") );




AddEventHandler("main", "OnBeforeProlog", "OnBeforePrologHandler");

AddEventHandler("catalog", "OnGetOptimalPrice", array("MultiPriceSiteClass", "OnGetOptimalPriceHandler"));

AddEventHandler('sale', 'OnOrderNewSendEmail', array('CSendOrderPass', 'OnOrderNewSendEmailHandler'));

AddEventHandler('main', 'OnBeforeUserAdd', array('CSendOrderPass', 'OnBeforeUserAddHandler'));

AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");

AddEventHandler("main", "OnBeforeUserLogin", "OnBeforeUserLoginHandler");

AddEventHandler("main", "OnBeforeEventAdd", array("CustomEventHandlersClass", "OnBeforeEventAdd"));

// AddEventHandler("iblock", "OnBeforeIBlockElementAdd", array("AmoX3M", "OnBeforeIBlockElementAddHandler") );
// AddEventHandler('sale', 'OnOrderAdd', array("AmoX3M", "OnOrderAddHandler"));

AddEventHandler("sale", "OnBasketAdd", array("AmoElementAddAfter", "OnAfterIBlockElementAddHandler")); // кастом
AddEventHandler("sale", "OnBeforeBasketUpdateAfterCheck", array("AmoElementAddAfter", "OnAfterIBlockElementAddHandler")); // кастом
AddEventHandler("sale", "OnOrderAdd", array("AmoAfterUserRegister", "OnAfterIBlockElementAddHandler")); // кастом
AddEventHandler("main", "OnAfterUserAdd", array("AmoAfterUserRegister", "OnAfterIBlockElementAddHandler")); // кастом
// AddEventHandler("sale", "OnBasketUpdate", array("AmoElementAddAfter", "OnAfterIBlockElementAddHandler")); // кастом




class Curl
{
    public function WebHook($data) {
       

        $request = json_encode($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://google.com');
        // curl_setopt($curl, CURLOPT_URL, 'https://webhook.site/17ed4399-2199-4e54-916f-b127ccb29088');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 1100);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,  ['data' => $request]);
        $result = curl_exec($curl);
        curl_close($curl);
        curl_close ($ch);
        return $result;
    }
}

class AmoElementAddAfter
{
    function OnAfterIBlockElementAddHandler(&$ID,$arFields)
    {
        global $USER;
        $ID = $USER->GetID();
        $rsUser = CUser::GetByID( $ID );    // return array
        $arUser = $rsUser->Fetch();         //return bject
            
        $r = parse_url($_SERVER['HTTP_REFERER']);
        $url = $r['host'] . $r['path'];
    
        $data = [
            'request' => $_REQUEST,
            'server' => $_SERVER,
            'url' => $url,
            'files' => $_FILES,
            'arFields' => $arFields,

            // 'rs' => $rs
        ];

        $curl = new Curl;
        $req = $curl->WebHook($data);
        return $req;
    }
}

class AmoAfterUserRegister
{
    function OnAfterIBlockElementAddHandler($arFields)
    {
        $data = [
            'request' => $_REQUEST,
            'server' => $_SERVER,
            'files' => $_FILES,
            'arFields' => $arFields,
            // 'rs' => $rs
        ];

        $curl = new Curl;
        $req = $curl->WebHook($data);
        return $req;
    }
}




class AmoX3M {
    static $b_HandlerRun = true;
    static $b_Registration = true;
    static $arPost = [
            'phone' => null, // - телефон
            'email' => null, // - email
            'utm_source' => null, // - метка utm_source из GET параметров
            'utm_campaign' => null, // - метка utm_campaign из GET параметров
            'utm_medium' => null, // - метка utm_medium из GET параметров
            'utm_content' => null, // - метка utm_content из GET параметров
            'utm_term' => null, // - метка utm_term из GET параметров
            'cookies' => null, // - массив COOKIES, всех которые доступны
            'firstname' => null, // - имя
            'secondname' => null, // - фамилия
            'city' => null, // - город
            'address' => null, // - адрес
            'comment' => null, // - комментарий
            'order_items' => null, // - массив с позициями заказа из корзины (если это заказ из корзины конечно)
            'form_name' => null
        ];
    
    public function __construct(){
        
    }
    
    public function sendCurl(){
        self::$arPost['utm_source'] = $_COOKIE['utm_source'];
        self::$arPost['utm_campaign'] = $_COOKIE['utm_campaign'];
        self::$arPost['utm_medium'] = $_COOKIE['utm_medium'];
        self::$arPost['utm_content'] = $_COOKIE['utm_content'];
        self::$arPost['utm_term'] = $_COOKIE['utm_term'];
        self::$arPost['cookies'] = $_COOKIE;
        self::$arPost['page_url'] = $_SERVER['HTTP_REFERER'];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://mazdata.ru/thai-traditions/site-order");
        // curl_setopt($ch, CURLOPT_URL,"https://webhook.site/4cbf93fe-d988-45f1-9386-a1e1562b798a");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(self::$arPost));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close ($ch);
        return $result;
    }
    
    public function OnBeforeIBlockElementAddHandler(&$arFields){
        self::$arPost['form_name'] = $_REQUEST['FORM_NAME'];
        
        if($arFields['IBLOCK_ID'] == 53){
            self::$arPost['phone'] = $arFields['PROPERTY_VALUES']['PHONE'];
            $result = self::sendCurl();
        }
        if($arFields['IBLOCK_ID'] == 56){
            self::$arPost['email'] = $arFields['PROPERTY_VALUES']['EMAIL'];
            self::sendCurl();
        }
        if($arFields['IBLOCK_ID'] == 26){
            $arAddr = [
                ($arFields['PROPERTY_VALUES']['ADDRESS_1']) ? $arFields['PROPERTY_VALUES']['ADDRESS_1'] : null,
                ($arFields['PROPERTY_VALUES']['ADDRESS_3']) ? 'ул. '.$arFields['PROPERTY_VALUES']['ADDRESS_3'] : null,
                ($arFields['PROPERTY_VALUES']['ADDRESS_4']) ? 'дом '.$arFields['PROPERTY_VALUES']['ADDRESS_4'] : null,
                ($arFields['PROPERTY_VALUES']['ADDRESS_5']) ? 'корпус '.$arFields['PROPERTY_VALUES']['ADDRESS_5'] : null,
                ($arFields['PROPERTY_VALUES']['ADDRESS_6']) ? 'кв '.$arFields['PROPERTY_VALUES']['ADDRESS_6'] : null,
            ];
            
            self::$arPost['email'] = $arFields['PROPERTY_VALUES']['EMAIL'];
            self::$arPost['phone'] = $arFields['PROPERTY_VALUES']['PHONE'];
            self::$arPost['firstname'] = $arFields['PROPERTY_VALUES']['NAME'];
            self::$arPost['secondname'] = $arFields['PROPERTY_VALUES']['SURNAME'];
            self::$arPost['city'] = $arFields['PROPERTY_VALUES']['ADDRESS_2'];
            self::$arPost['address'] = implode(', ', $arAddr);
            self::$arPost['comment'] = $arFields['PROPERTY_VALUES']['COMMENT'];
            self::$arPost['order_items'] = $arFields['PROPERTY_VALUES']['AROMAS'];
            
            self::sendCurl();
        }
    }
    
    public function HiddenRegister($name, $email, $phone, $city, $group, $diplom, $requisites) {
        self::$arPost['form_name'] = (self::$b_Registration === true) ? 'registration' : 'opt';
        self::$arPost['phone'] = $phone;
        self::$arPost['email'] = $email;
        self::$arPost['firstname'] = $name;
        self::$arPost['city'] = $city;
        self::$arPost['diplom'] = $diplom;
        self::$arPost['requisites'] = $requisites;
        
        $result = self::sendCurl();
    }
    
    public function OnOrderAddHandler($ORDER_ID, &$arFields){
        CModule::IncludeModule("sale");
        $order = Sale\Order::load($ORDER_ID);
        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), $arFields['SITE_ID'])->getOrderableItems();
        
        $basketItems = $basket->getBasketItems();
        $arItems = [];
        foreach ($basketItems as $basketItem) {
            $arItems[] = [
                'name' => $basketItem->getField('NAME'),
                'price' => $basketItem->getPrice(),      // Цена за единицу
                'count' => $basketItem->getQuantity()   // Количество
            ];
        }
        
        $parameters = array();
        $parameters['filter']['=CODE'] = $arFields['ORDER_PROP'][59];
        $parameters['filter']['NAME.LANGUAGE_ID'] = "ru";

        $parameters['limit'] = 1;
        $parameters['select'] = array('LNAME' => 'NAME.NAME');

        $arLocation = Bitrix\Sale\Location\LocationTable::getList( $parameters )->fetch();
        
        self::$arPost['phone'] = $arFields['ORDER_PROP'][26];
        self::$arPost['email'] = $arFields['USER_EMAIL'];
        self::$arPost['firstname'] = $arFields['ORDER_PROP'][31];
        self::$arPost['secondname'] = $arFields['ORDER_PROP'][24];
        self::$arPost['city'] = $arLocation['LNAME'];
        self::$arPost['address'] = $arFields['ORDER_PROP'][32];
        self::$arPost['comment'] = $arFields['USER_DESCRIPTION'];
        self::$arPost['order_items'] = $arItems;

        self::$arPost = array_merge(self::$arPost, $arFields);
        self::$arPost['order_id'] = $arFields['ID'];
        
        $result = self::sendCurl();
    }
}


function OnBeforePrologHandler(){

	$arUserGroups = $GLOBALS["USER"]->GetUserGroupArray();

    $GLOBALS["SITE_CURRENT_CURRENCY"] = MultiPriceSiteClass::getSiteCurrency();
	if($GLOBALS['SITE_PRICE_PARAM_CODE'] == 'default'){
		///пользователи группы "Салоны"
		if( in_array( 9, $arUserGroups) ){
			MultiPriceSiteClass::getPriceParamCode('salons');
		}
		///пользователи группы "Корпоративные клиенты"
		elseif( in_array( 11, $arUserGroups) ){
			MultiPriceSiteClass::getPriceParamCode('corp');
		}
		///пользователи группы "Дистрибьюторы"
		elseif( in_array( 12, $arUserGroups) ){
			MultiPriceSiteClass::getPriceParamCode('dist');
		}
		///пользователи группы "Дистрибьюторы 18.10.2019"
		elseif( in_array( 13, $arUserGroups) ){
			MultiPriceSiteClass::getPriceParamCode('dist_other');
		}
		$GLOBALS["SITE_PRICE_PARAMS"] = MultiPriceSiteClass::getSiteParams();
	}
}

function OnBeforeUserRegisterHandler(&$args) {
	//if(SITE_ID == "s2") {
		$args['LOGIN'] = $args['EMAIL'];
		$args['CONFIRM_PASSWORD'] = $args['PASSWORD'];
		if($args["PERSONAL_CITY"]==""){
            $args["PERSONAL_CITY"]="Москва";
        }
	//}
}

class IdListDoc
{
    //шапка таблицы
    public function getHeaderTable(){
        $arHeaderTable = array();
        $arHeaderTable['tbl-1']['header'][] = '<table id="tbl-1" class="identific_doc"> <tr class="id_h"> <td>Название документа</td> <td>Код документа</td> <td>Дата создания</td> <td>Подразделение</td> <td>Действие регламентного документа распространяется на подразделения</td> </tr>'; //шапка таблицы 1
        $arHeaderTable['tbl-2']['header'][] = '<table id="tbl-2" class="identific_doc"> <tr class="id_h"> <td>Разработчик</td> <td>Должность</td> <td>Ф.И.О.</td> <td>Внутренний телефон</td> </tr>'; //шапка таблицы 2
        $arHeaderTable['tbl-3']['header'][] = '<table id="tbl-3" class="identific_doc"> <tr class="id_h"> <td>История документа</td> <td>Версия документа</td> <td>Дата последнего изменения версии</td> <td>Описание</td> </tr>'; //шапка таблицы 3
        $arHeaderTable['tbl-4']['header'][] = '<table id="tbl-4" class="identific_doc"> <tr class="id_h"> <td>№</td> <td>Подразделение</td> <td>Должность</td> </tr>'; //шапка таблицы 4

        $arHeaderTable['tbl-1']['cols'] = 5; //количество столбцов, 4 - по умолчанию
        $arHeaderTable['tbl-1']['textarea'][4] = 'Y';
        $arHeaderTable['tbl-4']['textarea'][1] = 'Y';
        $arHeaderTable['tbl-4']['textarea'][2] = 'Y';
        $arHeaderTable['tbl-4']['cols'] = 3;
        return $arHeaderTable;
    }

    function GetUserTypeDescription()
    {
        return array(
                "PROPERTY_TYPE" => "S",
                "USER_TYPE" => "custom_table",
                "DESCRIPTION" => 'Таблицы',
                "GetPublicViewHTML" => array("IdListDoc","GetPublicViewHTML"),
                "GetAdminListViewHTML" => array("IdListDoc","GetAdminListViewHTML"),
                "GetPropertyFieldHtml" => array("IdListDoc","GetPropertyFieldHtml"),
                "ConvertToDB" => array("IdListDoc","ConvertToDB"),
                "ConvertFromDB" => array("IdListDoc","ConvertFromDB"),
   );
    }

    //отображение таблиц на странице
    function GetPublicViewHTML($arProperty, $value, $strHTMLControlName)
    {
        return self::ShowTable(self::BuildTable($value['VALUE'], $arProperty['ID'])); //построение таблицы (построение структуры таблицы)
    }

    function GetAdminListViewHTML($arProperty, $value, $strHTMLControlName)
    {
        return;
    }

    //отображение формы редактирования в админке и в режиме правки
    function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        //print_r($value['VALUE']);
        $arTable = self::BuildTable($value['VALUE'], $arProperty['ID']); //получаем структуру таблицы
        CJSCore::Init( 'jquery' );
        ob_start();
   ?>
   <script type="text/javascript">
        //замена подстроки в строке
        function str_replace(search, replace, subject) {
          return subject.split(search).join(replace);
        }

        //добавление строки таблицы
        function addRow(prID){
            var rows_count = $("#edit_table_" + prID).find('tr').length;
            var cols_count = $("#edit_table_" + prID).find('tr').eq(0).find('td').length;
            var arRow = '<tr>';
            for (i = 0; i < cols_count; i++) {
                arRow = arRow + '<td><input type="text" name="PROP[' + prID + '][n0][' + rows_count + '][]" size="7"></td>';
            }
            arRow = arRow + '</tr>';
            $("#edit_table_" + prID).find('table tbody').append(arRow);
        }

        //удаляем последнюю строку таблицы
        function removeRow(prID){
            var rows_count = $("#edit_table_" + prID).find('tr').length;
            if(rows_count > 1) { //запрет на удаление последней строки
                $("#edit_table_" + prID).find('tr').eq(rows_count - 1).remove();
            }
        }

        function addColumn(prID) {
            var i = 0;
            $("#edit_table_" + prID).find('tr').each(function(){
                $(this).append('<td><input type="text" name="PROP[' + prID + '][n0][' + i + '][]" size="7"></td>');
                i++;
            });
        }

        function removeColumn(prID) {
            if($("#edit_table_" + prID).find('td').length != $("#edit_table_" + prID).find('tr').length) {
                $("#edit_table_" + prID).find('tr td:last-child').remove();
            }
        }
   </script>

   <div id="edit_table_<?=$arProperty['ID']?>">
        <?
            echo $arTable;
        ?>
      <p class="mngnt"><input type="button" value="Добавить строку" OnClick="addRow('<?=$arProperty['ID']?>'); return false;">  <input type="button" value="Удалить строку" OnClick="removeRow('<?=$arProperty['ID']?>'); return false;"></p>
      <p class="mngnt"><input type="button" value="Добавить столбец" OnClick="addColumn('<?=$arProperty['ID']?>'); return false;">  <input type="button" value="Удалить стобец" OnClick="removeColumn('<?=$arProperty['ID']?>'); return false;"></p>
      <?


       ?>
   </div>
   <?
   $return = ob_get_contents();
   ob_end_clean();
   return  $return;
    }

    //Сохранение в БД
    function ConvertToDB($arProperty, $value) {
        $return = false;
   if(is_array($value)&& array_key_exists("VALUE", $value))
   {
      $return = array("VALUE" => serialize($value["VALUE"]),);
      if(strlen(trim($value["DESCRIPTION"])) > 0)$return["DESCRIPTION"] = trim($value["DESCRIPTION"]);
   }
        return $return;
    }

    //Извлечение из БД
    function ConvertFromDB($arProperty, $value)
    {
   $return = false;
   if(!is_array($value["VALUE"]))
   {
      $return = array("VALUE" => unserialize($value["VALUE"]),);
      if($value["DESCRIPTION"])$return["DESCRIPTION"] = trim($value["DESCRIPTION"]);
   }
   return $return;
    }

    //построение структуры таблиц (шапка + содержание)
    function BuildTable($arBodyTable, $prID){
        $arTable .= '<table><tbody>';
        //$arBodyTable = '';
        if(is_array($arBodyTable)){ //содержание таблиц данные из БД
            foreach($arBodyTable as $r => $row){
                $arTable .= '<tr>';
                foreach($row as $c => $v) {
                    $arTable .= '<td><input type="text" name="PROP[' . $prID . '][n0][' . $r . '][]" value="' . $v . '" size="7"></td>';
                }
                $arTable .= '</tr>';
            }
        }
        else { //заполняем данных по дефолту
            $arTable .= '<tr><td><input type="text" name="PROP[' . $prID . '][n0][0][]" value="Время" size="7"></td>';
            $arTable .= '<td><input type="text" name="PROP[' . $prID . '][n0][0][]" value="Стандарт" size="7"></td>';
            $arTable .= '<td><input type="text" name="PROP[' . $prID . '][n0][0][]" value="Голд" size="7"></td></tr>';
            for($i = 1; $i < 3; $i++) {
                $arTable .= '<tr>';
                for($j = 0; $j < 3; $j++) {
                    $arTable .= '<td><input type="text" name="PRICE[' . $i .'][' . $j .']" value="" size="7"></td>';
                }
                $arTable .= '</tr>';
            }
        }
        $arTable .= '</tbody></table>';

        return $arTable;
    }

    //показа таблиц с содержанием
    function ShowTable($arTable){
      $TableList = '';
      foreach($arTable as $table_name => $ar_table){
   if(!empty($arTable[$table_name]['header'][0]) && is_array($arTable[$table_name]['body'])){ //если установлены шапка таблицы
     /*...
     ...
     ...*/
   }
      }
      return $TableList;
    }

    //показа таблиц с содержанием по ID элементу
    function ShowTableByEl($prID, $elID){
      $TableList = '';
	  $connection = Bitrix\Main\Application::getConnection();
      $qStruct = $connection->query("SELECT VALUE FROM `b_iblock_element_property` WHERE IBLOCK_PROPERTY_ID=".$prID." AND IBLOCK_ELEMENT_ID=".$elID." ");
      if($rStruct = $qStruct->fetch()){ if(!empty($rStruct['VALUE'])){ $TableList = self::ShowTable(self::BuildTable(unserialize($rStruct['VALUE'])));} }
      return $TableList;
    }

}


// #PASSWORD# в почтовом шаблоне выведет логин и пароль для пользователя.
class CSendOrderPass {

   private static $newUserLogin = false;
   private static $newUserPass = false;

   public static function OnBeforeUserAddHandler(&$arFields) {
		if(strlen($arFields["LOGIN"])<=0) {
			$arFields['LOGIN'] = $arFields['EMAIL'];
		}
		if(strlen($arFields["CONFIRM_PASSWORD"])<=0) {
			$arFields['CONFIRM_PASSWORD'] = $arFields['PASSWORD'];
		}
      self::$newUserLogin = $arFields['LOGIN'];
      self::$newUserPass = $arFields['PASSWORD'];
		/*$args['LOGIN'] = $args['EMAIL'];
		$args['CONFIRM_PASSWORD'] = $args['PASSWORD'];	  */
   }

   public static function OnOrderNewSendEmailHandler($ID, $eventName, $arFields) {
      if (self::$newUserPass === false) {
         $arFields['PASSWORD'] = '';
      } else {
         $arFields['PASSWORD'] = "\n".'Ваш логин: '.self::$newUserLogin;
         $arFields['PASSWORD'] .= "\n".'Ваш пароль: '.self::$newUserPass;
      }
   }
}

function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
    //Убираем из времени часы:минуты:секунды
    $arFields["ORDER_DATE"]=date('d.m.Y',strtotime($arFields["ORDER_DATE"]));
    $arFields["EMAILS"]="<a href='mailto:".$arFields["EMAILS"]."' style='color:#994098;font-weight:550;'>".$arFields["EMAILS"]."</a>";
	$db_props = CSaleOrderPropsValue::GetOrderProps($orderID);
	while ($arProps = $db_props->Fetch()) {
		switch($arProps["ORDER_PROPS_ID"]) {
			case 26:
				$arFields["ORDER_PHONE"] = $arProps["VALUE"];
				break;
			case 59:
				$city = CSaleLocation::GetByID($arProps['VALUE']);
                if(isset($city["CITY_NAME"]) && ($city["CITY_NAME"]!="")){
                    $arFields["ORDER_CITY"] = $city["CITY_NAME"];
                }else{
                    $arFields["ORDER_CITY"] = $city["REGION_NAME"];
                }
				break;
			case 31:
				$arFields["ORDER_NAME"] = $arProps["VALUE"];
				break;
			case 24:
				$arFields["ORDER_FAMILIA"] = $arProps["VALUE"];
				break;
			case 32:
				$arFields["ORDER_STREET"] = $arProps["VALUE"];
				break;
			case 33:
				$arFields["ORDER_BUILDING"] = $arProps["VALUE"];
				break;
			case 34:
				$arFields["ORDER_ADDITIONAL"] = $arProps["VALUE"];
				break;
			case 35:
				$arFields["ORDER_APP"] = $arProps["VALUE"];
				break;
			case 41:
				$arFields["ORDER_ZIP"] = $arProps["VALUE"];
				break;
		}
	}

	$arOrder = CSaleOrder::GetByID($orderID);
    if($arOrder["USER_DESCRIPTION"])
    {
	   $arFields["ORDER_DESC"] = '<b>Примечания по заказу:</b> ' . $arOrder["USER_DESCRIPTION"] . '. <br />';
    }
	if(is_numeric($arOrder['DELIVERY_ID']))
    {
        $arDelivery = CSaleDelivery::GetByID($arOrder['DELIVERY_ID']);
        $arFields["DELIVERY"] = $arDelivery['NAME'];
        if($arOrder['DELIVERY_ID']==2 || $arOrder['DELIVERY_ID']==5){
            $arFields["DELIVERY_INFO"] = '<b>Способ доставки:</b> самовывоз со склада в Москве по адресу г. Москва, м. Сокольники, Колодезный переулок, д. 2А. <br/>Режим работы склада: пн-пт, 9-18 часов.';
            $arFields["NEW_DELIVERY_TYPE"]='
<span style="display:block;font-weight:300;font-size: 16px;line-height:110%;letter-spacing: 0.1em;text-transform: uppercase;">Способ доставки</span>
<span style="display:block;font-weight:300;font-size: 30px;line-height: 130%;margin-bottom:15px;">Самовывоз со склада в Москве по адресу г. Москва, м. Сокольники, Колодезный переулок, д. 2А. <br/>Режим работы склада: пн-пт, 9-18 часов.</span>';
        }else{
            $arFields["NEW_DELIVERY_TYPE"]='
<span style="display:block;font-weight:300;font-size: 16px;line-height:110%;letter-spacing: 0.1em;text-transform: uppercase;">Адрес доставки</span>
<span style="display:block;font-weight:300;font-size: 30px;line-height: 130%;margin-bottom:15px;">' .
                $arFields["ORDER_ZIP"] . ' ' . $arFields["ORDER_CITY"] . ' ул. ' . $arFields["ORDER_STREET"] . ', ' .
                $arFields["ORDER_BUILDING"] . ($arFields["ORDER_APP"] ? (', ' . $arFields["ORDER_APP"]) : '') . '</span>
<span style="display:block;font-weight:300;font-size: 16px;line-height:110%;letter-spacing: 0.1em;text-transform: uppercase;">Способ доставки</span>
<span style="display:block;font-weight:300;font-size: 30px;line-height: 130%;margin-bottom:15px;">Доставка курьером</span>';
            $arFields["DELIVERY_INFO"] = '<b>Способ доставки:</b> доставка курьером со склада в Москве по адресу:' .
                $arFields["ORDER_ZIP"] . ' ' . $arFields["ORDER_CITY"] . ' ул. ' . $arFields["ORDER_STREET"] . ', ' .
                $arFields["ORDER_BUILDING"] . ($arFields["ORDER_APP"] ? (', ' . $arFields["ORDER_APP"]) : '') . '';
        }
    }
    else
    {
    	$arDelivSID = explode(':', $arOrder['DELIVERY_ID']);
    	$dbResult = CSaleDeliveryHandler::GetBySID($arDelivSID[0]);
        if($arDelivery = $dbResult->GetNext())
        {
            $arFields["DELIVERY"] = $arDelivery['NAME'];
        }

        if($arFields["DELIVERY"] == "Cамовывоз"){
            $arFields["DELIVERY_INFO"] = '<b>Способ доставки:</b> самовывоз со склада в Москве по адресу г. Москва, м. Сокольники, Колодезный переулок, д. 2А. <br/>Режим работы склада: пн-пт, 9-18 часов.';
            $arFields["NEW_DELIVERY_TYPE"]='
<span style="display:block;font-weight:300;font-size: 16px;line-height:110%;letter-spacing: 0.1em;text-transform: uppercase;">Способ доставки</span>
<span style="display:block;font-weight:300;font-size: 30px;line-height: 130%;margin-bottom:15px;">Самовывоз со склада в Москве по адресу г. Москва, м. Сокольники, Колодезный переулок, д. 2А. <br/>Режим работы склада: пн-пт, 9-18 часов.</span>';
        }else{
            $arFields["NEW_DELIVERY_TYPE"]='
<span style="display:block;font-weight:300;font-size: 16px;line-height:110%;letter-spacing: 0.1em;text-transform: uppercase;">Адрес доставки</span>
<span style="display:block;font-weight:300;font-size: 30px;line-height: 130%;margin-bottom:15px;">' .
                $arFields["ORDER_ZIP"] . ' ' . $arFields["ORDER_CITY"] . ' ул. ' . $arFields["ORDER_STREET"] . ', ' .
                $arFields["ORDER_BUILDING"] . ($arFields["ORDER_APP"] ? (', ' . $arFields["ORDER_APP"]) : '') . '</span>
<span style="display:block;font-weight:300;font-size: 16px;line-height:110%;letter-spacing: 0.1em;text-transform: uppercase;">Способ доставки</span>
<span style="display:block;font-weight:300;font-size: 30px;line-height: 130%;margin-bottom:15px;">Доставка курьером</span>';
            $arFields["DELIVERY_INFO"] = '<b>Способ доставки:</b> доставка курьером со склада в Москве по адресу:' .
                $arFields["ORDER_ZIP"] . ' ' . $arFields["ORDER_CITY"] . ' ул. ' . $arFields["ORDER_STREET"] . ', ' .
                $arFields["ORDER_BUILDING"] . ($arFields["ORDER_APP"] ? (', ' . $arFields["ORDER_APP"]) : '') . '';
        }
    }

	/* Добавляем информацию об оплате начало */
    $arrayForPayment = CSaleOrder::GetByID($orderID);
    switch($arrayForPayment["PAY_SYSTEM_ID"]) {
        case 20:
        case 5:
            if($arrayForPayment["PAYED"] == "Y"){
                $arFields["PAYMENT_INFO"] = "<b>Способ оплаты:</b> картой на сайте, оплата прошла успешно";
            }else{
                $arFields["PAYMENT_INFO"] = "<b>Способ оплаты:</b> картой на сайте, оплатить можно в <a href='https://thai-traditions.ru/personal/profile/'>личном кабинете</a>";
            }
            break;
        case 9:
        case 21:
            $arFields["PAYMENT_INFO"] = "<b>Способ оплаты:</b> счет для безналичной оплаты, ожидайте звонка менеджера";
            break;
        case 1:
        case 10:
            $arFields["PAYMENT_INFO"] = "<b>Способ оплаты:</b> наличными курьеру";
            break;
        default:
            break;
    }
	/* Добавляем информацию об оплате конец */

	$order_summary = '<table style="border: none; width: 100%; font-size: 12px; color:#6d6e71;">
			<tr style="background: #ececec; font-weight: bold;">
				<td></td><td style="padding: 10px 0; padding-left: 10px;">Продукт</td><td style="text-align: center; padding: 10px 0;">Кол-во</td><td style="padding: 10px 0;">Цена</td>
			</tr>';

			$arBasketItems = array();
			$dbBasketItems = CSaleBasket::GetList(
				array(
						"NAME" => "ASC",
						"ID" => "ASC"
					),
				array(
						"ORDER_ID" => $orderID
					),
				false,
				false
			);
			while ($arItems = $dbBasketItems->Fetch()) {
				$arBasketItems[] = CSaleBasket::GetByID($arItems["ID"]);
			}

			$ids = array();
			foreach ($arBasketItems as &$v)
			{
				$ids[$v['PRODUCT_ID']] = $v['PRODUCT_ID'];
			}
			$pics = array();
			$arFilter = Array("IBLOCK_ID"=>50, "ID"=>$ids);
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "DETAIL_PICTURE", "PREVIEW_PICTURE"));
			while($ob = $res->Fetch())
			{
				if($ob['DETAIL_PICTURE'] > 0)
					$pics[$ob['ID']] = $ob['DETAIL_PICTURE'];
				elseif($ob['PREVIEW_PICTURE'] > 0)
					$pics[$ob['ID']] = $ob['PREVIEW_PICTURE'];
			}
			foreach ($ids as $id)
			{
				$res = CIBlockElement::GetProperty(50, $id);
				$ids[$id] = array();
				while($res_arr = $res->Fetch()) {
					$ids[$id][$res_arr["CODE"]] = $res_arr["VALUE"];
				}
			}
			foreach ($arBasketItems as &$v)
			{
				$total += $v["PRICE"] * intval($v["QUANTITY"]);
				if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y")
				{
					$v["NAME"] = HTMLToTxt($v["NAME"]);
					$order_summary .= '<tr>';
					$file = CFile::ResizeImageGet($pics[$v['PRODUCT_ID']], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT);
					if($file['src'] == '')
						$file = array('src' => '/images/no-image_x50.png');

					$order_summary .= '<td style="padding: 10px 0;" class="picture">
<a href="' . $v["DETAIL_PAGE_URL"] . '">
	<img src="https://'.$_SERVER['HTTP_HOST'] . str_replace(array('+', ' '), '%20', $file['src']) . '" alt="' . $v["NAME"] . '" title="' . $v["NAME"] . '">
</a>
</td>
<td style="padding: 10px 0;" class="name">';

					if ('' != $v["DETAIL_PAGE_URL"])
					{
						$order_summary .= '<a style="color: #414042; font-weight: bold;" href="' . $v["DETAIL_PAGE_URL"] . '"><b>' . $v["NAME"] . '</b></a>';
					}
					else
					{
						$order_summary .= '<b>' . $v["NAME"] . '</b>';
					}
					$order_summary .= '<br />Артикул: ' . HTMLToTxt($ids[$v['PRODUCT_ID']]['CML2_ARTICLE']) . '<br/>Объём: ' . HTMLToTxt($ids[$v['PRODUCT_ID']]['OBYEM']);
					$order_summary .= '</td><td style="padding: 10px 0; text-align: center;">' . intval($v["QUANTITY"]) . '</td>';
					$order_summary .= '<td>' . intval($v["PRICE"]) . ' Р.<br/>';
					if(intval($v["QUANTITY"]) > 1) {
						$order_summary .= 'Итого:<br/>';
						$order_summary .= (intval($v["PRICE"]) * intval($v["QUANTITY"])) . ' Р.<br/>';
					}
					$order_summary .= '</td></tr>';
				}
			}
			if (isset($v))
				unset($v);
			$order_summary .= '<tr><td class="total" style="text-align: right;" colspan="4">Доставка: '.intval($arOrder['PRICE_DELIVERY']).' Р.</td></tr>';
			$order_summary .= '<tr><td class="total" style="font-weight: bold; text-align: right;" colspan="4">Итого: ' . ( intval($total) + intval($arOrder['PRICE_DELIVERY']) ) . ' Р.</td></tr><tr><td align="center" colspan="3"></td></tr></table>';
			$arFields["ORDER_SUMMARY"] = $order_summary;

    // Собираем таблицу для нового шаблона
    $priceNoDiscount = $total = $quantity = 0;
    $order_summary = '<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;padding:15px 60px; border-collapse:collapse;" width="480"><tbody>';
    foreach ($arBasketItems as &$v)
    {
        //Высчитываем стоимость без скидок
        $priceNoDiscount += $v["BASE_PRICE"] * intval($v["QUANTITY"]);
        //Высчитываем стоимость со скидками
        $total += $v["PRICE"] * intval($v["QUANTITY"]);
        //Высчитываем общее количество товаров
        $quantity += intval($v["QUANTITY"]);

        if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y")
        {
            $v["NAME"] = HTMLToTxt($v["NAME"]);
            $order_summary .= '<tr>';
            $file = CFile::ResizeImageGet($pics[$v['PRODUCT_ID']], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT);
            if($file['src'] == ''){
                $file = array('src' => '/images/no-image_x50.png');
            }
            $order_summary .= '
        <td style="padding-top:20px;padding-bottom:20px;border-top:1px solid #181A16;border-bottom:1px solid #181A16; ">
        <a href="'.$v["DETAIL_PAGE_URL"].'"  target="_blank">
            <img style="width: 60px;padding-right:30px;" src="https://'.$_SERVER['HTTP_HOST'] . str_replace(array('+', ' '), '%20', $file['src']) . '" alt="">
        </a>
    </td>';

            $order_summary .= '<td style="text-align: left;padding-top:20px;padding-bottom:20px;border-top:1px solid #181A16;border-bottom:1px solid #181A16;">
        <span style="display:block;font-weight:550;font-size: 20px;line-height: 120%;margin-bottom:5px;">' . $v["NAME"] . ' ('. intval($v["QUANTITY"]).' шт)</span>';//<span style="font-weight:300;">| ' . HTMLToTxt($ids[$v["PRODUCT_ID"]]["OBYEM"]).' ('.intval($v["QUANTITY"]).' шт)</span>

            $order_summary .= '<span style="display:block;font-size: 20px;line-height: 120%;">'.intval($v["PRICE"]).' <span style="font-family: \'Roboto\', sans-serif;">₽</span>';
            if(intval($v["PRICE"]) != intval($v["BASE_PRICE"])){
                $order_summary .= '<span style="font-size: 16px;color: #A5A5A5;text-decoration: line-through;padding-left:10px;">'.intval($v["BASE_PRICE"]).' <span style="font-family: \'Roboto\', sans-serif;">₽</span></span>';
            }
            $order_summary .= '</span></td></tr>';
        }
    }
    $order_summary .= '</tbody></table>';

// Собираем итого после таблицы
    $order_summary .= '<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;padding-bottom:15px;margin-top: 50px;font-size:24px;line-height:160%;" width="480">
    <tbody>
    <tr>
        <td style="text-align: left; width: 50%;">
            <span>'.$quantity.' товаров на сумму</span>
        </td>
        <td style="text-align: right;">
            <span>'.number_format($priceNoDiscount, 0, ',', ' ').'<span style="font-family: \'Roboto\', sans-serif;">₽</span></span>
        </td>
    </tr>';
    if($priceNoDiscount != $total){
        $order_summary .= '<tr style="font-weight:550">
        <td style="text-align: left; width: 50%;">
            <span>С учетом скидки</span>
        </td>
        <td style="text-align: right;">
            <span>'.number_format($total, 0, ',', ' ').'<span style="font-family: \'Roboto\', sans-serif;">₽</span></span>
        </td>
    </tr>';
    }
    $order_summary .= '<tr>
        <td style="text-align: left; width: 50%;">
            <span>Доставка</span>
        </td>
        <td style="text-align: right;">
            <span>'.intval($arOrder['PRICE_DELIVERY']).' <span style="font-family: \'Roboto\', sans-serif;">₽</span></span>
        </td>
    </tr>';

    $order_summary .= '<tr>
        <td colspan="2" style="text-align: center; padding-top: 30px; padding-bottom:30px;">
            <span style="display:block;font-weight: 300;font-size: 18px;line-height: 120%;">Итого</span>
            <span style="display:block;font-weight: 550;font-size: 48px;line-height: 120%;">' . number_format( (intval($total) + intval($arOrder['PRICE_DELIVERY'])), 0, ',', ' ' ) . ' <span style="font-family: \'Roboto\', sans-serif;">₽</span></span>
        </td>
    </tr>
    </tbody>
</table>';

    if (isset($v))
        unset($v);
    $arFields["ORDER_SUMMARY_NEW"]=$order_summary;
    $arFields["UTMSTAT_CLIENT_ID"]=isset($_COOKIE['utmstat_client_id']) ? $_COOKIE['utmstat_client_id'] : null;
			// Выведем даты всех заказов текущего пользователя, отсортированные по дате заказа и подсчитаем кол-во заказов
			$arFilter = Array(
			   "USER_ID" => $arOrder['USER_ID']);

			$db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
			$order_count = 0;
			while ($ar_sales = $db_sales->Fetch())
			{
                if($order_count < 5){
                    $arFields["USER_ORDERS"] .= $ar_sales["DATE_INSERT_FORMAT"] . '<br>';
                }
			   $order_count++;
			}
			$arFields["USER_ORDERS_COUNT"] = $order_count;
			
			//добавляем использованный промокод в письмо
			$couponList = \Bitrix\Sale\Internals\OrderCouponsTable::getList(array(
				'select' => array('COUPON'),
				'filter' => array('=ORDER_ID' => $orderID)
			));
			while ($coupon = $couponList->fetch())
			{
			   $arFields["USER_COUPON"] = $coupon['COUPON'];
			}			

}

//авторизация через почту
function OnBeforeUserLoginHandler(&$arFields){
	$login = trim($arFields["LOGIN"]);
	global $USER;
	$rsUsers = $USER->GetList(($by="email"), ($order="asc"), array('LOGIN' => $login));
	if(!$rsUsers->Fetch()){

		$filter = array('EMAIL' => $login);
		$rsUsers = $USER->GetList(($by="email"), ($order="asc"), $filter);
		if($arUser = $rsUsers->Fetch()){
			$login = $arUser['LOGIN'];
		}

		$arFields["LOGIN"] = $login;
	}

}

/* Меняем вхождение слова "Москва" во всех метатегах на "Казахстан" или "Беларусь" */
AddEventHandler("main", "OnEndBufferContent", "changeMoskowToKzBy");
function changeMoskowToKzBy(&$content) {
    if((SITE_ID == "s3" || SITE_ID == "s4")&&($curDir != "/contacts/")){
    $curDir = $GLOBALS['APPLICATION']->GetCurDir();
    $inCatalog = ( $_SERVER['REAL_FILE_PATH'] == '/catalog/index.php' ||
        preg_match('/^(\/catalog\/).*/', $curDir) );
        $padeji = array(
            "s3" => array(
                "в Беларуси",
                "Беларуси",
                "Беларусь",
                "Белорусский",
                "Белорусских",
                "Беларусь",
                "Беларуси",
                "Беларуси",
                "Беларусь",
                "Беларусью",
                "Беларуси",
            ),
            "s4" => array(
                "в Казахстане",
                "Казахстане",
                "Казахстан",
                "Казахский",
                "Казахских",
                "Казахстан",
                "Казахстана",
                "Казахстану",
                "Казахстан",
                "Казахстаном",
                "Казахстане",
            ),
            "original" => array(
                "в Москве",
                "г. Москве",
                "г. Москва",
                "Московский",
                "Московских",
                "Москва",
                "Москвы",
                "Москве",
                "Москву",
                "Москвой",
                "Москве",
            )
        );
        $newHead = $content;
        foreach ($padeji["original"] as $key => $item) {
            $newHead = preg_replace( '/'.$item.'/i', $padeji[SITE_ID][$key] , $newHead );
        }
        if($inCatalog){
            if (SITE_ID == "s3") {
                if(!preg_match('/в Беларуси<\/title>/i', $newHead)){
                    $newHead = str_replace('</title>',' в Беларуси</title>', $newHead);
                }
            }
            if (SITE_ID == "s4") {
                if(!preg_match('/в Казахстане<\/title>/i', $newHead)) {
                    $newHead = str_replace('</title>', ' в Казахстане</title>', $newHead);
                }
            }
        }
        $content = $newHead;
    }
}

/* Проверяем есть ли скидка на ТП товара, и если есть - ставим свойство "Скидка" активным, если нет ставим свойство неактивным */
//S1:30.04.2021 Свойство не работает, пока что отключаем обработчик
//AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "checkDiscount");
//AddEventHandler("iblock", "OnAfterIBlockElementAdd", "checkDiscount");


function checkDiscount(&$arParams){
    global $USER;
    if($arParams["IBLOCK_ID"] == 49){
        $discounts = 0;
        $res = CIBlockElement::GetList(
            array("sort" => "asc"),
            Array("IBLOCK_ID" => 50,"PROPERTY_CML2_LINK" => $arParams["ID"]),
            false, false
        );
        while ($ob = $res->GetNext()) {
            $arDiscounts = CCatalogDiscount::GetDiscountByProduct($ob["ID"],$USER->GetUserGroupArray(),"N",array(1,2,3,4,5,6,7),'s2');
            if(!empty($arDiscounts)){
                $discounts = true;
            }
        }
        if($discounts){
            CIBlockElement::SetPropertyValuesEx($arParams["ID"], false, array("DISCOUNT" => "6392"));
        }else{
            CIBlockElement::SetPropertyValuesEx($arParams["ID"], false, array("DISCOUNT" => ""));
        }

        $db_old_groups = CIBlockElement::GetElementGroups($arParams["ID"], true);
        $ar_new_groups = Array();
        while($ar_group = $db_old_groups->Fetch()){
            $ar_new_groups[] = $ar_group["ID"];
        }
        if(!in_array(632,$ar_new_groups)){
            $ar_new_groups[]=632;
            CIBlockElement::SetElementSection($arParams["ID"], $ar_new_groups );
        }
    }
}
/* Добавляем ограничение для служб доставок чтобы исключать группы пользователей из списка */
$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler(
    'sale',
    'onSaleDeliveryRestrictionsClassNamesBuildList',
    'myDeliveryRestrictions'
);
function myDeliveryRestrictions()
{
    return new \Bitrix\Main\EventResult(
        \Bitrix\Main\EventResult::SUCCESS,
        array(
            '\MyDeliveryRestriction' => '/bitrix/php_interface/include/deliveryRestrictions/unauthorized.php',
        )
    );
}

/* Пробуем сделать так чтобы ссылки на стили на сайте казахстана были относительны,а не абсолютные */
AddEventHandler("main", "OnEndBufferContent", "deleteKernelJs");
function deleteKernelJs(&$content) {
    if(SITE_ID=="s4"){
        $newHead = $content;
        $content = str_replace('thai-traditions.ru', 'thai-traditions.kz', $content);
        $content = $newHead;
    }
}

//S1:10.03.2021 Убираем распродажную поцизию если её нельзя купить и убираем нераспродажную позицию, если есть распродажная и её можно купить https://seotime.megaplan.ru/task/1070493/card/
AddEventHandler("search", "BeforeIndex", "SearchExclude");
//Возвращает айдишники всех торговых предложений тестеров
function getAllTesterElementIDs()
{
    CModule::IncludeModule('iblock');
    $elementIds = $tpIDs = array();
    $arFilter = Array(
        "IBLOCK_ID" => 49,
        "SECTION_ID" => 654,
        "INCLUDE_SUBSECTIONS" => "Y"
    );
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID"));
    while ($fields = $res->GetNext()) {
        $elementIds[] = $fields["ID"];
    }

    $arFilter = Array(
        "IBLOCK_ID" => 50,
        "PROPERTY_CML2_LINK" => $elementIds
    );
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "NAME"));
    while ($fields = $res->GetNext()) {
        $tpIDs[] = $fields["ID"];
    }
    return $tpIDs;
}
function SearchExclude($arFields){
    if($arFields["PARAM2"]=="50"){
        //Сразу удаляем из индекса если это тестер
        $tpIds = getAllTesterElementIDs();
        if(in_array($arFields["ITEM_ID"],$tpIds)){
            $arFields['BODY'] = '';
            $arFields['TITLE'] = '';
            $arFields['TAGS'] = '';
            return $arFields;
        }
        CModule::IncludeModule('iblock');
        $db_props = CIBlockElement::GetProperty($arFields["PARAM2"], $arFields["ITEM_ID"], array("sort" => "asc"), Array("CODE"=>"RASPRODAZHNAYA_POZITSIYA"));
        if($prop = $db_props->Fetch()){
            // Если распродажная проверяем доступна ли к покупке, если нет - удаляем из индекса
            if($prop["VALUE_ENUM"]=="Да"){
                $dbr = CIBlockElement::GetList(
                    array(),
                    array("IBLOCK_ID"=>$arFields["PARAM2"], "ID"=>$arFields["ITEM_ID"]),
                    false,
                    false,
                    array("ID", "SORT", "CATALOG_QUANTITY"));
                while ($elem = $dbr->Fetch())
                {
                    if($elem['CATALOG_QUANTITY']>0){
                        return $arFields;
                    }else{
                        $arFields['BODY'] = '';
                        $arFields['TITLE'] = '';
                        $arFields['TAGS'] = '';
                        return $arFields;
                    }

                }
                //Если нераспродажная, получаем артикул ( CML2_ARTICLE ) и ищем распродажную с таким же артикулом
            }elseif($prop["VALUE_ENUM"]=="Нет"){
                //Получаем артикул
                $db_props = CIBlockElement::GetProperty($arFields["PARAM2"], $arFields["ITEM_ID"], array("sort" => "asc"), Array("CODE"=>"CML2_ARTICLE"));
                if($prop = $db_props->Fetch()){
                    $articul = $prop["VALUE"];
                }
                //Ищем распродажный товарй
                $dbr = CIBlockElement::GetList(
                    array(),
                    array("IBLOCK_ID"=>$arFields["PARAM2"], "PROPERTY_CML2_ARTICLE"=>$articul,"PROPERTY_RASPRODAZHNAYA_POZITSIYA"=>6627),
                    false,
                    false,
                    array("ID", "SORT", "CATALOG_QUANTITY"));
                while ($elem = $dbr->Fetch())
                {
                    //Если есть распродажный товар и он доступен к покупке - убираем этот из индекса
                    if($elem['CATALOG_QUANTITY']>0){
                        $arFields['BODY'] = '';
                        $arFields['TITLE'] = '';
                        $arFields['TAGS'] = '';
                        return $arFields;
                    }else{
                        return $arFields;
                    }

                }
                return $arFields;
            }
        }
    }else{
        return $arFields;
    }
}

/** S1:17.03.2021 В корзину нельзя добавить тестеров:
 *  1) Каждого больше одной штуки
 *  2) Больше 10 штук из раздела "Уход за лицом"
 *  3) Больше 6 штук из раздела "Уход за телом"
 * */
AddEventHandler("sale", "OnBeforeBasketAdd", array("TesteryEvents", "onAdd") );
AddEventHandler("sale", "OnBeforeBasketUpdate", array("TesteryEvents", "basketUpdateItem") );
class TesteryEvents{
    static $uhodZaLitsomID = 656;
    static $uhodZaTelomID = 657;
    static $catalogIblockID = 49;
    static $productsIblockID = 50;

    //При добавлении товара
    public function onAdd(&$arFields){
        //Получаем айдишники всех тестеров
        $allUhodZaLitsomTpIds = self::getAllTPs(self::$uhodZaLitsomID);
        $allUhodZaTelomTpIds = self::getAllTPs(self::$uhodZaTelomID);
        $productId=$arFields["PRODUCT_ID"];

        //Если ID этого товара есть в одном из этих массивах - это тестер
        if(in_array($productId,$allUhodZaLitsomTpIds)||in_array($productId,$allUhodZaTelomTpIds)){
            //получаем корзину
            $litsoQuan=$teloQuan=0;
            $dbBasketItems = CSaleBasket::GetList(
                array(
                    "NAME" => "ASC",
                    "ID" => "ASC"
                ),
                array(
                    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                    "LID" => SITE_ID,
                    "ORDER_ID" => "NULL"
                ),
                false,
                false,
                array("ID", "PRODUCT_ID", "QUANTITY")
            );
            while ($arItems = $dbBasketItems->Fetch())
            {
                //Если этот тестер уже есть в корзине - отменяем, тестеры можно добавить только в количестве одной штуки
                if($productId==$arItems["PRODUCT_ID"]){
                    return array("ERROR"=>'В корзину нельзя добавить более 1 тестера каждого вида');
                }

                //Если этого тестера нет в корзине - считаем сколько в корзине тестеров каждого типа
                $itemID = $arItems["PRODUCT_ID"];
                if(in_array($itemID,$allUhodZaLitsomTpIds)){
                    $litsoQuan+=round($arItems["QUANTITY"]);
                }
                if(in_array($itemID,$allUhodZaTelomTpIds)){
                    $teloQuan+=round($arItems["QUANTITY"]);
                }
            }
            //Если тестер из раздела "Уход за лицом", (их можно максимум 10 штук), а количество тестеров уже 10, отменяем
            if(in_array($productId,$allUhodZaLitsomTpIds)&&($litsoQuan>=10)){
                return array("ERROR"=>'В корзину можно добавить только 10 тестеров из раздела "Уход за лицом"');
            }
            //Если тестер из раздела "Уход за телом", (их можно максимум 6 штук), а количество тестеров уже 10, отменяем
            if(in_array($productId,$allUhodZaTelomTpIds)&&($teloQuan>=6)){
                return array("ERROR"=>'В корзину можно добавить только 6 тестеров из раздела "Уход за телом"');
            }
        }
        return $arFields;
    }

    //При изменении товара в корзины
    public function basketUpdateItem($ID,&$arFields){
        if(empty($arFields)){
            return true;
        }
        $allUhodZaLitsomTpIds = self::getAllTPs(self::$uhodZaLitsomID);
        $allUhodZaTelomTpIds = self::getAllTPs(self::$uhodZaTelomID);
        $dbBasketItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
            ),
            false,
            false,
            array("ID", "PRODUCT_ID", "QUANTITY")
        );
        while ($arItems = $dbBasketItems->Fetch())
        {
            if($ID==$arItems["ID"]){
                $productId = $arItems['PRODUCT_ID'];
            }
        }

        //Если это тестер и пытаются увеличить количество
        if((in_array($productId,$allUhodZaLitsomTpIds)||in_array($productId,$allUhodZaTelomTpIds))&&$arFields["QUANTITY"]>1){
            $arFields["QUANTITY"]=1;
            return true;
        }
    }

    //Получает все ТП раздела
    public function getAllTPs($sectID){
        //Получаем все подразделы раздела
        $allSections = array($sectID);
        $allTovars=$allTps=array();
        $db_list = CIBlockSection::GetList(
            Array(),
            Array(
                'IBLOCK_ID' => self::$catalogIblockID,
                'SECTION_ID' => $sectID
            ),
            true,
            array("ID","IBLOCK_ID","IBLOCK_SECTION_ID",));
        while($result = $db_list->GetNext())
        {
            $allSections[]=$result["ID"];
        }
        //Получаем все товары этого раздела
        $res = CIBlockElement::GetList(
            Array(),
            Array(
                "IBLOCK_ID" => self::$catalogIblockID,
                "IBLOCK_SECTION_ID" => $allSections
            ),
            false,
            false,
            array("ID", "IBLOCK_ID")
        );
        while($ar_fields = $res->GetNext())
        {
            $allTovars[]=$ar_fields["ID"];
        }
        //Теперь получаем все ТП этих товаров
        $res = CCatalogSKU::getOffersList($allTovars);
        foreach ($res as $tovarTPs) {
            foreach ($tovarTPs as $TP) {
                $allTps[]=$TP["ID"];
            }

        }
        return $allTps;
    }
}

//убираем type="text/javascript" из системных скриптов для валидации
use Bitrix\Main\EventManager;
$handler = EventManager::getInstance()->addEventHandler(
"main",
"OnEndBufferContent",
array(
	"ClInit",
	"removeType"
)
);
class ClInit
{
	function removeType(&$content)
	{
		$content = static::replace_output($content);
	}

	static function replace_output($d)
	{
		return str_replace(' type=\'text/javascript\'', "", str_replace(' type="text/javascript"', "", $d));
	}
}