<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noTitleDesc' );
function noTitleDesc() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Title With Short Description', 'ihosting-core' ),
            'base'        => 'no_title_desc', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'Blog &amp; Ideas', 'ihosting-core' ),
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
                    'std'           => __( 'Discover even more...', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Icon Type', 'ihosting-core' ),
                    'param_name'    => 'icon_type',
                    'value' => array(
                        __( 'Font Icon', 'ihosting-core' ) => 'font_icon',
                        __( 'Image', 'ihosting-core' ) => 'image'		    
                    ),
                    'std'           => 'font_icon'
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
    				    'element'   => 'icon_type',
    				    'value' => array( 'font_icon' )
    			   	),
                ),
                array(
                    'type'          => 'attach_image',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Image Icon', 'ihosting-core' ),
                    'param_name'    => 'img_icon_id',
                    'dependency' => array(
    				    'element'   => 'icon_type',
    				    'value' => array( 'image' )
    			   	),
                    'description'   => __( 'Choose an image as icon', 'ihosting-core' )
                ),
                array(
                    'type'          => 'attach_image',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Image', 'ihosting-core' ),
                    'param_name'    => 'img_id',
                    'description'   => __( 'Choose an image as background', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Image Size', 'ihosting-core' ),
                    'param_name'    => 'img_size',
                    'std'           => '592x382',
                    'description'   => __( '<em>{width}x{height}</em>. Example: <em>592x382</em>, <em>920x382</em>, etc... Image size also is output width:height ratio', 'ihosting-core' )
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
                        __( 'Center', 'ihosting-core' ) => 'center'		    
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
                    'dependency' => array(
    				    'element'   => 'icon_type',
    				    'value' => array( 'font_icon' )
    			   	),
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
                    'std'           => '#949494',
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

function no_title_desc( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_title_desc', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'title'             =>  '',
        'link'              =>  '',
        'short_desc'        =>  '',
        'icon_type'         =>  'font_icon',
        'icon'              =>  '',
        'img_icon_id'       =>  0,
        'img_id'            =>  0,
        'img_size'          =>  '592x382', // {width}x{height}
        'text_align'        =>  'left',
        'icon_color'        =>  '#000000',
        'title_color'       =>  '#000000',
        'short_desc_color'  =>  '#949494',
        'css_animation'     =>  '',
        'animation_delay'   =>  '0.4',   //In second
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'section-title-desc ts-feature wow ' . $css_animation . ' text-' . $text_align;
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
    $animation_delay = $animation_delay . 's';
    
    $html = '';
    $icon_html = '';
    if ( trim( $icon_type ) == 'font_icon' ) {
        if ( trim( $icon ) != '' ) {
            $icon_style = trim( $icon_color ) != '' ? 'style="color: ' . esc_attr( $icon_color ) . ';"' : '';
            $icon_html = '<span ' . $icon_style . ' class="icon ' . esc_attr( $icon ) . '"></span>';   
        }
    }
    else{
        $img_icon = ihosting_core_resize_image( $img_icon_id, null, 81, 81, true, false, false ); 
        if ( trim( $img_icon['url'] ) != '' ) {
            $icon_html = '<span class="image-icon"><img width="' . esc_attr( $img_icon['width'] ) . '" height="' . esc_attr( $img_icon['height'] ) . '" src="' . esc_url( $img_icon['url'] ) . '" alt="' . esc_attr( get_post_meta( $img_icon_id, '_wp_attachment_image_alt', true ) ) . '"></span>';
        }
    }
    
    $title_html = '';
    $title_style = trim( $title_color ) != '' ? 'style="color: ' . esc_attr( $title_color ) . ';"' : '';
    if ( trim( $link['url'] ) != '' ) {
        $title_html = '<h4 ' . $title_style . '><a href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '">' . sanitize_text_field( $title ) . '</a></h4>';
    }
    else{
        $title_html = '<h4 ' . $title_style . ' >' . sanitize_text_field( $title ) . '</h4>';
    }
    
    $desc_style = trim( $short_desc_color ) != '' ? 'style="color: ' . esc_attr( $short_desc_color ) . ';"' : '';
    $desc_html = trim( $short_desc ) != '' ? '<p ' . $desc_style . '>' . sanitize_text_field( $short_desc ) . '</p>' : '';
    
    $img_size_x = 592;
    $img_size_y = 582;
    if ( trim( $img_size ) != '' ) {
        $img_size = explode( 'x', $img_size );
    }
    $img_size_x = isset( $img_size[0] ) ? max( 0, intval( $img_size[0] ) ) : $img_size_x;
    $img_size_y = isset( $img_size[1] ) ? max( 0, intval( $img_size[1] ) ) : $img_size_y;
    
    if ( intval( $img_id ) > 0 ) {
        $img = ihosting_core_resize_image( $img_id, null, $img_size_x, $img_size_y, true, true, false, 'fff' );   
    }
    else{
        $img = array(
            'url' =>  ihosting_no_image( array( 'width' => $img_size_x, 'height' => $img_size_y ), false, true ),
            'width' => $img_size_x,
            'height' => $img_size_y
        );
    }
    
    $html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				<figure><img width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ) . '"></figure>
				<div class="info-feature">
					' . $icon_html . '
					' . $title_html . '
					' . $desc_html . '
				</div><!-- /.info-feature -->
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_title_desc', 'no_title_desc' );
