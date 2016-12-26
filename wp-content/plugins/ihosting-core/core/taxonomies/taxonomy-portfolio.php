<?php
/**
 * Custom Taxonomies
 * @package  Nella Core 1.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

if (!function_exists('ihosting_core_create_taxonomy_portfolio')) {
    
    function ihosting_core_create_taxonomy_portfolio() {
        // Taxonomy 
        $labels = array(
        	'name'                       => _x( 'Portfolio Categories', 'Portfolio Categories', 'ihosting-core' ),
        	'singular_name'              => _x( 'Portfolio Category', 'Portfolio Category', 'ihosting-core' ),
        	'menu_name'                  => __( 'Portfolio Categories', 'ihosting-core' ),
        	'all_items'                  => __( 'All Portfolio Categoties', 'ihosting-core' ),
        	'parent_item'                => '',
        	'parent_item_colon'          => '',
        	'new_item_name'              => __( 'New Portfolio Category', 'ihosting-core' ),
        	'add_new_item'               => __( 'Add New Portfolio Category', 'ihosting-core' ),
        	'edit_item'                  => __( 'Edit Portfolio Category', 'ihosting-core' ),
        	'update_item'                => __( 'Update Portfolio Category', 'ihosting-core' ), 
        	'search_items'               => __( 'Search Portfolio Category', 'ihosting-core' ),
        	'add_or_remove_items'        => __( 'Add New or Delete Portfolio Category', 'ihosting-core' ),
        	'choose_from_most_used'      => __( 'Choose from most used', 'ihosting-core' ),
        	'not_found'                  => __( 'Portfolio category not found', 'ihosting-core' ),
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
        register_taxonomy( 'portfolio_cat', array( 'portfolio' ), $args );  
        //flush_rewrite_rules();
    }
    add_action('init', 'ihosting_core_create_taxonomy_portfolio');
} 
