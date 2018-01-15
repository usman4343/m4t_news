<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 		Dan Fisher
 * @package 	Alchemists
 * @version   1.1.0
 */

?>

<?php

$alchemists_data   = get_option('alchemists_data');
$categories_toggle = isset( $alchemists_data['alchemists__posts-categories'] ) ? $alchemists_data['alchemists__posts-categories'] : 1;

// get post category class
$post_class = alchemists_post_category_class();

$post_classes = array(
	'posts__item',
	'posts__item--card',
  'posts__item--card-condensed',
	$post_class,
);

?>

<article <?php post_class( $post_classes ); ?>>
	<?php if( has_post_thumbnail() ) { ?>
	<figure class="posts__thumb">

    <?php if ( $categories_toggle ) : ?>
      <?php alchemists_post_category_labels(); ?>
    <?php endif; ?>

		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'alchemists_thumbnail-alt' ); ?></a>
	</figure>
	<?php } ?>

	<div class="posts__inner card__content">
		<?php if( has_post_thumbnail() ) { ?>
		<a href="<?php the_permalink(); ?>" class="posts__cta"></a>
		<?php } ?>
		<time datetime="<?php esc_attr( the_time('c') ); ?>" class="posts__date"><?php the_time( get_option('date_format') ); ?></time>
		<?php the_title( '<h6 class="posts__title posts__title--sm"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h6>' ); ?>
		<div class="posts__excerpt">
			<?php echo alchemists_string_limit_words( get_the_excerpt(), 14 ); ?>
		</div>
	</div>
</article><!-- #post-## -->
