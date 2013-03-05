<?php 


/**
 * constant
 **/
define('PATH', STYLESHEETPATH);
define('FUNCTIONS_PATH', PATH . '/inc/');

//require_once(FUNCTIONS_PATH . 'language.php');
require_once (FUNCTIONS_PATH . 'login.php');
require_once (FUNCTIONS_PATH . 'admin.php');
//require_once (FUNCTIONS_PATH . 'dashboard.php');
//require_once (FUNCTIONS_PATH . 'menu.php');

require_once (FUNCTIONS_PATH . 'social.php');
require_once (FUNCTIONS_PATH . 'images.php');
require_once (FUNCTIONS_PATH . 'comments.php');
require_once (FUNCTIONS_PATH . 'shortcodes.php');
//require_once (FUNCTIONS_PATH . 'shortcodes-images.php');
require_once (FUNCTIONS_PATH . 'widget.php');



      
  register_sidebar(array(
    'name' => 'Sidebar Widgets',
    'id'   => 'sidebar-widgets',
    'description'   => 'These are widgets for the sidebar.',
    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ));

  add_theme_support('nav-menus');
  add_action( 'init', 'register_my_menu' );
  function register_my_menu() {
    register_nav_menu( 'main-nav', __( 'Main Nav' ) );
  }
  
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'automatic_feed_links' );
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
  
      
  function category_id_class($classes) {
    global $post;
    foreach( ( get_the_category($post->ID) ) as $category )
      $classes [] = 'cat-' . $category->cat_ID . '-id';
    return $classes;
  }
  add_filter('post_class', 'category_id_class');
  add_filter('body_class', 'category_id_class');

  add_action('wp_enqueue_scripts', 'base_register_scripts');
  function base_register_scripts() {
    wp_deregister_script('jquery');

    $jQuery = "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js";
    $test   = @fopen($jQuery,'r'); 
    if ( $test === false ) { 
      $jQuery = get_template_directory_uri() . '/js/jquery.min.js';
    }

    $jquery_url = 'http://ajax.googleapis.com/ajax/libs/jquery/1.91/jquery.min.js';      
    $resp       = wp_remote_head($jquery_url);
    if ( is_wp_error($resp) || 200 != $resp['response']['code'] ) {
      $jquery_url = get_template_directory_uri() . '/js/jquery.min.js';  
    }

    wp_register_script( 'jquery', $jquery_url, false, '1.9.1', false );
    wp_enqueue_script( 'jquery' );

     
    wp_register_script('base_plugins', '/wp-content/themes/base/js/plugins.min.js', array('jquery'), '1', true );
    wp_enqueue_script('base_plugins');
    
    wp_register_script('base_functions', '/wp-content/themes/base/js/script.min.js', array('jquery', 'base_plugins'), '1', true );
    wp_enqueue_script('base_functions');    
    
    wp_register_style('base_styles', '/wp-content/themes/base/css/style.css', '', '1', 'all');
    wp_enqueue_style('base_styles');
    
  }

  function complete_version_removal() { return ''; }
  add_filter('the_generator', 'complete_version_removal');
  remove_filter('pre_user_description',    'wp_filter_kses');
  remove_filter('pre_comment_content',     'wp_rel_nofollow');
  add_filter   ('get_comment_author_link', 'xwp_dofollow');
  add_filter   ('post_comments_link',      'xwp_dofollow');
  add_filter   ('comment_reply_link',      'xwp_dofollow');
  add_filter   ('comment_text',            'xwp_dofollow');
  
  function jtd_allow_rel() {
    global $allowedtags;
    $allowedtags['a']['rel'] = array ();
  }
  add_action( 'wp_loaded', 'jtd_allow_rel' );
  


add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
      global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

  if($is_lynx) $classes[]       = 'lynx';
  elseif($is_gecko) $classes[]  = 'gecko';
  elseif($is_opera) $classes[]  = 'opera';
  elseif($is_NS4) $classes[]    = 'ns4';
  elseif($is_safari) $classes[] = 'safari';
  elseif($is_chrome) $classes[] = 'chrome';
  elseif($is_IE) $classes[]     = 'ie';
  else $classes[]               = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
  if($is_ipad) $classes[]   = 'ipad';
	return $classes;
}



function jtd_comment_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li class="media">
  <div class="pull-left">
      <?php echo get_avatar( $comment, '64' ); ?>
  </div>
  <div class="media-body">
      <?php printf(__('<h4 class="media-heading">%s <span class="says">says:</span></h4>'), get_comment_author_link()); ?>
  
      <?php if ($comment->comment_approved == '0') : ?>
          <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.'); ?></p>
      <?php endif; ?>

      <?php comment_text() ?>

      <p class="reply">
          <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
      </p>
  </div>
<?php
} // end comment

add_filter('get_avatar','change_avatar_css');
function change_avatar_css($class) {
    $class = str_replace("class='avatar", "class='author_gravatar media-object ", $class) ;
    return $class;
}
