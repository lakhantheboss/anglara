jQuery(document).ready(function ($) {
 // preoader 
    preloaderFadeOutTime = 1000;
    function fadePreloader() {
        var preloader = $('#preloader');
        preloader.fadeOut(preloaderFadeOutTime);
    }
    fadePreloader();
 //for sticky bar
    function header_sticky() {
        var scroll = $(window).scrollTop();
        if (scroll >= 50) {
            $(".site-header").addClass("sticky");
        } else {
            $(".site-header").removeClass("sticky");
        }
    }
    header_sticky();
    $(window).scroll(header_sticky);

// 	back top btn
	var btn = $('#back_top');

		$(window).scroll(function() {
		  if ($(window).scrollTop() > 300) {
			btn.addClass('show');
		  } else {
			btn.removeClass('show');
		  }
		});

// slider
    console.log('hua');
    $('.slide_box > .elementor-container').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        // infinite: false,
        asNavFor: '.dot_box .elementor-widget-wrap'
    });

    $('.dot_box .elementor-widget-wrap').slick({
        slidesToShow: 7,
        slidesToScroll: 1,
        // infinite: false,
        asNavFor: '.slide_box > .elementor-container',
        dots: false,
        arrows: true,
		centerMode: true,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 3,
                },
            }
        ],
    });
	
	

});