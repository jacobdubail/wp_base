<?php

/**
 * constant
 **/
define('PATH', get_stylesheet_directory());
define('FUNCTIONS_PATH', PATH . '/lib/');

require_once (FUNCTIONS_PATH . 'theme_support.php');
require_once (FUNCTIONS_PATH . 'login.php');
require_once (FUNCTIONS_PATH . 'admin.php');
require_once (FUNCTIONS_PATH . 'images.php');
require_once (FUNCTIONS_PATH . 'comments.php');
require_once (FUNCTIONS_PATH . 'shortcodes.php');
require_once (FUNCTIONS_PATH . 'sidebars.php');
require_once (FUNCTIONS_PATH . 'widget.php');
require_once (FUNCTIONS_PATH . 'nav_walker.php');
require_once (FUNCTIONS_PATH . 'acf_fields.php');
//require_once (FUNCTIONS_PATH . 'foxyshop.php');
//
if ( ! current_user_can( 'manage_options' ) ) {
	show_admin_bar( false );
}

add_action('after_setup_theme', 'base_remove_admin_bar');
function base_remove_admin_bar() {
	if ( ! current_user_can('administrator') && !is_admin() ) {
	  show_admin_bar(false);
	}
}

add_action('wp_enqueue_scripts', 'base_register_scripts');
function base_register_scripts() {
	wp_enqueue_script( 'jquery' );

	wp_register_script('base_plugins', get_stylesheet_directory_uri() . '/js/plugins.min.js', false, filemtime( get_stylesheet_directory().'/js/plugins.min.js'), true );
	wp_enqueue_script('base_plugins');

	wp_register_script('base_functions', get_stylesheet_directory_uri() . '/js/main.min.js', array('base_plugins'), filemtime( get_stylesheet_directory().'/js/main.min.js'), true );
	wp_enqueue_script('base_functions');


	wp_register_style('base_google', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700', '', '', 'all');
	wp_enqueue_style('base_google');

	wp_register_style('base_styles', get_stylesheet_uri(), '', filemtime( get_stylesheet_directory().'/style.css'), 'all');
	wp_enqueue_style('base_styles');

}


function osl_remove_foxyshop_images_box() {
	remove_meta_box('product_images_meta', 'foxyshop_product', 'normal');
}
add_action( 'admin_init' , 'osl_remove_foxyshop_images_box' );

add_action('admin_head', 'osl_show_featured_image_box');
function osl_show_featured_image_box() {
  echo '<style>
    html body.post-type-foxyshop_product #postimagediv {
			display: block;
		}
  </style>';
}


if ( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}


function jtd_include_field_types_gravity_forms( $version ) {
	include_once( FUNCTIONS_PATH . 'acfgfv5.php');
}
add_action('acf/include_field_types', 'jtd_include_field_types_gravity_forms');


function jtd_change_gform_submit_btn($button, $form){
	return "<button class='btn' id='gform_submit_button_{$form["id"]}'>{$form["button"]["text"]}</button>";
}
add_filter("gform_submit_button", "jtd_change_gform_submit_btn", 10, 2);


add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

/**
 *  Set Yoast SEO plugin metabox priority to low
 */
function jtd_lowpriority_yoastseo() {
  return 'low';
}
add_filter( 'wpseo_metabox_prio', 'jtd_lowpriority_yoastseo' );




/*
Usage:
	$frag = new JTD_Fragment_Cache( 'unique-key', 3600 ); // Second param is TTL
	if ( !$frag->output() ) { // NOTE, testing for a return of false
		functions_that_do_stuff_live();
		these_should_echo();
		// IMPORTANT
		$frag->store();
		// YOU CANNOT FORGET THIS. If you do, the site will break.
	}
*/

class JTD_Fragment_Cache {
	const GROUP = 'jtd-fragments';
	var $key;
	var $ttl;

	public function __construct( $key, $ttl ) {
		$this->key = $key;
		$this->ttl = $ttl;
	}

	public function output() {
		$output = wp_cache_get( $this->key, self::GROUP );
		if ( !empty( $output ) ) {
			// It was in the cache
			echo $output;
			return true;
		} else {
			ob_start();
			return false;
		}
	}

	public function store() {
		$output = ob_get_flush(); // Flushes the buffers
		wp_cache_add( $this->key, $output, self::GROUP, $this->ttl );
	}
}