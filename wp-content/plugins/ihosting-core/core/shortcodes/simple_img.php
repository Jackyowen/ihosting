<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkSimpleImage' );
function lkSimpleImage() {
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
			'name'     => esc_html__( 'LK Simple Image', 'ihosting-core' ),
			'base'     => 'lk_simple_img', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'attach_image',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Image', 'ihosting-core' ),
					'param_name'  => 'img_id',
					'description' => esc_html__( 'Choose banner image', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Image Size', 'ihosting-core' ),
					'param_name'  => 'img_size',
					'std'         => '1170x100',
					'description' => wp_kses( esc_html__( '<em>{width}x{height}</em>. Example: <em>390x214, 1170x100</em>, etc...', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'       => 'vc_link',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Link', 'ihosting-core' ),
					'param_name' => 'link',
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
					'std'        => 'hover-zoom-scale-opacity-05',
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

function lk_simple_img( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_simple_img', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'img_id'          => 0,
				'img_size'        => '1170x100',
				'link'            => '',
				'hover_effect'    => '',
				'css_animation'   => '',
				'animation_delay' => '0.4',   //In second
				'css'             => '',
			), $atts
		)
	);

	$css_class = 'simple-img-wrap wow ' . $css_animation;
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
	$banner_html = '';

	// Banner image size (background)
	$img_size_x = 1170;
	$img_size_y = 100;
	if ( trim( $img_size ) != '' ) {
		$img_size = explode( 'x', $img_size );
	}
	$img_size_x = isset( $img_size[0] ) ? max( 0, intval( $img_size[0] ) ) : $img_size_x;
	$img_size_y = isset( $img_size[1] ) ? max( 0, intval( $img_size[1] ) ) : $img_size_y;

	// Banner image (background)
	$img = array(
		'url'    => ihosting_core_no_image( array( 'width' => $img_size_x, 'height' => $img_size_y ), false, true ),
		'width'  => $img_size_x,
		'height' => $img_size_y,
	);

	if ( intval( $img_id ) > 0 ) {
		$img = ihosting_core_resize_image( $img_id, null, $img_size_x, $img_size_y, true, true, false );
	}

	if ( trim( $link['url'] ) != '' ) {
		$banner_html .= '<a class="simple-banner ' . esc_attr( $hover_effect ) . '" href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '">
							<span class="screen-reader-text">' . sanitize_text_field( $link['title'] ) . '</span>
							<img width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( $link['title'] ) . '" />
						</a>';
	}
	else {
		$banner_html .= '<a class="simple-banner click-return-false ' . esc_attr( $hover_effect ) . '" href="#">
							<img width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( $link['title'] ) . '" />
						</a>';
	}

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
					' . $banner_html . '
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'lk_simple_img', 'lk_simple_img' );
