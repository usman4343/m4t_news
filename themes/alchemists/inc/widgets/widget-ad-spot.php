<?php
/**
 * Ad Spot
 *
 * @package Alchemists
 * @subpackage Widget
 */


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}


/**
 * Widget class.
 */

class Alchemists_Widget_Ad_Spot extends WP_Widget {


  /**
	 * Constructor.
	 *
	 * @access public
	 */
  function __construct() {

		$widget_ops = array(
      'classname' => 'widget-banner',
      'description' => esc_html__( 'Display Ad as a widget.', 'alchemists' ),
    );
		$control_ops = array(
      'id_base' => 'ad-spot-widget'
    );

		parent::__construct( 'ad-spot-widget', 'ALC: Ad Spot', $widget_ops, $control_ops );

	}


  /**
	 * Outputs the widget content.
	 */

  function widget( $args, $instance ) {

		extract( $args );

		$title        = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$img_url      = isset( $instance['img_url'] ) ? $instance['img_url'] : '';
		$href         = isset( $instance['href'] ) ? $instance['href'] : '';
    $alt          = isset( $instance['alt'] ) ? $instance['alt'] : '';

		echo wp_kses_post( $before_widget );

		if( $title ) {
      echo wp_kses_post( $before_title ) . esc_html( $title ) . wp_kses_post( $after_title );
    }
		?>


    <?php if ( $img_url != '' ) { ?>

      <figure class="widget-banner__img">
        <a href="<?php echo esc_url( $href ); ?>"><img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>"></a>
      </figure>

    <?php } else { ?>

      <figure class="widget-banner__img">
        <a href="<?php echo esc_url( $href ); ?>"><img src="<?php echo get_template_directory_uri() . '/assets/images/samples/banner.jpg'; ?>" alt="<?php echo esc_attr( $alt ); ?>"></a>
      </figure>

    <?php } ?>


		<?php echo wp_kses_post( $after_widget );
  }

  /**
   * Updates a particular instance of a widget.
   */

  function update($new_instance, $old_instance) {

    $instance = $old_instance;

    $instance['title']   = strip_tags( $new_instance['title'] );
		$instance['img_url'] = $new_instance['img_url'];
		$instance['href']    = $new_instance['href'];
		$instance['alt']     = $new_instance['alt'];

    return $instance;
  }


  /**
   * Outputs the settings update form.
   */

  function form( $instance ) {

    $defaults = array(
      'title'   => '',
			'img_url' => '',
			'href'    => '',
			'alt'     => '',
    );
    $instance = wp_parse_args( (array) $instance, $defaults );
    ?>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'img_url' ) ); ?>"><?php esc_html_e( 'Image URL:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'img_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'img_url' ) ); ?>" value="<?php echo esc_attr( $instance['img_url'] ); ?>" />
      <em><?php esc_html_e( 'Recommended size 300x250', 'alchemists' ); ?></em>
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'href' ) ); ?>"><?php esc_html_e( 'Link URL:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'href' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'href' ) ); ?>" value="<?php echo esc_attr( $instance['href'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'alt' ) ); ?>"><?php esc_html_e( 'Alt Text:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'alt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'alt' ) ); ?>" value="<?php echo esc_attr( $instance['alt'] ); ?>" />
    </p>


    <?php

  }
}

register_widget('Alchemists_Widget_Ad_Spot');
