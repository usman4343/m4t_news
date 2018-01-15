<?php
/**
 * Event Results
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   2.2.0
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
	'number' => -1,
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
);

if ( alchemists_sp_preset( 'soccer' ) ) {
	$defaults['show_timeline'] = false;
}

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
endif; ?>


<div class="card card--no-paddings">

	<?php if ( $title ) {
		echo '<header class="card__header"><h4 class="sp-table-caption">' . esc_html( $title ) . '</h4></header>';
	} ?>

	<div class="card__content">

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

			$event_id       = $event;

			if (count($teams) > 1) {
				$team1 = $teams[0];
				$team2 = $teams[1];
			}

			$venue1_desc = wp_get_post_terms($team1, 'sp_venue');
			$venue2_desc = wp_get_post_terms($team2, 'sp_venue');

			?>

			<!-- Game Score -->
			<div class="widget-game-result__section">
				<div class="widget-game-result__section-inner">

					<?php if ( $link_events ) : ?>
						<a href="<?php echo esc_url( $permalink ); ?>" class="widget-game-result__item">
					<?php else : ?>
						<div class="widget-game-result__item">
					<?php endif; ?>

					<header class="widget-game-result__header">
						<?php if ( $show_league ): $leagues = get_the_terms( $event, 'sp_league' ); if ( $leagues ): $league = array_shift( $leagues ); ?>
							<h3 class="widget-game-result__title">
								<?php echo esc_html( $league->name ); ?>

								<?php if ( $show_season ): $seasons = get_the_terms( $event, 'sp_season' ); if ( $seasons ): $season = array_shift( $seasons ); ?>
									<?php echo esc_html( $season->name ); ?>
								<?php endif; endif; ?>

							</h3>
						<?php endif; endif; ?>

						<time class="widget-game-result__date" datetime="<?php echo esc_attr( $event_date ); ?>"><?php echo esc_html( get_the_time( sp_date_format() . ' - ' . sp_time_format(), $event ) ); ?></time>

					</header>


					<div class="widget-game-result__main">

						<?php
						$j = 0;
						foreach( $teams as $team ):
							$j++;

							echo '<div class="widget-game-result__team widget-game-result__team--' . ( $j % 2 ? 'odd' : 'even' ) . '">';
								echo '<figure class="widget-game-result__team-logo">';
									if ( has_post_thumbnail ( $team ) ):
										echo get_the_post_thumbnail( $team, 'alchemists_team-logo-sm-fit' );
									endif;
								echo '</figure>';
								echo '<div class="widget-game-result__team-info">';
									echo '<h5 class="widget-game-result__team-name">' . esc_html( get_the_title( $team ) ) . '</h5>';
									echo '<div class="widget-game-result__team-desc">';
										if ( $j == 1 ) {
											if ( isset( $venue1_desc[0] )) {
												echo esc_html( $venue1_desc[0]->description );
											}
										} elseif ( $j == 2 ) {
											if ( isset( $venue2_desc[0] )) {
												echo esc_html( $venue2_desc[0]->description );
											}
										}
									echo '</div>';
								echo '</div>';
							echo '</div>';

						endforeach;
						?>

						<div class="widget-game-result__score-wrap">
							<div class="widget-game-result__score">

								<?php

								// 1st Team
								$team1_class = 'widget-game-result__score-result--loser';
								if (!empty($results)) {
									if (!empty($results[$team1])) {
										if (isset($results[$team1]['outcome']) && !empty($results[$team1]['outcome'][0])) {
											if ( $results[$team1]['outcome'][0] == 'win' ) {
												$team1_class = 'widget-game-result__score-result--winner';
											}
										}
									}
								}

								// 2nd Team
								$team2_class = 'widget-game-result__score-result--loser';
								if (!empty($results)) {
									if (!empty($results[$team2])) {
										if (isset($results[$team2]['outcome']) && !empty($results[$team2]['outcome'][0])) {
											if ( $results[$team2]['outcome'][0] == 'win' ) {
												$team2_class = 'widget-game-result__score-result--winner';
											}
										}
									}
								}

								?>

								<!-- 1st Team -->
								<span class="widget-game-result__score-result <?php echo esc_attr( $team1_class ); ?>">
									<?php if (!empty($results)) {
										if (!empty($results[$team1]) && !empty($results[$team2])) {
											if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
												echo esc_html( $results[$team1][$primary_result] );
											}
										}
									} ?>
								</span>
								<!-- 1st Team / End -->

								<span class="widget-game-result__score-dash">-</span>

								<!-- 2nd Team -->
								<span class="widget-game-result__score-result <?php echo esc_attr( $team2_class ); ?>">
									<?php if (!empty($results)) {
										if (!empty($results[$team1]) && !empty($results[$team2])) {
											if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
												echo esc_html( $results[$team2][$primary_result] );
											}
										}
									} ?>
								</span>
								<!-- 2nd Team / End -->

							</div>

							<?php if ( $event->post_status === 'publish' ): ?>
							<div class="widget-game-result__score-label"><?php esc_html_e( 'Final Score', 'alchemists' ); ?></div>
							<?php else: ?>
								<?php if ( $show_venue ): $venues = get_the_terms( $event, 'sp_venue' ); if ( $venues ): $venue = array_shift( $venues ); ?>
									<div class="widget-game-result__score-label"><?php echo esc_html( $venue->name ); ?></div>
								<?php endif; endif; ?>
							<?php endif; ?>
						</div>

					</div>

					<?php
					$i++; ?>

				<?php if ( $link_events ) : ?>
					</a><!-- .widget-game-result__item -->
				<?php else : ?>
					</div><!-- .widget-game-result__item -->
				<?php endif; ?>

			</div>
		</div>
		<!-- Game Score / End -->


		<?php if ( alchemists_sp_preset( 'soccer' ) && $show_timeline ) : ?>
			<!-- Timeline -->
			<?php
			if (!empty($results)) :
				if (!empty($results[$team1]) && !empty($results[$team2])) :
					// Get linear timeline from event
					$event = new SP_Event( $event_id );
					$timeline = $event->timeline( false, true );

					// Return if timeline is empty
					if ( empty( $timeline ) ) return;

					// Get full time of event
					$event_minutes = $event->minutes();

					// Initialize spacer
					$previous = 0;
					?>

					<div class="widget-game-result__section">

						<!-- Timeline -->
						<div class="game-timeline-wrapper game-timeline-wrapper--vertical">
							<div class="game-timeline">

								<?php foreach ( $timeline as $minutes => $details ) : ?>
									<?php
									$time = sp_array_value( $details, 'time', false );

									if ( false === $time ) continue;

									$icon = sp_array_value( $details, 'icon', '' );
									$side = sp_array_value( $details, 'side', 'home' );

									if ( $time < 0 ) {
										$name = sp_array_value( $details, 'name', esc_html__( 'Team', 'alchemists' ) );
										?>
										<div class="game-timeline__event game-timeline__event--kickoff game-timeline__event--side-<?php echo esc_attr( $side ); ?>" title="<?php esc_attr_e( 'Kick Off', 'alchemists' ); ?>">
											<div class="game-timeline__time game-timeline__time--kickoff game-timeline__time--kickoff-<?php echo esc_attr( $side ); ?>"><?php esc_html_e( 'KO', 'alchemists' ); ?></div>
										</div>
										<?php
									} else {
										$name = sp_array_value( $details, 'name', esc_html__( 'Player', 'alchemists' ) );
										$number = sp_array_value( $details, 'number', '' );

										if ( '' !== $number ) $name = $number . '. ' . $name;

										$offset = floor( $time / ( $event_minutes + 4 ) * 100 );
										if ( $offset - $previous <= 4 ) $offset = $previous + 4;
										$previous = $offset;
										?>
										<div class="game-timeline__event game-timeline__event--side-<?php echo esc_attr( $side ); ?>" style="left: <?php echo $offset; ?>%;">
											<div class="game-timeline__event-info game-timeline__event-info--side-<?php echo esc_attr( $side ); ?>">
												<div class="game-timeline__event-name"><?php echo $name; ?></div>
												<div class="game-timeline__icon game-timeline__icon--<?php echo esc_attr( $side ); ?>">
													<?php echo $icon; ?>
												</div>
											</div>
											<div class="game-timeline__time" title="<?php echo esc_attr( $name ); ?>"><?php echo $time . "'"; ?></div>
										</div>
									<?php } ?>

								<?php endforeach; ?>

								<div class="game-timeline__event game-timeline__event--ft" title="<?php esc_attr_e( 'Full Time', 'alchemists' ); ?>">
									<div class="game-timeline__time"><?php esc_html_e( 'FT', 'alchemists' ); ?></div>
								</div>

							</div>
						</div>
						<!-- Timeline / End -->

					</div>
					<!-- Timeline / End -->

				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>


		<?php if ( alchemists_sp_preset( 'basketball' ) ) : ?>
			<?php if (!empty($results)) : ?>
				<?php if (!empty($results[$team1]) && !empty($results[$team2])) : ?>
					<?php if ( isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result]) ) : ?>
						<!-- Scoreboard -->
						<div class="widget-game-result__section">
							<div class="widget-game-result__table-stats">
								<div class="table-responsive">
									<table class="table table__cell-center table-thead-color">
										<thead>
											<tr>
												<th><?php esc_html_e( 'Scoreboard', 'alchemists' ); ?></th>
												<th><?php esc_html_e( '1', 'alchemists' ); ?></th>
												<th><?php esc_html_e( '2', 'alchemists' ); ?></th>
												<th><?php esc_html_e( '3', 'alchemists' ); ?></th>
												<th><?php esc_html_e( '4', 'alchemists' ); ?></th>
												<?php if ( !empty( $results[$team1]['ot'] ) || !empty( $results[$team2]['ot'] ) ) : ?>
													<th><?php esc_html_e( 'OT', 'alchemists' ); ?></th>
												<?php endif; ?>
												<th><?php esc_html_e( 'T', 'alchemists' ); ?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th><?php echo get_the_title( $team1 ); ?></th>
												<td><?php echo esc_html( $results[$team1]['one'] ); ?></td>
												<td><?php echo esc_html( $results[$team1]['two'] ); ?></td>
												<td><?php echo esc_html( $results[$team1]['three'] ); ?></td>
												<td><?php echo esc_html( $results[$team1]['four'] ); ?></td>
												<?php if ( !empty( $results[$team1]['ot'] ) ) : ?>
													<td><?php echo esc_html( $results[$team1]['ot'] ); ?></td>
												<?php endif; ?>
												<td>
													<?php echo esc_html( $results[$team1][$primary_result] ); ?>
												</td>
											</tr>
											<tr>
												<th><?php echo get_the_title( $team2 ); ?></th>
												<td><?php echo esc_html( $results[$team2]['one'] ); ?></td>
												<td><?php echo esc_html( $results[$team2]['two'] ); ?></td>
												<td><?php echo esc_html( $results[$team2]['three'] ); ?></td>
												<td><?php echo esc_html( $results[$team2]['four'] ); ?></td>
												<?php if ( !empty( $results[$team2]['ot'] ) ) : ?>
													<td><?php echo esc_html( $results[$team2]['ot'] ); ?></td>
												<?php endif; ?>
												<td>
													<?php echo esc_html( $results[$team2][$primary_result] ); ?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- Scoreboard / End -->
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>



		<?php if ( alchemists_sp_preset( 'soccer' ) ) : ?>

		<?php

		// Sport - Soccer

		$event_performance = sp_get_performance( $event );

		// Remove the first row to leave us with the actual data
		unset( $event_performance[0] );

		// Player Performance
		$performances_posts = get_posts(array(
			'post_type' => 'sp_performance',
			'posts_per_page' => 9999
		));

		$performances_posts_array = array();
		if($performances_posts){
			foreach($performances_posts as $performance_post){
				$performances_posts_array[$performance_post->post_name] = array(
					'label'   => $performance_post->post_title,
					'value'   => $performance_post->post_name,
					'excerpt' => $performance_post->post_excerpt
				);
			}
			wp_reset_postdata();
		}

		$game_stats = array( 'sh', 'sog', 'ck', 'f', 'yellowcards', 'redcards' );

		$game_stats_array = array();
		$game_stats_array = array_reverse( array_intersect_key( $performances_posts_array, array_flip( $game_stats ) ) );
		?>

		<!-- Game Statistics -->
		<div class="widget-game-result__section">
			<header class="widget-game-result__subheader card__subheader card__subheader--sm card__subheader--nomargins">
				<h5 class="widget-game-result__subtitle"><?php esc_html_e( 'Game Statistics', 'alchemists' ); ?></h5>
			</header>
			<div class="widget-game-result__section-inner">

				<?php
				foreach ($game_stats_array as $game_stat_key => $game_stat_excerpt) {

					// Event Stats
					if (isset( $event_performance[$team1][0][$game_stat_key] ) && !empty( $event_performance[$team1][0][$game_stat_key] )) {
						$event_team1_stat = $event_performance[$team1][0][$game_stat_key];
					} else {
						$event_team1_stat = 0;
					}

					if (isset( $event_performance[$team2][0][$game_stat_key] ) && !empty( $event_performance[$team2][0][$game_stat_key] )) {
						$event_team2_stat = $event_performance[$team2][0][$game_stat_key];
					} else {
						$event_team2_stat = 0;
					}

					$event_total_stat = $event_team1_stat + $event_team2_stat;
					if ( $event_total_stat <= '0' ) {
						$event_total_stat = '1';
					}
					$event_team1_stat_pct = round( ( $event_team1_stat / $event_total_stat ) * 100 );
					$event_team2_stat_pct = round( ( $event_team2_stat / $event_total_stat ) * 100 );

					$event_team1_stat_highlight = '';
					$event_team2_stat_highlight = '';

					if ( $event_team1_stat > $event_team2_stat ) {
						$event_team1_stat_highlight = 'progress__digit--highlight';
					} else {
						$event_team2_stat_highlight = 'progress__digit--highlight';
					} ?>

					<div class="progress-double-wrapper">
						<h6 class="progress-title"><?php echo esc_html( $game_stat_excerpt['excerpt'] ); ?></h6>
						<div class="progress-inner-holder">
							<div class="progress__digit progress__digit--left <?php echo esc_attr( $event_team1_stat_highlight ); ?>">
								<?php echo esc_html( $event_team1_stat ); ?>
							</div>
							<div class="progress__double">
								<div class="progress">
									<div class="progress__bar" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team1_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team1_stat_pct ); ?>%;"></div>
								</div>
								<div class="progress">
									<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team2_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team2_stat_pct ); ?>%;"></div>
								</div>
							</div>
							<div class="progress__digit progress__digit--right <?php echo esc_attr( $event_team2_stat_highlight ); ?>">
								<?php echo esc_html( $event_team2_stat ); ?>
							</div>
						</div>
					</div>

				<?php } ?>

			</div>
		</div>
		<!-- Game Statistics / End -->
		<?php else : ?>

		<?php

		// Sport - Basketball
		$event_performance = sp_get_performance( $event );

		// Remove the first row to leave us with the actual data
		unset( $event_performance[0] );

		// Player Performance
		$performances_posts = get_posts(array(
			'post_type' => 'sp_performance',
			'posts_per_page' => 9999
		));

		$performances_posts_array = array();
		if($performances_posts){
			foreach($performances_posts as $performance_post){
				$performances_posts_array[$performance_post->post_name] = array(
					'label'   => $performance_post->post_title,
					'value'   => $performance_post->post_name,
					'excerpt' => $performance_post->post_excerpt
				);
			}
			wp_reset_postdata();
		}

		$game_stats = array( 'ast', 'reb', 'stl' );

		$game_stats_array = array();
		$game_stats_array = array_reverse( array_intersect_key( $performances_posts_array, array_flip( $game_stats ) ) );
		?>

		<!-- Game Statistics -->
		<div class="widget-game-result__section">
			<header class="widget-game-result__subheader card__subheader card__subheader--sm card__subheader--nomargins">
				<h5 class="widget-game-result__subtitle"><?php esc_html_e( 'Game Statistics', 'alchemists' ); ?></h5>
			</header>
			<div class="widget-game-result__section-inner">

				<?php
				foreach ($game_stats_array as $game_stat_key => $game_stat_excerpt) {

					// Event Stats
					if (isset( $event_performance[$team1][0][$game_stat_key] ) && !empty( $event_performance[$team1][0][$game_stat_key] )) {
						$event_team1_stat = $event_performance[$team1][0][$game_stat_key];
					} else {
						$event_team1_stat = 0;
					}

					if (isset( $event_performance[$team2][0][$game_stat_key] ) && !empty( $event_performance[$team2][0][$game_stat_key] )) {
						$event_team2_stat = $event_performance[$team2][0][$game_stat_key];
					} else {
						$event_team2_stat = 0;
					}

					$event_total_stat = $event_team1_stat + $event_team2_stat;
					if ( $event_total_stat <= '0' ) {
						$event_total_stat = '1';
					}
					$event_team1_stat_pct = round( ( $event_team1_stat / $event_total_stat ) * 100 );
					$event_team2_stat_pct = round( ( $event_team2_stat / $event_total_stat ) * 100 );

					$event_team1_stat_highlight = '';
					$event_team2_stat_highlight = '';

					if ( $event_team1_stat > $event_team2_stat ) {
						$event_team1_stat_highlight = 'progress__digit--highlight';
					} else {
						$event_team2_stat_highlight = 'progress__digit--highlight';
					} ?>

					<div class="progress-double-wrapper">
						<h6 class="progress-title"><?php echo esc_html( $game_stat_excerpt['excerpt'] ); ?></h6>
						<div class="progress-inner-holder">
							<div class="progress__digit progress__digit--left <?php echo esc_attr( $event_team1_stat_highlight ); ?>">
								<?php echo esc_html( $event_team1_stat ); ?>
							</div>
							<div class="progress__double">
								<div class="progress">
									<div class="progress__bar" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team1_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team1_stat_pct ); ?>%;"></div>
								</div>
								<div class="progress">
									<div class="progress__bar progress__bar--info" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team2_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team2_stat_pct ); ?>%;"></div>
								</div>
							</div>
							<div class="progress__digit progress__digit--right <?php echo esc_attr( $event_team2_stat_highlight ); ?>">
								<?php echo esc_html( $event_team2_stat ); ?>
							</div>
						</div>
					</div>

				<?php } ?>

			</div>
		</div>
		<!-- Game Statistics / End -->

		<?php endif; ?>


		<?php endforeach; ?>


	</div>
</div>
