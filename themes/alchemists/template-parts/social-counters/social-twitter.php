<?php
$alchemists_data     = get_option('alchemists_data');

// Twitter
$alchemists_tw_user                = isset( $alchemists_data['alchemists__opt-social-tw-user'] ) ? esc_html( $alchemists_data['alchemists__opt-social-tw-user'] ) : '';
$alchemists_tw_consumer_key        = isset( $alchemists_data['alchemists__opt-social-tw-consumer-key'] ) ? esc_html( $alchemists_data['alchemists__opt-social-tw-consumer-key'] ) : '';
$alchemists_tw_consumer_secret     = isset( $alchemists_data['alchemists__opt-social-tw-consumer-secret'] ) ? esc_html( $alchemists_data['alchemists__opt-social-tw-consumer-secret'] ) : '';
$alchemists_tw_access_token        = isset( $alchemists_data['alchemists__opt-social-tw-access-token'] ) ? esc_html( $alchemists_data['alchemists__opt-social-tw-access-token'] ) : '';
$alchemists_tw_access_token_secret = isset( $alchemists_data['alchemists__opt-social-tw-access-token-secret'] ) ? esc_html( $alchemists_data['alchemists__opt-social-tw-access-token-secret'] ) : '';

$uid = uniqid();

?>

<div class="post-grid__item col-sm-4">
  <?php if ( !empty( $alchemists_tw_user ) ) : ?>
  <!-- Twitter Counter -->
  <a href="https://twitter.com/<?php echo esc_attr( $alchemists_tw_user ); ?>" id="twitter-counter-<?php echo esc_attr( $uid ); ?>" class="btn-social-counter btn-social-counter--card btn-social-counter--twitter" target="_blank">
    <div class="btn-social-counter__name"><?php esc_html_e( 'Twitter', 'alchemists' ); ?></div>
    <footer class="btn-social-counter__footer">
      <h6 class="btn-social-counter__title"><?php esc_html_e( 'Follow Us on Twitter', 'alchemists' ); ?></h6>

      <?php if ( function_exists( 'alchemists_tweet_count' ) ) : ?>
        <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"><?php echo esc_html( alchemists_tweet_count($alchemists_tw_user, $alchemists_tw_consumer_key, $alchemists_tw_consumer_secret, $alchemists_tw_access_token, $alchemists_tw_access_token_secret) );?></span> <?php esc_html_e( 'Followers', 'alchemists' ); ?></span>
      <?php else : ?>
        <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"><?php esc_html_e( 'Follow US', 'alchemists' ); ?></span>
      <?php endif; ?>

      <span class="btn-social-counter__add-icon"></span>
    </footer>
  </a>
  <!-- Twitter Counter / End -->
  <?php endif; ?>
</div>
