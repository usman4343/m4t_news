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
  'title' => esc_html__( 'Schedule', 'alchemists' ),
  'order' => 'ASC',
  'time_format' => 'time',
  'status' => 'future',
  'columns' => array(
    'event',
    'teams',
    'time',
    'league',
    'season',
    'venue',
  ),
));
