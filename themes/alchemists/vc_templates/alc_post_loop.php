<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $link
 * @var $items_per_page
 * @var $offset
 * @var $posts_layout
 * @var $taxonomies_categories
 * @var $taxonomies_tags
 * @var $order
 * @var $order_by
 * @var $disable_excerpt
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Alc_Post_Loop
 */

$title = $link = $items_per_page = $offset = $posts_layout = $taxonomies_categories = $taxonomies_tags = $order = $order_by = $disable_excerpt = $el_class = $el_id = $css = $css_animation = '';
$a_href = $a_title = $a_target = $a_rel = '';
$attributes = array();

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'card card--clean mb-0';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

//parse link
$link = ( '||' === $link ) ? '' : $link;
$link = vc_build_link( $link );
$use_link = false;
if ( strlen( $link['url'] ) > 0 ) {
	$use_link = true;
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'];
	$a_rel = $link['rel'];
}

if ( $use_link ) {
	$attributes[] = 'href="' . trim( $a_href ) . '"';
	$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
	if ( ! empty( $a_target ) ) {
		$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
	}
	if ( ! empty( $a_rel ) ) {
		$attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
	}
}

$attributes = implode( ' ', $attributes );


// Posts arguments
$args = array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => $items_per_page,
	'order'          => $order,
	'orderby'        => $order_by,
	'offset'         => $offset,
	'no_found_rows'       => true,
	'ignore_sticky_posts' => true
);

// filter by categories
if( !empty( $taxonomies_categories ) ) {
	$args['category_name'] = $taxonomies_categories;
}

// filter by tags
if( !empty( $taxonomies_tags ) ) {
	$args['tag'] = $taxonomies_tags;
}

// echo '<pre>' . var_export($taxonomies_tags, true) . '</pre>';

$query = new WP_Query($args);

// Post Template
$post_template = '';

// Check for Posts Layout
if ( $posts_layout == 'grid_2cols' ) {

	$posts_classes_array = array(
		'posts',
		'posts--cards',
		'post-grid',
		'post-grid--2cols',
		'post-grid--fitRows',
		'row',
	);
	$post_template = 'blog-1';

} elseif ( $posts_layout == 'grid_1col' ) {

	$posts_classes_array = array(
		'posts',
		'posts--cards',
		'post-grid',
		'post-grid--1col',
		'row',
	);
	$post_template = 'card-1col';

} elseif ( $posts_layout == 'list_simple' ) {

	$posts_classes_array = array(
		'posts',
		'posts--simple-list',
		'posts--simple-list--lg',
	);
	$post_template = 'blog-list-simple';

} elseif ( $posts_layout == 'list_simple_1st_ext' ) {

	$posts_classes_array = array(
		'posts',
		'posts--simple-list',
		'posts--simple-list-condensed',
	);
	$post_template = 'blog-list-simple';

} elseif ( $posts_layout == 'list_simple_hor' ) {

	$posts_classes_array = array(
		'posts',
		'posts--simple-list',
		'posts--horizontal',
	);
	$post_template = 'blog-list-simple';

} elseif ( $posts_layout == 'list_thumb_sm' ) {

	$posts_classes_array = array(
		'posts',
		'posts--simple-list',
	);
	$post_template = 'blog-list-thumb-sm';

}  elseif ( $posts_layout == 'masonry' ) {

	$posts_classes_array = array(
		'posts',
		'posts--cards',
		'post-grid',
		'post-grid--masonry',
		'row',
	);
	$post_template = 'blog-4';

} else {

	$posts_classes_array = array(
		'posts',
		'posts--cards',
		'posts--cards-thumb-left',
		'post-list',
	);
}

// Disable Excerpt
if( !empty( $disable_excerpt ) ) {
	$posts_classes_array[] = 'posts--excerpt-hide';
}

$posts_classes = implode( " ", $posts_classes_array );

?>


<!-- Post Loop -->
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">

	<?php if ( $title ) { ?>
		<div class="card__header">
			<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>

			<?php if ( $use_link ) {
				echo '<a class="btn btn-default btn-outline btn-xs card-header__button" ' . $attributes . '>' . $a_title . '</a>';
			} ?>
		</div>
	<?php } ?>

	<div class="card__content">

		<?php
		if ( $query->have_posts() ) : ?>

			<?php if ( $posts_layout == 'list_simple' || $posts_layout == 'list_simple_hor' || $posts_layout == 'list_simple_1st_ext' || $posts_layout == 'list_thumb_sm' ) : ?>
			<div class="card"><div class="card__content">
			<?php endif; ?>

			<div class="<?php echo esc_attr( $posts_classes ); ?>">

				<?php /* Start the Loop */
				$counter = 0;
				while ( $query->have_posts() ) : $query->the_post();
					$counter++;

					if ( $posts_layout == 'list_simple_1st_ext' ) {
						if ( $counter == 1 ) {
							get_template_part( 'template-parts/content', 'blog-list-simple-ext' );
						} else {
							get_template_part( 'template-parts/content', $post_template );
						}
					} else {
						get_template_part( 'template-parts/content', $post_template );
					}

				endwhile; ?>

			</div><!-- .posts -->

			<?php if ( $posts_layout == 'list_simple' || $posts_layout == 'list_simple_hor' || $posts_layout == 'list_simple_1st_ext' || $posts_layout == 'list_thumb_sm' ) : ?>
			</div></div>
			<?php endif; ?>

			<?php // Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata(); ?>

		<?php else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	</div>



</div>
<!-- Post Loop / End -->
