<?php
/**
 * Philosophy theme bootstrap.
 *
 * @package Philosophy
 * @since   1.0
 */

// Block direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Theme version. Read from style.css so the two can never drift apart.
 */
if ( ! defined( 'PHILOSOPHY_VERSION' ) ) {
	$philosophy_theme = wp_get_theme( get_template() );
	define( 'PHILOSOPHY_VERSION', $philosophy_theme->get( 'Version' ) ? $philosophy_theme->get( 'Version' ) : '1.3.0' );
	unset( $philosophy_theme );
}

/**
 * Bundled Font Awesome version, used as the icon stylesheet's cache buster.
 */
if ( ! defined( 'PHILOSOPHY_FONTAWESOME_VERSION' ) ) {
	define( 'PHILOSOPHY_FONTAWESOME_VERSION', '7.3.1' );
}

/**
 * Paths and URIs.
 */
if ( ! defined( 'PHILOSOPHY_DIR_URI' ) ) {
	define( 'PHILOSOPHY_DIR_URI', trailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'PHILOSOPHY_DIR_ASSETS_URI' ) ) {
	define( 'PHILOSOPHY_DIR_ASSETS_URI', PHILOSOPHY_DIR_URI . 'assets/' );
}

if ( ! defined( 'PHILOSOPHY_DIR_CSS_URI' ) ) {
	define( 'PHILOSOPHY_DIR_CSS_URI', PHILOSOPHY_DIR_ASSETS_URI . 'css/' );
}

if ( ! defined( 'PHILOSOPHY_DIR_JS_URI' ) ) {
	define( 'PHILOSOPHY_DIR_JS_URI', PHILOSOPHY_DIR_ASSETS_URI . 'js/' );
}

if ( ! defined( 'PHILOSOPHY_DIR_IMG_URI' ) ) {
	define( 'PHILOSOPHY_DIR_IMG_URI', PHILOSOPHY_DIR_URI . 'img/' );
}

// Retained for child themes; the directory it pointed at never existed.
if ( ! defined( 'PHILOSOPHY_DIR_ICON_IMG_URI' ) ) {
	define( 'PHILOSOPHY_DIR_ICON_IMG_URI', PHILOSOPHY_DIR_URI . 'img/icons/' );
}

if ( ! defined( 'PHILOSOPHY_DIR_PATH' ) ) {
	define( 'PHILOSOPHY_DIR_PATH', trailingslashit( get_parent_theme_file_path() ) );
}

if ( ! defined( 'PHILOSOPHY_DIR_PATH_INC' ) ) {
	define( 'PHILOSOPHY_DIR_PATH_INC', PHILOSOPHY_DIR_PATH . 'inc/' );
}

if ( ! defined( 'PHILOSOPHY_DIR_PATH_LIB' ) ) {
	define( 'PHILOSOPHY_DIR_PATH_LIB', PHILOSOPHY_DIR_PATH_INC . 'libraries/' );
}

if ( ! defined( 'PHILOSOPHY_DIR_PATH_CLASSES' ) ) {
	define( 'PHILOSOPHY_DIR_PATH_CLASSES', PHILOSOPHY_DIR_PATH_INC . 'classes/' );
}

if ( ! defined( 'PHILOSOPHY_DIR_PATH_HOOKS' ) ) {
	define( 'PHILOSOPHY_DIR_PATH_HOOKS', PHILOSOPHY_DIR_PATH_INC . 'hooks/' );
}

if ( ! defined( 'PHILOSOPHY_DIR_PATH_WIDGET' ) ) {
	define( 'PHILOSOPHY_DIR_PATH_WIDGET', PHILOSOPHY_DIR_PATH_INC . 'widgets/' );
}

/**
 * Includes.
 */
require_once PHILOSOPHY_DIR_PATH_INC . 'philosophy-functions.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'philosophy-sanitize.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'philosophy-breadcrumbs.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'philosophy-widgets-reg.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'popular-post-widget.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'philosophy-newsletter-widget.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'wp_bootstrap_navwalker.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'philosophy-commoncss.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'philosophy-blocks.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'philosophy-migrate.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'support-functions.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'wp-html-helper.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'wp_bootstrap_pagination.php';
require_once PHILOSOPHY_DIR_PATH_CLASSES . 'Class-Enqueue.php';
require_once PHILOSOPHY_DIR_PATH_HOOKS . 'hooks.php';
require_once PHILOSOPHY_DIR_PATH_HOOKS . 'hooks-functions.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'customizer/customizer.php';
require_once PHILOSOPHY_DIR_PATH_CLASSES . 'Class-Config.php';
require_once PHILOSOPHY_DIR_PATH_INC . 'philosophy-deprecated.php';

if ( is_admin() ) {
	require_once PHILOSOPHY_DIR_PATH_INC . 'admin/class-philosophy-welcome.php';
}

// The update check runs wherever WordPress runs its own; the filter core calls
// is registered on load, not behind is_admin().
require_once PHILOSOPHY_DIR_PATH_INC . 'philosophy-updates.php';

/**
 * Instantiate the theme.
 */
$GLOBALS['philosophy'] = new Philosophy();
