<?php
/**
 * Add Philosophy to the /wp/themes/ listing (page 5091).
 *
 * Two insertions, both idempotent: a card in the free themes grid, and an entry
 * in the "pick a theme by what you are building" list at the top.
 *
 * Bails if Philosophy is already listed, so it is safe to re-run.
 */

defined( 'ABSPATH' ) || exit;

$page_id  = 5091;
$card_img = 'https://colorlib.com/wp/wp-content/uploads/sites/2/philosophy-free-wordpress-theme.jpg';
$page_url = 'https://colorlib.com/wp/themes/philosophy/';

$content = get_post_field( 'post_content', $page_id );

if ( '' === $content ) {
	echo "ERROR: page $page_id has no content\n";
	return;
}

if ( false !== stripos( $content, 'theme-philosophy' ) ) {
	// Already listed. The only thing that changes on a re-run is the card
	// image, so swap that and leave the rest alone.
	if ( false !== strpos( $content, $card_img ) ) {
		echo "already listed, card image current — nothing to do\n";
		return;
	}

	$updated = preg_replace(
		'~(<li class="clt-theme" id="theme-philosophy">.*?<img src=")[^"]+~s',
		'$1' . $card_img,
		$content,
		1
	);

	if ( null === $updated || $updated === $content ) {
		echo "ERROR: listed, but the card image could not be replaced\n";
		return;
	}

	wp_update_post( array( 'ID' => $page_id, 'post_content' => $updated ) );

	if ( function_exists( 'visual_composer' ) ) {
		visual_composer()->buildShortcodesCss( $page_id, 'custom' );
	}

	echo "card image updated to $card_img\n";
	return;
}

// The card goes immediately before Academia's, so the two block themes sit
// together in the grid.
$anchor = '<li class="clt-theme" id="theme-academia">';

if ( false === strpos( $content, $anchor ) ) {
	echo "ERROR: could not find the Academia card to insert before\n";
	return;
}

$card = '<li class="clt-theme" id="theme-philosophy">'
	. '<span class="clt-theme__shot">'
	. '<img src="' . esc_url( $card_img ) . '"'
	. ' alt="Philosophy free WordPress blog theme homepage with its featured panels and masonry grid"'
	. ' width="1200" height="815" loading="lazy" decoding="async" />'
	. '</span>'
	. '<span class="clt-theme__body">'
	. '<span class="clt-theme__kind">Classic theme and block theme</span>'
	. '<h3 class="clt-theme__name"><a href="' . esc_url( $page_url ) . '">Philosophy</a></h3>'
	. '<span class="clt-theme__desc">A masonry blog with a featured area at the top, in two editions of the same design: one that keeps the Customizer, one built for the Site Editor.</span>'
	. '<span class="clt-theme__foot"><span class="clt-theme__installs"></span><span class="clt-theme__cta">View theme &rarr;</span></span>'
	. '</span></li>';

$content = str_replace( $anchor, $card . $anchor, $content );

// And a line in the "what are you building" picker, before the school entry.
$pick_anchor = '<li class="clt-pick"><span class="clt-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M22 10L12 5 2 10l10 5 10-5z"/>';

if ( false !== strpos( $content, $pick_anchor ) ) {
	$pick = '<li class="clt-pick"><span class="clt-ico">'
		. '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'
		. '<path d="M4 5h16v14H4z"/><path d="M4 10h16"/><path d="M10 10v9"/>'
		. '</svg></span>'
		. '<span><span class="clt-pick__lab">A personal blog or magazine</span>'
		. '<span class="clt-pick__themes"><a href="#theme-philosophy">Philosophy</a></span></span></li>';

	$content = str_replace( $pick_anchor, $pick . $pick_anchor, $content );
	echo "picker entry added\n";
} else {
	echo "NOTE: picker anchor not found — card added, picker left alone\n";
}

$kses = has_filter( 'content_save_pre', 'wp_filter_post_kses' );

if ( $kses ) {
	kses_remove_filters();
}

$result = wp_update_post( array( 'ID' => $page_id, 'post_content' => $content ), true );

if ( $kses ) {
	kses_init_filters();
}

if ( is_wp_error( $result ) ) {
	echo 'ERROR: ' . $result->get_error_message() . "\n";
	return;
}

// This page is WPBakery too, so its css= meta has to be regenerated like any
// other programmatic edit.
if ( function_exists( 'visual_composer' ) ) {
	$vc = visual_composer();

	if ( method_exists( $vc, 'buildShortcodesCss' ) ) {
		$vc->buildShortcodesCss( $page_id, 'custom' );
		$vc->buildShortcodesCss( $page_id, 'default' );
	}
}

$saved = get_post_field( 'post_content', $page_id );

echo 'page: ' . $page_id . ' (' . get_post_status( $page_id ) . ")\n";
echo 'length: ' . strlen( $saved ) . "\n";
echo 'philosophy cards: ' . substr_count( $saved, 'id="theme-philosophy"' ) . "\n";
echo 'philosophy picker links: ' . substr_count( $saved, '#theme-philosophy' ) . "\n";
echo 'total theme cards: ' . substr_count( $saved, 'class="clt-theme" id=' ) . "\n";
