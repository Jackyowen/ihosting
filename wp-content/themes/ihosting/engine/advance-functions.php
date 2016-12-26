<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package iHosting
 */


if ( !function_exists( 'ihosting_get_global_theme_options' ) ) {
	function ihosting_get_global_theme_options() {
		return ihosting_get_some_vars();
	}
}

if ( !function_exists( 'ihosting_init_some_options' ) ) {
	function ihosting_init_some_options() {
		// Disable options for compare button in products list
		if ( get_option( 'yith_woocompare_compare_button_in_products_list' ) == 'yes' ) {
			update_option( 'yith_woocompare_compare_button_in_products_list', 'no' );
		}
	}

	add_action( 'init', 'ihosting_init_some_options' );
}

if ( !function_exists( 'ihosting_get_some_vars' ) ) {

	function ihosting_get_some_vars() {
		global $ihosting, $woocommerce_loop, $force_grid_masonry;

		// Socials info
		$ihosting['opt_twitter_link'] = isset( $ihosting['opt_twitter_link'] ) ? $ihosting['opt_twitter_link'] : '';
		$ihosting['opt_fb_link'] = isset( $ihosting['opt_fb_link'] ) ? $ihosting['opt_fb_link'] : '';
		$ihosting['opt_google_plus_link'] = isset( $ihosting['opt_google_plus_link'] ) ? $ihosting['opt_google_plus_link'] : '';
		$ihosting['opt_dribbble_link'] = isset( $ihosting['opt_dribbble_link'] ) ? $ihosting['opt_dribbble_link'] : '';
		$ihosting['opt_behance_link'] = isset( $ihosting['opt_behance_link'] ) ? $ihosting['opt_behance_link'] : '';
		$ihosting['opt_tumblr_link'] = isset( $ihosting['opt_tumblr_link'] ) ? $ihosting['opt_tumblr_link'] : '';
		$ihosting['opt_instagram_link'] = isset( $ihosting['opt_instagram_link'] ) ? $ihosting['opt_instagram_link'] : '';
		$ihosting['opt_pinterest_link'] = isset( $ihosting['opt_pinterest_link'] ) ? $ihosting['opt_pinterest_link'] : '';
		$ihosting['opt_youtube_link'] = isset( $ihosting['opt_youtube_link'] ) ? $ihosting['opt_youtube_link'] : '';
		$ihosting['opt_vimeo_link'] = isset( $ihosting['opt_vimeo_link'] ) ? $ihosting['opt_vimeo_link'] : '';
		$ihosting['opt_linkedin_link'] = isset( $ihosting['opt_linkedin_link'] ) ? $ihosting['opt_linkedin_link'] : '';
		$ihosting['opt_rss_link'] = isset( $ihosting['opt_rss_link'] ) ? $ihosting['opt_rss_link'] : '';

		if ( isset( $_GET['sidebar'] ) ) {
			if ( trim( $_GET['sidebar'] ) != '' ) { // left, right, fullwidth
				$ihosting['opt_blog_sidebar_pos'] = trim( $_GET['sidebar'] ); // Set blog sidebar
				$ihosting['woo_shop_sidebar_pos'] = trim( $_GET['sidebar'] ); // Set shop sidebar
				$ihosting['woo_single_product_sidebar_pos'] = trim( $_GET['sidebar'] ); // Set single product sidebar
			}
		}

		if ( isset( $_GET['shop_default_layout'] ) ) {
			if ( trim( $_GET['shop_default_layout'] ) != '' ) {
				$ihosting['woo_shop_default_layout'] = trim( $_GET['shop_default_layout'] ); // Set shop/products archive default layout
			}
		}

		if ( isset( $_GET['blog_layout'] ) ) { // Set blog layout style: default, standard, grid, masonry
			if ( trim( $_GET['blog_layout'] ) != '' ) {
				$ihosting['opt_blog_layout_style'] = trim( $_GET['blog_layout'] ); // Set blog sidebar
			}
		}

		if ( isset( $_GET['single_sidebar'] ) ) { // Set product single sidebar
			if ( trim( $_GET['single_sidebar'] ) != '' ) { // 0 or 1 (1: show single product sidebar)
				$ihosting['opt_single_product_sidebar'] = trim( $_GET['single_sidebar'] ); // Set single sidebar
			}
		}

		if ( isset( $_GET['product_title'] ) ) { // Product title always show or show on hover?
			if ( trim( $_GET['product_title'] ) != '' ) { // "always_show" or "show_on_hover"
				$ihosting['opt_show_product_title_on_loop'] = trim( $_GET['product_title'] );
			}
		}

		if ( isset( $_GET['products_per_row'] ) ) { // Products per row on shop
			if ( trim( $_GET['products_per_row'] ) != '' ) { // 2 --> 4
				$ihosting['woo_products_per_row'] = min( 4, max( 2, intval( $_GET['products_per_row'] ) ) );
				apply_filters( 'loop_shop_columns', $ihosting['woo_products_per_row'] );
			}
		}

		return $ihosting;

	}

	add_action( 'init', 'ihosting_get_some_vars' );

}

if ( !function_exists( 'ihosting_get_current_page_id' ) ) {
	/**
	 * Get current post/page... id
	 *
	 * @return  integer Current post/page... id
	 */
	function ihosting_get_current_page_id() {
		$post_id = 0; // Post, page or post type... id

		if ( is_front_page() && is_home() ) {
			// Default homepage
			// Current version of theme does not support custom header for search results default home page, global setting will be used
		}
		elseif ( is_front_page() ) {
			// static homepage
			$post_id = get_option( 'page_on_front' );
		}
		elseif ( is_home() ) {
			// blog page
			$post_id = get_option( 'page_for_posts' );
		}
		else {
			// Everything else

			// Is a singular
			if ( is_singular() ) {
				$post_id = get_the_ID();
			}
			else {
				// Is archive or taxonomy
				if ( is_archive() ) {

					// Category
					if ( is_category() ) {

					}

					// Checking for shop archive
					if ( function_exists( 'is_shop' ) ) { // Products archive, products category, products search page...
						if ( is_shop() ) {
							$post_id = get_option( 'woocommerce_shop_page_id' );
							//$header_settings['woo_shop_top_bg'] = isset( $ihosting['woo_shop_top_bg'] ) ? $ihosting['woo_shop_top_bg'] : array();
						}
						if ( is_product_category() ) {


						}
					}

					// Other taxonomies
					if ( isset( $ihosting['opt_hero_show_on_taxs'] ) ) {

					}

				}
				else {
					if ( is_404() ) {
						// Current version of theme does not support custom header for 404 page, global setting will be used
					}
					else {
						if ( is_search() ) {

						}
						else {
							// Is category, is tag, is tax
							// Current version of theme does not support custom header for search results category, tag, tax.., global setting will be used
						}
					}
				}

			}

			// Other WooCommerce pages
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_cart() ) {
					$post_id = wc_get_page_id( 'cart' );
				}
				if ( is_checkout() ) {
					$post_id = wc_get_page_id( 'checkout' );
				}
				if ( is_account_page() ) {
					$post_id = wc_get_page_id( 'myaccount' );
				}
			}

		}

		return $post_id;
	}
}

if ( !function_exists( 'ihosting_get_current_header_layout' ) ) {

	/**
	 * Get current header layout
	 *
	 * @since 1.0
	 *
	 * @return string   Header layout name
	 */
	function ihosting_get_current_header_layout() {
		global $ihosting;
		$header_layout = isset( $ihosting['opt_header_layout'] ) ? trim( $ihosting['opt_header_layout'] ) : 'style_1';

		return $header_layout;
	}
}

