<?php
/**
 * Author biography shown below a single post.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="s-content__author">
	<?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?>

	<div class="s-content__author-about">
		<h2 class="s-content__author-name">
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php echo esc_html( get_the_author() ); ?>
			</a>
		</h2>

		<?php
		// the_author_meta() echoes; wrapping it in esc_html() escaped nothing
		// and printed the description raw.
		echo wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) );
		?>
	</div>
</div>
