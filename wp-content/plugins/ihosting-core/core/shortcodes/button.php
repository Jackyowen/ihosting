<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'ihButton' );
function ihButton() {
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
			'name'     => esc_html__( 'IH Button', 'ihosting-core' ),
			'base'     => 'ih_button', // shortcode
			'class'    => '',
			'category' => esc_html__( 'iHosting', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Button Text', 'ihosting-core' ),
					'param_name' => 'btn_text',
					'std'        => esc_html__( 'Get Start now!', 'ihosting-core' ),
				),
				array(
					'type'       => 'vc_link',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Button Link', 'ihosting-core' ),
					'param_name' => 'link'
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
					'param_name' => 'btn_text_color',
					'std'        => '#0d58a1',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Button Background Color', 'ihosting-core' ),
					'param_name' => 'btn_bg_color',
					'std'        => '#fcb100',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Hover Effect', 'ihosting-core' ),
					'param_name' => 'hover_effect',
					'value'      => array(
						esc_html__( ' --- No Effect ---', 'ihosting-core' )                  => '',
						esc_html__( 'Diagonally', 'ihosting-core' )                          => 'hover-effect-diagonally',
						esc_html__( 'Crossing', 'ihosting-core' )                            => 'hover-effect-crossing',
						esc_html__( 'Plus', 'ihosting-core' )                                => 'hover-plus-effect',
						esc_html__( 'Dark Change To Light From RTL', 'ihosting-core' )       => 'hover-overlay-dark-to-light-rtl',
						esc_html__( 'Hover Zoom Scale Bigger Opacity 0.5', 'ihosting-core' ) => 'hover-zoom-scale-opacity-05',
					),
					'std'        => 'hover-effect-diagonally',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Additional Class', 'ihosting-core' ),
					'param_name' => 'btn_class',
					'std'        => ''
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

function ih_button( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ih_button', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'btn_text'        => '',
				'link'            => '',
				'btn_text_color'  => '#0d58a1',
				'btn_bg_color'    => '#fcb100',
				'hover_effect'    => 'hover-effect-diagonally',
				'btn_class'       => '',
				'css_animation'   => '',
				'animation_delay' => '0.4',   //In second
				'css'             => '',
			), $atts
		)
	);

	$css_class = 'ih-btn-wrap text-center';
	if ( $css_animation != '' ) {
		$css_class .= ' wow ' . $css_animation;
	}
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	$link_default = array(
		'url'    => '',
		'title'  => '',
		'target' => '',
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

	$html = '';
	$btn_html = '';

	// Title html
	if ( trim( $btn_text ) != '' ) {
		$btn_class = 'ih-btn button btn ' . $hover_effect . ' ' . $btn_class;
		if ( trim( $link['url'] ) != '' ) {
			$btn_class .= ' is-btn-with-link';
			$btn_html .= '<a href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . sanitize_text_field( $link['title'] ) . '" class="' . esc_attr( $btn_class ) . '" style="background-color: ' . esc_attr( $btn_bg_color ) . '; color: ' . esc_attr( $btn_text_color ) . ';">' . esc_html( $btn_text ) . '</a>';
		}
		else {
			$btn_html .= '<input type="button" class="' . esc_attr( $btn_class ) . '" style="background-color: ' . esc_attr( $btn_bg_color ) . '; color: ' . esc_attr( $btn_text_color ) . ';" value="' . esc_attr( $btn_text ) . '" />';
		}
	}

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				' . $btn_html . '
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return balanceTags( $html );

}

add_shortcode( 'ih_button', 'ih_button' );
