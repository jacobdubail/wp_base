<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  
  <?php if (is_search()) { ?>
    <meta name="robots" content="noindex, nofollow" /> 
  <?php } ?>

  <title><?php wp_title(''); ?></title>
  <meta name="google-site-verification" content="">
  <meta name="viewport" content="width=device-width">
  
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/i/favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/i/apple-touch-icon.png"> 

  <script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.min.js"></script>

  <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

  <script src="//use.typekit.net/xdb0ddk.js"></script>
  <script>try{Typekit.load();}catch(e){}</script>

  <?php wp_head(); ?>
  
</head>

<body <?php body_class(); ?>>

  <div id="bg"></div>
  
  <div class="page-wrap">
    <div class="centered">
      <header class="header">
        <?php if ( is_front_page() ) : ?>
          <h1>Danielle<small>&amp;</small>Jacob</h1>
        <?php else : ?>
          <h1><a href="<?php home_url(); ?>/">Danielle<small>&amp;</small>Jacob</a></h1>
        <?php endif; ?>
        <h2><?php bloginfo('description'); ?></h2>
        <nav class="main-nav">
          <?php wp_nav_menu( array( 'theme_location' => 'main-nav' ) ); ?>
        </nav>
      </header>
    
    
    
      <section class="main-content">
