<?php
/**
 * Countdown
 *
 * @author    ThemeBoy
 * @package   SportsPress/Templates
 * @version   2.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$defaults = array(
	'team' => null,
	'league' => null,
	'season' => null,
	'id' => null,
	'title' => null,
	'live' => get_option( 'sportspress_enable_live_countdowns', 'yes' ) == 'yes' ? true : false,
	'link_events' => get_option( 'sportspress_link_events', 'yes' ) == 'yes' ? true : false,
	'link_teams' => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
	'link_venues' => get_option( 'sportspress_link_venues', 'no' ) == 'yes' ? true : false,
	'show_logos' => get_option( 'sportspress_countdown_show_logos', 'no' ) == 'yes' ? true : false,
);

if ( isset( $id ) ):
	$post = get_post( $id );
else:
	$args = array();
	if ( isset( $team ) ) {
		$args['meta_query'] = array(
			array(
				'key' => 'sp_team',
				'value' => $team,
			)
		);
	}
	if ( isset( $league ) || isset( $season ) ) {
		$args['tax_query'] = array( 'relation' => 'AND' );

		if ( isset( $league ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'sp_league',
				'terms' => $league,
			);
		}

		if ( isset( $season ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'sp_season',
				'terms' => $season,
			);
		}
	}
	$post = sp_get_next_event( $args );
endif;

extract( $defaults, EXTR_SKIP );

if ( ! isset( $post ) || ! $post ) return;


// Event Date
$post_date = $post->post_date;

echo '<div class="card">';

	echo '<div class="card__content">';

		echo '<header class="match-preview__header">';

			// Heading
			if ( $title ) {
				echo '<h2 class="match-preview__heading">' . esc_html( $title ) . '</h2>';
			}

			// Event League
			if ( isset( $show_league ) && $show_league ):
				$leagues = get_the_terms( $post->ID, 'sp_league' );
				if ( $leagues ):
					foreach( $leagues as $league ):
						$term = get_term( $league->term_id, 'sp_league' );
						?>
						<h3 class="match-preview__title"><?php echo esc_html( $term->name ); ?></h3>
						<?php
					endforeach;
				endif;
			endif;

			// Event Date
			echo '<time class="match-preview__date" datetime="' . esc_attr( $post_date ) . '">' . mysql2date( get_option( 'date_format' ), $post_date ) . '</time>';

		echo '</header>';
		?>
		<div class="match-preview">
			<section class="match-preview__body">
				<div class="match-preview__content">
					<?php
					$teams = array_unique( (array) get_post_meta( $post->ID, 'sp_team' ) );
					$i = 0;

					if ( is_array( $teams ) ) {
						foreach ( $teams as $team ) {
							$i++;

							if ( has_post_thumbnail ( $team ) ) {
								echo '<div class="match-preview__team match-preview__team--' . ( $i % 2 ? 'odd' : 'even' ) . '">';
									echo '<figure class="match-preview__team-logo">';
										if ( $link_teams ) {
											echo '<a class="team-logo" href="' . get_post_permalink( $team ) . '" title="' . get_the_title( $team ) . '">' . get_the_post_thumbnail( $team, 'alchemists_team-logo-fit' ) . '</a>';
										} else {
											echo get_the_post_thumbnail( $team, 'alchemists_team-logo-fit' );
										}
									echo '</figure>';
									echo '<h5 class="match-preview__team-name">' . esc_html( get_the_title( $team ) ) . '</h5>';
								echo '</div>';
							}
						}

					}
					?>

					<div class="match-preview__vs">
						<div class="match-preview__conj"><?php esc_html_e( 'VS', 'alchemists' ); ?></div>
						<div class="match-preview__match-info">
							<time class="match-preview__match-time" datetime="<?php echo esc_attr( $post_date ); ?>"><?php echo mysql2date( get_option( 'time_format' ), $post_date ); ?></time>

							<?php
							if ( isset( $show_venue ) && $show_venue ):
								$venues = get_the_terms( $post->ID, 'sp_venue' );
								if ( $venues ):
									?>

									<div class="match-preview__match-place">
										<?php
										if ( $link_venues ) {
											the_terms( $post->ID, 'sp_venue' );
										} else {
											$venue_names = array();
											foreach ( $venues as $venue ) {
												$venue_names[] = $venue->name;
											}
											echo implode( '/', $venue_names );
										}
										?>
									</div>

									<?php
								endif;
							endif; ?>

						</div>
					</div>


					<?php $now = new DateTime( current_time( 'mysql', 0 ) );
					$date = new DateTime( $post_date );
					$interval = date_diff( $now, $date );

					$days = $interval->invert ? 0 : $interval->days;
					$h = $interval->invert ? 0 : $interval->h;
					$i = $interval->invert ? 0 : $interval->i;
					$s = $interval->invert ? 0 : $interval->s;
					?>
				</div>

				<?php if ( alchemists_sp_preset( 'basketball' ) ) : ?>
					<div class="match-preview__action">
						<a href="<?php echo get_post_permalink( $post->ID, false, true ); ?>" class="btn btn-default btn-block"><?php esc_html_e( 'Read More', 'alchemists' ); ?></a>
					</div>
				<?php endif; ?>
			</section>

			<?php if ( alchemists_sp_preset( 'basketball' ) ) : ?>
			<section class="match-preview__countdown countdown">
				<h4 class="countdown__title"><?php esc_html_e( 'Game Countdown', 'alchemists' ); ?></h4>
			<?php endif; ?>

				<div class="countdown__content">
					<div class="countdown sp-countdown<?php if ( $days >= 10 ): ?> long-countdown<?php endif; ?>">
						<time class="countdown-counter" datetime="<?php echo esc_attr( $post_date ); ?>"<?php if ( $live ): ?> data-countdown="<?php echo str_replace( '-', '/', $post_date ); ?>"<?php endif; ?>>
							<span><?php echo sprintf( '%02s', $days ); ?> <small><?php esc_html_e( 'days', 'alchemists' ); ?></small></span>
							<span><?php echo sprintf( '%02s', $h ); ?> <small><?php esc_html_e( 'hrs', 'alchemists' ); ?></small></span>
							<span><?php echo sprintf( '%02s', $i ); ?> <small><?php esc_html_e( 'mins', 'alchemists' ); ?></small></span>
							<span><?php echo sprintf( '%02s', $s ); ?> <small><?php esc_html_e( 'secs', 'alchemists' ); ?></small></span>
						</time>
					</div>
				</div>

			<?php if ( alchemists_sp_preset( 'basketball' ) ) : ?>
			</section>
			<?php endif; ?>

			<?php if ( alchemists_sp_preset( 'soccer' ) ) : ?>
				<div class="match-preview__action match-preview__action--ticket">
					<a href="<?php echo get_post_permalink( $post->ID, false, true ); ?>" class="btn btn-primary-inverse btn-lg btn-block"><?php esc_html_e( 'Read More', 'alchemists' ); ?></a>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>
