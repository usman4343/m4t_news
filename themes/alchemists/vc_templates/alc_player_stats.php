<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $player_id
 * @var $style_type
 * @var $customize_primary_stats
 * @var $values_primary
 * @var $display_detailed_stats
 * @var $display_detailed_stats_secondary
 * @var $customize_detailed_stats
 * @var $customize_detailed_stats_secondary
 * @var $values
 * @var $values_equation
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Alc_Player_Stats
 */

// Theme Options
$alchemists_data = get_option('alchemists_data');
$color_primary = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';

$title = $player_id = $style_type = $customize_primary_stats = $display_detailed_stats_secondary = $values_primary = $display_detailed_stats = $customize_detailed_stats_secondary = $customize_detailed_stats = $values = $values_equation = $el_class = $el_id = $css = $css_animation = '';

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'widget card widget-player';
if ( $style_type == 'style_2' ) {
	$style_type = ' widget-player--alt';
	$class_to_filter .= $style_type;
}

if ( alchemists_sp_preset( 'soccer') ) {
	$class_to_filter .= ' widget-player--soccer';
}

$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

// Customized Statistics (primary - numbers)
$values_primary = (array) vc_param_group_parse_atts( $values_primary );
$values_primary_array = array();
foreach ($values_primary as $value) {
	$custom_stat = $value;
	$custom_stat['stat_heading']    = isset( $value['stat_heading'] ) ? $value['stat_heading'] : '';
	$custom_stat['stat_subheading'] = isset( $value['stat_subheading'] ) ? $value['stat_subheading'] : '';
	$custom_stat['stat_value']      = isset( $value['stat_value'] ) ? $value['stat_value'] : '';

	$values_primary_array[] = $custom_stat;
}

// Customized Statistics (numbers)
$values = (array) vc_param_group_parse_atts( $values );
$values_array = array();
foreach ($values as $value) {
	$custom_stat = $value;
	$custom_stat['stat_heading']    = isset( $value['stat_heading'] ) ? $value['stat_heading'] : '';
	$custom_stat['stat_subheading'] = isset( $value['stat_subheading'] ) ? $value['stat_subheading'] : '';
	$custom_stat['stat_value']      = isset( $value['stat_value'] ) ? $value['stat_value'] : '';

	$values_array[] = $custom_stat;
}

// Customized Statistics (equation)
$values_equation = (array) vc_param_group_parse_atts( $values_equation );
$values_equation_array = array();
foreach ($values_equation as $value) {
	$custom_stat = $value;
	$custom_stat['stat_heading']    = isset( $value['stat_heading'] ) ? $value['stat_heading'] : '';
	$custom_stat['stat_value']      = isset( $value['stat_value'] ) ? $value['stat_value'] : '';

	$values_equation_array[] = $custom_stat;
}


// Check if we're on Single Team page and Team is not selected
if ( is_singular('sp_player') && $player_id == 'default' ) {
	if ( ! isset( $id ) ) {
		$id = get_the_ID();
	}
} else {
	$id = intval( $player_id );
}


$player = new SP_Player( $id );
$data = $player->data( 0, false );

// Remove the first row to leave us with the actual data
unset( $data[0] );

// Get Total array
$data = $data[-1];

if ( $style_type != 'style_hide_banner' ) {
	// Player Image (Alt)
	$player_image_head  = get_field('heading_player_photo', $id);
	$player_image_size  = 'alchemists_thumbnail-player-sm';
	if( $player_image_head ) {
		$image_url = wp_get_attachment_image( $player_image_head, $player_image_size );
	} else {
		$image_url = '<img src="' . get_template_directory_uri() . '/assets/images/player-single-placeholder-189x198.png' . '" alt="" />';
	}
}


if ( alchemists_sp_preset( 'soccer' ) ) :

// ======================== Soccer

