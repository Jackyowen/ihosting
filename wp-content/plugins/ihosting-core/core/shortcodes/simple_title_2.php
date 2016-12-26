<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'lkSimpleTitle2' );
function lkSimpleTitle2() {
	global $kt_vc_anim_effects_in;
	vc_map(
		array(
			'name'     => esc_html__( 'LK Simple Title 2', 'ihosting-core' ),
			'base'     => 'lk_simple_title_2', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title', 'ihosting-core' ),
					'param_name' => 'title',
					'std'        => esc_html__( 'Kute Theme', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description', 'ihosting-core' ),
					'param_name' => 'short_desc',
					'std'        => esc_html__( 'Welcome to Lucky - Beautiful Creative E-commerce Template!', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Title Tag', 'ihosting-core' ),
					'param_name' => 'title_tag',
					'value'      => array(
						esc_html__( 'h1', 'ihosting-core' )    => 'h1',
						esc_html__( 'h2', 'ihosting-core' )    => 'h2',
						esc_html__( 'h3', 'ihosting-core' )    => 'h3',
						esc_html__( 'h4', 'ihosting-core' )    => 'h4',
						esc_html__( 'h5', 'ihosting-core' )    => 'h5',
						esc_html__( 'h6', 'ihosting-core' )    => 'h6',
						esc_html__( 'span', 'ihosting-core' )  => 'span',
						esc_html__( 'label', 'ihosting-core' ) => 'label',
						esc_html__( 'p', 'ihosting-core' )     => 'p',
					),
					'std'        => 'h3'
				),
				array(
					'type'       => 'vc_link',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Link', 'ihosting-core' ),
					'param_name' => 'link',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
					'param_name' => 'title_color',
					'std'        => '#222',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description Color', 'ihosting-core' ),
					'param_name' => 'short_desc_color',
					'std'        => '#888',
				),
				array(
					'type'       => 'dropdown',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Text Align', 'ihosting-core' ),
					'param_name' => 'text_align',
					'value'      => array(
						esc_html__( 'Left', 'ihosting-core' )    => 'left',
						esc_html__( 'Right', 'ihosting-core' )   => 'right',
						esc_html__( 'Center', 'ihosting-core' )  => 'center',
						esc_html__( 'Inherit', 'ihosting-core' ) => 'inherit'
					),
					'std'        => 'center',
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

function lk_simple_title_2( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_simple_title_2', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'title'            => '',
				'short_desc'       => '',
				'title_tag'        => 'h3',
				'link'             => '',
				'title_color'      => '#444',
				'short_desc_color' => '#444',
				'text_align'       => 'center',
				'css_animation'    => '',
				'animation_delay'  => '0.4',   //In second
				'css'              => '',
			), $atts
		)
	);

	$css_class = 'section-simple-title-2-wrap wow ' . $css_animation . ' text-' . $text_align;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	$link_default = array(
		'url'    => '',
		'title'  => '',
		'target' => ''
	);

	if ( function_exists( 'vc_build_link' ) ):
		$link = vc_build_link( $link );
	else:
		$link = $link_default;
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}
	$animation_delay = $animation_delay . 's';

	$allowed_title_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'label', 'span', 'p' );
	if ( !in_array( $title_tag, $allowed_title_tags ) ) {
		$title_tag = 'h3';
	}

	$html = '';

	$title_html = '';
	$short_desc_html = '';
	$title_style = trim( $title_color ) != '' ? 'style="color: ' . esc_attr( $title_color ) . ';"' : '';
	$title_class = 'simple-title-2';

	if ( trim( $short_desc ) != '' ) {
		$short_desc_html .= '<span class="short-desc" style="color: ' . esc_attr( $short_desc_color ) . ';">' . sanitize_text_field( $short_desc ) . '</span>';
	}

	if ( trim( $link['url'] ) != '' ) {
		$title_class .= ' has-link';
		$title_html .= '<' . $title_tag . ' ' . $title_style . ' class="' . esc_attr( $title_class ) . '" ><a href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '">' . sanitize_text_field( $title ) . '</a></' . $title_tag . '>';
	}
	else {
		$title_class .= ' no-link';
		$title_html .= '<' . $title_tag . ' ' . $title_style . ' class="' . esc_attr( $title_class ) . '" >' . sanitize_text_field( $title ) . '</' . $title_tag . '>';
	}

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				' . $title_html . '
				' . $short_desc_html . '
			</div>';

	return $html;

}

add_shortcode( 'lk_simple_title_2', 'lk_simple_title_2' );
