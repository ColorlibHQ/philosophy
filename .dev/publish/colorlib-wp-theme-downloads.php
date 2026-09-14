<?php
/**
 * Email-gated downloads for the free WordPress theme pages at /wp/themes/.
 *
 * These pages linked their zip directly, so everyone who took a theme left no
 * trace and could never be told about the next one. They now go through the same
 * popup the free HTML templates and the Shopify themes use — email, consent,
 * Sendy double opt-in, download link on confirmation — but write to their own
 * list, so someone who wanted a WordPress theme is not mailed about Shopify.
 *
 * Sendy list 11 "Colorlib - Free WordPress Themes" (brand Colorlib), double
 * opt-in, GDPR consent on, custom field `download_name`. Its autoresponder mails
 * https://updates.colorlib.com/download/theme/[download_name].zip immediately on
 * confirmation. That endpoint always redirects to the current release, so a link
 * mailed today still works after the next version ships.
 *
 * **This gates the marketing download only.** Installed sites update through
 * `Update URI` -> updates.colorlib.com/theme/{slug}.json, whose package points
 * straight at downloads.colorlib.com and is deliberately left open: gating it
 * would break automatic updates for every site already running the theme.
 *
 * A page here may offer more than one theme — Philosophy ships a classic and a
 * block edition — so the download name comes from whichever link was clicked.
 * The plugin reads it off the href; the map below is only the fallback for a
 * trigger that is not a zip link.
 *
 * The popup, the list registry and the AJAX endpoint all live in the
 * colorlib-shop plugin; this file only says which pages opt in and what they say.
 */

defined( 'ABSPATH' ) || exit;

const COLORLIB_WP_THEME_DOWNLOADS_BLOG_ID = 2;

/**
 * page ID => fallback zip basename under https://updates.colorlib.com/download/theme/
 */
function colorlib_wp_theme_downloads_map() {
	return array(
		169039 => 'philosophy', // Philosophy — also offers philosophy-blocks
	);
}

/**
 * Point the free-download popup at the WordPress list on the mapped pages.
 *
 * The trigger matches the page's own download buttons by href, so they stay
 * ordinary links in the markup: with JavaScript off the zip still downloads
 * rather than the page offering a button that does nothing.
 */
add_filter(
	'colorlib_free_download_context',
	function ( $context, $post ) {
		if ( get_current_blog_id() !== COLORLIB_WP_THEME_DOWNLOADS_BLOG_ID ) {
			return $context;
		}

		$map = colorlib_wp_theme_downloads_map();

		if ( ! isset( $map[ $post->ID ] ) ) {
			return $context;
		}

		return array_merge(
			$context,
			array(
				'list_key'      => 'wordpress',
				'download_name' => $map[ $post->ID ],
				'trigger'       => 'a[href^="https://updates.colorlib.com/download/theme/"]',
				'title'         => 'Get this WordPress theme',
				'subtitle'      => 'Confirm your email and we will send the download link. We will also let you know when we release a new free WordPress theme.',
				'button'        => 'Send my download link',
			)
		);
	},
	10,
	2
);

/**
 * Make sure the popup is actually printed on the mapped pages.
 *
 * colorlib-shop hooks it from a body_class filter, and only when the page has no
 * matching EDD download by title. That is true today for every page here, but it
 * is a coincidence rather than a rule, and a premium product sharing a title
 * would silently take the download form away.
 */
add_action(
	'wp',
	function () {
		if ( get_current_blog_id() !== COLORLIB_WP_THEME_DOWNLOADS_BLOG_ID || ! is_singular() ) {
			return;
		}

		$post = get_queried_object();

		if ( ! $post instanceof WP_Post || ! isset( colorlib_wp_theme_downloads_map()[ $post->ID ] ) ) {
			return;
		}

		if ( function_exists( 'colorlib_free_download_popup' )
			&& ! has_action( 'wp_footer', 'colorlib_free_download_popup' ) ) {
			add_action( 'wp_footer', 'colorlib_free_download_popup' );
		}
	},
	20
);
