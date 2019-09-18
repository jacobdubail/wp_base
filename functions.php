<?php

/**
 * constant
 **/
define('PATH', get_stylesheet_directory());
define('FUNCTIONS_PATH', PATH . '/lib/');

require_once (FUNCTIONS_PATH . 'theme_support.php');
require_once (FUNCTIONS_PATH . 'login.php');
require_once (FUNCTIONS_PATH . 'admin.php');
require_once (FUNCTIONS_PATH . 'widget.php');
require_once (FUNCTIONS_PATH . 'nav_walker.php');


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

  wp_register_script('base_functions', get_stylesheet_directory_uri() . '/js/main.min.js', array(), filemtime( get_stylesheet_directory().'/js/main.min.js'), true );
  wp_enqueue_script('base_functions');


  wp_register_style('base_google', 'https://fonts.googleapis.com/css?family=Teko:600&display=swap', '', '', 'all');
  wp_enqueue_style('base_google');

  wp_register_style('base_styles', get_stylesheet_uri(), '', filemtime( get_stylesheet_directory().'/style.css'), 'all');
  wp_enqueue_style('base_styles');

}



if ( function_exists('acf_add_options_page') ) {
  acf_add_options_page();
}


function jtd_include_field_types_gravity_forms( $version ) {
  include_once( FUNCTIONS_PATH . 'acfgfv5.php');
}
add_action('acf/include_field_types', 'jtd_include_field_types_gravity_forms');




// add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );
