<?php
class Awhmcs_Widget extends WP_Widget { 
     
    function __construct() {
        $widget_ops = array( 
            'classname'     =>  '', 
            'description'   =>  __( 'Add Awhmcs Widget', 'awhmcs' ) 
        );
        
        $control_ops = array( 'width' => 400, 'height' => 0); 
        parent::__construct( 
            'Awhmcs_Widget', 
            __('Awhmcs Widget', 'awhmcs'), 
            $widget_ops, $control_ops
        );
        
    }
    
    public function widget( $args, $instance ) {
        global $post; 
        
        $title = apply_filters( 'widget_title', $instance['title'] ); 
        $description = isset( $instance['description'] ) ? strip_tags( $instance['description'] ) : '';

        
        // before and after widget arguments are defined by themes 
        echo  $args['before_widget'];   
        
        ?>
        <div class="widget widget_meta awhmcs-widget">
        <?php if ( trim( $title ) != '' ): ?>
            <h3 class="sidebar_title"><span><?php echo esc_attr( $title ); ?></span></h3>
        <?php endif; ?>
        <?php if ( trim( $description ) != '' ): ?>
            <p class="ts-description-shortcode-content">
                <?php echo do_shortcode( $description ); ?>
            </p>
        <?php endif; ?>


        <div class="sdomainchecker">
            <domain-shortcode template-url="pages/blocks/sdomainchecker.html"></domain-shortcode>
        </div>
        </div>
        <?php
        
        echo  $args['after_widget']; 
    }
    
    public function form( $instance ) {
        if ( isset( $instance['title'] )) { 
            $title = $instance['title'];  
        }
        
        $description = isset( $instance['description'] ) ? strip_tags( $instance['description'] ) : '';
        $img = isset( $instance['img'] ) ? strip_tags( $instance['img'] ) : '';
        
        // Widget admin form
        ?> 
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'awhmcs' ); ?>: </label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"  />
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php _e( 'Description', 'awhmcs' ); ?>: </label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>"  />
        </p>
        
        <?php 
    }
    
    
    
    public function update( $new_instance, $old_instance ) {
        $instance = array(); 
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
        return $instance;
    }
    
} 
// End class ts_widget_lastest_news 
function Awhmcs_init_Widget() {
    register_widget( 'Awhmcs_Widget' );
}
add_action( 'widgets_init', 'Awhmcs_init_Widget' );