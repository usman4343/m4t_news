<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form class="woocomerce-form woocommerce-form-login login" method="post" <?php if ( $hidden ) echo 'style="display:none;"'; ?>>

	<div class="card card--lg">
		<div class="card__content">
			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<?php if ( $message ) echo wpautop( wptexturize( $message ) ); ?>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="username"><?php esc_html_e( 'Username or email', 'alchemists' ); ?> <span class="required">*</span></label>
						<input type="text" class="input-text" name="username" id="username" />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="password"><?php esc_html_e( 'Password', 'alchemists' ); ?> <span class="required">*</span></label>
						<input class="input-text" type="password" name="password" id="password" />
					</div>
				</div>
			</div>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<div class="form-group form-group--password-forgot">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox checkbox-inline">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'alchemists' ); ?></span>
					<span class="checkbox-indicator"></span>
				</label>
				<span class="password-reminder woocommerce-LostPassword lost_password">
					<?php esc_html_e( 'Lost your password?', 'alchemists' ); ?> <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Click Here', 'alchemists' ); ?></a>
				</span>
			</div>

			<div class="form-group form-group--sm">
				<?php wp_nonce_field( 'woocommerce-login' ); ?>
				<input type="submit" class="btn btn-primary-inverse btn-lg btn-block" name="login" value="<?php esc_attr_e( 'Login', 'alchemists' ); ?>" />
				<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
			</div>

			<?php do_action( 'woocommerce_login_form_end' ); ?>
		</div>
	</div>

</form>
