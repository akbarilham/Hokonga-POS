jQuery(function ($) {

    'use strict';

    // -------------------------------------------------------------
    //	1. Product Carousel
    //	2. Latest Project Carousel
    //	3. Client Testimonial Carousel
    //	4. Chart
    //	5. Accordion
    //	6. Revolution Slider
    // -------------------------------------------------------------


    (function () {


    }());


    // -------------------------------------------------------------
    //  Product Carousel
    // -------------------------------------------------------------


    (function () {

        $(".clients").owlCarousel({
            autoPlay: 3000, //Set AutoPlay to 3 seconds
            pagination: false,
            items: 6,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [979, 3]
        });


        // Custom Navigation Events
        $(".clients-navigation .next").click(function () {
            $(".clients").trigger('owl.next');
        })
        $(".clients-navigation .prev").click(function () {
            $(".clients").trigger('owl.prev');
        })


    }());


    // -------------------------------------------------------------
    // Latest Project Carousel
    // -------------------------------------------------------------


    (function () {

        $(".latest-project").owlCarousel({
            autoPlay: 5000, //Set AutoPlay to 5 seconds
            pagination: false,
            items: 1,
            itemsDesktop: [1199, 1],
            itemsDesktopSmall: [979, 1],
            itemsTablet: [768, 1]
        });

        $(".latest-project-navigation .next").click(function () {
            $(".latest-project").trigger('owl.next');
        })

        $(".latest-project-navigation .prev").click(function () {
            $(".latest-project").trigger('owl.prev');
        })

    }());


    // -------------------------------------------------------------
    // Client Testimonial Carousel
    // -------------------------------------------------------------


    (function () {

        $(".client-testimonial").owlCarousel({
            autoPlay: 5000, //Set AutoPlay to 5 seconds
            pagination: false,
            items: 1,
            itemsDesktop: [1199, 1],
            itemsDesktopSmall: [979, 1],
            itemsTablet: [768, 1]
        });

        // Custom Navigation Events
        $(".client-testimonial-navigation .next").click(function () {
            $(".client-testimonial").trigger('owl.next');
        })
        $(".client-testimonial-navigation .prev").click(function () {
            $(".client-testimonial").trigger('owl.prev');
        })

    }());


    // -------------------------------------------------------------
    // Chart
    // -------------------------------------------------------------

    (function () {

        $("#donutchart1").donutchart({'size': 115, 'fgColor': '#9ed154', 'bgColor': '#eeeeee' });
        $("#donutchart1").donutchart("animate");

        $("#donutchart2").donutchart({'size': 115, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart2").donutchart("animate");

        $("#donutchart3").donutchart({'size': 115, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart3").donutchart("animate");

        $("#donutchart4").donutchart({'size': 115, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart4").donutchart("animate");

        $("#donutchart5").donutchart({'size': 115, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart5").donutchart("animate");

    }());


    // -------------------------------------------------------------
    // Accordion
    // -------------------------------------------------------------

    (function () {

        $('.collapse').on('show.bs.collapse', function () {
            var id = $(this).attr('id');
            $('a[href="#' + id + '"]').closest('.panel-heading').addClass('active-faq');
            $('a[href="#' + id + '"] .panel-title span').html('<i class="fa fa-angle-down"></i>');
        });
        $('.collapse').on('hide.bs.collapse', function () {
            var id = $(this).attr('id');
            $('a[href="#' + id + '"]').closest('.panel-heading').removeClass('active-faq');
            $('a[href="#' + id + '"] .panel-title span').html('<i class="fa fa-angle-right"></i>');
        });

    }());


    // -------------------------------------------------------------
    // Revolution Slider
    // -------------------------------------------------------------
    (function () {

        //homepage
        jQuery('.tp-banner').show().revolution(
            {
                dottedOverlay: "none",
                delay: 3000,
                startwidth: 770,
                startheight: 400,

                navigationType: "off",
                navigationArrows: "solo",
                navigationStyle: "preview1",

                touchenabled: "on",
                onHoverStop: "off",
                hideTimerBar: "on",


            });


        //homepage 2
        jQuery('.tp-banner2').show().revolution(
            {
                dottedOverlay: "none",
                delay: 3000,
                startwidth: 1140,
                startheight: 500,

                navigationType: "off",
                navigationArrows: "solo",
                navigationStyle: "preview3",

                touchenabled: "on",
                onHoverStop: "off",
                hideTimerBar: "on",


            });

    }());


    // -------------------------------------------------------------
    // PrettyPhoto
    // -------------------------------------------------------------

    (function () {

        jQuery(document).ready(function () {
            jQuery('a[data-gal]').each(function () {
                jQuery(this).attr('rel', jQuery(this).data('gal'));
            });
            jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({animationSpeed: 'slow', theme: 'light_square', slideshow: 3000, social_tools: false});
        });

    }());

    // -------------------------------------------------------------
    // Tabs
    // -------------------------------------------------------------


	(function() {

		[].slice.call( document.querySelectorAll( '.tabs' ) ).forEach( function( el ) {
			new CBPFWTabs( el );
		});

	})();




});


jQuery(document).ready(function ($) {
    //$( "#footer-two" ).append( "<a href=\'#\' class=\'back-to-top\'><i class=\'fa fa-angle-up\'></i></a>" );
    var offset = 220;
    var duration = 500;
    $(window).scroll(function () {
        if ($(this).scrollTop() > offset) {
            $('.back-to-top').fadeIn(duration);
        } else {
            $('.back-to-top').fadeOut(duration);
        }
    });

    $('.back-to-top').click(function (event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, 1000);
        return false;
    })
});


// =============================================
//  Dropdown menu
// =============================================


(function () {

    function getIEVersion() {
        var agent = navigator.userAgent;
        var reg = /MSIE\s?(\d+)(?:\.(\d+))?/i;
        var matches = agent.match(reg);
        if (matches != null) {
            return { major: matches[1], minor: matches[2] };
        }
        return { major: "-1", minor: "-1" };
    }

    var ie_version = getIEVersion();

    if (ie_version.major == 10) {
        $('html').addClass('ie10');
    }


    if ($('html').hasClass('ie9') || $('html').hasClass('ie10')) {

        $('.submenu-wrapper').each(function () {

            $(this).addClass('no-pointer-events');

        });

    }


    var timer;

    $('li.dropdown').on('mouseenter', function (event) {


        event.stopImmediatePropagation();
        event.stopPropagation();

        $(this).removeClass('open menu-animating').addClass('menu-animating');
        var that = this;


        if (timer) {
            clearTimeout(timer);
            timer = null;
        }


        timer = setTimeout(function () {

            $(that).removeClass('menu-animating');
            $(that).addClass('open');

        }, 300);   // 300ms as animation end time


    });

    // on mouse leave

    $('li.dropdown').on('mouseleave', function (event) {

        var that = this;

        $(this).removeClass('open menu-animating').addClass('menu-animating');


        if (timer) {
            clearTimeout(timer);
            timer = null;
        }

        timer = setTimeout(function () {

            $(that).removeClass('menu-animating');
            $(that).removeClass('open');

        }, 300);  // 300ms as animation end time

    });

}());