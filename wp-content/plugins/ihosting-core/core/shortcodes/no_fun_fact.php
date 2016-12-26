<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noFunFact' );
function noFunFact() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Fun Fact', 'ihosting-core' ),
            'base'        => 'no_fun_fact', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Number', 'ihosting-core' ),
                    'param_name'    => 'number',
                    'std'           => 3600,
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'Clients', 'ihosting-core' ),
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

function no_fun_fact( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_fun_fact', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'number'            =>  3600,
        'title'             =>  '',
        'css_animation'     =>  '',
        'animation_delay'   =>  '0.4',   //In second
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'ts-funfact-wrap wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    if ( !is_numeric( $animation_delay ) ) {
        $animation_delay = 0;
    }
    $animation_delay = $animation_delay . 's';
    
    $number = max( 1, intval( $number ) );
    
    $html = '';
    $title_html = '';
    
    if ( trim( $title ) != '' ) {
        $title_html = '<h5 class="title-funfact">' . sanitize_text_field( $title ) . '</h5>';
    }
    
    $html .= '<div class="ts-funfact">
				<span class="number title" data-number="' . esc_attr( $number ) . '">' . sanitize_text_field( $number ) . '</span>
				' . $title_html . '
			</div><!-- /.ts-funfact -->';
   
   $html =  '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                ' . $html . '
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_fun_fact', 'no_fun_fact' );
