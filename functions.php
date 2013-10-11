<?php 


/**
 * constant
 **/
define('PATH', get_stylesheet_directory());
define('FUNCTIONS_PATH', PATH . '/lib/');

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
require_once (FUNCTIONS_PATH . 'sidebars.php');
require_once (FUNCTIONS_PATH . 'widget.php');

//require_once (FUNCTIONS_PATH . 'posttypes.php');



  add_action('wp_enqueue_scripts', 'base_register_scripts');
  function base_register_scripts() {
    wp_enqueue_script( 'jquery' );

    wp_register_script('base_plugins', get_stylesheet_directory_uri() . '/js/plugins.min.js', false, '1', true );
    wp_enqueue_script('base_plugins');
    
    wp_register_script('base_functions', get_stylesheet_directory_uri() . '/js/script.min.js', array('base_plugins'), '1', true );
    wp_enqueue_script('base_functions');    
    
    wp_register_style('base_styles', get_stylesheet_directory_uri() . '/css/style.css', '', '1', 'all');
    wp_enqueue_style('base_styles');
    
  }

      
  if ( ! isset( $content_width ) ) $content_width = 1200;


  function category_id_class( $classes ) {
    global $post;
    if ( ! empty( $post ) ) {
      $cats = get_the_category($post->ID);
      if ( ! empty( $cats ) ) {
        foreach( $cats as $cat )
          $classes [] = 'cat-' . $cat->cat_ID . '-id';
      }
    }
    return $classes;
  }
  add_filter('post_class', 'category_id_class');
  add_filter('body_class', 'category_id_class');

      
  add_theme_support( 'automatic-feed-links' );
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
  

  function complete_version_removal() { return ''; }
  add_filter('the_generator', 'complete_version_removal');
  remove_filter('pre_user_description',    'wp_filter_kses');
  remove_filter('pre_comment_content',     'wp_rel_nofollow');
  
  function jtd_allow_rel() {
    global $allowedtags;
    $allowedtags['a']['rel'] = array ();
  }
  add_action( 'wp_loaded', 'jtd_allow_rel' );
  


add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
      global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone, $is_ipad;

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



$customHeaderDefaults = array(
  'default-image'          => get_template_directory_uri() . '/images/logo.png',
  'random-default'         => false,
  'width'                  => 202,
  'height'                 => 72,
  'flex-height'            => false,
  'flex-width'             => false,
  'default-text-color'     => '',
  'header-text'            => '',
  'uploads'                => true,
  'wp-head-callback'       => '',
  'admin-head-callback'    => '',
  'admin-preview-callback' => '',
);

add_theme_support( 'custom-header', $customHeaderDefaults );


add_filter("gform_submit_button", "jtd_change_gform_submit_btn", 10, 2);
function jtd_change_gform_submit_btn($button, $form){
  return "<button class='btn' id='gform_submit_button_{$form["id"]}'>{$form["submit"]}</button>";
}





/* PLACE HOLDER SUPPORT FOR GRAVITY FORMS */
/* Add a custom field to the field editor (See editor screenshot) */
add_action("gform_field_standard_settings", "jtd_gform_placeholders", 10, 2);

function jtd_gform_placeholders($position, $form_id){

  // Create settings on position 25 (right after Field Label)
  if ( $position == 25 ) {
  ?>
      
    <li class="admin_label_setting field_setting" style="display: list-item; ">
      <label for="field_placeholder">Placeholder Text
        <!-- Tooltip to help users understand what this field does -->
        <a href="javascript:void(0);" class="tooltip tooltip_form_field_placeholder" tooltip="&lt;h6&gt;Placeholder&lt;/h6&gt;Enter the placeholder/default text for this field.">(?)</a>  
      </label>
      <input type="text" id="field_placeholder" class="fieldwidth-3" size="35" onkeyup="SetFieldProperty('placeholder', this.value);">
    </li>
  <?php
  }
}

/* Now we execute some javascript technicalitites for the field to load correctly */

add_action("gform_editor_js", "jtd_gform_editor_js");
function jtd_gform_editor_js(){
?>
  <script>
    //binding to the load field settings event to initialize the checkbox
    jQuery(document).bind("gform_load_field_settings", function(event, field, form){
      jQuery("#field_placeholder").val(field["placeholder"]);
    });
  </script>

<?php
}

/* We use jQuery to read the placeholder value and inject it to its field */
add_action('gform_pre_render',"jtd_gform_enqueue_scripts", 10, 2);
function jtd_gform_enqueue_scripts($form, $is_ajax=false) {
?>
  <script>
    jQuery(document).bind('gform_post_render',function(){
    <?php
      /* Go through each one of the form fields */
      foreach($form['fields'] as $i=>$field) {
        /* Check if the field has an assigned placeholder */
        if(isset($field['placeholder']) && !empty($field['placeholder'])){
          /* If a placeholder text exists, inject it as a new property to the field using jQuery */
          ?>
          jQuery('#input_<?php echo $form['id']?>_<?php echo $field['id']?>')
            .attr('placeholder',"<?php echo $field['placeholder']?>");
        <?php
        }
      }
    ?>
    });
  </script>
<?php
}

/**
 * Fix Gravity Form Tabindex Conflicts
 * http://gravitywiz.com
 */
add_filter("gform_tabindex", "gform_tabindexer");
function gform_tabindexer() {
    $starting_index = 1000; // if you need a higher tabindex, update this number
    return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}





if(!function_exists('jtd_log')){
  function jtd_log( $message ) {
    if( WP_DEBUG === true && is_user_logged_in() ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  }
}

