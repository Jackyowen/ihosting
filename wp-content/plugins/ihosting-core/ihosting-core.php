<?php
/*
 * Plugin Name: iHosting Core
 * Plugin URI: 
 * Description: Functions add new post type, taxonomy, metaboxes, shortcodes, ...
 * Author: Kute Themes
 * Text Domain: ihosting-core
 * Domain Path: /languages
 * Version: 1.1
 * Author URI: 
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // disable direct access
}

define( 'IHOSTINGCORE_VERSION', '1.1' );
define( 'IHOSTINGCORE_BASE_URL', trailingslashit( plugins_url( 'ihosting-core' ) ) );
define( 'IHOSTINGCORE_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'IHOSTINGCORE_LIBS', IHOSTINGCORE_DIR_PATH . '/libs/' );
define( 'IHOSTINGCORE_LIBS_URL', IHOSTINGCORE_BASE_URL . '/libs/' );
define( 'IHOSTINGCORE_CORE', IHOSTINGCORE_DIR_PATH . '/core/' );
define( 'IHOSTINGCORE_CSS_URL', IHOSTINGCORE_BASE_URL . 'assets/css/' );
define( 'IHOSTINGCORE_JS', IHOSTINGCORE_BASE_URL . 'assets/js/' );
define( 'IHOSTINGCORE_VENDORS_URL', IHOSTINGCORE_BASE_URL . 'assets/vendors/' );
define( 'IHOSTINGCORE_IMG_URL', IHOSTINGCORE_BASE_URL . 'assets/images/' );

/**
 * Load plugin textdomain
 */
if ( !function_exists( 'ihosting_core_load_textdomain' ) ) {
	function ihosting_core_load_textdomain() {
		load_plugin_textdomain( 'ihosting-core', false, IHOSTINGCORE_DIR_PATH . 'languages' );
	}

	add_action( 'plugins_loaded', 'ihosting_core_load_textdomain' );
}

/**
 * Load Theme customize css (via ajax)
 */
require_once IHOSTINGCORE_CORE . 'custom-css.php';

/**
 * Load libs
 */
if ( file_exists( IHOSTINGCORE_LIBS . 'init.php' ) ) {
	require_once IHOSTINGCORE_LIBS . 'init.php';
}

/**
 * Load One Click Import Demo Data
 */

if ( file_exists( IHOSTINGCORE_CORE . 'oneclick-import.php' ) ) {
	require_once IHOSTINGCORE_CORE . 'oneclick-import.php';
}

/**
 * Load core
 */
if ( file_exists( IHOSTINGCORE_CORE . 'init.php' ) ) {
	require_once IHOSTINGCORE_CORE . 'init.php';
}

if ( !function_exists( 'ihosting_core_admin_fonts_url' ) ) {

	/**
	 * Register Google fonts for iHosting.
	 *
	 * @since iHosting 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function ihosting_core_admin_fonts_url() {
		$fonts_url = '';
		$fonts = array();
		$subsets = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Oswald, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Oswald font: on or off', 'ihosting-core' ) ) {
			$fonts[] = 'Oswald:400,300,700';
		}

		/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'ihosting-core' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		}
		elseif ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		}
		elseif ( 'devanagari' == $subset ) {
			$subsets .= ',devanagari';
		}
		elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( $subsets ),
				), '//fonts.googleapis.com/css'
			);
		}

		return $fonts_url;
	}
}


/**
 * Enqueue Admin Style
 */
if ( !function_exists( 'ihosting_core_admin_enqueue_style' ) ) {

	function ihosting_core_admin_enqueue_style() {

		// Add custom fonts, used in the main stylesheet.
		wp_enqueue_style( 'ihostingcore-fonts', ihosting_core_admin_fonts_url(), array(), null );

		//wp_register_style( 'ihostingcore-admin-bootstrap', IHOSTINGCORE_CSS_URL . 'admin-bootstrap.css', array(), IHOSTINGCORE_VERSION, 'all' );
		//wp_enqueue_style( 'ihostingcore-admin-bootstrap' );

		//wp_register_style( 'ihostingcore-admin-style', IHOSTINGCORE_CSS_URL . 'admin-style.css', array(), IHOSTINGCORE_VERSION, 'all' );
		//        wp_enqueue_style( 'ihostingcore-admin-style' );

		wp_register_style( 'spectrum', IHOSTINGCORE_VENDORS_URL . 'spectrum/spectrum.css', array(), IHOSTINGCORE_VERSION, 'all' );
		wp_enqueue_style( 'spectrum' );

		//		wp_register_style( 'flaticon', IHOSTINGCORE_VENDORS_URL . 'flaticon/css/flaticon.css', array(), IHOSTINGCORE_VERSION, 'all' );
		//		wp_enqueue_style( 'flaticon' );

		//		wp_register_style( 'Pe-icon-7-stroke', IHOSTINGCORE_VENDORS_URL . 'Pe-icon-7-stroke/css/Pe-icon-7-stroke.css', array(), IHOSTINGCORE_VERSION, 'all' );
		//		wp_enqueue_style( 'Pe-icon-7-stroke' );

		wp_register_style( 'ihostingcore-admin-redux', IHOSTINGCORE_CSS_URL . 'admin-redux.css', array(), IHOSTINGCORE_VERSION, 'all' );
		wp_enqueue_style( 'ihostingcore-admin-redux' );

		wp_register_style( 'ihostingcore-admin', IHOSTINGCORE_CSS_URL . 'admin.css', array(), IHOSTINGCORE_VERSION, 'all' );
		wp_enqueue_style( 'ihostingcore-admin' );

	}

	add_action( 'admin_enqueue_scripts', 'ihosting_core_admin_enqueue_style' );
}

if ( !function_exists( 'ihosting_dequeue_wc_styles' ) ) {
	// Remove some default WooCommerce Styles
	function ihosting_dequeue_wc_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-general'] );    // Remove the gloss
		unset( $enqueue_styles['woocommerce-layout'] );        // Remove the layout
		unset( $enqueue_styles['woocommerce-smallscreen'] );    // Remove the smallscreen optimisation
		return $enqueue_styles;
	}

	add_filter( 'woocommerce_enqueue_styles', 'ihosting_dequeue_wc_styles' );
}

