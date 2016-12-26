<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'vc_before_init', 'lkBannerText2' );
function lkBannerText2()
{
    $allowed_tags = array(
        'em'     => array(),
        'i'      => array(),
        'b'      => array(),
        'strong' => array(),
        'a'      => array(
            'href'   => array(),
            'target' => array(),
            'class'  => array(),
            'id'     => array(),
            'title'  => array(),
        ),
    );

    global $kt_vc_anim_effects_in;
    vc_map(
        array(
            'name'     => esc_html__( 'LK Banner Text 2', 'ihosting-core' ),
            'base'     => 'lk_banner_text_2', // shortcode
            'class'    => '',
            'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
            'params'   => array(
                array(
                    'type'       => 'dropdown',
                    'class'      => '',
                    'heading'    => esc_html__( 'Style', 'ihosting-core' ),
                    'param_name' => 'style',
                    'value'      => array(
                        esc_html__( 'Style 1 (Text Top)', 'ihosting-core' )    => 'text-top',
                        esc_html__( 'Style 2 (Text Bottom)', 'ihosting-core' ) => 'text-bottom',
                        esc_html__( 'Style 3 (Text Left)', 'ihosting-core' )   => 'text-left',
                        esc_html__( 'Style 4 (Text Right)', 'ihosting-core' )  => 'text-right',
                        esc_html__( 'Style 5 (Text Middle)', 'ihosting-core' ) => 'text-mid',
                    ),
                    'std'        => 'text-right',
                ),
                array(
                    'type'        => 'attach_image',
                    'holder'      => 'div',
                    'class'       => '',
                    'heading'     => esc_html__( 'Image', 'ihosting-core' ),
                    'param_name'  => 'img_id',
                    'description' => esc_html__( 'Choose banner image', 'ihosting-core' ),
                ),
                array(
                    'type'        => 'textfield',
                    'holder'      => 'div',
                    'class'       => '',
                    'heading'     => esc_html__( 'Image Size', 'ihosting-core' ),
                    'param_name'  => 'img_size',
                    'std'         => '780x328',
                    'description' => wp_kses( esc_html__( '<em>{width}x{height}</em>. Example: <em>780x328, 390x595</em>, etc...', 'ihosting-core' ), $allowed_tags ),
                ),
                array(
                    'type'       => 'textfield',
                    'holder'     => 'div',
                    'class'      => '',
                    'heading'    => esc_html__( 'Title', 'ihosting-core' ),
                    'param_name' => 'title',
                    'std'        => esc_html__( 'Banner title', 'ihosting-core' ),
                ),
                array(
                    'type'       => 'colorpicker',
                    'holder'     => 'div',
                    'class'      => '',
                    'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
                    'param_name' => 'title_color',
                    'std'        => '#555',
                ),
                array(
                    'type'       => 'textfield',
                    'holder'     => 'div',
                    'class'      => '',
                    'heading'    => esc_html__( 'Sub Title', 'ihosting-core' ),
                    'param_name' => 'sub_title',
                    'std'        => esc_html__( 'Banner sub title', 'ihosting-core' ),
                ),
                array(
                    'type'       => 'colorpicker',
                    'holder'     => 'div',
                    'class'      => '',
                    'heading'    => esc_html__( 'Sub Title Color', 'ihosting-core' ),
                    'param_name' => 'sub_title_color',
                    'std'        => '#888',
                ),
                array(
                    'type'       => 'textfield',
                    'holder'     => 'div',
                    'class'      => '',
                    'heading'    => esc_html__( 'Flash Text', 'ihosting-core' ),
                    'param_name' => 'flash_text',
                    'std'        => esc_html__( 'HOT', 'ihosting-core' ),
                ),
                array(
                    'type'       => 'colorpicker',
                    'holder'     => 'div',
                    'class'      => '',
                    'heading'    => esc_html__( 'Flash Text Color', 'ihosting-core' ),
                    'param_name' => 'flash_text_color',
                    'std'        => '#fff',
                ),
                array(
                    'type'       => 'colorpicker',
                    'holder'     => 'div',
                    'class'      => '',
                    'heading'    => esc_html__( 'Flash Text Background Color', 'ihosting-core' ),
                    'param_name' => 'flash_text_bg_color',
                    'std'        => '#ff9081',
                ),
                array(
                    'type'       => 'dropdown',
                    'class'      => '',
                    'heading'    => esc_html__( 'Flash Text Position', 'ihosting-core' ),
                    'param_name' => 'flash_text_pos',
                    'value'      => array(
                        esc_html__( 'Top', 'ihosting-core' )    => 'top',
                        esc_html__( 'Bottom', 'ihosting-core' ) => 'bottom',
                    ),
                    'std'        => 'top',
                ),
                array(
                    'type'       => 'vc_link',
                    'holder'     => 'div',
                    'class'      => '',
                    'heading'    => esc_html__( 'Link', 'ihosting-core' ),
                    'param_name' => 'link',
                ),
                array(
                    'type'       => 'dropdown',
                    'class'      => '',
                    'heading'    => esc_html__( 'Enable Text Hover Effect', 'ihosting-core' ),
                    'param_name' => 'enable_text_hover_effect',
                    'value'      => array(
                        esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
                        esc_html__( 'No', 'ihosting-core' )  => 'no',
                    ),
                    'std'        => 'yes',
                ),
                array(
                    'type'       => 'dropdown',
                    'holder'     => 'div',
                    'class'      => '',
                    'heading'    => esc_html__( 'CSS Animation', 'ihosting-core' ),
                    'param_name' => 'css_animation',
                    'value'      => $kt_vc_anim_effects_in,
                    'std'        => 'fadeInUp',
                ),
                array(
                    'type'        => 'textfield',
                    'holder'      => 'div',
                    'class'       => '',
                    'heading'     => esc_html__( 'Animation Delay', 'ihosting-core' ),
                    'param_name'  => 'animation_delay',
                    'std'         => '0.4',
                    'description' => esc_html__( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency'  => array(
                        'element'   => 'css_animation',
                        'not_empty' => true,
                    ),
                ),
                array(
                    'type'       => 'css_editor',
                    'heading'    => esc_html__( 'Css', 'ihosting-core' ),
                    'param_name' => 'css',
                    'group'      => esc_html__( 'Design options', 'ihosting-core' ),
                ),
            ),
        )
    );
}

