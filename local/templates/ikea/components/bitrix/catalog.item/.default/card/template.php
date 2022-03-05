<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */

if (in_array($item['ID'], $arParams['FAVORITES'])) {
    $fav_action = 'compfavdelete';
    $fav_act = ' is-active';
} else {
    $fav_action = 'compfav';
    $fav_act = '';
}
?>

<div class="product-item_img">
	<a href="<?= $item['DETAIL_PAGE_URL']; ?>">
        <? if ($item['PROPERTIES']['NEW']['VALUE'] == 'Y') { ?>
			<span class="product-item_label new">Новинка</span>
        <? } ?>
        <? if ($item['PROPERTIES']['BESTSELLER']['VALUE'] == 'Y') { ?>
			<span class="product-item_label hit">Бестселлер</span>
        <? } ?>
		<span class="product-item_img-tab">
			<? foreach ($item['GALLERY'] as $key => $arImage) { ?>
				<img data-src="<?= $arImage['BIG']; ?>"
				     alt="<?= $item['NAME']; ?>"<? if ($key == 0) { ?> class="active"<? } ?>>
            <? } ?>
		</span>
	</a>
	<span data-add="FAVORITES"
	      data-id="<?= $item['ID']; ?>"
	      data-class="tools"
	      data-method="<?= $fav_action; ?>"
	      class="product-item_fav<?= $fav_act; ?>">
			<span class="ico-fav"></span>
			<span class="ico-fav-2"></span>
	</span>
</div>

<div class="product-item_desc">
    <? if ($item['CATALOG_QUANTITY'] > 0) { ?>
        <? if ($item['CATALOG_QUANTITY'] < 10) { ?>
			<span class="product-item_stock few">Осталось мало товара</span>
        <? } else { ?>
			<span class="product-item_stock">В наличии</span>
        <? } ?>
    <? } else { ?>
		<span class="product-item_stock ended">Товар закончился</span>
    <? } ?>
	<span class="product-item_title">
			<a href="<?= $item['DETAIL_PAGE_URL']; ?>">
				<?= $item['NAME']; ?>
			</a>
		</span>
	<p><?= $item['PREVIEW_TEXT']; ?></p>
    <? if ($item['CATALOG_QUANTITY'] > 0 && $item['CAN_BUY'] == 'Y') { ?>
		<span class="product-item_price"><?= $item['MIN_PRICE']['PRINT_DISCOUNT_VALUE_NOVAT']; ?></span>
    <? } else { ?>
		<span class="product-item_price">от <?= $item['MIN_PRICE']['PRINT_DISCOUNT_VALUE_NOVAT']; ?></span>
    <? } ?>
	<a href="javascript:void(0)"
	   data-class="basket"
	   data-method="add2basket"
	   data-id="<?= $item['ID']; ?>"
	   class="product-item_btn ico-cart">
		<span class="plus-icon">+</span>
		<span class="ico-check"></span>
	</a>
	<div class="product-item_footer">
		<ul class="product-item_photo">
            <? foreach ($item['GALLERY'] as $key => $arImage) { ?>
				<li<? if ($key == 0) { ?> class="active"<? } ?>>
					<img data-src="<?= $arImage['SMALL']; ?>" alt="<?= $item['NAME']; ?>">
				</li>
            <? } ?>
		</ul>
        <? if ($item['IMAGE_COUNT'] > 0) { ?>
			<a href="<?= $item['DETAIL_PAGE_URL']; ?>" class="all_product-photo">+<?= $item['IMAGE_COUNT']; ?></a>
        <? } ?>
	</div>
</div>
