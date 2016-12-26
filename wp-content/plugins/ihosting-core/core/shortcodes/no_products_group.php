<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'vc_before_init', 'noProductsGroup' );
function noProductsGroup() {
    if ( !class_exists( 'WooCommerce' ) ) {
        return;
    }
    global $kt_vc_anim_effects_in;
    vc_map( 
        array(
            'name'        => __( 'N Products Group', 'ihosting-core' ),
            'base'        => 'no_products_group', // shortcode
            'class'       => '',
            'category'    => __( 'iHosting', 'ihosting-core'),
            'params'      => array(
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Enable Group Description', 'ihosting-core' ),
                    'param_name'    => 'enable_group_desc',
                    'value' => array(
                        __( 'Yes', 'theone-core' ) => 'yes',
                        __( 'No', 'theone-core' ) => 'no'		    
                    ),
                    'std'           => 'yes',
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Title', 'ihosting-core' ),
                    'param_name'    => 'title',
                    'std'           => __( 'Furniture design', 'ihosting-core' ),
                    'dependency' => array(
    				    'element' => 'enable_group_desc',
    				    'value' => array( 'yes' )
    			   	),
                ),
                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Short Description', 'ihosting-core' ),
                    'param_name'    => 'short_desc',
                    'std'           => __( 'Monotonectally recaptiualize leading-edge', 'ihosting-core' ),
                    'dependency' => array(
    				    'element' => 'enable_group_desc',
    				    'value' => array( 'yes' )
    			   	),
                ),
                array(
                    'type'          => 'vc_link',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Link', 'ihosting-core' ),
                    'param_name'    => 'link',
                    'dependency' => array(
    				    'element' => 'enable_group_desc',
    				    'value' => array( 'yes' )
    			   	),
                ),
                array(
                    'type'          => 'attach_image',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Icon Image', 'ihosting-core' ),
                    'param_name'    => 'icon_img',
                    'dependency' => array(
    				    'element' => 'enable_group_desc',
    				    'value' => array( 'yes' )
    			   	),
                ),
                array(
                    'type'          => 'autocomplete',
                    'holder'        => '',
                    'class'         => '',
                    'heading'       => __( 'Product 1', 'ihosting-core' ),
                    'param_name'    => 'product_1',
                    'std'           => '',
                    'description'   => __( 'Input product ID or product title to see suggestions.', 'ihosting-core' )
                ),
                array(
                    'type'          => 'autocomplete',
                    'holder'        => '',
                    'class'         => '',
                    'heading'       => __( 'Product 2', 'ihosting-core' ),
                    'param_name'    => 'product_2',
                    'std'           => '',
                    'description'   => __( 'Input product ID or product title to see suggestions.', 'ihosting-core' )
                ),
                array(
                    'type'          => 'autocomplete',
                    'holder'        => '',
                    'class'         => '',
                    'heading'       => __( 'Product 3', 'ihosting-core' ),
                    'param_name'    => 'product_3',
                    'std'           => '',
                    'description'   => __( 'Input product ID or product title to see suggestions.', 'ihosting-core' ),
                    'dependency' => array(
    				    'element' => 'enable_group_desc',
    				    'value' => array( 'no' )
    			   	),
                ),
                array(
                    'type'          => 'autocomplete',
                    'holder'        => '',
                    'class'         => '',
                    'heading'       => __( 'Product 4', 'ihosting-core' ),
                    'param_name'    => 'product_4',
                    'std'           => '',
                    'description'   => __( 'Input product ID or product title to see suggestions.', 'ihosting-core' ),
                ),
                array(
                    'type'          => 'autocomplete',
                    'holder'        => '',
                    'class'         => '',
                    'heading'       => __( 'Product With Big Image', 'ihosting-core' ),
                    'param_name'    => 'product_big',
                    'std'           => '',
                    'description'   => __( 'Input product ID or product title to see suggestions.<br /> This product will show image x4 bigger than others in group.', 'ihosting-core' )
                ),
                array(
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __( 'Big Product Position', 'ihosting-core' ),
                    'param_name'    => 'big_product_pos',
                    'value' => array(
                        __( 'Left', 'theone-core' ) => 'left',
                        __( 'Right', 'theone-core' ) => 'right'		    
                    ),
                    'std'           => 'left',
                    'description'   => __( 'Show product with big image on left or right', 'ihosting-core' )
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

add_filter( 'vc_autocomplete_no_products_group_product_1_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_no_products_group_product_1_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_no_products_group_product_2_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_no_products_group_product_2_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_no_products_group_product_3_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_no_products_group_product_3_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_no_products_group_product_4_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_no_products_group_product_4_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
add_filter( 'vc_autocomplete_no_products_group_product_big_callback', 'ihosting_vc_include_field_product_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_no_products_group_product_big_render', 'ihosting_vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)


function no_products_group( $atts ) {
    global $ihosting;
    
    $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'no_products_group', $atts ) : $atts;
    
    if ( !class_exists( 'WooCommerce' ) ):
        return false;
    endif;
    
    extract( shortcode_atts( array(
        'enable_group_desc' =>  'yes',
        'title'             =>  '',
        'short_desc'        =>  '',
        'link'              =>  '',
        'icon_img'          =>  0, // 85x85
        'product_1'         =>  '',
        'product_2'         =>  '',
        'product_3'         =>  '',
        'product_4'         =>  '',
        'product_big'       =>  '',
        'big_product_pos'   =>  'left',
        'css_animation'     =>  '',
        'animation_delay'   =>  '0.4',  // In second
        'css'               =>  '',
	), $atts ) );
    
    $css_class = 'ihosting-products-group-wrap';
    if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
        $css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    endif;  
    
    $animation_delay_big_img = $animation_delay;
    if ( !is_numeric( $animation_delay ) ) {
        $animation_delay = 0;
        $animation_delay_big_img = 0;
    }
    //$animation_delay = $animation_delay . 's';
    
    $product_ids = array();
    
    $product_ids[] = intval( $product_1 );
    $product_ids[] = intval( $product_2 );
    $product_ids[] = intval( $product_3 );
    $product_ids[] = intval( $product_4 );
    $product_ids[] = intval( $product_big );
    
    $args = array(
		'post_type'				=> 'product',
		'post_status' 			=> 'publish',
        'post__in'              => $product_ids,
		'ignore_sticky_posts'	=> 1
	);
    
    $link_default = array(
        'url'       =>  '',
        'title'     =>  '',
        'target'    =>  ''
    );
    
    if ( function_exists( 'vc_build_link' ) ):
        $link = vc_build_link( $link );
    else:
        $link = $link_default;
    endif;
    
    $icon_img = ihosting_core_resize_image( $icon_img, null, 85, 85, false, false, false );
    $product_no_img = ihosting_core_resize_image( get_post_thumbnail_id( $product_1 ), null, 464, 467, true, true, false );
    $img_alt = get_post_meta( get_post_thumbnail_id( $product_1 ), '_wp_attachment_image_alt', true );
    $img_alt = trim( $img_alt ) == '' ? get_the_title( $product_1 ) : '';
    
    $html = '';
    $col_1_html = ''; // Small product images
    $col_2_html = ''; // Big product image
    $product_1_html = '<a href="' . esc_url( get_permalink( $product_1 ) ) . '">
							<figure><img width="464" height="467" src="' . esc_attr( $product_no_img['url'] ) . '" alt="' . esc_attr( $img_alt ) . '"></figure>
						</a>';
    $product_no_img = ihosting_core_resize_image( get_post_thumbnail_id( $product_2 ), null, 464, 467, true, true, false );
    $img_alt = get_post_meta( get_post_thumbnail_id( $product_2 ), '_wp_attachment_image_alt', true );
    $img_alt = trim( $img_alt ) == '' ? get_the_title( $product_2 ) : '';
    $product_2_html = '<a href="' . esc_url( get_permalink( $product_2 ) ) . '">
							<figure><img width="464" height="467" src="' . esc_attr( $product_no_img['url'] ) . '" alt="' . esc_attr( $img_alt ) . '"></figure>
						</a>';
    $product_no_img = ihosting_core_resize_image( get_post_thumbnail_id( $product_3 ), null, 464, 467, true, true, false );
    $img_alt = get_post_meta( get_post_thumbnail_id( $product_3 ), '_wp_attachment_image_alt', true );
    $img_alt = trim( $img_alt ) == '' ? get_the_title( $product_3 ) : '';
    $product_3_html = '<a href="' . esc_url( get_permalink( $product_3 ) ) . '">
							<figure><img width="464" height="467" src="' . esc_attr( $product_no_img['url'] ) . '" alt="' . esc_attr( $img_alt ) . '"></figure>
						</a>';
    $product_no_img = ihosting_core_resize_image( get_post_thumbnail_id( $product_4 ), null, 464, 467, true, true, false );
    $img_alt = get_post_meta( get_post_thumbnail_id( $product_4 ), '_wp_attachment_image_alt', true );
    $img_alt = trim( $img_alt ) == '' ? get_the_title( $product_4 ) : '';
    $product_4_html = '<a href="' . esc_url( get_permalink( $product_4 ) ) . '">
							<figure><img width="464" height="467" src="' . esc_attr( $product_no_img['url'] ) . '" alt="' . esc_attr( $img_alt ) . '"></figure>
						</a>';
    $product_no_img = ihosting_core_resize_image( get_post_thumbnail_id( $product_big ), null, 928, 934, true, true, false );
    $img_alt = get_post_meta( get_post_thumbnail_id( $product_big ), '_wp_attachment_image_alt', true );
    $img_alt = trim( $img_alt ) == '' ? get_the_title( $product_big ) : '';
    $product_big_html = '<a href="' . esc_url( get_permalink( $product_big ) ) . '">
							<figure><img width="928" height="934" src="' . esc_attr( $product_no_img['url'] ) . '" alt="' . esc_attr( $img_alt ) . '"></figure>
						</a>';
    
    $group_icon_html = trim( $icon_img['url'] != '' ) ? '<span class="icon-cat"><img width="85" height="85" src="' . esc_attr( $icon_img['url'] ) . '" alt=""></span>' : '';
    $group_title_html = trim( $link['url'] != '' ) ? '<h4><a href="' . esc_attr( $link['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" title="' . esc_attr( $link['title'] ) . '">' . sanitize_text_field( $title ) . '</a></h4>' : '<h4>' . sanitize_text_field( $title ) . '</h4>';
    $short_desc_html = trim( $short_desc != '' ) ? '<p>' . sanitize_text_field( $short_desc ) . '</p>' : '';
    $group_desc_html = '<div class="width50 product-catinfo products-group-info">
    						<div class="inforcat">
    							' . $group_icon_html . '
    							' . $group_title_html . '
    							' . $short_desc_html . '
    						</div><!-- /.inforcat -->
    					</div><!-- /.products-group-info -->';
    
    $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
    $total_products = $products->post_count;
    $i = 0;
    $product_ids_queried = array(); 
    
    $enable_product_overlay = isset( $ihosting['opt_enable_product_overlay'] ) ? $ihosting['opt_enable_product_overlay'] == 1 : true;
    $enable_product_img_clickable = isset( $ihosting['woo_product_image_clickable'] ) ? $ihosting['woo_product_image_clickable'] == 1 : true;
    $product_innercotent_class = $enable_product_overlay ? 'product-innercotent' : 'product-innercotent no-overlay';
    $product_innercotent_class .= $enable_product_img_clickable ? ' product-img-clickable' : '';
    
    ?>
    
    <?php if ( $products->have_posts() ): ?>
        
        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
            <?php
            $product = new WC_Product( get_the_ID() ); 
            $product_ids_queried[] = get_the_ID();
            
            for ( $i = 1; $i <= 4; $i++ ):
                $pro_id = 'product_' . $i;
                if ( get_the_ID() == intval( $$pro_id ) ): 
                    
                    $add_to_cart_html = '';
                    ob_start();
                    //wc_get_template( 'loop/add-to-cart.php' );
                    woocommerce_template_loop_add_to_cart();
                    $add_to_cart_html = ob_get_clean();
                
                    $animation_delay += 0.2;
                    
                    $pro_html = 'product_' . $i . '_html';
                    
                    $$pro_html = '<div class="width50 product-item wow ' . esc_attr( $css_animation ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . 's">
                                    <div class="' . esc_attr( $product_innercotent_class ) . '">
                                        ' . $$pro_html /* Product image with link */ . ' 
                                        <div class="info-product">
                                            <h3 class="title-product"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>
                                            <span class="price-product">' . $product->get_price_html() . '</span>
                                            <a class="ts-viewdetail" href="' . get_permalink() . '"><span class="icon icon-arrows-slim-right"></span></a>
                                        </div><!-- /.info-product -->
                                        <div class="ts-product-button">
                							' . ihosting_add_wishlist_btn( get_the_ID(), false ) . '
                                            ' . ihosting_add_quick_view_button( get_the_ID(), false ) . '
                                            ' . $add_to_cart_html . '
                						</div><!-- /.ts-product-button -->
                                    </div><!-- /.' . esc_attr( $product_innercotent_class ) . ' -->
                                </div><!-- /.product-item -->';
                endif; // End if ( get_the_ID() == intval( $$pro_id ) )
            endfor;
            
            if ( get_the_ID() == intval( $product_big ) ): 
                
                $add_to_cart_html = '';
                ob_start();
                woocommerce_template_loop_add_to_cart();
                $add_to_cart_html = ob_get_clean();
                
                $product_big_html = '<div class="product-item wow ' . esc_attr( $css_animation ) . '" data-wow-delay="' . esc_attr( $animation_delay_big_img ) . 's">
                                        <div class="' . esc_attr( $product_innercotent_class ) . '">
                                            ' . $product_big_html /* Product image with link */ . ' 
                                            <div class="info-product">
                                                <h3 class="title-product"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>
                                                <span class="price-product">' . $product->get_price_html() . '</span>
                                                <a class="ts-viewdetail" href="' . get_permalink() . '"><span class="icon icon-arrows-slim-right"></span></a>
                                            </div><!-- /.info-product -->
                                            <div class="ts-product-button">
                    							' . ihosting_add_wishlist_btn( get_the_ID(), false ) . '
                                                ' . ihosting_add_quick_view_button( get_the_ID(), false ) . '
                                                ' . $add_to_cart_html . '
                    						</div><!-- /.ts-product-button -->
                                        </div><!-- /.' . esc_attr( $product_innercotent_class ) . ' -->
                                    </div><!-- /.product-item -->';
                
            endif; // End if ( get_the_ID() == intval( $product_1 ) ) ?>
            
        <?php endwhile; ?>
                
    <?php endif; // End if ( $products->have_posts() ) ?>
    
    <?php
        
    wp_reset_postdata();
    
    // Wrap missing products (not queried or does not exist)
    for ( $i = 1; $i <= 4; $i++ ):
        
        $pro_id = 'product_' . $i;
        if ( !in_array( $$pro_id, $product_ids_queried ) ) {
            $animation_delay += 0.2;
            
            $pro_html = 'product_' . $i . '_html';
            $$pro_html = '<div class="width50 product-item wow ' . esc_attr( $css_animation ) . '" data-wow-delay="' . esc_attr( $animation_delay ) . 's">
                                <div class="product-innercotent">
                                    ' . $$pro_html /* Product image with link */ . ' 
                                </div><!-- /.product-innercotent -->
                            </div><!-- /.product-item -->';
        }
        
    endfor;
    
    if ( trim( $enable_group_desc ) != 'yes' ) {
        $group_desc_html = $product_3_html;
    }
    
    $product_group_class = trim( $big_product_pos ) == 'left' ? 'cat-right' : 'cat-left';
    
    $col_1_html .= '<div class="product-column1 width50">';
    $col_1_html .= '<div class="row-one">';
    $col_1_html .= $product_1_html . $product_2_html;
    $col_1_html .= '</div><!-- /.row-one -->';
    $col_1_html .= '<div class="row-two">';
    $col_1_html .= $group_desc_html . $product_4_html;
    $col_1_html .= '</div><!-- /.row-two -->';
    $col_1_html .= '</div><!-- /.product-column1 -->';
    
    $col_2_html .= '<div class="product-column2 width50">';
    $col_2_html .= $product_big_html;
    $col_2_html .= '</div><!-- /.product-column2  -->';
    
    $html .= '<div class="' . esc_attr( $css_class ) . '">';
    $html .= '<div class="ts-shortcode-category ' . esc_attr( $product_group_class ) . '">'; 
    $html .= $col_1_html;
    $html .= $col_2_html;
    $html .= '</div><!-- /.ts-shortcode-category -->';
    $html .= '</div><!-- /.' . esc_attr( $css_class ) . ' -->';
    
    return $html;
    
}

add_shortcode( 'no_products_group', 'no_products_group' );
