<?php
/**
 * Global Functions
 *
 * @package iHosting 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


/**
 *  Display wp errors (notes) messages
 *
 * @param $notes : array or string of notes
 *
 * @since 1.0
 **/
function ihosting_display_note( $notes, $type = 'error', $echo = true ) {
	$html = '';

	if ( !empty( $notes ) ) {
		$class = ( $type == 'error' ) ? 'error' : 'updated';
		$class .= ' ihosting-mesage';

		$html .= '<div class="' . $class . ' below-h2" >'; // error
		if ( is_array( $notes ) ) {
			$html .= '<ul>';
			foreach ( $notes as $e ) {
				$html .= '<li>' . ( $e ) . '</li>';
			}
			$html .= '</ul>';
		}
		else {
			$html .= '<p>' . ( $notes ) . '</p>';
		}

		$html .= '</div>';
	}

	if ( $echo ) {
		echo $html;
	}
	else {
		return $html;
	}
}

if ( !function_exists( 'ihosting_core_meta_tags' ) ) {

	/**
	 * Meta tags
	 **/
	function ihosting_core_meta_tags() {
		global $ihosting;

		echo '<meta name="robots" content="NOODP">';

		if ( is_front_page() && is_home() ) {
			// Default homepage
			echo '<meta name="description" content="' . get_bloginfo( 'description' ) . '" />';
		}
		elseif ( is_front_page() ) {
			// static homepage
			echo '<meta name="description" content="' . get_bloginfo( 'description' ) . '" />';
		}
		elseif ( is_home() ) {
			// blog page
			echo '<meta name="description" content="' . get_bloginfo( 'description' ) . '" />';
		}
		else {
			//everything else

			// Is a singular
			if ( is_singular() ) {
				echo '<meta name="description" content="' . single_post_title( '', false ) . '" />';
			}
			else {
				// Is archive or taxonomy
				if ( is_archive() ) {
					// Checking for shop archive
					if ( function_exists( 'is_shop' ) ) { // Products archive, products category, products search page...
						if ( is_shop() ) {
							$post_id = get_option( 'woocommerce_shop_page_id' );
							$use_custom_title = get_post_meta( $post_id, '_ihosting_use_custom_title', true ) == 'yes';

							if ( $use_custom_title ) {
								echo '<meta name="description" content="' . ihosting_single_title( $post_id ) . '" />';
							}
							else {
								echo '<meta name="description" content="' . woocommerce_page_title( false ) . '" />';
							}
						}
					}
					else {
						echo '<meta name="description" content="' . get_the_archive_description() . '" />';
					}
				}
				else {
					if ( is_404() ) {
						$not_found_text = isset( $ihosting['opt_404_header_title'] ) ? $ihosting['opt_404_header_title'] : esc_html__( 'Oops, page not found !', 'ihosting' );
						echo '<meta name="description" content="' . sanitize_text_field( $not_found_text ) . '" />';
					}
					else {
						if ( is_search() ) {
							echo '<meta name="description" content="' . sprintf( esc_html__( 'Search results for: %s', 'ihosting' ), get_search_query() ) . '" />';
						}
						else {
							// is category, is tag, is tax
							echo '<meta name="description" content="' . single_cat_title( '', false ) . '" />';
						}
					}
				}

				// Is WooCommerce page
				if ( function_exists( 'is_woocommerce' ) ) {
					if ( is_woocommerce() && !is_shop() ) {
						if ( apply_filters( 'woocommerce_show_page_title', true ) ) {
							echo '<meta name="description" content="' . woocommerce_page_title( false ) . '" />';
						}
					}
				}

			}
		}

	}

	add_action( 'wp_head', 'ihosting_core_meta_tags' );
}