if ( !function_exists( 'ihosting_get_header_settings' ) ) {

	/**
	 * Get Header and Hero section settings
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	function ihosting_get_header_settings() {
		global $ihosting, $woocommerce;

		$allow_tags = array(
			'a'      => array(
				'href'   => array(),
				'title'  => array(),
				'target' => array(),
			),
			'span'   => array(),
			'b'      => array(),
			'strong' => array(),
		);

		$logo_width = 190;
		$logo_height = 46;

		$header_settings = array(
			'header_class' => 'header'
		);
		$header_layout = isset( $ihosting['opt_header_layout'] ) ? trim( $ihosting['opt_header_layout'] ) : 'style_1';
		$header_desc = isset( $ihosting['opt_header_desc'] ) ? trim( $ihosting['opt_header_desc'] ) : '';
		$header_contact_info = isset( $ihosting['opt_header_contact_info'] ) ? (array)$ihosting['opt_header_contact_info'] : array();

		$header_settings['header_layout'] = $header_layout;
		$header_settings['header_class'] .= ' header-layout-' . esc_attr( $header_layout );
		$header_settings['header_desc'] = $header_desc;
		$header_settings['header_contact_info'] = $header_contact_info;
		$header_settings['header_top_menu_html'] = '';
		$header_settings['show_login_link'] = isset( $ihosting['opt_show_login_link'] ) ? $ihosting['opt_show_login_link'] == 1 : true;
		$header_settings['show_language_swicher'] = isset( $ihosting['opt_show_language_swicher'] ) ? $ihosting['opt_show_language_swicher'] == 1 : true;

		//$header_settings['header_logo_url'] = isset( $ihosting['opt_header_' . esc_attr( $header_settings['header_layout'] ) . '_logo']['url'] ) ? $ihosting['opt_header_' . esc_attr( $header_settings['header_layout'] ) . '_logo']['url'] : get_template_directory_uri() . '/assets/images/logo.png';

		$header_settings['logo'] = array(
			'url'    => get_template_directory_uri() . '/assets/images/logo.png',
			'width'  => '',
			'height' => ''
		);

		if ( isset( $ihosting['opt_header_' . esc_attr( $header_settings['header_layout'] ) . '_logo']['id'] ) ) {
			$logo_id = $ihosting['opt_header_' . esc_attr( $header_settings['header_layout'] ) . '_logo']['id'];
			$logo = ihosting_resize_image( $logo_id, null, $logo_width, $logo_height, false, true, false );
			$header_settings['logo'] = $logo;
		}
		else {
			if ( isset( $ihosting['opt_header_' . esc_attr( $header_settings['header_layout'] ) . '_logo']['url'] ) ) {
				$header_settings['logo'] = array(
					'url' => $ihosting['opt_header_' . esc_attr( $header_settings['header_layout'] ) . '_logo']['url']
				);
			}
		}


		// For custom Header/Banner/Heading/Breadcrumb (static home page, blog page, single post, page, product...)
		$post_id = ihosting_get_current_page_id(); // Post, page or post type... id

		$custom_header_layout = get_post_meta( $post_id, '_ihosting_header_layout', true );

		$is_custom_header = $post_id > 0 && $custom_header_layout != 'global' && $custom_header_layout != '';

		// Is custom header
		if ( $is_custom_header ) {
			$header_settings['header_layout'] = $custom_header_layout;
			$header_settings['header_class'] = "header header-custom header_{$header_settings['header_layout']}";

			// Default logo args for custom logo
			$header_settings['logo'] = array(
				'url'    => '',
				'width'  => '',
				'height' => ''
			);

			$logo_img_id = get_post_meta( $post_id, "_ihosting_header_logo_{$header_settings['header_layout']}_id", true );

			// Custom header logo
			$header_settings['logo'] = ihosting_resize_image( $logo_img_id, null, $logo_width, $logo_height, false, true, false );

			// Custom contact info
			$header_contact_info_args = (array)get_post_meta( $post_id, "_ihosting_header_contact_info_group", true );
			if ( !empty( $header_contact_info_args ) ) {
				$header_contact_info = array();
				foreach ( $header_contact_info_args as $header_contact_info_arg ) {
					$contact_info_icon_html = '';
					if ( isset( $header_contact_info_arg['_ihosting_header_contact_info_icon_class'] ) ) {
						$contact_info_icon_html = trim( $header_contact_info_arg['_ihosting_header_contact_info_icon_class'] ) != '' ? '<i class="' . esc_attr( $header_contact_info_arg['_ihosting_header_contact_info_icon_class'] ) . '"></i>' : '';
					}
					$contact_info_text = isset( $header_contact_info_arg['_ihosting_header_contact_info_text'] ) ? $header_contact_info_arg['_ihosting_header_contact_info_text'] : '';
					if ( trim( $header_contact_info_arg['_ihosting_header_contact_info_link'] ) != '' ) {
						$header_contact_info[] = '<a href="' . esc_attr( $header_contact_info_arg['_ihosting_header_contact_info_link'] ) . '">' . wptexturize( $contact_info_icon_html ) . '<span>' . esc_html( $contact_info_text ) . '</span></a>';
					}
					else {
						$header_contact_info[] = '<span href="' . esc_attr( $header_contact_info_arg['_ihosting_header_contact_info_link'] ) . '">' . wptexturize( $contact_info_icon_html ) . '<span>' . esc_html( $contact_info_text ) . '</span></span>';
					}
				}
			}

			// Custom show login/register link
			$header_settings['show_login_link'] = get_post_meta( $post_id, "_ihosting_show_header_login_link", true ) == 'show';

			// Custom show language switcher
			$header_settings['show_language_swicher'] = get_post_meta( $post_id, "_ihosting_show_header_lang_switcher", true ) == 'show';
		}

		if ( !empty( $header_contact_info ) ) {
			foreach ( $header_contact_info as $contact_info ) {
				$header_settings['header_top_menu_html'] .= '<li class="icon-header">' . wptexturize( $contact_info ) . '</li>';
			}
		}

		if ( class_exists( 'WooCommerce' ) && $header_settings['show_login_link'] ) {
			global $current_user;
			$account_page_link = get_permalink( wc_get_page_id( 'myaccount' ) );
			$login_title = is_user_logged_in() ? sprintf( esc_html__( 'Welcome %s', 'ihosting' ), $current_user->display_name ) : esc_html__( 'Login/Register', 'ihosting' );
			$header_settings['header_top_menu_html'] .= '<li class="icon-header">
								                            <a href="' . esc_url( $account_page_link ) . '">
								                                <i class="fa fa-user" aria-hidden="true"></i>
								                                <span>' . sanitize_text_field( $login_title ) . '</span>
								                            </a>
								                        </li>';
		}

		if ( $header_settings['show_language_swicher'] ) {
			$header_settings['header_top_menu_html'] .= ihosting_language_switcher_flags_list( 'li', 'icon-header icon-country' );
		}

		if ( trim( $header_settings['header_top_menu_html'] ) != '' ) {
			$header_settings['header_top_menu_html'] = '<ul class="menu-icon-header">' . wptexturize( $header_settings['header_top_menu_html'] ) . '</ul>';
		}

		return $header_settings;

	}
}

if ( !function_exists( 'ihosting_header_banner_setting' ) ) {
	function ihosting_header_banner_setting() {
		global $ihosting;

		$header_banner_settings = array(
			'show_page_heading'      => isset( $ihosting['opt_show_page_heading'] ) ? $ihosting['opt_show_page_heading'] == 1 : true,
			'heading_html'           => '',
			'show_breadcrumbs'       => isset( $ihosting['opt_show_breadcrumbs'] ) ? $ihosting['opt_show_breadcrumbs'] == 1 : true,
			'breadcrumbs_html'       => '',
			'show_page_banner'       => isset( $ihosting['opt_show_page_banner'] ) ? $ihosting['opt_show_page_banner'] == 1 : true,
			'banner_bg_custom_style' => '', // For custom banner background only
			'height'                 => isset( $ihosting['opt_heading_banner_height'] ) ? intval( $ihosting['opt_heading_banner_height'] ) . 'px' : '215px',
			'class'                  => ''
		);

		$post_id = ihosting_get_current_page_id();

		$custom_show_heading = get_post_meta( $post_id, '_ihosting_show_heading', true );
		$custom_show_breadcrumb = get_post_meta( $post_id, '_ihosting_show_breadcrumb', true );
		$custom_show_banner = get_post_meta( $post_id, '_ihosting_show_banner', true );

		$is_custom_heading = $post_id > 0 && $custom_show_heading != 'global' && trim( $custom_show_heading ) != '';
		$is_custom_breadcrumb = $post_id > 0 && $custom_show_breadcrumb != 'global' && trim( $custom_show_breadcrumb ) != '';
		$is_custom_banner = $post_id > 0 && $custom_show_banner != 'global' && trim( $custom_show_banner ) != '';

		// Is custom heading (custom show/hide, color)
		if ( $is_custom_heading ) {
			$header_banner_settings['show_page_heading'] = $custom_show_heading == 'show';
		}

		// Is custom breadcrumb (custom show/hide, color)
		if ( $is_custom_breadcrumb ) {
			$header_banner_settings['show_breadcrumbs'] = $custom_show_breadcrumb == 'show';
		}

		// Is custom page banner bg
		if ( $is_custom_banner ) {
			$header_banner_settings['show_page_banner'] = $custom_show_banner == 'show';

			if ( $header_banner_settings['show_page_banner'] ) {
				$bg_color = get_post_meta( $post_id, '_ihosting_banner_bg_color', true );
				$bg_img_id = get_post_meta( $post_id, '_ihosting_banner_bg_img_id', true );
				$bg_img_repeat = get_post_meta( $post_id, '_ihosting_banner_bg_repeat', true );
				$bg_img_attachment = get_post_meta( $post_id, '_ihosting_banner_bg_attachment', true );
				$bg_img_align = get_post_meta( $post_id, '_ihosting_banner_bg_align', true );
				$banner_height = str_replace( 'px', '', get_post_meta( $post_id, '_ihosting_banner_height', true ) );

				// Get full image size? 9999x9999 is large enough, may be :v
				$bg_img = ihosting_resize_image( $bg_img_id, null, 9999, 9999, false, false, false );

				$header_banner_settings['banner_bg_custom_style'] .= 'background: url("' . esc_url( $bg_img['url'] ) . '") ' . esc_attr( $bg_img_repeat ) . ' ' . esc_attr( $bg_img_align ) . ' ' . esc_attr( $bg_img_attachment ) . ' ' . esc_attr( $bg_color ) . ';';
				$header_banner_settings['height'] = intval( $banner_height ) . 'px';
			}
		}

		// Get page/archive title
		if ( $post_id > 0 ) {
			$header_banner_settings['title'] = get_the_title( $post_id );
		}
		else {
			$header_banner_settings['title'] = get_the_archive_title();
		}


		if ( $header_banner_settings['show_page_heading'] ) {
			$header_banner_settings['class'] .= ' has-heading';
			if ( $is_custom_heading ) {
				$heading_color = get_post_meta( $post_id, 'opt_breadcrumbs_color', true );
				$header_banner_settings['heading_html'] = '<h1 class="page-heading ih-page-heading ih-text-mid ih-custom-heading" style="color: ' . esc_attr( $heading_color ) . ';">' . esc_html( $header_banner_settings['title'] ) . '</h1>';
			}
			else {
				$header_banner_settings['heading_html'] = '<h1 class="page-heading ih-page-heading ih-text-mid">' . esc_html( $header_banner_settings['title'] ) . '</h1>';
			}
		}

		if ( $header_banner_settings['show_breadcrumbs'] ) {
			$header_banner_settings['class'] .= ' has-breadcrumbs';

			if ( $is_custom_breadcrumb ) {
				$breadcrumb_color = get_post_meta( $post_id, '_ihosting_breadcrumb_color', true );
				$header_banner_settings['breadcrumbs_html'] = '<div class="breadcrumb-wrap ih-breadcrumb-wrap ih-text-mid-right" style="color: ' . esc_attr( $breadcrumb_color ) . ' ;"><div class="ih-breadcrumb-inner">';
				ob_start();
				get_template_part( 'template-parts/breadcrumb' );
				$header_banner_settings['breadcrumbs_html'] .= ob_get_clean();
				$header_banner_settings['breadcrumbs_html'] .= '</div></div>';
			}
			else {
				$header_banner_settings['breadcrumbs_html'] = '<div class="breadcrumb-wrap ih-breadcrumb-wrap ih-text-mid-right"><div class="ih-breadcrumb-inner">';
				ob_start();
				get_template_part( 'template-parts/breadcrumb' );
				$header_banner_settings['breadcrumbs_html'] .= ob_get_clean();
				$header_banner_settings['breadcrumbs_html'] .= '</div></div>';
			}
		}

		if ( $header_banner_settings['show_page_banner'] ) {
			$header_banner_settings['class'] .= ' has-bg';
		}
		else {
			$header_banner_settings['height'] = 'auto';
		}

		$header_banner_settings['class'] = trim( $header_banner_settings['class'] );

		return $header_banner_settings;

	}
}

if ( !function_exists( 'ihosting_get_footer_settings' ) ) {
	/**
	 * Get footer settings
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	function ihosting_get_footer_settings() {
		global $ihosting;

		$footer_settings = array();

		//$footer_logo = isset( $ihosting['opt_footer_logo'] ) ? $ihosting['opt_footer_logo'] : array( 'url' => get_template_directory_uri() . '/assets/images/logo-footer.png' );

		$footer_settings['bg_color'] = isset( $ihosting['opt_footer_bg_color'] ) ? $ihosting['opt_footer_bg_color'] : '#141414';
		$footer_settings['bg_color'] = isset( $footer_settings['bg_color']['rgba'] ) ? $footer_settings['bg_color']['rgba'] : '#141414';

		$footer_mid_has_social_links = isset( $ihosting['opt_show_footer_social_links'] ) ? $ihosting['opt_show_footer_social_links'] == 1 : false;
		$footer_mid_has_copy_right = false;

		$footer_copyright_text = isset( $ihosting['opt_footer_copyright_text'] ) ? $ihosting['opt_footer_copyright_text'] : sprintf( esc_html__( 'Proudly powered by %s', 'ihosting' ), 'WordPress' );
		$footer_settings['footer_content_id'] = isset( $ihosting['opt_footer_layout_content'] ) ? intval( $ihosting['opt_footer_layout_content'] ) : 0;

		if ( trim( $footer_copyright_text ) != '' ) {
			$footer_mid_has_copy_right = true;
		}

		$footer_settings['footer_enable_mid'] = isset( $ihosting['opt_enable_footer_mid'] ) ? $ihosting['opt_enable_footer_mid'] == 1 : true;
		$footer_settings['footer_enable_bottom'] = isset( $ihosting['opt_enable_footer_bottom'] ) ? $ihosting['opt_enable_footer_bottom'] == 1 : true;

		// For custom Footer (static home page, blog page, single post, page, product...)
		$post_id = 0; // Post, page or post type... id

		if ( is_front_page() && is_home() ) {
			// Default homepage
			// Current version of theme does not support custom footer for search results, default home page, global setting will be used
		}
		elseif ( is_front_page() ) {
			// static homepage
			$post_id = get_option( 'page_on_front' );
		}
		elseif ( is_home() ) {
			// blog page
			$post_id = get_option( 'page_for_posts' );
		}
		else {
			// Everything else

			// Is a singular
			if ( is_singular() ) {
				$post_id = get_the_ID();
			}
			else {
				// Is archive or taxonomy
				if ( is_archive() ) {

					// Category
					if ( is_category() ) {

					}

					// Checking for shop archive
					if ( function_exists( 'is_shop' ) ) { // Products archive, products category, products search page...
						if ( is_shop() ) {
							$post_id = get_option( 'woocommerce_shop_page_id' );
						}
						if ( is_product_category() ) {
							// Current version of theme does not support custom footer for taxonomy, global setting will be used
						}
					}

				}
				else {
					if ( is_404() ) {
						// Current version of theme does not support custom footer for 404 page, global setting will be used
					}
					else {
						if ( is_search() ) {

						}
						else {
							// Is category, is tag, is tax
							// Current version of theme does not support custom footer for search results, category, tag, tax.., global setting will be used
						}
					}
				}

			}

			// Other WooCommerce pages
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_cart() ) {
					$post_id = wc_get_page_id( 'cart' );
				}
				if ( is_checkout() ) {
					$post_id = wc_get_page_id( 'checkout' );
				}
				if ( is_account_page() ) {
					$post_id = wc_get_page_id( 'myaccount' );
				}
			}

		}

		// Custom Footer
		$is_custom_footer = get_post_meta( $post_id, '_ihosting_enable_custom_footer', true ) == 'custom'; // custom, global

		if ( $is_custom_footer ) {

			$footer_settings['bg_color'] = get_post_meta( $post_id, '_ihosting_footer_bg_color', true );

			$footer_bottom_layout = get_post_meta( $post_id, '_ihosting_footer_layout', true );
			$is_custom_footer_bottom_layout = $footer_bottom_layout != 'global' && $footer_bottom_layout != '';

			if ( $is_custom_footer_bottom_layout ) {
				$footer_settings['footer_content_id'] = $footer_bottom_layout;
			}

			$footer_settings['footer_enable_mid'] = get_post_meta( $post_id, '_ihosting_footer_enable_mid', true ) == 'enable'; // enable, disable
			$footer_copyright_text = get_post_meta( $post_id, '_ihosting_footer_mid_text', true );
			if ( trim( $footer_copyright_text ) != '' ) {
				$footer_mid_has_copy_right = true;
			}

		}


		$footer_settings['footer_content'] = '';
		if ( $footer_settings['footer_content_id'] > 0 ) {
			$footer_post = get_post( $footer_settings['footer_content_id'] );
			//$footer_settings['footer_content'] = apply_filters( 'the_content', $footer_post->post_content );
			$footer_settings['footer_content'] = do_shortcode( $footer_post->post_content );
		}

		$footer_mid_part_class = 'col-xs-12';
		if ( $footer_mid_has_social_links && $footer_mid_has_copy_right ) {
			$footer_mid_part_class .= ' col-sm-6';
		}

		$footer_settings['social_links_html'] = '';
		if ( $footer_mid_has_social_links ) {
			$footer_mid_part_class .= ' has-social-links';
			$footer_settings['social_links_html'] .= '<div class="kt-social-footer-wrap ' . esc_attr( $footer_mid_part_class ) . '">';
			ob_start();
			get_template_part( 'template-parts/socials', 'footer' );
			$footer_settings['social_links_html'] .= ob_get_clean();
			$footer_settings['social_links_html'] .= '</div> <!-- /.kt-social-footer-wrap -->';
		}
		$footer_settings['footer_copyright_text'] = '<div class="copyright-wrap ' . esc_attr( $footer_mid_part_class ) . '"><div class="copyright">' . wptexturize( $footer_copyright_text ) . '</div></div>';

		$footer_settings['footer_bottom_text'] = isset( $ihosting['opt_footer_bottom_text'] ) ? '<div class="footer-bottom-text col-xs-12">' . sanitize_text_field( $ihosting['opt_footer_bottom_text'] ) . '</div>' : '';


		return $footer_settings;
	}
}

if ( !function_exists( 'ihosting_breadcrumb' ) ) {
	function ihosting_breadcrumb( $setting = array() ) {
		if ( !function_exists( 'breadcrumb_trail' ) ) {
			return;
		}

		if ( function_exists( 'is_woocommerce' ) ) {
			if ( is_woocommerce() ) {
				woocommerce_breadcrumb();

				return;
			}
		}

		$defaults_setting = array(
			'container'     => 'nav',
			'before'        => '',
			'after'         => '',
			'show_on_front' => false,
			'network'       => false,
			'show_title'    => true,
			'show_browse'   => true,
			'echo'          => true,
			'post_taxonomy' => array(),
			'labels'        => array(
				'browse'              => '',
				'aria_label'          => esc_attr_x( 'Breadcrumbs', 'breadcrumbs aria label', 'ihosting' ),
				'home'                => esc_html__( 'Home', 'ihosting' ),
				'error_404'           => esc_html__( '404 Not Found', 'ihosting' ),
				'archives'            => esc_html__( 'Archives', 'ihosting' ), // Translators: %s is the search query. The HTML entities are opening and closing curly quotes.
				'search'              => esc_html__( 'Search results for &#8220;%s&#8221;', 'ihosting' ), // Translators: %s is the page number.
				'paged'               => esc_html__( 'Page %s', 'ihosting' ), // Translators: Minute archive title. %s is the minute time format.
				'archive_minute'      => esc_html__( 'Minute %s', 'ihosting' ), // Translators: Weekly archive title. %s is the week date format.
				'archive_week'        => esc_html__( 'Week %s', 'ihosting' ),

				// "%s" is replaced with the translated date/time format.
				'archive_minute_hour' => '%s', 'archive_hour' => '%s', 'archive_day' => '%s', 'archive_month' => '%s', 'archive_year' => '%s',
			),
		);

		$setting = wp_parse_args( $setting, $defaults_setting );
		breadcrumb_trail( $setting );
	}
}

if ( !function_exists( 'ihosting_cat_count_span' ) ) {
	function ihosting_cat_count_span( $links ) {
		$links = str_replace( '</a> (', ' <span class="count">(', $links );
		$links = str_replace( ')', ')</span></a>', $links );

		return $links;
	}

	add_filter( 'wp_list_categories', 'ihosting_cat_count_span' );
}

if ( !function_exists( 'ihosting_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	function ihosting_body_classes( $classes ) {
		// Adds a class ihosting-body
		if ( is_multi_author() ) {
			$classes[] = ' ihosting-body';
		}

		return $classes;
	}

	add_filter( 'body_class', 'ihosting_body_classes' );
}

if ( !function_exists( 'ihosting_favicon' ) ) {

	/**
	 * Custom favicon
	 **/
	function ihosting_favicon() {
		global $ihosting;

		if ( !function_exists( 'has_site_icon' ) || !has_site_icon() ) {
			$favicon = isset( $ihosting['opt_general_favicon']['url'] ) ? $ihosting['opt_general_favicon']['url'] : get_template_directory_uri() . '/assets/images/favicon.png';
			if ( trim( $favicon ) != '' ) {
				echo '<link rel="shortcut icon" href="' . esc_url( $favicon ) . '" />', "\n";
			}
		}
	}

	add_action( 'wp_head', 'ihosting_favicon', 2 );

}

