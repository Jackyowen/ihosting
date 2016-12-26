<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'ihImgsCarousel' );
function ihImgsCarousel() {
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
			'name'     => esc_html__( 'IH Images Carousel', 'ihosting-core' ),
			'base'     => 'ih_imgs_carousel', // shortcode
			'class'    => '',
			'category' => esc_html__( 'iHosting', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'attach_images',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Images', 'ihosting-core' ),
					'param_name'  => 'img_ids',
					'description' => esc_html__( 'Choose images for the carousel', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Image Size', 'ihosting-core' ),
					'param_name'  => 'img_size',
					'std'         => '205x92',
					'description' => wp_kses( esc_html__( '<em>{width}x{height}</em>. Example: <em>205x92, 390x214</em>, etc...', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Slider Speed', 'ihosting-core' ),
					'param_name'  => 'slider_speed',
					'std'         => '4000',
					'description' => esc_html__( 'Duration of animation between slides (in ms). Min = 100', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Items Per Slide', 'ihosting-core' ),
					'param_name'  => 'items_per_slide',
					'std'         => '5',
					'description' => esc_html__( 'Enter number of slides to display at the same time on large screen. Min = 1, max = 12', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Space Between Items', 'ihosting-core' ),
					'param_name'  => 'space_between_items',
					'std'         => '30',
					'description' => esc_html__( 'Enter number for space between items. Unit is pixel. Default: 30.', 'ihosting-core' ),
				),
				array(
					'type'        => 'exploded_textarea_safe',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Custom Links', 'ihosting-core' ),
					'param_name'  => 'image_links',
					'description' => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter))', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Link Target', 'ihosting-core' ),
					'param_name' => 'link_target',
					'value'      => array(
						esc_html__( 'Same window', 'ihosting-core' ) => '_self',
						esc_html__( 'New tab', 'ihosting-core' )     => '_blank',
					),
					'std'        => '_self',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Hover Effect', 'ihosting-core' ),
					'param_name' => 'hover_effect',
					'value'      => array(
						esc_html__( ' --- No Effect ---', 'ihosting-core' )                  => '',
						esc_html__( 'Diagonally', 'ihosting-core' )                          => 'hover-effect-diagonally',
						esc_html__( 'Crossing', 'ihosting-core' )                            => 'hover-effect-crossing',
						esc_html__( 'Plus', 'ihosting-core' )                                => 'hover-plus-effect',
						esc_html__( 'Dark Change To Light From RTL', 'ihosting-core' )       => 'hover-overlay-dark-to-light-rtl',
						esc_html__( 'Hover Zoom Scale Bigger Opacity 0.5', 'ihosting-core' ) => 'hover-zoom-scale-opacity-05',
					),
					'std'        => 'hover-effect-diagonally',
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

function ih_imgs_carousel( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ih_imgs_carousel', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'img_ids'             => '',
				'img_size'            => '205x92',
				'slider_speed'        => 4000,
				'items_per_slide'     => 5,
				'space_between_items' => 30,
				'image_links'         => '',
				'link_target'         => '_self',
				'hover_effect'        => '',
				'css_animation'       => '',
				'animation_delay'     => '0.4',   //In second
				'css'                 => '',
			), $atts
		)
	);

	$css_class = 'ih-imgs-carousel-wrap imgs-carousel-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}

	$animation_delay = $animation_delay . 's';

	if ( trim( $img_ids ) == '' ) {
		return '';
	}

	$img_ids = array_filter( explode( ',', $img_ids ) );

	if ( empty( $img_ids ) ) {
		return '';
	}

	$html = '';
	$carousel_html = '';

	if ( trim( $image_links ) != '' && function_exists( 'vc_value_from_safe' ) ) {
		$image_links = vc_value_from_safe( $image_links );
		$image_links = array_filter( explode( ',', $image_links ) );
	}

	// Image size (background)
	$img_size_x = 205;
	$img_size_y = 92;
	if ( trim( $img_size ) != '' ) {
		$img_size = explode( 'x', $img_size );
	}
	$img_size_x = isset( $img_size[0] ) ? max( 0, intval( $img_size[0] ) ) : $img_size_x;
	$img_size_y = isset( $img_size[1] ) ? max( 0, intval( $img_size[1] ) ) : $img_size_y;

	$i = 0;
	foreach ( $img_ids as $img_id ) {
		$img = ihosting_core_resize_image( $img_id, null, $img_size_x, $img_size_y, true, true, false );
		if ( isset( $image_links[$i] ) ) {
			$carousel_html .= '<div class="img-wrap">
								<a class="' . esc_attr( $hover_effect ) . '" href="' . esc_attr( $image_links[$i] ) . '" target="' . esc_attr( $link_target ) . '">
									<img width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" src="' . esc_url( $img['url'] ) . '" alt="' . ihosting_core_get_img_alt( $img_id ) . '" />
								</a>
							</div>';
		}
		else {
			$carousel_html .= '<div class="img-wrap">
								<a href="#" class="click-return-false ' . esc_attr( $hover_effect ) . '">
									<img width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" src="' . esc_url( $img['url'] ) . '" alt="' . ihosting_core_get_img_alt( $img_id ) . '" />
								</a>
							</div>';
		}
		$i++;
	}

	$autoplay = count( $img_ids ) > 1 ? 'yes' : 'no';
	$loop = count( $img_ids ) > 1 ? 'yes' : 'no';
	$slider_speed = max( 100, intval( $slider_speed ) );
	$space_between_items = str_replace( 'px', '', $space_between_items );
	$carousel_attrs = 'data-number="' . esc_attr( $items_per_slide ) . '" data-loop="' . esc_attr( $loop ) . '" data-navControl="yes" data-Dots="no" data-autoPlay="' . $autoplay . '" data-autoPlayTimeout="' . esc_attr( $slider_speed ) . '" data-margin="' . intval( $space_between_items ) . '" data-rtl="no"';

	$carousel_html = '<div class="ih-imgs-carousel ihosting-owl-carousel nav-center nav-style-2" ' . $carousel_attrs . '>
						' . $carousel_html . '
					</div>';

	$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				' . $carousel_html . '
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'ih_imgs_carousel', 'ih_imgs_carousel' );