if ( !function_exists( 'ihosting_core_get_img_alt' ) ) {
	function ihosting_core_get_img_alt( $img_id = 0 ) {
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


/**
 *  Update products categories via ajax
 *
 * @since 1.0
 **/
function ihosting_update_procat_imgs_via_ajax() {

	$errors = array();
	$notes = array();
	$nonce = ( isset( $_POST['nonce'] ) ) ? $_POST['nonce'] : '';

	// Security check
	if ( !wp_verify_nonce( $nonce, 'ovic-fh-core-ajax-nonce' ) ):

		$errors[] = __( 'Security check error!', 'ihosting-core' );

	endif;

	if ( !current_user_can( 'manage_options' ) ):

		$errors[] = __( 'You do not have sufficient permissions to access this page!', 'ihosting-core' );

	endif;

	if ( empty( $errors ) ):

		$procat_id = isset( $_POST['procat_id'] ) ? intval( $_POST['procat_id'] ) : 0;
		$img_ids = isset( $_POST['img_ids'] ) ? sanitize_text_field( $_POST['img_ids'] ) : '';

		if ( $procat_id > 0 ):

			update_option( 'ihosting_procat_imgs_' . $procat_id, $img_ids );
			$notes[] = __( 'Product images updated', 'ihosting-core' );

		endif;

	endif;

	ihosting_display_note( $errors );
	ihosting_display_note( $notes, 'updated' );


	die();
}

add_action( 'wp_ajax_ihosting_update_procat_imgs_via_ajax', 'ihosting_update_procat_imgs_via_ajax' );


/**
 *  Load procat imgs via ajax
 *
 * @since 1.0
 **/
function ihosting_load_procat_imgs_via_ajax() {

	$response = array(
		'message' => '',
		'html'    => ''
	);
	$errors = array();
	$notes = array();
	$nonce = ( isset( $_POST['nonce'] ) ) ? $_POST['nonce'] : '';

	// Security check
	if ( !wp_verify_nonce( $nonce, 'ovic-fh-core-ajax-nonce' ) ):

		$errors[] = __( 'Security check error!', 'ihosting-core' );
		$response['html'] .= ihosting_display_note( $errors, 'error', false );

	endif;

	if ( !current_user_can( 'manage_options' ) ):

		$errors[] = __( 'You do not have sufficient permissions to access this page!', 'ihosting-core' );
		$response['html'] .= ihosting_display_note( $errors, 'error', false );

	endif;

	if ( empty( $errors ) ):

		$procat_id = isset( $_POST['procat_id'] ) ? intval( $_POST['procat_id'] ) : 0;
		$img_ids = get_option( 'ihosting_procat_imgs_' . $procat_id, '' );

		if ( $img_ids != '' ):

			$img_ids = explode( ',', $img_ids );

			foreach ( $img_ids as $img_id ):

				$thumb_img = wp_get_attachment_image( $img_id, 'thumbnail' );

				$response['html'] .= '<div data-img-id="' . $img_id . '" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 ovic-fh-thumbnail-preview ovic-fh-sortable-item">' . $thumb_img . '<i class="ovic-fh-delete fa fa-times-circle-o"></i></div>';

			endforeach;

		else:

			$notes[] = __( 'No image to display!', 'ihosting-core' );
			$response['html'] .= ihosting_display_note( $notes, 'updated', false );

		endif;

	endif;

	wp_send_json( $response );


	die();
}

add_action( 'wp_ajax_ihosting_load_procat_imgs_via_ajax', 'ihosting_load_procat_imgs_via_ajax' );


if ( !function_exists( 'ihosting_custom_taxonomy_opt_walker' ) ) :
	/**
	 *  Return terms array
	 *
	 * @since 1.0
	 **/
	function ihosting_custom_taxonomy_opt_walker( &$terms_select_opts = array(), $taxonomy, $parent = 0, $lv = 0 ) {

		$terms = get_terms( $taxonomy, array( 'parent' => $parent, 'hide_empty' => false ) );

		if ( $parent > 0 ):
			$lv++;
		endif;

		//If there are terms
		if ( count( $terms ) > 0 ):
			$prefix = '';
			if ( $lv > 0 ):
				for ( $i = 1; $i <= $lv; $i++ ):
					$prefix .= '-- ';
				endfor;
			endif;

			//Cycle though the terms
			foreach ( $terms as $term ):
				$terms_select_opts[$term->term_id] = htmlentities2( $prefix . $term->name );

				//Function calls itself to display child elements, if any
				ihosting_custom_taxonomy_opt_walker( $terms_select_opts, $taxonomy, $term->term_id, $lv );
			endforeach;

		endif;

	}
endif; // Endif !function_exists( 'ihosting_custom_taxonomy_opt_walker' )

if ( !function_exists( 'ihosting_procats_select' ) ):
	function ihosting_procats_select( $selected_procat_ids = array(), $settings = array() ) {

		if ( !class_exists( 'WooCommerce' ) ):
			return false;
		endif;

		$term_args = array();
		$default_settings = array(
			'multiple'          => false,
			'id'                => '',
			'name'              => '',
			'class'             => '',
			'first_option'      => false,
			'first_select_val'  => '',
			'first_select_text' => __( ' --------------- ', 'ihosting-core' )
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$attrs = '';
		$attrs .= ( trim( $settings['id'] ) != '' ) ? 'id="' . esc_attr( $settings['id'] ) . '"' : '';
		$attrs .= ( trim( $settings['name'] ) != '' ) ? ' name="' . esc_attr( $settings['name'] ) . '"' : '';
		$attrs .= ( $settings['multiple'] === true ) ? ' multiple="true"' : '';

		ihosting_custom_taxonomy_opt_walker( $term_args, 'product_cat' );

		$html = '';
		if ( !empty( $term_args ) ):

			$html .= '<select ' . $attrs . ' class="ihosting-select ' . $settings['class'] . '">';

			if ( $settings['first_option'] ):
				$html .= '<option ' . selected( in_array( 0, $selected_procat_ids ), true, false ) . ' value="' . esc_attr( $settings['first_select_val'] ) . '">' . sanitize_text_field( $settings['first_select_text'] ) . '</option>';
			endif;

			foreach ( $term_args as $term_id => $term_name ):

				$html .= '<option ' . selected( in_array( $term_id, $selected_procat_ids ), true, false ) . ' value="' . $term_id . '">' . $term_name . '</option>';

			endforeach;
			$html .= '</select>';

		endif;

		$html .= ob_get_clean();

		return $html;

	}
endif; // Endif if ( !function_exists( 'ihosting_procats_select' ) )

if ( !function_exists( 'ihosting_procats_slug_select' ) ):

	/**
	 *  Option values are slugs
	 **/
	function ihosting_procats_slug_select( $selected_procat_slugs = array(), $settings = array() ) {

		if ( !class_exists( 'WooCommerce' ) ):
			return false;
		endif;

		$term_args = array();
		$default_settings = array(
			'multiple'          => false,
			'id'                => '',
			'name'              => '',
			'class'             => '',
			'first_option'      => false,
			'first_select_val'  => '',
			'first_select_text' => __( ' --------------- ', 'ihosting-core' )
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$attrs = '';
		$attrs .= ( trim( $settings['id'] ) != '' ) ? 'id="' . esc_attr( $settings['id'] ) . '"' : '';
		$attrs .= ( trim( $settings['name'] ) != '' ) ? ' name="' . esc_attr( $settings['name'] ) . '"' : '';
		$attrs .= ( $settings['multiple'] === true ) ? ' multiple="true"' : '';

		ihosting_custom_taxonomy_opt_walker( $term_args, 'product_cat' );

		$html = '';
		if ( !empty( $term_args ) ):

			$html .= '<select ' . $attrs . ' class="ihosting-select ' . $settings['class'] . '">';

			if ( $settings['first_option'] ):
				$html .= '<option ' . selected( in_array( 0, $selected_procat_slugs ), true, false ) . ' value="' . esc_attr( $settings['first_select_val'] ) . '">' . sanitize_text_field( $settings['first_select_text'] ) . '</option>';
			endif;

			foreach ( $term_args as $term_id => $term_name ):

				$term = get_term( $term_id, 'product_cat' );
				if ( !is_wp_error( $term ) ) {
					$html .= '<option ' . selected( in_array( $term->slug, $selected_procat_slugs ), true, false ) . ' value="' . esc_attr( $term->slug ) . '">' . sanitize_text_field( $term_name ) . '</option>';
				}

			endforeach;
			$html .= '</select>';

		endif;

		$html .= ob_get_clean();

		return $html;

	}
endif; // Endif if ( !function_exists( 'ihosting_procats_select' ) )

if ( !function_exists( 'ihosting_custom_tax_slug_select' ) ):
	function ihosting_custom_tax_slug_select( $selected_tax_slugs = array(), $settings = array() ) {

		$term_args = array();
		$default_settings = array(
			'tax'               => 'category',
			'multiple'          => false,
			'id'                => '',
			'name'              => '',
			'class'             => '',
			'first_option'      => false,
			'first_option_val'  => '',
			'first_option_text' => __( ' --------------- ', 'ihosting-core' )
		);

		$settings = wp_parse_args( $settings, $default_settings );

		if ( !taxonomy_exists( $settings['tax'] ) ):

			return false;

		endif;

		$attrs = '';
		$attrs .= ( trim( $settings['id'] ) != '' ) ? 'id="' . esc_attr( $settings['id'] ) . '"' : '';
		$attrs .= ( trim( $settings['name'] ) != '' ) ? ' name="' . esc_attr( $settings['name'] ) . '"' : '';
		$attrs .= ( $settings['multiple'] === true ) ? ' multiple="true"' : '';

		ihosting_custom_taxonomy_opt_walker( $term_args, $settings['tax'] );

		$html = '';
		if ( !empty( $term_args ) ):

			$html .= '<select ' . $attrs . ' class="ihosting-select ' . esc_attr( $settings['class'] ) . '">';

			if ( $settings['first_option'] ):
				$html .= '<option ' . selected( in_array( 0, $selected_tax_slugs ), true, false ) . ' value="' . esc_attr( $settings['first_option_val'] ) . '">' . sanitize_text_field( $settings['first_option_text'] ) . '</option>';
			endif;

			foreach ( $term_args as $term_id => $term_name ):

				$term = get_term( $term_id, $settings['tax'] );
				if ( !is_wp_error( $term ) ) {
					$html .= '<option ' . selected( in_array( $term->slug, $selected_tax_slugs ), true, false ) . ' value="' . esc_attr( $term->slug ) . '">' . $term_name . '</option>';
				}

			endforeach;
			$html .= '</select>';

		endif;

		return $html;

	}
endif; // Endif if ( !function_exists( 'ihosting_custom_tax_slug_select' ) )


if ( !function_exists( 'ihosting_custom_tax_select' ) ):
	function ihosting_custom_tax_select( $selected_procat_ids = array(), $settings = array() ) {

		$term_args = array();
		$default_settings = array(
			'tax'               => 'category',
			'multiple'          => false,
			'id'                => '',
			'name'              => '',
			'class'             => '',
			'first_option'      => false,
			'first_option_val'  => '',
			'first_option_text' => __( ' --------------- ', 'ihosting-core' )
		);

		$settings = wp_parse_args( $settings, $default_settings );

		if ( !taxonomy_exists( $settings['tax'] ) ):

			return false;

		endif;

		$attrs = '';
		$attrs .= ( trim( $settings['id'] ) != '' ) ? 'id="' . esc_attr( $settings['id'] ) . '"' : '';
		$attrs .= ( trim( $settings['name'] ) != '' ) ? ' name="' . esc_attr( $settings['name'] ) . '"' : '';
		$attrs .= ( $settings['multiple'] === true ) ? ' multiple="true"' : '';

		ihosting_custom_taxonomy_opt_walker( $term_args, $settings['tax'] );

		$html = '';
		if ( !empty( $term_args ) ):

			$html .= '<select ' . $attrs . ' class="ihosting-select ' . esc_attr( $settings['class'] ) . '">';

			if ( $settings['first_option'] ):
				$html .= '<option ' . selected( in_array( 0, $selected_procat_ids ), true, false ) . ' value="' . esc_attr( $settings['first_option_val'] ) . '">' . sanitize_text_field( $settings['first_option_text'] ) . '</option>';
			endif;

			foreach ( $term_args as $term_id => $term_name ):

				$html .= '<option ' . selected( in_array( $term_id, $selected_procat_ids ), true, false ) . ' value="' . $term_id . '">' . $term_name . '</option>';

			endforeach;
			$html .= '</select>';

		endif;

		return $html;

	}
endif; // Endif if ( !function_exists( 'ihosting_custom_tax_select' ) )


if ( !function_exists( 'ihosting_order_by_rating_post_clauses' ) ) {

	/**
	 * ihosting_order_by_rating_post_clauses function.
	 *
	 * @param array $args
	 *
	 * @return array
	 * @since 1.0
	 */
	function ihosting_order_by_rating_post_clauses( $args ) {
		global $wpdb;

		$args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";

		$args['where'] .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";

		$args['join'] .= "
    		LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
    		LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
    	";

		$args['orderby'] = "average_rating DESC, $wpdb->posts.post_date DESC";

		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}
}


if ( !function_exists( 'ihosting_order_by_popularity_post_clauses' ) ) {
	function ihosting_order_by_popularity_post_clauses( $args ) {
		global $wpdb;

		$args['orderby'] = "$wpdb->postmeta.meta_value+0 DESC, $wpdb->posts.post_date DESC";

		return $args;
	}
}


if ( !function_exists( 'ihosting_get_the_excerpt' ) ) {

	function ihosting_get_the_excerpt( $content = '', $length = 55, $more = '...' ) {

		$content = wp_strip_all_tags( strip_shortcodes( $content ), true );
		$length = max( 1, intval( $length ) );
		$excerpt = substr( $content, 0, $length );

		if ( strlen( $excerpt ) < strlen( $content ) ):
			$excerpt = $excerpt . $more;
		endif;

		return $excerpt;

	}

}

if ( !function_exists( 'ihosting_get_img_src_by_id' ) ) {

	/**
	 *  Return img src
	 **/
	function ihosting_get_img_src_by_id( $img_id = 0, $size = 'full' ) {

		$img_id = max( 0, intval( $img_id ) );
		$src = '';

		if ( $img_id > 0 ):

			$thumb = wp_get_attachment_image_src( $img_id, $size );
			$src = $thumb['0'];

		endif;

		return $src;

	}

}

if ( !function_exists( 'ihosting_get_the_excerpt_max_charlength' ) ) {
	function ihosting_get_the_excerpt_max_charlength( $charlength ) {
		if ( post_password_required() ) {
			return '';
		}

		$excerpt = get_the_excerpt();

		$charlength++;

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

if ( !function_exists( 'ts_custom_excerpt_length' ) ) {
	function ts_custom_excerpt_length( $length ) {
		//global $ihosting;
		//$the_excerpt_max_chars = isset( $ihosting['opt-excerpt-max-char-length'] ) ? max( 1, intval( $ihosting['opt-excerpt-max-char-length'] ) ) : 300;
		//return $the_excerpt_max_chars;
		return 1000;
	}

	add_filter( 'excerpt_length', 'ts_custom_excerpt_length', 999 );
}


add_action( 'after_setup_theme', 'ts_init_vc_global', 1 );

function ts_init_vc_global() {
	// Check if Visual Composer is installed
	if ( !defined( 'WPB_VC_VERSION' ) ) {
		return;
	}

	if ( version_compare( WPB_VC_VERSION, '4.2', '<' ) ) {

		add_action( 'init', 'ts_add_vc_global_params', 100 );

		vc_add_shortcode_param( 'ihosting_icon_picker', 'ihosting_icon_picker' ); // iHosting

		vc_add_shortcode_param( 'ihosting_icon_box_preview', 'ihosting_icon_box_preview' );
		vc_add_shortcode_param( 'ihosting_animated_column_preview', 'ihosting_animated_column_preview' );
		vc_add_shortcode_param( 'ihosting_select_tes_cat_field', 'ihosting_select_tes_cat_field' );
		vc_add_shortcode_param( 'ihosting_select_client_cat_field', 'ihosting_select_client_cat_field' );
		vc_add_shortcode_param( 'ihosting_select_animated_column_cat_field', 'ihosting_select_animated_column_cat_field' );
		vc_add_shortcode_param( 'ihosting_select_member_cat_field', 'ihosting_select_member_cat_field' );
		vc_add_shortcode_param( 'ihosting_quick_edit_animated_columns_field', 'ihosting_quick_edit_animated_columns_field' );

	}
	else {

		add_action( 'vc_after_mapping', 'ts_add_vc_global_params' );

		vc_add_shortcode_param( 'ihosting_icon_picker', 'ihosting_icon_picker' ); // iHosting

		vc_add_shortcode_param( 'ihosting_icon_box_preview', 'ihosting_icon_box_preview' );
		vc_add_shortcode_param( 'ihosting_animated_column_preview', 'ihosting_animated_column_preview' );
		vc_add_shortcode_param( 'ihosting_select_tes_cat_field', 'ihosting_select_tes_cat_field' );
		vc_add_shortcode_param( 'ihosting_select_client_cat_field', 'ihosting_select_client_cat_field' );
		vc_add_shortcode_param( 'ihosting_select_animated_column_cat_field', 'ihosting_select_animated_column_cat_field' );
		vc_add_shortcode_param( 'ihosting_select_member_cat_field', 'ihosting_select_member_cat_field' );
		vc_add_shortcode_param( 'ihosting_quick_edit_animated_columns_field', 'ihosting_quick_edit_animated_columns_field' );

	}
}

function ts_add_vc_global_params() {

	// Check if Visual Composer is installed
	if ( !defined( 'WPB_VC_VERSION' ) ) {
		return;
	}

	// Visual composer support equal columns since v4.9, so we do not need add custom vc_row with VC version from 4.9 or newer
	if ( version_compare( WPB_VC_VERSION, '4.9', '<' ) ) {
		//vc_set_shortcodes_templates_dir( IHOSTINGCORE_DIR_PATH . '/core/shortcodes/vc_templates/');

		//        global $vc_setting_row, $vc_setting_row_inner;
		//        vc_add_params( 'vc_row', $vc_setting_row );
		//        vc_add_params( 'vc_row_inner', $vc_setting_row_inner );
	}

	//vc_add_params( 'vc_icon', $vc_setting_icon_shortcode );
	//    vc_add_params( 'vc_column', $vc_setting_col );
	//    vc_add_params( 'vc_column_inner', $vc_setting_column_inner );

	vc_add_shortcode_param( 'ihosting_select_adv_cat', 'ihosting_param_select_adv_cat_field' );
	vc_add_shortcode_param( 'ihosting_param_num_field', 'ihosting_param_num_field' );
	vc_add_shortcode_param( 'ihosting_select_product_cat_field', 'ihosting_select_product_cat_field' );
	vc_add_shortcode_param( 'ihosting_select_product_cat_field_2', 'ihosting_select_product_cat_field_2' ); // Not show "All Categories" text
	vc_add_shortcode_param( 'ihosting_select_cat_field', 'ihosting_select_cat_field' );
	vc_add_shortcode_param( 'ihosting_select_portfolio_cat_field', 'ihosting_select_portfolio_cat_field' );

}


//------------------------------//
// iHosting shortcode params      //
//------------------------------//

function ihosting_icon_box_preview( $settings, $value ) {

	if ( file_exists( IHOSTINGCORE_DIR_PATH . '/assets/images/icon-boxes-preview/' . esc_attr( $value ) . '.jpg' ) ) {
		return '<div class="icon-box-preview" style="padding: 15px; border: 1px solid #ccc; background-color: #efefef;">
                    <img style="max-width: 100%;" src="' . IHOSTINGCORE_BASE_URL . '/assets/images/icon-boxes-preview/' . esc_attr( $value ) . '.jpg" alt="' . esc_attr( 'Icon Preview', 'ihosting-core' ) . '" />
                    <input type="hidden" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value" value="' . esc_attr( $value ) . '" />
                </div>';
	}

	return '';

}

function ihosting_icon_picker( $settings, $value ) {

	$icon_paths = '';
	for ( $i = 1; $i <= 25; $i++ ) {
		$icon_paths .= '<span class="path' . $i . '"></span>';
	}
	$icon = '<span class="ts-selected-icon"><i class="' . esc_attr( $value ) . '">' . $icon_paths . '</i></span>
            <span class="ts-selector-button"><i class="fip-fa fa fa-arrow-down"></i></span>';

	$icon_html = '<div class="ts-icon-preview">' . $icon . '</div>
                <input type="hidden" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value ts-icon-class-value" value="' . esc_attr( $value ) . '" />';

	$html = '<div class="ts-icon-picker-wrap">
                ' . $icon_html . '
                ' . ihosting_core_font_icons_chooser( '', 1, 96, false, false ) . '
            </div><!-- /.ts-icon-picker-wrap -->';

	//ihosting_core_font_icons_chooser

	return $html;

}

function ihosting_animated_column_preview( $settings, $value ) {

	if ( file_exists( IHOSTINGCORE_DIR_PATH . '/assets/images/animated-column-preview/' . esc_attr( $value ) . '.jpg' ) ) {
		$preview_img_src = IHOSTINGCORE_BASE_URL . '/assets/images/animated-column-preview/' . esc_attr( $value ) . '.jpg';
		$preview_img_hover_src = IHOSTINGCORE_BASE_URL . '/assets/images/animated-column-preview/' . esc_attr( $value ) . '-hover.jpg';

		return '<div class="ihosting-preview-shortcode" style="padding: 15px; border: 1px solid #ccc; background-color: #efefef;">
                    <img class="preview-img" style="max-width: 100%;" src="' . esc_url( $preview_img_src ) . '" alt="' . esc_attr( 'Preview Image', 'ihosting-core' ) . '" />
                    <img class="preview-img-hover" style="max-width: 100%;" src="' . esc_url( $preview_img_hover_src ) . '" alt="' . esc_attr( 'Preview Image Hover', 'ihosting-core' ) . '" />
                    <p class="normal-preview-desc">' . __( 'Normal preview', 'ihosting-core' ) . '</p>
                    <p class="hover-preview-desc">' . __( 'Hover preview', 'ihosting-core' ) . '</p>
                    <input type="hidden" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value" value="' . esc_attr( $value ) . '" />
                </div>';
	}

	return '';

}

function ihosting_select_tes_cat_field( $settings, $value ) {

	return '<div class="select_cat_block">'
	       . ihosting_custom_tax_select(
		       array( $value ),
		       array(
			       'tax'               => 'testimonial_cat',
			       'class'             => 'wpb_vc_param_value',
			       'name'              => $settings['param_name'],
			       'first_option'      => true,
			       'first_option_val'  => '0',
			       'first_option_text' => __( ' --- All Categories --- ', 'ihosting-core' )
		       )
	       )
	       . '</div>';
}

function ihosting_select_client_cat_field( $settings, $value ) {

	return '<div class="select_cat_block">'
	       . ihosting_custom_tax_select(
		       array( $value ),
		       array(
			       'tax'               => 'client_cat',
			       'class'             => 'wpb_vc_param_value',
			       'name'              => $settings['param_name'],
			       'first_option'      => true,
			       'first_option_val'  => '0',
			       'first_option_text' => __( ' --- All Categories --- ', 'ihosting-core' )
		       )
	       )
	       . '</div>';
}

function ihosting_select_animated_column_cat_field( $settings, $value ) {

	return '<div class="select_cat_block">'
	       . ihosting_custom_tax_select(
		       array( $value ),
		       array(
			       'tax'               => 'animated_column_cat',
			       'class'             => 'wpb_vc_param_value ts_anim_cat_select',
			       'name'              => $settings['param_name'],
			       'first_option'      => true,
			       'first_option_val'  => '0',
			       'first_option_text' => __( ' --- All Categories --- ', 'ihosting-core' )
		       )
	       )
	       . '</div>';
}

function ihosting_select_member_cat_field( $settings, $value ) {

	return '<div class="select_cat_block">'
	       . ihosting_custom_tax_select(
		       array( $value ),
		       array(
			       'tax'               => 'member_cat',
			       'class'             => 'wpb_vc_param_value',
			       'name'              => $settings['param_name'],
			       'first_option'      => true,
			       'first_option_val'  => '0',
			       'first_option_text' => __( ' --- All Categories --- ', 'ihosting-core' )
		       )
	       )
	       . '</div>';
}


/**
 *  List "animated_column" posts field in the shortcode edit form with VC
 *  Allow quick edit: Excerpt, icon class, read more link, use read more link or permalink, title, thumbnail...
 *
 * @param $value       string  JSON format, content category id and maximum number of animated columns load (limit)
 * @param $settings    array
 *
 * @since 1.0
 **/
function ihosting_quick_edit_animated_columns_field( $settings, $value ) {

	/**
	 *  data-edit-for="ihosting_icon_class" --> meta key is "ihosting_icon_class"
	 **/

	$value_default = array(
		'cat_id' => 0,
		'limit'  => 8
	);

	$value_bak = $value;
	if ( trim( $value ) == '' ) {
		$value = $value_default;
	}
	else {
		$value = json_decode( $value );
		$value = wp_parse_args( $value, $value_default );
	}

	$args = array(
		'post_type'   => 'animated_column',
		'post_status' => 'publish',
		'showposts'   => intval( $value['limit'] )
	);

	$animated_column_cat_id = intval( $value['cat_id'] );
	if ( $animated_column_cat_id > 0 ):

		$args['tax_query'] = array(
			array(
				'taxonomy' => 'animated_column_cat',
				'field'    => 'id',
				'terms'    => $animated_column_cat_id
			)
		);

	endif;

	$query = new WP_Query( $args );

	$html = '';

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ): $query->the_post();

			$icon_class = get_post_meta( get_the_ID(), 'ihosting_icon_class', true );
			$bg_color = get_post_meta( get_the_ID(), 'ihosting_animate_bg_color', true );
			$bg_color = trim( $bg_color ) == '' ? '#dcc6b9' : $bg_color;
			$use_permalink = get_post_meta( get_the_ID(), 'ihosting_use_permalink', true ) == 'on';
			$custom_link = $use_permalink ? '' : get_post_meta( get_the_ID(), 'ihosting_animate_link', true );
			$use_permalink_select_id = uniqid( 'use-permalink-' );

			$html .= '<h3 class="quick-edit-title quick-edit-title-' . get_the_ID() . '">
                        <span class="accordion-header-title">' . sanitize_text_field( get_the_title() ) . '</span>
                        <i class="ihosting-icon-acc-header-preview ' . esc_attr( $icon_class ) . '""></i>
                    </h3>';
			$html .= '<div data-post-id="' . get_the_ID() . '" class="ts-quick-edit-post-vc-content">';

			$html .= '<div class="ts-quick-edit-field-group vc_column">
                        <div class="wpb_element_label">' . __( 'Title', 'ihosting-core' ) . '</div>
                        <div class="edit_form_line">
                            <input class="wpb-textinput ts-title-edit ts-quick-edit-field textfield" type="text" value="' . sanitize_text_field( get_the_title() ) . '">
                        </div><!-- /.edit_form_line -->
                     </div><!-- /.ts-quick-edit-field-group -->';

			$html .= '<div class="ts-quick-edit-field-group vc_column">
                        <div class="wpb_element_label">' . __( 'Icon', 'ihosting-core' ) . '</div>
                        <div class="edit_form_line">
                            <input data-edit-for="ihosting_icon_class" class="wpb-textinput ts-meta-edit ts-quick-edit-field ts-icon-class-input textfield" type="text" value="' . esc_attr( $icon_class ) . '">
                            <span class="vc_description vc_clearfix"><i class="ihosting-icon-preview ' . esc_attr( $icon_class ) . '"></i>' . __( 'Enter or choose class from the list below', 'ihosting-core' ) . '</span>
                            <a href="#" class="toggle-iconpicker">' . __( 'Icon picker', 'ihosting-core' ) . '</a>
                            <div class="iconpicker-wrap">
                                ' . ihostingcorefont_icons_chooser( '', 1, 96, false, false ) . '
                            </div><!-- /.iconpicker-wrap -->
                        </div><!-- /.edit_form_line -->
                     </div><!-- /.ts-quick-edit-field-group -->';

			$html .= '<div class="ts-quick-edit-field-group vc_column">
                        <div class="wpb_element_label">' . __( 'Use Permalink As Read More Link', 'ihosting-core' ) . '</div>
                        <div class="edit_form_line">
                            <select data-edit-for="ihosting_use_permalink" id="' . esc_attr( $use_permalink_select_id ) . '" class="ts-meta-edit ts-quick-edit-field ts-select">
                                <option value="">' . __( 'No', 'ihosting-core' ) . '</option>
                                <option ' . selected( $use_permalink, true, false ) . ' value="on">' . __( 'Yes', 'ihosting-core' ) . '</option>
                            </select>
                            <span class="vc_description vc_clearfix"></span>
                        </div><!-- /.edit_form_line -->
                     </div><!-- /.ts-quick-edit-field-group -->';

			$html .= '<div data-dep-on="#' . esc_attr( $use_permalink_select_id ) . '" data-dep-val="" data-dep-compare="=" class="ts-quick-edit-field-group ts-dependency vc_column">
                        <div class="wpb_element_label">' . __( 'Read More Link', 'ihosting-core' ) . '</div>
                        <div class="edit_form_line">
                            <input data-edit-for="ihosting_animate_link" class="wpb-textinput ts-meta-edit ts-quick-edit-field ts-animate-link-input textfield" type="text" value="' . esc_url( $custom_link ) . '">
                            <span class="vc_description vc_clearfix"></span>
                        </div><!-- /.edit_form_line -->
                     </div><!-- /.ts-quick-edit-field-group -->';

			$html .= '<div data-dep-on="#vc_edit-form-tabs select[name=\'style\']" data-dep-val="colorful-animate" data-dep-compare="=" class="ts-quick-edit-field-group ts-dependency vc_column">
                        <div class="wpb_element_label">' . __( 'Background Color', 'ihosting-core' ) . '</div>
                        <div class="edit_form_line">
                            <input data-edit-for="ihosting_animate_bg_color" class="wpb-textinput ts-meta-edit ts-quick-edit-field ts-animate-bg-color-input ts-color-input ts-color-picker textfield" type="text" value="' . esc_url( $bg_color ) . '">
                            <span class="vc_description vc_clearfix">' . __( 'This configuration only apply for "Style 2"', 'ihosting-core' ) . '</span>
                        </div><!-- /.edit_form_line -->
                     </div><!-- /.ts-quick-edit-field-group -->';

			$html .= '</div><!-- /.ts-quick-edit-post-vc-content -->';

		endwhile;
	}

	$html = '<div class="ts-quick-edit-posts-for-vc-wrap">' . $html . '</div><!-- /.ts-quick-edit-posts-for-vc-wrap -->';

	$html .= '<input data-val-json="' . esc_attr( json_encode( $value ) ) . '" type="hidden" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value" value="' . htmlentities2( $value_bak ) . '" />';

	wp_reset_postdata();

	return $html;

}


function ihosting_team_member_list(
	$query_args, $cur_page = 1, $show_pagination = true, $members_per_row = 4, $max_chars = 100
) {

	$html = '';
	$items_html = '';
	$pagination_html = '';
	$pre_page_html = '';
	$next_page_html = '';

	$total_query_args = array(
		'post_type'   => 'member',
		'showposts'   => -1,
		'post_status' => array( 'publish' )
	);

	if ( isset( $query_args['tax_query'] ) ) {
		$total_query_args['tax_query'] = $query_args['tax_query'];
	}

	$post_per_page = isset( $query_args['showposts'] ) ? max( 1, intval( $query_args['showposts'] ) ) : 8;
	$members_per_row = max( 1, intval( $members_per_row ) );

	$total_query_posts = new WP_Query( $total_query_args );
	$total_mems = $total_query_posts->found_posts;
	$total_pages = ceil( $total_mems / $post_per_page );
	$cur_page = max( 1, min( intval( $cur_page ), $total_pages ) );

	if ( $total_pages > 1 && $show_pagination ) {

		if ( $cur_page > 1 ) {
			$pre_page_html .= '<li class="ts-members-pagi-li"><a class="ts-go-to-page" data-go-to-page="' . intval( $cur_page - 1 ) . '" href="#"><i class="fa fa-angle-left"></i></a></li>';
		}

		if ( $cur_page < $total_pages ) {
			$next_page_html .= '<li class="ts-members-pagi-li"><a class="ts-go-to-page" data-go-to-page="' . intval( $cur_page + 1 ) . '" href="#"><i class="fa fa-angle-right"></i></a></li>';
		}

		$pagination_html .= '<div class="pagination ts-members-pagination">';
		$pagination_html .= '<ul>';
		$pagination_html .= $pre_page_html;

		for ( $i = 1; $i <= $total_pages; $i++ ):

			$li_class = 'ts-members-pagi-li';
			$li_class .= ( $i == $cur_page ) ? ' page-active' : '';

			$pagination_html .= '<li class="' . esc_attr( $li_class ) . '"><a class="ts-go-to-page" data-go-to-page="' . intval( $i ) . '" href="#">' . intval( $i ) . '</a></li>';

		endfor;

		$pagination_html .= $next_page_html;
		$pagination_html .= '</ul>';
		$pagination_html .= '</div><!-- /.ts-members-pagination -->';
	}

	wp_reset_postdata();

	$query_posts = new WP_Query( $query_args );
	if ( $query_posts->have_posts() ):

		$col_class = '';
		if ( $members_per_row <= 2 ) {
			$col_class = 'col-xs-12 col-sm-6';
		}

		if ( $members_per_row == 3 ) {
			$col_class = 'col-xs-12 col-sm-4';
		}

		if ( $members_per_row == 4 ) {
			$col_class = 'col-xs-12 col-sm-6 col-md-3';
		}

		while ( $query_posts->have_posts() ) : $query_posts->the_post();

			$post_id = get_the_ID();
			$excerpt = ihosting_get_the_excerpt_max_charlength( $max_chars );

			$thumb_src = '';
			if ( has_post_thumbnail() ) {
				$thumb_src = ihosting_get_img_src_by_id( get_post_thumbnail_id(), '536x588' );
			}
			else {
				$thumb_src = ihosting_core_no_image( array( 'width' => 536, 'height' => 588 ), false, false );
			}

			$mem_position = get_post_meta( $post_id, 'ihosting_member_position', true );

			$member_links_html = '';

			$fb_link = get_post_meta( $post_id, 'ihosting_fb_link', true );
			$tw_link = get_post_meta( $post_id, 'ihosting_tw_link', true );
			$gplus_link = get_post_meta( $post_id, 'ihosting_gplus_link', true );
			$in_link = get_post_meta( $post_id, 'ihosting_in_link', true );
			$yt_link = get_post_meta( $post_id, 'ihosting_yt_link', true );
			$vimeo_link = get_post_meta( $post_id, 'ihosting_vimeo_link', true );
			$pinterest_link = get_post_meta( $post_id, 'ihosting_pinterest_link', true );

			if ( trim( $fb_link ) != '' ) {
				$member_links_html .= '<a target="_blank" href="' . esc_attr( $fb_link ) . '"><i class="fa fa-facebook"></i></a>';
			}
			if ( trim( $tw_link ) != '' ) {
				$member_links_html .= '<a target="_blank" href="' . esc_attr( $tw_link ) . '"><i class="fa fa-twitter"></i></a>';
			}
			if ( trim( $gplus_link ) != '' ) {
				$member_links_html .= '<a target="_blank" href="' . esc_attr( $gplus_link ) . '"><i class="fa fa-google-plus"></i></a>';
			}
			if ( trim( $in_link ) != '' ) {
				$member_links_html .= '<a target="_blank" href="' . esc_attr( $in_link ) . '"><i class="fa fa-linkedin"></i></a>';
			}
			if ( trim( $yt_link ) != '' ) {
				$member_links_html .= '<a target="_blank" href="' . esc_attr( $yt_link ) . '"><i class="fa fa-youtube"></i></a>';
			}
			if ( trim( $vimeo_link ) != '' ) {
				$member_links_html .= '<a target="_blank" href="' . esc_attr( $vimeo_link ) . '"><i class="fa fa-vimeo-square"></i></a>';
			}
			if ( trim( $pinterest_link ) != '' ) {
				$member_links_html .= '<a target="_blank" href="' . esc_attr( $pinterest_link ) . '"><i class="fa fa-pinterest"></i></a>';
			}

			$items_html .= '<div class="team-item ' . $col_class . '">
            					<div class="team-item-inner">
                                    <div class="team-thumb">
                						<img src="' . esc_url( $thumb_src ) . '" alt="' . esc_attr( get_the_title() ) . '">
                                        <div class="ts-team-overlay">
                                            <p>' . sanitize_text_field( $excerpt ) . '</p>
                                            <div class="team-icons">
                                                ' . $member_links_html . '
                                            </div>
                                        </div><!-- /.ts-team-overlay -->
                					</div><!-- /.team-thumb -->
                					<div class="info-team">
                						<h5>' . get_the_title() . '</h5>
                						<div class="team-company">' . sanitize_text_field( $mem_position ) . '</div>
                					</div><!-- /.info-team -->
                                </div><!-- /.team-item-inner -->
            				</div><!-- /.team-item -->';

		endwhile;

		$html .= '<div class="ts-team">
                        <div class="row">
                            ' . $items_html . '
                        </div><!-- /.row -->
                        ' . $pagination_html . '
                    </div><!-- /.ts-team -->';

	endif;

	wp_reset_postdata();

	return $html;

}

if ( !function_exists( 'ihosting_core_products_search_suggestion_via_ajax' ) ) {
	function ihosting_core_products_search_suggestion_via_ajax() {
		$response = array(
			'html' => ''
		);

		if ( !class_exists( 'WooCommerce' ) ) {
			wp_send_json( $response );
		}

		$search_key = isset( $_POST['search_key'] ) ? $_POST['search_key'] : '';
		$product_cat_slug = isset( $_POST['product_cat_slug'] ) ? $_POST['product_cat_slug'] : '';

		if ( trim( $search_key ) != '' ) {
			$args = array(
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'showposts'           => 6,
				's'                   => $search_key
			);

			$product_cat_slug = trim( $product_cat_slug );
			if ( $product_cat_slug != '' ):

				$args['tax_query'] = array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $product_cat_slug
					)
				);

			endif;

			$html = '';

			$products = new WP_Query( $args );

			if ( $products->have_posts() ) {
				$html .= '<ul class="products-suggestion-list">';
				while ( $products->have_posts() ) {
					$products->the_post();
					$img = ihosting_core_resize_image( get_post_thumbnail_id( get_the_ID() ), null, 30, 30, true, true, false );
					$product = new WC_Product( get_the_ID() );
					$html .= '<li>
								<a href="' . get_permalink() . '">
								<img width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( get_the_title() ) . '" />
								<span>' . get_the_title() . '</span>
								</a>
							</li>';
				}
				$html .= '</ul>';

				$response['html'] .= $html;
			}

			wp_reset_postdata();

		}

		wp_send_json( $response );
		die();
	}

	add_action( 'wp_ajax_ihosting_core_products_search_suggestion_via_ajax', 'ihosting_core_products_search_suggestion_via_ajax' );
	add_action( 'wp_ajax_nopriv_ihosting_core_products_search_suggestion_via_ajax', 'ihosting_core_products_search_suggestion_via_ajax' );
}

function ts_load_team_members_via_ajax() {

	$member_cat_id = isset( $_POST['mem_cat_id'] ) ? max( 0, intval( $_POST['mem_cat_id'] ) ) : 0;
	$post_per_page = isset( $_POST['post_per_page'] ) ? max( 1, intval( $_POST['post_per_page'] ) ) : 8; // limit
	$mem_per_row = isset( $_POST['mem_per_row'] ) ? max( 1, intval( $_POST['mem_per_row'] ) ) : 4;
	$max_chars = isset( $_POST['max_chars'] ) ? max( 1, intval( $_POST['max_chars'] ) ) : 100;
	$go_to_page = isset( $_POST['go_to_page'] ) ? max( 1, intval( $_POST['go_to_page'] ) ) : 1;

	$query_args = array(
		'post_type'   => 'member',
		'showposts'   => $post_per_page,
		'post_status' => array( 'publish' ),
		'paged'       => $go_to_page
	);

	if ( $member_cat_id > 0 ):

		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'member_cat',
				'field'    => 'ids',
				'terms'    => $member_cat_id
			)
		);

	endif;

	$response = array(
		'html' => ''
	);

	$response['html'] = ihosting_team_member_list( $query_args, $go_to_page, true, $mem_per_row, $max_chars );

	wp_send_json( $response );

	die();
}

