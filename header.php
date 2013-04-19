<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js ie lt-ie9 lt-ie8 lt-ie7" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js ie lt-ie9 lt-ie8" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js ie lt-ie9" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie ie9" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  
  <?php if (is_search()) { ?>
    <meta name="robots" content="noindex, nofollow" /> 
  <?php } ?>

  <title><?php wp_title(''); ?></title>
  <meta name="google-site-verification" content="">
  <meta name="viewport" content="width=device-width">
  
  <link rel="apple-touch-icon" href="/touchicon.png">
  <link rel="icon" href="/favicon.png">
  <!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->
  <!-- or, set /favicon.ico for IE10 win -->
  <meta name="msapplication-TileColor" content="#bada55">
  <meta name="msapplication-TileImage" content="/tileicon.png"> 

  <script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.min.js"></script>

  <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

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
  <!--[if lt IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
  <![endif]-->
  
  <div class="page-wrap">
    
    <header class="header">
      <nav class="main-nav" id="nav-wrap" role="navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'main-nav', 'container' => '' ) ); ?>
      </nav>
      <h1>
        <a id="logo" href="<?php home_url(); ?>/">
          <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo('name'); ?>" />
        </a>
      </h1> 
      <h2><?php bloginfo('description'); ?></h2>
    </header>
    
    <section class="main-content" role="main">