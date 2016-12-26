<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'lkTestimonialsCarousel' );
function lkTestimonialsCarousel() {

	global $kt_vc_anim_effects_in;

	$allowed_tags = array(
		'em' => array(),
	);

	vc_map(
		array(
			'name'     => esc_html__( 'LK Testimonials Carousel', 'ihosting-core' ),
			'base'     => 'lk_testimonials_carousel', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'        => 'autocomplete',
					'heading'     => esc_html__( 'Testimonials', 'ihosting-core' ),
					'param_name'  => 'testimonial_ids',
					'settings'    => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'std'         => '',
					'description' => esc_html__( 'Input testimonial ID or testimonial title to see suggestions.', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Text Color', 'ihosting-core' ),
					'param_name' => 'text_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Text Background Color', 'ihosting-core' ),
					'param_name' => 'text_bg_color',
					'std'        => 'rgba(255,255,255,0.1)',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Name Color', 'ihosting-core' ),
					'param_name' => 'name_color',
					'std'        => '#fff',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Max Width', 'ihosting-core' ),
					'param_name'  => 'max_width',
					'std'         => 684,
					'description' => esc_html__( 'Item inner max width. Width unit is pixel. Default 684.', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Text Align', 'ihosting-core' ),
					'param_name' => 'text_align',
					'value'      => array(
						esc_html__( 'Left', 'ihosting-core' )   => 'left',
						esc_html__( 'Right', 'ihosting-core' )  => 'right',
						esc_html__( 'Center', 'ihosting-core' ) => 'center',
					),
					'std'        => 'center',
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
add_filter( 'vc_autocomplete_lk_testimonials_carousel_testimonial_ids_callback', 'ihosting_vc_include_field_testimonial_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_lk_testimonials_carousel_testimonial_ids_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact testimonial. Must return an array (label,value)

function lk_testimonials_carousel( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_testimonials_carousel', $atts ) : $atts;

	if ( !class_exists( 'WooCommerce' ) ) {
		return '';
	}

	extract(
		shortcode_atts(
			array(
				'testimonial_ids' => '',
				'text_color'      => '#fff',
				'text_bg_color'   => 'rgba(255,255,255,0.1)',
				'name_color'      => '#fff',
				'max_width'       => 684,
				'text_align'      => 'center',
				'css_animation'   => '',
				'animation_delay' => '0.4',   //In second
				'css'             => '',
			), $atts
		)
	);

	$css_class = 'lk-testimonials-carousel-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}

	$animation_delay = $animation_delay . 's';

	$html = '';
	$testimonial_items_html = '';

	if ( trim( $testimonial_ids ) != '' ) {
		$testimonial_ids = explode( ',', $testimonial_ids );

		$query_args = array(
			'post_type'           => 'testimonial',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'post__in'            => $testimonial_ids,
			'posts_per_page'      => -1,
		);

		$testimonials = new WP_Query( $query_args );
		$total_testimonials = $testimonials->found_posts;

		$max_width = max( 0, intval( $max_width ) );

		if ( $testimonials->have_posts() ) :
			while ( $testimonials->have_posts() ) : $testimonials->the_post();


				$testimonial_items_html .= '<div class="testimonial-item">';
				$testimonial_items_html .= '<div class="inner" style="max-width: ' . $max_width . 'px;">';
				$testimonial_items_html .= '<div class="text said text-' . esc_attr( $text_align ) . '" style="color: ' . esc_attr( $text_color ) . '; background-color: ' . $text_bg_color . ';"><p><span class="ldquo">&ldquo;</span>' . get_the_content() . '<span class="rdquo">&rdquo;</span></p></div>';
				$testimonial_items_html .= '<span class="name people-said" style="color: ' . $name_color . ';">' . get_the_title() . '</span>';
				$testimonial_items_html .= '</div>';
				$testimonial_items_html .= '</div>';

			endwhile;

		endif; // End if ( $testimonials->have_posts() )

		wp_reset_postdata();

		$autoplay = $total_testimonials > 0 ? 'yes' : 'no';
		$loop = $autoplay;
		$html_attr = 'data-number="1" data-loop="' . esc_attr( $loop ) . '" data-navControl="yes" data-Dots="no" data-autoPlay="' . esc_attr( $autoplay ) . '" data-autoPlayTimeout="4000" data-margin="0" data-rtl="no"';


		$html = '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
                        <div class="testimonials-carousel ihosting-owl-carousel nav-center nav-style-3" ' . $html_attr . ' >
                            ' . $testimonial_items_html . '
                        </div><!-- /.testimonials-carousel -->
                    </div>';
	}

	return $html;

}

add_shortcode( 'lk_testimonials_carousel', 'lk_testimonials_carousel' );