add_action( 'wp_ajax_ts_load_team_members_via_ajax', 'ts_load_team_members_via_ajax' );
add_action( 'wp_ajax_nopriv_ts_load_team_members_via_ajax', 'ts_load_team_members_via_ajax' );


/**
 * Convert color hex to rgba format
 **/
if ( !function_exists( 'ts_color_hex2rgba' ) ) {
	function ts_color_hex2rgba( $hex, $alpha = 1 ) {
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

if ( !function_exists( 'ts_color_rgb2hex' ) ) {
	function ts_color_rgb2hex( $rgb ) {
		$hex = '#';
		$hex .= str_pad( dechex( $rgb[0] ), 2, '0', STR_PAD_LEFT );
		$hex .= str_pad( dechex( $rgb[1] ), 2, '0', STR_PAD_LEFT );
		$hex .= str_pad( dechex( $rgb[2] ), 2, '0', STR_PAD_LEFT );

		return $hex; // returns the hex value including the number sign (#)
	}
}

if ( !function_exists( 'ts_rev_sliders_args' ) ) {
	/**
	 *  Return args of Revolution sliders
	 *
	 * @since 1.0
	 **/
	function ts_rev_sliders_args() {
		global $wpdb;

		$args = array();

		if ( shortcode_exists( 'rev_slider' ) ) {

			$sql = "SELECT rs.title, rs.alias " .
			       "FROM {$wpdb->prefix}revslider_sliders rs " .
			       "ORDER BY rs.title ASC ";

			$rows = $wpdb->get_results( $sql );

			if ( count( $rows ) > 0 ) {

				foreach ( $rows as $row ):

					$args[esc_attr( $row->alias )] = sanitize_text_field( $row->title );

				endforeach;

			}

		}

		return $args;

	}
}


// New VC field types ================
// https://wpbakery.atlassian.net/wiki/display/VC/Create+New+Param+Type
function ihosting_param_select_adv_cat_field( $settings, $value ) {

	$terms = get_terms( 'adv_cat', array( 'hide_empty' => false ) );
	$select_html = '<select name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value" >';
	$select_html .= '<option value="0">' . __( 'All Adv Categories', 'ihosting-core' ) . '</option>';

	if ( !empty( $terms ) && !is_wp_error( $terms ) ):

		foreach ( $terms as $term ):

			$select_html .= '<option ' . selected( esc_attr( $value ) == esc_attr( $term->term_id ), true, false ) . ' value="' . esc_attr( $term->term_id ) . '">' . $term->name . '</option>';

		endforeach;

	endif;

	$select_html .= '</select>';

	return '<div class="select_adv_cat_block">'
	       . $select_html
	       . '</div>';
}

function ihosting_param_num_field( $settings, $value ) {

	$value = max( 1, intval( $value ) );

	return '<div>
                <input type="text" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value nl-num-input" value="' . esc_attr( $value ) . '" />
            </div>';
}


function ihosting_select_product_cat_field( $settings, $value ) {

	return '<div class="select_pro_cat_block">'
	       . ihosting_procats_slug_select(
		       array( $value ),
		       array(
			       'class'             => 'wpb_vc_param_value',
			       'name'              => $settings['param_name'],
			       'first_option'      => true,
			       'first_select_val'  => '',
			       'first_select_text' => __( ' --- All Categories --- ', 'ihosting-core' )
		       )
	       )
	       . '</div>';
}

function ihosting_select_product_cat_field_2( $settings, $value ) {

	return '<div class="select_pro_cat_block">'
	       . ihosting_procats_slug_select(
		       array( $value ),
		       array(
			       'class'             => 'wpb_vc_param_value',
			       'name'              => $settings['param_name'],
			       'first_option'      => true,
			       'first_select_val'  => '',
			       'first_select_text' => __( ' --- Choose A Category --- ', 'ihosting-core' )
		       )
	       )
	       . '</div>';
}

function ihosting_select_cat_field( $settings, $value ) {

	return '<div class="select_post_cat_block">'
	       . ihosting_custom_tax_slug_select(
		       array( $value ),
		       array(
			       'tax'               => 'category',
			       'class'             => 'wpb_vc_param_value',
			       'name'              => $settings['param_name'],
			       'first_option'      => true,
			       'first_option_val'  => '0',
			       'first_option_text' => __( ' --- All Categories --- ', 'ihosting-core' )
		       )
	       )
	       . '</div>';
}

function ihosting_select_portfolio_cat_field( $settings, $value ) {

	return '<div class="select_portfolio_cat_block">'
	       . ihosting_custom_tax_select(
		       array( $value ),
		       array(
			       'tax'               => 'portfolio_cat',
			       'class'             => 'wpb_vc_param_value',
			       'name'              => $settings['param_name'],
			       'first_option'      => true,
			       'first_option_val'  => '0',
			       'first_option_text' => __( ' --- All Categories --- ', 'ihosting-core' )
		       )
	       )
	       . '</div>';
}


if ( !function_exists( 'ihosting_get_the_category_list' ) ) {

	/**
	 * Retrieve category list in either HTML list or custom format. Modified from get_the_category_list()
	 *
	 * @since 1.0
	 *
	 * @param string $separator Optional, default is empty string. Separator for between the categories.
	 * @param string $parents   Optional. How to display the parents.
	 * @param int    $post_id   Optional. Post ID to retrieve categories.
	 *
	 * @return string
	 */
	function ihosting_get_the_category_list( $separator = '', $parents = '', $post_id = false ) {
		global $wp_rewrite;
		if ( !is_object_in_taxonomy( get_post_type( $post_id ), 'category' ) ) {
			/** This filter is documented in wp-includes/category-template.php */
			return apply_filters( 'the_category', '', $separator, $parents );
		}

		$categories = get_the_category( $post_id );
		if ( empty( $categories ) ) {
			/** This filter is documented in wp-includes/category-template.php */
			return apply_filters( 'the_category', __( 'Uncategorized' ), $separator, $parents );
		}

		$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

		$thelist = '';
		if ( '' == $separator ) {
			foreach ( $categories as $category ) {
				$thelist .= "\n\t";
				switch ( strtolower( $parents ) ) {
					case 'multiple':
						if ( $category->parent )
							$thelist .= get_category_parents( $category->parent, true, $separator );
						$thelist .= '<a class="name-category" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name . '</a>';
						break;
					case 'single':
						$thelist .= '<a class="name-category" href="' . esc_url( get_category_link( $category->term_id ) ) . '"  ' . $rel . '>';
						if ( $category->parent )
							$thelist .= get_category_parents( $category->parent, false, $separator );
						$thelist .= $category->name . '</a>';
						break;
					case '':
					default:
						$thelist .= '<a class="name-category" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name . '</a>';
				}
			}
		}
		else {
			$i = 0;
			foreach ( $categories as $category ) {
				if ( 0 < $i )
					$thelist .= $separator;
				switch ( strtolower( $parents ) ) {
					case 'multiple':
						if ( $category->parent )
							$thelist .= get_category_parents( $category->parent, true, $separator );
						$thelist .= '<a class="name-category" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name . '</a>';
						break;
					case 'single':
						$thelist .= '<a class="name-category" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>';
						if ( $category->parent )
							$thelist .= get_category_parents( $category->parent, false, $separator );
						$thelist .= "$category->name</a>";
						break;
					case '':
					default:
						$thelist .= '<a class="name-category" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name . '</a>';
				}
				++$i;
			}
		}

		/**
		 * Filter the category or list of categories.
		 *
		 * @since 1.2.0
		 *
		 * @param array  $thelist   List of categories for the current post.
		 * @param string $separator Separator used between the categories.
		 * @param string $parents   How to display the category parents. Accepts 'multiple',
		 *                          'single', or empty.
		 */
		return apply_filters( 'the_category', $thelist, $separator, $parents );
	}

}

if ( !function_exists( 'ihosting_get_the_tax_list' ) ) {

	/**
	 * Retrieve category list in either HTML list or custom format.
	 *
	 * @since 1.0
	 *
	 *
	 */
	function ihosting_get_the_tax_list( $separator = '', $post_id = false, $taxonomy = '' ) {

		if ( $post_id == false || intval( $post_id ) <= 0 ) {
			$post_id = get_the_ID();
		}

		$html = '';

		if ( trim( $taxonomy == '' ) ) {
			$taxonomy = 'post_tag';
		}

		$terms = wp_get_post_terms( $post_id, $taxonomy );

		if ( !is_wp_error( $terms ) ) {
			if ( !empty( $terms ) ) {
				$total = count( $terms );
				$i = 0;
				foreach ( $terms as $term ):

					$i++;
					$html .= '<a href="' . get_term_link( $term, $taxonomy ) . '" class="name-category">' . sanitize_text_field( $term->name ) . '</a>';
					if ( $i < $total ) {
						$html .= '<span class="separator">' . $separator . '</span>';
					}

				endforeach;
			}
		}

		$html = '<div class="term-list">
                    ' . $html . '
                </div><!-- /.term-list -->';

		return $html;

	}

}

if ( !function_exists( 'ihosting_product_loop' ) ) {
	function ihosting_product_loop( $query_args, $atts, $loop_name, $extra_class = '' ) {

		if ( !class_exists( 'WooCommerce' ) ):
			return false;
		endif;

		global $woocommerce_loop, $before_loop_extra_class;

		$before_loop_extra_class .= trim( ' ' . $extra_class );

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts ) );
		$columns = absint( $atts['columns'] );
		$woocommerce_loop['columns'] = $columns;

		ob_start();

		if ( $products->have_posts() ) : ?>

			<?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

			<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php do_action( "woocommerce_shortcode_after_{$loop_name}_loop" ); ?>

		<?php endif;

		woocommerce_reset_loop();
		wp_reset_postdata();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}
}


