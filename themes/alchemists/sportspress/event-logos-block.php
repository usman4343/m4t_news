<?php
/**
 * Event Logos Block
 *
 * @author   ThemeBoy
 * @package  SportsPress/Templates
 * @version  2.2.0
 */

// Theme Options
$alchemists_data = get_option('alchemists_data');
$color_primary = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';

if ( get_post_status($id) != 'publish') {
	$game_title = esc_html__( 'Game Recap', 'alchemists' );
} else {
	$game_title = esc_html__( 'Game Results', 'alchemists' );
}
?>

<?php // Soccer
if ( alchemists_sp_preset( 'soccer' ) ) : ?>

	<div class="card">
		<div class="card__header">
			<h4><?php echo esc_html( $game_title ); ?></h4>
		</div>
		<div class="card__content">

			<!-- Game Result -->
			<div class="game-result">

				<?php

				$permalink      = get_post_permalink( $id, false, true );
				$results        = get_post_meta( $id, 'sp_results', true );
				$primary_result = alchemists_sportspress_primary_result();
				$teams          = array_unique( get_post_meta( $id, 'sp_team' ) );
				$teams          = array_filter( $teams, 'sp_filter_positive' );

				$sportspress_primary_result = get_option( 'sportspress_primary_result', null );

				if( !empty( $sportspress_primary_result ) ) {
					$goals = $sportspress_primary_result;
				} else {
					$goals = "goals";
				}

				if (count($teams) > 1) {
					$team1 = $teams[0];
					$team2 = $teams[1];
				}

				$venue1_desc = wp_get_post_terms($team1, 'sp_venue');
				$venue2_desc = wp_get_post_terms($team2, 'sp_venue');

				$show_stats = '';
				if (!empty($results)) :
					if (!empty($results[$team1]) && !empty($results[$team2])) :
						if ( isset($results[$team1]['outcome']) && isset($results[$team2]['outcome']) ) :
							$show_stats = true;
						endif;
					endif;
				endif;

				?>

				<section class="game-result__section pt-0">
					<header class="game-result__header game-result__header--alt">

						<?php $leagues = get_the_terms( $id, 'sp_league' ); if ( $leagues ): $league = array_shift( $leagues ); ?>
							<span class="game-result__league">
								<?php echo esc_html( $league->name ); ?>

								<?php $seasons = get_the_terms( $id, 'sp_season' ); if ( $seasons ): $season = array_shift( $seasons ); ?>
									<?php echo esc_html( $season->name ); ?>
								<?php endif; ?>

							</span>
						<?php endif; ?>

						<?php
							$venues = get_the_terms( $id, 'sp_venue' );
							if ( $venues ): ?>

								<h3 class="game-result__title">
									<?php
									$venue_names = array();
									foreach ( $venues as $venue ) {
										$venue_names[] = $venue->name;
									}
									echo implode( '/', $venue_names ); ?>
								</h3>

						<?php endif; ?>

						<time class="game-result__date" datetime="<?php echo get_the_time( 'Y-m-d H:i:s' ); ?>">
							<?php echo get_the_time( get_option( 'date_format' ) ); ?>
						</time>
					</header>

					<!-- Team Logos + Game Result -->
					<div class="game-result__content">
						<?php
						$j = 0;
						foreach( $teams as $team ):
							$j++;

							echo '<div class="game-result__team game-result__team--' . ( $j % 2 ? 'odd' : 'even' ) . '">';
								echo '<figure class="game-result__team-logo">';
									if ( has_post_thumbnail ( $team ) ):

										if ( $link_teams ) :
											echo '<a href="' . get_permalink( $team, false, true ) . '" title="' . get_the_title( $team ) . '">';
												echo get_the_post_thumbnail( $team, 'alchemists_team-logo-fit' );
											echo '</a>';
										else:
											echo get_the_post_thumbnail( $team, 'alchemists_team-logo-fit' );
										endif;
									endif;

								echo '</figure>';

								if ( $show_team_names ) {
									echo '<div class="game-result__team-info">';
										echo '<h5 class="game-result__team-name">' . esc_html( get_the_title( $team ) ) . '</h5>';
										echo '<div class="game-result__team-desc">';
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
								}
							echo '</div>';

						endforeach;
						?>

						<!-- Game Score -->
						<div class="game-result__score-wrap">
							<div class="game-result__score game-result__score--lg">

								<?php

								$status = esc_html__( 'Preview', 'alchemists' );

								if ( $show_results && ! empty( $results ) ) :

									$status = esc_html__( 'Final Score', 'alchemists' ); ?>

									<?php
									// 1st Team
									$team1_class = 'game-result__score-result--loser';
									if (!empty($results)) {
										if (!empty($results[$team1])) {
											if (isset($results[$team1]['outcome']) && !empty($results[$team1]['outcome'][0])) {
												if ( $results[$team1]['outcome'][0] == 'win' ) {
													$team1_class = 'game-result__score-result--winner';
												}
											}
										}
									}

									// 2nd Team
									$team2_class = 'game-result__score-result--loser';
									if (!empty($results)) {
										if (!empty($results[$team2])) {
											if (isset($results[$team2]['outcome']) && !empty($results[$team2]['outcome'][0])) {
												if ( $results[$team2]['outcome'][0] == 'win' ) {
													$team2_class = 'game-result__score-result--winner';
												}
											}
										}
									}

									?>

									<!-- 1st Team -->
									<span class="game-result__score-result <?php echo esc_attr( $team1_class ); ?>">
										<?php if (!empty($results)) {
											if (!empty($results[$team1]) && !empty($results[$team2])) {
												if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
													echo esc_html( $results[$team1][$primary_result] );
												}
											}
										} ?>
									</span>
									<!-- 1st Team / End -->

									<span class="game-result__score-dash">-</span>

									<!-- 2nd Team -->
									<span class="game-result__score-result <?php echo esc_attr( $team2_class ); ?>">
										<?php if (!empty($results)) {
											if (!empty($results[$team1]) && !empty($results[$team2])) {
												if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
													echo esc_html( $results[$team2][$primary_result] );
												}
											}
										} ?>
									</span>
									<!-- 2nd Team / End -->

							<?php else : ?>

								<span class="game-result__score-dash">&ndash;</span>

							<?php endif; ?>

							</div>

							<div class="game-result__score-label">
								<?php echo apply_filters( 'sportspress_event_logos_status', $status, $id ); ?>
							</div>

						</div>
						<!-- Game Score / End -->

					</div>
					<!-- Team Logos + Game Result / End -->
				</section>


				<?php if ( $show_stats ) : ?>
				<div class="spacer"></div>
				<section class="gamre-result__section">

					<?php // Get Performance
					$event_performance = sp_get_performance( $id );

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

					?>

					<header class="game-result__header game-result__header--alt">
						<div class="game-result__header--alt__team">
							<?php foreach($event_performance[$team1] as $player_id => $player){
								$goalsList = $goals;

								if( isset( $player[$goalsList] ) ){
									if( $player[$goalsList] >= 1 ){ ?>
										<span class="game-result__goal">
										<?php echo get_the_title( $player_id ); ?> - <?php echo $player[$goalsList]; ?>
										</span>
										<?php
									}
								}
							} ?>
						</div>
						<div class="game-result__header--alt__team">
							<?php foreach($event_performance[$team2] as $player_id => $player){
								$goalsList = $goals;

								if( isset( $player[$goalsList] ) ){
									if( $player[$goalsList] >= 1 ){ ?>
										<span class="game-result__goal">
											<?php echo get_the_title( $player_id ); ?> - <?php echo $player[$goalsList]; ?>
										</span>
										<?php
									}
								}
							} ?>
						</div>
					</header>

					<?php

					// Stats
					$game_stats = array( 'sh', 'sog', 'ck', 's', 'yellowcards', 'redcards' );

					$game_stats_array = array();
					$game_stats_array = array_reverse( array_intersect_key( $performances_posts_array, array_flip( $game_stats ) ) );

					?>

					<!-- Game Stats -->
					<div class="game-result__stats">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-md-push-3 game-result__stats-scoreboard">
								<div class="game-result__table-stats game-result__table-stats--soccer">
									<div class="table-responsive">
										<table class="table table-wrap-bordered table-thead-color">
											<thead>
												<tr>
													<th colspan="3"><?php esc_html_e( 'Game Statistics', 'alchemists' ); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ( $game_stats_array as $game_stat_key => $game_stat_excerpt ) {

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
													} ?>

													<tr>
														<td><?php echo esc_html( $event_team1_stat ); ?></td>
														<td><?php echo esc_html( $game_stat_excerpt['excerpt'] ); ?></td>
														<td><?php echo esc_html( $event_team2_stat ); ?></td>
													</tr>

												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<?php

							// Progress Bars
							$event_stats_bar = array( 'sh', 'f', 'off' );
							$event_stats_array = array();
							$event_stats_array = array_reverse( array_intersect_key( $performances_posts_array, array_flip( $event_stats_bar ) ) );

							// Accuracy
							$event_percents = array( 'shpercent', 'passpercent' );
							$event_stats_percent_array = array();
							$event_stats_percent_array = array_reverse( array_intersect_key( $performances_posts_array, array_flip( $event_percents ) ) );

							?>
							<div class="col-xs-6 col-md-3 col-md-pull-6 game-result__stats-team-1">

								<div class="row">

									<?php // 1st Team
										foreach ($event_stats_percent_array as $event_percent_key => $event_percent_excerpt) {

											if (isset( $event_performance[$team1][0][$event_percent_key] )) {
												$event_team1_percent = $event_performance[$team1][0][$event_percent_key];
											} else {
												$event_team1_percent = '';
											}
										?>

										<div class="col-xs-6">
											<div class="circular circular--size-70">
												<div class="circular__bar" data-percent="<?php echo esc_attr( $event_team1_percent ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
													<span class="circular__percents"><?php echo esc_html( $event_team1_percent ); ?><small>%</small></span>
												</div>
												<span class="circular__label"><?php echo esc_html( $event_percent_excerpt['excerpt'] ); ?></span>
											</div>
										</div>

									<?php } ?>
								</div>

								<div class="spacer"></div>

								<?php // 1st Team
								foreach ($event_stats_array as $event_stat_bar_key => $event_stat_bar_label) {

									// Event Stats
									if (isset( $event_performance[$team1][0][$event_stat_bar_key] ) && !empty( $event_performance[$team1][0][$event_stat_bar_key] )) {
										$event_team1_stat = $event_performance[$team1][0][$event_stat_bar_key];
									} else {
										$event_team1_stat = 0;
									}

									if (isset( $event_performance[$team2][0][$event_stat_bar_key] ) && !empty( $event_performance[$team2][0][$event_stat_bar_key] )) {
										$event_team2_stat = $event_performance[$team2][0][$event_stat_bar_key];
									} else {
										$event_team2_stat = 0;
									}

									$event_total_stat = $event_team1_stat + $event_team2_stat;
									if ( $event_total_stat <= '0' ) {
										$event_total_stat = '1';
									}
									$event_team1_stat_pct = round( ( $event_team1_stat / $event_total_stat ) * 100 ); ?>


									<div class="progress-stats">
										<div class="progress__label progress__label--abbr"><?php echo esc_html( $event_stat_bar_label['label'] ); ?></div>
										<div class="progress">
											<div class="progress__bar" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team1_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team1_stat_pct ); ?>%;"></div>
										</div>
										<div class="progress__number progress__number--20"><?php echo esc_html( $event_team1_stat ); ?></div>
									</div>

								<?php } ?>

							</div>
							<div class="col-xs-6 col-md-3 game-result__stats-team-2">

								<div class="row">

									<?php // 2nd Team
										foreach ($event_stats_percent_array as $event_percent_key => $event_percent_excerpt) {

											if (isset( $event_performance[$team2][0][$event_percent_key] )) {
												$event_team2_percent = $event_performance[$team2][0][$event_percent_key];
											} else {
												$event_team2_percent = '';
											}
										?>

										<div class="col-xs-6">
											<div class="circular circular--size-70">
												<div class="circular__bar" data-percent="<?php echo esc_attr( $event_team2_percent ); ?>" data-bar-color="#9fe900">
													<span class="circular__percents"><?php echo esc_html( $event_team2_percent ); ?><small>%</small></span>
												</div>
												<span class="circular__label"><?php echo esc_html( $event_percent_excerpt['excerpt'] ); ?></span>
											</div>
										</div>

									<?php } ?>
								</div>

								<div class="spacer"></div>

								<?php // 2nd Team
								foreach ($event_stats_array as $event_stat_bar_key => $event_stat_bar_label) {

									// Event Stats
									if (isset( $event_performance[$team1][0][$event_stat_bar_key] ) && !empty( $event_performance[$team1][0][$event_stat_bar_key] )) {
										$event_team1_stat = $event_performance[$team1][0][$event_stat_bar_key];
									} else {
										$event_team1_stat = 0;
									}

									if (isset( $event_performance[$team2][0][$event_stat_bar_key] ) && !empty( $event_performance[$team2][0][$event_stat_bar_key] )) {
										$event_team2_stat = $event_performance[$team2][0][$event_stat_bar_key];
									} else {
										$event_team2_stat = 0;
									}

									$event_total_stat = $event_team1_stat + $event_team2_stat;
									if ( $event_total_stat <= '0' ) {
										$event_total_stat = '1';
									}

									$event_team2_stat_pct = round( ( $event_team2_stat / $event_total_stat ) * 100 ); ?>


									<div class="progress-stats">
										<div class="progress__label progress__label--abbr"><?php echo esc_html( $event_stat_bar_label['label'] ); ?></div>
										<div class="progress">
											<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team2_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team2_stat_pct ); ?>%;"></div>
										</div>
										<div class="progress__number progress__number--20"><?php echo esc_html( $event_team2_stat ); ?></div>
									</div>

								<?php } ?>

							</div>
						</div>
					</div>
					<!-- Game Stats / End -->

				</section>
				<?php endif; ?>

				<?php
				if (!empty($results)) {
					if (!empty($results[$team1]) && !empty($results[$team2])) {

						// ball possession fields
						$team1_poss   = isset( $results[$team1]['poss'] ) ? str_replace( '%', '', $results[$team1]['poss'] ) : '';
						$team2_poss   = isset( $results[$team2]['poss'] ) ? str_replace( '%', '', $results[$team2]['poss'] ) : '';

						if (!empty($results[$team1]['poss']) && !empty($results[$team2]['poss'])) { ?>

							<!-- Ball Possession -->
							<section class="game-result__section">
								<header class="game-result__subheader card__subheader">
									<h5 class="game-result__subtitle"><?php esc_attr_e( 'Ball Possession', 'alchemists' ); ?></h5>
								</header>
								<div class="game-result__content">

									<!-- Progress: Ball Possession -->
									<div class="progress-double-wrapper">
										<div class="spacer-sm"></div>
										<div class="progress-inner-holder">
											<div class="progress__digit progress__digit--left progress__digit--highlight"><?php echo esc_html( $team1_poss ); ?>%</div>
											<div class="progress__double">
												<div class="progress progress--lg">
													<div class="progress__bar" role="progressbar" aria-valuenow="<?php echo esc_attr( $team1_poss ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $team1_poss ); ?>%"></div>
												</div>
												<div class="progress progress--lg">
													<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $team2_poss ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $team2_poss ); ?>%"></div>
												</div>
											</div>
											<div class="progress__digit progress__digit--right progress__digit--highlight"><?php echo esc_html( $team2_poss ); ?>%</div>
										</div>
									</div>
									<!-- Progress: Ball Possession / End -->

								</div>
							</section>
							<!-- Ball Possession / End -->

						<?php }
					}
				}
				?>

				<?php // Game Timeline
				if (!empty($results)) :
					if (!empty($results[$team1]) && !empty($results[$team2])) :

						// Get linear timeline from event
						$event = new SP_Event( $id );
						$timeline = $event->timeline( false, true );

						// Return if timeline is empty
						if ( empty( $timeline ) ) return;

						// Get team link option
						$link_teams = get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false;

						// Get full time of event
						$event_minutes = $event->minutes();

						// Initialize spacer
						$previous = 0;
						?>

						<!-- Game Timeline -->
						<section class="game-result__section">
							<header class="game-result__subheader card__subheader">
								<h5 class="game-result__subtitle"><?php esc_html_e( 'Game Timeline', 'alchemists' ); ?></h5>
							</header>
							<div class="game-result__content game-result__content--block game-result__content--visible mb-0">

								<!-- Timeline -->
								<div class="game-timeline-wrapper">
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
													<?php if ( $icon ) : ?>
														<?php if ( $link_teams ) : ?>
															<?php $team = sp_array_value( $details, 'id' ); ?>
															<a href="<?php echo get_post_permalink( $team ); ?>" class="game-timeline__team-logo" title="<?php echo $name; ?>"><?php echo $icon; ?></a>
														<?php else : ?>
															<span class="game-timeline__team-logo" title="<?php echo $name; ?>"><?php echo $icon; ?></span>
														<?php endif; ?>
													<?php endif; ?>
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
													<div class="game-timeline__time" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( strip_tags( $name ) ); ?>"><?php echo $time . "'"; ?></div>
												</div>
											<?php } ?>

										<?php endforeach; ?>

										<div class="game-timeline__event game-timeline__event--ft" title="<?php esc_attr_e( 'Full Time', 'alchemists' ); ?>">
											<div class="game-timeline__time"><?php esc_html_e( 'FT', 'alchemists' ); ?></div>
										</div>

									</div>
								</div>
								<!-- Timeline / End -->

								<div class="spacer-sm"></div>

								<div class="game-result__section-decor"></div>

							</div>
						</section>

					<?php endif; ?>
				<?php endif; ?>

			</div>
			<!-- Game Result / End -->
		</div>
	</div>

