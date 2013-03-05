<?php


$options_pages   = array();

$options_pages[] = array(
	'id'   => 'sandbox_theme_display_options',
	'page' => array(
		'id'       => 'sandbox_theme_options',
		'user'     => 'administrator',
		'title'    => 'Sandbox Theme',
		'callback' => 'sandbox_theme_display'
	),
	'sections'=>array(
		array(
			'id'     => 'general_settings_section',
			'title'  => 'Display Options',
			'desc'   => '<p>Select which areas of content you wish to display.</p>',
			'fields' => array(
				array(
					'label' => 'Header',
					'desc'  => 'Activate this setting to display the header.',
					'id'    => 'show_header',
					'type'  => 'checkbox'
				),
				array(
					'label' => 'Content',
					'desc'  => 'Activate this setting to display the content.',
					'id'    => 'show_content',
					'type'  => 'checkbox'
				),
				array(
					'label' => 'Footer',
					'desc'  => 'Activate this setting to display the footer.',
					'id'    => 'show_footer',
					'type'  => 'checkbox'
				),
			)
		)
	)
);





foreach ( $options_pages as $o_page ) {
	$my_page = new jtd_option_page( $o_page );

}

class jtd_option_page {
	protected $_o_page;

	protected $_section_description;

	public function jtd_option_page( $o_page ) {
		$this->_o_page = $o_page;
		add_action( 'admin_menu', array( &$this, 'add_page' ) );
		add_action( 'admin_init', array( &$this, 'add_options' ) );
	}

	function add_page() {
		add_menu_page(
			$this->_o_page['page']['title'],
			$this->_o_page['page']['title'],
			$this->_o_page['page']['user'],
			$this->_o_page['page']['id'],
			array( &$this, 'display_page' )
		);

	} // end sandbox_example_theme_menu


	function display_page() {?>
		<div class="wrap">

			<div id="icon-themes" class="icon32"></div>
			<h2><?php echo $this->_o_page['page']['title']; ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php settings_fields( $this->_o_page['id'] ); ?>
				<?php do_settings_sections( $this->_o_page['id'] ); ?>
				<?php submit_button(); ?>
			</form>

		</div><!-- /.wrap -->
	<?php
	} // end sandbox_theme_display


	function add_options() {
		if ( false == get_option( $this->_o_page['id'] ) ) {
			add_option( $this->_o_page['id'] );
		}

		foreach ( $this->_o_page['sections'] as $section ) {

			// First, we register a section. This is necessary since all future options must belong to a
			$this->_section_description=$section['desc'];
			add_settings_section(
				$section['id'],
				$section['title'],
				array( &$this, 'show_section_description' ),
				$this->_o_page['id']
			);



			foreach ( $section['fields'] as $field ) {
				// Next, we'll introduce the fields for toggling the visibility of content elements.
				add_settings_field(
					$field['id'],
					$field['label'],
					array( &$this, 'show_field' ),
					$this->_o_page['id'] ,
					$section['id'],
					$field
				);
			}
		}

		// Finally, we register the fields with WordPress
		register_setting(
			$this->_o_page['id'],
			$this->_o_page['id']
		);

	}

	function show_section_description() {
		echo $this->_section_description;
	}

