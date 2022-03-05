<? if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$GLOBALS['arrFavoritesFilter']['=ID'] = $_SESSION['FAVORITES'];
$GLOBALS['popSectionsFilter']['!UF_POPULAR'] = false;

if(!empty($_REQUEST['sort'])){
    $_SESSION['SORT'] = $_REQUEST['sort'];
}
