<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package alchemists
 */

get_header();

$alchemists_data       = get_option('alchemists_data');
$page_heading_overlay  = isset( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) : '';
$breadcrumbs           = isset( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) : '';

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
				<h1 class="page-heading__title">
					<?php esc_html_e('Search Results', 'alchemists'); ?>
				</h1>
				<?php
				// Breadcrumb
				if ( function_exists( 'breadcrumb_trail' ) && $breadcrumbs != 0 ) {
					breadcrumb_trail( array(
						'show_browse' => false,
						// 'show_title'  => false
					));
				}?>
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

					<div class="posts posts--simple-list posts--simple-list--search">

					<?php /* Start the Loop */
					while ( have_posts() ) : the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */

						if ( get_post_type() == 'post' ) {

							get_template_part( 'template-parts/content-search', 'post' );

						} else {

							get_template_part( 'template-parts/content', 'search' );

						}

          endwhile;

          // Reset the global $the_post as this query will have stomped on it
          wp_reset_postdata();

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
