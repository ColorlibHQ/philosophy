<?php
/**
 * Shown when a query returns nothing.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<article class="no-results not-found">
	<div class="text-center">
		<h2 class="blog-item-title p-b-30"><?php esc_html_e( 'Nothing Found', 'philosophy' ); ?></h2>

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php
				printf(
					/* translators: 1: opening anchor tag, 2: closing anchor tag. */
					esc_html__( 'Ready to publish your first post? %1$sGet started here%2$s.', 'philosophy' ),
					'<a href="' . esc_url( admin_url( 'post-new.php' ) ) . '">',
					'</a>'
				);
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'philosophy' ); ?></p>

			<?php get_search_form(); ?>

			<div class="backtohome">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home page', 'philosophy' ); ?></a>
			</div>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'philosophy' ); ?></p>

			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</article>
