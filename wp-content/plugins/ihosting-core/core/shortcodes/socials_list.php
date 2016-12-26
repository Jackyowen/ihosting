<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'lkSocialsList' );
function lkSocialsList() {
	global $kt_vc_anim_effects_in;

	vc_map(
		array(
			'name'     => esc_html__( 'LK Socials List', 'ihosting-core' ),
			'base'     => 'lk_socials_list', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'exploded_textarea',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Input The Socials List', 'ihosting-core' ),
					'param_name'  => 'socials_list',
					'std'         => 'fa fa-facebook|https://facebook.com|_blank|My Facebook,fa fa-twitter|https://twitter.com|_blank|My Twitter',
					//'description' => esc_html__( 'Each is a social link adhere to the following format: {icon_class}|{link}|{link_target}|{link_title}|{color}|{bg_color}. Ex: fa fa-facebook|https://facebook.com|_blank|My Facebook|#fff|#2e88e2. Background color Facebook: #2e88e2, Twitter: #00caff, Google Plus: #de5347, Instagram: #125688, Pinterest: #cb222a. Note: Comma is not allowed.', 'ihosting-core' ),
					'description' => esc_html__( 'Each is a social link adhere to the following format: {icon_class}|{link}|{link_target}|{link_title}. Ex: fa fa-facebook|https://facebook.com|_blank|My Facebook. Note: Comma is not allowed.', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Icon Color', 'ihosting-core' ),
					'param_name' => 'icon_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Icon Hover Color', 'ihosting-core' ),
					'param_name' => 'icon_hover_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Icon Background Color', 'ihosting-core' ),
					'param_name' => 'icon_bg_color',
					'std'        => 'rgba(0,0,0,0.1)',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Icon Hover Background Color', 'ihosting-core' ),
					'param_name' => 'icon_hover_bg_color',
					'std'        => '#eec15b',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Align', 'ihosting-core' ),
					'param_name' => 'align',
					'value'      => array(
						esc_html__( 'Inherit', 'ihosting-core' ) => 'inherit',
						esc_html__( 'Left', 'ihosting-core' )    => 'left',
						esc_html__( 'Right', 'ihosting-core' )   => 'right',
						esc_html__( 'Center', 'ihosting-core' )  => 'center',
					),
					'std'        => 'inherit'
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
				)
			)
		)
	);
}

function lk_socials_list( $atts ) {
	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_socials_list', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'socials_list'        => '',
				'icon_color'          => '#fff',
				'icon_hover_color'    => '#fff',
				'icon_bg_color'       => 'rgba(0,0,0,0.1)',
				'icon_hover_bg_color' => '#eec15b',
				'align'               => 'inherit',
				'css_animation'       => '',
				'animation_delay'     => '0.4',  // In second
				'css'                 => '',
			), $atts
		)
	);

	$css_class = 'lk-socials-list-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = '0';
	}
	$animation_delay = $animation_delay . 's';

	$html = '';

	if ( trim( $socials_list ) != '' ) {
		$socials_list = explode( ',', $socials_list );
	}

	$icon_attrs = '';
	$icon_style = '';

	if ( trim( $icon_color ) != '' ) {
		$icon_style .= 'color: ' . esc_attr( $icon_color ) . ';';
	}
	if ( trim( $icon_bg_color ) != '' ) {
		$icon_style .= 'background-color: ' . esc_attr( $icon_bg_color ) . ';';
	}

	if ( trim( $icon_style ) != '' ) {
		$icon_style = 'style="' . $icon_style . '"';
	}

	$icon_attrs .= 'data-color="' . esc_attr( $icon_color ) . '" data-hover-color="' . esc_attr( $icon_hover_color ) . '" data-bg-color="' . esc_attr( $icon_bg_color ) . '" data-hover-bg-color="' . esc_attr( $icon_hover_bg_color ) . '"';

	foreach ( $socials_list as $social ) {
		$social = explode( '|', $social );
		$social_class = isset( $social[0] ) ? esc_attr( $social[0] ) : '';
		$social_url = isset( $social[1] ) ? $social[1] : '';
		$target = isset( $social[2] ) ? esc_attr( $social[2] ) : '__self';
		$social_title = isset( $social[3] ) ? sanitize_text_field( $social[3] ) : '';

		// Check is valid url
		if ( filter_var( $social_url, FILTER_VALIDATE_URL ) ) {
			$html .= '<li class="social-li"><a ' . $icon_attrs . ' ' . $icon_style . ' href="' . esc_url( $social_url ) . '" target="' . $target . '" title="' . $social_title . '"><i class="' . $social_class . '"></i><span class="screen-reader-text">' . $social_title . '</span></a></li>';
		}

	}

	if ( trim( $html ) != '' ) {
		$html = '<div class="' . $css_class . '">
					<ul class="socials-list text-' . esc_attr( $align ) . '">' . $html . '</ul>
				</div>';
	}

	return $html;

}

add_shortcode( 'lk_socials_list', 'lk_socials_list' );