<?php
/*-----------------------------------------------------------------------------------*/
/* Functions for menus
/*-----------------------------------------------------------------------------------*/
class jtd_language {
	public function __construct() {



		//load the text domain for localization
		add_action( 'after_theme_setup', array( &$this, 'load_domain' ) );
	}


	function load_domain() {
		$lang_dir = get_template_directory() . '/lang';
		load_theme_textdomain( 'jtd', $lang_dir );
	} // end load_domain

}// end class
$jtd_language = new jtd_language();
?>