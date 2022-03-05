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
<div class="viewed-product_item-img">
	<a href="<?= $item['DETAIL_PAGE_URL']; ?>">
		<img data-src="<?=$item['PREVIEW_PICTURE']['SRC'];?>" alt="alt">
	</a>
</div>
<div class="viewed-product_item-desc">
	<span class="product-item_title"><a href="<?= $item['DETAIL_PAGE_URL']; ?>"><?= $item['NAME']; ?></a></span>
	<p><?=$item['PREVIEW_TEXT'];?></p>
    <? if ($item['CATALOG_QUANTITY'] > 0 && $item['CAN_BUY'] == 'Y') { ?>
		<span class="product-item_price"><?= $item['ITEM_PRICES'][0]['PRINT_PRICE']; ?></span>
    <? } else { ?>
		<span class="product-item_price">от <?= $item['ITEM_PRICES'][0]['PRINT_PRICE']; ?></span>
    <? } ?>
</div>
