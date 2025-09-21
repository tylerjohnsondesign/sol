<?php
/**
 * Template Name: Fullwidth
 * Description: A full-width page template for Gutenberg blocks.
 */
get_header(); ?>

	<main id="primary" class="site-main full-width"><?php

		while ( have_posts() ) :
			the_post();

			get_template_part( 'views/content', 'page' );

		endwhile; ?>

	</main><!-- #main -->

<?php
get_footer();