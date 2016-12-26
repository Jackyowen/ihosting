<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'lkProductsCatsGrid' );
function lkProductsCatsGrid() {
	if ( !class_exists( 'WooCommerce' ) ) {
		return;
	}

	global $kt_vc_anim_effects_in;

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

	vc_map(
		array(
			'name'     => esc_html__( 'LK Products Categories Grid', 'ihosting-core' ),
			'base'     => 'lk_products_categories_grid', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'autocomplete',
					'heading'     => esc_html__( 'Categories', 'js_composer' ),
					'param_name'  => 'cat_slugs',
					'settings'    => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'description' => esc_html__( 'Choose product categories', 'js_composer' ),
				),
				array(
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Title Color', 'ihosting-core' ),
					'description' => esc_html__( 'Color of category name', 'js_composer' ),
					'param_name'  => 'title_color',
					'std'         => '#333',
				),
				array(
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Description Color', 'ihosting-core' ),
					'description' => esc_html__( 'Color of category description', 'js_composer' ),
					'param_name'  => 'desc_color',
					'std'         => '#666',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Overlay Color', 'ihosting-core' ),
					'param_name' => 'overlay_color',
					'std'        => '',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Enable Hover Effect (Hoverdir)', 'ihosting-core' ),
					'param_name' => 'enable_hover_effect',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no',
					),
					'std'        => 'yes',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Hover Effect Color', 'ihosting-core' ),
					'param_name' => 'hover_effect_color',
					'std'        => 'rgba(238, 193, 1, 0.3)',
					'dependency' => array(
						'element' => 'enable_hover_effect',
						'value'   => array( 'yes' ),
					),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Items Per Row', 'ihosting-core' ),
					'value'       => 4,
					'save_always' => true,
					'param_name'  => 'items_per_row',
					'description' => esc_html__( 'How many categories per row on the large screen? Min = 1, max = 4.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Items Height', 'ihosting-core' ),
					'value'       => 170,
					'save_always' => true,
					'param_name'  => 'items_height',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Image Size', 'ihosting-core' ),
					'value'       => '300x185',
					'save_always' => true,
					'param_name'  => 'img_size',
					'description' => wp_kses( __( '<em>{width}x{height}</em>. Example: <em>300x185</em>, etc...', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'       => 'dropdown',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'CSS Animation', 'ihosting-core' ),
					'param_name' => 'css_animation',
					'value'      => $kt_vc_anim_effects_in,
					'std'        => 'fadeInUp'
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

//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter( 'vc_autocomplete_lk_products_categories_grid_cat_slugs_callback', 'ihosting_product_cat_autocomplete_suggester_by_slug', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_categories_grid_cat_slugs_render', 'ihosting_product_cat_render_by_slug_exact', 10, 1 ); // Render exact category by id. Must return an array (label,value)

function lk_products_categories_grid( $atts ) {

	if ( !class_exists( 'WooCommerce' ) ) {
		return;
	}

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_products_categories_grid', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'cat_slugs'           => '',
				'title_color'         => '#333',
				'desc_color'          => '#666',
				'overlay_color'       => '',
				'enable_hover_effect' => 'yes',
				'hover_effect_color'  => 'rgba(238, 193, 1, 0.3)',
				'items_per_row'       => 4,
				'items_height'        => 170,
				'img_size'            => '300x185',
				'css_animation'       => '',
				'animation_delay'     => '0.4',   //In second
				'css'                 => '',
			), $atts
		)
	);

	$css_class = 'kt-product-categories-grid-wrap ' . $css_animation;
	if ( $css_animation != '' ) {
		$css_class .= ' wow';
	}
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}
	$animation_delay = $animation_delay . 's';

	$img_size_x = 300;
	$img_size_y = 185;
	if ( trim( $img_size ) != '' ) {
		$img_size = explode( 'x', $img_size );
	}
	$img_size_x = isset( $img_size[0] ) ? max( 0, intval( $img_size[0] ) ) : $img_size_x;
	$img_size_y = isset( $img_size[1] ) ? max( 0, intval( $img_size[1] ) ) : $img_size_y;

	// Remove all whitespaces
	$cat_slugs = preg_replace( '/\s+/', '', $cat_slugs );

	$cat_slugs = $cat_slugs != '' ? explode( ',', $cat_slugs ) : array();

	$html = '';
	$cats_html = '';
	$overlay_html = '';
	$hover_eff_bg_html = '';

	if ( trim( $overlay_color ) != '' ) {
		$overlay_html = '<div class="overlay" style="background-color: ' . esc_attr( $overlay_color ) . ';"></div>';
	}
	if ( $enable_hover_effect == 'yes' ) {
		$hover_eff_bg_html = '<div class="background hover-effect-bg" style="background-color: ' . esc_attr( $hover_effect_color ) . ';"></div>';
	}

	$items_per_row = min( 4, max( 1, intval( $items_per_row ) ) );
	$item_class = 'col-sm-6 col-md-3 padding-05';
	switch ( $items_per_row ) {
		case 4:
			$item_class = 'col-sm-6 col-md-3 padding-05';
			break;
		case 3:
			$item_class = 'col-sm-6 col-md-4 padding-05';
			break;
		case 2:
			$item_class = 'col-sm-6 padding-05';
			break;
		case 1:
			$item_class = 'col-sm-12 padding-05';
			break;
	}

	$items_height = intval( $items_height );

	if ( !empty( $cat_slugs ) ) {
		foreach ( $cat_slugs as $cat_slug ):

			$category = get_term_by( 'slug', trim( $cat_slug ), 'product_cat' );

			if ( $category != false ) {

				$cat_img_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
				$cat_img = ihosting_core_resize_image( $cat_img_id, null, $img_size_x, $img_size_y, true, true, false );

				$cat_html = '';
				$cat_img_bg_html = '';
				$cat_title_html = '';
				$cat_desc_html = trim( $category->description ) != '' ? '<span style="color: ' . esc_attr( $desc_color ) . ';">' . sanitize_text_field( $category->description ) . '</span>' : '';

				$term_link = get_term_link( $category, 'product_cat' );

				if ( is_wp_error( $term_link ) ) {
					$cat_title_html = '<h6 style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $category->name ) . '</h6>';
					$cat_img_bg_html = '<a href="#" class="bg-image click-return-false" style="background-image: url(' . esc_url( $cat_img['url'] ) . '); height:' . $items_height . 'px; min-height: ' . $items_height . 'px;"><span class="screen-reader-text">' . sanitize_text_field( $category->name ) . '</span></a>';
				}
				else {
					$cat_title_html = '<h6><a style="color: ' . esc_attr( $title_color ) . ';" href="' . esc_url( $term_link ) . '">' . sanitize_text_field( $category->name ) . '</a></h6>';
					$cat_img_bg_html = '<a href="' . esc_url( $term_link ) . '" class="bg-image" style="background-image: url(' . esc_url( $cat_img['url'] ) . '); height:' . $items_height . 'px; min-height: ' . $items_height . 'px;"><span class="screen-reader-text">' . sanitize_text_field( $category->name ) . '</span></a>';
				}

				$cat_class = 'item-category';
				if ( $enable_hover_effect == 'yes' ) {
					$cat_class .= ' kt-hover-dir';
				}

				$cat_html .= '<div class="' . $item_class . '">';
				$cat_html .= '<div class="' . $cat_class . '">';
				$cat_html .= $cat_img_bg_html;
				$cat_html .= $overlay_html;
				$cat_html .= $hover_eff_bg_html;
				$cat_html .= '<div class="content-info">';
				$cat_html .= $cat_title_html;
				$cat_html .= $cat_desc_html;
				$cat_html .= '</div><!-- /.content-info -->';
				$cat_html .= '</div>';
				$cat_html .= '</div>';

				$cats_html .= $cat_html;

			}

		endforeach;
	}

	if ( trim( $cats_html ) != '' ) {
		$cats_html = '<div class="row margin-0">
                            ' . $cats_html . '
                        </div>';
	}

	$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                ' . $cats_html . '
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'lk_products_categories_grid', 'lk_products_categories_grid' );
