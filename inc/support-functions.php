<?php 
/**
 * @Packge     : Philosophy
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
    // Block direct access
    if( !defined( 'ABSPATH' ) ){
        exit( 'Direct script access denied.' );
    }


// Post Category
function philosophy_post_cats( $args = array() ){
    
    
    $default = array(
        'wrp_start'         => '',
        'wrp_end'           => '',
        'before_tag_start'  => '',
        'before_tag_end'    => '',
        'label'             => '',
        'tag'               => '',
        'tag_class'         => '',
        'link'              => true,
    );

    $args = wp_parse_args( $args, $default );

	$cats = get_the_category();
	$categories = '';
    if( $cats ){
        // Wrapper 
        $wrpStart = $wrpEnd = '';

        if( !empty( $args['wrp_start'] ) ){
            $wrpStart = $args['wrp_start'];
            $wrpEnd   = $args['wrp_end'];
        }

        // Before tag
        $btagStart =  $btagEnd = '';
        if( !empty( $args['before_tag_start'] ) ){

            $btagStart  = $args['before_tag_start'];
            $btagEnd    = $args['before_tag_end'];
        }
        $categories .= $wrpStart;
        $categories .= !empty( $args['label'] ) ? $args['label'] : '';
        // Category loop
        foreach( $cats as $cat ){

            $tagStart = $tagEnd = $href = '';

            // link 
            if( !empty( $args['link'] ) ){

                $href = ' href="'.esc_url( get_category_link( $cat->term_id ) ).'"';
            }

            // Tag
            if( !empty( $args['tag'] ) ){   
                $tag = $args['tag'];
                $tagStart = '<'.esc_attr( $tag ).$href.( !empty( $args['tag_class'] ) ? ' class="'.esc_attr( $args['tag_class'] ).'"' : ''  ).'>';
                $tagEnd   = '</'.esc_attr( $tag ).'>';
            }

            $categories .= $btagStart.$tagStart.esc_html( $cat->name ).$tagEnd.$btagEnd;

        }

        $categories .= $wrpEnd;
    }
	
	return $categories;
	
}

// Post Tags
function philosophy_post_tags(){
    
    $tags = get_the_tags();
    
    $getTags = '';
    
    if( $tags ){

        foreach( $tags as $tag ){
            $getTags .= '<a href="'.esc_url( get_tag_link( $tag->term_id ) ).'" class="tag-item">'.esc_html( $tag->name ).'</a>';
        }
    
    }
    
    return $getTags;
    
}

/**
 * Alias of philosophy_post_tags(), kept for child themes.
 *
 * @return string
 */
function philosophy_tags_list(){
    return philosophy_post_tags();
}

// philosophy comment template callback
function philosophy_comment_callback( $comment, $args, $depth ) {
    
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment--item">
    <?php endif; ?>
        <div class="comment--meta-info">
    		<div class="comment--meta-img comment__avatar">
    			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    		</div>
            <div class="comment__info">
                <cite><span class="comment-author-name"><?php echo wp_kses_post( get_comment_author_link( $comment ) ); ?></span></cite>
                <div class="comment__meta">
                    <time class="comment__time" datetime="<?php echo esc_attr( get_comment_date( DATE_W3C, $comment ) ); ?>">
                        <?php
                        printf(
                            /* translators: 1: comment date, 2: comment time. */
                            esc_html__( '%1$s at %2$s', 'philosophy' ),
                            esc_html( get_comment_date( '', $comment ) ),
                            esc_html( get_comment_time( '', false, true, $comment ) )
                        );
                        ?>
                    </time>
                    <?php edit_comment_link( esc_html__( '(Edit)', 'philosophy' ), ' ', '' ); ?>

                    <?php if ( '0' === $comment->comment_approved ) : ?>
                        <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'philosophy' ); ?></em>
                    <?php endif; ?>

                    <?php
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => $add_below,
                                'depth'     => $depth,
                                'max_depth' => isset( $args['max_depth'] ) ? $args['max_depth'] : 5,
                                'reply_text' => esc_html__( 'Reply', 'philosophy' ),
                            )
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
		<div class="comment__content">

			<div class="comment__text">
				<?php comment_text(); ?>
				
			</div> 
		</div>
			
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
    <?php  
}

