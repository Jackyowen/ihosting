<?php
/*
 Plugin Name: WHMCS Bridge Pro (aka SSO)
 Plugin URI: http://i-plugins.com
 Description: WHMCS Bridge Pro (aka SSO) is a professional extension to the WHMCS Bridge plugin that takes the integration between WHMCS and Wordpress a step further.
 Author: globalprogramming
 Version: 3.7.2
 Author URI: http://i-plugins.com/
 */

require_once(dirname(__FILE__) . '/sso.init.php');

register_activation_hook(__FILE__,'cc_whmcs_bridge_sso_activate');
register_deactivation_hook(__FILE__,'cc_whmcs_bridge_sso_deactivate');
