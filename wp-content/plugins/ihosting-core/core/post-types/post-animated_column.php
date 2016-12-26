<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * Register post type animated_column
*/
function ihosting_animated_columns_post_type() {
	$labels = array(
		'name'               => __( 'Animated Columns', 'post type general name', 'ihosting-core' ),
		'singular_name'      => __( 'Animated Column', 'post type singular name', 'ihosting-core' ),
		'add_new'            => __( 'Add New', 'testmonials', 'ihosting-core' ),
		'all_items'          => __( 'All Animated Columns', 'ihosting-core' ),
		'add_new_item'       => __( 'Add New Animated Column', 'ihosting-core' ),
		'edit_item'          => __( 'Edit Animated Column', 'ihosting-core' ),
		'new_item'           => __( 'New Animated Column', 'ihosting-core' ),
		'view_item'          => __( 'View Animated Column', 'ihosting-core' ),
		'search_items'       => __( 'Search Animated Columns', 'ihosting-core' ),
		'not_found'          => __( 'No Animated Column Found', 'ihosting-core' ),
		'not_found_in_trash' => __( 'No Animated Column Found in Trash', 'ihosting-core' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_ui'           => true,
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'rewrite'           => array( 'slug' => 'animated_columns', 'with_front' => true ),
		'query_var'         => true,
		'show_in_nav_menus' => false,
		'menu_icon'         => 'dashicons-screenoptions',
		'supports'          => array( 'title', 'thumbnail', 'author', 'editor', 'excerpt' ),
	);

	register_post_type( 'animated_column', $args );

}

add_action( 'init', 'ihosting_animated_columns_post_type' );
