<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'vc_before_init', 'lkProductsCarousel' );
function lkProductsCarousel()
{

    global $kt_vc_anim_effects_in;
    vc_map(
        array(
            'name'     => esc_html__( 'LK Products Carousel', 'ihosting-core' ),
            'base'     => 'lk_products_carousel', // shortcode
            'class'    => '',
            'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
            'params'   => array(
                array(
                    'type'        => 'autocomplete',
                    'heading'     => esc_html__( 'Products', 'ihosting-core' ),
                    'param_name'  => 'product_ids',
                    'settings'    => array(
                        'multiple' => true,
                        'sortable' => true,
                    ),
                    'save_always' => true,
                    'std'         => '',
                    'description' => esc_html__( 'Input product ID or product title to see suggestions.', 'ihosting-core' ),
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
            ),
        )
    );
}

// vc_autocomplete_{short_code_name}_{param_name}_callback
add_filter( 'vc_autocomplete_lk_products_carousel_product_ids_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_products_carousel_product_ids_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

function lk_products_carousel( $atts )
{

    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_products_carousel', $atts ) : $atts;

    if ( !class_exists( 'WooCommerce' ) ) {
        return '';
    }

    extract(
        shortcode_atts(
            array(
                'product_ids'     => '',
                'css_animation'   => '',
                'animation_delay' => '0.4',   //In second
                'css'             => '',
            ), $atts
        )
    );

    $css_class = 'lk-products-carousel-wrap wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;

    if ( !is_numeric( $animation_delay ) ) {
        $animation_delay = 0;
    }

    $animation_delay = $animation_delay . 's';

    $html = '';

    if ( trim( $product_ids ) != '' ) {
        $product_ids = explode( ',', $product_ids );

        $html_attr = 'data-number="1" data-loop="no" data-navControl="yes" data-Dots="no" data-autoPlay="no" data-autoPlayTimeout="4000" data-margin="0" data-rtl="no"';

        if ( !empty( $product_ids ) ) {
            foreach ( $product_ids as $product_id ) {
                $html .= do_shortcode( '[lk_single_product product_id=' . intval( $product_id ) . ' css_animation="" animation_delay="0"]' );
            }

            $html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                        <div class="products-carousel ihosting-owl-carousel nav-center nav-style-1" ' . $html_attr . ' >
                            ' . $html . '
                        </div><!-- /.products-carousel -->
                    </div>';

        }
    }

    return $html;

}

add_shortcode( 'lk_products_carousel', 'lk_products_carousel' );
