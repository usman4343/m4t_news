<?php
/**
 * Player Average Statistics for Single Player
 *
 * @author 		Dan Fisher
 * @package 	Alchemists
 * @version   2.0.3
 */

// Skip if there are no rows in the table
if ( empty( $data ) ) {
	return;
}

unset( $data[0] );

if ( isset( $data[-1] )) {
	$data = $data[-1]; // Get Total array
}

// Theme Options
$alchemists_data = get_option('alchemists_data');
$color_primary = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';

// Player List
$player_list_id  = get_field( 'player_header_list' );

if ( $player_list_id ) {
	$player_list      = new SP_Player_List( $player_list_id );
	$player_list_data = $player_list->data();

	// Remove the first row to leave us with the actual data
	unset( $player_list_data[0] );
}


// Sports specifics
if ( alchemists_sp_preset( 'soccer') ) {

	// Soccer
	$stats = array(
		'gpg' => esc_html__( 'Goals', 'alchemists' ),
		'apg' => esc_html__( 'Assists', 'alchemists' ),
	);

	// circular bar
	$track_color = 'rgba(255,255,255,.2)';
	$bar_color   = isset( $alchemists_data['color-4-darken'] ) ? $alchemists_data['color-4-darken'] : '#9fe900';

	// stats numbers
	$goals      = isset( $data['goals'] ) ? $data['goals'] : esc_html__( 'n/a', 'alchemists' );
	$assists    = isset( $data['assists'] ) ? $data['assists'] : esc_html__( 'n/a', 'alchemists' );
	$games      = isset( $data['appearances'] ) ? $data['appearances'] : esc_html__( 'n/a', 'alchemists' );

	// css classes
	$stats_wrapper_class = 'player-info-stats pt-0';
	$stat_class          = 'player-info-stats__item player-info-stats__item--top-padding';

} else {

	// Basketball
	$stats = array(
		'ppg' => esc_html__( 'Points', 'alchemists' ),
		'apg' => esc_html__( 'Assists', 'alchemists' ),
		'rpg' => esc_html__( 'Rebounds', 'alchemists' ),
	);

	// circular bar
	$track_color = 'rgba(255,255,255,.2)';
	$bar_color   = $color_primary;

	// css classes
	$stats_wrapper_class = 'player-info-stats';
	$stat_class          = 'player-info-stats__item';
}
?>

<div class="<?php echo esc_attr( $stats_wrapper_class ); ?>">

	<?php if ( alchemists_sp_preset( 'soccer' ) ) : ?>
	<div class="player-info-stats__item">
		<div class="player-info-details player-info-details--extra-stats">

			<?php if ( $goals ) : ?>
			<div class="player-info-details__item player-info-details__item--goals">
				<h6 class="player-info-details__title"><?php esc_attr_e( 'T.Goals', 'alchemists' ); ?></h6>
				<div class="player-info-details__value"><?php echo esc_html( $goals ); ?></div>
			</div>
			<?php endif; ?>

			<?php if ( $assists ) : ?>
			<div class="player-info-details__item player-info-details__item--assists">
				<h6 class="player-info-details__title"><?php esc_attr_e( 'T.Assists', 'alchemists' ); ?></h6>
				<div class="player-info-details__value"><?php echo esc_html( $assists ); ?></div>
			</div>
			<?php endif; ?>

			<?php if ( $games ) : ?>
			<div class="player-info-details__item player-info-details__item--games pb-0">
				<h6 class="player-info-details__title"><?php esc_attr_e( 'T.Games', 'alchemists' ); ?></h6>
				<div class="player-info-details__value"><?php echo esc_html( $games ); ?></div>
			</div>
			<?php endif; ?>

		</div>
	</div>
	<?php endif; ?>

	<?php
	// check if Player List selected
	if ( $player_list_id ) {

		// Player List selected, so we can display circular bar with relative values
		foreach ( $stats as $stat_key => $stat_label ) :

			$player_list->priorities = array(
				array(
					'key' => $stat_key,
					'order' => 'DESC',
				),
			);
			uasort( $player_list_data, array( $player_list, 'sort' ) );

			$player_top = array_slice( $player_list_data, 0, 1, true );
			$player_top = current($player_top);
			$player_top_value = $player_top[$stat_key];

			if ( isset( $data[$stat_key] ) ) {
				if ( $player_top_value > 0 ) {
					$circular_percent = $data[$stat_key] / $player_top_value * 100;
				} else {
					$circular_percent = 0;
				}
				$circular_value = $data[$stat_key];
			} else {
				$circular_percent = 0;
				$circular_value = esc_html__( 'n/a', 'alchemists' );
			}

			// output circular bar
			alchemists_sp_player_circular_bar(
				$class = $stat_class,
				$percent = $circular_percent,
				$track_color = $track_color,
				$bar_color = $bar_color,
				$stat_value = $circular_value,
				$stat_label = $stat_label
			);

		endforeach;

	} else {

		// Player List is not selected, display static circular bars
		foreach ( $stats as $stat_key => $stat_label ) :

			if ( isset( $data[$stat_key] ) ) {
				$circular_percent = 100;
				$circular_value = $data[$stat_key];
			} else {
				$circular_percent = 0;
				$circular_value = esc_html__( 'n/a', 'alchemists' );
			}

			// output circular bar
			alchemists_sp_player_circular_bar(
				$class = $stat_class,
				$percent = $circular_percent,
				$track_color = $track_color,
				$bar_color = $bar_color,
				$stat_value = $circular_value,
				$stat_label = $stat_label
			);

		endforeach;

	} ?>

</div>
