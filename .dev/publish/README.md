# Publishing scripts for colorlib.com

Run these with wp-cli **as the site user**, from the colorlib.com docroot:

```bash
scp .dev/publish/colorlib-product-page.php hetzner:/tmp/pp.php
ssh hetzner 'cd /var/www/colorlib.com/public \
  && sudo chown web_colorlib_com /tmp/pp.php \
  && sudo -u web_colorlib_com wp --url=https://colorlib.com/wp/ eval "require \"/tmp/pp.php\";"'
```

| Script | Does |
| --- | --- |
| `colorlib-product-page.php` | Rebuilds the Philosophy product page (169039). Idempotent; leaves it a **draft**. |
| `colorlib-themes-listing.php` | Adds Philosophy to the `/wp/themes/` listing (5091). Bails if already listed. |

## Use `wp eval "require …"`, not `wp eval-file`

`wp eval-file` runs these scripts and **prints nothing, changes nothing and
exits 0**. No error, no warning. `wp eval "require '…';"` runs the identical
file correctly. Whatever the cause, the symptom is indistinguishable from a
script that decided to do nothing, so it cost a while to spot. Use `require`.

## The trap that makes these scripts necessary

**WPBakery keeps every `css="…"` rule in the `_wpb_shortcodes_custom_css` post
meta, and only regenerates it when the page is saved through the builder UI.**

Updating `post_content` with `wp_update_post()` leaves that meta at whatever the
*first* save produced, so every `css=` edit after that is silently inert — the
markup says one thing and the page renders another.

Both scripts call `visual_composer()->buildShortcodesCss( $id, 'custom' )` after
saving. **Any script that writes WPBakery content must do the same.**

## Other things worth knowing

- **URLs in a `vc_btn` `link=` attribute must be percent-encoded.** That
  attribute is WPBakery's own `url:…|title:…|target:…` encoding: it splits on
  `|` then on the **first `:`**, so a raw `https://…` is cut off at `https:`
  and the button renders `href="http://https"` — every button dead while the
  shortcode text reads perfectly. `rawurlencode()` it. Plain `url="…"`
  attributes (`vcex_teaser`) take the URL as-is.
- **Check the rendered `<a href>`, not the shortcode.** The script asserts
  `dead: 0` by running `do_shortcode()` and scanning the anchors, and then
  HEADs each outbound URL so a missing release shows up here rather than to a
  visitor.
- **`vcex_toggle` takes `heading`, not `title`.** With `title` every toggle
  renders the shortcode's own placeholder, "Lorem ipsum dolor sit amet?".
- **`vcex_icon_box` and `vcex_teaser` render `h2` unless given
  `heading_type="h3"`.** Without it a page of cards produces nineteen sibling
  h2s and no outline at all.
- **`vcex_milestone animated="true"` counts up when scrolled into view**, so a
  full-page screenshot taken without scrolling shows `0`. Scroll first.
- **Draft pages 301 for anonymous visitors, and the pretty permalink then
  resolves to something else entirely** — `/wp/themes/philosophy/` falls through
  to the HTML *template* post of the same name. Preview with
  `?page_id=169039&preview=true` and a cookie from `wp_generate_auth_cookie()`,
  named `wordpress_logged_in_` . COOKIEHASH (read COOKIEHASH from the site, do
  not compute it — this install's is not md5 of the front-end URL).
- **Yoast meta is not writable over REST**, and changing it means deleting the
  `wp_yoast_indexable` row and rebuilding, or the old title keeps being served.

## What is still missing for this page to go live

The two download buttons point at the update endpoint, which 404s until the
releases exist:

```
https://updates.colorlib.com/download/theme/philosophy.zip         404
https://updates.colorlib.com/download/theme/philosophy-blocks.zip  404
```

To fix, per release: upload the zip to
`r2:colorlib-downloads/wp/{slug}/{slug}-{version}.zip`, then from
`~/Projects/colorlib-updates`:

```bash
node release.mjs --product theme/philosophy --version 1.2.0 \
  --package https://downloads.colorlib.com/wp/philosophy/philosophy-1.2.0.zip \
  --url https://colorlib.com/wp/themes/philosophy/ \
  --tested 7.1 --requires 6.0 --requires-php 7.4
```

`colorlibhub.com/philosophy/` exists but still runs a placeholder demo site, so
the Live demo button works while showing the wrong thing.
