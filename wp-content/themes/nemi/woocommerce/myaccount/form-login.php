<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set" id="customer_login">
	
	<ul>
		<li class="active"><a data-toggle="tab" href="#tab-login"><?php _e( 'Login', 'nemi' ); ?></a></li>
		<li><a data-toggle="tab" href="#tab-regis"><?php _e( 'Register', 'nemi' ); ?></a></li>
	</ul>
	<div class="tab-content">
	<div id="tab-login" class="tab-pane fade in active">

<?php endif; ?>

	<form class="woocomerce-form woocommerce-form-login login" method="post">
		<p class="desc">
			<?php _e( 'If you have an account with us, log in using your email address.', 'nemi' ); ?>
		</p>
		<?php do_action( 'woocommerce_login_form_start' ); ?>
		
		<div class="d_grid d_grid_2">
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<input placeholder="<?php _e( 'Username or email address *', 'nemi' ); ?>" type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<input placeholder="<?php _e( 'Password *', 'nemi' ); ?>" class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
			</p>
		</div>

		<?php do_action( 'woocommerce_login_form' ); ?>

		<div class="d_grid d_grid_2">
			<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline text-left">
				<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"/>
				<span><?php _e( 'Remember me', 'nemi' ); ?></span>
			</label>
			<label class="woocommerce-form__label woocommerce-LostPassword lost_password text-left">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'nemi' ); ?></a>
			</label>
		</div>
		<input type="submit" class="woocommerce-Button btn btn-default" name="login" value="<?php esc_attr_e( 'Login', 'nemi' ); ?>" />

		<?php do_action( 'woocommerce_login_form_end' ); ?>

	</form>

	</div>
<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>


	<div id="tab-regis" class="tab-pane fade">

		<form method="post" class="register">
			<p class="desc">
				<?php _e( 'If you have an account with us, log in using your email address.', 'nemi' ); ?>
			</p>
			<?php do_action( 'woocommerce_register_form_start' ); ?>
			<div class="d_grid d_grid_2">
				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input placeholder="<?php _e( 'Username', 'nemi' ); ?>" type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
					</p>

				<?php endif; ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<input placeholder="<?php _e( 'Email address', 'nemi' ); ?>" type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
				</p>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input placeholder="<?php _e( 'Password', 'nemi' ); ?>" type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
					</p>

				<?php endif; ?>
			</div>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'nemi' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" autocomplete="off" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="woocomerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<input type="submit" class="woocommerce-Button btn btn-default" name="register" value="<?php esc_attr_e( 'Register', 'nemi' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>
	</div>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
