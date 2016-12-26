<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noCustomMenu' );
function noCustomMenu() {
    global $kt_vc_anim_effects_in;
    
    $custom_menus = array();
    $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
    if ( is_array( $menus ) && ! empty( $menus ) ) {
    	foreach ( $menus as $single_menu ) {
    		if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
    			$custom_menus[ $single_menu->name ] = $single_menu->slug;
    		}
    	}
    }
    
    vc_map( 
        array(
            'name'        => __( 'N Custom Menu', 'ihosting-core' ),
            'base'        => 'no_custom_nav_menu', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                ),
                array(
        			'type' => 'dropdown',
        			'heading' => __( 'Menu', 'ihosting-core' ),
        			'param_name' => 'nav_menu', // slug 
        			'value' => $custom_menus,
        			'description' => empty( $custom_menus ) ? __( 'Custom menus not found. Please visit <b>Appearance > Menus</b> page to create new menu.', 'ihosting-core' ) : __( 'Select menu to display.', 'ihosting-core' ),
        			'admin_label' => true,
        			'save_always' => true,
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

function no_custom_nav_menu( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_custom_nav_menu', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'title'             =>  '',
        'nav_menu'          =>  '', // slug
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'ts-custom-menu-wrap';
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    $html = '';
    
    $type = 'WP_Nav_Menu_Widget';
    $args = array();
    global $wp_widget_factory;
    
    $menu = get_term_by( 'slug', $nav_menu, 'nav_menu' );
    
    if ( $menu ) {
        $atts['nav_menu'] = $menu->term_id;
        
        // to avoid unwanted warnings let's check before using widget
        if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
            
            $html .= '<div class="vc_wp_custommenu wpb_content_element ts-custom-menu">';
            
            ob_start();
        	the_widget( $type, $atts, $args );
        	$html .= ob_get_clean();
            
            $html .= '</div><!-- /.ts-custom-menu -->';
        }
        
    }
    
    $html = '<div class="' . esc_attr( $css_class ) . '">' . $html  . '</div><!-- /' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_custom_nav_menu', 'no_custom_nav_menu' );
