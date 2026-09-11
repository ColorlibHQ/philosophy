<?php
/**
 * The 404 page body.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$philosophy_title = philosophy_opt( 'philosophy_fof_titleone' );

if ( ! $philosophy_title ) {
	$philosophy_title = esc_html__( 'Ooops 404 Error!', 'philosophy' );
}

$philosophy_message = philosophy_opt( 'philosophy_fof_titletwo' );

if ( ! $philosophy_message ) {
	$philosophy_message = esc_html__( 'Either something went wrong or the page doesn&rsquo;t exist anymore.', 'philosophy' );
}
?>
<main id="content" class="s-content">
	<div id="f0f">
		<div class="container">
			<div class="row">
				<div class="f0f-content text-center">
					<div class="f0f-content-inner">
						<h1 class="h1"><?php echo esc_html( $philosophy_title ); ?></h1>

						<p>
							<?php echo esc_html( $philosophy_message ); ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go to the home page', 'philosophy' ); ?></a>
						</p>

						<div class="f0f-search">
							<?php get_search_form(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
