<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Post Styling Options
if ( alchemists_sp_preset( 'soccer' ) ) {
  $product_color_1_default = '#ffffff';
  $product_color_2_default = '#ffffff';
} else {
  $product_color_1_default = '#fe2b00';
  $product_color_2_default = '#f7d500';
}

$product_color_1   = get_field('product_grad_color_1') ? get_field('product_grad_color_1') : $product_color_1_default;
$product_color_2   = get_field('product_grad_color_2') ? get_field('product_grad_color_2') : $product_color_2_default;

$attributes   = array();
$attributes[] = 'style="background-image: linear-gradient(to left top, ' . $product_color_1 . ', ' . $product_color_2 . ');"';

// Category Abbr
$product_cat_abbr = '';
$terms = wp_get_post_terms( $post->ID, 'product_cat' );
if ( !empty( $terms )) {
	$cat_id = $terms[0]->term_id;
	$product_cat_abbr = get_term_meta( $cat_id, 'alc_meta_abbr', true );
}

// Post Classes
$post_classes   = array();
$post_classes[] = 'product__item card';
?>
<li <?php post_class( $post_classes ); ?> <?php echo implode( ' ', $attributes ); ?>>
	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 */
	do_action( 'woocommerce_before_shop_loop_item' ); ?>

  <div class="product__img" <?php echo implode( ' ', $attributes ); ?>>

    <?php if ( !alchemists_sp_preset('soccer') ) : ?>
      <?php if ( $product_cat_abbr ) : ?>
      <div class="product__bg-letters"><?php echo esc_html( $product_cat_abbr ); ?></div>
      <?php endif; ?>
    <?php endif; ?>

		<div class="product__img-holder">

			<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		</div>
	</div>

	<div class="product__content card__content">

		<header class="product__header">
			<div class="product__header-inner">
				<?php
				/**
				 * woocommerce_shop_loop_item_title hook.
				 *
				 * @hooked woocommerce_template_loop_product_title - 10
				 * @hooked woocommerce_template_loop_rating - 11
				 */
				do_action( 'woocommerce_shop_loop_item_title' ); ?>
			</div>

			<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
		</header>

		<?php
		/**
		 * woocommerce_after_shop_loop_item hook.
		 *
		 * @hooked alchemists_template_loop_add_to_cart_before - 9
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 * @hooked alchemists_template_loop_add_to_cart_after - 20
		 */
		do_action( 'woocommerce_after_shop_loop_item' );
		?>
	</div>
</li>
