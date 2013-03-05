<?php
/*-----------------------------------------------------------------------------------*/
/* Functions for admin
/*-----------------------------------------------------------------------------------*/
class jtd_admin {
	public function jtd_admin() {

		// Remove notifications for non admins
		$this->remove_notifications();

		add_filter( 'admin_footer_text',  array( &$this, 'change_admin_footer' ) );
		add_action( 'pre_ping', array( &$this, 'no_self_ping' ) );
		add_filter( 'mce_buttons',  array( &$this, 'enable_more_buttons' ) );

		if ( is_user_logged_in() && !get_current_user_id() == 1 ) {
        add_action( 'admin_menu', array( &$this, 'remove_menus' ) );
        add_action( 'admin_menu', array( &$this, 'remove_dashboard_widgets' ) );
      }

    add_action( 'admin_menu', array( &$this, 'remove_menus_everyone' ) );
    add_action( 'admin_init', array( &$this, 'remove_theme_editor' ) );
    add_action( 'admin_menu', array( &$this, 'relabel_posts_menu' ));
    add_action( 'init', array( &$this, 'relabel_posts' ));
    add_filter( 'user_contactmethods', array( &$this, 'tweak_profile_fields' ) );

	}

	function remove_notifications() {
		global $user_login;
		get_currentuserinfo();
		if ( !current_user_can( 'activate_plugins' ) ) {
			add_action( 'init', array( &$this, 'remove_wp_check' ) );
			add_filter( 'pre_option_update_core', array( &$this, 'return null' ) );
		}
	}
	function remove_wp_check() {
		remove_action( 'init', 'wp_version_check' );
	}
	function return_null() {
		return null;
	}


	function add_cpt_to_dropdown( $pages ) {
		$cpt   = get_posts( array( 'post_type' => 'portfolio' ) );
		$pages = array_merge( $pages, $cpt );
		return $pages;
	}


	function change_admin_footer() {
		echo 'Site developed by <a href="http://jacobdubail.com">Jacob Dubail</a>';
	}

	function no_self_ping( &$links ) {
		$home = get_option( 'home' );
		foreach ( $links as $l => $link )
			if ( 0 === strpos( $link, $home ) )
				unset( $links[$l] );
	}

	function enable_more_buttons( $buttons ) {
		$buttons[] = 'hr';

		/*
		Repeat with any other buttons you want to add, e.g.
		  $buttons[] = 'fontselect';
		  $buttons[] = 'sup';
		*/
		return $buttons;
	}


	 function remove_menus() {
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'options-general.php' );
        remove_menu_page( 'plugins.php' );

        remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
        remove_submenu_page( 'options-general.php', 'options-permalink.php' );
    }
    function remove_menus_everyone() {
        remove_menu_page( 'link-manager.php' );
    }
    // This function removes dashboard widgets
    function remove_dashboard_widgets() {
      global $wp_meta_boxes;

      unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
      unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
      unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
      unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
      unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    }
    // This function removes the theme editor
    function remove_theme_editor() {
      remove_submenu_page( 'themes.php', 'theme-editor.php' );
    }
    /**
     * Relabel "Posts" to a much more user friendly "Articles"
     * Handles all the variations as well
     */
    public function relabel_posts() {
      global $wp_post_types;

      $wp_post_types['post']->labels->name               = 'Articles';
      $wp_post_types['post']->labels->singular_name      = 'Article';
      $wp_post_types['post']->labels->add_new            = 'Add New';
      $wp_post_types['post']->labels->add_new_item       = 'Add New Article';
      $wp_post_types['post']->labels->edit_item          = 'Edit Article';
      $wp_post_types['post']->labels->new_item           = 'New Article';
      $wp_post_types['post']->labels->view_item          = 'View Article';
      $wp_post_types['post']->labels->search_items       = 'Search Articles';
      $wp_post_types['post']->labels->not_found          = 'No articles found';
      $wp_post_types['post']->labels->not_found_in_trash = 'No articles found in Trash';
      $wp_post_types['post']->labels->all_items          = 'All Articles';
      $wp_post_types['post']->labels->menu_name          = 'Articles';
      $wp_post_types['post']->labels->name_admin_bar     = 'Article';
    }
    /**
     * Update the admin menu to use Articles instead of News
     * This will automatically pull in terms updated from $wp_post_types['post']->labels
     */
    public function relabel_posts_menu() {
      global $menu, $submenu, $wp_post_types;

      $menu[5][0]   = $wp_post_types['post']->labels->name;
      $submenu['edit.php'][5][0]  = $wp_post_types['post']->labels->all_items;
      $submenu['edit.php'][10][0] = $wp_post_types['post']->labels->add_new;
    }

    function tweak_profile_fields( $contactmethods ) {
	    // Add Google Profiles
	    $contactmethods['google_profile'] = 'Google Profile URL';
	    $contactmethods['googleplus']     = 'Google+';
	    $contactmethods['facebook']       = 'Facebook';
	    $contactmethods['twitter']        = 'Twitter';
	    unset($contactmethods['aim']);
	    unset($contactmethods['yim']);    
	    unset($contactmethods['jabber']);
	    return $contactmethods;
	  }
	  

}
$jtd_admin = new jtd_admin();
?>
