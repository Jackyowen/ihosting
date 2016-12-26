<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkProductsCarouselByCat' );
function lkProductsCarouselByCat() {

	global $kt_vc_anim_effects_in;

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

	vc_map(
		array(
			'name'     => esc_html__( 'LK Products Carousel By Category', 'ihosting-core' ),
			'base'     => 'lk_products_carousel_by_cat', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'ihosting_select_product_cat_field_2', // slug
					'heading'    => esc_html__( 'Category', 'ihosting-core' ),
					'param_name' => 'cat_slug',
					'std'        => '',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Items Per Slide', 'ihosting-core' ),
					'value'       => 1,
					'save_always' => true,
					'param_name'  => 'items_per_slide',
					'description' => esc_html__( 'How many items per slide on the large screen? Min = 1, max = 4.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Products Per Item', 'ihosting-core' ),
					'value'       => 3,
					'save_always' => true,
					'param_name'  => 'products_per_item',
					'description' => esc_html__( 'How many products per item? Min = 1, max = 10.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Maximum Products Number', 'ihosting-core' ),
					'value'       => 12,
					'save_always' => true,
					'param_name'  => 'max_products_num',
					'description' => esc_html__( 'How many products will load? Min = 1.', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show Category Link', 'ihosting-core' ),
					'param_name' => 'show_cat_link',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no',
					),
					'std'        => 'yes',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Category Link Text', 'ihosting-core' ),
					'value'       => esc_html__( 'View all', 'ihosting-core' ),
					'save_always' => true,
					'param_name'  => 'cat_link_text',
					'dependency'  => array(
						'element' => 'show_cat_link',
						'value'   => array( 'yes' ),
					),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show Category Image', 'ihosting-core' ),
					'param_name' => 'show_cat_img',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no',
					),
					'std'        => 'yes',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Category Image Size', 'ihosting-core' ),
					'param_name'  => 'cat_img_size',
					'std'         => '285x274',
					'description' => wp_kses( __( '<em>{width}x{height}</em>. Example: <em>285x274</em>, etc...', 'ihosting-core' ), $allowed_tags ),
					'dependency'  => array(
						'element' => 'show_cat_img',
						'value'   => array( 'yes' ),
					),
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

function lk_products_carousel_by_cat( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_products_carousel_by_cat', $atts ) : $atts;

	if ( !class_exists( 'WooCommerce' ) ) {
		return '';
	}

	extract(
		shortcode_atts(
			array(
				'cat_slug'          => '',
				'items_per_slide'   => 1,
				'products_per_item' => 3,
				'max_products_num'  => 12,
				'show_cat_link'     => 'yes',
				'cat_link_text'     => esc_html__( 'View all', 'ihosting-core' ),
				'show_cat_img'      => 'yes',
				'cat_img_size'      => '285x274',
				'css_animation'     => '',
				'animation_delay'   => '0.4',   //In second
				'css'               => '',
			), $atts
		)
	);

	$css_class = 'lk-products-carousel-by-cat-wrap ' . $css_animation;

	if ( trim( $css_animation ) != '' ) {
		$css_class .= ' wow';
	}

	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}

	$animation_delay = $animation_delay . 's';

	$img_size_x = 285;
	$img_size_y = 274;
	if ( trim( $cat_img_size ) != '' ) {
		$cat_img_size = explode( 'x', $cat_img_size );
	}
	$img_size_x = isset( $cat_img_size[0] ) ? max( 0, intval( $cat_img_size[0] ) ) : $img_size_x;
	$img_size_y = isset( $cat_img_size[1] ) ? max( 0, intval( $cat_img_size[1] ) ) : $img_size_y;

	// Remove all whitespaces
	$cat_slug = preg_replace( '/\s+/', '', $cat_slug );

	$cat_img_bg_html = '';
	$cat_title_html = '';
	$products_carousel_html = '';
	$cat_link_html = '';
	$head_html = ''; // Category image and title
	$html = '';

	if ( trim( $cat_slug ) != '' ) {
		$category = get_term_by( 'slug', trim( $cat_slug ), 'product_cat' );

		if ( $category != false ) {

			if ( $show_cat_img == 'yes' ) {
				$cat_img_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
				$cat_img = ihosting_core_resize_image( $cat_img_id, null, $img_size_x, $img_size_y, true, true, false );
				$cat_img_bg_html = '<a href="#" class="bg-image click-return-false" style="background-image: url(' . esc_url( $cat_img['url'] ) . '); height:' . $img_size_y . 'px; min-height: ' . $img_size_y . 'px;"><span class="screen-reader-text">' . sanitize_text_field( $category->name ) . '</span></a>';
			}

			$term_link = get_term_link( $category, 'product_cat' );
			if ( is_wp_error( $term_link ) ) {
				$cat_title_html = '<h6 class="product-cat-title"><span>' . sanitize_text_field( $category->name ) . '</span></h6>';
			}
			else {
				$cat_title_html = '<h6 class="product-cat-title"><a href="' . esc_url( $term_link ) . '"><span>' . sanitize_text_field( $category->name ) . '</span></a></h6>';
				if ( $show_cat_link == 'yes' && trim( $cat_link_text ) != '' ) {
					$cat_link_html = '<div class="box-footer">
										<a class="view-products-cat-details" href="' . esc_url( $term_link ) . '">' . sanitize_text_field( $cat_link_text ) . '</a>
									</div>';
				}
			}

			$head_html = '<div class="box-head">' . $cat_img_bg_html . $cat_title_html . '</div>';

			$max_products_num = max( 1, intval( $max_products_num ) );
			// Product ids
			$query_args = array(
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page'      => $max_products_num,
				'tax_query'           => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => array( $category->slug )
					)
				)
			);

			$products = new WP_Query( $query_args );
			$product_ids = '0';

			if ( $products->have_posts() ) {
				while ( $products->have_posts() ) {
					$products->the_post();
					$product_ids .= ', ' . get_the_ID();
				}
			}

			wp_reset_postdata();

			// Products carousel html
			$shortcode_carousel_text = '[lk_products_carousel_3 style="style_3" 
										product_ids="' . $product_ids . '" 
										items_per_slide="' . esc_attr( $items_per_slide ) . '" 
										products_per_item="' . esc_attr( $products_per_item ) . '" 
										border_container="no" 
										title="" 
										short_desc="" 
										css_animation=""
										]';

			$products_carousel_html = do_shortcode( $shortcode_carousel_text );
			$products_carousel_html = '<div class="box-inner">' . $products_carousel_html . '</div>';

		}

	}

	$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				' . $head_html . '
				' . $products_carousel_html . '
				' . $cat_link_html . '
            </div>';


	return $html;

}

add_shortcode( 'lk_products_carousel_by_cat', 'lk_products_carousel_by_cat' );
