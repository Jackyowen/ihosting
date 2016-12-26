<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkSimpleContactInfo' );
function lkSimpleContactInfo() {
	$allowed_tags = array(
		'em'     => array(),
		'i'      => array(
			'class' => array(),
		),
		'b'      => array(),
		'strong' => array(),
		'label'  => array(
			'class' => array()
		),
		'a'      => array(
			'href'   => array(),
			'target' => array(),
			'class'  => array(),
			'id'     => array(),
			'title'  => array(),
		),
	);

	global $kt_vc_anim_effects_in;

	$icon_params = lk_iconpicker_build_param();
	$vc_map = array(
		'name'     => esc_html__( 'LK Simple Contact Info', 'ihosting-core' ),
		'base'     => 'lk_simple_contact_info', // shortcode
		'class'    => '',
		'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
		'params'   => array(
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Title', 'ihosting-core' ),
				'param_name' => 'title',
				'std'        => esc_html__( 'Address', 'ihosting-core' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Information', 'ihosting-core' ),
				'param_name' => 'short_info',
				'std'        => esc_html__( 'Chicago, IL, 55030, 8500 Grand Street', 'ihosting-core' ),
			),
		),
	);

	foreach ( $icon_params as $icon_param ) {
		$vc_map['params'][] = $icon_param;
	}
	$vc_map['params'][] = array(
		'type'       => 'colorpicker',
		'holder'     => 'div',
		'class'      => '',
		'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
		'param_name' => 'title_color',
		'std'        => '#444444',
	);
	$vc_map['params'][] = array(
		'type'       => 'colorpicker',
		'holder'     => 'div',
		'class'      => '',
		'heading'    => esc_html__( 'Information Color', 'ihosting-core' ),
		'param_name' => 'info_color',
		'std'        => '#888888',
	);
	$vc_map['params'][] = array(
		'type'       => 'colorpicker',
		'holder'     => 'div',
		'class'      => '',
		'heading'    => esc_html__( 'Icon Color', 'ihosting-core' ),
		'param_name' => 'icon_color',
		'std'        => '#bfbfbf',
	);
	$vc_map['params'][] = array(
		'type'       => 'dropdown',
		'holder'     => 'div',
		'class'      => '',
		'heading'    => esc_html__( 'CSS Animation', 'ihosting-core' ),
		'param_name' => 'css_animation',
		'value'      => $kt_vc_anim_effects_in,
		'std'        => 'fadeInUp',
	);
	$vc_map['params'][] = array(
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
	);

	$vc_map['params'][] = array(
		'type'       => 'css_editor',
		'heading'    => esc_html__( 'Css', 'ihosting-core' ),
		'param_name' => 'css',
		'group'      => esc_html__( 'Design options', 'ihosting-core' ),
	);
	vc_map( $vc_map );
}

function lk_simple_contact_info( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_simple_contact_info', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'title'              => '',
				'short_info'         => '',
				'title_tag'          => 'label',
				'icon_type'          => 'lkflaticon',
				'icon_fontawesome'   => '',
				'icon_openiconic'    => '',
				'icon_typicons'      => '',
				'icon_entypo'        => '',
				'icon_linecons'      => '',
				'icon_monosocial'    => '',
				'icon_lkflaticon'    => '',
				'icon_peicon7stroke' => '',
				'title_color'        => '#444',
				'info_color'         => '#888',
				'icon_color'         => '#bfbfbf',
				'css_animation'      => '',
				'animation_delay'    => '0.4',   //In second
				'css'                => '',
			), $atts
		)
	);

	$css_class = 'simple-contact-info-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}

	$animation_delay = $animation_delay . 's';

	$icon_class_param = 'icon_' . esc_attr( $icon_type );
	$icon_class = $$icon_class_param;
	$p_class = 'contact-line';

	$title_tag = trim( $title_tag ) == '' ? 'label' : trim( $title_tag );

	$title_html = '';
	$icon_html = '';
	$info_html = '';

	if ( trim( $title ) != '' ) {
		$title_html .= '<' . esc_attr( $title_tag ) . ' class="contact-line-title" style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $title ) . '</' . esc_attr( $title_tag ) . '>';
	}

	if ( trim( $icon_class ) != '' ) {
		$icon_html .= '<span class="icon ' . esc_attr( $icon_class ) . '" style="color: ' . esc_attr( $icon_color ) . ' ;"></span>';
		$p_class .= ' has-icon';
	}

	if ( trim( $short_info ) != '' ) {
		$info_html .= $icon_html . '<span class="contact-line-info" style="color: ' . esc_attr( $info_color ) . ';">' . balanceTags( $short_info ) . '</span>';
	}

	$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				<p class="' . $p_class . '">
					' . $title_html . '
					' . $info_html . '
				</p>
			</div>';


	return balanceTags( $html );

}

add_shortcode( 'lk_simple_contact_info', 'lk_simple_contact_info' );
