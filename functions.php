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

