<?php
/**
 * Event Logos Inline
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version   2.2
 */


if ( get_post_status($id) != 'publish') {
	$game_title = esc_html__( 'Game Recap', 'alchemists' );
} else {
	$game_title = esc_html__( 'Game Results', 'alchemists' );
}

// Soccer
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

	    if (count($teams) > 1) {
	      $team1 = $teams[0];
	      $team2 = $teams[1];
	    }

	    $venue1_desc = wp_get_post_terms($team1, 'sp_venue');
	    $venue2_desc = wp_get_post_terms($team2, 'sp_venue');

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

		</div>
		<!-- Game Result / End -->
	</div>
</div>

<?php else : ?>

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
			</section>

		</div>
		<!-- Game Result / End -->
	</div>
</div>

<?php endif; ?>
