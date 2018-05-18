<?php
/**
 * Template part for displaying gallery posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry__brick entry format-gallery'); ?> data-aos="fade-up">
    	


    <div class="entry__thumb slider">
        <div class="slider__slides">
            <?php
                $attachments = get_posts( array( 
                    'post_type' => 'attachment', 
                    'posts_per_page' => 3, 
                    'post_status' =>'any', 
                    'post_parent' => get_the_ID()
                ));
                if ( is_array( $attachments ) && count( $attachments ) > 0 ) {
                    foreach ( $attachments as $attachment ) { ?>
                        <div class="slider__slide">
                            <?php 
                            // echo apply_filters( 'the_title' , $attachment->post_title );
                                the_attachment_link( $attachment->ID , 'full' );
                            ?>
                        </div>
                        
                    <?php }
                }
                wp_reset_postdata();
             ?>
        </div>
    </div>

    <div class="entry__text">
        <div class="entry__header">
            
            <div class="entry__date">
                <a href="<?php the_permalink(); ?>"><?php the_time('M d, Y'); ?></a>
            </div>
            <h1 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            
        </div>
        <div class="entry__excerpt">
            <p>
                <?php the_excerpt(); ?>
            </p>
        </div>
        <div class="entry__meta">
            <span class="entry__meta-links">
                <?php the_category( ', ' ); ?>
            </span>
        </div>
    </div>


</article><!-- #post-## -->
