<?php
/**
 * Player Radar Graph Statistics for Single Player
 *
 * @author 		Dan Fisher
 * @package 	Alchemists
 * @version   1.1.0
 */

// Skip if there are no rows in the table
if ( empty( $data ) ) {
	return;
}

unset( $data[0] );

if ( isset( $data[-1] )) {
	$data = $data[-1]; // Get Total array
}

wp_enqueue_script( 'alchemists-chartjs' );

// Theme Options
$alchemists_data     = get_option('alchemists_data');
$color_primary       = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';
$color_primary_radar = hex2rgba( $color_primary, 0.8 );

$off     = isset( $data['off'] ) ? esc_html( $data['off'] ) : 0;
$ast     = isset( $data['ast'] ) ? esc_html( $data['ast'] ) : 0;
$threepm = isset( $data['threepm'] ) ? esc_html( $data['threepm'] ) : 0;
$fgm     = isset( $data['fgm'] ) ? esc_html( $data['fgm'] ) : 0;
$def     = isset( $data['def'] ) ? esc_html( $data['def'] ) : 0;
$twopm   = ($fgm - $threepm);

?>

<div class="player-info__item player-info__item--stats">
	<canvas id="player-stats" class="player-info-chart" height="290"></canvas>

	<script type="text/javascript">
		(function($){
			$(document).on('ready', function() {
				var radar_data = {
					type: 'radar',
					data: {
						labels: ["<?php esc_html_e( 'OFF', 'alchemists' ); ?>", "<?php esc_html_e( 'AST', 'alchemists' ); ?>", "<?php esc_html_e( '3PT', 'alchemists' ); ?>", "2PT", "<?php esc_html_e( 'DEF', 'alchemists' ); ?>"],
						datasets: [{
							data: [<?php echo esc_js( $off ); ?>, <?php echo esc_js( $ast ); ?>, <?php echo esc_js( $threepm ); ?>, <?php echo esc_js( $twopm ); ?>, <?php echo esc_js( $def ); ?>],
							backgroundColor: "<?php echo esc_html( $color_primary_radar ); ?>",
							borderColor: "<?php echo esc_html( $color_primary ); ?>",
							pointBorderColor: "rgba(255,255,255,0)",
							pointBackgroundColor: "rgba(255,255,255,0)",
							pointBorderWidth: 0
						}]
					},
					options: {
						legend: {
							display: false,
						},
						tooltips: {
							backgroundColor: "rgba(49,64,75,0.8)",
							titleFontSize: 10,
							titleSpacing: 2,
							titleMarginBottom: 4,
							bodyFontFamily: 'Montserrat, sans-serif',
							bodyFontSize: 9,
							bodySpacing: 0,
							cornerRadius: 2,
							xPadding: 10,
							displayColors: false,
						},
						scale: {
							angleLines: {
								color: "rgba(255,255,255,0.025)",
							},
							pointLabels: {
								fontColor: "#9a9da2",
								fontFamily: 'Montserrat, sans-serif',
							},
							ticks: {
								beginAtZero: true,
								display: false,
							},
							gridLines: {
								color: "rgba(255,255,255,0.05)",
								lineWidth: 2,
							},
							labels: {
								display: false
							}
						}
					},
				};

				var ctx = $("#player-stats");
				var playerInfo = new Chart(ctx, radar_data);
			});
		})(jQuery);

	</script>
</div>
