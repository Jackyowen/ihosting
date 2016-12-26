<?php
/**
 * The template for displaying product search form for header style_3
 *
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div id="search-popup" class="search-popup kt-popup">
	<div class="kt-overlay"></div>
	<div class="popup-inner">
		<div class="container">
			<form action="<?php echo esc_url( home_url( '/' ) ); ?>"
			      class="form-search woocommerce-product-search form-search-popup" method="get"
			      role="search">
				<div class="product-cats-select-wrap">
					<?php echo ihosting_product_cats_dropdown(); ?>
				</div>
				<div class="search-input-wrap">
					<input class="input" type="text"
					       placeholder="<?php echo esc_attr_x( 'Search entire store here...', 'placeholder', 'ihosting' ); ?>"
					       value="<?php echo get_search_query(); ?>" name="s"
					       title="<?php echo esc_attr_x( 'Search for:', 'label', 'ihosting' ); ?>" autocomplete="off"/>
					<button type="submit" class="btn-search"><span class="flaticon-magnifying-glass34"></span></button>
				</div>
				<input type="hidden" name="post_type" value="product"/>
				<input type="hidden" name="taxonomy" value="product_cat"/>
			</form>
		</div>
		<a class="popup-close" href="#">
			<?php esc_html_e( 'x', 'ihosting' ); ?>
		</a>
	</div>
</div>