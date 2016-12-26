<?php
/**
 * The template for displaying product search form for header style_1
 *
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-search woocommerce-product-search" method="get"
      role="search">
	<div class="search-input-wrap">
		<input class="input" type="text"
		       placeholder="<?php echo esc_attr_x( 'Search entire store here...', 'placeholder', 'ihosting' ); ?>"
		       value="<?php echo get_search_query(); ?>" name="s"
		       title="<?php echo esc_attr_x( 'Search for:', 'label', 'ihosting' ); ?>" autocomplete="off"/>
	</div>
	<button type="submit" class="btn-search"><span class="flaticon-magnifying-glass34"></span></button>
	<input type="hidden" name="post_type" value="product"/>
</form>