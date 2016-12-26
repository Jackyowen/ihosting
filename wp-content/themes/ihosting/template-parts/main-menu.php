<?php
/**
 * Template part for displaying Main Menu.
 *
 * @package iHosting
 */

$ihosting = ihosting_get_global_theme_options();
$breakpoint = isset( $ihosting['opt_main_menu_break_point'] ) ? max( 1, intval( $ihosting['opt_main_menu_break_point'] ) ) : 991;
$is_main_menu_sticky = isset( $ihosting['opt_enable_main_menu_sticky'] ) ? $ihosting['opt_enable_main_menu_sticky'] == 1 : true;
$sticky_class = $is_main_menu_sticky ? 'has-main-menu-sticky' : '';

?>

<div class="main-menu-wapper <?php echo esc_attr( $sticky_class ); ?>"
     data-breakpoint="<?php echo esc_attr( $breakpoint ); ?>">
	<a class="mobile-navigation" href="#primary-navigation">
		<span class="icon">
			<span></span>
			<span></span>
			<span></span>
		</span>
		<?php esc_html_e( 'Main Menu', 'ihosting' ); ?>
	</a>
	<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
		<?php wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_class'     => 'primary-menu main-nav kt-nav main-menu',
				'container'      => false,
				'menu_id'        => 'main-menu',
			)
		); ?>
	</nav>
</div>
