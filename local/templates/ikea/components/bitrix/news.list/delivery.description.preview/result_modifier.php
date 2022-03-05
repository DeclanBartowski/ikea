<?php

foreach ($arResult["ITEMS"] as &$arItem) {
    $arItem['ICON'] = CFile::GetPath($arItem);
}
unset($arItem);