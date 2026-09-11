<?php
/**
 * Archive pagination.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( function_exists( 'philosophy_pagination' ) ) {
	philosophy_pagination();

	return;
}

if ( ! get_previous_posts_link() && ! get_next_posts_link() ) {
	return;
}

$philosophy_newer = '<i class="fa-solid fa-arrow-left-long fm" aria-hidden="true"></i>' . esc_html__( 'Newer Post', 'philosophy' );
$philosophy_older = esc_html__( 'Older Post', 'philosophy' ) . '<i class="fa-solid fa-arrow-right-long flm" aria-hidden="true"></i>';
?>
<nav class="pagination-wrap" aria-label="<?php esc_attr_e( 'Posts navigation', 'philosophy' ); ?>">
	<ul class="pager">
		<li class="previous">
			<?php
			if ( get_previous_posts_link() ) {
				previous_posts_link( $philosophy_newer );
			} else {
				echo '<span>' . wp_kses_post( $philosophy_newer ) . '</span>';
			}
			?>
		</li>
		<li class="next">
			<?php
			if ( get_next_posts_link() ) {
				next_posts_link( $philosophy_older );
			} else {
				echo '<span>' . wp_kses_post( $philosophy_older ) . '</span>';
			}
			?>
		</li>
	</ul>
</nav>
