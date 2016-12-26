<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkImgsGrid' );
function lkImgsGrid() {
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
			'name'     => esc_html__( 'LK Images Grid', 'ihosting-core' ),
			'base'     => 'lk_imgs_grid', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'attach_images',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Images', 'ihosting-core' ),
					'param_name'  => 'img_ids',
					'description' => esc_html__( 'Choose images for the grid', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Items Per Row', 'ihosting-core' ),
					'value'       => 4,
					'save_always' => true,
					'param_name'  => 'items_per_row',
					'description' => esc_html__( 'How many categories per row on the large screen? Min = 1, max = 4.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Items Height', 'ihosting-core' ),
					'value'       => 170,
					'save_always' => true,
					'param_name'  => 'items_height',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Image Size', 'ihosting-core' ),
					'param_name'  => 'img_size',
					'std'         => '300x185',
					'description' => wp_kses( esc_html__( '<em>{width}x{height}</em>. Example: <em>300x185</em>, etc...', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Overlay Color', 'ihosting-core' ),
					'param_name' => 'overlay_color',
					'std'        => '',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Enable Hover Effect (Hoverdir)', 'ihosting-core' ),
					'param_name' => 'enable_hover_effect',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no',
					),
					'std'        => 'yes',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Hover Effect Color', 'ihosting-core' ),
					'param_name' => 'hover_effect_color',
					'std'        => 'rgba(238, 193, 1, 0.3)',
					'dependency' => array(
						'element' => 'enable_hover_effect',
						'value'   => array( 'yes' ),
					),
				),
				array(
					'type'        => 'exploded_textarea_safe',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Images Links', 'ihosting-core' ),
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

function lk_imgs_grid( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_imgs_grid', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'img_ids'             => '',
				'items_per_row'       => 4,
				'items_height'        => 170,
				'img_size'            => '300x185',
				'overlay_color'       => '',
				'enable_hover_effect' => 'yes',
				'hover_effect_color'  => 'rgba(238, 193, 1, 0.3)',
				'image_links'         => '',
				'link_target'         => '_self',
				'css_animation'       => '',
				'animation_delay'     => '0.4',   //In second
				'css'                 => '',
			), $atts
		)
	);

	$css_class = 'kt-imgs-grid-wrap ' . $css_animation;
	if ( $css_animation != '' ) {
		$css_class .= ' wow';
	}
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

	// Image size (background)
	$img_size_x = 300;
	$img_size_y = 185;
	if ( trim( $img_size ) != '' ) {
		$img_size = explode( 'x', $img_size );
	}
	$img_size_x = isset( $img_size[0] ) ? max( 0, intval( $img_size[0] ) ) : $img_size_x;
	$img_size_y = isset( $img_size[1] ) ? max( 0, intval( $img_size[1] ) ) : $img_size_y;

	$html = '';
	$imgs_html = '';
	$overlay_html = '';
	$hover_eff_bg_html = '';

	if ( trim( $image_links ) != '' && function_exists( 'vc_value_from_safe' ) ) {
		$image_links = vc_value_from_safe( $image_links );
		$image_links = array_filter( explode( ',', $image_links ) );
	}

	if ( trim( $overlay_color ) != '' ) {
		$overlay_html = '<div class="overlay" style="background-color: ' . esc_attr( $overlay_color ) . ';"></div>';
	}

	$items_per_row = min( 4, max( 1, intval( $items_per_row ) ) );
	$item_class = 'col-sm-6 col-md-3 padding-05';
	switch ( $items_per_row ) {
		case 4:
			$item_class = 'col-sm-6 col-md-3 padding-05';
			break;
		case 3:
			$item_class = 'col-sm-6 col-md-4 padding-05';
			break;
		case 2:
			$item_class = 'col-sm-6 padding-05';
			break;
		case 1:
			$item_class = 'col-sm-12 padding-05';
			break;
	}

	$items_height = intval( $items_height );

	$i = 0;
	foreach ( $img_ids as $img_id ) {
		$img = ihosting_core_resize_image( $img_id, null, $img_size_x, $img_size_y, true, true, false );
		$img_style = 'style="background-image: url(' . esc_url( $img['url'] ) . '); height:' . $items_height . 'px; min-height: ' . $items_height . 'px;"';
		$hover_dir_class = '';
		if ( $enable_hover_effect == 'yes' ) {
			$hover_dir_class .= 'kt-hover-dir';
		}
		if ( isset( $image_links[$i] ) ) {
			if ( $enable_hover_effect == 'yes' ) {
				$hover_eff_bg_html = '<a href="' . esc_attr( $image_links[$i] ) . '" target="' . esc_attr( $link_target ) . '" class="background hover-effect-bg" style="background-color: ' . esc_attr( $hover_effect_color ) . ';"></a>';
			}
			$imgs_html .= '<div class="' . esc_attr( $item_class ) . '">
								<div class="img-item ' . esc_attr( $hover_dir_class ) . '">
									<a class="bg-image" href="' . esc_attr( $image_links[$i] ) . '" target="' . esc_attr( $link_target ) . '" ' . $img_style . '>
										<span class="screen-reader-text">' . esc_html( basename( $img['url'] ) ) . '</span>
									</a>
									' . $overlay_html . '
									' . $hover_eff_bg_html . '
								</div><!-- /.img-item -->
							</div>';
		}
		else {
			if ( $enable_hover_effect == 'yes' ) {
				$hover_eff_bg_html = '<div class="background hover-effect-bg" style="background-color: ' . esc_attr( $hover_effect_color ) . ';"></div>';
			}
			$imgs_html .= '<div class="' . esc_attr( $item_class ) . '">
								<div class="img-item ' . esc_attr( $hover_dir_class ) . '">
									<a class="bg-image click-return-false" href="#" target="' . esc_attr( $link_target ) . '" ' . $img_style . '>
										<span class="screen-reader-text">' . esc_html( basename( $img['url'] ) ) . '</span>
									</a>
									' . $overlay_html . '
									' . $hover_eff_bg_html . '
								</div><!-- /.img-item -->
							</div>';
		}
		$i++;
	}

	if ( trim( $imgs_html ) != '' ) {
		$imgs_html = '<div class="row margin-0">
                            ' . $imgs_html . '
                        </div>';
	}


	$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                ' . $imgs_html . '
            </div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;


	$autoplay = count( $img_ids ) > 1 ? 'yes' : 'no';
	$loop = count( $img_ids ) > 1 ? 'yes' : 'no';
	$slider_speed = max( 100, intval( $slider_speed ) );
	$grid_attrs = 'data-number="' . esc_attr( $items_per_slide ) . '" data-loop="' . esc_attr( $loop ) . '" data-navControl="yes" data-Dots="no" data-autoPlay="' . $autoplay . '" data-autoPlayTimeout="' . esc_attr( $slider_speed ) . '" data-margin="16" data-rtl="no"';

	$grid_html = '<div class="lk-imgs-grid ihosting-owl-grid nav-center nav-style-2" ' . $grid_attrs . '>
						' . $grid_html . '
					</div>';

	$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				' . $grid_html . '
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'lk_imgs_grid', 'lk_imgs_grid' );
