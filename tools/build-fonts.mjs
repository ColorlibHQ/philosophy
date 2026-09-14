/**
 * Downloads the theme's webfonts and writes a local @font-face stylesheet.
 *
 * Up to 1.1.x Philosophy requested its fonts from fonts.googleapis.com on every
 * page load: a render-blocking third-party request that hands a visitor's IP
 * address to Google and makes the theme unusable under a strict CSP. They are
 * self-hosted now.
 *
 * Three families, and the reason for each:
 *
 * - **Metropolis** is the sans the Philosophy design was drawn with, in the
 *   HTML template and in Philosophy 1.1.x. 1.2.0 substituted Montserrat, which
 *   changed the texture of every page. It comes from Fontsource because it is
 *   not on Google Fonts. Latin only.
 * - **Libre Baskerville** supplies the headings. Its bold has to come from
 *   Fontsource too: the Google Fonts CSS API serves *the same file* for weight
 *   400 and weight 700, so a theme built from it declares a bold it does not
 *   have and every heading is synthesised by the browser.
 * - **Montserrat** ships only its latin-ext file, as the fallback for the few
 *   letters Metropolis does not draw — Latvian Ļ ļ and the Romanian comma-below
 *   Ș ș Ț ț. It is never downloaded by a page that has no such character.
 *
 * Usage:  node tools/build-fonts.mjs
 *
 * @package Philosophy
 */

import { writeFileSync, mkdirSync, readdirSync, unlinkSync } from 'node:fs';
import { join, dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const here = dirname( fileURLToPath( import.meta.url ) );
const themeRoot = resolve( here, '..' );
const fontDir = join( themeRoot, 'assets/fonts' );
const cssPath = join( themeRoot, 'assets/css/fonts.css' );

// A desktop Chrome UA is what makes Google Fonts serve woff2 with unicode-range.
const USER_AGENT =
	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

/** Pinned so a rebuild cannot quietly change what the theme ships. */
const FONTSOURCE = [
	{
		pkg: '@fontsource/metropolis',
		version: '5.3.0',
		family: 'Metropolis',
		faces: [
			[ 'latin', 400, 'normal' ],
			[ 'latin', 400, 'italic' ],
			[ 'latin', 500, 'normal' ],
			[ 'latin', 600, 'normal' ],
			[ 'latin', 700, 'normal' ],
			[ 'latin', 800, 'normal' ],
		],
	},
	{
		pkg: '@fontsource/libre-baskerville',
		version: '5.3.0',
		family: 'Libre Baskerville',
		faces: [
			[ 'latin', 400, 'normal' ],
			[ 'latin-ext', 400, 'normal' ],
			[ 'latin', 400, 'italic' ],
			[ 'latin-ext', 400, 'italic' ],
			[ 'latin', 700, 'normal' ],
			[ 'latin-ext', 700, 'normal' ],
		],
	},
];

/** Google Fonts still serves Montserrat as one variable file per subset. */
const GOOGLE = {
	api:
		'https://fonts.googleapis.com/css2' +
		'?family=Montserrat:ital,wght@0,300..800;1,300..800' +
		'&display=swap',
	keepSubsets: [ 'latin-ext' ],
};

/**
 * The unicode-range Google Fonts publishes for each subset. Fontsource omits it
 * on single-subset families, and a face with no range claims every codepoint,
 * which would stop the browser ever falling through to the next family.
 */
const RANGES = {
	latin:
		'U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, ' +
		'U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD',
	'latin-ext':
		'U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, ' +
		'U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, ' +
		'U+2C60-2C7F, U+A720-A7FF',
};

const face = ( family, style, weight, file, range ) =>
	`@font-face {\n` +
	`  font-family: '${ family }';\n` +
	`  font-style: ${ style };\n` +
	`  font-display: swap;\n` +
	`  font-weight: ${ weight };\n` +
	`  src: url("../fonts/${ file }") format('woff2');\n` +
	`  unicode-range: ${ range };\n` +
	`}`;

mkdirSync( fontDir, { recursive: true } );

for ( const stale of readdirSync( fontDir ) ) {
	if ( stale.endsWith( '.woff2' ) ) {
		unlinkSync( join( fontDir, stale ) );
	}
}

const out = [];
let files = 0;

for ( const { pkg, version, family, faces } of FONTSOURCE ) {
	for ( const [ subset, weight, style ] of faces ) {
		const name = `${ pkg.split( '/' )[ 1 ] }-${ subset }-${ weight }-${ style }.woff2`;
		const url = `https://cdn.jsdelivr.net/npm/${ pkg }@${ version }/files/${ name }`;
		const response = await fetch( url );

		if ( ! response.ok ) {
			console.error( `Failed to download ${ url } (${ response.status })` );
			process.exit( 1 );
		}

		writeFileSync( join( fontDir, name ), Buffer.from( await response.arrayBuffer() ) );
		files++;

		out.push( `/* ${ family } — ${ subset } */\n` + face( family, style, weight, name, RANGES[ subset ] ) );
	}
}

const response = await fetch( GOOGLE.api, { headers: { 'User-Agent': USER_AGENT } } );

if ( ! response.ok ) {
	console.error( `Google Fonts returned ${ response.status }` );
	process.exit( 1 );
}

const blocks = [
	...( await response.text() ).matchAll( /\/\* ([a-z-]+) \*\/\s*(@font-face \{[\s\S]*?\})/g ),
].map( ( match ) => ( { subset: match[ 1 ], css: match[ 2 ] } ) );

if ( ! blocks.length ) {
	console.error( 'No @font-face blocks found in the Google Fonts response.' );
	process.exit( 1 );
}

for ( const block of blocks ) {
	if ( ! GOOGLE.keepSubsets.includes( block.subset ) ) {
		continue;
	}

	const url = block.css.match( /url\((https:\/\/fonts\.gstatic\.com\/[^)]+)\)/ )?.[ 1 ];

	if ( ! url ) {
		continue;
	}

	const family = block.css.match( /font-family: '([^']+)'/ )?.[ 1 ] ?? 'font';
	const style = block.css.match( /font-style: ([a-z]+)/ )?.[ 1 ] ?? 'normal';
	const weight = ( block.css.match( /font-weight: ([0-9 ]+)/ )?.[ 1 ] ?? '400' ).replace( / /g, '-' );
	const slug = family.toLowerCase().replace( /[^a-z0-9]+/g, '-' );
	const name = `${ slug }-${ weight }-${ style }-${ block.subset }.woff2`;

	const file = await fetch( url, { headers: { 'User-Agent': USER_AGENT } } );

	if ( ! file.ok ) {
		console.error( `Failed to download ${ url }` );
		process.exit( 1 );
	}

	writeFileSync( join( fontDir, name ), Buffer.from( await file.arrayBuffer() ) );
	files++;

	out.push(
		block.css
			.replace( /url\(https:\/\/fonts\.gstatic\.com\/[^)]+\)/, `url("../fonts/${ name }")` )
			.replace( /^@font-face \{/, `/* ${ family } — ${ block.subset }, fallback only */\n@font-face {` )
	);
}

const header = `/**
 * Self-hosted webfaces for Philosophy.
 *
 * Generated by tools/build-fonts.mjs — edit that script, not this file.
 *
 * Metropolis is public domain (Unlicense). Libre Baskerville and Montserrat are
 * under the SIL Open Font License 1.1. See readme.txt for the full credits.
 */

`;

writeFileSync( cssPath, header + out.join( '\n\n' ) + '\n' );

console.log( `Wrote ${ files } font files and ${ out.length } @font-face rules.` );
