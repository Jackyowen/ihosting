<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noNewsLetter' );
function noNewsLetter() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Newsletter', 'ihosting-core' ),
            'base'        => 'no_news_letter', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Style', 'ihosting-core' ),
                    'param_name'    => 'style',
                    'value'         => array(
                        __( 'Style 1', 'ihosting-core' ) => 'title_before', // Title before form and no bg
                        __( 'Style 2', 'ihosting-core' ) => 'title_after' // Title after form with a bg
                    ),
                    'std'           => 'title_after',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'Get 10% off', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Short Description', 'ihosting-core' ),
                    'param_name'    => 'short_desc',
                    'std'           => __( 'by subscribing to our newsletter', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Submit Text', 'ihosting-core' ),
                    'param_name'    => 'submit_text',
                    'std'           => __( 'Submit', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Placeholder Text', 'ihosting-core' ),
                    'param_name'    => 'placeholder',
                    'std'           => __( 'Your email address...', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Success Message', 'ihosting-core' ),
                    'param_name'    => 'success_message',
                    'std'           => __( 'Your email added...', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'attach_image',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Image', 'ihosting-core' ),
                    'param_name'    => 'img_id',
                    'description'   => __( 'Choose an image as background', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value'     => array( 'title_after' )
    			   	),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Image Size', 'ihosting-core' ),
                    'param_name'    => 'img_size',
                    'std'           => '592x382',
                    'description'   => __( '<em>{width}x{height}</em>. Example: <em>592x382</em>, <em>920x382</em>, etc...', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value'     => array( 'title_after' )
    			   	),
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Using Theme Options', 'ihosting-core' ),
                    'param_name'    => 'using_theme_options_api_settings',
                    'value'         => array(
                        __( 'Yes', 'ihosting-core' ) => 'yes',
                        __( 'No', 'ihosting-core' ) => 'no'
                    ),
                    'std'           => 'yes',
                    'group'         => __( 'Mailchimp Settings', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Mailchimp API Key', 'ihosting-core' ),
                    'param_name'    => 'api_key',
                    'description'   => sprintf( __( '<a href="%s" target="__blank">Click here to get your Mailchimp API key</a>', 'ihosting-core' ), 'https://admin.mailchimp.com/account/api' ),
                    'dependency' => array(
    				    'element'   => 'using_theme_options_api_settings',
    				    'value'     => array( 'no' )
    			   	),
                    'group'         => __( 'Mailchimp Settings', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Mailchimp List ID', 'ihosting-core' ),
                    'param_name'    => 'list_id',
                    'description'   => sprintf( __( '<a href="%s" target="__blank">How to find Mailchimp list ID</a>', 'ihosting-core' ), 'http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id' ),
                    'dependency' => array(
    				    'element'   => 'using_theme_options_api_settings',
    				    'value'     => array( 'no' )
    			   	),
                    'group'         => __( 'Mailchimp Settings', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'css_animation',
    				    'not_empty' => true,
    			   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}

function no_news_letter( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_news_letter', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'style'             =>  'title_after',
        'title'             =>  '',
        'short_desc'        =>  '',
        'submit_text'       =>  '',
        'placeholder'       =>  '',
        'success_message'   =>  '',
        'img_id'            =>  0,
        'img_size'          =>  '592x382', // {width}x{height}
        'using_theme_options_api_settings'  =>  'yes',
        'api_key'           =>  '',
        'list_id'           =>  '',
        'css_animation'     =>  '',
        'animation_delay'   =>  '0.4',   //In second
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    if ( !is_numeric( $animation_delay ) ) {
        $animation_delay = 0;
    }
    $animation_delay = $animation_delay . 's';
    
    $action_url = IHOSTINGCORE_BASE_URL . 'core/shortcodes/no_news_letter.php';
    
    if ( trim( $using_theme_options_api_settings ) == 'yes' ) {
        global $ihosting;
        $api_key = isset( $ihosting['opt_mailchimp_api_key'] ) ? $ihosting['opt_mailchimp_api_key'] : '';
        $list_id = isset( $ihosting['opt_mailchimp_list_id'] ) ? $ihosting['opt_mailchimp_list_id'] : '';
    }
    
    $img_size_x = 592;
    $img_size_y = 582;
    if ( trim( $img_size ) != '' ) {
        $img_size = explode( 'x', $img_size );
    }
    $img_size_x = isset( $img_size[0] ) ? max( 0, intval( $img_size[0] ) ) : $img_size_x;
    $img_size_y = isset( $img_size[1] ) ? max( 0, intval( $img_size[1] ) ) : $img_size_y;
    
    if ( intval( $img_id ) > 0 ) {
        $img = ihosting_core_resize_image( $img_id, null, $img_size_x, $img_size_y, true, true, false, 'fff' );   
    }
    else{
        $img = array(
            'url' =>  ihosting_no_image( array( 'width' => $img_size_x, 'height' => $img_size_y ), false, true ),
            'width' => $img_size_x,
            'height' => $img_size_y
        );
    }
    
    $html = '';
    $figure_html = '';
    $before_form_html = '';
    $after_form_html = '';
    
    if ( trim( $style ) == 'title_before' ) {
        $before_form_html = '<h4>' . sanitize_text_field( $title ) . '</h4>
		                      <p>' . sanitize_text_field( $short_desc ) . '</p>';
        $css_class .= ' kt-newsletter-shortcode ' . esc_attr( $style );
    }
    if ( trim( $style ) == 'title_after' ) {
        $after_form_html = '<h4>' . sanitize_text_field( $title ) . '</h4>
		                      <p>' . sanitize_text_field( $short_desc ) . '</p>';
        $figure_html = '<figure><img width="' . esc_attr( $img['width'] ) . '" height="' . esc_attr( $img['height'] ) . '" src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ) . '"></figure>';
        $css_class .= ' ts-feature feature-newsletter ' . esc_attr( $style );
    }
    
    
    
    
    $html .= '<div class="' . esc_attr( $css_class ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . '">
					' . $figure_html . '
					<div class="info-feature newsletter-form-wrap">
                        ' . $before_form_html . '
						<form action="' . esc_url( $action_url ) . '" name="news_letter" class="form-newsletter">
                            <input type="hidden" name="api_key" value="' . esc_html( $api_key ) . '" />
                            <input type="hidden" name="list_id" value="' . esc_html( $list_id ) . '" />
                            <input type="hidden" name="success_message" value="' . sanitize_text_field( $success_message ) . '" />
							<input type="text" name="email" placeholder="' . sanitize_text_field( $placeholder ) . '">
							<span><button type="submit" name="submit_button" class="button_newletter">' . sanitize_text_field( $submit_text ) . '</button></span>
						</form>
						' . $after_form_html . '
					</div><!-- /.newsletter-form-wrap -->
				</div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_news_letter', 'no_news_letter' );

function no_submit_mailchimp_via_ajax() {
    
    if ( !class_exists( 'MCAPI' ) ) {
        ihosting_require_once( IHOSTINGCORE_LIBS. 'classes/MCAPI.class.php' );
    }
    
    $response = array(
        'html'      =>  '',
        'message'   =>  '',
        'success'   =>  'no'
    );
    
    $api_key = isset( $_POST['api_key'] ) ? $_POST['api_key'] : '';
    $list_id = isset( $_POST['list_id'] ) ? $_POST['list_id'] : '';
    $success_message = isset( $_POST['success_message'] ) ? $_POST['success_message'] : '';
    $email = isset( $_POST['email'] ) ? $_POST['email'] : '';
    
    $response['message'] = __( 'Failed', 'ihosting-core' );
    
    $merge_vars = array();
    
    if ( class_exists( 'MCAPI' ) ) {
        $api = new MCAPI( $api_key );
        if(  $api->listSubscribe( $list_id, $email, $merge_vars ) === true ) {
            $response['message'] = sanitize_text_field( $success_message );
            $response['success'] = 'yes';
    	} else {
            // Sending failed
            $response['message'] = $api->errorMessage;
    	}
    }
    
    wp_send_json( $response );
    die();
}
add_action( 'wp_ajax_no_submit_mailchimp_via_ajax', 'no_submit_mailchimp_via_ajax' );
add_action( 'wp_ajax_nopriv_no_submit_mailchimp_via_ajax', 'no_submit_mailchimp_via_ajax' );


if ( isset( $_POST['news_letter'] ) ) {
    
    if ( !class_exists( 'MCAPI' ) ) {
        ihosting_require_once( IHOSTINGCORE_LIBS. 'classes/MCAPI.class.php' );
    }
    
    $api_key          = isset( $_POST['api_key'] ) ? $_POST['api_key'] : '';
    $list_id          = isset( $_POST['list_id'] ) ? $_POST['list_id'] : '';
    $success_message = isset( $_POST['success_message'] ) ? $_POST['success_message'] : __( 'Failed', 'ihosting-core' );	
    $email = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
    //$merge_vars      = array( 'FIRSTNAME' => $fname, 'LASTNAME' => $lname );
    $merge_vars = array();
    
    if ( trim( $api_key ) != '' && trim( $list_id ) != '' && is_email( $email ) && class_exists( 'MCAPI' ) )  {
        $api = new MCAPI( $api_key );
        if(  $api->listSubscribe( $list_id, $email, $merge_vars ) === true ) {
    	   //echo  '<div class="mailchip-success">' . $success_message . '</div>';
    	} else {
    	   //echo  '<div class="mailchip-success">' . $api->errorMessage . '</div>';
    	}
    }
}


