<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'ihClientSay' );
function ihClientSay() {
	global $kt_vc_anim_effects_in;

	$allowed_tags = array(
		'em'     => array(),
		'i'      => array(),
		'b'      => array(),
		'strong' => array(),
		'br'     => array(),
		'code'   => array(),
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
			'name'     => esc_html__( 'IH Client Say', 'ihosting-core' ),
			'base'     => 'ih_client_say', // shortcode
			'class'    => '',
			'category' => esc_html__( 'iHosting', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'textfield',
					'holder'     => 'h5',
					'class'      => '',
					'heading'    => esc_html__( 'Title', 'ihosting-core' ),
					'param_name' => 'title',
					'std'        => esc_html__( 'Reliable and affordable hosting.', 'ihosting-core' ),
				),
				array(
					'type'       => 'textarea',
					'holder'     => 'em',
					'class'      => '',
					'heading'    => esc_html__( 'Soft Description', 'ihosting-core' ),
					'param_name' => 'short_desc',
					'std'        => esc_html__( 'They helped me fix errors and I am very grateful, especially to John Doe from support who has always been there for me.', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Stars Rating', 'ihosting-core' ),
					'param_name' => 'num_of_stars',
					'value'      => array(
						esc_html__( 'Don\'t show', 'ihosting-core' ) => '0',
						esc_html__( '1 star', 'ihosting-core' )      => '1',
						esc_html__( '1.5 stars', 'ihosting-core' )   => '1.5',
						esc_html__( '2 stars', 'ihosting-core' )     => '2',
						esc_html__( '2.5 stars', 'ihosting-core' )   => '2.5',
						esc_html__( '3 stars', 'ihosting-core' )     => '3',
						esc_html__( '3.5 stars', 'ihosting-core' )   => '3.5',
						esc_html__( '4 stars', 'ihosting-core' )     => '4',
						esc_html__( '4.5 stars', 'ihosting-core' )   => '4.5',
						esc_html__( '5 stars', 'ihosting-core' )     => '5',
					),
					'std'        => '5'
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'h5',
					'class'      => '',
					'heading'    => esc_html__( 'Client\'s Name', 'ihosting-core' ),
					'param_name' => 'client_name',
					'std'        => esc_html__( 'Claudio', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Client\'s Short Information', 'ihosting-core' ),
					'param_name'  => 'client_short_info',
					'std'         => esc_html__( 'Founder at Google', 'ihosting-core' ),
					'description' => esc_html__( 'Short information about client. Ex: Founder at Google.', 'ihosting-core' ),
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
						esc_html__( 'label', 'ihosting-core' ) => 'label'
					),
					'std'        => 'h5'
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
					'std'        => 'left',
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

function ih_client_say( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ih_client_say', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'title'             => '',
				'short_desc'        => '',
				'num_of_stars'      => '0',
				'client_name'       => '',
				'client_short_info' => '',
				'title_tag'         => 'h5',
				'text_align'        => 'left',
				'css_animation'     => '',
				'animation_delay'   => '0.4',   //In second
				'css'               => '',
			), $atts
		)
	);

	$css_class = 'ih-client-say-wrap text-' . $text_align;
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

	$allowed_title_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'label', 'span' );
	if ( !in_array( $title_tag, $allowed_title_tags ) ) {
		$title_tag = 'h5';
	}

	$html = '';

	$title_html = '';
	$stars_html = '';
	$short_desc_html = '';
	$client_name_html = '';
	$client_short_info_html = '';
	$client_info_wrap_html = '';

	$title_class = 'ih-client-say-title title-client';

	if ( trim( $title ) != '' ) {
		$title_html .= '<' . $title_tag . ' class="' . esc_attr( $title_class ) . '" >' . $title . '</' . $title_tag . '>';
	}

	// Stars highlight width. Value from 0% - 100%. 5 stars rating means 100% width
	$stars_width = 0;
	$num_of_stars = min( 5, max( 0, floatval( $num_of_stars ) ) );
	
	if ( $num_of_stars > 0 ) {
		$stars_width = ( $num_of_stars / 5 ) * 100;
		$stars_html .= '<div class="rate-client ih-stars-rating"><span style="width:' . esc_attr( $stars_width ) . '%;"></span></div>';
	}

	if ( trim( $short_desc ) != '' ) {
		$short_desc_html .= '<p class="short-desc desc-client">' . $short_desc . '<span>,,</span></p>';
	}

	if ( trim( $client_name . $client_short_info ) != '' ) {
		if ( trim( $client_name ) != '' ) {
			$client_name_html .= '<p>' . sanitize_text_field( $client_name ) . '</p>';
		}
		if ( trim( $client_short_info ) != '' ) {
			$client_short_info_html .= '<span class="client-short-info">' . esc_html( $client_short_info ) . '</span>';
		}
		$client_info_wrap_html = '<div class="under-box-client ih-client-info-wrap">' . $client_name_html . $client_short_info_html . '</div>';
	}

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				<div class="ih-client-say-inner">
					<div class="client-box client-say-box">
						' . $title_html . '
						' . $stars_html . '
						' . $short_desc_html . '
					</div>
					' . $client_info_wrap_html . '
				</div><!-- /.ih-client-say-inner -->
			</div>';

	return $html;

}

add_shortcode( 'ih_client_say', 'ih_client_say' );
