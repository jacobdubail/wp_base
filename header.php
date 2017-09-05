<!DOCTYPE html>
<html class="no-js" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<?php if (is_search()) { ?>
		<meta name="robots" content="noindex, nofollow" />
	<?php } ?>

	<title><?php wp_title(''); ?></title>
	<meta name="viewport" content="width=device-width">

	<link rel="icon" href="/favicon.png">
	<meta name="msapplication-TileColor" content="#bada55">

	<?php wp_head(); ?>

	<!--[if lte IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/respond.js"></script>
	<![endif]-->

</head>
<body <?php body_class(); ?>>
	<?php get_template_part('lib/svg-defs'); ?>
	<!--[if IE]>
		<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	<![endif]-->

	<header class="site__header">
		<a class="site__logo" href="<?php home_url(); ?>/">
			<img src="<?php header_image(); ?>" alt="<?php bloginfo('name'); ?>" />
		</a>
		<nav class="site__nav" role="navigation">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
				&#9776;
			</button>
			<?php
				$in = ( wp_is_mobile() ) ? '' : 'in';
				wp_nav_menu(
					array(
						'theme_location'  => 'main-nav',
						'menu_class'      => 'menu main__nav',
						'container'       => 'div',
						'container_id'    => 'main-nav',
						'container_class' => 'collapse ' . $in,
						//'walker'         => new BASE_nav_walker()
					)
				);
			?>
		</nav>
	</header>

	<main class="site__content" role="main">
