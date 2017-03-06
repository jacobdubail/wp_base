<?php

/* Sublime Snippet to Auto-populate keys */
define_license_keys

// Set ACF 5 license key on theme activation. Stick in your functions.php or equivalent.
function jtd_acf_auto_set_license_keys() {

  if ( !get_option('acf_pro_license') && defined('ACF_5_KEY') ) {

    $save = array(
			'key'	=> ACF_5_KEY,
			'url'	=> home_url()
		);

		$save = maybe_serialize($save);
		$save = base64_encode($save);

    update_option('acf_pro_license', $save);
  }
}
add_action('after_switch_theme', 'jtd_acf_auto_set_license_keys');


add_action('wpmdb_migration_complete', 'jtd_acf_punch_a_license');
function jtd_acf_punch_a_license() {
	if ( ! get_option('acf_pro_license') ) {
		jtd_acf_auto_set_license_keys();
	}
}
