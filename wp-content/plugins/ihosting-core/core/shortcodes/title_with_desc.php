<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'ihTitleWithDesc' );
function ihTitleWithDesc() {
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
			'name'     => esc_html__( 'IH Title With Description', 'ihosting-core' ),
			'base'     => 'ih_title_with_desc', // shortcode
			'class'    => '',
			'category' => esc_html__( 'iHosting', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Style', 'ihosting-core' ),
					'param_name' => 'style',
					'value'      => array(
						esc_html__( 'Style 1 (Description in the same line)', 'ihosting-core' )         => 'style_1',
						esc_html__( 'Style 2 (Description in the bottom of heading)', 'ihosting-core' ) => 'style_2'
					),
					'std'        => 'style_1',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Title', 'ihosting-core' ),
					'param_name'  => 'title',
					'std'         => esc_html__( 'Find your domain name here.', 'ihosting-core' ),
					'description' => wp_kses( __( '<code>{highlight}</code> will be replaced by highlight text of the title.', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Soft Description', 'ihosting-core' ),
					'param_name'  => 'short_desc',
					//'std'         => esc_html__( 'At only {highlight}/mth', 'ihosting-core' ),
					'description' => wp_kses( __( '<code>{highlight}</code> will be replaced by highlight text of the title.', 'ihosting-core' ), $allowed_tags ),
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
					'std'        => 'h3'
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Title Font Size', 'ihosting-core' ),
					'param_name'  => 'title_font_size',
					'std'         => '26',
					'description' => esc_html__( 'Default: 26. Unit is pixel.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Short Description Font Size', 'ihosting-core' ),
					'param_name'  => 'short_desc_font_size',
					'std'         => '18',
					'description' => esc_html__( 'Default: 18. Unit is pixel.', 'ihosting-core' ),
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
					'class'      => '',
					'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
					'param_name' => 'title_color',
					'std'        => '#222',
				),
				array(
					'type'       => 'colorpicker',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description Color', 'ihosting-core' ),
					'param_name' => 'short_desc_color',
					'std'        => '#666',
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
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title Highlight Text', 'ihosting-core' ),
					'param_name' => 'title_highlight_text',
					'group'      => esc_html__( 'Highlight texts', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'class'      => '',
					'heading'    => esc_html__( 'Title Highlight Text Color', 'ihosting-core' ),
					'param_name' => 'title_highlight_text_color',
					'std'        => '#0d58a1',
					'group'      => esc_html__( 'Highlight texts', 'ihosting-core' ),
					'dependency' => array(
						'element'   => 'title_highlight_text',
						'not_empty' => true,
					),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Title Highlight Text Font Size', 'ihosting-core' ),
					'param_name'  => 'title_highlight_text_font_size',
					'std'         => '26',
					'description' => esc_html__( 'Default: 26. Unit is pixel.', 'ihosting-core' ),
					'group'       => esc_html__( 'Highlight texts', 'ihosting-core' ),
					'dependency'  => array(
						'element'   => 'title_highlight_text',
						'not_empty' => true,
					),
				),
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Title Highlight Text Font Weight', 'ihosting-core' ),
					'param_name'  => 'title_highlight_text_font_weight',
					'value'       => array(
						esc_html__( 'Inherit', 'ihosting-core' ) => 'inherit',
						esc_html__( 'Normal', 'ihosting-core' )  => 'normal',
						esc_html__( 'Bold', 'ihosting-core' )    => 'bold',
					),
					'std'         => 'inherit',
					'description' => esc_html__( 'Default: Inherit.', 'ihosting-core' ),
					'group'       => esc_html__( 'Highlight texts', 'ihosting-core' ),
					'dependency'  => array(
						'element'   => 'title_highlight_text',
						'not_empty' => true,
					),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description Highlight Text', 'ihosting-core' ),
					'param_name' => 'short_desc_highlight_text',
					'group'      => esc_html__( 'Highlight texts', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description Highlight Text Color', 'ihosting-core' ),
					'param_name' => 'short_desc_highlight_text_color',
					'std'        => '#fcb100',
					'group'      => esc_html__( 'Highlight texts', 'ihosting-core' ),
					'dependency' => array(
						'element'   => 'short_desc_highlight_text',
						'not_empty' => true,
					),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Short Description Highlight Text Font Size', 'ihosting-core' ),
					'param_name'  => 'short_desc_highlight_text_font_size',
					'std'         => '18',
					'description' => esc_html__( 'Default: 18. Unit is pixel.', 'ihosting-core' ),
					'group'       => esc_html__( 'Highlight texts', 'ihosting-core' ),
					'dependency'  => array(
						'element'   => 'short_desc_highlight_text',
						'not_empty' => true,
					),
				),
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Short Description Highlight Font Weight', 'ihosting-core' ),
					'param_name'  => 'short_desc_highlight_text_font_weight',
					'value'       => array(
						esc_html__( 'Inherit', 'ihosting-core' ) => 'inherit',
						esc_html__( 'Normal', 'ihosting-core' )  => 'normal',
						esc_html__( 'Bold', 'ihosting-core' )    => 'bold',
					),
					'std'         => 'inherit',
					'description' => esc_html__( 'Default: Inherit.', 'ihosting-core' ),
					'group'       => esc_html__( 'Highlight texts', 'ihosting-core' ),
					'dependency'  => array(
						'element'   => 'short_desc_highlight_text',
						'not_empty' => true,
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
				)
			)
		)
	);
}

