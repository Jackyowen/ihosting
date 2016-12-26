<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Register post type member
*/
function ihosting_members_post_type() {
	$labels = array(
		'name'               => esc_html__( 'Members', 'post type general name', 'ihosting-core' ),
		'singular_name'      => esc_html__( 'Member', 'post type singular name', 'ihosting-core' ),
		'add_new'            => esc_html__( 'Add New', 'ihosting-core' ),
		'all_items'          => esc_html__( 'All Members', 'ihosting-core' ),
		'add_new_item'       => esc_html__( 'Add New Member', 'ihosting-core' ),
		'edit_item'          => esc_html__( 'Edit Member', 'ihosting-core' ),
		'new_item'           => esc_html__( 'New Member', 'ihosting-core' ),
		'view_item'          => esc_html__( 'View Member', 'ihosting-core' ),
		'search_items'       => esc_html__( 'Search Members', 'ihosting-core' ),
		'not_found'          => esc_html__( 'No Member Found', 'ihosting-core' ),
		'not_found_in_trash' => esc_html__( 'No Member Found in Trash', 'ihosting-core' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_ui'           => true,
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'rewrite'           => array( 'slug' => 'members', 'with_front' => true ),
		'query_var'         => true,
		'show_in_nav_menus' => false,
		'menu_icon'         => 'dashicons-groups',
		'supports'          => array( 'title', 'thumbnail', 'editor' ),
	);

	register_post_type( 'member', $args );

}

add_action( 'init', 'ihosting_members_post_type' );