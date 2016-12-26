<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noBanner' );
function noBanner() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Banner', 'ihosting-core' ),
            'base'        => 'no_banner', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Style', 'ihosting-core' ),
                    'param_name'    => 'style',
                    'value' => array(
                        __( 'Style 1 (Text left)', 'ihosting-core' ) => 'style-1',
                        __( 'Style 2 (Text center)', 'ihosting-core' ) => 'style-2'		    
                    ),
                    'std'           => 'style-1'
                ),
                array(
                    'type'          => 'attach_image',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Image', 'ihosting-core' ),
                    'param_name'    => 'img_id',
                    'description'   => __( 'Choose banner image', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Image Size', 'ihosting-core' ),
                    'param_name'    => 'img_size',
                    'std'           => '593x384',
                    'description'   => __( '<em>{width}x{height}</em>. Example: <em>593x384</em>, <em>1840x295</em>, etc...', 'ihosting-core' )
                ),
                array(
                    'type'          => 'attach_image',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Image Icon', 'ihosting-core' ),
                    'param_name'    => 'img_icon_id',
                    'description'   => __( 'Choose image icon', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Image Icon Size', 'ihosting-core' ),
                    'param_name'    => 'img_icon_size',
                    'std'           => '172x172',
                    'description'   => __( '<em>{width}x{height}</em>. Example: <em>172x172</em>, <em>280x80</em>, etc...', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'Banner title', 'ihosting-core' ),
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
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Sub Title', 'ihosting-core' ),
                    'param_name'    => 'sub_title',
                    'std'           => __( 'Banner sub title', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Sub title Color', 'ihosting-core' ),
                    'param_name'    => 'sub_title_color',
                    'std'           => '#949494',
                ),
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Show Banner Link', 'ihosting-core' ),
                    'param_name'    => 'show_banner_link',
                    'value' => array(
                        __( 'Yes', 'ihosting-core' ) => 'yes',
                        __( 'No', 'ihosting-core' ) => 'no'		    
                    ),
                    'std'           => 'yes',
                ),
                array(
                    'type'          => 'vc_link',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Link', 'ihosting-core' ),
                    'param_name'    => 'link',
                    'dependency' => array(
    				    'element'   => 'show_banner_link',
    				    'value' => array( 'yes' )
    			   	),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Link Color', 'ihosting-core' ),
                    'param_name'    => 'link_color',
                    'std'           => '#000000',
                    'dependency' => array(
    				    'element'   => 'show_banner_link',
    				    'value' => array( 'yes' )
    			   	),
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

function no_banner( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_banner', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'style'             =>  'style-1',
        'img_id'            =>  0,
        'img_size'          =>  '593x384',
        'img_icon_id'       =>  0,
        'img_icon_size'     =>  '172x172',  
        'title'             =>  '',
        'title_color'       =>  '#000000',
        'sub_title'         =>  '',
        'sub_title_color'   =>  '#949494',
        'show_banner_link'  =>  'yes',
        'link'              =>  '',
        'link_color'        =>  '#000000',
        'css_animation'     =>  '',
        'animation_delay'   =>  '0.4',   //In second
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'ts-banner_wrap wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
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
    $show_banner_link = $show_banner_link == 'yes';
    
    $animation_delay = $animation_delay . 's';
    
    $html = '';
    $img_icon_html = '';
    $title_html = '';
    $sub_title_html = '';
    $link_html = '';
 
    // Banner image size (background)
    $img_size_x = 592;
    $img_size_y = 582;
    if ( trim( $img_size ) != '' ) {
        $img_size = explode( 'x', $img_size );
    }
    $img_size_x = isset( $img_size[0] ) ? max( 0, intval( $img_size[0] ) ) : $img_size_x;
    $img_size_y = isset( $img_size[1] ) ? max( 0, intval( $img_size[1] ) ) : $img_size_y;   
    
    // Banner icon size
    $img_icon_size_x = 592;
    $img_icon_size_y = 582;
    if ( trim( $img_icon_size ) != '' ) {
        $img_icon_size = explode( 'x', $img_icon_size );
    }
    $img_icon_size_x = isset( $img_icon_size[0] ) ? max( 0, intval( $img_icon_size[0] ) ) : $img_icon_size_x;
    $img_icon_size_y = isset( $img_icon_size[1] ) ? max( 0, intval( $img_icon_size[1] ) ) : $img_icon_size_y; 
    
    // Banner image (background)
    $img = array(
        'url'   =>  ihosting_no_image( array( 'width' => $img_size_x, 'height' => $img_size_y ), false, true )
    );
    
    if ( intval( $img_id ) > 0 ) {
        $img = ihosting_core_resize_image( $img_id, null, $img_size_x, $img_size_y, true, true, false );   
    }
    
    // banner icon image
    $img_icon = array(
        'url'   =>  ihosting_no_image( array( 'width' => $img_icon_size_x, 'height' => $img_icon_size_y ), false, true )
    );
    
    if ( intval( $img_icon_id ) > 0 ) {
        $img_icon = ihosting_core_resize_image( $img_icon_id, null, $img_icon_size_x, $img_icon_size_y, false, false, false );   
    }
    
    // Icon image html
    if ( intval( $img_icon_id ) > 0 && trim( $img_icon['url'] ) != '' ) {
        $img_icon_html = '<div class="banner-icon"><img width="' . esc_attr( $img_icon_size_x ) . '" height="' . esc_attr( $img_icon_size_y ) . '" src="' . esc_url( $img_icon['url'] ) . '" alt="' . esc_attr( $title ) . '" /></div>';
    }
    
    
    // Title html
    if ( trim( $title ) != '' ) {
        $title_html = '<h4 style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $title ) . '</h4>';
    }
    if ( trim( $sub_title ) != '' ) {
        $sub_title_html = '<span style="color: ' . esc_attr( $sub_title_color ) . ';" class="sub-title">' . sanitize_text_field( $sub_title ) . '</span>';
    }
    if ( $show_banner_link && trim( $link['url'] ) != '' ) {
        $link_html = '<a style="color: ' . esc_attr( $link_color ) . ';" href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . sanitize_text_field( $link['title'] ) . '" class="banner-link">' . sanitize_text_field( $link['title'] ) . '<span class="icon icon-arrows-slim-right"></span></a>';
    }
    
    
    $html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				<div class="ts-banner banner-' . esc_attr( $style ) . '">
					<div class="bg-banner" style="background-image: url(\'' . esc_url( $img['url'] ) . '\')"></div>
					<div class="banner-text">
                        ' . $img_icon_html . '
						' . $title_html . '
						' . $sub_title_html . '
						' . $link_html . '
					</div><!-- /.banner-text -->
				</div><!-- /.ts-banner -->
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_banner', 'no_banner' );
