<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $team_id
 * @var $calendar_id
 * @var $date
 * @var $date_from
 * @var $date_to
 * @var $color_line
 * @var $color_point
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Alc_Team_Points_History
 */

$title = $team_id = $calendar_id = $date = $date_from = $date_to = $color_line = $color_point = $el_class = $el_id = $css = $css_animation = '';

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'widget card';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

wp_enqueue_script( 'alchemists-chartjs' );

// Team ID
// Check if we're on Single Team page and Team is not selected
if ( is_singular('sp_team') && $team_id == 'default' ) {
	if ( ! isset( $id ) ) {
		global $post;
		$id = $post->ID;
	}
} else {
	$id = intval($team_id);
}

// Calendar ID
$calendar = new SP_Calendar( $calendar_id );
if ( $date != 'default' )
	$calendar->date = $date;
if ( $date_from != 'default' )
	$calendar->from = $date_from;
if ( $date_to != 'default' )
	$calendar->to = $date_to;
$data = $calendar->data();


// echo '<pre>' . var_export($data, true) . '</pre>';

$results_by_event = array();
$dates_by_event   = array();

if ( alchemists_sp_preset('soccer') ) {

	$results_by_event2 = array();

	// Soccer
	foreach ( $data as $event ) {

		$results        = get_post_meta( $event->ID, 'sp_results', true );
		$primary_result = alchemists_sportspress_primary_result();
		$event_date     = $event->post_date;

		// echo '<pre>' . var_export($results, true) . '</pre>';

		if ( isset( $results[$id] )) {
			if ( isset( $results[$id]['outcome'])) {
				$results_by_event[] = $results[$id]['firsthalf'];
				$results_by_event2[] = $results[$id]['secondhalf'];
				$dates_by_event[] = date( 'M j', strtotime($event_date));
			}
		}

	}
	wp_reset_postdata();

} else {

	// Basketball
	foreach ( $data as $event ) {

		$results        = get_post_meta( $event->ID, 'sp_results', true );
		$primary_result = alchemists_sportspress_primary_result();
		$event_date     = $event->post_date;

		if ( isset( $results[$id] )) {
			if ( isset( $results[$id]['outcome'])) {
				$results_by_event[] = $results[$id]['points'];
				$dates_by_event[] = date( 'M j', strtotime($event_date));
			}
		}
	}
	wp_reset_postdata();

}

$results_by_event = implode(",", $results_by_event);
if ( alchemists_sp_preset( 'soccer' ) ) {
	$results_by_event2 = implode(",", $results_by_event2);
}
$dates_by_event =  implode(',', array_map('alchemists_add_quotes', $dates_by_event));

// Chart Line color
$alchemists_data = get_option('alchemists_data');
$chart_line_color = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';
if ( $color_line ) {
	$chart_line_color = $color_line;
}

// Chart Point color
$chart_point_color = '#ffcc00';
if ( $color_point ) {
	$chart_point_color = $color_point;
}

?>

<!-- Points History -->
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">

	<?php if ( alchemists_sp_preset( 'soccer' ) ) : ?>

		<?php

		// 2nd Chart line color
		$chart_line_color2 = isset( $alchemists_data['color-4'] ) ? $alchemists_data['color-4'] : '#c2ff1f';

		// Chart bg color
		$chart_bg_color1 = hex2rgba( $chart_line_color, 0.8);
		$chart_bg_color2 = hex2rgba( $chart_line_color2, 0.8);

		?>

		<?php if ( $title ) { ?>
			<div class="widget__title card__header card__header--has-legend">
				<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>
				<div id="gamesPoinstsLegendSoccer" class="chart-legend"></div>
			</div>
		<?php } ?>
		<div class="card__content">
			<canvas id="points-history-soccer" class="points-history-chart" height="135"></canvas>

			<script type="text/javascript">
				(function($){
					$(document).on('ready', function() {
						var data = {
							type: 'line',
							data: {
								labels: [<?php print_r( $dates_by_event); ?>],
								datasets: [{
									label: '<?php esc_html_e( '1st Half', 'alchemists' ); ?>',
									fill: true,
									lineTension: 0.5,
									backgroundColor: "<?php echo esc_js( $chart_bg_color2 ); ?>",
									borderWidth: 2,
									borderColor: "<?php echo esc_js( $chart_line_color2 ); ?>",
									borderCapStyle: 'butt',
									borderDashOffset: 0.0,
									borderJoinStyle: 'bevel',
									pointRadius: 0,
									pointBorderWidth: 0,
									pointHoverRadius: 5,
									pointHoverBackgroundColor: "#fff",
									pointHoverBorderColor: "<?php echo esc_js( $chart_line_color2 ); ?>",
									pointHoverBorderWidth: 5,
									pointHitRadius: 10,
									data: [<?php echo esc_js( $results_by_event ); ?>],
									spanGaps: false,
								}, {
									label: '<?php esc_html_e( '2nd Half', 'alchemists' ); ?>',
									fill: true,
									lineTension: 0.5,
									backgroundColor: "<?php echo esc_js( $chart_bg_color1 ); ?>",
									borderWidth: 2,
									borderColor: "<?php echo esc_js( $chart_line_color ); ?>",
									borderCapStyle: 'butt',
									borderDashOffset: 0.0,
									borderJoinStyle: 'bevel',
									pointRadius: 0,
									pointBorderWidth: 0,
									pointHoverRadius: 5,
									pointHoverBackgroundColor: "#fff",
									pointHoverBorderColor: "<?php echo esc_js( $chart_line_color ); ?>",
									pointHoverBorderWidth: 5,
									pointHitRadius: 10,
									data: [<?php echo esc_js( $results_by_event2 ); ?>],
									spanGaps: false,
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
										gridLines: {
											color: "#e4e7ed",
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

						var ctx = $('#points-history-soccer');
						var gamesHistory = new Chart(ctx, data);

						document.getElementById('gamesPoinstsLegendSoccer').innerHTML = gamesHistory.generateLegend();
					});
				})(jQuery);

			</script>
		</div>

	<?php else : ?>

		<?php if ( $title ) { ?>
			<div class="widget__title card__header">
				<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>
			</div>
		<?php } ?>
		<div class="card__content">
			<canvas id="points-history" class="points-history-chart" height="135"></canvas>

			<script type="text/javascript">
				(function($){
					$(document).on('ready', function() {
						var data = {
							type: 'line',
							data: {
								labels: [<?php print_r( $dates_by_event); ?>],
								datasets: [{
									label: "<?php esc_html_e( 'POINTS', 'alchemists' ); ?>",
									fill: false,
									lineTension: 0,
									backgroundColor: "<?php echo esc_js( $chart_line_color ); ?>",
									borderWidth: 2,
									borderColor: "<?php echo esc_js( $chart_line_color ); ?>",
									borderCapStyle: 'butt',
									borderDashOffset: 0.0,
									borderJoinStyle: 'bevel',
									pointRadius: 0,
									pointBorderWidth: 0,
									pointHoverRadius: 5,
									pointHoverBackgroundColor: "#fff",
									pointHoverBorderColor: "<?php echo esc_js( $chart_point_color ); ?>",
									pointHoverBorderWidth: 5,
									pointHitRadius: 10,
									data: [<?php echo esc_js( $results_by_event ); ?>],
									spanGaps: false,
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
										gridLines: {
											color: "#e4e7ed",
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
											padding: 20
										}
									}]
								}
							},
						};

						var ctx = $('#points-history');
						var gamesHistory = new Chart(ctx, data);
					});
				})(jQuery);

			</script>
		</div>

	<?php endif; ?>
</div>
<!-- Points History / End -->
