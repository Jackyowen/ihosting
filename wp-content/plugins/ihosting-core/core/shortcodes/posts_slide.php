<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'lkPostsSlide' );
function lkPostsSlide() {
	global $kt_vc_anim_effects_in;
	vc_map(
		array(
			'name'     => esc_html__( 'LK Posts Slide', 'ihosting-core' ),
			'base'     => 'lk_posts_slide', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'ihosting_select_cat_field',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Posts Category', 'ihosting-core' ),
					'param_name' => 'cat_slug',
					'std'        => '',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Thumbnail Size', 'ihosting-core' ),
					'param_name'  => 'img_size',
					'std'         => '370x253',
					'description' => wp_kses( __( 'Format {width}x{height}. Default <strong>370x253</strong>.', 'ihosting-core' ), array( 'strong' => array(), 'b' => array() ) ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show The Post Author', 'ihosting-core' ),
					'param_name' => 'show_post_author',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no'
					),
					'std'        => 'no'
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show The Post Date', 'ihosting-core' ),
					'param_name' => 'show_post_date',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no'
					),
					'std'        => 'yes'
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show Post Comments Count', 'ihosting-core' ),
					'param_name' => 'show_post_comments_count',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no'
					),
					'std'        => 'yes'
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show Read More Button', 'ihosting-core' ),
					'param_name' => 'show_read_more_btn',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no'
					),
					'std'        => 'yes'
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Number Of Posts', 'ihosting-core' ),
					'param_name'  => 'number_of_items',
					'std'         => 12,
					'description' => esc_html__( 'Maximum number of posts will load', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Posts Per Slide', 'ihosting-core' ),
					'param_name'  => 'items_per_slide',
					'std'         => 3,
					'description' => esc_html__( 'Number of posts per slide on the large screen', 'ihosting-core' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Loop', 'ihosting-core' ),
					'param_name' => 'loop',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no'
					),
					'std'        => 'yes'
				),
				array(
					'type'       => 'dropdown',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Autoplay', 'ihosting-core' ),
					'param_name' => 'autoplay',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no'
					),
					'std'        => 'yes',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Autoplay Timeout', 'ihosting-core' ),
					'param_name'  => 'autoplay_timeout',
					'std'         => 5000,
					'description' => esc_html__( 'Unit is milliseconds (ms). 1000ms = 1s.', 'ihosting-core' ),
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
				)
			)
		)
	);
}


function lk_posts_slide( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_posts_slide', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'cat_slug'                 => '',
				'img_size'                 => '370x253',
				'show_post_author'         => 'no',
				'show_post_date'           => 'yes',
				'show_post_comments_count' => 'yes',
				'show_read_more_btn'       => 'yes',
				'number_of_items'          => 9,
				'items_per_slide'          => 3,
				'loop'                     => 'yes',
				'autoplay'                 => 'yes',
				'autoplay_timeout'         => 5000,
				'css_animation'            => '',
				'animation_delay'          => '0.4',  // In second
				'css'                      => '',
			), $atts
		)
	);

	$css_class = 'lk-slide-post-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = '0';
	}
	$animation_delay = $animation_delay . 's';

	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'showposts'           => intval( $number_of_items ),
	);

	$cat_slug = intval( $cat_slug );
	if ( $cat_slug > 0 ):

		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $cat_slug
			)
		);

	endif;

	$html = '';

	ob_start();

	$posts = new WP_Query( $args );
	$total_posts = $posts->post_count;
	$loop = $total_posts <= 1 ? 'no' : $loop;
	$autoplay = $total_posts <= 1 ? 'no' : $autoplay;

	$img_size_x = 370;
	$img_size_y = 253;
	if ( trim( $img_size ) != '' ) {
		$img_size = explode( 'x', $img_size );
	}
	$img_size_x = isset( $img_size[0] ) ? max( 1, intval( $img_size[0] ) ) : $img_size_x;
	$img_size_y = isset( $img_size[1] ) ? max( 1, intval( $img_size[1] ) ) : $img_size_y;

	//$gallery_unid_id = uniqid( 'gallery-' );

	?>

	<?php if ( $posts->have_posts() ): ?>
		<div class="<?php echo esc_attr( $css_class ); ?>" data-wow-delay="<?php echo esc_attr( $animation_delay ); ?>">
			<div class="ihosting-owl-carousel lk-slide-post nav-style-1 nav-center nav-align-mid-by-elem"
			     data-align-elem=".post-thumb-wrap" data-margin="25"
			     data-number="<?php echo intval( $items_per_slide ); ?>" data-loop="<?php echo esc_attr( $loop ); ?>"
			     data-autoPlayTimeout="<?php echo intval( $autoplay_timeout ); ?>"
			     data-autoPlay="<?php echo esc_attr( $autoplay ); ?>" data-navControl="yes">
				<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
					<?php
					$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
					//		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
					//			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <span>' . esc_html__( 'Update', 'ihosting' ) . '</span> <time class="updated" datetime="%3$s">%4$s</time>';
					//		}

					$time_string = sprintf(
						$time_string,
						esc_attr( get_the_date( 'c' ) ),
						esc_html( get_the_date() ),
						esc_attr( get_the_modified_date( 'c' ) ),
						esc_html( get_the_modified_date() )
					);

					$img = ihosting_core_resize_image( get_post_thumbnail_id(), null, $img_size_x, $img_size_y, true, true, false );
					//$img_full = ihosting_core_resize_image( null, null, 2000, 2000, true, true, false );
					?>
					<div class="item-post">
						<div class="post-thumb-wrap">
							<a href="<?php echo get_permalink(); ?>" class="hover-plus-effect">
								<figure>
									<img width="<?php echo esc_attr( $img['width'] ); ?>"
									     height="<?php echo esc_attr( $img['height'] ); ?>"
									     src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php the_title(); ?>"/>
								</figure>
							</a>
						</div>
						<div class="post-title-wrap">
							<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							<?php if ( $show_post_author == 'yes' ) { ?>
								<span class="post-author">
								<?php
								echo sprintf( esc_html_x( 'by %s', 'post author', 'ihosting-core' ), '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>' );
								?>
								</span>
							<?php } ?>
							<?php if ( $show_post_date == 'yes' ) { ?>
								<?php
								echo sprintf( esc_html_x( '%s', 'post date', 'ihosting-core' ), '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>' );
								?>
							<?php } ?>
						</div>
						<div class="post-meta-wrap">
							<?php if ( $show_post_comments_count == 'yes' ) { ?>
								<span class="comments-count-wrap">
									<i class="fa fa-comment-o"></i>
									<?php
									echo comments_popup_link( esc_html__( 'Leave a comment', 'ihosting-core' ), esc_html__( '1 Comment', 'ihosting-core' ), esc_html__( '% Comments', 'ihosting-core' ) );
									?>
								</span>
							<?php } ?>
							<?php if ( $show_read_more_btn == 'yes' ) { ?>
								<a href="<?php echo get_permalink(); ?>"
								   class="button read-mmore-btn"><?php esc_html_e( 'Read more', 'ihosting-core' ); ?></a>
							<?php } ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div><!-- /.lk-slide-post -->
		</div><!-- /.<?php echo esc_attr( $css_class ); ?> -->
	<?php endif; // End if ( $posts->have_posts() ) ?>

	<?php

	wp_reset_postdata();

	$html .= ob_get_clean();

	return $html;

}

add_shortcode( 'lk_posts_slide', 'lk_posts_slide' );
