<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iHosting
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

$ihosting = ihosting_get_global_theme_options();

$sidebar_pos = isset( $ihosting['opt_blog_sidebar_pos'] ) ? trim( $ihosting['opt_blog_sidebar_pos'] ) : 'right';
$secondary_class = ihosting_secondary_class();

?>

<?php if ( $sidebar_pos != 'fullwidth' ): ?>

    <div id="secondary" class="widget-area <?php echo esc_attr( $secondary_class ); ?>" role="complementary">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div><!-- #secondary -->

<?php endif; ?>
