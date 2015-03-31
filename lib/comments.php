<?php
/*-----------------------------------------------------------------------------------*/
/* Functions for comments
/*-----------------------------------------------------------------------------------*/
class jtd_comments {
	public function jtd_comments() {
		// Enable threaded comments
		add_action( 'get_header', array( &$this, 'enable_threaded_comments' ) );
	}


	function enable_threaded_comments() {
		if ( is_singular() and comments_open() and ( get_option( 'thread_comments' ) == 1 ) ) {
			wp_enqueue_script( 'comment-reply' );
		} else {
			wp_deregister_script( 'comment-reply' );
		}
	}
}
$jtd_comments = new jtd_comments();
