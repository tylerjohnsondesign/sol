<?php
/**
 * Logo Slider.
 * @param   array    $block  The block settings and attributes.
 * @since            1.0.0
 */
use SOL\Inc\blocks;

// Get block attributes.
$attrs = get_block_wrapper_attributes( blocks::get_args( $block ) ); ?>
<div <?php echo $attrs; ?>>
    <div class="sol-logo-slider__container"><?php 

        // Check.
        if( ! empty( get_field( 'logos' ) ) ) {

            // Loop.
            foreach( get_field( 'logos' ) as $logo ) {

                // Output. ?>
                <div class="sol-logo-slider__slide">
                    <img src="<?php echo esc_url( $logo['logo'] ); ?>" />
                </div><?php

            }

        } ?>

    </div>
</div>
