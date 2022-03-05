<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

?>

<div class="contact-section">
	<div class="contact-section_body">
		<div class="row no-gutters">
			<div class="col-md-5 contact_left-column">
				<div class="contact-info_box">
					<p class="top-text"><?=$arResult['DESCRIPTION'];?></p>
					<ul class="contact-list">
						<?if(!empty($arResult['PHONES'])){?>
						<li>
							<span class="subtitle"><span class="ico-phone"></span>Телефон</span>
							<?foreach ($arResult['PHONES'] as $phone){?>
							<a href="tel:<?=$phone['PHONE']?>"><?=$phone['FORMATED']?></a><br/>
							<?}?>
						</li>
						<?}?>
                        <?if(!empty($arResult['ADDRESS'])){?>
						<li>
							<span class="subtitle"><span class="ico-adress"></span>Адрес</span>
							<?=implode('<br/>',$arResult['ADDRESS']);?>
						</li>
                        <?}?>
						<?if(!empty($arResult['WORK_TIMES'])){?>
						<li>
							<span class="subtitle"><span class="ico-clock"></span>Время работы </span>
							<p>
                                <?=implode('<br/>',$arResult['WORK_TIMES']);?>
							</p>
						</li>
						<?}?>
                        <?if(!empty($arResult['EMAILS'])){?>
						<li>
							<span class="subtitle"><span class="ico-email"></span>Написать нам</span>
							<?foreach ($arResult['EMAILS'] as $email){?>
							<a href="mailto:<?=$email;?>" class="contact-email"><?=$email;?></a><br/>
							<?}?>
						</li>
						<?}?>
					</ul>
				</div>
			</div>
			<div class="col-md-7">
				<div id="map"></div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="section-title text-center">Обратная связь</div>
        <?$APPLICATION->IncludeComponent(
            "2quick:main.feedback",
            "contacts",
            Array(
                "AJAX_MODE" => "Y",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "EMAIL_TO" => "admin@admin.com",
                "EVENT_MESSAGE_ID" => array(),
                "INFOBLOCKADD" => "Y",
                "INFOBLOCKID" => "3",
                "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                "REQUIRED_FIELDS" => array(),
                "USE_CAPTCHA" => "N"
            )
        );?>
	</div>
</div>
