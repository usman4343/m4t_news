<?php
/**
 * Player Slider Thumbnail
 *
 * @author 		Dan Fisher
 * @package 	Alchemists
 * @version   2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$defaults = array(
	'id' => null,
	'link_posts' => get_option( 'sportspress_link_players', 'yes' ) == 'yes' ? true : false,
);

extract( $defaults, EXTR_SKIP );

$player = new SP_Player( $id );
$player_data = $player->data(0);

unset( $player_data[0] );
$player_data = $player_data[-1]; // Get Total array


// echo '<pre>' . var_export( $player_data, true ) . '</pre>';

// Player Number
$player_number = get_post_meta( $id, 'sp_number', true );
if ( '' == $player_number ) {
	$player_number = "-";
}

// Player Position
$player_position = get_the_term_list( $id, 'sp_position', '', ', ', '');

$caption_class = 'team-roster__player-name--no-link';
if ( $link_posts ) {
	$caption = '<a href="' . get_permalink( $id ) . '">' . $caption . '</a>';
	$caption_class = 'team-roster__player-name--has-link';
}

// Player Background Image
if ( has_post_thumbnail( $id ) ) {
	$player_thumbnail = 'style="background-image:url('. get_the_post_thumbnail_url( $id, 'alchemists_thumbnail-player-lg-fit' ) .')"';
} else {
	$player_thumbnail = '';
}

// Player Image (Alt)
$player_image_head  = get_post_meta( $id, 'heading_player_photo', true );
$player_image_size  = 'alchemists_thumbnail-player-lg-fit';
if( $player_image_head ) {
	$image_url = wp_get_attachment_image( $player_image_head, $player_image_size );
} else {
	$image_url = '<img src="' . get_template_directory_uri() . '/assets/images/player-single-370x400.png' . '" alt="" />';
}

// Player Excerpt
$player_excerpt = get_the_excerpt( $id );

// Player Bars
$shpercent   = isset( $player_data['shpercent'] ) ? $player_data['shpercent'] : '';
$passpercent = isset( $player_data['passpercent'] ) ? $player_data['passpercent'] : '';
$performance = isset( $player_data['perf'] ) ? $player_data['perf'] : '';

// Player Aside Stats
$goals   = isset( $player_data['goals'] ) ? $player_data['goals'] : esc_html__( 'n/a', 'alchemists' );
$gmp     = isset( $player_data['appearances'] ) ? $player_data['appearances'] : esc_html__( 'n/a', 'alchemists' );
$assists = isset( $player_data['assists'] ) ? $player_data['assists'] : esc_html__( 'n/a', 'alchemists' );
$drb     = isset( $player_data['drb'] ) ? $player_data['drb'] : esc_html__( 'n/a', 'alchemists' );

echo '<div class="team-roster__item card card--no-paddings">';

	echo '<div class="card__content">';
		echo '<div class="team-roster__content-wrapper">';

			echo '<figure class="team-roster__player-img">';
				echo '<div class="team-roster__player-shape">';
					echo '<div class="team-roster__player-shape-inner" ' . $player_thumbnail . '></div>';
				echo '</div>';
				echo wp_kses_post( $image_url );
			echo '</figure>';

			echo '<div class="team-roster__content">';

				echo '<div class="team-roster__player-details">';
					echo '<div class="team-roster__player-number">' . esc_html( $player_number ) . '</div>';
					echo '<div class="team-roster__player-info">';
						echo '<h3 class="team-roster__player-name ' . esc_attr( $caption_class ) . '">' . $caption . '</h3>';
					echo '</div>';
				echo '</div>';

				echo '<div class="team-roster__player-excerpt">';
					echo $player_excerpt;
				echo '</div>';

				echo '<div class="team-roster__player-stats">';

					if ( !empty( $shpercent )) :
						echo '<div class="progress-stats mb-20">';
							echo '<div class="progress__label progress__label--color-default">' . esc_html( 'Shot Accuracy', 'alchemists' ) .'</div>';
							echo '<div class="progress">';
								echo '<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="' . esc_attr( $shpercent ) . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . esc_attr( $shpercent ) . '%"></div>';
							echo '</div>';
							echo '<div class="progress__number progress__number--color-highlight">' . esc_attr( $shpercent ) . '%</div>';
						echo '</div>';
					endif;

					if ( !empty( $passpercent )) :
						echo '<div class="progress-stats mb-20">';
							echo '<div class="progress__label progress__label--color-default">' . esc_html( 'Pass Accuracy', 'alchemists' ) .'</div>';
							echo '<div class="progress">';
								echo '<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="' . esc_attr( $passpercent ) . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . esc_attr( $passpercent ) . '%"></div>';
							echo '</div>';
							echo '<div class="progress__number progress__number--color-highlight">' . esc_attr( $passpercent ) . '%</div>';
						echo '</div>';
					endif;

					if ( !empty( $performance )) :
						echo '<div class="progress-stats mb-20">';
							echo '<div class="progress__label progress__label--color-default">' . esc_html( 'Performance', 'alchemists' ) .'</div>';
							echo '<div class="progress">';
								echo '<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="' . esc_attr( $performance ) . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . esc_attr( $performance ) . '%"></div>';
							echo '</div>';
							echo '<div class="progress__number progress__number--color-highlight">' . esc_attr( $performance ) . '%</div>';
						echo '</div>';
					endif;

				echo '</div>';

				echo '<footer class="team-roster__player-footer">';
					echo '<a href="' . get_permalink( $id ) . '" class="btn btn-primary-inverse">' . esc_html( 'Read Full Bio', 'alchemists' ) . '</a>';
				echo '</footer>';

			echo '</div>';

			echo '<aside class="team-roster__meta">';
				echo '<div class="team-roster__meta-item team-roster__meta-item--lg">';
					echo '<div class="team-roster__meta-value">' . $goals . '</div>';
					echo '<div class="team-roster__meta-label">' . esc_html( 'Goals', 'alchemists' ) . '</div>';
				echo '</div>';

				echo '<div class="team-roster__meta-item">';
					echo '<div class="team-roster__meta-value">' . $gmp . '</div>';
					echo '<div class="team-roster__meta-label">' . esc_html( 'Games', 'alchemists' ) . '</div>';
				echo '</div>';

				echo '<div class="team-roster__meta-item">';
					echo '<div class="team-roster__meta-value">' . $assists . '</div>';
					echo '<div class="team-roster__meta-label">' . esc_html( 'Assists', 'alchemists' ) . '</div>';
				echo '</div>';

				echo '<div class="team-roster__meta-item">';
					echo '<div class="team-roster__meta-value">' . $drb . '</div>';
					echo '<div class="team-roster__meta-label">' . esc_html( 'Dribbles', 'alchemists' ) . '</div>';
				echo '</div>';

			echo '</aside>';

		echo '</div>';
	echo '</div>';

echo '</div>';
