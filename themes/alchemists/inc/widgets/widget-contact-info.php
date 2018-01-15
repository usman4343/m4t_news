<?php
/**
 * Contact Info
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

class Alchemists_Widget_Contact_Info extends WP_Widget {


  /**
	 * Constructor.
	 *
	 * @access public
	 */
  function __construct() {

		$widget_ops = array(
      'classname' => 'widget-contact-info',
      'description' => esc_html__( 'Display Contact Info as a widget.', 'alchemists' ),
    );
		$control_ops = array(
      'id_base' => 'contact-info-widget'
    );

		parent::__construct( 'contact-info-widget', 'ALC: Contact Info', $widget_ops, $control_ops );

	}


  /**
	 * Outputs the widget content.
	 */

  function widget( $args, $instance ) {

		extract( $args );

		$title        = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$desc         = isset( $instance['desc'] ) ? $instance['desc'] : '';
    $label_1      = isset( $instance['label_1'] ) ? $instance['label_1'] : '';
    $email_1      = isset( $instance['email_1'] ) ? $instance['email_1'] : '';
    $label_2      = isset( $instance['label_2'] ) ? $instance['label_2'] : '';
    $email_2      = isset( $instance['email_2'] ) ? $instance['email_2'] : '';
		$soc_tw       = isset( $instance['soc_tw'] ) ? $instance['soc_tw'] : '';
    $soc_fb       = isset( $instance['soc_fb'] ) ? $instance['soc_fb'] : '';
    $soc_ggl      = isset( $instance['soc_ggl'] ) ? $instance['soc_ggl'] : '';
    $soc_inst     = isset( $instance['soc_inst'] ) ? $instance['soc_inst'] : '';

		echo wp_kses_post( $before_widget );

		if( $title ) {
      echo wp_kses_post( $before_title ) . esc_html( $title ) . wp_kses_post( $after_title );
    }
		?>

    <?php if ( !empty( $desc ) ) : ?>
    <div class="widget-contact-info__desc">
      <p><?php echo wp_kses_post( $desc ); ?></p>
    </div>
    <?php endif; ?>
    <div class="widget-contact-info__body info-block">

      <?php if ( !empty( $email_1 )) : ?>
      <div class="info-block__item">

        <?php if ( alchemists_sp_preset( 'soccer' ) ) : ?>
          <svg role="img" class="df-icon df-icon--soccer-ball">
            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/icons-soccer.svg#soccer-ball"/>
          </svg>
        <?php else : ?>
          <svg role="img" class="df-icon df-icon--basketball">
            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/icons-basket.svg#basketball"/>
          </svg>
        <?php endif; ?>

        <?php if ( !empty( $label_1 ) ) : ?>
          <h6 class="info-block__heading"><?php echo esc_html( $label_1 ); ?></h6>
        <?php endif; ?>
        <a class="info-block__link" href="mailto:<?php echo esc_attr( $email_1 ); ?>"><?php echo esc_html( $email_1 ); ?></a>
      </div>
      <?php endif; ?>

      <?php if ( !empty( $email_2 ) ) : ?>
      <div class="info-block__item">

        <?php if ( alchemists_sp_preset('soccer') ) : ?>
          <svg role="img" class="df-icon df-icon--whistle">
            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/icons-soccer.svg#whistle"/>
          </svg>
        <?php else : ?>
          <svg role="img" class="df-icon df-icon--jersey">
            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/icons-basket.svg#jersey"/>
          </svg>
        <?php endif; ?>

        <?php if ( !empty( $label_2) ) : ?>
          <h6 class="info-block__heading"><?php echo esc_html( $label_2); ?></h6>
        <?php endif; ?>
        <a class="info-block__link" href="mailto:<?php echo esc_attr( $email_2 ); ?>"><?php echo esc_html( $email_2 ); ?></a>
      </div>
      <?php endif; ?>

      <?php if ( !empty( $soc_tw ) || !empty( $soc_fb) || !empty( $soc_ggl) || !empty( $soc_inst) ) : ?>
      <div class="info-block__item info-block__item--nopadding">
        <ul class="social-links">

          <?php if ( !empty( $soc_fb) ): ?>
          <li class="social-links__item">
            <a href="<?php echo esc_attr( $soc_fb ); ?>" class="social-links__link"><i class="fa fa-facebook"></i> <?php esc_html_e( 'Facebook', 'alchemists' ); ?></a>
          </li>
          <?php endif; ?>

          <?php if ( !empty( $soc_tw) ): ?>
          <li class="social-links__item">
            <a href="<?php echo esc_attr( $soc_tw ); ?>" class="social-links__link"><i class="fa fa-twitter"></i> <?php esc_html_e( 'Twitter', 'alchemists' ); ?></a>
          </li>
          <?php endif; ?>

          <?php if ( !empty( $soc_ggl) ): ?>
          <li class="social-links__item">
            <a href="<?php echo esc_attr( $soc_ggl ); ?>" class="social-links__link"><i class="fa fa-google-plus"></i> <?php esc_html_e( 'Google+', 'alchemists' ); ?></a>
          </li>
          <?php endif; ?>

          <?php if ( !empty( $soc_inst) ): ?>
          <li class="social-links__item">
            <a href="<?php echo esc_attr( $soc_inst ); ?>" class="social-links__link"><i class="fa fa-instagram"></i> <?php esc_html_e( 'Instagram', 'alchemists' ); ?></a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>


		<?php echo wp_kses_post( $after_widget );
  }

  /**
   * Updates a particular instance of a widget.
   */

  function update($new_instance, $old_instance) {

    $instance = $old_instance;

    $instance['title']    = strip_tags( $new_instance['title'] );
    $instance['desc']     = $new_instance['desc'];
    $instance['label_1']  = $new_instance['label_1'];
    $instance['email_1']  = $new_instance['email_1'];
    $instance['label_2']  = $new_instance['label_2'];
    $instance['email_2']  = $new_instance['email_2'];
    $instance['soc_tw']   = $new_instance['soc_tw'];
    $instance['soc_fb']   = $new_instance['soc_fb'];
    $instance['soc_ggl']  = $new_instance['soc_ggl'];
    $instance['soc_inst'] = $new_instance['soc_inst'];

    return $instance;
  }


  /**
   * Outputs the settings update form.
   */

  function form( $instance ) {

    $defaults = array(
      'title'    => '',
      'desc'     => '',
      'label_1'  => '',
      'email_1'  => '',
      'label_2'  => '',
      'email_2'  => '',
      'soc_tw'   => '',
      'soc_fb'   => '',
      'soc_ggl'  => '',
      'soc_inst' => '',
    );
    $instance = wp_parse_args( (array) $instance, $defaults );
    ?>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>"><?php esc_html_e( 'Short Info:', 'alchemists' ); ?></label>
      <textarea class="widefat" row="4" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'desc' ) ); ?>"><?php echo esc_attr( $instance['desc'] ); ?></textarea>
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'label_1' ) ); ?>"><?php esc_html_e( '1st Label:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'label_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label_1' ) ); ?>" value="<?php echo esc_attr( $instance['label_1'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'email_1' ) ); ?>"><?php esc_html_e( '1st Email:', 'alchemists' ); ?></label>
      <input class="widefat" type="email" id="<?php echo esc_attr( $this->get_field_id( 'email_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email_1' ) ); ?>" value="<?php echo esc_attr( $instance['email_1'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'label_2' ) ); ?>"><?php esc_html_e( '2nd Label:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'label_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label_2' ) ); ?>" value="<?php echo esc_attr( $instance['label_2'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'email_2' ) ); ?>"><?php esc_html_e( '2nd Email:', 'alchemists' ); ?></label>
      <input class="widefat" type="email" id="<?php echo esc_attr( $this->get_field_id( 'email_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email_2' ) ); ?>" value="<?php echo esc_attr( $instance['email_2'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'soc_fb' ) ); ?>"><?php esc_html_e( 'Social - Facebook:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'soc_fb' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'soc_fb' ) ); ?>" value="<?php echo esc_attr( $instance['soc_fb'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'soc_tw' ) ); ?>"><?php esc_html_e( 'Social - Twitter:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'soc_tw' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'soc_tw' ) ); ?>" value="<?php echo esc_attr( $instance['soc_tw'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'soc_ggl' ) ); ?>"><?php esc_html_e( 'Social - Google+:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'soc_ggl' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'soc_ggl' ) ); ?>" value="<?php echo esc_attr( $instance['soc_ggl'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'soc_inst' ) ); ?>"><?php esc_html_e( 'Social - Instagram:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'soc_inst' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'soc_inst' ) ); ?>" value="<?php echo esc_attr( $instance['soc_inst'] ); ?>" />
    </p>


    <?php

  }
}

register_widget('Alchemists_Widget_Contact_Info');