if ( !function_exists( 'ihosting_custom_js' ) ) {

	/**
	 * Custom js
	 **/
	function ihosting_custom_js() {
		global $ihosting;

		$script = '';
		if ( isset( $ihosting['opt_general_js_code'] ) ) {
			$script .= stripslashes( $ihosting['opt_general_js_code'] );
		}

		$custom_js = 'jQuery(document).ready(function($){
		                    ' . stripslashes( $script ) . '
		                });';

		// Add inline script to "ihosting-frontend"
		wp_add_inline_script( 'ihosting-frontend', $custom_js );
	}

	add_action( 'wp_enqueue_scripts', 'ihosting_custom_js', 21 );

}

if ( !function_exists( 'ihosting_rev_slide_options_for_redux' ) ) {
	function ihosting_rev_slide_options_for_redux() {
		$ihosting_herosection_revolutions = array( '' => esc_html__( '--- Choose Revolution Slider ---', 'ihosting' ) );
		if ( class_exists( 'RevSlider' ) ) {
			global $wpdb;
			if ( shortcode_exists( 'rev_slider' ) ) {
				$rev_sql = $wpdb->prepare(
					"SELECT *
                    FROM {$wpdb->prefix}revslider_sliders
                    WHERE %d", 1
				);
				$rev_rows = $wpdb->get_results( $rev_sql );
				if ( count( $rev_rows ) > 0 ) {
					foreach ( $rev_rows as $rev_row ):
						$ihosting_herosection_revolutions[$rev_row->alias] = $rev_row->title;
					endforeach;
				}
			}
		}

		return $ihosting_herosection_revolutions;
	}
}

if ( !function_exists( 'ihosting_language_switcher_flags_list' ) ) {
	function ihosting_language_switcher_flags_list( $wrap = 'div', $class = '' ) {
		global $sitepress;
		$html = '';

		$allowed_wraps = array( 'div', 'li' );

		if ( !in_array( $wrap, $allowed_wraps ) ) {
			$wrap = 'div';
		}

		if ( function_exists( 'wpml_get_active_languages_filter' ) ) {
			$languages = wpml_get_active_languages_filter( 'skip_missing=0' );

			if ( isset( $languages[ICL_LANGUAGE_CODE] ) ) {
				$html .= '<div class="country select">
                                <img src="' . esc_url( $languages[ICL_LANGUAGE_CODE]['country_flag_url'] ) . '" height="12" alt="' . esc_attr( $languages[ICL_LANGUAGE_CODE]['language_code'] ) . '" width="18" />
                                ' . esc_html( $languages[ICL_LANGUAGE_CODE]['native_name'] ) . '
                            </div>';
			}

			if ( 1 <= count( $languages ) ) {
				$html .= '<div class="country-dropdown" style="display: none;">';
				foreach ( $languages as $l ) {
					//$class = ICL_LANGUAGE_CODE == $l[ 'language_code' ] ? 'current-lang lang-switcher-li' : 'lang-switcher-li';

					if ( $l['language_code'] != ICL_LANGUAGE_CODE ) {
						$html .= '<div class="country">
									<a href="' . esc_url( $l['url'] ) . '">
										<img src="' . esc_url( $l['country_flag_url'] ) . '" height="12" alt="' . esc_attr( $l['language_code'] ) . '" width="18" />
										' . esc_html( $l['native_name'] ) . '
									</a>
                                </div>';
					}
				}
				$html .= '</div><!-- /.country-dropdown -->';
				$html .= '<span class="click-country fa fa-caret-down"></span>';
			}
		}

		$class = esc_attr( $class ) . ' ih-language-switcher-wrap';

		if ( trim( $html ) != '' ) {
			$html = '<' . esc_attr( $wrap ) . ' class="' . esc_attr( $class ) . '">' . wptexturize( $html ) . '</' . esc_attr( $wrap ) . '>';
		}

		return $html;
	}
}


if ( !function_exists( 'ihosting_currency_switcher' ) ) {
	function ihosting_currency_switcher() {
		$html = '';

		if ( shortcode_exists( 'currency_switcher' ) ) {
			$html .= '<div class="currency-switcher-wrap">';
			$html .= '<h4 class="title">' . esc_html__( 'Select your currency:', 'ihosting' ) . '</h4>';
			$html .= do_shortcode( '[currency_switcher]' );
			$html .= '</div><!-- /.currency-switcher-wrap -->';
		}

		return $html;
	}
}

if ( !function_exists( 'ihosting_get_the_excerpt_max_charlength' ) ) {

	function ihosting_get_the_excerpt_max_charlength( $charlength ) {
		if ( post_password_required() ) {
			return '';
		}

		$excerpt = get_the_excerpt();
		$charlength++;

		if ( mb_strlen( $excerpt ) <= $charlength ) {
			$excerpt = strip_tags( get_the_content() );
		}

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = -( mb_strlen( $exwords[count( $exwords ) - 1] ) );
			if ( $excut < 0 ) {
				$subex = mb_substr( $subex, 0, $excut );
			}
			$subex .= '...';
			$excerpt = $subex;
		}

		return $excerpt;
	}

}

if ( !function_exists( 'ihosting_get_img_alt' ) ) {
	function ihosting_get_img_alt( $img_id = 0 ) {
		$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
		if ( trim( $alt ) == '' && (int)$img_id > 0 ) {
			$img_src = wp_get_attachment_image_src( $img_id, 'full' );
			if ( !empty( $img_src ) ) {
				$alt = wp_basename( $img_src[0] );
			}
		}

		return esc_attr( $alt );
	}
}

if ( !function_exists( 'ihosting_main_container_class' ) ) {
	function ihosting_main_container_class() {
		global $ihosting;

		$class = 'main-container';

		if ( is_front_page() && is_home() ) {
			// Default homepage

		}
		elseif ( is_front_page() ) {
			// static homepage

		}
		elseif ( is_home() ) {
			// blog page
			$class .= ' page-blog';

		}
		else {
			//everything else

			// Is a singular
			if ( is_singular() ) {
				if ( is_singular( 'post' ) ) {
					$class .= ' page-blog page-blog-single';
				}
			}
			else {
				// Is archive or taxonomy
				if ( is_archive() ) {
					$title = post_type_archive_title( '', false );

					// Checking for shop archive
					if ( function_exists( 'is_shop' ) ) { // Products archive, products category, products search page...
						if ( is_shop() ) {
							$sidebar_pos = isset( $ihosting['woo_shop_sidebar_pos'] ) ? trim( $ihosting['woo_shop_sidebar_pos'] ) : 'right';
							if ( $sidebar_pos == 'fullwidth' ) {
								$class .= ' page-shop-no-sidebar';
							}
							else {
								$class .= ' page-shop-sidebar' . esc_attr( $sidebar_pos );
							}
						}
						if ( is_product() ) {
							$sidebar_pos = isset( $ihosting['woo_single_product_sidebar_pos'] ) ? trim( $ihosting['woo_single_product_sidebar_pos'] ) : 'right';
							$class .= ' page-single-product';
						}
					}
				}
				else {
					if ( is_search() ) {
						$class .= ' page-search-results';
					}
				}

				// Is WooCommerce page
				if ( function_exists( 'is_woocommerce' ) ) {
					if ( is_woocommerce() ) {

					}
				}

			}
		}

		return esc_attr( $class );
	}
}

if ( !function_exists( 'ihosting_primary_class' ) ) {

	/**
	 * Add class to #primary
	 *
	 * @return string
	 **/
	function ihosting_primary_class( $class = '' ) {
		global $ihosting;

		$sidebar_pos = isset( $ihosting['opt_blog_sidebar_pos'] ) ? trim( $ihosting['opt_blog_sidebar_pos'] ) : 'right';

		if ( $sidebar_pos == 'fullwidth' ) {
			$class .= ' col-xs-12 no-sidebar content-area-full-width';
		}
		else {
			$class .= ' col-xs-12 col-sm-8 col-md-9 has-sidebar has-sidebar-' . esc_attr( $sidebar_pos );
		}

		return esc_attr( $class );

	}

}

if ( !function_exists( 'ihosting_secondary_class' ) ) {

	/**
	 * Add class to #secondary
	 *
	 * @return string
	 **/
	function ihosting_secondary_class( $class = '' ) {
		global $ihosting;

		$sidebar_pos = isset( $ihosting['opt_blog_sidebar_pos'] ) ? trim( $ihosting['opt_blog_sidebar_pos'] ) : 'right';

		if ( $sidebar_pos == 'fullwidth' ) {
			$class .= ' col-xs-12 secondary-fullwidth';
		}
		else {
			$class .= ' col-xs-12 col-sm-4 col-md-3 sidebar sidebar-' . esc_attr( $sidebar_pos );
		}

		return esc_attr( $class );

	}

}

if ( !function_exists( 'ihosting_shop_primary_class' ) ) {

	/**
	 * Add class to #primary
	 *
	 * @return string
	 **/
	function ihosting_shop_primary_class( $class = '' ) {
		global $ihosting;

		$sidebar_pos = isset( $ihosting['woo_shop_sidebar_pos'] ) ? trim( $ihosting['woo_shop_sidebar_pos'] ) : 'right';

		if ( is_product() ) {
			$sidebar_pos = isset( $ihosting['woo_single_product_sidebar_pos'] ) ? trim( $ihosting['woo_single_product_sidebar_pos'] ) : 'right';
		}

		if ( $sidebar_pos == 'fullwidth' ) {
			$class .= ' col-xs-12 primary-fullwidth';
			if ( is_product() ) {
				$class .= ' primary-single-product';
			}
		}
		else {
			$class .= ' primary-area col-xs-12 col-sm-8 col-md-9 has-sidebar has-sidebar-' . esc_attr( $sidebar_pos );
		}

		return esc_attr( $class );

	}

}

