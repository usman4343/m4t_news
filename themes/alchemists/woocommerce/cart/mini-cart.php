<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

do_action( 'woocommerce_before_mini_cart' ); ?>

<ul class="cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">

	<?php if ( ! WC()->cart->is_empty() ) : ?>

		<?php do_action( 'woocommerce_before_mini_cart_contents' ); ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

					// Post Styling Options
					$product_color_1   = get_field( 'product_grad_color_1', $product_id ) ? get_field( 'product_grad_color_1', $product_id ) : '#fe2b00';
					$product_color_2   = get_field( 'product_grad_color_2', $product_id ) ? get_field( 'product_grad_color_2', $product_id ) : '#f7d500';

					$attributes   = array();
					$attributes[] = 'style="background-image: linear-gradient(to left top, ' . $product_color_1 . ', ' . $product_color_2 . ');"';
					?>
					<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'products-list__item', $cart_item, $cart_item_key ) ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
							esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
							esc_html__( 'Remove this item', 'alchemists' ),
              esc_attr( $product_id ),
              esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>

						<figure class="products-list__product-thumb" <?php echo implode( ' ', $attributes ); ?>>
							<?php if ( ! $_product->is_visible() ) : ?>
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '&nbsp;'; ?>
							<?php else : ?>
								<a href="<?php echo esc_url( $product_permalink ); ?>">
									<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '&nbsp;'; ?>
								</a>
							<?php endif; ?>
						</figure>

						<div class="products-list__inner">

							<?php echo wc_get_product_category_list( $_product->get_id(), ', ', '<span class="products-list__product-cat">', '</span>' ); ?>

							<h5 class="products-list__product-title">
								<?php if ( ! $_product->is_visible() ) : ?>
									<?php echo esc_html( $product_name ); ?>
								<?php else : ?>
									<a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo esc_html( $product_name ); ?></a>
								<?php endif; ?>
							</h5>
							<?php echo WC()->cart->get_item_data( $cart_item ); ?>

							<?php if ( ! empty( $show_rating ) ) : ?>
								<div class="products-list__product-ratings">
									<?php echo wc_get_rating_html( $_product->get_average_rating() ); ?>
								</div>
							<?php endif; ?>

							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<div class="products-list__product-amount">' . sprintf( '%s &times; %s', $product_price, $cart_item['quantity']) . '</div>', $cart_item, $cart_item_key ); ?>
						</div>
					</li>
					<?php
				}
			}
		?>

		<?php do_action( 'woocommerce_mini_cart_contents' ); ?>

	<?php else : ?>

		<li class="empty"><?php esc_html_e( 'No products in the cart.', 'alchemists' ); ?></li>

	<?php endif; ?>

</ul><!-- end product list -->

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<div class="total">
		<div class="total__label"><?php esc_html_e( 'Subtotal', 'alchemists' ); ?>:</div>
		<div class="total__amount"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
	</div>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<div class="buttons">
		<?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
	</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
