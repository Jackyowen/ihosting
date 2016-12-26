<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noAccordion' );
function noAccordion() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Accordion', 'ihosting-core' ),
            'base'        => 'vc_tta_accordion', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'icon' => 'icon-wpb-ui-accordion',
        	'is_container' => true,
        	'show_settings_on_create' => false,
        	'as_parent' => array(
        		'only' => 'vc_tta_section'
        	),
        	'description' => __( 'Collapsible content panels', 'ihosting' ),
            'params'      => array(
                array(
        			'type' => 'textfield',
        			'param_name' => 'title',
        			'heading' => __( 'Widget title', 'ihosting' ),
        			'description' => __( 'Enter text used as widget title (Note: located above content element).', 'ihosting' ),
        		),
        		array(
        			'type' => 'dropdown',
        			'param_name' => 'spacing',
        			'value' => array(
        				__( 'None', 'ihosting' ) => '',
        				'1px' => '1',
        				'2px' => '2',
        				'3px' => '3',
        				'4px' => '4',
        				'5px' => '5',
        				'10px' => '10',
        				'15px' => '15',
        				'20px' => '20',
        				'25px' => '25',
        				'30px' => '30',
        				'35px' => '35',
        			),
        			'heading' => __( 'Spacing', 'ihosting' ),
        			'description' => __( 'Select accordion spacing.', 'ihosting' ),
        		),
        		array(
        			'type' => 'dropdown',
        			'param_name' => 'c_align',
        			'value' => array(
        				__( 'Left', 'ihosting' ) => 'left',
        				__( 'Right', 'ihosting' ) => 'right',
        				__( 'Center', 'ihosting' ) => 'center',
        			),
        			'heading' => __( 'Alignment', 'ihosting' ),
        			'description' => __( 'Select accordion section title alignment.', 'ihosting' ),
        		),
        		array(
        			'type' => 'checkbox',
        			'param_name' => 'collapsible_all',
        			'heading' => __( 'Allow collapse all?', 'ihosting' ),
        			'description' => __( 'Allow collapse all accordion sections.', 'ihosting' ),
        		),
        		// Control Icons
        		array(
        			'type' => 'dropdown',
        			'param_name' => 'c_icon',
        			'value' => array(
        				__( 'None', 'ihosting' ) => '',
        				__( 'Chevron', 'ihosting' ) => 'chevron',
        				__( 'Plus', 'ihosting' ) => 'plus',
        			),
        			'std' => 'plus',
        			'heading' => __( 'Icon', 'ihosting' ),
        			'description' => __( 'Select accordion navigation icon.', 'ihosting' ),
        		),
        		array(
        			'type' => 'dropdown',
        			'param_name' => 'c_position',
        			'value' => array(
        				__( 'Left', 'ihosting' ) => 'left',
        				__( 'Right', 'ihosting' ) => 'right',
        			),
        			'dependency' => array(
        				'element' => 'c_icon',
        				'not_empty' => true,
        			),
        			'heading' => __( 'Position', 'ihosting' ),
        			'description' => __( 'Select accordion navigation icon position.', 'ihosting' ),
        		),
        		// Control Icons END
        		array(
        			'type' => 'textfield',
        			'param_name' => 'active_section',
        			'heading' => __( 'Active section', 'ihosting' ),
        			'value' => 1,
        			'description' => __( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'ihosting' ),
        		),
        		array(
        			'type' => 'textfield',
        			'heading' => __( 'Extra class name', 'ihosting' ),
        			'param_name' => 'el_class',
        			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ihosting' ),
        		),
        		array(
        			'type' => 'css_editor',
        			'heading' => __( 'CSS box', 'ihosting' ),
        			'param_name' => 'css',
        			'group' => __( 'Design Options', 'ihosting' )
        		),
            ),
            'js_view' => 'VcBackendTtaAccordionView',
            	'custom_markup' => '
            <div class="vc_tta-container" data-vc-action="collapseAll">
            	<div class="vc_general vc_tta vc_tta-accordion vc_tta-color-backend-accordion-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-gap-2">
            	   <div class="vc_tta-panels vc_clearfix {{container-class}}">
            	      {{ content }}
            	      <div class="vc_tta-panel vc_tta-section-append">
            	         <div class="vc_tta-panel-heading">
            	            <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
            	               <a href="javascript:;" aria-expanded="false" class="vc_tta-backend-add-control">
            	                   <span class="vc_tta-title-text">' . __( 'Add Section', 'ihosting' ) . '</span>
            	                    <i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>
            					</a>
            	            </h4>
            	         </div>
            	      </div>
            	   </div>
            	</div>
            </div>',
            	'default_content' => '
            [vc_tta_section title="' . sprintf( "%s %d", __( 'Section', 'ihosting' ), 1 ) . '"][/vc_tta_section]
            [vc_tta_section title="' . sprintf( "%s %d", __( 'Section', 'ihosting' ), 2 ) . '"][/vc_tta_section]
            	'
        )
    );
}

function vc_tta_accordion( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'vc_tta_accordion', $atts ) : $atts;
    
    //extract( shortcode_atts( array(
//        'style'             =>  'style1',
//        'sep_type'          =>  'dashed',
//        'icon'              =>  '',
//        'icon_color'        =>  '',
//        'icon_bg_color'     =>  '',
//        'title'             =>  '',
//        'short_desc'        =>  '',
//        'link'              =>  '',
//        'show_read_more_btn'    =>  'no',
//        'read_more_text'    =>  '',
//        'text_align'        =>  'center',
//        'css_animation'     =>  '',
//        'animation_delay'   =>  '0.4',   //In second
//        'css'               =>  '',
//	), $atts ) );
    
    $css_class = 'icon-boxes-wrap wow ' . $css_animation;
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    $html = '';
            
    return $html;
    
}

//add_shortcode( 'vc_tta_accordion', 'vc_tta_accordion' );
