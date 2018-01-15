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

get_header();

$alchemists_data    = get_option('alchemists_data');
$post_layout        = isset( $alchemists_data['alchemists__opt-single-post-layout'] ) ? esc_html( $alchemists_data['alchemists__opt-single-post-layout'] ) : '1';
$post_layout_get    = isset( $_GET['single_post'] ) ? $_GET['single_post'] : '';
$custom_post_layout = get_field('post_layout');

if ( is_singular( 'post' ) ) {

	// Select a layout depends on Theme Options, GET variable or Post Options
	if ( $post_layout == '3' || $post_layout_get == '3' || $custom_post_layout == 'layout_3' ) {

		get_template_part( 'template-parts/post/post', 'single-3' );

	} elseif ( $post_layout == '2' || $post_layout_get == '2' || $custom_post_layout == 'layout_2' ) {

		get_template_part( 'template-parts/post/post', 'single-2' );

	} else {

		get_template_part( 'template-parts/post/post', 'single-1' );
	}

} else {

	get_template_part( 'template-parts/single' );

}

get_footer();
