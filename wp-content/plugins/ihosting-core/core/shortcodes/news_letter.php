<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'lkNewsLetter' );
function lkNewsLetter() {
	global $kt_vc_anim_effects_in;

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
	vc_map(
		array(
			'name'     => esc_html__( 'LK Newsletter', 'ihosting-core' ),
			'base'     => 'lk_news_letter', // shortcode
			'class'    => '',
			'category' => esc_html__( 'Lucky Shop', 'ihosting-core' ),
			'params'   => array(
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Style', 'ihosting-core' ),
					'param_name' => 'style',
					'value'      => array(
						esc_html__( 'Style 1', 'ihosting-core' ) => 'style_1',
						esc_html__( 'Style 2', 'ihosting-core' ) => 'style_2',
						esc_html__( 'Style 3', 'ihosting-core' ) => 'style_3',
					),
					'std'        => 'style_1',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title', 'ihosting-core' ),
					'param_name' => 'title',
					'std'        => esc_html__( 'Join Our Newsletter', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description', 'ihosting-core' ),
					'param_name' => 'short_desc',
					'std'        => esc_html__( 'Sign up our newsletter and get more events &amp; promotions!', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Placeholder Text', 'ihosting-core' ),
					'param_name' => 'placeholder',
					'std'        => esc_html__( 'Enter your email here', 'ihosting-core' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Success Message', 'ihosting-core' ),
					'param_name' => 'success_message',
					'std'        => esc_html__( 'Your email added...', 'ihosting-core' ),
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Title Color', 'ihosting-core' ),
					'param_name' => 'title_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Short Description Color', 'ihosting-core' ),
					'param_name' => 'short_desc_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Input Text Color', 'ihosting-core' ),
					'param_name' => 'input_text_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Input Background Color', 'ihosting-core' ),
					'param_name' => 'input_bg_color',
					'std'        => 'rgba(255,255,255,0.2)',
				),
				array(
					'type'       => 'colorpicker',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Submit Button Color', 'ihosting-core' ),
					'param_name' => 'submit_btn_color',
					'std'        => '#fff',
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Text Align', 'ihosting-core' ),
					'param_name' => 'text_align',
					'value'      => array(
						esc_html__( 'Left', 'ihosting-core' )    => 'left',
						esc_html__( 'Right', 'ihosting-core' )   => 'right',
						esc_html__( 'Center', 'ihosting-core' )  => 'center',
						esc_html__( 'Inherit', 'ihosting-core' ) => 'inherit',
					),
					'std'        => 'left',
				),
				array(
					'type'       => 'dropdown',
					'holder'     => 'div',
					'class'      => '',
					'heading'    => esc_html__( 'Using Theme Options', 'ihosting-core' ),
					'param_name' => 'using_theme_options_api_settings',
					'value'      => array(
						esc_html__( 'Yes', 'ihosting-core' ) => 'yes',
						esc_html__( 'No', 'ihosting-core' )  => 'no'
					),
					'std'        => 'yes',
					'group'      => esc_html__( 'Mailchimp Settings', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Mailchimp API Key', 'ihosting-core' ),
					'param_name'  => 'api_key',
					'description' => wp_kses( sprintf( __( '<a href="%s" target="__blank">Click here to get your Mailchimp API key</a>', 'ihosting-core' ), 'https://admin.mailchimp.com/account/api' ), $allowed_tags ),
					'dependency'  => array(
						'element' => 'using_theme_options_api_settings',
						'value'   => array( 'no' )
					),
					'group'       => esc_html__( 'Mailchimp Settings', 'ihosting-core' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__( 'Mailchimp List ID', 'ihosting-core' ),
					'param_name'  => 'list_id',
					'description' => wp_kses( sprintf( __( '<a href="%s" target="__blank">How to find Mailchimp list ID</a>', 'ihosting-core' ), 'http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id' ), $allowed_tags ),
					'dependency'  => array(
						'element' => 'using_theme_options_api_settings',
						'value'   => array( 'no' )
					),
					'group'       => esc_html__( 'Mailchimp Settings', 'ihosting-core' ),
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

function lk_news_letter( $atts ) {

	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lk_news_letter', $atts ) : $atts;

	extract(
		shortcode_atts(
			array(
				'style'                            => 'style_1',
				'title'                            => '',
				'short_desc'                       => '',
				'submit_text'                      => '',
				'placeholder'                      => '',
				'success_message'                  => '',
				'title_color'                      => '#fff',
				'short_desc_color'                 => '#fff',
				'input_text_color'                 => '#fff',
				'input_bg_color'                   => 'rgba(255,255,255,0.2)',
				'submit_btn_color'                 => '#fff',
				'text_align'                       => 'left',
				'img_id'                           => 0,
				'img_size'                         => '592x382', // {width}x{height}
				'using_theme_options_api_settings' => 'yes',
				'api_key'                          => '',
				'list_id'                          => '',
				'css_animation'                    => '',
				'animation_delay'                  => '0.4',   //In second
				'css'                              => '',
			), $atts
		)
	);

	$css_class = 'newsleter-wrap wow ' . $css_animation;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;

	if ( !is_numeric( $animation_delay ) ) {
		$animation_delay = 0;
	}
	$animation_delay = $animation_delay . 's';

	$action_url = IHOSTINGCORE_BASE_URL . 'core/shortcodes/news_letter.php';

	if ( trim( $using_theme_options_api_settings ) == 'yes' ) {
		global $ihosting;
		$api_key = isset( $ihosting['opt_mailchimp_api_key'] ) ? $ihosting['opt_mailchimp_api_key'] : '';
		$list_id = isset( $ihosting['opt_mailchimp_list_id'] ) ? $ihosting['opt_mailchimp_list_id'] : '';
	}

	$html = '';
	$title_html = '';
	$short_desc_html = '';

	if ( trim( $title ) != '' ) {
		$title_html .= '<h4 class="news-letter-title" style="color: ' . esc_attr( $title_color ) . ';">' . sanitize_text_field( $title ) . '</h4>';
	}
	if ( trim( $short_desc ) != '' ) {
		$short_desc_html .= '<p class="short-desc" style="color: ' . esc_attr( $short_desc_color ) . ';" >' . sanitize_text_field( $short_desc ) . '</p>';
	}

	$html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
				<div class="newsletter newsletter-' . esc_attr( $style ) . ' text-' . esc_attr( $text_align ) . '">
					' . $title_html . '
					' . $short_desc_html . '
					<div class="newsletter-form-wrap">
						<form action="' . esc_url( $action_url ) . '" name="news_letter" class="form-newsletter">
	                        <input type="hidden" name="api_key" value="' . esc_html( $api_key ) . '" />
	                        <input type="hidden" name="list_id" value="' . esc_html( $list_id ) . '" />
	                        <input type="hidden" name="success_message" value="' . sanitize_text_field( $success_message ) . '" />
							<input type="text" name="email" placeholder="' . sanitize_text_field( $placeholder ) . '" style="color: ' . esc_attr( $input_text_color ) . '; background-color: ' . esc_attr( $input_bg_color ) . ';" >
							<span><button type="submit" name="submit_button" class="submit-newsletter" style="color: ' . esc_attr( $submit_btn_color ) . ';"><i class="fa fa-envelope-o"></i><span class="screen-reader-text">' . sanitize_text_field( $submit_text ) . '</span></button></span>
						</form>
					</div><!-- /.newsletter-form-wrap -->
				</div><!-- /.newsletter -->
			</div><!-- /.' . esc_attr( $css_class ) . ' -->';

	return $html;

}

add_shortcode( 'lk_news_letter', 'lk_news_letter' );

function ihosting_core_submit_mailchimp_via_ajax() {

	if ( !class_exists( 'MCAPI' ) ) {
		ihosting_require_once( IHOSTINGCORE_LIBS . 'classes/MCAPI.class.php' );
	}

	$response = array(
		'html'    => '',
		'message' => '',
		'success' => 'no'
	);

	$api_key = isset( $_POST['api_key'] ) ? $_POST['api_key'] : '';
	$list_id = isset( $_POST['list_id'] ) ? $_POST['list_id'] : '';
	$success_message = isset( $_POST['success_message'] ) ? $_POST['success_message'] : '';
	$email = isset( $_POST['email'] ) ? $_POST['email'] : '';

	$response['message'] = esc_html__( 'Failed', 'ihosting-core' );

	$merge_vars = array();

	if ( class_exists( 'MCAPI' ) ) {
		$api = new MCAPI( $api_key );
		if ( $api->listSubscribe( $list_id, $email, $merge_vars ) === true ) {
			$response['message'] = sanitize_text_field( $success_message );
			$response['success'] = 'yes';
		}
		else {
			// Sending failed
			$response['message'] = $api->errorMessage;
		}
	}

	wp_send_json( $response );
	die();
}

add_action( 'wp_ajax_ihosting_core_submit_mailchimp_via_ajax', 'ihosting_core_submit_mailchimp_via_ajax' );
add_action( 'wp_ajax_nopriv_ihosting_core_submit_mailchimp_via_ajax', 'ihosting_core_submit_mailchimp_via_ajax' );


if ( isset( $_POST['news_letter'] ) ) {

	if ( !class_exists( 'MCAPI' ) ) {
		ihosting_require_once( IHOSTINGCORE_LIBS . 'classes/MCAPI.class.php' );
	}

	$api_key = isset( $_POST['api_key'] ) ? $_POST['api_key'] : '';
	$list_id = isset( $_POST['list_id'] ) ? $_POST['list_id'] : '';
	$success_message = isset( $_POST['success_message'] ) ? $_POST['success_message'] : esc_html__( 'Failed', 'ihosting-core' );
	$email = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
	//$merge_vars      = array( 'FIRSTNAME' => $fname, 'LASTNAME' => $lname );
	$merge_vars = array();

	if ( trim( $api_key ) != '' && trim( $list_id ) != '' && is_email( $email ) && class_exists( 'MCAPI' ) ) {
		$api = new MCAPI( $api_key );
		if ( $api->listSubscribe( $list_id, $email, $merge_vars ) === true ) {
			//echo  '<div class="mailchip-success">' . $success_message . '</div>';
		}
		else {
			//echo  '<div class="mailchip-success">' . $api->errorMessage . '</div>';
		}
	}
}


