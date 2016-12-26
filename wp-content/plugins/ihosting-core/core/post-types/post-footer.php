<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * Register post type footer
*/
function ihosting_footers_post_type() {
	$labels = array(
		'name'               => esc_html__( 'Footers', 'post type general name', 'ihosting-core' ),
		'singular_name'      => esc_html__( 'Footer', 'post type singular name', 'ihosting-core' ),
		'add_new'            => esc_html__( 'Add New', 'ihosting-core' ),
		'all_items'          => esc_html__( 'All Footers', 'ihosting-core' ),
		'add_new_item'       => esc_html__( 'Add New Footer', 'ihosting-core' ),
		'edit_item'          => esc_html__( 'Edit Footer', 'ihosting-core' ),
		'new_item'           => esc_html__( 'New Footer', 'ihosting-core' ),
		'view_item'          => esc_html__( 'View Footer', 'ihosting-core' ),
		'search_items'       => esc_html__( 'Search Footers', 'ihosting-core' ),
		'not_found'          => esc_html__( 'No Footer Found', 'ihosting-core' ),
		'not_found_in_trash' => esc_html__( 'No Footer Found in Trash', 'ihosting-core' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_ui'           => true,
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'rewrite'           => array( 'slug' => 'footers' ),
		'query_var'         => true,
		'show_in_nav_menus' => false,
		'menu_icon'         => 'dashicons-schedule',
		'supports'          => array( 'title', 'editor' ),
	);

	register_post_type( 'footer', $args );

}

add_action( 'init', 'ihosting_footers_post_type' );