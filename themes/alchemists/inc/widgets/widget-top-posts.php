<?php
/**
 * Tabs
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.3.0
 * @version   2.2.0
 */


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}


/**
 * Widget class.
 */

class Alchemists_Widget_Top_Posts extends WP_Widget {


	/**
	 * Constructor.
	 *
	 * @access public
	 */
	function __construct() {

		$widget_ops = array(
			'classname' => 'widget-tabbed',
			'description' => esc_html__( 'Newest, Most Commented and Popular posts.', 'alchemists' ),
		);
		$control_ops = array(
			'id_base' => 'tabbed-widget'
		);

		parent::__construct( 'tabbed-widget', 'ALC: Top Posts', $widget_ops, $control_ops );

	}


	/**
	 * Outputs the widget content.
	 */

	function widget( $args, $instance ) {

		extract( $args );

		$title                 = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$posts_newest_count    = isset( $instance['posts_newest_count'] ) ? $instance['posts_newest_count'] : 3;
		$posts_commented_count = isset( $instance['posts_commented_count'] ) ? $instance['posts_commented_count'] : 3;
		$posts_popular_count   = isset( $instance['posts_popular_count'] ) ? $instance['posts_popular_count'] : 3;

		echo wp_kses_post( $before_widget );

		if( $title ) {
			echo wp_kses_post( $before_title ) . esc_html( $title ) . wp_kses_post( $after_title );
		}

		$alchemists_data = get_option('alchemists_data');
		$categories_toggle = isset( $alchemists_data['alchemists__posts-categories'] ) ? $alchemists_data['alchemists__posts-categories'] : 1;

		// Generate unique ID
		$unique_id = rand( 0, 9999 );
		?>

		<div class="widget-tabbed__tabs">
			<!-- Widget Tabs -->
			<ul class="nav nav-tabs nav-justified widget-tabbed__nav" role="tablist">
				<li role="presentation" class="active">
					<a href="#widget-tabbed-sm-newest-<?php echo esc_attr( $unique_id ); ?>" aria-controls="widget-tabbed-sm-newest-<?php echo esc_attr( $unique_id ); ?>" role="tab" data-toggle="tab"><?php esc_html_e( 'Newest', 'alchemists' ); ?></a>
				</li>
				<li role="presentation">
					<a href="#widget-tabbed-sm-commented-<?php echo esc_attr( $unique_id ); ?>" aria-controls="widget-tabbed-sm-commented-<?php echo esc_attr( $unique_id ); ?>" role="tab" data-toggle="tab"><?php esc_html_e( 'Most Commented', 'alchemists' ); ?></a>
				</li>
				<li role="presentation">
					<a href="#widget-tabbed-sm-popular-<?php echo esc_attr( $unique_id ); ?>" aria-controls="widget-tabbed-sm-popular-<?php echo esc_attr( $unique_id ); ?>" role="tab" data-toggle="tab"><?php esc_html_e( 'Popular', 'alchemists' ); ?></a>
				</li>
			</ul>

			<!-- Widget Tab panes -->
			<div class="tab-content widget-tabbed__tab-content">
				<!-- Newest -->
				<div role="tabpanel" class="tab-pane fade in active" id="widget-tabbed-sm-newest-<?php echo esc_attr( $unique_id ); ?>">

					<?php
						$args_newest = array(
							'posts_per_page'      => $posts_newest_count,
							'orderby'             => 'date',
							'no_found_rows'       => true,
							'post_status'         => 'publish',
							'ignore_sticky_posts' => true
						);

						// Start the Loop
						$newest_posts_query = new WP_Query( $args_newest );
						if ( $newest_posts_query->have_posts() ) :
					?>
					<ul class="posts posts--simple-list">

						<?php while ($newest_posts_query->have_posts()) : $newest_posts_query->the_post();

						// get post category class
						$post_class = alchemists_post_category_class(); ?>

						<li class="posts__item <?php echo esc_attr( $post_class ); ?>">
							<div class="posts__inner">

								<?php if ( $categories_toggle ) : ?>
									<?php alchemists_post_category_labels(); ?>
								<?php endif; ?>

								<h6 class="posts__title" title="<?php the_title_attribute(); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
								<time datetime="<?php the_time('c'); ?>" class="posts__date">
									<?php the_time( get_option('date_format') ); ?>
								</time>
								<div class="posts__excerpt">
									<?php echo alchemists_string_limit_words( get_the_excerpt(), 20); ?>
								</div>
							</div>
						</li>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>

					</ul>
					<?php endif; ?>
				</div>
				<!-- Commented -->
				<div role="tabpanel" class="tab-pane fade" id="widget-tabbed-sm-commented-<?php echo esc_attr( $unique_id ); ?>">

					<?php
						$args_commented = array(
							'posts_per_page'      => $posts_commented_count,
							'orderby'             => 'comment_count',
							'no_found_rows'       => true,
							'post_status'         => 'publish',
							'ignore_sticky_posts' => true
						);

						// Start the Loop
						$commented_posts_query = new WP_Query( $args_commented );
						if ( $commented_posts_query->have_posts() ) :
					?>
					<ul class="posts posts--simple-list">

						<?php while ($commented_posts_query->have_posts()) : $commented_posts_query->the_post();

						// get post category class
						$post_class = alchemists_post_category_class(); ?>

						<li class="posts__item <?php echo esc_attr( $post_class ); ?>">
							<div class="posts__inner">

								<?php if ( $categories_toggle ) : ?>
									<?php alchemists_post_category_labels(); ?>
								<?php endif; ?>

								<h6 class="posts__title" title="<?php the_title_attribute(); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
								<time datetime="<?php the_time('c'); ?>" class="posts__date">
									<?php the_time( get_option('date_format') ); ?>
								</time>
								<div class="posts__excerpt">
									<?php echo alchemists_string_limit_words( get_the_excerpt(), 20); ?>
								</div>
							</div>
						</li>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>

					</ul>
					<?php endif; ?>

				</div>
				<!-- Popular -->
				<div role="tabpanel" class="tab-pane fade" id="widget-tabbed-sm-popular-<?php echo esc_attr( $unique_id ); ?>">

					<?php
						$args_popular = array(
							'posts_per_page'      => $posts_popular_count,
							'orderby'             => '_post_like_count',
							'meta_key'            => '_post_like_count',
							'no_found_rows'       => true,
							'post_status'         => 'publish',
							'ignore_sticky_posts' => true
						);

						// Start the Loop
						$popular_posts_query = new WP_Query( $args_popular );
						if ( $popular_posts_query->have_posts() ) :
					?>
					<ul class="posts posts--simple-list">

						<?php while ($popular_posts_query->have_posts()) : $popular_posts_query->the_post();

						// get post category class
						$post_class = alchemists_post_category_class(); ?>

						<li class="posts__item <?php echo esc_attr( $post_class ); ?>">
							<div class="posts__inner">

								<?php if ( $categories_toggle ) : ?>
									<?php alchemists_post_category_labels(); ?>
								<?php endif; ?>

								<h6 class="posts__title" title="<?php the_title_attribute(); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
								<time datetime="<?php the_time('c'); ?>" class="posts__date">
									<?php the_time( get_option('date_format') ); ?>
								</time>
								<div class="posts__excerpt">
									<?php echo alchemists_string_limit_words( get_the_excerpt(), 20); ?>
								</div>
							</div>
						</li>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>

					</ul>
					<?php endif;?>

				</div>
			</div>

		</div>


		<?php echo wp_kses_post( $after_widget );
	}

