<?php
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
