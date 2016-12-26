<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iHosting
 */

$ihosting = ihosting_get_global_theme_options();

$post_class = 'blog-item post-item';
$blog_layout_style = 'standard'; // default, standard (= list)
$the_excerpt_max_chars = 180;
$allow_the_excerpt = false;
$show_post_grid_excerpt = isset( $ihosting['opt_blog_grid_show_post_excerpt'] ) ? $ihosting['opt_blog_grid_show_post_excerpt'] == 1 : false;

if ( $blog_layout_style == 'standard' ) { // Always $allow_the_excerpt
	$the_excerpt_max_chars = isset( $ihosting['opt_excerpt_max_char_length_standard'] ) ? max( 1, intval( $ihosting['opt_excerpt_max_char_length_standard'] ) ) : 180;
	$allow_the_excerpt = true;
}

if ( $blog_layout_style == 'masonry' ) { // Always $allow_the_excerpt
	$the_excerpt_max_chars = isset( $ihosting['opt_excerpt_max_char_length_masonry'] ) ? max( 1, intval( $ihosting['opt_excerpt_max_char_length_masonry'] ) ) : 180;
	$allow_the_excerpt = true;
}

if ( $blog_layout_style == 'default' ) {
	$the_excerpt_max_chars = isset( $ihosting['opt_excerpt_max_char_length'] ) ? max( 1, intval( $ihosting['opt_excerpt_max_char_length'] ) ) : 180;
	$allow_the_excerpt = isset( $ihosting['opt_blog_loop_content_type'] ) ? $ihosting['opt_blog_loop_content_type'] != 1 : false;
}

$sidebar_pos = isset( $ihosting['opt_blog_sidebar_pos'] ) ? trim( $ihosting['opt_blog_sidebar_pos'] ) : 'right';
if ( in_array( $blog_layout_style, array( 'grid', 'masonry' ) ) ) {
	if ( $sidebar_pos != 'fullwidth' ) {
		$post_class .= ' col-sm-6 linh ' . $sidebar_pos;
	}
	else {
		$post_class .= ' col-sm-4';
	}
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>

	<?php if ( $blog_layout_style == 'standard' ): // list ?>

		<?php ihosting_post_thumbnail(); ?>

		<div class="post-info">
			<?php the_title( sprintf( '<h3 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
			<?php if ( 'post' === get_post_type() ) : ?>
				<ul class="entry-meta post-meta">
					<?php ihosting_posted_on(); ?>
				</ul><!-- /.entry-meta -->
			<?php endif; ?>
			<div class="entry-content content-post">
				<?php echo function_exists( 'ihosting_get_the_excerpt_max_charlength' ) ? ihosting_get_the_excerpt_max_charlength( $the_excerpt_max_chars ) : get_the_excerpt(); ?>
			</div><!-- /.entry-content -->
			<?php echo ihosting_modify_read_more_link(); ?>
			<div class="entry-footer entry-links">
				<?php ihosting_entry_footer(); ?>
			</div><!-- .entry-footer -->
		</div><!-- /.post-info -->

	<?php endif; // End if ( $blog_layout_style == 'standard' ) ?>

	<?php if ( $blog_layout_style == 'grid' ): ?>

		<?php ihosting_post_thumbnail(); ?>

		<div class="post-info">
			<?php the_title( sprintf( '<h3 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
			<?php if ( 'post' === get_post_type() ) : ?>
				<ul class="entry-meta post-meta">
					<?php ihosting_posted_on(); ?>
				</ul><!-- /.entry-meta -->
			<?php endif; ?>
			<?php if ( $show_post_grid_excerpt ) { ?>
				<div class="entry-content content-post">
					<?php echo function_exists( 'ihosting_get_the_excerpt_max_charlength' ) ? ihosting_get_the_excerpt_max_charlength( $the_excerpt_max_chars ) : get_the_excerpt(); ?>
				</div><!-- /.entry-content -->
			<?php } ?>
			<div class="entry-footer entry-links">
				<?php ihosting_entry_footer(); ?>
			</div><!-- .entry-footer -->
		</div><!-- /.post-info -->

	<?php endif; // End if ( $blog_layout_style == 'grid' ) ?>

	<?php if ( $blog_layout_style == 'masonry' ): ?>

		<?php ihosting_post_thumbnail(); ?>

		<div class="post-info">
			<?php the_title( sprintf( '<h3 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
			<?php if ( 'post' === get_post_type() ) : ?>
				<ul class="entry-meta post-meta">
					<?php ihosting_posted_on(); ?>
				</ul><!-- /.entry-meta -->
			<?php endif; ?>
			<div class="entry-content content-post">
				<?php echo function_exists( 'ihosting_get_the_excerpt_max_charlength' ) ? ihosting_get_the_excerpt_max_charlength( $the_excerpt_max_chars ) : get_the_excerpt(); ?>
			</div><!-- /.entry-content -->
			<div class="entry-footer entry-links">
				<?php ihosting_entry_footer(); ?>
			</div><!-- .entry-footer -->
		</div><!-- /.post-info -->

	<?php endif; // End if ( $blog_layout_style == 'masonry' ) ?>

	<?php if ( $blog_layout_style == 'default' ): ?>

		<?php ihosting_post_thumbnail(); ?>

		<header class="entry-header">
			<?php the_title( sprintf( '<h3 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

			<?php if ( 'post' === get_post_type() ) : ?>
				<ul class="entry-meta post-meta">
					<?php ihosting_posted_on(); ?>
				</ul><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content content-post">
			<?php if ( has_excerpt() ) { ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div>
			<?php } ?>
			<?php if ( $allow_the_excerpt ): ?>
				<?php echo function_exists( 'ihosting_get_the_excerpt_max_charlength' ) ? ihosting_get_the_excerpt_max_charlength( $the_excerpt_max_chars ) : get_the_excerpt(); ?>
			<?php else: ?>
				<?php
				the_content(
					sprintf(
					/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ihosting' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					)
				);
				?>

				<?php
				wp_link_pages(
					array(
						'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'ihosting' ),
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'ihosting' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
				?>
			<?php endif; ?>
		</div><!-- .entry-content -->

		<?php if ( $allow_the_excerpt ) {
			echo ihosting_modify_read_more_link();
		} ?>

		<footer class="entry-footer entry-links">
			<?php ihosting_entry_footer(); ?>
		</footer><!-- .entry-footer -->

	<?php endif; // End if ( $blog_layout_style == 'default' ) ?>


</article><!-- #post-<?php the_ID(); ?> -->