// Player Banner Data
if ( $style_type != 'style_hide_banner' ) : // if requested

	// Player Team Logo
	$sp_current_teams = get_post_meta($id,'sp_current_team');
	$sp_current_team = '';
	if( !empty($sp_current_teams[0]) ) {
		$sp_current_team = $sp_current_teams[0];
	}

	// Player Name
	$player_name = $player->post->post_title;
	$player_url  = get_the_permalink( $id );

	// Player Number
	$player_number = get_post_meta( $id, 'sp_number', true );

	// Player Position(s)
	$positions = wp_get_post_terms( $id, 'sp_position');
	$position = false;
	if( $positions ) {
		$position = $positions[0]->name;
	}

	// Player Stats - numbers
	$goals       = isset( $data['goals'] ) ? $data['goals'] : esc_html__( 'n/a', 'alchemists' );
	$shots       = isset( $data['sh'] ) ? $data['sh'] : esc_html__( 'n/a', 'alchemists' );
	$assists     = isset( $data['assists'] ) ? $data['assists'] : esc_html__( 'n/a', 'alchemists' );
	$appearances = isset( $data['appearances'] ) ? $data['appearances'] : esc_html__( 'n/a', 'alchemists' );

	$stats_primary_default_array = array(
		'goals'       => esc_html__( 'Goals', 'alchemists' ),
		'shots'       => esc_html__( 'Shots', 'alchemists' ),
		'assists'     => esc_html__( 'Assists', 'alchemists' ),
		'appearances' => esc_html__( 'Games', 'alchemists' ),
	);

	// Secondary Performances
	if ( $display_detailed_stats_secondary ) {
		// bars
		$shpercent   = isset( $data['shpercent'] ) ? $data['shpercent'] : '';
		$passpercent = isset( $data['passpercent'] ) ? $data['passpercent'] : '';

		// Equation Stats - predefined
		$equation_default_array = array(
			'shpercent'   => esc_html__( 'SHOT ACC', 'alchemists' ),
			'passpercent' => esc_html__( 'PASS ACC', 'alchemists' ),
		);
	}

endif;


// Player Detailed Stats
if ( $display_detailed_stats ) : // if requested
	$goals       = isset( $data['goals'] ) ? $data['goals'] : esc_html__( 'n/a', 'alchemists' );
	$shots       = isset( $data['sh'] ) ? $data['sh'] : esc_html__( 'n/a', 'alchemists' );
	$assists     = isset( $data['assists'] ) ? $data['assists'] : esc_html__( 'n/a', 'alchemists' );
	$appearances = isset( $data['appearances'] ) ? $data['appearances'] : esc_html__( 'n/a', 'alchemists' );
	$yellowcards     = isset( $data['yellowcards'] ) ? $data['yellowcards'] : esc_html__( 'n/a', 'alchemists' );
	$redcards        = isset( $data['redcards'] ) ? $data['redcards'] : esc_html__( 'n/a', 'alchemists' );
	$shots_on_target = isset( $data['sog'] ) ? $data['sog'] : esc_html__( 'n/a', 'alchemists' );
	$pka             = isset( $data['pka'] ) ? $data['pka'] : esc_html__( 'n/a', 'alchemists' );
	$pkg             = isset( $data['pkg'] ) ? $data['pkg'] : esc_html__( 'n/a', 'alchemists' );
	$drb             = isset( $data['drb'] ) ? $data['drb'] : esc_html__( 'n/a', 'alchemists' );
	$fouls           = isset( $data['f'] ) ? $data['f'] : esc_html__( 'n/a', 'alchemists' );
	$off             = isset( $data['off'] ) ? $data['off'] : esc_html__( 'n/a', 'alchemists' );
endif;

