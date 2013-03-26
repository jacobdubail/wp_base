<?php
/*-----------------------------------------------------------------------------------*/
/* Functions for post types
/*-----------------------------------------------------------------------------------*/
class jtd_post_types {
    public function __construct() {
        add_action( 'init', array( &$this, 'register_films' ) );
    }

    // Register Custom Post Type
    function register_films() {
        $labels = array(
            'name'                => _x( 'Films', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Film', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Film', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Film:', 'text_domain' ),
            'all_items'           => __( 'All Films', 'text_domain' ),
            'view_item'           => __( 'View Film', 'text_domain' ),
            'add_new_item'        => __( 'Add New Film', 'text_domain' ),
            'add_new'             => __( 'New Film', 'text_domain' ),
            'edit_item'           => __( 'Edit Film', 'text_domain' ),
            'update_item'         => __( 'Update Film', 'text_domain' ),
            'search_items'        => __( 'Search films', 'text_domain' ),
            'not_found'           => __( 'No films found', 'text_domain' ),
            'not_found_in_trash'  => __( 'No films found in Trash', 'text_domain' ),
        );
    
        $args = array(
            'label'               => __( 'film', 'text_domain' ),
            'description'         => __( 'Film information pages', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 
                                        'title',
                                        'editor',
                                        'excerpt',
                                        'author',
                                        'thumbnail',
                                        'comments',
                                        'trackbacks',
                                        'revisions',
                                        'custom-fields',
                                        'page-attributes',
                                        'post-formats'
                                    ),
            'taxonomies'          => array( 'people' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            //'menu_icon'           => '',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'query_var'           => 'film',
            'capability_type'     => 'post',
        );
    
        register_post_type( 'film', $args );
    }



}
$jtd_post_types = new jtd_post_types();