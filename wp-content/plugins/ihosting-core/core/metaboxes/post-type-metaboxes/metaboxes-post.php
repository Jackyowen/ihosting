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

if ( file_exists( IHOSTINGCORE_LIBS . 'admin/cmb2/init.php' ) ) {
	require_once IHOSTINGCORE_LIBS . 'admin/cmb2/init.php';
}
elseif ( file_exists( IHOSTINGCORE_LIBS . 'admin/CMB2/init.php' ) ) {
	require_once IHOSTINGCORE_LIBS . 'admin/CMB2/init.php';
}

add_filter( 'cmb2_init', 'ihosting_post_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @return array
 */
function ihosting_post_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_ihosting_';

	$meta_boxes = new_cmb2_box(
		array(
			'title'        => __( 'Post Gallery', 'ihosting-core' ),
			'id'           => 'ihosting_post_metas',
			'object_types' => array( 'post' ), // Post type
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
			'name'         => 'Images Gallery',
			'desc'         => '',
			'id'           => $prefix . 'images_gallery',
			'type'         => 'file_list',
			'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		),
	);

	foreach ( $field_args as $field ):

		$meta_boxes->add_field( $field );

	endforeach;

}