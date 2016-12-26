<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * Register post type testimonial
*/
function ihosting_testimonials_post_type() {
	$labels = array(
		'name'               => esc_html__( 'Testimonials', 'post type general name', 'ihosting-core' ),
		'singular_name'      => esc_html__( 'Testimonial', 'post type singular name', 'ihosting-core' ),
		'add_new'            => esc_html__( 'Add New', 'ihosting-core' ),
		'all_items'          => esc_html__( 'All Testimonials', 'ihosting-core' ),
		'add_new_item'       => esc_html__( 'Add New Testimonial', 'ihosting-core' ),
		'edit_item'          => esc_html__( 'Edit Testimonial', 'ihosting-core' ),
		'new_item'           => esc_html__( 'New Testimonial', 'ihosting-core' ),
		'view_item'          => esc_html__( 'View Testimonial', 'ihosting-core' ),
		'search_items'       => esc_html__( 'Search Testimonials', 'ihosting-core' ),
		'not_found'          => esc_html__( 'No Testimonial Found', 'ihosting-core' ),
		'not_found_in_trash' => esc_html__( 'No Testimonial Found in Trash', 'ihosting-core' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_ui'           => true,
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'rewrite'           => array( 'slug' => 'testimonials', 'with_front' => true ),
		'query_var'         => true,
		'show_in_nav_menus' => false,
		'menu_icon'         => 'dashicons-format-quote',
		'supports'          => array( 'title', 'editor' ),
	);

	register_post_type( 'testimonial', $args );

}

add_action( 'init', 'ihosting_testimonials_post_type' );
