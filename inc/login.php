<?php
/*-----------------------------------------------------------------------------------*/
/* Functions for comments
/*-----------------------------------------------------------------------------------*/
class jtd_login {
	public function jtd_login() {
		// Change logo
		add_action( 'login_head',  array( &$this, 'custom_logo' ) );

		// Change logo link url
		add_action( 'login_headerurl',  array( &$this, 'change_url' ) );

		// Change logo link title
		add_action( 'login_headertitle',  array( &$this, 'change_url_title' ) );

		add_filter ( 'login_errors', array( &$this, 'failed_login' ) );
	}


	function custom_logo() {
		echo '<style type="text/css"> h1 a { background-image:url('.get_template_directory_uri().'/images/logo_admin.png)  !important; } </style>';
	}

	function change_url() {
		return home_url();
	}

	function change_url_title() {
		return get_bloginfo('name');
	}

	function failed_login () {
    return 'the login information you have entered is incorrect.';
	}


}
$jtd_login = new jtd_login();
?>
