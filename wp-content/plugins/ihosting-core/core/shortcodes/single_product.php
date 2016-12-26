<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkSingleProduct' );
function lkSingleProduct() {
	$allowed_tags = array(
		'em'     => array(),
		'i'      => array(),
		'b'      => array(),
		'strong' => array(),
		'a'      => array(
			'href'   => array(),
			'target' => array(),
			'class'  => array(),
			'id'     => array(),
			'title'  => array(),
		),
	);

	global $kt_vc_anim_effects_in;
	vc_map(
		array(
			'name'     => esc_html__( 'LK Single Product', 'ihosting-core' ),
			'base'     => 'lk_single_product', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'autocomplete',
					'holder'      => '',
					'class'       => '',
					'heading'     => esc_html__( 'Product', 'ihosting-core' ),
					'param_name'  => 'product_id',
					'std'         => '',
					'description' => esc_html__( 'Input product ID or product title to see suggestions.', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'CSS Animation', 'ihosting-core' ),
					'param_name' => 'css_animation',
					'value'      => $kt_vc_anim_effects_in,
					'std'        => 'fadeInUp',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Animation Delay', 'ihosting-core' ),
					'param_name'  => 'animation_delay',
					'std'         => '0.4',
					'description' => esc_html__( 'Delay unit is second.', 'ihosting-core' ),
					'dependency'  => array(
						'element'   => 'css_animation',
						'not_empty' => true,
					),
				),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'Css', 'ihosting-core' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design options', 'ihosting-core' ),
				),
			),
		)
	);
}

