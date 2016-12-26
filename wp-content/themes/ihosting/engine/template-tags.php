<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package iHosting
 */

if ( !function_exists( 'ihosting_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function ihosting_posted_on() {
		global $ihosting;

		$default_blog_metas = array( 'date', 'author', 'comment', 'category', 'tags' );
		$blog_metas = isset( $ihosting['opt_blog_metas'] ) ? $ihosting['opt_blog_metas'] : $default_blog_metas;

		if ( !isset( $blog_metas ) ) {
			$blog_metas = $default_blog_metas;
		}

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <span>' . esc_html__( 'Update', 'ihosting' ) . '</span> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
		                        esc_attr( get_the_date( 'c' ) ),
		                        esc_html( get_the_date() ),
		                        esc_attr( get_the_modified_date( 'c' ) ),
		                        esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( '%s', 'post date', 'ihosting' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'ihosting' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		if ( in_array( 'author', $blog_metas ) ) {
			echo '<li class="byline post-by"> ' . $byline . '</li>'; // WPCS: XSS OK.
		}

		if ( in_array( 'date', $blog_metas ) ) {

			echo '<li class="posted-on post-date">' . $posted_on . '</li>';
		}

		if ( !is_single() && !post_password_required() && ( comments_open() || get_comments_number() ) && in_array( 'comment', $blog_metas ) ) {
			echo '<li class="post-comment">';
			echo comments_popup_link( esc_html__( 'Leave a comment', 'ihosting' ), esc_html__( '1 Comment', 'ihosting' ), esc_html__( '% Comments', 'ihosting' ) );
			echo '</li>';
		}

	}
endif; // End if ( ! function_exists( 'ihosting_posted_on' ) )

if ( !function_exists( 'ihosting_entry_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ihosting_entry_footer() {
		global $ihosting;

		$default_blog_metas = array( 'date', 'author', 'comment', 'category', 'tags' );
		$blog_metas = isset( $ihosting['opt_blog_metas'] ) ? $ihosting['opt_blog_metas'] : $default_blog_metas;

		if ( !isset( $blog_metas ) ) {
			$blog_metas = $default_blog_metas;
		}

		if ( is_sticky() && is_home() && !is_paged() ) {
			printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'ihosting' ) );
		}

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( ', ' );
			if ( $categories_list && ihosting_categorized_blog() && in_array( 'category', $blog_metas ) ) {
				printf( '<div class="cat-links">' . esc_html__( 'Posted in %1$s', 'ihosting' ) . '</div><br />', $categories_list ); // WPCS: XSS OK.
			}

			$tags_list = get_the_tag_list( '', ' ' );
			if ( $tags_list && in_array( 'tags', $blog_metas ) ) {
				printf( '<div class="tags-links tagcloud">' . esc_html__( '%1$s', 'ihosting' ) . '</div>', $tags_list ); // WPCS: XSS OK.
			}
		}

	}
}; // End if ( ! function_exists( 'ihosting_entry_footer' ) )

if ( !function_exists( 'ihosting_entry_single_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ihosting_entry_single_footer() {
		global $ihosting;

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$tags_list = get_the_tag_list( '', ' ' );
			printf( '<div class="tags-links tagcloud">' . esc_html__( '%1$s', 'ihosting' ) . '</div>', $tags_list ); // WPCS: XSS OK.
		}

	}
}; // End if ( ! function_exists( 'ihosting_entry_single_footer' ) )

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function ihosting_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'ihosting_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,

				// We only need to know if there is more than one category.
				'number'     => 2,
			)
		);

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'ihosting_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so ihosting_categorized_blog should return true.
		return true;
	}
	else {
		// This blog has only 1 category so ihosting_categorized_blog should return false.
		return false;
	}
}


