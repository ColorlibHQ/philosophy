<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package philosophy
 */

get_header();
?>
	
	<section class="s-content">

        <div class="row narrow">
            <div class="col-full s-content__header" data-aos="fade-up">
                
                <?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="lead archive-description">', '</div>' );
				?>
				
            </div>
        </div>
        
        <div class="row masonry-wrap">
            <div class="masonry">

			<?php if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Type-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 */
					get_template_part( 'template-parts/post/content', get_post_type() );

				endwhile;

			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif;
			?>
			</div>
		</div>
		
		<div class="row">
	 		<?php philosophy_pagination(); ?>
        </div>

	</section>

<?php get_footer();
