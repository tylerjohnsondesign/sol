/**
 * Logo Slider Block JavaScript.
 * @since   1.0.0
 */
jQuery(document).ready(function($) {
    
    // Slick.js.
    $('.sol-logo-slider__container').slick({
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 1,
        infinite: true,
        speed: 6000,
        cssEase: 'linear',
        slidesToShow: 5,
        slidesToScroll: 1,
        variableWidth: true,
        adaptiveHeight: true,
        pauseOnHover: false,
        pauseOnFocus: false,
        centerMode: true,
        centerPadding: '60px',
    });

});
