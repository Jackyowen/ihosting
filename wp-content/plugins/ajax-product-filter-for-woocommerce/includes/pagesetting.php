<?php if ( ! defined( 'ABSPATH' ) ) exit;

$plugin_dir_url=plugin_dir_url(__FILE__);
	
if ( ! empty( $_POST ) && check_admin_referer( 'phoe_Ajax_Product_Filter_form_action', 'phoe_Ajax_Product_Filter_form_nonce_field' ) ) {

	if(sanitize_text_field( $_POST['ajax_submit'] ) == 'Save'){
		
		$enable_ajax=isset($_POST['enable_ajax'])?$_POST['enable_ajax']:'';
		
		$next_Selector=sanitize_text_field($_POST['next_Selector']);
		
		$content_Selector=sanitize_text_field($_POST['content_Selector']);
		
		$item_Selector=sanitize_text_field($_POST['item_Selector']);
		if($content_Selector=='')
	{
		$content_Selector=".products";
	}
	
	if($next_Selector=='')
	{
		$next_Selector=".next";
	}
	
	
	if($item_Selector=='')
	{
		$item_Selector=".product";
	}
		
		
		$phoe_Ajax_Product_Filter_value = array(
		
		'enable_ajax'=>$enable_ajax,
		
		'content_Selector'=>$content_Selector,
		
		'next_Selector'=>$next_Selector,
		
		'item_Selector'=>$item_Selector
		
		
		);
		
		update_option('phoe_Ajax_Product_Filter_value',$phoe_Ajax_Product_Filter_value);
		
	}
	
}
 
	$gen_settings = get_option('phoe_Ajax_Product_Filter_value');

			$enable_ajax=isset($gen_settings['enable_ajax'])?$gen_settings['enable_ajax']:'';
			
			$content_Selector=isset($gen_settings['content_Selector'])?$gen_settings['content_Selector']:'';
			
			$next_Selector=isset($gen_settings['next_Selector'])?$gen_settings['next_Selector']:'';
			
			$item_Selector=isset($gen_settings['item_Selector'])?$gen_settings['item_Selector']:'';
			
			$product_shown=isset($gen_settings['product_shown'])?$gen_settings['product_shown']:'';
 ?>

	<div id="phoe_Ajax_Product_Filter_profile-page" class="phoe_Ajax_Product_Filter_wrap ajax_setting">

		<div class="pho-upgrade-btn">
			<a target="_blank" href="https://www.phoeniixx.com/product/ajax-product-filter-woocommerce/"><img src="<?php echo $plugin_dir_url; ?>../assets/images/premium-btn.png"></a>
			<a target="_blank" href="https://phoeniixx.com/demo/woocommerce/ajax-product-filter/shop/"><img src="<?php echo $plugin_dir_url; ?>../assets/images/button2.png"></a>
		</div>
	
		<form method="post" id="phoe_Ajax_Product_Filter_form" action="" >
		
			<?php wp_nonce_field( 'phoe_Ajax_Product_Filter_form_action', 'phoe_Ajax_Product_Filter_form_nonce_field' ); ?>
			
			<table class="form-table">
				
				<tbody>	
		
					<tr class="phoeniixx_phoe_Ajax_Product_Filter_wrap">
				
						<th>
						
							<label><?php _e('Enable Ajax Product Filter','phoen-ajax-product-Filter'); ?> </label>
							
						</th>
						
						<td>
						
							<input type="checkbox"  name="enable_ajax" id="enable_ajax" value="1" <?php echo(isset($gen_settings['enable_ajax']) && $gen_settings['enable_ajax'] == '1')?'checked':'';?>>
							
						</td>
						
					</tr>
		
					<tr class="phoeniixx_phoe_Ajax_Product_Filter_wrap">
					
						<th colspan="2"><label><?php _e('Note:','phoen-ajax-product-Filter'); ?> </label>"Selectors can be ID or Class: If ID use '#id_name' and if Class use '.class_name' " </th>
					
					</tr>
				
					<tr class="phoeniixx_phoe_Ajax_Product_Filter_wrap">
						
						<th>	
						
							<label><?php _e('Content Selector On Shop page','phoen-ajax-product-Filter'); ?></label>
						
						</th>
						
						<td>
						
							<input type="text" value="<?php echo $content_Selector;?>" name="content_Selector" id="content_Selector" class="regular-text">
							
						</td>
					
					</tr>
		
					<tr class="phoeniixx_phoe_Ajax_Product_Filter_wrap">
						
						<th>
						
							<label><?php _e('Next Selector On Shop page','phoen-ajax-product-Filter'); ?></label>
							
						</th>
						
						<td>
						
							<input type="text" value="<?php echo $next_Selector;?>" name="next_Selector" id="next_Selector" class="regular-text">
							
						</td>
					
					</tr>
		
					<tr class="phoeniixx_phoe_Ajax_Product_Filter_wrap">
						
						<th>
						
							<label><?php _e('Item Selector On Shop page','phoen-ajax-product-Filter'); ?></label>
						
						</th>
						
						<td>
						
							<input type="text" value="<?php echo $item_Selector;?>" name="item_Selector" id="item_Selector" class="regular-text">
							
						</td>
					
					</tr>
		
					<tr class="phoeniixx_phoe_Ajax_Product_Filter_wrap">
					
						<td colspan="2">
						
							<input type="submit" value="Save" name="ajax_submit" id="submit" class="button button-primary">
						
						</td>
						
					</tr>
		
				</tbody>
				
			</table>
			
		</form>
		
	</div>
	<style>
	
	
	.pho-upgrade-btn {
		margin-top: 30px;
	}
	
	.pho-upgrade-btn a:focus {
		box-shadow: none;
	}
	
	</style>