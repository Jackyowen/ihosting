<?php
/**
 * iHosting functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package iHosting
 */


function ihosting_init() {
	define( 'IHOSTING_THEME_VERSION', '1.0.2' );
}

add_action( 'init', 'ihosting_init' );

/**
 * Load global localize
 */
require get_template_directory() . '/engine/global-localize.php';

if ( !function_exists( 'ihosting_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ihosting_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on iHosting, use a find and replace
		 * to change 'ihosting' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ihosting', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary'                              => esc_html__( 'Primary Menu', 'ihosting' ),
				'footer_menu'                          => esc_html__( 'Footer Menu', 'ihosting' ),
				'small_menu_for_header_layout_style_5' => esc_html__( 'Small Menu For Header Layout Style 5', 'ihosting' ),
				'vertical_menu_for_header'             => esc_html__( 'Vertical Menu For Header Layout Style 2, 5, 7', 'ihosting' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'audio',
				'video',
				'gallery',
				'quote',
				'link',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'ihosting_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Screen reader text
		add_theme_support( 'screen-reader-text' );

		// Declare WooCommerce support
		add_theme_support( 'woocommerce' );

	}
endif; // ihosting_setup
add_action( 'after_setup_theme', 'ihosting_setup' );

if ( !function_exists( 'ihosting_fonts_url' ) ) {
	/**
	 * Register Google fonts for Twenty Fifteen.
	 *
	 * @since Lucky Shop 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function ihosting_fonts_url() {
		$fonts_url = '';
		$fonts = array();
		$subsets = 'latin,latin-ext';

		/*
		 * Translators: If there are characters in your language that are not supported
		 * by Open Sans, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'ihosting' ) ) {
			$fonts[] = 'Open Sans:400,400i,600,600i,700,700i';
		}

		/*
		 * Translators: To add an additional character subset specific to your language,
		 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'ihosting' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		}
		elseif ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		}
		elseif ( 'devanagari' == $subset ) {
			$subsets .= ',devanagari';
		}
		elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( $subsets ),
				), 'https://fonts.googleapis.com/css'
			);
		}

		return $fonts_url;
	}
};

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ihosting_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ihosting_content_width', 640 );
}

add_action( 'after_setup_theme', 'ihosting_content_width', 0 );

if ( !function_exists( 'ihosting_widgets_init' ) ) {
	/**
	 * Register widget area.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function ihosting_widgets_init() {
		global $ihosting;

		// Sidebar 1 (default sidebar)
		register_sidebar(
			array(
				'name'          => esc_html__( 'Primary Sidebar', 'ihosting' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Add widgets here to appear in your sidebar', 'ihosting' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h5 class="widget-title">',
				'after_title'   => '</h5>',
			)
		);

		// Sidebar for single post
		register_sidebar(
			array(
				'name'          => esc_html__( 'Single Post Sidebar', 'ihosting' ),
				'id'            => 'sidebar-single-post',
				'description'   => esc_html__( 'Sidebar display on single post', 'ihosting' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h5 class="widget-title">',
				'after_title'   => '</h5>',
			)
		);

		$total_footer_sidebars = isset( $ihosting['opt_footer_sidebar_layout'] ) ? min( 4, max( 0, intval( $ihosting['opt_footer_sidebar_layout'] ) ) ) : 4;
		$enable_footer_sidebars = isset( $ihosting['opt_enable_footer_sidebars'] ) ? intval( $ihosting['opt_enable_footer_sidebars'] ) == 1 && $total_footer_sidebars > 0 : false;

		/*
		 * Register sidebar footer top widgets
		*/
		if ( $enable_footer_sidebars ):

			for ( $i = 1; $i <= $total_footer_sidebars; $i++ ):
				register_sidebar(
					array(
						'name'          => sprintf( esc_html__( 'Footer Sidebar %d', 'ihosting' ), $i ),
						'id'            => 'footer-sidebar-' . intval( $i ),
						'description'   => esc_html__( 'This is a footer sidebar', 'ihosting' ),
						'before_title'  => '<h5 class="widget-title">',
						'after_title'   => '</h5>',
						'before_widget' => '<div class="%1$s widget %2$s">',
						'after_widget'  => '</div>',
					)
				);
			endfor;

		endif;

		// Sidebar shop for WooCommerce
		if ( class_exists( 'WooCommerce' ) ):

			register_sidebar(
				array(
					'name'          => esc_html__( 'Sidebar Shop', 'ihosting' ),
					'id'            => 'sidebar-shop',
					'description'   => esc_html__( 'Sidebar display on shop page', 'ihosting' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h5 class="widget-title">',
					'after_title'   => '</h5>',
				)
			);

			register_sidebar(
				array(
					'name'          => esc_html__( 'Sidebar Single Product', 'ihosting' ),
					'id'            => 'sidebar-single-product',
					'description'   => esc_html__( 'Sidebar display on single product page', 'ihosting' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h5 class="widget-title">',
					'after_title'   => '</h5>',
				)
			);

		endif;

	}

	add_action( 'widgets_init', 'ihosting_widgets_init' );
}

if ( !function_exists( 'ihosting_enqueue_font_icons' ) ) {
	function ihosting_enqueue_font_icons() {

		// Simple line font icons
		wp_register_style( 'simple-line-icons', get_template_directory_uri() . '/assets/vendors/simple-line-icons/simple-line-icons.css', array(), IHOSTING_THEME_VERSION, 'all' );
		wp_enqueue_style( 'simple-line-icons' );

		// Linea font icons
		//		wp_register_style( 'linea-arrows', get_template_directory_uri() . '/assets/vendors/linea-font-icons/css/linea-arrows.css', array(), IHOSTING_THEME_VERSION, 'all' );
		//		wp_enqueue_style( 'linea-arrows' );
		//		wp_register_style( 'linea-basic', get_template_directory_uri() . '/assets/vendors/linea-font-icons/css/linea-basic.css', array(), IHOSTING_THEME_VERSION, 'all' );
		//		wp_enqueue_style( 'linea-basic' );
		//		wp_register_style( 'linea-basic-elaboration', get_template_directory_uri() . '/assets/vendors/linea-font-icons/css/linea-basic-elaboration.css', array(), IHOSTING_THEME_VERSION, 'all' );
		//		wp_enqueue_style( 'linea-basic-elaboration' );
		//		wp_register_style( 'linea-ecommerce', get_template_directory_uri() . '/assets/vendors/linea-font-icons/css/linea-ecommerce.css', array(), IHOSTING_THEME_VERSION, 'all' );
		//		wp_enqueue_style( 'linea-ecommerce' );
		//		wp_register_style( 'linea-music', get_template_directory_uri() . '/assets/vendors/linea-font-icons/css/linea-music.css', array(), IHOSTING_THEME_VERSION, 'all' );
		//		wp_enqueue_style( 'linea-music' );
		//		wp_register_style( 'linea-software', get_template_directory_uri() . '/assets/vendors/linea-font-icons/css/linea-software.css', array(), IHOSTING_THEME_VERSION, 'all' );
		//		wp_enqueue_style( 'linea-software' );
		//		wp_register_style( 'linea-weather', get_template_directory_uri() . '/assets/vendors/linea-font-icons/css/linea-weather.css', array(), IHOSTING_THEME_VERSION, 'all' );
		//		wp_enqueue_style( 'linea-weather' );
	}
}


if ( !function_exists( 'ihosting_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 */
	function ihosting_scripts() {
		$ihosting_global_localize = function_exists( 'ihosting_get_global_localize' ) ? ihosting_get_global_localize() : array();

		// Add custom fonts, used in the main stylesheet.
		wp_enqueue_style( 'ihosting-fonts', ihosting_fonts_url(), array(), null );

		// Fonts
		ihosting_enqueue_font_icons();

		wp_enqueue_style( 'bootstrap.min', get_template_directory_uri() . '/assets/vendors/bootstrap/css/bootstrap.min.css', false, IHOSTING_THEME_VERSION, 'all' );
		wp_enqueue_style( 'ihosting-style', get_stylesheet_uri(), false, IHOSTING_THEME_VERSION, 'all' );

		if ( is_rtl() ) {
			wp_enqueue_style( 'bootstrap-rtl.min', get_template_directory_uri() . '/assets/vendors/bootstrap-rtl/css/bootstrap-rtl.min.css', false, IHOSTING_THEME_VERSION, 'all' );
		}

		wp_enqueue_style(
			'ihosting-frontend',
			get_template_directory_uri() . '/assets/css/frontend.css'
		);

		wp_enqueue_style(
			'ihosting-custom-style',
			get_template_directory_uri() . '/assets/css/custom.css'
		);

		// iHosting js
		wp_enqueue_script( 'jquery-ui-accordion' );

		if ( wp_is_mobile() ) {
			$ihosting_global_localize['is_mobile'] = 'true';
			if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) !== false ) {
				$ihosting_global_localize['may_be_iphone'] = 'true';
			}
		}

		// Right to left
		if ( is_rtl() ) {
			$ihosting_global_localize['is_rtl'] = 'yes';
			$ihosting_global_localize['mmenu_position'] = 'right';
		}
		else {
			$ihosting_global_localize['is_rtl'] = 'no';
			$ihosting_global_localize['mmenu_position'] = 'left';
		}

		//wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/js/bootstrap.js', array(), false, true );

		//wp_enqueue_script( 'jquery.mmenu.backbutton.min', get_template_directory_uri() . '/assets/vendors/mmenu/addons/backbutton/jquery.mmenu.backbutton.min.js', array(), IHOSTING_THEME_VERSION, true );
		wp_enqueue_script( 'ihosting-frontend', get_template_directory_uri() . '/assets/js/frontend.js', array(), IHOSTING_THEME_VERSION, true );

		wp_localize_script( 'ihosting-frontend', 'ajaxurl', get_admin_url() . '/admin-ajax.php' );
		wp_localize_script( 'ihosting-frontend', 'ihosting', $ihosting_global_localize );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Right to left
		if ( is_rtl() ) {
			wp_enqueue_script( 'ihosting-frontend-rtl', get_template_directory_uri() . '/assets/js/frontend-rtl.js', array(), IHOSTING_THEME_VERSION, true );
		}


	}

	add_action( 'wp_enqueue_scripts', 'ihosting_scripts', 20 );
}

if ( !function_exists( 'ihosting_admin_enqueue_js' ) ) {

	/**
	 * Enqueue Admin js
	 */
	function ihosting_admin_enqueue_js() {
		$ihosting_global_localize = function_exists( 'ihosting_get_global_localize' ) ? ihosting_get_global_localize() : array();

		if ( wp_is_mobile() ) {
			$ihosting_global_localize['is_mobile'] = 'true';
			if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) !== false ) {
				$ihosting_global_localize['may_be_iphone'] = 'true';
			}
		}

		wp_add_inline_style( 'wp-admin', '#setting-error-tgmpa { display: block; }' );

		ihosting_enqueue_font_icons();
		add_editor_style( get_stylesheet_uri() );

		wp_localize_script( 'ihostingcore-admin-scripts', 'ihosting', $ihosting_global_localize );

	}

	add_action( 'admin_enqueue_scripts', 'ihosting_admin_enqueue_js' );
}


/**
 *  Load required plugins
 */
require_once get_template_directory() . "/engine/plugins-load.php";

/**
 * Breadcrumbs Trail
 */
require_once get_template_directory() . '/engine/classes/breadcrumbs.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/engine/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require_once get_template_directory() . '/engine/advance-functions.php';

/**
 *  Load Bootstrap Menu Walker
 */
require_once get_template_directory() . "/engine/classes/ts_bootstrap_navwalker.php";

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/engine/customizer.php';

/**
 * Load Theme Coming Soon Template
 */
require_once get_template_directory() . "/engine/coming-soon-template.php";


/**
 * Load Jetpack compatibility file.
 */
//require get_template_directory() . '/engine/jetpack.php';
