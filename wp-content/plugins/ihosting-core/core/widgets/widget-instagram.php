<?php

/**
 * @author    Le Manh Linh
 * @copyright 2015
 */
class ihostingInstagramWidget extends WP_Widget
{

	function __construct() {
		$widget_ops = array( 'classname' => 'ihosting-instagram-feed', 'description' => __( 'Displays your latest Instagram photos', 'ihosting' ) );
		parent::__construct( 'ihostingInstagramWidget', __( 'Lucky Shop - Instagram', 'ihosting' ), $widget_ops );
	}

	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$username = empty( $instance['username'] ) ? '' : $instance['username']; // parlovetati
		$number_of_images = empty( $instance['number_of_images'] ) ? 8 : max( 1, intval( $instance['number_of_images'] ) );
		$target = empty( $instance['target'] ) ? '_self' : $instance['target'];

		echo $before_widget;
		if ( trim( $title ) != '' ) {
			echo $before_title . $title . $after_title;
		};

		if ( trim( $username ) != '' ) {
			echo '<div class="instagram-user-link hidden">
                    <a href="/instagram.com/' . esc_attr( $username ) . '" rel="me" target="' . esc_attr( $target ) . '"><span class="title-name">&#64;' . esc_attr( $username ) . '</span></a>
                </div><!-- /.instagram-user-link -->';
		}

		do_action( 'wpiw_before_widget', $instance );

		$size_add = 's150x150'; // s320x320

		if ( $username != '' ) {

			$media_array = $this->ts_mr_instagram( $username, $number_of_images );

			if ( is_wp_error( $media_array ) ) {

				echo $media_array->get_error_message();

			}
			else {

				// filter for images only?
				if ( $images_only = apply_filters( 'wpiw_images_only', false ) ) {
					$media_array = array_filter( $media_array, array( $this, 'images_only' ) );
				}

				?>

				<div class="photo-instagram">
					<ul class="list-photo instargram clearfix">
						<?php
						$i = 0;
						foreach ( $media_array as $item ) {

							$i++;
							$img_url = $item['thumbnail'];
							$img_name = basename( $img_url );

							$size_add = 's150x150';

							$instagram_class = 'instagram-img-wrap instagram-img-wrap-' . $i;
							if ( $i == 1 ) {
								$instagram_class .= ' first-child';
							}
							if ( $i == $number_of_images ) {
								$instagram_class .= ' lass-child';
							}

							$crop_str = '/sh0.08/c0.100.800.800/c0.135.1080.1080/c0.0.1079.1079/c107.0.865.865/c123.0.557.557/c234.0.611.611/';

							if ( $item['type'] == 'video' ) {
								$crop_str = '/';
							}

							$img_url = str_replace( $img_name, $size_add . $crop_str . $img_name, $img_url );

							echo '<li class="' . esc_attr( $instagram_class ) . '"><a href="' . esc_url( $item['link'] ) . '" class="hover-overlay-dark-to-light-rtl" target="' . esc_attr( $target ) . '"><img src="' . esc_url( $img_url ) . '"  alt="' . esc_attr( $item['description'] ) . '" title="' . esc_attr( $item['description'] ) . '"/></a></li>';

						}
						?>
					</ul>
				</div><!-- /.photo-instagram -->
				<?php
			}
		}

