jQuery(document).ready(function($){
	//responsive menu toggle
	var submenuDropdown = $('<button class="submenu-toggle"><i class="fas fa-chevron-down"></i></button>');

	$('.main-navigation ul li.menu-item-has-children').find('> a').after( submenuDropdown );

	$('.main-navigation .menu-item-has-children .submenu-toggle').on('click', function() {
		$(this).siblings('.sub-menu').slideToggle();
		$(this).toggleClass('active');
	});

	$('.main-navigation .toggle-button').on('click', function() {
		$(this).parent('.main-navigation').addClass('menu-toggled');
		$(this).siblings('div').children('.mobile-menu').slideDown();
	});

	$('.main-navigation .close').on('click', function() {
		$(this).parents('.main-navigation').removeClass('menu-toggled');
		$(this).siblings('.mobile-menu').slideUp();
	});

	$(window).on('keyup', function(e) {
		if(e.key == 'Escape') {
			$('.main-navigation').removeClass('menu-toggled');
			$('.main-navigation .mobile-menu').slideUp();	
		}
	});
	
	//banner slider
	$('.site-banner .banner-items').owlCarousel({
		items          : 1,
		autoplay       : sublime_blog_data.auto ? true : false,
		loop           : sublime_blog_data.loop ? true : false,
		rtl            : sublime_blog_data.rtl ? true : false,
		dots           : false,
		nav            : true,
		lazyLoad       : true,
		autoplayTimeout: sublime_blog_data.pause,		
		animateOut     : sublime_blog_data.mode,
		autoplaySpeed  : sublime_blog_data.speed,
	});

	//add class when slider is disable
	$(window).load(function() {
		if($('.site-banner').length != '1') {
			$('.header-banner-wrap').addClass('slider-disabled');
		} else {
			$('.header-banner-wrap').removeClass('slider-disabled');
		}
	});

	//goto top js
	var headerHeight = $('.site-header').outerHeight();
	$(window).on('scroll', function() {
		if($(this).scrollTop() > headerHeight) {
			$('.goto-top').addClass('active');
		}else {
			$('.goto-top').removeClass('active');
		}
	});

	$('.goto-top').on('click', function() {
		$('body, html').animate({
			scrollTop: 0,
		}, 700);
	});

	$('.main-navigation ul li a').on('focus', function() {
        $(this).parents('li').addClass('focused');
    }).on('blur', function() {
        $(this).parents('li').removeClass('focused');
	});
}); //document close