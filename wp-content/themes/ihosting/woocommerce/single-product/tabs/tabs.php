<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see        http://docs.woothemes.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version    2.4.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */

$ihosting = ihosting_get_global_theme_options();
$tabs = apply_filters( 'woocommerce_product_tabs', array() );
$tabs_layout = isset( $ihosting['woo_single_product_tabs_layout'] ) ? $ihosting['woo_single_product_tabs_layout'] : 'vertical'; // horizontal, vertical
$tabs_layout = trim( $tabs_layout ) == '' ? 'vertical' : $tabs_layout;

if ( !empty( $tabs ) ) : ?>

	<div class="lk-product-tabs-container col-xs-12">
		<div class="woocommerce-tabs wc-tabs-wrapper tabs-<?php echo esc_attr( $tabs_layout ); ?>">
			<ul class="tabs wc-tabs">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab">
						<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="tab-container">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<div class="panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>">
						<?php call_user_func( $tab['callback'], $key, $tab ); ?>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
	</div>

<?php endif; ?>
