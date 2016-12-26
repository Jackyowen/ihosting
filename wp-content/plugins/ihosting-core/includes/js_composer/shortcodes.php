<?php
/**
 * @author  Kutethemes
 * @package ALESIA
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if( ! class_exists( 'KUTETHEME_ShortCode' ) ){
    class KUTETHEME_ShortCode {
        /**
         * Include params list objects and calls all stored activity methods.
         *
         * @since  1.0
         * @access public
         **/
        public $cache = "";
        public $shortcodes = array();
        public function __construct( ) {
            do_action( 'kutetheme_ovic_init_before' );
            add_action( 'vc_backend_editor_render', array( &$this, 'scripts') );
            add_action( 'vc_after_mapping', array( &$this, '__load') );
            add_action( 'after_setup_theme', array( &$this, 'checkVersionVC' ), 1);
            do_action( 'kutetheme_ovic_init_after' );
            //add_action( 'save_post', array(&$this, 'save_post_callback'), 10, 3 );
        }
        public function remove_option_attributes($elements){
            global $kuteToolkit;
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
                                            if(get_option($kuteToolkit->hash_key.'_css-'.$banner_text['title_uniqid']))
                                                delete_option($kuteToolkit->hash_key.'_css-'.$banner_text['title_uniqid']);
                                    }
                        }
                    }
                    $kt_uniqid = $kuteToolkit->get_shortcode_attr_value($element, 'kt_uniqid');
                    if($kt_uniqid){
                        if(get_option($kuteToolkit->hash_key.'_css-'.$kt_uniqid)){
                            delete_option($kuteToolkit->hash_key.'_css-'.$kt_uniqid);
                        }
                        if(get_option($kuteToolkit->hash_key.'_script-'.$kt_uniqid)){
                            delete_option($kuteToolkit->hash_key.'_script-'.$kt_uniqid);
                        }
                    }
                }
            }
        }
        public function save_post_callback($post_id, $post, $update){
            $re_render = false;
            if(isset($_POST['content'])){
                if($_POST['content']){
                    $content = str_replace('\\', '', $_POST['content']);
                    $pattern = '/\[kt_flexible_banner(.*?)\]|\[kt_custom_banner(.*?)\]|\[kt_single_banner(.*?)\]|\[kt_megacategories(.*?)\]|\[kt_woocommerce(.*?)\]|\[kt_banner(.*?)\]|\[kt_blog(.*?)\]|\[kt_call_to_action(.*?)\]|\[kt_container(.*?)\]|\[kt_countdown(.*?)\]|\[kt_featured_box(.*?)\]|\[kt_newsletter(.*?)\]|\[kt_parallax(.*?)\]|\[kt_social(.*?)\]|\[kt_testimonial(.*?)\]/s';
                    if(preg_match_all($pattern, $content, $matches)){

                        $re_render = true;
                        $this->remove_option_attributes($matches[0]);
                    }
                    if($re_render == true){
                        $css_options = trailingslashit (get_template_directory()). 'css/options.css';
                        if(file_exists($css_options)){
                            $file = fopen($css_options, "w");
                            fclose($file);
                            chmod($css_options,0777);
                        }
                        $js_options = trailingslashit (get_template_directory()). 'js/options.js';
                        if(file_exists($js_options)){
                            $file = fopen($js_options, "w");
                            fclose($file);
                            chmod($js_options,0777);
                        }
                    }
                }
            }
        }
        /**
         * load param autocomplete render
         * */
        public function __load() {
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_megacategories_ids_callback', array(&$this, 'productIdAutocompleteSuggester'), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_megacategories_ids_render', array(&$this, 'productIdAutocompleteRender'), 10, 1 );  //Render exact product. Must return an array (label,value).
            add_filter( 'vc_autocomplete_kt_megacategory_ids_callback', array(&$this, 'productIdAutocompleteSuggester'), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_megacategory_ids_render', array(&$this, 'productIdAutocompleteRender'), 10, 1 );  //Render exact product. Must return an array (label,value).
            add_action( 'wp_ajax_vc_woocommerce_get_attribute_terms', array(
                &$this,
                'getAttributeTermsAjax',
            ) );
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_single_banner_id_callback', array(
                &$this,
                'productIdAutocompleteSuggester',
            ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_single_banner_id_render', array(
                &$this,
                'productIdAutocompleteRender',
            ), 10, 1 ); // Render exact product. Must return an array (label,value)
            //For param: ID default value filter
            add_filter( 'vc_form_fields_render_field_kt_single_banner_id_param_value', array(
                &$this,
                'productIdDefaultValue',
            ), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_banner_product_id_callback', array(
                &$this,
                'productIdAutocompleteSuggester',
            ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_banner_product_id_render', array(
                &$this,
                'productIdAutocompleteRender',
            ), 10, 1 );  //Render exact product. Must return an array (label,value).
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_deals_of_day_ids_callback', array(
                &$this,
                'productIdAutocompleteSuggester',
            ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_deals_of_day_ids_render', array(
                &$this,
                'productIdAutocompleteRender',
            ), 10, 1 );  //Render exact product. Must return an array (label,value).
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_deals_of_day_taxonomy_callback', array(
                &$this,
                'productCategoryCategoryAutocompleteSuggesterBySlug',
            ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_deals_of_day_taxonomy_render', array(
                &$this,
                'productCategoryCategoryRenderBySlugExact',
            ), 10, 1 ); // Render exact category by Slug. Must return an array (label,value)
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_products_ids_callback', array(
                &$this,
                'productIdAutocompleteSuggester',
            ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_products_ids_render', array(
                &$this,
                'productIdAutocompleteRender',
            ), 10, 1 );  //Render exact product. Must return an array (label,value).
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_woocommerce_ids_callback', array(
                &$this,
                'productIdAutocompleteSuggester',
            ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_woocommerce_ids_render', array(
                &$this,
                'productIdAutocompleteRender',
            ), 10, 1 );  //Render exact product. Must return an array (label,value).
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_menu_product_ids_callback', array(
                &$this,
                'productIdAutocompleteSuggester',
            ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_menu_product_ids_render', array(
                &$this,
                'productIdAutocompleteRender',
            ), 10, 1 );  //Render exact product. Must return an array (label,value).
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_woocommerce_taxonomy_callback', array(
                &$this,
                'productCategoryCategoryAutocompleteSuggesterBySlug',
            ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_woocommerce_taxonomy_render', array(
                &$this,
                'productCategoryCategoryRenderBySlugExact',
            ), 10, 1 ); // Render exact category by Slug. Must return an array (label,value)
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_products_taxonomy_callback', array(
                &$this,
                'productCategoryCategoryAutocompleteSuggesterBySlug',
            ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_products_taxonomy_render', array(
                &$this,
                'productCategoryCategoryRenderBySlugExact',
            ), 10, 1 ); // Render exact category by Slug. Must return an array (label,value)
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_kt_collection_taxonomy_callback', array(
                &$this,
                'productCategoryCategoryAutocompleteSuggesterBySlug',
            ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_kt_collection_taxonomy_render', array(
                &$this,
                'productCategoryCategoryRenderBySlugExact',
            ), 10, 1 ); // Render exact category by Slug. Must return an array (label,value)
            //For param: "filter" param value
            //vc_form_fields_render_field_{shortcode_name}_{param_name}_param
            add_filter( 'vc_form_fields_render_field_kt_woocommerce_filter_param', array(
                &$this,
                'productAttributeFilterParamValue',
            ), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
            add_filter( 'vc_form_fields_render_field_kt_deals_of_day_filter_param', array(
                &$this,
                'productAttributeFilterParamValue',
            ), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
            add_filter( 'vc_font_container_get_allowed_tags', array(&$this,'kutetheme_ovic_vc_font_container_get_allowed_tags'),1,1 );
        }
        public function kutetheme_ovic_vc_font_container_get_allowed_tags($allowed_tags){
            $allowed_tags[] = 'span';
            $allowed_tags[] = 'lable';
            return $allowed_tags;
        }
        public function loadShortcode(){
            $folder_config = kutetheme_ovic_path_dir( 'SHORTCODES_DIR', 'configs' );
            $folder_template = kutetheme_ovic_path_dir( 'SHORTCODES_DIR', 'templates/' );
            $tags = scandir( $folder_config );
            $this->cache = false;
            $content = array();
            while ( $tag = current( $tags ) ) {
                if ( ! in_array( $tag, array( ".", ".." ) ) ){
                    if ( strlen( $tag )>= 5 && substr( $tag, -4) == '.php' ) {
                        $loaded = $this->loadMap( $tag, $folder_config, $folder_template );
                        if( $loaded ){
                            $content[] = $tag;
                        }
                    }
                }
                next( $tags );
            }
        }
        public function generateMap($file, $content){
            $code = '<?php return (array) json_decode(\'' . json_encode( $content ) . '\') ?>';
            return (bool) file_put_contents( $file, $code );
        }
        /*public function loadMap( $tag, $folder_config, $folder_template ){
            $setting_path = $folder_config .'/'. $tag;
            if( file_exists( $setting_path ) ){
                $settings = include_once( $setting_path );
            }
            return false;
        }*/
        public function loadMap( $tag, $folder_config, $folder_template ){
            $setting_path = $folder_config .'/'. $tag;
            if( file_exists( $setting_path ) ){
                $settings = include_once( $setting_path );
                if( is_array( $settings ) && isset( $settings[ 'base' ] ) && $settings[ 'base' ] ){
                    vc_map( $settings );
                    return true;
                }
            }
            return false;
        }
        /**
         * Check version visualcomposer
         * @author Kutethemes
         * @since 1.0
         **/
        public function checkVersionVC(){
            if( ! defined( 'WPB_VC_VERSION' )){
                return ;
            }
            if( version_compare( WPB_VC_VERSION , '4.2', '<' ) ){
                add_action( 'init', array( &$this, 'params' ), 100 );
            }else{
                add_action( 'vc_after_mapping', array( &$this, 'params' ) );
            }
        }
        /**
         * Custom param for visual composer
         * @author Kutethemes
         * @since 1.0
         **/
        public function params(){
            //vc_shortcodes_theme_templates_dir( get_stylesheet_directory() . '/vc_templates/' );
            global $vc_setting_row, $vc_setting_col, $vc_setting_column_inner, $vc_setting_icon_shortcode;
            vc_add_params( 'vc_icon', $vc_setting_icon_shortcode );
            vc_add_params( 'vc_column', $vc_setting_col );
            vc_add_params( 'vc_column_inner', $vc_setting_column_inner );
            if( function_exists( 'vc_add_shortcode_param' ) ) {
                vc_add_shortcode_param( 'kt_select_image',   array( &$this, 'images_field' ) );
                vc_add_shortcode_param( 'kt_select_preview',   array( &$this, 'select_preview_field' ) );
                vc_add_shortcode_param( 'kt_select_shortcode_layout',   array( &$this, 'kt_select_shortcode_layout_field' ) );
                vc_add_shortcode_param( 'kt_select_product_style',   array( &$this, 'kt_select_product_style_field' ) );
                vc_add_shortcode_param( 'kt_uniqid',                array( &$this, 'kt_uniqid_field' ) );
                vc_add_shortcode_param( 'kt_number' ,        array( &$this, 'number_field' ) );
                vc_add_shortcode_param( 'kt_inputtext_raw_html' ,        array( &$this, 'kt_inputtext_raw_html_field' ) );
                vc_add_shortcode_param( 'kt_categories',     array( &$this, 'categories_field' ) );
                vc_add_shortcode_param( 'kt_nav_menu' ,      array( &$this, 'nav_menu_field' ) );
                vc_add_shortcode_param( 'kt_taxonomy',       array( &$this, 'taxonomy_field' ) );
                vc_add_shortcode_param( 'kt_product_attributes', array( &$this, 'product_attributes' ) );
                vc_add_shortcode_param( 'kt_datetimepicker', array( &$this, 'datetimepicker_field' ) );
                vc_add_shortcode_param( 'kt_posts' ,         array( &$this, 'post_type_field' ) );
                vc_add_shortcode_param( 'kt_animate' ,       array( &$this, 'animate_field' ) );
            }else{
                add_shortcode_param( 'kt_select_image',   array( &$this, 'images_field' ) );
                add_shortcode_param( 'kt_select_preview',   array( &$this, 'select_preview_field' ) );
                add_shortcode_param( 'kt_select_shortcode_layout',   array( &$this, 'kt_select_shortcode_layout_field' ) );
                add_shortcode_param( 'kt_uniqid',               array( &$this, 'kt_uniqid_field' ) );
                add_shortcode_param( 'kt_select_product_style',   array( &$this, 'kt_select_product_style_field' ) );
                add_shortcode_param( 'kt_number' ,        array( &$this, 'number_field' ) );
                add_shortcode_param( 'kt_inputtext_raw_html' ,        array( &$this, 'kt_inputtext_raw_html_field' ) );
                add_shortcode_param( 'kt_categories',     array( &$this, 'categories_field' ) );
                add_shortcode_param( 'kt_nav_menu' ,      array( &$this, 'nav_menu_field' ) );
                add_shortcode_param( 'kt_taxonomy',       array( &$this, 'taxonomy_field' ) );
                add_shortcode_param( 'kt_product_attributes',  array( &$this, 'product_attributes' ) );
                add_shortcode_param( 'kt_datetimepicker', array( &$this, 'datetimepicker_field' ) );
                add_shortcode_param( 'kt_posts' ,         array( &$this, 'post_type_field' ) );
                add_shortcode_param( 'kt_animate' ,       array( &$this, 'animate_field' ) );
            }
        }
        /**
         * Add more setting in shortcode
         * @author Kutethemes
         *
         * @param $settings array setting in shortcode
         * @param $args array setting added more
         * @since 1.0
         *
         */
        public function addSetting( $settings, $args ){
            if( ! isset( $settings[ 'params' ] ) ){
                $settings[ 'params' ] = array();
            }
            if( is_array( $args ) && count( $args ) > 0 ){
                foreach( $args as $arg ){
                    $settings[ 'params' ][] = $arg;
                }
            }
            return $settings;
        }
        public function kt_inputtext_raw_html_field($settings, $value){
            $dependency = '';
            $param_name = isset( $settings[ 'param_name' ] ) ? $settings[ 'param_name' ] : '';
            $type = isset($settings[ 'type ']) ? $settings[ 'type' ] : '';
            $class = isset($settings[ 'class' ]) ? $settings[ 'class' ] : '';
            if( ! $value && isset($settings[ 'std' ]) ){
                $value = $settings[ 'std' ];
            }
            $output = '<input type="text" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.htmlentities( rawurldecode( base64_decode( $value ) ), ENT_COMPAT, 'UTF-8' ).'" '.$dependency.' />';
            return $output;
            //return '<textarea name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textarea_raw_html ' . $settings['param_name'] . ' ' . $settings['type'] . '" rows="2">' . htmlentities( rawurldecode( base64_decode( $value ) ), ENT_COMPAT, 'UTF-8' ) . '</textarea>';
        }
        public function kt_select_product_style_field($settings, $value){
            global $kuteToolkit;
            ob_start();
            // Get menus list
            $shortcodeName = $settings['value'];
            if(!$value) $value = 'default';
            $layoutDir = $kuteToolkit->theme_dir.'woocommerce/product-styles/';
            if($shortcodeName && is_dir($layoutDir)){
                if(file_exists($layoutDir.'layouts.php')){
                    $files = include $layoutDir.'layouts.php';
                }else{
                    $files = scandir($layoutDir);
                }
                if($files && is_array($files)){
                    $uniqeID    = uniqid();
                    $option = '';
                    foreach ($files as $file){
                        if ($file != '.' && $file != '..'){
                            $fileInfo = pathinfo($file);
                            if($fileInfo['extension'] == 'php'){
                                if($value == $fileInfo['filename']){
                                    $option .= '<option selected="selected" value="'.$fileInfo['filename'].'">'.$fileInfo['filename'].'</option>';
                                }else{
                                    $option .= '<option value="'.$fileInfo['filename'].'">'.$fileInfo['filename'].'</option>';
                                }
                            }
                        }
                    }
                }
            }
            ?>
            <div class="kt_select_product_style">
                <select data-layout_uri="<?php echo $kuteToolkit->theme_uri.'woocommerce/product-styles/';  ?>" id="product_style_<?php echo $uniqeID ?>" name="<?php echo $settings['param_name'] ?>" class="wpb_vc_param_value wpb-input wpb-select <?php $settings['param_name'] ?> <?php echo $settings['type'] ?>_field">
                    <?php echo $option; ?>
                </select>
                <?php if( $value ): ?>
                    <img style="margin-top: 10px; max-width: 320px; max-height: 240px" class="product_style_preview" alt="<?php _e('Product style preview', 'kute-toolkit'); ?>" src="<?php echo $kuteToolkit->theme_uri.'woocommerce/product-styles/'.$value.'.jpg';  ?>">
                <?php endif; ?>
            </div>
            <script type="text/javascript">
                var previewUri = '<?php echo $kuteToolkit->theme_uri.'woocommerce/product-styles/';  ?>';
                jQuery("#product_style_<?php echo $uniqeID ?>").change(function(){
                    var value = jQuery(this).val(), layout_uri = jQuery(this).data('layout_uri'), parent = jQuery(this).parent(), img = parent.find('img');;
                    if( value != '' ){
                        if( typeof img == 'undefined'){
                            parent.append('<img style="margin-top: 10px; max-width: 320px; max-height: 240px" class="photo_preview" alt="Product style preview" src="'+layout_uri+value+'.jpg">');
                        }else{
                            img.attr('src', layout_uri+value+'.jpg');
                        }
                    }
                });
            </script>
            <?php
            return ob_get_clean();
        }
        public function kt_select_shortcode_layout_field($settings, $value){
            global $kuteToolkit;
            ob_start();
            // Get menus list
            $shortcodeName = $settings['value'];
            if(!$value) $value = 'default';
            $layoutDir = $kuteToolkit->theme_dir.'settings/shortcodes/'.$shortcodeName.'/';
            if($shortcodeName && is_dir($layoutDir)){
                if(file_exists($layoutDir.'layouts.php')){
                    $files = include $layoutDir.'layouts.php';
                }else{
                    $files = scandir($layoutDir);
                }
                if($files && is_array($files)){
                    $uniqeID    = uniqid();
                    $option = '';
                    foreach ($files as $file){
                        if ($file != '.' && $file != '..'){
                            $fileInfo = pathinfo($file);
                            if($fileInfo['extension'] == 'php'){
                                //echo $layoutDir.$file;
                                $header = $kuteToolkit->get_shortcode_layout_data($shortcodeName, $file);
                                // print_r($header);
                                if($value == $fileInfo['filename']){
                                    $option .= '<option selected="selected" value="'.$fileInfo['filename'].'">'.$header['Name'].'</option>';
                                }else{
                                    $option .= '<option value="'.$fileInfo['filename'].'">'.$header['Name'].'</option>';
                                }
                            }
                        }
                    }
                }
            }
            ?>
            <div class="kt_select_shortcode_layout">
                <select data-layout_uri="<?php echo $kuteToolkit->theme_uri.'settings/shortcodes/'.$shortcodeName.'/';  ?>" id="shortcode_layout_<?php echo $uniqeID ?>" name="<?php echo $settings['param_name'] ?>" class="wpb_vc_param_value wpb-input wpb-select <?php $settings['param_name'] ?> <?php echo $settings['type'] ?>_field">
                    <?php echo $option; ?>
                </select>
                <?php if( $value ): ?>
                    <img style="margin-top: 10px; max-width: 320px;max-height: 240px" class="shortcode_layout_preview" alt="<?php _e('Layout preview', 'kute-toolkit'); ?>" src="<?php echo $kuteToolkit->theme_uri.'settings/shortcodes/'.$shortcodeName.'/'.$value.'.jpg';  ?>">
                <?php endif; ?>
            </div>
            <script type="text/javascript">
                var previewUri = '<?php echo $kuteToolkit->theme_uri.'settings/shortcodes/'.$shortcodeName.'/';  ?>';
                jQuery("#shortcode_layout_<?php echo $uniqeID ?>").change(function(){
                    var value = jQuery(this).val(), layout_uri = jQuery(this).data('layout_uri'), parent = jQuery(this).parent(), img = parent.find('img');;
                    if( value != '' ){
                        if( typeof img == 'undefined'){
                            parent.append('<img style="margin-top: 10px; max-width: 320px; max-height: 240px" class="photo_preview" alt="Layout preview" src="'+layout_uri+value+'.jpg">');
                        }else{
                            img.attr('src', layout_uri+value+'.jpg');
                        }
                    }
                });
            </script>
            <?php
            return ob_get_clean();
        }
        public function images_field( $settings, $value ) { ob_start(); ?>
            <div class="container-kt-select-image">
                <?php foreach( $settings['value'] as $k => $v ): ?>
                    <label class="kt-image-select kt-image-select " for="kt-select-image-<?php echo esc_attr( $v ) ?>">
                        <input name="kt-select-image-<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $v ) ?>" <?php checked($v, $value, 1) ?> id="kt-select-image-<?php echo esc_attr( $v ) ?>"  style="display: none;" type="radio" class="wpb_vc_param_value" />
                        <img src="<?php echo esc_attr( $k ) ?>" alt="<?php echo esc_attr( $v ) ?>" />
                    </label>
                <?php endforeach; ?>
                <img />
            </div>
            <?php
            return ob_get_clean();
        }
        public function select_preview_field($settings, $value) {
            ob_start();
            // Get menus list
            $options = $settings['value'];
            if ( is_array($options) && count($options) > 0 ) : $uniqeID    = uniqid(); ?>
                <div class="container-select_preview">
                    <select id="kt_select_preview-<?php echo $uniqeID ?>" name="<?php echo $settings['param_name'] ?>" class="wpb_vc_param_value wpb-input wpb-select <?php $settings['param_name'] ?> <?php echo $settings['type'] ?>_field">
                        <?php foreach( $options as $k => $op ): $selected = ( $op == $value ) ? ' selected="selected"' : ''; ?>
                            <option value='<?php echo esc_attr( $op )  ?>' <?php echo esc_attr( $selected ) ?>><?php echo esc_attr( $k ) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if( $value ): ?>
                        <img style="margin-top: 10px" class="photo_preview" alt="Select preview control" src="<?php echo kutetheme_ovic_path_uri(); ?>js_composer/assets/imgs/<?php echo $settings['param_name'] ?>_<?php echo esc_attr($value)  ?>.jpg">
                    <?php endif; ?>
                </div>
                <script type="text/javascript">
                    var asset_url = '<?php echo kutetheme_ovic_path_uri(); ?>js_composer/assets/imgs/<?php echo $settings['param_name'] ?>_';
                    jQuery("#kt_select_preview-<?php echo $uniqeID ?>").change(function(){
                        var $control = jQuery(this);
                        var $container = $control.closest('.container-select_preview');
                        var $preview = $container.find('.photo_preview');
                        var $value = $control.val();
                        if( $value != '' ){
                            if( typeof $preview == 'undefined'){
                                $img = jQuery('<img style="margin-top: 10px" class="photo_preview" alt="Select preview control" src="'+asset_url+$value+'.jpg">');
                                $container.append($img);
                            }else{
                                $src = asset_url + $value + '.jpg';
                                $preview.attr('src', $src);
                            }
                        }
                    });
                </script>
            <?php endif;
            return ob_get_clean();
        }
        public function kt_uniqid_field($settings, $value){
            if( ! $value){
                $value = uniqid(hash('crc32', $settings[ 'param_name' ]).'-');
            }
            $output = '<input type="text" class="wpb_vc_param_value textfield" name="'.$settings[ 'param_name' ].'" value="'.esc_attr($value).'" />';
            return $output;
        }
        public function number_field($settings, $value){
            $dependency = '';
            $param_name = isset( $settings[ 'param_name' ] ) ? $settings[ 'param_name' ] : '';
            $type = isset($settings[ 'type ']) ? $settings[ 'type' ] : '';
            $min = isset($settings[ 'min' ]) ? $settings[ 'min' ] : '';
            $max = isset($settings[ 'max' ]) ? $settings[ 'max'] : '';
            $suffix = isset($settings[ 'suffix' ]) ? $settings[ 'suffix' ] : '';
            $class = isset($settings[ 'class' ]) ? $settings[ 'class' ] : '';
            if( ! $value && isset($settings[ 'std' ]) ){
                $value = $settings[ 'std' ];
            }
            $output = '<input type="number" min="'.esc_attr( $min ).'" max="'.esc_attr( $max ).'" class="wpb_vc_param_value textfield ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.esc_attr($value).'" '.$dependency.' style="max-width:100px; margin-right: 10px;" />'.$suffix;
            return $output;
        }
        public function categories_field($settings, $value) {
            $args = array(
                'id'          => $settings['param_name'],
                'name'        => $settings['param_name'],
                'class'       => 'select-category wpb_vc_param_value',
                'hide_empty'  => 1,
                'orderby'     => 'name',
                'order'       => "desc",
                'tab_index'   => true,
                'hierarchical'=> true,
                'echo'        => 0,
                'selected'    => $value
            );
            if( kt_is_wc()){
                $args['taxonomy'] = 'product_cat';
            }
            return wp_dropdown_categories( $args );
        }
        public function nav_menu_field($settings, $value) {
            // Get menus list
            $value_arr = $value;
            if ( ! is_array($value_arr) ) {
                $value_arr = array_map( 'trim', explode(',', $value_arr) );
            }
            ob_start();
            $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
            if ( $menus && !is_wp_error( $menus ) ) : $uniqeID    = uniqid(); ?>
                <select id="kt_nav-<?php echo $uniqeID ?>" multiple="multiple" name="<?php echo $settings['param_name'] ?>" class="wpb_vc_param_value wpb-input wpb-select <?php $settings['param_name'] ?> <?php echo $settings['type'] ?>_field">
                    <?php foreach( $menus as $menu ): $selected = (in_array( $menu->slug, $value_arr )) ? ' selected="selected"' : ''; ?>
                        <option value='<?php echo esc_attr( $menu->slug )  ?>' <?php echo esc_attr( $selected ) ?>><?php echo esc_attr( $menu->name ) ?></option>
                    <?php endforeach; ?>
                </select>
                <script type="text/javascript">jQuery("#kt_nav-<?php echo esc_attr( $uniqeID )  ?>").chosen();</script>
            <?php endif;
            return ob_get_clean();
        }
        public function product_attributes($settings, $value) {
            // Get attributes list
            $value_arr = $value;
            if ( ! is_array($value_arr) ) {
                $value_arr = array_map( 'trim', explode(',', $value_arr) );
            }
            ob_start();
            $multiple = (!empty($settings['multiple'])) ? 'multiple="multiple"' : '';

            $attribute_taxonomies = wc_get_attribute_taxonomies();
            if ( $attribute_taxonomies && !is_wp_error( $attribute_taxonomies ) ) : $uniqeID    = uniqid(); ?>
                <select id="kt_nav-<?php echo $uniqeID ?>" <?php echo $multiple;?> name="<?php echo $settings['param_name'] ?>" class="wpb_vc_param_value wpb-input wpb-select <?php $settings['param_name'] ?> <?php echo $settings['type'] ?>_field">
                    <?php foreach( $attribute_taxonomies as $attr ):
                        $selected = (in_array( $attr->attribute_name, $value_arr )) ? ' selected="selected"' : '';
                        ?>
                        <option value='<?php echo esc_attr( $attr->attribute_name )  ?>' <?php echo esc_attr( $selected ) ?> ><?php echo esc_attr( $attr->attribute_label ) ?></option>
                    <?php endforeach; ?>
                </select>
                <script type="text/javascript">jQuery("#kt_nav-<?php echo esc_attr( $uniqeID )  ?>").chosen();</script>
            <?php endif;
            return ob_get_clean();
        }
        public function taxonomy_field($settings, $value) {
            $dependency = '';
            $value_arr = $value;
            if ( ! is_array($value_arr) ) {
                $value_arr = array_map( 'trim', explode(',', $value_arr) );
            }
            $output = '';
            if( isset( $settings['hide_empty'] ) && $settings['hide_empty'] ){
                $settings['hide_empty'] = 1;
            }else{
                $settings['hide_empty'] = 0;
            }
            if ( ! empty($settings['taxonomy']) ) {
                $terms_fields = array();
                if(isset($settings['placeholder']) && $settings['placeholder']){
                    $terms_fields[] = "<option value=''>".$settings['placeholder']."</option>";
                }
                $terms = get_terms( $settings['taxonomy'] , array('hide_empty' => false, 'parent' => $settings['parent'], 'hide_empty' => $settings['hide_empty'] ));
                if ( $terms && !is_wp_error($terms) ) {
                    foreach( $terms as $term ) {
                        $selected = (in_array( $term->slug, $value_arr )) ? ' selected="selected"' : '';
                        $terms_fields[] = "<option value='{$term->slug}' {$selected}>{$term->name}</option>";
                    }
                }
                $size = (!empty($settings['size'])) ? 'size="'.$settings['size'].'"' : '';
                $multiple = (!empty($settings['multiple'])) ? 'multiple="multiple"' : '';
                $uniqeID    = uniqid();
                $output = '<select id="kt_taxonomy-'.$uniqeID.'" '.$multiple.' '.$size.' name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field" '.$dependency.'>'
                    .implode( $terms_fields )
                    .'</select>';
                $output .= '<script type="text/javascript">jQuery("#kt_taxonomy-' . $uniqeID . '").chosen();</script>';
            }
            return $output;
        }
        public function datetimepicker_field( $settings, $value )
        {
            $dependency = '';
            $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
            $type = isset($settings['type']) ? $settings['type'] : '';
            $class = isset($settings['class']) ? $settings['class'] : '';
            $uni = uniqid();
            $output = '<div class="kt-datetime"><input id="kt-date-time'.$uni.'" data-format="yyyy/MM/dd hh:mm:ss" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" style="width:258px;" value="'.$value.'" '.$dependency.'/><div class="add-on" >  <i data-time-icon="Defaults-time" data-date-icon="Defaults-time"></i></div></div>';
            $output .= '<script type="text/javascript">
        		jQuery(document).ready(function(){
        			jQuery("#kt-date-time'.$uni.'").datetimepicker();
        		})
        		</script>';
            return $output;
        }
        public function post_type_field( $settings, $value ) {
            $dependency = '';
            $value_arr = $value;
            if ( ! is_array($value_arr) ) {
                $value_arr = array_map( 'trim', explode(',', $value_arr) );
            }
            $output = '';
            if( isset( $settings['hide_empty'] ) && $settings['hide_empty'] ){
                $settings['hide_empty'] = 1;
            }else{
                $settings['hide_empty'] = 0;
            }
            $settings['post_type'] = $settings['post_type'] ? $settings['post_type'] : 'post';
            $terms_fields = array();
            if(isset($settings['placeholder']) && $settings['placeholder']){
                $terms_fields[] = "<option value=''>".$settings['placeholder']."</option>";
            }
            $posts = get_posts( array( 'post_type' => 'template', 'posts_per_page' => -1 ));
            if ( $posts && ! is_wp_error( $posts ) ) {
                foreach( $posts as $post ) { setup_postdata( $post );
                    $selected = (in_array( $post->ID, $value_arr )) ? ' selected="selected"' : '';
                    $posts_fields[] = "<option value='{$post->ID}' {$selected}>{$post->post_title}</option>";
                }
            }
            $size = (!empty($settings['size'])) ? 'size="'.$settings['size'].'"' : '';
            $multiple = (!empty($settings['multiple'])) ? 'multiple="multiple"' : '';
            $uniqeID    = uniqid();
            $output = '<select id="kt_post_type-'.$uniqeID.'" '.$multiple.' '.$size.' name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field" '.$dependency.'>'
                .implode( $posts_fields )
                .'</select>';
            $output .= '<script type="text/javascript">jQuery("#kt_post_type-' . $uniqeID . '").chosen();</script>';
            return $output;
        }
        public function animate_field( $settings, $value ) {
            // Animate list
            $animate_arr = array(
                'bounce',
                'flash',
                'pulse',
                'rubberBand',
                'shake',
                'headShake',
                'swing',
                'tada',
                'wobble',
                'jello',
                'bounceIn',
                'bounceInDown',
                'bounceInLeft',
                'bounceInRight',
                'bounceInUp',
                'bounceOut',
                'bounceOutDown',
                'bounceOutLeft',
                'bounceOutRight',
                'bounceOutUp',
                'fadeIn',
                'fadeInDown',
                'fadeInDownBig',
                'fadeInLeft',
                'fadeInLeftBig',
                'fadeInRight',
                'fadeInRightBig',
                'fadeInUp',
                'fadeInUpBig',
                'fadeOut',
                'fadeOutDown',
                'fadeOutDownBig',
                'fadeOutLeft',
                'fadeOutLeftBig',
                'fadeOutRight',
                'fadeOutRightBig',
                'fadeOutUp',
                'fadeOutUpBig',
                'flipInX',
                'flipInY',
                'flipOutX',
                'flipOutY',
                'lightSpeedIn',
                'lightSpeedOut',
                'rotateIn',
                'rotateInDownLeft',
                'rotateInDownRight',
                'rotateInUpLeft',
                'rotateInUpRight',
                'rotateOut',
                'rotateOutDownLeft',
                'rotateOutDownRight',
                'rotateOutUpLeft',
                'rotateOutUpRight',
                'hinge',
                'rollIn',
                'rollOut',
                'zoomIn',
                'zoomInDown',
                'zoomInLeft',
                'zoomInRight',
                'zoomInUp',
                'zoomOut',
                'zoomOutDown',
                'zoomOutLeft',
                'zoomOutRight',
                'zoomOutUp',
                'slideInDown',
                'slideInLeft',
                'slideInRight',
                'slideInUp',
                'slideOutDown',
                'slideOutLeft',
                'slideOutRight',
                'slideOutUp',
            );
            $uniqeID    = uniqid();
            ob_start();
            ?>
            <select id="kt_animate-<?php echo $uniqeID ?>" name="<?php echo $settings['param_name'] ?>" class="wpb_vc_param_value wpb-input wpb-select <?php echo $settings['param_name']; ?> <?php echo $settings['type'] ?>_field">
                <option value=""><?php esc_html_e( 'None', 'kute-toolkit' ) ?></option>
                <?php foreach( $animate_arr as $animate ):
                    $selected = ( $value == $animate ) ? ' selected="selected"' : '';
                    ?>
                    <option value='<?php echo esc_attr( $animate)  ?>' <?php echo esc_attr( $selected ) ?>><?php echo esc_attr( $animate ) ?></option>
                <?php endforeach; ?>
            </select>
            <?php
            return ob_get_clean();
        }
        public function scripts(){
            wp_enqueue_script( 'chosen-js', kutetheme_ovic_path_uri().'js_composer/assets/js/chosen/chosen.jquery.min.js', array( 'jquery' ), '1.4.2', true );
            wp_enqueue_script( 'datetimepicker-js', kutetheme_ovic_path_uri() . 'js_composer/assets/js/jquery-ui-timepicker-addon.js', array( 'jquery' ), '1.5.0', true );
            wp_enqueue_style( 'chosen-css', kutetheme_ovic_path_uri() .'js_composer/assets/js/chosen/chosen.css' );
            wp_enqueue_style( 'kt_style_css', kutetheme_ovic_path_uri() .'js_composer/assets/css/style.css' );
            wp_enqueue_script( 'kt_script_js', kutetheme_ovic_path_uri() . 'js_composer/assets/js/function.js', array( 'jquery' ), '1.5.0', true );
        }
        /**
         * Suggester for autocomplete by id/name/title/sku
         * @since 1.0
         *
         * @param $query
         * @author Kutethemes
         * @return array - id's from products with title/sku.
         */
        public function productIdAutocompleteSuggester( $query ) {
            global $wpdb;
            $product_id = (int) $query;
            $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
    					FROM {$wpdb->posts} AS a
    					LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
    					WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );
            $results = array();
            if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
                foreach ( $post_meta_infos as $value ) {
                    $data = array();
                    $data['value'] = $value['id'];
                    $data['label'] = __( 'Id', 'js_composer' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . __( 'Title', 'js_composer' ) . ': ' . $value['title'] : '' ) . ( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $value['sku'] : '' );
                    $results[] = $data;
                }
            }
            return $results;
        }
        /**
         * Find product by id
         * @since 1.0
         *
         * @param $query
         * @author Angels.IT
         *
         * @return bool|array
         */
        public function productIdAutocompleteRender( $query ) {
            $query = trim( $query['value'] ); // get value from requested
            if ( ! empty( $query ) ) {
                // get product
                $product_object = wc_get_product( (int) $query );
                if ( is_object( $product_object ) ) {
                    $product_sku = $product_object->get_sku();
                    $product_title = $product_object->get_title();
                    $product_id = $product_object->id;
                    $product_sku_display = '';
                    if ( ! empty( $product_sku ) ) {
                        $product_sku_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $product_sku;
                    }
                    $product_title_display = '';
                    if ( ! empty( $product_title ) ) {
                        $product_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $product_title;
                    }
                    $product_id_display = __( 'Id', 'js_composer' ) . ': ' . $product_id;
                    $data = array();
                    $data['value'] = $product_id;
                    $data['label'] = $product_id_display . $product_title_display . $product_sku_display;
                    return ! empty( $data ) ? $data : false;
                }
                return false;
            }
            return false;
        }
        /**
         * Replace single product sku to id.
         * @since 1.0
         *
         * @param $current_value
         * @param $param_settings
         * @param $map_settings
         * @param $atts
         *
         * @author Angels.IT
         * @return bool|string
         */
        public function productIdDefaultValue( $current_value, $param_settings, $map_settings, $atts ) {
            $value = trim( $current_value );
            if ( strlen( trim( $current_value ) ) === 0 && isset( $atts['sku'] ) && strlen( $atts['sku'] ) > 0 ) {
                $value = $this->productIdDefaultValueFromSkuToId( $atts['sku'] );
            }
            return $value;
        }
        /**
         * Suggester for autocomplete to find product category by id/name/slug but return found product category SLUG
         * @since 1.0
         *
         * @param $query
         * @author Angels.IT
         * @return array - slug of products categories.
         */
        public function productCategoryCategoryAutocompleteSuggesterBySlug( $query ) {
            $result = $this->productCategoryCategoryAutocompleteSuggester( $query, true );
            return $result;
        }
        /**
         * Search product category by slug.
         * @since 1.0
         *
         * @param $query
         * @author Angels.IT
         * @return bool|array
         */
        public function productCategoryCategoryRenderBySlugExact( $query ) {
            $query = $query['value'];
            $query = trim( $query );
            if( is_numeric($query) ){
                $term = get_term_by( 'ID', $query, 'product_cat' );
            }else{
                $term = get_term_by( 'slug', $query, 'product_cat' );
            }
            return $this->productCategoryTermOutput( $term );
        }
        /**
         * Search product category by id
         * @since 1.0
         *
         * @param $query
         *
         * @return bool|array
         */
        public function productCategoryCategoryRenderByIdExact( $query ) {
            $query = $query['value'];
            $cat_id = (int) $query;
            $term = get_term( $cat_id, 'product_cat' );
            return $this->productCategoryTermOutput( $term );
        }
        /**
         * Defines default value for param if not provided. Takes from other param value.
         * @since 1.0
         *
         * @param array $param_settings
         * @param $current_value
         * @param $map_settings
         * @param $atts
         *
         * @author Angels.IT
         * @return array
         */
        public function productAttributeFilterParamValue( $param_settings, $current_value, $map_settings, $atts ) {
            if ( isset( $atts['attribute'] ) ) {
                $value = $this->getAttributeTerms( $atts['attribute'] );
                if ( is_array( $value ) && ! empty( $value ) ) {
                    $param_settings['value'] = $value;
                }
            }
            return $param_settings;
        }
        /**
         * Get attribute terms hooks from ajax request
         * @since 1.0
         */
        public function getAttributeTermsAjax() {
            vc_user_access()
                ->checkAdminNonce()
                ->validateDie()
                ->wpAny( 'edit_posts', 'edit_pages' )
                ->validateDie();
            $attribute = vc_post_param( 'attribute' );
            $values = $this->getAttributeTerms( $attribute );
            $param = array(
                'param_name' => 'filter',
                'type' => 'checkbox',
            );
            $param_line = '';
            foreach ( $values as $label => $v ) {
                $param_line .= ' <label class="vc_checkbox-label"><input id="' . $param['param_name'] . '-' . $v . '" value="' . $v . '" class="wpb_vc_param_value ' . $param['param_name'] . ' ' . $param['type'] . '" type="checkbox" name="' . $param['param_name'] . '"' . '> ' . $label . '</label>';
            }
            die( json_encode( $param_line ) );
        }
        /**
         * Return product category value|label array
         *
         * @since 1.0
         *
         * @param $term
         *
         * @author Angels.IT
         * @return array|bool
         */
        protected function productCategoryTermOutput( $term ) {
            if( ! is_object($term) ) return false;
            $term_slug = $term->slug;
            $term_title = $term->name;
            $term_id = $term->term_id;
            $term_slug_display = '';
            if ( ! empty( $term_slug ) ) {
                $term_slug_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $term_slug;
            }
            $term_title_display = '';
            if ( ! empty( $term_title ) ) {
                $term_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $term_title;
            }
            $term_id_display = __( 'Id', 'js_composer' ) . ': ' . $term_id;
            $data = array();
            $data['value'] = $term_id;
            $data['label'] = $term_id_display . $term_title_display . $term_slug_display;
            return ! empty( $data ) ? $data : false;
        }
        /**
         * Get attribute terms suggester
         * @since 1.0
         *
         * @param $attribute
         *
         * @author Angels.IT
         * @return array
         */
        public function getAttributeTerms( $attribute ) {
            $terms = get_terms( 'pa_' . $attribute ); // return array. take slug
            $data = array();
            if ( ! empty( $terms ) && empty( $terms->errors ) ) {
                foreach ( $terms as $term ) {
                    $data[ $term->name ] = $term->slug;
                }
            }
            return $data;
        }
        /**
         * Autocomplete suggester to search product category by name/slug or id.
         * @since 1.0
         *
         * @param $query
         * @param bool $slug - determines what output is needed
         *      default false - return id of product category
         *      true - return slug of product category
         * @author Angels.IT
         * @return array
         */
        public function productCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
            global $wpdb;
            $cat_id = (int) $query;
            $query = trim( $query );
            $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
    						FROM {$wpdb->term_taxonomy} AS a
    						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
    						WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );
            $result = array();
            if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
                foreach ( $post_meta_infos as $value ) {
                    $data = array();
                    $data['value'] = $slug ? $value['slug'] : $value['id'];
                    $data['label'] = __( 'Id', 'js_composer' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'js_composer' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'js_composer' ) . ': ' . $value['slug'] : '' );
                    $result[] = $data;
                }
            }
            return $result;
        }
        /**
         * Return ID of product by provided SKU of product.
         * @since 1.0
         *
         * @param $query
         *
         * @author Angels.IT
         * @return bool
         */
        public function productIdDefaultValueFromSkuToId( $query ) {
            $result = $this->productIdAutocompleteSuggesterExactSku( $query );
            return isset( $result['value'] ) ? $result['value'] : false;
        }
        /**
         * Find product by SKU
         * @since 1.0
         *
         * @param $query
         *
         * @author Angels.IT
         * @return bool|array
         */
        public function productIdAutocompleteSuggesterExactSku( $query ) {
            global $wpdb;
            $query = trim( $query );
            $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", stripslashes( $query ) ) );
            $product_data = get_post( $product_id );
            if ( 'product' !== $product_data->post_type ) {
                return '';
            }
            $product_object = wc_get_product( $product_data );
            if ( is_object( $product_object ) ) {
                $product_sku = $product_object->get_sku();
                $product_title = $product_object->get_title();
                $product_id = $product_object->id;
                $product_sku_display = '';
                if ( ! empty( $product_sku ) ) {
                    $product_sku_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $product_sku;
                }
                $product_title_display = '';
                if ( ! empty( $product_title ) ) {
                    $product_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $product_title;
                }
                $product_id_display = __( 'Id', 'js_composer' ) . ': ' . $product_id;
                $data = array();
                $data['value'] = $product_id;
                $data['label'] = $product_id_display . $product_title_display . $product_sku_display;
                return ! empty( $data ) ? $data : false;
            }
            return false;
        }
    }
}
/**
 * KUTETHEME core class
 * @version 1.0
 * @package KUTETHEME Shortcode Container
 */
