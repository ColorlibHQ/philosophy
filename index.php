<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package philosophy
 */

$blog_sidebar = get_theme_mod( 'blog_sidebar_setting' ) == 'blog_with_sidebar' ? true : false;

get_header();
?>

	<!-- s-content
    ================================================== -->
    <section class="s-content">
        <div class="row masonry-wrap">
			<?php

			if ( $blog_sidebar == true) {?>
			<div class="main-content-area">
			<?php } ?>

				<div class="masonry">

					<div class="grid-sizer"></div>

						<?php
						if ( have_posts() ) :
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part( 'template-parts/post/content', get_post_format() );

							endwhile;

						else :

							get_template_part( 'template-parts/post/content', 'none' );

						endif;
						
						?>

				</div> <!-- end masonry -->
				
			<?php if ( $blog_sidebar == true) {?>

			</div>
			<div class="sidebar-area">
				<?php 
				get_sidebar();
				?>
			</div>
			<?php } ?>
		</div> <!-- end masonry-wrap -->
        
        <?php 

        if ( philosophy_pagination() ):

        		philosophy_pagination();
		 	
		endif;

		?>
		

    </section> <!-- s-content -->

<?php get_footer();
