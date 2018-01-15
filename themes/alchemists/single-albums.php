<?php
/**
 * The template for displaying single Album Custom Post Type
 *
 * @author 		Dan Fisher
 * @package 	Alchemists
 * @version   1.0
 */

get_header();

$alchemists_data = get_option('alchemists_data');
$page_heading_overlay  = isset( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) : '';
$breadcrumbs           = isset( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) : '';

?>


<!-- Page Heading
================================================== -->
<div class="page-heading <?php echo esc_attr( $page_heading_overlay ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<?php the_title( '<h1 class="page-heading__title">', '</h1>' ); ?>
				<?php
				// Breadcrumb
				if ( function_exists( 'breadcrumb_trail' ) && $breadcrumbs != 0 ) {
					breadcrumb_trail( array(
						'show_browse' => false,
					));
				}?>
			</div>
		</div>
	</div>
</div>

<div class="site-content" id="content">

  <div class="container">
    <div class="content-title">
      <a href="<?php echo wp_get_referer(); ?>" class="btn btn-xs btn-default btn-outline"><?php esc_html_e( 'Go Back to the Albums', 'alchemists' ); ?></a>
    </div>
  </div>

	<div class="row">

		<div id="primary" class="content-area">
      <main id="main" class="site-main">

        <?php
        $images = get_field('album_photos');

        if ( $images ): ?>
        <!-- Gallery Album -->
        <div class="album album--condensed container-fluid">
          <div class="row">

            <?php if ( alchemists_sp_preset( 'soccer' ) ) : ?>

              <?php foreach ( $images as $image ): ?>
                <div class="album__item col-xs-6 col-sm-4">
                  <div class="album__item-holder">
                    <a href="<?php echo esc_url( $image['url'] ); ?>" class="album__item-link mp_gallery">
                      <figure class="album__thumb">
                        <img src="<?php echo esc_url( $image['sizes']['large'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                      </figure>
                      <div class="album__item-desc">
                        <?php if ( $image['title'] ) : ?>
                        <h4 class="album__item-title"><?php echo esc_html( $image['title'] ); ?></h4>
                        <?php endif; ?>
                        <?php if ( $image['caption'] ) : ?>
                        <div class="album__item-date"><?php echo esc_html( $image['caption'] ); ?></div>
                        <?php endif; ?>
                        <span class="album__item-btn-fab btn-fab btn-fab--clean"></span>
                      </div>
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>

            <?php else : ?>

              <?php foreach ( $images as $image ): ?>
                <div class="album__item col-xs-6 col-sm-4">
                  <div class="album__item-holder">
                    <a href="<?php echo esc_url( $image['url'] ); ?>" class="album__item-link mp_gallery">
                      <figure class="album__thumb">
                        <img src="<?php echo esc_url( $image['sizes']['large'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                      </figure>
                      <div class="album__item-desc album__item-desc--bottom-left">
                        <span class="album__item-icon">
                          <span class="icon-camera"></span>
                        </span>
                        <div class="album__item-desc-inner">
                          <?php if ( $image['title'] ) : ?>
                          <h4 class="album__item-title"><?php echo esc_html( $image['title'] ); ?></h4>
                          <?php endif; ?>

                          <?php if ( $image['caption'] ) : ?>
                          <div class="album__item-date"><?php echo esc_html( $image['caption'] ); ?></div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>

            <?php endif; ?>

          </div>
        </div>
        <!-- Gallery Album / End -->
        <?php endif; ?>

      </main><!-- #main -->
    </div><!-- #primary -->

	</div>
</div>


<?php get_footer();
