<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script> <![endif]-->
    <?php wp_head(); ?>
</head>

<?php global $ihosting; ?>

<body <?php body_class( 'body-coming-soon' ); ?>>
<!--Wrapper-->
<div id="main" class="site-main">

    <!-- Header -->
    <header id="header" class="site-header">
    </header>
    <!-- End / Header -->