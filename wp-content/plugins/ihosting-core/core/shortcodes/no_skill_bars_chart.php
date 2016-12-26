<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noSkillBars' );
function noSkillBars() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Skill Bars', 'ihosting-core' ),
            'base'        => 'no_skill_bars_chart', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Text', 'ihosting-core' ),
                    'param_name'    => 'bar_text',
                    'std'           => __( 'Design', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Value', 'ihosting-core' ),
                    'param_name'    => 'bar_value',
                    'std'           => 80,
                    'description'   => __( 'Value percent. Min is 0, max is 100.', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Bar Color', 'ihosting-core' ),
                    'param_name'    => 'bar_color',
                    'std'           => '#bda47d',
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Bar Background Color', 'ihosting-core' ),
                    'param_name'    => 'bar_bg_color',
                    'std'           => '#f2f2f2',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Value', 'ihosting-core' ),
                    'param_name'    => 'bar_height',
                    'std'           => 5,
                    'description'   => __( 'Height of skill bar. Default 5px.', 'ihosting-core' ),
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

function no_skill_bars_chart( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_skill_bars_chart', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'bar_text'          =>  '',
        'bar_value'         =>  80,
        'bar_color'         =>  '',
        'bar_bg_color'      =>  '',
        'bar_height'        =>  5,
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'ts-skillbars-wrap';
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    $bar_text_html = trim( $bar_text ) != '' ? '<span class="skillbar-title">' . sanitize_text_field( $bar_text ) . '</span>' : '';
    $bar_value = min( 100, max( 0, intval( $bar_value ) ) );
    $bar_bg_color_style = trim( $bar_bg_color ) != '' ? 'style="background-color: ' . esc_attr( $bar_bg_color ) . ';"' : '';
    
    $html = '<div class="ts-skillbars">
				<div class="item-skillbar" data-height="' . intval( $bar_height ) . '" data-percent="' . intval( $bar_value ) . '" data-bgskill="' . esc_attr( $bar_color ) . '">
            		' . $bar_text_html . '
            		<div class="skill-bar-bg" ' . $bar_bg_color_style . '>
            			<div class="skillbar-bar">
            				<div class="skill-bar-percent">' . intval( $bar_value ) . '&#37;</div>
            			</div>
            	    </div><!-- /.skill-bar-bg -->
            	</div><!-- /.item-skillbar -->
			</div><!-- /.ts-skillbars -->';
   
   $html = '<div class="' . esc_attr( $css_class ) . '">
                   ' . $html . '
               </div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_skill_bars_chart', 'no_skill_bars_chart' );
