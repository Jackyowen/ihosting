<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://awhmcs.com
 * @since      1.0.0
 *
 * @package    Awhmcs
 * @subpackage Awhmcs/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Awhmcs
 * @subpackage Awhmcs/includes
 * @author     Nam Nguyen <vniteam@gmail.com>
 */
class Awhmcs {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Awhmcs_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'awhmcs';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Awhmcs_Loader. Orchestrates the hooks of the plugin.
	 * - Awhmcs_i18n. Defines internationalization functionality.
	 * - Awhmcs_Admin. Defines all hooks for the admin area.
	 * - Awhmcs_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-awhmcs-loader.php';
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/api/whmcs.class.php';	
		
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/api/action/api.php';	

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-awhmcs-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-awhmcs-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-awhmcs-public.php';

		$this->loader = new Awhmcs_Loader();
		
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
			

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Awhmcs_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Awhmcs_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Awhmcs_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Save ajx
		$this->loader->add_action( 'wp_ajax_save_button', $plugin_admin, 'save_button' );
		$this->loader->add_action( 'wp_ajax_nopriv_save_button', $plugin_admin, 'save_button' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {	
		
		$plugin_public = new Awhmcs_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'boostrap_enqueue_scripts',100 );

		// Load whmcs ajax
		$this->loader->add_action( 'wp_ajax_whmcs_ajax', $plugin_public, 'whmcs_ajax' );
		$this->loader->add_action( 'wp_ajax_nopriv_whmcs_ajax', $plugin_public, 'whmcs_ajax' );
		add_action( 'rest_api_init', function(){
		register_rest_route( 'awhmcs/v1', '/data/(?P<id>\d+)', array(
			'methods' => 'GET',
			'callback' => array($this, 'test'),
		) );			
		});
		
	}
	
	public function test( WP_REST_Request $request ) {
		
		// Get admin settings for whmcs
		$url = get_option('whmcs_url');		
		$admin = get_option('whmcs_admin');		
		$password = get_option('whmcs_password');			
		
		$whmcs = new WHMCS($url, $admin, $password, '123123');
		
		$result = $whmcs->getAnnouncements();		
		
		return $result;

	}		
	

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Awhmcs_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
