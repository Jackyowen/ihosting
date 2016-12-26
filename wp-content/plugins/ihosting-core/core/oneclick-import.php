<?php
/*
 * @package     WBC_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0
 */


/************************************************************************
 * Importer will auto load, there is no settings required to put in your
 * Reduxframework config file.
 *
 * BUT- If you want to put the demo importer in a different position on
 * the panel, use the below within your config for Redux.
 *************************************************************************/
// $this->sections[] = array(
//     'id' => 'wbc_importer_section',
//     'title'  => esc_html__( 'Demo Content', 'ihosting-core' ),
//     'desc'   => esc_html__( 'Description Goes Here', 'ihosting-core' ),
//     'icon'   => 'el-icon-website',
//     'fields' => array(
//                     array(
//                         'id'   => 'wbc_demo_importer',
//                         'type' => 'wbc_importer'
//                         )
//                 )
//     );

/************************************************************************
 * Example functions/filters
 *************************************************************************/

if ( !function_exists( 'ihosting_before_content_import' ) ) {
	function ihosting_before_content_import() {

		// Set some WooCommerce $attributes
		if ( class_exists( 'WooCommerce' ) ) {
			global $wpdb;

			if ( current_user_can( 'administrator' ) ) {
				$attributes = array(
					array(
						'attribute_label'   => 'Color',
						'attribute_name'    => 'color',
						'attribute_type'    => 'select',
						'attribute_orderby' => 'menu_order',
						'attribute_public'  => '0'
					),
					array(
						'attribute_label'   => 'Size',
						'attribute_name'    => 'size',
						'attribute_type'    => 'select',
						'attribute_orderby' => 'menu_order',
						'attribute_public'  => '0'
					),
				);

				foreach ( $attributes as $attribute ):
					if ( empty( $attribute['attribute_name'] ) || empty( $attribute['attribute_label'] ) ) {
						return new WP_Error( 'error', __( 'Please, provide an attribute name and slug.', 'woocommerce' ) );
					}
					elseif ( ( $valid_attribute_name = ihosting_wc_valid_attribute_name( $attribute['attribute_name'] ) ) && is_wp_error( $valid_attribute_name ) ) {
						return $valid_attribute_name;
					}
					elseif ( taxonomy_exists( wc_attribute_taxonomy_name( $attribute['attribute_name'] ) ) ) {
						return new WP_Error( 'error', sprintf( __( 'Slug "%s" is already in use. Change it, please.', 'woocommerce' ), sanitize_title( $attribute['attribute_name'] ) ) );
					}

					$wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );

					do_action( 'woocommerce_attribute_added', $wpdb->insert_id, $attribute );

					flush_rewrite_rules();
					delete_transient( 'wc_attribute_taxonomies' );
				endforeach;
			}

		}

	}

	add_action( 'lk_before_content_import', 'ihosting_before_content_import' );
}

if ( !function_exists( 'ihosting_wc_valid_attribute_name' ) ) {
	function ihosting_wc_valid_attribute_name( $attribute_name ) {
		if ( !class_exists( 'WooCommerce' ) ) {
			return false;
		}

		if ( strlen( $attribute_name ) >= 28 ) {
			return new WP_Error( 'error', sprintf( __( 'Slug "%s" is too long (28 characters max). Shorten it, please.', 'woocommerce' ), sanitize_title( $attribute_name ) ) );
		}
		elseif ( wc_check_if_attribute_name_is_reserved( $attribute_name ) ) {
			return new WP_Error( 'error', sprintf( __( 'Slug "%s" is not allowed because it is a reserved term. Change it, please.', 'woocommerce' ), sanitize_title( $attribute_name ) ) );
		}

		return true;
	}
}


