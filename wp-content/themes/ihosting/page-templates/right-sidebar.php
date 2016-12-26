<?php
/**
 * Template Name: Right Sidebar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iHosting
 */

global $ihosting;

$bak_sidebar_pos = isset( $ihosting['opt_blog_sidebar_pos'] ) ? trim( $ihosting['opt_blog_sidebar_pos'] ) : 'right'; // Backup current sidebar position setting
$ihosting['opt_blog_sidebar_pos'] = 'right';  // Force right sidebar
$primary_class = ihosting_primary_class(); // Get primary content area class

get_header(); ?>

	<div id="primary" class="content-area <?php echo esc_attr( $primary_class ); ?>">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php
    // Reset sidebar position setting
    $ihosting['opt_blog_sidebar_pos'] = $bak_sidebar_pos; 
?>

<?php get_footer(); ?>
