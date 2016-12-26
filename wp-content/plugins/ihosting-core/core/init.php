<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'ihosting_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function ihosting_initialize_cmb_meta_boxes() {

	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once IHOSTINGCORE_LIBS . '/admin/metaboxes/init.php';
	};

}


/**
 * Require file
 **/
function ihosting_require_once( $file_path ) {

	if ( file_exists( $file_path ) ) {
		require_once $file_path;
	}
}

/**
 * Load custom post type
 */


$postTypeArgs = array( 'member', 'testimonial', 'footer', 'kt_doc' );
if ( is_array( $postTypeArgs ) && !empty( $postTypeArgs ) ):
	foreach ( $postTypeArgs as $postType ):
		$postType = sanitize_key( $postType );
		$filePath = IHOSTINGCORE_CORE . 'post-types/post-' . $postType . '.php';
		if ( file_exists( $filePath ) ):
			include_once $filePath;
		endif;
	endforeach;
endif;

/**
 * Load custom taxonomies
 */

$taxonomiesArgs = array();
if ( is_array( $taxonomiesArgs ) && !empty( $taxonomiesArgs ) ):
	foreach ( $taxonomiesArgs as $taxonomy ):
		$taxonomy = sanitize_key( $taxonomy );
		$filePath = IHOSTINGCORE_CORE . 'taxonomies/taxonomy-' . $taxonomy . '.php';
		if ( file_exists( $filePath ) ):
			include_once $filePath;
		endif;
	endforeach;
endif;

/**
 * Load Post type metaboxes
 */
include_once IHOSTINGCORE_CORE . 'metaboxes/post-type-metaboxes/global-metaboxes.php';

$postTypeMetaboxesArgs = array( 'post', 'member' );
if ( is_array( $postTypeMetaboxesArgs ) && !empty( $postTypeMetaboxesArgs ) ):
	foreach ( $postTypeMetaboxesArgs as $post_type ):
		$post_type = sanitize_key( $post_type );
		$filePath = IHOSTINGCORE_CORE . 'metaboxes/post-type-metaboxes/metaboxes-' . $post_type . '.php';
		if ( file_exists( $filePath ) ):
			include_once $filePath;
		endif;
	endforeach;
endif;

/**
 * Load Taxonomies metaboxes
 */
$taxonomyMetaboxesArgs = array( 'pa_color' );
if ( is_array( $taxonomyMetaboxesArgs ) && !empty( $taxonomyMetaboxesArgs ) ):
	foreach ( $taxonomyMetaboxesArgs as $taxonomy ):
		$taxonomy = sanitize_key( $taxonomy );
		$filePath = IHOSTINGCORE_CORE . 'metaboxes/taxonomy-metaboxes/metaboxes-tax-' . $taxonomy . '.php';
		if ( file_exists( $filePath ) ):
			include_once $filePath;
		endif;
	endforeach;
endif;

/**
 * Load Global Functions
 */
ihosting_require_once( IHOSTINGCORE_CORE . 'functions.php' );

/**
 *  Load Kute Menu Walker Improved
 */
ihosting_require_once( IHOSTINGCORE_CORE . 'classes/kt_bootstrap_navwalker_improved.php' );

/**
 * Load VC Global Custom
 */
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/ts_vc_global.php' );

/**
 * Load shortcodes not for VC
 */
function ihosting_core_load_shortcodes() {
	ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/shortcodes.php' );
}

add_action( 'init', 'ihosting_core_load_shortcodes', 10 );

/**
 * Load VC Map
 */
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/vc_map.php' );


/**
 *  Load all shortcodes for VC
 **/

ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/banner_text.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/title_with_desc.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/img_with_text.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/pricing_table_1.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/client_say.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/imgs_carousel.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/button.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/custom_nav_menu.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/contact_info.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/funfact_number.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/personnel.php' );

//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/simple_title.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/simple_title_2.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/simple_text_area.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/simple_contact_info.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/custom_nav_menu.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/doc_menu.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/simple_img.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/imgs_carousel.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/imgs_grid.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/imgs_grid_tabs.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/members_carousel.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/testimonials_carousel.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/banner_text.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/banner_text_2.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/banner_text_3.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/banner_text_4.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/single_product.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/products_carousel.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/products_carousel_2.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/products_carousel_3.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/products_carousel_by_cat.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/products_carousel_by_cats_tabs.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/products_grid.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/products_carousel_tabs.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/product_categories_grid.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/product_cats_grid_tabs.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/posts_slide.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/icon_box.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/socials_list.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/news_letter.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/gmap.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'shortcodes/instagram.php' );


/**
 * Load widgets
 **/

//ihosting_require_once( IHOSTINGCORE_CORE . 'widgets/widget-socials.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'widgets/widget-instagram.php' );
//ihosting_require_once( IHOSTINGCORE_CORE . 'widgets/widget-recent-posts.php' );
ihosting_require_once( IHOSTINGCORE_CORE . 'widgets/class-ih-nav-menu-widget.php' );


function ihosting_core_init_widgets() {
	//	register_widget( 'ihostingSidgetSocial' );
	//	register_widget( 'ihostingInstagramWidget' );
	//	register_widget( 'ihostingWidgetRecentPosts' );
	register_widget( 'IH_Nav_Menu_Widget' );

	//	if ( class_exists( 'WooCommerce' ) ) {
	//		unregister_widget( 'WC_Widget_Recent_Reviews' ); // I hate this widget, no template for it =.=
	//		ihosting_require_once( IHOSTINGCORE_CORE . 'widgets/class-wc-widget-recent-reviews.php' );
	//		register_widget( 'iHosting_WC_Widget_Recent_Reviews' );
	//	}
}

add_action( 'widgets_init', 'ihosting_core_init_widgets' );

