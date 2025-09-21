/**
 * Post Slider Block JavaScript.
 * @since   1.0.0
 */
jQuery(document).ready(function($) {
    
    // Slick.js.
    $('.sol-post-slider__container').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 5000,
        infinite: true,
        speed: 750,
        fade: true,
        cssEase: 'linear'
    });

});
