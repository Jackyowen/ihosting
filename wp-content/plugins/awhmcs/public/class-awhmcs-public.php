<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://awhmcs.com
 * @since      1.0.0
 *
 * @package    Awhmcs
 * @subpackage Awhmcs/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Awhmcs
 * @subpackage Awhmcs/public
 * @author     Nam Nguyen <vniteam@gmail.com>
 */
class Awhmcs_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;	
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Awhmcs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Awhmcs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'angular-material', plugin_dir_url( __FILE__ ) . 'css/angular-material.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $this->version, 'all' );
		wp_enqueue_style( 'fonts', plugin_dir_url( __FILE__ ) . 'css/font.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . 'css/styles.css?id='.rand(1, 1500), array(), $this->version, 'all' );
		wp_enqueue_style( 'style1', plugin_dir_url( __FILE__ ) . 'css/styles1.css?id='.rand(1, 1500), array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap-select', plugin_dir_url( __FILE__ ) . 'css/bootstrap-select.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'summernote', plugin_dir_url( __FILE__ ) . 'css/summernote.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap-markdown', plugin_dir_url( __FILE__ ) . 'css/bootstrap-markdown.min.css', array(), $this->version, 'all' );

	}
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Awhmcs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Awhmcs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/awhmcs-public.js', array( 'jquery' ), $this->version, false );
		//wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( 'summernote', plugin_dir_url( __FILE__ ) . 'js/summernote.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'angular', plugin_dir_url( __FILE__ ) . 'js/angular.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'angular-animate', plugin_dir_url( __FILE__ ) . 'js/angular-animate.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'angular-route', plugin_dir_url( __FILE__ ) . 'js/angular-route.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'angular-aria', plugin_dir_url( __FILE__ ) . 'js/angular-aria.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'angular-messages', plugin_dir_url( __FILE__ ) . 'js/angular-messages.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'angular-breadcrums', plugin_dir_url( __FILE__ ) . 'js/angular-breadcrums.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'angular-material', plugin_dir_url( __FILE__ ) . 'js/angular-material.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'storage', plugin_dir_url( __FILE__ ) . 'js/storage.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'ngCart', plugin_dir_url( __FILE__ ) . 'js/ngCart.js?id='.rand(1, 1500), array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'app-services', plugin_dir_url( __FILE__ ) . 'js/app-services.js?id='.rand(1, 1500), array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'app', plugin_dir_url( __FILE__ ) . 'js/app.js?id='.rand(1, 1500), array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'app-main', plugin_dir_url( __FILE__ ) . 'js/app-main.js?id='.rand(1, 1500), array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'app-config', plugin_dir_url( __FILE__ ) . 'js/app-config.js?id='.rand(1, 1500), array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'app2', plugin_dir_url( __FILE__ ) . 'js/app2.js?id='.rand(1, 1500), array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'paging', plugin_dir_url( __FILE__ ) . 'js/paging.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'wysiwyg', plugin_dir_url( __FILE__ ) . 'js/wysiwyg.min.js', array( 'jquery' ), $this->version, false );

	    $wnm_custom = array( 'plugin_url' => plugins_url('awhmcs').'/public/api/', 'app_permalink' => get_option('whmcs_app_permalink') , 'whmcs_ajax_url' => admin_url('admin-ajax.php') , 'whmcs_installed_folder' => get_option('whmcs_installed_folder'));
	    wp_localize_script( 'jquery', 'awhmcs', $wnm_custom );	
	    
	    wp_localize_script( 'wp-api', 'wpApiSettings', array( 'root' => esc_url_raw( rest_url() ), 'nonce' => wp_create_nonce( 'wp_rest' ) ) );

	}
	public function boostrap_enqueue_scripts() {
		wp_enqueue_script( 'bootstrap-select', plugin_dir_url( __FILE__ ) . 'js/bootstrap-select.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'bootstrap-markdown', plugin_dir_url( __FILE__ ) . 'js/bootstrap-markdown.js', array( 'jquery' ), $this->version, true );
	}

}