	/**
	 * Updates a particular instance of a widget.
	 */

	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title']                 = strip_tags( $new_instance['title'] );
		$instance['posts_newest_count']    = $new_instance['posts_newest_count'];
		$instance['posts_commented_count'] = $new_instance['posts_commented_count'];
		$instance['posts_popular_count']   = $new_instance['posts_popular_count'];

		return $instance;
	}


	/**
	 * Outputs the settings update form.
	 */

	function form( $instance ) {

		$defaults = array(
			'title'                 => '',
			'posts_newest_count'    => 3,
			'posts_commented_count' => 3,
			'posts_popular_count'   => 3,
			'show_newest_posts'     => 'on',
			'show_commented_posts'  => 'on',
			'show_popular_posts'    => 'on',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'alchemists' ); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_newest_count' ) ); ?>"><?php esc_html_e( 'Number of newest posts:', 'alchemists' ); ?></label>
			<input class="tiny-text" type="number" id="<?php echo esc_attr( $this->get_field_id( 'posts_newest_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_newest_count' ) ); ?>" step="1" min="1" size="3" value="<?php echo esc_attr( $instance['posts_newest_count'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_commented_count' ) ); ?>"><?php esc_html_e( 'Number of most commented posts:', 'alchemists' ); ?></label>
			<input class="tiny-text" type="number" id="<?php echo esc_attr( $this->get_field_id( 'posts_commented_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_commented_count' ) ); ?>" step="1" min="1" size="3" value="<?php echo esc_attr( $instance['posts_commented_count'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_popular_count' ) ); ?>"><?php esc_html_e( 'Number of popular posts:', 'alchemists' ); ?></label>
			<input class="tiny-text" type="number" id="<?php echo esc_attr( $this->get_field_id( 'posts_popular_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_popular_count' ) ); ?>" step="1" min="1" size="3" value="<?php echo esc_attr( $instance['posts_popular_count'] ); ?>" />
		</p>

		<?php

	}
}

register_widget('Alchemists_Widget_Top_Posts');
