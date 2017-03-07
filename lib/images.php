<?php
/*-----------------------------------------------------------------------------------*/
/* Functions for images
/*-----------------------------------------------------------------------------------*/
// class jtd_images {
// 	public function __construct() {

// 		// Remove p tags on images
// 		add_filter( 'the_content', array( &$this, 'filter_ptags_on_images' ) );

// 		// add image size
// 		//add_image_size( "poster", 188, 280, true );
// 	}


// 	function filter_ptags_on_images( $content ) {
// 		return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
// 	}
// }
// $jtd_images = new jtd_images();


require_once FUNCTIONS_PATH . '/image-processing-queue/vendor/a5hleyrich/wp-background-processing/classes/wp-async-request.php';
require_once FUNCTIONS_PATH . '/image-processing-queue/vendor/a5hleyrich/wp-background-processing/classes/wp-background-process.php';
require_once FUNCTIONS_PATH . '/image-processing-queue/includes/class-ipq-process.php';
require_once FUNCTIONS_PATH . '/image-processing-queue/includes/class-image-processing-queue.php';
require_once FUNCTIONS_PATH . '/image-processing-queue/includes/ipq-template-functions.php';

Image_Processing_Queue::instance();

/**
echo ipq_get_theme_image( $post_id, array(
		array( 600, 400, false ),
		array( 1280, 720, false ),
		array( 1600, 1067, false ),
	),
	array(
		'class' => 'header-banner'
	)
);
*/