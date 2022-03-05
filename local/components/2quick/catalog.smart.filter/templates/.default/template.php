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
$this->setFrameMode(true);
?>
<form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>" method="get"
      class="smartfilter">
    <? foreach ($arResult["HIDDEN"] as $arItem): ?>
		<input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>"
		       value="<? echo $arItem["HTML_VALUE"] ?>"/>
    <? endforeach; ?>
	<div class="filter-panel">
		<div class="left-column">
			<span class="catalog_filter-btn"><span class="ico-filter"></span>Все фильтры</span>
			<ul class="filter-select_list">
				<li>
					<select name="sort" class="js-select">
						<option value="all">Сортировка</option>
                        <? foreach ($GLOBALS['SORT_ITEMS'] as $item) { ?>
							<option<? if ($_SESSION['SORT'] == $item['CODE']) {
                                echo ' selected';
                            } ?> value="<?= $item['CODE']; ?>">
                                <?= $item['NAME']; ?>
							</option>
                        <? } ?>
					</select>
				</li>
                <?

                $cnt = 0;
                //not prices
                foreach ($arResult["ITEMS"] as $key => $arItem) {
                    if (
                        empty($arItem["VALUES"])
                        || isset($arItem["PRICE"])
                    ) {
                        continue;
                    }

                    if (
                        $arItem["DISPLAY_TYPE"] == "A"
                        && (
                            $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
                        )
                    ) {
                        continue;
                    }
                    $cnt++;
                    if ($cnt > 3) {
                        break;
                    }
                    ?>
					<li>
                        <?
                        $arCur = current($arItem["VALUES"]);
                        switch ($arItem["DISPLAY_TYPE"]) {
                            case "A"://NUMBERS_WITH_SLIDER
                                ?>
								<div class="filter_price-column">
									<span class="filter_price-label"><?= $arItem['NAME']; ?></span>
									<div class="filter_price-dropdown">
										<div class="filter-number filter-number_mod">
											<div class="wrapper_slider-range">
												<div class="slider-range slider-range_vertical"></div>
											</div>
											<div class="field-number_container field-number_container-mod">
												<div class="wrapper_filter-number">
													<input
															class="field-number price-max"
															data-number="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
															type="text"
															name="<?
                                                            echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
															value="<?
                                                            echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
															size="5"
															onkeyup="smartFilter.keyup(this)"
															placeholder="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
													/>
												</div>
												<div class="wrapper_filter-number">
													<input
															class="field-number price-min"
															data-number="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
															type="text"
															name="<?
                                                            echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
															value="<?
                                                            echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
															size="5"
															onkeyup="smartFilter.keyup(this)"
															placeholder="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
													/>
												</div>
											</div>
										</div>
									</div>
								</div>
                                <?
                                break;
                            case "B"://NUMBERS
                                ?>
								<div class="filter_price-column">
									<span class="filter_price-label"><?= $arItem['NAME']; ?></span>
									<div class="filter_price-dropdown">
										<div class="filter-number filter-number_mod">
											<div class="field-number_container field-number_container-mod">
												<div class="wrapper_filter-number">
													<input
															class="field-number"
															data-number="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
															type="text"
															name="<?
                                                            echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
															value="<?
                                                            echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
															size="5"
															onkeyup="smartFilter.keyup(this)"
															placeholder="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
													/>
												</div>
												<div class="wrapper_filter-number">
													<input
															class="field-number"
															data-number="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
															type="text"
															name="<?
                                                            echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
															value="<?
                                                            echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
															size="5"
															onkeyup="smartFilter.keyup(this)"
															placeholder="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
													/>
												</div>
											</div>
										</div>
									</div>
								</div>
                                <?
                                break;

                            default://DROPDOWN
                                $checkedItemExist = false;
                                ?>
								<select name="<?= $arCur["CONTROL_NAME_ALT"]; ?>" class="js-select">
									<option value=""><?= $arItem['NAME']; ?></option>
                                    <?
                                    foreach ($arItem["VALUES"] as $val => $ar):?>
										<option <? echo $ar["CHECKED"] ? 'selected' : '' ?>
												value="<? echo $ar["HTML_VALUE_ALT"] ?>"><? echo $ar["VALUE"]; ?>
										</option>
                                    <? endforeach ?>
								</select>
                                <?
                                break;
                        }
                        ?>
					</li>
                    <?
                }

                foreach ($arResult["ITEMS"] as $key => $arItem)//prices
                {
                    $key = $arItem["ENCODED_ID"];
                    if (isset($arItem["PRICE"])):
                        if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) {
                            continue;
                        }

                        $step_num = 4;
                        $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                        $prices = array();
                        if (Bitrix\Main\Loader::includeModule("currency")) {
                            for ($i = 0; $i < $step_num; $i++) {
                                $prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i,
                                    $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                            }
                            $prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"],
                                $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                        } else {
                            $precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
                            for ($i = 0; $i < $step_num; $i++) {
                                $prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $precision,
                                    ".", "");
                            }
                            $prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                        }
                        ?>
						<li>
							<div class="filter_price-column">
								<span class="filter_price-label">Цена</span>
								<div class="filter_price-dropdown">
									<div class="filter-number filter-number_mod">
										<div class="wrapper_slider-range">
											<div class="slider-range slider-range_vertical"></div>
										</div>
										<div class="field-number_container field-number_container-mod">
											<div class="wrapper_filter-number">
												<input
														class="field-number price-max"
														data-number="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
														type="text"
														name="<?
                                                        echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
														value="<?
                                                        echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
														size="5"
														onkeyup="smartFilter.keyup(this)"
														placeholder="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
												/>
											</div>
											<div class="wrapper_filter-number">
												<input
														class="field-number price-min"
														data-number="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
														type="text"
														name="<?
                                                        echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
														value="<?
                                                        echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
														size="5"
														onkeyup="smartFilter.keyup(this)"
														placeholder="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
												/>
											</div>
										</div>
									</div>
								</div>
							</div>
						</li>
                    <?endif;
                }
                ?>
			</ul>
		</div>
		<div class="right-column">
			<?$APPLICATION->ShowViewContent('products_count');?>
            <?/* echo GetMessage("CT_BCSF_FILTER_COUNT",
                array("#ELEMENT_COUNT#" => '<span class="found-products_number" id="modef_num">' . intval($arResult["ELEMENT_COUNT"]) . '</span>')); */?>
		</div>
	</div>
	<!-- end filter-panel -->
	<input type="hidden" id="set_filter" name="set_filter" value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>">
