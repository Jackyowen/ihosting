<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkProductsCarouselTabs' );
function lkProductsCarouselTabs() {
	global $kt_vc_anim_effects_in;

	$tab_fields = array();
	for ( $i = 1; $i <= 8; $i++ ) {
		$dep_array = array();
		for ( $k = 8; $k >= $i; $k-- ) {
			$dep_array[] = $k . '_tab';
		}
		$tab_fields[] = array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Tab Title', 'ihosting-core' ),
				'value'       => esc_html__( 'Tab Title', 'ihosting-core' ),
				'save_always' => true,
				'param_name'  => 'tab_title_' . $i,
				'dependency'  => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'       => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
				'holder'     => 'h5',
			),
			array(
				'type'        => 'autocomplete',
				'heading'     => esc_html__( 'Products', 'ihosting-core' ),
				'param_name'  => 'product_ids_' . $i,
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
				'save_always' => true,
				'std'         => '',
				'description' => esc_html__( 'Input product ID or product title to see suggestions.', 'ihosting-core' ),
				'dependency'  => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'       => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Items Per Slide', 'ihosting-core' ),
				'value'       => 4,
				'save_always' => true,
				'param_name'  => 'items_per_slide_' . $i,
				'description' => esc_html__( 'How many items per slide on the large screen? Min = 1, max = 4.', 'ihosting-core' ),
				'dependency'  => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'       => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Items Per Slide', 'ihosting-core' ),
				'value'       => 2,
				'save_always' => true,
				'param_name'  => 'products_per_item_' . $i,
				'description' => esc_html__( 'How many products per item? Min = 1, max = 10.', 'ihosting-core' ),
				'dependency'  => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'       => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'       => 'dropdown',
				'class'      => '',
				'heading'    => esc_html__( 'Products Animation When Change Tab', 'ihosting-core' ),
				'param_name' => 'products_animation_' . $i,
				'value'      => $kt_vc_anim_effects_in,
				'std'        => 'fadeInUp',
				'dependency' => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'      => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
		);
	}

	vc_map(
		array(
			'name'     => esc_html__( 'LK Products Carousel Tabs', 'ihosting-core' ),
			'base'     => 'lk_products_carousel_tabs', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Style', 'ihosting-core' ),
					'param_name' => 'style',
					'value'      => array(
						esc_html__( 'Style 1', 'ihosting-core' ) => 'style_1',
						esc_html__( 'Style 2', 'ihosting-core' ) => 'style_2',
					),
					'std'        => 'style_1',
					'holder'     => 'div',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Number Of Tabs', 'ihosting-core' ),
					'param_name' => 'num_of_tabs',
					'value'      => array(
						esc_html__( '1 tab', 'ihosting-core' )  => '1_tab',
						esc_html__( '2 tabs', 'ihosting-core' ) => '2_tab',
						esc_html__( '3 tabs', 'ihosting-core' ) => '3_tab',
						esc_html__( '4 tabs', 'ihosting-core' ) => '4_tab',
						esc_html__( '5 tabs', 'ihosting-core' ) => '5_tab',
						esc_html__( '6 tabs', 'ihosting-core' ) => '6_tab',
						esc_html__( '7 tabs', 'ihosting-core' ) => '7_tab',
						esc_html__( '8 tabs', 'ihosting-core' ) => '8_tab',
					),
					'std'        => '3_tab',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'ihosting-core' ),
					'std'         => esc_html__( 'Hot Deals of the Day!', 'ihosting-core' ),
					'save_always' => true,
					'param_name'  => 'title',
					'holder'      => 'h3',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Heading Background Color', 'ihosting-core' ),
					'param_name' => 'heading_bg_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
					'param_name' => 'title_color',
					'std'        => '#444',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Try Border On Equal Height Row', 'ihosting-core' ),
					'param_name' => 'try_border_on_equal_row',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'try-border-equal-row',
						esc_html__( 'No', 'ihosting-core' )  => 'no-border-equal-row',
					),
					'std'        => 'try-border-equal-row',
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
				$tab_fields[0][0],
				$tab_fields[0][1],
				$tab_fields[0][2],
				$tab_fields[0][3],
				$tab_fields[0][4],

				$tab_fields[1][0],
				$tab_fields[1][1],
				$tab_fields[1][2],
				$tab_fields[1][3],
				$tab_fields[1][4],

				$tab_fields[2][0],
				$tab_fields[2][1],
				$tab_fields[2][2],
				$tab_fields[2][3],
				$tab_fields[2][4],

				$tab_fields[3][0],
				$tab_fields[3][1],
				$tab_fields[3][2],
				$tab_fields[3][3],
				$tab_fields[3][4],

				$tab_fields[4][0],
				$tab_fields[4][1],
				$tab_fields[4][2],
				$tab_fields[4][3],
				$tab_fields[4][4],

				$tab_fields[5][0],
				$tab_fields[5][1],
				$tab_fields[5][2],
				$tab_fields[5][3],
				$tab_fields[5][4],

				$tab_fields[6][0],
				$tab_fields[6][1],
				$tab_fields[6][2],
				$tab_fields[6][3],
				$tab_fields[6][4],

				$tab_fields[7][0],
				$tab_fields[7][1],
				$tab_fields[7][2],
				$tab_fields[7][3],
				$tab_fields[7][4],
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
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_1_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_1_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_2_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_2_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_3_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_3_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_4_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_4_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_5_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_5_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_6_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_6_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_7_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_7_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_8_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_tabs_product_ids_8_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)