function ihosting_quick_edit_post_via_ajax() {

	$response = array(
		'html'    => '',
		'message' => ''
	);

	// Only admin can quick edit
	if ( !current_user_can( 'manage_options' ) ) {
		$response['message'] = __( 'You have not permission to edit this post', 'ihosting-core' );
		wp_send_json( $response );
	}

	$ts_vc_edit_nonce = isset( $_POST['ts_vc_edit_nonce'] ) ? $_POST['ts_vc_edit_nonce'] : '';

	if ( !wp_verify_nonce( $ts_vc_edit_nonce, 'ts_vc_edit_nonce' ) ) {
		$response['message'] = __( 'Security check error. Please re-loggin.', 'ihosting-core' );
		wp_send_json( $response );
	}

	$is_edit_title = isset( $_POST['is_edit_title'] ) ? $_POST['is_edit_title'] == 'yes' : false;
	$post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
	$new_val = isset( $_POST['new_val'] ) ? $_POST['new_val'] : '';
	$edit_for = isset( $_POST['edit_for'] ) ? $_POST['edit_for'] : ''; // Should be post meta key if is not title edit

	if ( $is_edit_title ) {
		$post_args = array(
			'ID'         => $post_id,
			'post_title' => $new_val
		);
		wp_update_post( $post_args );
		$response['message'] = __( 'Title updated', 'ihosting-core' );
	}
	else {
		update_post_meta( $post_id, $edit_for, $new_val );
		$response['message'] = __( 'Post meta data updated', 'ihosting-core' );
	}

	wp_send_json( $response );

	die();
}

