<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $this WPBakeryShortCode_VC_Tta_Accordion|WPBakeryShortCode_VC_Tta_Tabs|WPBakeryShortCode_VC_Tta_Tour|WPBakeryShortCode_VC_Tta_Pageable
 */
$el_class = $css = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->resetVariables( $atts, $content );
extract( $atts );

if ( $this->getShortcode() == 'vc_tta_accordion' ) { // Custom VC Accordion

    $this->setGlobalTtaInfo();
    
    $this->enqueueTtaScript();
    
    // It is required to be before tabs-list-top/left/bottom/right for tabs/tours
    $prepareContent = $this->getTemplateVariable( 'content' );
    
    // Replace attribute "data-vc-accordion"
    //$prepareContent = str_replace( 'data-vc-accordion', 'data-ihosting-vc-accordion', $prepareContent );
    
    $class_to_filter = $this->getTtaGeneralClasses();
    $class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
    $css_class = 'ts-accordion ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
    
    $allow_collapsible_all = $collapsible_all == true || $collapsible_all == 'true' ? 'yes' : 'no';
    
    $output = '<div ' . $this->getWrapperAttributes() . '>';
    $output .= $this->getTemplateVariable( 'title' );
    $output .= '<div class="' . esc_attr( $css_class ) . '" data-tab-active="' . esc_attr( intval( $active_section ) - 1 ) . '" data-allow-collapsible-all="' . esc_attr( $allow_collapsible_all ) . '">';
    $output .= $this->getTemplateVariable( 'tabs-list-top' );
    $output .= $this->getTemplateVariable( 'tabs-list-left' );
    $output .= '<div class="vc_tta-panels-container">';
    $output .= $this->getTemplateVariable( 'pagination-top' );
    $output .= '<div class="vc_tta-panels">';
    $output .= $prepareContent;
    $output .= '</div>';
    $output .= $this->getTemplateVariable( 'pagination-bottom' );
    $output .= '</div>';
    $output .= $this->getTemplateVariable( 'tabs-list-bottom' );
    $output .= $this->getTemplateVariable( 'tabs-list-right' );
    $output .= '</div>';
    $output .= '</div>';
    
    echo $output;
}
else {
    $this->setGlobalTtaInfo();
    
    $this->enqueueTtaScript();
    
    // It is required to be before tabs-list-top/left/bottom/right for tabs/tours
    $prepareContent = $this->getTemplateVariable( 'content' );
    
    $class_to_filter = $this->getTtaGeneralClasses();
    $class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
    
    $output = '<div ' . $this->getWrapperAttributes() . '>';
    $output .= $this->getTemplateVariable( 'title' );
    $output .= '<div class="' . esc_attr( $css_class ) . '">';
    $output .= $this->getTemplateVariable( 'tabs-list-top' );
    $output .= $this->getTemplateVariable( 'tabs-list-left' );
    $output .= '<div class="vc_tta-panels-container">';
    $output .= $this->getTemplateVariable( 'pagination-top' );
    $output .= '<div class="vc_tta-panels">';
    $output .= $prepareContent;
    $output .= '</div>';
    $output .= $this->getTemplateVariable( 'pagination-bottom' );
    $output .= '</div>';
    $output .= $this->getTemplateVariable( 'tabs-list-bottom' );
    $output .= $this->getTemplateVariable( 'tabs-list-right' );
    $output .= '</div>';
    $output .= '</div>';
    
    echo $output;
}


