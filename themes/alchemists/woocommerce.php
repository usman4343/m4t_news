<?php
/**
 * The template for displaying Woocommerce pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Alchemists
 * @version 1.0.0
 */

get_header();

$alchemists_data       = get_option('alchemists_data');
$page_heading_overlay  = isset( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) : '';
$breadcrumbs           = isset( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) : '';

$post_id = get_option( 'woocommerce_shop_page_id' );

if ( $page_heading_overlay == 0 ) {
	$page_heading_overlay = 'page-heading--no-bg';
} else {
	$page_heading_overlay = 'page-heading--has-bg';
}

// Page Options
$page_heading = get_field('page_heading');

// Shop Options
$shop_sidebar      = isset( $alchemists_data['alchemists__shop-sidebar'] ) ? esc_html( $alchemists_data['alchemists__shop-sidebar'] ) : 'left_sidebar';

// Left Sidebar
$content_class = 'col-md-9 col-md-push-3';
$sidebar_class = 'col-md-3 col-md-pull-9';

if ( $shop_sidebar == 'right_sidebar' ) {
	// Right Sidebar
	$content_class = 'col-md-9';
	$sidebar_class = 'col-md-3';
} elseif ( $shop_sidebar == 'no_sidebar' ) {
	// No Sidebar (fullwidth)
	$content_class = 'col-md-12';
}


// remove sidebar on Single Product
if ( is_singular( 'product' ) ) {
	$content_class = 'col-md-12';
}

?>



<?php if ( $page_heading == 'page_hero' ) { ?>

	<?php get_template_part( 'template-parts/page-hero-unit'); ?>

<?php } elseif ( $page_heading == 'page_default' || !$page_heading ) { ?>

	<!-- Page Heading
	================================================== -->
	<div class="page-heading <?php echo esc_attr( $page_heading_overlay ); ?>">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<h1 class="page-heading__title">
						<?php echo esc_html( get_the_title( $post_id ) ) ; ?>
					</h1>
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

<?php } ?>


<div class="site-content" id="content">
	<div class="container">
		<div class="row">

			<div id="primary" class="content-area <?php echo esc_attr( $content_class ); ?>">
				<main id="main" class="site-main">

				<?php if ( have_posts() ) :
					woocommerce_content();
				endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php if ( $shop_sidebar != 'no_sidebar' ) : ?>
				<?php if ( !is_singular( 'product' ) ) : ?>
					<aside id="secondary" class="sidebar widget-area <?php echo esc_attr( $sidebar_class ); ?>">
						<?php dynamic_sidebar( 'alchemists-shop-sidebar' ); ?>
					</aside><!-- #secondary -->
				<?php endif; ?>
			<?php endif; ?>

		</div>
	</div>
</div>

<?php
get_footer();
