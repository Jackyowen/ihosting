<?php

/**
 * Created by PhpStorm.
 * User: Kutethemes
 * Author: Kutethemes
 * Date: 12/04/2016
 * Time: 2:10 CH
 */
class TemplateManager
{
    public $post_type = "template_manager", $submenu_file = "", $dir = "", $meta_data_name = "template_manager", $current_post_type = "", $settings_tab = 'template_manager';
    public function __construct( $post_type = "template_manager", $meta_data_name = "template_manager" )
    {
        global $kuteToolkit;
        $this->post_type = $post_type;
        $this->meta_data_name = $meta_data_name;

        $option_post_type = get_option('template_manager', "template_manager");
        if( $this->post_type != $option_post_type ){
            update_option( 'template_manager', $post_type );
        }
        $option_meta_data = get_option('template_manager_meta_name', "template_manager");
        if( $this->meta_data_name != $option_meta_data ){
            update_option( 'template_manager_meta_name', $meta_data_name );
        }

        $this->dir = dirname( __FILE__ );

        if( $kuteToolkit->gtVC('4.5') ){
            add_action( 'admin_head', array( &$this, 'activation_menu' ) );
            add_action( 'vc_menu_page_build', array( &$this, 'add_submenu' ) );
        }
        add_filter( 'page_row_actions', array( &$this, 'export_template' ) );
    }

    /**
     * Initialize all components in class
     * @author Kutethemes
     * @version 1.0
     */
    public function init() {
        //Export event
        $this->export_event();
        //register_post_type
        $this->register_post_type();
        //Load all hooks necessary
        $this->load_hook();
        //Accept template post type
        $this->template_post_type();
        return $this; // chaining.
    }

    /**
     * Catch event submit export template
     */
    public function export_event(){
        //export
        if ( current_user_can( 'manage_options' ) && isset( $_GET['action'] ) && $_GET['action'] === 'export_template' ) {
            $id = ( isset( $_GET['id'] ) ? $_GET['id'] : null );
            add_action( 'wp_loaded', array_map( array(
                &$this,
                'export'
            ), array( $id ) ) );
        }
    }

    /**
     * Add template post type in the list post type allowed
     * @author Kutethemes
     * @since 1.0
     */
    public function template_post_type(){
        // Add vc template post type into the list of allowed post types for visual composer.
        if ( ( isset( $_GET['post'] ) && $this->is_post_type( get_post_type( $_GET['post'] ) ) ) || ( isset( $_GET['post_type'] ) && $this->is_post_type( $_GET['post_type'] ) ) ) {
            $pt_array = get_option( 'wpb_js_content_types' );
            if ( ! is_array( $pt_array ) || empty( $pt_array ) ) {
                $pt_array = array( $this->get_post_type(), 'page' );
                update_option( 'wpb_js_content_types', $pt_array );
            } elseif ( ! in_array( $this->get_post_type(), $pt_array ) ) {
                $pt_array[] = $this->get_post_type();
                update_option( 'wpb_js_content_types', $pt_array );
            }
            add_action( 'admin_init', array( &$this, 'add_meta_box' ), 1 );
            vc_set_default_editor_post_types( array(
                'page',
                'template_manager'
            ) );
            add_filter( 'vc_role_access_with_post_types_get_state', '__return_true' );
            add_filter( 'vc_role_access_with_backend_editor_get_state', '__return_true' );
            add_filter( 'vc_role_access_with_frontend_editor_get_state', '__return_false' );
            add_filter( 'vc_check_post_type_validation', '__return_true' );
        } else {
            //add_action( 'wp_loaded', array( $this, 'map_shortcode_template' ) );
        }
    }
    /**
     * Create meta box for $this->get_post_type(), with template settings
     * @author Kutethemes
     * @since 1.0
     */
    public function add_meta_box() {
        add_meta_box( 'vas_template_settings_metabox', __( 'Template Settings', "kute-toolkit" ), array(
            &$this,
            'side_output'
        ), $this->get_post_type(), 'side', 'high' );
    }
    /**
     * Sidebar setting for template created
     * @author Kutethemes
     * @since 1.0
     */
    public function side_output() {
        $data = get_post_meta( get_the_ID(), $this->meta_data_name, true );
        $data_post_types = isset( $data['post_type'] ) ? $data['post_type'] : array();
        $post_types = get_post_types( array( 'public' => true ) );
        echo '<div class="misc-pub-section">
            <div class="template_title"><b>' . __( 'Post types', "kute-toolkit" ) . '</b></div>
            <div class="input-append">
                ';
        foreach ( $post_types as $type ) {
            if ( $type != 'attachment' && ! $this->is_post_type( $type ) ) {
                echo '<label><input type="checkbox" name="' . esc_attr( $this->meta_data_name ) . '[post_type][]" value="' . esc_attr( $type ) . '"' . ( in_array( $type, $data_post_types ) ? ' checked="true"' : '' ) . '> ' . ucfirst( $type ) . '</label><br/>';
            }
        }
        echo '</div><p>' . __( 'Select for which post types this template should be available. Default: Available for all post types.', "kute-toolkit" ) . '</p></div>';
        $groups = get_editable_roles();
        $data_user_role = isset( $data['user_role'] ) ? $data['user_role'] : array();
        echo '<div class="misc-pub-section vc_user_role">
            <div class="template_title"><b>' . __( 'Roles', "kute-toolkit" ) . '</b></div>
            <div class="input-append">
                ';
        foreach ( $groups as $key => $g ) {
            echo '<label><input type="checkbox" name="' . $this->meta_data_name . '[user_role][]" value="' . $key . '"' . ( in_array( $key, $data_user_role ) ? ' checked="true"' : '' ) . '> ' . $g['name'] . '</label><br/>';
        }
        echo '</div><p>' . __( 'Select for user roles this template should be available. Default: Available for all user roles.', "kute-toolkit" ) . '</p></div>';
        $this->export_link();
    }

