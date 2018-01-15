<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * @author 		Dan Fisher
 * @package 	Alchemists
 * @since     1.0.0
 * @version   2.1.0
 *
 * Shortcode attributes
 * @var $atts
 * @var $post_id
 * @var $post_style
 * @var $image
 * @var $disable_excerpt
 * @var $custom_excerpt
 * @var $excerpt_size
 * @var $disable_btn
 * @var $btn
 * @var $disable_date
 * @var $custom_date
 * @var $disable_cats
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Alc_Featured_Post
 */

$post_id = $post_style = $image = $disable_excerpt = $custom_excerpt = $excerpt_size = $disable_btn = $btn = $disable_date = $custom_date = $disable_cats = $el_class = $el_id = $css = $css_animation = '';
$a_href = $a_title = $a_target = $a_rel = '';
$attributes = array();

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'main-news-banner';
if ( $post_style == 'style_1' ) {
	$class_to_filter .= ' main-news-banner--img-left';
} elseif ( $post_style == 'style_2' ) {
	$class_to_filter .= ' main-news-banner--bg';
}
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

//parse link
$btn = ( '||' === $btn ) ? '' : $btn;
$btn = vc_build_link( $btn );
$use_link = false;
if ( strlen( $btn['url'] ) > 0 ) {
	$use_link = true;
	$a_href = $btn['url'];
	$a_title = $btn['title'];
	$a_target = $btn['target'];
	$a_rel = $btn['rel'];
}

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
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


// Posts arguments
$args = array(
  'p'              => $post_id,
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 1,
);

// echo '<pre>' . var_export($taxonomies_tags, true) . '</pre>';

$query = new WP_Query($args);

// Post Template
$post_template = '';

// Check for Posts Layout
if ( $post_style == 'style_1' ) {

	$posts_classes_array = array(
		'posts',
		'posts--simple-list',
    'posts--simple-list--xlg',
	);
	$post_template = 'post-featured-primary';

} else {

	$posts_classes_array = array(
		'posts',
		'posts--simple-list',
    'posts--simple-list--xlg',
	);
  $post_template = 'post-featured-secondary';
}

$posts_classes = implode( " ", $posts_classes_array );


$alchemists_data   = get_option('alchemists_data');
$categories_toggle = isset( $alchemists_data['alchemists__posts-categories'] ) ? $alchemists_data['alchemists__posts-categories'] : 1;

// button attributes
$attributes = implode( ' ', $attributes );

?>

<!-- Main News Banner -->
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">

  <?php
  if ( $query->have_posts() ) :

  while ( $query->have_posts() ) : $query->the_post();

    // get post category class
    $post_class = alchemists_post_category_class();

    $post_item_classes = array(
    	'posts__item',
    	$post_class
    ); ?>

    <?php if ( !empty( $image ) and $post_style == 'style_1' ) : ?>
    <figure class="main-news-banner__img">
      <img src="<?php echo esc_url( wp_get_attachment_url( $atts['image'] ) ); ?>" alt="">
    </figure>
    <?php endif; ?>

    <div class="main-news-banner__inner">
      <div class="<?php echo esc_attr( $posts_classes ); ?>">
        <div <?php post_class( $post_item_classes ); ?>>
          <div class="posts__inner">

            <?php if ( empty( $disable_cats ) && $categories_toggle ) : ?>
              <?php alchemists_post_category_labels(); ?>
            <?php endif; ?>

            <?php
            if ( !empty( $content ) ) :
              echo '<h6 class="posts__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . wp_kses_post( $content ) . '</a></h6>';
            else :
              the_title( '<h6 class="posts__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h6>' );
            endif;
            ?>

            <?php if ( empty( $disable_date )) : ?>
              <?php if ( strlen( $custom_date ) > 0 ) { ?>
                <div class="posts__date"><?php echo esc_html( $custom_date ); ?></div>
              <?php } else { ?>
                <time datetime="<?php esc_attr( the_time('c') ); ?>" class="posts__date"><?php the_time( get_option('date_format') ); ?></time>
              <?php } ?>
            <?php endif; ?>

            <?php if ( empty( $disable_excerpt ) ) : ?>
            <div class="posts__excerpt">
              <?php if ( strlen( $custom_excerpt ) > 0 ) {
                echo esc_html( $custom_excerpt );
              } else {
                echo alchemists_string_limit_words( get_the_excerpt(), intval( $excerpt_size ) );
              } ?>
            </div>
            <?php endif; ?>

            <?php if ( empty( $disable_btn ) ) : ?>
            <div class="posts__more">
              <?php if ( $use_link ) : ?>
                <?php echo '<a class="btn btn-inverse btn-sm btn-outline btn-icon-right btn-condensed" ' . $attributes . '>' . $a_title . '<i class="fa fa-plus text-primary"></i></a>'; ?>
              <?php else : ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-inverse btn-sm btn-outline btn-icon-right btn-condensed"><?php esc_html_e( 'Read More', 'alchemists' ); ?> <i class="fa fa-plus text-primary"></i></a>
              <?php endif; ?>
            </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>

  <?php endwhile; ?>

  <?php // Reset the global $the_post as this query will have stomped on it
  wp_reset_postdata(); ?>

  <?php else :

    get_template_part( 'template-parts/content', 'none' );

  endif; ?>

</div>
<!-- Main News Banner / End -->
