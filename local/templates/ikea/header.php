<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

$page = $APPLICATION->GetCurPage();

require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/filters.php');

?>
	<!DOCTYPE html>
	<html prefix="og: http://ogp.me/ns#" dir="ltr" lang="ru">
	<head>

		<meta content="<?= SITE_TEMPLATE_PATH ?>/browserconfig.xml" name="msapplication-config"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?= SITE_TEMPLATE_PATH ?>/img/favicon.ico" rel="icon" type="image/png"/>
		<link href="<?= SITE_TEMPLATE_PATH ?>/img/favicon.png" rel="icon" type="image/png"/>
		<link rel="apple-touch-icon" sizes="120x35" href="<?= SITE_TEMPLATE_PATH ?>/img/apple-touch-icon.png"/>
		<style>body {
				opacity: 0;
			}</style>

        <? $APPLICATION->ShowHead(); ?>
        <? $APPLICATION->ShowPanel(); ?>
		<title><? $APPLICATION->ShowTitle(); ?></title>
        <?
        //CSS
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/min.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/main.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/costume.css");
        //JS
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/main.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/costume.js");
        ?>
	</head>
<body>
<!--[if lt IE 10]>
<p class="browsehappy"><br>Вы используете <strong>устаревший</strong> браузер.
	Пожалуйста, <a href="http://browsehappy.com/">обновите его</a> для корректного
	отображения сайтов.</p>
<![endif]-->
<div class="global-wrapper">
	<div class="wrapper-loader">
		<div class="logo-loader"></div>
		<div class="loader-content"></div>
		<div class="loader-text">Загрузка</div>
	</div>
	<div class="bg-overlay"></div>
