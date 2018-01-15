<?php
/**
 * The template for displaying Single Player
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   1.0.0
 */
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php
		$images = get_field('images');

		if ( $images ): ?>
		<!-- Gallery Album -->
		<div class="album-wrapper">
			<div class="album">

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

			</div>
		</div>
		<!-- Gallery Album / End -->
		<?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->
