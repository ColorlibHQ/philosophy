/**
 * Builds the Font Awesome bundle the theme ships.
 *
 * Font Awesome Free is ~111 KB of CSS across all.css and v4-shims.css, defining
 * every one of the ~2,000 free icons. Philosophy loads its icon stylesheet on
 * every page, so shipping all of it is 111 KB that almost no site uses.
 *
 * This script keeps:
 *   - the whole core (sizing, rotation, stacking, list and animation utilities);
 *   - every brand icon, so any social network a reader links to has an icon;
 *   - every solid/regular icon that a v4 shim maps to, which is exactly the
 *     Font Awesome 4.7 set Philosophy 1.1.x shipped, so no icon a site already
 *     uses can disappear;
 *   - the icons this theme's own markup and stylesheet reference;
 *   - the "FontAwesome" v4 font-family alias, which assets/css/main.css uses.
 *
 * Only .woff2 sources are kept: every browser that can run WordPress 6.7 reads
 * woff2, and the .ttf fallbacks double the download for nobody.
 *
 * Usage:  node tools/build-fontawesome.mjs <path-to-fontawesome-free-package>
 *
 * @package Philosophy
 */

import { readFileSync, writeFileSync, mkdirSync, copyFileSync, existsSync } from 'node:fs';
import { join, dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import { spawnSync } from 'node:child_process';

const here = dirname( fileURLToPath( import.meta.url ) );
const themeRoot = resolve( here, '..' );
const outDir = join( themeRoot, 'assets/css/fontawesome' );
const outFonts = join( outDir, 'webfonts' );

const source = process.argv[ 2 ];

if ( ! source || ! existsSync( join( source, 'css/fontawesome.css' ) ) ) {
	console.error( 'Usage: node tools/build-fontawesome.mjs <path-to-fontawesome-free-package>' );
	process.exit( 1 );
}

const read = ( file ) => readFileSync( join( source, file ), 'utf8' );

/** Icons this theme references directly, by Font Awesome 7 name. */
const themeIcons = [
	'angle-down', 'angle-left', 'angle-right', 'angle-up',
	'arrow-left-long', 'arrow-right-long', 'arrow-up',
	'bars', 'calendar', 'chevron-down', 'chevron-up',
	'comment', 'envelope', 'folder', 'heart', 'link',
	'magnifying-glass', 'minus', 'play', 'plus',
	'quote-left', 'quote-right', 'tag', 'user', 'xmark'
];

/**
 * Splits a Font Awesome stylesheet into its banner, its non-icon rules and its
 * icon rules keyed by icon name.
 *
 * @param {string} css Stylesheet source.
 * @return {{banner: string, base: string, icons: Map<string, string>}} Parts.
 */
const split = ( css ) => {
	const banner = css.match( /^\/\*![\s\S]*?\*\/\n/ )?.[ 0 ] ?? '';
	const body = css.slice( banner.length );
	const icons = new Map();

	// Icon rules are always a single declaration of the --fa custom property.
	const base = body.replace(
		/\.fa-([a-z0-9-]+) \{\n(\s*--fa(?:--fa)?: "[^"]*";\n)+\}\n\n?/g,
		( rule, name ) => {
			icons.set( name, rule );
			return '';
		}
	);

	return { banner, base, icons };
};

const core = split( read( 'css/fontawesome.css' ) );
const brands = split( read( 'css/brands.css' ) );
const shims = read( 'css/v4-shims.css' );

/** Every codepoint a v4 shim maps to: the Font Awesome 4.7 icon set. */
const shimCodepoints = new Set(
	[ ...shims.matchAll( /--fa: "(\\[0-9a-f]+)"/g ) ].map( ( match ) => match[ 1 ] )
);

/** Icon names to keep out of the solid/regular table. */
const keep = new Set( themeIcons );

for ( const [ name, rule ] of core.icons ) {
	const codepoint = rule.match( /--fa: "(\\[0-9a-f]+)"/ )?.[ 1 ];

	if ( codepoint && shimCodepoints.has( codepoint ) ) {
		keep.add( name );
	}
}

const missing = themeIcons.filter( ( name ) => ! core.icons.has( name ) );

if ( missing.length ) {
	console.error( 'Icons not found in this Font Awesome build: ' + missing.join( ', ' ) );
	process.exit( 1 );
}

/** Drops .ttf sources and rewrites the webfont path to sit beside this file. */
const woff2Only = ( css ) =>
	css
		.replace( /,\s*url\("[^"]*\.ttf"\) format\("truetype"\)/g, '' )
		.replace( /url\("\.\.\/webfonts\//g, 'url("webfonts/' );

/**
 * Splits a stylesheet into top-level blocks, keeping braces balanced.
 *
 * @param {string} css Stylesheet source.
 * @return {Array<{prelude: string, body: string|null, raw: string}>} Blocks.
 */
const parseBlocks = ( css ) => {
	const blocks = [];
	let i = 0;
	let prelude = '';

	while ( i < css.length ) {
		const char = css[ i ];

		if ( '{' === char ) {
			let depth = 1;
			let j = i + 1;

			while ( j < css.length && depth > 0 ) {
				if ( '{' === css[ j ] ) {
					depth += 1;
				} else if ( '}' === css[ j ] ) {
					depth -= 1;
				}

				j += 1;
			}

			blocks.push( {
				prelude: prelude.trim(),
				body: css.slice( i + 1, j - 1 ),
				raw: prelude + css.slice( i, j )
			} );

			prelude = '';
			i = j;
			continue;
		}

		if ( ';' === char ) {
			blocks.push( { prelude: prelude.trim() + ';', body: null, raw: prelude + ';' } );
			prelude = '';
			i += 1;
			continue;
		}

		prelude += char;
		i += 1;
	}

	if ( prelude.trim() ) {
		blocks.push( { prelude: prelude.trim(), body: null, raw: prelude } );
	}

	return blocks;
};

/**
 * Drops the animation utilities Font Awesome 4.7 never had.
 *
 * Philosophy 1.1.x shipped Font Awesome 4.7, so no existing site can be using
 * fa-beat, fa-bounce, fa-buzz, fa-fade, fa-flip, fa-float, fa-jello, fa-shake,
 * fa-swing, fa-wag or fa-spin-snap. fa-spin and fa-pulse did exist in 4.7 and
 * are kept.
 *
 * This walks balanced blocks rather than matching text: the animations live
 * inside an @media (prefers-reduced-motion) wrapper as well as at the top
 * level, and a regular expression cannot tell which closing brace is whose.
 *
 * @param {string} css Stylesheet source.
 * @return {string} Stylesheet without the unused animations.
 */
const trimAnimations = ( css ) => {
	const drop = [
		'beat', 'beat-fade', 'bounce', 'buzz', 'fade', 'flip', 'float',
		'jello', 'shake', 'spin-snap', 'swing', 'wag'
	];

	// fa-flip-horizontal and friends are transforms, not animations.
	const keepExactly = /^\.fa-(?:flip-horizontal|flip-vertical|flip-both)(?:\.[a-z0-9-]+)*$/;

	const isDropped = ( name ) => drop.some( ( dropped ) => name === dropped || name.startsWith( dropped + '-' ) );

	const filter = ( source ) =>
		parseBlocks( source )
			.filter( ( block ) => {
				const keyframes = block.prelude.match( /^@(?:-webkit-)?keyframes\s+fa-([a-z0-9-]+)$/ );

				if ( keyframes ) {
					return ! block.prelude.startsWith( '@-webkit-' ) && ! isDropped( keyframes[ 1 ] );
				}

				if ( block.prelude.startsWith( '@' ) || null === block.body ) {
					return true;
				}

				const selectors = block.prelude.split( ',' ).map( ( selector ) => selector.trim() );

				// Drop a rule only when every selector in it targets a dropped
				// animation, so shared rules survive.
				return ! selectors.every( ( selector ) => {
					if ( keepExactly.test( selector ) ) {
						return false;
					}

					const match = selector.match( /^\.fa-([a-z0-9-]+)(?:\.[a-z0-9-]+)*$/ );

					return match ? isDropped( match[ 1 ] ) : false;
				} );
			} )
			.map( ( block ) => {
				if ( null === block.body || ! block.prelude.startsWith( '@' ) ) {
					return block.raw;
				}

				// Recurse into @media and @supports so their contents are filtered
				// too, and their own braces stay balanced.
				if ( /^@(?:media|supports|layer)\b/.test( block.prelude ) ) {
					return block.prelude + ' {\n' + filter( block.body ) + '\n}\n';
				}

				return block.raw;
			} )
			.join( '' );

	return filter( css );
};

/**
 * Rewrites the v4 shims so the font-family declaration appears once.
 *
 * Font Awesome emits two rules per shim, and repeats the same
 * font-family/font-weight pair across hundreds of them. Collecting the shims
 * that share a family into one selector list leaves each shim costing only its
 * own codepoint.
 *
 * @param {string} css Stylesheet source.
 * @return {string} Stylesheet with the shims regrouped.
 */
const mergeShims = ( css ) => {
	const families = new Map();
	const codepoints = [];

	const body = css.replace(
		/\.fa\.fa-([a-z0-9-]+) \{\n((?:\s+[a-z-]+: [^;]+;\n)+)\}\n\n?/g,
		( rule, name, declarations ) => {
			const family = declarations.match( /font-family: ([^;]+);/ )?.[ 1 ];
			const weight = declarations.match( /font-weight: ([^;]+);/ )?.[ 1 ];
			const codepoint = declarations.match( /--fa: ("[^"]*");/ )?.[ 1 ];

			if ( family ) {
				const key = family + '|' + ( weight ?? '' );

				if ( ! families.has( key ) ) {
					families.set( key, { family, weight, names: [] } );
				}

				families.get( key ).names.push( name );
			}

			if ( codepoint ) {
				codepoints.push( `.fa.fa-${ name } {\n  --fa: ${ codepoint };\n}` );
			}

			return '';
		}
	);

	if ( ! codepoints.length ) {
		return css;
	}

	const grouped = [ ...families.values() ].map( ( group ) => {
		const selectors = group.names.map( ( name ) => `.fa.fa-${ name }` ).join( ',\n' );
		const weight = group.weight ? `\n  font-weight: ${ group.weight };` : '';

		return `${ selectors } {\n  font-family: ${ group.family };${ weight }\n}`;
	} );

	return body.trimEnd() + '\n\n' + grouped.join( '\n\n' ) + '\n\n' + codepoints.join( '\n\n' ) + '\n';
};

const banner = `/*!
 * Font Awesome Free 7.3.1 by @fontawesome - https://fontawesome.com
 * License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License)
 * Copyright 2026 Fonticons, Inc.
 *
 * Trimmed for Philosophy by tools/build-fontawesome.mjs: every brand icon, every
 * Font Awesome 4.7 icon (via the v4 shims) and the icons this theme uses.
 */
`;

const parts = [
	banner,
	core.base.trim(),
	'',
	'/* Icons: solid and regular */',
	[ ...keep ].sort().map( ( name ) => core.icons.get( name ).trim() ).join( '\n\n' ),
	'',
	'/* Brands */',
	brands.base.trim(),
	'',
	[ ...brands.icons.keys() ].sort().map( ( name ) => brands.icons.get( name ).trim() ).join( '\n\n' ),
	'',
	'/* Font families */',
	split( read( 'css/solid.css' ) ).base.trim(),
	'',
	split( read( 'css/regular.css' ) ).base.trim(),
	'',
	'/* Version 4 compatibility */',
	read( 'css/v4-font-face.css' ).replace( /^\/\*![\s\S]*?\*\/\n/, '' ).trim(),
	'',
	shims.replace( /^\/\*![\s\S]*?\*\/\n/, '' ).trim()
];

const out = mergeShims( trimAnimations( woff2Only( parts.join( '\n' ) ) ) ) + '\n';

/**
 * A deliberately conservative minifier: comments out, whitespace collapsed.
 *
 * @param {string} css Stylesheet source.
 * @return {string} Minified stylesheet.
 */
const minify = ( css ) => {
	const bannerMatch = css.match( /^\/\*![\s\S]*?\*\/\n/ )?.[ 0 ] ?? '';

	return (
		bannerMatch +
		css
			.slice( bannerMatch.length )
			.replace( /\/\*[\s\S]*?\*\//g, '' )
			.replace( /\s*([{}:;,>])\s*/g, '$1' )
			.replace( /;\}/g, '}' )
			.replace( /\s+/g, ' ' )
			.trim()
	);
};

mkdirSync( outFonts, { recursive: true } );
writeFileSync( join( outDir, 'all.css' ), out );
writeFileSync( join( outDir, 'all.min.css' ), minify( out ) + '\n' );

/**
 * Every codepoint the built stylesheet can ask for.
 *
 * The solid and regular faces are subset to exactly this set, which keeps the
 * fonts and the stylesheet in lockstep: an icon whose CSS rule survived will
 * always have a glyph, and one that did not was already unreachable.
 */
const codepoints = [ ...new Set( [ ...out.matchAll( /--fa(?:--fa)?: "\\([0-9a-f]+)"/g ) ].map( ( m ) => m[ 1 ] ) ) ];

// Brands is shipped whole: which networks a site links to is unknowable, and
// a missing brand glyph is a visible hole in someone's header.
copyFileSync( join( source, 'webfonts', 'fa-brands-400.woff2' ), join( outFonts, 'fa-brands-400.woff2' ) );
copyFileSync( join( source, 'webfonts', 'fa-v4compatibility.woff2' ), join( outFonts, 'fa-v4compatibility.woff2' ) );

const unicodes = codepoints.map( ( c ) => 'U+' + c.toUpperCase() ).join( ',' );

for ( const font of [ 'fa-regular-400.woff2', 'fa-solid-900.woff2' ] ) {
	const from = join( source, 'webfonts', font );
	const to = join( outFonts, font );

	const result = spawnSync(
		'python3',
		[
			'-m', 'fontTools.subset', from,
			'--unicodes=' + unicodes,
			'--flavor=woff2',
			'--layout-features=*',
			'--no-hinting',
			'--desubroutinize',
			'--output-file=' + to
		],
		{ encoding: 'utf8' }
	);

	if ( result.status !== 0 ) {
		console.error( `Could not subset ${ font }. Install fonttools (pip install fonttools brotli) or ship the full file.` );
		console.error( result.stderr || result.stdout );
		process.exit( 1 );
	}

	const before = readFileSync( from ).length;
	const after = readFileSync( to ).length;

	console.log(
		`${ font.padEnd( 24 ) } ${ ( before / 1024 ).toFixed( 1 ).padStart( 7 ) } KB -> ${ ( after / 1024 ).toFixed( 1 ).padStart( 7 ) } KB`
	);
}

copyFileSync( join( source, 'LICENSE.txt' ), join( outDir, 'LICENSE.txt' ) );

const kb = ( file ) => ( readFileSync( file ).length / 1024 ).toFixed( 1 ) + ' KB';

console.log( `Kept ${ keep.size } solid/regular icons and ${ brands.icons.size } brand icons.` );
console.log( `all.css     ${ kb( join( outDir, 'all.css' ) ) }` );
console.log( `all.min.css ${ kb( join( outDir, 'all.min.css' ) ) }` );
