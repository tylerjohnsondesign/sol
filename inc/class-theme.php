<?php
/**
 * Theme.
 * 
 * @since   1.0.0
 */
namespace SOL\Inc;
class theme {

    /**
	 * Instance.
     * 
     * @since   1.0.0
	 */
	private static $instance = null;

    /**
	 * Get instance.
	 *
	 * @return storefront
     * @since   1.0.0
	 */
	public static function get_instance() {

        // If instance is null, create a new instance.
		if( null === self::$instance ) {
			self::$instance = new self();
		}

        // Return the instance.
		return self::$instance;

	}

    /**
     * Construct.
     * 
     * @since   1.0.0
     */
    public function __construct() {

        // Enqueue.
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );

        // ACF Filters.
        add_filter( 'acf/load_field/name=post_type', [ $this, 'post_type' ] );

        // Email Sign-up.
        add_shortcode( 'newsletter', [ $this, 'newsletter' ] );

    }

    /**
     * Enqueue scripts and styles.
     *
     * @since 1.0.0
     */
    public function enqueue() {

        // CSS.
        wp_enqueue_style( 'aos-css', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css', [], SOL_VERSION );
        wp_enqueue_style( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css', [], SOL_VERSION );
        wp_enqueue_style( 'slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css', [ 'slick' ], SOL_VERSION );
        wp_enqueue_style( 'sol-style', SOL_URL . 'dist/main.css', [], SOL_VERSION );

        // Script.
        wp_enqueue_script( 'aos-js', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js', [], SOL_VERSION, true );
        wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', [ 'jquery' ], SOL_VERSION, true );
        wp_enqueue_script( 'bricks-js', SOL_URL . 'assets/bricks.js', [ 'jquery' ], SOL_VERSION, true );
        wp_enqueue_script( 'sol-script', SOL_URL . 'dist/main.js', [ 'jquery', 'bricks-js', 'aos-js', 'slick' ], SOL_VERSION, true );

        // Load blocks.
        foreach( blocks::get_instance()->define_blocks() as $block ) {

            // Check for block.
            if( ! has_block( 'acf/' . $block ) ) continue;

            // Check if block CSS file exists.
            if( file_exists( SOL_PATH . 'blocks/' . $block . '/assets/' . $block . '.min.css' ) ) {

                // Enqueue block style.
                wp_enqueue_style( 'sol-block-' . $block, SOL_URL . 'blocks/' . $block . '/assets/' . $block . '.min.css', [], SOL_VERSION );

            }

            // Check if block JS file exists.
            if( file_exists( SOL_PATH . 'blocks/' . $block . '/assets/' . $block . '.min.js' ) ) {  
            
                // Enqueue block script.
                wp_enqueue_script( 'sol-block-' . $block, SOL_URL . 'blocks/' . $block . '/assets/' . $block . '.min.js', [ 'wp-blocks', 'wp-element', 'wp-editor' ], SOL_VERSION, true );

            }

        }

    }

    /**
     * Post Type.
     * 
     * @param   array    $field  The field array.
     * @return  array            The modified field array.
     * @since           1.0.0
     */
    public function post_type( $field ) {

        // Reset choices.
        $field['choices'] = [];

        // Get post types.
        $post_types = get_post_types( [ 'public' => true ], 'objects' );

        // Loop through post types.
        foreach( $post_types as $post_type ) {

            // Add to choices.
            $field['choices'][ $post_type->name ] = $post_type->labels->singular_name;

        }

        // Return field.
        return $field;

    }

    /**
     * Newsletter.
     * 
     * @since   1.0.0
     */
    public function newsletter( $atts ) {

        // Start output buffering.
        ob_start(); ?>

        <div class="sol-newsletter">
            <form method="POST" action="https://if.inboxfirst.com/ga/front/forms/160/subscriptions/">
                <input type="email" name="pending_subscriber[email]" placeholder="Enter your email address" title="Enter your email address" id="emailInput" required="" />
                <input class="sol-newsletter-btn" type="submit" value="Subscribe" title="Click to subscribe to our mailing list">
            </form>
            <div class="sol-newsletter-privacy">🔒 We will never share your private info.</div>
        </div><?php

        // Return.
        return ob_get_clean();


    }

     /**
     * Define theme colors.
     */
    public function define_colors() {

        // Set blank colors array.
        $colors = [];

        // Check if theme.json exists.
        if( file_exists( SOL_PATH . 'theme.json' ) ) {

            // Get theme.json.
            $theme_json = json_decode( file_get_contents( SOL_PATH . 'theme.json' ), true );

            // Check for colors.
            if( isset( $theme_json['settings']['color']['palette'] ) && is_array( $theme_json['settings']['color']['palette'] ) ) {

                // Loop through colors.
                foreach( $theme_json['settings']['color']['palette'] as $color ) {

                    // Add to colors array.
                    $colors[] = [
                        'name'  => isset( $color['name'] ) ? esc_attr__( $color['name'], SOL_DOMAIN ) : '',
                        'slug'  => isset( $color['slug'] ) ? sanitize_title( $color['slug'] ) : '',
                        'color' => isset( $color['color'] ) ? esc_attr( $color['color'] ) : '',
                    ];

                }

                // Return colors.
                return apply_filters( 'child_theme_colors', $colors );

            }

        }

        // Black.
        $colors[] = [
            'name'  => esc_attr__( 'Black', SOL_DOMAIN ),
            'slug'  => 'black',
            'color' => '#000000'
        ];

        // White.
        $colors[] = [
            'name'  => esc_attr__( 'White', SOL_DOMAIN ),
            'slug'  => 'white',
            'color' => '#ffffff'
        ];

        // Dark Grey.
        $colors[] = [
            'name'  => esc_attr__( 'Dark Grey', SOL_DOMAIN ),
            'slug'  => 'dark-grey',
            'color' => '#1C1C1C'
        ];

        // Light Grey.
        $colors[] = [
            'name'  => esc_attr__( 'Light Grey', SOL_DOMAIN ),
            'slug'  => 'light-grey',
            'color' => '#858585'
        ];

        // Red.
        $colors[] = [
            'name'  => esc_attr__( 'Red', SOL_DOMAIN ),
            'slug'  => 'red',
            'color' => '#F12D12'
        ];

        // Yellow.
        $colors[] = [
            'name'  => esc_attr__( 'Yellow', SOL_DOMAIN ),
            'slug'  => 'yellow',
            'color' => '#D69746'
        ];

        // Return colors.
        return apply_filters( 'child_theme_colors', $colors );

    }

}
