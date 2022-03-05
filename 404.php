<?
include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");

?>
	<main class="main-content">
		<div class="error-section">
			<div class="container">
				<div class="error-number"></div>
				<div class="section-title">Ошибка</div>
				<p>Извините, такой страницы нет</p>
				<a href="<?= SITE_DIR ?>" class="main-btn main-btn_mod">Перейти на главную</a>
			</div>
		</div>
	</main>
<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>