// Comment textarea field top to bottom
function philosophy_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    
    return $fields;
}
add_filter( 'comment_form_fields', 'philosophy_move_comment_field_to_bottom' );

// add class comment reply link
add_filter('comment_reply_link', 'philosophy_replace_reply_link_class');
function philosophy_replace_reply_link_class( $class ){
    $class = str_replace("class='comment-reply-link", "class='reply", $class);
    return $class;
}

//  contact form 7 Shortcode list
function philosophy_contact_form7_shortcode(){

    // contact form list
    $getforms['cs'] = __( 'Custom Shortcode', 'philosophy' );
    // Instruction
    $Instruction = ''; 

    if( defined('WPCF7_VERSION') ){
        $forms = get_posts(
            array(
                'post_type'              => 'wpcf7_contact_form',
                'posts_per_page'         => 100,
                'post_status'            => 'publish',
                'no_found_rows'          => true,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
            )
        );

        if ( $forms ) {
            foreach ( $forms as $form ) {
                $getforms[ $form->ID ] = $form->post_title;
            }
        } else {
            $Instruction = __( 'Contact form not found.', 'philosophy' );
        }
    }else{
        $url = admin_url( 'plugins.php' );
        
        $Instruction = sprintf( __( 'If you want to use contact form 7, Please install and active contact form 7 plugin. %s Click here to install %s  ' , 'philosophy' ), '<a target="_blank" href="'.esc_url( $url ).'">', '</a>'  );
    }

    $data = [ $getforms, $Instruction ];

    return $data;

}
// Set contact form 7 default form template
function philosophy_contact7_form_content( $template, $prop ) {
  if ( 'form' == $prop ) {

        $template =
            '<div id="cForm">
                <fieldset>
                    <div class="form-field">
                        [text* cName id:cName class:full-width placeholder "Your Name"]
                    </div>
                    <div class="form-field">
                        [email* cEmail id:cEmail class:full-width placeholder "Your Email"]
                    </div>
                    <div class="form-field">
                        [text* cWebsite id:cWebsite class:full-width placeholder "Website"]
                    </div>
                    <div class="message form-field">
                    [textarea cMessage id:cMessage class:full-width placeholder "Your Message"]
                    </div>
                    [submit class:submit class:btn class:btn--primary class:full-width "Submit"]
                </fieldset>
            </div>';
        return $template;

  } else {
    return $template;
  } 
}
add_filter( 'wpcf7_default_template', 'philosophy_contact7_form_content', 10, 2 );

/**
 * Increments the view counter the Popular Posts widget orders by.
 *
 * Skipped for previews, feeds, logged-in editors looking at their own drafts
 * and anything that is not a real front-end request, so the count reflects
 * readers rather than traffic of every kind.
 *
 * @param int $post_id Post ID.
 */
function philosophy_set_post_views( $post_id ) {
    $post_id = absint( $post_id );

    if ( ! $post_id || is_preview() || is_feed() || is_robots() || wp_doing_ajax() || wp_is_json_request() ) {
        return;
    }

    if ( 'publish' !== get_post_status( $post_id ) ) {
        return;
    }

    $count_key = 'philosophy_post_views_count';
    $count     = (int) get_post_meta( $post_id, $count_key, true );

    update_post_meta( $post_id, $count_key, $count + 1 );
}

// blog post categoty 
function philosophy_get_post_cat(){
    $cats = get_categories();

    $categories = array( 'na' => esc_html__( 'Select post category', 'philosophy' ) );
    foreach ( $cats as $value ) {
        
        $categories[$value->slug] = $value->name;

    }

    return $categories;
}
?>