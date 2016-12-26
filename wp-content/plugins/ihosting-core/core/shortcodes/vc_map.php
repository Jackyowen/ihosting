<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'ihostingIntroRow' );
function ihostingIntroRow() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Single Intro', 'ihosting-core' ),
            'base'        => 'ts_intro_row', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Number Of Items', 'ihosting-core' ),
                    'param_name'    => 'number_of_items',
                    'value' => array(
                        __( '1', 'theone-core' ) => '1',
                        __( '2', 'theone-core' ) => '2',
                        __( '3', 'theone-core' ) => '3',			    
                        __( '4', 'theone-core' ) => '4',
                    ),
                    'std'           => 4,
                ),
                
                // Item 1
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Primary Title', 'ihosting-core' ),
                    'param_name'    => 'primary_title_1',
                    'std'           => __( 'Digital painting', 'ihosting-core' ),
                    'group'         => __( 'Item 1', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Secondary Title', 'ihosting-core' ),
                    'param_name'    => 'secondary_title_1',
                    'std'           => __( '01', 'ihosting-core' ),
                    'group'         => __( 'Item 1', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textarea',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Description', 'ihosting-core' ),
                    'param_name'    => 'desc_1',
                    'std'           => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.', 'ihosting-core' ),
                    'group'         => __( 'Item 1', 'ihosting-core' )
                ),
                
                // Item 2
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Primary Title', 'ihosting-core' ),
                    'param_name'    => 'primary_title_2',
                    'std'           => __( 'Web design', 'ihosting-core' ),
                    'group'         => __( 'Item 2', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'number_of_items',
    				    'value'     => array( '2', '3', '4' ),
    			   	),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Secondary Title', 'ihosting-core' ),
                    'param_name'    => 'secondary_title_2',
                    'std'           => __( '02', 'ihosting-core' ),
                    'group'         => __( 'Item 2', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'number_of_items',
    				    'value'     => array( '2', '3', '4' ),
    			   	),
                ),
                array(
                    'type'          => 'textarea',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Description', 'ihosting-core' ),
                    'param_name'    => 'desc_2',
                    'std'           => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.', 'ihosting-core' ),
                    'group'         => __( 'Item 2', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'number_of_items',
    				    'value'     => array( '2', '3', '4' ),
    			   	),
                ),
                
                // Item 3
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Primary Title', 'ihosting-core' ),
                    'param_name'    => 'primary_title_3',
                    'std'           => __( 'Illustrator', 'ihosting-core' ),
                    'group'         => __( 'Item 3', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'number_of_items',
    				    'value'     => array( '3', '4' ),
    			   	),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Secondary Title', 'ihosting-core' ),
                    'param_name'    => 'secondary_title_3',
                    'std'           => __( '03', 'ihosting-core' ),
                    'group'         => __( 'Item 3', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'number_of_items',
    				    'value'     => array( '3', '4' ),
    			   	),
                ),
                array(
                    'type'          => 'textarea',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Description', 'ihosting-core' ),
                    'param_name'    => 'desc_3',
                    'std'           => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.', 'ihosting-core' ),
                    'group'         => __( 'Item 3', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'number_of_items',
    				    'value'     => array( '3', '4' ),
    			   	),
                ),
                
                // Item 4
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Primary Title', 'ihosting-core' ),
                    'param_name'    => 'primary_title_4',
                    'std'           => __( 'Mobile application', 'ihosting-core' ),
                    'group'         => __( 'Item 4', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'number_of_items',
    				    'value'     => array( '4' ),
    			   	),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Secondary Title', 'ihosting-core' ),
                    'param_name'    => 'secondary_title_4',
                    'std'           => __( '04', 'ihosting-core' ),
                    'group'         => __( 'Item 4', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'number_of_items',
    				    'value'     => array( '4' ),
    			   	),
                ),
                array(
                    'type'          => 'textarea',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Description', 'ihosting-core' ),
                    'param_name'    => 'desc_4',
                    'std'           => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.', 'ihosting-core' ),
                    'group'         => __( 'Item 4', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'number_of_items',
    				    'value'     => array( '4' ),
    			   	),
                ),
                
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'css_animation',
    				    'not_empty' => true,
    			   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}