<?php else : ?>

	<?php // Basketball ?>
	<div class="card">
		<div class="card__header">
			<h4><?php echo esc_html( $game_title ); ?></h4>
		</div>
		<div class="card__content">

			<!-- Game Result -->
			<div class="game-result">

				<?php

				$permalink      = get_post_permalink( $id, false, true );
				$results        = get_post_meta( $id, 'sp_results', true );
				$primary_result = alchemists_sportspress_primary_result();
				$teams          = array_unique( get_post_meta( $id, 'sp_team' ) );
				$teams          = array_filter( $teams, 'sp_filter_positive' );

				if (count($teams) > 1) {
					$team1 = $teams[0];
					$team2 = $teams[1];
				}

				$venue1_desc = wp_get_post_terms($team1, 'sp_venue');
				$venue2_desc = wp_get_post_terms($team2, 'sp_venue');

				$show_stats = '';
				if (!empty($results)) :
					if (!empty($results[$team1]) && !empty($results[$team2])) :
						if ( isset($results[$team1]['outcome']) && isset($results[$team2]['outcome']) ) :
							$show_stats = true;
						endif;
					endif;
				endif;

				?>

				<section class="game-result__section">
					<header class="game-result__header">

						<?php $leagues = get_the_terms( $id, 'sp_league' ); if ( $leagues ): $league = array_shift( $leagues ); ?>
							<h3 class="game-result__title">
								<?php echo esc_html( $league->name ); ?>

								<?php $seasons = get_the_terms( $id, 'sp_season' ); if ( $seasons ): $season = array_shift( $seasons ); ?>
									<?php echo esc_html( $season->name ); ?>
								<?php endif; ?>

							</h3>
						<?php endif; ?>

						<time class="game-result__date" datetime="<?php echo get_the_time( 'Y-m-d H:i:s' ); ?>">
							<?php echo get_the_time( get_option( 'date_format' ) ); ?>
						</time>
					</header>

					<!-- Team Logos + Game Result -->
					<div class="game-result__content">
						<?php
						$j = 0;
						foreach( $teams as $team ):
							$j++;

							echo '<div class="game-result__team game-result__team--' . ( $j % 2 ? 'odd' : 'even' ) . '">';
								echo '<figure class="game-result__team-logo">';
									if ( has_post_thumbnail ( $team ) ):

										if ( $link_teams ) :
											echo '<a href="' . get_permalink( $team, false, true ) . '" title="' . get_the_title( $team ) . '">';
												echo get_the_post_thumbnail( $team, 'alchemists_team-logo-fit' );
											echo '</a>';
										else:
											echo get_the_post_thumbnail( $team, 'alchemists_team-logo-fit' );
										endif;
									endif;

								echo '</figure>';

								if ( $show_team_names ) {
									echo '<div class="game-result__team-info">';
										echo '<h5 class="game-result__team-name">' . esc_html( get_the_title( $team ) ) . '</h5>';
										echo '<div class="game-result__team-desc">';
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
								}
							echo '</div>';

						endforeach;
						?>

						<!-- Game Score -->
						<div class="game-result__score-wrap">
							<div class="game-result__score">

								<?php

								$status = esc_html__( 'Preview', 'alchemists' );

								if ( $show_results && ! empty( $results ) ) :

									$status = esc_html__( 'Final Score', 'alchemists' ); ?>

									<?php
									// 1st Team
									$team1_class = 'game-result__score-result--loser';
									if (!empty($results)) {
										if (!empty($results[$team1])) {
											if (isset($results[$team1]['outcome']) && !empty($results[$team1]['outcome'][0])) {
												if ( $results[$team1]['outcome'][0] == 'win' ) {
													$team1_class = 'game-result__score-result--winner';
												}
											}
										}
									}

									// 2nd Team
									$team2_class = 'game-result__score-result--loser';
									if (!empty($results)) {
										if (!empty($results[$team2])) {
											if (isset($results[$team2]['outcome']) && !empty($results[$team2]['outcome'][0])) {
												if ( $results[$team2]['outcome'][0] == 'win' ) {
													$team2_class = 'game-result__score-result--winner';
												}
											}
										}
									}

									?>

									<!-- 1st Team -->
									<span class="game-result__score-result <?php echo esc_attr( $team1_class ); ?>">
										<?php if (!empty($results)) {
											if (!empty($results[$team1]) && !empty($results[$team2])) {
												if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
													echo esc_html( $results[$team1][$primary_result] );
												}
											}
										} ?>
									</span>
									<!-- 1st Team / End -->

									<span class="game-result__score-dash">-</span>

									<!-- 2nd Team -->
									<span class="game-result__score-result <?php echo esc_attr( $team2_class ); ?>">
										<?php if (!empty($results)) {
											if (!empty($results[$team1]) && !empty($results[$team2])) {
												if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
													echo esc_html( $results[$team2][$primary_result] );
												}
											}
										} ?>
									</span>
									<!-- 2nd Team / End -->

							<?php else : ?>

								<span class="game-result__score-dash">&ndash;</span>

							<?php endif; ?>

							</div>

							<div class="game-result__score-label">
								<?php echo apply_filters( 'sportspress_event_logos_status', $status, $id ); ?>
							</div>

						</div>
						<!-- Game Score / End -->

					</div>
					<!-- Team Logos + Game Result / End -->

					<?php if ( $show_stats ) : ?>
						<!-- Game Stats -->
						<div class="game-result__stats">
							<div class="row">
								<div class="col-xs-12 col-md-6 col-md-push-3 game-result__stats-scoreboard">
									<div class="game-result__table-stats">
										<div class="table-responsive">
											<table class="table table__cell-center table-wrap-bordered table-thead-color">
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

								<?php
								// Get Performance
								$event_performance = sp_get_performance( $id );

								// Remove the first row to leave us with the actual data
								unset( $event_performance[0] );

								// echo '<pre>' . var_export($event_performance, true) . '</pre>';

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

								// Custom Stats
								$game_stats = array( 'ast', 'reb', 'stl', 'blk', 'pf' );

								$game_stats_array = array();
								$game_stats_array = array_reverse( array_intersect_key( $performances_posts_array, array_flip( $game_stats ) ) );

								?>
								<div class="col-xs-6 col-md-3 col-md-pull-6 game-result__stats-team-1">

									<?php // 1st Team
									foreach ($game_stats_array as $game_stat_key => $game_stat_label) {

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
										$event_team1_stat_pct = round( ( $event_team1_stat / $event_total_stat ) * 100 ); ?>


										<div class="progress-stats">
											<div class="progress__label progress__label--abbr"><?php echo esc_html( $game_stat_label['label'] ); ?></div>
											<div class="progress">
												<div class="progress__bar" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team1_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team1_stat_pct ); ?>%;"></div>
											</div>
											<div class="progress__number progress__number--20"><?php echo esc_html( $event_team1_stat ); ?></div>
										</div>

									<?php } ?>

								</div>
								<div class="col-xs-6 col-md-3 game-result__stats-team-2">

									<?php // 2nd Team
									foreach ($game_stats_array as $game_stat_key => $game_stat_label) {

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

										$event_team2_stat_pct = round( ( $event_team2_stat / $event_total_stat ) * 100 ); ?>


										<div class="progress-stats">
											<div class="progress__label progress__label--abbr"><?php echo esc_html( $game_stat_label['label'] ); ?></div>
											<div class="progress">
												<div class="progress__bar progress__bar--info" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team2_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team2_stat_pct ); ?>%;"></div>
											</div>
											<div class="progress__number progress__number--20"><?php echo esc_html( $event_team2_stat ); ?></div>
										</div>

									<?php } ?>

								</div>
							</div>
						</div>
						<!-- Game Stats / End -->

					<?php endif; ?>
				</section>



				<?php if ( $show_stats ) : ?>
					<!-- Game Percentage -->
					<section class="game-result__section">
						<header class="game-result__subheader card__subheader">
							<h5 class="game-result__subtitle"><?php esc_html_e( 'Game Statistics', 'alchemists' ); ?></h5>
						</header>
						<div class="game-result__content-alt mb-0">
							<div class="row">
								<div class="col-xs-12 col-md-6">
									<div class="row">

										<?php
										// Accuracy
										$game_percents = array( 'fgpercent', 'threeppercent', 'ftpercent' );

										$game_stats_percentage_array = array();
										$game_stats_percentage_array = array_reverse( array_intersect_key( $performances_posts_array, array_flip( $game_percents ) ) );

										?>

										<?php // 1st Team
										foreach ($game_stats_percentage_array as $game_percent_key => $game_percent_label) {

											if (isset( $event_performance[$team1][0][$game_percent_key] ) && !empty( $event_performance[$team1][0][$game_percent_key] )) {
												$event_team1_percent = $event_performance[$team1][0][$game_percent_key];
											} else {
												$event_team1_percent = 0;
											}
										?>

										<div class="col-xs-4">
											<div class="circular">
												<div class="circular__bar" data-percent="<?php echo esc_attr( $event_team1_percent ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
													<span class="circular__percents"><?php echo esc_html( $event_team1_percent ); ?><small>%</small></span>
												</div>
												<span class="circular__label"><?php echo esc_html( $game_percent_label['excerpt'] ); ?></span>
											</div>
										</div>

										<?php } ?>

									</div>
								</div>
								<div class="col-xs-12 col-md-6">
									<div class="row">

										<?php // 2nd Team
										foreach ($game_stats_percentage_array as $game_percent_key => $game_percent_label) {

											if (isset( $event_performance[$team2][0][$game_percent_key] ) && !empty( $event_performance[$team2][0][$game_percent_key] )) {
												$event_team2_percent = $event_performance[$team2][0][$game_percent_key];
											} else {
												$event_team2_percent = 0;
											}
										?>

										<div class="col-xs-4">
											<div class="circular">
												<div class="circular__bar" data-percent="<?php echo esc_attr( $event_team2_percent ); ?>" data-bar-color="#0cb2e2">
													<span class="circular__percents"><?php echo esc_html( $event_team2_percent ); ?><small>%</small></span>
												</div>
												<span class="circular__label"><?php echo esc_html( $game_percent_label['excerpt'] ); ?></span>
											</div>
										</div>

										<?php } ?>

									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- Game Percentage / End -->
				<?php endif; ?>

			</div>
			<!-- Game Result / End -->
		</div>
	</div>
<?php endif; ?>
