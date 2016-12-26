<?php

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}
if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( ! defined( 'KUTETHEME_DEV' ) ) {
    define( 'KUTETHEME_DEV', false);
}
if ( ! defined( 'KUTE_TOOLKIT_VERSION' ) ) {
    define( 'KUTE_TOOLKIT_VERSION', '1.0.0' );
}

if( file_exists( get_template_directory() ."/settings/global.php")){
    require_once( get_template_directory() ."/settings/global.php" );
}

/**
 * Vc starts here. Manager sets mode, adds required wp hooks and loads required object of structure
 *
 * Manager controls and access to all modules and classes of VC.
 *
 * @package KUTE_TOOLKIT
 * @since   1.0.0
 */
class KUTE_TOOLKIT {
    public $prefix = 'kt_';
    public $theme_option = 'kt_options';
    public $hash_key = '';
    public $socials = array();
    public $product_attribute_color = 'kt_product_attribute_color';
    public $product_attribute_image_size = 'kt_product_attribute_image_size';
    public $theme_options = array();
    public $data_demos = array();

    /**
     * ROOT file
     * @since 1.0
     * @var $plugin_dir, $plugin_uri, $theme_uri
     */
    public $plugin_dir, $plugin_uri, $theme_dir, $theme_uri, $compile_less;
    /**
     * Detect Mobile
     * @since 1.0
     * @var $is_mobile detect mobile
     */
    public $mobile_detect;
    public $is_mobile = false;
    public $is_tablet = false;
    /**
     * All the URL directory
     *
     * @since 1.0
     * @author Kutethemes
     * @var array
     */
    public $paths = array();
    /**
     * Core singleton class
     * @since 1.0
     * @var self - pattern realization
     */
    public static $_instance;
    public $apm, $tm;
    public $shortcodes;
    public $_prefix = 'kt_';
    /**
     * Constructor loads API functions, defines paths and adds required wp actions
     *
     * @since  1.0.0
     */
    public function __construct() {
        global $kutetheme_ovic_option_key;
        if( $kutetheme_ovic_option_key && $kutetheme_ovic_option_key !="" ){
            $this->theme_option = $kutetheme_ovic_option_key;
        }else{
            $this->theme_option = sanitize_key(wp_get_theme()->get('Name')).'_kt_options';
        }
        $this->hash_key = hash('crc32', $this->theme_option);
        $this->theme_options = get_option($this->theme_option);        
        /* add swatches image size */
        add_image_size( $this->product_attribute_image_size, 32, 32, true);
        //echo plugin_dir_path(__FILE__).'settings/options.php';
        //die;
        //if( ! $this->is_compatible_theme() ) return false;
        $this->plugin_dir = trailingslashit(plugin_dir_path(__FILE__) );
        $this->plugin_uri = trailingslashit(plugin_dir_url(__FILE__) );
        $this->theme_dir  = trailingslashit( get_template_directory() );
        $this->theme_uri  = trailingslashit(get_template_directory_uri() );
        $this->compile_less  = false;
        /**
         * Define path settings for visual composer.
         *
         * PLUGIN          - plugin directory.
         * WP_ROOT         - WP application root directory.
         * SETTINGS_DIR    - main dashboard settings classes.
         * SHORTCODES_DIR  - shortcodes classes.
         * INCLUDES_DIR    - include some function utility
         */
        $this->setPaths( array(
            'PLUGIN'         => $this->plugin_dir,
            'PLUGIN_URI'     => $this->plugin_uri,
            'THEME'          => $this->theme_dir,
            'THEME_URI'      => $this->theme_uri,
            'WP_ROOT'        => preg_replace( '/$\//', '', ABSPATH ),
            'CORE_DIR'       => $this->plugin_dir . 'classes',
            'SHORTCODES_DIR' => $this->plugin_dir . 'js_composer',
            'SETTINGS_DIR'   => $this->plugin_dir . 'settings',
            'INCLUDES_DIR'   => $this->plugin_dir . 'includes'
        ) );
        if( ! class_exists( 'Mobile_Detect' ) ){
            $this->path( 'CORE_DIR', '/Mobile_Detect/Mobile_Detect.php', true);
        }
        
        $this->isMobile();

        if( ! class_exists( 'PW_CMB2_Field_Select2' ) ){
            $this->path( 'CORE_DIR', '/cmb-field-select2/cmb-field-select2.php', true);
        }
        
        if( ! class_exists( 'Tax_Meta_Class' ) ){
            $this->path( 'CORE_DIR', '/Tax-meta-class/Tax-meta-class.php', true);
        }        
        if( ! class_exists( 'MCAPI' ) ){
            $this->path( 'CORE_DIR', '/MCAPI/MCAPI.class.php', true);
            $this->path( 'CORE_DIR', '/MCAPI/mailchimp.php', true);
        }

//        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
//            $this->path( 'CORE_DIR', '/APM/kt_term.php', true);
//            $this->path( 'CORE_DIR', '/APM/product_attribute_meta.php', true);
//            $this->apm = new KT_Attribute_Product_Meta($this->product_attribute_color, $this->product_attribute_image_size);
//        }
                
        if( ! class_exists( 'Template_Manager_Widget' ) ){
            $this->path( 'CORE_DIR', '/TemplateManager/tm_widget.php', true);
        }
        // Add hooks        
        add_action( 'plugins_loaded', array( &$this, 'pluginsLoaded' ), 99 );
        add_action( 'init', array( &$this, 'init' ), 9 );
        add_action( 'widgets_init', array( &$this, 'register_kt_template_widget') );
        add_filter( 'product_attributes_type_selector', array($this, 'kt_product_attributes_type_selector') );
        //Load less config
        add_filter( 'less_vars', array( &$this, 'lessVars' ), 10, 2 );
        add_action( 'wp_head', array( &$this, 'addShortcodesGoogleFont'), 1 );
        add_action( 'wp_head', array( &$this, 'addFrontEndAsset'), 1 );
        register_activation_hook( __FILE__, array( $this, 'activationHook' ) );
        
        /*JS and css*/
        add_action('admin_enqueue_scripts', array($this, 'register_scripts'));
        /*JS and css font end*/
        add_action('wp_enqueue_scripts', array($this, 'kutetheme_ovic_fontend_register_scripts'));   

         add_action( 'wp_footer', array( &$this, 'kutetheme_ovic_write_option_css'), 1 );                    
    }
    function kt_css_script_remove($prefix=''){
        global $wpdb;
        $items = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options Where `option_name` LIKE '".$this->hash_key.$prefix."%'" );
        if($items)
            foreach ($items as $item)
                kutetheme_ovic_delete_option($item->option_name);
    }
    function kt_css_render($kutetheme_ovic_render = false){
        global $wpdb;
        if($kutetheme_ovic_render == false)
            return true;
        if(file_exists(trailingslashit ( get_template_directory() ). 'assets/css/options.css')){
            if(file_get_contents( trailingslashit ( get_template_directory() ). 'assets/css/options.css' ) == ''){
                $items = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options Where `option_name` LIKE '".$this->hash_key."_css-%'" );
                $css = '';
                if($items)
                    foreach ($items as $item)
                        if($item->option_value)
                            $css .= $item->option_value;
                file_put_contents(trailingslashit ( get_template_directory() ). 'assets/css/options.css', $css);
            }
        }else{
            $items = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options Where `option_name` LIKE '".$this->hash_key."_css-%'" );
            $css = '';
            if($items)
                foreach ($items as $item)
                    if($item->option_value)
                        $css .= $item->option_value;
            $file = fopen(trailingslashit ( get_template_directory() ). 'assets/css/options.css', "w");
            fwrite($file, $css);
            fclose($file);
            chmod(trailingslashit ( get_template_directory() ). 'assets/css/options.css',0777);
        }
    }
    function kutetheme_ovic_write_option_css(){
        global  $wpdb;
        $items = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options Where `option_name` LIKE '".$this->hash_key."_css-%'" );
        $css = '';
        if($items){
            foreach ($items as $item){
                if($item->option_value){
                    $css .= $item->option_value;
                }
            }
        }
        ?>
        <style id="kt_option_css" type="text/css">
            <?php echo apply_filters( 'kt_option_css', $css );?>
        </style>
        <?php
    }
    function kutetheme_ovic_write_option_js(){
        global  $wpdb;
        $items = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options Where `option_name` LIKE '".$this->hash_key."_script-%'" );
        $content = '';
        if($items){
            foreach ($items as $item){
                if($item->option_value){
                    $content .= $item->option_value;
                }
            }
        }
        if($content){
            $content = '(function($){"use strict";$(document).ready(function() {'.$content.'});})(jQuery);';
            ?>
            <script type="text/javascript">
                <?php echo apply_filters( 'kt_theme_option_js', $content );?>
            </script>
            <?php
        }
    }

