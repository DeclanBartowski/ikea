<?php

	namespace TQ\Tools;

	use Bitrix\Main\Loader, Bitrix\Main\Context, Bitrix\Sale\Basket as BXBasket, Bitrix\Sale\Fuser;

	class Basket
	{
		public static function getItemsInBasket()
		{
			Loader::IncludeModule('sale');
			$basket = BXBasket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite())->getOrderableItems();
			foreach ($basket as $basketItem) {
				$productId = $basketItem->getProductId();
				$basketItems[$basketItem->getId()] = $productId;
			}
			return $basketItems;
		}

		/**
		 * @return mixed
		 * @throws \Bitrix\Main\LoaderException
		 */
		public static function getItemsInBasketForCard()
		{
			Loader::IncludeModule('sale');
			$basket = BXBasket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite())->getOrderableItems();
			foreach ($basket as $basketItem) {
				$productId = $basketItem->getProductId();
				$basketItems[$productId] = ['BASKET_ID' => $basketItem->getId(), 'QUANTITY' => $basketItem->getQuantity()];
			}
			return $basketItems;
		}

		public static function getBasketItem($id)
		{
			Loader::IncludeModule('sale');
			$basket = BXBasket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite())->getOrderableItems();
			foreach ($basket as $basketItem) {
				$productId = $basketItem->getProductId();
				$basketItems[$productId] = $productId;
			}
			if (in_array($id, $basketItems)) {
				return ['ID' => $basketItem->getId(), 'QUANTITY' => $basketItem->getQuantity()];
			} else {
				return false;
			}
		}
	}