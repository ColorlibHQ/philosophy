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
$philosophy_blocks    = philosophy_decode_repeater( philosophy_opt( 'philosophy_about_infoblock' ) );
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

				<?php if ( $philosophy_blocks ) : ?>
					<div class="row block-1-2 block-tab-full">
						<?php foreach ( $philosophy_blocks as $philosophy_block ) : ?>
							<?php $philosophy_block = (array) $philosophy_block; ?>
							<div class="col-block">
								<?php if ( ! empty( $philosophy_block['info_title'] ) ) : ?>
									<h2 class="quarter-top-margin"><?php echo esc_html( $philosophy_block['info_title'] ); ?></h2>
								<?php endif; ?>

								<?php
								if ( ! empty( $philosophy_block['info_desc'] ) ) {
									echo philosophy_get_textareahtml_output( $philosophy_block['info_desc'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- run through wp_kses_post().
								}
								?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

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
