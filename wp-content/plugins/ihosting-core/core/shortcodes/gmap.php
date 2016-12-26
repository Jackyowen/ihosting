<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'lkGmap' );
function lkGmap() {
	global $kt_vc_anim_effects_in;
	$allowed_tags = array(
		'em'     => array(),
		'i'      => array(),
		'b'      => array(),
		'strong' => array(),
		'br'     => array(),
		'a'      => array(
			'href'   => array(),
			'target' => array(),
			'class'  => array(),
			'id'     => array(),
			'title'  => array(),
		),
	);
	vc_map(
		array(
			'name'     => esc_html__( 'LK Google Map', 'ihosting-core' ),
			'base'     => 'lk_gmap', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Map Type', 'ihosting-core' ),
					'param_name'  => 'map_type',
					'value'       => array(
						esc_html__( 'ROADMAP', 'ihosting-core' )   => 'ROADMAP',
						esc_html__( 'SATELLITE', 'ihosting-core' ) => 'SATELLITE',
						esc_html__( 'HYBRID', 'ihosting-core' )    => 'HYBRID',
						esc_html__( 'TERRAIN', 'ihosting-core' )   => 'TERRAIN',
					),
					'std'         => 'ROADMAP',
					'description' => esc_html__( 'ROADMAP displays the default road map view. SATELLITE displays Google Earth satellite images. HYBRID displays a mixture of normal and satellite views. TERRAIN displays a physical map based on terrain information.', 'ihosting-core' ),
				),
				array(
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Hue', 'ihosting-core' ),
					'param_name'  => 'hue',
					'description' => esc_html__( 'An RGB hex string. indicates the basic color.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Lightness', 'ihosting-core' ),
					'param_name'  => 'lightness',
					'std'         => '1',
					'description' => esc_html__( 'A floating point value between -100 and 100. Indicates the percentage change in brightness of the element.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Saturation', 'ihosting-core' ),
					'param_name'  => 'saturation',
					'std'         => '-100',
					'description' => esc_html__( 'A floating point value between -100 and 100. Indicates the percentage change in intensity of the basic color to apply to the element.', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Address', 'ihosting-core' ),
					'param_name' => 'address',
					'std'        => '',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Infomation Title', 'ihosting-core' ),
					'param_name'  => 'info_title',
					'std'         => '',
					'description' => esc_html__( 'Title of infomation box will show when click on pin icon.', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Phone', 'ihosting-core' ),
					'param_name' => 'phone',
					'std'        => '',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Email', 'ihosting-core' ),
					'param_name' => 'email',
					'std'        => '',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Website', 'ihosting-core' ),
					'param_name' => 'website',
					'std'        => '',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Latitude', 'ihosting-core' ),
					'param_name'  => 'latitude',
					'std'         => '21.028554',
					'description' => wp_kses( __( '1. Open <a href="https://www.google.com/maps" target="_blank">Google Maps</a><br />2. Right-click the place or area on the map.<br />3. Select <b>What\'s here</b>?<br />4. Under the search box, an info card with coordinates will appear.', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Longitude', 'ihosting-core' ),
					'param_name'  => 'longitude',
					'std'         => '105.851127',
					'description' => wp_kses( __( '1. Open <a href="https://www.google.com/maps" target="_blank">Google Maps</a><br />2. Right-click the place or area on the map.<br />3. Select <b>What\'s here</b>?<br />4. Under the search box, an info card with coordinates will appear.', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'        => 'attach_image',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Pin Icon', 'ihosting-core' ),
					'param_name'  => 'pin_icon',
					'std'         => '',
					'description' => esc_html__( 'If not choose, default pin icon will show.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Zoom', 'ihosting-core' ),
					'param_name'  => 'zoom',
					'std'         => '14',
					'description' => esc_html__( 'Most roadmap imagery is available from zoom levels 0 to 18.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Map Height', 'ihosting-core' ),
					'param_name'  => 'map_height',
					'std'         => '555',
					'description' => esc_html__( 'Map height unit is pixel.', 'ihosting-core' ),
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
			)
		)
	);
}

function lk_gmap( $atts ) {
	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_gmap', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'map_type'        => 'ROADMAP',
				'hue'             => '',
				'lightness'       => '',
				'saturation'      => '',
				'address'         => '',
				'info_title'      => '',
				'phone'           => '',
				'email'           => '',
				'website'         => '',
				'longitude'       => '',
				'latitude'        => '',
				'pin_icon'        => '',
				'zoom'            => '',
				'map_height'      => 555,
				'css_animation'   => '',
				'animation_delay' => '',
				'css'             => '',
			), $atts
		)
	);

	$css_class = 'kt-gmaps-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = '0';
	}
	$animation_delay = $animation_delay . 's';

	$html = '';

	$map_id = uniqid( 'google-map-' );

	$pin_icon = intval( $pin_icon );
	$pin_icon_url = IHOSTINGCORE_IMG_URL . '/marker.png';
	if ( $pin_icon > 0 ) {
		$pin_img = ihosting_core_resize_image( $pin_icon, null, 52, 58, false, false );
		$pin_icon_url = isset( $pin_img['url'] ) ? $pin_img['url'] : $pin_icon_url;

		if ( trim( $pin_icon_url ) == '' ) {
			$pin_icon_url = IHOSTINGCORE_IMG_URL . '/marker.png';
		}
	}

	$info_title = trim( $info_title ) != '' ? sanitize_text_field( $info_title ) : '';

	if ( !is_email( sanitize_email( $email ) ) ) {
		$email = '';
	}
	else {
		$email = sanitize_email( $email );
	}

	$website = trim( $website ) != '' ? esc_url( $website ) : '';

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                    <div id="' . esc_attr( $map_id ) . '" 
            			class="kt-gmaps" 
            			data-hue="' . esc_attr( $hue ) . '" 
            			data-lightness="' . intval( $lightness ) . '" 
            			data-saturation="' . intval( $saturation ) . '" 
            			data-modify-coloring="true" 
            			data-draggable="true" 
            			data-scale-control="true" 
            			data-map-type-control="true" 
            			data-zoom-control="true" 
            			data-pan-control="true" 
                        data-scrollwheel="true"
            			data-address="' . esc_attr( htmlentities2( $address ) ) . '" 
                        data-info_title="' . esc_attr( $info_title ) . '"
                        data-phone="' . esc_attr( sanitize_text_field( $phone ) ) . '"
                        data-email="' . esc_attr( $email ) . '"
                        data-website="' . $website . '"
            			data-longitude="' . esc_attr( $longitude ) . '" 
            			data-latitude="' . esc_attr( $latitude ) . '" 
            			data-pin-icon="' . esc_url( $pin_icon_url ) . '" 
            			data-zoom="' . esc_attr( $zoom ) . '" 
            			style="height: ' . intval( $map_height ) . 'px; width: 100%;" 
            			data-map-type="' . esc_attr( $map_type ) . '">
                    </div><!-- /.kt-gmaps -->
                </div><!-- /.kt-gmaps-wrap -->';

	return $html;

}

add_shortcode( 'lk_gmap', 'lk_gmap' );