if ( !function_exists( 'wbc_after_content_import' ) ) {

	/**
	 * Function/action ran after import of content.xml file
	 *
	 * @param (array) $demo_active_import       Example below
	 *            [wbc-import-1] => Array
	 *            (
	 *            [directory] => current demo data folder name
	 *            [content_file] => content.xml
	 *            [image] => screen-image.png
	 *            [theme_options] => theme-options.txt
	 *            [widgets] => widgets.json
	 *            [imported] => imported
	 *            )
	 * @param (string) $demo_data_directory_path path to current demo folder being imported.
	 *
	 */

	function wbc_after_content_import( $demo_active_import, $demo_data_directory_path ) {
		//Do something

		// Update some options

		// WooCommerce options
		$shop_page = get_page_by_title( 'Shop' );
		if ( isset( $shop_page->ID ) ) {
			update_option( 'woocommerce_shop_page_id', $shop_page->ID );
		}

		$checkout_page = get_page_by_title( 'Checkout' );
		if ( isset( $checkout_page->ID ) ) {
			update_option( 'woocommerce_checkout_page_id', $checkout_page->ID );
		}

		$myaccount_page = get_page_by_title( 'My Account' );
		if ( isset( $myaccount_page->ID ) ) {
			update_option( 'woocommerce_myaccount_page_id', $myaccount_page->ID );
		}

		$cart_page = get_page_by_title( 'Cart' );
		if ( isset( $cart_page->ID ) ) {
			update_option( 'woocommerce_cart_page_id', $cart_page->ID );
		}

		// Shop ajax filter options
		update_option( 'woof_first_init', '1' );
		update_option( 'woof_set_automatically', '0' );
		update_option( 'woof_autosubmit', '1' );
		update_option( 'woof_show_count', '1' );
		update_option( 'woof_show_count_dynamic', '0' );
		update_option( 'woof_try_ajax', '1' );
		update_option( 'woof_checkboxes_slide', '1' );
		update_option( 'woof_hide_red_top_panel', '0' );
		$woof_settings = unserialize( 'a:42:{s:11:"items_order";s:0:"";s:8:"by_price";a:6:{s:4:"show";s:1:"0";s:11:"show_button";s:1:"0";s:10:"title_text";s:0:"";s:6:"ranges";s:0:"";s:17:"first_option_text";s:0:"";s:15:"ion_slider_step";s:1:"1";}s:8:"tax_type";a:4:{s:11:"product_cat";s:5:"radio";s:11:"product_tag";s:5:"radio";s:8:"pa_color";s:5:"radio";s:7:"pa_size";s:5:"radio";}s:14:"excluded_terms";a:4:{s:11:"product_cat";s:0:"";s:11:"product_tag";s:0:"";s:8:"pa_color";s:0:"";s:7:"pa_size";s:0:"";}s:16:"tax_block_height";a:4:{s:11:"product_cat";s:1:"0";s:11:"product_tag";s:1:"0";s:8:"pa_color";s:1:"0";s:7:"pa_size";s:1:"0";}s:16:"show_title_label";a:4:{s:11:"product_cat";s:1:"0";s:11:"product_tag";s:1:"0";s:8:"pa_color";s:1:"0";s:7:"pa_size";s:1:"0";}s:18:"show_toggle_button";a:4:{s:11:"product_cat";s:1:"0";s:11:"product_tag";s:1:"0";s:8:"pa_color";s:1:"0";s:7:"pa_size";s:1:"0";}s:13:"dispay_in_row";a:4:{s:11:"product_cat";s:1:"0";s:11:"product_tag";s:1:"0";s:8:"pa_color";s:1:"0";s:7:"pa_size";s:1:"0";}s:16:"custom_tax_label";a:4:{s:11:"product_cat";s:0:"";s:11:"product_tag";s:0:"";s:8:"pa_color";s:0:"";s:7:"pa_size";s:0:"";}s:11:"icheck_skin";s:4:"none";s:12:"overlay_skin";s:7:"default";s:19:"overlay_skin_bg_img";s:0:"";s:18:"plainoverlay_color";s:0:"";s:25:"default_overlay_skin_word";s:0:"";s:10:"use_chosen";s:1:"1";s:17:"use_beauty_scroll";s:1:"0";s:15:"ion_slider_skin";s:8:"skinNice";s:25:"woof_auto_hide_button_img";s:0:"";s:25:"woof_auto_hide_button_txt";s:0:"";s:26:"woof_auto_subcats_plus_img";s:0:"";s:27:"woof_auto_subcats_minus_img";s:0:"";s:11:"toggle_type";s:4:"text";s:18:"toggle_opened_text";s:0:"";s:18:"toggle_closed_text";s:0:"";s:19:"toggle_opened_image";s:0:"";s:19:"toggle_closed_image";s:0:"";s:16:"custom_front_css";s:0:"";s:15:"custom_css_code";s:0:"";s:18:"js_after_ajax_done";s:0:"";s:12:"init_only_on";s:0:"";s:15:"wpml_tax_labels";s:0:"";s:8:"per_page";s:2:"-1";s:14:"non_latin_mode";s:1:"1";s:12:"storage_type";s:7:"session";s:20:"hide_terms_count_txt";s:1:"0";s:25:"listen_catalog_visibility";s:1:"0";s:23:"disable_swoof_influence";s:1:"0";s:16:"cache_count_data";s:1:"0";s:11:"cache_terms";s:1:"0";s:19:"show_woof_edit_view";s:1:"1";s:22:"custom_extensions_path";s:0:"";s:20:"activated_extensions";s:0:"";}' );
		$current_woof_settings = get_option( 'woof_settings', $woof_settings );
		update_option( 'woof_settings', $current_woof_settings );

	}

	// Uncomment the below
	add_action( 'wbc_importer_after_content_import', 'wbc_after_content_import', 10, 2 );
}

