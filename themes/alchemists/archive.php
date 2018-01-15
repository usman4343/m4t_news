<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Alchemists
 */

get_header();

$alchemists_data           = get_option('alchemists_data');
$page_heading_overlay      = isset( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) : '';
$breadcrumbs               = isset( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) : '';

if ( $page_heading_overlay == 0 ) {
	$page_heading_overlay = 'page-heading--no-bg';
} else {
	$page_heading_overlay = 'page-heading--has-bg';
}

?>

<!-- Page Heading
================================================== -->
<div class="page-heading <?php echo esc_attr( $page_heading_overlay ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<?php
					the_archive_title( '<h1 class="page-heading__title">', '</h1>' );
				?>
				<?php
				// Breadcrumb
				if ( function_exists( 'breadcrumb_trail' ) && $breadcrumbs != 0 ) {
					breadcrumb_trail( array(
						'show_browse' => false,
						// 'show_title'  => false
					));
				}?>

        <?php if ( is_category() || is_tag() ) : ?>
        <div class="page-header__desc">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <?php
              if ( is_category( ) ) :
                echo category_description();
              elseif ( is_tag() ) :
                echo tag_description();
              endif;
              ?>
            </div>
          </div>
        </div>
        <?php endif; ?>

			</div>
		</div>
	</div>
</div>

<div class="site-content" id="content">
	<div class="container">
		<div class="row">

			<div id="primary" class="content-area col-md-8">
				<main id="main" class="site-main">

				<?php
				if ( have_posts() ) : ?>

					<div class="posts posts--cards posts--cards-thumb-left post-list">

					<?php /* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

          endwhile;

          // Reset the global $the_post as this query will have stomped on it
          wp_reset_postdata();

          // add pagination
          alchemists_pagination(); ?>

					</div><!-- .posts -->

				<?php else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->


			<aside id="secondary" class="sidebar widget-area col-md-4">
				<?php get_sidebar(); ?>
			</aside><!-- #secondary -->

		</div>
	</div>
</div>

<?php
get_footer();
