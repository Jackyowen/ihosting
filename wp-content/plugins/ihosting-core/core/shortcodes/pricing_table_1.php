<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'ihPricingTable1' );
function ihPricingTable1() {
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

	global $zan_vc_anim_effects_in;
	vc_map(
		array(
			'name'     => esc_html__( 'IH Pricing Table 1', 'ihosting-core' ),
			'base'     => 'ih_pricing_table_1', // shortcode
			'class'    => '',
			'category' => esc_html__( 'iHosting', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title', 'ihosting-core' ),
					'param_name' => 'title',
					'std'        => esc_html__( 'Standard', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description', 'ihosting-core' ),
					'param_name' => 'short_desc',
					'std'        => esc_html__( 'Great plan for Small Business', 'ihosting-core' ),
				),
                array(
                    'type'       => 'dropdown',
                    'class'      => '',
                    'heading'    => esc_html__( 'Style Hover box:', 'ihosting-core' ),
                    'param_name' => 'style_hover',
                    'value'      => array(
                        esc_html__( 'Style 1', 'ihosting-core' )    => 'box-1',
                        esc_html__( 'Style 2', 'ihosting-core' )    => 'box-2',
                    ),
                    'std'        => 'box-1'
                ),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Price Text', 'ihosting-core' ),
					'param_name' => 'price_text',
					'std'        => esc_html__( '$9.00', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Price Per', 'ihosting-core' ),
					'param_name' => 'price_per',
					'std'        => esc_html__( 'month', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show Button Link', 'ihosting-core' ),
					'param_name' => 'show_btn_link',
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
					'heading'    => esc_html__( 'Button Link Text', 'ihosting-core' ),
					'param_name' => 'btn_link_text',
					'std'        => esc_html__( 'Get Start', 'ihosting-core' ),
					'dependency' => array(
						'element' => 'show_btn_link',
						'value'   => 'yes',
					),
				),
				array(
					'type'       => 'vc_link',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Link', 'ihosting-core' ),
					'param_name' => 'link',
					'dependency' => array(
						'element' => 'show_btn_link',
						'value'   => 'yes',
					),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Highlight Pricing Table', 'ihosting-core' ),
					'param_name' => 'highlight_pricing',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no'
					),
					'std'        => 'no'
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Highlight Pricing Text', 'ihosting-core' ),
					'param_name' => 'highlight_ricing_text',
					'std'        => esc_html__( 'Feature', 'ihosting-core' ),
					'dependency' => array(
						'element' => 'highlight_pricing',
						'value'   => 'yes',
					),
				),
				array(
					'type'        => 'exploded_textarea_safe',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Features List', 'ihosting-core' ),
					'param_name'  => 'features_list',
					'std'         => wp_kses( __( 'fa fa-check|50 GB Web Space', 'ihosting-core' ), $allowed_tags ),
					'description' => wp_kses( __( 'Enter features for pricing table (Note: divide features with linebreaks (Enter)). Each line in format: <code>{Font Icon Class}|{Feature Text}</code>. Ex: <code>fa fa-check|50 GB Web Space</code>', 'ihosting-core' ), $allowed_tags ),
					'group'       => esc_html__( 'Features List', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
					'param_name' => 'title_color',
					'std'        => '#0d58a1',
					'group'      => esc_html__( 'Color', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description Color', 'ihosting-core' ),
					'param_name' => 'short_desc_color',
					'std'        => '#aaa',
					'group'      => esc_html__( 'Color', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Price Color', 'ihosting-core' ),
					'param_name' => 'price_color',
					'std'        => '#fcb100',
					'group'      => esc_html__( 'Color', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Other Text Color', 'ihosting-core' ),
					'param_name' => 'text_color',
					'std'        => '#666',
					'group'      => esc_html__( 'Color', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Highlight Text Color', 'ihosting-core' ),
					'param_name' => 'highlight_text_color',
					'std'        => '#fff',
					'group'      => esc_html__( 'Color', 'ihosting-core' ),
					'dependency' => array(
						'element' => 'highlight_pricing',
						'value'   => 'yes',
					),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Highlight Text Background Color', 'ihosting-core' ),
					'param_name' => 'highlight_text_bg_color',
					'std'        => '#e43e43',
					'group'      => esc_html__( 'Color', 'ihosting-core' ),
					'dependency' => array(
						'element' => 'highlight_pricing',
						'value'   => 'yes',
					),
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

function ih_pricing_table_1( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ih_pricing_table_1', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'title'                   => 0,
				'short_desc'              => '',
				'price_text'              => '',
				'price_per'               => '',
				'show_btn_link'           => 'yes',
				'btn_link_text'           => '',
				'link'                    => '',
				'highlight_pricing'       => 'no',
				'highlight_ricing_text'   => '',
				'features_list'           => '',
				'title_color'             => '#0d58a1',
				'short_desc_color'        => '#aaa',
				'price_color'             => '#fcb100',
				'text_color'              => '#666',
				'highlight_text_color'    => '#fff',
				'highlight_text_bg_color' => '#e43e43',
				'css_animation'           => '',
				'animation_delay'         => '0.4',   //In second
				'css'                     => '',
                'style_hover'             => ''
			), $atts
		)
	);

	$css_class = 'ih-pricing-table-1-wrap';
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

	$html = '';
	$title_html = '';
	$short_desc_html = '';
	$price_html = '';
	$features_list_html = '';
	$btn_html = '';
	$highlight_text_html = '';

	// Title html
	if ( trim( $title ) != '' ) {
		$title_html .= '<h4 class="price-title" style="color: ' . esc_attr( $title_color ) . ';">' . esc_html( $title ) . '</h4>';
	}

	// Short description html
	if ( trim( $short_desc ) != '' ) {
		$short_desc_html .= '<p class="price-short-desc" style="color: ' . esc_attr( $short_desc_color ) . ';">' . esc_html( $short_desc ) . '</p>';
	}

	// Price html
	if ( trim( $price_text . $price_per ) != '' ) {
		$price_html .= '<div class="price-cost"><span class="price-text" style="color: ' . esc_attr( $price_color ) . ';">' . esc_html( $price_text ) . '</span><span class="price-sep">' . htmlspecialchars( '/' ) . '</span><span class="price-per">' . esc_html( $price_per ) . '</span></div>';
	}

	// Features list html
	if ( trim( $features_list ) != '' ) {
		$features_list = explode( ',', $features_list );
		if ( !empty( $features_list ) ) {
			foreach ( $features_list as $feature ) {
				$feature_item_html = '';
				$feature = explode( '|', $feature );
				$bullet_class = isset( $feature[0] ) ? esc_attr( $feature[0] ) : '';
				$feature_text = isset( $feature[1] ) ? esc_html( $feature[1] ) : '';
				if ( !isset( $feature[1] ) && isset( $feature[0] ) ) {
					$bullet_class = '';
					$feature_text = esc_html( $feature[0] );
				}

				$feature_item_class = '';
				if ( trim( $bullet_class ) != '' ) {
					$feature_item_html .= '<i class="feature-bullet ' . esc_attr( $bullet_class ) . '" style="color: ' . esc_attr( $title_color ) . ';"></i>';
					$feature_item_class .= ' has-bullet';
				}
				if ( trim( $feature_text ) != '' ) {
					$feature_item_html .= '<span class="feature-text">' . $feature_text . '</span>';
				}
				if ( $feature_item_html != '' ) {

					$feature_item_html = '<li class="price-feature-item ' . esc_attr( $feature_item_class ) . '">' . $feature_item_html . '</li>';
					$features_list_html .= $feature_item_html;
				}
			}

			if ( trim( $features_list_html ) != '' ) {
				$features_list_html = '<div class="price-features-list-wrap"><ul class="price-features-list" style="color: ' . esc_attr( $text_color ) . ';">' . $features_list_html . '</ul></div>';
			}
		}
	}

	// Button html
	if ( $show_btn_link == 'yes' && trim( $btn_link_text ) != '' ) {
		if ( $link['url'] != '' ) {
			$btn_html .= '<a href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '" class="ih-price-btn btn has-link hover-effect-crossing">' . esc_html( $btn_link_text ) . '</a>';
		}
		else {
			$btn_html .= '<span class="ih-price-btn btn no-link">' . esc_html( $btn_link_text ) . '</span>';
		}
	}

	// Highlight text html
	if ( $highlight_pricing == 'yes' ) {
		$css_class .= ' pricing-table-hightlight';
		if ( trim( $highlight_ricing_text ) != '' ) {
			$highlight_text_html .= '<div class="hight-light-text" style="color: ' . esc_attr( $highlight_text_color ) . '; background-color: ' . esc_attr( $highlight_text_bg_color ) . ';">' . esc_html( $highlight_ricing_text ) . '</div>';
		}
	}


	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
					<div class="ih-pricing-table-content">
						<div class="ih-pricing-table-1 pricing-table-inner '.esc_attr($style_hover).'">
							' . $title_html . '
							' . $short_desc_html . '
							' . $price_html . '
							' . $features_list_html . '
							' . $btn_html . '
						</div><!-- /.pricing-table-inner -->
						' . $highlight_text_html . '
					</div><!-- /.ih-pricing-table-content -->
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'ih_pricing_table_1', 'ih_pricing_table_1' );
