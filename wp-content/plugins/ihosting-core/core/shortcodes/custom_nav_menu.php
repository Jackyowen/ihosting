<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'ihCustomMenu' );
function ihCustomMenu() {
	global $kt_vc_anim_effects_in;

	$custom_menus = array();
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	if ( is_array( $menus ) && !empty( $menus ) ) {
		foreach ( $menus as $single_menu ) {
			if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
				$custom_menus[$single_menu->name] = $single_menu->slug;
			}
		}
	}

	vc_map(
		array(
			'name'     => esc_html__( 'IH Custom Menu', 'ihosting-core' ),
			'base'     => 'ihosting_core_custom_nav_menu', // shortcode
			'class'    => '',
			'category' => esc_html__( 'iHosting', 'ihosting-core' ),
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
					'std'        => '#666666',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Menu', 'ihosting-core' ),
					'param_name'  => 'nav_menu', // slug
					'value'       => $custom_menus,
					'description' => empty( $custom_menus ) ? esc_html__( 'Custom menus not found. Please visit <b>Appearance > Menus</b> page to create new menu.', 'ihosting-core' ) : esc_html__( 'Select menu to display.', 'ihosting-core' ),
					'admin_label' => true,
					'save_always' => true,
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

function ihosting_core_custom_nav_menu( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ihosting_core_custom_nav_menu', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'title'       => '',
				'title_color' => '#666666',
				'nav_menu'    => '', // slug
				'css'         => '',
			), $atts
		)
	);

	$css_class = 'ih-custom-menu-wrap';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	$html = '';

	$type = 'WP_Nav_Menu_Widget';
	$args = array(
		'before_title' => '<h5 class="widgettitle" style="color: ' . esc_attr( $title_color ) . ';">',
		'after_title'  => '</h5>',
	);
	global $wp_widget_factory;

	$menu = get_term_by( 'slug', $nav_menu, 'nav_menu' );

	if ( $menu ) {
		$atts['nav_menu'] = $menu->term_id;

		// to avoid unwanted warnings let's check before using widget
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[$type] ) ) {

			$html .= '<div class="vc_wp_custommenu wpb_content_element ih-custom-menu" data-menu-slug="' . esc_attr( $menu->slug ) . '">';

			ob_start();
			the_widget( $type, $atts, $args );
			$html .= ob_get_clean();

			$html .= '</div><!-- /.ih-custom-menu -->';
		}

	}

	$html = '<div class="' . esc_attr( $css_class ) . '">' . $html . '</div><!-- /' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'ihosting_core_custom_nav_menu', 'ihosting_core_custom_nav_menu' );
