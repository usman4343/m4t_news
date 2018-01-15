<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package alchemists
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php $alchemists_data = get_option('alchemists_data'); ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php do_action('alchemists_before_body_content'); ?>

	<div class="site-wrapper clearfix">
		<div class="site-overlay"></div>

	  <!-- Header
	  ================================================== -->

	  <!-- Header Mobile -->
		<?php get_template_part( 'template-parts/header-mobile' ); ?>
		<!-- Header Mobile / End -->

	  <!-- Header Desktop -->
	  <header class="header">

	    <!-- Header Top Bar -->
			<?php get_template_part( 'template-parts/header-top-bar' ); ?>
	    <!-- Header Top Bar / End -->

	    <!-- Header Secondary -->
			<?php get_template_part( 'template-parts/header-secondary' ); ?>
	    <!-- Header Secondary / End -->

	    <!-- Header Primary -->
			<?php get_template_part( 'template-parts/header-primary' ); ?>
	    <!-- Header Primary / End -->

	  </header>
	  <!-- Header / End -->

		<?php
		$pushy_panel = isset( $alchemists_data['alchemists__header-pushy-panel'] ) ? $alchemists_data['alchemists__header-pushy-panel'] : 1;

		if ( $pushy_panel ) : ?>
		<!-- Pushy Panel -->
		<?php get_template_part( 'template-parts/pushy-panel'); ?>
		<!-- Pushy Panel / End -->
		<?php endif; ?>