if ( !function_exists( 'ihosting_post_thumbnail' ) ) {
	/**
	 * Display an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * Image responsive: https://www.sitepoint.com/how-to-build-responsive-images-with-srcset/
	 *
	 * @since iHosting 1.0
	 */
	function ihosting_post_thumbnail() {
		global $ihosting;

		if ( post_password_required() || is_attachment() ) {
			return;
		}

		$blog_layout_style = isset( $ihosting['opt_blog_layout_style'] ) ? $ihosting['opt_blog_layout_style'] : 'default';

		// Show place hold thumbnail when the post thumbnail does not exist
		$show_placehold_thumb = isset( $ihosting['opt_blog_' . esc_attr( $blog_layout_style ) . '_show_place_hold_img'] ) ? $ihosting['opt_blog_' . esc_attr( $blog_layout_style ) . '_show_place_hold_img'] == 1 : false;


		if ( !$show_placehold_thumb && !has_post_thumbnail() ) {
			return;
		}

		$thumb_w = 1156;
		$thumb_h = 578; // Single always use this size
		$img_sizes = array(
			'scr_lg' => array( $thumb_w, $thumb_h ),
			'scr_md' => array( $thumb_w, $thumb_h ),
			'scr_sm' => array( $thumb_w, $thumb_h ),
			'scr_xs' => array( $thumb_w, $thumb_h ),
		);

		if ( !is_singular() ) {

			$img_full = ihosting_resize_image( get_post_thumbnail_id(), null, 4000, 4000, true, true, false );
			$img_mime_type = get_post_mime_type( get_post_thumbnail_id() );

			$picture_html = '';
			$img_sources_html = '';
			$img_html = '<img width="' . esc_attr( $img_full['width'] ) . '"
						     height="' . esc_attr( $img_full['height'] ) . '"
						     class="attachment-post-thumbnail wp-post-image"
						     src="' . esc_url( $img_full['url'] ) . '"
						     alt="' . get_the_title() . '"/>';

			if ( $blog_layout_style == 'standard' ) { // For blog loop standard
				$img_sizes['scr_lg'] = array( 720, 450 ); // 420, 262
				$img_sizes['scr_md'] = array( 720, 450 );
				$img_sizes['scr_sm'] = array( 720, 450 );
				$img_sizes['scr_xs'] = array( 700, 436 );
				$img_scr_lg = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_lg'][0], $img_sizes['scr_lg'][1], true, true, false );
				$img_scr_md = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_md'][0], $img_sizes['scr_md'][1], true, true, false );
				$img_scr_sm = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_sm'][0], $img_sizes['scr_sm'][1], true, true, false );
				$img_scr_xs = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_xs'][0], $img_sizes['scr_xs'][1], true, true, false );

				$img_html = '<img width="' . esc_attr( $img_scr_lg['width'] ) . '"
						     height="' . esc_attr( $img_scr_lg['height'] ) . '"
						     class="attachment-post-thumbnail wp-post-image"
						     src="' . esc_url( $img_scr_lg['url'] ) . '"
						     alt="' . get_the_title() . '"/>';

				$img_sources_html .= '<source type="' . esc_attr( $img_mime_type ) . '" media="(max-width: 767px)" sizes="(max-width: 480px) 100vw, 60vw" srcset="' . esc_url( $img_scr_sm['url'] ) . ' ' . esc_attr( $img_scr_sm['width'] ) . 'w, ' . esc_url( $img_scr_sm['url'] ) . ' ' . esc_attr( $img_scr_sm['width'] ) . 'w">';
				//$img_sources_html .= '<source type="' . esc_attr($img_mime_type) . '" media="(max-width: 991px)" sizes="100vw" srcset="' . esc_url( $img_scr_md['url'] ) . ' ' . esc_attr( $img_scr_md['width'] ) . 'w">';
				$img_sources_html .= '<source type="' . esc_attr( $img_mime_type ) . '" media="(max-width: 1199px)" sizes="(max-width: 1000px) 60vw, 60vw" srcset="' . esc_url( $img_scr_lg['url'] ) . ' ' . esc_attr( $img_scr_lg['width'] ) . 'w, ' . esc_url( $img_scr_lg['url'] ) . ' ' . esc_attr( $img_scr_lg['width'] ) . 'w">';
			}
			if ( $blog_layout_style == 'grid' ) { // For blog loop grid
				$img_sizes['scr_lg'] = array( 420, 262 );
				$img_sizes['scr_md'] = array( 420, 262 );
				$img_sizes['scr_sm'] = array( 420, 262 );
				$img_sizes['scr_xs'] = array( 700, 436 );
				$img_scr_lg = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_lg'][0], $img_sizes['scr_lg'][1], true, true, false );
				$img_scr_md = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_md'][0], $img_sizes['scr_md'][1], true, true, false );
				$img_scr_sm = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_sm'][0], $img_sizes['scr_sm'][1], true, true, false );
				$img_scr_xs = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_xs'][0], $img_sizes['scr_xs'][1], true, true, false );

				$img_html = '<img width="' . esc_attr( $img_scr_lg['width'] ) . '"
						     height="' . esc_attr( $img_scr_lg['height'] ) . '"
						     class="attachment-post-thumbnail wp-post-image"
						     src="' . esc_url( $img_scr_lg['url'] ) . '"
						     alt="' . get_the_title() . '"/>';

				$img_sources_html .= '<source type="' . esc_attr( $img_mime_type ) . '" media="(max-width: 767px)" sizes="(max-width: 480px) 90vw, 96vw" srcset="' . esc_url( $img_scr_sm['url'] ) . ' ' . esc_attr( $img_scr_sm['width'] ) . 'w, ' . esc_url( $img_scr_sm['url'] ) . ' ' . esc_attr( $img_scr_sm['width'] ) . 'w">';
				//$img_sources_html .= '<source type="' . esc_attr($img_mime_type) . '" media="(max-width: 991px)" sizes="100vw" srcset="' . esc_url( $img_scr_md['url'] ) . ' ' . esc_attr( $img_scr_md['width'] ) . 'w">';
				$img_sources_html .= '<source type="' . esc_attr( $img_mime_type ) . '" media="(max-width: 1199px)" sizes="(max-width: 1000px) 40vw, 40vw" srcset="' . esc_url( $img_scr_lg['url'] ) . ' ' . esc_attr( $img_scr_lg['width'] ) . 'w, ' . esc_url( $img_scr_lg['url'] ) . ' ' . esc_attr( $img_scr_lg['width'] ) . 'w">';
			}
			if ( $blog_layout_style == 'masonry' ) { // For blog loop masonry
				$img_sizes['scr_lg'] = array( 420, 262 );
				$img_sizes['scr_md'] = array( 420, 262 );
				$img_sizes['scr_sm'] = array( 420, 262 );
				$img_sizes['scr_xs'] = array( 700, 436 );
				$img_scr_lg = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_lg'][0], $img_sizes['scr_lg'][1], true, true, false );
				$img_scr_md = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_md'][0], $img_sizes['scr_md'][1], true, true, false );
				$img_scr_sm = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_sm'][0], $img_sizes['scr_sm'][1], true, true, false );
				$img_scr_xs = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_xs'][0], $img_sizes['scr_xs'][1], true, true, false );

				$img_html = '<img width="' . esc_attr( $img_scr_lg['width'] ) . '"
						     height="' . esc_attr( $img_scr_lg['height'] ) . '"
						     class="attachment-post-thumbnail wp-post-image"
						     src="' . esc_url( $img_scr_lg['url'] ) . '"
						     alt="' . get_the_title() . '"/>';

				$img_sources_html .= '<source type="' . esc_attr( $img_mime_type ) . '" media="(max-width: 767px)" sizes="(max-width: 480px) 90vw, 96vw" srcset="' . esc_url( $img_scr_sm['url'] ) . ' ' . esc_attr( $img_scr_sm['width'] ) . 'w, ' . esc_url( $img_scr_sm['url'] ) . ' ' . esc_attr( $img_scr_sm['width'] ) . 'w">';
				//$img_sources_html .= '<source type="' . esc_attr($img_mime_type) . '" media="(max-width: 991px)" sizes="100vw" srcset="' . esc_url( $img_scr_md['url'] ) . ' ' . esc_attr( $img_scr_md['width'] ) . 'w">';
				$img_sources_html .= '<source type="' . esc_attr( $img_mime_type ) . '" media="(max-width: 1199px)" sizes="(max-width: 1000px) 40vw, 40vw" srcset="' . esc_url( $img_scr_lg['url'] ) . ' ' . esc_attr( $img_scr_lg['width'] ) . 'w, ' . esc_url( $img_scr_lg['url'] ) . ' ' . esc_attr( $img_scr_lg['width'] ) . 'w">';
			}

			$picture_html .= '<picture>';
			$picture_html .= $img_sources_html;
			$picture_html .= $img_html;
			$picture_html .= '</picture>';

			?>
			<div class="post-thumb-wrap">
				<div class="post-format post-format-<?php echo esc_attr( get_post_format() ); ?>">
					<a class="post-thumbnail hover-plus-effect" href="<?php echo esc_url( get_permalink() ); ?>"
					   aria-hidden="true">
						<?php echo wptexturize( $picture_html ); ?>
					</a>
				</div>
			</div>
			<?php

			return;
		}; // End if ( $show_placehold_thumb )

		// For single
		if ( is_singular() ) {

			$sidebar_pos = isset( $ihosting['opt_blog_sidebar_pos'] ) ? trim( $ihosting['opt_blog_sidebar_pos'] ) : 'right';

			// Collecting single post images for slideshow
			$imgs = array();
			if ( has_post_thumbnail() ) {
				$img_sizes['scr_lg'] = array( 1156, 578 );
				$img_sizes['scr_md'] = array( 770, 385 );
				$img_sizes['scr_sm'] = array( 770, 385 );
				$img_sizes['scr_xs'] = array( 480, 240 );
				$img_scr_lg = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_lg'][0], $img_sizes['scr_lg'][1], true, true, false );
				$img_scr_md = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_md'][0], $img_sizes['scr_md'][1], true, true, false );
				$img_scr_sm = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_sm'][0], $img_sizes['scr_sm'][1], true, true, false );
				$img_scr_xs = ihosting_resize_image( get_post_thumbnail_id(), null, $img_sizes['scr_xs'][0], $img_sizes['scr_xs'][1], true, true, false );

				$srcset = esc_url( $img_scr_lg['url'] ) . ' 1156w, ' . esc_url( $img_scr_md['url'] ) . ' 992w, ' . esc_url( $img_scr_sm['url'] ) . ' 768w, ' . esc_url( $img_scr_xs['url'] ) . ' 480w';
				$sizes = '(max-width: 479px) 100vw, (max-width: 767px) 96vw, (max-width: 991px) 96vw, (max-width: 1199px) 96vw, (max-width: 1362px) 96vw, 1156px';
				if ( $sidebar_pos != 'fullwidth' ) {
					$sizes = '(max-width: 479px) 100vw, (max-width: 767px) 96vw, (max-width: 991px) 55vw, (max-width: 1199px) 66vw, (max-width: 1362px) 62vw, 60vw';
				}

				$img_featured_html = '<img width="' . esc_attr( $img_scr_lg['width'] ) . '"
								     height="' . esc_attr( $img_scr_lg['height'] ) . '"
								     class="attachment-post-thumbnail size-post-thumbnail wp-post-image"
								     src="' . esc_url( $img_scr_lg['url'] ) . '"
								     srcset="' . esc_attr( $srcset ) . '"
								     sizes="' . esc_attr( $sizes ) . '"
								     alt="' . get_the_title() . '"/>';

				$imgs[] = $img_featured_html;
			}

			$gallery = array_filter( (array)get_post_meta( get_the_ID(), '_ihosting_images_gallery', true ) );

			if ( !empty( $gallery ) ) {
				foreach ( $gallery as $img_id => $img_url ):
					$img_sizes['scr_lg'] = array( 1156, 578 );
					$img_sizes['scr_md'] = array( 770, 385 );
					$img_sizes['scr_sm'] = array( 770, 385 );
					$img_sizes['scr_xs'] = array( 480, 240 );
					$img_scr_lg = ihosting_resize_image( $img_id, null, $img_sizes['scr_lg'][0], $img_sizes['scr_lg'][1], true, true, false );
					$img_scr_md = ihosting_resize_image( $img_id, null, $img_sizes['scr_md'][0], $img_sizes['scr_md'][1], true, true, false );
					$img_scr_sm = ihosting_resize_image( $img_id, null, $img_sizes['scr_sm'][0], $img_sizes['scr_sm'][1], true, true, false );
					$img_scr_xs = ihosting_resize_image( $img_id, null, $img_sizes['scr_xs'][0], $img_sizes['scr_xs'][1], true, true, false );

					$srcset = esc_url( $img_scr_lg['url'] ) . ' 1156w, ' . esc_url( $img_scr_md['url'] ) . ' 992w, ' . esc_url( $img_scr_sm['url'] ) . ' 768w, ' . esc_url( $img_scr_xs['url'] ) . ' 480w';
					$sizes = '(max-width: 479px) 100vw, (max-width: 767px) 96vw, (max-width: 991px) 96vw, (max-width: 1199px) 96vw, (max-width: 1362px) 96vw, 1156px';
					if ( $sidebar_pos != 'fullwidth' ) {
						$sizes = '(max-width: 479px) 100vw, (max-width: 767px) 96vw, (max-width: 991px) 55vw, (max-width: 1199px) 66vw, (max-width: 1362px) 62vw, 60vw';
					}

					$img_html = '<img width="' . esc_attr( $img_scr_lg['width'] ) . '"
							     height="' . esc_attr( $img_scr_lg['height'] ) . '"
							     class="attachment-post-thumbnail size-post-thumbnail wp-post-image"
							     src="' . esc_url( $img_scr_lg['url'] ) . '"
							     srcset="' . esc_attr( $srcset ) . '"
							     sizes="' . esc_attr( $sizes ) . '"
							     alt="' . esc_attr( get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ) . '"/>';

					$imgs[] = $img_html;

				endforeach;
				//$imgs = array_merge( $imgs, $gallery );
			}

			?>

			<?php if ( !empty( $imgs ) ) { ?>

				<?php if ( count( $imgs ) > 1 ) { // Show as slideshow ?>

					<div class="post-format lk-post-slide ihosting-owl-carousel nav-center nav-style-1" data-number="1"
					     data-loop="yes" data-navControl="yes"
					     data-Dots="no" data-autoPlay="yes" data-autoPlayTimeout="3000" data-margin="0" data-rtl="no">

						<?php foreach ( $imgs as $img ): ?>
							<div class="item-slide"><?php echo wptexturize( $img ); ?></div>
						<?php endforeach; ?>

					</div><!-- /.lk-post-slide -->

				<?php }
				else { // Show as thumbnail (has 1 image) ?>

					<div class="post-thumbnail">
						<?php echo wptexturize( $imgs[0] ); ?>
					</div><!-- .post-thumbnail -->

				<?php }; // End if ( count( $imgs_url ) > 1 ) ?>

			<?php }; // End if ( !empty( $imgs_url ) )
			?>

		<?php }
		else { ?>

			<a class="post-thumbnail" href="<?php echo get_permalink(); ?>" aria-hidden="true">
				<?php
				the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
				?>
			</a>

		<?php }; // End is_singular()
	}
};

