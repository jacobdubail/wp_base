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
	}


	function custom_logo() {
		echo '<style type="text/css"> h1 a { background-image:url('.get_template_directory_uri().'/images/logo_admin.png)  !important; } </style>';
	}

	function change_url() {
		echo bloginfo( 'url' );
	}

	function change_url_title() {
		echo get_option( 'blogname' );
	}

}
$jtd_login = new jtd_login();
?>
