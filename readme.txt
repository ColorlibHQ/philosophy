=== Philosophy ===

Contributors: colorlib
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: blog, two-columns, left-sidebar, right-sidebar, custom-background, custom-colors, custom-logo, custom-menu, featured-images, footer-widgets, post-formats, sticky-post, theme-options, threaded-comments, translation-ready, block-styles, wide-blocks

A modern masonry blog theme.

== Description ==

Philosophy is a masonry blog WordPress theme with a featured area at the top of
the blog, a full-screen search overlay and a mobile navigation panel. It styles
the standard, video and audio post formats, supports a sidebar on either side of
the grid, and ships About and Contact page templates.

The theme is built without jQuery. Everything it does on the front end — the
masonry grid, the search overlay, the mobile menu, the scroll reveal and the
back-to-top button — runs on about 12 KB of vanilla JavaScript.

* Masonry blog layout with a choice of no sidebar, a right sidebar or a left one
* A featured area on the blog home page, driven by any category you choose
* Social icons picked automatically from the address each menu item points at
* Seven footer widget areas plus a post sidebar
* Popular posts and newsletter widgets
* About and Contact page templates
* Block editor support: wide and full alignments, block styles and patterns
* Self-hosted webfonts — no third-party requests on any page
* Translation ready

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload Theme and choose the philosophy.zip file, then click Install Now.
3. Click Activate to use the theme right away.
4. Go to Appearance > Customize and open Theme Options to set the theme up.

== Frequently Asked Questions ==

= How do I add the social icons in the header? =

Create a menu under Appearance > Menus, add a custom link for each profile, and
assign the menu to the Social Menu location. The icon is worked out from the
address, so a link to your Instagram profile shows the Instagram icon with no
further setup. To override one, add a Font Awesome class such as `fa-mastodon`
to the menu item's CSS Classes field.

= Where do the three large posts at the top of the blog come from? =

Appearance > Customize > Theme Options > Blog > Featured post category. The three
most recent posts in that category fill the featured area.

= The Contact page template shows no map =

The map only appears once you have saved a Google Maps API key under Theme
Options > General, together with a latitude and longitude under Theme Options >
Contact Page. Without a key Google renders a grey placeholder, so the theme
leaves the map out entirely.

= I upgraded from 1.1.x and the About Philosophy screen looks different =

It was rebuilt on standard WordPress admin markup in 1.2.0. The screen it
replaced came from the Epsilon framework, whose upstream project no longer
exists. All of your settings were kept.

== Changelog ==

= 1.2.0 =

The Epsilon release. Philosophy 1.1.2 could not be installed from a fresh
checkout at all: the theme depended on two git submodules, `epsilon-framework`
and `epsilon-theme-dashboard`, whose repositories have been deleted. Without them
every page raised a fatal error and the Customizer never loaded. 1.2.0 removes
that dependency and rebuilds what it provided on WordPress core.

Fixed

* Fixed the fatal error that made the theme unusable when installed from source.
* Fixed the Customizer, which had been gated behind the missing framework and so
  never registered a single setting.
* Fixed four options that read as "on" in the Customizer but behaved as "off" on
  a fresh install: the featured area, the header search, the header social icons
  and the footer widgets.
* Fixed parent menu items linking to `#` instead of their own page.
* Fixed the site navigation being invisible to visitors until a menu was
  assigned; the theme now falls back to a page menu.
* Fixed the empty placeholder text that shipped as the default archive and
  search page descriptions.
* Fixed the comment count, category lists and post dates rendering a stray
  trailing comma.
* Fixed the author biography printing raw HTML.
* Fixed the Contact Form 7 list only offering the first page of forms.
* Fixed the search form, the comment form and the social links having no
  accessible names.
* Fixed several PHP 8 deprecation notices.

Security and privacy

* Every Customizer setting now has a sanitize callback. Most had none, so what
  an administrator pasted into a colour field reached the front end verbatim.
* The generated colour CSS is escaped on output.
* Removed the Google Maps script, which loaded on every page with an empty API
  key. It now loads only on a Contact page that has a key saved, and only once
  the map scrolls into view.
* Removed the Mailchimp validation script the newsletter widget pulled from
  Amazon S3 on every page that showed the widget.
* Webfonts are served from the theme instead of fonts.googleapis.com, so no
  visitor's address is handed to a third party.
* The post view counter no longer writes to the database on previews, feeds and
  robot requests.

Settings

* The About and Contact info blocks are page content now, edited in the block
  editor like the rest of the page. They were a Customizer repeater: a heading
  and a body of rich text, repeated, stored in a theme_mod and printed under the
  page. That is page content wearing a costume. Existing rows are moved into
  their page automatically the next time an administrator loads the admin, as
  real heading and paragraph blocks, and the Info blocks pattern builds the same
  layout for a new page. The old setting is left in the database rather than
  deleted, and the templates keep rendering it until the move has happened.
* Every remaining Customizer control is a core WordPress control type: the
  toggles are checkboxes, the blog layout is a radio, the rich-text fields are
  textareas, the colours are core colour pickers. The theme ships no control
  classes of its own.

Updates

* Philosophy checks for its own updates through the Update URI header that
  WordPress 6.1 added for themes distributed outside the theme directory, the
  same way Academia and Unapp do. Updates appear in Dashboard > Updates and
  Appearance > Themes with no cron, no bespoke updater and no nagging notice.
