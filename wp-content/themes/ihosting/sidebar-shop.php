<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iHosting
 */

$ihosting = ihosting_get_global_theme_options();

$secondary_class = ihosting_shop_secondary_class();
$sidebar_pos = isset( $ihosting['woo_shop_sidebar_pos'] ) ? trim( $ihosting['woo_shop_sidebar_pos'] ) : 'right';

if ( is_product() ) {
	$sidebar_pos = isset( $ihosting['woo_single_product_sidebar_pos'] ) ? trim( $ihosting['woo_single_product_sidebar_pos'] ) : 'right';
}

?>

<?php if ( $sidebar_pos != 'fullwidth' ): ?>

	<?php if ( is_shop() || is_product_category() || is_product_tag() ) { ?>
		<div id="secondary" class="widget-area shop-widget-area <?php echo esc_attr( $secondary_class ); ?>"
		     role="complementary">
			<?php if ( is_active_sidebar( 'sidebar-shop' ) ): ?>
				<?php dynamic_sidebar( 'sidebar-shop' ); ?>
			<?php endif; ?>
		</div><!-- #secondary -->
	<?php } ?>

	<?php if ( is_product() ) { ?>
		<div id="secondary" class="widget-area shop-widget-area <?php echo esc_attr( $secondary_class ); ?>"
		     role="complementary">
			<?php if ( is_active_sidebar( 'sidebar-single-product' ) ): ?>
				<?php dynamic_sidebar( 'sidebar-single-product' ); ?>
			<?php endif; ?>
		</div><!-- #secondary -->
	<?php } ?>
<?php endif; ?>