if ( !function_exists( 'wbc_filter_title' ) ) {

	/**
	 * Filter for changing demo title in options panel so it's not folder name.
	 *
	 * @param  [string] $title name of demo data folder
	 *
	 * @return [string] return title for demo name.
	 */

	function wbc_filter_title( $title ) {
		if ( $title == 'ihosting' ) {
			return 'iHosting Home 1-2-3-4';
		}

		return trim( ucwords( preg_replace( '/(_|-)+/', ' ', $title ) ) );
	}

	// Uncomment the below
	add_filter( 'wbc_importer_directory_title', 'wbc_filter_title', 10 );
}

if ( !function_exists( 'wbc_importer_description_text' ) ) {

	/**
	 * Filter for changing importer description info in options panel
	 * when not setting in Redux config file.
	 *
	 * @param  [string] $title description above demos
	 *
	 * @return [string] return.
	 */

	function wbc_importer_description_text( $description ) {

		$message = '<p>' . esc_html__( 'Works best to import on a new install of WordPress. Images are for demo purpose only.', 'ihosting-core' ) . '</p>';

		return $message;
	}

	// Uncomment the below
	add_filter( 'wbc_importer_description', 'wbc_importer_description_text', 10 );
}

if ( !function_exists( 'wbc_importer_label_text' ) ) {

	/**
	 * Filter for changing importer label/tab for redux section in options panel
	 * when not setting in Redux config file.
	 *
	 * @param  [string] $title label above demos
	 *
	 * @return [string] return no html
	 */

	function wbc_importer_label_text( $label_text ) {

		$label_text = __( 'iHosting Importer', 'ihosting-core' );

		return $label_text;
	}

	// Uncomment the below
	add_filter( 'wbc_importer_label', 'wbc_importer_label_text', 10 );
}

if ( !function_exists( 'wbc_change_demo_directory_path' ) ) {

	/**
	 * Change the path to the directory that contains demo data folders.
	 *
	 * @param  [string] $demo_directory_path
	 *
	 * @return [string]
	 */

	function wbc_change_demo_directory_path( $demo_directory_path ) {

		$demo_directory_path = IHOSTINGCORE_LIBS . 'demo-data/';

		return $demo_directory_path;

	}

	// Uncomment the below
	add_filter( 'wbc_importer_dir_path', 'wbc_change_demo_directory_path' );
}

