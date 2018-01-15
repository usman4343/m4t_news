<?php
/**
 * Featured Player
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @version   1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Theme Options
$alchemists_data = get_option('alchemists_data');
$color_primary = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';

$defaults = array(
	'id'         => null,
	'caption'    => false,
  'style_type' => false,
  'stat_type'  => false,
	'columns'    => null,
);

extract( $defaults, EXTR_SKIP );

if ( $style_type == 'style_type2' ) {
  $style_type = 'widget-player--alt';
} else {
  $style_type = '';
}

// Explode into array
if ( null !== $columns && ! is_array( $columns ) ) {
	$columns = explode( ',', $columns );
}

$player = new SP_Player( $id );
if ( isset( $columns ) && null !== $columns ):
	$player->columns = $columns;
endif;

$data = $player->data( 0, false );

// The first row should be column labels
$labels = $data[0];

// Remove the first row to leave us with the actual data
unset( $data[0] );

// Get Total array
if ( isset( $data[-1] ) ) {
  $data = $data[-1];
}
?>

<?php if ( alchemists_sp_preset( 'soccer') ) : ?>

<?php
// Sport - Soccer

// Player Image (Alt)
$player_image_head  = get_field('heading_player_photo', $id);
$player_image_size  = 'alchemists_thumbnail-player-sm';
if( $player_image_head ) {
  $image_url = wp_get_attachment_image( $player_image_head, $player_image_size );
} else {
  $image_url = '<img src="' . get_template_directory_uri() . '/assets/images/player-single-placeholder-189x198.png' . '" alt="" />';
}

// Player Team Logo
$sp_current_teams = get_post_meta($id,'sp_current_team');
$sp_current_team = '';
if( !empty($sp_current_teams[0]) ) {
  $sp_current_team = $sp_current_teams[0];
}

// Player Name
$player_name = $player->post->post_title;
$player_url  = get_the_permalink( $id );

// Player Number
$player_number = get_post_meta( $id, 'sp_number', true );

// Player Position(s)
$positions = wp_get_post_terms( $id, 'sp_position');
$position = false;
if( $positions ) {
  $position = $positions[0]->name;
}

// Player Stats

// Bars
$shpercent   = isset( $data['shpercent'] ) ? $data['shpercent'] : '';
$passpercent = isset( $data['passpercent'] ) ? $data['passpercent'] : '';

if ( $stat_type == 'stat_extended' ) {

	// Explode into array
	if ( null !== $performance && ! is_array( $performance ) ) {
		$performance = explode( ',', $performance );
	}

	$performance_excerpts = array();
	$performance_posts = get_posts( array(
		'posts_per_page' => -1,
		'post_type' => 'sp_performance'
	) );
	foreach ( $performance_posts as $post ):
		$performance_excerpts[ $post->post_name ] = $post->post_excerpt;
	endforeach;
}


// echo '<pre>' . var_export($labels, true) . '</pre>';

?>


<!-- Widget: Featured Player -->
<div class="widget-player widget-player--soccer card <?php echo esc_attr( $style_type ); ?>">
  <?php if ( $caption ) {
		echo '<header class="card__header"><h4>' . esc_html( $caption ) . '</h4></header>';
	} ?>
  <div class="widget-player__inner">

    <a href="<?php echo esc_url( $player_url ); ?>" class="widget-player__link-layer"></a>

    <div class="widget-player__ribbon">
      <div class="fa fa-star"></div>
    </div>

    <figure class="widget-player__photo">
      <?php echo wp_kses_post( $image_url ); ?>
    </figure>

    <header class="widget-player__header clearfix">
      <?php if (!empty( $player_number )) : ?>
      <div class="widget-player__number"><?php echo esc_html( $player_number ); ?></div>
      <?php endif; ?>

      <h4 class="widget-player__name">
        <?php echo wp_kses_post( $player_name ); ?>
      </h4>
    </header>

    <div class="widget-player__content">
      <div class="widget-player__content-inner">

				<?php // Display Main Stats
				if ( is_array( $data ) ) :

					foreach ( $data as $stat_key => $stat_value ) :
						if ( in_array( $stat_key, $columns )) { ?>
							<div class="widget-player__stat">
			          <div class="widget-player__stat-number"><?php echo esc_html( $stat_value ); ?></div>
                <?php if ( isset( $labels[$stat_key] ) ) : ?>
			          <h6 class="widget-player__stat-label"><?php echo esc_html( $labels[$stat_key] ); ?></h6>
								<?php endif; ?>
			        </div>
						<?php }
					endforeach;

				endif; ?>

      </div>

      <div class="widget-player__content-alt">

        <?php if ( $shpercent ) : ?>
        <!-- Progress: Shot Accuracy -->
        <div class="progress-stats">
          <div class="progress__label"><?php esc_html_e( 'SHOT ACC', 'alchemists' ); ?></div>
          <div class="progress">
            <div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $shpercent ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $shpercent ); ?>%"></div>
          </div>
          <div class="progress__number"><?php echo esc_html( $shpercent ); ?>%</div>
        </div>
        <!-- Progress: Shot Accuracy / End -->
        <?php endif; ?>

        <?php if ( $passpercent ) : ?>
        <!-- Progress: Pass Accuracy -->
        <div class="progress-stats">
          <div class="progress__label"><?php esc_html_e( 'PASS ACC', 'alchemists' ); ?></div>
          <div class="progress">
            <div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $passpercent ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $passpercent ); ?>%"></div>
          </div>
          <div class="progress__number"><?php echo esc_html( $passpercent ); ?>%</div>
        </div>
        <!-- Progress: Pass Accuracy / End -->
        <?php endif; ?>

      </div>

    </div>

  </div>

  <?php if ( $stat_type == 'stat_extended' ) : ?>
  <div class="widget__content-secondary">

    <!-- Player Details -->
    <div class="widget-player__details">

      <?php foreach ( $data as $performance_key => $performance_value ) : ?>
				<?php if ( in_array( $performance_key, $performance ) ) : ?>
					<div class="widget-player__details__item">
						<div class="widget-player__details-desc-wrapper">
							<span class="widget-player__details-holder">
								<?php if ( isset( $performance_excerpts[$performance_key] )) : ?>
								<span class="widget-player__details-label"><?php echo esc_html( $performance_excerpts[$performance_key] ); ?></span>
								<?php endif; ?>
								<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
							</span>
							<span class="widget-player__details-value"><?php echo esc_html( $performance_value ); ?></span>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>

    </div>
    <!-- Player Details / End -->

  </div>
  <?php endif; ?>

</div>
<!-- Widget: Featured Player / End -->

<?php else : ?>

<?php
// Sport - Basketball

// Player Image (Alt)
$player_image_head  = get_field('heading_player_photo', $id);
$player_image_size  = 'alchemists_thumbnail-player-sm';
if( $player_image_head ) {
  $image_url = wp_get_attachment_image( $player_image_head, $player_image_size );
} else {
  $image_url = '<img src="' . get_template_directory_uri() . '/assets/images/player-single-placeholder-189x198.png' . '" alt="" />';
}

// Player Team Logo
$sp_current_teams = get_post_meta($id,'sp_current_team');
$sp_current_team = '';
if( !empty($sp_current_teams[0]) ) {
  $sp_current_team = $sp_current_teams[0];
}

// Player Name
$player_name = $player->post->post_title;
$player_url  = get_the_permalink( $id );

// Player Number
$player_number = get_post_meta( $id, 'sp_number', true );

// Player Position(s)
$positions = wp_get_post_terms( $id, 'sp_position');
$position = false;
if( $positions ) {
  $position = $positions[0]->name;
}

// Player Stats

if ( $stat_type == 'stat_extended' ) {

	// Explode into array
	if ( null !== $performance && ! is_array( $performance ) ) {
		$performance = explode( ',', $performance );
	}

	$performance_excerpts = array();
	$performance_posts = get_posts( array(
		'posts_per_page' => -1,
		'post_type' => 'sp_performance'
	) );
	foreach ( $performance_posts as $post ):
		$performance_excerpts[ $post->post_name ] = $post->post_excerpt;
	endforeach;

  $fgpercent     = isset( $data['fgpercent'] ) ? esc_html( $data['fgpercent'] ) : 0;
  $ftpercent     = isset( $data['ftpercent'] ) ? esc_html( $data['ftpercent'] ) : 0;
  $threeppercent = isset( $data['threeppercent'] ) ? esc_html( $data['threeppercent'] ) : 0;
}


// echo '<pre>' . var_export($labels, true) . '</pre>';

?>


<!-- Widget: Featured Player -->
<div class="widget-player card <?php echo esc_attr( $style_type ); ?>">
  <?php if ( $caption ) {
		echo '<header class="card__header"><h4>' . esc_html( $caption ) . '</h4></header>';
	} ?>
  <div class="widget-player__inner">

    <a href="<?php echo esc_url( $player_url ); ?>" class="widget-player__link-layer"></a>

    <?php if( !empty( $sp_current_team ) ):
      $player_team_logo = alchemists_get_thumbnail_url( $sp_current_team, '0', 'full' );
      if( !empty($player_team_logo) ): ?>
        <div class="widget-player__team-logo">
          <img src="<?php echo esc_url( $player_team_logo ); ?>" alt="<?php esc_attr_e( 'Team Logo', 'alchemists' ); ?>" />
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <figure class="widget-player__photo">
      <?php echo wp_kses_post( $image_url ); ?>
    </figure>

    <header class="widget-player__header clearfix">
      <?php if (!empty( $player_number )) : ?>
      <div class="widget-player__number"><?php echo esc_html( $player_number ); ?></div>
      <?php endif; ?>

      <h4 class="widget-player__name">
        <?php echo wp_kses_post( $player_name ); ?>
      </h4>
    </header>

    <div class="widget-player__content">
      <div class="widget-player__content-inner">

				<?php // Display Main Stats
				if ( is_array( $data ) ) :

					foreach ( $data as $stat_key => $stat_value ) :
						if ( in_array( $stat_key, $columns )) { ?>
							<div class="widget-player__stat">
								<?php if ( isset( $labels[$stat_key] ) ) : ?>
			          <h6 class="widget-player__stat-label"><?php echo esc_html( $labels[$stat_key] ); ?></h6>
								<?php endif; ?>
			          <div class="widget-player__stat-number"><?php echo esc_html( $stat_value ); ?></div>
								<?php if ( in_array( $stat_key, array( 'ppg', 'bpg', 'apg', 'rpg', 'apg', 'spg' ) ) )  : ?>
			          <div class="widget-player__stat-legend"><?php esc_html_e( 'AVG', 'alchemists' ); ?></div>
								<?php endif; ?>
			        </div>
						<?php }
					endforeach;

				endif; ?>

      </div>
    </div>

    <?php if (!empty( $position )) : ?>
    <footer class="widget-player__footer">
      <span class="widget-player__footer-txt">
        <?php echo esc_html( $position ); ?>
      </span>
    </footer>
    <?php endif; ?>

  </div>

  <?php if ( $stat_type == 'stat_extended' ) : ?>
  <div class="widget__content-secondary">

    <!-- Player Details -->
    <div class="widget-player__details">

      <?php foreach ( $data as $performance_key => $performance_value ) : ?>
				<?php if ( in_array( $performance_key, $performance ) ) : ?>
					<div class="widget-player__details__item">
						<div class="widget-player__details-desc-wrapper">
							<span class="widget-player__details-holder">
								<?php if ( isset( $performance_excerpts[$performance_key] )) : ?>
								<span class="widget-player__details-label"><?php echo esc_html( $performance_excerpts[$performance_key] ); ?></span>
								<?php endif; ?>
								<span class="widget-player__details-desc"><?php esc_html_e( 'In his career', 'alchemists' ); ?></span>
							</span>
							<span class="widget-player__details-value"><?php echo esc_html( $performance_value ); ?></span>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>

    </div>
    <!-- Player Details / End -->

  </div>

  <div class="widget__content-tertiary widget__content--bottom-decor">
    <div class="widget__content-inner">
      <div class="widget-player__stats row">
        <div class="col-xs-4">
          <div class="widget-player__stat-item">
            <div class="widget-player__stat-circular circular">
              <div class="circular__bar" data-percent="<?php echo esc_attr( $fgpercent ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
                <span class="circular__percents"><?php echo esc_html( number_format( $fgpercent, 1 ) ); ?><small>%</small></span>
              </div>
              <span class="circular__label"><?php echo wp_kses_post(__( 'Shot<br> Accuracy', 'alchemists' ) ); ?></span>
            </div>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="widget-player__stat-item">
            <div class="widget-player__stat-circular circular">
              <div class="circular__bar" data-percent="<?php echo esc_attr( $ftpercent ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
                <span class="circular__percents"><?php echo esc_html( number_format( $ftpercent, 1 ) ); ?><small>%</small></span>
              </div>
              <span class="circular__label"><?php echo wp_kses_post(__( 'Free Throw<br> Accuracy', 'alchemists' ) ); ?></span>
            </div>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="widget-player__stat-item">
            <div class="widget-player__stat-circular circular">
              <div class="circular__bar" data-percent="<?php echo esc_attr( $threeppercent ); ?>" data-bar-color="<?php echo esc_attr( $color_primary ); ?>">
                <span class="circular__percents"><?php echo esc_html( number_format( $threeppercent, 1 ) ); ?><small>%</small></span>
              </div>
              <span class="circular__label"><?php echo wp_kses_post(__( '3 Points<br> Accuracy', 'alchemists' ) ); ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

</div>
<!-- Widget: Featured Player / End -->

<?php endif; ?>