add_action( 'wp_ajax_ihosting_quick_edit_post_via_ajax', 'ihosting_quick_edit_post_via_ajax' );


function ihosting_load_quick_edit_animated_posts_via_ajax() {

	$response = array(
		'html'    => '',
		'message' => ''
	);

	// Only admin can quick edit
	if ( !current_user_can( 'manage_options' ) ) {
		$response['message'] = __( 'You have not permission to edit this post', 'ihosting-core' );
		wp_send_json( $response );
	}

	$ts_vc_edit_nonce = isset( $_POST['ts_vc_edit_nonce'] ) ? $_POST['ts_vc_edit_nonce'] : '';

	if ( !wp_verify_nonce( $ts_vc_edit_nonce, 'ts_vc_edit_nonce' ) ) {
		$response['message'] = __( 'Security check error. Please re-loggin.', 'ihosting-core' );
		wp_send_json( $response );
	}

	$quick_edit_items_data = isset( $_POST['quick_edit_items_data'] ) ? urldecode( $_POST['quick_edit_items_data'] ) : '';


	$settings = array(
		'param_name' => 'quick_edit_items'
	);

	$response['html'] .= ihosting_quick_edit_animated_columns_field( $settings, $quick_edit_items_data );

	wp_send_json( $response );

	die();

}

