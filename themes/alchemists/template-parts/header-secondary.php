<?php
/**
 * Template part for Header Secondary section.
 *
 * @package Alchemists
 * @version 1.0.2
 */

$alchemists_data = get_option('alchemists_data');

$search_form          = isset( $alchemists_data['alchemists__header-search-form'] ) ? esc_html( $alchemists_data['alchemists__header-search-form'] ) : true;
$shopping_cart        = isset( $alchemists_data['alchemists__header-shopping-cart'] ) ? esc_html( $alchemists_data['alchemists__header-shopping-cart'] ) : true;
$icon_custom_primary  = isset( $alchemists_data['alchemists__header-secondary-info-1-icon-custom'] ) ? $alchemists_data['alchemists__header-secondary-info-1-icon-custom'] : '';
$icon_custom_secondary = isset( $alchemists_data['alchemists__header-secondary-info-2-icon-custom'] ) ? $alchemists_data['alchemists__header-secondary-info-2-icon-custom'] : '';
$icon_custom_cart = isset( $alchemists_data['alchemists__header-shopping-cart-icon-custom'] ) ? $alchemists_data['alchemists__header-shopping-cart-icon-custom'] : '';

$email_1 = isset( $alchemists_data['alchemists__header-secondary-info-1-email'] ) ? $alchemists_data['alchemists__header-secondary-info-1-email'] : '';
$email_2 = isset( $alchemists_data['alchemists__header-secondary-info-2-email'] ) ? $alchemists_data['alchemists__header-secondary-info-2-email'] : '';

$email_1_label = isset( $alchemists_data['alchemists__header-secondary-info-1-label'] ) ? $alchemists_data['alchemists__header-secondary-info-1-label'] : '';
$email_2_label = isset( $alchemists_data['alchemists__header-secondary-info-2-label'] ) ? $alchemists_data['alchemists__header-secondary-info-2-label'] : '';

// check if Primary Email Address is an email address or link
if ( filter_var( $email_1, FILTER_VALIDATE_EMAIL ) ) {
  $email_1_attr = 'mailto:' . $email_1;
} else {
  $email_1_attr = esc_url( $email_1 );
}

// check if Secondary Email Address is an email address or link
if ( filter_var( $email_2, FILTER_VALIDATE_EMAIL ) ) {
  $email_2_attr = 'mailto:' . $email_2;
} else {
  $email_2_attr = esc_url( $email_2 );
}
?>

<div class="header__secondary">
  <div class="container">

    <?php if ( $search_form ) : ?>
    <!-- Header Search Form -->
    <?php get_template_part('template-parts/header-searchform'); ?>
    <!-- Header Search Form / End -->
    <?php endif; ?>

    <ul class="info-block info-block--header">

      <?php // Primary Email
      if ( isset( $alchemists_data['alchemists__header-secondary-info-1'] ) && $alchemists_data['alchemists__header-secondary-info-1'] == 1 ) : ?>
      <li class="info-block__item info-block__item--contact-primary">

        <?php if ( !empty( $icon_custom_primary ) ) : ?>
          <span class="df-icon-custom"><?php echo $icon_custom_primary; ?></span>
        <?php else : ?>
          <?php if ( alchemists_sp_preset('soccer') ) : ?>
            <svg role="img" class="df-icon df-icon--whistle">
              <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/icons-soccer.svg#whistle"/>
            </svg>
          <?php else : ?>
            <svg role="img" class="df-icon df-icon--jersey">
              <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/icons-basket.svg#jersey"/>
            </svg>
          <?php endif; ?>
        <?php endif; ?>

        <h6 class="info-block__heading"><?php echo esc_html( $email_1_label ); ?></h6>
        <a class="info-block__link" href="<?php echo $email_1_attr; ?>"><?php echo esc_html( $email_1 ); ?></a>
      </li>
      <?php endif; ?>

      <?php // Secondary Email
      if ( isset( $alchemists_data['alchemists__header-secondary-info-2'] ) && $alchemists_data['alchemists__header-secondary-info-2'] == 1 ) : ?>
      <li class="info-block__item info-block__item--contact-secondary">

        <?php if ( !empty( $icon_custom_secondary ) ) : ?>
          <span class="df-icon-custom"><?php echo $icon_custom_secondary; ?></span>
        <?php else : ?>

          <?php if ( alchemists_sp_preset( 'soccer' ) ) : ?>
          <svg role="img" class="df-icon df-icon--soccer-ball">
            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/icons-soccer.svg#soccer-ball"/>
          </svg>
          <?php else : ?>
            <svg role="img" class="df-icon df-icon--basketball">
              <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/icons-basket.svg#basketball"/>
            </svg>
          <?php endif; ?>
        <?php endif; ?>

        <h6 class="info-block__heading"><?php echo esc_html( $email_2_label ); ?></h6>
        <a class="info-block__link" href="<?php echo $email_2_attr; ?>"><?php echo esc_html( $email_2 ); ?></a>
      </li>
      <?php endif; ?>

      <?php // Shopping Cart
      if ( alchemists_woo_exists() && $shopping_cart ) :

      $product_count = sprintf('%d', WC()->cart->cart_contents_count, WC()->cart->cart_contents_count ); ?>
      <li class="info-block__item info-block__item--shopping-cart">
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="info-block__link-wrapper" title="<?php esc_attr_e( 'View your shopping cart', 'alchemists' ); ?>">

          <?php if ( !empty( $icon_custom_cart ) ) : ?>
            <span class="df-icon-custom"><?php echo $icon_custom_cart; ?></span>
          <?php else : ?>
            <div class="df-icon-stack df-icon-stack--bag">
              <svg role="img" class="df-icon df-icon--bag">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/icons-basket.svg#bag"/>
              </svg>
              <svg role="img" class="df-icon df-icon--bag-handle">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/icons-basket.svg#bag-handle"/>
              </svg>
            </div>
          <?php endif; ?>

          <h6 class="info-block__heading"><?php esc_html_e( 'Your Bag', 'alchemists' ); ?> (<?php printf( _n( '%s item', '%s items', $product_count, 'alchemists' ), $product_count ); ?>)</h6>
          <span class="info-block__cart-sum"><?php echo WC()->cart->get_cart_total(); ?></span>
        </a>

        <div class="header-cart-dropdown">
          <div class="widget_shopping_cart_content"></div>
        </div>

      </li>
      <?php endif; ?>

    </ul>
  </div>
</div>
