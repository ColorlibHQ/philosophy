<?php
/**
 * Footer credit line and the back-to-top link.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$philosophy_copyright = philosophy_opt( 'philosophy_footer_copyright_text' );

if ( ! $philosophy_copyright ) {
	$philosophy_copyright = philosophy_default_copyright();
}
?>
<!-- Footer Bottom Area -->
<div class="s-footer__bottom">
	<div class="row">
		<div class="col-full">
			<div class="s-footer__copyright">
				<span><?php echo wp_kses_post( $philosophy_copyright ); ?></span>
			</div>

			<?php if ( philosophy_opt( 'philosophy_backtotop_btn' ) ) : ?>
				<div class="go-top">
					<a class="smoothscroll" href="#top">
						<span class="screen-reader-text"><?php esc_html_e( 'Back to top', 'philosophy' ); ?></span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div> <!-- end s-footer__bottom -->
