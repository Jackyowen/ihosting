<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
    exit;
} 

/**
 * Widget Name: iHosting Socials
 * Widget Description: Display the lastest posts of selected category
 * Widget Function Name: _social
 * Widget Text Domain: ihosting-core
 * 
 */
 
class ihostingSidgetSocial extends WP_Widget { 
     
    function __construct() {
        $widget_ops = array( 
            'classname'     =>  '', 
            'description'   =>  esc_html__( 'Display social links in theme options as icons', 'ihosting-core' )
        );
        
        $control_ops = array( 'width' => 400, 'height' => 0); 
        parent::__construct( 
            'ihostingSidgetSocial', 
            esc_html__('Lucky Shop - Socials', 'ihosting-core'),
            $widget_ops, $control_ops
        );
        
    }
    
    
    public function widget( $args, $instance ) {
        global $post, $themename;; 
        
        $title = apply_filters( 'widget_title', $instance['title'] ); 
        
        
        // before and after widget arguments are defined by themes 
        echo $args['before_widget'];   
        
        if ( trim( $title ) != '' ) {
            if ( isset( $args['before_title']) ){
                echo $args['before_title'];
                echo $title;
                echo $args['after_title'];
            } else{
                echo '<h5 class="widget-title">' . sanitize_text_field( $title ) . '</h5>';
            }   
        }
        
        if ( trim( $themename['opt_twitter_link'] . $themename['opt_fb_link'] . $themename['opt_google_plus_link'] . $themename['opt_dribbble_link'] . 
            $themename['opt_behance_link'] . $themename['opt_tumblr_link'] . $themename['opt_instagram_link'] . $themename['opt_pinterest_link'] . 
            $themename['opt_youtube_link'] . $themename['opt_vimeo_link'] . $themename['opt_linkedin_link'] .  $themename['opt_rss_link'] ) != '' ) {
                echo '<ul class="socials-list">';
                get_template_part( 'template-parts/social', 'items' );
                echo '</ul><!-- /.socials-list -->';
        }
        
        echo $args['after_widget']; 
    }
    
    
    
    public function form( $instance ) {
        if ( isset( $instance['title'] )) { 
            $title = $instance['title'];  
        }
        else { 
            $title = __('Socials', 'ihosting-core'); 
        }
        
        // Widget admin form
        ?> 
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'ihosting-core' ); ?>: </label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"  />
        </p>
        
        <?php 
    }
    
    
    
    public function update( $new_instance, $old_instance ) {
        $instance = array(); 
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
    
}
