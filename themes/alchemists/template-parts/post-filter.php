<?php
/**
 * Template part for displaying a post filter
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   2.2.0
 */

$alchemists_data    = get_option('alchemists_data');
$posts_filter       = isset( $alchemists_data['alchemists__posts-filter-sorter']['enabled'] ) ? $alchemists_data['alchemists__posts-filter-sorter']['enabled'] : array();

?>

<?php if ( sizeof( $posts_filter ) > 1 ) : ?>
<!-- Post Filter -->
<div class="post-filter">
	<div class="container">
		<form action="#" class="post-filter__form clearfix">

			<?php if ( $posts_filter ) : foreach( $posts_filter as $posts_filter_key => $posts_filter_label ) {

				switch ( $posts_filter_key ) {

					// Category
					case 'filter__category': ?>
					<div class="post-filter__select">
						<label class="post-filter__label"><?php esc_html_e( 'Category', 'alchemists' ); ?></label>
						<select class="cs-select cs-skin-border" name="cat">
							<option value=""><?php esc_html_e( 'All Articles', 'alchemists' ); ?></option>

							<?php
								if( $terms = get_terms( 'category', 'orderby=name' ) ) : // check for post categories
									foreach ( $terms as $term ) :
										$selected_cat = ( isset( $_GET['cat'] ) ? selected( $_GET['cat'], $term->term_id ) : '');
										echo '<option ' . $selected_cat . ' value="' . esc_attr( $term->term_id ) . '">' . esc_html( $term->name ) . '</option>'; // ID of the category as the value of an option
									endforeach;
								endif;
							?>

						</select>
					</div>
					<?php break;

					// Orderby
					case 'filter__orderby' : ?>
					<div class="post-filter__select">
						<label class="post-filter__label"><?php esc_html_e( 'Order By', 'alchemists' ); ?></label>
						<select class="cs-select cs-skin-border" name="orderby">
							<?php
								$orderby_options = array(
									'post_date'     => esc_html__( 'Article Date', 'alchemists' ),
									'post_title'    => esc_html__( 'Article Title', 'alchemists' ),
									'ID'            => esc_html__( 'Article ID', 'alchemists' ),
									'comment_count' => esc_html__( 'Comments Count', 'alchemists' ),
									'rand'          => esc_html__( 'Random', 'alchemists' ),
								);

								foreach( $orderby_options as $value => $label ) {
									$selected_orderby = ( isset( $_GET['orderby'] ) ? selected( $_GET['orderby'], $value ) : '');
									echo '<option ' . $selected_orderby . ' value=' . esc_attr( $value ) . '>' . esc_html( $label ) . '</option>';
								}
							?>
						</select>
					</div>
					<?php break;

					// Order
					case 'filter__order' : ?>
					<div class="post-filter__select">
						<label class="post-filter__label"><?php esc_html_e( 'Order', 'alchemists' ); ?></label>
						<select class="cs-select cs-skin-border" name="order">
							<?php
								$order_options = array(
									'DESC' => esc_html__( 'Descending', 'alchemists' ),
									'ASC'  => esc_html__( 'Ascending', 'alchemists' ),
								);
								foreach( $order_options as $value => $label ) {
									$selected_order = ( isset( $_GET['order'] ) ? selected( $_GET['order'], $value ) : '');
									echo '<option ' . $selected_order . ' value=' . esc_attr( $value ). '>' . esc_html( $label ) . '</option>';
								}
							?>
						</select>
					</div>
					<?php break;

					// Author
					case 'filter__author' : ?>
					<div class="post-filter__select">
						<label class="post-filter__label"><?php esc_html_e( 'Author', 'alchemists' ); ?></label>
						<select class="cs-select cs-skin-border" name="author">
							<option value=""><?php esc_html_e( 'All Authors', 'alchemists' ); ?></option>
							<?php

							$args_users = array(
								'who'     => 'authors',
								'number'  => 999,
								'orderby' => 'post_count',
								'order'   => 'DESC',
							);

							$users = get_users( $args_users );

							if( !empty( $users ) ) {
								foreach( $users as $user ) {
									$selected_author = ( isset( $_GET['author'] ) ? selected( $_GET['author'], $user->ID ) : '');
									echo '<option ' . $selected_author . ' value=' . esc_attr( $user->ID ) . '>' . esc_html( $user->display_name ) . '</option>';
								}
							} ?>

						</select>
					</div>
					<?php break;

				} // end switch
			} // end foreach
			endif; ?>

			<div class="post-filter__submit">
				<button type="submit" class="btn btn-default btn-lg btn-block"><?php esc_html_e( 'Filter News', 'alchemists' ); ?></button>
			</div>
		</form>
	</div>
</div>
<!-- Post Filter / End -->
<?php endif; ?>
