<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noProductsCatsGrid' );
function noProductsCatsGrid() {
    if ( !class_exists( 'WooCommerce' ) ) {
        return;
    }
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Products Categories Grid', 'ihosting-core' ),
            'base'        => 'no_products_categories_grid', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
					'type' => 'autocomplete',
					'heading' => __( 'Categories', 'js_composer' ),
					'param_name' => 'cat_slugs',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'description' => __( 'Choose product categories', 'js_composer' ),
				),
                array(
					'type' => 'autocomplete',
					'heading' => __( 'Choose Categories X2 Image', 'js_composer' ),
					'param_name' => 'x2_img_cat_slugs',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'description' => __( 'Choose product categories will show larger image (x2).', 'js_composer' ),
				),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title Color', 'ihosting-core' ),
                    'description' => __( 'Color of category name', 'js_composer' ),
                    'param_name'    => 'title_color',
                    'std'           => '#000000',
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Description color', 'ihosting-core' ),
                    'description' => __( 'Color of category description', 'js_composer' ),
                    'param_name'    => 'desc_color',
                    'std'           => '#949494',
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp'
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'css_animation',
    				    'not_empty' => true,
    			   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}

//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter( 'vc_autocomplete_no_products_categories_grid_cat_slugs_callback', 'ihosting_product_cat_autocomplete_suggester_by_slug', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_no_products_categories_grid_cat_slugs_render', 'ihosting_product_cat_render_by_slug_exact', 10, 1 ); // Render exact category by id. Must return an array (label,value)
add_filter( 'vc_autocomplete_no_products_categories_grid_x2_img_cat_slugs_callback', 'ihosting_product_cat_autocomplete_suggester_by_slug', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_no_products_categories_grid_x2_img_cat_slugs_render', 'ihosting_product_cat_render_by_slug_exact', 10, 1 ); // Render exact category by id. Must return an array (label,value)

function no_products_categories_grid( $atts ) {
    
    if ( !class_exists( 'WooCommerce' ) ) {
        return;
    }
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_products_categories_grid', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'cat_slugs'         =>  '',
        'x2_img_cat_slugs'  =>  '',
        'title_color'       =>  '#000000',
        'desc_color'        =>  '#949494',
        'css_animation'     =>  '',
        'animation_delay'   =>  '0.4',   //In second
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'ts-categories-grid-wrap wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    if ( !is_numeric( $animation_delay ) ) {
        $animation_delay = 0;
    }
    $animation_delay = $animation_delay . 's';
    
    // Remove all all whitespaces
    $cat_slugs = preg_replace( '/\s+/', '', $cat_slugs );
    $x2_img_cat_slugs = preg_replace( '/\s+/', '', $x2_img_cat_slugs );
    
    $cat_slugs = $cat_slugs != '' ? explode( ',', $cat_slugs ) : array();
    $x2_img_cat_slugs = $x2_img_cat_slugs != '' ? explode( ',', $x2_img_cat_slugs ) : array();
    
    $html = '';
    $cats_html = '';
    
    if ( !empty( $cat_slugs ) ) {
        foreach ( $cat_slugs as $cat_slug ):
            
            $category = get_term_by( 'slug', trim( $cat_slug ), 'product_cat' );
            
            if ( $category != false ) {
                
                $cat_html = '';
                $cat_title_html = '';
                $cat_desc_html = trim( $category->description ) != '' ? '<p style="color: ' . esc_attr( $desc_color ) . ';">' . sanitize_text_field( $category->description ) . '</p>' : '';
                
                $term_link = get_term_link( $category, 'product_cat' );
                
                if ( is_wp_error( $term_link ) ) {
                    $cat_title_html = '<h4 style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $category->name ) . '</h4>';
                }
                else {
                    $cat_title_html = '<h4><a style="color: ' . esc_attr( $title_color ) . ';" href="' . esc_url( $term_link ) . '">' . sanitize_text_field( $category->name ) . '</a></h4>';
                }
                
                $cat_img_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
                $cat_img = ihosting_core_resize_image( $cat_img_id, null, 460, 467, true, true, false );
                
                $cat_class = 'item-category grid';
                if ( in_array( $cat_slug, $x2_img_cat_slugs ) ) {
                    $cat_class .= ' grid-2x';
                    $cat_img = ihosting_core_resize_image( $cat_img_id, null, 920, 934, true, true, false );
                }
                
                $cat_html .= '<div data-slug="' . $cat_slug . '" class="' . esc_attr( $cat_class ) . '">
                				<figure><img src="' . esc_url( $cat_img['url'] ) . '" alt="' . esc_attr( $category->name ) . '"></figure>
                				<div class="category-info">
                					' . $cat_title_html . '
                					' . $cat_desc_html . '
                				</div><!-- /.category-info -->
                			</div><!-- /.' . esc_attr( $cat_class ) . ' -->';
                
                $cats_html .= $cat_html;
                
            }
            
        endforeach;
    }
    
    if ( trim( $cats_html ) != '' ) {
        $cats_html =    '<div class="ts-categories-grid grid-masonry ihosting-product-categories-grid" data-layoutmode="packery">
                            ' . $cats_html . '
                        </div><!-- /.ts-categories-grid -->';
    }
    
    
    $html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                ' . $cats_html . '
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_products_categories_grid', 'no_products_categories_grid' );
