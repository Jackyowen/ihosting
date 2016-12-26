<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

function lk_get_product_carousel_by_cat_tab_fields() {
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
				'value'       => sprintf( esc_html__( 'Tab Title #%d', 'ihosting-core' ), $i ),
				'save_always' => true,
				'param_name'  => 'tab_title_' . $i,
				'dependency'  => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'       => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'       => 'ihosting_select_product_cat_field_2', // slug
				'heading'    => esc_html__( 'Category 1', 'ihosting-core' ),
				'param_name' => 'cat_slug_1_' . $i,
				'std'        => '',
				'dependency' => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'      => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'       => 'ihosting_select_product_cat_field_2', // slug
				'heading'    => esc_html__( 'Category 2', 'ihosting-core' ),
				'param_name' => 'cat_slug_2_' . $i,
				'std'        => '',
				'dependency' => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'      => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'       => 'ihosting_select_product_cat_field_2', // slug
				'heading'    => esc_html__( 'Category 3', 'ihosting-core' ),
				'param_name' => 'cat_slug_3_' . $i,
				'std'        => '',
				'dependency' => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'      => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'       => 'ihosting_select_product_cat_field_2', // slug
				'heading'    => esc_html__( 'Category 4', 'ihosting-core' ),
				'param_name' => 'cat_slug_4_' . $i,
				'std'        => '',
				'dependency' => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'      => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Items Per Slide', 'ihosting-core' ),
				'value'       => 1,
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
				'heading'     => esc_html__( 'Products Per Item', 'ihosting-core' ),
				'value'       => 3,
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
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Maximum Products Number', 'ihosting-core' ),
				'value'       => 12,
				'save_always' => true,
				'param_name'  => 'max_products_num_' . $i,
				'description' => esc_html__( 'How many products will load for each category? Min = 1.', 'ihosting-core' ),
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
				'param_name' => 'cats_animation_' . $i,
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

	return $tab_fields;
}

add_action( 'vc_before_init', 'lkProductsCarouselByCatsTabs' );
function lkProductsCarouselByCatsTabs() {
	if ( !class_exists( 'WooCommerce' ) ) {
		return;
	}

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

	$tab_fields = lk_get_product_carousel_by_cat_tab_fields();

	$vc_map = array(
		'name'     => esc_html__( 'LK Products Carousel By Categories Tabs', 'ihosting-core' ),
		'base'     => 'lk_products_carousel_by_cats_tabs', // shortcode
		'class'    => '',
		'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
		'params'   => array(
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
				'heading'     => esc_html__( 'Tabs Heading', 'ihosting-core' ),
				'std'         => esc_html__( 'Shopping', 'ihosting-core' ),
				'save_always' => true,
				'param_name'  => 'title',
				'holder'      => 'h3',
			),
			array(
				'type'       => 'colorpicker',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Tabs Heading Color', 'ihosting-core' ),
				'param_name' => 'title_color',
				'std'        => '#444',
			),
			array(
				'type'       => 'dropdown',
				'class'      => '',
				'heading'    => esc_html__( 'Show Categories Link', 'ihosting-core' ),
				'param_name' => 'show_cat_link',
				'value'      => array(
					esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
					esc_html__( 'No', 'ihosting-core' )  => 'no',
				),
				'std'        => 'yes',
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Categories Link Text', 'ihosting-core' ),
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
				'heading'    => esc_html__( 'Show Categories Image', 'ihosting-core' ),
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
				'heading'     => esc_html__( 'Categories Image Size', 'ihosting-core' ),
				'param_name'  => 'cat_img_size',
				'std'         => '285x274',
				'description' => wp_kses( __( '<em>{width}x{height}</em>. Example: <em>285x274</em>, etc...', 'ihosting-core' ), $allowed_tags ),
				'dependency'  => array(
					'element' => 'show_cat_img',
					'value'   => array( 'yes' ),
				),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Set Tabs ID', 'ihosting-core' ),
				'param_name'  => 'tabs_id', // Tabs html id
				'std'         => '',
				'description' => esc_html__( 'Enter tabs ID (Note: make sure it is unique and valid according to w3c specification).', 'ihosting-core' ),
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
		),
	);

	foreach ( $tab_fields as $fields ) {
		foreach ( $fields as $field ) {
			$vc_map['params'][] = $field;
		}
	}

	$vc_map['params'][] = array(
		'type'        => 'textfield',
		'holder'      => 'div',
		'class'       => '',
		'heading'     => esc_html__( 'The Floor ID', 'ihosting-core' ),
		'param_name'  => 'floor_id',
		'std'         => uniqid( 'floor_' ),
		'description' => esc_html__( 'Enter the floor ID (Note: make sure it is unique and valid according to w3c specification).', 'ihosting-core' ),
		'group'       => esc_html__( 'Elevator options', 'ihosting-core' ),
	);
	$vc_map['params'][] = array(
		'type'       => 'dropdown',
		'class'      => '',
		'heading'    => esc_html__( 'Elevator 1', 'ihosting-core' ),
		'param_name' => 'elevator_1_type',
		'value'      => array(
			esc_html__( 'Custom ID', 'ihosting-core' )                  => 'custom_id',
			esc_html__( 'Auto run to previous floor', 'ihosting-core' ) => 'auto',
		),
		'std'        => 'auto',
		'group'      => esc_html__( 'Elevator options', 'ihosting-core' ),
	);
	$vc_map['params'][] = array(
		'type'        => 'textfield',
		'holder'      => 'div',
		'class'       => '',
		'heading'     => esc_html__( 'Elevator 1 Target', 'ihosting-core' ),
		'param_name'  => 'elevator_1_target',
		'description' => esc_html__( 'Enter a html element ID', 'ihosting-core' ),
		'dependency'  => array(
			'element' => 'elevator_1_type',
			'value'   => array( 'custom_id' ),
		),
		'group'       => esc_html__( 'Elevator options', 'ihosting-core' ),
	);
	$vc_map['params'][] = array(
		'type'       => 'dropdown',
		'class'      => '',
		'heading'    => esc_html__( 'Elevator 2', 'ihosting-core' ),
		'param_name' => 'elevator_2_type',
		'value'      => array(
			esc_html__( 'Custom ID', 'ihosting-core' )              => 'custom_id',
			esc_html__( 'Auto run to next floor', 'ihosting-core' ) => 'auto',
		),
		'std'        => 'auto',
		'group'      => esc_html__( 'Elevator options', 'ihosting-core' ),
	);
	$vc_map['params'][] = array(
		'type'        => 'textfield',
		'holder'      => 'div',
		'class'       => '',
		'heading'     => esc_html__( 'Elevator 2 Target', 'ihosting-core' ),
		'param_name'  => 'elevator_2_target',
		'description' => esc_html__( 'Enter a html element ID', 'ihosting-core' ),
		'dependency'  => array(
			'element' => 'elevator_2_type',
			'value'   => array( 'custom_id' ),
		),
		'group'       => esc_html__( 'Elevator options', 'ihosting-core' ),
	);

	$vc_map['params'][] = array(
		'type'       => 'css_editor',
		'heading'    => esc_html__( 'Css', 'ihosting-core' ),
		'param_name' => 'css',
		'group'      => esc_html__( 'Design options', 'ihosting-core' ),
	);

	vc_map(
		$vc_map
	);
}

