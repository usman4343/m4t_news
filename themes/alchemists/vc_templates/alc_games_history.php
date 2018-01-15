<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $team_id
 * @var $label_won
 * @var $label_lost
 * @var $color_won
 * @var $color_lost
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Alc_Games_History
 */

$title = $team_id = $label_won = $label_lost = $color_won = $color_lost = $el_class = $el_id = $css = $css_animation = '';

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'widget card widget-games-history';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

wp_enqueue_script( 'alchemists-chartjs' );

// Check if we're on Single Team page and Team is not selected
if ( is_singular('sp_team') && $team_id == 'default' ) {
	if ( ! isset( $id ) ) {
		$id = get_the_ID();
	}
} else {
	$id = intval($team_id);
}

// Select the Team
$team = new SP_Team( $id );
$tables = $team->tables();

$team_wins    = array();
$team_loses   = array();
$season_years = array();

// Loop all League Tables
foreach ( $tables as $table ) {
	if ( ! $table ) continue;

	// get League Table ID
	$table_id = $table->ID;

	// check for the Seasons
	$seasons = (array)get_the_terms( $table_id, 'sp_season' );
	$season_names = array();
	foreach ( $seasons as $season ):
		if ( is_object( $season ) && property_exists( $season, 'term_id' ) && property_exists( $season, 'name' ) ):
			$season_names[] = $season->name;
		endif;
	endforeach;

	$season_years[] = $season_names[0];

	// jump into League Table data
	$table = new SP_League_Table( $table_id );
	$data = $table->data();

	// Remove the first row to leave us with the actual data
	unset( $data[0] );

	// and find Win games
	$team_wins[] = $data[$id]['w'];

	// and Lost games
	$team_loses[] = $data[$id]['l'];

}

// Convert arrays
$team_wins    = implode(",", $team_wins);
$team_loses   = implode(",", $team_loses);
$season_years = "'" . implode("','", $season_years) . "'";

// WON Bar color
$alchemists_data = get_option('alchemists_data');

if ( alchemists_sp_preset('soccer') ) {
	$bar_won_color = isset( $alchemists_data['color-4'] ) ? $alchemists_data['color-4'] : '#c2ff1f';
} else {
	$bar_won_color = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';
}
if ( $color_won ) {
	$bar_won_color = $color_won;
}

// LOST Bar color
if ( alchemists_sp_preset('soccer') ) {
	$bar_lost_color = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#38a9ff';
} else {
	$bar_lost_color = '#ff8429';
}
if ( $color_lost ) {
	$bar_lost_color = $color_lost;
}
?>

