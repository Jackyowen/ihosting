<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkBannerText3' );
function lkBannerText3() {
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
			'name'     => esc_html__( 'LK Banner Text 3', 'ihosting-core' ),
			'base'     => 'lk_banner_text_3', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Style', 'ihosting-core' ),
					'param_name' => 'style',
					'value'      => array(
						esc_html__( 'Style 1', 'ihosting-core' )                              => 'style_1',
						esc_html__( 'Style 2', 'ihosting-core' )                              => 'style_2',
						esc_html__( 'Style 3 (big text before small text)', 'ihosting-core' ) => 'style_3',
					),
					'std'        => 'style_1',
				),
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
					'std'         => '570x292',
					'description' => wp_kses( __( '<em>{width}x{height}</em>. Example: <em>570x292, 780x410</em>, etc...', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title', 'ihosting-core' ),
					'param_name' => 'title',
					'std'        => esc_html__( 'Macbook Air', 'ihosting-core' ),
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
					'std'        => esc_html__( 'New Processors', 'ihosting-core' ),
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
					'heading'    => esc_html__( 'Text Align', 'ihosting-core' ),
					'param_name' => 'text_align',
					'value'      => array(
						esc_html__( 'Left', 'ihosting-core' )   => 'left',
						esc_html__( 'Right', 'ihosting-core' )  => 'right',
						esc_html__( 'Center', 'ihosting-core' ) => 'center',
					),
					'std'        => 'right',
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
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Min Height Equal To', 'ihosting-core' ),
					'param_name'  => 'min_height_equal_to',
					'std'         => '',
					'description' => esc_html__( 'Leave this field empty to using banner height as min height of enter html selector that you want the banner have min height equal to. Ex: #hot-deal-of-the-day', 'ihosting-core' ),
					'group'       => esc_html__( 'Height Options', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Max Of Min Height', 'ihosting-core' ),
					'param_name'  => 'max_of_min_height',
					'std'         => '',
					'description' => esc_html__( 'Leave this field empty to using banner height as max of min height of enter a number. Ex: 529. Unit is pixel.', 'ihosting-core' ),
					'group'       => esc_html__( 'Height Options', 'ihosting-core' ),
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

function lk_banner_text_3( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_banner_text_3', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'style'                    => 'style_1',
				'img_id'                   => 0,
				'img_size'                 => '570x292',
				'title'                    => '',
				'title_color'              => '#fff',
				'sub_title'                => '',
				'sub_title_color'          => '#fff',
				'link'                     => '',
				'link_text'                => '',
				'link_text_color'          => '#fff',
				'text_align'               => 'right',
				'enable_text_hover_effect' => 'yes',
				'css_animation'            => '',
				'animation_delay'          => '0.4',   //In second
				'min_height_equal_to'      => '',
				'max_of_min_height'        => '',
				'css'                      => '',
			), $atts
		)
	);

	$css_class = 'banner-text-3-wrap wow ' . $css_animation;
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
	$img_size_x = 570;
	$img_size_y = 292;
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

	if ( trim( $min_height_equal_to ) != '' ) {
		$max_of_min_height = str_replace( 'px', '', strtolower( $max_of_min_height ) );
		$max_of_min_height = intval( $max_of_min_height ) <= 0 ? $img['height'] : intval( $max_of_min_height );
		$banner_bg_html .= '<div class="bg-banner min-height-equal-to" data-equal-to-selector="' . esc_attr( $min_height_equal_to ) . '" data-max-of-min-height="' . $max_of_min_height . '" style="background-image: url(\'' . esc_url( $img['url'] ) . '\'); min-height: ' . esc_attr( $img['height'] ) . 'px;"></div>';
	}
	else {
		$banner_bg_html .= '<div class="bg-banner" style="background-image: url(\'' . esc_url( $img['url'] ) . '\'); min-height: ' . esc_attr( $img['height'] ) . 'px;"></div>';
	}

	// Title html
	if ( trim( $title ) != '' ) {
		$title_html = '<h4 style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $title ) . '</h4>';
	}
	if ( trim( $sub_title ) != '' ) {
		$sub_title_html = '<span style="color: ' . esc_attr( $sub_title_color ) . ';" class="sub-title">' . sanitize_text_field( $sub_title ) . '</span>';
	}

	if ( trim( $link['url'] ) != '' ) {
		$banner_bg_html = '<a class="bg-banner" href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . sanitize_text_field( $link['title'] ) . '" style="background-image: url(\'' . esc_url( $img['url'] ) . '\'); min-height: ' . esc_attr( $img['height'] ) . 'px;"><span class="screen-reader-text">' . sanitize_text_field( $link['title'] ) . '</span></a>';
		if ( trim( $link_text ) != '' ) {
			$link_html .= '<a class="link-more" href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . sanitize_text_field( $link['title'] ) . '" style="color: ' . esc_attr( $link_text_color ) . ';">' . sanitize_text_field( $link_text ) . '</a>';
		}
	}

	$banner_class = 'kt-banner-3 block-banner-text-3 text-' . esc_attr( $text_align ) . ' hover-effect-crossing banner-' . esc_attr( $style );
	if ( $enable_text_hover_effect == 'yes' ) {
		$banner_class .= ' has-text-hover-effect';
	}

	$banner_text_class = 'banner-text';

	// Text always center on style_2
	if ( $style == 'style_2' ) {
		$banner_text_class .= ' text-center';
	}

	$banner_text_css = '';
	switch ( $text_align ) {
		case 'left':
			if ( in_array( $style, array( 'style_1', 'style_3' ) ) ) {
				$banner_text_css = 'left: 40px; transform: translateY(-50%); top: 50%;';
			}
			if ( $style == 'style_2' ) {
				$banner_text_css = 'left: 60px; transform: translateY(-50%); top: 50%;';
			}
			break;
		case 'right':
			if ( in_array( $style, array( 'style_1', 'style_3' ) ) ) {
				$banner_text_css = 'right: 40px; transform: translateY(-50%); top: 50%;';
			}
			if ( $style == 'style_2' ) {
				$banner_text_css = 'right: 60px; transform: translateY(-50%); top: 50%;';
			}
			break;
		case 'center':
			if ( in_array( $style, array( 'style_1', 'style_3' ) ) ) {
				$banner_text_css = 'transform: translateY(-50%); top: 50%; width: 100%; text-align: center;';
			}
			if ( $style == 'style_2' ) {
				$banner_text_css = 'transform: translateY(-50%); top: 50%; width: 100%; text-align: center;';
			}
			break;
	}

	$title_and_sub_title_html = $title_html . $sub_title_html;

	// Subtile before the title. Subtitle is bigger
	if ( $style == 'style_3' ) {
		$title_and_sub_title_html = $sub_title_html . $title_html;
	}

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				<div class="' . esc_attr( $banner_class ) . '">
					' . $banner_bg_html . '
					<div class="' . esc_attr( $banner_text_class ) . '" style="' . $banner_text_css . '">
					    ' . $title_and_sub_title_html . '
					    ' . $link_html . '
					</div><!-- /.banner-text -->
				</div><!-- /.kt-banner-3 -->
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return balanceTags( $html );

}

add_shortcode( 'lk_banner_text_3', 'lk_banner_text_3' );
