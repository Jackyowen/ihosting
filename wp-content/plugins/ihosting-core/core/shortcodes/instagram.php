<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'lkInstagram' );
function lkInstagram() {
	global $kt_vc_anim_effects_in;

	vc_map(
		array(
			'name'     => esc_html__( 'LK Instagram', 'ihosting-core' ),
			'base'     => 'ihosting_core_instagram', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title', 'ihosting-core' ),
					'param_name' => 'title',
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
					'heading'    => esc_html__( 'User Name', 'ihosting-core' ),
					'param_name' => 'username',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Mumber Of Images', 'ihosting-core' ),
					'param_name'  => 'number_of_images',
					'std'         => '8',
					'description' => esc_html__( 'Maximum is 9', 'ihosting-core' )
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Image Link Target', 'ihosting-core' ),
					'param_name' => 'target',
					'value'      => array(
						esc_html__( 'Open In New Tab', 'ihosting-core' )        => '_blank',
						esc_html__( 'Open In Current Window', 'ihosting-core' ) => '_self',
					),
					'std'        => '_blank',
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

function ihosting_core_instagram( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ihosting_core_instagram', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'title'            => '',
				'title_color'      => '#fff',
				'username'         => '',
				'number_of_images' => '8',
				'nav_menu'         => '', // slug
				'css_animation'    => '',
				'animation_delay'  => '0.4',   //In second
				'css'              => '',
			), $atts
		)
	);

	$css_class = 'kt-instagram-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}

	$animation_delay = $animation_delay . 's';

	$html = '';

	$type = 'ihostingInstagramWidget';
	$args = array(
		'before_title' => '<h5 class="widgettitle" style="color: ' . esc_attr( $title_color ) . ';">',
		'after_title'  => '</h5>',
	);
	global $wp_widget_factory;

	// to avoid unwanted warnings let's check before using widget
	if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[$type] ) ) {

		$html .= '<div class="lk-instagram">';

		ob_start();
		the_widget( $type, $atts, $args );
		$html .= ob_get_clean();

		$html .= '</div><!-- /.lk-instagram -->';
	}

	$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				' . $html . '
			</div><!-- /' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'ihosting_core_instagram', 'ihosting_core_instagram' );
