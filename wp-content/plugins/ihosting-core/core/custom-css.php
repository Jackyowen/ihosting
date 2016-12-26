<?php

/**
 * Customize css for iHosting theme
 **/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !function_exists( 'ihosting_core_get_custom_css' ) ) {
	function ihosting_core_get_custom_css() {
		global $ihosting;

		$base_color = isset( $ihosting['opt_general_accent_color'] ) ? $ihosting['opt_general_accent_color'] : array( 'color' => '#eec15b', 'alpha' => 1 );
		$root_base_color = $base_color['color'];
		$base_color = ihosting_color_hex2rgba( $base_color['color'], $base_color['alpha'] );

		$css = '';

		return $css;

		$css .= '.footer.style4 .widget li > a:hover { color: ' . $base_color . '; }
				.footer.style4 .kt_widget_newsletter .button {
                    background-color: ' . $base_color . '; }
                .footer.style4 .kt_widget_social .social a:hover {
                    border-color: ' . $base_color . '; }
				a { color: ' . $base_color . '; }
				.chosen-container-single .chosen-drop .chosen-results .highlighted {
					background-color: ' . $base_color . ';
				}
				.search-popup .popup-inner .btn-search { background-color: ' . $base_color . '; }
				.header-settings-wrap .header-settings-container ul.language-flag-switcher > li:hover, .header-settings-wrap .header-settings-container ul.language-flag-switcher > li.current-lang {
                    border-color: ' . $base_color . '; }
                .header-settings-wrap .header-settings-container ul.wcml_currency_switcher > li:hover, .header-settings-wrap .header-settings-container ul.wcml_currency_switcher > li.wcml-active-currency {
			        border-color: ' . $base_color . ';
			        color: ' . $base_color . '; }
		        .top-bar-right .header-account-wrap .header-account-icon a:hover, .top-bar-right .header-account-wrap .header-settings-icon a:hover, .top-bar-right .header-account-wrap .header-view-cart-icon a:hover, .top-bar-right .header-settings-wrap .header-account-icon a:hover, .top-bar-right .header-settings-wrap .header-settings-icon a:hover, .top-bar-right .header-settings-wrap .header-view-cart-icon a:hover, .top-bar-right .mini-shopping-cart-wrap .header-account-icon a:hover, .top-bar-right .mini-shopping-cart-wrap .header-settings-icon a:hover, .top-bar-right .mini-shopping-cart-wrap .header-view-cart-icon a:hover {
                    color: ' . $base_color . '; }
                .top-bar-right .header-account-wrap .header-link-wrap a:hover {
                    color: ' . $base_color . '; }
                .main-menu .megamenu .menu li > a:hover {
                    color: ' . $base_color . '; }
                .toggle-product-vertical-menu-wrap .toggle-vertical-menu, .toggle-product-vertical-menu-wrap .toggle-vertical-menu-mobile {
                    background-color: ' . $base_color . ';}
                .toggle-product-vertical-menu-wrap .vertical-menu-wrap .vertical-menu li a:hover {
                    color: ' . $base_color . '; }
                .toggle-product-vertical-menu-wrap .vertical-menu-wrap .vertical-menu li .megamenu .megamenu-content .menu li > a:hover {
                    color: ' . $base_color . '; }
                .header_style_2 .header-control-wrap .form-search-wrap .search-input-wrap .btn-search {
                    background-color: ' . $base_color . '; }
                .page-404 .search-form .search-submit:hover {
			        background-color: ' . $base_color . '; }
		        .body-coming-soon .page-maintenance .content-maintenance .form-newsletter button[type=submit]:hover {
                    background-color: ' . $base_color . '; }
                .tagcloud a:hover {
			        background-color: ' . $base_color . ';}
		        .read-more-btn:hover {
		            background-color: ' . $base_color . '; }
	            .posts-wrap article .entry-title a:hover {
                    color: ' . $base_color . '; }
                .posts-wrap.posts-default article.sticky .sticky-post {
				    background-color: ' . $base_color . ';}
			    .posts-standard article .post-title a:hover {
                    color: ' . $base_color . '; }
                .posts-standard article.sticky .sticky-post {
					background-color: ' . $base_color . ';}
				.blog-single .blog-item .entry-header .entry-title a:hover {
                    color: ' . $base_color . '; }
                .blog-single .blog-item .entry-meta > li a:hover {
                    color: ' . $base_color . '; }
                .blog-single .blog-item .entry-footer .group-share .social-share li a:hover {
                    color: ' . $base_color . '; }
                .comments-area .comment-list .comment .comment-body .comment-reply-link:hover {
                    color: ' . $base_color . '; }
                .comment-respond .comment-form .submit {
				    background-color: ' . $base_color . ';}
			    .comment-respond .comment-logout-url:hover {
			        color: ' . $base_color . '; }
		        .navigation .nav-links .page-numbers.current, .navigation .nav-links .page-numbers:hover {
			        background-color: ' . $base_color . ';}
		        .entry-content .page-links > a:hover, .entry-content .page-links > span:hover {
				    background-color: ' . $base_color . ';}
			    .entry-content .page-links > span {
			        background-color: ' . $base_color . '; }
		        .sidebar .widget li a:hover {
                    color: ' . $base_color . '; }
                .sidebar .widget ul li > a:hover {
                    color: ' . $base_color . '; }
                .sidebar .widget .search-form .search-submit:hover {
                    background-color: ' . $base_color . '; }
                .wpcf7 form input[type=submit] {
					border-color: ' . $base_color . ';
					background-color: ' . $base_color . ';}
				.woocommerce-product-search .search-input-wrap .products-suggestion-list > li a:hover {
                    color: ' . $base_color . '; }
                .woocommerce-product-search.searching .spinner {
                    color: ' . $base_color . '; }
				';

		$custom_css = isset( $ihosting['opt_general_css_code'] ) ? $ihosting['opt_general_css_code'] : '';

		$css .= $custom_css;

		return $css;
	}
}

