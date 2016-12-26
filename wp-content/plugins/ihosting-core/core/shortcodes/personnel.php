<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'ihPersonnel' );
function ihPersonnel() {
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
			'name'     => esc_html__( 'IH People/Personnel', 'ihosting-core' ),
			'base'     => 'ih_personnel', // shortcode
			'class'    => '',
			'category' => esc_html__( 'iHosting', 'ihosting-core' ),
			'params'   => array(
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
					'std'         => '220x256',
					'description' => wp_kses( esc_html__( '<em>{width}x{height}</em>. Example: <em>220x256</em>, etc...', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Name', 'ihosting-core' ),
					'param_name' => 'title', // Name
					'std'        => esc_html__( 'Steven Coldin', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Position', 'ihosting-core' ),
					'param_name' => 'subtitle', // Name
					'std'        => esc_html__( 'Co-Founder', 'ihosting-core' ),
				),
				array(
					'type'       => 'textarea',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description', 'ihosting-core' ),
					'param_name' => 'desc', // Name
					'std'        => esc_html__( 'Nullam odio lorem, mattis eget tristique eu, cursus sit amet mi. Duis eget lacus vel mauris tincidunt lobortis sed vel est...', 'ihosting-core' ),
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
					'type'       => 'dropdown',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Social Links Target', 'ihosting-core' ),
					'param_name' => 'social_link_targets',
					'value'      => array(
						esc_html__( 'Open in new tab', '_blank' ),
						esc_html__( 'Open in current window', '_self' ),
					),
					'std'        => '_blank',
					'group'      => esc_html__( 'Social Links', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Facebook Link', 'ihosting-core' ),
					'param_name' => 'fb_link',
					'std'        => 'https://facebook.com/',
					'group'      => esc_html__( 'Social Links', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Twitter Link', 'ihosting-core' ),
					'param_name' => 'tw_link',
					'std'        => 'https://twitter.com/',
					'group'      => esc_html__( 'Social Links', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Linkedin Link', 'ihosting-core' ),
					'param_name' => 'linkedin_link',
					'std'        => 'https://www.linkedin.com/',
					'group'      => esc_html__( 'Social Links', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'G+ Link', 'ihosting-core' ),
					'param_name' => 'gplus_link',
					'std'        => '',
					'group'      => esc_html__( 'Social Links', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Instagram Link', 'ihosting-core' ),
					'param_name' => 'instagram_link',
					'std'        => '',
					'group'      => esc_html__( 'Social Links', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Behance Link', 'ihosting-core' ),
					'param_name' => 'behance_link',
					'std'        => '',
					'group'      => esc_html__( 'Social Links', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Youtube Link', 'ihosting-core' ),
					'param_name' => 'yt_link',
					'std'        => '',
					'group'      => esc_html__( 'Social Links', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Vimeo Link', 'ihosting-core' ),
					'param_name' => 'vimeo_link',
					'std'        => '',
					'group'      => esc_html__( 'Social Links', 'ihosting-core' ),
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

function ih_personnel( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ih_personnel', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'img_id'              => 0,
				'img_size'            => '1170x100',
				'title'               => '',
				'subtitle'            => '',
				'desc'                => '',
				'social_link_targets' => '_blank',
				'fb_link'             => '',
				'tw_link'             => '',
				'linkedin_link'       => '',
				'gplus_link'          => '',
				'instagram_link'      => '',
				'behance_link'        => '',
				'yt_link'             => '',
				'vimeo_link'          => '',
				'hover_effect'        => '',
				'css_animation'       => '',
				'animation_delay'     => '0.4',   //In second
				'css'                 => '',
			), $atts
		)
	);

	$css_class = 'lk-people-wrap';
	if ( $css_animation != '' ) {
		$css_class .= ' wow ' . $css_animation;
	}
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}

	$animation_delay = $animation_delay . 's';

	$html = '';
	$img_html = '';
	$title_html = '';
	$desc_html = '';
	$social_html = '';

	// Banner image size (background)
	$img_size_x = 220;
	$img_size_y = 256;
	if ( trim( $img_size ) != '' ) {
		$img_size = explode( 'x', $img_size );
	}
	$img_size_x = isset( $img_size[0] ) ? max( 0, intval( $img_size[0] ) ) : $img_size_x;
	$img_size_y = isset( $img_size[1] ) ? max( 0, intval( $img_size[1] ) ) : $img_size_y;

	$img = ihosting_resize_image( $img_id, null, $img_size_x, $img_size_y, true, true, false );

	$img_html .= '<div class="img-wrap"><img src="' . esc_url( $img['url'] ) . '" width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" alt="' . esc_attr( $title ) . '"></div>';

	if ( trim( $title ) != '' ) {
		$title_html .= '<h5 class="people-title">' . esc_html( $title ) . '</h5>';
	}
	if ( trim( $subtitle ) != '' ) {
		$title_html .= '<cite class="people-subtitle">' . esc_html( $subtitle ) . '</cite>';
	}

	if ( trim( $desc ) != '' ) {
		$desc_html .= '<p class="short-desc">' . sanitize_text_field( $desc ) . '</p>';
	}

	if ( $fb_link != '' ) {
		$social_html .= '<a class="ih-social-link fb-link facebook-link" href="' . esc_attr( $fb_link ) . '" target="' . esc_attr( $social_link_targets ) . '">
							<i class="fa fa-facebook"></i>
							<span class="screen-reader-text">' . sprintf( esc_html__( '%s Facebook link', 'ihosting-core' ), $title ) . '</span>
						</a>';
	}

	if ( $tw_link != '' ) {
		$social_html .= '<a class="ih-social-link tw-link twitter-link" href="' . esc_attr( $tw_link ) . '" target="' . esc_attr( $social_link_targets ) . '">
							<i class="fa fa-twitter"></i>
							<span class="screen-reader-text">' . sprintf( esc_html__( '%s Twitter link', 'ihosting-core' ), $title ) . '</span>
						</a>';
	}

	if ( $linkedin_link != '' ) {
		$social_html .= '<a class="ih-social-link linkedin-link" href="' . esc_attr( $linkedin_link ) . '" target="' . esc_attr( $social_link_targets ) . '">
							<i class="fa fa-linkedin"></i>
							<span class="screen-reader-text">' . sprintf( esc_html__( '%s Linkedin link', 'ihosting-core' ), $title ) . '</span>
						</a>';
	}

	if ( $gplus_link != '' ) {
		$social_html .= '<a class="ih-social-link gplus-link google-plus-link" href="' . esc_attr( $gplus_link ) . '" target="' . esc_attr( $social_link_targets ) . '">
							<i class="fa fa-google-plus"></i>
							<span class="screen-reader-text">' . sprintf( esc_html__( '%s Google plus link', 'ihosting-core' ), $title ) . '</span>
						</a>';
	}

	if ( $instagram_link != '' ) {
		$social_html .= '<a class="ih-social-link instagram-link" href="' . esc_attr( $instagram_link ) . '" target="' . esc_attr( $social_link_targets ) . '">
							<i class="fa fa-instagram"></i>
							<span class="screen-reader-text">' . sprintf( esc_html__( '%s Instagram link', 'ihosting-core' ), $title ) . '</span>
						</a>';
	}

	if ( $behance_link != '' ) {
		$social_html .= '<a class="ih-social-link behance-link" href="' . esc_attr( $behance_link ) . '" target="' . esc_attr( $social_link_targets ) . '">
							<i class="fa fa-behance"></i>
							<span class="screen-reader-text">' . sprintf( esc_html__( '%s Behance link', 'ihosting-core' ), $title ) . '</span>
						</a>';
	}

	if ( $yt_link != '' ) {
		$social_html .= '<a class="ih-social-link yt-link youtube-link" href="' . esc_attr( $yt_link ) . '" target="' . esc_attr( $social_link_targets ) . '">
							<i class="fa fa-youtube"></i>
							<span class="screen-reader-text">' . sprintf( esc_html__( '%s Youtube link', 'ihosting-core' ), $title ) . '</span>
						</a>';
	}

	if ( $vimeo_link != '' ) {
		$social_html .= '<a class="ih-social-link vimeo-link" href="' . esc_attr( $vimeo_link ) . '" target="' . esc_attr( $social_link_targets ) . '">
							<i class="fa fa-vimeo"></i>
							<span class="screen-reader-text">' . sprintf( esc_html__( '%s Vimeo link', 'ihosting-core' ), $title ) . '</span>
						</a>';
	}

	if ( $social_html != '' ) {
		$social_html = '<div class="social-links-list">' . $social_html . '</div>';
	}

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
					' . $img_html . '
					<div class="info-wrap">
					' . $title_html . '
					' . $desc_html . '
					' . $social_html . '
					</div>
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'ih_personnel', 'ih_personnel' );
