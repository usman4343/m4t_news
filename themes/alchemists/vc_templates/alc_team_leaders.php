<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $player_lists_id
 * @var $values
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Alc_Team_Leaders
 */

// Theme Options
$alchemists_data = get_option('alchemists_data');
$color_primary = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';

$title = $player_lists_id = $values = $el_class = $el_id = $css = $css_animation = '';

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'widget card card--has-table widget-leaders';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$values = (array) vc_param_group_parse_atts( $values );
$values_array = array();
foreach ($values as $data) {
	$new_stat = $data;
	$new_stat['stat_heading'] = isset( $data['stat_heading'] ) ? $data['stat_heading'] : '';
	$new_stat['stat_value'] = isset( $data['stat_value'] ) ? $data['stat_value'] : '';
	$new_stat['stat_avg'] = isset( $data['stat_avg'] ) ? $data['stat_avg'] : '';
	$new_stat['stat_number'] = isset( $data['stat_number'] ) ? $data['stat_number'] : 1;

	$values_array[] = $new_stat;
}

$list = new SP_Player_List( $player_lists_id );
$data = $list->data();

// Remove the first row to leave us with the actual data
unset( $data[0] );

?>



<!-- Widget: Team Leaders -->
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">
	<?php if ( $title ) { ?>
		<div class="widget__title card__header">
			<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>
		</div>
	<?php } ?>
	<div class="widget__content card__content">


		<?php if (!empty($values_array)): ?>
			<?php
				$counter = 0;

				foreach ( $values_array as $stat_item ) :
					if( !empty($stat_item['stat_value']) ) :

					$counter++;

					$performances = get_post($stat_item['stat_value']);
					$performance = $performances->post_name;

					$stats_avg = get_post($stat_item['stat_avg']);
					$stat_avg = $stats_avg->post_name;

					$priorities[$counter] = $list;
					$priorities[$counter]->priorities = array(
						array(
							'key' => $performance,
							'order' => 'DESC',
						),
					);

					$data_new[$counter] = $data;

					uasort( $data_new[$counter], array( $priorities[$counter], 'sort' ) );

					// display array of players
					$data_new[$counter] = array_slice( $data_new[$counter], 0, $stat_item['stat_number'], true );
					$players_array = $data_new[$counter];

					// slice a top player with highest stats
					$player_top = array_slice( $data_new[$counter], 0, 1, true );
					$player_top = current($player_top);
					$player_top_value = $player_top[$stat_avg];

					?>
					<!-- Leader: <?php echo $stat_item['stat_heading']; ?> -->
					<div class="table-responsive">
						<table class="table team-leader">
							<thead>
								<tr>
									<th class="team-leader__type"><?php echo esc_html( $stat_item['stat_heading'] ); ?></th>
									<th class="team-leader__total"><?php esc_html_e( 'T', 'alchemists' ); ?></th>
									<th class="team-leader__gp"><?php esc_html_e( 'GP', 'alchemists' ); ?></th>
									<th class="team-leader__avg"><?php esc_html_e( 'AVG', 'alchemists' ); ?></th>
								</tr>
							</thead>
							<tbody>

								<?php foreach ( $players_array as $player_id => $player ) :

									// Player Photo
									if ( has_post_thumbnail( $player_id ) ) {
										$player_image = get_the_post_thumbnail( $player_id, 'alchemists_player-xxs' );
									} else {
										$player_image = '<img src="' . get_template_directory_uri() . '/assets/images/player-placeholder-200x200.jpg" alt="">';
									}

									// Player Position
									$positions = wp_get_post_terms( $player_id, 'sp_position' );
									$player_position = false;
									if( $positions ) {
										$player_position = $positions[0]->name;
									}

									// Player Name
									$title = get_the_title( $player_id );

									// Player Link
									$player_url = get_the_permalink( $player_id );

									// Player Name
									$player_name = $player['name'];

									// Player Circular Bar
									if ( $player_top_value > 0 ) {
										$circular_percent = $player[$stat_avg] / $player_top_value * 100;
									} else {
										$circular_percent = 0;
									}

									?>
									<tr>
										<td class="team-leader__player">
											<div class="team-leader__player-info">
												<figure class="team-leader__player-img">
													<a href="<?php echo esc_url( $player_url ); ?>">
														<?php echo wp_kses_post( $player_image ); ?>
													</a>
												</figure>
												<div class="team-leader__player-inner">
													<h5 class="team-leader__player-name">
														<a href="<?php echo esc_url( $player_url ); ?>"><?php echo wp_kses_post( $player_name ); ?></a>
													</h5>
													<?php if ( $player_position ) : ?>
													<span class="team-leader__player-position"><?php echo esc_html( $player_position ); ?></span>
													<?php endif; ?>
												</div>
											</div>
										</td>
										<td class="team-leader__total">
											<?php if ( $player[$performance] == 'reb' ) {
												echo esc_html( $player['off'] + $player['def'] );
											} else {
												echo esc_html( $player[$performance] );
											} ?>
										</td>
										<td class="team-leader__gp"><?php echo esc_html( $player['eventsplayed'] ); ?></td>
										<td class="team-leader__avg">
											<div class="circular">
												<div class="circular__bar" data-percent="<?php echo esc_attr( $circular_percent ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
													<span class="circular__percents">
														<?php echo esc_html( number_format( $player[$stat_avg], 1 ) );?>
													</span>
												</div>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>

							</tbody>
						</table>
					</div>
					<!-- Leader: <?php echo $stat_item['stat_heading']; ?> / End -->

				<?php endif;
			endforeach;
		endif; ?>

	</div>
</div>
<!-- Widget: Team Leaders / End -->