		do_action( 'wpiw_after_widget', $instance );

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args(
			(array)$instance,
			array(
				'title'            => __( 'Instagram', 'ihosting' ),
				'username'         => '',
				'number_of_images' => 8,
				'target'           => '_self'
			)
		);
		$title = esc_attr( $instance['title'] );
		$username = esc_attr( $instance['username'] );
		$number_of_images = intval( $instance['number_of_images'] );
		$target = esc_attr( $instance['target'] );
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'ihosting' ); ?>:
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				       value="<?php echo esc_attr( $title ); ?>"/></label></p>
		<p><label
				for="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>"><?php _e( 'Username', 'ihosting' ); ?>
				: <input class="widefat" id="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>"
				         name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text"
				         value="<?php echo esc_attr( $username ); ?>"/></label></p>
		<p><label
				for="<?php echo esc_attr( $this->get_field_name( 'number_of_images' ) ); ?>"><?php _e( 'Number of images', 'ihosting' ); ?>
				: <input class="widefat" id="<?php echo esc_attr( $this->get_field_name( 'number_of_images' ) ); ?>"
				         name="<?php echo esc_attr( $this->get_field_name( 'number_of_images' ) ); ?>" type="text"
				         value="<?php echo intval( $number_of_images ); ?>"/></label></p>
		<p><label
				for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php _e( 'Open links in', 'ihosting' ); ?>
				:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">
				<option
					value="_self" <?php selected( '_self', $target ) ?>><?php _e( 'Current window (_self)', 'ihosting' ); ?></option>
				<option
					value="_blank" <?php selected( '_blank', $target ) ?>><?php _e( 'New window (_blank)', 'ihosting' ); ?></option>
			</select>
		</p>
		<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = trim( strip_tags( $new_instance['username'] ) );
		$instance['number_of_images'] = max( 1, intval( $new_instance['number_of_images'] ) );
		$instance['target'] = ( ( $new_instance['target'] == '_self' || $new_instance['target'] == '_blank' ) ? $new_instance['target'] : '_self' );

		return $instance;
	}

	// based on https://gist.github.com/cosmocatalano/4544576
	function ts_mr_instagram( $username, $slice = 8 ) {
		$username = strtolower( $username );

		if ( false === ( $instagram = get_transient( 'instagram-media-new-' . sanitize_title_with_dashes( $username ) ) ) ) {

			$remote = wp_remote_get( 'http://instagram.com/' . trim( $username ) );

			if ( is_wp_error( $remote ) )
				return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'ihosting' ) );

			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
				return new WP_Error( 'invalid_response', __( 'Instagram did not return a 200.', 'ihosting' ) );

			$shards = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], true );

			if ( !$insta_array )
				return new WP_Error( 'bad_json', __( 'Instagram has returned invalid data.', 'ihosting' ) );

			// old style
			if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
				$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
				$type = 'old';
				// new style
			}
			else if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
				$type = 'new';
			}
			else {
				return new WP_Error( 'bad_josn_2', __( 'Instagram has returned invalid data.', 'ihosting' ) );
			}

			if ( !is_array( $images ) )
				return new WP_Error( 'bad_array', __( 'Instagram has returned invalid data.', 'ihosting' ) );

			$instagram = array();

			switch ( $type ) {
				case 'old':
					foreach ( $images as $image ) {

						if ( $image['user']['username'] == $username ) {

							$image['link'] = preg_replace( "/^http:/i", "", $image['link'] );
							$image['images']['thumbnail'] = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
							$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
							$image['images']['low_resolution'] = preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );

							$instagram[] = array(
								'description' => $image['caption']['text'],
								'link'        => $image['link'],
								'time'        => $image['created_time'],
								'comments'    => $image['comments']['count'],
								'likes'       => $image['likes']['count'],
								'thumbnail'   => $image['images']['thumbnail'],
								'large'       => $image['images']['standard_resolution'],
								'small'       => $image['images']['low_resolution'],
								'type'        => $image['type']
							);
						}
					}
					break;
				default:
					foreach ( $images as $image ) {

						$image['display_src'] = preg_replace( "/^http:/i", "", $image['display_src'] );

						if ( $image['is_video'] == true ) {
							$type = 'video';
						}
						else {
							$type = 'image';
						}

						$instagram[] = array(
							'description' => __( 'Instagram Image', 'ihosting' ),
							'link'        => '//instagram.com/p/' . $image['code'],
							'time'        => $image['date'],
							'comments'    => $image['comments']['count'],
							'likes'       => $image['likes']['count'],
							'thumbnail'   => $image['display_src'],
							'type'        => $type
						);
					}
					break;
			}

			// do not set an empty transient - should help catch private or empty accounts
			if ( !empty( $instagram ) ) {
				$instagram = base64_encode( serialize( $instagram ) );
				set_transient( 'instagram-media-new-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'ihosting_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
			}
		}

		if ( !empty( $instagram ) ) {
			$instagram = unserialize( base64_decode( $instagram ) );

			return array_slice( $instagram, 0, $slice );

		}
		else {

			return new WP_Error( 'no_images', __( 'Instagram did not return any images.', 'ihosting' ) );

		}
	}

	function images_only( $media_item ) {

		if ( $media_item['type'] == 'image' )
			return true;

		return false;
	}

}

?>