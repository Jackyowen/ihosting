<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noSimpleImgsSlide' );
function noSimpleImgsSlide() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Simple Images Slide', 'ihosting-core' ),
            'base'        => 'no_simple_imgs_slide', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'attach_images',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Images', 'ihosting-core' ),
                    'param_name'    => 'img_ids',
                    'description'   => __( 'Choose slide images', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Images Size', 'ihosting-core' ),
                    'param_name'    => 'imgs_size',
                    'std'           => '1842x608',
                    'description'   => __( '<em>{width}x{height}</em>. Example: <em>1842x608</em>, etc...', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textarea',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Images Text', 'ihosting-core' ),
                    'param_name'    => 'imgs_text',
                    'std'           => __( 'Minimalism style|Credibly fashion next-generation value through (from $30)|http://kute-themes.com|_blank|Theme Studio&#10;Nulla quis lorem ut|Pellentesque in ipsum id orci porta dapibus|http://themeforest.net', 'ihosting-core' ),
                    'description'   => __( '1. This field for images title, short description, link, link target...<br />
                                            2. Each line for an image, respectively <br />
                                            3. Empty line will skip image text, respectively <br />
                                            4. Each line must in format: {title}|{short description}|{link}|{link target}|{link title} <br />
                                            5. You can skip title, short description, link... by leave it empty, respectively. For example, skip short description and link title: <b>Minimalism style||http://kute-themes.com|_blank</b> <br />', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Loop', 'ihosting-core' ),
                    'param_name'    => 'loop',
                    'value' => array(
                        __( 'Yes', 'ihosting-core' ) => 'yes',
                        __( 'No', 'ihosting-core' ) => 'no'		    
                    ),
                    'std'           => 'yes'
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Autoplay', 'ihosting-core' ),
                    'param_name'    => 'autoplay',
                    'value' => array(
                        __( 'Yes', 'ihosting-core' ) => 'yes',
                        __( 'No', 'ihosting-core' ) => 'no'		    
                    ),
                    'std'           => 'yes',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Autoplay Timeout', 'ihosting-core' ),
                    'param_name'    => 'autoplay_timeout',
                    'std'           => 5000,
                    'description'   => __( 'Unit is milliseconds (ms). 1000ms = 1s.', 'ihosting-core' ),
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

function no_simple_imgs_slide( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_simple_imgs_slide', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'img_ids'           =>  '',
        'imgs_size'         =>  '1842x608',
        'imgs_text'         =>  '',
        'loop'              =>  'yes',
        'autoplay'          =>  'yes',
        'autoplay_timeout'  =>  5000,
        'css_animation'     =>  '',
        'animation_delay'   =>  '0.4',   // In second
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'ts-simple-slider-wrap wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    if ( !is_numeric( $animation_delay ) ) {
        $animation_delay = 0;
    }
    
    $animation_delay = $animation_delay . 's';
    
    $img_size_x = 1842;
    $img_size_y = 608;
    if ( trim( $imgs_size ) != '' ) {
        $imgs_size = explode( 'x', $imgs_size );
    }
    $img_size_x = isset( $imgs_size[0] ) ? max( 0, intval( $imgs_size[0] ) ) : $img_size_x;
    $img_size_y = isset( $imgs_size[1] ) ? max( 0, intval( $imgs_size[1] ) ) : $img_size_y;
    
    if ( trim( $imgs_text ) != '' ) {
        // Split each line
        $imgs_text = preg_split( '/\r\n|[\r\n]/', $imgs_text );   
    }
    else{
        $imgs_text = array();
    }
    
    $html = '';
    $slide_items_html = '';
    
    if ( trim( $img_ids ) != '' ) {
        
        $i = 0;    
        $img_ids = explode( ',', $img_ids );
        $total_items = count( $img_ids );
        
        $loop = $total_items <= 1 ? 'no' : $loop;
        $autoplay = $total_items <= 1 ? 'no' : $autoplay;
        
        foreach ( $img_ids as $img_id ):
        
            //{title}|{short description}|{link}|{link target}|{link title} 
            
            $img = ihosting_core_resize_image( $img_id, null, $img_size_x, $img_size_y, true, true, false );
            
            $img_text = array();
            if ( isset( $imgs_text[$i] ) ) {
                $img_text = explode( '|', $imgs_text[$i] );
            }
            
            $title = isset( $img_text[0] ) ? trim( $img_text[0] ) != '' ? $img_text[0] : '' : '';
            $sort_desc = isset( $img_text[1] ) ? trim( $img_text[1] ) != '' ? $img_text[1] : '' : '';
            $link = isset( $img_text[2] ) ? trim( $img_text[2] ) != '' ? $img_text[2] : '' : '';
            $link_target = isset( $img_text[3] ) ? trim( $img_text[3] ) != '' ? $img_text[3] : '' : '';
            $link_title = isset( $img_text[4] ) ? trim( $img_text[4] ) != '' ? $img_text[4] : '' : '';
            
            $title_html = '';
            $sort_desc_html = '';
            
            // Title html
            if ( trim( $title ) != '' ) {
                if ( trim( $link ) != '' ) { // If has link
                    $title_html = '<h2><a href="' . esc_url( $link ) . '" target="' . esc_attr( strip_tags( $link_target ) ) . '" title="' . esc_attr( strip_tags( $link_title ) ) . '">' . sanitize_text_field( $title ) . '</a></h2>';
                }
                else{ // Title with no link
                    $title_html = '<h2>' . sanitize_text_field( $title ) . '</h2>';
                }
            }
            
            $sort_desc_html = trim( $sort_desc ) != '' ? '<h5>' . sanitize_text_field( $sort_desc ) . '</h5>' : '';
            
            $slide_items_html .= '<div class="item-slide">
                					<figure><img src="' . esc_url( $img['url'] ) . '" alt=""></figure>
                					<div class="slide-text">
                						' . $title_html . '
                						' . $sort_desc_html . '
                					</div>
                				</div>';
            $i++;
            
        endforeach;
        
        if ( trim( $slide_items_html ) != '' ) {
            $html = '<div class="ts-slide-product slider-simplebanner ihosting-owl-carousel" data-number="1" data-loop="' . esc_attr( $loop ) . '" data-autoPlayTimeout="' . intval( $autoplay_timeout ) . '" data-autoPlay="' . esc_attr( $autoplay ) . '" data-Dots="yes">
                        ' . $slide_items_html . '
                    </div><!-- /.ihosting-owl-carousel -->';
        }
        
    }
    
    $html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                ' . $html . '
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_simple_imgs_slide', 'no_simple_imgs_slide' );
