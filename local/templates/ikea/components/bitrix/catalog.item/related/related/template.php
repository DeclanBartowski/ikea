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
?>
<div class="related-product_item" id="<?=$areaId?>">
    <div class="related-product_item-img">
        <a href="<?=$item['DETAIL_PAGE_URL']?>">
            <?if($item['PREVIEW_PICTURE']){?>
                <img data-src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="alt">
            <?}?>
        </a>
    </div>
    <div class="related-product_item-desc">
        <span class="product-item_title"><a href=""><?=$item['NAME']?></a></span>
        <p><?=$item['PREVIEW_TEXT']?></p>
        <span class="product-item_price"><?=$price['PRINT_PRICE']?></span>
    </div>
</div>