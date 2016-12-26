<?php
/**
 * Template part for displaying header banner.
 *
 * @package iHosting
 */


$header_banner_settings = ihosting_header_banner_setting();

?>

<div class="header-banner-wrap">
	<div class="ih-heading-banner <?php echo esc_attr( $header_banner_settings['class'] ); ?>"
	     style="height:<?php echo esc_attr( $header_banner_settings['height'] ) . '; ' . htmlentities2( $header_banner_settings['banner_bg_custom_style'] ); ?>">
		<div class="container">
			<?php if ( $header_banner_settings['show_page_heading'] ) { ?>
				<?php echo wptexturize( $header_banner_settings['heading_html'] ); ?>
			<?php } ?>
			<?php if ( $header_banner_settings['show_breadcrumbs'] ) { ?>
				<?php echo wptexturize( $header_banner_settings['breadcrumbs_html'] ); ?>
			<?php } ?>
		</div>
	</div>
</div>
