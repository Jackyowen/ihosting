<?php
/**
 * Custom Taxonomies
 * @package  Nella Core 1.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

if (!function_exists('ihosting_core_create_taxonomy_brand')) {
    
    function ihosting_core_create_taxonomy_brand() {
        // Taxonomy 
        $labels = array(
        	'name'                       => _x( 'Brands', 'product brands', 'ihosting-core' ),
        	'singular_name'              => _x( 'Brand', 'product brand', 'ihosting-core' ),
        	'menu_name'                  => __( 'Brands', 'ihosting-core' ),
        	'all_items'                  => __( 'All Brand', 'ihosting-core' ),
        	'parent_item'                => '',
        	'parent_item_colon'          => '',
        	'new_item_name'              => __( 'New Brand', 'ihosting-core' ),
        	'add_new_item'               => __( 'Add New Brand', 'ihosting-core' ),
        	'edit_item'                  => __( 'Edit Brand', 'ihosting-core' ),
        	'update_item'                => __( 'Update Brand', 'ihosting-core' ), 
        	'search_items'               => __( 'Search Brand', 'ihosting-core' ),
        	'add_or_remove_items'        => __( 'Add New or Delete Brand', 'ihosting-core' ),
        	'choose_from_most_used'      => __( 'Choose from most used', 'ihosting-core' ),
        	'not_found'                  => __( 'Brand not found', 'ihosting-core' ),
        ); 
        $args = array(
        	'labels'                     => $labels,
        	'hierarchical'               => true,
        	'public'                     => true,
        	'show_ui'                    => true,
        	'show_admin_column'          => true,
        	'show_in_nav_menus'          => true,
        	'show_tagcloud'              => false, 
            'hierarchical'               => true
        );
        register_taxonomy( 'product_brand', array( 'product' ), $args );  
        //flush_rewrite_rules();
    }
    add_action('init', 'ihosting_core_create_taxonomy_brand');
} 
