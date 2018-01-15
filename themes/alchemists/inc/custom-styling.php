<?php

/**
 * Output Custom Styling from Redux Theme Options
 */

function alchemists_custom_styling() {

	$alchemists_data = get_option('alchemists_data');
	$output = '';

	/**
	 * Logo Width
	 */
  $logo_width  = isset( $alchemists_data['alchemists__opt-logo-width']['width'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-width']['width'] ) : '';

	if ( !empty( $logo_width ) ) {
		$output    .= '.header-logo__img {max-width:' . $logo_width . '; width:' . $logo_width . ';}';
	}

	/**
	 * Logo Width on Mobile devices
	 */
  $logo_width_mobile  = isset( $alchemists_data['alchemists__opt-logo-width-mobile']['width'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-width-mobile']['width'] ) : '';

	if ( !empty( $logo_width_mobile ) ) {
		$output    .= '@media (max-width: 991px) {';
			$output    .= '.header-mobile__logo-img {max-width:' . $logo_width_mobile . '; width:' . $logo_width_mobile . ';}';
		$output    .= '}';
  }


  /**
	 * Logo Position Adjustments
   */
  $logo_position_on  = isset( $alchemists_data['alchemists__opt-logo-position'] ) ? $alchemists_data['alchemists__opt-logo-position'] : 0;
	if ( $logo_position_on ) {

    $logo_position_desktop_ver = ! empty( $alchemists_data['alchemists__opt-logo-position-desktop']['bottom'] ) ? $alchemists_data['alchemists__opt-logo-position-desktop']['bottom'] : 0;
    $logo_position_desktop_hor = ! empty( $alchemists_data['alchemists__opt-logo-position-desktop']['right'] ) ? $alchemists_data['alchemists__opt-logo-position-desktop']['right'] : 0;

    $logo_position_mobile_ver = ! empty( $alchemists_data['alchemists__opt-logo-position-mobile']['bottom'] ) ? $alchemists_data['alchemists__opt-logo-position-mobile']['bottom'] : 0;
    $logo_position_mobile_hor = ! empty( $alchemists_data['alchemists__opt-logo-position-mobile']['right'] ) ? $alchemists_data['alchemists__opt-logo-position-mobile']['right'] : 0;

    $output    .= '.header-logo { ';
      $output    .=  '-webkit-transform: translate(' . $logo_position_desktop_hor .  ', ' . $logo_position_desktop_ver . '); transform: translate(' . $logo_position_desktop_hor .  ', ' . $logo_position_desktop_ver . ');';
    $output    .= '}';

    $output    .= '@media (max-width: 991px) {';
      $output    .= '.header-mobile__logo {';
        $output    .=  'margin-left: ' . $logo_position_mobile_hor .  '; margin-top: ' . $logo_position_mobile_ver .  ';';
      $output    .= '}';
    $output    .= '}';
  }


	/**
	 * Header Paddings
	 */
	if ( $alchemists_data['alchemists__opt-page-title-spacing-on'] == 1) {

		$page_heading_padding_desktop = $alchemists_data['alchemists__opt-page-title-spacing-desktop'];
		$page_heading_padding_tablet  = $alchemists_data['alchemists__opt-page-title-spacing-tablet'];
		$page_heading_padding_mobile  = $alchemists_data['alchemists__opt-page-title-spacing-mobile'];

		$output    .= '.page-heading { padding-top:' . $page_heading_padding_mobile['padding-top'] . '; padding-bottom:' . $page_heading_padding_mobile['padding-bottom'] . '}';

		$output    .= '@media (min-width: 768px) {';
			$output    .= '.page-heading { padding-top:' . $page_heading_padding_tablet['padding-top'] . '; padding-bottom:' . $page_heading_padding_tablet['padding-bottom'] . '}';
		$output    .= '}';

		$output    .= '@media (min-width: 992px) {';
			$output    .= '.page-heading { padding-top:' . $page_heading_padding_desktop['padding-top'] . '; padding-bottom:' . $page_heading_padding_desktop['padding-bottom'] . '}';
		$output    .= '}';
	}


	/**
	 * Breadcrumbs Separator
	 */
	$breadcrumbs = $alchemists_data['alchemists__opt-page-title-breadcrumbs'];
	$breadcrumbs_custom_color = $alchemists_data['alchemists__custom_breadcrumbs'];

	if ( $breadcrumbs == 1 && $breadcrumbs_custom_color == 1 ) {
		$output .= '.page-heading ul.trail-items>li::after { color: ' . $alchemists_data['alchemists__opt-page-title-breadcrumbs-sep-color'] . '}';
	}


	/**
	 * Hero Unit height (mobile)
	 */

	if ( isset( $alchemists_data['alchemists__opt-page-heading-hero-height-sm']) and is_array( $alchemists_data['alchemists__opt-page-heading-hero-height-sm'] )) {
		$hero_height_sm = $alchemists_data['alchemists__opt-page-heading-hero-height-sm']['height'];

		// var_dump($hero_height_sm);

		if ( !empty( $hero_height_sm ) and $hero_height_sm != 'px' ) {
			$output    .= '.hero-unit__container { height:' . $hero_height_sm . ';}';
		}
	}


	/**
	 * Hero Unit height
	 */

	if ( isset( $alchemists_data['alchemists__opt-page-heading-hero-height']) and is_array( $alchemists_data['alchemists__opt-page-heading-hero-height'] )) {
		$hero_height = $alchemists_data['alchemists__opt-page-heading-hero-height']['height'];

		if ( !empty( $hero_height ) and $hero_height != 'px' ) {
			$output    .= '@media (min-width: 1200px) {';
				$output    .= '.hero-unit__container { height:' . $hero_height . ';}';
			$output    .= '}';
		}
  }


  /**
	 * Hero Unit - Posts Slider height
	 */
  $hero_posts_slider_height  = isset( $alchemists_data['alchemists__hero-posts-height'] ) ? $alchemists_data['alchemists__hero-posts-height'] : 0;
	if ( $hero_posts_slider_height ) {

    $hero_posts_slider_height_lg  = isset( $alchemists_data['alchemists__hero-posts-height-desktop']['height'] ) ? $alchemists_data['alchemists__hero-posts-height-desktop']['height'] : '';
    $hero_posts_slider_height_md  = isset( $alchemists_data['alchemists__hero-posts-height-tablet-landscape']['height'] ) ? $alchemists_data['alchemists__hero-posts-height-tablet-landscape']['height'] : '';
    $hero_posts_slider_height_sm  = isset( $alchemists_data['alchemists__hero-posts-height-tablet-portrait']['height'] ) ? $alchemists_data['alchemists__hero-posts-height-tablet-portrait']['height'] : '';
    $hero_posts_slider_height_xs  = isset( $alchemists_data['alchemists__hero-posts-height-mobile']['height'] ) ? $alchemists_data['alchemists__hero-posts-height-mobile']['height'] : '';

    if ( $hero_posts_slider_height_xs ) {
		  $output    .= '.hero-slider, .hero-slider__item { height:' . $hero_posts_slider_height_xs . ';}';
    }

    if ( $hero_posts_slider_height_sm ) {
			$output    .= '@media (min-width: 768px) {';
				$output    .= '.hero-slider, .hero-slider__item { height:' . $hero_posts_slider_height_sm . ';}';
			$output    .= '}';
    }

    if ( $hero_posts_slider_height_md ) {
			$output    .= '@media (min-width: 992px) {';
				$output    .= '.hero-slider, .hero-slider__item { height:' . $hero_posts_slider_height_md . ';}';
			$output    .= '}';
    }

		if ( $hero_posts_slider_height_lg ) {
			$output    .= '@media (min-width: 1200px) {';
				$output    .= '.hero-slider, .hero-slider__item { height:' . $hero_posts_slider_height_lg . ';}';
			$output    .= '}';
		}
  }


  /**
	 * Content Paddings
   */
  $content_padding_on  = isset( $alchemists_data['alchemists__opt-content-padding-on'] ) ? $alchemists_data['alchemists__opt-content-padding-on'] : 0;
	if ( $content_padding_on == 1) {

    $content_padding_desktop = $alchemists_data['alchemists__opt-content-padding-desktop'];
    $content_padding_tablet  = $alchemists_data['alchemists__opt-content-padding-tablet'];
    $content_padding_mobile  = $alchemists_data['alchemists__opt-content-padding-mobile'];

    $output    .= '.site-content { padding-top:' . $content_padding_mobile['padding-top'] . '; padding-bottom:' . $content_padding_mobile['padding-bottom'] . '}';

    $output    .= '@media (min-width: 768px) {';
      $output    .= '.site-content { padding-top:' . $content_padding_tablet['padding-top'] . '; padding-bottom:' . $content_padding_tablet['padding-bottom'] . '}';
    $output    .= '}';

    $output    .= '@media (min-width: 992px) {';
      $output    .= '.site-content { padding-top:' . $content_padding_desktop['padding-top'] . '; padding-bottom:' . $content_padding_desktop['padding-bottom'] . '}';
    $output    .= '}';
  }


  /**
	 * Custom CSS
	 */
	if ( isset( $alchemists_data['alchemists__custom-css'] ) ) {
		$custom_css = $alchemists_data['alchemists__custom-css'];
		if ($custom_css <> '') {
			$output .= $custom_css . "\n";
		}
	}


	/**
	 * Output
	 */
	if ($output <> '') {
		$output = "<!-- Dynamic CSS--><style type=\"text/css\">\n" . $output . "</style>\n";
		echo !empty( $output ) ? $output : '';
	}
}

add_action('wp_head', 'alchemists_custom_styling');
