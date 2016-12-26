<?php
global $kutetheme_ovic_toolkit, $woocommerce_loop;
$atts = $this->getAttributes( $atts );
$elementClass = $this->getCustomClass( $atts );
extract( $atts );

$category_attr = array(
    'title'         =>  '',
    'subtitle'      =>  '',
    'description'  =>  '',
    'taxonomy'      =>  '',
    'target'        =>  'recent-product',
    'filter'        =>  '',
    'attribute'     =>  '',
    'orderby'       =>  'date',
    'order'         =>  'DESC',
    'per_page'      =>  6,
    'ids'           =>  '',
    'photo'         =>  '',
    'link'          =>  ''
);
$uniqid = uniqid('ih_megacategories_');
$subs = kutetheme_ovic_get_all_attributes('ih_megacategory', $content);
if($subs){
    foreach ($subs as $key => &$sub){
        if(!isset($sub['title']))
            $sub['title'] = $category_attr['title'];
        if(!isset($sub['subtitle']))
            $sub['subtitle'] = $category_attr['subtitle'];
        if(!isset($sub['description']))
            $sub['description'] = $category_attr['description'];
        if(!isset($sub['taxonomy']))
            $sub['taxonomy'] = $category_attr['taxonomy'];
        if(!isset($sub['target']))
            $sub['target'] = $category_attr['target'];
        if(!isset($sub['filter']))
            $sub['filter'] = $category_attr['filter'];
        if(!isset($sub['attribute']))
            $sub['attribute'] = $category_attr['attribute'];
        if(!isset($sub['orderby']))
            $sub['orderby'] = $category_attr['orderby'];
        if(!isset($sub['order']))
            $sub['order'] = $category_attr['order'];
        if(!isset($sub['per_page']))
            $sub['per_page'] = $category_attr['per_page'];
        if(!isset($sub['ids']))
            $sub['ids'] = $category_attr['ids'];
        if(!isset($sub['photo']))
            $sub['photo'] = $category_attr['photo'];
        if(!isset($sub['link']))
            $sub['link'] = $category_attr['link'];
        $sub['uniqid'] = uniqid('ih_megacategory_');
    }
}
// Accordion -------------------------------------------------------------------------
$accordion_attr = array(
    'title'         =>  '',
    'description'   =>  '',
);
$uniqid = uniqid('ih_megacategories_');
$accordions = kutetheme_ovic_get_all_attributes('ih_accordion', $content);
if($accordions){
    foreach ($accordions as $key => &$accordion){
        if(!isset($accordion['title']))
            $accordion['title'] = $accordion_attr['title'];
        if(!isset($accordion['description']))
            $accordion['description'] = $accordion_attr['description'];
        $accordion['uniqid'] = uniqid('ih_accordion_');
    }
}

//$link = array();
if ( $product_image_size ){
    if( $product_image_size == 'custom'){
        $thumb_width = $product_custom_thumb_width;
        $thumb_height = $product_custom_thumb_height;
    }else{
        $product_image_size = explode("x",$product_image_size);
        $thumb_width = $product_image_size[0];
        $thumb_height = $product_image_size[1];
    }
    if($thumb_width > 0){
        add_filter( 'kutetheme_ovic_shop_pruduct_thumb_width', create_function('','return '.$thumb_width.';') );
    }
    if($thumb_height > 0){
        add_filter( 'kutetheme_ovic_shop_pruduct_thumb_height', create_function('','return '.$thumb_height.';') );
    }
}
if(isset($atts['layout']) && $atts['layout']){
    include get_template_directory().'/vc_templates/'.$this->shortcode.'/'.$atts['layout'].'.php';
}

?>