if ( !function_exists( 'ihosting_core_custom_css' ) ) {
	function ihosting_core_custom_css() {
		global $ihosting;

		$how_to_load_custom_css = isset( $ihosting['opt_how_to_load_custom_css'] ) ? $ihosting['opt_how_to_load_custom_css'] : 'wp_head';

		if ( $how_to_load_custom_css = 'wp_head' ) {
			$css = ihosting_core_get_custom_css();

			wp_enqueue_style(
				'lk-core-custom-css',
				IHOSTINGCORE_CSS_URL . 'custom.css'
			);

			wp_add_inline_style( 'lk-core-custom-css', $css );

		}
	}

	add_action( 'wp_enqueue_scripts', 'ihosting_core_custom_css' );
}


if ( !function_exists( 'ihosting_enqueue_style_via_ajax' ) ) {
	function ihosting_enqueue_style_via_ajax() {
		global $ihosting;

		$base_color = isset( $ihosting['opt_general_accent_color'] ) ? $ihosting['opt_general_accent_color'] : array( 'color' => '#bda47d', 'alpha' => 1 );
		$root_base_color = $base_color['color'];
		$base_color = ihosting_color_hex2rgba( $base_color['color'], $base_color['alpha'] );

		// For custom frontend if needed
		if ( isset( $_REQUEST['base_color'] ) ) {
			if ( trim( isset( $_REQUEST['base_color'] ) ) != '' ) {
				$base_color = trim( $_REQUEST['base_color'] );
				$root_base_color = $base_color;
			}
		}

		header( 'Content-type: text/css; charset: UTF-8' );

		$css = '';

		// Overide file style.css in themes/ihosting/styles.css
		$css .= '.comment-form .form-submit .submit{
                    background-color: ' . $base_color . ';
                }
                ';

		$custom_css = isset( $ihosting['opt_general_css_code'] ) ? $ihosting['opt_general_css_code'] : '';

		echo $css . $custom_css;

		wp_die();
	}
}

add_action( 'wp_ajax_ihosting_enqueue_style_via_ajax', 'ihosting_enqueue_style_via_ajax' );
add_action( 'wp_ajax_nopriv_ihosting_enqueue_style_via_ajax', 'ihosting_enqueue_style_via_ajax' );


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
