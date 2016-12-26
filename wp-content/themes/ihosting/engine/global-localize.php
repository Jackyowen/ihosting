<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


if ( !function_exists( 'ihosting_get_global_localize' ) ) {
	function ihosting_get_global_localize() {
		// Define Global localize variable
		global $ihosting, $ihosting_global_localize, $wp_version;

		$woo_curency_symbol = '';
		if ( function_exists( 'get_woocommerce_currency_symbol' ) ) {
			$woo_curency_symbol = get_woocommerce_currency_symbol();
		}

		$is_yith_quickview_premium = defined( 'YITH_WCQV_PREMIUM' ) ? 'yes' : 'no';
		$is_main_menu_sticky = 'false';
		if ( isset( $ihosting['opt_enable_main_menu_sticky'] ) ) {
			$is_main_menu_sticky = $ihosting['opt_enable_main_menu_sticky'] == 1 ? 'true' : 'false';
		}
		$main_menu_breakpoint = isset( $ihosting['opt_main_menu_break_point'] ) ? max( 0, intval( $ihosting['opt_main_menu_break_point'] ) ) : 991;
		$vertical_menu_breakpoint = isset( $ihosting['opt_vertical_menu_break_point'] ) ? max( 0, intval( $ihosting['opt_vertical_menu_break_point'] ) ) : 991;

		// For products color filter
		$color_terms = array();
		$product_color_info = array();
		if ( version_compare( $wp_version, '4.5.0', '>=' ) ) {
			$color_terms = get_terms(
				'pa_color',
				array(
					'hide_empty' => false,
				)
			);
		}
		else {
			$color_terms = get_terms(
				array(
					'taxonomy'   => 'pa_color',
					'hide_empty' => false,
				)
			);
		}

		if ( !is_wp_error( $color_terms ) ) {
			if ( !empty( $color_terms ) ) {

				foreach ( $color_terms as $color_term ) {
					$color = 'transparent';
					if ( function_exists( 'get_tax_meta' ) ) {
						$color = trim( get_tax_meta( $color_term->term_id, 'ihosting_color' ) ) != '' ? get_tax_meta( $color_term->term_id, 'ihosting_color' ) : 'transparent';
					}
					$product_color_info[$color_term->slug] = $color;
				}

			}
		}

		// ihosting
		$ihosting_global_localize = array(
			'is_mobile'                 => 'false',
			'may_be_iphone'             => 'false',
			'is_main_menu_sticky'       => $is_main_menu_sticky,
			'main_menu_breakpoint'      => $main_menu_breakpoint,
			'vertical_menu_breakpoint'  => $vertical_menu_breakpoint,
			'custom_style_via_ajax_url' => admin_url( 'admin-ajax.php' ) . '?action=ihosting_enqueue_style_via_ajax',  // This action locate in plugins/ihosting-core/core/ajax-css.php
			'html'                      => array(
				'countdown'            => '<div class="countdown-inner">
                                        <div class="counter-item">
                                            <span class="number">%D</span>
                                            <span class="lbl">' . esc_html__( 'Days', 'ihosting' ) . '</span>
                                        </div>
                                        <div class="counter-item">
                                            <span class="number">%H</span>
                                            <span class="lbl">' . esc_html__( 'Hrs', 'ihosting' ) . '</span>
                                        </div>
                                        <div class="counter-item">
                                            <span class="number">%M</span>
                                            <span class="lbl">' . esc_html__( 'Mins', 'ihosting' ) . '</span>
                                        </div>
                                        <div class="counter-item">
                                            <span class="number">%S</span>
                                            <span class="lbl">' . esc_html__( 'Secs', 'ihosting' ) . '</span>
                                        </div>
                                    </div>',
				'countdown_admin_menu' => '<div class="countdown-inner">
                                        <div class="counter-item">
                                            <span class="number">%D</span>
                                            <span class="lbl">' . esc_html__( 'D', 'ihosting' ) . '</span>
                                        </div>
                                        <div class="counter-item">
                                            <span class="number">%H</span>
                                            <span class="lbl">' . esc_html__( 'H', 'ihosting' ) . '</span>
                                        </div>
                                        <div class="counter-item">
                                            <span class="number">%M</span>
                                            <span class="lbl">' . esc_html__( 'M', 'ihosting' ) . '</span>
                                        </div>
                                        <div class="counter-item">
                                            <span class="number">%S</span>
                                            <span class="lbl">' . esc_html__( 'S', 'ihosting' ) . '</span>
                                        </div>
                                    </div>'
			),
			'product_color_info'        => $product_color_info,
			'curency_symbol'            => $woo_curency_symbol,
			'is_yith_quickview_premium' => $is_yith_quickview_premium
		);

		return $ihosting_global_localize;
	}
}