add_action( 'wp_ajax_ihosting_load_quick_edit_animated_posts_via_ajax', 'ihosting_load_quick_edit_animated_posts_via_ajax' );


/**
 * @param $search_string
 *
 * @return array
 */
function ihosting_vc_include_field_testimonial_search( $search_string ) {
	$query = $search_string;
	$data = array();
	$args = array( 's' => $query, 'post_type' => 'testimonial' );
	$args['vc_search_by_title_only'] = true;
	$args['numberposts'] = -1;
	if ( strlen( $args['s'] ) == 0 ) {
		unset( $args['s'] );
	}
	add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
	$posts = get_posts( $args );
	if ( is_array( $posts ) && !empty( $posts ) ) {
		foreach ( $posts as $post ) {
			$data[] = array(
				'value' => $post->ID,
				'label' => $post->post_title,
				'group' => $post->post_type,
			);
		}
	}

	return $data;
}

/**
 * @param $search_string
 *
 * @return array
 */
function ihosting_vc_include_field_member_search( $search_string ) {
	$query = $search_string;
	$data = array();
	$args = array( 's' => $query, 'post_type' => 'member' );
	$args['vc_search_by_title_only'] = true;
	$args['numberposts'] = -1;
	if ( strlen( $args['s'] ) == 0 ) {
		unset( $args['s'] );
	}
	add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
	$posts = get_posts( $args );
	if ( is_array( $posts ) && !empty( $posts ) ) {
		foreach ( $posts as $post ) {
			$data[] = array(
				'value' => $post->ID,
				'label' => $post->post_title,
				'group' => $post->post_type,
			);
		}
	}

	return $data;
}

