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
    * NOTICE: Rules naming variable: $'theme-name'_'taxonomy-name'_prefix. Ex: $fs_designer_prefix, $fs_designer_config,...
    */
    $fs_designer_prefix = 'fs_designer_';
    
    /* 
    * Config
    */
    $fs_designer_config = array(
        'id'        => 'fs_designer_tax_metabox',          
        'title'     => 'Designer Taxonomy Meta Box', 
        'pages'     => array( 'product_designer' ),
        'context'   => 'normal',     
        'fields'    => array(),
        'local_images' => false,
        'use_with_theme' => false
    );
    
    $fs_designer_meta =  new Tax_Meta_Class( $fs_designer_config );
    
    /*
    * Add Fields
    */  
    $fs_designer_meta->addText( $fs_designer_prefix . 'position', array( 'name' => __( 'Position', 'ihosting-core' ), 'desc' => '') );
    $fs_designer_meta->addText( $fs_designer_prefix . 'collection', array( 'name' => __( 'Collection', 'ihosting-core' ), 'desc' => '') );
    $fs_designer_meta->addImage( $fs_designer_prefix . 'image', array( 'name' => __( 'Image', 'ihosting-core' ) ) );
    
    /*
    * Finish Meta Box Decleration
    */
    $fs_designer_meta->Finish();
    
    /*
    * Manage Taxonomy Columns
    */
    add_filter( 'manage_edit-product_designer_columns', 'fs_manage_tax_desginer_columns' );
    add_filter( 'manage_product_designer_custom_column', 'fs_manage_tax_desginer_column', 10, 3 );
    if (!function_exists('fs_manage_tax_desginer_columns')) {
        
        function fs_manage_tax_desginer_columns( $columns ) {
        
        	$newColumns = array();
        	$newColumns['cb'] = $columns['cb']; 
        	$newColumns['designer_tax_thumb'] = __( 'Image', 'ihosting-core' );
            $newColumns['name'] = $columns['name'];
        	$newColumns['designer_postition'] = __( 'Position', 'ihosting-core' ); 
            $newColumns['designer_collection'] = __( 'Collection', 'ihosting-core' );
             
        	unset( $columns['slug'] ); 
              
            return array_merge( $newColumns, $columns ); 
        }
    }
    if (!function_exists('fs_manage_tax_desginer_column')) {
        function fs_manage_tax_desginer_column( $columns, $column, $id ) {
            
            global $fs_designer_prefix;
            
            switch ( $column ) :
            
                case 'designer_tax_thumb' :
                    $imgArg = get_tax_meta( $id, $fs_designer_prefix . 'image', false );
                    if ( !empty($imgArg) ) :
                        $url_thumb = ( function_exists('ihosting_get_img_src_by_id') )? ihosting_get_img_src_by_id( $imgArg['id'], '70x70' ) : IHOSTINGCORE_IMG_URL . 'noimage/no_personal_150x150.jpg';
                        $columns = '<span><img style="max-width:70px;" data-img-id="' . $imgArg['id'] . '" data-src-full="' . $imgArg['url']. '" src="' . $url_thumb . '" alt="' . __('Thumbnail', 'ihosting-core') . '" class="wp-post-image" /></span>';
                    else : 
                        $columns = '<span><img style="max-width:70px;" data-img-id="0" data-src-full="' . IHOSTINGCORE_IMG_URL . 'noimage/no_personal_150x150.jpg" src="' . IHOSTINGCORE_IMG_URL . 'noimage/no_personal_150x150.jpg" alt="' . __('Thumbnail', 'ihosting-core') . '" class="wp-post-image" /></span>';
                    endif; 
                    break;
                    
                case 'designer_postition' :
                    echo get_tax_meta( $id, $fs_designer_prefix. 'position', false );
                    break;
                    
                case 'designer_collection' :
                    echo get_tax_meta( $id, $fs_designer_prefix. 'collection', false );
                    break;
                    
            endswitch; 
        	
        	return $columns;
        }
    } 
}

