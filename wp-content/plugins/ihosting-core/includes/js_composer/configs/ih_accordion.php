<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if( ! class_exists('WooCommerce') ){
    return false;
}
global $kuteToolkit;
class WPBakeryShortCode_ih_accordion extends KUTETHEME_ShortCodeAbstract {
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
            'title'                         =>  '',
            'description'                   =>  '',
        );
        $atts = $this->setShortcodeAtts($params);
        return $atts;
    }
}
$attributes_tax = wc_get_attribute_taxonomies();
$attributes = array();
foreach ( $attributes_tax as $attribute ) {
    $attributes[ $attribute->attribute_label ] = $attribute->attribute_name;
}
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
        "type"        => "textarea",
        "heading"     => __( "Description", 'ihosting-core' ),
        "param_name"  => "description",
        'std'           =>  __( 'Description', 'ihosting-core' ),
    ),
);

/* Load settings with layout*/
$kuteToolkit->load_shortcode_settings('ih_accordion', $params, false);
return array(
    "name"                    =>    __( "IH Accordion", 'ihosting-core'),
    "base"                    =>    "ih_accordion",
    "category"                =>    __('iHosting', 'ihosting-core' ),
    "description"             =>    __( "Show list accordion", 'ihosting-core'),
    "as_child"                =>    array( 'only' => 'ih_megacategories' ),
    "content_element"         =>    true,
    "params"                  =>    $params,
);