    /**
     * Maps shortcode kt_template
     * @author Kutethemes
     * @since 1.0
     */
    function map_shortcode_template() {
        vc_map(
            array(
                "name" => __( "Template Manager", "kute-toolkit" ),
                "base" => "kt_template",
                "category" => __('Kute Theme', 'kute-toolkit' ),
                "description" => __( 'You can create flexible any template of visual composer, export and import theme in anywhere by Template Manager and then choose in this place', 'kute-toolkit' ),
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => __( "Select template", "kute-toolkit" ),
                        "param_name" => "id",
                        'admin_label' => true,
                        "value" => array( __( 'Choose template', 'js_composer' ) => '' ) + $this->get_template_list(),
                        "description" => __( "Choose which template to load for this location.", "kute-toolkit" )
                    )
                ),
                array(
                    "type"        => "textfield",
                    "heading"     => __( "Extra class name", 'kute-toolkit' ),
                    "param_name"  => "el_class",
                    "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'kute-toolkit' ),
                    'admin_label' => false,
                ),
                "js_view" => 'VcTemplatera'
            )
        );
        add_shortcode( 'kt_template', array( &$this, 'output_shortcode' ) );
    }


    /**
     * function shortcode kt_template
     * @author Kutethemes
     * @since 1.0
     *
     * @param $atts
     * @param string $content
     *
     * @return string
     */
    public function output_shortcode( $atts, $content = '' ) {
        $id = $el_class = $output = '';
        extract( shortcode_atts( array(
            'el_class' => '',
            'id' => ''
        ), $atts ) );
        if ( empty( $id ) ) {
            return $output;
        }
        $my_query = new WP_Query( array( 'post_type' => $this->get_post_type(), 'p' => (int)$id ) );
        while ( $my_query->have_posts() ) {
            $my_query->the_post();
            if( get_the_ID() === (int)$id ) {
                $output .= '<div class="kt_template_shortcode' . ( $el_class ? ' ' . $el_class : '' ) . '">';
                ob_start();
                the_content();
                $output .= ob_end_flush();
                $output .= '</div>';
            }
        }
        wp_reset_query();
        wp_reset_postdata();
        return $output;
    }

    public  function load_hook(){
        // Check for nav controls
        add_filter( 'vc_nav_controls', array( &$this, 'button' ) );
        add_filter( 'vc_nav_front_controls', array( &$this, 'button' ) );

        add_filter( 'vc_settings_tabs', array( &$this, 'add_tab' ) );
        // build settings tab @ER
        add_action( 'vc_settings_tab-' . $this->settings_tab, array( &$this, 'build_tab' ) );

        add_action( 'wp_ajax_vc_template_save_template', array( &$this, 'save_template' ) );
        add_action( 'wp_ajax_vc_template_delete_template', array( &$this, 'delete' ) );
        add_filter( 'vc_templates_render_category', array( &$this, 'render_template_block' ), 10, 2 );
        add_filter( 'vc_templates_render_template', array( &$this, 'render_template_window' ), 10, 2 );

        if ( $this->get_post_type() !== 'vc_grid_item' ) {
            add_filter( 'vc_get_all_templates', array( &$this, 'replace_template' ) );
        }
        add_filter( 'render_frontend_template', array( &$this, 'render_frontend_template' ), 10, 2 );
        add_filter( 'vc_templates_render_backend_template', array( &$this, 'render_backend_template' ), 10, 2 );
        add_action( 'vc_templates_render_backend_template_preview', array( &$this, 'content_preview' ), 10, 2 );
        add_action( 'wp_ajax_wpb_template_manager_load_html', array( &$this, 'load_html' ) ); // used in changeShortcodeParams in templates.js, todo make sure we need this?
        add_action( 'save_post', array( &$this, 'save_metabox' ) );

        add_action( 'vc_frontend_editor_enqueue_js_css', array( &$this, 'assets_frontend' ) );
        add_action( 'vc_backend_editor_enqueue_js_css', array( &$this, 'assets_backend' ) );
    }
    /**
     * Load required js and css files
     * @author Kutethemes
     * @since 1.0
     */
    public function assets() {
        if ( $this->is_valid_post_type() ) {
            $this->assets_frontend();
            $this->assets_backend();
        }
    }
    public function assets_backend() {
        if ( $this->is_valid_post_type() && ( vc_user_access()
                ->part( 'backend_editor' )
                ->can()
                ->get() || $this->is_post_type() )
        ) {
            $this->enqueue_script_grid();
            $dependency = array( 'vc-backend-min-js' );
            wp_register_script( 'vc_plugin_inline_templates', $this->asset_url( 'js/templates_panels.js' ), $dependency, WPB_VC_VERSION, true );
            wp_register_script( 'vc_plugin_templates', $this->asset_url( 'js/templates.js' ), array(), time(), true );
            //wp_register_script( 'vc_plugin_templates', $this->asset_url( 'js/tax-meta-clss.js' ), array(), time(), true );
            wp_localize_script( 'vc_plugin_templates', 'VcTemplateI18nLocale', array(
                'please_enter_templates_name' => __( 'Please enter template name', "kute-toolkit" ),
            ) );
            wp_register_style( 'vc_plugin_template_css', $this->asset_url( 'css/style.css' ), false, '1.1.0' );
            //wp_register_style( 'vc_plugin_template_css', $this->asset_url( 'css/Tax-meta-class.css' ), false, '1.1.0' );
            wp_enqueue_style( 'vc_plugin_template_css' );
            $this->add_template_js();
        }
    }
    public function assets_frontend() {
        if ( $this->is_valid_post_type() && ( vc_user_access()
                ->part( 'frontend_editor' )
                ->can()
                ->get() )
        ) {
            $this->enqueue_script_grid();
            $dependency = array( 'vc-frontend-editor-min-js', );
            wp_register_script( 'vc_plugin_inline_templates', $this->asset_url( 'js/templates_panels.js' ), $dependency, WPB_VC_VERSION, true );
            wp_register_script( 'vc_plugin_templates', $this->asset_url( 'js/templates.js' ), array(), time(), true );
            wp_localize_script( 'vc_plugin_templates', 'VcTemplateI18nLocale', array(
                'please_enter_templates_name' => __( 'Please enter template name', "kute-toolkit" )
            ) );
            wp_register_style( 'vc_plugin_template_css', $this->asset_url( 'css/style.css' ), false, '1.1.0' );
            wp_enqueue_style( 'vc_plugin_template_css' );
            $this->add_template_js();
        }
    }

    /**
     * Add script file for grid
     * @author Kutethemes
     * @since 1.0
     */
    public function enqueue_script_grid() {
        if ( $this->is_post_type() ) {
            wp_enqueue_script( 'wpb_template-manager-grid-id-param-js',
                $this->asset_url( 'js/template-manager-grid-id-param.js' ),
                array( 'wpb_js_composer_js_listeners' ), '1.0', true );
        }
    }
    public function is_valid_post_type() {
        return in_array( get_post_type(), array_merge( vc_editor_post_types(), array( 'template_manager' ) ) );
    }
    /**
     * Url to js/css or image assets of plugin
     * @author Kutethemes
     * @since 1.0
     *
     * @param $file
     *
     * @return string
     */
    public function asset_url( $file ) {
        global $kuteToolkit;
        return $kuteToolkit->getPluginUri() . 'assets/' . $file;
    }
    /**
     * Used to add js in backend/frontend to init template UI functionality
     * @author Kutethemes
     * @since 1.0
     */
    public function add_template_js() {
        wp_enqueue_script( 'vc_plugin_inline_templates' );
        wp_enqueue_script( 'vc_plugin_templates' );
    }
    /**
     * Saves post data in databases after publishing or updating template's post.
     * @author Kutethemes
     * @since 1.0
     *
     * @param $post_id
     *
     * @return bool
     */
    public function save_metabox( $post_id ) {
        if ( ! $this->is_post_type() ) {
            return true;
        }
        if ( isset( $_POST[ $this->meta_data_name ] ) ) {
            $options = isset( $_POST[ $this->meta_data_name ] ) ? (array) $_POST[ $this->meta_data_name ] : Array();
            update_post_meta( (int) $post_id, $this->meta_data_name, $options );
        } else {
            delete_post_meta( (int) $post_id, $this->meta_data_name );
        }

        return true;
    }
    /**
     * used in changeShortcodeParams in templates.js, todo make sure we need this?
     * @author Kutethemes
     * @since 1.0
     */
    public function load_html() {
        if ( ! vc_verify_admin_nonce() || ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) ) {
            die();
        }
        $id = vc_post_param( 'id' );
        $post = get_post( (int) $id );
        if ( ! $post ) {
            die( __( 'Wrong template', 'kute-toolkit' ) );
        }
        if ( $this->is_post_type( $post->post_type ) ) {
            echo $post->post_content;
        }
        die();
    }
    /**
     * Get template content for preview.
     * @author Kutethemes
     * @since 1.0
     *
     * @param $template_id
     * @param $template_type
     *
     * @return string
     */
    public function content_preview( $template_id, $template_type ) {
        if ( $this->get_post_type() === $template_type ) {
            // do something to return output of template
            $post = get_post( $template_id );
            if ( $this->is_post_type( $post->post_type ) ) {
                return $post->post_content;
            }
        }

        return $template_id;
    }
    /**
     * Used to render template for backend
     * @author Kutethemes
     * @since 1.0
     *
     * @param $template_id
     * @param $template_type
     *
     * @return string|int
     */
    public function render_backend_template( $template_id, $template_type ) {
        if ( $this->get_post_type() === $template_type ) {
            // do something to return output of template
            $post = get_post( $template_id );
            if ( $this->is_post_type( $post->post_type ) ) {
                echo $post->post_content;
                die();
            }
        }

        return $template_id;
    }
    /**
     * Used to render template for frontend
     * @author Kutethemes
     * @since 1.0
     *
     * @param $template_id
     * @param $template_type
     *
     * @return string|int
     */
    public function render_frontend_template( $template_id, $template_type ) {
        if ( $this->get_post_type() === $template_type ) {
            // do something to return output of template
            $post = get_post( $template_id );
            if ( $this->is_post_type( $post->post_type ) ) {
                vc_frontend_editor()->enqueueRequired();
                vc_frontend_editor()->setTemplateContent( $post->post_content );
                vc_frontend_editor()->render( 'template' );
                die();
            }
        }

        return $template_id;
    }
    /**
     * Gets list of existing templates. Checks access rules defined by template author.
     * @author Kutethemes
     * @since 1.0
     *
     * @return array
     */
    protected function get_template_list() {
        global $current_user;
        if( function_exists('wp_get_current_user') ){
            wp_get_current_user();
        }elseif('get_currentuserinfo'){
            get_currentuserinfo();
        }
        $current_user_role = isset( $current_user->roles[0] ) ? $current_user->roles[0] : false;
        $list = array();
        $templates = get_posts( array(
            'post_type' => $this->get_post_type(),
            'numberposts' => - 1
        ) );
        $post = get_post( isset( $_POST['post_id'] ) ? $_POST['post_id'] : null );

        foreach ( $templates as $template ) {
            $id = $template->ID;
            $meta_data = get_post_meta( $id, $this->meta_data_name, true );
            $post_types = isset( $meta_data['post_type'] ) ? $meta_data['post_type'] : false;
            $user_roles = isset( $meta_data['user_role'] ) ? $meta_data['user_role'] : false;
            if (
                ( ! $post || ! $post_types || in_array( $post->post_type, $post_types ) )
                && ( ! $current_user_role || ! $user_roles || in_array( $current_user_role, $user_roles ) )
            ) {
                $list[ $template->post_title ] = $id;
            }
        }
        return $list;
    }
    /**
     * Function used to replace old my templates with new templates
     * @author Kutethemes
     * @since 1.0
     *
     * @param array $data
     *
     * @return array
     */
    public function replace_template( array $data ) {
        $templates = $this->get_template_list();
        $template_conf = array();
        foreach ( $templates as $template_name => $template_id ) {
            $template_conf[] = array(
                'unique_id' => $template_id,
                'name'      => $template_name,
                'type'      => $this->get_post_type(),
                // for rendering in backend/frontend with ajax);
            );
        }

        if ( ! empty( $data ) ) {
            $found = false;
            foreach ( $data as $key => $category ) {
                if ( $category['category'] == 'my_templates' ) {
                    $found = true;
                    $data[ $key ]['templates'] = $template_conf;
                }
            }
            if ( ! $found ) {
                $data[] = array(
                    'templates' => $template_conf,
                    'category' => 'kt_templates',
                    'category_name' => __( 'KT Templates', 'kute-toolkit' ),
                    'category_description' => __( 'Append previously saved template to the current layout', 'kute-toolkit' ),
                    'category_weight' => 10,
                );
            }
        } else {
            $data[] = array(
                'templates' => $template_conf,
                'category' => 'kt_templates',
                'category_name' => __( 'KT Templates', 'kute-toolkit' ),
                'category_description' => __( 'Append previously saved template to the current layout', 'kute-toolkit' ),
                'category_weight' => 10,
            );
        }

        return $data;
    }

    /**
     * @author Kutethemes
     * @since 1.0
     *
     * @param $category
     * @return mixed
     */
    public function render_template_block( $category ) {
        if ( $this->get_post_type() === $category['category'] ) {
            if ( vc_user_access()
                    ->part( 'templates' )
                    ->checkStateAny( true, null )
                    ->get()
            ) {
                $category['output'] = '
				<div class="vc_column vc_col-sm-12" data-vc-hide-on-search="true">
					<div class="vc_element_label">' . esc_html( 'Save current layout as a template', 'kute-toolkit' ) . '</div>
					<div class="vc_input-group">
						<input name="padding" class="vc_form-control wpb-textinput vc_panel-templates-name" type="text" value=""
						       placeholder="' . esc_attr( 'Template name', 'kute-toolkit' ) . '">
						<span class="vc_input-group-btn"> <button class="vc_btn vc_btn-primary vc_btn-sm vc_template-save-btn">' . esc_html( 'Save template', 'kute-toolkit' ) . '</button></span>
					</div>
					<span class="vc_description">' . esc_html( 'Save your layout and reuse it on different sections of your website', 'kute-toolkit' ) . '</span>
				</div>';
            }
            $category['output'] .= '<div class="vc_col-md-12">';
            if ( isset( $category['category_name'] ) ) {
                $category['output'] .= '<h3>' . esc_html( $category['category_name'] ) . '</h3>';
            }
            if ( isset( $category['category_description'] ) ) {
                $category['output'] .= '<p class="vc_description">' . esc_html( $category['category_description'] ) . '</p>';
            }
            $category['output'] .= '</div>';
            $category['output'] .= '
			<div class="vc_column vc_col-sm-12">
			<ul class="vc_templates-list-my_templates">';
            if ( ! empty( $category['templates'] ) ) {
                foreach ( $category['templates'] as $template ) {
                    $category['output'] .= visual_composer()->templatesPanelEditor()->renderTemplateListItem($template);
                }
            }
            $category['output'] .= '</ul></div>';
        }

        return $category;
    }

    /**
     * Used to delete template by template id
     * @author Kutethemes
     * @since 1.0
     *
     * @param int $template_id - if provided used, if not provided used vc_post_param('template_id')
     */
    public function delete( $template_id = null ) {
        if ( ! vc_verify_admin_nonce() || ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) ) {
            die();
        }
        $post_id = $template_id ? $template_id : vc_post_param( 'template_id' );
        if ( ! is_null( $post_id ) ) {
            $post = get_post( $post_id );

            if ( ! $post || ! $this->is_post_type( $post->post_type ) ) {
                die( 'failed to delete' );
            } else if( wp_delete_post( $post_id ) ) {
                die( 'deleted' );
            }
        }
        die( 'failed to delete' );
    }
    /**
     * Used to save new template from ajax request in new panel window
     * @author Kutethemes
     * @since 1.0
     *
     */
    public function save_template() {
        global $kuteToolkit;
        if ( ! vc_verify_admin_nonce() || ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) ) {
            die();
        }
        $title = vc_post_param( 'template_name' );
        $content = vc_post_param( 'template' );
        $template_id = $this->create( $title, $content );
        $template_title = get_the_title( $template_id );
        if ( $kuteToolkit->gtVC( '4.8' ) ) {
            echo visual_composer()
                ->templatesPanelEditor()
                ->renderTemplateListItem( array(
                    'name' => $template_title,
                    'unique_id' => $template_id,
                    'type' => $this->get_post_type()
                ) );
        } else {
            echo $this->renderEditor( $template_title, array( 'unique_id' => $template_id ) );
        }
        die();
    }
    /**
     * Hook templates panel window rendering, if template type is templates render it
     * @author Kutethemes
     * @since 1.0
     *
     * @param $template_name
     * @param $template_data
     *
     * @return string
     */
    public function render_template_window( $template_name, $template_data ) {
        if ( $this->get_post_type() === $template_data['type'] ) {
            return $this->renderEditor( $template_name, $template_data );
        }
        return $template_name;
    }

    /**
     * Rendering panel template for window
     * @author Kutethemes
     * @since 1.0
     *
     * @param $template_name
     * @param $template_data
     *
     * @return string
     */
    public function renderEditor( $template_name, $template_data ) {
        global $kuteToolkit;
        ob_start();
        if ( $kuteToolkit->gtVC( '4.8' ) ) {
            $template_id = esc_attr( $template_data['unique_id'] );
            $template_id_hash = md5( $template_id ); // needed for jquery target for TTA
            $template_name = esc_html( $template_name );
            $delete_template_title = esc_attr( 'Delete template', 'kute-toolkit' );
            $preview_template_title = esc_attr( 'Preview template', 'kute-toolkit' );
            $add_template_title = esc_attr( 'Add template', 'kute-toolkit' );
            $edit_template_title = esc_attr( 'Edit template', 'kute-toolkit' );
            $template_url = esc_attr( admin_url( 'post.php?post=' . $template_data['unique_id'] . '&action=edit' ) );
            $edit_tr_html = '';
            if ( vc_user_access()
                        ->part( 'templates' )
                        ->checkStateAny( true, null )
                        ->get()
            ) {
                $edit_tr_html = <<<EDTR
				<a href="$template_url"  class="vc_general vc_ui-control-button" title="$edit_template_title" target="_blank">
					<i class="vc_ui-icon-pixel vc_ui-icon-pixel-control-edit-dark"></i>
				</a>
				<button type="button" class="vc_general vc_ui-control-button" data-vc-ui-delete="template-title" title="$delete_template_title">
					<i class="vc_ui-icon-pixel vc_ui-icon-pixel-control-trash-dark"></i>
				</button>
EDTR;
            }

            echo <<<HTML
			<button type="button" class="vc_ui-list-bar-item-trigger" title="$add_template_title"
					 	data-template-handler=""
						data-vc-ui-element="template-title">$template_name</button>
			<div class="vc_ui-list-bar-item-actions">
				<button type="button" class="vc_general vc_ui-control-button" title="$add_template_title"
					 	data-template-handler="">
					<i class="vc_ui-icon-pixel vc_ui-icon-pixel-control-add-dark"></i>
				</button>$edit_tr_html
				<button type="button" class="vc_general vc_ui-control-button" title="$preview_template_title"
					data-vc-container=".vc_ui-list-bar" data-vc-preview-handler data-vc-target="[data-template_id_hash=$template_id_hash]">
					<i class="vc_ui-icon-pixel vc_ui-preview-icon"></i>
				</button>
			</div>
HTML;
        } else {
            ?>
            <div class="vc_template-wrapper vc_input-group"
                 data-template_id="<?php echo esc_attr( $template_data['unique_id'] ); ?>">
                <a data-template-handler="true" class="vc_template-display-title vc_form-control"
                   data-vc-ui-element="template-title"
                   href="javascript:;"><?php echo esc_html( $template_name ); ?></a>
			<span class="vc_input-group-btn vc_template-icon vc_template-edit-icon"
                  title="<?php esc_attr_e( 'Edit template', 'kute-toolkit' ); ?>"
                  data-template_id="<?php echo esc_attr( $template_data['unique_id'] ); ?>"><a
                    href="<?php echo esc_attr( admin_url( 'post.php?post=' . $template_data['unique_id'] . '&action=edit' ) ); ?>"
                    target="_blank" class="vc_icon"></i></a></span>
			<span class="vc_input-group-btn vc_template-icon vc_template-delete-icon"
                  title="<?php esc_attr_e( 'Delete template', 'kute-toolkit' ); ?>"
                  data-template_id="<?php echo esc_attr( $template_data['unique_id'] ); ?>"><i
                    class="vc_icon"></i></span>
            </div>
            <?php
        }

        return ob_get_clean();
    }

    /**
     * Create templates button on navigation bar.
     * @author Kutethemes
     * @since 1.0
     * @param $buttons
     *
     * @return array
     */
    public function button( $buttons ) {
        global $kuteToolkit;
        if ( $kuteToolkit->gtVC('4.8') && ! vc_user_access()
                ->part( 'templates' )
                ->can()
                ->get()
        ) {
            return $buttons;
        }
        if ( $this->get_current_post_type() == "vc_grid_item" ) {
            return $buttons;
        }

        $new_buttons = array();

        foreach ( $buttons as $button ) {
            if ( $button[0] != 'templates' ) {
                // disable custom css as well but only in template page
                if ( ! $this->is_post_type() || ( $this->is_post_type() && $button[0] != 'custom_css' ) ) {
                    $new_buttons[] = $button;
                }
            } else {
                // @since 4.4 button is available but "Save" Functionality in form is disabled in template post.
                if ( $kuteToolkit->gtVC('4.7') ) {
                    $new_buttons[] = array(
                        'custom_templates',
                        '<li class="vc_navbar-border-right">
                            <a href="#" class="vc_icon-btn vc_template_button"  id="vc-template-editor-button" title="' . __( 'Templates', 'kute-toolkit' ) . '"></a>
                        </li>'
                    );
                } else if ( ! $this->is_post_type() ) {
                    $new_buttons[] = array(
                        'custom_templates',
                        '<li class="vc_navbar-border-right">
                            <a href="#" class="vc_icon-btn vc_template_button"  id="vc-template-editor-button" title="' . __( 'Templates', 'kute-toolkit' ) . '"></a>
                        </li>'
                    );
                }
            }
        }
        return $new_buttons;
    }
    /**
     * Create tab on VC settings page.
     * @author Kutethemes
     * @since 1.0
     * @param $tabs
     *
     * @return array
     */
    public function add_tab( $tabs ) {
        global $kuteToolkit;
        if ( $kuteToolkit->gtVC('4.8') && ! vc_user_access()
                ->part( 'templates' )
                ->can()
                ->get()
        ) {
            return $tabs;
        }
        $tabs[ $this->settings_tab ] = __( 'Template Setting', "kute-toolkit" );

        return $tabs;
    }
    /**
     * Create tab fields in setting page options-general.php?page=vc_settings
     * @author Kutethemes
     * @since 1.0
     *
     * @param Vc_Settings $settings
     */
    public function build_tab( Vc_Settings $settings ) {
        $settings->addSection( $this->settings_tab );
        add_filter( 'vc_setting-tab-form-' . $this->settings_tab, array( &$this, 'setting_form_param'  ) );
        $settings->addField( $this->settings_tab, __( 'Export Templates', "kute-toolkit" ), 'export', array( &$this, 'is_export_sanitize' ), array( &$this, 'export_link' ) );
        $settings->addField( $this->settings_tab, __( 'Import Templates', "kute-toolkit" ), 'import', array( &$this, 'export_field_sanitize' ), array( &$this, 'export_field_export' ) );
    }

    /**
     * Import templates from file to the database by parsing xml file
     * @return bool
     */
    public function export_field_sanitize() {
        $file = isset( $_FILES['import'] ) ? $_FILES['import'] : false;
        if ( $file === false || ! file_exists( $file['tmp_name'] ) ) {
            return false;
        } else {
            $post_types = get_post_types( array( 'public' => true ) );
            $roles = get_editable_roles();
            $templates = simplexml_load_file( $file['tmp_name'] );
            foreach ( $templates as $t ) {
                $template_post_types = $template_user_roles = $meta_data = array();
                $content = (string) $t->content;
                $id = $this->create( (string) $t->title, $content );
                $this->upload_attachment( $id, $content );
                foreach ( $t->post_types as $type ) {
                    $post_type = (string) $type->post_type;
                    if ( in_array( $post_type, $post_types ) ) {
                        $template_post_types[] = $post_type;
                    }
                }
                if ( ! empty( $template_post_types ) ) {
                    $meta_data['post_type'] = $template_post_types;
                }
                foreach ( $t->user_roles as $role ) {
                    $user_role = (string) $role->user_role;
                    if ( in_array( $user_role, $roles ) ) {
                        $template_user_roles[] = $user_role;
                    }
                }
                if ( ! empty( $template_user_roles ) ) {
                    $meta_data['user_role'] = $template_user_roles;
                }
                update_post_meta( (int) $id, $this->meta_data_name, $meta_data );
            }
            @unlink( $file['tmp_name'] );
        }

        return false;
    }
    /**
     * Creates new template.
     * @author Kutethemes
     * @version 1.0
     *
     * @param $title
     * @param $content
     *
     * @return int|WP_Error
     */
    protected function create( $title, $content ) {
        return wp_insert_post( array(
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
            'post_type'   => $this->get_post_type()
        ) );
    }

    /**
     * Upload external media files in a post content to media library.
     *
     * @author Kutethemes
     * @version 1.0
     *
     * @param $post_id
     * @param $content
     *
     * @return bool
     */
    protected function upload_attachment( $post_id, $content ) {
        preg_match_all( '/<img|a[^>]* src|href=[\'"]?([^>\'" ]+)/', $content, $matches );
        foreach ( $matches[1] as $match ) {
            if ( ! empty( $match ) ) {
                $file_array = array();
                $file_array['name'] = basename( $match );
                $tmp_file = download_url( $match );
                $file_array['tmp_name'] = $tmp_file;
                if ( is_wp_error( $tmp_file ) ) {
                    @unlink( $file_array['tmp_name'] );
                    $file_array['tmp_name'] = '';

                    return false;
                }
                $desc = $file_array['name'];
                $id = media_handle_sideload( $file_array, $post_id, $desc );
                if ( is_wp_error( $id ) ) {
                    @unlink( $file_array['tmp_name'] );

                    return false;
                } else {
                    $src = wp_get_attachment_url( $id );
                }
                $content = str_replace( $match, $src, $content );
            }
        }
        wp_update_post( array(
            'ID' => $post_id,
            'post_content' => $content
        ) );

        return true;
    }

    /**
     * Build import file input.
     */
    public function export_field_export() {
        echo '<input type="file" name="import">';
    }

    /**
     * Custom attributes for tab form.
     * @see TemplateManager::buildTab
     * @author Kutethemes
     * @since 1.0
     * @param $params
     *
     * @return string
     */
    public function setting_form_param( $params ) {
        $params .= ' enctype="multipart/form-data"';

        return $params;
    }
    /**
     * Sanitize export field.
     * @return bool
     */
    public function is_export_sanitize() {
        return false;
    }

    /**
     * Builds export link in settings tab.
     */
    public function export_link() {
        $id = get_the_ID();
        $link = "export.php?page=wpb_vc_settings&action=export_template";
        if( $id ){
            $link .= "&id={$id}";
        }
        echo '<a href="'.$link.'" class="button">' . __( 'Download Export File', "kute-toolkit" ) . '</a>';
    }

    /**
     * Create post type $this->post_type and item in the admin menu.
     * @return void
     */
    function register_post_type() {
        register_post_type( $this->get_post_type(),
            array(
                'labels'              => $this->config_post_type(),
                'public'              => false,
                'has_archive'         => false,
                'show_in_nav_menus'   => true,
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'show_ui'             => true,
                'query_var'           => true,
                'capability_type'     => 'post',
                'hierarchical'        => false,
                'menu_position'       => null,
            )
        );
    }
    /**
     * Export existing template in XML format.
     * @author Kutethemes
     * @version 1.0
     * @param int $id (optional) Template ID. If not specified, export all templates
     */
    public function export( $id = null ) {
        $file_name = 'template_manager';
        $xml = '<?xml version="1.0"?><templates>';
        if ( $id ) {
            $posts = get_post( $id );
            if($posts){
                $file_name = $posts->post_title;
                $xml .= $this->export_xmp_file( $posts );
            }
        } else {
            $posts = get_posts( array(
                'post_type' => $this->get_post_type(),
                'numberposts' => - 1
            ), ARRAY_A );
            if( $posts ){
                foreach ( $posts as $post ) {
                    $xml .= $this->export_xmp_file( $post );
                }
            }
        }
        $xml .= '</templates>';
        header( 'Content-Description: File Transfer' );
        header( 'Content-Disposition: attachment; filename='.$file_name.'_' . date( 'dMY' ) . '.xml' );
        header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );
        echo $xml;
        die();
    }

    /**
     * Convert post to xml for export
     * @author Kutethemes
     * @since 1.0
     * @param $template post Template object
     *
     * @return string
     */
    private function export_xmp_file( $post ) {
        $id = $post->ID;
        $meta_data = get_post_meta( $id, $this->meta_data_name, true );
        $post_types = isset( $meta_data['post_type'] ) ? $meta_data['post_type'] : false;
        $user_roles = isset( $meta_data['user_role'] ) ? $meta_data['user_role'] : false;
        $xml = '';
        $xml .= '<template>';
        $xml .= '<title>' . apply_filters( 'the_title_rss', $post->post_title ) . '</title>'
            . '<content>' . $this->wxr_cdata( apply_filters( 'the_content_export', $post->post_content ) ) . '</content>';
        if ( $post_types !== false ) {
            $xml .= '<post_types>';
            foreach ( $post_types as $t ) {
                $xml .= '<post_type>' . $t . '</post_type>';
            }
            $xml .= '</post_types>';
        }
        if ( $user_roles !== false ) {
            $xml .= '<user_roles>';
            foreach ( $user_roles as $u ) {
                $xml .= '<user_role>' . $u . '</user_role>';
            }
            $xml .= '</user_roles>';
        }

        $xml .= '</template>';

        return $xml;
    }

    /**
     * CDATA field type for XML
     * Call function wxr_cdata includes/export.php if file exist
     * @param $str
     *
     * @return string
     */
    function wxr_cdata( $str ) {
        if( function_exists( 'wxr_cdata' ) ){
            return wxr_cdata( $str );
        }
        if ( seems_utf8( $str ) == false ) {
            $str = utf8_encode( $str );
        }

        // $str = ent2ncr(esc_html($str));
        $str = '<![CDATA[' . str_replace( ']]>', ']]]]><![CDATA[>', $str ) . ']]>';

        return $str;
    }
    /**
     * Get post type after ini
     * @author Kutethemes
     * @since 1.0
     * @return string
     */
    public function get_post_type(){
        $post_type = $this->post_type;
        if( ! $post_type ){
            $post_type = 'template_manager';
        }
        return $post_type;
    }
    public function get_current_post_type(){
        if ( $this->current_post_type ) {
            return $this->current_post_type;
        }
        $post_type = false;
        if ( isset( $_GET['post'] ) ) {
            $post_type = get_post_type( $_GET['post'] );
        } else if ( isset( $_GET['post_type'] ) ) {
            $post_type = $_GET['post_type'];
        }
        $this->current_post_type = $post_type;

        return $this->current_post_type;
    }
    /**
     * @return bool
     */
    protected function is_post_type( $type = '' ) {
        return $type ? $type === $this->get_post_type() : get_post_type() === $this->get_post_type();
    }
    /**
     * Export template
     * @author Kutethemes
     * @since 1.0
     * @param $actions
     * @return mixed
     */
    public function export_template( $actions ) {
        $post = get_post();

        if ( $this->post_type === get_post_type( $post->ID ) ) {
            $url = 'export.php?page=wpb_vc_settings&action=export_template&id=' . $post->ID;
            $actions['vc_export_template'] = '<a href="' . $url . '">' . __( 'Export', 'js_composer' ) . '</a>';
        }

        return $actions;
    }

    /**
     * Add sub menu page in vc_wellcome or vc_general
     * @author Kutethemes
     * @version 1.0
     */
    public function add_submenu(){
        global $kuteToolkit;
        if( $kuteToolkit->gtVC('4.8') || vc_user_access()
                ->part( 'templates' )
                ->checkStateAny( true, null )
                ->get() ){
            $labels = $this->config_post_type();
            add_submenu_page( VC_PAGE_MAIN_SLUG, $labels['name'], $labels['name'], 'manage_options', 'edit.php?post_type=' . rawurlencode( $this->post_type ), '' );
        }
    }

    /**
     * Config Sub menu page
     * @author Kutethemes
     * @version 1.0
     * @return array
     */
    public function config_post_type(){
        return array(
            'name'               => __( 'Templates',          'kute-toolkit' ),
            'add_new_item'       => __( 'Add template',       'kute-toolkit' ),
            'singular_name'      => __( 'Template',           'kute-toolkit' ),
            'edit_item'          => __( 'Edit Template',      'kute-toolkit' ),
            'view_item'          => __( 'View Template',      'kute-toolkit' ),
            'search_items'       => __( 'Search Templates',   'kute-toolkit' ),
            'not_found'          => __( 'No Templates found', 'kute-toolkit' ),
            'not_found_in_trash' => __( 'No Templates found in Trash', 'kute-toolkit' ),
        );
    }
    /**
     * Active current menu
     * @author Kutethemes
     * @version 1.0
     */
    public function activation_menu(){
        global $post_type;
        if ( $post_type === $this->post_type && ( ! defined( 'VC_IS_TEMPLATE_PREVIEW' ) || ! VC_IS_TEMPLATE_PREVIEW ) ) {
            $this->submenu_file = 'edit.php?post_type=' . rawurlencode( $this->post_type );
        }
    }
}