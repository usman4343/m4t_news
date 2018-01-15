<?php
/**
 * The template for displaying Albums 3 cols
 *
 * @package Alchemists
 * @since 1.1.0
 */
?>

<a href="<?php echo get_permalink( ); ?>" class="gallery__item-inner card">

  <figure class="gallery__thumb">
    <?php if( has_post_thumbnail( ) ) {
      the_post_thumbnail('alchemists_thumbnail');
    } else {
      echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder-380x270.jpg" alt="" />';
    } ?>
    <span class="btn-fab gallery__btn-fab"></span>
  </figure>

  <div class="gallery__content card__content">
    <span class="gallery__icon">
      <span class="icon-camera"></span>
    </span>
    <div class="gallery__details">
      <h4 class="gallery__name"><?php echo get_the_title(); ?></h4>
      <div class="gallery__date"><?php the_time( get_option('date_format') ); ?></div>
    </div>
  </div>

</a>
