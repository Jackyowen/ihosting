<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Register post type kt_doc
*/
function ihosting_kt_docs_post_type() {
	$labels = array(
		'name'               => esc_html__( 'Documents', 'post type general name', 'ihosting-core' ),
		'singular_name'      => esc_html__( 'Document', 'post type singular name', 'ihosting-core' ),
		'add_new'            => esc_html__( 'Add New', 'ihosting-core' ),
		'all_items'          => esc_html__( 'All Documents', 'ihosting-core' ),
		'add_new_item'       => esc_html__( 'Add New Document', 'ihosting-core' ),
		'edit_item'          => esc_html__( 'Edit Document', 'ihosting-core' ),
		'new_item'           => esc_html__( 'New Document', 'ihosting-core' ),
		'view_item'          => esc_html__( 'View Document', 'ihosting-core' ),
		'search_items'       => esc_html__( 'Search Documents', 'ihosting-core' ),
		'not_found'          => esc_html__( 'No Document Found', 'ihosting-core' ),
		'not_found_in_trash' => esc_html__( 'No Document Found in Trash', 'ihosting-core' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'rewrite'           => array( 'slug' => 'kt_docs', 'with_front' => true ),
		'query_var'         => true,
		'show_in_nav_menus' => true,
		'menu_icon'         => 'dashicons-editor-paste-word',
		'supports'          => array( 'title', 'thumbnail', 'editor' ),
	);


	// Make sure only register document post type for our hosting
	$current_site_url = get_site_url();
	$parse_url = parse_url( $current_site_url );

	if ( isset( $parse_url['host'] ) ) {
		if ( in_array( $parse_url['host'], array( 'dev06.ovicsoft.com', 'kute-themes.com' ) ) ) {
			register_post_type( 'kt_doc', $args );
		}
	}

}

add_action( 'init', 'ihosting_kt_docs_post_type' );