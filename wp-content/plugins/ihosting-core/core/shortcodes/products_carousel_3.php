<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkProductsCarousel3' );
function lkProductsCarousel3() {

	global $kt_vc_anim_effects_in;
	vc_map(
		array(
			'name'     => esc_html__( 'LK Products Carousel 3', 'ihosting-core' ),
			'base'     => 'lk_products_carousel_3', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Style', 'ihosting-core' ),
					'param_name' => 'style',
					'value'      => array(
						esc_html__( 'Style 1', 'ihosting-core' )                     => 'style_1',
						esc_html__( 'Style 2', 'ihosting-core' )                     => 'style_2',
						esc_html__( 'Style 3 (for small spacing)', 'ihosting-core' ) => 'style_3',
					),
					'std'        => 'style_1',
				),
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
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Products Per Item', 'ihosting-core' ),
					'value'       => 2,
					'save_always' => true,
					'param_name'  => 'products_per_item',
					'description' => esc_html__( 'How many products per item? Min = 1, max = 10.', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Border Container', 'ihosting-core' ),
					'param_name' => 'border_container',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no',
					),
					'std'        => 'no',
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
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'ihosting-core' ),
					'std'         => esc_html__( 'Hot Deals of the Day!', 'ihosting-core' ),
					'save_always' => true,
					'param_name'  => 'title',
					'group'       => esc_html__( 'Heading options', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Short Description', 'ihosting-core' ),
					'std'         => esc_html__( 'The time is counting down. Come & buy theme now !', 'ihosting-core' ),
					'save_always' => true,
					'param_name'  => 'short_desc',
					'group'       => esc_html__( 'Heading options', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Hidden Short Description On', 'ihosting-core' ),
					'param_name' => 'hidden_short_desc_on',
					'value'      => array(
						esc_html__( 'Extra small devices', 'ihosting-core' ) => 'hidden-xs',
						esc_html__( 'Small devices', 'ihosting-core' )       => 'hidden-sm',
						esc_html__( 'Medium devices', 'ihosting-core' )      => 'hidden-md',
						esc_html__( 'Aways show', 'ihosting-core' )          => '',
					),
					'std'        => 'hidden-xs',
					'group'      => esc_html__( 'Heading options', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Heading Background Color', 'ihosting-core' ),
					'param_name' => 'heading_bg_color',
					'std'        => '#4e4e4e',
					'group'      => esc_html__( 'Heading options', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
					'param_name' => 'title_color',
					'std'        => '#fff',
					'group'      => esc_html__( 'Heading options', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Sort Description Color', 'ihosting-core' ),
					'param_name' => 'short_desc_color',
					'std'        => '#fff',
					'group'      => esc_html__( 'Heading options', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Auto Height Equal To', 'ihosting-core' ),
					'param_name'  => 'auto_height_equal_to',
					'std'         => '',
					'description' => esc_html__( 'Enter html selector that you want the carousel have height equal to. Ex: #chair-and-sofas', 'ihosting-core' ),
					'group'       => esc_html__( 'Height Options', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Max Of Auto Height', 'ihosting-core' ),
					'param_name'  => 'max_of_auto_height',
					'std'         => '',
					'description' => esc_html__( 'Set height threshold for auto calculate. Ex: 524. Unit is pixel.', 'ihosting-core' ),
					'group'       => esc_html__( 'Height Options', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Disable Auto Height Break Point', 'ihosting-core' ),
					'param_name'  => 'auto_height_break_point',
					'std'         => '1199',
					'description' => esc_html__( 'Set screen width threshold to disable auto equal height. Ex: 1199. Unit is pixel.', 'ihosting-core' ),
					'group'       => esc_html__( 'Height Options', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Decrease Auto Height', 'ihosting-core' ),
					'param_name'  => 'decrease_auto_height_selector',
					'std'         => '',
					'description' => esc_html__( 'Example: #block-head, .block-head, #somecontainer | Height auto will be decreased with the height of these containers', 'ihosting-core' ),
					'group'       => esc_html__( 'Height Options', 'ihosting-core' ),
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
add_filter( 'vc_autocomplete_lk_products_carousel_3_product_ids_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_3_product_ids_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

function lk_products_carousel_3( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_products_carousel_3', $atts ) : $atts;

	if ( !class_exists( 'WooCommerce' ) ) {
		return '';
	}

	extract(
		shortcode_atts(
			array(
				'style'                         => 'style_1',
				'product_ids'                   => '',
				'items_per_slide'               => 4,
				'products_per_item'             => 2,
				'border_container'              => 'no',
				'css_animation'                 => '',
				'animation_delay'               => '0.4',   //In second
				'title'                         => '',
				'short_desc'                    => '',
				'hidden_short_desc_on'          => 'hidden-xs',
				'heading_bg_color'              => '#4e4e4e',
				'title_color'                   => '#ffffff',
				'short_desc_color'              => '#ffffff',
				'auto_height_equal_to'          => '',
				'max_of_auto_height'            => '',
				'auto_height_break_point'       => '1199',
				'decrease_auto_height_selector' => '',
				'css'                           => '',
			), $atts
		)
	);

	$css_class = 'lk-products-carousel-3-wrap ' . $css_animation;

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

	$title_html = '';
	$html = '';

	if ( trim( $title . $short_desc ) != '' ) {
		$title_html .= '<div class="block-head" style="background-color: ' . esc_attr( $heading_bg_color ) . ';">';
		if ( trim( $title ) != '' ) {
			$title_html .= '<h5 class="block-head-title" style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $title ) . '</h5>';
		}
		if ( trim( $short_desc ) != '' ) {
			$title_html .= '<span class="block-head-desc ' . esc_attr( $hidden_short_desc_on ) . '" style="color: ' . esc_attr( $short_desc_color ) . ';">' . sanitize_text_field( $short_desc ) . '</span>';
		}
		$title_html .= '</div><!-- /.block-head -->';
	}

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

		$products_per_item = min( $total_products, max( 1, intval( $products_per_item ) ) );
		$total_items = 0;

		if ( $products->have_posts() ) :
			$i = 0;
			$item_number = 1;
			$total_items = ceil( $total_products / $products_per_item );

			// Open first ul
			$html .= '<ul class="products row" data-item-number="' . $item_number . '">';
			while ( $products->have_posts() ) : $products->the_post();
				$i++;
				ob_start();
				wc_get_template_part( 'content', 'product' );
				$html .= ob_get_clean();
				if ( ( $i % $products_per_item == 0 ) && $i < $total_products ) {
					$item_number++;
					$html .= '</ul>';
					$html .= '<ul class="products row" data-item-number="' . $item_number . '">';
				}

			endwhile;
			$html .= '</ul>';

		endif; // End if ( $products->have_posts() )
		wp_reset_postdata();

		if ( trim( $html ) != '' ) {
			$carousel_loop = $total_items > 4 ? 'yes' : 'no';
			//$autoplay = $carousel_loop;
			$autoplay = 'no';
			$html_attr = 'data-number="' . intval( $items_per_slide ) . '" data-total-items="' . esc_attr( $total_items ) . '" data-loop="' . esc_attr( $carousel_loop ) . '" data-navControl="yes" data-Dots="no" data-autoPlay="' . esc_attr( $autoplay ) . '" data-products-per-item="' . $products_per_item . '" data-autoPlayTimeout="4000" data-margin="1" data-rtl="no"';
			$html = '<div class="products-carousel-3 ihosting-owl-carousel nav-center nav-style-1" ' . $html_attr . ' >
						' . $html . '
					</div><!-- /.products-carousel-3 -->';
		}

		if ( trim( $html ) != '' || trim( $title_html ) != '' ) {

			$inner_class = 'products-wrap product-carousel-3-' . esc_attr( $style );
			if ( $style == 'style_1' ) {
				$inner_class .= ' kt-products-grid-wrap';
			}
			if ( $style == 'style_2' || $style == 'style_3' ) {
				$inner_class .= ' kt-products-list-wrap';
			}

			if ( $border_container == 'yes' ) {
				$inner_class .= ' border_1px';
			}

			if ( trim( $auto_height_equal_to ) != '' ) {
				$max_of_auto_height = str_replace( 'px', '', strtolower( $max_of_auto_height ) );
				$max_of_auto_height = intval( $max_of_auto_height ) <= 0 ? 0 : intval( $max_of_auto_height );
				$inner_class .= ' lk-products-carousel-auto-height auto-height-equal-to';
			}

			$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
						' . $title_html . '
                        <div class="' . esc_attr( $inner_class ) . '" data-equal-to-selector="' . esc_attr( $auto_height_equal_to ) . '" data-max-of-auto-height="' . $max_of_auto_height . '" data-auto-height-break-point="' . intval( $auto_height_break_point ) . '" data-decrease-selector="' . esc_attr( $decrease_auto_height_selector ) . '">
                            ' . $html . '
                        </div>
                    </div>';

		}
	}

	return $html;

}

add_shortcode( 'lk_products_carousel_3', 'lk_products_carousel_3' );
