<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="search-section">
	<div class="container">
        <?include_once ($_SERVER['DOCUMENT_ROOT'].'/include/header.php')?>
		<form method="get" class="search-mod_form">
			<input type="text" class="search-mod_form-input" name="q" value="<?= $arResult["REQUEST"]["QUERY"] ?>"
			       placeholder="Поиск">
			<div class="wrapper-submit">
				<span class="ico-search"></span>
				<input type="submit" class="search-mod_form-submit" value="">
			</div>
		</form>
        <? if (isset($arResult["REQUEST"]["ORIGINAL_QUERY"])): ?>
			<div class="search-language-guess">
                <?
                echo GetMessage("CT_BSP_KEYBOARD_WARNING",
                    array("#query#" => '<a href="' . $arResult["ORIGINAL_QUERY_URL"] . '">' . $arResult["REQUEST"]["ORIGINAL_QUERY"] . '</a>')) ?>
			</div><br/><?
        endif; ?>
        <? if ($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false) { ?>
        <? } elseif ($arResult["ERROR_CODE"] != 0) { ?>
			<div class="search_no-result">
				<span class="search_large-icon ico-search"></span>
				<p class="text-upper">Сожалеем, но ничего не найдено.</p>
				<p><?= GetMessage("SEARCH_ERROR") ?></p>
                <? ShowError($arResult["ERROR_TEXT"]); ?>
				<p><?= GetMessage("SEARCH_CORRECT_AND_CONTINUE") ?></p>
				<br/><br/>
				<a href="/catalog/" class="main-btn">Перейти в каталог</a>
			</div>

        <? } elseif (count($arResult["SEARCH"]) > 0) { ?>

            <? if ($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"] ?>
			<div class="row subcategory-row">
                <? foreach ($arResult["SEARCH"] as $arItem) { ?>
					<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="category-item">
							<a href="<?= $arItem['URL_WO_PARAMS']; ?>">
								<div class="category-item_img">
									<img data-src="<?= $arItem['PRODUCT_INFO']['PREVIEW_PICTURE_SRC']; ?>"
									     alt="<?= $arItem['TITLE']; ?>">
								</div>
								<span class="category-item_title"><?= $arItem['TITLE']; ?><span
											class="arrow-icon"></span></span>
							</a>
						</div>
					</div>
                <? } ?>
			</div>
            <? if ($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"] ?>
        <? } else { ?>
			<div class="search_no-result">
				<span class="search_large-icon ico-search"></span>
				<p class="text-upper">Сожалеем, но ничего не найдено.</p>
				<p>Пожалуйста, попробуйте другой поисковый запрос…</p>
				<a href="/catalog/" class="main-btn">Перейти в каталог</a>
			</div>
        <? }; ?>
	</div>
</div>
