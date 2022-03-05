<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<? if (!empty($arResult)): ?>
	<ul class="cart-fav_menu">
        <?
        foreach ($arResult as $arItem):
            if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) {
                continue;
            }
            ?>
			<li<? if ($arItem["SELECTED"]) echo ' class="active"'?>>
				<a href="<?= $arItem["LINK"] ?>">
                    <? if (!empty($arItem['PARAMS']['ICON'])) {
                        ?>
						<span class="<?= $arItem['PARAMS']['ICON']; ?>"></span>
                    <? } ?>
                    <?= $arItem["TEXT"] ?>
				</a>
			</li>
        <? endforeach ?>
	</ul>
<? endif ?>
