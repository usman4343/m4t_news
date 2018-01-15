<?php
/**
 * Birthdays
 *
 * @author 		ThemeBoy
 * @package 	SportsPress_Birthdays
 * @version   1.9.19
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$defaults = array(
	'date' => 'day',
	'size' => 'alchemists_player-xxs',
	'show_player_birthday' => get_option( 'sportspress_player_show_birthday', 'no' ) == 'yes' ? true : false,
	'show_staff_birthday' => get_option( 'sportspress_staff_show_birthday', 'no' ) == 'yes' ? true : false,
	'link_players' => get_option( 'sportspress_link_players', 'yes' ) == 'yes' ? true : false,
	'link_staff' => get_option( 'sportspress_link_staff', 'yes' ) == 'yes' ? true : false,
);

extract( $defaults, EXTR_SKIP );

$args = array(
	'post_type' => array( 'sp_player', 'sp_staff' ),
	'numberposts' => -1,
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'ASC',
	'monthnum' => date('n'),
);

if ( $date == 'day' ) {
	$args['day'] = date('j');
}

$posts = get_posts( $args );

echo '<div class="table-responsive">';
	echo '<table class="table alc-birthdays">';

		// echo '<thead>';
		//   echo '<tr>';
		//     echo '<th class="alc-birthdays__item alc-birthdays__item--name">' . esc_html__( 'Name', 'alchemists' ) . '</th>';
		//     echo '<th class="alc-birthdays__item alc-birthdays__item--date">' . esc_html__( 'Date', 'alchemists' ) . '</th>';
		//   echo '</tr>';
		// echo '</thead>';

		echo '<tbody>';
			foreach ( $posts as $post ) {
				echo '<tr>';
					echo '<td class="alc-birthdays__item-container">';

						if ( 'sp_staff' == $post->post_type ) {
							$link_posts    = $link_staff;
							$show_birthday = $show_staff_birthday;
							$position      = get_the_term_list( $post->ID, 'sp_role', '', ', ', '');

						} else {
							$link_posts    = $link_players;
							$show_birthday = $show_player_birthday;
							$position      = get_the_term_list( $post->ID, 'sp_position', '', ', ', '');
						}

						// date
						$birthday = get_the_date( get_option( 'date_format') , $post->ID );

						// name
						$caption = $post->post_title;
						$caption = trim( $caption );

						sp_get_template( 'player-birthday.php', array(
							'id'         => $post->ID,
							'size'       => $size,
							'caption'    => $caption,
							'position'   => $position,
							'link_posts' => $link_posts,
						) );

					echo '</td>';

					if ( $show_birthday && $birthday ) {
						echo '<td class="alc-birthdays__item alc-birthdays__item--date">' . $birthday . '</td>';
					}

				echo '</tr>';
			}
		echo '</tbody>';

	echo '</table>';
echo '</div>';