add_action( 'vc_before_init', 'tsTextIcon' );
function tsTextIcon() {
    global $kt_vc_anim_effects_in, $tonicons;
    vc_map( 
        array(
            'name'        => __( 'J Text Icon', 'ihosting-core' ),
            'base'        => 'ts_text_icon', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Style', 'ihosting-core' ),
                    'param_name'    => 'style',
                    'value' => array(
                        __( 'Style 1', 'theone-core' ) => 'style-1',
                        __( 'Style 2', 'theone-core' ) => 'style-2',
                        __( 'Style 3', 'theone-core' ) => 'style-3',			    
                    ),
                    'std'           => 'style-1',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'UX/UI Designer', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Sub Title', 'ihosting-core' ),
                    'param_name'    => 'subtitle',
                    'std'           => __( 'Recent blog', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'style',
    				    'value'     => array( 'style-1' ),
    			   	),
                ),
                array(
                    'type'          => 'ihosting_icon_picker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Icon', 'theone-core' ),
                    'param_name'    => 'icon',
                    'std'           => 'ton-so-AOL',
    				'description' => __( 'Select icon from library.', 'ihosting-core' )
                ),
                array(
                    'type'          => 'textarea',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Short Description', 'theone-core' ),
                    'param_name'    => 'short_desc',
                    'std'           => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.Lorem ipsum dolor.', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Align', 'ihosting-core' ),
                    'param_name'    => 'align',
                    'value' => array(
                        __( 'Default', 'theone-core' ) => 'default',
                        __( 'Left', 'theone-core' ) => 'left',
                        __( 'Right', 'theone-core' ) => 'right',			    
                    ),
                    'std'           => 'right',
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'css_animation',
    				    'not_empty' => true,
    			   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}



add_action( 'vc_before_init', 'tsClientSlide' );
function tsClientSlide() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Client Slide', 'ihosting-core' ),
            'base'        => 'ts_client_slide', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'Recent work', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'ihosting_select_client_cat_field',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Client Category', 'ihosting-core' ),
                    'param_name'    => 'cat_id',
                    'std'           => '0',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Number Of Items', 'theone-core' ),
                    'param_name'    => 'number_of_items',
                    'std'           => '6',
    				'description' => __( 'Number of clients will load.', 'ihosting-core' )
                ),
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Loop', 'ihosting-core' ),
                    'param_name'    => 'loop',
                    'value' => array(
                        __( 'Yes', 'theone-core' ) => 'yes',
                        __( 'No', 'theone-core' ) => 'no',			    
                    ),
                    'std'           => 'yes',
                ),
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Autoplay', 'ihosting-core' ),
                    'param_name'    => 'autoplay',
                    'value' => array(
                        __( 'Yes', 'theone-core' ) => 'yes',
                        __( 'No', 'theone-core' ) => 'no',			    
                    ),
                    'std'           => 'yes',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Autoplay Timeout', 'theone-core' ),
                    'param_name'    => 'autoplay_timeout',
                    'std'           => '5000',
                    'dependency' => array(
    				    'element'   => 'autoplay',
    				    'value'     => array( 'yes' ),
    			   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}


add_action( 'vc_before_init', 'tsSingleProduct' );
function tsSingleProduct() {
    
    if ( !class_exists( 'WooCommerce' ) ):
        return false;
    endif;
    
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Single Product', 'ihosting-core' ),
            'base'        => 'ts_single_product', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
            		'type'        => 'autocomplete',
                    'holder'      => 'div',
            		'heading'     => __( 'Search Product', 'ihosting-core' ),
            		'param_name'  => 'product_id',
            		'description' => __( 'Type product title to quick search', 'ihosting-core' ),
            		'settings' => array(
            			'multiple' => false,
            			'sortable' => true,
            			'groups' => true,
            		),
            	),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'My store', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}
