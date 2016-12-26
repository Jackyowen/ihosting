<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noIconBox' );
function noIconBox() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Icon Box', 'ihosting-core' ),
            'base'        => 'no_icon_box', // shortcode
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
                        __( 'Style 1 - Simple', 'ihosting-core' ) => 'style1',
                        __( 'Style 2 - Icon hover effect', 'ihosting-core' ) => 'style2',
                        __( 'Style 3 - Small icon', 'ihosting-core' ) => 'style3',	    
                    ),
                    'std'           => 'iconbox-style1',
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
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Icon Color', 'ihosting-core' ),
                    'param_name'    => 'icon_color',
                    'std'           => '#bda47d',
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value'     => array( 'style1', 'style2' ),
    			   	),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Icon Background Color', 'ihosting-core' ),
                    'param_name'    => 'icon_bg_color',
                    'std'           => '#fa7468',
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value'     => array( 'style2' ),
    			   	),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'Branding indentity', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textarea',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Short Description', 'ihosting-core' ),
                    'param_name'    => 'short_desc',
                    'std'           => __( 'Proactively procrastinate market-driven niche markets and Energistically provide access to future-proof deliverables and distinctive manufactured products.', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'vc_link',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Link', 'ihosting-core' ),
                    'param_name'    => 'link',
                    'std'           => __( 'Branding indentity', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Show Read More Button', 'ihosting-core' ),
                    'param_name'    => 'show_read_more_btn',
                    'value' => array(
                        __( 'Yes', 'ihosting-core' ) => 'yes',
                        __( 'No', 'ihosting-core' ) => 'no',	    
                    ),
                    'std'           => 'no',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Read More Button Text', 'ihosting-core' ),
                    'param_name'    => 'read_more_text',
                    'std'           => __( 'Learn more', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'show_read_more_btn',
    				    'value'     => array( 'yes' ),
    			   	),
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Text Align', 'ihosting-core' ),
                    'param_name'    => 'text_align',
                    'value' => array(
                        __( 'Left', 'ihosting-core' ) => 'left',
                        __( 'Right', 'ihosting-core' ) => 'right',
                        __( 'Center', 'ihosting-core' ) => 'center',	  	    
                    ),
                    'std'           => 'center',
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

function no_icon_box( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_icon_box', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'style'             =>  'style1',
        'sep_type'          =>  'dashed',
        'icon'              =>  '',
        'icon_color'        =>  '',
        'icon_bg_color'     =>  '',
        'title'             =>  '',
        'short_desc'        =>  '',
        'link'              =>  '',
        'show_read_more_btn'    =>  'no',
        'read_more_text'    =>  '',
        'text_align'        =>  'center',
        'css_animation'     =>  '',
        'animation_delay'   =>  '0.4',   //In second
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'icon-boxes-wrap wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    if ( !is_numeric( $animation_delay ) ) {
        $animation_delay = 0;
    }
    $animation_delay = $animation_delay . 's';
    
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
    
    $html = '';
    $title_html = '';
    $icon_html = '';
    $short_desc_html = '';
    $read_more_html = '';
    
    $class = 'ts-icon-boxes iconbox-' . $style . ' text-' . $text_align;
    $icon_hover_attr = '';
    
    if ( trim( $title ) != '' ) {
        if ( trim( $link['url'] ) != '' ) {
            $title_html = '<h4><a href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '">' . sanitize_text_field( $title ) . '</a></h4>';
        }
        else{
            $title_html = '<h4>' . sanitize_text_field( $title ) . '</h4>';   
        }
    }
    
    if ( trim( $icon ) != '' ) {
        $icon_style = trim( $icon_color ) != '' && $style != 'style3' ? 'color: ' . esc_attr( $icon_color ) . ';' : '';
        $icon_style .= trim( $icon_bg_color ) != '' && $style == 'style2' ? 'background-color: ' . esc_attr( $icon_bg_color ) . ';' : '';
        
        if ( trim( $icon_style ) != '' ) {
            $icon_style = 'style="' . $icon_style .  '"';
        }
        
        $icon_hover_attr = trim( $icon_bg_color ) != '' && $style == 'style2' ? 'data-hover-box-shadow-color="' . ihosting_color_hex2rgba( $icon_bg_color, '0.3' ) . '"' : '';
        
        $icon_html = '<span class="icon ' . esc_attr( $icon ) . '" ' . $icon_style . '></span>';
    }
    
    if ( trim( $short_desc ) != '' ) {
        $short_desc_html = '<p>' . sanitize_text_field( $short_desc ) . '</p>';
    }
    
    $show_read_more_btn = trim( $show_read_more_btn ) == 'yes';
    if ( trim( $link['url'] ) != '' && $show_read_more_btn && trim( $read_more_text ) != '' ) {
        $read_more_html = '<a href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '" class="learn-more">' . sanitize_text_field( $read_more_text ) . '</a>';
    }
    
    $html = '<div class="' . esc_attr( $class ) . '" ' . $icon_hover_attr . '>
				<div class="iconbox-title">
					' . $icon_html . '
					' . $title_html . '
				</div>
				' . $short_desc_html . $read_more_html . '
			</div><!-- /.' . esc_attr( $class ) . ' -->';
    
    $html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                ' . $html . '
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';
            
    return $html;
    
}

add_shortcode( 'no_icon_box', 'no_icon_box' );
