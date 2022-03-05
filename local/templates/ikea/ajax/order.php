<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;

global $USER;
Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");
$notShowProps = array('postcode','place');
$request = Context::getCurrent()->getRequest();
$siteId = Context::getCurrent()->getSite();
$currencyCode = CurrencyManager::getBaseCurrency();
$props = $_REQUEST;
$personType = !empty($props['payer'])?$props['payer']:1;
$db_props = CSaleOrderProps::GetList(array("SORT" => "ASC"),array("PERSON_TYPE_ID" => $personType),false,false,array());
while($prop = $db_props->GetNext()) {
        $properties[$prop['CODE']] = $prop;
}

$deliveryID = intval($_REQUEST['delivery']);
$paymentID = intval($_REQUEST['payment']);
$arResult['ERROR']="";
foreach ($properties as $key=> $property){
    if($property['REQUIED'] == 'Y' && empty($props[$property['CODE']])){
       $arResult['ERROR'].= 'Заполните поле "'.$property['NAME'].'" <br>';
    }
}

if(empty($deliveryID)) $arResult['ERROR'].= "Выберите Доставку <br>";
if(empty($paymentID)) $arResult['ERROR'].= "Выберите систему оплаты <br>";

if(!empty($arResult['ERROR'])){
    echo json_encode(array("STATUS"=>"ERROR","HTML"=>$arResult['ERROR']));
    die();
}


// Создаёт новый заказ
$order = Order::create($siteId, $USER->isAuthorized() ? $USER->GetID() : 1);
$order->setPersonTypeId(!empty($personType)?$personType:1);
//$order->setField('CURRENCY', $currencyCode);
// Создаём корзину с одним товаром
$basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
$order->setBasket($basket);
// Создаём одну отгрузку и устанавливаем способ доставки - "Без доставки" (он служебный)
$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem();
$service = Delivery\Services\Manager::getById($deliveryID);
$shipment->setFields(array(
    'DELIVERY_ID' => $service['ID'],
    'DELIVERY_NAME' => $service['NAME'],
));
$shipmentItemCollection = $shipment->getShipmentItemCollection();
// Создаём оплату со способом #1
$paymentCollection = $order->getPaymentCollection();
$payment = $paymentCollection->createItem();
$paySystemService = PaySystem\Manager::getObjectById($paymentID);
$arDeliv = CSaleDelivery::GetByID($deliveryID);
$deliveryPrice = $arDeliv['PRICE'];

$payment->setFields(array(
    'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
    'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
    'SUM' => $basket->getPrice()+$deliveryPrice
));

$shipment->setField("BASE_PRICE_DELIVERY", $deliveryPrice);
$shipment->setField("CUSTOM_PRICE_DELIVERY", "Y");


if ($prop['comment']) {
    $order->setField('USER_DESCRIPTION', $prop['comment']); // Устанавливаем поля комментария покупателя
}
$propertyCollection = $order->getPropertyCollection();
$propertyCollection->getPhone()->setValue($prop['phone']);
$propertyCollection->getPayerName()->setValue($prop['name']);
$propertyCollection->getUserEmail()->setValue($prop['email']);
foreach ($properties as $key=> $property){
    $propertyCollection->getItemByOrderPropertyId($property['ID'])->setValue($props[$key]);
}

$order->doFinalAction(true);
$result = $order->save();
$orderId = $order->getId();
if($result>0){
    $_SESSION['SALE_ORDER_ID'][] = $orderId;
    echo json_encode($orderId);
}