add_filter( 'vc_autocomplete_ts_single_product_product_id_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_ts_single_product_product_id_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)


add_action( 'vc_before_init', 'tsEssGridFilter' );
function tsEssGridFilter() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Ess Grid Filter', 'ihosting-core' ),
            'base'        => 'ts_ess_grid_filter', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core' ),
            'params'      => array(
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'Let\'s see what i do.', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Sub Title', 'ihosting-core' ),
                    'param_name'    => 'subtitle',
                    'std'           => __( 'Portfolio', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textarea',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Short Description', 'ihosting-core' ),
                    'param_name'    => 'short_desc',
                    'std'           => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'class'         => '',
                    'heading'       => __( 'Ess Grid Shortcode', 'ihosting-core' ),
                    'param_name'    => 'ess_grid_shortcode',
                    'value'         => ihosting_select_ess_grid_shortcodes(),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}


add_action( 'vc_before_init', 'tsSinglePost' );
function tsSinglePost() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Single Post', 'ihosting-core' ),
            'base'        => 'ts_single_post', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
            		'type'        => 'autocomplete',
                    'holder'      => 'div',
            		'heading'     => __( 'Search post', 'ihosting-core' ),
            		'param_name'  => 'post_id',
            		'description' => __( 'Type post title to quick search', 'ihosting-core' ),
            		'settings' => array(
            			'multiple' => false,
            			'sortable' => true,
            			'groups' => true,
            		),
            	),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}
