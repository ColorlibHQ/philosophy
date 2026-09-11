<?php
/**
 * Template Name: Contact Page
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

get_header();

$philosophy_top_title = philosophy_opt( 'philosophy_contact_top_title' );
$philosophy_lat       = philosophy_opt( 'philosophy_contact_latitude' );
$philosophy_long      = philosophy_opt( 'philosophy_contact_longitude' );
$philosophy_marker    = philosophy_opt( 'philosophy_map_marker' );
$philosophy_api_key   = philosophy_opt( 'philosophy_gmap_api_key' );
$philosophy_blocks    = philosophy_decode_repeater( philosophy_opt( 'philosophy_contact_infoblock' ) );
$philosophy_form_id   = philosophy_opt( 'philosophy_contact_formshortcode' );
$philosophy_custom    = philosophy_opt( 'philosophy_contact_custom_formshortcode' );
$philosophy_form_head = philosophy_opt( 'philosophy_contact_formtitle' );
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

			<?php
			// Without an API key Google renders a grey "for development purposes
			// only" box, so the map is only printed once one has been saved.
			if ( $philosophy_api_key && $philosophy_lat && $philosophy_long ) :
				?>
				<div class="s-content__media col-full">
					<div id="map-wrap"
						data-lat="<?php echo esc_attr( $philosophy_lat ); ?>"
						data-long="<?php echo esc_attr( $philosophy_long ); ?>"
						data-marker="<?php echo esc_url( $philosophy_marker ); ?>">
						<div id="map-container"></div>
						<button type="button" id="map-zoom-in"><span class="screen-reader-text"><?php esc_html_e( 'Zoom in', 'philosophy' ); ?></span></button>
						<button type="button" id="map-zoom-out"><span class="screen-reader-text"><?php esc_html_e( 'Zoom out', 'philosophy' ); ?></span></button>
					</div>
				</div> <!-- end s-content__media -->
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
					<div class="row">
						<?php foreach ( $philosophy_blocks as $philosophy_block ) : ?>
							<?php $philosophy_block = (array) $philosophy_block; ?>
							<div class="col-six tab-full">
								<?php if ( ! empty( $philosophy_block['info_title'] ) ) : ?>
									<h2><?php echo esc_html( $philosophy_block['info_title'] ); ?></h2>
								<?php endif; ?>

								<?php
								if ( ! empty( $philosophy_block['contact_info'] ) ) {
									echo philosophy_get_textareahtml_output( $philosophy_block['contact_info'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- run through wp_kses_post().
								}
								?>
							</div>
						<?php endforeach; ?>
					</div> <!-- end row -->
				<?php endif; ?>

				<?php if ( $philosophy_form_head ) : ?>
					<h2 class="form-title"><?php echo esc_html( $philosophy_form_head ); ?></h2>
				<?php endif; ?>

				<?php
				if ( $philosophy_form_id && 'cs' !== $philosophy_form_id ) {
					$philosophy_form = sprintf(
						'[contact-form-7 id="%1$d" title="%2$s"]',
						absint( $philosophy_form_id ),
						esc_attr( get_the_title( absint( $philosophy_form_id ) ) )
					);
				} else {
					$philosophy_form = $philosophy_custom;
				}

				if ( $philosophy_form ) {
					echo do_shortcode( wp_kses_post( $philosophy_form ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode output.
				}
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
