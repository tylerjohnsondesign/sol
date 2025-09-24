<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package test
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content"><?php

		// Title.
		the_title( '<h1 class="entry-title">', '</h1>' );

		// Share buttons.
		echo do_shortcode( '[sharenow]' );

		// Content.
		the_content();
		
		// Share buttons.
		echo do_shortcode( '[sharenow]' );
		
		// Navigation.
		the_post_navigation(
			array(
				'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'test' ) . '</span> <span class="nav-title">%title</span>',
				'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'test' ) . '</span> <span class="nav-title">%title</span>',
			)
		); ?>

	</div><?php

	// Sidebar.
	get_sidebar(); ?>
	
</article>
