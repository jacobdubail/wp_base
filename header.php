<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="preload no-js ie lt-ie9 lt-ie8 lt-ie7" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="preload no-js ie lt-ie9 lt-ie8" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="preload no-js ie lt-ie9" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>         <html class="preload no-js ie ie9" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="preload no-js" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<?php if (is_search()) { ?>
		<meta name="robots" content="noindex, nofollow" />
	<?php } ?>

	<title><?php wp_title(''); ?></title>
	<!-- <meta name="google-site-verification" content=""> -->
	<meta name="viewport" content="width=device-width">

	<!-- <link rel="apple-touch-icon" href="/touchicon.png"> -->
	<link rel="icon" href="/favicon.png">
	<!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->
	<!-- or, set /favicon.ico for IE10 win -->
	<meta name="msapplication-TileColor" content="#bada55">
	<!-- <meta name="msapplication-TileImage" content="/tileicon.png">  -->

	<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.js"></script>

<!-- Typekit
	<script src="//use.typekit.net/xdb0ddk.js"></script>
	<script>try{Typekit.load();}catch(e){}</script>
-->

	<?php wp_head(); ?>

	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/respond.js"></script>
	<![endif]-->

</head>
<body <?php body_class(); ?>>
	<?php get_template_part('inc/svg-defs'); ?>
	<!--[if lt IE 9]>
		<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	<![endif]-->

		<header class="site__header">
			<nav class="site__nav" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'main-nav', 'container' => '', 'walker' => new base_nav_walker() ) ); ?>
			</nav>
			<a class="site__logo" href="<?php home_url(); ?>/">
				<img src="<?php header_image(); ?>" alt="<?php bloginfo('name'); ?>" />
			</a>
			<h2 class="site__description">
				<?php bloginfo('description'); ?>
			</h2>
		</header>

		<main class="site__content" role="main">
