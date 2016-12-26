<?php
/**
 * iHosting Theme Customizer.
 *
 * @package iHosting
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ihosting_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'ihosting_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ihosting_customize_preview_js() {
	wp_enqueue_script( 'ihosting_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'ihosting_customize_preview_js' );

/**
 * Theme Options support customizer additions.
 */
if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/engine/theme-options.php' ) ) {
    require_once get_stylesheet_directory() . '/engine/theme-options.php';
}
else{
    require_once get_template_directory() . '/engine/theme-options.php';
}
