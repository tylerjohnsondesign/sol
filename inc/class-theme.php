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

        // Sidebar.
        add_action( 'widgets_init', [ $this, 'sidebar' ] );

        // ACF Filters.
        add_filter( 'acf/load_field/name=post_type', [ $this, 'post_type' ] );

        // Email Sign-up.
        add_shortcode( 'newsletter', [ $this, 'newsletter' ] );

        // Affiliates.
        add_shortcode( 'affiliates', [ $this, 'affiliates' ] );

        // Endorsements.
        add_shortcode( 'endorsements', [ $this, 'endorsements' ] );

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
        wp_enqueue_style( 'fancybox-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css', [], SOL_VERSION );
        wp_enqueue_style( 'sol-style', SOL_URL . 'dist/main.css', [], SOL_VERSION );

        // Script.
        wp_enqueue_script( 'aos-js', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js', [], SOL_VERSION, true );
        wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', [ 'jquery' ], SOL_VERSION, true );
        wp_enqueue_script( 'macy-js', 'https://cdn.jsdelivr.net/npm/macy@2.5.1/dist/macy.min.js', [ 'jquery' ], SOL_VERSION, true );
        wp_enqueue_script( 'fancybox-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', [ 'jquery' ], SOL_VERSION, true );
        wp_enqueue_script( 'sol-script', SOL_URL . 'dist/main.js', [ 'jquery', 'macy-js', 'aos-js', 'fancybox-js', 'slick' ], SOL_VERSION, true );

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
     * Register sidebar.
     * 
     * @since   1.0.0
     */
    public function sidebar() {

        // Register primary sidebar.
        register_sidebar( [
            'name'          => __( 'Primary Sidebar', 'sol' ),
            'id'            => 'primary-sidebar',                 // used in templates
            'description'   => __( 'Main sidebar for posts.', 'sol' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">', // markup around each widget
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ] );
        
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
     * Affiliates.
     * 
     * @since   1.0.0
     */
    public function affiliates( $atts ) {

        // Start output buffering.
        ob_start(); 
        
        // Get states.
        $states = get_terms( [
            'taxonomy'   => 'state',
            'hide_empty' => true,
        ] ); 
        
        // Check for states.
        if( empty( $states ) ) return ''; ?>

        <div class="sol-affiliates">
            <h1><?php esc_html_e( 'Our Affiliates', 'sol' ); ?></h1>
            <div class="sol-affiliates-nav">
                <select id="sol-affiliates-nav" name="sol-affiliates-nav"><?php

                    // Loop through states.
                    foreach( $states as $state ) {

                        // Print option.
                        echo '<option value="' . esc_attr( $state->slug ) . '">' . esc_html( $state->name ) . '</option>';

                    } ?>

                </select>
                <div class="sol-affiliates-nav-btn">Visit</div>
            </div>
            <div class="sol-affiliates-list"><?php

                // Loop.
                foreach( $states as $state ) {

                    // Output. ?>
                    <div class="sol-affiliates-state">
                        <h3 id="<?php echo esc_attr( $state->slug ); ?>"><?php echo esc_html( $state->name ); ?></h3><?php

                        // Get affiliates.
                        $affiliates = new \WP_Query( [
                            'post_type'      => 'affiliate',
                            'posts_per_page' => -1,
                            'tax_query'      => [
                                [
                                    'taxonomy' => 'state',
                                    'field'    => 'slug',
                                    'terms'    => $state->slug,
                                ]
                            ],
                            'orderby'        => 'title',
                            'order'          => 'ASC',
                        ] );

                        // Check for affiliates.
                        if( $affiliates->have_posts() ) {

                            // Loop.
                            while( $affiliates->have_posts() ) {
                                $affiliates->the_post(); ?>

                                <div class="sol-affiliate"><?php

                                    // Check for link.
                                    if( ! empty( get_field( 'link' ) ) ) { ?>

                                        <h4><a href="<?php echo get_field( 'link' ); ?>" target="_blank" rel="noopener"><?php the_title(); ?></a></h4><?php

                                    } else { ?>

                                        <h4><?php the_title(); ?></h4><?php

                                    } ?>

                                </div><?php

                            }

                            // Reset post data.
                            wp_reset_postdata();

                        } else {

                            // No affiliates.
                            echo '<p>' . esc_html__( 'No affiliates found in this state.', 'sol' ) . '</p>';

                        } ?>

                    </div><?php

                } ?>
                
            </div>
        </div><?php

        // Return.
        return ob_get_clean();

    }

    /**
     * Endorsements.
     * 
     * @since   1.0.0
     */
    public function endorsements( $atts ){

        // Start output buffering.
        ob_start(); 

        // Get categories.
        $categories = get_terms( [
            'taxonomy'   => 'endorsement_category',
            'hide_empty' => true,
        ] ); 
        
        // Check for categories.
        if( empty( $categories ) ) return '';

        // Endorsements. ?>
        <div class="sol-endorsements">
            <h1><?php esc_html_e( 'Endorsements', 'sol' ); ?></h1>
            <div class="sol-endorsement-categories"><?php

                // Loop.
                foreach( $categories as $category ) {

                    // Output. ?>
                    <div id="<?php echo esc_attr( $category->slug ); ?>" class="sol-endorsement-category">
                        <h3><?php echo esc_html( $category->name ); ?></h3>
                        <div class="sol-endorsement-images"><?php

                            // Get endorsements.
                            $endorsements = new \WP_Query( [
                                'post_type'      => 'endorsement',
                                'posts_per_page' => -1,
                                'tax_query'      => [
                                    [
                                        'taxonomy' => 'endorsement_category',
                                        'field'    => 'slug',
                                        'terms'    => $category->slug,
                                    ]
                                ],
                                'orderby'        => 'title',
                                'order'          => 'ASC',
                            ] );

                            // Check for endorsements.
                            if( $endorsements->have_posts() ) {

                                // Loop.
                                while( $endorsements->have_posts() ) {
                                    $endorsements->the_post(); 
                                    
                                    // Skip if we don't have a featured image.
                                    if( ! has_post_thumbnail() ) continue; ?>

                                    <div class="sol-endorsement"><?php

                                        // Get featured image.
                                        if( has_post_thumbnail() ) {

                                            // Get large size URL.
                                            $large_image_url = get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>

                                            <a href="<?php echo esc_url( $large_image_url ); ?>" data-fancybox="gallery" data-caption="<?php echo esc_attr( get_the_title() ); ?>">
                                                <img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) ); ?>" />
                                            </a><?php

                                        } ?>

                                    </div><?php

                                }

                                // Reset post data.
                                wp_reset_postdata();

                            } else {

                                // No endorsements.
                                echo '<p>' . esc_html__( 'No endorsements found in this category.', 'sol' ) . '</p>';

                            } ?>

                        </div>
                    </div><?php

                } ?>

            </div>
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