if ( !function_exists( 'ihosting_single_title' ) ) {
	function ihosting_single_title( $post_id = 0 ) {
		global $ihosting;

		$post_id = max( 0, intval( $post_id ) );
		$title = '';

		if ( $post_id == 0 && is_singular() ) {
			$post_id = get_the_ID();
		}

		if ( $post_id > 0 ) {

			$show_single_title_section_setting = get_post_meta( $post_id, '_ihosting_single_header_title_section', true );
			$use_custom_title = get_post_meta( $post_id, '_ihosting_use_custom_title', true ) == 'yes';

			// if is single post, check options title type
			if ( get_post_type( $post_id ) == 'post' ) {
				// check using single post title or blgo title for header title section
				$title_type = isset( $ihosting['opt_single_post_title_type'] ) ? trim( $ihosting['opt_single_post_title_type'] ) : 'single'; // single, blog
				if ( $title_type == 'blog' ) {
					// if using global setting or show title but not use custom title
					if ( $show_single_title_section_setting == 'global' || $show_single_title_section_setting == 'show' && !$use_custom_title ) {
						$post_id = get_option( 'page_for_posts' );
						$use_custom_title = get_post_meta( $post_id, '_ihosting_use_custom_title', true ) == 'yes';
					}

				}
			}

			$title = get_the_title( $post_id );

			if ( $use_custom_title ) {
				$title = get_post_meta( $post_id, '_ihosting_custom_header_title', true );
			}
			else {

			}

		}

		return $title;

	}
}

