<?php
/**
 * Template part for displaying audio posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry__brick entry format-audio'); ?>  data-aos="fade-up">
	
    <div class="entry__thumb">
        <a href="<?php the_permalink(); ?>" class="entry__thumb-link">
            <?php the_post_thumbnail(); ?>
        </a>
        <div class="audio-wrap">
            <?php echo philosophy_get_embedded_media( array('audio','iframe') ); ?>
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
            <?php the_excerpt(); ?>

        </div>
        <div class="entry__meta">
            <span class="entry__meta-links">
                <?php echo get_the_category_list( esc_html__( ', ', 'philosophy' ) ); ?>
            </span>
        </div>
    </div>

</article><!-- #post-## -->
