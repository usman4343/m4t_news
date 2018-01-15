<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<header class="product-tabs__header">
			<h2 class="woocommerce-Reviews-title"><?php
				if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) ) {
					/* translators: 1: reviews count 2: product name */
					printf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'alchemists' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
				} else {
					esc_html_e( 'Reviews', 'alchemists' );
				}
			?></h2>
		</header>

		<?php if ( have_comments() ) : ?>

			<ol class="comments comments--left-thumb">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<div class="alert alert-info woocommerce-noreviews"><strong><?php esc_html_e( 'There are no reviews yet.', 'alchemists' ); ?></strong></div>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'alchemists' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'alchemists' ), get_the_title() ),
						'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'alchemists' ),
						'title_reply_before'   => '<header class="product-tabs__header"><h2 id="reply-title" class="comment-reply-title">',
						'title_reply_after'    => '</h2></header>',
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<div class="row"><div class="col-md-6"><div class="form-group comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'alchemists' ) . ' <span class="required">*</span></label> ' .
										'<input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></div></div>',
							'email'  => '<div class="col-md-6"><div class="form-group comment-form-email"><label for="email">' . esc_html__( 'Email', 'alchemists' ) . ' <span class="required">*</span></label> ' .
										'<input id="email" name="email" type="email" class="form-control" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></div></div></div>',
						),
						'label_submit'  => esc_html__( 'Submit Review', 'alchemists' ),
						'logged_in_as'  => '',
						'comment_field' => '',
					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'alchemists' ), esc_url( $account_page_url ) ) . '</p>';
					}

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<div class="form-group"><label for="rating" class="control-label">' . esc_html__( 'Your rating', 'alchemists' ) . '</label><select name="rating" id="rating-custom" aria-required="true" class="form-control" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'alchemists' ) . '</option>
							<option value="5">' . esc_html__( '5 Stars - Perfect', 'alchemists' ) . '</option>
							<option value="4">' . esc_html__( '4 Stars - Good', 'alchemists' ) . '</option>
							<option value="3">' . esc_html__( '3 Stars - Average', 'alchemists' ) . '</option>
							<option value="2">' . esc_html__( '2 Stars - Not that bad', 'alchemists' ) . '</option>
							<option value="1">' . esc_html__( '1 Star - Very poor', 'alchemists' ) . '</option>
						</select></div>';
					}

					$comment_form['comment_field'] .= '<div class="form-group comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'alchemists' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true" required></textarea></div>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<div class="alert alert-warning mb-0 woocommerce-verification-required"><strong><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'alchemists' ); ?></strong></div>

	<?php endif; ?>

</div>
