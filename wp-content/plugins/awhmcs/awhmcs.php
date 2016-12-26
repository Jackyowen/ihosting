<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://awhmcs.com
 * @since             1.0.0
 * @package           Awhmcs
 *
 * @wordpress-plugin
 * Plugin Name:       awhmcs
 * Plugin URI:        http://awhmcs.com
 * Description:       aWHMCS plugin is built to work with Alaska Pro Theme, they work perfectly together to make 2 systems WHMCS and WordPress fully integrated with best result for speed, lowest cost(without any other plugins), and easiest way to setup. Enjoy it and send us any feedback to themestudio.net@gmail.com
 * Version:           1.0.0
 * Author:            Nam Nguyen
 * Author URI:        http://awhmcs.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       awhmcs
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-awhmcs-activator.php
 */
function activate_awhmcs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-awhmcs-activator.php';
	Awhmcs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-awhmcs-deactivator.php
 */
function deactivate_awhmcs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-awhmcs-deactivator.php';
	Awhmcs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_awhmcs' );
register_deactivation_hook( __FILE__, 'deactivate_awhmcs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-awhmcs.php';
require plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';
require plugin_dir_path( __FILE__ ) . 'includes/widget.php';

if ( is_admin() ) {
	require plugin_dir_path( __FILE__ ) . 'admin/admin.php';
	
	// Settings for app
	$url = get_option('whmcs_url');		
	$admin = get_option('whmcs_admin');		
	$password = get_option('whmcs_password');	
	$asscesskey = get_option('whmcs_accesskey');	
	
	$setting_file = 'settings.txt';
	
	$handle = fopen(plugin_dir_path( __FILE__ ).'/public/api/'. $setting_file, 'w') or die('Cannot open file:  '.$setting_file);
	
	$data = $url.','.$admin.','.$password.','.$asscesskey;
	
	fwrite($handle, $data);		
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_awhmcs() {

	$plugin = new Awhmcs();
	$plugin->run();

}
run_awhmcs();

add_filter( 'body_class', function( $classes ) {
    return $classes;
} );