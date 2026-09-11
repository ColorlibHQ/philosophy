/**
 * Customizer pane behaviour.
 *
 * Points the preview at the page whose options are open, and hides the options
 * that only apply when a toggle is on.
 *
 * Rewritten without jQuery in 1.2.0. The selectors it used before then pointed
 * at element ids the Epsilon controls no longer produced, so none of the
 * show/hide behaviour actually ran.
 *
 * @package Philosophy
 * @since   1.0
 */
( function ( api ) {
	'use strict';

	if ( ! api ) {
		return;
	}

	var data = window.customizerdata || {};

	/**
	 * Returns the home URL with exactly one trailing slash.
	 *
	 * @return {string} Home URL.
	 */
	var home = function () {
		var url = ( api.settings && api.settings.url && api.settings.url.home ) || data.home || '/';

		return url.replace( /\/+$/, '' ) + '/';
	};

	/**
	 * Sends the preview to a URL while a section is open, and home again when
	 * it is closed.
	 *
	 * @param {string}   sectionId Section id.
	 * @param {Function} resolve   Returns the URL to preview, or a falsy value.
	 */
	var previewSection = function ( sectionId, resolve ) {
		api.section( sectionId, function ( section ) {
			section.expanded.bind( function ( isExpanded ) {
				var url = isExpanded ? resolve() : home();

				if ( url ) {
					api.previewer.previewUrl.set( url );
				}
			} );
		} );
	};

	previewSection( 'philosophy_fof_section', function () {
		// Any address that cannot resolve will do; this one names itself.
		return home() + '?philosophy-preview-404=1';
	} );

	previewSection( 'philosophy_about_section', function () {
		return data.about_page ? home() + data.about_page + '/' : home();
	} );

	previewSection( 'philosophy_contact_section', function () {
		return data.contact_page ? home() + data.contact_page + '/' : home();
	} );

	previewSection( 'philosophy_blog_section', function () {
		return data.blog_page || home();
	} );

	/**
	 * Shows or hides controls that depend on a toggle being on.
	 *
	 * @param {string}   settingId  The toggle's setting id.
	 * @param {string[]} dependents Setting ids that only apply when it is on.
	 */
	var dependsOn = function ( settingId, dependents ) {
		api( settingId, function ( setting ) {
			var apply = function ( value ) {
				dependents.forEach( function ( id ) {
					api.control( id, function ( control ) {
						control.container.hidden = ! value;
					} );
				} );
			};

			apply( setting.get() );
			setting.bind( apply );
		} );
	};

	dependsOn( 'philosophy_preloader_toggle', [
		'philosophy_preloader_bg_color',
		'philosophy_preloader_color'
	] );

	dependsOn( 'philosophy_backtotop_btn', [
		'philosophy_backtotop_btn_bg_color',
		'philosophy_backtotop_btn_hover_bg_color'
	] );

	dependsOn( 'philosophy_hfblog_toggle', [ 'philosophy_featured_cat' ] );

	dependsOn( 'philosophy_footer_widget_toggle', [
		'philosophy_footer_widget_bdcolor',
		'philosophy_footer_widget_textcolor',
		'philosophy_footer_widget_titlecolor',
		'philosophy_footer_widget_anchorcolor',
		'philosophy_footer_widget_anchorhovcolor'
	] );

	// The custom shortcode field only matters when no Contact Form 7 form is
	// selected.
	api( 'philosophy_contact_formshortcode', function ( setting ) {
		var apply = function ( value ) {
			api.control( 'philosophy_contact_custom_formshortcode', function ( control ) {
				control.container.hidden = 'cs' !== value;
			} );
		};

		apply( setting.get() );
		setting.bind( apply );
	} );
}( window.wp && window.wp.customize ) );
