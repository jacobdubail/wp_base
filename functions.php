<?php 


/**
 * constant
 **/
define('PATH', get_stylesheet_directory());
define('FUNCTIONS_PATH', PATH . '/lib/');

//require_once(FUNCTIONS_PATH . 'language.php');
require_once (FUNCTIONS_PATH . 'login.php');
require_once (FUNCTIONS_PATH . 'admin.php');
//require_once (FUNCTIONS_PATH . 'dashboard.php');
//require_once (FUNCTIONS_PATH . 'menu.php');

require_once (FUNCTIONS_PATH . 'social.php');
require_once (FUNCTIONS_PATH . 'images.php');
require_once (FUNCTIONS_PATH . 'comments.php');
require_once (FUNCTIONS_PATH . 'shortcodes.php');
//require_once (FUNCTIONS_PATH . 'shortcodes-images.php');
require_once (FUNCTIONS_PATH . 'sidebars.php');
require_once (FUNCTIONS_PATH . 'widget.php');
require_once (FUNCTIONS_PATH . 'nav_walker.php');



  add_action('wp_enqueue_scripts', 'base_register_scripts');
  function base_register_scripts() {
    wp_enqueue_script( 'jquery' );

    wp_register_script('base_plugins', get_stylesheet_directory_uri() . '/js/plugins.min.js', false, '1', true );
    wp_enqueue_script('base_plugins');
    
    wp_register_script('base_functions', get_stylesheet_directory_uri() . '/js/script.min.js', array('base_plugins'), '1', true );
    wp_enqueue_script('base_functions');    
    
    wp_register_style('base_styles', get_stylesheet_directory_uri() . '/css/style.css', '', '1', 'all');
    wp_enqueue_style('base_styles');
    
  }

      
  if ( ! isset( $content_width ) ) $content_width = 1200;


  function category_id_class( $classes ) {
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
  add_filter('post_class', 'category_id_class');
  add_filter('body_class', 'category_id_class');

      
  add_theme_support( 'automatic-feed-links' );
  add_theme_support('nav-menus');
  add_action( 'init', 'register_my_menu' );
  function register_my_menu() {
    register_nav_menu( 'main-nav', __( 'Main Nav' ) );
  }
  
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'automatic_feed_links' );
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
  

  function complete_version_removal() { return ''; }
  add_filter('the_generator', 'complete_version_removal');
  remove_filter('pre_user_description', 'wp_filter_kses');
  remove_filter('pre_comment_content', 'wp_rel_nofollow');
  
  function jtd_allow_rel() {
    global $allowedtags;
    $allowedtags['a']['rel'] = array ();
  }
  add_action( 'wp_loaded', 'jtd_allow_rel' );
  


add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
      global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone, $is_ipad;

  if($is_lynx) $classes[]       = 'lynx';
  elseif($is_gecko) $classes[]  = 'gecko';
  elseif($is_opera) $classes[]  = 'opera';
  elseif($is_NS4) $classes[]    = 'ns4';
  elseif($is_safari) $classes[] = 'safari';
  elseif($is_chrome) $classes[] = 'chrome';
  elseif($is_IE) $classes[]     = 'ie';
  else $classes[]               = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
  if($is_ipad) $classes[]   = 'ipad';
	return $classes;
}



$customHeaderDefaults = array(
  'default-image'          => get_template_directory_uri() . '/images/logo.png',
  'random-default'         => false,
  'width'                  => 202,
  'height'                 => 72,
  'flex-height'            => false,
  'flex-width'             => false,
  'default-text-color'     => '',
  'header-text'            => '',
  'uploads'                => true,
  'wp-head-callback'       => '',
  'admin-head-callback'    => '',
  'admin-preview-callback' => '',
);

add_theme_support( 'custom-header', $customHeaderDefaults );


add_filter("gform_submit_button", "jtd_change_gform_submit_btn", 10, 2);
function jtd_change_gform_submit_btn($button, $form){
  return "<button class='btn' id='gform_submit_button_{$form["id"]}'>{$form["button"]["text"]}</button>";
}


/**
 * Fix Gravity Form Tabindex Conflicts
 * http://gravitywiz.com
 */
add_filter("gform_tabindex", "gform_tabindexer");
function gform_tabindexer() {
    $starting_index = 1000; // if you need a higher tabindex, update this number
    return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}
