<?php
/**
 * Template part for displaying posts in Post Slider
 *
 * @author 		Dan Fisher
 * @package 	Alchemists
 * @since     1.0.0
 * @version   2.1.0
 */

$alchemists_data   = get_option('alchemists_data');
$categories_toggle = isset( $alchemists_data['alchemists__posts-categories'] ) ? $alchemists_data['alchemists__posts-categories'] : 1;

$post_classes = array(
	'posts__item'
);

?>


<article <?php post_class( $post_classes ); ?>>
  <a href="<?php echo esc_url( get_permalink() ); ?>" class="posts__link-wrapper">

    <figure class="posts__thumb">
      <?php if( has_post_thumbnail() ) { ?>
    		<?php the_post_thumbnail('alchemists_thumbnail-sm'); ?>
    	<?php } else { ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-773x408.jpg" alt="">
      <?php } ?>
    </figure>

    <div class="posts__inner">

      <?php if ( $categories_toggle ) : ?>
        <?php alchemists_post_category_labels(); ?>
      <?php endif; ?>

      <?php the_title( '<h3 class="posts__title">', '</h3>' ); ?>
      <time datetime="<?php esc_attr( the_time('c') ); ?>" class="posts__date"><?php the_time( get_option('date_format') ); ?></time>
    </div>
  </a>
</article>
