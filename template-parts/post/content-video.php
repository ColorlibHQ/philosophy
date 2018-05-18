<?php
/**
 * Template part for displaying video posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry__brick entry format-video'); ?> data-aos="fade-up">           
    <div class="entry__thumb video-image">
        <a href="<?php echo esc_html(get_post_meta( get_the_ID(), '_philosophy_video_url', true ));?>" data-lity>
            <?php the_post_thumbnail(); ?>
        </a>
    </div>

    <div class="entry__text">
        <div class="entry__header">
            
            <div class="entry__date">
                <a href="<?php the_permalink(); ?>"><?php the_time('M d, Y'); ?></a>
            </div>
            <h1 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            
        </div>
        <div class="entry__excerpt">
            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div><!-- .entry-content -->
        </div>
        <div class="entry__meta">
            <span class="entry__meta-links">
                <?php echo get_the_category_list( esc_html__( ', ', 'philosophy' ) ); ?>
            </span>
        </div>
    </div>


</article><!-- #post-## -->
