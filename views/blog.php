<?php
/**
 * Default Index.
 * 
 * @since 1.0.0
 */ ?>
<main id="primary" class="site-main container blog-container">
    <div class="blog-posts"><?php

        // Check for posts.
        if( have_posts() ) {

            // Loop.
            while ( have_posts() ) {
                the_post();

                // Get template.
                get_template_part( 'views/content', get_post_type() . '-short' );

            }

            // Numbered pagination.
            the_posts_pagination();

        } else {

            // No posts found.
            get_template_part( 'views/content', 'none' );

        } ?>

    </div>
    <div class="blog-sidebar">
        <?php get_sidebar(); ?>
    </div>
</main><!-- #main -->