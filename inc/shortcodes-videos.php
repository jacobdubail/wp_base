<?php
/*-----------------------------------------------------------------------------------*/
/* Functions for shorcode videos
/*-----------------------------------------------------------------------------------*/
class jtd_shortcodes_videos {
	public function jtd_shortcodes_images() {
		// Snapshot of a website using wordpress.com
		add_shortcode( "jtd_vimeo", array( &$this, 'vimeo' ) );
		add_shortcode( "jtd_youtube", array( &$this, 'youtube' ) );
	}


	function jtd_vimeo( $atts, $content = null ) {
		extract( shortcode_atts( array(
					"id"     => '',
					"height" => '400',
					"width"  => '600'
				), $atts ) );
		return '<iframe src="http://player.vimeo.com/video/' . $id . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '" frameborder="0"></iframe>';
	}


	function jtd_youtube( $atts, $content = null ) {
		extract( shortcode_atts( array(
					"id"     => '',
					"height" => '400',
					"width"  => '600'
				), $atts ) );
		return '<iframe width="' . $width . '" height="' . $height . '" src="http://www.youtube.com/embed/' . $id . '?rel=0" frameborder="0" allowfullscreen></iframe>';
	}


}// end class
$jtd_shortcodes_videos = new jtd_shortcodes_videos();
?>