<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package test
 */

?>
<a href="<?php echo get_permalink(); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content"><?php

			// Title.
			the_title( '<h1 class="entry-title">', '</h1>' );

			// Author.
			echo '<p class="entry-author">By ' . get_the_author() . '</p>';

			// Content.
			echo '<p class="entry-excerpt">' . get_the_excerpt() . '</p>';
			
			// Read More. ?>
			<span class="thedean-read-more">Read More</span>

		</div>
	</article>
</a>
