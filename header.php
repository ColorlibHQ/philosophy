<?php
/**
 * The site header.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body id="top" <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'philosophy' ); ?></a>

<?php
/**
 * Preloader Start
 *
 * @Hook philosophy_preloader
 *
 * @Hooked philosophy_site_preloader 10
 */
do_action( 'philosophy_preloader' );

/**
 * Header Area Start
 * Header menu
 *
 * @Hook philosophy_header
 *
 * @Hooked philosophy_header_cb 10
 */
do_action( 'philosophy_header' );
