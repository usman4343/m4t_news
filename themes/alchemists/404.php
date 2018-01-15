<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   1.0.0
 */

get_header();

$alchemists_data           = get_option('alchemists_data');
$page_heading_overlay      = isset( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) : '';
$breadcrumbs               = isset( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) : '';

$error_image               = isset( $alchemists_data['alchemists__opt-404-image']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-404-image']['url'] ) : '';
$error_page_heading        = isset( $alchemists_data['alchemists__opt-404-page-heading'] ) ? esc_html( $alchemists_data['alchemists__opt-404-page-heading'] ) : '';
$error_title               = isset( $alchemists_data['alchemists__opt-404-page-title'] ) ? esc_html( $alchemists_data['alchemists__opt-404-page-title'] ) : '';
$error_subtitle            = isset( $alchemists_data['alchemists__opt-404-page-subtitle'] ) ? esc_html( $alchemists_data['alchemists__opt-404-page-subtitle'] ) : '';
$error_desc                = isset( $alchemists_data['alchemists__opt-404-desc'] ) ? esc_html( $alchemists_data['alchemists__opt-404-desc'] ) : '';
$error_btn_primary         = isset( $alchemists_data['alchemists__opt-404-btn'] ) ? esc_html( $alchemists_data['alchemists__opt-404-btn'] ) : '';
$error_btn_primary_txt     = isset( $alchemists_data['alchemists__opt-404-btn-txt'] ) ? esc_html( $alchemists_data['alchemists__opt-404-btn-txt'] ) : '';
$error_btn_primary_link    = isset( $alchemists_data['alchemists__opt-404-btn-link'] ) ? esc_html( $alchemists_data['alchemists__opt-404-btn-link'] ) : '';
$error_btn_secondary       = isset( $alchemists_data['alchemists__opt-404-btn-secondary'] ) ? esc_html( $alchemists_data['alchemists__opt-404-btn-secondary'] ) : '';
$error_btn_secondary_txt   = isset( $alchemists_data['alchemists__opt-404-btn-secondary-txt'] ) ? esc_html( $alchemists_data['alchemists__opt-404-btn-secondary-txt'] ) : '';
$error_btn_secondary_link  = isset( $alchemists_data['alchemists__opt-404-btn-secondary-link'] ) ? esc_html( $alchemists_data['alchemists__opt-404-btn-secondary-link'] ) : '';

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
					<?php if ( !empty( $error_page_heading ) ) { ?>
						<?php echo esc_html( $error_page_heading ); ?>
					<?php } else { ?>
						<?php esc_html_e( '404 Error', 'alchemists' ); ?>
					<?php } ?>
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

		<!-- Error 404 -->
		<div class="error-404">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<?php if ( !empty( $error_image ) ) { ?>
						<figure class="error-404__figure">
	          	<img src="<?php echo esc_url( $error_image ); ?>" alt="">
						</figure>
	        <?php } else { ?>
						<figure class="error-404__figure error-404__figure--cross">
	          	<img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-ghost.svg" alt="404 Error Image">
						</figure>
	        <?php } ?>
					<header class="error__header">
						<h2 class="error__title">
							<?php if ( !empty( $error_title ) ) { ?>
			          <?php echo esc_html( $error_title ); ?>
			        <?php } else { ?>
			          <?php esc_html_e( 'OOOOPS! Page not Found', 'alchemists' ); ?>
			        <?php } ?>
						</h2>
						<h3 class="error__subtitle">
							<?php if ( !empty( $error_subtitle ) ) { ?>
			          <?php echo esc_html( $error_subtitle ); ?>
			        <?php } else { ?>
			          <?php esc_html_e( 'Seems that we have a problem!', 'alchemists'); ?>
			        <?php } ?>
						</h3>
					</header>
					<div class="error__description">
						<?php if ( !empty( $error_desc ) ) { ?>
							<?php echo wp_kses_post( $error_desc ); ?>
						<?php } else { ?>
							<?php echo wp_kses_post( __( 'The page you are looking for has been moved or doesn\'t exist anymore, if you like you can return to our homepage. If the problem persists, please send us an email to <a href="mailto:info@alchemists.com">info@alchemists.com</a>', 'alchemists' ) ); ?>
						<?php } ?>

					</div>
					<footer class="error__cta">

						<?php if ( $error_btn_primary != 0 ) : ?>
						<a href="<?php if ( !empty( $error_btn_primary_link) ) { echo esc_url( $error_btn_primary_link ); } else { echo esc_url( home_url( '/' ) ); } ?>" class="btn btn-primary">
							<?php if ( !empty( $error_btn_primary_txt ) ) {
								echo esc_html( $error_btn_primary_txt );
							} else {
								esc_html_e( 'Return to Home', 'alchemists' );
							} ?>
						</a>
						<?php endif; ?>

						<?php if ( $error_btn_secondary != 0 ) : ?>
						<a href="<?php if ( !empty( $error_btn_secondary_link) ) { echo esc_url( $error_btn_secondary_link ); } else { echo get_permalink( get_option( 'page_for_posts' ) ); } ?>" class="btn btn-primary-inverse">
							<?php if ( !empty( $error_btn_secondary_txt ) ) {
								echo esc_html( $error_btn_secondary_txt );
							} else {
								esc_html_e( 'Keep Browsing', 'alchemists' );
							} ?>
						</a>
						<?php endif; ?>

					</footer>
				</div>
			</div>
		</div>
		<!-- Error 404 / End -->

	</div>
</div>

<?php
get_footer();
