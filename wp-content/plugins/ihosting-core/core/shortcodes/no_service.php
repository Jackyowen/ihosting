<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noService' );
function noService() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Service', 'ihosting-core' ),
            'base'        => 'no_service', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'Quality delivery service', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'vc_link',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Link', 'ihosting-core' ),
                    'param_name'    => 'link',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Short Description', 'ihosting-core' ),
                    'param_name'    => 'short_desc',
                    'std'           => __( 'Hourly time slots for deliveries.', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'iconpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Icon', 'ihosting-core' ),
                    'param_name'    => 'icon',
                    'settings' => array(
        				'emptyIcon' => true, // default true, display an "EMPTY" icon?
        				'type' => 'linea',
        				'iconsPerPage' => 100, // default 100, how many icons per/page to display
        			),
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Text Align', 'ihosting-core' ),
                    'param_name'    => 'text_align',
                    'value' => array(
                        __( 'Left', 'theone-core' ) => 'left',
                        __( 'Right', 'theone-core' ) => 'right',
                        __( 'Center', 'theone-core' ) => 'center'		    
                    ),
                    'std'           => 'left',
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Icon Color', 'ihosting-core' ),
                    'param_name'    => 'icon_color',
                    'std'           => '#000000',
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title Color', 'ihosting-core' ),
                    'param_name'    => 'title_color',
                    'std'           => '#000000',
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Short Description Color', 'ihosting-core' ),
                    'param_name'    => 'short_desc_color',
                    'std'           => '#000000',
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
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

function no_service( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_service', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'title'             =>  '',
        'link'              =>  '',
        'short_desc'        =>  '',
        'icon'              =>  '',
        'text_align'        =>  'left',
        'icon_color'        =>  '#000000',
        'title_color'       =>  '#000000',
        'short_desc_color'  =>  '#000000',
        'css_animation'     =>  '',
        'animation_delay'   =>  '0.4',   //In second
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'ts-service wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    $css_class .= ' text-' . esc_attr( $text_align );
    
    $link_default = array(
        'url'       =>  '',
        'title'     =>  '',
        'target'    =>  ''
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
    
    $icon_style = trim( $icon_color ) != '' ? 'style="color: ' . esc_attr( $icon_color ) . ';"' : '';
    $icon_html = trim( $icon ) != '' ? '<span ' . $icon_style . ' class="icon ' . esc_attr( $icon ) . '"></span>' : '';
    
    $title_html = '';
    $title_style = trim( $title_color ) != '' ? 'style="color: ' . esc_attr( $title_color ) . ';"' : '';
    if ( trim( $link['url'] ) != '' ) {
        $title_html = '<h4><a ' . $title_style . ' href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '">' . sanitize_text_field( $title ) . '</a></h4>';
    }
    else{
        $title_html = '<h4 ' . $title_style . ' >' . sanitize_text_field( $title ) . '</h4>';
    }
    
    $desc_style = trim( $short_desc_color ) != '' ? 'style="color: ' . esc_attr( $short_desc_color ) . ';"' : '';
    $desc_html = trim( $short_desc ) != '' ? '<p ' . $desc_style . '>' . sanitize_text_field( $short_desc ) . '</p>' : '';
    
    $html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '" >';
    $html .= $icon_html . $title_html . $desc_html;
    $html .= '</div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_service', 'no_service' );
