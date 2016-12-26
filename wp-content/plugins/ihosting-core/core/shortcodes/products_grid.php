<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'lkProductsGrid' );
function lkProductsGrid() {
	global $kt_vc_anim_effects_in;

	$order_by_values = array(
		'',
		esc_html__( 'Date', 'ihosting-core' )          => 'date',
		esc_html__( 'ID', 'ihosting-core' )            => 'ID',
		esc_html__( 'Author', 'ihosting-core' )        => 'author',
		esc_html__( 'Title', 'ihosting-core' )         => 'title',
		esc_html__( 'Modified', 'ihosting-core' )      => 'modified',
		esc_html__( 'Random', 'ihosting-core' )        => 'rand',
		esc_html__( 'Comment count', 'ihosting-core' ) => 'comment_count',
		esc_html__( 'Menu order', 'ihosting-core' )    => 'menu_order',
	);

	$order_way_values = array(
		'',
		esc_html__( 'Descending', 'ihosting-core' ) => 'DESC',
		esc_html__( 'Ascending', 'ihosting-core' )  => 'ASC',
	);


	vc_map(
		array(
			'name'     => esc_html__( 'LK Products Grid', 'ihosting-core' ),
			'base'     => 'lk_products_grid', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'ihosting_select_product_cat_field', // slug
					'heading'     => esc_html__( 'Category', 'ihosting-core' ),
					'param_name'  => 'cat_slug',
					'std'         => 0,
					'description' => esc_html__( 'Choose a products category', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Per Page', 'ihosting-core' ),
					'value'       => 12,
					'save_always' => true,
					'param_name'  => 'per_page',
					'description' => esc_html__( 'How many items you want to show per page?', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Columns', 'ihosting-core' ),
					'value'       => 4,
					'save_always' => true,
					'param_name'  => 'columns',
					'description' => esc_html__( 'How many columns per row? Min = 2, max = 4.', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Margin Between Products', 'ihosting-core' ),
					'param_name' => 'products_margin',
					'value'      => array(
						esc_html__( 'Margin', 'ihosting-core' )    => 'products-grid-margin',
						esc_html__( 'No margin', 'ihosting-core' ) => 'products-grid-no-margin',
					),
					'std'        => 'products-grid-no-margin',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order By', 'ihosting-core' ),
					'param_name'  => 'orderby',
					'value'       => $order_by_values,
					'save_always' => true,
					'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'ihosting-core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Sort Order', 'ihosting-core' ),
					'param_name'  => 'order',
					'value'       => $order_way_values,
					'save_always' => true,
					'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'ihosting-core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
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

function lk_products_grid( $atts ) {
	global $ihosting; // Theme options

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_products_grid', $atts ) : $atts;

	if ( !class_exists( 'WooCommerce' ) ):
		return '';
	endif;

	extract(
		shortcode_atts(
			array(
				'cat_slug'        => '',
				'per_page'        => '',
				'columns'         => '',
				'products_margin' => '',
				'orderby'         => '',
				'order'           => '',
				'css_animation'   => '',
				'animation_delay' => '0.4',   //In second
				'css'             => '',
			), $atts
		)
	);

	$css_class = 'kt-products-shortcode-grid-wrap';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	$html = '';

	// Validate columns in [2, 4]
	$columns = max( 2, min( 4, intval( $columns ) ) );
	$current_products_per_row_setting = isset( $ihosting['woo_products_per_row'] ) ? max( 2, intval( $ihosting['woo_products_per_row'] ) ) : 3;
	$ihosting['woo_products_per_row'] = $columns; // Set products per row
	$atts['columns'] = $columns;

	// Default ordering args
	$ordering_args = WC()->query->get_catalog_ordering_args( $orderby, $order );
	$meta_query = WC()->query->get_meta_query();

	$query_args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'orderby'             => $ordering_args['orderby'],
		'order'               => $ordering_args['order'],
		'posts_per_page'      => $per_page,
		'meta_query'          => $meta_query,
	);

	if ( trim( $cat_slug ) != '' ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'terms'    => array_map( 'sanitize_title', explode( ',', $cat_slug ) ),
				'field'    => 'slug',
				'operator' => 'IN',
			),
		);
	}

	if ( isset( $ordering_args['meta_key'] ) ) {
		$query_args['meta_key'] = $ordering_args['meta_key'];
	}

	// Set loop grid
	//$current_enable_shop_grid_masonry_setting = isset( $ihosting[ 'opt_enable_shop_grid_masonry' ] ) ? $ihosting[ 'opt_enable_shop_grid_masonry' ] : 0;
	//$ihosting[ 'opt_enable_shop_grid_masonry' ] = 0; // Disable grid masonry

	$html = ihosting_product_loop( $query_args, $atts, 'product_cat', esc_attr( $products_margin ) );

	// Reset old settings
	//$ihosting[ 'opt_enable_shop_grid_masonry' ] = $current_enable_shop_grid_masonry_setting;
	$ihosting['woo_products_per_row'] = $current_products_per_row_setting;

	// Remove ordering query arguments
	WC()->query->remove_ordering_args();

	// Backup theme options products layout style
	$products_layout_style_bak = isset( $ihosting['woo_shop_default_layout'] ) ? $ihosting['woo_shop_default_layout'] : '';
	$ihosting['woo_shop_default_layout'] = 'grid';

	$html = '<div class="' . esc_attr( $css_class ) . '">
                ' . $html . '
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';

	// Restore theme options products layout style
	$ihosting['woo_shop_default_layout'] = $products_layout_style_bak;

	return $html;

}

add_shortcode( 'lk_products_grid', 'lk_products_grid' );
