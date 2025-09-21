<?php
/**
 * Post Slider.
 * @param   array    $block  The block settings and attributes.
 * @since            1.0.0
 */
use SOL\Inc\blocks;

// Get block attributes.
$attrs = get_block_wrapper_attributes( blocks::get_args( $block ) ); ?>
<div <?php echo $attrs; ?>>
    <div class="sol-post-slider__cover sol-post-slider__cover-tr">
        <img src="<?php echo SOL_URL . 'assets/cover_tr.png'; ?>" alt="" />
    </div>
    <div class="sol-post-slider__cover sol-post-slider__cover-br">
        <img src="<?php echo SOL_URL . 'assets/cover_br.png'; ?>" alt="" />
    </div>
    <div class="sol-post-slider__cover sol-post-slider__cover-tl">
        <img src="<?php echo SOL_URL . 'assets/cover_tl.png'; ?>" alt="" />
    </div>
    <div class="sol-post-slider__cover sol-post-slider__cover-bl">
        <img src="<?php echo SOL_URL . 'assets/cover_bl.png'; ?>" alt="" />
    </div>
    <div class="sol-post-slider__container"><?php

        // Get.
        $args = [
            'post_type'      => get_field( 'post_type' ) ?: 'post',
            'posts_per_page' => get_field( 'post_limit' ) ?: 3,
            'orderby'        => get_field( 'orderby' ) ?: 'date',
            'order'          => get_field( 'order' ) ?: 'DESC',
            'post_status'    => 'publish',
        ];

        // Get.
        $query = new WP_Query( $args );

        // Check.
        if( $query->have_posts() ) {

            // Loop.
            while( $query->have_posts() ) { $query->the_post();
            
                // Get featured image URL.
                $featured_image = ( ! empty( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ) ) ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : SOL_URL . 'assets/parchment.png'; ?>

                <div class="sol-post-slider__slide" style="background-image: url(<?php echo esc_url( $featured_image ); ?>);">
                    <a href="<?php the_permalink(); ?>" class="sol-post-slider__slide-link">
                        <div class="sol-post-slider__slide-content">
                            <h2 class="sol-post-slider__slide-title"><?php the_title(); ?></h2>
                            <div class="sol-post-slider__slide-excerpt"><?php the_excerpt(); ?></div>
                            <span class="sol-post-slider__slide-button"><?php esc_html_e( 'Read More', 'sol' ); ?></span>
                        </div>
                    </a>
                </div><?php 
                
            }

            // Reset.
            wp_reset_postdata();

        } ?>

    </div>
</div>
