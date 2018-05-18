<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package philosophy
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry__brick'); ?> data-aos="fade-up">
    <div class="entry__thumb">
        <a href="<?php the_permalink(); ?>" class="entry__thumb-link">
            <?php the_post_thumbnail(); ?>
        </a>
    </div>

    <div class="entry__text">
        <div class="entry__header">
            
            <div class="entry__date">
                <a href="<?php the_permalink(); ?>"><?php echo get_the_time( 'M d , Y' ); ?></a>
            </div>
            <h1 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            
        </div>
        <div class="entry__excerpt">
            <p>
                <?php the_excerpt() ?>
            </p>
            <?php 
                wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'philosophy' ),
                'after'  => '</div>',
            ) ); ?>
        </div>
        <div class="entry__meta">
            <span class="entry__meta-links">
                <?php echo get_the_category_list( esc_html__( ', ', 'philosophy' ) ); ?>
            </span>
        </div>
    </div>
</article>
