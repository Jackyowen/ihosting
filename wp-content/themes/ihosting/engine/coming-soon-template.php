<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


if ( !function_exists( 'ihosting_coming_soon_html' ) ) {

	function ihosting_coming_soon_html() {
		global $ihosting;

		$date = isset( $ihosting['opt_coming_soon_date'] ) ? $ihosting['opt_coming_soon_date'] : date();
		$text = isset( $ihosting['opt_coming_soon_text'] ) ? wpautop( $ihosting['opt_coming_soon_text'] ) : '';
		$img = isset( $ihosting['opt_coming_soon_img'] ) ? $ihosting['opt_coming_soon_img'] : array( 'url' => get_template_directory_uri() . '/assets/images/logox2.png' );
		$show_subscribe_form = isset( $ihosting['opt_enable_coming_soon_newsletter'] ) ? $ihosting['opt_enable_coming_soon_newsletter'] != 0 : false;

		// Subscribe form info
		$mailchimp_api_key = isset( $ihosting['opt_mailchimp_api_key'] ) ? $ihosting['opt_mailchimp_api_key'] : '';
		$mailchimp_list_id = isset( $ihosting['opt_mailchimp_list_id'] ) ? $ihosting['opt_mailchimp_list_id'] : '';
		$subscribe_form_title = isset( $ihosting['opt_subscribe_form_title'] ) ? $ihosting['opt_subscribe_form_title'] : '';
		$subscribe_form_input_placeholder = isset( $ihosting['opt_subscribe_form_input_placeholder'] ) ? $ihosting['opt_subscribe_form_input_placeholder'] : '';
		$subscribe_submit_text = isset( $ihosting['opt_subscribe_form_submit_text'] ) ? $ihosting['opt_subscribe_form_submit_text'] : '';
		$subscribe_success_message = isset( $ihosting['opt_subscribe_success_message'] ) ? $ihosting['opt_subscribe_success_message'] : '';

		get_header( 'soon' );

		$html = '';
		$img_html = '';
		$subscribe_form_html = '';
		$count_down_html = '';

		if ( trim( $img['url'] ) != '' ) {
			$img_html = '<div class="logo-maintenance"><img src="' . esc_url( $img['url'] ) . '" alt=""></div>';
		}

		if ( $show_subscribe_form ) {
			$subscribe_form_title_html = trim( $subscribe_form_title ) != '' ? '<h5>' . sanitize_text_field( $subscribe_form_title ) . '</h5>' : '';
			$subscribe_form_html = '<div class="kt-newsletter newsletter-form-wrap">
                                        ' . $subscribe_form_title_html . '
                    					<form action="" name="news_letter" class="form-newsletter">
                                            <input type="hidden" name="api_key" value="' . esc_html( $mailchimp_api_key ) . '" />
                                                <input type="hidden" name="list_id" value="' . esc_html( $mailchimp_list_id ) . '" />
                                                <input type="hidden" name="success_message" value="' . sanitize_text_field( $subscribe_success_message ) . '" />
                    						<input type="text" name="email" placeholder="' . sanitize_text_field( $subscribe_form_input_placeholder ) . '">
                    						<span><button type="submit" name="submit_button" class="button_newletter"><i class="fa fa-envelope-o"></i><span class="screen-reader-text">' . sanitize_text_field( $subscribe_submit_text ) . '</span></button></span>
                    					</form>
                    				</div><!-- /.newsletter-form-wrap -->';
		}

		$count_down_html = '<div class="ihosting-countdown-wrap counter" data-countdown="' . esc_attr( $date ) . '"></div><!-- /.ihosting-countdown-wrap -->';

		$html .= '<div class="page-maintenance">
                		<div class="container">
                			' . $img_html . '
                			<div class="content-maintenance">
                				' . $text . '
                				' . $subscribe_form_html . '
                                ' . $count_down_html . '
                			</div>
                		</div>
                	</div>';

		echo wptexturize( $html );
		get_footer( 'soon' );

	}


}