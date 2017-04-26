<?php
/*-----------------------------------------------------------------------------------*/
/* Functions for menus
/*-----------------------------------------------------------------------------------*/
class jtd_shortcodes {
	public function __construct() {

		add_filter( 'the_content', array( &$this, 'shortcode_empty_paragraph_fix' ) );
		add_shortcode( 'email', array( &$this, 'email_encode_' ) );

	}


	function shortcode_empty_paragraph_fix( $content ) {
		$array = array (
			'<p>['    => '[',
			']</p>'   => ']',
			']<br />' => ']'
		);

		$content = strtr( $content, $array );

		return $content;
	}


	function email_encode( $atts, $content ) {
		return '<a href="'.antispambot( "mailto:".$content ).'">'.antispambot( $content ).'</a>';
	}


}// end class
$jtd_shortcodes = new jtd_shortcodes();
