<? if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Config\Option;
define('NO_IMAGE', Option::get("tq.tools", "tq_module_param_osnovnye_no_image"));

//Iblock
define('IBLOCK_POPULAR_BANNERS', 7);
define('IBLOCK_SHOPS', 2);
define('IBLOCK_DELIVERY_ADDRESSES', 22);
//Hightload
define('HL_NEWS_COLORS', 2);
define('HL_PRODUCT_COLORS', 6);


$GLOBALS['SORT_ITEMS'] = [
    'PRICE_DESC' => [
        'NAME' => 'Сначала дорогие',
        'FIELD' => 'CATALOG_PRICE_1',
        'ORDER' => 'DESC',
        'CODE' => 'PRICE_DESC'
    ],
    'PRICE_ASC' => [
        'NAME' => 'Сначала дешевые',
        'FIELD' => 'CATALOG_PRICE_1',
        'ORDER' => 'ASC',
        'CODE' => 'PRICE_ASC'
    ],
];
