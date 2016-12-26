<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'ihImgWithText' );
function ihImgWithText() {
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

	global $zan_vc_anim_effects_in;
	vc_map(
		array(
			'name'     => esc_html__( 'IH Image With Text', 'ihosting-core' ),
			'base'     => 'ih_img_with_text', // shortcode
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
					'std'         => '320x280',
					'description' => wp_kses( esc_html__( '<em>{width}x{height}</em>. Example: <em>320x280</em>, etc...', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Image Circle', 'ihosting-core' ),
					'param_name' => 'img_circle',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no'
					),
					'std'        => 'yes'
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title', 'ihosting-core' ),
					'param_name' => 'title',
					'std'        => esc_html__( 'WHMCS Integration', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description', 'ihosting-core' ),
					'param_name' => 'short_desc',
					'std'        => '',
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
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Align', 'ihosting-core' ),
					'param_name' => 'align',
					'value'      => array(
						esc_html__( 'Theme Default', 'ihosting-core' ) => '',
						esc_html__( 'Left', 'ihosting-core' )          => 'text-left',
						esc_html__( 'Right', 'ihosting-core' )         => 'text-right',
						esc_html__( 'Center', 'ihosting-core' )        => 'text-center',
					),
					'std'        => ''
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
					'param_name' => 'title_color',
					'std'        => '#000',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description Color', 'ihosting-core' ),
					'param_name' => 'short_desc_color',
					'std'        => '#7c7c7c',
				),
				array(
					'type'       => 'dropdown',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'CSS Animation', 'ihosting-core' ),
					'param_name' => 'css_animation',
					'value'      => $zan_vc_anim_effects_in,
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

function ih_img_with_text( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ih_img_with_text', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'img_id'           => 0,
				'img_size'         => '320x280',
				'img_circle'       => 'yes',
				'title'            => '',
				'short_desc'       => '',
				'link'             => '',
				'title_tag'        => 'h3',
				'align'            => '',
				'title_color'      => '#000',
				'short_desc_color' => '#7c7c7c',
				'css_animation'    => '',
				'animation_delay'  => '0.4',   //In second
				'css'              => '',
			), $atts
		)
	);

	$css_class = 'ih-img-with-text-wrap ' . $align;
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

	$allowed_title_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'label', 'span', 'p' );
	if ( !in_array( $title_tag, $allowed_title_tags ) ) {
		$title_tag = 'h3';
	}

	$title_style = trim( $title_color ) != '' ? 'style="color: ' . esc_attr( $title_color ) . ';"' : '';
	$title_class = 'img-item-title';

	$html = '';
	$img_html = '';
	$text_html = '';
	$title_html = '';
	$short_desc_html = '';

	// Banner image size (background)
	$img_size_x = 60;
	$img_size_y = 60;
	if ( trim( $img_size ) != '' ) {
		$img_size = explode( 'x', $img_size );
	}
	$img_size_x = isset( $img_size[0] ) ? max( 0, intval( $img_size[0] ) ) : $img_size_x;
	$img_size_y = isset( $img_size[1] ) ? max( 0, intval( $img_size[1] ) ) : $img_size_y;

	$img = zmb_resize_image( $img_id, null, $img_size_x, $img_size_y, true, true, false );

	$img_wrap_class = 'img-wrap';
	if ( $img_circle == 'yes' ) {
		$img_wrap_class .= ' border-circle';
	}
	$img_html .= '<div class="' . esc_attr( $img_wrap_class ) . '"><img src="' . esc_url( $img['url'] ) . '" width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" alt=""></div>';

	if ( trim( $link['url'] ) != '' ) {
		$title_class .= ' has-link';
		$title_html .= '<' . $title_tag . ' ' . $title_style . ' class="' . esc_attr( $title_class ) . '" ><a href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '">' . sanitize_text_field( $title ) . '</a></' . $title_tag . '>';
	}
	else {
		$title_class .= ' no-link';
		$title_html .= '<' . $title_tag . ' ' . $title_style . ' class="' . esc_attr( $title_class ) . '" >' . sanitize_text_field( $title ) . '</' . $title_tag . '>';
	}

	if ( trim( $short_desc ) != '' ) {
		$short_desc_html .= '<span class="short-desc" style="color: ' . esc_attr( $short_desc_color ) . '">' . esc_html( $short_desc ) . '</span>';
	}

	if ( $text_html != '' || $short_desc_html != '' ) {
		$text_html = '<div class="text-wrap">
					' . $title_html . '
					' . $short_desc_html . '
					</div><!-- /.text-wrap -->';
	}

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
					<div class="item-inner">
						' . $img_html . '
						' . $text_html . '
					</div>
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'ih_img_with_text', 'ih_img_with_text' );