// vc_autocomplete_{short_code_name}_{param_name}_callback
add_filter( 'vc_autocomplete_lk_single_product_product_id_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_single_product_product_id_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

function lk_single_product( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_single_product', $atts ) : $atts;

	if ( !class_exists( 'WooCommerce' ) ) {
		return '';
	}

	extract(
		shortcode_atts(
			array(
				'product_id'      => 0,
				'css_animation'   => '',
				'animation_delay' => '0.4',   //In second
				'css'             => '',
			), $atts
		)
	);

	$css_class = 'lk-single-product-wrap ' . $css_animation;
	if ( trim( $css_animation ) != '' ) {
		$css_class .= ' wow';
	}

	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	$html = '';
	$product_details_html = '';
	$img_thumbs_html = ''; // Product images gallery
	$sale_flash_html = ''; // Sale flash html
	$product_info_html = ''; // Title, rating, short desc, price
	$countdown_html = ''; // Countdown for product is on sale

	$product_id = intval( $product_id );
	$single_product = wc_get_product( $product_id );

	if ( !$single_product ) {
		return '';
	}

	$is_on_sale = $single_product->is_on_sale();
	if ( $is_on_sale && $single_product->regular_price != 0 ) {
		$percentage = round( ( ( $single_product->regular_price - $single_product->sale_price ) / $single_product->regular_price ) * 100 );
		$sale_flash_html .= '<span class="sale-flash">' . esc_attr( $percentage ) . '&#37;</span>';
	}

	$imgs = array();

	$product_thumb_id = get_post_thumbnail_id( $product_id );

	$img_thumb = ihosting_core_resize_image( $product_thumb_id, null, 120, 120, true, true, false );
	$img = ihosting_core_resize_image( $product_thumb_id, null, 410, 410, true, true, false );
	$img_full = ihosting_core_resize_image( $product_thumb_id, null, 2000, 2000, true, true, false );
	$img['alt'] = get_post_meta( $product_thumb_id, '_wp_attachment_image_alt', true );

	$imgs[] = array(
		'thumb' => $img_thumb,
		'img'   => $img,
		'full'  => $img_full,
	);

	$img_large_html = '<div class="product-image kt-images">
                            ' . $sale_flash_html . '
                            <a href="' . esc_url( $img_full['url'] ) . '" class="zoom">
                                <img width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( $img['alt'] ) . '" title="' . esc_attr( $single_product->get_title() ) . '" />
                            </a>
                        </div><!-- /.product-image -->';

	$attachment_ids = $single_product->get_gallery_attachment_ids();
	if ( $attachment_ids ) {
		foreach ( $attachment_ids as $attachment_id ) {
			$img_thumb = ihosting_core_resize_image( $attachment_id, null, 120, 120, true, true, false );
			$img = ihosting_core_resize_image( $attachment_id, null, 410, 410, true, true, false );
			$img_full = ihosting_core_resize_image( $attachment_id, null, 2000, 2000, true, true, false );
			$img['alt'] = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

			$imgs[] = array(
				'thumb' => $img_thumb,
				'img'   => $img,
				'full'  => $img_full,
			);

		}
	}

	$i = 0;
	foreach ( $imgs as $img ) {

		$i++;
		$a_class = 'img-data';
		if ( $i == 1 ) {
			$a_class .= ' selected';
		}
		$img_thumbs_html .= '<a href="#" class="' . esc_attr( $a_class ) . '" data-img="' . htmlentities2( json_encode( $img['img'] ) ) . '" data-img-full="' . htmlentities2( json_encode( $img['full'] ) ) . '" >
                                <div class="hover-effect-diagonally">
                                    <img width="' . esc_attr( $img['thumb']['width'] ) . '" height="' . esc_attr( $img['thumb']['height'] ) . '" src="' . esc_url( $img['thumb']['url'] ) . '" alt="' . esc_attr( $img['img']['alt'] ) . '" />
                                </div>
                            </a>';
		// Maximum 3 thumbnails
		if ( $i == 3 ) {
			break;
		}
	}

	$img_thumbs_html = '<div class="thumbs">' . $img_thumbs_html . '</div>';

	$product_info_html .= '<div class="product-info">';
	$product_info_html .= '<h3 class="product-name"><a href="' . esc_url( get_permalink( $product_id ) ) . '">' . sanitize_text_field( $single_product->get_title() ) . '</a></h3>';
	$product_info_html .= $single_product->get_rating_html();
	$product_info_html .= '<div class="short-desc">' . apply_filters( 'woocommerce_short_description', $single_product->post->post_excerpt ) . '</div>';
	$product_info_html .= '<div class="price">' . $single_product->get_price_html() . '</div>';
	$product_info_html .= '</div><!-- /.product-info -->';

	if ( $is_on_sale ) {
		$css_class .= ' is-on-sale';

		$sales_price_to_timestamp = get_post_meta( $product_id, '_sale_price_dates_to', true );
		$current_timestamp = current_time( 'timestamp' );

		if ( $sales_price_to_timestamp > $current_timestamp ) {
			$css_class .= ' has-countdown';
			$sales_price_to = date_i18n( 'm/d/Y', $sales_price_to_timestamp );
			$countdown_html .= '<div class="product-countdown ihosting-countdown-wrap" data-countdown="' . htmlentities2( $sales_price_to ) . '">';
			$countdown_html .= '<div class="countdown-inner">';
			$countdown_html .= '<div class="counter-item days">
                                    <span class="number">%D</span>
                                    <span class="lbl">' . esc_html__( 'Days', 'ihosting-core' ) . '</span>
                                </div>
                                <div class="counter-item hrs">
                                    <span class="number">%H</span>
                                    <span class="lbl">' . esc_html__( 'Hrs', 'ihosting-core' ) . '</span>
                                </div>
                                <div class="counter-item mins">
                                    <span class="number">%M</span>
                                    <span class="lbl">' . esc_html__( 'Mins', 'ihosting-core' ) . '</span>
                                </div>
                                <div class="counter-item secs">
                                    <span class="number">%S</span>
                                    <span class="lbl">' . esc_html__( 'Secs', 'ihosting-core' ) . '</span>
                                </div>';
			$countdown_html .= '</div><!-- /.countdown-inner -->';
			$countdown_html .= '</div><!-- /.product-countdown -->';
		}
	}


	$product_details_html .= '<div class="product-details">';
	$product_details_html .= '<div class="product-details-inner">';
	$product_details_html .= $img_large_html . $product_info_html;
	$product_details_html .= '</div><!-- /.product-details-inner -->';
	$product_details_html .= '</div><!-- /.product-details -->';

	$html .= '<div class="' . esc_attr( $css_class ) . '">';
	$html .= $img_thumbs_html . $product_details_html . $countdown_html;
	$html .= '</div>';

	return $html;

}

add_shortcode( 'lk_single_product', 'lk_single_product' );
