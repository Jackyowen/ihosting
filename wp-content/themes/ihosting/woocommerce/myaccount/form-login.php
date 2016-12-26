<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see           http://docs.woothemes.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.6.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="col2-set" id="customer_login">

	<div class="col-1 kt-wc-login-form-wrap">

		<?php endif; ?>

		<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) != 'yes' ) { ?>
		<div class="kt-wc-login-form-wrap">
			<?php } ?>
			<h2><?php _e( 'Login', 'ihosting' ); ?></h2>

			<form method="post" class="login">

				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<p class="form-row form-row-wide">
					<label for="username"><?php _e( 'Username or email address', 'ihosting' ); ?> <span
							class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="username"
					       value="<?php if ( !empty( $_POST['username'] ) )
						       echo esc_attr( $_POST['username'] ); ?>"
					       placeholder="<?php _e( 'Username or email address', 'ihosting' ); ?>"/>
				</p>
				<p class="form-row form-row-wide">
					<label for="password"><?php _e( 'Password', 'ihosting' ); ?> <span
							class="required">*</span></label>
					<input class="input-text" type="password" name="password" id="password"
					       placeholder="<?php _e( 'Password', 'ihosting' ); ?>"/>
				</p>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<p class="form-row">
					<?php wp_nonce_field( 'woocommerce-login' ); ?>
					<input type="submit" class="button primary" name="login"
					       value="<?php esc_attr_e( 'Login', 'ihosting' ); ?>"/>
					<label for="rememberme" class="inline">
						<input name="rememberme" type="checkbox" id="rememberme"
						       value="forever"/> <?php _e( 'Remember me', 'ihosting' ); ?>
					</label>
				</p>

				<?php do_action( 'woocommerce_login_form_end' ); ?>

			</form>
			<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) != 'yes' ) { ?>
		</div>
	<?php } ?>

		<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="col-2 kt-wc-register-form-wrap">

		<h2><?php _e( 'Register', 'ihosting' ); ?></h2>

		<form method="post" class="register">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_username"><?php _e( 'Username', 'ihosting' ); ?> <span
							class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="reg_username"
					       value="<?php if ( !empty( $_POST['username'] ) )
						       echo esc_attr( $_POST['username'] ); ?>"
					       placeholder="<?php _e( 'Username', 'ihosting' ); ?>"/>
				</p>

			<?php endif; ?>

			<p class="form-row form-row-wide">
				<label for="reg_email"><?php _e( 'Email address', 'ihosting' ); ?> <span
						class="required">*</span></label>
				<input type="email" class="input-text" name="email" id="reg_email"
				       value="<?php if ( !empty( $_POST['email'] ) )
					       echo esc_attr( $_POST['email'] ); ?>"
				       placeholder="<?php _e( 'Email address', 'ihosting' ); ?>"/>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_password"><?php _e( 'Password', 'ihosting' ); ?> <span
							class="required">*</span></label>
					<input type="password" class="input-text" name="password" id="reg_password"
					       placeholder="<?php _e( 'Password', 'ihosting' ); ?>"/>
				</p>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="<?php echo( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;">
				<label for="trap"><?php _e( 'Anti-spam', 'ihosting' ); ?></label>
				<input type="text" name="email_2"
				       id="trap" tabindex="-1"
				       placeholder="<?php _e( 'Anti-spam', 'ihosting' ); ?>"/>
			</div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register' ); ?>
				<input type="submit" class="button primary" name="register"
				       value="<?php esc_attr_e( 'Register', 'ihosting' ); ?>"/>
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
<?php endif; ?>

<div class="lost-pw-wrap">
	<p class="lost_password">
		<?php echo sprintf( __( 'Forgot your password? %s', 'ihosting' ), ' <a href="' . esc_url( wp_lostpassword_url() ) . '">' . esc_html__( 'Click here', 'ihosting' ) . '</a>' ); ?>
	</p>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
