<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * Register post type portfolio
*/
function ihosting_portfolios_post_type() {
	$labels = array(
		'name'               => __( 'Portfolios', 'post type general name', 'ihosting-core' ),
		'singular_name'      => __( 'Portfolio', 'post type singular name', 'ihosting-core' ),
		'add_new'            => __( 'Add New', 'ihosting-core' ),
		'all_items'          => __( 'All Portfolios', 'ihosting-core' ),
		'add_new_item'       => __( 'Add New Portfolio', 'ihosting-core' ),
		'edit_item'          => __( 'Edit Portfolio', 'ihosting-core' ),
		'new_item'           => __( 'New Portfolio', 'ihosting-core' ),
		'view_item'          => __( 'View Portfolio', 'ihosting-core' ),
		'search_items'       => __( 'Search Portfolios', 'ihosting-core' ),
		'not_found'          => __( 'No Portfolio Found', 'ihosting-core' ),
		'not_found_in_trash' => __( 'No Portfolio Found in Trash', 'ihosting-core' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_ui'           => true,
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'rewrite'           => array( 'slug' => 'portfolios', 'with_front' => true ),
		'query_var'         => true,
		'show_in_nav_menus' => false,
		'menu_icon'         => 'dashicons-schedule',
		'supports'          => array( 'title', 'thumbnail', 'excerpt', 'editor', 'author', ),
	);

	register_post_type( 'portfolio', $args );

}

add_action( 'init', 'ihosting_portfolios_post_type' );
