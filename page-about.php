<?php
/**
 * The template for displaying about page
 * Template Name: About page
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package philosophy
 */

get_header();
?>

<section class="s-content s-content--narrow">
	<div class="row">

		<?php
		if( have_posts() ):
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/page/content', 'about' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		endif;
		?>

		</div>

</section>

<?php get_footer();
