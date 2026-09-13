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
| `colorlib-themes-listing.php` | Adds Philosophy to the `/wp/themes/` listing (5091). If already listed, refreshes the card image and leaves the rest alone. |
| `frame.mjs` | Wraps a screenshot in the browser frame the page uses: `node frame.mjs in.png out.jpg 88`. |

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

## The demo site

`colorlibhub.com/philosophy/` (blog 14) is the real demo now: 16 posts across
five categories, About and Contact, both editions installed, **Philosophy
Blocks active**. Every screenshot on the page and the listing card comes from
it, framed by `frame.mjs` and imported as 381470-381476. The first set
(381458-381466) was captured before the demo existed, showed the *Academia*
demo content, and has been deleted.

Switching editions for a capture is just `wp theme activate philosophy` /
`philosophy-blocks`; style variations are applied by writing the variation JSON
into the `wp_global_styles` post.

**Two traps on that site specifically:**

- **`wp_global_styles` needs its `wp_theme` term.** Without it every write
  creates a *new* orphan post and `get_user_global_styles_post_id()` keeps
  resolving to the old one, so all three variations render identically. The
  captures were byte-identical twice before this was spotted. Post 125 carries
  the term `philosophy-blocks`.
- **On a subdirectory multisite the asset URL is not what you think.** The
  stylesheet is at `/philosophy/wp-content/themes/…`, not
  `/wp-content/themes/…`, and Cloudflare caches them as different objects with
  `immutable`. Purging the second one leaves the browser on the old CSS while
  `curl` of the first reports the change landed.
- **Uploads on colorlibhub are owned by `www-data`**, the opposite of
  colorlib.com, so attaching media has to run as `www-data`.
