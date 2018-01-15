<?php
/*
Plugin Name: DF Twitter Widget
Plugin URI: https://github.com/danfisher85/df-twitter-widget
Description: A simple Twitter feed widget.
Author: Dan Fisher
Version: 1.0.1
Author URI: https://themeforest.net/user/dan_fisher
Text Domain: df-twitter-widget
Domain Path: /lang
*/


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

// Load the widget on widgets_init
function df_load_image_widget() {
	register_widget( 'DF_Widget_Twitter_Feed' );
}
add_action( 'widgets_init', 'df_load_image_widget' );

/**
 * Widget class.
 */

class DF_Widget_Twitter_Feed extends WP_Widget {


  /**
	 * Constructor.
	 *
	 * @access public
	 */
  function __construct() {

    load_plugin_textdomain( 'df-twitter-widget', false, trailingslashit( basename( dirname( __FILE__ ) ) ) . 'lang/' );

		$widget_ops = array(
      'classname' => 'widget-twitter',
      'description' => esc_html__( 'Your latest tweets.', 'df-twitter-widget' ),
    );
		$control_ops = array(
      'id_base' => 'twitter-widget'
    );

		parent::__construct( 'twitter-widget', 'DF - Twitter Feed', $widget_ops, $control_ops );

	}



  /**
	 * Outputs the widget content.
	 */

  function widget( $args, $instance ) {

		extract( $args );

		$title               = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$twitter_id          = isset( $instance['twitter_id'] ) ? $instance['twitter_id'] : '';
		$count               = (int) isset( $instance['count'] ) ? $instance['count'] : 3;

		$consumer_key        = isset( $instance['consumer_key'] ) ? $instance['consumer_key'] : '';
		$consumer_secret     = isset( $instance['consumer_secret'] ) ? $instance['consumer_secret'] : '';
		$access_token        = isset( $instance['access_token'] ) ? $instance['access_token'] : '';
		$access_token_secret = isset( $instance['access_token_secret'] ) ? $instance['access_token_secret'] : '';

    $cachetime           = isset( $instance['cachetime'] ) ? $instance['cachetime'] : 1;
    $exclude_replies     = isset( $instance['exclude_replies'] ) ? true : false;

		echo wp_kses_post( $before_widget );

		if( $title ) {
      echo wp_kses_post( $before_title ) . esc_html( $title ) . wp_kses_post( $after_title );
    }
		?>


    <?php

    if ( $exclude_replies ) {
      $exclude_replies_new = 'true';
    }

    //check settings and die if not set
    if(empty($instance['consumer_key']) || empty($instance['consumer_secret']) || empty($instance['access_token']) || empty($instance['access_token_secret']) || empty($instance['cachetime']) || empty($instance['twitter_id'])){
      echo '<strong>' . esc_html__( 'Please fill all widget settings!', 'df-twitter-widget' ) . '</strong>' . $after_widget;
      return;
    }

    //check if cache needs update
    $alchemists_twitter_plugin_last_cache_time = get_option('alchemists_twitter_plugin_last_cache_time');
    $diff = time() - $alchemists_twitter_plugin_last_cache_time;
    $crt  = $instance['cachetime'] * 3600;

     //	yes, it needs update
    if($diff >= $crt || empty($alchemists_twitter_plugin_last_cache_time)){

      if( !require_once( 'lib/twitteroauth.php' ) ){
        echo '<strong>' . esc_html__( 'Couldn\'t find twitteroauth.php!', 'df-twitter-widget' ).'</strong>' . $after_widget;
        return;
      }

      function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
        $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
        return $connection;
      }


      $connection = getConnectionWithAccessToken($instance['consumer_key'], $instance['consumer_secret'], $instance['access_token'], $instance['access_token_secret']);
      $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$instance['twitter_id']."&count=10&exclude_replies=" . $exclude_replies_new ) or die( 'Couldn\'t retrieve tweets! Wrong username?' );


      if(!empty($tweets->errors)){
        if($tweets->errors[0]->message == 'Invalid or expired token'){
          echo '<strong>' . $tweets->errors[0]->message . '!</strong><br />' . esc_html__('You\'ll need to regenerate your token!', 'df-twitter-widget') . $after_widget;
        }else{
          echo '<strong>' . $tweets->errors[0]->message . '</strong>' . $after_widget;
        }
        return;
      }

