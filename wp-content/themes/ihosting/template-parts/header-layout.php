<?php
/**
 * Template part for displaying header layout.
 *
 * @package iHosting
 */

global $ihosting;
$header_settings = ihosting_get_header_settings();
$header_layout = isset( $header_settings['header_layout'] ) ? $header_settings['header_layout'] : 'style_1';
//
//echo "<pre>";
//print_r( $ihosting['opt_page_heading_color'] );
//echo "</pre>";
//
//echo "<pre>";
//print_r( $ihosting['opt_heading_banner_bg'] );
//echo "</pre>";

?>

<header id="masthead" class="<?php echo esc_attr( $header_settings['header_class'] ); ?>"
        data-header-layout="<?php echo esc_attr( $header_layout ); ?>">
	<div class="main-header">

		<div class="header-top">
			<div class="container">
				<div class="header-top-left">
					<?php echo sanitize_text_field( $header_settings['header_desc'] ); ?>
				</div>
				<div class="header-top-right">
					<?php echo wptexturize( $header_settings['header_top_menu_html'] ); ?>
				</div>
			</div>
		</div>

		<div class="header-bottom">
			<div class="container">
				<div class="header-bottom-left">
					<?php if ( isset( $header_settings['logo']['url'] ) ) { ?>
						<div class="logo">
							<a href="<?php echo esc_url( get_home_url() ); ?>" class="logo-image">
								<img src="<?php echo esc_url( $header_settings['logo']['url'] ); ?>"
								     width="<?php echo esc_attr( $header_settings['logo']['width'] ); ?>"
								     height="<?php echo esc_attr( $header_settings['logo']['height'] ); ?>"
								     alt="<?php esc_attr_e( 'logo', 'ihosting' ); ?>">
							</a>
						</div>
					<?php } ?>
				</div>
				<div class="header-bottom-right">
					<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
						<?php wp_nav_menu(
							array(
								'theme_location' => 'primary'
							)
						); ?>
					</nav>
				</div>
			</div>
		</div>

	</div><!-- /.main-header -->

</header><!-- /#masthead -->