// Detailed Stats - predefined
$stats_default_array = array(
	'goals'           => esc_html__( 'Goals', 'alchemists' ),
	'assists'         => esc_html__( 'Assists', 'alchemists' ),
	'shots'           => esc_html__( 'Shots', 'alchemists' ),
	'shots_on_target' => esc_html__( 'Shots on Target', 'alchemists' ),
	'pka'             => esc_html__( 'P.Kick Attempts', 'alchemists' ),
	'pkg'             => esc_html__( 'P.Kick Goals', 'alchemists' ),
	'drb'             => esc_html__( 'Dribbles', 'alchemists' ),
	'fouls'           => esc_html__( 'Fouls', 'alchemists' ),
	'off'             => esc_html__( 'Offsides', 'alchemists' ),
	'appearances'     => esc_html__( 'Games Played', 'alchemists' ),
	'yellowcards'     => esc_html__( 'Yellow Cards', 'alchemists' ),
	'redcards'        => esc_html__( 'Red Cards', 'alchemists' ),
);

?>

<!-- Widget: Player Stats -->
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">
	<?php if ( $title ) { ?>
		<div class="widget__title card__header">
			<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>
		</div>
	<?php } ?>

	<?php if ( $style_type != 'style_hide_banner' ) : ?>
	<div class="widget-player__inner">

		<a href="<?php echo esc_url( $player_url ); ?>" class="widget-player__link-layer"></a>

		<div class="widget-player__ribbon">
			<div class="fa fa-star"></div>
		</div>

		<figure class="widget-player__photo">
			<?php echo wp_kses_post( $image_url ); ?>
		</figure>

		<header class="widget-player__header clearfix">
			<?php if (!empty( $player_number )) : ?>
			<div class="widget-player__number"><?php echo esc_html( $player_number ); ?></div>
			<?php endif; ?>

			<h4 class="widget-player__name">
				<?php echo wp_kses_post( $player_name ); ?>
			</h4>
		</header>

		<div class="widget-player__content">
			<div class="widget-player__content-inner">

				<?php if ( $customize_primary_stats ) : ?>
					<?php if ( !empty( $values_primary_array) ) : ?>
						<?php foreach ( $values_primary_array as $stat_primary_item ) : ?>
							<?php if ( !empty( $stat_primary_item ) ) : ?>
								<?php
									$statistics_primary = get_post( $stat_primary_item['stat_value'] );
									$statistic_primary = $statistics_primary->post_name;

									if ( isset( $data[$statistic_primary]) ) :

										// value
										$stat_primary_value = strip_tags( $data[$statistic_primary] );

										// heading
										$stat_primary_heading = $stat_primary_item['stat_heading']; ?>

									<div class="widget-player__stat">
										<div class="widget-player__stat-number"><?php echo esc_html( $stat_primary_value ); ?></div>
										<h6 class="widget-player__stat-label"><?php echo esc_html( $stat_primary_heading ); ?></h6>
									</div>

								<?php endif; ?>

							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php else : ?>

					<?php foreach( $stats_primary_default_array as $stat_primary_default_key => $stat_primary_default_value ) : ?>
						<div class="widget-player__stat">
							<div class="widget-player__stat-number"><?php echo ${"$stat_primary_default_key"}; ?></div>
							<h6 class="widget-player__stat-label"><?php echo esc_html( $stat_primary_default_value ); ?></h6>
						</div>
					<?php endforeach; ?>

				<?php endif; ?>
			</div>

			<?php if ( $display_detailed_stats_secondary ) : ?>
				<div class="widget-player__content-alt">

					<?php if ( $customize_detailed_stats_secondary ) : ?>

						<?php // Customized stats
						if ( !empty( $values_equation_array ) ) :
							foreach ( $values_equation_array as $stat_item ) :
								if ( !empty ( $stat_item['stat_value']) ) :

									$performances = get_post( $stat_item['stat_value'] );
									$performance = $performances->post_name;

									if ( isset( $data[$performance]) ) :

										// value
										$stat_value = strip_tags( $data[$performance] );

										// heading
										$stat_heading = $stat_item['stat_heading']; ?>

										<div class="progress-stats">
											<div class="progress__label"><?php echo esc_html( $stat_heading ); ?></div>
											<div class="progress">
												<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $stat_value ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $stat_value ); ?>%"></div>
											</div>
											<div class="progress__number"><?php echo esc_html( $stat_value ); ?>%</div>
										</div>

									<?php endif;
								endif;
							endforeach;
							wp_reset_postdata();
						endif; ?>

					<?php else : ?>
						<?php // Predefined stats
							foreach ( $equation_default_array as $equation_default_key => $equation_default_value ) : ?>

							<div class="progress-stats">
								<div class="progress__label"><?php echo esc_html( $equation_default_value ); ?></div>
								<div class="progress">
									<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( ${"$equation_default_key"} ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( ${"$equation_default_key"} ); ?>%"></div>
								</div>
								<div class="progress__number"><?php echo esc_html( ${"$equation_default_key"} ); ?>%</div>
							</div>

						<?php endforeach; ?>
					<?php endif; ?>

				</div>
			<?php endif; ?>

		</div>

	</div>
	<?php endif; ?>


	<?php if ( $display_detailed_stats ) : ?>
	<div class="widget__content-secondary">

		<!-- Player Details -->
		<div class="widget-player__details">

			<?php if ( $customize_detailed_stats ) : ?>

				<?php // Customized stats
				if ( !empty( $values_array ) ) :
					foreach ( $values_array as $stat_item ) :
						if ( !empty ( $stat_item['stat_value']) ) :

							$performances = get_post( $stat_item['stat_value'] );
							$performance = $performances->post_name;

							if ( isset( $data[$performance]) ) :

								// value
								$stat_value = strip_tags( $data[$performance] );

								// heading
								$stat_heading = $stat_item['stat_heading'];

								// subheading
								$stat_subheading = $stat_item['stat_subheading']; ?>

								<div class="widget-player__details__item">
									<div class="widget-player__details-desc-wrapper">
										<span class="widget-player__details-holder">
											<span class="widget-player__details-label"><?php echo esc_html( $stat_heading ); ?></span>
											<span class="widget-player__details-desc"><?php echo esc_html( $stat_subheading ); ?></span>
										</span>
										<span class="widget-player__details-value"><?php echo esc_html( $stat_value ); ?></span>
									</div>
								</div>

							<?php endif;
						endif;
					endforeach;
					wp_reset_postdata();
				endif; ?>

			<?php else : ?>

				<?php // Predefined stats
				foreach ( $stats_default_array as $stat_default_key => $stat_default_value ) : ?>

					<div class="widget-player__details__item">
						<div class="widget-player__details-desc-wrapper">
							<span class="widget-player__details-holder">
								<span class="widget-player__details-label"><?php echo esc_html( $stat_default_value ) ; ?></span>
								<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
							</span>
							<span class="widget-player__details-value"><?php echo ${"$stat_default_key"}; ?></span>
						</div>
					</div>

				<?php endforeach; ?>

			<?php endif; ?>

		</div>
		<!-- Player Details / End -->

	</div>

	<div class="widget__content-tertiary widget__content--bottom-decor">
		<div class="widget__content-inner"></div>
	</div>
	<?php endif; ?>

</div>
<!-- Widget: Player Stats / End -->


<?php else :


// ======================== Basketball

// Player Banner Data
if ( $style_type != 'style_hide_banner' ) : // if requested

	// Player Team Logo
	$sp_current_teams = get_post_meta($id,'sp_current_team');
	$sp_current_team = '';
	if( !empty($sp_current_teams[0]) ) {
		$sp_current_team = $sp_current_teams[0];
	}

	// Player Name
	$player_name = $player->post->post_title;
	$player_url  = get_the_permalink( $id );

	// Player Number
	$player_number = get_post_meta( $id, 'sp_number', true );

	// Player Position(s)
	$positions = wp_get_post_terms( $id, 'sp_position');
	$position = false;
	if( $positions ) {
		$position = $positions[0]->name;
	}

	// Player Stats
	$ppg = isset( $data['ppg'] ) ? esc_html( $data['ppg'] ) : esc_html__( 'n/a', 'alchemists' );
	$apg = isset( $data['apg'] ) ? esc_html( $data['apg'] ) : esc_html__( 'n/a', 'alchemists' );
	$rpg = isset( $data['rpg'] ) ? esc_html( $data['rpg'] ) : esc_html__( 'n/a', 'alchemists' );

	$stats_primary_default_array = array(
		'ppg' => esc_html__( 'Points', 'alchemists' ),
		'apg' => esc_html__( 'Assists', 'alchemists' ),
		'rpg' => esc_html__( 'Rebs', 'alchemists' ),
	);

endif;


// Player Detailed Stats
if ( $display_detailed_stats ) {
	$ast     = isset( $data['ast'] ) ? esc_html( $data['ast'] ) : esc_html__( 'n/a', 'alchemists' );
	$threepm = isset( $data['threepm'] ) ? esc_html( $data['threepm'] ) : esc_html__( 'n/a', 'alchemists' );
	$blk     = isset( $data['blk'] ) ? esc_html( $data['blk'] ) : esc_html__( 'n/a', 'alchemists' );
	$pf      = isset( $data['pf'] ) ? esc_html( $data['pf'] ) : esc_html__( 'n/a', 'alchemists' );
	$gp      = isset( $data['g'] ) ? esc_html( $data['g'] ) : esc_html__( 'n/a', 'alchemists' );
	$fgm     = isset( $data['fgm'] ) ? esc_html( $data['fgm'] ) : esc_html__( 'n/a', 'alchemists' );
	$def     = isset( $data['def'] ) ? esc_html( $data['def'] ) : esc_html__( 'n/a', 'alchemists' );
	$off     = isset( $data['off'] ) ? esc_html( $data['off'] ) : esc_html__( 'n/a', 'alchemists' );
	$stl     = isset( $data['stl'] ) ? esc_html( $data['stl'] ) : esc_html__( 'n/a', 'alchemists' );

	if ( is_numeric( $fgm ) && is_numeric( $threepm ) ) {
		$twopm = ( $fgm - $threepm );
	} else {
		$twopm = esc_html__( 'n/a', 'alchemists' );
	}

	if ( is_numeric( $def ) && is_numeric( $off ) ) {
		$rebs = ( $def + $off );
	} else {
		$rebs = esc_html__( 'n/a', 'alchemists' );
	}

	// Detailed Stats - predefined
	$stats_default_array = array(
		'twopm'   => esc_html__( '2 Points', 'alchemists' ),
		'threepm' => esc_html__( '3 Points', 'alchemists' ),
		'rebs'    => esc_html__( 'Rebounds', 'alchemists' ),
		'ast'     => esc_html__( 'Assists', 'alchemists' ),
		'stl'     => esc_html__( 'Steals', 'alchemists' ),
		'blk'     => esc_html__( 'Blocks', 'alchemists' ),
		'pf'      => esc_html__( 'Fouls', 'alchemists' ),
		'gp'      => esc_html__( 'Games Played', 'alchemists' ),
	);
}

// Secondary Performances
if ( $display_detailed_stats_secondary ) {
	$fgpercent     = isset( $data['fgpercent'] ) ? esc_html( $data['fgpercent'] ) : 0;
	$ftpercent     = isset( $data['ftpercent'] ) ? esc_html( $data['ftpercent'] ) : 0;
	$threeppercent = isset( $data['threeppercent'] ) ? esc_html( $data['threeppercent'] ) : 0;

	// Equation Stats - predefined
	$equation_default_array = array(
		'fgpercent'     => esc_html__( 'Field Goal Accuracy', 'alchemists' ),
		'ftpercent'     => esc_html__( 'Free Throw Accuracy', 'alchemists' ),
		'threeppercent' => esc_html__( '3 Points Accuracy', 'alchemists' ),
	);
}

?>

<!-- Widget: Player Stats -->
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">
	<?php if ( $title ) { ?>
		<div class="widget__title card__header">
			<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>
		</div>
	<?php } ?>

	<?php if ( $style_type != 'style_hide_banner' ) : ?>
	<div class="widget-player__inner">

		<a href="<?php echo esc_url( $player_url ); ?>" class="widget-player__link-layer"></a>

		<?php if( !empty( $sp_current_team ) ):
			$player_team_logo = alchemists_get_thumbnail_url( $sp_current_team, '0', 'full' );
			if( !empty($player_team_logo) ): ?>
				<div class="widget-player__team-logo">
					<img src="<?php echo esc_url( $player_team_logo ); ?>" alt="<?php esc_attr_e( 'Team Logo', 'alchemists' ); ?>" />
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<figure class="widget-player__photo">
			<?php echo wp_kses_post( $image_url ); ?>
		</figure>

		<header class="widget-player__header clearfix">
			<?php if (!empty( $player_number )) : ?>
			<div class="widget-player__number"><?php echo esc_html( $player_number ); ?></div>
			<?php endif; ?>

			<h4 class="widget-player__name">
				<?php echo wp_kses_post( $player_name ); ?>
			</h4>
		</header>

		<div class="widget-player__content">
			<div class="widget-player__content-inner">

				<?php if ( $customize_primary_stats ) : ?>
					<?php if ( !empty( $values_primary_array) ) : ?>
						<?php foreach ( $values_primary_array as $stat_primary_item ) : ?>
							<?php if ( !empty( $stat_primary_item ) ) : ?>
								<?php
									$statistics_primary = get_post( $stat_primary_item['stat_value'] );
									$statistic_primary = $statistics_primary->post_name;

									if ( isset( $data[$statistic_primary]) ) :

										// value
										$stat_primary_value = strip_tags( $data[$statistic_primary] );

										// heading
										$stat_primary_heading = $stat_primary_item['stat_heading'];

										// subheading
										$stat_primary_subheading = $stat_primary_item['stat_subheading']; ?>

									<div class="widget-player__stat">
										<h6 class="widget-player__stat-label"><?php echo esc_html( $stat_primary_heading ); ?></h6>
										<div class="widget-player__stat-number"><?php echo esc_html( $stat_primary_value ); ?></div>
										<div class="widget-player__stat-legend"><?php echo esc_html( $stat_primary_subheading ); ?></div>
									</div>
								<?php endif; ?>

							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php else : ?>

					<?php foreach( $stats_primary_default_array as $stat_primary_default_key => $stat_primary_default_value ) : ?>
						<div class="widget-player__stat">
							<h6 class="widget-player__stat-label"><?php echo esc_html( $stat_primary_default_value ); ?></h6>
							<div class="widget-player__stat-number"><?php echo ${"$stat_primary_default_key"}; ?></div>
							<div class="widget-player__stat-legend"><?php esc_html_e( 'AVG', 'alchemists' ); ?></div>
						</div>
					<?php endforeach; ?>

				<?php endif; ?>
			</div>
		</div>

		<?php if (!empty( $position )) : ?>
		<footer class="widget-player__footer">
			<span class="widget-player__footer-txt">
				<?php echo esc_html( $position ); ?>
			</span>
		</footer>
		<?php endif; ?>

	</div>
	<?php endif; ?>


	<?php if ( $display_detailed_stats ) : ?>
	<div class="widget__content-secondary">

		<!-- Player Details -->
		<div class="widget-player__details">

			<?php // Customized stats
			if ( $customize_detailed_stats ) :

				if ( !empty( $values_array ) ) :
					foreach ( $values_array as $stat_item ) :
						if ( !empty ( $stat_item['stat_value']) ) :

							$performances = get_post( $stat_item['stat_value'] );
							$performance = $performances->post_name;

							if ( isset( $data[$performance]) ) :

								// value
								$stat_value = strip_tags( $data[$performance] );

								// heading
								$stat_heading = $stat_item['stat_heading'];

								// subheading
								$stat_subheading = $stat_item['stat_subheading']; ?>

								<div class="widget-player__details__item">
									<div class="widget-player__details-desc-wrapper">
										<span class="widget-player__details-holder">
											<span class="widget-player__details-label"><?php echo esc_html( $stat_heading ); ?></span>
											<span class="widget-player__details-desc"><?php echo esc_html( $stat_subheading ); ?></span>
										</span>
										<span class="widget-player__details-value"><?php echo esc_html( $stat_value ); ?></span>
									</div>
								</div>

							<?php endif;
						endif;
					endforeach;
					wp_reset_postdata();
				endif; ?>

			<?php else : ?>

				<?php // Predefined stats
				foreach ( $stats_default_array as $stat_default_key => $stat_default_value ) : ?>

				<div class="widget-player__details__item">
					<div class="widget-player__details-desc-wrapper">
						<span class="widget-player__details-holder">
							<span class="widget-player__details-label"><?php echo esc_html( $stat_default_value ) ; ?></span>
							<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
						</span>
						<span class="widget-player__details-value"><?php echo ${"$stat_default_key"}; ?></span>
					</div>
				</div>

				<?php endforeach; ?>

			<?php endif; ?>

		</div>
		<!-- Player Details / End -->

	</div>
	<?php endif; ?>

	<?php if ( $display_detailed_stats_secondary ) : ?>
	<div class="widget__content-tertiary widget__content--bottom-decor">
		<div class="widget__content-inner">
			<div class="widget-player__stats row">

				<?php if ( $customize_detailed_stats_secondary ) :

					// Customized stats
					if ( !empty( $values_equation_array ) ) :
						foreach ( $values_equation_array as $stat_item ) :
							if ( !empty ( $stat_item['stat_value']) ) :

								$performances = get_post( $stat_item['stat_value'] );
								$performance = $performances->post_name;

								if ( isset( $data[$performance]) ) :

									// value
									$stat_value = strip_tags( $data[$performance] );

									// heading
									$stat_heading = $stat_item['stat_heading']; ?>

									<div class="col-xs-4">
										<div class="widget-player__stat-item">
											<div class="widget-player__stat-circular circular">
												<div class="circular__bar" data-percent="<?php echo esc_attr( $stat_value ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
													<span class="circular__percents"><?php echo esc_html( number_format( $stat_value, 1 ) ); ?><small>%</small></span>
												</div>
												<span class="circular__label"><?php echo esc_html( $stat_heading ); ?></span>
											</div>
										</div>
									</div>

								<?php endif;
							endif;
						endforeach;
						wp_reset_postdata();
					endif; ?>

				<?php else : ?>

					<?php // Predefined stats
					foreach ( $equation_default_array as $equation_default_key => $equation_default_value ) : ?>

					<div class="col-xs-4">
						<div class="widget-player__stat-item">
							<div class="widget-player__stat-circular circular">
								<div class="circular__bar" data-percent="<?php echo esc_attr( ${"$equation_default_key"} ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
									<span class="circular__percents"><?php echo esc_html( number_format( ${"$equation_default_key"}, 1 ) ); ?><small>%</small></span>
								</div>
								<span class="circular__label"><?php echo esc_html( $equation_default_value ); ?></span>
							</div>
						</div>
					</div>

					<?php endforeach; ?>

				<?php endif; ?>

			</div>
		</div>
	</div>
	<?php endif; ?>

</div>
<!-- Widget: Player Stats / End -->

<?php endif; ?>
