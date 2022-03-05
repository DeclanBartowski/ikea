<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
?>
<a href="<?= $USER->IsAuthorized() ? '/personal/' : '/auth/'; ?>" class="head-user mobile-hidden"><span
			class="ico-user"></span></a>
<a href="/favorites/" class="head-fav">
	<span class="ico-fav"></span>
    <? if ($_SESSION['FAVORITES']) { ?>
		<span class="head-basket_number"><?= count($_SESSION['FAVORITES']) ?></span>
    <? } ?>
</a>
<a href="/basket/" class="head-basket">
	<span class="ico-cart"></span>
    <? if ($arResult['NUM_PRODUCTS']) { ?>
		<span class="head-basket_number"><?= $arResult['NUM_PRODUCTS'] ?></span>
    <? } ?>
</a>

