<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package iHosting
 */

$ihosting = ihosting_get_global_theme_options();
$title_404 = isset( $ihosting['opt_404_header_title'] ) ? $ihosting['opt_404_header_title'] : esc_html__( '404', 'ihosting' );
$subtitle_404 = isset( $ihosting['opt_404_subtitle'] ) ? $ihosting['opt_404_subtitle'] : esc_html__( 'Oops! That page can\'t be found.', 'ihosting' );
$text_404 = isset( $ihosting['opt_404_text'] ) ? $ihosting['opt_404_text'] : esc_html__( 'It looks like nothing was found at this location. Maybe try a search?', 'ihosting' );
$img_404 = isset( $ihosting['opt_404_img'] ) ? $ihosting['opt_404_img'] : array( 'url' => get_template_directory_uri() . '/assets/images/page404.png' );
$enable_search_form = isset( $ihosting['opt_enable_search_form_on_404'] ) ? $ihosting['opt_enable_search_form_on_404'] == 1 : true;

get_header(); ?>

<div id="primary" class="content-area col-xs-12">
	<main id="main" class="site-main" role="main">

		<div class="page-inner page-404">
			<div class="content-404 text-center">
				<?php if ( trim( $img_404['url'] ) != '' ): ?>
					<figure><img src="<?php echo esc_url( $img_404['url'] ); ?>" alt="404"/></figure>
				<?php endif; // End if ( trim( $img_404['url'] ) != '' ) ?>
				<?php if ( trim( $title_404 ) != '' ): ?>
					<h1 class="title-404"><?php echo sanitize_text_field( $title_404 ); ?></h1>
				<?php endif; // End if ( trim( $title_404 ) != '' ) ?>
				<?php if ( trim( $subtitle_404 ) != '' ): ?>
					<h2 class="subtitle-404"><?php echo sanitize_text_field( $subtitle_404 ); ?></h2>
				<?php endif; // End if ( trim( $subtitle_404 ) != '' ) ?>
				<?php if ( trim( $text_404 ) != '' ): ?>
					<p class="text-404"><?php echo sanitize_text_field( $text_404 ); ?></p>
				<?php endif; // End if ( trim( $text_404 ) != '' ) ?>
				<?php if ( $enable_search_form ) { ?>
					<?php get_search_form(); ?>
				<?php } ?>
			</div>
		</div>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
