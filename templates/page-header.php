<?php
/**
 * Archive and search results header.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="row narrow">
	<div class="col-full s-content__header" data-aos="fade-up">
		<?php
		if ( is_search() ) {
			printf(
				'<h1>%1$s <span>%2$s</span></h1>',
				esc_html__( 'Search results for', 'philosophy' ),
				esc_html( get_search_query() )
			);
		} elseif ( is_archive() ) {
			the_archive_title( '<h1>', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
		} elseif ( is_home() ) {
			echo '<h1>' . esc_html__( 'Blog', 'philosophy' ) . '</h1>';
		} else {
			the_title( '<h1>', '</h1>' );
		}

		$philosophy_lead = is_search()
			? philosophy_opt( 'philosophy_search_header_content' )
			: philosophy_opt( 'philosophy_archive_header_content' );

		if ( $philosophy_lead ) {
			echo '<div class="lead">' . philosophy_get_textareahtml_output( $philosophy_lead ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- run through wp_kses_post().
		}
		?>
	</div>
</div>