function lk_products_carousel_by_cats_tabs( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_products_carousel_by_cats_tabs', $atts ) : $atts;

	if ( !class_exists( 'WooCommerce' ) ) {
		return '';
	}

	$default_atts = array(
		'num_of_tabs'       => '3_tab',
		'title'             => '',
		'title_color'       => '#444',
		'show_cat_link'     => 'yes',
		'cat_link_text'     => esc_html__( 'View all', 'ihosting-core' ),
		'show_cat_img'      => 'yes',
		'cat_img_size'      => '285x274',
		'tabs_id'           => '', // Tabs html id
		'css_animation'     => '',
		'animation_delay'   => '0.4',   //In second
		'floor_id'          => '',
		'elevator_1_type'   => 'auto',
		'elevator_1_target' => '',
		'elevator_2_type'   => 'auto',
		'elevator_2_target' => '',
		'css'               => '',
	);

	$tab_fields = lk_get_product_carousel_by_cat_tab_fields();
	foreach ( $tab_fields as $fields ) {
		foreach ( $fields as $field ) {
			$default_atts[$field['param_name']] = '';
		}
	}

	extract(
		shortcode_atts(
			$default_atts, $atts
		)
	);

	$css_class = 'lk-products-carousel-by-cats-tabs-wrap lk-tabs-floor-style wow ' . $css_animation;
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
	$elevator_html = '';
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
		$cat_slug_1_param = 'cat_slug_1_' . $i;
		$cat_slug_2_param = 'cat_slug_2_' . $i;
		$cat_slug_3_param = 'cat_slug_3_' . $i;
		$cat_slug_4_param = 'cat_slug_4_' . $i;
		$items_per_slide_param = 'items_per_slide_' . $i;
		$products_per_item_param = 'products_per_item_' . $i;
		$max_products_num_param = 'max_products_num_' . $i;
		$cats_animation_param = 'cats_animation_' . $i;

		$tab_title = $$tab_title_param;
		$cat_slug_1 = $$cat_slug_1_param;
		$cat_slug_2 = $$cat_slug_2_param;
		$cat_slug_3 = $$cat_slug_3_param;
		$cat_slug_4 = $$cat_slug_4_param;
		$items_per_slide = $$items_per_slide_param;
		$products_per_item = $$products_per_item_param;
		$max_products_num = $$max_products_num_param;
		$cats_animation = $$cats_animation_param;

		// Get tabs nav html
		$tabs_nav_html .= '<li class="' . $tab_nav_li_class . '"><a data-animated="' . esc_attr( $cats_animation ) . '" data-toggle="tab" href="#' . esc_attr( $tab_id ) . '">' . sanitize_text_field( $tab_title ) . '</a></li>';

		// Get tabs content html
		$tabs_content_html .= '<div id="' . esc_attr( $tab_id ) . '" class="' . $tab_content_class . '">';

		$number_of_carousels = count( array_filter( array( $cat_slug_1, $cat_slug_2, $cat_slug_3, $cat_slug_4 ) ) );

		if ( $number_of_carousels > 0 ) {
			$carousel_wrap_class = 'col-xxs-12 col-xs-6 col-sm-6 col-md-3 padding-5'; // Default 4 columns
			switch ( $number_of_carousels ) {
				case 1:
					$carousel_wrap_class = 'col-sm-12 padding-5';
					break;
				case 2:
					$carousel_wrap_class = 'col-sm-6 padding-5';
					break;
				case 3:
					$carousel_wrap_class = 'col-sm-6 col-md-4 padding-5';
					break;
				case 4:
					$carousel_wrap_class = 'col-xxs-12 col-xs-6 col-sm-6 col-md-3 padding-5';
					break;
			}

			$tabs_content_html .= '<div class="row margin-negative-5">';

			for ( $k = 1; $k <= $number_of_carousels; $k++ ) {
				$tabs_content_html .= '<div class="' . $carousel_wrap_class . '">';
				$cat_slug_param = 'cat_slug_' . $k;
				$cat_slug = $$cat_slug_param;
				$tabs_content_html .= do_shortcode(
					'[lk_products_carousel_by_cat 
					cat_slug="' . esc_attr( $cat_slug ) . '" 
					items_per_slide="' . esc_attr( $items_per_slide ) . '" 
					products_per_item="' . esc_attr( $products_per_item ) . '" 
					max_products_num="' . esc_attr( $max_products_num ) . '" 
					show_cat_link="' . esc_attr( $show_cat_link ) . '" 
					cat_link_text="' . esc_attr( $cat_link_text ) . '" 
					show_cat_img="' . esc_attr( $show_cat_img ) . '" 
					cat_img_size="' . esc_attr( $cat_img_size ) . '"
					css_animation=""
					]'
				);
				$tabs_content_html .= '</div><!-- /.' . $carousel_wrap_class . ' -->';
			}
			$tabs_content_html .= '</div><!-- /.row margin-negative-5 -->';
		}

		$tabs_content_html .= '</div>';

	}
	$tabs_nav_html = '<ul class="nav-tab">' . $tabs_nav_html . '</ul>';

	if ( trim( $tabs_id ) != '' ) {
		$tabs_content_html = '<div id="' . esc_attr( $tabs_id ) . '" class="tab-container">' . $tabs_content_html . '</div>';
	}
	else {
		$tabs_content_html = '<div class="tab-container">' . $tabs_content_html . '</div>';
	}

	// Elevator
	$elevator_html_1 = '';
	$elevator_html_2 = '';
	$elevator_1_target = str_replace( '#', '', $elevator_1_target );
	$elevator_2_target = str_replace( '#', '', $elevator_2_target );
	if ( $elevator_1_type == 'custom_id' && trim( $elevator_1_target ) != '' ) {
		$elevator_html_1 = '<a href="#' . esc_attr( $elevator_1_target ) . '" class="btn-elevator btn-elevator-prev up fa fa-angle-up"></a>';
	}
	if ( $elevator_1_type == 'auto' ) {
		$elevator_html_1 = '<a href="#" class="btn-elevator btn-elevator-prev btn-elevator-auto up fa fa-angle-up"></a>';
	}
	if ( $elevator_2_type == 'custom_id' && trim( $elevator_2_target ) != '' ) {
		$elevator_html_2 = '<a href="#' . esc_attr( $elevator_2_target ) . '" class="btn-elevator btn-elevator-next down fa fa-angle-down"></a>';
	}
	if ( $elevator_2_type == 'auto' ) {
		$elevator_html_2 = '<a href="#" class="btn-elevator btn-elevator-next btn-elevator-auto down fa fa-angle-down"></a>';
	}

	if ( trim( $elevator_html_1 . $elevator_html_2 ) != '' ) {
		if ( trim( $floor_id ) != '' ) {
			$elevator_html = '<div id="' . esc_attr( $floor_id ) . '" class="floor-elevator has-elevator">' . $elevator_html_1 . $elevator_html_2 . '</div>';
		}
		else {
			$elevator_html = '<div class="floor-elevator elevator-banned">' . $elevator_html_1 . $elevator_html_2 . '</div>';
		}
	}

	if ( trim( $title ) != '' ) {
		$title_html .= '<h3 class="simple-title" style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $title ) . '</h3>';
	}

	$tab_head_html .= '<div class="tab-head">';
	$tab_head_html .= $title_html . $elevator_html . $tabs_nav_html;
	$tab_head_html .= '</div><!-- /.tab-head -->';

	$tabs_html .= '<div class="kt-tabs kt-tabs-effect">';
	$tabs_html .= $tab_head_html . $tabs_content_html;
	$tabs_html .= '</div><!-- /.kt-tabs -->';

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">';
	$html .= $tabs_html;
	$html .= '</div>';

	return $html;

}

add_shortcode( 'lk_products_carousel_by_cats_tabs', 'lk_products_carousel_by_cats_tabs' );
