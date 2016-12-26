<?php
/**
 * Template part for displaying top banner.
 * 
 * @package iHosting
 */
 
global $ihosting;

// Get header layout style
$layout = isset( $ihosting['opt_header_layout'] ) ? $ihosting['opt_header_layout'] : 'style-1'; // style-1: Two parts header
$header_img = isset( $ihosting['opt_header_img'] ) ? $ihosting['opt_header_img'] : array( 'url' => get_template_directory_uri() . '/assets/images/pattern1.png' );
$header_img_repeat =  isset( $ihosting['opt_header_img_repeat'] ) ? $ihosting['opt_header_img_repeat'] : 'repeat';
$header_title_text_align =  isset( $ihosting['opt_header_title_text_align'] ) ? $ihosting['opt_header_title_text_align'] : 'left';

$top_banner_class = 'page-banner';
$top_banner_style = '';
if ( trim( $header_img['url'] ) != '' ) {
    $top_banner_class .= ' has-bg-img';
    $top_banner_style = 'style="background: url(' . esc_url( $header_img['url'] ) . ') ' . esc_attr( $header_img_repeat ) . ' center center;"';
}
else{
    $top_banner_class .= ' no-bg-img';
}

$title = '';

if ( is_front_page() && is_home() ) {
    // Default homepage
    
} elseif ( is_front_page() ) {
    // static homepage
    
} elseif ( is_home() ) {
    // blog page
    $post_id = get_option( 'page_for_posts' );
    $title = ihosting_single_title( $post_id );
    $top_banner_style = ihosting_single_header_bg_style( $post_id );
    $header_title_text_align = ihosting_single_title_align( $post_id );
    
    if ( trim( $top_banner_style ) != '' ) {
        $top_banner_class = 'page-banner has-bg-img';
    }
    else{
        $top_banner_class = 'page-banner no-bg-img';
    }
    
} else {
    //everything else
    
    // Is a singular
    if ( is_singular() ) {
        $show_single_title_section = ihosting_is_single_show_header_title_section();
        if ( !$show_single_title_section ) {
            return '';   
        }
        
        $title = ihosting_single_title();
        $top_banner_style = ihosting_single_header_bg_style();
        $header_title_text_align = ihosting_single_title_align();
    }
    else{ 
        // Is archive or taxonomy
        if ( is_archive() ) {
            //$title = post_type_archive_title( '', false );
            $title = get_the_archive_title();
            
            // Checking for shop archive
            if ( function_exists( 'is_shop' ) ) { // Products archive, products category, products search page...
                if ( is_shop() ) {
                    if ( apply_filters( 'woocommerce_show_page_title', true ) ) {
                        $post_id = get_option( 'woocommerce_shop_page_id' );
                        $use_custom_title = get_post_meta( $post_id, '_ihosting_use_custom_title', true ) == 'yes';
                        
                        if ( $use_custom_title ) {
                            $title = ihosting_single_title( $post_id );
                        }
                        else{
                            $title = woocommerce_page_title( false );    
                        }
                        
                        $top_banner_style = ihosting_single_header_bg_style( $post_id );
                        $header_title_text_align = ihosting_single_title_align( $post_id );
                         
                    }
                }   
            } 
            
        }
        else{
            if ( is_404() ) {
                $title = isset( $ihosting['opt_404_header_title'] ) ? $ihosting['opt_404_header_title'] : esc_html__( 'Oops, page not found !', 'ihosting' );
            }
            else{ 
                if ( is_search() ) {
                    $title = sprintf( esc_html__( 'Search results for: %s', 'ihosting' ), get_search_query() );
                }
                else{
                    // is category, is tag, is tax
                    $title = single_cat_title( '', false );   
                } 
            }
        }
        
        // Is WooCommerce page
        if ( function_exists( 'is_woocommerce' ) ) {
            if ( is_woocommerce() && !is_shop() ) {
                if ( apply_filters( 'woocommerce_show_page_title', true ) ) {
                    $title = woocommerce_page_title( false );   
                } 
            }
        }
        
    }
}

if ( trim( $top_banner_style ) != '' ) {
    $top_banner_class = 'page-banner has-bg-img';
}
else{
    $top_banner_class = 'page-banner no-bg-img';
}

$top_banner_class .= ' text-' . esc_attr( $header_title_text_align );

?>

<?php if ( trim( $title ) != '' ): ?>

    <section class="<?php echo esc_attr( $top_banner_class ); ?>" <?php echo normalize_whitespace( $top_banner_style ); ?>>
    	<h2 class="page-title"><?php echo sanitize_text_field( $title ); ?></h2>
        <?php if ( function_exists( 'is_woocommerce' ) ): ?>
            <?php if ( is_woocommerce() ): ?>
                <?php ihosting_wc_pro_cats_list(); ?>
            <?php endif; // End if ( is_woocommerce() ) ?>
        <?php endif; // End if ( function_exists( 'is_woocommerce' ) ) ?>
    </section>
    
<?php endif; ?>




