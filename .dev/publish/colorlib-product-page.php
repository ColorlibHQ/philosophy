<?php
/**
 * Rebuild the Philosophy product page (169039) on colorlib.com/wp.
 *
 * The page had been a placeholder image and the words "Coming Soon..." since
 * 2017. This gives it the same shape as the Academia and Unapp pages: what the
 * theme is, what you get, what it looks like, and the questions people ask.
 *
 * Philosophy is unusual in shipping two editions of the same design — a classic
 * theme with the Customizer and a block theme for the Site Editor — so the page
 * leads with that choice rather than burying it.
 *
 * Idempotent. Leaves the page a DRAFT: colorlib.com's convention is draft
 * first, publish separately.
 */

defined( 'ABSPATH' ) || exit;

$page_id = 169039;

// Media captured from the colorlibhub.com/philosophy demo, 2026-09-13. The
// first set (381458-381466) was shot before that demo existed and showed the
// Academia demo content instead; it has been deleted.
$img_blocks_home  = 381471;
$img_classic_grid = 381474;
$img_single       = 381472;
$img_ink          = 381473;
$img_paper        = 381475;
$img_sans         = 381476;

$dl_classic = 'https://updates.colorlib.com/download/theme/philosophy.zip';
$dl_blocks  = 'https://updates.colorlib.com/download/theme/philosophy-blocks.zip';
$demo       = 'https://colorlibhub.com/philosophy/';

// vc_btn's `link` attribute is WPBakery's own "url:…|title:…|target:…" encoding.
// It splits on "|" then on the first ":", so a raw URL is cut off at "https:"
// and the button renders href="http://https". Percent-encode anything that goes
// into a `link`. Plain url="…" attributes, as on vcex_teaser, take it as-is.
$dl_classic_enc = rawurlencode( $dl_classic );
$dl_blocks_enc  = rawurlencode( $dl_blocks );
$demo_enc       = rawurlencode( $demo );

$btn_css = 'display:inline-block !important;vertical-align:middle !important;margin-right:12px !important;margin-bottom:10px !important;';

// Style variations: image id => [heading, summary]
$variations = array(
	$img_ink   => array( 'Ink', 'The whole site on the dark ground the masthead already uses. Every colour re-tuned so nothing is dark on dark.' ),
	$img_paper => array( 'Paper', 'Warmer stock, a quieter brown accent and softer rules. For a site that is mostly long-form writing.' ),
	$img_sans  => array( 'Sans', 'Montserrat everywhere, headings included, for a blog that wants no serif at all.' ),
);

$variation_teasers = '';

foreach ( $variations as $img => $v ) {
	list( $heading, $summary ) = $v;

	$variation_teasers .= '[vc_column width="1/3"][vcex_teaser image="' . $img . '"'
		. ' heading="' . $heading . '" heading_type="h3" heading_size="20px" content_font_size="14px"'
		. ' img_aspect_ratio="3/2" img_object_fit="cover" img_border_radius="10px"'
		. ' style="two" border_radius="12px" bottom_margin="30px"]'
		. $summary . '[/vcex_teaser][/vc_column]';
}

