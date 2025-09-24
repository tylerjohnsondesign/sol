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
    <div class="sol-small-slider__cover sol-small-slider__cover-tr">
        <img src="<?php echo SOL_URL . 'assets/cover_tr.png'; ?>" alt="" />
    </div>
    <div class="sol-small-slider__cover sol-small-slider__cover-br">
        <img src="<?php echo SOL_URL . 'assets/cover_br.png'; ?>" alt="" />
    </div>
    <div class="sol-small-slider__cover sol-small-slider__cover-tl">
        <img src="<?php echo SOL_URL . 'assets/cover_tl.png'; ?>" alt="" />
    </div>
    <div class="sol-small-slider__cover sol-small-slider__cover-bl">
        <img src="<?php echo SOL_URL . 'assets/cover_bl.png'; ?>" alt="" />
    </div>
    <div class="sol-small-slider__container"><?php

        // Check.
        if( ! empty( get_field( 'slides' ) ) ) {

            // Loop.
            foreach( get_field( 'slides' ) as $slide ) {

                // Get featured image URL.
                $featured_image = ( ! empty( $slide['image'] ) ) ? $slide['image'] : SOL_URL . 'assets/parchment.png'; ?>

                <div class="sol-small-slider__slide" style="background-image: url(<?php echo esc_url( $featured_image ); ?>);">
                    <div class="sol-small-slider__overlay"></div><?php

                    // Check if link exists.
                    if( ! empty( $slide['button_url'] ) ) { ?>

                        <a href="<?php echo esc_url( $slide['button_url'] ); ?>" class="sol-small-slider__slide-link"><?php

                    } else { ?>

                        <div class="sol-small-slider__slide-link"><?php

                    } ?>
                        <div class="sol-small-slider__slide-content"><?php
                        
                            // Check.
                            echo ( ! empty( $slide['title'] ) ) ? '<h2 class="sol-small-slider__slide-title">' . esc_html( $slide['title'] ) . '</h2>' : '';
                            echo ( ! empty( $slide['content'] ) ) ? '<div class="sol-small-slider__slide-excerpt">' . $slide['content'] . '</div>' : '';
                            echo ( ! empty( $slide['button_text'] ) ) ? '<span class="sol-small-slider__slide-button">' . esc_html( $slide['button_text'] ) . '</span>' : ''; ?>

                        </div><?php

                    // Check if link exists.
                    if( ! empty( $slide['button_url'] ) ) { ?>

                        </a><?php

                    } else { ?>

                        </div><?php

                    } ?>

                </div><?php

            }

        } ?>

    </div>
</div>
