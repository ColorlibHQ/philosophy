/**
 * Customizer control behaviour for Philosophy.
 *
 * Drives the repeater rows and the rich-text control that replaced Epsilon's.
 * Written against the DOM directly: the Customizer pane loads jQuery for core's
 * own controls, but nothing here needs it.
 *
 * @package Philosophy
 * @since   1.2.0
 */
( function () {
	'use strict';

	/**
	 * Fires the events the Customizer listens to so a change is registered.
	 *
	 * @param {HTMLElement} el Field whose value changed.
	 */
	var notify = function ( el ) {
		el.dispatchEvent( new Event( 'input', { bubbles: true } ) );
		el.dispatchEvent( new Event( 'change', { bubbles: true } ) );
	};

	/**
	 * Serialises a repeater's rows back into its hidden input.
	 *
	 * @param {HTMLElement} wrap Repeater wrapper.
	 */
	var syncRepeater = function ( wrap ) {
		var store = wrap.querySelector( '.philosophy-repeater__value' );
		var rows = [];

		if ( ! store ) {
			return;
		}

		wrap.querySelectorAll( '.philosophy-repeater__row' ).forEach( function ( row ) {
			var data = {};

			row.querySelectorAll( '.philosophy-repeater__field' ).forEach( function ( field ) {
				var input = field.querySelector( '.philosophy-repeater__input' );

				if ( input ) {
					data[ field.getAttribute( 'data-field' ) ] = input.value;
				}
			} );

			rows.push( data );
		} );

		store.value = JSON.stringify( rows );
		notify( store );
	};

	/**
	 * Keeps a row's collapsed heading in step with its title field.
	 *
	 * @param {HTMLElement} wrap Repeater wrapper.
	 * @param {HTMLElement} row  Row element.
	 */
	var syncRowTitle = function ( wrap, row ) {
		var titleField = wrap.getAttribute( 'data-title-field' );
		var heading = row.querySelector( '.philosophy-repeater__row-title' );
		var field;
		var input;

		if ( ! titleField || ! heading ) {
			return;
		}

		field = row.querySelector( '.philosophy-repeater__field[data-field="' + titleField + '"]' );
		input = field ? field.querySelector( '.philosophy-repeater__input' ) : null;

		if ( input ) {
			heading.textContent = input.value || wrap.getAttribute( 'data-row-label' ) || '';
		}
	};

	/**
	 * Wires one repeater control.
	 *
	 * @param {HTMLElement} wrap Repeater wrapper.
	 */
	var initRepeater = function ( wrap ) {
		var list = wrap.querySelector( '.philosophy-repeater__rows' );
		var add = wrap.querySelector( '.philosophy-repeater__add' );
		var template = wrap.querySelector( '.philosophy-repeater__template' );

		if ( ! list || wrap.dataset.philosophyReady ) {
			return;
		}

		wrap.dataset.philosophyReady = '1';

		wrap.addEventListener( 'input', function ( event ) {
			var row;

			if ( ! event.target.classList.contains( 'philosophy-repeater__input' ) ) {
				return;
			}

			row = event.target.closest( '.philosophy-repeater__row' );

			if ( row ) {
				syncRowTitle( wrap, row );
			}

			syncRepeater( wrap );
		} );

		wrap.addEventListener( 'click', function ( event ) {
			var toggle = event.target.closest( '.philosophy-repeater__toggle' );
			var remove = event.target.closest( '.philosophy-repeater__remove' );
			var row;
			var body;

			if ( toggle ) {
				event.preventDefault();
				row = toggle.closest( '.philosophy-repeater__row' );
				body = row ? row.querySelector( '.philosophy-repeater__row-body' ) : null;

				if ( body ) {
					body.hidden = ! body.hidden;
					toggle.setAttribute( 'aria-expanded', body.hidden ? 'false' : 'true' );
				}

				return;
			}

			if ( remove ) {
				event.preventDefault();
				row = remove.closest( '.philosophy-repeater__row' );

				if ( row ) {
					row.parentNode.removeChild( row );
					syncRepeater( wrap );
				}
			}
		} );

		if ( add && template ) {
			add.addEventListener( 'click', function ( event ) {
				var holder = document.createElement( 'div' );
				var row;

				event.preventDefault();

				holder.innerHTML = template.innerHTML.replace( /__i__/g, String( list.children.length ) );
				row = holder.querySelector( '.philosophy-repeater__row' );

				if ( ! row ) {
					return;
				}

				list.appendChild( row );

				// A freshly added row opens straight away, ready to type into.
				var body = row.querySelector( '.philosophy-repeater__row-body' );
				var toggle = row.querySelector( '.philosophy-repeater__toggle' );

				if ( body ) {
					body.hidden = false;
				}

				if ( toggle ) {
					toggle.setAttribute( 'aria-expanded', 'true' );
				}

				syncRepeater( wrap );

				var first = row.querySelector( '.philosophy-repeater__input' );

				if ( first ) {
					first.focus();
				}
			} );
		}
	};

	/**
	 * Turns a rich-text control's textarea into a TinyMCE instance.
	 *
	 * Falls back to the plain textarea when the editor is unavailable, which is
	 * exactly what the control renders on its own.
	 *
	 * @param {HTMLElement} wrap Editor wrapper.
	 */
	var initEditor = function ( wrap ) {
		var id = wrap.getAttribute( 'data-editor-id' );
		var textarea = wrap.querySelector( '.philosophy-text-editor__field' );

		if ( ! id || ! textarea || wrap.dataset.philosophyReady ) {
			return;
		}

		if ( ! window.wp || ! window.wp.editor || ! window.wp.editor.initialize ) {
			return;
		}

		wrap.dataset.philosophyReady = '1';

		window.wp.editor.initialize( id, {
			tinymce: {
				wpautop: true,
				toolbar1: 'bold,italic,bullist,numlist,link,unlink,undo,redo',
				setup: function ( editor ) {
					editor.on( 'change keyup NodeChange SetContent', function () {
						textarea.value = editor.getContent();
						notify( textarea );
					} );
				}
			},
			quicktags: true,
			mediaButtons: false
		} );

		// The Text tab writes to the textarea directly; mirror that back out.
		textarea.addEventListener( 'input', function () {
			notify( textarea );
		} );
	};

	/**
	 * Scans the pane for controls that still need wiring.
	 */
	var scan = function () {
		document.querySelectorAll( '.philosophy-repeater' ).forEach( initRepeater );
		document.querySelectorAll( '.philosophy-text-editor' ).forEach( initEditor );
	};

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', scan );
	} else {
		scan();
	}

	// Sections render their controls lazily, so re-scan when one is expanded.
	if ( window.wp && window.wp.customize ) {
		window.wp.customize.bind( 'ready', function () {
			scan();

			window.wp.customize.section.each( function ( section ) {
				section.expanded.bind( function ( expanded ) {
					if ( expanded ) {
						window.setTimeout( scan, 0 );
					}
				} );
			} );
		} );
	}
}() );
