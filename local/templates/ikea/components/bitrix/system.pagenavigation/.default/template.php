<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false)) {
        return;
    }
}
?>
<ul class="main-pagination mobile-hidden">
    <?

    $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
    $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
    ?>
    <?
    if ($arResult["bDescPageNumbering"] === true):
        $bFirst = true;
        if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
            if ($arResult["bSavePage"]):
                ?>
				<li>
					<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"
					   class="prev-page">
					</a>
				</li>
            <?
            else:
                if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"] + 1)):
                    ?>
					<li>
						<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
						   class="prev-page">
						</a>
					</li>
                <?
                else:
                    ?>
					<li>
						<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"
						   class="prev-page">
						</a>
					</li>
                <?
                endif;
            endif;

            if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
                $bFirst = false;
                if ($arResult["bSavePage"]):
                    ?>
					<li>
						<a class="modern-page-first"
						   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>">1</a>
					</li>
                <?
                else:
                    ?>
					<li>
						<a class="modern-page-first"
						   href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">1</a>
					</li>
                <?
                endif;
                if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
                    /*?>
                                <span class="modern-page-dots">...</span>
                    <?*/
                    ?>
                <?
                endif;
            endif;
        endif;
        do {
            $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;

            if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                ?>
				<li class="active"><a href="javascript:void(0)"><?= $NavRecordGroupPrint ?></a></li>
            <?
			elseif ($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
                ?>
				<li>
					<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
					   class="<?= ($bFirst ? "modern-page-first" : "") ?>"><?= $NavRecordGroupPrint ?></a>
				</li>
            <?
            else:
                ?>
				<li>
					<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"<?
                    ?> class="<?= ($bFirst ? "modern-page-first" : "") ?>"><?= $NavRecordGroupPrint ?></a>
				</li>
            <?
            endif;

            $arResult["nStartPage"]--;
            $bFirst = false;
        } while ($arResult["nStartPage"] >= $arResult["nEndPage"]);

        if ($arResult["NavPageNomer"] > 1):
            if ($arResult["nEndPage"] > 1):
                if ($arResult["nEndPage"] > 2):
                    /*?>
                            <span class="modern-page-dots">...</span>
                    <?*/
                    ?>
                <?
                endif;
                ?>
				<li>
					<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1"><?= $arResult["NavPageCount"] ?></a>
				</li>
            <?
            endif;

            ?>
			<li>
				<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
				   class="next-page">
				</a>
			</li>
        <?
        endif;

    else:
        $bFirst = true;

        if ($arResult["NavPageNomer"] > 1):
            if ($arResult["bSavePage"]):
                ?>
				<li>
					<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
					   class="prev-page">
					</a>
				</li>
            <?
            else:
                if ($arResult["NavPageNomer"] > 2):
                    ?>
					<li>
						<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
						   class="prev-page">
						</a>
					</li>
                <?
                else:
                    ?>
					<li>
						<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
						   class="prev-page">
						</a>
					</li>
                <?
                endif;

            endif;

            if ($arResult["nStartPage"] > 1):
                $bFirst = false;
                if ($arResult["bSavePage"]):
                    ?>
					<li>
						<a class="modern-page-first"
						   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1">1</a>
					</li>
                <?
                else:
                    ?>
					<li>
						<a class="modern-page-first"
						   href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">1</a>
					</li>
                <?
                endif;
                if ($arResult["nStartPage"] > 2):
                    /*?>
                                <span class="modern-page-dots">...</span>
                    <?*/
                    ?>
                <?
                endif;
            endif;
        endif;

        do {
            if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                ?>
				<li class="active"><a href="javascript:void(0)"><?= $arResult["nStartPage"] ?></a></li>
            <?
			elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
                ?>
				<li>
					<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
					   class="<?= ($bFirst ? "modern-page-first" : "") ?>"><?= $arResult["nStartPage"] ?></a>
				</li>
            <?
            else:
                ?>
				<li>
					<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"<?
                    ?> class="<?= ($bFirst ? "modern-page-first" : "") ?>"><?= $arResult["nStartPage"] ?></a>
				</li>
            <?
            endif;
            $arResult["nStartPage"]++;
            $bFirst = false;
        } while ($arResult["nStartPage"] <= $arResult["nEndPage"]);

        if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
            if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
                if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
                    /*?>
                            <span class="modern-page-dots">...</span>
                    <?*/
                    ?>
                <?
                endif;
                ?>
				<li>
					<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>"><?= $arResult["NavPageCount"] ?></a>
				</li>
            <?
            endif;
            ?>
			<li>
				<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"
				   class="next-page">
				</a>
			</li>
        <?
        endif;
    endif;
    ?>
</ul>