/**
 * @param $search_string
 *
 * @return array
 */
function ihosting_vc_include_field_product_search( $search_string ) {
	$query = $search_string;
	$data = array();
	$args = array( 's' => $query, 'post_type' => 'product' );
	$args['vc_search_by_title_only'] = true;
	$args['numberposts'] = -1;
	if ( strlen( $args['s'] ) == 0 ) {
		unset( $args['s'] );
	}
	add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
	$posts = get_posts( $args );
	if ( is_array( $posts ) && !empty( $posts ) ) {
		foreach ( $posts as $post ) {
			$data[] = array(
				'value' => $post->ID,
				'label' => $post->post_title,
				'group' => $post->post_type,
			);
		}
	}

	return $data;
}

/**
 * @param $search_string
 *
 * @return array
 */
function ihosting_vc_include_field_post_search( $search_string ) {
	$query = $search_string;
	$data = array();
	$args = array( 's' => $query, 'post_type' => 'post' );
	$args['vc_search_by_title_only'] = true;
	$args['numberposts'] = -1;
	if ( strlen( $args['s'] ) == 0 ) {
		unset( $args['s'] );
	}
	add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
	$posts = get_posts( $args );
	if ( is_array( $posts ) && !empty( $posts ) ) {
		foreach ( $posts as $post ) {
			$data[] = array(
				'value' => $post->ID,
				'label' => $post->post_title,
				'group' => $post->post_type,
			);
		}
	}

	return $data;
}

/**
 * @param $value
 *
 * @return array|bool
 */
function ihosting_vc_include_field_render( $value ) {
	$post = get_post( $value['value'] );

	return is_null( $post ) ? false : array(
		'label' => $post->post_title,
		'value' => $post->ID,
		'group' => $post->post_type
	);
}

/**
 * Suggester for autocomplete to find product category by id/name/slug but return found product category SLUG
 *
 * @since 1.0
 *
 * @param $query
 *
 * @return array - slug of products categories.
 */
function ihosting_product_cat_autocomplete_suggester_by_slug( $query ) {
	$result = ihosting_product_cat_autocomplete_suggester( $query, true );

	return $result;
}

/**
 * Autocomplete suggester to search product category by name/slug or id.
 *
 * @since 1.0
 *
 * @param      $query
 * @param bool $slug - determines what output is needed
 *                   default false - return id of product category
 *                   true - return slug of product category
 *
 * @return array
 */
function ihosting_product_cat_autocomplete_suggester( $query, $slug = false ) {
	global $wpdb;
	$cat_id = (int)$query;
	$query = trim( $query );
	$post_meta_infos = $wpdb->get_results(
		$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
					FROM {$wpdb->term_taxonomy} AS a
					INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
					WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
		                $cat_id > 0 ? $cat_id : -1, stripslashes( $query ), stripslashes( $query )
		), ARRAY_A
	);

	$result = array();
	if ( is_array( $post_meta_infos ) && !empty( $post_meta_infos ) ) {
		foreach ( $post_meta_infos as $value ) {
			$data = array();
			$data['value'] = $slug ? $value['slug'] : $value['id'];
			$data['label'] = __( 'Id', 'js_composer' ) . ': ' .
			                 $value['id'] .
			                 ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'js_composer' ) . ': ' .
			                                                      $value['name'] : '' ) .
			                 ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'js_composer' ) . ': ' .
			                                                      $value['slug'] : '' );
			$result[] = $data;
		}
	}

	return $result;
}

/**
 * Search product category by slug.
 *
 * @since 1.0
 *
 * @param $query
 *
 * @return bool|array
 */
function ihosting_product_cat_render_by_slug_exact( $query ) {
	global $wpdb;
	$query = $query['value'];
	$query = trim( $query );
	$term = get_term_by( 'slug', $query, 'product_cat' );

	return ihosting_product_cat_term_slug_output( $term );
}


/**
 * Search product category by id
 *
 * @since 1.0
 *
 * @param $query
 *
 * @return bool|array
 */
function ihosting_product_cat_render_by_id_exact( $query ) {
	global $wpdb;
	$query = $query['value'];
	$cat_id = (int)$query;
	$term = get_term( $cat_id, 'product_cat' );

	return ihosting_product_cat_term_output( $term );
}

/**
 * Return product category value|label array
 *
 * @param $term
 *
 * @since 1.0
 * @return array|bool
 */
function ihosting_product_cat_term_output( $term ) {
	$term_slug = $term->slug;
	$term_title = $term->name;
	$term_id = $term->term_id;

	$term_slug_display = '';
	if ( !empty( $term_slug ) ) {
		$term_slug_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $term_slug;
	}

	$term_title_display = '';
	if ( !empty( $term_title ) ) {
		$term_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $term_title;
	}

	$term_id_display = __( 'Id', 'js_composer' ) . ': ' . $term_id;

	$data = array();
	$data['value'] = $term_id;
	$data['label'] = $term_id_display . $term_title_display . $term_slug_display;

	return !empty( $data ) ? $data : false;
}

/**
 * Return product category value|label array
 *
 * @param $term
 *
 * @since 1.0
 * @return array|bool
 */
function ihosting_product_cat_term_slug_output( $term ) {
	$term_slug = $term->slug;
	$term_title = $term->name;
	$term_id = $term->term_id;

	$term_slug_display = '';
	if ( !empty( $term_slug ) ) {
		$term_slug_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $term_slug;
	}

	$term_title_display = '';
	if ( !empty( $term_title ) ) {
		$term_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $term_title;
	}

	$term_id_display = __( 'Id', 'js_composer' ) . ': ' . $term_id;

	$data = array();
	$data['value'] = $term_slug;
	$data['label'] = $term_id_display . $term_title_display . $term_slug_display;

	return !empty( $data ) ? $data : false;
}


/**
 *  Return shortcode array for VC select
 **/
function ihosting_select_ess_grid_shortcodes() {
	global $wpdb;

	$ess_grid_args = array();

	if ( !class_exists( 'Essential_Grid' ) ) {
		return array();
	}
	else {

		$sql = "SELECT * " .
		       "FROM " . $wpdb->prefix . "eg_grids " .
		       "ORDER BY name ASC " .
		       " ";

		$rows = $wpdb->get_results( $sql );

		if ( count( $rows ) > 0 ) {

			foreach ( $rows as $row ):

				$ess_grid_args[$row->name] = $row->handle;

			endforeach;

		}

	}

	return $ess_grid_args;

}

