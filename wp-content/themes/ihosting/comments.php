<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iHosting
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$fields = array(
	'author' => '<div class="row"><div class="col-xs-12 col-sm-6"><input type="text" name="author" id="name" class="input-form" placeholder="' . esc_html__( 'Name *', 'ihosting' ) . '" /></div>',
	'email'  => '<div class="col-xs-12 col-sm-6"><input type="text" name="email" id="email" class="input-form" placeholder="' . esc_html__( 'Email *', 'ihosting' ) . '"/></div></div><!-- /.row -->',
	//'website'  => '<div class="col-sm-4"><input type="text" name="website" id="website" placeholder="' . esc_html__( 'Website', 'ihosting' ) . '" /></div></div><!-- /.row -->',
	//'submit'  => '<input class="submit  logged-is-out" type="submit" value="Add Comment" name="submit"></div>',
);

$custom_comment_form = array(
	'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
	'comment_field'        => '
  	<div class="message-comment"><textarea name="comment" id="message" rows="5" class="textarea-form" placeholder="' . esc_html__( 'Your comment *', 'ihosting' ) . '" ></textarea></div>',
	'logged_in_as'         => '<p class="logged-in-as">' . sprintf( wp_kses( __( 'Logged in as <a href="%1$s" class="comment-author-url">%2$s</a> <a href="%3$s" class="comment-logout-url">' . esc_html__( 'Log out?', 'ihosting' ) . '</a>', 'ihosting' ), array( 'a' => array( 'href' => array(), 'class' => array() ) ) ), esc_url( admin_url( 'profile.php' ) ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
	'cancel_reply_link'    => esc_html__( 'Cancel', 'ihosting' ),
	'comment_notes_before' => '<h4 class="leave-comment-title">' . esc_html__( 'Leave Comment', 'ihosting' ) . '</h4>',
	'comment_notes_after'  => '',
	'title_reply'          => '',
	'label_submit'         => esc_html__( 'Add Comment', 'ihosting' ),
);

$cm_area_class = have_comments() ? 'have-comments' : 'no-comment';

?>

<div id="comments" class="comments-area <?php echo esc_attr( $cm_area_class ); ?>">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
			printf( // WPCS: XSS OK.
				esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'ihosting' ) ),
				number_format_i18n( get_comments_number() ),
				'<span>' . get_the_title() . '</span>'
			);
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'ihosting' ); ?></h2>
				<div class="nav-links">

					<div
						class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'ihosting' ) ); ?></div>
					<div
						class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'ihosting' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'type'        => 'comment',
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => '90',
					'reply_text'  => wp_kses( __( '<i class="fa fa-mail-reply"></i> reply', 'ihosting' ), array( 'i' => array( 'class' => array() ) ) ),
					'callback'    => 'ihosting_theme_comment'
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'ihosting' ); ?></h2>
				<div class="nav-links">

					<div
						class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'ihosting' ) ); ?></div>
					<div
						class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'ihosting' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( !comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'ihosting' ); ?></p>
	<?php endif; ?>

</div><!-- #comments -->

<?php comment_form( $custom_comment_form ); ?>
