<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'lkDocumentationMenu' );
function lkDocumentationMenu() {
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
			'name'     => esc_html__( 'LK Documentation Menu', 'ihosting-core' ),
			'base'     => 'ihosting_core_doc_menu', // shortcode
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

function ihosting_core_doc_menu( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ihosting_core_doc_menu', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'nav_menu' => '', // slug
				'css'      => '',
			), $atts
		)
	);

	$css_class = 'kt-doc-menu-wrap';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	$html = '';
	$nav_html = '';
	$content_html = '';

	$type = 'LK_Nav_Menu_Widget';
	$args = array();

	global $wp_widget_factory;

	$menu = get_term_by( 'slug', $nav_menu, 'nav_menu' );

	if ( $menu ) {
		$atts['nav_menu'] = $menu->term_id;

		// to avoid unwanted warnings let's check before using widget
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[$type] ) ) {

			$nav_html .= '<div class="vc_wp_custommenu wpb_content_element kt-doc-menu"><div class="container">';

			ob_start();
			the_widget( $type, $atts, $args );
			$nav_html .= ob_get_clean();

			$nav_html .= '</div></div><!-- /.kt-doc-menu -->';
		}

		$menu_items = wp_get_nav_menu_items( $atts['nav_menu'] );
		if ( !empty( $menu_items ) ) {
			foreach ( $menu_items as $menu_item ) {
				if ( isset( $menu_item->object_id ) ) {
					if ( trim( $menu_item->object_id ) != '' ) {
						if ( $menu_item->object == 'megamenu' ) {
							$obj_post = get_post( $menu_item->object_id );
							$post_content = str_replace( 'ihosting_core_custom_nav_menu', 'ihosting_core_custom_nav_menu_content', $obj_post->post_content );

							$mega_menu_intro = '';
							if ( trim( strtolower( $menu_item->title ) ) == 'shortcodes for visual composer' ) {
								$mega_menu_intro_doc = get_page_by_title( 'Shortcodes For Visual Composer', OBJECT, 'kt_doc' );
								if ( isset( $mega_menu_intro_doc ) ) {
									$mega_menu_intro = apply_filters( 'the_content', $mega_menu_intro_doc->post_content );
								}
							}

							$content_html .= '<span id="anchor-menu-item-' . esc_attr( $menu_item->ID ) . '" class="doc-anchor"></span>';
							$content_html .= '<section class="clearfix document-content-section section-has-child document-content-section-' . esc_attr( $menu_item->ID ) . '" data-object="' . esc_attr( $menu_item->object ) . '">
												<div class="entry-content">
													<h4>' . sanitize_text_field( $menu_item->title ) . '</h4>
													' . $mega_menu_intro . '
												</div>
							                </section><!-- /.document-content-section -->';
							$content_html .= '<div class="child-of-section child-of-section-' . esc_attr( $menu_item->ID ) . '">' . apply_filters( 'the_content', $post_content ) . '</div>';
						}
						else {
							$obj_post = get_post( $menu_item->object_id );
							$content_html .= '<span id="anchor-menu-item-' . esc_attr( $menu_item->ID ) . '" class="doc-anchor"></span>';
							$content_html .= '<section class="clearfix document-content-section document-content-section-' . esc_attr( $menu_item->ID ) . '" data-object="' . esc_attr( $menu_item->object ) . '">
												<div class="entry-content">
													<h4>' . sanitize_text_field( $menu_item->title ) . '</h4>
													' . apply_filters( 'the_content', $obj_post->post_content ) . '
												</div>
							                </section><!-- /.document-content-section -->';
						}
					}
				}
			}
		}

		if ( trim( $content_html ) != '' ) {
			$content_html = '<div class="document-content-sections-wrap">
								' . $content_html . '
			                </div><!-- /.document-content-sections-wrap -->';
		}

	}

	$html = '<div class="' . esc_attr( $css_class ) . '">
				' . $nav_html . '
				' . $content_html . '
			</div><!-- /' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'ihosting_core_doc_menu', 'ihosting_core_doc_menu' );