if ( !function_exists( 'ihosting_shop_secondary_class' ) ) {

	/**
	 * Add class to #secondary
	 *
	 * @return string
	 **/
	function ihosting_shop_secondary_class( $class = '' ) {
		global $ihosting;

		$sidebar_pos = isset( $ihosting['woo_shop_sidebar_pos'] ) ? trim( $ihosting['woo_shop_sidebar_pos'] ) : 'right';
		if ( is_product() ) {
			$sidebar_pos = isset( $ihosting['woo_single_product_sidebar_pos'] ) ? trim( $ihosting['woo_single_product_sidebar_pos'] ) : 'right';
		}

		if ( $sidebar_pos == 'fullwidth' ) {
			$class .= ' col-xs-12';
		}
		else {
			$class .= ' col-xs-12 col-sm-4 col-md-3 sidebar sidebar-' . esc_attr( $sidebar_pos );
		}

		return esc_attr( $class );

	}

}

if ( !function_exists( 'ihosting_search_form' ) ) {

	/*
	 * Filter Search form
	*/
	function ihosting_search_form( $form ) {

		$key = get_search_query();

		$form = '<form class="lk-search-form search-form" method="get" action="' . esc_url( home_url( '/' ) ) . '" >
                  <input type="search" value="' . esc_attr( $key ) . '" placeholder="' . esc_html__( 'Type and hit enter...', 'ihosting' ) . '" class="search" name="s">
                  <span><button type="submit" class="search-submit"><i class="icon icon-arrows-slide-right2"></i></button></span>
                </form>';

		return $form;
	}

	add_filter( 'get_search_form', 'ihosting_search_form' );

}

if ( !function_exists( 'ihosting_tax_dropdown' ) ) {
	function ihosting_tax_dropdown( &$terms_select_opts = array(), $taxonomy, $parent = 0, $lv = 0 ) {
		// Function "ihosting_custom_taxonomy_opt_walker" locate in Lucky Shop Core plugin
		return function_exists( 'ihosting_custom_taxonomy_opt_walker' ) ? ihosting_custom_taxonomy_opt_walker( $terms_select_opts, $taxonomy, $parent = 0, $lv = 0 ) : '';
	}
}
if ( !function_exists( 'ihosting_product_cats_dropdown' ) ) {
	function ihosting_product_cats_dropdown( $selected_procat_slugs = array(), $settings = array() ) {
		$default_settings = array(
			'multiple'          => false,
			'id'                => '',
			'name'              => 'product_cat',
			'class'             => '',
			'first_option'      => true,
			'first_select_val'  => '',
			'first_select_text' => esc_html__( ' --- All Categories --- ', 'ihosting' )
		);

		$settings = wp_parse_args( $settings, $default_settings );

		// Function "ihosting_procats_select" locate in Lucky Shop Core plugin
		return function_exists( 'ihosting_procats_slug_select' ) ? ihosting_procats_slug_select( $selected_procat_slugs, $settings ) : '';
	}
}

if ( !function_exists( 'ihosting_custom_login' ) ) {

	/**
	 * Custom login inherit from wp_login_form
	 **/

	/**
	 * Provides a simple login form for use anywhere within WordPress. By default, it echoes
	 * the HTML immediately. Pass array('echo'=>false) to return the string instead.
	 *
	 * @since 3.0.0
	 *
	 * @param array $args Configuration options to modify the form output.
	 *
	 * @return string|null String when retrieving, null when displaying.
	 */
	function ihosting_custom_login( $args = array() ) {
		$defaults = array(
			'echo'                => true,
			'redirect'            => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // Default redirect is back to the current page
			'form_id'             => 'loginform',
			'label_username'      => esc_html__( 'Username', 'ihosting' ),
			'label_password'      => esc_html__( 'Password', 'ihosting' ),
			'label_remember'      => esc_html__( 'Remember Me', 'ihosting' ),
			'label_log_in'        => esc_html__( 'Log In', 'ihosting' ),
			'id_username'         => 'user_login',
			'id_password'         => 'user_pass',
			'id_remember'         => 'rememberme',
			'id_submit'           => 'wp-submit',
			'remember'            => true,
			'value_username'      => '',
			'value_remember'      => false, // Set this to true to default the "Remember me" checkbox to checked
			'lost_pass_link'      => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // Default redirect is back to the current page
			'show_lost_pass_link' => true,
			'show_register_link'  => true,
		);

		/**
		 * Filter the default login form output arguments.
		 *
		 * @since 3.0.0
		 *
		 * @see   wp_login_form()
		 *
		 * @param array $defaults An array of default login form arguments.
		 */
		$args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );

		/**
		 * Filter content to display at the top of the login form.
		 *
		 * The filter evaluates just following the opening form tag element.
		 *
		 * @since 3.0.0
		 *
		 * @param string $content Content to display. Default empty.
		 * @param array  $args    Array of login form arguments.
		 */
		$login_form_top = apply_filters( 'login_form_top', '', $args );

		/**
		 * Filter content to display in the middle of the login form.
		 *
		 * The filter evaluates just following the location where the 'login-password'
		 * field is displayed.
		 *
		 * @since 3.0.0
		 *
		 * @param string $content Content to display. Default empty.
		 * @param array  $args    Array of login form arguments.
		 */
		$login_form_middle = apply_filters( 'login_form_middle', '', $args );

		/**
		 * Filter content to display at the bottom of the login form.
		 *
		 * The filter evaluates just preceding the closing form tag element.
		 *
		 * @since 3.0.0
		 *
		 * @param string $content Content to display. Default empty.
		 * @param array  $args    Array of login form arguments.
		 */
		$login_form_bottom = apply_filters( 'login_form_bottom', '', $args );

		$lost_pass_link = '';
		if ( $args['show_lost_pass_link'] === true ) {
			$lost_pass_link = '<a class="lost-pass-link" href="' . esc_url( wp_lostpassword_url( get_permalink() ) ) . '" title="' . esc_html__( 'Forgot Your Password', 'ihosting' ) . '">' . esc_html__( 'Forgot Your Password', 'ihosting' ) . '</a>';
		}

		$register_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$register_url = esc_url( add_query_arg( array( 'action' => 'register' ), $register_url ) );

		$form = '
    		<form name="' . esc_attr( $args['form_id'] ) . '" id="' . esc_attr( $args['form_id'] ) . '" class="login-form" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post">
    			' . $login_form_top . '
    			<div class="login-username form-group">
    				<label for="' . esc_attr( $args['id_username'] ) . '" class="lb-user-login">' . esc_html( $args['label_username'] ) . '</label>
    				<input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="input form-control" value="' . esc_attr( $args['value_username'] ) . '" size="20" />
    			</div><!-- /.login-username -->
    			<div class="login-password form-group">
    				<label for="' . esc_attr( $args['id_password'] ) . '" class="lb-user-pw">' . esc_html( $args['label_password'] ) . '</label>
    				<input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="input form-control" value="" size="20" />
    			</div><!-- /.login-password -->
                <div class="login-submit form-group">
                    <button type="submit">' . sanitize_text_field( $args['label_log_in'] ) . '</button>
    				<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
    			</div><!-- /.login-submit -->
    			' . $login_form_middle . '
                <div class="bottom-login">
    			' . ( $args['remember'] ? '<div class="checkbox-remember"><label class="lb-remember"><input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . '</label></div>' : '' ) . '
                ' . $lost_pass_link . '
                ' . wp_nonce_field( 'ajax-login-nonce', 'login-ajax-nonce', true, false ) . '
                </div><!-- /.bottom-login -->
    			' . $login_form_bottom . '
    		</form>';

		if ( $args['echo'] ) {
			echo wptexturize( $form );
		}
		else {
			return wptexturize( $form );
		}

	}

}


if ( !function_exists( 'ihosting_coming_soon_redirect' ) ) {
	function ihosting_coming_soon_redirect() {
		global $ihosting;

		$is_coming_soon_mode = isset( $ihosting['opt_enable_coming_soon_mode'] ) ? $ihosting['opt_enable_coming_soon_mode'] == '1' : false;
		$disable_if_date_smaller_than_current = isset( $ihosting['opt_disable_coming_soon_when_date_small'] ) ? $ihosting['opt_disable_coming_soon_when_date_small'] == '1' : false;
		$coming_date = isset( $ihosting['opt_coming_soon_date'] ) ? $ihosting['opt_coming_soon_date'] : '';

		$today = date( 'm/d/Y' );

		if ( trim( $coming_date ) == '' || strtotime( $coming_date ) <= strtotime( $today ) ) {
			if ( $disable_if_date_smaller_than_current ) {
				$is_coming_soon_mode = false;
			}
		}

		// Dont't show coming soon page if is user logged in or is not coming soon mode on
		if ( is_user_logged_in() || !$is_coming_soon_mode ) {
			return;
		}

		ihosting_coming_soon_html(); // Locate in theme_coming_soon_template.php

		exit();
	}

	add_action( 'template_redirect', 'ihosting_coming_soon_redirect' );
}

if ( !function_exists( 'ihosting_coming_soon_mode_admin_toolbar' ) ) {
	// Add Toolbar Menus
	function ihosting_coming_soon_mode_admin_toolbar() {
		global $wp_admin_bar, $ihosting;

		$is_coming_soon_mode = isset( $ihosting['opt_enable_coming_soon_mode'] ) ? $ihosting['opt_enable_coming_soon_mode'] == '1' : false;
		$disable_if_date_smaller_than_current = isset( $ihosting['opt_disable_coming_soon_when_date_small'] ) ? $ihosting['opt_disable_coming_soon_when_date_small'] == '1' : false;
		$coming_date = isset( $ihosting['opt_coming_soon_date'] ) ? $ihosting['opt_coming_soon_date'] : '';

		$today = date( 'm/d/Y' );

		if ( trim( $coming_date ) == '' || strtotime( $coming_date ) <= strtotime( $today ) ) {
			if ( $disable_if_date_smaller_than_current && $is_coming_soon_mode ) {
				$is_coming_soon_mode = false;
				$menu_item_class = 'ihosting_coming_soon_expired';
				if ( current_user_can( 'administrator' ) ) { // Coming soon expired

					$date = isset( $ihosting['opt_coming_soon_date'] ) ? $ihosting['opt_coming_soon_date'] : date();

					$args = array(
						'id'     => 'ihosting_coming_soon',
						'parent' => 'top-secondary',
						'title'  => esc_html__( 'Coming Soon Mode Expired', 'ihosting' ),
						'href'   => esc_url( admin_url( 'themes.php?page=ihosting_options' ) ),
						'meta'   => array(
							'class' => 'ihosting_coming_soon_expired',
							'title' => esc_html__( 'Coming soon mode is actived but expired', 'ihosting' ),
						),
					);
					$wp_admin_bar->add_menu( $args );
				}
			}
		}

		if ( current_user_can( 'administrator' ) && $is_coming_soon_mode ) {

			$date = isset( $ihosting['opt_coming_soon_date'] ) ? $ihosting['opt_coming_soon_date'] : date();

			$args = array(
				'id'     => 'ihosting_coming_soon',
				'parent' => 'top-secondary',
				'title'  => esc_html__( 'Coming Soon Mode', 'ihosting' ),
				'href'   => esc_url( admin_url( 'themes.php?page=ihosting_options' ) ),
				'meta'   => array(
					'class' => 'ihosting_coming_soon ihosting-countdown-wrap countdown-admin-menu ihosting-cms-date_' . esc_attr( $date ),
					'title' => esc_html__( 'Coming soon mode is actived', 'ihosting' ),
				),
			);
			$wp_admin_bar->add_menu( $args );
		}

	}

	add_action( 'wp_before_admin_bar_render', 'ihosting_coming_soon_mode_admin_toolbar', 999 );
}

if ( !function_exists( 'ihosting_wp_title' ) ) {

	/*
	 * WP title
	*/
	function ihosting_wp_title( $title, $separator ) {
		global $ihosting;

		if ( is_feed() ) {
			return $title;
		}

		$is_coming_soon_mode = isset( $ihosting['opt_enable_coming_soon_mode'] ) ? $ihosting['opt_enable_coming_soon_mode'] == '1' : false;

		if ( !current_user_can( 'administrator' ) && $is_coming_soon_mode ) {
			$title = isset( $ihosting['opt_coming_soon_site_title'] ) ? $ihosting['opt_coming_soon_site_title'] : $title;
		}
		else {
			return $title;
		}

		return $title;
	}

	add_filter( 'wp_title', 'ihosting_wp_title', 10, 2 );

}


/** FUNCTIONS FOR WOOCOMMERCE ======================================= **/

