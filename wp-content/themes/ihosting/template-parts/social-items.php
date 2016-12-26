<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

global $ihosting;

?>

<?php if ( trim( $ihosting['opt_twitter_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_twitter_link'] ); ?>">
        <i class="fa fa-twitter"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Twitter link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_fb_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_fb_link'] ); ?>">
        <i class="fa fa-facebook"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Facebook link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_google_plus_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_google_plus_link'] ); ?>">
        <i class="fa fa-google-plus"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Google Plus link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_dribbble_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_dribbble_link'] ); ?>">
        <i class="fa fa-dribbble"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Dribbble link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_behance_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_behance_link'] ); ?>">
        <i class="fa fa-behance"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Behance link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_tumblr_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_tumblr_link'] ); ?>">
        <i class="fa fa-tumblr"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Tumblr link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_instagram_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_instagram_link'] ); ?>">
        <i class="fa fa-instagram"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Instagram link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_pinterest_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_pinterest_link'] ); ?>">
        <i class="fa fa-pinterest"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Pinterest link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_youtube_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_youtube_link'] ); ?>">
        <i class="fa fa-youtube"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Youtube link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_vimeo_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_vimeo_link'] ); ?>">
        <i class="fa fa-vimeo"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Vimeo link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_linkedin_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_linkedin_link'] ); ?>">
        <i class="fa fa-linkedin"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'LinkedIn link', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>
<?php if ( trim( $ihosting['opt_rss_link'] ) != '' ): ?>
  <li>
    <a href="<?php echo esc_url( $ihosting['opt_rss_link'] ); ?>">
        <i class="fa fa-rss"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'RSS feed', 'ihosting' ); ?></span>
    </a>
  </li>
<?php endif; ?>