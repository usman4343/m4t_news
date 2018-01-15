<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Alchemists
 */

$alchemists_data       = get_option('alchemists_data');

// Footer Logo
$logo_footer           = isset( $alchemists_data['alchemists__opt-footer-logo'] ) ? esc_html( $alchemists_data['alchemists__opt-footer-logo'] ) : '';
$logo_footer_standard  = isset( $alchemists_data['alchemists__opt-logo-footer-standard']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-footer-standard']['url'] ) : '';
$logo_footer_retina    = isset( $alchemists_data['alchemists__opt-logo-footer-retina']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-footer-retina']['url'] ) : '';

// Footer Widgets
$footer_widgets        = isset( $alchemists_data['alchemists__opt-footer-widgets'] ) ? esc_html( $alchemists_data['alchemists__opt-footer-widgets'] ) : '';
$footer_widgets_layout = isset( $alchemists_data['alchemists__opt-footer-widgets-layout'] ) ? esc_html( $alchemists_data['alchemists__opt-footer-widgets-layout'] ) : '';

// Footer Sponsors
$footer_sponsors       = isset( $alchemists_data['alchemists__footer-sponsors'] ) ? $alchemists_data['alchemists__footer-sponsors'] : 0;
$footer_sponsors_title = isset( $alchemists_data['alchemists__footer-sponsors-title'] ) ? $alchemists_data['alchemists__footer-sponsors-title'] : '';
$footer_sponsors_imgs  = isset( $alchemists_data['alchemists__footer-sponsors-images'] ) ? $alchemists_data['alchemists__footer-sponsors-images'] : '';

// Footer Secondary
$footer_secondary      = isset( $alchemists_data['alchemists__opt-secondary'] ) ? esc_html( $alchemists_data['alchemists__opt-secondary'] ) : '';

// Copyright
$footer_copyright      = isset( $alchemists_data['alchemists__footer-secondary-copyright'] ) ? $alchemists_data['alchemists__footer-secondary-copyright'] : '';


$footer_logo_width = 'col-sm-12 col-md-3';
if ( $footer_widgets == 0 ) {
	$footer_logo_width = 'col-sm-12';
}


// Widgets Columns Width
$footer_widgets_col = 'col-sm-4 col-md-3';

if ( alchemists_sp_preset( 'soccer' ) ) {
  if ( $footer_widgets_layout == 1 ) {
    $footer_widgets_col = 'col-sm-4';
  }
} else {
  if ( $footer_widgets_layout == 1 && $logo_footer == 0 ) {
    $footer_widgets_col = 'col-sm-4';
  }
}
if ( $footer_widgets_layout == 2 ) {
	$footer_widgets_col = 'col-sm-3';
}
?>

	<!-- Footer
	================================================== -->
	<footer id="footer" class="footer">

		<?php // Don't display if Footer Widgets and Footer Logo disabled
		if ( ( $logo_footer == '' && $footer_widgets == '' ) || ( ( $logo_footer != 0 ) || ( $footer_widgets != 0 ) ) ) { ?>
	  <!-- Footer Widgets -->
	  <div class="footer-widgets">
	    <div class="footer-widgets__inner">
	      <div class="container">

	        <div class="row">

						<?php if ( $logo_footer != 0 && !alchemists_sp_preset( 'soccer' )) { ?>
							<div class="<?php echo esc_attr( $footer_logo_width ); ?>">
		            <div class="footer-col-inner">

									<!-- Footer Logo -->
									<div class="footer-logo">

										<?php if ( !empty( $logo_footer_standard ) ) { ?>
						          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
												<img src="<?php echo esc_url( $logo_footer_standard ); ?>" alt="<?php bloginfo('name'); ?>" <?php if ( !empty( $logo_footer_retina ) ) { ?> srcset="<?php echo esc_url( $logo_footer_retina ); ?> 2x" <?php } ?> class="footer-logo__img">
											</a>
						        <?php } else { ?>
						          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
												<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/logo@2x.png 2x" alt="<?php bloginfo('name'); ?>" class="footer-logo__img">
											</a>
						        <?php } ?>

									</div>
									<!-- Footer Logo / End -->

								</div>
							</div>
						<?php } ?>


						<?php if ( $footer_widgets == 1 ) { ?>

							<?php if ( is_active_sidebar( 'alchemists-footer-widget-1' ) ) { ?>
              <div class="<?php echo esc_attr( $footer_widgets_col ); ?>">

                <?php if ( alchemists_sp_preset( 'soccer' )) : ?>

                <!-- Footer Logo -->
                <div class="footer-logo footer-logo--has-txt">

                  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php if ( !empty( $logo_footer_standard ) ) { ?>
                      <img src="<?php echo esc_url( $logo_footer_standard ); ?>" alt="<?php bloginfo('name'); ?>" <?php if ( !empty( $logo_footer_retina ) ) { ?> srcset="<?php echo esc_url( $logo_footer_retina ); ?> 2x" <?php } ?> class="footer-logo__img">
                    <?php } else { ?>
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/soccer/logo-footer.png" class="footer-logo__img" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/soccer/logo-footer@2x.png 2x" alt="<?php esc_attr( bloginfo('name') ); ?>">
                    <?php } ?>
                  </a>

                  <div class="footer-logo__heading">
                    <h5 class="footer-logo__txt"><?php esc_html( bloginfo('name') ); ?></h5>
                    <?php if ( get_bloginfo( 'description' ) ) : ?>
                      <span class="footer-logo__tagline"><?php bloginfo( 'description' ); ?></span>
                    <?php endif; ?>
                  </div>

                </div>
                <!-- Footer Logo / End -->
                <?php endif; ?>

								<div class="footer-col-inner">
									<?php dynamic_sidebar('alchemists-footer-widget-1'); ?>
								</div>
							</div>
							<?php } ?>

							<?php if ( is_active_sidebar( 'alchemists-footer-widget-2' ) ) { ?>
		          <div class="<?php echo esc_attr( $footer_widgets_col ); ?>">
								<div class="footer-col-inner">
									<?php dynamic_sidebar('alchemists-footer-widget-2'); ?>
								</div>
							</div>
							<?php } ?>

							<?php if ( is_active_sidebar( 'alchemists-footer-widget-3' ) ) { ?>
		          <div class="<?php echo esc_attr( $footer_widgets_col ); ?>">
								<div class="footer-col-inner">
									<?php dynamic_sidebar('alchemists-footer-widget-3'); ?>
								</div>
							</div>
							<?php } ?>

							<?php // Display this widget area if Footer Widgets Layout set to 4 columns
							if ( $footer_widgets_layout == 2 && is_active_sidebar( 'alchemists-footer-widget-4' ) ) : ?>
								<div class="<?php echo esc_attr( $footer_widgets_col ); ?>">
			            <div class="footer-col-inner">
										<?php dynamic_sidebar('alchemists-footer-widget-4'); ?>
									</div>
								</div>
							<?php endif; ?>

						<?php } ?>

	        </div>
	      </div>
      </div>

      <?php if ( $footer_sponsors == 1 ) : ?>
        <!-- Sponsors -->
        <div class="container">
          <div class="sponsors">

            <?php if ( !empty( $footer_sponsors_title ) ) : ?>
              <h6 class="sponsors-title"><?php echo esc_html( $footer_sponsors_title ); ?></h6>
            <?php endif; ?>

            <?php if ( !empty( $footer_sponsors_imgs ) ) :

              $footer_sponsors_imgs_array = explode( ',', $footer_sponsors_imgs ); ?>

              <ul class="sponsors-logos">
                <?php foreach ( $footer_sponsors_imgs_array as $footer_sponsors_img ) { ?>
                  <?php $sponsor_img_alt = get_post_meta( $footer_sponsors_img, '_wp_attachment_image_alt', true); ?>
                  <li class="sponsors__item">
                    <img src="<?php echo wp_get_attachment_url( $footer_sponsors_img ); ?>" alt="<?php echo esc_attr( $sponsor_img_alt ); ?>">
                  </li>
                <?php } ?>
              </ul>
            <?php endif; ?>

          </div>
        </div>
        <!-- Sponsors / End -->
      <?php endif; ?>


	  </div>
	  <!-- Footer Widgets / End -->
		<?php } ?>

	  <!-- Footer Secondary -->
    <?php if ( $footer_secondary == '' || $footer_secondary == 1 ) : ?>

      <?php if ( alchemists_sp_preset( 'soccer' )) : ?>

        <div class="footer-secondary">
          <div class="container">
            <div class="footer-secondary__inner">
              <div class="row">
                <?php if (!empty( $footer_copyright )) : ?>
                <div class="col-md-4">
                  <div class="footer-copyright">
                    <?php echo wp_kses_post( $footer_copyright ); ?>
                  </div>
                </div>
                <?php endif; ?>
                <div class="col-md-8">
                  <?php // Footer navigation
                  if ( has_nav_menu('footer_menu') ) {
                    wp_nav_menu(
                      array(
                        'theme_location'  => 'footer_menu',
                        'container'       => false,
                        'menu_class'      => 'footer-nav footer-nav--right footer-nav--condensed footer-nav--sm',
                        'echo'            => true,
                        'fallback_cb'     => false,
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 0,
                      )
                    );
                  } ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php else : ?>

        <div class="footer-secondary footer-secondary--has-decor">
          <div class="container">
            <div class="footer-secondary__inner">
              <div class="row">
                <div class="col-md-10 col-md-offset-1">
                  <?php // Footer navigation
                  if ( has_nav_menu('footer_menu') ) {
                    wp_nav_menu(
                      array(
                        'theme_location'  => 'footer_menu',
                        'container'       => false,
                        'menu_class'      => 'footer-nav',
                        'echo'            => true,
                        'fallback_cb'     => false,
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 0,
                      )
                    );
                  } ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php endif; ?>
	  <!-- Footer Secondary / End -->
		<?php endif; ?>

	</footer>
	<!-- Footer / End -->

</div><!-- .site-wrapper -->

<?php wp_footer(); ?>

</body>
</html>
