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

// get Tags
function philosophy_tags_list(){
	
	$tags = get_the_tags();
	
	$getTags = '';
	
	if( $tags ){

		foreach( $tags as $tag ){
			$getTags .= '<a href="'.esc_url( get_tag_link( $tag->term_id ) ).'" class="tag-item">'.esc_html( $tag->name ).'</a>';
		}
	
	}
	
	return $getTags;
	
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
                <cite><?php printf( __( '<span class="comment-author-name">%s</span> ', 'philosophy' ), get_comment_author_link() ); ?></cite>
                <div class="comment__meta">
                    <time class="comment__time"> <?php printf( __('%1$s at %2$s', 'philosophy'), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( esc_html__( '(Edit)', 'philosophy' ), '  ', '' ); ?></time> 
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                     <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'philosophy' ); ?></em>
                    <?php endif; ?>
                    
                    <?php comment_reply_link(array_merge( $args, array( 'add_below' => $add_below, 'depth' => 1, 'max_depth' => 5, 'reply_text' => 'Reply' ) ) ); ?>
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

// social media
if ( ! function_exists( 'philosophy_social' ) ) {
	function philosophy_social( $args = array()  ){
		
		$default = array(
			'wrapper_start' => '',
			'wrapper_end'   => '',
			'class'   		=> 'topbar-social',
		);
		
		$args = wp_parse_args( $args, $default );
		
		
		$url = philosophy_opt('philosophy_social_url');
		if( is_array( $url ) && count( $url ) > 0 ):
		
		echo wp_kses_post( $args['wrapper_start'] );
		
			echo '<div class="'.esc_attr( $args['class'] ).'">';
		
			// Facebook
			if( !empty( $url['facebook_url'] ) ){
				echo '<a href="'.esc_url( $url['facebook_url'] ).'" class="topbar-social-item fa fa-facebook"></a>';
			}
			// Twitter
			if( !empty( $url['twitter_url'] ) ){
				echo '<a href="'.esc_url( $url['twitter_url'] ).'" class="topbar-social-item fa fa-twitter"></a>';
			}
			// Google
			if( !empty( $url['google_url'] ) ){
				echo '<a href="'.esc_url( $url['google_url'] ).'" class="topbar-social-item fa fa-google-plus"></a>';
			}
			// Instagram
			if( !empty( $url['instagram_url'] ) ){
				echo '<a href="'.esc_url( $url['instagram_url'] ).'" class="topbar-social-item fa fa-instagram"></a>';
			}
			// Pinterest
			if( !empty( $url['pinterest_url'] ) ){
				echo '<a href="'.esc_url( $url['pinterest_url'] ).'" class="topbar-social-item fa fa-pinterest-p"></a>';
			}
			// Snapchat
			if( !empty( $url['snapchat_url'] ) ){
				echo '<a href="'.esc_url( $url['snapchat_url'] ).'" class="topbar-social-item fa fa-snapchat-ghost"></a>';
			}
			// Youtube
			if( !empty( $url['youtube_url'] ) ){
				echo '<a href="'.esc_url( $url['youtube_url'] ).'" class="topbar-social-item fa fa-youtube-play"></a>';
			}
			
		
			echo '</div>';
		echo wp_kses_post( $args['wrapper_end'] );

		endif;
	}
}

//  contact form 7 Shortcode list
function philosophy_contact_form7_shortcode(){

    // contact form list
    $getforms['cs'] = __( 'Custom Shortcode', 'philosophy' );
    // Instruction
    $Instruction = ''; 

    if( defined('WPCF7_VERSION') ){
        $args = array(
            'post_type'      => 'wpcf7_contact_form',
            'post_per_pages' => '-1'
        );

        $loop = new WP_Query( $args );

        if( $loop->have_posts() ){
            while( $loop->have_posts() ){
                $loop->the_post();

                $getforms[ get_the_ID() ] = get_the_title();

            }

        }else{
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

// Popular post count
function philosophy_set_post_views($postID) {
    $count_key = 'philosophy_post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

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