if ( !function_exists( 'wbc_importer_before_widget' ) ) {

	/**
	 * Function/action ran before widgets get imported
	 *
	 * @param (array) $demo_active_import       Example below
	 *            [wbc-import-1] => Array
	 *            (
	 *            [directory] => current demo data folder name
	 *            [content_file] => content.xml
	 *            [image] => screen-image.png
	 *            [theme_options] => theme-options.txt
	 *            [widgets] => widgets.json
	 *            [imported] => imported
	 *            )
	 * @param (string) $demo_data_directory_path path to current demo folder being imported.
	 *
	 * @return nothing
	 */

	function wbc_importer_before_widget( $demo_active_import, $demo_data_directory_path ) {

		//Do Something
		//update_option( 'tdf_consumer_key', 'LPxUwy0VIHynyiybsyOhu04IL' );
		//        update_option( 'tdf_consumer_secret', '3CZsE7FdoG7WinQRoRzTfcIg8MbIYyVDEnzTZ69N9YpxDaGhEd' );
		//        update_option( 'tdf_access_token', '3070007774-YxYRsRZqXPbXVC5Zx1E6op8E4QHsdQz2nuwQp4l' );
		//        update_option( 'tdf_access_token_secret', 'V8kX8HpAQHoQaPNutwq6jDTq2GdvDgepqfTx55ezeRXWa' );
		//        update_option( 'tdf_cache_expire', '3600' );
		//        update_option( 'tdf_user_timeline', 'envato' );

	}

	// Uncomment the below
	add_action( 'wbc_importer_before_widget_import', 'wbc_importer_before_widget', 10, 2 );
}

if ( !function_exists( 'ihosting_after_theme_options' ) ) {

	/**
	 * Function/action ran after theme options set
	 *
	 * @param (array) $demo_active_import       Example below
	 *            [wbc-import-1] => Array
	 *            (
	 *            [directory] => current demo data folder name
	 *            [content_file] => content.xml
	 *            [image] => screen-image.png
	 *            [theme_options] => theme-options.txt
	 *            [widgets] => widgets.json
	 *            [imported] => imported
	 *            )
	 * @param (string) $demo_data_directory_path path to current demo folder being imported.
	 *
	 * @return nothing
	 */

	function ihosting_after_theme_options( $demo_active_import, $demo_data_directory_path ) {

		// Update Visual Composer roles

		// administrator
		ihosting_add_cap( 'administrator', 'vc_access_rules_post_types/page' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_post_types/megamenu' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_post_types/footer' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_post_types', 'custom' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_backend_editor' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_frontend_editor' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_post_settings' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_settings' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_templates' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_shortcodes' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_grid_builder' );
		ihosting_add_cap( 'administrator', 'vc_access_rules_presets' );

		// editor
		ihosting_add_cap( 'editor', 'vc_access_rules_post_types' );
		ihosting_add_cap( 'editor', 'vc_access_rules_backend_editor' );
		ihosting_add_cap( 'editor', 'vc_access_rules_frontend_editor' );
		ihosting_add_cap( 'editor', 'vc_access_rules_post_settings' );
		ihosting_add_cap( 'editor', 'vc_access_rules_templates' );
		ihosting_add_cap( 'editor', 'vc_access_rules_shortcodes' );
		ihosting_add_cap( 'editor', 'vc_access_rules_grid_builder' );
		ihosting_add_cap( 'editor', 'vc_access_rules_presets' );

		// author
		ihosting_add_cap( 'author', 'vc_access_rules_post_types' );
		ihosting_add_cap( 'author', 'vc_access_rules_backend_editor' );
		ihosting_add_cap( 'author', 'vc_access_rules_frontend_editor' );
		ihosting_add_cap( 'author', 'vc_access_rules_post_settings' );
		ihosting_add_cap( 'author', 'vc_access_rules_templates' );
		ihosting_add_cap( 'author', 'vc_access_rules_shortcodes' );
		ihosting_add_cap( 'author', 'vc_access_rules_grid_builder' );
		ihosting_add_cap( 'author', 'vc_access_rules_presets' );

		// shop_manager
		ihosting_add_cap( 'shop_manager', 'vc_access_rules_post_types' );
		ihosting_add_cap( 'shop_manager', 'vc_access_rules_backend_editor' );
		ihosting_add_cap( 'shop_manager', 'vc_access_rules_frontend_editor' );
		ihosting_add_cap( 'shop_manager', 'vc_access_rules_post_settings' );
		ihosting_add_cap( 'shop_manager', 'vc_access_rules_templates' );
		ihosting_add_cap( 'shop_manager', 'vc_access_rules_shortcodes' );
		ihosting_add_cap( 'shop_manager', 'vc_access_rules_grid_builder' );
		ihosting_add_cap( 'shop_manager', 'vc_access_rules_presets' );
	}

	// Uncomment the below
	add_action( 'wbc_importer_after_theme_options_import', 'ihosting_after_theme_options', 10, 2 );
}

