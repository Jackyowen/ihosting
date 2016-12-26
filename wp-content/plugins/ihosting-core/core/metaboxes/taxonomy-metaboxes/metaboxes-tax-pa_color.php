<?php

/**
 * Metaboxes pa_colors Taxonomy
 *
 * @package Lucky Shop Core 1.0
 * @author  Gordon Freeman
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_admin() && class_exists( 'Tax_Meta_Class' ) ) {

	/*
	* Prefix of meta keys, optional
	* NOTICE: Rules naming variable: $'theme-name'_'taxonomy-name'_prefix. Ex: $ihosting_prefix, $ihosting_config,...
	*/
	$ihosting_prefix = 'ihosting_';

	/*
	* Config
	*/
	$ihosting_config = array(
		'id'             => 'ihosting_tax_metabox',
		'title'          => esc_html__( 'Color Attribute Meta Box', 'ihosting-core' ),
		'pages'          => array( 'pa_color' ),
		'context'        => 'normal',
		'fields'         => array(),
		'local_images'   => false,
		'use_with_theme' => false
	);

	$ihosting_meta = new Tax_Meta_Class( $ihosting_config );

	/*
	* Add Fields
	*/
	$ihosting_meta->addColor( $ihosting_prefix . 'color', array( 'name' => esc_html__( 'Select Color ', 'ihosting-core' ) ) );

	/*
	* Finish Meta Box Decleration
	*/
	$ihosting_meta->Finish();

	/*
	* Manage Taxonomy Columns
	*/
	add_filter( 'manage_edit-pa_color_columns', 'ts_manage_tax_pa_color_columns' );
	add_filter( 'manage_pa_color_custom_column', 'ts_manage_tax_pa_color_column', 10, 3 );
	if ( !function_exists( 'ts_manage_tax_pa_color_columns' ) ) {

		function ts_manage_tax_pa_color_columns( $columns ) {

			$newColumns = array();
			$newColumns['cb'] = $columns['cb'];
			$newColumns['pa_color_tax_thumb'] = esc_html__( 'Color', 'ihosting-core' );
			$newColumns['name'] = $columns['name'];

			unset( $columns['slug'] );

			return array_merge( $newColumns, $columns );
		}
	}
	if ( !function_exists( 'ts_manage_tax_pa_color_column' ) ) {
		function ts_manage_tax_pa_color_column( $columns, $column, $id ) {

			global $ihosting_prefix;

			switch ( $column ) :

				case 'pa_color_tax_thumb' :
					$color = get_tax_meta( $id, $ihosting_prefix . 'color', false );
					if ( $color != '' ) :
						$columns = '<span class="color_thumbnail" style="background:' . $color . '"></span>';
					else :
						$columns = '<span class="color_thumbnail"></span>';
					endif;
					break;

			endswitch;

			return $columns;
		}
	}
}