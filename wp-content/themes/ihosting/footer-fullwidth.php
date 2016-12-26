<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iHosting
 */

$ihosting = ihosting_get_global_theme_options();

$footer_logo = isset( $ihosting['opt_footer_logo'] ) ? $ihosting['opt_footer_logo'] : array( 'url' => get_template_directory_uri() . '/assets/images/logo-footer.png' );

$footer_copyright_text = isset( $ihosting['opt_footer_copyright_text'] ) ? $ihosting['opt_footer_copyright_text'] : sprintf( esc_html__( 'Proudly powered by %s', 'ihosting' ), 'WordPress' );

?>          </div><!-- /.row -->
        </div><!-- /.site-content-inner -->
	</div><!-- #main-container -->

	<footer id="colophon" class="site-footer" role="contentinfo">
        
        <div class="left-footer">
            <?php if ( trim( $footer_logo['url'] ) != '' ): ?>
                <div class="logo-footer"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $footer_logo['url'] ); ?>" alt="footer_logo" /></a></div>
            <?php endif; // End if ( trim( $footer_logo['url'] ) != '' ) ?>
			<div class="copyright"><?php echo wpautop( $footer_copyright_text ); ?></div>
		</div>
        
        <div class="right-footer">
			<?php get_template_part( 'template-parts/socials', 'footer' ); ?>
            <?php if ( has_nav_menu( 'footer_menu' ) ): ?>
                <?php wp_nav_menu( 
                    array( 'theme_location' => 'footer_menu', 
                        'container'     =>  false,
                        'menu_id'       => 'footer-menu',
                        'menu_class'    => 'menu-footer'
                    ) 
                ); ?>
            <?php endif; // End if ( has_nav_menu( 'footer_menu' ) ) ?>
		</div>
        
        <a class="backtotop" href="#">
            <span class="icon icon-arrows-slim-up"></span>
            <span class="text-totop"><?php esc_html_e( 'Top', 'ihosting' ); ?></span>
        </a>
        
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
