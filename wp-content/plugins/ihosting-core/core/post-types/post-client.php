<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * Register post type client
*/
function ihosting_clients_post_type() {
	$labels = array(
		'name'               => __( 'Clients', 'post type general name', 'ihosting-core' ),
		'singular_name'      => __( 'Client', 'post type singular name', 'ihosting-core' ),
		'add_new'            => __( 'Add New', 'ihosting-core' ),
		'all_items'          => __( 'All Clients', 'ihosting-core' ),
		'add_new_item'       => __( 'Add New Client', 'ihosting-core' ),
		'edit_item'          => __( 'Edit Client', 'ihosting-core' ),
		'new_item'           => __( 'New Client', 'ihosting-core' ),
		'view_item'          => __( 'View Client', 'ihosting-core' ),
		'search_items'       => __( 'Search Clients', 'ihosting-core' ),
		'not_found'          => __( 'No Client Found', 'ihosting-core' ),
		'not_found_in_trash' => __( 'No Client Found in Trash', 'ihosting-core' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_ui'           => true,
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'rewrite'           => array( 'slug' => 'clients', 'with_front' => true ),
		'query_var'         => true,
		'show_in_nav_menus' => false,
		'menu_icon'         => 'dashicons-awards',
		'supports'          => array( 'title', 'thumbnail', 'author', 'editor' ),
	);

	register_post_type( 'client', $args );

}

add_action( 'init', 'ihosting_clients_post_type' );
