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
  'card',
	$post_class
);

?>

<article <?php post_class( $post_classes ); ?>>
	<?php if( has_post_thumbnail() ) { ?>
	<figure class="posts__thumb">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('alchemists_thumbnail-lg'); ?></a>
	</figure>
	<?php } ?>

	<div class="posts__inner card__content">
    <a href="<?php the_permalink(); ?>" class="posts__cta"></a>

    <?php if ( $categories_toggle ) : ?>
      <?php alchemists_post_category_labels(); ?>
    <?php endif; ?>

		<?php the_title( '<h2 class="posts__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		<time datetime="<?php esc_attr( the_time('c') ); ?>" class="posts__date"><?php the_time( get_option('date_format') ); ?></time>
		<div class="posts__excerpt">
			<?php the_excerpt(); ?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'alchemists' ),
					'after'  => '</div>',
				) );
			?>
		</div>
	</div>

	<footer class="posts__footer card__footer">
		<?php alchemists_entry_footer(); ?>
	</footer>

</article><!-- #post-## -->
