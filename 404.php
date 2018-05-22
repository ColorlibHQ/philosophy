<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package philosophy
 */

get_header();
?>

	<section class="s-content">

        <div class="row narrow">
            <div class="col-full s-content__header" data-aos="fade-up">

			<section class="not-found">
				<h2 class="error-404"><?php echo esc_html__('404','philosophy')?></h2>
				<h1 class="page-title"><?php echo esc_html__( 'Oops! That page can&rsquo;t be found.', 'philosophy' ); ?></h1>
				<p><?php echo esc_html__( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'philosophy' ); ?></p>
				<a class="btn btn--stroke" href="<?php echo esc_url( get_site_url() ); ?>"><?php echo esc_html__( 'Return to home','philosophy' ); ?></a>
			</section><!-- .error-404 -->
			</div>
		</div>
	</section>

<?php
get_footer();