if ( !function_exists( 'ihosting_wc_get_item_data' ) ) {
	/**
	 * Gets and formats a list of cart item data + variations for display on the frontend.
	 *
	 * @param array $cart_item
	 * @param bool  $flat (default: false)
	 *
	 * @return string
	 */
	function ihosting_wc_get_item_data( $cart_item, $flat = false ) {
		$item_data = array();

		// Variation data
		if ( !empty( $cart_item['data']->variation_id ) && is_array( $cart_item['variation'] ) ) {

			foreach ( $cart_item['variation'] as $name => $value ) {

				if ( '' === $value )
					continue;

				$taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );
				$additional_attr = '';

				// If this is a term slug, get the term's nice name
				if ( taxonomy_exists( $taxonomy ) ) {
					$term = get_term_by( 'slug', $value, $taxonomy );
					if ( !is_wp_error( $term ) && $term && $term->name ) {
						$value = $term->name;
					}
					$label = wc_attribute_label( $taxonomy );

					if ( $taxonomy == 'pa_color' ) {
						$data_color = 'transparent';
						if ( function_exists( 'get_tax_meta' ) ) {
							$data_color = trim( get_tax_meta( $term->term_id, 'ihosting_color' ) ) != '' ? get_tax_meta( $term->term_id, 'ihosting_color' ) : 'transparent';
						}
						$additional_attr = $data_color;
					}

					// If this is a custom option slug, get the options name
				}
				else {
					$value = apply_filters( 'woocommerce_variation_option_name', $value );
					$product_attributes = $cart_item['data']->get_attributes();
					if ( isset( $product_attributes[str_replace( 'attribute_', '', $name )] ) ) {
						$label = wc_attribute_label( $product_attributes[str_replace( 'attribute_', '', $name )]['name'] );
					}
					else {
						$label = $name;
					}
				}

				$item_data[] = array(
					'key'             => $label,
					'value'           => $value,
					'additional_attr' => $additional_attr
				);
			}
		}

		// Filter item data to allow 3rd parties to add more to the array
		$item_data = apply_filters( 'woocommerce_get_item_data', $item_data, $cart_item );

		// Format item data ready to display
		foreach ( $item_data as $key => $data ) {
			// Set hidden to true to not display meta on cart.
			if ( !empty( $data['hidden'] ) ) {
				unset( $item_data[$key] );
				continue;
			}
			$item_data[$key]['key'] = !empty( $data['key'] ) ? $data['key'] : $data['name'];
			$item_data[$key]['display'] = !empty( $data['display'] ) ? $data['display'] : $data['value'];
		}

		// Output flat or in list format
		if ( sizeof( $item_data ) > 0 ) {
			ob_start();

			if ( $flat ) {
				foreach ( $item_data as $data ) {
					echo esc_html( $data['key'] ) . ': ' . wp_kses_post( $data['display'] ) . "\n";
				}
			}
			else {
				wc_get_template( 'cart/cart-item-data.php', array( 'item_data' => $item_data ) );
			}

			return ob_get_clean();
		}

		return '';
	}
}

/**
 * Override WooCommerce function wc_dropdown_variation_attribute_options (Locate in wc-template-functions.php)
 * Output a list of variation attributes for use in the cart forms.
 *
 * @param array $args
 *
 * @since  1.0
 *
 * @author Gordon Freeman
 */
function wc_dropdown_variation_attribute_options( $args = array() ) {
	$args = wp_parse_args(
		apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ),
		array(
			'options'          => false,
			'attribute'        => false,
			'product'          => false,
			'selected'         => false,
			'name'             => '',
			'id'               => '',
			'class'            => '',
			'show_option_none' => esc_html__( 'Choose an option', 'ihosting' )
		)
	);

	$options = $args['options'];
	$product = $args['product'];
	$attribute = $args['attribute'];
	$name = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
	$id = $args['id'] ? $args['id'] : sanitize_title( $attribute );
	$class = trim( $args['class'] . ' kt-product-attr select-attr-' . esc_attr( $attribute ) );

	if ( empty( $options ) && !empty( $product ) && !empty( $attribute ) ) {
		$attributes = $product->get_variation_attributes();
		$options = $attributes[$attribute];
	}

	$html = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

	if ( $args['show_option_none'] ) {
		if ( $attribute == 'pa_color' ) {
			$html .= '<option data-pa_color="" value="">' . esc_html( $args['show_option_none'] ) . '</option>';
		}
		else {
			$html .= '<option data-' . esc_attr( $attribute ) . '="" value="">' . esc_html( $args['show_option_none'] ) . '</option>';
		}
	}

	if ( !empty( $options ) ) {
		if ( $product && taxonomy_exists( $attribute ) ) {
			// Get terms if this is a taxonomy - ordered. We need the names too.
			$terms = wc_get_product_terms( $product->id, $attribute, array( 'fields' => 'all' ) );

			foreach ( $terms as $term ) {
				if ( in_array( $term->slug, $options ) ) {

					// For color attribute
					if ( $attribute == 'pa_color' ) {
						$data_color = 'transparent';
						if ( function_exists( 'get_tax_meta' ) ) {
							$data_color = trim( get_tax_meta( $term->term_id, 'ihosting_color' ) ) != '' ? get_tax_meta( $term->term_id, 'ihosting_color' ) : 'transparent';
						}
						$html .= '<option data-pa_color="' . esc_attr( $data_color ) . '" value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
					}
					else {
						$html .= '<option data-' . esc_attr( $attribute ) . '="' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '" value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
					}
				}
			}
		}
		else {
			foreach ( $options as $option ) {
				// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
				$selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
				$html .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
			}
		}
	}

	$html .= '</select>';

	echo apply_filters( 'woocommerce_dropdown_variation_attribute_options_html', $html, $args );
}

if ( !function_exists( 'ihosting_wc_pro_cats_list' ) ) {
	function ihosting_wc_pro_cats_list() {
		global $ihosting, $wp_query;

		$html = '';

		$header_shop_product_cats = isset( $ihosting['opt_header_shop_product_cats'] ) ? $ihosting['opt_header_shop_product_cats'] : 'auto'; // "auto" or "manually"

		if ( $header_shop_product_cats == 'auto' ) {

			// Array of active product categories (in single product)
			$active_pro_cats = array();

			// Get list or categoris in current single product
			if ( is_product() ) {
				$terms = wp_get_post_terms( get_the_ID(), 'product_cat' );
				if ( !is_wp_error( $terms ) ) {
					if ( !empty( $terms ) ) {
						foreach ( $terms as $term ):
							$active_pro_cats[] = $term->term_id;
						endforeach;
					}
				}
			}

			$args = array(
				'hierarchical'     => true,
				'show_option_none' => '',
				'hide_empty'       => 0,
				'taxonomy'         => 'product_cat',
			);

			if ( is_product_category() ) {
				$cur_pro_cat = $wp_query->get_queried_object();
				if ( $cur_pro_cat ) {
					$args['parent'] = $cur_pro_cat->term_id;
				}
			}

			$pro_cats = get_categories( $args );

			if ( !empty( $pro_cats ) ) {
				foreach ( $pro_cats as $pro_cat ):

					$cat_link = get_term_link( $pro_cat->slug, $pro_cat->taxonomy );
					$li_class = 'product_cat_li';
					if ( is_shop() ) {
						if ( $pro_cat->category_parent == 0 ) { // Show only parent
							if ( in_array( $pro_cat->term_id, $active_pro_cats ) ) {
								$li_class .= ' active_product_category';
							}
							$html .= '<li class="' . esc_attr( $li_class ) . '"><a href="' . esc_url( $cat_link ) . '">' . sanitize_text_field( $pro_cat->name ) . '</a></li>';
						}
					}
					else {
						if ( in_array( $pro_cat->term_id, $active_pro_cats ) ) {
							$li_class .= ' active_product_category';
						}
						$html .= '<li class="' . esc_attr( $li_class ) . '"><a href="' . esc_url( $cat_link ) . '">' . sanitize_text_field( $pro_cat->name ) . '</a></li>';
					}


				endforeach;
			}

		}
		else { // manually
			$cat_slugs = isset( $ihosting['woo_product_cats_show_on_archive'] ) ? $ihosting['woo_product_cats_show_on_archive'] : '';
			$cat_slugs = preg_replace( '/\s+/', '', $cat_slugs );

			if ( trim( $cat_slugs ) != '' ) {
				$cat_slugs = explode( ',', $cat_slugs );

				foreach ( $cat_slugs as $cat_slug ):

					$category = get_term_by( 'slug', trim( $cat_slug ), 'product_cat' );
					if ( $category != false ) {
						$html .= '<li class="product_cat_li"><a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '">' . sanitize_text_field( $category->name ) . '</a></li>';
					}

				endforeach;

			}
		}

		if ( trim( $html ) != '' ) {
			$html = '<ul class="list-categories product-list-categories">
                    ' . wptexturize( $html ) . '
                </ul>';
		}

		echo wptexturize( $html );

	}
}

if ( !function_exists( 'ihosting_wc_template_loop_product_thumbnail' ) ) {
	function ihosting_wc_template_loop_product_thumbnail() {
		global $product;

		$img_size_x = 250;
		$img_size_y = 310;

		$class = 'thumb';

		$primary_img = ihosting_resize_image( get_post_thumbnail_id( $product->id ), null, $img_size_x, $img_size_y, true, true, false );
		$primary_img_html = '<img class="primary-img" width="' . esc_attr( $primary_img['width'] ) . '" height="' . esc_attr( $primary_img['height'] ) . '" src="' . esc_url( $primary_img['url'] ) . '" alt="' . esc_attr( get_the_title( $product->id ) ) . '" >';

		$secondary_img_html = '';
		$attachment_ids = $product->get_gallery_attachment_ids();
		if ( isset( $attachment_ids[0] ) ) {
			$class .= ' has-secondary-image';
			$secondary_img = ihosting_resize_image( $attachment_ids[0], null, $img_size_x, $img_size_y, true, true, false );
			$secondary_img_html .= '<img class="secondary-img" width="' . esc_attr( $secondary_img['width'] ) . '" height="' . esc_attr( $secondary_img['height'] ) . '" src="' . esc_url( $secondary_img['url'] ) . '" alt="' . esc_attr( get_post_meta( $attachment_ids[0], '_wp_attachment_image_alt', true ) ) . '" >';
		}

		echo '<div class="' . esc_attr( $class ) . '">
                <a href="' . esc_url( get_permalink() ) . '">
                    ' . wptexturize( $primary_img_html ) . '
                    ' . wptexturize( $secondary_img_html ) . '
                </a>
                ' . ihosting_wc_add_quickview_btn( 0, false ) . '
            </div>';

	}
}

if ( !function_exists( 'ihosting_wc_loop_thumbs_btns' ) ) {
	function ihosting_wc_loop_thumbs_btns() {
		$html = '';
		$thumbs_html = '';
		$btns_html = '';

		ob_start();
		ihosting_wc_template_loop_product_thumbnail();
		$thumbs_html .= ob_get_clean();

		ob_start();
		ihosting_wc_loop_product_hidden_info_open();
		ihosting_wc_loop_product_wishlist_btn();
		woocommerce_template_loop_add_to_cart();
		ihosting_wc_loop_product_compare_btn();
		ihosting_wc_loop_product_hidden_info_close();
		$btns_html .= ob_get_clean();

		$html .= '<div class="ih-product-thumbs-btns-wrap">';
		$html .= $thumbs_html;
		$html .= $btns_html;
		$html .= '</div><!-- /.ih-product-thumbs-btns-wrap -->';

		echo $html;
	}
}

function ihosting_filter_breadcrumb_products() {
	?>
	<div class="filter-breadcrumb-product">
		<?php
		woocommerce_breadcrumb();
		woocommerce_catalog_ordering();
		woocommerce_result_count();
		?>
	</div><!-- /.filter-breadcrumb-product -->
	<?php
}

if ( !function_exists( 'ihosting_wc_template_loop_product_info' ) ) {
	/**
	 * Display product title, price, wishlist button, compare button
	 **/
	function ihosting_wc_template_loop_product_info() {
		global $ihosting, $post;

		$show_star_rating = isset( $ihosting['woo_show_star_rating_on_product_loop'] ) ? $ihosting['woo_show_star_rating_on_product_loop'] == 1 : false;

		?>

		<div class="product-info">
			<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
			<?php if ( $show_star_rating ) { ?>
				<?php woocommerce_template_loop_rating(); ?>
			<?php }; ?>
			<div class="price-wrap">
				<?php woocommerce_template_loop_price(); ?>
			</div>
			<?php if ( $post->post_excerpt ) { ?>
				<div class="short-desc">
					<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
				</div>
			<?php } ?>
		</div>

		<?php
	}
}

if ( !function_exists( 'ihosting_wc_add_quickview_btn' ) ) {
	function ihosting_wc_add_quickview_btn( $product_id = 0, $echo = true ) {
		$html = '';

		if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
			$product_id = intval( $product_id );
			if ( $product_id <= 0 ) {
				$product_id = get_the_ID();
			}
			$label = get_option( 'yith-wcqv-button-label' );
			$html .= '<a href="#" class="button yith-wcqv-button" data-product_id="' . esc_attr( $product_id ) . '">' . esc_html( $label ) . '</a>';
		}

		if ( $echo ) {
			echo $html;
		}
		else {
			return $html;
		}
	}
}

if ( !function_exists( 'ihosting_wc_loop_product_wishlist_btn' ) ) {
	function ihosting_wc_loop_product_wishlist_btn() {
		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			echo do_shortcode( '[yith_wcwl_add_to_wishlist product_id="' . get_the_ID() . '"]' );
		}
	}
}

