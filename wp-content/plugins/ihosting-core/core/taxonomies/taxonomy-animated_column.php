<?php
/**
 * Custom Taxonomies
 * @package  Nella Core 1.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !function_exists( 'ihosting_core_create_taxonomy_animated_column' ) ) {
    
    function ihosting_core_create_taxonomy_animated_column() {
        // Taxonomy 
        $labels = array(
        	'name'                       => _x( 'Animated Column Categories', 'Animated Column Categories', 'ihosting-core' ),
        	'singular_name'              => _x( 'Animated Column Category', 'Animated Column Category', 'ihosting-core' ),
        	'menu_name'                  => __( 'Animated Column Categories', 'ihosting-core' ),
        	'all_items'                  => __( 'All A.Col Categoties', 'ihosting-core' ),
        	'parent_item'                => '',
        	'parent_item_colon'          => '',
        	'new_item_name'              => __( 'New Animated Column Category', 'ihosting-core' ),
        	'add_new_item'               => __( 'Add New Animated Column Category', 'ihosting-core' ),
        	'edit_item'                  => __( 'Edit Animated Column Category', 'ihosting-core' ),
        	'update_item'                => __( 'Update Animated Column Category', 'ihosting-core' ), 
        	'search_items'               => __( 'Search Animated Column Category', 'ihosting-core' ),
        	'add_or_remove_items'        => __( 'Add New or Delete Animated Column Category', 'ihosting-core' ),
        	'choose_from_most_used'      => __( 'Choose from most used', 'ihosting-core' ),
        	'not_found'                  => __( 'Animated Column category not found', 'ihosting-core' ),
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
        register_taxonomy( 'animated_column_cat', array( 'animated_column' ), $args );  
        //flush_rewrite_rules();
    }
    add_action('init', 'ihosting_core_create_taxonomy_animated_column');
} 
