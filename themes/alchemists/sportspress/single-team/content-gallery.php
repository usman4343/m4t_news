<?php
/**
 * The template for displaying Single Team
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   1.0.0
 */

$team_gallery_albums = get_field('team_gallery_albums');

if( $team_gallery_albums ): ?>

	<!-- Team Gallery -->
	<div class="gallery row">
		<?php foreach( $team_gallery_albums as $post): ?>

			<?php setup_postdata( $post ); ?>

			<div class="gallery__item col-xs-6 col-sm-4">
				<a href="<?php echo get_permalink( ); ?>" class="gallery__item-inner card">

					<figure class="gallery__thumb">
						<?php if( has_post_thumbnail() ) {
							the_post_thumbnail('alchemists_thumbnail');
						} else {
							echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder-380x270.jpg" alt="" />';
						} ?>
						<span class="btn-fab gallery__btn-fab"></span>
					</figure>

					<div class="gallery__content card__content">
						<span class="gallery__icon">
							<span class="icon-camera"></span>
						</span>
						<div class="gallery__details">
							<h4 class="gallery__name"><?php echo get_the_title(); ?></h4>
							<div class="gallery__date"><?php the_time( get_option('date_format') ); ?></div>
						</div>
					</div>
				</a>
			</div>

		<?php endforeach; ?>
	</div>
	<?php wp_reset_postdata(); ?>
	<!-- Team Gallery / End -->

<?php endif;