if ( !function_exists( 'ihosting_wc_loop_product_compare_btn' ) ) {
	function ihosting_wc_loop_product_compare_btn() {
		if ( shortcode_exists( 'yith_compare_button' ) ) {
			echo do_shortcode( '[yith_compare_button product_id="' . get_the_ID() . '"]' );
		} // End if ( shortcode_exists( 'yith_compare_button' ) )
		else {
			if ( class_exists( 'YITH_Woocompare_Frontend' ) ) {
				$YITH_Woocompare_Frontend = new YITH_Woocompare_Frontend();
				echo do_shortcode( '[yith_compare_button product_id="' . get_the_ID() . '"]' );
			}
		}
	}
}

if ( !function_exists( 'ihosting_wc_loop_product_inner_open' ) ) {
	function ihosting_wc_loop_product_inner_open() {
		echo '<div class="kt-product-inner">';
	}
}
if ( !function_exists( 'ihosting_wc_loop_product_inner_close' ) ) {
	function ihosting_wc_loop_product_inner_close() {
		echo '</div><!-- /.kt-product-inner -->';
	}
}

if ( !function_exists( 'ihosting_wc_loop_product_hidden_info_open' ) ) {
	function ihosting_wc_loop_product_hidden_info_open() {
		echo '<div class="kt-product-btns">';
	}
}
if ( !function_exists( 'ihosting_wc_loop_product_hidden_info_close' ) ) {
	function ihosting_wc_loop_product_hidden_info_close() {
		echo '</div><!-- /.kt-product-btns -->';
	}
}

if ( !function_exists( 'ihosting_product_img_open_tag' ) ) {
	function ihosting_product_img_open_tag() {
		echo '<div class="product-img-wrap col-xs-12 col-sm-6 col-md-4">';
	}
}

if ( !function_exists( 'ihosting_product_img_close_tag' ) ) {
	function ihosting_product_img_close_tag() {
		echo '</div><!-- /.product-img-wrap -->';
	}
}

if ( !function_exists( 'ihosting_wc_single_sku' ) ) {
	function ihosting_wc_single_sku() {
		global $product;
		?>
		<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

			<span class="sku_wrapper">
				<strong><?php esc_html_e( 'SKU:', 'ihosting' ); ?></strong>
				<span class="sku"
				      itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'ihosting' ); ?></span></span>

		<?php endif; ?>
		<?php
	}
}

if ( !function_exists( 'ihosting_wc_shop_display_mode' ) ) {
	function ihosting_wc_shop_display_mode() {
		global $ihosting;

		if ( !is_shop() && !is_product_category() && !is_product_tag() ) {
			return false;
		}

		$active_grid = isset( $ihosting['woo_shop_default_layout'] ) ? $ihosting['woo_shop_default_layout'] == 'grid' : true;
		$grid_class = $active_grid ? 'display-mode active' : 'display-mode';
		$list_class = $active_grid ? 'display-mode' : 'display-mode active';
		?>
		<div class="shop-display-mode">
			<span class="label-filter"><?php esc_html_e( 'View as:', 'ihosting' ); ?></span>
			<a data-mode="list" class="<?php echo esc_attr( $list_class ); ?>" href="#"><i
					class="fa fa-th-list"></i></a>
			<a data-mode="grid" class="<?php echo esc_attr( $grid_class ); ?>" href="#"><i
					class="fa fa-th-large"></i></a>
		</div>
		<?php
	}
}

if ( !function_exists( 'ihosting_wc_new_product_tab' ) ) {
	function ihosting_wc_new_product_tab( $tabs ) {
		global $ihosting;

		$enable_cats_tab = isset( $ihosting['woo_single_product_enable_cats_tab'] ) ? $ihosting['woo_single_product_enable_cats_tab'] == 1 : true;
		$enable_tags_tab = isset( $ihosting['woo_single_product_enable_tags_tab'] ) ? $ihosting['woo_single_product_enable_tags_tab'] == 1 : true;

		if ( $enable_cats_tab ) {
			// Adds the categories tab
			$tabs['product_cats'] = array(
				'title'    => esc_html__( 'Product Categories', 'ihosting' ),
				'priority' => 50,
				'callback' => 'ihosting_wc_product_cats_tab_content'
			);
		}

		if ( $enable_tags_tab ) {
			// Adds the categories tab
			$tabs['product_tags'] = array(
				'title'    => esc_html__( 'Product Tags', 'ihosting' ),
				'priority' => 50,
				'callback' => 'ihosting_wc_product_tags_tab_content'
			);
		}

		return $tabs;

	}

	add_filter( 'woocommerce_product_tabs', 'ihosting_wc_new_product_tab' );
}

if ( !function_exists( 'ihosting_wc_product_cats_tab_content' ) ) {
	function ihosting_wc_product_cats_tab_content() {
		global $product;
		echo wptexturize( $product->get_categories( ' ', '<span class="posted_in">', '</span>' ) );
	}
}

if ( !function_exists( 'ihosting_wc_product_tags_tab_content' ) ) {
	function ihosting_wc_product_tags_tab_content() {
		global $product;
		echo wptexturize( $product->get_tags( ' ', '<span class="tagged_as">', '</span>' ) );
	}
}

/**
 * Display product title, price
 **/
function ihosting_wc_template_loop_title_price() {
	global $ihosting;
	$show_product_title_on_loop = isset( $ihosting['opt_show_product_title_on_loop'] ) ? $ihosting['opt_show_product_title_on_loop'] : 'always_show';
	if ( ihosting_wc_is_enable_grid_masonry() ) {
		$show_product_title_on_loop = 'show_on_hover';
	}
	?>
	<?php if ( trim( $show_product_title_on_loop ) == 'always_show' ): ?>
		<div class="info-product">
			<?php
			//woocommerce_template_loop_product_title();
			echo '<h3 class="title-product"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h3>';
			woocommerce_template_loop_price();
			?>
			<a class="ts-viewdetail" href="<?php echo esc_url( get_permalink() ); ?>">
				<span class="icon icon-arrows-slim-right"></span>
            <span
	            class="screen-reader-text"><?php echo sprintf( esc_html__( 'View %s details', 'ihosting' ), get_the_title() ); ?></span>
			</a>
		</div><!-- /.info-product -->
	<?php endif; // End if ( trim( $show_product_title_on_loop ) == 'always_show' )
	?>
	<?php
}

if ( !function_exists( 'ihosting_move_comment_field_to_bottom' ) ) {
	/**
	 * Move comment field (textarea) to bottom
	 */
	function ihosting_move_comment_field_to_bottom( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;

		return $fields;
	}

	add_filter( 'comment_form_fields', 'ihosting_move_comment_field_to_bottom' );
}

function ihosting_product_sharers() {
	global $ihosting;
	$enable_share_post = isset( $ihosting['opt_enable_share_product'] ) ? $ihosting['opt_enable_share_product'] == 1 : false;
	$socials_shared = isset( $ihosting['opt_single_product_socials_share'] ) ? $ihosting['opt_single_product_socials_share'] : array();

	$thumb_url = '';
	if ( has_post_thumbnail() ) {
		$img_full = ihosting_resize_image( get_post_thumbnail_id(), null, 4000, 4000, true, true, false );
		$thumb_url = $img_full['url'];
	}

	?>

	<?php if ( $enable_share_post && !empty( $socials_shared ) ): ?>

		<div class="product-share">
			<span class="share-product-title"><?php esc_html_e( 'Share this product: ', 'ihosting' ); ?></span>
			<ul class="product-socials-share-wrap">
				<?php if ( in_array( 'facebook', $socials_shared ) ): ?>
					<li>
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>"
						   target="_blank"><i class="fa fa-facebook"></i><span
								class="screen-reader-text"><?php echo sprintf( esc_html__( 'Share "%s" on Facebook', 'ihosting' ), get_the_title() ); ?></span></a>
					</li>
				<?php endif; ?>
				<?php if ( in_array( 'gplus', $socials_shared ) ): ?>
					<li>
						<a href="https://plus.google.com/share?url=<?php echo esc_url( get_permalink() ); ?>"
						   target="_blank"><i class="fa fa-google-plus"></i><span
								class="screen-reader-text"><?php echo sprintf( esc_html__( 'Share "%s" on Google Plus', 'ihosting' ), get_the_title() ); ?></span></a>
					</li>
				<?php endif; ?>
				<?php if ( in_array( 'twitter', $socials_shared ) ): ?>
					<li>
						<a href="https://twitter.com/home?status=<?php echo esc_url( get_permalink() ); ?>"
						   target="_blank"><i
								class="fa fa-twitter"></i><span
								class="screen-reader-text"><?php echo sprintf( esc_html__( 'Share "%s" on Twitter', 'ihosting' ), get_the_title() ); ?></span></a>
					</li>
				<?php endif; ?>
				<?php if ( in_array( 'pinterest', $socials_shared ) ): ?>
					<li>
						<a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url( get_permalink() ); ?>&media=<?php echo esc_url( $thumb_url ); ?>&description=<?php echo esc_attr( get_the_title() ); ?>"
						   target="_blank"><i class="fa fa-pinterest"></i><span
								class="screen-reader-text"><?php echo sprintf( esc_html__( 'Share "%s" on Pinterest', 'ihosting' ), get_the_title() ); ?></span></a>
					</li>
				<?php endif; ?>
				<?php if ( in_array( 'linkedin', $socials_shared ) ): ?>
					<li>
						<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_attr( get_the_title() ); ?>&summary=&source=<?php echo esc_url( get_permalink() ); ?>"
						   target="_blank"><i class="fa fa-linkedin"></i><span
								class="screen-reader-text"><?php echo sprintf( esc_html__( 'Share "%s" on LinkedIn', 'ihosting' ), get_the_title() ); ?></span></a>
					</li>
				<?php endif; ?>
			</ul><!-- /.product-socials-share-wrap -->
		</div><!-- /.product-share -->

	<?php endif; ?>

	<?php
}

function ihosting_wc_is_enable_grid_masonry() {
	global $ihosting;

	$enable_shop_grid_masonry = isset( $ihosting['opt_enable_shop_grid_masonry'] ) ? $ihosting['opt_enable_shop_grid_masonry'] == 1 : false;
	$enable_shop_grid_masonry = $enable_shop_grid_masonry && ( is_shop() || is_product_category() || is_product_tag() );

	return $enable_shop_grid_masonry;
}

function ihosting_wc_grid_masonry_open_tag() {
	global $product_num;

	$enable_shop_grid_masonry = ihosting_wc_is_enable_grid_masonry();

	if ( $enable_shop_grid_masonry ):
		$product_num = 0;
		?>
		<div class="ts-catalog-masonry grid-masonry ihosting-product-categories-grid-masonry" data-layoutmode="packery">
		<?php
	endif;
}

function ihosting_wc_grid_masonry_close_tag() {
	$enable_shop_grid_masonry = ihosting_wc_is_enable_grid_masonry();

	if ( $enable_shop_grid_masonry ):
		?>
		</div><!-- /.ihosting-product-categories-grid-masonry -->
		<?php
	endif;
}

function ihosting_wc_open_tag_before_single_product_add_to_cart_form() {
	?>
	<div class="product-addtocart">
	<?php
}

function ihosting_wc_close_tag_after_single_product_add_to_cart_form() {
	?>
	</div><!-- /.product-addtocart -->
	<?php
}

/**
 * Output the add to cart button for variations.
 */
function ihosting_wc_single_variation_add_to_cart_button() {
	global $product;
	?>
	<div class="variations_button">
		<?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
		<br/>
		<button type="submit"
		        class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
		<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>"/>
		<input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>"/>
		<input type="hidden" name="variation_id" class="variation_id" value=""/>
	</div>
	<?php
}

/**
 * Remove by js after document ready
 **/
function ihosting_open_tag_hack_remove_wish_list_btn() {
	?>
	<div class="ihosting-remove-inner-content hidden">
	<?php
}

function ihosting_close_tag_hack_remove_wish_list_btn() {
	?>
	</div><!-- /.ihosting-remove-inner-content -->
	<?php
}

// Add some actions for WooCommerce
add_action( 'woocommerce_before_shop_loop_item', 'ihosting_wc_loop_product_inner_open', 10 ); // content-product.php
//add_action( 'woocommerce_before_shop_loop_item_title', 'ihosting_wc_template_loop_product_thumbnail', 10 ); // content-product.php
add_action( 'woocommerce_before_shop_loop_item_title', 'ihosting_wc_loop_thumbs_btns', 10 ); // content-product.php
//add_action( 'woocommerce_after_shop_loop_item', 'ihosting_wc_loop_product_hidden_info_open', 6 ); // content-product.php
//add_action( 'woocommerce_after_shop_loop_item', 'ihosting_wc_loop_product_wishlist_btn', 7 ); // content-product.php
//add_action( 'woocommerce_after_shop_loop_item', 'ihosting_wc_loop_product_compare_btn', 15 ); // content-product.php
//add_action( 'woocommerce_after_shop_loop_item', 'ihosting_wc_loop_product_hidden_info_close', 20 ); // content-product.php
add_action( 'woocommerce_after_shop_loop_item', 'ihosting_wc_template_loop_product_info', 25 ); // content-product.php
add_action( 'woocommerce_after_shop_loop_item', 'ihosting_wc_loop_product_inner_close', 30 ); // content-product.php
add_action( 'woocommerce_before_main_content', 'ihosting_wc_shop_display_mode', 30 ); // archive-product.php
add_action( 'woocommerce_before_main_content', 'woocommerce_catalog_ordering', 35 ); // archive-product.php
add_action( 'woocommerce_before_single_product_summary', 'ihosting_product_img_open_tag', 5 ); // content-single-product.php
add_action( 'woocommerce_before_single_product_summary', 'ihosting_product_img_close_tag', 30 ); // content-single-product.php
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 ); // content-single-product.php
add_action( 'woocommerce_single_product_summary', 'ihosting_wc_single_sku', 16 ); // content-single-product.php
add_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 15 ); // content-single-product.php
add_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 20 ); // content-single-product.php
add_action( 'woocommerce_share', 'ihosting_product_sharers', 10 ); // single-product/share.php


