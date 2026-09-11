<?php
/**
 * Comments and the comment form.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( post_password_required() ) {
	return;
}
?>

<?php if ( have_comments() ) : ?>
	<div id="comments" class="comment--items">
		<h2 class="h2">
			<?php
			$philosophy_comment_count = get_comments_number();

			printf(
				/* translators: %s: comment count. */
				esc_html( _n( '%s Comment', '%s Comments', $philosophy_comment_count, 'philosophy' ) ),
				esc_html( number_format_i18n( $philosophy_comment_count ) )
			);
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="commentlist">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 70,
					'callback'    => 'philosophy_comment_callback',
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>
	</div>
<?php endif; ?>

<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'philosophy' ); ?></p>
<?php endif; ?>

<?php
$philosophy_commenter = wp_get_current_commenter();
$philosophy_required  = get_option( 'require_name_email' );
$philosophy_aria_req  = $philosophy_required ? ' required aria-required="true"' : '';

$philosophy_fields = array(
	'author' => '<div class="form-field">'
		. '<label for="cName" class="screen-reader-text">' . esc_html__( 'Your Name', 'philosophy' ) . '</label>'
		. '<input class="full-width" placeholder="' . esc_attr__( 'Your Name', 'philosophy' ) . '" type="text" name="author" autocomplete="name" value="' . esc_attr( $philosophy_commenter['comment_author'] ) . '" id="cName"' . $philosophy_aria_req . '>'
		. '</div>',
	'email'  => '<div class="form-field">'
		. '<label for="cEmail" class="screen-reader-text">' . esc_html__( 'Your Email', 'philosophy' ) . '</label>'
		. '<input class="full-width" placeholder="' . esc_attr__( 'Your Email', 'philosophy' ) . '" type="email" name="email" autocomplete="email" value="' . esc_attr( $philosophy_commenter['comment_author_email'] ) . '" id="cEmail"' . $philosophy_aria_req . '>'
		. '</div>',
	'url'    => '<div class="form-field">'
		. '<label for="cWebsite" class="screen-reader-text">' . esc_html__( 'Website', 'philosophy' ) . '</label>'
		. '<input class="full-width" placeholder="' . esc_attr__( 'Website', 'philosophy' ) . '" type="url" name="url" autocomplete="url" value="' . esc_attr( $philosophy_commenter['comment_author_url'] ) . '" id="cWebsite">'
		. '</div>',
);

if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
	$philosophy_consent = empty( $philosophy_commenter['comment_author_email'] ) ? '' : ' checked="checked"';

	$philosophy_fields['cookies'] = '<div class="form-field"><p class="comment-form-cookies-consent">'
		. '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $philosophy_consent . '>'
		. '<label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'philosophy' ) . '</label>'
		. '</p></div>';
}

comment_form(
	array(
		'comment_field'      => '<div class="message form-field">'
			. '<label for="cMessage" class="screen-reader-text">' . esc_html__( 'Comment', 'philosophy' ) . '</label>'
			. '<textarea id="cMessage" class="full-width" rows="10" name="comment" placeholder="' . esc_attr__( 'Comment...', 'philosophy' ) . '" required aria-required="true"></textarea>'
			. '</div>',
		'id_form'            => 'contactForm',
		'title_reply'        => esc_html__( 'Leave a comment', 'philosophy' ),
		'title_reply_before' => '<h3 class="comment-reply-title">',
		'title_reply_after'  => '</h3>',
		'label_submit'       => esc_html__( 'Post Comment', 'philosophy' ),
		'class_submit'       => 'submit btn--primary btn--large full-width',
		'submit_button'      => '<button type="submit" name="%1$s" id="%2$s" class="%3$s">%4$s</button>',
		'fields'             => $philosophy_fields,
	)
);