<? if (ERROR_404 != 'Y') { ?>
	<header class="ui-header">
		<div class="container">
			<div class="main-head">
				<div class="hamburger hamburger--spring">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
				<div class="head-logo">
					<a href="<?= ($page != SITE_DIR) ? SITE_DIR : 'javascript:void(0)'; ?>">
						<img data-src="<?= SITE_TEMPLATE_PATH ?>/img/static/logo.svg" alt="alt">
					</a>
				</div>
				<div class="head-catalog js_catalog tablet-large_visible">
					<a href="javascript:void(0)">
						<span class="ico-close"></span>
						<span class="ico-catalog"></span>
						Каталог
					</a>
				</div>
				<div class="head-fixed_panel">
					<div class="head-fixed_panel-top">
						<div class="head_tablet-box">
							<div class="mobile-visible">
								<form method="get" action="/search/" class="search-form">
									<input type="text" name="q" class="search-form_input" placeholder="Поиск по сайту">
									<div class="search-form_wrapper-submit">
										<span class="ico-search"></span>
										<input type="submit" class="search-form_submit" value="">
									</div>
								</form>
							</div>
							<div class="head-catalog js_catalog-mobile">
								<a href="javascript:void(0)"><span class="ico-close"></span><span
											class="ico-catalog"></span>Каталог</a>
							</div>
							<ul class="head_top-menu">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:menu",
                                    "header_menu",
                                    Array(
                                        "ALLOW_MULTI_SELECT" => "N",
                                        "CHILD_MENU_TYPE" => "left",
                                        "DELAY" => "N",
                                        "MAX_LEVEL" => "1",
                                        "MENU_CACHE_GET_VARS" => array(""),
                                        "MENU_CACHE_TIME" => "3600",
                                        "MENU_CACHE_TYPE" => "N",
                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                        "ROOT_MENU_TYPE" => "top",
                                        "USE_EXT" => "N"
                                    )
                                ); ?>
							</ul>
						</div>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section.list",
                            "header_menu",
                            Array(
                                "ADD_SECTIONS_CHAIN" => "N",
                                "CACHE_FILTER" => "N",
                                "CACHE_GROUPS" => "Y",
                                "CACHE_TIME" => "36000000",
                                "CACHE_TYPE" => "A",
                                "COUNT_ELEMENTS" => "Y",
                                "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                                "FILTER_NAME" => "sectionsFilter",
                                "IBLOCK_ID" => "1",
                                "IBLOCK_TYPE" => "catalog",
                                "SECTION_CODE" => "",
                                "SECTION_FIELDS" => array("NAME", ""),
                                "SECTION_ID" => "",
                                "SECTION_URL" => "",
                                "SECTION_USER_FIELDS" => array("", ""),
                                "SHOW_PARENT_NAME" => "Y",
                                "TOP_DEPTH" => "2",
                                "VIEW_MODE" => "LINE"
                            )
                        ); ?>
						<div class="mobile-visible">
							<?if ($USER->IsAuthorized()) {?>
							<a href="/personal/" class="head-user gray-btn">
								<span class="ico-user"></span>
								Личный кабинет
							</a>
							<?} else {?>
								<a href="/auth/" class="head-user gray-btn">
									<span class="ico-user"></span>
									Войти в личный кабинет
								</a>
							<?}?>
						</div>
					</div>
					<div class="head-fixed_panel-bottom">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:news.detail",
                            "header_contacts",
                            Array(
                                "ACTIVE_DATE_FORMAT" => "",
                                "ADD_ELEMENT_CHAIN" => "N",
                                "ADD_SECTIONS_CHAIN" => "N",
                                "AJAX_MODE" => "N",
                                "AJAX_OPTION_ADDITIONAL" => "",
                                "AJAX_OPTION_HISTORY" => "N",
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "BROWSER_TITLE" => "-",
                                "CACHE_GROUPS" => "Y",
                                "CACHE_TIME" => "36000000",
                                "CACHE_TYPE" => "A",
                                "CHECK_DATES" => "Y",
                                "DETAIL_URL" => "",
                                "DISPLAY_BOTTOM_PAGER" => "N",
                                "DISPLAY_DATE" => "Y",
                                "DISPLAY_NAME" => "Y",
                                "DISPLAY_PICTURE" => "Y",
                                "DISPLAY_PREVIEW_TEXT" => "Y",
                                "DISPLAY_TOP_PAGER" => "N",
                                "ELEMENT_CODE" => "",
                                "ELEMENT_ID" => "49",
                                "FIELD_CODE" => array("", ""),
                                "IBLOCK_ID" => "15",
                                "IBLOCK_TYPE" => "information",
                                "IBLOCK_URL" => "",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                "MESSAGE_404" => "",
                                "META_DESCRIPTION" => "-",
                                "META_KEYWORDS" => "-",
                                "PAGER_BASE_LINK_ENABLE" => "N",
                                "PAGER_SHOW_ALL" => "N",
                                "PAGER_TEMPLATE" => ".default",
                                "PAGER_TITLE" => "Страница",
                                "PROPERTY_CODE" => array("EMAIL", "PHONE", ""),
                                "SET_BROWSER_TITLE" => "N",
                                "SET_CANONICAL_URL" => "N",
                                "SET_LAST_MODIFIED" => "N",
                                "SET_META_DESCRIPTION" => "N",
                                "SET_META_KEYWORDS" => "N",
                                "SET_STATUS_404" => "N",
                                "SET_TITLE" => "N",
                                "SHOW_404" => "N",
                                "STRICT_SECTION_CHECK" => "N",
                                "USE_PERMISSIONS" => "N",
                                "USE_SHARE" => "N"
                            )
                        );?>
						<a href="#callback" data-toggle="modal" class="gray-btn callback-btn">Заказать звонок</a>
                        <?$APPLICATION->IncludeComponent(
                            "asd:subscribe.quick.form",
                            "subscribe",
                            Array(
                                "FORMAT" => "text",
                                "INC_JQUERY" => "N",
                                "NOT_CONFIRM" => "Y",
                                "RUBRICS" => array(),
                                "SHOW_RUBRICS" => "N"
                            )
                        );?>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:news.list",
                            "socials",
                            Array(
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "ADD_SECTIONS_CHAIN" => "N",
                                "AJAX_MODE" => "N",
                                "AJAX_OPTION_ADDITIONAL" => "",
                                "AJAX_OPTION_HISTORY" => "N",
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "CACHE_FILTER" => "N",
                                "CACHE_GROUPS" => "Y",
                                "CACHE_TIME" => "36000000",
                                "CACHE_TYPE" => "A",
                                "CHECK_DATES" => "Y",
                                "DETAIL_URL" => "",
                                "DISPLAY_BOTTOM_PAGER" => "N",
                                "DISPLAY_DATE" => "Y",
                                "DISPLAY_NAME" => "Y",
                                "DISPLAY_PICTURE" => "Y",
                                "DISPLAY_PREVIEW_TEXT" => "Y",
                                "DISPLAY_TOP_PAGER" => "N",
                                "FIELD_CODE" => array("", ""),
                                "FILTER_NAME" => "",
                                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                "IBLOCK_ID" => "16",
                                "IBLOCK_TYPE" => "information",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "MESSAGE_404" => "",
                                "NEWS_COUNT" => "20",
                                "PAGER_BASE_LINK_ENABLE" => "N",
                                "PAGER_DESC_NUMBERING" => "N",
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                "PAGER_SHOW_ALL" => "N",
                                "PAGER_SHOW_ALWAYS" => "N",
                                "PAGER_TEMPLATE" => ".default",
                                "PAGER_TITLE" => "Новости",
                                "PARENT_SECTION" => "",
                                "PARENT_SECTION_CODE" => "",
                                "PREVIEW_TRUNCATE_LEN" => "",
                                "PROPERTY_CODE" => array("URL", ""),
                                "SET_BROWSER_TITLE" => "N",
                                "SET_LAST_MODIFIED" => "N",
                                "SET_META_DESCRIPTION" => "N",
                                "SET_META_KEYWORDS" => "N",
                                "SET_STATUS_404" => "N",
                                "SET_TITLE" => "N",
                                "SHOW_404" => "N",
                                "SORT_BY1" => "SORT",
                                "SORT_BY2" => "NAME",
                                "SORT_ORDER1" => "ASC",
                                "SORT_ORDER2" => "ASC",
                                "STRICT_SECTION_CHECK" => "N"
                            )
                        );?>
						<a href="/user-agreement/" class="footer_terms-use">Пользовательское соглашение</a>
						<div class="copyright">Все права защищены. DOM IKEA</div>
						<a href="/privacy-policy/" class="footer-policy">Политика конфеденциальности</a> <br>
						<a href="/" class="footer-studio">
							<img alt="alt" src="<?= SITE_TEMPLATE_PATH ?>/img/static/studio.svg">
						</a>
					</div>
				</div>
				<ul class="head_top-menu tablet-large_visible">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "header_menu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "top",
                            "USE_EXT" => "N"
                        )
                    ); ?>
				</ul>
				<form action="/search/" method="get" class="search-form mobile-hidden">
					<input type="text" name="q" class="search-form_input" placeholder="Поиск по сайту">
					<div class="search-form_wrapper-submit">
						<span class="ico-search"></span>
						<input type="submit" class="search-form_submit" value="">
					</div>
				</form>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:sale.basket.basket.line",
                    "basket",
                    Array(
                        "HIDE_ON_BASKET_PAGES" => "N",
                        "PATH_TO_AUTHORIZE" => "",
                        "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                        "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                        "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                        "PATH_TO_PROFILE" => SITE_DIR."personal/",
                        "PATH_TO_REGISTER" => SITE_DIR."login/",
                        "POSITION_FIXED" => "N",
                        "SHOW_AUTHOR" => "N",
                        "SHOW_EMPTY_VALUES" => "N",
                        "SHOW_NUM_PRODUCTS" => "Y",
                        "SHOW_PERSONAL_LINK" => "N",
                        "SHOW_PRODUCTS" => "N",
                        "SHOW_REGISTRATION" => "N",
                        "SHOW_TOTAL_PRICE" => "N"
                    )
                );?>
			</div>
		</div>
	</header>
	<!-- END UI-HEADER -->
	<main class="main-content">
    <? if ($page != SITE_DIR && $APPLICATION->GetProperty('HIDE_WRAPPER') != 'Y'){ ?>
	<div class="container">
    <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        "breadcrumbs",
        Array(
            "PATH" => "",
            "SITE_ID" => "s1",
            "START_FROM" => "0"
        )
    ); ?>
	<h1><?= $APPLICATION->ShowTitle(false); ?></h1>
<? } ?>
<? } ?>