if ( !function_exists( 'ihosting_single_header_bg_style' ) ) {
	function ihosting_single_header_bg_style( $post_id = 0 ) {
		global $ihosting;
		$post_id = max( 0, intval( $post_id ) );
		$top_banner_style = '';

		if ( $post_id == 0 && is_singular() ) {
			$post_id = get_the_ID();
		}

		$header_img = array(
			'url' => get_template_directory_uri() . '/assets/images/pattern1.png'
		);
		$header_img_repeat = 'repeat';

		if ( $post_id > 0 ) {
			$header_bg_type = get_post_meta( $post_id, '_ihosting_header_bg_type', true );
			if ( trim( $header_bg_type ) == '' ) {
				$header_bg_type = 'global';
			}

			switch ( $header_bg_type ) {
				case 'global':
					$header_img = isset( $ihosting['opt_header_img'] ) ? $ihosting['opt_header_img'] : $header_img;
					$header_img_repeat = isset( $ihosting['opt_header_img_repeat'] ) ? $ihosting['opt_header_img_repeat'] : $header_img_repeat;
					break;
				case 'image':
					$header_img['url'] = trim( get_post_meta( $post_id, '_ihosting_header_bg_src', true ) ) != '' ? esc_url( get_post_meta( $post_id, '_ihosting_header_bg_src', true ) ) : $header_img['url'];
					$header_img_repeat = trim( get_post_meta( $post_id, '_ihosting_header_bg_repeat', true ) ) != '' ? trim( get_post_meta( $post_id, '_ihosting_header_bg_repeat', true ) ) : $header_img_repeat;
					break;
				case 'no_image':
					$header_img['url'] = '';
					break;
			}
		}

		if ( trim( $header_img['url'] ) != '' ) {
			if ( $header_img_repeat == 'no-repeat' ) {
				$top_banner_style = 'style="background: url(' . esc_url( $header_img['url'] ) . ') ' . esc_attr( $header_img_repeat ) . ' center center; background-size: cover !important;"';
			}
			else {
				$top_banner_style = 'style="background: url(' . esc_url( $header_img['url'] ) . ') ' . esc_attr( $header_img_repeat ) . ' center center;"';
			}
		}

		return $top_banner_style;

	}
}

