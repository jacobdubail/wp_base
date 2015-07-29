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

add_action('wp_enqueue_scripts', 'base_register_scripts');
function base_register_scripts() {
	wp_enqueue_script( 'jquery' );

	$vers = ".01";

	wp_register_script('base_plugins', get_stylesheet_directory_uri() . '/js/plugins.min.js', false, $vers, true );
	wp_enqueue_script('base_plugins');

	wp_register_script('base_functions', get_stylesheet_directory_uri() . '/js/main.min.js', array('base_plugins'), $vers, true );
	wp_enqueue_script('base_functions');

	wp_register_style('base_styles', get_stylesheet_directory_uri() . '/css/main.css', '', $vers, 'all');
	wp_enqueue_style('base_styles');

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