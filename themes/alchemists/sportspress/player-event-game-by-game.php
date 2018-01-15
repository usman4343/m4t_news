<?php
/**
 * Game-by-game Stats
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @version   2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$defaults = array(
	'id' => null,
	'title' => false,
	'status' => 'default',
	'date' => 'default',
	'date_from' => 'default',
	'date_to' => 'default',
	'day' => 'default',
	'league' => null,
	'season' => null,
	'venue' => null,
	'team' => null,
	'player' => null,
	'number' => $number,
	'show_team_logo' => get_option( 'sportspress_event_blocks_show_logos', 'yes' ) == 'yes' ? true : false,
	'link_teams' => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
	'link_events' => get_option( 'sportspress_link_events', 'yes' ) == 'yes' ? true : false,
	'paginated' => get_option( 'sportspress_event_blocks_paginated', 'yes' ) == 'yes' ? true : false,
	'rows' => get_option( 'sportspress_event_blocks_rows', 5 ),
	'orderby' => 'default',
	'order' => 'default',
	'show_all_events_link' => false,
	'show_title' => get_option( 'sportspress_event_blocks_show_title', 'no' ) == 'yes' ? true : false,
	'show_league' => get_option( 'sportspress_event_blocks_show_league', 'no' ) == 'yes' ? true : false,
	'show_season' => get_option( 'sportspress_event_blocks_show_season', 'no' ) == 'yes' ? true : false,
	'show_venue' => get_option( 'sportspress_event_blocks_show_venue', 'no' ) == 'yes' ? true : false,
	'hide_if_empty' => false,
	'player_id' => null,
	'player_stats' => null,
);

extract( $defaults, EXTR_SKIP );

$calendar = new SP_Calendar( $id );
if ( $status != 'default' )
	$calendar->status = $status;
if ( $date != 'default' )
	$calendar->date = $date;
if ( $date_from != 'default' )
	$calendar->from = $date_from;
if ( $date_to != 'default' )
	$calendar->to = $date_to;
if ( $league )
	$calendar->league = $league;
if ( $season )
	$calendar->season = $season;
if ( $venue )
	$calendar->venue = $venue;
if ( $team )
	$calendar->team = $team;
if ( $player )
	$calendar->player = $player;
if ( $order != 'default' )
	$calendar->order = $order;
if ( $orderby != 'default' )
	$calendar->orderby = $orderby;
if ( $day != 'default' )
	$calendar->day = $day;
$data = $calendar->data();

if ( $hide_if_empty && empty( $data ) ) return false;

if ( $show_title && false === $title && $id ):
	$caption = $calendar->caption;
	if ( $caption )
		$title = $caption;
	else
		$title = get_the_title( $id );
endif;


// Player Stats
$player_stats_array = array();

// convert stats string to array
if ( !empty( $player_stats )) {
	$player_stats_array = array_map( 'trim', explode(',', $player_stats ) );
}

// and get labels
$performances_array = array();
foreach ( $player_stats_array as $player_stat_single ) {
	$performances = get_post( $player_stat_single );
	$performances_array[$performances->post_name] = $performances->post_title;
}

?>


<!-- Last Game Log -->
<div class="card card--has-table">

	<?php if ( $title ) {
		echo '<header class="card__header"><h4 class="sp-table-caption">' . esc_html( $title ) . '</h4>';

		if ( $id && $show_all_events_link ) {
			echo '<a href="' . get_permalink( $id ) . '" class="btn btn-default btn-outline btn-xs card-header__button">' . esc_html__( 'View all events', 'alchemists' ) . '</a>';
		}

		echo '</header>';
	} ?>

	<div class="card__content">
		<div class="table-responsive">
			<table class="table table-hover game-player-result">
				<thead>
					<tr>
						<th class="game-player-result__date"><?php esc_html_e( 'Date', 'alchemists' ); ?></th>
						<th class="game-player-result__vs"><?php esc_html_e( 'Versus', 'alchemists' ); ?></th>
						<th class="game-player-result__stat"><?php esc_html_e( 'Score', 'alchemists' ); ?></th>

						<?php // Display selected stats
						if ( alchemists_sp_preset( 'soccer' ) ) {

							// Soccer
							foreach ( $performances_array as $performances_key => $performances_label ) : ?>

								<th class="game-player-result__stat">
									<?php if ( 'yellowcards' === $performances_key ) :
										echo esc_html_e( 'YC', 'alchemists' );
									elseif ( 'redcards' === $performances_key ) :
										echo esc_html_e( 'RC', 'alchemists' );
									elseif ( 'assists' === $performances_key ) :
										echo esc_html_e( 'A', 'alchemists' );
									elseif ( 'goals' === $performances_key ) :
										echo esc_html_e( 'G', 'alchemists' );
									else :
										echo esc_html( $performances_label );
									endif; ?>
								</th>

							<?php endforeach;

						} else {

							// Basketball
							foreach ( $performances_array as $performances_key => $performances_label ) : ?>
							<th class="game-player-result__stat"><?php echo esc_html( $performances_label ); ?></th>

						<?php endforeach;
						} ?>

					</tr>
				</thead>
				<tbody>

					<?php
					$i = 0;

					if ( intval( $number ) > 0 ) {
						$limit = $number;
					}

					foreach ( $data as $event ):
						if ( isset( $limit ) && $i >= $limit ) continue;

						$permalink      = get_post_permalink( $event, false, true );
						$results        = get_post_meta( $event->ID, 'sp_results', true );
						$primary_result = alchemists_sportspress_primary_result();
						$event_date     = $event->post_date;
						$teams          = array_unique( get_post_meta( $event->ID, 'sp_team' ) );
						$teams          = array_filter( $teams, 'sp_filter_positive' );

						?>

						<tr>
							<td class="game-player-result__date">
								<time datetime="<?php echo esc_attr( $event_date ); ?>"><?php echo get_the_time( get_option('date_format'), $event ); ?></time>
							</td>
							<td class="game-player-result__vs">
								<?php foreach( $teams as $team_single ):

									// find only the opponent team
									if ( $team != $team_single ) :

										// venue
										$venue = wp_get_post_terms($team_single, 'sp_venue');
										$venue_desc = false;
										if( $venue ) {
											$venue_desc = $venue[0]->description;
										}

										echo '<div class="team-meta">';
											echo '<figure class="team-meta__logo">';
												if ( has_post_thumbnail ( $team_single ) ):
													echo get_the_post_thumbnail( $team_single, 'sportspress-fit-mini' );
												endif;
											echo '</figure>';
											echo '<div class="team-meta__info">';
												echo '<h6 class="team-meta__name">' . esc_html( get_the_title( $team_single ) ) . '</h6>';
												if ( $venue_desc ) {
													echo '<span class="team-meta__place">' . $venue_desc . '</span>';
												}
											echo '</div>';
										echo '</div>';
									endif;
								endforeach; ?>

							</td>
							<td class="game-player-result__score">
								<span class="game-player-result__game">
									<?php foreach( $teams as $team_single ):
										if ( $team == $team_single ) :
											if (!empty($results)) {
												if (!empty($results[$team])) {
													if (isset($results[$team]['outcome']) && !empty($results[$team]['outcome'][0])) {
														if ( $results[$team]['outcome'][0] == 'win' ) {
															esc_html_e( 'W', 'alchemists' );
														} elseif ( $results[$team]['outcome'][0] == 'loss' ) {
															esc_html_e( 'L', 'alchemists' );
														} elseif ( $results[$team]['outcome'][0] == 'draw' ) {
															esc_html_e( 'D', 'alchemists' );
														}
													}
												}
											}
										endif;
									endforeach; ?>
								</span>
								<?php echo sp_add_link( '<span class="sp-result">' . implode( '</span> - <span class="sp-result">', apply_filters( 'sportspress_event_blocks_team_result_or_time', sp_get_main_results_or_time( $event ), $event->ID ) ) . '</span>', $permalink, $link_events ); ?>
							</td>

							<?php
							$event_performance = sp_get_performance( $event );

							// Remove the first row to leave us with the actual data
							unset( $event_performance[0] );


							// Display selected stats
							foreach ( $performances_array as $performances_key => $performances_label ) :

								if ( isset( $event_performance[$team][$player_id][$performances_key] ) ) {
									$player_stat = $event_performance[$team][$player_id][$performances_key];
								} else {
									$player_stat = '-';
								}

								?>

								<td class="game-player-result__stat"><?php echo esc_html( $player_stat ); ?></td>

							<?php endforeach; ?>


						</tr>

					<?php $i++; endforeach; ?>

				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- Last Game Log / End -->