add_filter( 'vc_autocomplete_ts_single_post_post_id_callback', 'ihosting_vc_include_field_post_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_ts_single_post_post_id_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact post. Must return an array (label,value)


add_action( 'vc_before_init', 'tsButton' );
function tsButton() {
    vc_map( 
        array(
            'name'        => __( 'J Button', 'ihosting-core' ),
            'base'        => 'ts_button', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Button Text', 'ihosting-core' ),
                    'param_name'    => 'btn_text',
                    'std'           => __( 'Show me more', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Button Link', 'ihosting-core' ),
                    'param_name'    => 'btn_link',
                    'std'           => __( '#', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Link Target', 'ihosting-core' ),
                    'param_name'    => 'link_target',
                    'value' => array(
                        __( '_self', 'theone-core' ) => '_self',
                        __( '_blank', 'theone-core' ) => '_blank',			    
                    ),
                    'std'           => 'blank',
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Color', 'ihosting-core' ),
                    'param_name'    => 'color',
                    'std'           => __( '#8a8a8a', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Hover Color', 'ihosting-core' ),
                    'param_name'    => 'hover_color',
                    'std'           => __( '#ffffff', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Border Style', 'ihosting-core' ),
                    'param_name'    => 'border_style',
                    'value' => array(
                        __( 'none', 'theone-core' ) => 'none',
                        __( 'hidden', 'theone-core' ) => 'hidden',			    
                        __( 'dotted', 'theone-core' ) => 'dotted',
                        __( 'dashed', 'theone-core' ) => 'dashed',
                        __( 'solid', 'theone-core' ) => 'solid',
                        __( 'double', 'theone-core' ) => 'double',			    
                        __( 'groove', 'theone-core' ) => 'groove',
                        __( 'ridge', 'theone-core' ) => 'ridge',
                        __( 'inset', 'theone-core' ) => 'inset',
                        __( 'outset', 'theone-core' ) => 'outset',			    
                        __( 'initial', 'theone-core' ) => 'initial',
                        __( 'inherit', 'theone-core' ) => 'inherit'
                    ),
                    'std'           => 'solid',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Border Width', 'ihosting-core' ),
                    'param_name'    => 'border_width',
                    'std'           => __( '2', 'ihosting-core' ),
                    'description'   => __( 'Border width unit is "px"', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Border Radius', 'ihosting-core' ),
                    'param_name'    => 'border_radius',
                    'std'           => __( '17.5', 'ihosting-core' ),
                    'description'   => __( 'Border radius unit is "px"', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Border Color', 'ihosting-core' ),
                    'param_name'    => 'border_color',
                    'std'           => __( '#ebebeb', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Border Hover Color', 'ihosting-core' ),
                    'param_name'    => 'border_hover_color',
                    'std'           => __( '#424242', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Background Color', 'ihosting-core' ),
                    'param_name'    => 'btn_bg_color',
                    'std'           => __( '#ffffff', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Background Hover Color', 'ihosting-core' ),
                    'param_name'    => 'bg_hover_color',
                    'std'           => __( '#424242', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}


add_action( 'vc_before_init', 'tsTestimonials' );
function tsTestimonials() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Testimonials', 'ihosting-core' ),
            'base'        => 'ts_testimonials', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
            		'type'        => 'ihosting_select_tes_cat_field',
                    'holder'      => 'div',
            		'heading'     => __( 'Select Category', 'ihosting-core' ),
            		'param_name'  => 'cat_id',
            	),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Loop', 'ihosting-core' ),
                    'param_name'    => 'loop',
                    'value' => array(
                        __( 'Yes', 'theone-core' ) => 'yes',
                        __( 'No', 'theone-core' ) => 'no',	
                    ),
                    'std'           => 'yes',
                ),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Number Of Items', 'ihosting-core' ),
            		'param_name'  => 'number_of_items',
                    'std'           => '3',
            	),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Autoplay', 'ihosting-core' ),
                    'param_name'    => 'autoplay',
                    'value' => array(
                        __( 'Yes', 'theone-core' ) => 'yes',
                        __( 'No', 'theone-core' ) => 'no',	
                    ),
                    'std'           => 'yes',
                ),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Autoplay Timeout', 'ihosting-core' ),
            		'param_name'  => 'autoplay_timeout',
                    'std'           => '5000',
            		'description' => __( 'Timeout unit is "milisecond".', 'ihosting-core' ),
            	),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}


add_action( 'vc_before_init', 'tsClientsCarousel' );
function tsClientsCarousel() {
    vc_map( 
        array(
            'name'        => __( 'J Clients Carousel', 'ihosting-core' ),
            'base'        => 'ts_clients_carousel', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
            		'type'        => 'ihosting_select_client_cat_field',
                    'holder'      => 'div',
            		'heading'     => __( 'Select Category', 'ihosting-core' ),
            		'param_name'  => 'cat_id',
            	),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Loop', 'ihosting-core' ),
                    'param_name'    => 'loop',
                    'value' => array(
                        __( 'Yes', 'theone-core' ) => 'yes',
                        __( 'No', 'theone-core' ) => 'no',	
                    ),
                    'std'           => 'yes',
                ),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Number Of Items', 'ihosting-core' ),
            		'param_name'  => 'number_of_items',
                    'std'           => '10',
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Items Per Slide', 'ihosting-core' ),
            		'param_name'  => 'items_per_slide',
                    'std'           => '6',
            	),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Autoplay', 'ihosting-core' ),
                    'param_name'    => 'autoplay',
                    'value' => array(
                        __( 'Yes', 'theone-core' ) => 'yes',
                        __( 'No', 'theone-core' ) => 'no',	
                    ),
                    'std'           => 'yes',
                ),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Autoplay Timeout', 'ihosting-core' ),
            		'param_name'  => 'autoplay_timeout',
                    'std'           => '5000',
            		'description' => __( 'Timeout unit is "milisecond".', 'ihosting-core' ),
            	),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}

add_action( 'vc_before_init', 'tsProgressBars' );
function tsProgressBars() {
    vc_map( 
        array(
            'name'        => __( 'J Progress Bars', 'ihosting-core' ),
            'base'        => 'ts_progress_bars', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
            		'type'        => 'exploded_textarea',
                    'holder'      => 'div',
            		'heading'     => __( 'Bar Values', 'ihosting-core' ),
            		'param_name'  => 'bar_values',
                    'std'         => __( 'Composer|80|&#37;&#13;&#10;Arranger|70|&#37;&#13;&#10;Mastering|90|&#37;', 'ihosting-core' ),
            		'description' => __( 'Each bar information on a line. {text}|{value}|{unit}. For example: Composer|80|&#37;', 'ihosting-core' ),
            	),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Bar Color', 'ihosting-core' ),
                    'param_name'    => 'bar_color',
                    'std'           => __( '#ececec', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Bar Background Color', 'ihosting-core' ),
                    'param_name'    => 'bar_bg_color',
                    'std'           => __( '#ffffff', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Bar Border Color', 'ihosting-core' ),
                    'param_name'    => 'bar_border_color',
                    'std'           => __( '#d0d0d0', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Text Color', 'ihosting-core' ),
                    'param_name'    => 'text_color',
                    'std'           => __( '#424242', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Value Color', 'ihosting-core' ),
                    'param_name'    => 'value_color',
                    'std'           => __( '#949494', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Unit Color', 'ihosting-core' ),
                    'param_name'    => 'unit_color',
                    'std'           => __( '#949494', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}


add_action( 'vc_before_init', 'tsIntroducedBlock' );
function tsIntroducedBlock() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Introduced Block', 'ihosting-core' ),
            'base'        => 'ts_intro_block', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Style', 'ihosting-core' ),
                    'param_name'    => 'style',
                    'value' => array(
                        __( 'Big Image Right', 'theone-core' ) => 'big_img_right',
                        __( 'Big Image Left', 'theone-core' ) => 'big_img_left',	
                    ),
                    'std'           => 'big_img_right',
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Text Align', 'ihosting-core' ),
                    'param_name'    => 'text_align',
                    'value' => array(
                        __( 'Center', 'theone-core' ) => 'center',
                        __( 'Left', 'theone-core' ) => 'left',
                        __( 'Right', 'theone-core' ) => 'right',	
                    ),
                    'std'           => 'center',
                ),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Title', 'ihosting-core' ),
            		'param_name'  => 'title',
                    'std'           => __( 'Store', 'ihosting-core' ),
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Short Description', 'ihosting-core' ),
            		'param_name'  => 'short_desc',
                    'std'           => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt sed do eiusmod tempor incididunt.', 'ihosting-core' ),
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Button Text', 'ihosting-core' ),
            		'param_name'  => 'btn_text',
                    'std'           => __( 'Show more', 'ihosting-core' ),
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Button Link', 'ihosting-core' ),
            		'param_name'  => 'btn_link',
                    'std'           => '#',
            	),
                array(
            		'type'        => 'attach_image',
                    'holder'      => 'div',
            		'heading'     => __( 'Big Image', 'ihosting-core' ),
            		'param_name'  => 'big_img',
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Big Image Link', 'ihosting-core' ),
            		'param_name'  => 'big_img_link',
                    'std'         => '#',
            	),
                array(
            		'type'        => 'attach_image',
                    'holder'      => 'div',
            		'heading'     => __( 'Small Image 1', 'ihosting-core' ),
            		'param_name'  => 'small_img_1',
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Small Image 1 Link', 'ihosting-core' ),
            		'param_name'  => 'small_img_1_link',
                    'std'         => '#',
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Small Image 1 Text', 'ihosting-core' ),
            		'param_name'  => 'small_img_1_text',
                    'std'         => __( 'Fur jacket', 'ihosting-core' ),
            	),
                array(
            		'type'        => 'attach_image',
                    'holder'      => 'div',
            		'heading'     => __( 'Small Image 2', 'ihosting-core' ),
            		'param_name'  => 'small_img_2',
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Small Image 2 Link', 'ihosting-core' ),
            		'param_name'  => 'small_img_2_link',
                    'std'         => '#',
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Small Image 2 Text', 'ihosting-core' ),
            		'param_name'  => 'small_img_2_text',
                    'std'         => __( 'Product name', 'ihosting-core' ),
               ),
               array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Link Target', 'ihosting-core' ),
                    'param_name'    => 'link_target',
                    'value' => array(
                        __( '_self', 'theone-core' )    => '_self',
                        __( '_blank', 'theone-core' )   => '_blank',
                    ),
                    'std'           => '_self',
                    'description'   => __( 'Apply for all links above.', 'ihosting-core' )
               ),
               array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'css_animation',
    				    'not_empty' => true,
    			   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}


add_action( 'vc_before_init', 'tsProductCatIntro' );
function tsProductCatIntro() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Product Category Introduced', 'ihosting-core' ),
            'base'        => 'ts_product_cat_intro', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Style', 'ihosting-core' ),
                    'param_name'    => 'style',
                    'value' => array(
                        __( 'Big Image Right', 'theone-core' ) => 'big_img_right',
                        __( 'Big Image Left', 'theone-core' ) => 'big_img_left',	
                    ),
                    'std'           => 'big_img_right',
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Text Align', 'ihosting-core' ),
                    'param_name'    => 'text_align',
                    'value' => array(
                        __( 'Center', 'theone-core' ) => 'center',
                        __( 'Left', 'theone-core' ) => 'left',
                        __( 'Right', 'theone-core' ) => 'right',	
                    ),
                    'std'           => 'center',
                ),
                array(
            		'type'        => 'ihosting_select_product_cat_field',
                    'holder'      => 'div',
            		'heading'     => __( 'Category', 'ihosting-core' ),
            		'param_name'  => 'cat_id',
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Title', 'ihosting-core' ),
            		'param_name'  => 'title',
                    'std'           => __( 'Store', 'ihosting-core' ),
            	),
                array(
            		'type'        => 'dropdown',
                    'holder'      => 'div',
            		'heading'     => __( 'Show Category Link Button', 'ihosting-core' ),
            		'param_name'  => 'show_cat_link_btn',
                    'value' => array(
                        __( 'Yes', 'theone-core' )  => 'yes',
                        __( 'No', 'theone-core' )   => 'no',
                    ),
                    'std'           => 'yes',
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Button Text', 'ihosting-core' ),
            		'param_name'  => 'btn_text',
                    'std'           => __( 'Show more', 'ihosting-core' ),
               ),
               array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'css_animation',
    				    'not_empty' => true,
    			   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}


add_action( 'vc_before_init', 'tsRecentPosts' );
function tsRecentPosts() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Recent Posts', 'ihosting-core' ),
            'base'        => 'ts_recent_posts', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Style', 'ihosting-core' ),
                    'param_name'    => 'style',
                    'value' => array(
                        __( 'First Post Left', 'theone-core' )  => 'first_post_left',
                        __( 'First Post Right', 'theone-core' ) => 'first_post_right',	
                    ),
                    'std'           => 'first_post_left',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'Recent blog post', 'ihosting-core' ),
                ),
                array(
            		'type'        => 'ihosting_select_cat_field',
                    'holder'      => 'div',
            		'heading'     => __( 'Category', 'ihosting-core' ),
            		'param_name'  => 'cat_id',
            	),
                array(
            		'type'        => 'textarea',
                    'holder'      => 'div',
            		'heading'     => __( 'Short Description', 'ihosting-core' ),
            		'param_name'  => 'short_desc',
                    'std'           => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt sed do eiusmod tempor incididunt.', 'ihosting-core' ),
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Number Of Posts', 'ihosting-core' ),
            		'param_name'  => 'show_posts',
                    'std'         => '4',
            		'description' => __( 'Number of posts will show. Default is "4".', 'ihosting-core' ),
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'The Excerpt Max Chars Length', 'ihosting-core' ),
            		'param_name'  => 'excerpt_max_chars',
                    'std'         => '180',
       	       ),
                array(
            		'type'        => 'dropdown',
                    'holder'      => 'div',
            		'heading'     => __( 'Show Place Hold Image', 'ihosting-core' ),
            		'param_name'  => 'show_no_img',
                    'value' => array(
                        __( 'Yes', 'theone-core' )  => 'yes',
                        __( 'No', 'theone-core' )   => 'no',
                    ),
                    'std'         => 'yes',
            		'description' => __( 'Show place hold image if post has not featured image.', 'ihosting-core' ),
       	       ),
               array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Read More Text', 'ihosting-core' ),
            		'param_name'  => 'readmore_text',
                    'std'         => __( 'See my blog', 'ihosting-core' ),
            	),
               array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'css_animation',
    				    'not_empty' => true,
    			   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}

