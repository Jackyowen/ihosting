<?php
/**
 * Template part for displaying single posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iHosting
 */

$ihosting = ihosting_get_global_theme_options();
$enable_author_bio = isset( $ihosting['opt_blog_single_post_bio'] ) ? $ihosting['opt_blog_single_post_bio'] == 1 : true;

?>

<div class="blog-single">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-item' ); ?>>

		<?php ihosting_post_thumbnail(); ?>

		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title post-title">', '</h3>' ); ?>

			<ul class="entry-meta post-meta">
				<?php ihosting_posted_on(); ?>
			</ul><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<div class="entry-content content-post">
			<?php the_content(); ?>
			<?php
			wp_link_pages( array(
				               'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'ihosting' ),
				               'after'       => '</div>',
				               'link_before' => '<span>',
				               'link_after'  => '</span>',
				               'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'ihosting' ) . ' </span>%',
				               'separator'   => '<span class="screen-reader-text">, </span>',
			               )
			);
			?>
		</div><!-- .entry-content -->

		<div class="entry-footer entry-links">
			<?php ihosting_entry_single_footer(); ?>
			<?php get_template_part( 'template-parts/single-post-sharing' ); ?>
		</div><!-- .entry-footer -->

		<?php if ( $enable_author_bio ) { ?>
			<?php get_template_part( 'template-parts/author', 'bio' ); ?>
		<?php } ?>

	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- /.blog-single -->



