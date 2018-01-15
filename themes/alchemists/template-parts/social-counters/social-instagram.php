<?php
$alchemists_data     = get_option('alchemists_data');

// Instagram
$alchemists_insta_user  = isset( $alchemists_data['alchemists__opt-social-insta-user'] ) ? esc_html( $alchemists_data['alchemists__opt-social-insta-user'] ) : '';
$alchemists_insta_token = isset( $alchemists_data['alchemists__opt-social-insta-token'] ) ? esc_html( $alchemists_data['alchemists__opt-social-insta-token'] ) : '';

$uid = uniqid();

?>

<div class="post-grid__item col-sm-4">
  <?php if ( !empty( $alchemists_insta_user ) ) : ?>
  <!-- Instagram Counter -->
  <a href="#" id="insta-counter-<?php echo esc_attr( $uid ); ?>" class="btn-social-counter btn-social-counter--card btn-social-counter--instagram" target="_blank">
    <div class="btn-social-counter__name"><?php esc_html_e( 'Instagram', 'alchemists' ); ?></div>
    <footer class="btn-social-counter__footer">
      <h6 class="btn-social-counter__title"><?php esc_html_e( 'Follow Us on Instagram', 'alchemists' ); ?></h6>
      <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span> <?php esc_html_e( 'Followers', 'alchemists' ); ?></span>
      <span class="btn-social-counter__add-icon"></span>
    </footer>
  </a>
  <!-- Instagram Counter / End -->
  <?php endif; ?>
</div>

<script>
  jQuery(document).on('ready', function() {
    jQuery('#insta-counter-<?php echo esc_js( $uid ); ?>').SocialCounter({

      <?php if ( !empty( $alchemists_insta_user ) && !empty( $alchemists_insta_token ) ) : ?>
      instagram_user: '<?php echo esc_js( $alchemists_insta_user ); ?>',
      instagram_token: '<?php echo esc_js( $alchemists_insta_token ); ?>',
      <?php endif; ?>

    });
  });
</script>
