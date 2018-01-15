<?php
/**
 * Plugin Name: Alchemists SCSS Compiler
 * Plugin URI: https://github.com/danfisher85/alc-scss
 * Description: Compiles SCSS to CSS for Alchemists WP Theme.
 * Version: 2.0.2
 * Author: Dan Fisher
 * Author URI: https://themeforest.net/user/dan_fisher
 */


/*
 * 1. PLUGIN GLOBAL VARIABLES
 */

// Plugin Paths
if (!defined('DFSCSS_THEME_DIR'))
		define('DFSCSS_THEME_DIR', get_stylesheet_directory());

if (!defined('DFSCSS_PLUGIN_NAME'))
		define('DFSCSS_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('DFSCSS_PLUGIN_DIR'))
		define('DFSCSS_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . DFSCSS_PLUGIN_NAME);

if (!defined('DFSCSS_PLUGIN_URL'))
		define('DFSCSS_PLUGIN_URL', WP_PLUGIN_URL . '/' . DFSCSS_PLUGIN_NAME);

// Plugin Version
if (!defined('DFSCSS_VERSION_KEY'))
		define('DFSCSS_VERSION_KEY', 'dfscss_version');

if (!defined('DFSCSS_VERSION_NUM'))
		define('DFSCSS_VERSION_NUM', '2.0.2');



/*
 * 2. REQUIRE DEPENDENCIES
 *
 *    scssphp - scss compiler
 */

include_once DFSCSS_PLUGIN_DIR . '/compiler/WP_SCSS_Compiler.php'; // SCSS Compiler (vendor)


/**
 * 3. ENQUEUE STYLES
 */

add_action( 'wp_enqueue_scripts', 'df_enqueue_styles', 20 );
function df_enqueue_styles() {

	// Main styles
	if ( alchemists_sp_preset('soccer') ) {
		wp_enqueue_style( 'df-compiled', get_template_directory_uri() . '/sass/style-skin-soccer.scss', array( 'alchemists-style' ), DFSCSS_VERSION_NUM );
	} else {
		wp_enqueue_style( 'df-compiled', get_template_directory_uri() . '/sass/style-skin-basketball.scss', array( 'alchemists-style' ), DFSCSS_VERSION_NUM );
	}

	// Woocommerce styles
	if ( alchemists_sp_preset('soccer') ) {
		wp_enqueue_style( 'df-compiled-woocommerce', get_template_directory_uri() . '/sass/woocommerce/woocommerce-skin-soccer.scss', array( 'woocommerce' ), DFSCSS_VERSION_NUM );
	} else {
		wp_enqueue_style( 'df-compiled-woocommerce', get_template_directory_uri() . '/sass/woocommerce/woocommerce-skin-basketball.scss', array( 'woocommerce' ), DFSCSS_VERSION_NUM );
	}

	// Sportspress styles
	if ( alchemists_sp_preset('soccer') ) {
		wp_enqueue_style( 'df-compiled-sportspress', get_template_directory_uri() . '/sass/sportspress-skin-soccer.scss', array( 'alchemists-sportspress' ), DFSCSS_VERSION_NUM );
	} else {
		wp_enqueue_style( 'df-compiled-sportspress', get_template_directory_uri() . '/sass/sportspress-skin-basketball.scss', array( 'alchemists-sportspress' ), DFSCSS_VERSION_NUM );
	}
}



/**
 * 4. PASS VARIABLES INTO COMPILER
 */
add_filter( 'wp_scss_variables', 'df_scss_vars', 10, 2 );
function df_scss_vars( $vars, $handle ) {

	$alchemists_data = get_option('alchemists_data');

	if ( ! is_array( $vars ) ) {
		$vars = array();
	}

	if ( alchemists_sp_preset('soccer') ) {
		// Soccer Colors
		$colors = array(
			'color_primary'        => '#38a9ff',
			'color_primary_darken' => '#1892ed',
			'color_dark'           => '#1e2024',
			'color_dark_lighten'   => '#292c31',
			'color_gray'           => '#9a9da2',
			'color_2'              => '#31404b',
			'color_3'              => '#07e0c4',
			'color_4'              => '#c2ff1f',
			'color_4_darken'       => '#9fe900',
		); 
	} else {
		// Basketball Colors
		$colors = array(
			'color_primary'        => '#ffdc11',
			'color_primary_darken' => '#ffcc00',
			'color_dark'           => '#1e2024',
			'color_dark_lighten'   => '#292c31',
			'color_gray'           => '#9a9da2',
			'color_2'              => '#31404b',
			'color_3'              => '#ff7e1f',
			'color_4'              => '#9a66ca',
		); 
	}

	// Colors
	$vars['color-primary'] = ( isset( $alchemists_data['color-primary'] ) && !empty( $alchemists_data['color-primary'] ) ) ? $alchemists_data['color-primary'] : $colors['color_primary'];
	$vars['color-primary-darken'] = ( isset( $alchemists_data['color-primary-darken'] ) && !empty( $alchemists_data['color-primary-darken'] ) ) ? $alchemists_data['color-primary-darken'] : $colors['color_primary_darken'];
	$vars['color-dark'] = ( isset( $alchemists_data['color-dark'] ) && !empty( $alchemists_data['color-dark'] ) )  ? $alchemists_data['color-dark'] : $colors['color_dark'];
	$vars['color-dark-lighten'] = ( isset( $alchemists_data['color-dark-lighten'] ) && !empty( $alchemists_data['color-dark-lighten'] ) ) ? $alchemists_data['color-dark-lighten'] : $colors['color_dark_lighten'];
	$vars['color-gray'] = ( isset( $alchemists_data['color-gray'] ) && !empty( $alchemists_data['color-gray'] ) ) ? $alchemists_data['color-gray'] : $colors['color_gray'];
	$vars['color-2'] = ( isset( $alchemists_data['color-2'] ) && !empty( $alchemists_data['color-2'] ) ) ? $alchemists_data['color-2'] : $colors['color_2'];
	$vars['color-3'] = ( isset( $alchemists_data['color-3'] ) && !empty( $alchemists_data['color-3'] ) ) ? $alchemists_data['color-3'] : $colors['color_3'];
	$vars['color-4'] = ( isset( $alchemists_data['color-4'] ) && !empty( $alchemists_data['color-4'] ) ) ? $alchemists_data['color-4'] : $colors['color_4'];

	if ( alchemists_sp_preset('soccer') ) {
		$vars['color-4-darken'] = ( isset( $alchemists_data['color-4-darken'] ) && !empty( $alchemists_data['color-4-darken'] ) ) ? $alchemists_data['color-4-darken'] : $colors['color_4_darken'];
	}

	// Header Primary Height
	$vars['nav-height'] = ( isset( $alchemists_data['alchemists__header-primary-height'] ) && !empty( $alchemists_data['alchemists__header-primary-height'] )) ? $alchemists_data['alchemists__header-primary-height'] . 'px' : '62px';

	// Mobile Nav Width
	$vars['nav-mobile-width'] = ( isset( $alchemists_data['alchemists__mobile-nav-width'] ) && !empty( $alchemists_data['alchemists__mobile-nav-width'] )) ? $alchemists_data['alchemists__mobile-nav-width'] . 'px' : '270px';

	// Body Background
	$vars['body-bg-color'] = ( isset( $alchemists_data['alchemists__body-bg']['background-color'] ) && !empty( $alchemists_data['alchemists__body-bg']['background-color'] )) ? $alchemists_data['alchemists__body-bg']['background-color'] : '#edeff4';

	// Links Color
	$vars['link-color'] = ( isset( $alchemists_data['alchemists__link-color']['regular'] ) && !empty( $alchemists_data['alchemists__link-color']['regular'] )) ? $alchemists_data['alchemists__link-color']['regular'] : $vars['color-primary-darken'];
	$vars['link-color-hover'] = ( isset( $alchemists_data['alchemists__link-color']['hover'] ) && !empty( $alchemists_data['alchemists__link-color']['hover'] )) ? $alchemists_data['alchemists__link-color']['hover'] : $vars['color-primary'];

	// Top Bar
	$vars['header-top-bg'] = ( isset( $alchemists_data['alchemists__header-top-bar-bg'] ) && !empty( $alchemists_data['alchemists__header-top-bar-bg'] ) ) ? $alchemists_data['alchemists__header-top-bar-bg'] : $vars['color-dark-lighten'];
	$vars['top-bar-highlight'] = ( isset( $alchemists_data['alchemists__header-top-bar-highlight'] ) && !empty( $alchemists_data['alchemists__header-top-bar-highlight'] ) ) ? $alchemists_data['alchemists__header-top-bar-highlight'] : $vars['color-primary'];
	$vars['top-bar-text-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-text-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-text-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-text-color'] : '#6b6d70';
	$vars['top-bar-divider-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-divider-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-divider-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-divider-color'] : $vars['top-bar-text-color'];

	// Header Background
	$vars['header-bg'] = ( isset( $alchemists_data['alchemists__header-secondary-bg'] ) && !empty( $alchemists_data['alchemists__header-secondary-bg'] ) ) ? $alchemists_data['alchemists__header-secondary-bg'] : $vars['color-dark'];
	$vars['header-secondary-bg'] = ( isset( $alchemists_data['alchemists__header-secondary-bg'] ) && !empty( $alchemists_data['alchemists__header-secondary-bg'] ) ) ? $alchemists_data['alchemists__header-secondary-bg'] : $vars['color-dark'];
	$vars['header-primary-bg'] = ( isset( $alchemists_data['alchemists__header-primary-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-bg'] ) )  ? $alchemists_data['alchemists__header-primary-bg'] : $vars['color-dark-lighten'];

	// Header Primary Links Color
	$vars['nav-font-color'] = ( isset( $alchemists_data['alchemists__header-primary-font-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-font-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-font-color']['regular'] : '#fff';

	if ( alchemists_sp_preset('soccer') ) {
		$vars['nav-font-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-font-color']['hover'] : '#fff';
	} else {
		$vars['nav-font-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-font-color']['hover'] : $vars['color-primary'];
	}

	// Header Primary Link Border Color
	$vars['nav-active-border-color'] = ( isset( $alchemists_data['alchemists__header-primary-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-border-color'] : $vars['color-primary'];


	if ( alchemists_sp_preset('soccer')) {
		// Header Primary Link Border Height
		$vars['nav-active-border-height'] = ( isset( $alchemists_data['alchemists__header-primary-border-height']['height'] ) && !empty( $alchemists_data['alchemists__header-primary-border-height']['height'] ) )  ? $alchemists_data['alchemists__header-primary-border-height']['height'] : '100%';

		// Header Submenu Background Color
		$vars['nav-sub-bg'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-bg'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-bg'] : $vars['color-dark'];

		// Header Submenu Border Color
		$vars['nav-sub-border-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-border-color'] : '#292c31';

		// Header Submenu Link Color
		$vars['nav-sub-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] : '#fff';
		$vars['nav-sub-hover-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] : $vars['color-4'];

		// Megamenu Link Color
		$vars['nav-sub-megamenu-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] : '#78797C';
		$vars['nav-sub-megamenu-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] : '#fff';

		// Megamenu Title Color
		$vars['nav-sub-megamenu-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-title-color'] : '#fff';
	
		// Megamenu Post Title Color
		$vars['nav-sub-megamenu-post-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] : '#fff';

	} else {

		// Header Primary Link Border Height
		$vars['nav-active-border-height'] = ( isset( $alchemists_data['alchemists__header-primary-border-height']['height'] ) && !empty( $alchemists_data['alchemists__header-primary-border-height']['height'] ) )  ? $alchemists_data['alchemists__header-primary-border-height']['height'] : '2px';

		// Header Submenu Background Color
		$vars['nav-sub-bg'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-bg'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-bg'] : '#fff';

		// Header Submenu Border Color
		$vars['nav-sub-border-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-border-color'] : '#e4e7ed';

		// Header Submenu Link Color
		$vars['nav-sub-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] : $vars['color-2'];
		$vars['nav-sub-hover-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] : $vars['color-2'];

		// Megamenu Link Color
		$vars['nav-sub-megamenu-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] : '#adb3b7';
		$vars['nav-sub-megamenu-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] : $vars['color-2'];

		// Megamenu Title Color
		$vars['nav-sub-megamenu-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-title-color'] : $vars['color-2'];
		
		// Megamenu Post Title Color
		$vars['nav-sub-megamenu-post-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] : $vars['color-2'];
	}
	

	// Mobile Nav Background Color
	$vars['nav-mobile-bg'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-nav-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-nav-bg'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-nav-bg'] : $vars['color-dark'];

	// Mobile Nav Links Color
	$vars['nav-mobile-color'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-link-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-link-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-link-color'] : '#fff';

	// Mobile Nav Links Color
	$vars['nav-mobile-border'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-border-color'] : $vars['color-dark-lighten'];

	// Mobile Nav Submenu Background Color
	$vars['nav-mobile-sub-bg'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-sub-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-sub-bg'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-sub-bg'] : $vars['color-dark-lighten'];

	// Mobile Nav Submenu Links Color
	$vars['nav-mobile-sub-color'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] : $vars['color-gray'];



	// Header Info Block
	if ( alchemists_sp_preset('soccer')) {
		$vars['header-info-block-color'] = ( isset( $alchemists_data['alchemists__header-info-block-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-color'] ) )  ? $alchemists_data['alchemists__header-info-block-color'] : $vars['color-4'];
		
		$vars['header-info-block-cart-sum-color'] = ( isset( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) )  ? $alchemists_data['alchemists__header-info-block-cart-sum-color'] : $vars['color-4'];
	} else {
		$vars['header-info-block-color'] = ( isset( $alchemists_data['alchemists__header-info-block-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-color'] ) )  ? $alchemists_data['alchemists__header-info-block-color'] : $vars['color-primary'];

		$vars['header-info-block-cart-sum-color'] = ( isset( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) )  ? $alchemists_data['alchemists__header-info-block-cart-sum-color'] : $vars['color-primary'];
	}

	$vars['header-info-block-title-color'] = ( isset( $alchemists_data['alchemists__header-info-block-title-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-title-color'] ) )  ? $alchemists_data['alchemists__header-info-block-title-color'] : '#fff';

	$vars['header-info-block-cart-sum-color-mobile'] = ( isset( $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] ) && !empty( $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] ) )  ? $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] : $vars['color-primary'];

	$vars['header-info-block-link-color'] = ( isset( $alchemists_data['alchemists__header-info-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-info-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-info-link-color']['regular'] : '#6b6d70';

	$vars['header-info-block-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-info-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-info-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-info-link-color']['hover'] : '#fff';

	$vars['header-info-block-link-color-mobile'] = ( isset( $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] ) && !empty( $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] ) )  ? $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] : '#6b6d70';
	$vars['header-info-block-link-color-mobile-hover'] = ( isset( $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] ) && !empty( $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] ) )  ? $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] : '#fff';

	// Blog Categories Group 1
	$vars['post-category-1'] = ( isset( $alchemists_data['alchemists__blog-cat-group-1'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-1'] ) )  ? $alchemists_data['alchemists__blog-cat-group-1'] : $vars['color-primary-darken'];
	// Blog Categories Group 2
	$vars['post-category-2'] = ( isset( $alchemists_data['alchemists__blog-cat-group-2'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-2'] ) )  ? $alchemists_data['alchemists__blog-cat-group-2'] : $vars['color-4'];
	// Blog Categories Group 3
	$vars['post-category-3'] = ( isset( $alchemists_data['alchemists__blog-cat-group-3'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-3'] ) )  ? $alchemists_data['alchemists__blog-cat-group-3'] : $vars['color-3'];

	// Footer Background
	$vars['footer-widgets-bg'] = ( isset( $alchemists_data['alchemists__footer-widgets-bg']['background-color'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg']['background-color'] )) ? $alchemists_data['alchemists__footer-widgets-bg']['background-color'] : $vars['color-dark'];

	if ( alchemists_sp_preset('soccer') ) {
		$vars['footer-secondary-bg'] = ( isset( $alchemists_data['alchemists__footer-secondary-bg'] ) && !empty( $alchemists_data['alchemists__footer-secondary-bg'] ) ) ? $alchemists_data['alchemists__footer-secondary-bg'] : '#16171a';
	} else {
		$vars['footer-secondary-bg'] = ( isset( $alchemists_data['alchemists__footer-secondary-bg'] ) && !empty( $alchemists_data['alchemists__footer-secondary-bg'] ) ) ? $alchemists_data['alchemists__footer-secondary-bg'] : $vars['color-dark'];
	}
	
	$vars['footer-secondary-side-bg'] = ( isset( $alchemists_data['alchemists__footer-side-decoration-bg'] ) && !empty( $alchemists_data['alchemists__footer-side-decoration-bg'] ) ) ? $alchemists_data['alchemists__footer-side-decoration-bg'] : $vars['color-primary'];


	// Typography

	// Body
	if ( $alchemists_data['alchemists__custom_body_font'] ) {
		$vars['font-family-base'] = ( isset( $alchemists_data['alchemists__typography-body']['font-family'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-family'] ) ) ? $alchemists_data['alchemists__typography-body']['font-family'] : 'Source Sans Pro, sans-serif';
		$vars['base-font-size'] = ( isset( $alchemists_data['alchemists__typography-body']['font-size'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-size'] ) ) ? $alchemists_data['alchemists__typography-body']['font-size'] : '15px';
		$vars['base-line-height'] = ( isset( $alchemists_data['alchemists__typography-body']['line-height'] ) && !empty( $alchemists_data['alchemists__typography-body']['line-height'] ) ) ? $alchemists_data['alchemists__typography-body']['line-height'] : '26px';
		$vars['body-font-weight'] = ( isset( $alchemists_data['alchemists__typography-body']['font-weight'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-weight'] ) ) ? $alchemists_data['alchemists__typography-body']['font-weight'] : '400';
		$vars['body-font-color'] = ( isset( $alchemists_data['alchemists__typography-body']['color'] ) && !empty( $alchemists_data['alchemists__typography-body']['color'] ) ) ? $alchemists_data['alchemists__typography-body']['color'] : '#9a9da2';
	}


	if ( $alchemists_data['alchemists__custom_heading_font'] ) {

		// Font Family Accent
		$vars['font-family-accent'] = ( isset( $alchemists_data['font-family-accent']['font-family'] ) && !empty( $alchemists_data['font-family-accent']['font-family'] ) ) ? $alchemists_data['font-family-accent']['font-family'] : 'Montserrat';

		// Headings
		$vars['headings-font-family'] = ( isset( $alchemists_data['headings-typography']['font-family'] ) && !empty( $alchemists_data['headings-typography']['font-family'] ) ) ? $alchemists_data['headings-typography']['font-family'] : 'Montserrat';
		$vars['headings-color'] = ( isset( $alchemists_data['headings-typography']['color'] ) && !empty( $alchemists_data['headings-typography']['color'] ) ) ? $alchemists_data['headings-typography']['color'] : '#31404b';
	}

	// Navigation
	if ( $alchemists_data['alchemists__custom_nav-font'] ) {
		$vars['nav-font-family'] = ( isset( $alchemists_data['alchemists__nav-font']['font-family'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-family'] ) ) ? $alchemists_data['alchemists__nav-font']['font-family'] : 'Montserrat, sans-serif';
		$vars['nav-text-transform'] = ( isset( $alchemists_data['alchemists__nav-font']['text-transform'] ) && !empty( $alchemists_data['alchemists__nav-font']['text-transform'] ) ) ? $alchemists_data['alchemists__nav-font']['text-transform'] : 'uppercase';
		$vars['nav-font-weight'] = ( isset( $alchemists_data['alchemists__nav-font']['font-weight'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-weight'] ) ) ? $alchemists_data['alchemists__nav-font']['font-weight'] : '700';
		$vars['nav-font-style'] = ( isset( $alchemists_data['alchemists__nav-font']['font-style'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-style'] ) ) ? $alchemists_data['alchemists__nav-font']['font-style'] : 'normal';
		$vars['nav-font-size'] = ( isset( $alchemists_data['alchemists__nav-font']['font-size'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-size'] ) ) ? $alchemists_data['alchemists__nav-font']['font-size'] : '12px';

		$vars['nav-sub-font-family'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-family'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-family'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-family'] : 'Montserrat, sans-serif';
		$vars['nav-sub-text-transform'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['text-transform'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['text-transform'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['text-transform'] : 'uppercase';
		$vars['nav-sub-font-weight'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-weight'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-weight'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-weight'] : '700';
		$vars['nav-sub-font-style'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-style'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-style'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-style'] : 'normal';
		$vars['nav-sub-font-size'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-size'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-size'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-size'] : '12px';
	}


	// Preloader
	if ( $alchemists_data['alchemists__opt-custom_pageloader'] ) {

		$vars['preloader-bg'] = ( isset( $alchemists_data['alchemists__opt-preloader-bg'] ) && !empty( $alchemists_data['alchemists__opt-preloader-bg'] ) ) ? $alchemists_data['alchemists__opt-preloader-bg'] : $vars['color-dark'];
		$vars['preloader-size'] = ( isset( $alchemists_data['alchemists__opt-preloader-size']['width'] ) && !empty( $alchemists_data['alchemists__opt-preloader-size']['width'] ) ) ? $alchemists_data['alchemists__opt-preloader-size']['width'] : '32px';
		$vars['preloader-color'] = ( isset( $alchemists_data['alchemists__opt-preloader-color'] ) && !empty( $alchemists_data['alchemists__opt-preloader-color'] ) ) ? $alchemists_data['alchemists__opt-preloader-color'] : $vars['color-primary'];
		$vars['preloader-color-secondary'] = ( isset( $alchemists_data['alchemists__opt-preloader-color-secondary'] ) && !empty( $alchemists_data['alchemists__opt-preloader-color-secondary'] ) ) ? $alchemists_data['alchemists__opt-preloader-color-secondary'] : 'rgba(255,255,255, 0.15)';
		$vars['preloader-spin-duration'] = ( isset( $alchemists_data['alchemists__opt-preloader-spin-duration'] ) && !empty( $alchemists_data['alchemists__opt-preloader-spin-duration'] ) ) ? $alchemists_data['alchemists__opt-preloader-spin-duration'] . 's' : '0.8s';
	}

	return $vars;
}