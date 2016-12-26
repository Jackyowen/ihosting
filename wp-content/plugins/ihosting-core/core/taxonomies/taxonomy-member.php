<?php
/**
 * Custom Taxonomies
 * @package  Nella Core 1.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

if (!function_exists('ihosting_core_create_taxonomy_member')) {
    
    function ihosting_core_create_taxonomy_member() {
        // Taxonomy 
        $labels = array(
        	'name'                       => _x( 'Member Categories', 'Member Categories', 'ihosting-core' ),
        	'singular_name'              => _x( 'Member Category', 'Member Category', 'ihosting-core' ),
        	'menu_name'                  => __( 'Member Categories', 'ihosting-core' ),
        	'all_items'                  => __( 'All Member Categoties', 'ihosting-core' ),
        	'parent_item'                => '',
        	'parent_item_colon'          => '',
        	'new_item_name'              => __( 'New Member Category', 'ihosting-core' ),
        	'add_new_item'               => __( 'Add New Member Category', 'ihosting-core' ),
        	'edit_item'                  => __( 'Edit Member Category', 'ihosting-core' ),
        	'update_item'                => __( 'Update Member Category', 'ihosting-core' ), 
        	'search_items'               => __( 'Search Member Category', 'ihosting-core' ),
        	'add_or_remove_items'        => __( 'Add New or Delete Member Category', 'ihosting-core' ),
        	'choose_from_most_used'      => __( 'Choose from most used', 'ihosting-core' ),
        	'not_found'                  => __( 'Member category not found', 'ihosting-core' ),
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
        register_taxonomy( 'member_cat', array( 'member' ), $args );  
        //flush_rewrite_rules();
    }
    add_action('init', 'ihosting_core_create_taxonomy_member');
} 
