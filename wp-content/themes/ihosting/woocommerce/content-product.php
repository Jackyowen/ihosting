<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$ihosting = ihosting_get_global_theme_options();

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

$columns = 4;
if ( isset( $ihosting['woo_products_per_row'] ) ) {
	$columns = min( 4, max( 2, intval( $ihosting['woo_products_per_row'] ) ) );
	apply_filters( 'loop_shop_columns', $columns );
}
$woocommerce_loop['columns'] = $columns;

// Ensure visibility
if ( !$product || !$product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}

switch ( $woocommerce_loop['columns'] ) {
	case 4:
		$classes[] = 'col-lg-3 col-md-4 col-sm-6 col-xs-6 col-xxs-12';
		break;
	case 3:
		$classes[] = 'col-lg-4 col-md-4 col-sm-6 col-xs-6 col-xxs-12';
		break;
	case 2:
		$classes[] = 'col-md-6 col-sm-6 col-xs-12';
		break;
	default:
		$classes[] = 'col-lg-3 col-md-4 col-sm-6 col-xs-6 col-xxs-12';
		break;
}


?>
<li <?php post_class( $classes ); ?>>

	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10 // Removed
	 * @hooked ihosting_wc_loop_product_inner_open - 10 // Added
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10 // Removed
	 * @hooked ihosting_wc_loop_thumbs_btns - 10 // Added
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10 // Removed
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5 // Removed
	 * @hooked woocommerce_template_loop_price - 10 // Removed
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5 // Removed
	 * @hooked ihosting_wc_template_loop_product_info - 25 // Added
	 * @hooked ihosting_wc_loop_product_inner_close - 30 // Added
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>

</li>