function ih_title_with_desc( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ih_title_with_desc', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'style'                                 => 'style_1',
				'title'                                 => '',
				'short_desc'                            => '',
				'title_tag'                             => 'h3',
				'title_font_size'                       => 26,
				'short_desc_font_size'                  => 18,
				'link'                                  => '',
				'title_color'                           => '#444',
				'short_desc_color'                      => '#444',
				'text_align'                            => 'center',
				'title_highlight_text'                  => '',
				'title_highlight_text_color'            => '#0d58a1',
				'title_highlight_text_font_size'        => 26,
				'title_highlight_text_font_weight'      => 'inherit',
				'short_desc_highlight_text'             => '',
				'short_desc_highlight_text_color'       => '#0d58a1',
				'short_desc_highlight_text_font_size'   => 18,
				'short_desc_highlight_text_font_weight' => 'inherit',
				'css_animation'                         => '',
				'animation_delay'                       => '0.4',   //In second
				'css'                                   => '',
			), $atts
		)
	);

	$css_class = 'ih-title-with-desc-wrap text-' . $text_align . ' ' . $style;
	if ( $css_animation != '' ) {
		$css_class .= ' wow ' . $css_animation;
	}
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

	$allowed_title_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'label', 'span' );
	if ( !in_array( $title_tag, $allowed_title_tags ) ) {
		$title_tag = 'h3';
	}

	$html = '';

	$title_html = '';
	$short_desc_html = '';
	$title_highlight_text_html = '';
	$short_desc_highlight_text_html = '';

	// Title highlight
	if ( trim( $title_highlight_text ) != '' ) {
		$title_highlight_text_font_size = str_replace( 'px', '', $title_highlight_text_font_size );
		$title_highlight_text_html = '<span class="ih-highlight" style="color: ' . esc_attr( $title_highlight_text_color ) . '; font-size: ' . $title_highlight_text_font_size . 'px; font-weight: ' . esc_attr( $title_highlight_text_font_weight ) . ';">' . esc_html( $title_highlight_text ) . '</span>';
	}

	// Short description highlight
	if ( trim( $short_desc_highlight_text ) != '' ) {
		$short_desc_highlight_text_font_size = str_replace( 'px', '', $short_desc_highlight_text_font_size );
		$short_desc_highlight_text_html = '<span class="ih-highlight" style="color: ' . esc_attr( $short_desc_highlight_text_color ) . '; font-size: ' . $short_desc_highlight_text_font_size . 'px; font-weight: ' . esc_attr( $short_desc_highlight_text_font_weight ) . ';">' . esc_html( $short_desc_highlight_text ) . '</span>';
	}

	$title = str_replace( '{highlight}', $title_highlight_text_html, sanitize_text_field( $title ) );
	$short_desc = str_replace( '{highlight}', $short_desc_highlight_text_html, sanitize_text_field( $short_desc ) );

	$title_style = '';
	if ( trim( $title_color ) != '' ) {
		$title_style .= 'color: ' . esc_attr( $title_color ) . ';';
	}
	if ( trim( $title_font_size ) != '' ) {
		$title_font_size = str_replace( 'px', '', $title_font_size );
		$title_style .= 'font-size: ' . intval( $title_font_size ) . 'px;';
	}
	$title_style = trim( $title_style ) != '' ? 'style="' . $title_style . '"' : '';
	$title_class = 'ih-title';

	if ( trim( $short_desc ) != '' ) {
		$short_desc_style = '';
		if ( trim( $short_desc_color ) != '' ) {
			$short_desc_style .= 'color: ' . esc_attr( $short_desc_color ) . ';';
		}
		if ( trim( $short_desc_font_size ) != '' ) {
			$short_desc_font_size = str_replace( 'px', '', $short_desc_font_size );
			$short_desc_style .= 'font-size: ' . intval( $short_desc_font_size ) . 'px;';
		}
		$short_desc_style = trim( $short_desc_style ) != '' ? 'style="' . $short_desc_style . '"' : '';
		$short_desc_html .= '<span class="short-desc" ' . $short_desc_style . '>' . $short_desc . '</span>';
	}

	if ( trim( $link['url'] ) != '' ) {
		$title_class .= ' has-link';
		if ( $style == 'style_1' ) { // Description in the same line
			$title_html .= '<' . $title_tag . ' ' . $title_style . ' class="' . esc_attr( $title_class ) . '" ><a href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '">' . $title . '</a>' . ' ' . $short_desc_html . '</' . $title_tag . '>';
		}
		else {
			$title_html .= '<' . $title_tag . ' ' . $title_style . ' class="' . esc_attr( $title_class ) . '" ><a href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '">' . $title . '</a></' . $title_tag . '>';
			$title_html .= $short_desc_html;
		}
	}
	else {
		$title_class .= ' no-link';
		if ( $style == 'style_1' ) { // Description in the same line
			$title_html .= '<' . $title_tag . ' ' . $title_style . ' class="' . esc_attr( $title_class ) . '" >' . $title . ' ' . $short_desc_html . '</' . $title_tag . '>';
		}
		else {
			$title_html .= '<' . $title_tag . ' ' . $title_style . ' class="' . esc_attr( $title_class ) . '" >' . $title . '</' . $title_tag . '>';
			$title_html .= $short_desc_html;
		}
	}

	//$title_html =  sprintf();

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				' . $title_html . '
			</div>';

	return $html;

}

add_shortcode( 'ih_title_with_desc', 'ih_title_with_desc' );

/**
 * Shortcode to display text with color, font size, font weight
 *
 * @param $atts
 */
function ih_text_style( $atts ) {
	extract(
		shortcode_atts(
			array(
				'text'        => '',
				'color'       => '#fcb100',
				'font_size'   => '16',
				'font_weight' => '400',
				'class'       => ''
			), $atts
		)
	);

	$html = '';

	if ( trim( $text ) != '' ) {
		$style = '';
		if ( trim( $color ) != '' ) {
			$style .= 'color: ' . esc_attr( $color ) . ';';
		}
		if ( trim( $font_size ) != '' ) {
			$font_size = str_replace( 'px', '', $font_size );
			$style .= 'font-size: ' . esc_attr( $font_size ) . 'px;';
		}
		if ( trim( $font_weight ) != '' ) {
			$style .= 'font-weight: ' . esc_attr( $font_weight ) . ';';
		}
		$html .= '<label class="lk-text-stye ' . esc_attr( $class ) . '" style="' . $style . '">' . sanitize_text_field( $text ) . '</label>';
	}

	return $html;

}

add_shortcode( 'ih_text_style', 'ih_text_style' );