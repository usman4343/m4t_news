<!-- Searchform -->
<form id="search-form" class="inline-form" action="<?php echo esc_url( home_url('/') ); ?>">
  <div class="input-group">
    <input id="s" type="text" name="s" class="form-control" placeholder="<?php esc_attr_e( 'Search text...', 'alchemists' ); ?>">
    <span class="input-group-btn">
      <button class="btn btn-lg btn-default" type="button"><?php esc_html_e( 'Search', 'alchemists' ); ?></button>
    </span>
  </div>
</form>
<!-- /Searchform -->
