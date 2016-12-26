<?php
/**
 * Custom Taxonomies
 * @package  Nella Core 1.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

if (!function_exists('ihosting_core_create_taxonomy_designer')) {
    
    function ihosting_core_create_taxonomy_designer() {
        // Taxonomy 
        $labels = array(
        	'name'                       => _x( 'Designers', 'product brands', 'ihosting-core' ),
        	'singular_name'              => _x( 'Designer', 'product brand', 'ihosting-core' ),
        	'menu_name'                  => __( 'Designers', 'ihosting-core' ),
        	'all_items'                  => __( 'All Designers', 'ihosting-core' ),
        	'parent_item'                => '',
        	'parent_item_colon'          => '',
        	'new_item_name'              => __( 'New Designer', 'ihosting-core' ),
        	'add_new_item'               => __( 'Add New Designer', 'ihosting-core' ),
        	'edit_item'                  => __( 'Edit Designer', 'ihosting-core' ),
        	'update_item'                => __( 'Update Designer', 'ihosting-core' ), 
        	'search_items'               => __( 'Search Designer', 'ihosting-core' ),
        	'add_or_remove_items'        => __( 'Add New or Delete Designer', 'ihosting-core' ),
        	'choose_from_most_used'      => __( 'Choose from most used', 'ihosting-core' ),
        	'not_found'                  => __( 'Designer not found', 'ihosting-core' ),
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
        register_taxonomy( 'product_designer', array( 'product' ), $args );  
        //flush_rewrite_rules();
    }
    add_action('init', 'ihosting_core_create_taxonomy_designer');
} 
