<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$img_size_x = 100;
$img_size_y = 125;

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart" cellspacing="0">
		<thead>
		<tr>
			<th class="product-and-price"><?php _e( 'Product/Price', 'ihosting' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'ihosting' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Total', 'ihosting' ); ?></th>
			<th class="product-remove"><?php _e( 'Remove', 'ihosting' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-thumbnail" data-title="<?php _e( 'Product/Price', 'ihosting' ); ?>">
						<?php

						$img_thumb = ihosting_resize_image( $_product->get_image_id(), null, $img_size_x, $img_size_y, true, true, false );
						$img_alt = '';
						$thumb_html = '<img class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" width="' . esc_attr( $img_thumb['width'] ) . '" height="' . esc_attr( $img_thumb['height'] ) . '" src="' . esc_url( $img_thumb['url'] ) . '" alt="' . ihosting_get_img_alt( $_product->get_image_id() ) . '" />';

						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $thumb_html, $cart_item, $cart_item_key );

						if ( !$_product->is_visible() ) {
							echo $thumbnail;
						}
						else {
							printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
						}

						echo '<div class="product-info">';
						if ( !$_product->is_visible() ) {
							echo '<h6 class="product-title">' . apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '</h6>';
						}
						else {
							echo '<h6 class="product-title">' . apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key ) . '</h6>';
						}

						echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

						// Meta data
						//echo WC()->cart->get_item_data( $cart_item );
						echo ihosting_wc_get_item_data( $cart_item );

						// Backorder notification
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'ihosting' ) . '</p>';
						}
						echo '</div><!-- /.product-info -->';
						?>
					</td>

					<td class="product-quantity" data-title="<?php _e( 'Quantity', 'ihosting' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
						}
						else {
							$product_quantity = woocommerce_quantity_input( array(
								                                                'input_name'  => "cart[{$cart_item_key}][qty]",
								                                                'input_value' => $cart_item['quantity'],
								                                                'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
								                                                'min_value'   => '0'
							                                                ), $_product, false
							);
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</td>

					<td class="product-subtotal" data-title="<?php _e( 'Total', 'ihosting' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-remove" data-title="<?php _e( 'Remove', 'ihosting' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
							esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
							__( 'Remove this item', 'ihosting' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key
						);
						?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="coupon">

						<label for="coupon_code"><?php _e( 'Coupon', 'ihosting' ); ?>:</label>
						<input type="text"
						       name="coupon_code"
						       class="input-text"
						       id="coupon_code"
						       value=""
						       placeholder="<?php esc_attr_e( 'Coupon code', 'ihosting' ); ?>"/>
						<input type="submit" class="button" name="apply_coupon"
						       value="<?php esc_attr_e( 'Apply Coupon', 'ihosting' ); ?>"/>

						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>

				<input type="submit" class="button" name="update_cart"
				       value="<?php esc_attr_e( 'Update Cart', 'ihosting' ); ?>"/>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>

	<div class="cart-collaterals">

		<?php
		/**
		 * woocommerce_cart_collaterals hook
		 *
		 * @hoocked woocommerce_cross_sell_display
		 * @hooked  woocommerce_cart_totals - 10
		 *
		 **/
		do_action( 'woocommerce_cart_collaterals' );

		?>

	</div>

</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