add_action( 'vc_before_init', 'tsRecentPostsGrid' );
function tsRecentPostsGrid() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Recent Posts Grid', 'ihosting-core' ),
            'base'        => 'ts_recent_posts_grid', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
            		'type'        => 'ihosting_select_cat_field',
                    'holder'      => 'div',
            		'heading'     => __( 'Category', 'ihosting-core' ),
            		'param_name'  => 'cat_id',
            	),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Number Of Posts', 'ihosting-core' ),
            		'param_name'  => 'show_posts',
                    'std'         => '3',
            		'description' => __( 'Number of posts will show. Default is "3".', 'ihosting-core' ),
            	),
                array(
            		'type'        => 'dropdown',
                    'holder'      => 'div',
            		'heading'     => __( 'Show Place Hold Image', 'ihosting-core' ),
            		'param_name'  => 'show_no_img',
                    'value' => array(
                        __( 'Yes', 'theone-core' )  => 'yes',
                        __( 'No', 'theone-core' )   => 'no',
                    ),
                    'std'         => 'yes',
            		'description' => __( 'Show place hold image if post has not featured image.', 'ihosting-core' ),
       	       ),
               array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'The Excerpt Max Chars Length', 'ihosting-core' ),
            		'param_name'  => 'excerpt_max_chars',
                    'std'         => '180',
       	       ),
               array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Read More Text', 'ihosting-core' ),
            		'param_name'  => 'show_all_btn_text',
                    'std'         => __( 'Show me all', 'ihosting-core' ),
                    'description' => __( 'This button link to blog page (if posts from all categories) or category page (if posts from a category). Leave it empty if you don\'t want to show read more button on the frontend.', 'ihosting-core' ),
            	),
               array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
    				    'element'   => 'css_animation',
    				    'not_empty' => true,
    			   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}


