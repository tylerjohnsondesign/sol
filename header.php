<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package test
 */ ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'test' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="header__inner" style="background:url('<?php echo SOL_URL . 'assets/background.jpg'; ?>') no-repeat;">
			<div class="container container-flex">
				<div id="site-logo">
					<a href="<?php echo site_url( '/' ); ?>">
						<img src="<?php echo get_field( 'header_logo', 'options' ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"/>
					</a>
				</div>
				<nav id="site-navigation" class="main-navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">+</button>
					<div class="header-nav"><?php
						wp_nav_menu(
							array(
								'theme_location' => 'main-menu',
								'menu_id'        => 'main-menu',
							)
						); ?>
						<a href="https://sonsofliberty.dntly.com/#/" class="sol-donate-btn" target="_blank">Donate</a>
						<a href="/" class="sol-search-btn">
							<?php include SOL_PATH . 'assets/search.svg'; ?>
						</a>
					</div>
				</nav>
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
			<div class="site-bradlee">
				<img src="<?php echo SOL_URL . 'assets/bradlee.png'; ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"/>
			</div>
		</div>
	</header><!-- #masthead -->
