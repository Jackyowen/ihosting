<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noPieChart' );
function noPieChart() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Pie Chart', 'ihosting-core' ),
            'base'        => 'no_pie_chart', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Style', 'ihosting-core' ),
                    'param_name'    => 'style',
                    'value' => array(
                        __( 'Chart with icon', 'theone-core' ) => 'chart_icon',
                        __( 'Chart with number', 'theone-core' ) => 'chart_number',
                        __( 'Chart with text', 'theone-core' ) => 'chart_text',
                        __( 'Chart with image', 'theone-core' ) => 'chart_img'		    
                    ),
                    'std'           => 'chart_icon'
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Chart Title', 'ihosting-core' ),
                    'param_name'    => 'chart_title',
                    'std'           => __( 'iHosting pie chart', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Chart Percent', 'ihosting-core' ),
                    'param_name'    => 'chart_percent',
                    'std'           => 75,
                    'description'   => __( 'From 0 - 100.', 'ihosting-core' )
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
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value' => array( 'chart_icon' )
    			   	),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Chart Unit', 'ihosting-core' ),
                    'param_name'    => 'chart_unit',
                    'std'           => __( '&#37;', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value' => array( 'chart_number' )
    			   	),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Chart Text', 'ihosting-core' ),
                    'param_name'    => 'chart_text',
                    'std'           => __( 'iHostingstore', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value' => array( 'chart_text' )
    			   	),
                ),
                array(
                    'type'          => 'attach_image',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Chart Image', 'ihosting-core' ),
                    'param_name'    => 'chart_img',
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value' => array( 'chart_img' )
    			   	),
                    'description'   => __( 'Choose an image', 'ihosting-core' )
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Track Color', 'ihosting-core' ),
                    'param_name'    => 'trackcolor',
                    'std'           => '#e4e4e4',
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Chart Color', 'ihosting-core' ),
                    'param_name'    => 'barcolor',
                    'std'           => '#eeb14f',
                    'description'   => __( 'Bar, text and icon color.', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Chart Size', 'ihosting-core' ),
                    'param_name'    => 'size',
                    'std'           => 215,
                    'description'   => __( 'Chart size in pixel (px).', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Bar Line Width', 'ihosting-core' ),
                    'param_name'    => 'linewidth',
                    'std'           => 5,
                    'description'   => __( 'Bar line width in pixel (px).', 'ihosting-core' )
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

function no_pie_chart( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_pie_chart', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'style'             =>  'chart_icon',
        'chart_title'       =>  '',
        'chart_percent'     =>  75,
        'icon'              =>  '',
        'chart_unit'        =>  '&#37;',
        'chart_text'        =>  '',
        'chart_img'         =>  '',
        'trackcolor'        =>  '#e4e4e4',
        'barcolor'          =>  '#eeb14f',
        'size'              =>  215,
        'linewidth'         =>  5,
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'ts-progressbar-wrap';
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    $chart_attrs = 'data-trackColor="' . esc_attr( $trackcolor ) . '" data-barColor="' . esc_attr( $barcolor ) . '" data-lineWidth="' . esc_attr( $linewidth ) . '" data-size="' . intval( $size ) . '" data-percent="' . intval( $chart_percent ) . '" data-unit="' . esc_attr( $chart_unit ) . '"';
    
    $html = '';
    $inner_chart_html = '';
    $title_html = '';
    
    switch ( trim( $style ) ):
    
        case 'chart_icon':
            if ( trim( $icon ) != '' ) {
                $inner_chart_html = '<span class="icon ' . esc_attr( $icon ) . '"></span>';   
            }
            break;
        
        case 'chart_number':
            $inner_chart_html = '<span class="title chart-percent">' . intval( $chart_percent ) . esc_attr( $chart_unit ) . '</span>';
            break;
        
        case 'chart_text':
            $inner_chart_html = '<span class="title chart-text">' . sanitize_text_field( $chart_text ) . '</span>';
            break;
        
        case 'chart_img':
            $size = max( 1, ( intval( $size ) - 2*intval( $linewidth ) ) );
            $img = ihosting_core_resize_image( $chart_img, null, intval( $size ), intval( $size ), true, true, false );
            $inner_chart_html = '<span class="chart-image"><img src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( $chart_title ) . '"></span>';
            break;
    
    endswitch;
    
    if ( trim( $chart_title ) != '' ) {
        $title_html = '<h5 class="piechar-title">' . sanitize_text_field( $chart_title ) . '</h5>';
    }
    
    $html = '<div class="' . esc_attr( $css_class ) . '">
                <div class="ts-progressbar">
                    <div class="ts-chart" ' . $chart_attrs . '>
                        ' . $inner_chart_html . '
                    </div><!-- /.ts-chart -->
                    ' . $title_html . '
                </div><!-- /.ts-progressbar -->
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    
    return $html;
    
}

add_shortcode( 'no_pie_chart', 'no_pie_chart' );
