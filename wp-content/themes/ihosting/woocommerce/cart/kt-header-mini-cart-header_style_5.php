<?php
/**
 * Mini Cart For Header Style: style_5
 *
 * @author  Gordon Freeman
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce;

$items_text = $woocommerce->cart->cart_contents_count > 1 ? esc_html__( 'items', 'ihosting' ) : esc_html__( 'item', 'ihosting' );
$cart_subtotal = 0;

if ( !WC()->cart->is_empty() ) {
	$cart_subtotal = WC()->cart->get_cart_subtotal();
}

?>

<div class="mini-shopping-cart-wrap">
	<div class="header-view-cart-icon">
		<a title="<?php esc_html_e( 'View your shopping cart', 'ihosting' ); ?>"
		   href="<?php echo esc_url( wc_get_cart_url() ); ?>"
		   class="cart-link">
			<span class="menu-icon icon pe-7s-cart"></span>
			<?php echo sprintf( '<span class="count">%d</span>', $woocommerce->cart->cart_contents_count ); ?>
			<span class="text"><?php esc_html_e( 'Cart', 'ihosting' ); ?></span>
			<span class="kak">:</span>
			<span class="subtotal"><?php echo wptexturize( $cart_subtotal ); ?></span>
		</a>
	</div>

	<div class="mini-cart-content">
		<div class="content-inner">
			<h4 class="box-title">
				<?php echo wp_kses(
					sprintf( __( 'You have <span class="count"><span class="number-of-items">%d</span> %s</span> in your cart.', 'ihosting' ), $woocommerce->cart->cart_contents_count, $items_text ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				); ?>
			</h4>
			<div class="widget_shopping_cart_content">
				<?php if ( $woocommerce->cart->cart_contents_count > 0 ) { ?>
					<?php woocommerce_mini_cart(); ?>
				<?php } ?>
			</div>
		</div>
	</div>

</div>
