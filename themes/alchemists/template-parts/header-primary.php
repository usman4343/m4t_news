<?php
/**
 * Template part for Header Primary section.
 *
 * @package Alchemists
 * @since Alchemists 2.0.0
 */

$alchemists_data = get_option('alchemists_data');

$logo_standard = isset( $alchemists_data['alchemists__opt-logo-standard']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-standard']['url'] ) : '';
$logo_retina   = isset( $alchemists_data['alchemists__opt-logo-retina']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-retina']['url'] ) : '';
$pushy_panel   = isset( $alchemists_data['alchemists__header-pushy-panel'] ) ? $alchemists_data['alchemists__header-pushy-panel'] : 1;

?>

<div class="header__primary">
  <div class="container">
    <div class="header__primary-inner">

      <!-- Header Logo -->
      <div class="header-logo">
        <?php if ( !empty( $logo_standard ) ) { ?>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img src="<?php echo esc_url( $logo_standard ); ?>" <?php if ( !empty( $logo_retina ) ) { ?> srcset="<?php echo esc_url( $logo_retina ); ?> 2x" <?php } ?> class="header-logo__img" alt="<?php bloginfo('name'); ?>">
          </a>
        <?php } else { ?>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

            <?php if ( alchemists_sp_preset('soccer') ) : ?>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/soccer/logo.png" class="header-logo__img" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/soccer/logo@2x.png 2x" alt="<?php esc_attr( bloginfo('name') ); ?>">
            <?php else : ?>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" class="header-logo__img" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/logo@2x.png 2x" alt="<?php esc_attr( bloginfo('name') ) ; ?>">
            <?php endif; ?>

          </a>
        <?php } ?>
      </div>
      <!-- Header Logo / End -->

      <!-- Main Navigation -->
      <nav class="main-nav clearfix">
        <?php // Primary navigation
        if ( has_nav_menu('primary') ) {
          wp_nav_menu(
            array(
              'theme_location'  => 'primary',
              'container'       => false,
              'menu_class'      => 'main-nav__list',
              'echo'            => true,
              'fallback_cb'     => 'wp_page_menu',
              'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
              'depth'           => 0,
              'walker'          => new Alchemists_Nav_Menu()
            )
          );
        } ?>

        <?php if ( isset ( $alchemists_data['alchemists__header-primary-social'] ) && $alchemists_data['alchemists__header-primary-social'] == 1 ) :

          // Get all social media links
          $social_media = $alchemists_data['alchemists__header-primary-social-links'];
        ?>

          <!-- Social Links -->
          <ul class="social-links social-links--inline social-links--main-nav">
            <?php foreach ( array_filter( $social_media ) as $key => $value) {

              switch($key) {

                case esc_html__( 'Facebook URL', 'alchemists') :
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Facebook URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>';
                break;

                case esc_html__( 'Twitter URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Twitter URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>';
                break;

                case esc_html__( 'LinkedIn URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'LinkedIn URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
                break;

                case esc_html__( 'Google+ URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Google+ URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Google+" target="_blank"><i class="fa fa-google-plus"></i></a></li>';
                break;

                case esc_html__( 'Instagram URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Instagram URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>';
                break;

                case esc_html__( 'Github URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Github URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Github" target="_blank"><i class="fa fa-github"></i></a></li>';
                break;

                case esc_html__( 'VK URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'VK URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="VKontakte" target="_blank"><i class="fa fa-vk"></i></a></li>';
                break;

                case esc_html__( 'YouTube URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'YouTube URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="YouTube" target="_blank"><i class="fa fa-youtube"></i></a></li>';
                break;

                case esc_html__( 'Pinterest URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Pinterest URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Pinterest" target="_blank"><i class="fa fa-pinterest"></i></a></li>';
                break;

                case esc_html__( 'Tumblr URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Tumblr URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Tumblr" target="_blank"><i class="fa fa-tumblr"></i></a></li>';
                break;

                case esc_html__( 'Dribbble URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Dribbble URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Dribbble" target="_blank"><i class="fa fa-dribbble"></i></a></li>';
                break;

                case esc_html__( 'Vimeo URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Vimeo URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Vimeo" target="_blank"><i class="fa fa-vimeo"></i></a></li>';
                break;

                case esc_html__( 'Flickr URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Flickr URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Flickr" target="_blank"><i class="fa fa-flickr"></i></a></li>';
                break;

                case esc_html__( 'Yelp URL', 'alchemists'):
                  echo '<li class="social-links__item"><a href="' . esc_url( $social_media[ esc_html__( 'Yelp URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Yelp" target="_blank"><i class="fa fa-yelp"></i></a></li>';
                break;
              }
            } ?>
          </ul>
          <!-- Social Links / End -->
        <?php endif; ?>


        <?php if ( $pushy_panel == 1 ) : ?>
        <!-- Pushy Panel Toggle -->
        <a href="#" class="pushy-panel__toggle">
          <span class="pushy-panel__line"></span>
        </a>
        <!-- Pushy Panel Toggle / Eng -->
        <?php endif; ?>

      </nav>
      <!-- Main Navigation / End -->
    </div>
  </div>
</div>
