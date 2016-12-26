<li data-url="<?php echo esc_attr(get_the_permalink())?>" class="product-item-ajax-serach">
		<div class="thumb">
			<?php
		/**
		 * kt_wcajs_before_shop_loop_item_title hook
		 *
		 * @hooked result_loop_product_thumbnail - 10
		 */
		do_action( 'kt_wcajs_before_shop_loop_item_title' );
		?>
		</div>
		<div class="info">
			<?php
        /**
		 * woocommerce_template_loop_product_title hook
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 * @hooked woocommerce_template_loop_price - 20
		 */
		do_action( 'kt_wcajs_shop_loop_item_title' );
		/**
		 * woocommerce_template_loop_product_title hook
		 *
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'kt_wcajs_after_shop_loop_item_title' );
		?>
		</div>	
</li>