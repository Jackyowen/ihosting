<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iHosting
 */

$header_layout = ihosting_get_current_header_layout();

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ihosting' ); ?></a>

	<?php get_template_part( 'template-parts/header-layout', $header_layout ); ?>

	<?php if ( !is_front_page() && !is_home() ) { ?>
		<?php get_template_part( 'template-parts/header', 'banner' ); ?>
	<?php } ?>

	<div id="main-container" class="<?php echo ihosting_main_container_class(); ?>">
		<div class="site-content-inner container">
			<?php //get_template_part( 'template-parts/breadcrumb' ); ?>
			<div class="row">