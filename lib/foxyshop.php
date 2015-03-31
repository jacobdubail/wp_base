<?php

function base_nav_parent_class($classes, $item) {
	$cpt_name    = 'foxyshop_product';
	$parent_slug = 'products';

	if ( $cpt_name == get_post_type() && ! is_admin() ) {
		$page = get_page_by_title($item->title, OBJECT, 'page');
		if ( isset($page->post_name) && $page->post_name == $parent_slug ) {
			$classes[] = 'current_page_parent';
		}
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'base_nav_parent_class', 10, 2);

function base_remove_blog_active_link_on_cpt($classes,$item,$args) {
	if ( ! is_singular('post') && ! is_category() && ! is_tag()) {
	  $blog_page_id = intval( get_option('page_for_posts') );
	  if ( $blog_page_id != 0 ) {
      if ( $item->object_id == $blog_page_id ) {
				unset( $classes[array_search( 'current_page_parent', $classes )] );
			}
	  }
	}
	return $classes;
}
add_filter('nav_menu_css_class','base_remove_blog_active_link_on_cpt',10,3);
