/* main.js */
jQuery(document).ready(function($) {
    
    // Initialize AOS.
    AOS.init({ once: true });

    // Check for Bricks.
    if($('.bricks-container').length) {

        // Macy masonry.
        var macyInstance = Macy({
            container: '.bricks-container',
            trueOrder: false,
            waitForImages: true,
            useImageLoad: true,
            columns: 4,
            margin: 30,
            breakAt: {
                1200: 3,
                900: 2,
                600: 1
            }
        });

    }

    // On affiliate state.
    $('.sol-affiliates-nav-btn').on('click', function() {
        // Get state.
        var state = $('#sol-affiliates-nav').val();
        // Check if element exists.
        if($('#' + state).length) {
            // Scroll to element.
            $('html, body').animate({
                scrollTop: $('#' + state).offset().top - 100
            }, 1000);
        }
    });

    // Smooth scroll for anchor links.
    $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 1000, function() {
                    var $target = $(target);
                    $target.focus();
                    if ($target.is(":focus")) {
                        return false;
                    } else {
                        $target.attr('tabindex', '-1');
                        $target.focus();
                    }
                });
            }
        }
    });

    // Bind Fancybox if elements exist.
    if($("[data-fancybox]").length) {
        $("[data-fancybox]").fancybox({
            buttons: [
                "zoom",
                "slideShow",
                "thumbs",
                "close"
            ],
            loop: false,
            protect: true
        });
    }

});