<?php

if ( ! isset( $content_width ) ) $content_width = 1200;


register_sidebar(array(
  'name' => 'Sidebar Widgets',
  'id'   => 'sidebar-widgets',
  'description'   => 'These are widgets for the sidebar.',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3>',
  'after_title'   => '</h3>'
));


/* Theme Support Function */
function jtd_theme_supports()  {
  $customHeaderDefaults = array(
    'default-image'          => get_template_directory_uri() . '/images/logo.png',
    'random-default'         => false,
    'width'                  => 202,
    'height'                 => 72,
    'flex-height'            => true,
    'flex-width'             => true,
    'default-text-color'     => '',
    'header-text'            => '',
    'uploads'                => true,
    'wp-head-callback'       => '',
    'admin-head-callback'    => '',
    'admin-preview-callback' => '',
  );
  add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'widgets' ) );
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'automatic_feed_links' );
  add_theme_support( 'custom-header', $customHeaderDefaults );
}

function register_my_menu() {
  register_nav_menu( 'main-nav', __( 'Main Nav' ) );
}

function jtd_oembed_default($defaults) {
  $defaults['width'] = 1160;
  return $defaults;
}

function jtd_allow_rel() {
  global $allowedtags;
  $allowedtags['a']['rel'] = array ();
}

function jtd_browser_body_class($classes) {
  global $is_IE, $is_iphone, $is_ipad;

  if($is_IE) $classes[]     = 'ie';
  if($is_iphone) $classes[] = 'iphone';
  if($is_ipad) $classes[]   = 'ipad';
  return $classes;
}

function jtd_category_id_class( $classes ) {
  global $post;
  if ( ! empty( $post ) ) {
    $cats = get_the_category($post->ID);
    if ( ! empty( $cats ) ) {
      foreach( $cats as $cat )
        $classes [] = 'cat-' . $cat->cat_ID . '-id';
    }
  }
  return $classes;
}



/* Actions */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

add_action( 'after_setup_theme', 'jtd_theme_supports' );
add_action( 'init', 'register_my_menu' );
add_action( 'wp_loaded', 'jtd_allow_rel' );



/* Filters */
remove_filter( 'pre_user_description', 'wp_filter_kses' );
remove_filter( 'pre_comment_content', 'wp_rel_nofollow' );

add_filter( 'the_generator', '__return_false' );
add_filter( 'embed_defaults', 'jtd_oembed_default' );
add_filter( 'body_class', 'jtd_browser_body_class' );
// add_filter( 'post_class', 'jtd_category_id_class' );
// add_filter( 'body_class', 'jtd_category_id_class' );
