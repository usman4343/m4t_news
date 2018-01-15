<?php
/**
 * Game Result
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   2.2.0
 */


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}


/**
 * Widget class.
 */

class Alchemists_Widget_Event_Result extends WP_Widget {


	/**
	 * Constructor.
	 *
	 * @access public
	 */
	function __construct() {

		$widget_ops = array(
			'classname' => 'widget-game-result',
			'description' => esc_html__( 'Display event results.', 'alchemists' ),
		);
		$control_ops = array(
			'id_base' => 'widget-game-result'
		);

		parent::__construct( 'widget-game-result', 'ALC: Event Results', $widget_ops, $control_ops );

	}


	/**
	 * Outputs the widget content.
	 */

	function widget( $args, $instance ) {

		extract( $args );

		$id = empty($instance['id']) ? null : $instance['id'];

		$title                = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$caption              = empty($instance['caption']) ? null : $instance['caption'];
		$date                 = empty($instance['date']) ? 'default' : $instance['date'];
		$date_from            = empty($instance['date_from']) ? 'default' : $instance['date_from'];
		$date_to              = empty($instance['date_to']) ? 'default' : $instance['date_to'];
		$day                  = empty($instance['day']) ? 'default' : $instance['day'];
		$number               = empty($instance['number']) ? null : $instance['number'];

		if ( alchemists_sp_preset( 'soccer' ) ) {
			$show_timeline      = isset( $instance['show_timeline'] ) ? true : false;
		}


		echo wp_kses_post( $before_widget );

		if( $title ) {
			echo wp_kses_post( $before_title ) . esc_html( $title ) . wp_kses_post( $after_title );
		}

		$event_result_array = array(
			'id'        => $id,
			'title'     => $caption,
			'status'    => 'publish',
			'date'      => $date,
			'date_from' => $date_from,
			'date_to'   => $date_to,
			'day'       => $day,
			'number'    => $number,
			'order'     => 'default'
		);

		if ( alchemists_sp_preset( 'soccer' ) ) {
			$event_result_array['show_timeline'] = $show_timeline;
		}

		sp_get_template( 'game-result.php', $event_result_array );

		echo wp_kses_post( $after_widget );
	}

	/**
	 * Updates a particular instance of a widget.
	 */

	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title']                = strip_tags( $new_instance['title'] );
		$instance['id']                   = intval($new_instance['id']);
		$instance['caption']              = strip_tags($new_instance['caption']);
		$instance['date']                 = $new_instance['date'];
		$instance['date_from']            = $new_instance['date_from'];
		$instance['date_to']              = $new_instance['date_to'];
		$instance['day']                  = $new_instance['day'];
		$instance['number']               = intval($new_instance['number']);

		if ( alchemists_sp_preset( 'soccer' ) ) {
			$instance['show_timeline']      = $new_instance['show_timeline'];
		}

		return $instance;
	}


	/**
	 * Outputs the settings update form.
	 */

	function form( $instance ) {

		$defaults = array(
			'title'                => '',
			'id'                   => null,
			'caption'              => '',
			'status'               => 'publish',
			'date'                 => 'default',
			'date_from'            => date_i18n( 'Y-m-d' ),
			'date_to'              => date_i18n( 'Y-m-d' ),
			'day'                  => '',
			'number'               => 1,
			'order'                => 'default',
			'show_all_events_link' => false,
		);

		if ( alchemists_sp_preset( 'soccer' ) ) {
			$defaults['show_timeline'] = false;
		}

		// echo '<pre>' . var_export( $defaults, true ) . '</pre>';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title                = strip_tags($instance['title']);
		$id                   = intval($instance['id']);
		$caption              = strip_tags($instance['caption']);
		$date                 = $instance['date'];
		$date_from            = $instance['date_from'];
		$date_to              = $instance['date_to'];
		$day                  = $instance['day'];
		$number               = intval($instance['number']);

		if ( alchemists_sp_preset( 'soccer' ) ) {
			$show_timeline = $instance['show_timeline'];
		}
		?>

		<p><label for="<?php echo esc_attr( $this->get_field_id('caption') ); ?>"><?php esc_html_e( 'Title:', 'alchemists' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('caption') ); ?>" name="<?php echo esc_attr( $this->get_field_name('caption') ); ?>" type="text" value="<?php echo esc_attr( $caption ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id('id') ); ?>"><?php printf( esc_html__( 'Select %s:', 'alchemists' ), esc_html__( 'Calendar', 'alchemists' ) ); ?></label>
		<?php
		$args = array(
			'post_type'       => 'sp_calendar',
			'show_option_all' => esc_html__( 'All', 'alchemists' ),
			'name'            => $this->get_field_name('id'),
			'id'              => $this->get_field_id('id'),
			'selected'        => $id,
			'values'          => 'ID',
			'class'           => 'sp-event-calendar-select widefat',
		);
		if ( ! sp_dropdown_pages( $args ) ):
			sp_post_adder( 'sp_calendar', esc_html__( 'Add New', 'alchemists' ) );
		endif;
		?>
		</p>

		<div class="sp-date-selector">
			<p><label for="<?php echo esc_attr( $this->get_field_id('date') ); ?>"><?php esc_html_e( 'Date:', 'alchemists' ); ?></label>
				<?php
				$args = array(
					'show_option_default' => esc_html__( 'Default', 'alchemists' ),
					'name' => $this->get_field_name('date'),
					'id' => $this->get_field_id('date'),
					'selected' => $date,
					'class' => 'sp-event-date-select widefat',
				);
				sp_dropdown_dates( $args );
				?>
			</p>
			<p class="sp-date-range<?php if ( 'range' !== $date ): ?> hidden<?php endif; ?>">
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'date_from' ) ); ?>" value="<?php echo esc_attr( $date_from ); ?>" placeholder="yyyy-mm-dd" size="10">
				:
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'date_to' ) ); ?>" value="<?php echo esc_attr( $date_to ); ?>" placeholder="yyyy-mm-dd" size="10">
			</p>
		</div>

		<p><label for="<?php echo esc_attr( $this->get_field_id('day') ); ?>"><?php esc_html_e( 'Match Day:', 'alchemists' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id('day') ); ?>" name="<?php echo esc_attr( $this->get_field_name('day') ); ?>" type="text" placeholder="<?php esc_attr_e( 'All', 'alchemists' ); ?>" value="<?php echo esc_attr( $day ); ?>" size="10"></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id('number') ); ?>"><?php esc_html_e( 'Number of events to show:', 'alchemists' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3"></p>

		<?php if ( alchemists_sp_preset( 'soccer' ) ) : ?>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_timeline'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_timeline' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_timeline' ) ); ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_timeline' ) ); ?>"><?php esc_attr_e( 'Show Timeline', 'alchemists' ); ?></label>
			</p>
		<?php endif; ?>

		<?php

	}
}

register_widget('Alchemists_Widget_Event_Result');
