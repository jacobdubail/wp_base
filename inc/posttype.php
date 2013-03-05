<?php
/*-----------------------------------------------------------------------------------*/
/* Functions for post types
/*-----------------------------------------------------------------------------------*/
class jtd_posttype {
    public function jtd_posttype() {
        add_action( 'init', array( &$this, 'register' ) );
    }

    function register() {

        $args = array(
            'labels' => array(
                'name'          => __( 'Posttype' ),
                'singular_name' => __( 'Posttype' )

            ),
            'public'          => true,
            'show_in_menu'    => true,
            'capability_type' => 'page',
            'has_archive'     => true,
            'rewrite'         => true,
            'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt' )
        );

        register_post_type( 'posttype' , $args );
    }


}
$jtd_posttype = new jtd_posttype();
?>
