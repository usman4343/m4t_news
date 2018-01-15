<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $team_id
 * @var $league_table_id
 * @var $values
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Alc_Team_Stats
 */

$title = $team_id = $league_table_id = $values = $el_class = $el_id = $css = $css_animation = '';

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'widget card card--has-table widget-team-stats';
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
	$new_stat['stat_icon'] = isset( $data['stat_icon'] ) ? $data['stat_icon'] : '';
	$new_stat['stat_icon_symbol'] = isset( $data['stat_icon_symbol'] ) ? $data['stat_icon_symbol'] : '';

	$values_array[] = $new_stat;
}

// Check if we're on Single Team page and Team is not selected
if ( is_singular('sp_team') && $team_id == 'default' ) {
	if ( ! isset( $id ) ) {
		$id = get_the_ID();
	}
} else {
	$id = intval($team_id);
}

// Select the Team
$team = new SP_Team( $id );
$tables = $team->tables();
$table_id = intval($league_table_id);

// Jump into League Table data
$table = new SP_League_Table( $table_id );
$data = $table->data();

// Remove the first row to leave us with the actual data
unset( $data[0] );
?>

<!-- Widget: Team Stats -->
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">
	<?php if ( $title ) { ?>
		<div class="widget__title card__header">
			<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>
		</div>
	<?php } ?>
	<div class="widget__content card__content">
		<ul class="team-stats-box">
			<?php if (!empty($values_array)) : ?>
				<?php foreach ( $values_array as $stat_item ) : ?>
					<?php if( !empty($stat_item['stat_value']) ) : ?>
						<?php
						// values
						$stats = get_post($stat_item['stat_value']);
						$stat = $stats->post_name; ?>

						<?php if ( isset( $data[$id][$stat] ) ) : ?>

							<?php
							$stat_value = strip_tags($data[$id][$stat]);

							// label
							$stat_label = $stat_item['stat_heading'];

							// icon
							$stat_icon = $stat_item['stat_icon'];
							?>

							<?php if ( alchemists_sp_preset( 'soccer') ) : ?>

							<?php
							// Soccer

							$stat_icon_class = "";

							if ( $stat_icon == 'icon_2' ) {
								$stat_icon_class = "team-stats__icon--shots-ot";
								$stat_icon = '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-ball.svg" class="team-stats__icon-primary" alt="">';
								$stat_icon .= '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-gate.svg" class="team-stats__icon-secondary" alt="">';
							} elseif ( $stat_icon == 'icon_3' ) {
								$stat_icon_class = "team-stats__icon--shots";
								$stat_icon = '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-ball.svg" class="team-stats__icon-primary" alt="">';
								$stat_icon .= '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-shots.svg" class="team-stats__icon-secondary" alt="">';
							} elseif ( $stat_icon == 'icon_custom' ) {
								// icon symbol
								$stat_icon_symbol = $stat_item['stat_icon_symbol'];
								$stat_icon_class = "team-stats__icon--assists";
								$stat_icon = '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-ball.svg" class="team-stats__icon-primary" alt="">';
								$stat_icon .= '<span class="team-stats__icon-secondary">' .  $stat_item['stat_icon_symbol'] . '</span>';
							} else {
								$stat_icon = '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-ball.svg" class="team-stats__icon-primary" alt="">';
							} ?>

							<li class="team-stats__item team-stats__item--clean">
								<div class="team-stats__icon team-stats__icon--circle <?php echo esc_attr( $stat_icon_class ); ?>">
									<?php echo $stat_icon; ?>
								</div>
								<div class="team-stats__value"><?php echo esc_html( $stat_value ); ?></div>
								<div class="team-stats__label"><?php echo esc_html( $stat_label ); ?></div>
							</li>

							<?php else : ?>

							<?php
							// Basketball
							if ( $stat_icon == 'icon_2' ) {
								$stat_icon = '<svg role="img" class="df-icon df-icon--apg"><use xlink:href="' . get_template_directory_uri() . '/assets/images/icons-basket.svg#assists-per-game"/></svg>';
							} elseif ( $stat_icon == 'icon_3' ) {
								$stat_icon = '<svg role="img" class="df-icon df-icon--rpg"><use xlink:href="' . get_template_directory_uri() . '/assets/images/icons-basket.svg#rebounds-per-game"/></svg>';
							} elseif ( $stat_icon == 'icon_custom' ) {
								// icon symbol
								$stat_icon_symbol = $stat_item['stat_icon_symbol'];

								$stat_icon = '<div class="df-icon-stack df-icon-stack--3pts"><svg role="img" class="df-icon df-icon--basketball"><use xlink:href="' . get_template_directory_uri() . '/assets/images/icons-basket.svg#basketball"></use></svg><div class="df-icon--txt">' . esc_html( $stat_icon_symbol ) . '</div></div>';
							} else {
								$stat_icon = '<svg role="img" class="df-icon df-icon--ppg"><use xlink:href="' . get_template_directory_uri() . '/assets/images/icons-basket.svg#points-per-game"/></svg>';
							} ?>

							<li class="team-stats__item">
								<div class="team-stats__icon">
									<?php echo $stat_icon; ?>
								</div>
								<div class="team-stats__value"><?php echo esc_html( $stat_value ); ?></div>
								<div class="team-stats__label"><?php echo esc_html( $stat_label ); ?></div>
							</li>

							<?php endif; ?>
						<?php endif; ?>

					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</div>
<!-- Widget: Team Stats / End -->
