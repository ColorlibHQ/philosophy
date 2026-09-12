<?php
/**
 * Template Name: About Page
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

get_header();

$philosophy_top_title = philosophy_opt( 'philosophy_about_top_title' );
?>
	<!-- s-content
	================================================== -->
	<main id="content" class="s-content s-content--narrow">

		<div class="row">
			<?php if ( $philosophy_top_title ) : ?>
				<div class="s-content__header col-full">
					<h1 class="s-content__header-title"><?php echo esc_html( $philosophy_top_title ); ?></h1>
				</div>
			<?php endif; ?>

			<div class="col-full s-content__main">

				<?php
				while ( have_posts() ) :
					the_post();

					if ( ! $philosophy_top_title ) {
						the_title( '<div class="s-content__header col-full"><h1 class="s-content__header-title">', '</h1></div>' );
					}

					the_content();
					philosophy_link_pages();
				endwhile;
				?>

				<?php
				// Info blocks are page content from 1.2.0. This renders any rows a
				// site still holds in the old theme_mod, until the migration in
				// inc/philosophy-migrate.php moves them into the page itself.
				philosophy_legacy_info_blocks( 'philosophy_about_infoblock', 'info_desc', 'col-block' );
				?>

				<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>

			</div> <!-- end s-content__main -->

		</div> <!-- end row -->

	</main> <!-- s-content -->

<?php
get_footer();
