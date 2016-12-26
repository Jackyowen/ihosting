<?php
if ( ! defined( 'KT_WCAJS_DIR' ) ) {
    define( 'KT_WCAJS_DIR', plugin_dir_path( __FILE__ )  );
}
if ( ! defined( 'KT_WCAJSC_URL' ) ) {
    define( 'KT_WCAJS_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'KT_WCAJS_TEMPLATE_PATH' ) ) {
    define( 'KT_WCAJS_TEMPLATE_PATH', KT_WCAJS_DIR . 'templates' );
}

if ( ! defined( 'KT_WCAJS_CSS_URL' ) ) {
    define( 'KT_WCAJS_CSS_URL', KT_WCAJS_URL . 'css' );
}
if ( ! defined( 'KT_WCAJS_JS_URL' ) ) {
    define( 'KT_WCAJS_JS_URL', KT_WCAJS_URL . 'js' );
}



if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function kt_wcajs_install_woocommerce_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'Ajax Search for WooCommerce is enabled but not effective. It requires WooCommerce in order to work.', 'kute-tookit' ); ?></p>
    </div>
    <?php
}

function kt_wcajs_innit(){
	// Load required classes and functions
    require_once('kt-ajaxsearch.php');
    require_once('kt-wcajs-settings.php');
    
    new KT_AJAX_SEARCH();
}

add_action( 'kt_wcajs_innit', 'kt_wcajs_innit' );

function kt_wcajs_install(){
	if ( ! function_exists( 'WC' ) ) {
        add_action( 'admin_notices', 'kt_wcajs_install_woocommerce_admin_notice' );
    }else{
    	do_action('kt_wcajs_innit');
    }
}

add_action( 'plugins_loaded', 'kt_wcajs_install', 100 );