<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iHosting
 */

$footer_settings = ihosting_get_footer_settings();

?>
</div><!-- /.row -->
</div><!-- /.site-content-inner -->
</div><!-- #main-container -->

<footer id="colophon" class="site-footer" role="contentinfo"
        style="background-color: <?php echo esc_attr( $footer_settings['bg_color'] ); ?>;">

	<div class="footer-top">
		<div class="container">
			<?php
			echo wptexturize( $footer_settings['footer_content'] );
			?>
		</div>
	</div><!-- /.footer-top -->

	<?php if ( $footer_settings['footer_enable_mid'] ) { ?>
		<div class="footer-mid">
			<div class="container">
				<div class="row">
					<?php echo wptexturize( $footer_settings['footer_copyright_text'] ); ?>
					<?php echo wptexturize( $footer_settings['social_links_html'] ); ?>
				</div>
			</div>
		</div><!-- /.footer-bottom -->
	<?php } ?>

	<?php if ( $footer_settings['footer_enable_bottom'] ) { ?>
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<?php echo wptexturize( $footer_settings['footer_bottom_text'] ); ?>
				</div>
			</div>
		</div><!-- /.footer-bottom -->
	<?php } ?>

	<a href="#" class="back-to-top">
		<i class="fa fa-angle-double-up"></i>
		<span><?php esc_html_e( 'To top', 'ihosting' ); ?></span>
	</a>

</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
