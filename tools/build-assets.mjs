/**
 * Minifies the theme's stylesheets and script.
 *
 * Philosophy used to ship both minified and unminified copies of every asset
 * and then enqueue the unminified ones, so visitors downloaded 266 KB of
 * JavaScript and 160 KB of CSS that had already been minified next door. The
 * theme now enqueues the .min files and falls back to the readable sources when
 * SCRIPT_DEBUG is on; this script keeps the two in step.
 *
 * Usage:  node tools/build-assets.mjs
 *
 * @package Philosophy
 */

import { readFileSync, writeFileSync } from 'node:fs';
import { join, dirname, resolve, basename } from 'node:path';
import { fileURLToPath } from 'node:url';

const here = dirname( fileURLToPath( import.meta.url ) );
const themeRoot = resolve( here, '..' );

/**
 * Minifies CSS, keeping any leading /*! banner.
 *
 * @param {string} css Stylesheet source.
 * @return {string} Minified stylesheet.
 */
const minifyCss = ( css ) => {
	const banner = css.match( /^\/\*![\s\S]*?\*\/\n/ )?.[ 0 ] ?? '';

	return (
		banner +
		css
			.slice( banner.length )
			.replace( /\/\*[\s\S]*?\*\//g, '' )
			.replace( /\s*([{}:;,>~])\s*/g, '$1' )
			.replace( /;\}/g, '}' )
			.replace( /\s+/g, ' ' )
			.replace( /\( /g, '(' )
			.replace( / \)/g, ')' )
			.trim() + '\n'
	);
};

/**
 * Minifies JavaScript conservatively: comments and indentation only.
 *
 * Deliberately does not rename anything or drop line breaks inside statements,
 * so the output stays debuggable and the transform stays obviously correct.
 *
 * @param {string} js Script source.
 * @return {string} Minified script.
 */
const minifyJs = ( js ) => {
	const out = [];
	let i = 0;
	let atLineStart = true;

	while ( i < js.length ) {
		const two = js.slice( i, i + 2 );

		// String and template literals pass through untouched.
		if ( "'" === js[ i ] || '"' === js[ i ] || '`' === js[ i ] ) {
			const quote = js[ i ];
			let end = i + 1;

			while ( end < js.length ) {
				if ( '\\' === js[ end ] ) {
					end += 2;
					continue;
				}

				if ( js[ end ] === quote ) {
					break;
				}

				end += 1;
			}

			out.push( js.slice( i, end + 1 ) );
			i = end + 1;
			atLineStart = false;
			continue;
		}

		if ( '//' === two ) {
			i = js.indexOf( '\n', i );

			if ( -1 === i ) {
				break;
			}

			continue;
		}

		if ( '/*' === two ) {
			const end = js.indexOf( '*/', i + 2 );
			i = -1 === end ? js.length : end + 2;
			continue;
		}

		// A regular expression literal: only valid where a value may start.
		if ( '/' === js[ i ] ) {
			const previous = out.join( '' ).trimEnd().slice( -1 );

			if ( previous && ! '(,=:[!&|?{};+-*%~^<>'.includes( previous ) ) {
				out.push( js[ i ] );
				i += 1;
				atLineStart = false;
				continue;
			}

			let end = i + 1;
			let inClass = false;

			while ( end < js.length ) {
				if ( '\\' === js[ end ] ) {
					end += 2;
					continue;
				}

				if ( '[' === js[ end ] ) {
					inClass = true;
				} else if ( ']' === js[ end ] ) {
					inClass = false;
				} else if ( '/' === js[ end ] && ! inClass ) {
					break;
				}

				end += 1;
			}

			while ( /[a-z]/.test( js[ end + 1 ] ?? '' ) ) {
				end += 1;
			}

			out.push( js.slice( i, end + 1 ) );
			i = end + 1;
			atLineStart = false;
			continue;
		}

		if ( '\n' === js[ i ] ) {
			if ( out.length && '\n' !== out[ out.length - 1 ] ) {
				out.push( '\n' );
			}

			atLineStart = true;
			i += 1;
			continue;
		}

		if ( atLineStart && ( ' ' === js[ i ] || '\t' === js[ i ] ) ) {
			i += 1;
			continue;
		}

		out.push( js[ i ] );
		atLineStart = false;
		i += 1;
	}

	return out.join( '' ).replace( /\n{2,}/g, '\n' ).trim() + '\n';
};

const targets = [
	{ from: 'assets/css/base.css', to: 'assets/css/base.min.css', minify: minifyCss },
	{ from: 'assets/css/vendor.css', to: 'assets/css/vendor.min.css', minify: minifyCss },
	{ from: 'assets/css/main.css', to: 'assets/css/main.min.css', minify: minifyCss },
	{ from: 'assets/js/philosophy.js', to: 'assets/js/philosophy.min.js', minify: minifyJs }
];

for ( const target of targets ) {
	const source = readFileSync( join( themeRoot, target.from ), 'utf8' );
	const output = target.minify( source );

	writeFileSync( join( themeRoot, target.to ), output );

	const saved = ( ( 1 - output.length / source.length ) * 100 ).toFixed( 0 );

	console.log(
		`${ basename( target.to ).padEnd( 22 ) } ${ ( output.length / 1024 ).toFixed( 1 ).padStart( 7 ) } KB  (-${ saved }%)`
	);
}
