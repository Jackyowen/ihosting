<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'ihBannerText' );
function ihBannerText() {
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
			'name'     => esc_html__( 'IH Banner Text', 'ihosting-core' ),
			'base'     => 'ih_banner_text', // shortcode
			'class'    => '',
			'category' => esc_html__( 'iHosting', 'ihosting-core' ),
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
					'std'         => '1050x116',
					'description' => wp_kses( __( '<em>{width}x{height}</em>. Example: <em>1050x116, 390x214</em>, etc...', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title', 'ihosting-core' ),
					'param_name' => 'title',
					'std'        => esc_html__( 'Banner title', 'ihosting-core' ),
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
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Sub Title', 'ihosting-core' ),
					'param_name' => 'sub_title',
					'std'        => esc_html__( 'Banner sub title', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Sub Title Color', 'ihosting-core' ),
					'param_name' => 'sub_title_color',
					'std'        => '#888',
				),
				array(
					'type'       => 'vc_link',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Banner Link', 'ihosting-core' ),
					'param_name' => 'link'
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show Button Link', 'ihosting-core' ),
					'param_name' => 'show_btn_link',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no',
					),
					'std'        => 'yes',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Link Text', 'ihosting-core' ),
					'param_name' => 'btn_link_text',
					'std'        => esc_html__( 'Get Start', 'ihosting-core' ),
					'dependency' => array(
						'element' => 'show_btn_link',
						'value'   => array( 'yes' ),
					),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Button Text Color', 'ihosting-core' ),
					'param_name' => 'btn_text_color',
					'std'        => '#0d58a1',
					'dependency' => array(
						'element' => 'show_btn_link',
						'value'   => array( 'yes' ),
					),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Button Background Color', 'ihosting-core' ),
					'param_name' => 'btn_bg_color',
					'std'        => '#fcb100',
					'dependency' => array(
						'element' => 'show_btn_link',
						'value'   => array( 'yes' ),
					),
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

function ih_banner_text( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ih_banner_text', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'img_id'          => 0,
				'img_size'        => '390x214',
				'title'           => '',
				'title_color'     => '#444',
				'sub_title'       => '',
				'sub_title_color' => '#666',
				'link'            => '',
				'show_btn_link'   => 'yes',
				'btn_link_text'   => '',
				'btn_text_color'  => '#0d58a1',
				'btn_bg_color'    => '#fcb100',
				'css_animation'   => '',
				'animation_delay' => '0.4',   //In second
				'css'             => '',
			), $atts
		)
	);

	$css_class = 'banner-text-wrap';
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
	$show_btn_link = $show_btn_link == 'yes';

	$animation_delay = $animation_delay . 's';

	$html = '';
	$banner_bg_html = '';
	$title_html = '';
	$sub_title_html = '';
	$link_html = '';

	// Banner image size (background)
	$img_size_x = 390;
	$img_size_y = 214;
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

	$banner_bg_html .= '<div class="bg-banner" style="background-image: url(\'' . esc_url( $img['url'] ) . '\'); min-height: ' . esc_attr( $img['height'] ) . 'px;"></div>';

	// Title html
	if ( trim( $title ) != '' ) {
		$title_html = '<h4 style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $title ) . '</h4>';
	}
	if ( trim( $sub_title ) != '' ) {
		$sub_title_html = '<span style="color: ' . esc_attr( $sub_title_color ) . ';" class="sub-title">' . sanitize_text_field( $sub_title ) . '</span>';
	}
	if ( $show_btn_link && trim( $link['url'] ) != '' ) {
		$link_html = '<a style="color: ' . esc_attr( $btn_text_color ) . '; border-color: ' . esc_attr( $btn_bg_color ) . '; background-color: ' . esc_attr( $btn_bg_color ) . ';" href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . sanitize_text_field( $link['title'] ) . '" class="banner-link link-more">' . sanitize_text_field( $btn_link_text ) . '</a>';
	}

	if ( trim( $link['url'] ) != '' ) {
		$banner_bg_html = '<a class="bg-banner" href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . sanitize_text_field( $link['title'] ) . '" style="background-image: url(\'' . esc_url( $img['url'] ) . '\'); min-height: ' . esc_attr( $img['height'] ) . 'px;"><span class="screen-reader-text">' . sanitize_text_field( $link['title'] ) . '</span></a>';
	}

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				<div class="kt-banner block-banner-text">
					' . $banner_bg_html . '
					<div class="banner-text">
						' . $title_html . '
						' . $sub_title_html . '
						' . $link_html . '
					</div><!-- /.banner-text -->
				</div><!-- /.kt-banner -->
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return balanceTags( $html );

}

add_shortcode( 'ih_banner_text', 'ih_banner_text' );
