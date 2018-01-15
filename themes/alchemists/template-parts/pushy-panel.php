<?php
/**
 * Template part for Pushy Panel.
 *
 * @package Alchemists
 * @since Alchemists 1.0.0
 */

$alchemists_data     = get_option('alchemists_data');

$logo_pushy_standard = isset( $alchemists_data['alchemists__opt-logo-pushy-standard']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-pushy-standard']['url'] ) : '';
$logo_pushy_retina   = isset( $alchemists_data['alchemists__opt-logo-pushy-retina']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-pushy-retina']['url'] ) : '';

// Color scheme
$pushy_panel_color   = isset( $alchemists_data['alchemists__pushy-panel-color'] ) ? $alchemists_data['alchemists__pushy-panel-color'] : 'light';
?>

<aside class="pushy-panel pushy-panel--<?php echo esc_attr( $pushy_panel_color ); ?>">
  <div class="pushy-panel__inner">

    <?php if ( isset($alchemists_data['alchemists__header-pushy-panel-logo']) && $alchemists_data['alchemists__header-pushy-panel-logo'] == 1 ) { ?>
    <header class="pushy-panel__header">
      <div class="pushy-panel__logo">

        <?php if ( !empty( $logo_pushy_standard ) ) { ?>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img src="<?php echo esc_url( $logo_pushy_standard ); ?>" <?php if ( !empty( $logo_pushy_retina ) ) { ?> srcset="<?php echo esc_url( $logo_pushy_retina ); ?> 2x" <?php } ?> class="pushy-panel__logo-img" alt="<?php bloginfo('name'); ?>">
          </a>
        <?php } else { ?>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <?php if ( alchemists_sp_preset('soccer') ) : ?>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/soccer/logo.png" class="pushy-panel__logo-img" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/soccer/logo@2x.png 2x" alt="<?php esc_attr( bloginfo('name') ); ?>">
            <?php else : ?>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" class="pushy-panel__logo-img" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/logo@2x.png 2x" alt="<?php esc_attr( bloginfo('name') ) ; ?>">
            <?php endif; ?>
          </a>
        <?php } ?>

      </div>
    </header>
    <?php } ?>

    <div class="pushy-panel__content">

      <?php if ( is_active_sidebar( 'alchemists-sidebar-pushy-panel' ) ) { ?>

      <?php dynamic_sidebar('alchemists-sidebar-pushy-panel'); ?>

      <?php } else { ?>

        <div class="alert alert-warning pushy-panel__alert"><?php echo wp_kses_post( 'Ooops! Sidebar is empty.<br> Add some widgets in <strong>Settings > Widgets > Pushy Panel</strong>', 'alchemists'); ?></div>

      <?php } ?>

    </div>
    <a href="#" class="pushy-panel__back-btn"></a>
  </div>
</aside>
