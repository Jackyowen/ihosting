<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

global $ihosting;

if ( trim( $ihosting['opt_twitter_link'] . $ihosting['opt_fb_link'] . $ihosting['opt_google_plus_link'] . $ihosting['opt_dribbble_link'] . 
    $ihosting['opt_behance_link'] . $ihosting['opt_tumblr_link'] . $ihosting['opt_instagram_link'] . $ihosting['opt_pinterest_link'] . 
    $ihosting['opt_youtube_link'] . $ihosting['opt_vimeo_link'] . $ihosting['opt_linkedin_link'] .  $ihosting['opt_rss_link'] ) != '' ):
?>
    <ul class="social-header">
        <?php get_template_part( 'template-parts/social', 'items' ); ?>
    </ul><!-- /.social-header -->
<?php
endif;
