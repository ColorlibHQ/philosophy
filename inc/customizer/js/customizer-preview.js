/**
 * Live preview inside the Customizer iframe.
 *
 * Updates the site title and description without reloading the preview.
 *
 * @package Philosophy
 * @since   1.2.0
 */
( function ( api ) {
	'use strict';

	if ( ! api ) {
		return;
	}

	/**
	 * Writes a value into the first element matching a selector.
	 *
	 * @param {string} settingId Setting id.
	 * @param {string} selector  Target selector.
	 */
	var bindText = function ( settingId, selector ) {
		api( settingId, function ( setting ) {
			setting.bind( function ( value ) {
				var target = document.querySelector( selector );

				if ( target ) {
					target.textContent = value;
				}
			} );
		} );
	};

	bindText( 'blogname', '.header__logo h1 a, .header__logo h2 a' );
	bindText( 'blogdescription', '.header__logo span' );
}( window.wp && window.wp.customize ) );
