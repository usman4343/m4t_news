<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $caption
 * @var $calendar
 * @var $player_id
 * @var $player_stats
 * @var $number
 * @var $order
 * @var $show_all_events_link
 * Shortcode class
 * @var $this WPBakeryShortCode_Alc_Player_Gbg_Stats
 */

$caption = $calendar = $player_id = $player_stats = $number = $order = $show_all_events_link = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Hide Show All Events button if all calendars displayed
if ( $calendar == 'all' ) {
	$show_all_events_link = 0;
}

// Check if we're on a Single Player page and Player is not selected
if ( is_singular('sp_player') && $player_id == 'default' ) {
	$player_id = get_the_ID();
}

// Get player's current team
$teams = get_post_meta( $player_id, 'sp_current_team' );
$team = 'default';
if( !empty($teams[0]) ) {
	$team = $teams[0];
}

sp_get_template( 'player-event-game-by-game.php', array(
	'id'                   => $calendar,
	'title'                => $title,
	'status'               => 'publish',
	'date'                 => 'default',
	'date_from'            => 'default',
	'date_to'              => 'default',
	'day'                  => 'default',
	'number'               => $number,
	'order'                => $order,
	'show_all_events_link' => $show_all_events_link,
	'team'                 => $team,
	'player_id'            => $player_id,
	'player_stats'         => $player_stats,
));
