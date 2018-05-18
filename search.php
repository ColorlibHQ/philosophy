<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package philosophy
 */

get_header();

$contentNone = 'masonry';
if( !have_posts() ){
	$contentNone = 'no-masonry';
}

?>

	<section class="s-content">

        <div class="row narrow">
            <div class="col-full s-content__header" data-aos="fade-up">
                <?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'philosophy' ), '<h1>' . get_search_query() . '</h1>' );
				?>
				
            </div>
        </div>
        
        <div class="row masonry-wrap">
            <div class="<?php echo esc_attr( $contentNone ); ?>">

				<?php if ( have_posts() ) :
					
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/page/content', 'search' );

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