// Remove some default actions of WooCommcerce
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 ); // content-product.php
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 ); // content-product.php
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 ); // content-product.php
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); // content-product.php
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 ); // content-product.php
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 ); // content-product.php
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); // content-product.php
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 ); // archive-product.php
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 ); // archive-product.php
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 ); // archive-product.php
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 ); // content-single-product.php
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 ); // content-single-product.php
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 ); // content-single-product.php


if ( !function_exists( 'ihosting_remove_title' ) ) {
	/**
	 * Remove shop/products archive default page title
	 */
	function ihosting_remove_shop_title() {
		return false;
	}

	add_filter( 'woocommerce_show_page_title', 'ihosting_remove_shop_title' );
}

// Remove some hooks of YITH plugins
if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
	remove_action( 'woocommerce_after_shop_loop_item', array( YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button' ), 15 );
}

/** END FUNCTIONS FOR WOOCOMMERCE =================================== **/

if ( !function_exists( 'ihosting_404_footer_post_type_redirect' ) ) {
	/**
	 * Redirect 404 on single post type 'footer'
	 */
	function ihosting_404_footer_post_type_redirect() {
		if ( is_singular( 'footer' ) ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
		}
	}

	add_action( 'wp', 'ihosting_404_footer_post_type_redirect' );
}

if ( !function_exists( 'ihosting_select_post_by_post_types_for_redux' ) ) {
	function ihosting_select_post_by_post_types_for_redux( $args = array() ) {
		$args_default = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => 'date',
			'order'            => 'DESC',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'post',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'author'           => '',
			'post_status'      => 'publish',
			'suppress_filters' => true
		);

		$args = wp_parse_args( $args, $args_default );
		$posts_array = get_posts( $args );

		$results = array();

		if ( !empty( $posts_array ) ) {
			foreach ( $posts_array as $post ) {
				setup_postdata( $post );
				$results[$post->ID] = sanitize_text_field( $post->post_title );
			}
		}

		wp_reset_postdata();

		return $results;
	}
}

if ( !function_exists( 'ihosting_get_shortcode_custom_css_no_wrap' ) ) {
	function ihosting_get_shortcode_custom_css_no_wrap( $post_id = 0 ) {

		if ( !class_exists( 'Vc_Manager' ) ) {
			return '';
		}

		$output = $shortcodes_custom_css = '';
		$id = $post_id;
		if ( preg_match( '/^\d+$/', $id ) ) {
			$shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
		}

		$output .= $shortcodes_custom_css;

		return $output;
	}
}

if ( !function_exists( 'ihosting_get_shortcode_custom_css' ) ) {
	function ihosting_get_shortcode_custom_css( $post_id = 0 ) {

		$output = $shortcodes_custom_css = '';

		$shortcodes_custom_css .= ihosting_get_shortcode_custom_css_no_wrap( $post_id );

		if ( !empty( $shortcodes_custom_css ) ) {
			$shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
			$output .= '<style type="text/css" data-type="vc_shortcodes-custom-css" class="lk-custom-shortcodes-css">';
			$output .= $shortcodes_custom_css;
			$output .= '</style>';
		}

		return $output;
	}
}

if ( !function_exists( 'ihosting_footer_custom_style_for_vc' ) ) {

	/**
	 * Add VC CSS for footer
	 */
	function ihosting_footer_custom_style_for_vc() {
		global $ihosting;

		$footer_content_id = isset( $ihosting['opt_footer_layout_content'] ) ? intval( $ihosting['opt_footer_layout_content'] ) : 0;

		// For custom Footer (static home page, blog page, single post, page, product...)
		$post_id = 0; // Post, page or post type... id

		if ( is_front_page() && is_home() ) {
			// Default homepage
			// Current version of theme does not support custom footer for search results, default home page, global setting will be used
		}
		elseif ( is_front_page() ) {
			// static homepage
			$post_id = get_option( 'page_on_front' );
		}
		elseif ( is_home() ) {
			// blog page
			$post_id = get_option( 'page_for_posts' );
		}
		else {
			// Everything else

			// Is a singular
			if ( is_singular() ) {
				$post_id = get_the_ID();
			}
			else {
				// Is archive or taxonomy
				if ( is_archive() ) {

					// Category
					if ( is_category() ) {

					}

					// Checking for shop archive
					if ( function_exists( 'is_shop' ) ) { // Products archive, products category, products search page...
						if ( is_shop() ) {
							$post_id = get_option( 'woocommerce_shop_page_id' );
						}
						if ( is_product_category() ) {
							// Current version of theme does not support custom footer for taxonomy, global setting will be used
						}
					}

				}
				else {
					if ( is_404() ) {
						// Current version of theme does not support custom footer for 404 page, global setting will be used
					}
					else {
						if ( is_search() ) {

						}
						else {
							// Is category, is tag, is tax
							// Current version of theme does not support custom footer for search results, category, tag, tax.., global setting will be used
						}
					}
				}

			}

			// Other WooCommerce pages
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_cart() ) {
					$post_id = wc_get_page_id( 'cart' );
				}
				if ( is_checkout() ) {
					$post_id = wc_get_page_id( 'checkout' );
				}
				if ( is_account_page() ) {
					$post_id = wc_get_page_id( 'myaccount' );
				}
			}

		}

		$is_custom_footer = get_post_meta( $post_id, '_ihosting_enable_custom_footer', true ) == 'custom'; // custom, global

		if ( $is_custom_footer ) {
			$footer_layout = get_post_meta( $post_id, '_ihosting_footer_layout', true );
			$is_custom_footer_layout = $footer_layout != 'global' && $footer_layout != '';

			if ( $is_custom_footer_layout ) {
				$footer_content_id = intval( $footer_layout );
			}
		}

		$style = '';
		if ( $footer_content_id > 0 ) {
			//$style .= ihosting_get_shortcode_custom_css( $footer_content_id );
			$style .= ihosting_get_shortcode_custom_css_no_wrap( $footer_content_id );
		}

		//echo $style;
		wp_add_inline_style( 'ihosting-custom-style', $style );

	}

	add_action( 'wp_enqueue_scripts', 'ihosting_footer_custom_style_for_vc', 21 );
}


/** UPDATE SOME INITIAL OPTIONS AFTER PLUGINS ACTIVED =============== **/
if ( !function_exists( 'ihosting_init_update_woof_function' ) ) {

	/**
	 * Update Woof initital options
	 **/
	function ihosting_init_update_woof_function() {
		$woof_settings = unserialize( 'a:24:{s:8:"tax_type";a:4:{s:11:"product_cat";s:8:"checkbox";s:8:"pa_color";s:8:"checkbox";s:7:"pa_size";s:8:"checkbox";s:11:"product_tag";s:8:"checkbox";}s:14:"excluded_terms";a:4:{s:11:"product_cat";s:0:"";s:8:"pa_color";s:0:"";s:7:"pa_size";s:0:"";s:11:"product_tag";s:0:"";}s:16:"tax_block_height";a:4:{s:11:"product_cat";s:1:"0";s:8:"pa_color";s:1:"0";s:7:"pa_size";s:1:"0";s:11:"product_tag";s:1:"0";}s:16:"show_title_label";a:4:{s:11:"product_cat";s:1:"1";s:8:"pa_color";s:1:"1";s:7:"pa_size";s:1:"1";s:11:"product_tag";s:1:"0";}s:13:"dispay_in_row";a:4:{s:11:"product_cat";s:1:"0";s:8:"pa_color";s:1:"0";s:7:"pa_size";s:1:"0";s:11:"product_tag";s:1:"0";}s:16:"custom_tax_label";a:4:{s:11:"product_cat";s:18:"Product Categories";s:8:"pa_color";s:12:"Color Filter";s:7:"pa_size";s:11:"Size Filter";s:11:"product_tag";s:0:"";}s:3:"tax";a:3:{s:11:"product_cat";s:1:"1";s:8:"pa_color";s:1:"1";s:7:"pa_size";s:1:"1";}s:11:"icheck_skin";s:4:"none";s:12:"overlay_skin";s:7:"default";s:19:"overlay_skin_bg_img";s:0:"";s:18:"plainoverlay_color";s:0:"";s:25:"default_overlay_skin_word";s:0:"";s:25:"woof_auto_hide_button_img";s:0:"";s:25:"woof_auto_hide_button_txt";s:0:"";s:18:"title_submit_image";s:0:"";s:22:"price_filter_title_txt";s:0:"";s:25:"search_by_title_behaviour";s:5:"title";s:31:"search_by_title_placeholder_txt";s:29:"Enter a product title here...";s:8:"per_page";s:2:"12";s:12:"storage_type";s:7:"session";s:20:"hide_terms_count_txt";s:1:"0";s:16:"cache_count_data";s:1:"0";s:15:"custom_css_code";s:0:"";s:18:"js_after_ajax_done";s:0:"";}' );
		$current_woof_settings = get_option( 'woof_settings', $woof_settings );
		update_option( 'woof_settings', $current_woof_settings );
	}
	//add_action( 'activate_woocommerce-products-filter/index.php', 'ihosting_init_update_woof_function' );

}

/** END UPDATE SOME INITIAL OPTIONS AFTER PLUGINS ACTIVED =========== **/

if ( !function_exists( 'ihosting_no_image' ) ) {

	/**
	 * No image generator
	 *
	 * @since 1.0
	 *
	 * @param $size : array, image size
	 * @param $echo : bool, echo or return no image url
	 **/
	function ihosting_no_image( $size = array( 'width' => 500, 'height' => 500 ), $echo = false, $transparent = false
	) {

		$noimage_dir = get_template_directory();
		$noimage_uri = get_template_directory_uri();

		$suffix = ( $transparent ) ? '_transparent' : '';

		if ( !is_array( $size ) || empty( $size ) ):
			$size = array( 'width' => 500, 'height' => 500 );
		endif;

		if ( !is_numeric( $size['width'] ) && $size['width'] == '' || $size['width'] == null ):
			$size['width'] = 'auto';
		endif;

		if ( !is_numeric( $size['height'] ) && $size['height'] == '' || $size['height'] == null ):
			$size['height'] = 'auto';
		endif;

		// base image must be exist
		$img_base_fullpath = $noimage_dir . '/assets/images/noimage/no_image' . $suffix . '.png';
		$no_image_src = $noimage_uri . '/assets/images/noimage/no_image' . $suffix . '.png';


		// Check no image exist or not
		if ( !file_exists( $noimage_dir . '/assets/images/noimage/no_image' . $suffix . '-' . $size['width'] . 'x' . $size['height'] . '.png' ) && is_writable( $noimage_dir . '/assets/images/noimage/' ) ):

			$no_image = wp_get_image_editor( $img_base_fullpath );

			if ( !is_wp_error( $no_image ) ):
				$no_image->resize( $size['width'], $size['height'], true );
				$no_image_name = $no_image->generate_filename( $size['width'] . 'x' . $size['height'], $noimage_dir . '/assets/images/noimage/', null );
				$no_image->save( $no_image_name );
			endif;

		endif;

		// Check no image exist after resize
		$noimage_path_exist_after_resize = $noimage_dir . '/assets/images/noimage/no_image' . $suffix . '-' . $size['width'] . 'x' . $size['height'] . '.png';

		if ( file_exists( $noimage_path_exist_after_resize ) ):
			$no_image_src = $noimage_uri . '/assets/images/noimage/no_image' . $suffix . '-' . $size['width'] . 'x' . $size['height'] . '.png';
		endif;

		if ( $echo ):
			echo esc_url( $no_image_src );
		else:
			return esc_url( $no_image_src );
		endif;

	}
}