add_action( 'vc_before_init', 'tsMailTo' );
function tsMailTo() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Mail To', 'ihosting-core' ),
            'base'        => 'ts_mail_to', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Email', 'ihosting-core' ),
            		'param_name'  => 'email',
                    'std'         => get_option( 'admin_email' ),
           	    ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
                	    'element'   => 'css_animation',
                	    'not_empty' => true,
                   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}


add_action( 'vc_before_init', 'tsTeamMember' );
function tsTeamMember() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Team Member', 'ihosting-core' ),
            'base'        => 'ts_team_member', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Member Name', 'ihosting-core' ),
            		'param_name'  => 'mem_name',
                    'std'         => __( 'Michael Nelson', 'ihosting-core' ),
           	    ),
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Member Position', 'ihosting-core' ),
            		'param_name'  => 'mem_pos',
                    'std'         => __( 'Director', 'ihosting-core' ),
           	    ),
                array(
            		'type'        => 'attach_image',
                    'holder'      => 'div',
            		'heading'     => __( 'Member Image', 'ihosting-core' ),
            		'param_name'  => 'mem_img',
           	    ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Member Image Size', 'ihosting-core' ),
                    'param_name'    => 'mem_img_size',
                    'std'           => '258x258',
                    'description'   => __( 'Example: 258x258 for normal size, 358x358 for bigger size.', 'ihosting-core' )
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
                	    'element'   => 'css_animation',
                	    'not_empty' => true,
                   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}

