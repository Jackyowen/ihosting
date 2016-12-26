<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://awhmcs.com
 * @since      1.0.0
 *
 * @package    Awhmcs
 * @subpackage Awhmcs/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Awhmcs
 * @subpackage Awhmcs/admin
 * @author     Nam Nguyen <vniteam@gmail.com>
 */


?>
<?php

	global $wpdb;
	
	$postdata = file_get_contents("php://input");

	$request = json_decode($postdata);

	$payment_data['params'] = $postdata;
	
	print_r($wpdb) ;

	$insert = $wpdb->update( $wpdb->prefix.'awhmcs', $payment_data );
		
	die();

?>