if ( !function_exists( 'ihosting_resize_image' ) ) {
	/**
	 * @param int    $attach_id
	 * @param string $img_url
	 * @param int    $width
	 * @param int    $height
	 * @param bool   $crop
	 * @param bool   $place_hold        Using place hold image if the image does not exist
	 * @param bool   $use_real_img_hold Using real image for holder if the image does not exist
	 * @param string $solid_img_color   Solid placehold image color (not text color). Random color if null
	 *
	 * @since 1.0
	 * @return array
	 */
	function ihosting_resize_image(
		$attach_id = null, $img_url = null, $width, $height, $crop = false, $place_hold = true,
		$use_real_img_hold = true, $solid_img_color = null
	) {

		// If is singular and has post thumbnail and $attach_id is null, so we get post thumbnail id automatic (there is a bug, don't use)
		//		if ( is_singular() && !$attach_id && !$img_url ) {
		//			if ( has_post_thumbnail() && !post_password_required() ) {
		//				$attach_id = get_post_thumbnail_id();
		//			}
		//		}

		// this is an attachment, so we have the ID
		$image_src = array();
		if ( $attach_id ) {
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$actual_file_path = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url
		}
		else {
			if ( $img_url ) {
				$file_path = str_replace( get_site_url(), ABSPATH, $img_url );
				$actual_file_path = rtrim( $file_path, '/' );
				if ( !file_exists( $actual_file_path ) ) {
					$file_path = parse_url( $img_url );
					$actual_file_path = rtrim( ABSPATH, '/' ) . $file_path['path'];
				}
				if ( file_exists( $actual_file_path ) ) {
					$orig_size = getimagesize( $actual_file_path );
					$image_src[0] = $img_url;
					$image_src[1] = $orig_size[0];
					$image_src[2] = $orig_size[1];
				}
				else {
					$image_src[0] = '';
					$image_src[1] = 0;
					$image_src[2] = 0;
				}
			}
		}
		if ( !empty( $actual_file_path ) && file_exists( $actual_file_path ) ) {
			$file_info = pathinfo( $actual_file_path );
			$extension = '.' . $file_info['extension'];

			// the image path without the extension
			$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

			$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

			// checking if the file size is larger than the target size
			// if it is smaller or the same size, stop right here and return
			if ( $image_src[1] > $width || $image_src[2] > $height ) {

				// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
				if ( file_exists( $cropped_img_path ) ) {
					$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
					$vt_image = array( 'url' => $cropped_img_url, 'width' => $width, 'height' => $height, );

					return $vt_image;
				}

				// $crop = false
				if ( $crop == false ) {
					// calculate the size proportionaly
					$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
					$resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

					// checking if the file already exists
					if ( file_exists( $resized_img_path ) ) {
						$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

						$vt_image = array( 'url' => $resized_img_url, 'width' => $proportional_size[0], 'height' => $proportional_size[1], );

						return $vt_image;
					}
				}

				// no cache files - let's finally resize it
				$img_editor = wp_get_image_editor( $actual_file_path );

				if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
					return array( 'url' => '', 'width' => '', 'height' => '', );
				}

				$new_img_path = $img_editor->generate_filename();

				if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
					return array( 'url' => '', 'width' => '', 'height' => '', );
				}
				if ( !is_string( $new_img_path ) ) {
					return array( 'url' => '', 'width' => '', 'height' => '', );
				}

				$new_img_size = getimagesize( $new_img_path );
				$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

				// resized output
				$vt_image = array( 'url' => $new_img, 'width' => $new_img_size[0], 'height' => $new_img_size[1], );

				return $vt_image;
			}

			// default output - without resizing
			$vt_image = array( 'url' => $image_src[0], 'width' => $image_src[1], 'height' => $image_src[2], );

			return $vt_image;
		}
		else {
			if ( $place_hold ) {
				$width = intval( $width );
				$height = intval( $height );

				// Real image place hold (https://unsplash.it/)
				if ( $use_real_img_hold ) {
					$random_time = time() + rand( 1, 100000 );
					$vt_image = array( 'url' => 'https://unsplash.it/' . $width . '/' . $height . '?random&time=' . $random_time, 'width' => $width, 'height' => $height, );
				}
				else {
					$color = $solid_img_color;
					if ( is_null( $color ) || trim( $color ) == '' ) {

						// Show no image (gray)
						$vt_image = array( 'url' => ihosting_no_image( array( 'width' => $width, 'height' => $height ) ), 'width' => $width, 'height' => $height, );
					}
					else {
						if ( $color == 'transparent' ) { // Show no image transparent
							$vt_image = array( 'url' => ihosting_no_image( array( 'width' => $width, 'height' => $height ), false, true ), 'width' => $width, 'height' => $height, );
						}
						else { // No image with color from placehold.it
							$vt_image = array( 'url' => 'http://placehold.it/' . $width . 'x' . $height . '/' . $color . '/ffffff/', 'width' => $width, 'height' => $height, );
						}
					}
				}

				return $vt_image;
			}
		}

		return false;
	}
}

if ( !function_exists( 'ihosting_color_hex2rgba' ) ) {
	function ihosting_color_hex2rgba( $hex, $alpha = 1 ) {
		$hex = str_replace( "#", "", $hex );

		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		}
		else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = array( $r, $g, $b );

		return 'rgba( ' . implode( ', ', $rgb ) . ', ' . $alpha . ' )'; // returns the rgb values separated by commas
	}
}

if ( !function_exists( 'ihosting_color_rgb2hex' ) ) {
	function ihosting_color_rgb2hex( $rgb ) {
		$hex = '#';
		$hex .= str_pad( dechex( $rgb[0] ), 2, '0', STR_PAD_LEFT );
		$hex .= str_pad( dechex( $rgb[1] ), 2, '0', STR_PAD_LEFT );
		$hex .= str_pad( dechex( $rgb[2] ), 2, '0', STR_PAD_LEFT );

		return $hex; // returns the hex value including the number sign (#)
	}
}

/** FUNCTIONS FOR AJAX ======================================= **/


/**
 * Do login via ajax
 **/
function ihosting_do_login_via_ajax() {
	global $current_user;

	$response = array(
		'html'         => '',
		'is_logged_in' => is_user_logged_in() ? 'yes' : 'no',
		'message'      => '',
	);

	if ( $response['is_logged_in'] == 'yes' ) {
		$response['message'] = '<p class="text-primary bg-primary login-message">' . esc_html__( 'You are logged in!', 'ihosting' ) . '</p>';
		wp_send_json( $response );
		die();
	}

	$user_login = isset( $_POST['user_login'] ) ? $_POST['user_login'] : '';
	$user_pass = isset( $_POST['user_pass'] ) ? $_POST['user_pass'] : '';
	$rememberme = isset( $_POST['rememberme'] ) ? $_POST['rememberme'] == 'yes' : false;
	//$redirect_to = isset( $_POST['redirect_to'] ) ? esc_url( $_POST['redirect_to'] ) : '';
	$login_nonce = isset( $_POST['login_nonce'] ) ? $_POST['login_nonce'] : '';

	if ( !wp_verify_nonce( $login_nonce, 'ajax-login-nonce' ) ) {
		$response['message'] = '<p class="text-danger bg-danger login-message">' . esc_html__( 'Security check error!', 'ihosting' ) . '</p>';
		wp_send_json( $response );
		die();
	}

	if ( trim( $user_login ) == '' ) {
		$response['message'] = '<p class="text-danger bg-danger login-message">' . esc_html__( 'User name can not be empty!', 'ihosting' ) . '</p>';
		wp_send_json( $response );
		die();
	}

	$info = array();
	$info['user_login'] = $user_login;
	$info['user_password'] = $user_pass;
	$info['remember'] = $rememberme;

	$user_signon = wp_signon( $info, false );

	if ( is_wp_error( $user_signon ) ) {
		$response['message'] = '<p class="text-danger bg-danger login-message">' . esc_html__( 'Wrong username or password.', 'ihosting' ) . '</p>';
	}
	else {
		$response['is_logged_in'] = 'yes';
		$response['message'] = '<p class="text-success bg-success login-message">' . esc_html__( 'Logged in successfully', 'ihosting' ) . '</p>';
		$response['html'] = '<h3>' . esc_html__( 'Welcome', 'ihosting' ) . '</h3>
                            <p>' . sprintf( esc_html__( 'Hello %s!', 'ihosting' ), $current_user->display_name ) . '</p>';
	}

	wp_send_json( $response );

	die();
}

add_action( 'wp_ajax_nopriv_ihosting_do_login_via_ajax', 'ihosting_do_login_via_ajax' );
add_action( 'wp_ajax_ihosting_do_login_via_ajax', 'ihosting_do_login_via_ajax' );

function ihosting_do_register_via_ajax() {

	$response = array(
		'html'        => '',
		'register_ok' => 'no',
		'message'     => '',
	);

	$username = isset( $_POST['username'] ) ? $_POST['username'] : '';
	$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
	$password = isset( $_POST['password'] ) ? $_POST['password'] : '';
	$repassword = isset( $_POST['repassword'] ) ? $_POST['repassword'] : '';
	$agree = isset( $_POST['agree'] ) ? $_POST['agree'] : 'no';
	$register_nonce = isset( $_POST['register_nonce'] ) ? $_POST['register_nonce'] : '';

	if ( !wp_verify_nonce( $register_nonce, 'ajax-register-nonce' ) ) {
		$response['message'] = '<p class="text-danger bg-danger register-message">' . esc_html__( 'Security check error!', 'ihosting' ) . '</p>';
		wp_send_json( $response );
		die();
	}

	if ( trim( $username ) == '' ) {
		$response['message'] = '<p class="text-danger bg-danger register-message">' . esc_html__( 'User name can not be empty!', 'ihosting' ) . '</p>';
		wp_send_json( $response );
		die();
	}

	if ( !is_email( $email ) ) {
		$response['message'] = '<p class="text-danger bg-danger register-message">' . esc_html__( 'The Email Address is in an invalid format!', 'ihosting' ) . '</p>';
		wp_send_json( $response );
		die();
	}

	if ( trim( $password ) == '' ) {
		$response['message'] = '<p class="text-danger bg-danger register-message">' . esc_html__( 'Please enter a password!', 'ihosting' ) . '</p>';
		wp_send_json( $response );
		die();
	}

	if ( trim( $password ) != trim( $repassword ) ) {
		$response['message'] = '<p class="text-danger bg-danger register-message">' . esc_html__( 'Passwords did not match. Please try again!', 'ihosting' ) . '</p>';
		wp_send_json( $response );
		die();
	}

	if ( trim( $agree ) != 'yes' ) {
		$response['message'] = '<p class="text-danger bg-danger register-message">' . esc_html__( 'You must agree to our terms of use!', 'ihosting' ) . '</p>';
		wp_send_json( $response );
		die();
	}

	$user_id = username_exists( $username );

	if ( !$user_id and email_exists( $email ) == false ) {
		$user_id = wp_create_user( $username, $password, $email );
		if ( !is_wp_error( $user_id ) ) {
			$response['register_ok'] = 'yes';
			$response['message'] = '<p class="text-success bg-success register-message">' . esc_html__( 'Thank you! Registered successfully, now you can login.', 'ihosting' ) . '</p>';
		}
		else {
			$response['message'] = '<p class="text-danger bg-danger register-message">' . esc_html__( 'Registration failed. Please try again latter!', 'ihosting' ) . '</p>';
		}
	}
	else {
		$response['message'] = '<p class="text-danger bg-danger register-message">' . esc_html__( 'User already exists.', 'ihosting' ) . '</p>';
	}

	wp_send_json( $response );

	die();
}

add_action( 'wp_ajax_nopriv_ihosting_do_register_via_ajax', 'ihosting_do_register_via_ajax' );

if ( !function_exists( 'ihosting_loadmore_masonry_via_ajax' ) ) {

	function ihosting_loadmore_masonry_via_ajax() {
		global $ihosting;

		$load_more_text = isset( $ihosting['opt_blog_masonry_loadmore_text'] ) ? $ihosting['opt_blog_masonry_loadmore_text'] : esc_html__( 'Load more', 'ihosting' );
		$no_more_text = isset( $ihosting['opt_blog_masonry_nomore_text'] ) ? $ihosting['opt_blog_masonry_nomore_text'] : esc_html__( 'No more post', 'ihosting' );

		$response = array(
			'items'          => array(),
			'message'        => '',
			'load_more_text' => $load_more_text,
			'nomore_post'    => 'no',
		);

		$post__not_in = isset( $_POST['except_post_ids'] ) ? $_POST['except_post_ids'] : array( 0 );
		$sidebar_pos = isset( $_POST['sidebar_pos'] ) ? $_POST['sidebar_pos'] : 'right';
		$ihosting['opt_blog_sidebar_pos'] = $sidebar_pos;
		$ihosting['opt_blog_layout_style'] = 'masonry'; // Force blog layout masonry

		if ( !is_array( $post__not_in ) ) {
			$post__not_in = array( 0 );
		}

		$showposts = isset( $ihosting['opt_blog_masonry_loadmore_number'] ) ? max( 1, intval( $ihosting['opt_blog_masonry_loadmore_number'] ) ) : 6;

		$args = array(
			'showposts'    => $showposts,
			'post_status'  => array( 'publish' ),
			'paged'        => 1,
			'post__not_in' => $post__not_in,
		);

		$query_posts = new WP_Query( $args );
		$i = 0;

		if ( $query_posts->have_posts() ):

			while ( $query_posts->have_posts() ) : $query_posts->the_post();
				$i++;
				ob_start();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );
				$response['items'][] = ob_get_clean();

			endwhile;

		endif;
		wp_reset_postdata();

		if ( $i < $showposts ) { // Not really correct
			$response['load_more_text'] = $no_more_text;
			$response['nomore_post'] = 'yes';
		}

		wp_send_json( $response );

		die();
	}

	add_action( 'wp_ajax_ihosting_loadmore_masonry_via_ajax', 'ihosting_loadmore_masonry_via_ajax' );
	add_action( 'wp_ajax_nopriv_ihosting_loadmore_masonry_via_ajax', 'ihosting_loadmore_masonry_via_ajax' );
}


/** END FUNCTIONS FOR AJAX =================================== **/