	function show_field( $field ) {

		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue' ) );
		add_action( 'admin_head', array( &$this, 'add_custom_scripts' ) );

		// First, we read the options collection
		$options = get_option( $this->_o_page['id'] );
		$option=$options[$field['id']];
		switch ( $field['type'] ) {

			// text
		case 'text':
			echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$option.'" size="30" />
		            <br /><span class="description">'.$field['desc'].'</span>';
			break;


			// textarea
		case 'textarea':
			echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$option.'</textarea>
		            <br /><span class="description">'.$field['desc'].'</span>';
			break;


			// checkbox
		case 'checkbox':
			echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ', $option ? ' checked="checked"' : '', '/>
		            <label for="'.$field['id'].'">'.$field['desc'].'</label>';
			break;


			// select
		case 'select':
			echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
			foreach ( $field['options'] as $option ) {
				echo '<option', $option == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
			}
			echo '</select><br /><span class="description">'.$field['desc'].'</span>';
			break;


			// radio
		case 'radio':
			foreach ( $field['options'] as $option ) {
				echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ', $option == $option['value'] ? ' checked="checked"' : '', ' />
			                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
			}
			break;


			// checkbox_group
		case 'checkbox_group':
			foreach ( $field['options'] as $option ) {
				echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"', $option && in_array( $option['value'], $option ) ? ' checked="checked"' : '', ' />
			                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
			}
			echo '<span class="description">'.$field['desc'].'</span>';
			break;


			// tax_select
		case 'tax_select':
			echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
		                <option value="">Select One</option>'; // Select One
			$terms = get_terms( $field['id'], 'get=all' );
			$selected = wp_get_object_terms( $post->ID, $field['id'] );
			foreach ( $terms as $term ) {
				if ( !empty( $selected ) && !strcmp( $term->slug, $selected[0]->slug ) )
					echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>';
				else
					echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
			}
			$taxonomy = get_taxonomy( $field['id'] );
			echo '</select><br /><span class="description"><a href="'.get_bloginfo( 'home' ).'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Manage '.$taxonomy->label.'</a></span>';
			break;


			// post_list
		case 'post_list':
			$items = get_posts( array (
					'post_type' => $field['post_type'],
					'posts_per_page' => -1
				) );
			echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
		                <option value="">Select One</option>'; // Select One
			foreach ( $items as $item ) {
				echo '<option value="'.$item->ID.'"', $option == $item->ID ? ' selected="selected"' : '', '>'.$item->post_type.': '.$item->post_title.'</option>';
			} // end foreach
			echo '</select><br /><span class="description">'.$field['desc'].'</span>';
			break;


			// date
		case 'date':
			echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$option.'" size="30" />
						<br /><span class="description">'.$field['desc'].'</span>';
			break;


			// slider
		case 'slider':
			$value = $option != '' ? $option : '0';
			echo '<div id="'.$field['id'].'-slider"></div>
			            <input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$value.'" size="5" />
			            <br /><span class="description">'.$field['desc'].'</span>';
			break;


			// image
		case 'image':
			$image = get_template_directory_uri().'/images/admin-meta-image.png';
			echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
			if ( $option ) { $image = wp_get_attachment_image_src( $option, 'medium' ); $image = $image[0]; }
			echo    '<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$option.'" />
		                    <img src="'.$image.'" class="custom_preview_image" alt="" /><br />
		                        <input class="custom_upload_image_button button" type="button" value="Choose Image" />
		                        <small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>
		                        <br clear="all" /><span class="description">'.$field['desc'].'';
			break;


			// repeatable
		case 'repeatable':
			echo '<a class="repeatable-add button" href="#">+</a>
		                <ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
			$i = 0;
			if ( $option ) {
				foreach ( $option as $row ) {
					echo '<li><span class="sort hndle">|||</span>
		                            <input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
		                            <a class="repeatable-remove button" href="#">-</a></li>';
					$i++;
				}
			} else {
				echo '<li><span class="sort hndle">|||</span>
		                        <input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
		                        <a class="repeatable-remove button" href="#">-</a></li>';
			}
			echo '</ul>
		            <span class="description">'.$field['desc'].'</span>';
			break;



		} //end switch

	} // end sandbox_toggle_header_callback


	function enqueue() {
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_style( 'jquery-ui-custom', get_template_directory_uri().'/css/jquery-ui-custom.css' );
		wp_enqueue_script( 'admin-meta', get_template_directory_uri().'/js/libs/admin-meta.js' );
	}

	function add_custom_scripts() {
		global $custom_meta_fields, $post;

		$output = '<script type="text/javascript">
	                jQuery(function() {';

		foreach ( $this->_meta['fields'] as $field ) { // loop through the fields looking for certain types
			if ( $field['type'] == 'date' )
				$output .= 'jQuery(".datepicker").datepicker();';

			if ( $field['type'] == 'slider' ) {
				$value = get_post_meta( $post->ID, $field['id'], true );


				if ( $value == '' ) $value = $field['min'];
				$output .= '
			                jQuery( "#'.$field['id'].'-slider" ).slider({
			                    value: '.$value.',
			                    min: '.$field['min'].',
			                    max: '.$field['max'].',
			                    step: '.$field['step'].',
			                    slide: function( event, ui ) {
			                        jQuery( "#'.$field['id'].'" ).val( ui.value );
			                    }
			                });';
			}

		}
		$output .= '});</script>';

		echo $output;
	}

}


?>