/**
 * Enqueue Frontend Styles
 **/
if ( !function_exists( 'ihosting_core_css' ) ) {

	/*
	 * Load css
	*/
	function ihosting_core_css() {

		// Font flaticon
		//		wp_register_style( 'flaticon', IHOSTINGCORE_VENDORS_URL . 'flaticon/css/flaticon.css', false, IHOSTINGCORE_VERSION, 'all' );
		//		wp_enqueue_style( 'flaticon' );

		// Font Pe-icon-7-stroke
		//		wp_register_style( 'Pe-icon-7-stroke', IHOSTINGCORE_VENDORS_URL . 'Pe-icon-7-stroke/css/Pe-icon-7-stroke.css', false, IHOSTINGCORE_VERSION, 'all' );
		//		wp_enqueue_style( 'Pe-icon-7-stroke' );

		wp_register_style( 'animate', IHOSTINGCORE_VENDORS_URL . 'animate/animate.css', false, IHOSTINGCORE_VERSION, 'all' );
		wp_enqueue_style( 'animate' );

		wp_register_style( 'chosen', IHOSTINGCORE_VENDORS_URL . 'chosen/chosen.css', false, IHOSTINGCORE_VERSION, 'all' );
		wp_enqueue_style( 'chosen' );

		wp_register_style( 'owl.carousel', IHOSTINGCORE_VENDORS_URL . 'owl-carousel/owl.carousel.css', false, IHOSTINGCORE_VERSION, 'all' );
		wp_enqueue_style( 'owl.carousel' );

		// Remove Default WooCommerce Style
		wp_deregister_style( 'woocommerce-general-css' );

		//        wp_register_style( 'jquery-ui', IHOSTINGCORE_VENDORS_URL. 'jquery-ui/css/jquery-ui.css', false, IHOSTINGCORE_VERSION, 'all' );
		//		wp_enqueue_style( 'jquery-ui' );

		//        wp_register_style( 'lightbox', IHOSTINGCORE_VENDORS_URL. 'lightbox/css/lightbox.css', false, IHOSTINGCORE_VERSION, 'all' );
		//		wp_enqueue_style( 'lightbox' );

		//        wp_register_style( 'ihostingcore-woocommerce', IHOSTINGCORE_CSS_URL . 'woocommerce.css', false, IHOSTINGCORE_VERSION, 'all' );
		//        wp_enqueue_style( 'ihostingcore-woocommerce' );

		wp_register_style( 'ihostingcore-frontend-style', IHOSTINGCORE_CSS_URL . 'frontend-style.css', false, IHOSTINGCORE_VERSION, 'all' );
		wp_enqueue_style( 'ihostingcore-frontend-style' );

		// Right to left
		if ( is_rtl() ) {
			wp_register_style( 'ihostingcore-frontend-style-rtl', IHOSTINGCORE_CSS_URL . 'frontend-style-rtl.css', false, IHOSTINGCORE_VERSION, 'all' );
			wp_enqueue_style( 'ihostingcore-frontend-style-rtl' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'ihosting_core_css', 99 );

}

/**
 * Enqueue Frontend Custom Styles
 **/
if ( !function_exists( 'ihosting_core_custom_css' ) ) {

	/*
	 * Load css
	*/
	function ihosting_core_custom_css() {

		//wp_enqueue_style( 'ihostingcore-customize-style', esc_url( admin_url( 'admin-ajax.php' ) ), false, IHOSTINGCORE_VERSION . '&amp;action=ihosting_enqueue_style_via_ajax', 'all' );
		//wp_enqueue_style( 'ihostingcore-customize-style', esc_url( add_query_arg( 'action', 'ihosting_enqueue_style_via_ajax', admin_url( 'admin-ajax.php' ) ) ), false, IHOSTINGCORE_VERSION, 'all' );

	}

	add_action( 'wp_enqueue_scripts', 'ihosting_core_custom_css', 99 );

}

/**
 * Enqueue Admin js
 */
if ( !function_exists( 'ihosting_core_admin_enqueue_js' ) ) {

	function ihosting_core_admin_enqueue_js() {

		wp_register_script( 'jquery.countdown.min', IHOSTINGCORE_VENDORS_URL . 'jquery.countdown/jquery.countdown.min.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'jquery.countdown.min' );

		wp_register_script( 'spectrum', IHOSTINGCORE_VENDORS_URL . 'spectrum/spectrum.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'spectrum' );

		wp_register_script( 'ihostingcore-admin-scripts', IHOSTINGCORE_JS . 'admin-scripts.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'ihostingcore-admin-scripts' );

	}

	add_action( 'admin_enqueue_scripts', 'ihosting_core_admin_enqueue_js' );
}

if ( !function_exists( 'ihosting_core_enqueue_js' ) ) {

	/*
	 * Load jquery
	*/
	function ihosting_core_enqueue_js() {
		global $ihosting;

		$enable_smooth_scroll = isset( $ihosting['opt_enable_smooth_scroll'] ) ? $ihosting['opt_enable_smooth_scroll'] == 1 : false;

		wp_register_script( 'wow.min', IHOSTINGCORE_VENDORS_URL . 'wow/wow.min.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'wow.min' );

		wp_register_script( 'Modernizr', IHOSTINGCORE_VENDORS_URL . 'Modernizr/Modernizr.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'Modernizr' );

		$gmap_api_key = isset( $ihosting['opt_gmap_api_key'] ) ? $ihosting['opt_gmap_api_key'] : '';
		$google_map_js_url = 'https://maps.googleapis.com/maps/api/js?sensor=false';
		if ( trim( $gmap_api_key ) != '' ) {
			$google_map_js_url .= '&key=' . esc_attr( $gmap_api_key );
		}

		wp_register_script( 'jquery.debouncedresize', IHOSTINGCORE_VENDORS_URL . 'debounced-resize/jquery.debouncedresize.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'jquery.debouncedresize' );

		wp_register_script( 'chosen.jquery.min', IHOSTINGCORE_VENDORS_URL . 'chosen/chosen.jquery.min.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'chosen.jquery.min' );

		if ( $enable_smooth_scroll ) {
			wp_register_script( 'SmoothScroll', IHOSTINGCORE_VENDORS_URL . 'SmoothScroll/SmoothScroll.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
			wp_enqueue_script( 'SmoothScroll' );
		}

		wp_register_script( 'jquery.appear.min', IHOSTINGCORE_VENDORS_URL . 'jquery.appear/jquery.appear.min.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'jquery.appear.min' );

		wp_register_script( 'jquery.countTo', IHOSTINGCORE_VENDORS_URL . 'pie-chart/jquery.countTo.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'jquery.countTo' );

		wp_register_script( 'owl.carousel.min', IHOSTINGCORE_VENDORS_URL . 'owl-carousel/owl.carousel.min.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'owl.carousel.min' );

		wp_register_script( 'jquery.countdown.min', IHOSTINGCORE_VENDORS_URL . 'jquery.countdown/jquery.countdown.min.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'jquery.countdown.min' );

//		wp_register_script( 'jquery.easyzoom', IHOSTINGCORE_VENDORS_URL . 'easyzoom/easyzoom.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
//		wp_enqueue_script( 'jquery.easyzoom' );

		wp_register_script( 'ihostingcore-woocommerce', IHOSTINGCORE_JS . 'woocommerce.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'ihostingcore-woocommerce' );

		wp_register_script( 'ihostingcore-frontend-script', IHOSTINGCORE_JS . 'frontend-script.js', array( 'jquery' ), IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'ihostingcore-frontend-script' );

		wp_localize_script( 'ihostingcore-frontend-script', 'ajaxurl', get_admin_url() . '/admin-ajax.php' );

		wp_register_script( 'google-map', $google_map_js_url, false, IHOSTINGCORE_VERSION, true );
		wp_enqueue_script( 'google-map' );
	}

	add_action( 'wp_enqueue_scripts', 'ihosting_core_enqueue_js' );

}



