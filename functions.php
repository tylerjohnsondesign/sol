<?php
/**
 * Child Theme.
 * 
 * @author  Tyler Johnson
 * @since   1.0.0
 */
namespace SOL;

/**
 * Constants.
 */
define( 'SOL_MODE', 'development' );
define( 'SOL_VERSION', ( SOL_MODE == 'development' ) ? time() : '1.0.0' );
define( 'SOL_NAME', 'sol' );
define( 'SOL_DOMAIN', 'sol' );
define( 'SOL_URL', trailingslashit( get_stylesheet_directory_uri() ) );
define( 'SOL_PATH', trailingslashit( get_stylesheet_directory() ) );

/**
 * Theme.
 *
 * @since 1.0.0
 */
add_action( 'after_setup_theme', '\SOL\load' );
function load() {

    /** 
     * Load classes.
     * 
     * @since   1.0.0
     */
    require_once SOL_PATH . 'init.php';
    require_once SOL_PATH . 'inc/class-theme.php';
    require_once SOL_PATH . 'inc/class-blocks.php';

    /**
     * Register menus.
     * 
     * @since   1.0.0
     */
    register_nav_menus( [
        'main-menu' => esc_html__( 'Main Menu', 'sol' ),
    ] );

    /**
     * Add theme support.
     *
     * @since 1.0.0
     */
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );

    /**
     * Kick off the theme core class.
     *
     * @since 1.0.0
     */
    \SOL\init::get_instance();

}

/**
 * ACF message.
 */
add_action( 'admin_notices', '\SOL\acf_notice' );
function acf_notice() {

    // Check for ACF.
    if( ! class_exists( 'acf' ) ) {

        // Set class.
        $class = 'notice notice-error';

        // Set message.
        $message = __( 'Please install Advanced Custom Fields Pro to properly use this theme.', SOL_DOMAIN );

        // Print.
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );

    }
	
}

/**
 * Get featured image from RSS item content.
 * 
 * @param mixed $content
 * @return string
 * 
 * @since 1.0.0
 */
function get_rss_image( $content ) {

    // Parse content.
    preg_match( '/<img.*?src=["\'](.*?)["\'].*?>/i', $content, $matches );

    // Check for matches.
    if( empty( $matches ) ) return '';

    // Return.
    return $matches[1];

}