if ( !function_exists( 'ihosting_single_title_align' ) ) {
	function ihosting_single_title_align( $post_id = 0 ) {
		global $ihosting;

		$header_title_text_align = isset( $ihosting['opt_header_title_text_align'] ) ? $ihosting['opt_header_title_text_align'] : 'left';

		$post_id = max( 0, intval( $post_id ) );

		if ( $post_id == 0 && is_singular() ) {
			$post_id = get_the_ID();
		}

		if ( $post_id > 0 ) {

			$post_title_align = get_post_meta( $post_id, '_ihosting_header_title_text_align', true );

			if ( $post_title_align != 'global' ) {
				$header_title_text_align = $post_title_align;
			}

		}

		return $header_title_text_align;

	}
}

if ( !function_exists( 'ihosting_theme_comment' ) ) {

	function ihosting_theme_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		extract( $args, EXTR_SKIP );

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		}
		else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ) . ' '; ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-item">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php if ( $args['avatar_size'] != 0 )
				echo get_avatar( $comment, $args['avatar_size'] ); ?>
			<?php //printf( esc_html__( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?>
		</div>
		<div class="comment-body">
			<h5 class="author"><?php echo get_comment_author(); ?></h5>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'ihosting' ); ?></em>
				<br/>
			<?php endif; ?>

			<div class="date-reply-comment">
				<span class="date-comment"><?php echo get_comment_date(); ?></span>
			</div><!-- /.date-reply-comment -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- /.comment-content -->

			<?php comment_reply_link(
				array_merge(
					$args,
					array(
						'add_below' => $add_below,
						'depth'     => $depth,
						'max_depth' => $args['max_depth']
					)
				)
			); ?>

		</div><!-- /.comment-body -->

		<?php if ( 'div' != $args['style'] ) : ?>
			</div>
		<?php endif; ?>
		<?php
	}

}