      $tweets_array = array();
      for($i = 0;$i <= count($tweets); $i++){
        if(!empty($tweets[$i])){
          $tweets_array[$i]['created_at'] = $tweets[$i]->created_at;

          //clean tweet text
          $tweets_array[$i]['text'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $tweets[$i]->text);

          //profile image
          $tweets_array[$i]['profile_image_url_https'] = $tweets[$i]->user->profile_image_url_https;

          //screen name
          $tweets_array[$i]['screen_name'] = $tweets[$i]->user->screen_name;

          //name
          $tweets_array[$i]['name'] = $tweets[$i]->user->name;

          if(!empty($tweets[$i]->id_str)){
            $tweets_array[$i]['status_id'] = $tweets[$i]->id_str;
          }
        }
      }

      //save tweets to wp option
      update_option('alchemists_twitter_plugin_tweets',serialize($tweets_array));
      update_option('alchemists_twitter_plugin_last_cache_time',time());

      echo '<!-- twitter cache has been updated! -->';
    }



    $alchemists_twitter_plugin_tweets = maybe_unserialize(get_option('alchemists_twitter_plugin_tweets'));

    if(!empty($alchemists_twitter_plugin_tweets) && is_array($alchemists_twitter_plugin_tweets)){
      print '
      <div class="twitter-feed-wrapper">
        <ul class="twitter-feed">';
        $fctr = '1';
        foreach($alchemists_twitter_plugin_tweets as $tweet){
          if(!empty($tweet['text'])){
            if(empty($tweet['status_id'])){ $tweet['status_id'] = ''; }
            if(empty($tweet['created_at'])){ $tweet['created_at'] = ''; }
            if(empty($tweet['profile_image_url_https'])){ $tweet['profile_image_url_https'] = ''; }
            if(empty($tweet['screen_name'])){ $tweet['screen_name'] = ''; }
            if(empty($tweet['name'])){ $tweet['name'] = ''; }

            print '<li class="twitter-feed__item">
            <header class="twitter-feed__header">
            <figure class="twitter-feed__thumb">
            <a href="//twitter.com/' . $tweet['screen_name'] . '" target="_blank">
            <img src="' . $tweet['profile_image_url_https'] . '" alt="" /></a>
            </figure>
            <div class="twitter-feed__info">
            <h5 class="twitter-feed__name">' . $tweet['name'] . '</h5>
            <h6 class="twitter-feed__username"><a href="//twitter.com/' . $tweet['screen_name'] . '" target="_blank">@' . $tweet['screen_name'] . '</a></h6>
            </div>
            </header>
            <div class="twitter-feed__body">' . $this->df_convert_links($tweet['text']) . '</div>
            <footer class="twitter-feed__footer">
            <div class="twitter-feed__timestamp"><a href="//twitter.com/' . $instance['twitter_id'] . '/statuses/' . $tweet['status_id'] . '" target="_blank">' . $this->df_relative_time( $tweet['created_at'] ) . '</a></div>
            <div class="twitter-feed__actions">
            <a href="//twitter.com/intent/tweet?in_reply_to=' . $tweet['status_id'] . '" onclick="window.open(\'//twitter.com/intent/tweet?in_reply_to=' . $tweet['status_id'] . '\', \'newwindow\', \'width=600, height=400\'); return false;" class="twitter-feed__reply"></a>
            <a href="//twitter.com/intent/retweet?tweet_id=' . $tweet['status_id'] . '" onclick="window.open(\'//twitter.com/intent/retweet?tweet_id=' . $tweet['status_id'] . '\', \'newwindow\', \'width=600, height=400\'); return false;" class="twitter-feed__retweet"></a>
            <a href="//twitter.com/intent/favorite?tweet_id=' . $tweet['status_id'] . '" onclick="window.open(\'//twitter.com/intent/favorite?tweet_id=' . $tweet['status_id'] . '\', \'newwindow\', \'width=600, height=400\'); return false;" class="twitter-feed__favorite"></a>
            </div>
            </footer>
            </li>';
            if($fctr == $instance['count']){ break; }
            $fctr++;
          }
        }

      print '</ul>
			</div>';
    } else {
      print '
      <div class="twitter-feed-wrapper">
        ' . esc_html_e( 'Error! Couldn\'t retrieve tweets for some reason!', 'df-twitter-widget' ) . '
      </div>';
    } ?>


		<?php echo wp_kses_post( $after_widget );
  }

  /**
   * Updates a particular instance of a widget.
   */

  function update($new_instance, $old_instance) {

    $instance = $old_instance;

    $instance['title']   = strip_tags( $new_instance['title'] );
		$instance['twitter_id']          = $new_instance['twitter_id'];
		$instance['count']               = $new_instance['count'];

		$instance['consumer_key']        = $new_instance['consumer_key'];
		$instance['consumer_secret']     = $new_instance['consumer_secret'];
		$instance['access_token']        = $new_instance['access_token'];
		$instance['access_token_secret'] = $new_instance['access_token_secret'];
    $instance['cachetime']           = $new_instance['cachetime'];
    $instance['exclude_replies']     = $new_instance['exclude_replies'];

    return $instance;
  }


  /**
   * Outputs the settings update form.
   */

  function form( $instance ) {

    $defaults = array(
      'title'               => esc_html__( 'Twitter', 'df-twitter-widget' ),
			'twitter_id'          => '',
			'count'               => 3,

			'consumer_key'        => '',
			'consumer_secret'     => '',
			'access_token'        => '',
			'access_token_secret' => '',

      'cachetime'           => 1,
      'exclude_replies'     => 'on',
    );
    $instance = wp_parse_args( (array) $instance, $defaults );
    ?>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'df-twitter-widget' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'twitter_id' ) ); ?>"><?php esc_html_e( 'Twitter Username:', 'df-twitter-widget' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'twitter_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter_id' ) ); ?>" value="<?php echo esc_attr( $instance['twitter_id'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>"><?php esc_html_e( 'Consumer Key:', 'df-twitter-widget' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_key' ) ); ?>" value="<?php echo esc_attr( $instance['consumer_key'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>"><?php esc_html_e( 'Consumer Secret:', 'df-twitter-widget' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_secret' ) ); ?>" value="<?php echo esc_attr( $instance['consumer_secret'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>"><?php esc_html_e( 'Access Token:', 'df-twitter-widget' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>" value="<?php echo esc_attr( $instance['access_token'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>"><?php esc_html_e( 'Access Token Secret:', 'df-twitter-widget' ); ?></label>
      <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token_secret' ) ); ?>" value="<?php echo esc_attr( $instance['access_token_secret'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of Tweets:', 'df-twitter-widget' ); ?></label>
      <input class="tiny-text" type="number" step="1" min="1" size="3" max="20" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" value="<?php echo esc_attr( $instance['count'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'cachetime' ) ); ?>"><?php esc_html_e( 'Cache Tweets Duration (hours):', 'df-twitter-widget' ); ?></label>
      <input class="tiny-text" type="number" id="<?php echo esc_attr( $this->get_field_id( 'cachetime' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cachetime' ) ); ?>" step="1" min="1" size="3" value="<?php echo esc_attr( $instance['cachetime'] ); ?>" />
    </p>

    <p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['exclude_replies'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'exclude_replies' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_replies' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_replies' ) ); ?>"><?php esc_attr_e( 'Exclude Replies:', 'df-twitter-widget' ); ?></label>
		</p>


    <?php

  }


  /**
	 * Convert Links.
	 */
	private function df_convert_links( $status, $targetBlank = true, $linkMaxLen = 250  ) {
		// the target
		$target = $targetBlank ? " target=\"_blank\" " : "";

		// convert link to url
		$status = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]/i', '<a href="\0" target="_blank">\0</a>', $status);

		// convert @ to follow
		$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

		// convert # to search
		$status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);

		// return the status
		return $status;
	}


  /**
	 * Convert dates to readable format
	 */
	private function df_relative_time( $a  ) {
		//get current timestampt
		$b = strtotime('now');
		//get timestamp when tweet created
		$c = strtotime($a);
		//get difference
		$d = $b - $c;
		//calculate different time values
		$minute = 60;
		$hour = $minute * 60;
		$day = $hour * 24;
		$week = $day * 7;

		if(is_numeric($d) && $d > 0) {
			//if less then 3 seconds
			if($d < 3) return esc_html__( 'right now', 'df-twitter-widget' );
			//if less then minute
			if($d < $minute) return floor($d) . esc_html__( ' seconds ago', 'df-twitter-widget' );
			//if less then 2 minutes
			if($d < $minute * 2) return esc_html__( 'about 1 minute ago', 'df-twitter-widget' );
			//if less then hour
			if($d < $hour) return floor($d / $minute) . esc_html__( ' minutes ago', 'df-twitter-widget' );
			//if less then 2 hours
			if($d < $hour * 2) return esc_html__( 'about 1 hour ago', 'df-twitter-widget' );
			//if less then day
			if($d < $day) return floor($d / $hour) . esc_html__( ' hours ago', 'df-twitter-widget' );
			//if more then day, but less then 2 days
			if($d > $day && $d < $day * 2) return esc_html__( 'yesterday', 'df-twitter-widget' );
			//if less then year
			if($d < $day * 365) return floor($d / $day) . esc_html__( ' days ago', 'df-twitter-widget' );
			//else return more than a year
			return esc_html__( 'over a year ago', 'df-twitter-widget' );
		}
	}
}
