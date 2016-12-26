<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class KT_WCAJS_SETTINGS {
    /**
     * Option key, and option page slug
     * @var string
     */
    private $key = 'kt_wcajs_options';
    /**
     * Options page metabox id
     * @var string
     */
    private $metabox_id = 'kt_wcajs_option_metabox';
    /**
     * Options Page title
     * @var string
     */
    protected $title = '';
    /**
     * Options Page hook
     * @var string
     */
    protected $options_page = '';
    /**
     * Holds an instance of the object
     *
     * @var Myprefix_Admin
     **/
    private static $instance = null;
    /**
     * Constructor
     * @since 0.1.0
     */
    private function __construct() {
        // Set our title
        $this->title = __( 'Ajax Search', 'kute-toolkit' );
    }
    /**
     * Returns the running object
     *
     * @return Myprefix_Admin
     **/
    public static function get_instance() {
        if( is_null( self::$instance ) ) {
            self::$instance = new self();
            self::$instance->hooks();
        }
        return self::$instance;
    }
    /**
     * Initiate our hooks
     * @since 0.1.0
     */
    public function hooks() {
        add_action( 'admin_init', array( $this, 'init' ) );
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
        add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
    }
    /**
     * Register our setting to WP
     * @since  0.1.0
     */
    public function init() {
        register_setting( $this->key, $this->key );
    }
    /**
     * Add menu options page
     * @since 0.1.0
     */
    public function add_options_page() {
        //$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
        $this->options_page = add_submenu_page( 'kt_capnel_page',$this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
        // Include CMB CSS in the head to avoid FOUC
        add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
    }
    /**
     * Admin page markup. Mostly handled by CMB2
     * @since  0.1.0
     */
    public function admin_page_display() {
        ?>
        <div class="container-option <?php echo $this->key; ?>">
            <div class="wrapper">
                <h2 class="kt-page-option-title"><?php echo esc_html( get_admin_page_title() ); ?></h2>
                <div class="kt-box-menu kt_wcsc_seting_wapper">
                    <div class="kt-box-menu-inner">
                        <?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
                    </div>
                </div>
            </div> 
        </div>
        <?php
    }
    /**
     * Add the options metabox to the array of metaboxes
     * @since  0.1.0
     */
    function add_options_page_metabox(){
        // hook in our save notices
        add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );
        $cmb = new_cmb2_box( array(
            'id'         => $this->metabox_id,
            'hookup'     => false,
            'cmb_styles' => false,
            'show_on'    => array(
                // These are important, don't remove
                'key'   => 'options-page',
                'value' => array( $this->key, )
            ),
        ) );
        // Set our CMB2 fields
        $cmb->add_field( array(
            'name' => '',
            'desc' => 'Enable Ajax Serach',
            'id'   => 'kt_wcajs_enable',
            'type' => 'checkbox',
        ) );

        $cmb->add_field( array(
            'name'    => 'Minimum number of characters',
            'desc'    => 'Minimum number of characters required to trigger autosuggest.',
            'default' => '3',
            'id'      => 'kt_wcajs_min_char',
            'type'    => 'text',
        ) );

        $cmb->add_field( array(
            'name'    => 'Maximum number of results',
            'desc'    => 'Maximum number of results showed within the autosuggest box.',
            'default' => '3',
            'id'      => 'kt_wcajs_max_results',
            'type'    => 'text',
        ) );
    }
    /**
     * Register settings notices for display
     *
     * @since  0.1.0
     * @param  int   $object_id Option key
     * @param  array $updated   Array of updated fields
     * @return void
     */
    public function settings_notices( $object_id, $updated ) {
        if ( $object_id !== $this->key || empty( $updated ) ) {
            return;
        }
        add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'kute-toolkit' ), 'updated' );
        settings_errors( $this->key . '-notices' );
    }
    /**
     * Public getter method for retrieving protected/private variables
     * @since  0.1.0
     * @param  string  $field Field to retrieve
     * @return mixed          Field value or exception is thrown
     */
    public function __get( $field ) {
        // Allowed fields to retrieve
        if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
            return $this->{$field};
        }
        throw new Exception( 'Invalid property: ' . $field );
    }
}

function kt_wcajs_get_option( $key = '' , $default = "" ) {
    $options = get_option('kt_wcajs_options',true);
    if( !$options ){
        return $default;
    }
    if( isset($options[$key]) && $options[$key] ){
        return $options[$key];
    }
    return $default;
    
}

/**
 * Helper function to get/return the KT_WCSC_SETTINGS object
 * @since  0.1.0
 * @return KT_WCSC_SETTINGS object
 */
function kt_wcajs_settings() {
    return KT_WCAJS_SETTINGS::get_instance();
}

kt_wcajs_settings();