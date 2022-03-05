<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

?>

<?ShowError($arResult["strProfileError"]);?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
    ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>

<form  method="post" name="form1" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data" role="form" class="personal-data_form">
    <?=$arResult["BX_SESSION_CHECK"]?>
	<input type="hidden" name="lang" value="<?=LANG?>" />
	<input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
	<input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />
	<div class="subtitle">Личные данные</div>
	<div class="form-fields">
		<div class="form-group">
			<input type="text" name="NAME" value="<?=$arResult["arUser"]["NAME"]?>" class="form-control requiredField callback-name">
			<label class="form-label">Ф. И. О.</label>
			<span class="input_delete-text ico-close"></span>
		</div>
		<div class="form-group">
			<input type="tel" name="PERSONAL_PHONE" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" class="form-control requiredField callback-phone">
			<label class="form-label">Телефон</label>
			<span class="input_delete-text ico-close"></span>
		</div>
		<div class="form-group">
			<input type="email" name="EMAIL" class="form-control requiredField callback-email" value="<?=$arResult["arUser"]["EMAIL"]?>">
			<label class="form-label">Почта</label>
			<span class="input_delete-text ico-close"></span>
		</div>
	</div>
	<div class="subtitle">Данные для доставки</div>
	<div class="form-group">
		<input type="text" name="PERSONAL_ZIP" class="form-control requiredField callback-text" value="<?=$arResult["arUser"]["PERSONAL_ZIP"]?>">
		<label class="form-label">Индекс *</label>
		<span class="input_delete-text ico-close"></span>
	</div>
	<div class="form-group">
		<input type="text" name="PERSONAL_CITY" class="form-control requiredField callback-text" value="<?=$arResult['arUser']['PERSONAL_CITY']?>">
		<label class="form-label">Город*</label>
		<span class="input_delete-text ico-close"></span>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<input type="text" name="PERSONAL_STREET"  value="<?=$arResult["arUser"]["PERSONAL_STREET"]?>" class="form-control">
				<label class="form-label"> Улица</label>
				<span class="input_delete-text ico-close"></span>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<input type="text" class="form-control" name="UF_HOUSE" value="<?=$arResult["arUser"]["UF_HOUSE"]?>">
				<label class="form-label">Дом</label>
				<span class="input_delete-text ico-close"></span>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<input type="text" name="UF_APARTMENT" class="form-control" value="<?=$arResult["arUser"]["UF_APARTMENT"]?>">
				<label class="form-label">Квартира</label>
				<span class="input_delete-text ico-close"></span>
			</div>
		</div>
	</div>
	<div class="wrapper-submit">
		<input type="submit" name="save" class="personal-data_form-submit main-btn main-btn_mod js_form-submit" value="Сохранить">
	</div>
</form>

