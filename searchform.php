<?php
/**
 * The search form.
 *
 * Two layouts share this template: the sidebar/widget form, and the overlay in
 * the site header. get_search_form() passes its $args through, so the header
 * asks for its own variant rather than hard coding a second <form>.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$philosophy_args    = isset( $args ) && is_array( $args ) ? $args : array();
$philosophy_context = isset( $philosophy_args['philosophy_context'] ) ? $philosophy_args['philosophy_context'] : 'default';
$philosophy_id      = 'philosophy-search-' . wp_unique_id();

if ( 'header' === $philosophy_context ) :
	?>
	<form role="search" method="get" class="header__search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="<?php echo esc_attr( $philosophy_id ); ?>">
			<span class="hide-content"><?php echo esc_html_x( 'Search for:', 'label', 'philosophy' ); ?></span>
		</label>
		<input
			type="search"
			id="<?php echo esc_attr( $philosophy_id ); ?>"
			class="search-field"
			placeholder="<?php esc_attr_e( 'Type Keywords', 'philosophy' ); ?>"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			name="s"
			autocomplete="off">
		<input type="submit" class="search-submit" value="<?php esc_attr_e( 'Search', 'philosophy' ); ?>">
	</form>
	<?php
	return;
endif;
?>
<div class="blog-post-search-widget">
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="<?php echo esc_attr( $philosophy_id ); ?>" class="screen-reader-text">
			<?php echo esc_html_x( 'Search for:', 'label', 'philosophy' ); ?>
		</label>
		<input
			type="search"
			id="<?php echo esc_attr( $philosophy_id ); ?>"
			name="s"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'Type Keywords', 'philosophy' ); ?>">
		<button type="submit" class="submit btn btn--primary full-width"><?php esc_html_e( 'Search', 'philosophy' ); ?></button>
	</form>
</div>
