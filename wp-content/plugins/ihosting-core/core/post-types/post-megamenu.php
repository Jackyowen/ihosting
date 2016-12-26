<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/*-----------------------------------------------------------------------------------*/
/* MEGA MENU
/*-----------------------------------------------------------------------------------*/
function no_post_type_megamenu() {

	$labels = array(
		'name'               => __( 'Mega Menu', 'ihosting-core' ),
		'singular_name'      => __( 'Mega Menu Item', 'ihosting-core' ),
		'add_new'            => __( 'Add New', 'ihosting-core' ),
		'add_new_item'       => __( 'Add New Menu Item', 'ihosting-core' ),
		'edit_item'          => __( 'Edit Menu Item', 'ihosting-core' ),
		'new_item'           => __( 'New Menu Item', 'ihosting-core' ),
		'view_item'          => __( 'View Menu Item', 'ihosting-core' ),
		'search_items'       => __( 'Search Menu Items', 'ihosting-core' ),
		'not_found'          => __( 'No Menu Items found', 'ihosting-core' ),
		'not_found_in_trash' => __( 'No Menu Items found in Trash', 'ihosting-core' ),
		'parent_item_colon'  => __( 'Parent Menu Item:', 'ihosting-core' ),
		'menu_name'          => __( 'Mega Menu', 'ihosting-core' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => __( 'Mega Menus.', 'ihosting-core' ),
		'supports'            => array( 'title', 'editor' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 40,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => false,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => false,
		'capability_type'     => 'post'
	);

	register_post_type( 'megamenu', $args );
}

add_action( 'init', 'no_post_type_megamenu' );