if ( !function_exists( 'ihosting_add_wishlist_btn' ) ) {

	/** Add wish list button to shop loop item */
	function ihosting_add_wishlist_btn( $product_id = 0, $echo = true ) {

		$product_id = intval( $product_id );
		if ( $product_id <= 0 ) {
			$product_id = get_the_ID();
		}

		$html = '';

		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			$html = do_shortcode( '[yith_wcwl_add_to_wishlist product_id="' . $product_id . '"]' );
		}

		if ( $echo ) {
			echo $html;
		}
		else {
			return $html;
		}

	}

}

if ( !function_exists( 'ihosting_core_change_post_type_title_placeholder_text' ) ) {
	function ihosting_core_change_post_type_title_placeholder_text( $title ) {
		$screen = get_current_screen();

		if ( 'member' == $screen->post_type ) {
			$title = esc_html__( 'Enter member name', 'ihosting-core' );
		}

		if ( 'testimonial' == $screen->post_type ) {
			$title = esc_html__( 'Who is said this?', 'ihosting-core' );
		}

		return $title;
	}

	add_filter( 'enter_title_here', 'ihosting_core_change_post_type_title_placeholder_text' );
}

if ( !function_exists( 'ihosting_add_compare_btn' ) ) {

	/** Add wish list button to shop loop item */
	function ihosting_add_compare_btn( $product_id = 0, $echo = true ) {

		$product_id = intval( $product_id );
		if ( $product_id <= 0 ) {
			$product_id = get_the_ID();
		}

		$html = '';

		if ( shortcode_exists( 'yith_compare_button' ) ) {
			$html = do_shortcode( '[yith_compare_button product_id="' . $product_id . '"]' );
		}

		if ( $echo ) {
			echo $html;
		}
		else {
			return $html;
		}

	}

}

if ( !function_exists( 'ihosting_add_quick_view_button' ) ) {
	function ihosting_add_quick_view_button( $product_id = 0, $echo = true ) {

		$product_id = intval( $product_id );
		if ( $product_id <= 0 ) {
			$product_id = get_the_ID();
		}

		$html = '';

		if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
			$label = esc_html( get_option( 'yith-wcqv-button-label' ) );
			$html = '<a href="#" class="button yith-wcqv-button" data-product_id="' . esc_attr( $product_id ) . '">' . $label . '</a>';
		}

		if ( $echo ) {
			echo $html;
		}
		else {
			return $html;
		}
	}
}

if ( !function_exists( 'ihosting_add_to_cart_button' ) ) {
	function ihosting_add_to_cart_button( $product, $echo = true ) {

		$html = apply_filters( 'woocommerce_loop_add_to_cart_link',
		                       sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
		                                esc_url( $product->add_to_cart_url() ),
		                                esc_attr( $product->id ),
		                                esc_attr( $product->get_sku() ),
		                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
		                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
		                                esc_attr( $product->product_type ),
		                                esc_html( $product->add_to_cart_text() )
		                       ),
		                       $product
		);

		if ( $echo ) {
			echo $html;
		}
		else {
			return $html;
		}
	}
}

if ( !function_exists( 'ihosting_core_cmb2_render_callback_for_spectrum_color_picker' ) ) {
	/**
	 *
	 * Field type is 'kt_color_picker'
	 *
	 * @param $field                The current CMB2_Field object.
	 * @param $escaped_value        The value of this field passed through the escaping filter. It defaults to 'sanitize_text_field'. If you need the unescaped value, you can access it via $field_type_object->value()
	 * @param $object_id            The id of the object you are working with. Most commonly, the post id.
	 * @param $object_type          The type of object you are working with. Most commonly, post (this applies to all post-types), but could also be comment, user or options-page
	 * @param $field_type_object    This is an instance of the CMB2_Types object and gives you access to all of the methods that CMB2 uses to build its field types.
	 *
	 * @since  1.0
	 *
	 * @author Le Manh Linh
	 *
	 */
	function ihosting_core_cmb2_render_callback_for_spectrum_color_picker(
		$field, $escaped_value, $object_id, $object_type, $field_type_object
	) {
		echo $field_type_object->input(
			array(
				'type'  => 'text',
				'class' => 'regular-text kt-color-picker spectrum-color-picker'
			)
		);
	}

	add_action( 'cmb2_render_kt_color_picker', 'ihosting_core_cmb2_render_callback_for_spectrum_color_picker', 10, 5 );
}

if ( !function_exists( 'ihosting_core_cmb2_sanitize_kt_color_picker_callback' ) ) {
	function ihosting_core_cmb2_sanitize_kt_color_picker_callback( $override_value, $value ) {
		$value = esc_attr( $value );

		return $value;
	}

	add_filter( 'cmb2_sanitize_kt_color_picker', 'ihosting_core_cmb2_sanitize_kt_color_picker_callback', 10, 2 );
}

if ( !function_exists( 'ihosting_core_footer_options_for_metabox' ) ) {
	function ihosting_core_footer_options_for_metabox() {
		$footers = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type'      => 'footer',
				'post_status'    => 'publish'
			)
		);

		$ihosting_footers = array( 'global' => esc_html__( 'Use theme options global settings', 'ihosting-core' ) );
		if ( !empty( $footers ) ) {
			foreach ( $footers as $footer ) {
				setup_postdata( $footer );
				$ihosting_footers[$footer->ID] = sanitize_text_field( $footer->post_title );
			}
		}

		wp_reset_postdata();

		return $ihosting_footers;

	}
}

if ( !function_exists( 'ihosting_core_rev_slide_options_for_redux' ) ) {
	function ihosting_core_rev_slide_options_for_redux() {

		if ( function_exists( 'ihosting_rev_slide_options_for_redux' ) ) {
			return ihosting_rev_slide_options_for_redux();
		}

		$ihosting_herosection_revolutions = array( '' => esc_html__( '--- Choose Revolution Slider ---', 'ihosting-core' ) );
		if ( class_exists( 'RevSlider' ) ) {
			global $wpdb;
			if ( shortcode_exists( 'rev_slider' ) ) {
				$rev_sql = $wpdb->prepare(
					"SELECT rs.* 
                    FROM {$wpdb->prefix}revslider_sliders rs 
                    WHERE %d 
                    ORDER BY rs.title ASC", 1
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

function ihosting_time_ago() {

	global $post;

	$date = get_post_time( 'G', true, $post );

	// Array of time period chunks
	$chunks = array(
		array( 60 * 60 * 24 * 365, __( 'year', 'ihosting-core' ), __( 'years', 'ihosting-core' ) ),
		array( 60 * 60 * 24 * 30, __( 'month', 'ihosting-core' ), __( 'months', 'ihosting-core' ) ),
		array( 60 * 60 * 24 * 7, __( 'week', 'ihosting-core' ), __( 'weeks', 'ihosting-core' ) ),
		array( 60 * 60 * 24, __( 'day', 'ihosting-core' ), __( 'days', 'ihosting-core' ) ),
		array( 60 * 60, __( 'hour', 'ihosting-core' ), __( 'hours', 'ihosting-core' ) ),
		array( 60, __( 'minute', 'ihosting-core' ), __( 'minutes', 'ihosting-core' ) ),
		array( 1, __( 'second', 'ihosting-core' ), __( 'seconds', 'ihosting-core' ) )
	);

	if ( !is_numeric( $date ) ) {
		$time_chunks = explode( ':', str_replace( ' ', ':', $date ) );
		$date_chunks = explode( '-', str_replace( ' ', '-', $date ) );
		$date = gmmktime( (int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0] );
	}

	$current_time = current_time( 'mysql', $gmt = 0 );
	$newer_date = strtotime( $current_time );

	// Difference in seconds
	$since = $newer_date - $date;

	// Something went wrong with date calculation and we ended up with a negative date.
	if ( 0 > $since )
		return __( 'sometime', 'ihosting-core' );

	/**
	 * We only want to output one chunks of time here, eg:
	 * x years
	 * xx months
	 * so there's only one bit of calculation below:
	 */

	//Step one: the first chunk
	for ( $i = 0, $j = count( $chunks ); $i < $j; $i++ ) {
		$seconds = $chunks[$i][0];

		// Finding the biggest chunk (if the chunk fits, break)
		if ( ( $count = floor( $since / $seconds ) ) != 0 )
			break;
	}

	// Set output var
	$output = ( 1 == $count ) ? '1 ' . $chunks[$i][1] : $count . ' ' . $chunks[$i][2];


	if ( !(int)trim( $output ) ) {
		$output = '0 ' . __( 'seconds', 'ihosting-core' );
	}

	$output .= __( ' ago', 'ihosting-core' );

	return $output;
}

if ( !function_exists( 'ihosting_core_no_image' ) ) {

	/**
	 * No image generator
	 *
	 * @since 1.0
	 *
	 * @param $size : array, image size
	 * @param $echo : bool, echo or return no image url
	 **/
	function ihosting_core_no_image(
		$size = array( 'width' => 500, 'height' => 500 ), $echo = false, $transparent = false
	) {

		$noimage_dir = IHOSTINGCORE_DIR_PATH;
		$noimage_uri = IHOSTINGCORE_BASE_URL;

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

if ( !function_exists( 'ihosting_core_resize_image' ) ) {
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
	function ihosting_core_resize_image(
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
						$vt_image = array( 'url' => ihosting_core_no_image( array( 'width' => $width, 'height' => $height ) ), 'width' => $width, 'height' => $height, );
					}
					else {
						if ( $color == 'transparent' ) { // Show no image transparent
							$vt_image = array( 'url' => ihosting_core_no_image( array( 'width' => $width, 'height' => $height ), false, true ), 'width' => $width, 'height' => $height, );
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