<?php
/**
 * Blocks.
 * 
 * @since   1.0.0
 */
namespace SOL\Inc;
use SOL\Inc\theme;
class blocks {

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

        // Register blocks.
        add_action( 'init', [ $this, 'register_blocks' ] );

        // Set allowed blocks.
        add_filter( 'allowed_block_types_all', [ $this, 'allowed_blocks' ] );

        // Set theme colors.
        add_action( 'after_setup_theme', [ $this, 'theme_colors' ] );

        // Set block colors.
        add_filter( 'acf/format_value/type=color_picker', [ $this, 'block_colors' ], 10, 3 );
        add_filter( 'acf/format_value/type=color', [ $this, 'block_colors' ], 10, 3 );

        // Public color CSS.
        add_action( 'wp_head', [ $this, 'public_color_css' ] );

        // Private color CSS.
        add_action( 'admin_head', [ $this, 'private_color_css' ] );

    }

    /**
     * Define blocks.
     * 
     * @since   1.0.0
     * @return  array       $blocks     The blocks.
     * @access  public
     */
    public function define_blocks() {

        // Define blocks.
        $blocks = [
            // Add blocks.
            'logo-slider',
            'rss-feed',
            'post-slider',
            'slider',
        ];

        // Return.
        return apply_filters( 'child_theme_blocks', $blocks );

    }

    /** 
     * Register blocks.
     * 
     * @since   1.0.0
     */
    public function register_blocks() {

        // Check for ACF.
        if( class_exists( 'acf' ) ) {

            // Loop through blocks.
            foreach( $this->define_blocks() as $block ) {

                // Register the block type.
                register_block_type( SOL_PATH . 'blocks/' . $block );

                // Backend styles and scripts.
                if( file_exists( SOL_PATH . 'blocks/' . $block . '/assets/' . $block . '.min.js' ) ) {

                    // Register.
                    wp_register_style( 'block-' . $block . '-editor-style', SOL_URL . 'blocks/' . $block . '/assets/' . $block . '.min.css', [], SOL_VERSION );

                }
                if( file_exists( SOL_PATH . 'blocks/' . $block . '/assets/' . $block . '.min.js' ) ) {

                    // Register.
                    wp_register_script( 'block-' . $block . '-editor-script', SOL_URL . 'blocks/' . $block . '/assets/' . $block . '.min.js', [ 'wp-blocks', 'wp-element', 'wp-editor' ], SOL_VERSION, true );

                }

            }

        }

    }

    /**
     * Set allowed blocks
     * 
     * @return  array   The allowed blocks.
     * @since   1.0.0
     */
    public function allowed_blocks( $blocks ) {

        // Return. Comment to allow only defined blocks below.
        return $blocks;

        // Set default allowed.
        $allowed = [
            'core/archives',
            'core/audio',
            'core/buttons',
            'core/categories',
            'core/code',
            'core/column',
            'core/columns',
            'core/coverImage',
            'core/embed',
            'core/file',
            'core/freeform',
            'core/gallery',
            'core/heading',
            'core/html',
            'core/image',
            'core/latestComments',
            'core/latestPosts',
            'core/list',
            'core/list-item',
            'core/more',
            'core/nextpage',
            'core/paragraph',
            'core/preformatted',
            'core/pullquote',
            'core/quote',
            'core/block',
            'core/separator',
            'core/shortcode',
            'core/spacer',
            'core/subhead',
            'core/table',
            'core/textColumns',
            'core/verse',
            'core/video',
        ];

        // Check for defined blocks.
        if( $this->define_blocks() ) {

            // Loop through blocks.
            foreach( $this->define_blocks() as $block ) {

                // Add block to allowed.
                $allowed[] = 'acf/' . $block['name'];

            }

        }

        // Return allowed. 
        return $allowed;

    }

    /**
     * Set theme colors.
     * 
     * @since   1.0.0
     * @return  void
     * @access  public
     */
    public function theme_colors() {

        // Disable default colors.
        add_theme_support( 'disable-custom-colors' );
        add_theme_support( 'editor-gradient-presets', [] );
        add_theme_support( 'disable-custom-gradients' );

        // Set custom colors.
        add_theme_support( 'editor-color-palette', theme::get_instance()->define_colors() );

    }

    /**
     * Set block colors.
     */
    public function block_colors( $value, $post_id, $field ) {

        // Skip in admin.
        if( is_admin() ) return $value;

        // Check if field is color or background.
        if( str_contains( $field['name'], 'color' ) || str_contains( $field['name'], 'background' ) ) {

            // Get colors. 
            $colors = theme::get_instance()->define_colors();

            // Loop through colors and look for a match.
            foreach( $colors as $color ) {

                // Check for color match.
                if( $color['color'] == $value ) {

                    // Set class.
                    $value = ( str_contains( $field['name'], 'color' ) ) ? 'has-' . $color['slug'] . '-color' : 'has-' . $color['slug'] . '-background-color';

                }

            }

        }

        // Return the value.
        return $value;

    }

    /**
     * Set public color CSS.
     * 
     * @since   1.0.0
     * @return  void
     * @access  public
     */
    public function public_color_css() {

        // Check for defined colors.
        if( ! theme::get_instance()->define_colors() || ! is_array( theme::get_instance()->define_colors() ) ) return;

        // Output. ?>
        <style>
        
            :root {<?php

                // Loop through colors.
                foreach( theme::get_instance()->define_colors() as $color ) {

                    // Output color. ?>
                    --<?php echo $color['slug']; ?>: <?php echo $color['color']; ?>;<?php

                } ?>
                
            }<?php

            // Loop through colors.
            foreach( theme::get_instance()->define_colors() as $color ) {

                // Output color. ?>
                .has-<?php echo $color['slug']; ?>-color { color: <?php echo $color['color']; ?>; }
                .has-<?php echo $color['slug']; ?>-background-color { background-color: <?php echo $color['color']; ?>; }<?php

            }

            // Loop through hover colors.
            foreach( theme::get_instance()->define_colors() as $color ) {

                // Output color. ?>
                .has-<?php echo $color['slug']; ?>-hover:hover { color: <?php echo $color['color']; ?>; }
                .has-<?php echo $color['slug']; ?>-background-hover:hover { background-color: <?php echo $color['color']; ?>; }<?php

            } ?>

        </style><?php

    }

    /** 
     * Set private color CSS.
     * 
     * @since   1.0.0
     * @return  void
     * @access  public
     */
    public function private_color_css() { ?>

        <style>body.wp-admin .wp-block{margin:0 auto!important}.acf-color-picker .iris-border .iris-picker-inner,span.wp-picker-input-wrap input[type=text]{display:none!important}.acf-color-picker .iris-picker.iris-border{height:auto!important;padding-bottom:0!important}.iris-palette-container{position:relative!important;left:0!important;bottom:0!important;padding:8px!important;display:flex;flex-wrap:wrap}.acf-color-picker a.iris-palette{border-radius:100%;height:30px!important;width:30px!important;margin:5px!important;box-shadow:none!important;border:2px solid rgb(0 0 0 / 30%);transition:all 0.2s ease;-webkit-transition:all 0.2s ease;-moz-transition:all 0.2s ease}.acf-color-picker a.iris-palette:hover{transform:scale(1.1)}</style>
        <script type="text/javascript">
            (function($) {
                acf.add_filter('color_picker_args', function( args, $field ) {
                    // Add codes.
                    args.palettes = [<?php

                        // Set count.
                        $theme = theme::get_instance();
                        $total = count( $theme->define_colors() );
                        $count = 0;

                        // Loop through.
                        foreach( $theme->define_colors() as $color ) {

                            // Add to count.
                            $count++;

                            // Check count.
                            if( $count == $total ) {

                                // Output.
                                echo '\'' . $color['color'] . '\'';

                            } else {

                                // Output.
                                echo '\'' . $color['color'] . '\', ';

                            }

                        } ?>
                    ]
                    // Return.
                    return args;
                });
            })(jQuery);
        </script><?php

    }

    /**
     * Get block args.
     * 
     * @param $block array  An array of block data.
     * @since 1.0.0
     */
    public static function get_args( $block ) {

        // Set args.
        $args = [
            'id'        => ( isset( $block['anchor'] ) && ! empty( $block['anchor'] ) ) ? $block['anchor'] : $block['id'],
            'class'     => 'sol-block sol-' . str_replace( 'acf/', '', $block['name'] )
        ];

        // Return.
        return apply_filters( 'sol_block_settings', $args );

    }

    /**
     * Get color.
     * 
     * @param $color string    Hex color code.
     * @param $type  string    Type of color class to return.
     * @since 1.0.0
     */
    public static function get_color( $color, $type = 'color' ) {

        // Set type.
        if( $type === 'background' ) {
            $type = 'background';
        } elseif( $type === 'background-hover' ) {
            $type = 'background-hover';
        } elseif( $type === 'hover' ) {
            $type = 'hover';
        } else {
            $type = 'color';
        }

        // Uppercase color.
        $color = strtoupper( $color );

        // Get colors.
        $colors = theme::get_instance()->define_colors();

        // Loop through colors.
        foreach( $colors as $c ) {

            // Check for color match.
            if( $c['color'] === $color ) {

                // Return class.
                return 'has-' . $c['slug'] . '-' . $type;

            }

        }

        // Return empty if no match found.
        return '';

    }

    /**
     * Get video.
     * 
     * @param $video string     Video URL.
     * @since   1.0.0
     */
    public static function get_video( $url ) {

        // Get HTML.
        $html = wp_oembed_get( $url );

        // Check if available.
        if( ! $html ) return '';

        // Return.
        return preg_replace_callback(
            '/src="([^"]+)"/',
            function( $matches ) use ( $url ) {
                $src = $matches[1];

                if ( strpos( $url, 'youtube.com' ) !== false || strpos( $url, 'youtu.be' ) !== false ) {
                    $src = add_query_arg( [
                        'autoplay'        => 1,
                        'mute'            => 1,
                        'rel'             => 0,
                        'modestbranding'  => 1,
                    ], $src );
                } elseif ( strpos( $url, 'vimeo.com' ) !== false ) {
                    $src = add_query_arg( [
                        'autoplay' => 1,
                        'muted'    => 1,
                        'title'    => 0,
                        'byline'   => 0,
                        'portrait' => 0,
                    ], $src );
                }

                return 'src="' . esc_url( $src ) . '"';
            },
            $html
        );

    }

}