</form>
<form name="<? echo $arResult["FILTER_NAME"] . "_form_full" ?>" action="<? echo $arResult["FORM_ACTION"] ?>"
      method="get"
      class="smartfilter">
    <? foreach ($arResult["HIDDEN"] as $arItem): ?>
		<input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>"
		       value="<? echo $arItem["HTML_VALUE"] ?>"/>
    <? endforeach; ?>
	<div class="filter-fixed">
		<div class="text-right">
			<span class="catalog-filter_close-btn ico-close"></span>
		</div>
		<div class="section-title">
			Фильтр <span class="min">по параметрам</span>
		</div>
		<div class="filter-fixed_body">
            <? foreach ($arResult["ITEMS"] as $key => $arItem)//prices
            {
                $key = $arItem["ENCODED_ID"];
                if (isset($arItem["PRICE"])):
                    if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) {
                        continue;
                    }

                    $step_num = 4;
                    $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                    $prices = array();
                    if (Bitrix\Main\Loader::includeModule("currency")) {
                        for ($i = 0; $i < $step_num; $i++) {
                            $prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i,
                                $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                        }
                        $prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"],
                            $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                    } else {
                        $precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
                        for ($i = 0; $i < $step_num; $i++) {
                            $prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $precision, ".",
                                "");
                        }
                        $prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                    }
                    ?>
					<div class="catalog-filter_item">
						<div class="catalog-filter_item-title">Цена</div>
						<div class="catalog-filter_item-body">
							<div class="filter-number">
								<div class="field-number_container">
									<div class="wrapper_filter-number">
										<span class="text">от</span>
										<input
												class="field-number price-min"
												data-number="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
												type="text"
												name="<?
                                                echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
												id="<?
                                                echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
												value="<?
                                                echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
												placeholder="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
										/>
									</div>
									<div class="wrapper_filter-number">
										<span class="text">до</span>
										<input
												class="field-number price-max"
												data-number="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
												type="text"
												name="<?
                                                echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
												id="<?
                                                echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
												value="<?
                                                echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
												placeholder="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
										/>
									</div>
								</div>
								<div class="slider-range"></div>
								<div class="filter-number_footer">
									<span class="ico-close"></span>
									выбрано: от <span class="price-text">
						                <span class="first-price"><? echo (!empty($arItem["VALUES"]["MIN"]["HTML_VALUE"])) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ?></span>
						                <span class="rouble">i</span>
					                </span> по
									<span class="second-price"><? echo (!empty($arItem["VALUES"]["MAX"]["HTML_VALUE"])) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"] ?></span>
									<span class="rouble">i</span>
								</div>
							</div>
						</div>
					</div>
                <?endif;
            }

            //not prices
            foreach ($arResult["ITEMS"] as $key => $arItem) {
                if (
                    empty($arItem["VALUES"])
                    || isset($arItem["PRICE"])
                ) {
                    continue;
                }

                if (
                    $arItem["DISPLAY_TYPE"] == "A"
                    && (
                        $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
                    )
                ) {
                    continue;
                }
                ?>

                <?
                $arCur = current($arItem["VALUES"]);
                switch ($arItem["DISPLAY_TYPE"]) {
                    case "A"://NUMBERS_WITH_SLIDER
                        ?>
						<div class="catalog-filter_item">
							<div class="catalog-filter_item-title"><?= $arItem['NAME']; ?></div>
							<div class="catalog-filter_item-body">
								<div class="filter-number">
									<div class="field-number_container">
										<div class="wrapper_filter-number">
											<span class="text">от</span>
											<input
													class="field-number price-min"
													data-number="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
													type="text"
													name="<?
                                                    echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
													id="<?
                                                    echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
													value="<?
                                                    echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
													size="5"
													onkeyup="smartFilter.keyup(this)"
													placeholder="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
											/>
										</div>
										<div class="wrapper_filter-number">
											<span class="text">до</span>
											<input
													class="field-number price-max"
													data-number="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
													type="text"
													name="<?
                                                    echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
													id="<?
                                                    echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
													value="<?
                                                    echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
													size="5"
													onkeyup="smartFilter.keyup(this)"
													placeholder="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
											/>
										</div>
									</div>
									<div class="slider-range"></div>
									<div class="filter-number_footer">
										<span class="ico-close"></span>
										выбрано: от <span class="price-text">
						                <span class="first-price"><? echo (!empty($arItem["VALUES"]["MIN"]["HTML_VALUE"])) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ?></span>
						                <span class="rouble">i</span>
					                </span> по
										<span class="second-price"><? echo (!empty($arItem["VALUES"]["MAX"]["HTML_VALUE"])) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"] ?></span>
										<span class="rouble">i</span>
									</div>
								</div>
							</div>
						</div>
                        <?
                        break;
                    case "B"://NUMBERS
                        ?>
						<div class="catalog-filter_item">
							<div class="catalog-filter_item-title"><?= $arItem['NAME']; ?></div>
							<div class="catalog-filter_item-body">
								<div class="filter-number">
									<div class="field-number_container">
										<div class="wrapper_filter-number">
											<span class="text">от</span>
											<input
													class="field-number"
													data-number="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
													type="text"
													name="<?
                                                    echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
													id="<?
                                                    echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
													value="<?
                                                    echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
													size="5"
													onkeyup="smartFilter.keyup(this)"
													placeholder="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
											/>
										</div>
										<div class="wrapper_filter-number">
											<span class="text">до</span>
											<input
													class="field-number"
													data-number="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
													type="text"
													name="<?
                                                    echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
													id="<?
                                                    echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
													value="<?
                                                    echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
													size="5"
													onkeyup="smartFilter.keyup(this)"
													placeholder="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
											/>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <?
                        break;
                    default://CHECKBOXES
                        ?>
						<div class="catalog-filter_item">
							<div class="catalog-filter_item-title"><?= $arItem['NAME']; ?></div>
							<div class="catalog-filter_item-body">
								<ul class="catalog-filter_list">
                                    <?
                                    foreach ($arItem["VALUES"] as $val => $ar):?>
										<li>
											<label data-role="label_<?= $ar["CONTROL_ID"] ?>"
											       for="<? echo $ar["CONTROL_ID"] ?>"
											       class="unified-checkbox">
												<input type="checkbox"
												       value="<? echo $ar["HTML_VALUE"] ?>"
												       name="<? echo $ar["CONTROL_NAME"] ?>"
												       id="<? echo $ar["CONTROL_ID"] ?>"
                                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
													   onclick="smartFilter.click(this)">
												<span class="checkbox-text">
														<?= $ar["VALUE"]; ?>
                                                    <? if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])) {
                                                        ?> (<span class="number" data-role="count_<?= $ar["CONTROL_ID"] ?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)
                                                    <? } ?>
													</span>
											</label>
										</li>
                                    <? endforeach; ?>
								</ul>
							</div>
						</div>
                    <?
                }
            }
            ?>
		</div>
	</div>
	<!-- end filter-fixed -->
	<input type="hidden" id="set_filter" name="set_filter" value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>">
</form>

<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
