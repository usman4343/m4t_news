<?php
/**
 * The template for displaying Single Team
 *
 * @package Alchemists
 */
?>

<?php
/**
 * The template for displaying Single Team
 *
 * @package Alchemists
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! isset( $id ) )
	$id = get_the_ID();


sp_get_template( 'event-list.php', array(
  'team' => $id,
  'title' => esc_html__( 'Latest Results', 'alchemists' ),
  'order' => 'DESC',
  'status' => 'publish',
  'time_format' => 'results',
  'columns' => array(
    'event',
    'teams',
    'results',
    'league',
    'season',
    'venue',
  ),
));
