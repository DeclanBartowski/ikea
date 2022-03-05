<? if (!empty($arResult['ITEMS'])) { ?>
	<div class="checkout-title">Состав заказа</div>
	<table class="cart-table">
		<tr>
			<th colspan="2">Товар</th>
			<th>Артикул</th>
			<th>Скидка</th>
			<th>Цена</th>
		</tr>
        <? foreach ($arResult['ITEMS'] as $arItem) { ?>
			<tr>
				<td><span data-class="basket"
				          data-method="removeFromOrder"
				          data-id="<?=$arItem['ID'];?>" class="cart-item_delete ico-close"></span></td>
				<td>
					<div class="cart-item">
						<div class="cart-item_img">
							<a href="<?= $arItem['DETAIL_PAGE_URL']; ?>">
								<img data-src="<?= $arItem['PREVIEW_PICTURE']['src']; ?>" alt="<?= $arItem['NAME']; ?>">
							</a>
						</div>
						<div class="cart-item_desc">
                            <? if ($arItem['PROPS']['IS_OUT_OF_STOCKS']['VALUE'] == 'Y') { ?>
								<span class="cart-item_stock"><span class="ico-check"></span>В наличии</span>
                            <? } else { ?>
								<span class="cart-item_stock"><span class="ico-check"></span>Под заказ</span>
                            <? } ?>
							<span class="cart-item_title">
						    <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>">
							    <?= $arItem['NAME']; ?>
						    </a>
					    </span>
						</div>
					</div>
				</td>
				<td><span class="mobile-title">Артикул</span><?= $arItem['ARTNUMBER']; ?></td>
                <? if ($arItem['DISCOUNT_PRICE'] > 0) { ?>
					<td><span class="mobile-title">Скидка</span><?= CurrencyFormat($arItem['DISCOUNT_PRICE'],
                            $arItem['CURRENCY']); ?></td>
                <? } ?>
				<td><span class="mobile-title">Цена</span>
                    <?= CurrencyFormat($arItem['PRICE'], $arItem['CURRENCY']); ?> / <?= $arItem['MEASURE_NAME']; ?>
				</td>
			</tr>
        <? } ?>
	</table>
<? } ?>
