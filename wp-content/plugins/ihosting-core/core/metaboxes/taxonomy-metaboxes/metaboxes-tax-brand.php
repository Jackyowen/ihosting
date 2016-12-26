<?php

/**
 * Metaboxes Designer Taxonomy 
 * @package OViC Core 1.0
 * @author Theme Studio 
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_admin() && class_exists('Tax_Meta_Class') ){
    
    /* 
    * Prefix of meta keys, optional
    * NOTICE: Rules naming variable: $'theme-name'_'taxonomy-name'_prefix. Ex: $ihosting_brand_prefix, $ihosting_brand_config,...
    */
    $ihosting_brand_prefix = 'ihosting_brand_';
    
    /* 
    * Config
    */
    $ihosting_brand_config = array(
        'id'        => 'ihosting_brand_tax_metabox',
        'title'     => 'Brand Taxonomy Meta Box',
        'pages'     => array( 'product_brand' ),
        'context'   => 'normal',
        'fields'    => array(),
        'local_images' => false,
        'use_with_theme' => false
    ); 
    
    $ihosting_brand_meta  =  new Tax_Meta_Class( $ihosting_brand_config );
    
    /*
    * Add Fields
    */
    $ihosting_brand_meta->addImage( $ihosting_brand_prefix . 'image', array( 'name' => __( 'Image', 'ihosting-core' ) ) );
    
    /*
    * Finish Meta Box Decleration
    */
    $ihosting_brand_meta->Finish();
    
    /*
    * Manage Taxonomy Columns
    */
    add_filter( 'manage_edit-product_brand_columns', 'ihosting_manage_tax_brand_columns' );
    add_filter( 'manage_product_brand_custom_column', 'ihosting_manage_tax_brand_column', 10, 3 );
    if (!function_exists('ihosting_manage_tax_brand_columns')) {
        
        function ihosting_manage_tax_brand_columns( $columns ) {
        
        	$newColumns = array();
        	$newColumns['cb'] = $columns['cb']; 
        	$newColumns['brand_tax_thumb'] = __( 'Image', 'ihostingfashion' );
            $newColumns['name'] = $columns['name']; 
             
        	unset( $columns['slug'] ); 
              
            return array_merge( $newColumns, $columns ); 
        }
    }
    if (!function_exists('ihosting_manage_tax_brand_column')) {
        function ihosting_manage_tax_brand_column( $columns, $column, $id ) {
            
            global $ihosting_brand_prefix;
            
            switch ( $column ) :
            
                case 'brand_tax_thumb' :
                    $imgArg = get_tax_meta( $id, $ihosting_brand_prefix . 'image', false );
                    if ( !empty($imgArg) ) :
                        $url_thumb = ( function_exists('ihosting_get_img_src_by_id') )? ihosting_get_img_src_by_id( $imgArg['id'], '100x49' ) : IHOSTINGCORE_IMG_URL . 'noimage/no_image_100x49.jpg';
                        $columns = '<span><img data-img-id="' . $imgArg['id'] . '" data-src-full="' . $imgArg['url']. '" src="' . $url_thumb . '" alt="' . __('Thumbnail', 'ihosting-core') . '" class="wp-post-image" /></span>';
                    else : 
                        $columns = '<span><img data-img-id="0" data-src-full="' . IHOSTINGCORE_IMG_URL . 'noimage/no_image_100x49.jpg" src="' . IHOSTINGCORE_IMG_URL . 'noimage/no_image_100x49.jpg" alt="' . __('Thumbnail', 'ihosting-core') . '" class="wp-post-image" /></span>';
                    endif; 
                    break; 
                    
            endswitch; 
        	
        	return $columns;
        }
    } 
}