$content = <<<HTML
[vc_row css=".vc_custom_philosophy006{padding-top:64px !important;padding-bottom:44px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_heading text="One blog theme, two ways to build it." tag="h2" font_size="46px" text_align="center" bottom_margin="20px" font_weight="700"][vc_column_text css=".vc_custom_philosophy001{text-align:center !important;font-size:18px !important;}"]Philosophy is a free masonry blog theme for WordPress, and it comes in two editions of the same design. The classic theme keeps the Customizer. The block theme puts every template, the header and the footer in the Site Editor. Same masonry grid, same typography, same featured area — you pick which editor you want to work in, and you can change your mind later.[/vc_column_text][vc_column_text css=".vc_custom_philosophy002{text-align:center !important;margin-top:26px !important;}"][vc_btn title="Download Philosophy" style="flat" color="green" link="url:{$dl_classic_enc}|title:Download%20Philosophy|target:_blank" css=".vc_custom_philosophy003{{$btn_css}}" i_icon_fontawesome="fa fa-download" add_icon="true"][vc_btn title="Download Philosophy Blocks" style="flat" color="green" link="url:{$dl_blocks_enc}|title:Download%20Philosophy%20Blocks|target:_blank" css=".vc_custom_philosophy004{{$btn_css}}" i_icon_fontawesome="fa fa-download" add_icon="true"][vc_btn title="Live demo" style="flat" color="grey" link="url:{$demo_enc}|title:Live%20demo|target:_blank" css=".vc_custom_philosophy005{{$btn_css}}" i_icon_fontawesome="fa fa-eye" add_icon="true"][/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_philosophy007{padding-top:0px !important;padding-bottom:64px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_image image_id="{$img_blocks_home}" align="center" border_radius="14px" bottom_margin="0px"][/vc_column][/vc_row]

[vc_row css=".vc_custom_philosophy008{padding-top:56px !important;padding-bottom:44px !important;}"][vc_column width="1/4"][vcex_milestone number="2" caption="Editions" animated="true" text_align="center" number_size="46px" number_weight="700" caption_size="13px"][/vc_column][vc_column width="1/4"][vcex_milestone number="14" caption="Block templates" animated="true" text_align="center" number_size="46px" number_weight="700" caption_size="13px"][/vc_column][vc_column width="1/4"][vcex_milestone number="3" caption="Style variations" animated="true" text_align="center" number_size="46px" number_weight="700" caption_size="13px"][/vc_column][vc_column width="1/4"][vcex_milestone number="0" caption="Third-party requests" animated="true" text_align="center" number_size="46px" number_weight="700" caption_size="13px"][/vc_column][/vc_row]

[vc_row css=".vc_custom_philosophy010{padding-top:44px !important;padding-bottom:20px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_heading text="Two editions, one design" tag="h2" font_size="34px" text_align="center" bottom_margin="14px" font_weight="700"][vc_column_text css=".vc_custom_philosophy011{text-align:center !important;max-width:760px !important;margin-left:auto !important;margin-right:auto !important;}"]They are separate themes, installed side by side, so moving across is a switch and moving back is another. Neither can see the other's settings, which is exactly what makes the decision reversible.[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_philosophy012{padding-bottom:44px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/2"][vcex_icon_box style="one" heading_type="h3" heading="Philosophy — the classic theme" icon="fa fa-sliders" icon_color="#0054a5" heading_size="19px"]Colours, the header, the footer, the featured area and the 404 page are set in the Customizer, where they have always been. Forty-one options, eight widget areas, and About and Contact page templates. WordPress 6.0 and PHP 7.4 or newer.[/vcex_icon_box][/vc_column][vc_column width="1/2"][vcex_icon_box style="one" heading_type="h3" heading="Philosophy Blocks — the block theme" icon="fa fa-th-large" icon_color="#0054a5" heading_size="19px"]Fourteen templates, the header, the footer and every section are blocks, edited in Appearance → Editor. The design system lives in theme.json, so colour and type are one click. WordPress 6.6 and PHP 7.4 or newer.[/vcex_icon_box][/vc_column][/vc_row]

[vc_row css=".vc_custom_philosophy020{padding-top:44px !important;padding-bottom:24px !important;}"][vc_column width="1/1"][vcex_heading text="A masonry grid that survives a blocked script" tag="h2" font_size="34px" text_align="center" bottom_margin="14px" font_weight="700"][vc_column_text css=".vc_custom_philosophy021{text-align:center !important;max-width:760px !important;margin-left:auto !important;margin-right:auto !important;}"]Posts are laid out in columns of uneven height, so a short post does not leave a gap under a tall one. The grid is rendered by the server first and rebalanced by about three kilobytes of JavaScript; with scripts blocked it falls back to an ordinary grid rather than to nothing. No jQuery, in either edition.[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_philosophy022{padding-bottom:56px !important;}"][vc_column width="1/1"][vcex_image image_id="{$img_classic_grid}" align="center" border_radius="12px" bottom_margin="0px" img_shadow="two"][/vc_column][/vc_row]

[vc_row css=".vc_custom_philosophy030{padding-top:44px !important;padding-bottom:10px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_heading text="Three looks, one click" tag="h2" font_size="34px" text_align="center" bottom_margin="14px" font_weight="700"][vc_column_text css=".vc_custom_philosophy031{text-align:center !important;max-width:760px !important;margin-left:auto !important;margin-right:auto !important;}"]The block edition ships three style variations. Each one re-tunes the whole palette rather than inverting it, and every text colour in every variation meets WCAG AA — measured, not assumed.[/vc_column_text][/vc_column][/vc_row][vc_row equal_height="yes" content_placement="top" css=".vc_custom_philosophy032{padding-top:0px !important;padding-bottom:24px !important;background-color:#f7f7f5 !important;}"]{$variation_teasers}[/vc_row]

[vc_row css=".vc_custom_philosophy040{padding-top:44px !important;padding-bottom:24px !important;}"][vc_column width="1/1"][vcex_heading text="Built for reading" tag="h2" font_size="34px" text_align="center" bottom_margin="14px" font_weight="700"][vc_column_text css=".vc_custom_philosophy041{text-align:center !important;max-width:760px !important;margin-left:auto !important;margin-right:auto !important;}"]Libre Baskerville for the words and Montserrat for everything around them, both served from your own server. A single measured column, a real author block, tags, previous and next, and threaded comments with labelled fields.[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_philosophy042{padding-bottom:56px !important;}"][vc_column width="1/1"][vcex_image image_id="{$img_single}" align="center" border_radius="12px" bottom_margin="0px" img_shadow="two"][/vc_column][/vc_row]

[vc_row css=".vc_custom_philosophy050{padding-top:44px !important;padding-bottom:20px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_heading text="What else is in it" tag="h2" font_size="34px" text_align="center" bottom_margin="24px" font_weight="700"][/vc_column][/vc_row][vc_row css=".vc_custom_philosophy051{padding-bottom:20px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/3"][vcex_icon_box style="one" heading_type="h3" heading="Nothing phones home" icon="fa fa-bolt" icon_color="#0054a5" heading_size="18px"]Both typefaces and the icon set are served from your own server. No Google Fonts, no CDN, no third-party request on any page — so the theme works behind a strict content security policy.[/vcex_icon_box][/vc_column][vc_column width="1/3"][vcex_icon_box style="one" heading_type="h3" heading="Social icons that work themselves out" icon="fa fa-share-alt" icon_color="#0054a5" heading_size="18px"]Add a link to your profile and the right icon appears, worked out from the address. X, Bluesky, Threads, Mastodon, TikTok and the rest — no CSS classes to look up.[/vcex_icon_box][/vc_column][vc_column width="1/3"][vcex_icon_box style="one" heading_type="h3" heading="Keyboard and screen reader" icon="fa fa-universal-access" icon_color="#0054a5" heading_size="18px"]A skip link, real buttons rather than links to nowhere, a focus outline you can see, one h1 per page, and a mobile menu that traps focus and closes on Escape.[/vcex_icon_box][/vc_column][/vc_row][vc_row css=".vc_custom_philosophy052{padding-bottom:44px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/3"][vcex_icon_box style="one" heading_type="h3" heading="Post formats" icon="fa fa-play-circle-o" icon_color="#0054a5" heading_size="18px"]Video and audio posts show their media in the grid without a featured image, using the player WordPress already ships rather than a second copy of it.[/vcex_icon_box][/vc_column][vc_column width="1/3"][vcex_icon_box style="one" heading_type="h3" heading="Block editor ready" icon="fa fa-th" icon_color="#0054a5" heading_size="18px"]Wide and full alignments, an editor stylesheet so the editor matches the page, four block styles and a set of patterns — in the classic edition too, not only the block one.[/vcex_icon_box][/vc_column][vc_column width="1/3"][vcex_icon_box style="one" heading_type="h3" heading="Translation ready" icon="fa fa-globe" icon_color="#0054a5" heading_size="18px"]Every string is translatable and a current .pot file ships with each edition. Right-to-left languages inherit WordPress's own handling.[/vcex_icon_box][/vc_column][/vc_row]

[vc_row css=".vc_custom_philosophy060{padding-top:44px !important;padding-bottom:44px !important;}"][vc_column width="1/1"][vcex_heading text="Questions" tag="h2" font_size="34px" text_align="center" bottom_margin="24px" font_weight="700"][vcex_toggle heading="Which edition should I install?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]If you already run Philosophy, stay on the classic theme — updating is safe and nothing moves. If you are starting fresh and want to edit the header, footer and templates visually, take the block edition. The design is the same either way.[/vcex_toggle][vcex_toggle heading="I use Philosophy already. What happens when I update?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]Your settings are kept, including the ones stored by the old framework the theme used to bundle. The About and Contact info blocks move into their pages as ordinary content the first time an administrator loads the admin, so they can be edited like the rest of the page.[/vcex_toggle][vcex_toggle heading="Can I install both?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]Yes. They are separate themes with separate directories, so they sit side by side. Only one is active at a time, and switching back restores the other's settings untouched.[/vcex_toggle][vcex_toggle heading="Does the block edition still have the Customizer?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]No — WordPress hides the Customizer for block themes, because everything it did now lives in one editor. Colours and type are under Appearance → Editor → Styles; the header, footer and templates are under Templates.[/vcex_toggle][vcex_toggle heading="Does it need any plugins?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]No. The classic edition can use Contact Form 7 on its Contact page template if you want a form, and renders whatever shortcode you give it otherwise. Nothing else is required.[/vcex_toggle][vcex_toggle heading="Can I use it on a client site?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]Yes. GPL v2 or later, no attribution required, no licence key and no seat limit.[/vcex_toggle][vcex_toggle heading="What does Philosophy cost?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]Nothing. Both editions are free and licensed GPL v2 or later — the same licence as WordPress itself.[/vcex_toggle][/vc_column][/vc_row]

[vc_row css=".vc_custom_philosophy070{padding-top:56px !important;padding-bottom:56px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_heading text="Download Philosophy" tag="h2" font_size="34px" text_align="center" bottom_margin="14px" font_weight="700"][vc_column_text css=".vc_custom_philosophy071{text-align:center !important;}"]Free, GPL v2 or later. The classic theme needs WordPress 6.0 or newer; the block theme needs 6.6 or newer. Both need PHP 7.4 or newer.[/vc_column_text][vc_column_text css=".vc_custom_philosophy072{text-align:center !important;margin-top:20px !important;}"][vc_btn title="Download Philosophy" style="flat" color="green" link="url:{$dl_classic_enc}|title:Download%20Philosophy|target:_blank" css=".vc_custom_philosophy073{{$btn_css}}" i_icon_fontawesome="fa fa-download" add_icon="true"][vc_btn title="Download Philosophy Blocks" style="flat" color="green" link="url:{$dl_blocks_enc}|title:Download%20Philosophy%20Blocks|target:_blank" css=".vc_custom_philosophy074{{$btn_css}}" i_icon_fontawesome="fa fa-download" add_icon="true"][vc_btn title="Live demo" style="flat" color="grey" link="url:{$demo_enc}|title:Live%20demo|target:_blank" css=".vc_custom_philosophy075{{$btn_css}}" i_icon_fontawesome="fa fa-eye" add_icon="true"][/vc_column_text][/vc_column][/vc_row]
HTML;

$kses = has_filter( 'content_save_pre', 'wp_filter_post_kses' );

if ( $kses ) {
	kses_remove_filters();
}

$result = wp_update_post(
	array(
		'ID'           => $page_id,
		'post_content' => $content,
		'post_title'   => 'Philosophy',
		'post_status'  => 'draft',
	),
	true
);

if ( $kses ) {
	kses_init_filters();
}

if ( is_wp_error( $result ) ) {
	echo 'ERROR: ' . $result->get_error_message() . "\n";
	return;
}

// WPBakery keeps every css="…" rule in the _wpb_shortcodes_custom_css post meta
// and only regenerates it when the page is saved through the builder UI.
// Updating post_content programmatically leaves that meta at whatever the first
// save produced, so every css= edit after that is silently inert.
if ( function_exists( 'visual_composer' ) ) {
	$vc = visual_composer();

	if ( method_exists( $vc, 'buildShortcodesCss' ) ) {
		$vc->buildShortcodesCss( $page_id, 'custom' );
		$vc->buildShortcodesCss( $page_id, 'default' );
		echo "custom css rebuilt\n";
	} elseif ( method_exists( $vc, 'buildShortcodesCustomCss' ) ) {
		$vc->buildShortcodesCustomCss( $page_id );
		echo "custom css rebuilt (legacy)\n";
	} else {
		echo "WARNING: could not rebuild the custom css — css= rules will be stale\n";
	}
} else {
	echo "WARNING: visual_composer() unavailable — css= rules will be stale\n";
}

$css = (string) get_post_meta( $page_id, '_wpb_shortcodes_custom_css', true );
echo 'css meta: ' . strlen( $css ) . " bytes, inline-block present: " . ( false !== strpos( $css, 'inline-block' ) ? 'yes' : 'NO' ) . "\n";

$saved = get_post_field( 'post_content', $page_id );

echo 'page: ' . $page_id . ' (' . get_post_status( $page_id ) . ")\n";
echo 'length: ' . strlen( $saved ) . "\n";
echo 'variation teasers: ' . substr_count( $saved, '[vcex_teaser' ) . "\n";
echo 'toggles: ' . substr_count( $saved, '[vcex_toggle' ) . ' (with heading=: ' . substr_count( $saved, '[vcex_toggle heading=' ) . ")\n";
echo 'images: ' . substr_count( $saved, '[vcex_image' ) . "\n";
echo 'unbalanced rows: ' . ( substr_count( $saved, '[vc_row' ) - substr_count( $saved, '[/vc_row]' ) ) . "\n";
echo 'unbalanced columns: ' . ( substr_count( $saved, '[vc_column ' ) - substr_count( $saved, '[/vc_column]' ) ) . "\n";

// A button whose href is dead is worse than no button, so check the rendered
// anchors rather than the shortcode text.
$rendered = do_shortcode( $saved );
preg_match_all( '#<a[^>]+href="([^"]*)"#', $rendered, $hrefs );
$unique = array_values( array_unique( $hrefs[1] ) );
$dead   = array_values(
	array_filter(
		$unique,
		function ( $h ) {
			return '' === $h || '#' === $h || false !== strpos( $h, 'http://https' ) || 0 === strpos( $h, 'url:' );
		}
	)
);

echo 'rendered links: ' . count( $unique ) . ', dead: ' . count( $dead ) . "\n";

foreach ( $dead as $d ) {
	echo '  DEAD: ' . $d . "\n";
}

// The outbound targets exist independently of this page; report them so a
// missing release is noticed here rather than by a visitor.
foreach ( array( $dl_classic, $dl_blocks, $demo ) as $target ) {
	$head = wp_remote_head( $target, array( 'timeout' => 15, 'redirection' => 5 ) );
	$code = is_wp_error( $head ) ? $head->get_error_message() : wp_remote_retrieve_response_code( $head );
	echo '  ' . str_pad( (string) $code, 6 ) . $target . "\n";
}

echo 'images resolve: ';
foreach ( array( $img_blocks_home, $img_classic_grid, $img_single, $img_ink, $img_paper, $img_sans ) as $id ) {
	echo ( wp_get_attachment_url( $id ) ? 'y' : 'N' );
}
echo "\n";