add_action( 'vc_before_init', 'tsTitleDesc' );
function tsTitleDesc() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'J Title With Description', 'ihosting-core' ),
            'base'        => 'ts_title_desc', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
            		'type'        => 'textfield',
                    'holder'      => 'div',
            		'heading'     => __( 'Title', 'ihosting-core' ),
            		'param_name'  => 'title',
                    'std'         => __( 'Jonathan', 'ihosting-core' ),
           	    ),
                array(
            		'type'        => 'textarea',
                    'holder'      => 'div',
            		'heading'     => __( 'Description', 'ihosting-core' ),
            		'param_name'  => 'short_desc',
                    'std'         => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt sed do eiusmod tempor incididunt.', 'ihosting-core' ),
           	    ),
                array(
            		'type'        => 'dropdown',
                    'holder'      => 'div',
            		'heading'     => __( 'Text Align', 'ihosting-core' ),
            		'param_name'  => 'text_align',
                    'value' => array(
                        __( 'Left', 'theone-core' )     => 'left',
                        __( 'Right', 'theone-core' )    => 'right',
                        __( 'Center', 'theone-core' )   => 'center',
                        __( 'Inherit', 'theone-core' )  => 'inherit',
                    ),
                    'std'         => 'center',
       	       ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'CSS Animation', 'ihosting-core' ),
                    'param_name'    => 'css_animation',
                    'value'         => $kt_vc_anim_effects_in,
                    'std'           => 'fadeInUp',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Animation Delay', 'ihosting-core' ),
                    'param_name'    => 'animation_delay',
                    'std'           => '0.4',
                    'description'   => __( 'Delay unit is second.', 'ihosting-core' ),
                    'dependency' => array(
                	    'element'   => 'css_animation',
                	    'not_empty' => true,
                   	),
                ),
                array(
                    'type'          => 'css_editor',
                    'heading'       => __( 'Css', 'ihosting-core' ),
                    'param_name'    => 'css',
                    'group'         => __( 'Design options', 'ihosting-core' ),
                )
            )
        )
    );
}