function lk_products_carousel_tabs( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_products_carousel_tabs', $atts ) : $atts;

	if ( !class_exists( 'WooCommerce' ) ) {
		return '';
	}

	extract(
		shortcode_atts(
			array(
				'style'                   => 'style_1',
				'num_of_tabs'             => '3_tab',
				'title'                   => '',
				'heading_bg_color'        => '#4e4e4e',
				'title_color'             => '#ffffff',
				'try_border_on_equal_row' => 'try-border-equal-row',

				'product_ids_1'        => '',
				'tab_title_1'          => '',
				'items_per_slide_1'    => 4,
				'products_per_item_1'  => 2,
				'products_animation_1' => '',

				'tab_title_2'          => '',
				'product_ids_2'        => '',
				'items_per_slide_2'    => 4,
				'products_per_item_2'  => 2,
				'products_animation_2' => '',

				'tab_title_3'          => '',
				'product_ids_3'        => '',
				'items_per_slide_3'    => 4,
				'products_per_item_3'  => 2,
				'products_animation_3' => '',

				'tab_title_4'          => '',
				'product_ids_4'        => '',
				'items_per_slide_4'    => 4,
				'products_per_item_4'  => 2,
				'products_animation_4' => '',

				'tab_title_5'          => '',
				'product_ids_5'        => '',
				'items_per_slide_5'    => 4,
				'products_per_item_5'  => 2,
				'products_animation_5' => '',

				'tab_title_6'          => '',
				'product_ids_6'        => '',
				'items_per_slide_6'    => 4,
				'products_per_item_6'  => 2,
				'products_animation_6' => '',

				'tab_title_7'          => '',
				'product_ids_7'        => '',
				'items_per_slide_7'    => 4,
				'products_per_item_7'  => 2,
				'products_animation_7' => '',

				'tab_title_8'          => '',
				'product_ids_8'        => '',
				'items_per_slide_8'    => 4,
				'products_per_item_8'  => 2,
				'products_animation_8' => '',

				'css_animation'   => '',
				'animation_delay' => '0.4',   //In second
				'css'             => '',
			), $atts
		)
	);

	$css_class = 'lk-products-carousel-tabs-wrap wow ' . $css_animation . ' ' . $try_border_on_equal_row;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}
	$animation_delay = $animation_delay . 's';

	// Validate params
	$num_of_tabs = max( 1, intval( str_replace( '_tab', '', $num_of_tabs ) ) );

	$title_html = '';
	$tab_head_html = '';
	$tabs_nav_html = '';
	$tabs_content_html = '';
	$tabs_html = '';
	$html = '';

	for ( $i = 1; $i <= $num_of_tabs; $i++ ) {
		$tab_id = uniqid( 'tab_' );
		$tab_nav_li_class = 'tab-nav-item';
		$tab_content_class = 'tab-panel';
		if ( $i == 1 ) {
			$tab_nav_li_class .= ' active'; // Active first tab
			$tab_content_class .= ' active'; // Active first tab
		}
		$tab_title_param = 'tab_title_' . $i;
		$product_ids_param = 'product_ids_' . $i;
		$items_per_slide_param = 'items_per_slide_' . $i;
		$products_per_item_param = 'products_per_item_' . $i;
		$products_animation_param = 'products_animation_' . $i;

		$tab_title = $$tab_title_param;
		$product_ids = $$product_ids_param;
		$items_per_slide = $$items_per_slide_param;
		$products_per_item = $$products_per_item_param;
		$products_animation = $$products_animation_param;

		// Get tabs nav html
		$tabs_nav_html .= '<li class="' . $tab_nav_li_class . '"><a data-animated="' . esc_attr( $products_animation ) . '" data-toggle="tab" href="#' . esc_attr( $tab_id ) . '">' . sanitize_text_field( $tab_title ) . '</a></li>';

		// Get tabs content html
		$tabs_content_html .= '<div id="' . esc_attr( $tab_id ) . '" class="' . $tab_content_class . '">';
		$tabs_content_html .= do_shortcode( '[lk_products_carousel_3 style="' . esc_attr( $style ) . '" product_ids="' . esc_attr( $product_ids ) . '" items_per_slide="' . esc_attr( $items_per_slide ) . '" products_per_item="' . esc_attr( $products_per_item ) . '" title="" short_desc=""]' );
		$tabs_content_html .= '</div>';

	}
	$tabs_nav_html = '<ul class="nav-tab">' . $tabs_nav_html . '</ul>';
	$tabs_content_html = '<div class="tab-container">' . $tabs_content_html . '</div>';

	if ( trim( $title ) != '' ) {
		$title_html .= '<h3 class="tab-title" style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $title ) . '</h3>';
	}

	$tab_head_html .= '<div class="tab-head" style="background-color: ' . esc_attr( $heading_bg_color ) . ';">';
	$tab_head_html .= $title_html . $tabs_nav_html;
	$tab_head_html .= '</div><!-- /.tab-head -->';

	$tabs_html .= '<div class="kt-tabs kt-tabs-effect">';
	$tabs_html .= $tab_head_html . $tabs_content_html;
	$tabs_html .= '</div><!-- /.kt-tabs -->';

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">';
	$html .= $tabs_html;
	$html .= '</div>';

	return $html;

}

add_shortcode( 'lk_products_carousel_tabs', 'lk_products_carousel_tabs' );
