<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Alchemists
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php
// You can start editing here -- including this comment!
if ( have_comments() ) : ?>
<div id="comments" class="post-comments card card--lg">

	<header class="post-commments__header card__header">
    <h4><?php echo esc_html( 'Comments', 'alchemists' ) . ' (' . get_comments_number() . ')'; ?></h4>
  </header><!-- .post-commments__header -->

	<div class="post-comments__content card__content pb-0">

		<ol class="comments">
			<?php wp_list_comments('type=all&callback=alchemists_comments'); ?>
		</ol><!-- .comments -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav class="comment-navigation post__comments-pagination" role="navigation">
			<?php
			$args = array(
				'format' => '',
				'prev_text' => '<i class="fa fa-angle-left"></i>',
				'next_text' => '<i class="fa fa-angle-right"></i>'
			);
			paginate_comments_links( $args ); ?>
		</nav><!-- #comment-nav-below -->

		<?php endif; // Check for comment navigation.
		?>
	</div>

</div><!-- #comments -->
<?php endif; // Check for have_comments().
?>

<?php // If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

	<div class="alert alert-warning no-comments"><?php esc_html_e( 'Comments are closed.', 'alchemists' ); ?></div>

<?php
endif; ?>

<!-- Comment Form -->
<div class="post-comment-form card card--lg">
	<?php
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required=true" : '' );

		$comments_args = array(
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'class_form'           => 'post-comment-form__content card__content',
			'class_submit'         => 'btn btn-default btn-block btn-lg',
			'title_reply_before'   => '<header class="post-comment-form__header card__header"><h4>',
			'title_reply_after'    => '</h4></header>',
			'title_reply'          => esc_html__( 'Leave a Reply', 'alchemists' ),
			'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'alchemists' ),
			'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'alchemists' ),
			'label_submit'         => esc_html__( 'Post Your Comment', 'alchemists' ),

			'comment_field'        =>
				'<div class="comment-form-message form-group">' .
				'<label class="control-label" for="comment">' . esc_attr__( 'Your Comment', 'alchemists' ) . '</label>' .
				'<textarea id="comment" name="comment" cols="30" rows="7" class="form-control" aria-required="true">' .
				'</textarea>' .
				'</div>',

			'comment_notes_before' => '',
			'comment_notes_after'  => '',
			'must_log_in'          => '<div class="alert alert-warning">' .  sprintf( wp_kses( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'alchemists' ), array('a' => array( 'href' => array() ))), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</div>',

			'fields' => apply_filters( 'comment_form_default_fields', array(

				'author' =>
					'<div class="row">' .
					'<div class="col-md-6">' .
					'<div class="comment-form-author form-group">' .
					'<label class="control-label" for="author">' . esc_attr__( 'Your Name', 'alchemists' ) . '</label>' .
					'<input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30"' . esc_attr( $aria_req ) . ' /></div>' .
					'</div>',

				'email' =>
					'<div class="col-md-6">' .
					'<div class="comment-form-email form-group">' .
					'<label class="control-label" for="email">' . esc_attr__( 'Email Address', 'alchemists' ) . '</label>' .
					'<input id="email" name="email" type="email" class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30"' . esc_attr( $aria_req ) . ' /></div>' .
					'</div>' .
					'</div>',
				)
			),
		);
		comment_form($comments_args);
	?>
</div>
<!-- Comment Form / End -->
