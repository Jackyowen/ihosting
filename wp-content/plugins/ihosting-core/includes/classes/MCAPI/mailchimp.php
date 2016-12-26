<?php
function kutetheme_ovic_submit_mailchimp_via_ajax() {

	if ( !class_exists( 'MCAPI' ) ) {

		 $this->path( 'CORE_DIR', '/MCAPI/MCAPI.class.php', true);
	}

	$response = array(
		'html'    => '',
		'message' => '',
		'success' => 'no'
	);

	$api_key = "";
	$list_id = "";
	$success_message = "";
	if( function_exists( 'kutetheme_ovic_option' ) ){
		$api_key = kutetheme_ovic_option('kt_mailchimp_api_key','');
		$list_id = kutetheme_ovic_option('kt_mailchimp_list_id','');
		$success_message = kutetheme_ovic_option('kt_mailchimp_success_message','');
	}
	
	$email = isset( $_POST['email'] ) ? $_POST['email'] : '';

	$response['message'] = esc_html__( 'Failed', 'kute-toolkit' );

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

add_action( 'wp_ajax_kutetheme_ovic_submit_mailchimp_via_ajax', 'kutetheme_ovic_submit_mailchimp_via_ajax' );
add_action( 'wp_ajax_nopriv_kutetheme_ovic_submit_mailchimp_via_ajax', 'kutetheme_ovic_submit_mailchimp_via_ajax' );