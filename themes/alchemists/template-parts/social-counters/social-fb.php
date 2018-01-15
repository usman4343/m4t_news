<?php
$alchemists_data     = get_option('alchemists_data');

// Facebook
$alchemists_fb_user  = isset( $alchemists_data['alchemists__opt-social-fb-user'] ) ? esc_html( $alchemists_data['alchemists__opt-social-fb-user'] ) : '';
$alchemists_fb_token = isset( $alchemists_data['alchemists__opt-social-fb-token'] ) ? esc_html( $alchemists_data['alchemists__opt-social-fb-token'] ) : '';

$uid = uniqid();

?>

<div class="post-grid__item col-sm-4">
  <?php if ( !empty( $alchemists_fb_user ) ) : ?>
  <!-- Facebook Counter -->
  <a href="#" id="fb-counter-<?php echo esc_attr( $uid ); ?>" class="btn-social-counter btn-social-counter--card btn-social-counter--fb" target="_blank">
    <div class="btn-social-counter__name"><?php esc_html_e( 'Facebook', 'alchemists' ); ?></div>
    <footer class="btn-social-counter__footer">
      <h6 class="btn-social-counter__title"><?php esc_html_e( 'Like Our Facebook Page', 'alchemists' ); ?></h6>
      <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span> <?php esc_html_e( 'Likes', 'alchemists' ); ?></span>
      <span class="btn-social-counter__add-icon"></span>
    </footer>
  </a>
  <!-- Facebook Counter / End -->
  <?php endif; ?>
</div>

<script>
  jQuery(document).on('ready', function() {
    jQuery('#fb-counter-<?php echo esc_js( $uid ); ?>').SocialCounter({

      <?php if ( !empty( $alchemists_fb_user ) && !empty( $alchemists_fb_token ) ) : ?>
      facebook_user: '<?php echo esc_js( $alchemists_fb_user ); ?>',
      facebook_token: '<?php echo esc_js( $alchemists_fb_token ); ?>',
      <?php endif; ?>

    });
  });
</script>
