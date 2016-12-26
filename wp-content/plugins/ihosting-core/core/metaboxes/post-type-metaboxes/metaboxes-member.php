<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category Lucky Shop Core
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

add_filter( 'cmb2_init', 'ihosting_member_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @return array
 */
function ihosting_member_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_ihosting_';

	$meta_boxes = new_cmb2_box(
		array(
			'title'        => esc_html__( 'Member Information', 'ihosting-core' ),
			'id'           => 'ihosting_member_metas',
			'object_types' => array( 'member' ), // Post type
			// 'show_on_cb' => 'lena_core_show_if_front_page', // function should return a bool value
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		)
	);

	$field_args = array(
		array(
			'name'    => esc_html__( 'Position', 'ihosting-core' ),
			'id'      => $prefix . 'member_position',
			'type'    => 'text_medium',
			'default' => esc_html__( 'CEO-Founder Luckyshop', 'ihosting-core' ),
		),
		array(
			'name' => esc_html__( 'Member Social Pages', 'ihosting-core' ),
			'id'   => $prefix . 'member_social_pages',
			'type' => 'text',
			//'escape_cb' => 'esc_html',
		),
	);

	foreach ( $field_args as $field ):

		if ( $field['id'] == $prefix . 'member_social_pages' ) {
			$member_social_pages_group = $meta_boxes->add_field(
				array(
					'id'          => $prefix . 'member_social_pages_groups',
					'type'        => 'group',
					'description' => esc_html__( 'Member Social Pages', 'ihosting-core' ),
					// 'repeatable'  => false, // use false if you want non-repeatable group
					'options'     => array(
						'group_title'   => esc_html__( 'Social Page {#}', 'ihosting-core' ), // since version 1.1.4, {#} gets replaced by row number
						'add_button'    => esc_html__( 'Add More', 'ihosting-core' ),
						'remove_button' => esc_html__( 'Remove', 'ihosting-core' ),
						'sortable'      => true, // beta
						// 'closed'     => true, // true to have the groups closed by default
					),
				)
			);


			$group_fields = array(
				array(
					'name'      => esc_html__( 'Social Page Link', 'ihosting-core' ),
					'id'        => $prefix . 'member_social_link',
					'type'      => 'text',
					'escape_cb' => 'esc_attr',
				),
				array(
					'name'      => esc_html__( 'Icon Class', 'ihosting-core' ),
					'id'        => $prefix . 'member_social_icon_class',
					'type'      => 'text_medium',
					'escape_cb' => 'esc_attr',
					'desc'      => esc_html__( 'Ex: fa fa-facebook, fa fa-twitter, fa fa-pinterest, fa fa-youtube...', 'ihosting-core' )
				),
				array(
					'name'            => esc_html__( 'Title', 'ihosting-core' ),
					'id'              => $prefix . 'member_social_title',
					'type'            => 'text',
					'sanitization_cb' => 'sanitize_text_field',
					'desc'      => esc_html__( 'Ex: Facebook', 'ihosting-core' )
				),
			);

			foreach ( $group_fields as $group_field ) {
				$meta_boxes->add_group_field( $member_social_pages_group, $group_field );
			}
		}
		else {
			$meta_boxes->add_field( $field );
		}

	endforeach;

}

