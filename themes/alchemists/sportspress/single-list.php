<?php
/**
 * The template for displaying Single Team List
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Alchemists
 */

get_header();

$alchemists_data       = get_option('alchemists_data');
$page_heading_overlay  = isset( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) : '';
$breadcrumbs           = isset( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) : '';
$post_author_box       = isset( $alchemists_data['alchemists__opt-single-post-author'] ) ? esc_html( $alchemists_data['alchemists__opt-single-post-author'] ) : '';

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
				<?php the_title( '<h1 class="page-heading__title">', '</h1>' ); ?>
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

			<div id="primary" class="content-area col-md-12">

				<?php
				while ( have_posts() ) : the_post();

					the_content();

				endwhile; // End of the loop.
				?>

			</div><!-- #primary -->

		</div>
	</div>
</div>


<?php get_footer();
