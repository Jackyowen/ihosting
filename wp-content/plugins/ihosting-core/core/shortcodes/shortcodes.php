<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


/** SHORTCODES NOT FOR VISUAL COMPOSER ================= **/

//add_action( 'vc_before_init', 'lkDocumentationMenuContent' );
function lkDocumentationMenuContent() {
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
			'name'     => esc_html__( 'LK Documentation Menu Content', 'ihosting-core' ),
			'base'     => 'ihosting_core_custom_nav_menu_content', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Menu', 'ihosting-core' ),
					'param_name'  => 'nav_menu', // slug
					'value'       => $custom_menus,
					'description' => empty( $custom_menus ) ? esc_html__( 'Menus not found. Please visit <b>Appearance > Menus</b> page to create new menu.', 'ihosting-core' ) : esc_html__( 'Select menu to display.', 'ihosting-core' ),
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

/**
 * Display content of menu items
 **/
function ihosting_core_custom_nav_menu_content( $atts ) {
	//$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ihosting_core_custom_nav_menu_content', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'title'       => '',
				'title_color' => '#444',
				'nav_menu'    => '', // slug
				'css'         => '',
			), $atts
		)
	);

	$css_class = 'kt-custom-menu-wrap';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		if ( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ) {
			$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
		}
	endif;

	$html = '';
	$content_html = '';

	$type = 'WP_Nav_Menu_Widget';
	$args = array(
		'before_title' => '<h5 class="widgettitle" style="color: ' . esc_attr( $title_color ) . ';">',
		'after_title'  => '</h5>',
	);
	global $wp_widget_factory;

	//$menu = get_term_by( 'slug', $nav_menu, 'nav_menu' );
	$menu_items = wp_get_nav_menu_items( $nav_menu );

	foreach ( $menu_items as $menu_item ) {
		if ( isset( $menu_item->object_id ) ) {
			if ( trim( $menu_item->object_id ) != '' ) {
				$obj_post = get_post( $menu_item->object_id );
				$content_html .= '<span id="anchor-menu-item-' . esc_attr( $menu_item->ID ) . '" class="doc-anchor"></span>';
				$content_html .= '<section class="clearfix document-content-section">
										<div class="entry-content">
											<h4>' . sanitize_text_field( $menu_item->title ) . '</h4>
											' . apply_filters( 'the_content', $obj_post->post_content ) . '
										</div>
					                </section><!-- /.document-content-section -->';
			}
		}
	}

	$html = '<div class="' . esc_attr( $css_class ) . '">' . $content_html . '</div><!-- /' . esc_attr( $css_class ) . ' -->';

	return $html;
}


// Actions add shortcodes
add_shortcode( 'ihosting_core_custom_nav_menu_content', 'ihosting_core_custom_nav_menu_content' );





