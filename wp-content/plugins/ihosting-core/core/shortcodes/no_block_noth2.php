<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noiHosting2' );
function noiHosting2() {
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N iHosting Home Page 2', 'ihosting-core' ),
            'base'        => 'no_block_noth2', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting Blocks', 'ihosting-core' ),
            'params'      => array(
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'iHosting 2', 'ihosting-core' ),
                ),
            )
        )
    );
}

function no_block_noth2( $atts ) {
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_block_noth2', $atts ) : $atts;
    
    extract( shortcode_atts( array(
        'title'             =>  ''
	), $atts ) );
    
    $block = '[vc_row full_width="stretch_row_content_no_spaces" equal_columns="true" css=".vc_custom_1444894621533{margin-bottom: 0px !important;}"][vc_column width="1/2"][no_products_slide cat_id="197" number_of_items="3" autoplay_timeout="5000"][/vc_column][vc_column width="1/2" css=".vc_custom_1444896708505{background-image: url(http://dev.kute-themes.com/ihosting/wp-content/uploads/2015/10/pattern1.png?id=1893) !important;}"][vc_raw_html]JTNDZGl2JTIwY2xhc3MlM0QlMjJhYm91dC10ZXh0JTIyJTNFJTBBJTA5JTA5JTA5JTA5JTA5JTNDZGl2JTIwY2xhc3MlM0QlMjJ0ZXh0LWFib3V0Y29udGVudCUyMiUzRSUwQSUwOSUwOSUwOSUwOSUwOSUwOSUzQ2gyJTNFSGVsbG8uJTIwd2UlMjBhcmUlMjAlM0NzdHJvbmclM0Vub3J0aCUyMHN0b3JlJTNDJTJGc3Ryb25nJTNFJTIwaW1wcm92ZW1lbnRzJTIwd2l0aCUyMGJyaWNrcy1hbmQtY2xpY2tzJTIwZ3Jvd3RoJTIwJTNDc3Ryb25nJTNFc3RyYXRlZ2llcyUyMGNoYWlucy4lM0MlMkZzdHJvbmclM0UlM0MlMkZoMiUzRSUwQSUwOSUwOSUwOSUwOSUwOSUzQyUyRmRpdiUzRSUwQSUwOSUwOSUwOSUwOSUzQyUyRmRpdiUzRQ==[/vc_raw_html][/vc_column][/vc_row][vc_row full_width="stretch_row_content_no_spaces" css=".vc_custom_1444732285007{margin-bottom: 0px !important;}"][vc_column][no_products_group product_1="93" product_2="99" product_4="96" product_big="76" big_product_pos="right" icon_img="1738"][no_products_group title="Bags & Backpacks" short_desc="Discover even more..." product_1="93" product_2="99" product_4="96" product_big="76" icon_img="1817"][/vc_column][/vc_row][vc_row full_width="stretch_row_content"][vc_column width="1/3"][no_title_desc icon="icon-basic-sheet-pen" img_id="1749"][/vc_column][vc_column width="1/3"][no_news_letter img_id="1753"][/vc_column][vc_column width="1/3"][no_title_desc title="Faqs" icon="icon-basic-question" img_id="1756"][/vc_column][/vc_row]';
    
    $html = apply_filters( 'the_content', $block );
    
    return $html;
    
}

add_shortcode( 'no_block_noth2', 'no_block_noth2' );
