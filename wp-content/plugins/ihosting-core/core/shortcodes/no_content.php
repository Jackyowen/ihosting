<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noContent' );
function noContent() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Content', 'ihosting-core' ),
            'base'        => 'no_content', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'textarea_html',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Content', 'ihosting-core' ),
                    'param_name'    => 'content',
                    'std'           => '',
                ),
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Endble Do Shortcode', 'ihosting-core' ),
                    'param_name'    => 'enable_do_shortcode',
                    'value' => array(
                        __( 'Yes', 'theone-core' ) => 'yes',
                        __( 'No', 'theone-core' ) => 'no'		    
                    ),
                    'std'           => 'yes'
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


function no_content( $atts, $content = null ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_content', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'enable_do_shortcode'   =>  'yes',
        'css_animation'         =>  '',
        'animation_delay'       =>  '0.4',  // In second
        'css'                   =>  '',
	), $atts ) );
    
    $css_class = 'ihosting-content wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    if ( !is_numeric( $animation_delay ) ) {
        $animation_delay = '0';
    }
    $animation_delay = $animation_delay . 's';
    
    $content = wpb_js_remove_wpautop( $content, true );
    
    $html = '';
    
    $html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">';
    $html .= '<div class="about-text">';
    $html .= '<div class="text-aboutcontent">';
    if ( trim( $enable_do_shortcode ) == 'yes' ) {
        $html .= $content;
    }
    else{
        $html .= $content;
    }
    $html .= '</div><!-- /.text-aboutcontent -->';
    $html .= '</div><!-- /.about-text -->';
    $html .= '</div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_content', 'no_content' );
