<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   2.2.0
 */

$alchemists_data       = get_option('alchemists_data');
$breadcrumbs           = isset( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) : '';
$post_author_box       = isset( $alchemists_data['alchemists__opt-single-post-author'] ) ? esc_html( $alchemists_data['alchemists__opt-single-post-author'] ) : '';
$post_layout_get       = isset( $_GET['single_post'] ) ? $_GET['single_post'] : '';
$categories_toggle     = isset( $alchemists_data['alchemists__posts-categories'] ) ? $alchemists_data['alchemists__posts-categories'] : 1;

// post thumbnail
$header_post = '';
if ( has_post_thumbnail() ) {
	$thumb_id = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src($thumb_id, 'full', true);

	$header_post = 'style="background-image:url(' . $thumb_url[0] . ')"';
}

?>


<!-- Page Heading
================================================== -->
<div class="page-heading page-heading--overlay" <?php echo wp_kses_post( $header_post ); ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<!-- Post Meta - Top -->
				<div class="post__meta-block post__meta-block--top">

					<?php if ( $categories_toggle ) : ?>
						<?php alchemists_post_category_labels( 'post__category' ); ?>
					<?php endif; ?>

					<!-- Post Title -->
					<?php the_title( '<h1 class="page-heading__title">', '</h1>' ); ?>
					<!-- Post Title / End -->

					<!-- Post Meta Info -->
					<?php alchemists_entry_meta_single(); ?>
					<!-- Post Meta Info / End -->

					<!-- Post Author -->
					<div class="post-author">
						<figure class="post-author__avatar">
							<?php echo get_avatar( get_the_author_meta('email'), '40' ); ?>
						</figure>
						<div class="post-author__info">
							<h4 class="post-author__name"><?php the_author(); ?></h4>
							<span class="post-author__slogan"><?php echo get_the_author_meta('nickname'); ?></span>
						</div>
					</div>
					<!-- Post Author / End -->

				</div>
				<!-- Post Meta - Top / End -->
			</div>
		</div>
	</div>
</div>

<div class="site-content" id="content">
	<div class="container">
		<div class="row">

			<div id="primary" class="content-area col-md-8 col-md-offset-2">

				<?php
				while ( have_posts() ) : the_post();

					// set post views
					if ( function_exists( 'alchemists_setPostViews' ) ) {
						alchemists_setPostViews( get_the_ID() );
					}

					get_template_part( 'template-parts/content', 'single-3' );

					// Post Social Sharing
					if ( function_exists( 'alc_post_social_share_buttons' ) ) {
						alc_post_social_share_buttons();
					}

					if ( $post_layout_get != '3' ) {

						if ( $post_author_box != 0 ) {
							// Post Author
							get_template_part( 'template-parts/post/post', 'author' );
						}
					}

					// Post Navigation
					get_template_part( 'template-parts/post/post', 'navigation' );


					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</div><!-- #primary -->

		</div>
	</div>
</div>
