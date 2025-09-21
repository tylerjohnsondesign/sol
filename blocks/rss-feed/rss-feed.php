<?php
/**
 * NRSS Feed.
 * @param   array    $block  The block settings and attributes.
 * @since            1.0.0
 */
use SOL\Inc\blocks;

// Get RSS feed.
$feed = get_field( 'feed_url' );
if( empty( $feed ) ) return;

// Get block attributes.
$attrs = get_block_wrapper_attributes( blocks::get_args( $block ) ); ?>
<div <?php echo $attrs; ?>>
    <div class="sol-rss-feed__container"><?php

        // Load feed class.
        include_once( ABSPATH . WPINC . '/feed.php' );

        // Get feed.
        $rss = fetch_feed( $feed );

        // Check for appropriate feed.
        if( ! is_wp_error( $rss ) ) {

            // Set max items.
            $maxItems = $rss->get_item_quantity( 4 );

            // Built an array of RSS items.
            $rss_items = $rss->get_items( 0, $maxItems );
            
        }

        // Check for items.
        if( $maxItems == 0 ) {

            // Output. ?>
            <p><?php esc_html_e( 'No items', 'sol' ); ?></p><?php

        } else {

            // Output.
            foreach( $rss_items as $item ) {

                // Get featured image from RSS item content.
                $featured_image = \SOL\get_rss_image( $item->get_content() );

                // Output. ?>
                <div class="sol-feed-item" style="background:url(<?php echo $featured_image; ?>) no-repeat center center; background-size:cover;">
                    <a class="sol-feed-item__link" href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php echo 'Posted ' . esc_html( $item->get_date( 'j F Y | g:i a' ) ); ?>">
                        <div class="sol-feed-item__overlay">
                            <h3 class="sol-feed-item__title"><?php echo esc_html( $item->get_title() ); ?></h3>
                            <div class="sol-feed-item__footer">
                                <span class="sol-feed-item__date"><?php echo esc_html( $item->get_date( 'j F Y | g:i a' ) ); ?></span>
                                <span class="sol-feed-item__author"><?php echo esc_html( $item->get_author() ? $item->get_author()->get_name() : '' ); ?></span>
                            </div>
                            <div class="sol-feed-item__readmore">Read More</div>
                        </div>
                    </a>
                </div><?php

            }

        } ?>
        
    </div>
</div>
