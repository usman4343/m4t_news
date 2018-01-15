<?php
/**
 * Template part for Header on mobile devices.
 *
 * @package Alchemists
 * @since Alchemists 1.0.0
 */

$alchemists_data = get_option('alchemists_data');

$alchemists_logo_standard = isset( $alchemists_data['alchemists__opt-logo-standard']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-standard']['url'] ) : '';
$alchemists_logo_retina   = isset( $alchemists_data['alchemists__opt-logo-retina']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-retina']['url'] ) : ''; ?>

<div class="header-mobile clearfix" id="header-mobile">
  <div class="header-mobile__logo">

    <?php if ( !empty( $alchemists_logo_standard ) ) { ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <img src="<?php echo esc_url( $alchemists_logo_standard ); ?>" <?php if ( !empty( $alchemists_logo_retina ) ) { ?> srcset="<?php echo esc_url( $alchemists_logo_retina ); ?> 2x" <?php } ?> class="header-mobile__logo-img" alt="<?php bloginfo('name'); ?>">
      </a>
    <?php } else { ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <?php if ( alchemists_sp_preset('soccer') ) : ?>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/soccer/logo.png" class="header-mobile__logo-img" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/soccer/logo@2x.png 2x" alt="<?php esc_attr( bloginfo('name') ); ?>">
        <?php else : ?>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" class="header-mobile__logo-img" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/logo@2x.png 2x" alt="<?php esc_attr( bloginfo('name') ) ; ?>">
        <?php endif; ?>
      </a>
    <?php } ?>

  </div>
  <div class="header-mobile__inner">
    <a id="header-mobile__toggle" class="burger-menu-icon"><span class="burger-menu-icon__line"></span></a>
    <span class="header-mobile__search-icon" id="header-mobile__search-icon"></span>
  </div>
</div>
