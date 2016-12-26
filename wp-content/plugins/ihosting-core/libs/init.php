<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

if( !function_exists( 'wp_get_current_user' ) ) {
    include( ABSPATH . 'wp-includes/pluggable.php' ); 
}

/** Nonce for security check **/
//global $ihosting_core_nonce;
//$ihosting_core_nonce = array(
//    'ajax_nonce'  =>  wp_create_nonce( 'ovic-fh-core-ajax-nonce' )
//);

/**
 * Load Redux Framework 
 */
if ( !class_exists( 'ReduxFramework' ) && file_exists( IHOSTINGCORE_LIBS . 'admin/reduxframework/ReduxCore/framework.php' ) ) {
    require_once( IHOSTINGCORE_LIBS . 'admin/reduxframework/ReduxCore/framework.php' );
}

/**
 * Load Metaboxes Framework 
 */

if ( file_exists( IHOSTINGCORE_LIBS . 'admin/Tax-meta-class/Tax-meta-class.php' ) ) {
    require_once IHOSTINGCORE_LIBS . 'admin/Tax-meta-class/Tax-meta-class.php';
}

/**
 * Load Menu edit custom
 */

if ( file_exists( IHOSTINGCORE_LIBS . 'classes/ihostingNavMenuEditCustom.php' ) ) {
    require_once IHOSTINGCORE_LIBS . 'classes/ihostingNavMenuEditCustom.php';
}

//if (!function_exists('ihosting_admin_load_font_awesome')) {
//    
//    function ihosting_admin_load_font_awesome() {
//        //wp_deregister_style( 'font-awesome' );
//        wp_register_style( 'ovic-font-awesome', IHOSTINGCORE_LIBS . 'font-awesome/css/font-awesome.min.css');
//        wp_enqueue_script( 'ovic-font-awesome' );
//    }
//    add_action( 'admin_enqueue_scripts', 'ihosting_admin_load_font_awesome' );
//}
