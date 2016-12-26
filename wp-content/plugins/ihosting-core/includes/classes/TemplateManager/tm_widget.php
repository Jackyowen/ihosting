<?php

/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 13/04/2016
 * Time: 10:39 SA
 */

/**
 * Adds Template_Manager_Widget widget.
 */
class Template_Manager_Widget extends WP_Widget {
    private $post_type = "template_manager", $meta_data_name = "template_manager";
    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'kt_template', // Base ID
            __( 'Template Manager', 'kute-toolkit' ), // Name
            array( 'description' => __( 'You can create flexible any template of visual composer, export and import theme in anywhere by Template Manager and then choose in this place', 'kute-toolkit' ), ) // Args
        );
        $this->post_type = get_option('template_manager', "template_manager");
        $this->meta_data_name = get_option('template_manager_meta_name', "template_manager");
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        $output = "";
        $id = ! empty( $instance['template'] ) ? $instance['template'] : '';
        $el_class = ! empty( $instance['el_class'] ) ? $instance['el_class'] : '';

        if ( empty( $id ) ) {
            return $output;
        }
        $my_query = new WP_Query( array( 'post_type' => $this->post_type, 'p' => (int)$id ) );
        while ( $my_query->have_posts() ) {
            $my_query->the_post();
            if( get_the_ID() === (int)$id ) {
                $output .= '<div class="kt_template_shortcode' . ( $el_class ? ' ' . $el_class : '' ) . '">';
                ob_start();
                the_content();
                $output .= ob_end_flush();
                $output .= '</div>';
            }
        }
        return $output;

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $template = ! empty( $instance['template'] ) ? $instance['template'] : '';
        $el_class = ! empty( $instance['el_class'] ) ? $instance['el_class'] : '';

        if( ! $this->post_type ){
            return;
        }
        $list_templates = $this->get_template_list();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Template:' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'template' ); ?>" name="<?php echo $this->get_field_name( 'template' ); ?>">
                <option class="" value=""><?php _e( 'Choose template', 'kute-toolkit' ) ?></option>
                <?php foreach ( $list_templates as $k => $t ): ?>
                    <option <?php selected( $t, $template ) ?> value="<?php echo esc_attr( $t )?>"><?php echo esc_attr( $k )?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'el_class' ); ?>"><?php _e( 'Extra Class Name:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'el_class' ); ?>" name="<?php echo $this->get_field_name( 'el_class' ); ?>" type="text" value="<?php echo esc_attr( $el_class ); ?>">
        </p>
        <?php
    }
    public function get_template_list(){
        global $current_user;
        wp_get_current_user();
        $current_user_role = isset( $current_user->roles[0] ) ? $current_user->roles[0] : false;
        $list = array();
        $templates = get_posts( array(
            'post_type' => $this->post_type,
            'numberposts' => - 1
        ) );
        $post = get_post( isset( $_POST['post_id'] ) ? $_POST['post_id'] : null );

        foreach ( $templates as $template ) {
            $id = $template->ID;
            $meta_data = get_post_meta( $id, $this->meta_data_name, true );
            $post_types = isset( $meta_data['post_type'] ) ? $meta_data['post_type'] : false;
            $user_roles = isset( $meta_data['user_role'] ) ? $meta_data['user_role'] : false;
            if (
                ( ! $post || ! $post_types || in_array( $post->post_type, $post_types ) )
                && ( ! $current_user_role || ! $user_roles || in_array( $current_user_role, $user_roles ) )
            ) {
                $list[ $template->post_title ] = $id;
            }
        }
        return $list;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
        $instance['el_class'] = ( ! empty( $new_instance['el_class'] ) ) ? strip_tags( $new_instance['el_class'] ) : '';
        return $instance;
    }

} // class Template_Manager_Widget