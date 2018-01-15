<?php
/**
 * Template part for Header Top Bar.
 *
 * @author 		Dan Fisher
 * @package 	Alchemists
 * @since     1.0.0
 * @version   2.1.0
 */

$alchemists_data = get_option( 'alchemists_data' );
$top_bar         = isset( $alchemists_data['alchemists__header-top-bar'] ) ? esc_html( $alchemists_data['alchemists__header-top-bar'] ) : true;
$top_bar_links   = isset( $alchemists_data['alchemists__header-top-bar-links'] ) ? esc_html( $alchemists_data['alchemists__header-top-bar-links'] ) : true;
?>

<?php if ( $top_bar ) : ?>
<div class="header__top-bar clearfix">
  <div class="container">

    <?php // Top Menu
    if ( $top_bar_links ) :
      if ( has_nav_menu( 'top_menu' ) ) {
        wp_nav_menu(
          array(
            'theme_location'  => 'top_menu',
            'container'       => false,
            'menu_class'      => 'nav-account',
            'echo'            => true,
            'fallback_cb'     => false,
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth'           => 2,
            'walker'          => new Alchemists_Top_Menu_Walker
          )
        );
      }
    endif; ?>

  </div>
</div>
<?php endif; ?>
