<?php
/**
 * Sportspress Global Functions
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @version   1.1.0
 */

/**
 * SportsPress Presets
 */

// Sets custom 'alchemists_current_sport_preset' option based on 'sportspress_sport'
if ( ! function_exists( 'alchemists_sp_current_sport_preset' ) ) {
  function alchemists_sp_current_sport_preset() {
    $current_sport = get_option( 'sportspress_sport', 'basketball' );
    if ( 'none' == $current_sport  ) {
      $current_sport = 'basketball';
    }
    update_option( 'alchemists_current_sport_preset', $current_sport );
  }
  add_action( 'sportspress_init', 'alchemists_sp_current_sport_preset' );
}


// Adds args depends on current preset
if ( ! function_exists( 'alchemists_sp_preset_options' ) ) {
  function alchemists_sp_preset_options() {

    $current_theme_preset = get_option( 'alchemists_current_sport_preset', 'basketball' );

    if ( $current_theme_preset == 'soccer' ) {
      $preset     = 'soccer';
      $body_class = 'template-soccer';
    } else {
      $preset     = 'basketball';
      $body_class = 'template-basketball';
    }

    $args = array(
      'preset'     => $preset,
      'body_class' => $body_class
    );

    return $args;
  }
}


// Checks what preset is active
if ( ! function_exists( 'alchemists_sp_preset' ) ) {
  function alchemists_sp_preset( $preset_slug ) {
    $args = alchemists_sp_preset_options();
    return ( $args['preset'] == $preset_slug ) ? true : false;
  }
}


// Adds class to body depends on active preset
if ( ! function_exists( 'alchemists_preset_body_class' ) ) {
	function alchemists_preset_body_class( $classes ) {
		$args = alchemists_sp_preset_options();
		$classes[] = $args['body_class'];
		return $classes;
	}
	add_filter( 'body_class', 'alchemists_preset_body_class' );
}
