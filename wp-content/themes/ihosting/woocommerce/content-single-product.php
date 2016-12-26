<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see           http://docs.woothemes.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       1.6.4
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
/**
 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>"
     id="product-<?php the_ID(); ?>" <?php post_class( 'single-product-wrap' ); ?>>
	<div class="row">

		<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked ihosting_product_img_open_tag - 5 // Added
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 * @hooked ihosting_product_img_close_tag - 30 // Added
		 */
		do_action( 'woocommerce_before_single_product_summary' );
		?>

		<div class="entry-summary-wrap col-xs-12 col-sm-6 col-md-8">
			<div class="summary entry-summary">

				<?php
				/**
				 * woocommerce_single_product_summary hook.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10 // Removed
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_rating - 15 // Added
				 * @hooked ihosting_wc_single_sku - 16 // Added
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 */
				do_action( 'woocommerce_single_product_summary' );
				?>

			</div><!-- .summary -->
		</div><!-- /.entry-summary-wrap -->

		<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15 // Removed
		 * @hooked woocommerce_output_related_products - 20 // Removed
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>

		<meta itemprop="url" content="<?php the_permalink(); ?>"/>

	</div>
</div><!-- #product-<?php the_ID(); ?> -->

<?php
/**
 * woocommerce_after_single_product hook.
 *
 * @hooked woocommerce_upsell_display - 15 // Added
 * @hooked woocommerce_output_related_products - 20 // Added
 */
do_action( 'woocommerce_after_single_product' );
?>