function lk_banner_text_2( $atts )
{

    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_banner_text_2', $atts ) : $atts;

    extract(
        shortcode_atts(
            array(
                'style'                    => 'text-right',
                'img_id'                   => 0,
                'img_size'                 => '780x328',
                'title'                    => '',
                'title_color'              => '#555',
                'sub_title'                => '',
                'sub_title_color'          => '#888',
                'flash_text'               => '',
                'flash_text_color'         => '#fff',
                'flash_text_bg_color'      => '#ff9081',
                'flash_text_pos'           => 'top',
                'link'                     => '',
                'enable_text_hover_effect' => 'yes',
                'css_animation'            => '',
                'animation_delay'          => '0.4',   //In second
                'css'                      => '',
            ), $atts
        )
    );

    $css_class = 'banner-text-2-wrap wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;

    $link_default = array(
        'url'    => '',
        'title'  => '',
        'target' => '',
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
    $banner_bg_html = '';
    $before_content_html = ''; // For top flash text
    $title_html = '';
    $sub_title_html = '';
    $flash_text_html = '';
    $after_content_html = ''; // For bottom flash text

    // Banner image size (background)
    $img_size_x = 780;
    $img_size_y = 328;
    if ( trim( $img_size ) != '' ) {
        $img_size = explode( 'x', $img_size );
    }
    $img_size_x = isset( $img_size[ 0 ] ) ? max( 0, intval( $img_size[ 0 ] ) ) : $img_size_x;
    $img_size_y = isset( $img_size[ 1 ] ) ? max( 0, intval( $img_size[ 1 ] ) ) : $img_size_y;

    // Banner image (background)
    $img = array(
        'url'    => ihosting_core_no_image( array( 'width' => $img_size_x, 'height' => $img_size_y ), false, true ),
        'width'  => $img_size_x,
        'height' => $img_size_y,
    );

    if ( intval( $img_id ) > 0 ) {
        $img = ihosting_core_resize_image( $img_id, null, $img_size_x, $img_size_y, true, true, false );
    }

    $banner_bg_html .= '<div class="bg-banner" style="background-image: url(\'' . esc_url( $img[ 'url' ] ) . '\'); min-height: ' . esc_attr( $img[ 'height' ] ) . 'px;"></div>';


    // Title html
    if ( trim( $title ) != '' ) {
        $title_html = '<h4 style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $title ) . '</h4>';
    }
    if ( trim( $sub_title ) != '' ) {
        $sub_title_html = '<span style="color: ' . esc_attr( $sub_title_color ) . ';" class="sub-title">' . sanitize_text_field( $sub_title ) . '</span>';
    }

    if ( trim( $link[ 'url' ] ) != '' ) {
        $banner_bg_html = '<a class="bg-banner" href="' . esc_attr( $link[ 'url' ] ) . '" target="' . esc_attr( $link[ 'target' ] ) . '" title="' . sanitize_text_field( $link[ 'title' ] ) . '" style="background-image: url(\'' . esc_url( $img[ 'url' ] ) . '\'); min-height: ' . esc_attr( $img[ 'height' ] ) . 'px;"><span class="screen-reader-text">' . sanitize_text_field( $link[ 'title' ] ) . '</span></a>';
    }

    if ( trim( $flash_text ) != '' ) {
        $flash_text_style = 'color: ' . esc_attr( $flash_text_color ) . '; background-color: ' . esc_attr( $flash_text_bg_color ) . '; ';
        $flash_text_html .= '<span class="flash-text" style="' . $flash_text_style . '">' . sanitize_text_field( $flash_text ) . '</span>';
        if ( $flash_text_pos == 'top' ) {
            $before_content_html .= $flash_text_html;
        }
        else {
            $after_content_html .= $flash_text_html;
        }
    }

    $banner_class = 'kt-banner-2 block-banner-text-2 style-' . esc_attr( $style ) . ' hover-effect-crossing';
    if ( $enable_text_hover_effect == 'yes' ) { 
        $banner_class .= ' has-text-hover-effect';
    }

    $html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				<div class="' . esc_attr( $banner_class ) . '">
					' . $banner_bg_html . '
					<div class="banner-text">
					    ' . $before_content_html . '
					    ' . $title_html . '
					    ' . $sub_title_html . '
					    ' . $after_content_html . '
					</div><!-- /.banner-text -->
				</div><!-- /.kt-banner-2 -->
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

    return balanceTags( $html );

}

add_shortcode( 'lk_banner_text_2', 'lk_banner_text_2' );
