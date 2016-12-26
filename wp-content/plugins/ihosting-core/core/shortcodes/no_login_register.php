<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noLoginRegister' );
function noLoginRegister() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Login/Register Form', 'ihosting-core' ),
            'base'        => 'no_login_register', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Don\'t show welcome text if user is logged in', 'ihosting-core' ),
                    'param_name'    => 'dont_show_welcome',
                    'value' => array(
                        __( 'Yes', 'text_domain' ) => 'yes',
                        __( 'No', 'text_domain' ) => 'no'		    
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

function no_login_register( $atts ) {
    global $current_user;
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_login_register', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'dont_show_welcome' =>  'yes',
        'css_animation'     =>  '',
        'animation_delay'   =>  '0.4',   //In second
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'login-register-form-wrap wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    if ( !is_numeric( $animation_delay ) ) {
        $animation_delay = 0;
    }
    $animation_delay = $animation_delay . 's';
    
    $dont_show_welcome = trim( $dont_show_welcome ) == 'yes';
    
    $html = '';
    
    if ( is_user_logged_in() ) {
        if ( !$dont_show_welcome ) {
            $html .= '<p><span>' . sprintf( __( 'Hello %s!', 'ihosting' ), $current_user->display_name ) . '</span></p>';
        }
    }
    else{
        ob_start();
        get_template_part( 'template-parts/login' );
        $html .= ob_get_clean();   
    }
    
    $html = '<div class="' . esc_attr( $css_class ) . '">
                ' . $html . '
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';;
    
    return $html;
    
}

add_shortcode( 'no_login_register', 'no_login_register' );
