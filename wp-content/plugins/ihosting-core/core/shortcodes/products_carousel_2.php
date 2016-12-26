<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkProductsCarousel2' );
function lkProductsCarousel2() {

	global $kt_vc_anim_effects_in;
	vc_map(
		array(
			'name'     => esc_html__( 'LK Products Carousel 2', 'ihosting-core' ),
			'base'     => 'lk_products_carousel_2', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'autocomplete',
					'heading'     => esc_html__( 'Products', 'ihosting-core' ),
					'param_name'  => 'product_ids',
					'settings'    => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'std'         => '',
					'description' => esc_html__( 'Input product ID or product title to see suggestions.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Items Per Slide', 'ihosting-core' ),
					'value'       => 4,
					'save_always' => true,
					'param_name'  => 'items_per_slide',
					'description' => esc_html__( 'How many items per slide on the large screen? Min = 1, max = 4.', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Margin Between Products', 'ihosting-core' ),
					'param_name' => 'products_margin',
					'value'      => array(
						esc_html__( 'Margin', 'ihosting-core' )    => '10',
						esc_html__( 'No margin', 'ihosting-core' ) => '0',
					),
					'std'        => '10',
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
add_filter( 'vc_autocomplete_lk_products_carousel_2_product_ids_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_2_product_ids_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

function lk_products_carousel_2( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_products_carousel_2', $atts ) : $atts;

	if ( !class_exists( 'WooCommerce' ) ) {
		return '';
	}

	extract(
		shortcode_atts(
			array(
				'product_ids'     => '',
				'items_per_slide' => 4,
				'products_margin' => '10',
				'css_animation'   => '',
				'animation_delay' => '0.4',   //In second
				'css'             => '',
			), $atts
		)
	);

	$css_class = 'lk-products-carousel-2-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	$html = '';

	if ( trim( $product_ids ) != '' ) {
		$product_ids = explode( ',', $product_ids );

		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'post__in'            => $product_ids,
			'posts_per_page'      => -1,
		);

		$products = new WP_Query( $query_args );
		$total_products = $products->found_posts;

		ob_start();
		if ( $products->have_posts() ) :
			while ( $products->have_posts() ) : $products->the_post();

				wc_get_template_part( 'content', 'product' );

			endwhile;

		endif; // End if ( $products->have_posts() )
		$html .= ob_get_clean();
		wp_reset_postdata();

		if ( trim( $html ) != '' ) {
			$carousel_loop = intval( $total_products ) > 4 ? 'yes' : 'no';
			$autoplay = $carousel_loop;
			$html_attr = 'data-number="' . intval( $items_per_slide ) . '" total-items="' . intval( $total_products ) . '" data-loop="' . esc_attr( $carousel_loop ) . '" data-navControl="yes" data-Dots="no" data-autoPlay="' . esc_attr( $autoplay ) . '" data-autoPlayTimeout="4000" data-margin="' . intval( $products_margin ) . '" data-rtl="no"';
			$html = '<ul class="products row products-carousel-2 ihosting-owl-carousel nav-center nav-style-1" ' . $html_attr . ' >
						' . $html . '
					</ul>';
		}

		if ( !empty( $product_ids ) ) {

			$html = '<div class="' . esc_attr( $css_class ) . '">
                        <div class="kt-products-grid-wrap products-wrap">
                            ' . $html . '
                        </div>
                    </div>';

		}
	}

	return $html;

}

add_shortcode( 'lk_products_carousel_2', 'lk_products_carousel_2' );