if ( !function_exists( 'ihosting_the_posts_navigation' ) ) {

	/**
	 * Display navigation to next/previous set of posts when applicable (Except blog layout style masonry)
	 *
	 * @since 1.0
	 *
	 * @param array $args Optional. See {@see get_the_posts_navigation()} for available
	 *                    arguments. Default empty array.
	 */
	function ihosting_the_posts_navigation( $args = array() ) {
		global $ihosting;

		$blog_layout_style = isset( $ihosting['opt_blog_layout_style'] ) ? $ihosting['opt_blog_layout_style'] : 'standard';
		$sidebar_pos = isset( $ihosting['opt_blog_sidebar_pos'] ) ? trim( $ihosting['opt_blog_sidebar_pos'] ) : 'right';

		if ( is_search() ) {
			$blog_layout_style = 'standard';
		}

		// Don't show navigation on masonry blog layout style
		if ( $blog_layout_style == 'masonry' ) {

			// Masonry load more text
			$load_more_text = isset( $ihosting['opt_blog_masonry_loadmore_text'] ) ? $ihosting['opt_blog_masonry_loadmore_text'] : esc_html__( 'Load more', 'ihosting' );
			?>
			<?php if ( trim( $load_more_text ) != '' ): ?>
				<div class="masonry-loadmore-wrap">
					<a href="#" data-sidebar-pos="<?php echo esc_attr( $sidebar_pos ); ?>"
					   class="button btn blog-masonry-loadmore-btn"><?php echo sanitize_text_field( $load_more_text ); ?></a>
				</div>
			<?php endif; // End if ( trim( $load_more_text ) != '' ) ?>
			<?php
		}
		else {
			the_posts_pagination( $args );
		}
	}

}

