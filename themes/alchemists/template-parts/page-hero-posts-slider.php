<?php
/**
 * Page Header - Hero Slider
 *
 * @author 		Dan Fisher
 * @package 	Alchemists
 * @version   2.0.0
 */

$alchemists_data      = get_option('alchemists_data');
$hero_posts           = isset( $alchemists_data['alchemists__hero-posts-slider'] ) ? $alchemists_data['alchemists__hero-posts-slider'] : '';
$hero_slider_per_page = isset( $alchemists_data['alchemists__hero-posts-slider--per-page'] ) ? $alchemists_data['alchemists__hero-posts-slider--per-page'] : 3;
$hero_slider_orderby  = isset( $alchemists_data['alchemists__hero-posts-slider--orderby'] ) ? $alchemists_data['alchemists__hero-posts-slider--orderby'] : 'date';
$hero_slider_order    = isset( $alchemists_data['alchemists__hero-posts-slider--order'] ) ? $alchemists_data['alchemists__hero-posts-slider--order'] : 'DESC';
$hero_slider_cats     = isset( $alchemists_data['alchemists__hero-posts-slider--categories'] ) ? $alchemists_data['alchemists__hero-posts-slider--categories'] : '';
$hero_slider_tags     = isset( $alchemists_data['alchemists__hero-posts-slider--tags'] ) ? $alchemists_data['alchemists__hero-posts-slider--tags'] : '';
$hero_slider_autoplay = isset( $alchemists_data['alchemists__hero-posts-autoplay'] ) ? $alchemists_data['alchemists__hero-posts-autoplay'] : true;
$hero_slider_autoplay_speed = isset( $alchemists_data['alchemists__hero-posts-autoplay-speed'] ) ? $alchemists_data['alchemists__hero-posts-autoplay-speed'] : 8;
$hero_slider_autoplay_speed = $hero_slider_autoplay_speed * 1000;
?>

<?php

// Posts arguments
$hero_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => $hero_slider_per_page,
	'order'               => $hero_slider_order,
	'orderby'             => $hero_slider_orderby,
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => true,
);

// posts id
if( !empty( $hero_posts ) ) {
	$hero_args['post__in'] = $hero_posts;
}

// filter posts by categories
if( !empty( $hero_slider_cats ) ) {
	$hero_args['cat'] = $hero_slider_cats;
}

// filter by tags
if( !empty( $hero_slider_tags ) ) {
	$hero_args['tag__in'] = $hero_slider_tags;
}

$hero_query = new WP_Query( $hero_args );
if ( $hero_query->have_posts() ) : ?>

<!-- Hero Slider
================================================== -->
<div class="hero-slider-wrapper">

	<!-- Slides -->
	<div class="hero-slider">

		<?php while ( $hero_query->have_posts() ) : $hero_query->the_post();

			get_template_part( 'template-parts/content', 'hero-slider' );

		endwhile;

		wp_reset_postdata(); ?>

	</div>
	<!-- Slides / End -->

	<!-- Thumbs -->
	<div class="hero-slider-thumbs-wrapper">
		<div class="container">
			<div class="hero-slider-thumbs posts posts--simple-list">

				<?php while ( $hero_query->have_posts() ) : $hero_query->the_post();

					get_template_part( 'template-parts/content', 'hero-thumb' );

				endwhile; ?>

			</div>
		</div>
	</div>
	<!-- Thumbs / End -->

	<script type="text/javascript">
		(function($){
			$(document).on('ready', function() {

				var $slick_hero_slider = $('.hero-slider'),
						$slick_hero_thumbs = $('.hero-slider-thumbs');

				$slick_hero_slider.slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					fade: true,
					autoplay: <?php echo esc_js( $hero_slider_autoplay ); ?>,
					autoplaySpeed: <?php echo esc_js( $hero_slider_autoplay_speed ); ?>,
					asNavFor: $slick_hero_thumbs,

					responsive: [
						{
							breakpoint: 992,
							settings: {
								fade: false,
							}
						}
					]
				});

				$slick_hero_thumbs.slick({
					slidesToShow: 3,
					slidesToScroll: 1,
					asNavFor: $slick_hero_slider,
					focusOnSelect: true,
				});

			});
		})(jQuery);
	</script>

</div>
<?php endif; ?>
