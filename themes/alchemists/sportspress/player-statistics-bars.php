<?php
/**
 * Player Percentas Statistics for Single Player
 *
 * @author 		Dan Fisher
 * @package 	Alchemists
 * @version   2.0.0
 */

// Skip if there are no rows in the table
if ( empty( $data ) )
  return;

unset( $data[0] );
$data = $data[-1]; // Get Total array

// Theme Options
$alchemists_data = get_option('alchemists_data');
$color_primary = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';

// Stats
$winratio      = isset( $data['winratio'] ) ? $data['winratio'] : 0;
$shpercent     = isset( $data['shpercent'] ) ? $data['shpercent'] : 0;
$passpercent   = isset( $data['passpercent'] ) ? $data['passpercent'] : 0;
$perf          = isset( $data['perf'] ) ? $data['perf'] : 0;
$penpercent    = isset( $data['penpercent'] ) ? $data['penpercent'] : 0;
?>


<!-- Player Stats -->
<div class="player-info__item player-info__item--stats">
  <div class="player-info__item--stats-inner">

    <?php if ( $winratio ) : ?>
    <!-- Progress: Win Ration -->
    <div class="progress-stats progress-stats--top-labels">
      <div class="progress__label"><?php esc_attr_e( 'Win Ratio', 'alchemists' ); ?></div>
      <div class="progress">
        <div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $winratio ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $winratio ); ?>%"></div>
      </div>
      <div class="progress__number"><?php echo esc_attr( round($winratio, 0) ); ?>%</div>
    </div>
    <!-- Progress: Win Ration / End -->
    <?php endif; ?>

    <?php if ( $shpercent ) : ?>
    <!-- Progress: Shot Accuracy -->
    <div class="progress-stats progress-stats--top-labels">
      <div class="progress__label"><?php esc_attr_e( 'Shot Accuracy', 'alchemists' ); ?></div>
      <div class="progress">
        <div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $shpercent ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $shpercent ); ?>%"></div>
      </div>
      <div class="progress__number"><?php echo esc_html( $shpercent ); ?>%</div>
    </div>
    <!-- Progress: Shot Accuracy / End -->
    <?php endif; ?>

    <?php if ( $passpercent ) : ?>
    <!-- Progress: Pass Accuracy -->
    <div class="progress-stats progress-stats--top-labels">
      <div class="progress__label"><?php esc_attr_e( 'Pass Accuracy', 'alchemists' ); ?></div>
      <div class="progress">
        <div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $passpercent ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $passpercent ); ?>%"></div>
      </div>
      <div class="progress__number"><?php echo esc_html( $passpercent ); ?>%</div>
    </div>
    <!-- Progress: Pass Accuracy / End -->
    <?php endif; ?>

    <?php if ( $perf ) : ?>
    <!-- Progress: Perfomance -->
    <div class="progress-stats progress-stats--top-labels">
      <div class="progress__label"><?php esc_attr_e( 'Performance', 'alchemists' ); ?></div>
      <div class="progress">
        <div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $perf ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $perf ); ?>%"></div>
      </div>
      <div class="progress__number"><?php echo esc_html( $perf ); ?>%</div>
    </div>
    <!-- Progress: Perfomance / End -->
    <?php endif; ?>

    <?php if ( $penpercent ) : ?>
    <!-- Progress: Penalty Accuracy -->
    <div class="progress-stats progress-stats--top-labels">
      <div class="progress__label"><?php esc_attr_e( 'P.Kick Accuracy', 'alchemists' ); ?></div>
      <div class="progress">
        <div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $penpercent ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $penpercent ); ?>%"></div>
      </div>
      <div class="progress__number"><?php echo esc_html( $penpercent ); ?>%</div>
    </div>
    <!-- Progress: Penalty Accuracy / End -->
    <?php endif; ?>

  </div>
</div>
<!-- Player Stats / End -->
