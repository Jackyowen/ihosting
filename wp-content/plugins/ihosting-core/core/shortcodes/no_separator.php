<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noSeparator' );
function noSeparator() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Separator', 'ihosting-core' ),
            'base'        => 'no_separator', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Style', 'ihosting-core' ),
                    'param_name'    => 'style',
                    'value' => array(
                        __( 'Simple', 'ihosting-core' ) => 'simple',
                        __( 'Separator with content', 'ihosting-core' ) => 'content',	    
                    ),
                    'std'           => 'simple',
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Type', 'ihosting-core' ),
                    'param_name'    => 'sep_type',
                    'value' => array(
                        __( 'Dashed', 'ihosting-core' ) => 'dashed',
                        __( 'Solid', 'ihosting-core' ) => 'solid',	    
                    ),
                    'std'           => 'dashed',
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Separator Color', 'ihosting-core' ),
                    'param_name'    => 'sep_color',
                    'std'           => '#bda47d',
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Content Type', 'ihosting-core' ),
                    'param_name'    => 'content_type',
                    'value' => array(
                        __( 'Text', 'ihosting-core' ) => 'text',
                        __( 'Icon', 'ihosting-core' ) => 'icon',	    
                    ),
                    'std'           => 'text',
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value'     => array( 'content' ),
    			   	),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Text/Icon Color', 'ihosting-core' ),
                    'param_name'    => 'text_color',
                    'std'           => '#000000',
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value'     => array( 'content' ),
    			   	),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Text', 'ihosting-core' ),
                    'param_name'    => 'text',
                    'std'           => __( 'Separators', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'content_type',
    				    'value'     => array( 'text' ),
    			   	),
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
    				    'element'   => 'content_type',
    				    'value' => array( 'icon' )
    			   	),
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Content Align', 'ihosting-core' ),
                    'param_name'    => 'content_align',
                    'value' => array(
                        __( 'Left', 'ihosting-core' ) => 'left',
                        __( 'Right', 'ihosting-core' ) => 'right',
                        __( 'Center', 'ihosting-core' ) => 'center',	  	    
                    ),
                    'std'           => 'center',
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value'     => array( 'content' ),
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

function no_separator( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_separator', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'style'             =>  'simple',
        'sep_type'          =>  'dashed',
        'sep_color'         =>  'bda47d',
        'content_type'      =>  'text',
        'text_color'        =>  '#000000',
        'text'              =>  '',
        'icon'              =>  '',
        'content_align'     =>  'center',
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'separator-wrap';
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    $html = '';
    $content_html = '';
    $sep_class = 'separator separator-' . esc_attr( $style );
    $sep_class .= ' separator-' . esc_attr( $sep_type );
    
    $sep_style = trim( $sep_color ) != '' ? 'style="color: ' . esc_attr( $sep_color ) . ';"' : '';
    
    if ( trim( $style ) != 'content' ) {
        // $sep_class .= ' separator-' . esc_attr( $sep_type );
    }
    else{
        $sep_class .= ' separator-' . esc_attr( $content_align );
        
        $text_style = trim( $text_color ) != '' ? 'style="color: ' . esc_attr( $text_color ) . ';"' : '';
        
        if ( trim( $content_type ) == 'text' ) {
            $content_html = '<div class="separator-innercontent">
            			 		<span ' . $text_style . '>' . sanitize_text_field( $text ) . '</span>
            			 	</div><!-- /.separator-innercontent -->';
        }
        else{ // Icon
            $content_html = '<div class="separator-innercontent">
        				 		<span class="icon ' . esc_attr( $icon ) . '" ' . $text_style . '></span>
        				 	</div>';
        }
    }
    
    $html = '<div class="' . esc_attr( $css_class ) . '">  
                <div class="' . esc_attr( $sep_class ) . '" ' . $sep_style . '>
                    ' . $content_html . '
                </div><!-- /.' . esc_attr( $sep_class ) . ' -->
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';
            
    return $html;
    
}

add_shortcode( 'no_separator', 'no_separator' );
