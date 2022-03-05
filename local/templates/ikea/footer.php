<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<? if (ERROR_404 != 'Y') { ?>
    <? if ($page != SITE_DIR && $APPLICATION->GetProperty('HIDE_WRAPPER') != 'Y') { ?></div><? } ?>
    <? $APPLICATION->ShowViewContent('same_goods'); ?>
    <? if ($APPLICATION->GetProperty('SHOW_RECOMMENDS') == 'Y') { ?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            "personal-recommends",
            Array(
            	"TITLE" => "Рекомендации для вас",
                "GRAY_BACKGROUND" => "Y",
                "ACTION_VARIABLE" => "action",
                "ADD_PICT_PROP" => "-",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "BACKGROUND_IMAGE" => "-",
                "BASKET_URL" => "/personal/basket.php",
                "BROWSER_TITLE" => "-",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COMPATIBLE_MODE" => "Y",
                "CONVERT_CURRENCY" => "N",
                "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                "DETAIL_URL" => "",
                "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_COMPARE" => "N",
                "DISPLAY_TOP_PAGER" => "N",
                "ELEMENT_SORT_FIELD" => "RAND",
                "ELEMENT_SORT_FIELD2" => "RAND",
                "ELEMENT_SORT_ORDER" => "RAND",
                "ELEMENT_SORT_ORDER2" => "RAND",
                "ENLARGE_PRODUCT" => "STRICT",
                "FILTER_NAME" => "arrFilter",
                "HIDE_NOT_AVAILABLE" => "N",
                "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                "IBLOCK_ID" => "1",
                "IBLOCK_TYPE" => "catalog",
                "INCLUDE_SUBSECTIONS" => "Y",
                "LABEL_PROP" => array(),
                "LAZY_LOAD" => "N",
                "LINE_ELEMENT_COUNT" => "3",
                "LOAD_ON_SCROLL" => "N",
                "MESSAGE_404" => "",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "META_DESCRIPTION" => "-",
                "META_KEYWORDS" => "-",
                "OFFERS_LIMIT" => "5",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Товары",
                "PAGE_ELEMENT_COUNT" => "18",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRICE_CODE" => array("BASE"),
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                "PRODUCT_SUBSCRIPTION" => "Y",
                "PROPERTY_CODE_MOBILE" => array(),
                "RCM_PROD_ID" => "",
                "RCM_TYPE" => "personal",
                "SECTION_CODE" => "",
                "SECTION_ID" => "",
                "SECTION_ID_VARIABLE" => "SECTION_ID",
                "SECTION_URL" => "",
                "SECTION_USER_FIELDS" => array("", ""),
                "SEF_MODE" => "N",
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SHOW_ALL_WO_SECTION" => "N",
                "SHOW_CLOSE_POPUP" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_FROM_SECTION" => "N",
                "SHOW_MAX_QUANTITY" => "N",
                "SHOW_OLD_PRICE" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "SHOW_SLIDER" => "Y",
                "SLIDER_INTERVAL" => "3000",
                "SLIDER_PROGRESS" => "N",
                "TEMPLATE_THEME" => "blue",
                "USE_ENHANCED_ECOMMERCE" => "N",
                "USE_MAIN_ELEMENT_SECTION" => "N",
                "USE_PRICE_COUNT" => "N",
                "USE_PRODUCT_QUANTITY" => "N"
            )
        );?>
		<!-- end product-section -->
    <? } ?>
    <? if ($APPLICATION->GetProperty('SHOW_CATEGORIES') == 'Y') { ?>
        <? $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "popular_sections",
            Array(
                "ADD_SECTIONS_CHAIN" => "N",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COUNT_ELEMENTS" => "N",
                "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                "FILTER_NAME" => "popSectionsFilter",
                "IBLOCK_ID" => "1",
                "IBLOCK_TYPE" => "catalog",
                "SECTION_CODE" => "",
                "SECTION_FIELDS" => array("NAME", "PICTURE", ""),
                "SECTION_ID" => "",
                "SECTION_URL" => "",
                "SECTION_USER_FIELDS" => array("", ""),
                "SHOW_PARENT_NAME" => "Y",
                "TOP_DEPTH" => "4",
                "VIEW_MODE" => "LINE"
            )
        ); ?>
    <? } ?>

	<div class="popular-goods_section">
		<div class="container">
            <? $APPLICATION->IncludeFile(
                sprintf('/include/section/seo/%s/seo.php', $APPLICATION->GetCurPage(false)),
                Array(),
                Array("MODE" => "html")
            ); ?>
		</div>
	</div>
	<!-- end popular-goods_section -->

    <? if ($APPLICATION->GetProperty('SHOW_QUESTION_FORM') == 'Y') { ?>
		<div class="container">
            <? $APPLICATION->IncludeComponent(
                "2quick:main.feedback",
                "question",
                array(
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "EMAIL_TO" => "admin@admin.com",
                    "EVENT_MESSAGE_ID" => array(),
                    "INFOBLOCKADD" => "Y",
                    "INFOBLOCKID" => "8",
                    "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                    "USE_CAPTCHA" => "Y",
                    "COMPONENT_TEMPLATE" => "question"
                ),
                false
            ); ?>
			<!-- end form-section -->
		</div>
    <? } ?>

    <? if ($APPLICATION->GetProperty('SHOW_VIEWED_PRODUCTS') == 'Y') { ?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.products.viewed",
            "viewed",
            Array(
                "ACTION_VARIABLE" => "action_cpv",
                "ADDITIONAL_PICT_PROP_1" => "-",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "BASKET_URL" => "/catalog/",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CONVERT_CURRENCY" => "N",
                "DEPTH" => "2",
                "DISPLAY_COMPARE" => "N",
                "ENLARGE_PRODUCT" => "STRICT",
                "HIDE_NOT_AVAILABLE" => "N",
                "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                "IBLOCK_ID" => "1",
                "IBLOCK_MODE" => "single",
                "IBLOCK_TYPE" => "catalog",
                "LABEL_PROP_1" => "",
                "LABEL_PROP_POSITION" => "top-left",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "PAGE_ELEMENT_COUNT" => "99",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRICE_CODE" => array(0=>"BASE",),
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                "PRODUCT_SUBSCRIPTION" => "Y",
                "SECTION_CODE" => "",
                "SECTION_ELEMENT_CODE" => "",
                "SECTION_ELEMENT_ID" => $GLOBALS["CATALOG_CURRENT_ELEMENT_ID"],
                "SECTION_ID" => $GLOBALS["CATALOG_CURRENT_SECTION_ID"],
                "SHOW_CLOSE_POPUP" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_FROM_SECTION" => "N",
                "SHOW_MAX_QUANTITY" => "N",
                "SHOW_OLD_PRICE" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "SHOW_SLIDER" => "Y",
                "SLIDER_INTERVAL" => "3000",
                "SLIDER_PROGRESS" => "N",
                "TEMPLATE_THEME" => "blue",
                "USE_ENHANCED_ECOMMERCE" => "N",
                "USE_PRICE_COUNT" => "N",
                "USE_PRODUCT_QUANTITY" => "N"
            )
        );?>
    <? } ?>
	</main>

	<!-- end main-content -->
	<footer class="main-footer">
		<div class="container">
			<div class="main-footer_content">
				<div class="row">
					<div class="col-xl-6">
						<div class="main-footer_row">
							<div class="footer-logo">
								<a href="<?= ($page != SITE_DIR) ? SITE_DIR : 'javascript:void(0)'; ?>">
									<img data-src="<?= SITE_TEMPLATE_PATH ?>/img/static/logo.svg" alt="alt">
								</a>
							</div>
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "footer_menu",
                                Array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "1",
                                    "MENU_CACHE_GET_VARS" => array(""),
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "N",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "footer",
                                    "USE_EXT" => "N"
                                )
                            ); ?>
						</div>
						<div class="main-footer_row">
                            <? $APPLICATION->IncludeComponent(
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
                            ); ?>
							<a href="#callback" data-toggle="modal" class="gray-btn callback-btn">Заказать звонок</a>
                            <? $APPLICATION->IncludeComponent(
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
                            ); ?>
						</div>
					</div>
					<div class="col-xl-6">
                        <? $APPLICATION->IncludeComponent(
                            "asd:subscribe.quick.form",
                            "subscribe",
                            Array(
                                "FORMAT" => "text",
                                "INC_JQUERY" => "N",
                                "NOT_CONFIRM" => "Y",
                                "RUBRICS" => array(),
                                "SHOW_RUBRICS" => "N"
                            )
                        ); ?>
                        <? $APPLICATION->IncludeComponent(
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
                        ); ?>
						<div class="main-footer_row">
							<div class="left-column">
								<a href="/user-agreement/" class="footer_terms-use">Пользовательское соглашение</a>
								<div class="copyright">Все права защищены. DOM IKEA</div>
							</div>
							<div class="right-column text-right">
								<a href="/privacy-policy/" class="footer-policy">Политика конфеденциальности</a> <br>
								<a href="/" class="footer-studio"><img alt="alt"
								                                       src="<?= SITE_TEMPLATE_PATH ?>/img/static/studio.svg"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<form action="/search/" method="get" class="search-form search-form_footer mobile-hidden">
				<input type="text" name="q" class="search-form_input" placeholder="Поиск по сайту">
				<div class="search-form_wrapper-submit">
					<span class="ico-search"></span>
					<input type="submit" class="search-form_submit" value="">
				</div>
			</form>
		</div>
	</footer>
	<!-- end main-footer -->

	<div class="scroll-to-top"></div>
	</div>
	<!-- END GLOBAL-WRAPPER -->
	<div aria-hidden="true" class="modal fade js-modal" id="callback" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<button class="close" data-dismiss="modal" type="button">
					<span class="ico-close"></span>
				</button>
				<div class="section-title">Заказать звонок</div>
                <? $APPLICATION->IncludeComponent(
                    "2quick:main.feedback",
                    "callback",
                    Array(
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "EMAIL_TO" => "admin@admin.com",
                        "EVENT_MESSAGE_ID" => array(),
                        "INFOBLOCKADD" => "Y",
                        "INFOBLOCKID" => "9",
                        "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                        "USE_CAPTCHA" => "Y"
                    )
                ); ?>
			</div>
		</div>
	</div>
	<!-- end callback -->
	<div aria-hidden="true" class="modal fade js-modal" role="dialog" id="application-accepted">
		<div class="modal-dialog modal-dialog_mod modal-dialog-centered" role="document">
			<div class="modal-content">
				<button class="close" data-dismiss="modal" type="button"><span class="ico-close"></span></button>
				<div class="popup-icon"><img data-src="<?= SITE_TEMPLATE_PATH ?>/img/icons/ico-check.svg" alt=""></div>
				<p class="modal-text">Ваша заявка успешно отправлена!</p>
			</div>
		</div>
	</div>
	<!-- end application-accepted -->

	<div aria-hidden="true" class="modal fade js-modal" role="dialog" id="success-modal">
		<div class="modal-dialog modal-dialog_mod modal-dialog-centered" role="document">
			<div class="modal-content">
				<button class="close" data-dismiss="modal" type="button"><span class="ico-close"></span></button>
				<div class="popup-icon"><img data-src="<?= SITE_TEMPLATE_PATH ?>/img/icons/ico-check.svg" alt=""></div>
				<p class="modal-text"></p>
			</div>
		</div>
	</div>
<? } ?>
</body>
</html>
