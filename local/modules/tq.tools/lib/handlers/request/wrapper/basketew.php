<?

namespace TQ\Tools\Handlers\Request\Wrapper;

use TQ\Tools\Handlers\Request\EntityWrapper;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Sale;
use Bitrix\Main\SystemException;
use Bitrix\Main\Web\Json;
use \Bitrix\Iblock\SectionTable;
use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;

\CModule::IncludeModule('iblock');
\CModule::IncludeModule("sale");
\CModule::IncludeModule("catalog");


class BasketEW extends EntityWrapper
{

    private $data;
    private $result;

    public function __construct($data)
    {
        $this->data = $data;

        parent::__construct($this->data);
        parent::checkRequestMethod('post');
    }

    private static function checkProductQuantity($productID)
    {
        $select = Array('ID', 'IBLOCK_ID', 'CATALOG_QUANTITY');
        $filter = Array('ID' => $productID, 'ACTIVE_DATE' => 'Y', 'ACTIVE' => 'Y');
        $res = \CIBlockElement::GetList(Array(), $filter, false, Array("nPageSize" => 1), $select);
        if ($fields = $res->Fetch()) {
            return $fields['CATALOG_QUANTITY'];
        }
    }

    private static function addCostumeOutOfStockItem($id, $quantity)
    {
        $properties = [
            [
                'NAME' => 'OUT_OF_STOCK',
                'CODE' => 'IS_OUT_OF_STOCKS',
                'VALUE' => 'Y',
                'SORT' => 100,
            ]
        ];

        $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());

        if ($item = $basket->getExistsItem('catalog', $id, $properties)) {
            $item->setField('QUANTITY', /*$item->getQuantity() + $quantity*/ $quantity);
        } else {
            $item = $basket->createItem('catalog', $id);
            $item->setFields(array(
                'QUANTITY' => $quantity,
                'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                'LID' => \Bitrix\Main\Context::getCurrent()->getSite(),
                'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                'PRICE' => 0,
                'CUSTOM_PRICE' => 'Y',
            ));
        }
        $basket->save();
        $basketPropertyCollection = $item->getPropertyCollection();
        $basketPropertyCollection->setProperty($properties);
        $basketPropertyCollection->save();
    }

    private static function addProduct2Basket($id, $quantity)
    {
        $catalogQuantity = self::checkProductQuantity($id);
        if (empty($quantity)) {
            $quantity = 1;
        }

        $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());

        if ($item = $basket->getExistsItem('catalog', $id)) {

            if ($catalogQuantity >= $quantity/* + $item->getQuantity()*/) {
                $item->setField('QUANTITY', /*$item->getQuantity() + $quantity*/ $quantity);
            } else {

                $item->setField('QUANTITY', $catalogQuantity);
                $basket->save();
                self::addCostumeOutOfStockItem($id, $quantity);
            }

        } else {
            if ($catalogQuantity >= $quantity) {
                $item = $basket->createItem('catalog', $id);
                $item->setFields(array(
                    'QUANTITY' => $quantity,
                    'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                    'LID' => \Bitrix\Main\Context::getCurrent()->getSite(),
                    'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                ));
                $basket->save();
            } else {

                if ($catalogQuantity > 0) {
                    $item = $basket->createItem('catalog', $id);
                    $item->setFields(array(
                        'QUANTITY' => $catalogQuantity,
                        'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                        'LID' => \Bitrix\Main\Context::getCurrent()->getSite(),
                        'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                    ));
                    $basket->save();
                }
                self::addCostumeOutOfStockItem($id, $quantity - $catalogQuantity);
            }
        }
    }

    public static function add2basket($id = 0, $quantity = 1, $properties = [])
    {
        self::addProduct2Basket($id, $quantity);
        return ['message' => 'Товар добавлен в корзину!'];
    }

    public static function update($id = 0, $quantity = 1, $properties = [])
    {
        //$quantity = 1;
        $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());
        $basketItem = $basket->getItemById($id);
        $basketPropertyCollection = $basketItem->getPropertyCollection();
        $basketItemProps = $basketPropertyCollection->getPropertyValues();

        $item = \CSaleBasket::GetByID($id);
        if ($basketItemProps['IS_OUT_OF_STOCKS']['VALUE'] != 'Y') {
            $catalogQuantity = self::checkProductQuantity($item['PRODUCT_ID']);
            if ($quantity > $catalogQuantity) {
                $quantity = $catalogQuantity;
            }
        }
        $arFields = array(
            "QUANTITY" => intval($quantity),
        );
        $result = \CSaleBasket::Update(intval($id), $arFields);
        if ($result) {
            return $result;
        } else {
            return 'При обновлении товара возникла ошиибка';
        }
    }

    public function delete($id)
    {
        $result = \CSaleBasket::Delete(intval($id));
        return $result;
    }

    public function setCoupon($coupon)
    {
        \Bitrix\Sale\DiscountCouponsManager::clear(true);
        Sale\DiscountCouponsManager::add($coupon);
        return true;
    }

    public function clearCoupon()
    {
        \Bitrix\Sale\DiscountCouponsManager::clear(true);
        return true;
    }

    private function clearBasket()
    {
        return \CSaleBasket::DeleteAll(\CSaleBasket::GetBasketUserID());
    }

    public function get()
    {

        switch ($this->data['method']) {
            case 'add2basket':
                if (is_array($this->data['items'])) {
                    foreach ($this->data['items'] as $item) {
                        $result = $this->add2basket($item['id'], $item['quantity'], $item['properties']);
                    }
                } else {
                    $result = $this->add2basket($this->data['id'], $this->data['quantity']);
                }
                break;
            case 'delete':
                $result = $this->data['id'];
                $this->delete($this->data['id']);
                break;
            case 'update_all':
                if ($this->data['items']) {
                    foreach ($this->data['items'] as $item) {
                        $this->update($item['id'], $item['quantity']);
                    }
                    $result = true;
                }
                break;
            case 'update':
                $result = $this->update($this->data['id'], $this->data['quantity'], $this->data['properties']);
                break;
            case 'set_coupon':
                $this->setCoupon($this->data['coupon']);
                break;
            case 'clear_coupon':
                $this->clearCoupon($this->data['coupon']);
                break;
            case 'clear':
                $result = $this->clearBasket();
                break;
        }

        return $result;
    }
}


