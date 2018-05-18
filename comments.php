<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package philosophy
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

<div class="col-full">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h3 class="h2">
			<?php
			$philosophy_comment_count = get_comments_number();
			if ( '1' === $philosophy_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One Comment', 'philosophy' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s Comment;', '%1$s Comments', $philosophy_comment_count, 'comments title', 'philosophy' ) ),
					number_format_i18n( $philosophy_comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h3><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="commentlist">
			<?php
				wp_list_comments( array(
					'type' => 'comment',
					'callback' => 'philosophy_comment',
				));
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'philosophy' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	$fields =  array(
		 
	  'author' =>
	    '<div class="form-field"><input id="author" name="author" type="text" class="full-width" value="' . esc_attr( $commenter['comment_author'] ) .
	    '" size="30" placeholder="' . esc_attr('Your Name', 'philosophy') . '" /></div>',

	  'email' =>
	    '<div class="form-field"><input id="email" name="email" type="text" class="full-width" value="' . esc_attr(  $commenter['comment_author_email'] ) .
	    '" size="30" placeholder="' . esc_attr('Your Email' , 'philosophy') . '" /></div>',

	  'url' =>
	    '<div class="form-field"><input id="url" name="url" type="text" class="full-width" value="' . esc_attr( $commenter['comment_author_url'] ) .
	    '" size="30" placeholder="' . esc_attr('Website', 'philosophy') . '" /></div>',
	);

	comment_form( array(
		  'id_form'           => 'commentform',
		  'class_form'      => 'comment-form',
		  'id_submit'         => 'submit',
		  'class_submit'      => 'submit',
		  'name_submit'       => 'submit',
		  'title_reply'       => esc_html__( 'Add Comment', 'philosophy'),
		  'title_reply_to'    => esc_html__( 'Add Comment to %s' , 'philosophy'),
		  'cancel_reply_link' => esc_html__( 'Cancel Reply' , 'philosophy'),
		  'label_submit'      => esc_html__( 'Submit' , 'philosophy'),
		  'format'            => 'xhtml',
		  'comment_field' =>  '<div class="message form-field"><textarea name="comment" class="full-width"  aria-required="true" placeholder="' . esc_attr__('Your Message', 'philosophy') . '">' .
		    '</textarea></div>',
		  'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		  'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="btn--primary btn--large full-width %3$s" value="%4$s" />'
		)
		
	);


	?>

</div><!-- #comments -->
