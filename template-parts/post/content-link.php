<?php
/**
 * Template part for displaying link posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry__brick entry format-link'); ?> data-aos="fade-up">                    
    <div class="entry__thumb">
        <div class="link-wrap">
            <?php the_title( '<p>', '</p>') ?>
            <cite>
                <?php the_content() ?>
            </cite>
        </div>
    </div>

</article><!-- #post-## -->
