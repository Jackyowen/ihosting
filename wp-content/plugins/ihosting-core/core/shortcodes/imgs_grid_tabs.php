<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

function lk_get_imgs_tab_fields() {
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
				'type'        => 'attach_images',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Images', 'ihosting-core' ),
				'param_name'  => 'img_ids_' . $i,
				'description' => esc_html__( 'Choose images for the grid', 'ihosting-core' ),
				'dependency'  => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'       => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'       => 'colorpicker',
				'class'      => '',
				'heading'    => esc_html__( 'Overlay Color', 'ihosting-core' ),
				'param_name' => 'overlay_color_' . $i,
				'std'        => '',
				'dependency' => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'      => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'       => 'dropdown',
				'class'      => '',
				'heading'    => esc_html__( 'Enable Hover Effect (Hoverdir)', 'ihosting-core' ),
				'param_name' => 'enable_hover_effect_' . $i,
				'value'      => array(
					esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
					esc_html__( 'No', 'ihosting-core' )  => 'no',
				),
				'std'        => 'yes',
				'dependency' => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'      => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'       => 'colorpicker',
				'class'      => '',
				'heading'    => esc_html__( 'Hover Effect Color', 'ihosting-core' ),
				'param_name' => 'hover_effect_color_' . $i,
				'std'        => 'rgba(238, 193, 1, 0.3)',
				'dependency' => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'      => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'        => 'exploded_textarea_safe',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Images Links', 'ihosting-core' ),
				'param_name'  => 'image_links_' . $i,
				'description' => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter))', 'ihosting-core' ),
				'dependency'  => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'       => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'       => 'dropdown',
				'class'      => '',
				'heading'    => esc_html__( 'Link Target', 'ihosting-core' ),
				'param_name' => 'link_target_' . $i,
				'value'      => array(
					esc_html__( 'Same window', 'ihosting-core' ) => '_self',
					esc_html__( 'New tab', 'ihosting-core' )     => '_blank',
				),
				'std'        => '_self',
				'dependency' => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'      => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Items Per Row', 'ihosting-core' ),
				'value'       => 4,
				'save_always' => true,
				'param_name'  => 'items_per_row_' . $i,
				'description' => esc_html__( 'How many categories per row on the large screen? Min = 1, max = 4.', 'ihosting-core' ),
				'dependency'  => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'       => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Items Height', 'ihosting-core' ),
				'value'       => 170,
				'save_always' => true,
				'param_name'  => 'items_height_' . $i,
				'dependency'  => array(
					'element' => 'num_of_tabs',
					'value'   => $dep_array,
				),
				'group'       => sprintf( esc_html__( 'Tab %d', 'ihosting-core' ), $i ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Images Size', 'ihosting-core' ),
				'value'       => '300x185',
				'save_always' => true,
				'param_name'  => 'img_size_' . $i,
				'description' => wp_kses( __( '<em>{width}x{height}</em>. Example: <em>300x185</em>, etc...', 'ihosting-core' ), $allowed_tags ),
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

add_action( 'vc_before_init', 'lkImgsGridTabs' );
function lkImgsGridTabs() {
	if ( !class_exists( 'WooCommerce' ) ) {
		return;
	}

	global $kt_vc_anim_effects_in;

	$tab_fields = lk_get_imgs_tab_fields();

	$vc_map = array(
		'name'     => esc_html__( 'LK Images Grid Tabs', 'ihosting-core' ),
		'base'     => 'lk_imgs_grid_tabs', // shortcode
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
				'heading'     => esc_html__( 'Title', 'ihosting-core' ),
				'std'         => esc_html__( 'Hot Categories', 'ihosting-core' ),
				'save_always' => true,
				'param_name'  => 'title',
			),
			array(
				'type'       => 'colorpicker',
				'class'      => '',
				'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
				'param_name' => 'title_color',
				'std'        => '#444',
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Set Grid Tabs ID', 'ihosting-core' ),
				'param_name'  => 'grid_tabs_id',
				'std'         => uniqid( 'imgs-grid-tabs_' ),
				'description' => esc_html__( 'Enter images grid tab ID (Note: make sure it is unique and valid according to w3c specification).', 'ihosting-core' ),
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
		'heading'     => esc_html__( 'Set Floor ID', 'ihosting-core' ),
		'param_name'  => 'floor_id',
		'std'         => uniqid( 'floor_' ),
		'description' => esc_html__( 'Enter floor ID (Note: make sure it is unique and valid according to w3c specification).', 'ihosting-core' ),
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

function lk_imgs_grid_tabs( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_imgs_grid_tabs', $atts ) : $atts;

	$default_atts = array(
		'num_of_tabs'       => '3_tab',
		'title'             => '',
		'title_color'       => '#444',
		'grid_tabs_id'      => '',
		'css_animation'     => '',
		'animation_delay'   => '0.4',   //In second
		'floor_id'          => '',
		'elevator_1_type'   => 'auto',
		'elevator_1_target' => '',
		'elevator_2_type'   => 'auto',
		'elevator_2_target' => '',
		'css'               => '',
	);

	$tab_fields = lk_get_imgs_tab_fields();
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

	$css_class = 'lk-imgs-grid-tabs-wrap lk-tabs-floor-style wow ' . $css_animation;
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
		$img_ids_param = 'img_ids_' . $i;
		$overlay_color_param = 'overlay_color_' . $i;
		$enable_hover_effect_param = 'enable_hover_effect_' . $i;
		$hover_effect_color_param = 'hover_effect_color_' . $i;
		$image_links_param = 'image_links_' . $i;
		$link_target_param = 'link_target_' . $i;
		$items_per_row_param = 'items_per_row_' . $i;
		$items_height_param = 'items_height_' . $i;
		$img_size_param = 'img_size_' . $i;
		$cats_animation_param = 'cats_animation_' . $i;

		$tab_title = $$tab_title_param;
		$img_ids = $$img_ids_param;
		$overlay_color = $$overlay_color_param;
		$enable_hover_effect = $$enable_hover_effect_param;
		$hover_effect_color = $$hover_effect_color_param;
		$image_links = $$image_links_param;
		$link_target = $$link_target_param;
		$items_per_row = $$items_per_row_param;
		$items_height = $$items_height_param;
		$img_size = $$img_size_param;
		$cats_animation = $$cats_animation_param;

		// Get tabs nav html
		$tabs_nav_html .= '<li class="' . $tab_nav_li_class . '"><a data-animated="' . esc_attr( $cats_animation ) . '" data-toggle="tab" href="#' . esc_attr( $tab_id ) . '">' . sanitize_text_field( $tab_title ) . '</a></li>';

		// Get tabs content html
		$tabs_content_html .= '<div id="' . esc_attr( $tab_id ) . '" class="' . $tab_content_class . '">';
		$tabs_content_html .= do_shortcode(
			'[lk_imgs_grid 
				img_ids="' . esc_attr( $img_ids ) . '" 
				items_per_row="' . esc_attr( $items_per_row ) . '" 
				items_height="' . esc_attr( $items_height ) . '" 
				img_size="' . esc_attr( $img_size ) . '" 
				overlay_color="' . esc_attr( $overlay_color ) . '" 
				enable_hover_effect="' . esc_attr( $enable_hover_effect ) . '" 
				hover_effect_color="' . esc_attr( $hover_effect_color ) . '" 
				image_links="' . esc_attr( $image_links ) . '" 
				link_target="' . esc_attr( $link_target ) . '" 
				css_animation=""
				]'
		);
		$tabs_content_html .= '</div>';

	}
	$tabs_nav_html = '<ul class="nav-tab">' . $tabs_nav_html . '</ul>';

	if ( trim( $grid_tabs_id ) != '' ) {
		$tabs_content_html = '<div id="' . esc_attr( $grid_tabs_id ) . '" class="tab-container">' . $tabs_content_html . '</div>';
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

add_shortcode( 'lk_imgs_grid_tabs', 'lk_imgs_grid_tabs' );
