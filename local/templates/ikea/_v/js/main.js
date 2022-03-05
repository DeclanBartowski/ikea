function is_mobile() {
	return (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
}
$(window).on('load', function() {
	 if (!is_mobile()) {
			NProgress.configure({
			parent: '.loader-content'
			});
			NProgress.start();
			NProgress.done();
			setTimeout(function() {
				$('.wrapper-loader').fadeOut(200);
			}, 500);
		}
	var heightHead = $('.ui-header').outerHeight();
	jQuery(window).on("resize", function() {
		heightHead = +parseInt($('.ui-header').outerHeight());
	});
	jQuery(window).on("scroll load", function() {
		if ($(window).scrollTop() > heightHead) {
			 $('.ui-header').addClass('fixed-menu');
			 $('.global-wrapper').css('paddingTop', heightHead);
			 setTimeout(function() {
			 	$('.ui-header').addClass('scroll-transform');
			 }, 100);
		} else {
			$('.ui-header').removeClass('fixed-menu');
			$('.ui-header').removeClass('scroll-transform');
			$('.global-wrapper').css('paddingTop', 0);
		}
		if ($(window).scrollTop() > $(window).height()) {
			$('.scroll-to-top').addClass('scroll-to-top-visible');
		} else {
			$('.scroll-to-top').removeClass('scroll-to-top-visible');
		}	
	});
});
jQuery(document).ready(function($) {
	 if (is_mobile()) {
	  	setTimeout(function() {
	  		$('.wrapper-loader').fadeOut(150);
	  	}, 600);
	  }
	lazyLoad($('body'));
	var swidth=(window.innerWidth-$(window).width());
	$(".js_catalog >a").on("click", function() {
		$(this).closest('.head-catalog').toggleClass('is-active');
		$('.head-fixed_panel').toggleClass('is-open');
		$('.bg-overlay').fadeToggle(200);
		if (!is_mobile()) {
			$('body').toggleClass('is-hidden');
		}
		return false;
	});
	$('.js_catalog-mobile> a').on('click', function() {
		$('.head-fixed_panel-top').css('transform', 'translate3d(-100%, 0, 0)');
		return false;
	});
	$('.js_back-list').on('click', function() {
		$('.head-fixed_panel-top').css('transform', 'translate3d(0, 0, 0)');
	});
	$('.js_arrow-icon').on('click', function() {
		$('.head-nav').addClass('is-visible');
		$('.head-fixed_panel-top').css('transform', 'translate3d(-200%, 0, 0)');
	});
	$('.js_back-list_2').on('click', function() {
		// setTimeout(function() {
  		$('.head-nav').removeClass('is-visible');
  	// }, 310);
		$('.head-fixed_panel-top').css('transform', 'translate3d(-100%, 0, 0)');
	});
	$(".hamburger").on("click", function() {
		$(this).toggleClass('is-active');
		$('.head-fixed_panel').toggleClass('is-open');
		$('.bg-overlay').fadeToggle(200);
		if (is_mobile()) {
			$('html').toggleClass('is-hidden');
		}
		
	});
	$('.bg-overlay').on("click", function() {
		$(this).fadeOut(200);
		$(".hamburger").removeClass('is-active');
		$(".head-catalog").removeClass('is-active');
		$('.filter-fixed').removeClass('is-open');
		$('.head-fixed_panel').removeClass('is-open');
		$('.product-added_fixed-box').removeClass('is-open');
		$('html').removeClass('is-hidden');
		if (!is_mobile()) {
			$('body').removeClass('is-hidden');
		}
	});
	$('.catalog_filter-btn').on('click', function() {
		$('.filter-fixed').addClass('is-open');
		$('.bg-overlay').fadeIn(150);
		if (is_mobile()) {
			$('html').addClass('is-hidden');
		}
	});
	$('.catalog-filter_close-btn').on('click', function() {
		$('.filter-fixed').removeClass('is-open');
		$('.bg-overlay').fadeOut(150);
		if (is_mobile()) {
			$('html').removeClass('is-hidden');
		}
	});
	$('.product-card_order-btn').on("click", function() {
		var name = $('.product-card_title').text();
		$('.product-added_name').text(name);
		$(this).addClass('is-active');
		$(this).find('.text').text('Добавлено');
		$('.product-added_fixed-box').addClass('is-open');
		$('.bg-overlay').fadeIn(150);
		if (is_mobile()) {
			$('html').toggleClass('is-hidden');
		}
		return false;
	});
	$('.product-added_close-btn').on("click", function() {
		$('.product-added_fixed-box').removeClass('is-open');
		$('.bg-overlay').fadeOut(150);
		if (is_mobile()) {
			$('html').removeClass('is-hidden');
		}
	});

	if($('.product-card_fixed-btns').length && $(window).width() < 575){
		$('.main-footer').addClass('is-pad');
	}
	

	 $(".portfolio-content").masonry({
        itemSelector: ".portfolio-item",
        columnWidth: ".portfolio-item",
    });
    var $grid = $('.portfolio-content').imagesLoaded( function() {
   	 $grid.masonry();
   	});

   	$('.show-all_portfolio-btn').on('click',function(){
   		$(this).toggleClass('is-active');
		  if ($(this).find('.text').html() == 'Свернуть') {
		      $(this).closest('.tab-item').find('.item-hidden').slideUp(200);
		      $(this).find('.text').text('Смотреть еще');
		    } else {
		      $(this).closest('.tab-item').find('.item-hidden').slideDown(200);
		      $(this).find('.text').text('Свернуть');
		    }
		    setTimeout(function() {
					 $grid.masonry('layout');
				}, 220);
		    return false;
		 });

   	$('.qustion-item').on('click',function(){
   		$(this).toggleClass('is-active');
   		$(this).find('.qustion-item_body').slideToggle(200);
   	});
	if($(window).width()> 575){
		$('.category-slider').slick({
			slidesToShow: 6,
			slidesToScroll: 6,
			speed: 1000,
			appendArrows: $('.category-counter'),
			responsive: [
			{
				breakpoint: 1199,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4,
				}
			}, 
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			}, ]
		});
		if ($('.category-slider').length) {
			var number = $(".category-slider").find('.slick-slide:not(.slick-cloned)').length;
			var currentIndex = $(".category-slider").find('.slick-active').index();
			$('.category-counter').find('.pagination-digit').text(number);
			$('.category-counter').find('.pagination-number').text(currentIndex);
			$(".category-slider").on('afterChange', function() {
				var number = $(this).find('.slick-slide:not(.slick-cloned)').length;
				currentIndex = $(this).find('.slick-active').index();
				$('.category-counter').find('.pagination-digit').text(number);
				$('.category-counter').find('.pagination-number').text(currentIndex);
			});
		}
		$('.product-slider').slick({
			slidesToShow: 4,
			slidesToScroll: 4,
			speed: 1000,
			appendArrows: $('.product-counter'),
			responsive: [
			{
				breakpoint: 1199,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					variableWidth: false,
				}
			}, 
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					variableWidth: false,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					variableWidth: false,
					// autoplay: true,
					// autoplaySpeed: 6000,
				}
			}, ]
		});
		if ($('.product-slider').length) {
			var number = $(".product-slider").find('.slick-slide:not(.slick-cloned)').length;
			var currentIndex = $(".product-slider").find('.slick-active').index();
			$('.product-counter').find('.pagination-digit').text(number);
			$('.product-counter').find('.pagination-number').text(currentIndex);
			$(".product-slider").on('afterChange', function() {
				var number = $(this).find('.slick-slide:not(.slick-cloned)').length;
				currentIndex = $(this).find('.slick-active').index();
				$('.product-counter').find('.pagination-digit').text(number);
				$('.product-counter').find('.pagination-number').text(currentIndex);
			});
		}
		$('.viewed-products_slider').slick({
			slidesToShow: 4,
			slidesToScroll: 4,
			speed: 1000,
			appendArrows: $('.viewed-products_counter'),
			responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				}
			}, 
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			}, 
			]
		});
		if ($('.viewed-products_slider').length) {
			var number = $(".viewed-products_slider").find('.slick-slide:not(.slick-cloned)').length;
			var currentIndex = $(".viewed-products_slider").find('.slick-active').index();
			$('.viewed-products_counter').find('.pagination-digit').text(number);
			$('.viewed-products_counter').find('.pagination-number').text(currentIndex);
			$(".viewed-products_slider").on('afterChange', function() {
				var number = $(this).find('.slick-slide:not(.slick-cloned)').length;
				currentIndex = $(this).find('.slick-active').index();
				$('.viewed-products_counter').find('.pagination-digit').text(number);
				$('.viewed-products_counter').find('.pagination-number').text(currentIndex);
			});
			if(number < 4){
				$('.viewed-products_counter').addClass('is-hidden');
			} else{
				$('.viewed-products_counter').removeClass('is-hidden');
			}
		}
	}
	function setProgress(index) {
		var calc = ((index + 1) / ($slider.slick('getSlick').slideCount)) * 100;
		$progressBarLabel.css('width', calc + '%')
	}
	var $slider = $('.product-card_img');
	var $progressBar = $('.progres-line');
	var $progressBarLabel = $('.progress-bar');
	$slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
		setProgress(nextSlide);
	});
	$('.product-card_img').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    responsive: [{
      breakpoint: 9999,
      settings: "unslick"
    }, {
      breakpoint: 575,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  });
  setProgress(0);

	$('.product-item_fav').on("click", function() {
		$(this).toggleClass('is-active');
	});
	$('.product-card_fav').on("click", function() {
		$(this).toggleClass('is-active');
	});

	$('.form-control').focus(function() {
		$(this).closest('.form-group').addClass('focus');
		$(this).closest('.form-group').find('.input_delete-text').addClass('is-visible');
	});
	$('.form-control').blur(function() {
		if ($(this).val().length == 0) {
			$(this).closest('.form-group').removeClass('focus');
			$(this).closest('.form-group').find('.input_delete-text').removeClass('is-visible');
		}
	});
	$('.input_delete-text').on("click", function() {
		$(this).closest('.form-group').find('.form-control').val(' ');
		$(this).closest('.form-group').removeClass('focus');
		$(this).removeClass('is-visible');
	});
	$('form').find('.form-control').each(function() {
		if ($(this).val().length > 1) {
			$(this).closest('.form-group').addClass('focus');
			$(this).closest('.form-group').find('.input_delete-text').addClass('is-visible');
		}
	});

	$('.case-item').on("click", function() {
		var text = $(this).data('text');
		$('.select-cover_title').text(text);
		$(this).closest('li').siblings().find('.case-item').removeClass('is-active');
		$(this).addClass('is-active');
	});
	$('.order-good_th-collapse-btn').on('click', function() {
		$(this).closest('.order-good').toggleClass('is-active');
	});
	$('.order-good_mobile-btn').on("click", function() {
		$(this).closest('.order-good').toggleClass('is-active');
	});
	
	$('.js_form-submit').on("click", function() {
		var jhis = $(this).closest('form');
		$(jhis).find('.requiredField').removeClass('input-error');
		$(jhis).find('.error').remove();
		var error = 0;
		$(jhis).find('.requiredField').each(function() {
			if ($(this).hasClass('callback-phone')) {
				if ($(this).val().length < 10) {
					$(this).after('<span class="error">Введите номер телефона</span>');
					$(this).addClass('input-error');
					error = 1;
				}
			} else if ($(this).hasClass('callback-name')) {
				if ($(this).val().length < 3) {
					$(this).addClass('input-error');
					$(this).after('<span class="error">Заполните поле имя</span>');
					error = 2;
				}
			}else if ($(this).hasClass('callback-text')) {
				if ($(this).val().length < 4) {
					$(this).addClass('input-error');
					$(this).after('<span class="error">Заполните поле</span>');
					error = 3;
				}
			}else if ($(this).hasClass('callback-email')) {
				var emailReg = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
				if (emailReg.test($(this).val()) === false) {
					$(this).addClass('input-error');
					$(this).after('<span class="error">Введите корректный E-mail</span>');
					error = 4;
				}
			}
		});
		if (error == 0) {
			/***отправка формы**/
		} else {
			if(jhis.hasClass('checkout-form')){
				var hHead = $('.ui-header').outerHeight();
				var myOffset = $(jhis).find('.error').offset().top;
				$('html, body').animate({
					scrollTop: myOffset - hHead- 75
				}, 1000);
			}
			return false;
		}
	});
	
	var sliders = $(".slider-range")
	sliders.each(function() {
		var number = parseInt($(this).closest('.filter-number').find('.price-min').data('number'));
		var number2 = parseInt($(this).closest('.filter-number').find('.price-max').data('number'));
		$(this).closest('.filter-number').find(".price-min").on('input', function() {
			var value1 = $(this).val();
			var rep = /[a-zA-Zа-яА-Я]/;
			if (rep.test(value1)) {
				value1 = value1.replace(rep, '');
				$(this).val(value1);
			}
		});
		$(this).closest('.filter-number').find(".price-max").on('input', function() {
			var value2 = $(this).val();
			var rep = /[a-zA-Zа-яА-Я]/;
			if (rep.test(value2)) {
				value2 = value2.replace(rep, '');
				$(this).val(value2);
			}
		});
		$(this).closest('.filter-number').find(".price-min").on('change', function() {
			var value1 = parseInt($(this).val());
			var value2 = parseInt($(this).closest('.filter-number').find('.price-max').val());
			if ($(this).val() == '') value1 = 1
			if (value1 > number2) {
				$(this).val(number2);
				value1 = number2;
			}
			if (value1 < number) {
				$(this).val(number);
				value1 = number;
			}
			if (value1 > value2) {
				$(this).val(value2);
				value1 = value2;
			}
			$(this).closest('.filter-number').find('.slider-range').slider("values", 0, value1);
			$(this).closest('.filter-number').find(".first-price").text(value1);
		});
		$(this).closest('.filter-number').find(".price-max").on('change', function() {
			var value1 = parseInt($(this).closest('.filter-number').find(".price-min").val());
			var value2 = parseInt($(this).val());
			if ($(this).val() == '') value2 = 2000
			if (value2 > number2) {
				$(this).val(number2);
				value2 = number2;
			}
			if (value2 < number) {
				$(this).val(number);
				value2 = number;
			}
			if (value1 > value2) {
				$(this).val(value1);
				value2 = value1;
			}
			$(this).closest('.filter-number').find('.slider-range').slider("values", 1, value2);
			$(this).closest('.filter-number').find(".second-price").text(value2);
		});
		if($(this).hasClass('slider-range_vertical')){
			$(this).slider({
			animate: true,
			range: true,
			orientation: "vertical",
			min: number,
			max: number2,
			values: [number, number2],
			slide: function(event, ui) {
				$(this).closest('.filter-number').find(".price-min").val(ui.values[0] + " " + "руб.");
				$(this).closest('.filter-number').find(".price-max").val(ui.values[1] + " " + "руб.");
			}
		});
		} else{
			$(this).slider({
				animate: true,
				range: true,
				min: number,
				max: number2,
				values: [number, number2],
				slide: function(event, ui) {
					$(this).closest('.filter-number').find(".price-min").val(ui.values[0]);
					$(this).closest('.filter-number').find(".price-max").val(ui.values[1]);
					$(this).closest('.filter-number').find(".first-price").text(ui.values[0]);
					$(this).closest('.filter-number').find(".second-price").text(ui.values[1]);
				}
			});
		}
	});
	$('.filter_price-label').on('click',function(){
		$('.filter_price-dropdown').slideToggle(10);
		$(this).toggleClass('is-active');
	});
	$('.catalog-filter_item-title').on('click', function() {
		$(this).toggleClass('active');
		$(this).closest('.catalog-filter_item').find('.catalog-filter_item-body').slideToggle(150);
	});
	$('.product-item_btn').on('click', function() {
		$(this).removeClass('ico-cart');
		$(this).addClass('is-active');
		return false;
	});
	$('body').on("touchend, click", function(e) {
	 	if( $(e.target).closest(".filter_price-label").length || $(e.target).closest(".filter_price-dropdown").length) return;
	 	$('.filter_price-dropdown').slideUp(10);
	 	$('.filter_price-label').removeClass('is-active');
	 });

	$('.js-select').selectric({
			maxHeight: 300,
			disableOnMobile: false,
			nativeOnMobile: false,
		});
		$('.tab-container').on('click', '.tab:not(.active)', function() {
			$(this).addClass('active').siblings().removeClass('active')
			$(this).closest('.tab-container').find('.tab-item').removeClass('is-visible').eq($(this).index()).addClass('is-visible');
		});

		$('.product-item_photo').on('click', 'li:not(.active)', function() {
			$(this).addClass('active').siblings().removeClass('active')
			$(this).closest('.product-item').find('.product-item_img-tab').find('img').removeClass('active').eq($(this).index()).addClass('active');
		});
	
	$(document).find('.slick-cloned a').removeAttr('data-fancybox');
	$(".fancybox").fancybox({
		afterLoad: function(instance, current) {
			if (!is_mobile()) {
				$('.fixed-menu').addClass('is-overflow');
				$('.scroll-to-top').addClass('is-hidden');
			}
		},
		afterClose: function(instance, current) {
			if (!is_mobile()) {
				$('.fixed-menu').removeClass('is-overflow');
				$('.scroll-to-top').removeClass('is-hidden');
			}
		},
		backFocus: false,
	});
	if (!is_mobile()) {
		$('.js-modal').on('show.bs.modal', function(event) {
			$('.fixed-menu').addClass('is-overflow');
			$('.scroll-to-top').addClass('is-hidden');
		});
		$('.js-modal').on('hidden.bs.modal', function(event) {
			$('.fixed-menu').removeClass('is-overflow');
			$('.scroll-to-top').removeClass('is-hidden');
		});
	}

	$('.scroll-to-top').on('click', function() {
		$('html, body').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
	$('input[type="tel"]').inputmask("+7 (999) 999 99 99", {
		"clearIncomplete": true,
		showMaskOnHover: false,
	});
});
function lazyLoad($content) {
		$content.find('img[data-src], source[data-src], audio[data-src], iframe[data-src]').each(function() {
			$(this).attr('src', $(this).data('src'));
			$(this).removeAttr('data-src');
			if ($(this).is('source')) {
				$(this).closest('video').get(0).load();
			}
		});
	}
if ($('#map').length) {
	YaMapsShown = false;
	$(window).on("scroll load resize", function() {
		if (!YaMapsShown) {
			if ($(window).scrollTop() + $(window).height() > $('#map').offset().top - 500) {
				showYaMaps();
				YaMapsShown = true;
			}
		}
	});

	function showYaMaps() {
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src = "https://api-maps.yandex.ru/2.1/?lang=ru_RU";
		document.getElementById("map").appendChild(script);
		script.onload = function() {
			ymaps.ready(init);
			var myMap, myMap2,
				myPlacemark2;

			function init() {
				myMap = new ymaps.Map("map", {
					center: [55.035782069678625,21.673446500000004],
					zoom: 16,
					behaviors: ['default', 'scrollZoom'],
				});
				myMap.behaviors.disable('scrollZoom');
				myMap.geoObjects.add(new ymaps.Placemark([55.035782069678625,21.673446500000004], {
					iconCaption: 'ул. Ленина 55, оф. 5',
				}, {
					preset: 'islands#blackCircleDotIcon',
				}));
			}
		}
	}
}