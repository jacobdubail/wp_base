<?php

/* Sublime Snippet to Auto-populate keys */
define_license_keys

// Set ACF 5 license key on theme activation. Stick in your functions.php or equivalent.
function jtd_acf_auto_set_license_keys() {

  if ( !get_option('acf_pro_license') && defined('ACF_5_KEY') ) {

    $save = array(
			'key'	=> ACF_5_KEY,
			'url'	=> home_url()
		);

		$save = maybe_serialize($save);
		$save = base64_encode($save);

    update_option('acf_pro_license', $save);
  }
}
add_action('after_switch_theme', 'jtd_acf_auto_set_license_keys');


if( function_exists('register_field_group') ):

register_field_group(array (
	'key' => 'group_54ff6660ea8ee',
	'title' => 'Options',
	'fields' => array (
		array (
			'key' => 'field_54ff667aa905c',
			'label' => 'Social',
			'name' => 'social',
			'prefix' => '',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Add Network',
			'sub_fields' => array (
				array (
					'key' => 'field_54ff668da905d',
					'label' => 'Link',
					'name' => 'link',
					'prefix' => '',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => 'http://google.com',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_54ff6691a905e',
					'label' => 'Network',
					'name' => 'network',
					'prefix' => '',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
						'facebook' => 'facebook',
						'twitter' => 'twitter',
						'linkedin' => 'linkedin',
						'google-plus' => 'google-plus',
						'pinterest' => 'pinterest',
						'instagram' => 'instagram',
						'youtube' => 'youtube',
						'rss' => 'rss',
					),
					'default_value' => array (
						'' => '',
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'disabled' => 0,
					'readonly' => 0,
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

endif;


if( function_exists('register_field_group') ):

register_field_group(array (
	'key' => 'group_552ef11616b08',
	'title' => 'Slides',
	'fields' => array (
		array (
			'key' => 'field_552ef11f82769',
			'label' => 'Slides',
			'name' => 'slides',
			'prefix' => '',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => '',
			'layout' => 'block',
			'button_label' => 'Add Slide',
			'sub_fields' => array (
				array (
					'key' => 'field_552ef12a8276a',
					'label' => 'Image',
					'name' => 'image',
					'prefix' => '',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array (
					'key' => 'field_552ef24c8276b',
					'label' => 'Title',
					'name' => 'title',
					'prefix' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_552ef2508276c',
					'label' => 'Text',
					'name' => 'text',
					'prefix' => '',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => 2,
					'new_lines' => 'br',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_552ef2548276d',
					'label' => 'Link',
					'name' => 'link',
					'prefix' => '',
					'type' => 'page_link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array (
						0 => 'post',
						1 => 'page',
						2 => 'resources',
					),
					'taxonomy' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_552ef2638276e',
					'label' => 'Link Label',
					'name' => 'link_label',
					'prefix' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => 'Learn More',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_552ef26e8276f',
					'label' => 'Gradient',
					'name' => 'gradient',
					'prefix' => '',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
						'base' => 'Orange',
						'secondary' => 'Yellow',
						'tertiary' => 'Brown',
					),
					'default_value' => array (
						'' => '',
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'disabled' => 0,
					'readonly' => 0,
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'the_content',
	),
));

endif;
