<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

global $ihosting;
$enable_share_post = isset( $ihosting['opt_enable_single_post_sharing'] ) ? $ihosting['opt_enable_single_post_sharing'] == 1 : true;
$socials_shared = isset( $ihosting['opt_single_share_socials'] ) ? $ihosting['opt_single_share_socials'] : array();

$img_url = '';
if ( has_post_thumbnail() ) {
    $img = ihosting_resize_image( get_post_thumbnail_id( get_the_ID() ), null, 1333, 687, true, false, false );
    $img_url = esc_url( $img['url'] );
}

?>

<?php if ( $enable_share_post ): ?>

    <?php if ( !empty( $socials_shared ) ): ?>
    
        <div class="group-share">
            <label><?php esc_html_e( 'Share:', 'ihosting' ); ?></label>
            <ul class="social-share">
                <?php if ( in_array( 'facebook', $socials_shared ) ): ?>
                    <li>
                        <a class="style1" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank">
                            <i class="fa fa-facebook"></i>
                            <span class="screen-reader-text"><?php echo sprintf( esc_html__( 'Share "%s" on Facebook', 'ihosting' ), get_the_title() ); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ( in_array( 'twitter', $socials_shared ) ): ?>
                    <li>
                        <a class="style2" href="https://twitter.com/home?status=<?php the_permalink(); ?>" target="_blank">
                            <i class="fa fa-twitter"></i>
                            <span class="screen-reader-text"><?php echo sprintf( esc_html__( 'Post status "%s" on Twitter', 'ihosting' ), get_the_title() ); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ( in_array( 'gplus', $socials_shared ) ): ?>
                    <li>
                        <a class="style3" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank">
                            <i class="fa fa-google-plus"></i>
                            <span class="screen-reader-text"><?php echo sprintf( esc_html__( 'Share "%s" on Google Plus', 'ihosting' ), get_the_title() ); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ( in_array( 'pinterest', $socials_shared ) ): ?>
                    <li>
                        <a class="style4" href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url( $img_url ); ?>&amp;description=<?php echo urlencode( get_the_excerpt() ); ?>" target="_blank">
                            <i class="fa fa-pinterest"></i>
                            <span class="screen-reader-text"><?php echo sprintf( esc_html__( 'Pin "%s" on Pinterest', 'ihosting' ), get_the_title() ); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ( in_array( 'linkedin', $socials_shared ) ): ?>
                    <li>
                        <a class="style6" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>&amp;summary=<?php echo urlencode( get_the_excerpt() ); ?>&amp;source=<?php echo urlencode( get_bloginfo( 'name' ) ); ?>" target="_blank">
                            <i class="fa fa-linkedin"></i>
                            <span class="screen-reader-text"><?php echo sprintf( esc_html__( 'Share "%s" on LinkedIn', 'ihosting' ), get_the_title() ); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div><!-- /.group-share -->
    
    <?php endif; // End if ( !empty( $socials_shared ) ) ?>

<?php endif; ?>
