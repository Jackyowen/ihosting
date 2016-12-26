<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkMemberCarousel' );
function lkMemberCarousel() {

	global $kt_vc_anim_effects_in;

	$allowed_tags = array(
		'em' => array(),
	);

	vc_map(
		array(
			'name'     => esc_html__( 'LK Members Carousel', 'ihosting-core' ),
			'base'     => 'lk_members_carousel', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'autocomplete',
					'heading'     => esc_html__( 'Members', 'ihosting-core' ),
					'param_name'  => 'member_ids',
					'settings'    => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'std'         => '',
					'description' => esc_html__( 'Input member ID or member title to see suggestions.', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Image Size', 'ihosting-core' ),
					'param_name'  => 'img_size',
					'std'         => '180x180',
					'description' => wp_kses( __( '<em>{width}x{height}</em>. Example: <em>180x180</em>, etc...', 'ihosting-core' ), $allowed_tags ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Members Per Slide', 'ihosting-core' ),
					'value'       => 4,
					'save_always' => true,
					'param_name'  => 'members_per_slide',
					'description' => esc_html__( 'How many members per slide on the large screen? Min = 1, max = 4.', 'ihosting-core' ),
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

// vc_autocomplete_{short_code_name}_{param_name}_callback
add_filter( 'vc_autocomplete_lk_members_carousel_member_ids_callback', 'ihosting_vc_include_field_member_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_members_carousel_member_ids_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact member. Must return an array (label,value)

function lk_members_carousel( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_members_carousel', $atts ) : $atts;

	if ( !class_exists( 'WooCommerce' ) ) {
		return '';
	}

	extract(
		shortcode_atts(
			array(
				'member_ids'        => '',
				'img_size'          => '180x180',
				'members_per_slide' => '',
				'css_animation'     => '',
				'animation_delay'   => '0.4',   //In second
				'css'               => '',
			), $atts
		)
	);

	$css_class = 'lk-members-carousel-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}

	$animation_delay = $animation_delay . 's';

	// Member image size (background)
	$img_size_x = 180;
	$img_size_y = 180;
	if ( trim( $img_size ) != '' ) {
		$img_size = explode( 'x', $img_size );
	}
	$img_size_x = isset( $img_size[0] ) ? max( 0, intval( $img_size[0] ) ) : $img_size_x;
	$img_size_y = isset( $img_size[1] ) ? max( 0, intval( $img_size[1] ) ) : $img_size_y;


	$html = '';
	$member_items_html = '';

	if ( trim( $member_ids ) != '' ) {
		$member_ids = explode( ',', $member_ids );

		$query_args = array(
			'post_type'           => 'member',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'post__in'            => $member_ids,
			'posts_per_page'      => -1,
		);

		$members = new WP_Query( $query_args );
		$total_members = $members->found_posts;

		if ( $members->have_posts() ) :
			while ( $members->have_posts() ) : $members->the_post();

				$member_pos_html = '';
				$member_social_html = '';

				$member_pos = get_post_meta( get_the_ID(), '_ihosting_member_position', true );
				$member_social_pages_groups = get_post_meta( get_the_ID(), '_ihosting_member_social_pages_groups', true );

				if ( trim( $member_pos ) != '' ) {
					$member_pos_html = '<span class="position">' . sanitize_text_field( $member_pos ) . '</span>';
				}

				if ( !empty( $member_social_pages_groups ) ) {
					foreach ( $member_social_pages_groups as $member_social_page ) {
						$social_link = isset( $member_social_page['_ihosting_member_social_link'] ) ? esc_url( $member_social_page['_ihosting_member_social_link'] ) : '';
						$social_class = isset( $member_social_page['_ihosting_member_social_icon_class'] ) ? esc_attr( $member_social_page['_ihosting_member_social_icon_class'] ) : 'fa fa-question';
						$social_title = isset( $member_social_page['_ihosting_member_social_title'] ) ? esc_attr( $member_social_page['_ihosting_member_social_title'] ) : '';
						if ( trim( $social_link ) != '' && trim( $social_class ) != '' ) {
							$member_social_html .= '<a class="member-social-page-link" href="' . $social_link . '" title="' . $social_title . '"><i class="' . $social_class . '"></i><span class="screen-reader-text">' . $social_title . '</span></a>';
						}
					}
					$member_social_html = '<div class="member-social-pages">' . $member_social_html . '</div>';
				}


				$img = ihosting_core_resize_image( get_post_thumbnail_id(), null, $img_size_x, $img_size_y, true, true, false );
				$member_items_html .= '<div class="member-item">';
				$member_items_html .= '<div class="member">';
				$member_items_html .= '<div class="member-inner">';
				$member_items_html .= '<div class="member-img-wrap"><img width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( get_the_title() ) . '" /></div>';
				$member_items_html .= '<h6 class="member-name">' . get_the_title() . '</h6>';
				$member_items_html .= $member_pos_html;
				$member_items_html .= $member_social_html;
				$member_items_html .= '</div><!-- /.member-inner -->';
				$member_items_html .= '</div><!-- /.member -->';
				$member_items_html .= '</div><!-- /.member-item -->';

			endwhile;

		endif; // End if ( $members->have_posts() )

		wp_reset_postdata();

		$autoplay = $total_members > 0 ? 'yes' : 'no';
		$loop = $autoplay;
		$html_attr = 'data-number="' . esc_attr( $members_per_slide ) . '" data-loop="' . esc_attr( $loop ) . '" data-navControl="yes" data-Dots="no" data-autoPlay="' . esc_attr( $autoplay ) . '" data-autoPlayTimeout="4000" data-margin="30" data-rtl="no"';


		$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                        <div class="members-carousel ihosting-owl-carousel nav-center nav-style-2" ' . $html_attr . ' >
                            ' . $member_items_html . '
                        </div><!-- /.members-carousel -->
                    </div>';
	}

	return $html;

}

add_shortcode( 'lk_members_carousel', 'lk_members_carousel' );
