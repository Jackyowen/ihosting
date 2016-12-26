<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if( ! class_exists('WooCommerce') ){
    return false;
}
global $kuteToolkit;
class WPBakeryShortCode_ih_megacategory extends KUTETHEME_ShortCodeAbstract {
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
            'subtitle'                      =>  '',
            'description'                   =>  '',
            'auto_manual'                   =>  '',
            'taxonomy'                      =>  '',
            'target'                        =>  '',
            'filter'                        =>  '',
            'attribute'                     =>  '',
            'orderby'                       =>  '',
            'order'                         =>  '',
            'per_page'                      =>  '',
            'ids'                           =>  '',
            'photo'                         =>  '',
            'link'                          =>  ''
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
        "type"        => "textfield",
        "heading"     => __( "Sub title", 'ihosting-core' ),
        "param_name"  => "subtitle",
        'admin_label' => true,
        'std'           =>  __( 'Sub title', 'ihosting-core' ),
    ),
    array(
        "type"        => "textarea",
        "heading"     => __( "Description", 'ihosting-core' ),
        "param_name"  => "description",
        'std'           =>  __( 'Description', 'ihosting-core' ),
    ),
    array(
        "type"        => "kt_taxonomy",
        "taxonomy"    => "product_cat",
        "class"       => "",
        "heading"     => __("Category", 'ihosting-core'),
        "param_name"  => "taxonomy",
        "value"       => '',
        'parent'      => '',
        'multiple'    => false,
        'hide_empty'  => false,
        'placeholder' => __('Choose category', 'ihosting-core'),
        "description" => __("Note: If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'ihosting-core'),
        'std'           =>  '',
    ),
    array(
        'type'        =>    'dropdown',
        'heading'     =>    __( 'Target', 'ihosting-core' ),
        'param_name'  =>    'target',
        'value'       => array(
            __( 'Best Selling Products', 'ihosting-core' ) => 'best-selling',
            __( 'Top Rated Products', 'ihosting-core' )    => 'top-rated',
            __( 'Recent Products', 'ihosting-core' )       => 'recent-product',
            __( 'Product Category', 'ihosting-core' )      => 'product-category',
            __( 'Products', 'ihosting-core' )              => 'products',
            __( 'Featured Products', 'ihosting-core' )     => 'featured_products',
            __( 'Attribute Products', 'ihosting-core' )    => 'product_attribute',
            __( 'On Sale', 'ihosting-core' )               => 'on_sale',
        ),
        'description'   =>  __( 'Choose the target to filter products', 'ihosting-core' ),
        'std'           =>  'recent-product',
    ),
    array(
        'type'           => 'checkbox',
        'heading'        => __( 'Filter', 'ihosting-core' ),
        'param_name'     => 'filter',
        'value'          => array( 'empty' => 'empty' ),
        'save_always'    => true,
        'description'    => __( 'Taxonomy values', 'ihosting-core' ),
        'dependency'     => array(
            'callback'   => 'vcWoocommerceProductAttributeFilterDependencyCallback',
        ),
    ),
    array(
        'type'           => 'dropdown',
        'heading'        => __( 'Attribute', 'ihosting-core' ),
        'param_name'     => 'attribute',
        'value'          => $attributes,
        'save_always'    => true,
        'description'    => __( 'List of product taxonomy attribute', 'ihosting-core' ),
        "dependency"     => array("element" => "target", "value" => array( 'product_attribute' )),
    ),
    array(
        "type"       => "dropdown",
        "heading"    => __("Order by", 'ihosting-core'),
        "param_name" => "orderby",
        "value"      => array(
            '',
            __( 'Date', 'ihosting-core' )      => 'date',
            __( 'ID', 'ihosting-core' )        => 'ID',
            __( 'Author', 'ihosting-core' )    => 'author',
            __( 'Title', 'ihosting-core' )     => 'title',
            __( 'Modified', 'ihosting-core' )  => 'modified',
            __( 'Random', 'ihosting-core' )    => 'rand',
            __( 'Comment count', 'ihosting-core' ) => 'comment_count',
            __( 'Menu order', 'ihosting-core' )    => 'menu_order',
            __( 'Sale price', 'ihosting-core' )    => '_sale_price',
        ),
        'std'         => 'date',
        "description" => __("Select how to sort retrieved posts.",'ihosting-core'),
        "dependency"  => array("element" => "target", "value" => array( 'top-rated', 'recent-product', 'product-category', 'featured_products', 'on_sale', 'product_attribute')),
    ),
    array(
        "type"       => "dropdown",
        "heading"    => __("Order", 'ihosting-core'),
        "param_name" => "order",
        "value"      => array(
            __('ASC', 'ihosting-core')  => 'ASC',
            __('DESC', 'ihosting-core') => 'DESC'
        ),
        'std'         => 'DESC',
        "description" => __("Designates the ascending or descending order.",'ihosting-core'),
        "dependency"  => array("element" => "target", "value" => array( 'top-rated', 'recent-product', 'product-category', 'featured_products', 'on_sale', 'product_attribute')),
    ),
    array(
        'type'        => 'kt_number',
        'heading'     => __( 'Max item', 'ihosting-core' ),
        'param_name'  => 'per_page',
        'value'       => 6,
        "dependency"  => array("element" => "target", "value" => array( 'best-selling', 'top-rated', 'recent-product', 'product-category', 'featured_products', 'product_attribute', 'on_sale')),
    ),
    array(
        'type'               => 'autocomplete',
        'heading'            => __( 'Products', 'ihosting-core' ),
        'param_name'         => 'ids',
        'settings'           => array(
            'multiple'       => true,
            'sortable'       => true,
            'unique_values'  => true,
        ),
        'save_always' => true,
        'description' => __( 'Enter List of Products', 'ihosting-core' ),
        "dependency"  => array("element" => "target", "value" => array( 'products')),
    ),
    array(
        'type'        => 'attach_image',
        'heading'     => __( 'Image Banner', 'ihosting-core' ),
        'param_name'  => 'photo',
        'description' => __( 'Show the photo in a corner of the block', 'ihosting-core' )
    ),
    array(
        'type' => 'vc_link',
        'heading' => __( 'URL (Link)', 'ihosting-core' ),
        'param_name' => 'link',
        'description' => __( 'Add link to banner.', 'ihosting-core' ),
    ),
);
//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter('vc_autocomplete_ih_megacategory_ids_callback', 'xshop_product_autocomplete_suggester_by_slug', 10, 1); // Get suggestion(find). Must return an array
add_filter('vc_autocomplete_ih_megacategory_ids_render', 'xshop_product_render_by_slug_exact', 10, 1); // Render exact category by id. Must return an array (label,value)
/* Load settings with layout*/
$kuteToolkit->load_shortcode_settings('ih_megacategory', $params, false);
return array(
    "name"                    =>    __( "Mega category", 'ihosting-core'),
    "base"                    =>    "ih_megacategory",
    "category"                =>    __('iHosting', 'ihosting-core' ),
    "description"             =>    __( "Show products of woocommerce", 'ihosting-core'),
    "as_child"                =>    array( 'only' => 'ih_megacategories' ),
    "content_element"         =>    true,
    "params"                  =>    $params,
);