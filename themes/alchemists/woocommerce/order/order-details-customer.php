<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="woocommerce-customer-details">

	<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

		<section class="row">

			<div class="col-md-6">

				<?php endif; ?>

        <div class="card">
          <header class="card__header">
            <h4><?php esc_html_e( 'Billing address', 'alchemists' ); ?></h4>
          </header>
          <div class="card__content">
            <address>
              <?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : esc_html__( 'N/A', 'alchemists' ); ?>
              <?php if ( $order->get_billing_phone() ) : ?>
                <p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
              <?php endif; ?>
              <?php if ( $order->get_billing_email() ) : ?>
                <p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
              <?php endif; ?>
            </address>
          </div>
        </div>

				<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

			</div><!-- /.col-1 -->

			<div class="col-md-6">

        <div class="card">
          <header class="card__header">
            <h4><?php esc_html_e( 'Shipping address', 'alchemists' ); ?></h4>
          </header>
          <div class="card__content">
            <address>
              <?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : esc_html__( 'N/A', 'alchemists' ); ?>
            </address>
          </div>
        </div>

			</div><!-- /.col-2 -->

		</section><!-- /.col2-set -->

	<?php endif; ?>

</section>
