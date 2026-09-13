/**
 * ===================================================================
 *  Philosophy - theme JavaScript
 *
 *  No jQuery, no Modernizr, no plugin bundle. Everything below is one
 *  init function per feature, each of which returns early when the
 *  markup it drives is not on the page.
 *
 *  Anything a component needs in order to *function* (the masonry
 *  positioning, the reveal starting state) is applied from here rather
 *  than from a stylesheet, so a stale or replaced style.css cannot
 *  leave the page unusable.
 * ------------------------------------------------------------------- */
( function () {
	'use strict';

	var settings = window.philosophySettings || {};
	var i18n = settings.i18n || {};
	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/**
	 * Runs a callback on the next animation frame, at most once per frame.
	 *
	 * @param {Function} fn Callback.
	 * @return {Function} Throttled callback.
	 */
	var onFrame = function ( fn ) {
		var queued = false;

		return function () {
			if ( queued ) {
				return;
			}

			queued = true;

			window.requestAnimationFrame( function () {
				queued = false;
				fn();
			} );
		};
	};

	/**
	 * Preloader.
	 *
	 * The markup is only printed when the option is on, so the absence of
	 * #preloader is the "disabled" case and needs no separate check.
	 * ------------------------------------------------------------------- */
	var initPreloader = function () {
		var preloader = document.getElementById( 'preloader' );
		var loader = document.getElementById( 'loader' );
		var root = document.documentElement;

		if ( ! preloader ) {
			root.classList.add( 'cl-loaded' );
			return;
		}

		var reveal = function () {
			root.classList.remove( 'cl-preload' );
			root.classList.add( 'cl-loaded' );

			if ( loader ) {
				loader.classList.add( 'is-hidden' );
			}

			preloader.classList.add( 'is-hidden' );

			// Remove it outright once the fade has run so it can never trap
			// clicks on a slow connection.
			window.setTimeout( function () {
				if ( preloader.parentNode ) {
					preloader.parentNode.removeChild( preloader );
				}
			}, reduceMotion ? 0 : 800 );
		};

		if ( 'complete' === document.readyState ) {
			reveal();
		} else {
			window.addEventListener( 'load', reveal );
		}

		// A failed asset must never leave the overlay up for good.
		window.setTimeout( reveal, 8000 );
	};

	/**
	 * Header search overlay.
	 * ------------------------------------------------------------------- */
	var initSearch = function () {
		var trigger = document.querySelector( '.header__search-trigger' );
		var wrap = document.querySelector( '.header__search' );

		if ( ! trigger || ! wrap ) {
			return;
		}

		var field = wrap.querySelector( '.search-field' );
		var close = wrap.querySelector( '.header__overlay-close' );
		var body = document.body;

		var open = function () {
			body.classList.add( 'search-is-visible' );
			trigger.setAttribute( 'aria-expanded', 'true' );

			if ( field ) {
				window.setTimeout( function () {
					field.focus();
				}, 100 );
			}
		};

		var hide = function ( refocus ) {
			if ( ! body.classList.contains( 'search-is-visible' ) ) {
				return;
			}

			body.classList.remove( 'search-is-visible' );
			trigger.setAttribute( 'aria-expanded', 'false' );

			if ( field ) {
				field.blur();
			}

			if ( refocus ) {
				trigger.focus();
			}
		};

		trigger.setAttribute( 'aria-expanded', 'false' );

		trigger.addEventListener( 'click', function ( event ) {
			event.preventDefault();
			event.stopPropagation();
			open();
		} );

		if ( close ) {
			close.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				event.stopPropagation();
				hide( true );
			} );
		}

		// Clicking the backdrop closes; clicking the form itself does not.
		wrap.addEventListener( 'click', function ( event ) {
			if ( ! event.target.closest( '.header__search-form' ) ) {
				hide( true );
			}
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key ) {
				hide( true );
			}
		} );
	};

	/**
	 * Mobile navigation and its sub-menus.
	 * ------------------------------------------------------------------- */
	var initMobileMenu = function () {
		var toggle = document.querySelector( '.header__toggle-menu' );
		var wrap = document.querySelector( '.header__nav-wrap' );

		if ( ! toggle || ! wrap ) {
			return;
		}

		var close = wrap.querySelector( '.header__overlay-close' );
		var body = document.body;

		var open = function () {
			body.classList.add( 'nav-wrap-is-visible' );
			toggle.setAttribute( 'aria-expanded', 'true' );
			toggle.setAttribute( 'aria-label', i18n.closeMenu || 'Close the menu' );

			var first = wrap.querySelector( 'a' );

			if ( first ) {
				first.focus();
			}
		};

		var hide = function ( refocus ) {
			if ( ! body.classList.contains( 'nav-wrap-is-visible' ) ) {
				return;
			}

			body.classList.remove( 'nav-wrap-is-visible' );
			toggle.setAttribute( 'aria-expanded', 'false' );
			toggle.setAttribute( 'aria-label', i18n.openMenu || 'Open the menu' );

			if ( refocus ) {
				toggle.focus();
			}
		};

		toggle.setAttribute( 'aria-expanded', 'false' );
		toggle.setAttribute( 'aria-controls', 'philosophy-primary-nav' );
		wrap.setAttribute( 'id', wrap.id || 'philosophy-primary-nav' );

		toggle.addEventListener( 'click', function ( event ) {
			event.preventDefault();
			event.stopPropagation();

			if ( body.classList.contains( 'nav-wrap-is-visible' ) ) {
				hide( true );
			} else {
				open();
			}
		} );

		if ( close ) {
			close.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				event.stopPropagation();
				hide( true );
			} );
		}

		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key ) {
				hide( true );
			}
		} );

		// Keep focus inside the overlay while it is open.
		wrap.addEventListener( 'keydown', function ( event ) {
			if ( 'Tab' !== event.key || ! body.classList.contains( 'nav-wrap-is-visible' ) ) {
				return;
			}

			var focusable = wrap.querySelectorAll( 'a[href], button:not([disabled]), input, [tabindex]:not([tabindex="-1"])' );

			if ( ! focusable.length ) {
				return;
			}

			var first = focusable[ 0 ];
			var last = focusable[ focusable.length - 1 ];

			if ( event.shiftKey && document.activeElement === first ) {
				event.preventDefault();
				last.focus();
			} else if ( ! event.shiftKey && document.activeElement === last ) {
				event.preventDefault();
				first.focus();
			}
		} );

		initSubMenus( wrap );
	};

	/**
	 * Expandable sub-menus inside the mobile navigation.
	 *
	 * The parent link keeps working on desktop; only the overlay swaps it for
	 * a disclosure. A dedicated button carries the toggle so the link itself
	 * stays reachable from the keyboard.
	 *
	 * @param {HTMLElement} wrap Navigation wrapper.
	 */
	var initSubMenus = function ( wrap ) {
		var parents = wrap.querySelectorAll( '.header__nav .has-children, .header__nav .menu-item-has-children' );

		if ( ! parents.length ) {
			return;
		}

		var overlayIsOpen = function () {
			var close = wrap.querySelector( '.close-mobile-menu' );

			return !! ( close && close.offsetParent !== null );
		};

		Array.prototype.forEach.call( parents, function ( parent ) {
			var link = parent.querySelector( ':scope > a' );
			var submenu = parent.querySelector( ':scope > ul' );

			if ( ! link || ! submenu ) {
				return;
			}

			link.addEventListener( 'click', function ( event ) {
				if ( ! overlayIsOpen() ) {
					return;
				}

				event.preventDefault();

				var isOpen = link.classList.contains( 'sub-menu-is-open' );

				// Only one branch stays open at a time.
				Array.prototype.forEach.call( parents, function ( other ) {
					if ( other === parent ) {
						return;
					}

					var otherLink = other.querySelector( ':scope > a' );
					var otherMenu = other.querySelector( ':scope > ul' );

					if ( otherLink ) {
						otherLink.classList.remove( 'sub-menu-is-open' );
						otherLink.setAttribute( 'aria-expanded', 'false' );
					}

					if ( otherMenu ) {
						otherMenu.style.display = '';
					}
				} );

				link.classList.toggle( 'sub-menu-is-open', ! isOpen );
				link.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
				submenu.style.display = isOpen ? '' : 'block';
			} );
		} );
	};


	/**
	 * Reserve the right amount of room for the masthead.
	 *
	 * The header is positioned absolutely over the featured area, and the
	 * stylesheet reserves a fixed 222px for it. That number was measured against
	 * one particular masthead: give the site a tagline, or a menu long enough to
	 * wrap, and the header grows past it and the featured panels paint over the
	 * navigation. Measuring it here keeps the two in step whatever the header
	 * ends up containing.
	 *
	 * The CSS value stays as the fallback, so a page whose script does not run
	 * is laid out exactly as before.
	 * ------------------------------------------------------------------- */
	var initPageHeader = function () {
		var pageheader = document.querySelector( '.s-pageheader--home' );
		var header = document.querySelector( '.header' );

		if ( ! pageheader || ! header ) {
			return;
		}

		var apply = onFrame( function () {
			// Only while the header is actually lifted out of the flow; the
			// mobile layout puts it back and needs no reservation.
			if ( 'absolute' !== window.getComputedStyle( header ).position ) {
				pageheader.style.paddingTop = '';
				return;
			}

			var rect = header.getBoundingClientRect();
			var top = rect.top + window.pageYOffset;
			var needed = Math.ceil( top + rect.height );

			// Never reserve less than the stylesheet already does.
			pageheader.style.paddingTop = '';

			var css = parseFloat( window.getComputedStyle( pageheader ).paddingTop ) || 0;

			if ( needed > css ) {
				pageheader.style.paddingTop = needed + 'px';
			}
		} );

		apply();
		window.addEventListener( 'resize', apply );
		window.addEventListener( 'load', apply );

		if ( document.fonts && document.fonts.ready ) {
			document.fonts.ready.then( apply );
		}

		if ( window.ResizeObserver ) {
			new window.ResizeObserver( apply ).observe( header );
		}
	};

	/**
	 * Masonry layout for the blog grid.
	 *
	 * Replaces Masonry + imagesLoaded. Column width comes from the stylesheet,
	 * which is what makes the layout responsive; everything positional is set
	 * here.
	 * ------------------------------------------------------------------- */
	var initMasonry = function () {
		var grids = document.querySelectorAll( '.masonry' );

		if ( ! grids.length ) {
			return;
		}

		Array.prototype.forEach.call( grids, function ( grid ) {
			var bricks = grid.querySelectorAll( '.masonry__brick' );

			if ( ! bricks.length ) {
				return;
			}

			var layout = function () {
				var gridWidth = grid.clientWidth;

				if ( ! gridWidth ) {
					return;
				}

				// Measure a brick at its natural, un-positioned width.
				grid.style.position = '';
				grid.style.height = '';

				Array.prototype.forEach.call( bricks, function ( brick ) {
					brick.style.position = '';
					brick.style.left = '';
					brick.style.top = '';
					brick.style.width = '';
				} );

				var brickWidth = bricks[ 0 ].getBoundingClientRect().width;

				if ( ! brickWidth ) {
					return;
				}

				var columns = Math.max( 1, Math.round( gridWidth / brickWidth ) );

				// One column is just the normal document flow; leave it alone so
				// the stacked mobile layout needs no JavaScript at all.
				if ( 1 === columns ) {
					return;
				}

				var heights = new Array( columns ).fill( 0 );

				grid.style.position = 'relative';

				Array.prototype.forEach.call( bricks, function ( brick ) {
					var shortest = heights.indexOf( Math.min.apply( null, heights ) );

					brick.style.position = 'absolute';
					brick.style.width = brickWidth + 'px';
					brick.style.left = ( shortest * brickWidth ) + 'px';
					brick.style.top = heights[ shortest ] + 'px';

					heights[ shortest ] += brick.getBoundingClientRect().height;
				} );

				grid.style.height = Math.max.apply( null, heights ) + 'px';
			};

			var relayout = onFrame( layout );

			layout();

			// Re-run as images arrive: an image without width and height
			// attributes changes its brick's height the moment it decodes.
			Array.prototype.forEach.call( grid.querySelectorAll( 'img' ), function ( img ) {
				if ( img.complete ) {
					return;
				}

				img.addEventListener( 'load', relayout );
				img.addEventListener( 'error', relayout );
			} );

			window.addEventListener( 'load', relayout );
			window.addEventListener( 'resize', relayout );

			if ( window.ResizeObserver ) {
				new window.ResizeObserver( relayout ).observe( grid );
			}

			// Embeds and late web fonts both resize bricks after first paint.
			if ( document.fonts && document.fonts.ready ) {
				document.fonts.ready.then( relayout );
			}
		} );
	};

	/**
	 * Smooth scrolling for in-page links.
	 * ------------------------------------------------------------------- */
	var initSmoothScroll = function () {
		var links = document.querySelectorAll( '.smoothscroll' );

		if ( ! links.length ) {
			return;
		}

		Array.prototype.forEach.call( links, function ( link ) {
			link.addEventListener( 'click', function ( event ) {
				var hash = link.hash;

				if ( ! hash ) {
					return;
				}

				var target = document.getElementById( hash.slice( 1 ) );

				if ( ! target ) {
					return;
				}

				event.preventDefault();

				target.scrollIntoView( {
					behavior: reduceMotion ? 'auto' : 'smooth',
					block: 'start'
				} );

				// Move the keyboard caret too, not just the viewport.
				target.setAttribute( 'tabindex', '-1' );
				target.focus( { preventScroll: true } );

				if ( window.history && window.history.replaceState ) {
					window.history.replaceState( null, '', hash );
				}
			} );
		} );
	};

	/**
	 * Back-to-top button.
	 * ------------------------------------------------------------------- */
	var initBackToTop = function () {
		var button = document.querySelector( '.go-top' );

		if ( ! button ) {
			return;
		}

		var threshold = 500;

		var update = onFrame( function () {
			button.classList.toggle( 'link-is-visible', window.pageYOffset >= threshold );
		} );

		update();
		window.addEventListener( 'scroll', update, { passive: true } );
	};

	/**
	 * Scroll reveal.
	 *
	 * Replaces AOS. The data-aos attributes stay in the markup so a child theme
	 * or pasted content keeps animating.
	 * ------------------------------------------------------------------- */
	var initReveal = function () {
		var items = document.querySelectorAll( '[data-aos]' );

		if ( ! items.length ) {
			return;
		}

		// Reduced motion, no IntersectionObserver, or a touch-sized screen: show
		// everything immediately rather than risk content that never appears.
		if ( reduceMotion || ! window.IntersectionObserver || window.innerWidth < 768 ) {
			Array.prototype.forEach.call( items, function ( item ) {
				item.classList.add( 'aos-init', 'aos-animate' );
			} );

			return;
		}

		var observer = new window.IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( ! entry.isIntersecting ) {
					return;
				}

				entry.target.classList.add( 'aos-animate' );
				observer.unobserve( entry.target );
			} );
		}, {
			rootMargin: '0px 0px -10% 0px',
			threshold: 0.05
		} );

		Array.prototype.forEach.call( items, function ( item ) {
			item.classList.add( 'aos-init' );
			observer.observe( item );
		} );
	};

	/**
	 * Google map on the Contact page template.
	 *
	 * The Maps script is only fetched when the page actually has a map on it and
	 * an API key has been saved. Before 1.2.0 it was requested on every single
	 * page view, with an empty key.
	 * ------------------------------------------------------------------- */
	var initMap = function () {
		var wrap = document.getElementById( 'map-wrap' );

		if ( ! wrap || ! settings.mapApiKey ) {
			return;
		}

		var container = document.getElementById( 'map-container' );

		if ( ! container ) {
			return;
		}

		var render = function () {
			if ( ! window.google || ! window.google.maps ) {
				return;
			}

			var position = {
				lat: parseFloat( wrap.getAttribute( 'data-lat' ) ) || 0,
				lng: parseFloat( wrap.getAttribute( 'data-long' ) ) || 0
			};

			var map = new window.google.maps.Map( container, {
				center: position,
				zoom: 14,
				panControl: false,
				zoomControl: false,
				mapTypeControl: false,
				streetViewControl: false,
				scrollwheel: false,
				styles: [
					{ elementType: 'labels', stylers: [ { saturation: -30 } ] },
					{ featureType: 'poi', elementType: 'labels', stylers: [ { visibility: 'off' } ] },
					{ featureType: 'road', elementType: 'labels.icon', stylers: [ { visibility: 'off' } ] }
				]
			} );

			new window.google.maps.Marker( {
				position: position,
				map: map,
				icon: wrap.getAttribute( 'data-marker' ) || null
			} );

			var zoomIn = document.getElementById( 'map-zoom-in' );
			var zoomOut = document.getElementById( 'map-zoom-out' );

			if ( zoomIn && zoomOut ) {
				var controls = document.createElement( 'div' );

				controls.appendChild( zoomIn );
				controls.appendChild( zoomOut );

				zoomIn.style.display = 'block';
				zoomOut.style.display = 'block';

				zoomIn.addEventListener( 'click', function () {
					map.setZoom( map.getZoom() + 1 );
				} );

				zoomOut.addEventListener( 'click', function () {
					map.setZoom( map.getZoom() - 1 );
				} );

				map.controls[ window.google.maps.ControlPosition.TOP_RIGHT ].push( controls );
			}
		};

		if ( window.google && window.google.maps ) {
			render();
			return;
		}

		// Load the API only once the map scrolls into view.
		var load = function () {
			var script = document.createElement( 'script' );

			script.src = 'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent( settings.mapApiKey );
			script.async = true;
			script.defer = true;
			script.addEventListener( 'load', render );

			document.head.appendChild( script );
		};

		if ( window.IntersectionObserver ) {
			var observer = new window.IntersectionObserver( function ( entries ) {
				if ( entries[ 0 ].isIntersecting ) {
					observer.disconnect();
					load();
				}
			}, { rootMargin: '200px' } );

			observer.observe( wrap );
		} else {
			load();
		}
	};

	/**
	 * Dismissible alert boxes.
	 * ------------------------------------------------------------------- */
	var initAlertBoxes = function () {
		document.addEventListener( 'click', function ( event ) {
			var close = event.target.closest( '.alert-box__close' );

			if ( ! close ) {
				return;
			}

			var box = close.closest( '.alert-box' );

			if ( box ) {
				box.hidden = true;
			}
		} );
	};

	/**
	 * Boot.
	 * ------------------------------------------------------------------- */
	var init = function () {
		initPreloader();
		initPageHeader();
		initSearch();
		initMobileMenu();
		initMasonry();
		initSmoothScroll();
		initBackToTop();
		initReveal();
		initMap();
		initAlertBoxes();
	};

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );
