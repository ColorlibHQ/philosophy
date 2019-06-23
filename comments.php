<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit( 'Direct script access denied.' );
}
/**
 * @Packge     : Philosophy
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 


if ( post_password_required() ) 
{
    return;
}
?>

    <?php if ( have_comments() ) : ?>
		<div id="comments" class="comment--items"> <!-- Comment Item Start-->
        <h3 class="h2"><?php printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'philosophy' ), number_format_i18n( get_comments_number() ) ); ?></h3>
		
        <?php the_comments_navigation(); ?>
            <ol class="commentlist">
                <?php
                    wp_list_comments( array(
                        'style'       => 'ol',
                        'short_ping'  => true,
                        'avatar_size' => 70,
                        'callback'    => 'philosophy_comment_callback'
                    ) );
                ?>
            </ol><!-- .comment-list -->
        <?php the_comments_navigation(); ?>
		</div><!-- Comment Item End-->
    <?php endif; // Check for have_comments(). ?>

    <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'philosophy' ); ?></p>
    <?php endif; ?>
    
<?php
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? "required='required'" : '' );
	$fields =  array(
	  'author' =>'<div class="form-field"><input class="full-width" placeholder="'.esc_attr__( 'Your Name', 'philosophy' ).'" type="text" name="author" value="'. esc_attr( $commenter['comment_author'] ).'" id="cName" '.$aria_req.'></div>',
	  'email' =>'<div class="form-field"><input class="full-width" placeholder="'.esc_attr__( 'Your Email', 'philosophy' ).'" type="text" name="email"  value="' . esc_attr(  $commenter['comment_author_email'] ) .'" id="cEmail" '.$aria_req.'></div>',
	  'url' =>'<div class="form-field"><input class="full-width" placeholder="'.esc_attr__( 'Website', 'philosophy' ).'" type="text" name="url" value="'. esc_attr( $commenter['comment_author_url'] ) .'" id="cWebsite"></div>',
      'cookies_consent' =>'<div class="form-field"><p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" value="yes" type="checkbox"><label for="wp-comment-cookies-consent">'.esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'philosophy' ).'</label></p></div>',
	);
	

	$args=array(
	'comment_field'         =>'<div class="message form-field"><textarea id="cMessage" class="full-width" rows="10" name="comment" placeholder="'.esc_attr__( 'Comment...', 'philosophy' ).'"></textarea></div>',
	'id_form'               =>'contactForm',
    'class_form'            =>'',
	'title_reply'           =>esc_html__( 'LEAVE A COMMENT', 'philosophy' ),
	'title_reply_before'    =>'<h4>',
	'title_reply_after'     =>'</h4>',
    'label_submit'          => esc_html__( 'Post Comment', 'philosophy' ),
    'class_submit'          => 'submit btn--primary btn--large full-width',
	'submit_button'         => '<button type="submit" name="%1$s" id="%2$s" class="%3$s">%4$s</button>',
	'fields'                =>$fields,
	
	);
    
    // Comments form
	comment_form( $args );
    

?>
<!-- .comments-area -->
