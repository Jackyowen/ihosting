<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

global $ihosting;

// Get header layout style
$layout = isset( $ihosting['opt_header_layout'] ) ? $ihosting['opt_header_layout'] : 'style-1'; // style-1: Two parts header

// Subscribe form info
$mailchimp_api_key = isset( $ihosting['opt_mailchimp_api_key'] ) ? $ihosting['opt_mailchimp_api_key'] : '';
$mailchimp_list_id = isset( $ihosting['opt_mailchimp_list_id'] ) ? $ihosting['opt_mailchimp_list_id'] : '';
$subscribe_form_title = isset( $ihosting['opt_subscribe_form_title'] ) ? $ihosting['opt_subscribe_form_title'] : '';
$subscribe_form_input_placeholder = isset( $ihosting['opt_subscribe_form_input_placeholder'] ) ? $ihosting['opt_subscribe_form_input_placeholder'] : '';
$subscribe_submit_text = isset( $ihosting['opt_subscribe_form_submit_text'] ) ? $ihosting['opt_subscribe_form_submit_text'] : esc_html__( 'Submit', 'ihosting' );
$subscribe_success_message = isset( $ihosting['opt_subscribe_success_message'] ) ? $ihosting['opt_subscribe_success_message'] : '';

$header_menu_show_way = 'show_on_click_caret';
if ( $layout == 'style-1' ) {
    $header_menu_show_way = isset( $ihosting['opt_header_menu_show_way'] ) ? $ihosting['opt_header_menu_show_way'] : $header_menu_show_way;
}

?>

<?php if ( $layout == 'style-1' ): ?>
    
    <div id="ts-main-menu" class="ts-main-menu fullheight" >
			<div class="ts-mainmenu-inner">
                
                <nav id="site-navigation" class="main-navigation navigation-ihosting <?php echo esc_attr( $header_menu_show_way ); ?>" role="navigation">
                    <?php wp_nav_menu( 
                        array( 'theme_location' => 'primary', 
                            'container' =>  false,
                            'menu_id' => 'primary-menu-' . esc_attr( $layout ),
                            'walker' => new kt_wp_bootstrap_navwalker(),
                            'fallback_cb' => 'kt_wp_bootstrap_navwalker::fallback'
                        ) 
                    ); ?>
                </nav>
                
				<div class="kt-newsletter newsletter-form-wrap">
                    <?php if ( trim( $subscribe_form_title ) != '' ): ?>
					   <h6><?php echo sanitize_text_field( $subscribe_form_title ); ?></h6>
                    <?php endif; ?>
					<form action="<?php echo esc_url( home_url( '/' ) ); ?>" name="news_letter" class="form-newsletter">
                        <input type="hidden" name="api_key" value="<?php echo esc_html( $mailchimp_api_key ); ?>" />
                            <input type="hidden" name="list_id" value="<?php echo esc_html( $mailchimp_list_id ); ?>" />
                            <input type="hidden" name="success_message" value="<?php echo sanitize_text_field( $subscribe_success_message ); ?>" />
						<input type="text" name="email" placeholder="<?php echo sanitize_text_field( $subscribe_form_input_placeholder ); ?>" />
						<span><button type="submit" name="submit_button" class="button_newletter"><?php echo sanitize_text_field( $subscribe_submit_text ); ?></button></span>
					</form>
				</div><!-- /.newsletter-form-wrap -->
                
				<div class="ts-social-header">
					<h6><?php esc_html_e( 'Follow us', 'ihosting' ); ?></h6>
					<?php get_template_part( 'template-parts/socials', 'header' ); ?>
				</div><!-- /.ts-social-header -->
                
			</div><!-- /.ts-mainmenu-inner -->
		</div><!-- /ts-main-menu -->
    
<?php endif; // End if ( $layout == 'style-1' ) ?>

<?php if ( $layout == 'style-2' ): ?>
    
    <div id="ts-main-menu" class="ts-main-menu fullheight" >
			<div class="ts-mainmenu-inner">
                
                <nav id="site-navigation" class="main-navigation navigation-ihosting" role="navigation">
                    <?php wp_nav_menu( 
                        array( 'theme_location' => 'primary', 
                            'container' =>  false,
                            'menu_id' => 'primary-menu-' . esc_attr( $layout ),
                            'walker' => new kt_wp_bootstrap_navwalker(),
                            'fallback_cb' => 'kt_wp_bootstrap_navwalker::fallback'
                        ) 
                    ); ?>
                </nav>
                
			</div><!-- /.ts-mainmenu-inner -->
		</div><!-- /ts-main-menu -->
    
<?php endif; // End if ( $layout == 'style-2' ) ?>




