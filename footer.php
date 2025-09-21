<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package test
 */

?>

	<footer id="colophon" class="site-footer" style="background:url('<?php echo SOL_URL . 'assets/background.jpg'; ?>') no-repeat;">
		<div class="site-footer__container container">
			<div class="site-footer__top">
				<div class="site-footer_left"><?php

					// Footer menu.
					wp_nav_menu(
						array(
							'theme_location' => 'main-menu',
							'menu_id'        => 'footer-menu',
						)
					); ?>

				</div>
				<div class="site-footer_center">
					<a href="<?php echo site_url( '/' ); ?>">
						<img src="<?php echo get_field( 'header_logo', 'options' ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"/>
					</a>
				</div>
				<div class="site-footer_right">
					<div id="site-social"><?php

						// Loop.
						foreach( get_field( 'social_networks', 'options' ) as $network ) { 

							// Output. ?>
							<a href="<?php echo $network['link']; ?>" target="_blank" rel="noopener">
								<?php include SOL_PATH . 'assets/' . $network['network'] . '.svg'; ?>
							</a><?php

						} ?>

					</div>
				</div>
			</div>
			<div class="site-footer__bottom">
				<div class="site-footer__bradlee">
					<img src="<?php echo SOL_URL . 'assets/bradlee.png'; ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"/>
				</div>
				<p>&copy; <?php echo date('Y'); ?> <?php echo get_bloginfo( 'name' ); ?>. All Rights Reserved.</p>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
