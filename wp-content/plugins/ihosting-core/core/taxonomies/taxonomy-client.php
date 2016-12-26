<?php
/**
 * Custom Taxonomies
 * @package  Nella Core 1.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

if (!function_exists('ihosting_core_create_taxonomy_client')) {
    
    function ihosting_core_create_taxonomy_client() {
        // Taxonomy 
        $labels = array(
        	'name'                       => _x( 'Client Categories', 'Client Categories', 'ihosting-core' ),
        	'singular_name'              => _x( 'Client Category', 'Client Category', 'ihosting-core' ),
        	'menu_name'                  => __( 'Client Categories', 'ihosting-core' ),
        	'all_items'                  => __( 'All Client Categoties', 'ihosting-core' ),
        	'parent_item'                => '',
        	'parent_item_colon'          => '',
        	'new_item_name'              => __( 'New Client Category', 'ihosting-core' ),
        	'add_new_item'               => __( 'Add New Client Category', 'ihosting-core' ),
        	'edit_item'                  => __( 'Edit Client Category', 'ihosting-core' ),
        	'update_item'                => __( 'Update Client Category', 'ihosting-core' ), 
        	'search_items'               => __( 'Search Client Category', 'ihosting-core' ),
        	'add_or_remove_items'        => __( 'Add New or Delete Client Category', 'ihosting-core' ),
        	'choose_from_most_used'      => __( 'Choose from most used', 'ihosting-core' ),
        	'not_found'                  => __( 'Client category not found', 'ihosting-core' ),
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
        register_taxonomy( 'client_cat', array( 'client' ), $args );  
        //flush_rewrite_rules();
    }
    add_action('init', 'ihosting_core_create_taxonomy_client');
} 
