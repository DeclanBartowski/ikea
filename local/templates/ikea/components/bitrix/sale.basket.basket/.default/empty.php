<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

?>
<div class="cart-section_content">
	<div class="row">
		<div class="col-xl-3">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "favorites",
                Array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(0=>"",),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "left",
                    "USE_EXT" => "N"
                )
            );?>
		</div>
		<div class="col-lg-6">
			<div class="cart-empty_box">
				<span class="cart-empty_box-icon">
					<img alt="alt" src="<?= SITE_TEMPLATE_PATH ?>/img/icons/cart-icon.svg">
				</span>
				<div class="section-title">Ваша корзина пуста!</div>
				<p>Перейдите в каталог, у нас много интересного </p>
				<a href="<?= $arParams['EMPTY_BASKET_HINT_PATH']; ?>" class="main-btn main-btn_mod">
					Перейти в каталог
				</a>
			</div>
		</div>
	</div>
</div>
