<?php

/**
 * Widget Name: Luckyshop Core LatestPosts
 * Widget Description: Display the Form Login
 * Widget Text Domain: ihosting-core
 *
 */
class ihostingWidgetRecentPosts extends WP_Widget
{
	function __construct() {
		$widget_ops = array( 'classname' => '', 'description' => 'The recent posts with thumbnails' );
		$control_ops = array( 'width' => 400, 'height' => 0 );
		parent::__construct(
			'ihostingWidgetRecentPosts',
			esc_html__( 'Lucky Shop - Recent Posts', 'ihosting-core' ),
			$widget_ops, $control_ops
		);
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		echo $before_widget;
		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$items = empty( $instance['items'] ) ? '3' : apply_filters( 'widget_number', $instance['items'] );
		$order = empty( $instance['order'] ) ? 'ASC' : strtoupper( $instance['order'] ); // ASC, DESC

		if ( !is_numeric( $items ) ) {
			$items = intval( $items );
		}

		if ( $title != '' ) {
			echo $before_title . $title . $after_title;
		}

		$args = array(
			'numberposts'         => $items,
			'post_status'         => 'publish',
			'orderby'             => 'ID',
			'order'               => $order,
			'ignore_sticky_posts' => 1
		);
		$recent_posts = wp_get_recent_posts( $args );

		if ( count( $recent_posts ) > 0 ) {
			$html = '';

			$html .= '<ul class="recent_posts_list">';
			foreach ( $recent_posts as $recent ) {

				$thumb = ihosting_core_resize_image( get_post_thumbnail_id( get_post( $recent["ID"] ) ), null, 90, 90, true, true, false );

				$html .= '<li>';
				if ( trim( $thumb['url'] ) != '' ) {
					$html .= '<div class="thumb"><img width="' . esc_attr( $thumb['width'] ) . '" height="' . esc_attr( $thumb['height'] ) . '" src="' . esc_url( $thumb['url'] ) . '" alt="' . get_the_title() . '"></div>';
				}
				$html .= '<div class="info">';
				$html .= '<h6 class="post-title"><a href="' . esc_url( get_permalink( $recent["ID"] ) ) . '">' . sanitize_text_field( $recent["post_title"] ) . '</a></h6>';
				$html .= '<div class="meta">
								<span class="author vcard">' . esc_html__( 'By: ', 'ihosting-core' ) . '<a class="url fn n" href="' . esc_url( get_author_posts_url( $recent['post_author'] ) ) . '">' . sanitize_text_field( get_the_author_meta( 'display_name', $recent['post_author'] ) ) . '</a></span>
								<span class="date"><a href="' . esc_url( get_permalink( $recent["ID"] ) ) . '">' . get_the_date( '', $recent["ID"] ) . '</a></span>
							</div>';
				$html .= '</div><!-- /.info -->';
				$html .= '</li>';
			}

			$html .= '</ul>';

			echo $html;
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['items'] = (int)( $new_instance['items'] );
		$instance['order'] = strtoupper( $new_instance['order'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array)$instance, array( 'title' => 'Recent Posts', 'items' => '3', 'order' => 'ASC' ) );
		$title = strip_tags( $instance['title'] );
		$items = (int)( $instance['items'] );
		$order = strtoupper( $instance['order'] );

		?>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title', 'ihosting-core' ); ?>
				:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'items' ); ?>"><?php esc_html_e( 'Items (default 3)', 'ihosting-core' ); ?>
				:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'items' ); ?>"
			       name="<?php echo $this->get_field_name( 'items' ); ?>" type="text"
			       value="<?php echo esc_attr( $items ); ?>"/>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'order' ); ?>"><?php esc_html_e( 'Order', 'ihosting-core' ); ?>
				:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>"
			        name="<?php echo $this->get_field_name( 'order' ); ?>">
				<option <?php selected( $order == 'ASC' ); ?>
					value="ASC"><?php esc_html_e( 'ASC', 'ihosting-core' ); ?></option>
				<option <?php selected( $order == 'DESC' ); ?>
					value="DESC"><?php esc_html_e( 'DESC', 'ihosting-core' ); ?></option>
			</select>
		</p>
		<?php
	}
}
