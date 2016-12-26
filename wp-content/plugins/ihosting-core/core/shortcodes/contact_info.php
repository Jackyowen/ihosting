<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'ihContactInfo' );
function ihContactInfo() {
	$allowed_tags = array(
		'em'     => array(),
		'i'      => array(),
		'b'      => array(),
		'strong' => array(),
		'code'   => array(),
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
			'name'     => esc_html__( 'IH Contact Info', 'ihosting-core' ),
			'base'     => 'ih_contact_info', // shortcode
			'class'    => '',
			'category' => esc_html__( 'iHosting', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'textarea',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Contact Info', 'ihosting-core' ),
					'param_name'  => 'contact_infos',
					'description' => wp_kses( __( 'Enter information, divide each line with linebreaks (Enter). Format: <code>{icon_class}|{Label}|{Information Text}</code>. Ex: <code>fa fa-phone|Phone:|+1 234 456 7890</code>', 'ihosting-core' ), $allowed_tags )
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Label Color', 'ihosting-core' ),
					'param_name' => 'label_color',
					'std'        => '#000',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Icon Color', 'ihosting-core' ),
					'param_name' => 'icon_color',
					'std'        => '#000',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Text Color', 'ihosting-core' ),
					'param_name' => 'text_color',
					'std'        => '#666',
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

function ih_contact_info( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ih_contact_info', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'contact_infos'   => '',
				'label_color'     => '#000000',
				'icon_color'      => '#000000',
				'text_color'      => '#666666',
				'css_animation'   => '',
				'animation_delay' => '0.4',   //In second
				'css'             => '',
			), $atts
		)
	);

	$css_class = 'ih-contact-info-wrap';
	if ( $css_animation != '' ) {
		$css_class .= ' wow ' . $css_animation;
	}
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}

	$animation_delay = $animation_delay . 's';

	$contact_infos = explode( "\n", $contact_infos );
	$contact_infos = array_filter( $contact_infos, 'trim' );  // remove any extra \r characters left behind

	$html = '';

	if ( !empty( $contact_infos ) ) {
		foreach ( $contact_infos as $contact_info ) {
			$icon_html = '';
			$label_html = '';
			$info_text_html = '';
			$info_line_html = '';
			$contact_info_args = explode( '|', $contact_info );
			//$contact_info_args = array_filter( $contact_info_args );

			$icon_html = isset( $contact_info_args[0] ) ? trim( $contact_info_args[0] ) != '' ? '<i style="color: ' . esc_attr( $icon_color ) . ';" class="' . esc_attr( $contact_info_args[0] ) . '"></i>' : '' : '';
			$label_html = isset( $contact_info_args[1] ) ? trim( $contact_info_args[1] ) != '' ? '<label style="color: ' . esc_attr( $label_color ) . ';">' . sanitize_text_field( $contact_info_args[1] ) . '</label>' : '' : '';
			$info_text_html = isset( $contact_info_args[2] ) ? trim( $contact_info_args[2] ) != '' ? '<span  style="color: ' . esc_attr( $text_color ) . ';">' . sanitize_text_field( $contact_info_args[2] ) . '</span>' : '' : '';
			$info_line_html .= '<p class="info-line">' . $icon_html . $label_html . $info_text_html . '</p>';

			$html .= $info_line_html;
		}
	}

	$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				<div class="ih-contact-info">
					' . $html . '
				</div><!-- /.ih-contact-info -->
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'ih_contact_info', 'ih_contact_info' );
