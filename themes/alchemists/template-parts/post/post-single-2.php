<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Alchemists
 */


$alchemists_data       = get_option('alchemists_data');
$post_author_box       = isset( $alchemists_data['alchemists__opt-single-post-author'] ) ? esc_html( $alchemists_data['alchemists__opt-single-post-author'] ) : '';
$post_layout_get       = isset( $_GET['single_post'] ) ? $_GET['single_post'] : '';

?>

<div class="site-content" id="content">
	<div class="container">
		<div class="row">

			<div id="primary" class="content-area col-md-8">

				<?php
				while ( have_posts() ) : the_post();

					// set post views
					if ( function_exists( 'alchemists_setPostViews' ) ) {
						alchemists_setPostViews( get_the_ID() );
					}

					get_template_part( 'template-parts/content', 'single-2' );

					if ( $post_layout_get != '2' ) {

            if ( $post_author_box != 0 ) {
              // Post Author
  						get_template_part( 'template-parts/post/post', 'author' );
            }
					}

					// Post Navigation
					get_template_part( 'template-parts/post/post', 'navigation-2' );


					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</div><!-- #primary -->


			<aside id="secondary" class="sidebar widget-area col-md-4">
				<?php get_sidebar(); ?>
			</aside><!-- #secondary -->

		</div>
	</div>
</div>
