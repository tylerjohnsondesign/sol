<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package test
 */
if( ! is_active_sidebar( 'primary-sidebar' ) ) return; ?>

<aside id="secondary" class="widget-area has-dark-grey-background-color has-background">
	<?php dynamic_sidebar( 'primary-sidebar' ); ?>
</aside><!-- #secondary -->
