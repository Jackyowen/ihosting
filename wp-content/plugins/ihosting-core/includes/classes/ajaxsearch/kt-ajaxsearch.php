<?php

Class KT_AJAX_SEARCH{
	function __construct(){
		$kt_wcajs_enable = kt_wcajs_get_option('kt_wcajs_enable','');
		if( $kt_wcajs_enable && $kt_wcajs_enable == 'on'){
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'wp_ajax_kt_ajax_search_products', array( $this, 'ajax_search_products' ) );
	        add_action( 'wp_ajax_nopriv_kt_ajax_search_products', array( $this, 'ajax_search_products' ) );

	        add_action('kt_wcajs_before_shop_loop_item_title',array($this,'result_loop_product_thumbnail'),10);
	        add_action('kt_wcajs_shop_loop_item_title','woocommerce_template_loop_product_title',10);
	        add_action('kt_wcajs_after_shop_loop_item_title','woocommerce_template_loop_price',10);
		}
        
	}

	function enqueue_scripts(){
		wp_enqueue_style( 'kt_wcajs', KT_WCAJS_CSS_URL .'/kt_wcajs.min.css');
		wp_enqueue_script( 'kt_wcajs', KT_WCAJS_JS_URL .'/kt_wcajs.min.js', array( 'jquery' ), '1.0.0', true );
		$kt_wcajs_min_char = kt_wcajs_get_option('kt_wcajs_min_char',3);
		wp_localize_script( 'kt_wcajs', 'kt_wcajs_fontend', array(
			'ajaxurl'           => admin_url( 'admin-ajax.php' ),
			'security'          => wp_create_nonce( 'kt_wcajs_fontend' ),
			'kt_wcajs_min_char' => $kt_wcajs_min_char
		) );
	}

	function ajax_search_products(){
		global $woocommerce;
        $search_keyword =  $_REQUEST['keyword'];

        $link_all = get_site_url()."/?post_type=product&s=".$search_keyword;

        $ordering_args = $woocommerce->query->get_catalog_ordering_args( 'title', 'asc' );
        $suggestions   = array();
        $kt_wcajs_max_results  = kt_wcajs_get_option('kt_wcajs_max_results',3);
        $args = array(
            's'                   => $search_keyword,
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby'             => $ordering_args['orderby'],
            'order'               => $ordering_args['order'],
            'posts_per_page'      => $kt_wcajs_max_results,
            'suppress_filters'    => false,
            'meta_query'          => array(
                array(
                    'key'     => '_visibility',
                    'value'   => array( 'search', 'visible' ),
                    'compare' => 'IN'
                )
            )
        );

        if ( isset( $_REQUEST['product_cat'] ) ) {
            $args['tax_query'] = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $_REQUEST['product_cat']
                ) );
        }


        $products = new WP_Query($args);
        ob_start();
        if( $products->have_posts()){
        	?>
        	<ul class="kt_wcajs_products">
        	<?php
        	while ( $products->have_posts() ) {
        	   	$max_num_page = $products->max_num_pages;
            	$query_paged  = $products->query_vars['paged']+1;
               	$products->the_post();
               	wc_get_template( 'wcajs_search_results.php', array(), '', KT_WCAJS_TEMPLATE_PATH . '/' );
            }
            ?>
            </ul>
            <?php if($query_paged >= 0 && ($query_paged < $max_num_page)):?>
	    	<div class="view-all-result">
	        	<a href="<?php echo esc_url($link_all);?>"><?php esc_html_e('View All','kute-toolkit');?></a>
	        </div>
	    	<?php endif;?>
            <?php
        }else{
        	?>
        	<ul class="no_result">
        		<li>
        			<?php esc_html_e('No results','kute-toolkit');?>
        		</li>
        	</ul>
        	<?php
        }

        wp_reset_postdata();
        wp_reset_query();
    	die();
	}


	function result_loop_product_thumbnail(){
		echo woocommerce_get_product_thumbnail('shop_thumbnail');
	}
}