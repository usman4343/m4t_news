<?php
/**
 * Social Counters
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

class Alchemists_Widget_Social_Counters extends WP_Widget {


  /**
	 * Constructor.
	 *
	 * @access public
	 */
  function __construct() {

		$widget_ops = array(
      'classname' => 'widget-social',
      'description' => esc_html__( 'Display social counters as a widget.', 'alchemists' ),
    );
		$control_ops = array(
      'id_base' => 'social-widget'
    );

		parent::__construct( 'social-widget', 'ALC: Social Counters', $widget_ops, $control_ops );

    //enqueue JS on frontend only if widget is active.
    // if(is_active_widget(false, false, $this->id_base)) {
    //   add_action('wp_enqueue_scripts', 'alchemists_social_widget_load');
    // }

	}


  /**
	 * Outputs the widget content.
	 */

  function widget( $args, $instance ) {

		extract( $args );

		$show_fb         = isset( $instance['show_fb'] ) ? $instance['show_fb'] : 1;
		$show_tw         = isset( $instance['show_tw'] ) ? $instance['show_tw'] : 1;
		$show_gplus      = isset( $instance['show_gplus'] ) ? $instance['show_gplus'] : 1;
		$show_instagram      = isset( $instance['show_instagram'] ) ? $instance['show_instagram'] : 1;

		// Theme Options Data
		$alchemists_data     = get_option('alchemists_data');

		// Facebook
		$alchemists_fb_user  = isset( $alchemists_data['alchemists__opt-social-fb-user'] ) ? esc_html( $alchemists_data['alchemists__opt-social-fb-user'] ) : '';
		$alchemists_fb_token = isset( $alchemists_data['alchemists__opt-social-fb-token'] ) ? esc_html( $alchemists_data['alchemists__opt-social-fb-token'] ) : '';

		// Twitter
		$alchemists_tw_user                = isset( $alchemists_data['alchemists__opt-social-tw-user'] ) ? esc_html( $alchemists_data['alchemists__opt-social-tw-user'] ) : '';
		$alchemists_tw_consumer_key        = isset( $alchemists_data['alchemists__opt-social-tw-consumer-key'] ) ? esc_html( $alchemists_data['alchemists__opt-social-tw-consumer-key'] ) : '';
		$alchemists_tw_consumer_secret     = isset( $alchemists_data['alchemists__opt-social-tw-consumer-secret'] ) ? esc_html( $alchemists_data['alchemists__opt-social-tw-consumer-secret'] ) : '';
		$alchemists_tw_access_token        = isset( $alchemists_data['alchemists__opt-social-tw-access-token'] ) ? esc_html( $alchemists_data['alchemists__opt-social-tw-access-token'] ) : '';
		$alchemists_tw_access_token_secret = isset( $alchemists_data['alchemists__opt-social-tw-access-token-secret'] ) ? esc_html( $alchemists_data['alchemists__opt-social-tw-access-token-secret'] ) : '';

		// Google+
		$alchemists_gplus_user  = isset( $alchemists_data['alchemists__opt-social-gplus-user'] ) ? esc_html( $alchemists_data['alchemists__opt-social-gplus-user'] ) : '';
		$alchemists_gplus_key   = isset( $alchemists_data['alchemists__opt-social-gplus-key'] ) ? esc_html( $alchemists_data['alchemists__opt-social-gplus-key'] ) : '';

		// Instagram
		$alchemists_insta_user  = isset( $alchemists_data['alchemists__opt-social-insta-user'] ) ? esc_html( $alchemists_data['alchemists__opt-social-insta-user'] ) : '';
		$alchemists_insta_token = isset( $alchemists_data['alchemists__opt-social-insta-token'] ) ? esc_html( $alchemists_data['alchemists__opt-social-insta-token'] ) : '';

		// Layout Style
		$layout_style           = isset( $instance['layout_style'] ) ? $instance['layout_style'] : 'default';

		// Social Labels
		$fb_label               = isset( $instance['fb_label'] ) ? $instance['fb_label'] : esc_html__( 'Like Our Facebook Page', 'alchemists');
		$tw_label               = isset( $instance['tw_label'] ) ? $instance['tw_label'] : esc_html__( 'Follow Us on Twitter', 'alchemists');
		$gplus_label            = isset( $instance['gplus_label'] ) ? $instance['gplus_label'] : esc_html__( 'Subscribe to Our Google+', 'alchemists');
		$insta_label            = isset( $instance['insta_label'] ) ? $instance['insta_label'] : esc_html__( 'Follow us on Instagram', 'alchemists');

		echo wp_kses_post( $before_widget );

		?>

		<?php $uid = uniqid();

		$socia_layout_style = '';
		if ( $layout_style == 'columns') {
			$socia_layout_style = 'widget-social--condensed';
		} elseif ( $layout_style == 'grid') {
			$socia_layout_style = 'widget-social--grid';
		}
		?>

    <div id="social-counters-<?php echo esc_attr( $uid ); ?>" class="<?php echo esc_attr( $socia_layout_style ); ?>">

			<?php if ( !empty( $alchemists_fb_user ) and 'on' == $show_fb ) : ?>
			<!-- Facebook Counter -->
    	<a href="#" class="btn-social-counter btn-social-counter--fb" target="_blank">
    	  <div class="btn-social-counter__icon">
    	    <i class="fa fa-facebook"></i>
    	  </div>
    	  <h6 class="btn-social-counter__title"><?php echo esc_html( $fb_label ); ?></h6>
    	  <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span> <?php esc_html_e( 'Likes', 'alchemists' ); ?></span>
    	  <span class="btn-social-counter__add-icon"></span>
    	</a>
			<!-- Facebook Counter / End -->
			<?php endif; ?>

			<?php if ( !empty( $alchemists_tw_user ) and 'on' == $show_tw ): ?>
			<!-- Twitter -->
			<a href="https://twitter.com/<?php echo esc_attr( $alchemists_tw_user ); ?>" class="btn-social-counter btn-social-counter--twitter" target="_blank">
		    <div class="btn-social-counter__icon">
		      <i class="fa fa-twitter"></i>
		    </div>
		    <h6 class="btn-social-counter__title"><?php echo esc_html( $tw_label ); ?></h6>

        <?php if ( function_exists( 'alchemists_tweet_count' ) ) : ?>
          <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"><?php echo esc_html( alchemists_tweet_count($alchemists_tw_user, $alchemists_tw_consumer_key, $alchemists_tw_consumer_secret, $alchemists_tw_access_token, $alchemists_tw_access_token_secret) );?></span> <?php esc_html_e( 'Followers', 'alchemists' ); ?></span>
        <?php else : ?>
          <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"><?php esc_html_e( 'Follow US', 'alchemists' ); ?></span>
        <?php endif; ?>

		    <span class="btn-social-counter__add-icon"></span>
		  </a>
			<!-- Twitter / End -->
			<?php endif; ?>

			<?php if ( !empty( $alchemists_gplus_user ) and 'on' == $show_gplus ): ?>
			<!-- Google+ -->
			<a href="#" class="btn-social-counter btn-social-counter--gplus" target="_blank">
		    <div class="btn-social-counter__icon">
		      <i class="fa fa-google-plus"></i>
		    </div>
		    <h6 class="btn-social-counter__title"><?php echo esc_html( $gplus_label ); ?></h6>
		    <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span> <?php esc_html_e( 'Subscribers', 'alchemists' ); ?></span>
		    <span class="btn-social-counter__add-icon"></span>
		  </a>
			<!-- Google+ / End -->
			<?php endif; ?>

			<?php if ( !empty( $alchemists_insta_user ) and 'on' == $show_instagram ): ?>
			<!-- Instagram -->
			<a href="#" class="btn-social-counter btn-social-counter--instagram" target="_blank">
		    <div class="btn-social-counter__icon">
		      <i class="fa fa-instagram"></i>
		    </div>
		    <h6 class="btn-social-counter__title"><?php echo esc_html( $insta_label ); ?></h6>
		    <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span> <?php esc_html_e( 'Followers', 'alchemists' ); ?></span>
		    <span class="btn-social-counter__add-icon"></span>
		  </a>
			<!-- Instagram / End -->
			<?php endif; ?>
    </div>

		<script>
			jQuery(document).on('ready', function() {
				jQuery('#social-counters-<?php echo esc_js( $uid ); ?>').SocialCounter({

					<?php if ( !empty( $alchemists_fb_user ) && !empty( $alchemists_fb_token ) ) : ?>
	        facebook_user: '<?php echo esc_js( $alchemists_fb_user ); ?>',
					facebook_token: '<?php echo esc_js( $alchemists_fb_token ); ?>',
					<?php endif; ?>

					<?php if ( !empty( $alchemists_gplus_user ) && !empty( $alchemists_gplus_key ) ) : ?>
					google_plus_id: '<?php echo esc_js( $alchemists_gplus_user ); ?>',
					google_plus_key: '<?php echo esc_js( $alchemists_gplus_key ); ?>',
					<?php endif; ?>

					<?php if ( !empty( $alchemists_insta_user ) && !empty( $alchemists_insta_token ) ) : ?>
					instagram_user: '<?php echo esc_js( $alchemists_insta_user ); ?>',
					instagram_token: '<?php echo esc_js( $alchemists_insta_token ); ?>',
					<?php endif; ?>

	      });
			});
    </script>


		<?php echo wp_kses_post( $after_widget );
  }

  /**
   * Updates a particular instance of a widget.
   */

  function update($new_instance, $old_instance) {

    $instance = $old_instance;

		$instance['layout_style']           = $new_instance['layout_style'];
		$instance['fb_label']               = $new_instance['fb_label'];
		$instance['tw_label']               = $new_instance['tw_label'];
		$instance['gplus_label']            = $new_instance['gplus_label'];
		$instance['insta_label']            = $new_instance['insta_label'];
		$instance['show_fb']                = $new_instance['show_fb'];
		$instance['show_tw']                = $new_instance['show_tw'];
		$instance['show_gplus']             = $new_instance['show_gplus'];
		$instance['show_instagram']             = $new_instance['show_instagram'];

    return $instance;
  }


  /**
   * Outputs the settings update form.
   */

  function form( $instance ) {

    $defaults = array(
			'layout_style'           => '',
			'fb_label'               => esc_html__( 'Like Our Facebook Page', 'alchemists' ),
			'tw_label'               => esc_html__( 'Follow Us on Twitter', 'alchemists' ),
			'gplus_label'            => esc_html__( 'Subscribe to Our Google+', 'alchemists' ),
			'insta_label'            => esc_html__( 'Follow us on Instagram', 'alchemists' ),
			'show_fb'                => 'on',
			'show_tw'                => 'on',
			'show_gplus'             => 'on',
			'show_instagram'         => 'on',
    );
    $instance = wp_parse_args( (array) $instance, $defaults );
    ?>

    <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'layout_style' ) ); ?>"><?php esc_html_e( 'Layout Style:', 'alchemists' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'layout_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout_style' ) ); ?>" class="widefat">
				<option value="default" <?php echo ( 'default' == $instance['layout_style'] ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Full-width Buttons', 'alchemists' ); ?></option>
				<option value="grid" <?php echo ( 'grid' == $instance['layout_style'] ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Half-width Buttons', 'alchemists' ); ?></option>
				<option value="columns" <?php echo ( 'columns' == $instance['layout_style'] ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Auto width', 'alchemists' ); ?></option>
			</select>
		</p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_fb') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_fb') ); ?>" <?php checked( $instance['show_fb'], 'on' ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id('show_fb') ); ?>"><?php esc_html_e( 'Facebook', 'alchemists' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_tw') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_tw') ); ?>" <?php checked( $instance['show_tw'], 'on' ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id('show_tw') ); ?>"><?php esc_html_e( 'Twitter', 'alchemists' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_gplus') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_gplus') ); ?>" <?php checked( $instance['show_gplus'], 'on' ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id('show_gplus') ); ?>"><?php esc_html_e( 'Google+', 'alchemists' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_instagram') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_instagram') ); ?>" <?php checked( $instance['show_instagram'], 'on' ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id('show_instagram') ); ?>"><?php esc_html_e( 'Instagram', 'alchemists' ); ?></label>
		</p>

		<p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'fb_label' ) ); ?>"><?php esc_html_e( 'Facebook Text Label:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'fb_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'fb_label' ) ); ?>" value="<?php echo esc_attr( $instance['fb_label'] ); ?>" />
    </p>

		<p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'tw_label' ) ); ?>"><?php esc_html_e( 'Twitter Text Label:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'tw_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tw_label' ) ); ?>" value="<?php echo esc_attr( $instance['tw_label'] ); ?>" />
    </p>

		<p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'gplus_label' ) ); ?>"><?php esc_html_e( 'Google+ Text Label:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'gplus_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'gplus_label' ) ); ?>" value="<?php echo esc_attr( $instance['gplus_label'] ); ?>" />
    </p>

		<p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'insta_label' ) ); ?>"><?php esc_html_e( 'Instagram Text Label:', 'alchemists' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'insta_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'insta_label' ) ); ?>" value="<?php echo esc_attr( $instance['insta_label'] ); ?>" />
    </p>


    <?php

  }
}

register_widget('Alchemists_Widget_Social_Counters');
