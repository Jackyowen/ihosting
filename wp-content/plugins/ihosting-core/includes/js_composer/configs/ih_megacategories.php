<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if( ! class_exists('WooCommerce') ){
    return false;
}
global $kuteToolkit;
class WPBakeryShortCode_ih_megacategories extends KUTETHEME_ShortCodesContainerAbstract {
    /**
     * Parses shortcode attributes and set defaults based on vc_map function relative to shortcode and fields names
     *
     * @param $atts
     *
     * @since 1.0
     * @return array
     */
    public function getAttributes($atts)
    {
        global $kuteToolkit;
        $default_params = vc_map_get_attributes( $this->shortcode, $atts);
        $params = array(
            'title'                         => '',
            'layout'                        => '',
            'kt_uniqid'                     => '',
            'el_class'                      => '',
            'css'                           => '',
            'css_animation'                 => '',
            'animation_delay'               => '',

            'product_image_size'            => '',
            'product_custom_thumb_width'    => '',
            'product_custom_thumb_height'   => '',
        );
        if(isset($default_params['layout']) && $default_params['layout']){
            $params = $kuteToolkit->get_shortcode_attrs($this->shortcode, $default_params['layout'], $params);
        }else{
            $params = $kuteToolkit->get_shortcode_attrs($this->shortcode, 'all', $params);
        }
        $atts = $this->setShortcodeAtts($params);
        return $atts;
    }
    public static function remove_option_attributes($elements){
        global $kuteToolkit;
        if($elements && is_array($elements)){
            foreach ($elements as $element){
                $kt_uniqid = $kuteToolkit->get_shortcode_attr_value($element, 'kt_uniqid');
                if($kt_uniqid){
                    if(get_option($kuteToolkit->hash_key.'-'.$kt_uniqid)){
                        delete_option($kuteToolkit->hash_key.'-'.$kt_uniqid);
                    }
                    if(get_option($kuteToolkit->hash_key.'_script-'.$kt_uniqid)){
                        delete_option($kuteToolkit->hash_key.'_script-'.$kt_uniqid);
                    }
                }
            }
        }
    }
    public function getProducts() {
        $atts = $this->getAtts();
        $args = array();
        if( isset( $atts['per_page'] ) and $atts['per_page'] )
            $args['posts_per_page'] = $atts['per_page'];
        $query_args = $this->woocommerce( $atts, $args );
        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts ) );
        return $products;// '<div class="kt-woocommerce-container ' . esc_attr( $elementClass ) . '">' . $return . '</div>';
    }
}
$attributes_tax = wc_get_attribute_taxonomies();
$attributes = array();
foreach ( $attributes_tax as $attribute ) {
    $attributes[ $attribute->attribute_label ] = $attribute->attribute_name;
}
// CUSTOM PRODUCT SIZE
$product_size_width_list  = array();
$width = 300;
$height = 300;
$crop = 1;
if( function_exists( 'wc_get_image_size' ) ){
    $size = wc_get_image_size( 'shop_catalog' );
    $width   = isset( $size[ 'width' ] ) ? $size[ 'width' ] : $width;
    $height  = isset( $size[ 'height' ] ) ? $size[ 'height' ] : $height;
    $crop    = isset( $size[ 'crop' ] ) ? $size[ 'crop' ] : $crop;
}
for( $i = 100; $i < $width; $i= $i+10){
    array_push($product_size_width_list, $i);
}
$product_size_list = array();
$product_size_list[$width.'x'.$height] = $width.'x'.$height;
foreach( $product_size_width_list as $k => $w ){
    $w = intval( $w );
    if(isset($width) && $width > 0){
        $h = round( $height * $w / $width ) ;
    }else{
        $h = $w;
    }
    $product_size_list[$w.'x'.$h] = $w.'x'.$h;
}
$product_size_list['Custom'] = 'custom';


$params = array(
    array(
        'type'          =>  'textfield',
        'heading'       =>  __( 'Title', 'ihosting-core' ),
        'param_name'    =>  'title',
        'description'   =>  __( 'The title of shortcode', 'ihosting-core' ),
        'admin_label'   =>  true,
        'std'           =>  __( 'Title', 'ihosting-core' ),
    ),
    array(
        "type"          =>  "kt_select_shortcode_layout",
        "heading"       =>  __("Select layout", 'ihosting-core'),
        "param_name"    =>  "layout",
        "value"         =>  'ih_megacategories',
        'std'           =>  'default',
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __( 'Product image thumb size', 'ihosting-core' ),
        'param_name'  => 'product_image_size',
        'value'       => $product_size_list,
        'description' => __( 'Select a size for product', 'ihosting-core' )
    ),
    array(
        "type"        => "kt_number",
        "heading"     => __("Width", 'ihosting-core'),
        "param_name"  => "product_custom_thumb_width",
        "value"       => $width,
        "suffix"      => __("px", 'ihosting-core'),
        "dependency"  => array("element" => "product_image_size", "value" => array( 'custom' )),
    ),
    array(
        "type"        => "kt_number",
        "heading"     => __("Height", 'ihosting-core'),
        "param_name"  => "product_custom_thumb_height",
        "value"       => $height,
        "suffix"      => __("px", 'ihosting-core'),
        "dependency"  => array("element" => "product_image_size", "value" => array( 'custom' )),
    ),
//    animation -------------------------------------------------------------------------------------
    vc_map_add_css_animation(),
    array(
        'type'        => 'textfield',
        'holder'      => 'div',
        'class'       => '',
        'heading'     => esc_html__('Animation Delay', 'ihosting-core'),
        'param_name'  => 'animation_delay',
        'std'         => '0.4',
        'description' => esc_html__('Delay unit is second.', 'ihosting-core'),
        'dependency'  => array(
            'element'   => 'css_animation',
            'not_empty' => true,
        ),
    ),
);
/* Load settings with layout*/
$kuteToolkit->load_shortcode_settings('ih_megacategories', $params);
return array(
    "name"                    =>    __( "Mega categories", 'ihosting-core'),
    "base"                    =>    "ih_megacategories",
    "category"                =>    __('iHosting', 'ihosting-core' ),
    "description"             =>    __( "Multi show", 'ihosting-core'),
    "as_parent"               =>    array( 'only' => 'ih_megacategory,ih_accordion'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element"         =>    true,
    "is_container"            =>    true,
    "js_view"                 =>    "VcColumnView",
    "params"                  =>    $params,
);