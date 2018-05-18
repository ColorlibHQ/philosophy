<?php
/**
 * Template part for displaying quote posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package philosophy
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry__brick  entry'); ?>  data-aos="fade-up">
        <div class="entry__thumb">
            <blockquote>
                <?php the_content(); ?>
                <?php the_title( '<cite>', '</cite>' ) ?>
            </blockquote>
        </div>
</article>