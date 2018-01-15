<?php
$alchemists_data     = get_option('alchemists_data');

// Google+
$alchemists_gplus_user = isset( $alchemists_data['alchemists__opt-social-gplus-user'] ) ? esc_html( $alchemists_data['alchemists__opt-social-gplus-user'] ) : '';
$alchemists_gplus_key  = isset( $alchemists_data['alchemists__opt-social-gplus-key'] ) ? esc_html( $alchemists_data['alchemists__opt-social-gplus-key'] ) : '';

$uid = uniqid();

?>

<div class="post-grid__item col-sm-4">
  <?php if ( !empty( $alchemists_gplus_user ) ) : ?>
  <!-- Facebook Counter -->
  <a href="#" id="gplus-counter-<?php echo esc_attr( $uid ); ?>" class="btn-social-counter btn-social-counter--card btn-social-counter--gplus" target="_blank">
    <div class="btn-social-counter__name"><?php esc_html_e( 'Google+', 'alchemists' ); ?></div>
    <footer class="btn-social-counter__footer">
      <h6 class="btn-social-counter__title"><?php esc_html_e( 'Friend us on Google+', 'alchemists' ); ?></h6>
      <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span> <?php esc_html_e( 'Likes', 'alchemists' ); ?></span>
      <span class="btn-social-counter__add-icon"></span>
    </footer>
  </a>
  <!-- Facebook Counter / End -->
  <?php endif; ?>
</div>

<script>
  jQuery(document).on('ready', function() {
    jQuery('#gplus-counter-<?php echo esc_js( $uid ); ?>').SocialCounter({

      <?php if ( !empty( $alchemists_gplus_user ) && !empty( $alchemists_gplus_key ) ) : ?>
      google_plus_id: '<?php echo esc_js( $alchemists_gplus_user ); ?>',
      google_plus_key: '<?php echo esc_js( $alchemists_gplus_key ); ?>',
      <?php endif; ?>

    });
  });
</script>