if ( !function_exists( 'ihosting_add_cap' ) ) {
	function ihosting_add_cap( $role_name = 'administrator', $cap = '', $grant = true ) {

		if ( trim( $cap ) == '' ) {
			return;
		}

		$role = get_role( $role_name );
		$role->add_cap( $cap, $grant );

	}
}


/************************************************************************
 * Extended Example:
 * Way to set menu, import revolution slider, and set home page.
 *************************************************************************/

if ( !function_exists( 'kt_extended_import' ) ) {
	function kt_extended_import( $demo_active_import, $demo_directory_path ) {

		reset( $demo_active_import );
		$current_key = key( $demo_active_import );

		/************************************************************************
		 * Setting Menus
		 *************************************************************************/

		$wbc_menu_array = array(
			'ihosting',
			'home-5',
		);

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
			$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
			if ( !isset( $main_menu->term_id ) ) {
				$main_menu = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
			}

			$vertical_menu = get_term_by( 'name', 'Vertical Menu', 'nav_menu' );
			if ( !isset( $vertical_menu->term_id ) ) {
				$vertical_menu = get_term_by( 'name', 'Vertical Menu For Header Layout Style 2, 5, 7', 'nav_menu' );
			}

			$small_menu_for_header_5 = get_term_by( 'name', 'Small Menu For Header Layout Style 5', 'nav_menu' );

			if ( isset( $main_menu->term_id ) ) {
				set_theme_mod(
					'nav_menu_locations',
					array(
						'primary' => $main_menu->term_id,
					)
				);
			}

			if ( isset( $vertical_menu->term_id ) ) {
				set_theme_mod(
					'nav_menu_locations',
					array(
						'vertical_menu_for_header' => $vertical_menu->term_id,
					)
				);
			}

			if ( isset( $small_menu_for_header_5->term_id ) ) {
				set_theme_mod(
					'nav_menu_locations',
					array(
						'small_menu_for_header_layout_style_5' => $small_menu_for_header_5->term_id,
					)
				);
			}
		}


		/************************************************************************
		 * Import slider(s) for the current demo being imported
		 *************************************************************************/
		if ( class_exists( 'RevSlider' ) ) {

			$wbc_sliders_array = array(
				'ihosting' => array(
					'revslider/home-1.zip',
					'revslider/home-2.zip',
					'revslider/home-3.zip',
					'revslider/home-4.zip',
					'revslider/hh_5.zip',
				), //Set slider zip name
				'home-5'    => array(
					'revslider/hh_5.zip',
				)
			);

			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
				//$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
				$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
				if ( is_array( $wbc_slider_import ) ) {
					if ( !empty( $wbc_slider_import ) ) {
						foreach ( $wbc_slider_import as $wbc_slider_import_name ) {
							if ( file_exists( $demo_directory_path . $wbc_slider_import_name ) ) {
								$slider = new RevSlider();
								$slider->importSliderFromPost( true, true, $demo_directory_path . $wbc_slider_import_name );
							}
						}
					}
				}
				else {
					if ( file_exists( $demo_directory_path . $wbc_slider_import ) ) {
						$slider = new RevSlider();
						$slider->importSliderFromPost( true, true, $demo_directory_path . $wbc_slider_import );
					}
				}

			}
		}


		/************************************************************************
		 * Set HomePage
		 *************************************************************************/

		// array of demos/homepages to check/select from
		$wbc_home_pages = array(
			'ihosting' => 'Home 1',
		);

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
			$home_page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $home_page->ID ) ) {
				update_option( 'page_on_front', $home_page->ID );
				update_option( 'show_on_front', 'page' );
			}
		}

		// Set blog page
		$blog_page = get_page_by_title( 'Blog' );
		if ( isset( $blog_page->ID ) ) {
			update_option( 'page_for_posts', $blog_page->ID );
		}

	}

	add_action( 'wbc_importer_after_content_import', 'kt_extended_import', 10, 2 );
}
