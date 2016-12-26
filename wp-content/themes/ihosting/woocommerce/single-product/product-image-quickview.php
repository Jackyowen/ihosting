<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see           http://docs.woothemes.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.0.14
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

$img_size_x = 350;
$img_size_y = 435;

?>
<div class="images">
	<?php
	$img = ihosting_resize_image( get_post_thumbnail_id(), null, $img_size_x, $img_size_y, true, true, false );
	$img_full = ihosting_resize_image( get_post_thumbnail_id(), null, 4000, 4000, true, true, false );

	if ( has_post_thumbnail() ) {
		$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
		$image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
		$image_link = esc_url( $img_full['url'] );

		$image = '<img width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" src="' . esc_url( $img['url'] ) . '" class="attachment-shop_single wp-post-image product-featured-img" alt="' . esc_attr( $image_title ) . '" title="' . esc_attr( $image_title ) . '">';

		$attachment_count = count( $product->get_gallery_attachment_ids() );

		if ( $attachment_count > 0 ) {
			$gallery = '[product-gallery]';
		}
		else {
			$gallery = '';
		}

		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );

	}
	else {

		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', esc_url( $img['url'] ), __( 'Placeholder', 'ihosting' ) ), $post->ID );

	}
	?>

	<?php wc_get_template( 'single-product/product-thumbnails.php' ); ?>
</div>
