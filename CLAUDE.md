# Philosophy — architecture and invariants

A masonry blog theme for WordPress. Version 1.2.0 removed the Epsilon framework
and rebuilt everything it provided on WordPress core.

This file is export-ignored: it is in the repository, never in a release zip.

## Layout

```
functions.php                 constants, includes, instantiates Philosophy
inc/
  classes/Class-Config.php    the Philosophy class: theme support + enqueues
  classes/Class-Enqueue.php   deprecated shim, nothing uses it
  philosophy-functions.php    helpers, including philosophy_defaults()
  philosophy-sanitize.php     every Customizer sanitize callback
  philosophy-commoncss.php    the inline colour CSS
  philosophy-blocks.php       block styles and patterns
  philosophy-deprecated.php   Epsilon shims
  wp_bootstrap_navwalker.php  the primary and social nav walkers
  hooks/                      the do_action points the templates hang off
  customizer/
    class-philosophy-customizer.php   add_field()/add_multiple()
    controls/                          toggle, text editor, repeater, layout
    fields/                            the field and section definitions
    assets/                            control CSS and JS
    js/                                pane script and preview script
  admin/class-philosophy-welcome.php   the About Philosophy screen
templates/                    template parts
assets/css/                   base, vendor, main, fonts, fontawesome, editor
assets/js/philosophy.js       all the front-end behaviour
tools/                        build and verification scripts
```

## Invariants

**Never reintroduce jQuery on the front end.** `assets/js/philosophy.js` is the
only script the theme enqueues. It has no dependencies.

**Anything a component needs in order to function is set from JavaScript, not
from a stylesheet.** The masonry positioning and the reveal starting state are
applied from the script. A site serving a cached or replaced `style.css` — a
plugin-generated combined stylesheet, a child theme — must still get a working
page. Only cosmetics belong in CSS.

**Stored Customizer values keep their 1.1.x shapes.** `philosophy_blog_layout`
may be the Epsilon column-descriptor array, a JSON string of it, or a plain
column count; `philosophy_normalize_layout()` reads all three. The repeaters may
be an array of arrays, an array of objects, or JSON;
`philosophy_decode_repeater()` reads all three. Do not "clean up" a stored value
without a migration.

**Every setting has a sanitize callback**, chosen by
`Philosophy_Customizer::default_sanitizer()` unless the field overrides it.
Colours accept short hex and `rgba()` because Epsilon wrote both.

**`philosophy_opt()` falls back to `philosophy_defaults()`**, not to zero. Add a
new setting to that map at the same time you add its field, or it will read as
empty on every site that has not saved it.

**The icon stylesheet and the icon fonts are built together.** The solid and
regular faces are subset to exactly the codepoints `all.css` references. After
running `tools/build-fontawesome.mjs`, run `tools/verify-icons.py`; it fails if
any referenced codepoint has no drawable glyph. Do not hand-edit either.

**Minified assets are what get served.** After editing any `.css` or
`assets/js/philosophy.js`, run `node tools/build-assets.mjs` or the change never
reaches a visitor. `SCRIPT_DEBUG` serves the readable sources.

**Asset handles are prefixed.** The theme used to claim `base`, `main`, `vendor`
and `font-awesome`; a plugin registering any of those first replaced the theme's
own file.

## Build

```bash
node tools/build-assets.mjs                       # minify CSS and JS
node tools/build-fontawesome.mjs <fa-free-pkg>    # rebuild the icon bundle
python3 tools/verify-icons.py                     # then always verify it
node tools/build-fonts.mjs                        # refetch the webfonts
```

`tools/build-fontawesome.mjs` wants the unpacked `@fortawesome/fontawesome-free`
npm package. Font subsetting needs `fonttools` and `brotli`.

## Release

```bash
git archive --format=zip --prefix=philosophy/ -o philosophy.zip HEAD
```

`.gitattributes` keeps `tools/`, the dotfiles and the markdown out of the
archive, so the zip is exactly what people install.

## Things that bit, and why the code looks the way it does

- **Epsilon's submodules are gone from GitHub.** That is why 1.1.2 fatalled on a
  fresh checkout and why nothing may depend on an external framework again.
- **`control.container` is a jQuery object.** Assigning `.hidden` to it does
  nothing; reach for `container[0]`.
- **A repeater template rendered outside its wrapper is invisible to the
  script.** Keep the `<script type="text/html">` inside `.philosophy-repeater`.
- **Re-dispatching the event you are listening for blows the call stack.** The
  Customizer already listens to control inputs.
- **`html.cl-preload .featured { opacity: 0 }`** is how a page ends up reporting
  no first contentful paint when one asset is slow. Nothing may hold content at
  zero opacity waiting for `load`.
- **WebKit resolves `*.local` through mDNS**, so it hangs on a Local site's
  hostname. Test it through a loopback proxy that supplies the `Host` header.
- **Playwright's `isVisible()` passes on white-on-white text.** Assert contrast
  on menu changes, not visibility.