if( ! class_exists( 'KUTETHEME_ShortCodesContainerAbstract' ) ){
    class KUTETHEME_ShortCodesContainerAbstract extends WPBakeryShortCodesContainer {
        public static $frontend_js = array();
        public static $fronend_css = array();
        /**
         * @author Kutethemes
         *
         * @version 1.0
         * @param $settings
         */
        public function __construct( $settings ) {
            parent::__construct( $settings );
        }
        /**
         * Get param value by providing key
         * @author Kutethemes
         * @param $key
         *
         * @since 1.0
         * @return array|bool
         */
        protected function getParamData( $key ) {
            return WPBMap::getParam( $this->shortcode, $key );
        }
        /**
         * @author Kutethemes
         * get value Font Data
         *
         * @version 1.0
         * @return array
         */
        public function getFontData(){
            $atts = $this->getAtts();
            $google_fonts = $font_container = "";
            extract( $atts );
            $google_fonts_field = $this->getParamData( 'google_fonts' );
            $font_container_field = $this->getParamData( 'font_container' );
            $font_container_obj = new Vc_Font_Container();
            $google_fonts_obj = new Vc_Google_Fonts();
            $font_container_field_settings = isset( $font_container_field['settings'], $font_container_field['settings']['fields'] ) ? $font_container_field['settings']['fields'] : array();
            $google_fonts_field_settings = isset( $google_fonts_field['settings'], $google_fonts_field['settings']['fields'] ) ? $google_fonts_field['settings']['fields'] : array();
            $font_container_data = $font_container_obj->_vc_font_container_parse_attributes( $font_container_field_settings, $font_container );
            $google_fonts_data = strlen( $google_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings, $google_fonts ) : '';
            return array(
                'font_container_data' => $font_container_data,
                'google_fonts_data' => $google_fonts_data,
            );
        }
        /**
         * Enqueue JS CSS in the front-end
         * @author Kutethemes
         * @since 1.0
         */
        public function assets(){
            if( is_page() ){
                if ( ! empty( $this->settings['frontend_enqueue_js'] ) ) {
                    $this->registerFrontEndJs( $this->settings['frontend_enqueue_js'] );
                }
                if ( ! empty( $this->settings['frontend_enqueue_css'] ) ) {
                    $this->registerFrontEndCss( $this->settings['frontend_enqueue_css'] );
                }
            }
        }
        /**
         * @author Kutethemes
         *
         * @version 1.0
         * @param $param
         *
         */
        public function registerFrontEndJs( $param, $name ="" ){
            if ( is_array( $param ) && ! empty( $param ) ) {
                foreach ( $param as $k => $value ) {
                    $this->registerFrontEndJs( $value, $k );
                }
            } elseif ( is_string( $param ) && ! empty( $param ) ) {
                if( ! $name || is_numeric( $name ) )
                    $name = 'frontend_enqueue_js_' . md5( $param );
                self::$frontend_js[] = $name;
                wp_register_script( $name, $param, array( 'jquery' ), KUTE_TOOLKIT_VERSION, true );
                wp_enqueue_script( $name );
            }
        }
        /**
         * @author Kutethemes
         *
         * @version 1.0
         * @param $param
         */
        public function registerFrontEndCss( $param, $name = "" ) {
            if ( is_array( $param ) && ! empty( $param ) ) {
                foreach ( $param as $k => $value ) {
                    $this->registerFrontEndCss( $value, $k );
                }
            } elseif ( is_string( $param ) && ! empty( $param ) ) {
                if( ! $name || is_numeric( $name ) )
                    $name = 'frontend_enqueue_css_' . md5( $param );
                self::$fronend_css[] = $name;
                wp_register_style( $name, $param, array( 'kutetheme-style' ), KUTE_TOOLKIT_VERSION );
                wp_enqueue_style( $name );
            }
        }
        /**
         * Parses shortcode attributes and set defaults based on vc_map function relative to shortcode and fields names
         * @author Kutethemes
         * @param $atts
         *
         * @since 1.0
         * @return string
         */
        public function getCustomClass( $atts ){
            $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
            $el_class = $css ="";
            extract( $atts );
            $class_to_filter = ' ';
            if( isset( $css_animation ) ){
                $class_to_filter.= $this->getCSSAnimation( $css_animation );
            }
            $elementClass = array(
                'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts ),
                'extra' => $this->getExtraClass( $el_class ),
                'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
            );
            $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
            return $elementClass;
        }
        /**
         * extract arguement from content shortcode
         * @author Kutethemes
         *
         * @since 1.0
         * @param $tag string shortcode tag
         * @param $text string content shortcode is needed extract param
         */
        public function getContentAttributes( $tag, $text ) {
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
        public function get_styles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) {
            $styles = array();
            if ( ! empty( $font_container_data ) && isset( $font_container_data['values'] ) ) {
                foreach ( $font_container_data['values'] as $key => $value ) {
                    if ( 'tag' !== $key && strlen( $value ) ) {
                        if ( preg_match( '/description/', $key ) ) {
                            continue;
                        }
                        if ( 'font_size' === $key || 'line_height' === $key ) {
                            $value = preg_replace( '/\s+/', '', $value );
                        }
                        if ( 'font_size' === $key ) {
                            $pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
                            // allowed metrics: http://www.w3schools.com/cssref/css_units.asp
                            $regexr = preg_match( $pattern, $value, $matches );
                            $value = isset( $matches[1] ) ? (float) $matches[1] : (float) $value;
                            $unit = isset( $matches[2] ) ? $matches[2] : 'px';
                            $value = $value . $unit;
                        }
                        if ( strlen( $value ) > 0 ) {
                            $styles[] = str_replace( '_', '-', $key ) . ': ' . $value;
                        }
                    }
                }
            }
            if ( ( ! isset( $atts['use_theme_fonts'] ) || 'yes' !== $atts['use_theme_fonts'] ) && ! empty( $google_fonts_data ) && isset( $google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'] ) ) {
                $google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
                $styles[] = 'font-family:' . $google_fonts_family[0];
                $google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
                $styles[] = 'font-weight:' . $google_fonts_styles[1];
                $styles[] = 'font-style:' . $google_fonts_styles[2];
            }
            /**
             * Filter 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' to change vc_custom_heading class
             *
             * @param string - filter_name
             * @param string - element_class
             * @param string - shortcode_name
             * @param array - shortcode_attributes
             *
             * @since 4.3
             */
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_custom_heading ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
            return array(
                'css_class' => trim( preg_replace( '/\s+/', ' ', $css_class ) ),
                'styles' => $styles,
            );
        }
        public function generate_carousel_data_attributes($prefix = 'default_', $atts){
            $result = '';
            if(isset($atts[$prefix.'autoplay']))
                $result .= 'data-autoplay="'.$atts[$prefix.'autoplay'].'" ';
            if(isset($atts[$prefix.'navigation']))
                $result .= 'data-nav="'.$atts[$prefix.'navigation'].'" ';
            if(isset($atts[$prefix.'dots']))
                $result .= 'data-dots="'.$atts[$prefix.'dots'].'" ';
            if(isset($atts[$prefix.'loop']))
                $result .= 'data-loop="'.$atts[$prefix.'loop'].'" ';
            if(isset($atts[$prefix.'slidespeed']))
                $result .= 'data-slidespeed="'.$atts[$prefix.'slidespeed'].'" ';
            if(isset($atts[$prefix.'items']))
                $result .= 'data-items="'.$atts[$prefix.'items'].'" ';
            $margin = 0;
            if(isset($atts[$prefix.'margin']))
                $margin = $atts[$prefix.'margin'];
            $result .= 'data-margin="'.$margin.'" ';
            $responsive = '';
            if(isset($atts[$prefix.'ts_items'])){
                $responsive .= '"0":{"items":'.$atts[$prefix.'ts_items'].', ';
                if(isset($atts[$prefix.'ts_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'ts_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'xs_items'])){
                $responsive .= '"480":{"items":'.$atts[$prefix.'xs_items'].', ';
                if(isset($atts[$prefix.'xs_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'xs_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'sm_items'])){
                $responsive .= '"768":{"items":'.$atts[$prefix.'sm_items'].', ';
                if(isset($atts[$prefix.'sm_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'sm_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'md_items'])){
                $responsive .= '"992":{"items":'.$atts[$prefix.'md_items'].', ';
                if(isset($atts[$prefix.'md_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'md_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'lg_items'])){
                $responsive .= '"1200":{"items":'.$atts[$prefix.'lg_items'].', ';
                if(isset($atts[$prefix.'lg_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'lg_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if($responsive){
                $responsive = substr($responsive, 0, strlen($responsive)-2);
                $result .= ' data-responsive = \'{'.$responsive.'}\'';
            }
            return $result;
        }
        public function render_carousel($prefix = 'default_', $atts, $class_name){
            $result = '{';
            if(isset($atts[$prefix.'autoplay']))
                $result .= "autoplay:".$atts[$prefix.'autoplay'].', ';
            if(isset($atts[$prefix.'navigation']))
                $result .= "nav:".$atts[$prefix.'navigation'].', ';
            if(isset($atts[$prefix.'dots']))
                $result .= "dots:".$atts[$prefix.'dots'].', ';
            if(isset($atts[$prefix.'loop']))
                $result .= "loop:".$atts[$prefix.'loop'].', ';
            if(isset($atts[$prefix.'center']))
                $result .= "center:".$atts[$prefix.'center'].', ';
            if(isset($atts[$prefix.'mousedrag']))
                $result .= "mouseDrag:".$atts[$prefix.'mousedrag'].', ';
            if(isset($atts[$prefix.'touchdrag']))
                $result .= "touchDrag:".$atts[$prefix.'touchdrag'].', ';
            if(isset($atts[$prefix.'pulldrag']))
                $result .= "pullDrag:".$atts[$prefix.'pulldrag'].', ';
            if(isset($atts[$prefix.'freedrag']))
                $result .= "freeDrag:".$atts[$prefix.'freedrag'].', ';
            if(isset($atts[$prefix.'stagepadding']))
                $result .= "stagePadding:".$atts[$prefix.'stagepadding'].', ';
            if(isset($atts[$prefix.'merge']))
                $result .= "merge:".$atts[$prefix.'merge'].', ';
            if(isset($atts[$prefix.'mergefit']))
                $result .= "mergeFit:".$atts[$prefix.'mergefit'].', ';
            if(isset($atts[$prefix.'autowidth']))
                $result .= "autoWidth:".$atts[$prefix.'autowidth'].', ';
            if(isset($atts[$prefix.'startposition']))
                $result .= "startPosition:".$atts[$prefix.'startposition'].', ';
            if(isset($atts[$prefix.'urlhashlistener']))
                $result .= "URLhashListener:".$atts[$prefix.'urlhashlistener'].', ';
            if(isset($atts[$prefix.'navrewind']))
                $result .= "navRewind:".$atts[$prefix.'navrewind'].', ';
            if(isset($atts[$prefix.'navtext']))
                $result .= "navText:".$atts[$prefix.'navtext'].', ';
            else
                $result .= "navText:['',''], ";
            if(isset($atts[$prefix.'slideby']))
                $result .= "slideBy:".$atts[$prefix.'slideby'].', ';
            if(isset($atts[$prefix.'dotseach']))
                $result .= "dotsEach:".$atts[$prefix.'dotseach'].', ';
            if(isset($atts[$prefix.'dotdata']))
                $result .= "dotData:".$atts[$prefix.'dotdata'].', ';
            if(isset($atts[$prefix.'lazyload']))
                $result .= "lazyLoad:".$atts[$prefix.'lazyload'].', ';
            if(isset($atts[$prefix.'lazycontent']))
                $result .= "lazyContent:".$atts[$prefix.'lazycontent'].', ';
            if(isset($atts[$prefix.'autoplaytimeout']))
                $result .= "autoplayTimeout:".$atts[$prefix.'autoplaytimeout'].', ';
            if(isset($atts[$prefix.'autoplayhoverpause']))
                $result .= "autoplayHoverPause:".$atts[$prefix.'autoplayhoverpause'].', ';
            if(isset($atts[$prefix.'smartspeed']))
                $result .= "smartSpeed:".$atts[$prefix.'smartspeed'].', ';
            if(isset($atts[$prefix.'fluidspeed']))
                $result .= "fluidSpeed:".$atts[$prefix.'fluidspeed'].', ';
            if(isset($atts[$prefix.'autoplayspeed']))
                $result .= "autoplaySpeed:".$atts[$prefix.'autoplayspeed'].', ';
            if(isset($atts[$prefix.'navspeed']))
                $result .= "navSpeed:".$atts[$prefix.'navspeed'].', ';
            if(isset($atts[$prefix.'dotsSpeed']))
                $result .= "dotsspeed:".$atts[$prefix.'dotsspeed'].', ';
            if(isset($atts[$prefix.'dragendspeed']))
                $result .= "dragEndSpeed:".$atts[$prefix.'dragendspeed'].', ';
            if(isset($atts[$prefix.'callbacks']))
                $result .= "callbacks:".$atts[$prefix.'callbacks'].', ';
            if(isset($atts[$prefix.'responsiverefreshrate']))
                $result .= "responsiveRefreshRate:".$atts[$prefix.'responsiverefreshrate'].', ';
            if(isset($atts[$prefix.'responsivebaseelement']))
                $result .= "responsiveBaseElement:".$atts[$prefix.'responsivebaseelement'].', ';
            if(isset($atts[$prefix.'responsiveclass']))
                $result .= "responsiveClass:".$atts[$prefix.'responsiveclass'].', ';
            if(isset($atts[$prefix.'video']))
                $result .= "video:".$atts[$prefix.'video'].', ';
            if(isset($atts[$prefix.'videoheight']))
                $result .= "videoHeight:".$atts[$prefix.'videoheight'].', ';
            if(isset($atts[$prefix.'videowidth']))
                $result .= "videoWidth:".$atts[$prefix.'videowidth'].', ';
            if(isset($atts[$prefix.'fallbackEasing']))
                $result .= "fallbackeasing:".$atts[$prefix.'fallbackeasing'].', ';
            if(isset($atts[$prefix.'itemelement']))
                $result .= "itemElement:".$atts[$prefix.'itemelement'].', ';
            if(isset($atts[$prefix.'stageelement']))
                $result .= "stageElement:".$atts[$prefix.'stageelement'].', ';
            if(isset($atts[$prefix.'navcontainer']))
                $result .= "navContainer:".$atts[$prefix.'navcontainer'].', ';
            if(isset($atts[$prefix.'dotscontainer']))
                $result .= "dotsContainer:".$atts[$prefix.'dotscontainer'].', ';
            if(isset($atts[$prefix.'slidespeed']))
                $result .= "slidespeed:".$atts[$prefix.'slidespeed'].', ';
            if(isset($atts[$prefix.'items']))
                $result .= "items:".$atts[$prefix.'items'].', ';
            if(isset($atts[$prefix.'animateout']))
                $result .= "animateOut:'".$atts[$prefix.'animateout']."', ";
            if(isset($atts[$prefix.'animatein']))
                $result .= "animateIn:'".$atts[$prefix.'animatein']."', ";
            $margin = 0;
            if(isset($atts[$prefix.'margin']))
                $margin = $atts[$prefix.'margin'];
            $result .= "margin:".$margin.', ';
            $responsive = '';
            if(isset($atts[$prefix.'ts_items'])){
                $responsive .= '"0":{"items":'.$atts[$prefix.'ts_items'].', ';
                if(isset($atts[$prefix.'ts_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'ts_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'xs_items'])){
                $responsive .= '"480":{"items":'.$atts[$prefix.'xs_items'].', ';
                if(isset($atts[$prefix.'xs_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'xs_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'sm_items'])){
                $responsive .= '"768":{"items":'.$atts[$prefix.'sm_items'].', ';
                if(isset($atts[$prefix.'sm_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'sm_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'md_items'])){
                $responsive .= '"992":{"items":'.$atts[$prefix.'md_items'].', ';
                if(isset($atts[$prefix.'md_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'md_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'lg_items'])){
                $responsive .= '"1200":{"items":'.$atts[$prefix.'lg_items'].', ';
                if(isset($atts[$prefix.'lg_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'lg_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if($responsive){
                $responsive = substr($responsive, 0, strlen($responsive)-2);
                $result .= 'responsive:{'.$responsive.'}';
            }
            $result .= '}';
            return 'if($(".'.$class_name.'").length >0){$(".'.$class_name.'").owlCarousel('.$result.')}';
        }
        public function render_data_carousel($prefix = 'default_', $atts){
            $result = '';
            if(isset($atts[$prefix.'autoplay']))
                $result .= ' data-autoplay="'.$atts[$prefix.'autoplay'].'"';
            if(isset($atts[$prefix.'navigation']))
                $result .= ' data-nav="'.$atts[$prefix.'navigation'].'"';
            if(isset($atts[$prefix.'dots']))
                $result .= 'data-dots="'.$atts[$prefix.'dots'].'"';
            if(isset($atts[$prefix.'loop']))
                $result .= ' data-loop="'.$atts[$prefix.'loop'].'"';
            if(isset($atts[$prefix.'center']))
                $result .= ' data-center="'.$atts[$prefix.'center'].'"';
            if(isset($atts[$prefix.'mousedrag']))
                $result .= ' data-mouseDrag="'.$atts[$prefix.'mousedrag'].'"';
            if(isset($atts[$prefix.'touchdrag']))
                $result .= ' data-touchDrag="'.$atts[$prefix.'touchdrag'].'"';
            if(isset($atts[$prefix.'pulldrag']))
                $result .= ' data-pullDrag="'.$atts[$prefix.'pulldrag'].'"';
            if(isset($atts[$prefix.'freedrag']))
                $result .= ' data-freeDrag="'.$atts[$prefix.'freedrag'].'"';
            if(isset($atts[$prefix.'stagepadding']))
                $result .= ' data-stagePadding="'.$atts[$prefix.'stagepadding'].'"';
            if(isset($atts[$prefix.'merge']))
                $result .= ' data-merge="'.$atts[$prefix.'merge'].'"';
            if(isset($atts[$prefix.'mergefit']))
                $result .= ' data-mergeFit="'.$atts[$prefix.'mergefit'].'"';
            if(isset($atts[$prefix.'autowidth']))
                $result .= ' data-autoWidth="'.$atts[$prefix.'autowidth'].'"';
            if(isset($atts[$prefix.'startposition']))
                $result .= ' data-startPosition="'.$atts[$prefix.'startposition'].'"';
            if(isset($atts[$prefix.'urlhashlistener']))
                $result .= ' data-URLhashListener="'.$atts[$prefix.'urlhashlistener'].'"';
            if(isset($atts[$prefix.'navrewind']))
                $result .= ' data-$prefix="'.$atts[$prefix.'navrewind'].'"';
            if(isset($atts[$prefix.'navtext']))
                $result .= ' data-navText="'.$atts[$prefix.'navtext'].'"';
            /*else
                $result .= ' data-navText="[<i class=\'fa fa-angle-left\'></i>,<i class=\'fa fa-angle-right\'></i>]"';*/
            if(isset($atts[$prefix.'slideby']))
                $result .= ' data-slideBy="'.$atts[$prefix.'slideby'].'"';
            if(isset($atts[$prefix.'dotseach']))
                $result .= ' data-dotsEach="'.$atts[$prefix.'dotseach'].'"';
            if(isset($atts[$prefix.'dotdata']))
                $result .= ' data-dotData="'.$atts[$prefix.'dotdata'].'"';
            if(isset($atts[$prefix.'lazyload']))
                $result .= ' data-lazyLoad="'.$atts[$prefix.'lazyload'].'"';
            if(isset($atts[$prefix.'lazycontent']))
                $result .= ' data-lazyContent="'.$atts[$prefix.'lazycontent'].'"';
            if(isset($atts[$prefix.'autoplaytimeout']))
                $result .= ' data-autoplayTimeout="'.$atts[$prefix.'autoplaytimeout'].'"';
            if(isset($atts[$prefix.'autoplayhoverpause']))
                $result .= ' data-autoplayHoverPause="'.$atts[$prefix.'autoplayhoverpause'].'"';
            if(isset($atts[$prefix.'smartspeed']))
                $result .= ' data-smartSpeed="'.$atts[$prefix.'smartspeed'].'"';
            if(isset($atts[$prefix.'fluidspeed']))
                $result .= ' data-fluidSpeed="'.$atts[$prefix.'fluidspeed'].'"';
            if(isset($atts[$prefix.'autoplayspeed']))
                $result .= ' data-autoplaySpeed="'.$atts[$prefix.'autoplayspeed'].'"';
            if(isset($atts[$prefix.'navspeed']))
                $result .= ' data-navSpeed="'.$atts[$prefix.'navspeed'].'"';
            if(isset($atts[$prefix.'dotsspeed']))
                $result .= ' data-dotsSpeed="'.$atts[$prefix.'dotsspeed'].'"';
            if(isset($atts[$prefix.'dragendspeed']))
                $result .= ' data-dragEndSpeed="'.$atts[$prefix.'dragendspeed'].'"';
            if(isset($atts[$prefix.'callbacks']))
                $result .= ' data-callbacks="'.$atts[$prefix.'callbacks'].'"';
            if(isset($atts[$prefix.'responsiverefreshrate']))
                $result .= ' data-responsiveRefreshRate="'.$atts[$prefix.'responsiverefreshrate'].'"';
            if(isset($atts[$prefix.'responsivebaseelement']))
                $result .= ' data-responsiveBaseElement="'.$atts[$prefix.'responsivebaseelement'].'"';
            if(isset($atts[$prefix.'responsiveclass']))
                $result .= ' data-responsiveClass="'.$atts[$prefix.'responsiveclass'].'"';
            if(isset($atts[$prefix.'video']))
                $result .= ' data-video="'.$atts[$prefix.'video'].'"';
            if(isset($atts[$prefix.'videoheight']))
                $result .= ' data-videoHeight="'.$atts[$prefix.'videoheight'].'"';
            if(isset($atts[$prefix.'videowidth']))
                $result .= ' data-videoWidth="'.$atts[$prefix.'videowidth'].'"';
            if(isset($atts[$prefix.'fallbackEasing']))
                $result .= ' data-fallbackeasing="'.$atts[$prefix.'fallbackeasing'].'"';
            if(isset($atts[$prefix.'itemelement']))
                $result .= ' data-itemElement="'.$atts[$prefix.'itemelement'].'"';
            if(isset($atts[$prefix.'stageelement']))
                $result .= ' data-stageElement="'.$atts[$prefix.'stageelement'].'"';
            if(isset($atts[$prefix.'navcontainer']))
                $result .= ' data-navContainer="'.$atts[$prefix.'navcontainer'].'"';
            if(isset($atts[$prefix.'dotscontainer']))
                $result .= ' data-dotsContainer="'.$atts[$prefix.'dotscontainer'].'"';
            if(isset($atts[$prefix.'slidespeed']))
                $result .= ' data-slideSpeed="'.$atts[$prefix.'slidespeed'].'"';
            if(isset($atts[$prefix.'items']))
                $result .= ' data-items="'.$atts[$prefix.'items'].'"';
            if(isset($atts[$prefix.'animateout']))
                $result .= ' data-animateOut="'.$atts[$prefix.'animateout'].'"';
            if(isset($atts[$prefix.'animatein']))
                $result .= ' data-animateIn="'.$atts[$prefix.'animatein'].'"';
            $margin = 0;
            if(isset($atts[$prefix.'margin']))
                $margin = $atts[$prefix.'margin'];
            $result .= 'data-margin="'.$margin.'"';
            $responsive = '';
            if(isset($atts[$prefix.'ts_items'])){
                $responsive .= '"0":{"items":'.$atts[$prefix.'ts_items'].', ';
                if(isset($atts[$prefix.'ts_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'ts_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'xs_items'])){
                $responsive .= '"480":{"items":'.$atts[$prefix.'xs_items'].', ';
                if(isset($atts[$prefix.'xs_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'xs_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'sm_items'])){
                $responsive .= '"768":{"items":'.$atts[$prefix.'sm_items'].', ';
                if(isset($atts[$prefix.'sm_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'sm_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'md_items'])){
                $responsive .= '"992":{"items":'.$atts[$prefix.'md_items'].', ';
                if(isset($atts[$prefix.'md_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'md_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'lg_items'])){
                $responsive .= '"1200":{"items":'.$atts[$prefix.'lg_items'].', ';
                if(isset($atts[$prefix.'lg_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'lg_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if($responsive){
                $responsive = substr($responsive, 0, strlen($responsive)-2);
                $result .= 'data-responsive=\'{'.$responsive.'}\'';
            }
            return $result;
        }
        public function setShortcodeAtts( $shortcode_attributes ){
            $atts = $this->getAtts();
            if( function_exists( 'vc_map_get_attributes' ) ){
                $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
            }
            $atts = shortcode_atts( $shortcode_attributes, $atts );
            $this->atts = $atts;
            if( count( $atts ) > 0 ){
                foreach( $atts as $k=> $v ){
                    $this->$k = $v;
                }
            }
            return $atts;
        }
        /**
         * Generate query
         * @author Kutethemes
         *
         * @param $target
         * @param $args argument of query find all products
         * @param $ignore_sticky_posts
         * @since 1.0
         */
        public function woocommerce( $atts, $args = array(), $ignore_sticky_posts = 1 ){
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
                $ordering_args = WC()->query->get_catalog_ordering_args( );
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
                    $args[ 'orderby' ] = $orderby;
                    $args[ 'order' ]   = $order;
                    if ( ! empty( $ids ) ) {
                        $args['post__in'] = array_map( 'trim', explode( ',', $ids ) );
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
            return $args;
        }
        /**
         * woocommerce_order_by_rating_post_clauses function.
         *
         * @param array $args
         * @return array
         */
        public function order_by_rating_post_clauses( $args ) {
            global $wpdb;
            $args['where']   .= " AND $wpdb->commentmeta.meta_key = 'rating' ";
            $args['join']    .= "LEFT JOIN $wpdb->comments ON($wpdb->posts.ID               = $wpdb->comments.comment_post_ID) LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)";
            $args['orderby'] = "$wpdb->commentmeta.meta_value DESC";
            $args['groupby'] = "$wpdb->posts.ID";
            return $args;
        }
        /**
         * Get attachment by id
         * @author Kutethemes
         * @since 1.0
         */
        public function getAttachment( $banner_image ){
            if( ! $banner_image ){
                return false;
            }
            if( $banner_image ){
                $banner = wp_get_attachment_image_src( $banner_image , 'full' );
                $banner_url =  is_array($banner) ? esc_url($banner[0]) : '';
                return $banner_url;
            }
            return false;
        }
    }
}
/**
 * KUTETHEME core class
 * @version 1.0
 * @package KUTETHEME Shortcode
 */
if( ! class_exists( 'KUTETHEME_ShortCodeAbstract' ) ){
    class KUTETHEME_ShortCodeAbstract extends WPBakeryShortCode {
        public static $frontend_js = array();
        public static $fronend_css = array();
        /**
         * @author Kutethemes
         *
         * @version 1.0
         * @param $settings
         */
        public function __construct( $settings ) {
            parent::__construct( $settings );
        }
        /**
         * Get param value by providing key
         * @author Kutethemes
         * @param $key
         *
         * @since 1.0
         * @return array|bool
         */
        protected function getParamData( $key ) {
            return WPBMap::getParam( $this->shortcode, $key );
        }

        /**
         * @author Kutethemes
         * get value Font Data
         *
         * @version 1.0
         * @return array
         */
        public function getFontData(){
            $atts = $this->getAtts();
            $font_container = $google_fonts = "";
            extract( $atts );
            $google_fonts_field = $this->getParamData( 'google_fonts' );
            $font_container_field = $this->getParamData( 'font_container' );
            $font_container_obj = new Vc_Font_Container();
            $google_fonts_obj = new Vc_Google_Fonts();
            $font_container_field_settings = isset( $font_container_field['settings'], $font_container_field['settings']['fields'] ) ? $font_container_field['settings']['fields'] : array();
            $google_fonts_field_settings = isset( $google_fonts_field['settings'], $google_fonts_field['settings']['fields'] ) ? $google_fonts_field['settings']['fields'] : array();
            $font_container_data = $font_container_obj->_vc_font_container_parse_attributes( $font_container_field_settings, $font_container );
            $google_fonts_data = strlen( $google_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings, $google_fonts ) : '';
            return array(
                'font_container_data' => $font_container_data,
                'google_fonts_data' => $google_fonts_data,
            );
        }
        /**
         * Enqueue JS CSS in the front-end
         * @author Kutethemes
         * @since 1.0
         */
        public function assets(){
            if( is_page() ){
                if ( ! empty( $this->settings['frontend_enqueue_js'] ) ) {
                    $this->registerFrontEndJs( $this->settings['frontend_enqueue_js'] );
                }
                if ( ! empty( $this->settings['frontend_enqueue_css'] ) ) {
                    $this->registerFrontEndCss( $this->settings['frontend_enqueue_css'] );
                }
            }
        }
        /**
         * @author Kutethemes
         *
         * @version 1.0
         * @param $param
         *
         */
        public function registerFrontEndJs( $param, $name ="" ){
            if ( is_array( $param ) && ! empty( $param ) ) {
                foreach ( $param as $k => $value ) {
                    $this->registerFrontEndJs( $value, $k );
                }
            } elseif ( is_string( $param ) && ! empty( $param ) ) {
                if( ! $name || is_numeric( $name ) )
                    $name = 'frontend_enqueue_js_' . md5( $param );
                self::$frontend_js[] = $name;
                wp_register_script( $name, $param, array( 'jquery' ), KUTETHEME_ALESIA_VERSION, true );
                wp_enqueue_script( $name );
            }
        }
        /**
         * @author Kutethemes
         *
         * @version 1.0
         * @param $param
         */
        public function registerFrontEndCss( $param, $name = "" ) {
            if ( is_array( $param ) && ! empty( $param ) ) {
                foreach ( $param as $k => $value ) {
                    $this->registerFrontEndCss( $value, $k );
                }
            } elseif ( is_string( $param ) && ! empty( $param ) ) {
                if( ! $name || is_numeric( $name ) )
                    $name = 'frontend_enqueue_css_' . md5( $param );
                self::$fronend_css[] = $name;
                wp_register_style( $name, $param, array( 'kutetheme-style' ), KUTETHEME_ALESIA_VERSION );
                wp_enqueue_style( $name );
            }
        }
        /**
         * Parses shortcode attributes and set defaults based on vc_map function relative to shortcode and fields names
         * @author Kutethemes
         * @param $atts
         *
         * @since 1.0
         * @return string
         */
        public function getCustomClass( $atts ){
            $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
            $el_class = $css = "";
            extract( $atts );
            $class_to_filter = ' ';
            if( isset( $css_animation ) ){
                $class_to_filter.= $this->getCSSAnimation( $css_animation );
            }
            $elementClass = array(
                'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts ),
                'extra' => $this->getExtraClass( $el_class ),
                'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
            );
            $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
            return $elementClass;
        }
        /**
         * extract arguement from content shortcode
         * @author Kutethemes
         *
         * @since 1.0
         * @param $tag string shortcode tag
         * @param $text string content shortcode is needed extract param
         */
        public function getContentAttributes( $tag, $text ) {
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
        public function get_styles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) {
            $styles = array();
            if ( ! empty( $font_container_data ) && isset( $font_container_data['values'] ) ) {
                foreach ( $font_container_data['values'] as $key => $value ) {
                    if ( 'tag' !== $key && strlen( $value ) ) {
                        if ( preg_match( '/description/', $key ) ) {
                            continue;
                        }
                        if ( 'font_size' === $key || 'line_height' === $key ) {
                            $value = preg_replace( '/\s+/', '', $value );
                        }
                        if ( 'font_size' === $key ) {
                            $pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
                            // allowed metrics: http://www.w3schools.com/cssref/css_units.asp
                            $regexr = preg_match( $pattern, $value, $matches );
                            $value = isset( $matches[1] ) ? (float) $matches[1] : (float) $value;
                            $unit = isset( $matches[2] ) ? $matches[2] : 'px';
                            $value = $value . $unit;
                        }
                        if ( strlen( $value ) > 0 ) {
                            $styles[] = str_replace( '_', '-', $key ) . ': ' . $value;
                        }
                    }
                }
            }
            if ( ( ! isset( $atts['use_theme_fonts'] ) || 'yes' !== $atts['use_theme_fonts'] ) && ! empty( $google_fonts_data ) && isset( $google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'] ) ) {
                $google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
                $styles[] = 'font-family:' . $google_fonts_family[0];
                $google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
                $styles[] = 'font-weight:' . $google_fonts_styles[1];
                $styles[] = 'font-style:' . $google_fonts_styles[2];
            }
            /**
             * Filter 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' to change vc_custom_heading class
             *
             * @param string - filter_name
             * @param string - element_class
             * @param string - shortcode_name
             * @param array - shortcode_attributes
             *
             * @since 4.3
             */
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_custom_heading ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
            return array(
                'css_class' => trim( preg_replace( '/\s+/', ' ', $css_class ) ),
                'styles' => $styles,
            );
        }
        public function generate_carousel_data_attributes($prefix = 'default_', $atts){
            $result = '';
            if(isset($atts[$prefix.'autoplay']))
                $result .= 'data-autoplay="'.$atts[$prefix.'autoplay'].'" ';
            if(isset($atts[$prefix.'navigation']))
                $result .= 'data-nav="'.$atts[$prefix.'navigation'].'" ';
            if(isset($atts[$prefix.'dots']))
                $result .= 'data-dots="'.$atts[$prefix.'dots'].'" ';
            if(isset($atts[$prefix.'loop']))
                $result .= 'data-loop="'.$atts[$prefix.'loop'].'" ';
            if(isset($atts[$prefix.'slidespeed']))
                $result .= 'data-slidespeed="'.$atts[$prefix.'slidespeed'].'" ';
            if(isset($atts[$prefix.'items']))
                $result .= 'data-items="'.$atts[$prefix.'items'].'" ';
            if(isset($atts[$prefix.'margin']))
                $margin = $atts[$prefix.'margin'];
            $result .= 'data-margin="'.$margin.'" ';
            $responsive = '';
            if(isset($atts[$prefix.'ts_items'])){
                $responsive .= '"0":{"items":'.$atts[$prefix.'ts_items'].', ';
                if(isset($atts[$prefix.'ts_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'ts_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'xs_items'])){
                $responsive .= '"480":{"items":'.$atts[$prefix.'xs_items'].', ';
                if(isset($atts[$prefix.'xs_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'xs_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'sm_items'])){
                $responsive .= '"768":{"items":'.$atts[$prefix.'sm_items'].', ';
                if(isset($atts[$prefix.'sm_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'sm_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'md_items'])){
                $responsive .= '"992":{"items":'.$atts[$prefix.'md_items'].', ';
                if(isset($atts[$prefix.'md_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'md_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'lg_items'])){
                $responsive .= '"1200":{"items":'.$atts[$prefix.'lg_items'].', ';
                if(isset($atts[$prefix.'lg_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'lg_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if($responsive){
                $responsive = substr($responsive, 0, strlen($responsive)-2);
                $result .= ' data-responsive = \'{'.$responsive.'}\'';
            }
            return $result;
        }
        public function render_carousel($prefix = 'default_', $atts, $class_name){
            $result = '{';
            if(isset($atts[$prefix.'autoplay']))
                $result .= "autoplay:".$atts[$prefix.'autoplay'].', ';
            if(isset($atts[$prefix.'navigation']))
                $result .= "nav:".$atts[$prefix.'navigation'].', ';
            if(isset($atts[$prefix.'dots']))
                $result .= "dots:".$atts[$prefix.'dots'].', ';
            if(isset($atts[$prefix.'loop']))
                $result .= "loop:".$atts[$prefix.'loop'].', ';
            if(isset($atts[$prefix.'center']))
                $result .= "center:".$atts[$prefix.'center'].', ';
            if(isset($atts[$prefix.'mousedrag']))
                $result .= "mouseDrag:".$atts[$prefix.'mousedrag'].', ';
            if(isset($atts[$prefix.'touchdrag']))
                $result .= "touchDrag:".$atts[$prefix.'touchdrag'].', ';
            if(isset($atts[$prefix.'pulldrag']))
                $result .= "pullDrag:".$atts[$prefix.'pulldrag'].', ';
            if(isset($atts[$prefix.'freedrag']))
                $result .= "freeDrag:".$atts[$prefix.'freedrag'].', ';
            if(isset($atts[$prefix.'stagepadding']))
                $result .= "stagePadding:".$atts[$prefix.'stagepadding'].', ';
            if(isset($atts[$prefix.'merge']))
                $result .= "merge:".$atts[$prefix.'merge'].', ';
            if(isset($atts[$prefix.'mergefit']))
                $result .= "mergeFit:".$atts[$prefix.'mergefit'].', ';
            if(isset($atts[$prefix.'autowidth']))
                $result .= "autoWidth:".$atts[$prefix.'autowidth'].', ';
            if(isset($atts[$prefix.'startposition']))
                $result .= "startPosition:".$atts[$prefix.'startposition'].', ';
            if(isset($atts[$prefix.'urlhashlistener']))
                $result .= "URLhashListener:".$atts[$prefix.'urlhashlistener'].', ';
            if(isset($atts[$prefix.'navrewind']))
                $result .= "navRewind:".$atts[$prefix.'navrewind'].', ';
            if(isset($atts[$prefix.'navtext']))
                $result .= "navText:".$atts[$prefix.'navtext'].', ';
            else
                $result .= "navText:['',''],";
            if(isset($atts[$prefix.'slideby']))
                $result .= "slideBy:".$atts[$prefix.'slideby'].', ';
            if(isset($atts[$prefix.'dotseach']))
                $result .= "dotsEach:".$atts[$prefix.'dotseach'].', ';
            if(isset($atts[$prefix.'dotdata']))
                $result .= "dotData:".$atts[$prefix.'dotdata'].', ';
            if(isset($atts[$prefix.'lazyload']))
                $result .= "lazyLoad:".$atts[$prefix.'lazyload'].', ';
            if(isset($atts[$prefix.'lazycontent']))
                $result .= "lazyContent:".$atts[$prefix.'lazycontent'].', ';
            if(isset($atts[$prefix.'autoplaytimeout']))
                $result .= "autoplayTimeout:".$atts[$prefix.'autoplaytimeout'].', ';
            if(isset($atts[$prefix.'autoplayhoverpause']))
                $result .= "autoplayHoverPause:".$atts[$prefix.'autoplayhoverpause'].', ';
            if(isset($atts[$prefix.'smartspeed']))
                $result .= "smartSpeed:".$atts[$prefix.'smartspeed'].', ';
            if(isset($atts[$prefix.'fluidspeed']))
                $result .= "fluidSpeed:".$atts[$prefix.'fluidspeed'].', ';
            if(isset($atts[$prefix.'autoplayspeed']))
                $result .= "autoplaySpeed:".$atts[$prefix.'autoplayspeed'].', ';
            if(isset($atts[$prefix.'navspeed']))
                $result .= "navSpeed:".$atts[$prefix.'navspeed'].', ';
            if(isset($atts[$prefix.'dotsSpeed']))
                $result .= "dotsspeed:".$atts[$prefix.'dotsspeed'].', ';
            if(isset($atts[$prefix.'dragendspeed']))
                $result .= "dragEndSpeed:".$atts[$prefix.'dragendspeed'].', ';
            if(isset($atts[$prefix.'callbacks']))
                $result .= "callbacks:".$atts[$prefix.'callbacks'].', ';
            if(isset($atts[$prefix.'responsiverefreshrate']))
                $result .= "responsiveRefreshRate:".$atts[$prefix.'responsiverefreshrate'].', ';
            if(isset($atts[$prefix.'responsivebaseelement']))
                $result .= "responsiveBaseElement:".$atts[$prefix.'responsivebaseelement'].', ';
            if(isset($atts[$prefix.'responsiveclass']))
                $result .= "responsiveClass:".$atts[$prefix.'responsiveclass'].', ';
            if(isset($atts[$prefix.'video']))
                $result .= "video:".$atts[$prefix.'video'].', ';
            if(isset($atts[$prefix.'videoheight']))
                $result .= "videoHeight:".$atts[$prefix.'videoheight'].', ';
            if(isset($atts[$prefix.'videowidth']))
                $result .= "videoWidth:".$atts[$prefix.'videowidth'].', ';
            if(isset($atts[$prefix.'fallbackEasing']))
                $result .= "fallbackeasing:".$atts[$prefix.'fallbackeasing'].', ';
            if(isset($atts[$prefix.'itemelement']))
                $result .= "itemElement:".$atts[$prefix.'itemelement'].', ';
            if(isset($atts[$prefix.'stageelement']))
                $result .= "stageElement:".$atts[$prefix.'stageelement'].', ';
            if(isset($atts[$prefix.'navcontainer']))
                $result .= "navContainer:".$atts[$prefix.'navcontainer'].', ';
            if(isset($atts[$prefix.'dotscontainer']))
                $result .= "dotsContainer:".$atts[$prefix.'dotscontainer'].', ';
            if(isset($atts[$prefix.'slidespeed']))
                $result .= "slidespeed:".$atts[$prefix.'slidespeed'].', ';
            if(isset($atts[$prefix.'items']))
                $result .= "items:".$atts[$prefix.'items'].', ';
            if(isset($atts[$prefix.'animateout']))
                $result .= "animateOut:'".$atts[$prefix.'animateout']."', ";
            if(isset($atts[$prefix.'animatein']))
                $result .= "animateIn:'".$atts[$prefix.'animatein']."', ";
            $margin = 0;
            if(isset($atts[$prefix.'margin']))
                $margin = $atts[$prefix.'margin'];
            $result .= "margin:".$margin.', ';
            $responsive = '';
            if(isset($atts[$prefix.'ts_items'])){
                $responsive .= '"0":{"items":'.$atts[$prefix.'ts_items'].', ';
                if(isset($atts[$prefix.'ts_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'ts_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'xs_items'])){
                $responsive .= '"480":{"items":'.$atts[$prefix.'xs_items'].', ';
                if(isset($atts[$prefix.'xs_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'xs_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'sm_items'])){
                $responsive .= '"768":{"items":'.$atts[$prefix.'sm_items'].', ';
                if(isset($atts[$prefix.'sm_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'sm_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'md_items'])){
                $responsive .= '"992":{"items":'.$atts[$prefix.'md_items'].', ';
                if(isset($atts[$prefix.'md_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'md_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'lg_items'])){
                $responsive .= '"1200":{"items":'.$atts[$prefix.'lg_items'].', ';
                if(isset($atts[$prefix.'lg_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'lg_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if($responsive){
                $responsive = substr($responsive, 0, strlen($responsive)-2);
                $result .= 'responsive:{'.$responsive.'}';
            }
            $result .= '}';
            return 'if($(".'.$class_name.'").length >0){$(".'.$class_name.'").owlCarousel('.$result.')}';
        }
        public function render_data_carousel($prefix = 'default_', $atts){
            $result = '';
            if(isset($atts[$prefix.'autoplay']))
                $result .= ' data-autoplay="'.$atts[$prefix.'autoplay'].'"';
            if(isset($atts[$prefix.'navigation']))
                $result .= ' data-nav="'.$atts[$prefix.'navigation'].'"';
            if(isset($atts[$prefix.'dots']))
                $result .= 'data-dots="'.$atts[$prefix.'dots'].'"';
            if(isset($atts[$prefix.'loop']))
                $result .= ' data-loop="'.$atts[$prefix.'loop'].'"';
            if(isset($atts[$prefix.'center']))
                $result .= ' data-center="'.$atts[$prefix.'center'].'"';
            if(isset($atts[$prefix.'mousedrag']))
                $result .= ' data-mouseDrag="'.$atts[$prefix.'mousedrag'].'"';
            if(isset($atts[$prefix.'touchdrag']))
                $result .= ' data-touchDrag="'.$atts[$prefix.'touchdrag'].'"';
            if(isset($atts[$prefix.'pulldrag']))
                $result .= ' data-pullDrag="'.$atts[$prefix.'pulldrag'].'"';
            if(isset($atts[$prefix.'freedrag']))
                $result .= ' data-freeDrag="'.$atts[$prefix.'freedrag'].'"';
            if(isset($atts[$prefix.'stagepadding']))
                $result .= ' data-stagePadding="'.$atts[$prefix.'stagepadding'].'"';
            if(isset($atts[$prefix.'merge']))
                $result .= ' data-merge="'.$atts[$prefix.'merge'].'"';
            if(isset($atts[$prefix.'mergefit']))
                $result .= ' data-mergeFit="'.$atts[$prefix.'mergefit'].'"';
            if(isset($atts[$prefix.'autowidth']))
                $result .= ' data-autoWidth="'.$atts[$prefix.'autowidth'].'"';
            if(isset($atts[$prefix.'startposition']))
                $result .= ' data-startPosition="'.$atts[$prefix.'startposition'].'"';
            if(isset($atts[$prefix.'urlhashlistener']))
                $result .= ' data-URLhashListener="'.$atts[$prefix.'urlhashlistener'].'"';
            if(isset($atts[$prefix.'navrewind']))
                $result .= ' data-$prefix="'.$atts[$prefix.'navrewind'].'"';
            if(isset($atts[$prefix.'navtext']))
                $result .= ' data-navText="'.$atts[$prefix.'navtext'].'"';
            /*else
                $result .= ' data-navText="[<i class="fa fa-angle-left"></i>,<i class="fa fa-angle-right"></i>]"';*/
            if(isset($atts[$prefix.'slideby']))
                $result .= ' data-slideBy="'.$atts[$prefix.'slideby'].'"';
            if(isset($atts[$prefix.'dotseach']))
                $result .= ' data-dotsEach="'.$atts[$prefix.'dotseach'].'"';
            if(isset($atts[$prefix.'dotdata']))
                $result .= ' data-dotData="'.$atts[$prefix.'dotdata'].'"';
            if(isset($atts[$prefix.'lazyload']))
                $result .= ' data-lazyLoad="'.$atts[$prefix.'lazyload'].'"';
            if(isset($atts[$prefix.'lazycontent']))
                $result .= ' data-lazyContent="'.$atts[$prefix.'lazycontent'].'"';
            if(isset($atts[$prefix.'autoplaytimeout']))
                $result .= ' data-autoplayTimeout="'.$atts[$prefix.'autoplaytimeout'].'"';
            if(isset($atts[$prefix.'autoplayhoverpause']))
                $result .= ' data-autoplayHoverPause="'.$atts[$prefix.'autoplayhoverpause'].'"';
            if(isset($atts[$prefix.'smartspeed']))
                $result .= ' data-smartSpeed="'.$atts[$prefix.'smartspeed'].'"';
            if(isset($atts[$prefix.'fluidspeed']))
                $result .= ' data-fluidSpeed="'.$atts[$prefix.'fluidspeed'].'"';
            if(isset($atts[$prefix.'autoplayspeed']))
                $result .= ' data-autoplaySpeed="'.$atts[$prefix.'autoplayspeed'].'"';
            if(isset($atts[$prefix.'navspeed']))
                $result .= ' data-navSpeed="'.$atts[$prefix.'navspeed'].'"';
            if(isset($atts[$prefix.'dotsspeed']))
                $result .= ' data-dotsSpeed="'.$atts[$prefix.'dotsspeed'].'"';

            if(isset($atts[$prefix.'dragendspeed']))
                $result .= ' data-dragEndSpeed="'.$atts[$prefix.'dragendspeed'].'"';
            if(isset($atts[$prefix.'callbacks']))
                $result .= ' data-callbacks="'.$atts[$prefix.'callbacks'].'"';
            if(isset($atts[$prefix.'responsiverefreshrate']))
                $result .= ' data-responsiveRefreshRate="'.$atts[$prefix.'responsiverefreshrate'].'"';
            if(isset($atts[$prefix.'responsivebaseelement']))
                $result .= ' data-responsiveBaseElement="'.$atts[$prefix.'responsivebaseelement'].'"';
            if(isset($atts[$prefix.'responsiveclass']))
                $result .= ' data-responsiveClass="'.$atts[$prefix.'responsiveclass'].'"';
            if(isset($atts[$prefix.'video']))
                $result .= ' data-video="'.$atts[$prefix.'video'].'"';
            if(isset($atts[$prefix.'videoheight']))
                $result .= ' data-videoHeight="'.$atts[$prefix.'videoheight'].'"';
            if(isset($atts[$prefix.'videowidth']))
                $result .= ' data-videoWidth="'.$atts[$prefix.'videowidth'].'"';
            if(isset($atts[$prefix.'fallbackEasing']))
                $result .= ' data-fallbackeasing="'.$atts[$prefix.'fallbackeasing'].'"';
            if(isset($atts[$prefix.'itemelement']))
                $result .= ' data-itemElement="'.$atts[$prefix.'itemelement'].'"';
            if(isset($atts[$prefix.'stageelement']))
                $result .= ' data-stageElement="'.$atts[$prefix.'stageelement'].'"';
            if(isset($atts[$prefix.'navcontainer']))
                $result .= ' data-navContainer="'.$atts[$prefix.'navcontainer'].'"';
            if(isset($atts[$prefix.'dotscontainer']))
                $result .= ' data-dotsContainer="'.$atts[$prefix.'dotscontainer'].'"';
            if(isset($atts[$prefix.'slidespeed']))
                $result .= ' data-slideSpeed="'.$atts[$prefix.'slidespeed'].'"';
            if(isset($atts[$prefix.'items']))
                $result .= ' data-items="'.$atts[$prefix.'items'].'"';
            if(isset($atts[$prefix.'animateout']))
                $result .= ' data-animateOut="'.$atts[$prefix.'animateout'].'"';
            if(isset($atts[$prefix.'animatein']))
                $result .= ' data-animateIn="'.$atts[$prefix.'animatein'].'"';
            $margin = 0;
            if(isset($atts[$prefix.'margin']))
                $margin = $atts[$prefix.'margin'];
            $result .= 'data-margin="'.$margin.'"';

            $responsive = '';
            if(isset($atts[$prefix.'ts_items'])){
                $responsive .= '"0":{"items":'.$atts[$prefix.'ts_items'].', ';
                if(isset($atts[$prefix.'ts_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'ts_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'xs_items'])){
                $responsive .= '"480":{"items":'.$atts[$prefix.'xs_items'].', ';
                if(isset($atts[$prefix.'xs_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'xs_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'sm_items'])){
                $responsive .= '"768":{"items":'.$atts[$prefix.'sm_items'].', ';
                if(isset($atts[$prefix.'sm_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'sm_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'md_items'])){
                $responsive .= '"992":{"items":'.$atts[$prefix.'md_items'].', ';
                if(isset($atts[$prefix.'md_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'md_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if(isset($atts[$prefix.'lg_items'])){
                $responsive .= '"1200":{"items":'.$atts[$prefix.'lg_items'].', ';
                if(isset($atts[$prefix.'lg_margin']))
                    $responsive .= '"margin":'.$atts[$prefix.'lg_margin'].'}, ';
                else
                    $responsive .= '"margin":'.$margin.'}, ';
            }
            if($responsive){
                $responsive = substr($responsive, 0, strlen($responsive)-2);
                $result .= 'data-responsive=\'{'.$responsive.'}\'';
            }
            return $result;
        }
        /**
         * @author Kutethemes
         *
         * @param $shortcode_attributes default setting
         * @param $atts
         * @return array
         * @since 1.0
         */
        public function setShortcodeAtts( $shortcode_attributes ){
            $atts = $this->getAtts();
            if( function_exists( 'vc_map_get_attributes' ) ){
                $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
            }
            $atts = shortcode_atts( $shortcode_attributes, $atts );
            $this->atts = $atts;
            if( count( $atts ) > 0 ){
                foreach( $atts as $k=> $v ){
                    $this->$k = $v;
                }
            }
            return $atts;
        }
        /**
         * Generate query
         * @author Kutethemes
         *
         * @param $target
         * @param $args argument of query find all products
         * @param $ignore_sticky_posts
         * @since 1.0
         */
        public function woocommerce( $atts, $args = array(), $ignore_sticky_posts = 1 ){
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
            $args['post_status']         = 'publish';
            $args['ignore_sticky_posts'] = $ignore_sticky_posts;
            $args['suppress_filter']     = true;
            if( ! isset( $orderby ) ){
                $ordering_args = WC()->query->get_catalog_ordering_args( );
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
                    $args[ 'orderby' ] = $orderby;
                    $args[ 'order' ]   = $order;
                    if ( ! empty( $ids ) ) {
                        $args['post__in'] = array_map( 'trim', explode( ',', $ids ) );
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
            return $args;
        }
        /**
         * woocommerce_order_by_rating_post_clauses function.
         *
         * @param array $args
         * @return array
         */
        public function order_by_rating_post_clauses( $args ) {
            global $wpdb;
            $args['where']   .= " AND $wpdb->commentmeta.meta_key = 'rating' ";
            $args['join']    .= "LEFT JOIN $wpdb->comments ON($wpdb->posts.ID               = $wpdb->comments.comment_post_ID) LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)";
            $args['orderby'] = "$wpdb->commentmeta.meta_value DESC";
            $args['groupby'] = "$wpdb->posts.ID";
            return $args;
        }
        /**
         * Get attachment by id
         * @author Kutethemes
         * @param $banner_image id attachment
         * @since 1.0
         */
        public function getAttachment( $banner_image ){
            if( ! $banner_image ){
                return false;
            }
            if( $banner_image ){
                $banner = wp_get_attachment_image_src( $banner_image , 'full' );
                $banner_url =  is_array($banner) ? esc_url($banner[0]) : '';
                return $banner_url;
            }
            return false;
        }
    }
}