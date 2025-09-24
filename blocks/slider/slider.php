<?php
/**
 * Slider.
 * @param   array    \$block  The block settings and attributes.
 * @since            1.0.0
 */
use SOL\Inc\blocks;

// Check for slider.
if( empty( get_field( 'slider' ) ) ) return;

// Get block attributes.
$attrs = get_block_wrapper_attributes( blocks::get_args( $block ) ); ?>
<div <?php echo $attrs; ?>>
    <div class="sol-slider__container"><?php

        // Loop through slides.
        foreach( get_field( 'slider' ) as $slide ) { ?>

            <div class="sol-slider__slide">
                <div class="sol-slider__slide-image">
                    <img src="<?php echo esc_url( $slide['image'] ); ?>" alt="<?php echo esc_attr( $slide['heading'] ); ?>">
                </div>
                <div class="sol-slider__slide-inner container sol-slider-align__<?php echo ( ! empty( $slide['align'] ) ) ? esc_attr( $slide['align'] ) : 'left'; ?>">
                    <div class="sol-slider__slide-content">

                        <?php if( ! empty( $slide['heading'] ) ) : ?>
                            <h2 class="sol-slider__slide-title"><?php echo esc_html( $slide['heading'] ); ?></h2>
                        <?php endif; ?>
                        <?php if( ! empty( $slide['content'] ) ) : ?>
                            <div class="sol-slider__slide-text"><?php echo wp_kses_post( wpautop( $slide['content'] ) ); ?></div>
                        <?php endif; ?>
                        <?php if( ! empty( $slide['button_text'] ) && ! empty( $slide['button_url'] ) ) : ?>
                            <a href="<?php echo esc_url( $slide['button_url'] ); ?>" class="sol-slider__slide-button"><?php echo esc_html( $slide['button_text'] ); ?></a>
                        <?php endif; ?>

                    </div>
                </div>
            </div><?php
        
        } ?>

    </div>
</div>