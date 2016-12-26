<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'ktIconBox' );
function ktIconBox() {
	global $kt_vc_anim_effects_in;

	$params = array();

	$icon_params = lk_iconpicker_build_param();
	$params = array_merge(
		$icon_params,
		array(
			array(
				'type'       => 'dropdown',
				'class'      => '',
				'heading'    => esc_html__( 'Style', 'ihosting-core' ),
				'param_name' => 'style',
				'value'      => array(
					esc_html__( 'Style 1', 'ihosting-core' ) => 'style_1',
					esc_html__( 'Style 2', 'ihosting-core' ) => 'style_2',
					esc_html__( 'Style 3', 'ihosting-core' ) => 'style_3',
				),
				'std'        => 'style_1',
			),
			array(
				'type'       => 'colorpicker',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Icon Color', 'ihosting-core' ),
				'param_name' => 'icon_color',
				'std'        => '#fff',
			),
			array(
				'type'       => 'colorpicker',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Icon Hover Color', 'ihosting-core' ),
				'param_name' => 'icon_hover_color',
				'std'        => '#fff',
			),
			array(
				'type'       => 'dropdown',
				'class'      => '',
				'heading'    => esc_html__( 'Inherit Icon Hover Color For Border And Title', 'ihosting-core' ),
				'param_name' => 'inherit_icon_hv_color',
				'value'      => array(
					esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
					esc_html__( 'No', 'ihosting-core' )  => 'no',
				),
				'std'        => 'yes',
				'dependency' => array(
					'element' => 'style',
					'value'   => array( 'style_3' ),
				),
			),
			array(
				'type'       => 'colorpicker',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Icon Background Color', 'ihosting-core' ),
				'param_name' => 'icon_bg_color',
				'std'        => '#555',
			),
			array(
				'type'       => 'colorpicker',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Icon Hover Background Color', 'ihosting-core' ),
				'param_name' => 'icon_hover_bg_color',
				'std'        => '#eec15b',
			),
			array(
				'type'       => 'colorpicker',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Content Background Color', 'ihosting-core' ),
				'param_name' => 'content_bg_color',
				'std'        => '#fff',
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Title', 'ihosting-core' ),
				'param_name' => 'title',
				'std'        => esc_html__( 'Money Back Guarantee!', 'ihosting-core' ),
			),
			array(
				'type'       => 'colorpicker',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
				'param_name' => 'title_color',
				'std'        => '#444',
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Short Description', 'ihosting-core' ),
				'param_name' => 'short_desc',
				'std'        => esc_html__( 'We free 30 days 100% money back &amp; return', 'ihosting-core' ),
			),
			array(
				'type'       => 'colorpicker',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Short Description Color', 'ihosting-core' ),
				'param_name' => 'short_desc_color',
				'std'        => '#aaa',
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
		)
	);

	vc_map(
		array(
			'name'     => esc_html__( 'LK Icon Box', 'ihosting-core' ),
			'base'     => 'lk_icon_box', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => $params,
		)
	);
}

function lk_icon_box( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_icon_box', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'style'                 => 'style_1',
				'icon_type'             => 'lkflaticon',
				'icon_fontawesome'      => '',
				'icon_openiconic'       => '',
				'icon_typicons'         => '',
				'icon_entypo'           => '',
				'icon_linecons'         => '',
				'icon_monosocial'       => '',
				'icon_lkflaticon'       => '',
				'icon_peicon7stroke'    => '',
				'icon_color'            => '',
				'icon_hover_color'      => '',
				'inherit_icon_hv_color' => 'yes',
				'icon_bg_color'         => '',
				'icon_hover_bg_color'   => '',
				'content_bg_color'      => '',
				'title'                 => '',
				'title_color'           => '',
				'short_desc'            => '',
				'short_desc_color'      => '',
				'link'                  => '',
				'css_animation'         => '',
				'animation_delay'       => '0.4',   //In second
				'css'                   => '',
			), $atts
		)
	);

	$css_class = 'icon-box-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}
	$animation_delay = $animation_delay . 's';

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

	$icon_class_var = 'icon_' . esc_attr( $icon_type );
	$icon_class = $$icon_class_var;

	$html = '';
	$title_html = '';
	$icon_html = '';
	$short_desc_html = '';
	$content_html = '';

	$class = 'kt-icon-box icon-box icon-box-' . esc_attr( $style );

	if ( $style == 'style_3' && $inherit_icon_hv_color == 'yes' ) {
		$class .= ' title-border-inherit-color-icon-hover';
	}

	if ( trim( $title ) != '' ) {
		$title_style = trim( $title_color ) != '' ? 'color: ' . esc_attr( $title_color ) . ';' : '';
		if ( trim( $link['url'] ) != '' ) {
			$title_html = '<h4 style="' . $title_style . '"><a href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '">' . sanitize_text_field( $title ) . '</a></h4>';
		}
		else {
			$title_html = '<h4 style="' . $title_style . '">' . sanitize_text_field( $title ) . '</h4>';
		}
	}

	if ( trim( $icon_class ) != '' ) {
		$icon_style = trim( $icon_color ) != '' ? 'color: ' . esc_attr( $icon_color ) . ';' : '';
		$icon_style .= trim( $icon_bg_color ) != '' ? 'background-color: ' . esc_attr( $icon_bg_color ) . ';' : '';

		if ( trim( $icon_style ) != '' ) {
			$icon_style = 'style="' . $icon_style . '"';
		}

		$icon_attr = 'data-color="' . esc_attr( $icon_color ) . '" data-hover-color="' . esc_attr( $icon_hover_color ) . '"';
		$icon_attr .= ' data-bg-color="' . esc_attr( $icon_bg_color ) . '" data-hover-bg-color="' . esc_attr( $icon_hover_bg_color ) . '"';

		$icon_html = '<div class="icon-wrap" ' . $icon_attr . ' ' . $icon_style . '>
                        <span class="' . esc_attr( $icon_class ) . '"></span>
                     </div>';
	}

	if ( trim( $short_desc ) != '' ) {
		$short_desc_style = trim( $short_desc_color ) != '' ? 'color: ' . esc_attr( $short_desc_color ) . ';' : '';
		$short_desc_html = '<span class="short-desc" style="' . $short_desc_style . '">' . sanitize_text_field( $short_desc ) . '</span>';
	}

	if ( trim( $title_html . $short_desc_html ) != '' ) {
		$content_style = 'background-color: ' . esc_attr( $content_bg_color ) . ';';
		$content_html .= '<div class="icon-box-content" style="' . $content_style . '">
                            ' . $title_html . '
                            ' . $short_desc_html . '
                        </div>';
	}

	$html = '<div class="' . esc_attr( $class ) . '">
                ' . $icon_html . '
				' . $content_html . '
			</div><!-- /.' . esc_attr( $class ) . ' -->';

	$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                ' . $html . '
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'lk_icon_box', 'lk_icon_box' );
