<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see           http://docs.woothemes.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.0.0
 */

global $woocommerce_loop;

$ihosting = ihosting_get_global_theme_options();
$layout_wrap_class = isset( $ihosting['woo_shop_default_layout'] ) ? 'kt-products-' . esc_attr( $ihosting['woo_shop_default_layout'] ) . '-wrap' : 'kt-products-grid-wrap';
$layout_wrap_class .= ' products-wrap';

$columns = 4;
if ( isset( $ihosting['woo_products_per_row'] ) ) {
	$columns = min( 4, max( 2, intval( $ihosting['woo_products_per_row'] ) ) );
	apply_filters( 'loop_shop_columns', $columns );
}
$woocommerce_loop['columns'] = $columns;

$class = 'products row';
if ( isset( $woocommerce_loop['columns'] ) ) {
	$class .= ' kt-product-columns-' . esc_attr( $woocommerce_loop['columns'] );
}

?>
<div class="<?php echo esc_attr( $layout_wrap_class ); ?>">
	<ul data-columns="<?php echo esc_attr( $woocommerce_loop['columns'] ); ?>"
	    class="<?php echo esc_attr( $class ); ?>">
