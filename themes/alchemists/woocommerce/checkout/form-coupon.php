<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
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
 * @version 2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! wc_coupons_enabled() ) {
	return;
}

if ( empty( WC()->cart->applied_coupons ) ) {
	$info_message = apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'alchemists' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'alchemists' ) . '</a>' );
	wc_print_notice( $info_message, 'notice' );
}
?>

<form class="checkout_coupon form-inline" method="post" style="display:none">

	<div class="card">
		<div class="card__content">
			<div class="form-group">
				<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'alchemists' ); ?>" id="coupon_code" value="" />
			</div>

			<div class="form-group">
				<input type="submit" class="button btn-lg" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'alchemists' ); ?>" />
			</div>
		</div>
	</div>

</form>
