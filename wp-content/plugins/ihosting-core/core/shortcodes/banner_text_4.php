<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkBannerText4' );
function lkBannerText4() {
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
			'name'     => esc_html__( 'LK Banner Text 4', 'ihosting-core' ),
			'base'     => 'lk_banner_text_4', // shortcode
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
					'std'         => '390x410',
					'description' => wp_kses( __( '<em>{width}x{height}</em>. Example: <em>390x410, 780x410</em>, etc... Image size also is banner base size.', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Background Color', 'ihosting-core' ),
					'param_name'  => 'banner_bg_color',
					'std'         => '#d3b6c2',
					'description' => esc_html__( 'In case of no image is chosen, the banner will display background solid color. Some colors suggestion: #d3b6c2, #aace9f, #83ccd5, #dcb793', 'ihosting-core' )
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title', 'ihosting-core' ),
					'param_name' => 'title',
					'std'        => esc_html__( 'Digital & Electronic', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
					'param_name' => 'title_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Sub Title', 'ihosting-core' ),
					'param_name' => 'sub_title',
					'std'        => esc_html__( 'The armchair is easy to keep clean because the cushions are machine washable', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Sub Title Color', 'ihosting-core' ),
					'param_name' => 'sub_title_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'vc_link',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Link', 'ihosting-core' ),
					'param_name' => 'link',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Link Text', 'ihosting-core' ),
					'param_name' => 'link_text',
					'std'        => esc_html__( 'Shop now!', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Link Text Color', 'ihosting-core' ),
					'param_name' => 'link_text_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Text Position', 'ihosting-core' ),
					'param_name' => 'text_pos',
					'value'      => array(
						esc_html__( 'Left', 'ihosting-core' )   => 'left',
						esc_html__( 'Right', 'ihosting-core' )  => 'right',
						esc_html__( 'Center', 'ihosting-core' ) => 'center',
					),
					'std'        => 'center',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Text Align', 'ihosting-core' ),
					'param_name' => 'text_align',
					'value'      => array(
						esc_html__( 'Left', 'ihosting-core' )   => 'left',
						esc_html__( 'Right', 'ihosting-core' )  => 'right',
						esc_html__( 'Center', 'ihosting-core' ) => 'center',
					),
					'std'        => 'center',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Enable Text Hover Effect', 'ihosting-core' ),
					'param_name' => 'enable_text_hover_effect',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no',
					),
					'std'        => 'yes',
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

function lk_banner_text_4( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_banner_text_4', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'img_id'                   => 0,
				'img_size'                 => '390x410',
				'banner_bg_color'          => '#d3b6c2',
				'title'                    => '',
				'title_color'              => '#fff',
				'sub_title'                => '',
				'sub_title_color'          => '#fff',
				'link'                     => '',
				'link_text'                => '',
				'link_text_color'          => '#fff',
				'text_pos'                 => 'center',
				'text_align'               => 'center',
				'enable_text_hover_effect' => 'yes',
				'css_animation'            => '',
				'animation_delay'          => '0.4',   //In second
				'css'                      => '',
			), $atts
		)
	);

	$css_class = 'banner-text-4-wrap wow ' . $css_animation;
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
	$banner_bg_html = '';
	$title_html = '';
	$sub_title_html = '';
	$link_html = '';

	// Banner image size (background)
	$img_size_x = 390;
	$img_size_y = 410;
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

	$banner_bg_html .= '<div class="bg-banner" style="background-image: url(\'' . esc_url( $img['url'] ) . '\'); min-height: ' . esc_attr( $img['height'] ) . 'px; background-color: ' . esc_attr( $banner_bg_color ) . ';"></div>';


	// Title html
	if ( trim( $title ) != '' ) {
		$title_html = '<h4 style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $title ) . '</h4>';
	}
	if ( trim( $sub_title ) != '' ) {
		$sub_title_html = '<span style="color: ' . esc_attr( $sub_title_color ) . ';" class="sub-title">' . sanitize_text_field( $sub_title ) . '</span>';
	}

	if ( trim( $link['url'] ) != '' ) {
		$banner_bg_html = '<a class="bg-banner" href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . sanitize_text_field( $link['title'] ) . '" style="background-image: url(\'' . esc_url( $img['url'] ) . '\'); min-height: ' . esc_attr( $img['height'] ) . 'px; background-color: ' . esc_attr( $banner_bg_color ) . ';"><span class="screen-reader-text">' . sanitize_text_field( $link['title'] ) . '</span></a>';
		if ( trim( $link_text ) != '' ) {
			$link_html .= '<a class="link-more" href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . sanitize_text_field( $link['title'] ) . '" style="color: ' . esc_attr( $link_text_color ) . ';">' . sanitize_text_field( $link_text ) . '</a>';
		}
	}

	$banner_class = 'kt-banner-4 block-banner-text-4 text-' . esc_attr( $text_align ) . ' hover-effect-crossing';
	if ( $enable_text_hover_effect == 'yes' ) {
		$banner_class .= ' has-text-hover-effect';
	}

	$banner_text_class = 'banner-text';
	$banner_text_css = 'transform: translateY(-50%); top: 50%;';
	if ( $text_pos == 'left' ) {
		$banner_text_css .= ' left: 30px;';
	}
	if ( $text_pos == 'right' ) {
		$banner_text_css .= ' right: 30px;';
	}
	if ( $text_pos == 'center' ) {
		$banner_text_css = 'transform: translateY(-50%) translateX(-50%); top: 50%; left: 50%;';
	}

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				<div class="' . esc_attr( $banner_class ) . '">
					' . $banner_bg_html . '
					<div class="' . esc_attr( $banner_text_class ) . '" style="' . $banner_text_css . '">
					    ' . $title_html . '
					    ' . $sub_title_html . '
					    ' . $link_html . '
					</div><!-- /.banner-text -->
				</div><!-- /.kt-banner-4 -->
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return balanceTags( $html );

}

add_shortcode( 'lk_banner_text_4', 'lk_banner_text_4' );
