<?php
/**
 * The template for displaying Single Team
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Theme Options
$alchemists_data = get_option('alchemists_data');
$color_primary = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';

$roster_type_get = isset( $_GET['roster_type'] ) ? $_GET['roster_type'] : '';
$roster_type = get_field( 'gallery_roster_type' );

// to-do: add option to select number on the team page
$columns = 3;

$roster = 'gallery';
 if ( $roster_type_get === 'blocks' || $roster_type === 'blocks' ) {
	$roster = 'blocks';
} elseif ( $roster_type_get === 'cards' || $roster_type === 'cards' ) {
	$roster = 'cards';
} elseif ( $roster_type_get === 'slider' || $roster_type === 'slider' ) {
	if ( alchemists_sp_preset( 'soccer') ) {
		$roster = 'slider-card';
	} else {
		$roster = 'slider';
	}
}

// Gallery Roster
$gallery_roster_on   = get_field('gallery_roster_show');
$gallery_roster      = get_field('gallery_roster');
$gallery_roster_id   = '';

// List Roster
$list_roster_on       = get_field('list_roster_show');
$list_roster          = get_field('list_roster');
$list_roster_id       = '';

// Featured
$featured_player_on   = get_field('featured_player');
$featured_player      = get_field('team_featured_player');
$featured_player_args = array();

// Featured Player
$featured_player_args = array(
	'post_type'      => 'sp_player',
	'p'              => $featured_player,
	'posts_per_page' => 1,
);

if ( $featured_player_on ) {
	$list_roster_width = 'col-md-8';
} else {
	$list_roster_width = 'col-md-12';
}

?>


<?php // Display Gallery Roster
if ( $gallery_roster_on && $gallery_roster ) {
	$gallery_roster_id = $gallery_roster->ID;
	sp_get_template( 'player-' . $roster . '.php', array(
		'id'      => $gallery_roster_id,
		'columns' => $columns,
	) );
} ?>

<div class="row">
	<div class="<?php echo esc_attr( $list_roster_width ); ?>">
		<?php // Display List Roster
		if ( $gallery_roster_on && $list_roster ) {
			$list_roster_id = $list_roster->ID;
			sp_get_template( 'player-list.php', array(
				'id'      => $list_roster_id,
				'rows'    => 11,
			) );
		} ?>
	</div>

	<?php if ( $featured_player_on && $featured_player ) : ?>
	<div class="col-md-4">

		<?php

		$loop = new WP_Query( $featured_player_args );
		while ( $loop->have_posts() ) : $loop->the_post();

			$player_id = $featured_player;

			$player = new SP_Player( $player_id );
			$data = $player->data( 0, false );
			unset( $data[0] );
			$data = $data[-1]; // Get Total array

			// Player Image (Alt)
			$player_image_head  = get_field('heading_player_photo');
			$player_image_size  = 'alchemists_thumbnail-player-sm';
			if( $player_image_head ) {
				$image_url = wp_get_attachment_image( $player_image_head, $player_image_size );
			} else {
				$image_url = '<img src="' . get_template_directory_uri() . '/assets/images/player-single-placeholder-189x198.png' . '" alt="" />';
			}

			// Player Team Logo
			$sp_current_teams = get_post_meta($id,'sp_current_team');
			$sp_current_team = '';
			if( !empty($sp_current_teams[0]) ) {
				$sp_current_team = $sp_current_teams[0];
			}

			// Player Name
			$title      = get_the_title( $player_id );
			$player_url = get_the_permalink( $player_id );

			// Player Number
			$player_number = get_post_meta( $player_id, 'sp_number', true );

			// Player Position(s)
			$positions = wp_get_post_terms( $player_id, 'sp_position');
			$position = false;
			if( $positions ) {
				$position = $positions[0]->name;
			}

			// echo '<pre>' . var_export($data, true) . '</pre>';
			?>

			<?php
			// Sport: Soccer
			if ( alchemists_sp_preset( 'soccer' ) ) : ?>

			<?php
			// Player Stats
			$goals       = isset( $data['goals'] ) ? $data['goals'] : esc_html__( 'n/a', 'alchemists' );
			$shots       = isset( $data['sh'] ) ? $data['sh'] : esc_html__( 'n/a', 'alchemists' );
			$assists     = isset( $data['assists'] ) ? $data['assists'] : esc_html__( 'n/a', 'alchemists' );
			$appearances = isset( $data['appearances'] ) ? $data['appearances'] : esc_html__( 'n/a', 'alchemists' );

			// bars
			$shpercent   = isset( $data['shpercent'] ) ? $data['shpercent'] : '';
			$passpercent = isset( $data['passpercent'] ) ? $data['passpercent'] : '';

			// Player Detailed Stats
			$yellowcards     = isset( $data['yellowcards'] ) ? $data['yellowcards'] : esc_html__( 'n/a', 'alchemists' );
			$redcards        = isset( $data['redcards'] ) ? $data['redcards'] : esc_html__( 'n/a', 'alchemists' );
			$shots_on_target = isset( $data['sog'] ) ? $data['sog'] : esc_html__( 'n/a', 'alchemists' );
			$pka             = isset( $data['pka'] ) ? $data['pka'] : esc_html__( 'n/a', 'alchemists' );
			$pkg             = isset( $data['pkg'] ) ? $data['pkg'] : esc_html__( 'n/a', 'alchemists' );
			$drb             = isset( $data['drb'] ) ? $data['drb'] : esc_html__( 'n/a', 'alchemists' );
			$fouls           = isset( $data['f'] ) ? $data['f'] : esc_html__( 'n/a', 'alchemists' );
			$off             = isset( $data['off'] ) ? $data['off'] : esc_html__( 'n/a', 'alchemists' );

			?>
			<!-- Widget: Featured Player - Alternative Extended -->
			<div class="widget card widget-player widget-player--soccer">
				<div class="widget__title card__header">
					<h4><?php esc_html_e( 'Featured Player', 'alchemists' ); ?></h4>
				</div>
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
							<?php echo wp_kses_post( $title ); ?>
						</h4>
					</header>

					<div class="widget-player__content">

						<div class="widget-player__content-inner">
							<div class="widget-player__stat widget-player__goals">
								<div class="widget-player__stat-number"><?php echo esc_html( $goals ); ?></div>
								<h6 class="widget-player__stat-label"><?php esc_html_e( 'Goals', 'alchemists' ); ?></h6>
							</div>
							<div class="widget-player__stat widget-player__shots">
								<div class="widget-player__stat-number"><?php echo esc_html( $shots ); ?></div>
								<h6 class="widget-player__stat-label"><?php esc_html_e( 'Shots', 'alchemists' ); ?></h6>
							</div>
							<div class="widget-player__stat widget-player__assists">
								<div class="widget-player__stat-number"><?php echo esc_html( $assists ); ?></div>
								<h6 class="widget-player__stat-label"><?php esc_html_e( 'Assists', 'alchemists' ); ?></h6>
							</div>
							<div class="widget-player__stat widget-player__games">
								<div class="widget-player__stat-number"><?php echo esc_html( $appearances ); ?></div>
								<h6 class="widget-player__stat-label"><?php esc_html_e( 'Games', 'alchemists' ); ?></h6>
							</div>
						</div>

						<div class="widget-player__content-alt">
							<?php if ( $shpercent ) : ?>
							<!-- Progress: Shot Accuracy -->
							<div class="progress-stats">
								<div class="progress__label"><?php esc_html_e( 'SHOT ACC', 'alchemists' ); ?></div>
								<div class="progress">
									<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $shpercent ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $shpercent ); ?>%"></div>
								</div>
								<div class="progress__number"><?php echo esc_html( $shpercent ); ?>%</div>
							</div>
							<!-- Progress: Shot Accuracy / End -->
							<?php endif; ?>

							<?php if ( $passpercent ) : ?>
							<!-- Progress: Pass Accuracy -->
							<div class="progress-stats">
								<div class="progress__label"><?php esc_html_e( 'PASS ACC', 'alchemists' ); ?></div>
								<div class="progress">
									<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $passpercent ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $passpercent ); ?>%"></div>
								</div>
								<div class="progress__number"><?php echo esc_html( $passpercent ); ?>%</div>
							</div>
							<!-- Progress: Pass Accuracy / End -->
							<?php endif; ?>
						</div>


					</div>
				</div>

				<div class="widget__content-secondary">

					<!-- Player Details -->
					<div class="widget-player__details">

						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Goals', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $goals ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Assists', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $assists ); ?></span>
							</div>
						</div>

						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Shots', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $shots ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Shots on Target', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $shots_on_target ); ?></span>
							</div>
						</div>

						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'P.Kick Attempts', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $pka ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'P.Kick Goals', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $pkg ); ?></span>
							</div>
						</div>

						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Dribbles', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $drb ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Fouls', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $fouls ); ?></span>
							</div>
						</div>

						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Offsides', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $off ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Games Played', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $appearances ); ?></span>
							</div>
						</div>

						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Yellow Cards', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $yellowcards ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Red Cards', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $redcards ); ?></span>
							</div>
						</div>

					</div>
					<!-- Player Details / End -->

				</div>

				<div class="widget__content-tertiary widget__content--bottom-decor">
					<div class="widget__content-inner"></div>
				</div>
			</div>
			<!-- Widget: Featured Player - Alternative Extended / End -->

			<?php else : ?>

			<?php
			// Sport: Basketball

			// Player Stats
			$ppg = isset( $data['ppg'] ) ? esc_html( $data['ppg'] ) : esc_html__( 'n/a', 'alchemists' );
			$apg = isset( $data['apg'] ) ? esc_html( $data['apg'] ) : esc_html__( 'n/a', 'alchemists' );
			$rpg = isset( $data['rpg'] ) ? esc_html( $data['rpg'] ) : esc_html__( 'n/a', 'alchemists' );

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

			$fgpercent     = isset( $data['fgpercent'] ) ? esc_html( $data['fgpercent'] ) : 0;
			$ftpercent     = isset( $data['ftpercent'] ) ? esc_html( $data['ftpercent'] ) : 0;
			$threeppercent = isset( $data['threeppercent'] ) ? esc_html( $data['threeppercent'] ) : 0;

			?>
			<!-- Widget: Featured Player - Alternative Extended -->
			<div class="widget card widget--sidebar widget-player widget-player--alt">
				<div class="widget__title card__header">
					<h4><?php esc_html_e( 'Featured Player', 'alchemists' ); ?></h4>
				</div>
				<div class="widget__content card__content widget-player__inner">

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
							<?php echo wp_kses_post( $title ); ?>
						</h4>
					</header>

					<div class="widget-player__content">
						<div class="widget-player__content-inner">
							<div class="widget-player__stat widget-player__points">
								<h6 class="widget-player__stat-label"><?php esc_html_e( 'Points', 'alchemists' ); ?></h6>
								<div class="widget-player__stat-number"><?php echo esc_html( $ppg ); ?></div>
								<div class="widget-player__stat-legend"><?php esc_html_e( 'AVG', 'alchemists' ); ?></div>
							</div>
							<div class="widget-player__stat widget-player__assists">
								<h6 class="widget-player__stat-label"><?php esc_html_e( 'Assists', 'alchemists' ); ?></h6>
								<div class="widget-player__stat-number"><?php echo esc_html( $apg ); ?></div>
								<div class="widget-player__stat-legend"><?php esc_html_e( 'AVG', 'alchemists' ); ?></div>
							</div>
							<div class="widget-player__stat widget-player__rebounds">
								<h6 class="widget-player__stat-label"><?php esc_html_e( 'Rebs', 'alchemists' ); ?></h6>
								<div class="widget-player__stat-number"><?php echo esc_html( $rpg ); ?></div>
								<div class="widget-player__stat-legend"><?php esc_html_e( 'AVG', 'alchemists' ); ?></div>
							</div>
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
				<div class="widget__content-secondary">

					<!-- Player Details -->
					<div class="widget-player__details">

						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( '2 Points', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $twopm ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( '3 Points', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $threepm ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Rebounds', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $rebs ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Assists', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $ast ); ?></span>
							</div>
						</div>

						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Steals', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $stl ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Blocks', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $blk ); ?></span>
							</div>
						</div>

						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Fouls', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $pf ); ?></span>
							</div>
						</div>
						<div class="widget-player__details__item">
							<div class="widget-player__details-desc-wrapper">
								<span class="widget-player__details-holder">
									<span class="widget-player__details-label"><?php esc_html_e( 'Games Played', 'alchemists' ); ?></span>
									<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
								</span>
								<span class="widget-player__details-value"><?php echo esc_html( $gp ); ?></span>
							</div>
						</div>

					</div>
					<!-- Player Details / End -->

				</div>

				<div class="widget__content-tertiary widget__content--bottom-decor">
					<div class="widget__content-inner">
						<div class="widget-player__stats row">
							<div class="col-xs-4">
								<div class="widget-player__stat-item">
									<div class="widget-player__stat-circular circular">
										<div class="circular__bar" data-percent="<?php echo esc_attr( $fgpercent ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
											<span class="circular__percents"><?php echo esc_html( number_format( $fgpercent, 1 ) ); ?><small>%</small></span>
										</div>
										<span class="circular__label"><?php echo wp_kses_post(__( 'Shot<br> Accuracy', 'alchemists' ) ); ?></span>
									</div>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="widget-player__stat-item">
									<div class="widget-player__stat-circular circular">
										<div class="circular__bar" data-percent="<?php echo esc_attr( $ftpercent ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
											<span class="circular__percents"><?php echo esc_html( number_format( $ftpercent, 1 ) ); ?><small>%</small></span>
										</div>
										<span class="circular__label"><?php echo wp_kses_post(__( 'Free Throw<br> Accuracy', 'alchemists' ) ); ?></span>
									</div>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="widget-player__stat-item">
									<div class="widget-player__stat-circular circular">
										<div class="circular__bar" data-percent="<?php echo esc_attr( $threeppercent ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
											<span class="circular__percents"><?php echo esc_html( number_format( $threeppercent, 1 ) ); ?><small>%</small></span>
										</div>
										<span class="circular__label"><?php echo wp_kses_post(__( '3 Points<br> Accuracy', 'alchemists' ) ); ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Widget: Featured Player - Alternative Extended / End -->
			<?php endif; ?>

			<?php

		endwhile;

		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata(); ?>

	</div>
	<?php endif; ?>

</div>
