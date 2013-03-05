<?php
/*-----------------------------------------------------------------------------------*/
/* Functions for menus
/*-----------------------------------------------------------------------------------*/
class jtd_social {
	public function jtd_social() {
		add_action( 'wp_head', array( &$this, 'opengraph_for_posts' ) );
		add_action( 'wp_head', array( &$this, 'googleplus' ) );
	}
	function opengraph_for_posts() {
		if ( is_singular() ) {
			global $post;
			setup_postdata( $post );
			$output  = '<meta property="og:type" content="article" />' . "\n";
			$output .= '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '" />' . "\n";
			$output .= '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
			$output .= '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '" />' . "\n";
			if ( has_post_thumbnail() ) {
				$imgsrc  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
				$output .= '<meta property="og:image" content="' . $imgsrc[0] . '" />' . "\n";
			}
			echo $output;
		}
	}

	function googleplus() {
	    if ( is_singular() ) {
	        $gplus_link = get_the_author_meta( 'googleplus', get_current_user_id() );
	        if ( $gplus_link )
	            echo '<link rel="author" href="' . $gplus_link . '" />';
	    }
	}


	/**
	 * Display a pinterest button
	 * <script src="http://assets.pinterest.com/js/pinit.js"></script> 
	 *
	 * @return null
	 */
	function pinterest_button() {
		global $post;
		setup_postdata( $post );
		$thumb  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
		$output = '<a href="http://pinterest.com/pin/create/button/?url=' . the_permalink() . '&media=' . $thumb['0'] . '&description=' . the_title() .'" class="pin-it-button" count-layout="horizontal">Pin It</a>';
		echo $output;
	}

}
$jtd_social = new jtd_social();
?>
