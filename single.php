<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package test
 */

get_header();
?>

	<main id="primary" class="site-main container">

		<?php
		while ( have_posts() ) {
			the_post();

			get_template_part( 'views/content', get_post_type() );

		} ?>

	</main><!-- #main -->

<?php
get_footer();