* The same request is the only install count Colorlib gets. It sends the theme
  version, the WordPress and PHP versions, the locale, whether the install is
  multisite, and a site identifier that is a one-way hash of the home URL salted
  with the install's own key. No site name, no URL and no personal data. The
  About Philosophy screen says so, and the philosophy_check_for_updates filter
  switches it off.

Removed

* Removed the Epsilon framework, the Epsilon theme dashboard and the onboarding
  wizard. Compatibility shims keep `Epsilon_Customizer::add_field()` working for
  child themes.
* Rebuilt the About Philosophy screen on core admin markup.
* Removed jQuery, Modernizr, Pace, Masonry, imagesLoaded, FitVids, Slick, Lity,
  AOS, google-code-prettify and the HTML5 placeholder polyfill — 266 KB of
  JavaScript, replaced by 12 KB of vanilla JavaScript.
* MediaElement now comes from WordPress core, and only on pages with audio or
  video on them.
* Removed 1.6 MB of images that nothing referenced.
* Removed the Grunt toolchain.

Performance

* Minified CSS and JavaScript are now the files that get served. The theme
  shipped both, then enqueued the unminified ones.
* Asset handles are prefixed. The theme used to claim the generic handles
  `base`, `main`, `vendor` and `font-awesome`, so a plugin registering any of
  those first silently replaced the theme's own file.
* Post thumbnails are output through `the_post_thumbnail()`, which adds srcset,
  sizes, width, height and lazy loading. None of that was present before.
* The vendor stylesheet went from 53 KB to 2 KB.
* A blog home page now pulls 356 KB from the theme, fonts and icons included,
  against 464 KB before the fonts were subset and around 1 MB in 1.1.x.
* The preloader no longer holds the featured area at zero opacity until the page
  finishes loading, and it is removed outright if an asset hangs.
* The screenshot went from 750 KB to 130 KB.

Icons

* Font Awesome 4.7 was replaced with Font Awesome 7.3.1, trimmed to every brand
  icon, every Font Awesome 4.7 icon and the icons the theme uses. Existing
  `fa-` classes keep working through Font Awesome's version 4 shims. The
  stylesheet is 51 KB rather than the 111 KB of upstream's all.css plus shims.
* Only `.woff2` font files are shipped, and the solid and regular faces are
  subset to the icons the stylesheet can reference: 117 KB becomes 17 KB and
  19 KB becomes 11 KB. Brands ships whole, because which networks a site links
  to is unknowable. tools/verify-icons.py checks that every codepoint the
  stylesheet references still has a glyph that draws.
* Social icons cover the networks that did not exist in 2018: X, Bluesky,
  Threads, Mastodon, TikTok, Discord, Telegram and others.

Accessibility

* Added a skip link, `wp_body_open()` and a `main` landmark.
* The search trigger, the menu toggle and the overlay close controls are buttons
  rather than links to `#0`, and they carry `aria-expanded`.
* The mobile menu traps focus while it is open and closes on Escape.
* Restored a visible focus outline, which the theme's reset had removed.
* One `h1` per page: archive card titles are `h2`.
* Scroll reveal is skipped entirely when the visitor prefers reduced motion.

Compatibility

* Declared support for WordPress 7.1 and PHP 8.4.
* Added `theme.json`, wide and full alignments, block styles, block patterns and
  the editor stylesheet the theme had referenced since 1.0 without shipping it.
* Added `custom-background` and a proper `custom-logo` declaration.

= 1.1.2 =
* Bug fixes.

= 1.1.1 =
* Bug fixes.

= 1.0 =
* Initial release.

== Notes for maintainers ==

Theme Check reports one REQUIRED item: the `Update URI` header. That rule is for
themes *in* the WordPress.org directory, which must not carry it. Philosophy is
distributed from colorlib.com, which is the case the header exists for. If the
theme is ever submitted to the directory, drop the header and
`inc/philosophy-updates.php` together.

The update endpoint `https://updates.colorlib.com/theme/philosophy.json` has to
be published for update checks to report anything. Until it is, the check fails
closed: no update is offered and no error is shown.

== Copyright ==

Philosophy WordPress Theme, Copyright 2018-2026 Colorlib
Philosophy is distributed under the terms of the GNU GPL v2 or later.

Philosophy is based on Underscores https://underscores.me/,
(C) 2012-2024 Automattic, Inc., licensed under GPLv2 or later.

== Resources ==

Font Awesome Free 7.3.1
* Copyright Fonticons, Inc.
* Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License
* https://fontawesome.com/license/free
* Bundled in assets/css/fontawesome/, trimmed by tools/build-fontawesome.mjs

Metropolis
* Copyright Chris Simpson
* The Unlicense (public domain)
* https://github.com/dw5/Metropolis
* Bundled in assets/fonts/

Libre Baskerville
* Copyright Impallari Type
* SIL Open Font License, 1.1
* https://fonts.google.com/specimen/Libre+Baskerville
* Bundled in assets/fonts/

Montserrat
* Copyright The Montserrat Project Authors
* SIL Open Font License, 1.1
* https://fonts.google.com/specimen/Montserrat
* Bundled in assets/fonts/, latin-ext only, as the fallback for the few letters
  Metropolis does not draw

MediaElement.js control sprite (img/mejs/)
* Copyright 2010-2024 John Dyer
* MIT License
* https://www.mediaelementjs.com/

The theme ships no photographs. The images in screenshot.jpg are a Colorlib
composite used for the theme listing only and are not part of the theme files.