<!-- Widget: Games History -->
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">

	<?php if ( alchemists_sp_preset( 'soccer' ) ) : ?>

		<?php if ( $title ) { ?>
			<div class="widget__title card__header card__header--has-legend">
				<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>
				<div id="gamesHistoryLegendSoccer" class="chart-legend chart-legend--games-history"></div>
			</div>
		<?php } ?>

		<div class="widget__content card__content">
			<canvas id="games-history-soccer" class="games-history-chart" height="230"></canvas>

			<script type="text/javascript">
				(function($){
					$(document).on('ready', function() {
						var data = {
							type: 'bar',
							data: {
								labels: [<?php print_r( $season_years ); ?>],
								datasets: [{
									label: "<?php echo esc_js( $label_won ); ?>",
									data: [<?php print_r( $team_wins ); ?>],
									backgroundColor: "<?php echo esc_js( $bar_won_color ); ?>",
								}, {
									label: '<?php echo esc_js( $label_lost ); ?>',
									data: [<?php print_r( $team_loses ); ?>],
									backgroundColor: "<?php echo esc_js( $bar_lost_color ); ?>",
								}]
							},
							options: {
								legend: {
									display: false,
									labels: {
										boxWidth: 8,
										fontSize: 9,
										fontColor: '#31404b',
										fontFamily: 'Montserrat, sans-serif',
										padding: 20,
									}
								},
								tooltips: {
									backgroundColor: "rgba(49,64,75,0.8)",
									titleFontSize: 0,
									titleSpacing: 0,
									titleMarginBottom: 0,
									bodyFontFamily: 'Montserrat, sans-serif',
									bodyFontSize: 9,
									bodySpacing: 0,
									cornerRadius: 2,
									xPadding: 10,
									displayColors: false,
								},
								scales: {
									xAxes: [{
										stacked: true,
										barThickness: 34,
										gridLines: {
											display:false,
											color: "rgba(255,255,255,0)",
										},
										ticks: {
											fontColor: '#9a9da2',
											fontFamily: 'Montserrat, sans-serif',
											fontSize: 10,
										},
									}],
									yAxes: [{
										stacked: true,
										gridLines: {
											display:false,
											color: "rgba(255,255,255,0)",
										},
										ticks: {
											fontColor: '#9a9da2',
											fontFamily: 'Montserrat, sans-serif',
											fontSize: 10,
											padding: 20,
											userCallback: function(label, index, labels) {
												// when the floored value is the same as the value we have a whole number
												if (Math.floor(label) === label) {
													return label;
												}
											},
										}
									}]
								}
							},
						};

						var ctx = $('#games-history-soccer');
						var gamesHistory = new Chart(ctx, data);
						document.getElementById('gamesHistoryLegendSoccer').innerHTML = gamesHistory.generateLegend();
					});
				})(jQuery);

			</script>
		</div>

	<?php else : ?>

		<?php if ( $title ) { ?>
			<div class="widget__title card__header card__header--has-legend">
				<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>
				<div id="gamesHistoryLegend" class="chart-legend chart-legend--games-history"></div>
			</div>
		<?php } ?>

		<div class="widget__content card__content">
			<canvas id="games-history" class="games-history-chart" height="270"></canvas>

			<script type="text/javascript">
				(function($){
					$(document).on('ready', function() {
						var data = {
							type: 'bar',
							data: {
								labels: [<?php print_r( $season_years ); ?>],
								datasets: [{
									label: "<?php echo esc_js( $label_won ); ?>",
									data: [<?php print_r( $team_wins ); ?>],
									backgroundColor: "<?php echo esc_js( $bar_won_color ); ?>",
								}, {
									label: '<?php echo esc_js( $label_lost ); ?>',
									data: [<?php print_r( $team_loses ); ?>],
									backgroundColor: "<?php echo esc_js( $bar_lost_color ); ?>"
								}]
							},
							options: {
								legend: {
									display: false,
									labels: {
										boxWidth: 8,
										fontSize: 9,
										fontColor: '#31404b',
										fontFamily: 'Montserrat, sans-serif',
										padding: 20,
									}
								},
								tooltips: {
									backgroundColor: "rgba(49,64,75,0.8)",
									titleFontSize: 0,
									titleSpacing: 0,
									titleMarginBottom: 0,
									bodyFontFamily: 'Montserrat, sans-serif',
									bodyFontSize: 9,
									bodySpacing: 0,
									cornerRadius: 2,
									xPadding: 10,
									displayColors: false,
								},
								scales: {
									xAxes: [{
										barThickness: 14,
										gridLines: {
											display:false,
											color: "rgba(255,255,255,0)",
										},
										ticks: {
											fontColor: '#9a9da2',
											fontFamily: 'Montserrat, sans-serif',
											fontSize: 10,
										},
									}],
									yAxes: [{
										gridLines: {
											display:false,
											color: "rgba(255,255,255,0)",
										},
										ticks: {
											beginAtZero: true,
											fontColor: '#9a9da2',
											fontFamily: 'Montserrat, sans-serif',
											fontSize: 10,
											padding: 20,
											userCallback: function(label, index, labels) {
												// when the floored value is the same as the value we have a whole number
												if (Math.floor(label) === label) {
													return label;
												}
											},
										}
									}]
								}
							},
						};

						var ctx = $('#games-history');
						var gamesHistory = new Chart(ctx, data);
						document.getElementById('gamesHistoryLegend').innerHTML = gamesHistory.generateLegend();
					});
				})(jQuery);

			</script>
		</div>
	<?php endif; ?>
</div>
<!-- Widget: Games History / End -->
