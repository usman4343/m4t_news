<?php
/**
 * Template part for displaying posts on a Single Post Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Alchemists
 */

?>

<?php

$post_classes = array(
	'card',
	'card--lg',
	'post',
	'post--single',
	'post--extra-top',
);

?>

<!-- Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>

	<div class="card__content">

		<div class="post__content">

			<?php the_content(); ?>

		</div>

		<footer class="post__footer">

			<?php $terms = get_the_terms( $post->ID, 'post_tag' );
				if ($terms && ! is_wp_error($terms)): ?>
				<div class="post__tags">
			    <?php foreach($terms as $term): ?>
		        <a href="<?php echo esc_url( get_term_link( $term->slug, 'post_tag') ); ?>" rel="tag" class="tag-link-<?php echo esc_attr( $term->slug ); ?> btn btn-primary btn-outline btn-xs"><?php echo esc_html( $term->name ); ?></a>
			    <?php endforeach; ?>
				</div>
			<?php endif; ?>

		</footer>
	</div>
</article>
