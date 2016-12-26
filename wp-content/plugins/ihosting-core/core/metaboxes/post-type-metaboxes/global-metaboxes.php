<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

add_filter( 'cmb2_init', 'ihosting_global_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @return array
 */
function ihosting_global_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_ihosting_';

	$meta_boxes = new_cmb2_box(
		array(
			'title'        => esc_html__( 'Custom Header', 'ihosting-core' ),
			'id'           => 'ihosting_custom_header_metas',
			'object_types' => array( 'page', 'post', 'product' ), // Post type
			// 'show_on_cb' => 'lena_core_show_if_front_page', // function should return a bool value
			'context'      => 'normal',
			'priority'     => 'low',
			'show_names'   => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		)
	);

	$header_logo_style_fields = array();
	for ( $i = 1; $i <= 3; $i++ ) {
		$header_logo_style_fields[] = array(
			'name' => esc_html__( 'Logo', 'ihosting-core' ),
			'desc' => esc_html__( 'Custom header logo', 'ihosting-core' ),
			'id'   => $prefix . 'header_logo_style_' . $i,
			'type' => 'file',
			'text' => array(
				'add_upload_file_text' => esc_html__( 'Upload Logo', 'ihosting-core' ) // Change upload button text. Default: "Add or Upload File"
			),
		);
	}

	$field_args = array(
		array(
			'name'      => esc_html__( 'Header Layout', 'ihosting-core' ),
			'id'        => $prefix . 'header_layout',
			'type'      => 'select',
			'options'   => array(
				'global'  => esc_html__( 'Use theme options global settings', 'ihosting-core' ),
				'style_1' => esc_html__( 'Style 1', 'ihosting-core' ),
				'style_2' => esc_html__( 'Style 2', 'ihosting-core' ),
				'style_3' => esc_html__( 'Style 3', 'ihosting-core' ),
			),
			'default'   => 'global',
			'after_row' => 'ihosting_core_after_header_layout_field',
		),
		$header_logo_style_fields[0],
		$header_logo_style_fields[1],
		$header_logo_style_fields[2],

		// For Header Style 1, 3
		array(
			'name'    => esc_html__( 'Header Description', 'ihosting-core' ),
			'id'      => $prefix . 'header_desc',
			'type'    => 'text',
			'default' => esc_html__( 'Trusted by over 10,000 website owners globally!', 'ihosting' ),
			//'escape_cb' => 'esc_html',
		),
		// This field will repeatable
		array(
			'name' => esc_html__( 'Input Contact Info', 'ihosting-core' ),
			'id'   => $prefix . 'header_contact_info',
			'type' => 'text',
			//'escape_cb' => 'esc_html',
		),
		array(
			'name'    => esc_html__( 'Show Header Login/Register Link', 'ihosting-core' ),
			'id'      => $prefix . 'show_header_login_link',
			'type'    => 'select',
			'options' => array(
				'show'      => esc_html__( 'Show', 'ihosting-core' ),
				'dont_show' => esc_html__( 'Don\'t show', 'ihosting-core' ),
			),
			'default' => 'show',
		),
		array(
			'name'    => esc_html__( 'Show Header Language Switcher', 'ihosting-core' ),
			'id'      => $prefix . 'show_header_lang_switcher',
			'type'    => 'select',
			'options' => array(
				'show'      => esc_html__( 'Show', 'ihosting-core' ),
				'dont_show' => esc_html__( 'Don\'t show', 'ihosting-core' ),
			),
			'default' => 'show',
		),
	);

	foreach ( $field_args as $field ):

		if ( $field['id'] == $prefix . 'header_contact_info' ) {
			$header_contact_info_group_id = $meta_boxes->add_field(
				array(
					'id'          => $prefix . 'header_contact_info_group',
					'type'        => 'group',
					'description' => esc_html__( 'Header Contact Infomation', 'ihosting-core' ),
					// 'repeatable'  => false, // use false if you want non-repeatable group
					'options'     => array(
						'group_title'   => esc_html__( 'Contact Info {#}', 'ihosting-core' ), // since version 1.1.4, {#} gets replaced by row number
						'add_button'    => esc_html__( 'Add More', 'ihosting-core' ),
						'remove_button' => esc_html__( 'Remove', 'ihosting-core' ),
						'sortable'      => true, // beta
						// 'closed'     => true, // true to have the groups closed by default
					),
				)
			);


			$group_fields = array(
				array(
					'name'      => esc_html__( 'Link', 'ihosting-core' ),
					'id'        => $prefix . 'header_contact_info_link',
					'type'      => 'text',
					'escape_cb' => 'esc_attr',
				),
				array(
					'name'            => esc_html__( 'Text', 'ihosting-core' ),
					'id'              => $prefix . 'header_contact_info_text',
					'type'            => 'text',
					'sanitization_cb' => 'sanitize_text_field',
				),
				array(
					'name'      => esc_html__( 'Icon Class', 'ihosting-core' ),
					'id'        => $prefix . 'header_contact_info_icon_class',
					'type'      => 'text_medium',
					'escape_cb' => 'esc_attr',
					'desc'      => esc_html__( 'Ex: fa fa-comments, fa fa-phone, fa fa-envelope...', 'ihosting-core' )
				),
			);

			foreach ( $group_fields as $group_field ) {
				$meta_boxes->add_group_field( $header_contact_info_group_id, $group_field );
			}
		}
		else {
			$meta_boxes->add_field( $field );
		}

	endforeach;

	// Banner/Heading/Breadcrumb
	$banner_boxes = new_cmb2_box(
		array(
			'title'        => esc_html__( 'Banner/Heading/Breadcrumb', 'ihosting-core' ),
			'id'           => 'ihosting_custom_banner_heading_breadcrumb_metas',
			'object_types' => array( 'page', 'post', 'product' ), // Post type
			// 'show_on_cb' => 'lena_core_show_if_front_page', // function should return a bool value
			'context'      => 'normal',
			'priority'     => 'low',
			'show_names'   => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		)
	);

	$banner_field_args = array(
		array(
			'name'    => esc_html__( 'Show Heading', 'ihosting-core' ),
			'id'      => $prefix . 'show_heading',
			'type'    => 'select',
			'options' => array(
				'global' => esc_html__( 'Use theme options global settings', 'ihosting-core' ),
				'show'   => esc_html__( 'Show', 'ihosting-core' ),
				'hide'   => esc_html__( 'Hide', 'ihosting-core' ),
			),
			'default' => 'global',
		),
		array(
			'name'    => esc_html__( 'Heading Color', 'ihosting-core' ),
			'id'      => $prefix . 'heading_color',
			'type'    => 'kt_color_picker',
			'default' => '#222222',
		),
		array(
			'name'    => esc_html__( 'Show Breadcrumb', 'ihosting-core' ),
			'id'      => $prefix . 'show_breadcrumb',
			'type'    => 'select',
			'options' => array(
				'global' => esc_html__( 'Use theme options global settings', 'ihosting-core' ),
				'show'   => esc_html__( 'Show', 'ihosting-core' ),
				'hide'   => esc_html__( 'Hide', 'ihosting-core' ),
			),
			'default' => 'global',
			'desc'    => esc_html__( 'This ineffective on the home page/front page. Breadcrumb always hide on the home page/front page.', 'ihosting-core' )
		),
		array(
			'name'    => esc_html__( 'Breadcrumb Color', 'ihosting-core' ),
			'id'      => $prefix . 'breadcrumb_color',
			'type'    => 'kt_color_picker',
			'default' => '#222222',
		),
		array(
			'name'    => esc_html__( 'Show Banner', 'ihosting-core' ),
			'id'      => $prefix . 'show_banner',
			'type'    => 'select',
			'options' => array(
				'global' => esc_html__( 'Use theme options global settings', 'ihosting-core' ),
				'show'   => esc_html__( 'Show', 'ihosting-core' ),
				'hide'   => esc_html__( 'Hide', 'ihosting-core' ),
			),
			'default' => 'global',
		),
		array(
			'name'    => esc_html__( 'Banner Color', 'ihosting-core' ),
			'desc'    => esc_html__( 'Banner background color.', 'ihosting-core' ),
			'id'      => $prefix . 'banner_bg_color',
			'type'    => 'kt_color_picker',
			'default' => '#ffffff',
		),
		array(
			'name' => esc_html__( 'Banner Image', 'ihosting-core' ),
			'desc' => esc_html__( 'Banner background image.', 'ihosting-core' ),
			'id'   => $prefix . 'banner_bg_img',
			'type' => 'file',
			'text' => array(
				'add_upload_file_text' => esc_html__( 'Upload Banner', 'ihosting-core' ) // Change upload button text. Default: "Add or Upload File"
			),
		),
		array(
			'name'    => esc_html__( 'Banner Background Repeat', 'ihosting-core' ),
			'id'      => $prefix . 'banner_bg_repeat',
			'type'    => 'select',
			'options' => array(
				'no-repeat' => esc_html__( 'No Repeat', 'ihosting-core' ),
				'repeat'    => esc_html__( 'Repeat All', 'ihosting-core' ),
				'repeat-x'  => esc_html__( 'Repeat Horizontally', 'ihosting-core' ),
				'hide'      => esc_html__( 'Hide', 'ihosting-core' ),
				'repeat-y'  => esc_html__( 'Repeat Vertically', 'ihosting-core' ),
				'inherit'   => esc_html__( 'Inherit', 'ihosting-core' ),
			),
			'default' => 'no-repeat',
		),
		array(
			'name'    => esc_html__( 'Banner Background Attachment', 'ihosting-core' ),
			'id'      => $prefix . 'banner_bg_attachment',
			'type'    => 'select',
			'options' => array(
				'fixed'   => esc_html__( 'Fixed', 'ihosting-core' ),
				'scroll'  => esc_html__( 'Scroll', 'ihosting-core' ),
				'inherit' => esc_html__( 'Inherit', 'ihosting-core' ),
			),
			'default' => 'scroll',
		),
		array(
			'name'    => esc_html__( 'Banner Background Align', 'ihosting-core' ),
			'id'      => $prefix . 'banner_bg_align',
			'type'    => 'select',
			'options' => array(
				'left top'      => esc_html__( 'Left Top', 'ihosting-core' ),
				'left center'   => esc_html__( 'Left center', 'ihosting-core' ),
				'left bottom'   => esc_html__( 'Left Bottom', 'ihosting-core' ),
				'center top'    => esc_html__( 'Center Top', 'ihosting-core' ),
				'center center' => esc_html__( 'Center Center', 'ihosting-core' ),
				'center bottom' => esc_html__( 'Center Bottom', 'ihosting-core' ),
				'right top'     => esc_html__( 'Right Top', 'ihosting-core' ),
				'right center'  => esc_html__( 'Right Center', 'ihosting-core' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'ihosting-core' )
			),
			'default' => 'center center',
		),
		array(
			'name'      => esc_html__( 'Banner Height', 'ihosting-core' ),
			'id'        => $prefix . 'banner_height',
			'type'      => 'text_small',
			//'escape_cb' => 'number',
			'default'   => 215,
			'desc'      => esc_html__( 'Default: 215. Unit is pixel.', 'ihosting-core' ),
		),
	);

	foreach ( $banner_field_args as $field ):

		$banner_boxes->add_field( $field );

	endforeach;

}

/**
 * Output some header images for preview
 *
 * @param  object $field_args Current field args
 * @param  object $field      Current field object
 *
 * @since  1.0
 *
 * @author Le Manh Linh
 *
 */
function ihosting_core_after_header_layout_field( $field_args, $field ) {

	echo '<div class="header-layout-preview-wrap">';
	echo '<label class="header-layout-preview-title">' . esc_html__( 'Preview: ', 'ihosting-core' ) . '</label>';
	for ( $i = 1; $i <= 3; $i++ ) {
		echo '<div class="img-header-layout-preview-wrap img-header-layout-wrap-' . $i . '">';
		echo '<img class="img-header-layout-preview img-header-layout-' . $i . '" src="' . esc_url( IHOSTINGCORE_IMG_URL . 'headers-preview/header_' . $i . '.jpg' ) . '" title="' . esc_attr__( 'Header Layout Preview', 'ihosting-core' ) . '" alt="Header ' . $i . '">';
		echo '</div>';
	}
	echo '</div><!-- /.header-layout-preview-wrap -->';

}

