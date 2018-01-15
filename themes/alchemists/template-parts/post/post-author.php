<?php
/**
 * Template part for displaying posts Author box a Single Post Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Alchemists
 * @since Alchemists 1.1.0
 */

?>

<!-- Post Author -->
<div class="post-author card card--lg">
  <div class="card__content">
    <header class="post-author__header">
      <figure class="post-author__avatar">
        <?php echo get_avatar(get_the_author_meta('email'), '60'); ?>
      </figure>
      <div class="post-author__info">
        <h4 class="post-author__name"><?php the_author(); ?></h4>
        <span class="post-author__slogan"><?php the_author_meta('nickname'); ?></span>
      </div>
      <ul class="post-author__social-links social-links social-links--btn">
        <?php if ( get_the_author_meta('email') ) : ?>
        <li class="social-links__item">
          <a href="mailto:<?php echo esc_attr( get_the_author_meta('email') ); ?>" class="social-links__link social-links__link--mail"><i class="fa fa-envelope"></i></a>
        </li>
        <?php endif; ?>
        <?php if ( get_the_author_meta('url') ) : ?>
        <li class="social-links__item">
          <a href="<?php echo esc_url( get_the_author_meta('url') ); ?>" class="social-links__link social-links__link--site"><i class="fa fa-link"></i></a>
        </li>
        <?php endif; ?>
      </ul>
    </header>
    <?php if ( get_the_author_meta('description') ) : ?>
    <div class="post-author__description">
      <?php the_author_meta('description'); ?>
    </div>
    <?php endif; ?>
  </div>
</div>
<!-- Post Author / End -->