if ( !function_exists( 'ihosting_modify_read_more_link' ) ) {
	function ihosting_modify_read_more_link() {
		global $ihosting;
		$read_more_text = isset( $ihosting['opt_blog_continue_reading'] ) ? sanitize_text_field( $ihosting['opt_blog_continue_reading'] ) : esc_html__( 'Read more', 'ihosting' );

		return '<a class="read-more kt-button button read-more-btn" href="' . get_permalink() . '">' . $read_more_text . '<span class="screen-reader-text">' . get_the_title() . '</span></a>';
	}

	add_filter( 'the_content_more_link', 'ihosting_modify_read_more_link' );
}

if ( !function_exists( 'ihosting_before_loop_posts_wrap' ) ) {

	function ihosting_before_loop_posts_wrap() {
		global $ihosting;

		$blog_layout_style = isset( $ihosting['opt_blog_layout_style'] ) ? $ihosting['opt_blog_layout_style'] : 'default';

		if ( is_search() ) {
			$blog_layout_style = 'standard';
		}

		$additional_class = in_array( $blog_layout_style, array( 'grid', 'masonry' ) ) ? ' row' : '';

		echo '<div class="posts-wrap posts-' . esc_attr( $blog_layout_style ) . esc_attr( $additional_class ) . '">';

	}

	add_action( 'ihosting_before_loop_posts', 'ihosting_before_loop_posts_wrap', 10 );
}

if ( !function_exists( 'ihosting_after_loop_posts_wrap' ) ) {

	function ihosting_after_loop_posts_wrap() {
		global $ihosting;

		$blog_layout_style = isset( $ihosting['opt_blog_layout_style'] ) ? $ihosting['opt_blog_layout_style'] : 'default';

		if ( is_search() ) {
			$blog_layout_style = 'standard';
		}

		echo '</div><!-- /.posts-wrap .posts-' . esc_attr( $blog_layout_style ) . ' -->';

	}

	add_action( 'ihosting_after_loop_posts', 'ihosting_after_loop_posts_wrap', 10 );
}


/**
 * Flush out the transients used in ihosting_categorized_blog.
 */
function ihosting_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'ihosting_categories' );
}

add_action( 'edit_category', 'ihosting_category_transient_flusher' );
add_action( 'save_post', 'ihosting_category_transient_flusher' );
