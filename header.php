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
		<div class="header__desktop" style="background:url('<?php echo SOL_URL . 'assets/newtopbg.png'; ?>') no-repeat; background-position: center top;">
			<div class="header__desktop-wrapper">
				<div class="header__desktop-donate">
					<a href="https://sonsofliberty.dntly.com/#/" class="sol-donate-btn" target="_blank">
						<img src="<?php echo SOL_URL . 'assets/donate_globe.png'; ?>" alt="Donations Gratefully Received" />
						<span>Donations</span> Gratefully Received
					</a>
				</div>
				<div class="newsletter-signup">
					<a href="<?php echo site_url( '/newsletter' ); ?>">
						Sign Up Here for<br>Email Updates
					</a>
				</div>
				<div class="listen-live-gcn">
					<a href="https://www2.gcnlive.com/JW1D/index.php/onair?show=39&type=onDem" target="_blank" rel="noopener">
						<?php include SOL_PATH . 'assets/radio.svg'; ?>
						Listen Live at GCN
					</a>
				</div>
				<div id="desktop-site-social"><?php

					// Loop.
					foreach( get_field( 'social_networks', 'options' ) as $network ) { 

						// Output. ?>
						<a href="<?php echo $network['link']; ?>" target="_blank" rel="noopener">
							<?php include SOL_PATH . 'assets/' . $network['network'] . '.svg'; ?>
						</a><?php

					} ?>

				</div>
				<div class="header__desktop-ycr" style="background:url('<?php echo SOL_URL . 'assets/ycr.png'; ?>') no-repeat;"></div>
			</div>
			<div class="header__desktop-menu">
				<nav class="main-navigation">
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
			</div>
		</div>
		<div class="header__inner" style="background:url('<?php echo SOL_URL . 'assets/background.jpg'; ?>') no-repeat;">
			<div class="container container-flex">
				<div id="site-logo">
					<a href="<?php echo site_url( '/' ); ?>">
						<img src="<?php echo get_field( 'header_logo', 'options' ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"/>
					</a>
				</div>
				<nav id="site-navigation" class="main-navigation">
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
					<div id="mobile-site-social"><?php

						// Loop.
						foreach( get_field( 'social_networks', 'options' ) as $network ) { 

							// Output. ?>
							<a href="<?php echo $network['link']; ?>" target="_blank" rel="noopener">
								<?php include SOL_PATH . 'assets/' . $network['network'] . '.svg'; ?>
							</a><?php

						} ?>

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
				<div id="mobile-menu">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">+</button>
				</div>
			</div>
			<div class="site-bradlee">
				<img src="<?php echo SOL_URL . 'assets/bradlee.png'; ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"/>
			</div>
		</div>
	</header><!-- #masthead -->