    function kt_script_render($kutetheme_ovic_render = false){
        global $wpdb;
        if($kutetheme_ovic_render == false)
            return true;
        if(file_exists(trailingslashit ( get_template_directory() ). 'js/options.js')){
            if(file_get_contents( trailingslashit ( get_template_directory() ). 'js/options.js' ) == ''){
                $items = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options Where `option_name` LIKE '".$this->hash_key."_script-%'" );
                $content = '';
                if($items)
                    foreach ($items as $item)
                        if($item->option_value)
                            $content .= $item->option_value;
                if($content)
                    $content = '(function($){"use strict";$(document).ready(function() {'.$content.'});})(jQuery);';
                file_put_contents(trailingslashit ( get_template_directory() ). 'js/options.js', $content);
            }
        }else{
            $items = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options Where `option_name` LIKE '".$this->hash_key."_script-%'" );
            $content = '';
            if($items)
                foreach ($items as $item)
                    if($item->option_value)
                        $content .= $item->option_value;
            if($content)
                $content = '(function($){"use strict";$(document).ready(function() {'.$content.'});})(jQuery);';
            $file = fopen(trailingslashit ( get_template_directory() ). 'js/options.js', "w");
            fwrite($file, $content);
            fclose($file);
            chmod(trailingslashit ( get_template_directory() ). 'js/options.js',0777);
        }
        return true;
    }
    function bump_request_timeout(){
        return 60;
    }
    function kt_menu_localtion_importer($folder){

        /*$aa = wp_get_nav_menu_object( 'main-menu' );
        kt_print($aa);*/
        if(file_exists($this->theme_dir.'settings/datas/'.$folder.'/locations.xml')){
            $locations = get_theme_mod( 'nav_menu_locations' );
            $xml = simplexml_load_file($this->theme_dir.'settings/datas/'.$folder.'/locations.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
            if(isset($xml->location)){
                if(count($xml->location) >0){
                    foreach ($xml->location as $location){
                        $key = trim((string)$location->key);
                        if($key){
                            $menu = wp_get_nav_menu_object((string)$location->menu->name);
                            $locations[$key] = $menu->term_id;
                        }

                    }
                }
            }
            set_theme_mod( 'nav_menu_locations', $locations );
            return true;
        }
    }
    function kt_page_settings_importer($folder){

        if(file_exists($this->theme_dir.'settings/datas/'.$folder.'/options.xml')){
            $xml = simplexml_load_file($this->theme_dir.'settings/datas/'.$folder.'/options.xml', 'SimpleXMLElement', LIBXML_NOCDATA);

            if(isset($xml->page_on_front)){
                $page_title = trim((string)$xml->page_on_front);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('page_on_front', 'page');
                        update_option('page_on_front', $page->ID);
                    }
                }
            }
            if(isset($xml->page_for_posts)){
                $page_title = trim((string)$xml->page_for_posts);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('page_for_posts', 'page');
                        update_option('page_for_posts', $page->ID);
                    }
                }
            }
            if(isset($xml->woocommerce_shop_page_id)){
                $page_title = trim((string)$xml->woocommerce_shop_page_id);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('woocommerce_shop_page_id', 'page');
                        update_option('woocommerce_shop_page_id', $page->ID);
                    }
                }
            }
            if(isset($xml->woocommerce_cart_page_id)){
                $page_title = trim((string)$xml->woocommerce_cart_page_id);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('woocommerce_cart_page_id', 'page');
                        update_option('woocommerce_cart_page_id', $page->ID);
                    }
                }
            }
            if(isset($xml->woocommerce_checkout_page_id)){
                $page_title = trim((string)$xml->woocommerce_checkout_page_id);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('woocommerce_checkout_page_id', 'page');
                        update_option('woocommerce_checkout_page_id', $page->ID);
                    }
                }
            }
            if(isset($xml->woocommerce_pay_page_id)){
                $page_title = trim((string)$xml->woocommerce_pay_page_id);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('woocommerce_pay_page_id', 'page');
                        update_option('woocommerce_pay_page_id', $page->ID);
                    }
                }
            }
            if(isset($xml->woocommerce_thanks_page_id)){
                $page_title = trim((string)$xml->woocommerce_thanks_page_id);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('woocommerce_thanks_page_id', 'page');
                        update_option('woocommerce_thanks_page_id', $page->ID);
                    }
                }
            }
            if(isset($xml->woocommerce_myaccount_page_id)){
                $page_title = trim((string)$xml->woocommerce_myaccount_page_id);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('woocommerce_myaccount_page_id', 'page');
                        update_option('woocommerce_myaccount_page_id', $page->ID);
                    }
                }
            }
            if(isset($xml->woocommerce_edit_address_page_id)){
                $page_title = trim((string)$xml->woocommerce_edit_address_page_id);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('woocommerce_edit_address_page_id', 'page');
                        update_option('woocommerce_edit_address_page_id', $page->ID);
                    }
                }
            }
            if(isset($xml->woocommerce_edit_address_page_id)){
                $page_title = trim((string)$xml->woocommerce_edit_address_page_id);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('woocommerce_edit_address_page_id', 'page');
                        update_option('woocommerce_edit_address_page_id', $page->ID);
                    }
                }
            }
            if(isset($xml->woocommerce_view_order_page_id)){
                $page_title = trim((string)$xml->woocommerce_view_order_page_id);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('woocommerce_view_order_page_id', 'page');
                        update_option('woocommerce_view_order_page_id', $page->ID);
                    }
                }
            }
            if(isset($xml->woocommerce_terms_page_id)){
                $page_title = trim((string)$xml->woocommerce_terms_page_id);
                if($page_title){
                    $page = get_page_by_title($page_title);
                    if($page){
                        update_option('woocommerce_terms_page_id', 'page');
                        update_option('woocommerce_terms_page_id', $page->ID);
                    }
                }
            }
            /*set_theme_mod( 'nav_menu_locations', $locations );*/
            return true;
        }
    }
    /* import Sidebar Content */
    function kt_widgets_importer($folder){
        global $wp_registered_sidebars;
        if(file_exists($this->theme_dir.'settings/datas/'.$folder.'/widgets.txt')){
            // Get file contents and decode
            $data = file_get_contents( $this->theme_dir.'settings/datas/'.$folder.'/widgets.txt' );
            $data = json_decode( $data );
            // Have valid data?
            // If no data or could not decode
            if ( empty( $data ) || ! is_object( $data ) ) {
                return true;
            }
            // Hook before import
            do_action( 'wie_before_import' );
            $data = apply_filters( 'wie_import_data', $data );
            // Get all available widgets site supports
            $available_widgets = $this->kt_available_widgets();
            // Get all existing widget instances
            $widget_instances = array();
            foreach ( $available_widgets as $widget_data ) {
                $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
            }
            // Begin results
            $results = array();
            // Loop import data's sidebars
            foreach ( $data as $sidebar_id => $widgets ) {
                // Skip inactive widgets
                // (should not be in export file)
                if ( 'wp_inactive_widgets' == $sidebar_id ) {
                    continue;
                }
                // Check if sidebar is available on this site
                // Otherwise add widgets to inactive, and say so
                if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
                    $sidebar_available = true;
                    $use_sidebar_id = $sidebar_id;
                    $sidebar_message_type = 'success';
                    $sidebar_message = '';
                } else {
                    $sidebar_available = false;
                    $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
                    $sidebar_message_type = 'error';
                    $sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', 'widget-importer-exporter' );
                }
                // Result for sidebar
                $results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
                $results[$sidebar_id]['message_type'] = $sidebar_message_type;
                $results[$sidebar_id]['message'] = $sidebar_message;
                $results[$sidebar_id]['widgets'] = array();
                // Loop widgets
                foreach ( $widgets as $widget_instance_id => $widget ) {
                    $fail = false;
                    // Get id_base (remove -# from end) and instance ID number
                    $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
                    $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );
                    // Does site support this widget?
                    if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
                        $fail = true;
                        $widget_message_type = 'error';
                        $widget_message = __( 'Site does not support widget', 'widget-importer-exporter' ); // explain why widget not imported
                    }
                    // Filter to modify settings object before conversion to array and import
                    // Leave this filter here for backwards compatibility with manipulating objects (before conversion to array below)
                    // Ideally the newer wie_widget_settings_array below will be used instead of this
                    $widget = apply_filters( 'wie_widget_settings', $widget ); // object
                    // Convert multidimensional objects to multidimensional arrays
                    // Some plugins like Jetpack Widget Visibility store settings as multidimensional arrays
                    // Without this, they are imported as objects and cause fatal error on Widgets page
                    // If this creates problems for plugins that do actually intend settings in objects then may need to consider other approach: https://wordpress.org/support/topic/problem-with-array-of-arrays
                    // It is probably much more likely that arrays are used than objects, however
                    $widget = json_decode( json_encode( $widget ), true );
                    // Filter to modify settings array
                    // This is preferred over the older wie_widget_settings filter above
                    // Do before identical check because changes may make it identical to end result (such as URL replacements)
                    $widget = apply_filters( 'wie_widget_settings_array', $widget );
                    // Does widget with identical settings already exist in same sidebar?
                    if ( ! $fail && isset( $widget_instances[$id_base] ) ) {
                        // Get existing widgets in this sidebar
                        $sidebars_widgets = get_option( 'sidebars_widgets' );
                        $sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go
                        // Loop widgets with ID base
                        $single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
                        foreach ( $single_widget_instances as $check_id => $check_widget ) {
                            // Is widget in same sidebar and has identical settings?
                            if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {
                                $fail = true;
                                $widget_message_type = 'warning';
                                $widget_message = __( 'Widget already exists', 'widget-importer-exporter' ); // explain why widget not imported
                                break;
                            }
                        }
                    }
                    // No failure
                    if ( ! $fail ) {
                        // Add widget instance
                        $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
                        $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
                        $single_widget_instances[] = $widget; // add it
                        // Get the key it was given
                        end( $single_widget_instances );
                        $new_instance_id_number = key( $single_widget_instances );
                        // If key is 0, make it 1
                        // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
                        if ( '0' === strval( $new_instance_id_number ) ) {
                            $new_instance_id_number = 1;
                            $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
                            unset( $single_widget_instances[0] );
                        }
                        // Move _multiwidget to end of array for uniformity
                        if ( isset( $single_widget_instances['_multiwidget'] ) ) {
                            $multiwidget = $single_widget_instances['_multiwidget'];
                            unset( $single_widget_instances['_multiwidget'] );
                            $single_widget_instances['_multiwidget'] = $multiwidget;
                        }
                        // Update option with new widget
                        update_option( 'widget_' . $id_base, $single_widget_instances );
                        // Assign widget instance to sidebar
                        $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
                        $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
                        $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
                        update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data
                        // After widget import action
                        $after_widget_import = array(
                            'sidebar'           => $use_sidebar_id,
                            'sidebar_old'       => $sidebar_id,
                            'widget'            => $widget,
                            'widget_type'       => $id_base,
                            'widget_id'         => $new_instance_id,
                            'widget_id_old'     => $widget_instance_id,
                            'widget_id_num'     => $new_instance_id_number,
                            'widget_id_num_old' => $instance_id_number
                        );
                        do_action( 'wie_after_widget_import', $after_widget_import );
                        // Success message
                        if ( $sidebar_available ) {
                            $widget_message_type = 'success';
                            $widget_message = __( 'Imported', 'widget-importer-exporter' );
                        } else {
                            $widget_message_type = 'warning';
                            $widget_message = __( 'Imported to Inactive', 'widget-importer-exporter' );
                        }
                    }
                    // Result for widget instance
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = ! empty( $widget['title'] ) ? $widget['title'] : __( 'No Title', 'widget-importer-exporter' ); // show "No Title" if widget instance is untitled
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;
                }
            }
            // Hook after import
            do_action( 'wie_after_import' );
            // Return results
        }
        return apply_filters( 'wie_import_results', $results );
    }

    /* Import Revolution Slider */
    function kt_revslider_importer(){
        if( class_exists('UniteFunctionsRev') && class_exists('ZipArchive') ) {
            global $wpdb;
            $updateAnim = true;
            $updateStatic= true;
            $folder = isset($_POST['folder']) ? $_POST['folder'] : "";
            $rev_directory = $this->theme_dir.'settings/datas/'.$folder.'/';// dirname(__FILE__) .$folder.'revslider/';
            $rev_files = array();
            $rev_db = new RevSliderDB();
            foreach( glob( $rev_directory . '*.zip' ) as $filename ) {
                $filename = basename($filename);
                $allow_import = false;
                $arr_filename = explode('_', $filename);
                $slider_new_id = absint( $arr_filename[0] );
                if( $slider_new_id > 0 ){
                    $response = $rev_db->fetch( RevSliderGlobals::$table_sliders, 'id=' + $slider_new_id );
                    if( empty($response) ){ /* not exists */
                        $rev_files_ids[] = $slider_new_id;
                        $allow_import = true;
                    }
                    else{
                        /* do nothing */
                    }
                }
                else{
                    $rev_files_ids[] = 0;
                    $allow_import = true;
                }
                if( $allow_import ){
                    $rev_files[] = $rev_directory . $filename;
                }
            }

            foreach( $rev_files as $index => $rev_file ) {
                $filepath = $rev_file;
                $zip = new ZipArchive;
                $importZip = $zip->open($filepath, ZIPARCHIVE::CREATE);

                if( $importZip === true ){

                    $slider_export = $zip->getStream('slider_export.txt');
                    $custom_animations = $zip->getStream('custom_animations.txt');
                    $dynamic_captions = $zip->getStream('dynamic-captions.css');
                    $static_captions = $zip->getStream('static-captions.css');

                    $content = '';
                    $animations = '';
                    $dynamic = '';
                    $static = '';

                    while ( !feof($slider_export) ) $content .= fread($slider_export, 1024);
                    if($custom_animations){ while (!feof($custom_animations)) $animations .= fread($custom_animations, 1024); }
                    if($dynamic_captions){ while (!feof($dynamic_captions)) $dynamic .= fread($dynamic_captions, 1024); }
                    if($static_captions){ while (!feof($static_captions)) $static .= fread($static_captions, 1024); }

                    fclose($slider_export);
                    if($custom_animations){ fclose($custom_animations); }
                    if($dynamic_captions){ fclose($dynamic_captions); }
                    if($static_captions){ fclose($static_captions); }

                }else{
                    $content = @file_get_contents($filepath);
                }

                if($importZip === true){
                    $db = new UniteDBRev();

                    $animations = @unserialize($animations);
                    if( !empty($animations) ){
                        foreach($animations as $key => $animation){
                            $exist = $db->fetch(GlobalsRevSlider::$table_layer_anims, "handle = '".$animation['handle']."'");
                            if( !empty($exist) ){
                                if( $updateAnim == 'true' ){
                                    $arrUpdate = array();
                                    $arrUpdate['params'] = stripslashes(json_encode(str_replace("'", '"', $animation['params'])));
                                    $db->update(GlobalsRevSlider::$table_layer_anims, $arrUpdate, array('handle' => $animation['handle']));

                                    $id = $exist['0']['id'];
                                }else{
                                    $arrInsert = array();
                                    $arrInsert["handle"] = 'copy_'.$animation['handle'];
                                    $arrInsert["params"] = stripslashes(json_encode(str_replace("'", '"', $animation['params'])));

                                    $id = $db->insert(GlobalsRevSlider::$table_layer_anims, $arrInsert);
                                }
                            }else{
                                $arrInsert = array();
                                $arrInsert["handle"] = $animation['handle'];
                                $arrInsert["params"] = stripslashes(json_encode(str_replace("'", '"', $animation['params'])));

                                $id = $db->insert(GlobalsRevSlider::$table_layer_anims, $arrInsert);
                            }

                            $content = str_replace(array('customin-'.$animation['id'], 'customout-'.$animation['id']), array('customin-'.$id, 'customout-'.$id), $content);
                        }
                    }else{

                    }

                    if( !empty($static) ){
                        if( isset( $updateStatic ) && $updateStatic == 'true' ){
                            RevOperations::updateStaticCss($static);
                        }else{
                            $static_cur = RevOperations::getStaticCss();
                            $static = $static_cur."\n".$static;
                            RevOperations::updateStaticCss($static);
                        }
                    }

                    $dynamicCss = UniteCssParserRev::parseCssToArray($dynamic);

                    if(is_array($dynamicCss) && $dynamicCss !== false && count($dynamicCss) > 0){
                        foreach($dynamicCss as $class => $styles){
                            $class = trim($class);

                            if((strpos($class, ':hover') === false && strpos($class, ':') !== false) ||
                                strpos($class," ") !== false ||
                                strpos($class,".tp-caption") === false ||
                                (strpos($class,".") === false || strpos($class,"#") !== false) ||
                                strpos($class,">") !== false){
                                continue;
                            }


                            if(strpos($class, ':hover') !== false){
                                $class = trim(str_replace(':hover', '', $class));
                                $arrInsert = array();
                                $arrInsert["hover"] = json_encode($styles);
                                $arrInsert["settings"] = json_encode(array('hover' => 'true'));
                            }else{
                                $arrInsert = array();
                                $arrInsert["params"] = json_encode($styles);
                            }

                            $result = $db->fetch(GlobalsRevSlider::$table_css, "handle = '".$class."'");

                            if(!empty($result)){
                                $db->update(GlobalsRevSlider::$table_css, $arrInsert, array('handle' => $class));
                            }else{
                                $arrInsert["handle"] = $class;
                                $db->insert(GlobalsRevSlider::$table_css, $arrInsert);
                            }
                        }

                    }else{

                    }
                }

                $content = preg_replace_callback('!s:(\d+):"(.*?)";!', array('RevSliderSlider', 'clear_error_in_string') , $content); //clear errors in string

                $arrSlider = @unserialize($content);
                $sliderParams = $arrSlider["params"];

                if(isset($sliderParams["background_image"]))
                    $sliderParams["background_image"] = UniteFunctionsWPRev::getImageUrlFromPath($sliderParams["background_image"]);

                $json_params = json_encode($sliderParams);


                $arrInsert = array();
                $arrInsert["params"] = $json_params;
                $arrInsert["title"] = UniteFunctionsRev::getVal($sliderParams, "title","Slider1");
                $arrInsert["alias"] = UniteFunctionsRev::getVal($sliderParams, "alias","slider1");
                if( $rev_files_ids[$index] != 0 ){
                    $arrInsert["id"] = $rev_files_ids[$index];
                    $arrFormat = array('%s', '%s', '%s', '%d');
                }
                else{
                    $arrFormat = array('%s', '%s', '%s');
                }
                $sliderID = $wpdb->insert(GlobalsRevSlider::$table_sliders, $arrInsert, $arrFormat);
                $sliderID = $wpdb->insert_id;



                /* create all slides */
                $arrSlides = $arrSlider["slides"];

                $alreadyImported = array();

                foreach($arrSlides as $slide){

                    $params = $slide["params"];
                    $layers = $slide["layers"];

                    if(isset($params["image"])){
                        if(trim($params["image"]) !== ''){
                            if($importZip === true){
                                $image = $zip->getStream('images/'.$params["image"]);
                                if(!$image){
                                    echo $params["image"].' not found!<br>';
                                }else{
                                    if(!isset($alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]])){
                                        $importImage = UniteFunctionsWPRev::import_media('zip://'.$filepath."#".'images/'.$params["image"], $sliderParams["alias"].'/');

                                        if($importImage !== false){
                                            $alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]] = $importImage['path'];

                                            $params["image"] = $importImage['path'];
                                        }
                                    }else{
                                        $params["image"] = $alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]];
                                    }
                                }
                            }
                        }
                        $params["image"] = UniteFunctionsWPRev::getImageUrlFromPath($params["image"]);
                    }

                    foreach($layers as $key=>$layer){
                        if(isset($layer["image_url"])){
                            if(trim($layer["image_url"]) !== ''){
                                if($importZip === true){
                                    $image_url = $zip->getStream('images/'.$layer["image_url"]);
                                    if(!$image_url){
                                        echo $layer["image_url"].' not found!<br>';
                                    }else{
                                        if(!isset($alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]])){
                                            $importImage = UniteFunctionsWPRev::import_media('zip://'.$filepath."#".'images/'.$layer["image_url"], $sliderParams["alias"].'/');

                                            if($importImage !== false){
                                                $alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]] = $importImage['path'];

                                                $layer["image_url"] = $importImage['path'];
                                            }
                                        }else{
                                            $layer["image_url"] = $alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]];
                                        }
                                    }
                                }
                            }
                            $layer["image_url"] = UniteFunctionsWPRev::getImageUrlFromPath($layer["image_url"]);
                            $layers[$key] = $layer;
                        }
                    }

                    /* create new slide */
                    $arrCreate = array();
                    $arrCreate["slider_id"] = $sliderID;
                    $arrCreate["slide_order"] = $slide["slide_order"];
                    $arrCreate["layers"] = json_encode($layers);
                    $arrCreate["params"] = json_encode($params);

                    $wpdb->insert(GlobalsRevSlider::$table_slides,$arrCreate);
                }
            }
        }
        return true;
    }

    function kt_demo_importer_callback(){
        $folder = $_POST['folder'];
        $post_index = intval($_POST['post_index']);
        $post_total = intval($_POST['post_total']);
        $response = array('status'=>'prosess', 'post_total'=>$post_total, 'post_index'=>$post_index);
        //$this->kt_page_settings_importer($folder);
        if($post_total >0 && $post_index >= $post_total){
            /* Import theme option */
            $this->kt_theme_options_importer_prosess($folder);
            /* Import page  */
            $this->kt_page_settings_importer($folder);
            /* Import menu location */
            $this->kt_menu_localtion_importer($folder);
            /* Import widgets */
            $this->kt_widgets_importer($folder);
            /* Import revslider */
            //$this->kt_revslider_importer($folder);
            /*
            if(file_exists($this->plugin_dir.'classes/importer/menu_item_orphans.txt'))
                unlink($this->plugin_dir.'classes/importer/menu_item_orphans.txt');
            if(file_exists($this->plugin_dir.'classes/importer/post_orphans.txt'))
                unlink($this->plugin_dir.'classes/importer/post_orphans.txt');

            if(file_exists($this->plugin_dir.'classes/importer/processed_authors.txt'))
                unlink($this->plugin_dir.'classes/importer/processed_authors.txt');

            if(file_exists($this->plugin_dir.'classes/importer/processed_menu_items.txt'))
                unlink($this->plugin_dir.'classes/importer/processed_menu_items.txt');

            if(file_exists($this->plugin_dir.'classes/importer/processed_posts.txt'))
                unlink($this->plugin_dir.'classes/importer/processed_posts.txt');

            if(file_exists($this->plugin_dir.'classes/importer/processed_terms.txt'))
                unlink($this->plugin_dir.'classes/importer/processed_terms.txt');

            if(file_exists($this->plugin_dir.'classes/importer/data_post_ids.txt'))
                unlink($this->plugin_dir.'classes/importer/data_post_ids.txt');*/

            $response = array('status'=>'ok', 'post_total'=>$post_total);
        }else{
            /* Import content */
            $response['post_total'] = $this->kt_contents_importer($folder, $post_index);
        }
        wp_send_json($response);
        wp_die();
    }
    /* Dont Resize image while importing */
    function no_resize_image( $sizes ){
        return array();
    }
    function kt_contents_importer($folder, $post_index=0){
        if ( !defined('WP_LOAD_IMPORTERS') ){
            define('WP_LOAD_IMPORTERS', true);
        }
        if( file_exists($this->theme_dir.'settings/datas/contents.xml') ){
            $this->path( 'CORE_DIR', '/importer/kt-wordpress-importer.php', true);
            $importer = new KT_WP_Import();
            $importer->fetch_attachments = true;
            ob_start();
            //add_filter('intermediate_image_sizes_advanced', array($this, 'no_resize_image'));
            //add_filter( 'http_request_timeout', array( &$this, 'bump_request_timeout' ) );
            $post_total = $importer->import($this->theme_dir.'settings/datas/', $post_index);
            ob_end_clean();
            return $post_total;
            /*echo 'Successful Import Demo Content';
            wp_die();*/
        }
    }
    /*function kt_available_widgets() {
        global $wp_registered_widget_controls;
        $widget_controls = $wp_registered_widget_controls;
        $available_widgets = array();
        foreach ( $widget_controls as $widget ) {
            if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes
                $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
                $available_widgets[$widget['id_base']]['name'] = $widget['name'];
            }
        }
        return apply_filters( 'wie_available_widgets', $available_widgets );
    }*/

    function import_config(){
        $this->woocommerce_settings();
        $this->menu_locations();
        $this->update_options();
    }

    /* WooCommerce Settings */
    function woocommerce_settings(){
        $woopages = array(
            'woocommerce_shop_page_id' 			=> 'Shop'
        ,'woocommerce_cart_page_id' 		=> 'Shopping cart'
        ,'woocommerce_checkout_page_id' 	=> 'Checkout'
        ,'woocommerce_myaccount_page_id' 	=> 'My Account'
        );
        foreach( $woopages as $woo_page_name => $woo_page_title ) {
            $woopage = get_page_by_title( $woo_page_title );
            if( isset( $woopage->ID ) && $woopage->ID ) {
                update_option($woo_page_name, $woopage->ID);
            }
        }

        if( class_exists('YITH_Woocompare') ){
            update_option('yith_woocompare_compare_button_in_products_list', 'yes');
        }

        if( class_exists('WC_Admin_Notices') ){
            WC_Admin_Notices::remove_notice('install');
        }
        delete_transient( '_wc_activation_redirect' );

        flush_rewrite_rules();
    }
    /* Menu Locations */
    function menu_locations(){
        $locations = get_theme_mod( 'nav_menu_locations' );
        $menus = wp_get_nav_menus();
        if( $menus ) {
            foreach($menus as $menu) {
                if( $menu->name == 'Main menu' ) {
                    $locations['primary'] = $menu->term_id;
                }
                if( $menu->name == 'Vertical Menu' ) {
                    $locations['vertical'] = $menu->term_id;
                }
                if( $menu->name == 'Control Menu' ) {
                    $locations['control-menu'] = $menu->term_id;
                }
                if( $menu->name == 'Services Menu' ) {
                    $locations['services-menu'] = $menu->term_id;
                }
            }
        }
        set_theme_mod( 'nav_menu_locations', $locations );
    }

    /* Update Options */
    function update_options(){
        update_option('show_on_front', 'page');
        // Home page
        $homepage = get_page_by_title( 'Home' );
        if( isset( $homepage ) && $homepage->ID ){
            /*update_option('show_on_front', 'page');*/
            update_option('page_on_front', $homepage->ID);
        }
        // Blog page
        $post_page = get_page_by_title( 'Blog' );
        if( isset( $post_page ) && $post_page->ID ){
            update_option('page_for_posts', $post_page->ID);
        }
    }


    function register_scripts(){
        global $wp_scripts, $pagenow;
        $jquery_version = isset( $wp_scripts->registered['jquery-ui-core']->ver ) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';
        wp_enqueue_style( 'yit-jquery-ui-style', '//code.jquery.com/ui/' . $jquery_version . '/themes/smoothness/jquery-ui.css', array(), $jquery_version );
        wp_enqueue_style( 'kt-import-style', plugins_url( '/assets/css/style.css', __FILE__ ) );
        wp_enqueue_style( 'kt-import-circle', plugins_url( '/assets/css/circle.css', __FILE__ ) );
        wp_enqueue_script( 'kt-import-script', plugins_url( '/assets/js/script.js', __FILE__ ), array( 'jquery' ), false, true );
        wp_enqueue_script( 'kt-ajax-upload', plugins_url( '/assets/js/ajaxupload.3.5.js', __FILE__ ), array( 'jquery' ), false, false );
        wp_enqueue_script( 'kt-widget-banner', plugins_url( '/assets/js/kt_banner.js', __FILE__ ), array( 'jquery' ), false, true );

    }
    function kutetheme_ovic_fontend_register_scripts(){
        wp_enqueue_script( 'kt-mailchimp', plugins_url( '/classes/MCAPI/js/mailchimp.min.js', __FILE__ ) , array( 'jquery' ), false, false);
        wp_localize_script( 'kutetheme_ovic_script', 'kt_ajax_fontend', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'security' => wp_create_nonce( 'kt_ajax_fontend' ),
        ) );
    }
    public static function set_image_size() {
        $size = get_option( 'yith_woocompare_image_size' );

        if( ! $size ) {
            return;
        }

        $size['crop'] = isset( $size['crop'] ) ? true : false;
        add_image_size( 'yith-woocompare-image', $size['width'], $size['height'], $size['crop'] );
    }
    public function kt_product_attributes_type_selector($types){
        $kt_types   =   array(
            'color' => __( 'Color style', 'kute-toolkit'),
        );
        return array_merge($types, $kt_types);
    }
    /*public function is_compatible_theme(){
        if( wp_get_theme()->get('Name') == 'Kutetheme ALESIA' ){
            return true;
        }
    }*/
    /**
     * Get the instane of KUTE_TOOLKIT
     * @since 1.0
     * @return self
     */
    public static function getInstance() {
        if ( ! ( self::$_instance instanceof self ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /*function register_menu_page(){
        add_menu_page( 'KUTETHEME', 'KUTETHEME', 'manage_options', 'kt_capnel_page', array( &$this, 'wellcome' ), $this->getPluginUri() .'assets/images/menu-icon.png', 1 );
        add_submenu_page( 'kt_capnel_page','Install Demo', 'Install Demo', 'manage_options', 'kt_importer', array( $this, 'importer_page_content' ) );
    }*/
    public function themeOptionPage(){
        add_menu_page( 'Kutethemes', 'Kutethemes', 'manage_options', 'kt_capnel_page', array( &$this, 'wellcome' ), $this->getPluginUri() .'assets/images/menu-icon.png', 1 );
        /*add_submenu_page( 'kt_capnel_page','Install Demo', 'Install Demo', 'manage_options', 'kt_importer', array( $this, 'importer_page_content' ) );*/
    }
    public function wellcome(){
        $uniqid = uniqid();
        $file = get_template_directory().'/changelog.txt'; ?>

        <?php /*add_action('kkk_test', function ($val){echo "<a href='#'>".$val."</a>";})*/ /*add_thickbox(); */?>
        <div class="kt-importer-wrapper">    

        <h1><?php _e('Wellcome to ','kute-toolkit'); echo wp_get_theme()->get('Name'); ?> <?php /*do_action( 'kkk_test', 'kkkkkk' );*/ ?></h1>
        <div>
            <a class="kt-demo-exporter" href="javascript:void(0)"><?php esc_html_e('Export data demo', 'kute-toolkit'); ?></a><?php esc_html_e('&nbsp;&nbsp;|&nbsp;&nbsp;')  ?>
            <a href="javascript:void(0)" class="kt-theme-options-export" data-uniqid = "<?php echo esc_attr($uniqid); ?>"><?php esc_html_e('Export theme options', 'kute-toolkit') ?></a><?php esc_html_e('&nbsp;&nbsp;|&nbsp;&nbsp;')  ?>
            <a href="javascript:void(0)" class="kt-theme-options-importer" data-uniqid = "<?php echo esc_attr($uniqid); ?>"><?php esc_html_e('Import theme options ', 'kute-toolkit') ?></a>
        </div>
        <!--<div>
            <a class="kt-demo-importer" href="javascript:void(0)">demo import</a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <a class="kt-demo-exporter" href="javascript:void(0)">demo export</a>
        </div>-->
        <div  id="kt-dialog-export-theme-options" class="kt-dialog">
            <div class="kt-dialog-content">
                <div class="form-group">
                    <label class="control-label"><?php esc_html_e('Save with name', 'kute-toolkit'); ?></label>
                    <input  id="export_file_name" type="text" class="form-control" value="" />
                </div>
                <div class="form-group">
                    <label class="control-label">
                        <input id="export_file_overwrite" type="checkbox" class="" value="1" />
                        <?php esc_html_e('Overwritten if file name is the same', 'kute-toolkit'); ?>
                    </label>
                </div>

            </div>
        </div>
        <div  id="kt-dialog-export-data" class="kt-dialog">
            <div class="kt-dialog-content">
                <div class="form-group">
                    <label class="control-label"><?php esc_html_e('Folder name', 'kute-toolkit'); ?></label>
                    <input  id="export_data_folder" type="text" class="form-control" value="" />
                </div>
            </div>
        </div>
        <div  id="kt-dialog-import-theme-options" class="kt-dialog">
            <div class="kt-dialog-content">
                <table id="kt-dialog-import-theme-options-table" class="kt-table">
                    <thead>
                        <tr>
                            <th class="text-left"><?php esc_html_e('Data file name', 'kute-toolkit') ?></th>
                            <th class="text-center" width="80"><?php esc_html_e('Import', 'kute-toolkit') ?></th>
                            <th class="text-center" width="80"><?php esc_html_e('View', 'kute-toolkit') ?></th>
                            <th class="text-center" width="80"><?php esc_html_e('Delete', 'kute-toolkit') ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right">
                                <button id="kt_theme_options_uploader" type="button" class="kt-btn"><?php esc_html_e("Add new file", 'kute-toolkit')  ?></button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        </div> 
        <?php $this->importer_page_content(); ?>
        <?php if( file_exists( $file ) ){ ?>
            <h3><?php _e('Change Log','kute-toolkit');?></h3>
            <div style="height: 200px; overflow: auto;">
                <?php
                $myfile = fopen($file, "r") or die( "Unable to open file!" );
                while(!feof($myfile)) {
                    echo fgets($myfile) . "<br>";
                }
                fclose($myfile);
                ?>
            </div>
            <?php
        }
    }
    function importer_page_content(){
        if ( file_exists($this->theme_dir . 'settings/datas/options.php')){
            $this->data_demos = include( $this->theme_dir . 'settings/datas/options.php' );
        }
        ?>
        <div class="kt-importer-wrapper">
            <h1 class="heading"><?php echo wp_get_theme()->get('Name');  _e('- Options','kute-toolkit');  ?> </h1>
            <div class="note">
                <h3>Please read before importing:</h3>
                <p>This importer will help you build your site look like our demo. Importing data is recommended on fresh install.</p>
                <p>Please ensure you have already installed and activated Kute Toolkit, WooCommerce, Visual Composer and Revolution Slider plugins.</p>
                <p>Please note that importing data only builds a frame for your website. <strong>It will not import all demo contents and images.</strong></p>
                <p>It can take a few minutes to complete. <strong>Please don't close your browser while importing.</strong></p>
                
            </div>
            <h3>Select the options below which you want to import:</h3>
            <?php if( $this->data_demos ) :?>
                <div class="options">
                    <?php $i=0; foreach( $this->data_demos as $data):  $i++;?>
                        <div id="option-<?php echo $i;?>" class="option">
                            <div class="inner">
                                <div class="progress-wapper">
                                    <div class="progress-circle">
                                        <div class="c100 p0 dark green">
                                            <span class="percent">0%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview">
                                    <img src="<?php echo $data['preview'] ? $data['preview'] : $this->theme_uri.'settings/datas/'.$data['folder'].'/preview.jpg';?>">
                                </div>
                                <div class="kt-control">
                                    <div class="control-inner">
                                        <h3 class="demo-name"><?php echo $data['name'];?></h3>
                                        <a target="_blank" class="more" href="<?php echo $data['demo_link'];?>">View demo</a>
                                        <button data-folder="<?php echo $data['folder'];?>" data-optionid="<?php echo $i;?>" class="button button-primary kt-demo-importer">Install</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php else: ?>
                <div>No options!</div>
            <?php endif;?>
        </div>
        <?php
    }

    /**
     * Config global variable for less file
     * @since 1.0
     * @author Kutethemes
     * @return @array
     *
     */
    public function lessVars( $vars, $handle ) {
        $main_color = $this->getOption( 'kt_main_color', '#c99947' );
        $vars[ 'color' ] = $main_color;
        return $vars;
    }
    /**
     * Get option setting in backend
     * @since 1.0
     * @author Kutethemes
     * @return string
     */
    public function getOption( $option = false, $default = false ){
        return kutetheme_ovic_option( $option, $default );
    }
    /**
     * Check Active Plugin
     * @since 1.0
     * @author Kutethemes
     * @return bool
     */
    public function checkActivePlugin( $key ){
        $active_plugins = (array) $this->getOption( 'active_plugins', array() );
        if ( is_multisite() ){
            $active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
        }
        return in_array( $key, $active_plugins ) || array_key_exists( $key, $active_plugins );
    }
    /**
     * Get option fonts
     * @since 1.0
     * @author Kutethemes
     * @return array
     */
    public function getFonts(){
        $fonts = array();
        $fonts['content'] 		= $this->getOption( 'font_content', 	   'Roboto' );
        $fonts['menu'] 			= $this->getOption( 'font_menu', 		   'Roboto' );
        $fonts['title'] 		= $this->getOption( 'font_title', 		   'Roboto' );
        $fonts['headings'] 		= $this->getOption( 'font_headings', 	   'Roboto' );
        $fonts['headingsSmall'] = $this->getOption( 'font_headings_small', 'Roboto' );
        $fonts['blockquote'] 	= $this->getOption( 'font_blockquote', 	   'Roboto' );
        $fonts['decorative'] 	= $this->getOption( 'font_decorative', 	   'Roboto' );
        return $fonts;
    }
    /**
     * Add google fonts
     * @return void
     * @author Kutethemes
     * @since 1.0
     */
    public function getGoogleFonts(){
        // Google Fonts --------------------
        $google_fonts 	= kutetheme_ovic_fonts( 'all' );
        // subset
        $subset 		= $this->getOption('font_subset');
        if( $subset ) $subset = '&amp;subset='. str_replace(' ', '', $subset);
        // style & weight
        if( $weight = $this->getOption('font_weight') ){
            $weight = ':'. implode( ',', $weight );
        }
        $fonts = $this->getFonts();
        foreach( $fonts as $font ){
            if( in_array( $font, $google_fonts ) ){
                // Google Fonts
                $font_slug = str_replace(' ', '+', $font);
                wp_enqueue_style( $font_slug, 'http'. kutetheme_ovic_ssl() .'://fonts.googleapis.com/css?family='. $font_slug . $weight . $subset );
            }
        }
    }
    /**
     * Check if the device is mobile.
     * Returns true if any type of mobile device detected, including special ones
     * @since 1.0
     * @return bool
     */
    public function isMobile() {
        if( ! isset( $this->mobile_detect ) || ! $this->mobile_detect ){
            $this->mobile_detect = new Mobile_Detect;
        }
        $this->is_mobile = $this->mobile_detect->isMobile();
        return $this->is_mobile;
    }
    /**
     * Check if the device is Tablet.
     * Returns true if any type of mobile device detected, including special ones
     * @since 1.0
     * @return bool
     */
    public function isTablet() {
        if( ! isset( $this->mobile_detect ) || ! $this->mobile_detect ){
            $this->mobile_detect = new Mobile_Detect;
        }
        $this->is_tablet = $this->mobile_detect->isTablet();
        return $this->is_tablet;
    }
    /**
     * Check version Visual Composer
     * @param $verson
     * @return bool
     */
    public function gtVC( $verson ){
        if( version_compare( $verson , WPB_VC_VERSION ) <= 0 ){
            return true;
        }
        return false;
    }
    /**
     * Get the URL directory path (with trailing slash) for the plugin.
     *
     * @since 1.0
     * @access public
     * @author Kutethemes
     *
     * @return string the URL path of the directory that contains the plugin.
     */
    public function getPluginDir(){
        return $this->plugin_dir;
    }
    /**
     * Get the URL directory path (with trailing slash) for the plugin.
     *
     * @since 1.0
     * @access public
     * @author Kutethemes
     *
     * @return string the URL path of the directory that contains the plugin.
     */
    public function getPluginUri(){
        return $this->plugin_uri;
    }
    /**
     * Get the URL directory path (with trailing slash) for the theme.
     *
     * @since 1.0
     * @access public
     * @author Kutethemes
     *
     * @return string the URL path of the directory that contains the theme.
     */
    public function getThemeUri(){
        return $this->theme_uri;
    }
    /**
     * define all the paths
     *
     * @since  1.0
     * @access public
     * @author Kutethemes
     *
     * @param $paths
     */
    public function setPaths( $paths ) {
        $this->paths = $paths;
    }
    /**
     * get the paths
     *
     * @since  1.0
     * @access public
     * @author Kutethemes
     *
     * @param $paths
     */
    public function getPaths( ) {
        return $this->paths;
    }
    /**
     * Gets absolute path for file/directory in filesystem.
     *
     * @since  1.0
     * @access public
     * @author Kutethemes
     *
     * @param $name - name of path dir
     * @param string $file - file name or directory inside path
     * @param check require file default false
     *
     * @return string
     */
    public function path( $name, $file = '', $require = false ) {
        $path = trailingslashit( $this->paths[ $name ] ) . ( strlen( $file ) > 0 ? '/' . preg_replace( '/^\//', '', $file ) : '' );
        $path = apply_filters( 'kutetheme_ovic_path_filter', $path );
        if( $require ){
            require_once $path;
        }
        return $path;
    }
    /**
     * Callback function WP plugin_loaded action hook. Loads locale
     *
     * @since  1.0
     * @access public
     */

    public function pluginsLoaded() {
        // Setup locale
        do_action('kutetheme_ovic_plugins_loaded' );
        load_plugin_textdomain( 'kute-toolkit', false, $this->plugin_dir . 'languages' );
        if( class_exists( 'Vc_Manager' ) ){
            $this->path( 'SHORTCODES_DIR', '/shortcodes.php', true);
            if(file_exists($this->theme_dir.'/settings/templates.php')){
                $this->path( 'THEME', '/settings/templates.php', true);
            }else{
                $this->path( 'SHORTCODES_DIR', '/templates.php', true);
            }
            //$this->path( 'SHORTCODES_DIR', '/templates.php', true);
            $shortcodes = new KUTETHEME_ShortCode();
            $this->shortcodes = $shortcodes;
            add_action( 'admin_init', array( &$this, 'enqueueAssetsBackendVc' ) );
            add_action( 'vc_after_mapping', array(
                $shortcodes,
                'loadShortcode',
            ) );
        }
        remove_action( 'admin_notices', 'woothemes_updater_notice' );
    }
    public function taxonomy_register(){
        $settings = include( $this->theme_dir . 'settings/custom_taxonomy.php' );
        if(!$settings || !is_array($settings)) return true;
        foreach ($settings as $key  =>  $setting){
            if($key && is_array($setting)){
                if(isset($setting['object_type']) && isset($setting['args']))
                    register_taxonomy( $key, $setting['object_type'], $setting['args'] );
            }
        }
        return true;

    }
    public function post_type_register(){
        $settings = include( $this->theme_dir . 'settings/post_type.php' );
        if(!$settings || !is_array($settings)) return true;
        foreach ($settings as $key  =>  $setting){
            if($key && is_array($setting)){
                if(isset($setting['args']))
                    register_post_type( $key, $setting['args'] );
            }
        }
        return true;
    }
    public function metabox_register(){
        $settings = include( $this->theme_dir . 'settings/metaboxs.php' );
        if(!$settings || !is_array($settings)) return true;
        foreach ($settings as $key  =>  $setting){
            if($key && is_array($setting)){
                if(isset($setting['args']) && isset($setting['fields'])){
                    $meta_box = new_cmb2_box($setting['args']);
                    foreach ($setting['fields'] as $field){
                        $meta_box->add_field($field);
                    }
                }
            }
        }
        return true;
    }
    public function enqueueAssetsBackendVc(){
        wp_enqueue_style( 'kt_style_css', $this->path( 'PLUGIN_URI', 'js_composer/assets/css/style.css' ) );
        wp_enqueue_script( 'kt_script_js', $this->path( 'PLUGIN_URI', 'js_composer/assets/js/function.js' ) );
    }
    /**
     * Callback function for WP init action hook. Sets ALESIA mode and loads required objects.
     *
     * @since  1.0
     * @access public
     *
     * @return void
     */
    public function init() {
        do_action( 'kutetheme_ovic_before_init' );
        //$ex_fonts = '[{"font_family":"Karla","font_types":"400,400italic,700,700italic"}]';
        /*if(file_exists($this->theme_dir.'settings/google_fonts.php')){
            $ex_fonts = require $this->theme_dir.'settings/google_fonts.php';
            add_filters('vc_google_fonts_get_fonts_filter', json_decode($ex_fonts));
        }*/
        // add_filters('vc_google_fonts_get_fonts_filter', json_decode($ex_fonts));
        if( class_exists( 'Vc_Manager' ) ){
            add_action( 'save_post', array( &$this, 'save' ) , 10, 3 );
            $this->path( 'CORE_DIR',     '/TemplateManager/tm.php', true);
            $tm = new TemplateManager();
            $this->tm = $tm->init();
        }
        if( function_exists( 'kutetheme_ovic_option') ){
            if( 'yes' == kutetheme_ovic_option('kt_enable_cdn') && ! class_exists('KT_CDN') ){
                $this->path( 'CORE_DIR',     '/CDN/cdn.php', true);
                $cdn = new KT_CDN();
                $cdn->ini();
            }
        }
        
        if( is_admin() ){

            $prefix = 'kt_cat_';
            $taxMetaConfig = array(
                'id' => 'kt_meta_box',          // meta box id, unique per meta box
                'title' => 'Kute Meta Box',          // meta box title
                'pages' => array('product_cat'),        // taxonomy name, accept categories, post_tag and custom taxonomies
                'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
                'fields' => array(),            // list of meta fields (can be added by field arrays)
                'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
                'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
            );
            $taxMeta =  new Tax_Meta_Class($taxMetaConfig);
            if(class_exists('RevSlider')){
                $slider = new RevSlider();
                $arrOutput = array();
                $arrSlides = $slider->getArrSlidersWithSlidesShort();
                if($arrSlides){
                    foreach ($arrSlides as $key => $value){
                        if($value){
                            $arr = explode(',', $value);
                            if($arr){
                                $arrOutput[trim($arr[0])] = $value;
                            }
                        }
                    }
                    if($arrOutput){
                        $taxMeta->addSelect($prefix.'type',array('none'=>__('None', 'kute-toolkit'), 'banner'=>__('Banner', 'kute-toolkit'),'revslider'=>__('Revolution slider', 'kute-toolkit')),array('name'=> __('Category slider view ','kute-toolkit'), 'std'=> array('none')));
                        $taxMeta->addSelect($prefix.'category_revslider',$arrOutput,array('name'=> __('Category slider view ','kute-toolkit'), 'std'=> array('none')));
                    }else{
                        $taxMeta->addSelect($prefix.'type',array('none'=>__('None', 'kute-toolkit'), 'banner'=>__('Banner', 'kute-toolkit')),array('name'=> __('Category slider view ','kute-toolkit'), 'std'=> array('none')));
                    }
                }else{
                    $taxMeta->addSelect($prefix.'type',array('none'=>__('None', 'kute-toolkit'), 'banner'=>__('Banner', 'kute-toolkit')),array('name'=> __('Category slider view ','kute-toolkit'), 'std'=> array('none')));
                }
            }else{
                $taxMeta->addSelect($prefix.'category_slide',array('none'=>__('None', 'kute-toolkit'), 'banner'=>__('Banner', 'kute-toolkit')),array('name'=> __('Category slider view ','kute-toolkit'), 'std'=> array('none')));
            }
            $taxMeta->addImage($prefix.'category_banner', array('name'=> __('Category slider', 'kute-toolkit' ), 'multiple'=>'multiFile'));
            $taxMeta->addWysiwyg($prefix.'custom_content', array('name'=> __('Custom content', 'kute-toolkit' ), 'style' =>'width: 300px; height: 260px'));
            $taxMeta->Finish();
        }
        do_action( 'kutetheme_ovic_after_init', array($this, 'kutetheme_ovic_after_init'));
        //add_action( 'admin_footer', array(&$this, 'kt_js_functions'));
    }

    function get_all_cmb_configs($haystack, &$output){
        foreach($haystack as $key => $values){
            if($key == 'fields'){
                if(is_array($values)){
                    foreach ($values as $value){
                        if(isset($value['name']) && isset($value['type']) && isset($value['id'])){
                            if(isset($value['default']))
                                $output[$value['id']] = array('key'=>$value['id'], 'value'=>$value['default']);
                            else
                                $output[$value['id']] = array('key'=>$value['id'], 'value'=>'');
                        }
                    }
                }

            }elseif(is_array($values)){
                $this->get_all_cmb_configs($values, $output);
            }
        }
        //return $output;
    }
    function kt_add_cdata(&$item, $text){
        $doc = dom_import_simplexml($item);
        $note = $doc->ownerDocument;
        $doc->appendChild($note->createCDATASection(str_replace('\\', '', $text)));
        return true;
    }
    function kt_theme_options_exporter_callback() {
        $file_name = sanitize_key($_POST['file_name']);
        $this->kt_theme_options_exporter_prosess($file_name);
    }
    function kt_theme_options_exporter_prosess($file_name = '', $ajax = true){
        if( ! class_exists( 'CMB2_Option' ) ){
            $this->path( 'CORE_DIR', '/CMB/includes/CMB2_Options.php', true);
        }
        $cmb2_option = new CMB2_Option($this->theme_option);
        //$cmb2_option->update('kt_main_color', '#999999', true, true);
        //$custom_sidebars = $cmb2_option->get('kt_custom_sidebars');
        $current_configs = $cmb2_option->get_options();
        $response = array('status'=>1, 'msg'=>__('Export theme options success', 'kute-toolkit'));
        if(is_dir($this->theme_dir . 'settings/')){
            $config_file = $this->theme_dir . 'settings/theme_option.php';
            if ( file_exists($this->theme_dir . 'settings/theme_option.php')){
                $file_configs = include( $this->theme_dir . 'settings/theme_option.php' );
                $theme_configs = array();
                $this->get_all_cmb_configs($file_configs, $theme_configs);
                if($theme_configs){
                    if(!file_exists($this->theme_dir.'settings/theme_options/')){
                        mkdir($this->theme_dir.'settings/theme_options/', 0777, true);
                    }

                    $cmb2_option_new = new CMB2_Option($file_name);
                    $cmb2_option_new->set($current_configs);

                    $theme_option = fopen($this->theme_dir.'settings/theme_options/'.$file_name.'.txt', "w") or die("Unable to open file!");
                    $current_configs = json_encode($current_configs);
                    $current_configs = base64_encode($current_configs);
                    fwrite($theme_option, $current_configs);
                    fclose($theme_option);

                }else{
                    $response['status'] = 0;
                    $response['msg'] = __('Error: theme options empty.', 'kute-toolkit');
                }
            }else{
                $response['status'] = 0;
                $response['msg'] = __('Error: file theme_option.php not found.', 'kute-toolkit');
            }
        }else{
            $response['status'] = 0;
            $response['msg'] = __('Error: file theme_option.php not found.', 'kute-toolkit');
        }
        if($ajax == true){
            wp_send_json($response);
            wp_die();
        }else{
            return true;
        }

    }
    function kt_load_theme_options_backup_callback(){
        $response = '';
        if(is_dir($this->theme_dir . 'settings/theme_options/')){
            $files = scandir($this->theme_dir . 'settings/theme_options/');
            if($files && is_array($files)){
                foreach ($files as $i=>$file){
                    if ($file != '.' && $file != '..' && $file != 'index.php'){
                        $fileInfo = pathinfo($file);
                        if($fileInfo['extension'] == 'txt'){
                            $uniqid = uniqid($i);
                            $response .= '<tr id="'.$uniqid.'">
                                                <td class="file-name">'.$file.'</td>
                                                <td><a class="kt-theme-options-imported" data-file="'.$file.'" href="javascript:void(0)">'.__('Install', 'kute-toolkit').'</a></td>
                                                <td><a target="_blank" href="'.$this->theme_uri.'settings/theme_options/'.$file.'" >'.__('View', 'kute-toolkit').'</a></td>
                                                <td><a data-uniqid="'.$uniqid.'" class="kt-theme-options-backup-delete" data-file="'.$file.'" href="javascript:void(0)">'.__('Delete', 'kute-toolkit').'</a></td>
                                           </tr>';
                        }
                    }
                }
            }
        }else{
            $response = '<tr><td colspan="4">'.__('Not files.', 'kute-toolkit').'</td></tr>';
        }
        echo $response;
        wp_die();
    }
    function kt_theme_options_importer_callback(){
        $file = $_POST['file'];
        if($file){
            if(!$this->kt_theme_options_importer_prosess($this->theme_dir . 'settings/theme_options/'.$file)){
                echo __('Error: file not found.', 'kute-toolkit');
            }else{
                echo __('Import data success.', 'kute-toolkit');
            }
        }else{
            echo __('Error: file not found.', 'kute-toolkit');
        }
        wp_die();
    }
    function kt_theme_options_importer_prosess($file=''){
        if( ! class_exists( 'CMB2_Option' ) ){
            $this->path( 'CORE_DIR', '/CMB/includes/CMB2_Options.php', true);
        }
        if(file_exists($file)){
            $theme_option = file_get_contents($file);
            $theme_option = base64_decode($theme_option);
            $theme_option = json_decode($theme_option, true);

            $cmb2_option = new CMB2_Option($this->theme_option);
            $cmb2_option->set($theme_option);
            return true;
        }else{
            return false;
        }
    }
    function kt_theme_options_backup_delete_callback(){
        $response = '';
        $file = $_POST['file'];
        if(file_exists($this->theme_dir . 'settings/theme_options/'.$file)){
            unlink($this->theme_dir . 'settings/theme_options/'.$file);
            $response = __('Delete success.', 'kute-toolkit');
        }else{
            $response = __('Error: file not found.', 'kute-toolkit');
        }
        echo $response;
        wp_die();
    }
    function kt_theme_options_uploader_callback(){
        $fileName = $_FILES["uploader"]["name"];
        $pathFile = $this->theme_dir.'settings/theme_options/'.$fileName;
        if(file_exists($this->theme_dir.'settings/theme_options/'.$fileName))
            $fileName = time().'-'.$fileName;


        if (@move_uploaded_file($_FILES['uploader']['tmp_name'], $this->theme_dir.'settings/theme_options/'.$fileName)) {
            $response = array('status'=>1, 'msg'=>__('Upload file success', 'kute-toolkit'));
        }else {
            $response = array('status'=>0, 'msg'=>__('Error: Upload file not success', 'kute-toolkit'));
        }
        wp_send_json($response);
        wp_die();
    }
    function kt_generate_export_data() {
        // Get all available widgets site supports
        $available_widgets = $this->kt_available_widgets();
        // Get all widget instances for each widget
        $widget_instances = array();
        foreach ( $available_widgets as $widget_data ) {
            // Get all instances for this ID base
            $instances = get_option( 'widget_' . $widget_data['id_base'] );
            // Have instances
            if ( ! empty( $instances ) ) {
                // Loop instances
                foreach ( $instances as $instance_id => $instance_data ) {
                    // Key is ID (not _multiwidget)
                    if ( is_numeric( $instance_id ) ) {
                        $unique_instance_id = $widget_data['id_base'] . '-' . $instance_id;
                        $widget_instances[$unique_instance_id] = $instance_data;
                    }
                }
            }
        }
        // Gather sidebars with their widget instances
        $sidebars_widgets = get_option( 'sidebars_widgets' ); // get sidebars and their unique widgets IDs
        $sidebars_widget_instances = array();
        foreach ( $sidebars_widgets as $sidebar_id => $widget_ids ) {
            // Skip inactive widgets
            if ( 'wp_inactive_widgets' == $sidebar_id ) {
                continue;
            }
            // Skip if no data or not an array (array_version)
            if ( ! is_array( $widget_ids ) || empty( $widget_ids ) ) {
                continue;
            }
            // Loop widget IDs for this sidebar
            foreach ( $widget_ids as $widget_id ) {
                // Is there an instance for this widget ID?
                if ( isset( $widget_instances[$widget_id] ) ) {
                    // Add to array
                    $sidebars_widget_instances[$sidebar_id][$widget_id] = $widget_instances[$widget_id];
                }
            }
        }
        // Filter pre-encoded data
        $data = apply_filters( 'kt_unencoded_export_data', $sidebars_widget_instances );
        // Encode the data for file contents
        $encoded_data = json_encode( $data );
        // Return contents
        return apply_filters( 'kt_generate_export_data', $encoded_data );
    }
    function kt_available_widgets() {
        global $wp_registered_widget_controls;
        $widget_controls = $wp_registered_widget_controls;
        $available_widgets = array();
        foreach ( $widget_controls as $widget ) {
            if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes
                $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
                $available_widgets[$widget['id_base']]['name'] = $widget['name'];
            }
        }
        return apply_filters( 'kt_available_widgets', $available_widgets );
    }
    function kt_demo_exporter_callback() {
        $folder = $_POST['folder'];
        if(!file_exists($this->theme_dir.'settings/datas/'.$folder.'/'))
            mkdir($this->theme_dir.'settings/datas/'.$folder.'/', 0777, true);
        // $page = get_page(get_option('page_on_front'));
        // $all_options = wp_load_alloptions();
        // kt_print($page);
        
        /* export theme options */
        $this->kt_theme_options_exporter_prosess($folder, false);
        
        /* export contents */
        /* export revslider */

        /* export widgets */
        $widget_contents = $this->kt_generate_export_data();
        $widget_files = fopen($this->theme_dir.'settings/datas/'.$folder.'/widgets.txt', "w") or die("Unable to open file!");
        fwrite($widget_files, $widget_contents);
        fclose($widget_files);
        
        /* export menu location */
        $locations = get_nav_menu_locations();
        $nav_menus = get_registered_nav_menus();
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><!-- Copyright Themekute --><locations></locations>');
        foreach($locations as $key  =>  $value){
            //$menus = wp_get_nav_menus();
            $xml_location = $xml->addChild('location');
            $xml_location->addChild('key', $key);
            $xml_location->addChild('name', $nav_menus[$key]);
            $xml_location->addChild('value', $value);
            $xml_menu = $xml_location->addChild('menu');
            $location_menu = get_term($value, 'nav_menu');
            if($location_menu){
                $xml_menu->addChild('term_id', $location_menu->term_id);
                $xml_menu->addChild('name', $location_menu->name);
                $xml_menu->addChild('slug', $location_menu->slug);
                $xml_menu->addChild('term_group', $location_menu->term_group);
                $xml_menu->addChild('term_taxonomy_id', $location_menu->term_taxonomy_id);
                $xml_menu->addChild('taxonomy', $location_menu->taxonomy);
                $xml_menu->addChild('description', $location_menu->description);
                $xml_menu->addChild('parent', $location_menu->parent);
                $xml_menu->addChild('count', $location_menu->count);
                $xml_menu->addChild('filter', $location_menu->filter);
            }else{
                $xml_menu->addChild('term_id', 0);
                $xml_menu->addChild('name', '');
                $xml_menu->addChild('slug', '');
                $xml_menu->addChild('term_group', 0);
                $xml_menu->addChild('term_taxonomy_id', 0);
                $xml_menu->addChild('taxonomy', '');
                $xml_menu->addChild('description', '');
                $xml_menu->addChild('parent', 0);
                $xml_menu->addChild('count', 0);
                $xml_menu->addChild('filter', '');
            }
        }
        $xml->asXML($this->theme_dir.'settings/datas/'.$folder.'/locations.xml');
        /* export options */
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><!-- Copyright Themekute --><options></options>');
        /* page_on_front */
        $page = get_page(get_option('page_on_front'));
        $child = $xml->addChild('page_on_front');
        $this->kt_add_cdata($child, $page->post_title);
        /* page_for_posts */
        $page = get_page(get_option('page_for_posts'));
        $child = $xml->addChild('page_for_posts');
        $this->kt_add_cdata($child, $page->post_title);
        /* woocommerce_shop_page_id */
        $page = get_page(get_option('woocommerce_shop_page_id'));
        $child = $xml->addChild('woocommerce_shop_page_id');
        $this->kt_add_cdata($child, $page->post_title);
        /* woocommerce_cart_page_id */
        $page = get_page(get_option('woocommerce_cart_page_id'));
        $child = $xml->addChild('woocommerce_cart_page_id');
        $this->kt_add_cdata($child, $page->post_title);
        /* woocommerce_checkout_page_id */
        $page = get_page(get_option('woocommerce_checkout_page_id'));
        $child = $xml->addChild('woocommerce_checkout_page_id');
        $this->kt_add_cdata($child, $page->post_title);
        /* woocommerce_pay_page_id */
        $page = get_page(get_option('woocommerce_pay_page_id'));
        $child = $xml->addChild('woocommerce_pay_page_id');
        $this->kt_add_cdata($child, $page->post_title);
        /* woocommerce_thanks_page_id */
        $page = get_page(get_option('woocommerce_thanks_page_id'));
        $child = $xml->addChild('woocommerce_thanks_page_id');
        $this->kt_add_cdata($child, $page->post_title);
        /* woocommerce_myaccount_page_id */
        $page = get_page(get_option('woocommerce_myaccount_page_id'));
        $child = $xml->addChild('woocommerce_myaccount_page_id');
        $this->kt_add_cdata($child, $page->post_title);
        /* woocommerce_edit_address_page_id */
        $page = get_page(get_option('woocommerce_edit_address_page_id'));
        $child = $xml->addChild('woocommerce_edit_address_page_id');
        $this->kt_add_cdata($child, $page->post_title);
        /* woocommerce_view_order_page_id */
        $page = get_page(get_option('woocommerce_view_order_page_id'));
        $child = $xml->addChild('woocommerce_view_order_page_id');
        $this->kt_add_cdata($child, $page->post_title);
        /* woocommerce_terms_page_id */
        $page = get_page(get_option('woocommerce_terms_page_id'));
        $child = $xml->addChild('woocommerce_terms_page_id');
        $this->kt_add_cdata($child, $page->post_title);
        $xml->asXML($this->theme_dir.'settings/datas/'.$folder.'/options.xml');

        esc_html_e('Export demo data success.', 'kute-toolkit');
        wp_die();
    }
    function kt_menu_location_importer_prosess(){
        
    }
    function kt_page_option_importer_callback(){
        $folder = $_POST['folder'];
        if(file_exists($this->theme_dir.'settings/datas/'.$folder.'/options.xml')){
            $xml = simplexml_load_file($this->theme_dir.'settings/datas/'.$folder.'/options.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
            if(isset($xml->page_on_front)){
                $page_on_front = $xml->page_on_front[0];
                kt_print($page_on_front);
                if(count($xml->kt_option) >0){
                    $kt_options = array();
                    foreach ($xml->kt_option as $kt_option){
                        $kt_options[(string)$kt_option->name] = (string)$kt_option->value;
                    }
                }
            }

        }

    }

    function kt_js_functions(){?>
        <script type="text/javascript" >
            !(function ($) {
                function kt_theme_options_exporter(){
                    var file_name = $("#export_file_name").val();
                    if(file_name == ""){
                        alert("<?php esc_html_e("Enter file name, please.") ?>");
                        return false;
                    }
                    var export_file_overwrite = 0;
                    if($("#export_file_overwrite").is(':checked')){
                        export_file_overwrite = 1;
                    }
                    var data = {'action':'kt_theme_options_exporter', 'file_name':file_name, 'export_file_overwrite':export_file_overwrite};
                    $.post(ajaxurl, data, function(response) {
                        alert(response.msg);
                        $("#export_file_name").val("");
                        $("#kt-dialog-export-theme-options").dialog("close");
                    });
                }
                $(".kt-theme-options-export").click(function(event) {
                    event.preventDefault();
                    //var data = $(this).data(), uniqid = $(this).data('uniqid');
                    $("#kt-dialog-export-theme-options").dialog({
                        title:  "<?php esc_html_e('Theme options exporter') ?>",
                        dialogClass:'kt-dialog',
                        width: 320,
                        height: 'auto',
                        modal:true,
                        buttons: [
                            {
                                text: "<?php esc_html_e('Export', 'kute-toolkit'); ?>",
                                click: function() {
                                    kt_theme_options_exporter();
                                }
                            },
                            {
                                text: "<?php esc_html_e('Cancel', 'kute-toolkit'); ?>",
                                click: function() {
                                    $(this).dialog( "close" );
                                }
                            }
                        ]
                    });
                });
                function kt_data_exporter() {
                    var folder = $("#export_data_folder").val();
                    if(folder == ""){
                        alert("<?php esc_html_e("Enter folder name, please.") ?>");
                        return false;
                    }
                    var data = {'action':'kt_demo_exporter', 'folder':folder};
                    $.post(ajaxurl, data, function(response) {
                        alert(response);
                        $("#export_data_folder").val("");
                        $("#kt-dialog-export-data").dialog("close");
                    });
                }
                $(".kt-demo-exporter").click(function(event) {
                    $("#kt-dialog-export-data").dialog({
                        title:  "<?php esc_html_e('Data exporter') ?>",
                        dialogClass:'kt-dialog',
                        width: 320,
                        height: 'auto',
                        modal:true,
                        buttons: [
                            {
                                text: "<?php esc_html_e('Export', 'kute-toolkit'); ?>",
                                click: function() {
                                    kt_data_exporter();
                                }
                            },
                            {
                                text: "<?php esc_html_e('Cancel', 'kute-toolkit'); ?>",
                                click: function() {
                                    $(this).dialog( "close" );
                                }
                            }
                        ]
                    });
                });

                function kt_load_theme_options_backup() {
                    var data = {'action':'kt_load_theme_options_backup'};
                    $.post(ajaxurl, data, function(response) {
                        $("#kt-dialog-import-theme-options-table > tbody").html(response);
                    });
                }
                $(".kt-theme-options-importer").click(function(event) {
                    event.preventDefault();
                    kt_load_theme_options_backup();
                    /*var data = {'action':'kt_load_theme_options_backup'};
                    $.post(ajaxurl, data, function(response) {
                        $("#kt-dialog-import-theme-options-table > tbody").html(response);

                    });*/
                    $("#kt-dialog-import-theme-options").dialog({
                        title:  "<?php esc_html_e('Theme options backup files') ?>",
                        dialogClass:'kt-dialog',
                        width: 768,
                        height: 'auto',
                        modal:true
                    });
                });
                $(document).on('click','.kt-theme-options-backup-delete',function(){
                    var file = $(this).data('file'), uniqid = $(this).data('uniqid');
                    event.preventDefault();
                    var data = {
                        'action'    :   'kt_theme_options_backup_delete',
                        'file'      :   file,
                    };
                    $.post(ajaxurl, data, function(response) {
                        alert(response);
                        $("#"+uniqid).remove();
                    });
                });
                $(document).on('click','.kt-theme-options-imported',function(){
                    var file = $(this).data('file');
                    event.preventDefault();
                    var data = {
                        'action'    :   'kt_theme_options_importer',
                        'file'      :   file,
                    };
                    $.post(ajaxurl, data, function(response) {
                        alert(response);
                    });
                });

                if($("#kt_theme_options_uploader").length >0){
                    new AjaxUpload($('#kt_theme_options_uploader'), {
                        action: ajaxurl,
                        name: 'uploader',
                        data:{'action':'kt_theme_options_uploader'},
                        responseType: 'json',
                        onChange: function(file, ext){},
                        onSubmit: function(file, ext){
                            if (! (ext && /^(txt)$/.test(ext))){
                                alert("<?php esc_html_e('Support txt file format only.', 'kute-toolkit'); ?>" );
                                return false;
                            }
                        },
                        onComplete: function(file, response){
                            alert(response.msg)
                            if(response.status = 1)
                                kt_load_theme_options_backup();
                            //alert(response);
                        }
                    });
                }

                // close dialog
                $(".kt-dialog-close").click(function(e){
                    event.preventDefault();
                    var uniqid = $(this).data('uniqid');
                    $("#kt-dialog-"+uniqid).dialog('destroy');
                });
            })(jQuery); // End of use strict
        </script>
    <?php }
    function kutetheme_ovic_after_init(){
    }
    public function register_kt_template_widget() {
        register_widget( 'Template_Manager_Widget' );
    }
    public function remove_option_attributes($elements){
        if($elements && is_array($elements)){
            foreach ($elements as $element){
                if(strpos($element, 'banner_texts') !== false){
                    $atts = shortcode_parse_atts($element);
                    if(isset($atts['banner_texts'])){
                        $banner_texts = vc_param_group_parse_atts( $atts['banner_texts'] );
                        if($banner_texts)
                            if(is_array($banner_texts))
                                foreach ($banner_texts as $banner_text){
                                    if(isset($banner_text['title_uniqid']))
                                        if(get_option($this->hash_key.'_css-'.$banner_text['title_uniqid']))
                                            delete_option($this->hash_key.'_css-'.$banner_text['title_uniqid']);
                                }
                    }
                }
                $kt_uniqid = $this->get_shortcode_attr_value($element, 'kt_uniqid');
                if($kt_uniqid){
                    if(get_option($this->hash_key.'_css-'.$kt_uniqid)){
                        delete_option($this->hash_key.'_css-'.$kt_uniqid);
                    }
                    if(get_option($this->hash_key.'_script-'.$kt_uniqid)){
                        delete_option($this->hash_key.'_script-'.$kt_uniqid);
                    }
                }
            }
        }
        return true;
    }
    /**
     * Save generated css
     *
     * @access public
     * @since 1.0
     *
     * @param $post_id - current post id
     *
     * @return void
     */
    public function save( $post_id, $post, $update ) {
        //global $kuteToolkit;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        // @todo fix_roles maybe check also for is vc_enabled
        if ( ! vc_user_access()
            ->wpAny( array( 'edit_post', $post_id ) )
            ->get()
        ) {
            return;
        }
        $re_render = false;
        if( class_exists( 'Vc_Manager' ) ){
            require_once vc_path_dir( 'SETTINGS_DIR', 'class-vc-roles.php' );
            $vc_roles = new Vc_Roles();
            //$this->post_types = $vc_roles->getPostTypes();
            $state = 0;
            foreach ( $vc_roles->getParts() as $part ) {
                if($part == 'post_types'){
                    $partObj = vc_user_access()->part( $part );
                    $state = $partObj->getState();
                    $capabilities = $partObj->getAllCaps();
                }
            }
            if($state == '1'){
                if($post->post_type == 'page'){
                    $re_render = true;
                }
            }elseif($state == 'custom'){
                if(array_key_exists($post->post_type,$capabilities)){
                    $re_render = true;
                }
            }
            if($re_render == true){
                $css_options = trailingslashit (get_template_directory()). 'css/options.css';
                if(file_exists($css_options)){
                    file_put_contents($css_options, '');
                }
                $js_options = trailingslashit (get_template_directory()). 'js/options.js';
                if(file_exists($js_options)){
                    file_put_contents($js_options, '');
                }
                if($post->post_content){
                    $content = str_replace('\\', '', $post->post_content);
                    $pattern = '/\[kt_flexible_banner(.*?)\]|\[kt_custom_banner(.*?)\]|\[kt_single_banner(.*?)\]|\[kt_megacategories(.*?)\]|\[kt_woocommerce(.*?)\]|\[kt_banner(.*?)\]|\[kt_blog(.*?)\]|\[kt_call_to_action(.*?)\]|\[kt_container(.*?)\]|\[kt_countdown(.*?)\]|\[kt_featured_box(.*?)\]|\[kt_newsletter(.*?)\]|\[kt_parallax(.*?)\]|\[kt_social(.*?)\]|\[kt_testimonial(.*?)\]|\[kt_hotcategories(.*?)\]/s';
                    if(preg_match_all($pattern, $content, $matches)){
                        $this->remove_option_attributes($matches[0]);
                    }
                }
            }
        }
        return true;
        //$post = get_post( $post_id );
        $shortcodes = $this->shortcodes->shortcodes;
        $all_shortcodes = $this->shortcodes($post->post_content);
        $assets = array(
            'kt_shortcodes_frontend_enqueue_css' => array(),
            'kt_shortcodes_frontend_enqueue_js' => array()
        );

        if( isset( $shortcodes ) && is_array( $shortcodes ) && count( $shortcodes ) > 0 ) {
            if( $all_shortcodes && isset( $all_shortcodes[2] ) && is_array( $all_shortcodes[2] ) && count( $all_shortcodes[2] ) > 0 ){
                $all_shortcodes = array_unique($all_shortcodes[2] );
                foreach ( $all_shortcodes as $sc){
                    if( isset( $shortcodes[$sc] ) && is_array( $shortcodes[$sc] ) && isset( $shortcodes[$sc]['base'] ) ){
                        if( isset( $shortcodes[$sc]['frontend_enqueue_css'] ) && is_array( $shortcodes[$sc]['frontend_enqueue_css'] ) && count( $shortcodes[$sc]['frontend_enqueue_css'] ) > 0 )
                            $this->registerFrontEndAsset( $assets['kt_shortcodes_frontend_enqueue_css'], $shortcodes[$sc]['frontend_enqueue_css'] );
                        if( isset( $shortcodes[$sc]['frontend_enqueue_js'] ) && is_array( $shortcodes[$sc]['frontend_enqueue_js'] ) && count( $shortcodes[$sc]['frontend_enqueue_js'] ) > 0 )
                            $this->registerFrontEndAsset( $assets['kt_shortcodes_frontend_enqueue_js'], $shortcodes[$sc]['frontend_enqueue_js'] );
                    }
                }
            }
        }
        if ( count( $assets['kt_shortcodes_frontend_enqueue_css'] ) < 1 && count( $assets['kt_shortcodes_frontend_enqueue_js'] ) < 1 ) {
            delete_post_meta( $post_id, 'kt_shortcodes_frontend_asset' );
        } else {
            update_post_meta( $post_id, 'kt_shortcodes_frontend_asset', serialize($assets) );
        }
        $font = $this->parseShortcodesFont($post->post_content);
        if( count( $font ) > 0 ){
            update_post_meta( $post_id, 'kt_shortcodes_custom_font', serialize($font) );
        }else{
            delete_post_meta( $post_id, 'kt_shortcodes_custom_font' );
        }
    }
    public function shortcode_has_assets( $content = "", $shortcodes = array()){
        if( ! $content ) return false;
        if( ! is_array( $shortcodes ) || count( $shortcodes ) < 1 ){
            $shortcodes = $this->shortcodes->shortcodes;
        }
        $assets = array(
            'kt_shortcodes_frontend_enqueue_css' => array(),
            'kt_shortcodes_frontend_enqueue_js'	 => array()
        );
        if( isset( $shortcodes ) && is_array( $shortcodes ) && count( $shortcodes ) > 0 ){
            foreach ( $shortcodes as $base => $sc){
                if( isset( $sc['base'] ) && ( isset( $sc['frontend_enqueue_css'] ) || isset( $sc['frontend_enqueue_js'] ) ) ){
                    if( has_shortcode( $content, $base ) ){
                        if( isset( $sc['frontend_enqueue_css'] ) && is_array( $sc['frontend_enqueue_css'] ) && count( $sc['frontend_enqueue_css'] ) > 0 )
                            $this->registerFrontEndAsset( $assets['kt_shortcodes_frontend_enqueue_css'], $sc['frontend_enqueue_css'] );
                        if( isset( $sc['frontend_enqueue_js'] ) && is_array( $sc['frontend_enqueue_js'] ) && count( $sc['frontend_enqueue_js'] ) > 0 )
                            $this->registerFrontEndAsset( $assets['kt_shortcodes_frontend_enqueue_js'], $sc['frontend_enqueue_js'] );
                    }
                }
            }
        }
        return $assets;
    }
    public function registerFrontEndAsset( &$param, $asset){
        foreach ( $asset as $k => $v ){
            if( ! in_array( $v, $param ) ){
                if( ! $k || is_numeric( $k ) ){
                    $k = 'frontend_enqueue_' . md5( $v );
                }
                $param[$k] = $v;
            }
        }
        return $param;
    }
    public function addFrontEndAsset(){
        global $posts;
        if( ! is_admin() && is_singular() ){
            //For page
            $this->getFrontEndAsset( get_the_ID() );
            //For header and footer
            $kt_used_header = $this->kutetheme_ovic_get_post_meta( get_the_ID(), 'kt_page_header', '' );
            if( $kt_used_header == 'built' ){
                $this->getFrontEndAsset($kt_used_header);
            }
            $kt_footer_style = $this->kutetheme_ovic_get_post_meta( get_the_ID(), 'kt_page_footer', '' );
            if( $kt_footer_style ){
                $this->getFrontEndAsset($kt_footer_style);
            }
        }
    }
    public function kutetheme_ovic_get_post_meta( $post_id, $key, $default = "" ){
        $meta = get_post_meta( $post_id, $key, true );
        if($meta){
            return $meta;
        }
        return $default;
    }
    public function getFrontEndAsset( $id ){
        $sc_assets = get_post_meta( $id, 'kt_shortcodes_frontend_asset', true );
        if( $sc_assets and is_string( $sc_assets ) ){
            $sc_assets = unserialize( $sc_assets );
            if( isset( $sc_assets['kt_shortcodes_frontend_enqueue_js'] ) && is_array( $sc_assets['kt_shortcodes_frontend_enqueue_js'] ) ){
                foreach ( $sc_assets['kt_shortcodes_frontend_enqueue_js'] as $name => $js ){
                    wp_enqueue_script( $name,  $js, array('jquery') );
                }
            }
            if( isset( $sc_assets['kt_shortcodes_frontend_enqueue_css'] ) && is_array( $sc_assets['kt_shortcodes_frontend_enqueue_css'] ) ){
                foreach ( $sc_assets['kt_shortcodes_frontend_enqueue_css'] as $name => $css ){
                    wp_enqueue_style( $name, $css , array( 'kutetheme-style' ) );
                }
            }
        }
    }
    public function addShortcodesGoogleFont( $id = null ){
        if ( ! is_singular() ) {
            return;
        }
        if ( ! $id ) {
            $id = get_the_ID();
        }
        if ( $id ) {
            $shortcodes_custom_font = get_post_meta( $id, 'kt_shortcodes_custom_font', true );
            if ( ! empty( $shortcodes_custom_font ) ) {
                $shortcodes_custom_font = unserialize( $shortcodes_custom_font );
                if( is_array( $shortcodes_custom_font ) && count( $shortcodes_custom_font ) > 0 ){
                    if( class_exists( 'Vc_Google_Fonts' ) ){
                        $google_fonts_obj = new Vc_Google_Fonts();
                    }
                    foreach( $shortcodes_custom_font as $fonts ){
                        if( isset( $fonts['value'] ) and isset( $fonts['fields'] ) ){
                            $google_fonts = $fonts['value'];
                            $google_fonts_field_settings = $fonts['fields'];
                            $google_fonts_data = strlen( $google_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings, $google_fonts ) : '';
                            $settings = get_option( 'wpb_js_google_fonts_subsets' );
                            if ( is_array( $settings ) && ! empty( $settings ) ) {
                                $subsets = '&subset=' . implode( ',', $settings );
                            } else {
                                $subsets = '';
                            }
                            $font_name = 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] );
                            if ( isset( $google_fonts_data['values']['font_family'] ) ) {
                                wp_enqueue_style( $font_name, '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
                                //echo "<link href='http://fonts.googleapis.com/css?family=". $google_fonts_data['values']['font_family'] ."' rel='stylesheet' type='text/css'>";
                            }
                        }
                    }
                }
            }
        }
    }
    public function get_shortcode_layout_data($shortcode_name, $file_layout){
        $data = get_file_data( $this->theme_dir.'settings/shortcodes/'.$shortcode_name.'/'.$file_layout, array('Name'=>'Name') );
        return $data;
    }
    public function load_shortcode_settings($shortcode_name = '', &$settings = array(), $load_default_setting = true){
        if($shortcode_name){
            $layoutDir = $this->theme_dir.'settings/shortcodes/'.$shortcode_name.'/';
            //echo $layoutDir;
            if(is_dir($layoutDir)){
                if(file_exists($layoutDir.'layouts.php')){
                    $files = include $layoutDir.'layouts.php';
                }else{
                    $files = scandir($layoutDir);
                }
                if($files && is_array($files)){
                    foreach ($files as $file){
                        if ($file != '.' && $file != '..' && $file != 'index.php'){
                            $fileInfo = pathinfo($file);
                            if($fileInfo['extension'] == 'php'){
                                $layout_params = @include $layoutDir.$file;
                                if(is_array($layout_params)){
                                    foreach ($layout_params as $param)
                                        $settings[] = $param;
                                }
                            }
                        }
                    }
                }
            }
        }
        if($load_default_setting == true){
            $settings[] = array(
                "type"        => "kt_uniqid",
                "heading"     => __( "Shortcode id", 'kute-toolkit' ),
                "param_name"  => "kt_uniqid",
                'admin_label' => true,
            );
            $settings[] = array(
                "type"        => "textfield",
                "heading"     => __( "Extra class name", 'kute-toolkit' ),
                "param_name"  => "el_class",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'kute-toolkit' ),
                'admin_label' => false,
            );
            $settings[] = array(
                'type'           => 'css_editor',
                'heading'        => __( 'Css', 'kute-toolkit' ),
                'param_name'     => 'css',
                'group'          => __( 'Design options', 'kute-toolkit' ),
                'admin_label'    => false,
            );
            $settings[] = array(
                'type'        => 'dropdown',
                'heading'     => __( 'CSS Animation', 'kute-toolkit' ),
                'param_name'  => 'css_animation',
                'admin_label' => false,
                'value'       => array(
                    __( 'No', 'kute-toolkit' )                 => '',
                    __( 'Top to bottom', 'kute-toolkit' )      => 'top-to-bottom',
                    __( 'Bottom to top', 'kute-toolkit' )      => 'bottom-to-top',
                    __( 'Left to right', 'kute-toolkit' )      => 'left-to-right',
                    __( 'Right to left', 'kute-toolkit' )      => 'right-to-left',
                    __( 'Appear from center', 'kute-toolkit' ) => "appear"
                ),
                'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'kute-toolkit' )
            );
        }else{
            $settings[] = array(
                "type"        => "kt_uniqid",
                "heading"     => __( "Shortcode id", 'kute-toolkit' ),
                "param_name"  => "kt_uniqid",
                'admin_label' => true,
            );
        }
        return true;
    }
    public function get_shortcode_attr_value($shortcode_text, $attr_name){
        $str_post = strpos($shortcode_text, $attr_name);
        if($str_post !== false){
            $start_post = strpos($shortcode_text, '"', $str_post + strlen($attr_name));
            $end_post = strpos($shortcode_text, '"', $start_post+1);
            if($start_post !== false && $end_post !== false)
                return substr($shortcode_text, $start_post+1, $end_post-$start_post-1);
        }
        return '';
    }
    public function get_shortcode_attrs($shortcode_name = '', $layout_name='all', $attrs = array()){
        if($shortcode_name){
            $layoutDir = $this->theme_dir.'settings/shortcodes/'.$shortcode_name.'/';
            if($layout_name && $layout_name != 'all'){
                if(file_exists($layoutDir.$layout_name.'.php')){
                    $layout_params = include $layoutDir.$layout_name.'.php';
                    if($layout_params){
                        foreach ($layout_params as $param){
                            if(isset($param['param_name']) && $param['param_name']){
                                if(isset($param['std']))
                                    $attrs[$param['param_name']] = $param['std'];
                                else
                                    $attrs[$param['param_name']] = '';
                            }
                        }
                    }
                }
            }else{
                if(is_dir($layoutDir)){
                    if(file_exists($layoutDir.'layouts.php')){
                        $files = include $layoutDir.'layouts.php';
                    }else{
                        $files = scandir($layoutDir);
                    }
                    if($files && is_array($files)){
                        foreach ($files as $file){
                            if ($file != '.' && $file != '..' && $file != 'index.php'){
                                $fileInfo = pathinfo($file);
                                if($fileInfo['extension'] == 'php'){
                                    $layout_params = include $layoutDir.$file;
                                    if($layout_params){
                                        foreach ($layout_params as $param)
                                            if(isset($param['param_name']) && $param['param_name']){
                                                if(isset($param['std']))
                                                    $attrs[$param['param_name']] = $param['std'];
                                                else
                                                    $attrs[$param['param_name']] = '';
                                            }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $attrs;
    }
    public function getProducts( $atts, $args = array(), $ignore_sticky_posts = 1 ){
        extract( $atts );
        $target = isset( $target ) ? $target : 'recent-product';
        $meta_query = WC()->query->get_meta_query();
        $args['meta_query'] = $meta_query;
        $args['post_type']  = 'product';
        if( isset( $taxonomy ) and $taxonomy ){
            $args['tax_query'] =
                array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => array_map( 'sanitize_title', explode( ',', $taxonomy )
                        )
                    )
                );
        }
        $args['post_type']           = 'product';
        $args['post_status']         = 'publish';
        $args['ignore_sticky_posts'] = $ignore_sticky_posts;
        $args['suppress_filter']     = true;
        if( ! isset( $orderby ) ){
            $ordering_args = WC()->query->get_catalog_ordering_args();
            $orderby = $ordering_args['orderby'];
            $order   = $ordering_args['order'];
        }

        switch( $target ):
            case 'best-selling' :
                $args[ 'meta_key' ] = 'total_sales';
                $args[ 'orderby' ]  = 'meta_value_num';
                break;
            case 'top-rated' :
                $args[ 'orderby' ] = $orderby;
                $args[ 'order' ]   = $order;
                break;
            case 'product-category' :
                $ordering_args = WC()->query->get_catalog_ordering_args( $atts['orderby'], $atts['order'] );
                $args[ 'orderby' ] = $ordering_args['orderby'];
                $args[ 'order' ]   = $ordering_args['order'];
                break;
            case 'products' :
                /*$args[ 'orderby' ] = $orderby;
                $args[ 'order' ]   = $order;*/
                if ( ! empty( $ids ) ) {
                    //$args['post__in'] = array_map( 'trim', explode( ',', $ids ) );
                    $args['post__in'] = array_map( 'trim', explode( ',', $ids ) );
                    $args['orderby'] = 'post__in';
                }
                if ( ! empty( $skus ) ) {
                    $args['meta_query'][] = array(
                        'key'     => '_sku',
                        'value'   => array_map( 'trim', explode( ',', $skus ) ),
                        'compare' => 'IN'
                    );
                }
                break;
            case 'featured_products' :
                $meta_query[] = array(
                    'key'   => '_featured',
                    'value' => 'yes'
                );
                $args[ 'meta_query' ]   = $meta_query;
                break;
            case 'product_attribute' :
                //'recent-product'
                $args[ 'tax_query' ] =  array(
                    array(
                        'taxonomy' => strstr( $atts['attribute'], 'pa_' ) ? sanitize_title( $atts['attribute'] ) : 'pa_' . sanitize_title( $atts['attribute'] ),
                        'terms'    => array_map( 'sanitize_title', explode( ',', $atts['filter'] ) ),
                        'field'    => 'slug'
                    )
                );
                break;
            case 'on_sale' :
                $product_ids_on_sale = wc_get_product_ids_on_sale();
                $args['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
                if( $orderby == '_sale_price' ){
                    $orderby = 'date';
                    $order   = 'DESC';
                }
                $args['orderby'] = $orderby;
                $args['order'] 	= $order;
                break;
            case 'filter' :
                if( $atts['order'] ) {
                    $order = $atts['order'];
                }else{
                    $order = '';
                }
                $ordering_args = $this->get_catalog_ordering_args( $atts['orderby'],$order);
                
                $args[ 'orderby' ] = $ordering_args['orderby'];
                $args[ 'order' ]   = $ordering_args['order'];
                if ( isset( $ordering_args['meta_key'] ) ) {
                    $args['meta_key'] = $ordering_args['meta_key'];
                }

                if( $atts['filter_by_price'] && $atts['price_max'] && $atts['price_min'] ){
                    $args['meta_query'][] = array(
                        'key'     => '_price',
                        'value'   => array( intval( $atts['price_min']), intval( $atts['price_max'] ) ),
                        'compare' => 'BETWEEN',
                        'type'    => 'NUMERIC'
                    );
                }

                if( $atts['attributes']){
                    foreach ($atts['attributes'] as $attr) {
                        if( trim( $attr['terms'] ) != "" ){
                            $attr_terms = explode(',', $attr['terms'] );
                            if( !empty( $attr_terms ) ){
                                $args['tax_query'][] = array(
                                    'taxonomy' => $attr['taxonomy'],
                                    'terms'    => $attr_terms,
                                    'field'    => 'slug',
                                    'operator'  => 'IN'
                                );
                            }
                        }
                    }
                }
                /*tags*/
                if(trim( $atts['tags'] ) != "" ){
                    $tags = explode(',', $atts['tags'] );
                    if( !empty( $tags) ){
                        $args['tax_query'][] = array(
                            'taxonomy' => 'product_tag',
                            'terms'    => $tags,
                            'field'    => 'slug',
                            'operator'  => 'IN'
                        );
                    }
                }
            break;
            default :
                //'recent-product'
                $args[ 'orderby' ] = $orderby;
                $args[ 'order' ]   = $order;
                if ( isset( $ordering_args['meta_key'] ) ) {
                    $args['meta_key'] = $ordering_args['meta_key'];
                }
                // Remove ordering query arguments
                WC()->query->remove_ordering_args();

                break;
        endswitch;
        // echo "<pre>";
        // print_r($args);
        // echo "</pre>";
        return $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
    }
    
    /**
     * Parse shortcodes custom css string.
     *
     * This function is used by self::buildShortcodesCustomCss and creates css string from shortcodes attributes
     * like 'google_fonts'.
     *
     * @author  Kutethemes
     * @since  1.0
     * @access public
     *
     * @param $content
     *
     * @return string
     */
    public function shortcodes( $the_content ) {
        $shortcode = "";
        $pattern = $this->shortcode_regex();
        if( $pattern ){
            if (   preg_match_all( '/'. $pattern .'/s', $the_content, $matches ))
            {
                return $matches;
            }
        }
        return false;
        //preg_match_all('/'.$pattern.'/uis', $the_content, $matches);
    }
    /**
     * Get shortcode regex check all the shortcode of kutetheme
     * @param null $tagnames
     * @return string
     */
    public function shortcode_regex( $tagnames = null ) {
        $shortcode_tags = $this->shortcodes->shortcodes;
        if ( empty( $tagnames ) ) {
            $tagnames = array_keys( $shortcode_tags );
        }
        $tagregexp = join( '|', array_map('preg_quote', $tagnames) );
        // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
        // Also, see shortcode_unautop() and shortcode.js.
        return
            '\\['                              // Opening bracket
            . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            . "($tagregexp)"                     // 2: Shortcode name
            . '(?![\\w-])'                       // Not followed by word character or hyphen
            . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
            .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
            .     '(?:'
            .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
            .         '[^\\]\\/]*'               // Not a closing bracket or forward slash
            .     ')*?'
            . ')'
            . '(?:'
            .     '(\\/)'                        // 4: Self closing tag ...
            .     '\\]'                          // ... and closing bracket
            . '|'
            .     '\\]'                          // Closing bracket
            .     '(?:'
            .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            .             '[^\\[]*+'             // Not an opening bracket
            .             '(?:'
            .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            .                 '[^\\[]*+'         // Not an opening bracket
            .             ')*+'
            .         ')'
            .         '\\[\\/\\2\\]'             // Closing shortcode tag
            .     ')?'
            . ')'
            . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
    }
    /**
     * Get all the font setting param google_fonts
     * @param $content
     * @param array $fonts
     * @return array
     */
    public function parseShortcodesFont( $content, $fonts = array() ) {
        WPBMap::addAllMappedShortcodes();
        preg_match_all( '/' . $this->shortcode_regex() . '/', $content, $shortcodes );
        if( isset( $shortcodes[2] ) ){
            foreach ( $shortcodes[2] as $index => $tag ) {
                $shortcode = WPBMap::getShortCode( $tag );
                $attr_array = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
                if ( isset( $shortcode['params'] ) && ! empty( $shortcode['params'] ) ) {
                    foreach ( $shortcode['params'] as $param ) {
                        if ( 'google_fonts' === $param['type'] && isset( $attr_array[ $param['param_name'] ] ) ) {
                            if( isset( $param['settings']['fields'] ) ){
                                $font = array(
                                    'fields' => $param['settings']['fields'],
                                    'value'  => $attr_array[ $param['param_name'] ]
                                );
                                $fonts[] = $font;
                            }
                        }
                    }
                }
            }
            foreach ( $shortcodes[5] as $shortcode_content ) {
                $fonts = $this->parseShortcodesFont( $shortcode_content, $fonts );
            }
        }
        return $fonts;
    }

    /**
     * Returns an array of arguments for ordering products based on the selected values.
     *
     * @access public
     * @return array
     */
    public function get_catalog_ordering_args( $orderby = '', $order = '' ) {
        // Get ordering from query string unless defined
        if ( ! $orderby ) {
            $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

            // Get order + orderby args from string
            $orderby_value = explode( '-', $orderby_value );
            $orderby       = esc_attr( $orderby_value[0] );
            $order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : $order;
        }

        $orderby = strtolower( $orderby );
        $order   = strtoupper( $order );
        $args    = array();

        // default - menu_order
        $args['orderby']  = 'menu_order title';
        $args['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
        $args['meta_key'] = '';

        switch ( $orderby ) {
            case 'rand' :
                $args['orderby']  = 'rand';
            break;
            case 'date' :
                $args['orderby']  = 'date ID';
                $args['order']    = $order == 'ASC' ? 'ASC' : 'DESC';
            break;
            case 'price' :
                $args['orderby']  = "meta_value_num ID";
                $args['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
                $args['meta_key'] = '_price';
            break;
            case 'popularity' :
                $args['meta_key'] = 'total_sales';

                // Sorting handled later though a hook
                add_filter( 'posts_clauses', array( $this, 'order_by_popularity_post_clauses' ) );
            break;
            case 'rating' :
                // Sorting handled later though a hook
                add_filter( 'posts_clauses', array( $this, 'order_by_rating_post_clauses' ) );
            break;
            case 'title' :
                $args['orderby']  = 'title';
                $args['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
            break;
        }
        
        return apply_filters( 'woocommerce_get_catalog_ordering_args', $args );
    }
    public function order_by_popularity_post_clauses( $args ) {
        global $wpdb;
        $args['orderby'] = "$wpdb->postmeta.meta_value+0 DESC, $wpdb->posts.post_date DESC";
        return $args;
    }
    public function order_by_rating_post_clauses( $args ) {
        global $wpdb;

        $args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";
        $args['where']  .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";
        $args['join']   .= "
            LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
            LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
        ";
        $args['orderby'] = "average_rating DESC, $wpdb->posts.post_date DESC";
        $args['groupby'] = "$wpdb->posts.ID";

        return $args;
    }
    /**
     * Enables to add hooks in activation process.
     * @since 1.0
     */
    public function activationHook() {
        do_action( 'kutetheme_ovic_activation_hook' );
    }
    /**
     * Cloning disabled
     */
    public function __clone() {
    }
    /**
     * Serialization disabled
     */
    public function __sleep() {
    }
    /**
     * De-serialization disabled
     */
    public function __wakeup() {
    }
}


/**
 * KUTE_TOOLKIT.
 *
 * @since   1.0
 * @author Kutethemes
 */
//global $alesia;
global $kuteToolkit, $kutetheme_ovic_toolkit, $kutetheme_ovic_render;
$kutetheme_ovic_render = false;
if ( ! $kuteToolkit ) {
    $kuteToolkit = KUTE_TOOLKIT::getInstance();
}
if(!$kutetheme_ovic_toolkit)
    $kutetheme_ovic_toolkit = KUTE_TOOLKIT::getInstance();

if( ! function_exists( 'kutetheme_ovic_path_dir' ) ){
    /**
     * Get file/directory path in KUTETHEME_ALESIA.
     *
     * @param string $name - path name
     * @param string $file
     * @param string $require check require
     *
     * @since 1.0
     * @return string
     */
    function kutetheme_ovic_path_dir( $name, $file = '', $require = false ) {
        global $kuteToolkit;
        return $kuteToolkit->path( $name, $file, $require );
    }
}
if( ! function_exists( 'kutetheme_ovic_path_uri' ) ){
    /**
     * Get style file path in KUTETHEME_ALESIA.
     *
     * @since 1.0
     * @return string
     */
    function kutetheme_ovic_path_uri() {
        global $kuteToolkit;
        return $kuteToolkit->getPluginUri();
    }
}
/**
 * extract arguement from content shortcode
 * @author Kutethemes
 * @since 1.0
 * @param $tag string shortcode tag
 * @param $text string content shortcode is needed extract param
 */
if( ! function_exists('kutetheme_ovic_get_all_attributes') ){
    function kutetheme_ovic_get_all_attributes( $tag, $text ) {
        preg_match_all( '/' . get_shortcode_regex() . '/s', $text, $matches );
        $out = array();
        if( isset( $matches[2] ) )
        {
            foreach( (array) $matches[2] as $key => $value )
            {
                if( $tag === $value )
                    $out[] = shortcode_parse_atts( $matches[3][$key] );
            }
        }
        return $out;
    }
}
if ( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ) {
    /**
     * Add shortcode add to wishlist because It don't work via ajax
     * @author Kutethemes
     *
     * @since 1.0
     * yith_wcwl_enabled
     */
    if( get_option('yith_wcwl_enabled') == 'yes'){
        if( ! shortcode_exists('yith_wcwl_add_to_wishlist') && class_exists( 'YITH_WCWL_Shortcode' ) ){
            add_shortcode( 'yith_wcwl_add_to_wishlist', array( 'YITH_WCWL_Shortcode' , 'add_to_wishlist' ) );
        }
        /*add_action( 'kutetheme_ovic_function_shop_loop_item_wishlist', 'kutetheme_ovic_item_wishlist', 5 );*/
        add_action( 'kutetheme_ovic_function_shop_loop_item_wishlist', create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ), 5 );
    }
}
if(!function_exists('kutetheme_ovic_compare_button')){
    function kutetheme_ovic_compare_button(){
        $atts = array(
            'product' => false,
            'type' => 'default',
            'container' => 'no'
        );
        if( class_exists('YITH_Woocompare_Frontend')){
            $yith_compare = new YITH_Woocompare_Frontend();
            echo $yith_compare->compare_button_sc($atts, '<span>'.__('Compare', 'koolshop').'</span>');
        }else{
//            echo "A";
//            if(is_plugin_active( 'yith-woocommerce-compare/init.php' )){
//               $plugin_dir_path = ABSPATH . 'wp-content/plugins/yith-woocommerce-compare/includes/class.yith-woocompare-frontend.php';
//                if( file_exists($plugin_dir_path)){
//                    require_once($plugin_dir_path);
//                    if( class_exists('YITH_Woocompare_Frontend')){
//                        $yith_compare = new YITH_Woocompare_Frontend();
//                        echo $yith_compare->compare_button_sc($atts, '<span>'.__('Compare', 'koolshop').'</span>');
//                    }
//
//                }
//
//            }
        }

    }
}
if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) ) {
    /**
     * Add shortcode compare because It don't work via ajax
     * @author Kutethemes
     *
     * @since 1.0
     */
    if( ! shortcode_exists('yith_compare_button') && class_exists( 'YITH_Woocompare_Frontend' ) ){
        $yith_compare = new YITH_Woocompare_Frontend();
        add_shortcode( 'yith_compare_button', array( $yith_compare , 'compare_button_sc' ) );
    }
    add_action( 'kutetheme_ovic_function_shop_loop_item_compare', 'kutetheme_ovic_compare_button', 5 );
    //add_action( 'kutetheme_ovic_function_shop_loop_item_compare', create_function( '', 'echo do_shortcode( "[yith_compare_button]" );' ), 5 );
}
if( ! function_exists( 'kutetheme_ovic_footer' ) ){
    function kutetheme_ovic_footer( $atts ) {
        $atts = shortcode_atts( array(
            'id' => '',
            'el_class' => ''
        ),  $atts, 'kutetheme_ovic_footer' );
        if( ! $atts[ 'id' ] || intval( $atts[ 'id' ] ) <= 0 ){
            $kt_footer_style = get_post_meta( get_the_ID(), 'kt_page_footer', true );
            if( ! $kt_footer_style ){
                $kt_footer_style = kutetheme_ovic_option( 'kt_footer_style' );
            }
        }else{
            $kt_footer_style = $atts[ 'id' ];
        }
        if( $kt_footer_style ){
            $kt_footer_wapper = kutetheme_ovic_option('kt_footer_wapper', '');
            if(!$kt_footer_wapper)
                $kt_footer_wapper = kutetheme_ovic_option('kt_site_wapper','container');
            $kt_template_style = get_post_meta( $kt_footer_style, 'kt_template_style', true );
            if(!$kt_template_style)
                $kt_template_style = 'default';
            ob_start();
            $query = new WP_Query( array( 'p' => $kt_footer_style , 'post_type' => 'template', 'posts_per_page' => 1 ) );
            if( $query->have_posts() ):
                while( $query->have_posts() ): $query->the_post(); ?>
                    <?php $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), $atts[ 'el_class' ] ); ?>
                    <?php if($kt_template_style == 'default'):  ?>
                        <footer class="footer footer-fullwidth <?php echo  ( $kt_template_style == "custom") ? "custom-footer" : esc_attr($kt_template_style) ?> <?php echo esc_attr( $elementClass ); ?>">
                            <div class="<?php echo esc_attr($kt_footer_wapper);  ?>">
                                <?php the_content();?>
                            </div>
                        </footer>
                    <?php else: ?>
                        <?php get_template_part( 'templates/footers/footer',$kt_template_style );  ?>
                    <?php  endif; ?>
                <?php endwhile;
            endif;
            wp_reset_postdata();
            echo ob_get_clean();
        }
    }
}
add_shortcode( 'kutetheme_ovic_footer', 'kutetheme_ovic_footer' );
if ( !function_exists( 'kutetheme_ovic_load_custom_css_header_footer' ) ){
    function kutetheme_ovic_load_custom_css_header_footer($id = 0){
        global $kuteToolkit;
        if( ! $id ) $id = get_the_ID();
        $kt_footer_style = $kuteToolkit->kutetheme_ovic_get_post_meta( get_the_ID(), 'kt_page_footer', '' );
        if( ! $kt_footer_style && function_exists( 'kutetheme_ovic_option') ){
            $kt_footer_style = kutetheme_ovic_option( 'kt_footer_style' );
        }
        $shortcodes_custom_css = get_post_meta( $kt_footer_style, '_wpb_shortcodes_custom_css', true );
        if ( ! empty( $shortcodes_custom_css ) ) {
            $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
            echo '<style type="text/css" data-type="kt_template_shortcodes_custom_css">';
            echo $shortcodes_custom_css;
            echo '</style>';
        }
    }
}
add_action( 'wp_head','kutetheme_ovic_load_custom_css_header_footer',100 );
if( ! function_exists('kutetheme_ovic_product_style') ) {
    function kutetheme_ovic_product_style($fileName){
        $slug = 'content-product-';
        return str_replace($slug, '', $fileName);
    }
};
/**
 * Function kutetheme_ovic_yith_compare_ajax_woocompare_shortcode() create shortcode [yith_compare_button]
 * Because [yith_compare_button] not working via ajax when located in: kute-toolkit plugin
 *
 */
if( !function_exists( 'kutetheme_ovic_yith_compare_ajax_woocompare_shortcode' ) ){
    function kutetheme_ovic_yith_compare_ajax_woocompare_shortcode(){
        if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) ) {

            if(  !shortcode_exists('yith_compare_button') && class_exists( 'YITH_Woocompare_Frontend' ) ){
                $yith_compare = new YITH_Woocompare_Frontend();
                add_shortcode( 'yith_compare_button', array( $yith_compare , 'compare_button_sc' ) );
            }
        }
    }
}
function kutetheme_ovic_get_option($key, $prefix=''){
    global $kutetheme_ovic_toolkit;
    return get_option($kutetheme_ovic_toolkit->hash_key.$prefix.'-'.$key);
}
function kutetheme_ovic_add_option($key, $value, $prefix='', $test = false){
    global $kutetheme_ovic_toolkit;

    if(add_option($kutetheme_ovic_toolkit->hash_key.$prefix.'-'.$key, $value)){
        return true;
    }else{
        return update_option($kutetheme_ovic_toolkit->hash_key.$prefix.'-'.$key, $value);
    }
}
function kutetheme_ovic_update_option($key, $value, $prefix=''){
    global $kutetheme_ovic_toolkit;
    return update_option($kutetheme_ovic_toolkit->hash_key.$prefix.'-'.$key, $value);
}
function kutetheme_ovic_delete_option($key, $prefix=''){
    global $kutetheme_ovic_toolkit;
    return delete_option($kutetheme_ovic_toolkit->hash_key.$prefix.'-'.$key);
}

function kutetheme_ovic_strip_shortcodes( $content, $tags = array() ) {
    global $shortcode_tags;

    if ( false === strpos( $content, '[' ) ) {
        return $content;
    }

    if (empty($shortcode_tags) || !is_array($shortcode_tags))
        return $content;
    if(!$tags)
        $trip_shortcode_tags = $shortcode_tags;
    else{
        foreach ($tags as $tag){
            $trip_shortcode_tags[$tag] = $shortcode_tags[$tag];
        }
    }
    // Find all registered tag names in $content.
    preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
    $tagnames = array_intersect( array_keys( $trip_shortcode_tags ), $matches[1] );


    if ( empty( $tagnames ) ) {
        return $content;
    }

    $content = do_shortcodes_in_html_tags( $content, true, $tagnames );

    $pattern = get_shortcode_regex( $tagnames );
    $content = preg_replace_callback( "/$pattern/", 'strip_shortcode_tag', $content );

    // Always restore square braces so we don't break things like <!--[if IE ]>
    $content = unescape_invalid_shortcodes( $content );

    return $content;
}
// GET HTML 
if( !function_exists( 'kutetheme_ovic_get_html' )){
    function kutetheme_ovic_get_html( $html ){
        return balanceTags( $html );
    }
}
if( !function_exists( 'kutetheme_ovic_get_attr' ) ){
    function kutetheme_ovic_get_attr($attr){
        return $attr;
    }
}