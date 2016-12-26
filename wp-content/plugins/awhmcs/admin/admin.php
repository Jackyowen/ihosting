<?php
/*
 * @wordpress-plugin
 * Plugin Name:       awhmcs
 * Plugin URI:        http://awhmcs.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Nam Nguyen
 * Author URI:        http://awhmcs.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       awhmcs
 * Domain Path:       /languages
 */
class Awhmcs_Settings {
	public function __construct() {
		// Hook into the admin menu
		add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );
		add_action( 'admin_init', array( $this, 'setup_sections' ) );
		add_action( 'admin_init', array( $this, 'setup_fields' ) );
		add_action( 'admin_init', array( $this, 'register' ) );	
	}

	
	public function create_plugin_settings_page() {
		// Add the menu item and page
		$page_title = 'AWHCS Settings Page';
		$menu_title = 'AWHMCS';
		$capability = 'manage_options';
		$slug = 'awhmcs';
		$callback = array( $this, 'plugin_settings_page_content' );
		$icon = 'dashicons-admin-plugins';
		$position = 100;
	
		add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
	}		
	
	public function setup_sections() {
		add_settings_section( 'our_first_section', '', false, 'awhmcs' );
	}	
	
	public function setup_fields() {
	    add_settings_field( 'whmcs_url', 'WHMCS URL', array( $this, 'field_callback' ), 'awhmcs', 'our_first_section', 'whmcs_url' );
	    add_settings_field( 'whmcs_admin', 'WHMCS Admin', array( $this, 'field_callback' ), 'awhmcs', 'our_first_section', 'whmcs_admin' );
	    add_settings_field( 'whmcs_password', 'WHMCS Password', array( $this, 'field_callback' ), 'awhmcs', 'our_first_section', 'whmcs_password' );
	    add_settings_field( 'whmcs_accesskey', 'WHMCS Accesskey', array( $this, 'field_callback' ), 'awhmcs', 'our_first_section', 'whmcs_accesskey' );
	    add_settings_field( 'whmcs_app_permalink', 'Wordpres WHMCS App Permalink', array( $this, 'field_callback' ), 'awhmcs', 'our_first_section', 'whmcs_app_permalink' );
	    add_settings_field( 'whmcs_folder', 'WHMCS installed folder', array( $this, 'field_callback' ), 'awhmcs', 'our_first_section', 'whmcs_installed_folder' );
	}	
	
	public function field_callback( $arguments ) {
		echo '<input name="'.$arguments.'" id="'.$arguments.'" type="text" value="' . get_option( $arguments ) . '" />';
	}	
	
	public function register() {
		register_setting( 'awhmcs', 'whmcs_url' );
		register_setting( 'awhmcs', 'whmcs_admin' );
		register_setting( 'awhmcs', 'whmcs_password' );
		register_setting( 'awhmcs', 'whmcs_accesskey' );
		register_setting( 'awhmcs', 'whmcs_app_permalink' );
		register_setting( 'awhmcs', 'whmcs_installed_folder' );
	}		
	
	public function plugin_settings_page_content() { ?>
		<div class="wrap">
			<h2>AWHMCS Settings Page</h2>
			<form method="post" action="options.php">
	            <?php
	                settings_fields( 'awhmcs' );
	                do_settings_sections( 'awhmcs' );
	                submit_button();
	            ?>
			</form>
		</div> <?php
	}
}
new Awhmcs_Settings();