<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package iHosting
 */

$primary_class = ihosting_primary_class();

get_header(); ?>

<div id="primary" class="content-area <?php echo esc_attr( $primary_class ); ?>">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php
			// Previous/next post navigation.
			the_post_navigation(
				array(
					'next_text' => '<span class="meta-nav meta-nav-next button" aria-hidden="true"><span class="next-post">' . esc_html__( 'Next post', 'ihosting' ) . '</span><i class="fa fa-long-arrow-right"></i></span> ' .
					               '<span class="screen-reader-text">' . esc_html__( 'Next post: %title', 'ihosting' ) . '</span> ',
					'prev_text' => '<span class="meta-nav meta-nav-prev button" aria-hidden="true"><span class="prev-post">' . esc_html__( 'Previous post', 'ihosting' ) . '</span><i class="fa fa-long-arrow-left"></i></span> ' .
					               '<span class="screen-reader-text">' . esc_html__( 'Previous post: %title', 'ihosting' ) . '</span> ',
				)
			);

			?>

			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>

		<?php endwhile; // End of the loop. ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar( 'single' ); ?>
<?php get_footer(); ?>
