<?php
/*-----------------------------------------------------------------------------------*/
/* Functions shotcodes images
/*-----------------------------------------------------------------------------------*/
class jtd_shortcodes_images {
	public function __construct() {
		// Snapshot of a website using wordpress.com
		add_shortcode( "snapshot", array( &$this, 'website_snapshot' ) );
	}


	function website_snapshot( $atts, $content = null ) {
		extract( shortcode_atts( array(
					"snap"   => 'http://s.wordpress.com/mshots/v1/',
					"url"    => 'http://jacobdubail.com',
					"alt"    => 'My image',
					"width"  => '400', // width
					"height" => '300' // height
				), $atts ) );

		$img = '<img src="' . $snap . '' . urlencode( $url ) . '?w=' . $width . '&h=' . $height . '" alt="' . $alt . '"/>';
		return $img;
	}// end website snapshot

}// end class
$jtd_shortcodes_images = new jtd_shortcodes_images();
?>
